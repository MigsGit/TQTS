<?php
//Set Class name here, it's a good practice to Capitalize the first letter, I've just read it somewhere on the internet... so its up to you if will follow...
class TQTS extends mysqli 
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
		$path 		= '../';
		$db_config  = 'db_config/config_tqts.php';
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
	
	/*								---------------PUBLIC FUNCTIONS STARTS HERE---------------- */
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
	public function update_query_log($table,$array_fields,$array_values,$pkid,$column){ //NOTE: SET DEFAULT WEEK
		$update_arrays =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_arrays) ."WHERE `{$column}` ='{$pkid}';";
		$this->query($query);
		return $query;
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
		// return $query;
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
				// echo 'error.'.$array_values[$i].' <br>';
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
	
	public function get_table_fields($table){
		$result = $this->query("SHOW COLUMNS FROM $table");
		return $result;
	}
}


class SYSTEMONE extends mysqli 
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
		$path 		= '../';
		$db_config  = 'db_config/config_hris.php';
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
		// return $query;
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
	
	public function get_table_fields($table){
		$result = $this->query("SHOW COLUMNS FROM $table");
		return $result;
	}
}

/*		SEIKO Database	*/
class SEIKODB extends mysqli 
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
		$db = '../../db_config/seiko_iqc_db.php';

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

	
	
/* NOTE:  Count the Total Number of lot inspected, lot ok, samples and ng qty every WEEK*/
/* This query is intended to select every data from 1 table in sequential way*/
	public function select_query_weekly_report($sql_where_1,$sql_where_2,$sql_where_1_w2,$sql_where_2_w2,$sql_where_1_w3,
												$sql_where_2_w3,$sql_where_1_w4,$sql_where_2_w4,$sql_where_1_w5,$sql_where_2_w5){
		$query = "SELECT 
		(select count(*) FROM iqc_inspections {$sql_where_1}) AS 'WEEK_1_INSPECTED', 
		(select count(*) FROM iqc_inspections {$sql_where_2}) AS 'WEEK_1_ACCEPTED',
		(select SUM(sample_size) FROM iqc_inspections {$sql_where_1}) AS 'WEEK_1_SAMPLE',
		(select SUM(no_of_defects) FROM iqc_inspections {$sql_where_1}) AS 'WEEK_1_NG_QTY',


		(select count(*) FROM iqc_inspections {$sql_where_1_w2}) AS 'WEEK_2_INSPECTED',
		(select count(*) FROM iqc_inspections {$sql_where_2_w2}) AS 'WEEK_2_ACCEPTED',
		(select SUM(sample_size) FROM iqc_inspections {$sql_where_1_w2}) AS 'WEEK_2_SAMPLE',
		(select SUM(no_of_defects) FROM iqc_inspections {$sql_where_1_w2}) AS 'WEEK_2_NG_QTY',

		(select count(*) FROM iqc_inspections {$sql_where_1_w3}) AS 'WEEK_3_INSPECTED',
		(select count(*) FROM iqc_inspections {$sql_where_2_w3}) AS 'WEEK_3_ACCEPTED',
		(select SUM(sample_size) FROM iqc_inspections {$sql_where_1_w3}) AS 'WEEK_3_SAMPLE',
		(select SUM(no_of_defects) FROM iqc_inspections {$sql_where_1_w3}) AS 'WEEK_3_NG_QTY',

		(select count(*) FROM iqc_inspections {$sql_where_1_w4}) AS 'WEEK_4_INSPECTED',
		(select count(*) FROM iqc_inspections {$sql_where_2_w4}) AS 'WEEK_4_ACCEPTED',
		(select SUM(sample_size) FROM iqc_inspections {$sql_where_1_w4}) AS 'WEEK_4_SAMPLE',
		(select SUM(no_of_defects) FROM iqc_inspections {$sql_where_1_w4}) AS 'WEEK_4_NG_QTY',

		(select count(*) FROM iqc_inspections {$sql_where_1_w5}) AS 'WEEK_5_INSPECTED',
		(select count(*) FROM iqc_inspections {$sql_where_2_w5}) AS 'WEEK_5_ACCEPTED',
		(select SUM(sample_size) FROM iqc_inspections {$sql_where_1_w5}) AS 'WEEK_5_SAMPLE',
		(select SUM(no_of_defects) FROM iqc_inspections {$sql_where_1_w5}) AS 'WEEK_5_NG_QTY'
		";
		return $this->query($query);
	}
			
 /* THIS QUERY IS FOR CN -  is_deleted*/
/* NOTE:  Nested select the data from table = iqc_inspections from WEEK 1 to WEEK 5 group by Many Suppliers */
/* This query is intended to select every data from 1 table in sequential way*/


	// public function sql_select_group($sql_table,$sql_where_group_w1,$sql_column){
	// 	$query = "SELECT {$sql_column}, 
	// 		COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) AS 'LOT_INSPECTED',
	// 		COUNT(if(`judgement` = 'Accepted' AND `is_deleted`=0, 1, null)) as 'LOT_OK',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, sample_size, null)) as 'SAMPLES',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, `no_of_defects`, null)) as 'NG_QTY'
	// 		FROM {$sql_table} WHERE {$sql_where_group_w1}
	// 		GROUP BY {$sql_column}
	// 		";
	
	// 	// $query = "SELECT supplier,
	// 	// COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) AS 'LOT_INSPECTED',
	// 	// COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) as 'LOT_OK',
	// 	// SUM(if(`judgement` in ('accepted','rejected')  AND `is_deleted`=0, sample_size, null)) as 'SAMPLES',
	// 	// SUM(if(`judgement` in ('accepted','rejected')  AND `is_deleted`=0, `no_of_defects`, null)) as 'NG_QTY'
	// 	// FROM `iqc_inspections` WHERE `date_ispected` BETWEEN '2022-09-23' AND '2022-09-29'
	// 	// GROUP BY supplier" ;
	// 	return $this->query($query);
	// }
	// public function sql_select_group_w2($sql_table,$sql_where_group_w2,$sql_column){
	// 	$query = "SELECT {$sql_column}, 
	// 		COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) AS 'LOT_INSPECTED_W2',
	// 		COUNT(if(`judgement` = 'Accepted' AND `is_deleted`=0, 1, null)) as 'LOT_OK_W2',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, sample_size, null)) as 'SAMPLES_W2',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, `no_of_defects`, null)) as 'NG_QTY_W2'
	// 		FROM {$sql_table} WHERE {$sql_where_group_w2}
	// 		GROUP BY {$sql_column}
	// 		";
	// 	return $this->query($query);
	// }
	// public function sql_select_group_w3($sql_table,$sql_where_group_W3,$sql_column){

	// 	$query = "SELECT {$sql_column}, 
	// 		COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) AS 'LOT_INSPECTED_W3',
	// 		COUNT(if(`judgement` = 'Accepted' AND `is_deleted`=0, 1, null)) as 'LOT_OK_W3',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, sample_size, null)) as 'SAMPLES_W3',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, `no_of_defects`, null)) as 'NG_QTY_W3'
	// 		FROM {$sql_table} WHERE {$sql_where_group_W3}
	// 		GROUP BY {$sql_column}
	// 		";
	// 	return $this->query($query);
	// }
	// public function sql_select_group_w4($sql_table,$sql_where_group_W4,$sql_column){
	// 	$query = "SELECT {$sql_column}, 
	// 		COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) AS 'LOT_INSPECTED_W4',
	// 		COUNT(if(`judgement` = 'Accepted' AND `is_deleted`=0, 1, null)) as 'LOT_OK_W4',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, sample_size, null)) as 'SAMPLES_W4',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, `no_of_defects`, null)) as 'NG_QTY_W4'
	// 		FROM {$sql_table} WHERE {$sql_where_group_W4}
	// 		GROUP BY {$sql_column}
	// 		";
	// 	return $this->query($query);
	// }
	// public function sql_select_group_w5($sql_table,$sql_where_group_W5,$sql_column){
	// 	$query = "SELECT {$sql_column}, 
	// 		COUNT(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, 1, null)) AS 'LOT_INSPECTED_W5',
	// 		COUNT(if(`judgement` = 'Accepted' AND `is_deleted`=0, 1, null)) as 'LOT_OK_W5',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, sample_size, null)) as 'SAMPLES_W5',
	// 		SUM(if(`judgement` in ('accepted','rejected') AND `is_deleted`=0, `no_of_defects`, null)) as 'NG_QTY_W5'
	// 		FROM {$sql_table} WHERE {$sql_where_group_W5}
	// 		GROUP BY {$sql_column}
	// 		";
	// 	return $this->query($query);
	// }

/* NOTE:  Nested select the data from table = iqc_inspections from WEEK 1 to WEEK 5 group by Many Suppliers */
/* This query is intended to select every data from 1 table in sequential way*/
public function sql_select_group_by($sql_table,$sql_where,$sql_column,$lot_inspected,$lot_ok,$samples,$ng_qty){
	$query = "SELECT {$sql_column}, 
		COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS {$lot_inspected},
		COUNT(if(`judgement` = 'Accepted', 1, null)) as {$lot_ok},
		SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as {$samples},
		SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as {$ng_qty}
		FROM {$sql_table} WHERE {$sql_where}
		GROUP BY {$sql_column}
		";

	// $query = "SELECT supplier,
	// COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
	// COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
	// SUM(if(`judgement` in ('accepted','rejected') , sample_size, null)) as 'SAMPLES',
	// SUM(if(`judgement` in ('accepted','rejected') , `no_of_defects`, null)) as 'NG_QTY'
	// FROM `iqc_inspections` WHERE `date_ispected` BETWEEN '2022-09-23' AND '2022-09-29'
	// GROUP BY supplier" ;
	return $this->query($query);
}
public function sql_select_group_by_script($sql_table,$sql_where,$sql_column,$lot_inspected,$lot_ok,$samples,$ng_qty){
	$query = "SELECT {$sql_column}, 
		COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS {$lot_inspected},
		COUNT(if(`judgement` = 'Accepted', 1, null)) as {$lot_ok},
		SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as {$samples},
		SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as {$ng_qty}
		FROM {$sql_table} WHERE {$sql_where}
		GROUP BY {$sql_column}
		";

	// $query = "SELECT supplier,
	// COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
	// COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
	// SUM(if(`judgement` in ('accepted','rejected') , sample_size, null)) as 'SAMPLES',
	// SUM(if(`judgement` in ('accepted','rejected') , `no_of_defects`, null)) as 'NG_QTY'
	// FROM `iqc_inspections` WHERE `date_ispected` BETWEEN '2022-09-23' AND '2022-09-29'
	// GROUP BY supplier" ;
	return $query;
}
	public function sql_select_iqc($sql_table,$sql_where){
		$query = "SELECT, 
			COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
			COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
			SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as 'SAMPLES',
			SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as 'NG_QTY'
			FROM {$sql_table} WHERE {$sql_where}
			";

		// $query = "SELECT supplier,
		// COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
		// COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
		// SUM(if(`judgement` in ('accepted','rejected') , sample_size, null)) as 'SAMPLES',
		// SUM(if(`judgement` in ('accepted','rejected') , `no_of_defects`, null)) as 'NG_QTY'
		// FROM `iqc_inspections` WHERE `date_ispected` BETWEEN '2022-09-23' AND '2022-09-29'
		// GROUP BY supplier" ;
		return $this->query($query);
	}
	public function sql_select_group($sql_table,$sql_where_group_w1,$sql_column){
		$query = "SELECT {$sql_column}, 
			COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
			COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
			SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as 'SAMPLES',
			SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as 'NG_QTY'
			FROM {$sql_table} WHERE {$sql_where_group_w1}
			GROUP BY {$sql_column}
			";
	
		// $query = "SELECT supplier,
		// COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED',
		// COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK',
		// SUM(if(`judgement` in ('accepted','rejected') , sample_size, null)) as 'SAMPLES',
		// SUM(if(`judgement` in ('accepted','rejected') , `no_of_defects`, null)) as 'NG_QTY'
		// FROM `iqc_inspections` WHERE `date_ispected` BETWEEN '2022-09-23' AND '2022-09-29'
		// GROUP BY supplier" ;
		return $this->query($query);
	}
	public function sql_select_group_w2($sql_table,$sql_where_group_w2,$sql_column){
		$query = "SELECT {$sql_column}, 
			COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED_W2',
			COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK_W2',
			SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as 'SAMPLES_W2',
			SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as 'NG_QTY_W2'
			FROM {$sql_table} WHERE {$sql_where_group_w2}
			GROUP BY {$sql_column}
			";
		return $this->query($query);
	}
	public function sql_select_group_w3($sql_table,$sql_where_group_W3,$sql_column){

		$query = "SELECT {$sql_column}, 
			COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED_W3',
			COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK_W3',
			SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as 'SAMPLES_W3',
			SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as 'NG_QTY_W3'
			FROM {$sql_table} WHERE {$sql_where_group_W3}
			GROUP BY {$sql_column}
			";
		return $this->query($query);
	}
	public function sql_select_group_w4($sql_table,$sql_where_group_W4,$sql_column){
		$query = "SELECT {$sql_column}, 
			COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED_W4',
			COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK_W4',
			SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as 'SAMPLES_W4',
			SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as 'NG_QTY_W4'
			FROM {$sql_table} WHERE {$sql_where_group_W4}
			GROUP BY {$sql_column}
			";
		return $this->query($query);
	}
	public function sql_select_group_w5($sql_table,$sql_where_group_W5,$sql_column){
		$query = "SELECT {$sql_column}, 
			COUNT(if(`judgement` in ('accepted','rejected'), 1, null)) AS 'LOT_INSPECTED_W5',
			COUNT(if(`judgement` = 'Accepted', 1, null)) as 'LOT_OK_W5',
			SUM(if(`judgement` in ('accepted','rejected'), sample_size, null)) as 'SAMPLES_W5',
			SUM(if(`judgement` in ('accepted','rejected'), `no_of_defects`, null)) as 'NG_QTY_W5'
			FROM {$sql_table} WHERE {$sql_where_group_W5}
			GROUP BY {$sql_column}
			";
		return $this->query($query);
	}
/* NOTE:  This the Common Query */
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
	
	public function get_table_fields($table){
		$result = $this->query("SHOW COLUMNS FROM $table");
		return $result;
	}
	
}

class OQC extends mysqli 
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
		$db = '../db_config/seiko_oqc_db.php';
		if(file_exists($db)) {
			include($db);
		} else if(file_exists('../'.$db)) {
			include('../'.$db);
		}else if(file_exists('../../'.$db)){
			include('../../'.$db);
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
	
	public function get_table_fields($table){
		$result = $this->query("SHOW COLUMNS FROM $table");
		return $result;
	}
	
}

class WBSSUBSYSTEM extends mysqli 
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
		$db = '../db_config/seiko_wbs_db.php';
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
	
	////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
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


class PTIS extends mysqli 
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
		$path 		= '../';
		$db_config  = 'db_config/config_ptis.php';
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
	
	public function get_table_fields($table){
		$result = $this->query("SHOW COLUMNS FROM $table");
		return $result;
	}
}

//THIS CLASS CONNECTS INTO THE YPICS SERVER OR MSSQL Server	5.0
class YPICS4{
	//FUNCTION TO CONNECT TO MALACHI SERVER	
    private function connect_DBM(){
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
			if(!$result){
				return mssql_get_last_message;
			}
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
class CNYPICS{
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
class SYS1 extends mysqli
	{
		private static $instance = null;
		
		//db connection config variables
		private $user = "root";
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
class TSYPICS{
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

class RAPID extends mysqli {
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
	
	public function get_table_fields($table){
		$result = $this->query("SHOW COLUMNS FROM $table");
		return $result;
	}
}
?>


