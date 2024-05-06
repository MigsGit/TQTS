<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	/* ***************************************
		List of functions
		Common:
			get_user_roles
			get_fields_values
			return_file_path_by_div_mod
			get_table_fields
			get_table_fields_seiko_subsystem
			get_table_fields_ptis
			get_part_name_by_code2
			return_approver_name_by_username
			return_system_division
			return_user_email_add
			get_emp_name_by_username
			get_emp_name_by_username_systemone
			get_emp_name_by_email_add_systemone
			get_emp_info_by_username_systemone
			get_file_name_and_rev_from_table
			remove_specific_string_pattern
			add_three_days_without_sunday
			get_field_names
			get_field_text_display
			display_approvers_log
		Excel
			get_excel_content
			remove_none_english_characters
		YPICS 4
			get_series_name
			get_po_number_list
		MAILER
			send_with_mailer
			send_with_mailer_with_attachment
			send_with_auto_mailer
			close_auto_mailer
	*******************************************/
	
	function get_user_roles($username){
		$oop = '../../class/oop_user_roles.php';
		if(!file_exists($oop)){
			echo '<br><br><br>
					<h1><center>OOP does not exist!</center>
				  </h1>';
			exit;
		}else{
			require_once($oop);
		}
		// session_start();
		// $username = $_SESSION['username'];
		$array_fields 	= array('`subsystem`.`subsystem_code`','`module`.`module`','`subsystem`.`pkid`','`roles`.*');
		$table 			= 'tbl_user_roles `roles`';
		$joins			= 'INNER JOIN `tbl_module` `module` ON `module`.`pkid` = `roles`.`fk_module`
						   INNER JOIN `tbl_subsystem` `subsystem` ON `module`.`fk_subsystem` = `subsystem`.`pkid`';
		$sql_where		= "WHERE `roles`.`user` = '$username' AND `roles`.`logdel` = '0' ";
		$sql_order		= '';
		$sql_limit		= '';
		$result = ROLES::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = ROLES::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$user_role = array(
			"pkid"			=> array(),
			"subsystem_code"=> array(),
			"fk_module"		=> array(),
			"module"		=> array(),
			"user"			=> array(),
			"section"		=> array(),
			"role"			=> array(),
			"create"		=> array(),
			"read"			=> array(),
			"update"		=> array(),
			"delete"		=> array()
		);
		while($row = mysqli_fetch_array($result)){
			$user_role['pkid'][] 			= $row['pkid'];
			$user_role['subsystem_code'][] 	= $row['subsystem_code'];
			$user_role['fk_module'][] 		= $row['fk_module'];
			$user_role['module'][] 			= $row['module'];
			$user_role['user'][] 			= $row['user'];
			$user_role['section'][] 		= $row['section'];
			$user_role['role'][] 			= $row['role'];
			$user_role['create'][] 			= $row['create'];
			$user_role['read'][] 			= $row['read'];
			$user_role['update'][] 			= $row['update'];
			$user_role['delete'][] 			= $row['delete'];
		}
		return $user_role;
	}
	
	function get_fields_values($passed_param,$excluded_value){
		 $array_fields = array();
		 $array_values = array();
		 foreach($passed_param as $key => $value){
			if(in_array($key,$excluded_value)){
				continue;
			}
			$array_fields[] = $key;
			if(is_array($value)){
				$array_values[] = implode(',',$value);
			}else{
				$array_values[] = $value;
			}
		}
		$return = array();
		$return['array_fields'] = $array_fields;
		$return['array_values'] = $array_values;
		return $return;
	}
	 
	function return_file_path_by_div_mod($module) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('pkid','file_path');
		$table 	   	= 'tbl_file_path';
		$joins 	   	= '';
		$sql_where 	= 'WHERE module="'.$module.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$file  = array();
		if($row = mysqli_fetch_array($result)){
			$file['pkid'] 		= $row['pkid'];
			$file['path'] 		= $row['file_path'];
		}
		return $file;		
	}
	function return_file_path_by_div_mod_qfr_sa($module) {
		require_once('../../../class/oop_tqts.php');
		$array_fields = array('pkid','file_path');
		$table 	   	= 'tbl_file_path';
		$joins 	   	= '';
		$sql_where 	= 'WHERE module="'.$module.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$file  = array();
		if($row = mysqli_fetch_array($result)){
			$file['pkid'] 		= $row['pkid'];
			$file['path'] 		= $row['file_path'];
		}
		return $file;		
	}
	
	function get_table_fields($table){
		require_once('../class/oop_tqts.php');
		$result    = TQTS::getInstance()->get_table_fields($table);
		$fields = array();
		while($row = mysqli_fetch_array($result)){
			$fields[] = $row[0];
		}
		return $fields;
	}
	
	function get_table_fields_seiko_subsystem($table){
		require_once('../class/oop_tqts.php');
		$result    = SEIKODB::getInstance()->get_table_fields($table);
		$fields = array();
		if(!$result){
			return mysqli_error($result);
		}else{
			while($row = mysqli_fetch_array($result)){
				$fields[] = $row[0];
			}
		}
		return $fields;
	}
	
	function get_table_fields_ptis($table){
		require_once('../class/oop_tqts.php');
		$result    = PTIS::getInstance()->get_table_fields($table);
		$fields = array();
		while($row = mysqli_fetch_array($result)){
			$fields[] = $row[0];
		}
		return $fields;
	}
	
	function get_part_name_by_code2($part_code) {
		require_once('../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$array_fields 	= array("NAME");
		$table 			= "VHEAD";
		$joins 			= "";
		$sql_where 		= "WHERE CODE='$part_code'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$part_name = $row['NAME'];
		} else {
            $part_name = '';
        }
		return $part_name;
	}
	
	function return_approver_name_by_username($approver_username) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('approver_name');
		$table 	   	= 'tbl_report_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE approver_username="'.$approver_username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			return $row['approver_name'];
		} else {
			return '-';
		}
	}
		
	function return_system_division() {
		if(file_exists('../class/oop_tqts.php')) {
			require_once('../class/oop_tqts.php');
		} else {
			require_once('../../class/oop_tqts.php');
		}		
		$array_fields = array('division_name');
		$table      = 'tbl_division';
		$joins      = '';
		$sql_where  = '';
		$sql_order  = '';
		$sql_limit  = 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			return $row['division_name'];
		} else {
			return 'N/A';
		}
	 }
	 
	function return_user_email_add($username) {
		require_once('../class/oop_tqts.php');
		/* Check first if employee has email address to Rapid database. If none, get the email address to SystemOne. Else, display empty. */
		$result = "";
		$array_fields = array('email_add','emp_type');
		$table 	   	= 'db_rapid.tbl_useraccounts';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows != 0) {
			if($row = mysqli_fetch_array($result)){
				$email_add = $row['email_add'];
				$emp_type  = $row['emp_type'];
				if($emp_type == 'Pricon Employee' && $email_add == '') {
					/* Get the email address to SystemOne and update the record to Rapid database */
					$array_fields2 = array('email_add');
					$table2 	   	= 'db_acl.tbl_useraccnt';
					$joins2 	   	= '';
					$sql_where2 	= 'WHERE username="'.$username.'"';
					$sql_order2 	= '';
					$sql_limit2 	= 'LIMIT 0,1';
					$result2 = SYS1::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
					if($row2=mysqli_fetch_array($result2)) {
						$email_add = $row2['email_add'];
					} else {
						$email_add = 'NONE';
					}
				} else if($emp_type == 'Pricon Employee' && $email_add != '') {
					$email_add = $row['email_add'];
				} else if($emp_type == 'Subcon Hired' && $email_add == '') {
					$email_add = 'NONE';
				} else {
					$email_add = $row['email_add'];
				}
			}
		} else {
			$email_add = 'NONE';
		}
		return $email_add;
	}
	
	function get_emp_name_by_username($username) {
		
		if(file_exists('../class/oop_tqts.php')) {
			require_once('../class/oop_tqts.php');
		} else {
			require_once('../../class/oop_tqts.php');
		}
		$emp_name		= 'Not found!';
		$array_fields 	= array('`name` as emp_name');
		$table			= 'tbl_useraccounts';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script			= RAPID::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$emp_name = $row['emp_name'];
		}
		// return $script;
		return $emp_name;
		//SELECT SQL_CALC_FOUND_ROWS `name` as emp_name FROM tbl_useraccounts WHERE username="ritamor" LIMIT 0,1;
	}

	function get_emp_name_by_username_systemone($username) {
		if(file_exists('../class/oop_tqts.php')) {
			require_once('../class/oop_tqts.php');
		} else {
			require_once('../../class/oop_tqts.php');
		}
		$emp_name		= 'Not found!';
		$array_fields 	= array('CONCAT(`firstName`," ",`lastname`) as emp_name');
		$table			= 'vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$emp_name = $row['emp_name'];
		} else {
			$array_fields 	= array('`name` as emp_name');
			$table			= 'db_rapid.tbl_useraccounts';
			$joins			= '';
			$sql_where		= 'WHERE username="'.$username.'"';
			$sql_order		= '';
			$sql_limit		= 'LIMIT 0,1';
			$html_select	= '';
			$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			// $emp_name			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$emp_name = $row['emp_name'];
			}
		}
		return $emp_name;
	}

	function get_emp_name_by_email_add_systemone($email_add) {
		require_once('../class/oop_tqts.php');
		$emp_name		= $email_add;
		$array_fields 	= array('CONCAT(`firstName`," ",SUBSTRING(  `middlename` , 1, 1 ),". ",`lastname`) as emp_name');
		$table			= 'vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE email_add="'.$email_add.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$emp_name = $row['emp_name'];
		}
		return $emp_name;
	}
	
	function get_emp_info_by_username_systemone($username) {
		require_once('../class/oop_tqts.php');
		$emp_info		= array();
		$array_fields 	= array('*');
		$table			= 'vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_assoc($result)) {
			$emp_info = $row;
		}
		return $emp_info;
	}

	function get_file_name_and_rev_from_table($tbl_name,$field_name_filename,$field_name_rev,$pkid){
		require_once('../class/oop_tqts.php');
		$array_fields = array($field_name_filename,$field_name_rev);
		$table      = $tbl_name;
		$joins      = '';
		$sql_where  = 'WHERE pkid = "'.$pkid.'"';
		$sql_order  = '';
		$sql_limit  = 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row = array();
		if($row=mysqli_fetch_assoc($result)) {
			return $row;
		} else {
			return $row[] = 'No File Found';
		}
	}
	
	function return_esign_by_username($username) {
		if(file_exists('../class/oop_tqts.php')) {
			require_once('../class/oop_tqts.php');
		} else if(file_exists('../../class/oop_tqts.php')){
			require_once('../../class/oop_tqts.php');
		}else{
			require_once('../../../class/oop_tqts.php');
		}
		$empno		= 'Not found!';
		$array_fields 	= array('EmpNo');
		$table			= 'vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$empno = $row['EmpNo'];
		} else {
			$array_fields 	= array('EmpNo');
			$table			= 'db_rapid.tbl_useraccounts';
			$joins			= '';
			$sql_where		= 'WHERE username="'.$username.'"';
			$sql_order		= '';
			$sql_limit		= 'LIMIT 0,1';
			$html_select	= '';
			$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			// $emp_name			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$empno = $row['EmpNo'];
			}
		}
		
		/* Check if e-sign already exists */
		if(file_exists('../../../ACDCS/e_signatures/'.$empno.'.png')) {
			return '../../../ACDCS/e_signatures/'.$empno.'.png';
		} else {
			return '../../../ACDCS/e_signatures/default.png';
		}		
	}
	function return_esignature_sar($username) {
		if(file_exists('../class/oop_tqts.php')) {
			require_once('../class/oop_tqts.php');
		} else if(file_exists('../../class/oop_tqts.php')){
			require_once('../../class/oop_tqts.php');
		}else{
			require_once('../../../class/oop_tqts.php');
		}
		$empno		= 'Not found!';
		$array_fields 	= array('EmpNo');
		$table			= 'vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$empno = $row['EmpNo'];
		} else {
			$array_fields 	= array('EmpNo');
			$table			= 'db_rapid.tbl_useraccounts';
			$joins			= '';
			$sql_where		= 'WHERE username="'.$username.'"';
			$sql_order		= '';
			$sql_limit		= 'LIMIT 0,1';
			$html_select	= '';
			$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			// $emp_name			= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$empno = $row['EmpNo'];
			}
		}
		
		/* Check if e-sign already exists */
		if(file_exists('../../ACDCS/e_signatures/'.$empno.'.png')) {
			return '../../ACDCS/e_signatures/'.$empno.'.png';
		} else {
			return '../../ACDCS/e_signatures/default.png';
		}		
	}
	
	function display_approvers_log($status, $date_time_approved, $approver_username, $remarks) {
		require_once('common_handler.php');
		$status				= $status == '' ? '-'  : $status;
		if($status == 'PENDING') {
			$approvers_log 		= ($approver_username == '' ? '' : get_emp_name_by_username_systemone_rapid($approver_username)).' <b>[<i>PENDING</i>]</b><br>';
		} else {
			$date_time_approved = $date_time_approved == '' ? '' : '<i> - '.(date('M d, Y h:i:s A',strtotime($date_time_approved))).'</i>';
			// $date_time_approved = $date_time_approved == '' ? '' : '<i> - '.($date_time_approved).'</i>';
			$approvers_log 		= ($approver_username == '' ? '' : get_emp_name_by_username_systemone_rapid($approver_username)).' <b> ['.$status.$date_time_approved.']</b> '.$remarks.'<br>';
		}
		
		return $approvers_log;
	}
	
	/* Get The Excel Content */
	function get_excel_content($inputFileName,$max_row){
		/* 
			NOTE: This will only get data from A-Z to your max row,
			If you want to get the col AA above please change the for 2nd for loop
		*/
		$excel_content = array();
		if(!is_numeric($max_row) || $max_row <= 0){
			$excel_content['A1'] = "Incorrect max row value";
			return $excel_content;
		}		
		/* library for reading excel files */
		require_once( '../../media/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
		require_once( '../../media/PHPExcel-1.8/Classes/PHPExcel.php');
		/* Read your Excel workbook */
		/* try catch reading of excel file */
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
			/* catch error if excel file cannot be read */
			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		$sheet = $objPHPExcel->getSheet(0);
		/* get excel values */
		$row_ctr = 1;
		$col_ctr = 'A';
		for($x = $row_ctr; $x < $max_row; $x++){
			/* change this depending on what max column you want */
			for($y = $col_ctr; $y != 'Z'; $y++ ){
				$excel_content[$y.$x] = mb_convert_encoding($sheet->getCell($y.$x)->getValue(), "UTF-8");
				// $excel_content[$y.$x] = mb_convert_encoding($sheet->getCell($y.$x)->getFormattedValue(),"UTF-8", "EUC-JP");
			}			
		}
		return $excel_content;
	}
	
	/* Remove non-english characters */
	function remove_none_english_characters($str){
		$str = preg_replace('/[^\00-\255]+/u', '', $str);
		return $str;
	}
	
	/* Remove specific character */
	function remove_specific_string_pattern($str,$pattern){
		$str = str_replace($pattern,"",$str);
		return $str;
	}
	
	/* Remove specific character */
	function remove_specific_array_string_pattern($str,$array_pattern){
		foreach($array_pattern as $key => $pattern){
			$str = str_replace($pattern,"",$str);
		}
		return $str;
	}
	
	function add_three_days_without_sunday($date){
		$new_date = $date;
		$added_day = 0;
		while($added_day != 3){
			$new_date = date('Y-m-d',strtotime($new_date." + 1 day"));
			$day = date('D',strtotime($new_date." + 1 day"));
			if($day != 'Sun'){
				$added_day++;
			}
		}
		return $new_date;
	}
	
	function get_field_names($table,$excluded_value){
		require_once('../class/oop_tqts.php');
		$result = TQTS::getInstance()->get_table_fields($table);
		$fields = array();
		while($row = mysqli_fetch_assoc($result)){
			if(!in_array($row['Field'],$excluded_value)){
				$fields[] = $row['Field'];
			}
		}
		return $fields;
	}
	
	function get_field_text_display($field_name){
		require_once('../class/oop_tqts.php');
		$array_fields = array('text_display');
		$table      = 'tbl_field_text_display';
		$joins      = '';
		$sql_where  = 'WHERE `field_name` = "'.$field_name.'"';
		$sql_order  = '';
		$sql_limit  = 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$text_display = 'No assigned display text';
		if($row = mysqli_fetch_assoc($result)){
			$text_display = $row['text_display'];
		}
		return $text_display;
	}
	
	/************************************
		YPICS 4 Functions - START
	************************************/
	
	function get_series_name($po_num){
		require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $array_fields   = array("TOP 1 XRECE.SORDER","XRECE.CODE","XHEAD.NAME","XCUST.CNAME");
        $table          = "XRECE";
        $joins          = "INNER JOIN XHEAD ON XHEAD.CODE = XRECE.CODE 
						   LEFT JOIN XCUST ON XCUST.CUST = XRECE.CUST ";
        $sql_where      = "WHERE XRECE.SORDER = '$po_num'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $script         = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
        $ypics_data     = array(
								"po_number"		=> "",
								"device_code"	=> "",
								"device_name"	=> "",
								"customer"		=> ""
							    );
        while($row = mssql_fetch_array($result)){
			$ypics_data['po_number'] 	= $row['SORDER'];
			$ypics_data['device_code'] 	= $row['CODE'];
			$ypics_data['device_name'] 	= $row['NAME'];
			$ypics_data['customer'] 	= $row['CNAME'];
        }
        // return $script;
        return $ypics_data;
	}
	
	function get_po_number_list($pattern){
		require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $array_fields   = array("TOP 10 XRECE.SORDER");
        $table          = "XRECE";
        $joins          = "";
        $sql_where      = "WHERE XRECE.SORDER LIKE '%$pattern%' ";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $script         = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
        $po_number_list  = array();
        while($row = mssql_fetch_array($result)){
			$po_number_list[] 	= $row['SORDER'];
        }
        return $po_number_list;
	}
	
	function get_pono_invoiceno_list($pattern){
		require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $array_fields   = array("TOP 10 XSACT.PORDER");
        $table          = "XRECE";
        $joins          = "";
        $sql_where      = "WHERE XSACT.PORDER LIKE '%$pattern%' ";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $script         = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
        $list  = array();
        while($row = mssql_fetch_array($result)){
			$list[] 	= $row['PORDER'];
        }
        return $list;
	}
	
	/************************************
		YPICS 4 Functions - END
	************************************/

	/* ***************************
			Mailing Functions
	*****************************/
	function send_with_mailer($mail_data){
		require_once('../class/oop_mailer.php');
		$result = "";
		/* 
			Instructions for data values
			Array should contain the following data:
			1. to			= separator is comma
			2. cc			= separator is comma
			3. bcc			= separator is comma
			4. from			
			5. from_name
			6. subject
			7. message
			8. system_name
			9. send_date_time
		*/
		$table				 = 'tbl_mailer';
		$array_fields_values = get_fields_values($mail_data,array('username'));
		$array_fields		 = $array_fields_values['array_fields']; 
		$array_values		 = $array_fields_values['array_values']; 
		$array_fields[]		 = 'date_created'; $array_values[] = date('Y-m-d H:i:s');
		$array_fields[]		 = 'created_by'; $array_values[] = $mail_data['username'];
		$result = MAILER::getInstance()->insert_query($table,$array_fields,$array_values);
		$script = MAILER::getInstance()->insert_query_script($table,$array_fields,$array_values);
		return $result;
	}
	
	function send_with_mailer_with_attachment($mail_data){
		require_once('../class/oop_mailer.php');
		$result = "";
		/* 
			Instructions for data values
			Array should contain the following data:
			1. to			= separator is comma
			2. cc			= separator is comma
			3. bcc			= separator is comma
			4. from			
			5. from_name
			6. subject
			7. message
			8. attachment
			9. system_name
			10. send_date_time
		*/
		$table				 = 'tbl_mailer';
		$array_fields_values = get_fields_values($mail_data,array('username'));
		$array_fields		 = $array_fields_values['array_fields']; 
		$array_values		 = $array_fields_values['array_values']; 
		$array_fields[]		 = 'date_created'; $array_values[] = date('Y-m-d H:i:s');
		$array_fields[]		 = 'created_by'; $array_values[] = $mail_data['username'];
		$result = MAILER::getInstance()->insert_query($table,$array_fields,$array_values);
		$script = MAILER::getInstance()->insert_query_script($table,$array_fields,$array_values);
		return $result;
	}
	
	/* Scheduled e-mail */
	function send_with_auto_mailer($mail_data){
		require_once('../class/oop_mailer.php');
		$result = "";
		/* 
			Instructions for data values
			Array should contain the following data:
			1. to			= separator is comma
			2. cc			= separator is comma
			3. bcc			= separator is comma
			4. from			
			5. from_name
			6. subject
			7. message
			8. system_name
			9. send_date_time
		*/
		$table				 = 'tbl_auto_mailer';
		$array_fields_values = get_fields_values($mail_data,array('username'));
		$array_fields		 = $array_fields_values['array_fields']; 
		$array_values		 = $array_fields_values['array_values']; 
		$array_fields[]		 = 'date_created'; $array_values[] = date('Y-m-d H:i:s');
		$result = MAILER::getInstance()->insert_query($table,$array_fields,$array_values);
		$script = MAILER::getInstance()->insert_query_script($table,$array_fields,$array_values);
		return $script;
	}
	
	
	function close_auto_mailer($tbl_name,$fkid){
		require_once('../class/oop_mailer.php');
		$table		  = 'tbl_auto_mailer';
		$array_fields = array('logdel');
		$array_values = array('1');
		$where		  = "WHERE `fkid` = '".$fkid."' AND `table_name` = '".$tbl_name."'";
		$result = MAILER::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script = MAILER::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
		// return $script;
		return $result;
	}
	/* ***************************
			Mailing Functions
	*****************************/	
	
	/* ***************************
			YPICS 4.0 Subsystem
	*****************************/	
	function get_visual_inspection_data($date_start,$date_end){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*','num_of_defects as lot_rejected', 'date_inspected as date_inspected');
		$table			= 'oqc_inspections';
		$joins			= '';
		$sql_where		= '';
		$sql_order		= "WHERE `date_inspected` BETWEEN '$date_start' AND '$date_end' AND `submission`='1st'";
		$sql_limit		= '';
		$result = OQC::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row_data = array();
		while($row = mysqli_fetch_assoc($result)){
			$row_data[] = $row;
		}
		return $row_data;
	}
	
	// function get_iqc_visual_inspection_data($date_start,$date_end){
	// 	require_once('../class/oop_tqts.php');
	// 	$array_fields 	= array('*','no_of_defects as lot_rejected', 'date_ispected as date_inspected');
	// 	$table			= 'iqc_inspections';
	// 	$joins			= '';
	// 	$sql_where		= '';
	// 	$sql_order		= "WHERE `date_ispected` BETWEEN '$date_start' AND '$date_end' ";
	// 	$sql_limit		= '';
	// 	$result = OQC::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// 	$row_data = array();
	// 	while($row = mysqli_fetch_assoc($result)){
	// 		$row_data[] = $row;
	// 	}
	// 	return $row_data;
	// }
	function get_iqc_visual_inspection_data($date_start,$date_end){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*','no_of_defects as lot_rejected', 'date_ispected as date_inspected');
		$table			= 'iqc_inspections';
		$joins			= '';
		$sql_where		= "WHERE `date_ispected` BETWEEN '$date_start' AND '$date_end' AND `judgement` in ('accepted','rejected') AND `submission`='1st'";
		$sql_order		= '';
		$sql_limit		= '';
		$result = OQC::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row_data = array();
		while($row = mysqli_fetch_assoc($result)){
			$row_data[] = $row;
		}
		return $row_data;
		// $query = "SELECT supplier,
		// COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
		// COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
		// SUM(if(`judgement` in ('accepted','rejected') , sample_size, null)) as 'SAMPLES',
		// SUM(if(`judgement` in ('accepted','rejected') , `no_of_defects`, null)) as 'NG_QTY'
		// FROM `iqc_inspections` WHERE `date_ispected` BETWEEN '2022-09-23' AND '2022-09-29'
		// GROUP BY supplier" ;$array_fields = array('`user`');
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
			
	}
	
	function get_target_dppm($date){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('target_dppm');
		$table			= 'tbl_target_dppm';
		$joins			= '';
		$sql_where		= '';
		$sql_order		= "WHERE '$date' BETWEEN `date_start` AND `date_end` ";
		$sql_limit		= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$target_dppm = 0;
		if(!$result){
			return $target_dppm;
		}
		while($row = mysqli_fetch_assoc($result)){
			$target_dppm = $row['target_dppm'];
		}
		return $target_dppm;
	}
	
	function get_target_lar($date){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('target_lar');
		$table			= 'tbl_target_lar';
		$joins			= '';
		$sql_where		= '';
		$sql_order		= "WHERE '$date' BETWEEN `date_start` AND `date_end` ";
		$sql_limit		= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$target_lar = 0;
		if(!$result){
			return $target_lar;
		}
		while($row = mysqli_fetch_assoc($result)){
			$target_lar = $row['target_lar'];
		}
		return $target_lar;
	}

	//novs
	function send_with_auto_mailer2($db_name,$tbl_name, $fkid, $system_name, $from, $from_name, $address, $reply_to, $cc, $bcc,$attachment,$attachment_name, $subject, $body, $created_by, $date_time_created,$date_time_first_sent,$date_time_last_sent,$frequency,$interval,$sent_count,$sent_count_limit,$week_start,$skip_days){
		require_once('../class/oop_mailer2.php');
		$result = "";
		/* 
			Instructions for data values
			Array should contain the following data:
			1. to			= separator is comma
			2. cc			= separator is comma
			3. bcc			= separator is comma
			4. from			
			5. from_name
			6. subject
			7. message
			8. system_name
			9. send_date_time
		*/

			//2021-03-12 req by mam rita to temporarily disable the auto email, i added logdel 1 - novs
		$table				 = 'tbl_auto_mailer';
		$array_fields		 = array(
			'`db_name`',
			'`tbl_name`',
			'`fkid`',
			'`system_name`',
			'`from`',
			'`from_name`',
			'`address`',
			'`reply_to`',
			'`cc`',
			'`bcc`',
			'`attachment`',
			'`attachment_name`',
			'`subject`',
			'`body`',
			'`created_by`',
			'`date_time_created`',
			'`date_time_first_sent`',
			'`date_time_last_sent`',
			'`frequency`',
			'`interval`',
			'`sent_count`',
			'`sent_count_limit`',
			'`week_start`',
			'`skip_days`',
			'`logdel`'
		); 

		$array_values		 = array(
			$db_name,
			$tbl_name,
			$fkid,
			$system_name,
			$from,
			$from_name,
			$address,
			$reply_to,
			$cc,
			$bcc,
			$attachment,
			$attachment_name,
			$subject,
			$body,
			$created_by,
			$date_time_created,
			$date_time_first_sent,
			$date_time_last_sent,
			$frequency,
			$interval,
			$sent_count,
			$sent_count_limit,
			$week_start,
			$skip_days,
			'1'
		); 

		$result = MAILER2::getInstance()->insert_query($table,$array_fields,$array_values);
		$script = MAILER2::getInstance()->insert_query_script($table,$array_fields,$array_values);
		return $result.' '.$script;
	}
	//-novs

	?>
	
	