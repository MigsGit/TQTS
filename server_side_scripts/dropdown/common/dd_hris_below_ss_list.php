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
$search = trim(strip_tags($_GET['q']));
// $search = trim(strip_tags($_GET['searchTerms']));

/* Query Here  */
// $sql  = "SELECT CONCAT(`firstname`,' ',`lastname`) as `Emp_name`,`username` FROM vw_EmpInfo_Rapid WHERE (`lastname` LIKE '%$search%'  OR `firstname` LIKE '%$search%') AND Position_Level < 6 LIMIT 0,10";
$sql  = "SELECT CONCAT(`firstname`,' ',`lastname`) as `Emp_name`,`username` FROM vw_EmpInfo_Rapid WHERE `lastname` LIKE '%$search%'  OR `firstname` LIKE '%$search%' LIMIT 0,10";
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
if(count($list) > 0){
   foreach ($list as $key => $value) {
		$data[] = array('id' => $value['username'], 'text' => $value['Emp_name']);              
   } 
} else {
   $data[] = array('id' => '0', 'text' => 'No Employee Found');
}

/* return the result in json */
echo json_encode($data); 

?>