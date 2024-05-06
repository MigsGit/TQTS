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
				case "upload_oqc_dir"							: upload_oqc_dir(); break;
				case "save_oqc_dir"								: save_oqc_dir(); break;
				case "get_oqc_dir_details"						: get_oqc_dir_details(); break;
				case "reupload_oqc_dir"							: reupload_oqc_dir(); break;
				case "edit_oqc_dir"								: edit_oqc_dir(); break;
				case "cancel_oqc_dir"							: cancel_oqc_dir(); break;
				/* Advanced Search */
				case "oqc_dir_return_dir_fields"				: oqc_dir_return_dir_fields(); break;
				case "oqc_dir_advance_search"					: oqc_dir_advance_search(); break;
				
				/* QCFR */
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
	
	/* OQC Dimension Inspection Result DIR - START */
	
	function upload_oqc_dir(){
		$return = $_POST;
		$return['error'] 						= array();
		$input_file_name 						= $_FILES['file_oqc_dir']['tmp_name'];
		$original_file_name	 					= $_FILES['file_oqc_dir']['name'];
		$ext 									= pathinfo($original_file_name, PATHINFO_EXTENSION);
		$return['ext']							= $ext;
		$array_valid_ext 						= array("xls","xlsx");	
		if(!in_array($ext,$array_valid_ext)){
			$return['error'][]					= "Incorrect file uploaded!";
		}
		if(count($return['error']) == 0){
			copy($input_file_name,'../uploaded_file/temp/oqc/dir/'.$original_file_name);
			$excel_data 							= get_excel_content($input_file_name,100);
			$return['excel_data'] 					= $excel_data;
			$return['data']['po_number']			= remove_specific_array_string_pattern($excel_data['B4'],array("ï¼",':',' '));
			if(trim($return['data']['po_number']) == ''){
				$return['data']['po_number'] 		= search_excel_fields($excel_data,'A','P.O. No.');
			}
			$return['data']['shipment_date']		= remove_specific_array_string_pattern($excel_data['B6'],array("ï¼",':',' '));
			if(trim($return['data']['shipment_date']) == ''){
				$return['data']['shipment_date'] 	= search_excel_fields($excel_data,'A','Date');
			}
			$return['data']['shipment_date'] = date( 'm/d/Y', strtotime($return['data']['shipment_date']) );
			if( $return['data']['shipment_date'] == '01/01/1970'){
				$return['data']['shipment_date'] = 'Invalid Date';
			}
			$return['customer'] 					= remove_specific_array_string_pattern($excel_data['B2'],array("ï¼",':',' '));
			$ypics_data 							= get_series_name($return['data']['po_number']);
			$return['data']['series_name']			= $ypics_data['device_name'];
			$return['data']['customer']				= $ypics_data['customer'];
			$return['original_file_name'] 			= $original_file_name;
			if(file_exists($input_file_name)){
				/* move the file to the temp directory */
				move_uploaded_file($input_file_name,'../uploaded_file/temp/oqc/dir/'.$original_file_name);
			}
		}
		echo json_encode($return);
	}
	
	function search_excel_fields($excel_data,$col,$field){
		$col_row_location = 0;
		for($ctr = 1; $ctr < 20; $ctr++){
			if($excel_data[$col.$ctr] == $field){
				$col++;
				return remove_specific_array_string_pattern($excel_data[$col.$ctr],array("ï¼",':',' '));
			}
		}
		return 'Cannot find '.$field.' in excel..';
	}
	
	function save_oqc_dir(){
		require_once('../class/oop_tqts.php');
		$return 						= $_POST;
		$return['error']				= array();
		$po_number 						= $_POST["po_number"];
		/* check if oqc dir data is already a duplicate copy */
		$table  						= "tbl_oqc_dir";
		$array_fields					= array("po_number");
		$joins  	 					= "";
		$sql_where  					= "WHERE `po_number` = '$po_number' and `logdel` = '0'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['existing_data'] 		= false;
		while($row = mysqli_fetch_assoc($result)){
			$return['existing_data'] = true;
		}
		if($return['existing_data']){
			// $return['error'][] = "This PO already exist!";
		}
		if( $_POST['shipment_date'] == "Invalid Date" ){
			$return['error'][] = "Warning Invalid Date Format! Please enter it manualy if the system cannot format the given date.";
		}else{
			$_POST['shipment_date'] = date('Y-m-d',strtotime($_POST['shipment_date']));
		}
		if( count($return['error']) > 0 ){
			echo json_encode($return);
			exit;
		}
		$values 					= get_fields_values($_POST,array("action","username","file"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$fk_file_path 				= return_file_path_by_div_mod('oqc_dimension');
		$array_fields[]				= 'filename'; $array_values[] = str_replace('C:\fakepath\\',"",$_POST['file']);
		$array_fields[]				= 'fk_file_path'; $array_values[] = $fk_file_path['pkid'];
		$pk_file_uploaded 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script			 			= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		$return['last_id']			= $pk_file_uploaded;
		$return['script']			= $script;
		$filename 					= str_replace('C:\fakepath\\',"",$_POST['file']);
		$path_to_file = '../uploaded_file/temp/oqc/dir/'.$filename;
		$return['test'] = $path_to_file;
		/* save uploaded file details */
		if(file_exists($path_to_file)){
			$file_path 	= return_file_path_by_div_mod('oqc_dimension');
			$ext 		= pathinfo($path_to_file, PATHINFO_EXTENSION);
			rename($path_to_file, $file_path['path'].$pk_file_uploaded.'.'.$ext);
			$return['file_moved'] = $file_path['path'].$pk_file_uploaded.'.'.$ext;
		}else{
			$return['file_moved'] = false;
		}
		echo json_encode($return);
	}
	
	function get_oqc_dir_details(){
		require_once('../class/oop_tqts.php');
		$return 						= $_POST;
		$return['error']				= array();
		$id 							= $_POST["id"];
		$table  						= "tbl_oqc_dir";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$id'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$return['data']	= $row;
            $return['data']['shipment_date'] = date('m/d/Y',strtotime($row['shipment_date']));
		}
		echo json_encode($return);
	}
	
	function reupload_oqc_dir(){
		$return = $_POST;
		$return['error'] 						= array();
		$input_file_name 						= $_FILES['file_oqc_dir']['tmp_name'];
		$original_file_name	 					= $_FILES['file_oqc_dir']['name'];
		$ext 									= pathinfo($original_file_name, PATHINFO_EXTENSION);
		$return['ext']							= $ext;
		$array_valid_ext 						= array("xls","xlsx");	
		if(!in_array($ext,$array_valid_ext)){
			$return['error'][]					= "Incorrect file uploaded!";
		}
		if(count($return['error']) == 0){
			$excel_data 							= get_excel_content($input_file_name,100);
			$return['excel_data'] 					= $excel_data;
			$return['data']['po_number']			= remove_specific_string_pattern($excel_data['B4'],"ï¼");
			$return['shipment_date']				= remove_specific_string_pattern($excel_data['B6'],"ï¼");
			$return['shipment_date']				= explode(" ",$return['shipment_date']);
			if(count($return['shipment_date'] < 13)){
				$return['data']['shipment_date']		= "Invalid Date Format";
			}else{
				$return['data']['shipment_date']		= $return['shipment_date'][1].'-'.$return['shipment_date'][7].'-'.$return['shipment_date'][13];
			}
			$return['customer'] 					= remove_specific_string_pattern($excel_data['B2'],"ï¼");
			$ypics_data 							= get_series_name($return['data']['po_number']);
			$return['data']['series_name']			= $ypics_data['device_name'];
			$return['data']['customer']				= $ypics_data['customer'];
			$return['original_file_name'] 			= $original_file_name;
			if(file_exists($input_file_name)){
				$temp_dir = '../uploaded_file/temp/oqc/dir/';
				if(!file_exists($temp_dir)){
					mkdir($temp_dir,0777);
				}
				/* move the file to the temp directory */
				move_uploaded_file($input_file_name,$temp_dir.$original_file_name);
			}
		}
		echo json_encode($return);
	}
	
	function edit_oqc_dir(){
		require_once('../class/oop_tqts.php');
		/* check if the newly uploaded file has the same P.O. */
		$return 						= $_POST;
		$return['error']				= array();
		$id 							= $_POST["id"];
		$table  						= "tbl_oqc_dir";
		$array_fields					= array("po_number");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$id'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['script'] 				= $script;
		$return['data']['po_number']	= "";
		while($row = mysqli_fetch_assoc($result)){
			$return['data']['po_number']	= $row['po_number'];
		}
		if($return['data']['po_number'] != $_POST['po_number']){
			$return['error'][] = 'PO Number is different from the Original PO';
		}
		if(count($return['error']) != 0){
			echo json_encode($return);
			exit;
		}
		/* Update OQC Dir Data */
		$table 							= "tbl_oqc_dir";
		$values 						= get_fields_values($_POST,array("action","username","file","id"));
		$array_fields 					= $values["array_fields"];
		$array_values 					= $values["array_values"];
		$result 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$id);
		$script 						= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$id);
		$return['script'] 				= $script;
		$return['values']				= $values;
		
		$filename 						= str_replace('C:\fakepath\\',"",$_POST['file']);
		/* overwrite uploaded file */
		$path_to_file = '../uploaded_file/temp/oqc/dir/'.$filename;
		if(file_exists($path_to_file)){
			$file_path 	= return_file_path_by_div_mod('oqc_dimension');
			$ext 		= pathinfo($path_to_file, PATHINFO_EXTENSION);
			rename($path_to_file, $file_path['path'].$id.'.'.$ext);
			$return['file_moved'] = $file_path['path'].$id.'.'.$ext;
		}else{
			$return['file_moved']   = false;
			$return['error'] 		= "Something went wrong during file upload, please re-upload the file.";
		}
		echo json_encode($return);
	}
	
	function cancel_oqc_dir(){
		require_once('../class/oop_tqts.php');
		$return 						= $_POST;
		/* Update OQC Dir Data */
		$table 							= "tbl_oqc_dir";
		$values 						= get_fields_values($_POST,array("action","username","id"));
		$array_fields 					= $values["array_fields"];
		$array_values 					= $values["array_values"];
		$id 							= $_POST["id"];
		$array_fields[] = "logdel";	$array_values[] = "1";
		$result 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$id);
		$script 						= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$id);
		$return["script"]				= $script;
		echo json_encode($return);
	}
	
	/* **********************
		Advance Search
	 ********************** */
	 function oqc_dir_return_dir_fields(){
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="po_number">P.O. Number</option>'; $ctr++;
		$option[$ctr] = '<option value="series_name">Series Name</option>'; $ctr++;
		$option[$ctr] = '<option value="shipment_date">Shipment Date</option>'; $ctr++;
		$option[$ctr] = '<option value="customer">Customer</option>'; $ctr++;
		$option[$ctr] = '<option value="remarks">Remarks</option>'; $ctr++;
		$option[$ctr] = '<option value="filename">Filename</option>'; $ctr++;
		$option[$ctr] = '<option value="created_by">Uploaded By</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	 }
	 
	 function oqc_dir_advance_search() {
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
	 
	/* OQC Dimension Inspection Result DIR - END */
	
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