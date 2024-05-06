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

	$aColumns = array('pkid',
                'created_by',
                'machine_area',
                'machine_no',
				'monitoring_type',
                'area',
                'monitoring_year_month',
                'monitoring_file',
                'fkfile_path',
                'remarks',
                'checked_by',
                'approved_by',
                'username',
                'created_at',
                'updated_at'
                );

	// $aColumns = array('*');
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_ipqc_lqc_monitoring";
	
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
		$sOrder = " ORDER BY pkid DESC ";
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
	
	$username 	= $_GET['username'];
	$sql_where 	= $_GET['wh'];
	if($sql_where != ""){
		$sWhere 	= $sql_where;
	}
	
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	$sWhere .= "`logdel` = 0";
	
	
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
	// $query_used = $sQuery;
	// echo $query_used."<hr>";
	
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

	/* Get Full Name using Username */
	require_once("../../handler/common_handler.php");

	/* Get User Access */
	require_once('../../handler/common_function.php');
	$user_role = get_user_roles($username);
	$subsystem_code 			= "IPQC";
	$module 					= "LQC Monitoring Result";
	$user_lqc_access 	    	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module && $user_role['role'][$key]=='SUPERVISOR'){ 
			if ($user_role['create'][$key] == 1){
				$user_lqc_access['create'] = true;
			}
			if ($user_role['read'][$key] == 1){
				$user_lqc_access['read'] = true;
			}
			if ($user_role['update'][$key] == 1){
				$user_lqc_access['update'] = true;
			}
			if ($user_role['delete'][$key] == 1){
				$user_lqc_access['delete'] = true;
			}
		}
	}
	/*
	 * Output
	 */
    

	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array(),
		'sWhere' => $sWhere
	);
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
        unset($row);
		$row[]='<center> <span class="badge highlight-color-green">Uploaded</span> </center>';
			$display=array();
			if($aRow['machine_no']!=null){
				$display[] = '<p> Machine No. 		: '.$aRow['machine_no'].' </p>';
				$display[] = '<p> Monitoring Type 	: '.$aRow['monitoring_type'].' </p>';
			}else if($aRow['area']!=null){
				$display[] = '<p> Area : '.$aRow['area'].' </p>';
				$display[] = '<p> Monitoring Type 	: '.$aRow['monitoring_type'].' </p>';
			}
		$row[]=implode($display);
		$row[]=date('M-Y',strtotime($aRow['monitoring_year_month']));
		$row[]='<center> <a class = "fa fa-file-excel-o" id="a_download" data-id="'.$aRow['pkid'].'"> Download Attachment</a> </center>';
		$row[]=get_emp_name_by_username_systemone_rapid($aRow['checked_by']);
		$row[]=get_emp_name_by_username_systemone_rapid($aRow['approved_by']);
            $button = array();
			if($user_lqc_access['update']){
				$button[]='<button class="btn btn-primary fa fa-eye" style="margin-bottom:5px;" data-id="'.$aRow['pkid'].'"> View/Edit</button><br>';
			}
			if($user_lqc_access['update']){
				$button[]='<button class="btn btn-danger fa fa-remove" style="margin-bottom:5px;" data-id="'.$aRow['pkid'].'"> Delete</button><br>';
			}
            $button='<center>'.implode($button).'</center>';

        $row[] = $button;
	    array_push($output['aaData'],$row);
	}
	echo json_encode( $output );
	
	
	 
	
	
