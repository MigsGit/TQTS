<?php
//Set Class name here, it's a good practice to Capitalize the first letter, I've just read it somewhere on the internet... so its up to you if will follow...
class ROLES extends mysqli 
{
	private static $instance = null;
	
	public static function getInstance() {
		if(!self::$instance instanceof self) 
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __clone()
	{
		trigger_error('Clone is not allowed.',E_USER_ERROR);
	}
	
	public function __wakeup()
	{
		trigger_error('Deserializing is not allowed.',E_USER_ERROR);
	}
	
	private function __construct() {
		$path 		= '';
		$db_config  = 'db_config/config_tqts.php';
		if(file_exists($path.$db_config)){
			include($path.$db_config);
		}else{
			$path = '../';
			if(file_exists($path.$db_config)){
				include($path.$db_config);
			}else{
				$path = '../../';
				if(file_exists($path.$db_config)){
					include($path.$db_config);
				}else{
					exit;
				}
				
			}
		}
		parent::__construct($server, $username, $password, $db_name);
		// parent::__construct('localhost', 'root', 'r@p1d0nl1n3', 'db_tqts_ts_edited');
		
		if(mysqli_connect_error())
		{
			exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		parent::set_charset('utf-8');
	}

	////////////////////////////////////UP TO HERE////////////////////////////////////////
	
	////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
    
    public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "<br>SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};<br>";
		return $query;
	}
    
	public function select_query_with_variable($array_variable,$array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "";
		foreach($array_variable as $key => $value){
			$query .= "SET @".$key." = ".$value.';';
		}
		$query .= "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
	
	public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		// $this->save_logs('1',$query);
		return "New record has been saved";
	}
    
	/* insert a query and get the pkid */
	public function insert_query_id($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$result = $this->query($query);
		$new_pkid = $this->insert_id;
		// $this->save_logs('1',$query);
		return $new_pkid;
	}
	
	public function insert_query_script($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");<br>";
       	return $query;
	}
	
	public function insert_query_id_script($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");<br>";
       	return $query;
	}

	public function update_query($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}';";
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}
	
	public function update_query_script($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}'; <br>";
		return $query;
	}

	public function update_query_detailed($table,$array_fields,$array_values,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) .$where;
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}

	public function update_query_detailed_script($table,$array_fields,$array_values,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) .$where.' <br>';
		$this->query($query);
		return $query;
	}

	public function delete_query($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		$this->query($query);
		// $this->save_logs('3',$query);
		return "Record has been deleted";
	}

	public function delete_query_details($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `fkid_ot_main` = '{$pkid}';";
		$this->query($query);
		// $this->save_logs('3',$query);
		return "Record has been deleted";
	}
	
	public function add_quotations($array_values){
		$array_values_r = array();
		for($i=0;$i<count($array_values);$i++){
			if(isset($array_values[$i]) || $array_values[$i] != ''){
				$array_values[$i] = $this->real_escape_string($array_values[$i]);
				$array_values_r[$i] = "'".$array_values[$i]."'";
			}else{
				$array_values_r[$i] = '';
			}
		}
		return $array_values_r;
	}

	public function create_update_param($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_values[$i] = $this->real_escape_string($array_values[$i]);
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
	}
	
	public function save_logs($type,$query){
		$date_today = date('Y-m-d H:i:s');
		$new_query = str_replace("'",'"',$query);
		$logs = "INSERT INTO `tbl_logs` (`type_of_query`,`query`,`date`) VALUES('".$type."','".$new_query."','".$date_today."');";
		$this->query($logs);
	}
	
		public function check_unset($variable){
		if(!isset($variable)){
			$new_variable = '';
		}else{
			$new_variable = $variable;
		}
		return $new_variable;
	}
	
	public function check_if_array($array){
		if(!is_array($array)){
			$new_array = array($array);
		}else{
			$new_array = $array;
		}
		return $new_array;
	}
	
}


class SEIKODB3 extends mysqli 
{
	private static $instance = null;
	
	public static function getInstance() {
		if(!self::$instance instanceof self) 
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __clone()
	{
		trigger_error('Clone is not allowed.',E_USER_ERROR);
	}
	
	public function __wakeup()
	{
		trigger_error('Deserializing is not allowed.',E_USER_ERROR);
	}
	
	private function __construct() {
		$db = '../db_config/seiko_ts_iqc_db.php';
		if(file_exists($db)) {
			include($db);
		} else if(file_exists($db)) {
			include('../'.$db);
		}
		parent::__construct($server, $username, $password, $db_name);
		
		if(mysqli_connect_error())
		{
			exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		parent::set_charset('utf-8');
	}

	////////////////////////////////////UP TO HERE////////////////////////////////////////
	
	////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////
	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
    
    public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "<br>SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};<br>";
		return $query;
	}
    
	public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		// $this->save_logs('1',$query);
		return "New record has been saved";
	}
    
	/* insert a query and get the pkid */
	public function insert_query_id($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$result = $this->query($query);
		$new_pkid = $this->insert_id;
		// $this->save_logs('1',$query);
		return $new_pkid;
	}
	
	public function insert_query_script($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");<br>";
       	return $query;
	}

	public function update_query($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}';";
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}
	
	public function update_query_script($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}'; <br>";
		return $query;
	}

	public function update_query_detailed($table,$array_fields,$array_values,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) .$where;
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}

	public function update_query_detailed_script($table,$array_fields,$array_values,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) .$where.' <br>';
		$this->query($query);
		return $query;
	}

	public function delete_query($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		$this->query($query);
		// $this->save_logs('3',$query);
		return "Record has been deleted";
	}

	public function delete_query_details($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `fkid_ot_main` = '{$pkid}';";
		$this->query($query);
		// $this->save_logs('3',$query);
		return "Record has been deleted";
	}
	
	public function add_quotations($array_values){
		$array_values_r = array();
		for($i=0;$i<count($array_values);$i++){
			if(isset($array_values[$i]) || $array_values[$i] != ''){
				$array_values[$i] = $this->real_escape_string($array_values[$i]);
				$array_values_r[$i] = "'".$array_values[$i]."'";
			}else{
				$array_values_r[$i] = '';
			}
		}
		return $array_values_r;
	}

	public function create_update_param($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_values[$i] = $this->real_escape_string($array_values[$i]);
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
	}
	
	public function save_logs($type,$query){
		$date_today = date('Y-m-d H:i:s');
		$new_query = str_replace("'",'"',$query);
		$logs = "INSERT INTO `tbl_logs` (`type_of_query`,`query`,`date`) VALUES('".$type."','".$new_query."','".$date_today."');";
		$this->query($logs);
	}
	
		public function check_unset($variable){
		if(!isset($variable)){
			$new_variable = '';
		}else{
			$new_variable = $variable;
		}
		return $new_variable;
	}
	
	public function check_if_array($array){
		if(!is_array($array)){
			$new_array = array($array);
		}else{
			$new_array = $array;
		}
		return $new_array;
	}
	
}

//THIS CLASS CONNECTS INTO THE YPICS SERVER OR MSSQL Server	4.0
class YPICS43{
	//FUNCTION TO CONNECT TO MALACHI SERVER	
    private function connect_DBM(){
		// if(file_exists('../../db_config/db_ypics4.php')){
			// include('../../db_config/db_ypics4.php');
		// } else {
			// include('../db_config/db_ypics4.php');
		// }
		$path 		= '../';
		$db_config  = 'db_config/db_ypics4.php';
		if(file_exists($path.$db_config)){
			include($path.$db_config);
		}else{
			$path = '../../';
			if(file_exists($path.$db_config)){
				include($path.$db_config);
			}else{
				$path = '../../../';
				if(file_exists($path.$db_config)){
					include($path.$db_config);
				}else{
					exit;
				}
				
			}
		}
		$this->db_handleM = mssql_connect($server,$username,$password);
        return mssql_select_db($db_name,$this->db_handleM);
    }
   
    //FUNCTION TO CLOSE MALACHI SERVER
    private function close_DBM(){
        if(isset($this->db_handleM)){
            mssql_close($this->db_handleM);
        }
    }
	
	/////////////////////////////////PUBLIC FUNCTIONS///////////////////////////////////////////////	
	//FUNCTION TO LOAD PO NUM FROM MALACHI DATABASE
	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order){ //sample
		$db_found = $this->connect_DBM();
		if($db_found){
			$array_fields = implode(",",$array_fields);
			$SQL = "SELECT $array_fields FROM {$table} {$joins} {$sql_where} {$sql_order};";
			$result = mssql_query($SQL);
			return $result;
			mssql_free_result($result);
		}
		else{
			$errorMsg = "Database not found, Please contact your administrator";
		}
		$this->close_DBM();
	}
	public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order){ //sample
		$db_found = $this->connect_DBM();
		if($db_found){
			$array_fields = implode(",",$array_fields);
			$SQL = "SELECT $array_fields FROM {$table} {$joins} {$sql_where} {$sql_order};";
			return $SQL;
			mssql_free_result($result);
		}
		else{
			$errorMsg = "Database not found, Please contact your administrator";
		}
		$this->close_DBM();
	}
}


//THIS CLASS CONNECTS INTO THE YPICS SERVER OR MSSQL Server	
class CNYPICS3{
	//MALACHIXD CONNECTION INFO
	// private $serverM = "192.168.3.251\MSSQLSERVER"; //MSSQL Server of ypics
	// private $userM ="builder";  //username
	// private $passM = ""; //password
	// private $databaseM = ""; //database
	// private $db_handleM =""; //handler 
	
	//FUNCTION TO CONNECT TO MALACHI SERVER	
    private function connect_DBM(){
        include('../db_config/ypics_cn_db.php');
		$this->db_handleM = mssql_connect($server,$username,$password);
        return mssql_select_db($db_name,$this->db_handleM);
    }
   
    //FUNCTION TO CLOSE MALACHI SERVER
    private function close_DBM(){
        if(isset($this->db_handleM)){
            mssql_close($this->db_handleM);
        }
    }
	
	/////////////////////////////////PUBLIC FUNCTIONS///////////////////////////////////////////////	
	//FUNCTION TO LOAD PO NUM FROM MALACHI DATABASE
	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order){ //sample
		$db_found = $this->connect_DBM();
		if($db_found){
			$array_fields = implode(",",$array_fields);
			$SQL = "SELECT $array_fields FROM {$table} {$joins} {$sql_where} {$sql_order};";
			$result = mssql_query($SQL);
			return $result;
			// return $SQL;
			mssql_free_result($result);
		}
		else{
			$errorMsg = "Database not found, Please contact your administrator";
		}
		$this->close_DBM();
	}
}

//THIS CLASS CONNECTS INTO SYSTEMONE SERVER
class SYS13 extends mysqli
	{
		private static $instance = null;
		
		//db connection config variables
		private $user = "rapid";
		private $pass = "newd3v";
		private $dbName = "db_hris";
		private $dbHost = "192.168.3.240";

		public static function getInstance() {
			if(!self::$instance instanceof self) 
			{
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function __clone()
		{
			trigger_error('Clone is not allowed.',E_USER_ERROR);
		}
		
		public function __wakeup()
		{
			trigger_error('Deserializing is not allowed.',E_USER_ERROR);
		}
		
		private function __construct() {
			parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
			if(mysqli_connect_error())
			{
				exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			}
			parent::set_charset('utf-8');
		}

		////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
		public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $this->query($query);
		}
		public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $query;
		}
	}

//THIS CLASS CONNECTS INTO THE YPICS SERVER OR MSSQL Server	YPICS 3.1
class TSYPICS3{
	//MALACHIXD CONNECTION INFO
	// private $serverM = "192.168.3.251\MSSQLSERVER"; //MSSQL Server of ypics
	// private $userM ="builder";  //username
	// private $passM = ""; //password
	// private $databaseM = ""; //database
	// private $db_handleM =""; //handler 
	
	//FUNCTION TO CONNECT TO MALACHI SERVER	
    private function connect_DBM(){
        include('../../db_config/ypics_ts_db.php');
		$this->db_handleM = mssql_connect($server,$username,$password);
        return mssql_select_db($db_name,$this->db_handleM);
    }
   
    //FUNCTION TO CLOSE MALACHI SERVER
    private function close_DBM(){
        if(isset($this->db_handleM)){
            mssql_close($this->db_handleM);
        }
    }
	
	/////////////////////////////////PUBLIC FUNCTIONS///////////////////////////////////////////////	
	//FUNCTION TO LOAD PO NUM FROM MALACHI DATABASE
	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order){ //sample
		$db_found = $this->connect_DBM();
		if($db_found){
			$array_fields = implode(",",$array_fields);
			$SQL = "SELECT $array_fields FROM {$table} {$joins} {$sql_where} {$sql_order};";
			$result = mssql_query($SQL);
			return $result;
			// return $SQL;
			// mssql_free_result($result);
		}
		else{
			$errorMsg = "Database not found, Please contact your administrator";
			return dirname(__FILE__);;
			return $errorMsg;
		}
		$this->close_DBM();
	}
}

class RAPID3{
	private static $instance = null;
	
	public static function getInstance() {
		if(!self::$instance instanceof self) 
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __clone()
	{
		trigger_error('Clone is not allowed.',E_USER_ERROR);
	}
	
	public function __wakeup()
	{
		trigger_error('Deserializing is not allowed.',E_USER_ERROR);
	}
	
	private function __construct() {
		$path 		= '../';
		$db_config  = 'db_config/config_rapid.php';
		if(file_exists($path.$db_config)){
			include($path.$db_config);
		}else{
			$path = '../../';
			if(file_exists($path.$db_config)){
				include($path.$db_config);
			}else{
				$path = '../../../';
				if(file_exists($path.$db_config)){
					include($path.$db_config);
				}else{
					exit;
				}
				
			}
		}
		parent::__construct($server, $username, $password, $db_name);
		
		if(mysqli_connect_error())
		{
			exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		parent::set_charset('utf-8');
	}

	////////////////////////////////////UP TO HERE////////////////////////////////////////
	
	////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
    
    public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "<br>SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};<br>";
		return $query;
	}
    
	public function select_query_with_variable($array_variable,$array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "";
		foreach($array_variable as $key => $value){
			$query .= "SET @".$key." = ".$value.';';
		}
		$query .= "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
	
	public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		// $this->save_logs('1',$query);
		return "New record has been saved";
	}
    
	/* insert a query and get the pkid */
	public function insert_query_id($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$result = $this->query($query);
		$new_pkid = $this->insert_id;
		// $this->save_logs('1',$query);
		return $new_pkid;
	}
	
	public function insert_query_script($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");<br>";
       	return $query;
	}
	
	public function insert_query_id_script($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");<br>";
       	return $query;
	}

	public function update_query($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}';";
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}
	
	public function update_query_script($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}'; <br>";
		return $query;
	}

	public function update_query_detailed($table,$array_fields,$array_values,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) .$where;
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}

	public function update_query_detailed_script($table,$array_fields,$array_values,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) .$where.' <br>';
		$this->query($query);
		return $query;
	}

	public function delete_query($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		$this->query($query);
		// $this->save_logs('3',$query);
		return "Record has been deleted";
	}

	public function delete_query_details($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `fkid_ot_main` = '{$pkid}';";
		$this->query($query);
		// $this->save_logs('3',$query);
		return "Record has been deleted";
	}
	
	public function add_quotations($array_values){
		$array_values_r = array();
		for($i=0;$i<count($array_values);$i++){
			if(isset($array_values[$i]) || $array_values[$i] != ''){
				$array_values[$i] = $this->real_escape_string($array_values[$i]);
				$array_values_r[$i] = "'".$array_values[$i]."'";
			}else{
				$array_values_r[$i] = '';
			}
		}
		return $array_values_r;
	}

	public function create_update_param($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_values[$i] = $this->real_escape_string($array_values[$i]);
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
	}
	
	public function save_logs($type,$query){
		$date_today = date('Y-m-d H:i:s');
		$new_query = str_replace("'",'"',$query);
		$logs = "INSERT INTO `tbl_logs` (`type_of_query`,`query`,`date`) VALUES('".$type."','".$new_query."','".$date_today."');";
		$this->query($logs);
	}
	
		public function check_unset($variable){
		if(!isset($variable)){
			$new_variable = '';
		}else{
			$new_variable = $variable;
		}
		return $new_variable;
	}
	
	public function check_if_array($array){
		if(!is_array($array)){
			$new_array = array($array);
		}else{
			$new_array = $array;
		}
		return $new_array;
	}
}
?>


