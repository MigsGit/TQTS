<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "generate_etr_no"							: generate_etr_no(); break;
				case "get_lon_disposition_lists"				: get_lon_disposition_lists(); break;
				case "return_etr_training_title_lists"			: return_etr_training_title_lists(); break;
				case "return_etr_training_objective_by_title"	: return_etr_training_objective_by_title(); break;
				case "return_etr_training_mechanics_lists"		: return_etr_training_mechanics_lists(); break;
				case "return_etr_type_training_lists"			: return_etr_type_training_lists(); break;
				case "return_etr_venue_lists"					: return_etr_venue_lists(); break;
				case "return_reason_certification_lists"		: return_reason_certification_lists(); break;
				case "return_training_category_lists"		    : return_training_category_lists(); break;
				case "get_emp_no_by_operator_name"		        : get_emp_no_by_operator_name(); break;
				case "get_emp_name_by_operator_empno"		    : get_emp_name_by_operator_empno(); break;
				case "save_prdn_training"		                : save_prdn_training(); break;
				case "get_etr_details_by_pkid"		            : get_etr_details_by_pkid(); break;
				case "edit_prdn_training"		            	: edit_prdn_training(); break;
				case "return_reason_certification_by_fketr"		: return_reason_certification_by_fketr(); break;
				case "return_training_category_by_fketr"		: return_training_category_by_fketr(); break;
				case "return_operator_lists"					: return_operator_lists(); break;
				case "return_check_items_by_fketr"				: return_check_items_by_fketr(); break;
				case "add_engr_training"						: add_engr_training(); break;
				case "add_qc_training"							: add_qc_training(); break;
				case "save_data_hris_etr"						: save_data_hris_etr(); break;
				case "cancel_etr"								: cancel_etr(); break;
				case "return_certified_operators"				: return_certified_operators(); break;
				case "update_prdn_eng_approval_logs"			: update_prdn_eng_approval_logs(); break;
				
				
				case "return_empno_list"						: return_empno_list(); break;
				case "return_empname_list"						: return_empname_list(); break;
				case "return_firstname_list"					: return_firstname_list(); break;
				case "return_lastname_list"						: return_lastname_list(); break;
				case "return_middlename_list"					: return_middlename_list(); break;
				case "return_position_list"						: return_position_list(); break;
				case "return_department_list"					: return_department_list(); break;
				
				
				/* Advanced Search */
				// case "oqc_dir_return_dir_fields"				: oqc_dir_return_dir_fields(); break;
				// case "oqc_dir_advance_search"				: oqc_dir_advance_search(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function generate_etr_no(){
		$return['control_no'] 	= return_etr_no();
		echo json_encode($return);
	}
	
	function return_etr_no(){
		require_once('../class/oop_tqts.php');
		$table  			= "tbl_etr_training";
		$array_fields		= array("date_time_created","SUBSTRING_INDEX(`control_no`, '-', -1) as series","SUBSTRING_INDEX(`control_no`, '-', 1) as fiscal_month");
		$joins  	 		= "";
		$sql_where  		= "WHERE logdel=0";
		$sql_order  		= "ORDER BY fiscal_month DESC,series DESC";
		$sql_limit  		= "LIMIT 0,1";
		$result        		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$year_month 		= date('ym');	
		$control_no 		= $year_month.'-001';
		
		if(date('m') >= 4 && date('m') <= 12) {
			$row=mysqli_fetch_array($result);
			$sql_where     = 'WHERE (date_time_created BETWEEN "'.date('Y', strtotime($row['date_time_created'].'-1')).'-04-01" AND "'.date('Y').'-12-31") AND logdel=0';
			$result        = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$script        = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			
			if($row=mysqli_fetch_array($result)) {
				$series 		= $row['series'] + 1;
				$series 		= '-'.str_pad(($series),3,"0",STR_PAD_LEFT);
				$control_no 	= $year_month.$series;
			}
		} else {
			if($row=mysqli_fetch_array($result)) {
				$series 		= $row['series'] + 1;
				$series 		= '-'.str_pad(($series),3,"0",STR_PAD_LEFT);
				$control_no 	= $year_month.$series;
			}
		}
		return $control_no;
	}
	
	function return_etr_training_title_lists() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('id','Title');
		$table			= 'db_hris.tbl_training_title_objective';
		$joins			= '';
		$sql_where		= 'WHERE Title LIKE "%'.$pattern.'%" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['id'].'" value="'.$row['Title'].'">'.$row['Title'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_etr_training_objective_by_title() {
		require_once('../class/oop_tqts.php');
		$title_id		= $_POST['title_id'];
		$array_fields 	= array('Objective');
		$table			= 'db_hris.tbl_training_title_objective';
		$joins			= '';
		$sql_where		= 'WHERE id = "'.$title_id.'" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$return['objective'] = $row['Objective'];
		} else {
			$return['objective'] = '';
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_etr_training_mechanics_lists() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('id','Mechanics');
		$table			= 'db_hris.tbl_training_mechanics';
		$joins			= '';
		$sql_where		= 'WHERE Mechanics LIKE "%'.$pattern.'%" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['id'].'" value="'.$row['Mechanics'].'">'.$row['Mechanics'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_etr_type_training_lists() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('id','TypeOfTraining');
		$table			= 'db_hris.tbl_training_type_of_training';
		$joins			= '';
		$sql_where		= 'WHERE TypeOfTraining LIKE "%'.$pattern.'%" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['id'].'" value="'.$row['TypeOfTraining'].'">'.$row['TypeOfTraining'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_etr_venue_lists() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('id','Venue');
		$table			= 'db_hris.tbl_training_venue';
		$joins			= '';
		$sql_where		= 'WHERE Venue LIKE "%'.$pattern.'%" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['id'].'" value="'.$row['Venue'].'">'.$row['Venue'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_reason_certification_lists() {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('pkid','reason_certification');
		$table			= 'tbl_etr_reason_certification';
		$joins			= '';
		$sql_where		= 'WHERE logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$html_chkbox	= '';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_chkbox .= '<label class="checkbox-inline"> <input type="checkbox" data-id="'.$row['pkid'].'" value="'.$row['pkid'].'" name="reason_certification">'.$row['reason_certification'].'</label> ';
		}
		$return['html_chkbox'] = $html_chkbox;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_training_category_lists() {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('pkid','training_category');
		$table			= 'tbl_etr_training_category';
		$joins			= '';
		$sql_where		= 'WHERE logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$html_chkbox	= '';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_chkbox .= '<label class="checkbox-inline"> <input type="checkbox" data-id="'.$row['pkid'].'" value="'.$row['pkid'].'">'.$row['training_category'].'</label> ';
		}
		$return['html_chkbox'] = $html_chkbox;
		$return['script'] = $script;
		echo json_encode($return);
	}
		
	function get_emp_no_by_operator_name() {
		require_once('../class/oop_tqts.php');
		$empname		= $_POST['empname'];
		$array_fields 	= array('empno');
        $table			= 'db_systemone_views.vw_pmi_subcon_operators';
        $joins			= '';
        $sql_where		= 'WHERE empname="'.$empname.'"';
        $sql_order		= '';
        $sql_limit		= 'LIMIT 0,1';
        $empno          = '';
        $result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)) {
            $array_empno = explode(",",$row['empno']);
            $row['empno'] = array();
            foreach($array_empno as $key => $value){
                $array_data_empno 				= array();
                $array_data_empno['id'] 		= $value;
                $array_data_empno['text'] 		= $value;
                $row['empno'][]				    = $array_data_empno;
            }
            $return['data'] = $row;
        }
		echo json_encode($return);
	}

	function get_emp_name_by_operator_empno() {
		require_once('../class/oop_tqts.php');
		$empno		    = $_POST['empno'];
		$array_fields 	= array('empname');
        $table			= 'db_systemone_views.vw_pmi_subcon_operators';
        $joins			= '';
        $sql_where		= 'WHERE empno="'.$empno.'"';
        $sql_order		= '';
        $sql_limit		= 'LIMIT 0,1';
        $empno          = '';
        $result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        if($row = mysqli_fetch_array($result)) {
            $array_empname  = explode(",",$row['empname']);
            $row['empname'] = array();
            foreach($array_empname as $key => $value){
                $array_data_empname 				= array();
                $array_data_empname['id'] 		    = $value;
                $array_data_empname['text'] 		= $value;
                $row['empname'][]				    = $array_data_empname;
            }
            $return['data'] = $row;
        }
		echo json_encode($return);
	}
	
    function save_prdn_training() {
        require_once('../class/oop_tqts.php');		
		$date_time_today            = date('Y-m-d H:i:s');
        $return                     = $_POST;
        $username                   = $_POST['username'];        
        $table 						= "tbl_etr_training";
		$values 					= get_fields_values($_POST,array("action","username","status","reason_certification","operator_name", "operator_en", "prdn_first_take_result", "prdn_second_take_result", "prdn_second_take_result2", "details_pkid","cancelled_by", "cancelled_logs", "cancelled_remarks", "station_from", "station_to","prdn_checked_by_logs"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "status"; 			$array_values[] = $_POST['status'];
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;


		//-------------- added novs
		$eng_arr_str 	= '';
		$has_eng = isset( $_POST['eng_first_take_qualified_by'] )?$_POST['eng_first_take_qualified_by']:0;
		if($has_eng){
			if(is_array($has_eng)){
				$eng_arr_str = implode(',',$has_eng);
			}else{
				$eng_arr_str = $has_eng;
			}
			$array_fields[] 			= "engr_checked_by"; 				$array_values[] = $eng_arr_str;//added novs 2019 05 31
		}

		$qc_arr_str 	= '';
		$has_qc = isset( $_POST['qc_first_take_certified_by'] )?$_POST['qc_first_take_certified_by']:0;
		if($has_qc){
			if(is_array($has_qc)){
				$qc_arr_str = implode(',',$has_qc);
			}else{
				$qc_arr_str = $has_qc;
			}
			$array_fields[] 			= "qc_checked_by"; 				$array_values[] = $qc_arr_str;//added novs 2019 05 31
		}

		// $array_fields[] 			= "engr_checked_by"; 			$array_values[] = $_POST['eng_first_take_qualified_by'];//added novs 2019 05 31
		// $array_fields[] 			= "qc_checked_by"; 				$array_values[] = $_POST['qc_first_take_certified_by'];//added novs 2019 05 31
		//--------------


		if($_POST['status'] == 'FOR PRDN CHECKING') {
			$array_fields[] = "prdn_checked_by_logs"; 		$array_values[] = 'PENDING||';
		}
		$script2 = '';
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		$msg						= 'No employee training found!';
		if(isset($_POST['operator_name'])) {
			$table_details	 		 = 'tbl_etr_training_employees';
			$operator_name 			 = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_name']))) : '';
			$operator_en 			 = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_en']))) : '';
			$station_from 			 = isset($_POST['station_from']) ? explode(',', (implode(',', $_POST['station_from']))) : '';
			$station_to 			 = isset($_POST['station_to']) ? explode(',', (implode(',', $_POST['station_to']))) : '';
			$prdn_first_take_result  =  isset($_POST['prdn_first_take_result']) ? explode(',', (implode(',', $_POST['prdn_first_take_result']))) : '';
			$prdn_second_take_result =  isset($_POST['prdn_second_take_result2']) ? explode(',', (implode(',', $_POST['prdn_second_take_result2']))) : '';
			foreach($operator_en as $key => $operator_empno) { 
				$array_fields 	 = array('date_time_created', 'created_by', 'fketr', 'operators_name', 'employee_no', 'station_from', 'station_to', 'prdn_first_take_result', 'prdn_second_take_result', 'lastupdate', 'username');
				$array_values 	 = array($date_time_today,$username,$pkid,$operator_name[$key],$operator_empno,$station_from[$key],$station_to[$key],$prdn_first_take_result[$key],$prdn_second_take_result[$key],$date_time_today,$username);
				$msg 			 = TQTS::getInstance()->insert_query($table_details,$array_fields,$array_values);
				$script2 		 = TQTS::getInstance()->insert_query_script($table_details,$array_fields,$array_values);
			}
			if((!in_array("PASSED", $prdn_second_take_result)) && (!in_array("", $prdn_second_take_result))) {
				if($_POST['status'] != 'DRAFT') {
					update_status($pkid, 'FAILED PRODUCTION');
				} 
			}
		}
		if($_POST['status'] != 'DRAFT') {
			send_email_for_approval($pkid, 'PROD-APP', 'new');
		}         
        $return['msg']        = $msg;
        $return['script']     = $script2;
        echo json_encode($return);
    }
	
	function get_etr_details_by_pkid() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$user 							= $_POST["user"];
		$table  						= "tbl_etr_training";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){
			$prdn_date_train	= $row['prdn_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['prdn_first_take_date_time']));
			$prdn_instructor	= get_emp_name_by_username_systemone($row['prdn_first_take_trained_by']);
			$engr_date_train	= $row['eng_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['eng_first_take_date_time']));
			$engr_instructor	= get_emp_name_by_username_systemone($row['eng_first_take_qualified_by']);
			$qc_date_train		= $row['qc_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['qc_first_take_date_time']));
			$qc_instructor		= get_emp_name_by_username_systemone($row['qc_first_take_certified_by']);
			
			$array_prdn_1st_take_trained_by = explode(",",$row['prdn_first_take_trained_by']);
			$row['prdn_first_take_trained_by'] 			= array();
			foreach($array_prdn_1st_take_trained_by as $key => $value){
				$array_data_prdn_1st 						= array();
				$array_data_prdn_1st['id'] 					= $value;
				$array_data_prdn_1st['text'] 				= get_emp_name_by_username_systemone($value);
				$row['prdn_first_take_trained_by'][]		= $array_data_prdn_1st;
			}
			$array_prdn_checked_by = explode(",",$row['prdn_checked_by']);
			$row['prdn_checked_by'] 			= array();
			foreach($array_prdn_checked_by as $key => $value){
				$array_data_prdn_chk 						= array();
				$array_data_prdn_chk['id'] 					= $value;
				$array_data_prdn_chk['text'] 				= get_emp_name_by_username_systemone($value);
				$row['prdn_checked_by'][]					= $array_data_prdn_chk;
			}
			
			$array_prdn_2nd_take_trained_by = explode(",",$row['prdn_second_take_trained_by']);
			$row['prdn_second_take_trained_by'] 			= array();
			foreach($array_prdn_2nd_take_trained_by as $key => $value){
				$array_data_prdn_2nd 						= array();
				$array_data_prdn_2nd['id'] 					= $value;
				$array_data_prdn_2nd['text'] 				= get_emp_name_by_username_systemone($value);
				$row['prdn_second_take_trained_by'][]		= $array_data_prdn_2nd;
			}
			
			$array_eng_1st_take_trained_by = explode(",",$row['eng_first_take_qualified_by']);
			$row['eng_first_take_qualified_by'] 			= array();
			foreach($array_eng_1st_take_trained_by as $key => $value){
				$array_data_eng_1st 						= array();
				$array_data_eng_1st['id'] 					= $value;
				$array_data_eng_1st['text'] 				= get_emp_name_by_username_systemone($value);
				$row['eng_first_take_qualified_by'][]		= $array_data_eng_1st;
			}
			
			$array_eng_2nd_take_trained_by = explode(",",$row['eng_second_take_qualified_by']);
			$row['eng_second_take_qualified_by'] 			= array();
			foreach($array_eng_2nd_take_trained_by as $key => $value){
				$array_data_eng_2nd 						= array();
				$array_data_eng_2nd['id'] 					= $value;
				$array_data_eng_2nd['text'] 				= get_emp_name_by_username_systemone($value);
				$row['eng_second_take_qualified_by'][]		= $array_data_eng_2nd;
			}
			
			$array_engr_checked_by = explode(",",$row['engr_checked_by']);
			$row['engr_checked_by'] 			= array();
			foreach($array_engr_checked_by as $key => $value){
				$array_data_engr_chk 						= array();
				$array_data_engr_chk['id'] 					= $value;
				$array_data_engr_chk['text'] 				= get_emp_name_by_username_systemone($value);
				$row['engr_checked_by'][]					= $array_data_engr_chk;
			}
			
			$array_qc_1st_take_trained_by = explode(",",$row['qc_first_take_certified_by']);
			$row['qc_first_take_certified_by'] 			= array();
			foreach($array_qc_1st_take_trained_by as $key => $value){
				$array_data_qc_1st 						= array();
				$array_data_qc_1st['id'] 				= $value;
				$array_data_qc_1st['text'] 				= get_emp_name_by_username_systemone($value);
				$row['qc_first_take_certified_by'][]	= $array_data_qc_1st;
			}
			
			$array_qc_2nd_take_trained_by = explode(",",$row['qc_second_take_certified_by']);
			$row['qc_second_take_certified_by'] 			= array();
			foreach($array_qc_2nd_take_trained_by as $key => $value){
				$array_data_qc_2nd 						= array();
				$array_data_qc_2nd['id'] 				= $value;
				$array_data_qc_2nd['text'] 				= get_emp_name_by_username_systemone($value);
				$row['qc_second_take_certified_by'][]	= $array_data_qc_2nd;
			}
			
			$array_qc_checked_by = explode(",",$row['qc_checked_by']);
			$row['qc_checked_by'] 			= array();
			foreach($array_qc_checked_by as $key => $value){
				$array_data_qc_cb 						= array();
				$array_data_qc_cb['id'] 				= $value;
				$array_data_qc_cb['text'] 				= get_emp_name_by_username_systemone($value);
				$row['qc_checked_by'][]	= $array_data_qc_cb;
			}
			
			$return['data'][0]	= $row;
		}	
		
		$sql_where2 = '';
		if($user == 'ENGR') {
			$sql_where2 = ' AND (prdn_second_take_result="" OR prdn_second_take_result="PASSED")';
		}
		if($user == 'QC') {
			$sql_where2 = ' AND (prdn_second_take_result="" OR prdn_second_take_result="PASSED") AND (eng_second_take_overall_assessment="" OR eng_second_take_overall_assessment="PASSED")';
		}
		if($user == 'TH') {
			$sql_where2 = ' AND (`qc_first_take_overall_assessment`="PASSED" OR `qc_second_take_overall_assessment`="PASSED") ';
		}
		$tbl_body				= '';
		$ctr					= 1;
		$table_details  		= "tbl_etr_training_employees";
		$array_fields			= array("*");
		$joins  	 			= "";
		$sql_where  			= "WHERE `fketr` = '$pkid' AND logdel=0".$sql_where2;
		$sql_order  			= "";
		$sql_limit  			= "";
		$result        			= TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		$script        			= TQTS::getInstance()->select_query_script($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			$return['data_1']	= 'NO DATA';
			$tbl_body	 = '<tr>';
			$tbl_body  .= '	<td colspan="9"><center>No data found!</center></td>';
			$tbl_body  .= '</tr>';
		} else {
			while($row = mysqli_fetch_assoc($result)){		
				$operators_name = $row['operators_name'];
				$employee_no 	= $row['employee_no'];
				$station_from 	= $row['station_from'];
				$station_to 	= $row['station_to'];
			
				$array_operator_name = explode(",",$operators_name);
				$row['operators_name'] 			= array();
				foreach($array_operator_name as $key => $value){
					$array_data_oprt 			= array();
					$array_data_oprt['id'] 		= $value;
					$array_data_oprt['text'] 	= $value;
					$row['operators_name'][]	= $array_data_oprt;
				}
							
				$array_operator_en = explode(",",$employee_no);
				$row['employee_no'] 			= array();
				foreach($array_operator_en as $key => $value){
					$array_data_oprt_en			= array();
					$array_data_oprt_en['id'] 	= $value;
					$array_data_oprt_en['text'] = $value;
					$row['employee_no'][]		= $array_data_oprt_en;
				}
				
				$return['data'][1][]	= $row;
				$return['data_1']		= 'HAVE DATA';
				
				/* Return certified operators */
				$tbl_body	.= '<tr>';
				$tbl_body  .= '	<td><center>'.$ctr++.'</center></td>';
				$tbl_body  .= '	<td>'.$operators_name.'</td>';
				$tbl_body  .= '	<td><center>'.$employee_no.'</center></td>';
				$tbl_body  .= '	<td><center>'.$station_from.'</center></td>';
				$tbl_body  .= '	<td><center>'.$station_to.'</center></td>';
				$tbl_body  .= '	<td><center>'.$prdn_date_train.'</center></td>';
				$tbl_body  .= '	<td><center>'.$prdn_instructor.'</center></td>';
				$tbl_body  .= '	<td><center>'.$engr_date_train.'</center></td>';
				$tbl_body  .= '	<td><center>'.$engr_instructor.'</center></td>';
				$tbl_body  .= '	<td><center>'.$qc_date_train.'</center></td>';
				$tbl_body  .= '	<td><center>'.$qc_instructor.'</center></td>';
				$tbl_body  .= '</tr>';
				$return['tbl_body']		= $tbl_body;
			}
		}
		$return['script'] = $script;
		$return['num_rows'] = $result->num_rows;
		echo json_encode($return);
	}
		
    function edit_prdn_training() {
        require_once('../class/oop_tqts.php');		
		$date_time_today            = date('Y-m-d H:i:s');
        $return                     = $_POST;
        $pkid                   	= $_POST['pkid'];
        $username                   = $_POST['username'];
        
        $table 						= "tbl_etr_training";
		$values 					= get_fields_values($_POST,array("action","username","status","reason_certification","operator_name", "operator_en", "prdn_first_take_result", "prdn_second_take_result", "prdn_second_take_result2","details_pkid", "station_from","station_to"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "status"; 			$array_values[] = $_POST['status'];
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		if($_POST['status'] == 'FOR PRDN CHECKING') {
			$array_fields[] = "prdn_checked_by_logs"; 		$array_values[] = 'PENDING||';
		} else if($_POST['status'] == 'FOR ENGR. QUALIFICATION') {
			$array_fields[] = "prdn_checked_by_logs"; 		$array_values[] = 'APPROVED|'.$date_time_today.'|';
			$array_fields[] = "engr_checked_by_logs"; 		$array_values[] = 'PENDING||';

		}
		$result						= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 					= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$msg						= 'No employee training found!';
		if(isset($_POST['operator_name'])) {
			$table_details	 		 = 'tbl_etr_training_employees';
			$details_pkid 			 = isset($_POST['details_pkid']) ? explode(',', (implode(',', $_POST['details_pkid']))) : '';
			$operator_name 			 = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_name']))) : '';
			$operator_en 			 = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_en']))) : '';
			$station_from 			 = isset($_POST['station_from']) ? explode(',', (implode(',', $_POST['station_from']))) : '';
			$station_to 			 = isset($_POST['station_to']) ? explode(',', (implode(',', $_POST['station_to']))) : '';
			$prdn_first_take_result  = isset($_POST['prdn_first_take_result']) ? explode(',', (implode(',', $_POST['prdn_first_take_result']))) : '';
			$prdn_second_take_result = isset($_POST['prdn_second_take_result2']) ? explode(',', (implode(',', $_POST['prdn_second_take_result2']))) : '';
			
			$array_fields 	 = array('lastupdate', 'username', 'logdel');
			$array_values 	 = array($date_time_today,$username, 1);
			$sql_where		 = 'WHERE fketr='.$pkid;
			$result 		 = TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
			$script2 		 = TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);
			
			foreach($operator_en as $key => $operator_empno) { 
				if($details_pkid[$key] == 0) {
					$array_fields 	 = array('date_time_created', 'created_by', 'fketr', 'operators_name', 'employee_no', 'station_from', 'station_to', 'prdn_first_take_result', 'prdn_second_take_result', 'lastupdate', 'username');
					$array_values 	 = array($date_time_today,$username,$pkid,$operator_name[$key],$operator_empno,$station_from[$key],$station_to[$key],$prdn_first_take_result[$key],$prdn_second_take_result[$key],$date_time_today,$username);
					$msg 			 = TQTS::getInstance()->insert_query($table_details,$array_fields,$array_values);
					$script2 		.= TQTS::getInstance()->insert_query_script($table_details,$array_fields,$array_values);
				} else {
					$array_fields 	 = array('operators_name', 'employee_no', 'station_from', 'station_to', 'prdn_first_take_result', 'prdn_second_take_result', 'lastupdate', 'username', 'logdel');
					$array_values 	 = array($operator_name[$key],$operator_empno,$station_from[$key],$station_to[$key],$prdn_first_take_result[$key],$prdn_second_take_result[$key],$date_time_today,$username, 0);
					$msg 			 = TQTS::getInstance()->update_query($table_details,$array_fields,$array_values,$details_pkid[$key]);
					$script2 		.= TQTS::getInstance()->update_query_script($table_details,$array_fields,$array_values,$details_pkid[$key]);
				}
			}
			if((!in_array("PASSED", $prdn_second_take_result)) && (!in_array("", $prdn_second_take_result))) {
				if($_POST['status'] != 'DRAFT') {
					update_status($pkid, 'FAILED PRODUCTION');
				} 
			}
		}
		
		if($_POST['status'] != 'DRAFT') {
			send_email_for_approval($pkid, 'ENGR', 'new');
		}
        $return['msg']           = $msg;
        $return['script']        = $script;
        $return['script2']       = $script2;
        echo json_encode($return);
    }
	
	function return_reason_certification_by_fketr() {
		require_once('../class/oop_tqts.php');
		$fk_etr			= $_POST['fk_etr'];
		$array_fields 	= array('reason_for_certification','reason_for_certification_value','reason_certification_others');
		$table			= 'tbl_etr_training';
		$joins			= '';
		$sql_where		= 'WHERE pkid="'.$fk_etr.'" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_chkbox	= '';
		$others_value	= '';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$reason_for_certification_id 	= explode(',', $row['reason_for_certification']);
			$reason_for_certification_val 	= explode(',', $row['reason_for_certification_value']);
			foreach($reason_for_certification_id as $key => $value) {
				$checked = '';
				if($reason_for_certification_val[$key] == "true") {
					$checked = 'checked';
				}
				if($value == 5 && $reason_for_certification_val[$key] == "true") {
					$others_value = $row['reason_certification_others'];
				}
				/* return requivalent data */
				$array_fields2 	= array('pkid','reason_certification');
				$table2			= 'tbl_etr_reason_certification';
				$joins2			= '';
				$sql_where2		= 'WHERE pkid="'.$value.'" AND logdel=0';
				$sql_order2		= '';
				$sql_limit2		= '';
				$result2		= TQTS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
				$script2		= TQTS::getInstance()->select_query_script($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
				if($row2 = mysqli_fetch_array($result2)) {
					$html_chkbox .= '<label class="checkbox-inline"> <input type="checkbox" data-id="'.$row2['pkid'].'" value="'.$row2['pkid'].'" name="reason_certification" '.$checked.'>'.$row2['reason_certification'].'</label> ';
				}
			}	
		}
		
		$return['html_chkbox']  = $html_chkbox;
		$return['others_value'] = $others_value;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_training_category_by_fketr() {
		require_once('../class/oop_tqts.php');
		$fk_etr			= $_POST['fk_etr'];
		$array_fields 	= array('training_category','training_category_value');
		$table			= 'tbl_etr_training';
		$joins			= '';
		$sql_where		= 'WHERE pkid="'.$fk_etr.'" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_chkbox	= '';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$training_category_id 	= explode(',', $row['training_category']);
			$training_category_val 	= explode(',', $row['training_category_value']);
			foreach($training_category_id as $key => $value) {
				$checked = '';
				if($training_category_val[$key] == "true") {
					$checked = 'checked';
				}
				/* return requivalent data */
				$array_fields2 	= array('pkid','training_category');
				$table2			= 'tbl_etr_training_category';
				$joins2			= '';
				$sql_where2		= 'WHERE pkid="'.$value.'" AND logdel=0';
				$sql_order2		= '';
				$sql_limit2		= '';
				$result2		= TQTS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
				$script2		= TQTS::getInstance()->select_query_script($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
				if($row2 = mysqli_fetch_array($result2)) {
					$html_chkbox .= '<label class="checkbox-inline"> <input type="checkbox" data-id="'.$row2['pkid'].'" value="'.$row2['pkid'].'" '.$checked.'>'.$row2['training_category'].'</label> ';
				}
			}	
		}
		
		$return['html_chkbox']  = $html_chkbox;
		$return['script'] = $script2;
		echo json_encode($return);
	}
	
	function update_status($etr_id, $status) {
		require_once('../class/oop_tqts.php');				
		$table 			 = "tbl_etr_training";
		$array_fields 	 = array('status');
		$array_values 	 = array($status);
		$result			 = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$etr_id);
	}
	
	function return_check_items_by_fketr() {
		require_once('../class/oop_tqts.php');
		$fk_etr			= $_POST['fk_etr'];
		$array_fields 	= array('check_items','check_items_value');
		$table			= 'tbl_etr_training';
		$joins			= '';
		$sql_where		= 'WHERE pkid="'.$fk_etr.'" AND check_items != "" AND logdel=0';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_chkbox	= '';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			$array_fields2 	= array('pkid','engr_check_items');
			$table2			= 'tbl_etr_engr_check_items';
			$joins2			= '';
			$sql_where2		= 'WHERE logdel=0';
			$sql_order2		= '';
			$sql_limit2		= '';
			$result2		= TQTS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
			$script2		= TQTS::getInstance()->select_query_script($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
			while($row2 = mysqli_fetch_array($result2)) {
				$html_chkbox .= '<label class="checkbox-inline"> <input type="checkbox" data-id="'.$row2['pkid'].'" value="'.$row2['pkid'].'">'.$row2['engr_check_items'].'</label> ';
			}
		} else {
			if($row = mysqli_fetch_array($result)) {
				$check_items_id 	= explode(',', $row['check_items']);
				$check_items_value 	= explode(',', $row['check_items_value']);
				foreach($check_items_id as $key => $value) {
					$checked = '';
					if($check_items_value[$key] == "true") {
						$checked = 'checked';
					}
					/* return requivalent data */
					$array_fields2 	= array('pkid','engr_check_items');
					$table2			= 'tbl_etr_engr_check_items';
					$joins2			= '';
					$sql_where2		= 'WHERE pkid="'.$value.'" AND logdel=0';
					$sql_order2		= '';
					$sql_limit2		= '';
					$result2		= TQTS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
					$script2		= TQTS::getInstance()->select_query_script($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
					if($row2 = mysqli_fetch_array($result2)) {
						$html_chkbox .= '<label class="checkbox-inline"> <input type="checkbox" data-id="'.$row2['pkid'].'" value="'.$row2['pkid'].'" '.$checked.'>'.$row2['engr_check_items'].'</label> ';
					}
				}	
			}
		}
		$return['html_chkbox']  = $html_chkbox;
		$return['script'] = $script2;
		echo json_encode($return);
	}
	
	function return_operator_lists() {
		require_once('../class/oop_tqts.php');
		$pkid				= $_POST['pkid'];		
		$return['data'] 	= array();
		$table_details  	= "tbl_etr_training_employees";
		$array_fields		= array("*");
		$joins  	 		= "";
		$sql_where  		= "WHERE `fketr` = '$pkid' AND logdel=0";
		$sql_order  		= "";
		$sql_limit  		= "";
		$result        		= TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		$script        		= TQTS::getInstance()->select_query_script($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		
		$tbl_prdn_body		= '';
		$tbl_engr_body		= '';
		$tbl_qc_body		= '';
		$prdn_ctr			= 1;
		$engr_ctr			= 1;
		$qc_ctr				= 1;
		
		if($result->num_rows == 0) {
			$tbl_prdn_body	 = '<tr>';
			$tbl_prdn_body  .= '	<td colspan="4"><center>No data found!</center></td>';
			$tbl_prdn_body  .= '</tr>';
		} else {
			while($row = mysqli_fetch_assoc($result)){	
				$tbl_prdn_body	.= '<tr>';
				$tbl_prdn_body  .= '	<td>'.$prdn_ctr++.'</td>';
				$tbl_prdn_body  .= '	<td>'.$row['operators_name'].'</td>';
				$tbl_prdn_body  .= '	<td><center>'.$row['employee_no'].'</center></td>';
				$tbl_prdn_body  .= '	<td><center>'.$row['prdn_first_take_result'].'</center></td>';
				$tbl_prdn_body  .= '	<td><center>'.($row['prdn_second_take_result'] == ''? '-':$row['prdn_second_take_result']).'</center></td>';
				$tbl_prdn_body  .= '</tr>';
				
				if($row['eng_first_take_observation_interview'] != '') {
					$tbl_engr_body	.= '<tr>';
					$tbl_engr_body  .= '	<td>'.$engr_ctr++.'</td>';
					$tbl_engr_body  .= '	<td>'.$row['operators_name'].'</td>';
					$tbl_engr_body  .= '	<td><center>'.$row['employee_no'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_first_take_observation_interview'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.($row['eng_second_take_observation_interview'] == ''? '-':$row['eng_second_take_observation_interview']).'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_first_take_sample_checking_ok'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_first_take_sample_checking_ng'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_second_take_sample_checking_ok'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_second_take_sample_checking_ng'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_first_take_overall_assessment'].'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.($row['eng_second_take_overall_assessment'] == ''? '-':$row['eng_second_take_overall_assessment']).'</center></td>';
					$tbl_engr_body  .= '	<td><center>'.$row['eng_reason_for_disqualification'].'</center></td>';
					$tbl_engr_body  .= '</tr>';
				}
				
				if($row['qc_first_take_observation_interview_result'] != '') {
					$tbl_qc_body  .= '<tr>';
					$tbl_qc_body  .= '	<td>'.$qc_ctr++.'</td>';
					$tbl_qc_body  .= '	<td>'.$row['operators_name'].'</td>';
					$tbl_qc_body  .= '	<td><center>'.$row['employee_no'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_first_take_observation_interview_result'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.($row['qc_second_take_observation_interview_result'] == ''? '-':$row['qc_second_take_observation_interview_result']).'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_first_take_sample_checking_ok'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_first_take_sample_checking_ng'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_second_take_sample_checking_ok'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_second_take_sample_checking_ng'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_first_take_overall_assessment'].'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.($row['qc_second_take_overall_assessment'] == ''? '-':$row['qc_second_take_overall_assessment']).'</center></td>';
					$tbl_qc_body  .= '	<td><center>'.$row['qc_reason_for_disqualification'].'</center></td>';
					$tbl_qc_body  .= '</tr>';
				}
			}
		}
		
		/* Display Table for Production */
		$tbl_prdn 	 = '<div class="profile-info-title h4" >';
		$tbl_prdn 	.= '	<span class="fa fa-list"></span> Production Section';
		$tbl_prdn 	.= '</div>';
		$tbl_prdn 	.= '<hr class="graph-orange" style="margin-top:0px;">';
		$tbl_prdn 	.= '<table class="table table-bordered table-hover table-condensed table-striped" style="width:100%;">';
		$tbl_prdn 	.= '	<thead>';
		$tbl_prdn 	.= '		<tr>';
		$tbl_prdn 	.= '			<th rowspan="2"><center>#</center></th>';
		$tbl_prdn 	.= '			<th rowspan="2"><center>Operator Name</center></th>';
		$tbl_prdn 	.= '			<th rowspan="2"><center>Emp. No.</center></th>';
		$tbl_prdn 	.= '			<th colspan="2"><center>Result</center></th>';
		$tbl_prdn 	.= '		</tr>';
		$tbl_prdn 	.= '		<tr>';
		$tbl_prdn 	.= '			<th><center>1st Take</center></th>';
		$tbl_prdn 	.= '			<th><center>2nd Take</center></th>';
		$tbl_prdn 	.= '		</tr>';
		$tbl_prdn 	.= '	</thead>';
		$tbl_prdn 	.= '	<tbody>';
		$tbl_prdn 	.= $tbl_prdn_body;
		$tbl_prdn 	.= '	</tbody>';
		$tbl_prdn 	.= '</table>';
		
		$tbl_data	 = $tbl_prdn;
		
		/* Display Table for Engineering */
		$tbl_engr 	 = '<div class="profile-info-title h4" >';
		$tbl_engr 	.= '	<span class="fa fa-list"></span> Engineering Section';
		$tbl_engr 	.= '</div>';
		$tbl_engr 	.= '<hr class="graph-orange" style="margin-top:0px;">';
		$tbl_engr 	.= '<table class="table table-bordered table-hover table-condensed table-striped" style="width:100%;">';
		$tbl_engr 	.= '	<thead>';
		$tbl_engr 	.= '		<tr>';
		$tbl_engr 	.= '			<th rowspan="3"><center>#</center></th>';
		$tbl_engr 	.= '			<th rowspan="3"><center>Operator Name</center></th>';
		$tbl_engr 	.= '			<th rowspan="3"><center>Emp. No.</center></th>';
		$tbl_engr 	.= '			<th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>';
		$tbl_engr 	.= '			<th colspan="4" style="width:20%"><center>Sample Checking</center></th>';
		$tbl_engr 	.= '			<th colspan="2" style="width:20%"><center>Overall Assessment</center></th>';
		$tbl_engr 	.= '			<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>';
		$tbl_engr 	.= '		</tr>';
		$tbl_engr 	.= '		<tr>';
		$tbl_engr 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_engr 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_engr 	.= '		</tr>';
		$tbl_engr 	.= '	</thead>';
		$tbl_engr 	.= '	<tbody>';
		$tbl_engr 	.= $tbl_engr_body;
		$tbl_engr 	.= '	</tbody>';
		$tbl_engr 	.= '</table>';
		
		/* Display Table for QC */
		$tbl_qc 	 = '<div class="profile-info-title h4" >';
		$tbl_qc 	.= '	<span class="fa fa-list"></span> Quality Control Section';
		$tbl_qc 	.= '</div>';
		$tbl_qc 	.= '<hr class="graph-orange" style="margin-top:0px;">';
		$tbl_qc 	.= '<table class="table table-bordered table-hover table-condensed table-striped" style="width:100%;">';
		$tbl_qc 	.= '	<thead>';
		$tbl_qc 	.= '		<tr>';
		$tbl_qc 	.= '			<th rowspan="3"><center>#</center></th>';
		$tbl_qc 	.= '			<th rowspan="3"><center>Operator Name</center></th>';
		$tbl_qc 	.= '			<th rowspan="3"><center>Emp. No.</center></th>';
		$tbl_qc 	.= '			<th colspan="2" style="width:20%"><center>Observation/Interview result</center></th>';
		$tbl_qc 	.= '			<th colspan="4" style="width:20%"><center>Sample Checking</center></th>';
		$tbl_qc 	.= '			<th colspan="2" style="width:20%"><center>Overall Assessment</center></th>';
		$tbl_qc 	.= '			<th rowspan="3" style="width:10%"><center>Reason for Disqualification</center></th>';
		$tbl_qc 	.= '		</tr>';
		$tbl_qc 	.= '		<tr>';
		$tbl_qc 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>1st Take</center></th>';
		$tbl_qc 	.= '			<th rowspan="2"><center>2nd Take</center></th>';
		$tbl_qc 	.= '		</tr>';
		$tbl_qc 	.= '	</thead>';
		$tbl_qc 	.= '	<tbody>';
		$tbl_qc 	.= $tbl_qc_body;
		$tbl_qc 	.= '	</tbody>';
		$tbl_qc 	.= '</table>';
		
		$tbl_data .= $tbl_engr_body == '' ? '' : $tbl_engr;
		$tbl_data .= $tbl_qc_body == '' ? '' : $tbl_qc;
		
		$return['tbl_data'] = $tbl_data;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function add_engr_training() {
        require_once('../class/oop_tqts.php');		
		$date_time_today              = date('Y-m-d H:i:s');
        $return                       = $_POST;
        $pkid                   	  = $_POST['pkid'];
        $username                     = $_POST['username'];
        $status                  	  = $_POST['status'];
        $check_items_id               = isset($_POST['check_items_id']) ? implode(',',$_POST['check_items_id']) : '';
        $check_items_value               = isset($_POST['check_items_value']) ? implode(',',$_POST['check_items_value']) : '';
        // $check_items_value            = implode(',',$_POST['check_items_value']);
        $eng_first_take_qualified_by  = $_POST['eng_first_take_qualified_by'];
        $eng_first_take_date_time 	  = $_POST['eng_first_take_date_time'];
        $eng_second_take_qualified_by = isset($_POST['eng_second_take_qualified_by']) ? $_POST['eng_second_take_qualified_by'] : '';
        $eng_second_take_date_time    = $_POST['eng_second_take_date_time'];
        $engr_checked_by    		  = $_POST['engr_checked_by'];

        //added fields from Approver module 2019 06 27 req by ms cnpoblete
		// require_once('../class/oop_tqts.php');
		// $date_time_today    = date('Y-m-d H:i:s');
		// $username			= $_POST["username"];
		// $pkid 				= $_POST["pkid"];
		// $status				= $_POST["status"];
		// $remarks			= $_POST["remarks"];	
		// // $cby_field			= $_POST["checked_by_field"];		
		// $logs_field 		= $_POST["checked_by_logs_field"];		
		// $app_logs	 		= $_POST["app_status"] . '|'.$date_time_today . '|'.$remarks;		
		// $table  			= "tbl_etr_training";
		// $array_fields 		= array('status', $logs_field, 'lastupdate', 'username');
		// $array_values 		= array($status, $app_logs, $date_time_today, $username);
		// $msg				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		// $script 		    = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$remarks = '';
		$app_logs	 		= 'APPROVED' . '|'.$date_time_today . '|'.$remarks;//always approve since there is no longer approver



		//commented by novs 2019-06-27
		// if($_POST['status'] == 'FOR ENGR CHECKING') {
		// 	$array_fields[] = "engr_checked_by_logs"; 		$array_values[] = 'PENDING||';
		// }


        $table 						  = "tbl_etr_training";
		// $array_fields 				  = array('status','check_items','check_items_value','eng_first_take_qualified_by','eng_first_take_date_time','eng_second_take_qualified_by','eng_second_take_date_time','engr_checked_by','lastupdate', 'username');
		// $array_values 				  = array($status, $check_items_id, $check_items_value, $eng_first_take_qualified_by, $eng_first_take_date_time, $eng_second_take_qualified_by, $eng_second_take_date_time, $engr_checked_by, $date_time_today, $username);

		$array_fields 				  = array('status','check_items','check_items_value','eng_first_take_qualified_by','eng_first_take_date_time','eng_second_take_qualified_by','eng_second_take_date_time','engr_checked_by','engr_checked_by_logs','qc_checked_by_logs','lastupdate', 'username');//novs edit 2019-06-27
		$array_values 				  = array($status, $check_items_id, $check_items_value, $eng_first_take_qualified_by, $eng_first_take_date_time, $eng_second_take_qualified_by, $eng_second_take_date_time, $username, $app_logs, 'PENDING||', $date_time_today, $username);//novs edit 2019-06-27



		$result						  = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 					  = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$msg						  = '';
		if(isset($_POST['operator_name'])) {
			$table_details	 		  = 'tbl_etr_training_employees';
			$details_pkid 			  = isset($_POST['details_pkid']) ? explode(',', (implode(',', $_POST['details_pkid']))) : '';
			$operator_name 			  = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_name']))) : '';
			$operator_en 			  = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_en']))) : '';
			$eng_first_take_observation_interview  	= isset($_POST['eng_first_take_observation_interview']) ? explode(',', (implode(',', $_POST['eng_first_take_observation_interview']))) : '';
			$eng_second_take_observation_interview  = isset($_POST['eng_second_take_observation_interview2']) ? explode(',', (implode(',', $_POST['eng_second_take_observation_interview2']))) : '';
			$eng_first_take_sample_checking_ok  	= isset($_POST['eng_first_take_sample_checking_ok']) ? explode(',', (implode(',', $_POST['eng_first_take_sample_checking_ok']))) : '';
			$eng_second_take_sample_checking_ok  	= isset($_POST['eng_second_take_sample_checking_ok2']) ? explode(',', (implode(',', $_POST['eng_second_take_sample_checking_ok2']))) : '';
			$eng_first_take_sample_checking_ng  	= isset($_POST['eng_first_take_sample_checking_ng']) ? explode(',', (implode(',', $_POST['eng_first_take_sample_checking_ng']))) : '';
			$eng_second_take_sample_checking_ng  	= isset($_POST['eng_second_take_sample_checking_ng2']) ? explode(',', (implode(',', $_POST['eng_second_take_sample_checking_ng2']))) : '';
			$eng_first_take_overall_assessment  	= isset($_POST['eng_first_take_overall_assessment2']) ? explode(',', (implode(',', $_POST['eng_first_take_overall_assessment2']))) : '';
			$eng_second_take_overall_assessment  	= isset($_POST['eng_second_take_overall_assessment2']) ? explode(',', (implode(',', $_POST['eng_second_take_overall_assessment2']))) : '';
			$eng_reason_for_disqualification 		= isset($_POST['eng_reason_for_disqualification']) ? explode(',', (implode(',', $_POST['eng_reason_for_disqualification']))) : '';
			
			foreach($operator_en as $key => $operator_empno) { 
				if($details_pkid[$key] != 0) {
					$array_fields 	 = array('eng_first_take_observation_interview', 'eng_second_take_observation_interview', 'eng_first_take_sample_checking_ok', 'eng_first_take_sample_checking_ng', 'eng_second_take_sample_checking_ok', 'eng_second_take_sample_checking_ng', 'eng_first_take_overall_assessment', 'eng_second_take_overall_assessment', 'eng_reason_for_disqualification', 'lastupdate', 'username');
					$array_values 	 = array($eng_first_take_observation_interview[$key], $eng_second_take_observation_interview[$key], $eng_first_take_sample_checking_ok[$key], $eng_first_take_sample_checking_ng[$key], $eng_second_take_sample_checking_ok[$key], $eng_second_take_sample_checking_ng[$key], $eng_first_take_overall_assessment[$key], $eng_second_take_overall_assessment[$key], $eng_reason_for_disqualification[$key],$date_time_today,$username);
					$msg 			 = TQTS::getInstance()->update_query($table_details,$array_fields,$array_values,$details_pkid[$key]);
					$script 		.= TQTS::getInstance()->update_query_script($table_details,$array_fields,$array_values,$details_pkid[$key]);
				}
			}
			if((!in_array("PASSED", $eng_second_take_overall_assessment)) && (!in_array("", $eng_second_take_overall_assessment))) {
				if($_POST['status'] != 'DRAFT ENGR') {
					update_status($pkid, 'FAILED ENGINEERING');
				} 
			}
		}
        send_email_for_approval($pkid, 'QC', 'new');
        $return['msg']           = $msg;
        $return['script']        = $script;
        echo json_encode($return);
    }
	
	function cancel_etr() {
        require_once('../class/oop_tqts.php');		
		$date_time_today              = date('Y-m-d H:i:s');
        $return                       = $_POST;
        $pkid                   	  = $_POST['pkid'];
        $username                     = $_POST['username'];
        $status                       = $_POST['status'];
        $cancelled_by    			  = $_POST['username'];
        $cancelled_logs    			  = $date_time_today;
        $cancelled_remarks    		  = $_POST['cancelled_remarks'];
        
        $table 						  = "tbl_etr_training";
		$array_fields 				  = array('status','cancelled_by', 'cancelled_logs', 'cancelled_remarks','lastupdate', 'username');
		$array_values 				  = array($status, $cancelled_by, $cancelled_logs, $cancelled_remarks, $date_time_today, $username);
		$msg						  = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script						  = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
        $return['msg']           = $msg;
        send_email_cancelled($pkid);
        $return['script']        = $script;
        echo json_encode($return);
    }	
	
	function send_email_for_approval($pkid, $attn, $action) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_etr_training';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 				= $row['created_by'];
			$username 					= $row['username'];
			$training_title 			= $row['training_title'];
			$training_objective 		= $row['training_objective'];
			$line 						= $row['line'];
			$control_no 				= $row['control_no'];
			$series_name 				= $row['series_name'];
			$prdn_checked_by 			= $row['prdn_checked_by'];
			$prdn_trained_by 			= $row['prdn_first_take_trained_by'];
			$qc_checked_by 				= $row['qc_checked_by'];
			$prdn_first_take_trained_by = get_emp_name_by_username_systemone($row['prdn_first_take_trained_by']);
			$prdn_first_take_date_time 	= date('M d, Y',strtotime($row['prdn_first_take_date_time']));
			$eng_first_take_qualified_by = $row['eng_first_take_qualified_by'];
			$qc_first_take_certified_by  = $row['qc_first_take_certified_by'];
		}
		if($action == 'new') {
			$subject 	 = 'FOR TRAINING/ORIENTATION: '.$training_title.' ('.$series_name.')';
		} else if($action == 'edit') {
			$subject 	 = 'FOR TRAINING/ORIENTATION (Revised): '.$training_title.' ('.$series_name.')';
		}  
		
		$body 	 	 = 'Please be informed that you have training for qualification.<br> <br>';
		$body 		.= 'Training details: <br>';
		$body 		.= '&emsp;Title: '.$training_title.' <br>';
		$body 		.= '&emsp;Objective: '.$training_objective.' <br>';
		$body 		.= '&emsp;Line: '.$line.' <br>';
		$body 		.= '&emsp;Control No.: '.$control_no.' <br>';
		$body 		.= '&emsp;Series Name: '.$series_name.' <br>';
		$body 		.= '&emsp;Trained by (Prod.): '.$prdn_first_take_trained_by.' <br>';
		$body 		.= '&emsp;Date: '.$prdn_first_take_date_time.' <br>';
		
		if($attn == 'PROD-APP') { //send email to PROD-APP
			$to			= return_user_email_add($prdn_checked_by) == 'NONE' ? '' : return_user_email_add($prdn_checked_by);
			$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$cc 		= $from.','.(return_user_email_add($prdn_trained_by) == 'NONE' ? '' : return_user_email_add($prdn_trained_by));
		} else if($attn == 'ENGR') { //send email to ENGINEERING
			$to			= return_user_email_add($eng_first_take_qualified_by) == 'NONE' ? '' : return_user_email_add($eng_first_take_qualified_by);
			$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$cc 		= $from.','.(return_user_email_add($prdn_trained_by) == 'NONE' ? '' : return_user_email_add($prdn_trained_by));
		} else if($attn == 'QC') { //send email to QC
			/* Select recipients */
			$to			= return_user_email_add($qc_first_take_certified_by) == 'NONE' ? '' : return_user_email_add($qc_first_take_certified_by);
			$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$cc 		= $from.','.(return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username));
		} else if($attn == 'QC-APP') { //send email to QC
			/* Select recipients */
			$to			= return_user_email_add($qc_checked_by) == 'NONE' ? '' : return_user_email_add($qc_checked_by);
			$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$cc 		= $from.','.(return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username));
		} else if($attn == 'ADMIN') { //send email to ADMIN
			/* Select recipients */
			$to			= return_training_unit();
			$from 		= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
			$cc 		= $from;
		}
		// email testing
		// $body 		.= '<br><br>Recipients:<br>to: '.$to.'<br>from: '.$from.'<br>cc: '.$from.'<br>';
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc, $subject, $body,'','');
	}
	
	function send_email_cancelled($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_etr_training';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 				= $row['created_by'];
			$status 					= $row['status'];
			$username 					= $row['username'];
			$cancelled_by				= get_emp_name_by_username_systemone($row['username']);
			$training_title 			= $row['training_title'];
			$training_objective 		= $row['training_objective'];
			$line 						= $row['line'];
			$control_no 				= $row['control_no'];
			$series_name 				= $row['series_name'];
			$prdn_trained_by 			= $row['prdn_first_take_trained_by'];
			$prdn_first_take_trained_by = get_emp_name_by_username_systemone($row['prdn_first_take_trained_by']);
			$prdn_first_take_date_time 	= $row['prdn_first_take_date_time'];
			$station_from 				= $row['station_from'];
			$station_to 				= $row['station_to'];
			$eng_first_take_qualified_by = $row['eng_first_take_qualified_by'];
			$eng_first_take_date_time 	 = $row['eng_first_take_date_time'];
			$qc_first_take_certified_by  = $row['qc_first_take_certified_by'];
			$cancelled_remarks  		 = $row['cancelled_remarks'];
		}
		$subject 	 = 'CANCELLED TRAINING/ORIENTATION: '.$training_title.' ('.$series_name.')'; 
		
		$body 	 	 = 'Please be informed that below training has been '.strtolower($status).' ('.$cancelled_by.'). <br>Reason of cancellation: '.$cancelled_remarks.'<br> <br>';
		$body 		.= 'Training details: <br>';
		$body 		.= '&emsp;Title: '.$training_title.' <br>';
		$body 		.= '&emsp;Objective: '.$training_objective.' <br>';
		$body 		.= '&emsp;Line: '.$line.' <br>';
		$body 		.= '&emsp;Control No.: '.$control_no.' <br>';
		$body 		.= '&emsp;Series Name: '.$series_name.' <br>';
		$body 		.= '&emsp;Station From: '.$station_from.' <br>';
		$body 		.= '&emsp;Station To: '.$station_to.' <br>';
		$body 		.= '&emsp;Trained by (Prod.): '.$prdn_first_take_trained_by.' <br>';
		
		$from 			= return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username);
		$to_array		= array();
		$to_array[]		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		if($status == 'CANCELLED BY PRODUCTION') { //send email to PRODUCTION
			$to_array[]		= return_user_email_add($prdn_trained_by) == 'NONE' ? '' : return_user_email_add($prdn_trained_by);
			if($prdn_first_take_date_time != '') {
				$to_array[]		= return_user_email_add($eng_first_take_qualified_by) == 'NONE' ? '' : return_user_email_add($eng_first_take_qualified_by);
			} 
			if($eng_first_take_date_time != '') {
				$to_array[]		= return_user_email_add($qc_first_take_certified_by) == 'NONE' ? '' : return_user_email_add($qc_first_take_certified_by);
			} 	
			$to				= implode(',',$to_array);
		} else if($status == 'CANCELLED BY ENGINEERING') { //send email to ENGINEERING
			$to_array[]		= return_user_email_add($qc_first_take_certified_by) == 'NONE' ? '' : return_user_email_add($qc_first_take_certified_by);
			
			$to_array[]		= return_user_email_add($eng_first_take_qualified_by) == 'NONE' ? '' : return_user_email_add($eng_first_take_qualified_by);
			$to				= implode(',',$to_array);
		}
		// email testing
		// $body 		.= '<br><br>Recipients:<br>to: '.$to.'<br>from: '.$from.'<br>cc: '.$from.'<br>';
		if($prdn_first_take_date_time != '') {
			$php_mailer = new email();
			$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
		}		
	}
	
	function add_qc_training() {
        require_once('../class/oop_tqts.php');		
		$date_time_today              = date('Y-m-d H:i:s');
        $return                       = $_POST;
        $pkid                   	  = $_POST['pkid'];
        $username                     = $_POST['username'];
        $status                  	  = $_POST['status'];
        $qc_first_take_certified_by  = $_POST['qc_first_take_certified_by'];
        $qc_first_take_date_time 	  = $_POST['qc_first_take_date_time'];
        $qc_second_take_certified_by = isset($_POST['qc_second_take_certified_by']) ? $_POST['qc_second_take_certified_by'] : '';
        $qc_second_take_date_time    = $_POST['qc_second_take_date_time'];
        $qc_checked_by    			 = $_POST['qc_checked_by'];
        
        //added fields from Approver module 2019 05 31 req by ms cnpoblete
		// require_once('../class/oop_tqts.php');
		// $date_time_today    = date('Y-m-d H:i:s');
		// $username			= $_POST["username"];
		// $pkid 				= $_POST["pkid"];
		// $status				= $_POST["status"];
		// $remarks			= $_POST["remarks"];	
		// // $cby_field			= $_POST["checked_by_field"];		
		// $logs_field 		= $_POST["checked_by_logs_field"];		
		// $app_logs	 		= $_POST["app_status"] . '|'.$date_time_today . '|'.$remarks;		
		// $table  			= "tbl_etr_training";
		// $array_fields 		= array('status', $logs_field, 'lastupdate', 'username');
		// $array_values 		= array($status, $app_logs, $date_time_today, $username);
		// $msg				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		// $script 		    = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$remarks = '';
		$app_logs	 		= 'APPROVED' . '|'.$date_time_today . '|'.$remarks;//always approve since there is no longer approver


        //-----

        $table 						  = "tbl_etr_training";

		// $array_fields 				  = array('status','qc_first_take_certified_by', 'qc_first_take_date_time', 'qc_second_take_certified_by', 'qc_second_take_date_time','qc_checked_by','qc_checked_by_logs','lastupdate', 'username');//orig
		// $array_values 				  = array($status, $qc_first_take_certified_by, $qc_first_take_date_time, $qc_second_take_certified_by, $qc_second_take_date_time, $qc_checked_by,'PENDING||',$date_time_today, $username);//orig

		$array_fields 				  = array('status','qc_first_take_certified_by', 'qc_first_take_date_time', 'qc_second_take_certified_by', 'qc_second_take_date_time','qc_checked_by','qc_checked_by_logs','lastupdate', 'username');//novs edit 2019 05 31
		$array_values 				  = array($status, $qc_first_take_certified_by, $qc_first_take_date_time, $qc_second_take_certified_by, $qc_second_take_date_time, $username,$app_logs,$date_time_today, $username);//novs edit 2019 05 31

		$result						  = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 					  = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		$msg						  = '';
		if(isset($_POST['operator_name'])) {
			$table_details	 		  = 'tbl_etr_training_employees';
			$details_pkid 			  = isset($_POST['details_pkid']) ? explode(',', (implode(',', $_POST['details_pkid']))) : '';
			$operator_name 			  = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_name']))) : '';
			$operator_en 			  = isset($_POST['operator_en']) ? explode(',', (implode(',', $_POST['operator_en']))) : '';
			$qc_first_take_observation_interview_result  	= isset($_POST['qc_first_take_observation_interview_result']) ? explode(',', (implode(',', $_POST['qc_first_take_observation_interview_result']))) : '';
			$qc_second_take_observation_interview_result  = isset($_POST['qc_second_take_observation_interview2']) ? explode(',', (implode(',', $_POST['qc_second_take_observation_interview2']))) : '';
			$qc_first_take_sample_checking_ok  	= isset($_POST['qc_first_take_sample_checking_ok']) ? explode(',', (implode(',', $_POST['qc_first_take_sample_checking_ok']))) : '';
			$qc_first_take_sample_checking_ng  	= isset($_POST['qc_first_take_sample_checking_ng']) ? explode(',', (implode(',', $_POST['qc_first_take_sample_checking_ng']))) : '';
			$qc_second_take_sample_checking_ok  = isset($_POST['qc_second_take_sample_checking_ok2']) ? explode(',', (implode(',', $_POST['qc_second_take_sample_checking_ok2']))) : '';
			$qc_second_take_sample_checking_ng  = isset($_POST['qc_second_take_sample_checking_ng2']) ? explode(',', (implode(',', $_POST['qc_second_take_sample_checking_ng2']))) : '';
			$qc_first_take_overall_assessment  	= isset($_POST['qc_first_take_overall_assessment2']) ? explode(',', (implode(',', $_POST['qc_first_take_overall_assessment2']))) : '';
			$qc_second_take_overall_assessment  = isset($_POST['qc_second_take_overall_assessment2']) ? explode(',', (implode(',', $_POST['qc_second_take_overall_assessment2']))) : '';
			$qc_reason_for_disqualification 	= isset($_POST['qc_reason_for_disqualification']) ? explode(',', (implode(',', $_POST['qc_reason_for_disqualification']))) : '';
			
			foreach($operator_en as $key => $operator_empno) { 
				if($details_pkid[$key] != 0) {
					$array_fields 	 = array('qc_first_take_observation_interview_result', 'qc_second_take_observation_interview_result', 'qc_first_take_sample_checking_ok', 'qc_first_take_sample_checking_ng', 'qc_second_take_sample_checking_ok', 'qc_second_take_sample_checking_ng', 'qc_first_take_overall_assessment', 'qc_second_take_overall_assessment', 'qc_reason_for_disqualification', 'lastupdate', 'username');
					$array_values 	 = array($qc_first_take_observation_interview_result[$key], $qc_second_take_observation_interview_result[$key], $qc_first_take_sample_checking_ok[$key], $qc_first_take_sample_checking_ng[$key], $qc_second_take_sample_checking_ok[$key], $qc_second_take_sample_checking_ng[$key], $qc_first_take_overall_assessment[$key], $qc_second_take_overall_assessment[$key], $qc_reason_for_disqualification[$key],$date_time_today,$username);
					$msg 			 = TQTS::getInstance()->update_query($table_details,$array_fields,$array_values,$details_pkid[$key]);
					$script 		.= TQTS::getInstance()->update_query_script($table_details,$array_fields,$array_values,$details_pkid[$key]);
				}
			}
			if((!in_array("PASSED", $qc_second_take_overall_assessment)) && (!in_array("", $qc_second_take_overall_assessment))) {
				if($_POST['status'] != 'DRAFT QC') {
					update_status($pkid, 'FAILED QC');
				} 
			}
		}
        send_email_for_approval($pkid, 'QC-APP', 'new');
        $return['msg']           = $msg;
        $return['script']        = $script;
        echo json_encode($return);
    }
	
	function save_data_hris_etr() {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		
		$date_time_today    = date('Y-m-d H:i:s');
        $return             = $_POST;
        $pkid               = $_POST['pkid'];
        $username           = $_POST['username'];
        
        $table 				= "tbl_etr_training";
		$array_fields 		= array('status','lastupdate', 'username');
		$array_values 		= array("POSTED", $date_time_today, $username);
		$result				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
		
		$array_fields 		= array('*');
		$joins 	   			= '';
		$sql_where 			= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 			= '';
		$sql_limit 			= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$training_title 	= $row['training_title'];
			$training_objective = $row['training_objective'];
			$venue 				= $row['venue'];
			$period_from 		= date('Y-m-d', strtotime($row['prdn_first_take_date_time']));
			$period_to	 		= date('Y-m-d', strtotime($row['qc_first_take_date_time']));
			$mechanics 			= $row['mechanics'];
			$trainor 			= get_emp_name_by_username_systemone($row['prdn_first_take_trained_by']);
			$type_of_training 	= $row['type_of_training'];
			
			/* Insert into SystemOne ETR */
			$division			= return_system_division();
			$table_sys1			= "db_hris.tbl_Training_TQTS"; //test only
			// $table_sys1			= "db_hris.tbl_Training";
			$array_fields_sys1 	= array('DateCreated', 'lastupdate', 'Title', 'Objective', 'Venue', 'PeriodFrom', 'PeriodTo', 'Mechanics', 'Trainor', 'TypeTraining', 'logdel', 'Username','SavedFROM');
			$array_values_sys1 	= array($date_time_today, $date_time_today, $training_title, $training_objective, $venue, $period_from, $period_to, $mechanics, $trainor, $type_of_training, "2", $username, 'TQTS '.$division.':pkid'.$pkid);
			$sys1_pkid			= SYSTEMONE::getInstance()->insert_query_id($table_sys1,$array_fields_sys1,$array_values_sys1);
			$script 		   .= SYSTEMONE::getInstance()->insert_query_script($table_sys1,$array_fields_sys1,$array_values_sys1);
		}
		
		$array_fields 		= array('*');
		$table 	   			= 'tbl_etr_training_employees';
		$joins 	   			= '';
		$sql_where 			= 'WHERE fketr="'.$pkid.'" AND (`qc_first_take_overall_assessment`="PASSED" OR `qc_second_take_overall_assessment`="PASSED") AND logdel=0';
		$sql_order 			= '';
		$sql_limit 			= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$etr_id 			= $row['pkid'];
			$empno 				= $row['employee_no'];
			$training_result 	= $row['qc_first_take_overall_assessment'] == 'FAILED' ? ucfirst($row['qc_second_take_overall_assessment']) : ucfirst($row['qc_first_take_overall_assessment']);
			$training_remarks 	= $row['qc_first_take_overall_assessment'] == 'FAILED' ? 'Passed on 2nd take' : 'n/a';
			
			/* Update status_hris_etr before posting */
			$array_fields 		= array('status_hris_etr','lastupdate', 'username');
			$array_values 		= array("1", $date_time_today, $username);
			$msg				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
			$script 		   .= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
			
			/* Insert into SystemOne ETR */
			$fkEmployee			= return_sys1_fkemployee($empno);
			$table_sys1			= "db_hris.tbl_Trainee_TQTS";
			$array_fields_sys1 	= array('lastupdate', 'fkTraining', 'fkEmployee', 'Result', 'Remarks', 'logdel');
			$array_values_sys1 	= array($date_time_today, $sys1_pkid, $fkEmployee, $training_result, $training_remarks, 0);
			$sys1_pkid			= SYSTEMONE::getInstance()->insert_query_id($table_sys1,$array_fields_sys1,$array_values_sys1);
			$script 		   .= SYSTEMONE::getInstance()->insert_query_script($table_sys1,$array_fields_sys1,$array_values_sys1);
		}
		
		$return['msg']        = $msg;
		$return['script']     = $script;
        echo json_encode($return);
	}
	
	function return_sys1_fkemployee($empno) {
		require_once('../class/oop_tqts.php');
		$emp_id			= 'Not found!';
		$array_fields 	= array('emp_id','emp_type');
		$table			= 'db_systemone_views.vw_pmi_subcon_operators';
		$joins			= '';
		$sql_where		= 'WHERE empno="'.$empno.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)) {
			$emp_id = $row['emp_type'] == 'SUB' ? 'SUB'. $row['emp_id'] : $row['emp_id'];
		}
		return $emp_id;
	}
	
	function return_training_unit() {
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('user');
		$table			= 'vw_user_roles';
		$joins			= '';
		$sql_where		= 'WHERE `subsystem_code`="ETR" AND `module`="ETR-Training Unit" AND `read`=1';
		$sql_order		= '';
		$sql_limit		= '';
		$recipients		= array();
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)) {
			$recipients[] = return_user_email_add($row['user']) == 'NONE' ? '' : return_user_email_add($row['user']);
		}
		$recipients = implode(',',$recipients);
		return $recipients;
	}
	
	
	function return_empno_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('EmpNo');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE EmpNo LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['EmpNo'].'" value="'.$row['EmpNo'].'">'.$row['EmpNo'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function return_empname_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('EmpName');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE EmpName LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['EmpName'].'" value="'.$row['EmpName'].'">'.$row['EmpName'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function return_firstname_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('FirstName');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE FirstName LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['FirstName'].'" value="'.$row['FirstName'].'">'.$row['FirstName'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function return_lastname_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('LastName');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE LastName LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['LastName'].'" value="'.$row['LastName'].'">'.$row['LastName'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function return_middlename_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('MiddleName');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE MiddleName LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['MiddleName'].'" value="'.$row['MiddleName'].'">'.$row['MiddleName'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function return_position_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('DISTINCT(Position)');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE Position LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['Position'].'" value="'.$row['Position'].'">'.$row['Position'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	function return_department_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('DISTINCT(Department)');
		$table			= $_POST['db'].'vw_employeeinfo';
		$joins			= '';
		$sql_where		= 'WHERE Department LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,5';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script			= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option data-id="'.$row['Department'].'" value="'.$row['Department'].'">'.$row['Department'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function return_certified_operators() {
		require_once('../class/oop_tqts.php');
		$pkid 					= $_POST["pkid"];
		
		$table  						= "tbl_etr_training";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){
			$return['series_name']	= $row['series_name'];
			$prdn_date_train		= $row['prdn_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['prdn_first_take_date_time']));
			$prdn_instructor		= get_emp_name_by_username_systemone($row['prdn_first_take_trained_by']);
			$engr_date_train		= $row['eng_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['eng_first_take_date_time']));
			$engr_instructor		= get_emp_name_by_username_systemone($row['eng_first_take_qualified_by']);
			$qc_date_train			= $row['qc_first_take_date_time'] == '' ? '' : date('M d, Y', strtotime($row['qc_first_take_date_time']));
			$qc_instructor			= get_emp_name_by_username_systemone($row['qc_first_take_certified_by']);
		}
		
		$tbl_body				= '';
		$ctr					= 1;
		$table_details  		= "tbl_etr_training_employees";
		$array_fields			= array("*");
		$joins  	 			= "";
		// $sql_where  			= "WHERE `fketr` = '$pkid' AND logdel=0 AND (`qc_first_take_overall_assessment`='PASSED' OR `qc_second_take_overall_assessment`='PASSED') ";//before, 2019-5-6
		$sql_where  			= "WHERE `fketr` = '$pkid' AND logdel=0 ";
		$sql_order  			= "";
		$sql_limit  			= "";
		$result        			= TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		$script        			= TQTS::getInstance()->select_query_script($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows == 0) {
			$return['data_1']	= 'NO DATA';
			$tbl_body	 = '<tr>';
			$tbl_body  .= '	<td colspan="9"><center>No data found!</center></td>';
			$tbl_body  .= '</tr>';
		} else {
			while($row = mysqli_fetch_assoc($result)){		
				$operators_name 		= $row['operators_name'];
				$employee_no 			= $row['employee_no'];
				$return['station_to'] 	= $row['station_to'];
				
				/* Return certified operators */
				$tbl_body	.= '<tr>';
				$tbl_body  .= '	<td><center>'.$ctr++.'</center></td>';
				$tbl_body  .= '	<td>'.$operators_name.'</td>';
				$tbl_body  .= '	<td><center>'.$employee_no.'</center></td>';
				$tbl_body  .= '	<td><center>'.$prdn_date_train.'</center></td>';
				$tbl_body  .= '	<td><center>'.$qc_date_train.'</center></td>';
				$tbl_body  .= '	<td><center>'.$prdn_instructor.'</center></td>';
				$tbl_body  .= '	<td><center>'.$engr_instructor.'</center></td>';
				$tbl_body  .= '	<td><center>'.$qc_instructor.'</center></td>';
				$tbl_body  .= '</tr>';
				$return['tbl_body']		= $tbl_body;
			}
		}
		$return['script'] = $script;
		echo json_encode($return);
	}
		
	function update_prdn_eng_approval_logs() {
		require_once('../class/oop_tqts.php');
		$date_time_today    = date('Y-m-d H:i:s');
		$username			= $_POST["username"];		
		$pkid 				= $_POST["pkid"];		
		$status				= $_POST["status"];		
		$remarks			= $_POST["remarks"];		
		// $cby_field			= $_POST["checked_by_field"];		
		$logs_field 		= $_POST["checked_by_logs_field"];		
		$app_logs	 		= $_POST["app_status"] . '|'.$date_time_today . '|'.$remarks;		
		$table  			= "tbl_etr_training";
		$array_fields 		= array('status', $logs_field, 'lastupdate', 'username');
		$array_values 		= array($status, $app_logs, $date_time_today, $username);
		$msg				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$script 		    = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
			
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	
	
?>