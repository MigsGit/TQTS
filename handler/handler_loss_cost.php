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
				case "save_loss_cost"							: save_loss_cost(); break;
				case "update_loss_cost"							: update_loss_cost(); break;
				case "get_loss_cost_attachments"				: get_loss_cost_attachments(); break;
				case "get_loss_cost_details_by_pkid"			: get_loss_cost_details_by_pkid(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function save_loss_cost() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$msg			 = '';				
		
		/* Get all fields to be inserted */		
		$table 						= "tbl_loss_cost_main";
		$values 					= get_fields_values($_POST,array("action","username","file_name"));
		$array_fields 				= $values["array_fields"];
		$array_values 				= $values["array_values"];
		$array_fields[] 			= "created_by"; 		$array_values[] = $username;
		$array_fields[] 			= "date_time_created"; 	$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "lastupdate"; 			$array_values[] = date("Y-m-d H:i:s");
		$array_fields[] 			= "username"; 				$array_values[] = $username;
		$fklosscost 				= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		
		/* Upload attachment */
		if(count($_FILES['file_name']['name']) != 0) {
			$file_ctr = 1;
			for($i=0;$i<count($_FILES['file_name']['name']);$i++) {
				$temp_file 	     = $_FILES["file_name"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_name"]["name"][$i];
				
				if($_FILES["file_name"]["tmp_name"][0] != '') {
					$file  		     	= return_file_path_by_div_mod('qfr_loss_cost');
					$fkfile_path     	= $file['pkid'];
					$target_dir      	= $file['path'];
					$target_file 	 	= $target_dir . $file_name;	
					if (file_exists($target_file)) {
						$msg 					= "Sorry, your file already exists.";
						$return['error']		= $msg;
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {	
							$table_details				= 'tbl_loss_cost_mdetails';
							$array_fields_details 		= array("date_time_created","created_by","fklosscost","file_name", "fkfile_path","lastupdate", "username");
							$array_values_details 		= array(date("Y-m-d H:i:s"), $username, $fklosscost, $file_name, $fkfile_path, date("Y-m-d H:i:s"), $username);
							$pkid						= TQTS::getInstance()->insert_query_id($table_details,$array_fields_details,$array_values_details);
							$script 				   .= TQTS::getInstance()->insert_query_script($table_details,$array_fields_details,$array_values_details);
						
							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							$new_file_name  = $pkid.".".$ext;
							if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
								$msg .= '<br>File was successfully uploaded to the system';
							} else {
								$msg .= '<br>There was an error on renaming the file.';
							}	
							
						}
						
					}
				}
			}
		}
		
		$return['msg'] 	= 'New record has been saved'.$msg;
		$return['POST'] 	= $_POST;
		$return['_FILES'] 	= $_FILES;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function update_loss_cost() {
		require_once('../class/oop_tqts.php');		
		$date_time_today = date('Y-m-d H:i:s');
		$username    	 = $_POST['username'];
		$fklosscost    	 = $_POST['pkid'];
		$msg			 = '';				
		
		/* Get all fields to be updated */		
		$table 						= "tbl_loss_cost_main";
		$array_fields 		= array("month_year", "remarks","lastupdate", "username");
		$array_values 		= array($_POST['month_year'], $_POST['remarks'], date("Y-m-d H:i:s"), $username);
		$pkid 				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$fklosscost);
		$script 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$fklosscost);
		
		/* Upload attachment */
		if(count($_FILES['file_name']['name']) != 0) {
			$file_ctr = 1;
			for($i=0;$i<count($_FILES['file_name']['name']);$i++) {
				$temp_file 	     = $_FILES["file_name"]["tmp_name"][$i];
				$file_name 	     = $_FILES["file_name"]["name"][$i];
				
				if($_FILES["file_name"]["tmp_name"][0] != '') {
					$file  		     	= return_file_path_by_div_mod('qfr_loss_cost');
					$fkfile_path     	= $file['pkid'];
					$target_dir      	= $file['path'];
					$target_file 	 	= $target_dir . $file_name;	
					if (file_exists($target_file)) {
						$msg 					= "Sorry, your file already exists.";
						$return['error']		= $msg;
					} else {
						if (move_uploaded_file($temp_file, $target_file)) {	
							$table_details				= 'tbl_loss_cost_mdetails';
							$array_fields_details 		= array("date_time_created","created_by","fklosscost","file_name", "fkfile_path","lastupdate", "username");
							$array_values_details 		= array(date("Y-m-d H:i:s"), $username, $fklosscost, $file_name, $fkfile_path, date("Y-m-d H:i:s"), $username);
							$pkid						= TQTS::getInstance()->insert_query_id($table_details,$array_fields_details,$array_values_details);
							$script 				   .= TQTS::getInstance()->insert_query_script($table_details,$array_fields_details,$array_values_details);
						
							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							$new_file_name  = $pkid.".".$ext;
							if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
								$msg .= '<br>File was successfully uploaded to the system';
							} else {
								$msg .= '<br>There was an error on renaming the file.';
							}								
						}						
					}
				}
			}
		}
		
		/* Delete all data logdel=1 */
		if($_POST['pkid_for_delete'] != '') {
			$pkid_for_delete = explode(',', $_POST['pkid_for_delete']);
			
			for($i=0; $i<count($pkid_for_delete); $i++) {
				$table 				= "tbl_loss_cost_mdetails";
				$array_fields 		= array("logdel","lastupdate", "username");
				$array_values 		= array(1, date("Y-m-d H:i:s"), $username);
				$result				= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid_for_delete[$i]);
				$script 			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid_for_delete[$i]);
				
				/* Permanently delete the file to server to save space :) */
				$array_fields = array('pkid','file_name','(SELECT file_path FROM tbl_file_path WHERE tbl_file_path.pkid = tbl_loss_cost_mdetails.fkfile_path) as file_path');
				$table 	   	= 'tbl_loss_cost_mdetails';
				$joins 	   	= '';
				$sql_where 	= 'WHERE pkid="'.$pkid_for_delete[$i].'" AND logdel=1';
				$sql_order 	= '';
				$sql_limit 	= 'LIMIT 0,1';
				$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);				
				while($row = mysqli_fetch_array($result)){
					$pkid 		= $row['pkid'];
					$file_path 	= $row['file_path'];
					$extension 	= end(explode('.',$row['file_name']));

					$file_for_delete = $file_path . $pkid . '.' . $extension;
					
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
				}
			}
		}		
		
		$return['msg'] 	= 'New record has been saved'.$msg;
		$return['POST'] 	= $_POST;
		$return['_FILES'] 	= $_FILES;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
	function get_loss_cost_attachments() {
		require_once('../class/oop_tqts.php');
		$fklosscost = $_POST['pkid'];
		$action2 	= $_POST['action2'];
		$array_fields = array('pkid','file_name','(SELECT file_path FROM tbl_file_path WHERE tbl_file_path.pkid = tbl_loss_cost_mdetails.fkfile_path) as file_path');
		$table 	   	= 'tbl_loss_cost_mdetails';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fklosscost="'.$fklosscost.'" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$html_body 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			if($action2 == 'edit') {
				$html_body .= '<tr>';
				$html_body .= '	<td><button type="button" data-id="'.$row['pkid'].'" class="btn btn-link fa fa-paperclip" id="uploaded_image"> '.$row['file_name'].'</button></td>';
				$html_body .= '	<td><center><button type="button" class="btn btn-danger fa fa-trash" id="btn_remove_attachment" data-id="'.$row['pkid'].'"> </button></center></td>';
				$html_body .= '</tr>';
			} else {				
				$html_body .= '<tr>';
				$html_body .= '	<td><button type="button" data-id="'.$row['pkid'].'" class="btn btn-link fa fa-paperclip" id="uploaded_image"> '.$row['file_name'].'</button></td>';
				$html_body .= '</tr>';
			}
		}
		$return['table_body'] = $html_body;
		echo json_encode($return);
	}

	function get_loss_cost_details_by_pkid() {
		require_once('../class/oop_tqts.php');
		$pkid 							= $_POST["pkid"];
		$table  						= "tbl_loss_cost_main";
		$array_fields					= array("*");
		$joins  	 					= "";
		$sql_where  					= "WHERE `pkid` = '$pkid'";
		$sql_order  					= "";
		$sql_limit  					= "LIMIT 0,1";
		$result        					= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['data'] 				= array();
		if($row = mysqli_fetch_assoc($result)){		
			$return['data']	= $row;
		}		
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	
	?>