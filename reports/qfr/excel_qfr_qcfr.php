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
// $pkid = 6;

$array_fields 	= array('*');
$table 	   		= ' tbl_qfr_qcfr';
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
$excel->title = $sql_data['qcfr_no'];
$excel->add_sheet(0);

/* use the default font style */
$excel->set_default_font_style();
$excel->set_margin();
$excel->set_print_area();

/* set format */
$array_format = array(
	"size"	=> 8,
	'fill_color'  => "FFFFFF"
);
$cell_range = 'B1:S84'; $excel->set_format($cell_range,$array_format);
$array_format_header = array(
	"bold"	=> true,
	"size"	=> 14,
	"h_alignment"	=> "center"
);
$cell_range = 'A3:R3'; $excel->set_format($cell_range,$array_format_header);

$array_format_labels = array(
	"bold"	=> true,
	"size"	=> 10
);
$cell_range = 'D6:K6'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'K8'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'B26'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'B63:R63'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'R65'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'B75:P76'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'F80:P80'; $excel->set_format($cell_range,$array_format_labels);

$array_format_labels = array(
	"bold"	=> true,
	"size"	=> 10,
	"h_alignment"	=> "center"
);
$cell_range = 'B69:R69'; $excel->set_format($cell_range,$array_format_labels);
$cell_range = 'B74:R74'; $excel->set_format($cell_range,$array_format_labels);

$array_format_center = array(
	"size"	=> 8,
	"h_alignment"	=> "center"
);
$cell_range = 'B17:R18'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'Q76:R83'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'C6'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'H6'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'N8:N12'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'K20'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'Q20'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'C65:C67'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'E65:E67'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'H65:H67'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'N65:N66'; $excel->set_format($cell_range,$array_format_center);
$cell_range = 'C77:C78'; $excel->set_format($cell_range,$array_format_center);

$width_allowance = .81;

/* set width */
$excel->set_width('A',$width_allowance+2);
$excel->set_width('B',$width_allowance);	
$excel->set_width('C',$width_allowance+3);	
$excel->set_width('D',$width_allowance+15);	
$excel->set_width('E',$width_allowance+3);	
$excel->set_width('F',$width_allowance+15);	
$excel->set_width('G',$width_allowance);	
$excel->set_width('H',$width_allowance+3);	
$excel->set_width('I',$width_allowance+15);
$excel->set_width('J',$width_allowance);
$excel->set_width('K',$width_allowance+3);
$excel->set_width('L',$width_allowance+11);
$excel->set_width('M',$width_allowance);
$excel->set_width('N',$width_allowance+3);
$excel->set_width('O',$width_allowance+8);
$excel->set_width('P',$width_allowance+5);
$excel->set_width('Q',$width_allowance+3);
$excel->set_width('R',$width_allowance+20);
$excel->set_width('S',$width_allowance);

/* set height */
$excel->set_height('1',19.5);
$excel->set_height('2',12);
$excel->set_height('3',18);
$excel->set_height('4',3);
$excel->set_height('5',3);
$excel->set_height('14',3);
$excel->set_height('19',3);
$excel->set_height('20',9.75);
$excel->set_height('21',3);
$excel->set_height('64',3);
$excel->set_height('84',3);

/* Merge Cells */
$excel->merge_cells('B3:S3');
$excel->merge_cells('B18:F18');
$excel->merge_cells('M6:S6');
$excel->merge_cells('F7:I7');
$excel->merge_cells('F8:I8');
$excel->merge_cells('F9:I9');
$excel->merge_cells('F10:I10');
$excel->merge_cells('F11:I11');
$excel->merge_cells('B17:F17');
$excel->merge_cells('G18:L18');
$excel->merge_cells('B22:E22');
$excel->merge_cells('B23:E23');
$excel->merge_cells('B24:E24');
$excel->merge_cells('B25:E25');
$excel->merge_cells('G19:I21');
$excel->merge_cells('L19:L21');
$excel->merge_cells('R19:S21');
$excel->merge_cells('G22:I22');
$excel->merge_cells('G23:I23');
$excel->merge_cells('G24:I24');
$excel->merge_cells('G25:I25');
$excel->merge_cells('B26:S26');
$excel->merge_cells('B63:F63');
$excel->merge_cells('G63:L63');
$excel->merge_cells('M63:P63');
$excel->merge_cells('Q63:R63');
$excel->merge_cells('B19:E21');
$excel->merge_cells('B69:S69');
$excel->merge_cells('B74:S74');
$excel->merge_cells('B75:E75');
$excel->merge_cells('B76:E76');
$excel->merge_cells('F19:F21');
$excel->merge_cells('F75:P75');
$excel->merge_cells('F76:P76');
$excel->merge_cells('F80:P80');
$excel->merge_cells('F77:P79');
$excel->merge_cells('F81:P83');
$excel->merge_cells('J23:L23');
$excel->merge_cells('J24:L24');
$excel->merge_cells('J25:L25');
$excel->merge_cells('Q23:S23');
$excel->merge_cells('Q24:S24');
$excel->merge_cells('Q25:S25');
$excel->merge_cells('Q67:S67');
$excel->merge_cells('Q75:S75');
$excel->merge_cells('Q76:S76');
$excel->merge_cells('Q77:S77');
$excel->merge_cells('Q78:S78');
$excel->merge_cells('Q79:S79');
$excel->merge_cells('Q80:S80');
$excel->merge_cells('Q81:S81');
$excel->merge_cells('Q82:S82');
$excel->merge_cells('Q83:S83');
$excel->merge_cells('C27:S35');
$excel->merge_cells('C71:R72');

/* 
	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/
$cell = 'B1:S84'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'B4:I14'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'J4:S14'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'B15:S15'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'F15:F18'; $excel->set_borders($cell,0,1,0,0, "medium");	
$cell = 'M15:M18'; $excel->set_borders($cell,1,0,0,0, "medium");	
// $cell = 'Q16:Q18'; $excel->set_borders($cell,0,1,0,0, "medium");	
$cell = 'B63:F68'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'M63:P68'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'B63:S63'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'B69:S69'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'B74:R74'; $excel->set_borders($cell,1,1,1,1, "medium");	
$cell = 'B75:E84'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'Q75:S84'; $excel->set_borders($cell,1,1,1,0, "medium");	
$cell = 'B84:S84'; $excel->set_borders($cell,0,0,0,1, "medium");	
$cell = 'C6'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'H6'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N8'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N9'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N10'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N11'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N12'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'K20'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'Q20'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'C65'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'C66'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'C67'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'E65'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'E66'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'E67'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'H65'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'H66'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'H67'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N65'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'N66'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'C77'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'C78'; $excel->set_borders($cell,1,1,1,1, "thin");	//box
$cell = 'M6:R6'; $excel->set_borders($cell,0,0,0,1, "thin");	//line
$cell = 'F8:I8'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'F10:I10'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'F11:I11'; $excel->set_borders($cell,0,0,0,1, "thin");	//line
$cell = 'B15:R15'; $excel->set_borders($cell,0,0,0,1, "thin");	//line
$cell = 'B18:R18'; $excel->set_borders($cell,0,0,0,1, "double");	//line
$cell = 'B22:R22'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'B23:R23'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'B24:R24'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'B24:R25'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'F19:F25'; $excel->set_borders($cell,1,1,0,0, "thin");	//line
$cell = 'I19:I25'; $excel->set_borders($cell,0,1,0,0, "thin");	//line
$cell = 'L23:L25'; $excel->set_borders($cell,0,1,0,0, "thin");	//line
$cell = 'P23:P25'; $excel->set_borders($cell,0,1,0,0, "thin");	//line
$cell = 'Q77:R77'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'Q80:R80'; $excel->set_borders($cell,0,0,1,1, "thin");	//line
$cell = 'Q83:R83'; $excel->set_borders($cell,0,0,1,0, "thin");	//line

$col = 'B'; $row = '1';
$excel->set_height('1',10.00);
$pmi_logo	= '../../images/pmi-logo2.png';
$excel->add_image($col.$row,$pmi_logo,'26px');

/* Place value */
$col = 'B'; $row = '3';   $excel->place_value($col.$row,'QUALITY COMPLAINT FEEDBACK REPORT','string');
$col = 'D'; $row = '6';   $excel->place_value($col.$row,'Supplier/Subcon ','string');
$col = 'I'; $row = '6';   $excel->place_value($col.$row,'PMI Assy.','string');
$col = 'K'; $row = '6';   $excel->place_value($col.$row,'QCFR No. :','string');
$col = 'C'; $row = '7';   $excel->place_value($col.$row,'  TO','string');
$col = 'C'; $row = '8';   $excel->place_value($col.$row,'  CC','string');
$col = 'C'; $row = '9';   $excel->place_value($col.$row,'  ATTN','string');
$col = 'C'; $row = '10';   $excel->place_value($col.$row,'  FROM','string');
$col = 'C'; $row = '11';   $excel->place_value($col.$row,'  DATE ISSUED','string');
$col = 'E'; $row = '7';   $excel->place_value($col.$row,':','string');
$col = 'E'; $row = '8';   $excel->place_value($col.$row,':','string');
$col = 'E'; $row = '9';   $excel->place_value($col.$row,':','string');
$col = 'E'; $row = '10';   $excel->place_value($col.$row,':','string');
$col = 'E'; $row = '11';   $excel->place_value($col.$row,':','string');
$col = 'K'; $row = '8';   $excel->place_value($col.$row,'Found During :','string');
$col = 'K'; $row = '9';   $excel->place_value($col.$row,'  (発見工程):','string');
$col = 'O'; $row = '8';   $excel->place_value($col.$row,' Outgoing Inspection','string');
$col = 'O'; $row = '9';   $excel->place_value($col.$row,' Incoming Inspection','string');
$col = 'O'; $row = '10';   $excel->place_value($col.$row,' In-Process Inspection','string');
$col = 'O'; $row = '11';   $excel->place_value($col.$row,' Quality System Check','string');
$col = 'O'; $row = '12';   $excel->place_value($col.$row,' Others (specify)','string');
$col = 'O'; $row = '13';   $excel->place_value($col.$row,($sql_data['found_during_others']),'string');
$col = 'B'; $row = '15';   $excel->place_value($col.$row,'Reported by :','string');
$col = 'H'; $row = '15';   $excel->place_value($col.$row,'Verified & Conformed by :','string');
$col = 'N'; $row = '15';   $excel->place_value($col.$row,'Approved by :','string');
$col = 'B'; $row = '18';   $excel->place_value($col.$row,'LQC','string');
$col = 'G'; $row = '18';   $excel->place_value($col.$row,'LQC / Production / Engineering','string');
$col = 'M'; $row = '18';   $excel->place_value($col.$row,'Section Head','string');
$col = 'R'; $row = '18';   $excel->place_value($col.$row,'Department Head','string');
$col = 'B'; $row = '19';   $excel->place_value($col.$row,'Product Name(   品名     )','string');
$col = 'G'; $row = '19';   $excel->place_value($col.$row,'Inspection Method(検査法)','string');
$col = 'L'; $row = '19';   $excel->place_value($col.$row,'Sampling (抽出）','string');
$col = 'R'; $row = '19';   $excel->place_value($col.$row,'100%','string');
$col = 'B'; $row = '22';   $excel->place_value($col.$row,'Model No.(モデル番号)','string');
$col = 'G'; $row = '22';   $excel->place_value($col.$row,'Sampling Plan(抽出計画)','string');
$col = 'J'; $row = '22';   $excel->place_value($col.$row,'AQL=','string');
$col = 'N'; $row = '22';   $excel->place_value($col.$row,'n=','string');
$col = 'P'; $row = '22';   $excel->place_value($col.$row,'Ac=','string');
$col = 'R'; $row = '22';   $excel->place_value($col.$row,'Re=','string');
$col = 'B'; $row = '23';   $excel->place_value($col.$row,'Batch No./Lot No.(ロット番)','string');
$col = 'G'; $row = '23';   $excel->place_value($col.$row,'Affected Qty. (N)(総計)','string');
$col = 'N'; $row = '23';   $excel->place_value($col.$row,'% Defective(不良)','string');
$col = 'B'; $row = '24';   $excel->place_value($col.$row,'P.O. No. / INV. No.(指番号)','string');
$col = 'G'; $row = '24';   $excel->place_value($col.$row,'Defective Qty.(不良数)','string');
$col = 'N'; $row = '24';   $excel->place_value($col.$row,'No. of Occurrence(件数)','string');
$col = 'B'; $row = '25';   $excel->place_value($col.$row,'Date Received(受領日)','string');
$col = 'G'; $row = '25';   $excel->place_value($col.$row,'Date Encountered','string');
$col = 'N'; $row = '25';   $excel->place_value($col.$row,'Ref. QCFR No.(参考番)','string');
$col = 'B'; $row = '26';   $excel->place_value($col.$row,'<FAILURE / DEFECT DESCRIPTION>   NOTE : Use additional attachment if necessary','string');
$col = 'B'; $row = '63';   $excel->place_value($col.$row,'Disposition (処理)','string');
$col = 'G'; $row = '63';   $excel->place_value($col.$row,'Nature of Request (依頼の内容)','string');
$col = 'M'; $row = '63';   $excel->place_value($col.$row,'Answer（解答）','string');
$col = 'Q'; $row = '63';   $excel->place_value($col.$row,'Date Answer Required','string');
$col = 'D'; $row = '65';   $excel->place_value($col.$row,'Rework/Repair(修理)','string');
$col = 'F'; $row = '65';   $excel->place_value($col.$row,'Return(返す)','string');
$col = 'I'; $row = '65';   $excel->place_value($col.$row,'For Information only (報告する為)','string');
$col = 'O'; $row = '65';   $excel->place_value($col.$row,'Need (必用)','string');
$col = 'R'; $row = '65';   $excel->place_value($col.$row,'(回答希望日)','string');
$col = 'D'; $row = '66';   $excel->place_value($col.$row,'Use as is(使用可)','string');
$col = 'F'; $row = '66';   $excel->place_value($col.$row,'100% sorting','string');
$col = 'I'; $row = '66';   $excel->place_value($col.$row,'Submit 8D Report','string');
$col = 'O'; $row = '66';   $excel->place_value($col.$row,'No Need (不必要)','string');
$col = 'D'; $row = '67';   $excel->place_value($col.$row,'Replace (取り替える)','string');
$col = 'F'; $row = '67';   $excel->place_value($col.$row,'Others (specify)','string');
$col = 'I'; $row = '67';   $excel->place_value($col.$row,'Corrective & Preventive Action Report','string');
$col = 'B'; $row = '69';   $excel->place_value($col.$row,'Recipient Fill-In (回答欄)','string');
$col = 'B'; $row = '74';   $excel->place_value($col.$row,'PMI / Originator Fill-In (PMI記入)','string');
$col = 'B'; $row = '75';   $excel->place_value($col.$row,'Factory Line Audit? ','string');
$col = 'F'; $row = '75';   $excel->place_value($col.$row,'<Result Confirmation>(結果の確認)','string');
$col = 'B'; $row = '76';   $excel->place_value($col.$row,'(工場ライン監査)  ','string');
$col = 'F'; $row = '76';   $excel->place_value($col.$row,'1. Treatment for affected lot:','string');
$col = 'D'; $row = '77';   $excel->place_value($col.$row,'Yes','string');
$col = 'Q'; $row = '77';   $excel->place_value($col.$row,'Prepared by','string');
$col = 'D'; $row = '78';   $excel->place_value($col.$row,'No','string');
$col = 'F'; $row = '80';   $excel->place_value($col.$row,'2. Verification result for corrective and preventive action:','string');
$col = 'Q'; $row = '80';   $excel->place_value($col.$row,'Checked by (確認者)','string');
$col = 'Q'; $row = '83';   $excel->place_value($col.$row,'Approved by (承認者)','string');

/* Set data value */
$col = 'M'; $row = '6';   $excel->place_value($col.$row,$sql_data['qcfr_no'],'string');
$col = 'F'; $row = '7';   $excel->place_value($col.$row,$sql_data['to'],'string');
$col = 'F'; $row = '10';   $excel->place_value($col.$row,$sql_data['from'],'string');
$col = 'F'; $row = '11';   $excel->place_value($col.$row,$sql_data['date_issued'],'string');
$col = 'B'; $row = '17';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['reported_by']),'string');
$col = 'F'; $row = '19';   $excel->place_value($col.$row,$sql_data['product_name'],'string');
$col = 'F'; $row = '22';   $excel->place_value($col.$row,$sql_data['model_no'],'string');
$col = 'F'; $row = '23';   $excel->place_value($col.$row,$sql_data['batch_no_lot_no'],'string');
$col = 'F'; $row = '24';   $excel->place_value($col.$row,$sql_data['po_no_invoice_no'],'string');
$col = 'F'; $row = '25';   $excel->place_value($col.$row,$sql_data['date_received'],'string');
$col = 'K'; $row = '20';   $excel->place_value($col.$row,($sql_data['inspection_method'] == 'Sampling' ? 'X' : ''),'string');
$col = 'Q'; $row = '20';   $excel->place_value($col.$row,($sql_data['inspection_method'] == '100%' ? 'X' : ''),'string');
$col = 'L'; $row = '22';   $excel->place_value($col.$row,$sql_data['sampling_plan_aql'],'string');
$col = 'O'; $row = '22';   $excel->place_value($col.$row,$sql_data['sampling_plan_n'],'string');
$col = 'Q'; $row = '22';   $excel->place_value($col.$row,$sql_data['sampling_plan_ac'],'string');
$col = 'R'; $row = '22';   $excel->place_value($col.$row,'Re= '.$sql_data['sampling_plan_re'],'string');
$col = 'J'; $row = '23';   $excel->place_value($col.$row,$sql_data['affected_qty'],'string');
$col = 'Q'; $row = '23';   $excel->place_value($col.$row,$sql_data['defective_percentage'],'string');
$col = 'J'; $row = '24';   $excel->place_value($col.$row,$sql_data['defective_qty'],'string');
$col = 'Q'; $row = '24';   $excel->place_value($col.$row,$sql_data['no_of_occurence'],'string');
$col = 'J'; $row = '25';   $excel->place_value($col.$row,$sql_data['date_encountered'],'string');
$col = 'Q'; $row = '25';   $excel->place_value($col.$row,$sql_data['reference_qcfr_no'],'string');
$col = 'C'; $row = '27';   $excel->place_value($col.$row,$sql_data['failure_defect_description'],'string');
$col = 'N'; $row = '65';   $excel->place_value($col.$row,($sql_data['answer'] == 'Need' ? 'X' : ''),'string');
$col = 'N'; $row = '66';   $excel->place_value($col.$row,($sql_data['answer'] == 'No Need' ? 'X' : ''),'string');
$col = 'Q'; $row = '67';   $excel->place_value($col.$row,($sql_data['answer'] == 'No Need' ? 'N/A' : $sql_data['date_answer_required']),'string');
$col = 'C'; $row = '77';   $excel->place_value($col.$row,($sql_data['factory_line_audit'] == 'Yes' ? 'X' : ''),'string');
$col = 'C'; $row = '78';   $excel->place_value($col.$row,($sql_data['factory_line_audit'] == 'No' ? 'X' : ''),'string');
$col = 'F'; $row = '77';   $excel->place_value($col.$row,$sql_data['treatment_affected_lot'],'string');
$col = 'F'; $row = '81';   $excel->place_value($col.$row,$sql_data['verification_result'],'string');
$col = 'Q'; $row = '76';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['reported_by']),'string');
$col = 'Q'; $row = '79';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['pmi_orginator_fill_in_checked_by']),'string');
$col = 'Q'; $row = '82';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['pmi_orginator_fill_in_approved_by']),'string');

if($sql_data['subcon_pmi'] == 'Supplier/Subcon') {
	$col = 'C'; $row = '6';   $excel->place_value($col.$row,'X','string');
	$col = 'F'; $row = '8';   $excel->place_value($col.$row,$sql_data['cc_supplier'],'string');
	$excel->merge_cells('G17:L17'); 
	$col = 'G'; $row = '17';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['verified_conformed_by_lqc']),'string');
	$col = 'G'; $row = '18';   $excel->place_value($col.$row,'LQC','string');
	$excel->merge_cells('M16:R16'); 
	$excel->merge_cells('M17:R17'); 
	$excel->merge_cells('M18:R18'); 
	$col = 'M'; $row = '17';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($sql_data['approved_by_sh']),'string');
} else {
	$col = 'H'; $row = '6';   $excel->place_value($col.$row,'X','string');
	
	$cc_pmi = '';
	$cc_pmi_data = explode(' | ', $sql_data['cc_pmi']);
	for($i=0; $i<count($cc_pmi_data); $i++) {
		$cc_pmi .= get_emp_name_by_username_systemone($cc_pmi_data[$i]);
	}
	$col = 'C'; $row = '8';   $excel->place_value($col.$row,$cc_pmi,'string');
}

$attn_data = explode(' | ', $sql_data['attn']);
for($i=0; $i<count($attn_data); $i++) {	
	$col = 'F'; $row = '9';   $excel->place_value($col.$row,get_emp_name_by_username_systemone($attn_data[$i]),'string');
}
// echo $sql_data['found_during'];
$found_during_data = explode(' | ', $sql_data['found_during']);
for($i=0; $i<count($found_during_data); $i++) {
	if(strstr($found_during_data[$i], 'Outgoing Inspection')) { 	$col = 'N'; $row = '8';    $excel->place_value($col.$row,'X','string'); }
	if(strstr($found_during_data[$i], 'Incoming Inspection')) { 	$col = 'N'; $row = '9';    $excel->place_value($col.$row,'X','string'); }
	if(strstr($found_during_data[$i], 'In-Process Inspection')) { 	$col = 'N'; $row = '10';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($found_during_data[$i], 'Quality System Check')) { 	$col = 'N'; $row = '11';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($found_during_data[$i], 'Others. Please Specify')) { 
		$col = 'N'; $row = '12';   $excel->place_value($col.$row,'X','string'); 
		$col = 'N'; $row = '13';   $excel->place_value($col.$row,$sql_data['found_during_others'],'string'); 	
	}
}
// $col = 'C'; $row = '62';   $excel->place_value($col.$row,$sql_data['disposition'],'string'); 
$disposition_data = explode(' | ', $sql_data['disposition']);
for($i=0; $i<count($disposition_data); $i++) {
	if(strstr($disposition_data[$i], 'Rework/Repair')) { $col = 'C'; $row = '65';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'Use as is')) { 	 $col = 'C'; $row = '66';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'Replace')) { 		 $col = 'C'; $row = '67';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'Return')) { 		 $col = 'E'; $row = '65';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], '100% sorting')) { 	$col = 'E'; $row = '66';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($disposition_data[$i], 'Others (specify)')) { 
		$col = 'E'; $row = '67';   $excel->place_value($col.$row,'X','string'); 
		$col = 'E'; $row = '68';   $excel->place_value($col.$row,$sql_data['disposition_others'],'string');
	}
}

$nature_of_request_data = explode(' | ', $sql_data['nature_of_request']);
for($i=0; $i<count($nature_of_request_data); $i++) {
	if(strstr($nature_of_request_data[$i], 'For Information only')) { 	$col = 'H'; $row = '65';   $excel->place_value($col.$row,'X','string'); }
	if(strstr($nature_of_request_data[$i], 'Submit 8D report')) { 
		$col = 'H'; $row = '66';   $excel->place_value($col.$row,'X','string'); 
		$col = 'C'; $row = '71';   $excel->place_value($col.$row,'See attached data','string'); 
	}
	if(strstr($nature_of_request_data[$i], 'Corrective & Preventive Action Report')) { 
		$col = 'H'; $row = '67';   $excel->place_value($col.$row,'X','string'); 
		$col = 'C'; $row = '71';   $excel->place_value($col.$row,'See attached data','string'); 	
	}
}

/* set file name */
$filename = $sql_data['qcfr_no'];
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>