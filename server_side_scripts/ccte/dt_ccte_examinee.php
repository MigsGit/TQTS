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
				'tbl_theoretical_exam.pkid',
				'status', 
				'empno', 
				'take_type', 
				'date_exam', 
				'series_name', 
				'defect', 
				'brief_desc', 
				'state', 
				'series_name_score', 
				'defect_score', 
				'brief_desc_score', 
				'state_score', 
				'series_name_points', 
				'defect_points', 
				'brief_desc_points', 
				'state_points', 
				'checked_by', 
				'date_time_checked',
				'exam_result'
				);
	
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "tbl_theoretical_exam.pkid";
	
	/* DB table to use */
	$sTable = "tbl_theoretical_exam, tbl_theoretical_points";
	
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
	
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	$sWhere .= " tbl_theoretical_exam.logdel=0 AND tbl_theoretical_points.logdel=0";
	
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
		unset($row);
		$row   = array();
		$buttons = '';
		
		if($aRow['status'] == 'DRAFT') {
			$buttons .= '<button type="button" class="btn btn-primary fa fa-edit" data-id="'.$aRow['pkid'].'"> Edit</button><br>';
			$badge = '<span class="badge highlight-color-gray" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'FOR CHECKING') {
			$badge = '<span class="badge highlight-color-yellow" >'.$aRow['status'].'</span>';
		} else if($aRow['status'] == 'CHECKED') {
			$badge = '<span class="badge highlight-color-green" >'.$aRow['status'].'</span>';
		}
		
		$buttons .= '<button type="button" class="btn btn-default fa fa-eye" data-id="'.$aRow['pkid'].'" style="margin-top:5px;"> View</button>';
		
		
		$score  = $aRow['series_name_score'] + $aRow['defect_score'] + $aRow['brief_desc_score'] + $aRow['state_score']; 
		$points = $aRow['series_name_points'] + $aRow['defect_points'] + $aRow['brief_desc_points'] + $aRow['state_points'];
		
		$row[] = $badge;
		$row[] = $aRow['date_exam'] == '' ? '' : date('M d, Y', strtotime($aRow['date_exam']));
		$row[] = $aRow['series_name'];
		$row[] = $score . '/' . $points.' = '.round((($score/$points)*100),2).'%';
		$row[] = $aRow['take_type'].' => '. ($aRow['exam_result'] == '' ? '<i>[PENDING]</i>' : $aRow['exam_result'] );
		$row[] = $aRow['checked_by'] == '' ? '-' : $aRow['date_time_checked'] == '' ? '' : get_emp_name_by_username_systemone_rapid($aRow['checked_by']). ' [<b><i>'.(date('M d, Y h:i:s A',strtotime($aRow['date_time_checked']))).'</i></b>]';
		$row[] = $buttons;
		
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );

?>