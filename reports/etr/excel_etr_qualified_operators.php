<?php

$oop = '../../class/oop_tqts.php';
include('../../handler/common_function.php');
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$pkid 		= $_GET['id'];

// $pkid 		= '68';

$array_fields = array('*');
$table 	   	= 'tbl_etr_training';
$joins 	   	= '';
$sql_order 	= '';
$sql_limit 	= 'LIMIT 0,1';
$sql_where 	= "WHERE pkid='".$pkid."' AND logdel=0";
$result_main = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
if($row = mysqli_fetch_array($result_main)) {
	$line 					= $row['line'];
	$prdn_date_train		= $row['prdn_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['prdn_first_take_date_time']));
	$prdn_instructor		= get_emp_name_by_username_systemone($row['prdn_first_take_trained_by']);
	$engr_date_train		= $row['eng_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['eng_first_take_date_time']));
	$engr_instructor		= get_emp_name_by_username_systemone($row['eng_first_take_qualified_by']);
	$qc_date_train			= $row['qc_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['qc_first_take_date_time']));
	$qc_instructor			= get_emp_name_by_username_systemone($row['qc_first_take_certified_by']);
}

$array_fields = array('*');
$table 	   	= 'tbl_etr_training_employees';
$joins 	   	= '';
$sql_order 	= '';
$sql_limit 	= '';
$sql_where 	= "WHERE `fketr` = '$pkid' AND logdel=0 AND (`qc_first_take_overall_assessment`='PASSED' OR `qc_second_take_overall_assessment`='PASSED')";
$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// /* Do excel here */

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

$width_allowance = 30;

/* set width */
$excel->set_width('A',5);
$excel->set_width('B',50);
$excel->set_width('C',50);
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
	"h_alignment" 	=> 'left'
);
$excel->set_format('A1',$array_format);
$array_format = array(
	"size" 			=> 11,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A2',$array_format);

$array_format = array(
	"size" 			=> 12,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'center'
);
$excel->set_format('A4:J4',$array_format);


/* place value */
$row = 1; $col = 'A'; $excel->place_value($col.$row,'CERTIFIED OPERATORS LIST','string');	
$row = 2; $col = 'A'; $excel->place_value($col.$row,'PRODUCT LINE: '.$line,'string');	
$row = 4; $col = 'A'; $excel->place_value($col.$row,'NO.','string');	
$row = 4; $col = 'B'; $excel->place_value($col.$row,'OPERATOR\'s NAME','string');	
$row = 4; $col = 'C'; $excel->place_value($col.$row,'EMPLOYEE NO.','string');	
$row = 4; $col = 'D'; $excel->place_value($col.$row,'DATE TRAINED','string');	
$row = 4; $col = 'E'; $excel->place_value($col.$row,'DATE CERTIFIED ','string');	
$row = 4; $col = 'F'; $excel->place_value($col.$row,'PRODUCTION IN-CHARGE','string');	
$row = 4; $col = 'G'; $excel->place_value($col.$row,'ENGINEERING IN-CHARGE','string');	
$row = 4; $col = 'H'; $excel->place_value($col.$row,'QC IN-CHARGE','string');	
$row = 4; $col = 'I'; $excel->place_value($col.$row,'STATION FROM','string');	
$row = 4; $col = 'J'; $excel->place_value($col.$row,'STATION TO','string');	

$row = 5; $col = 'A';
$array_format = array(
	"wordwrap"	=> true
);
$ctr = 1;
while($row_result = mysqli_fetch_array($result)){
	$operators_name 		= $row_result['operators_name'];
	$employee_no 			= $row_result['employee_no'];
	$station_from 			= $row_result['station_from'];
	$station_to 			= $row_result['station_to'];
	
	$excel->place_value($col.$row,$ctr++,'string');				$col++;		
	$excel->place_value($col.$row,$operators_name,'string');	$col++;	
	$excel->set_format($col.$row,$array_format);
	$excel->place_value($col.$row,$employee_no,'string');		$col++;	
	$excel->place_value($col.$row,$prdn_date_train,'string');	$col++;	
	$excel->place_value($col.$row,$qc_date_train,'string');		$col++;	
	$excel->place_value($col.$row,$prdn_instructor,'string');	$col++;	
	$excel->place_value($col.$row,$engr_instructor,'string');	$col++;	
	$excel->place_value($col.$row,$qc_instructor,'string');		$col++;	
	$excel->place_value($col.$row,$station_from,'string');		$col++;	
	$excel->place_value($col.$row,$station_to,'string');		$col++;	
	$row++;	
	$col = 'A';
}

/* set file name */
$filename = 'Qualified Operators Line '.$line.'.xls';
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

/* delete cookie */
// setcookie($cookie_name, "", -1);
// setcookie($cookie_name, '', time() + 3600, "/");
?>
