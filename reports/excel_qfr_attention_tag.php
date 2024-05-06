<?php
$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$pkid = $_GET['pkid'];		
$array_fields = array('*');
$table 	   	= 'tbl_qfr_attention_tag';
$joins 	   	= '';
$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
$sql_order 	= '';
$sql_limit 	= '';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return = array();
while($row = mysqli_fetch_array($result)){
	$return['pkid'] 				= $row['pkid'];
	$return['category']	 			= explode( ",", $row['category'] );
	$return['control_no'] 			= $row['control_no'];
	$return['date'] 				= $row['date'];
	$return['product'] 				= $row['product'];
	$return['model'] 				= $row['model'];
	$return['partscode_pono'] 		= $row['partscode_pono'];
	$return['lot_number'] 			= $row['lot_number'];
	$return['quantity'] 			= $row['quantity'];
	$return['issued_by'] 			= $row['issued_by'];
	$return['description'] 			= $row['description'];
	$return['analysis'] 			= $row['analysis'];
	$return['disposition'] 			= $row['disposition'];
	$return['corrective_action'] 	= $row['corrective_action'];
	$return['remarks'] 				= $row['remarks'];
	$return['created_by'] 			= $row['created_by'];
	if($row['created_by'] == $_POST['username']){
		$return['editable']	= '1';
	}else{
		$return['editable']	= '0';
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

$width_allowance = .81;
/* set width */
$excel->set_width('A',83);
$excel->set_width('B',$width_allowance+0.50);
$excel->set_width('C',$width_allowance+2.43);
$excel->set_width('D',$width_allowance+9.43);
$excel->set_width('E',$width_allowance+0.58);
$excel->set_width('F',$width_allowance+10.43);
$excel->set_width('G',$width_allowance+8.57);
$excel->set_width('H',$width_allowance+9.14);
$excel->set_width('I',$width_allowance+0.58);
$excel->set_width('J',$width_allowance+10.57);
$excel->set_width('K',0.45);

$excel->set_height('1',3.00);
$excel->set_height('3',1.00);
$excel->set_height('39',3.00);
$excel->set_height('40',3.00);

/* header */
/* Row 2 */
$excel->merge_cells('B2:I2');
$excel->place_value('B2','                           ATTENTION TAG','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true
);
$excel->set_format('B2',$array_format);
$excel->place_value('J2','PMIF-1007-046','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 6,
	"h_alignment" 	=> 'center'
);
$excel->set_format('J2',$array_format);

/* Row 4 */
foreach($return['category'] as $key => $value){
	if($value == 'Material'){
		$array_format = array(
			"fill_color" 	=> '000000'
		);
		$excel->set_format('C4',$array_format);
	}
}
$excel->merge_cells('H4:J4');
$excel->set_borders('C4','1','1','1','1');
$excel->set_borders('H4:J4','','','','1');
$excel->place_value('H4',$return['control_no'],'string');
$excel->place_value('D4','Material','string');
$excel->place_value('G4','Control No. :','string');

/* Row 5 */
foreach($return['category'] as $key => $value){
	if($value == 'Workmanship'){
		$array_format = array(
			"fill_color" 	=> '000000'
		);
		$excel->set_format('C5',$array_format);
	}
}
$excel->set_borders('C5','1','1','1','1');
$excel->place_value('D5','Workmanship','string');

/* Row 6 */
foreach($return['category'] as $key => $value){
	if($value == 'Machine'){
		$array_format = array(
			"fill_color" 	=> '000000'
		);
		$excel->set_format('C6',$array_format);
	}
}
$excel->merge_cells('H6:J6');
$excel->set_borders('H6:J6','','','','1');
$excel->place_value('H6',date('M d, Y',strtotime($return['date'])),'string');
$excel->set_borders('C6','1','1','1','1');
$excel->place_value('D6','Machine','string');
$excel->place_value('G6','Date: ','string');

/* Row 7 */
foreach($return['category'] as $key => $value){
	if($value == 'Others'){
		$array_format = array(
			"fill_color" 	=> '000000'
		);
		$excel->set_format('C7',$array_format);
	}
}
$excel->set_borders('C7','1','1','1','1');
$excel->place_value('D7','Others','string');


/* Row 9 */
$excel->merge_cells('F9:G9');
$excel->set_borders('F9:G9','','','','1');
$excel->set_borders('J9','','','','1');
$excel->place_value('J9',$return['lot_number'],'string');
$excel->place_value('B9','Product','string');
$excel->place_value('F9',$return['product'],'string');
$excel->place_value('E9',':','string');
$excel->place_value('H9','Lot No.','string');
$excel->place_value('I9',':','string');

/* Row 10 */
$excel->merge_cells('F10:G10');
$excel->set_borders('F10:G10','','','','1');

$excel->set_borders('J10','','','','1');
$excel->place_value('J10',$return['quantity'],'string');
$excel->place_value('B10','Model','string');
$excel->place_value('F10',$return['model'],'string');
$excel->place_value('E10',':','string');
$excel->place_value('H10','Quantity','string');
$excel->place_value('I10',':','string');

/* Row 11 */
$excel->merge_cells('F11:G11');
$excel->set_borders('F11:G11','','','','1');
$excel->place_value('F11',$return['partscode_pono'],'string');
$excel->set_borders('J11','','','','1');
$excel->place_value('J11',$return['issued_by'],'string');
$excel->place_value('B11','Parts Code/ P.O. No.','string');
$excel->place_value('E11',':','string');
$excel->place_value('H11','Issued By','string');
$excel->place_value('I11',':','string');

/* Row 13 */
$excel->place_value('B13','DESCRIPTION:','string');
$description = explode("\n",$return['description']);
$current_row = 14;
foreach($description as $key => $value){
	$excel->place_value('B'.$current_row,$value,'string');
	$current_row++;
}
/* Row 18 */
$excel->place_value('B18','ANALYSIS:','string');
$analysis = explode("\n",$return['analysis']);
$current_row = 19;
foreach($analysis as $key => $value){
	$excel->place_value('B'.$current_row,$value,'string');
	$current_row++;
}

/* Row 23 */
$excel->place_value('B23','DISPOSITION/ RECOMMENDATION:','string');
$disposition = explode("\n",$return['disposition']);
$current_row = 24;
foreach($disposition as $key => $value){
	$excel->place_value('B'.$current_row,$value,'string');
	$current_row++;
}

/* Row 28 */
$excel->place_value('B28','CORRECTIVE/ PREVENTIVE ACTION:','string');
$corrective_action = explode("\n",$return['corrective_action']);
$current_row = 29;
foreach($corrective_action as $key => $value){
	$excel->place_value('B'.$current_row,$value,'string');
	$current_row++;
}

/* Row 33 */
$excel->place_value('B33','REMARKS:','string');
$remarks = explode("\n",$return['remarks']);
$current_row = 34;
foreach($remarks as $key => $value){
	$excel->place_value('B'.$current_row,$value,'string');
	$current_row++;
}

/* Row 37 */
$excel->set_borders('B36:E37','','','','1');
$excel->set_borders('H36:J37','','','','1');

/* Row 38 */
$excel->place_value('B38',"PROD'N/ENG'G/PPC",'string');
$excel->merge_cells('H38:J38');
$excel->place_value('H38',"QUALITY CONTROL",'string');


// $excel->setPrintFitToWidth();

// $excel->set_outline_borders('A1:K39','thin');
$excel->set_outline_borders('B2:J38','thin');
// $excel->set_page_break('A40');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"bold" 			=> false
);
$excel->set_format('B3:J37',$array_format);
$excel->set_margin_dynamic(.40,.0,0,.45);
$excel->set_print_area_dynamic('A1:K39');

/* set file name */
$filename = "Attention Tag";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
