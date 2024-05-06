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
				'control_no', 
				'category', 
				'parts_affected_parts', 
				'part_code', 
				'supplier', 
				'(SELECT GROUP_CONCAT(  `lot_number` ) FROM  `tbl_qfr_aye_lot_numbers` WHERE fk_aye=tbl_qfr_aye.pkid) as lot_number', 
				'(SELECT SUM(  `quantity` ) FROM  `tbl_qfr_aye_lot_numbers` WHERE fk_aye=tbl_qfr_aye.pkid) as quantity', 
				'sample_size', 
				'percent_ng', 
				'date_issued', 
				'device_name', 
				'po_number', 
				'po_qty', 
				'customer_name', 
				'shipment_date', 
				'remarks', 
				'aye_judgement', 
				'judgement_date', 
				'judgement_remarks', 
				'illustration_name',
				'created_by',
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_aye";
	
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
		$sOrder = " ORDER BY aye_judgement ASC,control_no DESC ";
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
		}
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
	$username 	= $_GET['username'];
	$sql_where 	= $_GET['wh'];
	if($sWhere == ""){
		$sWhere .= "WHERE  (created_by = '$username' AND logdel='0')";
	}else{
		if(substr($sWhere,-3) != 'OR ') {
			$sWhere .= "AND (created_by = '$username' AND logdel='0')";
		} else {
			$sWhere = substr($sWhere,0, -3)." AND (created_by = '$username' AND logdel='0'))";
		}
	}
	
	if($sql_where != ""){
		$sWhere 	= $sql_where." AND (created_by = '$username') AND logdel='0'";
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
	// echo "<hr>".$sQuery."<hr>";
	// $query_used = $sQuery;
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	
	
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

	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
		$row[] = $aRow['control_no'];
		$row[] = $aRow['date_issued'];
		if($aRow['category'] == "Parts"){
			$row[] = 'Part Name : '.$aRow['parts_affected_parts'].'<br>'.
				 'Part Code : '.$aRow['part_code'].'<br>'.
				 'Supplier Name : '.$aRow['supplier'].'<br>'.
				 'Lot # : '.$aRow['lot_number'].'<br>'.
				 'Quantity : '.$aRow['quantity'];
		} else{
			$row[] = 'Device Name : '.$aRow['device_name'].'<br>'.
				 'PO # : '.$aRow['po_number'].'<br>'.
				 'PO Quantity : '.$aRow['po_qty'].'<br>'.
				 'Affected Quantity : '.$aRow['affected_quantity'].'<br>'.
				 'Customer Name : '.$aRow['customer_name'];
				 'Shipment Date : '.$aRow['shipment_date'];
		}
		$row[] = $aRow['sample_size'];
		$row[] = $aRow['percent_ng'];
		if($aRow['aye_judgement'] != ""){
			$row[] = 'Judgement : '.$aRow['aye_judgement'].'<br>'.
				 'Date : '.($aRow['judgement_date'] == '' ? '' : date('M d, Y', strtotime($aRow['judgement_date']))).'<br>'.
				 'Remarks : '.$aRow['judgement_remarks'];
		} else {
			$row[] = '<i>[Pending]</i>';
		}
		// $row[] = $aRow['notations_remarks'];
		$row[] = '<button class="btn btn-link" id="a_download_excel" data-id="'.$aRow['status'].'" value="'.$aRow['pkid'].'">Download Excel</button>';
		if($aRow['status'] == 'NO JUDGEMENT') {
			$button  = '<button class="btn btn-primary fa fa-edit" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> Edit</button>';
			$button .= '<button class="btn btn-default fa fa-plus" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> Add Judgement</button>';
		} else if($aRow['status'] == 'WITH JUDGEMENT') {
			$button  = '<button class="btn btn-primary fa fa-eye" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> View</button>';
		} else {
			$row[] = 'N/A';
			$button = '';
		}
		
		// $button .= '<button class="btn btn-danger fa fa-times-circle" style="margin-bottom:5px;" id="'.$aRow['pkid'].'"> Cancel</button>';
		$row[] = $button;
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );
	
	
	?>