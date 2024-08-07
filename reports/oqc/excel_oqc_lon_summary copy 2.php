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
	//FY 2024 Lot Out Notice (LON) SUMMARY MONITORING_TS Section           
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
$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$result_group 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//TODO: daysWithoutSundays
function daysWithoutSundays($date_from, $date_to) {
    $start = new DateTime($date_from);
    $end = new DateTime($date_to);
    $end->modify('+1 day');

    $daysCount = 0;
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($start, $interval, $end);

    foreach ($period as $date) {
        if ($date->format('N') != 7) {
            $daysCount++;
        }
    }
    return $daysCount;
}
function getDateFormat($date) {
	// return $date;
	$is_date_exist = $date != "" ? 'true' : 'false';
	if($is_date_exist == 'true'){
		$date = date( 'd-M-y', strtotime( $date ) ) ;
	}else{
		$date = "";
	}
    return $date;
}

/* Details data */
$array_fields 	= array('lon.*','lon_production.date_time_created AS capa_report_received_date');
$table 	   		= 'tbl_oqc_lon lon';
$joins 	   		= 'LEFT JOIN tbl_oqc_lon_production lon_production ON lon_production.fklon = lon.pkid';
$sql_order 		= 'ORDER BY lon.date_inspected';
$sql_limit 		= '';
$return = array();

$capa_array_fields 		= array('*');
$capa_table 	   		= 'tbl_oqc_lon_capa_monitoring';
$capa_joins 	   		= '';
$capa_sql_order 		= '';
$capa_sql_limit 		= '';
// $sql_where 		= 'WHERE (lon.date_inspected LIKE "%'.$row_group['year_inspected'].'-'.sprintf("%02d", $row_group['month_inspected']).'%") AND lon.logdel=0';
// $sql_where 		.= ' AND lon_production.logdel = 0';
// $result_details	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// echo json_encode($result_details);
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

$array_format_subheader_right = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 20,
	"h_alignment"	=> "right"
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

$array_format_value = array(
	"size"	=> 11,
	"h_alignment"	=> "center"
);
$array_format_value_capa_monitoring = array(
	"size"	=> 11,
	"h_alignment"	=> "left"
);
$cell_range = 'A8:T8'; $excel->set_format($cell_range,$array_format_subheader);
$cell_range = 'A1:K1'; $excel->set_format($cell_range,$array_format_header);
$cell_range = 'M9:R9'; $excel->set_format($cell_range,$array_format_subheader);
$cell_range = 'R5:R6'; $excel->set_format($cell_range,$array_format_subheader_right);

/* set width */
$width_allowance = 10;
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
$excel->set_width('M',$width_allowance+70);
$excel->set_width('N',$width_allowance+10);
$excel->set_width('O',$width_allowance+10);
$excel->set_width('P',$width_allowance+10);
$excel->set_width('Q',$width_allowance+10);
$excel->set_width('R',$width_allowance+15);
$excel->set_width('S',$width_allowance+25);
$excel->set_width('T',$width_allowance+15);

/* set height */
$arr_custom_height = array('1','2','3','4','5','6','7','8','9');
for($i=0; $i<count($arr_custom_height); $i++) {
	$excel->set_height($arr_custom_height[$i],30);
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
$excel->wrap_text('A3:A3');
$excel->wrap_text('C8:T8');
$excel->wrap_text('M9:T9');


/* Border */
$cell = 'A8:T9'; $excel->set_borders($cell,1,1,1,1, "thin"); //Column Header


/* Image */
$col = 'A'; $row = '1';
$pmi_logo	= '../../images/pmi-logo2.png';
$excel->add_image($col.$row,$pmi_logo,'28px');

$col = 'A'; $row = '4';
$excel->set_height('2',15.00);
$pmi_logo	= '../../images/oqc_lon_ctr_no_format.png';
$excel->add_image($col.$row,$pmi_logo,'100px');

$section	= return_system_division();
$col = 'A'; $row = '1';   $excel->place_value($col.$row,$fiscal_year.'_Lot-out summary monitoring'.$section.'_Section','string');
$col = 'A'; $row = '3';   $excel->place_value($col.$row,'LON control numbering','string');
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
$col = 'R'; $row = '5';   $excel->place_value($col.$row,'****','string');
$col = 'R'; $row = '6';   $excel->place_value($col.$row,'**','string');
$col = 'R'; $row = '4';   $excel->place_value($col.$row,'Legend:                               Please update month','string');
$col = 'Q'; $row = '9';   $excel->place_value($col.$row,'Actual Submission Date','string');
$col = 'S'; $row = '8';   $excel->place_value($col.$row,'Remarks','string');
$col = 'S'; $row = '5';   $excel->place_value($col.$row,' Please update current Fiscal Year','string');
$col = 'S'; $row = '6';   $excel->place_value($col.$row,'Please update section name','string');
$col = 'T'; $row = '8';   $excel->place_value($col.$row,'Status','string');
$col = 'T'; $row = '3';   $excel->place_value($col.$row,'PQS-I01-028','string');


/* Set data value */
$col = 'A';
$row = 10;
//Column A-T :MONTH YEAR
while($row_group = mysqli_fetch_assoc($result_group)){	
	//Excel Format
	$cell_range = 'A'.$row.':T'.$row; $excel->set_format($cell_range,$array_format_sub_content);
	$excel->set_borders($cell_range,1,1,1,1, "thin"); //Column Header

	$excel->merge_cells('A'.$row.':T'.$row);
	$excel->set_height($row,50);
	//PLACE VALUE
	$month_year = date('M, Y', strtotime($row_group['year_inspected'].'-'.$row_group['month_inspected'].'-01'));
	$excel->place_value($col.$row,$month_year,'string'); 		
	$row++;
	//Column A-L :for OQC LON
	$sql_where 		= 'WHERE (lon.date_inspected LIKE "%'.$row_group['year_inspected'].'-'.sprintf("%02d", $row_group['month_inspected']).'%") AND lon.logdel=0 AND lon.status="CONFORMED BY OQC INSPECTOR"';
	$sql_where 		.= ' AND lon_production.logdel = 0';
	$result_details	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row_details = mysqli_fetch_assoc($result_details)){
		// var_dump($script) ;
		$custom_row_count = $row_details['pkid'];
		$arr_attention 	= array();
		$attention 		= explode(',',$row_details['attention']);
		$operator 		= explode(',',$row_details['operator']);
		foreach($attention as $key => $value_attention) {
			$arr_attention[] = get_emp_name_by_username_systemone($value_attention);
		}
		$lon_no = $section.'-'.date('my', strtotime($row_details['date_time_created'])).'-'.$row_details['lon_ctr'];
		//PLACE VALUE
		$excel->place_value($col.$row,$lon_no,'string'); 							$col++; 
		$excel->place_value($col.$row,getDateFormat($row_details['date_inspected']),'date_format'); 	$col++; 	
		$excel->place_value($col.$row,$row_details['line'],'string'); 				$col++; 	
		$excel->place_value($col.$row,$row_details['device_name'],'string'); 		$col++; 	
		$excel->place_value($col.$row,$row_details['factory_location'],'string'); 	$col++;
		$excel->place_value($col.$row,$row_details['lot_number'],'number_0_decimal'); 		$col++;
		$excel->place_value($col.$row,$row_details['defect_mode'],'string'); 		$col++;
		$excel->place_value($col.$row,implode(' / ',$operator),'string'); 		$col++;
		$excel->place_value($col.$row,implode(' / ',$arr_attention),'string'); 		$col++;
		$excel->place_value($col.$row,getDateFormat($row_details['capa_due_date']),'date_format'); 		$col++;
		$excel->place_value($col.$row,getDateFormat($row_details['capa_report_received_date']),'date_format'); 		$col++;
		$excel->place_value($col.$row,'daysWithoutSundays','string'); 		$col++;
		$col = 'A';
		//Column H-T :for OQC CAPA Monitoring
		$capa_sql_where 		= 'WHERE oqc_lon_id = '.$row_details['pkid'].'';
		$script_details_tbl_oqc_lon_capa_monitoring_script	= TQTS::getInstance()->select_query_script($capa_array_fields,$capa_table,$capa_joins,$capa_sql_where,$capa_sql_order,$capa_sql_limit);
		$result_details_tbl_oqc_lon_capa_monitoring	= TQTS::getInstance()->select_query($capa_array_fields,$capa_table,$capa_joins,$capa_sql_where,$capa_sql_order,$capa_sql_limit);
		// $return_tbl_oqc_lon_capa_monitoring = array();
		$lowest_row = null;
		$highest_row = null;
		while($row_tbl_oqc_lon_capa_monitoring = mysqli_fetch_assoc($result_details_tbl_oqc_lon_capa_monitoring)){
			// echo $script_details_tbl_oqc_lon_capa_monitoring_script;
			//Excel Format
			$excel->set_height($row,50);
			// SET lowest_row INSIDE the condition & Set highest_row OUTSIDE the condition
			if ($lowest_row === null || $highest_row === null) {
				$lowest_row = $row;
			}
			$highest_row = $row;
			
			$cell_range = 'M'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'N'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'O'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'P'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'Q'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'R'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'S'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");
			$cell_range = 'T'.$row; $excel->set_format($cell_range,$array_format_value_capa_monitoring);
			$excel->set_borders($cell_range,1,1,1,1, "thin");

			//PLACE VALUE CAPA MONITORING
			$arr_oqc_capa_action_incharge 	= array();
			$oqc_capa_action_incharge = explode(',',$row_tbl_oqc_lon_capa_monitoring['oqc_capa_action_incharge']);
			foreach($oqc_capa_action_incharge as $key => $value) {
				$arr_oqc_capa_action_incharge[] = get_emp_name_by_username_systemone($value);
			}
			if($row_tbl_oqc_lon_capa_monitoring['oqc_capa_req_sub_date'] !="" && $row_tbl_oqc_lon_capa_monitoring['oqc_capa_actual_sub_date'] != ""){
				$capa_evidence_status = 'CLOSED';
			}else{
				$capa_evidence_status = 'OPEN';
			}
			$excel->place_value('M'.$row,$row_tbl_oqc_lon_capa_monitoring['oqc_capa_action'],'string');
			// $excel->place_value('N'.$row,implode(' / ',$arr_oqc_capa_action_incharge),'string');
			$excel->place_value('N'.$row,implode(' / ',$arr_oqc_capa_action_incharge),'string');
			$excel->place_value('O'.$row,getDateFormat($row_tbl_oqc_lon_capa_monitoring['oqc_capa_due_date']),'date_format');	 	
			$excel->place_value('P'.$row,$row_tbl_oqc_lon_capa_monitoring['oqc_capa_status'],'string');
			$excel->place_value('Q'.$row,getDateFormat($row_tbl_oqc_lon_capa_monitoring['oqc_capa_req_sub_date']),'date_format'); 	
			$excel->place_value('R'.$row,getDateFormat($row_tbl_oqc_lon_capa_monitoring['oqc_capa_actual_sub_date']),'date_format');	 	
			$excel->place_value('S'.$row,$row_tbl_oqc_lon_capa_monitoring['oqc_capa_remarks'],'string');
			$excel->place_value('T'.$row,$capa_evidence_status,'string');
			$excel->wrap_text('M'.$row.':'.'T'.$row);
			$row++;	
		}
		// Excel Format
		// Column A-L :GET lowest_row INSIDE the condition & Set highest_row OUTSIDE the condition
		$cell_range = 'A'.$lowest_row.':'.'A'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'B'.$lowest_row.':'.'B'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'C'.$lowest_row.':'.'C'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'D'.$lowest_row.':'.'D'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'E'.$lowest_row.':'.'E'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'F'.$lowest_row.':'.'F'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'G'.$lowest_row.':'.'G'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'H'.$lowest_row.':'.'H'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'I'.$lowest_row.':'.'I'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'J'.$lowest_row.':'.'J'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'K'.$lowest_row.':'.'K'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");
		$cell_range = 'L'.$lowest_row.':'.'L'.$highest_row; $excel->set_format($cell_range,$array_format_value);
		$excel->set_borders($cell_range,1,1,1,1, "thin");

		$excel->merge_cells('A'.$lowest_row.':'.'A'.$highest_row);
		$excel->merge_cells('B'.$lowest_row.':'.'B'.$highest_row);
		$excel->merge_cells('C'.$lowest_row.':'.'C'.$highest_row);
		$excel->merge_cells('D'.$lowest_row.':'.'D'.$highest_row);
		$excel->merge_cells('E'.$lowest_row.':'.'E'.$highest_row);
		$excel->merge_cells('F'.$lowest_row.':'.'F'.$highest_row);
		$excel->merge_cells('G'.$lowest_row.':'.'G'.$highest_row);
		$excel->merge_cells('H'.$lowest_row.':'.'H'.$highest_row);
		$excel->merge_cells('I'.$lowest_row.':'.'I'.$highest_row);
		$excel->merge_cells('J'.$lowest_row.':'.'J'.$highest_row);
		$excel->merge_cells('K'.$lowest_row.':'.'K'.$highest_row);
		$excel->merge_cells('L'.$lowest_row.':'.'L'.$highest_row);
		$excel->wrap_text('A'.$lowest_row.':'.'L'.$highest_row);
	}

}
// return;
//$excel->set_borders('A'.$lowest_row.':'.'L'.$highest_row,1,1,1,1, "thin");
//$excel->wrap_text('A'.$lowest_row.':'.'L'.$highest_row);

/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/

/* set file name */
// $filename = $section.' LON Summary List as of '.$date_from.' to '.$date_to;
$filename = $fiscal_year.'_Lot-out summary monitoring'.$section.'_Section.xls';
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

?>