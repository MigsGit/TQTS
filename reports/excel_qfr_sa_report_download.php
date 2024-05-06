<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../handler/common_function.php');
$excel_class = '../class/excel_new.php';
// $excel_class = '../class/excel_php_spreadsheet.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}
/** 
 * *LIST OF FUNCTIONS*
 * !get_file_path_by_pkid
 * !get_control_number
 * !get_originator_esignature
 * !get_y_coordinate_esignature
 * !get_x_coordinate_esignature
 * !get_checker_esignature
 * !get_1_review_result
 * !get_2_review_result
 * !get_3_review_result
 * !get_4_review_result
 */
$pkid 		= trim($_GET['id'],' ');

$result_1 = get_1_review_result($pkid);
$date_1=$result_1['date'];
if($result_1['review_result'] == 'No need QAD approval'){
	$result_1= 'C44:C44';
}else if($result_1['review_result'] == 'No need YEC approval'){
	$result_1= 'C45:C45';
}else if($result_1['review_result'] == 'NEED YEC/Customer approval'){
	$result_1= 'C46:C46';
}else{
	$result_1= 'C0:C0';
}

$result_2 = get_2_review_result($pkid);
$date_2=$result_2['date'];
if($result_2['review_result'] == 'No need QAD approval'){
	$result_2= 'I44:I44';
}else if($result_2['review_result'] == 'No need YEC approval'){
	$result_2= 'I45:I45';
}else if($result_2['review_result'] == 'NEED YEC/Customer approval'){
	$result_2= 'I46:I46';
}else{
	$result_2= 'I0:I0';
}

$result_3 = get_3_review_result($pkid);
$date_3=$result_3['date'];
if($result_3['review_result'] == 'No need QAD approval'){
	$result_3= 'P44:P44';
}else if($result_3['review_result'] == 'No need YEC approval'){
	$result_3= 'P45:P45';
}else if($result_3['review_result'] == 'NEED YEC/Customer approval'){
	$result_3= 'P46:P46';
}else{
	$result_3= 'P0:P0';
}

$result_4 = get_4_review_result($pkid);
$date_4=$result_4['date'];
if($result_4['review_result'] == 'No need YEC approval'){
	$result_4= 'X44:X44';
}else if($result_4['review_result'] == 'NEED YEC/Customer approval'){
	$result_4= 'X45:X45';
}else{
	$result_4= 'X0:X0';
}

$checker_esignature 			= get_checker_esignature($pkid);
$originator_esignature 			= get_originator_esignature($pkid);
$ctrl_no						= get_control_number($pkid);
$file	 						= get_file_path_by_pkid($pkid);
$file_path 						= $file['file_path'];
$file 							= $file_path . 'e_'.$pkid . '.xls'; 
$file_x 						= $file_path . 'e_'.$pkid . '.xlsx'; 
$get_file_name 					= fn_get_file_name($pkid);
$new_file_name 					= $get_file_name['file_name'];

function get_1_review_result($pkid){
	require_once('../class/oop_tqts.php');
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('approver_remarks','date_time_approved');
	$table 	   		= 'tbl_qfr_sa_approvers_main';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `order_id` = 1 AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $review_result 	= array();
	if($row = mysqli_fetch_array($result)){
		$return['review_result'] = $row['approver_remarks'];
		$return['date'] 		 = date('Y-m-d',strtotime($row['date_time_approved']));
	}else{
		$return['review_result']='';
		$return['date'] = '';
	}
	return $return;
}
function get_2_review_result($pkid){
	require_once('../class/oop_tqts.php');
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('approver_remarks','date_time_approved');
	$table 	   		= 'tbl_qfr_sa_approvers_main';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `order_id` = 2 AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $review_result 	= array();
	if($row = mysqli_fetch_array($result)){
		$return['review_result'] = $row['approver_remarks'];
		$return['date'] 		 = date('Y-m-d',strtotime($row['date_time_approved']));
	}else{
		$return['review_result'] ='';
		$return['date'] = '';
	}
	return $return;
}
function get_3_review_result($pkid){
	require_once('../class/oop_tqts.php');
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('approver_remarks','date_time_approved');
	$table 	   		= 'tbl_qfr_sa_approvers_main';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `order_id` = 3 AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $review_result 	= array();
	if($row = mysqli_fetch_array($result)){
		$return['review_result'] = $row['approver_remarks'];
		$return['date'] 		 = date('Y-m-d',strtotime($row['date_time_approved']));
	}else{
		$return['review_result']='';
		$return['date'] = '';
	}
	return $return;
}
function get_4_review_result($pkid){
	require_once('../class/oop_tqts.php');
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('approver_remarks','date_time_approved');
	$table 	   		= 'tbl_qfr_sa_approvers_main';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `order_id` = 4 AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $review_result 	= array();
	if($row = mysqli_fetch_array($result)){
		$return['review_result'] = $row['approver_remarks'];
		$return['date'] 		 = date('Y-m-d',strtotime($row['date_time_approved']));
	}else{
		$return['review_result']='';
		$return['date'] = '';
	}
	return $return;
}
function get_file_path_by_pkid($fkdetails) {
	require_once('../class/oop_tqts.php');
	$result 		= '';
	$array_fields = array('path.file_path');
	$table 	   	= 'tbl_qfr_special_acceptance_attachment details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.fkspecial_acceptance="'.$fkdetails.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = $row['file_path'];
	}
	return $file;
}
function get_control_number($fkdetails){
	require_once('../class/oop_tqts.php');
	$result_w1 		= '';
	$array_fields = array('control_number');
	$table 	   	= 'tbl_qfr_special_acceptance';
	$joins 	   	= '';
	$sql_where 	= 'WHERE pkid="'.$fkdetails.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file_ctrl 	= array();
	$result_w1 = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result_w1)){
		$file_ctrl = $row;
	}
	$get_ctrl_no = $file_ctrl['control_number'];
	return $get_ctrl_no;
}
function get_originator_esignature($pkid){ //NOTE : fsignature originator
	require_once('../class/oop_tqts.php');
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('created_by');
	$table 	   		= 'tbl_qfr_special_acceptance';
	$joins 	   		= '';
	$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$get_esignature = '';
	while($row = mysqli_fetch_array($result)){
		$file_ctrl = $row ['created_by'];
		$get_esignature = return_esignature_sar($file_ctrl);
	}
	return $get_esignature;
}

function get_y_coordinate_esignature($pkid){ //NOTE : fsignature originator
	require_once('../class/oop_tqts.php'); //NOTE : fsignature get the signature of every approver according to the EMPLOYEE NUMBER
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('y_coordinate,x_coordinate');
	$table 	   		= 'tbl_qfr_sa_approvers_main';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= 'ORDER BY `fkid` DESC';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$esignature 	= array();
	while($row = mysqli_fetch_array($result)){
		$esignature = $row['y_coordinate'];
	}
	return $esignature;
}
function get_x_coordinate_esignature($pkid){ //NOTE : fsignature originator
	require_once('../class/oop_tqts.php'); //NOTE : fsignature get the signature of every approver according to the EMPLOYEE NUMBER
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('y_coordinate,x_coordinate');
	$table 	   		= 'tbl_qfr_sa_approvers_main';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= 'ORDER BY `fkid` DESC';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$esignature 	= array();
	while($row = mysqli_fetch_array($result)){
		$esignature = $row['x_coordinate'];
	}
	return $esignature;
}
function get_checker_esignature($pkid){ //NOTE : fsignature originator
	require_once('../class/oop_tqts.php'); //NOTE : fsignature get the signature of every approver according to the EMPLOYEE NUMBER
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('approver_username');
	$table 	   		= 'tbl_qfr_sa_approvers';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `logdel` = 0 AND `status` = 1';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$file_ctrl 		= array();
	while($row = mysqli_fetch_assoc($result)){
		$file_ctrl = $row ['approver_username'];
		$get_esignature = return_esignature_sar($file_ctrl);
	}
	return $get_esignature;
}

function fn_get_file_name($pkid){
	require_once('../class/oop_tqts.php'); //NOTE : fsignature get the signature of every approver according to the EMPLOYEE NUMBER
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('file_name');
	$table 	   		= 'tbl_qfr_special_acceptance_attachment';
	$joins 	   		= '';
	$sql_where 		= 'WHERE `fkspecial_acceptance` = "'.$pkid.'" AND `logdel` = 0';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_assoc($result)){
		$return['file_name'] = $row ['file_name'];
	}else{
		$return['file_name'] = 'Special Acceptance';
	}
	return $return;
}
/* 
$y_coordinate_esignature = get_y_coordinate_esignature($pkid);
$x_coordinate_esignature = get_x_coordinate_esignature($pkid);
$originator_esignature_count 	= get_originator_esignature_count($pkid);
$originator_esignature_second 	= get_originator_esignature_second($pkid); */

/** Query: get the approver signature and each row */
require_once('../class/oop_tqts.php'); //NOTE : fsignature get the signature of every approver according to the EMPLOYEE NUMBER
$return 		= $_POST;
$result 		= '';
$array_fields 	= array('approver_username,y_coordinate,x_coordinate,order_id');
$table 	   		= 'tbl_qfr_sa_approvers_main';
$joins 	   		= '';
$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `logdel` = 0 AND `status` = 1';
$sql_order 		= 'ORDER BY order_id';
$sql_limit 		= '';
$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$file_ctrl 		= array();
if (file_exists($file)) {
	$file = $file_path . 'e_'.$pkid . '.xls'; 
	// Load an existing spreadsheet
	$phpExcel = PHPExcel_IOFactory::load($file);
	// Get the first sheet
	$sheet = $phpExcel ->getActiveSheet(0);
	// Insert setValue 
	$sheet ->getCell('X2')->setValue($ctrl_no);
	//modifynow
	$sheet->getStyle ($result_1)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	$sheet->getStyle ($result_2)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	$sheet->getStyle ($result_3)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	$sheet->getStyle ($result_4)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	/* if the prepared by == 2, 2 prepared by else 1 prepared by */
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('image');
	$objDrawing->setDescription('image');
	$objDrawing->setPath($originator_esignature);
	$objDrawing->setWidthAndHeight(90,90);
	$objDrawing->setResizeProportional(true);
	$objDrawing->setWorksheet($phpExcel->getActiveSheet());
	$objDrawing->setCoordinates('AA'.'7');

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('image');
	$objDrawing->setDescription('image');
	$objDrawing->setPath($checker_esignature);
	$objDrawing->setWidthAndHeight(90,90);
	$objDrawing->setResizeProportional(true);
	$objDrawing->setWorksheet($phpExcel->getActiveSheet());
	$objDrawing->setCoordinates('AA'.'9');
	while($row = mysqli_fetch_assoc($result)){
		
		$file_ctrl = $row ['approver_username'];
		$column = $row ['y_coordinate'];
		$row = $row ['x_coordinate'];
		$get_esignature = return_esignature_sar($file_ctrl);

		// Create the PHPExcel spreadsheet writer object
			/** get the signature of the approvers */
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('image');
		$objDrawing->setDescription('image');
		$objDrawing->setPath($get_esignature);
		$objDrawing->setWidthAndHeight(90,90);
		$objDrawing->setResizeProportional(true);
		$objDrawing->setWorksheet($phpExcel->getActiveSheet());
		$objDrawing->setCoordinates($column.$row);
	}
	/** Get the date approved by the approvers */
	$sheet ->getCell('G51')->setValue($date_1);
	$sheet ->getCell('L51')->setValue($date_2);
	$sheet ->getCell('V51')->setValue($date_3);
	$sheet ->getCell('AB51')->setValue($date_4);
	
	// $sheet -> getDrawingCollection()[0];
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");

	/* Redirect to browser (download) instead of saving the result to file */
	/* Only for xls format */
	ob_end_clean();
	// header('Content-type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="'.basename($new_file_name).'"');
	header('Cache-Control: max-age=0');
	// Save the spreadsheet
	$writer->save('php://output');
    exit;
} else if(file_exists($file_x)) {
	// Load an existing spreadsheet
	// $objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$phpExcel =PHPExcel_IOFactory::load($file_x);
	// Get the first sheet
	$sheet = $phpExcel ->getActiveSheet();
	
	/**ML Modified 2023 - Avoid the comment to become black bgcolor*/
	$custom_cells = array('I5','E10','T9','Y19','AA39');
	foreach($custom_cells as $cells){
		$comment = $sheet->getComment($cells);
		$commentStyle = $comment->getFillColor();
		$commentStyle->setRGB('FFFFE1');
	}
	// Insert setValue 
	$sheet ->getCell('X2')->setValue($ctrl_no);
	//modifynow
	$sheet->getStyle ($result_1)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	$sheet->getStyle ($result_2)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	$sheet->getStyle ($result_3)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	$sheet->getStyle ($result_4)-> getFill () -> setFillType (PHPExcel_Style_Fill :: FILL_SOLID);
	/* if the prepared by == 2, 2 prepared by else 1 prepared by */
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('image');
	$objDrawing->setDescription('image');
	$objDrawing->setPath($originator_esignature);
	$objDrawing->setWidthAndHeight(90,90);
	$objDrawing->setResizeProportional(true);
	$objDrawing->setWorksheet($phpExcel->getActiveSheet());
	$objDrawing->setCoordinates('AA'.'7');

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('image');
	$objDrawing->setDescription('image');
	$objDrawing->setPath($checker_esignature);
	$objDrawing->setWidthAndHeight(90,90);
	$objDrawing->setResizeProportional(true);
	$objDrawing->setWorksheet($phpExcel->getActiveSheet());
	$objDrawing->setCoordinates('AA'.'9');
	while($row = mysqli_fetch_assoc($result)){
		
		$file_ctrl = $row ['approver_username'];
		$column = $row ['y_coordinate'];
		$row = $row ['x_coordinate'];
		$get_esignature = return_esignature_sar($file_ctrl);

		// Create the PHPExcel spreadsheet writer object
			/** get the signature of the approvers */
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('image');
		$objDrawing->setDescription('image');
		$objDrawing->setPath($get_esignature);
		$objDrawing->setWidthAndHeight(90,90);
		$objDrawing->setResizeProportional(true);
		$objDrawing->setWorksheet($phpExcel->getActiveSheet());
		$objDrawing->setCoordinates($column.$row);
	}
	/** Get the date approved by the approvers */
	$sheet ->getCell('G51')->setValue($date_1);
	$sheet ->getCell('L51')->setValue($date_2);
	$sheet ->getCell('V51')->setValue($date_3);
	$sheet ->getCell('AB51')->setValue($date_4);

	/* Redirect to browser (download) instead of saving the result to file */
	/* Only for xlsx format */
	ob_end_clean();
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.basename($new_file_name).'"');
	header('Cache-Control: max-age=0');

	// Save the spreadsheet
	$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
	$writer->save('php://output');
    // readfile($file_x);
    exit;
} else {
	echo 'File not found!';
}

?>