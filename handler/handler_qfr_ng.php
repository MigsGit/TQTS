<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {			
				case "ng_reload_wbs_record" 					: ng_reload_wbs_record(); break; 
				case "get_material_type_list" 					: get_material_type_list(); break; 
				case "save_ng_report" 							: save_ng_report(); break; 
				case "load_ng_details_by_pkid" 					: load_ng_details_by_pkid(); break; 
				case "update_ng_report" 						: update_ng_report(); break; 
				case "get_ng_lot_numbers_by_fkng" 				: get_ng_lot_numbers_by_fkng(); break; 
				case "get_approvers_log" 						: get_approvers_log(); break; 
				case "ng_approver_decision" 					: ng_approver_decision(); break;
				case "ng_send_for_disposition" 					: ng_send_for_disposition(); break;
				case "load_ng_treatment_details_by_fkng" 		: load_ng_treatment_details_by_fkng(); break;
				case "get_disposition_list" 					: get_disposition_list(); break;
				case "add_treatment" 							: add_treatment(); break;
				case "validate_is_approver" 					: validate_is_approver(); break;
				case "cancel_ng" 								: cancel_ng(); break;
				case "get_email_recipients_by_category" 		: get_email_recipients_by_category(); break; 
				case "get_supplier_by_pkid" 					: get_supplier_by_pkid(); break; 
				case "view_ng_attachments" 						: view_ng_attachments(); break; 

				case "get_supplier_ng_email_address" 			: get_supplier_ng_email_address(); break; 
			}
		}
	}
	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function ng_reload_wbs_record() {
		require_once('../class/oop_tqts.php');
		$username	= $_POST['username'];
		$array_fields = array('invoice_no', 'app_date', 'date_ispected', 'type_of_inspection', 'time_ins_from', 'fy', 'ww', 'submission', 'partcode', 'partname', 'supplier', 'lot_no', 'lot_qty', 'aql', 'judgement', 'id');
		$table 	   	= 'iqc_inspections';
		$joins 	   	= '';
		$sql_where 	= 'WHERE judgement="Rejected"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$tbody	 	= '';
		$result = SEIKODB::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			//Check if already exists on TQTS record
			$is_exists = check_tqts_pending_ng_record($row['invoice_no'], $row['date_ispected'], $row['partcode'], $row['lot_no']);
			if($is_exists == 0) {
				$tbody .= insert_wbs_pending_ng($row['id'], $row['date_ispected'], $row['time_ins_from'], $row['submission'],$row['invoice_no'], $row['partcode'], $row['partname'], $row['lot_no'], $row['lot_qty'], $row['supplier'], 'PENDING', $username);
			} else {
				$tbody .= '<tr>';
				$tbody .= '	<td>'.$row['invoice_no'].'</td>';
				$tbody .= '	<td>'.$row['partcode'].'</td>';
				$tbody .= '	<td>'.$row['lot_no'].'</td>';
				$tbody .= '	<td>'.$row['lot_qty'].'</td>';
				$tbody .= '	<td style="color:red">Already Exists!</td>';
				$tbody .= '</tr>';
			}
		}	
		$table  = '<table class="table table-bordered table-condensed" id="tbl_ng_for_filling">';
		$table .= '	<thead>';
		$table .= '		<th>Status</th>';
		$table .= '		<th>Invoice #</th>';
		$table .= '		<th>Part Code</th>';
		$table .= '		<th>Lot #</th>';
		$table .= '		<th>Lot Qty</th>';
		$table .= '	</thead>';
		$table .= $tbody;
		$table .= '</table>';
		$return['table'] = $table;		
		echo json_encode($return);
	}
	
	function check_tqts_pending_ng_record($invoice_no, $date_inspected, $partcode, $lot_no) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('status');
		$table 	   	= 'tbl_qfr_ng_wbs_rejected_visual_inspection';
		$joins 	   	= '';
		$sql_where 	= 'WHERE invoice_no="'.$invoice_no.'" AND inspection_date="'.$date_inspected.'" AND partcode="'.$partcode.'" AND lot_no="'.$lot_no.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			return 0;
		} else {
			return 1;
		}	
	}
	
	function insert_wbs_pending_ng($wbs_id, $inspection_date, $inspection_time, $sub,$invoice_no, $partcode, $partname, $lot_no, $qty, $supplier, $status, $username) {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$table 			= 'tbl_qfr_ng_wbs_rejected_visual_inspection';
		$array_fields 	= array('date_time_loaded', 'loaded_by', 'wbs_id', 'inspection_date', 'inspection_time', 'submission', 'invoice_no', 'partcode', 'partname', 'lot_no', 'quantity', 'supplier', 'status', 'lastupdate', 'username');
		$array_values 	= array($date_time_today, $username, $wbs_id, $inspection_date, $inspection_time, $sub,$invoice_no, $partcode, $partname, $lot_no, $qty, $supplier, $status, $date_time_today, $username);
		$insert_query 	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
		$tbody  = '<tr>';
		$tbody .= '	<td>'.$invoice_no.'</td>';
		$tbody .= '	<td>'.$partcode.'</td>';
		$tbody .= '	<td>'.$lot_no.'</td>';
		$tbody .= '	<td>'.$qty.'</td>';
		$tbody .= '	<td style="color:green">Successfully added!</td>';
		$tbody .= '</tr>';
		return $tbody;
	}
	
	function get_material_type_list() {
		require_once('../class/oop_tqts.php');
		$array_fields = array('material_type');
		$table 	   	= 'tbl_material_type';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select = '<option></option>';
		while($row = mysqli_fetch_array($result)){
			$html_select .= '<option value="'.$row['material_type'].'">'.$row['material_type'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function save_ng_report() { //email
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$wbs_id 		 = $_POST["wbs_id"];
		$username 		 = $_POST["username"];
		$approvers 		 = implode(',',$_POST["approvers"]);
		$file  		     = return_file_path_by_div_mod('ng_new');
		$file_names	     = implode(' | ',$_FILES["file_ng"]["name"]);
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];		
		$msg			 = '';
		$table 		  	= 'tbl_qfr_ng';
		$values		  	= get_fields_values($_POST,array("action","file_ng","device_name","report_approvers_new","lot_numbers","quantity","lot_pkid","username","fkfile_path","wbs_id","approvers","rbtn_new"));
		$array_fields 	= $values["array_fields"];
		$array_values 	= $values["array_values"];
		$control_number = generate_sa_control_number(date('Y-m-d'),$return['username']);
		$array_fields[]	= 'control_number'; $array_values[] = $control_number;
		$array_fields[] = "status"; 			$array_values[] = "FOR APPROVAL";
		$array_fields[] = "file_name"; 			$array_values[] = $file_names;
		$array_fields[] = "fkfile_path"; 		$array_values[] = $fkfile_path;
		$array_fields[] = "date_time_created"; 	$array_values[] = $date_time_today;
		$array_fields[] = "lastupdate"; 		$array_values[] = $date_time_today;
		$array_fields[] = "created_by"; 		$array_values[] = $username;
		$array_fields[] = "username"; 			$array_values[] = $username;
		$pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 		= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		
		/* Save selected approvers */
		$table			= 'tbl_qfr_ng_approvers';
		$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'approver_username', 'status', 'lastupdate', 'username');
		$approvers 		 = explode(',',$approvers);
		foreach($approvers as $approver_username) {
			$array_values 	= array($date_time_today, $username, $pkid, $approver_username, 'PENDING', $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			// $script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
		
		if(!file_exists($target_dir.$pkid.'/')) {
			$target_dir = $target_dir.$pkid.'/';
			mkdir($target_dir, 0777, false);
		} 
		/* Upload the file to target directory */	
		for($i=0; $i < count($_FILES["file_ng"]["tmp_name"]); $i++) {
			$temp_file 	     = $_FILES["file_ng"]["tmp_name"][$i];
			$file_name 	     = $_FILES["file_ng"]["name"][$i];
			
			$target_file 	 = $target_dir . $file_name;
			if (file_exists($target_file)) {
				$msg = "Sorry, your file already exists.";
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					/* Rename the file based on pkid of Quality Report */					
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = ($i+1).".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg = 'File was successfully uploaded to the system.<br>';
						/* Send email notification to the first approver */
						if($i == 0) {
							// ng_send_email_for_approval($pkid);
						}
					} else {
						$msg = 'There was an error on renaming the file.';
					}					
				} else {
					$msg = "Sorry, there was an error uploading your file.";
				}
			}
		}
		/* Save lot number datas */
		$lot_numbers	= explode(",",$_POST["lot_numbers"]);
		$quantity		= explode(",",$_POST["quantity"]);
		$table			= 'tbl_qfr_ng_lot_numbers';
		$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'lot_no', 'quantity', 'lastupdate', 'username');
		for($i=0; $i<count($lot_numbers);$i++) {
			$array_values 	= array($date_time_today, $username, $pkid, $lot_numbers[$i], $quantity[$i], $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			$script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
		/* Update tbl_qfr_ng_wbs_rejected_visual_inspection status to "WITH NG REPORT" */
		if($wbs_id != 0) {
			$table 			= 'tbl_qfr_ng_wbs_rejected_visual_inspection';
			$array_fields 	= array('status','lastupdate', 'username');
			$array_values 	= array('WITH NG REPORT',$date_time_today,$username);
			$update_query	= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$wbs_id);
			$script	.= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$wbs_id);
		}
		
		$return['msg'] 		= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function check_ng_report_no($ng_report_no) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('ng_report_no');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE ng_report_no="'.$ng_report_no.'" AND logdel="0" AND status != "CANCELLED"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		return $result->num_rows;
	}
	
	// function update_ng_report() {
	// 	require_once('../class/oop_tqts.php');
	// 	$date_time_today = date('Y-m-d H:i:s');
	// 	$approvers 		 = implode(',',$_POST["approvers"]);
	// 	$table  		= 'tbl_qfr_ng';
	// 	$values		  	= get_fields_values($_POST,array("action","file_ng","report_approvers_edit","lot_numbers","lot_pkid","username","fkfile_path","wbs_id","approvers", "rbtn_new","device_name","quantity"));
	// 	$array_fields 	= $values["array_fields"];
	// 	$array_values 	= $values["array_values"];
	// 	$array_fields[] = "lastupdate"; $array_values[] = $date_time_today;
	// 	$array_fields[] = "username"; $array_values[] = $_POST['username'];
	// 	$pkid  			= $_POST['pkid'];
	// 	$msg		    = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	// 	$script		    = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		
	// 	/* Update approvers */
	// 	$table			= 'tbl_qfr_ng_approvers';
	// 	$sql_where		= 'WHERE fkng='.$pkid;
	// 	$array_fields 	= array('lastupdate', 'username', 'logdel');
	// 	$array_values 	= array($date_time_today, $_POST['username'], 1);
	// 	$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		
	// 	$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'approver_username', 'status', 'lastupdate', 'username');
	// 	$approvers 		 = explode(',',$approvers);
	// 	foreach($approvers as $approver_username) {
	// 		$array_values 	= array($date_time_today, $_POST['username'], $pkid, $approver_username, 'PENDING', $date_time_today, $_POST['username']);
	// 		$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
	// 		$script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
	// 	}	
		
	// 	/* Upload new file to target directory */
	// 	if(isset($_FILES["file_ng"]["tmp_name"])) {
	// 		$array_fields = array('file_name','fkfile_path');
	// 		$joins 	   	= '';
	// 		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel="0"';
	// 		$sql_order 	= '';
	// 		$sql_limit 	= '';
	// 		$result 	= TQTS::getInstance()->select_query($array_fields,'tbl_qfr_ng',$joins,$sql_where,$sql_order,$sql_limit);
	// 		if($row = mysqli_fetch_array($result)) {
	// 			$existing_file 		= $row['file_name'];
	// 			$existing_file_e 	= explode('.',$row['file_name']);
	// 			$existing_file_ext 	= end($existing_file_e);
	// 			$existing_path 		= $row['fkfile_path'];
	// 		}
	// 		$file  		     = return_file_path_by_div_mod('ng_new');
	// 		$fkfile_path     = $file['pkid'];
	// 		$target_dir      = $file['path'];
	// 		$temp_file 	 	 = $_FILES["file_ng"]["tmp_name"];
	// 		$file_name 		 = $_FILES["file_ng"]["name"];		
	// 		$target_file	 = $target_dir . $file_name;
	// 		$ext 			 = pathinfo($target_file, PATHINFO_EXTENSION);
	// 		$new_file		 = $target_dir .$pkid.".".$ext;
	// 		$existing_file	 = $target_dir .$pkid.".".$existing_file_ext;
	// 		if(file_exists($existing_file)) {
	// 			unlink($existing_file);
	// 			if (move_uploaded_file($temp_file, $target_file)) {					
	// 				if(rename ($target_file, $new_file)){	
	// 					/* Update file name and path and reset the status */
	// 					$table 			= 'tbl_qfr_ng';
	// 					$array_fields 	= array('file_name', 'fkfile_path','status');
	// 					$array_values 	= array($file_name,$fkfile_path, 'FOR APPROVAL');
	// 					$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
						
	// 					$msg = 'File was successfully uploaded to the system';
	// 					/* Send email notification to the first approver */
	// 					ng_send_email_for_approval($pkid);
	// 				} else {
	// 					$msg = 'There was an error on renaming the file.';
	// 				}						
	// 			} else {
	// 				$msg = "Sorry, there was an error uploading your file.";
	// 			}
	// 		}	
	// 	} else {
	// 		// $msg .= 'no file';
	// 		ng_send_email_for_approval($pkid);
	// 	}
				
	// 	$lot_numbers	= explode(",",$_POST["lot_numbers"]);
	// 	$lot_pkid		= explode(",",$_POST["lot_pkid"]);
	// 	$quantity		= explode(",",$_POST["quantity"]);
	// 	$table			= 'tbl_qfr_ng_lot_numbers';
		
	// 	/* Update logdel to 1 */
	// 	$sql_where		= 'WHERE fkng='.$pkid;
	// 	$array_fields 	= array('lastupdate', 'username', 'logdel');
	// 	$array_values 	= array($date_time_today, $_POST['username'], 1);
	// 	$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
	// 	/* Re-enter lot numbers */
	// 	$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'lot_no', 'quantity', 'lastupdate', 'username');
	// 	for($i=0; $i<count($lot_numbers);$i++) {
	// 		if($lot_pkid[$i] == 0) {
	// 			$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'lot_no', 'quantity', 'lastupdate', 'username');
	// 			$array_values 	= array($date_time_today, $_POST['username'], $pkid, $lot_numbers[$i], $quantity[$i], $date_time_today, $_POST['username']);
	// 			$script	.= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
	// 		} else {
	// 			$array_fields 	= array('lot_no', 'quantity', 'lastupdate', 'username', 'logdel');
	// 			$array_values 	= array($lot_numbers[$i], $quantity[$i], $date_time_today, $_POST['username'], 0);
	// 			$update_query	= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$lot_pkid[$i]);
	// 			$script	.= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$lot_pkid[$i]);
	// 		}
	// 	}	
		
	// 	$return['msg'] = $msg;
	// 	$return['script'] = $script;
	// 	echo json_encode($return);
	// }
	function update_ng_report() { //Updating of Upload file function was successful, ready to transfer in live server
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$approvers 		 = implode(',',$_POST["approvers"]);
		$table  		= 'tbl_qfr_ng';
		$values		  	= get_fields_values($_POST,array("action","file_ng","report_approvers_edit","lot_numbers","lot_pkid","username","fkfile_path","wbs_id","approvers", "rbtn_new","device_name","quantity"));
		$array_fields 	= $values["array_fields"];
		$array_values 	= $values["array_values"];
		$array_fields[] = "lastupdate"; $array_values[] = $date_time_today;
		$array_fields[] = "username"; $array_values[] = $_POST['username'];
		$pkid  			= $_POST['pkid'];
		$result		    = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$msg = $result? $msg = 'Saved Successfully':'';
		$script		    = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		
		/* Update approvers */
		$table			= 'tbl_qfr_ng_approvers';
		$sql_where		= 'WHERE fkng='.$pkid;
		$array_fields 	= array('lastupdate', 'username', 'logdel');
		$array_values 	= array($date_time_today, $_POST['username'], 1);
		$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		
		$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'approver_username', 'status', 'lastupdate', 'username');
		$approvers 		 = explode(',',$approvers);
		foreach($approvers as $approver_username) {
			$array_values 	= array($date_time_today, $_POST['username'], $pkid, $approver_username, 'PENDING', $date_time_today, $_POST['username']);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			$script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
		
		/* Upload new file to target directory */
		if(isset($_FILES["file_ng"]["tmp_name"])) {
			$array_fields = array('file_name','fkfile_path');
			$joins 	   	= '';
			$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel="0"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result 	= TQTS::getInstance()->select_query($array_fields,'tbl_qfr_ng',$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$existing_file 		= $row['file_name'];
				$existing_file_e 	= explode('.',$row['file_name']);
				$existing_file_ext 	= end($existing_file_e);
				$existing_path 		= $row['fkfile_path'];
			}
			$file  		     = return_file_path_by_div_mod('ng_new');
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];
			$existing_file	 = $target_dir .$pkid;
			if(is_dir($existing_file)) {
				array_map('unlink', glob("$existing_file/*.*"));
			}	
			if(!file_exists($target_dir.$pkid.'/')) {
				$msg = "Directory doesn't exist";
			} 
			$target_dir = $target_dir.$pkid.'/';
			/* Upload the file to target directory */	
			for($i=0; $i < count($_FILES["file_ng"]["tmp_name"]); $i++) {
				$temp_file 	     = $_FILES["file_ng"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_ng"]["name"][$i];
				
				$target_file 	 = $target_dir . $file_name;
				if (file_exists($target_file)) {
					$msg = "Sorry, your file already exists.";
				} else {
					if (move_uploaded_file($temp_file, $target_file)) {
						/* Rename the file based on pkid of Quality Report */					
						$ext = pathinfo($target_file, PATHINFO_EXTENSION);
						$new_file_name  = ($i+1).".".$ext;
						if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
							$msg = 'File was successfully uploaded to the system.<br>';
							/* Update file name and path and reset the status */
							$table 			= 'tbl_qfr_ng';
							$array_fields 	= array('file_name', 'fkfile_path','status');
							$array_values 	= array($file_name,$fkfile_path, 'FOR APPROVAL');
							$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
							$msg = 'File was successfully uploaded to the system';
									/* Send email notification to the first approver */
									// ng_send_email_for_approval($pkid);
							if($i == 0) {
								// ng_send_email_for_approval($pkid);
							}
						} else {
							$msg = 'There was an error on renaming the file.';
						}					
					} else {
						$msg = "Sorry, there was an error uploading your file.";
					}
				}
			}
		} else {
			// $msg .= 'no file';
			// ng_send_email_for_approval($pkid);
		}
				
		$lot_numbers	= explode(",",$_POST["lot_numbers"]);
		$lot_pkid		= explode(",",$_POST["lot_pkid"]);
		$quantity		= explode(",",$_POST["quantity"]);
		$table			= 'tbl_qfr_ng_lot_numbers';
		
		/* Update logdel to 1 */
		$sql_where		= 'WHERE fkng='.$pkid;
		$array_fields 	= array('lastupdate', 'username', 'logdel');
		$array_values 	= array($date_time_today, $_POST['username'], 1);
		$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		/* Re-enter lot numbers */
		$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'lot_no', 'quantity', 'lastupdate', 'username');
		for($i=0; $i<count($lot_numbers);$i++) {
			if($lot_pkid[$i] == 0) {
				$array_fields 	= array('date_time_created', 'created_by', 'fkng', 'lot_no', 'quantity', 'lastupdate', 'username');
				$array_values 	= array($date_time_today, $_POST['username'], $pkid, $lot_numbers[$i], $quantity[$i], $date_time_today, $_POST['username']);
				$script	.= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			} else {
				$array_fields 	= array('lot_no', 'quantity', 'lastupdate', 'username', 'logdel');
				$array_values 	= array($lot_numbers[$i], $quantity[$i], $date_time_today, $_POST['username'], 0);
				$update_query	= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$lot_pkid[$i]);
				$script	.= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$lot_pkid[$i]);
			}
		}	
		
		$return['msg'] = $msg;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function ng_send_email_for_approval($pkid_quality_report) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('created_by', 'issuance_date', 'invoice_no', 'part_code','po_number','drawing_number', 'supplier', 'remarks', 'parts_affected_parts');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid_quality_report.'" AND status="FOR APPROVAL" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$issuance_date 		= date('M d, Y',strtotime($row['issuance_date']));
			$invoice_no 		= $row['invoice_no'];
			$part_code 		    = $row['part_code'];
			$part_name 			= $row['part_code'] == 'N/A' ? $row['parts_affected_parts'] : get_part_name_by_code2($row['part_code']);
			$po_number 		    = $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$lot_no 		    = return_ng_lot_numbers($pkid_quality_report);
			$drawing_number 	= $row['drawing_number'];
			$supplier 			= $row['supplier'];
			$remarks 			= $row['remarks'];			
		}
		// if($part_code != '') {
			$part_details 		= '&emsp;Part Code: '.$part_code.' <br>';
			$part_details 	   .= '&emsp;Part Name: '.$part_name.' <br>';
		// } else if ($po_number != '') {
			$part_details 	   .= '&emsp;PO Number: '.$po_number.' <br>';
			$part_details 	   .= '&emsp;Device Name: '.$ypics_data['device_name'].' <br>';
		// } 
		$subject 	 = 'FOR APPROVAL NG REPORT: '.$invoice_no.'';
		$body 	 	 = 'Please be informed that you have NG Report for approval.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
		$body 		.= '&emsp;Invoice No.: '.$invoice_no.' <br>';
		$body 		.= $part_details;
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
		$body 		.= '&emsp;Supplier: '.$supplier.' <br>';
		$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
		
		/* Select the report signatories */
		$result = "";
		$array_fields = array('approver_username');
		$table 	   	= 'tbl_qfr_ng_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkng="'.$pkid_quality_report.'" AND status="PENDING" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$approver_username = '';
		$to_recipients = array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$approver_username 	= $row['approver_username'];
			$to_recipients[]	= return_user_email_add($approver_username) == 'NONE' ? '' : return_user_email_add($approver_username);
		}
		$to 		= implode(',',$to_recipients);
		$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
	}
	
	function return_ng_lot_numbers($fkng) {
		require_once('../class/oop_tqts.php');
		$lot_no		= array();
		$array_fields = array('lot_nos.lot_no');
		$table 	   	= 'tbl_qfr_ng_lot_numbers lot_nos';
		$joins 	   	= 'INNER JOIN tbl_qfr_ng ng ON ng.pkid = lot_nos.fkng';
		$sql_where 	= 'WHERE lot_nos.fkng="'.$fkng.'" AND lot_nos.logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$approvers  = '';
		while($row = mysqli_fetch_array($result)){
			$lot_no[]				.= $row['lot_no'];
		}
		$lot_no = count($lot_no) == 0 ? 'N/A' : implode(', ', $lot_no);
		return $lot_no;	
	}
	
	function load_ng_details_by_pkid() {
		require_once('../class/oop_tqts.php');
		/* Return NG report details */
		$return 	= array();
		$return 	= $_POST;
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid`="'.$_POST['pkid'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
			
			$array_approver = explode(",",$return['data']['supplier']);
			$return['supplier'] 	= array();
			foreach($array_approver as $key => $value){
				$array_data_sup 			= array();
				$array_data_sup['id'] 		= $value;
				$array_data_sup['text'] 	= $value;
				$return['supplier'][]		= $array_data_sup;
			}
		}
		
		/* Return approver details */
		$approver_username	= array();
		$date_time_approved	= array();
		$approver_status	= array();
		$array_fields = array('approver_username','date_time_approved', 'status');
		$table 	   	= 'tbl_qfr_ng_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkng`="'.$_POST['pkid'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$approver_username[] 			= $row['approver_username'];
			$date_time_approved[]		 	= $row['date_time_approved'];
			$approver_status[] 				= $row['status'];
		}
		$return['approver_username'] 	= implode(',',$approver_username);
		$return['date_time_approved']	= implode(',',$date_time_approved);
		$return['approver_status'] 		= implode(',',$approver_status);
		
		$array_approver = explode(",",$return['approver_username']);
		$return['approver_username'] 	= array();
		foreach($array_approver as $key => $value){
			$array_data_app 				= array();
			$array_data_app['id'] 			= $value;
			$array_data_app['text'] 		= get_emp_name_by_username_systemone($value);
			$return['approver_username'][]	= $array_data_app;
		}
		echo json_encode($return);
	}
		
	function get_ng_lot_numbers_by_fkng() {
		require_once('../class/oop_tqts.php');
		$fkng		= $_POST['fkng'];
		$lot_no		= array();
		$quantity	= array();
		$lot_pkid	= array();
		$array_fields = array('lot_nos.pkid','lot_nos.lot_no','lot_nos.quantity');
		$table 	   	= 'tbl_qfr_ng_lot_numbers lot_nos';
		$joins 	   	= 'INNER JOIN tbl_qfr_ng ng ON ng.pkid = lot_nos.fkng';
		$sql_where 	= 'WHERE lot_nos.fkng="'.$fkng.'" AND lot_nos.logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$approvers  = '';
		while($row = mysqli_fetch_array($result)){
			$lot_pkid[]				.= $row['pkid'];
			$lot_no[]				.= $row['lot_no'];
			$quantity[]				.= $row['quantity'];
		}
		$lot_no = count($lot_no) == 0 ? 'N/A' : implode(', ', $lot_no);
		$quantity = count($quantity) == 0 ? 'N/A' : implode(', ', $quantity);
		$lot_pkid = count($lot_pkid) == 0 ? 'N/A' : implode(', ', $lot_pkid);
		$return['lot_no'] 	= $lot_no;
		$return['quantity'] = $quantity;
		$return['lot_pkid'] = $lot_pkid;
		echo json_encode($return);
	}
	
	function get_approvers_log() {
		require_once('../class/oop_tqts.php');
		$fkng			= $_POST['fkng'];
		$table_body		= '';
		$array_fields = array('approver_username', 'status', 'date_time_approved', 'approver_remarks');
		$table 	   	= 'tbl_qfr_ng_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkng="'.$fkng.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$table_body .= '<tr>';
			$table_body .= '	<td>'.$row['status'].'</td>';
			$table_body .= '	<td>'.get_emp_name_by_username($row['approver_username']).'</td>';
			$table_body .= '	<td>'.($row['approver_remarks'] == '' ? '-' : $row['approver_remarks']).'</td>';
			$table_body .= '	<td>'.($row['date_time_approved'] == '' ? '-' : date('M d, Y h:i A',strtotime($row['date_time_approved']))).'</td>';
			$table_body .= '</tr>';
		}
		$return['table_body'] 	= $table_body;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function ng_approver_decision() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$fkng    	 	 = $_POST['fkng'];
		$status   		 = $_POST['status'];
		$remarks  		 = $_POST['remarks'];
		$username  		 = $_POST['username'];		
		$msg 		     = '';		
		$script 		 = '';		
		
		/* Update the record based on pkid */
		$table_details	= 'tbl_qfr_ng_approvers';
		$array_fields 	= array('status', 'date_time_approved', 'approver_remarks','lastupdate','username');
		$array_values 	= array($status, $date_time_today, $remarks, $date_time_today,$username);
		$sql_where		= 'WHERE fkng='.$fkng.' AND approver_username="'.$username.'" AND logdel=0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		
		$table_main		= 'tbl_qfr_ng';		
		
		if($status == "APPROVED"){
			/* Update main table if all approver approved the request */
			$rows_status = 'APPROVED';
			$array_fields = array('status');
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkng="'.$fkng.'" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$checker_status 	= 0;
			$result = TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				if($row['status'] == 'PENDING') {
					$rows_status = 'PENDING';
					/* Send email to all approver who's status is PENDING */
					ng_send_email_for_approval($fkng);
					$checker_status = 1;
					break;
				}
			}
			if($checker_status == 0) {
				$array_fields 	= array('status');
				$array_values 	= array($status);
				$sql_where		= 'WHERE pkid='.$fkng.' AND logdel=0';
				$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
			}
		} else {
			$array_fields 	= array('status');
			$array_values 	= array($status);
			$sql_where		= 'WHERE pkid='.$fkng.' AND logdel=0';
			$msg 			= TQTS::getInstance()->update_query_detailed($table_main,$array_fields,$array_values,$sql_where);
			$script 		.= TQTS::getInstance()->update_query_detailed_script($table_main,$array_fields,$array_values,$sql_where);
		}
		/* Send email regarding APPROVED/DISAPPROVED/CANCELLED status */
		ng_send_email_approver_decision($fkng,$username,$status);
		ng_send_ready_sending_disposition($fkng);
		$return['script']  = $script;
		$return['msg']  = $msg;
		echo json_encode($return);
	}
	
	function ng_send_email_approver_decision($pkid_quality_report, $approver_username, $status) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('created_by', 'issuance_date', 'invoice_no', 'part_code', 'po_number' ,'drawing_number', 'supplier', 'remarks', 'parts_affected_parts');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid_quality_report.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$issuance_date 		= date('M d, Y',strtotime($row['issuance_date']));
			$invoice_no 		= $row['invoice_no'];
			$part_code 			= $row['part_code'];
			$part_name 			= $row['part_code'] == 'N/A' ? $row['parts_affected_parts'] : get_part_name_by_code2($row['part_code']);
			$po_number 			= $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$lot_no 			= return_ng_lot_numbers($pkid_quality_report);
			$drawing_number 	= $row['drawing_number'];
			$supplier 			= $row['supplier'];
			$remarks 			= $row['remarks'];
			
		}
		// if($part_code != '') {
			// $subject 		 	= $status.' NG REPORT : '.$part_code.' ('.$part_name.')';
			$subject 		 	= $status.' NG REPORT : '.$part_code.' ('.$part_name.') | ' . $po_number.' ('.$ypics_data['device_name'].')';
			$part_details 		= '&emsp;Part Code: '.$part_code.' <br>';
			$part_details 	   .= '&emsp;Part Name: '.$part_name.' <br>';
		// } else if ($po_number != '') {
			// $subject 		 	= $status.' NG REPORT : '.$po_number.' ('.$ypics_data['device_name'].')';
			$part_details 	   .= '&emsp;PO Number: '.$po_number.' <br>';
			$part_details 	   .= '&emsp;Device Name: '.$ypics_data['device_name'].' <br>';
		// } 
		
		$body 	 	 = 'Please be informed that your NG Report has been '.$status.'.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
		$body 		.= '&emsp;Invoice Number: '.$invoice_no.' <br>';
		$body 		.= $part_details;
		$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
		$body 		.= '&emsp;Supplier: '.$supplier.' <br>';
		$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
		
		$to 		 = return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		$from 		 = return_user_email_add($approver_username) == 'NONE' ? '' : return_user_email_add($approver_username);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
	}
	
	function ng_send_for_disposition() {
        require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
        $date_time_today 	 = date('Y-m-d H:i:s');	
        $fkng 				 = trim($_POST['fkng'],' ');
        $ng_report_no  		 = $_POST['ng_report_no'];
        $username  			 = $_POST['username'];
        $to_recip_internal   = !isset($_POST['ng_send_to']) ? '' : implode(',',$_POST['ng_send_to']);
        $to_recip_external   = $_POST['ng_send_external_to'] == '' ? '' : implode(',',$_POST['ng_send_external_to']);
        $cc_recip_internal   = !isset($_POST['ng_send_cc'])  ? '' : implode(',',$_POST['ng_send_cc']);
        $cc_recip_external   = $_POST['ng_send_external_cc'] == '' ? '' : implode(',',$_POST['ng_send_external_cc']);
        $disposition_remarks    = $_POST['remarks'];        
        $msg = '';
        
		if(check_ng_report_no($ng_report_no) == 0) {
			$file  		     = return_file_path_by_div_mod('ng_approved');
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];
			
			if(!file_exists($target_dir.$fkng.'/')) {
				$target_dir = $target_dir.$fkng.'/';
				mkdir($target_dir, 0777, false);
			} 
			/* Upload the file to target directory */	
			for($i=0; $i < count($_FILES["file_ng"]["tmp_name"]); $i++) {
				$temp_file 	     = $_FILES["file_ng"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_ng"]["name"][$i];
				$target_file = $target_dir . $file_name;
				if (file_exists($target_file)) {
					$msg = "Sorry, your file already exists.";
				} else {
					if (move_uploaded_file($temp_file, $target_file)) {
						/* Rename the file based on pkid of Quality Report */					
						$ext = pathinfo($target_file, PATHINFO_EXTENSION);
						$new_file_name  = trim(($i+1)).".".$ext;
						if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
							$msg = 'File was successfully uploaded to the system.<br>';
						} else {
							$msg = 'There was an error on renaming the file.';
						}					
					} else {
						$msg = "Sorry, there was an error uploading your file.";
					}
				}
			}
			
			/* Update the status as WAITING DISPOSITION */
			$table_details	= 'tbl_qfr_ng';
			$array_fields 	= array('fkfile_path','file_name','ng_report_no','fail_mode','status', 'supplier', 'lastupdate','username');
			$array_values 	= array($fkfile_path, (implode(' | ', $_FILES["file_ng"]["name"])), $ng_report_no, $return['fail_mode'],'WAITING DISPOSITION', $_POST['supplier'], $date_time_today,$username);
			$sql_where		= 'WHERE pkid='.$fkng.' AND logdel=0';
			$msg 			.= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
			
			/* Create new row for new code with disposition */
			$table_dispo	     = 'tbl_qfr_ng_treatment';
			$array_fields_dispo  = array('date_time_created', 'created_by', 'fkng', 'disposition_sent_by', 'disposition_sent_date', 'disposition_sent_remarks', 'lastupdate', 'username');
			$array_values_dispo  = array($date_time_today,$username,$fkng,$username,$date_time_today, $disposition_remarks, $date_time_today,$username);
			$query_msg       	 = TQTS::getInstance()->insert_query($table_dispo,$array_fields_dispo,$array_values_dispo);
			
			/* Create email notification */
			$result = "";
			$array_fields = array('created_by', 'ng_report_no', 'issuance_date', 'invoice_no', 'part_code', 'po_number', 'drawing_number', 'supplier', 'remarks', 'file_name', '(SELECT tbl_file_path.file_path FROM tbl_file_path WHERE tbl_file_path.pkid=fkfile_path LIMIT 0,1) as file_path', 'parts_affected_parts');
			$table 	   	= 'tbl_qfr_ng';
			$joins 	   	= '';
			$sql_where 	= 'WHERE pkid="'.$fkng.'"';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)){
				$created_by 		= $row['created_by'];
				$ng_report_no 		= $row['ng_report_no'];
				$issuance_date 		= date('M d, Y',strtotime($row['issuance_date']));
				$invoice_no 		= $row['invoice_no'];
				$part_code 			= $row['part_code'];
				$part_name 			= $row['part_code'] == 'N/A' ? $row['parts_affected_parts'] : get_part_name_by_code2($row['part_code']);
				$po_number 			= $row['po_number'];
				$ypics_data 		= get_series_name($row['po_number']);
				$lot_no 			= return_ng_lot_numbers($fkng);
				$drawing_number 	= $row['drawing_number'];
				$supplier 			= $row['supplier'];
				$remarks 			= $row['remarks'];
				$file_array			= explode(' | ', $row['file_name']);
				$attachment			= array();
				$attachment_name	= array();
				for($i=0; $i<count($file_array); $i++) {
					$tqts_path			= str_replace('/var/www/','',realpath(dirname(__FILE__)."/../"));
					$ext                = end(explode('.',$file_array[$i]));
					$attachment[]       = str_replace('../',$tqts_path.'/',$row['file_path'].$fkng.'/'.($i+1).'.'.$ext);
					$attachment_name[]	= $file_array[$i];
				}
				$attachment 	 = implode('|', $attachment);
				$attachment_name = implode('|', $attachment_name);
			}
			
			// if($part_code != '') {
				// $subject 	 = 'Urgent NG REPORT : '.$ng_report_no.' '.$part_name.' '.$_POST['fail_mode'];
				$subject 	 =  $ng_report_no.' '.$part_name.' '.$_POST['fail_mode'];
				$part_details 		= '&emsp;Part Code: '.$part_code.' <br>';
				$part_details 	   .= '&emsp;Part Name: '.$part_name.' <br>';
			// } else if ($po_number != '') {
				// $subject 	 = 'Urgent NG REPORT : '.$ng_report_no.' '.$po_number.' '.$_POST['fail_mode'];
				$subject 	 = $ng_report_no.' '.$part_name.' '.$_POST['fail_mode'];
				$part_details 	   .= '&emsp;PO Number: '.$po_number.' <br>';
				$part_details 	   .= '&emsp;Device Name: '.$ypics_data['device_name'].' <br>';
			// } 
			
			$body 		 = 'Good day! <br>';
			$body 		.= $_POST['message'].'<br>';
			$body 	 	.= 'Attached is the NG report generated due to the defect encountered:<br> <br>';
			$body 		.= $part_details;
			$body 		.= '&emsp;Fail Mode: '.$_POST['fail_mode'].' <br>';
			$body 		.= '&emsp;Supplier: '.$supplier.' <br>';
			$body 		.= 'For your disposition.'.' <br><br>';
			
			$to = array();
			if($to_recip_internal != '') {
				$to_recip_internal = explode(',',$to_recip_internal);
				for($i=0;$i<count($to_recip_internal);$i++) {
					array_push($to, $to_recip_internal[$i]);
				}	
			}
			if($to_recip_external != '') {
				$to_recip_external = explode(',',$to_recip_external);
				for($i=0;$i<count($to_recip_external);$i++) {
					array_push($to, $to_recip_external[$i]);
				}	
			}
			
			$cc = array();
			if($cc_recip_internal != '') {
				$cc_recip_internal = explode(',',$cc_recip_internal);
				for($i=0;$i<count($cc_recip_internal);$i++) {
					array_push($cc, $cc_recip_internal[$i]);
				}	
			}
			if($cc_recip_external != '') {
				$cc_recip_external = explode(',',$cc_recip_external);
				for($i=0;$i<count($cc_recip_external);$i++) {
					array_push($cc, $cc_recip_external[$i]);
				}
			}		
			$to 		 = implode(',',$to);
			$cc 		 = implode(',',$cc);
			$from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);

			$php_mailer = new email();
			// $php_mailer->send_email($to, $from, $cc, $subject, $body,$attachment,$attachment_name);
			$php_mailer->send_email_with_attachment($to, $from, $cc, $subject, $body, $attachment_name, $attachment);

			//For follow-up email - this portion is copied from YF TQTS
			$subject 	 = 'Follow-up: '.$ng_report_no.' '.$part_name.' '.$_POST['fail_mode'];
			$body 		 = 'Good day! <br>';
			$body 		.= $_POST['message'].'<br>';
			$body 	 	.= 'This is a follow-up email regarding the NG report generated due to the defect encountered:<br> <br>';
			$body 		.= $part_details;
			$body 		.= '&emsp;Fail Mode: '.$_POST['fail_mode'].' <br>';
			$body 		.= '&emsp;Supplier: '.$supplier.' <br>';
			$body 		.= 'For your disposition.'.' <br><br>';
			
			// $php_mailer->send_scheduled_email('tbl_qfr_ng', $fkng, $to, $from, $cc, $subject, $body , (date('Y-m-d', strtotime($date_time_today.' +1 day'))), '2');//3-22-2019
			//novs
			require_once('common_function.php');
			$auto_mailer2_result = send_with_auto_mailer2(
				'db_tqts_ts',
				'tbl_qfr_ng', 
				$fkng, 
				'TQTS', 
				$from, 
				'', 
				$to, 
				'', 
				$cc, 
				'naayes@pricon.ph',
				'',
				'', 
				$subject, 
				$body, 
				$username, 
				$date_time_today,
				$date_time_today,
				$date_time_today,
				0,
				0,
				0,
				0,
				0,
				'6,7'
			);
			$return['mailer2'] = $auto_mailer2_result;
			//-/novs

			$return['msg'] = "Message has been sent!";
		} else {
			$return['msg'] = 'NG Report Number already exist!';
		}
		
		$return['POST'] = $_POST;
		echo json_encode($return);
    }
	
	function ng_send_ready_sending_disposition($pkid_quality_report) {
        require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('created_by', 'issuance_date', 'invoice_no', 'part_code', 'po_number' ,'drawing_number', 'supplier', 'remarks', 'parts_affected_parts');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid_quality_report.'" AND status="APPROVED" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$issuance_date 		= date('M d, Y',strtotime($row['issuance_date']));
			$invoice_no 		= $row['invoice_no'];
			$part_code 			= $row['part_code'];
			$part_name 			= $row['part_code'] == 'N/A' ? $row['parts_affected_parts'] : get_part_name_by_code2($row['part_code']);
			$po_number 			= $row['po_number'];
			$ypics_data 		= get_series_name($row['po_number']);
			$lot_no 			= return_ng_lot_numbers($pkid_quality_report);
			$drawing_number 	= $row['drawing_number'];
			$supplier 			= $row['supplier'];
			$remarks 			= $row['remarks'];
			
			// if($part_code != '') {
				// $subject 		 	= 'FOR SENDING NG REPORT : '.$part_code.' ('.$part_name.')';
				$subject 		 	= 'FOR SENDING NG REPORT : '.$part_code.' ('.$part_name.') | '.$po_number.' ('.$ypics_data['device_name'].')';
				$part_details 		= '&emsp;Part Code: '.$part_code.' <br>';
				$part_details 	   .= '&emsp;Part Name: '.$part_name.' <br>';
				$body 	 	 		= 'This is to inform you that the NG report request with Invoice #: '.$invoice_no.' and Part Code: '.$part_code.' is ready for sending to Supplier.<br> <br>';
			// } else if ($po_number != '') {
				// $subject 		 	= 'FOR SENDING NG REPORT : '.$po_number.' ('.$ypics_data['device_name'].')';
				$part_details 	   .= '&emsp;PO Number: '.$po_number.' <br>';
				$part_details 	   .= '&emsp;Device Name: '.$ypics_data['device_name'].' <br>';
				$body 	 	 		= 'This is to inform you that the NG report request with Invoice #: '.$invoice_no.' and PO Number: '.$po_number.' is ready for sending to Supplier.<br> <br>';
			// } else {
				// $subject 		 	= 'SOMETHING IS WRONG! Please inform ISS';
				// $body 	 	 		= 'Something is wrong!!!!! Please inform ISS ahead.<br> <br>';
			// }	
			
			$body 		.= 'Request details: <br>';
			$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
			$body 		.= '&emsp;Invoice Number: '.$invoice_no.' <br>';
			$body 		.= $part_details;
			$body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
			$body 		.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
			$body 		.= '&emsp;Supplier: '.$supplier.' <br>';
			$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
			
			$array_fields = array('`user`');
			$table 	   	= 'tbl_user_roles';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fk_module="7" AND `read` = 1 AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$to_array	= array();
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				if(return_user_email_add($row['user']) != 'NONE') {
					$to_array[] 	= return_user_email_add($row['user']);
				}
			}
			
			$to 		 = implode(',', $to_array);
			$from 		 = 'TQTSystemNotification@pricon.ph';
			
			$php_mailer = new email();
			$php_mailer->send_email($to, $from, '', $subject, $body,'','');
		} 
    }
	
	function load_ng_treatment_details_by_fkng() {
		require_once('../class/oop_tqts.php');
		/* Return NG report treatment details */
		$return 	= array();
		$return 	= $_POST;
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_ng_treatment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkng`="'.$_POST['fkng'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
		}else{
			$return['data'] = 0;

		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_disposition_list() {
		require_once('../class/oop_tqts.php');
		$array_fields = array('disposition');
		$table 	   	= 'tbl_disposition';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel="0"';
		$sql_order 	= 'ORDER BY disposition';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select = '<option></option>';
		while($row = mysqli_fetch_array($result)){
			$html_select .= '<option value="'.$row['disposition'].'">'.$row['disposition'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function add_treatment() {
		require_once('../class/oop_tqts.php');
        $date_time_today        = date('Y-m-d H:i:s');	
        $fkng                   = $_POST['fkng'];
        $disposition            = $_POST['disposition'];
        $disposition_by         = $_POST['disposition_by'];
        $disposition_date       = $_POST['disposition_date'];
        $disposition_time       = $_POST['disposition_time'];
        $disposition_remarks    = $_POST['disposition_remarks'];
        $final_reply_status     = $_POST['final_reply_status'];
        $final_reply_date       = $_POST['final_reply_date'];
        $final_reply_time       = $_POST['final_reply_time'];
        $final_reply_remarks    = $_POST['final_reply_remarks'];
        $disposition_status     = $_POST['disposition_status'];
        $username               = $_POST['username'];
        $msg               		= '';
        $disposition_file_name = array();
        /* Upload the disposition */
        if($disposition_status == 'WITH TREATMENT') {
			// echo 'WITH TREATMENT';
			
			if(isset($_FILES['treatment_file']["name"])) {
			/* nmodify MIGZ 10262023 : 1 data will saved, dont need to use the for loop
				for($i=0; $i<count($_FILES['treatment_file']['name']); $i++) {
					$temp_file 	     = $_FILES["treatment_file"]["tmp_name"];
					$file_name 	     = $_FILES["treatment_file"]["name"];
					$file  		     = return_file_path_by_div_mod('ng_disposition');
					$fkfile_path     = $file['pkid'];
					$target_dir      = $file['path'].$fkng."_1/";
					if(!file_exists($target_dir)){
						mkdir($target_dir.'/', 0777);
					}
					$target_file     		 = $target_dir . $file_name;
						$disposition_file_name[] = $file_name;
					if (file_exists($target_file)) {
						$msg = "Sorry, your file already exists.";
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {
							$msg .= '<br>File was successfully uploaded to the system ->'.$file_name;				
						} else {
							$msg .= "Sorry, there was an error uploading your file.";
						}
					}
				}
				
			*/
				$temp_file 	     = $_FILES["treatment_file"]["tmp_name"];
				$file_name 	     = $_FILES["treatment_file"]["name"];
				$file  		     = return_file_path_by_div_mod('ng_disposition');
				$fkfile_path     = $file['pkid'];
				$target_dir      = $file['path'].$fkng."_1/";
				if(!file_exists($target_dir)){
					mkdir($target_dir.'/', 0777);
				}
				$target_file     		 = $target_dir . $file_name;
				$disposition_file_name[] = $file_name;
				if (file_exists($target_file)) {
					$msg = "Sorry, your file already exists.";
				} else {
					if (move_uploaded_file($temp_file, $target_file)) {
						$msg .= '<br>File was successfully uploaded to the system ->'.$file_name;				
					} else {
						$msg .= "Sorry, there was an error uploading your file.";
					}
				}
				$disposition_file_name = implode(',',$disposition_file_name);
				$table 			= 'tbl_qfr_ng_treatment';
				$array_fields 	= array('disposition_file_name','fkfile_path','lastupdate', 'username');
				$array_values 	= array($disposition_file_name,$fkfile_path,$date_time_today, $username);
				$sql_where      = 'WHERE fkng='.$fkng.' AND logdel=0';
				$msg 		    = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
				
				//novs
				/* Stop daily email notification alert on "Follow-up" */
				require_once('../class/oop_mailer2.php');
				$table_mailer 			= 'tbl_auto_mailer';
				$array_fields_mailer 	= array('logdel');
				$array_values_mailer 	= array('1');
				$sql_where_mailer		= 'WHERE fkid="'.$fkng.'" AND db_name="db_tqts_ts" AND tbl_name="tbl_qfr_ng" AND system_name="TQTS"';
				$msg_mailer 			= MAILER2::getInstance()->update_query_detailed($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				$script 			   = MAILER2::getInstance()->update_query_detailed_script($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				//-/novs
			}else{
				echo 'Saving Failed, WITH TREATMENT';
			}
        } else if($disposition_status == 'WITH FINAL REPLY') {
			if(isset($_FILES['final_reply_file'])) {
				$final_reply_file_name = array();
				for($i=0; $i<count($_FILES['final_reply_file']['name']); $i++) {
					$temp_file 	     = $_FILES["final_reply_file"]["tmp_name"][$i];
					$file_name 	     = $_FILES["final_reply_file"]["name"][$i];
					$file  		     = return_file_path_by_div_mod('ng_disposition');
					$fkfile_path     = $file['pkid'];
					$target_dir      = $file['path'];
					$target_dir      = $file['path'].$fkng."_2/";
					if(!file_exists($target_dir)){
						mkdir($target_dir.'/', 0777);
					}
					$target_file     		 = $target_dir . $file_name;
					$final_reply_file_name[] = $file_name;
					if (file_exists($target_file)) {
						$msg = "Sorry, your file already exists.";
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {
							/* Rename the file based on pkid of Quality Report */					
							$msg .= 'File was successfully uploaded to the system ->'.$file_name;							
						} else {
							$msg .= "Sorry, there was an error uploading your file.";
						}
					}
				}
				$final_reply_file_name = implode(',',$final_reply_file_name);
				$table 			= 'tbl_qfr_ng_treatment';
				$array_fields 	= array('final_reply_file_name','fkfile_path','lastupdate', 'username');
				$array_values 	= array($final_reply_file_name,$fkfile_path,$date_time_today, $username);
				$sql_where      = 'WHERE fkng='.$fkng.' AND logdel=0';
				$msg 		    = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);

				//novs
				/* Stop daily email notification alert on "Follow-up" */
				require_once('../class/oop_mailer2.php');
				$table_mailer 			= 'tbl_auto_mailer';
				$array_fields_mailer 	= array('logdel');
				$array_values_mailer 	= array('1');
				$sql_where_mailer		= 'WHERE fkid="'.$fkng.'" AND db_name="db_tqts_ts" AND tbl_name="tbl_qfr_ng" AND system_name="TQTS"';
				$msg_mailer 			= MAILER2::getInstance()->update_query_detailed($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				$script 			   .= MAILER2::getInstance()->update_query_detailed_script($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				//-/novs
			}
        }
        /* Update disposition */
        $table 			= 'tbl_qfr_ng_treatment';
		$array_fields 	= array('disposition', 'disposition_by', 'disposition_date','disposition_time','disposition_remarks','final_reply_status', 'final_reply_date', 'final_reply_time', 'final_reply_remarks','lastupdate', 'username');
		$array_values 	= array($disposition,$disposition_by,$disposition_date,$disposition_time,$disposition_remarks,$final_reply_status,$final_reply_date,$final_reply_time,$final_reply_remarks,$date_time_today, $username);
        $sql_where      = 'WHERE fkng='.$fkng.' AND logdel=0';
		$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$sql_where);
		
        /* Update status */
        if($disposition == 'OK TO USE' || $disposition == 'USE AS IS') {
            $new_disposition_status = 'WITH TREATMENT ('.$disposition.')';
        } else {
            $new_disposition_status = $disposition_status;
        }
		$table 			= 'tbl_qfr_ng';
		$array_fields 	= array('status','lastupdate', 'username');
		$array_values 	= array($new_disposition_status,$date_time_today, $username);
		$update_query 	= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$fkng);
        
            
        $return['target_dir']  = $target_dir;
        $return['POST']  = $_POST;
        $return['msg']  = $msg;
        $return['script']  = $script;
        echo json_encode($return);
	}

	function add_treatment_migz() {
		require_once('../class/oop_tqts.php');
        $date_time_today        = date('Y-m-d H:i:s');	
        $fkng                   = $_POST['fkng'];
        $disposition            = $_POST['disposition'];
        $disposition_by         = $_POST['disposition_by'];
        $disposition_date       = $_POST['disposition_date'];
        $disposition_time       = $_POST['disposition_time'];
        $disposition_remarks    = $_POST['disposition_remarks'];
        $final_reply_status     = $_POST['final_reply_status'];
        $final_reply_date       = $_POST['final_reply_date'];
        $final_reply_time       = $_POST['final_reply_time'];
        $final_reply_remarks    = $_POST['final_reply_remarks'];
        $disposition_status     = $_POST['disposition_status'];
        $username               = $_POST['username'];
        $msg               		= '';
        $disposition_file_name = array();
        /* Upload the disposition */
        if($disposition_status == 'WITH TREATMENT') {
			echo 'WITH TREATMENT';
			return;
			if(isset($_FILES['treatment_file']["name"])) {
				for($i=0; $i<count($_FILES['treatment_file']['name']); $i++) {
					$temp_file 	     = $_FILES["treatment_file"]["tmp_name"][$i];
					$file_name 	     = $_FILES["treatment_file"]["name"][$i];
					$file  		     = return_file_path_by_div_mod('ng_disposition');
					$fkfile_path     = $file['pkid'];
					$target_dir      = $file['path'].$fkng."_1/";
					if(!file_exists($target_dir)){
						mkdir($target_dir.'/', 0777);
					}
					$target_file     		 = $target_dir . $file_name;
					$disposition_file_name[] = $file_name;
					if (file_exists($target_file)) {
						$msg = "Sorry, your file already exists.";
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {
							$msg .= '<br>File was successfully uploaded to the system ->'.$file_name;				
						} else {
							$msg .= "Sorry, there was an error uploading your file.";
						}
					}
				}
				$disposition_file_name = implode(',',$disposition_file_name);
				$table 			= 'tbl_qfr_ng_treatment';
				$array_fields 	= array('disposition_file_name','fkfile_path','lastupdate', 'username');
				$array_values 	= array($disposition_file_name,$fkfile_path,$date_time_today, $username);
				$sql_where      = 'WHERE fkng='.$fkng.' AND logdel=0';
				$msg 		    = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
				
				//novs
				/* Stop daily email notification alert on "Follow-up" */
				require_once('../class/oop_mailer2.php');
				$table_mailer 			= 'tbl_auto_mailer';
				$array_fields_mailer 	= array('logdel');
				$array_values_mailer 	= array('1');
				$sql_where_mailer		= 'WHERE fkid="'.$fkng.'" AND db_name="db_tqts_ts" AND tbl_name="tbl_qfr_ng" AND system_name="TQTS"';
				$msg_mailer 			= MAILER2::getInstance()->update_query_detailed($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				$script 			   .= MAILER2::getInstance()->update_query_detailed_script($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				//-/novs
			}
        } else if($disposition_status == 'WITH FINAL REPLY') {
			echo 'WITH FINAL REPLY';
			return;
			if(isset($_FILES['final_reply_file'])) {
				$final_reply_file_name = array();
				for($i=0; $i<count($_FILES['final_reply_file']['name']); $i++) {
					$temp_file 	     = $_FILES["final_reply_file"]["tmp_name"][$i];
					$file_name 	     = $_FILES["final_reply_file"]["name"][$i];
					$file  		     = return_file_path_by_div_mod('ng_disposition');
					$fkfile_path     = $file['pkid'];
					$target_dir      = $file['path'];
					$target_dir      = $file['path'].$fkng."_2/";
					if(!file_exists($target_dir)){
						mkdir($target_dir.'/', 0777);
					}
					$target_file     		 = $target_dir . $file_name;
					$final_reply_file_name[] = $file_name;
					if (file_exists($target_file)) {
						$msg = "Sorry, your file already exists.";
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {
							/* Rename the file based on pkid of Quality Report */					
							$msg .= 'File was successfully uploaded to the system ->'.$file_name;							
						} else {
							$msg .= "Sorry, there was an error uploading your file.";
						}
					}
				}
				$final_reply_file_name = implode(',',$final_reply_file_name);
				$table 			= 'tbl_qfr_ng_treatment';
				$array_fields 	= array('final_reply_file_name','fkfile_path','lastupdate', 'username');
				$array_values 	= array($final_reply_file_name,$fkfile_path,$date_time_today, $username);
				$sql_where      = 'WHERE fkng='.$fkng.' AND logdel=0';
				$msg 		    = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);

				//novs
				/* Stop daily email notification alert on "Follow-up" */
				require_once('../class/oop_mailer2.php');
				$table_mailer 			= 'tbl_auto_mailer';
				$array_fields_mailer 	= array('logdel');
				$array_values_mailer 	= array('1');
				$sql_where_mailer		= 'WHERE fkid="'.$fkng.'" AND db_name="db_tqts_ts" AND tbl_name="tbl_qfr_ng" AND system_name="TQTS"';
				$msg_mailer 			= MAILER2::getInstance()->update_query_detailed($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				$script 			   .= MAILER2::getInstance()->update_query_detailed_script($table_mailer,$array_fields_mailer,$array_values_mailer,$sql_where_mailer);
				//-/novs
			}
        }
        echo 'labas';
		return;
        /* Update disposition */ //disposition_file_name
        $table 			= 'tbl_qfr_ng_treatment';
		$array_fields 	= array('disposition', 'disposition_by', 'disposition_date','disposition_time','disposition_remarks','final_reply_status', 'final_reply_date', 'final_reply_time', 'final_reply_remarks','lastupdate', 'username');
		$array_values 	= array($disposition,$disposition_by,$disposition_date,$disposition_time,$disposition_remarks,$final_reply_status,$final_reply_date,$final_reply_time,$final_reply_remarks,$date_time_today, $username);
        $sql_where      = 'WHERE fkng='.$fkng.' AND logdel=0';
		$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$sql_where);
		
        /* Update status */
        if($disposition == 'OK TO USE' || $disposition == 'USE AS IS') {
            $new_disposition_status = 'WITH TREATMENT ('.$disposition.')';
        } else {
            $new_disposition_status = $disposition_status;
        }
		$table 			= 'tbl_qfr_ng';
		$array_fields 	= array('status','lastupdate', 'username');
		$array_values 	= array($new_disposition_status,$date_time_today, $username);
		$update_query 	= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$fkng);
        
            
        $return['target_dir']  = $target_dir;
        $return['POST']  = $_POST;
        $return['msg']  = $msg;
        $return['script']  = $script;
        echo json_encode($return);
	}
	
	function validate_is_approver() {
		require_once('../class/oop_tqts.php');
		$return 	= array();
		$return 	= $_POST;
		$array_fields = array('pkid');
		$table 	   	= 'tbl_qfr_ng_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkng`="'.$_POST['fkng'].'" AND status="PENDING" AND `approver_username`="'.$_POST['username'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['is_approver'] = $result->num_rows;
		echo json_encode($return);
	}
	
	function cancel_ng() {
		require_once('../class/oop_tqts.php');
		$return 		= array();
		$date_time_today = date('Y-m-d H:i:s');
		$pkid  			= $_POST['pkid'];
		$remarks		= '';
		$array_fields 	= array('remarks');
		$table 	   		= 'tbl_qfr_ng';
		$joins 	   		= '';
		$sql_where 		= 'WHERE `pkid`="'.$pkid.'" AND logdel="0"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$remarks = $row['remarks'];
		}
		$remarks	   .= '<br> <b>Cancellation Remarks: </b>'.$_POST['remarks'];
		$array_fields 	= array('status','remarks','lastupdate', 'username');
		$array_values 	= array('CANCELLED',$remarks, $date_time_today,$_POST['username']);
		$msg			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		
		/* Update transaction table */
		$table 	   		= 'tbl_qfr_ng_approvers';
		$array_fields 	= array('status','lastupdate', 'username');
		$array_values 	= array('CANCELLED',$date_time_today,$_POST['username']);
		$sql_where		= "WHERE fkng = ".$pkid." AND username='".$_POST['username']."' AND logdel=0";
		$msg			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		
		$return['msg'] 	= $msg;
		echo json_encode($return);
	}
	
	function get_email_recipients_by_category() {
        require_once('../class/oop_tqts.php');
        $category_code = $_POST['qfr_category'];
		$array_fields = array('to_recipient','cc_recipient');
		$table 	   	= 'tbl_quality_report_category';
		$joins 	   	= '';
		$sql_where 	= 'WHERE category_code="'.$category_code.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			$return['to'] = $row['to_recipient'];
			$return['cc'] = $row['cc_recipient'];
			
			$array_to	 	= explode(",",$row['to_recipient']);
			$return['to']	= array();
			foreach($array_to as $key => $value){
				$array_data_to 				= array();
				$array_data_to['id'] 		= $value;
				$array_data_to['text'] 		= get_emp_name_by_email_add_systemone($value);
				$return['to'][]				= $array_data_to;
			}
			$array_cc	 	= explode(",",$row['cc_recipient']);
			$return['cc']	= array();
			foreach($array_cc as $key => $value){
				$array_data_cc				= array();
				$array_data_cc['id'] 		= $value;
				$array_data_cc['text'] 		= get_emp_name_by_email_add_systemone($value);
				$return['cc'][]				= $array_data_cc;
			}
		}
		echo json_encode($return);
    }
	
	function get_supplier_by_pkid() {
        require_once('../class/oop_tqts.php');
        $pkid 		= $_POST['pkid'];
		$array_fields = array('supplier');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			$array_supp	 		= explode(",",$row['supplier']);
			$return['supplier']	= array();
			foreach($array_supp as $key => $value){
				$array_data_supp 			= array();
				$array_data_supp['id'] 		= $value;
				$array_data_supp['text'] 	= $value;
				$return['supplier'][]		= $array_data_supp;
			}
			$return['supplier_name'] = $row['supplier'];
		}
		echo json_encode($return);
    }
	
	function view_ng_attachments() {
        require_once('../class/oop_tqts.php');
        $fkng 		= $_POST['fkng'];
		$table_body = '';
		/* Report attachments */
		$array_fields = array('file_name');
		$table 	   	= 'tbl_qfr_ng';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fkng.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			$file_names  = explode(' | ', $row['file_name']);
			$table_body .= '<tr>';
			$table_body .= '	<td>NG Report Attachment/s (No e-signature)</td>';
			$table_body .= '</tr>';
			for($i=0; $i<count($file_names); $i++) {
				$table_body .= '<tr>';
				$table_body .= '	<td><a href="#" class="fa fa-paperclip" id="'.$fkng.'_'.($i+1).'" folder="new" style="display:inline-block;"> '.$file_names[$i].'</a></td>';
				$table_body .= '</tr>';
			}
		}
		
		/* Disposition attachments */
		$array_fields = array('disposition_file_name','final_reply_file_name');
		$table 	   	= 'tbl_qfr_ng_treatment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkng="'.$fkng.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			if($row['disposition_file_name'] != '') {
				$table_body .= '<tr>';
				$table_body .= '	<td>Disposition Attachment/s</td>';
				$table_body .= '</tr>';
				$diposition = explode(',',$row['disposition_file_name']);
				for($i=0; $i<count($diposition); $i++) {					
					$table_body .= '<tr>';
					$table_body .= '	<td><a href="#" class="fa fa-paperclip" id="'.$fkng.'" folder="'.$fkng.'_1" style="display:inline-block;"> '.$diposition[$i].'</a></td>';
					$table_body .= '</tr>';
				}
			}
			if($row['final_reply_file_name'] != '') {
				$table_body .= '<tr>';
				$table_body .= '	<td>Final Reply Attachment/s</td>';
				$table_body .= '</tr>';
				$final_reply = explode(',',$row['final_reply_file_name']);
				for($i=0; $i<count($final_reply); $i++) {					
					$table_body .= '<tr>';
					$table_body .= '	<td><a href="#" class="fa fa-paperclip" id="'.$fkng.'" folder="'.$fkng.'_2" style="display:inline-block;"> '.$final_reply[$i].'</a></td>';
					$table_body .= '</tr>';
				}
			}
		}
		$return['table_body'] = $table_body;
		echo json_encode($return);
    }

	function get_supplier_ng_email_address() {
		require_once('../class/oop_tqts.php');
		$supplier 		= $_POST['supplier'];
		$field_name 	= $_POST['field_name'];
		$array_fields = array($field_name);
		$table 	   	= 'tbl_supplier';
		$joins 	   	= '';
		$sql_where 	= 'WHERE supplier="'.$supplier.'" AND fksupplier_group != 0 OR category = "NGR" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$html_select= '';
		$result = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			
			// echo $row['recipients_to'];
			$array_email_add = explode(',',$row[$field_name]);
			$return['email_add'] = array();
			foreach($array_email_add as $key => $value){
				$array_data_email 				= array();
				$array_data_email['id'] 		= $value;
				$array_data_email['text'] 		= $value;
				$return['email_add'][]			= $array_data_email;
			}
		} 
		else {
			$return['email_add'] = '';
			$return['script'] = '';
		}
		echo json_encode($return);
	}
	
	
	?>