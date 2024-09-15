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
	 
	$user_qfr_ng_access 	    = array("create" => false, 
										"read" => false,
										"update" => false,
										"delete" => false
										);
	$subsystem_code 			= "ng";
	$module 					= "Dimension Inspection Result";
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
			if ($user_role['create'][$key] == 1){
				$user_qfr_ng_access['create'] = true;
			}
			if ($user_role['read'][$key] == 1){
				$user_qfr_ng_access['read'] = true;
			}
			if ($user_role['update'][$key] == 1){
				$user_qfr_ng_access['update'] = true;
			}
			if ($user_role['delete'][$key] == 1){
				$user_qfr_ng_access['delete'] = true;
			}
		}
	}
	 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$aColumns = array( 
				'pkid',
				'status',
                'part_code',
                'parts_affected_parts',
                'po_number',
				'ng_report_no',
				'file_name',
				'fkfile_path',
				'supplier',
				'created_by',
				'fail_mode',
				'(SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0)',
				'issuance_date'
	);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_ng";
	
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
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			// if( in_array($aColumns[$i],$array_search) ){
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			// }
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* 
		dito ka mag add ng where mo, una check mo kung may laman na yung $sWhere pag wala append mo yung where mo na meron
		kasama where kapag naman may laman na AND na syempre diba :)
	*/

	$un 	 = $_GET['un'];
	$status	 = isset($_GET['st']) ? $_GET['st'] : '';
	
	
	
	if($status != '') {
		if($sWhere == ""){
			$sWhere .= "WHERE  ";
		}else{
			$sWhere .= "AND ";
		}
        
		if($status == 'WITHOUT FINAL REPLY') {
            $status = "(status LIKE '%WITH TREATMENT (%') AND ";
        } else {
            $status = "status = '".$status."' AND ";
        }
		$sWhere .= $status. " logdel=0 AND (created_by = '$un' OR (SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0) LIKE '%$un%')";
	} else {
		if($sWhere == ""){
			$sWhere .= "WHERE logdel=0 AND (created_by = '$un' OR (SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0) LIKE '%$un%')";
		}else{
			$sWhere .= " AND logdel=0 AND (created_by = '$un' OR (SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0) LIKE '%$un%') ";
		}
	}
	
	$username 	= isset($_GET['username']) ? $_GET['username'] : '';
	$sql_where 	= isset($_GET['wh']) ? $_GET['wh'] : '';	
	if($sql_where != ""){
		$sWhere 	= $sql_where." AND (created_by = '$un' OR (SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0) LIKE '%$un%')";
	}
	$sWhere = substr( $sWhere, -4) == 'AND ' ? substr(trim($sWhere), 0, -3) : $sWhere;
	$sOrder = 'ORDER BY pkid DESC';
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
	
	$query_used = $sQuery;
	
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

	require_once('../../handler/common_handler.php');
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{	
		$buttons = '';
		$row = array();
		unset($row);
		$part_details = '';
		if($aRow['status'] == 'FOR APPROVAL') {
			$badge = '<span class="badge highlight-color-yellow" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'APPROVED') {
			$badge = '<span class="badge highlight-color-green" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'DISAPPROVED') {
			$badge = '<span class="badge highlight-color-red" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'WAITING DISPOSITION') {
			$badge = '<span class="badge highlight-color-lime" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'WITH TREATMENT (OK TO USE)' || $aRow['status'] == 'WITH TREATMENT (USE AS IS)' || $aRow['status'] == 'WITH FINAL REPLY') {
			$badge = '<span class="badge highlight-color-blue" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'WITH TREATMENT') {
			$badge = '<span class="badge highlight-color-purple" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'CANCELLED') {
			$badge = '<span class="badge highlight-color-red" >'.$aRow['status'].'</span>';
		} else {
			$badge = $aRow['status'];
		}
		
		
		$initial_dispo   = return_ng_initial_disposition($aRow['pkid']);
		$final_dispo     = return_ng_final_disposition($aRow['pkid']);
		$lot_numbers     = return_ng_lot_numbers($aRow['pkid']);
		$btn_ng_report 	 = '<center><button type="button" class="btn btn-link fa fa-paperclip" id="btn_dl_ng_report" value="'.$aRow['pkid'].'"> Download File</button> </center> <br>';
		$btn_ng_report  .= 'NG Number:  '.$aRow['ng_report_no'].'<br>';
		$approvers       = return_ng_approvers($aRow['pkid']);
		
		
		
		$part_name	    = $aRow['part_code'] == 'N/A' ? $aRow['parts_affected_parts'] : return_partname_by_partcode($aRow['part_code']) ;
		$part_details  	= 'Part Code: '.$aRow['part_code'].'<br>';
		$part_details  .= 'Part Name: '.$part_name.'<br>';
		$series_name	= get_series_name_by_po_number($aRow['po_number']);
		$part_details  .= 'PO Number: '.$aRow['po_number'].'<br>';
		$part_details  .= 'Device Name: '.$series_name.'<br>';
		$part_details  .= 'Lot No.: '.$lot_numbers.'<br>';
		// $part_details  .= 'NG Number: '.$aRow['ng_report_no'].'<br>';

		
		$created_by 	= $aRow['created_by'];
		$access_approver= $aRow['(SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0)'];
		
		if($created_by == $un) {
			if($aRow['status'] == 'APPROVED' || $aRow['status'] == 'WAITING DISPOSITION') {
				$buttons = '<button type="button" class="btn btn-default fa fa-eye" id="btn_edit" value="'.$aRow['pkid'].'"> View</button>';
			} else {
				if($aRow['status'] != 'CANCELLED') {
					$buttons = '<button type="button" class="btn btn-primary fa fa-edit" id="btn_edit" value="'.$aRow['pkid'].'"> Edit</button>';
				} 
				$buttons .= '<br><button type="button" class="btn btn-default fa fa-eye" id="btn_edit" value="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
			}
		} else if(strstr($access_approver, $un)) {
			$buttons = '<button type="button" class="btn btn-default fa fa-eye" id="btn_view" value="'.$aRow['pkid'].'"> View</button>';
		} else if(strstr($access_approver, $un) && $created_by == $un) {
			if($aRow['status'] != 'CANCELLED') {
				$buttons = '<button type="button" class="btn btn-primary fa fa-edit" id="btn_edit" value="'.$aRow['pkid'].'"> Edit</button>';
			}                
			$buttons .= '<br><button type="button" class="btn btn-default fa fa-eye" id="btn_view" value="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
		}
		
		if($aRow['status'] != 'CANCELLED') {
			$buttons .= '<br><button type="button" class="btn btn-danger fa fa-remove" id="btn_cancel" value="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button>';
		}
		
		
		$row[] = $badge;
		$row[] = $part_details;
		$row[] = $initial_dispo;
		$row[] = $final_dispo;
		$row[] = $btn_ng_report;
		$row[] = '<center>'.$aRow['supplier'].'</center>';
		$row[] = $approvers;
		$row[] = $buttons;
		array_push($output['aaData'],$row);
	}
	ob_end_clean();
	echo json_encode( $output );
	
	function return_partname_by_partcode($part_code) {
		require_once('../../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$array_fields 	= array("NAME");
		$table 			= "VHEAD";
		$joins 			= "";
		$sql_where 		= "WHERE CODE='$part_code'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			return $row['NAME'];
		} else {
            return '';
        }
	}
	
	function get_series_name_by_po_number($po_number) {
		require_once('../../class/oop_tqts.php');
        $YPICS         	= new YPICS4;
		$array_fields 	= array("VRECE.CODE");
		$table 			= "VRECE";
		$joins 			= "";
		$sql_where 		= "WHERE VRECE.SORDER = '$po_number'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$device_code	= $row['CODE'];
			$array_fields 	= array("VHEAD.NAME");
			$table 			= "VHEAD";
			$joins 			= "";
			$sql_where 		= "WHERE VHEAD.CODE = '".$device_code."'";
			$sql_order 		= "";
			$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
			if($row = mssql_fetch_array($result)){
				return $row['NAME'];
			} else {
				return '';
			}
		} else{
			return '';
		}		
	}
	
	function return_ng_initial_disposition($fkng) {
		require_once('../../class/oop_tqts.php');
		$initial_dispo = '';
		$array_fields = array('disposition', 'disposition_by', 'disposition_date', 'disposition_time');
		$table 	   	= 'tbl_qfr_ng_treatment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkng="'.$fkng.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$initial_dispo	= $row['disposition'] == '' ? 'N/A' : $row['disposition'] . '<br>' . $row['disposition_by'] . '<br>' . date('M d, Y h:i:s a',strtotime($row['disposition_date'] . ' '. $row['disposition_time']));
		} else {
			$initial_dispo	= 'N/A';
		}
		return $initial_dispo;		
	}

	function return_ng_final_disposition($fkng) {
		require_once('../../class/oop_tqts.php');
		$array_fields = array('final_reply_status', 'final_reply_date', 'final_reply_time');
		$table 	   	= 'tbl_qfr_ng_treatment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkng="'.$fkng.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$final_dispo	= $row['final_reply_status'] == 'N/A' ? 'N/A' : date('M d, Y h:i:s a',strtotime($row['final_reply_date'] . ' ' . $row['final_reply_time']));
		} else {
			$final_dispo	= 'N/A';
		}
		return $final_dispo;		
	}
	
	function return_ng_lot_numbers($fkng) {
		require_once('../../class/oop_tqts.php');
		$lot_no		= array();
		$array_fields = array('lot_nos.lot_no');
		$table 	   	= 'tbl_qfr_ng_lot_numbers lot_nos';
		$joins 	   	= 'INNER JOIN tbl_qfr_ng ng ON ng.pkid = lot_nos.fkng';
		$sql_where 	= 'WHERE lot_nos.fkng="'.$fkng.'" AND lot_nos.logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$approvers  = '';
		while($row = mysqli_fetch_array($result)){
			$lot_no[]				.= $row['lot_no'];
		}
		$lot_no = count($lot_no) == 0 ? 'N/A' : implode(', ', $lot_no);
		return $lot_no;	
	}
	
	function return_ng_approvers($fkng) {
		require_once('../../class/oop_tqts.php');
		$array_fields = array('qrs.approver_username', 'qrs.status','qrs.date_time_approved','qrs.approver_remarks');
		$table 	   	= 'tbl_qfr_ng_approvers qrs';
		$joins 	   	= '';
		$sql_where 	= 'WHERE qrs.fkng="'.$fkng.'" AND qrs.logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$approvers  = '';
		while($row = mysqli_fetch_array($result)){
			$status				= $row['status'] == '' ? '-'  : $row['status'];
			$date_time_approved = $row['date_time_approved'] == '' ? '' : '<i> - '.(date('M d, Y h:i:s A',strtotime($row['date_time_approved']))).'</i>';
			$remarks			= $row['approver_remarks'];
			$approvers 			.= get_emp_name_by_username_systemone_rapid($row['approver_username']).' <b> ['.$status.$date_time_approved.']</b> '.$remarks.'<br>';
		}
		return $approvers;		
	}
	
	
	
	
	?>