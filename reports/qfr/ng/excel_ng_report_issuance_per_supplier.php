<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../class/oop_tqts.php');
require_once('../../../../media/PHPExcel-1.8/Classes/PHPExcel.php');

$fy_start 	= $_GET['fs'];
$fy_end 	= $_GET['fe'];
$section 	= $_GET['sc'];

/* PHPExcel */
$objPHPExcel 		= new PHPExcel();
$objWorksheet 		= $objPHPExcel->getActiveSheet();
$dataSeriesLabels 	= array();
$xAxisTickValues 	= array();
$dataSeriesValues 	= array();

/* Populate supplier Lists */
$table_array 	= array();
$col			= "A";
$row			= 4;

$supplier			= array();
$array_fields 		= array('supplier');
$table 	   			= 'tbl_supplier';
$joins 	   			= '';
$sql_where 			= 'WHERE logdel=0';
$sql_order 			= 'ORDER BY supplier';
$sql_limit 			= '';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
while($row_rec = mysqli_fetch_array($result)) {
	$supplier[]		  = $row_rec['supplier'];	
}

/* Populate Table header and Total number of record per supplier */
if($fy_start == $fy_end) {
	$fy_end 	= date('Y', strtotime(($fy_end.'-01-01').' -1 year')); //for the computation of Fiscal Year
	$date 		= $fy_end.'-12';
	$ctr 		= 4;
	$total 		= 0;
	$col		= "B";
	$table_array[] = array('A'.$row, '');
	$table_array[] = array('N3', 'Total');
	for($i = 0; $i < count($supplier); $i++) {
		$total = 0;
		for($col='B';$col != 'N'; $col++) {
			$month_year 	= date('M-y', strtotime($date.'+'.$ctr.' month')); //table header
			$year_month 	= date('Y-m', strtotime($date.'+'.$ctr.' month'));
			$table_array[] 	= array($col."3", $month_year);		
			$ctr++;
			
			$sub_total 		= return_total_num_by_supplier($supplier[$i],$year_month, $section); //total
			$table_array[] 	= array($col.($i+4), $sub_total);	
			$total		   += $sub_total;
		}
		// $table_array[] 		= array('N'.($row), $total);	
		$table_array[] 		= array('N'.($row), '=SUM(B'.$row.':M'.$row.')');	
		$table_array[] 		= array('A'.($row++), $supplier[$i]);
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
		for($x = 0; $x < count($supplier); $x++) {
			$average 		= return_average_supplier($supplier[$x],$year, $supplier, $section); //average
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
	for($i = 0; $i < count($supplier); $i++) {
		for($col=$last_col;$col != $max_col; $col++) {
			$month_year 	= date('M-y', strtotime($date.'+'.$ctr.' month')); //table header
			$year_month 	= date('Y-m', strtotime($date.'+'.$ctr.' month'));
			$table_array[] 	= array($col."3", $month_year);		
			$ctr++;
			
			$total 			= return_total_num_by_supplier($supplier[$i],$year_month, $section); //total
			$table_array[] 	= array($col.($i+4), $total);	
		}
		$table_array[] 		= array('A'.($row++), $supplier[$i]);
		$ctr 				= 4;
	}
}

/* Set excel style */
$styleArray = array(
	'font' => array(
		'name' => 'Arial',
		'size' => '10',
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	),
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	)
);
$styleArray_bold = array(
	'font' => array(
		'bold' => true,
		'name' => 'Arial',
		'size' => '10',
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);
$objPHPExcel->getActiveSheet()->getStyle('A3:N'.($row-1))->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A2:N3')->applyFromArray($styleArray_bold);
$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');

/* Create the worksheet array */
for( $x = 0;$x<count($table_array);$x++ ){
	$objWorksheet->getCell($table_array[$x][0])->setValue($table_array[$x][1]);
}

$objWorksheet->getCell('A2')->setValue('NG Report count per Month');
$objWorksheet->getColumnDimension('A')->setWidth(20);

//	Set the Labels for each data series we want to plot (supplier LIST)
//	Set the Values for each data series we want to plot (supplier COUNT)
$dispo_row = 4;
$max_col   = decrementLetter($max_col);
for($i = 0; $i < count($supplier); $i++ ) {
	$dataSeriesLabels[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.$dispo_row, NULL, 1);
	$dataSeriesValues[] = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$A$'.$dispo_row.':$'.$max_col.'$'.$dispo_row, NULL, 4);
	$dispo_row++;	
}
//	Set the X-Axis Labels (DISPLAY FY AVERAGE, MONTHS)
$xAxisTickValues[] = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$3:$'.$max_col.'$3', NULL, 4);

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

$title 		= new PHPExcel_Chart_Title('NG Report Issuance per Supplier');
$yAxisLabel 		= new PHPExcel_Chart_Title('NG Report Issuance per Supplier');


//	Create the chart
$chart = new PHPExcel_Chart(
	'chart1',		// name
	$title,			// title
	$legend,		// legend
	$plotArea,		// plotArea
	true,			// plotVisibleOnly
	0,				// displayBlanksAs
	NULL,			// xAxisLabel
	$yAxisLabel			// yAxisLabel
);

//	Set the position where the chart should appear in the worksheet
$chart->setTopLeftPosition('P4');
$chart->setBottomRightPosition('AB35');

//	Add the chart to the worksheet
$objWorksheet->addChart($chart);

/* set file name */
$file_name = "NG Report supplier_".date('MY').'.xlsx';
// $file_name = "NG Report supplier_".date('MY').'.xls';

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2003');
$objWriter->setIncludeCharts(TRUE);
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-supplier: attachment; filename=\"$file_name\"");
header("Cache-Control: max-age=0");
ob_clean();
$objWriter->save('php://output');

function iterate_colums($column, $ctr) {	
	for($i = 0; $i < $ctr; $i++) {
		$column++;
	}
	return $column++;
}
function decrementLetter($l) {
    return chr(ord($l) - 1);
}
function return_total_num_by_supplier($supplier,$disposition_sent_date, $section) {
	$section 			= json_decode($section);
	$sect_where			= array();
	$section_where		= ' AND (';
	foreach($section as $i => $section_name) {
		$sect_where[] 	= ' main.ng_report_no LIKE "%'.$section_name.'-%"';
	}
	$sect_where = implode(' OR ',$sect_where);
	$section_where	   .= $sect_where . ')';
	
	$array_fields 		= array('COUNT(details.pkid) as total');
	$table 	   			= 'tbl_qfr_ng_treatment details';
	$joins 	   			= 'INNER JOIN tbl_qfr_ng main ON main.pkid = details.fkng';
	$sql_where 			= 'WHERE main.supplier="'.$supplier.'" AND details.disposition_sent_date LIKE "'.$disposition_sent_date.'-%" AND details.logdel=0 AND main.logdel=0'.$section_where;
	$sql_order 			= '';
	$sql_limit 			= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// echo $script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)) {
		return $row['total'];
	} else {
		return 0;
	}
	// return $script;
}
function return_average_supplier($supplier,$disposition_year, $supplier, $section) {
	$section 			= json_decode($section);
	$sect_where			= array();
	$section_where		= ' AND (';
	foreach($section as $i => $section_name) {
		$sect_where[] 	= ' main.ng_report_no LIKE "%'.$section_name.'-%"';
	}
	$sect_where = implode(' OR ',$sect_where);
	$section_where	   .= $sect_where . ')';
	
	$array_fields 		= array('COUNT(`details`.`pkid`)/12 AS ave');
	$table 	   			= 'tbl_qfr_ng_treatment details';
	$joins 	   			= 'INNER JOIN tbl_qfr_ng main ON main.pkid = details.fkng';
	$sql_where 			= 'WHERE main.supplier="'.$supplier.'" AND details.disposition_sent_date LIKE "'.$disposition_year.'-%" AND details.logdel=0 AND main.logdel=0'.$section_where;
	$sql_order 			= '';
	$sql_limit 			= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)) {
		return $row['ave'];
	} else {
		return 0;
	}
}
?>