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
$pkid = 2;
// $array_fields 	= array('*');
// $table 	   		= ' tbl_iqc_qar';
// $joins 	   		= '';
// $sql_where 		= 'WHERE pkid="'.$pkid.'" AND logdel=0';
// $sql_order 		= '';
// $sql_limit 		= 'LIMIT 0,1';
// $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// $script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// $return = array();
// $sql_data = array();
// while($row = mysqli_fetch_assoc($result)){
	// $sql_data = $row;
// }


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

$width_allowance = .81;

/* set width */
$excel->set_width('A',$width_allowance+35);	
$excel->set_width('B',$width_allowance+39);	
$excel->set_width('C',$width_allowance+20);	
$excel->set_width('D',$width_allowance+22);	
$excel->set_width('E',$width_allowance+26);	
$excel->set_width('F',$width_allowance+29);	
$excel->set_width('G',$width_allowance+20);	
$excel->set_width('H',$width_allowance+21);	
$excel->set_width('I',$width_allowance+21);	
$excel->set_width('J',$width_allowance+21);	
$excel->set_width('K',$width_allowance+32);		



/* Row 2 */
$row = 2; $col = 'A'; $excel->place_value($col.$row,'INTERNAL CLAIM SUMMARY FY2017','string');

/* Row 3 */
$row = 3; $col = 'A'; $excel->place_value($col.$row,'QAR #','string');	
$row = 3; $col = 'B'; $excel->place_value($col.$row,'PART NAME','string');	
$row = 3; $col = 'C'; $excel->place_value($col.$row,'CUSTOMER','string');	
$row = 3; $col = 'D'; $excel->place_value($col.$row,'Mode of Defect','string');	
$row = 3; $col = 'E'; $excel->place_value($col.$row,'Illustration','string');	
$row = 3; $col = 'F'; $excel->place_value($col.$row,'','string');	
$row = 3; $col = 'G'; $excel->place_value($col.$row,'DATE ISSUED','string');	
$row = 3; $col = 'H'; $excel->place_value($col.$row,'REQUIRED DATE REPLY','string');	
$row = 3; $col = 'I'; $excel->place_value($col.$row,'ACTUAL REPLY DATE','string');	
$row = 3; $col = 'J'; $excel->place_value($col.$row,'STATUS','string');	
$row = 3; $col = 'K'; $excel->place_value($col.$row,'Remarks','string');



/* Row Styles */
$array_format = array(
	"bold"	=> true,
	"size"	=> 18
);
$cell_range = 'A2';
$excel->set_format($cell_range,$array_format);
$array_format = array(
	"bold"	=> true,
	"fill_color" => "00ffff",
	"size"	=> 14,
	"wordwrap"	=> true,
	"h_alignment" => "center"
);
$cell_range = 'A3:K3';
$excel->set_format($cell_range,$array_format);



/* Borders */
/* all side borders */
$left = 1; $top = 1; $right = 1; $bottom = 1; $border_style = 'medium';
$cell = 'A3:K3';
$excel->set_borders($cell,$left,$right,$top,$bottom,$border_style);
// /* outline borders */
// $cell = 'E8:G8';
// $excel->set_outline_borders($cell,'medium');


/* Merge Cells */
$excel->merge_cells('E3:F3');


/* 
	Populate SQL values
*/
$array_fields 	= array('*','CONCAT("QAR-TS-",`section`,"-",DATE_FORMAT(`date_created`,"%y%m"),"-",`control_no_count`) as control_no');
$table 	   		= 'tbl_iqc_qar';
$joins 	   		= '';
$sql_where 		= '';
$sql_order 		= 'ORDER BY `date_created`,`to` ASC';
$sql_limit 		= '';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return = array();
$sql_data = array();
while($row = mysqli_fetch_assoc($result)){
	$sql_data[] = $row;
}

$row = 4; $col = 'A'; $row_start = 4; $row_end = 0;
$current_date = "";
foreach($sql_data as $key => $array_data){
	$date_created = date('MY',strtotime($array_data['date_created']));
	if($current_date != $date_created){
		if($row_end != 0){
			$cell_range = 'A'.$row_start.':K'.$row_end;
			$excel->set_borders($cell_range,$left,$right,$top,$bottom,'thin');
		}
		$current_date = $date_created;
		$excel->place_value($col.$row, $current_date,'string');
		$array_format = array(
			"bold"	=> true,
			"fill_color" => "ffff00",
			"size"	=> 12,
			"wordwrap"	=> true,
			"h_alignment" => "left"
		);
		$cell_range = 'A'.$row.':K'.$row;
		$excel->set_format($cell_range,$array_format);
		$excel->set_outline_borders($cell_range,'medium');
		$row++;
		$excel->place_value($col.$row, $array_data['to'],'string');
		$array_format = array(
			"bold"	=> true,
			"fill_color" => "00ff00",
			"size"	=> 12,
			"wordwrap"	=> true,
			"h_alignment" => "left"
		);
		$cell_range = 'A'.$row.':K'.$row;
		$excel->set_format($cell_range,$array_format);
		$excel->set_outline_borders($cell_range,'medium');
		$row++;
		$row_start = $row;
	}
	$excel->place_value($col.$row, $array_data['control_no'],'string'); $col++;
	$excel->place_value($col.$row, $array_data['part_name'],'string'); $col++;
	$excel->place_value($col.$row, $array_data['to'],'string'); $col++;
	$mode_of_defect 	= explode("|",$array_data['mode_of_defect']);
	$excel->place_value($col.$row, implode("\n",$mode_of_defect),'string'); $col++;
	$excel->place_value($col.$row, $array_data['ok_condition_text'],'string'); $col++;
	$excel->place_value($col.$row, $array_data['ng_condition_text'],'string'); $col++;
	$excel->place_value($col.$row, date('d-M-y',strtotime($array_data['date_conformed'])),'string'); $col++;
	$excel->place_value($col.$row, date('d-M-y',strtotime(add_three_days_without_sunday($array_data['date_conformed']))),'string'); $col++;
	$excel->place_value($col.$row, date('d-M-y',strtotime($array_data['disposition_date'])),'string'); $col++;
	$status = '';
	switch($array_data['status']){
		case "0"	: $status = 'Pending Conformance'; break;
		case "1"	: $status = 'Conformed & Sent'; break;
		case "2"	: $status = 'Rejected'; break;
		case "3"	: $status = 'For Review Disposition'; break;
		case "4"	: $status = 'Closed'; break;
		case "9"	: $status = 'Cancelled'; break;
	}
	$excel->place_value($col.$row, $status,'string'); $col++;
	$row_end = $row;
	$col='A';
	$row++;	
}
$cell_range = 'A'.$row_start.':K'.$row_end;
$excel->set_borders($cell_range,$left,$right,$top,$bottom,'thin');

/* set file name */
$filename = "Quality Alert Report - QAR (Summary)";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
