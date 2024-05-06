<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
				case "upload_meas_data" 							: upload_meas_data(); break; 
				case "return_meas_data_details_by_id" 			    : return_meas_data_details_by_id(); break; 
				case "re_upload_meas_data" 					        : re_upload_meas_data(); break; 
				case "get_measdata_attachments" 					: get_measdata_attachments(); break; 
				case "remove_measdata_attachment" 					: remove_measdata_attachment(); break; 
				case "get_iqc_data" 								: get_iqc_data(); break; 
                    
				case "get_invoice_num_datalist" 			        : get_invoice_num_datalist(); break; 
				case "get_partcode_datalist_by_invoice_num" 		: get_partcode_datalist_by_invoice_num(); break; 
				case "get_partname_by_partcode" 					: get_partname_by_partcode(); break; 
				case "get_partdetails_by_po_num" 					: get_partdetails_by_po_num(); break; 
				case "get_po_datalist" 					            : get_po_datalist(); break; 
				
				/* Advanced Search */
				case "iqc_return_dir_fields"						: iqc_return_dir_fields(); break;
				case "dir_advance_search"							: dir_advance_search(); break;
				
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	function upload_meas_data() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$file  		 = return_file_path_by_div_mod('iqc_measdata');
		$fkfile_path = $file['pkid'];
		$target_dir  = $file['path'];
		$meas_type	 = $_POST['measurement_type'];
		$invoice_no	 = isset($_POST['invoice_number']) ? $_POST['invoice_number'] : '';
		$lot_no	     = $_POST['lot_number'];
		$part_code	 = $_POST['part_code'];
		$file_type	 = $_POST['file_type'];
		$po_number	 = isset($_POST['po_number']) ? $_POST['po_number'] : '';
		$device_code = isset($_POST['device_code']) ? $_POST['device_code'] : '' ;
		$drawing_no	 = $_POST['drawing_number'];
		$remarks	 = $_POST['remarks'];
		$username	 = $_POST['username'];
		$msg 		 = '';
				
		/* Insert the record to database then return the pkid (as referenced pkid of attachment) */
		$table 			= 'tbl_iqc_measdata';
		$array_fields 	= array('date_time_created', 'created_by', 'meas_type', 'invoice_number', 'lot_number', 'part_code', 'file_type', 'po_number', 'device_code', 'drawing_number', 'remarks', 'lastupdate', 'username');
		$array_values 	= array($date_time_today,$username,$meas_type,$invoice_no,$lot_no,$part_code,$file_type,$po_number,$device_code,$drawing_no,$remarks,$date_time_today,$username);
		$fkmeasdata 	= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		
		for($i=0;$i<count($_FILES['meas_file']['name']);$i++) {
			$temp_file 	 = $_FILES["meas_file"]["tmp_name"][$i];
			$file_name 	 = $_FILES["meas_file"]["name"][$i];
			$target_file = $target_dir . $file_name;
			if (file_exists($target_file)) {
				$msg = "Sorry, your file already exists.";
			} else {
				if (move_uploaded_file($temp_file, $target_file)) {
					/* Record the attached file, then rename the file based on pkid */					
					$table 			= 'tbl_iqc_measdata_attachment';
					$array_fields 	= array('date_time_created', 'created_by', 'fkmeasdata', 'file_name', 'fkfile_path', 'lastupdate', 'username');
					$array_values 	= array($date_time_today,$username,$fkmeasdata,$file_name,$fkfile_path,$date_time_today,$username);
					$pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
					
					$ext = pathinfo($target_file, PATHINFO_EXTENSION);
					$new_file_name  = $pkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
						$msg = 'File was successfully uploaded to the system';
					} else {
						$msg = 'There was an error on renaming the file.';
					}					
				} else {
					$msg = "Sorry, there was an error uploading your file.";
				}
			}
		}
		$return['msg'] = $msg;
		echo json_encode($return);
	}

    function return_meas_data_details_by_id() {
		require_once('../class/oop_tqts.php');
		$pkid       = $_POST['pkid'];
		$array_fields = array('meas_type', 'invoice_number', 'lot_number', 'part_code', 'file_type', 'po_number', 'device_code', 'drawing_number', 'remarks');
		$table 	   	= 'tbl_iqc_measdata';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$html_body 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$return['meas_type']       = $row['meas_type'];
			$return['invoice_number']  = $row['invoice_number'];
			$return['lot_number']      = $row['lot_number'];
			$return['part_code']       = $row['part_code'];
			$return['part_name']       = get_partname_by_partcode2($row['part_code']);
			$return['file_type']       = $row['file_type'];
			$return['po_number']       = $row['po_number'];
			$return['device_code']     = $row['device_code'];
			$return['drawing_number']  = $row['drawing_number'];
			$return['remarks']         = $row['remarks'];
		}
		echo json_encode($return);
	}
	
    function get_measdata_attachments() {
		require_once('../class/oop_tqts.php');
		$fkmeasdata = $_POST['pkid'];
		$array_fields = array('pkid','file_name');
		$table 	   	= 'tbl_iqc_measdata_attachment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkmeasdata="'.$fkmeasdata.'" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$html_body 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$html_body .= '<tr>';
			$html_body .= '	<td><button type="button" class="btn btn-link fa fa-paperclip" id="btn_dl_attachment" value="'.$row['pkid'].'"> '.$row['file_name'].' '.$row['pkid'].'</button></td>';
			$html_body .= '	<td><center><button class="btn btn-danger fa fa-trash" id="btn_remove_attachment" value="'.$row['pkid'].'"> </button></center></td>';
			$html_body .= '</tr>';
		}
		$return['table_body'] = $html_body;
		echo json_encode($return);
	}
    
	function re_upload_meas_data() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');	
		$file        = return_file_path_by_div_mod('iqc_measdata');
		$fkfile_path = $file['pkid'];
		$target_dir  = $file['path'];
        $fkmeasdata  = $_POST['pkid'];
		$meas_type	 = $_POST['measurement_type'];
		$invoice_no	 = $_POST['invoice_number'];
		$lot_no	     = $_POST['lot_number'];
		$part_code	 = $_POST['part_code'];
		$file_type	 = $_POST['file_type'];
		$po_number	 = $_POST['po_number'];
		$device_code = $_POST['device_code'];
		$drawing_no	 = $_POST['drawing_number'];
		$remarks	 = $_POST['remarks'];
		$username	 = $_POST['username'];
		$msg 		 = '';
				
		/* Update the record to database then return the pkid (as referenced pkid of attachment) */
		$table 			= 'tbl_iqc_measdata';
		$array_fields 	= array('meas_type', 'invoice_number', 'lot_number', 'part_code', 'file_type', 'po_number', 'device_code', 'drawing_number', 'remarks', 'lastupdate', 'username');
		$array_values 	= array($meas_type,$invoice_no,$lot_no,$part_code,$file_type,$po_number,$device_code,$drawing_no,$remarks,$date_time_today,$username);
		$msg        	= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$fkmeasdata);
		
        /* Re-upload new file if has */
        if(isset($_FILES['meas_file']['name'])) {
            for($i=0;$i<count($_FILES['meas_file']['name']);$i++) {
                $temp_file 	 = $_FILES["meas_file"]["tmp_name"][$i];
                $file_name 	 = $_FILES["meas_file"]["name"][$i];
                $target_file = $target_dir . $file_name;
                if (file_exists($target_file)) {
                    $msg = "Sorry, your file already exists.";
                } else {
                    if (move_uploaded_file($temp_file, $target_file)) {
                        /* Record the attached file, then rename the file based on pkid */					
                        $table 			= 'tbl_iqc_measdata_attachment';
                        $array_fields 	= array('date_time_created', 'created_by', 'fkmeasdata', 'file_name', 'fkfile_path', 'lastupdate', 'username');
                        $array_values 	= array($date_time_today,$username,$fkmeasdata,$file_name,$fkfile_path,$date_time_today,$username);
                        $pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);

                        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
                        $new_file_name  = $pkid.".".$ext;
                        if(rename ($target_file, $target_dir.'/'.$new_file_name)){		
                            $msg = 'File was successfully uploaded to the system';
                        } else {
                            $msg = 'There was an error on renaming the file.';
                        }					
                    } else {
                        $msg = "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
            
		$return['msg'] = $msg;
		echo json_encode($return);
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
	
	function remove_measdata_attachment() {
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');		
		$username 		= $_POST['username'];
		$pkid 			= $_POST['pkid'];	
		$reason 		= $username.' '.$date_time_today.' : '.$_POST['reason'];	
		$msg 			= '';
		
		/* Update the status to 1 as deleted */
		$table 			= 'tbl_iqc_measdata_attachment';
		$array_fields 	= array('reason_delete','lastupdate', 'username', 'logdel');
		$array_values 	= array($reason,$date_time_today, $username, 1);
		$msg 			= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		
		/* Get the file and directory */
		$file 			 = get_file_details_by_pkid($pkid);
		$file_name 		 = $file['file_name'];
		$file_for_delete = $file['file'];
		
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
		$return['msg'] = $msg;
		echo json_encode($return);
	}
	
	function get_file_details_by_pkid($fkdetails) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('path.file_path','details.file_name');
		$table 	   	= 'tbl_iqc_measdata_attachment details ';
		$joins 	   	= 'INNER JOIN tbl_file_path path ON path.pkid = details.fkfile_path';
		$sql_where 	= 'WHERE details.pkid="'.$fkdetails.'" AND details.logdel=1';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$file 		= array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$file['file_path'] = $row['file_path'];
			$file['extension'] = end(explode('.',$row['file_name']));
			$file['file_name'] = $row['file_name'];		
			$file['file'] 	   = $row['file_path'] . $fkdetails . '.' . $file['extension']; 	
		} else {
			$file['file_path'] = '';
			$file['extension'] = '';
			$file['file_name'] = '';
			$file['file'] 	   = '';
		}
		$file['script'] 	   = $script;
		return $file;
	}
	
	function get_iqc_data(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$array_fields = array('*');
		$table = 'iqc_inspections';
		$joins = '';
		$sql_where= '';
		$sql_order = '';
		$sql_limit = 'LIMIT 0,10';
		$result = SEIKODB::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$return['data'][] = $row; 
		}
		echo json_encode($return);
	}	
    
    /* YPICS 4.0 Connection */
    function get_invoice_num_datalist(){
        require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $pattern        = $_POST['pattern']; 
        // $array_fields   = array("TOP 10 INVOICE_NUM");
        $array_fields   = array("DISTINCT TOP 10 INVOICE_NUM"); //as of 10/02/2018
        $table          = "XSACT";
        $joins          = "";
        $sql_where      = "WHERE INVOICE_NUM LIKE '%$pattern%'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $html    		= '';
        while($row = mssql_fetch_array($result)){
			$html .= '<option value="'.$row['INVOICE_NUM'].'">'.$row['INVOICE_NUM'].'</option>';
        }
        $return['html'] = $html;
        echo json_encode($return);
     }
    
    function get_partcode_datalist_by_invoice_num() {
        require_once('../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$invoice_num 	= $_POST['invoice_num']; 
		$array_fields 	= array("TOP 10 CODE");
		$table 			= "XSACT";
		$joins 			= "";
		$sql_where 		= "WHERE INVOICE_NUM LIKE '%$invoice_num%'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		$html_select= '';
		while($row = mssql_fetch_array($result)){
			$html_select .= '<option value="'.$row['CODE'].'">'.$row['CODE'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
    }

    function get_partname_by_partcode() {
		echo 'iqc_handler';
        // require_once('../class/oop_tqts.php');
		// $YPICS          = new YPICS4;
		// $part_code 		= $_POST['part_code']; 
		// $array_fields 	= array("NAME");
		// $table 			= "VHEAD";
		// $joins 			= "";
		// $sql_where 		= "WHERE CODE='$part_code'";
		// $sql_order 		= "";
		// $result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		// $script = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
		// if($row = mssql_fetch_array($result)){
		// 	$return['part_name'] = $row['NAME'];
		// } else {
        //     $return['part_name'] = '';
        // }
		// $return['script'] = $script;
		// echo json_encode($return);
    }

    function get_partname_by_partcode2($part_code) {
		if(file_exists('../../class/oop_tqts.php')) {
			require_once('../../class/oop_tqts.php');
		} else {
			require_once('../class/oop_tqts.php');
		}
        // require_once('../../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$array_fields 	= array("NAME");
		$table 			= "VHEAD";
		$joins 			= "";
		$sql_where 		= "WHERE CODE='$part_code'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			return $row['NAME'];
		} else {
            return '';
        }
    }

    function get_partdetails_by_po_num() {
        require_once('../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$po_number 		= $_POST['po_number']; 
		$array_fields 	= array("CODE","NAME");
		$table 			= "VRECE";
		$joins 			= "";
		$sql_where 		= "WHERE SORDER='$po_number'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['device_code'] = $row['CODE'];
			$return['device_name'] = $row['NAME'];
		} else {
            $return['device_code'] = '';
            $return['device_name'] = '';
        }
		echo json_encode($return);
    }

    function get_partdetails_by_po_num2($po_number) {
        require_once('../../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$array_fields 	= array("CODE","NAME");
		$table 			= "VRECE";
		$joins 			= "";
		$sql_where 		= "WHERE SORDER='$po_number'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['device_code'] = $row['CODE'];
			$return['device_name'] = $row['NAME'];
		} else {
            $return['device_code'] = '';
            $return['device_name'] = '';
        }
		return $return;
    }

    function get_po_datalist(){
        require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $pattern        = $_POST['pattern']; 
        $array_fields   = array("TOP 10 SORDER");
        $table          = "VRECE";
        $joins          = "";
        $sql_where      = "WHERE SORDER LIKE '%$pattern%'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $html           = '';
        while($row = mssql_fetch_array($result)){
        $html .= '<option value="'.$row['SORDER'].'">'.$row['SORDER'].'</option>';
        }
        $return['html'] = $html;
        echo json_encode($return);
     }
	 
	 /* advanced search */
	 function iqc_return_dir_fields(){
		$ctr = 0;
		$option		  		=	array();
		$option[$ctr] 		= '<option value="created_by"> Created By</option>'; $ctr++;
		$option[$ctr] 		= '<option value="date_time_created"> Date Created</option>'; $ctr++;
		$option[$ctr] 		= '<option value="meas_type"> Measurement Type</option>'; $ctr++;
		$option[$ctr] 		= '<option value="invoice_number"> Invoice Number</option>'; $ctr++;
		$option[$ctr] 		= '<option value="lot_number"> Lot Number</option>'; $ctr++;
		$option[$ctr] 		= '<option value="part_code"> Part Code</option>'; $ctr++;
		$option[$ctr] 		= '<option value="file_type"> File Type</option>'; $ctr++;
		$option[$ctr] 		= '<option value="po_number"> PO Number</option>'; $ctr++;
		$option[$ctr] 		= '<option value="device_code"> Device Code</option>'; $ctr++;
		$option[$ctr] 		= '<option value="drawing_number"> Drawing Number</option>'; $ctr++;
		$option[$ctr] 		= '<option value="remarks"> Remarks</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	 }
	 
	 function dir_advance_search(){
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

	?>