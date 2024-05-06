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
				'control_no',
				'category',
				'date',
				'product',
				'model',
				'part_code',
				'po_number',
				'lot_number',
				'quantity',
				'issued_by',
				'description',
				'remarks',
				'status',
				'created_by',
				'created_at',
				'updated_at',
				'username',
				'logdel',
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_attention_tag";
	
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
		$sOrder = " ORDER BY pkid DESC,control_no DESC  ";
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
		// $sWhere = "WHERE (";
		// for ( $i=0 ; $i<count($aColumns) ; $i++ )
		// {
		// 	// if( in_array($aColumns[$i],$array_search) ){
		// 	$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		// 	// }
		// }
		// $sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')'; 
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
	// for ( $i=0 ; $i<count($aColumns) ; $i++ )
	// {
	// 	if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
	// 	{
	// 		if ( $sWhere == "" )
	// 		{
	// 			$sWhere = "WHERE ";
	// 		}
	// 		else
	// 		{
	// 			$sWhere .= " AND ";
	// 		}
	// 		$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
	// 	}
	// }
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
	
	require_once("../../handler/common_function.php");
	
	/* get user role */ //IF DELETE AND UPDATE ACCESS 
	$username = $_GET['username'];

	$user_role = get_user_roles($username);
	$section 	    = '';
	$user_at_access 	    	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
	$subsystem_code 			= "QFR";
	$module 					= "Attention Tag";
	foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
		if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
			// $section = $user_role['section'][$key];
			if($user_role['create'][$key]==1){
				$user_at_access['create'] = true;
			}
			if($user_role['read'][$key]==1){
				$user_at_access['read'] = true;
			}
			if($user_role['update'][$key]==1){
				$user_at_access['update'] = true;
			}
			if($user_role['delete'][$key]==1){
				$user_at_access['delete'] = true;
			}
		}
	}
	/* 
		dito ka mag add ng where mo, una check mo kung may laman na yung $sWhere pag wala append mo yung where mo na meron
		kasama where kapag naman may laman na AND na syempre diba :)
	*/

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
		"aaData" => array(),
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
		$aRow['status'] == 1? $badge_class = '<span class = "badge highlight-color-green">Uploaded<span>'
		: $badge_class = '<span class = "badge highlight-color-red">Cancelled<span>';
		// :$badge_class ='';
		$row[] = '<center>'.$badge_class.'</center>';
		$row[] = $aRow['control_no'];
		$row[] = $aRow['date'];
		$row[] = $aRow['category'];
		$row[] = 'Product 	: '.$aRow['product'].'<br>'.
				 'Model		: '.$aRow['model'].'<br>';
		$row[] = get_emp_name_by_username_systemone($aRow['issued_by']);
		$row[] = $aRow['description'];			
		$row[] = '<a href="#"  name = "a_download" id="'.$aRow['pkid'].'"><i class="fa fa-file-pdf-o"></i> Download PDF File</a>';
		// $row[] = '<center><a href="#" id="a_download_excel" data-id="'.$aRow['pkid'].'">Download Excel</a></center>';

	
		$button = array();
	
		if($aRow['status']==2){ //status==Cancelled
			$button[] = '<center>';
			$button[] = '<button type="button" class="btn btn-default fa fa-eye" title="view" id="'.$aRow['pkid'].'" style="margin-bottom:5px;"> View</button>';
			$button[] = '</center>';
		}else{
			$button[] = '<center>';
			$button[] = '<button type="button" class="btn btn-default fa fa-eye" title="view" id="'.$aRow['pkid'].'" style="margin-bottom:5px;"> View</button>';
			$button[] = '</center>';
			if($user_at_access['update']){
				$button[] = '<center>';
				$button[]= '<button type="button" class="btn btn-primary fa fa-edit" title="edit" id="'.$aRow['pkid'].'" style="margin-bottom:5px;"> Edit</button>';
				$button[] = '</center>';
			}
			if($user_at_access['delete']){
				$button[] = '<center>';
				$button[]= '<button type="button" class="btn btn-danger fa fa-remove" title="edit" id="'.$aRow['pkid'].'" style="margin-bottom:5px;"> Cancel</button>';
				$button[] = '</center>';
			}
		}
		$row[] = implode($button);
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );
	
	
	?>