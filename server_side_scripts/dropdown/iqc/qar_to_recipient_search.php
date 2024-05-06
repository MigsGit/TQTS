<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* call connectio information from text file */
$db_config = '../../../db_config/config_hris.php';
if(file_exists($db_config)){
	require_once($db_config);
	
}else{
	echo 'Database config file does not exist.';
}

/* connect to database  */
$conn 		= mysqli_connect($server,$username,$password) or die("cannot connect server");
$database 	= mysqli_select_db($conn,$db_name) or die("cannot connect database");

/* Seach tags mag use $_GET or $_POST */
$_GET['q'] = 'marlope';
$search = trim(strip_tags($_GET['q']));

/* Query Here  */
$sql  = "SELECT DISTINCT `Emp_name`,`username` FROM vw_labor_identity WHERE `Emp_name` LIKE '%$search%' LIMIT 40";
$result = mysqli_query($conn,$sql);

if(!$result){
	echo 'fail query';
}

$list = array();
while($row = mysqli_fetch_assoc($result)){
	if($row['username'] != ""){
		$list[] = $row;
	}	
}

/* Make sure we have a result */
// if(count($list) > 0){
   // foreach ($list as $key => $value) {
		// $data[] = array('id' => $value['username'], 'text' => $value['Emp_name'], 'selected' => true);              
   // } 
// } else {
   // $data[] = array('id' => '0', 'text' => 'No Employee Found');
// }

$data[] = array("id"=>"marlope","text"=>"Mark Joseph Lopez","selected"=>true);
/* return the result in json */
echo json_encode($data); 

?>