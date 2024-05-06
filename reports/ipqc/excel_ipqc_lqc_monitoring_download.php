<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../../class/excel_new.php');
include('../../handler/common_function.php');

$pkid 		= trim($_GET['id'],'');

$file_path_by_pkid =get_file_path_by_pkid($pkid);
$file = '../'.$file_path_by_pkid.$pkid.'.xls';
$file_x = '../'.$file_path_by_pkid.$pkid.'.xlsx';

$name_by_pkid= get_name_by_pkid($pkid);
/** As way of removing an extension from a filename is using the string functions substr and strrpos.
 *  The substr() function returns the part of string whereas strrpos() finds the position of last occurrence of substring in a string. */
$file_name = substr($name_by_pkid, 0, strrpos($name_by_pkid, '.'));
$file_name = $file_name.'.xlsx';

if(file_exists($file)){
	// Load an existing spreadsheet
	$phpExcel = PHPExcel_IOFactory::load($file);
	// Get the first sheet
	$sheet = $phpExcel ->getActiveSheet();
	// Insert one new row before row 2
    
    // Create the PHPExcel spreadsheet writer object
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");

	/* Redirect to browser (download) instead of saving the result to file */
	ob_end_clean();
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Cache-Control: max-age=0');
	// Save the spreadsheet
	$writer->save('php://output');
    exit;
}else if(file_exists($file_x)){
	// Load an existing spreadsheet
	$phpExcel = PHPExcel_IOFactory::load($file_x);
	// Get the first sheet
	$sheet = $phpExcel ->getActiveSheet();
	// Insert one new row before row 2
    
    // Create the PHPExcel spreadsheet writer object
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");

	/* Redirect to browser (download) instead of saving the result to file */
	ob_end_clean();
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Cache-Control: max-age=0');
	// Save the spreadsheet
	$writer->save('php://output');
    exit;
}else{
    echo 'file not exist';
}

function get_file_path_by_pkid($pkid){
    require_once('../../class/oop_tqts.php');
    $result = '';
    $array_fields = array('path.file_path');
	$table 	   	= 'tbl_ipqc_lqc_monitoring details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.pkid="'.$pkid.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
    $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    if($row = mysqli_fetch_array($result)){
      $file['file_path'] = $row['file_path'];
    }
    return $file['file_path'];
}

function get_name_by_pkid($pkid){
    require_once('../../class/oop_tqts.php');
    $result = '';
    $array_fields = array('monitoring_file');
	$table 	   	= 'tbl_ipqc_lqc_monitoring';
	$joins 	   	= '';
	$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
    $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    if($row = mysqli_fetch_array($result)){
      $file['monitoring_file'] = $row['monitoring_file'];
    }
    return $file['monitoring_file'];
}


?>