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
				'created_by', 
				'status', 
				'po_number', 
				'customer_name', 
				'defect_phenomenon', 
				'due_date'
				);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	// $array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "tbl_qfr_8d";
	
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
	
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	$sWhere .= " (status='FOR SEND' OR status='CLOSED') AND logdel=0";
	
	$sql_where 	= $_GET['wh'];	
	$username   = $_GET['username'];
	if($sql_where != ""){
		$sWhere 	= $sql_where;
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
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		unset($row);
		$row 		= array();
		$badge 		= '';
		$buttons 	= '';
				
		$btn_dl_link  	= '<button type="button" style="margin-bottom:5px;" class="btn btn-link fa fa-paperclip" value="'.$aRow['pkid'].'"> View Attachment/s</button>';	
		$approver_array = return_8d_approvers_and_revno($aRow['pkid']);			
		$status			= $aRow['status'];
		
		if($status == 'FOR SEND') {
			$badge    = '<span class="badge highlight-color-yellow" >'.$status.'</span>';
			$buttons  = '<button type="button" style="margin-bottom:5px;" class="btn btn-info fa fa-send-o" data-id="'.$aRow['pkid'].'" id="" value="'.$aRow['pkid'].'"> Send & Close</button>';
			$buttons .= '<button type="button" style="margin-bottom:5px;" class="btn btn-primary fa fa-window-restore" data-id="'.$aRow['pkid'].'" id="" value="'.$aRow['pkid'].'"> Close</button>';
		} else if($status == 'CLOSED') {
			$badge 	  = '<span class="badge highlight-color-green" >'.$status.'</span>';
			$buttons  = '<button type="button" style="margin-bottom:5px;" class="btn btn-default fa fa-eye" data-id="'.$aRow['pkid'].'" id="" value="'.$aRow['pkid'].'"> View</button>';
		}
		
		$row[] = $badge;
		$row[] = $aRow['po_number'];
		$row[] = $aRow['customer_name'];
		$row[] = $aRow['defect_phenomenon'];
		$row[] = $aRow['due_date'] == '' ? '-' : date('M d, Y', strtotime($aRow['due_date']));
		$row[] = $btn_dl_link;
		$row[] = $approver_array['rev_no'];
		$row[] = $approver_array['approvers'];
		$row[] = $buttons;
		array_push($output['aaData'],$row);
	}
	
	echo json_encode( $output );
	
	function return_8d_approvers_and_revno($fk8d) {
		require_once('../../class/oop_tqts.php');
		$return = array();
		/* Return latest revision record */
		$array_fields	= array('pkid', 'rev_no');
		$table			= 'tbl_qfr_8d_attachments_initial';
		$joins			= '';
		$sql_where		= 'WHERE `fk8d` = "'.$fk8d.'" AND logdel="0"';
		$sql_order		= 'ORDER BY rev_no DESC';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			$fk8d_attachment_initial 	= $row['pkid'];
			$rev_no 					= $row['rev_no'];
		}
		
		$array_fields = array('(SELECT ra.approver_name FROM tbl_report_approvers ra WHERE ra.approver_username=qfr.approver_username LIMIT 0,1 ) as approver', 'qfr.status','qfr.date_time_sent','qfr.approver_comment');
		$table 	   	= 'tbl_qfr_8d_approvers qfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE qfr.fk8d="'.$fk8d.'" AND fk8d_attachment_initial="'.$fk8d_attachment_initial.'" AND qfr.logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$approvers  = '';
		while($row = mysqli_fetch_array($result)){
			$status				= $row['status'] == '' ? '-'  : $row['status'];
			$date_time_sent 	= $row['date_time_sent'] == '' ? '' : '<i> - '.(date('M d, Y h:i:s A',strtotime($row['date_time_sent']))).'</i>';
			$comment			= $row['approver_comment'];
			$approvers .= $row['approver'].' <b> ['.$status.$date_time_sent.']</b> '.$comment.'<br>';
		}
		$return['approvers'] 		 = $approvers;
		$return['rev_no'] 	 		 = $rev_no;
		$return['fk_attachment'] 	 = $fk8d_attachment_initial;
		return $return;		
	}
	
	?>