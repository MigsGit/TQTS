<?php

$oop = '../../class/oop_tqts.php';
include('../../handler/common_function.php');
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$group_by 		= $_GET['group_by'];
$group_by_val 	= $_GET['group_by_val'];

// $group_by 		= 'line';
// $group_by_val 	= 'd';


if($group_by != '') {
	$sql_where = "WHERE ". $group_by . " LIKE '%".$group_by_val."%' AND logdel=0";
} else {
	$sql_where = "WHERE logdel=0";
}

$array_fields = array('*');
$table 	   	= 'tbl_etr_training';
$joins 	   	= '';
$sql_order 	= 'ORDER BY pkid DESC';
$sql_limit 	= '';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
/* Do excel here */

$excel_class = '../../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist'.$return['file_path'];
	exit;
}

$excel = new EXCEL;
/* set title */
$excel->title = 'Summary';
/* add a new page */
$excel->add_page();
/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

$excel->set_margin();
$excel->set_print_area();

$width_allowance = 40;

/* set width */
$excel->set_width('A',15);
$excel->set_width('B',50);
$excel->set_width('C',70);
$excel->set_width('D',$width_allowance);
$excel->set_width('E',$width_allowance);
$excel->set_width('F',$width_allowance);
$excel->set_width('G',$width_allowance);
$excel->set_width('H',$width_allowance);
$excel->set_width('I',$width_allowance);
$excel->set_width('J',$width_allowance);


$array_format = array(
	"size" 			=> 12,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'center'
);
$excel->set_format('A3:J3',$array_format);


/* place value */
$row = 3; $col = 'A'; $excel->place_value($col.$row,'Status','string');	
$row = 3; $col = 'B'; $excel->place_value($col.$row,'Title','string');	
$row = 3; $col = 'C'; $excel->place_value($col.$row,'Objective','string');	
$row = 3; $col = 'D'; $excel->place_value($col.$row,'Mechanics','string');	
$row = 3; $col = 'E'; $excel->place_value($col.$row,'Type of Training','string');	
$row = 3; $col = 'F'; $excel->place_value($col.$row,'Venue','string');	
$row = 3; $col = 'G'; $excel->place_value($col.$row,'Line','string');	
$row = 3; $col = 'H'; $excel->place_value($col.$row,'Control #','string');	
$row = 3; $col = 'I'; $excel->place_value($col.$row,'Series Name','string');	
$row = 3; $col = 'J'; $excel->place_value($col.$row,'Instructors','string');

$row = 4; $col = 'A';
$array_format = array(
	"size" 			=> 12,
	"wordwrap"		=> true
);
while($row_result = mysqli_fetch_array($result)){
	$instructors			= get_emp_name_by_username_systemone($row_result['prdn_first_take_trained_by']);
	$instructors		   .= ', '.get_emp_name_by_username_systemone($row_result['eng_first_take_qualified_by']);
	$instructors		   .= ', '.get_emp_name_by_username_systemone($row_result['qc_first_take_certified_by']);
	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['status'],'string');	$col++;		
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['training_title'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['training_objective'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['mechanics'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['type_of_training'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['venue'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['line'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['control_no'],'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$row_result['series_name'],'string');$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$instructors,'string');$col++;	
	$excel->set_format($col.$row,$array_format);
	$row++;	
	$col = 'A';
}

/* set file name */
$filename = 'Training Records Summary.xls';
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

/* delete cookie */
// setcookie($cookie_name, "", -1);
// setcookie($cookie_name, '', time() + 3600, "/");
?>
