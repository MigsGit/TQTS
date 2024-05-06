<?php
    // error_reporting(E_ALL);
	// ini_set('display_errors', 1);
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "PONumber";
       
    /* DB table to use */
    $sTable = "[vw_cn_po_received_tqts]";
     
    /* Database connection information */
    $database_config = '../../db_config/search/ypics_cn_db.php';
	if(!file_exists($database_config)){
		echo "config file does not exist!";
		exit;
	}
	require_once($database_config);
	$gaSql['user']       = $username;
    $gaSql['password']   = $password;
    $gaSql['db']         = $db_name;
    $gaSql['server']     = $server;
     
    /*
    * Columns
    * If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
    * If not this will grab all the columns associated with $sTable
    */
    $aColumns = array(
			'PONumber',
			'DeviceCode',
			'DeviceName',
			'Supplier'
	);
 
 
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
     
    $gaSql['link'] = mssql_connect($gaSql['server'],$gaSql['user'],$gaSql['password']) or die ("can't connect server");
	mssql_select_db($gaSql['db'],$gaSql['link']) or die("can't connect database");
    
     $params = array();
 
       
    /* Ordering */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) ) {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".addslashes( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) {
            $sOrder = "";
        }
    }
       
    /* Filtering */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
	
	// if( isset($_GET['vl']) ){
		// if($sWhere == ""){
			// $sWhere = "WHERE ";
		// }else{
			// $sWhere .= " AND ";
		// }
		// $condition = " ( [PONumber] LIKE '%".$_GET['vl']."%') ";
		// $sWhere .= $condition;
	// }
	$field_name = $_GET['kw'];
	$value 		= $_GET['vl'];
	
	if( $value != '' ){
		if($sWhere == ""){
			$sWhere = "WHERE ";
		}else{
			$sWhere .= " AND ";
		}
		// $condition = " ( [PONumber] LIKE '%".$_GET['vl']."%') ";
		$condition = " ( [".$field_name."] LIKE '%".$value."%') ";
		$sWhere .= $condition;
	}
	
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )  {
            if ( $sWhere == "" ) {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
        }
    }
	
    /* 
	* Paging
	*/
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
	$sLimit = "AND id BETWEEN ".intval( $_GET['iDisplayStart'] )." AND ".
	intval( $_GET['iDisplayLength'] );
	}

    /*
	* SQL queries
	* Get data to display
	*/
	$sQuery = "
	SELECT * 
	FROM $sTable
	$sWhere
	$sOrder
	$sLimit
	";
	
	$rResult = mssql_query( $sQuery, $gaSql['link'] ) or die(mssql_get_last_message());

    $sQueryCnt = "SELECT * FROM $sTable $sWhere";
    
    $rResultTotal = mssql_query( $sQueryCnt, $gaSql['link'] ) or die(mssql_get_last_message());

    // $iFilteredTotal = mssql_num_rows( $rResultTotal ) or die(mssql_get_last_message());
    $iFilteredTotal = mssql_num_rows( $rResultTotal );
  	

    $sQuery = " SELECT * FROM $sTable ";
    $rResultTotal = mssql_query( $sQuery, $gaSql['link'] ) or die(mssql_get_last_message());
    $iTotal = mssql_num_rows( $rResultTotal ) or die(mssql_get_last_message());
      
	  
    $output = array(
        // "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
	
    while ( $aRow = mssql_fetch_array( $rResult ) ) {
        $row = array();
        
        $row[] = check_utf8( $aRow['PONumber'] );
        $row[] = check_utf8( $aRow['DeviceCode'] );
        $row[] = check_utf8( $aRow['DeviceName'] );
        $row[] = '<a href="#" title="get from SEIKO QC Database"><i class="fa fa-plus"></i> View Result</a>';
        $row[] = 'Pending';
        $row[] = 'Pending';
        $row[] = 'Pending';
        $row[] = '<a href="#"><i class="fa fa-paperclip"></i> See Attachments <span class="badge">5</span></a>';
        $row[] = 'N/A';
        If (!empty($row)) { $output['aaData'][] = $row; }
    }   
    
	echo json_encode( $output );

     function check_utf8($string){
        $converted_string = mb_check_encoding($string, 'UTF-8') ? $string : utf8_encode($string);
        return $converted_string;
    }
?>