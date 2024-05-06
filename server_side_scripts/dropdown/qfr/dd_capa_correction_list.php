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
$search 	= trim(strip_tags($_GET['q']));
$fk_capa 	= $_GET['fk_capa'];
$sql_where 	= isset($_GET['status']) ? (' AND tbl_qfr_capa_1st_monitoring.qs_status="CLOSED"') : (' AND tbl_qfr_capa_1st_monitoring.qs_status="OPEN"');
// $search = trim(strip_tags($_GET['searchTerms']));

/* Query Here  */
// $sql  = "SELECT tbl_qfr_capa_correction.pkid, tbl_qfr_capa_correction.correction_action FROM tbl_qfr_capa_correction INNER JOIN tbl_qfr_capa_1st_monitoring ON tbl_qfr_capa_1st_monitoring. `fk_capa` = tbl_qfr_capa_correction.fk_capa WHERE tbl_qfr_capa_correction.`correction_action` LIKE '%$search%' AND tbl_qfr_capa_correction.fk_capa='".$fk_capa."' AND tbl_qfr_capa_1st_monitoring.order <= 13 AND tbl_qfr_capa_correction.logdel=0 ".$sql_where." LIMIT 0,10";
$sql  = "SELECT tbl_qfr_capa_correction.pkid, tbl_qfr_capa_correction.`correction_action`, tbl_qfr_capa_1st_monitoring.qs_status FROM `tbl_qfr_capa_correction` RIGHT JOIN tbl_qfr_capa_1st_monitoring ON tbl_qfr_capa_1st_monitoring.fk_capa = tbl_qfr_capa_correction.`fk_capa` WHERE tbl_qfr_capa_1st_monitoring.fk_capa = ".$fk_capa." AND tbl_qfr_capa_correction.pkid =  tbl_qfr_capa_1st_monitoring.fk_capa_correction AND tbl_qfr_capa_1st_monitoring.order <= 13 ".$sql_where." AND tbl_qfr_capa_correction.logdel=0 AND tbl_qfr_capa_correction.`correction_action` LIKE '%$search%' AND tbl_qfr_capa_1st_monitoring.logdel=0";


$result = mysqli_query($conn,$sql);

if(!$result){
	echo 'fail query';
}

$list = array();
while($row = mysqli_fetch_assoc($result)){
	if($row['correction_action'] != ""){
		$list[] = $row;
	}	
}

/* Make sure we have a result */
if(count($list) > 0){
   foreach ($list as $key => $value) {
		$data[] = array('id' => $value['pkid'], 'text' => html_entity_decode(htmlentities($value['correction_action'])));              
   } 
} else {
   $data[] = array('id' => '0', 'text' => 'No record found');
}

/* return the result in json */
echo json_encode($data); 

?>