<?php
$pkid 		= $_GET['pkid'];

$array_fields = array('judgement_fkfile_path','judgement_file');
$table 	   	= 'tbl_qfr_aye';
$joins 	   	= '';
$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
$sql_order 	= '';
$sql_limit 	= '';
$return 	= array();
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
if($row = mysqli_fetch_array($result)){
	$return['fkfile_path'] 				= $row['judgement_fkfile_path'];
	$return['file_path'] 				= return_file_path_by_pkid($return['fkfile_path']);
	$filename				 			= $row['judgement_file'];
	$return['ext']  					= pathinfo($return['judgement_file'], PATHINFO_EXTENSION);
	$file	 							= $return['file_path'].$pkid.'.'.$return['ext'];
}
function return_file_path_by_pkid($pkid) {
	require_once('../class/oop_tqts.php');
	$array_fields = array('	file_path');
	$table 	   	= 'tbl_file_path';
	$joins 	   	= '';
	$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		return $row['file_path'];
	} 
}

if(!file_exists($file)){
	echo '['.$file.'] file does not exist!';
	exit;
}

$image = file_get_contents('http://www.url.com/image.jpg');
file_put_contents($file, $image); //Where to save the image on your server
?>