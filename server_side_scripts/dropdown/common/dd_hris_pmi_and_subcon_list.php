<?php
/** PROBLEM FOUND: the query select subcon emp to  "vw_pmi_subcon_list table" then passed the empno to the 
 * rapid "tbl_useraccounts" table. However, the employee number of the not constant because some of the employee 
 * is possible to be a regular employee.
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* call connectio information from text file */
$db_config = '../../../db_config/config_systemone_views.php';
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
// $search = "";
// $search = trim(strip_tags($_GET['searchTerms']));

/* Query Here  */
$sql  = "SELECT `empno`,`empname` FROM vw_pmi_subcon_list WHERE `empname` LIKE '%$search%' LIMIT 0,10";

$result = mysqli_query($conn,$sql);

if(!$result){
	echo mysqli_error($result)."<br>";
}

$list = array();
while($row = mysqli_fetch_assoc($result)){
	$username = get_username_using_empno($row['empno']);
	if($username != ""){
		$row['username'] = $username;
		$list[] = $row;
	}
}

/* Make sure we have a result */
if(count($list) > 0){
   foreach ($list as $key => $value) {
		$data[] = array('id' => $value['username'], 'text' => $value['empname']);              
   } 
} else {
   $data[] = array('id' => '0', 'text' => 'No Employee Found');
}

/* return the result in json */
echo json_encode($data); 

function get_username_using_empno($empno){
// function get_username_using_empno($empname){
	$db_config_rapid = '../../../db_config/config_tqts.php';
	if(file_exists($db_config_rapid)){
		include($db_config_rapid);
	}else{
		echo 'Database config file does not exist.';
	}
	/* connect to database  */
	$conn 		= mysqli_connect($server,$username,$password) or die("cannot connect server");
	$database 	= mysqli_select_db($conn,'db_rapid') or die("cannot connect database");
	$sql  = "SELECT `username` FROM tbl_useraccounts WHERE `empno` = '$empno' LIMIT 0,1";
	$result = mysqli_query($conn,$sql);
	$username = '';
	if($row = mysqli_fetch_assoc($result)){
		$username = $row['username'];
	}
	return $username;
}
?>