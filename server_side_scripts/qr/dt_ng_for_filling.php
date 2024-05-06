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
	/* 
			Invoice #			Application Date		Inspection Date	
			Inspection 			Time					FY #	
			WW #				Sub						Part Code	
			Part Name			Supplier				Lot #	
			AQL					Judgement
	
	*/
	$aColumns = array( 
				'invoice_no', 
				'inspection_date', 
				'inspection_time', 
				'submission', 
				'partcode', 
				'partname', 
				'supplier', 
				'lot_no',
				'quantity',
				'pkid'
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_ng_wbs_rejected_visual_inspection";
	
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
	// $keyword = $_GET['kw'];
	// $value 	 = $_GET['vl'];
	// if($value != '') {
		if($sWhere == ""){
			$sWhere .= "WHERE";
		}else{
			$sWhere .= "AND ";
		}
		$sWhere .= "`logdel`=0";

		
		// $date_start = $_GET['date_start'];
		// $date_end 	= $_GET['date_end'];
		
		// $sWhere .= "((date BETWEEN '" . $date_start . "' AND '" . $date_end . "') OR (date_out BETWEEN '" . $date_start . "' AND '" . $date_end . "')) AND `empno` LIKE '%".$empno."%'";
		// $sWhere .= " logdel=0";
	// } 
    // $sOrder = 'ORDER BY pkid DESC';
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
		$row[] = $aRow['inspection_date'] == '' ? '' : date('M d, Y', strtotime($aRow['inspection_date']));
		$row[] = $aRow['inspection_time'];
		$row[] = $aRow['submission'];
		$row[] = $aRow['invoice_no'];
		$row[] = $aRow['partcode'];
		$row[] = $aRow['partname'];
		$row[] = $aRow['lot_no'];
		$row[] = $aRow['quantity'];
		$row[] = $aRow['supplier'];
		$row[] = '<center><button type="button" class="btn btn-success fa fa-plus" value="'.$aRow['pkid'].'"> Add</button></center>';
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );
	/* add ng script pra maupdate ung nagawan n ng NG report s pending */
	function update_qfr_ng_wbs_rejected_visual_inspection() {
		require_once('../../class/oop_tqts.php');
		$array_fields = array('qrs.approver_username', 'qrs.status','qrs.date_time_approved','qrs.approver_remarks');
		$table 	   	= 'tbl_qfr_ng_wbs_rejected_visual_inspection';
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