<?php
// $cookie_name = 'download_type';
// $cookie_value = 'download_sa_report';
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$oop = '../../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}

$oop = '../../handler/common_function.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$sar_summary_date_from = $_GET['sar_summary_date_from'];
$sar_summary_date_to =  $_GET['sar_summary_date_to'];

if(date('m', strtotime($sar_summary_date_from)) >= 4 && date('m', strtotime($sar_summary_date_from) <= 12)) {
	$fiscal_year 	= 'FY'.date('Y', strtotime($sar_summary_date_from));
} else {
	$fiscal_year 	= 'FY'.date('Y', strtotime($sar_summary_date_from.'-1 year'));
}

/* Group by Year and month data */
$array_fields 	= array('YEAR(date_created) AS year_inspected', 'MONTH(date_created) AS month_inspected');
$table 	   		= 'tbl_qfr_special_acceptance';
$joins 	   		= '';
// $sql_where 		= 'WHERE 1=1';
// $sql_where  .= " AND DATE(`date_created`) BETWEEN ' " .date('Y-m-d', strtotime($sar_summary_date_from)). " ' AND ' " .date('Y-m-d', strtotime($sar_summary_date_to)). " ' ";
$sql_where 		= ' WHERE (date_created BETWEEN "'.$sar_summary_date_from.'-01" AND "'.$sar_summary_date_to.'-31") AND logdel=0';
// $sql_where  .= " AND DATE(`date_created`) BETWEEN ' ".date('Y-m-d', strtotime($sar_summary_date_from))." ' AND ' ".date('Y-m', strtotime($sar_summary_date_to)). "-31 ' ";
$sql_order 		= '';
$sql_limit 		= 'GROUP BY YEAR(date_created), MONTH(date_created)';
$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$result_group 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// $sar_details_sql_array_fields = array('MONTHNAME( `date_created` ) as created_at , sar.* ,sar_treatment.disposition');

$sar_details_sql_array_fields = array('sar.*','sar_treatment.disposition');
$sar_details_sql_table 	   	= 'tbl_qfr_special_acceptance sar';
$sar_details_sql_joins 	   	= 'LEFT JOIN tbl_qrf_sa_treatment sar_treatment ON sar_treatment.fkid = sar.pkid';
// $table 	   		= 'tbl_oqc_lon lon';
// $joins 	   		= 'LEFT JOIN tbl_oqc_lon_production lon_production ON lon_production.fklon = lon.pkid';
$sar_details_sql_order 	   	= 'ORDER BY date_created';
$sar_details_sql_limit 	   	= '';
// $sar_details_sql_where 	= 'WHERE 1=1';
// $sar_details_sql_where 	.= ' AND sar.status="CL"';
// $sar_details_sql_where 	.= ' AND sar_treatment.logdel=0 AND sar_treatment.disposition IS NOT NULL';
// $sar_details_script= TQTS::getInstance()->select_query_script($sar_details_sql_array_fields,$sar_details_sql_table,$sar_details_sql_joins,$sar_details_sql_where,$sar_details_sql_order,$sar_details_sql_limit);
// $sar_details_result= TQTS::getInstance()->select_query($sar_details_sql_array_fields,$sar_details_sql_table,$sar_details_sql_joins,$sar_details_sql_where,$sar_details_sql_order,$sar_details_sql_limit);
// while($sar_details_row = mysqli_fetch_array($sar_details_result)){
// 	echo $sar_details_row['pkid'];
// }
// return;
// $sar_details_result= TQTS::getInstance()->select_query($sar_details_sql_array_fields,$sar_details_sql_table,$sar_details_sql_joins,$sar_details_sql_where,$sar_details_sql_order,$sar_details_sql_limit);

function getTblSarTreatmentByFkid($fkid){
	$array_fields 	= array('disposition');
	$table 	   		= 'tbl_qrf_sa_treatment';
	$joins 	   		= '';
	$sql_where 		= 'WHERE 1=1';
	$sql_where 		= ' AND fkid = '.$fkid.' AND logdel = 0 AND disposition IS NOT NULL';
	$sql_order 		= '';
	$sql_limit 		= '';
	$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		return $row['disposition'];
	}
}
// return;
$excel_class = '../../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}

$excel = new EXCEL;

/* set title */
$excel->title = 'Special Acceptance';
/* add a new page */
$excel->add_page();


/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

$excel->set_margin();
$excel->set_print_area();

$width_allowance = 25;
$height_allowance = 38;
$height_allowance_for_date = 20;

/* set width */
$excel->set_width('A',$width_allowance);
$excel->set_width('B',$width_allowance);
$excel->set_width('C',$width_allowance);
$excel->set_width('D',$width_allowance);
$excel->set_width('E',$width_allowance+5);
$excel->set_width('F',$width_allowance);
$excel->set_width('G',$width_allowance);
$excel->set_width('H',$width_allowance);
$excel->set_width('I',$width_allowance);
$excel->set_width('J',$width_allowance);
$excel->set_width('K',$width_allowance);
$excel->set_width('L',$width_allowance);
$excel->set_width('M',$width_allowance);
$excel->set_width('N',$width_allowance);
$excel->set_width('O',$width_allowance);

//MERGE CELLS
$excel->merge_cells('A1:N1');
$excel->merge_cells('A8:A9');
$excel->merge_cells('B8:B9');
$excel->merge_cells('C8:C9');
$excel->merge_cells('E8:E9');
$excel->merge_cells('F8:F9');
$excel->merge_cells('G8:G9');
$excel->merge_cells('H8:H9');
$excel->merge_cells('I8:I9');
$excel->merge_cells('J8:J9');
$excel->merge_cells('K8:K9');
$excel->merge_cells('L8:L9');
$excel->merge_cells('M8:M9');
$excel->merge_cells('N8:N9');
$excel->merge_cells('O8:O9');

// $excel->set_borders('A8:O9',1,1,1,1);

//FONT FORMAT
$array_header = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 11,
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
$array_format_date = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 11,
	'fill_color'  => "FFB6C1",
);
$array_format_sub_content = array(
	"size"	=> 12,
	"h_alignment"	=> "left",
	'fill_color'  => "FF99cc"
);

$array_format_value_sar = array(
	"size"	=> 11,
	"h_alignment"	=> "left"
);
$cell_range = 'A1:O1'; $excel->set_format($cell_range,$array_header);
$cell_range = 'A8:O9'; $excel->set_format($cell_range,$array_format_subheader);
$cell_range = 'M5:M6'; $excel->set_format($cell_range,$array_format_subheader_right);
//WRAP TEXT
$excel->wrap_text('C');
$excel->wrap_text('C8');
$excel->wrap_text('H8');
$excel->wrap_text('J8');
//PLACE VALUE HEADER             
$section	= return_system_division();
$col = 'A'; $row = '1';   $excel->place_value($col.$row,$fiscal_year.' SAR SUMMARY MONITORING_'.$section.'_Section','string');
$excel->place_value('A8','Control Number','string');
$excel->place_value('B8','Date Issued','string');
$excel->place_value('C8','Part Name / Series Name / Machine Name','string');
$excel->place_value('D8','Location','string');
$excel->place_value('D9','(Cabuyao or Malvar)','string');
$excel->place_value('E8','Problem / Mode of defects','string');
$excel->place_value('F8','Issued By (Name)','string');
$excel->place_value('G8','Issued By (Section)','string');
$excel->place_value('H8','Customer Approval (YEC or End user)','string');
$excel->place_value('I8','Disposition','string');
$excel->place_value('J8','Specify the details of "OTHERS" disposition','string');
$excel->place_value('K8','Immediate Action','string');
$excel->place_value('L8','Due date / ICP','string');
$excel->place_value('M8','Permanent Action ','string');
$col = 'M'; $row = '4';   $excel->place_value($col.$row,'Legend:                               Please update month','string');
$col = 'M'; $row = '5';   $excel->place_value($col.$row,'****','string');
$col = 'M'; $row = '6';   $excel->place_value($col.$row,'**','string');
$excel->place_value('N8','Due date / ICP','string');
$col = 'N'; $row = '3';   $excel->place_value($col.$row,'PQS-I01-024','string');
$col = 'N'; $row = '5';   $excel->place_value($col.$row,' Please update current Fiscal Year','string');
$col = 'N'; $row = '6';   $excel->place_value($col.$row,'Please update section name','string');
$excel->place_value('O8','Status','string');






$custom_data_row = 10;
$custom_col = 'A';
while($row_group = mysqli_fetch_assoc($result_group)){	
	//FORMAT
	$cell_range = 'A'.$custom_data_row.':O'.$custom_data_row; $excel->set_format($cell_range,$array_format_sub_content);
	$excel->set_borders($cell_range,1,1,1,1, "thin"); //Column Header
	$excel->merge_cells('A'.$custom_data_row.':O'.$custom_data_row);
	$excel->set_height($custom_data_row,40);
	//PLACE VALUE DATE
	$month_year = date('M, Y', strtotime($row_group['year_inspected'].'-'.$row_group['month_inspected'].'-01'));
	$excel->place_value($custom_col.$custom_data_row,$month_year,'string'); 		
	$custom_data_row++;

	// $sar_details_sql_where 	= 'WHERE 1=1';
	$sar_details_sql_where 		= ' WHERE (sar.date_created LIKE "%'.$row_group['year_inspected'].'-'.sprintf("%02d", $row_group['month_inspected']).'%")';
	// $sar_details_sql_where 		.= ' sar.status="CL" AND sar.logdel=0';
	// $sar_details_sql_where 		.= ' AND sar_treatment.logdel = 0';
	$sar_details_script= TQTS::getInstance()->select_query_script($sar_details_sql_array_fields,$sar_details_sql_table,$sar_details_sql_joins,$sar_details_sql_where,$sar_details_sql_order,$sar_details_sql_limit);
	$sar_details_result= TQTS::getInstance()->select_query($sar_details_sql_array_fields,$sar_details_sql_table,$sar_details_sql_joins,$sar_details_sql_where,$sar_details_sql_order,$sar_details_sql_limit);
	$lowest_row =null;
	$highest_row =null;
<<<<<<< HEAD
	// var_dump($sar_details_script);
	while($sar_details_row = mysqli_fetch_assoc($sar_details_result)){
		echo $sar_details_script;
		// echo $sar_details_row['control_number'];
		$excel->set_height($custom_data_row,40);

		//PLACE VALUE SAR DETAILS
		$excel->place_value($custom_col.$custom_data_row,$sar_details_row['control_number'],'string'); $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,getDateFormat($sar_details_row['date_issued']),'date_format');  $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,( $sar_details_row['device_name'] != "" ? $sar_details_row['device_name'] : $sar_details_row['parts_affected_parts']),'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,$sar_details_row['factory_location'],'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,$sar_details_row['problem'],'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,get_emp_name_by_username_systemone($sar_details_row['created_by']),'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row, get_assigned_section($sar_details_row['created_by']),'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,$sar_details_row['supplier'],'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,'DISPOSITION','string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,( $sar_details_row['other_details'] != "" ) ? $sar_details_row['other_details'] : "N/A" ,'string' );   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,( $sar_details_row['immediate_action'] != "" ) ? $sar_details_row['immediate_action'] : "N/A" ,'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,( $sar_details_row['immediate_action_due_date']  != "" ) ? getDateFormat($sar_details_row['immediate_action_due_date']) : "N/A",'date_format');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,( $sar_details_row['permanent_action'] != "") ? $sar_details_row['permanent_action'] : "N/A" ,'string');   $custom_col++;
		// $excel->place_value($custom_col.$custom_data_row,( $sar_details_row['permanent_action_due_date']  != "" ) ? getDateFormat($sar_details_row['permanent_action_due_date']) : "N/A",'date_format');   $custom_col++;
=======
	$arr_custom_col =array();
	$arr_custom_data_row =array();
	while($sar_details_row = mysqli_fetch_array($sar_details_result)){
		//PLACE VALUE SAR DETAILS
		$excel->place_value($custom_col.$custom_data_row,$sar_details_row['control_number'],'string'); $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,$sar_details_row['date_issued'],'string');  $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,( $sar_details_row['device_name'] != "" ? $sar_details_row['device_name'] : $sar_details_row['parts_affected_parts']),'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,$sar_details_row['factory_location'],'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,$sar_details_row['problem'],'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,get_emp_name_by_username_systemone($sar_details_row['created_by']),'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row, get_assigned_section($sar_details_row['created_by']),'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,'SUPPLIER','string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,'DISPOSITION','string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,( $sar_details_row['other_details'] != "" ) ? $sar_details_row['other_details'] : "N/A" ,'string' );   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,( $sar_details_row['immediate_action'] != "" ) ? $sar_details_row['immediate_action'] : "N/A" ,'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,( $sar_details_row['immediate_action_due_date']  != "" ) ? $sar_details_row['immediate_action_due_date'] : "N/A",'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,( $sar_details_row['permanent_action'] != "") ? $sar_details_row['permanent_action'] : "N/A" ,'string');   $custom_col++;
		$excel->place_value($custom_col.$custom_data_row,( $sar_details_row['permanent_action_due_date']  != "" ) ? $sar_details_row['permanent_action_due_date'] : "N/A",'string');   $custom_col++;
>>>>>>> parent of 2717f35 (Add Date Issued in SAR NGR)
		if ($lowest_row === null || $highest_row === null) {
			$lowest_row = $custom_data_row;
		}
		$highest_row = $custom_data_row;
		$custom_col = 'A';
		$custom_data_row++;
	}

	//FORMAT
	$custom_cell_range = $custom_col.$lowest_row.':'.$custom_col.$highest_row;
	$cell_range = 'A'.$lowest_row.':'.'A'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'B'.$lowest_row.':'.'B'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'C'.$lowest_row.':'.'C'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'D'.$lowest_row.':'.'D'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'E'.$lowest_row.':'.'E'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'F'.$lowest_row.':'.'F'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'G'.$lowest_row.':'.'G'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'H'.$lowest_row.':'.'H'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'I'.$lowest_row.':'.'I'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'J'.$lowest_row.':'.'J'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'K'.$lowest_row.':'.'K'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'L'.$lowest_row.':'.'L'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'M'.$lowest_row.':'.'M'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'N'.$lowest_row.':'.'N'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
	$cell_range = 'O'.$lowest_row.':'.'O'.$highest_row; $excel->set_format($cell_range,$array_format_value_sar);
	$excel->set_borders($cell_range,1,1,1,1, "thin");
}
return;
$col = 'A'; $row = '1';
$excel->set_height('2',15.00);
$pmi_logo	= '../../images/pmi-logo2.png';
$excel->add_image($col.$row,$pmi_logo,'26px');

$col = 'A'; $row = '3';
$excel->set_height('2',15.00);
$pmi_logo	= '../../images/sar_format.png';
$excel->add_image($col.$row,$pmi_logo,'85px');

/* output excel - filename, excel version (2003,2007) */
$filename = $fiscal_year.' SAR SUMMARY MONITORING_'.$section.'_Section.xls';
$excel->output($filename,'2003');
exit;
?>
