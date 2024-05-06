<?php
$oop 			= '../class/oop_tqts.php';
$common_handler = '../handler/common_function.php';
if(file_exists($oop)){
	require_once($oop);
	require_once($common_handler);
}else{
	echo 'oop not found!';
	exit;
}

/* Get ITN Details  */
$pkid = $_GET['pkid'];
$table  = "tbl_qfr_itn";
$fields = get_table_fields($table);
$array_fields = array('*');
$table  		= "tbl_qfr_itn";
$joins  	 	= "";
$sql_where  	= "WHERE `pkid` = '$pkid'";
$sql_order  	= "";
$sql_limit  	= "";
$result         = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$data           = array();
while($row = mysqli_fetch_array($result)){
	foreach($fields as $key => $value){
		$data[$value] = $row[$value];
	}
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
$excel->title = 'Attention Tag';
/* add a new page */
$excel->add_page();
$excel->set_page_orientation_a4_landscape();
/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

// $excel->set_margin();
$excel->set_margin_dynamic('0','0','0','0');
// $excel->set_print_area();

$width_allowance = .81;

/* set width */
$excel->set_width('A',0.42);
$excel->set_width('B',$width_allowance+11.43);
$excel->set_width('C',$width_allowance+3.14);
$excel->set_width('D',$width_allowance+1.57);
$excel->set_width('E',.25);
$excel->set_width('F',$width_allowance+3.14);
$excel->set_width('G',$width_allowance+1.43);
$excel->set_width('H',$width_allowance+0.50);
$excel->set_width('I',$width_allowance+3.00);
$excel->set_width('J',$width_allowance+1);
$excel->set_width('K',$width_allowance+3);
$excel->set_width('L',0.25);
$excel->set_width('M',0.25);
$excel->set_width('N',$width_allowance+3.57);
$excel->set_width('O',$width_allowance+4.71);
$excel->set_width('P',$width_allowance+3.71);
$excel->set_width('Q',$width_allowance+3.29);
$excel->set_width('R',$width_allowance+2.29);
$excel->set_width('S',$width_allowance+3.86);
$excel->set_width('T',$width_allowance+6.5);
$excel->set_width('U',0.42);

$excel->set_height('1',5.25);
$excel->set_height('2',10.5);
$excel->set_height('5',3.00);
$excel->set_height('6',12.75);
$excel->set_height('7',8.25);
$excel->set_height('8',12);
$excel->set_height('9',12);
$excel->set_height('10',12);
$excel->set_height('11',12);
$excel->set_height('12',12);
$excel->set_height('13',12);
$excel->set_height('14',12);
$excel->set_height('15',3.75);
$excel->set_height('16',3.75);
$excel->set_height('17',9.75);
$excel->set_height('18',9.75);
$excel->set_height('19',9);
$excel->set_height('20',6.75);
$excel->set_height('21',13.5);
$excel->set_height('22',9);
$excel->set_height('23',11.25);

$array_format = array(
	"fill_color" 		=> 'ffffff',
);
$excel->set_format('A1:U50',$array_format);

/* header */
/* Row 2 */
$col_letter = 'R';
$row_cnt 	= 2;
$excel->place_value($col_letter.$row_cnt,'QAQCF-0199-005','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8
);
$excel->set_format($col_letter.$row_cnt,$array_format);
$excel->set_outline_borders('B'.$row_cnt.':T4','thin');

/* Row 3 */
$col_letter = 'B';
$row_cnt 	= 3;
$excel->place_value($col_letter.$row_cnt,'PRICON MICROELECTRONICS, INC.','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 11,
	"bold" 			=> true,
	"h_alignment" 	=> 'center'
);
$excel->set_format($col_letter.$row_cnt,$array_format);
$excel->merge_cells($col_letter.$row_cnt.':T'.$row_cnt);

/* Row 4 */
$col_letter = 'B';
$row_cnt 	= 4;
$excel->place_value($col_letter.$row_cnt,'INSPECTION TROUBLE NOTICE','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 11,
	"bold" 			=> true,
	"h_alignment" 	=> 'center'
);
$excel->set_format($col_letter.$row_cnt,$array_format);
$excel->merge_cells($col_letter.$row_cnt.':T'.$row_cnt);

/* Row 5 */
$row_cnt 	= 5;
$excel->set_outline_borders('B'.$row_cnt.':T'.$row_cnt,'thin');

/* Row 6 */
$row_cnt 	= 6;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'ATTENTION','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,': '.$data['attention'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'CONTROL #','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,': '.$data['control_no'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);
$excel->set_outline_borders('B'.$row_cnt.':T'.($row_cnt+8),'thin');
for($x=0;$x<8;$x++){
	if($x==1){ continue; }
	$excel->set_borders('C'.($row_cnt+$x).':J'.($row_cnt+$x),0,0,0,1);
}
for($x=0;$x<8;$x++){
	if($x==1){ continue; }
	$excel->set_borders('P'.($row_cnt+$x).':T'.($row_cnt+$x),0,0,0,1);
}

/* Row 8 */
$row_cnt 	= 8;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'PROJECT','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,': '.$data['project'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'LOT NUMBER','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,': '.$data['lot_no'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 9 */
$row_cnt 	= 9;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'MODEL','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,': '.$data['model'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'DATE / TIME','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,': '.$data['date_time'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 10 */
$row_cnt 	= 10;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'STATION','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,': '.$data['station'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'SAMPLE','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,': '.$data['sample'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);


/* Row 11 */
$row_cnt 	= 11;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'NAME','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,': '.$data['name'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'AC/RE','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,': '.$data['ac_re'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 12 */
$row_cnt 	= 12;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'REFERENCE','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,': '.$data['reference'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'ISSUANCE DATE','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,': '.$data['issuance_date'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);


/* Row 13 */
$row_cnt 	= 13;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'LOT QUANTITY','string');
$col_letter = 'C';
$excel->place_value($col_letter.$row_cnt,':'.$data['lot_qty'],'string');
$col_letter = 'K';
$excel->place_value($col_letter.$row_cnt,'RETURN DATE','string');
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,':'.$data['return_date'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 15 */
$row_cnt 	= 15;
$excel->set_outline_borders('B'.$row_cnt.':T'.$row_cnt,'thin');

/* Row 17 */
$row_cnt 	= 17;
$col_letter = 'O';
$excel->place_value($col_letter.$row_cnt,'GATE','string');
$col_letter = 'S';
$excel->place_value($col_letter.$row_cnt,'SURVEILLANCE','string');
if($data['gate']=='1'){ 
	$array_format['fill_color'] = '000000'; 
	$excel->set_format('N'.($row_cnt),$array_format);
}
$excel->set_outline_borders('N'.($row_cnt),'thin');
if($data['surveillance']=='1'){ 
	$array_format['fill_color'] = '000000'; 
	$excel->set_format('Q'.($row_cnt),$array_format);
}
$excel->set_outline_borders('Q'.($row_cnt),'thin');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);
$excel->set_outline_borders('B'.($row_cnt-1).':L'.($row_cnt+3),'thin');
$excel->set_outline_borders('M'.($row_cnt-1).':T'.($row_cnt+3),'thin');

/* Row 18 */
$row_cnt 	= 18;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'SHIFT','string');
$col_letter = 'D';
$excel->place_value($col_letter.$row_cnt,'A','string');
$col_letter = 'G';
$excel->place_value($col_letter.$row_cnt,'B','string');
$col_letter = 'J';
$excel->place_value($col_letter.$row_cnt,'C','string');
if($data['shift_a']=='1'){ 
	$array_format['fill_color'] = '000000'; 
	$excel->set_format('C'.($row_cnt),$array_format);
}
$excel->set_outline_borders('C'.($row_cnt),'thin');
if($data['shift_b']=='1'){ 
	$array_format['fill_color'] = '000000'; 
	$excel->set_format('F'.($row_cnt),$array_format);
}
$excel->set_outline_borders('F'.($row_cnt),'thin');
if($data['shift_c']=='1'){ 
	$array_format['fill_color'] = '000000'; 
	$excel->set_format('I'.($row_cnt),$array_format);
}
$excel->set_outline_borders('I'.($row_cnt),'thin');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'center'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 19 */
$row_cnt 	= 19;
$col_letter = 'O';
$excel->place_value($col_letter.$row_cnt,'Normal','string');
$col_letter = 'Q';
$excel->place_value($col_letter.$row_cnt,'Tightened','string');
$col_letter = 'T';
$excel->place_value($col_letter.$row_cnt,'Reduced','string');
if($data['normal']=='1'){ 
	$excel->place_value('N'.($row_cnt),'X',$array_format,'string');
}
$excel->set_borders('N'.($row_cnt),0,0,0,1);
$array_format['h_alignment'] = 'center';
$excel->set_format('N'.($row_cnt),$array_format);
if($data['tightened']=='1'){ 
	$excel->place_value('P'.($row_cnt),'X',$array_format,'string');
}
$excel->set_borders('P'.($row_cnt),0,0,0,1);
$array_format['h_alignment'] = 'center';
$excel->set_format('P'.($row_cnt),$array_format);
if($data['reduced']=='1'){ 
	$excel->place_value('S'.($row_cnt),'X',$array_format,'string');
}
$excel->set_borders('S'.($row_cnt),0,0,0,1);
$array_format['h_alignment'] = 'center';
$excel->set_format('S'.($row_cnt),$array_format);

$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 21 */
$row_cnt 	= 21;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'FINDINGS / PROBLEM:','string');

$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 9,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':T'.$row_cnt,$array_format);
$excel->set_outline_borders('B'.($row_cnt).':T'.($row_cnt+8),'thin');

/* Row 21 */
$row_cnt = 21;
$excel->place_value('P'.($row_cnt),$data['fp_inspected_by'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('P'.$row_cnt.':T'.($row_cnt+$end_cnt),$array_format);

/* Row 22 */
$row_cnt 	= 22;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'Description of found non-conformity / discrepant product','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 7,
	"italic" 		=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':B'.$row_cnt,$array_format);
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Inspected by:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 23 */
$row_cnt 	= 23;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'STANDARD SPECIFICATION / S:','string');
$col_letter = 'G';
$excel->place_value($col_letter.$row_cnt,$data['standard_specification'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 7,
	"italic" 		=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A'.$row_cnt.':B'.$row_cnt,$array_format);
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Inspected by:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 24 */
$row_cnt = 24;
$findings_problem = explode("\n", $data['findings_problem']);
foreach($findings_problem as $key => $value){
	$excel->place_value('B'.($row_cnt+$key),$value,'string');
	$end_cnt = $key;
}
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.($row_cnt+$end_cnt),$array_format);
$excel->place_value('P'.($row_cnt),$data['fp_verfied_by'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('P'.$row_cnt.':T'.($row_cnt+$end_cnt),$array_format);

/* Row 25 */
$row_cnt 	= 25;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Verified by:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 26 */
$row_cnt 	= 26;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'LQC Supervisor','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 27 */
$row_cnt 	= 27;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,$data['fp_conformed_by'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 28 */
$row_cnt 	= 28;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Conformed by:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 29 */
$row_cnt 	= 29;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Line Supervisor:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 30 */
$row_cnt 	= 30;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'ANALYSIS:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);
$excel->set_outline_borders('B'.($row_cnt).':T'.($row_cnt+6),'thin');

/* Row 31 */
$row_cnt = 31;
$analysis = explode("\n", $data['analysis']);
foreach($analysis as $key => $value){
	$excel->place_value('B'.($row_cnt+$key),$value,'string');
	$end_cnt = $key;
}
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.($row_cnt+$end_cnt),$array_format);

/* Row 33 */
$row_cnt 	= 33;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,$data['a_validated_by'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 34 */
$row_cnt 	= 34;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Validated By:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 35 */
$row_cnt 	= 35;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Line Supervisor','string');
$excel->place_value($col_letter.$row_cnt,'Line Supervisor','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 36 */
$row_cnt 	= 36;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Date','string');
$col_letter = 'Q';
$excel->place_value($col_letter.$row_cnt,$data['a_date'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 37 */
$row_cnt 	= 37;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'CORRECTIVE ACTION','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);
$excel->set_outline_borders('B'.($row_cnt).':T'.($row_cnt+6),'thin');

/* Row 38 */
$row_cnt = 38;
$corrective_action = explode("\n", $data['corrective_action']);
foreach($corrective_action as $key => $value){
	$excel->place_value('B'.($row_cnt+$key),$value,'string');
	$end_cnt = $key;
}
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.($row_cnt+$end_cnt),$array_format);

/* Row 40 */
$row_cnt 	= 40;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,$data['ca_responsible'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 41 */
$row_cnt 	= 41;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Responsible:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 42 */
$row_cnt 	= 42;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Production/Engineering','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 43 */
$row_cnt 	= 43;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Date','string');
$col_letter = 'Q';
$excel->place_value($col_letter.$row_cnt,$data['ca_date'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 44 */
$row_cnt 	= 44;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'RESULT OF CONFIRMATION: ','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt,$array_format);
$col_letter = 'G';
$excel->place_value($col_letter.$row_cnt,'(To be filled up by QC personnel who','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 7,
	"italic" 		=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('C'.$row_cnt.':T'.$row_cnt,$array_format);
$excel->set_outline_borders('B'.($row_cnt).':T'.($row_cnt+5),'thin');

/* Row 45  */
$row_cnt 	= 45;
$col_letter = 'B';
$excel->place_value($col_letter.$row_cnt,'issued the notice confirming the implementation of corrective acction given)','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 7,
	"italic" 		=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 46 */
$row_cnt = 46;
$result_confirmation = explode("\n", $data['result_confirmation']);
foreach($result_confirmation as $key => $value){
	$excel->place_value('B'.($row_cnt+$key),$value,'string');
	$end_cnt = $key;
}
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.($row_cnt+$end_cnt),$array_format);
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,$data['rc_responsible'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('P'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 47  */
$row_cnt 	= 47;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Responsible:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('P'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 48  */
$row_cnt 	= 48;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Production/Engineering','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);

/* Row 49  */
$row_cnt 	= 49;
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,'Date','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B'.$row_cnt.':T'.$row_cnt,$array_format);
$col_letter = 'P';
$excel->place_value($col_letter.$row_cnt,$data['rc_date'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'left'
);
$excel->set_format('P'.$row_cnt.':T'.$row_cnt,$array_format);

$excel->set_margin_dynamic(.40,.27,0,.45);

/* set file name */
$filename = "ITN";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
