<?php 
//Load required files
//InteractiveData/mvc/controller/initialize.php
require_once("initialize.php");
?>




<?php
//Page Controller
	$output_value = "";	
	if (isset($_POST["submit"])) {
		
		$input_value = trim($_POST["input_value"]);
		$base_currency = $_POST["base_currency"];
		$target_currency = $_POST["target_currency"];
		//Check if input is numeric.
		if (is_numeric($input_value)) {		
			$currency_calculator = new CurrencyCalculator($input_value, $base_currency, $target_currency, $curencies_dynamic_array, $exchange_rates_dynamic_array);
			//Check if the base or target currency has at least 
			//one exchange rate relationship inside the $exchange_rates_dynamic_array
			//Mainly for admin use, to check if the two input arrays are correct
			if ($currency_calculator->currency_exist()) {
				$currency_calculator->calculate();
				$output_value = $currency_calculator->output_value;
				$result = $currency_calculator->view_result_format();
			} else {
				$error_messages[] = "There is no exchange rate in relation to the chosen currencies ({$curencies_dynamic_array[$base_currency]} or {$curencies_dynamic_array[$target_currency]}), please try again!";
			}			
		} else {
			$error_messages[] = "The input value that was given is not valid, please try again!";
		}
	}
?>

<?php
//Page View
include("../view/public/currency_calculator_view.php");
?>



