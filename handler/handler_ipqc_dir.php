<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {		
				/* IPQC Dimension Inspection Start */
				case "dir_return_dimension_inspection_fields" 			: dir_return_dimension_inspection_fields(); break; 
				case "dir_advance_search" 								: dir_advance_search(); break; 
				case "dir_save_new_dimension_report" 					: dir_save_new_dimension_report(); break;
				case "dir_get_dimension_record_by_pkid" 				: dir_get_dimension_record_by_pkid(); break;
				case "dir_update_dimension_report" 						: dir_update_dimension_report(); break;
				/* NOTE : MODIFY(2022) - category list */
				case "dir_return_category_list"							: dir_return_category_list (); break;
				case "get_category_by_pkid"								: get_category_by_pkid (); break;
				case "dir_delete_info"									: dir_delete_info (); break;
				/* IPQC Dimension Inspection End */
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* IPQC Dimension Inspection Start */
	function dir_return_dimension_inspection_fields() {
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="ic">IC</option>'; $ctr++;
		$option[$ctr] = '<option value="inspection_date">Inspection Date</option>'; $ctr++;
		// $option[$ctr] = '<option value="po_number">PO Number</option>'; $ctr++;
		$option[$ctr] = '<option value="category">Category</option>'; $ctr++;
		
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	// dir_advance_search();
	function dir_advance_search() {
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
	
	function dir_save_new_dimension_report() {
		require_once('../class/oop_tqts.php');
		
		$date_time_today = date('Y-m-d H:i:s');
		$temp_file			= $_FILES['inspection_file']['tmp_name'];
		$file_name			= $_FILES['inspection_file']['name'];
		$file 				= return_file_path_by_div_mod('ipqc_dimension');
		$ext 				= pathinfo($file_name, PATHINFO_EXTENSION);
		$fkfile_path		= $file['pkid'];
		$script				= '';
		
		/* Check if record already exist */
		// $array_fields 	= array('ic', 'inspection_date', 'po_number', 'category', 'inspection_file', 'fkfile_path');

		// $array_fields 	= array('ic', 'inspection_date', 'category', 'inspection_file', 'fkfile_path');
		// $table 			= "tbl_ipqc_dimension_inspection";
		// $joins			= "";
		// // $sql_where		= "WHERE ic='".$_POST['ic']."' AND inspection_date='".$_POST['inspection_date']."' AND po_number='".$_POST['po_number']."' AND category='".$_POST['category']."' AND `logdel` = '0'";
		// $sql_where		= "WHERE ic='".$_POST['ic']."' AND inspection_date='".$_POST['inspection_date']."' AND category='".$_POST['category']."' AND `logdel` = '0'";
		// $sql_order		= "";
		// $sql_limit		= "LIMIT 0,1";
		// $result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// if($result->num_rows == 0){		
			/* Save record to main table */
			$table 			= "tbl_ipqc_dimension_inspection";
			$field_data			= get_fields_values($_POST, array("action"));
			$array_fields		= $field_data['array_fields']; 	$array_values   = $field_data['array_values'];
			$array_fields[]		= 'date_time_created'; 			$array_values[] = $date_time_today;
			$array_fields[]		= 'created_by'; 				$array_values[] = $_POST['username'];
			$array_fields[]		= 'inspection_file '; 			$array_values[] = $file_name;
			$array_fields[]		= 'fkfile_path'; 				$array_values[] = $fkfile_path;
			$array_fields[]		= 'lastupdate'; 				$array_values[] = $date_time_today;
			$pkid				= TQTS::getInstance()->insert_query_id($table, $array_fields, $array_values);
			$script				= TQTS::getInstance()->insert_query_script($table, $array_fields, $array_values);
			
			/* Save file */
			$target_file		= $file['path'].$pkid.'.'.$ext;
			if(move_uploaded_file($temp_file,$target_file)) {
				$return['msg']	= "New record has been saved";
			} else {
				$return['msg']	= 'There was an error on uploading the file.';
			}
		// } else {
		// 	$return['msg']	= 'Record already exist!';
		// }
		$return['msg']	= "New record has been saved";
		$return['script'] = $script;
		echo json_encode($return);
	}
		
	function dir_get_dimension_record_by_pkid() {
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$pkid			= $return['pkid'];
		// $array_fields 	= array('ic', 'inspection_date', 'po_number', 'category', 'inspection_file', 'po_number');
		$array_fields 	= array('ic', 'inspection_date','category', 'inspection_file', 'po_number');
		$table			= "tbl_ipqc_dimension_inspection";
		$joins			= "";
		$sql_where		= "WHERE pkid='".$pkid."' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,1";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$return['ic'] 				= $row['ic'];
			$return['inspection_date'] 	= $row['inspection_date'];
			// $return['po_number'] 		= $row['po_number'];
			$return['category'] 		= $row['category'];
			$return['inspection_file'] 	= $row['inspection_file'];
			$return['po_number'] 			= $row['po_number'];
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function dir_update_dimension_report() {
	
		// $return = $_POST;.
		require_once('../class/oop_tqts.php');
		$returns = $_POST;
		$date_time_today = date('Y-m-d H:i:s');
		$pkid			 = $_POST['pkid'];
		$script			 = '';
		$msg			 = '';
		// $temp_file		= $_FILES['inspection_file']['tmp_name'];
		// $file_name		= $_FILES['inspection_file']['name'];
		$file 			= return_file_path_by_div_mod('ipqc_dimension');

		
		/* Update record by pki */
		$table 				= "tbl_ipqc_dimension_inspection";
		$array_fields		=array(
			'ic','inspection_date',
			'category','po_number','lastupdate'
		);
		$array_values		=array(
			$returns['ic'],$returns['inspection_date'],
			$returns['category'],$returns['po_number'],date('Y-m-d H:i:s')
		);
		$where = 'WHERE pkid = "'.$pkid.'" AND `logdel` = 0';
		/*EDIT BY MIGUEL 03-10-23 - Edit the data not including the file name*/
		// $field_data			= get_fields_values($_POST, array("action","pkid","inspection_file"));
		// $array_fields		= $field_data['array_fields']; 	$array_values   = $field_data['array_values'];
		// $array_fields[]		= 'lastupdate'; 				$array_values[] = $date_time_today;
		// $msg			 .= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return['msg'] = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$return['script'] = TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
		
		/** Check if the file existed, then deleted it into the folder */
		$array_fields = array('inspection_file');
		$joins = '';
		$sql_where		= "WHERE `pkid`='".$pkid."' AND `logdel` = 0";
		$sql_order = '';
		$sql_limit = '';
		$result_select 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result_select)){
			$return['inspection_file'] 	= $row['inspection_file'];
		}
		
		$ext = pathinfo($return['inspection_file'], PATHINFO_EXTENSION);
		$current_file = $file['path'].$_POST['pkid'].'.'.$ext ;

		if($_FILES['inspection_file']['tmp_name'] == '' || (!isset($_FILES['inspection_file']['tmp_name']))) {
		} else { 
			unlink($current_file);
			$temp_file		= $_FILES['inspection_file']['tmp_name'];
			$file_name		= $_FILES['inspection_file']['name'];
			$ext 			= pathinfo($file_name, PATHINFO_EXTENSION);
			/* Save file */
			$target_file		= $file['path'].$pkid.'.'.$ext;
			if(move_uploaded_file($temp_file,$target_file)) {
				/*if the file uploaded to the directory change the inspection_file*/

				$table 				= "tbl_ipqc_dimension_inspection";
				$array_fields		=array(
					'inspection_file'
				);
				$array_values		=array(
					$file_name
				);
				$where = 'WHERE `pkid` = "'.$pkid.'" AND `logdel` = 0';
				$result =TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
				$return['msg'] = "File was successfully uploaded!";
			} else {
				$msg	= 'There was an error on uploading the file. ';
			}
		}
		echo json_encode($return);
	}
	// function replace_sa_image(){
		// 	require_once('../class/oop_tqts.php');
		// 	$return = $_POST;
		// 	$pkid 	= $_POST['attachment_pkid'];
		// 	$return['filename'] 	= $_FILES['file_sa']['name'];
		// 	$return['temp_name'] 	= $_FILES['file_sa']['tmp_name'];
		// 	$return['ext']  		= pathinfo($return['filename'], PATHINFO_EXTENSION);
		// 	$directory_path 		= return_file_path_by_div_mod('sa');
		// 	move_uploaded_file($return['temp_name'],$directory_path['path'].'e_'.$pkid.'.'.$return['ext']);
		// 	/* attachment */
		// 	$table			= 'tbl_qfr_special_acceptance_attachment';
		// 	$array_fields 	= array(
		// 								'file_name','lastupdate','username'
		// 							);
		// 	$array_values	= array(
		// 								$return['filename'],date('Y-m-d H:i:s'),$return['username']
		// 							);
		// 	$where 				= "WHERE pkid = '$pkid'";
		// 	$result 			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		// 	$return['script'] 	= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
		// 	$return['path'] 	= $directory_path['path'].'e_'.$pkid.'.'.$return['ext'];
			
		// 	echo json_encode($return);
		// }
	// function dir_update_dimension_report() {
	// 	echo 'true';
	// 		require_once('../class/oop_tqts.php');
	// 		$date_time_today = date('Y-m-d H:i:s');
	// 		$pkid			 = $_POST['pkid'];
	// 		$script			 = '';
	// 		$msg			 = '';
			
		// 	/* Update record by pkid */
			// $table 				= "tbl_ipqc_dimension_inspection";
		// 	$field_data			= get_fields_values($_POST, array("action","pkid","inspection_file"));
		// 	$array_fields		= $field_data['array_fields']; 	$array_values   = $field_data['array_values'];
		// 	$array_fields[]		= 'lastupdate'; 				$array_values[] = $date_time_today;
		// 	if($_FILES['inspection_file']['tmp_name'] == '' || (!isset($_FILES['inspection_file']['tmp_name']))) {
		// 	} else {
		// 		$field_data		= get_fields_values($_POST, array("action","pkid"));
		// 		$temp_file		= $_FILES['inspection_file']['tmp_name'];
		// 		$file_name		= $_FILES['inspection_file']['name'];
		// 		$file 			= return_file_path_by_div_mod('ipqc_dimension');
		// 		$ext 			= pathinfo($file_name, PATHINFO_EXTENSION);
		// 		$array_fields[]	= 'inspection_file '; 			$array_values[] = $file_name;
				
		// 		/* Save file */
		// 		$target_file		= $file['path'].$pkid.'.'.$ext;
		// 		if(move_uploaded_file($temp_file,$target_file)) {
		// 			$msg	= "File was successfully uploaded! ";
		// 		} else {
		// 			$msg	= 'There was an error on uploading the file. ';
		// 		}
		// 	}
		// 	$msg			 .= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$_POST['pkid']);
		// 	$return['script'] = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$_POST['pkid']);
		// 	$return['msg']	  = $msg;
		// 	echo json_encode($return);
	// }
	function dir_return_category_list(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$result = '';
		$array_fields 	= array('*');
		$table			= "tbl_ipqc_dir_category_list";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr= 0;
		while($row = mysqli_fetch_array($result)){
			$return ['pkid'][$ctr] = $row['pkid'];
			$return ['category'] [$ctr] = $row['category'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		echo json_encode($return);
	}

	function get_category_by_pkid(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$result = '';
		$pkid = $return['pkid'];
		$array_fields 	= array('*');
		$table			= "tbl_ipqc_dimension_inspection";
		$joins			= "";
		// $sql_where		= "WHERE `pkid` = $pkid `logdel` = '0'";
		$sql_where	='WHERE `pkid` = "'.$pkid.'" AND `logdel` = 0';
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr= 0;
		while($row = mysqli_fetch_array($result)){
			$return ['pkid'][$ctr] = $row['pkid'];
			$return ['category'] [$ctr] = $row['category'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		echo json_encode($return);
	}
	function dir_delete_info(){
		require_once('../class/oop_tqts.php');
		$return		  = $_POST;
		$table 		  = 'tbl_ipqc_dimension_inspection';
		$pkid         = $return['pkid'];
		$array_fields = array('remarks','logdel');
		$array_values =array($return['cancel_remarks'],1);
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
	
		echo json_encode($return);
	}
	
	/* IPQC Dimension Inspection End */

	
	?>