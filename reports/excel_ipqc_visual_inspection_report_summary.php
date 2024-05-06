<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$category_parts 	= array();
$category_device 	= array();

$array_fields 	= array('pkid', 'status', 'operators_category', 'line_number', 'station', 'fiscal_year', 'workweek', 'shift', 'checked_by', 'date_time_checked','checked_by_remarks');
$table 	   		= 'tbl_ipqc_visual_inspection';
$joins 	   		= '';
$sql_where 		= urldecode($_GET['wh']);
$sql_order 		= 'ORDER BY `fiscal_year`,`workweek` ASC';
$sql_limit 		= '';
$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return 		= array();
while($row = mysqli_fetch_array($result)){
	$return['pkid'][] 					= $row['pkid'];
	$return['status'][] 				= $row['status'];
	$return['operators_category'][] 	= $row['operators_category'];
	$return['line_number'][]			= $row['line_number'];
	$return['station'][]				= $row['station'];
	$return['fiscal_year'][]			= $row['fiscal_year'];
	$return['workweek'][]				= $row['workweek'];
	$return['shift'][]					= $row['shift'];
	$return['checked_by'][] 			= get_report_approvers($row['checked_by']);
	$return['date_time_checked'][]		= $row['date_time_checked'] == '' ? '' : "\n".date('M d, Y', strtotime($row['date_time_checked']));
	$return['checked_by_remarks'][]		= $row['checked_by_remarks'];
}

function get_report_approvers($approver_username) {
	require_once('../class/oop_tqts.php');
	$approver_name = '';
	$array_fields = array('approver_name');
	$table 	   	= 'tbl_report_approvers';
	$joins 	   	= '';
	$sql_where 	= 'WHERE approver_username="'.$approver_username.'"';
	$sql_order 	= '';
	$sql_limit 	= '';
	$html_select= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row=mysqli_fetch_array($result)) {
		$approver_name = $row['approver_name'];
	} 
	return $approver_name;
}

/* Do excel here */
$excel_class = '../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}

$excel = new EXCEL;
/* set title */
$excel->title = 'IPQC';
/* add a new page */
$excel->add_page();
$excel->set_page_orientation_a4_landscape();
/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

$excel->set_margin();
$excel->set_print_area();

$width_allowance = .81;

/* set width */
$excel->set_width('A',$width_allowance+18.86);
$excel->set_width('B',$width_allowance+18.43);
$excel->set_width('C',$width_allowance+18.43);
$excel->set_width('D',$width_allowance+18.43);
$excel->set_width('E',$width_allowance+18.43);
$excel->set_width('F',$width_allowance+18.43);
$excel->set_width('G',$width_allowance+18.43);
$excel->set_width('H',$width_allowance+28.86);
$excel->set_width('I',$width_allowance+28.86);
$excel->set_width('J',$width_allowance+40.71);

/* header */
/* Row 2 */
$excel->merge_cells('A1:J1');
$excel->place_value('A1','IPQC In-line Quality Control Report Summary','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 18,
	"bold" 			=> true,
	"h_alignment"	=> "center"
);
$excel->set_format('A1',$array_format);

/* Row 11 */
$array_values 	 = array(
	"A3" => 'Status',
	"B3" => 'Category',
	"C3" => 'Line Number',
	"D3" => 'Station',
	"E3" => 'FY',
	"F3" => 'WW',
	"G3" => 'Shift',
	"H3" => 'Checked by',
	"I3" => 'Date Checked',
	"J3" => 'Remarks'
);
foreach($array_values as $key => $value){
	$excel->place_value($key,$value,'string');
}
$array_format = array(
	"name" 			=> 'Arial',
	"fill_color"	=> 'ffff99',
	"size" 			=> 12,
	"wordwrap"		=> true,
	"h_alignment" 	=> 'center'
);
$excel->set_format('A3:J3',$array_format);
$excel->set_borders('A3:J3','1','1','1','1');
$excel->set_outline_borders('A3:J3','medium');

$row_cnt = 4;
$row_start = 4;
$month_compare = '';
foreach($return['pkid'] as $key => $value){
	$excel->place_value('A'.$row_cnt,$return['status'][$key],'string');
	$excel->place_value('B'.$row_cnt,$return['operators_category'][$key],'string');
	$excel->place_value('C'.$row_cnt,$return['line_number'][$key],'string');
	$excel->place_value('D'.$row_cnt,$return['station'][$key],'string');
	$excel->place_value('E'.$row_cnt,$return['fiscal_year'][$key],'string');
	$excel->place_value('F'.$row_cnt,$return['workweek'][$key],'string');
	$excel->place_value('G'.$row_cnt,$return['shift'][$key],'string');
	$excel->place_value('H'.$row_cnt,$return['checked_by'][$key],'string');
	$excel->place_value('I'.$row_cnt,$return['date_time_checked'][$key],'string');
	$excel->place_value('J'.$row_cnt,$return['checked_by_remarks'][$key],'string');
	$array_format = array(
		"name" 			=> 'Arial',
		"size" 			=> 12
	);
	$excel->set_format('A'.$row_start.':J'.$row_cnt,$array_format);
	$row_cnt++;
}
// $excel->set_borders('A'.$row_start.':J'.($row_cnt-1),'1','1','1','1');

/* set file name */
$filename = "IPQC In-line Quality Control Report Summary";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
