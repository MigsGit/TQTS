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
$cell_range = 'A1:K1'; $excel->set_format($cell_range,$array_format_header);
$array_format_sub_header = array(
	"size"	=> 12,
	"h_alignment"	=> "center",
	'fill_color'  => "FFFF99"
);
$cell_range = 'A4:K4'; $excel->set_format($cell_range,$array_format_sub_header);
$array_format_sub_content = array(
	"size"	=> 12,
	"h_alignment"	=> "left",
	'fill_color'  => "FF99cc"
);
$array_format_content = array(
	"size"	=> 12,
	"wordwrap"	=> true,
	"h_alignment"	=> "center",
	'fill_color'  => "FFFFFF"
);
$cell_range = 'A5:K9999'; $excel->set_format($cell_range,$array_format_content);

$width_allowance = .75;

/* set width */
$excel->set_width('A',$width_allowance+14);
$excel->set_width('B',$width_allowance+48);	
$excel->set_width('C',$width_allowance+38);	
$excel->set_width('D',$width_allowance+35);	
$excel->set_width('E',$width_allowance+52);	
$excel->set_width('F',$width_allowance+20);	
$excel->set_width('G',$width_allowance+20);	
$excel->set_width('H',$width_allowance+15);	
$excel->set_width('I',$width_allowance+15);
$excel->set_width('J',$width_allowance+25);
$excel->set_width('K',$width_allowance+25);

/* set height */
$excel->set_height('1',44);
$excel->set_height('2',160);
$excel->set_height('4',36);

/* Merge Cells */
$excel->merge_cells('A1:K1');


/* Place value */
$col = 'A'; $row = '2';
$pmi_logo	= '../../images/lon_summary_report_ctrl_guide.png';
$excel->add_image($col.$row,$pmi_logo,'179px');

$section	= return_system_division();
$col = 'A'; $row = '1';   $excel->place_value($col.$row,$section.' '.$fiscal_year.' LOT-OUT NOTICE ISSUANCE SUMMARY LIST','string');
$col = 'A'; $row = '4';   $excel->place_value($col.$row,'Date Issued','string');
$col = 'B'; $row = '4';   $excel->place_value($col.$row,'Control Number','string');
$col = 'C'; $row = '4';   $excel->place_value($col.$row,'Series Name/ Part Name','string');
$col = 'D'; $row = '4';   $excel->place_value($col.$row,'Assembly Line  / Line','string');
$col = 'E'; $row = '4';   $excel->place_value($col.$row,'Problem','string');
$col = 'F'; $row = '4';   $excel->place_value($col.$row,'Recipient','string');
$col = 'G'; $row = '4';   $excel->place_value($col.$row,'Issued By','string');
$col = 'H'; $row = '4';   $excel->place_value($col.$row,'Due Date','string');
$col = 'I'; $row = '4';   $excel->place_value($col.$row,'Date Returned','string');
$col = 'J'; $row = '4';   $excel->place_value($col.$row,'Remarks','string');
$col = 'K'; $row = '4';   $excel->place_value($col.$row,'Status','string');
/* Set data value */
$col = 'A';
$row = 5;
while($row_group = mysqli_fetch_assoc($result_group)){	
	$month_year = date('M, Y', strtotime($row_group['year_inspected'].'-'.$row_group['month_inspected'].'-01'));
	$excel->place_value($col.$row,$month_year,'string'); 		 		
	$cell_range = 'A'.$row.':K'.$row; $excel->set_format($cell_range,$array_format_sub_content);
	$excel->merge_cells('A'.$row.':K'.$row);
	$row++;
	
	$sql_where 		= 'WHERE (date_inspected LIKE "%'.$row_group['year_inspected'].'-'.sprintf("%02d", $row_group['month_inspected']).'%") AND logdel=0';
	$result_details	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row_details = mysqli_fetch_assoc($result_details)){
		$attention 	= array();
		$att 		= explode(',',$row_details['attention']);
		foreach($att as $key => $value) {
			$attention[] = get_emp_name_by_username_systemone($value);
		}
		
		$lon_no = $section.'-'.date('my', strtotime($row_details['date_time_created'])).'-'.$row_details['lon_ctr'];
		
		$excel->place_value($col.$row,date('M d, Y', strtotime($row_details['date_inspected'])),'string'); 	$col++; 	
		$excel->place_value($col.$row,$lon_no,'string'); 							$col++; 
		$excel->place_value($col.$row,$row_details['device_name'],'string'); 		$col++; 	
		$excel->place_value($col.$row,$row_details['line'],'string'); 				$col++; 	
		$excel->place_value($col.$row,$row_details['defect_mode'],'string'); 		$col++; 	
		$excel->place_value($col.$row,implode(' / ',$attention),'string'); 			$col++; 	
		$excel->place_value($col.$row,get_emp_name_by_username_systemone($row_details['created_by']),'string'); $col++; 	
		$excel->place_value($col.$row,date('M d, Y', strtotime($row_details['capa_due_date'])),'string'); 		$col++; 	
		$excel->place_value($col.$row,date('M d, Y', strtotime($row_details['date_inspected'])),'string'); 		$col++; 	
		$excel->place_value($col.$row,check_capa_creation($row_details['pkid'], $oop),'string'); 		$col++; 	
		$excel->place_value($col.$row,$row_details['status'],'string'); 		$col++; 	
		$col = 'A'; $row++;		
	}
}

/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/
$cell = 'A4:K'.$row; $excel->set_borders($cell,1,1,1,1, "thin");	

/* set file name */
$filename = $section.' LON Summary List as of '.$date_from.' to '.$date_to;
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

?>