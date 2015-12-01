<?php
//class required
require_once("TreeObject.php");

//Create a CurrencyCalculator class to handle the currency calculator app.
//The main aspect of this currency calculator is the ability to work dynamically.
//Every time a calculation is needed, the app will try to find the correct currency path, 
//from the base currency to the target currency,
//based on the existing exchange rates between currencies.
//Also there is a need of dynamic change of exchange rates
//and a dynamic ability to add new currencies and a relative exchange rate. 
//To find a currency path, the new object of calculator class will
//create a tree with the possible paths
//and then it will choose the correct path and will return back the appropriate total exchange rate 
//that the currency conversion will need to use.

class CurrencyCalculator {
	
	//all the inputs of the user are properties of class CurrencyCalculator
	public $input_value;
	public $output_value;
	public $base_currency;
	public $target_currency;
	public $currencies = array();
	public $exchange_rates = array();
	
	//array to keep the rates of a correct currency path 
	public $rates = array();
	public $total_rate;
	//The head of the currencies' tree	
	private $head;
	//test
	private $test_array = array();
	

	
	function __construct($input_value, $base_currency, $target_currency, $currencies, $exchange_rates) {
		
		$this->input_value     = $input_value;
		$this->base_currency   = $base_currency;
		$this->target_currency = $target_currency;
		$this->currencies      = $currencies;
		$this->exchange_rates  = $exchange_rates;
		$this->head = new TreeObject(); 
	}
		
	public function calculate() {
		//Method tha is used by the app to calculate the currency
		//If base and target currency are the same
		if ($this->base_currency == $this->target_currency) {
			unset($this->rates);
			$this->rates[] = 1;
			$this->calculate_total_rate();
		}
		//else if base and target currency exist in given exchange rates
		//"base2target"=>rate
		elseif ($this->find_in_rates_array($this->base_currency, $this->target_currency)){
			$this->calculate_total_rate();
		}
		//else create currency path
		else {
			$this->create_tree_of_currencies();
			$this->traverse_tree_of_currencies();
			$this->calculate_total_rate();
		}
		//Final result
		$this->output_value = $this->input_value * $this->total_rate;
	}
	

	
	private function find_in_rates_array($a_currency="", $b_currency="") {
		//Method that checks if there is given an exchange rate
		//between two currencies (a,b) or (b,a) and sets the rates array accordingly
		
		if (array_key_exists("{$a_currency}2{$b_currency}", $this->exchange_rates)) {
			$this->rates[] = $this->exchange_rates["{$a_currency}2{$b_currency}"];
			return true;
		} elseif (array_key_exists("{$b_currency}2{$a_currency}", $this->exchange_rates)) {
			$this->rates[] = 1/($this->exchange_rates["{$b_currency}2{$a_currency}"]);
			return true;
		} else {
			return false;
		}
		
	}
	
	private function create_tree_of_currencies() {
		//Method that creates the tree of possible paths of currencies.
		//Creates TreeObject objects in order parent-child relations to be created. 
		//The head of the tree, that is also a property of this class,
		//is the base currency that is put to the app by the user.
		//The currencies' tree will be created as a BFS tree
		//Every branch of the tree is created if there is an 
		//exchange rate between two curencies (leafs)
		//ex: for a,b currencies if exchange rate: a2b = x exists 
		//then (b) is a currency child of (a) and (a) will be a currency parent of (b).
		
		//Temporary editable array of currencies
		$temp_currencies = $this->currencies;
		//Array storage of currencies/children 
		//of the current breadth level of the tree
		$tree = array();
		
		//Initialise the head properties, delete the correspomding
		//currency from the array $temp_currencies and 
		//give the tree array the head object (1st level)
		$this->head->set_value($this->base_currency);
		unset($temp_currencies[$this->base_currency]);
		//test
		$this->test_array [] = $this->head->get_value()."<br/>";
		array_push($tree, $this->head);
		//While there are currencies/leafs on the same breadth level
		while (count($tree)>0) {
			//read all same level currencies/leafs
			foreach ($tree as $leaf) {
			
				foreach ($temp_currencies as $currency=>$value) {
				
					if ($this->find_in_rates_array($leaf->get_value(), $currency)) {
						
						//If there is a match of $currencies
						//a new TreeObject will be created and 
						//the parent-child relations will be set
						//and the current currency will be removed 
						//from $temp_currencies to avoid multiple checks
						unset($temp_currencies[$currency]);
						$tree_object = new TreeObject();
						$tree_object->set_value($currency);
						$tree_object->set_parent($leaf);
						$leaf->set_child($tree_object);
						//insert at the end of tree array the next breadth level
						array_push($tree, $tree_object);
						//test
						$this->test_array [] = $tree_object->get_value();
					}
				}				
			}
			//test
			$this->test_array [] = "<br/>";
			//remove the current currency/leaf from tree array
			array_shift($tree);
		}		
	}
	
	private function traverse_tree_of_currencies(TreeObject $object=null) {
		//Method that traverses the tree of currencies in a DFS way 
		//and finds the correct currency path.
		//When the correct child (target currency) is found
		//it traverses back the correct path to the head in order to
		//correctly populate the rates array.
		//useful flag to terminate the recursion
		static $found_target = false;
		if ($object == NULL) {
			//The very fist time the head should be the argument
			$object = $this->head;
			//test
			$this->test_array [] = $this->head->get_value();
		}
		//Traverses the tree seaching by child
		if ($object->has_children()) {
			foreach ($object->get_children() as $child) {
				//test
				$this->test_array [] = $child->get_value();
				if ($child->get_value() != $this->target_currency) {
					$this->traverse_tree_of_currencies($child);
					//test
					$this->test_array [] = "<br/>";
				} else {
					$found_target = true;
					//initialise rates array.
					unset($this->rates);
					//Traverses back to the head seaching by parent
					$this->find_parent_currencies($child);
					//return $child->get_value();
				}
				if ($found_target) { 
					//test
					$this->test_array [] = "ok";
					return 0; 
				}
			}
		}
	}
	
	private function find_parent_currencies(TreeObject $object=null) {
		//Traverses back the tree to the head seaching by parent
		//and correctly populates the rates array.
		if ($object->has_parents()) {
			$this->find_in_rates_array($object->get_parent()->get_value(), $object->get_value());
			$this->find_parent_currencies($object->get_parent());
		}
	}
	
	private function calculate_total_rate() {
		$this->total_rate = 1;
		foreach ($this->rates as $rate) {
			$this->total_rate *= $rate;
		} 
		$this->total_rate = round($this->total_rate, 4);
	}
	
	
	public function currency_exist() {
		//Check if the base or target currency has at least 
		//one exchange rate relationship inside the $exchange_rates_dynamic_array
		//Mainly for admin use, to check if the two input arrays are correct
		if ($this->base_currency_rate_exist() && $this->target_currency_rate_exist()) {
			return true;
		} else {
			return false;
		}
	}
	private function base_currency_rate_exist() {
		foreach ($this->exchange_rates as $key=>$value) {
			if (strstr($key, $this->base_currency)) {
				return true;
			}
		} return false;
	}
	private function target_currency_rate_exist() {
		foreach ($this->exchange_rates as $key=>$value) {
			if (strstr($key, $this->target_currency)) {
				return true;
			}
		} return false;
	}
	

	public function view_result_format() {
			
		$result  = $this->input_value;		
		$result .= " {$this->base_currency} ";
		$result .= "  &nbsp<=>&nbsp  ";
		$result .= "{$this->output_value} ";
		$result .= "{$this->target_currency} ";
		$result .= "<br/><br/>";
		$result .= "{$this->base_currency}/{$this->target_currency} ";
		$result .= "&nbsp({$this->total_rate})";
		return $result;
	}
	
	//test
	public function print_test() {
		$s="";
		//$this->rates
		//$this->test_array
		foreach($this->rates as $test) {
			$s .= $test."<br/>";
		}
		return $s;
	}
	
	
	
	
	
}

?>