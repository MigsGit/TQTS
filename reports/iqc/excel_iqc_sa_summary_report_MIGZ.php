<?php
// $cookie_name = 'download_type';
// $cookie_value = 'download_sa_report';
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$oop = '../../class/oop_tqts.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}

$oop = '../../handler/common_function.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oop not found!';
	exit;
}

$sar_summary_date = $_GET['sar_summary_date'];

function get_special_acceptance($sar_summary_date){
	$sar_summary_date = explode(' - ',$sar_summary_date);
	$array_fields = array('MONTHNAME( `date_created` ) as created_at , tbl_qfr_special_acceptance.*');
	$table 	   	= 'tbl_qfr_special_acceptance';
	$joins 	   	= '';
	// $sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
	$sql_where 	= 'WHERE 1=1';
	$sql_where  .= " AND DATE(`date_created`) BETWEEN ' " .date('Y-m-d', strtotime($sar_summary_date[0])). " ' AND ' " .date('Y-m-d', strtotime($sar_summary_date[1])). " ' ";
	// $sql_where .= " AND DATE(`date_created`) BETWEEN '2024-01-01' AND '2024-08-01' AND logdel=0";
	// $sql_where .= " AND date_issued IS NOT NULL";
	$sql_order 	= 'ORDER BY pkid ASC';
	$sql_limit 	= '';
	$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$return = array();
	while($row = mysqli_fetch_array($result)){
		$return['pkid'][] 							= $row['pkid'];
		$return['control_number'][] 				= $row['control_number'];
		// $return['category'][] 					= $row['category'];
		$return['parts_affected_parts'][] 			= $row['parts_affected_parts'];     
		// $return['part_code'][] 					= $row['part_code'];
		// $return['problem_parts'][] 				= $row['problem_parts'];
		$return['supplier'][] 						= $row['supplier'];
		// $return['lot_number'][] 					= $row['lot_number'];
		// $return['quantity'][] 					= $row['quantity'];
		$return['device_name'][]	 				= $row['device_name'];  
		// $return['problem_device'][] 				= $row['problem_device'];
		// $return['parts_affected_device'][] 		= $row['parts_affected_device'];
		// $return['po_number'][] 					= $row['po_number'];
		// $return['po_qty'][] 						= $row['po_qty'];
		// $return['affected_quantity'][] 			= $row['affected_quantity'];
		// $return['customer_name'][] 					= $row['customer_name'];
		// $return['shipment_date'][] 				= $row['shipment_date'];
		// $return['drawing_number'][] 				= $row['drawing_number'];
		// $return['other_details'][] 				= $row['other_details'];
		// $return['judgement_application'][] 		= $row['judgement_application'];
		// $return['judged_by'][] 					= $row['judged_by'];
		// $return['judged_by_approver'][] 			= $row['judged_by_approver'];
		// $return['notations_remarks'][] 			= $row['notations_remarks'];
		// $return['lastupdate'][] 					= $row['lastupdate'];
		$return['created_by'][] 					= get_emp_name_by_username_systemone($row['created_by']);
		$return['section'][] 						= get_assigned_section($row['created_by']);
		$return['problem'][] 						= $row['problem'];
		$return['factory_location'][] 				= $row['factory_location'];
		$return['date_issued'][] 					= $row['date_issued'];
		$return['immediate_action'][] 				= ($row['immediate_action'] != null) ? $row['immediate_action'] : "" ;
		$return['immediate_action_due_date'][] 		= $row['immediate_action_due_date'];
		$return['permanent_action'][] 				= $row['permanent_action'];
		$return['permanent_action_due_date'][] 		= $row['permanent_action_due_date'];
		$return['date_created'][] 					= $row['created_at'];
		// $return['username'][] 					= $row['username'];
		// $return['logdel'][] 						= $row['logdel'];
	}
	return $return;
}
// echo get_special_acceptance($sar_summary_date);
// return;

$get_special_acceptance = get_special_acceptance($sar_summary_date);

$excel_class = '../../class/excel_new.php';
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

$width_allowance = 25;
$height_allowance = 38;
$height_allowance_for_date = 20;

/* set width */
$excel->set_width('A',$width_allowance);
$excel->set_width('B',$width_allowance);
$excel->set_width('C',$width_allowance);
$excel->set_width('D',$width_allowance);
$excel->set_width('E',$width_allowance+5);
$excel->set_width('F',$width_allowance);
$excel->set_width('G',$width_allowance);
$excel->set_width('H',$width_allowance);
$excel->set_width('I',$width_allowance);
$excel->set_width('J',$width_allowance);
$excel->set_width('K',$width_allowance);
$excel->set_width('L',$width_allowance);
$excel->set_width('M',$width_allowance);
$excel->set_width('N',$width_allowance);
$excel->set_width('O',$width_allowance);


$excel->merge_cells('A1:N1');
$excel->merge_cells('A8:A9');
$excel->merge_cells('B8:B9');
$excel->merge_cells('C8:C9');
// $excel->merge_cells('D8:D9');
$excel->merge_cells('E8:E9');
$excel->merge_cells('F8:F9');
$excel->merge_cells('G8:G9');
$excel->merge_cells('H8:H9');
$excel->merge_cells('I8:I9');
$excel->merge_cells('J8:J9');
$excel->merge_cells('K8:K9');
$excel->merge_cells('L8:L9');
$excel->merge_cells('M8:M9');
$excel->merge_cells('N8:N9');
$excel->merge_cells('O8:O9');

$excel->set_borders('A8:O9',1,1,1,1);

$array_header = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 11,
	"h_alignment"	=> "center"
);
$array_format_subheader = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 11,
	'fill_color'  => "FFEB9C",
	"h_alignment"	=> "center"
);
$array_format_date = array(
	"bold"		=> true,
	// "italic"	=> true,
	"size"		=> 11,
	'fill_color'  => "FFB6C1",
);

$cell_range = 'A1:O1'; $excel->set_format($cell_range,$array_header);
$cell_range = 'A8:O9'; $excel->set_format($cell_range,$array_format_subheader);
$excel->wrap_text('C');
$excel->wrap_text('C8');
$excel->wrap_text('H8');
$excel->wrap_text('J8');
              
$excel->place_value('A1','FY **** SPECIAL ACCEPTANCE SUMMARY LIST_** Section','string');
$excel->place_value('A8','Control Number','string');
$excel->place_value('B8','Date Issued','string');
$excel->place_value('C8','Part Name / Series Name / Machine Name','string');
$excel->place_value('D8','Location','string');
$excel->place_value('D9','(Cabuyao or Malvar)','string');
$excel->place_value('E8','Problem / Mode of defects','string');
$excel->place_value('F8','Issued By (Name)','string');
$excel->place_value('G8','Issued By (Section)','string');
$excel->place_value('H8','Customer Approval (YEC or End user)','string');
$excel->place_value('I8','Disposition','string');
$excel->place_value('J8','Specify the details of "OTHERS" disposition','string');
$excel->place_value('K8','Immediate Action','string');
$excel->place_value('L8','Due date / ICP','string');
$excel->place_value('M8','Permanent Action ','string');
$excel->place_value('N8','Due date / ICP','string');
$excel->place_value('O8','Status','string');

$custom_data_row = 10;

for ($i=0; $i < count($get_special_acceptance['pkid']); $i++) { 
	$excel->set_height($custom_data_row,$height_allowance);
	
	if($get_special_acceptance['date_created'][$i] != $get_special_acceptance['date_created'][$i-1]){
		$new_data_row = $custom_data_row + 1;

		$excel->set_height($custom_data_row,$height_allowance_for_date);
		$cell_range = 'A'.$custom_data_row.':'.'O'.$custom_data_row; $excel->set_format($cell_range,$array_format_date);
		$excel->place_value('A'.$custom_data_row,$get_special_acceptance['date_created'][$i]."-23",'string');

		$custom_data_row+=1;
	}
	$excel->place_value('A'.$new_data_row,$get_special_acceptance['control_number'][$i],'string');
	$excel->place_value('B'.$new_data_row,$get_special_acceptance['date_issued'][$i],'string');
	$excel->place_value('C'.$new_data_row,( $get_special_acceptance['device_name'][$i] != "" ? $get_special_acceptance['device_name'][$i] : $get_special_acceptance['parts_affected_parts'][$i]),'string');
	$excel->place_value('D'.$new_data_row,$get_special_acceptance['factory_location'][$i],'string');
	$excel->place_value('E'.$new_data_row,$get_special_acceptance['problem'][$i],'string');
	$excel->place_value('F'.$new_data_row,$get_special_acceptance['created_by'][$i],'string');
	$excel->place_value('G'.$new_data_row,$get_special_acceptance['section'][$i],'string');
	$excel->place_value('H'.$new_data_row,'SUPPLIER','string');
	$excel->place_value('I'.$new_data_row,'DISPOSITION','string');
	$excel->place_value('J'.$new_data_row,( $get_special_acceptance['$other_details'][$i] != "" ) ? $get_special_acceptance['other_details'] : "N/A" ,'string' );
	$excel->place_value('K'.$new_data_row,( $get_special_acceptance['immediate_action'][$i] != "" ) ? $get_special_acceptance['immediate_action'] : "N/A" ,'string');
	$excel->place_value('L'.$new_data_row,( $get_special_acceptance['immediate_action_due_date'][$i]  != "" ) ? $get_special_acceptance['immediate_action_due_date'] : "N/A",'string');
	$excel->place_value('M'.$new_data_row,( $get_special_acceptance['permanent_action'][$i] != "") ? $get_special_acceptance['permanent_action'] : "N/A" ,'string');
	$excel->place_value('N'.$new_data_row,( $get_special_acceptance['permanent_action_due_date'][$i]  != "" ) ? $get_special_acceptance['permanent_action_due_date'] : "N/A",'string');
	
	$custom_data_row++;
	$new_data_row++;

}

$col = 'A'; $row = '1';
$excel->set_height('2',15.00);
$pmi_logo	= '../../images/pmi-logo2.png';
$excel->add_image($col.$row,$pmi_logo,'26px');

$col = 'A'; $row = '3';
$excel->set_height('2',15.00);
$pmi_logo	= '../../images/sar_format.png';
$excel->add_image($col.$row,$pmi_logo,'85px');


/* output excel - filename, excel version (2003,2007) */
$filename = "Special Acceptance.xls";
$excel->output($filename,'2003');
exit;
?>
