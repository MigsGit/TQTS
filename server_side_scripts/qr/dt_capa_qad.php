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
				'tbl_qfr_capa_main.pkid',
				'control_no', 
				'classification', 
				'section', 
				'product_mode', 
				'received_date', 
				'failure_mode', 
				'assigned_line', 
				'customer', 
				'capa_received',
				'status'
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "tbl_qfr_capa_main.pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_capa_main RIGHT JOIN tbl_qfr_capa_3rd_validation_external ON tbl_qfr_capa_3rd_validation_external.fk_capa = tbl_qfr_capa_main.`pkid` ";
	
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
	$sql_where 	= $_GET['wh'];	
	$username   = $_GET['username'];
	
	//if($sWhere == ""){
	//	$sWhere .= "WHERE  ";
	//}else{
	//	$sWhere .= "AND ";
	//}
	//$sWhere .= " (`operations_qe` LIKE '%".$username."%')";
	
	
	//if($sql_where != ""){
	//	$sWhere 	= $sql_where;
	//}
	
	if($sOrder == ""){
		$sOrder = 'ORDER BY tbl_qfr_capa_main.pkid DESC';
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
	include('capa_user_roles.php');
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$buttons = '';
		unset($row);
		$row   = array();
		if($capa_qs_inspector_access['create']) {
			$buttons .= '<button type="button" class="btn btn-success fa fa-plus" data-id="'.$aRow['pkid'].'"> Add</button><br>';
		} if($capa_qs_inspector_access['update']) {
			$buttons .= '<button type="button" class="btn btn-primary fa fa-edit" data-id="'.$aRow['pkid'].'" style="margin-top:2px;"> Edit</button><br>';
		} 
		$buttons .= '<button type="button" class="btn btn-default fa fa-eye" data-id="'.$aRow['tbl_qfr_capa_main.pkid'].'" style="margin-top:2px;"> View</button>';
		$row[] = $aRow['status'];
		$row[] = $aRow['control_no'];
		$row[] = $aRow['classification'];
		$row[] = $aRow['section'];
		$row[] = $aRow['product_mode'];
		$row[] = $aRow['received_date'];
		$row[] = $aRow['failure_mode'];
		$row[] = $aRow['customer'];
		$row[] = $aRow['assigned_line'];
		$row[] = $aRow['capa_received'];
		$row[] = $buttons;
		
		array_push($output['aaData'],$row);
	}
	
	function get_current_status($pkid, $username) {
		require_once('../../class/oop_tqts.php');
		/* Check posting status */
		$table 	   	= 'tbl_qfr_capa_1st_monitoring';
		$joins 	   	= '';
		$sql_where 	= "WHERE fk_capa='".$pkid."' AND logdel=0";
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row->num_rows == 0) {
			
		}
		$array_fields = array('pkid');
		$table 	   	= 'tbl_qfr_capa_correction';
		$joins 	   	= '';
		$sql_where 	= "WHERE fkcapa='".$pkid."'
						(`1st_validation_conformed_by` LIKE '%".$username."%' AND `1st_validation_conformed_by_date` = '') OR 
						(`2nd_validation_conformed_by` LIKE '%".$username."%' AND `2nd_validation_conformed_by_date` = '') OR 
						(`3rd_validation_conformed_by` LIKE '%".$username."%' AND `3rd_validation_conformed_by_date` = '') OR 
						(`4th_validation_conformed_by` LIKE '%".$username."%' AND `4th_validation_conformed_by_date` = '') OR 
						(`5th_validation_conformed_by` LIKE '%".$username."%' AND `5th_validation_conformed_by_date` = '') OR 
						(`6th_validation_conformed_by` LIKE '%".$username."%'  AND `6th_validation_conformed_by_date` = '') OR 
						(`7th_validation_conformed_by` LIKE '%".$username."%'  AND `7th_validation_conformed_by_date` = '') OR 
						(`8th_validation_conformed_by` LIKE '%".$username."%' AND `8th_validation_conformed_by_date` = '') OR 
						(`9th_validation_conformed_by` LIKE '%".$username."%'  AND `9th_validation_conformed_by_date` = '') OR 
						(`10th_validation_conformed_by` LIKE '%".$username."%'  AND `10th_validation_conformed_by_date` = '') OR 
						(`11th_validation_conformed_by` LIKE '%".$username."%'  AND `11th_validation_conformed_by_date` = '') OR 
						(`12th_validation_conformed_by` LIKE '%".$username."%'  AND `12th_validation_conformed_by_date` = '') AND logdel=0";
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row->num_rows == 0) {
			
		} else {
			$badge = '<span class="badge highlight-color-yellow" > FOR CHECKING</span>';
		}
		return $badge;
	}
	
	echo json_encode( $output );	
?>