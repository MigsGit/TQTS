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
				'correction_action',
				'(SELECT received_date FROM tbl_qfr_capa_main WHERE tbl_qfr_capa_main.pkid = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_main.logdel=0 LIMIT 0,1) as received_date', 
				'(SELECT product_mode FROM tbl_qfr_capa_main WHERE tbl_qfr_capa_main.pkid = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_main.logdel=0 LIMIT 0,1) as product_mode', 
				'(SELECT failure_mode FROM tbl_qfr_capa_main WHERE tbl_qfr_capa_main.pkid = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_main.logdel=0 LIMIT 0,1) as failure_mode', 
				'(SELECT classification FROM tbl_qfr_capa_main WHERE tbl_qfr_capa_main.pkid = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_main.logdel=0 LIMIT 0,1) as classification', 
				'(SELECT `order` FROM tbl_qfr_capa_1st_monitoring WHERE tbl_qfr_capa_1st_monitoring.fk_capa = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_1st_monitoring.logdel=0 AND tbl_qfr_capa_1st_monitoring.fk_capa_correction = tbl_qfr_capa_correction.pkid LIMIT 0,1) as order_1st', 
				'(SELECT `qs_status` FROM tbl_qfr_capa_1st_monitoring WHERE tbl_qfr_capa_1st_monitoring.fk_capa = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_1st_monitoring.logdel=0 AND tbl_qfr_capa_1st_monitoring.fk_capa_correction = tbl_qfr_capa_correction.pkid LIMIT 0,1) as status_1st', 
				'(SELECT `order` FROM tbl_qfr_capa_2nd_validation_external WHERE tbl_qfr_capa_2nd_validation_external.fk_capa = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_2nd_validation_external.logdel=0 AND tbl_qfr_capa_2nd_validation_external.fk_capa_correction = tbl_qfr_capa_correction.pkid LIMIT 0,1) as order_2nd', 
				'(SELECT `qc_status` FROM tbl_qfr_capa_2nd_validation_external WHERE tbl_qfr_capa_2nd_validation_external.fk_capa = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_2nd_validation_external.logdel=0 AND tbl_qfr_capa_2nd_validation_external.fk_capa_correction = tbl_qfr_capa_correction.pkid LIMIT 0,1) as status_2nd',  
				'(SELECT `order` FROM tbl_qfr_capa_3rd_validation_external WHERE tbl_qfr_capa_3rd_validation_external.fk_capa = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_3rd_validation_external.logdel=0 AND tbl_qfr_capa_3rd_validation_external.fk_capa_correction = tbl_qfr_capa_correction.pkid LIMIT 0,1) as order_3rd', 
				'(SELECT `qad_status` FROM tbl_qfr_capa_3rd_validation_external WHERE tbl_qfr_capa_3rd_validation_external.fk_capa = tbl_qfr_capa_correction.fk_capa AND tbl_qfr_capa_3rd_validation_external.logdel=0 AND tbl_qfr_capa_3rd_validation_external.fk_capa_correction = tbl_qfr_capa_correction.pkid LIMIT 0,1) as status_3rd', 
				'correction_action',
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_capa_correction";
	
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
	$sql_where 	= $_GET['wh'];	
	$username   = $_GET['username'];
	
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	// $sWhere .= " (`operations_qe` LIKE '%".$username."%')";
	$sWhere .= " logdel=0";
	
	
	//if($sql_where != ""){
	//	$sWhere 	= $sql_where;
	//}
	
	// if($sOrder == ""){
		// $sOrder = 'ORDER BY tbl_qfr_capa_main.pkid DESC';
	// }
    
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
	$status = '';
	include('capa_user_roles.php');
	include('../../handler/handler_qfr_capa.php');
	
	while ( $aRow = mysql_fetch_assoc( $rResult ) )
	{
		unset($row);
		$row   = array();
		
		$received_date 	= $aRow['received_date'];
		$product_mode 	= $aRow['product_mode'];
		$failure_mode 	= $aRow['failure_mode'];
		$classification = $aRow['classification'];
		$correction_action = $aRow['correction_action'];
				
		$order_1st 		= $aRow['order_1st'];
		$status_1st		= $aRow['status_1st'] == 'CLOSED' ? '<span class="label label-success"> '.$aRow['status_1st'].'</span>' : '<span class="label label-warning"> '.$aRow['status_1st'].'</span>';
		$order_2nd 		= $aRow['order_2nd'];
		$status_2nd		= $aRow['status_2nd'] == 'CLOSED' ? '<span class="label label-success"> '.$aRow['status_2nd'].'</span>' : '<span class="label label-warning"> '.$aRow['status_2nd'].'</span>';
		$order_3rd 		= $aRow['order_3rd'];
		$status_3rd		= $aRow['status_3rd'] == 'CLOSED' ? '<span class="label label-success"> '.$aRow['status_3rd'].'</span>' : '<span class="label label-warning"> '.$aRow['status_3rd'].'</span>';	
		
		$row[] = '<center>'.($received_date == '' ? '' : date('M d, Y', strtotime($received_date))).'</center>';
		$row[] = '<center>'.$classification.'</center>';
		$row[] = $product_mode;
		$row[] = $failure_mode;
		$row[] = $correction_action;
		$row[] = '<center>'.($order_1st == 13 ? $status_1st : str_replace('_', ' ',return_monitoring_field('', $order_1st)) . ' monitoring').'</center>';
		$row[] = '<center>'.($classification == 'Internal' ? 'N/A' : ($order_2nd == 13 ? $status_2nd : str_replace('_', ' monitoring',return_monitoring_field('', $order_2nd)))).'</center>';
		$row[] = '<center>'.($classification == 'Internal' ? 'N/A' : ($order_3rd == 13 ? $status_3rd : str_replace('_', ' monitoring',return_monitoring_field('', $order_3rd)))).'</center>';
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );	
?>