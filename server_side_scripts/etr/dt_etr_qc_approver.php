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
//	 error_reporting(E_ALL);
//	 ini_set('display_errors', 1);

	$aColumns = array( 
				'pkid', 
				'status', 
				'IF(status = "FOR QC APPROVAL", 0, 1) AS status_id', 
				'training_title', 
				'training_objective', 
				'line', 
				'control_no', 
				'series_name', 
				'reason_for_certification', 
				'prdn_first_take_trained_by', 
				'prdn_first_take_date_time', 
				'eng_first_take_qualified_by', 
				'eng_first_take_date_time', 
				'eng_second_take_qualified_by', 
				'eng_second_take_date_time', 
				'qc_first_take_certified_by', 
				'qc_first_take_date_time', 
				'qc_second_take_certified_by', 
				'qc_second_take_date_time',
				'prdn_checked_by',
				'prdn_checked_by_logs',
				'engr_checked_by',
				'engr_checked_by_logs',
				'qc_checked_by',
				'qc_checked_by_logs',
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_etr_training";
	
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
			if(!strstr($aColumns[$i]," AS ")) { //added condition due to exclusion of status_id on search
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
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
	$username   = $_GET['username'];
	if($sWhere == ""){
		$sWhere .= "WHERE ";
	}else{
		$sWhere .= "AND ";
	}
	$sWhere .= " (status = 'FOR QC APPROVAL' OR status LIKE '%POST%') AND logdel=0";
	
	$sql_where 	= $_GET['wh'];	
	
	if($sql_where != ""){
		$sWhere 	= $sql_where;
	}
	
	if($sOrder == ""){
		$sOrder = 'ORDER BY status_id ASC, pkid DESC';
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
	
	require_once('../../handler/common_handler.php');
	require_once('../../handler/common_function.php');
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row 		= array();
		$buttons 	= '';
		unset($row);
        
		$training_date		= 'PRDN:'.($aRow['prdn_first_take_date_time'] == '' ? '-' : date('M d, Y', strtotime($aRow['prdn_first_take_date_time'])));
		$training_date	   .= '<br>ENGR:'.($aRow['eng_first_take_date_time'] == '' ? '-' : date('M d, Y', strtotime($aRow['eng_first_take_date_time'])));
		$training_date	   .= '<br>QC:'.($aRow['qc_first_take_date_time'] == '' ? '-' : date('M d, Y', strtotime($aRow['qc_first_take_date_time'])));
		
		$prdn_checked_by_logs 	= ($aRow['prdn_checked_by_logs'] == '' ? array('','','') : explode('|',$aRow['prdn_checked_by_logs']));
		$engr_checked_by_logs 	= ($aRow['engr_checked_by_logs'] == '' ? array('','','') : explode('|',$aRow['engr_checked_by_logs']));
		$qc_checked_by_logs 	= ($aRow['qc_checked_by_logs'] == '' ? array('','','') : explode('|',$aRow['qc_checked_by_logs']));
		$signatories_log 	    = 'PRDN:'.display_approvers_log($prdn_checked_by_logs[0], $prdn_checked_by_logs[1], $aRow['prdn_checked_by'], (isset($prdn_checked_by_logs[2]) ? $prdn_checked_by_logs[2] : ''));
		$signatories_log	   .= '<br>ENGR:'.display_approvers_log($engr_checked_by_logs[0], $engr_checked_by_logs[1], $aRow['engr_checked_by'], (isset($engr_checked_by_logs[2]) ? $engr_checked_by_logs[2] : $engr_checked_by_logs[2]));
		$signatories_log	   .= '<br>QC:'.display_approvers_log($qc_checked_by_logs[0], $qc_checked_by_logs[1], $aRow['qc_checked_by'], (isset($qc_checked_by_logs[2]) ? $qc_checked_by_logs[2] : ''));
		
		// $aRow['status'] = 'FOR QC APPROVAL';//novs
		
		if($aRow['status'] == 'FOR QC APPROVAL') {
			$badge 	   = '<span class="badge highlight-color-yellow" > PENDING</span>';
			$buttons   = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-remove" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button>';
		} else if($aRow['status'] == 'POSTED') {
			$badge 	   = '<span class="badge highlight-color-green" > POSTED</span>';
			$buttons   = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
		} else if(strstr($aRow['status'], "CANCEL")){
			$badge 	   = '<span class="badge highlight-color-red" >'.$aRow['status'].'</span>';
			$buttons   = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
		} else {
			$badge 	   = '<span class="badge highlight-color-green" > DONE</span>';
			$buttons  .= '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-remove" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button>';
		}	
		
		$row[] = $badge;
        $row[] = $aRow['control_no'];
        $row[] = $aRow['training_title'];
        $row[] = $aRow['line'];
        $row[] = $aRow['series_name'];
        $row[] = $training_date; 
        $row[] = $signatories_log;
        $row[] = $buttons;
		
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );

?>