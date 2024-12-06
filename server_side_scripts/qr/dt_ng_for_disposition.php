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
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$aColumns = array( 
				'pkid',
				'status',
                'invoice_no',
                'part_code',
                'po_number',
				'file_name',
				'fkfile_path',
				'supplier',
				'fail_mode',
				'issuance_date',
				// '(SELECT GROUP_CONCAT(approver_username) FROM tbl_qfr_ng_approvers WHERE tbl_qfr_ng_approvers.fkng=tbl_qfr_ng.pkid AND tbl_qfr_ng_approvers.logdel=0)',
				'ng_report_no'
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

	 $sOrder ="";
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
	if($sOrder == '') {
		$sOrder = 'ORDER BY pkid DESC';
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
	
	/* Individual column filtering */
	// for ( $i=0 ; $i<count($aColumns) ; $i++ )
	// {
	// 	if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
	// 	{
	// 		if ( $sWhere == "" )
	// 		{
	// 			$sWhere = "WHERE ";
	// 		}
	// 		else
	// 		{
	// 			$sWhere .= " AND ";
	// 		}
	// 		$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
	// 	}
	// }
	
	/* 
		dito ka mag add ng where mo, una check mo kung may laman na yung $sWhere pag wala append mo yung where mo na meron
		kasama where kapag naman may laman na AND na syempre diba :)
	*/

	if($sWhere == ""){
		$sWhere .= "WHERE (status='APPROVED' OR status='WAITING DISPOSITION' OR status LIKE '%WITH %' OR status = 'CANCELLED') AND logdel=0";
	}else{
		$sWhere .= "AND (status='APPROVED' OR status='WAITING DISPOSITION' OR status LIKE '%WITH %' OR status = 'CANCELLED') AND logdel=0 ";
	}
	
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

	$buttons = '';
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{		
		$row = array();
		unset($row);
		
		if($aRow['status'] == 'APPROVED') {
			$badge 		= '<span class="badge highlight-color-green" >FOR DISPOSITION</span>';
			$buttons    = '<button type="button" class="btn btn-info fa fa-send-o" id="btn_add_dispo" value="'.$aRow['pkid'].'"> Send Disposition</button>';
		} else if($aRow['status'] == 'WAITING DISPOSITION') {
			$badge 		= '<span class="badge highlight-color-lime" >'.$aRow['status'].'</span>';
			$buttons    = '<button type="button" class="btn btn-success fa fa-plus" id="btn_add_dispo" value="'.$aRow['pkid'].'"> Add Disposition</button>';
		} else if($aRow['status'] == 'WITH TREATMENT (OK TO USE)' || $aRow['status'] == 'WITH TREATMENT (USE AS IS)' || $aRow['status'] == 'WITH FINAL REPLY') {
			$badge 		= '<span class="badge highlight-color-blue" >'.$aRow['status'].'</span>';
			$buttons    = '<br> <button type="button" class="btn btn-primary fa fa-edit" id="btn_edit_dispo" value="'.$aRow['pkid'].'" style="margin-top:5px;"> Edit Disposition</button>';
			$buttons   .= '<button type="button" class="btn btn-default fa fa-eye" id="btn_view_dispo" value="'.$aRow['pkid'].'"> View Disposition</button>';
		} else if($aRow['status'] == 'WITH TREATMENT') {
			$badge 		= '<span class="badge highlight-color-purple" >'.$aRow['status'].'</span>';
			$buttons    = '<button type="button" class="btn btn-success fa fa-plus" id="btn_add_dispo" value="'.$aRow['pkid'].'"> Add Disposition</button>';
			$buttons   .= '<br> <button type="button" class="btn btn-primary fa fa-edit" id="btn_edit_dispo" value="'.$aRow['pkid'].'" style="margin-top:5px;"> Edit Disposition</button>';
		}else if($aRow['status'] == 'CANCELLED') {
			$badge 		= '<span class="badge highlight-color-red" >'.$aRow['status'].'</span>';
		}else {
			$badge 		= $aRow['status'];
		}
		// $buttons    .= '<button type="button" class="btn btn-info fa fa-send-o" id="btn_add_dispo" value="'.$aRow['pkid'].'"> Send Disposition</button>';
		
		$lot_numbers     = return_ng_lot_numbers($aRow['pkid']);
		$approvers       = return_ng_approvers($aRow['pkid']);
		$btn_ng_report 	 = '<center><button type="button" class="btn btn-link fa fa-paperclip" id="btn_dl_ng_report" value="'.$aRow['pkid'].'"> Download File</button> </center> <br>';
		$btn_ng_report  .= 'NG Number:  '.$aRow['ng_report_no'].'<br>';
		
		if($aRow['part_code'] != '') {
			$part_name	    = get_partname_by_partcode($aRow['part_code']);
			if(	$aRow['fail_mode'] != "" && $aRow['fail_mode'] != 'fail_mode'){
				$fail_mode = $aRow['fail_mode'];
			}else{
				$fail_mode = "";
			}
			// $fail_mode	    = $aRow['fail_mode'] != '' $aRow['fail_mode'];
			$part_details  	= 'Fail Mode: '.$fail_mode.'<br>';
			$part_details  	= 'Part Code: '.$aRow['part_code'].'<br>';
			$part_details  .= 'Part Name: '.$part_name.'<br>';
			$part_details  .= 'Lot No.: '.$lot_numbers.'<br>';
		} 
		if($aRow['po_number'] != '') {
			$series_name    = get_series_name_by_po_number($aRow['po_number']);
			$part_details  .= 'Fail Mode: '.$aRow['fail_mode'].'<br>';
			$part_details  .= 'PO Number: '.$aRow['po_number'].'<br>';
			$part_details  .= 'Device Name: '.$series_name.'<br>';
			$part_details  .= 'Lot No.: '.$lot_numbers.'<br>';
		} 
		if($aRow['po_number'] != '' && $aRow['part_code'] != '') {
			$part_name	    = get_partname_by_partcode($aRow['part_code']);
			if(	$aRow['fail_mode'] != "" && $aRow['fail_mode'] != 'fail_mode'){
				$fail_mode = $aRow['fail_mode'];
			}else{
				$fail_mode = "";
			}
			// $fail_mode	    = $aRow['fail_mode'] != '' $aRow['fail_mode'];
			$part_details  	= 'Fail Mode: '.$fail_mode.'<br>';
			$part_details  	= 'Part Code: '.$aRow['part_code'].'<br>';
			$part_details  .= 'Part Name: '.$part_name.'<br>';

			$series_name    = get_series_name_by_po_number($aRow['po_number']);
			$part_details  .= 'Fail Mode: '.$aRow['fail_mode'].'<br>';
			$part_details  .= 'PO Number: '.$aRow['po_number'].'<br>';
			$part_details  .= 'Device Name: '.$series_name.'<br>';
			$part_details  .= 'Lot No.: '.$lot_numbers.'<br>';
		} 
		
		$row[] = $badge;
		$row[] = $part_details;
		$row[] = $btn_ng_report;
		$row[] = '<center>'.$aRow['supplier'].'</center>';
		$row[] = $approvers;
		$row[] = $buttons;
		array_push($output['aaData'],$row);
	}
	echo json_encode( $output );
	
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

	function get_partname_by_partcode($part_code) {
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
	
	function return_ng_approvers($fkng) {
		require_once('../../class/oop_tqts.php');
		$array_fields = array('(SELECT ra.approver_name FROM tbl_report_approvers ra WHERE ra.approver_username=qrs.approver_username LIMIT 0,1 ) as approver', 'qrs.status','qrs.date_time_approved');
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
			$approvers .= $row['approver'].' <b> ['.$status.$date_time_approved.']</b><br>';
		}
		return $approvers;		
	}
	?>