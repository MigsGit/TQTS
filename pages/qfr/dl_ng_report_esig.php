<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once( '../../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
$file = '../../uploaded_file/TS/quality_report/ng/00.xlsx';
// $file = '../../uploaded_file/TS/quality_report/ngsa/7.xls';
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

$file_name	= 'test.xlsx';
// $file_name	= 'test.xls';

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Cache-Control: max-age=0");
ob_clean();
$objWriter->save('php://output');
?>