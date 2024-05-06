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
$dataSeriesLabels2 	= array();
$dataSeriesValues2 	= array();

/* Populate data_category Lists */
$table_array 	= array();
$col			= "A";
$row			= 4;

$data_category		= array();
$data_category[]	= 'AVE. # OF NG REPORT';	
$data_category[]	= 'TRGT. RESPONSE LEADTIME';	
$data_category[]	= 'AVE. RESPONSE LEADTIME';	

/* Populate Table header and Total number of record by data_category */
if($fy_start == $fy_end) {
	$fy_end 	= date('Y', strtotime(($fy_end.'-01-01').' -1 year')); //for the computation of Fiscal Year
	$date 		= $fy_end.'-12';
	$ctr 		= 4;
	$col		= "B";
	$table_array[] = array('A'.$row, '');
	for($i = 0; $i < count($data_category); $i++) {
		for($col='B';$col != 'N'; $col++) {
			$month_year 	= date('M-y', strtotime($date.'+'.$ctr.' month')); //table header
			$year_month 	= date('Y-m', strtotime($date.'+'.$ctr.' month'));
			$table_array[] 	= array($col."3", $month_year);		
			$ctr++;
			
			if($i == 0) {
				$total 			= return_average_ng_report_per_month($year_month, $supplier, $section); //total
				$table_array[] 	= array($col.($i+4), $total);	
			} else if($i == 1) {
				$total 			= '24'; //default leadtime for supplier
				$table_array[] 	= array($col.($i+4), $total);	
			} else if($i == 2) {
				$total 			= number_format((return_average_response_leadtime_per_month($year_month, $supplier, $section) / 12), 2); //average leadtime 
				$table_array[] 	= array($col.($i+4), $total);	
			} 
			
		}
		$table_array[] 		= array('A'.($row++), $data_category[$i]);
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
		for($x = 0; $x < count($data_category); $x++) {
			if($x == 0) {
				$total 			= number_format((return_average_ng_report_per_month($year, $supplier, $section) / 12) , 2); //total
				$table_array[] 	= array($col.($average_row), $total);	
			} else if($x == 1) {
				$total 			= '24'; //default leadtime for supplier
				$table_array[] 	= array($col.($average_row), $total);	
			} else if($x == 2) {
				$total 			= number_format((return_average_response_leadtime_per_month($year, $supplier, $section) / 12), 2); //average leadtime 
				$table_array[] 	= array($col.($average_row), $total);	
			} 
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
	for($i = 0; $i < count($data_category); $i++) {
		for($col=$last_col;$col != $max_col; $col++) {
			$month_year 	= date('M-y', strtotime($date.'+'.$ctr.' month')); //table header
			$year_month 	= date('Y-m', strtotime($date.'+'.$ctr.' month'));
			$table_array[] 	= array($col."3", $month_year);		
			$ctr++;
			
			if($i == 0) {
				$total 			= return_average_ng_report_per_month($year_month, $supplier, $section); //total
				$table_array[] 	= array($col.($i+4), $total);	
			} else if($i == 1) {
				$total 			= '24'; //default leadtime for supplier
				$table_array[] 	= array($col.($i+4), $total);	
			} else if($i == 2) {
				$total 			= return_average_response_leadtime_per_month($year_month, $supplier, $section); //average leadtime 
				$table_array[] 	= array($col.($i+4), $total);	
			} 
		}
		$table_array[] 		= array('A'.($row++), $data_category[$i]);
		$ctr 				= 4;
	}
}

/* Create the worksheet array */
for( $x = 0;$x<count($table_array);$x++ ){
	$objWorksheet->getCell($table_array[$x][0])->setValue($table_array[$x][1]);
}

$objWorksheet->getCell('A1')->setValue('NG REPORT LEADTIME MONITORING FINAL RESPONSE');
$objWorksheet->getColumnDimension('A')->setWidth(20);

// Draw bar graph
$dataSeriesLabels[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A4', NULL, 1);
$xAxisTickValues[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$3:$O$3', NULL, 4);
$dataSeriesValues[] = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$A$4:$'.$max_col.'$4', NULL, 4);

//	Build the dataseries of bar graph
$series = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
	PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
	range(0, count($dataSeriesValues)-1),			// plotOrder
	$dataSeriesLabels,								// plotLabel
	$xAxisTickValues,								// plotCategory
	$dataSeriesValues								// plotValues
);

// Draw line graph 
$dataSeriesLabels2[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A5', NULL, 1);
$dataSeriesLabels2[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A6', NULL, 1);
$dataSeriesValues2[] = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$A$5:$'.$max_col.'$5', NULL, 4);
$dataSeriesValues2[] = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$A$6:$'.$max_col.'$6', NULL, 4);

//  Build the dataseries of line graph
$series2 = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART, 		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD, 	// plotGrouping
		range(0, count($dataSeriesValues2) - 1), 		// plotOrder
		$dataSeriesLabels2, 							// plotLabel
		NULL, 											// plotCategory
		$dataSeriesValues2                              // plotValues
);

//Set Data Labels (value of data)
$layout1 = new PHPExcel_Chart_Layout();
$layout1->setShowVal(TRUE);      // Initializing the data labels with Values
$layout1->setShowPercent(TRUE);  // Initializing the data labels with Percentages

//	Set the series in the plot area
$plotArea 	= new PHPExcel_Chart_PlotArea($layout1, array($series, $series2));
//	Set the chart legend
$legend 	= new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

$title 		= new PHPExcel_Chart_Title('NG REPORT LEADTIME MONITORING FIRST RESPONSE');


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
$chart->setBottomRightPosition('J30');

//	Add the chart to the worksheet
$objWorksheet->addChart($chart);

/* set file name */
$file_name = "NG Report Leadtime Monitoring First Response_".date('MY').'.xlsx';
// $file_name = "NG Report Leadtime Monitoring First Response_".date('MY').'.xls';


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setIncludeCharts(TRUE);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Cache-Control: max-age=0");
ob_clean();
$objWriter->save('php://output');

function return_average_ng_report_per_month($disposition_date, $supplier, $section) {
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
		$sect_where[] 	= ' main.ng_report_no LIKE "%'.$section_name.'-%"';
	}
	$sect_where = implode(' OR ',$sect_where);
	$section_where	   .= $sect_where . ')';
	
	$array_fields 		= array('COUNT(`details`.`pkid`) AS total');
	$table 	   			= 'tbl_qfr_ng_treatment details';
	$joins 	   			= 'INNER JOIN tbl_qfr_ng main ON main.pkid = details.fkng';
	$sql_where 			= 'WHERE details.disposition!="" AND details.disposition_date LIKE "'.$disposition_date.'-%" AND details.logdel=0 AND main.logdel=0'.$supplier_where.$section_where;
	$sql_order 			= '';
	$sql_limit 			= '';
	$result 			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)) {
		return $row['total'];
	} else {
		return 0;
	}
}

function return_average_response_leadtime_per_month($disposition_year, $supplier, $section) {
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
		$sect_where[] 	= ' main.ng_report_no LIKE "%'.$section_name.'-%"';
	}
	$sect_where = implode(' OR ',$sect_where);
	$section_where	   .= $sect_where . ')';
	
	$leadtime_sum 		= 0;
	$leadtime_record 	= 0;
	$leadtime_average 	= 0;
	$array_fields 		= array('details.disposition_sent_date', 'details.disposition_date', 'details.disposition_time');
	$table 	   			= 'tbl_qfr_ng_treatment details';
	$joins 	   			= 'INNER JOIN tbl_qfr_ng main ON main.pkid = details.fkng';
	$sql_where 			= 'WHERE details.disposition != "" AND details.disposition_date LIKE "'.$disposition_year.'-%" AND details.logdel=0 AND main.logdel=0'.$supplier_where.$section_where;
	$sql_order 			= '';
	$sql_limit 			= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row = mysqli_fetch_array($result)) {
		$disposition_sent_date 		= $row['disposition_sent_date'];
		$disposition_received_date 	= $row['disposition_date'].' '.$row['disposition_time'].':00';
		
		$leadtime_difference = compute_date_time_difference($disposition_sent_date, $disposition_received_date);
		$leadtime_sum		+= number_format($leadtime_difference, 2);
	}
	$leadtime_record = $result->num_rows;
	$leadtime_average= number_format(($leadtime_sum / $leadtime_record), 2);
	return $leadtime_average;
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
function compute_date_time_difference($disposition_sent_date, $disposition_received_date) {
	$date_time_sent 	= date('Y-m-d H:i',strtotime($disposition_sent_date));
	$date_time_received = date('Y-m-d H:i',strtotime($disposition_received_date));
	$sent 				= strtotime($date_time_sent);
	$received 			= strtotime($date_time_received);

	$diff = $received - $sent;

	$diff_in_min = $diff / 60;
	$diff_in_min = explode(".",$diff_in_min);
	/* get the minute difference */
	$diff_in_min = $diff_in_min[0];

	/* get difference in hour */
	$diff_in_hour = ($diff_in_min / 60); 

	$diff_in_min = ($diff_in_min * 60) / 3600; 
 
	$diff_in_hour = explode(".",$diff_in_hour);
	$diff_in_hour = $diff_in_hour[0]; 

	$leadtime_diff = $diff_in_hour + $diff_in_min;
	return $leadtime_diff;
}
?>