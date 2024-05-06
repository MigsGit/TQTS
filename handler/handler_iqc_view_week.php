<?php 
if(ajaxRequest()){
	if(isset($_POST['action']) ){
		$action = $_POST['action'];
			switch($action){
				case "load_table_week"		            : load_table_week(); break; 
				case "create_week"		            	: create_week(); break; 
				case "f_edit_week"		            	: f_edit_week(); break; 
				case "f_delete_week"		            : f_delete_week(); break;
				case "load_report_list"		            : load_report_list(); break; 
				case "change_default_week"		    	: change_default_week(); break; 
			}
	}
}
function ajaxRequest(){
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function load_table_week(){
	require_once('../class/oop_tqts.php');

	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('*');
	$table 	   		= 'tbl_set_weeks';
	$joins 	   		= '';
	$sql_where 		= "WHERE log = 1";
	$sql_order 		= 'ORDER BY pkid DESC';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$ctr 			= 0;
	while($row = mysqli_fetch_array($result)){
		$return['pkid'][$ctr] 		        = $row['pkid'];
		$return['month'][$ctr] 		        = $row['month'];
		$return['year'][$ctr] 	            = $row['year'];
		$return['status'][$ctr] 	        = $row['status'];
		$return['w1s'][$ctr] 	            = $row['w1s'];
		$return['w1e'][$ctr] 	            = $row['w1e'];
		$return['w2s'][$ctr] 	            = $row['w2s'];
		$return['w2e'][$ctr] 	            = $row['w2e'];
		$return['w3s'][$ctr] 	            = $row['w3s'];
		$return['w3e'][$ctr] 	            = $row['w3e'];
		$return['w4s'][$ctr] 	            = $row['w4s'];
		$return['w4e'][$ctr] 	            = $row['w4e'];
		$return['w5s'][$ctr] 	            = $row['w5s'];
		$return['w5e'][$ctr] 	            = $row['w5e'];
		// $return['w1s'][$ctr] 	            = (date('M d, Y',strtotime($row['w1s'])));
		// $return['w1e'][$ctr] 	            = (date('M d, Y',strtotime($row['w1e'])));
		// $return['w2s'][$ctr] 	            = (date('M d, Y',strtotime($row['w2s'])));
		// $return['w2e'][$ctr] 	            = (date('M d, Y',strtotime($row['w2e'])));
		// $return['w3s'][$ctr] 	            = (date('M d, Y',strtotime($row['w3s'])));
		// $return['w3e'][$ctr] 	            = (date('M d, Y',strtotime($row['w3e'])));
		// $return['w4s'][$ctr] 	            = (date('M d, Y',strtotime($row['w4s'])));
		// $return['w4e'][$ctr] 	            = (date('M d, Y',strtotime($row['w4e'])));
		// $return['w5s'][$ctr] 	            = (date('M d, Y',strtotime($row['w5s'])));
		// $return['w5e'][$ctr] 	            = (date('M d, Y',strtotime($row['w5e'])));
		$ctr++;
	}
	$return['ctr']	  = $ctr;
	echo json_encode($return);
}

function create_week(){
	require_once('../class/oop_tqts.php');

	$date_time_today = date('Y-m-d H:i:s');
	$year = date('Y');
	$return			= $_POST;
	$username		= $return['username'];
	$result			= '';
	$table			= 'tbl_set_weeks';
	$array_fields 	= array('status','month','year','w1s','w1e','w2s','w2e',
							'w3s','w3e','w4s','w4e','w5s','w5e','create_by','username','created_at','updated_at');
	$array_values 	= array('0',$return['month'],$return['year'],$return['w1_start'],$return['w1_end'],
	$return['w2_start'],$return['w2_end'],$return['w3_start'],$return['w3_end'],$return['w4_start'],
	$return['w4_end'],$return['w5_start'],$return['w5_end'],$username,$username,$date_time_today,$date_time_today); 

	$result = TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
	echo json_encode($result);
}

function f_edit_week(){
	require_once('../class/oop_tqts.php');

	$date_time_today = date('Y-m-d H:i:s');
	$return			= $_POST;
	$result			= '';
	$table			= 'tbl_set_weeks';
	$array_fields 	= array(
		'year','month','w1s','w1e','w2s','w2e','w3s','w3e','w4s','w4e',
		'w5s','w5e','updated_at'
	);
	$pkid = $return['id_edit'];
	$array_values 	= array($return['year_edit'],$return['month_edit'],$return['w1s_edit'],
	$return['w1e_edit'],$return['w2s_edit'],$return['w2e_edit'],$return['w3s_edit'],$return['w3e_edit'],
	$return['w4s_edit'],$return['w4e_edit'],$return['w5s_edit'],$return['w5e_edit'],$date_time_today
	); 
	$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	echo json_encode($return);
}

function f_delete_week(){
	require_once('../class/oop_tqts.php');
	
	$return			= $_POST;
	$result			= '';
	$table			= 'tbl_set_weeks';
	$array_fields 	= array('log');
	$array_values 	= array('0'); 
	$pkid = $return['pkid'];
	// $column = 'pkid';
	$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	echo json_encode($return);
}

function load_report_list(){
	require_once('../class/oop_tqts.php');
	
	$return 		= $_POST;
	$result 		= '';
	$array_fields 	= array('*');
	$table 	   		= 'tbl_set_weeks';
	$joins 	   		= '';
	$sql_where 		= "WHERE `log` = '1'";
	$sql_order 		= '';
	$sql_limit 		= '';
	$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$ctr 			= 0;
	
	while($row = mysqli_fetch_array($result)){
		$return['pkid'][$ctr] 		        = $row['pkid'];
		$return['month'][$ctr] 		        = $row['month'];
		$return['year'][$ctr] 	            = $row['year'];
		$return['status'][$ctr] 	        = $row['status'];
		$return['w1s'][$ctr] 	            = $row['w1s'];
		$return['w1e'][$ctr] 	            = $row['w1e'];
		$return['w2s'][$ctr] 	            = $row['w2s'];
		$return['w2e'][$ctr] 	            = $row['w2e'];
		$return['w3s'][$ctr] 	            = $row['w3s'];
		$return['w3e'][$ctr] 	            = $row['w3e'];
		$return['w4s'][$ctr] 	            = $row['w4s'];
		$return['w4e'][$ctr] 	            = $row['w4e'];
		$return['w5s'][$ctr] 	            = $row['w5s'];
		$return['w5e'][$ctr] 	            = $row['w5e'];
		$ctr++;
		
	}
	$return['ctr']	  = $ctr;
	echo json_encode($return);
} 
function change_default_week(){ //Before changing the active weeks, my goal is to change the all status to 0 - Not active, so I call the function set_week_to_default_val()
	set_week_to_default_val();

	$return			= $_POST;
	$result			= '';
	$table		    = 'tbl_set_weeks';
	$array_fields 	= array('status');
	$array_values 	= array('1'); 
	$pkid 	        = $return['week_id'];
	$column 	    = 'pkid'; 
	$result 		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$column);
	echo json_encode($return);

}

function set_week_to_default_val(){ 
	require_once('../class/oop_tqts.php');

	$return			= $_POST;
	$result			= '';
	$table		    = 'tbl_set_weeks';
	$array_fields 	= array('status');
	$array_values 	= array('0'); 
	$pkid 	        = '1';
	$column 	    = 'log'; 
	$result 		= TQTS::getInstance()->update_query_log($table,$array_fields,$array_values,$pkid,$column);
}
