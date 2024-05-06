<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {		
				case "return_user_name"							: return_user_name(); break;
				case "return_product_name_list"					: return_product_name_list(); break;
				case "return_prod_family_list"					: return_prod_family_list(); break;
				case "save_qcfr"								: save_qcfr(); break;
				case "save_qcfr_approvers_decision"				: save_qcfr_approvers_decision(); break;
				case "update_qcfr"								: update_qcfr(); break;
				case "add_recipient_fillin"						: add_recipient_fillin(); break;
				case "get_qcfr_details_by_pkid"					: get_qcfr_details_by_pkid(); break;
				case "get_qcfr_fill_in_signatories"				: get_qcfr_fill_in_signatories(); break;
				case "update_originator_fillin"					: update_originator_fillin(); break;
				case "return_qcfr_attachments"					: return_qcfr_attachments(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function return_user_name() {
		$username = $_POST['username'];
		$result['empname'] = get_emp_name_by_username_systemone($username);
		echo json_encode($result);
	}
	
	function update_qcfr_control_no($pkid) {
		require_once('../class/oop_tqts.php');
		$result = "";
		$division	= return_system_division();
		$array_fields = array('qcfr_no');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$last_qcfr_no	= explode('-', $row['qcfr_no']);
			$series			= end($last_qcfr_no);
			$series			= sprintf("%03d", $series);
		}
		
		$array_fields = array('qcfr_no', 'prod_family');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$qcfr_no = '';
		if($row = mysqli_fetch_array($result)){
			$qcfr_no = 'Q-'.$division.'-'.$row['prod_family'].'-'.date('my').'-'.($series+1);
		}
		$array_fields = array('qcfr_no');
		$array_values = array($qcfr_no);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
	}
	
	function return_product_name_list() {
		require_once('../class/oop_tqts.php');
		$fk_module		= 0;
		$array_fields	= array('pkid');
		$table  	 	= "tbl_module";
		$joins  	 	= "";
		$sql_where  	= "WHERE module='QCFR - LQC'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$fk_module = $row['pkid'];
		}
		
		$array_fields	= array('tbl_dropdown_maintenance_details.*');
		$table  	 	= "tbl_dropdown_maintenance_details";
		$joins  	 	= "INNER JOIN tbl_dropdown_maintenance_main ON tbl_dropdown_maintenance_main.pkid = tbl_dropdown_maintenance_details.fkdropdown_id";
		$sql_where  	= "WHERE tbl_dropdown_maintenance_main.fkmodule = '$fk_module' AND tbl_dropdown_maintenance_main.dropdown_title='Product Name'";
		$sql_order  	= "";
		$sql_limit  	= "";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select	= '<option value="">-</option>';
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['dropdown_value'].'">'.$row['dropdown_text'].'</option>';
		}		
		$return['html_select'] 	= $html_select;
		echo json_encode($return);
	}
	
	function return_prod_family_list() {
		require_once('../class/oop_tqts.php');
		$fk_module		= 0;
		$array_fields	= array('pkid');
		$table  	 	= "tbl_module";
		$joins  	 	= "";
		$sql_where  	= "WHERE module='QCFR - LQC'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$fk_module = $row['pkid'];
		}
		
		$array_fields	= array('tbl_dropdown_maintenance_details.*');
		$table  	 	= "tbl_dropdown_maintenance_details";
		$joins  	 	= "INNER JOIN tbl_dropdown_maintenance_main ON tbl_dropdown_maintenance_main.pkid = tbl_dropdown_maintenance_details.fkdropdown_id";
		$sql_where  	= "WHERE tbl_dropdown_maintenance_main.fkmodule = '$fk_module' AND tbl_dropdown_maintenance_main.dropdown_title='Product Family'";
		$sql_order  	= "";
		$sql_limit  	= "";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select	= '<option value="">-</option>';
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['dropdown_value'].'">'.$row['dropdown_text'].'</option>';
		}		
		$return['html_select'] 	= $html_select;
		echo json_encode($return);
	}
	
	function save_qcfr() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$msg			 = '';				
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_qfr_qcfr";
		$values 					= get_fields_values($_POST,array("action","username","to","attn","cc_supplier","cc_pmi","from","subcon_pmi","found_during","inspection_method","disposition","nature_of_request","reported_by","verified_conformed_by_eng","verified_conformed_by_prdn"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "reported_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "`to`"; 				$array_values[] = isset($_POST['to']) ? $_POST['to'] : '';
		$array_fields[] 			= "`attn`"; 			$array_values[] = isset($_POST['attn']) ? implode(' | ', $_POST['attn']) : '';
		$array_fields[] 			= "`cc_supplier`"; 		$array_values[] = isset($_POST['cc_supplier']) ? $_POST['cc_supplier'] : '';
		$array_fields[] 			= "`cc_pmi`"; 			$array_values[] = isset($_POST['cc_pmi']) ? implode(' | ', $_POST['cc_pmi']) : '';
		$array_fields[] 			= "`from`"; 			$array_values[] = $_POST['from'];
		$array_fields[] 			= "verified_conformed_by_lqc_logs";		$array_values[] = $_POST['verified_conformed_by_lqc'] == '' ? '' : 'PENDING';
		$array_fields[] 			= "verified_conformed_by_eng";			$array_values[] = isset($_POST['verified_conformed_by_eng']) ? implode(',',$_POST['verified_conformed_by_eng']) : '';
		$array_fields[] 			= "verified_conformed_by_eng_logs";		$array_values[] = isset($_POST['verified_conformed_by_eng']) ? 'PENDING' : '';
		$array_fields[] 			= "verified_conformed_by_prdn";			$array_values[] = isset($_POST['verified_conformed_by_prdn']) ? implode(',',$_POST['verified_conformed_by_prdn']) : '';
		$array_fields[] 			= "verified_conformed_by_prdn_logs";	$array_values[] = isset($_POST['verified_conformed_by_prdn']) ? 'PENDING' : '';
		$array_fields[] 			= "`subcon_pmi`"; 			$array_values[] = implode(' | ', $_POST['subcon_pmi']);
		$array_fields[] 			= "`found_during`"; 		$array_values[] = isset($_POST['found_during']) ? implode(' | ', $_POST['found_during']) : '';
		$array_fields[] 			= "`inspection_method`"; 	$array_values[] = implode(' | ', $_POST['inspection_method']);
		$array_fields[] 			= "`disposition`"; 			$array_values[] = implode(' | ', $_POST['disposition']);
		$array_fields[] 			= "`nature_of_request`"; 	$array_values[] = implode(' | ', $_POST['nature_of_request']);
		$array_fields[] 			= "reported_by_date_time"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "lastupdate"; 			$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 				$array_values[] = $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		
		/* Upload attachment */
		if(count($_FILES['file_failure_defect_filename']['name']) != 0) {
			for($i=0;$i<count($_FILES['file_failure_defect_filename']['name']);$i++) {
				$temp_file 	     = $_FILES["file_failure_defect_filename"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_failure_defect_filename"]["name"][$i];
				
				if($_FILES["file_failure_defect_filename"]["tmp_name"][0] != '') {
					$file  		     	= return_file_path_by_div_mod('qfr_qcfr_request');
					$fkfile_path     	= $file['pkid'];
					$target_dir      	= $file['path'];
					$target_file 	 	= $target_dir . $file_name;	
					if (file_exists($target_file)) {
						$msg 					= "Sorry, your file already exists.";
						$return['error']		= $msg;
					} else {						
						if (move_uploaded_file($temp_file, $target_file)) {	
							$table 				= 'tbl_qfr_qcfr_attachments';
							$array_fields 		= array("date_time_created", "created_by", "fkqcfr", "category", "file_name", "fkfile_path" , "lastupdate", "username");
							$array_values 		= array($date_time_today, $username, $pkid, "REQUEST", $file_name, $fkfile_path, $date_time_today, $username);
							$attachments_id		= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
							$script 			= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
														
							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							$new_file_name  = $attachments_id.".".$ext;
							if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
								$msg .= '<br>File was successfully uploaded to the system';
							} else {
								$msg .= '<br>There was an error on renaming the file.';
							}	
						}
						
					}
				}
			}
		}
		if($pkid != false) {
			send_email_qcfr_verified_conformance($pkid, 'new');
		}
		$return['msg'] 	= 'New record has been saved'.$msg;
		$return['POST'] 	= $_POST;
		$return['_FILES'] 	= $_FILES;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function send_email_qcfr_verified_conformance($pkid, $action) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$send_to = array();
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$subcon_pmi 		= $row['subcon_pmi'];
			$to 				= $row['to'];
			$attn 				= $row['attn'];
			$cc_supplier 		= $row['cc_supplier'];
			$cc_pmi 			= $row['cc_pmi'];
			$from 				= $row['from'];
			$date_issued 		= $row['date_issued'] == '' ? '' : date('M d, Y',strtotime($row['date_issued']));
			$reported_by 		= get_emp_name_by_username_systemone($row['reported_by']);
			$product_name 		= $row['product_name'];
			$model_no 			= $row['model_no'];
			$batch_no_lot_no 	= $row['batch_no_lot_no'];
			$po_no_invoice_no 	= $row['po_no_invoice_no'];
			$date_received 		= $row['date_received'] == '' ? '' : date('M d, Y',strtotime($row['date_received']));
			$disposition 		= $row['disposition'];
			$disposition_others = $row['disposition_others'];
			$send_to[] 			= $row['verified_conformed_by_lqc'] == '' ? '' : return_user_email_add($row['verified_conformed_by_lqc']);
			// $send_to[] 			= $row['verified_conformed_by_eng'] == '' ? '' : return_user_email_add($row['verified_conformed_by_eng']);
			// $send_to[] 			= $row['verified_conformed_by_prdn'] == '' ? '' : return_user_email_add($row['verified_conformed_by_prdn']);
		}
		if($action == 'new') {
			$subject 	 = 'FOR CHECKING QCFR: '.$po_no_invoice_no.' '.$product_name;
		} else if($action == 'edit') {
			$subject 	 = 'FOR CHECKING QCFR (Revised): '.$po_no_invoice_no.' '.$product_name;
		}  
		
		$body 	 	 = 'Please be informed that you have QCFR for checking.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;'.$subcon_pmi.' <br>';
		$body 		.= '&emsp;To: '.$to.' <br>';
		$body 		.= '&emsp;to: '.$attn.' <br>';
		$body 		.= '&emsp;Cc: '.$cc_supplier.','.$cc_pmi.' <br>';
		$body 		.= '&emsp;From: '.$from.' <br>';
		$body 		.= '&emsp;Date Issued: '.$date_issued.' <br>';
		$body 		.= '&emsp;Product Name: '.$product_name.' <br>';
		$body 		.= '&emsp;Model No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;Batch No./Lot No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;PO No./Inv. No.: '.$po_no_invoice_no.' <br>';
		$body 		.= '&emsp;Date Received: '.$date_received.' <br>';
		$body 		.= '&emsp;Disposition: '.str_replace(' | ',', ',$disposition).' <br>';
		$body 		.= '&emsp;Reported By: '.$reported_by.' <br>';
		
		/* Select recipients */
		$sent_from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		$php_mailer = new email();
		$send_to = implode(',',$send_to);
		$php_mailer->send_email($send_to, $sent_from, $sent_from, $subject, $body,'','');
	}
	
	function send_email_qcfr_for_checking($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$send_to = array();
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$status 			= $row['status'];
			$subcon_pmi 		= $row['subcon_pmi'];
			$to 				= $row['to'];
			$attn 				= $row['attn'];
			$cc_supplier 		= $row['cc_supplier'];
			$cc_pmi 			= $row['cc_pmi'];
			$from 				= $row['from'];
			$date_issued 		= $row['date_issued'] == '' ? '' : date('M d, Y',strtotime($row['date_issued']));
			$reported_by 		= get_emp_name_by_username_systemone($row['reported_by']);
			$product_name 		= $row['product_name'];
			$model_no 			= $row['model_no'];
			$batch_no_lot_no 	= $row['batch_no_lot_no'];
			$po_no_invoice_no 	= $row['po_no_invoice_no'];
			$date_received 		= $row['date_received'] == '' ? '' : date('M d, Y',strtotime($row['date_received']));
			$disposition 		= $row['disposition'];
			$disposition_others = $row['disposition_others'];
			
			if($status == 'FOR APPROVAL SECTHEAD') {
				$send_to[] 			= $row['approved_by_sh'] == '' ? '' : return_user_email_add($row['approved_by_sh']);
			} else if($status == 'FOR APPROVAL ENGINEERING') {
				$send_to[] 			= $row['verified_conformed_by_eng'] == '' ? '' : return_user_email_add($row['verified_conformed_by_eng']);
			} else if($status == 'FOR APPROVAL PRODUCTION') {
				$send_to[] 			= $row['verified_conformed_by_prdn_logs'] == '' ? '' : return_user_email_add($row['verified_conformed_by_prdn_logs']);
			} else if($status == 'FOR APPROVAL ENGR/PRDN') {
				$send_to[] 			= $row['verified_conformed_by_eng'] == '' ? '' : return_user_email_add($row['verified_conformed_by_eng']);
				$send_to[] 			= $row['verified_conformed_by_prdn_logs'] == '' ? '' : return_user_email_add($row['verified_conformed_by_prdn_logs']);
			} else if($status == 'RECIPIENT FILL-IN') {
				$send_to[] 			= $row['attn'] == '' ? '' : return_user_email_add($row['attn']);
			} else if($status == 'FOR CHECKING') {
				$send_to[] 			= $row['pmi_orginator_fill_in_approved_by'] == '' ? '' : return_user_email_add($row['pmi_orginator_fill_in_approved_by']);
			}
		}
		$subject 	 = $status.' QCFR: '.$po_no_invoice_no.' '.$product_name;
		
		$body 	 	 = 'Please be informed that you have QCFR for checking.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;'.$subcon_pmi.' <br>';
		$body 		.= '&emsp;To: '.$to.' <br>';
		$body 		.= '&emsp;to: '.$attn.' <br>';
		$body 		.= '&emsp;Cc: '.$cc_supplier.','.$cc_pmi.' <br>';
		$body 		.= '&emsp;From: '.$from.' <br>';
		$body 		.= '&emsp;Date Issued: '.$date_issued.' <br>';
		$body 		.= '&emsp;Product Name: '.$product_name.' <br>';
		$body 		.= '&emsp;Model No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;Batch No./Lot No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;PO No./Inv. No.: '.$po_no_invoice_no.' <br>';
		$body 		.= '&emsp;Date Received: '.$date_received.' <br>';
		$body 		.= '&emsp;Disposition: '.str_replace(' | ',', ',$disposition).' <br>';
		$body 		.= '&emsp;Reported By: '.$reported_by.' <br>';
		
		/* Select recipients */
		$sent_from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		$php_mailer = new email();
		$send_to = implode(',',$send_to);
		$php_mailer->send_email($send_to, $sent_from, $sent_from, $subject, $body,'','');
	}
	
	function send_email_closed($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$send_cc = array();
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$status 			= $row['status'];
			$subcon_pmi 		= $row['subcon_pmi'];
			$to 				= $row['to'];
			$attn 				= $row['attn'];
			$cc_supplier 		= $row['cc_supplier'];
			$cc_pmi 			= $row['cc_pmi'];
			$from 				= $row['from'];
			$date_issued 		= $row['date_issued'] == '' ? '' : date('M d, Y',strtotime($row['date_issued']));
			$reported_by 		= get_emp_name_by_username_systemone($row['reported_by']);
			$product_name 		= $row['product_name'];
			$model_no 			= $row['model_no'];
			$batch_no_lot_no 	= $row['batch_no_lot_no'];
			$po_no_invoice_no 	= $row['po_no_invoice_no'];
			$date_received 		= $row['date_received'] == '' ? '' : date('M d, Y',strtotime($row['date_received']));
			$disposition 		= $row['disposition'];
			$disposition_others = $row['disposition_others'];
			
			
			$send_cc[] 			= $row['approved_by_sh'] == '' ? '' : return_user_email_add($row['approved_by_sh']);
			$send_cc[] 			= $row['verified_conformed_by_eng'] == '' ? '' : return_user_email_add($row['verified_conformed_by_eng']);
			$send_cc[] 			= $row['verified_conformed_by_prdn_logs'] == '' ? '' : return_user_email_add($row['verified_conformed_by_prdn_logs']);
			$send_cc[] 			= $row['attn'] == '' ? '' : return_user_email_add($row['attn']);
			$send_cc[] 			= $row['pmi_orginator_fill_in_checked_by'] == '' ? '' : return_user_email_add($row['pmi_orginator_fill_in_checked_by']);
			$send_cc[] 			= $row['pmi_orginator_fill_in_approved_by'] == '' ? '' : return_user_email_add($row['pmi_orginator_fill_in_approved_by']);
			
		}
		$subject 	 = $status.' QCFR: '.$po_no_invoice_no.' '.$product_name;
		
		$body 	 	 = 'Please be informed that you have QCFR for checking.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;'.$subcon_pmi.' <br>';
		$body 		.= '&emsp;To: '.$to.' <br>';
		$body 		.= '&emsp;to: '.$attn.' <br>';
		$body 		.= '&emsp;Cc: '.$cc_supplier.','.$cc_pmi.' <br>';
		$body 		.= '&emsp;From: '.$from.' <br>';
		$body 		.= '&emsp;Date Issued: '.$date_issued.' <br>';
		$body 		.= '&emsp;Product Name: '.$product_name.' <br>';
		$body 		.= '&emsp;Model No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;Batch No./Lot No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;PO No./Inv. No.: '.$po_no_invoice_no.' <br>';
		$body 		.= '&emsp;Date Received: '.$date_received.' <br>';
		$body 		.= '&emsp;Disposition: '.str_replace(' | ',', ',$disposition).' <br>';
		$body 		.= '&emsp;Reported By: '.$reported_by.' <br>';
		
		/* Select recipients */
		$send_to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$sent_from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$send_cc = implode(',',$send_cc);
		$php_mailer->send_email($send_to, $sent_from, $send_cc, $subject, $body,'','');
	}
	
	function save_qcfr_approvers_decision() {
		require_once('../class/oop_tqts.php');	
		$date_time_today = date('Y-m-d H:i:s');
		$pkid 						= $_POST["pkid"];
		// $pkid 						= 9;
		// $status 					= 'ACCEPT LQC SUPERVISOR';
		$status 					= $_POST["status"];
		$remarks 					= $_POST["remarks"];
		$username 					= $_POST["username"];
		$check_if_eng_prdn_approved = '';
		
		if($status == 'ACCEPT LQC SUPERVISOR') {
			$array_fields_select = array("verified_conformed_by_lqc");
			$array_fields_update = array("status", "verified_conformed_by_lqc_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
		} else if($status == 'REJECT LQC SUPERVISOR') {
			$array_fields_select = array("verified_conformed_by_lqc");
			$array_fields_update = array("status", "verified_conformed_by_lqc_logs","lastupdate", "username");
			$status_main		 = "REJECT LQC";
		} else if($status == 'ACCEPT PRODUCTION') {
			$array_fields_select = array("verified_conformed_by_prdn","verified_conformed_by_prdn_logs");
			$array_fields_update = array("status", "verified_conformed_by_prdn_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
			if($status_main == 'FOR APPROVAL PRODUCTION1') {
				$check_if_eng_prdn_approved = '1';
				$status_main = 'FOR APPROVAL PRODUCTION';
			}
		} else if($status == 'REJECT PRODUCTION') {
			$array_fields_select = array("verified_conformed_by_prdn");
			$array_fields_update = array("status", "verified_conformed_by_prdn_logs","lastupdate", "username");
			$status_main		 = "REJECT PRODUCTION";
		} else if($status == 'ACCEPT ENGINEERING') {
			$array_fields_select = array("verified_conformed_by_eng","verified_conformed_by_eng_logs");
			$array_fields_update = array("status", "verified_conformed_by_eng_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
			if($status_main == 'FOR APPROVAL ENGINEERING1') {
				$check_if_eng_prdn_approved = '1';
				$status_main = 'FOR APPROVAL ENGINEERING';
			}
		} else if($status == 'REJECT ENGINEERING') {
			$array_fields_select = array("verified_conformed_by_eng");
			$array_fields_update = array("status", "verified_conformed_by_eng_logs","lastupdate", "username");
			$status_main		 = "REJECT ENGINEERING";
		} else if($status == 'APPROVED SECTHEAD') {
			$array_fields_select = array("approved_by_sh");
			$array_fields_update = array("status", "approved_by_sh_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
			update_qcfr_control_no($pkid);
		} else if($status == 'DISAPPROVED SECTHEAD') {
			$array_fields_select = array("approved_by_sh");
			$array_fields_update = array("status", "approved_by_sh_logs","lastupdate", "username");
			$status_main		 = "DISAPPROVED SECTHEAD";
		} else if($status == 'APPROVED DEPTHEAD') {
			$array_fields_select = array("approved_by_dh");
			$array_fields_update = array("status", "approved_by_dh_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
		} else if($status == 'DISAPPROVED DEPTHEAD') {
			$array_fields_select = array("approved_by_dh");
			$array_fields_update = array("status", "approved_by_dh_logs","lastupdate", "username");
		} else if($status == 'CHECKED LQC') {
			$array_fields_select = array("pmi_orginator_fill_in_checked_by");
			$array_fields_update = array("status", "pmi_orginator_fill_in_checked_by_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
		} else if($status == 'REJECT LQC SUPERVISOR2') {
			$array_fields_select = array("pmi_orginator_fill_in_checked_by");
			$array_fields_update = array("status", "pmi_orginator_fill_in_checked_by_logs","lastupdate", "username");
			$status_main		 = "REJECT LQC SUPERVISOR2";
		} else if($status == 'APPROVED QC HEAD') {
			$array_fields_select = array("pmi_orginator_fill_in_approved_by");
			$array_fields_update = array("status", "pmi_orginator_fill_in_approved_by_logs","lastupdate", "username");
			$status_main		 = return_next_qcfr_main_status($pkid, $status, $username);
		} else if($status == 'DISAPPROVED QC HEAD') {
			$array_fields_select = array("pmi_orginator_fill_in_approved_by");
			$array_fields_update = array("status", "pmi_orginator_fill_in_approved_by_logs","lastupdate", "username");
			$status_main		 = "DISAPPROVED QC HEAD";
		} 

		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields_select,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields_select,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$approvers 		= explode(',',$row[0]);
			$approvers_log  = isset($row[1]) ? explode(',',$row[1]) : 'N/A';
			$index 	   		= array_search($username,$approvers);
			$logs 	   		= array();
			for($i=0; $i<count($approvers);$i++) {
				if($i == $index) {
					$logs[] = $status.' | '.$date_time_today.' | '.$remarks;
				} else {
					$logs[] = ($approvers_log == 'N/A' ? '' : (isset($approvers_log[$i]) ? $approvers_log[$i] : 'PENDING'));
				}
			}
		}
		$logs = implode(',', $logs);
		
		// $logs				= $status.' | '.$date_time_today.' | '.$remarks;
		$array_values 		= array($status_main, $logs, $date_time_today, $username);
		$table 				= "tbl_qfr_qcfr";
		$msg 				= TQTS::getInstance()->update_query($table,$array_fields_update,$array_values,$pkid);
		$script 			= TQTS::getInstance()->update_query_script($table,$array_fields_update,$array_values,$pkid);
		
		/* send email notification */
		$user = end(explode(' ', $status));
		send_email_qcfr_approvers_decision($pkid, $user, $status);
		$status == 'CLOSED' ? send_email_closed($pkid) : send_email_qcfr_for_checking($pkid);
		
		/* Check if request is ready for SH approval */
		if($check_if_eng_prdn_approved == 1) {
			if(check_if_eng_prdn_approved($pkid) == 0) {				
				update_next_approver_status("approved_by_sh_logs", "PENDING", $pkid, $username);
				update_next_approver_status("status", "FOR APPROVAL SECTHEAD", $pkid, $username);
			}
		}
		
		$return['msg'] 		= $msg;
		$return['script'] 	= $script;
		$return['_POST'] 	= $_POST;
		echo json_encode($return);
	}
	
	function send_email_qcfr_approvers_decision($pkid, $user, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$username 			= $row['username'];
			$subcon_pmi 		= $row['subcon_pmi'];
			$status_db 			= $row['status'];
			$to 				= $row['to'];
			$attn 				= $row['attn'];
			$cc 				= $row['cc_pmi'].$row['cc_supplier'];
			$from 				= $row['from'];
			$date_issued 		= $row['date_issued'] == '' ? '' : date('M d, Y',strtotime($row['date_issued']));
			$reported_by 		= get_emp_name_by_username_systemone($row['reported_by']);
			$product_name 		= $row['product_name'];
			$model_no 			= $row['model_no'];
			$batch_no_lot_no 	= $row['batch_no_lot_no'];
			$po_no_invoice_no 	= $row['po_no_invoice_no'];
			$date_received 		= $row['date_received'] == '' ? '' : date('M d, Y',strtotime($row['date_received']));
			$disposition 		= $row['disposition'];
			$disposition_others = $row['disposition_others'];
		}
		$subject 	 = $status.' QCFR: '.$po_no_invoice_no.' '.$product_name; 
		
		$status_a = explode(' ', $status);
		if($status_a[0] == 'ACCEPT' || $status_a[0] == 'REJECT') {
			$body 	 	 = 'Please be informed that your QCFR for approval has been '.strtolower($status_a[0].'ed by '.$status_a[1]).'.<br> <br>';
		} else {
			$body 	 	 = 'Please be informed that your QCFR for approval has been '.strtolower($status_a[0].' by '.$status_a[1]).'.<br> <br>';
		}
		
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;'.$subcon_pmi.' <br>';
		$body 		.= '&emsp;To: '.$to.' <br>';
		$body 		.= '&emsp;to: '.$attn.' <br>';
		$body 		.= '&emsp;Cc: '.$cc.' <br>';
		$body 		.= '&emsp;From: '.$from.' <br>';
		$body 		.= '&emsp;Date Issued: '.$date_issued.' <br>';
		$body 		.= '&emsp;Product Name: '.$product_name.' <br>';
		$body 		.= '&emsp;Model No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;Batch No./Lot No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;PO No./Inv. No.: '.$po_no_invoice_no.' <br>';
		$body 		.= '&emsp;Date Received: '.$date_received.' <br>';
		$body 		.= '&emsp;Disposition: '.str_replace(' | ', ', ', $disposition).' <br>';
		$body 		.= '&emsp;Reported By: '.$reported_by.' <br>';
		
		/* Select recipients */
		$send_to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$sent_from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($send_to, $sent_from, $sent_from, $subject, $body,'','');
		
		if($status_db == 'FOR ADD ANSWER') {
			send_email_qcfr_add_answer($pkid);
		}
	}
	
	function send_email_qcfr_add_answer($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_qcfr';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$username 			= $row['username'];
			$status 			= $row['status'];
			$subcon_pmi 		= $row['subcon_pmi'];
			$to 				= $row['to'];
			$attn 				= $row['attn'];
			$cc 				= $row['cc_pmi'].$row['cc_supplier'];
			$from 				= $row['from'];
			$date_issued 		= $row['date_issued'] == '' ? '' : date('M d, Y',strtotime($row['date_issued']));
			$reported_by 		= get_emp_name_by_username_systemone($row['reported_by']);
			$product_name 		= $row['product_name'];
			$model_no 			= $row['model_no'];
			$batch_no_lot_no 	= $row['batch_no_lot_no'];
			$po_no_invoice_no 	= $row['po_no_invoice_no'];
			$date_received 		= $row['date_received'] == '' ? '' : date('M d, Y',strtotime($row['date_received']));
			$disposition 		= $row['disposition'];
			$disposition_others = $row['disposition_others'];
		}
		$subject 	 = $status.' QCFR: '.$po_no_invoice_no.' '.$product_name; 
		
		$status_a = explode(' ', $status);
		$body 	 	 = 'Please be informed that your QCFR has been done on approval process. You may now add the result of confirmation. <br> <br>';
		
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;'.$subcon_pmi.' <br>';
		$body 		.= '&emsp;To: '.$to.' <br>';
		$body 		.= '&emsp;to: '.$attn.' <br>';
		$body 		.= '&emsp;Cc: '.$cc.' <br>';
		$body 		.= '&emsp;From: '.$from.' <br>';
		$body 		.= '&emsp;Date Issued: '.$date_issued.' <br>';
		$body 		.= '&emsp;Product Name: '.$product_name.' <br>';
		$body 		.= '&emsp;Model No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;Batch No./Lot No.: '.$batch_no_lot_no.' <br>';
		$body 		.= '&emsp;PO No./Inv. No.: '.$po_no_invoice_no.' <br>';
		$body 		.= '&emsp;Date Received: '.$date_received.' <br>';
		$body 		.= '&emsp;Disposition: '.str_replace(' | ', ', ', $disposition).' <br>';
		$body 		.= '&emsp;Reported By: '.$reported_by.' <br>';
		
		/* Select recipients */
		$send_to 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$sent_from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		
		$php_mailer = new email();
		$php_mailer->send_email($send_to, $sent_from, $sent_from, $subject, $body,'','');
	}
	
	function return_next_qcfr_main_status($pkid, $previous_status, $username) {
		require_once('../class/oop_tqts.php');
		$array_fields	= array('*');
		$table  	 	= "tbl_qfr_qcfr";
		$joins  	 	= "";
		$sql_where  	= "WHERE `pkid` = '$pkid'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$next_status 	= '';
		if($row = mysqli_fetch_assoc($result)){	
			if($row['subcon_pmi'] == 'Supplier/Subcon') {
				if($previous_status == "ACCEPT LQC SUPERVISOR" ) {
					$next_status = 'FOR APPROVAL SECTHEAD';
					update_next_approver_status("approved_by_sh_logs", "PENDING", $pkid, $username);
				} else if($previous_status == "APPROVED SECTHEAD" ) {
					$next_status = $row['answer'] == 'Need' ? 'RECIPIENT FILL-IN' : 'FOR ADD ANSWER';
				} else if($previous_status == "CHECKED LQC" ) {
					$next_status = 'FOR CHECKING';
					update_next_approver_status("pmi_orginator_fill_in_approved_by_logs", "PENDING", $pkid, $username);
				} else if($previous_status == "APPROVED QC HEAD" ) {
					$next_status = 'CLOSED';
				}
			} else {
				if($previous_status == "ACCEPT LQC SUPERVISOR" ) {
					if($row['verified_conformed_by_eng'] != '' && $row['verified_conformed_by_prdn'] == '') {
						$next_status = 'FOR APPROVAL ENGINEERING';
						update_next_approver_status("verified_conformed_by_eng_logs", "PENDING", $pkid, $username);
					} else if($row['verified_conformed_by_eng'] == '' && $row['verified_conformed_by_prdn'] != '') {
						$next_status = 'FOR APPROVAL PRODUCTION';
						update_next_approver_status("verified_conformed_by_prdn_logs", "PENDING", $pkid, $username);
					} else {
						$next_status = 'FOR APPROVAL ENGR/PRDN';
						update_next_approver_status("verified_conformed_by_eng_logs", "PENDING", $pkid, $username);
						update_next_approver_status("verified_conformed_by_prdn_logs", "PENDING", $pkid, $username);
					}
				} else {
					if($previous_status == "ACCEPT ENGINEERING") {
						$next_status = "FOR APPROVAL ENGINEERING1";
					} else if($previous_status == "ACCEPT PRODUCTION") {
						$next_status = "FOR APPROVAL PRODUCTION1";
					} else if($previous_status == "APPROVED SECTHEAD" ) {
						$next_status = "FOR APPROVAL DEPTHEAD";
						update_next_approver_status("approved_by_dh_logs", "PENDING", $pkid, $username);
					} else if($previous_status == "APPROVED DEPTHEAD" ) {
						$next_status = $row['answer'] == 'Need' ? 'RECIPIENT FILL-IN' : 'FOR ADD ANSWER';
					} else if($previous_status == "CHECKED LQC" ) {
						$next_status = 'FOR CHECKING';
						update_next_approver_status("pmi_orginator_fill_in_approved_by_logs", "PENDING", $pkid, $username);
					} else if($previous_status == "APPROVED QC HEAD" ) {
						$next_status = 'CLOSED';
					}
				}
			}
		
			 
		}
		
		return $next_status;
	}
	
	function check_if_eng_prdn_approved($pkid) {
		require_once('../class/oop_tqts.php');
		$array_fields	= array('*');
		$table  	 	= "tbl_qfr_qcfr";
		$joins  	 	= "";
		$sql_where  	= "WHERE `pkid` = '$pkid' AND (verified_conformed_by_lqc_logs LIKE '%PENDING%' AND verified_conformed_by_eng_logs LIKE '%PENDING%')";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		return $result->num_rows;
	}
	
	function update_next_approver_status($approver_field, $approver_value, $pkid, $username) {
		$date_time_today = date('Y-m-d H:i:s');
		$table  	 	= "tbl_qfr_qcfr";
		$array_fields 	= array($approver_field,"lastupdate", "username"); 
		$array_values 	= array($approver_value, $date_time_today, $username);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
	}
	
	function update_status_main($pkid, $username) {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$table  		= "tbl_qfr_qcfr";
		$array_fields	= array('verified_conformed_by_lqc', 'verified_conformed_by_lqc_logs', 'verified_conformed_by_eng', 'verified_conformed_by_eng_logs', 'verified_conformed_by_prdn', 'verified_conformed_by_prdn_logs','approved_by_sh_logs', 'approved_by_dh_logs', 'approved_by_dh','pmi_orginator_fill_in_checked_by','pmi_orginator_fill_in_checked_by_logs','pmi_orginator_fill_in_approved_by_logs','nature_of_request');
		$joins  	 	= "";
		$sql_where  	= "WHERE `pkid` = '$pkid'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script         = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$status 		= '';
		if($row = mysqli_fetch_assoc($result)){	
			if($row['approved_by_sh_logs'] == '') {
				if($row['verified_conformed_by_lqc'] != '' && strstr($row['verified_conformed_by_lqc_logs'],"ACCEPT")) {
					$status = 'FOR APPROVAL';
				} if($row['verified_conformed_by_lqc'] != '' && strstr($row['verified_conformed_by_lqc_logs'],"REJECT")) {
					$status = 'REJECT LQC';
				} if($row['verified_conformed_by_eng'] != '' && strstr($row['verified_conformed_by_eng_logs'] == '',"ACCEPT")) {
					$status = 'FOR APPROVAL';
				} if($row['verified_conformed_by_eng'] != '' && strstr($row['verified_conformed_by_eng_logs'] == '',"REJECT")) {
					$status = 'REJECT ENGINEERING';
				} if($row['verified_conformed_by_prdn'] != '' && strstr($row['verified_conformed_by_prdn_logs'] == '',"ACCEPT")) {
					$status = 'FOR APPROVAL';
				} if($row['verified_conformed_by_prdn'] != '' && strstr($row['verified_conformed_by_prdn_logs'] == '',"REJECT")) {
					$status = 'REJECT PRODUCTION';
				} if($row['pmi_orginator_fill_in_checked_by'] != '' && strstr($row['pmi_orginator_fill_in_checked_by_logs'] == '',"CHECKED")) {
					$status = 'FOR CHECKING';
				} if($row['pmi_orginator_fill_in_checked_by'] != '' && strstr($row['pmi_orginator_fill_in_checked_by_logs'] == '',"REJECT LQC")) {
					$status = 'REJECT LQC CHECKED';
				}
				
				if($status == 'FOR APPROVAL') {
					$array_fields 	= array("status","approved_by_sh_logs","lastupdate", "username");
					$array_values 	= array($status." SECTHEAD","PENDING",$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				} else if(strstr($status, "REJECT")) {
					$array_fields 	= array("status","lastupdate", "username");
					$array_values 	= array($status,$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				} else {
					$array_fields 	= array("status","lastupdate", "username");
					$array_values 	= array("FOR VERIFICATION",$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
			} else {
				if($row['nature_of_request'] == 'For Information only') {
					$status = 'FOR ADD ANSWER';
					$date_answer_required = '';
				} else {
					$status = 'RECIPIENT FILL-IN';
					$date_answer_required = date('Y-m-d', strtotime(date('Y-m-d').'+3 days'));
				} 
				//For Supplier/Subcon
				if(strstr($row['approved_by_sh_logs'], 'APPROVED') && $row['approved_by_dh'] == ''  && $row['pmi_orginator_fill_in_checked_by_logs'] == '' ) {
					$array_fields 	= array("status","recipient_fill-in_logs","date_answer_required","lastupdate", "username"); //revise date answer; add 3 days after approval
					$array_values 	= array($status,$date_time_today,$date_answer_required, $date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
				if(strstr($row['approved_by_sh_logs'], 'APPROVED') && $row['approved_by_dh'] == ''  && $row['pmi_orginator_fill_in_checked_by_logs'] != '' && $row['pmi_orginator_fill_in_approved_by_logs'] == '' ) {
					$array_fields 	= array("status","pmi_orginator_fill_in_approved_by_logs","lastupdate", "username"); 
					$array_values 	= array("FOR APPROVAL QC HEAD", "PENDING", $date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
				//For PMI Assy.
				if(strstr($row['approved_by_sh_logs'], 'APPROVED') && $row['approved_by_dh'] != '' && $row['approved_by_dh_logs'] == '') {
					$array_fields 	= array("status","approved_by_dh_logs","lastupdate", "username");
					$array_values 	= array("FOR APPROVAL DEPTHEAD","PENDING",$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
				if((strstr($row['approved_by_dh_logs'], 'APPROVED')) && ($row['pmi_orginator_fill_in_checked_by_logs'] == '')) {
					$array_fields 	= array("status","lastupdate", "username");
					$array_values 	= array($status,$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
				if(strstr($row['pmi_orginator_fill_in_checked_by_logs'], 'CHECKED') && $row['pmi_orginator_fill_in_approved_by_logs'] == '-') {
					$array_fields 	= array("status","pmi_orginator_fill_in_approved_by_logs","lastupdate", "username");
					$array_values 	= array("FOR CHECKING","PENDING",$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
				if(strstr($row['pmi_orginator_fill_in_approved_by_logs'], 'APPROVED')) {
					$array_fields 	= array("status","lastupdate", "username");
					$array_values 	= array("CLOSED",$date_time_today, $username);
					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
					$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				}
			}
		}	
	}
	
	function update_qcfr() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$username = $_POST['username'];
		$pkid = $_POST['pkid'];
		/* Get all fields to be inserted */		
		$table 						= "tbl_qfr_qcfr";
		$values 					= get_fields_values($_POST,array("action","username","to","attn","cc_supplier","cc_pmi","from","subcon_pmi","found_during","inspection_method","disposition","nature_of_request","reported_by","verified_conformed_by_eng","verified_conformed_by_prdn","pkid"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "to"; 								$array_values[] = isset($_POST['to']) ? $_POST['to'] : '';
		$array_fields[] 			= "attn"; 								$array_values[] = isset($_POST['attn']) ? implode(' | ', $_POST['attn']) : '';
		$array_fields[] 			= "cc_supplier"; 						$array_values[] = isset($_POST['cc_supplier']) ? $_POST['cc_supplier'] : '';
		$array_fields[] 			= "cc_pmi"; 							$array_values[] = isset($_POST['cc_pmi']) ? implode(' | ', $_POST['cc_pmi']) : '';
		$array_fields[] 			= "from"; 								$array_values[] = $_POST['from'];
		$array_fields[] 			= "verified_conformed_by_lqc_logs";		$array_values[] = $_POST['verified_conformed_by_lqc'] == '' ? '' : 'PENDING';
		$array_fields[] 			= "verified_conformed_by_eng";			$array_values[] = isset($_POST['verified_conformed_by_eng']) ? implode(',',$_POST['verified_conformed_by_eng']) : '';
		$array_fields[] 			= "verified_conformed_by_eng_logs";		$array_values[] = '';
		$array_fields[] 			= "verified_conformed_by_prdn";			$array_values[] = isset($_POST['verified_conformed_by_prdn']) ? implode(',',$_POST['verified_conformed_by_prdn']) : '';
		$array_fields[] 			= "verified_conformed_by_prdn_logs";	$array_values[] = '';
		$array_fields[] 			= "subcon_pmi"; 						$array_values[] = implode(' | ', $_POST['subcon_pmi']);
		$array_fields[] 			= "found_during"; 						$array_values[] = isset($_POST['found_during']) ? implode(' | ', $_POST['found_during']) : '';
		$array_fields[] 			= "inspection_method"; 					$array_values[] = implode(' | ', $_POST['inspection_method']);
		$array_fields[] 			= "disposition"; 						$array_values[] = implode(' | ', $_POST['disposition']);
		$array_fields[] 			= "nature_of_request"; 					$array_values[] = implode(' | ', $_POST['nature_of_request']);
		$array_fields[] 			= "reported_by_date_time"; 				$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "approved_by_sh_logs"; 				$array_values[] = '';
		$array_fields[] 			= "approved_by_dh_logs"; 				$array_values[] = '';
		$array_fields[] 			= "lastupdate"; 						$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 							$array_values[] = $username;
		
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		
		/* Upload attachment */
		if(count($_FILES['file_failure_defect_filename']['name']) != 0) {
			$file_ctr = 1;
			for($i=0;$i<count($_FILES['file_failure_defect_filename']['name']);$i++) {
				$temp_file 	     = $_FILES["file_failure_defect_filename"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_failure_defect_filename"]["name"][$i];
				
				if($_FILES["file_failure_defect_filename"]["tmp_name"][0] != '') {
					$file  		     	= return_file_path_by_div_mod('qfr_qcfr_request');
					$fkfile_path     	= $file['pkid'];
					$target_dir      	= $file['path'];
					$target_file 	 	= $target_dir . $file_name;	
					if (file_exists($target_file)) {
						$msg 					= "Sorry, your file already exists.";
						$return['error']		= $msg;
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {		
							$table 				= 'tbl_qfr_qcfr_attachments';						
							$array_fields 		= array("logdel", "lastupdate", "username");
							$array_values 		= array("1", $date_time_today, $username);
							$sql_where			= 'WHERE qcfr_no='.$pkid;
							$result				= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
							$script 		   .= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$sql_where);
							
							$array_fields 		= array("date_time_created", "created_by", "fkqcfr", "category", "file_name", "fkfile_path" , "lastupdate", "username");
							$array_values 		= array($date_time_today, $username, $pkid, "REQUEST", $file_name, $fkfile_path, $date_time_today, $username);
							$attachments_id		= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
							$script 			= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
														
							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							$new_file_name  = $attachments_id.".".$ext;
							if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
								$msg .= '<br>File was successfully uploaded to the system';
							} else {
								$msg .= '<br>There was an error on renaming the file.';
							}	
						}
						
					}
				}
			}
		}
		if($pkid != false) {
			send_email_qcfr_verified_conformance($pkid, 'edit');
		}
		
		$return['msg'] 	= $msg;
		$return['POST'] 	= $_POST;
		$return['_FILES'] 	= $_FILES;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function get_qcfr_details_by_pkid() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$action2 						= $_POST["action2"];
		$table  						= "tbl_qfr_qcfr";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){	
			if($action2 == 'edit') {
				$row['reported_by']	 				= get_emp_name_by_username_systemone($row['reported_by']);
				
				$array_to = explode(",",$row['to']);
				$row['to'] = array();
				foreach($array_to as $key => $value){
					$array_data_to 			= array();
					$array_data_to['id'] 		= $value;
					$array_data_to['text'] 	= get_emp_name_by_username_systemone($value);
					$row['to'][]	= $array_data_to;
				}
				$array_attn = explode(" | ",$row['attn']);
				$row['attn'] = array();
				foreach($array_attn as $key => $value){
					$array_data_attn 			= array();
					$array_data_attn['id'] 		= $value;
					$array_data_attn['text'] 	= get_emp_name_by_username_systemone($value);
					$row['attn'][]				= $array_data_attn;
				}
				$array_cc_pmi = explode(" | ",$row['cc_pmi']);
				$row['cc_pmi'] = array();
				foreach($array_cc_pmi as $key => $value){
					$array_data_cc_pmi 			= array();
					$array_data_cc_pmi['id'] 	= $value;
					$array_data_cc_pmi['text'] 	= get_emp_name_by_username_systemone($value);
					$row['cc_pmi'][]			= $array_data_cc_pmi;
				}
				$array_from = explode(",",$row['from']);
				$row['from'] = array();
				foreach($array_from as $key => $value){
					$array_data_from 			= array();
					$array_data_from['id'] 		= $value;
					$array_data_from['text'] 	= get_emp_name_by_username_systemone($value);
					$row['from'][]			= $array_data_from;
				}
				$array_batch_no_lot_no = explode(",",$row['batch_no_lot_no']);
				$row['batch_no_lot_no'] = array();
				foreach($array_batch_no_lot_no as $key => $value){
					$array_data_batch_no_lot_no 		= array();
					$array_data_batch_no_lot_no['id'] 	= $value;
					$array_data_batch_no_lot_no['text'] = $value;
					$row['batch_no_lot_no'][]			= $array_data_batch_no_lot_no;
				}
				$array_verified_conformed_by_lqc = explode(",",$row['verified_conformed_by_lqc']);
				$row['verified_conformed_by_lqc'] = array();
				foreach($array_verified_conformed_by_lqc as $key => $value){
					$array_data_vcl 			= array();
					$array_data_vcl['id'] 		= $value;
					$array_data_vcl['text'] 	= get_emp_name_by_username_systemone($value);
					$row['verified_conformed_by_lqc'][]	= $array_data_vcl;
				}
				$array_verified_conformed_by_eng = explode(",",$row['verified_conformed_by_eng']);
				$row['verified_conformed_by_eng'] = array();
				foreach($array_verified_conformed_by_eng as $key => $value){
					$array_data_vce 			= array();
					$array_data_vce['id'] 		= $value;
					$array_data_vce['text'] 	= get_emp_name_by_username_systemone($value);
					$row['verified_conformed_by_eng'][]	= $array_data_vce;
				}
				$array_verified_conformed_by_prdn = explode(",",$row['verified_conformed_by_prdn']);
				$row['verified_conformed_by_prdn'] = array();
				foreach($array_verified_conformed_by_prdn as $key => $value){
					$array_data_vcp 			= array();
					$array_data_vcp['id'] 		= $value;
					$array_data_vcp['text'] 	= get_emp_name_by_username_systemone($value);
					$row['verified_conformed_by_prdn'][]	= $array_data_vcp;
				}
				$array_approved_by_sh = explode(",",$row['approved_by_sh']);
				$row['approved_by_sh'] = array();
				foreach($array_approved_by_sh as $key => $value){
					$array_data_ash 			= array();
					$array_data_ash['id'] 		= $value;
					$array_data_ash['text'] 	= get_emp_name_by_username_systemone($value);
					$row['approved_by_sh'][]	= $array_data_ash;
				}
				$array_approved_by_dh = explode(",",$row['approved_by_dh']);
				$row['approved_by_dh'] = array();
				foreach($array_approved_by_dh as $key => $value){
					$array_data_adh 			= array();
					$array_data_adh['id'] 		= $value;
					$array_data_adh['text'] 	= get_emp_name_by_username_systemone($value);
					$row['approved_by_dh'][]	= $array_data_adh;
				}				
				$array_created_by = explode(",",$row['created_by']);
				$row['created_by'] = array();
				foreach($array_created_by as $key => $value){
					$array_data_cb 				= array();
					$array_data_cb['id'] 		= $value;
					$array_data_cb['text'] 		= get_emp_name_by_username_systemone($value);
					$row['created_by'][]		= $array_data_cb;
				}				
				$array_pmi_orginator_fill_in_checked_by = explode(",",$row['pmi_orginator_fill_in_checked_by']);
				$row['pmi_orginator_fill_in_checked_by'] = array();
				foreach($array_pmi_orginator_fill_in_checked_by as $key => $value){
					$array_data_poc 			= array();
					$array_data_poc['id'] 		= $value;
					$array_data_poc['text'] 	= get_emp_name_by_username_systemone($value);
					$row['pmi_orginator_fill_in_checked_by'][]		= $array_data_poc;
				}			
				$array_pmi_orginator_fill_in_approved_by = explode(",",$row['pmi_orginator_fill_in_approved_by']);
				$row['pmi_orginator_fill_in_approved_by'] = array();
				foreach($array_pmi_orginator_fill_in_approved_by as $key => $value){
					$array_data_poa 			= array();
					$array_data_poa['id'] 		= $value;
					$array_data_poa['text'] 	= get_emp_name_by_username_systemone($value);
					$row['pmi_orginator_fill_in_approved_by'][]		= $array_data_poa;
				}
			}			
			if($action2 == 'view') {
				$attn = explode(' | ', $row['attn']);
				foreach($attn as $key => $value) {
					$attention[] = get_emp_name_by_username_systemone($value);
				}
				$cc_pmi_a = explode(' | ', $row['cc_pmi']);
				foreach($cc_pmi_a as $key => $value) {
					$cc_pmi[] = get_emp_name_by_username_systemone($value);
				}
				$engineering = explode(',', $row['verified_conformed_by_eng']);
				foreach($engineering as $key => $value) {
					$verified_conformed_by_eng[] = get_emp_name_by_username_systemone($value);
				}
				$production = explode(',', $row['verified_conformed_by_prdn']);
				foreach($production as $key => $value) {
					$verified_conformed_by_prdn[] = get_emp_name_by_username_systemone($value);
				}
				
				$row['reported_by']	 				= get_emp_name_by_username_systemone($row['reported_by']);
				$row['verified_conformed_by_lqc'] 	= get_emp_name_by_username_systemone($row['verified_conformed_by_lqc']);
				$row['attn'] 						= implode(', ',$attention);
				$row['cc'] 							= $row['subcon_pmi'] == 'Supplier/Subcon' ? $row['cc_supplier'] : implode(', ',$cc_pmi);
				$row['verified_conformed_by_eng'] 	= implode(', ',$verified_conformed_by_eng);
				$row['verified_conformed_by_prdn'] 	= implode(', ',$verified_conformed_by_prdn);
				$row['approved_by_sh'] 				= get_emp_name_by_username_systemone($row['approved_by_sh']);
				$row['approved_by_dh'] 				= get_emp_name_by_username_systemone($row['approved_by_dh']);
				$row['created_by'] 					= get_emp_name_by_username_systemone($row['created_by']);
				$row['pmi_orginator_fill_in_checked_by']  = get_emp_name_by_username_systemone($row['pmi_orginator_fill_in_checked_by']);
				$row['pmi_orginator_fill_in_approved_by'] = get_emp_name_by_username_systemone($row['pmi_orginator_fill_in_approved_by']);
				
				
			}			
			
			$row['request_attachment'] 	= check_if_has_qcfr_attachment($pkid, "request");
			$return['data'][0]	= $row;
		}		
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_qcfr_fill_in_signatories() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$table  						= "tbl_qfr_qcfr";
		$array_fields					= array('created_by', 'verified_conformed_by_lqc', 'approved_by_sh');
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){	
			$array_created_by = explode(",",$row['created_by']);
			$row['created_by'] = array();
			foreach($array_created_by as $key => $value){
				$array_data_cb 				= array();
				$array_data_cb['id'] 		= $value;
				$array_data_cb['text'] 		= get_emp_name_by_username_systemone($value);
				$row['created_by'][]		= $array_data_cb;
			}	
			$array_verified_conformed_by_lqc = explode(",",$row['verified_conformed_by_lqc']);
			$row['verified_conformed_by_lqc'] = array();
			foreach($array_verified_conformed_by_lqc as $key => $value){
				$array_data_vcl 			= array();
				$array_data_vcl['id'] 		= $value;
				$array_data_vcl['text'] 	= get_emp_name_by_username_systemone($value);
				$row['pmi_orginator_fill_in_checked_by'][]	= $array_data_vcl;
			}
			$array_approved_by_sh = explode(",",$row['approved_by_sh']);
			$row['approved_by_sh'] = array();
			foreach($array_approved_by_sh as $key => $value){
				$array_data_ash 			= array();
				$array_data_ash['id'] 		= $value;
				$array_data_ash['text'] 	= get_emp_name_by_username_systemone($value);
				$row['pmi_orginator_fill_in_approved_by'][]	= $array_data_ash;
			}		
			$return['data'][0]	= $row;
		}		
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_wbs_invoiceno_list() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$action2 						= $_POST["action2"];
		$table  						= "tbl_qfr_qcfr";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= WBSSUBSYSTEM::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= WBSSUBSYSTEM::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){	
			if($action2 == 'edit') {
				$array_reported_by = explode(",",$row['reported_by']);
				$row['reported_by'] = array();
				foreach($array_reported_by as $key => $value){
					$array_data_rb 				= array();
					$array_data_rb['id'] 		= $value;
					$array_data_rb['text'] 		= get_emp_name_by_username_systemone($value);
					$row['reported_by'][]		= $array_data_rb;
				}
				$array_verified_conformed_by_lqc = explode(",",$row['verified_conformed_by_lqc']);
				$row['verified_conformed_by_lqc'] = array();
				foreach($array_verified_conformed_by_lqc as $key => $value){
					$array_data_vcl 			= array();
					$array_data_vcl['id'] 		= $value;
					$array_data_vcl['text'] 	= get_emp_name_by_username_systemone($value);
					$row['verified_conformed_by_lqc'][]	= $array_data_vcl;
				}
				$array_verified_conformed_by_eng = explode(",",$row['verified_conformed_by_eng']);
				$row['verified_conformed_by_eng'] = array();
				foreach($array_verified_conformed_by_eng as $key => $value){
					$array_data_vce 			= array();
					$array_data_vce['id'] 		= $value;
					$array_data_vce['text'] 	= get_emp_name_by_username_systemone($value);
					$row['verified_conformed_by_eng'][]	= $array_data_vce;
				}
				$array_verified_conformed_by_prdn = explode(",",$row['verified_conformed_by_prdn']);
				$row['verified_conformed_by_prdn'] = array();
				foreach($array_verified_conformed_by_prdn as $key => $value){
					$array_data_vcp 			= array();
					$array_data_vcp['id'] 		= $value;
					$array_data_vcp['text'] 	= get_emp_name_by_username_systemone($value);
					$row['verified_conformed_by_prdn'][]	= $array_data_vcp;
				}
				$array_approved_by_sh = explode(",",$row['approved_by_sh']);
				$row['approved_by_sh'] = array();
				foreach($array_approved_by_sh as $key => $value){
					$array_data_ash 			= array();
					$array_data_ash['id'] 		= $value;
					$array_data_ash['text'] 	= get_emp_name_by_username_systemone($value);
					$row['approved_by_sh'][]	= $array_data_ash;
				}
				$array_approved_by_dh = explode(",",$row['approved_by_dh']);
				$row['approved_by_dh'] = array();
				foreach($array_approved_by_dh as $key => $value){
					$array_data_adh 			= array();
					$array_data_adh['id'] 		= $value;
					$array_data_adh['text'] 	= get_emp_name_by_username_systemone($value);
					$row['approved_by_dh'][]	= $array_data_adh;
				}				
				$array_created_by = explode(",",$row['created_by']);
				$row['created_by'] = array();
				foreach($array_created_by as $key => $value){
					$array_data_cb 				= array();
					$array_data_cb['id'] 		= $value;
					$array_data_cb['text'] 		= get_emp_name_by_username_systemone($value);
					$row['created_by'][]		= $array_data_cb;
				}				
				$array_pmi_orginator_fill_in_checked_by = explode(",",$row['pmi_orginator_fill_in_checked_by']);
				$row['pmi_orginator_fill_in_checked_by'] = array();
				foreach($array_pmi_orginator_fill_in_checked_by as $key => $value){
					$array_data_poc 			= array();
					$array_data_poc['id'] 		= $value;
					$array_data_poc['text'] 	= get_emp_name_by_username_systemone($value);
					$row['pmi_orginator_fill_in_checked_by'][]		= $array_data_poc;
				}			
				$array_pmi_orginator_fill_in_approved_by = explode(",",$row['pmi_orginator_fill_in_approved_by']);
				$row['pmi_orginator_fill_in_approved_by'] = array();
				foreach($array_pmi_orginator_fill_in_approved_by as $key => $value){
					$array_data_poa 			= array();
					$array_data_poa['id'] 		= $value;
					$array_data_poa['text'] 	= get_emp_name_by_username_systemone($value);
					$row['pmi_orginator_fill_in_approved_by'][]		= $array_data_poa;
				}
			}			
			if($action2 == 'view') {
				$row['reported_by']	 				= get_emp_name_by_username_systemone($row['reported_by']);
				$row['verified_conformed_by_lqc'] 	= get_emp_name_by_username_systemone($row['verified_conformed_by_lqc']);
				$row['verified_conformed_by_eng'] 	= get_emp_name_by_username_systemone($row['verified_conformed_by_eng']);
				$row['verified_conformed_by_prdn'] 	= get_emp_name_by_username_systemone($row['verified_conformed_by_prdn']);
				$row['approved_by_sh'] 				= get_emp_name_by_username_systemone($row['approved_by_sh']);
				$row['approved_by_dh'] 				= get_emp_name_by_username_systemone($row['approved_by_dh']);
				$row['created_by'] 					= get_emp_name_by_username_systemone($row['created_by']);
				$row['pmi_orginator_fill_in_checked_by']  = get_emp_name_by_username_systemone($row['pmi_orginator_fill_in_checked_by']);
				$row['pmi_orginator_fill_in_approved_by'] = get_emp_name_by_username_systemone($row['pmi_orginator_fill_in_approved_by']);
				
				
			}			
			$return['data'][0]	= $row;
		}		
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function add_recipient_fillin() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$fkqcfr    	 	 = $_POST['fkqcfr'];
		$username    	 = $_POST['username'];
		$msg			 = '';				
				
		$table			= 'tbl_qfr_qcfr';
		$array_fields 	= array("status", "lastupdate", "username");
		$array_values 	= array("FOR ADD ANSWER", $date_time_today, $username);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$fkqcfr);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$fkqcfr);
		
		/* Upload attachment - 8D report */
		$table 			 = 'tbl_qfr_qcfr_attachments';
		if(count($_FILES['file_name_8d_report']['name']) != 0) {
			$file_ctr = 1;
			for($i=0;$i<count($_FILES['file_name_8d_report']['name']);$i++) {
				$temp_file 	     = $_FILES["file_name_8d_report"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_name_8d_report"]["name"][$i];
				
				if($_FILES["file_name_8d_report"]["tmp_name"][0] != '') {
					$file  		     	= return_file_path_by_div_mod('qfr_qcfr_recipient_fillin_8d');
					$fkfile_path     	= $file['pkid'];
					$target_dir      	= $file['path'];
					$target_file 	 	= $target_dir . $file_name;	
					if (file_exists($target_file)) {
						$msg 					= "Sorry, your file already exists.";
						$return['error']		= $msg;
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {								
							$array_fields 				= array("date_time_created", "created_by", "fkqcfr", "category", "file_name", "fkfile_path" , "lastupdate", "username");
							$array_values 				= array($date_time_today, $username, $fkqcfr, "8D", $file_name, $fkfile_path, $date_time_today, $username);
							$pkid						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
							$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
														
							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							$new_file_name  = $pkid.".".$ext;
							if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
								$msg .= '<br>File was successfully uploaded to the system';
							} else {
								$msg .= '<br>There was an error on renaming the file.';
							}	
						}						
					}
				}
			}
		}
		
		/* Upload attachment - CAPA report */
		if(count($_FILES['file_name_capa']['name']) != 0) {
			$file_ctr = 1;
			for($i=0;$i<count($_FILES['file_name_capa']['name']);$i++) {
				$temp_file 	     = $_FILES["file_name_capa"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_name_capa"]["name"][$i];
				
				if($_FILES["file_name_capa"]["tmp_name"][0] != '') {
					$file  		     	= return_file_path_by_div_mod('qfr_qcfr_recipient_fillin_8d');
					$fkfile_path     	= $file['pkid'];
					$target_dir      	= $file['path'];
					$target_file 	 	= $target_dir . $file_name;	
					if (file_exists($target_file)) {
						$msg 					= "Sorry, your file already exists.";
						$return['error']		= $msg;
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {								
							$array_fields 				= array("date_time_created", "created_by", "fkqcfr", "category", "file_name", "fkfile_path" , "lastupdate", "username");
							$array_values 				= array($date_time_today, $username, $fkqcfr, "CAPA", $file_name, $fkfile_path, $date_time_today, $username);
							$pkid						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
							$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
														
							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							$new_file_name  = $pkid.".".$ext;
							if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
								$msg .= '<br>File was successfully uploaded to the system';
							} else {
								$msg .= '<br>There was an error on renaming the file.';
							}	
						}						
					}
				}
			}
		}
		
		$return['msg'] 	= 'New record has been saved'.$msg;
		$return['POST'] 	= $_POST;
		$return['_FILES'] 	= $_FILES;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function update_originator_fillin() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$pkid    	 	 = $_POST['pkid'];
		$username    	 = $_POST['username'];
		$msg			 = '';				
				
		$table			= 'tbl_qfr_qcfr';
		$array_fields 	= array('status','factory_line_audit', 'treatment_affected_lot', 'verification_result', 'pmi_orginator_fill_in_checked_by', 'pmi_orginator_fill_in_checked_by_logs', 'pmi_orginator_fill_in_approved_by', 'pmi_orginator_fill_in_approved_by_logs','lastupdate', 'username');
		$array_values 	= array('FOR QC CHECKING',implode(',',$_POST['factory_line_audit']), $_POST['treatment_affected_lot'], $_POST['verification_result'], $_POST['pmi_orginator_fill_in_checked_by'], 'PENDING',$_POST['pmi_orginator_fill_in_approved_by'],'-',$date_time_today, $username);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$return['msg'] 	= $msg;
		send_email_qcfr_approvers_decision($pkid, $username, 'FOR QC CHECKING');
		$return['POST'] 	= $_POST;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function check_if_has_qcfr_attachment($pkid, $view_att) {
        require_once('../class/oop_tqts.php');
		
		/* Report attachments */
		if($view_att == 'REQUEST') {
			$array_fields = array('file_name');
			$table 	   	= 'tbl_qfr_qcfr_attachments';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkqcfr="'.$pkid.'" AND category="REQUEST" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= 'LIMIT 0,1';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			return $result->num_rows;
		} else if($view_att == '8D') {
			$array_fields = array('file_name');
			$table 	   	= 'tbl_qfr_qcfr_attachments';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkqcfr="'.$pkid.'" AND category="8D" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= 'LIMIT 0,1';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			return $result->num_rows;
		} else if($view_att == 'CAPA') {
			$array_fields = array('file_name');
			$table 	   	= 'tbl_qfr_qcfr_attachments';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkqcfr="'.$pkid.'" AND category="CAPA" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= 'LIMIT 0,1';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			return $result->num_rows;
		}  
    }

	function return_qcfr_attachments() {
        require_once('../class/oop_tqts.php');
        $fk_qcfr 		= $_POST['pkid'];
        $category 		= $_POST['category'];
		$table_body = '';
		
		/* Report attachments */
		if($category == 'REQUEST') {
			$array_fields = array('pkid','file_name');
			$table 	   	= 'tbl_qfr_qcfr_attachments';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkqcfr="'.$fk_qcfr.'" AND category="REQUEST" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row=mysqli_fetch_array($result)) {
				$table_body .= '<tr>';
				$table_body .= '	<td><a href="#" class="fa fa-paperclip" id="'.$row['pkid'].'" folder="new" style="display:inline-block;"> '.$row['file_name'].'</a></td>';
				$table_body .= '</tr>';
			}
		} else {
			$array_fields = array('pkid','file_name');
			$table 	   	= 'tbl_qfr_qcfr_attachments';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkqcfr="'.$fk_qcfr.'" AND (category="8D" or category="CAPA") AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row=mysqli_fetch_array($result)) {
				$table_body .= '<tr>';
				$table_body .= '	<td><a href="#" class="fa fa-paperclip" id="'.$row['pkid'].'" folder="new" style="display:inline-block;"> '.$row['file_name'].'</a></td>';
				$table_body .= '</tr>';
			}
		}
		$return['table_body'] = $table_body;
		echo json_encode($return);
    }
?>