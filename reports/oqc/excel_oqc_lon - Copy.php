<?php
$oop 		= '../../class/oop_tqts.php';
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

$pkid = $_GET['id'];		
// $pkid = 29;

/* Main data */
$array_fields 	= array('*');
$table 	   		= 'tbl_oqc_lon';
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

/* Production data */
$array_fields_prdn 	= array('*');
$table_prdn 	   		= 'tbl_oqc_lon_production';
$joins_prdn 	   		= '';
$sql_where_prdn 		= 'WHERE fklon="'.$pkid.'" AND logdel=0';
$sql_order_prdn 		= '';
$sql_limit_prdn 		= 'LIMIT 0,1';
$result_prdn = TQTS::getInstance()->select_query($array_fields_prdn,$table_prdn,$joins_prdn,$sql_where_prdn,$sql_order_prdn,$sql_limit_prdn);
$script_prdn	= TQTS::getInstance()->select_query_script($array_fields_prdn,$table_prdn,$joins_prdn,$sql_where_prdn,$sql_order_prdn,$sql_limit_prdn);
$sql_data_prdn = array();
while($row_prdn = mysqli_fetch_assoc($result_prdn)){
	$sql_data_prdn = $row_prdn;
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
$excel->title = $sql_data['lon_no'];
$excel->add_sheet(0);

/* use the default font style */
$excel->set_default_font_style();
$excel->set_margin();
$excel->set_print_area();

/* set format */
$array_format = array(
	"size"	=> 10,
	'fill_color'  => "FFFFFF"
);
$cell_range = 'B2:R52'; $excel->set_format($cell_range,$array_format);
$array_format_header = array(
	"bold"	=> true,
	"size"	=> 14,
	"h_alignment"	=> "center"
);
$cell_range = 'C3:Q3'; $excel->set_format($cell_range,$array_format_header);
$array_format_subheader = array(
	"bold"		=> true,
	"italic"	=> true,
	"size"		=> 11,
	"h_alignment"	=> "center"
);
$cell_range = 'C4:Q4'; $excel->set_format($cell_range,$array_format_subheader);
$cell_range = 'C22:Q22'; $excel->set_format($cell_range,$array_format_subheader);
$cell_range = 'C35:Q35'; $excel->set_format($cell_range,$array_format_subheader);
$array_format_labels = array(
	"size"	=> 8,
	"h_alignment"	=> "center"
);
$cell_range = 'C20:Q20'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'N51:Q51'; $excel->set_format($cell_range,$array_format_labels);
$array_format_labels = array(
	"size"	=> 10,
	"h_alignment"	=> "center"
);
$cell_range = 'F8:F8'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'J8:J8'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'O8:O8'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'J11:J14'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'C19:Q19'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'N50:Q50'; $excel->set_format($cell_range,$array_format_labels);

$width_allowance = .75;

/* set width */
$excel->set_width('A',$width_allowance+.08);
$excel->set_width('B',$width_allowance+2);	
$excel->set_width('C',$width_allowance+15);	
$excel->set_width('D',$width_allowance);	
$excel->set_width('E',$width_allowance);	
$excel->set_width('F',$width_allowance+3);	
$excel->set_width('G',$width_allowance+1.5);	
$excel->set_width('H',$width_allowance+13);	
$excel->set_width('I',$width_allowance);
$excel->set_width('J',$width_allowance+3);
$excel->set_width('K',$width_allowance);
$excel->set_width('L',$width_allowance+13);
$excel->set_width('M',$width_allowance+1);
$excel->set_width('N',$width_allowance);
$excel->set_width('O',$width_allowance+3);
$excel->set_width('P',$width_allowance+5);
$excel->set_width('Q',$width_allowance+7);
$excel->set_width('R',$width_allowance+2);
$excel->set_width('S',$width_allowance+2);

/* set height */
$excel->set_height('1',5);
$excel->set_height('2',25);
$excel->set_height('3',15);
$excel->set_height('4',15);
$excel->set_height('22',15);
$excel->set_height('35',15);

/* Merge Cells */
$merge_cells = array('C3:Q3', 'C4:Q4', 'E5:J5', 'M5:Q5', 'E6:J6', 'M6:Q6', 'F9:H9', 'F10:H10', 'F11:H11', 'F12:H12', 'F13:H13', 'F14:H14', 'F15:H15', 'M9:P9', 'M14:Q14', 'M15:Q15', 'C17:F17', 'H17:L17', 'N17:Q17', 'C18:F18', 'H18:L18', 'N18:Q18', 'C19:F19', 'H19:L19', 'N19:Q19', 'C20:F20', 'H20:L20', 'N20:Q20', 'C22:Q22', 'F23:H23', 'K23:M23', 'N23:O23', 'P23:Q23', 'F24:Q24', 'C26:Q29', 'C31:Q34', 'C35:Q35', 'C38:Q41', 'C43:Q46', 'N48:Q48', 'N49:Q49', 'N50:Q50', 'N51:Q51' );
for($i=0; $i<count($merge_cells); $i++) {
	$excel->merge_cells($merge_cells[$i]);
}

/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/
$cell = 'B2:R52'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'C3:Q3'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'C4:Q4'; $excel->set_borders($cell,0,0,0,1, "double");	
$cell = 'E6:J6'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'M6:Q6'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'F8:F8'; $excel->set_borders($cell,1,1,1,1, "thin");	
$cell = 'J8:J8'; $excel->set_borders($cell,1,1,1,1, "thin");	
$cell = 'O8:O8'; $excel->set_borders($cell,1,1,1,1, "thin");	
$cell = 'L9:L9'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'Q9:Q9'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'F10:H10'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'F12:H12'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'F14:H14'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'F15:H15'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'J11:J14'; $excel->set_borders($cell,1,1,1,1, "thin");	
$cell = 'M15:Q15'; $excel->set_borders($cell,0,0,1,1, "thin");	
$cell = 'C19:F19'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'H19:L19'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'N19:Q19'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'C21:Q21'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'C22:Q22'; $excel->set_borders($cell,0,0,0,1, "double");	
$cell = 'F23:H23'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'K23:M23'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'P23:Q23'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'F24:Q24'; $excel->set_borders($cell,0,0,0,1, "thin");	
$cell = 'C26:Q29'; $excel->set_borders($cell,1,1,1,1, "thin");	
$cell = 'C31:Q34'; $excel->set_borders($cell,1,1,1,1, "thin");	
$cell = 'C35:Q35'; $excel->set_borders($cell,0,0,0,1, "double");
$cell = 'C38:Q41'; $excel->set_borders($cell,1,1,1,1, "thin");		
$cell = 'C43:Q46'; $excel->set_borders($cell,1,1,1,1, "thin");		
$cell = 'N50:Q50'; $excel->set_borders($cell,0,0,0,1, "thin");		
$cell = 'B52:R52'; $excel->set_borders($cell,0,0,0,1, "medium");	


$col = 'B'; $row = '2';
$excel->set_height('2',15.00);
$pmi_logo	= '../../images/pmi-logo2.png';
$excel->add_image($col.$row,$pmi_logo,'26px');

/* Place value */
$col = 'C'; $row = '3';   $excel->place_value($col.$row,'LOT-OUT NOTICE','string');
$col = 'C'; $row = '4';   $excel->place_value($col.$row,'OQC FILL-IN','string');
$col = 'C'; $row = '5';   $excel->place_value($col.$row,'Section:','string');
$col = 'C'; $row = '6';   $excel->place_value($col.$row,'Attention:','string');
$col = 'L'; $row = '5';   $excel->place_value($col.$row,'LON No.:','string');
$col = 'L'; $row = '6';   $excel->place_value($col.$row,'Defect mode:','string');
$col = 'C'; $row = '8';   $excel->place_value($col.$row,'LOT SUBMISSION','string');
$col = 'G'; $row = '8';   $excel->place_value($col.$row,'  1st SUB','string');
$col = 'L'; $row = '8';   $excel->place_value($col.$row,'2nd SUB','string');
$col = 'P'; $row = '8';   $excel->place_value($col.$row,'  3rd SUB','string');
$col = 'C'; $row = '9';   $excel->place_value($col.$row,'LOT QUANTITY','string');
$col = 'J'; $row = '9';   $excel->place_value($col.$row,'AQL:','string');
$col = 'M'; $row = '9';   $excel->place_value($col.$row,' SAMPLE SIZE:','string');
$col = 'D'; $row = '9';   $excel->place_value($col.$row,':','string');
$col = 'D'; $row = '10';   $excel->place_value($col.$row,':','string');
$col = 'D'; $row = '11';   $excel->place_value($col.$row,':','string');
$col = 'D'; $row = '12';   $excel->place_value($col.$row,':','string');
$col = 'D'; $row = '13';   $excel->place_value($col.$row,':','string');
$col = 'D'; $row = '14';   $excel->place_value($col.$row,':','string');
$col = 'D'; $row = '15';   $excel->place_value($col.$row,':','string');
$col = 'C'; $row = '10';   $excel->place_value($col.$row,'DATE INSPECTED','string');
$col = 'J'; $row = '10';   $excel->place_value($col.$row,'DISPOSITION ON AFFECTED LOT','string');
$col = 'C'; $row = '11';   $excel->place_value($col.$row,'MODEL/SERIES','string');
$col = 'L'; $row = '11';   $excel->place_value($col.$row,'SORTING','string');
$col = 'C'; $row = '12';   $excel->place_value($col.$row,'LOT NUMBER','string');
$col = 'L'; $row = '12';   $excel->place_value($col.$row,'REWORK/REPAIR','string');
$col = 'C'; $row = '13';   $excel->place_value($col.$row,'REEL/BATCH #','string');
$col = 'L'; $row = '13';   $excel->place_value($col.$row,'HOLD','string');
$col = 'C'; $row = '14';   $excel->place_value($col.$row,'CONCERN OPTR','string');
$col = 'L'; $row = '14';   $excel->place_value($col.$row,'OTHERS:','string');
$col = 'C'; $row = '15';   $excel->place_value($col.$row,'VERIFIED BY','string');
$col = 'J'; $row = '15';   $excel->place_value($col.$row,'CAPA DUE DATE:','string');
$col = 'C'; $row = '17';   $excel->place_value($col.$row,'PREPARED BY','string');
$col = 'H'; $row = '17';   $excel->place_value($col.$row,'CHECKED BY','string');
$col = 'N'; $row = '17';   $excel->place_value($col.$row,'APPROVED BY','string');
$col = 'C'; $row = '20';   $excel->place_value($col.$row,'LQC INSPECTOR','string');
$col = 'H'; $row = '20';   $excel->place_value($col.$row,'LQC SUPERSIVOR','string');
$col = 'N'; $row = '20';   $excel->place_value($col.$row,'LQC ASST MANAGER','string');
$col = 'C'; $row = '22';   $excel->place_value($col.$row,'PRODUCTION FILL-IN','string');
$col = 'C'; $row = '23';   $excel->place_value($col.$row,'SORTED QTY.','string');
$col = 'E'; $row = '23';   $excel->place_value($col.$row,':','string');
$col = 'J'; $row = '23';   $excel->place_value($col.$row,'OK:','string');
$col = 'N'; $row = '23';   $excel->place_value($col.$row,'NG:','string');
$col = 'C'; $row = '24';   $excel->place_value($col.$row,'MODE OF DEFECT','string');
$col = 'E'; $row = '24';   $excel->place_value($col.$row,':','string');
$col = 'C'; $row = '25';   $excel->place_value($col.$row,'GUARANTEED LOT','string');
$col = 'E'; $row = '25';   $excel->place_value($col.$row,':','string');
$col = 'C'; $row = '30';   $excel->place_value($col.$row,'REMARKS:','string');
$col = 'C'; $row = '35';   $excel->place_value($col.$row,'OQC FILL-IN','string');
$col = 'C'; $row = '36';   $excel->place_value($col.$row,'RESULT OF CONFIRMATION','string');
$col = 'C'; $row = '37';   $excel->place_value($col.$row,'1. Treatment for affected lot:','string');
$col = 'C'; $row = '42';   $excel->place_value($col.$row,'2. Verification result for corrective and preventive action:','string');
$col = 'N'; $row = '48';   $excel->place_value($col.$row,'PREPARED BY','string');
$col = 'N'; $row = '51';   $excel->place_value($col.$row,'LQC INSPECTOR','string');
/* Set data value */
$col = 'E'; $row = '5';   $excel->place_value($col.$row,$sql_data['section'],'string');
$col = 'M'; $row = '5';   $excel->place_value($col.$row,$sql_data['lon_no'],'string');
$col = 'M'; $row = '6';   $excel->place_value($col.$row,$sql_data['defect_mode'],'string');
$col = 'F'; $row = '8';   $excel->place_value($col.$row,($sql_data['lot_submission'] == '1st Sub' ? 'X' : ''),'string');
$col = 'J'; $row = '8';   $excel->place_value($col.$row,($sql_data['lot_submission'] == '2nd Sub' ? 'X' : ''),'string');
$col = 'O'; $row = '8';   $excel->place_value($col.$row,($sql_data['lot_submission'] == '3rd Sub' ? 'X' : ''),'string');
$col = 'F'; $row = '9';   $excel->place_value($col.$row,$sql_data['lot_qty'],'string');
$col = 'L'; $row = '9';   $excel->place_value($col.$row,$sql_data['aql'],'string');
$col = 'Q'; $row = '9';   $excel->place_value($col.$row,$sql_data['sample_size'],'string');
$col = 'F'; $row = '10';   $excel->place_value($col.$row,$sql_data['date_inspected'],'string');
$col = 'F'; $row = '11';   $excel->place_value($col.$row,$sql_data['device_name'],'string');
$col = 'F'; $row = '12';   $excel->place_value($col.$row,$sql_data['lot_number'],'string');
$col = 'F'; $row = '13';   $excel->place_value($col.$row,$sql_data['reel_batch_no'],'string');
$col = 'F'; $row = '14';   $excel->place_value($col.$row,$sql_data['operator'],'string');
$col = 'M'; $row = '15';   $excel->place_value($col.$row,$sql_data['capa_due_date'],'string');

$attention_data = explode(',', $sql_data['attention']);
$attention = array();
for($i=0; $i<count($attention_data); $i++) {
	$attention[] = get_emp_name_by_username_systemone($attention_data[$i]);
}
$attention = implode(', ', $attention);
$col = 'E'; $row = '6';   $excel->place_value($col.$row,$attention,'string');

$verified_by_data = explode(',', $sql_data['verified_by']);
$verified_by = array();
for($i=0; $i<count($verified_by_data); $i++) {
	$verified_by[] = get_emp_name_by_username_systemone($verified_by_data[$i]);
}
$verified_by = implode(', ', $verified_by);
$col = 'F'; $row = '15';   $excel->place_value($col.$row,$verified_by,'string');

$disposition_data = explode(' | ', $sql_data['disposition']);
for($i=0; $i<count($disposition_data); $i++) {
	if(strstr($disposition_data[$i], 'SORTING')) { $col = 'J'; $row = '11';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'REWORK / REPAIR')) { 	 $col = 'J'; $row = '12';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'HOLD')) { 		 $col = 'J'; $row = '13';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'OTHERS')) { 
		$col = 'J'; $row = '14';   $excel->place_value($col.$row,'X','string'); 
		$col = 'M'; $row = '14';   $excel->place_value($col.$row,$sql_data['disposition_others'],'string');
	}
}

$col = 'C'; $row = '19';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['created_by']),'string');
$col = 'H'; $row = '19';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['checked_by']),'string');
$col = 'N'; $row = '19';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['approved_by']),'string');
$col = 'F'; $row = '23';   $excel->place_value($col.$row,$sql_data_prdn['sorted_qty'],'string');
$col = 'K'; $row = '23';   $excel->place_value($col.$row,$sql_data_prdn['ok_qty'],'string');
$col = 'P'; $row = '23';   $excel->place_value($col.$row,$sql_data_prdn['ng_qty'],'string');
$col = 'F'; $row = '24';   $excel->place_value($col.$row,$sql_data_prdn['mode_defect'],'string');
$col = 'C'; $row = '26';   $excel->place_value($col.$row,$sql_data_prdn['guaranteed_lot'],'string');
$col = 'C'; $row = '31';   $excel->place_value($col.$row,$sql_data_prdn['production_remarks'],'string');
$col = 'C'; $row = '38';   $excel->place_value($col.$row,$sql_data_prdn['treatment'],'string');
$col = 'C'; $row = '43';   $excel->place_value($col.$row,$sql_data_prdn['verification_result'],'string');
$col = 'N'; $row = '50';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['created_by']),'string');
/* Place e-sign here */
$prepared_by_esign = return_esign_by_username($sql_data['created_by']); $excel->add_image('C18',$prepared_by_esign,40);
$prepared_by_esign = return_esign_by_username($sql_data['created_by']); $excel->add_image('N49',$prepared_by_esign,40);
if($sql_data['checked_by_status'] == "ACCEPT") {  $checked_by_esign = return_esign_by_username($sql_data['checked_by']); $excel->add_image('H18',$checked_by_esign,40); }
if($sql_data['approved_by_status'] == "APPROVED") {  $checked_by_esign = return_esign_by_username($sql_data['approved_by']); $excel->add_image('N18',$checked_by_esign,40); }

/* set file name */
$filename = $sql_data['lon_no'];
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

?>