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
						'`ptis`.`regDate`',
						'`ptis`.`ptisNo`',
						'`ptis`.`family`',
						'`po`.`deviceName`',
						'`po`.`poNumber`',
						'`po`.`poQty`',
						'`po`.`shipDate`',
						'`problem`.`problemType`',
						'`ptis`.`judgementPMI`',
						'`ptis`.`approval1`',
						'`ptis`.`judgementYEC`',
						'`problem`.`problemType`',
						'`ptis`.`incharge`',
						'`problem`.`problemValue`',
						'`problem`.`std_specs_min`',
						'`problem`.`std_specs_max`',
						'`ptis`.`pkid_ptisNo`'
					  );
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "`ptis`.`pkid_ptisNo`";
	
	/* DB table to use */
	$sTable = "tbl_ptisInfo `ptis` 
					INNER JOIN
			   tbl_problemType `problem` ON `problem`.`fkid_pkid_ptisNo` = `ptis`.`pkid_ptisNo` 
					INNER JOIN
			   tbl_poInfo `po` ON `po`.`poNumber` = `ptis`.`pkid_poNo` 
					INNER JOIN
			   tbl_uploads `uploads` ON `uploads`.`fkid_pkid_ptisNo` = `ptis`.`pkid_ptisNo`";
	
	$database_config = '../../db_config/config_ptis.php';
	
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
	
	// if($sOrder == ""){
		// $sOrder = " ORDER BY test DESC ";
	// }
	
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
	
	// if($sWhere == ""){
		// $sWhere .= " WHERE  ";
	// }else{
		// $sWhere .= " AND ";
	// }
	
	// $sql_where   = $_GET['wh'];
	// if(isset($_GET['wh']) && $_GET['wh'] != ''){
		// $sWhere 	.= str_replace("WHERE","",$_GET['wh']);
	// }

	// if($sWhere == "WHERE  "){
		// $sWhere = "";
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
		$row[] = $aRow['regDate'];
		$row[] = $aRow['ptisNo'];
		$row[] = $aRow['family'];
		$row[] = $aRow['deviceName'];
		$row[] = $aRow['poNumber'];
		$row[] = $aRow['poQty'];
		$row[] = $aRow['shipDate'];
		$row[] = $aRow['problemType'];
		$row[] = $aRow['judgementPMI'];
		$row[] = $aRow['approval1'];
		$row[] = $aRow['judgementYEC'];		
		$row[] = $aRow['problemType']."=".$aRow['problemValue'].";STD.SPECS:".$aRow['std_specs_min']."~".$aRow['std_specs_max']; 
		$row[] = $aRow['incharge'];		
		// $row[] = '<a href="../../WebPTIS/pages/attachments/QFN/NP506-040-SCG 4501965066 P01 SOCKET DATA.xls"><span class="fa fa-download"> Download File</a>';
		// if(file_exists("../../WebPTIS/pages/".($aRow['file_path']))){
			// $row[] = '<a href="../../WebPTIS/pages/'.$aRow['file_path'].'"><span class="fa fa-download"> Download File</a>';
		// }else{
			// $row[] = "../../WebPTIS/pages/".$aRow['file_path'];
		// }
		$row[] = '<a href="pages/qfr/dl_ptis.php?id='.$aRow['pkid_ptisNo'].'"><span class="fa fa-download"> Download File</a>';
		// $row[] 	= $aRow['pkid_ptisNo'];
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );
	
	
	?>