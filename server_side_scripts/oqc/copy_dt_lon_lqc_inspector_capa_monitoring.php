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
					'id', 
					'tbl_oqc_lon_id', 
					'oqc_capa_action', 
					'oqc_capa_action_incharge', 
					'oqc_capa_due_date', 
					'oqc_capa_status', 
					'oqc_capa_req_sub_date', 
					'oqc_capa_actual_sub_date', 
					'oqc_capa_remarks', 
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_oqc_lon";
	
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
	
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	
	if(check_has_supervisor_access($username)) {	
		$sWhere .= " logdel=0";
	} else {
		$sWhere .= " logdel=0 AND created_by='".$username."' ";		
	}
	
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
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
        
		$buttons = '';
		$badge 	 = '';
		
		if($aRow['status'] == 'FOR CHECKING LQC SUPERVISOR' || $aRow['status'] == 'ACCEPTED BY LQC SUPERVISOR' || $aRow['status'] == 'APPROVED BY LQC MANAGER') {
			$badge 		= '<span class="badge highlight-color-orange" > '.$aRow['status'].'</span>';
			$buttons   .= '<br><button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
			$buttons   .= '<br><button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button>';
		} else if(strstr($aRow['status'], 'REJECTED') || strstr($aRow['status'], 'DISAPPROVED')) {
			$badge 		= '<span class="badge highlight-color-red" > '.$aRow['status'].'</span>';
			$buttons  	= '<button type="button" class="btn btn-primary fa fa-edit" id="'.$aRow['pkid'].'"> Revise</button>';
			$buttons   .= '<br><button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
			$buttons   .= '<br><button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:2px;"> Cancel</button>';
		} else if($aRow['status'] == 'UPLOADED DISPOSITION') {
			$badge 		= '<span class="badge highlight-color-yellow" > FOR CONFORMANCE</span>';
			$buttons 	= '<button type="button" class="btn btn-primary fa fa-tasks" id="'.$aRow['pkid'].'" style="margin-top:2px;"> Review</button>';
			$buttons   .= '<br><button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
			$buttons   .= '<br><button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:2px;"> Cancel</button>';
			$buttons   .= '<br><button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button>';
		} else if($aRow['status'] == 'CONFORMED BY OQC INSPECTOR') {
			$badge 		= '<span class="badge highlight-color-green" > CONFORMED</span>';
			$buttons   .= '<br><button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
			$buttons   .= '<br><button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:2px;"> Cancel</button>';
			$buttons   .= '<br><button type="button" class="btn btn-success fa fa-file-excel-o" id="'.$aRow['pkid'].'" style="margin-top:5px;"> Export</button>';
		} else if(strstr($aRow['status'], 'CANCELLED')) {
			$badge 		= '<span class="badge highlight-color-red" > '.$aRow['status'].'</span>';
			$buttons   .= '<br><button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
		} else {
			$badge 		= '<span class="badge highlight-color-yellow" >'.$aRow['status'].'</span>';
			$buttons   .= '<br><button type="button" class="btn btn-default fa fa-eye" id="'.$aRow['pkid'].'" style="margin-top:2px;"> View</button>';
			$buttons   .= '<br><button type="button" class="btn btn-danger fa fa-close" id="'.$aRow['pkid'].'" style="margin-top:2px;"> Cancel</button>';
		}
		
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

		$signatories_log  = '<br>'.get_emp_name_by_username_systemone_rapid($aRow['created_by']).'<b> [CREATED'.( $aRow['date_time_created'] == '' ? '' : ' - <i>'.date('M d, Y h:i:s a', strtotime($aRow['date_time_created'])) ).'</i>]</b>';
		$signatories_log .= '<br>'.get_emp_name_by_username_systemone_rapid($aRow['checked_by']).'<b> ['.$aRow['checked_by_status'].( $aRow['checked_by_logs'] == '' ? '' : ' - <i>'.date('M d, Y h:i:s a', strtotime($aRow['checked_by_logs'])) ).'</i>]</b>';
		$signatories_log .= '<br>'.get_emp_name_by_username_systemone_rapid($aRow['approved_by']).'<b>['.($aRow['approved_by_status'] == '' ? ' PENDING' : $aRow['approved_by_status'] ).( $aRow['approved_by_logs'] == '' ? '' : ' - <i>'.date('M d, Y h:i:s a', strtotime($aRow['approved_by_logs'])) ).'</i>]</b>';
		
		$row[] = $badge;
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
	
	/* Request by Ma'am Kris P. 8/14/2018 to view all created record of inspector to all supervisor */
	function check_has_supervisor_access($username) {
		require_once('../../class/oop_tqts.php');
		/* Check posting status */
		$table 	   	= 'vw_user_roles';
		$array_fields = array('*');
		$joins 	   	= '';
		$sql_where 	= "WHERE user='".$username."' AND module = 'Lot-out Notice-LQC Supervisor' AND `update`=1 AND logdel=0";
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			return false;
		} else {
			return true;
		}
		// return $script;
	}
	
	echo json_encode( $output );

?>