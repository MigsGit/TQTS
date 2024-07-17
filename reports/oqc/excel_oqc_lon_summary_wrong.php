<?php
$oop 		= './../../class/oop_tqts.php';
$handler 	= '../../handler/common_function.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
if(file_exists($handler)){
	require_once($handler);
}else{
	echo 'handler not found!';
	exit;
}

$date_from 	= $_GET['df'];		
$date_to	= $_GET['dt'];
// $date_from 	= '2018-03';		
// $date_to	= '2018-12';	

if(date('m', strtotime($date_from)) >= 4 && date('m', strtotime($date_from) <= 12)) {
	$fiscal_year 	= 'FY'.date('Y', strtotime($date_from.'-01'));
} else {
	$fiscal_year 	= 'FY'.date('Y', strtotime($date_from.'-01 -1 year'));
}

/* Group by Year and month data */
$array_fields 	= array('YEAR(date_inspected) AS year_inspected', 'MONTH(date_inspected) AS month_inspected');
$table 	   		= 'tbl_oqc_lon';
$joins 	   		= '';
$sql_where 		= 'WHERE (date_inspected BETWEEN "'.$date_from.'-01" AND "'.$date_to.'-31") AND logdel=0';
$sql_order 		= '';
$sql_limit 		= 'GROUP BY YEAR(date_inspected), MONTH(date_inspected)';
$result_group 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);


/* Details data */
$array_fields 	= array('*');
$table 	   		= 'tbl_oqc_lon';
$joins 	   		= '';
$sql_order 		= 'ORDER BY date_inspected';
$sql_limit 		= '';
$return = array();

$capa_array_fields 	= array('*');
$capa_table 	   		= 'tbl_oqc_lon_capa_monitoring';
$capa_joins 	   		= '';
$capa_sql_order 		= '';
$capa_sql_limit 		= '';

// echo json_encode($return);
// exit;


function check_capa_creation($pkid, $oop) {
	require_once($oop);
	$array_fields 	= array('*');
	$table 	   		= 'tbl_oqc_lon_production';
	$sql_where 	   	= 'WHERE fklon="'.$pkid.'" AND logdel=0';
	$joins 	   		= '';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result		 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	return $result->num_rows == 0 ? '' : 'With CAPA';
}

/* Do excel here  */

$excel_class = '../../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}

$excel = new EXCEL;
/* set title */
$excel->title = $fiscal_year;
$excel->add_sheet(0);

/* use the default font style */
$excel->set_default_font_style();
$excel->set_margin();
$excel->set_print_area();

/* set format */
$array_format_header = array(
	"size"	=> 22,
	"bold"	=> true,
	"h_alignment"	=> "center"
);

$array_format_subheader = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 11,
	'fill_color'  => "FFEB9C",
	"h_alignment"	=> "center"
);

$array_format_sub_content = array(
	"size"	=> 12,
	"h_alignment"	=> "left",
	'fill_color'  => "FF99cc"
);
$cell_range = 'A8:T8'; $excel->set_format($cell_range,$array_format_subheader);
$cell_range = 'A1:K1'; $excel->set_format($cell_range,$array_format_header);
$cell_range = 'M9:R9'; $excel->set_format($cell_range,$array_format_subheader);

$width_allowance = 10;

/* set width */
$excel->set_width('A',$width_allowance+12);
$excel->set_width('B',$width_allowance+30);	
$excel->set_width('C',$width_allowance+20);	
$excel->set_width('D',$width_allowance+20);	
$excel->set_width('E',$width_allowance+20);	
$excel->set_width('F',$width_allowance+20);	
$excel->set_width('G',$width_allowance+20);	
$excel->set_width('H',$width_allowance+15);	
$excel->set_width('I',$width_allowance+15);
$excel->set_width('J',$width_allowance+25);
$excel->set_width('K',$width_allowance+25);
$excel->set_width('L',$width_allowance+10);
$excel->set_width('M',$width_allowance+50);
$excel->set_width('N',$width_allowance+10);
$excel->set_width('O',$width_allowance+10);
$excel->set_width('P',$width_allowance+10);
$excel->set_width('Q',$width_allowance+10);
$excel->set_width('R',$width_allowance+10);

/* set height */
$arr_custom_height = array('1','2','3','4','5','6','7','8','9');
for($i=0; $i<count($arr_custom_height); $i++) {
	$excel->set_height($arr_custom_height[$i],40);
}

/* Merge Cells */
$arr_custom_merge_cells = array( 
							'A1:K1','A8:A9','B8:B9','C8:C9','D8:D9','E8:E9','F8:F9',
							'G8:G9','H8:H9','I8:I9','J8:J9','K8:K9','L8:L9','M8:P8',
							'Q8:R8','S8:S9','T8:T9'
						  ); //,'M8:M9','N8:N9','O8:O9','P8:P9'
for($i=0; $i<count($arr_custom_merge_cells); $i++) {
	$excel->merge_cells($arr_custom_merge_cells[$i]);
}

/* Wrap Text */
$excel->wrap_text('C8:T8');
$excel->wrap_text('M9:T9');

/* Border */
$cell = 'A8:T9'; $excel->set_borders($cell,1,1,1,1, "thin"); //Column Header


/* Place value 

SELECT SQL_CALC_FOUND_ROWS * FROM tbl_oqc_lon oqc_lon LEFT JOIN tbl_oqc_lon_capa_monitoring capa_monitoring ON capa_monitoring.oqc_lon_id =pkid WHERE (date_inspected LIKE "%2024-07%") AND logdel=0 ORDER BY date_inspected ;


*/
$col = 'A'; $row = '1';
$pmi_logo	= '../../images/pmi-logo2.png';
$excel->add_image($col.$row,$pmi_logo,'28px');

// $col = 'A'; $row = '3';
// $excel->set_height('2',15.00);
// $pmi_logo	= '../../images/sar_format.png';
// $excel->add_image($col.$row,$pmi_logo,'85px');

$section	= return_system_division();
$col = 'A'; $row = '1';   $excel->place_value($col.$row,$section.' '.$fiscal_year.' LOT-OUT NOTICE ISSUANCE SUMMARY LIST','string');
$col = 'A'; $row = '8';   $excel->place_value($col.$row,'Control Number','string');
$col = 'B'; $row = '8';   $excel->place_value($col.$row,'Date Issued','string');
$col = 'C'; $row = '8';   $excel->place_value($col.$row,'Line / Product classification','string');
$col = 'D'; $row = '8';   $excel->place_value($col.$row,'Model / Product name / Series Name','string');
$col = 'E'; $row = '8';   $excel->place_value($col.$row,'Location (Cabuyao or Malvar)','string');
$col = 'F'; $row = '8';   $excel->place_value($col.$row,'Lot Number / Trace code','string');
$col = 'G'; $row = '8';   $excel->place_value($col.$row,'Mode of Defects / Quantity','string');
$col = 'H'; $row = '8';   $excel->place_value($col.$row,'Contributor/Concern Operator','string');
$col = 'I'; $row = '8';   $excel->place_value($col.$row,'Incharge Supervisor','string');
$col = 'J'; $row = '8';   $excel->place_value($col.$row,'CAPA due date(based on TAT -3 days)','string');
$col = 'K'; $row = '8';   $excel->place_value($col.$row,'CAPA report received date','string');
$col = 'L'; $row = '8';   $excel->place_value($col.$row,'Actual TAT','string');

$col = 'M'; $row = '8';   $excel->place_value($col.$row,'CORRECTIVE / PREVENTIVE ACTION MONITORING','string'); //M-P
$col = 'M'; $row = '9';   $excel->place_value($col.$row,'CORRECTIVE / PREVENTIVE ACTION','string');
$col = 'N'; $row = '9';   $excel->place_value($col.$row,'IN-CHARGE','string');
$col = 'O'; $row = '9';   $excel->place_value($col.$row,'DUE DATE','string');
$col = 'P'; $row = '9';   $excel->place_value($col.$row,'Status (Open/Closed)','string');

$col = 'Q'; $row = '8';   $excel->place_value($col.$row,'CAPA Evidence Submission(after 15 working days from the start of implementation)','string'); //Q-R
$col = 'R'; $row = '9';   $excel->place_value($col.$row,'Required Submission Date','string');
$col = 'Q'; $row = '9';   $excel->place_value($col.$row,'Actual Submission Date','string');
$col = 'S'; $row = '8';   $excel->place_value($col.$row,'Remarks','string');
$col = 'T'; $row = '8';   $excel->place_value($col.$row,'Status','string');

/* Set data value */
$col = 'A';
$row = 10;

while($row_group = mysqli_fetch_assoc($result_group)){	

	$month_year = date('M, Y', strtotime($row_group['year_inspected'].'-'.$row_group['month_inspected'].'-01'));
	$excel->place_value($col.$row,$month_year,'string'); 		 		
	$cell_range = 'A'.$row.':K'.$row; $excel->set_format($cell_range,$array_format_sub_content);
	$excel->merge_cells('A'.$row.':K'.$row);
	$excel->set_height($row,40);
	$row++;
	
	$capa_sql_where 		= 'WHERE (date_inspected LIKE "%'.$row_group['year_inspected'].'-'.sprintf("%02d", $row_group['month_inspected']).'%") AND logdel=0';
	$result_details	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);

	while($row_details = mysqli_fetch_assoc($result_details)){
		$attention 	= array();
		$custom_row_count[] = $row_details['pkid'];
		$att 		= explode(',',$row_details['attention']);
		foreach($att as $key => $value) {
			$attention[] = get_emp_name_by_username_systemone($value);
		}
		// echo "".$col.':'.$row."";
		$lon_no = $section.'-'.date('my', strtotime($row_details['date_time_created'])).'-'.$row_details['lon_ctr'];
		$excel->place_value($col.$row,$lon_no,'string'); 							$col++; 
		$excel->place_value($col.$row,date('M d, Y', strtotime($row_details['date_inspected'])),'string'); 	$col++; 	
		$excel->place_value($col.$row,$row_details['line'],'string'); 				$col++; 	
		$excel->place_value($col.$row,$row_details['device_name'],'string'); 		$col++; 	
		$excel->place_value($col.$row,$row_details['factory_location'],'string'); 	$col++;
		$excel->place_value($col.$row,$row_details['lot_number'],'string'); 		$col++;
		$excel->place_value($col.$row,$row_details['defect_mode'],'string'); 		$col++;
		$excel->place_value($col.$row,$row_details['operator'],'string'); 		$col++;
		$excel->place_value($col.$row,$row_details['attention'],'string'); 		$col++;
		$excel->place_value($col.$row,$row_details['capa_due_date'],'string'); 		$col++;
		$excel->place_value($col.$row,'capa received date','string'); 		$col++;
		$excel->place_value($col.$row,'actual tat','string'); 		$col++;
		$excel->set_height($row,40);
		// $excel->merge_cells($col.$row.':'.$col.$row);
		$row++;		
		
		// $capa_sql_where 		= 'WHERE oqc_lon_id = '.$row_details['pkid'].'';
		// $result_details_tbl_oqc_lon_capa_monitoring	= TQTS::getInstance()->select_query($capa_array_fields,$capa_table,$capa_joins,$capa_sql_where,$capa_sql_order,$capa_sql_limit);
		// $script_details_tbl_oqc_lon_capa_monitoring	= TQTS::getInstance()->select_query_script($capa_array_fields,$capa_table,$capa_joins,$capa_sql_where,$capa_sql_order,$capa_sql_limit);
		// $return_tbl_oqc_lon_capa_monitoring = array();
		// while($row_tbl_oqc_lon_capa_monitoring = mysqli_fetch_assoc($result_details_tbl_oqc_lon_capa_monitoring)){
		// 		$excel->place_value('L'.$row,$row_tbl_oqc_lon_capa_monitoring['oqc_capa_action'],'string');
		// 	$row++;		
		// }
		// echo (count($tbl_oqc_lon_capa_monitoring_by_id['oqc_capa_action']));
 
		// while ($row__oqc_lon_capa_monitoring_by_id = count($tbl_oqc_lon_capa_monitoring_by_id['oqc_capa_action'])) {
		// 	echo $row__oqc_lon_capa_monitoring_by_id['oqc_capa_action'];
		// }
		
		// $excel->place_value($col.$row,implode(' / ',$attention),'string'); 			$col++;
		// $excel->place_value($col.$row,get_emp_name_by_username_systemone($row_details['created_by']),'string'); $col++; 	
		// $excel->place_value($col.$row,date('M d, Y', strtotime($row_details['capa_due_date'])),'string'); 		$col++; 	
		// $excel->place_value($col.$row,date('M d, Y', strtotime($row_details['date_inspected'])),'string'); 		$col++; 	
		// $excel->place_value($col.$row,check_capa_creation($row_details['pkid'], $oop),'string'); 		$col++; 	
		// $excel->place_value($col.$row,$row_details['status'],'string'); 		$col++; 	
	
		// while($tbl_oqc_lon_capa_monitoring_by_id){
		// 	$col = 'A'; $row++;		
		// }
		
	}
	// echo $col.$first_row.':'.$col.$last_row;
}

// var_dump(count($tbl_oqc_lon_capa_monitoring_by_id['oqc_capa_action']));
//$tbl_oqc_lon_capa_monitoring_by_id = get_tbl_oqc_lon_capa_monitoring_by_id($row_details['pkid']);

// exit;
/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/

/* set file name */
// $filename = $section.' LON Summary List as of '.$date_from.' to '.$date_to;
$filename = 'FY 2024 Lot Out Notice (LON) SUMMARY MONITORING_TS Section';
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

?>