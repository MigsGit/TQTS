<?php
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				/* do not edit below */
				case "fn_get_page" 									: fn_get_page(); break; 
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
	
	function fn_get_page(){
		$li_id = $_POST['page_id'];
		switch($li_id){
			case "li_dashboard"  	: $return['page'] = "dashboard"; break;
			case "li_iqc"  			: $return['page'] = "iqc"; break;
			case "li_qfr"  			: $return['page'] = "qfr"; break;
			case "li_ipqc"  		: $return['page'] = "ipqc"; break;
			case "li_oqc"  			: $return['page'] = "oqc"; break;
			case "li_etr"  			: $return['page'] = "etr"; break;
			case "li_ypd"  			: $return['page'] = "ypd"; break;
			case "li_ccte" 			: $return['page'] = "ccte"; break;
			case "li_configuration" : $return['page'] = "configuration"; break;
			default					: $return['page'] = "";
		}
		echo json_encode($return);
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