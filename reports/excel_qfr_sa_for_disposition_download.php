<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    /* Download the Default Excel from Directory */
$fkid 		= trim($_GET['id'],' ');
$key_id 	= trim($_GET['key_id'],' ');
$file 		= get_file_path_by_fkid($fkid);
$file_path 	= $file['file_path'];
$file_name = fn_get_file_name($fkid,$key_id);
$new_file_name 	= $file_name['file_name'];

function get_file_path_by_fkid($fkid) {
	require_once('../class/oop_tqts.php');
	$result 		= '';
	$array_fields = array('path.file_path');
	$table 	   	= 'tbl_qrf_sa_treatment details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.fkid ="'.$fkid.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = $row['file_path'];
	}
	return $file;
}
function fn_get_file_name($fkid,$key_id){
	//NOTE : fsignature get the signature of every approver according to the EMPLOYEE NUMBER
	require_once('../class/oop_tqts.php');
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('file_name');
	$table 	   		= 'tbl_qrf_sa_treatment';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$fkid.'" AND `logdel` = 0';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_assoc($result)){
		$arr_file_name = explode(' | ',$row ['file_name']);
		$return['file_name'] = $arr_file_name[$key_id];
	}else{
		$return['file_name'] = 'Special Acceptance.xlsx';
	}
	return $return;
}
//File INSIDE the DIR
$file = ''. $file_path . $fkid ."/". $key_id. '.xls'; 
$file_x = ''. $file_path . $fkid ."/". $key_id. '.xlsx';
$file_pdf = $file_path .$fkid ."/". $key_id. '.pdf';
//File OUTSIDE the DIR
$file_outside_dir = ''. $file_path . $fkid . '.xls'; 
$file_x_outside_dir = ''. $file_path . $fkid . '.xlsx';
$file_pdf_outside_dir = $file_path .$fkid . '.pdf';

//XLS
if (file_exists($file)) {
	$header ='Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$file_name= $new_file_name;
    $path =$file;
}
if (file_exists($file_outside_dir)) {
	$header ='Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$file_name= $new_file_name;
    $path =$file_outside_dir;
}
//XLSX
if(file_exists($file_x)){
	$header ='Content-type: application/vnd.ms-excel';
	$file_name= $new_file_name;
    $path =$file_x;
}
if(file_exists($file_x_outside_dir)){
	$header ='Content-type: application/vnd.ms-excel';
	$file_name= $new_file_name;
    $path =$file_x_outside_dir;
}
//PDF
if(file_exists($file_pdf)){
	$header ='Content-type: application/vnd.ms-excel';
	$file_name= $new_file_name;
    $path =$file_pdf;
}
if(file_exists($file_pdf_outside_dir)){
	$header ='Content-type: application/vnd.ms-excel';
	$file_name= $new_file_name;
    $path =$file_pdf_outside_dir;
}

header('Content-Description: File Transfer');
header($content_type);
header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($path));
ob_end_clean();
readfile($path);

?>