<?php
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

	$aColumns = array( 
				'control_number',
				'parts_affected_parts',
				'judgement_application',
				'notations_remarks',
				'part_code',
				'problem_parts',
                'supplier',
                'lot_number',
                'quantity',
				'device_name',
				'problem_device',
				'parts_affected_device',
				'po_number',
				'po_qty',
				'affected_quantity',
				'customer_name',
				'shipment_date',
				'drawing_number',
				'category',
				'status',
				'created_by',
				'pkid',
				// "(SELECT `vw_role`.`role` FROM `vw_user_roles` `vw_role` WHERE `vw_role`.`user` = '".$_GET['username']."' AND `vw_role`.`module` = 'Special Acceptance' AND `vw_role`.`subsystem_code` = 'QFR' AND `vw_role`.`logdel` = '0') as role",
				);
	

	// $aColumns = array( '*',
	// 			"(SELECT `vw_role`.`role` FROM `vw_user_roles` `vw_role` WHERE `vw_role`.`user` = '".$_GET['username']."' AND `vw_role`.`module` = 'Special Acceptance' AND `vw_role`.`subsystem_code` = 'QFR' AND `vw_role`.`logdel` = '0') as role",
	// );



	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_special_acceptance";
	
	$database_config = '../../db_config/config_tqts.php';
	
	if(!file_exists($database_config)){
		echo "config file does not exist!";
		exit;
	} else {
		require_once($database_config);
	}
	
	/* Database connection information */
	$gaSql['user']       = $username;
	$gaSql['password']   = $password;
	$gaSql['db']         = $db_name;
	$gaSql['server']     = $server;
	
	
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
		
	/*
	 * Ordering
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	if($sOrder == ""){
		$sOrder = " ORDER BY pkid DESC ";
	}
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	 
	 /* wag gagalawin yung sWhere default to para sa searchbox ng datatables check mo sa baba kung pano gagawin mo :) */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		/* $sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			// if( in_array($aColumns[$i],$array_search) ){
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			// }
		}
		// $sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')'; */
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if( strpos($aColumns[$i]," as ") !== false ){
				$modified_search = explode(" ",$aColumns[$i]);
				$modified_search_reduced = array();
				for($x=0;$x< (count($modified_search) -2); $x++){
					$modified_search_reduced[] = $modified_search[$x];
				}
				$sWhere .= implode(" ",$modified_search_reduced)." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}else{
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
			// if( in_array($aColumns[$i],$array_search) ){
			// }
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	/* 
		dito ka mag add ng where mo, una check mo kung may laman na yung $sWhere pag wala append mo yung where mo na meron
		kasama where kapag naman may laman na AND na syempre diba :)
	*/
	
	// if($sWhere == ""){
		// $sWhere .= "WHERE  ";
	// }else{
		// $sWhere .= "AND ";
	// }

	// $sWhere  .= " (created_by = '$username' OR judged_by_approver = '$username') AND logdel='0'";
	$username 	= $_GET['username'];
	$sql_where 	= $_GET['wh'];
	if($sql_where != ""){
		$sWhere 	= $sql_where;
	}
	
	if($sWhere == ""){
		$sWhere .= "WHERE";
	}else{
		$sWhere .= "AND ";
	}
	
	/** $sWhere .= " `status` = 1 OR `status` = 5 OR `status` = 6 OR `status` = 7 AND `logdel` = 0 "; */
	$sWhere .= " (`status`= '6' OR `status` = '7') AND `logdel` = 0";
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	// echo "limit: ".$sLimit." : ".$sQuery."<hr>";
	$query_used = $sQuery;
	// echo $query_used;
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	

	/* NOTE : extention for include the common function (get emp id by emp username) */
	require_once("../../handler/common_function.php");
	/* get user role */
	$username = $_GET['username'];
	$user_role = get_user_roles($username);
	$user_sa_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false,
									"send" => false,
									);
	$subsystem_code 			= "IQC";
	$module 					= "Special Acceptance";
	$user_sa_access['qc_supervisor'] = false;
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
			if ($user_role['create'][$key] == 1){
				$user_sa_access['create'] = true;
			}
			if ($user_role['read'][$key] == 1){
				$user_sa_access['read'] = true;
			}
			if ($user_role['update'][$key] == 1){
				$user_sa_access['update'] = true;
			}
			if ($user_role['delete'][$key] == 1){
				$user_sa_access['delete'] = true;
			}
		}
		if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module && $user_role['role'][$key] =="SUPERVISOR" || $user_role['role'][$key] =="INSPECTOR"){ 
			$user_sa_access['qc_supervisor'] = true;
		}
	}

	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
		/*  STATUS LOG
			A - FOR QC CHECKING
			0 - FOR CHECKING
			1 - FOR DISPOSITION
			2 - DISAPPROVED
			4 - FOR APPROVAL
			5 - CLOSED
			6 - APPROVED BY YEC
			7 - DISAPPROVED BY YEC
			8 - CANCELLED
		 */
		if($aRow['status'] == '1') {
			$badge = '<span class="badge highlight-color-blue">FOR DISPOSITION</span>';
		}else if($aRow['status'] == '5') {
			$badge = '<span class="badge highlight-color-lime">WAITING FOR DISPOSITION</span>';
		}else if($aRow['status'] == '6') {
			$badge = '<span class="badge highlight-color-green">CLOSED</span>';
		}else if($aRow['status'] == '7') {
			$badge = '<span class="badge highlight-color-red">DISAPPROVED BY YEC</span>';
		}
	/*
		else if($aRow['status'] == '5') {
			$badge = '<span class="badge highlight-color-lime" >WAITING FOR DISPOSITION</span>';
		}
		else if($aRow['status'] == '6') {
			$badge = '<span class="badge highlight-color-green" >APPROVED</span>';
		}else if($aRow['status'] == '7') {
			$badge = '<span class="badge highlight-color-red" >DISAPPROVED</span>';
		} 
	 */	
		$row[] = '<center>'.$badge.'</center>';
		$count_revision = return_count_approvers_qc($aRow['pkid']);
		$count_revision = ($count_revision > 0) ? '<b><i><u> Revision No.'.$count_revision.'</u></i></b> <br><br>' : '';
		$row[] = $count_revision.$aRow['control_number'];
		if($aRow['category'] == "Parts"){
			$details ='Part Affected :'.$aRow['parts_affected_parts'].'<br>'.
				 'Part Code :'.$aRow['part_code'].'<br>'.
				 'Problem :'.$aRow['problem_parts'].'<br>'.
				 'Supplier Name :'.$aRow['supplier'].'<br>'.
				 'Fail Mode :'.$aRow['lot_number'].'<br>'.
				 'Drawing # :'.$aRow['drawing_number'].'<br>'.
				 'Quantity :'.$aRow['quantity'];
		}else{
			$details ='Device Name :'.$aRow['device_name'].'<br>'.
				 'Parts Affected :'.$aRow['parts_affected_device'].'<br>'.
				 'PO # :'.$aRow['po_number'].'<br>'.
				 'PO Quantity :'.$aRow['po_qty'].'<br>'.
				 'Fail Mode :'.$aRow['problem_device'].'<br>'.
				 'Affected Quantity :'.$aRow['affected_quantity'].'<br>'.
				 'Supplier Name :'.$aRow['customer_name'];
				 'Shipment Date :'.$aRow['shipment_date'];
		}
		$row[] = $details;
		$originators = return_sa_originators($aRow['pkid']);
		$row[] = $originators;
		$row[] = $aRow['supplier'];
		// $row[] = ;
		$row[] = is_treatment_exist($aRow['pkid'])==1?'<center><a class= "btn-link fa fa-paperclip" href="#" id="a_download_excel" data-id="'.$aRow['pkid'].'"> Download Excel</a></center>':'';
		/*  STATUS LOG
			1 - FOR DISPOSITION
			2 - DISAPPROVED
			5 - WAITING FOR DISPOSITION
			6 - CLOSED
			7 - DISAPPROVED BY YEC
			8 - CANCELLED
		 */
			$button = array();
			/* if request has already been closed */ 
			$button[] = '<center>';
			if($aRow['status'] == '1' && $username == $aRow['created_by']){
				$button[] = '<button class="btn btn-info fa fa-send-o" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> Send Disposition</button>';
			}
			else if($aRow['status'] == '5' && $username == $aRow['created_by']){
				$button[] = '<button class="btn btn-success fa fa-plus" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> Add Disposition</button>';
			}
			else if($aRow['status'] == '6' || $aRow['status'] == '7'){
				if($username == $aRow['created_by']){
					$button[] = '<button class="btn btn-warning fa fa-edit" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> Edit Disposition</button>';
				}
				$button[] = '<button class="btn btn-default fa fa-eye" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> View Disposition</button>';
			}
			$button[] = '</center>';
			$button = implode("<br/>",$button);
		$row[] = $button;
		
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );

/**
 * *LIST OF FUNCTION*
 * !return_sa_originators
 * !return_sa_approvers_qc
 * !return_count_approvers_qc
 * !return_sa_is_decision_qc
 * 
 */

function return_sa_originators($fkid) {
	require_once('../../class/oop_tqts.php');
	require_once('../../handler/common_handler.php');
	// return 'true';
	$array_fields = array('username');
	$table 	   	= 'tbl_qfr_special_acceptance';
	$joins 	   	= '';
	$sql_where 	= 'WHERE pkid="'.$fkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$approvers  = '';
	while($row = mysqli_fetch_array($result)){
		$approvers .= get_emp_name_by_username_systemone_rapid($row['username']);
		
	}
	return $approvers;
}

function return_sa_approvers_qc($fkid) {
	require_once('../../class/oop_tqts.php');
	require_once('../../handler/common_handler.php');
	// return 'true';
	$array_fields = array('approver_username', 'status','date_time_approved','approver_remarks','created_by');
	$table 	   	= 'tbl_qfr_sa_approver_qc';
	$joins 	   	= '';
	$sql_where 	= 'WHERE fkid="'.$fkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$approvers  = '';
	while($row = mysqli_fetch_array($result)){
		
		$status		= $row['status'];
		if($status == 0){
			$status = '-';
		}else if($status == 1){
			$status = 'APPROVED';
		}else if($status == 2){
			$status = 'DISAPPROVED';
		}
		$date_time_approved = $row['date_time_approved'] == '' ? '' : '<i> - '.(date('M d, Y h:i:s A',strtotime($row['date_time_approved']))).'</i>';
		$remarks			= $row['approver_remarks'];
		$approvers 			.= get_emp_name_by_username_systemone_rapid($row['approver_username']).'<b> ['.$status.$date_time_approved.'] </b>'.$remarks.'<br>';
	}
	return $approvers;
}
function return_count_approvers_qc($fkid) {
	require_once('../../class/oop_tqts.php');
	require_once('../../handler/common_handler.php');
	// return 'true';
	$array_fields = array('*');
	$table 	   	= 'tbl_qfr_sa_for_revision';
	$joins 	   	= '';
	$sql_where 	= 'WHERE `fk_special_acceptance`="'.$fkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$row_count ='';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$row_count = mysqli_num_rows($result);

	return $row_count;
}
function return_sa_is_decision_qc($fkid) {
	require_once('../../class/oop_tqts.php');
	require_once('../../handler/common_handler.php');
	// return 'true';
	$array_fields = array('status');
	$table 	   	= 'tbl_qfr_sa_approver_qc';
	$joins 	   	= '';
	$sql_where 	= 'WHERE fkid="'.$fkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$status  = '';
	while($row = mysqli_fetch_array($result)){
		$status				= $row['status'];
	}
	return $status;
}
function is_treatment_exist($fkid){
	$array_fields = array('file_name');
	$table 	   	= 'tbl_qrf_sa_treatment';
	$joins 	   	= '';
	$sql_where 	= 'WHERE `fkid`= "'.$fkid.'" AND logdel=0';
	$sql_order 	= '';
	$sql_limit 	= '';
	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$return = array();
	if($result->num_rows >= 1){
		$has_record = 1;
	}else{
		$has_record =	0;
	}
	return $has_record;

}

?>