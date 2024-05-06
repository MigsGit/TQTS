<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $parent_class = "../../media/PhpSpreadsheet-1.7.0/src/PhpSpreadsheet/IOFactory.php";
$parent_class = "../../media/PhpSpreadsheet-1.6.0/src/PhpSpreadsheet/IOFactory.php";
if(file_exists($parent_class)){
	include($parent_class); //call the parent class
} else{
	$parent_class = "../../../media/PhpSpreadsheet-1.6.0/src/PhpSpreadsheet/IOFactory.php";
	if(file_exists($parent_class)){
		include($parent_class); //call the parent class
	} else{
		$parent_class = "../../../../media/PhpSpreadsheet-1.6.0/src/PhpSpreadsheet/IOFactory.php";
		if(file_exists($parent_class)){
			include($parent_class); //call the parent class
		} else{
			echo 'file '.$parent_class.' does not exist!';
			exit;
		}	
	}	
}
?>