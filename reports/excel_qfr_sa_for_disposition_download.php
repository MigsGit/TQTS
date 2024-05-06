<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    /* Download the Default Excel from Directory */
$fkid 		= trim($_GET['id'],' ');
$file = get_file_path_by_fkid($fkid);
$file_path = $file['file_path'];
$file_name = fn_get_file_name($fkid);
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
function fn_get_file_name($fkid){
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
		$return['file_name'] = $row ['file_name'];
	}else{
		$return['file_name'] = 'Special Acceptance.xlsx';
	}
	return $return;
}
$file = ''. $file_path . $fkid . '.xls'; 
$file_x = ''. $file_path . $fkid . '.xlsx';
$file_pdf = $file_path .$fkid . '.pdf';
if (file_exists($file)) {
    header('Content-Description: File Transfer');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.basename($new_file_name).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_end_clean();
    readfile($file);
}else if(file_exists($file_x)){
    header('Content-Description: File Transfer');
	header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="'.basename($new_file_name).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_x));
    ob_end_clean();
    readfile($file_x);
}
else if(file_exists($file_pdf)){
    header('Content-Description: File Transfer');
	header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="'.basename($new_file_name).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_pdf));
    ob_end_clean();
    readfile($file_pdf);
}else{
	//  echo 'File Not Exist';
}