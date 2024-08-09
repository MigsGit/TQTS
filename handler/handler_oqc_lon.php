<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
				/* OQC DIR */
				case "generate_lon_no"							: generate_lon_no(); break;
				case "get_lon_disposition_lists"				: get_lon_disposition_lists(); break;
				case "save_lqc_inspector"						: save_lqc_inspector(); break;
				case "edit_lqc_inspector"						: edit_lqc_inspector(); break;
				case "get_lon_details_by_pkid"					: get_lon_details_by_pkid(); break;
				case "edit_lqc_supervisor"						: edit_lqc_supervisor(); break;
				case "save_lqc_supervisor_decision"				: save_lqc_supervisor_decision(); break;
				case "save_lqc_manager_decision"				: save_lqc_manager_decision(); break;
				case "save_production_disposition"				: save_production_disposition(); break;
				case "get_mode_defect_details"					: get_mode_defect_details(); break;
				case "edit_production_disposition"				: edit_production_disposition(); break;
				case "save_lqc_inspector_conformance_decision"	: save_lqc_inspector_conformance_decision(); break;
				case "save_lqc_cancel"							: save_lqc_cancel(); break;
				case "check_inspector_attachment"				: check_inspector_attachment(); break;
				case "lon_file_re_upload"						: lon_file_re_upload(); break; //nmodify

				/* OQC CAPA MONITORING */
				case "save_oqc_capa_monitoring"					: save_oqc_capa_monitoring(); break;
				case "read_oqc_capa_monitoring_by_id"			: read_oqc_capa_monitoring_by_id(); break;

				

				/* OQC Common */
				case "get_email_recipients_list"				: get_email_recipients_list(); break;
				
				
				/* Advanced Search */
				// case "oqc_dir_return_dir_fields"				: oqc_dir_return_dir_fields(); break;
				// case "oqc_dir_advance_search"				: oqc_dir_advance_search(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	function lon_file_re_upload(){
		try {
			require_once('../class/oop_tqts.php');
			$return = $_POST;
			$reponse = array();
			$date_time_today = date('Y-m-d H:i:s');
			$tbl_oqc_lon_production_id     	= $return['tbl_oqc_lon_production_id'];
			$file  		     				= return_file_path_by_div_mod('oqc_lot_out_notice_production');
			$fkfile_path     				= $file['pkid'];
			$target_dir      				= $file['path'];
			$temp_file 	     				= $_FILES["file_lon_re_upload"]["tmp_name"];
			$file_name 	     				= $_FILES["file_lon_re_upload"]["name"];
			$ext = pathinfo($file_name,PATHINFO_EXTENSION);
			$target_file = $target_dir . $tbl_oqc_lon_production_id . '.' . $ext;
			$reponse['is_success'] = 'true';
			$reponse['message'] = 'Saved Succefully';
			echo json_encode($reponse);
			return;
			if ( move_uploaded_file($temp_file,$target_file) ){
				$reponse['is_success'] = 'true';
				$reponse['message'] = 'Saved Succefully';
				$table = 'tbl_oqc_lon_production';
				$array_fields = array('file_name','updated_by','lastupdate');
				$array_values = array($file_name,$return['username'],$date_time_today);
				$where =' WHERE fklon =  '.$tbl_oqc_lon_production_id.'';
				// $msg 						= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
				$script 					= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
			}else{
				$reponse['message'] = 'Invalid file, Please Try Again !';
			}
			echo json_encode($reponse);
		} catch (\Throwable $th) {
			$reponse['is_success'] = 'false';
			$reponse['message'] = $th;
			echo json_encode($reponse);
		}
		
	}
	
	function save_oqc_capa_monitoring (){
		try {
			require_once('../class/oop_tqts.php');
			$return 		= $_POST;
			$reponse = array();
			$date_time_today = date('Y-m-d H:i:s');
			$oqc_lon_capa_monitoring_id =  $return['oqc_lon_capa_monitoring_id'];
			$arr_oqc_capa_action_incharge =  implode(',',$return['oqc_capa_action_incharge']);
			if($return['oqc_capa_status'] == "Open"){ 
				$field_data 	= get_fields_values($_POST,array('action','oqc_lon_capa_monitoring_id','username','oqc_capa_req_sub_date','oqc_capa_actual_sub_date'));
			}else{
				$field_data 	= get_fields_values($_POST,array('action','oqc_lon_capa_monitoring_id','username'));
			}
			/* get field data from post */
			$array_fields   = $field_data['array_fields'];
			$array_values   = $field_data['array_values'];
			/* add blanks to undefined or empty values */
			foreach($array_fields as $key => $value){
				if(!isset($return[$value]) || $return[$value] == ""){
					$return[$value] = "";
				}
			}
			$table			= 'tbl_oqc_lon_capa_monitoring';
			if($oqc_lon_capa_monitoring_id == ""){ //ADD
				/* add additional fields */
				$array_fields[]	= 'created_by'; 	$array_values[] = $_POST['username'];
				$array_fields[]	= 'created_at'; 	$array_values[] = date('Y-m-d H:i:s');
				$script 		= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
				$query 		= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			}else{ //EDIT
				
				/* add additional fields */
				$array_fields[]	= 'updated_by'; 	$array_values[] = $_POST['username'];
				$array_fields[]	= 'updated_at'; 	$array_values[] = date('Y-m-d H:i:s');
				$where 			= "WHERE id = '$oqc_lon_capa_monitoring_id'";
				$script 		= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
				$query 			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
			}
			$reponse['is_success'] = 'true';
			$reponse['message'] = 'Saved Succefully';
			echo json_encode($reponse);
		} catch (\Throwable $th) {
			$reponse['is_success'] = 'false';
			$reponse['message'] = $th;
			echo json_encode($reponse);
		}
	}
	function read_oqc_capa_monitoring_by_id (){
		try {
			require_once('../class/oop_tqts.php');
			$return 		= $_POST;
			$reponse = array();
			$read_oqc_capa_monitoring_by_id 		= $return['oqc_lon_capa_monitoring_id'];
			$table  			= "tbl_oqc_lon_capa_monitoring";
			$array_fields		= array("*");
			$joins  	 		= "";
			$sql_where  		= "WHERE 1=1 AND id='".$read_oqc_capa_monitoring_by_id."' AND logdel=0";
			$sql_order  		= "";
			$sql_limit  		= "LIMIT 0,1";
			$result        		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);	
			if($row = mysqli_fetch_array($result)) {
				$reponse['id'] 					= $row['id'];
				$reponse['oqc_capa_action'] 	= $row['oqc_capa_action'];
				$arr_oqc_capa_action_incharge = explode(',',$row['oqc_capa_action_incharge']);
				$reponse['oqc_capa_due_date'] 	= $row['oqc_capa_due_date'];
				$reponse['oqc_capa_status'] 	= $row['oqc_capa_status'];
				$reponse['oqc_capa_req_sub_date'] 		= $row['oqc_capa_req_sub_date'];
				$reponse['oqc_capa_actual_sub_date'] 	= $row['oqc_capa_actual_sub_date'];
				$reponse['oqc_capa_remarks'] 			= $row['oqc_capa_remarks'];

				foreach ($arr_oqc_capa_action_incharge as $key => $value) {
					$array_data_app 				= array();
					$array_data_app['id'] 			= $value;
					$array_data_app['text'] 		= get_emp_name_by_username_systemone($value);
					$reponse['oqc_capa_action_incharge'][]	= $array_data_app;
				}
			}
			// echo json_encode($arr_oqc_capa_action_incharge);
			// return; cnpoblete,cbretusto
			
			$reponse['is_success'] = 'true';
			$reponse['message'] = 'Saved Succefully';
			echo json_encode($reponse);
		} catch (\Throwable $th) {
			$reponse['is_success'] = 'false';
			$reponse['message'] = $th;
			echo json_encode($reponse);
		}
	}
	/* LON - START */
	
	function generate_lon_no(){
		require_once('../class/oop_tqts.php');
		$return['lon_no'] 	= return_lon_no();
		$return['section'] 	= return_system_division();
		echo json_encode($return);
	}
	
	function return_lon_no(){
		require_once('../class/oop_tqts.php');
		$section			= isset($_POST['section']) ? $_POST['section'] : return_system_division();
		$table  			= "tbl_oqc_lon";
		$array_fields		= array("*");
		$joins  	 		= "";
		$sql_where  		= "WHERE section='".$section."' AND lon_ctr !=  '' AND logdel=0";
		$sql_order  		= "ORDER BY pkid DESC";
		$sql_limit  		= "LIMIT 0,1";
		$result        		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);				
		$current_month = date('m');
		$row 				= mysqli_fetch_array($result);
		if((int)$current_month >= 4 && (int)$current_month <= 12) {
			$sql_where		= 'WHERE (date_time_created BETWEEN "'.date('Y', strtotime($row['date_time_created'].'-1')).'-04-01" AND "'.date('Y').'-12-31") AND logdel=0';
			$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($result->num_rows == 0) {
				$last_ctrl	= 1;
			} else {				
				$last_ctrl	= $row['lon_ctr'] + 1;
			}
		} else {			
			$last_ctrl		= $row['lon_ctr'] + 1;
		}
		$script        	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$last_ctrl		= str_pad($last_ctrl,3,0,STR_PAD_LEFT);
		$lon_no 		= $section.'-'.date("my").'-'.$last_ctrl;
		return $lon_no;
	}
	
	function get_lon_disposition_lists() {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('disposition');
		$table			= 'tbl_oqc_lon_disposition';
		$joins			= '';
		$sql_where		= 'WHERE logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$html_select	= '<option value="">-</option>';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['disposition'].'">'.$row['disposition'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function save_lqc_inspector() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$msg			 = '';		
				
		$_POST['attention'] 	= implode(",",$_POST['attention']);
		$_POST['operator'] 		= implode(",",$_POST['operator']);
		$_POST['verified_by'] 	= implode(",",$_POST['verified_by']);
		$lon_no 				= return_lon_no();
		$lon_no 				= explode("-",$lon_no);
		/* Get all fields to be inserted */		
		$table 						= "tbl_oqc_lon";
		$values 					= get_fields_values($_POST,array("action","username","lon_no","attention_logs","attention_remarks","lon_ctr","rev_no","checked_by_status","checked_by_logs","checked_by_remarks","capa_due_date","cc","approved_by_status","approved_by_logs","approved_by_remarks","status","cancel_by", "cancel_logs", "cancel_remarks"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "status"; 			$array_values[] = 'FOR CHECKING LQC SUPERVISOR';
		$array_fields[] 			= "lon_ctr"; 			$array_values[] = end($lon_no);
		$array_fields[] 			= "rev_no"; 			$array_values[] = '0';
		$array_fields[] 			= "checked_by_status"; 	$array_values[] = "PENDING";
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);

		/* Upload attachment */
		if($_FILES["file_lon"]["tmp_name"] != '') {
			$file  		     	= return_file_path_by_div_mod('oqc_lot_out_notice_inspector');
			$fkfile_path     	= $file['pkid'];
			$target_dir      	= $file['path'];
			$temp_file 	     	= $_FILES["file_lon"]["tmp_name"];
			$file_name 	     	= $_FILES["file_lon"]["name"];
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
					
					$array_fields 				= array("file_name", "fkfile_path");
					$array_values 				= array($file_name, $fkfile_path);
					$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 					.= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
				
			}
		}
		
		/* Send email to LQC supervisor */
		send_email_lqc_supervisor($pkid, 'new');
		
		$return['msg'] 	= 'New record has been saved'.$msg;
		$return['script'] 	= $script;
		$return['POST'] 	= $_POST;
		$return['FILES'] 	= $_FILES["file_lon"];
		echo json_encode($return);
	}
	
	function edit_lqc_inspector() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$pkid 			 = $_POST["pkid"];
		$username    	 = $_POST['username'];
		// $lon_no 		 = explode("-",$_POST['lon_no']);
		$lon_no_with_rev = explode(" Rev. ",$_POST['lon_no']);
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_oqc_lon";
		$values 					= get_fields_values($_POST,array("action","username","attention_logs","attention_remarks","lon_no","rev_no","verified_by_","checked_by_status","checked_by_logs","checked_by_remarks","capa_due_date","cc","approved_by_status","approved_by_logs","approved_by_remarks","status"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "status"; 			$array_values[] = 'FOR CHECKING LQC SUPERVISOR';
		$array_fields[] 			= "rev_no"; 			$array_values[] = $lon_no_with_rev[1];
		$array_fields[] 			= "checked_by_status"; 	$array_values[] = "PENDING";
		$array_fields[] 			= "checked_by_logs"; 	$array_values[] = "";
		$array_fields[] 			= "checked_by_remarks"; $array_values[] = "";
		$array_fields[] 			= "approved_by_status"; $array_values[] = "";
		$array_fields[] 			= "approved_by_logs"; 	$array_values[] = "";
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 					= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		
		/* Send email to LQC supervisor */
		send_email_lqc_supervisor($pkid, 'edit');
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_lqc_supervisor($pkid, $action) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$section 			= $row['section'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$checked_by 		= $row['checked_by'];	
			$attention			= '';
			for($i=0;$i<count($attention_array);$i++) {
				$attention .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
			}
		}
		if($action == 'new') {
			$subject 	 = 'FOR CHECKING LON: '.$po_number.' '.$device_name;
		} else if($action == 'edit') {
			$subject 	 = 'FOR CHECKING LON (Revised): '.$po_number.' '.$device_name;
		}  
		
		$body 	 	 = 'Please be informed that you have LON for checking.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br>';
		
		/* Select recipients */
		$to			= return_user_email_add($checked_by) == 'NONE' ? '' : return_user_email_add($checked_by);
		$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		 //nmodify
		// $php_mailer = new email();
		// $php_mailer->send_email($to, $from, $from, $subject, $body,'','');
	}
	
	function get_lon_details_by_pkid() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$action2 						= $_POST["action2"];
		$table  						= "tbl_oqc_lon";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		$return['lon_no_w_rev']			= '';
		if($row = mysqli_fetch_assoc($result)){
			$return['lon_no']			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$return['lon_no_w_rev']		= $return['lon_no'].' Rev. '.$row['rev_no'];
			$return['status']			= $row['status'];
			$return['created_by_qc']			= $row['created_by'];
			
			if($action2 == 'edit') {
				$array_attention = explode(",",$row['attention']);
				$row['attention'] = array();
				foreach($array_attention as $key => $value){
					$array_data_attn 				= array();
					$array_data_attn['id'] 			= $value;
					$array_data_attn['text'] 		= get_emp_name_by_username_systemone($value);
					$row['attention'][]				= $array_data_attn;
				}
				$array_verified_by = explode(",",$row['verified_by']);
				$row['verified_by'] 	= array();
				foreach($array_verified_by as $key => $value){
					$array_data_vfy 				= array();
					$array_data_vfy['id'] 			= $value;
					$array_data_vfy['text'] 		= get_emp_name_by_username_systemone($value);
					$row['verified_by'][]			= $array_data_vfy;
				}
				$array_operator = explode(",",$row['operator']);
				$row['operator'] = array();
				foreach($array_operator as $key => $value){
					$array_data_ope 				= array();
					$array_data_ope['id'] 			= $value;
					$array_data_ope['text'] 		= $value;
					$row['operator'][]				= $array_data_ope;
				}
				$array_checked_by = explode(",",$row['checked_by']);
				$row['checked_by'] 	= array();
				foreach($array_checked_by as $key => $value){
					$array_data_chk 				= array();
					$array_data_chk['id'] 			= $value;
					$array_data_chk['text'] 		= get_emp_name_by_username_systemone($value);
					$row['checked_by'][]			= $array_data_chk;
				}
				$array_approved_by 		= explode(",",$row['approved_by']);
				$row['approved_by'] 	= array();
				foreach($array_approved_by as $key => $value){
					$array_data_app 				= array();
					$array_data_app['id'] 			= $value;
					$array_data_app['text'] 		= get_emp_name_by_username_systemone($value);
					$row['approved_by'][]			= $array_data_app;
				}
				$array_cc 				= explode(",",$row['cc']);
				$row['cc'] 				= array();
				foreach($array_cc as $key => $value){
					$array_data_cc 				= array();
					$array_data_cc['id'] 		= $value;
					$array_data_cc['text'] 		= get_emp_name_by_username_systemone($value);
					$row['cc'][]				= $array_data_cc;
				}
			} else if($action2 == 'add'){
				$array_cc 				= explode(",",$row['cc']);
				$row['cc'] 				= array();
				foreach($array_cc as $key => $value){
					$array_data_cc 				= array();
					$array_data_cc['id'] 		= $value;
					$array_data_cc['text'] 		= get_emp_name_by_username_systemone($value);
					$row['cc'][]				= $array_data_cc;
				}
				
				// $array_verified_by = explode(",",$row['verified_by']);
				// $row['verified_by'] 	= array();
				// foreach($array_verified_by as $key => $value){
					// $array_data_vfy 				= array();
					// $array_data_vfy['id'] 			= $value;
					// $array_data_vfy['text'] 		= get_emp_name_by_username_systemone($value);
					// $row['verified_by'][]			= $array_data_vfy;
				// }
			}
			$return['data'][0]	= $row;
		}		
		$table  						= "tbl_oqc_lon_production";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `fklon` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			$return['data_1']	= 'NO DATA';
		} else {
			if($row = mysqli_fetch_assoc($result)){
				$return['data'][1]	= $row;
				$return['data_1']	= 'HAVE DATA';
			}
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function edit_lqc_supervisor() {
		require_once('../class/oop_tqts.php');
		$date_time_today 		= date('Y-m-d H:i:s');
		$pkid 			 		= $_POST["pkid"];
		$username    	 		= $_POST['username'];
		$lon_no_with_rev 		= explode(" Rev. ",$_POST['lon_no']);
		$msg			 		= '';		
		
		$_POST['attention'] 	= implode(",",$_POST['attention']);
		$_POST['operator'] 		= implode(",",$_POST['operator']);
		$_POST['verified_by'] 	= implode(",",$_POST['verified_by']);
		$_POST['cc'] 			= !isset($_POST['cc']) ? '' : implode(",",$_POST['cc']);
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_oqc_lon";
		$values 					= get_fields_values($_POST,array("action","username","attention_logs","attention_remarks","lon_no","rev_no","checked_by_status","checked_by_logs","approved_by_status","approved_by_logs","approved_by_remarks","status","cancel_by", "cancel_logs", "cancel_remarks"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "status"; 			$array_values[] = 'ACCEPTED BY LQC SUPERVISOR';
		// $array_fields[] 			= "lon_ctr"; 			$array_values[] = $lon_no_with_rev[0];
		$array_fields[] 			= "rev_no"; 			$array_values[] = $lon_no_with_rev[1];
		$array_fields[] 			= "checked_by_status"; 	$array_values[] = "ACCEPT";
		$array_fields[] 			= "checked_by_logs"; 	$array_values[] = $date_time_today;
		$array_fields[] 			= "approved_by_status"; $array_values[] = "";
		$array_fields[] 			= "approved_by_logs"; 	$array_values[] = "";
		$array_fields[] 			= "approved_by_remarks";$array_values[] = "";
		$array_fields[] 			= "lastupdate"; 		$array_values[] = $date_time_today;
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 					= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		
		/* Upload attachment */
		if($_FILES["file_lon"]["tmp_name"] != '') {
			$file  		     	= return_file_path_by_div_mod('oqc_lot_out_notice_inspector');
			$fkfile_path     	= $file['pkid'];
			$target_dir      	= $file['path'];
			$temp_file 	     	= $_FILES["file_lon"]["tmp_name"];
			$file_name 	     	= $_FILES["file_lon"]["name"];
			$target_file 	 	= $target_dir . $file_name;	
			if (move_uploaded_file($temp_file, $target_file)) {	
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$new_file_name  = $pkid.".".$ext;
				if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
					$msg .= '<br>File was successfully uploaded to the system';
				} else {
					$msg .= '<br>There was an error on renaming the file.';
				}	
				
				$array_fields 				= array("file_name", "fkfile_path");
				$array_values 				= array($file_name, $fkfile_path);
				$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
				$script 				   .= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
			}
		}
		
		/* Send email to LQC supervisor */
		send_email_lqc_supervisor($pkid, 'edit');
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		$return['POST'] 	= $_POST;
		echo json_encode($return);
	}
	
	function save_lqc_supervisor_decision() {
		require_once('../class/oop_tqts.php');
		$date_time_today    = date('Y-m-d H:i:s');
		$pkid 			    = $_POST["pkid"];
		$decision 		    = $_POST["decision"];
		$capa_due_date 		= $_POST["capa_due_date"];
		$cc_array 			= !isset($_POST["cc"]) ? '' : $_POST["cc"];
		$checked_by_remarks = $_POST["checked_by_remarks"];
		$username    	    = $_POST['username'];
		$msg			    = '';		
		echo 'true';
		return;
		if($decision != '') {
			$status = $decision.'ED BY LQC SUPERVISOR';			
		} else {
			$status = 'ERROR APPROVAL(LQC SUPERVISOR)';
		}
		
		$cc = $cc_array == '' ? '' : implode(',',$cc_array);
		
		if($decision == 'ACCEPT') { //if accept, make the status of approved_by as PENDING
			$array_fields 	= array('status', 'capa_due_date', 'cc', 'checked_by_status', 'checked_by_logs', 'checked_by_remarks', 'approved_by_status', 'lastupdate', 'username');
			$array_values 	= array($status, $capa_due_date, $cc, $decision, $date_time_today, $checked_by_remarks, 'PENDING', $date_time_today,$username);
		} else {
			$rev_no = get_latest_lon_no_rev($pkid) + 1;
			$array_fields 	= array('status', 'rev_no', 'capa_due_date', 'cc', 'checked_by_status', 'checked_by_logs', 'checked_by_remarks', 'lastupdate', 'username');
			$array_values 	= array($status, $rev_no, $capa_due_date, $cc, $decision, $date_time_today, $checked_by_remarks, $date_time_today,$username);
		}
		$table			= 'tbl_oqc_lon';		
		$sql_where		= 'WHERE pkid='.$pkid.' AND `checked_by`="'.$username.'" AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$sql_where);

		/* Send email to LQC Inspector */
		send_email_lqc_inspector_from_lqc_supervisor($pkid, $decision); //nmodify
		
		$return['msg'] 		= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_lqc_inspector_from_lqc_supervisor($pkid, $decision) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$section 			= $row['section'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$verified_by 		= $row['verified_by'];	
			$username 			= $row['username'];	
			$attention			= '';
			for($i=0;$i<count($attention_array);$i++) {
				$attention .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
			}
		}
		if($decision != '') {
			$subject 	 = $decision.' LON: '.$po_number.' '.$device_name;
		} else {
			$subject 	 = 'ERROR APPROVAL(LQC SUPERVISOR) LON: '.$po_number.' '.$device_name;
		} 
		
		$body 	 	 = 'Please be informed that your request has been '.strtolower($decision).'.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br>';
		
		/* Select recipients */
		$to			= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		// $php_mailer = new email();
		// $php_mailer->send_email($to, $from, $from, $subject, $body,'','');
	}
	
	function save_lqc_manager_decision() {
		require_once('../class/oop_tqts.php');
		$date_time_today     = date('Y-m-d H:i:s');
		$pkid 			     = $_POST["pkid"];
		$decision 		     = $_POST["decision"];
		$approved_by_remarks = $_POST["approved_by_remarks"];
		$username    	     = $_POST['username'];		
		$msg			     = '';		
		
		if($decision != '') {
			$status = $decision.' BY LQC MANAGER';
			if($decision == 'APPROVED') {
				$rev_no = get_latest_lon_no_rev($pkid);
			} else {
				$rev_no = get_latest_lon_no_rev($pkid) + 1;
			}
		} else {
			$status = 'ERROR APPROVAL(LQC MANAGER)';
			$rev_no = 0;
		}
		
		$table_details	= 'tbl_oqc_lon';		
		$array_fields 	= array('status', 'rev_no', 'approved_by_status', 'approved_by_logs', 'approved_by_remarks', 'lastupdate', 'username');
		$array_values 	= array($status, $rev_no, $decision, $date_time_today, $approved_by_remarks, $date_time_today,$username);
		$sql_where		= 'WHERE pkid='.$pkid.' AND `approved_by`="'.$username.'" AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);

		/* Send email to LQC Inspector */
		send_email_from_lqc_manager($pkid, $decision); //nmodify
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_from_lqc_manager($pkid, $decision) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$section 			= $row['section'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$checked_by 		= $row['checked_by'];	
			$approved_by 		= $row['approved_by'];	
			$attention			= '';
			for($i=0;$i<count($attention_array);$i++) {
				$attention .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
			}
		}
		if($decision != '') {
			$subject 	 = $decision.' LON: '.$po_number.' '.$device_name;
		} else {
			$subject 	 = 'ERROR APPROVAL(LQC SUPERVISOR) LON: '.$po_number.' '.$device_name;
		} 
		
		$body 	 	 = 'Please be informed that your request has been '.strtolower($decision).'.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br>';
		
		/* Select recipients */
		$to			= array();
		$to[]		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by); //send to LQC inspector
		$to[]		= return_user_email_add($checked_by) == 'NONE' ? '' : return_user_email_add($checked_by); //send to LQC supervisor
		$to = implode(',',$to);
		$from 		= return_user_email_add($approved_by) == 'NONE' ? '' : return_user_email_add($approved_by);
		
		// $php_mailer = new email();
		// $php_mailer->send_email($to, $from, $from, $subject, $body,'','');
		
		if($decision == 'APPROVED') {
			//create daily notification for CAPA reminder
			create_lon_daily_email($pkid);
		}
	}
	
	function save_production_disposition() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$username    	 	= $_POST['username'];
		$fklon    	 	 	= $_POST['fklon'];
		$production_remarks = $_POST['production_remarks'];
		$sorted_qty  		= $_POST['sorted_qty'];
		$ok_qty  			= $_POST['ok_qty'];
		$ng_qty  			= $_POST['ng_qty'];
		$mode_defect  		= $_POST['mode_defect'];
		$guaranteed_lot  	= $_POST['guaranteed_lot'];
		$file  		     	= return_file_path_by_div_mod('oqc_lot_out_notice_production');
		$fkfile_path     	= $file['pkid'];
		$target_dir      	= $file['path'];
		$temp_file 	     	= $_FILES["file_lon"]["tmp_name"];
		$file_name 	     	= $_FILES["file_lon"]["name"];
		$target_file 	 	= $target_dir . $file_name;
		$msg			 	= '';
		
		if (file_exists($target_file)) {
			$msg 					= "Sorry, your file already exists.";
			$return['error']		= $msg;
		} else {
			if (move_uploaded_file($temp_file, $target_file)) {				
				/* Update main table status */
				$conform_by			= '';
				$table_details		= 'tbl_oqc_lon';	
				$array_fields		= array("attention", "checked_by");
				$joins  	 		= "";
				$sql_where  		= "WHERE pkid='".$fklon."' AND logdel=0";
				$sql_order  		= "";
				$sql_limit  		= "LIMIT 0,1";
				$result        		= TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) {
					$attention_array  = explode(",",$row['attention']);
					$attention_array2 = array();
					foreach($attention_array as $key => $value) {
						$attention_array2[] = $value;
					}
					$attention_index = array_search($username, $attention_array2);
					$attention_logs_array  = array();
					for($i=0; $i<count($attention_array); $i++) {
						if($i == $attention_index) {
							$attention_logs_array[] = $date_time_today;
						} else {
							$attention_logs_array[] = '';
						}
					}
					$attention_logs = implode(',',$attention_logs_array);
					$conform_by		= $row['checked_by'];
				}
				$array_fields 	= array('status', 'attention_logs', 'lastupdate', 'username');
				$array_values 	= array('UPLOADED DISPOSITION', $attention_logs, $date_time_today,$username);
				$sql_where		= 'WHERE pkid='.$fklon.' AND (`attention` LIKE "%'.$username.'%") AND logdel=0';
				$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
				$script 		= TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);
				
				/* Update details table attachment file_name date_time_created nmodify*/
				/*CAPA report received date date_time_created nmodify*/
				$table 			 = 'tbl_oqc_lon_production';
				$array_fields 	 = array('date_time_created', 'created_by', 'fklon', 'sorted_qty', 'ok_qty', 'ng_qty', 'mode_defect', 'guaranteed_lot', 'file_name', 'fkfile_path', 'production_remarks', 'conform_by', 'conform_by_status', 'lastupdate', 'username');
				$array_values 	 = array($date_time_today,$username,$fklon,$sorted_qty,$ok_qty,$ng_qty,$mode_defect,$guaranteed_lot,$file_name,$fkfile_path,$production_remarks,$conform_by,'FOR CONFORMANCE',$date_time_today,$username);
				$pkid_attachment = TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
				$script 		.= TQTS::getInstance()->insert_query_id_script($table,$array_fields,$array_values);
				
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$new_file_name  = $fklon.".".$ext;
				if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
					$msg .= '<br>File was successfully uploaded to the system';
					/* Stop daily email notification alert on "Follow-up of CAPA" */
					$table_mailer 			= 'db_mailer.tbl_auto_mailer';
					$array_fields_mailer 	= array('logdel');
					$array_values_mailer 	= array('1');
					$sql_where_mailer		= 'WHERE fkid="'.$fklon.'" AND table_name="tbl_oqc_lon" AND system_name="TQTS"';
					$msg_mailer 			= TQTS::getInstance()->update_query_detailed($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
					$script 			   .= TQTS::getInstance()->update_query_detailed_script($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				} else {
					$msg .= '<br>There was an error on renaming the file.';
				}	
			}
			
		}
		/* Send email to LQC Inspector */
		$msg = $msg .'<br>'.send_email_from_production($fklon);
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function get_mode_defect_details() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$fklon    	 	 	= $_POST['fklon'];
		$tbl_body			= '';		
		$table 			 	= 'tbl_oqc_lon_production';
		$array_fields		= array("mode_defect");
		$joins  	 		= "";
		$sql_where  		= "WHERE fklon='".$fklon."' AND logdel=0";
		$sql_order  		= "ORDER BY pkid";
		$sql_limit  		= "";
		$result        		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$mode_defect	= explode(',',$row['mode_defect']);
			foreach($mode_defect as $key => $value) {
				$tbl_body .= '<tr>';
				$tbl_body .= '	<td>'.$value.'</td>';
				$tbl_body .= '	<td><a href="#" class="fa fa-remove"> Remove</a></td>';
				$tbl_body .= '</tr>';
			}
			$return['mode_defect'] 	= $mode_defect;
		}
		
		$return['tbl_body'] 	= $tbl_body;
		echo json_encode($return);
	}
	
	function update_production_mode_defect() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$fklon    	 	 	= $_POST['fklon'];
		$mode_defect    	= $_POST['mode_defect'];
		/* Update details table attachment */
		$table_prdn		 = 'tbl_oqc_lon_production';
		$array_fields 	 = array('mode_defect', 'lastupdate', 'username');
		$array_values 	 = array($mode_defect,$date_time_today,$username);
		$pkid_attachment = TQTS::getInstance()->insert_query_id($table_prdn,$array_fields,$array_values);
		
		$return['tbl_body'] 	= $tbl_body;
		echo json_encode($return);
	}
	
	function edit_production_disposition() {
		require_once('../class/oop_tqts.php');
		$date_time_today 	= date('Y-m-d H:i:s');
		$username    	 	= $_POST['username'];
		$fklon    	 	 	= $_POST['fklon'];
		$production_remarks = $_POST['production_remarks'];
		$sorted_qty  		= $_POST['sorted_qty'];
		$ok_qty  			= $_POST['ok_qty'];
		$ng_qty  			= $_POST['ng_qty'];
		$guaranteed_lot  	= $_POST['guaranteed_lot'];
		$mode_defect  		= $_POST['mode_defect'];
		$file  		     	= return_file_path_by_div_mod('oqc_lot_out_notice_production');
		$fkfile_path     	= $file['pkid'];
		$target_dir      	= $file['path'];
		$temp_file 	     	= $_FILES["file_lon"]["tmp_name"];
		$file_name 	     	= $_FILES["file_lon"]["name"];
		$target_file 	 	= $target_dir . $file_name;
		$msg			 	= '';
		
		// if (file_exists($target_file)) {
		// 	$msg 					= "Sorry, your file already exists.";
		// 	$return['error']		= $msg;
		// 	$script		= '';
		// } else {
			if (move_uploaded_file($temp_file, $target_file)) {				
				/* Update main table status */
				$conform_by			= '';
				$table_main			= 'tbl_oqc_lon';	
				$array_fields		= array("attention", "checked_by");
				$joins  	 		= "";
				$sql_where  		= "WHERE pkid='".$fklon."' AND logdel=0";
				$sql_order  		= "";
				$sql_limit  		= "LIMIT 0,1";
				$result        		= TQTS::getInstance()->select_query($array_fields,$table_main,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) {
					$attention_array  = explode(",",$row['attention']);
					$attention_array2 = array();
					foreach($attention_array as $key => $value) {
						$attention_array2[] = $value;
					}
					$attention_index = array_search($username, $attention_array2);
					$attention_logs_array  = array();
					for($i=0; $i<count($attention_array); $i++) {
						if($i == $attention_index) {
							$attention_logs_array[] = $date_time_today;
						} else {
							$attention_logs_array[] = '';
						}
					}
					$attention_logs = implode(',',$attention_logs_array);
					$conform_by		= $row['checked_by'];
				}
				
				$array_fields 	= array('status', 'attention_logs', 'lastupdate', 'username');
				$array_values 	= array('UPLOADED DISPOSITION', $attention_logs, $date_time_today,$username);
				// $sql_where		= 'WHERE pkid='.$fklon.' AND (`attention` LIKE "%'.$username.'%") AND logdel=0';
				$sql_where		= 'WHERE pkid='.$fklon.' AND logdel=0';
				$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
				$script 		= TQTS::getInstance()->update_query_detailed_script($table_main,$array_fields,$array_values,$sql_where);
				
				/* Update details table attachment */
				$table_prdn		 = 'tbl_oqc_lon_production';
				$array_fields 	 = array('sorted_qty', 'ok_qty', 'ng_qty', 'guaranteed_lot', 'mode_defect', 'file_name', 'fkfile_path', 'production_remarks', 'conform_by', 'conform_by_status', 'lastupdate', 'username');
				$array_values 	 = array($sorted_qty,$ok_qty,$ng_qty,$guaranteed_lot,$mode_defect,$file_name,$fkfile_path,$production_remarks,$conform_by,'FOR CONFORMANCE',$date_time_today,$username);
				$sql_where		= 'WHERE fklon='.$fklon.' AND logdel=0';
				$msg 			= TQTS::getInstance()->update_query_detailed($table_prdn,$array_fields,$array_values,$sql_where);
				$script 		= TQTS::getInstance()->update_query_detailed_script($table_main,$array_fields,$array_values,$sql_where);
				
				$ext = pathinfo($target_file, PATHINFO_EXTENSION);
				$new_file_name  = $fklon.".".$ext;
				if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
					$msg .= '<br>File was successfully uploaded to the system';
				} else {
					$msg .= '<br>There was an error on renaming the file.';
				}	
			}
		// }
		/* Send email to LQC Inspector */
		send_email_from_production($fklon);
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_from_production($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$cc_array	= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$section 			= $row['section'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$verified_by 		= $row['verified_by'];	
			$approved_by 		= $row['approved_by'];	
			$username 			= $row['username'];	
			$attention			= '';
			for($i=0;$i<count($attention_array);$i++) {
				$attention 	   .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
				$cc_array[]		= return_user_email_add($attention_array[$i]) == 'NONE' ? '' : return_user_email_add($attention_array[$i]);
			}
			$cc_array[]			= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by); 
		}
		
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon_production';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fklon="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$sorted_qty 		= $row['sorted_qty'];
			$ok_qty 			= $row['ok_qty'];
			$ng_qty 			= $row['ng_qty'];
			$guaranteed_lot 	= $row['guaranteed_lot'];
			$conform_by 		= $row['conform_by'];
		}
		
		$subject 	 = 'FOR CONFORMANCE: '.$po_number.' '.$device_name;
		$body 	 	 = 'Please be informed that you have request for conformance.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br> <br>';
		$body 		.= '<hr>Production <br>';
		$body 		.= '&emsp;Sorted Qty.: '.$sorted_qty.'<br>';
		$body 		.= '&emsp;OK: '.$ok_qty.'<br>';
		$body 		.= '&emsp;NG: '.$ng_qty.'<br>';
		
		/* Select recipients */
		$to			 = return_user_email_add($conform_by) == 'NONE' ? '' : return_user_email_add($conform_by); 
		$cc 		 = implode(',', $cc_array);
		$from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		// $php_mailer = new email();
		// $php_mailer->send_email($to, $from, $cc, $subject, $body,'','');
	}
	
	function save_lqc_inspector_conformance_decision() { //nmodify
		require_once('../class/oop_tqts.php');
		$date_time_today    = date('Y-m-d H:i:s');
		$pkid 			    = $_POST["pkid"];
		$decision 		    = $_POST["decision"];
		$treatment 			= $_POST["treatment"];
		$verification_result= $_POST["verification_result"];
		$conform_by_remarks = $_POST["conform_by_remarks"];
		$username    	    = $_POST['username'];
		$msg			    = '';		
		// echo send_email_from_inspector_conformance($pkid); //save_lqc_inspector_conformance_decision
		// return;
		if($decision != '') {
			$status = $decision.'ED BY OQC INSPECTOR';		
			if($decision == 'CONFORMED') {
				$rev_no = get_latest_lon_no_rev($pkid);
			} else {
				$rev_no = get_latest_lon_no_rev($pkid) + 1;
			}			
		} else {
			$status = 'ERROR APPROVAL(OQC INSPECTOR)';
		}
		/* Update Main table */
		$table_main		= 'tbl_oqc_lon';		
		$array_fields 	= array('status', 'rev_no', 'lastupdate', 'username');
		$array_values 	= array($status, $rev_no, $date_time_today,$username);
		$sql_where		= 'WHERE pkid='.$pkid.' AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table_main,$array_fields,$array_values,$sql_where);
		
		/* Update details table */
		$table_main		= 'tbl_oqc_lon_production';		
		$array_fields 	= array('treatment', 'verification_result', 'conform_by_status', 'conform_by_logs', 'conform_by_remarks', 'lastupdate', 'username');
		$array_values 	= array($treatment, $verification_result,$decision, $date_time_today,$conform_by_remarks, $date_time_today,$username);
		$sql_where		= 'WHERE fklon='.$pkid.' AND conform_by="'.$username.'" AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table_main,$array_fields,$array_values,$sql_where);

		/* Send email to LQC Inspector */
		send_email_from_inspector_conformance($pkid,$decision);
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_from_inspector_conformance($pkid,$decision) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$cc_array	= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$section 			= $row['section'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$verified_by 		= $row['verified_by'];	
			$approved_by 		= $row['approved_by'];	
			$username 			= $row['username'];	
			$attention			= '';
			for($i=0;$i<count($attention_array);$i++) {
				$attention 	   .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
				$attention 	   .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
				$cc_array[]		= return_user_email_add($attention_array[$i]) == 'NONE' ? '' : return_user_email_add($attention_array[$i]);
			}
				$cc_array[]		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by); 
			}
		
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon_production';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fklon="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$sorted_qty 		= $row['sorted_qty'];
			$ok_qty 			= $row['ok_qty'];
			$ng_qty 			= $row['ng_qty'];
			$guaranteed_lot 	= $row['guaranteed_lot'];
			$created_by_prodn 		= $row['created_by'];
		}
		
		$subject 	 = ''.$decision.'ED Lot-out Notice: '.$po_number.' '.$device_name;
		$body 	 	 = 'Please be informed that your request for conformance has been '.$decision.'ED. Kindly re-upload the file <br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br> <br>';
		$body 		.= '<hr>Production <br>';
		$body 		.= '&emsp;Sorted Qty.: '.$sorted_qty.'<br>';
		$body 		.= '&emsp;OK: '.$ok_qty.'<br>';
		$body 		.= '&emsp;NG: '.$ng_qty.'<br>';
		
		/* Select recipients */
		$to			 = return_user_email_add('mclegaspi') == 'NONE' ? '' : return_user_email_add('mclegaspi'); 
		$cc 		 = '';
		$from 		 = return_user_email_add('cdcasuyon') == 'NONE' ? '' : return_user_email_add('cdcasuyon');

		// $to			 = return_user_email_add($created_by_prodn) == 'NONE' ? '' : return_user_email_add($created_by_prodn); 
		// $cc 		 = implode(',', $cc_array);
		// $from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc, $subject, $body,'','');
	}
	
	// function send_email_from_inspector_conformance($pkid) {
	// 	require_once('../class/oop_tqts.php');
	// 	require_once('../class/send_email.php');
	// 	/* Select the report information */
	// 	$result = "";
	// 	$array_fields = array('*');
	// 	$table 	   	= 'tbl_oqc_lon';
	// 	$joins 	   	= '';
	// 	$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
	// 	$sql_order 	= '';
	// 	$sql_limit 	= 'LIMIT 0, 1';
	// 	$cc_array	= array();
	// 	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// 	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// 	if($row = mysqli_fetch_array($result)){
	// 		$created_by 		= $row['created_by'];
	// 		$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
	// 		$section 			= $row['section'];
	// 		$attention_array	= explode(',',$row['attention']);
	// 		$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
	// 		$po_number 		    = $row['po_number'];
	// 		$ypics_data 		= get_series_name($row['po_number']);
	// 		$device_name		= $ypics_data['device_name'];
	// 		$lot_no 		    = $row['lot_number'];
	// 		$lot_qty 			= $row['lot_qty'];
	// 		$disposition 		= $row['disposition'];	
	// 		$verified_by 		= $row['verified_by'];	
	// 		$approved_by 		= $row['approved_by'];	
	// 		$username 			= $row['username'];	
	// 		$attention			= '';
	// 		for($i=0;$i<count($attention_array);$i++) {
	// 			$attention 	   .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
	// 			$attention 	   .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
	// 			$cc_array[]		= return_user_email_add($attention_array[$i]) == 'NONE' ? '' : return_user_email_add($attention_array[$i]);
	// 		}
	// 			$cc_array[]		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by); 
	// 		}
		
	// 	$array_fields = array('*');
	// 	$table 	   	= 'tbl_oqc_lon_production';
	// 	$joins 	   	= '';
	// 	$sql_where 	= 'WHERE fklon="'.$pkid.'" AND logdel=0';
	// 	$sql_order 	= '';
	// 	$sql_limit 	= 'LIMIT 0, 1';
	// 	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// 	$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// 	if($row = mysqli_fetch_array($result)){
	// 		$sorted_qty 		= $row['sorted_qty'];
	// 		$ok_qty 			= $row['ok_qty'];
	// 		$ng_qty 			= $row['ng_qty'];
	// 		$guaranteed_lot 	= $row['guaranteed_lot'];
	// 		$created_by_prodn 		= $row['created_by'];
	// 	}
		
	// 	$subject 	 = 'FOR CONFORMANCE: '.$po_number.' '.$device_name;
	// 	$body 	 	 = 'Please be informed that you have request for conformance.<br> <br>';
	// 	$body 		.= 'Request details: <br>';
	// 	$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
	// 	$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
	// 	$body 		.= '&emsp;Section: '.$section.' <br>';
	// 	$body 		.= '&emsp;Attention: '.$attention.' <br>';
	// 	$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
	// 	$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
	// 	$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
	// 	$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
	// 	$body 		.= '&emsp;Disposition: '.$disposition.' <br> <br>';
	// 	$body 		.= '<hr>Production <br>';
	// 	$body 		.= '&emsp;Sorted Qty.: '.$sorted_qty.'<br>';
	// 	$body 		.= '&emsp;OK: '.$ok_qty.'<br>';
	// 	$body 		.= '&emsp;NG: '.$ng_qty.'<br>';
		
	// 	/* Select recipients */
	// 	$to			 = return_user_email_add($created_by_prodn) == 'NONE' ? '' : return_user_email_add($created_by_prodn); 
	// 	$cc 		 = implode(',', $cc_array);
	// 	$from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
	// 	// $php_mailer = new email();
	// 	// $php_mailer->send_email($to, $from, $cc, $subject, $body,'','');
	// }
		
	function save_lqc_cancel() {
		require_once('../class/oop_tqts.php');
		$date_time_today    = date('Y-m-d H:i:s');
		$pkid 			    = $_POST["pkid"];
		$cancel_remarks		= $_POST["cancel_remarks"];
		$status    	    	= $_POST['status'];
		$username    	    = $_POST['username'];
		$msg			    = '';		
		
		/* Update Main table */
		$table_main		= 'tbl_oqc_lon';		
		$array_fields 	= array('status', 'cancel_by', 'cancel_logs', 'cancel_remarks', 'lastupdate', 'username');
		$array_values 	= array($status, $username, $date_time_today,$cancel_remarks, $date_time_today,$username);
		$sql_where		= 'WHERE pkid='.$pkid.' AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table_main,$array_fields,$array_values,$sql_where);
		
		/* Send email to LQC Inspector */
		send_email_cancelled($pkid);
		
		/* Stop daily email notification alert on "Follow-up of CAPA" */
		$table_mailer 			= 'db_mailer.tbl_auto_mailer';
		$array_fields_mailer 	= array('logdel');
		$array_values_mailer 	= array('1');
		$sql_where_mailer		= 'WHERE fkid="'.$pkid.'" AND table_name="tbl_oqc_lon" AND system_name="TQTS"';
		$msg_mailer 			= TQTS::getInstance()->update_query_detailed($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
		$script 			   .= TQTS::getInstance()->update_query_detailed_script($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_cancelled($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$cc_array	= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$section 			= $row['section'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$checked_by 		= $row['checked_by'];	
			$verified_by 		= $row['verified_by'];	
			$approved_by 		= $row['approved_by'];	
			$username 			= $row['username'];	
			$attention			= '';
			for($i=0;$i<count($attention_array);$i++) {
				$attention 	   .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
				$cc_array[]		= return_user_email_add($attention_array[$i]) == 'NONE' ? '' : return_user_email_add($attention_array[$i]);
			}
			$cc_array[]			= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by); 
		}
		$subject 	 = 'CANCELLED LON: '.$po_number.' '.$device_name;
		$body 	 	 = 'Please be informed that your request has been cancelled.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;LON #: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br> <br>';
		/* Select recipients */
		$to			 = return_user_email_add($checked_by) == 'NONE' ? '' : return_user_email_add($checked_by); 
		$cc 		 = implode(',', $cc_array);
		$from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		// $php_mailer = new email();
		// $php_mailer->send_email($to, $from, $cc, $subject, $body,'','');
	}
	
	function check_inspector_attachment() {
		require_once('../class/oop_tqts.php');
		$pkid		= $_POST['pkid'];
		$array_fields = array('tbl_oqc_lon.fkfile_path as inspector', 'tbl_oqc_lon_production.fkfile_path as production');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= 'INNER JOIN tbl_oqc_lon_production ON tbl_oqc_lon_production.fklon = tbl_oqc_lon.pkid';
		$sql_where 	= 'WHERE tbl_oqc_lon.pkid="'.$pkid.'" AND ((tbl_oqc_lon.fkfile_path != "0" AND tbl_oqc_lon.file_name != "") OR (tbl_oqc_lon_production.fkfile_path != "0" AND tbl_oqc_lon_production.file_name != "" )) ';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$return['inspector'] 	= $row['inspector'];
			$return['production'] 	= $row['production'];
		} else {
			$return['inspector'] 	= 0;
			$return['production'] 	= 0;
		}
		echo json_encode($return);
	}
	
	function get_email_recipients_list() {
        require_once('../class/oop_tqts.php');
		$array_fields = array('CONCAT(firstname, " ",lastname) as emp_name', 'email_add');
		$table 	   	= 'db_hris.vw_emp_hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpStatus=1 AND (email_add != "kiosk@pricon.ph" AND email_add != "" AND email_add != "kiosk@pricon.ph ")';
		$sql_order 	= 'ORDER BY firstname';
		$sql_limit 	= '';
		$html_select= '';
		$result = SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row=mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['email_add'].'">'.$row['emp_name'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
    }
	
	function get_latest_lon_no_rev($pkid) {
		require_once('../class/oop_tqts.php');
		$table  		= "tbl_oqc_lon";
		$array_fields	= array("rev_no");
		$joins  	 	= "";
		$sql_where  	= "WHERE `pkid` = '$pkid'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			return $row['rev_no'];
		} else {
			return 0;
		}
	}
		
	function create_lon_daily_email($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_oqc_lon';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$to 		= array();
		$cc 		= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$lon_no 			= $row['section'].'-'.date('my', strtotime($row['date_time_created'])).'-'.$row['lon_ctr'];
			$section 			= $row['section'];
			$attention_array	= explode(',',$row['attention']);
			$date_inspected 	= date('M d, Y',strtotime($row['date_inspected']));
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$device_name		= $ypics_data['device_name'];
			$lot_no 		    = $row['lot_number'];
			$lot_qty 			= $row['lot_qty'];
			$disposition 		= $row['disposition'];	
			$checked_by 		= $row['checked_by'];	
			$approved_by 		= $row['approved_by'];	
			$verified_by 		= $row['verified_by'];	
			$capa_due_date 		= $row['capa_due_date'];	
			$defect_mode 		= $row['defect_mode'];	
			$cc_array			= explode(',', $row['cc']);	
			$attention			= '';
			for($i=0;$i<count($cc_array);$i++) {
				$cc[] = return_user_email_add($cc_array[$i]) == 'NONE' ? '' : return_user_email_add($cc_array[$i]);
			}
			$cc[]	  = return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$cc[]	  = return_user_email_add($checked_by) == 'NONE' ? '' : return_user_email_add($checked_by);
			$cc[]	  = return_user_email_add($verified_by) == 'NONE' ? '' : return_user_email_add($verified_by);
			$cc[]	  = return_user_email_add($approved_by) == 'NONE' ? '' : return_user_email_add($approved_by);
			for($i=0;$i<count($attention_array);$i++) {
				$attention .= get_emp_name_by_username_systemone($attention_array[$i]).', ';
				$to[] 		= return_user_email_add($attention_array[$i]) == 'NONE' ? '' : return_user_email_add($attention_array[$i]);
			}
		}
		$subject 	 = 'FOLLOW-UP CAPA (Due Date: '.date('M d, Y', strtotime($capa_due_date)).') Defect mode: '.$defect_mode;
		
		$body 	 	 = 'Good day! <br> A follow-up regarding CAPA submission.<br> <br>';
		$body 		.= 'LON details: <br>';
		$body 		.= '&emsp;LON No.: '.$lon_no.' <br>';
		$body 		.= '&emsp;Date Inspected: '.$date_inspected.' <br>';
		$body 		.= '&emsp;Section: '.$section.' <br>';
		$body 		.= '&emsp;Attention: '.$attention.' <br>';
		$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
		$body 		.= '&emsp;Device Name: '.$device_name.' <br>';
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Lot Qty.: '.$lot_qty.' <br>';
		$body 		.= '&emsp;Defect Mode: '.$defect_mode.' <br>';
		$body 		.= '&emsp;Disposition: '.$disposition.' <br>';
		
		/* Select recipients */
		$to 		= implode(',',$to);
		$cc 		= implode(',',$cc);
		$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		// $php_mailer = new email();
		// $php_mailer->send_scheduled_email('tbl_oqc_lon', $pkid, $to, $from, $cc, $subject, $body , $capa_due_date, '2');
		//nmodify
	}
	
	/* **********************
		Advance Search
	 ********************** */
	 // function oqc_dir_return_dir_fields(){
		// $ctr = 0;
		// $option		  =	array();
		// $option[$ctr] = '<option value="po_number">P.O. Number</option>'; $ctr++;
		// $option[$ctr] = '<option value="series_name">Series Name</option>'; $ctr++;
		// $option[$ctr] = '<option value="shipment_date">Shipment Date</option>'; $ctr++;
		// $option[$ctr] = '<option value="customer">Customer</option>'; $ctr++;
		// $option[$ctr] = '<option value="remarks">Remarks</option>'; $ctr++;
		// $option[$ctr] = '<option value="filename">Filename</option>'; $ctr++;
		// $option[$ctr] = '<option value="created_by">Uploaded By</option>'; $ctr++;
		// $return['option'] 	= $option;
		// $return['ctr'] 		= $ctr;
		// echo json_encode($return);
	 // }
	 
	 // function oqc_dir_advance_search() {
		// require_once('../class/oop_tqts.php');
		// $field_name	= array();
		// $condition	= array();
		// $value		= array();
		// $field_name = $_POST['field_name'];
		// $condition 	= $_POST['condition'];
		// $value	 	= $_POST['val'];
		
		// $sql_where		= '';
		// $sql_where_and	= array();
		// $sql_where_or	= array();
		// foreach($field_name as $key => $fieldn) {
			// if($condition[$key] == "EQUALS") {
				// $sql_where_and[] = ' ('.$fieldn.'="'.$value[$key].'")';
			// } else if($condition[$key] == "LIKE") {
				// $sql_where_or[] = ' ('.$fieldn.' LIKE "%'.$value[$key].'%")';
			// } else if($condition[$key] == "BETWEEN"){
				// $date_range = explode(' - ', $value[$key]);
				// $date_start = date('Y-m-d',strtotime($date_range[0]));
				// $date_end 	= date('Y-m-d',strtotime($date_range[1]));
				// $sql_where_and[] = ' ('.$fieldn.' BETWEEN "'.$date_start.'" AND "'.$date_end.'")';
			// }
		// }
		// $sql_where_and = implode(' AND', $sql_where_and);
		// $sql_where_or = implode(' OR', $sql_where_or);
		// if($sql_where_and != '' && $sql_where_or != '') {
			// $sql_where		= 'WHERE (logdel=0) AND '.$sql_where_and.' AND '.$sql_where_or;
		// } else if($sql_where_and != '' && $sql_where_or == '') {
			// $sql_where		= 'WHERE (logdel=0) AND '.$sql_where_and;
		// } else if($sql_where_and == '' && $sql_where_or != '') {
			// $sql_where		= 'WHERE (logdel=0) AND '.$sql_where_or;
		// }
		
		// $result['sql_where'] = $sql_where;
		// echo json_encode($result);
	// }
?>