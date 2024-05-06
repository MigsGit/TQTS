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
				case "remove_8d_attachment" 					: remove_8d_attachment(); break;
				case "load_8d_main_data" 						: load_8d_main_data(); break;
				case "edit_8d" 									: edit_8d(); break;
				
				/* advance search */
				case "qfr_8d_return_dir_fields" 				: qfr_8d_return_dir_fields(); break;
				case "qfr_8d_advance_search" 					: qfr_8d_advance_search(); break;
				
				/* qar */
				case "get_qar_data"								: get_qar_data(); break;
				case "save_qar"									: save_qar(); break;
				case "edit_qar"									: edit_qar(); break;
				case "get_last_ctrl_qar"						: get_last_ctrl_qar(); break;
				case "conform_and_send_qar"						: conform_and_send_qar(); break;
				case "reject_qar"								: reject_qar(); break;
				case "cancel_qar"								: cancel_qar(); break;
				case "close_qar"								: close_qar(); break;
				case "invalid_qar"								: invalid_qar(); break;
				case "add_disposition_qar_recipient"			: add_disposition_qar_recipient(); break;
				case "return_prod_code_list"					: return_prod_code_list(); break;
				case "get_qar_group_list"						: get_qar_group_list(); break;
				
				/* QCFR - used as a reference only */
				case "upload_qcfr"								: upload_qcfr(); break;
				case "save_qcfr"								: save_qcfr(); break;
				case "load_qcfr_data_details"					: load_qcfr_data_details(); break;
				case "re_upload_qcfr"							: re_upload_qcfr(); break;
				case "edit_qcfr"								: edit_qcfr(); break;
				case "cancel_qcfr"								: cancel_qcfr(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* 
		Note:
		1. Use pipe "|" as your delimiter
	*/
	
	/* QAR Start */
	function get_qar_data(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$table			= "tbl_iqc_qar";
		$array_fields  	= array('*');
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$_POST['id'].'"';
		$sql_order		= '';
		$sql_limit		= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['row'] 	= array();
		while($row = mysqli_fetch_assoc($result)){
			$return['row']	= $row;
		}
		/* for select2 data */
		if(count($return['row']) != 0){
			/* Attn */
			$array_attn = explode("|",$return['row']['attn']);
			$return['data_attn'] = array();
			foreach($array_attn as $key => $value){
				$array_data_attn = array();
				$array_data_attn['id'] 			= $value;
				$array_data_attn['text'] 		= get_emp_name_by_username_systemone($value);
				$return['data_attn'][] 			= $array_data_attn;
			}
			/* CC */
			$array_cc = explode("|",$return['row']['cc']);
			$return['data_cc'] = array();
			foreach($array_cc as $key => $value){
				$array_data_cc = array();
				$array_data_cc['id'] 			= $value;
				$array_data_cc['text'] 			= get_emp_name_by_username_systemone($value);
				$return['data_cc'][] 			= $array_data_cc;
			}
			/* QC Supervisor */
			$array_cc = explode("|",$return['row']['qc_supervisor']);
			$return['data_qc_supervisor'] = array();
			foreach($array_cc as $key => $value){
				$array_data_cc = array();
				$array_data_cc['id'] 			= $value;
				$array_data_cc['text'] 			= get_emp_name_by_username_systemone($value);
				$return['data_qc_supervisor'][]	= $array_data_cc;
			}
		}
		$return['row']['file_src_ok_condition_file'] = "";
		if($return['row']['ok_condition_files'] != ""){
			$file_path_ok 							= return_file_path_by_div_mod('iqc_qar_ok');
			$return['row']['file_src_ok_condition_file']	= str_replace("../","",$file_path_ok['path'].$return['row']['pkid'].'/'.$return['row']['ok_condition_files']);
		}
		$return['row']['file_src_ng_condition_file'] = "";
		if($return['row']['ng_condition_files'] != ""){
			$file_path_ok 							= return_file_path_by_div_mod('iqc_qar_ng');
			$return['row']['file_src_ng_condition_file']	= str_replace("../","",$file_path_ok['path'].$return['row']['pkid'].'/'.$return['row']['ng_condition_files']);
		}
		if($return['row']['file_src_ok_condition_file'] == ""){
			$return['row']['file_src_ok_condition_file'] = "uploaded_file/no_image.jpg";
		}
		if($return['row']['file_src_ng_condition_file'] == ""){
			$return['row']['file_src_ng_condition_file'] = "uploaded_file/no_image.jpg";
		}
		/* Disposition Portion */
		/* check if request has and uploaded disposition */
		if($return['row']['status'] == 3 || $return['row']['status'] == 4){
			if( $return['row']['status'] == 3 ){
				$return['row']['span_disposition_text'] = 'For Review Disposition';
				$return['row']['span_disposition_class'] = 'badge highlight-color-yellow pull-right';
			}
			if( $return['row']['status'] == 4 ){
				$return['row']['span_disposition_text'] = 'Closed Disposition';
				$return['row']['span_disposition_class'] = 'badge highlight-color-green pull-right';
			}
		}else{
			$return['row']['span_disposition_text'] = 'No Disposition';
			$return['row']['span_disposition_class'] = 'badge highlight-color-red pull-right';
		}
		echo json_encode($return);
	}
	
	function save_qar(){
		/* tweek some values */
		$error = array();
		if(isset($_POST['to'])){ 	
			$_POST['to']	= $_POST['to']; 	
		}else{
			$_POST['to']	= "";
		}
		if(isset($_POST['attn'])){ 	
			$_POST['attn']	= implode("|",$_POST['attn']); 	
		}else{
			$_POST['attn']	= "";
		}
		if(isset($_POST['cc'])){ 	
			$_POST['cc']	= implode("|",$_POST['cc']); 	
		}else{
			$_POST['cc']	= "";
		}
		if(isset($_POST['qc_supervisor'])){ 	
			$_POST['qc_supervisor']	= implode("|",$_POST['qc_supervisor']); 	
		}else{
			$_POST['qc_supervisor']	= "";
		}
		$return 					= $_POST;		
		$return['ng_file'] 			= $_FILES['ng_condition_files'];		
		$return['ok_file'] 			= $_FILES['ok_condition_files'];	
		$return['reference_file'] 	= $_FILES['reference_files'];	
		/* check image size */
		$ok_filesize 			= convert_file_size_to_mb($_FILES['ok_condition_files']['size']);
		$ng_filesize 			= convert_file_size_to_mb($_FILES['ng_condition_files']['size']);
		if($ok_filesize > 2){
			$error[] = "Ok image cannot exceed 2mb!";
		}
		if($ng_filesize > 2){
			$error[] = "NG Image cannot exceed 2mb!";
		}
		/* Check if uploaded file is an image */
		$image_mime_type = array("image/png","image/jpeg","image/bmp");
		
		if(!in_array($_FILES['ok_condition_files']['type'],$image_mime_type) && $_FILES['ok_condition_files']['name'] != ""){
			$error[] = "Uploaded File for OK condition is not an image!";
		}
		if(!in_array($_FILES['ng_condition_files']['type'],$image_mime_type) && $_FILES['ng_condition_files']['name'] != ""){
			$error[] = "Uploaded File for NG condition is not an image!";
		}
		if($_POST['section'] == ""){
			$error[] = "Your account has not been assigned with a section, Please contact the system administrator.";
		}
		if($_POST['to'] == ""){
			$error[] = "Please enter a value for [to:]";
		}
		if($_POST['cc'] == ""){
			$error[] = "Please enter a value for [cc:]";
		}
		if($_POST['attn'] == ""){
			$error[] = "Please enter a value for [attn:]";
		}
		if($_POST['lot_name'] == ""){
			$error[] = "Please enter a lot number";
		}
		if($_POST['mode_of_defect'] == ""){
			$error[] = "Please enter a mode of defect";
		}
		$return['error'] = $error;
		if(count($error) != 0){
			echo json_encode($return);
			exit;
		}		
		$_POST['created_by'] 			= $_POST['username'];
		$_POST['date_created'] 			= date('Y-m-d H:i:s');
		$_POST['lastupdate'] 			= date('Y-m-d H:i:s');
		$_POST['control_no_count']		= get_last_ctrl_no_count();
		$_POST['ok_condition_files'] 	= $_FILES['ok_condition_files']['name'];
		$_POST['ng_condition_files'] 	= $_FILES['ng_condition_files']['name'];
		$_POST['reference_file_name'] 	= $_FILES['reference_files']['name'];
		/* Save if threre are no error encountered */
		$array_fields_values = get_fields_values($_POST, array("action"));
		require_once('../class/oop_tqts.php');
		$table 			= "tbl_iqc_qar";
		foreach($array_fields_values['array_fields'] as $key => $value){
			$array_fields_values['array_fields'][$key] = '`'.$value.'`';
		}
		$array_fields	= $array_fields_values['array_fields'];
		$array_values	= $array_fields_values['array_values'];
		$pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 		= TQTS::getInstance()->insert_query_id_script($table,$array_fields,$array_values);
		$return['pkid'] 				= $pkid;
		$return['script'] 				= $script;
		$return['array_fields_values'] 	= $array_fields_values;
		/* Save uploaded files */
		if($_FILES['ok_condition_files']['name'] != ""){
			$file_path_ok 				= return_file_path_by_div_mod('iqc_qar_ok');
			if(!file_exists($file_path_ok['path'].$pkid)){
				mkdir($file_path_ok['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ok['path'].$pkid);
			}
			move_uploaded_file($_FILES['ok_condition_files']['tmp_name'],$file_path_ok['path'].$pkid.'/'.$_FILES['ok_condition_files']['name']);
		}
		if($_FILES['ng_condition_files']['name'] != ""){
			$file_path_ng 				= return_file_path_by_div_mod('iqc_qar_ng');
			if(!file_exists($file_path_ng['path'].$pkid)){
				mkdir($file_path_ng['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ng['path'].$pkid);
			}
			move_uploaded_file($_FILES['ng_condition_files']['tmp_name'],$file_path_ng['path'].$pkid.'/'.$_FILES['ng_condition_files']['name']);
		}
		if($_FILES['reference_files']['name'] != ""){
			$file_path_reference 				= return_file_path_by_div_mod('iqc_qar_reference');
			if(!file_exists($file_path_reference['path'].$pkid)){
				mkdir($file_path_reference['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_reference['path'].$pkid);
			}
			move_uploaded_file($_FILES['reference_files']['tmp_name'],$file_path_reference['path'].$pkid.'/'.$_FILES['reference_files']['name']);
		}
		/* Send mail to mailer */
		$mail_data  = array();
		$to		   	= explode("|", $_POST['qc_supervisor']);
		$to_email 	= array();
		foreach($to as $key => $username){
			$to_email[] = return_user_email_add($username);
		}
		$cc		   	= explode("|", $_POST['cc']);
		$cc_email 	= array();
		foreach($cc as $key => $username){
			$cc_email[] = return_user_email_add($username);
		}
		$to_email    = implode(",",$to_email);
		$cc_email    = implode(",",$cc_email);
		$bcc		 = 'rdfernandez@pricon.ph';
		$from		 = 'issinforservice@pricon.ph';
		$from_name	 = 'TQTS Mailer';
		$date_month  = date('ym',strtotime($_POST['date_issued']));
		$division 	= return_system_division();
		$subject	 = "QAR-".$division."-".$_POST['section']."-".$date_month."-".$_POST['control_no_count']."_".$_POST['part_name']."_".$_POST['mode_of_defect'];
		// $subject 	 = 'Quality Alert Report - Awaiting Conformance';
		$message 	 = 'Good Day! <br><br>';
		$message 	.= 'This is to inform that you have a Quality Alert awaiting for Conformance. <br>';
		$message 	.= 'Quality Alert Information: <br>';
		$message 	.= 'Date Issued: '.$_POST['date_issued'].'<br>';
		$message 	.= 'Partcode: '.$_POST['part_code'].'<br>';
		$message 	.= 'Partname: '.$_POST['part_name'].'<br>';
		$message 	.= 'Model: '.$_POST['model'].'<br>';
		$message 	.= 'Mode of Defect: '.$_POST['mode_of_defect'].'<br>';
		$message 	.= 'Please login to Rapid with this link http://rapid <br><br>';
		$message 	.= 'This is a system message generated by the system, Please do not reply!';
		$send_date_time = date('Y-m-d H:i:s');
		require_once('../class/send_email.php');
		$email = new email;
		$mailer_result = $email->send_email_detailed($to_email, $from, $from_name, $cc_email, $bcc, $subject, $message, $send_date_time, $_POST['username']);
		$return['mail_data'] 		= $mailer_result;
		echo json_encode($return);
	}
	
	function edit_qar(){
		/* tweek some values */
		$error = array();
		$return = $_POST;
		
		if(isset($_POST['to'])){ 	
			$_POST['to']	= $_POST['to']; 	
		}else{
			$_POST['to']	= "";
		}
		if(isset($_POST['attn'])){ 	
			$_POST['attn']	= implode("|",$_POST['attn']); 	
		}else{
			$_POST['attn']	= "";
		}
		if(isset($_POST['cc'])){ 	
			$_POST['cc']	= implode("|",$_POST['cc']); 	
		}else{
			$_POST['cc']	= "";
		}
		if(isset($_POST['qc_supervisor'])){ 	
			$_POST['qc_supervisor']	= implode("|",$_POST['qc_supervisor']); 	
		}else{
			$_POST['qc_supervisor']	= "";
		}
		$return 				= $_POST;		
		$return['ng_file'] 		= $_FILES['ng_condition_files'];		
		$return['ok_file'] 		= $_FILES['ok_condition_files'];	
		
		/* check image size */
		$ok_filesize 			= convert_file_size_to_mb($_FILES['ok_condition_files']['size']);
		$ng_filesize 			= convert_file_size_to_mb($_FILES['ng_condition_files']['size']);
		if($ok_filesize > 2){
			$error[] = "Ok image cannot exceed 2mb!";
		}
		if($ng_filesize > 2){
			$error[] = "NG Image cannot exceed 2mb!";
		}
		/* Check if uploaded file is an image */
		$image_mime_type = array("image/png","image/jpeg","image/bmp");
		if(!in_array($_FILES['ok_condition_files']['type'],$image_mime_type) && $_FILES['ok_condition_files']['name'] != ""){
			$error[] = "Uploaded File for OK condition is not an image!";
		}
		if(!in_array($_FILES['ng_condition_files']['type'],$image_mime_type) && $_FILES['ng_condition_files']['name'] != ""){
			$error[] = "Uploaded File for NG condition is not an image!";
		}
		if($_POST['section'] == ""){
			$error[] = "Your account has not been assigned with a section, Please contact the system administrator.";
		}
		if($_POST['to'] == ""){
			$error[] = "Please enter a value for [to:]";
		}
		if($_POST['cc'] == ""){
			$error[] = "Please enter a value for [cc:]";
		}
		if($_POST['attn'] == ""){
			$error[] = "Please enter a value for [attn:]";
		}
		
		if($_POST['lot_name'] == ""){
			$error[] = "Please enter a lot number";
		}
		if($_POST['mode_of_defect'] == ""){
			$error[] = "Please enter a mode of defect";
		}
		$return['error'] = $error;
		if(count($error) != 0){
			echo json_encode($return);
			exit;
		}
		
		$_POST['reference_file_name'] 	= $_FILES['reference_files']['name'];
		$_POST['created_by'] 			= $_POST['username'];
		$_POST['date_created'] 			= date('Y-m-d H:i:s');
		$_POST['lastupdate'] 			= date('Y-m-d H:i:s');
		
		if($_FILES['ok_condition_files']['name'] != ""){
			$_POST['ok_condition_files'] 	= $_FILES['ok_condition_files']['name'];
		}
		if($_FILES['ng_condition_files']['name'] != ""){
			$_POST['ng_condition_files'] 	= $_FILES['ng_condition_files']['name'];
		}		
		
		require_once('../class/oop_tqts.php');
		$array_fields_values = get_fields_values($_POST, array("action","id","section"));
		$table			= 'tbl_iqc_qar';
		$array_fields 	= $array_fields_values['array_fields'];
		$array_values 	= $array_fields_values['array_values'];
		$where 			= "WHERE `pkid` = '".$_POST['id']."' ";
		
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
		$return['script']	= $script;
		
		/* Save uploaded files */
		$pkid = $_POST['id'];
		if($_FILES['ok_condition_files']['name'] != ""){
			$file_path_ok 				= return_file_path_by_div_mod('iqc_qar_ok');
			if(!file_exists($file_path_ok['path'].$pkid."/")){
				mkdir($file_path_ok['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ok['path'].$pkid."/");
			}
			move_uploaded_file($_FILES['ok_condition_files']['tmp_name'],$file_path_ok['path'].$pkid.'/'.$_FILES['ok_condition_files']['name']);
		}
		if($_FILES['ng_condition_files']['name'] != ""){
			$file_path_ng 				= return_file_path_by_div_mod('iqc_qar_ng');
			if(!file_exists($file_path_ng['path'].$pkid."/")){
				mkdir($file_path_ng['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ng['path']."/".$pkid);
			}
			move_uploaded_file($_FILES['ng_condition_files']['tmp_name'],$file_path_ng['path'].$pkid.'/'.$_FILES['ng_condition_files']['name']);
		}
		if($_FILES['reference_files']['name'] != ""){
			$file_path_reference 				= return_file_path_by_div_mod('iqc_qar_reference');
			if(!file_exists($file_path_reference['path'].$pkid."/")){
				mkdir($file_path_reference['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_reference['path']."/".$pkid);
			}
			move_uploaded_file($_FILES['reference_files']['tmp_name'],$file_path_reference['path'].$pkid.'/'.$_FILES['reference_files']['name']);
		}
		/* Send mail to mailer */
		$mail_data  = array();
		$to		   	= explode("|", $_POST['qc_supervisor']);
		$to_email 	= array();
		foreach($to as $key => $username){
			$to_email[] = return_user_email_add($username);
		}
		$cc		   	= explode("|", $_POST['cc']);
		$cc_email 	= array();
		foreach($cc as $key => $username){
			$cc_email[] = return_user_email_add($username);
		}
		$to_email    = implode(",",$to_email);
		$cc_email    = implode(",",$cc_email);
		$bcc		 = 'rdfernandez@pricon.ph';
		$from		 = 'issinforservice@pricon.ph';
		$from_name	 = 'TQTS Mailer';
		$subject 	 = 'Quality Alert Report - Awaiting Conformance';
		$message 	 = 'Good Day! <br><br>';
		$message 	.= 'This is to inform that you have a Quality Alert awaiting for Conformance. <br>';
		$message 	.= 'Quality Alert Information: <br>';
		$message 	.= 'Date Issued: '.$_POST['date_issued'].'<br>';
		$message 	.= 'Partcode: '.$_POST['part_code'].'<br>';
		$message 	.= 'Partname: '.$_POST['part_name'].'<br>';
		$message 	.= 'Model: '.$_POST['model'].'<br>';
		$message 	.= 'Mode of Defect: '.$_POST['mode_of_defect'].'<br>';
		$message 	.= 'Please login to Rapid with this link http://rapid <br><br>';
		$message 	.= 'This is a system message generated by the system, Please do not reply!';
		$send_date_time = date('Y-m-d H:i:s');
		require_once('../class/send_email.php');
		$email = new email;
		// $mailer_result = $email->send_email_detailed($to_email, $from, $from_name, $cc_email, $bcc, $subject, $message, $send_date_time, $_POST['username']);
		// $return['mail_data'] 		= $mailer_result;
		echo json_encode($return);
	}
	
	function get_last_ctrl_qar(){
		$return = $_POST;
		$division 	= return_system_division();
		$control_no = "QAR-".$division."-".$_POST['section']."-".date('my');
		$last_ctrl_no_count = str_pad(get_last_ctrl_no_count(),3,0,STR_PAD_LEFT);
		$control_no = $control_no."-".$last_ctrl_no_count;
		$return['control_no'] = $control_no;
		echo json_encode($return);
	}
	
	function get_last_ctrl_no_count(){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("control_no_count as last_ctrl","date_created");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= 'WHERE logdel=0';
		$sql_order		= 'ORDER BY pkid DESC';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$current_month = date('m');
		if((int)$current_month >= 4 && (int)$current_month <= 12) {
			$sql_where		= 'WHERE (date_created BETWEEN "'.date('Y', strtotime($row['date_created'].'-1')).'-04-01" AND "'.date('Y').'-12-31") AND logdel=0';
			$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($result->num_rows == 0) {
				$last_ctrl		= 1;
			} else {				
				$last_ctrl		= $row['last_ctrl'] + 1;
			}
		} else {
			$last_ctrl		= $row['last_ctrl'] + 1;
		}
		$last_ctrl		= str_pad($last_ctrl,3,0,STR_PAD_LEFT);
		return $last_ctrl;
	}
	
	function get_qar_data_row($pkid){
		require_once('../class/oop_tqts.php');
		$control_no 		= '';
		$array_fields 		= array("*");
		$table				= "tbl_iqc_qar";
		$joins				= '';
		$sql_where			= 'WHERE `pkid`="'.$pkid.'"';
		$sql_order			= '';
		$sql_limit			= 'LIMIT 0,1';
		$result 			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row				= mysqli_fetch_assoc($result);
		// $control_no_count	= $row['control_no_count'];
		// $control_no_count	= str_pad($last_ctrl,3,0,STR_PAD_LEFT);
		return $row;
	}
	
	function convert_file_size_to_mb($file_size){
		$file_size = (($file_size / 1024) / 1024);
		return $file_size;
	}
	
	function conform_and_send_qar(){
		require_once('../class/oop_tqts.php');
		$division 	= return_system_division();
		$return 		=  $_POST;
		$return['error']= array();
		if( $_POST['disposition_required_date_reply'] == "" ){
			$return['error'][] = 'Please enter a required date reply!';
		}
		if(count($return['error']) != 0){
			echo json_encode($return);
			exit;
		}
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','date_conformed','conformed_by',
								'disposition_required_date_reply','username','lastupdate');
		$array_values 	= array('1',date('Y-m-d H:i:s'),$_POST['username'],
								$_POST['disposition_required_date_reply'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		
		$get_qar_data_row = get_qar_data_row($_POST['id']);
		
		/* Send mail to mailer */
		$to		   	= explode("|", $_POST['attn']);
		$to_email 	= array();
		foreach($to as $key => $username){
			$to_email[] = return_user_email_add($username);
		}
		$to_email = implode(",",$to_email);
		$cc		   = explode('|',$_POST['cc']);
		$cc_email 	= array();
		foreach($cc as $key => $username){
			$cc_email[] = return_user_email_add($username);
		}
		$qc_supervisor   = explode('|',$get_qar_data_row['qc_supervisor']);
		foreach($qc_supervisor as $key => $username){
			$cc_email[] = return_user_email_add($username);
		}
		$cc_email[] = return_user_email_add($get_qar_data_row['created_by']);
		$cc_email    = implode(",",$cc_email);
		$bcc		 = 'rdfernandez@pricon.ph';
		$from		 = 'issinforservice@pricon.ph';
		$from_name	 = 'TQTS Mailer';
		
		$date_month  = date('ym',strtotime($get_qar_data_row['date_issued']));
		// $subject	 = "QAR-".$division."-".$get_qar_data_row['section']."-".$date_month."-".$get_qar_data_row['control_no_count']."_".$get_qar_data_row['part_name']."_".$get_qar_data_row['mode_of_defect'];
		$subject	 = "FOLLOW-UP CAPA (Due Date: ".(date("M d, Y", strtotime($get_qar_data_row['disposition_required_date_reply']))).") Defect mode:".$_POST['mode_of_defect'];
		// $subject 	 = 'Quality Alert Report - Awaiting Disposition';
		$message 	 = 'Good Day! <br><br>';
		$message 	.= 'This is to inform that you have a Quality Alert awaiting for CAPA. <br>';
		$message 	.= 'Quality Alert Information: <br>';
		$message 	.= 'Date Issued: '.$_POST['date_issued'].'<br>';
		$message 	.= 'Partcode: '.$_POST['part_code'].'<br>';
		$message 	.= 'Partname: '.$_POST['part_name'].'<br>';
		$message 	.= 'Model: '.$_POST['model'].'<br>';
		$message 	.= 'Mode of Defect: '.$_POST['mode_of_defect'].'<br>';
		$message 	.= 'Please login to Rapid with this link http://rapid <br><br>';
		$message 	.= 'This is a system message generated by the system, Please do not reply!';
		$send_date_time = date('Y-m-d H:i:s');
		// $date_start  = $_POST['disposition_required_date_reply'];
		$date_start  = date('Y-m-d');
		require_once('../class/send_email.php');
		$email = new email;
		$mailer_result = $email->send_email_detailed($to_email, $from, $from_name, $cc_email, $bcc, $subject, $message, $send_date_time, $_POST['username']);
		/* CC supervisor and requestor only */
		$cc_email 	 = '';
		foreach($qc_supervisor as $key => $username){
			$cc_email[] = return_user_email_add($username);
		}
		$cc_email[] = return_user_email_add($get_qar_data_row['created_by']);
		$cc_email    = implode(",",$cc_email);
		
		$date_today = date('Y-m-d');
		$date_tomorrow = date('Y-m-d', strtotime($date_today.' + 1 day'));
		$mailer_result = $email->send_scheduled_email($table, $_POST['id'], $to_email, $from, $cc_email, $subject, $message, $date_tomorrow, '2'); //daily alert
		$return['mail_data'] 		= $mailer_result;
		echo json_encode($return); 
	}
	
	function reject_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','date_conformed','conformed_by','username','lastupdate');
		$array_values 	= array('2',date('Y-m-d H:i:s'),$_POST['username'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function close_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','date_conformed','conformed_by','username','lastupdate');
		$array_values 	= array('4',date('Y-m-d H:i:s'),$_POST['username'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function cancel_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','remarks','username','lastupdate');
		$array_values 	= array('9',$_POST['remarks'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function invalid_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$history		= get_qar_history($_POST['id']);
		$history 		= $history."<br>";
		$history 	   .= "User (".$_POST['username']."): Invalid QAR Remarks<br>";
		$history 	   .= $_POST['remarks'];
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','remarks','username','lastupdate');
		$array_values 	= array('9',$history,$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		/* Close alert */
		$mailer_result  = close_auto_mailer($table,$_POST['id']);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function add_disposition_qar_recipient(){
		require_once('../class/oop_tqts.php');
		$return 					= $_POST;
		$return['file']				= $_FILES['file_excel_with_disposition'];
		$mime_content_type			= array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$disposition_rev 			= get_qar_disposition_last_rev($_POST['id']);
		$return['disposition_rev']	= $disposition_rev;
		$disposition_history		= get_qar_disposition_history($_POST['id']);
		$disposition_history		= $disposition_history."rev=".$disposition_rev.';disposition_by='.$_POST['username'].';disposition_date='.date('Y-m-d H:i:s');
		$return['error']	= array();
		if(!in_array($return['file']['type'],$mime_content_type)){
			$return['error'][]= "File uploaded is not an excel file";
		}
		if( count($return['error']) != 0 ){
			echo json_encode($return);
			exit;
		}
		$table			= 'tbl_iqc_qar';
		$array_fields	= array('status','disposition_file_name','disposition_rev',
								'disposition_by','disposition_date','disposition_history',
								'lastupdate','username');
		$array_values 	= array('3',$return['file']['name'],$disposition_rev,
								$_POST['username'],date('Y-m-d H:i:s'),$disposition_history,
								$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		/* Move uploaded file */
		$file_path = return_file_path_by_div_mod('iqc_qar_disposition');
		$file_path_disposition = $file_path['path'].$_POST['id'].'/';
		if(!file_exists($file_path_disposition)){
			mkdir($file_path_disposition,0777);
		}
		$file_path_disposition = $file_path_disposition.$disposition_rev.'/';
		if(!file_exists($file_path_disposition)){
			mkdir($file_path_disposition,0777);
		}
		move_uploaded_file($return['file']['tmp_name'], $file_path_disposition.$return['file']['name']);
		
		/* Send mail to mailer */
		$get_qar_data_row = get_qar_data_row($_POST['id']);
		$mail_data  = array();
		$to		   	= explode("|", $get_qar_data_row['qc_supervisor']);
		$to_email 	= array();
		foreach($to as $key => $username){
			$to_email[] = return_user_email_add($username);
		}
		$to_email[] = return_user_email_add($get_qar_data_row['created_by']);
		$to_email    = implode(",",$to_email);
		$cc_email    = return_user_email_add($_POST['username']);
		$bcc		 = 'rdfernandez@pricon.ph';
		$from		 = 'issinforservice@pricon.ph';
		$from_name	 = 'TQTS Mailer';
		$date_month  = date('ym',strtotime($_POST['date_issued']));
		$division 	= return_system_division();
		$subject	 = "QAR-".$division."-".$get_qar_data_row['section']."-".$date_month."-".$get_qar_data_row['control_no_count']."_".$get_qar_data_row['part_name']."_".$get_qar_data_row['mode_of_defect'];
		$message 	 = 'Good Day! <br><br>';
		$message 	.= 'This is to inform that CAPA has been submitted. <br>';
		$message 	.= 'Quality Alert Information: <br>';
		$message 	.= 'Date Issued: '.$get_qar_data_row['date_issued'].'<br>';
		$message 	.= 'Partcode: '.$get_qar_data_row['part_code'].'<br>';
		$message 	.= 'Partname: '.$get_qar_data_row['part_name'].'<br>';
		$message 	.= 'Model: '.$get_qar_data_row['model'].'<br>';
		$message 	.= 'Mode of Defect: '.$get_qar_data_row['mode_of_defect'].'<br>';
		$message 	.= 'Please login to Rapid with this link http://rapid <br><br>';
		$message 	.= 'This is a system message generated by the system, Please do not reply!';
		$send_date_time = date('Y-m-d H:i:s');
		require_once('../class/send_email.php');
		$email = new email;
		$mailer_result = $email->send_email_detailed($to_email, $from, $from_name, $cc_email, $bcc, $subject, $message, $send_date_time, $_POST['username']);
		$return['mail_data'] 		= $mailer_result;		
		/* Close alert */
		$mailer_result  = close_auto_mailer($table,$_POST['id']);
		echo json_encode($return);
	}
	
	function return_prod_code_list(){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("dropdown_value","dropdown_text");
		$table			= "tbl_dropdown_maintenance_details";
		$joins			= '';
		$sql_where		= "WHERE fkdropdown_id ='3' AND logdel=0";
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select	= '<option value="">-</option>';
		while($row = mysqli_fetch_assoc($result)){
			$html_select .= '<option value="'.$row['dropdown_value'].'">'.$row['dropdown_text'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function get_qar_group_list(){
		require_once('../class/oop_tqts.php');
		$group_to 		= $_POST['group_to'];
		$array_fields 	= array("group_attn","group_cc","group_supervisor");
		$table			= "tbl_iqc_qar_group";
		$joins			= '';
		$sql_where		= "WHERE group_to ='".$group_to."' AND logdel=0";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_assoc($result)){
			$array_attn = explode(",",$row['group_attn']);
			$return['data_attn'] = array();
			foreach($array_attn as $key => $value){
				$array_data_attn = array();
				$array_data_attn['id'] 			= $value;
				$array_data_attn['text'] 		= get_emp_name_by_username_systemone($value);
				$return['data_attn'][] 			= $array_data_attn;
			}
			
			$array_cc = explode(",",$row['group_cc']);
			$return['data_cc'] = array();
			foreach($array_cc as $key => $value){
				$array_data_cc = array();
				$array_data_cc['id'] 		= $value;
				$array_data_cc['text'] 		= get_emp_name_by_username_systemone($value);
				$return['data_cc'][] 		= $array_data_cc;
			}
			
			$array_supervisor = explode(",",$row['group_supervisor']);
			$return['data_supervisor'] = array();
			foreach($array_supervisor as $key => $value){
				$array_data_supervisor = array();
				$array_data_supervisor['id'] 		= $value;
				$array_data_supervisor['text'] 		= get_emp_name_by_username_systemone($value);
				$return['data_supervisor'][] 		= $array_data_supervisor;
			}
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_qar_disposition_last_rev($pkid){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("disposition_rev");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= "WHERE pkid ='".$pkid."' ";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$disposition_rev = -1;
		if($row['disposition_rev'] == ""){
			$disposition_rev = -1;
		}else{
			$disposition_rev = $row['disposition_rev'];
		}
		$disposition_rev = $disposition_rev + 1;
		return $disposition_rev;
	}
	
	function get_qar_disposition_history($pkid){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("disposition_history");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= "WHERE pkid ='".$pkid."' ";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$disposition_history = "";
		if($row['disposition_history'] == ""){
			$disposition_history = "";
		}else{
			$disposition_history = $row['disposition_history'];
		}
		if($disposition_history != ""){
			$disposition_history = $disposition_history."|";
		}
		return $disposition_history;
	}
	
	function get_qar_history($pkid){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("qar_history");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= "WHERE pkid ='".$pkid."' ";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$qar_history = "";
		if($row['qar_history'] == ""){
			$qar_history = "";
		}else{
			$qar_history = $row['qar_history'];
		}
		if($qar_history != ""){
			$qar_history = $qar_history."|";
		}
		return $qar_history;
	}
	
	/* QAR End */
	
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
		$file  		     = return_file_path_by_div_mod('qfr_8d');
		$username    	 = $_POST['username'];
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];
		$return['error'] = array();
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_qfr_8d";
		$values 					= get_fields_values($_POST,array("action","username","file_8d","approver","approvers"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "status"; 			$array_values[] = "OPEN";
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] 			= $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);		
		
		/* Upload the file to target directory */
		for($i=0;$i<count($_FILES['file_8d']['name']);$i++) {
			$temp_file 	     = $_FILES["file_8d"]["tmp_name"][$i];
			$file_name 	     = $_FILES["file_8d"]["name"][$i];
			$target_file 	 = $target_dir . $file_name;
			if (file_exists($target_file)) {
				$msg 					= "Sorry, your file already exists.";
				$return['error']		= $msg;
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					/* Rename the file based on pkid of Quality Report */					
					$table 			= 'tbl_qfr_8d_attachments';
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
				
				if($i==0) { //para once lang sya mag insert :)
					
				}
				$return['array_fields']		= $array_fields;
				$return['array_fields']		= $array_values;
				$return['files']			= $_FILES;
			}
		}
		
		/* Save selected approvers */
		$table			= 'tbl_qfr_8d_approvers';
		$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'approver_username', 'status', 'lastupdate', 'username');
		foreach($approvers as $approver_username) {
			$array_values 	= array($date_time_today, $username, $pkid, $approver_username, 'PENDING', $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			$script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
		
		//send email notification to all approvers
		send_email_for_approval($pkid, 'new');
		
		$return['script']			= $script;
		echo json_encode($return);
	}
	
	function send_email_for_approval($pkid, $action) {
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
				$subject 	 = 'FOR APPROVAL 8D REPORT: PO # '.$po_number.'';
			} else {
				$subject 	 = 'FOR APPROVAL REVISED 8D REPORT: PO # '.$po_number.'';
			}
			$body 	 	 = 'Please be informed that you have 8D Report for approval.<br> <br>';
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
		$array_fields = array('pkid', 'file_name');
		$table 	   	= 'tbl_qfr_8d_attachments';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk8d='.$_POST['fk8d'].' AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$table_body = '';
		
		/* Check employees user rols */
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
			$disable    = '';
		}
		
		while($row = mysqli_fetch_array($result)){
			$table_body .= '<tr>';
			$table_body .= '	<td><button type="button" class="btn btn-link fa fa-paperclip" id="btn_dl_attachment" value="'.$_POST['fk8d'].'_'.$row['pkid'].'"> '.$row['file_name'].' '.$row['pkid'].'</button></td>';
			$table_body .= '	<td><center><button class="btn btn-danger fa fa-trash" '. $disable .' value="'.$row['pkid'].'"> </button></center></td>';
			$table_body .= '</tr>';
		}
		$return['table_body'] = $table_body;
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
		$table 			= 'tbl_qfr_8d_attachments';
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
		$table 	   	= 'tbl_qfr_8d_attachments details ';
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
		$file  		     = return_file_path_by_div_mod('qfr_8d');
		$username    	 = $_POST['username'];
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];
		$return['error'] = array();
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 			= "tbl_qfr_8d";
		$values 		= get_fields_values($_POST,array("action","username","file_8d","approver","approvers"));
		$array_fields 	= $values["array_fields"];
		$array_values 	= $values["array_values"];
		$pkid  			= $return['pkid'];
		$result 		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		
		if(isset($_FILES["file_8d"]["tmp_name"])) {
			/* Upload the file to target directory */
			for($i=0;$i<count($_FILES['file_8d']['name']);$i++) {
				$temp_file 	     = $_FILES["file_8d"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_8d"]["name"][$i];
				$target_file 	 = $target_dir . $file_name;
				if (file_exists($target_file)) {
					$msg 					= "Sorry, your file already exists.";
					$return['error']		= $msg;
				} else {
					if (move_uploaded_file($temp_file, $target_file)) {
						/* Rename the file based on pkid of Quality Report */					
						$table 			= 'tbl_qfr_8d_attachments';
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
			}
		}
		
		/* Update approvers */
		$table			= 'tbl_qfr_8d_approvers';
		$sql_where		= 'WHERE fkng='.$pkid;
		$array_fields 	= array('lastupdate', 'username', 'logdel');
		$array_values 	= array($date_time_today, $_POST['username'], 1);
		$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		
		/* Save updated approvers */
		$table			= 'tbl_qfr_8d_approvers';
		$array_fields 	= array('date_time_created', 'created_by', 'fk8d', 'approver_username', 'status', 'lastupdate', 'username');
		foreach($approvers as $approver_username) {
			$array_values 	= array($date_time_today, $username, $pkid, $approver_username, 'PENDING', $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			$script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
		
		//send email notification to all approvers
		send_email_for_approval($pkid, edit);
		
		$return['script']			= $script;
		echo json_encode($return);
		
		$table  					= 'tbl_qfr_qcfr';
		$values 					= get_fields_values($_POST,array("action","pkid","username","excel_file"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$pkid  						= $return['pkid'];
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
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
		$array_fields	= array('pkid','status', 'po_number', 'customer_name', 'defect_phenomenon', 'due_date', 'remarks');
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
		$date_time_approved	= array();
		$approver_status	= array();
		$array_fields = array('approver_username','date_time_approved', 'status');
		$table 	   	= ' tbl_qfr_8d_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fk8d`="'.$_POST['pkid'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$approver_username[] 			= $row['approver_username'];
			$date_time_approved[]		 	= $row['date_time_approved'];
			$approver_status[] 				= $row['status'];
		}
		$return['approver_username'] 	= implode(',',$approver_username);
		$return['date_time_approved']	= implode(',',$date_time_approved);
		$return['approver_status'] 		= implode(',',$approver_status);
		$return['script'] 				= $script;
		
		echo json_encode($return);
	}
	
	/* 8D End */

	

	/* QCFR Start */
	function upload_qcfr(){
		/* library for reading excel files */
		/* Read your Excel workbook */
		$inputFileName = $_FILES['file_qcfr']['tmp_name'];
		$original_file_name = $_FILES['file_qcfr']['name'];
		$excel_data 								= get_excel_content($inputFileName,100);
		/* get excel values */
		$return['excel_data']['qcfr_no'] 			= $excel_data['E6'];
		$return['excel_data']['product_name'] 		= $excel_data['B19'];
		$return['excel_data']['model_no'] 			= $excel_data['B20'];
		$return['excel_data']['batch_no_lot_no'] 	= $excel_data['B21'];
		$return['excel_data']['po_no_inv_no']		= $excel_data['B22'];
		$return['excel_data']['date_received'] 		= $excel_data['B23'];
		/* Get uploaded file filename */
		$return['original_file_name'] = $original_file_name;
		/* Check if uploaded file exist on /tmp/ folder */
		if(file_exists($inputFileName)){
			/* move the file to the temp directory */
			move_uploaded_file($inputFileName,'../uploaded_file/temp/qcfr/'.$original_file_name);
		}
		echo json_encode($return);
	}

	function save_qcfr(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		if($_POST['action'] == "save_qcfr"){
			/* check if qcfr data is already a duplicate copy */
			$return['error'] = array();
			$filename 		= str_replace('C:\fakepath\\',"",$_POST['excel_file']);
			if(!file_exists('../uploaded_file/temp/qcfr/'.$filename)){
				$return['error'][] = 'Please re-upload the file!';
			}
			$qcfr_no		= $_POST['qcfr_no'];
			$array_fields 	= array('qcfr_no');
			$table  		= "tbl_qfr_qcfr";
			$joins  	 	= "";
			$sql_where  	= "WHERE `qcfr_no` = '$qcfr_no'";
			$sql_order  	= "";
			$sql_limit  	= "";
			$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($result->num_rows != 0){
				$return['error'][] = 'QCFR No '.$qcfr_no." already exist!";
			}
			if(count($return['error']) == 0){
				/* save qcfr information */
				$table 						= "tbl_qfr_qcfr";
				$values 					= get_fields_values($_POST,array("action","username","excel_file"));
				$array_fields 				= $values["array_fields"];
				$array_values 				= $values["array_values"];
				$array_fields[] 			= "filename"; $array_values[] = $filename;
				$array_fields[] 			= "created_by"; $array_values[] = $_POST["username"];
				$array_fields[] 			= "date_created"; $array_values[] = date("Y-m-d H:i:s");
				$array_fields[] 			= "lastupdate"; $array_values[] = date("Y-m-d H:i:s");
				$array_fields[] 			= "username"; $array_values[] = $_POST["username"];
				$pk_file_uploaded 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
				$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
				$return['script'] 		= $script;
				/* save uploaded file details */
				if(file_exists('../uploaded_file/temp/qcfr/'.$filename)){
				$file_path 	= return_file_path_by_div_mod('qcfr');
					$ext 		= pathinfo('../uploaded_file/temp/qcfr/'.$filename, PATHINFO_EXTENSION);
					rename('../uploaded_file/temp/qcfr/'.$filename, $file_path['path'].$pk_file_uploaded.'.'.$ext);
					$return['file_moved'] = $file_path['path'].$pk_file_uploaded.'.'.$ext;
				}else{
					$return['file_moved'] = false;
				}
			}
		}
		$return['filename'] = $filename;
		echo json_encode($return);
	}
	
	function load_qcfr_data_details(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$array_fields	= array('*');
		$table			= 'tbl_qfr_qcfr';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$return['pkid'].'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
		}
		echo json_encode($return);
	}
	
	function re_upload_qcfr(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		/* Get excel values */
		$inputFileName 		= $_FILES['file_qcfr']['tmp_name'];
		$original_file_name = $_FILES['file_qcfr']['name'];
		$excel_data 								= get_excel_content($inputFileName,100);
		/* get excel values */
		$return['excel_data']['qcfr_no'] 			= $excel_data['E6'];
		$return['excel_data']['product_name'] 		= $excel_data['B19'];
		$return['excel_data']['model_no'] 			= $excel_data['B20'];
		$return['excel_data']['batch_no_lot_no'] 	= $excel_data['B21'];
		$return['excel_data']['po_no_inv_no']		= $excel_data['B22'];
		$return['excel_data']['date_received'] 		= $excel_data['B23'];		
		/* Get uploaded file filename */
		$return['original_file_name'] = $original_file_name;
		/* Check if uploaded file exist on /tmp/ folder */
		if(file_exists($inputFileName)){
			/* move the file to the temp directory */
			move_uploaded_file($inputFileName,'../uploaded_file/temp/qcfr/'.$original_file_name);
		}
		echo json_encode($return);
	}
	
	function edit_qcfr(){
		require_once('../class/oop_tqts.php');
		$return 					= $_POST;
		$return['error'] 			= array();
		$filename 					= str_replace('C:\fakepath\\',"",$_POST['excel_file']);
		/* Validate if the Control Number Exist on other data */
		$existing_qcfr_no = qcfr_ctrl_no_exist($return["pkid"],$return["qcfr_no"]); //for change QCFR number base on excel data
		$return['existing_qcfr_no'] = $existing_qcfr_no;
		if($return['existing_qcfr_no']){
			$return['error'][] = 'The control number for the excel file you want to replace is already existing on other record.';
		}
		if(count($return['error']) == 0){
			/* Update the current data */
			$table  					= 'tbl_qfr_qcfr';
			$values 					= get_fields_values($_POST,array("action","pkid","username","excel_file"));
			$array_fields 				= $values["array_fields"];
			$array_values 				= $values["array_values"];
			$pkid  						= $return['pkid'];
			$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
			$return['result'] = $result;
			/* overwrite uploaded file */
			if(file_exists('../uploaded_file/temp/qcfr/'.$filename)){
				$file_path 	= return_file_path_by_div_mod('qcfr');
				$ext 		= pathinfo('../uploaded_file/temp/qcfr/'.$filename, PATHINFO_EXTENSION);
				rename('../uploaded_file/temp/qcfr/'.$filename, $file_path['path'].$return['pkid'].'.'.$ext);
				$return['file_moved'] = $file_path['path'].$return['pkid'].'.'.$ext;
			}else{
				$return['file_moved']   = false;
				$return['error'] 		= "Something went wrong during file upload, please re-upload the file.";
			}
		}
		echo json_encode($return);
	}
	
	function qcfr_ctrl_no_exist($pkid,$qcfr_no){
		require_once('../class/oop_tqts.php');
		$array_fields	= array('qcfr_no');
		$table			= 'tbl_qfr_qcfr';
		$joins			= '';
		$sql_where		= 'WHERE `qcfr_no` = "'.$qcfr_no.'" AND `pkid` != "'.$pkid.'" AND `logdel` = "0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$exist 			= false;
		while($row = mysqli_fetch_assoc($result)){
			$exist = true;
		}		
		return $exist;
	}
	
	function cancel_qcfr(){
		require_once('../class/oop_tqts.php');
		$return 					= $_POST;
		/* Update the current data */
		$table  					= 'tbl_qfr_qcfr';
		$array_fields 				= array('logdel');
		$array_values 				= array('1');
		$pkid  						= $return['pkid'];
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return['result']			= $result;
		echo json_encode($return);
	}
	/* QCFR End */
?>