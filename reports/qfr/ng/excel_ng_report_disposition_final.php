<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../class/oop_tqts.php');
require_once('../../../../media/PHPExcel-1.8/Classes/PHPExcel.php');

$fy_start 	= $_GET['fs'];
$fy_end 	= $_GET['fe'];
$supplier 	= utf8_decode(urldecode($_GET['sp']));
$section 	= $_GET['sc'];

/* PHPExcel */
$objPHPExcel 		= new PHPExcel();
$objWorksheet 		= $objPHPExcel->getActiveSheet();
$dataSeriesLabels 	= array();
$xAxisTickValues 	= array();
$dataSeriesValues 	= array();

/* Populate response_type Lists */
$table_array 	= array();
$col			= "A";
$row			= 4;

$response_type		= array();
$response_type[]	= 'W/ Final Response';	
$response_type[]	= 'W/o Final Response';	

/* Populate Table header and Total number of record by response_type */
if($fy_start == $fy_end) {
	$fy_end 	= date('Y', strtotime(($fy_end.'-01-01').' -1 year')); //for the computation of Fiscal Year
	$date 		= $fy_end.'-12';
	$ctr 		= 4;
	$col		= "B";
	$table_array[] = array('A'.$row, '');
	for($i = 0; $i < count($response_type); $i++) {
		for($col='B';$col != 'N'; $col++) {
			$month_year 	= date('M-y', strtotime($date.'+'.$ctr.' month')); //table header
			$year_month 	= date('Y-m', strtotime($date.'+'.$ctr.' month'));
			$table_array[] 	= array($col."3", $month_year);		
			$ctr++;
			
			$total 			= return_total_count($response_type[$i],$year_month, $supplier, $section); //total
			$table_array[] 	= array($col.($i+4), $total);	
		}
		$table_array[] 		= array('A'.($row++), $response_type[$i]);
		$ctr 				= 4;
	}
	$max_col = $col;
} else {
	$row = 3;
	$table_array[] = array('A'.$row, '');
	$average_row = 4;

	for($year = $fy_start; $year <= $fy_end; $year++ ) {
		$col++;
		$table_array[] = array($col.($row), 'FY'.$year.' (Ave)');
		for($x = 0; $x < count($response_type); $x++) {
			$average 		= return_total_count($response_type[$x],$year, $supplier, $section); //average
			$table_array[] 	= array($col.($average_row), $average);	
			$objWorksheet->getColumnDimension($col)->setWidth(15);
			$average_row++;
		}
		$average_row = 4;
	}
	$col++;
	$last_col 	= $col;
	$row 		= 4;
	$fy_end 	= date('Y', strtotime($fy_end.' -1 year')); //for the computation of Fiscal Year
	$date 		= $fy_end.'-12';
	$ctr 		= 4;
	$max_col 	= iterate_colums($last_col, 12);
	for($i = 0; $i < count($response_type); $i++) {
		for($col=$last_col;$col != $max_col; $col++) {
			$month_year 	= date('M-y', strtotime($date.'+'.$ctr.' month')); //table header
			$year_month 	= date('Y-m', strtotime($date.'+'.$ctr.' month'));
			$table_array[] 	= array($col."3", $month_year);		
			$ctr++;
			
			$total 			= return_total_count($response_type[$i],$year_month, $supplier, $section); //total
			$table_array[] 	= array($col.($i+4), $total);	
		}
		$table_array[] 		= array('A'.($row++), $response_type[$i]);
		$ctr 				= 4;
	}
}

/* Create the worksheet array */
for( $x = 0;$x<count($table_array);$x++ ){
	$objWorksheet->getCell($table_array[$x][0])->setValue($table_array[$x][1]);
}

$objWorksheet->getCell('A1')->setValue('NG REPORT LEADTIME MONITORING FINAL RESPONSE');
$objWorksheet->getColumnDimension('A')->setWidth(20);

//	Set the Labels for each data series we want to plot (response_type LIST)
//	Set the Values for each data series we want to plot (response_type COUNT)
$dispo_row = 4;
$max_col   = decrementLetter($max_col);
for($i = 0; $i < count($response_type); $i++ ) {
	$dataSeriesLabels[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.$dispo_row, NULL, 1);
	$dataSeriesValues[] = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$A$'.$dispo_row.':$'.$max_col.'$'.$dispo_row, NULL, 4);
	$dispo_row++;	
}
//	Set the X-Axis Labels (DISPLAY FY AVERAGE, MONTHS)
$xAxisTickValues[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$3:$O$3', NULL, 4);

//	Build the dataseries
$series = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
	PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
	range(0, count($dataSeriesValues)-1),			// plotOrder
	$dataSeriesLabels,								// plotLabel
	$xAxisTickValues,								// plotCategory
	$dataSeriesValues								// plotValues
);
//Set Data Labels (value of data)
$layout1 = new PHPExcel_Chart_Layout();
$layout1->setShowVal(TRUE);      // Initializing the data labels with Values
$layout1->setShowPercent(TRUE);  // Initializing the data labels with Percentages

//	Set the series in the plot area
 $plotArea = new PHPExcel_Chart_PlotArea($layout1, array($series));
//	Set the chart legend
$legend 	= new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

$title 		= new PHPExcel_Chart_Title('NG REPORT LEADTIME MONITORING FINAL RESPONSE');


//	Create the chart
$chart = new PHPExcel_Chart(
	'chart1',		// name
	$title,			// title
	$legend,		// legend
	$plotArea,		// plotArea
	true,			// plotVisibleOnly
	0,				// displayBlanksAs
	NULL,			// xAxisLabel
	NULL			// yAxisLabel
);

//	Set the position where the chart should appear in the worksheet
$chart->setTopLeftPosition('B11');
$chart->setBottomRightPosition('J24');

//	Add the chart to the worksheet
$objWorksheet->addChart($chart);

/* set file name */
$file_name = "NG Report Leadtime Monitoring Final Response_".date('MY').' (IQC)'.'.xlsx';
// $file_name = "NG Report Leadtime Monitoring Final Response_".date('MY').' (IQC)'.'.xls';


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setIncludeCharts(TRUE);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Cache-Control: max-age=0");
ob_clean();
$objWriter->save('php://output');

function return_total_count($type, $response_year, $supplier, $section) {
	$supplier 			= explode(',',$supplier);
	$supp_where			= array();
	$supplier_where		= ' AND (';
	foreach($supplier as $i => $supplier_name) {
		$supp_where[] 	= ' main.supplier = "'.$supplier_name.'"';
	}
	$supp_where = implode(' OR ',$supp_where);
	$supplier_where	   .= $supp_where . ')';

	$section 			= json_decode($section);
	$sect_where			= array();
	$section_where		= ' AND (';
	foreach($section as $i => $section_name) {
		$sect_where[] 	= ' main.ng_report_no LIKE "%-'.$section_name.'-%"';
	}
	$sect_where = implode(' OR ',$sect_where);
	$section_where	   .= $sect_where . ')';
	
	$count = 0;
	if($type == 'W/ Final Response') {
		$array_fields 		= array('COUNT(details.pkid) AS with_final_dispo');
		$table 	   			= 'tbl_qfr_ng_treatment details';
		$joins 	   			= 'INNER JOIN tbl_qfr_ng main ON main.pkid = details.fkng';
		$sql_where 			= 'WHERE details.logdel=0 AND main.logdel=0 AND `final_reply_status` = "REQUIRED" AND `final_reply_date` LIKE "%'.$response_year.'-%"'.$supplier_where.$section_where;
		$sql_order 			= '';
		$sql_limit 			= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$count = $row['with_final_dispo'];
		}
	} else if($type == 'W/o Final Response') {
		$array_fields 		= array('COUNT(details.pkid) AS no_final_dispo');
		$table 	   			= 'tbl_qfr_ng_treatment details';
		$joins 	   			= 'INNER JOIN tbl_qfr_ng main ON main.pkid = details.fkng';
		$sql_where 			= 'WHERE details.logdel=0 AND main.logdel=0 AND `final_reply_status` = "REQUIRED" AND `final_reply_date` = "" AND disposition_date LIKE "%'.$response_year.'-%"'.$supplier_where.$section_where;
		$sql_order 			= '';
		$sql_limit 			= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$count = $row['no_final_dispo'];
		}
	}	
	return $count;
}

function decrementLetter($l) {
    return chr(ord($l) - 1);
}
function iterate_colums($column, $ctr) {	
	for($i = 0; $i < $ctr; $i++) {
		$column++;
	}
	return $column++;
}
?>