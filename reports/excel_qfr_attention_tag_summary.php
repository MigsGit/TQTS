<?php
$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}
// $pkid = $_GET['pkid'];
$array_fields 	= array('*');
$table 	   		= 'tbl_qfr_attention_tag';
$joins 	   		= '';
// $sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
$sql_where 		= $_GET['wh'];
$sql_order 		= 'ORDER BY `date` ASC';
$sql_limit 		= '';
$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$return 		= array();
while($row = mysqli_fetch_array($result)){
	$return['pkid'][] 				= $row['pkid'];
	$return['category'][] 			= $row['category'];
	$return['control_no'][]			= $row['control_no'];
	$return['date'][]				= $row['date'];
	$return['product'][]			= $row['product'];
	$return['model'][] 				= $row['model'];
	$return['partscode_pono'][]		= $row['partscode_pono'];
	$return['lot_number'][]			= $row['lot_number'];
	$return['quantity'][] 			= $row['quantity'];
	$return['issued_by'][] 			= $row['issued_by'];
	$return['description'][]		= $row['description'];
	$return['analysis'][] 			= $row['analysis'];
	$return['disposition'][]		= $row['disposition'];
	$return['corrective_action'][] 	= $row['corrective_action'];
	$return['remarks'][] 			= $row['remarks'];
	$return['incharge'][] 			= $row['incharge'];
	$return['status'][] 			= $row['status'];
	$return['created_by'][]			= $row['created_by'];
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

$excel->set_margin();
$excel->set_print_area();

$width_allowance = .81;

/* set width */
$excel->set_width('A',$width_allowance+15.86);
$excel->set_width('B',$width_allowance+28.43);
$excel->set_width('C',$width_allowance+28.00);
$excel->set_width('D',$width_allowance+28.86);
$excel->set_width('E',$width_allowance+18.71);
$excel->set_width('F',$width_allowance+28.71);
$excel->set_width('G',$width_allowance+45.86);
$excel->set_width('H',$width_allowance+21.71);
$excel->set_width('I',$width_allowance+23.57);

/* header */
/* Row 2 */
$excel->merge_cells('A1:I1');
$excel->place_value('A1','FY2017 ATTENTION TAG ISSUANCE SUMMARY LIST','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 18,
	"bold" 			=> true,
	"h_alignment"	=> "center"
);
$excel->set_format('A1',$array_format);

/* Row 2 */
$image = '../images/attention_tag_summary.png';
$excel->add_image('A2', $image, '175');

/* Row 11 */
$array_values 	 = array(
	"A11" => 'Date Issued',
	"B11" => 'Control Number',
	"C11" => 'Part Name / Series Name / Machine Name',
	"D11" => 'Problem',
	"E11" => 'Issued By',
	"F11" => 'Disposition',
	"G11" => 'Corrective Action',
	"H11" => 'Incharge',
	"I11" => 'Status of ATTN TAG'
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
$excel->set_format('A11:I11',$array_format);
$excel->set_borders('A11:I11','1','1','1','1');
$excel->set_outline_borders('A11:I11','medium');

$row_cnt = 12;
$row_start = 12;
$month_compare = '';
foreach($return['date'] as $key => $value){
	/* Month Label */
	$row_month = date('M-y',strtotime($return['date'][$key]));
	if($row_month != $month_compare){
		$excel->merge_cells('A'.$row_cnt.':I'.$row_cnt);
		$excel->place_value('A'.$row_cnt,$row_month,'string');
		$month_compare = $row_month;
		$array_format = array(
			"name" 			=> 'Arial',
			"fill_color"	=> 'ff99cc',
			"size" 			=> 12
		);
		$excel->set_format('A'.$row_cnt,$array_format);
		$row_cnt++;
	}
	$excel->place_value('A'.$row_cnt,date('m/d/Y',strtotime($return['date'][$key])),'string');
	$excel->place_value('B'.$row_cnt,$return['control_no'][$key],'string');
	$excel->place_value('C'.$row_cnt,$return['model'][$key],'string');
	$excel->place_value('D'.$row_cnt,$return['description'][$key],'string');
	$excel->place_value('E'.$row_cnt,$return['issued_by'][$key],'string');
	$excel->place_value('F'.$row_cnt,$return['disposition'][$key],'string');
	$excel->place_value('G'.$row_cnt,$return['corrective_action'][$key],'string');
	$excel->place_value('H'.$row_cnt,$return['incharge'][$key],'string');
	$excel->place_value('I'.$row_cnt,$return['status'][$key],'string');
	$array_format = array(
		"name" 			=> 'Arial',
		"size" 			=> 12
	);
	$excel->set_format('A'.$row_start.':I'.$row_cnt,$array_format);
	$row_cnt++;
}
$excel->set_borders('A'.$row_start.':I'.($row_cnt-1),'1','1','1','1');


// $excel->set_format('J2',$array_format);
// $excel->set_borders('C5','1','1','1','1');


/* set file name */
$filename = "Attention Tag";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
