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
				case "return_empno_by_username"					: return_empno_by_username(); break;
				case "save_exam"								: save_exam(); break;
				case "update_exam"								: update_exam(); break;
				case "return_exam_details"						: return_exam_details(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function return_empno_by_username() {
		require_once('../class/oop_tqts.php');	
		$username    	 = $_POST['username'];
		$emp_info 		 = get_emp_info_by_username_systemone($username);
		$return['empno'] = $emp_info['EmpNo'];		
		echo json_encode($return);
	}
	
	function save_exam() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_theoretical_exam";
		$values 					= get_fields_values($_POST,array("action","username","date_exam"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "date_exam"; 			$array_values[] = date("Y-m-d");
		$array_fields[] 			= "take_type"; 			$array_values[] = return_take_type($_POST['empno']);
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		$pkid 						= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		
		if($_POST['status'] == 'FOR CHECKING') {
			send_email_lqc_supervisor($pkid);
		}
		
		$return['msg'] 	= 'New record has been saved'.$msg;
		$return['POST'] 	= $_POST;
		echo json_encode($return);
	}
	
	function update_exam() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$pkid    		 = $_POST['pkid'];
		$username    	 = $_POST['username'];
		$msg			 = '';		
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_theoretical_exam";
		$values 					= get_fields_values($_POST,array("action","username", "pkid","series_name_points", "defect_points", "brief_desc_points", "state_points"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "date_exam"; 			$array_values[] = date("Y-m-d", strtotime($_POST['date_exam']));
		$array_fields[] 			= "lastupdate"; 		$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 			$array_values[] = $username;
		
		if($_POST['status'] == 'CHECKED') {
			$array_fields[] 			= "checked_by"; 			$array_values[] = $username;
			$array_fields[] 			= "date_time_checked"; 		$array_values[] = date("Y-m-d H:i:s");
			$array_fields[] 			= "exam_result"; 			$array_values[] = return_exam_result($pkid);
		}
		$msg 						= TQTS::getInstance()->update_query($table,$array_fields,$array_values, $pkid);
		$script 					= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values, $pkid);
		
		
		
		$return['msg'] 	= $msg;
		$return['script'] 	= $script;
		$return['POST'] 	= $_POST;
		echo json_encode($return);
	}
	
	function send_email_lqc_supervisor($pkid) {
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email.php');
		/* Select the report information */
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_theoretical_exam';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0, 1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by 		= $row['created_by'];
			$date_exam 			= date('M d, Y',strtotime($row['date_exam']));
			$empno 				= $row['empno'];
			$emp_info 		 	= get_emp_info_by_username_systemone($created_by);
			$empname			= $emp_info['firstname'].' '.$emp_info['lastname'];		
			$take_type 			= $row['take_type'];
			$series_name 		= $row['series_name'];
			$defect				= $row['defect'];
			$brief_desc			= $row['brief_desc'];
			$state 		   		= $row['state'];
		}
		
		$subject 	 = 'FOR CHECKING EXAM: '.$empno.' ('.$take_type.')';
		
		$body 	 	 = 'Please be informed that you have Customer Claim Theoretical Exam for checking.<br> <br>';
		$body 		.= 'Details: <br>';
		$body 		.= '&emsp;Date Exam: '.$date_exam.' <br>';
		$body 		.= '&emsp;Emp No: '.$empno.' <br>';
		$body 		.= '&emsp;Emp Name: '.$empname.' <br>';
		$body 		.= '&emsp;Series Name: '.$series_name.' <br>';
		$body 		.= '&emsp;Defect: '.$defect.' <br>';
		
		/* Select recipients */
		$lqc_supervisor = return_lqc_supervisor();
		$to			= $lqc_supervisor['email'];
		$from 		= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $from, $subject, $body,'','');
	}
	
	function return_exam_details() {
		require_once('../class/oop_tqts.php');	
		$pkid    	 = $_POST['pkid'];
		$table  		= "tbl_theoretical_exam";
		$array_fields	= array("*");
		$joins  	 	= "";
		$sql_where  	= "WHERE `pkid` = '$pkid'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
		}	
		$table  		= "tbl_theoretical_points";
		$array_fields	= array("*");
		$joins  	 	= "";
		$sql_where  	= "WHERE logdel=0";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			$return['points'] = $row;
		}		
		echo json_encode($return);
	}
	
	function return_take_type($empno) {
		require_once('../class/oop_tqts.php');	
		$table  		= "tbl_theoretical_exam";
		$array_fields	= array("take_type", "exam_result");
		$joins  	 	= "";
		$sql_where  	= "WHERE `empno` = '$empno'";
		$sql_order  	= "ORDER BY pkid DESC";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			if($row['exam_result'] == 'PASSED') {
				return '1st take';
			} else {
				if($row['take_type'] == '1st take') {
					return '2nd take';
				} else if($row['take_type'] == '2nd take') {
					return '3rd take';
				} else {
					return '1st take';
				} 
			}
		} else {
			return '1st take';
		}
	}
	
	function return_lqc_supervisor() {
		require_once('../class/oop_tqts.php');	
		$table  		= "vw_user_roles";
		$array_fields	= array("user");
		$joins  	 	= "";
		$sql_where  	= "WHERE `module` = 'Customer Claim Theoretical Exam - Admin' AND `read`='1' AND `update`='1' AND logdel=0";
		$sql_order  	= "";
		$sql_limit  	= "";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$lqc_supervisor = array();
		while($row = mysqli_fetch_assoc($result)){
			$lqc_supervisor['users'][] = $row['user'];
			$lqc_supervisor['email'][] = return_user_email_add($row['user']);
		}
		$lqc_supervisor['users'] = implode(',', $lqc_supervisor['users']);
		$lqc_supervisor['email'] = implode(',', $lqc_supervisor['email']);
		return $lqc_supervisor;
	}
	
	function return_exam_result($pkid) {
		require_once('../class/oop_tqts.php');	
		$table  		= "tbl_theoretical_exam,tbl_theoretical_points";
		$array_fields	= array("(`series_name_score` +  `defect_score` + `brief_desc_score` + `state_score`) as total_score", "(`series_name_points` + `defect_points` + `brief_desc_points` + `state_points`) as total_points");
		$joins  	 	= "";
		$sql_where  	= "WHERE tbl_theoretical_exam.pkid='$pkid' AND tbl_theoretical_exam.logdel=0 AND tbl_theoretical_points.logdel=0";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)){
			if( (($row['total_score'] / $row['total_points']) * 100) == 100) {
				return "PASSED";
			} else {
				return "FAILED";
			}
		} 
	}
?>