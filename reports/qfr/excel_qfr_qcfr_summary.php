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
$type		= $_GET['tp'];
// $date_from 	= '2018-11';		
// $date_to	= '2018-12';	
// $type		= 'Supplier/Subcon';	
if($type == "Internal") {
	$swhere		= ' AND subcon_pmi="PMI Assy"';	
} else if($type == "External") {
	$swhere		= ' AND subcon_pmi="Supplier/Subcon"';	
} else {
	$swhere		= '';
}

if(date('m', strtotime($date_from)) >= 4 && date('m', strtotime($date_from) <= 12)) {
	$fiscal_year 	= 'FY'.date('Y', strtotime($date_from.'-01'));
} else {
	$fiscal_year 	= 'FY'.date('Y', strtotime($date_from.'-01 -1 year'));
}

/* Group by Year and month data */
$array_fields 	= array('YEAR(date_issued) AS year_inspected', 'MONTH(date_issued) AS month_inspected');
$table 	   		= 'tbl_qfr_qcfr';
$joins 	   		= '';
$sql_where 		= 'WHERE (date_issued BETWEEN "'.$date_from.'-01" AND "'.$date_to.'-31") AND logdel=0'.$swhere;
$sql_order 		= '';
$sql_limit 		= 'GROUP BY YEAR(date_issued), MONTH(date_issued)';
$result_group 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);

/* Details data */
$array_fields 	= array('*');
$table 	   		= 'tbl_qfr_qcfr';
$joins 	   		= '';
$sql_order 		= 'ORDER BY date_issued';
$sql_limit 		= '';
$return = array();

function return_answer_uploaded($pkid, $oop) {
	require_once($oop);
	$array_fields 	= array('date_time_created');
	$table 	   		= 'tbl_qfr_qcfr_attachments';
	$sql_where 	   	= 'WHERE fkqcfr="'.$pkid.'" AND (category="8D" OR category="CAPA") AND logdel=0';
	$joins 	   		= '';
	$sql_order 		= '';
	$sql_limit 		= '';
	$result		 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)) {
		return date('M d, Y', strtotime($row['date_time_created']));
	} else {
		return '';
	}
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
$col = 'A'; $row = '1';   $excel->place_value($col.$row,$fiscal_year.' '.$section.' QCFR ISSUANCE SUMMARY LIST ','string');
$col = 'A'; $row = '4';   $excel->place_value($col.$row,'Date Issued','string');
$col = 'B'; $row = '4';   $excel->place_value($col.$row,'Control Number','string');
$col = 'C'; $row = '4';   $excel->place_value($col.$row,'Supplier / Assembly Line','string');
$col = 'D'; $row = '4';   $excel->place_value($col.$row,'Series Name/ Part Name','string');
$col = 'E'; $row = '4';   $excel->place_value($col.$row,'Problem','string');
$col = 'F'; $row = '4';   $excel->place_value($col.$row,'Recipient','string');
$col = 'G'; $row = '4';   $excel->place_value($col.$row,'Issued By','string');
$col = 'H'; $row = '4';   $excel->place_value($col.$row,'Due Date','string');
$col = 'I'; $row = '4';   $excel->place_value($col.$row,'Date Returned','string');
$col = 'J'; $row = '4';   $excel->place_value($col.$row,'Approved By (LQC Head)','string');
$col = 'K'; $row = '4';   $excel->place_value($col.$row,'Remarks','string');
/* Set data value */
$col = 'A';
$row = 5;
while($row_group = mysqli_fetch_assoc($result_group)){	
	$month_year = date('M, Y', strtotime($row_group['year_inspected'].'-'.$row_group['month_inspected'].'-01'));
	$excel->place_value($col.$row,$month_year,'string'); 		 		
	$cell_range = 'A'.$row.':K'.$row; $excel->set_format($cell_range,$array_format_sub_content);
	$excel->merge_cells('A'.$row.':K'.$row);
	$row++;
	
	$sql_where 		= 'WHERE (date_issued LIKE "%'.$row_group['year_inspected'].'-'.$row_group['month_inspected'].'%") AND logdel=0'.$swhere;
	$result_details	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row_details = mysqli_fetch_assoc($result_details)){
		$attention 	= array();
		$att 		= explode(',',$row_details['attn']);
		foreach($att as $key => $value) {
			$attention[] = get_emp_name_by_username_systemone($value);
		}		
		
		if($row_details['subcon_pmi'] == 'Supplier/Subcon') {
			$supplier = $row_details['cc_supplier'];
		} else {
			$supplier 	= array();
			$cc_pmi 	= explode(' | ',$row_details['cc_pmi']);
			foreach($cc_pmi as $key => $value) {
				$supplier[] = get_emp_name_by_username_systemone($value);
			}
			$supplier = implode(' / ',$supplier);
		}
		
		$date_answer = $row_details['answer'] == 'No Need' ? 'N/A' : date('M d, Y', strtotime($row_details['date_answer_required']));
		$approved_by = get_emp_name_by_username_systemone($row_details['approved_by_sh']);
		$approved_by = strstr($row_details['approved_by_sh_logs'], "APPROVED") ? $approved_by : 'PENDING to '.$approved_by;
		
		$excel->place_value($col.$row,date('M d, Y', strtotime($row_details['date_issued'])),'string'); 								$col++; 	
		$excel->place_value($col.$row,$row_details['qcfr_no'],'string'); 																$col++; 	
		$excel->place_value($col.$row,$supplier,'string'); 																				$col++; 	
		$excel->place_value($col.$row,$row_details['model_no'],'string'); 																$col++; 	
		$excel->place_value($col.$row,$row_details['failure_defect_description'],'string'); 											$col++; 	
		$excel->place_value($col.$row,implode(' / ',$attention),'string'); 																$col++; 	
		$excel->place_value($col.$row,get_emp_name_by_username_systemone($row_details['reported_by']),'string'); 						$col++; 	
		$excel->place_value($col.$row,$date_answer,'string'); 																			$col++; 	
		$excel->place_value($col.$row,return_answer_uploaded($row_details['pkid'], $oop),'string'); 									$col++; 	
		$excel->place_value($col.$row,$approved_by,'string'); 																			$col++; 		
		$excel->place_value($col.$row,($row_details['status'] == 'CLOSED' ? $row_details['status'] : ''),'string'); 					$col++; 	
		$col = 'A'; $row++;		
	}
}

/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/
$cell = 'A4:K'.$row; $excel->set_borders($cell,1,1,1,1, "thin");	

/* set file name */
$filename = $section.' QCFR Summary List as of '.$date_from.' to '.$date_to;
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

?>