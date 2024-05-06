<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id 		= trim($_GET['id'],' ');
$id_array	= explode('_',$id);
$fkid 		= $id_array[0];
$dispo 		= $id_array[1];
$file	 	= get_file_path_by_pkid($fkid,$dispo);
$file_path 	= $file['file_path'];
$extension 	= $file['extension'];
$file_name 	= $file['file_name'];

$file = $file_path . $id . '.' . $extension; 


if (file_exists($file)) {
	// flush();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
	ob_clean();
    readfile($file);
    exit;
}

function get_file_path_by_pkid($fkdetails,$dispo) {
	require_once('../../class/oop_tqts.php');
	$array_fields = array('path.file_path','details.disposition_file_name','details.final_reply_file_name');
	$table 	   	= 'tbl_qfr_ng_treatment details ';
	$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
	$sql_where 	= 'WHERE details.fkng="'.$fkdetails.'" AND details.logdel=0';
	$sql_order 	= '';
	$sql_limit 	= 'LIMIT 0,1';
	$file 		= array();
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// echo TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		$file['file_path'] = '../'.$row['file_path'];
		$file_name 		   = $dispo == 1 ? $row['disposition_file_name'] : $row['final_reply_file_name'];
		$file['extension'] = end(explode('.',$file_name));			
		$file['file_name'] = $file_name;	
	}
	return $file;
}

/* require_once( '../../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
$file = '../../uploaded_file/TS/quality_report/ngsa/6.xlsx';
$file = '../../uploaded_file/TS/quality_report/ngsa/7.xls';
$esig_file = '../../../ACDCS/e_signatures/J005.png';
$inputFileName = $file;
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

$objPHPExcelReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objPHPExcelReader->load($inputFileName);
	
	

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $index =  $objPHPExcel->getIndex($worksheet);
	$objPHPExcel->setActiveSheetIndex($index);
	$sheet = $objPHPExcel->getActiveSheet();
	$comments = $sheet->getComments();
	
	 foreach($comments  as $cellID => $comment) {
		$sheet->getComment($cellID)->getFillColor()->setRGB('EEEEEE');
	}
}

// Display e-signature based on given sheet number
// $objDrawing = new PHPExcel_Worksheet_Drawing();

//$objDrawing->setWorksheet($sheet_no);
//$objDrawing->setPath($esig_file);
//$objDrawing->setCoordinates('C6');
//$objDrawing->setHeight(40);

// $file_name	= 'test.xlsx';
$file_name	= 'test.xls';

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Cache-Control: max-age=0");
ob_clean();
$objWriter->save('php://output');*/
?>