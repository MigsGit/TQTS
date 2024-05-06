<?php
$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$array_fields 	= array('pkid','measurescope_no', 'meas_year_month', 'measurescope_file', 'checked_by', 'date_time_checked', 'approved_by', 'date_time_approved');
$table 	   		= 'tbl_ipqc_pre_production';
$joins 	   		= '';
$sql_where 		= $_GET['wh'];
$sql_order 		= 'ORDER BY `measurescope_no` ASC';
$sql_limit 		= '';
$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return 		= array();
while($row = mysqli_fetch_array($result)){
	$return['pkid'][] 				= $row['pkid'];
	$return['measurescope_no'][] 	= $row['measurescope_no'];
	$return['meas_year_month'][]	= $row['meas_year_month'];
	$return['measurescope_file'][]	= $row['measurescope_file'];
	$return['checked_by'][] 		= get_report_approvers($row['checked_by']);
	$return['date_time_checked'][]	= $row['date_time_checked'] == '' ? '' : "\n".date('M d, Y', strtotime($row['date_time_checked']));
	$return['approved_by'][]		= get_report_approvers($row['approved_by']);
	$return['date_time_approved'][] = $row['date_time_approved'] == '' ? '' : "\n".date('M d, Y', strtotime($row['date_time_approved']));
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
$excel->title = 'Pre-production';
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
$excel->set_width('B',$width_allowance+28.43);
$excel->set_width('C',$width_allowance+28.86);
$excel->set_width('D',$width_allowance+28.86);
$excel->set_width('E',$width_allowance+40.71);

/* header */
/* Row 2 */
$excel->merge_cells('A3:E3');
$excel->place_value('A3','XY MEASURESCOPE INSPECTION SHEET','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 18,
	"bold" 			=> true,
	"h_alignment"	=> "center"
);
$excel->set_format('A1',$array_format);

/* Row 11 */
$array_values 	 = array(
	"A3" => 'Measurescope #',
	"B3" => 'Month - Year',
	"C3" => 'Checked by',
	"D3" => 'Approved By',
	"E3" => 'Measurescope File'
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
$excel->set_format('A3:E3',$array_format);
$excel->set_borders('A3:E3','1','1','1','1');
$excel->set_outline_borders('A3:E3','medium');

$row_cnt = 4;
$row_start = 4;
$month_compare = '';
foreach($return['pkid'] as $key => $value){
	$excel->place_value('A'.$row_cnt,$return['measurescope_no'][$key],'string');
	$excel->place_value('B'.$row_cnt,date('M-Y',strtotime($return['meas_year_month'][$key])),'string');
	$excel->place_value('C'.$row_cnt,$return['checked_by'][$key].$return['date_time_checked'][$key],'string');
	$excel->place_value('D'.$row_cnt,$return['approved_by'][$key].$return['date_time_approved'][$key],'string');
	$excel->place_value('E'.$row_cnt,$return['measurescope_file'][$key],'string');
	$array_format = array(
		"name" 			=> 'Arial',
		"size" 			=> 12
	);
	$excel->set_format('A'.$row_start.':E'.$row_cnt,$array_format);
	$row_cnt++;
}
$excel->set_borders('A'.$row_start.':E'.($row_cnt-1),'1','1','1','1');

/* set file name */
$filename = "Pre-production Summary";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>
