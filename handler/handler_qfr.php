<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	
	include('common_function.php');
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
				case "get_fiscal_year" 							: get_fiscal_year(); break;
				case "get_supplier_list" 						: get_supplier_list(); break; 
				case "get_supplier_email_address" 				: get_supplier_email_address(); break; 
				case "get_part_name_by_code" 					: get_part_name_by_code(); break; 
				case "get_report_approvers" 					: get_report_approvers(); break; 
				case "get_report_approvers_technical_adviser" 	: get_report_approvers_technical_adviser(); break; 
				case "get_email_recipients_list" 		        : get_email_recipients_list(); break; 
				case "get_material_type_list" 					: get_material_type_list(); break; 
				
				case "get_measdata_attachments" 				: get_measdata_attachments(); break; 
				case "remove_measdata_attachment" 				: remove_measdata_attachment(); break;
				
				/* YPICS 4.0 */
				case "get_ng_invoice_num_datalist" 				: get_ng_invoice_num_datalist(); break; 
				case "get_partcode_datalist_by_invoice_num" 	: get_partcode_datalist_by_invoice_num(''); break; 
				case "get_partname_by_partcode" 	            : get_partname_by_partcode(); break; 
				case "get_partname_by_partcode_at" 	            : get_partname_by_partcode_at(); break; 
				case "get_po_list" 	            				: get_po_list(); break; 
				case "get_po_details" 	            			: get_po_details(); break;
				case "get_partcode_list"						: get_partcode_list(); break;
				case "get_lot_number_list"						: get_lot_number_list(); break;
			
				/* Special Acceptance */
				/* Get Report Ordinates */
				case "save_special_acceptance"					: save_special_acceptance(); break;
				case "generate_sa_control_number_view"			: generate_sa_control_number_view(); break;
				case "get_report_ordinates"						: get_report_ordinates(); break;
				case "load_special_acceptance"					: load_special_acceptance(); break;
				case "replace_sa_file"							: replace_sa_file(); break;
				case "cancel_special_acceptance"				: cancel_special_acceptance(); break;
				case "download_qfr_sa_report"					: download_qfr_sa_report(); break;
				case "download_sa_excel"						: download_sa_excel(); break;
				case "check_sa_judgement"						: check_sa_judgement(); break;
				//Approvers
				case "load_approver_table"						: load_approver_table(); break; //NOTE : fview get the approver table from "tbl_qfr_sa_approvers"
				case "validate_is_approver"						: validate_is_approver(); break; //NOTE : fview validate if the approver is Login the current account"
				case "validate_main_is_approver"				: validate_main_is_approver(); break; //NOTE : fview validate if the approver is Login the current account"
				case "sa_approver_decision"						: sa_approver_decision(); break; //NOTE : fview approver remarks & decision"
				case "sa_main_approver_decision"				: sa_main_approver_decision(); break; //NOTE : fview 4 approvers remarks & decision"
				case "sa_qc_approvers_decision"					: sa_qc_approvers_decision(); break; //NOTE :qc approvers remarks & decision"
				case "load_main_approver_table"					: load_main_approver_table(); break; //NOTE : fview get the main approver table from "tbl_qfr_sa_approvers_main"
				/* For Revision*/
				case "save_sa_for_revision"						:save_sa_for_revision();break;
				/* For Disposition*/
				case "get_supplier_by_pkid"						: get_supplier_by_pkid(); break;
				case "send_email_for_disposition"				: send_email_for_disposition(); break; //NOTE : fdisposition send the approved SAR to suppliers"
				case "get_disposition_list"						: get_disposition_list(); break; 
				case "get_view_attachment"						: get_view_attachment(); break; 
				/* With Disposition */
				case "get_sent_details"							: get_sent_details(); break; //NOTE : get the Sent Details"
				case "save_add_disposition"						: save_add_disposition(); break; //NOTE : Save the Disposition/Judgement"
				case "update_sa_disposition"					: update_sa_disposition(); break; //NOTE : Update the Disposition/Judgement"
				case "get_treatment"							: get_treatment(); break; //NOTE : get the treatment"
				/** Validation of QC Supervisor */
				case "validate_qc_supervisor"					: validate_qc_supervisor(); break; 
				
				/*=== Attention Tag ===*/
				case "generate_at_control_number_view"			: generate_at_control_number_view(); break;
				case "load_at_info"								: load_at_info(); break;
				case "save_attention_tag"						: save_attention_tag(); break;
				case "update_attention_tag"						: update_attention_tag(); break;
				case "cancel_attention_tag"						: cancel_attention_tag(); break;
				
				/* Advance Search */
				case "qfr_return_at_fields"						: qfr_return_at_fields(); break;
				case "at_advance_search"						: at_advance_search(); break;
				case "qfr_return_ng_fields"						: qfr_return_ng_fields(); break;
				case "ng_advance_search"						: ng_advance_search(); break;
				case "qfr_return_sa_fields"						: qfr_return_sa_fields(); break;
				case "sa_advance_search"						: ng_advance_search(); break;
				case "qfr_return_aye_fields"					: qfr_return_aye_fields(); break;
				case "aye_advance_search"						: aye_advance_search(); break;
				/* PTIS */
				case "qfr_return_ptis_fields"					: qfr_return_ptis_fields(); break;
				case "ptis_advance_search"						: ptis_advance_search(); break;
				
				/* ITN */
				case "get_control_no_itn_display"				: get_control_no_itn_display(); break;
				case "get_itn_details"							: get_itn_details(); break;
				case "save_itn"									: save_itn(); break;
				case "update_itn"								: update_itn(); break;
				case "change_status_itn"						: change_status_itn(); break;
				
				/* QCFR */
				case "upload_qcfr"								: upload_qcfr(); break;
				case "save_qcfr"								: save_qcfr(); break;

			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
    function get_fiscal_year() {
		require_once('../class/oop_tqts.php');
		$array_fields = array('DISTINCT(DATE_FORMAT(`disposition_date`,"%Y")) AS fy');
		$table 	   	= 'tbl_qfr_ng_treatment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';
		$sql_order 	= 'ORDER BY fy';
		$sql_limit 	= '';
		$html_select= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select= '';
		while($row = mysqli_fetch_array($result)){
			$html_select .= '<option value="'.$row['fy'].'">FY'.$row['fy'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
    function get_supplier_list() {				
		require_once('../class/oop_tqts.php');		
		$array_fields = array('s.supplier');		
		$table 	   	= 'tbl_supplier s';
		$joins 	   	= 'INNER JOIN tbl_supplier_group sg ON sg.pkid = s.fksupplier_group';
		$sql_where 	= 'WHERE sg.logdel=0 AND s.logdel=0';	
		$sql_order 	= 'ORDER BY s.supplier';	
		$sql_limit 	= '';	
		$html_select= '';		
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);		
		while($row=mysqli_fetch_array($result)) {		
			$html_select .= '<option value="'.$row['supplier'].'">'.$row['supplier'].'</option>';	
		}		
		$return['html_select'] = $html_select;		
		echo json_encode($return);		
	}			
	
	function get_supplier_email_address() {
		require_once('../class/oop_tqts.php');
		$supplier 		= $_POST['supplier'];
		$field_name 	= $_POST['field_name'];
		$array_fields = array($field_name);
		$table 	   	= 'tbl_supplier';
		$joins 	   	= '';
		$sql_where 	= 'WHERE supplier="'.$supplier.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$html_select= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			
			// echo $row['recipients_to'];
			$array_email_add = explode(',',$row[$field_name]);
			$return['email_add'] = array();
			foreach($array_email_add as $key => $value){
				$array_data_email 				= array();
				$array_data_email['id'] 		= $value;
				$array_data_email['text'] 		= $value;
				$return['email_add'][]			= $array_data_email;
			}
		} 
		else {
			$return['email_add'] = '';
			$return['script'] = '';
		}
		echo json_encode($return);
	}
	
    function get_part_name_by_code() {
		require_once('../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$part_code 		= $_POST['part_code']; 
		$array_fields 	= array("NAME");
		$table 			= "VHEAD";
		$joins 			= "";
		$sql_where 		= "WHERE CODE='$part_code'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['part_name'] = $row['NAME'];
		} else {
            $return['part_name'] = '';
        }
		echo json_encode($return);
	}
	
	function get_report_approvers() {
		require_once('../class/oop_tqts.php');
		$array_fields = array('approver_username','approver_name');
		
		$fk_module = array();
		foreach($_POST['fk_module'] as $key => $value){
			if($value != ""){
				$fk_module[] = ' fk_module = "'.$value.'"'; 
			}			
		}$fk_module = "(".implode(" OR ", $fk_module).")";
		
		$approver_type = array();
		foreach($_POST['approver_type'] as $key => $value){
			if($value != ""){
				$approver_type[] = ' approver_type = "'.$value.'"'; 
			}
		}$approver_type = "(".implode(" OR ", $approver_type).")";
		
		$array_where   = array();
		$fk_module 	   != "()" ? $array_where[] = $fk_module : "";
		$approver_type != "()"  ? $array_where[] = $approver_type : "";
		$array_where[] = 'logdel = "0"';
		$table 	   	= 'tbl_report_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE '.implode(" AND ", $array_where);
		$sql_order 	= 'ORDER BY approver_name';
		$sql_limit 	= '';
		$html_select= '<option></option>';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['approver_username'].'">'.$row['approver_name'].'</option>';
		}

		$return['html_select'] = $html_select;
		$return['script'] = $script;

		echo json_encode($return);
	}

	function get_report_approvers_technical_adviser(){
		require_once('../class/oop_tqts.php');
		$array_fields  	= array('approver_username','approver_name');
		$fk_module  	= $_POST['fk_module'];
		$table 	   		= 'tbl_report_approvers';
		$joins 	   		= '';
		$sql_where 		= 'WHERE fk_module = "'.$fk_module.'" AND logdel="0" AND approver_type="Technical Adviser"';
		$sql_order 		= 'ORDER BY approver_name';
		$sql_limit 		= '';
		$html_select	= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row=mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['approver_username'].'">'.$row['approver_username'].'</option>';
		}

		$return['html_select'] = $html_select;
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
	
	function get_email_recipients_list() {
        require_once('../class/oop_tqts.php');
		$array_fields = array('CONCAT(firstname, " ",lastname) as emp_name', 'email_add');
		$table 	   	= 'db_hris.vw_emp_hris';
		$joins 	   	= '';
		$sql_where 	= 'WHERE EmpStatus=1 AND (email_add != "kiosk@pricon.ph" AND email_add != "" AND email_add != "kiosk@pricon.ph ")';
		$sql_order 	= 'ORDER BY firstname';
		$sql_limit 	= '';
		$html_select= '';
		$result = SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row=mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['email_add'].'">'.$row['emp_name'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
    }
	
	/* YPICS 4.0 Connection */
    function get_ng_invoice_num_datalist(){
		require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $pattern        = $_POST['pattern']; 
        $array_fields   = array("TOP 10 INVOICE_NUM");
        // $table          = "VSACT";
        $table          = "XSACT";
        $joins          = "";
        $sql_where      = "WHERE INVOICE_NUM LIKE '%$pattern%'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		$script 		= $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
        $html           = '';
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
		// $table 			= "VSACT";
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
        require_once('../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$part_code 		= $_POST['part_code']; 
		$array_fields 	= array("VHEAD.NAME","VITEM.DRAWING_NUM","VITEM.VENDOR");
		$table 			= "VHEAD";
		$joins 			= "LEFT JOIN VITEM ON VHEAD.CODE = VITEM.CODE";
		$sql_where 		= "WHERE VHEAD.CODE='$part_code'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		$script  = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['part_name'] 		= $row['NAME'];
			$return['drawing_number'] 	= $row['DRAWING_NUM'];
			$return['supplier'] 		= $row['VENDOR'];
		} else {
            $return['part_name'] 		= '';
            $return['drawing_number'] 	= '';
			$return['supplier'] 		= '';
        }
        $return['script'] 	= $script;
		echo json_encode($return);
    }
	
	function get_partname_by_partcode_at() {
        require_once('../class/oop_tqts.php');
		$YPICS          = new YPICS4;
		$part_code 		= $_POST['part_code']; 
		$array_fields 	= array("VHEAD.NAME","VITEM.DRAWING_NUM","VITEM.VENDOR");
		$table 			= "VHEAD";
		$joins 			= "INNER JOIN VITEM ON VHEAD.CODE = VITEM.CODE";
		$sql_where 		= "WHERE VHEAD.CODE='$part_code'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['part_name'] 		= $row['NAME'];
			$return['drawing_number'] 	= $row['DRAWING_NUM'];
			$return['supplier'] 		= $row['VENDOR'];
		} else {
            $return['part_name'] 		= '';
            $return['drawing_number'] 	= '';
			$return['supplier'] 		= '';
        }
		echo json_encode($return);
    }
	
	function get_po_list() {
        require_once('../class/oop_tqts.php');
		$YPICS         	= new YPICS4;
		$pattern 		= $_POST['pattern'];
		// $part_code 		= $_POST['part_code']; 
		$array_fields 	= array("TOP 10 SORDER");
		$table 			= "VRECE";
		$joins 			= "";
		$sql_where 		= "WHERE SORDER LIKE '%".$pattern."%'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		$return = array();
		while($row = mssql_fetch_array($result)){
			$return['po_number'][] 			= $row['SORDER'];
		} 
		echo json_encode($return);
    }
	
	function get_po_details() {
        require_once('../class/oop_tqts.php');
		$YPICS         	= new YPICS4;
		$po_number 		= $_POST['po_number'];
		$array_fields 	= array("XRECE.CODE","XRECE.KVOL","XCUST.CNAME");
		$table 			= "XRECE";
		$joins 			= "INNER JOIN XCUST ON XRECE.CUST = XCUST.CUST";
		$sql_where 		= "WHERE XRECE.SORDER = '$po_number'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['device_code']			= $row['CODE'];
			$return['po_qty']				= $row['KVOL'];
			$return['customer_name']		= $row['CNAME'];
		} else{
			$return['device_code'] 			= '';
			$return['po_qty'] 				= '0';
			$return['customer_name'] 		= '';
		}
		$array_fields 	= array("XHEAD.NAME","XITEM.DRAWING_NUM");
		$table 			= "XHEAD";
		$joins 			= "INNER JOIN XITEM ON XHEAD.CODE = XITEM.CODE";
		$sql_where 		= "WHERE XHEAD.CODE = '".$return['device_code']."'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$return['device_name']			= $row['NAME'];
			$return['drawing_number']		= $row['DRAWING_NUM'];
		} else{
			$return['device_name'] 			= '';
			$return['drawing_number']		= '';
		}
		echo json_encode($return);
    }
	
	function get_partcode_list(){
		require_once('../class/oop_tqts.php');
		$YPICS         	= new YPICS4;
		$pattern 		= $_POST['pattern'];
		// $part_code 		= $_POST['part_code']; 
		$array_fields 	= array("TOP 10 CODE");
		$table 			= "VHEAD";
		$joins 			= "";
		$sql_where 		= "WHERE CODE LIKE '%".$pattern."%'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		while($row = mssql_fetch_array($result)){
			$return['part_code'][] 			= $row['CODE'];
		} 
		echo json_encode($return);
	}
	
	function get_lot_number_list(){
		require_once('../class/oop_tqts.php');
		$invoice_no		= $_POST['invoice_no'];
		$array_fields 	= array('lot_no');
		$table      	= 'tbl_wbs_material_receiving_batch';
		$joins      	= '';
		$sql_where  	= 'WHERE `invoice_no`="'.$invoice_no.'"';
		$sql_order  	= '';
		$sql_limit  	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select 	= '';
		while($row = mysqli_fetch_array($result)){
			$html_select .= '<option value="'.$row['lot_no'].'">'.$row['lot_no'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}

	function get_ordinates($report_type){
		$ordinates = array();
		if($report_type == "sa"){
			/* get_values on database later on */
			$sheet_number = 1;
			$sheet_number = $sheet_number - 1;
			$ordinates = array(
				"sheet_number"  			=> $sheet_number,
				"judgement_application"  	=> "D7",
				"drawing_number"  			=> "B13",
				"parts" => array(
					"parts_affected_parts"	=> "B7",
					"part_code"				=> "B9",
					"problem_parts"			=> "B10",
					"supplier"				=> "B11",
					"lot_number"			=> "B12",
					"quantity"				=> "B14"
				),
				"device" => array(
					"device_name"  			=> "B17",
					"problem_device"  		=> "B18",
					"parts_affected_device" => "B19",
					"po_number"  			=> "B20",
					"po_qty"  				=> "B21",
					"affected_quantity"  		=> "B22",
					"customer_name"  		=> "B23",
					"shipment_date"  		=> "B24"
				)
			);
			
		}
		return $ordinates;
	}
	
    function get_report_ordinates(){
		require_once('../class/oop_tqts.php');
		$array_fields = array('fk_report','sheet_number','field_name','cell_position');
		$table 	   	= 'tbl_report_ordinates';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$html= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row=mysqli_fetch_array($result)) {
			$html .= '<tr>';
			$html .= '	<td><input class="form-control" type="text" value="'.$row['field_name'].'" readonly></td>';
			$html .= '	<td><input class="form-control" type="text" value="'.$row['sheet_number'].'"></td>';
			$html .= '	<td><input class="form-control" type="text" value="'.$row['cell_position'].'"></td>';
			$html .= '</tr>';
		}
		$return = array();
		$return['html'] = $html;
		echo json_encode($return);
	}
	
	function arrange_ordinates_array($ordinates){
		$arranged_ordinates = array();
		return $ordinates['field_name'];
	}
	
	function load_special_acceptance(){ //NOTE : nmodify
		require_once('../class/oop_tqts.php');
		$array_fields = array('*');
		$table 	   	= 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$pkid = $_POST['pkid'];
		$sql_where 	= 'WHERE pkid="'.$_POST['pkid'].'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($result->num_rows == 0){
			$return['no_record'] 			= $script;
		}
		while($row = mysqli_fetch_array($result)){
			$return['pkid'] 				= $row['pkid'];
			$return['control_number'] 		= $row['control_number'];
			$return['category'] 			= $row['category'];
			$return['parts_affected_parts'] = $row['parts_affected_parts'];
			$return['part_code'] 			= $row['part_code'];
			$return['supplier'] 			= $row['supplier'];
			$return['device_name']	 		= $row['device_name'];
			$return['parts_affected_device'] = $row['parts_affected_device'];
			$return['po_number'] 			= $row['po_number'];
			$return['po_qty'] 				= $row['po_qty'];
			$return['customer_name'] 		= $row['customer_name'];
			$return['lastupdate'] 			= $row['lastupdate'];
			$return['created_by'] 			= $row['created_by'];
			$return['username'] 			= $row['username'];
			$return['problem'] 				= $row['problem'];
			$return['factory_location'] 	= $row['factory_location'];
			$return['date_issued'] 			= $row['date_issued'];
			$return['immediate_action'] 	= $row['immediate_action'];
			$return['immediate_action_due_date'] 	= $row['immediate_action_due_date'];
			$return['permanent_action'] 			= $row['permanent_action'];
			$return['permanent_action_due_date'] 	= $row['permanent_action_due_date'];
			$return['other_details'] 				= $row['other_details'];
			$return['status'] 						= getSarStatusByCode($row['status']);
		}
		echo json_encode($return);
	}

	function load_pmi_approvers($pkid){
		$pkid;
		$approver_username	= array();
		$array_fields = array('approver_username','y_coordinate','x_coordinate');
		$table 	   	= 'tbl_qfr_sa_approvers_main';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkid`="'.$pkid.'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$approver_username[] 	= $row['approver_username'];
			$y_coordinate[]  		= $row['y_coordinate'];
			$x_coordinate[] 		= $row['x_coordinate'];
		}
/**
 * !get the array data from while loop, apply implode & explode, apply for loop || foreach
 */
		$return['pmi_approvers'] 	= implode(',',$approver_username);
		$array_approver = explode(",",$return['pmi_approvers']);

		$return['pmi_approvers'] 	= array();
		foreach($array_approver as $key => $value){
			$array_data_app 				= array();
			$array_data_app['id'] 			= $value;
			$array_data_app['text'] 		= get_emp_name_by_username_systemone($value);
			$return['pmi_approvers'][]	= $array_data_app;
		}

		$return['y_coordinate'] 	= implode(',',$y_coordinate);
		$y_coordinate = explode(",",$return['y_coordinate']);

		$return['x_coordinate'] 	= implode(',',$x_coordinate);
		$y_coordinate = explode(",",$return['x_coordinate']);

		for($i=0;$i<count($return['pmi_approvers']);$i++){
			$returns['y_coordinate'][] =  $y_coordinate[$i];
			$returns['x_coordinate'][] =  $x_coordinate[$i];
		}

		$return['pmi_approvers'];
		$return['y_coordinate'];
		$return['x_coordinate'];
		return $returns;
	}
	
	function save_special_acceptance(){
		try {
			require_once('../class/oop_tqts.php');
			$return 		= $_POST;
			$date_time_today = date('Y-m-d H:i:s');
			$special_acceptance_id =  $return['special_acceptance_id'];
			$field_data 	= get_fields_values($_POST,array('action','pkid','upload_type','control_number','special_acceptance_id'));
			$array_fields   = $field_data['array_fields'];
			$array_values   = $field_data['array_values'];
			$table			= 'tbl_qfr_special_acceptance';

			if($special_acceptance_id == ""){ //ADD
				$username = $return ['username'];
				$control_number = generate_sa_control_number(date('Y-m-d'),$return['username']);
				/* get field data from post */
				/* add additional fields */
				$array_fields[]	= 'lastupdate'; 	$array_values[] = date('Y-m-d H:i:s');
				$array_fields[]	= 'created_by'; 	$array_values[] = $_POST['username'];
				$array_fields[]	= 'date_created'; 	$array_values[] = date('Y-m-d H:i:s');
				$array_fields[]	= 'control_number'; $array_values[] = $control_number;
				$script 		= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
				$pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
				
			}else{ //EDIT
				/* add blanks to undefined or empty values */
				foreach($array_fields as $key => $value){
					if(!isset($return[$value]) || $return[$value] == ""){
						$return[$value] = "";
					}
				}
				$where 			= "WHERE pkid = '$special_acceptance_id'";
				$result 		= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
				$script 		= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
			}
			$reponse = array();
			$reponse['is_success'] = 'true';
			$reponse['message'] = 'Save Succefully';
			echo json_encode($reponse);
		} catch (\Throwable $th) {
			$reponse['is_success'] = 'false';
			$reponse['message'] = $th;
			echo json_encode($reponse);
			// throw $th;
		}
		
	}
	
	function generate_sa_control_number($date,$username){
		require_once('../class/oop_tqts.php');
		$username 	= $_POST['username'];
		$date		= date("Y-m-d");
		require_once('../class/oop_tqts.php');
		$division 	= return_system_division();
		$section 	= get_assigned_section_sa($username);
		$sar = 'SAR-';
		
		if(date('m') == 4) {
			$pattern 	= date('ym');
			$stat 		= 'new FY';
		} else {
			$pattern 	= date('ym');
			$stat 		= 'current FY';
		}
		
		$array_fields = array('control_number');
		$table 	   	= 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE date_created LIKE "%'.$pattern.'-%" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= 'LIMIT 0,1';
		$control_number= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows==0) {
			if($stat == 'current FY') {
				$sql_where 	= 'WHERE logdel=0';
				$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) {
					$sar = 'SAR-';
					$control_number = $row['control_number'];
					$ctr 		 	= end(explode('-',$control_number));
					$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
					$control_number = $sar.$division.'-'.$section.'-'.$pattern.$series;
				} else {
					$sar = 'SAR-';
					$control_number =$sar.$division.'-'.$section.'-'.$pattern.'-001';
				}
			} else {
				$sql_where 	= 'WHERE control_number LIKE "%-'.date('ym').'-%" AND logdel=0';
				$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) {
					$sar = 'SAR-';
					$control_number = $row['control_number'];
					$ctr 		 	= end(explode('-',$control_number));
					$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
					$control_number = $division.'-'.$section.'-'.$pattern.$series;
				} else {
					$sar = 'SAR-';

					$control_number = $sar.$division.'-'.$section.'-'.$pattern.'-001';
				}
			}
		} else {
			if($row = mysqli_fetch_array($result)) {
				$sar = 'SAR-';
				$control_number = $row['control_number'];
				$ctr 		 	= end(explode('-',$control_number));
				$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
			}		
			$control_number = $sar.$division.'-'.$section.'-'.$pattern.$series;
		}
		
		return $control_number;
	}
	function generate_sa_control_number_view(){
		
		$username 	= $_POST['username'];
		$date		= date("Y-m-d");
		require_once('../class/oop_tqts.php');
		$division 	= return_system_division();
		$section 	= get_assigned_section_sa($username);
		$sar = 'SAR-';
	
		
		if(date('m') == 4) {
			$pattern 	= date('ym');
			$stat 		= 'new FY';
		} else {
			$pattern 	= date('ym');
			$stat 		= 'current FY';
		}
		
		$array_fields = array('control_number');
		$table 	   	= 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE date_created LIKE "%'.$pattern.'-%" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= 'LIMIT 0,1';
		$control_number= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows==0) {
			if($stat == 'current FY') {
				$sql_where 	= 'WHERE logdel=0';
				$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) {
					
					$control_number = $row['control_number'];
					$ctr 		 	= end(explode('-',$control_number));
					$series 	 	= str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
					$control_number =$sar.$division.'-'.$section.'-'. $pattern.'-'.$series;
				} else {
					
					$control_number = $sar.$division.'-'.$section.'-'.$pattern.'-001'; //ELSE
				}
			} else {
				// $control_number = $sar.$division.'-'.$section.'-'.$pattern.'-001'; // nmodify: (EVERY APRIL) activate this when the fiscal year is reset 
				/** nmodify : 03-04-23 after the user input first data in FY comment the 001 above then show this command 
				 * REASON: Auto Reset of control number every FY is not included in the TQTSV2 scoping.
				*/
				$sql_where 	= 'WHERE control_number LIKE "%-'.date('ym').'-%" AND logdel=0';
				$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) { /** nmodify: get the ControlNumber of the last data of SAR */
					$sar = 'SAR-';
					$control_number = $row['control_number'];
					$ctr 		 	= end(explode('-',$control_number));
					$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT); /** current Ctrl Num plus 1 */
					$control_number = $division.'-'.$section.'-'.$pattern.$series;
				} else {
					$sar = 'SAR-';
					$control_number = $sar.$division.'-'.$section.'-'.$pattern.'-001';
				}
			}
		} else {
			if($row = mysqli_fetch_array($result)) {
				
				$control_number = $row['control_number'];
				$ctr 		 	= end(explode('-',$control_number));
				$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
			}		
			$control_number = $sar.$division.'-'.$section.'-'.$pattern.$series;  
		}
		echo json_encode($control_number);
	}
	function generate_at_control_number_view(){
		require_once('../class/oop_tqts.php');
		
		$username 	= $_POST['username'];
		$date		= date("Y-m-d");
		$division 	= return_system_division();
		$section 	= get_assigned_section_sa($username);
		$sar = '';
	
		
		if(date('m') == 4) {
			$pattern 	= date('ym');
			$stat 		= 'new FY';
		} else {
			$pattern 	= date('ym');
			$stat 		= 'current FY';
		}
		
		$array_fields = array('control_no');
		$table 	   	= 'tbl_qfr_attention_tag';
		$joins 	   	= '';
		$sql_where 	= 'WHERE created_at	 LIKE "%'.$pattern.'-%" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= '';
		$control_number= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		 if($result->num_rows==0) {
			if($stat == 'current FY') {
				$sql_where 	= 'WHERE logdel=0';
				$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
				if($row = mysqli_fetch_array($result)) {
					
					$control_number = $row['control_no'];
					$ctr 		 	= end(explode('-',$control_number));
					$series 	 	= str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
					$control_number =$sar.$division.'-'.$section.'-'. $pattern.'-'.$series;
				} else {
					$control_number = $sar.$division.'-'.$section.'-'.$pattern.'-001'; //ELSE
				}
			} else {
				$control_number =$sar.$division.'-'.$section.'-'.$pattern.'-001'; //ELSE
			}
		} else {
			if($row = mysqli_fetch_array($result)) {
				
				$control_number = $row['control_no'];
				$ctr 		 	= end(explode('-',$control_number));
				$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
			}		
			$control_number = $sar.$division.'-'.$section.'-'.$pattern.$series;  
		}
		echo json_encode($control_number);
	}
	
	function replace_sa_file(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;

		$pkid 	= $_POST['attachment_pkid'];
		$return['filename'] 	= $_FILES['file_sa']['name'];
		$return['temp_name'] 	= $_FILES['file_sa']['tmp_name'];
		$return['ext']  		= pathinfo($return['filename'], PATHINFO_EXTENSION);
		$directory_path 		= return_file_path_by_div_mod('sa'); /* Get the file path */
		$array_fields = array('fkfile_path ,file_name');
		$table 	   	= 'tbl_qfr_special_acceptance_attachment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			/* Reupload the file. Delete the current file and replace by new one */
			$target_ext = end(explode('.',$row['file_name']));
			$ext =( $target_ext=='XLSX')? 'xlsx' : $target_ext;
			$target_file = $directory_path['path'].'e_'.$pkid .'.'. $ext;
			unlink($target_file);
			$upload_ext = ($return['ext']=='XLSX')? 'xlsx' : $return['ext'];
			move_uploaded_file($return['temp_name'],$directory_path['path'].'e_'.$pkid.'.'.$upload_ext);
			
			/* update the tbl_qfr_special_acceptance_attachment */
			$table			= 'tbl_qfr_special_acceptance_attachment';
			$array_fields 	= array('file_name','lastupdate','username');
			$array_values	= array($return['filename'],date('Y-m-d H:i:s'),$return['username']);
			$where 				= "WHERE `fkspecial_acceptance` = '$pkid'";
			$result 			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
			$return['script'] 	= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
			$return['result'] = 1;//nmodify
		}
		else{
			$return['result'] = 2;
			$return['error_msg'] = 'Uploading of File Failed';
		}
		echo json_encode($return);
	}
	
	
	function load_approver_table(){ 
		require_once('../class/oop_tqts.php');
		
		$return 		= $_POST;
		$pkid 			= $return ['pkid'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_qfr_sa_approvers';
		$joins 	   		= '';
		$sql_where 		= "WHERE fkid = '$pkid' AND `logdel` = 0 ";
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr 			= 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 	 = $row['pkid'];
			$return['approver_username'][$ctr] 	 = get_emp_name_by_username($row['approver_username']);
			if ($row['status'] == '0'){
				$return['status'][$ctr] = '<span class="badge highlight-color-yellow" >PENDING</span>' ;
			}else if ($row['status'] == '1'){
				$return['status'][$ctr] = '<span class="badge highlight-color-green" >APPROVED</span>' ;
			}else{
				$return['status'][$ctr] = 'DISAPPOVED' ;
			}
			$return['approver_remarks'][$ctr] = ($row['approver_remarks'] == '' ? '-' : $row['approver_remarks']);
			$return['date_time_approved'][$ctr] = ($row['date_time_approved'] == '' ? '-' : date('M d, Y h:i A',strtotime($row['date_time_approved'])));
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		echo json_encode($return);
	}
	function load_main_approver_table(){
		require_once('../class/oop_tqts.php');
		
		$return 		= $_POST;
		$pkid 			= $return ['pkid'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_qfr_sa_approvers_main';
		$joins 	   		= '';
		$sql_where 		= 'WHERE `fkid` = "'.$pkid.'" AND `logdel` = 0 ';
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr 			= 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 	 = $row['pkid'];
			$return['approver_username'][$ctr] 	 = get_emp_name_by_username($row['approver_username']);
			if ($row['status'] == '0'){
				$return['status'][$ctr] = '<span class="badge highlight-color-yellow" >PENDING</span>' ;
			}else if ($row['status'] == '1'){
				$return['status'][$ctr] = '<span class="badge highlight-color-green" >APPROVED</span>' ;
			}else{
				$return['status'][$ctr] = 'DISAPPOVED' ;
			}
			$return['approver_remarks'][$ctr] = ($row['approver_remarks'] == '' ? '-' : $row['approver_remarks']);
			$return['date_time_approved'][$ctr] = ($row['date_time_approved'] == '' ? '-' : date('M d, Y h:i A',strtotime($row['date_time_approved'])));
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		echo json_encode($return);
	}
	function validate_is_approver(){
		require_once('../class/oop_tqts.php');

		$return 		= $_POST;
		$result 		= '';
		$pkid 			= $return ['pkid'];
		$username	 	= $return ['username'];
		$array_fields 	= array('pkid');
		$table 	   		= 'tbl_qfr_sa_approvers';
		$joins 	   		= '';
		$sql_where 		= "WHERE `fkid`='$pkid' AND `status` = '0' AND `approver_username`='$username' AND `logdel`=0";
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,1';
		$ctr 			= 0;
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['is_approver'] = $result->num_rows;
		echo json_encode($return);
	}

	function validate_main_is_approver(){ /*NOTE:DEPARTMENT HEAD APPROVERS */
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$result 		= '';
		$pkid 			= $return ['pkid'];
		$username	 	= $return ['username'];
		$array_fields 	= array('approver_username');
		$table 	   		= 'tbl_qfr_sa_approvers_main';
		$joins 	   		= '';
		$sql_where 		= "WHERE `fkid`='$pkid' AND `status` = '0' AND `logdel`=0";
		$sql_order 		= 'ORDER BY order_id ASC';
		$sql_limit 		= 'LIMIT 0,1';
		$ctr 			= 0;
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// echo $result 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$return['approver_username'] =$row['approver_username'];
			// $return['approver_username'] = "ymatsuzaki"; //the approval is not base on number but base on the heirarchy (using username)
			/**
			 * Ex. Rita Morallos,Joel Padullo,Nian Lim, Matsuzalki, etc
			 */
		}
		$return['test'] = 'ok';
		echo json_encode($return);
		
	}
	function sa_approver_decision(){
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');	
		
		$return 		= $_POST;
		$fkid    		= $return['pkid'];
		$status   		= $return['status'];
		$remarks  		= $_POST['remarks'];
		$username  		= $return['username'];
		$msg		    = '';		
		$script 		= '';	
		
		/* Table */
		$table_details	= 'tbl_qfr_sa_approvers';
		$table_sa_main	= 'tbl_qfr_special_acceptance';

		/* Update the Table Approvers based on pkid */
		$row_status = 1;
		$array_fields 	= array('status', 'date_time_approved', 'approver_remarks','updated_at','username');
		$array_values 	= array($row_status, $date_time_today, $remarks, $date_time_today,$username);
		$sql_where		= 'WHERE `fkid`="'.$fkid.'" AND `approver_username`="'.$username.'" AND `logdel`= 0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		$script 		.= TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);

/** 
 	if All Approvers Approved, change the STATUS of the main table into 1 = APPROVED but if one person 
	DISAPPROVED change the main table STATUS 2 = DISAPPROVED 
*/
		if($status == "APPROVED"){ 
			$array_fields = array('*');
			/* table approver = table_details*/ 
			$joins 	   		= '';
			$sql_where 		= 'WHERE `fkid`="'.$fkid.'" AND `status`=1 AND `logdel`=0';
			$sql_order 		= 
			$sql_limit 		= '';
			$result = TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
			$row = mysqli_num_rows($result);
			if($row > 0){
				$new_status = 4;
				$array_fields 	= array('status');
				$array_values 	= array($new_status);
				$sql_where		= 'WHERE `pkid` = "'.$fkid.'" AND `logdel`=0';
				$msg 			= TQTS::getInstance()->update_query_detailed($table_sa_main,$array_fields,$array_values,$sql_where);
			
			/* ffunction sending of email to CHECK BY to approve the attachment with a status of FOR CHECKING */
				send_email_for_approval($fkid);
			}
		}else{
/**
*! ffunction - check if the status is disapproved it will update the $table_details status=2, also $table_sa_main 
*/
			sa_approver_disapproved($table_details,$array_fields,$sql_where,$date_time_today,$remarks,$username,$return);
			$new_status 	= 2;
			$array_fields 	= array('status');
			$array_values 	= array($new_status);
			$sql_where		= 'WHERE `pkid` = "'.$fkid.'" AND `logdel`=0';
			$msg 			= TQTS::getInstance()->update_query_detailed($table_sa_main,$array_fields,$array_values,$sql_where);
			
		}
		$return['script']  = $script;
		echo json_encode($return);
	}

	function sa_main_approver_decision(){ //fmodifynow
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');	
		
		$return 		= $_POST;
		$fkid    		= $return['pkid'];
		$status   		= $return['status'];
		$remarks  		= $_POST['remarks'];
		$username  		= $return['username'];
		$msg		    = '';		
		$script 		= '';	

		/* Table */
		$table_details	= 'tbl_qfr_sa_approvers_main';
		/* Update the Table Approvers based on pkid */
		$is_status = 1;
		$array_fields 	= array('status', 'date_time_approved', 'approver_remarks','updated_at','username');
		$array_values 	= array($is_status, $date_time_today, $remarks, $date_time_today,$username);
		$sql_where		= 'WHERE `fkid`="'.$fkid.'" AND `approver_username`="'.$username.'" AND `logdel`= 0';
		$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		$script 		.= TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);
		
/** 
 *!ffunction get decision if approved or disapproved  
*/
		sa_main_is_decision($status,$fkid,$table_details,$array_fields,$sql_where,$date_time_today,$remarks,$username,$return);
		
		echo json_encode($return);
	}

	function sa_main_is_decision($status,$fkid,$table_details,$array_fields,$sql_where,$date_time_today,$remarks,$username,$return){ //fmodifynow
		
		$table_sa_main	= 'tbl_qfr_special_acceptance';
		/* if All Approvers Approved, change the STATUS of the main table into 1 = APPROVED but if one person 
		DISAPPROVED change the main table STATUS 2 = DISAPPROVED */
		if($status == "APPROVED"){ 
			$array_fields = array('status');
			$joins 	   		= '';
			$sql_where 		= 'WHERE `fkid`="'.$fkid.'" AND `logdel`=0';
			$sql_order 		= 
			$sql_limit 		= '';
			$msg = '';
			$checker_status 	= 0;
			$result = TQTS::getInstance()->select_query($array_fields,$table_details,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){
				if($row['status'] == '0') {
					$rows_status = '0';
					/* Send email to all approver who's status is 0 = PENDING */
					send_email_for_approval($fkid);
					$checker_status = 1;
					break;
				}
			}
			if($checker_status ==0 ){ /* if row >= 3 the status will be approved and change status into FOR DISPOSITION */
				sa_send_ready_sending_disposition($fkid);
				$new_status = 1;
				$array_fields 	= array('status');
				$array_values 	= array($new_status);
				$sql_where		= 'WHERE `pkid` = "'.$fkid.'" AND `logdel`=0';
				$msg 			= TQTS::getInstance()->update_query_detailed($table_sa_main,$array_fields,$array_values,$sql_where);
				/*if all approvers approved, the email activated ready for disposition*/
			}
		}
		else{
		/* ffunction - check if the status is disapproved it will update the $table_details status=2, also $table_sa_main */
			sa_approver_disapproved($table_details,$array_fields,$sql_where,$date_time_today,$remarks,$username,$return);
			$new_status 	= 2;
			$array_fields 	= array('status');
			$array_values 	= array($new_status);
			$sql_where		= 'WHERE `pkid` = "'.$fkid.'" AND `logdel`=0';
			$msg 			= TQTS::getInstance()->update_query_detailed($table_sa_main,$array_fields,$array_values,$sql_where);
			// $script 		.= TQTS::getInstance()->update_query_detailed_script($table_sa_main,$array_fields,$array_values,$sql_where);
		}
		sa_send_email_approver_decision($fkid,$username,$status);
	}
	function sa_approver_disapproved($table_details,$array_fields,$sql_where,$date_time_today,$remarks,$username,$return){
		$script = '';
		$table_details;
		$array_fieldsx = implode(',',$array_fields);
		$array_fields = explode(',',$array_fieldsx);
		$new_status = 2;
		$array_values 	= array($new_status, $date_time_today, $remarks, $date_time_today,$username);
		$msg 			= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
	}

	function cancel_special_acceptance(){
		require_once('../class/oop_tqts.php');

		$return 		= $_POST;
		$pkid			= $return['pkid'];
		$table			= 'tbl_qfr_special_acceptance';
		$array_fields 	= array(
								'cancel_remarks',
								'status'
								);
		$array_values	= array(
								$_POST['cancel_remarks'],
								8
								);
		$where 				= "WHERE pkid = '$pkid'";
		$result 			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$return['script'] 	= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
		echo json_encode($return);
	}
	
	function check_sa_judgement() {
		require_once('../class/oop_tqts.php');
		$return 				= $_POST;
		$pkid					= $return['pkid'];
		$array_fields 			= array('judgement_application');
		$table 	   				= 'tbl_qfr_special_acceptance';
		$joins 	   				= '';
		$sql_where 				= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 				= '';
		$sql_limit 				= 'LIMIT 0,1';
		$result 				= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script					= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$judgement				= '';
		if($row = mysqli_fetch_array($result)) {
			if($row['judgement_application'] == ""){
				$judgement 	= 'No judgement';
			} else {
				$judgement 	= $row['judgement_application'];
			}
		} else {
			$judgement 	= 'No judgement';
		} 
		$return['judgement'] 	= $judgement;
		$return['script'] 	= $script;
		echo json_encode($return);
	}
	
/**
 * MODIFIED 11-2022 
 * ! vw_user_roles from tqts_ts DB is not applicable to use beacause ENGR is not found
 * ! vw_user_access from db_rapid DB
*/
	// function get_assigned_section_sa($username) {
	// 	require_once('../class/oop_tqts.php');
	// 	$array_fields = array('section');
	// 	$table      = 'vw_user_roles';
	// 	$joins      = '';
	// 	$sql_where  = 'WHERE subsystem_code="QFR" AND module="Special Acceptance" AND `user`="'.$username.'"';
	// 	$sql_order  = 'ORDER BY section';
	// 	$sql_limit  = 'LIMIT 0,1';
	// 	$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// 	if($row=mysqli_fetch_array($result)) {
	// 		return $row['section'];
	// 	} else {
	// 		return 'N/A';
	// 	}
	//  }
/**
 * MODIFIED 11-2022 
 * ! vw_user_access from db_rapid DB select the the department and validate if the user's department -
 * ! Engineering and LQC is exist, so create a condition below to get QC or ENGG 
*/
	function get_assigned_section_sa($username) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('department');
		$table      = 'vw_user_access';
		$joins      = '';
		$sql_where  = 'WHERE `username`="'.$username.'"';
		// $sql_where  = '';
		$sql_order  = '';
		$sql_limit  = '';
		$result = RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			$engineer = 'Engineer';
			$qc = 'LQC';
			$return_department =  $row['department'];
			$get_department = strstr( $return_department,$engineer );
			$get_department_qc = strstr( $return_department,$qc );
	/** !if the department is LIKE "Engineering" return ENGG,  if the department is LIKE "LQC" return QC , else return - */
			return  $department = ($get_department == "Engineering")?"ENGG":
					$department = ($get_department_qc == "LQC")? "QC":"-";

		} else {
			return 'N/A';
		}
	 }
	 
	 function load_at_info(){
		require_once('../class/oop_tqts.php');

		$pkid 			= $_POST['pkid'];
		$issued_by = array();
		$array_fields 	= array('*');
		$table      	= 'tbl_qfr_attention_tag';
		$joins      	= '';
		$sql_where  	= 'WHERE `pkid`="'.$pkid.'"';
		$sql_order  	= '';
		$sql_limit  	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		while($row = mysqli_fetch_array($result)){
			$return['pkid'] 				= $row['pkid'];
			$return['control_no'] 			= $row['control_no'];
			// $return['category']	 			= explode( ",", $row['category'] );
			$return['category']	 			= $row['category'];
			$return['date'] 				= $row['date'];
			$return['parts_po'] 				= $row['parts_po'];
			$return['product'] 				= $row['product'];
			$return['model'] 				= $row['model'];
			$return['part_code'] 			= $row['part_code'];
			$return['po_number'] 			= $row['po_number'];
			$return['lot_number'] 			= $row['lot_number'];
			$return['quantity'] 			= $row['quantity'];
			$return['description'] 			= $row['description'];
			$return['remarks'] 				= $row['remarks'];
			$issued_by[]		 			= $row['issued_by'];
	 	}
		$implode_issued_by = implode(',',$issued_by);
		$explode_issued_by = explode(',',$implode_issued_by);
		foreach ($explode_issued_by as $key => $value) {
			$array_data_app 				= array();
			$array_data_app['id'] 			= $value;
			$array_data_app['text'] 		= get_emp_name_by_username_systemone($value);
			$return['issuance_by'][]	= $array_data_app;
		}
		$table			= 'tbl_qfr_attention_tag_attachment';
		$return ['pkid'] = $pkid;
 		$array_fields 	= array('file_name');
		$joins      	= '';
		$sql_where  	= 'WHERE `fkid`="'.$pkid.'"';
		$sql_order  	= '';
		$sql_limit  	= 'LIMIT 0,1';
		$result_load_file = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result_load_file)){
			$return ['file_name'] = $row ['file_name'];
		}

		echo json_encode($return);
	}

	function save_attention_tag(){
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-d-m H:m:s');
		$return = $_POST;

		$control_number = $return['control_number'];
		// $category = implode(',',$return['category']);
		$category = $return['category'];
		$date= $return['date'];
		$parts_po= $return['radio_type_search'];
		$part_code= ($parts_po == 'Parts') ? $return['part_po'] :'';
		$po_number= ($parts_po == 'PO') ? $return['part_po'] :'';
		$issuance_by= $return['issuance_by'];
		$product= $return['product'];
		$lot_no= $return['lot_no'];
		$model= $return['model'];
		$quantity= $return['quantity'];
		$description= $return['description'];
		$remarks= $return['remarks'];
		$username= $return['username'];

		$table = 'tbl_qfr_attention_tag';
		$array_fields = array( 
			'control_no','category','date','parts_po','product','model','part_code','po_number','lot_number','quantity',
			'issued_by','description','remarks','status','created_by','created_at','updated_at','username'
		);
		/* add blanks to undefined or empty values */
		foreach($array_fields as $key => $value){
			if(!isset($return[$value]) || $return[$value] == ""){
				$return[$value] = "";
			}
		}
		$array_values =array(
			$control_number,$category,$date,$parts_po,$product,$model,$part_code,$po_number,$lot_no,$quantity,$issuance_by,
			$description,$remarks,1,$username,$date_time_today,$date_time_today,$username
		);
		$pkid = TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script = TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);

/* ffunction to get the file path:  ..uploaded_file/quality_report/attention_tag */
		$file  		     = return_file_path_by_div_mod('attention_tag');  
		$fkfile_path     = $file['pkid'];
		$target_dir      = $file['path'];


		if(!file_exists($target_dir.$pkid.'/')){ //qchange
			$target_dir = $target_dir.$pkid.'/';
			mkdir($target_dir,0777,false); /* 'if not exist make a folder named by pkid' */
		}
		$file_name = $_FILES['selected_file']['name'];
		$temp_file = $_FILES['selected_file']['tmp_name'];
		$ext = pathinfo($file_name,PATHINFO_EXTENSION);
		$target_file = $target_dir . $pkid . '.' . $ext;
		if(file_exists($target_file)){
			$return['msg'] = 'Sorry, the file already exists.';
		}else{
			$value = move_uploaded_file($temp_file,$target_file);
		}
		$table			= 'tbl_qfr_attention_tag_attachment';
		$return ['pkid'] = $pkid;
 		$array_fields 	= array(
			'created_by','fkid','file_name','fkfile_path','reason_delete','created_at','updated_at','username'
		);
		$array_values	= array(
			$username,$return['pkid'],$file_name,32,'',$date_time_today,$date_time_today,$username
		);
		$pkid_attachment = TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);

		echo json_encode($target_file);
	 }
	 function update_attention_tag(){
		require_once('../class/oop_tqts.php');

		$return = $_POST;
		$date_time_today = date('Y-m-d H:m:s');
		$pkid = $return['pkid'];
		$control_number = $return['control_number'];
		// $category = implode(',',$return['category']);
		$category = $return['category'];
		$date= $return['date'];
		$parts_po= $return['radio_type_search'];
		$part_code= ($parts_po == 'Parts') ? $return['part_po'] :'';
		$po_number= ($parts_po == 'PO') ? $return['part_po'] :'';
		$issued_by= $return['issuance_by'];
		$product= $return['product'];
		$lot_no= $return['lot_no'];
		$model= $return['model'];
		$quantity= $return['quantity'];
		$description= $return['description'];
		$remarks= $return['remarks'];
		$username= $return['username'];

		$table = 'tbl_qfr_attention_tag';
		$array_fields = array( 
			'control_no','category','date','parts_po','part_code','po_number','product','model','lot_number','quantity',
			'issued_by','description','remarks','updated_at'
		);
		/* add blanks to undefined or empty values */
		foreach($array_fields as $key => $value){
			if(!isset($return[$value]) || $return[$value] == ""){
				$return[$value] = "";
			}
		}
		$array_values =array(
			$control_number,$category,$date,$parts_po,$part_code,$po_number,$product,$model,$lot_no,$quantity,$issued_by,
			$description,$remarks,$date_time_today
		);
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);

		$file  		     = return_file_path_by_div_mod('attention_tag');  
		$path     = $file['path'];
	
		$file_name = $_FILES['selected_file']['name'];
		$temp_file = $_FILES['selected_file']['tmp_name'];
		$ext = pathinfo($file_name,PATHINFO_EXTENSION);
		$target_file = $path . $pkid . '/' . $pkid . '.' . $ext;
		if(file_exists($target_file)){
			move_uploaded_file($temp_file,$target_file);
		}

		$table			= 'tbl_qfr_attention_tag_attachment';
		$array_fields 	= array(
			'file_name','updated_at'
		);
		$array_values	= array(
			$file_name,$date_time_today
		);
		$where = 'WHERE `fkid` = "'.$pkid.'"';
		$updated_file_name = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);

		echo json_encode($return);
	 }
	 function cancel_attention_tag(){
		require_once('../class/oop_tqts.php');

		$return = $_POST;
		$pkid = $return['pkid'];
		$remarks = $return['cancel_remarks'];
		$table			= 'tbl_qfr_attention_tag';
		$array_fields 	= array('status','remarks');
		$array_values	= array(2,$remarks);
		$where = 'WHERE `pkid` = "'.$pkid.'"';

		$result = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		echo json_encode($return);
	 }
	 function return_at_approvers_log($approvers) {
		 $approvers_count = count(explode(',', implode(',',$approvers)));
		 $approvers_log = '';
		 if($approvers_count != 0) {
			 $approvers_log = array();
			 for($i=0; $i<$approvers_count; $i++) {
				 $approvers_log[] = 'PENDING';
			 }
			 $approvers_log = implode(' | ', $approvers_log);
		 }
		 return $approvers_log;
	 }
	 function edit_attention_tag(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$table="tbl_qfr_attention_tag";
		$fields_and_values = get_fields_values($_POST, array('pkid','action','username','control_no'));
		$array_fields 	= $fields_and_values['array_fields'];
		$array_values 	= $fields_and_values['array_values'];
		if(trim($_POST['disposition']) != ""){
			$array_fields[] = 'status'; $array_values[] = 'Closed';
		}
		/* Add Field					Add Values */
		$array_fields[] = 'username'; 		$array_values[] = $return['username'];
		$array_fields[] = 'created_by'; 	$array_values[] = $return['username'];
		$array_fields[] = 'date_created'; 	$array_values[] = date('Y-m-d H:i:s');
		$array_fields[] = 'lastupdate';		$array_values[] = date('Y-m-d H:i:s');
		$pkid 			= $_POST['pkid'];
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return = array();
		// $return['script'] 				= $script;
		// $return['fields_and_values']  	= $fields_and_values;
		echo json_encode($return);
	 }
	 
	 function save_approvers_attention_tag_decision(){
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');
		$return = $_POST;
		$pkid 			= $_POST['pkid'];
		$username 		= $_POST['username'];
		/* Select approval record of approver */
		$status_field 	= '';
		$array_fields 	= array('*');
		$table      	= 'tbl_qfr_attention_tag';
		$joins      	= '';
		$sql_where  	= 'WHERE `pkid`="'.$pkid.'"';
		$sql_order  	= '';
		$sql_limit  	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_array($result)){
			$logs = $_POST['status'] . ' - '.date('M d, Y h:i A');
			
			if(strstr($row['prdn_approver'], $username)) {
				$approver_array 	= explode(',', $row['prdn_approver']);
				$prdn_approver_logs = explode(' | ', $row['prdn_approver_logs']);
				$index 				= array_search($username, $approver_array);
				$status_field 		= 'prdn_approver_logs';
				$prdn_approver_logs[$index] = $logs;
			} else if(strstr($row['engr_approver'], $username)) {
				$approver_array 	= explode(',', $row['engr_approver']);
				$prdn_approver_logs = explode(' | ', $row['engr_approver_logs']);
				$index 				= array_search($username, $approver_array);
				$status_field 		= 'engr_approver_logs';
				$prdn_approver_logs[$index] = $logs;
			} else if(strstr($row['ppc_approver'], $username)) {
				$approver_array 	= explode(',', $row['ppc_approver']);
				$prdn_approver_logs = explode(' | ', $row['ppc_approver_logs']);
				$index 				= array_search($username, $approver_array);
				$status_field 		= 'ppc_approver_logs';
				$prdn_approver_logs[$index] = $logs;
			} else if(strstr($row['qc_approver'], $username)) {
				$approver_array 	= explode(',', $row['qc_approver']);
				$prdn_approver_logs = explode(' | ', $row['qc_approver_logs']);
				$index 				= array_search($username, $approver_array);
				$status_field 		= 'qc_approver_logs';
				$prdn_approver_logs[$index] = $logs;
			}				
			
			if($status_field != '') {
				$table			= "tbl_qfr_attention_tag";
				$array_fields 	= array($status_field, 'lastupdate', 'username');
				$array_values 	= array($prdn_approver_logs, $date_time_today, $_POST['username']);
				// $result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
				$script = TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
			}
		}
		
		$return['script'] 				= $script;
		$return['fields_and_values']  	= $_POST;
		echo json_encode($return);
	 }
	function get_assigned_section_at($username) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('section');
		$table      = 'vw_user_roles';
		$joins      = '';
		$sql_where  = 'WHERE subsystem_code="QFR" AND module="Attention Tag" AND `user`="'.$username.'"';
		$sql_order  = 'ORDER BY section';
		$sql_limit  = 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			return $row['section'];
		} else {
			return 'N/A';
		}
	 }
	 function change_itn_at_status(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$table			= "tbl_qfr_attention_tag";
		$array_fields 	= array('status');
		$array_values 	= array($_POST['status']);
		$pkid 			= $_POST['pkid'];
		$result 		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return 		= array();
		echo json_encode($return);
	 }
	 /* **********************
		Advance Search
	 ********************** */
	 function qfr_return_at_fields(){
		$fields = get_field_names('tbl_qfr_attention_tag',array('pkid','created_by','date_created','lastupdate','username','logdel'));
		$ctr = 0;
		$option		  =	array();
		foreach($fields as $key => $value){
			$option[$ctr] = '<option value="'.$value.'">'.get_field_text_display($value).'</option>'; $ctr++;
		}		
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	 }
	 
	 function at_advance_search() {
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
	
	function qfr_return_ng_fields(){
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="status">Status</option>'; $ctr++;
		$option[$ctr] = '<option value="issuance_no">Issuance #</option>'; $ctr++;
		$option[$ctr] = '<option value="rev_no">Revision No</option>'; $ctr++;
		$option[$ctr] = '<option value="issuance_date">Issuance Date</option>'; $ctr++;
		$option[$ctr] = '<option value="invoice_no">Invoice #</option>'; $ctr++;
		$option[$ctr] = '<option value="part_code">Partcode</option>'; $ctr++;
		$option[$ctr] = '<option value="lot_no">Lot #</option>'; $ctr++;
		$option[$ctr] = '<option value="drawing_number">Drawing #</option>'; $ctr++;
		$option[$ctr] = '<option value="file_name">File Name</option>'; $ctr++;
		$option[$ctr] = '<option value="supplier">Supplier</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	function ng_advance_search() {
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
	
	function qfr_return_sa_fields(){
		$fields = get_field_names('tbl_qfr_special_acceptance',array('pkid','created_by','date_created','lastupdate','username','logdel'));
		$ctr = 0;
		$option		  =	array();
		foreach($fields as $key => $value){
			$option[$ctr] = '<option value="'.$value.'">'.get_field_text_display($value).'</option>'; $ctr++;
		}
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	function sa_advance_search() {
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
	
    function get_material_type_list() {				
		require_once('../class/oop_tqts.php');		
		$array_fields = array('material_type');		
		$table 	   	= 'tbl_material_type';
		$joins 	   	= '';
		$sql_where 	= 'WHERE logdel=0';	
		$sql_order 	= '';	
		$sql_limit 	= '';	
		$html_select= '';		
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);		
		while($row=mysqli_fetch_array($result)) {		
			$html_select .= '<option value="'.$row['material_type'].'">'.$row['material_type'].'</option>';	
		}		
		$return['html_select'] = $html_select;		
		echo json_encode($return);		
	}	
	
	/* 
		ITN - Inspection Trouble Report 
	*/
	function save_itn(){
		require_once('../class/oop_tqts.php');
		$control_no 			= generate_itn_issuance_no( date('Y-m-d H:i:s'), $_POST['username'] );
		$error = '';
		if(is_array($control_no)){
			$error = array();
			$error[] = $control_no;
		}
		/* save itn if no error was encountered */
		if( $error == '' ){
			$values			= get_fields_values($_POST, array('action','control_no'));
			$table			= 'tbl_qfr_itn';
			$array_fields	= $values['array_fields'];
			$array_values	= $values['array_values'];
			$array_fields[] = 'control_no'; 	$array_values[] = $control_no;
			$array_fields[] = 'date_created'; 	$array_values[] = date('Y-m-d H:i:s');
			$array_fields[] = 'created_by'; 	$array_values[] = $_POST['username'];
			$array_fields[] = 'lastupdate'; 	$array_values[] = date('Y-m-d H:i:s');
			$result 		= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		}
		$return['error'] 		= $error;
		echo json_encode($return);
	}
	
	function generate_itn_issuance_no($date,$username){
		require_once('../class/oop_tqts.php');
		$division 	= return_system_division();
		$section 	= get_assigned_section_itn($username);
		$array_fields = array('control_no');
		$table 	   	= 'tbl_qfr_itn';
		$joins 	   	= '';
		$sql_where 	= 'WHERE date_created LIKE "%'.date('Y').'-%" AND logdel=0';
		$sql_order 	= 'ORDER BY pkid DESC';
		$sql_limit 	= 'LIMIT 0,1';
		$issuance_no= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($result->num_rows==0) {
			$issuance_no = $division.'-'.$section.'-'.date('ym').'-001';
		} else {
			if($row = mysqli_fetch_array($result)) {
				$issuance_no = $row['control_no'];
				$ctr 		 	= end(explode('-',$issuance_no));
				$series 	 	= '-'.str_pad(($ctr+1),3,"0",STR_PAD_LEFT);
			}		
			$issuance_no = $division.'-'.$section.'-'.date('ym').$series;
		}
		if(is_array($section)){
			$issuance_no = array();
			$issuance_no['error'] = $section['error'];
		}
		return $issuance_no;
	}
	
	function get_assigned_section_itn($username) {
		require_once('../class/oop_tqts.php');
		$array_fields = array('section');
		$table      = 'vw_user_roles';
		$joins      = '';
		$sql_where  = 'WHERE subsystem_code="QFR" AND module="ITN" AND `user`="'.$username.'"';
		$sql_order  = 'ORDER BY section';
		$sql_limit  = 'LIMIT 0,1';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$section  	= '';
		if($row=mysqli_fetch_array($result)) {
			if($row['section'] != ''){
				$section = $row['section'];
			}else{
				$section = array();
				$section['error']	= 'No section assigned to employee, please contact ISS Loc(205)!';
			}
		} else {
			$section = array();
			$section['error']		= 'No section assigned to employee, please contact ISS Loc(205)!';
		}
		return $section;
	 }
	 
	 function get_control_no_itn_display(){
		$control_no = generate_itn_issuance_no( date('Y-m-d H:i:s'), $_POST['username'] );
		$error = '';
		if(is_array($control_no)){
			$error 				= $control_no['error'];
		}
		$return['error'] 		= $error;
		$return['control_no'] 	= $control_no;
		echo json_encode($return);
	 }
	 
	 function get_itn_details(){
		 require_once('../class/oop_tqts.php');
		 $pkid   = $_POST['pkid'];
		 $table  = "tbl_qfr_itn";
		 $fields = get_table_fields($table);
		 $array_fields = array('*');
		 $table  		= "tbl_qfr_itn";
		 $joins  	 	= "";
		 $sql_where  	= "WHERE `pkid` = '$pkid'";
		 $sql_order  	= "";
		 $sql_limit  	= "";
		 $result        = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		 $return        = array();
		 while($row = mysqli_fetch_array($result)){
			 $not_included_field = array('pkid','created_by','date_created','lastupdate','username');
			 foreach($fields as $key => $value){
				 $return[$value] = $row[$value];
			 }
		 }
		 echo json_encode($return);
	 }
	 
	 function update_itn(){
		require_once('../class/oop_tqts.php');
		$error = '';
		/* update itn if no error was encountered */
		if( $error == '' ){
			$values			= get_fields_values($_POST, array('action','control_no'));
			$pkid 			= $_POST['pkid'];
			$table			= 'tbl_qfr_itn';
			$array_fields	= $values['array_fields'];
			$array_values	= $values['array_values'];
			$array_fields[] = 'lastupdate'; 	$array_values[] = date('Y-m-d H:i:s');
			$array_fields[] = 'username'; 		$array_values[] = $_POST['username'];
			if(!isset($_POST['shift_a'])){		$array_fields[] = 'shift_a'; 		$array_values[] = 0; }
			if(!isset($_POST['shift_b'])){ 		$array_fields[] = 'shift_b'; 		$array_values[] = 0; }
			if(!isset($_POST['shift_c'])){ 		$array_fields[] = 'shift_c'; 		$array_values[] = 0; }
			if(!isset($_POST['gate'])){    		$array_fields[] = 'gate'; 			$array_values[] = 0; }
			if(!isset($_POST['surveillance'])){ $array_fields[] = 'surveillance'; 	$array_values[] = 0; }
			if(!isset($_POST['normal'])){    	$array_fields[] = 'normal'; 		$array_values[] = 0; }
			if(!isset($_POST['tightened'])){    $array_fields[] = 'tightened'; 		$array_values[] = 0; }
			if(!isset($_POST['reduced'])){    	$array_fields[] = 'reduced'; 		$array_values[] = 0; }
			$result 		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		}
		$return['POST'] 		= $_POST;
		$return['error'] 		= $error;
		echo json_encode($return);
	 }
	 
	 function change_status_itn(){
		require_once('../class/oop_tqts.php');
		$error = '';
		/* update itn if no error was encountered */
		if( $error == '' ){
			$pkid 			= $_POST['pkid'];
			$status 		= $_POST['status'];
			$table			= 'tbl_qfr_itn';
			$array_fields   = array('status');
			if($status == "Open"){
				$array_values   = array('Closed');
			}else{
				$array_values   = array('Open');
			}
			$array_fields[] = 'lastupdate'; 	$array_values[] = date('Y-m-d H:i:s');
			$array_fields[] = 'username'; 		$array_values[] = $_POST['username'];
			$result 		= TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		}
		$return = array();
		$return['POST'] 		= $_POST;
		$return['result'] 		= $result;
		$return['error'] 		= $error;
		echo json_encode($return);
	 }
	/* ITN - End */
	
	/* PTIS */
	function qfr_return_ptis_fields(){
		$ctr = 0;
		$option		  		= array();
		$option[$ctr] 		= '<option value="`ptis`.`ptisNo`">PTIS Control No.</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`ptis`.`regDate`">Date</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`ptis`.`family`">Family</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`po`.`deviceName`">Device Name</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`po`.`poNumber`">P.O. No.</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`po`.`poQty`">P.O. Qty.</option>'; $ctr++;
		$option[$ctr]	 	= '<option value="`po`.`shipDate`">Original Shipment Date</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`problem`.`problemType`">Problem (NG Parameter/s)</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`ptis`.`judgementPMI`">PMI Disposition</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`ptis`.`approval1`">Senior Engineer In-charge</option>'; $ctr++;		
		$option[$ctr] 		= '<option value="`ptis`.`judgementYEC`">YEC Disposition</option>'; $ctr++; $ctr++;
		$option[$ctr] 		= '<option value="`problem`.`problemType`">Effect on Socket</option>'; $ctr++;
		$option[$ctr] 		= '<option value="`ptis`.`incharge`">Process Engineer In-charge</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	}
	
	function ptis_advance_search(){
		require_once('../class/oop_ptis.php');
		$field_name		= array();
		$condition		= array();
		$value			= array();
		$field_name 	= $_POST['field_name'];
		$condition 		= $_POST['condition'];
		$value	 		= $_POST['val'];
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
			$sql_where		= 'WHERE '.$sql_where_and.' AND '.$sql_where_or;
		} else if($sql_where_and != '' && $sql_where_or == '') {
			$sql_where		= 'WHERE '.$sql_where_and;
		} else if($sql_where_and == '' && $sql_where_or != '') {
			$sql_where		= 'WHERE '.$sql_where_or;
		}
		
		$result['post_value'] = $_POST;
		$result['sql_where'] = $sql_where;
		echo json_encode($result);
	}

	function get_supplier_by_pkid() {
        require_once('../class/oop_tqts.php');
        $pkid 		= $_POST['pkid'];
		$array_fields = array('supplier');
		$table 	   	= 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			$array_supp	 		= explode(",",$row['supplier']);
			$return['supplier']	= array();
			foreach($array_supp as $key => $value){
				$array_data_supp 			= array();
				$array_data_supp['id'] 		= $value;
				$array_data_supp['text'] 	= $value;
				$return['supplier'][]		= $array_data_supp;
			}
			$return['supplier_name'] = $row['supplier'];
		}
		echo json_encode($return);
    }

	/** Select All Special Acceptance Info*/
	function select_all_sa_data($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		require_once('../class/oop_tqts.php');
			
		$result = '';
		$return = array();
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_array($result)){
			$return['control_number'] 			= $row['control_number'];
			$return['created_by'] 				= $row['created_by'];
			$return['part_code'] 				= $row['part_code'];
			$return['parts_affected_parts'] 	= $row['parts_affected_parts'];
			$return['po_number'] 				= $row['po_number'];
			$return['device_name']				= $row['device_name'];
			$return['problem_device']			= $row['problem_device'];
			$return['lot_number']				= $row['lot_number'];
			$return['drawing_number'] 			= $row['drawing_number'];
			$return['supplier'] 				= $row['supplier'];
			$return['judged_by_approver'] 		= $row['judged_by_approver'];
			$return['judged_by_qc'] 			= $row['judged_by_qc'];
			$return['customer_name'] 			= $row['customer_name'];
			$return['other_details'] 			= $row['other_details'];
		}
		$return['created_by'];
		return $return;
	}
	/* NOTE: femail FUNCTION FOR AUTO EMAILER */
	//bamail
	function send_email_for_checking($pkid){ //fmail
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email_qfr_sa.php');

		$date= date('Y-m-d');
		$date_today = date('M d, Y',strtotime($date));	
		$issuance_date= $date_today;
		$array_fields = array('*');
		$table 	  = 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$where 	= 'WHERE pkid="'.$pkid.'" AND `status`=0 AND `logdel`=0';
		$order 	= '';
		$limit 	= '';

	/* ffunction to get special acceptance data */
		$return= select_all_sa_data($array_fields,$table,$joins,$where,$order,$limit);

		$created_by 			= $return['created_by'];
		$control_number 		= $return['control_number'];
		$part_code 				= $return['part_code'];
		$parts_affected_parts 	= $return['parts_affected_parts'];
		$po_number 				= $return['po_number'];
		$device_name			= $return['device_name'];
		$problem_device			= $return['problem_device'];
		$lot_no					= $return['lot_number'];
		$drawing_number 		= $return['drawing_number'];
		$supplier 				= $return['supplier'];
		$judged_by_qc 			= $return['judged_by_qc'];
		$judged_by_approver 	= $return['judged_by_approver'];
		$customer_name 			= $return['customer_name'];
		$remarks 				= $return['other_details'];
	
		if($part_code != '') {
			$subject		= 'FOR CHECKING SPECIAL ACCEPTANCE REPORT: '.$part_code.' ('.$parts_affected_parts.')';

			$part_details	= '&emsp;Part Code: '.$part_code.' <br>';
			$part_details	.= '&emsp;Part Name: '.$parts_affected_parts.'<br>';
			$part_details	.= '&emsp;Fail Mode: '.$lot_no.' <br>';
			$part_details	.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
			$part_details	.= '&emsp;Customer Name: '.$supplier.' <br>';
			$body 	 	 	= 'This is to inform you that the Special Acceptance report request with Part Code: '.$part_code.' is ready for sending to Customer.<br> <br>';
		}else if($po_number != ''){
			$subject 		= 'FOR CHECKING SPECIAL ACCEPTANCE REPORT: '.$po_number.' ('.$device_name.')';
			$part_details 	= '&emsp;PO Number: '.$po_number.' <br>';
			$part_details 	.= '&emsp;Device Name: '.$device_name.' <br>';
			$part_details 	.= '&emsp;Fail Mode: '.$problem_device.' <br>';
			$part_details 	.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
			$part_details 	.= '&emsp;Customer Name: '.$supplier.' <br>';
			$body 	 	 	= 'This is to inform you that the Special Acceptance report request with PO Number: '.$po_number.' is ready for sending to Supplier.<br> <br>';
		}else if ($part_code == '' && $po_number == ''){
			$subject 		 	= 'FOR CHECKING SPECIAL ACCEPTANCE REPORT ';
		}

		$body 	 	 = 'Please be informed that you have Special Acceptance Report for approval.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;Control No. : '.$control_number.' <br>';
		$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
		$body 		.= $part_details;
		// $body 		.= '&emsp;Fail Mode.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
		
		//load the special acceptance, if the qc approver exist, email to QC else email to Checked/Approved by
		$qc_approvers['approver_name'] = load_qc_approver($pkid); 
		$to = array();
		$qc_approver_username = implode(',',$qc_approvers['approver_name']);
		if($qc_approver_username != 'NONE'){
			$to[]	= return_user_email_add($qc_approver_username) == 'NONE' ? '' : return_user_email_add($qc_approver_username);
		}else{
			$approvers['approver_username'] = load_sa_approvers($pkid);
			$approver_username = implode(',',$approvers['approver_username']);
			$approver_username  = explode(',',$approver_username);
			foreach($approver_username as $new_approver_username) {
				$to_recipients	= return_user_email_add($new_approver_username) == 'NONE' ? '' : return_user_email_add($new_approver_username);
				array_push($to,$to_recipients);
			}
		}
		$to_recipients = implode(',',$to);
		$from_email	= return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);

		$to = $to_recipients;
		$from = $from_email;
		$cc= '';
		/** Send the email to the approvers (QC or Manager and Section Head) */
		
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc, $subject, $body, '', ''); //amail
	}

	function send_email_for_approval($pkid){ //gmail
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email_qfr_sa.php');


		$date= date('Y-m-d');
		$date_today = date('M d, Y',strtotime($date));	
		$issuance_date= $date_today;
		$array_fields = array('*');
		$table 	  = 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$where 	= 'WHERE pkid="'.$pkid.'" AND `status`=4 AND `logdel`=0';
		$order 	= '';
		$limit 	= '';

	/* ffunction to get special acceptance data */
		$return= select_all_sa_data($array_fields,$table,$joins,$where,$order,$limit);

		$created_by 			= $return['created_by'];
		$control_number 		= $return['control_number'];
		$part_code 				= $return['part_code'];
		$parts_affected_parts 	= $return['parts_affected_parts'];
		$po_number 				= $return['po_number'];
		$device_name			= $return['device_name'];
		$problem_device			= $return['problem_device'];
		$lot_no					= $return['lot_number'];
		$drawing_number 		= $return['drawing_number'];
		$supplier 				= $return['supplier'];
		$customer_name 			= $return['customer_name'];
		$remarks 				= $return['other_details'];

		if($part_code != '') {
			$subject 		 	= 'FOR APPROVAL SPECIAL ACCEPTANCE REPORT: '.$part_code.' ('.$parts_affected_parts.')';
			$part_details 		= '&emsp;Part Code: '.$part_code.' <br>';
			$part_details 	   .= '&emsp;Part Name: '.$parts_affected_parts.'<br>';
			$part_details 	   .= '&emsp;Fail Mode: '.$lot_no.' <br>';
			$part_details 		.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
			$part_details 		.= '&emsp;Customer Name: '.$supplier.' <br>';
			$body 	 	 		= 'This is to inform you that the Special Acceptance report request with Part Code: '.$part_code.' is ready for sending to Supplier.<br> <br>';
		}else if($po_number != ''){
			$subject 		 	= 'FOR APPROVAL SPECIAL ACCEPTANCE REPORT: '.$po_number.' ('.$device_name.')';
			$part_details 	    = '&emsp;PO Number: '.$po_number.' <br>';
			$part_details 	   .= '&emsp;Device Name: '.$device_name.' <br>';
			$part_details 	   .= '&emsp;Fail Mode: '.$problem_device.' <br>';
			$part_details 	   .= '&emsp;Drawing Number: '.$drawing_number.' <br>';
			$part_details 	   .= '&emsp;Customer Name: '.$supplier.' <br>';
			$body 	 	 		= 'This is to inform you that the Special Acceptance report request with PO Number: '.$po_number.' is ready for sending to Supplier.<br> <br>';
		}else if ($part_code == '' && $po_number == ''){
			$subject 		 	= 'FOR APPROVAL SPECIAL ACCEPTANCE REPORT ';
		}
		$body 	 	 = 'Please be informed that you have Special Acceptance Report for approval.<br> <br>';
		$body 		.= 'Request details: <br>';
		$body 		.= '&emsp;Control No.: '.$control_number.' <br>';
		$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
		$body 		.= $part_details;
		// $body 		.= '&emsp;Lot No.: '.$lot_no.' <br>';
		$body 		.= '&emsp;Remarks: '.$remarks.' <br>';

		
		$result = '';
		$array_fields = array('approver_username');
		$sql_table = 'tbl_qfr_sa_approvers_main';
		$sql_join = '';
		$sql_where = 'WHERE `fkid` ="'.$pkid.'" AND `status` = 0 AND `logdel` = 0';
		$sql_order = '';
		$sql_limit = '';
		$returns = array();
		$result = TQTS::getInstance()->select_query($array_fields,$sql_table,$sql_join,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$sql_table,$sql_join,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			$approver_username = $row ['approver_username'];
			$to_recipients[]	= return_user_email_add($approver_username) == 'NONE' ? '' : return_user_email_add($approver_username);

		}
		$to 	= array();
		$from	= '';
		$cc = '';

		$to = implode(',',$to_recipients);
		$from = return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);;
		$cc=  '';
		// $to = 'cdcasuyon@pricon.ph';
		// $from = '';
		// $cc= '';
		$php_mailer = new email();
		$php_mailer->send_email($to, $from, $cc, $subject, $body, '', '');//amail
	}

	function sa_send_ready_sending_disposition($pkid){ //hmail

		require_once('../class/oop_tqts.php');
		require_once('../class/send_email_qfr_sa.php');


		$array_fields = array('*');
		$date= date('Y-m-d');
		$date_today = date('M d, Y',strtotime($date));	
		$table 	  = 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND `status`=4 AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_array($result)){

			$created_by 				= $row['created_by'];
			$control_number 			= $row['control_number'];
			$issuance_date 				= $date_today; //date today
			$part_code 					= $row['part_code'];
			$parts_affected_parts 		= $row['parts_affected_parts'];
			$po_number 					= $row['po_number'];
			$device_name				= $row['device_name'];
			$problem_device				= $row['problem_device'];
			$lot_no						= $row['lot_number'];
			$drawing_number 			= $row['drawing_number'];
			$supplier 					= $row['supplier'];
			$customer_name 				= $row['customer_name'];
			$remarks 					= $row['other_details'];

			if($part_code != '') {
				$subject 		 	= 'FOR SENDING SPECIAL ACCEPTANCE REPORT : '.$part_code.' ('.$parts_affected_parts.')';
				$part_details	= '&emsp;Part Code: '.$part_code.' <br>';
				$part_details	.= '&emsp;Part Name: '.$parts_affected_parts.'<br>';
				$part_details	.= '&emsp;Fail Mode: '.$lot_no.' <br>';
				$part_details	.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
				$part_details	.= '&emsp;Customer Name: '.$supplier.' <br>';
				$body 	 	 	= 'This is to inform you that the Special Acceptance report request with Part Code: '.$part_code.' is ready for sending to Supplier.<br> <br>';
			}else if($po_number != ''){
				$subject 		 	= 'FOR SENDING SPECIAL ACCEPTANCE REPORT : '.$po_number.' ('.$device_name.')';
				$part_details 	= '&emsp;PO Number: '.$po_number.' <br>';
				$part_details 	.= '&emsp;Device Name: '.$device_name.' <br>';
				$part_details 	.= '&emsp;Fail Mode: '.$problem_device.' <br>';
				$part_details 	.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
				$part_details 	.= '&emsp;Customer Name: '.$supplier.' <br>';
				$body 	 	 	= 'This is to inform you that the Special Acceptance report request with PO Number: '.$po_number.' is ready for sending to Supplier.<br> <br>';
			}else if ($part_code == '' && $po_number == ''){
				$subject 		 	= 'FOR CHECKING SPECIAL ACCEPTANCE REPORT ';
			}
	
			$body 		.= 'Request details: <br>';
			$body 		.= '&emsp;Control No. : '.$control_number.' <br>';
			$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
			$body 		.= $part_details;
			$body 		.= '&emsp;Remarks: '.$remarks.' <br>';

			// $array_fields = array('`user`');
			// $table 	   	= 'tbl_user_roles';
			// $joins 	   	= '';
			// $sql_where 	= 'WHERE fk_module="4" AND `read` = 1 AND logdel=0';
			// $sql_order 	= '';
			// $sql_limit 	= '';
			// $to_array	= array();
			// $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			// while($row = mysqli_fetch_array($result)){
			// 	if(return_user_email_add($row['user']) != 'NONE') {
			// 		$to_array[] 	= return_user_email_add($row['user']);
			// 	}
			// }
			// $to 		 = implode(',', $to_array);
			// $cc 		= '';
			// $from 		 = 'TQTSystemNotification@pricon.ph';

			$to 		= 'jccataya@pricon.ph'; 
			$cc 		= '';
			$from 		= 'TQTSystemNotification@pricon.ph';
			$php_mailer = new email();
			$php_mailer->send_email($to,$from,$cc,$subject,$body,'',''); //amail
		}
	}
	function sa_send_email_approver_decision($pkid, $approver_username, $status) { //imail
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email_qfr_sa.php');

		$array_fields = array('*');
		$date= date('Y-m-d');
		$date_today = date('M d, Y',strtotime($date));	
		$table 	  = 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$pkid.'" AND `logdel`=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_array($result)){

			$created_by 				= $row['created_by'];
			$control_number 			= $row['control_number'];
			$issuance_date 				= $date_today; //date today
			$part_code 					= $row['part_code'];
			$parts_affected_parts 		= $row['parts_affected_parts'];
			$po_number 					= $row['po_number'];
			$device_name				= $row['device_name'];
			$problem_device				= $row['problem_device'];
			$lot_no						= $row['lot_number'];
			$drawing_number 			= $row['drawing_number'];
			$supplier 					= $row['supplier'];
			$customer_name 				= $row['customer_name'];
			$remarks 					= $row['other_details'];
			if($part_code != '') {
				$subject 		 	= ''.$status.' SPECIAL ACCEPTANCE REPORT : '.$part_code.' ('.$parts_affected_parts.')';
				$part_details	= '&emsp;Part Code: '.$part_code.' <br>';
				$part_details	.= '&emsp;Part Name: '.$parts_affected_parts.'<br>';
				$part_details	.= '&emsp;Fail Mode: '.$lot_no.' <br>';
				$part_details	.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
				$part_details	.= '&emsp;Supplier: '.$supplier.' <br>';
				$body 	 	 	= 'This is to inform you that the Special Acceptance report request with Part Code: '.$part_code.' is ready for sending to Supplier.<br> <br>';
			}else if($po_number != ''){
				$subject 		 	= ''.$status.' SPECIAL ACCEPTANCE REPORT : '.$po_number.' ('.$device_name.')';
				$part_details 	= '&emsp;PO Number: '.$po_number.' <br>';
				$part_details 	.= '&emsp;Device Name: '.$device_name.' <br>';
				$part_details 	.= '&emsp;Fail Mode: '.$problem_device.' <br>';
				$part_details 	.= '&emsp;Drawing Number: '.$drawing_number.' <br>';
				$part_details 	.= '&emsp;Supplier: '.$customer_name.' <br>';
				$body 	 	 	= 'This is to inform you that the Special Acceptance report request with PO Number: '.$po_number.' is ready for sending to Supplier.<br> <br>';
			}else if ($part_code == '' && $po_number == '' ){
				$subject 		 	= 'FOR CHECKING SPECIAL ACCEPTANCE REPORT ';
			}
			
			$body 	 	 = 'Please be informed that your Special Acceptance Report has been '.$status.'.<br> <br>';
			$body 		.= 'Request details: <br>';
			$body 		.= '&emsp;Issuance Date: '.$issuance_date.' <br>';
			$body 		.= '&emsp;Control No. : '.$control_number.' <br>';
			$body 		.= $part_details;
			$body 		.= '&emsp;Remarks: '.$remarks.' <br>';
			
			$to 		 = return_user_email_add($created_by) == 'NONE' ? '' : return_user_email_add($created_by);
			$from 		 = return_user_email_add($approver_username) == 'NONE' ? '' : return_user_email_add($approver_username);
			$cc 		= '';
			// $to 		= 'mclegaspi@pricon.ph'; 
			// $cc 		= '';
			// $from 		= 'TQTSystemNotification@pricon.ph';

			$php_mailer = new email();
			$php_mailer->send_email($to, $from, $cc, $subject, $body,'','');//amail
		}
	}
	
	
	/** change the status of tbl_sa */
	function change_status($new_status,$fkid){
		/*  STATUS LOG
			0 - FOR APPROVAL 
			1 - APPROVED
			2 - DISAPPROVED
			3 - FOR DISPOSITION
			4 - CHECKED
			5 - WAITING DISPOSITION
		 */
		require_once('../class/oop_tqts.php');
		$result 		= '';
		$array_fields 	= array('status');
		$array_values	= array($new_status);
		$table 			= 'tbl_qfr_special_acceptance';
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$fkid);
	}

	function get_sent_details(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$pkid = $return['pkid'];
		$result = '';
		$array_fields = array('*');
		$table = 'tbl_qfr_sa_for_disposition_attachment';
		$joins = '';
		$where = 'WHERE fkspecial_acceptance = "'.$pkid.'"';
		$order = '';
		$limit = '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$where,$order,$limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$where,$order,$limit);
		if ($row = mysqli_fetch_array($result)){
			$return['sent_by'] = get_emp_name_by_username_systemone($row['created_by']);
			$return['date_time_sent'] = $row ['date_time_created'];
			$return['date_time_sent'] = date('M d, Y H:i:s' ,strtotime($row ['date_time_created']));
			$return['remarks'] = $row ['remarks'];
		}
		echo json_encode($return);
	}

	function save_add_disposition(){
		require_once('../class/oop_tqts.php');
		
		$date_time_today 	 = date('Y-m-d H:i:s');
		$return  = $_POST;
		$return_file_tmp = $_FILES['treatment_file']['tmp_name'];
		$return_file_name = $_FILES['treatment_file']['name'];

		$fkid 					= $return['pkid'];
		$status 		= $return['status'];
		$disposition 			= $return['disposition'] == null? " ": $return['disposition'] ;;
		$disposition_by 		= $return['disposition_by'];
		$disposition_date 		= $return['disposition_date'];
		$disposition_time 		= $return['disposition_time'];
		$disposition_remarks 	= $return['disposition_remarks'] == null? " ": $return['disposition_remarks'] ;
		$username 				= $return['username'];
		
		$table = 'tbl_qrf_sa_treatment';
		$array_fields=array('fkid,
		disposition,disposition_by,disposition_date,
		disposition_time,file_name,status,disposition_remarks,created_by,
		username,created_at'
		);
		$array_values=array($fkid,
		$disposition,$disposition_by,$disposition_date,
		$disposition_time,$return_file_name,$status,$disposition_remarks,$username,
		$username,$date_time_today
		);
		$insert_query= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
		// echo $script= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);


		/* NOTE : upload the file with esignature of the approvers */
			/* ffunction to get the file path:  ../uploaded_file/quality_report/sa/treatment */
			$file  		     = return_file_path_by_div_mod('sa_treatment');  
			$fkfile_path     = $file['pkid']; //path_id = 32 
			$target_dir      = $file['path']; //path = ../uploaded_file/quality_report/sa/treatment
			$target_file = $target_dir . $return_file_name;

				if (move_uploaded_file($return_file_tmp,$target_file)){	
					/** if the file name is XLSX change it to xlsx, else get the original extension */
					$ext= pathinfo($return_file_name, PATHINFO_EXTENSION);
					$get_file_extension = $ext == 'XLSX' ? 'xlsx' : $ext;

					$new_filename = $fkid.".".$get_file_extension;
					if(rename ($target_file, $target_dir.'/'.$new_filename)){		
						$msg = 'File was successfully uploaded to the system.<br>';
					} else {
						$msg = 'There was an error on renaming the file.';
					}	
				}else{
					$msg = "Sorry, there was an error uploading your file.";
				}
	// /* ffunction change the status to 6-APPROVED OR 7-DISAPPROVED */	
		$new_status = $status == "APPROVED" ? 6:7;
		change_status($new_status,$fkid);
		echo json_encode($insert_query);
	}
	function update_sa_disposition(){
		require_once('../class/oop_tqts.php');
		$date_time_today 	 = date('Y-m-d H:i:s');
		$return  = $_POST;

		$fkid 					= $return['pkid'];
		$status 				= $return['status'];
		$disposition 			= $return['disposition'] == null? " ": $return['disposition'];
		$disposition_by 		= $return['disposition_by'];
		$disposition_date 		= $return['disposition_date'];
		$disposition_time 		= $return['disposition_time'];
		$disposition_remarks 	= $return['disposition_remarks'] == null? " ": $return['disposition_remarks'] ;

		$table = 'tbl_qrf_sa_treatment';
		$array_fields=array('fkid',
		'disposition','disposition_by','disposition_date',
		'disposition_time','status',
		'disposition_remarks','updated_at'
		);
		$array_values=array($fkid,
		$disposition,$disposition_by,$disposition_date,
		$disposition_time,$status,
		$disposition_remarks,$date_time_today
		);
		$where =  'WHERE `fkid` = "'.$fkid.'"' ;
		$result = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);

		/** If the temp file is defined save the file to treatment */
		$return_file_tmp = $_FILES['treatment_file']['tmp_name'];
		$return_file_name = $_FILES['treatment_file']['name'];
		if ($return_file_tmp == '' || !isset($return_file_tmp)){
			$msg	= "File was successfully uploaded! "; 
		}else{
			$return['ext']  		= pathinfo($return_file_name, PATHINFO_EXTENSION);
			$directory_path 		= return_file_path_by_div_mod('sa_treatment'); /* Get the file path */

			$array_fields = array('file_name');
			$table 	   	= 'tbl_qrf_sa_treatment';
			$joins 	   	= '';
			$sql_where 	= 'WHERE fkid="'.$fkid.'" AND logdel=0';
			$sql_order 	= '';
			$sql_limit 	= '';
			$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)){
				/* Reupload the file. Delete the current file and replace by new one */
				$target_ext = end(explode('.',$row['file_name']));
				$target_file = $directory_path['path'].$fkid .'.'. $target_ext;
				unlink($target_file);
				move_uploaded_file($return_file_tmp,$directory_path['path'].$fkid.'.'.$return['ext']);
				/** Update the name of with treatment file */

				$table = 'tbl_qrf_sa_treatment';
				$array_fields=array('file_name');
				$array_values=array($return_file_name);
				$where =  'WHERE `fkid` = "'.$fkid.'"' ;
				$result = TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);

				}
		}
		$new_status = ($status=="DISAPPROVED")?'7':'6';
		change_status($new_status,$fkid);
		echo json_encode($new_status);
	}
	function get_disposition_list(){
		require_once('../class/oop_tqts.php');

		$return = $_POST;
		$array_fields = array('pkid,disposition');
		$table 	   	= 'tbl_qfr_sa_disposition_list';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `logdel`="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $result 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] = $row['pkid'];
			$return['disposition'][$ctr] = $row['disposition'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		echo json_encode($return);
	}
	function get_view_attachment(){
		require_once('../class/oop_tqts.php');

		$return = $_POST;
		$fkid = $return['fkid'];
		// $array_fields = array('file_name');
		// $table 	   	= 'tbl_qfr_special_acceptance_attachment';
		// $joins 	   	= '';
		// $sql_where 	= 'WHERE `fkspecial_acceptance`= "'.$fkid.'" AND logdel=0';
		// $sql_order 	= '';
		// $sql_limit 	= '';
		// $return['table_body'] = "";
		// $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// if($row = mysqli_fetch_array($result)){
		// 	$file_names = $row['file_name'];
		// 	$table_body = '<tr>';
		// 	$table_body .= '<td><b>Without Signature</b></td>';
		// 	$table_body .= '</tr>';
		// 	$table_body .= '<tr>';
		// 	$table_body .= '	<td><a href="#" class="without_signature" id="'.$fkid.'" folder="new" style="display:inline-block;"> '.$file_names.'</a></td>';
		// 	$table_body .= '</tr>';
		// 	$table_body .= '<tr>';
		// 	$table_body .= '<td><b>With Signatures</b></td>';
		// 	$table_body .= '</tr>';
		// 	$table_body .= '<tr>';
		// 	$table_body .= '	<td><a href="#" class="fa fa-files-o" id="'.$fkid.'" folder="new" style="display:inline-block;"> '.$file_names.'</a></td>';
		// 	$table_body .= '</tr>';
		// }

		$array_fields = array('file_name');
		$table 	   	= 'tbl_qrf_sa_treatment';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkid`= "'.$fkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$file_names = $row['file_name'];
			// $file_names  = explode(' | ', $row['file_name']);
			$table_body = '<tr>';
			$table_body .= '<td><b>With YEC Judgement</b></td>';
			$table_body .= '</tr>';
			$table_body .= '<tr>';
			$table_body .= '	<td><a href="#" class="fa fa-paperclip" id="'.$fkid.'" folder="new" style="display:inline-block;"> '.$file_names.'</a></td>';
			$table_body .= '</tr>';
		}

		$return['table_body'] = $table_body;
		echo json_encode($return['table_body']);
	}
	function get_treatment(){
		require_once('../class/oop_tqts.php');

		$return = $_POST ;
		$result = '';
		$pkid = $return ['pkid'];
		$array_fields = array('*');
		$table 	   	= 'tbl_qrf_sa_treatment';
		$joins 	   	= '';
		$where 	= 'WHERE `fkid` = "'.$pkid.'" AND `logdel` = 0';
		$order 	= '';
		$limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$where,$order,$limit);
		if($row = mysqli_fetch_array($result)){
			$return ['disposition']			=$row['disposition'];
			$return ['disposition_by']		=$row['disposition_by'];
			$return ['disposition_date']	=$row['disposition_date'];
			$return ['disposition_time']	=$row['disposition_time'];
			$return ['status']				=$row['status'];
			$return ['file_name']			=$row['file_name'];
			$return ['disposition_remarks']	=$row['disposition_remarks'];
		}
		echo json_encode($return);
	}
	function save_sa_for_revision(){
		/** Add data for revision, also you will see how many revision will have to this*/
		require_once('../class/oop_tqts.php');
		$date_time_today 	 = date('Y-m-d H:i:s');
		$return = $_POST ;
		$fkid = $return['pkid'];
		$remarks = $return['remarks'];
		$username = $return['username'];
		$table = 'tbl_qfr_sa_for_revision';
		$array_fields = array('created_by','fk_special_acceptance','revision_count','remarks','username','created_at','updated_at');
		foreach($array_fields as $key => $value){
			if(!isset($return[$value]) || $return[$value] == ""){
				$return[$value] = "";
			}
		}
		$array_values = array($username,$fkid,1,$remarks,$username,$date_time_today,'');
		$result = TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
		/** Change the approver's status into zero == Pending */
		$table_details= 'tbl_qfr_sa_approvers';
		$row_status = 0;
		$array_fields 	= array('status','date_time_approved', 'approver_remarks');
		$array_values 	= array($row_status,'','');
		$sql_where		= 'WHERE `fkid`="'.$fkid.'" AND `logdel`= 0';
		$result 		= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		$script 	= TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);
		/** Change the main approver's status into zero == Pending */
		$table_main_approvers= 'tbl_qfr_sa_approvers_main';
		$row_status_main_approvers = 0;
		$array_fields 	= array('status','date_time_approved', 'approver_remarks');
		$array_values 	= array($row_status_main_approvers,'','');
		$sql_where		= 'WHERE `fkid`="'.$fkid.'" AND `logdel`= 0';
		$result 		= TQTS::getInstance()->update_query_detailed($table_main_approvers,$array_fields,$array_values,$sql_where);
		
		$table_approvers_qc= 'tbl_qfr_sa_approver_qc';
		$row_status_approvers_qc = 0;
		$array_fields 	= array('status','date_time_approved', 'approver_remarks');
		$array_values 	= array($row_status_approvers_qc,'','');
		$sql_where		= 'WHERE `fkid`="'.$fkid.'" AND `logdel`= 0';
		$result 		= TQTS::getInstance()->update_query_detailed($table_approvers_qc,$array_fields,$array_values,$sql_where);
		
		/** 
		 * If the QC Approver is exist, then status change into A -FOR QC CHECKING 
		 * else the status will be zero(0) -FOR CHECKING */
		$has_record = load_is_qc_approver($fkid);
		$new_status = ($has_record == 1)?'A':'0';
		
		change_status($new_status,$fkid);
		echo json_encode($has_record);
	}
	/**------------------------------- SA - QC Appover Query ----------------------------*/
	function validate_qc_supervisor(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$username 		= $return['username'];
		$array_fields 	= array('department');
		$table      	= 'vw_user_access';
		$joins      	= '';
		$sql_where  	= 'WHERE `username`="'.$username.'"';
		$sql_order  	= '';
		$sql_limit  	= '';
		$result = RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row=mysqli_fetch_array($result)) {
			$engineer = 'Engineer';
			$qc = 'LQC';
			$return_department =  $row['department'];
			$get_department = strstr( $return_department,$engineer );
			$get_department_qc = strstr( $return_department,$qc );
	/** !if the department is LIKE "Engineering" return ENGG,  if the department is LIKE "LQC" return QC , else return - */
			$return['department'] = ($get_department == "Engineering")?"ENGG":
			$return['department'] = ($get_department_qc == "LQC")? "QC":"-";

		} else {
			$return['department'] = 'N/A';
		}
		echo json_encode($return);
	}
	function save_qc_approvers($username,$pkid,$qc_approvers,$date_time_today){ //fsave
		if ($qc_approvers != '') {
			/** If the QC Approver is exist, then status change into A -FOR QC CHECKING  */
			$new_status = 'A';
			change_status($new_status,$pkid);
			/* Save selected approvers */
			$table			= 'tbl_qfr_sa_approver_qc';
			$array_fields 	= array('created_by','fkid', 'approver_username','status','created_at', 'updated_at', 'username');
			$qc_approvers 		 = explode(',',$qc_approvers);
			foreach($qc_approvers as $approver_username) {
				$array_values 	= array($username, $pkid, $approver_username, '0', $date_time_today, $date_time_today, $username);
				$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			}
		}else{
			$return ='No QC Approver';
		}
	}
	function edit_qc_approvers($pkid,$qc_approvers,$username,$date_time_today){
		$table			= 'tbl_qfr_sa_approver_qc';
		$array_fields 	= array('updated_at', 'username', 'logdel');
		$array_values 	= array($date_time_today, $username, 1);
		$sql_where		= 'WHERE fkid='.$pkid;
		$update_query	= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$sql_where);
		
		$array_fields 	= array('created_at', 'created_by', 'fkid', 'approver_username', 'status', 'updated_at', 'username');
		$qc_approvers 		 = explode(',',$qc_approvers);
		foreach($qc_approvers as $approver_username) {
			$array_values 	= array($date_time_today, $username, $pkid, $approver_username, '0', $date_time_today, $username);
			$insert_query	= TQTS::getInstance()->insert_query($table,$array_fields,$array_values);
			// $script	.= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
		}	
	}
	function load_is_qc_approver($fkid){
		$array_fields = array('approver_username');
		$table 	   	= 'tbl_qfr_sa_approver_qc';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkid="'.$fkid.'" AND logdel=0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($result->num_rows >= 1){
			$has_record = 1;
		}else{
			$has_record =	0;
		}
		return $has_record;
	}
	function load_qc_approver($fkid){
		$array_fields = array('approver_username');
		$table 	   	= 'tbl_qfr_sa_approver_qc';
		$joins 	   	= '';
		$sql_where 	= 'WHERE fkid="'.$fkid.'" AND logdel= 0';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return = array();
		if($row = mysqli_fetch_array($result)){
			$return ['qc_approver_name'] = $row['approver_username'];
		}else{
			$return ['qc_approver_name'] = 'NONE';
		}
		return $return;
	}
	function sa_qc_approvers_decision(){//gmodifynow
		require_once('../class/oop_tqts.php');
		$date_time_today = date('Y-m-d H:i:s');	
		$return 		= $_POST;

		$fkid    		= $return['pkid'];
		$status   		= $return['status'];
		$remarks  		= $return['remarks'];
		$username  		= $return['username'];
		$msg		    = '';		
		$script 		= '';	
		/* Table */
		$table_details	= 'tbl_qfr_sa_approver_qc';
		/* Update the Table Approvers based on pkid */
		$is_status		= ($status== "APPROVED")? '1': '2';
		$array_fields 	= array('status', 'date_time_approved', 'approver_remarks','updated_at','username');
		$array_values 	= array($is_status, $date_time_today, $remarks, $date_time_today,$username);
		$sql_where		= 'WHERE `fkid`="'.$fkid.'" AND `approver_username`="'.$username.'" AND `logdel`= 0';
		$result 		= TQTS::getInstance()->update_query_detailed($table_details,$array_fields,$array_values,$sql_where);
		$script 		= TQTS::getInstance()->update_query_detailed_script($table_details,$array_fields,$array_values,$sql_where);

		/** 
		 *!get decision if approved or disapproved  
		*/
		/** Include the select all data from tbl_qfr_special_acceptance then send the approver's decision*/
		$array_fields = array('*');
		$table 	  = 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fkid.'" AND `logdel`= 0';
		$sql_order 	= '';
		$sql_limit 	= '';
		if($status== "APPROVED"){
			$new_status = '0';
			$status_for_email = 'APPROVED';
			
			//bamail
			send_email_for_checking($fkid); //gmodifynow
		}else{
			$new_status = '2';
			$status_for_email = 'DISAPPROVED';
		}
		$return['change_status'] = change_status($new_status,$fkid);
		/** sa_main_is_decision($status,$fkid,$table_details,$array_fields,$sql_where,$date_time_today,$remarks,$username,$return);*/ 
		$returns = select_all_sa_data($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$returns['judged_by_qc'] 			= $returns['judged_by_qc'];
		sa_send_email_approver_decision($fkid,$returns['judged_by_qc'], $status_for_email);

		echo json_encode($return);
	}

	function load_sa_approvers($pkid){
		/* Return approver details */
		$approver_username	= array();
		$array_fields = array('approver_username');
		$table 	   	= 'tbl_qfr_sa_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fkid`="'.$pkid.'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$approver_username['approver_username'][] 			= $row['approver_username'];
		}
		return $approver_username['approver_username'];
	}
	function send_email_for_disposition(){ 
		require_once('../class/oop_tqts.php');
		require_once('../class/send_email_qfr_sa.php');

		$return = $_POST;
        $fkid 				 = $return['pkid'];
		$username = $return['username'];
       	$date_time_today 	 = date('Y-m-d H:i:s');
        $ctr_number  		 = $return['control_number']; //IF NEEDED

    	$to_recip_internal   = !isset($return['sa_send_to']) ? '' : implode(',',$return['sa_send_to']);
       	$to_recip_external   = $return['sa_send_external_to'] == '' ? '' : implode(',',$return['sa_send_external_to']);
		$cc_recip_internal   = !isset($_POST['sa_send_cc'])  ? '' : implode(',',$_POST['sa_send_cc']);
		// $cc_recip_external   = $_POST['sa_send_external_cc'] == '' ? '' : implode(',',$_POST['sa_send_external_cc']);
        $disposition_remarks    = $_POST['remarks'];        
        $msg = '';
		
		/* NOTE : upload the file with esignature of the approvers */
			/* ffunction to get the file path:  ..uploaded_file/quality_report/sa */
			$file  		     = return_file_path_by_div_mod('sa_approved');  
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];

			if(!file_exists($target_dir.$fkid.'/')) {
				$target_dir = $target_dir.$fkid.'/';
				mkdir($target_dir, 0777, false); /* 'if not exist make a folder named by pkid' */
			} 

			$temp_file 	     = $_FILES["file_sa"]["tmp_name"];
			$file_name 	     = $_FILES["file_sa"]["name"];
			$target_file = $target_dir . $file_name;
			if(file_exists($target_file)){
				$msg = 'Sorry, the file already exists.';
			}else{
				if (move_uploaded_file($temp_file,$target_file)){	
					$ext= pathinfo($file_name, PATHINFO_EXTENSION);
					$new_filename = $fkid.".".$ext;
					if(rename ($target_file, $target_dir.'/'.$new_filename)){		
						$msg = 'File was successfully uploaded to the system.<br>';
					} else {
						$msg = 'There was an error on renaming the file.';
					}	
				}else{
					$msg = "Sorry, there was an error uploading your file.";
				}
			}
		$table			= 'tbl_qfr_sa_for_disposition_attachment';
		$array_fields 	= array(
									'date_time_created','created_by','fkspecial_acceptance',
									'file_name','fkfile_path','remarks',
									'lastupdate','username'
								);
		$array_values	= array(
									$date_time_today,$username,$fkid,
									$file_name,4,'',
									$date_time_today,$username
								);
		$pkid_attachment = TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);

		/* Create email notification */
		$result = "";
		$date= date('Y-m-d');
		$date_today = date('M d, Y',strtotime($date));
		/* query for select all from tbl_special_acceptance, and select file_name to tbl_attactment by pkid  */	
		$array_fields = array('*', 
		'(SELECT tbl_qfr_sa_for_disposition_attachment.file_name FROM tbl_qfr_sa_for_disposition_attachment WHERE tbl_qfr_sa_for_disposition_attachment.pkid=pkid LIMIT 0,1) as file_name'
		);
		$table 	   	= 'tbl_qfr_special_acceptance';
		$joins 	   	= '';
		$sql_where 	= 'WHERE pkid="'.$fkid.'"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$created_by			= $row['created_by'];
			$control_number		= $row['control_number'];
			$created_by 		= $row['created_by'];
			$issuance_date 		= $date_today; //date today
			$part_code 			= $row['part_code'];
			$parts_affected_parts =$row['parts_affected_parts'];
			$po_number 			= $row['po_number'];
			$device_name		= $row['device_name'];
			$lot_no				= $row['lot_number'];
			$drawing_number 	= $row['drawing_number'];
			$supplier 			= $row['supplier'];
			$file_array			= $row['file_name'];
		
			$file  		     = return_file_path_by_div_mod('sa_approved');  
			$fkfile_path     = $file['pkid'];
			$target_dir      = $file['path'];

			/* get the file_name and file_path */	
			$tqts_path			= str_replace('/var/www/','',realpath(dirname(__FILE__)."/../")); /* get the folder of TQTS_TS*/
			$ext= pathinfo($target_dir, PATHINFO_EXTENSION);
			echo $attachment      	= str_replace('../',$tqts_path.'/',$target_dir.$fkid.'/'.$fkid.'.pdf'); /* get the path of the attachments*/
			$attachment_name	= $file_name; /* get file names*/
			
			if($part_code != '') {
				$subject 		 	 = 'SPECIAL ACCEPTANCE REPORT : '.$part_code.' ('.$parts_affected_parts.')';
				$part_details 		= '&emsp;Part Code: '.$part_code.' <br>';
				$part_details 	    .= '&emsp;Part Name: '.$parts_affected_parts.'<br>';
				// $body 	 	 		 = 'This is to inform you that the Special Acceptance report request with Part Code: '.$part_code.' is ready for sending to Supplier.<br> <br>';
			}else if($po_number != ''){
				$subject 		 	= 'SPECIAL ACCEPTANCE REPORT : '.$po_number.' ('.$device_name.')';
				$part_details 	   = '&emsp;PO Number: '.$po_number.' <br>';
				$part_details 	   .= '&emsp;Device Name: '.$device_name.' <br>';
				// $body 	 	 		= 'This is to inform you that the Special Acceptance report request with PO Number: '.$po_number.' is ready for sending to Supplier.<br> <br>';
			}else if ($part_code == '' && $po_number == ''){
				$subject 		 	= 'SPECIAL ACCEPTANCE REPORT : ';
			}

			$body 		 = 'Good day! <br>';
			$body 		.= $_POST['message'].'<br>';

			$body 	 	.= 'Attached is the Special Acceptance report generated due to the defect encountered:<br> <br>';
			$body 		.= $part_details;
			$body 		.= '&emsp;Fail Mode: '.$_POST['fail_mode'].' <br>';
			$body 		.= '&emsp;Customer Name: '.$_POST['supplier'].' <br>';
			$body 		.= 'For your disposition.'.' <br><br>';

			$to = array();
			if($to_recip_internal != '') {
				$to_recip_internal = explode(',',$to_recip_internal);
				for($i=0;$i<count($to_recip_internal);$i++) {
					array_push($to, $to_recip_internal[$i]);
				}	
			}
			if($to_recip_external != '') {
				$to_recip_external = explode(',',$to_recip_external);
				for($i=0;$i<count($to_recip_external);$i++) {
					array_push($to, $to_recip_external[$i]);
				}	
			}
			$cc = array();
			if($cc_recip_internal != '') {
				$cc_recip_internal = explode(',',$cc_recip_internal);
				for($i=0;$i<count($cc_recip_internal);$i++) {
					array_push($cc, $cc_recip_internal[$i]);
				}	
			}
			/** NOTE: External CC for Special Acceptance Report */
			// if($cc_recip_external != '') {
			// 	$cc_recip_external = explode(',',$cc_recip_external);
			// 	for($i=0;$i<count($cc_recip_external);$i++) {
			// 		array_push($cc, $cc_recip_external[$i]);
			// 	}
			// }
			// $to 		 = 'cdcasuyon@pricon.ph';
			// $from 	 = 'TQTSystemNotification@pricon.ph';
			// $cc 		 = 'mclegaspi@pricon.ph';

			$to 		 = implode(',',$to); //To internal, To external
			$cc 		 = implode(',',$cc); // CC internal 
			$from 		 = return_user_email_add($username) == 'NONE' ? '' : return_user_email_add($username); //judcataya/tmmabulac is the sender of SAR

			$php_mailer = new email();
			$php_mailer->send_email_with_attachment($to, $from, $cc, $subject, $body, $attachment_name, $attachment);
		}
		$new_status = 5;
		$return['change_status'] = change_status($new_status,$fkid);

		echo json_encode($return);
	}
?>