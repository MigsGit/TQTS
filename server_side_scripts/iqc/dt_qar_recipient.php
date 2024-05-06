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
				'status',
				'control_no_count',
				'part_code',
				'part_name', 
				'model', 
				'mode_of_defect', 
				'location_of_defect', 
				'lot_name', 
				'lot_qty', 
				'checked_qty',
				'ng_qty',
				'ng_rate',
				'ng_condition_text',
				'ng_condition_files',
				'pkid',
				'CONCAT(`section`,"-",`prod_code`,"-",DATE_FORMAT(`date_created`,"%m%y"),"-",`control_no_count`) as control_no'
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_iqc_qar";
	
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
			if(strpos($aColumns[$i], ' as ') !== false){ /* check if this is an alias */
				$position = stripos($aColumns[$i]," as ");
				$new_search_column = '('.substr_replace($aColumns[$i], '', $position, 100).')';
				$sWhere .= $new_search_column." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}else{
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
	
	/* Where from advanced search */
	$array_search = array();
	/* append array conditions here */
	
	/* Default to remove all logdel zero */
	$array_search[] = "(`status`= 1 OR `status` = '3' OR `status` = '4')";
	$array_search[] = "`attn` LIKE '%".$_GET['username']."%'";
	$array_search[] = "logdel=0";
	
	/* Check if sWhere is not empty */
	if($sWhere == ""){
		$sWhere .= ' WHERE '.implode(" AND ", $array_search);
	}else{
		$sWhere .= "AND ".implode(" AND ", $array_search);
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
	$query_used = $sQuery;
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
	
	require_once("../../handler/common_function.php");
	
	/* get user role */
	// $username = $_GET['username'];
	// $user_role = get_user_roles($username);
	// $user_oqc_dir_access 	    = array("create" => false, 
										// "read" => false,
										// "update" => false,
										// "delete" => false
										// );
	// $subsystem_code 			= "OQC";
	// $module 					= "Dimension Inspection Result";
	// foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		// if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
			// if ($user_role['create'][$key] == 1){
				// $user_oqc_dir_access['create'] = true;
			// }
			// if ($user_role['read'][$key] == 1){
				// $user_oqc_dir_access['read'] = true;
			// }
			// if ($user_role['update'][$key] == 1){
				// $user_oqc_dir_access['update'] = true;
			// }
			// if ($user_role['delete'][$key] == 1){
				// $user_oqc_dir_access['delete'] = true;
			// }
		// }
	// }
	$division = return_system_division();
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
		$status = '';
		switch($aRow['status']){
			case "0"	: $status = '<span class="badge highlight-color-yellow"> Pending Conformance</span>'; break;
			case "1"	: $status = '<span class="badge highlight-color-red"> For Disposition</span>'; break;
			case "2"	: $status = '<span class="badge highlight-color-red"> Rejected</span>'; break;
			case "3"	: $status = '<span class="badge highlight-color-yellow"> For Review Disposition</span>'; break;
			case "4"	: $status = '<span class="badge highlight-color-orange"> Closed</span>'; break;
			case "9"	: $status = '<span class="badge highlight-color-red"> Cancelled</span>'; break;
		}
		$row[] = $status;
		$row[] = "QAR-".$division.$aRow['control_no'];
		$row[] = $aRow['part_code'];
		$row[] = $aRow['part_name'];
        $row[] = $aRow['model'];
        $mode_of_defect 	= explode("|",$aRow['mode_of_defect']);
        $location_of_defect = explode("|",$aRow['location_of_defect']);
        $lot_name 			= explode("|",$aRow['lot_name']);
        $lot_qty 			= explode("|",$aRow['lot_qty']);
		$row[] = implode("<br>",$mode_of_defect);
        $row[] = implode("<br>",$location_of_defect);
        $row[] = implode("<br>",$lot_name);
        $row[] =implode("<br>",$lot_qty);
        $row[] = $aRow['checked_qty'];
        $row[] = $aRow['ng_qty'];
        $row[] = $aRow['ng_rate']."%";
        // $row[] = $aRow['attachment_text'].'<br> <button type="button" class="btn btn-link fa fa-paperclip" id="btn_attachment" value="'.$aRow['pkid'].'"> Attachments</button>';
        $array_button = array();
		$array_button[] = '<button style="margin-bottom:5px;" type="button" class="btn btn-default fa fa-eye" id="btn_add" value="'.$aRow['pkid'].'"> View</button>';
		$row[] = implode("<br>",$array_button);
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );

?>