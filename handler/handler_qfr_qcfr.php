<?php

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
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