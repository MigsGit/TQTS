<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {	
				case "return_qad_incharge_by_section"			: return_qad_incharge_by_section(); break;
				case "get_8d_po_list"							: get_8d_po_list(); break;
				case "save_capa_report"							: save_capa_report(); break;
				case "save_correction"							: save_correction(); break;
				case "save_monitoring_validation"				: save_monitoring_validation(); break;
				case "save_qs_check_supervisor_log"				: save_qs_check_supervisor_log(); break;
				case "save_qs_conformance_log"					: save_qs_conformance_log(); break;
				case "save_qs_supervisor_post_log"				: save_qs_supervisor_post_log(); break;
				case "save_qc_supervisor_post_log"				: save_qc_supervisor_post_log(); break;
				case "update_3rd_validation_status"				: update_3rd_validation_status(); break;
				case "get_monitoring_date_minimum" 				: get_monitoring_date_minimum(); break;
				case "get_capa_main_details" 					: get_capa_main_details(); break;
				case "get_capa_1st_monitoring_details" 			: get_capa_1st_monitoring_details(); break;
				case "get_capa_2nd_validation_details" 			: get_capa_2nd_validation_details(); break;
				case "get_capa_3rd_validation_details" 			: get_capa_3rd_validation_details(); break;
				case "check_capa_classification" 				: check_capa_classification(); break;
				case "check_capa_2nd_monitoring" 				: check_capa_2nd_monitoring(); break;
				case "get_capa_correction_details" 				: get_capa_correction_details(); break;
				case "update_correction_details" 				: update_correction_details(); break;
				case "update_monitoring_details" 				: update_monitoring_details(); break;
				case "return_editable_monitoring" 				: return_editable_monitoring(); break;
				case "return_monitoring_data_by_field" 			: return_monitoring_data_by_field(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function return_qad_incharge_by_section() {
		require_once('../class/oop_tqts.php');
		$section	= $_POST['section'];
		$array_fields = array('assigned_staffs');
		$table 	   	= 'tbl_qfr_capa_qad_settings';
		$joins 	   	= '';
		$sql_where 	= 'WHERE section="'.$section.'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$array_assigned_qad 	= explode(',',$row['assigned_staffs']);
			$row['assigned_staffs'] = array();
			foreach($array_assigned_qad as $key => $value){
				$array_assigned_qad 			= array();
				$array_assigned_qad['id'] 		= $value;
				$array_assigned_qad['text'] 	= get_emp_name_by_username_systemone($value);
				$return['assigned_staffs'][]	= $array_assigned_qad;
			}
		}
		// $return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_8d_po_list(){
		require_once('../class/oop_tqts.php');
		$pattern	= $_POST['pattern'];
		$array_fields = array('po_number');
		$table 	   	= 'tbl_qfr_8d';
		$joins 	   	= '';
		$sql_where 	= 'WHERE po_number LIKE "%'.$pattern.'%" AND status="CLOSED" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,10';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select = '<option></option>';
		while($row = mysqli_fetch_array($result)){
			$html_select .= '<option value="'.$row['po_number'].'">'.$row['po_number'].'</option>';
		}
		$return['html_select'] = $html_select;
		// $return['script'] = $script;
		echo json_encode($return);
	}
	
	function save_capa_report(){
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$file  		     = return_file_path_by_div_mod('qfr_capa_main');
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];
		$temp_file 	     = $_FILES["file_capa_attachment"]["tmp_name"];
		$file_name 	     = $_FILES["file_capa_attachment"]["name"];
		$target_file 	 = $target_dir . $file_name;
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_qfr_capa_main";
		$values 					= get_fields_values($_POST,array("action","username","qc_qad_manager","qad_auditor","conformance","file_name","fkfile_path"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "file_name"; 			$array_values[] = $file_name;
		$array_fields[] 			= "fkfile_path"; 		$array_values[] = $fkfile_path;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = $date_time_today;
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "lastupdate"; 		$array_values[] = $date_time_today;
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		
		/* Upload file attachment first */	
		if (file_exists($target_file)) {
			$msg 					= "Sorry, your file already exists.";
			$return['error']		= $msg;
		} else {
			if (move_uploaded_file($temp_file, $target_file)) {
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$new_file_name  = $pkid.".".$ext;
				if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
					$msg .= 'File was successfully uploaded to the system';
				} else {
					$msg .= 'There was an error on renaming the file.';
				}					
			} else {
				$msg .= "Sorry, there was an error uploading your file.".$file_name;
			}
		}
		$return['_POST']				= $_POST;
		$return['_FILES']				= $_FILES;
		$return['pkid']				= $pkid;
		$return['script']			= $script;
		echo json_encode($return);
	}
	
	function save_correction(){
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$file  		     = return_file_path_by_div_mod('qfr_capa_qs_monitoring');
		$fkfile_path     = $file['pkid'];
		$pkid    		 = $_POST['pkid'];
		$monitoring_type 	= explode(',',implode(',',$_POST['monitoring_type']));
		$correction_action 	= explode(',',implode(',',$_POST['correction_action']));
		$incharge_person 	= explode(';',implode(';',$_POST['incharge_person']));
		$due_date 			= explode(',',implode(',',$_POST['due_date']));
		$msg			 	= '';		
		$script			 	= '';		
		
		/* Get all fields to be inserted */		
		$table_correction	= "tbl_qfr_capa_correction";
		$table_monitoring	= "tbl_qfr_capa_1st_monitoring";
		for($i=0; $i<count($monitoring_type); $i++) {
			$array_fields 				= array('date_time_created', 'created_by', 'fk_capa', 'monitoring_type', 'correction_action', 'incharge_person', 'due_date', 'lastupdate', 'username');
			$array_values 				= array($date_time_today, $username, $pkid, $monitoring_type[$i], $correction_action[$i], $incharge_person[$i], $due_date[$i], $date_time_today, $username);
			$fk_capa_correction			= TQTS::getInstance()->insert_query_id($table_correction,$array_fields,$array_values);
			$script 				   .= TQTS::getInstance()->insert_query_script($table_correction,$array_fields,$array_values);	
			
			/* Insert monitoring */
			$array_fields 				= array('date_time_created', 'created_by', 'fk_capa', 'fkfile_path', 'fk_capa_correction', '`order`', 'qs_status', 'lastupdate', 'username');
			$array_values 				= array($date_time_today, $username, $pkid, $fkfile_path, $fk_capa_correction, 1, 'OPEN', $date_time_today, $username);
			$result						= TQTS::getInstance()->insert_query($table_monitoring,$array_fields,$array_values);
			$script 				   .= TQTS::getInstance()->insert_query_script($table_monitoring,$array_fields,$array_values);	
		}
		
		$return['POST']			= $_POST;
		$return['msg']			= $result;
		$return['script']			= $script;
		echo json_encode($return);
	}

	function save_monitoring_validation() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$fk_capa    		= $_POST['fk_capa'];
		$fk_capa_correction = $_POST['fk_capa_correction'];
		$monitoring_date    = $_POST['monitoring_date'];
		$monitoring_by    	= $_POST['monitoring_by'];
		$monitoring_result  = $_POST['monitoring_result'];
		$user  				= $_POST['user'];
		$file  		    	= ($_POST['tbl_id'] == 'tbl_qfr_capa_1st_monitoring' ? return_file_path_by_div_mod('qfr_capa_qs_monitoring') : ($_POST['tbl_id'] == 'tbl_qfr_capa_2nd_validation_external' ? return_file_path_by_div_mod('qfr_capa_qc_monitoring') : return_file_path_by_div_mod('qfr_capa_qad_monitoring')));
		$fkfile_path     	= $file['pkid'];
		$target_dir      	= $file['path'];
		$temp_file 	     	= $_FILES["file_capa_attachment"]["tmp_name"];
		$file_name 	     	= $_FILES["file_capa_attachment"]["name"];
		$msg			 	= '';		
		
		/* Get the order to be monitored */	
		$array_fields = array('`order`');
		$table 	   	= $_POST['tbl_id'];
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa='.$fk_capa.' AND fk_capa_correction='.$fk_capa_correction.' AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			if($table == 'tbl_qfr_capa_1st_monitoring') {
				$action = 'monitoring';
			} else {
				$action = 'validation';
			}
			$monitoring_field 			= return_monitoring_field('', $row['order']);
			$monitoring_date_field 		= return_monitoring_field($user.'_', $row['order']).$action.'_date';
			$monitoring_by_field 		= return_monitoring_field($user.'_', $row['order']).$action.'_by';
			$monitoring_result_field 	= return_monitoring_field($user.'_', $row['order']).$action.'_result';
			$monitoring_attachment_field 	= return_monitoring_field($user.'_', $row['order']).$action.'_attachment';			
			$target_file 	 			= $target_dir.return_monitoring_field($user.'_', $row['order']).$action.'/'. $file_name;
			$target_dir 	 			= $target_dir.return_monitoring_field($user.'_', $row['order']).$action.'/';
			$order						= $row['order'];
		}
		
		if($_POST['tbl_id'] != 'tbl_qfr_capa_3rd_validation_external' ) {
			$ctr = 12;
		} else {
			$ctr = 3;
		}
		
		if($order <= $ctr) {
			/* Update monitoring */	
			$order		= $order + 1;
			$array_fields 	= array('order', $monitoring_date_field, $monitoring_by_field, $monitoring_result_field,$monitoring_attachment_field, 'lastupdate', 'username');
			$array_values 	= array($order, $monitoring_date, $monitoring_by, $monitoring_result, $file_name,$date_time_today, $username);
			$msg			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
			$script 	   .= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values, $sql_where);	
			
			/* Upload file attachment first */	
			if (file_exists($target_file)) {
				// $msg 					= "Sorry, your file already exists.";
				// $return['error']		= $msg;
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $fk_capa.".".$ext;
					if(rename ($target_file, $target_dir.$new_file_name)){		
						$msg .= 'File was successfully uploaded to the system';
					} else {
						$msg .= 'There was an error on renaming the file.';
					}					
				} else {
					// $msg .= "Sorry, there was an error uploading your file.".$file_name;
				}
			}
			
			$script = update_1st_monitoring_column($fk_capa, $user, $monitoring_field.$action, $table, $username);
			
			/* Notify the Operations QS Supervisor if monitoring is for 12th day */
			if($order == 13 && $ctr == 12) {				
				$script .= 'Update posting '. update_posting_status($fk_capa, $fk_capa_correction, $username, $table);
			} else if($order == 4 && $ctr == 3) {				
				// $script .= 'Update posting '. update_3rd_validation_status($fk_capa, $fk_capa_correction, $username);
				$script .= 'Update posting '. update_posting_status($fk_capa, $fk_capa_correction, $username, $table);
			} else {
				$script .= 'Update posting N/A ';
			}
		} else {
			$msg = 'Invalid monitoring record!';
		}
		
		$return['script']			= $script;
		$return['POST']			= $_POST;
		$return['FILES']			= $_FILES;
		$return['msg']			= $msg;
		echo json_encode($return);
	}
	
	function save_qs_check_supervisor_log() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$monitoring_field = $_POST['monitoring_field'];
		$status 		= $_POST['status'];
		$fk_capa 		= $_POST['fk_capa'];
		$remarks 		= $_POST['remarks'];
		$user 			= $_POST['user'];
		$username 		= $_POST['username'];
		
		// return supervisor's index and logs
		$array_fields	= array($monitoring_field);
		$table			= 'tbl_qfr_capa_correction';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$monitoring_status	= '';
		if($row=mysqli_fetch_array($result)) {
			$rona = $row[$monitoring_field];
			$checked_by = explode(',',$row[$monitoring_field]);
			$index		= array_search($username, $checked_by);
			$checked_by_logs = array();
			for($i=0; $i<count($checked_by); $i++) {
				if($i == $index) {
					$checked_by_logs[$i] = 'Status:'.$status.'|Remarks: '.$remarks.'|Logs: '.date('M d, Y h:is', strtotime($date_time_today));
				} else {
					$checked_by_logs[$i] = '';
				}
			}
			$checked_by_logs = implode(',', $checked_by_logs);
		}		
		
		$array_fields 	= array($monitoring_field.'_date', 'lastupdate', 'username');
		$array_values 	= array($checked_by_logs, $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
		$script 	   .= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values, $sql_where);
				
		if($status == 'CHECKED') {
			$script .= set_conformance_approver($fk_capa, (str_replace('_checked_by', '_conformed_by', $monitoring_field)), $username);
		}
		
		if($user == 'supervisor') {
			$script .= send_email_qs_inspector_from_supervisor($fk_capa, str_replace('_checked_by','', $monitoring_field), $username, $status);
		} else if($user == 'ampup') {
			$script .= send_email_qs_inspector_from_supervisor($fk_capa, str_replace('_checked_by','', $monitoring_field), $username, $status);
		}  
		$return['msg']			= $result;
		$return['script']			= $script;
		$return['rona']			= $rona;
		echo json_encode($return);
	}
	
	function save_qs_conformance_log() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$monitoring_field = $_POST['monitoring_field'];
		$status 		= $_POST['status'];
		$fk_capa 		= $_POST['fk_capa'];
		$remarks 		= $_POST['remarks'];
		$username 		= $_POST['username'];
		
		// return supervisor's index and logs
		$array_fields	= array($monitoring_field);
		$table			= 'tbl_qfr_capa_correction';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$monitoring_status	= '';
		if($row=mysqli_fetch_array($result)) {
			$checked_by = explode(',',$row[$monitoring_field]);
			$index		= array_search($username, $checked_by);
			$checked_by_logs = array();
			for($i=0; $i<count($checked_by); $i++) {
				if($i == $index) {
					$checked_by_logs[$i] = 'Status:'.$status.'|Remarks: '.$remarks.'|Logs: '.date('M d, Y h:i', strtotime($date_time_today));
				} else {
					$checked_by_logs[$i] = '';
				}
			}
			$checked_by_logs = implode(',', $checked_by_logs);
		}		
		
		$array_fields 	= array($monitoring_field.'_date', 'lastupdate', 'username');
		$array_values 	= array($checked_by_logs, $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
		
		send_email_qs_inspector_from_conformance($fk_capa, $monitoring_field, $username, $status);
		
		$return['msg']			= $result;
		$return['script']		= $script;
		echo json_encode($return);
	}
	
	function save_qs_supervisor_post_log() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$fk_capa 			= $_POST['fk_capa'];
		$fk_capa_correction = $_POST['fk_capa_correction'];
		$status 			= $_POST['status'];
		$username 			= $_POST['username'];
		
		$table_status	= 'tbl_qfr_capa_1st_monitoring';
		$array_fields 	= array('qs_status', 'posted_by', 'posted_date', 'lastupdate', 'username');
		$array_values 	= array($status, $username, $date_time_today, $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND fk_capa_correction='.$fk_capa_correction.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table_status,$array_fields,$array_values, $sql_where);
		$script 	    = TQTS::getInstance()->update_query_detailed_script($table_status,$array_fields,$array_values, $sql_where);
		
		/* Send email for Posted CAPA */
		send_email_qs_inspector_from_supervisor_post($fk_capa, $fk_capa_correction, $username, $status);
		
		/* Check CAPA classification */
		$array_fields	= array('classification');
		$table			= 'tbl_qfr_capa_main';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$select_result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$classification	= '';
		if($row=mysqli_fetch_array($select_result)) {
			$classification = $row['classification'];
			if($classification == 'External') {
				/* Insert monitoring */
				$script .= save_external_2nd_monitoring($date_time_today, $username, $fk_capa);
			} else {
				/* Count correction record */
				$array_fields	= array('pkid');
				$table			= 'tbl_qfr_capa_correction';
				$joins			= '';
				$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
				$sql_order		= '';
				$sql_limit		= '';
				$result_details	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				$result_1st 	= TQTS::getInstance()->select_query($array_fields,$table_status,$joins,$sql_where,$sql_order,$sql_limit);
				// $script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($result_details->num_rows == $result_1st->num_rows) {		
					$table				= 'tbl_qfr_capa_main';
					$array_fields 		= array('status', 'lastupdate', 'username');
					$array_values 		= array('CLOSED', $date_time_today, $username);
					$sql_where			= 'WHERE `pkid`='.$fk_capa.' AND logdel=0';
					$result				= TQTS::getInstance()->update_query($table,$array_fields,$array_values, $fk_capa);
				}
				send_email_qs_supervisor_closed_capa($fk_capa, $fk_capa_correction,$username);
			}
		}
		
		$return['msg']			= $result;
		$return['script']		= $script;
		echo json_encode($return);
	}
	
	function save_qc_check_amup_log() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$monitoring_field = $_POST['monitoring_field'];
		$status 		= $_POST['status'];
		$fk_capa 		= $_POST['fk_capa'];
		$remarks 		= $_POST['remarks'];
		$username 		= $_POST['username'];
		
		// return supervisor's index and logs
		$array_fields	= array($monitoring_field);
		$table			= 'tbl_qfr_capa_correction';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$monitoring_status	= '';
		if($row=mysqli_fetch_array($result)) {
			$rona = $row[$monitoring_field];
			$checked_by = explode(',',$row[$monitoring_field]);
			$index		= array_search($username, $checked_by);
			$checked_by_logs = array();
			for($i=0; $i<count($checked_by); $i++) {
				if($i == $index) {
					$checked_by_logs[$i] = 'Status:'.$status.'|Remarks: '.$remarks.'|Logs: '.date('M d, Y h:is', strtotime($date_time_today));
				} else {
					$checked_by_logs[$i] = '';
				}
			}
			$checked_by_logs = implode(',', $checked_by_logs);
		}		
		
		$array_fields 	= array($monitoring_field.'_date', 'lastupdate', 'username');
		$array_values 	= array($checked_by_logs, $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
		// $script 	    = TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values, $sql_where);
				
		if($status == 'CHECKED') {
			$script = set_conformance_approver($fk_capa, (str_replace('_checked_by', '_conformed_by', $monitoring_field)), $username);
		}
		
		$script .= send_email_qs_inspector_from_supervisor($fk_capa, str_replace('_checked_by','', $monitoring_field), $username, $status);
		
		$return['msg']			= $result;
		$return['script']			= $script;
		$return['rona']			= $rona;
		echo json_encode($return);
	}
	
	function save_external_2nd_monitoring($date_time_today, $username, $fk_capa) {
		require_once('../class/oop_tqts.php');
		/* Check CAPA classification */
		$array_fields	= array('tbl_qfr_capa_correction.pkid');
		$table			= 'tbl_qfr_capa_correction';
		$joins			= 'INNER JOIN tbl_qfr_capa_1st_monitoring ON tbl_qfr_capa_1st_monitoring.fk_capa_correction = tbl_qfr_capa_correction.pkid';
		$sql_where		= 'WHERE tbl_qfr_capa_correction.`fk_capa` = "'.$fk_capa.'" AND tbl_qfr_capa_correction.fk_capa=tbl_qfr_capa_1st_monitoring.fk_capa AND tbl_qfr_capa_1st_monitoring.qs_status = "CLOSED" AND tbl_qfr_capa_correction.logdel="0" AND tbl_qfr_capa_1st_monitoring.logdel="0"';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$fk_capa_correction	= 0;
		while($row=mysqli_fetch_array($result)) {
			$fk_capa_correction = $row['pkid'];
			/* Insert 2nd monitoring */
			$file  		     				 = return_file_path_by_div_mod('qfr_capa_qc_monitoring');
			$fkfile_path     				 = $file['pkid'];
			$table_2nd_monitoring_ext		 = 'tbl_qfr_capa_2nd_validation_external';
			$array_fields_2nd_monitoring_ext = array('pkid');
			$joins_2nd_monitoring_ext		 = '';
			$sql_where_2nd_monitoring_ext 	 = 'WHERE `fk_capa` = "'.$fk_capa.'" AND fk_capa_correction="'.$fk_capa_correction.'" AND logdel="0"';
			$sql_order_2nd_monitoring_ext 	 = '';
			$sql_limit_2nd_monitoring_ext 	 = '';
			$result_2nd_monitoring_ext 		 = TQTS::getInstance()->select_query($array_fields_2nd_monitoring_ext,$table_2nd_monitoring_ext,$joins_2nd_monitoring_ext,$sql_where_2nd_monitoring_ext,$sql_order_2nd_monitoring_ext,$sql_limit_2nd_monitoring_ext);
			if($result_2nd_monitoring_ext->num_rows == 0) {			
				$array_fields 				= array('date_time_created', 'created_by', 'fk_capa', 'fk_capa_correction', 'fkfile_path', '`order`', 'qc_status', 'lastupdate', 'username');
				$array_values 				= array($date_time_today, $username, $fk_capa, $fk_capa_correction, $fkfile_path, 1, 'OPEN', $date_time_today, $username);
				$insert_result				= TQTS::getInstance()->insert_query($table_2nd_monitoring_ext,$array_fields,$array_values);
				$script 					.= TQTS::getInstance()->insert_query_script($table_2nd_monitoring_ext,$array_fields,$array_values);	
			}
		}
		return $script;
	}
	
	function save_qc_qad_ampup_log() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$validation_field = $_POST['validation_field'];
		$status 		= $_POST['status'];
		$fk_capa 		= $_POST['fk_capa'];
		$remarks 		= $_POST['remarks'];
		$username 		= $_POST['username'];
		
		// return supervisor's index and logs
		$array_fields	= array($validation_field);
		$table			= 'tbl_qfr_capa_correction';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$monitoring_status	= '';
		if($row=mysqli_fetch_array($result)) {
			$rona = $row[$validation_field];
			$checked_by = explode(',',$row[$validation_field]);
			$index		= array_search($username, $checked_by);
			$checked_by_logs = array();
			for($i=0; $i<count($checked_by); $i++) {
				if($i == $index) {
					$checked_by_logs[$i] = 'Status:'.$status.'|Remarks: '.$remarks.'|Logs: '.date('M d, Y h:i', strtotime($date_time_today));
				} else {
					$checked_by_logs[$i] = '';
				}
			}
			$checked_by_logs = implode(';', $checked_by_logs);
		}		
		
		$array_fields 	= array($validation_field.'_date', 'lastupdate', 'username');
		$array_values 	= array($checked_by_logs, $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
		// $script 	    = TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values, $sql_where);
				
		if($status == 'CHECKED') {
			$script = set_conformance_approver($fk_capa, (str_replace('_checked_by', '_conformed_by', $validation_field)), $username);
		}
		
		$script .= send_email_qs_inspector_from_amup_post($fk_capa, str_replace('_checked_by','', $validation_field), $username, $status);
		
		$return['msg']			= $result;
		$return['script']		= $script;
		$return['rona']			= $rona;
		echo json_encode($return);
	}
	
	function save_qc_supervisor_post_log() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$fk_capa 			= $_POST['fk_capa'];
		$fk_capa_correction = $_POST['fk_capa_correction'];
		$status 			= $_POST['status'];
		$username 			= $_POST['username'];
		
		$table_status	= 'tbl_qfr_capa_2nd_validation_external';
		$array_fields 	= array('qc_status', 'posted_by', 'posted_date', 'lastupdate', 'username');
		$array_values 	= array($status, $username, $date_time_today, $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND fk_capa_correction='.$fk_capa_correction.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table_status,$array_fields,$array_values, $sql_where);
		$script 	    = TQTS::getInstance()->update_query_detailed_script($table_status,$array_fields,$array_values, $sql_where);
		
		/* Send email for Posted CAPA */
		send_email_qs_inspector_from_supervisor_post($fk_capa, $fk_capa_correction, $username, $status);
		
		/* Check CAPA classification */
		$array_fields	= array('classification');
		$table			= 'tbl_qfr_capa_main';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$select_result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$classification	= '';
		if($row=mysqli_fetch_array($select_result)) {
			$classification = $row['classification'];
			if($classification == 'External') {
				/* Insert final validation */
				$script .= save_external_3rd_validation($date_time_today, $username, $fk_capa);
			}
		}
		
		$return['msg']			= $result;
		$return['script']		= $script;
		echo json_encode($return);
	}
	
	function save_external_3rd_validation($date_time_today, $username, $fk_capa) {
		require_once('../class/oop_tqts.php');
		/* Check CAPA classification */
		$array_fields	= array('tbl_qfr_capa_correction.pkid');
		$table			= 'tbl_qfr_capa_correction';
		$joins			= 'INNER JOIN tbl_qfr_capa_2nd_validation_external ON tbl_qfr_capa_2nd_validation_external.fk_capa_correction = tbl_qfr_capa_correction.pkid';
		$sql_where		= 'WHERE tbl_qfr_capa_correction.`fk_capa` = "'.$fk_capa.'" AND tbl_qfr_capa_correction.fk_capa=tbl_qfr_capa_2nd_validation_external.fk_capa AND tbl_qfr_capa_2nd_validation_external.qc_status = "CLOSED" AND tbl_qfr_capa_correction.logdel="0" AND tbl_qfr_capa_2nd_validation_external.logdel="0"';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$fk_capa_correction	= 0;
		while($row=mysqli_fetch_array($result)) {
			$fk_capa_correction = $row['pkid'];
			/* Insert 3rd monitoring */
			$file  		     				 = return_file_path_by_div_mod('qfr_capa_qad_monitoring');
			$fkfile_path     				 = $file['pkid'];
			$table_3rd_monitoring_ext		 = 'tbl_qfr_capa_3rd_validation_external';
			$array_fields_3rd_monitoring_ext = array('pkid');
			$joins_3rd_monitoring_ext		 = '';
			$sql_where_3rd_monitoring_ext 	 = 'WHERE `fk_capa` = "'.$fk_capa.'" AND fk_capa_correction="'.$fk_capa_correction.'" AND logdel="0"';
			$sql_order_3rd_monitoring_ext 	 = '';
			$sql_limit_3rd_monitoring_ext 	 = '';
			$result_2nd_monitoring_ext 		 = TQTS::getInstance()->select_query($array_fields_3rd_monitoring_ext,$table_3rd_monitoring_ext,$joins_3rd_monitoring_ext,$sql_where_3rd_monitoring_ext,$sql_order_3rd_monitoring_ext,$sql_limit_3rd_monitoring_ext);
			if($result_2nd_monitoring_ext->num_rows == 0) {			
				$array_fields 				= array('date_time_created', 'created_by', 'fk_capa', 'fk_capa_correction', 'fkfile_path', '`order`', 'qad_status', 'lastupdate', 'username');
				$array_values 				= array($date_time_today, $username, $fk_capa, $fk_capa_correction, $fkfile_path, 1, 'OPEN', $date_time_today, $username);
				$insert_result				= TQTS::getInstance()->insert_query($table_3rd_monitoring_ext,$array_fields,$array_values);
				$script 					.= TQTS::getInstance()->insert_query_script($table_3rd_monitoring_ext,$array_fields,$array_values);	
			}
		}
		return $script;
	}
	
	function get_monitoring_date_minimum() {
		require_once('../class/oop_tqts.php');
		$fk_capa    		= $_POST['fk_capa'];
		$fk_capa_correction = $_POST['fk_capa_correction'];
		$user  				= $_POST['user'];
		$msg			 	= '';		
		
		/* Get the order to be monitored */	
		$array_fields = array('*');
		$table 	   	= $_POST['tbl_id'];
		$monitoring = $_POST['tbl_id'] == 'tbl_qfr_capa_1st_monitoring' ? 'monitoring' : 'validation';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa='.$fk_capa.' AND fk_capa_correction='.$fk_capa_correction.' AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$min_monitoring_date 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$monitoring_date_field 		= return_monitoring_field($user.'_', ($row['order']-1)).$monitoring.'_date';
			$min_monitoring_date		= $row[$monitoring_date_field];
		}
		
		$return['min_monitoring_date'] 	 = $min_monitoring_date;
		$return['monitoring_date_field'] = $monitoring_date_field;
		$return['date_today'] 			 = date('Y-m-d');
		$return['script'] = $script;
		$return['POST'] = $_POST;
		echo json_encode($return);
	}
	
	function get_capa_main_details() {
		require_once('../class/oop_tqts.php');
		$array_fields	= array('*');
		$table			= 'tbl_qfr_capa_main';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$_POST['pkid'].'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$array_assigned_line = explode(",",$row['assigned_line']);
			$row['assigned_line'] 			= array();
			foreach($array_assigned_line as $key => $value){
				$array_assigned_line 						= array();
				$array_assigned_line['id'] 					= $value;
				$array_assigned_line['text'] 				= get_emp_name_by_username_systemone($value);
				$row['assigned_line'][]		= $array_assigned_line;
			}
			
			$array_checked_by = explode(",",$row['checked_by']);
			$row['checked_by'] 			= array();
			foreach($array_checked_by as $key => $value){
				$array_checked_by 						= array();
				$array_checked_by['id'] 					= $value;
				$array_checked_by['text'] 				= get_emp_name_by_username_systemone($value);
				$row['checked_by'][]		= $array_checked_by;
			}
			
			$array_conformed_by = explode(",",$row['conformed_by']);
			$row['conformed_by'] 			= array();
			foreach($array_conformed_by as $key => $value){
				$array_conformed_by 						= array();
				$array_conformed_by['id'] 					= $value;
				$array_conformed_by['text'] 				= get_emp_name_by_username_systemone($value);
				$row['conformed_by'][]		= $array_conformed_by;
			}
			
			$array_operations_qe = explode(",",$row['operations_qe']);
			$row['operations_qe'] 			= array();
			foreach($array_operations_qe as $key => $value){
				$array_operations_qe 			= array();
				$array_operations_qe['id'] 		= $value;
				$array_operations_qe['text'] 	= get_emp_name_by_username_systemone($value);
				$row['operations_qe'][]			= $array_operations_qe;
			}
			
			$return['data'] = $row;
		}
		// $script = 'rona';
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_capa_1st_monitoring_details() {
		require_once('../class/oop_tqts.php');
		$fk_capa		= $_POST['fk_capa'];
		$user			= $_POST['user'];
		// $fk_capa		= 9;
		// $user			= 'qs';
		$array_fields	= array('*');
		$table			= 'vw_qfr_capa_1st_monitoring';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		// $sql_where		= 'WHERE `fk_capa` = "9" AND logdel="0"';
		$sql_order		= 'ORDER BY monitoring_type';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$table_body		=	'';
		$tbody			=	'';
		$correction_array =	array();
		$corrective_array =	array();
		$monitoring_1st_by = array();
		$monitoring_2nd_by = array();
		$monitoring_3rd_by = array();
		$monitoring_4th_by = array();
		$monitoring_5th_by = array();
		$monitoring_6th_by = array();
		$monitoring_7th_by = array();
		$monitoring_8th_by = array();
		$monitoring_9th_by = array();
		$monitoring_10th_by = array();
		$monitoring_11th_by = array();
		$monitoring_12th_by = array();
		
		while($row = mysqli_fetch_assoc($result)){	
			$fk_capa_correction = $row['fk_capa_correction'];
			$qs_status 			= '';
			switch($row['qs_status']) {
				case 'OPEN'		: $qs_status = '<span class="badge highlight-color-yellow" >OPEN</span>'; break;
				case 'CLOSED'	: $qs_status = '<span class="badge highlight-color-green" >CLOSED</span>'; break;
			}
			
			$incharge_person = '';
			$incharge_person_array = explode(',',$row['incharge_person']);
			for($i=0; $i<count($incharge_person_array); $i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).'<br>';
			}
			$due_date		 = ($row['due_date'] == '' ? '' : date('M d, Y', strtotime($row['due_date'])));
			$monitoring_1st_date  	= $row['qs_1st_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_1st_monitoring_date']));
			$monitoring_1st_by[]  	= $row['qs_1st_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_1st_monitoring_by']);
			$monitoring_1st_result 	= $row['qs_1st_monitoring_date'] == '' ? '' : $row['qs_1st_monitoring_result'];
			$monitoring_1st_result .= $row['qs_1st_monitoring_date'] == '' ? '' : ($row['qs_1st_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="1"> Download</a>');
			$monitoring_2nd_date  	= $row['qs_2nd_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_2nd_monitoring_date']));
			$monitoring_2nd_by[]  	= $row['qs_2nd_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_2nd_monitoring_by']);
			$monitoring_2nd_result = $row['qs_2nd_monitoring_date'] == '' ? '' : $row['qs_2nd_monitoring_result'];
			$monitoring_2nd_result .= $row['qs_2nd_monitoring_date'] == '' ? '' : ($row['qs_2nd_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="2"> Download</a>');
			$monitoring_3rd_date  	= $row['qs_3rd_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_3rd_monitoring_date']));
			$monitoring_3rd_by[]  	= $row['qs_3rd_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_3rd_monitoring_by']);
			$monitoring_3rd_result = $row['qs_3rd_monitoring_date'] == '' ? '' : $row['qs_3rd_monitoring_result'];
			$monitoring_3rd_result .= $row['qs_3rd_monitoring_date'] == '' ? '' : ($row['qs_3rd_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="3"> Download</a>');
			$monitoring_4th_date  	= $row['qs_4th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_4th_monitoring_date']));
			$monitoring_4th_by[]  	= $row['qs_4th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_4th_monitoring_by']);
			$monitoring_4th_result = $row['qs_4th_monitoring_date'] == '' ? '' : $row['qs_4th_monitoring_result'];
			$monitoring_4th_result .= $row['qs_4th_monitoring_date'] == '' ? '' : ($row['qs_4th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="4"> Download</a>');
			$monitoring_5th_date  	= $row['qs_5th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_5th_monitoring_date']));
			$monitoring_5th_by[]  	= $row['qs_5th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_5th_monitoring_by']);
			$monitoring_5th_result 	= $row['qs_5th_monitoring_date'] == '' ? '' : $row['qs_5th_monitoring_result'];
			$monitoring_5th_result .= $row['qs_5th_monitoring_date'] == '' ? '' : ($row['qs_5th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="5"> Download</a>');
			$monitoring_6th_date  	= $row['qs_6th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_6th_monitoring_date']));
			$monitoring_6th_by[]  	= $row['qs_6th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_6th_monitoring_by']);
			$monitoring_6th_result = $row['qs_6th_monitoring_date'] == '' ? '' : $row['qs_6th_monitoring_result'];
			$monitoring_6th_result .= $row['qs_6th_monitoring_date'] == '' ? '' : ($row['qs_6th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="6"> Download</a>');
			$monitoring_7th_date  = $row['qs_7th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_7th_monitoring_date']));
			$monitoring_7th_by[]  = $row['qs_7th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_7th_monitoring_by']);
			$monitoring_7th_result = $row['qs_7th_monitoring_date'] == '' ? '' : $row['qs_7th_monitoring_result'];
			$monitoring_7th_result .= $row['qs_7th_monitoring_date'] == '' ? '' : ($row['qs_7th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="7"> Download</a>');
			$monitoring_8th_date  = $row['qs_8th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_8th_monitoring_date']));
			$monitoring_8th_by[]  = $row['qs_8th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_8th_monitoring_by']);
			$monitoring_8th_result = $row['qs_8th_monitoring_date'] == '' ? '' : $row['qs_8th_monitoring_result'];
			$monitoring_8th_result .= $row['qs_8th_monitoring_date'] == '' ? '' : ($row['qs_8th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="8"> Download</a>');
			$monitoring_9th_date  = $row['qs_9th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_9th_monitoring_date']));
			$monitoring_9th_by[]  = $row['qs_9th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_9th_monitoring_by']);
			$monitoring_9th_result = $row['qs_9th_monitoring_date'] == '' ? '' : $row['qs_9th_monitoring_result'];
			$monitoring_9th_result .= $row['qs_9th_monitoring_date'] == '' ? '' : ($row['qs_9th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="9"> Download</a>');
			$monitoring_10th_date  = $row['qs_10th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_10th_monitoring_date']));
			$monitoring_10th_by[]  = $row['qs_10th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_10th_monitoring_by']);
			$monitoring_10th_result = $row['qs_10th_monitoring_date'] == '' ? '' : $row['qs_10th_monitoring_result'];
			$monitoring_10th_result .= $row['qs_10th_monitoring_date'] == '' ? '' : ($row['qs_10th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="10"> Download</a>');
			$monitoring_11th_date  = $row['qs_11th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_11th_monitoring_date']));
			$monitoring_11th_by[]  = $row['qs_11th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_11th_monitoring_by']);
			$monitoring_11th_result = $row['qs_11th_monitoring_date'] == '' ? '' : $row['qs_11th_monitoring_result'];
			$monitoring_11th_result .= $row['qs_11th_monitoring_date'] == '' ? '' : ($row['qs_11th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="11"> Download</a>');
			$monitoring_12th_date  = $row['qs_12th_monitoring_date'] == '' ? '' : date('M d, Y', strtotime($row['qs_12th_monitoring_date']));
			$monitoring_12th_by[]  = $row['qs_12th_monitoring_date'] == '' ? '' :  get_emp_name_by_username_systemone($row['qs_12th_monitoring_by']);
			$monitoring_12th_result = $row['qs_12th_monitoring_date'] == '' ? '' : $row['qs_12th_monitoring_result'];
			$monitoring_12th_result .= $row['qs_12th_monitoring_date'] == '' ? '' : ($row['qs_12th_monitoring_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="12"> Download</a>');
			
			if($user == 'supervisor') {
				if($row['posted_date'] == '' && $row['posted_by'] != '') {
					$posted  		  = '<button type="button" class="btn btn-success fa fa-tags" data-id="'.$row['pkid'].'" data-fk="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Post</button>';
					$posted  		 .= '<button type="button" class="btn btn-danger fa fa-remove" data-id="'.$row['pkid'].'" data-fk="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Cancel</button>';
				} else {
					$posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
					$posted			 .= $row['posted_date'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
				}
				
				$colspan		  = 17;
			} else if($user == 'conformance' || $user == 'qc_qad' || $user == 'am_up' || $user == 'qc' || $user == 'qad' ) {
				$posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
				$posted			 .= $row['posted_date'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
				$colspan		  = 17;
			} else if($user == 'inspector_edit') {
				if($row['posted_date'] == '' && $row['posted_by'] == '') {
					$posted  		  = '<button type="button" class="btn btn-primary fa fa-edit" data-capa="'.$row['fk_capa'].'" data-correction="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Edit</button>';
				} else {
					$posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
					$posted			 .= $row['posted_date'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
				}
				$colspan		  = 17;
			} else if($user == 'qc_qad_edit') {
				$posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
				$posted			 .= $row['posted_date'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
				$colspan		  = 17;
			} else {
				$posted			  = '';
				$colspan		  = 16;
			}
			
			$tbody	 =	'<tr>';
			$tbody	.=	'	<td rowspan="3">'.$qs_status.'</td>';			
			$tbody	.=	'	<td rowspan="3">'.$row['correction_action'].'</td>';
			$tbody	.=	'	<td rowspan="3">'.$incharge_person.'</td>';
			$tbody	.=	'	<td rowspan="3">'.$due_date.'</td>';
			$tbody	.=	'	<td colspan="2"><center>1st Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>2nd Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>3rd Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>4th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>5th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>6th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>7th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>8th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>9th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>10th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>11th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>12th Monitoring</center></td>';
			$tbody	.=	$posted == '' ? '' : '	<td rowspan="3">'.$posted.'</td>';
			$tbody	.=	'</tr>';
			$tbody	.=	'<tr>';			
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_1st_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_2nd_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_3rd_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_4th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_5th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_6th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_7th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_8th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_9th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_10th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_11th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$monitoring_12th_date.'</td>';
			$tbody	.=	'</tr>';
			$tbody	.=	'<tr>';			
			$tbody	.=	'	<td colspan="2">'.$monitoring_1st_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_2nd_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_3rd_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_4th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_5th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_6th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_7th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_8th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_9th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_10th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_11th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$monitoring_12th_result.'</td>';
			$tbody	.=	'</tr>';
			
			if($row['monitoring_type'] == 'CORRECTION') {
				$correction_array[] = $tbody;
			} else if($row['monitoring_type'] == 'CORRECTIVE') {
				$corrective_array[] = $tbody;
			} 
		}
		
		$monitoring_1st_by = array_unique($monitoring_1st_by);
		$monitoring_2nd_by = array_unique($monitoring_2nd_by);
		$monitoring_3rd_by = array_unique($monitoring_3rd_by);
		$monitoring_4th_by = array_unique($monitoring_4th_by);
		$monitoring_5th_by = array_unique($monitoring_5th_by);
		$monitoring_6th_by = array_unique($monitoring_6th_by);
		$monitoring_7th_by = array_unique($monitoring_7th_by);
		$monitoring_8th_by = array_unique($monitoring_8th_by);
		$monitoring_9th_by = array_unique($monitoring_9th_by);
		$monitoring_10th_by = array_unique($monitoring_10th_by);
		$monitoring_11th_by = array_unique($monitoring_11th_by);
		$monitoring_12th_by = array_unique($monitoring_12th_by);
		
		if(count($correction_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="'.$colspan.'">CORRECTION</td>';		
			$table_body	.=	'</tr>';
			$table_body	.=	implode('',$correction_array);
		}
		if(count($corrective_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="'.$colspan.'">CORRECTIVE ACTION</td>';		
			$table_body	.=	'</tr>';
			$table_body	.=	implode('',$corrective_array);
		}
		
		if(count($correction_array) != 0 || count($corrective_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Audited by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_1st_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_2nd_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_3rd_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_4th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_5th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_6th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_7th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_8th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_9th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_10th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_11th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $monitoring_12th_by).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Checked by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('1st_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('2nd_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('3rd_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('4th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('5th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('6th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('7th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('8th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('9th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('10th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('11th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('12th_monitoring_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Conformed by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('1st_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('2nd_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('3rd_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('4th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('5th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('6th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('7th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('8th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('9th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('10th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('11th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('12th_monitoring_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
		}
		
		$return['script'] = $script;
		$return['table_body'] = $table_body;
		echo json_encode($return);
	}
	
	function get_capa_2nd_validation_details() {
		require_once('../class/oop_tqts.php');
		$fk_capa		= $_POST['fk_capa'];
		$user			= $_POST['user'];
		$array_fields	= array('*');
		$table			= 'vw_qfr_capa_2nd_validation_external';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		// $sql_where		= 'WHERE `fk_capa` = "19" AND logdel="0"';
		$sql_order		= 'ORDER BY monitoring_type';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$table_body		=	'';
		$tbody			=	'';
		$correction_array =	array();
		$corrective_array =	array();
		while($row = mysqli_fetch_assoc($result)){	
			$fk_capa_correction = $row['fk_capa_correction'];
			$qc_status 			= '';
			switch($row['qc_status']) {
				case 'OPEN'		: $qc_status = '<span class="badge highlight-color-yellow" >OPEN</span>'; break;
				case 'CLOSED'	: $qc_status = '<span class="badge highlight-color-green" >CLOSED</span>'; break;
			}
			
			$incharge_person = '';
			$incharge_person_array = explode(',',$row['incharge_person']);
			for($i=0; $i<count($incharge_person_array); $i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).'<br>';
			}
			$due_date		 = ($row['due_date'] == '' ? '' : date('M d, Y', strtotime($row['due_date'])));
			$validation_1st_date   = $row['qc_1st_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_1st_validation_date']));
			$validation_1st_by[]    = $row['qc_1st_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_1st_validation_by']);
			$validation_1st_result  = $row['qc_1st_validation_date'] == '' ? '' : '<br>'.$row['qc_1st_validation_result'];
			$validation_1st_result .= $row['qc_1st_validation_date'] == '' ? '' : ($row['qc_1st_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="1"> Download</a>');
			$validation_2nd_date   = $row['qc_2nd_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_2nd_validation_date']));
			$validation_2nd_by[]    = $row['qc_2nd_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_2nd_validation_by']);
			$validation_2nd_result  = $row['qc_2nd_validation_date'] == '' ? '' : '<br>'.$row['qc_2nd_validation_result'];
			$validation_2nd_result .= $row['qc_2nd_validation_date'] == '' ? '' : ($row['qc_2nd_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="2"> Download</a>');
			$validation_3rd_date    = $row['qc_3rd_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_3rd_validation_date']));
			$validation_3rd_by[]    = $row['qc_3rd_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_3rd_validation_by']);
			$validation_3rd_result  = $row['qc_3rd_validation_date'] == '' ? '' : '<br>'.$row['qc_3rd_validation_result'];
			$validation_3rd_result .= $row['qc_3rd_validation_date'] == '' ? '' : ($row['qc_3rd_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="3"> Download</a>');
			$validation_4th_date    = $row['qc_4th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_4th_validation_date']));
			$validation_4th_by[]    = $row['qc_4th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_4th_validation_by']);
			$validation_4th_result  = $row['qc_4th_validation_date'] == '' ? '' : '<br>'.$row['qc_4th_validation_result'];
			$validation_4th_result .= $row['qc_4th_validation_date'] == '' ? '' : ($row['qc_4th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="4"> Download</a>');
			$validation_5th_date    = $row['qc_5th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_5th_validation_date']));
			$validation_5th_by[]    = $row['qc_5th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_5th_validation_by']);
			$validation_5th_result  = $row['qc_5th_validation_date'] == '' ? '' : '<br>'.$row['qc_5th_validation_result'];
			$validation_5th_result .= $row['qc_5th_validation_date'] == '' ? '' : ($row['qc_5th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="5"> Download</a>');
			$validation_6th_date    = $row['qc_6th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_6th_validation_date']));
			$validation_6th_by[]    = $row['qc_6th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_6th_validation_by']);
			$validation_6th_result  = $row['qc_6th_validation_date'] == '' ? '' : '<br>'.$row['qc_6th_validation_result'];
			$validation_6th_result .= $row['qc_6th_validation_date'] == '' ? '' : ($row['qc_6th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="6"> Download</a>');
			$validation_7th_date    = $row['qc_7th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_7th_validation_date']));
			$validation_7th_by[]    = $row['qc_7th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_7th_validation_by']);
			$validation_7th_result  = $row['qc_7th_validation_date'] == '' ? '' : '<br>'.$row['qc_7th_validation_result'];
			$validation_7th_result .= $row['qc_7th_validation_date'] == '' ? '' : ($row['qc_7th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="7"> Download</a>');
			$validation_8th_date    = $row['qc_8th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_8th_validation_date']));
			$validation_8th_by[]    = $row['qc_8th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_8th_validation_by']);
			$validation_8th_result  = $row['qc_8th_validation_date'] == '' ? '' : '<br>'.$row['qc_8th_validation_result'];
			$validation_8th_result .= $row['qc_8th_validation_date'] == '' ? '' : ($row['qc_8th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="8"> Download</a>');
			$validation_9th_date    = $row['qc_9th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_9th_validation_date']));
			$validation_9th_by[]    = $row['qc_9th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_9th_validation_by']);
			$validation_9th_result  = $row['qc_9th_validation_date'] == '' ? '' : '<br>'.$row['qc_9th_validation_result'];
			$validation_9th_result .= $row['qc_9th_validation_date'] == '' ? '' : ($row['qc_9th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="9"> Download</a>');
			$validation_10th_date    = $row['qc_10th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_10th_validation_date']));
			$validation_10th_by[]    = $row['qc_10th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_10th_validation_by']);
			$validation_10th_result  = $row['qc_10th_validation_date'] == '' ? '' : '<br>'.$row['qc_10th_validation_result'];
			$validation_10th_result .= $row['qc_10th_validation_date'] == '' ? '' : ($row['qc_10th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="10"> Download</a>');
			$validation_11th_date    = $row['qc_11th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_11th_validation_date']));
			$validation_11th_by[]    = $row['qc_11th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_11th_validation_by']);
			$validation_11th_result  = $row['qc_11th_validation_date'] == '' ? '' : '<br>'.$row['qc_11th_validation_result'];
			$validation_11th_result .= $row['qc_11th_validation_date'] == '' ? '' : ($row['qc_11th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="11"> Download</a>');
			$validation_12th_date    = $row['qc_12th_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qc_12th_validation_date']));
			$validation_12th_by[]    = $row['qc_12th_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qc_12th_validation_by']);
			$validation_12th_result  = $row['qc_12th_validation_date'] == '' ? '' : '<br>'.$row['qc_12th_validation_result'];
			$validation_12th_result .= $row['qc_12th_validation_date'] == '' ? '' : ($row['qc_12th_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="12"> Download</a>');
			
			if($user == 'supervisor') {
				if($row['posted_date'] == '' && $row['posted_by'] != '') {
					$posted  		  = '<button type="button" class="btn btn-success fa fa-tags" data-id="'.$row['pkid'].'" data-fk="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Post</button>';
					$posted  		 .= '<button type="button" class="btn btn-danger fa fa-remove" data-id="'.$row['pkid'].'" data-fk="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Cancel</button>';
				} else {
					$posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
					$posted			 .= $row['posted_by'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
				}
				
				$colspan		  = 17;
			} else if($user == 'qc_qad_edit') {
				if($row['posted_date'] == '' && $row['posted_by'] == '') {
					$posted  		  = '<button type="button" class="btn btn-primary fa fa-edit" data-capa="'.$row['fk_capa'].'" data-correction="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Edit</button>';
				} else {
					$posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
					$posted			 .= $row['posted_date'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
				}
				$colspan		  = 17;
			} else {
				$posted			  = '';
				$colspan		  = 16;
			}
			
			$tbody	 =	'<tr>';
			$tbody	.=	'	<td rowspan="3">'.$qc_status.'</td>';			
			$tbody	.=	'	<td rowspan="3">'.$row['correction_action'].'</td>';
			$tbody	.=	'	<td rowspan="3">'.$incharge_person.'</td>';
			$tbody	.=	'	<td rowspan="3">'.$due_date.'</td>';
			$tbody	.=	'	<td colspan="2"><center>1st Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>2nd Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>3rd Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>4th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>5th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>6th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>7th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>8th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>9th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>10th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>11th Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>12th Monitoring</center></td>';
			$tbody	.=	$posted == '' ? '' : '	<td rowspan="3">'.$posted.'</td>';
			$tbody	.=	'</tr>';
			$tbody	.=	'<tr>';			
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_1st_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_2nd_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_3rd_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_4th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_5th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_6th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_7th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_8th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_9th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_10th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_11th_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_12th_date.'</td>';
			$tbody	.=	'</tr>';
			$tbody	.=	'<tr>';			
			$tbody	.=	'	<td colspan="2">'.$validation_1st_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_2nd_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_3rd_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_4th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_5th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_6th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_7th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_8th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_9th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_10th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_11th_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_12th_result.'</td>';
			$tbody	.=	'</tr>';
			
			if($row['monitoring_type'] == 'CORRECTION') {
				$correction_array[] = $tbody;
			} else if($row['monitoring_type'] == 'CORRECTIVE') {
				$corrective_array[] = $tbody;
			} 
		}
		
		$validation_1st_by = array_unique($validation_1st_by);
		$validation_2nd_by = array_unique($validation_2nd_by);
		$validation_3rd_by = array_unique($validation_3rd_by);
		$validation_4th_by = array_unique($validation_4th_by);
		$validation_5th_by = array_unique($validation_5th_by);
		$validation_6th_by = array_unique($validation_6th_by);
		$validation_7th_by = array_unique($validation_7th_by);
		$validation_8th_by = array_unique($validation_8th_by);
		$validation_9th_by = array_unique($validation_9th_by);
		$validation_10th_by = array_unique($validation_10th_by);
		$validation_11th_by = array_unique($validation_11th_by);
		$validation_12th_by = array_unique($validation_12th_by);
		
		if(count($correction_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="'.$colspan.'">CORRECTION</td>';		
			$table_body	.=	'</tr>';
			$table_body	.=	implode('',$correction_array);
		}
		if(count($corrective_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="'.$colspan.'">CORRECTIVE ACTION</td>';		
			$table_body	.=	'</tr>';
			$table_body	.=	implode('',$corrective_array);
		}
		
		
		
		/* Compare 1st monitoring data with 2nd monitoring */
		$array_fields2	= array('pkid');
		$table2			= 'tbl_qfr_capa_1st_monitoring';
		$joins2			= '';
		$sql_where2		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order2		= '';
		$sql_limit2		= '';
		$result2 		= TQTS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
		
		if($result->num_rows == $result2->num_rows) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Audited by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_1st_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_2nd_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_3rd_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_4th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_5th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_6th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_7th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_8th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_9th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_10th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_11th_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_12th_by).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Checked by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('1st_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('2nd_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('3rd_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('4th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('5th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('6th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('7th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('8th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('9th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('10th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('11th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('12th_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Conformed by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('1st_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('2nd_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('3rd_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('4th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('5th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('6th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('7th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('8th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('9th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('10th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('11th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('12th_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
		}
		
		$return['script'] = $script;
		$return['table_body'] = $table_body;
		echo json_encode($return);
	}
	
	function get_capa_3rd_validation_details() {
		require_once('../class/oop_tqts.php');
		$fk_capa		= $_POST['fk_capa'];
		$user			= $_POST['user'];
		// $fk_capa		= 1;
		// $user			= 'qad';
		$array_fields	= array('*');
		$table			= 'vw_qfr_capa_3rd_validation_external';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		// $sql_where		= 'WHERE `fk_capa` = "1" AND logdel="0"';
		$sql_order		= 'ORDER BY monitoring_type';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$table_body		=	'';
		$tbody			=	'';
		$correction_array =	array();
		$corrective_array =	array();
		while($row = mysqli_fetch_assoc($result)){	
			$fk_capa_correction = $row['fk_capa_correction'];
			$qad_status 			= '';
			$posted_dt 				= '';
			$posted_by 				= '';
			switch($row['qad_status']) {
				case 'OPEN'		: $qad_status = '<span class="badge highlight-color-yellow" >OPEN</span>'; break;
				case 'CLOSED'	: $qad_status = '<span class="badge highlight-color-green" >CLOSED</span>'; break;
			}
			
			$incharge_person = '';
			$incharge_person_array = explode(',',$row['incharge_person']);
			for($i=0; $i<count($incharge_person_array); $i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).'<br>';
			}
			$due_date		 = ($row['due_date'] == '' ? '' : date('M d, Y', strtotime($row['due_date'])));
			$validation_1st_date    = $row['qad_1st_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qad_1st_validation_date']));
			$validation_1st_by[]    = $row['qad_1st_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qad_1st_validation_by']);
			$validation_1st_result  = $row['qad_1st_validation_date'] == '' ? '' : $row['qad_1st_validation_result'];
			$validation_1st_result .= $row['qad_1st_validation_date'] == '' ? '' : ($row['qad_1st_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="1"> Download</a>');
			$validation_2nd_date    = $row['qad_2nd_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qad_2nd_validation_date']));
			$validation_2nd_by[]    = $row['qad_2nd_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qad_2nd_validation_by']);
			$validation_2nd_result  = $row['qad_2nd_validation_date'] == '' ? '' : $row['qad_2nd_validation_result'];
			$validation_2nd_result .= $row['qad_2nd_validation_date'] == '' ? '' : ($row['qad_2nd_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="2"> Download</a>');
			$validation_3rd_date    = $row['qad_3rd_validation_date'] == '' ? '' : date('M d, Y', strtotime($row['qad_3rd_validation_date']));
			$validation_3rd_by[]    = $row['qad_3rd_validation_date'] == '' ? '' : get_emp_name_by_username_systemone($row['qad_3rd_validation_by']);
			$validation_3rd_result  = $row['qad_3rd_validation_date'] == '' ? '' : $row['qad_3rd_validation_result'];
			$validation_3rd_result .= $row['qad_3rd_validation_date'] == '' ? '' : ($row['qad_3rd_validation_attachment'] == '' ? '' : '<br><a href="" data-id="'.$fk_capa.'"  data-fk="'.$fk_capa_correction.'" data-order="3"> Download</a>');
			
			if($user == 'supervisor') {
				if($row['posted_date'] == '' && $row['posted_by'] != '') {
					// $posted  		  = '';
					// $posted  		 .= '';
					
					$posted			  = 'has data';
					$posted_dt		 .=	'	<td colspan="2" style="width: 200px"><button type="button" class="btn btn-success fa fa-tags" data-id="'.$row['pkid'].'" data-fk="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Post</button></td>';
					$posted_by		  =	'	<td colspan="2"><button type="button" class="btn btn-danger fa fa-remove" data-id="'.$row['pkid'].'" data-fk="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Cancel</button></td>';
				} else {
					// $posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . date('M d, Y', strtotime($row['posted_date']));
					// $posted			 .= $row['posted_by'] == '' ? '-' : '<br>By : ' . get_emp_name_by_username_systemone($row['posted_by']);
					$posted			  = 'has data';
					$posted_dt		  =	'	<td style="width: 20px">Date: </td>';
					$posted_dt		 .=	'	<td style="width: 200px">'.($row['posted_date'] == '' ? '' : date('M d, Y', strtotime($row['posted_date']))).'</td>';
					$posted_by		  =	'	<td colspan="2">'.($row['posted_by'] == '' ? '-' : 'By : ' . get_emp_name_by_username_systemone($row['posted_by'])).'</td>';
				}
				
				$colspan		  = 8;
			} else if($user == 'qad_edit') {
				if($row['posted_date'] == '' && $row['posted_by'] != '') {
					$posted  		  = '<button type="button" class="btn btn-primary fa fa-edit" data-capa="'.$row['fk_capa'].'" data-correction="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Edit</button>';
					
					$posted			  = 'has data';
					$posted_dt		  =	'	<td style="width: 20px" colspan="2"> </td>';
					$posted_by		  =	'	<td colspan="2"><button type="button" class="btn btn-primary fa fa-edit" data-capa="'.$row['fk_capa'].'" data-correction="'.$fk_capa_correction.'" style="margin-bottom:3px;"> Edit</button></td>';
				} else {
					// $posted  		  = $row['posted_date'] == '' ? '' : 'Date : ' . ;
					// $posted			 .= $row['posted_date'] == '' ? '-' : '<br>By : ' . ;
					$posted			  = 'has data';
					$posted_dt		  =	'	<td style="width: 20px">Date: </td>';
					$posted_dt		 .=	'	<td style="width: 200px">'.($row['posted_date'] == '' ? '' : date('M d, Y', strtotime($row['posted_date']))).'</td>';
					$posted_by		  =	'	<td colspan="2">By: '.($row['posted_date'] == '' ? '-' : get_emp_name_by_username_systemone($row['posted_by'])).'</td>';
				}
				$colspan		  = 8;
			} else {
				$posted			  = '';
				$colspan		  = 7;
			}
			
			$tbody	 =	'<tr>';
			// $tbody	.=	'	<td rowspan="3">'.$qad_status.'</td>';			
			$tbody	.=	'	<td rowspan="3">'.$qad_status.'</td>';			
			$tbody	.=	'	<td rowspan="3">'.$row['correction_action'].'</td>';
			$tbody	.=	'	<td rowspan="3">'.$incharge_person.'</td>';
			$tbody	.=	'	<td rowspan="3">'.$due_date.'</td>';
			$tbody	.=	'	<td colspan="2"><center>1st Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>2nd Monitoring</center></td>';
			$tbody	.=	'	<td colspan="2"><center>3rd Monitoring</center></td>';
			$tbody	.=	$posted == '' ? '' : '	<td colspan="2"></td>';
			$tbody	.=	'</tr>';
			$tbody	.=	'<tr>';			
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_1st_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_2nd_date.'</td>';
			$tbody	.=	'	<td style="width: 20px">Date: </td>';
			$tbody	.=	'	<td style="width: 200px">'.$validation_3rd_date.'</td>';
			$tbody	.=	$posted == '' ? '' : $posted_dt;
			$tbody	.=	'</tr>';
			$tbody	.=	'<tr>';			
			$tbody	.=	'	<td colspan="2">'.$validation_1st_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_2nd_result.'</td>';
			$tbody	.=	'	<td colspan="2">'.$validation_3rd_result.'</td>';
			$tbody	.=	$posted == '' ? '' : $posted_by;
			$tbody	.=	'</tr>';
			
			if($row['monitoring_type'] == 'CORRECTION') {
				$correction_array[] = $tbody;
			} else if($row['monitoring_type'] == 'CORRECTIVE') {
				$corrective_array[] = $tbody;
			} 
		}
		
		$validation_1st_by = array_unique($validation_1st_by);
		$validation_2nd_by = array_unique($validation_2nd_by);
		$validation_3rd_by = array_unique($validation_3rd_by);
		
		if(count($correction_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="'.$colspan.'">CORRECTION</td>';		
			$table_body	.=	'</tr>';
			$table_body	.=	implode('',$correction_array);
		}
		if(count($corrective_array) != 0) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="'.$colspan.'">CORRECTIVE ACTION</td>';		
			$table_body	.=	'</tr>';
			$table_body	.=	implode('',$corrective_array);
		}
		
		/* Compare 1st monitoring data with 2nd monitoring */
		$array_fields2	= array('pkid');
		$table2			= 'tbl_qfr_capa_1st_monitoring';
		$joins2			= '';
		$sql_where2		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order2		= '';
		$sql_limit2		= '';
		$result2 		= TQTS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
		
		if($result->num_rows == $result2->num_rows) {
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Audited by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_1st_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_2nd_by).'</td>';
			$table_body	.=	'	<td colspan="2">'.implode(', ', $validation_3rd_by).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Checked by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('1st_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('2nd_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('3rd_validation_checked_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
			$table_body	.=	'<tr>';
			$table_body	.=	'	<td colspan="4"> <center>Conformed by:</center></td>';		
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('1st_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('2nd_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	'	<td colspan="2">'.check_monitoring_status('3rd_validation_conformed_by', $fk_capa, $fk_capa_correction, $user).'</td>';
			$table_body	.=	$posted == '' ? '' : '	<td colspan="2">-</td>';
			$table_body	.=	'</tr>';
		}
		
		$return['script'] = $script;
		$return['table_body'] = $table_body;
		echo json_encode($return);
	}
	
	function update_1st_monitoring_column($fk_capa, $user, $monitoring_field, $table, $username) {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$array_fields	= array('pkid');
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND `'.$user.'_'.$monitoring_field.'_by` = "" AND `'.$user.'_'.$monitoring_field.'_date` = "" AND `'.$user.'_'.$monitoring_field.'_result` = "" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($table == 'tbl_qfr_capa_1st_monitoring') {
			$condition = ($result->num_rows == 0 ? 'true' : 'false');
		} else if($table == 'tbl_qfr_capa_2nd_validation_external'){
			/* Compare 1st monitoring data with 2nd monitoring */
			$array_fields2	= array('pkid');
			$table_1st			= 'tbl_qfr_capa_1st_monitoring';
			$table_2nd			= 'tbl_qfr_capa_2nd_validation_external';
			$joins2			= '';
			// $sql_where2		= 'WHERE `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
			$sql_where1		= 'WHERE `fk_capa`='.$fk_capa.' AND `'.'qs_'.str_replace('validation','monitoring', $monitoring_field).'_by` != "" AND `qs_'.str_replace('validation','monitoring', $monitoring_field).'_date` != "" AND `qs_'.str_replace('validation','monitoring', $monitoring_field).'_result` != "" AND logdel=0';
			$sql_where2		= 'WHERE `fk_capa`='.$fk_capa.' AND `'.$user.'_'.$monitoring_field.'_by` != "" AND `'.$user.'_'.$monitoring_field.'_date` != "" AND `'.$user.'_'.$monitoring_field.'_result` != "" AND logdel=0';
			$sql_order2		= '';
			$sql_limit2		= '';
			$result_1st 		= TQTS::getInstance()->select_query($array_fields2,$table_1st,$joins2,$sql_where1,$sql_order2,$sql_limit2);
			$script 		.= '1 '.TQTS::getInstance()->select_query_script($array_fields2,$table_1st,$joins2,$sql_where1,$sql_order2,$sql_limit2);
			$result_2nd 		= TQTS::getInstance()->select_query($array_fields2,$table_2nd,$joins2,$sql_where2,$sql_order2,$sql_limit2);
			$script 		.= '2 '.TQTS::getInstance()->select_query_script($array_fields2,$table_2nd,$joins2,$sql_where2,$sql_order2,$sql_limit2);
			
			$condition = ($result_1st->num_rows == $result_2nd->num_rows ? 'true' : 'false');
		} else if($table == 'tbl_qfr_capa_3rd_validation_external'){
			/* Compare 1st monitoring data with 2nd monitoring */
			$array_fields2	= array('pkid');
			$table_2nd			= 'tbl_qfr_capa_2nd_validation_external';
			$table_3rd			= 'tbl_qfr_capa_3rd_validation_external';
			$joins2			= '';
			$sql_where1		= 'WHERE `fk_capa`='.$fk_capa.' AND `'.'qc_'.$monitoring_field.'_by` != "" AND `qc_'.$monitoring_field.'_date` != "" AND `qc_'.$monitoring_field.'_result` != "" AND logdel=0';
			$sql_where2		= 'WHERE `fk_capa`='.$fk_capa.' AND `'.$user.'_'.$monitoring_field.'_by` != "" AND `'.$user.'_'.$monitoring_field.'_date` != "" AND `'.$user.'_'.$monitoring_field.'_result` != "" AND logdel=0';
			$sql_order2		= '';
			$sql_limit2		= '';
			$result_1st 		= TQTS::getInstance()->select_query($array_fields2,$table_2nd,$joins2,$sql_where1,$sql_order2,$sql_limit2);
			$script 		.= '1 '.TQTS::getInstance()->select_query_script($array_fields2,$table_2nd,$joins2,$sql_where1,$sql_order2,$sql_limit2);
			$result_2nd 		= TQTS::getInstance()->select_query($array_fields2,$table_3rd,$joins2,$sql_where2,$sql_order2,$sql_limit2);
			$script 		.= '2 '.TQTS::getInstance()->select_query_script($array_fields2,$table_3rd,$joins2,$sql_where2,$sql_order2,$sql_limit2);
			
			$condition = ($result_1st->num_rows == $result_2nd->num_rows ? 'true' : 'false');
		}
		if($condition == 'true') {
			$array_fields	= array('checked_by');
			$table_main		= 'tbl_qfr_capa_main';
			$joins			= '';
			$sql_where		= 'WHERE `pkid`='.$fk_capa.' AND logdel=0';
			$sql_order		= '';
			$sql_limit		= '';
			$result 		= TQTS::getInstance()->select_query($array_fields,$table_main,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$checked_by = $row['checked_by'];
			}
			////Update the column checked_by
			$table_correction = 'tbl_qfr_capa_correction';
			$array_fields 	= array($monitoring_field.'_checked_by', 'lastupdate', 'username');
			$array_values 	= array($checked_by, $date_time_today, $username);
			$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
			$result			= TQTS::getInstance()->update_query_detailed($table_correction,$array_fields,$array_values, $sql_where);
			$script 	   .= TQTS::getInstance()->update_query_detailed_script($table_correction,$array_fields,$array_values, $sql_where);	
			
			/* Inform Supervisor checked by */
			$script .= send_email_qs_supervisor_checking($fk_capa, $monitoring_field,$checked_by, $table);
			
		}
		return $script;
	}
	
	function update_posting_status($fk_capa, $fk_capa_correction, $username, $table) {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$posted_by		= return_assigned_qs_supervisor_edit();
		$array_fields 	= array('posted_by', 'lastupdate', 'username');
		$array_values 	= array($posted_by['user_name'], $date_time_today, $username);
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND fk_capa_correction = "'.$fk_capa_correction.'" AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
		$script			= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values, $sql_where);
		
		if($table != 'tbl_qfr_capa_3rd_validation_external') {
			/* Notify supervisor */
			send_email_qs_supervisor_for_posting($fk_capa, $fk_capa_correction);
		}
		return $script;
	}
	
	function check_monitoring_status($monitoring_field, $fk_capa, $fk_capa_correction, $user) {
		require_once('../class/oop_tqts.php');
		$array_fields	= array($monitoring_field, $monitoring_field.'_date');
		$table			= 'tbl_qfr_capa_correction';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$fk_capa_correction.'" AND `fk_capa` = "'.$fk_capa.'" AND logdel="0"';
		$sql_order		= 'ORDER BY monitoring_type';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$monitoring_status	= '';
		if($row=mysqli_fetch_array($result)) {
			$index		 	 = array_search('|', explode(';',$row[$monitoring_field.'_date']));
			$checked_by		 = explode(',',$row[$monitoring_field]);
			$checked_by_logs = explode(';',$row[$monitoring_field.'_date']);
			$checked_by_data = get_emp_name_by_username_systemone($checked_by[$index]).'<br>'.str_replace('|','<br>', $checked_by_logs[$index]);
			if(strstr($monitoring_field, '_checked_by')) {
				if($user == 'supervisor' && (strstr($monitoring_field, 'monitoring'))) {
					$monitoring_status = $row[$monitoring_field] == '' ? '-N/A-' : ($row[$monitoring_field.'_date'] == '' ? '<button type="button" class="btn btn-success fa fa-check-square-o" data-id="'.$monitoring_field.'" style="margin-bottom:3px;"> Checked</button><button type="button" class="btn btn-danger fa fa-times-rectangle-o" data-id="'.$monitoring_field.'"> Reject</button>' : $checked_by_data );
				} else if($user == 'am_up' && strstr($monitoring_field, 'validation')) {
					$monitoring_status = $row[$monitoring_field] == '' ? '-N/A-' : ($row[$monitoring_field.'_date'] == '' ? '<button type="button" class="btn btn-success fa fa-check-square-o" data-id="'.$monitoring_field.'" style="margin-bottom:3px;"> Checked</button><button type="button" class="btn btn-danger fa fa-times-rectangle-o" data-id="'.$monitoring_field.'"> Reject</button>' : $checked_by_data );
				} else {
					$monitoring_status = $row[$monitoring_field] == '' ? '-N/A-' : ($row[$monitoring_field.'_date'] == '' ? '-PENDING-' : $checked_by_data );
				}
			} else if(strstr($monitoring_field, '_conformed_by')) {
				if($user == 'conformance') {
					$monitoring_status = $row[$monitoring_field] == '' ? '-N/A-' : ($row[$monitoring_field.'_date'] == '' ? '<button type="button" class="btn btn-success fa fa-thumbs-o-up" data-id="'.$monitoring_field.'" style="margin-bottom:3px;"> Conform</button><button type="button" class="btn btn-danger fa fa-thumbs-o-down" data-id="'.$monitoring_field.'"> Reject</button>' : $checked_by_data );
				} else if($user == 'conformance') {
					$monitoring_status = $row[$monitoring_field] == '' ? '-N/A-' : ($row[$monitoring_field.'_date'] == '' ? '<button type="button" class="btn btn-success fa fa-thumbs-o-up" data-id="'.$monitoring_field.'" style="margin-bottom:3px;"> Conform</button><button type="button" class="btn btn-danger fa fa-thumbs-o-down" data-id="'.$monitoring_field.'"> Reject</button>' : $checked_by_data );
				} else {
					$monitoring_status = $row[$monitoring_field] == '' ? '-N/A-' : ($row[$monitoring_field.'_date'] == '' ? '-PENDING-' : $checked_by_data );
				}
			}				
		}
		return $monitoring_status;
	}
	
	function set_conformance_approver($fk_capa, $monitoring_field, $username) {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$array_fields	= array('conformed_by');
		$table			= 'tbl_qfr_capa_main';
		$joins			= '';
		$sql_where		= 'WHERE `pkid`='.$fk_capa.' AND logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$conformed_by = $row['conformed_by'];
			//Update the column conformed_by
			$table			= 'tbl_qfr_capa_correction';
			$array_fields 	= array($monitoring_field, 'lastupdate', 'username');
			$array_values 	= array($conformed_by, $date_time_today, $username);
			$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
			$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values, $sql_where);
			$script 	   .= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values, $sql_where);	
		}
		return $script;
	}
	
	function update_3rd_validation_status() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$fk_capa			= $_POST['fk_capa'];
		$fk_capa_correction	= $_POST['fk_capa_correction'];
		$username			= $_POST['username'];
		$table3rd				= 'tbl_qfr_capa_3rd_validation_external';
		$array_fields 		= array('qad_status', 'posted_by', 'posted_date', 'lastupdate', 'username');
		$array_values 		= array('CLOSED', $username, $date_time_today, $date_time_today, $username);
		$sql_where			= 'WHERE `fk_capa`='.$fk_capa.' AND fk_capa_correction = "'.$fk_capa_correction.'" AND logdel=0';
		$result				= TQTS::getInstance()->update_query_detailed($table3rd,$array_fields,$array_values, $sql_where);
		$script				= TQTS::getInstance()->update_query_detailed_script($table3rd,$array_fields,$array_values, $sql_where);
		
		/* Count correction record */
		$array_fields	= array('pkid');
		$table			= 'tbl_qfr_capa_correction';
		$joins			= '';
		$sql_where		= 'WHERE `fk_capa`='.$fk_capa.' AND logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$result_details	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$result_3rd 	= TQTS::getInstance()->select_query($array_fields,$table3rd,$joins,$sql_where,$sql_order,$sql_limit);
		// $script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result_details->num_rows == $result_3rd->num_rows) {		
			$table				= 'tbl_qfr_capa_main';
			$array_fields 		= array('status', 'lastupdate', 'username');
			$array_values 		= array('CLOSED', $date_time_today, $username);
			$sql_where			= 'WHERE `pkid`='.$fk_capa.' AND logdel=0';
			$result				= TQTS::getInstance()->update_query($table,$array_fields,$array_values, $fk_capa);
		}
		send_email_qs_supervisor_closed_capa($fk_capa, $fk_capa_correction,$username);
		$return['msg'] = $result;
		echo json_encode($return);
	}
	
	
	
	function return_monitoring_field($user, $order) {
		switch($order) {
			case 1	:	return $user.'1st_'; break;
			case 2	:	return $user.'2nd_'; break;
			case 3	:	return $user.'3rd_'; break;
			case 4	:	return $user.'4th_'; break;
			case 5	:	return $user.'5th_'; break;
			case 6	:	return $user.'6th_'; break;
			case 7	:	return $user.'7th_'; break;
			case 8	:	return $user.'8th_'; break;
			case 9	:	return $user.'9th_'; break;
			case 10	:	return $user.'10th_'; break;
			case 11	:	return $user.'11th_'; break;
			case 12	:	return $user.'12th_'; break;
		}
	}
	
	function send_email_qs_supervisor_checking($fk_capa, $monitoring, $checked_by, $table) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table_main	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table_main,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table_main,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		/* Get the list of employees who update the monitoring, then include to recipient */
		// $table 	   	= 'tbl_qfr_capa_1st_monitoring';
		
		if($table == 'tbl_qfr_capa_1st_monitoring') {
			$array_fields 	= array('DISTINCT(qs_'.$monitoring.'_by)');
		} else if($table == 'tbl_qfr_capa_2nd_validation_external') {
			$array_fields = array('DISTINCT(qc_'.$monitoring.'_by)');
		} else if($table == 'tbl_qfr_capa_3rd_validation_external') {
			$array_fields = array('DISTINCT(qad_'.$monitoring.'_by)');
		}  
		
		// $array_fields = ($table == 'tbl_qfr_capa_1st_monitoring' ? array('DISTINCT(qs_'.$monitoring.'_by)') : ($table == 'tbl_qfr_capa_2nd_validation_external' ? array('DISTINCT(qc_'.$monitoring.'_by)') : array('DISTINCT(qad_'.$monitoring.'_by)')));
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$cc			= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			// $qs_monitoring = ($table == 'tbl_qfr_capa_1st_monitoring' ? explode(',',$row['qs_'.$monitoring.'_by']) : $table == 'tbl_qfr_capa_2nd_validation_external' ? explode(',',$row['qc_'.$monitoring.'_by']) : explode(',',$row['qad_'.$monitoring.'_by']));
			if($table == 'tbl_qfr_capa_1st_monitoring') {
				$qs_monitoring	= explode(',',$row['qs_'.$monitoring.'_by']);
			} else if($table == 'tbl_qfr_capa_2nd_validation_external') {
				$qs_monitoring	= explode(',',$row['qc_'.$monitoring.'_by']);
			} else if($table == 'tbl_qfr_capa_3rd_validation_external') {
				$qs_monitoring	= explode(',',$row['qad_'.$monitoring.'_by']);
			}  
			foreach($qs_monitoring as $key => $username) {
				$cc[] = return_user_email_add($username);
			}
		}
		if($table == 'tbl_qfr_capa_1st_monitoring') {
			$action = 'monitoring';
		} else {
			$action = 'validation';
		}
		$subject 	 = 'CAPA '.strtoupper($action).' FOR CHECKING: Ctrl #:'.$control_no.' ('.str_replace('_',' ',$monitoring).')';
		
		$body 	 	 = 'Please be informed that you have CAPA '.$action.' for checking ('.str_replace('_',' ',$monitoring).').<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br>';
		
		/* Select recipients */
		$to			= array();
		$to_array  	= explode(',', $checked_by);
		for($i=0; $i<count($to_array); $i++) {
			$to[] = return_user_email_add($to_array[$i]);
		}
		$to 		= implode(',',$to);
		$cc 		= implode(',',$cc);
		$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc, $subject, $body,'','');
		return $script;
	}
	
	function send_email_qs_inspector_from_supervisor($fk_capa, $monitoring, $username, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$subject 	 = $status.' CAPA MONITORING: Ctrl #:'.$control_no.' ('.str_replace('_',' ',$monitoring).')';
		
		$body 	 	 = 'Please be informed that '.str_replace('_',' ',$monitoring).' CAPA monitoring has been '.strtolower($status).'<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br>';
		
		$to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
		return $script;
	}
	
	function send_email_qs_inspector_from_conformance($fk_capa, $monitoring, $username, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$subject 	 = $status.' CAPA MONITORING: Ctrl #:'.$control_no.' ('.str_replace('_',' ',$monitoring).')';
		
		$body 	 	 = 'Please be informed that '.str_replace('_',' ',$monitoring).' CAPA monitoring has been '.strtolower($status).'<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br>';
		
		$to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
		return $script;
	}
	
	function send_email_qs_supervisor_for_posting($fk_capa, $fk_capa_correction) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_correction';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$fk_capa.'" AND pkid="'.$fk_capa_correction.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$monitoring_type 		= $row['monitoring_type'];
			$correction_action 		= $row['correction_action'];
			$due_date 				= date('M d, Y',strtotime($row['due_date']));
			$incharge_person_array = explode(',',$row['incharge_person']);
			$incharge_person			= '';
			for($i=0;$i<count($incharge_person_array);$i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).', ';
			}
		}
		
		$subject 	 = $monitoring_type.' ACTION APPROVAL: Ctrl #:'.$control_no;
		
		$body 	 	 = 'Please be informed that you have '.strtolower($monitoring_type).' action for approval prior posting to QC/QAD.<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br><br>';
		$body 		.= ucfirst($monitoring_type).' details: <br>';
		$body 		.= '&emsp;Action: '.$correction_action.' <br>';
		$body 		.= '&emsp;In-charge Person: '.$incharge_person.' <br>';
		$body 		.= '&emsp;Due Date: '.$due_date.' <br>';
		
		/* Select recipients */
		$to			= return_assigned_qs_supervisor_edit();
		$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		$php_mailer = new email();
		$php_mailer->send_email($to['user_email'], $from, $from, $subject, $body,'','');
	}
	
	function send_email_qs_inspector_from_supervisor_post($fk_capa, $fk_capa_correction, $username, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_correction';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$fk_capa.'" AND pkid="'.$fk_capa_correction.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$monitoring_type 		= $row['monitoring_type'];
			$correction_action 		= $row['correction_action'];
			$due_date 				= date('M d, Y',strtotime($row['due_date']));
			$incharge_person_array = explode(',',$row['incharge_person']);
			$incharge_person			= '';
			for($i=0;$i<count($incharge_person_array);$i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).', ';
			}
		}
		
		$subject 	 = strtoupper($status).' '.$monitoring_type.' ACTION: Ctrl #:'.$control_no;
		
		$body 	 	 = 'Please be informed that your '.strtolower($monitoring_type).' action has been '.strtolower($status).'.<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br><br>';
		$body 		.= ucfirst($monitoring_type).' details: <br>';
		$body 		.= '&emsp;Action: '.$correction_action.' <br>';
		$body 		.= '&emsp;In-charge Person: '.$incharge_person.' <br>';
		$body 		.= '&emsp;Due Date: '.$due_date.' <br>';
		
		/* Select recipients */
		$to 		= (return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by)) . ',' . return_assigned_qc_qad_edit();
		$cc			= return_assigned_qs_supervisor_edit();
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc['user_email'], $subject, $body,'','');
	}
	
	function send_email_qs_inspector_from_amup_post($fk_capa, $fk_capa_correction, $username, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_correction';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$fk_capa.'" AND pkid="'.$fk_capa_correction.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$monitoring_type 		= $row['monitoring_type'];
			$correction_action 		= $row['correction_action'];
			$due_date 				= date('M d, Y',strtotime($row['due_date']));
			$incharge_person_array = explode(',',$row['incharge_person']);
			$incharge_person			= '';
			for($i=0;$i<count($incharge_person_array);$i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).', ';
			}
		}
		
		$subject 	 = strtoupper($status).' '.$monitoring_type.' ACTION: Ctrl #:'.$control_no;
		
		$body 	 	 = 'Please be informed that your '.strtolower($monitoring_type).' action has been '.strtolower($status).'.<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br><br>';
		$body 		.= ucfirst($monitoring_type).' details: <br>';
		$body 		.= '&emsp;Action: '.$correction_action.' <br>';
		$body 		.= '&emsp;In-charge Person: '.$incharge_person.' <br>';
		$body 		.= '&emsp;Due Date: '.$due_date.' <br>';
		
		/* Select recipients */
		$to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$cc			= return_assigned_qc_qad_ampup_edit();
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc['user_email'], $subject, $body,'','');
	}
	
	function send_email_capa_validation_from_ampup($fk_capa, $monitoring, $username, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$subject 	 = $status.' CAPA MONITORING: Ctrl #:'.$control_no.' ('.str_replace('_',' ',$monitoring).')';
		
		$body 	 	 = 'Please be informed that '.str_replace('_',' ',$monitoring).' CAPA monitoring has been '.strtolower($status).'<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br>';
		
		$to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
		return $script;
	}
	
	function send_email_qs_supervisor_closed_capa($fk_capa, $fk_capa_correction, $username) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fk_capa.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$control_no 		= $row['control_no'];
			$classification 	= $row['classification'];
			$product_mode 		= $row['product_mode'];
			$received_date 		= date('M d, Y',strtotime($row['received_date']));
			$capa_received 		= date('M d, Y',strtotime($row['capa_received']));
			$failure_mode 		= $row['failure_mode'];
			$customer 			= $row['customer'];
			$assigned_line_array = explode(',',$row['assigned_line']);
			$assigned_line			= '';
			for($i=0;$i<count($assigned_line_array);$i++) {
				$assigned_line .= get_emp_name_by_username_systemone($assigned_line_array[$i]).', ';
			}
		}
		
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_correction';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$fk_capa.'" AND pkid="'.$fk_capa_correction.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$monitoring_type 		= $row['monitoring_type'];
			$correction_action 		= $row['correction_action'];
			$due_date 				= date('M d, Y',strtotime($row['due_date']));
			$incharge_person_array = explode(',',$row['incharge_person']);
			$incharge_person			= '';
			for($i=0;$i<count($incharge_person_array);$i++) {
				$incharge_person .= get_emp_name_by_username_systemone($incharge_person_array[$i]).', ';
			}
		}
		
		$subject 	 = 'CAPA VALIDATION: '.$monitoring_type.' ACTION CLOSED (Ctrl #:'.$control_no.')';
		
		$body 	 	 = 'Please be informed that '.strtolower($monitoring_type).' action has been closed by QAD.<br> <br>';
		$body 		.= 'CAPA details: <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Control #: '.$control_no.' <br>';
		$body 		.= '&emsp;Classification: '.$classification.' <br>';
		$body 		.= '&emsp;Product / Mode : '.$product_mode.' <br>';
		$body 		.= '&emsp;Received Date: '.$received_date.' <br>';
		$body 		.= '&emsp;Failure Mode: '.$failure_mode.' <br>';
		$body 		.= '&emsp;Customer: '.$customer.' <br>';
		$body 		.= '&emsp;Assigned LineJS/SS: '.$assigned_line.' <br><br>';
		$body 		.= ucfirst($monitoring_type).' details: <br>';
		$body 		.= '&emsp;Action: '.$correction_action.' <br>';
		$body 		.= '&emsp;In-charge Person: '.$incharge_person.' <br>';
		$body 		.= '&emsp;Due Date: '.$due_date.' <br>';
		
		/* Select recipients */
		$to			= return_assigned_qs_supervisor_edit();
		$created_by_email = return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to['user_email'].','.$created_by_email, $from, $from, $subject, $body,'','');
	}
	
	function return_assigned_qs_supervisor_edit() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$array_fields = array('user');
		$table 	   	= 'vw_user_roles';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `module`="CAPA-Operations QS Supervisor" and `read`=1 AND `update`=1';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			if(return_user_email_add($row['user']) != 'NONE') {
				$user_email[] 			= return_user_email_add($row['user']);		
				$user_name[] 			= $row['user'];		
			}
		}
		$user	= array();
		$user['user_name'] 	= implode(',',$user_name);
		$user['user_email'] = implode(',',$user_email);
		return $user;
	}
	
	function return_assigned_qc_qad_ampup_edit() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$array_fields = array('user');
		$table 	   	= 'vw_user_roles';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `module`="CAPA-QC and QAD AM-up" and `read`=1 AND `update`=1';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			if(return_user_email_add($row['user']) != 'NONE') {
				$user_email[] 			= return_user_email_add($row['user']);		
				$user_name[] 			= $row['user'];		
			}
		}
		$user	= array();
		$user['user_name'] 	= implode(',',$user_name);
		$user['user_email'] = implode(',',$user_email);
		return $user;
	}
	
	function return_assigned_qc_qad_edit() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$array_fields = array('user');
		$table 	   	= 'vw_user_roles';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `module`="CAPA-QC and QAD AM-up" and `read`=1 AND `update`=1';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			if(return_user_email_add($row['user']) != 'NONE') {
				$user_email[] 			= return_user_email_add($row['user']);		
				$user_name[] 			= $row['user'];		
			}
		}
		$user	= array();
		$user['user_name'] 	= implode(',',$user_name);
		$user['user_email'] = implode(',',$user_email);
		return $user;
	}
	
	function check_capa_classification() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$pkid		= $_POST['pkid'];
		$array_fields = array('`classification`');
		$table 	   	= 'tbl_qfr_capa_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND `classification`="External" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);		
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);		
		$return['classification'] = $result->num_rows == 1 ? 'External' : 'Internal';
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function check_capa_2nd_monitoring() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$pkid		= $_POST['pkid'];
		$array_fields = array('`pkid`');
		$table 	   	= 'tbl_qfr_capa_2nd_validation_external';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);		
		$return['rows'] = $result->num_rows;
		echo json_encode($return);
	}
	
	function get_capa_correction_details() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$pkid		= $_POST['pkid'];
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_correction';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$array_incharge_person = explode(",",$row['incharge_person']);
			$row['incharge_person'] 			= array();
			foreach($array_incharge_person as $key => $value){
				$array_ip 						= array();
				$array_ip['id'] 				= $value;
				$array_ip['text'] 				= get_emp_name_by_username_systemone($value);
				$row['incharge_person'][]		= $array_ip;
			}
			$return['data'] = $row;
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function update_correction_details() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$result = "";
		$pkid		= $_POST['pkid'];
		$username	= $_POST['username'];
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_capa_correction';
		$values 	= get_fields_values($_POST,array("action","username"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "lastupdate"; 		$array_values[] = $date_time_today;
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 					= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$return['msg'] = $msg;
		echo json_encode($return);
	}
	
	function update_monitoring_details() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$result = "";
		$fkcapa					= $_POST['fkcapa'];
		$fkcorrection			= $_POST['fkcorrection'];
		$username				= $_POST['username'];
		$user					= $_POST['user_group'].'_';
		$monitoring_number		= $_POST['monitoring_number'];
		$monitoring_by			= $_POST['monitoring_by'];
		$monitoring_date		= $_POST['monitoring_date'];
		$monitoring_result		= $_POST['monitoring_result'];
		$table					= $_POST['tbl_id'];
		
		/* Upload file attachment first */	
		if ($_FILES['monitoring_attachment']["tmp_name"] != '' ) {
			$file  		     = return_file_path_by_div_mod('qfr_capa_main');
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];
			$temp_file 	     = $_FILES["monitoring_attachment"]["tmp_name"];
			$file_name 	     = $_FILES["monitoring_attachment"]["name"];
			$target_file 	 = $target_dir . $file_name;
			if (move_uploaded_file($temp_file, $target_file)) {
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$new_file_name  = $pkid.".".$ext;
				if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
					$msg .= 'File was successfully uploaded to the system';
					$array_fields 			= array($user.$monitoring_number.'_by', $user.$monitoring_number.'_date', $user.$monitoring_number.'_result', 'file_name', 'fkfile_path');
					$array_values 			= array($monitoring_by, $monitoring_date, $monitoring_result, $file_name, $fkfile_path);
				} else {
					$msg .= 'There was an error on renaming the file.';
				}					
			} else {
				$msg .= "Sorry, there was an error uploading your file.".$file_name;
			}
			
		} else {			
			$array_fields 			= array($user.$monitoring_number.'_by', $user.$monitoring_number.'_date', $user.$monitoring_number.'_result');
			$array_values 			= array($monitoring_by, $monitoring_date, $monitoring_result);
		}
				
		$sql_where				= 'WHERE fk_capa="'.$fkcapa.'" AND fk_capa_correction="'.$fkcorrection.'" AND logdel=0';
		$msg 					= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		$script 				= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$sql_where);
		$return['msg'] = $msg;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function update_capa_main_details() {
		
	}
	
	function return_editable_monitoring() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$fk_capa_correction		= $_POST['pkid'];
		$user					= $_POST['user'];
		$field					= $_POST['field'];
		
		if($user == 'qs') {
			$array_fields = array('*');
			$table 	   	= 'tbl_qfr_capa_1st_monitoring';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fk_capa_correction="'.$fk_capa_correction.'" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result_details = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
			$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$html_select = '<option value="">-</option>';
			if($row = mysqli_fetch_array($result_details)) {
				for($i=1; $i<13; $i++) {
					$field_name_by 		= return_monitoring_field($user.'_', $i).$field.'_by';
					$field_name_date 	= return_monitoring_field($user.'_', $i).$field.'_date';
					$val = explode("_",$field_name_date);	
					if($row[$field_name_by] != '') {					
						/* Check if data is already CHECKED/REJECTED by user */
						$array_fields = array('*');
						$table 	   	= 'tbl_qfr_capa_correction';
						$joins 	   	= '';
						$sql_where 	= 'WHERE pkid="'.$fk_capa_correction.'" AND '.return_monitoring_field('', $i).$field.'_checked_by_date'.' LIKE "%CHECKED%" AND logdel=0';
						$sql_order 	= '';
						$sql_limit 	= '';
						$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
						$script .= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
						if($result->num_rows == 0) {
							$html_select .= '<option value="'.$val[1].'_'.$val[2].'">'.$val[1].' '.$val[2].'</option>';
						}
					}
				}
			}
		} else if($user == 'qc') {
			$array_fields = array('*');
			$table 	   	= 'tbl_qfr_capa_2nd_validation_external';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fk_capa_correction="'.$fk_capa_correction.'" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result_details = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
			$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$html_select = '<option value="">-</option>';
			if($row = mysqli_fetch_array($result_details)) {
				for($i=1; $i<13; $i++) {
					$field_name_by 		= return_monitoring_field($user.'_', $i).$field.'_by';
					$field_name_date 	= return_monitoring_field($user.'_', $i).$field.'_date';
					$val = explode("_",$field_name_date);				
					if($row[$field_name_by] != '') {
						/* Check if data is already CHECKED/REJECTED by user */
						$array_fields = array('*');
						$table 	   	= 'tbl_qfr_capa_correction';
						$joins 	   	= '';
						$sql_where 	= 'WHERE pkid="'.$fk_capa_correction.'" AND '.return_monitoring_field('', $i).$field.'_checked_by_date'.' LIKE "%CHECKED%" AND logdel=0';
						$sql_order 	= '';
						$sql_limit 	= '';
						$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
						$script .= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
						if($result->num_rows == 0) {
							$html_select .= '<option value="'.$val[1].'_'.$val[2].'">'.$val[1].' '.$val[2].'</option>';
						}
					}
				}
			}
		} else if($user == 'qad') {
			$array_fields = array('*');
			$table 	   	= 'tbl_qfr_capa_3rd_validation_external';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fk_capa_correction="'.$fk_capa_correction.'" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result_details = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
			$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$html_select = '<option value="">-</option>';
			if($row = mysqli_fetch_array($result_details)) {
				for($i=1; $i<4; $i++) {
					$field_name_by 		= return_monitoring_field($user.'_', $i).$field.'_by';
					$field_name_date 	= return_monitoring_field($user.'_', $i).$field.'_date';
					$val = explode("_",$field_name_date);				
					if($row[$field_name_by] != '') {
						/* Check if data is already CHECKED/REJECTED by user */
						$array_fields = array('*');
						$table 	   	= 'tbl_qfr_capa_correction';
						$joins 	   	= '';
						$sql_where 	= 'WHERE pkid="'.$fk_capa_correction.'" AND '.return_monitoring_field('', $i).$field.'_checked_by_date'.' LIKE "%CHECKED%" AND logdel=0';
						$sql_order 	= '';
						$sql_limit 	= '';
						$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
						$script .= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
						if($result->num_rows == 0) {
							$html_select .= '<option value="'.$val[1].'_'.$val[2].'">'.$val[1].' '.$val[2].'</option>';
						}
					}
				}
			}
		}
		$return['user'] = $user;
		$return['html_select'] = $html_select;
		$return['script'] = $script.'  '.$field_name_by;
		$return['POST'] = $_POST;
		echo json_encode($return);
	}
	
	function return_monitoring_data_by_field() {
		require_once('../class/oop_tqts.php');
		$result = "";
		$fk_capa			= $_POST['fk_capa'];
		$fk_capa_correction = $_POST['fk_capa_correction'];
		$user				= $_POST['user'];
		$field				= $_POST['field'];
		$table				= $_POST['tbl_id'];
		$field_array		= explode("_",$_POST['field']);
		// $fk_capa			= 2;
		// $fk_capa_correction = 4;
		// $user				= 'qs';
		// $_POST['field']		= '6th_monitoring';
		// $table				= 'tbl_qfr_capa_1st_monitoring';
		$field_by			= $user.'_'.$field.'_by';
		$field_date			= $user.'_'.$field.'_date';
		$field_result		= $user.'_'.$field.'_result';
		$field_attach		= $user.'_'.$field.'_attachment';
		
		$array_fields = array($field_by, $field_date, $field_result, $field_attach);
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_capa="'.$fk_capa.'" AND fk_capa_correction="'.$fk_capa_correction.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);			
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select = '<option value="">-</option>';
		if($row = mysqli_fetch_array($result)) {
			$return['monitoring_date'] 		= $row[$field_date];
			$return['monitoring_result']	= $row[$field_result];
			$return['file_capa_attachment'] = $row[$field_attach];
			$return['order'] 				= strstr($field_array[0], "st") ? str_replace("st","",$field_array[0]) : (strstr($field_array[0], "nd") ? str_replace("nd","",$field_array[0]) : (strstr($field_array[0], "rd") ? str_replace("rd","",$field_array[0]) : (str_replace("th","",$field_array[0]))));
			
			$array_monitoring_by = explode(",",$row[$field_by]);
			$row['monitoring_by'] 			= array();
			foreach($array_monitoring_by as $key => $value){
				$array_mb 					= array();
				$array_mb['id'] 			= $value;
				$array_mb['text'] 			= get_emp_name_by_username_systemone($value);
				$return['monitoring_by'][]	= $array_mb;
			}
			
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	
	

	
	
?>