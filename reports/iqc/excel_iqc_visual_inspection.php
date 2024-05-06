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
/* Do excel here  */

$excel_class = '../../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}


//================ NOTE:  GET THE Week 1 - 5 DATE ===============
	$result 		= '';
	$array_fields 	= array('*');
	$table 	   		= 'tbl_set_weeks';
	$joins 	   		= '';
	$sql_where 		= "WHERE status = 1 AND log = 1";
	$sql_order 		= '';
	$sql_limit 		= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$sql_data = array();
	while($row = mysqli_fetch_assoc($result)){
		$sql_data = $row;
	}
	// echo json_encode($sql_data);

	$week_1_from_date = $sql_data['w1s'];
	$week_1_to_date = $sql_data['w1e'];
	$week_2_from_date = $sql_data['w2s'];
	$week_2_to_date = $sql_data['w2e'];
	$week_3_from_date = $sql_data['w3s'];
	$week_3_to_date = $sql_data['w3e'];
	$week_4_from_date = $sql_data['w4s'];
	$week_4_to_date = $sql_data['w4e'];
	$week_5_from_date = $sql_data['w5s'];
	$week_5_to_date = $sql_data['w5e'];
	$month = $sql_data['month'];
	$year = $sql_data['year'];

	//=====NOTE: GET THE DATE FROM AND TO (EX. AUG 1 - 4) =====
	$date_w1s= date("M j", strtotime($week_1_from_date));
	$date_w1e= date("j", strtotime($week_1_to_date));
	$date_w2s= date("M j", strtotime($week_2_from_date));
	$date_w2e= date("j", strtotime($week_2_to_date));
	$date_w3s= date("M j", strtotime($week_3_from_date));
	$date_w3e= date("j", strtotime($week_3_to_date));
	$date_w4s= date("M j", strtotime($week_4_from_date));
	$date_w4e= date("j", strtotime($week_4_to_date));
	$date_w5s= date("M j", strtotime($week_5_from_date));
	$date_w5e= date("j", strtotime($week_5_to_date));
	// echo json_encode($date_w1s);

	// $result 		= '';
	// $sql_where_1 	= "WHERE `is_deleted` = 0 AND `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_1_from_date."' AND '".$week_1_to_date."' " ;
	// $sql_where_2 	= "WHERE `is_deleted` = 0 AND `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_1_from_date."' AND '".$week_1_to_date."'";
	// $sql_where_1_w2 	= "WHERE `is_deleted` = 0 AND `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_2_from_date."' AND '".$week_2_to_date."' " ;
	// $sql_where_2_w2	= "WHERE `is_deleted` = 0 AND `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_2_from_date."' AND '".$week_2_to_date."'";
	// $sql_where_1_w3 	= "WHERE `is_deleted` = 0 AND `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_3_from_date."' AND '".$week_3_to_date."' " ;
	// $sql_where_2_w3	= "WHERE `is_deleted` = 0 AND `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_3_from_date."' AND '".$week_3_to_date."'";
	// $sql_where_1_w4 	= "WHERE `is_deleted` = 0 AND `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_4_from_date."' AND '".$week_4_to_date."' " ;
	// $sql_where_2_w4	= "WHERE `is_deleted` = 0 AND `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_4_from_date."' AND '".$week_4_to_date."'";
	// $sql_where_1_w5 	= "WHERE `is_deleted` = 0 AND `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_5_from_date."' AND '".$week_5_to_date."' " ;
	// $sql_where_2_w5	= "WHERE `is_deleted` = 0 AND `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_5_from_date."' AND '".$week_5_to_date."'";
	// $result = SEIKODB::getInstance()->select_query_weekly_report($sql_where_1,$sql_where_2,$sql_where_1_w2,$sql_where_2_w2,
	// 															$sql_where_1_w3,$sql_where_2_w3,$sql_where_1_w4,$sql_where_2_w4,$sql_where_1_w5,$sql_where_2_w5);
	// $weekly_count_total = mysqli_fetch_assoc($result);

/* ========== NOTE: LASTEST COUNT ======== */
	$result 		= '';
	$sql_where_1 	= "WHERE `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_1_from_date."' AND '".$week_1_to_date."' " ;
	$sql_where_2 	= "WHERE `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_1_from_date."' AND '".$week_1_to_date."'";
	$sql_where_1_w2 	= "WHERE `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_2_from_date."' AND '".$week_2_to_date."' " ;
	$sql_where_2_w2	= "WHERE `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_2_from_date."' AND '".$week_2_to_date."'";
	$sql_where_1_w3 	= "WHERE `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_3_from_date."' AND '".$week_3_to_date."' " ;
	$sql_where_2_w3	= "WHERE `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_3_from_date."' AND '".$week_3_to_date."'";
	$sql_where_1_w4 	= "WHERE `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_4_from_date."' AND '".$week_4_to_date."' " ;
	$sql_where_2_w4	= "WHERE `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_4_from_date."' AND '".$week_4_to_date."'";
	$sql_where_1_w5 	= "WHERE `judgement` in ('accepted','rejected') AND `date_ispected` BETWEEN '".$week_5_from_date."' AND '".$week_5_to_date."' " ;
	$sql_where_2_w5	= "WHERE `judgement`='accepted' AND `date_ispected` BETWEEN '".$week_5_from_date."' AND '".$week_5_to_date."'";
	$result = SEIKODB::getInstance()->select_query_weekly_report($sql_where_1,$sql_where_2,$sql_where_1_w2,$sql_where_2_w2,
																$sql_where_1_w3,$sql_where_2_w3,$sql_where_1_w4,$sql_where_2_w4,$sql_where_1_w5,$sql_where_2_w5);
	$weekly_count_total = mysqli_fetch_assoc($result);

	// echo json_encode($approve_count);
	$week_1_inspected=$weekly_count_total['WEEK_1_INSPECTED'];
	$week_1_accepted=$weekly_count_total['WEEK_1_ACCEPTED'];
	$week_1_sample=$weekly_count_total['WEEK_1_SAMPLE'];
	$week_1_defect=$weekly_count_total['WEEK_1_NG_QTY'];

	$week_2_inspected=$weekly_count_total['WEEK_2_INSPECTED'];
	$week_2_accepted=$weekly_count_total['WEEK_2_ACCEPTED'];
	$week_2_sample=$weekly_count_total['WEEK_2_SAMPLE'];
	$week_2_defect=$weekly_count_total['WEEK_2_NG_QTY'];

	$week_3_inspected=$weekly_count_total['WEEK_3_INSPECTED'];
	$week_3_accepted=$weekly_count_total['WEEK_3_ACCEPTED'];
	$week_3_sample=$weekly_count_total['WEEK_3_SAMPLE'];
	$week_3_defect=$weekly_count_total['WEEK_3_NG_QTY'];

	$week_4_inspected=$weekly_count_total['WEEK_4_INSPECTED'];
	$week_4_accepted=$weekly_count_total['WEEK_4_ACCEPTED'];
	$week_4_sample=$weekly_count_total['WEEK_4_SAMPLE'];
	$week_4_defect=$weekly_count_total['WEEK_4_NG_QTY'];

	$week_5_inspected=$weekly_count_total['WEEK_5_INSPECTED'];
	$week_5_accepted=$weekly_count_total['WEEK_5_ACCEPTED'];
	$week_5_sample=$weekly_count_total['WEEK_5_SAMPLE'];
	$week_5_defect=$weekly_count_total['WEEK_5_NG_QTY'];

$excel = new EXCEL;
/* set title */
// $excel->title = $sql_data['invoice_no'].'-'.date('my', strtotime($sql_data['date_ispected'])).'-'.$sql_data['id'];
$excel->title = ('Weekly');
$excel->add_sheet(0);

// $excel->add_sheet(1);

/* use the default font style */
$excel->set_default_font_style();
$excel->set_margin();
$excel->set_print_area();

 /*Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); ) */


/* set format */
$array_format = array(
	"size"	=> 10,
	'fill_color'  => "FFFFFF"
);
$cell_range = 'A1:AZ100'; $excel->set_format($cell_range,$array_format);

$width_allowance = 20;

// /* set width */
$excel->set_width('A',$width_allowance+20);
$excel->set_width('K',$width_allowance+20);	
$excel->set_width('U',$width_allowance+20);	
$excel->set_width('AE',$width_allowance+20);	
$excel->set_width('AO',$width_allowance+20);	


// /* set height */
// $excel->set_height('1',5);
// $excel->set_height('2',25);

// /* Merge Cells */
// $merge_cells = array('C3:Q3', 'C4:Q4', 'E5:J5', 'M5:Q5', 'E6:J6', 'M6:Q6', 'F9:H9', 'F10:H10', 'F11:H11', 'F12:H12', 'F13:H13', 'F14:H14', 'F15:H15', 'M9:P9', 'M14:Q14', 'M15:Q15', 'C17:F17', 'H17:L17', 'N17:Q17', 'C18:F18', 'H18:L18', 'N18:Q18', 'C19:F19', 'H19:L19', 'N19:Q19', 'C20:F20', 'H20:L20', 'N20:Q20', 'C22:Q22', 'F23:H23', 'K23:M23', 'N23:O23', 'P23:Q23', 'F24:Q24', 'C26:Q29', 'C31:Q34', 'C35:Q35', 'C38:Q41', 'C43:Q46', 'N48:Q48', 'N49:Q49', 'N50:Q50', 'N51:Q51' );
// for($i=0; $i<count($merge_cells); $i++) {
// 	$excel->merge_cells($merge_cells[$i]);

$array_format_column = array(
	"color" => "orange",
	"size"		=> 14,
	"bold"	=> true,
	"h_alignment"	=> "center"
);
$cell_range = 'A2:AZ2'; $excel->set_format($cell_range,$array_format_column);



//===================================== BORDERS:COLUMN NAME WEEK 1 ==========================================	
$cell = 'A3:I3'; $excel->set_borders($cell,0,0,1,0, "thin");
/* Border inside the Array */
$set_borders = array('A3:A4','B3:B4','C3:C4', 'D3:D4','E3:E4','F3:F4','G3:G4','H3:H4', 'I3:I4' );
for($i=0; $i<9; $i++) {
	$cell = $set_borders[$i] ; $excel->set_borders($cell,1,1,0,0, "thin");
}
//=====================================BORDERS: COLUMN NAME WEEK 2 ==========================================	
$cell = 'K3:S3'; $excel->set_borders($cell,0,0,1,0, "thin");
/* Border inside the Array */
$set_borders = array('K3:K4','L3:L4','M3:M4', 'N3:N4','O3:O4','P3:P4','Q3:Q4','R3:R4', 'S3:S4');
for($i=0; $i<9; $i++) {
	$cell = $set_borders[$i] ; $excel->set_borders($cell,1,1,0,0, "thin");
}
//=====================================BORDERS: COLUMN NAME WEEK 3 ==========================================	
$cell = 'U3:AC3'; $excel->set_borders($cell,0,0,1,0, "thin");
/* Border inside the Array */
$set_borders = array('U3:U4','V3:V4','W3:W4', 'X3:X4','Y3:Y4','Z3:Z4','AA3:AA4','AB3:AB4', 'AC3:AC4');
for($i=0; $i<9; $i++) {
	$cell = $set_borders[$i] ; $excel->set_borders($cell,1,1,0,0, "thin");
}
//=====================================BORDERS: COLUMN NAME WEEK 4 ==========================================	
$cell = 'AE3:AM3'; $excel->set_borders($cell,0,0,1,0, "thin");
/* Border inside the Array */
$set_borders = array('AE3:AE4','AF3:AF3','AG3:AG4', 'AH3:AH4','AI3:AI4','AJ3:AJ4','AK3:AK4','AL3:AL4', 'AM3:AM4');
for($i=0; $i<9; $i++) {
	$cell = $set_borders[$i] ; $excel->set_borders($cell,1,1,0,0, "thin");
}
//=====================================BORDERS: COLUMN NAME WEEK 4 ==========================================	
$cell = 'AO3:AW3'; $excel->set_borders($cell,0,0,1,0, "thin");
/* Border inside the Array */
$set_borders = array('AO3:AO4','AP3:AP3','AQ3:AQ4', 'AR3:AR4','AS3:AS4','AT3:AT4','AU3:AU4','AV3:AV4', 'AW3:AW4');
for($i=0; $i<9; $i++) {
	$cell = $set_borders[$i] ; $excel->set_borders($cell,1,1,0,0, "thin");
}
//====================================ALL BORDERS======================================
$cell = 'A5:I50'; $excel->set_borders($cell,1,1,1,1, "thin");
$cell = 'K5:S50'; $excel->set_borders($cell,1,1,1,1, "thin");
$cell = 'U5:AC50'; $excel->set_borders($cell,1,1,1,1, "thin");
$cell = 'AE5:AM50'; $excel->set_borders($cell,1,1,1,1, "thin");
$cell = 'AO5:AW50'; $excel->set_borders($cell,1,1,1,1, "thin");

/* Place value */
//==============================================================================================
$col = 'A'; $row = '2';   $excel->place_value($col.$row,"WEEK 1 : $date_w1s - $date_w1e",'string');
$col = 'D'; $row = '2';   $excel->place_value($col.$row,"Local & Foreign Supplier",'string');
$col = 'B'; $row = '3';   $excel->place_value($col.$row,'Lot','string');
$col = 'B'; $row = '4';   $excel->place_value($col.$row,'Inspected','string');
$col = 'C'; $row = '3';   $excel->place_value($col.$row,'Lot OK','string');
$col = 'D'; $row = '3';   $excel->place_value($col.$row,'Samples','string');
$col = 'E'; $row = '3';   $excel->place_value($col.$row,'NG Qty','string');
$col = 'F'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'F'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'G'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'G'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'H'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'H'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');
$col = 'I'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'I'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');

//==============================================================================================
$col = 'K'; $row = '2';   $excel->place_value($col.$row,"WEEK 2 : $date_w2s - $date_w2e",'string');
// $col = 'L'; $row = '2';   $excel->place_value($col.$row,"Local & Foreign Supplier",'string');
$col = 'L'; $row = '3';   $excel->place_value($col.$row,'Lot','string');
$col = 'L'; $row = '4';   $excel->place_value($col.$row,'Inspected','string');
$col = 'M'; $row = '3';   $excel->place_value($col.$row,'Lot OK','string');
$col = 'N'; $row = '3';   $excel->place_value($col.$row,'Samples','string');
$col = 'O'; $row = '3';   $excel->place_value($col.$row,'NG Qty','string');
$col = 'P'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'P'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'Q'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'Q'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'R'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'R'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');
$col = 'S'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'S'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');

//==============================================================================================
$col = 'U'; $row = '2';   $excel->place_value($col.$row,"WEEK 3 : $date_w3s - $date_w3e",'string');
$col = 'V'; $row = '3';   $excel->place_value($col.$row,'Lot','string');
$col = 'V'; $row = '4';   $excel->place_value($col.$row,'Inspected','string');
$col = 'W'; $row = '3';   $excel->place_value($col.$row,'Lot OK','string');
$col = 'X'; $row = '3';   $excel->place_value($col.$row,'Samples','string');
$col = 'Y'; $row = '3';   $excel->place_value($col.$row,'NG Qty','string');
$col = 'Z'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'Z'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'AA'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'AA'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'AB'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'AB'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');
$col = 'AC'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'AC'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');

//==============================================================================================
$col = 'AE'; $row = '2';   $excel->place_value($col.$row,"WEEK 4 : $date_w4s - $date_w4e",'string');
$col = 'AF'; $row = '3';   $excel->place_value($col.$row,'Lot','string');
$col = 'AF'; $row = '4';   $excel->place_value($col.$row,'Inspected','string');
$col = 'AG'; $row = '3';   $excel->place_value($col.$row,'Lot OK','string');
$col = 'AH'; $row = '3';   $excel->place_value($col.$row,'Samples','string');
$col = 'AI'; $row = '3';   $excel->place_value($col.$row,'NG Qty','string');
$col = 'AJ'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'AJ'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'AK'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'AK'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'AL'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'AL'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');
$col = 'AM'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'AM'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');

//==============================================================================================
$col = 'AO'; $row = '2';   $excel->place_value($col.$row,"WEEK 5 : $date_w5s - $date_w5e",'string');
$col = 'AP'; $row = '3';   $excel->place_value($col.$row,'Lot','string');
$col = 'AP'; $row = '4';   $excel->place_value($col.$row,'Inspected','string');
$col = 'AQ'; $row = '3';   $excel->place_value($col.$row,'Lot OK','string');
$col = 'AR'; $row = '3';   $excel->place_value($col.$row,'Samples','string');
$col = 'AS'; $row = '3';   $excel->place_value($col.$row,'NG Qty','string');
$col = 'AT'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'AT'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'AU'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'AU'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'AV'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'AV'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');
$col = 'AW'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'AW'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');



/* WEEK 1 SUMMARY PER SUPPLIER */
$return= $_POST;
$result_w1 = '';
$result_w1_accepted = '';
$sql_table = 'iqc_inspections';
$sql_where_group_w1 = "date_ispected BETWEEN '".$week_1_from_date."' AND '".$week_1_to_date."' " ;
$sql_column = 'supplier';
// $sql_group_by = "GROUP BY supplier";

$result_w1 = SEIKODB::getInstance()->sql_select_group($sql_table,$sql_where_group_w1,$sql_column);
$count = array();
		$ctrRow = '5';
while ($row = mysqli_fetch_object($result_w1)){
	$count = $row;

	$supplier = $count->supplier;
	$LOT_INSPECTED = $count->LOT_INSPECTED;
	$LOT_OK = $count->LOT_OK;
	$SAMPLES = $count->SAMPLES;
	$NG_QTY = $count->NG_QTY;
	
	
	$col = 'A'; $row = $ctrRow; $excel->place_value($col.$row,$supplier,'string');
	$col = 'B'; $row = $ctrRow; $excel->place_value($col.$row,$LOT_INSPECTED,'int');
	$col = 'C'; $row = $ctrRow; $excel->place_value($col.$row,$LOT_OK,'int');
	$col = 'D'; $row = $ctrRow; $excel->place_value($col.$row,$SAMPLES,'int');
	$col = 'E'; $row = $ctrRow; $excel->place_value($col.$row,$NG_QTY,'int');

	$ctrRow++;
}

/* WEEK 2 SUMMARY PER SUPPLIER */
$result_w2 = '';
$sql_table = 'iqc_inspections';
$sql_where_group_w2 = "date_ispected BETWEEN '".$week_2_from_date."' AND '".$week_2_to_date."' " ;
$sql_column = 'supplier';
// $sql_group_by = "GROUP BY supplier";
$result_w2 = SEIKODB::getInstance()->sql_select_group_w2($sql_table,$sql_where_group_w2,$sql_column);
$count_w2 = array();
$ctrRow_w2 = '5';
while ($row = mysqli_fetch_object($result_w2)){
	$count_w2 = $row;

	$supplier_W2 = $count_w2->supplier;
	$LOT_INSPECTED_W2 = $count_w2->LOT_INSPECTED_W2;
	$LOT_OK_W2 = $count_w2->LOT_OK_W2;
	$SAMPLES_W2 = $count_w2->SAMPLES_W2;
	$NG_QTY_W2 = $count_w2->NG_QTY_W2;
	
	$col = 'K'; $row = $ctrRow_w2; $excel->place_value($col.$row,$supplier_W2,'string');
	$col = 'L'; $row = $ctrRow_w2; $excel->place_value($col.$row,$LOT_INSPECTED_W2,'int');
	$col = 'M'; $row = $ctrRow_w2; $excel->place_value($col.$row,$LOT_OK_W2,'int');
	$col = 'N'; $row = $ctrRow_w2; $excel->place_value($col.$row,$SAMPLES_W2,'int');
	$col = 'O'; $row = $ctrRow_w2; $excel->place_value($col.$row,$NG_QTY_W2,'int');

	$ctrRow_w2++;
}
/* WEEK 3 SUMMARY PER SUPPLIER */
$result_W3 = '';
$sql_table = 'iqc_inspections';
$sql_where_group_W3 = "date_ispected BETWEEN '".$week_3_from_date."' AND '".$week_3_to_date."' " ;
$sql_column = 'supplier';
$result_W3 = SEIKODB::getInstance()->sql_select_group_w3($sql_table,$sql_where_group_W3,$sql_column);
$count_w3 = array();
$ctrRow_w3 = '5';
while ($row = mysqli_fetch_object($result_W3)){
	$count_w3 = $row;

	$supplier_W3 = $count_w3->supplier;
	$LOT_INSPECTED_W3 = $count_w3->LOT_INSPECTED_W3;
	$LOT_OK_W3 = $count_w3->LOT_OK_W3;
	$SAMPLES_W3 = $count_w3->SAMPLES_W3;
	$NG_QTY_W3 = $count_w3->NG_QTY_W3;
	
	$col = 'U'; $row = $ctrRow_w3; $excel->place_value($col.$row,$supplier_W3,'string');
	$col = 'V'; $row = $ctrRow_w3; $excel->place_value($col.$row,$LOT_INSPECTED_W3,'int');
	$col = 'W'; $row = $ctrRow_w3; $excel->place_value($col.$row,$LOT_OK_W3,'int');
	$col = 'X'; $row = $ctrRow_w3; $excel->place_value($col.$row,$SAMPLES_W3,'int');
	$col = 'Y'; $row = $ctrRow_w3; $excel->place_value($col.$row,$NG_QTY_W3,'int');

	$ctrRow_w3++;
}

 /* WEEK 4 SUMMARY PER SUPPLIER */
$result_W4 = '';
$sql_table = 'iqc_inspections';
$sql_where_group_W4 = "date_ispected BETWEEN '".$week_4_from_date."' AND '".$week_4_to_date."' " ;
$sql_column = 'supplier';
$result_W4 = SEIKODB::getInstance()->sql_select_group_w4($sql_table,$sql_where_group_W4,$sql_column);
$count_w4 = array();
$ctrRow_w4 = '5';
while ($row = mysqli_fetch_object($result_W4)){
	$count_w4 = $row;

	$supplier_W4 = $count_w4->supplier;
	$LOT_INSPECTED_W4 = $count_w4->LOT_INSPECTED_W4;
	$LOT_OK_W4 = $count_w4->LOT_OK_W4;
	$SAMPLES_W4 = $count_w4->SAMPLES_W4;
	$NG_QTY_W4 = $count_w4->NG_QTY_W4;
	
	$col = 'AE'; $row = $ctrRow_w4; $excel->place_value($col.$row,$supplier_W4,'string');
	$col = 'AF'; $row = $ctrRow_w4; $excel->place_value($col.$row,$LOT_INSPECTED_W4,'int');
	$col = 'AG'; $row = $ctrRow_w4; $excel->place_value($col.$row,$LOT_OK_W4,'int');
	$col = 'AH'; $row = $ctrRow_w4; $excel->place_value($col.$row,$SAMPLES_W4,'int');
	$col = 'AI'; $row = $ctrRow_w4; $excel->place_value($col.$row,$NG_QTY_W4,'int');

	$ctrRow_w4++;
}

 /* WEEK 5 SUMMARY PER SUPPLIER */
$result_W5 = '';
$sql_table = 'iqc_inspections';
$sql_where_group_W5 = "date_ispected BETWEEN '".$week_5_from_date."' AND '".$week_5_to_date."' " ;
$sql_column = 'supplier';
$result_W5 = SEIKODB::getInstance()->sql_select_group_w5($sql_table,$sql_where_group_W5,$sql_column);
// $result_W5 = SEIKODB::getInstance()->sql_select_group_w5();
$count_w5 = array();
$ctrRow_w5 = '5';
while ($row = mysqli_fetch_object($result_W5)){
	$count_w5 = $row;

	$supplier_W5 = $count_w5->supplier;
	$LOT_INSPECTED_W5 = $count_w5->LOT_INSPECTED_W5;
	$LOT_OK_W5 = $count_w5->LOT_OK_W5;
	$SAMPLES_W5 = $count_w5->SAMPLES_W5;
	$NG_QTY_W5 = $count_w5->NG_QTY_W5;
	
	$col = 'AO'; $row = $ctrRow_w5; $excel->place_value($col.$row,$supplier_W5,'string');
	$col = 'AP'; $row = $ctrRow_w5; $excel->place_value($col.$row,$LOT_INSPECTED_W5,'int');
	$col = 'AQ'; $row = $ctrRow_w5; $excel->place_value($col.$row,$LOT_OK_W5,'int');
	$col = 'AR'; $row = $ctrRow_w5; $excel->place_value($col.$row,$SAMPLES_W5,'int');
	$col = 'AS'; $row = $ctrRow_w5; $excel->place_value($col.$row,$NG_QTY_W5,'int');

	$ctrRow_w5++;
}


// $array_format_subheader = array(
// 	"bold"		=> true,
// 	"italic"	=> true,
// 	"size"		=> 11,
// 	"h_alignment"	=> "center"
// );

// $cell_range = 'C4:Q4'; $excel->set_format($cell_range,$array_format_subheader);
// $array_format_labels = array(
// 	"bold"		=> true,
// 	"size"	=> 8,
// 	"h_alignment"	=> "center"
// );


// $width_allowance = .75;

// /* set width */
// $excel->set_width('A',$width_allowance+10);

// /* set height */
// $excel->set_height('1',5);


// /* Merge Cells */

// $merge_cells = array('C3:Q3', 'C4:Q4', 'E5:J5', 'M5:Q5', 'E6:J6', 'M6:Q6', 'F9:H9', 'F10:H10', 'F11:H11', 'F12:H12', 'F13:H13', 'F14:H14', 'F15:H15', 'M9:P9', 'M14:Q14', 'M15:Q15', 'C17:F17', 'H17:L17', 'N17:Q17', 'C18:F18', 'H18:L18', 'N18:Q18', 'C19:F19', 'H19:L19', 'N19:Q19', 'C20:F20', 'H20:L20', 'N20:Q20', 'C22:Q22', 'F23:H23', 'K23:M23', 'N23:O23', 'P23:Q23', 'F24:Q24', 'C26:Q29', 'C31:Q34', 'C35:Q35', 'C38:Q41', 'C43:Q46', 'N48:Q48', 'N49:Q49', 'N50:Q50', 'N51:Q51' );
// for($i=0; $i<count($merge_cells); $i++) {
// 	$excel->merge_cells($merge_cells[$i]);
// }

$excel->title = ('Montly');
$excel->add_sheet(1);
/* 
 	Set borders ( $excel->set_borders($cell,$left,$right,$top,$bottom,$border_style); )
*/

/* set format */
$array_format = array(
	// "bold"	=> true,
	"size"	=> 10,
	'fill_color'  => "FFFFFF"
);
$cell_range = 'A1:AR100'; $excel->set_format($cell_range,$array_format);



$array_format_column = array(
	"color" => "orange",
	"size"		=> 14,
	"bold"	=> true,
	"h_alignment"	=> "center"
);
$cell_range = 'A2:I2'; $excel->set_format($cell_range,$array_format_column);


//=====================================COLUMN NAME ==========================================	
$cell = 'A3:I10'; $excel->set_borders($cell,0,1,1,0, "thin");
$cell = 'A3:I3'; $excel->set_borders($cell,0,0,1,0, "thin");	
$cell = 'B3:B3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'B4:B4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'C3:C3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'C4:C4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'D3:D3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'D4:D4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'E3:E3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'E4:E4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'F3:F3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'F4:F4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'G3:G3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'G4:G4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'H3:H3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'H4:H4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'I3:I3'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'I4:I4'; $excel->set_borders($cell,1,1,0,0, "thin");
$cell = 'A4:I4'; $excel->set_borders($cell,0,0,0,1, "thin");


//====================================ALL BORDERS======================================
$cell = 'A5:I10'; $excel->set_borders($cell,1,1,1,1, "thin");




// $col = 'B'; $row = '2';
// $excel->set_height('2',15.00);
// $pmi_logo	= '../../images/pmi-logo2.png';
// $title = 'TS IQC LAR Summary / Trend – Foreign Supplier';
// $excel->add_image($col.$row,$pmi_logo,'26px');

// /* Place value */

$col = 'E'; $row = '2';   $excel->place_value($col.$row," TS IQC LAR Summary / Trend – Foreign Supplier ($month $year)",'string');

$col = 'B'; $row = '3';   $excel->place_value($col.$row,'Lot','string');
$col = 'B'; $row = '4';   $excel->place_value($col.$row,'Inspected','string');

$col = 'C'; $row = '3';   $excel->place_value($col.$row,'Lot OK','string');
$col = 'D'; $row = '3';   $excel->place_value($col.$row,'Samples','string');
$col = 'E'; $row = '3';   $excel->place_value($col.$row,'NG Qty','string');
$col = 'F'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'F'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'G'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'G'; $row = '4';   $excel->place_value($col.$row,'LAR','string');
$col = 'H'; $row = '3';   $excel->place_value($col.$row,'Target','string');
$col = 'H'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');
$col = 'I'; $row = '3';   $excel->place_value($col.$row,'Actual','string');
$col = 'I'; $row = '4';   $excel->place_value($col.$row,'Dppm','string');

/*NOTE: REPORT FOR TOTAL NUMBER EACH WEEK*/
$col = 'A'; $row = '5';   $excel->place_value($col.$row,"$date_w1s - $date_w1e",'string');
$col = 'B'; $row = '5';   $excel->place_value($col.$row,$week_1_inspected);
$col = 'C'; $row = '5';   $excel->place_value($col.$row,$week_1_accepted);
$col = 'D'; $row = '5';   $excel->place_value($col.$row,$week_1_sample);
$col = 'E'; $row = '5';   $excel->place_value($col.$row,$week_1_defect);

$col = 'A'; $row = '6';   $excel->place_value($col.$row,"$date_w2s - $date_w2e",'string');
$col = 'B'; $row = '6';   $excel->place_value($col.$row,$week_2_inspected);
$col = 'C'; $row = '6';   $excel->place_value($col.$row,$week_2_accepted);
$col = 'D'; $row = '6';   $excel->place_value($col.$row,$week_2_sample);
$col = 'E'; $row = '6';   $excel->place_value($col.$row,$week_2_defect);

$col = 'A'; $row = '7';   $excel->place_value($col.$row,"$date_w3s - $date_w3e",'string');
$col = 'B'; $row = '7';   $excel->place_value($col.$row,$week_3_inspected);
$col = 'C'; $row = '7';   $excel->place_value($col.$row,$week_3_accepted);
$col = 'D'; $row = '7';   $excel->place_value($col.$row,$week_3_sample);
$col = 'E'; $row = '7';   $excel->place_value($col.$row,$week_3_defect);

$col = 'A'; $row = '8';   $excel->place_value($col.$row,"$date_w4s - $date_w4e",'string');
$col = 'B'; $row = '8';   $excel->place_value($col.$row,$week_4_inspected);
$col = 'C'; $row = '8';   $excel->place_value($col.$row,$week_4_accepted);
$col = 'D'; $row = '8';   $excel->place_value($col.$row,$week_4_sample);
$col = 'E'; $row = '8';   $excel->place_value($col.$row,$week_4_defect);

$col = 'A'; $row = '9';   $excel->place_value($col.$row,"$date_w5s - $date_w5e",'string');
$col = 'B'; $row = '9';   $excel->place_value($col.$row,$week_5_inspected);
$col = 'C'; $row = '9';   $excel->place_value($col.$row,$week_5_accepted);
$col = 'D'; $row = '9';   $excel->place_value($col.$row,$week_5_sample);
$col = 'E'; $row = '9';   $excel->place_value($col.$row,$week_5_defect);

$filename = 'TS-Quality Performance Summary';
/* output excel - filename, excel version (2003,2007) */
// $excel->output($filename,'2007');
$excel->output($filename,'2003');

?>