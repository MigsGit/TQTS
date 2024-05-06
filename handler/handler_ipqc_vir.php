<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {		
				/* IPQC Visual Inspection Functions Start */
				case "vir_return_visual_inspection_fields" 			: vir_return_visual_inspection_fields(); break; 
				case "vir_advance_search" 							: vir_advance_search(); break; 
				case "save_vir_new_monitoring" 						: save_vir_new_monitoring(); break; 
				case "get_ipqc_vir_details_by_pkid" 				: get_ipqc_vir_details_by_pkid(); break; 
				case "edit_vir_monitoring" 							: edit_vir_monitoring(); break; 
				case "return_current_workweek" 						: return_current_workweek(); break; 
				case "return_current_fiscal_year" 					: return_current_fiscal_year(); break; 
				case "vir_delete_info" 								: vir_delete_info(); break; 
				
				
				
				
				case "get_ipqc_monitoring_time" 					: get_ipqc_monitoring_time(); break; 
				/* IPQC Visual Inspection Functions End */
				
				/* IPQC Common Functions Start */
				// case "get_emp_list_by_section" 						: get_emp_list_by_section(); break; 
				case "get_empname_by_username" 						: get_empname_by_username(); break; 
				case "get_operators_name" 							: get_operators_name(); break; 
				/* IPQC Common Functions Start */
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* IPQC Visual Inspection Functions Start */
	
	function vir_return_visual_inspection_fields() {
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="line_number">Line Number</option>'; $ctr++;
		$option[$ctr] = '<option value="station">Station</option>'; $ctr++;
		$option[$ctr] = '<option value="fiscal_year">Fiscal Year</option>'; $ctr++;
		$option[$ctr] = '<option value="workweek">Workweek</option>'; $ctr++;
		$option[$ctr] = '<option value="shift">Shift</option>'; $ctr++;
		
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	function vir_advance_search() {
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
	
	function save_vir_new_monitoring() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_ipqc_visual_inspection";
		$values 					= get_fields_values($_POST,array("action","username"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);

		/* Upload attachment */
		if($_FILES["monitoring_file"]["tmp_name"] != '') {
			$file  		     	= return_file_path_by_div_mod('ipqc_visual');
			$fkfile_path     	= $file['pkid'];
			$target_dir      	= $file['path'];
			$temp_file 	     	= $_FILES["monitoring_file"]["tmp_name"];
			$file_name 	     	= $_FILES["monitoring_file"]["name"];
			$target_file 	 	= $target_dir . $file_name;	
			if (file_exists($target_file)) {
				$msg 					= "Sorry, your file already exists.";
				$return['error']		= $msg;
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {	
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg .= '<br>File was successfully uploaded to the system';
					} else {
						$msg .= '<br>There was an error on renaming the file.';
					}	
					
					$array_fields 				= array("monitoring_file", "fkfile_path");
					$array_values 				= array($file_name, $fkfile_path);
					$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 				.= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}				
			}
		}
		
		$return['msg'] 	= 'New record has been saved';
		echo json_encode($return);
	}
	
	function get_ipqc_vir_details_by_pkid() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$table  						= "tbl_ipqc_visual_inspection";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){
			$array_inspector = explode(",",$row['inspected_by']);
			$row['inspected_by'] = array();
			foreach($array_inspector as $key => $value){
				$array_data_ins 				= array();
				$array_data_ins['id'] 			= $value;
				$array_data_ins['text'] 		= get_emp_name_by_username_systemone($value);
				$row['inspected_by'][]			= $array_data_ins;
			}
			$array_checked_by = explode(",",$row['checked_by']);
			$row['checked_by'] 	= array();
			foreach($array_checked_by as $key => $value){
				$array_data_chk 				= array();
				$array_data_chk['id'] 			= $value;
				$array_data_chk['text'] 		= get_emp_name_by_username_systemone($value);
				$row['checked_by'][]			= $array_data_chk;
			}
			$return['data'] = $row;
		}	
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function edit_vir_monitoring() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$pkid    		 = $_POST['pkid'];
		$username    	 = $_POST['username'];
		$msg			 = '';		
		$file  		     	= return_file_path_by_div_mod('ipqc_visual');

		
		/* Get all fields to be inserted */		
		$table 						= "tbl_ipqc_visual_inspection";
		$values 					= get_fields_values($_POST,array("action","username"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values, $pkid);
		$script 					= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values, $pkid);

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
		/* Upload attachment */
		if($_FILES["monitoring_file"]["tmp_name"] == '' ||  !isset($_FILES["monitoring_file"]["tmp_name"]) ) {
			$msg .= 'Record has been updated';
		}else{
			unlink($is_exist_files);
			$fkfile_path     	= $file['pkid'];
			$target_dir      	= $file['path'];
			$temp_file 	     	= $_FILES["monitoring_file"]["tmp_name"];
			$file_name 	     	= $_FILES["monitoring_file"]["name"];
			$target_file 	 	= $target_dir . $file_name;	
			if (file_exists($target_file)) {
				$msg 					= "Sorry, your file already exists.";
				$return['error']		= $msg;
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {	
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg .= '<br>File was successfully uploaded to the system';
					} else {
						$msg .= '<br>There was an error on renaming the file.';
					}	
					
					$array_fields 				= array("monitoring_file", "fkfile_path");
					$array_values 				= array($file_name, $fkfile_path);
					$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 				.= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}				
			}
		}
		
		$return['msg'] 	= $msg;
		echo json_encode($return);
	}
	
	
	function return_current_workweek() {
		$start 	= strtotime( (date('m') < 4 ? date('Y', strtotime(date('Y').' -1 year')) : date('Y')) .'-04-01' );
		$end   	= strtotime( date('Y-m-d') );
		
		$iter 	= 24*60*60; // whole day in seconds
		$ww 	= 0; // keep a count of Sats & Suns

		for($i = $start; $i <= $end; $i=$i+$iter)
		{
			if(Date('D',$i) == 'Sat')
			{
				$ww++;
			} 
		}
		if(Date('D',$end) != 'Sat')
		{
			$ww++;
		} 
		$return['ww'] = $ww;
		echo json_encode($return);
	}
	
	function return_current_fiscal_year() {
		$fiscal_year 	= strtotime( (date('m') < 4 ? date('Y', strtotime(date('Y').' -1 year')) : date('Y')) );
		$fiscal_year	= 'FY'.date('Y', $fiscal_year);
		// return $fiscal_year;
		$return['fy'] = $fiscal_year;
		echo json_encode($return);
	}
	
	
	/* IPQC Visual Inspection Functions End */
	
	/* IPQC Common Functions Start */
	
	
	function get_empname_by_username() {
		require_once('../class/oop_tqts.php');
		$username		 =  $_POST['user'];
		$array_fields 	 = array('emp_name');
		$table 	   		 = 'vw_user_roles';
		$joins 	   		 = '';
		$sql_where 		 = 'WHERE user="'.$username.'"';
		$sql_order 		 = '';
		$sql_limit 		 = '';
		$result 		 = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			return $row['emp_name'];
		} else {
			return 'N/A';
		}
	}
	function vir_delete_info(){
		require_once('../class/oop_tqts.php');
		
		$return		  = $_POST;
		$table 		  = 'tbl_ipqc_visual_inspection';
		$pkid         = $return['pkid'];
		$array_fields = array('logdel');
		$array_values =array(1);
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	
		echo json_encode($array_values);
	}
	// function pp_delte_data(){
	// 	require_once('../class/oop_tqts.php');
	// 	$return		  = $_POST;
	// 	$table 		  = 'tbl_ipqc_pre_production';
	// 	$pkid         = $return['pkid'];
	// 	$array_fields = array('remarks','logdel');
	// 	$array_values =array($return['cancel_remarks'],1);
	// 	$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	
	// 	echo json_encode($array_values);
	// }
	/* IPQC Common Functions End */
	?>