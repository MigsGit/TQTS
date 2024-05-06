<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
				/* AYE Report */
				case "generate_new_aye_control_no"				: generate_new_aye_control_no(); break;
				case "save_aye_report"							: save_aye_report(); break;
				case "load_aye_report_record"					: load_aye_report_record(); break;
				case "update_aye_report"						: update_aye_report(); break;
				case "upload_aye_judgement"						: upload_aye_judgement(); break;
				case "add_aye_judgement"						: add_aye_judgement(); break;
				case "save_aye_lot_numbers"						: save_aye_lot_numbers(); break;
				case "get_lot_number_by_fkaye"					: get_lot_number_by_fkaye(); break;
				
				case "qfr_return_aye_fields"					: qfr_return_aye_fields(); break;
				case "aye_advance_search"						: aye_advance_search(); break;
				
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* AYE Report Start */
	
	function generate_new_aye_control_no() {
		require_once('../class/oop_tqts.php');
		$username	= $_POST['username'];
		$section 	= get_assigned_section_aye($username);
		$array_fields = array('control_no');
		$table 	   	= 'tbl_qfr_aye';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= 'LIMIT 0,1';
		$control_no= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows==0) {
			$control_no = 'AYE-QI-'.$section.'-'.date('my').'-001';
		} else {
			if($row = mysqli_fetch_array($result)) {
				$control_no = $row['control_no'];
				$control_no = $row['control_no'];
				$ctr 		 = end(explode('-',$control_no));
				if($ctr < 10) {
					$series = '-00'. ($ctr+1);
				} else {
					$series = '-'. ($ctr+1);
				} 
			}		
			$control_no = 'AYE-QI-'.$section.'-'.date('my').$series;
		}
		$return['control_no'] = $control_no;
		echo json_encode($return);
	}
	
	function save_aye_report(){
		require_once('../class/oop_tqts.php');
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$date_time_today 		= date('Y-m-d H:i:s');
		$date_today 			= date('Y-m-d');
		$illustration_name	 	= $_FILES['file_aye']['name'];
		$illustration_name_temp	= $_FILES['file_aye']['tmp_name'];
		$extension  			= pathinfo($illustration_name, PATHINFO_EXTENSION);
		$directory_path 		= return_file_path_by_div_mod('aye_illustration');
		$return 				= $_POST;
				
		$issuance_no = get_new_aye_control_no();
		$table			= 'tbl_qfr_aye';
		$array_fields 	= array(
								'date_time_created', 'created_by', 'status', 'control_no', 'category', 'parts_affected_parts', 'part_code', 
								'sample_size', 'percent_ng', 'date_issued', 
								'device_name', 'po_number', 'po_qty', 'customer_name', 'shipment_date', 
								'remarks','illustration_name', 'illustration_fkfile_path', 'lastupdate', 'username'
								);
		$array_values	= array(
								$date_time_today,$return['username'],'NO JUDGEMENT', $issuance_no,$return['category'],$return['parts_affected_parts'],$return['partcode'],
								$return['sample_size'],$return['percent_ng'],$date_today,
								$return['device_name'],$return['po_number'],$return['po_qty'],$return['customer_name'],$return['shipment_date'],
								$return['remarks'],$illustration_name,$directory_path['pkid'],$date_time_today,$return['username']
								);
		$pkid 					= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$return['pkid']			= $pkid;
		$file_name				= $directory_path['path'].$pkid.'.'.$extension;
		if (file_exists($file_name)) {
			$msg = "Sorry, your file already exists.";
		} else {
			if (move_uploaded_file($illustration_name_temp,$file_name)) {
				/* Rename the file based on pkid of Quality Report */					
				$msg = 'File was successfully uploaded and saved to the system';				
			} else {
				$msg = "Sorry, there was an error uploading your file.";
			}
		}
		$return['msg'] = $msg;		
		echo json_encode($return);
	}
	
	function get_assigned_section_aye($username) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('section');
		$table 	   	= 'vw_user_roles';
		$joins 	   	= '';
		$sql_where 	= 'WHERE subsystem_code="QFR" AND module="AYE Report" AND `user`="'.$username.'"';
		$sql_order 	= 'ORDER BY section';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			return $row['section'];
		} else {
			return 'N/A';
		}
	}
	
	function get_new_aye_control_no() {
		require_once('../class/oop_tqts.php');
		$username	= $_POST['username'];
		$section 	= get_assigned_section_aye($username);
		$array_fields = array('control_no');
		$table 	   	= 'tbl_qfr_aye';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= 'LIMIT 0,1';
		$control_no= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows==0) {
			$control_no = 'AYE-QI-'.$section.'-'.date('my').'-001';
		} else {
			if($row = mysqli_fetch_array($result)) {
				$control_no = $row['control_no'];
				$control_no = $row['control_no'];
				$ctr 		 = end(explode('-',$control_no));
				if($ctr < 10) {
					$series = '-00'. ($ctr+1);
				} else {
					$series = '-'. ($ctr+1);
				} 
			}		
			$control_no = 'AYE-QI-'.$section.'-'.date('my').$series;
		}
		return $control_no;
	}
	
	function load_aye_report_record() {
		require_once('../class/oop_tqts.php');
		$pkid 			= $_POST['pkid'];
		$array_fields 	= array('status', 'control_no', 'category', 'parts_affected_parts', 'part_code', 'sample_size', 
							'percent_ng', 'date_issued', 'device_name', 'po_number', 'po_qty', 'customer_name', 'shipment_date', 'remarks', 'illustration_name', 'illustration_fkfile_path', 
							'aye_judgement', 'judgement_date', 'judgement_remarks', 'judgement_file', 'judgement_fkfile_path',
							'(SELECT fp.`file_path` FROM `tbl_file_path` fp WHERE fp.`pkid`=tbl_qfr_aye.illustration_fkfile_path LIMIT 0,1) as file_path',
							'(SELECT SUM(fln.quantity) FROM tbl_qfr_aye_lot_numbers fln WHERE fln.fk_aye = tbl_qfr_aye.pkid AND logdel=0) as quantity');
		$table      	= 'tbl_qfr_aye';
		$joins      	= '';
		$sql_where  	= 'WHERE `pkid`="'.$pkid.'" AND logdel=0';
		$sql_order  	= '';
		$sql_limit  	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_array($result)){
			$return['status'] 				= $row['status'];
			$return['control_no'] 			= $row['control_no'];
			$return['category'] 			= $row['category'];
			$return['parts_affected_parts'] = $row['parts_affected_parts'];
			$return['part_code'] 			= $row['part_code'];
			$return['quantity'] 			= number_format($row['quantity'],4);
			$return['sample_size'] 			= $row['sample_size'];
			$return['percent_ng'] 			= $row['percent_ng'];
			$return['date_issued'] 			= $row['date_issued'];
			$return['device_name'] 			= $row['device_name'];
			$return['po_number'] 			= $row['po_number'];
			$return['po_qty'] 				= $row['po_qty'];
			$return['customer_name'] 		= $row['customer_name'];
			$return['shipment_date'] 		= $row['shipment_date'];
			$return['remarks'] 				= $row['remarks'];
			$return['illustration_name'] 	= $row['illustration_name'];
			$return['illustration_fkfile_path'] 	= $row['illustration_fkfile_path'];
			$return['aye_judgement'] 		= $row['aye_judgement'];
			$return['judgement_date'] 		= $row['judgement_date'];
			$return['judgement_remarks'] 	= $row['judgement_remarks'];
			$return['judgement_file'] 		= $row['judgement_file'];
			$return['judgement_fkfile_path']= $row['judgement_fkfile_path'];
			$file_path						= $row['file_path'];
			$extension  					= pathinfo($return['illustration_name'], PATHINFO_EXTENSION);
			$return['file_path'] 			= str_replace('../','',$file_path.$pkid.'.'.$extension);
		
		}
		echo json_encode($return);
	}
	
	function update_aye_report() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$return			= $_POST;
		$pkid			= $return['pkid'];
		$table			= "tbl_qfr_aye";
		$msg			= "";
		
		$array_fields 	= array(
							'category', 'parts_affected_parts', 'part_code', 'sample_size', 'percent_ng', 
							'date_issued', 'device_name', 'po_number', 'po_qty', 'customer_name', 'shipment_date', 'remarks','lastupdate','username'
						);
		
		$array_values 	= array(
							$return['category'],$return['parts_affected_parts'],$return['partcode'],
							$return['sample_size'],$return['percent_ng'],$return['date_issued'],$return['device_name'],$return['po_number'],$return['po_qty'],
							$return['customer_name'],$return['shipment_date'],$return['remarks'],$date_time_today,$return['username']
						);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
				
		if(isset($_FILES['file_aye']['tmp_name'])) {
			$illustration_name_temp	= $_FILES['file_aye']['tmp_name'];
			$illustration_name	 	= $_FILES['file_aye']['name'];
			$extension  			= pathinfo($illustration_name, PATHINFO_EXTENSION);
			$directory_path 		= return_file_path_by_div_mod('aye_illustration');
			$file_name				= $directory_path['path'].$pkid.'.'.$extension;
			if (move_uploaded_file($illustration_name_temp,$file_name)) {
				/* Rename the file based on pkid of Quality Report */					
				$msg = 'Record and file was successfully updated to the system';				
			} else {
				$msg = "Sorry, there was an error uploading your file.";
			}
		}
		
		$return 			= array();
		$return['script'] 	= $script;
		$return['pkid'] 	= $pkid;
		$return['msg'] 		= $msg;
		echo json_encode($return);		
	}
	
	function upload_aye_judgement() {
		$return 		= $_POST;
		$pkid			= $_POST['pkid'];
		$control_number	= $_POST['control_number'];
		$temp_file		= $_FILES['judgement_file']['tmp_name'];
		$file_name		= $_FILES['judgement_file']['name'];
		$ext			= pathinfo($file_name, PATHINFO_EXTENSION);
		$file = return_file_path_by_div_mod('aye_judgement');
		if(move_uploaded_file($temp_file,$file['path'].$pkid.'.'.$ext)) {
			/* Read judgement on excel */
			require_once( '../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
			require_once( '../../media/PHPExcel-1.8/Classes/PHPExcel.php');
			$inputFileName = $file['path'].$pkid.'.'.$ext;
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				$sheet = $objPHPExcel->getSheet(0);
				/* get judgement application */
				$return['control_num'] = $objPHPExcel->getActiveSheet()->getCell('D2')->getValue();
				$return['judgement']   = $objPHPExcel->getActiveSheet()->getCell('N9')->getValue();
				$return['j_date'] 	   = $objPHPExcel->getActiveSheet()->getCell('N10')->getValue() == '' ? '' : date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('N10')->getValue()));
				$return['remarks'] 	   = $objPHPExcel->getActiveSheet()->getCell('N11')->getValue();
				if($control_number != trim($return['control_num'])) {
					$msg = 'Incorrect file uploaded. Control number did not match.';
					/* Delete the file uploaded. */
					unlink($inputFileName);
				} else {
					$fkfile_path     = $file['pkid'];
					$msg = 'File was successfully uploaded to the system';
					$table			= "tbl_qfr_aye";
					$array_fields 	= array('judgement_file','judgement_fkfile_path');		
					$array_values 	= array($file_name,$fkfile_path);
					$result 		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
				}
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
		} else {
			$msg = "Sorry, there was an error uploading your file.";
		}
		$return['msg']		 = $msg;
		echo json_encode($return);
	}
	
	function add_aye_judgement() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$return			= $_POST;
		$pkid			= $return['pkid'];
		$username		= $return['username'];
		$table			= "tbl_qfr_aye";
		
		$array_fields 	= array('status', 'aye_judgement', 'judgement_date', 'judgement_remarks','lastupdate', 'username');		
		$array_values 	= array('WITH JUDGEMENT',$return['aye_judgement'],$return['judgement_date'],$return['judgement_remarks'],$date_time_today,$username);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$return 		= array();
		$return['msg']  = $msg;
		$return['script'] = $script;
		echo json_encode($return);		
	}
	
	function save_aye_lot_numbers() {
		require_once('../class/oop_tqts.php');
		$fk_aye 		= $_POST['fk_aye'];
		$pkid 			= $_POST['pkid'];
		$lot_number 	= $_POST['lot_number'];
		$quantity 		= $_POST['quantity'];
		$username 		= $_POST['username'];
		$msg 			= '';
		$date_time_today = date('Y-m-d H:i:s');
		$table			= "tbl_qfr_aye_lot_numbers";
		$script 		= '';
		//set all logdel to 1 first
		$array_fields 	= array('logdel', 'lastupdate', 'username');		
		$array_values 	= array(1,$date_time_today,$username);
		$where		 	= 'WHERE fk_aye='.$fk_aye.' AND logdel=0';
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		
		for($i=0; $i<count($lot_number); $i++) {
			if($pkid[$i] == 0) {
				$array_fields 	= array('date_time_created', 'created_by', 'fk_aye', 'lot_number', 'quantity', 'lastupdate', 'username');		
				$array_values 	= array($date_time_today,$username,$fk_aye,$lot_number[$i],$quantity[$i],$date_time_today,$username);
				$msg 			= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
				$script 	   .= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
			} else {
				$array_fields 	= array('lot_number', 'quantity', 'lastupdate', 'username', 'logdel');		
				$array_values 	= array($lot_number[$i],$quantity[$i],$date_time_today,$username, '0');
				$where		 	= 'WHERE pkid='.$pkid[$i].' AND fk_aye='.$fk_aye.' AND logdel=1';
				$msg 			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
				$script 		.= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
			}
		}
		$return 			= array();
		$return['msg'] 		= $msg;
		$return['script'] 	= $script;
		echo json_encode($return);		
	}
	
	function get_lot_number_by_fkaye() {
		require_once('../class/oop_tqts.php');
		$fk_aye		= $_POST['fk_aye'];
		$array_fields = array('pkid','lot_number','quantity');
		$table 	   	= 'tbl_qfr_aye_lot_numbers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fk_aye="'.$fk_aye.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$ctr		= 0;
		$table_body_edit	= '';
		$table_body_view	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row=mysqli_fetch_array($result)) {
			$table_body_edit .= '<tr>';
			$table_body_edit .= '	<td>'.$row['lot_number'].'</td>';
			$table_body_edit .= '	<td>'.$row['quantity'].'</td>';
			$table_body_edit .= '	<td><a href="#" class="fa fa-remove"> Remove</a></td>';
			$table_body_edit .= '	<td style="display:none">'.$row['pkid'].'</td>';
			$table_body_edit .= '</tr>';
			
			$table_body_view .= '<tr>';
			$table_body_view .= '	<td>'.$row['lot_number'].'</td>';
			$table_body_view .= '	<td>'.$row['quantity'].'</td>';
			$table_body_view .= '</tr>';
		} 
		$return['table_body_edit'] = $table_body_edit;
		$return['table_body_view'] = $table_body_view;
		echo json_encode($return);
	}
	
	function qfr_return_aye_fields(){
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="control_no">Control Number</option>'; $ctr++;
		$option[$ctr] = '<option value="category">Category</option>'; $ctr++;
		$option[$ctr] = '<option value="parts_affected_parts">PARTS - Affected Parts</option>'; $ctr++;
		$option[$ctr] = '<option value="part_code">Partcode</option>'; $ctr++;
		$option[$ctr] = '<option value="lot_number">Lot #</option>'; $ctr++;
		$option[$ctr] = '<option value="quantity">Quantity</option>'; $ctr++;
		$option[$ctr] = '<option value="sample_size">Sample Size</option>'; $ctr++;
		$option[$ctr] = '<option value="percent_ng">Percent NG</option>'; $ctr++;
		$option[$ctr] = '<option value="date_issued">Date Issued</option>'; $ctr++;		
		$option[$ctr] = '<option value="device_name">Device Name</option>'; $ctr++; $ctr++;
		$option[$ctr] = '<option value="po_number">PO Number</option>'; $ctr++;
		$option[$ctr] = '<option value="po_qty">PO Quantity</option>'; $ctr++;
		$option[$ctr] = '<option value="customer_name">Customer Name</option>'; $ctr++;
		$option[$ctr] = '<option value="shipment_date">Shipment Date</option>'; $ctr++;
		$option[$ctr] = '<option value="aye_judgement">AYE Judgement</option>'; $ctr++;
		$option[$ctr] = '<option value="judgement_date">Judgement Date</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	function aye_advance_search() {
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
		
		$result['post_value'] = $_POST;
		$result['sql_where'] = $sql_where;
		echo json_encode($result);
	}
	/* AYE Report End */
	
	
	?>