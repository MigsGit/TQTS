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
				'oqc_lon.logdel', 
				'oqc_lon.pkid', 
				'oqc_lon.status', 
				'oqc_lon.lon_ctr', 
				'oqc_lon.section', 
				'oqc_lon.attention', 
				'oqc_lon.attention_logs', 
				'oqc_lon.attention_remarks', 
				'oqc_lon.date_inspected', 
				'oqc_lon.defect_mode', 
				'oqc_lon.po_number', 
				'oqc_lon.lot_submission', 
				'oqc_lon.lot_number', 
				'oqc_lon.lot_qty', 
				'oqc_lon.aql', 
				'oqc_lon.sample_size', 
				'oqc_lon.capa_due_date',
				'oqc_lon.created_by', 
				'oqc_lon.date_time_created', 
				'oqc_lon.checked_by', 
				'oqc_lon.checked_by_status', 
				'oqc_lon.checked_by_logs', 
				'oqc_lon.checked_by_remarks', 
				'oqc_lon.approved_by', 
				'oqc_lon.approved_by_status', 
				'oqc_lon.approved_by_logs', 
				'oqc_lon.approved_by_remarks',
				'oqc_lon_production.created_by AS prodn_created_by',
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "oqc_lon.pkid";
	
	/* DB table to use */
	$sTable = "tbl_oqc_lon oqc_lon";
	$sJoin = "LEFT JOIN tbl_oqc_lon_production oqc_lon_production ON oqc_lon_production.fklon = oqc_lon.pkid";
	
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
	$username   = $_GET['username'];
	// if($sWhere == ""){
		// $sWhere .= "WHERE ";
	// }else{
		// $sWhere .= "AND ";
	// }
	// $sWhere .= " logdel=0";
	
	// $sWhere = "WHERE oqc_lon_production.created_by LIKE '%".$username."%' AND oqc_lon.approved_by_status='APPROVED' OR oqc_lon.status = 'REJECTED BY OQC INSPECTOR' AND oqc_lon.logdel=0"; //REJECTED BY OQC INSPECTOR
	$sWhere = 'WHERE 1=1';
	$sWhere .= " AND oqc_lon.approved_by_status='APPROVED' AND oqc_lon.logdel=0 OR oqc_lon.checked_by LIKE '%".$username."%'";
	// $sWhere .= " AND oqc_lon_production.created_by LIKE '%".$username."%' AND oqc_lon_production.logdel=0 ";
	$sWhere .= " AND oqc_lon_production.created_by LIKE '%".$username."%' AND oqc_lon_production.logdel=0 ";
	
	$sql_where 	= $_GET['wh'];	
	
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
	$script = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sJoin
		$sWhere
		$sOrder
		$sLimit
	";
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sJoin
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	// echo "limit: ".$sLimit." : ".$sQuery."<hr>";
	// $query_used = $sQuery;
	// echo $query_used."<br>";
	
	/* Data set length after filtering 
	
		SELECT SQL_CALC_FOUND_ROWS oqc_lon.logdel, oqc_lon.pkid, oqc_lon.status, oqc_lon.lon_ctr, oqc_lon.section, oqc_lon.attention, oqc_lon.attention_logs, oqc_lon.attention_remarks, oqc_lon.date_inspected, oqc_lon.defect_mode, oqc_lon.po_number, oqc_lon.lot_submission, oqc_lon.lot_number, oqc_lon.lot_qty, oqc_lon.aql, oqc_lon.sample_size, oqc_lon.capa_due_date, oqc_lon.created_by, oqc_lon.date_time_created, oqc_lon.checked_by, oqc_lon.checked_by_status, oqc_lon.checked_by_logs, oqc_lon.checked_by_remarks, oqc_lon.approved_by, oqc_lon.approved_by_status, oqc_lon.approved_by_logs, oqc_lon.approved_by_remarks, oqc_lon_production.created_by AS prodn_created_by
		FROM   tbl_oqc_lon oqc_lon
		LEFT JOIN tbl_oqc_lon_production oqc_lon_production ON oqc_lon_production.fklon = oqc_lon.pkid
		WHERE 1=1 AND oqc_lon.approved_by_status='APPROVED' OR oqc_lon.status = 'REJECTED BY OQC INSPECTOR' AND oqc_lon.logdel=0 AND oqc_lon_production.created_by LIKE '%abgutierrez%' AND oqc_lon_production.logdel=0 
		ORDER BY pkid DESC
		LIMIT 0, 10
	
		SELECT SQL_CALC_FOUND_ROWS oqc_lon.logdel, oqc_lon.pkid, oqc_lon.status, oqc_lon.lon_ctr, oqc_lon.section, oqc_lon.attention, oqc_lon.attention_logs, oqc_lon.attention_remarks, oqc_lon.date_inspected, oqc_lon.defect_mode, oqc_lon.po_number, oqc_lon.lot_submission, oqc_lon.lot_number, oqc_lon.lot_qty, oqc_lon.aql, oqc_lon.sample_size, oqc_lon.capa_due_date, oqc_lon.created_by, oqc_lon.date_time_created, oqc_lon.checked_by, oqc_lon.checked_by_status, oqc_lon.checked_by_logs, oqc_lon.checked_by_remarks, oqc_lon.approved_by, oqc_lon.approved_by_status, oqc_lon.approved_by_logs, oqc_lon.approved_by_remarks, oqc_lon_production.created_by AS prodn_created_by
		FROM   tbl_oqc_lon oqc_lon
		LEFT JOIN tbl_oqc_lon_production oqc_lon_production ON oqc_lon_production.fklon = oqc_lon.pkid
		WHERE 1=1 AND oqc_lon.approved_by_status='UPLOADED DISPOSITION' AND oqc_lon.logdel=0 AND oqc_lon_production.created_by = 'mcaday' OR oqc_lon.checked_by = 'abgutierrez' AND oqc_lon_production.logdel=0 
		ORDER BY pkid DESC
		LIMIT 0, 10
	
	*/
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
		"aaData" => array(),
		"script" => $script,
	);
	
	require_once('../../handler/common_handler.php');
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row 		= array();
		$buttons 	= '';
		unset($row);
        
		if($aRow['status'] == 'APPROVED BY LQC MANAGER') {
			$badge 	   = '<span class="badge highlight-color-yellow" > PENDING</span>';
			$buttons   = '<button type="button" class="btn btn-primary fa fa-plus" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Add</button><br>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button><br>';
			$buttons  .= '<button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button><br>';
		} else if($aRow['status'] == 'UPLOADED DISPOSITION') {
			$badge 	   = '<span class="badge highlight-color-green" > DONE</span>';
			$buttons  = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button><br>';
			$buttons  .= '<button type="button" class="btn btn-primary fa fa-edit" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Edit</button><br>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button><br>';
			$buttons  .= '<button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button><br>';
		} else if($aRow['status'] == 'CONFORMED BY LQC SUPERVISOR') {
			$badge 	  = '<span class="badge highlight-color-green" > CONFORMED</span>';
			$buttons  = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button><br>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button><br>';
			$buttons  .= '<button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button><br>';
		} else if($aRow['status'] == 'REJECTED BY OQC INSPECTOR') {
			$badge 	  = '<span class="badge highlight-color-red" > REJECTED BY OQC INSPECTOR</span>';
			$buttons  = '<button type="button" class="btn btn-primary fa fa-edit" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Edit</button><br>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button><br>';
		} else if($aRow['status'] == 'CONFORMED BY OQC INSPECTOR') {
			$badge 	  = '<span class="badge highlight-color-green" > CONFORMED</span>';
			$buttons  = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button><br>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button><br>';
			$buttons  .= '<button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button><br>';
		} else if(strstr($aRow['status'] , "CANCELLED")) {
			$badge 	  = '<span class="badge highlight-color-red" > '.$aRow['status'].'</span>';
			$buttons  = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button><br>';
		} else {
			$badge 	  = '<span class="badge highlight-color-default" >'.$aRow['status'].'</span>';
			$buttons  = '<button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button><br>';
			$buttons  .= '<button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Cancel</button>';
		}
		//164 REJECTED BY OQC INSPECTOR 
		$attention_name		= '';
		$attention_username = explode(",", $aRow['attention']);
		for($i=0; $i<count($attention_username); $i++) {
			$attention_name .= get_emp_name_by_username_systemone_rapid($attention_username[$i]).'<br>';
		}
		
		$series_name	= get_series_name_by_po_number_fn($aRow['po_number']);
		$part_details  	= 'PO Number: '.$aRow['po_number'].'<br>';
		$part_details  .= 'Device Name: '.$series_name.'<br>';
		$part_details  .= 'Lot No.: '.$aRow['lot_number'].'<br>';
		
		$lot_details    = 'Lot Submission: '.$aRow['lot_submission'].'<br>';
		$lot_details   .= 'Lot Qty.: '.$aRow['lot_qty'].'<br>';
		$lot_details   .= 'AQL: '.$aRow['aql'].'<br>';
		$lot_details   .= 'Sample Size: '.$aRow['sample_size'].'<br>';

		
		$signatories_log  = get_emp_name_by_username_systemone_rapid($aRow['created_by']).'<b> ['.( $aRow['date_time_created'] == '' ? '-' : date('M d, Y', strtotime($aRow['date_time_created'])) ).'</i>]</b>';
		$signatories_log .= '<br>'.get_emp_name_by_username_systemone_rapid($aRow['checked_by']).'<b> ['.$aRow['checked_by_status'].' - <i>'.( $aRow['checked_by_logs'] == '' ? '-' : date('M d, Y', strtotime($aRow['checked_by_logs'])) ).'</i>]</b>';
		$signatories_log .= '<br>'.get_emp_name_by_username_systemone_rapid($aRow['approved_by']).'<b> ['.($aRow['approved_by_status'] == '' ? 'PENDING' : $aRow['approved_by_status'].'-' ).'<i>'.( $aRow['approved_by_logs'] == '' ? '' : date('M d, Y', strtotime($aRow['approved_by_logs'])) ).'</i>]</b>';
		
		$row[] = $badge.'<input type="hidden" value="'.$aRow['status'].'">';
        $row[] = $aRow['section'].'-'.date('my', strtotime($aRow['date_time_created'])).'-'.$aRow['lon_ctr'];
        $row[] = $attention_name;
        $row[] = $aRow['defect_mode'];
        $row[] = $part_details;
        $row[] = $lot_details;
        $row[] = $aRow['capa_due_date'] == '' ? '-' : date('M d, Y', strtotime($aRow['capa_due_date']));
        $row[] = $signatories_log;
        $row[] = $buttons;
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );

?>