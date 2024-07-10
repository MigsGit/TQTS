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
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
    
	$aColumns = array( 
		'id', 
		'oqc_lon_id', 
		'oqc_capa_action', 
		'oqc_capa_action_incharge', 
		'oqc_capa_due_date', 
		'oqc_capa_status', 
		'oqc_capa_req_sub_date', 
		'oqc_capa_actual_sub_date', 
		'oqc_capa_remarks', 
	);
	/* used this field for searching data typed in the search box */

	$array_search = array(
		'oqc_lon_id', 
		'oqc_capa_action', 
		'oqc_capa_action_incharge', 
		'oqc_capa_due_date', 
		'oqc_capa_status', 
		'oqc_capa_req_sub_date', 
		'oqc_capa_actual_sub_date', 
		'oqc_capa_remarks', 
	);
	$sJoin = "";
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id";
	/* DB table to use */
	$sTable = "tbl_oqc_lon_capa_monitoring";
	$database_config = '../../db_config/config_tqts.php';
	if(!file_exists($database_config)){
		echo "config file does not exist!";
		exit;
	} else {
		require_once($database_config);
	}
	require_once("../../handler/common_function.php");

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
	Ordering/Sorting
    aColumns is array of column a DB
*/
    $sOrder = '';
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY ";
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
		// $sOrder = "ORDER BY masterlist.id ASC";
		$sOrder = "ORDER BY id ASC";
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
		// $sWhere .= ')'; 
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($array_search) ; $i++ )
		{
			$sWhere .= $array_search[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}

    /* The number of UI column is required to be equal to table column
        Ex. 5 db table column == 5 UI column. Uncomment the script below to show.
        echo json_encode($aColumns);
        return;
    */

	/* Individual column filtering */
	for ( $i=0 ; $i<count($array_search) ; $i++ )
	{
		//NOTE: $_GET['bSearchable_'.$i] accept only based on  $array_search
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
			$sWhere .= $array_search[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			
		}
	}
	
	/* 
		dito ka mag add ng where mo, una check mo kung may laman na yung $sWhere pag wala append mo yung where mo na meron
		kasama where kapag naman may laman na AND na syempre diba :)
	*/

	$username   = $_GET['username'];
	
	if($sWhere == ""){
		$sWhere .= "WHERE  1=1";
	}else{
		$sWhere .= "AND 1=1";
	}
	
	if(check_has_supervisor_access($username)) {	
		$sWhere .= " AND logdel=0";
	} else {
		$sWhere .= " AND logdel=0 AND created_by='".$username."'";		
		$sWhere .= " AND oqc_lon_id = '".$_GET['oqc_lon_id']."'";		
	}
	
	if($sOrder == ""){
		$sOrder = 'ORDER BY id DESC';
	}
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$script = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sJoin
		$sWhere
		$sOrder
		$sLimit
	";
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sJoin
		$sWhere
		$sOrder
		$sLimit
	";
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
		"aaData" => array(),
		"script" => $script,
	);

	
	while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$row = array();
		unset($row);
		$button = '<center><button btn-type="view" tbl-oqc-lon-capa-monitoring-id ="'.$aRow['id'].'"  id="btnViewDocReviewDisposition" class="btn btn-sm btn-info fa fa-edit" type="button"> Edit</button></center>';
		switch ($aRow['oqc_capa_status']) {
			case 'Open':
				$status = '<span class="badge highlight-color-lime">Open</span>';
				break;
			case 'Closed':
				$status = '<span class="badge highlight-color-green">Closed</span>';
				break;
			default:
				$status = '<span class="badge highlight-color-red">Unknown Status</span>';
				break;
		}
		
		$row[] = $button;
		$row[] = $status;
		$row[] = $aRow['oqc_capa_action'];
		$row[] = get_in_charge_by_username($aRow['oqc_capa_action_incharge']);
		$row[] = $aRow['oqc_capa_due_date'];
		$row[] = $aRow['oqc_capa_req_sub_date'];
		$row[] = $aRow['oqc_capa_actual_sub_date'];
		$row[] = $aRow['oqc_capa_remarks'];
		
		array_push($output['aaData'],$row);
	}
	echo json_encode( $output );

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
	function get_in_charge_by_username ($username){
		$oqc_capa_action_incharge = explode(',',$username);
		foreach ($oqc_capa_action_incharge as $key => $value) {
			$arr_oqc_capa_action_incharge[]		= get_emp_name_by_username_systemone($value);
		}
		return $arr_oqc_capa_action_incharge = implode(',',$arr_oqc_capa_action_incharge);
		
	}
	
?>
