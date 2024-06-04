<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {	
				case "get_report_approvers" 					: get_report_approvers(); break; 
				case "get_emp_list_by_section" 					: get_emp_list_by_section(); break; 
				case "get_operators_name" 						: get_operators_name(); break; 
				case "get_supplier_lists" 						: get_supplier_lists(); break; 
				case "get_emp_name_by_username2" 				: get_emp_name_by_username2(); break; 
				case "get_section_list" 						: get_section_list(); break; 
				case "get_emp_name" 							: get_emp_name(); break; 
				case "get_emp_name_by_username_array" 			: get_emp_name_by_username_array(); break; 
				case "return_system_division" 					: return_system_division(); break; 
				case "return_emp_info"							: return_emp_info(); break;
				
				/* YPICS Functions */
				case "get_po_details" 							: get_po_details(); break; 
				case "get_partname_by_partcode" 				: get_partname_by_partcode(); break; 
				case "get_partcode_datalist" 					: get_partcode_datalist(); break; 
				case "get_invoice_num_list" 					: get_invoice_num_list(); break; 
				case "get_series_name_datalist" 				: get_series_name_datalist(); break; 
				case "get_po_datalist" 							: get_po_datalist(); break; 
				// case "get_series_name_by_po_number" 			: get_series_name_by_po_number(); break; 
				case "get_po_number_by_series_name" 			: get_po_number_by_series_name(); break; 
				case "get_lot_number_list" 						: get_lot_number_list(); break; 
				case "get_quantity_by_lot_number" 				: get_quantity_by_lot_number(); break;

				case "get_emp_name_by_username" 			: get_emp_name_by_username(); break;
				
				/* HRIS / Rapid */
				
				
			}	
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
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
		$html_select= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script = TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['approver_username'].'">'.$row['approver_name'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['script'] = $script;
		// echo $script;
		echo json_encode($return);
	}
	
	function get_emp_list_by_section() {
		require_once('../class/oop_tqts.php');
		$role		 	 =  $_POST['role'];
		$section		 =  $_POST['section'];
		$logdel		 	 =  $_POST['logdel'] == 0 ? '" AND logdel=0' : '"';
		$array_fields 	 = array('user','emp_name');
		$table 	   		 = 'vw_user_roles';
		$joins 	   		 = '';
		$sql_where 		 = 'WHERE section="'.$section.'" AND role="'.$role.$logdel;
		$sql_order 		 = '';
		$sql_limit 		 = '';
		$result 		 = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$html_select	 = '<option value="">-</option>';
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['user'].'">'.$row['emp_name'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function get_operators_name() {
		require_once('../class/oop_tqts.php');
		$array_fields 	 = array('EmpNo','CONCAT(`FirstName`," ",`LastName`) as operators_name');
		$table 	   		 = 'db_subcon.tbl_EmployeeInfo';
		$joins 	   		 = '';
		$sql_where 		 = 'WHERE fkPosition=43 AND EmpStatus=1 AND logdel=0 AND EmpNo !=""';
		$sql_order 		 = '';
		$sql_limit 		 = '';
		$html_select	 = '<option value="">-</option>';
		$result 		 = SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['EmpNo'].'">'.$row['operators_name'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function get_supplier_lists() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('supplier');
		$table			= 'tbl_supplier';
		$joins			= '';
		$sql_where		= 'WHERE supplier LIKE "%'.$pattern.'%"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,10';
		$html_select	= '';
		$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['supplier'].'">'.$row['supplier'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function get_emp_name_by_username() {
			if(file_exists('../class/oop_tqts.php')) {
				require_once('../class/oop_tqts.php');
			} else {
				require_once('../../class/oop_tqts.php');
			}
		$username		= $_POST['username'];
		$emp_name		= 'Not found!';
		// $array_fields 	= array('`name` as emp_name');
		// $table			= 'tbl_useraccounts';
		// $joins			= '';
		// $sql_where		= 'WHERE username="'.$username.'"';
		// $sql_order		= '';
		// $sql_limit		= 'LIMIT 0,1';
		// $html_select	= '';
		// $result			= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// if($row = mysqli_fetch_array($result)) {
			// $return['emp_name'] = $row['emp_name'];
		// }
		$array_fields 	= array('CONCAT(`firstName`," ",`lastname`) as emp_name');
		$table			= 'db_hris.vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$return['emp_name'] = $row['emp_name'];
		}
		echo json_encode($return);
	}
	function get_emp_name_by_username2() {
		require_once('../class/oop_tqts.php');
		$username		= $_POST['username'];
		$emp_name		= 'Not found!';
		// $array_fields 	= array('`name` as emp_name');
		// $table			= 'tbl_useraccounts';
		// $joins			= '';
		// $sql_where		= 'WHERE username="'.$username.'"';
		// $sql_order		= '';
		// $sql_limit		= 'LIMIT 0,1';
		// $html_select	= '';
		// $result			= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// if($row = mysqli_fetch_array($result)) {
			// $return['emp_name'] = $row['emp_name'];
		// }
		$array_fields 	= array('CONCAT(`firstName`," ",`lastname`) as emp_name');
		$table			= 'db_hris.vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$return['emp_name'] = $row['emp_name'];
		}
		echo json_encode($return);
	}
	
	function get_emp_name_by_username_array() {
		require_once('../class/oop_tqts.php');
		$username		= explode(',',$_POST['username_array']);
		$emp_name		= array();
		for($i=0; $i<count($username); $i++) {
			$array_fields 	= array('CONCAT(`firstName`," ",`lastname`) as emp_name');
			$table			= 'db_hris.vw_EmpInfo_Rapid';
			$joins			= '';
			$sql_where		= 'WHERE username="'.$username[$i].'"';
			$sql_order		= '';
			$sql_limit		= 'LIMIT 0,1';
			$html_select	= '';
			$result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$emp_name[] = $row['emp_name'];
			}
		}
		$emp_name = implode(', ',$emp_name);
		$return['emp_name'] = $emp_name;
		echo json_encode($return);
	}
	
	// function return_system_division() {
		// require_once('../class/oop_tqts.php');
		// $array_fields = array('division_name');
		// $table      = 'tbl_division';
		// $joins      = '';
		// $sql_where  = '';
		// $sql_order  = '';
		// $sql_limit  = 'LIMIT 0,1';
		// $result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// if($row=mysqli_fetch_array($result)) {
			// $division_name = $row['division_name'];
		// } else {
			// $division_name = 'N/A';
		// }
		// $return['division_name'] = $division_name;
		// echo json_encode($return);
	// }

	function get_emp_name_by_username_systemone_rapid($username) {
		require_once('../../class/oop_tqts.php');
		$emp_name		= 'Not found!';
		$array_fields 	= array('CONCAT(`firstName`," ",`lastname`) as emp_name');
		$table			= 'db_hris.vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$emp_name = $row['emp_name'];
		} else{
			$array_fields 	= array('name as emp_name');
			$table			= 'db_rapid.tbl_useraccounts';
			$joins			= '';
			$sql_where		= 'WHERE username="'.$username.'"';
			$sql_order		= '';
			$sql_limit		= 'LIMIT 0,1';
			$html_select	= '';
			$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$emp_name = $row['emp_name'];
			}
		}
		return $emp_name;
		echo json_encode($return);
	}
	function get_emp_name_by_username_systemone_rapid_new_version($username) {
		require_once('../../class/oop_tqts.php');
		$emp_name		= 'Not found!';
		$array_fields 	= array('CONCAT(`firstName`," ",`lastname`) as emp_name');
		$table			= 'db_hris.vw_EmpInfo_Rapid';
		$joins			= '';
		$sql_where		= 'WHERE username="'.$username.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$html_select	= '';
		$result			= SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$emp_name = $row['emp_name'];
		} else{
			$array_fields 	= array('name as emp_name');
			$table			= 'db_rapid.tbl_useraccounts';
			$joins			= '';
			$sql_where		= 'WHERE username="'.$username.'"';
			$sql_order		= '';
			$sql_limit		= 'LIMIT 0,1';
			$html_select	= '';
			$result			= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_array($result)) {
				$emp_name = $row['emp_name'];
			}
		}
		return $emp_name;
		echo json_encode($return);
	}
	
	function get_section_list() {
		require_once('../class/oop_tqts.php');
		$array_fields 	 = array('section');
		$table 	   		 = 'tbl_section';
		$joins 	   		 = '';
		$sql_where 		 = 'WHERE logdel=0';
		$sql_order 		 = '';
		$sql_limit 		 = '';
		$html_select	 = '<option value="">-</option>';
		$result 		 = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['section'].'">'.$row['section'].'</option>';
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	function get_emp_name() {
		require_once('../class/oop_tqts.php');
		$array_fields 	 = array('username','CONCAT(`firstName`," ",`lastname`) as emp_name');
		$table 	   		 = 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   		 = '';
		$sql_where 		 = '';
		$sql_order 		 = '';
		$sql_limit 		 = '';
		$html_select	 = '<option>-</option>';
		$result 		 = SYS1::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			if($row['username'] != '') {
				$html_select .= '<option value="'.$row['username'].'">'.$row['emp_name'].'</option>';
			}
		}
		$return['html_select'] = $html_select;
		echo json_encode($return);
	}
	
	/* ************************* 
		YPICS Functions 
	***************************/
	function get_po_details(){
		require_once('../class/oop_tqts.php');
        $po_number 		= $_POST['po_number'];
		$YPICS          = new YPICS4;
        $array_fields   = array("TOP 1 XRECE.SORDER","XRECE.CODE","XRECE.CDATE","XHEAD.NAME","XCUST.CNAME");
        $table          = "XHEAD";
        $joins          = "INNER JOIN XRECE ON XRECE.CODE = XHEAD.CODE 
							INNER JOIN XCUST ON XCUST.CUST = XRECE.CUST";
        $sql_where      = "WHERE XRECE.SORDER = '$po_number'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $script         = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
        $html    		= '';
		$ypics_data     = array(
								"po_number"		=> "",
								"device_code"	=> "",
								"device_name"	=> "",
								"customer"		=> ""
							    );
        while($row = mssql_fetch_array($result)){
			$ypics_data['po_number'] 	= $row['SORDER'];
			$ypics_data['shipment_date']= convert_ypics_date($row['CDATE']);
			$ypics_data['device_code'] 	= $row['CODE'];
			$ypics_data['device_name'] 	= $row['NAME'];
			$ypics_data['customer'] 	= $row['CNAME'];
        }
        echo json_encode($ypics_data);
	}
	
	function convert_ypics_date($date){
		$date = date('m/d/Y',strtotime(substr($date, 0, -1)));
		return $date;
	}
	
	function get_partname_by_partcode(){
		// echo 'common handler';
		require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $partcode        = $_POST['partcode']; 
        $array_fields   = array("TOP 1 NAME");
        $table          = "XHEAD";
        $joins          = "";
        $sql_where      = "WHERE CODE = '$partcode'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $script         = $YPICS->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order);
        $html    		= '';
        $partname		= 'No record found';
		while($row = mssql_fetch_array($result)){
			$partname 	= $row['NAME'];
        }
        $return['partname'] = $partname;
        $return['script'] 	= $script;
        echo json_encode($return);
	}
	
	function get_partcode_datalist(){
		require_once('../class/oop_tqts.php');
        $YPICS          = new YPICS4;
        $pattern        = $_POST['pattern']; 
        // $array_fields   = array("TOP 10 CODE");
        $array_fields   = array("DISTINCT TOP 10 CODE"); //as of 10/02/2018
        $table          = "XHEAD";
        $joins          = "";
        $sql_where      = "WHERE CODE LIKE '%$pattern%'";
        $sql_order      = "";
        $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        $html    		= '';
        while($row = mssql_fetch_array($result)){
			$html .= '<option value="'.$row['CODE'].'">'.$row['CODE'].'</option>';
        }
        $return['html'] = $html;
        echo json_encode($return);
	}
	
	function get_invoice_num_list(){
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
	 
	// function get_series_name_datalist(){
        // require_once('../class/oop_tqts.php');
        // $YPICS          = new YPICS4;
        // $pattern        = $_POST['pattern']; 
        // $array_fields   = array("TOP 10 NAME");
        // $table          = "VRECE";
        // $joins          = "";
        // $sql_where      = "WHERE NAME LIKE '%$pattern%'";
        // $sql_order      = "";
        // $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        // $html    		= '';
        // while($row = mssql_fetch_array($result)){
			// $html .= '<option value="'.$row['NAME'].'">'.$row['NAME'].'</option>';
        // }
        // $return['html'] = $html;
        // echo json_encode($return);
     // }
	 
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
	
	function get_series_name_by_po_number_fn($po_number) {
		require_once('../../class/oop_tqts.php');
        $YPICS         	= new YPICS4;
		$array_fields 	= array("XRECE.CODE");
		$table 			= "XRECE";
		$joins 			= "";
		$sql_where 		= "WHERE XRECE.SORDER = '$po_number'";
		$sql_order 		= "";
		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
		if($row = mssql_fetch_array($result)){
			$device_code	= $row['CODE'];
			$array_fields 	= array("VHEAD.NAME");
			$table 			= "VHEAD";
			$joins 			= "";
			$sql_where 		= "WHERE VHEAD.CODE = '".$device_code."'";
			$sql_order 		= "";
			$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
			if($row = mssql_fetch_array($result)){
				return $row['NAME'];
			} else {
				return '';
			}
		} else{
			return '';
		}		
	}


	// function get_series_name_by_po_number_fn($po_number) {//NOVS EDIT
	// 	require_once('../../class/oop_tqts.php');
 //        $YPICS         	= new YPICS4;
	// 	$array_fields 	= array("VRECE.CODE");
	// 	$table 			= "VRECE";
	// 	$joins 			= "";
	// 	$sql_where 		= "WHERE VRECE.SORDER = '$po_number'";
	// 	$sql_order 		= "";
	// 	$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
	// 	if($row = mssql_fetch_array($result)){
	// 		$device_code	= $row['CODE'];
	// 		$array_fields 	= array("VHEAD.NAME");
	// 		$table 			= "VHEAD";
	// 		$joins 			= "";
	// 		$sql_where 		= "WHERE VHEAD.CODE = '".$device_code."'";
	// 		$sql_order 		= "";
	// 		$result = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
	// 		if($row = mssql_fetch_array($result)){
	// 			return $row['NAME'];
	// 		} else {
	// 			return '';
	// 		}
	// 	} else{
	// 		return '';
	// 	}		
	// }
	
	
	// function get_series_name_by_po_number(){
        // require_once('../class/oop_tqts.php');
        // $YPICS          = new YPICS4;
        // $pattern        = $_POST['pattern']; 
        // $array_fields   = array("NAME");
        // $table          = "VRECE";
        // $joins          = "";
        // $sql_where      = "WHERE SORDER = '$pattern'";
        // $sql_order      = "";
        // $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        // $series_name    = '';
        // if($row = mssql_fetch_array($result)){
			// $series_name= $row['NAME'];
        // }
        // $return['series_name'] = $series_name;
        // echo json_encode($return);
    // }
	
	// function get_po_number_by_series_name(){
        // require_once('../class/oop_tqts.php');
        // $YPICS          = new YPICS4;
        // $pattern        = $_POST['pattern']; 
        // $array_fields   = array("SORDER");
        // $table          = "VRECE";
        // $joins          = "";
        // $sql_where      = "WHERE NAME = '$pattern'";
        // $sql_order      = "";
        // $result         = $YPICS->select_query($array_fields,$table,$joins,$sql_where,$sql_order);
        // $po_number    	= '';
        // if($row = mssql_fetch_array($result)){
			// $po_number= $row['SORDER'];
        // }
        // $return['po_number'] = $po_number;
        // echo json_encode($return);
     // } 
	
	function get_lot_number_list() {
		require_once('../class/oop_tqts.php');
		$pattern		= $_POST['pattern'];
		$array_fields 	= array('lot_no');
		$table			= 'tbl_wbs_material_receiving_batch';
		$joins			= '';
		$sql_where		= 'WHERE lot_no LIKE "%'.$pattern.'%"';
		$sql_where		= '';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,10';
		$html_select	= '';
		$result	= WBSSUBSYSTEM::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$query	= WBSSUBSYSTEM::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)) {
			$html_select .= '<option value="'.$row['lot_no'].'">'.$row['lot_no'].'</option>';
		}
		$return['html_select'] = $html_select;
		$return['query'] = $query;
		echo json_encode($return);
	}
	
	function get_quantity_by_lot_number() {
		require_once('../class/oop_tqts.php');
		$lot_number		= $_POST['lot_number'];
		$array_fields 	= array('qty');
		$table			= 'tbl_wbs_material_receiving_batch';
		$joins			= '';
		$sql_where		= 'WHERE lot_no = "'.$lot_number.'"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$quantity		= 0;
		$result	= WBSSUBSYSTEM::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$query	= WBSSUBSYSTEM::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)) {
			$quantity 	= $row['qty'];
		}
		$return['quantity'] = $quantity;
		$return['query'] = $query;
		echo json_encode($return);
	}	
	
	function return_emp_info() {
		require_once('../class/oop_tqts.php');
		$fk_employee 	= $_POST['fk_employee'];
		$table  		= "vw_employeeinfo";
		$array_fields	= array("*");
		$joins  	 	= "";
		$sql_where  	= "WHERE `pkid` = '".$fk_employee."'";
		$sql_order  	= "";
		$sql_limit  	= "LIMIT 0,1";
		$result        	= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script        	= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return 		= array();
		if($result->num_rows ==0) {
			$fk_employee	= str_replace('SUB','',$fk_employee);
			$table  		= "db_subcon.vw_employeeinfo";
			$array_fields	= array("*");
			$joins  	 	= "";
			$sql_where  	= "WHERE `pkid` = '$fk_employee'";
			$sql_order  	= "";
			$sql_limit  	= "LIMIT 0,1";
			$result        	= SYSTEMONE::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$script        	= SYSTEMONE::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($row = mysqli_fetch_assoc($result)){
				switch($row['HiringStatus']) {
					case "1" : $row['HiringStatus'] = "Contractual"; break;
					case "2" : $row['HiringStatus'] = "Probationary"; break;
					case "3" : $row['HiringStatus'] = "Regular"; break;
					default	 : $row['HiringStatus'] = "-No record found. Please update the record-"; break;
				}
				$row['DateHired'] = date('M d, Y', strtotime($row['DateHired']));
				$return['data'] = $row;
			}
		} else {
			if($row = mysqli_fetch_assoc($result)){
				switch($row['HiringStatus']) {
					case "1" : $row['HiringStatus'] = "Contractual"; break;
					case "2" : $row['HiringStatus'] = "Probationary"; break;
					case "3" : $row['HiringStatus'] = "Regular"; break;
				}
				$row['DateHired'] = date('M d, Y', strtotime($row['DateHired']));
				$return['data'] = $row;
			}
		}
		
		echo json_encode($return);
	}
	
	
	function display_qcfr_status($user, $logs) {
		$user_logs = '';
		$user = explode(',',$user);
		foreach($user as $key => $value) {
			if( $value != '' ) {
				if($logs == '' || $logs == '-' ) {
					$user_logs  .= get_emp_name_by_username_systemone_rapid($value);
					$user_logs  .= ' <b>[-]</b><br>';
				} else if($logs == 'PENDING') {
					$user_logs  .= get_emp_name_by_username_systemone_rapid($value);
					$user_logs  .= ' <b>[<i>PENDING</i>]</b><br>';
				} else {					
					// if(strstr($logs[$key],',')) {
						// if($logs[$key] == '') {
							// $user_logs .= '';	
						// } else {
							// $logs_user	= explode(',',$logs);
							// $logs_array = explode(' | ', $logs_user[$key]);
							// $status 	= $logs_array[0] == '' ? '-'  : $logs_array[0];
							// $date 		= $logs_array[1] == '' ? ''  : date('M d, Y h:i:s A', strtotime($logs_array[1]));
							// $remarks 	= $logs_array[2] == '' ? ''  : $logs_array[2];
							// $user_logs .= get_emp_name_by_username_systemone_rapid($value);
							// $user_logs .= ' <b>222['.($logs_array[0] == '' ? '<i>PENDING</i>' : $status .' - <i>'. $date).'</i>] </b>'.$remarks.'<br>';
						// }
					// } else {
						// if($logs == '') {
							// $user_logs .= '';	
						// } else {							
							if(strstr($logs,',')) {
								$logs_user	= explode(',',$logs);
								if($logs_user[$key] == '' || $logs_user[$key] == 'PENDING') {
									$user_logs .= get_emp_name_by_username_systemone_rapid($value);
									$user_logs .= ' <b>[<i>PENDING</i>]<br>';
								} else {
									$logs_array = explode(' | ', $logs_user[$key]);
									$status 	= $logs_array[0] == '' ? '-'  : $logs_array[0];
									$date 		= $logs_array[1] == '' ? ''  : date('M d, Y h:i:s A', strtotime($logs_array[1]));
									$remarks 	= $logs_array[2] == '' ? ''  : $logs_array[2];
									$user_logs .= get_emp_name_by_username_systemone_rapid($value);
									$user_logs .= ' <b>['.($logs_array[0] == '' ? '<i>PENDING</i>' : $status .' - <i>'. $date).'</i>] </b>'.$remarks.'<br>';
								}								
							} else {
								$logs_array = explode(' | ', $logs);
								$status 	= $logs_array[0] == '' ? '-'  : $logs_array[0];
								$date 		= $logs_array[1] == '' ? ''  : date('M d, Y h:i:s A', strtotime($logs_array[1]));
								$remarks 	= $logs_array[2] == '' ? ''  : $logs_array[2];
								$user_logs .= get_emp_name_by_username_systemone_rapid($value);
								$user_logs .= ' <b>['.($logs_array[0] == '' ? '<i>PENDING</i>' : $status .' - <i>'. $date).'</i>] </b>'.$remarks.'<br>';
							}
							
						// }						
					// }
					
				}	
			}
		}
		return $user_logs.'<hr>';
	}
?>