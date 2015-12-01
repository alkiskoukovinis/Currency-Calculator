<?php

function redirect_to($location = null) {
	if($location != null) {
		header("Location: {$location}");
		exit;
	}
}
function __autoload($class_name) {
	//no case sensitive!!!
	//$class_name = strtolower($class_name);
	$path = "../model/{$class_name}.php";
	if(file_exists($path)) {
		require_once($path);
	} else {
		die("The Class or PHP-File {$class_name}.php could not be found!");
	}
}

?>