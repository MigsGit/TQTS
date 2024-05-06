<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				
				case "get_supplier" 								: get_supplier(); break; 
				case "add_supplier" 								: add_supplier(); break; 
				case "edit_supplier" 								: edit_supplier(); break; 
				case "delete_supplier" 								: delete_supplier(); break; 
				
				/* approver - start */
				case "get_subystem_list" 							: get_subystem_list(); break; 
				case "get_module_list" 								: get_module_list(); break;
				case "get_approver_type" 							: get_approver_type(); break;
				case "get_approver_user_list" 						: get_approver_user_list(); break;
				case "save_approver" 								: save_approver(); break; 
				/* approver - end */
				
				case "get_current_user_role" 						: get_current_user_role(); break; 
				case "get_user_roles_section" 						: get_user_roles_section(); break; 
				case "get_user_roles_role" 							: get_user_roles_role(); break; 
				case "save_edit_user_role" 							: save_edit_user_role(); break; 
				
				
				/* do not edit below */
				case "encode" 										: encode(); break; 
				case "decode" 										: decode(); break; 
				case "load_records" 								: load_records(); break; 
				case "add_new_record" 								: add_new_record(); break; 
				case "update_fetch_record" 							: update_fetch_record(); break; 
				case "update_record" 								: update_record(); break; 
				case "delete_record" 								: delete_record(); break; 
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* ***********************
		Supplier - Start 
	**************************/
	function get_supplier(){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*');
		$table			= "tbl_supplier_group";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		while($row = mysqli_fetch_array($result)){
			$html .= '<option value="'.$row['pkid'].'">'.$row['supplier_group'].'</option>';
		}
		$return['html'] = $html;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function add_supplier(){
		require_once('../class/oop_tqts.php');
		$return = array();
		$table 				= 'tbl_supplier';
		$field_data 		= get_fields_values($_POST,array("action","username"));
		
		$array_fields 		= $field_data['array_fields'];
		$array_values 		= $field_data['array_values'];
		
		$array_fields[]		= 'date_time_created'; $array_values[] = date('Y-m-d H:i:s');
		$array_fields[]		= 'created_by'; $array_values[] = $_POST['username'];
		$array_fields[]		= 'lastupdate'; $array_values[] = date('Y-m-d H:i:s');
		$array_fields[]		= 'username'; $array_values[] = $_POST['username'];
		$result 			= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
		$script 			= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		$return['script']	= $script;
		echo json_encode($result);
	}
	
	function edit_supplier(){
		require_once('../class/oop_tqts.php');
		$table 				= 'tbl_supplier';
		$field_data 		= get_fields_values($_POST,array("action","username","pkid"));
		$array_fields 		= $field_data['array_fields'];
		$array_values 		= $field_data['array_values'];
		$array_fields[]		= 'lastupdate'; $array_values[] = date('Y-m-d H:i:s');
		$array_fields[]		= 'username'; $array_values[] = $_POST['username'];
		$result 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$_POST['pkid']);
		$script 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$_POST['pkid']);
		$return				= array();
		$return['script']	= $script;
		echo json_encode($return);
	}
	
	function delete_supplier(){
		require_once('../class/oop_tqts.php');
		$table 				= 'tbl_supplier';
		$array_fields 		= array('logdel');
		$array_values 		= array('1');
		$result 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$_POST['pkid']);
		$script 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$_POST['pkid']);
		$return				= array();
		$return['script']	= $script;
		echo json_encode($return);
	}
	
	/* ***********************
		Supplier - End 
	**************************/
	
	/* ***********************
		Approver - Start 
	**************************/
	function get_subystem_list(){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*');
		$table			= "tbl_subsystem";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		while($row = mysqli_fetch_array($result)){
			$html .= '<option value="'.$row['pkid'].'">'.$row['subsystem_name'].'</option>';
		}
		$return['html'] = $html;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_module_list(){
		require_once('../class/oop_tqts.php');
		$fk_subsystem 	= $_POST['subsystem'];
		$array_fields 	= array('*');
		$table			= "tbl_module";
		$joins			= "";
		$sql_where		= "WHERE fk_subsystem = '$fk_subsystem' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		while($row = mysqli_fetch_array($result)){
			$html .= '<option value="'.$row['pkid'].'">'.$row['module'].'</option>';
		}
		$return['html'] = $html;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_approver_type(){
		require_once('../class/oop_tqts.php');
		$fk_module 	= $_POST['module'];
		$array_fields 	= array('DISTINCT(`approver_type`)');
		$table			= "tbl_report_approvers";
		$joins			= "";
		$sql_where		= "WHERE fk_module = '$fk_module' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		while($row = mysqli_fetch_array($result)){
			$html .= '<option value="'.$row['approver_type'].'">'.$row['approver_type'].'</option>';
		}
		$return['html'] = $html;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function get_approver_user_list(){
		require_once('../class/oop_tqts.php');
		$fk_module 	= $_POST['module'];
		$array_fields 	= array('`username`','`name`');
		$table			= "db_rapid.tbl_useraccounts";
		$joins			= "";
		$sql_where		= "WHERE `name` LIKE '%".$_POST['pattern']."%'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,20";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		while($row = mysqli_fetch_array($result)){
			$html .= '<option value="'.$row['username'].'">'.$row['name'].'</option>';
		}
		$return['html'] = $html;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function save_approver(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$existing_username = validate_existing_username($_POST['approver_username']);
		if(!$existing_username['validate']){
			$return['error'][] = "Username does not exist";
		}
		if(count($return['error']) == 0){
			$table 				= 'tbl_report_approvers';
			$field_data 		= get_fields_values($_POST,array("action","subsystem_name","username"));
			$array_fields 		= $field_data['array_fields'];
			$array_values 		= $field_data['array_values'];
			$array_fields[]		= 'approver_name'; $array_values[] = $existing_username['name'];
			$array_fields[]		= '	approver_esignature'; $array_values[] = $existing_username['empno'].".PNG";
			$array_fields[]		= 'date_time_created'; $array_values[] = date('Y-m-d H:i:s');
			$array_fields[]		= 'created_by'; $array_values[] = $_POST['username'];
			$array_fields[]		= 'lastupdate'; $array_values[] = date('Y-m-d H:i:s');
			$array_fields[]		= 'username'; $array_values[] = $_POST['username'];
			$result 			= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			$result 			= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}		
		$return['existing_username'] = $existing_username;
		$return['result'] = $result;
		echo json_encode($return);
	}
	
	function validate_existing_username($username){
		require_once('../class/oop_tqts.php');
		$fk_module 	= $_POST['module'];
		$array_fields 	= array('`username`','`name`','`empno`');
		$table			= "db_rapid.tbl_useraccounts";
		$joins			= "";
		$sql_where		= "WHERE `username` = '$username'";
		$sql_order		= "";
		$sql_limit		= "LIMIT 0,1";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		$return 		= array();
		$return['validate'] = false;
		if(mysqli_num_rows($result) != 0){
			$return['validate'] = true;
			$row = mysqli_fetch_array($result);
			$return['name'] = $row['name'];
			$return['empno'] = strtoupper($row['empno']);
		}
		$return['script']   = $script;
		return $return;
	}
	/* ***********************
		Approver - End 
	**************************/
	function get_current_user_role(){
		$html 			= '';
		$modules 		= get_modules();
		$section 		= get_user_roles_section();
		$role 			= get_user_roles_role();
		$no_record_ctr  = 0;
		foreach($modules['module'] as $key => $module){
			$user_role = get_user_role($_POST['user'],$modules['pkid'][$key]);
			$return['script'][] = $user_role['script'];
			$return['modules'][]  = $modules['pkid'][$key];
			if($user_role['pkid'] == 0){
				$no_record_ctr--;
				$user_role['pkid'] = $no_record_ctr;
			}
			$subystem_code = get_subsystem_code($modules['fk_subsystem'][$key]);
			$html .= '<tr id="'.$user_role['pkid'].'">';
			$html .= '	<td>'.$subystem_code.'</td>';
			$html .= '	<td>
							<input type="hidden" name="fk_subsystem[]" value="'.$modules['fk_subsystem'][$key].'">
							<input type="hidden" name="module[]" value="'.$module.'">('.$subystem_code.') '.$module.'
						</td>';
			/* create combo box for section */
			$combo_section  = '<select class="form-control" name="section[]">';
			$combo_section .= '		<option class="form-control" value=""></option>';
			foreach($section['section'] as $key_section => $value){
				if( $user_role['section'] == $value){
					$combo_section .= '<option value="'.$value.'" selected>'.$value.'</option>';
				}else{
					$combo_section .= '<option value="'.$value.'">'.$value.'</option>';
				}
			}
			$combo_section .= '</select>';
			$html .= '	<td>'.$combo_section.'</td>';
			/* create combo box for role */
			$combo_role  = '<select class="form-control" name="role[]">';
			$combo_role .= '		<option class="form-control" value=""></option>';
			foreach($role['role'] as $key_role => $value){
				if( $user_role['role'] == $value){
					$combo_role .= '<option value="'.$value.'" selected>'.$value.'</option>';
				}else{
					$combo_role .= '<option value="'.$value.'">'.$value.'</option>';
				}
			}
			$combo_role .= '</select>';
			// $combo_role = 'Approver<span class="fa fa-edit"></span>';
			$html .= '	<td><input type="hidden" name="pkid[]" value="'.$user_role['pkid'].'">'.$combo_role.'</td>';
			$html .= '	<td>'. ($user_role['create'] == 1 ? '<input type="checkbox" name="create_'.$user_role['pkid'].'" checked>' : '<input type="checkbox" name="create_'.$user_role['pkid'].'">') .'</td>';
			$html .= '	<td>'. ($user_role['read'] 	 == 1 ? '<input type="checkbox" name="read_'.$user_role['pkid'].'" checked>' : '<input type="checkbox" name="read_'.$user_role['pkid'].'">') .'</td>';
			$html .= '	<td>'. ($user_role['update'] == 1 ? '<input type="checkbox" name="update_'.$user_role['pkid'].'" checked>' : '<input type="checkbox" name="update_'.$user_role['pkid'].'">') .'</td>';
			$html .= '	<td>'. ($user_role['delete'] == 1 ? '<input type="checkbox" name="delete_'.$user_role['pkid'].'" checked>' : '<input type="checkbox" name="delete_'.$user_role['pkid'].'">') .'</td>';
			$html .= '</tr>';
		}
		$return['html'] = $html;
		echo json_encode($return);
	}
	
	function get_modules(){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*');
		$table			= "`tbl_module`";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html 			= '';
		$modules 		= array(
			"pkid"			=>	array(),
			"fk_subsystem"	=> array(),
			"module"		=> array()
		);
		while($row = mysqli_fetch_array($result)){
			$modules['pkid'][] 			= $row['pkid'];
			$modules['fk_subsystem'][] 	= $row['fk_subsystem'];
			$modules['module'][] 		= $row['module'];
		}
		return $modules;
	}
	
	function get_subsystem_code($fk_module){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('pkid','subsystem_code');
		$table			= "tbl_subsystem";
		$joins			= "";
		$sql_where		= "WHERE `pkid` = '$fk_module' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$subsystem_code = '';
		while($row = mysqli_fetch_array($result)){
			$subsystem_code = $row['subsystem_code'];
		}
		return $subsystem_code;
	}
	
	function get_user_role($user,$fk_module){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('`roles`.*','`module`.`module`');
		$table			= "tbl_user_roles `roles`";
		$joins			= "INNER JOIN `tbl_module` `module` ON `module`.`pkid` = `roles`.`fk_module`";
		$sql_where		= "WHERE `roles`.`fk_module` = '$fk_module' AND `roles`.`user` = '".$_POST['user']."' AND `roles`.`logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$user_role		= array(
			"fk_module"	=> array(),
			"module"	=> array(),
			"section"	=> array(),
			"role"		=> array(),
			"create"	=> array(),
			"read"		=> array(),
			"update"	=> array(),
			"delete"	=> array()
		);
		if($row = mysqli_fetch_array($result)){
			$user_role['pkid'] 			= $row['pkid'];
			$user_role['fk_module'] 	= $row['fk_module'];
			$user_role['module']		= $row['module'];
			$user_role['section'] 		= $row['section'];
			$user_role['role'] 			= $row['role'];
			$user_role['create'] 		= $row['create'];
			$user_role['read'] 			= $row['read'];
			$user_role['update'] 		= $row['update'];
			$user_role['delete'] 		= $row['delete'];
		}else{
			$user_role['pkid'] 			= 0;
			$user_role['fk_module'] 	= 0;
			$user_role['module'] 		= '';
			$user_role['section'] 		= '<label style="color:red;"> - NOT SET - </label>';
			$user_role['role']			= '<label style="color:red;"> - NOT SET - </label>';
			$user_role['create'] 		= 0;
			$user_role['read']			= 0;
			$user_role['update']		= 0;
			$user_role['delete']		= 0;
		}
		$user_role['script'] = $script;
		return $user_role;
	}
	
	function get_user_roles_section(){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*');
		$table			= "tbl_user_roles_section";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$section		= array(
			"pkid"		=> array(),
			"section"	=> array()
		);
		while($row = mysqli_fetch_array($result)){
			$section["pkid"][] 		= $row['pkid'];
			$section["section"][] 	= $row['section'];
		}
		return $section;
	}
	
	function get_user_roles_role(){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*');
		$table			= "tbl_user_roles_role";
		$joins			= "";
		$sql_where		= "WHERE `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$role			= array(
			"pkid"		=> array(),
			"role"		=> array()
		);
		while($row = mysqli_fetch_array($result)){
			$role["pkid"][] 	= $row['pkid'];
			$role["role"][] 	= $row['role'];
		}
		return $role;
	}
	
	function save_edit_user_role(){
		$user_role		= array(
			"pkid"		=> array(),
			"fk_subsystem"	=> array(),
			"module"	=> array(),
			"section"	=> array(),
			"role"		=> array(),
			"create"	=> array(),
			"read"		=> array(),
			"update"	=> array(),
			"delete"	=> array()
		);
		foreach($_POST['pkid'] as $key => $pkid){
			$user_role['pkid'][] 	= $pkid;
			$user_role['fk_subsystem'][]  = $_POST['fk_subsystem'][$key];
			$user_role['module'][]  = $_POST['module'][$key];
			$user_role['section'][] = $_POST['section'][$key];
			$user_role['role'][] 	= $_POST['role'][$key];
			$user_role['create'][] 	= ( $_POST['create_'.$pkid] == "on" ? 	1 : 0 );
			$user_role['read'][] 	= ( $_POST['read_'.$pkid] 	== "on" ? 	1 : 0 );
			$user_role['update'][] 	= ( $_POST['update_'.$pkid] == "on" ? 	1 : 0 );
			$user_role['delete'][] 	= ( $_POST['delete_'.$pkid] == "on" ?	1 : 0 );
		}
		/* call class */
		require_once('../class/oop_tqts.php');
		$script = array();
				
		foreach($user_role['pkid'] as $key => $pkid){
			if($pkid < 1){
				/* Add Non Existing Role */
				$table 				= 'tbl_user_roles';
				$array_fields 		= array('`fk_module`','`user`','`section`','`role`','`create`','`read`','`update`','`delete`');
				$array_values 		= array(get_module_id($user_role['fk_subsystem'][$key],$user_role['module'][$key]),$_POST['user'],$user_role['section'][$key],$user_role['role'][$key],$user_role['create'][$key],
											$user_role['read'][$key],$user_role['update'][$key],$user_role['delete'][$key]);
				$array_fields[]		= 'date_time_created'; $array_values[] = date('Y-m-d H:i:s');
				$array_fields[]		= 'created_by'; $array_values[] = $_POST['username'];
				$array_fields[]		= 'lastupdate'; $array_values[] = date('Y-m-d H:i:s');
				$array_fields[]		= 'username'; $array_values[] = $_POST['username'];
				$result 			= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
				$script[] 			= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
			}else{
				/* Edit Existing Role */
				$table 				= 'tbl_user_roles';
				$array_fields 		= array('section','role','create','read','update','delete');
				$array_values 		= array($user_role['section'][$key],$user_role['role'][$key],$user_role['create'][$key],
											$user_role['read'][$key],$user_role['update'][$key],$user_role['delete'][$key]);
				$array_fields[]		= 'lastupdate'; $array_values[] = date('Y-m-d H:i:s');
				$array_fields[]		= 'username'; $array_values[] = $_POST['username'];
				$result 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$user_role['pkid'][$key]);
				$script[] 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$user_role['pkid'][$key]);
			}
		}
		$return['user_role'] = $user_role;
		$return['post'] 	 = $_POST;
		$return['script'] 	 = $script;
		echo json_encode($return);
	}
	
	function get_module_id($fk_subsystem, $module){
		require_once('../class/oop_tqts.php');
		$array_fields 	= array('*');
		$table			= "tbl_module";
		$joins			= "";
		$sql_where		= "WHERE `fk_subsystem` = '$fk_subsystem' AND `module` = '$module' AND `logdel` = '0'";
		$sql_order		= "";
		$sql_limit		= "";
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$pkid 			= 0;
		while($row = mysqli_fetch_array($result)){
			$pkid = $row['pkid'];
		}
		return $pkid;
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
	 
	/* convert an array to encode base64 and serialize */
	function encode(){
		$str = base64_encode(serialize($_POST));
		echo json_encode($str);
	}

	/* revert to normal array, decode str to base64 and unserialize */
	function decode(){
		$array = unserialize(base64_decode($_POST));
		echo json_encode($array);
	}

	function encodeURIComponent($str) {
		$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
		return strtr(rawurlencode($str), $revert);
	}
    
	/* function for displaying record */
	function load_records(){
		require_once('../class/oop.php'); 
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = TEST::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	/* function for adding record */
	function add_new_record(){
		require_once('../class/oop.php'); 
		$return 		= $_POST; 
		$result 		= "";
		$table   		= "tbl_records"; //table name
		$array_fields 	= array('name','lastname','address','remarks'); //table fields
		$array_values 	= array($return['txt_name'],$return['txt_lastname'],$return['txt_address'],$return['txt_remarks']); //values to be saved
		$result 		= TEST::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for fetching record */
	function update_fetch_record(){
		require_once('../class/oop.php'); 
		$return = $_POST; 
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ='.$return['pkid'];
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = TEST::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid2'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return);//json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for updating record */
	function update_record(){
		require_once('../class/oop.php'); 
		$return = $_POST; 
		$result = "";
		$table        = "tbl_records";
		$array_fields = array('name','lastname','address','remarks');
		$array_values = array($return['txt_name_update'],$return['txt_lastname_update'],$return['txt_address_update'],$return['txt_remarks_update']);
		$pkid = $return['txt_pkid'];
		$result = TEST::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for deleting a record */
	function delete_record(){
		require_once('../class/oop.php'); 
		$return 	= $_POST;
		$result 	= "";
		$table   	= "tbl_records";
		$pkid 		= $return['pkid'];
		$result 	= TEST::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
?>