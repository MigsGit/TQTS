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
				'pkid',
				'status', 
				'qcfr_no', 
				'subcon_pmi', 
				'`to`', 
				'`from`', 
				'date_issued', 
				'product_name', 
				'model_no', 
				'batch_no_lot_no', 
				'po_no_invoice_no',
				'date_received',
				'disposition',
				'date_answer_required',
				'reported_by',
				'reported_by_date_time',
				'verified_conformed_by_lqc',
				'verified_conformed_by_lqc_logs',
				'verified_conformed_by_eng',
				'verified_conformed_by_eng_logs',
				'verified_conformed_by_prdn',
				'verified_conformed_by_prdn_logs',
				'approved_by_sh',
				'approved_by_sh_logs',
				'approved_by_dh',
				'approved_by_dh_logs',
				'pmi_orginator_fill_in_approved_by',
				'pmi_orginator_fill_in_approved_by_logs',
				'pmi_orginator_fill_in_checked_by',
				'pmi_orginator_fill_in_checked_by_logs',
				'pmi_orginator_fill_in_approved_by',
				'pmi_orginator_fill_in_approved_by_logs',
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_qcfr";
	
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
	
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	$sWhere .= " `attn` LIKE '%".$_GET['username']."%' AND logdel=0";
	
	$sql_where 	= $_GET['wh'];	
	$username   = $_GET['username'];
	if($sql_where != ""){
		$sWhere 	= $sql_where;
	}
	
	if($sOrder == ""){
		$sOrder = 'ORDER BY pkid DESC';
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
	
	// echo "limit: ".$sLimit." : ".$sQuery."<hr>";
	// $query_used = $sQuery;
	// echo $query_used."<br>";
	
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
	$status = '';

	require_once('../../handler/common_handler.php');
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$buttons = '';
		unset($row);
		$row   = array();
		if($aRow['status'] == 'RECIPIENT FILL-IN') {
			$badge 	   = '<span class="badge highlight-color-yellow" > FOR FILL-IN</span>';
			$buttons  .= '<button type="button" class="btn btn-success fa fa-plus" data-id="'.$aRow['pkid'].'"> Add</button><br>';
		} else {
			if($aRow['date_answer_required'] != '') {
				$badge 	   = '<span class="badge highlight-color-green" > DONE</span>';
			} else {
				$badge 	   = '<span class="label label-default" > VIEW ONLY</span>';
			}
		} 
		$buttons .= '<button type="button" class="btn btn-default fa fa-eye" data-id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
		if($aRow['qcfr_no'] != '') {
			$buttons .= '<button type="button" class="btn btn-success fa fa-file-excel-o" data-id="'.$aRow['pkid'].'" style="margin-top:2px;"> Export</button>';
		}
		$type = ( $aRow['subcon_pmi'] == 0 ? 'Supplier/Subcon' : 'PMI Assy' ) .'<br> TO: '.$aRow['to'].'<br>FROM: '.$aRow['from'];
		
		$prod_details  = 'Product Name: ' . $aRow['product_name'].'<br>';
		$prod_details .= 'Model No.: ' . $aRow['model_no'].'<br>';
		$prod_details .= 'Batch No./Lot No.: ' . $aRow['batch_no_lot_no'].'<br>';
		$prod_details .= 'PO No. Inv. No.: ' . $aRow['po_no_invoice_no'];
		
		$reported_by   = get_emp_name_by_username_systemone_rapid($aRow['reported_by']);
		$reported_by  .= '<b>'.($aRow['reported_by_date_time'] == '' ? '' : date('M d, Y', strtotime($aRow['reported_by_date_time']))).'</b>';
		
		$verified_conformed_by_lqc  = display_status($aRow['verified_conformed_by_lqc'], $aRow['verified_conformed_by_lqc_logs']);
		$verified_conformed_by_prdn = display_status($aRow['verified_conformed_by_prdn'], $aRow['verified_conformed_by_prdn_logs']);
		$verified_conformed_by_eng  = display_status($aRow['verified_conformed_by_eng'], $aRow['verified_conformed_by_eng_logs']);
		$approved_by_sh   			= display_status($aRow['approved_by_sh'], $aRow['approved_by_sh_logs']);
		$approved_by_dh   			= display_status($aRow['approved_by_dh'], $aRow['approved_by_dh_logs']);
		$originator_checked_by   	= display_status($aRow['pmi_orginator_fill_in_checked_by'], $aRow['pmi_orginator_fill_in_checked_by_logs']);
		$originator_approved_by		= display_status($aRow['pmi_orginator_fill_in_approved_by'], $aRow['pmi_orginator_fill_in_approved_by_logs']);
		
		$row[] = $badge.'<input type="hidden" id="status" value="'.$aRow['status'].'">';
		$row[] = $aRow['qcfr_no'];
		$row[] = $type;
		$row[] = $aRow['date_issued'] == '' ? '' : date('M d, Y', strtotime($aRow['date_issued']));
		$row[] = $prod_details;
		$row[] = $aRow['disposition'];
		$row[] = $aRow['date_answer_required'] == '' ? '' : date('M d, Y', strtotime($aRow['date_answer_required']));
		$row[] = $reported_by;
		$row[] = $verified_conformed_by_lqc.$verified_conformed_by_prdn.$verified_conformed_by_eng;
		$row[] = $approved_by_sh.$approved_by_dh;
		$row[] = $originator_checked_by.$originator_approved_by;
		$row[] = $buttons;
		
		
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );		
	
	function display_status($user, $logs) {
		$user_logs = '';
		if( $user != '' ) {
			if($logs == '' || $logs == '-' ) {
				$user_logs   = get_emp_name_by_username_systemone_rapid($user);
				$user_logs  .= ' <b>[-]</b><br>';
			} else if($logs == 'PENDING') {
				$user_logs   = get_emp_name_by_username_systemone_rapid($user);
				$user_logs  .= ' <b>[<i>PENDING</i>]</b><br>';
			} else {
				$logs 		= explode(' | ', $logs);
				$status 	= $logs[0] == '' ? '-'  : $logs[0];
				$date 		= $logs[1] == '' ? ''  : date('M d, Y h:i:s A', strtotime($logs[1]));
				$remarks 	= $logs[2] == '' ? ''  : $logs[2];
				$user_logs  = get_emp_name_by_username_systemone_rapid($user);
				$user_logs .= ' <b>['.($logs[0] == '' ? '<i>PENDING</i>' : $status .' - <i>'. $date).'</i>] </b>'.$remarks.'<br>';
			}	
		}
		
		return $user_logs;
	}
?>