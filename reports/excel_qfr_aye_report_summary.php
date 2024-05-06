<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
$category_parts 	= array();
$category_device 	= array();

$array_fields 	= array('pkid','control_no', 'category', 'parts_affected_parts', 'part_code', 'supplier', 'lot_number', 'quantity', 'sample_size', 'percent_ng', 
'date_issued', 'device_name', 'po_number', 'po_qty', 'customer_name', 'shipment_date', 'remarks', 'aye_judgement', 'judgement_date', 'judgement_remarks');
$table 	   		= 'tbl_qfr_aye';
$joins 	   		= '';
$sql_where 		= $_GET['wh'];
$sql_order 		= 'ORDER BY `category`,`control_no` ASC';
$sql_limit 		= '';
$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return 		= array();
while($row = mysqli_fetch_array($result)){
	if($row['category'] == 'Parts') {
		$category_parts['control_no'][] 			= $row['control_no'];
		$category_parts['category'][]				= $row['category'];
		$category_parts['date_issued'][]			= $row['date_issued'] == '' ? '' : date('M d, Y', strtotime($row['date_issued']));
		$category_parts['parts_affected_parts'][]	= $row['parts_affected_parts'];
		$category_parts['part_code'][]				= $row['part_code'];
		$category_parts['supplier'][]				= $row['supplier'];
		$category_parts['lot_number'][]				= $row['lot_number'];
		$category_parts['quantity'][]				= $row['quantity'];
		$category_parts['sample_size'][]			= $row['sample_size'];
		$category_parts['percent_ng'][]				= $row['percent_ng'];
		$category_parts['remarks'][]				= $row['remarks'];
		$category_parts['aye_judgement'][]			= $row['aye_judgement'];
		$category_parts['judgement_date'][]			= $row['judgement_date'] == '' ? '' : date('M d, Y', strtotime($row['judgement_date']));
		$category_parts['judgement_remarks'][]		= $row['judgement_remarks'];
	} else if($row['category'] == 'Device') {
		$category_device['control_no'][] 			= $row['control_no'];
		$category_device['category'][]				= $row['category'];
		$category_device['date_issued'][]			= $row['date_issued'] == '' ? '' : date('M d, Y', strtotime($row['date_issued']));
		$category_device['device_name'][]			= $row['device_name'];
		$category_device['po_number'][]				= $row['po_number'];
		$category_device['po_qty'][]				= $row['po_qty'];
		$category_device['customer_name'][]			= $row['customer_name'];
		$category_device['shipment_date'][]			= $row['shipment_date'] == '' ? '' : date('M d, Y', strtotime($row['shipment_date']));
		$category_device['sample_size'][]			= $row['sample_size'];
		$category_device['percent_ng'][]			= $row['percent_ng'];
		$category_device['remarks'][]				= $row['remarks'];
		$category_device['aye_judgement'][]			= $row['aye_judgement'];
		$category_device['judgement_date'][]		= $row['judgement_date'] == '' ? '' : date('M d, Y', strtotime($row['judgement_date']));
		$category_device['judgement_remarks'][]		= $row['judgement_remarks'];
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
$excel->title = 'Parts';
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
$excel->set_width('A',$width_allowance+28.43);
$excel->set_width('B',$width_allowance+18.86);
$excel->set_width('C',$width_allowance+28.86);
$excel->set_width('D',$width_allowance+28.86);
$excel->set_width('E',$width_allowance+18.86);
$excel->set_width('F',$width_allowance+18.86);
$excel->set_width('G',$width_allowance+18.86);
$excel->set_width('H',$width_allowance+18.86);
$excel->set_width('I',$width_allowance+18.86);
$excel->set_width('J',$width_allowance+40.71);
$excel->set_width('K',$width_allowance+28.86);
$excel->set_width('L',$width_allowance+28.86);
$excel->set_width('M',$width_allowance+28.86);

/* header */
/* Row 2 */
$excel->merge_cells('A1:M1');
$excel->place_value('A1','PARTS CATEGORY SUMMARY LIST','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 18,
	"bold" 			=> true,
	"h_alignment"	=> "center"
);
$excel->set_format('A1',$array_format);

/* Row 11 */
$array_values 	 = array(
	"A3" => 'Control #',
	"B3" => 'Data Issued',
	"C3" => 'Parts Name',
	"D3" => 'Part Code',
	"E3" => 'Supplier',
	"F3" => 'Lot #',
	"G3" => 'Quantity',
	"H3" => 'Sample Size',
	"I3" => '% NG',
	"J3" => 'Remarks',
	"K3" => 'AYE Judgement',
	"L3" => 'Judgement Date',
	"M3" => 'Judgement Remarks'
);
foreach($array_values as $key => $value){
	$excel->place_value($key,$value,'string');
}
$array_format = array(
	"name" 			=> 'Arial',
	"fill_color"	=> 'ffff99',
	"size" 			=> 12,
	"wordwrap"		=> true,
	"h_alignment" 	=> 'center'
);
$excel->set_format('A3:M3',$array_format);
$excel->set_borders('A3:M3','1','1','1','1');
$excel->set_outline_borders('A3:M3','medium');

$row_cnt = 4;
$row_start = 4;
$month_compare = '';
foreach($category_parts['control_no'] as $key => $value){
	$excel->place_value('A'.$row_cnt,$category_parts['control_no'][$key],'string');
	$excel->place_value('B'.$row_cnt,$category_parts['date_issued'][$key],'string');
	$excel->place_value('C'.$row_cnt,$category_parts['parts_affected_parts'][$key],'string');
	$excel->place_value('D'.$row_cnt,$category_parts['part_code'][$key],'string');
	$excel->place_value('E'.$row_cnt,$category_parts['supplier'][$key],'string');
	$excel->place_value('F'.$row_cnt,$category_parts['lot_number'][$key],'string');
	$excel->place_value('G'.$row_cnt,$category_parts['quantity'][$key],'string');
	$excel->place_value('H'.$row_cnt,$category_parts['sample_size'][$key],'string');
	$excel->place_value('I'.$row_cnt,$category_parts['percent_ng'][$key],'string');
	$excel->place_value('J'.$row_cnt,$category_parts['remarks'][$key],'string');
	$excel->place_value('K'.$row_cnt,$category_parts['aye_judgement'][$key],'string');
	$excel->place_value('L'.$row_cnt,$category_parts['judgement_date'][$key],'string');
	$excel->place_value('M'.$row_cnt,$category_parts['judgement_remarks'][$key],'string');
	$array_format = array(
		"name" 			=> 'Arial',
		"size" 			=> 12
	);
	$excel->set_format('A'.$row_start.':M'.$row_cnt,$array_format);
	$row_cnt++;
}
$excel->set_borders('A'.$row_start.':M'.($row_cnt-1),'1','1','1','1');

/* Create new sheet for Device data */
$excel->title = 'Device';
$excel->add_sheet(1);

/* set width */
$excel->set_width('A',$width_allowance+28.43);
$excel->set_width('B',$width_allowance+18.86);
$excel->set_width('C',$width_allowance+28.86);
$excel->set_width('D',$width_allowance+28.86);
$excel->set_width('E',$width_allowance+18.86);
$excel->set_width('F',$width_allowance+18.86);
$excel->set_width('G',$width_allowance+18.86);
$excel->set_width('H',$width_allowance+18.86);
$excel->set_width('I',$width_allowance+18.86);
$excel->set_width('J',$width_allowance+40.71);
$excel->set_width('K',$width_allowance+28.86);
$excel->set_width('L',$width_allowance+28.86);
$excel->set_width('M',$width_allowance+28.86);

/* header */
/* Row 2 */
$excel->merge_cells('A1:M1');
$excel->place_value('A1','DEVICE CATEGORY SUMMARY LIST','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 18,
	"bold" 			=> true,
	"h_alignment"	=> "center"
);
$excel->set_format('A1',$array_format);

/* Row 11 */
$array_values 	 = array(
	"A3" => 'Control #',
	"B3" => 'Data Issued',
	"C3" => 'Parts Name',
	"D3" => 'Part Code',
	"E3" => 'Supplier',
	"F3" => 'Lot #',
	"G3" => 'Quantity',
	"H3" => 'Sample Size',
	"I3" => '% NG',
	"J3" => 'Remarks',
	"K3" => 'AYE Judgement',
	"L3" => 'Judgement Date',
	"M3" => 'Judgement Remarks'
);
foreach($array_values as $key => $value){
	$excel->place_value($key,$value,'string');
}
$array_format = array(
	"name" 			=> 'Arial',
	"fill_color"	=> 'ffff99',
	"size" 			=> 12,
	"wordwrap"		=> true,
	"h_alignment" 	=> 'center'
);
$excel->set_format('A3:M3',$array_format);
$excel->set_borders('A3:M3','1','1','1','1');
$excel->set_outline_borders('A3:M3','medium');

$row_cnt = 4;
$row_start = 4;
$month_compare = '';
foreach($category_parts['control_no'] as $key => $value){
	$excel->place_value('A'.$row_cnt,$category_parts['control_no'][$key],'string');
	$excel->place_value('B'.$row_cnt,$category_parts['date_issued'][$key],'string');
	$excel->place_value('C'.$row_cnt,$category_parts['parts_affected_parts'][$key],'string');
	$excel->place_value('D'.$row_cnt,$category_parts['part_code'][$key],'string');
	$excel->place_value('E'.$row_cnt,$category_parts['supplier'][$key],'string');
	$excel->place_value('F'.$row_cnt,$category_parts['lot_number'][$key],'string');
	$excel->place_value('G'.$row_cnt,$category_parts['quantity'][$key],'string');
	$excel->place_value('H'.$row_cnt,$category_parts['sample_size'][$key],'string');
	$excel->place_value('I'.$row_cnt,$category_parts['percent_ng'][$key],'string');
	$excel->place_value('J'.$row_cnt,$category_parts['remarks'][$key],'string');
	$excel->place_value('K'.$row_cnt,$category_parts['aye_judgement'][$key],'string');
	$excel->place_value('L'.$row_cnt,$category_parts['judgement_date'][$key],'string');
	$excel->place_value('M'.$row_cnt,$category_parts['judgement_remarks'][$key],'string');
	$array_format = array(
		"name" 			=> 'Arial',
		"size" 			=> 12
	);
	$excel->set_format('A'.$row_start.':M'.$row_cnt,$array_format);
	$row_cnt++;
}
$excel->set_borders('A'.$row_start.':M'.($row_cnt-1),'1','1','1','1');

// /* set file name */
// $filename = "Pre-production Summary.xlsx";
$filename = "Pre-production Summary.xls";
// /* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
