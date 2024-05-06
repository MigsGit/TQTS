<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {		
				/* IPQC Pre-production Start */
				case "pp_return_visual_inspection_fields" 				: pp_return_visual_inspection_fields(); break; 
				case "pp_advance_search" 								: pp_advance_search(); break; 
				case "pp_save_new_measurement_inspection" 				: pp_save_new_measurement_inspection(); break; 
				case "pp_get_machine_inspection_record_by_pkid" 		: pp_get_machine_inspection_record_by_pkid(); break; 
				case "pp_update_inspection_result" 						: pp_update_inspection_result(); break;  
				case "pp_return_judgment" 								: pp_return_judgment(); break;  
				case "pp_update_details" 								: pp_update_details(); break;  
				case "pp_return_machine_list" 							: pp_return_machine_list(); break;  
				case "pp_delte_data" 									: pp_delte_data(); break;  
				
				
				/* IPQC Pre-production End */
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* IPQC Pre-production Start */
	function pp_return_visual_inspection_fields() {
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="measurescope_no">Measurescope Number</option>'; $ctr++;
		$option[$ctr] = '<option value="meas_year_month">Month - Year</option>'; $ctr++;
		$option[$ctr] = '<option value="measurescope_file">Measurescope File</option>'; $ctr++;
		
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	// pp_advance_search();
	function pp_advance_search() {
		require_once('../class/oop_tqts.php');
		$field_name	= array();
		$condition	= array();
		$value		= array();
		$field_name = $_POST['field_name'];
		$condition 	= $_POST['condition'];
		$value	 	= $_POST['val'];
		
		$sql_where		= '';
		$sql_where_and	= array();
		$sql_where_or	= array();
		foreach($field_name as $key => $fieldn) {
			if($condition[$key] == "EQUALS") {
				$sql_where_and[] = ' ('.$fieldn.'="'.$value[$key].'")';
			} else if($condition[$key] == "LIKE") {
				$sql_where_or[] = ' ('.$fieldn.' LIKE "%'.$value[$key].'%")';
			} else if($condition[$key] == "BETWEEN"){
				$date_range = explode(' - ', $value[$key]);
				$date_start = date('Y-m-',strtotime($date_range[0]));
				$date_end 	= date('Y-m-',strtotime($date_range[1]));
				/* Set to first day of the month since search field only selects year and month */
				$sql_where_and[] = ' ('.$fieldn.' BETWEEN "'.$date_start.'-01" AND "'.$date_end.'-01")';
			}
		}
		$sql_where_and = implode(' AND', $sql_where_and);
		$sql_where_or = implode(' OR', $sql_where_or);
		if($sql_where_and != '' && $sql_where_or != '') {
			$sql_where		= 'WHERE (logdel=0) AND '.$sql_where_and.' AND '.$sql_where_or;
		} else if($sql_where_and != '' && $sql_where_or == '') {
			$sql_where		= 'WHERE (logdel=0) AND '.$sql_where_and;
		} else if($sql_where_and == '' && $sql_where_or != '') {
			$sql_where		= 'WHERE (logdel=0) AND '.$sql_where_or;
		}
		
		$result['sql_where'] = $sql_where;
		echo json_encode($result);
	}
	
	function pp_save_new_measurement_inspection() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$temp_file			= $_FILES['measurescope_file']['tmp_name'];
		$file_name			= $_FILES['measurescope_file']['name'];
		$file 				= return_file_path_by_div_mod('ipqc_preproduction');
		$ext 				= pathinfo($file_name, PATHINFO_EXTENSION);
		$fkfile_path		= $file['pkid'];
		$script				= '';
		$return['rec']	= check_record_exists_main($_POST['measurescope_no'], $_POST['meas_year_month']);
		if(check_record_exists_main($_POST['measurescope_no'], $_POST['meas_year_month']) == 'Record already exists!') {
			$return['msg']	= 'Record already exists!';
		} else {
			/* Fetch selected checked by  */
			$checked_by = implode(',',$_POST['checked_by']);
			
			/* Fetch selected approved by */
			$approved_by 			= implode(',',$_POST['approved_by']);
			$return['checked_by'] 	= $checked_by;
			$return['approved_by'] 	= $approved_by;
			
			/* Save record to main table */
			$table 				= "tbl_ipqc_pre_production";
			$field_data			= get_fields_values($_POST, array("action","checked_by","approved_by","machine"));
			$array_fields		= $field_data['array_fields']; 	$array_values   = $field_data['array_values'];
			$array_fields[]		= 'date_time_created'; 			$array_values[] = $date_time_today;
			$array_fields[]		= 'created_by'; 				$array_values[] = $_POST['username'];
			$array_fields[]		= 'fkmachine '; 				$array_values[] = $_POST['machine'];
			$array_fields[]		= 'measurescope_file '; 		$array_values[] = $file_name;
			$array_fields[]		= 'fkfile_path'; 				$array_values[] = $fkfile_path;
			$array_fields[]		= 'checked_by'; 				$array_values[] = $checked_by;
			$array_fields[]		= 'approved_by'; 				$array_values[] = $approved_by;
			$array_fields[]		= 'lastupdate'; 				$array_values[] = $date_time_today;
			$pkid				= TQTS::getInstance()->insert_query_id($table, $array_fields, $array_values);
			$script				= TQTS::getInstance()->insert_query_script($table, $array_fields, $array_values);
			/* Save file */
			$target_file		= $file['path'].$pkid.'.'.$ext;
			if(move_uploaded_file($temp_file,$target_file)) {
				$return['msg']	= "New record has been saved";
			} else {
				$return['msg']	= 'There was an error on uploading the file.';
			}
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
		
	function pp_get_machine_inspection_record_by_pkid() {
		require_once('../class/oop_tqts.php');
		$pkid			= $_POST['pkid'];
		$array_fields 	= array('fkmachine','measurescope_no', 'meas_year_month', 'measurescope_file', 'checked_by', 'date_time_checked', 'approved_by', 'date_time_approved');
		$table			= "tbl_ipqc_pre_production";
		$joins			= "";
		$sql_where		= "WHERE pkid='".$pkid."' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,1";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){

			$return['fkmachine'] 			= $row['fkmachine'];
			$return['measurescope_no'] 		= $row['measurescope_no'];
			$return['meas_year_month'] 		= $row['meas_year_month'];
			$return['measurescope_file'] 	= $row['measurescope_file'];
			$return['date_time_checked'] 	= $row['date_time_checked'];
			$return['date_time_approved'] 	= $row['date_time_approved'];
			
			$array_checked_by = explode(",",$row['checked_by']);
			$row['checked_by'] = array();
			foreach($array_checked_by as $key => $value){
				$array_data_chk 				= array();
				$array_data_chk['id'] 			= $value;
				$array_data_chk['text'] 		= get_emp_name_by_username_systemone($value);
				$return['checked_by'][]			= $array_data_chk;
			}
			$array_approved_by = explode(",",$row['approved_by']);
			$row['approved_by'] = array();
			foreach($array_approved_by as $key => $value){
				$array_data_app 				= array();
				$array_data_app['id'] 			= $value;
				$array_data_app['text'] 		= get_emp_name_by_username_systemone($value);
				$return['approved_by'][]			= $array_data_app;
			}
		}
		echo json_encode($return);
	}
	
	function pp_update_inspection_result(){
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$msg				= '';		
		/* Fetch selected checked by  */
		$checked_by = implode(',',$_POST['checked_by']);
		
		/* Fetch selected approved by */
		$approved_by 			= implode(',',$_POST['approved_by']);
		$return['checked_by'] 	= $checked_by;
		$return['approved_by'] 	= $approved_by;
		$file 				= return_file_path_by_div_mod('ipqc_preproduction');
		
		$table 				= "tbl_ipqc_pre_production";
		$field_data			= get_fields_values($_POST, array("action","checked_by","approved_by","machine"));
		$array_fields		= $field_data['array_fields']; 	$array_values   = $field_data['array_values'];
		$array_fields[]		= 'checked_by'; 				$array_values[] = $checked_by;
		$array_fields[]		= 'approved_by'; 				$array_values[] = $approved_by;
		$array_fields[]		= 'fkmachine'; 					$array_values[] = $_POST['machine'];
		$array_fields[]		= 'lastupdate'; 				$array_values[] = $date_time_today;
		
		/** Check if the file existed, then deleted it into the folder */
		$current_file = $file['path'].$_POST['pkid'].'.xls' ;
		$current_file_x = $file['path'].$_POST['pkid'].'.xlsx';
		$current_files_y = $file['path'].$_POST['pkid'].'.XLSX';
		if(file_exists($current_file) ){
			$is_exist_files = $current_file;
		}else if(file_exists($current_file_x)){
			$is_exist_files = $current_file_x;
		}else{
			$is_exist_files = $current_files_y;
		}
		$is_exist_files;
		
		/* Check if file is for update */
		
		if(isset($_FILES['measurescope_file']['tmp_name'])) {
			unlink($is_exist_files);
			$temp_file			= $_FILES['measurescope_file']['tmp_name'];
			$file_name			= $_FILES['measurescope_file']['name'];
			$ext 				= pathinfo($file_name, PATHINFO_EXTENSION);
			$target_file		= $file['path'].$_POST['pkid'].'.'.$ext;
			$fkfile_path		= $file['pkid'];
			
			/* Save file */
			if(move_uploaded_file($temp_file,$target_file)) {
				$msg			= "<br>File was successfully updated.";
			} else {
				$msg			= '<br>There was an error on uploading the file.';
			}
			/* Include file name and path on for update */
			$array_fields[]		= 'measurescope_file'; 		$array_values[] = $file_name;
			$array_fields[]		= 'fkfile_path'; 				$array_values[] = $fkfile_path;			
		}
		$result 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$_POST['pkid']);
		$script 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$_POST['pkid']);
		$return['msg']		= $result.$msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function get_pre_production_condition() {
		require_once('../class/oop_tqts.php');
		$between_condi	= array();
		$array_fields 	= array('between_min', 'between_max');
		$table			= "tbl_ipqc_pre_production_condition";
		$joins			= "";
		$sql_where		= "WHERE logdel = '0'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,1";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$between_condi['between_min'] 		= $row['between_min'];
			$between_condi['between_max'] 		= $row['between_max'];
		}
		return $between_condi;
	}
	
	function check_record_exists_main($measurescope_no, $meas_year_month) {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('pkid');
		$table			= "tbl_ipqc_pre_production";
		$joins			= "";
		$sql_where		= "WHERE measurescope_no='".$measurescope_no."' AND meas_year_month='".$meas_year_month."' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,1";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 1){
			return 'Record already exists!';
		} else {
			return 'No record found.';
		}
	}
	
	function check_record_exists_details($fkpp, $date_inspection) {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('pkid');
		$table			= "tbl_ipqc_pre_production_details";
		$joins			= "";
		$sql_where		= "WHERE fkpp='".$fkpp."' AND date_inspection='".$date_inspection."' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,1";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 1){
			return 'Record already exists!';
		} else {
			return 'No record found.';
		}
	}
	
	function pp_return_judgment() {
		$data_x_axis		= $_POST['x_data'];
		$data_y_axis		= $_POST['y_data'];
		
		$between_condi		= get_pre_production_condition();
		$remarks 			= 'PASSED';
		
		if($data_x_axis < $between_condi['between_min'] || $data_x_axis > $between_condi['between_max']) {
			$remarks		= '<font color="red">FAILED</font>';
		} 
		if($data_y_axis < $between_condi['between_min'] || $data_y_axis > $between_condi['between_max']) {
			$remarks		= '<font color="red">FAILED</font>';
		}
		$result['remarks'] = $remarks;
		echo json_encode($result);
	}
	
	function pp_update_details() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		
		$table 				= "tbl_ipqc_pre_production_details";
		$field_data			= get_fields_values($_POST, array("action","pkid"));
		$array_fields		= $field_data['array_fields']; 	$array_values   = $field_data['array_values'];
		$array_fields[]		= 'lastupdate'; 				$array_values[] = $date_time_today;
		$result['msg']		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$_POST['pkid']);
		$result['script']	= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$_POST['pkid']);
		echo json_encode($result);
	}
	
	function pp_return_machine_list() {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('pkid','machine');
		$table			= "tbl_ipqc_pre_production_machine_list";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$html_select	= '<option value="" selected disabled>-Select Machine-</option>';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$html_select 	.= '<option value="'.$row['pkid'].'">'.$row['machine'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}

	function pp_delte_data(){
		require_once('../class/oop_tqts.php');
		$return		  = $_POST;
		$table 		  = 'tbl_ipqc_pre_production';
		$pkid         = $return['pkid'];
		$array_fields = array('remarks','logdel');
		$array_values =array($return['cancel_remarks'],1);
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	
		echo json_encode($array_values);
	}
	
	// function remove_lqc_monitoring(){
	// 	require_once('../class/oop_tqts.php');
	
	// 	$return                 = $_POST;
	
	// 	$table = 'tbl_ipqc_lqc_monitoring';
	// 	$pkid                   = $return['pkid'];
	// 	$array_fields = array('remarks','logdel');
	// 	$array_values =array($return['deleted_remarks'],1);
	// 	$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	
	// 	echo json_encode($return);
	// }
	/* IPQC Pre-production End */
	?>