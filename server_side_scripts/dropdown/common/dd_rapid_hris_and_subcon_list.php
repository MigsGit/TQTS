<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* call connectio information from text file */
$db_config_rapid = '../../../db_config/config_rapid.php';
if(file_exists($db_config_rapid)){
    include($db_config_rapid);
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
$sql  = "SELECT CONCAT(`name`) as `Emp_name`,`username` FROM tbl_useraccounts WHERE `name` LIKE '%$search%' AND `logdel`=0 LIMIT 0,10";
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