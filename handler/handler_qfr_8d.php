<?php

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
				/* 8D */
				case "get_8d_approvers"							: get_8d_approvers(); break;
				case "save_8d"									: save_8d(); break;
				case "load_po_datalist" 						: load_po_datalist(); break;
				case "get_po_details" 							: get_po_details(); break;
				case "return_8d_attachments" 					: return_8d_attachments(); break;
				case "return_final_8d_attachment" 				: return_final_8d_attachment(); break;
				case "remove_8d_attachment" 					: remove_8d_attachment(); break;
				case "load_8d_main_data" 						: load_8d_main_data(); break;
				case "edit_8d" 									: edit_8d(); break;
				case "get_8d_approvers_log" 					: get_8d_approvers_log(); break;
				case "validate_is_approver" 					: validate_is_approver(); break;
				case "approver_8d_comment" 						: approver_8d_comment(); break;
				case "remove_8d_approver_attachment" 			: remove_8d_approver_attachment(); break;
				case "requestor_8d_comment" 					: requestor_8d_comment(); break;
				case "admin_save_final_report" 					: admin_save_final_report(); break;
				
				/* advance search */
				case "qfr_8d_return_dir_fields" 				: qfr_8d_return_dir_fields(); break;
				case "qfr_8d_advance_search" 					: qfr_8d_advance_search(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* 8D Start */
	
	function get_8d_approvers(){
		require_once('../class/oop_tqts.php');
		$array_fields = array('approver_username', 'approver_name');
		$table 	   	= 'tbl_report_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_module=15 AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select = '<option></option>';
		while($row = mysqli_fetch_array($result)){
			$html_select .= '<option value="'.$row['approver_username'].'">'.$row['approver_name'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function save_8d(){
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$approvers 		 = json_decode($_POST["approvers"]);
		$file  		     = return_file_path_by_div_mod('qfr_8d_initial');
		$username    	 = $_POST['username'];
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];
		$return['error'] = array();
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_qfr_8d";
		$values 					= get_fields_values($_POST,array("action","username","file_8d","approver","approvers","device_name","rev_no"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "status"; 			$array_values[] = "OPEN";
		$array_fields[] 			= "rev_no"; 			$array_values[] = 0;
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);		
		
		/* Upload the file to target directory */
		// for($i=0;$i<count($_FILES['file_8d']['name']);$i++) {
			// $temp_file 	     = $_FILES["file_8d"]["tmp_name"][$i];
			// $file_name 	     = $_FILES["file_8d"]["name"][$i];
			$temp_file 	     = $_FILES["file_8d"]["tmp_name"];
			$file_name 	     = $_FILES["file_8d"]["name"];
			$target_file 	 = $target_dir . $file_name;
			if (file_exists($target_file)) {
				$msg 					= "Sorry, your file already exists.";
				$return['error']		= $msg;
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					/* Rename the file based on pkid of Quality Report */					
					$table 			= 'tbl_qfr_8d_attachments_initial';
					$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'file_name', 'fkfile_path', 'lastupdate', 'username');
					$array_values 	= array($date_time_today,$username,$pkid,$file_name,$fkfile_path,$date_time_today,$username);
					$pkid_attachment= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
					$script 		.= TQTS::getInstance()->insert_query_id_script($table,$array_fields,$array_values);
					
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid."_".($pkid_attachment).".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg .= 'File was successfully uploaded to the system';
					} else {
						$msg .= 'There was an error on renaming the file.';
					}	
				} else {
					$msg .= "Sorry, there was an error uploading your file.".$temp_file.' - '.$file_name.' ('.$i;
				}
				$return['array_fields']		= $array_fields;
				$return['array_fields']		= $array_values;
				$return['files']			= $_FILES;
			}
		// }
		
		/* Save selected approvers */
		$table			= 'tbl_qfr_8d_approvers';
		$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'fk8d_attachment_initial', 'approver_username', 'status', 'lastupdate', 'username');
		foreach($approvers as $approver_username) {
			$array_values 	= array($date_time_today, $username, $pkid, $pkid_attachment, $approver_username, 'PENDING', $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			$script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
		
		//send email notification to all approvers
		send_email_for_comment($pkid, 'new');
		
		$return['script']			= $script;
		echo json_encode($return);
	}
	
	function send_email_for_comment($pkid, $action) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('created_by', 'po_number', 'customer_name', 'defect_phenomenon', 'due_date', 'remarks');
		$table 	   	= 'tbl_qfr_8d';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND status="OPEN" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$customer_name 		= $row['customer_name'];
			$defect_phenomenon 	= $row['defect_phenomenon'];
			$due_date 			= $row['due_date'] == '' ? '' : date('M d, Y', strtotime($row['due_date']));			
			$remarks 			= $row['remarks'];
			
			if($action == 'new') {
				$subject 	 = 'FOR CHECKING 8D REPORT: '.$ypics_data['device_name'].'_'.$defect_phenomenon;
			} else {
				$subject 	 = 'REVISED 8D REPORT: '.$ypics_data['device_name'].'_'.$defect_phenomenon;
			}
			$body 	 	 = 'Please be informed that you have 8D Report for checking.<br> <br>';
			$body 		.= 'Request details: <br>';
			$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
			$body 	    .= '&emsp;Device Name: '.$ypics_data['device_name'].' <br>';
			$body 		.= '&emsp;Customer Name: '.$customer_name.' <br>';
			$body 		.= '&emsp;Defect Phenomenon: '.$defect_phenomenon.' <br>';
			$body 		.= '&emsp;Due Date: '.$due_date.' <br>';
			$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
			
			/* Select the report signatories */
			$result = "";
			$array_fields = array('approver_username');
			$table 	   	= 'tbl_qfr_8d_approvers';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fk8d="'.$pkid.'" AND status="PENDING" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$approver_username = '';
			$to_recipients = array();
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				$approver_username 	= $row['approver_username'];
				$to_recipients[]	= return_user_email_add($approver_username) == 'NONE' ? '' : return_user_email_add($approver_username);
			}
			$to = implode(',',$to_recipients);
			$from 		 = return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			
			$php_mailer = new email();
			$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'','');
			return $msg;
		} else {
			$msg = 'Record does not exists!';
			return $msg;
		}
		
		
	}
	
	function load_po_datalist(){
		$po_number_list = get_po_number_list($_POST['pattern']);
		$return = array();
		$return['po_number'] = $po_number_list;
		$html = '';
		foreach($po_number_list as $key => $value){
			$html .= '<option value="'.$value.'">'.$value.'</option>';
		}
		$return['html'] = $html;
		echo json_encode($return);
	}
	
	function get_po_details(){
		$return = array();
		$return = get_series_name($_POST['po_number']);
		echo json_encode($return);
	}
	
	function return_8d_attachments() {
		require_once('../class/oop_tqts.php');
		$array_fields = array('pkid', 'file_name', 'rev_no', 'remarks');
		$table 	   	= 'tbl_qfr_8d_attachments_initial';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk8d='.$_POST['fk8d'].' AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$table_body = '';
		$num_rows	= $result->num_rows;
		$ctr		= 0;		
		$disable    = 'disabled';
		
		while($row = mysqli_fetch_array($result)){
			$ctr++;
			if($ctr == $num_rows) {
				/* Check employees user roles */
				$array_fields = array('pkid');
				$table 	   	= 'tbl_user_roles';
				$joins 	   	= '';
				$sql_where 	= 'WHERE `fk_module`=15 AND `user`="'.$_POST['username'].'" AND `delete`=1 AND logdel="0"';
				$sql_order 	= '';
				$sql_limit 	= '';
				
				$user_role 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($user_role->num_rows != 0) {
					$disable    = '';
				}
			}			
			
			$table_body .= '<tr>';
			$table_body .= '	<td><center>'.$row['rev_no'].'</center></td>';
			$table_body .= '	<td><button type="button" class="btn btn-link fa fa-paperclip" id="btn_dl_attachment" value="'.$_POST['fk8d'].'_'.$row['pkid'].'"> '.$row['file_name'].' '.$row['pkid'].'</button></td>';
			$table_body .= '	<td>'.$row['remarks'].'</td>';
			$table_body .= '	<td><center><button class="btn btn-danger fa fa-trash" '. $disable .' value="'.$row['pkid'].'"> </button></center></td>';
			$table_body .= '</tr>';
			
			
		}
		$return['table_body'] = $table_body;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_final_8d_attachment() {
		require_once('../class/oop_tqts.php');
		$array_fields = array('pkid');
		$table 	   	= 'tbl_qfr_8d_attachment_final';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk8d='.$_POST['fk8d'].' AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pkid 		= 0;
		if($result->num_rows  != 0) {
			$row 	= mysqli_fetch_array($result);
			$pkid 	= $row['pkid'];
		}
		$return['pkid'] = $pkid;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function remove_8d_attachment() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$username 		= $_POST['username'];
		$pkid 			= $_POST['pkid'];	
		$reason 		= $username.' '.$date_time_today.' : '.$_POST['reason'];	
		$msg 			= '';
		
		/* Update the status to 1 as deleted */
		$table 			= 'tbl_qfr_8d_attachments_initial';
		$array_fields 	= array('reason_delete','lastupdate', 'username', 'logdel');
		$array_values 	= array($reason,$date_time_today, $username, 1);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		
		/* Get the file and directory */
		$file 			 = get_file_details_by_pkid($pkid);
		$file_name 		 = $file['file_name'];
		$file_for_delete = $file['file'];
		$fk8d 			 = $file['fk8d'];
		
		/* Permanently delete the file to server to save space :) */
		if(file_exists($file_for_delete)) {
			if (!unlink($file_for_delete)) {
			  $msg .= "<br>Error deleting $file_name";
			} else {
			  $msg .= "<br>File was successfully deleted.";
			}
		} else {
			$msg .= "<br>File does not exist!";
		}
		$return['fk8d'] = $fk8d;
		$return['msg']  = $msg;
		echo json_encode($return);
	}
		
	function get_file_details_by_pkid($fkdetails) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('path.file_path','details.fk8d','details.file_name');
		$table 	   	= 'tbl_qfr_8d_attachments_initial details ';
		$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
		$sql_where 	= 'WHERE details.pkid="'.$fkdetails.'" AND details.logdel=1';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$file 		= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$file['file_path'] = $row['file_path'];
			$file['extension'] = end(explode('.',$row['file_name']));
			$file['fk8d'] 	   = $row['fk8d'];		
			$file['file_name'] = $row['file_name'];		
			$file['file'] 	   = $row['file_path'] . $fkdetails . '.' . $file['extension']; 	
		} else {
			$file['file_path'] = '';
			$file['extension'] = '';
			$file['fk8d'] 	   = '';
			$file['file_name'] = '';
			$file['file'] 	   = '';
		}
		$file['script'] 	   = $script;
		return $file;
	}
	
	function edit_8d() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$approvers 		 = json_decode($_POST["approvers"]);
		$file  		     = return_file_path_by_div_mod('qfr_8d_initial');
		$username    	 = $_POST['username'];
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];
		$return['error'] = array();
		$msg			 = '';		
		$script			 = '';	
		$pkid  			 = $_POST['pkid'];	
		$rev_status  	 = $_POST['rev_status'];	
		$rev_no  		 = $_POST['rev_no'];	
		
		/* Get all fields to be inserted */		
		$table_main 	= "tbl_qfr_8d";
		$values 		= get_fields_values($_POST,array("action","username","file_8d","approver","approvers", "device_name"));
		$array_fields 	= $values["array_fields"];
		$array_values 	= $values["array_values"];
		$result 		= TQTS::getInstance()->update_query($table_main,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table_main,$array_fields,$array_values,$pkid);
		
		$table_initial	= 'tbl_qfr_8d_attachments_initial';
		
		if(isset($_FILES["file_8d"]["tmp_name"])) {
			/* Upload the file to target directory */
			// for($i=0;$i<count($_FILES['file_8d']['name']);$i++) {
				// $temp_file 	     = $_FILES["file_8d"]["tmp_name"][$i];
				// $file_name 	     = $_FILES["file_8d"]["name"][$i];
				$temp_file 	     = $_FILES["file_8d"]["tmp_name"];
				$file_name 	     = $_FILES["file_8d"]["name"];
				$target_file 	 = $target_dir . $file_name;
				if (file_exists($target_file)) {
					// $msg 					= "Sorry, your file already exists.";
					// $return['error']		= $msg;
					
					$array_fields 	= array('pkid');
					$joins 	   		= '';
					$sql_where 		= 'WHERE fk8d="'.$pkid.'" AND rev_no="'.$rev_no.'" AND logdel=0';
					$sql_order 		= '';
					$sql_limit 		= 'LIMIT 0,1';
					$result 		= TQTS::getInstance()->select_query($array_fields,$table_initial,$joins,$sql_where,$sql_order,$sql_limit);
					$row 			= mysqli_fetch_array($result);
					$pkid_attachment = $row['pkid'];
				} else {
					if (move_uploaded_file($temp_file, $target_file)) {
						/* Rename the file based on pkid of Quality Report */	
						/* Check the revision number. if new revision, insert. else, update existing */
						if($rev_status == 'existing') {
							$array_fields 	= array('file_name', 'fkfile_path', 'lastupdate', 'username');
							$array_values 	= array($file_name,$fkfile_path,$date_time_today,$username);
							$sql_where		= 'WHERE fk8d="'.$pkid.'" AND rev_no="'.$rev_no.'" AND logdel=0';
							$msg			= TQTS::getInstance()->update_query_detailed($table_initial,$array_fields,$array_values,$sql_where);
							
							$array_fields 	= array('pkid');
							$joins 	   	= '';
							$sql_where 	= 'WHERE fk8d="'.$pkid.'" AND rev_no="'.$rev_no.'" AND logdel=0';
							$sql_order 	= '';
							$sql_limit 	= 'LIMIT 0,1';
							$result 	= TQTS::getInstance()->select_query($array_fields,$table_initial,$joins,$sql_where,$sql_order,$sql_limit);
							$row 		= mysqli_fetch_array($result);
							$pkid_attachment = $row['pkid'];							
						} else if($rev_status == 'new') {		
							$rev_no += 1;
							$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'file_name', 'fkfile_path', 'rev_no', 'lastupdate', 'username');
							$array_values 	= array($date_time_today,$username,$pkid,$file_name,$fkfile_path,$rev_no,$date_time_today,$username);
							$pkid_attachment= TQTS::getInstance()->insert_query_id($table_initial,$array_fields,$array_values);
							$script 		.= TQTS::getInstance()->insert_query_id_script($table_initial,$array_fields,$array_values);
							
							/* Update main table rev # */
							$array_fields 	= array('rev_no', 'lastupdate', 'username');
							$array_values 	= array($rev_no,$fkfile_path,$date_time_today,$username);
							$msg			= TQTS::getInstance()->update_query($table_main,$array_fields,$array_values,$pkid);
						}
						
						
						$ext = pathinfo($target_file, PATHINFO_EXTENSION);
						$new_file_name  = $pkid."_".($pkid_attachment).".".$ext;
						if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
							$msg .= 'File was successfully uploaded to the system';
						} else {
							$msg .= 'There was an error on renaming the file.';
						}	
						
						/* Update main table to "OPEN" */
						$sql_where		= 'WHERE pkid='.$pkid;
						$array_fields 	= array('status', 'lastupdate', 'username');
						$array_values 	= array('OPEN',$date_time_today, $_POST['username']);
						$msg			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
					} else {
						$msg .= "Sorry, there was an error uploading your file.";
					}
					$return['array_fields']		= $array_fields;
					$return['array_fields']		= $array_values;
					$return['files']			= $_FILES;
				}
			// }
		}
		$table_approvers	= 'tbl_qfr_8d_approvers';
		if($rev_status == 'existing') {
			/* Update approvers */			
			$sql_where		= 'WHERE fk8d='.$pkid;
			$array_fields 	= array('lastupdate', 'username', 'logdel');
			$array_values 	= array($date_time_today, $_POST['username'], 1);
			$msg			= TQTS::getInstance()->update_query_detailed($table_approvers,$array_fields,$array_values,$sql_where);
			$script			= TQTS::getInstance()->update_query_detailed_script($table_approvers,$array_fields,$array_values,$sql_where);
		}
		/* Save updated approvers */
		$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'fk8d_attachment_initial', 'approver_username', 'status', 'lastupdate', 'username');
		foreach($approvers as $approver_username) {
			$array_values 	= array($date_time_today, $username, $pkid, $pkid_attachment, $approver_username, 'PENDING', $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table_approvers,$array_fields,$array_values);
			$script	.= TQTS::getInstance()->insert_query_script($table_approvers,$array_fields,$array_values);
		}	
		
		//send email notification to all approvers
		send_email_for_comment($pkid, 'edit');
		
		$return['msg']				= $msg;
		$return['script']			= $script;
		$return['_POST']			= $_POST;
		echo json_encode($return);
	}
	
	function get_8d_approvers_log() {
		require_once('../class/oop_tqts.php');
		$fk8d			= $_POST['fk8d'];
		$table_body		= '';
		$array_fields = array('a.pkid', 'a.approver_username', 'a.status', 'a.date_time_sent', 'a.file_name', 'a.approver_comment', '(SELECT rev_no FROM tbl_qfr_8d_attachments_initial b WHERE b.pkid = a.`fk8d_attachment_initial` AND b.logdel = 0 LIMIT 0,1) as rev_no');
		$table 	   	= 'tbl_qfr_8d_approvers a';
		$joins 	   	= '';
		$sql_where 	= 'WHERE a.fk8d="'.$fk8d.'" AND a.logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			if($row['file_name'] == '' && $row['approver_comment'] == '') {
				$approver_comment  = '-';
			} else if($row['file_name'] != '' && $row['approver_comment'] == '') {
				$approver_comment  = '<a href="#" class="fa fa-paperclip" id="'.$row['pkid'].'" style="display:inline-block;"> '.$row['file_name'].'</a>';
			} else if($row['file_name'] == '' && $row['approver_comment'] != '') {
				$approver_comment  = $row['approver_comment'];
			} else if($row['file_name'] != '' && $row['approver_comment'] != '') {
				$approver_comment  = '<a href="#" class="fa fa-paperclip" id="'.$row['pkid'].'" style="display:inline-block;"> '.$row['file_name'].'</a><br>';
				$approver_comment .= $row['approver_comment'];
			} else {
				$approver_comment = '-';
			}
			
			$table_body .= '<tr>';
			$table_body .= '	<td>'.$row['status'].'</td>';
			$table_body .= '	<td><center>'.$row['rev_no'].'</center></td>';
			$table_body .= '	<td>'.get_emp_name_by_username($row['approver_username']).'</td>';
			$table_body .= '	<td>'.$approver_comment.'</td>';
			$table_body .= '	<td>'.($row['date_time_sent'] == '' ? '-' : date('M d, Y h:i A',strtotime($row['date_time_sent']))).'</td>';
			$table_body .= '</tr>';
		}
		$return['table_body'] 	= $table_body;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
		
	function validate_is_approver() {
		require_once('../class/oop_tqts.php');
		$return 	= array();
		$return 	= $_POST;
		$array_fields = array('status');
		$table 	   	= 'tbl_qfr_8d_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fk8d`="'.$_POST['fk8d'].'" AND `approver_username`="'.$_POST['username'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['is_approver'] = $result->num_rows;
		
		echo json_encode($return);
	}
	
	function approver_8d_comment() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$fk8d    	 	 = $_POST['fk8d'];
		$username  		 = $_POST['username'];	
		$approver_comment= $_POST['approver_comment'];	
		$temp_file 	     = $_FILES["file_8d"]["tmp_name"];
		$file_name 	     = $_FILES["file_8d"]["name"];		
		$msg 		     = '';		
		$script 		 = '';		
		
		
		$array_fields 	= array('status', 'date_time_sent', 'approver_comment','lastupdate','username');
		$array_values 	= array('DONE', $date_time_today, $approver_comment, $date_time_today,$username);
		
		if(isset($temp_file)) {				
			$file  		     = return_file_path_by_div_mod('qfr_8d_approver');
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];
			$target_file 	= $target_dir . $file_name;
			
			if (file_exists($target_file)) {
				$msg = "Sorry, your file already exists.";
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					//Get the pkid of tbl_qfr_8d_approvers
					$array_fields = array('pkid');
					$table 	   	= 'tbl_qfr_8d_approvers';
					$joins 	   	= '';
					$sql_where 	= 'WHERE `fk8d`="'.$fk8d.'" AND `approver_username`="'.$username.'" AND logdel="0"';
					$sql_order 	= '';
					$sql_limit 	= 'LIMIT 0,1';
					$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
					$row 		= mysqli_fetch_array($result);
					$pkid 		= $row['pkid'];
					
					
					/* Rename the file based on pkid of tbl_qfr_8d_approvers */					
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg = 'File was successfully uploaded to the system.<br>';
						
						/* Update the record based on pkid */					
						$array_fields 	= array('status', 'date_time_sent', 'file_name', 'fkfile_path', 'approver_comment','lastupdate','username');
						$array_values 	= array('DONE', $date_time_today, $file_name, $fkfile_path, $approver_comment, $date_time_today,$username);
						
						/* Send email notification to the first approver */
						// $msg .= ng_send_email_for_approval($pkid);
					} else {
						$msg = 'There was an error on renaming the file.';
						/* Update the record based on pkid */	
					}					
				} else {
					$msg = "Sorry, there was an error uploading your file.";
				}
			}
		}
		$table_details	= 'tbl_qfr_8d_approvers';
		$sql_where		= 'WHERE fk8d='.$fk8d.' AND approver_username="'.$username.'" AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		
		/* Check the approvers table and update the main table if done with all approver */
		$array_fields = array('status');
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk8d="'.$fk8d.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$main_status= 'FOR UPLOAD';
		$result = TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			if($row['status'] == 'PENDING') {
				$main_status = 'OPEN';
				break;
			}
		}
		$table_main 	= 'tbl_qfr_8d';
		$array_fields 	= array('status', 'lastupdate', 'username');
		$array_values 	= array($main_status, $date_time_today,$username);
		$sql_where		= 'WHERE pkid='.$fk8d.' AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
		
		send_email_done_comment($fk8d, $username);
		
		$return['msg']  = $msg;
		echo json_encode($return);
	}
	
	function send_email_done_comment($pkid, $username) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('created_by', 'po_number', 'customer_name', 'defect_phenomenon', 'due_date', 'remarks');
		$table 	   	= 'tbl_qfr_8d';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$customer_name 		= $row['customer_name'];
			$defect_phenomenon 	= $row['defect_phenomenon'];
			$due_date 			= $row['due_date'] == '' ? '' : date('M d, Y', strtotime($row['due_date']));			
			$remarks 			= $row['remarks'];
			
			$subject 	 = 'CHECKED 8D REPORT: '.$ypics_data['device_name'].'_'.$defect_phenomenon;
			$body 	 	 = 'Please be informed that your 8D Report has been reviewed by the approver.<br> <br>';
			$body 		.= 'Request details: <br>';
			$body 		.= '&emsp;PO Number: '.$po_number.' <br>';
			$body 	    .= '&emsp;Device Name: '.$ypics_data['device_name'].' <br>';
			$body 		.= '&emsp;Customer Name: '.$customer_name.' <br>';
			$body 		.= '&emsp;Defect Phenomenon: '.$defect_phenomenon.' <br>';
			$body 		.= '&emsp;Due Date: '.$due_date.' <br>';
			$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
			
			$array_fields = array('file_name', 'approver_comment');
			$table 	   	= 'tbl_qfr_8d_approvers';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fk8d="'.$pkid.'" AND approver_username="'.$username.'" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= 'LIMIT 0, 1';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)){
				if($row['approver_comment'] != '') {
					$body 		.= '<br><br>Approver Comment: '.$row['approver_comment'].' <br>';
				}
				if($row['file_name'] != '') {
					$body 		.= '*Please see attachment on 8D Report Module of TQTS <br>';
				}				
			}
			
			$to 	= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$from	= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
			
			$php_mailer = new email();
			$msg = $php_mailer->send_email($to, $from, $from, $subject, $body,'','');
			return $msg;
		} else {
			$msg = 'Record does not exists!';
			return $msg;
		}
	}
		
	function remove_8d_approver_attachment() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$username 		= $_POST['username'];
		$fk8d 			= $_POST['pkid'];	
		$reason 		= $username.' '.$date_time_today.' : '.$_POST['reason'];	
		$msg 			= '';
		
		
		/* Get the file and directory */
		$file 			 = get_approver_file_details_by_pkid($fk8d, $username);
		$file_name 		 = $file['file_name'];
		$file_for_delete = $file['file'];
		$pkid_approver	 = $file['pkid'];
		$script	 		 = $file['script'];
		
		/* Update the file uploaded */
		$table 			= 'tbl_qfr_8d_approvers';
		$array_fields 	= array('file_name', 'fkfile_path','reason','lastupdate', 'username');
		$array_values 	= array('', '', $reason, $date_time_today, $username);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid_approver);
		
		/* Permanently delete the file to server to save space :) */
		if(file_exists($file_for_delete)) {
			if (!unlink($file_for_delete)) {
			  $msg .= "<br>Error deleting $file_name";
			} else {
			  $msg .= "<br>File was successfully deleted.";
			}
		} else {
			$msg .= "<br>File does not exist!";
		}
		$return['fk8d'] = $file_for_delete;
		$return['msg']  = $msg;
		$return['script']  = $script;
		echo json_encode($return);
	}
	
	function get_approver_file_details_by_pkid($fkdetails, $username) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('path.file_path','details.pkid','details.file_name');
		$table 	   	= 'tbl_qfr_8d_approvers details ';
		$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
		$sql_where 	= 'WHERE details.fk8d="'.$fkdetails.'" AND approver_username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$file 		= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$file['file_path'] = $row['file_path'];
			$file['extension'] = end(explode('.',$row['file_name']));
			$file['pkid'] 	   = $row['pkid'];		
			$file['file_name'] = $row['file_name'];		
			$file['file'] 	   = $row['file_path'] . $row['pkid'] . '.' . $file['extension']; 	
		} else {
			$file['file_path'] = '';
			$file['extension'] = '';
			$file['pkid'] 	   = '';
			$file['file_name'] = '';
			$file['file'] 	   = '';
		}
		$file['script'] 	   = $script;
		return $file;
	}
	
	function requestor_8d_comment() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$fk8d    	 	 = $_POST['fk8d'];
		$username  		 = $_POST['username'];	
		$remarks		 = $_POST['final_remarks'];	
		$temp_file 	     = $_FILES["file_8d"]["tmp_name"];
		$file_name 	     = $_FILES["file_8d"]["name"];		
		$msg 		     = '';		
		$script 		 = '';		
		
		/* Check if fk8d already exist */
		$return 	= array();
		$return 	= $_POST;
		$array_fields = array('pkid');
		$table 	   	= 'tbl_qfr_8d_attachment_final';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fk8d`="'.$_POST['fk8d'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'final_remarks', 'lastupdate', 'username');
			$array_values 	= array($date_time_today,$username, $fk8d, $remarks, $date_time_today,$username);			
			$pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		} else {
			$row			= mysqli_fetch_array($result);
			$pkid 			= $row['pkid'];
		}
		
		/* Upload file */
		if(isset($temp_file)) {				
			$file  		     = return_file_path_by_div_mod('qfr_8d_final');
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];
			$target_file 	= $target_dir . $file_name;
			
			if (file_exists($target_file)) {
				$msg = "Sorry, your file already exists.";
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					/* Rename the file based on pkid of tbl_qfr_8d_approvers */					
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg = 'File was successfully uploaded to the system.<br>';
						
						/* Update the record based on pkid */					
						$array_fields 	= array('file_name', 'fkfile_path', 'lastupdate','username');
						$array_values 	= array($file_name, $fkfile_path, $date_time_today,$username);
						$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
						
						/* Send email notification to the first approver */
						// $msg .= ng_send_email_for_approval($pkid);
					} else {
						$msg = 'There was an error on renaming the file.';
						/* Update the record based on pkid */	
					}					
				} else {
					$msg = "Sorry, there was an error uploading your file.";
				}
			}
		}
		/* Check the approvers table and update the main table if done with all approver */
		$table_main 	= 'tbl_qfr_8d';
		$array_fields 	= array('status', 'lastupdate', 'username');
		$array_values 	= array('FOR SEND', $date_time_today,$username);
		$sql_where		= 'WHERE pkid='.$fk8d.' AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
		
		//send_email_done_comment($fk8d, $username);//send email to 8D Admin
		
		$return['msg']  = $msg;
		echo json_encode($return);
	}
	
	function admin_save_final_report() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$fk8d    	 	 = $_POST['fk8d'];
		$username  		 = $_POST['username'];	
		$send_action 	= $_POST['send'];			
		$msg 		     = '';		
		$script 		 = '';		
		
		/* Check if fk8d already exist */
		$return 	= array();
		$return 	= $_POST;
		$array_fields = array('pkid');
		$table 	   	= 'tbl_qfr_8d_attachment_final';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fk8d`="'.$_POST['fk8d'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row	= mysqli_fetch_array($result)) {
			$pkid 			= $row['pkid'];
		}
		
		/* Upload file */
		if(isset($_FILES["file_8d"]["tmp_name"])) {			
			$temp_file 	     = $_FILES["file_8d"]["tmp_name"];
			$file_name 	     = $_FILES["file_8d"]["name"];		
			
			$file  		     = return_file_path_by_div_mod('qfr_8d_final');
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];
			$target_file 	= $target_dir . $file_name;
			
			if (file_exists($target_file)) {
				$msg = "Sorry, your file already exists.";
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					/* Rename the file based on pkid of tbl_qfr_8d_approvers */					
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg = 'File was successfully uploaded to the system.<br>';
						
						/* Update the record based on pkid */					
						$array_fields 	= array('file_name', 'fkfile_path', 'lastupdate','username');
						$array_values 	= array($file_name, $fkfile_path, $date_time_today,$username);
						$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					} else {
						$msg = 'There was an error on renaming the file.';
						/* Update the record based on pkid */	
					}					
				} else {
					$msg = "Sorry, there was an error uploading your file.";
				}
			}
		}
		/* Check the approvers table and update the main table if done with all approver */
		$table_main 	= 'tbl_qfr_8d';
		$array_fields 	= array('status', 'lastupdate', 'username');
		$array_values 	= array('CLOSED', $date_time_today,$username);
		$sql_where		= 'WHERE pkid='.$fk8d.' AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
		
		if($send_action != '') {
			require_once('../class/send_email.php');
			$to_recipient   = json_decode($_POST['to_recipient']);
			$cc_recipient   = json_decode($_POST['cc_recipient']);
			$subject   		= $_POST['subject'];
			$body   		= $_POST['body'];
						
			$to = array();
			for($i=0;$i<count($to_recipient);$i++) {
				array_push($to, $to_recipient[$i]);
			}	
			$cc = array();
			for($i=0;$i<count($cc_recipient);$i++) {
				array_push($cc, $cc_recipient[$i]);
			}
			$to 		 = implode(',',$to);
			$cc 		 = implode(',',$cc);
			
			/* Get file attachment */
			$array_fields = array('details.pkid','path.file_path','details.file_name');
			$table 	   	= 'tbl_qfr_8d_attachment_final details ';
			$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
			$sql_where 	= 'WHERE details.fk8d="'.$fk8d.'" AND details.logdel=0';
			$sql_order 	= '';
			$sql_limit 	= 'LIMIT 0,1';
			$file 		= array();
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			// echo TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)){
				$file_path 		 = $row['file_path'];
				$extension 		 = end(explode('.',$row['file_name']));
				$attachment_name = $row['file_name'];		
				$attachment_file = $file_path.$row['pkid'].'.'.$extension;		
			}
			// $body .= $attachment_file.' FILE <br>';
			// $body .= $attachment_name;
			$from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
			$php_mailer  = new email();
			$msg 		 = $php_mailer->send_email($to, $from, $cc, $subject, $body,$attachment_file,$attachment_name);
		}
		
		$return['msg']  = $msg;
		echo json_encode($return);
	}
	
	function get_latest_revision() {
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$array_fields	= array('rev_no');
		$table			= 'tbl_qfr_8d_attachments_initial';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$return['pkid'].'" AND logdel="0"';
		$sql_order		= 'ORDER BY rev_no DESC';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			return $row['rev_no'];
		}
		return 0;
	}
	
	/* **********************
		Advance Search
	 ********************** */
	 function qfr_8d_return_dir_fields(){
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="po_number">P.O. Number</option>'; $ctr++;
		$option[$ctr] = '<option value="customer_name">Customer Name</option>'; $ctr++;
		$option[$ctr] = '<option value="defect_phenomenon">Defect Phenomenon</option>'; $ctr++;
		$option[$ctr] = '<option value="due_date">Due Date</option>'; $ctr++;
		$option[$ctr] = '<option value="report_file">Report File</option>'; $ctr++;
		$option[$ctr] = '<option value="approver">Approver</option>'; $ctr++;
		$option[$ctr] = '<option value="created_by">Uploaded By</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	 }
	 
	 function qfr_8d_advance_search() {
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
				$date_start = date('Y-m-d',strtotime($date_range[0]));
				$date_end 	= date('Y-m-d',strtotime($date_range[1]));
				$sql_where_and[] = ' ('.$fieldn.' BETWEEN "'.$date_start.'" AND "'.$date_end.'")';
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
	
	function load_8d_main_data(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$array_fields	= array('*');
		$table			= 'tbl_qfr_8d';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$return['pkid'].'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
		}
		
		$approver_username	= array();
		$date_time_sent		= array();
		$approver_status	= array();
		$array_fields = array('approver_username','date_time_sent', 'status','fkfile_path');
		$table 	   	= ' tbl_qfr_8d_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fk8d`="'.$_POST['pkid'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$approver_username[] 			= $row['approver_username'];
			$date_time_sent[]		 		= $row['date_time_sent'];
			$approver_status[] 				= $row['status'];
			$fkfile_path 					= $row['fkfile_path'];
		}
		
		$return['remove_attachment'] 	= 'false';
		
		/* Check employees user roles */
		if($fkfile_path != 0) {
			$array_fields = array('pkid');
			$table 	   	= 'tbl_user_roles';
			$joins 	   	= '';
			$sql_where 	= 'WHERE `fk_module`=15 AND `user`="'.$_POST['username'].'" AND `delete`=1 AND logdel="0"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$disable    = 'disabled';
			$user_role 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($user_role->num_rows != 0) {
				$return['remove_attachment'] 	= 'true';
			}
		}
		
		$return['approver_username'] 	= implode(',',$approver_username);
		$return['approver_username'] 	= implode(',',$approver_username);
		$return['date_time_sent']		= implode(',',$date_time_sent);
		$return['approver_status'] 		= implode(',',$approver_status);
		$return['script'] 				= $script;
		$return['rev_no'] 				= get_latest_revision($return['pkid']);
		
		echo json_encode($return);
	}
	
	/* 8D End */	
?>