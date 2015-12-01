<?php
//Create a class of tree objects
//Every object must have at least: parents, children and value properties

class TreeObject {
	
	private $value;
	//arrays of other TreeObject objects
	private $parents = array();
	private $children = array();
		
	//methods to get the value of the TreeObject properties
	public function get_value() {
		return $this->value;
	}
	public function get_parents() {
		return $this->parents;
	}
	public function get_children() {
		return $this->children;
	}
	//get a specific child or parent
	//by defult index=0
	public function get_child($index=0) {
		return $this->children[$index];
	}
	public function get_parent($index=0) {
		return $this->parents[$index];
	}
	
	//methods to set the value of the TreeObject properties
	public function set_parent(TreeObject $object) {
		$this->parents[] = $object;
	}
	public function set_child(TreeObject $object) {
		$this->children[] = $object;
	}
	public function set_value($value) {
		$this->value = $value;
	}
	
	//methods to check if the current object has parents or children
	public function has_children() {
		if (!empty($this->get_children()))  {
			return true;
		} else {
			return false;
		}	
	}
	public function has_parents() {
		if (!empty($this->get_parents()))  {
			return true;
		} else {
			return false;
		}	
	}
	
}

?>