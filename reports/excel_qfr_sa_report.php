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
$table 	   	= 'tbl_qfr_special_acceptance';
$joins 	   	= '';
$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
$sql_order 	= '';
$sql_limit 	= '';
$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return = array();
while($row = mysqli_fetch_array($result)){
	$return['pkid'] 					= $row['pkid'];
	$return['control_number'] 			= $row['control_number'];
	$return['category'] 				= $row['category'];
	$return['parts_affected_parts'] 	= $row['parts_affected_parts'];
	$return['part_code'] 				= $row['part_code'];
	$return['problem_parts'] 			= $row['problem_parts'];
	$return['supplier'] 				= $row['supplier'];
	$return['lot_number'] 				= $row['lot_number'];
	$return['quantity'] 				= $row['quantity'];
	$return['device_name']	 			= $row['device_name'];
	$return['problem_device'] 			= $row['problem_device'];
	$return['parts_affected_device'] 	= $row['parts_affected_device'];
	$return['po_number'] 				= $row['po_number'];
	$return['po_qty'] 					= $row['po_qty'];
	$return['affected_quantity'] 		= $row['affected_quantity'];
	$return['customer_name'] 			= $row['customer_name'];
	$return['shipment_date'] 			= $row['shipment_date'];
	$return['drawing_number'] 			= $row['drawing_number'];
	$return['other_details'] 			= $row['other_details'];
	$return['judgement_application'] 	= $row['judgement_application'];
	$return['judged_by'] 				= $row['judged_by'];
	$return['judged_by_approver'] 		= $row['judged_by_approver'];
	$return['notations_remarks'] 		= $row['notations_remarks'];
	$return['lastupdate'] 				= $row['lastupdate'];
	$return['created_by'] 				= $row['created_by'];
	$return['date_created'] 			= $row['date_created'];
	$return['username'] 				= $row['username'];
	$return['logdel'] 					= $row['logdel'];
}
if($return['category'] == 'Parts'){
	$return['po_number']				= '';
	$return['po_qty']					= '';
	$return['device_name']				= '';
	$return['problem_device']			= '';
	$return['affected_qty']				= '';
	$return['parts_affected_device']	= '';
	$return['customer_name']			= '';
	$return['shipment_date']			= '';
	
}else{
	$return['partcode']					= '';
	$return['parts_affected_parts']     = '';
	$return['problem_parts']			= '';
	$return['supplier']					= '';
	$return['lot_number']				= '';
	$return['quantity']					= '';
}
/* attached image */
$array_fields = array('pkid','fkspecial_acceptance','file_name','fkfile_path');
$table 	   	= 'tbl_qfr_special_acceptance_attachment';
$joins 	   	= '';
$sql_where 	= 'WHERE fkspecial_acceptance="'.$pkid.'" AND logdel = 0';
$sql_order 	= '';
$sql_limit 	= '';
$result		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
while($row = mysqli_fetch_array($result)){
	$return['attachhment_pkid'] 		= $row['pkid'];
	$return['fkspecial_acceptance'] 	= $row['fkspecial_acceptance'];
	$return['file_name'] 				= $row['file_name'];
	$return['fkfile_path'] 				= $row['fkfile_path'];
	$return['file_path'] 				= return_file_path_by_div_mod('sa');
}
$return['ext']  						= pathinfo($return['file_name'], PATHINFO_EXTENSION);
$return['attached_file'] 				= $return['file_path']['path'].$return['pkid'].'.'.$return['ext'];
$return['attached_file_link'] 			= str_replace('../../','../',$return['attached_file']);

function return_file_path_by_div_mod($module) {
	require_once('../class/oop_tqts.php');
	$array_fields = array('pkid','file_path');
	$table 	   	= 'tbl_file_path';
	$joins 	   	= '';
	$sql_where 	= 'WHERE module="'.$module.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$file  = array();
	if($row = mysqli_fetch_array($result)){
		$file['pkid'] 		= $row['pkid'];
		$file['path'] 		= $row['file_path'];
	}
	return $file;
}

// $prepared_by = get_user_information($return['created_by']);

// function get_user_information($username){
	// require_once('../class/oop_tqts.php');
	// $prepared_by = '';
	// $array_fields = array('pkid','file_path');
	// $table 	   	= 'tbl_useraccounts';
	// $joins 	   	= '';
	// $sql_where 	= 'WHERE module="'.$module.'" AND logdel=0';
	// $sql_order 	= '';
	// $sql_limit 	= '';
	// $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $file  = array();
	// if($row = mysqli_fetch_array($result)){
		// $file['pkid'] 		= $row['pkid'];
		// $file['path'] 		= $row['file_path'];
	// }
	// return $prepared_by;
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
$excel->title = 'Special Acceptance';
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
$excel->set_width('A',$width_allowance+24.86);
$excel->set_width('B',$width_allowance+35.71);
$excel->set_width('C',$width_allowance+4.43);
$excel->set_width('D',$width_allowance+4.00);
$excel->set_width('E',$width_allowance+8.43);
$excel->set_width('F',$width_allowance+7.71);
$excel->set_width('G',$width_allowance+7.43);
$excel->set_width('H',$width_allowance+4.00);
$excel->set_width('I',$width_allowance+12.86);
$excel->set_width('J',$width_allowance+12.29);
$excel->set_width('K',$width_allowance+4.43);

$excel->set_height('1',12.75);
$excel->set_height('2',9.75);
$excel->set_height('74',15.00);

/* header */
$excel->merge_cells('J2:K2');
$excel->merge_cells('A3:K3');
$excel->merge_cells('A4:H4');$excel->merge_cells('J4:K4');
$excel->merge_cells('A5:B5');$excel->merge_cells('C5:F5');
/* Row 2 */
/* header values */
$excel->place_value('J2','PQS-D01-014','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 8,
	"h_alignment" 	=> 'right'
);
$excel->set_format('A2:K2',$array_format);
/* Row 3 */
$excel->place_value('A3','REQUEST FOR SPECIAL ACCEPTANCE REPORT','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 20,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'center'
);
$excel->set_format('A3',$array_format);
$excel->set_borders('A3:K3',1,1,1,1);
$excel->place_value('J4',$return['control_number'],'string');
/* Row 4 */
$array_format = array(
	"fill_color" 	=> 'ccffcc'
);
$excel->set_format('A4:K4',$array_format);
$excel->place_value('I4','CONTROL #','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 11,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'center'
);
$excel->set_format('I4',$array_format);
$excel->set_borders('A4:K4',1,1,1,1);
/* Row 5 */
$excel->place_value('A5','I. PARTS  & PRODUCTS DETAILS','string');
$excel->place_value('C5','II. DISPOSITION','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A5:K5',$array_format);
$excel->set_outline_borders('A5:B5','thin');
$excel->set_outline_borders('C5:K5','thin');
/* Row 6 */
$excel->place_value('A6','  I.I Parts Details','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true,
	"fill_color" 	=> 'ffff00',
	"h_alignment" 	=> 'center'
);
$excel->set_format('A6:B6',$array_format);
$excel->set_borders('A6:B6',1,1,1,1);
$excel->place_value('C6','Judgment Application:','string');
$excel->place_value('H6','Judged By:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 10,
	"bold" 			=> true,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'left'
);
$excel->set_format('C6:K6',$array_format);
/* labels row A7 to A15 */
$excel->place_value('A7','      PARTS AFFECTED','string');
$excel->place_value('A9','      PART CODE:','string');
$excel->place_value('A10','      PROBLEM','string');
$excel->place_value('A11','      SUPPLIER NAME','string');
$excel->place_value('A12','      LOT NO.','string');
$excel->place_value('A13','      DRAWING NUMBER:','string');
$excel->place_value('A14','      QUANTITY','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 12,
	"bold" 			=> true,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A7:A15',$array_format);
/* labels row 7 to 15 */
$excel->place_value('B7','      '.$return['parts_affected_parts'],'string');
$excel->place_value('B9','      '.$return['part_code'],'string');
$excel->place_value('B10','      '.$return['problem_parts'],'string');
$excel->place_value('B11','      '.$return['supplier'],'string');
$excel->place_value('B12','      '.$return['lot_number'],'string');
$excel->place_value('B13','      '.$return['drawing_number'],'string');
$excel->place_value('B14','      '.$return['quantity'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 12,
	"bold" 			=> false,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'center'
);
$excel->set_format('B7:B15',$array_format);
$excel->set_outline_borders('A7:B15','thin');
/* Row 16 */
$excel->place_value('A16','  I.II Product Details','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A16:B16',$array_format);
$excel->set_borders('A16:B16',1,1,1,1);
/* labels row A17 to B24 */
$excel->place_value('A17','      DEVICE NAME','string');
$excel->place_value('A18','      PROBLEM','string');
$excel->place_value('A19','      PARTS AFFECTED','string');
$excel->place_value('A20','      P.O. #','string');
$excel->place_value('A21','      P.O. QTY','string');
$excel->place_value('A22','      AFFECTED QTY','string');
$excel->place_value('A23','      CUSTOMER NAME','string');
$excel->place_value('A24','      SHIPMENT DATE','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 12,
	"bold" 			=> true,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A17:A24',$array_format);
$excel->place_value('B17','      '.$return['device_name'],'string');
$excel->place_value('B18','      '.$return['problem_device'],'string');
$excel->place_value('B19','      '.$return['parts_affected_device'],'string');
$excel->place_value('B20','      '.$return['po_number'],'number_0_decimal');
$excel->place_value('B21','      '.$return['po_qty'],'number_0_decimal');
$excel->place_value('B22','      '.$return['affected_quantity'],'string');
$excel->place_value('B23','      '.$return['customer_name'],'string');
$excel->place_value('B24','      '.$return['shipment_date'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 12,
	"bold" 			=> false,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'center'
);
$excel->set_format('B17:B24',$array_format);
$excel->set_outline_borders('A17:B24','thin');
/* C7 to K24 */
$excel->set_outline_borders('C6:K24','thin');
$excel->set_borders('D7:D11',1,1,1,1);
$excel->place_value('E7','All incoming Parts','string');
$excel->place_value('E8','All incoming P.O.','string');
$excel->place_value('E9','Specific Parts Lot no.','string');
$excel->place_value('E10','Specific Product P.O. no.','string');
$excel->place_value('E11','Others, please specify','string');
if($return['judgement_application'] == "All incoming Parts"){
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('D7',$array_format);
}else if($return['judgement_application'] == "All incoming P.O."){
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('D8',$array_format);
}else if($return['judgement_application'] == "Specific Parts Lot no."){
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('D9',$array_format);
}else if($return['judgement_application'] == "Specific Product P.O. no."){
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('D10',$array_format);
}else if($return['judgement_application'] == 'Others') {
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('D11',$array_format);
}
$excel->set_borders('H7:H9',1,1,1,1);
$excel->place_value('I7','YEC QC','string');
$excel->place_value('I8','PMI Technical Adviser','string');
$excel->place_value('I9','Others, please specify','string');

if($return['judged_by'] == "YEC QC"){
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('H7',$array_format);
}else if($return['judged_by'] == "PMI Technical Adviser"){
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('H8',$array_format);
}else{
	$array_format = array(
		"fill_color" 	=> '000000'
	);
	$excel->set_format('H9',$array_format);
	$excel->place_value('I9','Others: '.$return['judged_by_approver'],'string');
}
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 11,
	"bold" 			=> false,
	"fill_color" 	=> '',
	"h_alignment" 	=> 'left'
);
$excel->set_format('C7:K24',$array_format);

$excel->place_value('H14','Name: ___________________','string');
$excel->place_value('H15','Sign: ____________________','string');
$excel->place_value('H16','Date / Time: ______________','string');
$excel->place_value('D18','Notations / Remarks:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 12,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('D14:H18',$array_format);
$excel->set_outline_borders('D19:J23','thin');
$excel->merge_cells('D19:J23');
$excel->place_value('D19',$return['notations_remarks'],'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 10,
	"bold" 			=> false,
	"h_alignment" 	=> 'left',
	"wordwrap"		=> true
);
$excel->set_format('D19',$array_format);
/* Row A25 */
$excel->place_value('A25','III. ILLUSTRATIONS','string');

$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A25:K25',$array_format);
$excel->set_outline_borders('A25:K25','medium');
/* Row A26 */
$excel->place_value('A26','Requirement: ','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 12,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A26',$array_format);
$excel->set_outline_borders('A26:K56','thin');
/* Row A57 */
$excel->place_value('A57','IV: OTHER DETAILS:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A57:K57',$array_format);
$excel->set_outline_borders('A57:K57','medium');
/* Row A58 */
$excel->place_value('A58'," (Details: Packaging / Lot number affected / runcard / traveller's card, etc)",'string');
$other_details = explode("\n",$return['other_details']);
$other_details_row_cnt = 59;
$ctr=0;
foreach($other_details as $key => $value){
	$excel->place_value('A'.$other_details_row_cnt, $other_details[$ctr], 'string');
	$other_details_row_cnt++;
	$ctr++;
}
$array_format = array(
	"size"		=> 10,
	"bold" 		=> false
);
$excel->set_format('A59:A71',$array_format);
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 10,
	"bold" 			=> false,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A58',$array_format);
$excel->set_outline_borders('A58:K71','thin');
/* Row A72 */
$excel->place_value('A72',"V: IN-CHARGE PERSON:",'string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 14,
	"bold" 			=> true,
	"fill_color" 	=> 'ccffcc',
	"h_alignment" 	=> 'left'
);
$excel->set_format('A72:K72',$array_format);
$excel->set_outline_borders('A72:K72','medium');
/* Row A73 */
$excel->place_value('A73',"Prepared By:",'string');
$excel->place_value('C73','Date prepared:','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 10,
	"h_alignment" 	=> 'left'
);
$excel->set_format('A73',$array_format);
$excel->set_format('C73',$array_format);

$excel->place_value('B73',$return['created_by'],'string');
$excel->place_value('F73',date('m/d/Y',strtotime($return['date_created'])),'string');
$array_format = array(
	"name" 			=> 'arial',
	"bold" 			=> true,
	"size" 			=> 10,
	"h_alignment" 	=> 'left'
);
$excel->set_format('B73',$array_format);
$excel->set_format('F73',$array_format);
$excel->merge_cells('F73:G73');

$excel->set_outline_borders('A73:K73','medium');
$excel->set_outline_borders('A3:K73','medium');

$excel->merge_cells('J74:K74');
$excel->place_value('J74','OP-QC-1013-005','string');
$array_format = array(
	"name" 			=> 'arial',
	"bold" 			=> true,
	"size" 			=> 8,
	"h_alignment" 	=> 'center'
);
$excel->set_format('J74',$array_format);

if(file_exists($return['attached_file_link'])){
	$excel->add_image('A27',$return['attached_file_link'],"");
}else{
	$excel->place_value('L5','file does not exist','string');
}

// $excel->place_value('A1',$return['pkid'],'string');
/* set file name */
// $filename = "Special Acceptance.xlsx";
$filename = "Special Acceptance.xls";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2003');

/* delete cookie */
// setcookie($cookie_name, "", -1);
// setcookie($cookie_name, '', time() + 3600, "/");
?>
