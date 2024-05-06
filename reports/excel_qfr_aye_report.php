<?php
// $cookie_name = 'download_type';
// $cookie_value = 'download_sa_report';
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$pkid = $_GET['pkid'];		
$array_fields = array('*');
$table 	   	= 'tbl_qfr_aye';
$joins 	   	= '';
$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
$sql_order 	= '';
$sql_limit 	= '';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return = array();
if($row = mysqli_fetch_array($result)){
	$return['pkid'] 					= $row['pkid'];
	$return['control_no'] 				= $row['control_no'];
	$return['category'] 				= $row['category'];
	$return['parts_affected_parts'] 	= $row['parts_affected_parts'];
	$return['part_code'] 				= $row['part_code'];
	$return['supplier'] 				= $row['supplier'];
	$return['lot_number'] 				= $row['lot_number'];
	$return['quantity'] 				= $row['quantity'];
	$return['sample_size']	 			= $row['sample_size'];
	$return['percent_ng']	 			= $row['percent_ng'];
	$return['date_issued']	 			= date('d-M-Y', strtotime($row['date_issued']));
	$return['device_name']	 			= $row['device_name'];
	$return['po_number'] 				= $row['po_number'];
	$return['po_qty'] 					= $row['po_qty'];
	$return['customer_name'] 			= $row['customer_name'];
	$return['shipment_date'] 			= date('d-M-Y', strtotime($row['shipment_date']));
	$return['remarks'] 					= $row['remarks'];
	$return['aye_judgement'] 			= $row['aye_judgement'];
	$return['judgement_date'] 			= $row['judgement_date'];
	$return['judgement_remarks'] 		= $row['judgement_remarks'];
	$return['illustration_name'] 		= $row['illustration_name'];
	$return['illustration_fkfile_path'] = $row['illustration_fkfile_path'];
	$return['file_path'] 				= return_file_path_by_pkid($return['illustration_fkfile_path']);
}
$return['ext']  						= pathinfo($return['illustration_name'], PATHINFO_EXTENSION);

$return['attached_file'] 				= $return['file_path'].$return['pkid'].'.'.$return['ext'];
$return['attached_file_link'] 			= str_replace('../../','../',$return['attached_file']);

if($return['category'] == 'Parts'){
	$return['device_name']				= 'n/a';
	$return['po_number']				= 'n/a';
	$return['po_qty']					= 'n/a';
	$return['customer_name']			= 'n/a';
	$return['shipment_date']			= 'n/a';
	
}else{
	$return['parts_affected_parts']     = 'n/a';
	$return['part_code']				= 'n/a';
	$return['supplier']					= 'n/a';
	$return['lot_number']				= 'n/a';
	$return['quantity']					= 'n/a';
}

function return_file_path_by_pkid($pkid) {
	require_once('../class/oop_tqts.php');
	$array_fields = array('	file_path');
	$table 	   	= 'tbl_file_path';
	$joins 	   	= '';
	$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	if($row = mysqli_fetch_array($result)){
		return $row['file_path'];
	} 
}

/* Do excel here */

$excel_class = '../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist'.$return['file_path'];
	exit;
}

$excel = new EXCEL;
/* set title */
$excel->title = $return['control_no'];
/* add a new page */
$excel->add_page();
/* use the default font style */
$excel->set_default_font_style();
/* select an active page */
$excel->set_active_sheet(0);

$excel->set_margin();
$excel->set_print_area();

$width_allowance = .81;

/* set width */
$excel->set_width('A',1.5);
$excel->set_width('B',$width_allowance+20);
$excel->set_width('C',1.2);
$excel->set_width('L',$width_allowance+20);
$excel->set_width('M',1.2);

/* place value */

$excel->place_value('B2','Control #','string');
$excel->place_value('B3','Part Name','string');
$excel->place_value('B4','Part Code','string');
$excel->place_value('B5','Supplier','string');
$excel->place_value('B6','Lot Number','string');
$excel->place_value('B7','Quantity','string');
$excel->place_value('B8','Sample Size','string');
$excel->place_value('B9','% NG','string');
$excel->place_value('B11','ILLUSTRATION:');
$excel->place_value('C47',':');
$excel->place_value('L2','Date Issued');
$excel->place_value('L3','Product Name');
$excel->place_value('L4','PO Number');
$excel->place_value('L5','PO Qty');
$excel->place_value('L6','Customer Name');
$excel->place_value('L7','Shipment Date');
$excel->place_value('L9','AYE Judgement');
$excel->place_value('L10','Date');
$excel->place_value('L11','Remarks');


for($i=2;$i<10; $i++) {
	$excel->place_value('C'.$i,':','string');
	$excel->place_value('M'.$i,':','string');
}

$excel->place_value('D2',$return['control_no'],'string');
$excel->place_value('D3',$return['parts_affected_parts'],'string');
$excel->place_value('D4',$return['part_code'],'string');
$excel->place_value('D5',$return['supplier'],'string');
$excel->place_value('D6',$return['lot_number'],'string');
$excel->place_value('D7',$return['quantity'],'string');
$excel->place_value('D8',$return['sample_size'],'string');
$excel->place_value('D9',$return['percent_ng'],'string');
$excel->place_value('N2',$return['date_issued'],'string');
$excel->place_value('N3',$return['device_name'],'string');
$excel->place_value('N4',$return['po_number'],'string');
$excel->place_value('N5',$return['po_qty'],'string');
$excel->place_value('N6',$return['customer_name'],'string');
$excel->place_value('N7',$return['shipment_date'],'string');
$excel->place_value('N9',$return['aye_judgement'],'string');
$excel->place_value('N10',$return['judgement_date'],'string');
$excel->place_value('N11',$return['judgement_remarks'],'string');
$excel->place_value('M8','');
$excel->place_value('M9',':');
$excel->place_value('M10',':');
$excel->place_value('M11',':');

/* attach image here */
if(file_exists($return['attached_file_link'])){
	$excel->add_image('B14',$return['attached_file'],"");
}else{
	$excel->place_value('B14','File does not exist'.$return['attached_file'],'string');
}

$array_format = array(
	"name" 			=> 'Arial',
	"size" 			=> 11,
	"bold" 			=> true,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'left'
);
$excel->set_format('B2:S11',$array_format);
$excel->set_outline_borders('B2:S47','medium');

/* set file name */
$filename = $return['control_no'];
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

/* delete cookie */
// setcookie($cookie_name, "", -1);
// setcookie($cookie_name, '', time() + 3600, "/");
?>
