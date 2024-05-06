<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../class/oop_tqts.php');
require_once('../../../../media/PHPExcel-1.8/Classes/PHPExcel.php');

$fy_start 	= $_GET['fs'];
$fy_end 	= $_GET['fe'];
$section 	= $_GET['sc'];

$material_type 		= array();
$mode_of_defects 	= array();
$table_array 		= array();

/* PHPExcel */
$objPHPExcel 		= new PHPExcel();
$objWorksheet 		= $objPHPExcel->getActiveSheet();

$row_cell = 4;

// $material_type 		= return_material_type_list();
// $mode_of_defects 	= return_mode_of_defects_list();

/* Create table per material type */
// foreach($material_type as $a => $mt_value) {
	for($a=0; $a<count($mode_of_defects); $a++) {
		$table_array[] = array('A'.$row_cell++, $mode_of_defects[$a]);
		
	}
// }


/* Create the worksheet array */
for( $x = 0;$x<count($table_array);$x++ ){
	$objWorksheet->getCell($table_array[$x][0])->setValue($table_array[$x][1]);
}

/* set file name */
// $file_name = "NG Report Per Material Type".date('MY').'.xlsx';
$file_name = "NG Report Per Material Type".date('MY').'.xls';

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->setIncludeCharts(TRUE);
// header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
// header("Content-supplier: attachment; filename=".$file_name);
// header("Cache-Control: max-age=0");
// ob_clean();
// $objWriter->save('php://output');

function return_material_type_list() {
	$material_type 		= array();
	$array_fields 		= array('material_type');
	$table 	   			= 'tbl_material_type';
	$joins 	   			= '';
	$sql_where 			= 'WHERE logdel=0';
	$sql_order 			= '';
	$sql_limit 			= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row = mysqli_fetch_array($result)) {
		$material_type[] = $row['material_type'];
	}
	return $material_type;
}

// function return_mode_of_defects_list() {
	$mode_of_defects 	= array();
	$array_fields 		= array('modDescription as mode_of_defects');
	$table 	   			= 'tbl_mod';
	$joins 	   			= '';
	$sql_where 			= '';
	$sql_order 			= '';
	$sql_limit 			= '';
	$result = SEIKODB::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row = mysqli_fetch_array($result)) {
		$mode_of_defects[] = $row['mode_of_defects'];
		echo $row['mode_of_defects'];
	}
	echo $result->num_rows;
	// return $mode_of_defects;
// }
?>