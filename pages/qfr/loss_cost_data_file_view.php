<?php
$pkid = $_GET['id'];
$file	 	= get_file_path_by_pkid($pkid);
$file_path 	= $file['file_path'];
$extension 	= $file['extension'];
$file_name 	= $file['file_name'];

$file = $file_path . $pkid . '.' . $extension;

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=".$file_name);
@readfile($file);

function get_file_path_by_pkid($fkdetails) {
	require_once('../../class/oop_tqts.php');
	$array_fields = array('path.file_path','details.file_name');
	$table 	   	= 'tbl_loss_cost_mdetails details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.pkid="'.$fkdetails.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	echo TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = '../'.$row['file_path'];
		$file['extension'] = end(explode('.',$row['file_name']));
		$file['file_name'] = $row['file_name'];		
	}
	return $file;
}
?>