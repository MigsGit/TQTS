<?php
$oop 		= '../class/oop_tqts.php';
$handler 	= '../handler/common_function.php';
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

// $pkid = $_GET['id'];		
$pkid = 15;
$array_fields 	= array('*');
$table 	   		= ' tbl_iqc_qar';
$joins 	   		= '';
$sql_where 		= 'WHERE pkid="'.$pkid.'" AND logdel=0';
$sql_order 		= '';
$sql_limit 		= 'LIMIT 0,1';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return = array();
$sql_data = array();
while($row = mysqli_fetch_assoc($result)){
	$sql_data = $row;
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
$excel->title = 'Quality Alert Report';
/* add a new page */
$excel->add_page();
$excel->set_page_orientation_a4_landscape();
/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

$excel->set_margin();
$excel->set_print_area();

/* Row Styles */
$array_format = array(
	"bold"	=> true,
	"size"	=> 18,
	"h_alignment"	=> "center",
	"fill_color"	=> "ccffff"
);
$cell_range = 'A1:I4'; $excel->set_format($cell_range,$array_format);
$array_format = array(
	"h_alignment"	=> "center",
	"fill_color"	=> "ffff99"
);
$cell_range = 'A6:E7'; $excel->set_format($cell_range,$array_format);
$array_format = array(
	"h_alignment"	=> "right",
	"fill_color"	=> "ffff99"
);
$cell_range = 'F6:H7'; $excel->set_format($cell_range,$array_format);
$array_format = array(
	"h_alignment"	=> "left",
	"fill_color"	=> "ffff99"
);
$cell_range = 'I6:I7'; $excel->set_format($cell_range,$array_format);


$array_format_bold_left_fill_yellow = array(
	"bold"	=> true,
	"size"	=> 11,
	"h_alignment"	=> "left",
	"fill_color"	=> "ffff99"
);
$array_format_bold_center_fill_yellow = array(
	"bold"	=> true,
	"size"	=> 11,
	"h_alignment"	=> "center",
	"fill_color"	=> "ffff99"
);
$array_format_center = array(
	"h_alignment"	=> "center"
);
$cell_range = 'C6:E7'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'A16:I16'; $excel->set_format($cell_range,$array_format_bold_left_fill_yellow);
$cell_range = 'A17:I17'; $excel->set_format($cell_range,$array_format_bold_left_fill_yellow);
$cell_range = 'A26'; $excel->set_format($cell_range,$array_format_bold_left_fill_yellow);
$cell_range = 'A34'; $excel->set_format($cell_range,$array_format_bold_left_fill_yellow);
$cell_range = 'A42'; $excel->set_format($cell_range,$array_format_bold_left_fill_yellow);
$cell_range = 'A50:I50'; $excel->set_format($cell_range,$array_format_bold_center_fill_yellow);
$cell_range = 'A54:I54'; $excel->set_format($cell_range,$array_format_bold_center_fill_yellow);
$cell_range = 'A58'; $excel->set_format($cell_range,$array_format_bold_left_fill_yellow);
$cell_range = 'A17:I17'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'A27:I27'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'D27:I27'; $excel->set_format($cell_range,$array_format_center);

$width_allowance = .81;

/* set width */
$excel->set_width('A',$width_allowance+8);
$excel->set_width('B',$width_allowance+8);	
$excel->set_width('C',$width_allowance+14);	
$excel->set_width('D',$width_allowance+14);	
$excel->set_width('E',$width_allowance+14);	
$excel->set_width('F',$width_allowance+8);	
$excel->set_width('G',$width_allowance+8);	
$excel->set_width('H',$width_allowance+14);	
$excel->set_width('I',$width_allowance+14);
	
/* set height */
$excel->set_height('18',200);

/* Merge Cells */
$excel->merge_cells('A1:C4');
$excel->merge_cells('D1:I4');
$excel->merge_cells('A6:B7');
$excel->merge_cells('C6:E7');
$excel->merge_cells('F6:H6');
$excel->merge_cells('F7:H7');
$excel->merge_cells('B8:I8');
$excel->merge_cells('B9:I9');
$excel->merge_cells('B10:I10');
$excel->merge_cells('B11:I11');
$excel->merge_cells('A13:C13');
$excel->merge_cells('D13:I13');
$excel->merge_cells('A14:C14');
$excel->merge_cells('D14:I14');
$excel->merge_cells('A16:C16');
$excel->merge_cells('D16:I16');
$excel->merge_cells('A17:C17');
$excel->merge_cells('A18:C18');
$excel->merge_cells('D17:I17');
$excel->merge_cells('D18:I18');
$excel->merge_cells('A20:B20');
$excel->merge_cells('C20:I20');
$excel->merge_cells('A21:B21');
$excel->merge_cells('C21:I21');
$excel->merge_cells('A22:B22');
$excel->merge_cells('C22:I22');
$excel->merge_cells('A23:B23');
$excel->merge_cells('C23:I23');
$excel->merge_cells('A24:B24');
$excel->merge_cells('C24:I24');
$excel->merge_cells('A26:I26');
$excel->merge_cells('A27:C27');
$excel->merge_cells('F27:G27'); 
$excel->merge_cells('A34:I34'); 
$excel->merge_cells('A42:I42'); 
$excel->merge_cells('A50:E50'); 
$excel->merge_cells('F50:G50'); 
$excel->merge_cells('A54:E54'); 
$excel->merge_cells('F54:G54'); 
$excel->merge_cells('A58:I58'); 

/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/
$cell = 'A1:A69'; $excel->set_borders($cell,1,0,0,0, "medium");
$cell = 'I1:I69'; $excel->set_borders($cell,0,1,0,0, "medium");
$cell = 'A1:I1'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A69:I69'; $excel->set_borders($cell,0,0,0,1, "medium");
$cell = 'A4:I4'; $excel->set_borders($cell,0,0,0,1, "medium");
$cell = 'A6:I6'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A7:I7'; $excel->set_borders($cell,0,0,0,1, "medium");
$cell = 'A11:I11'; $excel->set_borders($cell,0,0,0,1, "medium");
$cell = 'A13:I13'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A14:I14'; $excel->set_borders($cell,0,0,0,1, "medium");
$cell = 'A16:I18'; $excel->set_borders($cell,1,1,1,1, "medium");
$cell = 'A26:I26'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A34:I34'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A42:I42'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A50:I50'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A54:I54'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'A58:I58'; $excel->set_borders($cell,0,0,1,0, "medium");
$cell = 'D1:D4'; $excel->set_borders($cell,1,0,0,0, "thin");
$cell = 'F6:F7'; $excel->set_borders($cell,1,0,0,0, "thin");
$cell = 'I6:I7'; $excel->set_borders($cell,1,0,0,0, "thin");
$cell = 'F6:I6'; $excel->set_borders($cell,0,0,0,1, "thin");
$cell = 'A26:I26'; $excel->set_borders($cell,0,0,0,1, "thin");
$cell = 'A34:I34'; $excel->set_borders($cell,0,0,0,1, "thin");
$cell = 'A42:I42'; $excel->set_borders($cell,0,0,0,1, "thin");
$cell = 'A50:I50'; $excel->set_borders($cell,0,0,0,1, "thin");
$cell = 'A54:I54'; $excel->set_borders($cell,0,0,0,1, "thin");
$cell = 'A59:I65'; $excel->set_borders($cell,0,0,1,1, "thin");


/* 
	Show default texts
*/

/* Row 2 */
$col = 'A'; $row = '1';
$excel->set_height(2.00);
$pmi_logo	= '../images/pmi-logo.png';
$excel->add_image($col.$row,$pmi_logo,'45px');

$col = 'D'; $row = '1';   $excel->place_value($col.$row,'Quality Alert Report','string');
$col = 'A'; $row = '6';   $excel->place_value($col.$row,'QAR Control No.:','string');

if($sql_data['date_conformed'] != ""){
	$col = 'C'; $row = 6; $excel->place_value($col.$row,'QAR-TS-'.$sql_data['section'].'-'.date('my',strtotime($sql_data['date_conformed'])).'-'.$sql_data['control_no_count'],'string');
}else{
	$col = 'C'; $row = 6; $excel->place_value($col.$row,'QAR-TS-'.$sql_data['section'].'-'.date('my',strtotime($sql_data['date_created'])).'-'.$sql_data['control_no_count'],'string');
}

$col = 'F'; $row = '6';   $excel->place_value($col.$row,'Date Issued:','string');
$col = 'F'; $row = '7';   $excel->place_value($col.$row,'CAPA Leadtime (TAT):','string');
$col = 'I'; $row = '6';   $excel->place_value($col.$row,date('d-M-Y',strtotime($sql_data['date_issued'])),'string');
$col = 'I'; $row = '7';   $excel->place_value($col.$row,'-NO VALUE DB-','string');
$col = 'A'; $row = '8';   $excel->place_value($col.$row,'To:','string');
$col = 'B'; $row = '8';   $excel->place_value($col.$row,$sql_data['to'],'string');

$attn = explode("|",$sql_data["attn"]);
$emp_name = array();
foreach($attn as $key => $username){
	$emp_info 	= get_emp_info_by_username_systemone($username);
	$emp_name[] = $emp_info['firstname']." ".$emp_info['lastname'][0].".";
}

$col = 'A'; $row = '9';   $excel->place_value($col.$row,'ATTN:','string');
$col = 'B'; $row = '9';   $excel->place_value($col.$row,implode(" / ",$emp_name),'string');

$cc = explode("|",$sql_data["cc"]);
$emp_name = array();
foreach($cc as $key => $username){
	$emp_info 	= get_emp_info_by_username_systemone($username);
	$emp_name[] = $emp_info['firstname']." ".$emp_info['lastname'][0].".";
}

$col = 'A'; $row = '10';   $excel->place_value($col.$row,'CC:','string');
$col = 'B'; $row = '10';   $excel->place_value($col.$row,implode(" / ",$emp_name),'string');
$col = 'A'; $row = '11';   $excel->place_value($col.$row,'FROM:','string');
$col = 'B'; $row = '11';   $excel->place_value($col.$row,'TS-'.$sql_data['section'],'string');
$col = 'A'; $row = '13';   $excel->place_value($col.$row,'Part / Product Classification:','string');
$col = 'D'; $row = '13';   $excel->place_value($col.$row,'-NO VALUE DB-','string');
$col = 'A'; $row = '14';   $excel->place_value($col.$row,'Part / Product Name:','string');
$col = 'D'; $row = '14';   $excel->place_value($col.$row,$sql_data['part_name'],'string');
$col = 'A'; $row = '16';   $excel->place_value($col.$row,'Problem Description / Illustration:','string');

$location_of_defect = explode("|",$sql_data['location_of_defect']);
$col = 'D'; $row = '14';   $excel->place_value($col.$row,implode("\n",$location_of_defect),'string');

$col = 'A'; $row = '17';   $excel->place_value($col.$row,'OK','string');
$col = 'D'; $row = '17';   $excel->place_value($col.$row,'NG','string');

if($sql_data['ok_condition_files'] != ""){
	$file_path_ok 		= return_file_path_by_div_mod('iqc_qar_ok');
	$image_ok			= $file_path_ok['path'].$sql_data['pkid'].'/'.$sql_data['ok_condition_files'];
	$col = 'A'; $row = 18; $excel->add_image($col.$row,$image_ok,'240px');
}
if($sql_data['ng_condition_files'] != ""){
	$file_path_ng 		= return_file_path_by_div_mod('iqc_qar_ng');
	$image_ng			= $file_path_ng['path'].$sql_data['pkid'].'/'.$sql_data['ng_condition_files'];
	$col = 'D'; $row = 18; $excel->add_image($col.$row,$image_ng,'240px');
}

$lot_name 	= explode("|",$sql_data['lot_name']);
$col = 'A'; $row = '20';   $excel->place_value($col.$row,'Affected Lot No/s.:','string');
$col = 'C'; $row = '21';   $excel->place_value($col.$row,implode("\n",$lot_name),'string');
$lot_qty 	= explode("|",$sql_data['lot_qty']);
$col = 'A'; $row = '21';   $excel->place_value($col.$row,'Lot Quantity:','string');
$col = 'C'; $row = '21';   $excel->place_value($col.$row,implode("\n",$lot_qty),'string');
$col = 'A'; $row = '22';   $excel->place_value($col.$row,'Inspected Quantity:','string');
$col = 'C'; $row = '22';   $excel->place_value($col.$row,$sql_data['checked_qty'],'string');
$col = 'A'; $row = '23';   $excel->place_value($col.$row,'NG Quantity:','string');
$col = 'C'; $row = '23';   $excel->place_value($col.$row,$sql_data['ng_qty'],'string');
$col = 'A'; $row = '24';   $excel->place_value($col.$row,'NG Rate:','string');
$col = 'C'; $row = '24';   $excel->place_value($col.$row,$sql_data['ng_rate']."%",'string');
$col = 'A'; $row = '26';   $excel->place_value($col.$row,'CONTAINMENT ACTIONS','string');
$col = 'A'; $row = '27';   $excel->place_value($col.$row,'Corrective Action/s','string');
$col = 'D'; $row = '27';   $excel->place_value($col.$row,'Date','string');
$col = 'E'; $row = '27';   $excel->place_value($col.$row,'Quantity','string');
$col = 'F'; $row = '27';   $excel->place_value($col.$row,'NG Quantity','string');
$col = 'H'; $row = '27';   $excel->place_value($col.$row,'Who','string');
$col = 'I'; $row = '27';   $excel->place_value($col.$row,'Remarks','string');
$col = 'A'; $row = '34';   $excel->place_value($col.$row,'Root Cause Analysis','string');
$col = 'A'; $row = '42';   $excel->place_value($col.$row,'Escapee Cause Analysis','string');
$col = 'A'; $row = '50';   $excel->place_value($col.$row,'Corrective Action/s','string');
$col = 'F'; $row = '50';   $excel->place_value($col.$row,'Date','string');
$col = 'H'; $row = '50';   $excel->place_value($col.$row,'Who','string');
$col = 'I'; $row = '50';   $excel->place_value($col.$row,'Remarks','string');
$col = 'A'; $row = '54';   $excel->place_value($col.$row,'Corrective Action/s','string');
$col = 'F'; $row = '54';   $excel->place_value($col.$row,'Date','string');
$col = 'H'; $row = '54';   $excel->place_value($col.$row,'Who','string');
$col = 'I'; $row = '54';   $excel->place_value($col.$row,'Remarks','string');
$col = 'A'; $row = '58';   $excel->place_value($col.$row,'Conclusion','string');
$col = 'A'; $row = '67';   $excel->place_value($col.$row,'Complaint is VALID.','string');
$col = 'A'; $row = '68';   $excel->place_value($col.$row,'Complaint is INVALID.','string');
$col = 'A'; $row = '69';   $excel->place_value($col.$row,'Complaint closed ','string');

/* 
	Populate SQL values
*/



/* set file name */
$date_month = date('ym',strtotime($sql_data['date_issued']));
// $filename = "QAR-TS-".$sql_data['section']."-".$date_month."-".$sql_data['control_no_count']."_".$sql_data['part_name']."_".$sql_data['mode_of_defect'];
$filename = "QAR-TS-";
// $filename = "Quality Alert Report - QAR";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
