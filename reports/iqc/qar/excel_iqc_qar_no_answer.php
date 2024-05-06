<?php
$oop = '../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}

// $pkid = $_GET['pkid'];		
// $array_fields = array('*');
// $table 	   	= 'tbl_qfr_attention_tag';
// $joins 	   	= '';
// $sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
// $sql_order 	= '';
// $sql_limit 	= '';
// $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// $script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
// $return = array();
// while($row = mysqli_fetch_array($result)){
	// $return['pkid'] 				= $row['pkid'];
	// $return['category']	 			= explode( ",", $row['category'] );
	// $return['control_no'] 			= $row['control_no'];
	// $return['date'] 				= $row['date'];
	// $return['product'] 				= $row['product'];
	// $return['model'] 				= $row['model'];
	// $return['partscode_pono'] 		= $row['partscode_pono'];
	// $return['lot_number'] 			= $row['lot_number'];
	// $return['quantity'] 			= $row['quantity'];
	// $return['issued_by'] 			= $row['issued_by'];
	// $return['description'] 			= $row['description'];
	// $return['analysis'] 			= $row['analysis'];
	// $return['disposition'] 			= $row['disposition'];
	// $return['corrective_action'] 	= $row['corrective_action'];
	// $return['remarks'] 				= $row['remarks'];
	// $return['created_by'] 			= $row['created_by'];
	// if($row['created_by'] == $_POST['username']){
		// $return['editable']	= '1';
	// }else{
		// $return['editable']	= '0';
	// }
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
$excel->title = 'Quality Alert Report';
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
// $excel->set_width('A',0.45);
// $excel->set_width('B',$width_allowance+0.50);
// $excel->set_width('C',$width_allowance+2.43);
// $excel->set_width('D',$width_allowance+13.49);
// $excel->set_width('E',$width_allowance+0.58);
// $excel->set_width('F',$width_allowance+10.43);
// $excel->set_width('G',$width_allowance+9.8);
// $excel->set_width('H',$width_allowance+9.14);
// $excel->set_width('I',$width_allowance+0.58);
// $excel->set_width('J',$width_allowance+14.53);
// $excel->set_width('K',0.45);


/* Row 2 */
// $excel->merge_cells('B2:I2');
$row = 'A'; $col = 1;
$excel->place_value($row.$col,'TS ALERT REPORT','string');
$array_format = array(
	"name" 			=> 'arial',
	"size" 			=> 28,
	"bold" 			=> true,
	"h_alignment" 	=> 'left'
);
$excel->set_format($row.$col,$array_format);



/* set file name */
$filename = "Quality Alert Report - QAR";
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');
?>
