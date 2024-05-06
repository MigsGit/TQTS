<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* call connectio information from text file */
$db_config = '../../../db_config/config_tqts.php';
if(file_exists($db_config)){
	require_once($db_config);
	
}else{
	echo 'Database config file does not exist.';
}

/* connect to database  */
$conn 		= mysqli_connect($server,$username,$password) or die("cannot connect server");
$database 	= mysqli_select_db($conn,$db_name) or die("cannot connect database");

/* Seach tags mag use $_GET or $_POST */
$search = trim(strip_tags($_GET['q']));
// $search = trim(strip_tags($_GET['searchTerms']));

/* Query Here  */
$sql  = "SELECT supplier FROM tbl_qfr_qcfr_supplier_list WHERE `supplier` LIKE '%$search%' AND logdel=0 LIMIT 0,10";
$result = mysqli_query($conn,$sql);

if(!$result){
	echo 'fail query';
}

$list = array();
while($row = mysqli_fetch_assoc($result)){
	if($row['supplier'] != ""){
		$list[] = $row;
	}	
}

/* Make sure we have a result */
if(count($list) > 0){
   foreach ($list as $key => $value) {
		$data[] = array('id' => $value['supplier'], 'text' => html_entity_decode(htmlentities($value['supplier'])));              
   } 
} else {
   $data[] = array('id' => '0', 'text' => 'No record found');
}

/* return the result in json */
echo json_encode($data); 

?>