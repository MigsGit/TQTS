<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	ini_set('memory_limit', '8192M'); // or you could use 1G
	
	include('common_function.php');
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {				
				
				case "search_tqts"								: search_tqts(); break;
				case "search_equivalent_field"					: search_equivalent_field(); break;
				case "return_lost_cost_presentation"			: return_lost_cost_presentation(); break;
				
				
				/* qar */
				case "get_qar_data"								: get_qar_data(); break;
				case "save_qar"									: save_qar(); break;
				case "edit_qar"									: edit_qar(); break;
				case "get_last_ctrl_qar"						: get_last_ctrl_qar(); break;
				case "conform_and_send_qar"						: conform_and_send_qar(); break;
				case "reject_qar"								: reject_qar(); break;
				case "cancel_qar"								: cancel_qar(); break;
				case "close_qar"								: close_qar(); break;
				case "invalid_qar"								: invalid_qar(); break;
				case "add_disposition_qar_recipient"			: add_disposition_qar_recipient(); break;
				case "get_oqc_chart_data"						: get_oqc_chart_data(); break;
				
				/* QCFR - used as a reference only */
				case "upload_qcfr"								: upload_qcfr(); break;
				case "save_qcfr"								: save_qcfr(); break;
				case "load_qcfr_data_details"					: load_qcfr_data_details(); break;
				case "re_upload_qcfr"							: re_upload_qcfr(); break;
				case "edit_qcfr"								: edit_qcfr(); break;
				case "cancel_qcfr"								: cancel_qcfr(); break;
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	/* 
		Note:
		1. Use pipe "|" as your delimiter
	*/
	
	/* ***********************
		Dashboard - Start 
	*************************/
	function search_tqts(){
		/* *********************************
			Search in TQTS Module - Start 
		************************************/
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$search_category= explode("|",$_POST['search']['category']);
		$search_pattern	= $_POST['search']['search_pattern'];
		$array_table	= array(
								//tbl for IQC Visual inspection --> Seiko
								'tbl_iqc_measdata',									
								'tbl_qfr_ng',							
								'tbl_qfr_special_acceptance',								
								'tbl_qfr_aye',	
								'tbl_iqc_qar',
								'tbl_ipqc_pre_production',
								'tbl_ipqc_visual_inspection',
								'tbl_ipqc_dimension_inspection',
								'tbl_qfr_attention_tag',								
								'tbl_qfr_itn',											
								'tbl_qfr_qcfr',	
								//tbl for OQC Visual inspection --> Seiko
								'tbl_oqc_dir',
								'tbl_oqc_lon',
								//tbl for Yield Performance Data --> Seiko
								//tbl for PTIS --> PTIS System
								'tbl_qfr_8d',			
								'tbl_qfr_capa_main',			
								'tbl_theoretical_exam',			
								//'tbl_loss_cost_main',	 not included
								'tbl_etr_training'		
							   );
							   
		$array_table_info = array(
			"tbl_iqc_measdata" => array("text_display" => "IQC Measdata","icon" => "search","Module" => "IQC"),
			"tbl_qfr_ng" => array("text_display" => "QFR NG Report","icon" => "cogs","Module" => "QFR"),
			"tbl_qfr_special_acceptance" => array("text_display" => "QFR Special Acceptance","icon" => "cogs","Module" => "QFR"),
			"tbl_qfr_aye" => array("text_display" => "QFR AYE","icon" => "cogs","Module" => "QFR"),
			"tbl_iqc_qar" => array("text_display" => "IQC Quality Alert Report (QAR)","icon" => "search","Module" => "IQC"),
			"tbl_ipqc_pre_production" => array("text_display" => "IPQC Pre-Production","icon" => "search","Module" => "IPQC"),
			"tbl_ipqc_visual_inspection" => array("text_display" => "IPQC Visual Inspection","icon" => "search","Module" => "IPQC"),
			"tbl_ipqc_dimension_inspection" => array("text_display" => "IPQC Dimension Inspection","icon" => "search","Module" => "IPQC"),
			"tbl_qfr_attention_tag" => array("text_display" => "QFR Attention Tag","icon" => "cogs","Module" => "QFR"),
			"tbl_qfr_itn" => array("text_display" => "QFR ITN","icon" => "cogs","Module" => "QFR"),
			"tbl_qfr_qcfr" => array("text_display" => "QFR QCFR","icon" => "cogs","Module" => "QFR"),
			"tbl_oqc_dir" => array("text_display" => "OQC Dimension Inspection","icon" => "search","Module" => "OQC"),
			"tbl_oqc_lon" => array("text_display" => "OQC Lot-out Notice","icon" => "search","Module" => "OQC"),
			"tbl_qfr_8d" => array("text_display" => "QFR 8D","icon" => "cogs","Module" => "QFR"),
			"tbl_qfr_capa_main" => array("text_display" => "QFR CAPA","icon" => "file","Module" => "QFR"),
			"tbl_theoretical_exam" => array("text_display" => "Customer Claim Theoretical Exam","icon" => "edit","Module" => "QFR"),
			"tbl_etr_training" => array("text_display" => "ETR Training","icon" => "users","Module" => "ETR")
		);
		
		$field_to_show = array(
			"tbl_iqc_measdata" => array('date_time_created','invoice_number','lot_number','part_code','po_number','device_code','drawing_number','remarks'),
			"tbl_qfr_ng" => array('ng_report_no','issuance_date','invoice_no','part_code','po_number','drawing_number','material_type','file_name','supplier'),
			"tbl_qfr_special_acceptance" => array('control_number','category','parts_affected_parts','part_code','problem_parts','supplier','lot_number','quantity','device_name','problem_device','parts_affected_device','po_number','po_qty','supplier'),
			"tbl_qfr_aye" => array('control_no','category','part_code','parts_affected_parts','supplier','lot_number','quantity','date_issued','device_name','po_number','po_qty','customer_name','shipment_date','remarks'),
			"tbl_iqc_qar" => array('section','date_issued','part_code','part_name','model','lot_name','lot_qty'),
			"tbl_ipqc_pre_production" => array('measurescope_no','meas_year_month','remarks'), //no connection to po, invoice, partcode, or whatsoever
			"tbl_ipqc_visual_inspection" => array('line_number','station','fiscal_year','workweek','shift','fiscal_year'), //no connection to po, invoice, partcode, or whatsoever
			"tbl_ipqc_dimension_inspection" => array('inspection_date','po_number','category','inspection_file'),
			"tbl_qfr_attention_tag" => array('control_no','date','product','model','partscode_pono','lot_number','quantity','description','remarks'),
			"tbl_qfr_itn" => array('control_no','project','lot_no','model','date_time','station','issuance_date','lot_qty','findings_problem'),
			"tbl_qfr_qcfr" => array('control_no','qcfr_no','product_name','model_no','batch_no_lot_no','po_no_inv_no','date_received'),
			"tbl_oqc_dir" => array('po_number','series_name','shipment_date','customer','remarks'),
			"tbl_oqc_lon" => array('lon_no','rev_no','section','attention','po_number','lot_number','lot_qty','operator'),
			"tbl_qfr_8d" => array('po_number','po_qty','customer_name','defect_phenomenon','remarks'),
			"tbl_qfr_capa_main" => array('control_no','classification','section','product_mode','failure_mode','customer'),
			"tbl_theoretical_exam" => array('empno','date_exam','series_name','defect','exam_result'),
			"tbl_etr_training" => array('training_title','training_objective','mechanics','type_of_training','venue','control_no','series_name','reason_for_certification','reason_for_certification_value','reason_certification_others','training_category')
		);
		
		$array_where_clause = generate_table_where_clause($array_table,$search_category,$search_pattern);
		$array_row 			= array();
		$html				= '';
		$total_match_found  = 0;
		foreach($array_where_clause as $table_key => $where){
			if(trim($where) != ""){
				$array_data = array();
				$array_data = search_record_in_table($table_key,$where);
				if( count($array_data) > 0 ){
					$array_row[$table_key]  = array();
					$array_row[$table_key]  = $array_data;
					$total_match_found 	   += count($array_data);
					$html .= generate_search_html($array_table_info[$table_key],count($array_data),$field_to_show[$table_key],$array_data);
				}
			}
		}
		
		/* *********************************
			Search in TQTS Module - End 
		***********************************/
		/* ***********************************
			Search in Seiko Database - Start 
		*************************************/
		$array_table	= array(
								'iqc_inspections'
							   );
		$array_table_info = array(
			"iqc_inspections" =>  array("text_display" => "IQC Visual Inspection","icon" => "search","Module" => "IQC")
			
		);
		$field_to_show = array(
			"iqc_inspections" => array('invoice_no','partcode','partname','supplier','app_date','app_time','app_no','lot_no','lot_qty','judgement')
		);
		$array_where_clause = generate_table_where_clause_seiko_subsystem($array_table,$search_category,$search_pattern);
		foreach($array_where_clause as $table_key => $where){
			if(trim($where) != ""){
				$array_data = array();
				$array_data = search_record_in_table_seiko_subsystem($table_key,$where);
				if( count($array_data) > 0 ){
					$array_row[$table_key]  = array();
					$array_row[$table_key]  = $array_data;
					$total_match_found 	   += count($array_data);
					$html .= generate_search_html($array_table_info[$table_key],count($array_data),$field_to_show[$table_key],$array_data);
				}
			}
		}
		$return['seiko_subystem_where_clause'] = $array_where_clause;
		
		/* ***********************************
			Search in Seiko Database - End 
		*************************************/
		
		/* ***********************************
			Search in PTIS Database - Start 
		*************************************/
		$array_table	= array(
								'vw_po_with_ptis'
							   );
		$array_table_info = array(
			"vw_po_with_ptis" => array("text_display" => "QFR PTIS","icon" => "cogs","Module" => "QFR")
		);
		$field_to_show = array(
			"vw_po_with_ptis" => array('pkid_poNo','deviceName','ptisNo','section','family','judgementPMI','judgeDate','incharge','regDate')
		);
		$array_where_clause = generate_table_where_clause_ptis($array_table,$search_category,$search_pattern);
		foreach($array_where_clause as $table_key => $where){
			if(trim($where) != ""){
				$array_data = array();
				$array_data = search_record_in_table_ptis($table_key,$where);
				if( count($array_data) > 0 ){
					$array_row[$table_key]  = array();
					$array_row[$table_key]  = $array_data;
					$total_match_found 	   += count($array_data);
					$html .= generate_search_html($array_table_info[$table_key],count($array_data),$field_to_show[$table_key],$array_data);
				}
			}
		}
		$return['seiko_subystem_where_clause'] = $array_where_clause;
		
		/* ***********************************
			Search in PTIS Database - End 
		*************************************/
		$return['html'] 		  	  = $html;
		$return['total_match_found']  = $total_match_found;
		$return['array_row'] 		  = $array_row;
		$return['array_where_clause'] = $array_where_clause;
		echo json_encode($return);
	}
	
	function generate_table_where_clause($array_table,$search_category,$search_pattern){
		$array_where = array();
		foreach($array_table as $table_key => $table){
			$array_where[$table] = array();
			$fields = get_table_fields($table);
			foreach($search_category as $search_key => $category){
				if( in_array($category, $fields) ){
					$array_where[$table][] = $category.' LIKE "%'.$search_pattern.'%"';
				}
			}
			if( count($array_where[$table]) > 0 ){
				$array_where[$table] = 'WHERE '.implode( " AND ", $array_where[$table]);
				/* Order By Date Created */
				if( in_array('date_created',$fields) ){
					$array_where[$table] .= ' ORDER BY date_created DESC';
				}
			}else{
				$array_where[$table] = '';
			}
		}
		return $array_where;
	}
	
	function generate_table_where_clause_seiko_subsystem($array_table,$search_category,$search_pattern){
		$array_where = array();
		foreach($array_table as $table_key => $table){
			$array_where[$table] = array();
			$fields = get_table_fields_seiko_subsystem($table);
			foreach($search_category as $search_key => $category){
				if( in_array($category, $fields) ){
					$array_where[$table][] = $category.' LIKE "%'.$search_pattern.'%"';
				}
			}
			if( count($array_where[$table]) > 0 ){
				$array_where[$table] = 'WHERE '.implode( " AND ", $array_where[$table]);
				if( in_array('created_at',$fields) ){
					$array_where[$table] .= ' ORDER BY created_at DESC';
				}
			}else{
				$array_where[$table] = '';
			}
		}
		return $array_where;
	}
	
	function generate_table_where_clause_ptis($array_table,$search_category,$search_pattern){
		$array_where = array();
		foreach($array_table as $table_key => $table){
			$array_where[$table] = array();
			$fields = get_table_fields_ptis($table);
			foreach($search_category as $search_key => $category){
				if( in_array($category, $fields) ){
					$array_where[$table][] = $category.' LIKE "%'.$search_pattern.'%"';
				}
			}
			if( count($array_where[$table]) > 0 ){
				$array_where[$table] = 'WHERE '.implode( " AND ", $array_where[$table]);
				if( in_array('created_at',$fields) ){
					$array_where[$table] .= ' ORDER BY regDate DESC';
				}
			}else{
				$array_where[$table] = '';
			}
		}
		return $array_where;
	}
	
	function generate_search_html($array_table_info,$match_found,$field_to_show,$array_data){
		$html  = '<article class="search-result row">';
		// $html .= '	<div class="row">';
		// $html .= '		<div class="col-xs-3" style="padding:0px;">';
		// $html .= '			<div class="panel panel-default" style="padding:0px;">';
		// $html .= '				<div class="panel-body alert-info" style="padding-right:0px;color:white;">';
		// $html .= '					<a href="#" title="" class=""><center><span class="fa fa-'.$array_table_info['icon'].' fa-3x"> '.$array_table_info['Module'].'</span></center></a>';
		// $html .= '				</div>';
		// $html .= '			</div>';
		// $html .= '		</div>';
		// $html .= '		<div class="col-xs-9" style="padding:0px;">';
		// $html .= '			<div class="panel panel-default" style="padding:0px;">';
		// $html .= '				<div class="panel-body alert-default" style="">';
		// $html .= '					<ul class="meta-search">';
		// $html .= '						<p><strong class="text-primary fa-lg">'.$array_table_info['text_display'].'</strong></p>';
		// $html .= '						<p><strong class="text-danger">'.$match_found.' result/s found</strong></p>';
		// $html .= '						<p><span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i> Expand</a></span></p>';
		// $html .= '					</ul>';
		// $html .= '				</div>';
		// $html .= '			</div>';
		// $html .= '		</div>';
		// $html .= '	</div>';
		
		$html .= '	<div class="col-xs-12 col-sm-12 col-md-3">';
		$html .= '		<a href="#" title="Lorem ipsum" class="thumbnail"><center><span class="fa fa-'.$array_table_info['icon'].' fa-3x"> '.$array_table_info['Module'].'</span></center></a>';
		$html .= '	</div>';
		$html .= '	<div class="col-xs-12 col-sm-12 col-md-2">';
		$html .= '		<ul class="meta-search">';
		$html .= '			<li><i class="glyphicon glyphicon-tags"></i> <span>'.$array_table_info['Module'].'</span></li>';
		$html .= '		</ul>';
		$html .= '	</div>';
		$html .= '	<div class="col-xs-12 col-sm-12 col-md-7 excerpet">';
		$html .= '		<p><strong class="text-primary fa-lg">'.$array_table_info['text_display'].'</strong></p>';
		$html .= '		<p><strong class="text-danger">'.$match_found.' result/s found</strong></p>';
		$html .= '		<p><span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i> Expand</a></span></p>';
		$html .= '	</div>';
		
		$html .= '	<div class="col-xs-12 excerpet" style="display:none;" id="div_expanded_content">';
		$html .= '		<table class="table table-bordered table-striped table-condensed" style="font-size:11px;" id="tbl_search_result">';
		$html .= '			<thead>';
		$html .= '				<tr>';
		foreach($field_to_show as $key => $header){
			$html .= '				<th>'.search_equivalent_text($header).'</th>';
		}
		$html .= '				</tr>';
		$html .= '			</thead>';
		$html .= '			<tbody>';
		foreach($array_data as $data_key => $row){
			$html .= '				<tr>';
			foreach($field_to_show as $field_key => $field_name){
				$html .= '				<td>'.$row[$field_name].'</td>';
			}
			$html .= '				</tr>';
		}
		$html .= '			</tbody>';
		$html .= '		</table>';
		$html .= '	</div>';
		$html .= '	<span class="clearfix borda"></span>';
		$html .= '</article>';
		return $html;
	}
	
	function search_record_in_table($table,$where){
		require_once('../class/oop_tqts.php');
		$table			= $table;
		$array_fields	= array('*');
		$joins			= '';
		$sql_where		= $where;
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$array_row	= array();
		while($row = mysqli_fetch_assoc($result)){
			$array_row[] = $row;
		}
		return $array_row;
	}
	
	function search_record_in_table_seiko_subsystem($table,$where){
		require_once('../class/oop_tqts.php');
		$table			= $table;
		$array_fields	= array('*');
		$joins			= '';
		$sql_where		= $where;
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= SEIKODB::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= SEIKODB::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit); 
		$array_row	= array();
		while($row = mysqli_fetch_assoc($result)){
			$array_row[] = $row;
		}
		return $array_row;
	}
	
	function search_record_in_table_ptis($table,$where){
		require_once('../class/oop_tqts.php');
		$table			= $table;
		$array_fields	= array('*');
		$joins			= '';
		$sql_where		= $where;
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= PTIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= PTIS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$array_row	= array();
		while($row = mysqli_fetch_assoc($result)){
			$array_row[] = $row;
		}
		return $array_row;
	}
	
	function search_equivalent_field(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$table			= "tbl_field_text_display";
		$array_fields	= array('field_name','text_display');
		$joins			= '';
		$sql_where		= 'WHERE text_display = "'.trim($_POST['category']).'" ';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['row']	= array();
		while($row = mysqli_fetch_assoc($result)){
			$return['row'][] = $row['field_name'];
		}
		$field_name = implode("|",$return['row']);
		$return['field_name'] = $field_name;
		$return['script'] = $script;
		echo json_encode($return);
	}
	
	function search_equivalent_text($field_name){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$table			= "tbl_field_text_display";
		$array_fields	= array('field_name','text_display');
		$joins			= '';
		$sql_where		= 'WHERE field_name = "'.trim($field_name).'" ';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$text_display   = '';
		while($row = mysqli_fetch_assoc($result)){
			$text_display = $row['text_display'];
		}
		return $text_display;
	}
	
	function return_lost_cost_presentation() {
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$table			= "tbl_loss_cost_main";
		$array_fields	= array('tbl_loss_cost_mdetails.pkid','(SELECT `file_path` FROM `tbl_file_path` WHERE tbl_file_path.pkid = tbl_loss_cost_mdetails.fkfile_path AND logdel=0 LIMIT 0,1) as file_path','file_name','month_year','remarks');
		$joins			= 'INNER JOIN tbl_loss_cost_mdetails ON tbl_loss_cost_mdetails.fklosscost = tbl_loss_cost_main.pkid';
		$sql_where		= 'WHERE tbl_loss_cost_main.month_year BETWEEN "'.$return['date_start'].'" AND "'.$return['date_end'].'" AND tbl_loss_cost_main.logdel=0 AND tbl_loss_cost_mdetails.logdel=0';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$frame   = '';
		while($row = mysqli_fetch_assoc($result)){
			$pkid 	   = $row['pkid'];
			$file_path = 'TQTS_edited/'.$row['file_path'];
			$extension = end(explode('.',$row['file_name']));
			$file_name = $row['file_name'];		
			$file 	   = $file_path . $pkid . '.' . $extension;
			$frame[]   = $file;
		}
		$return['loss_cost'] = $frame;
		$return['num_rows'] = $result->num_rows;
		echo json_encode($return);
	}
	/* ***********************
		Dashboard - End 
	*************************/
	
	/* QAR Start */
	function get_qar_data(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$table			= "tbl_iqc_qar";
		$array_fields  	= array('*');
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$_POST['id'].'"';
		$sql_order		= '';
		$sql_limit		= '';
		$result = TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$return['row'] 	= array();
		while($row = mysqli_fetch_assoc($result)){
			$return['row']	= $row;
		}
		/* for select2 data */
		if(count($return['row']) != 0){
			/* Attn */
			$array_attn = explode("|",$return['row']['attn']);
			$return['data_attn'] = array();
			foreach($array_attn as $key => $value){
				$array_data_attn = array();
				$array_data_attn['id'] 			= $value;
				$array_data_attn['text'] 		= get_emp_name_by_username_systemone($value);
				$return['data_attn'][] 			= $array_data_attn;
			}
			/* CC */
			$array_cc = explode("|",$return['row']['cc']);
			$return['data_cc'] = array();
			foreach($array_cc as $key => $value){
				$array_data_cc = array();
				$array_data_cc['id'] 			= $value;
				$array_data_cc['text'] 			= get_emp_name_by_username_systemone($value);
				$return['data_cc'][] 			= $array_data_cc;
			}
			/* QC Supervisor */
			$array_cc = explode("|",$return['row']['qc_supervisor']);
			$return['data_qc_supervisor'] = array();
			foreach($array_cc as $key => $value){
				$array_data_cc = array();
				$array_data_cc['id'] 			= $value;
				$array_data_cc['text'] 			= get_emp_name_by_username_systemone($value);
				$return['data_qc_supervisor'][]	= $array_data_cc;
			}
		}
		$return['row']['file_src_ok_condition_file'] = "";
		if($return['row']['ok_condition_files'] != ""){
			$file_path_ok 							= return_file_path_by_div_mod('iqc_qar_ok');
			$return['row']['file_src_ok_condition_file']	= str_replace("../","",$file_path_ok['path'].$return['row']['pkid'].'/'.$return['row']['ok_condition_files']);
		}
		$return['row']['file_src_ng_condition_file'] = "";
		if($return['row']['ng_condition_files'] != ""){
			$file_path_ok 							= return_file_path_by_div_mod('iqc_qar_ng');
			$return['row']['file_src_ng_condition_file']	= str_replace("../","",$file_path_ok['path'].$return['row']['pkid'].'/'.$return['row']['ng_condition_files']);
		}
		if($return['row']['file_src_ok_condition_file'] == ""){
			$return['row']['file_src_ok_condition_file'] = "uploaded_file/no_image.jpg";
		}
		if($return['row']['file_src_ng_condition_file'] == ""){
			$return['row']['file_src_ng_condition_file'] = "uploaded_file/no_image.jpg";
		}
		/* Disposition Portion */
		/* check if request has and uploaded disposition */
		if($return['row']['status'] == 3 || $return['row']['status'] == 4){
			if( $return['row']['status'] == 3 ){
				$return['row']['span_disposition_text'] = 'For Review Disposition';
				$return['row']['span_disposition_class'] = 'badge highlight-color-yellow pull-right';
			}
			if( $return['row']['status'] == 4 ){
				$return['row']['span_disposition_text'] = 'Closed Disposition';
				$return['row']['span_disposition_class'] = 'badge highlight-color-green pull-right';
			}
		}else{
			$return['row']['span_disposition_text'] = 'No Disposition';
			$return['row']['span_disposition_class'] = 'badge highlight-color-red pull-right';
		}
		echo json_encode($return);
	}
	
	function save_qar(){
		/* tweek some values */
		$error = array();
		if(isset($_POST['to'])){ 	
			$_POST['to']	= $_POST['to']; 	
		}else{
			$_POST['to']	= "";
		}
		if(isset($_POST['attn'])){ 	
			$_POST['attn']	= implode("|",$_POST['attn']); 	
		}else{
			$_POST['attn']	= "";
		}
		if(isset($_POST['cc'])){ 	
			$_POST['cc']	= implode("|",$_POST['cc']); 	
		}else{
			$_POST['cc']	= "";
		}
		if(isset($_POST['qc_supervisor'])){ 	
			$_POST['qc_supervisor']	= implode("|",$_POST['qc_supervisor']); 	
		}else{
			$_POST['qc_supervisor']	= "";
		}
		$return 				= $_POST;		
		$return['ng_file'] 		= $_FILES['ng_condition_files'];		
		$return['ok_file'] 		= $_FILES['ok_condition_files'];	
		/* check image size */
		$ok_filesize 			= convert_file_size_to_mb($_FILES['ok_condition_files']['size']);
		$ng_filesize 			= convert_file_size_to_mb($_FILES['ng_condition_files']['size']);
		if($ok_filesize > 2){
			$error[] = "Ok image cannot exceed 2mb!";
		}
		if($ng_filesize > 2){
			$error[] = "NG Image cannot exceed 2mb!";
		}
		/* Check if uploaded file is an image */
		$image_mime_type = array("image/png","image/jpeg","image/bmp");
		
		if(!in_array($_FILES['ok_condition_files']['type'],$image_mime_type) && $_FILES['ok_condition_files']['name'] != ""){
			$error[] = "Uploaded File for OK condition is not an image!";
		}
		if(!in_array($_FILES['ng_condition_files']['type'],$image_mime_type) && $_FILES['ng_condition_files']['name'] != ""){
			$error[] = "Uploaded File for NG condition is not an image!";
		}
		if($_POST['section'] == ""){
			$error[] = "Your account has not been assigned with a section, Please contact the system administrator.";
		}
		if($_POST['to'] == ""){
			$error[] = "Please enter a value for [to:]";
		}
		if($_POST['cc'] == ""){
			$error[] = "Please enter a value for [cc:]";
		}
		if($_POST['attn'] == ""){
			$error[] = "Please enter a value for [attn:]";
		}
		if($_POST['lot_name'] == ""){
			$error[] = "Please enter a lot number";
		}
		if($_POST['mode_of_defect'] == ""){
			$error[] = "Please enter a mode of defect";
		}
		$return['error'] = $error;
		if(count($error) != 0){
			echo json_encode($return);
			exit;
		}		
		$_POST['created_by'] 			= $_POST['username'];
		$_POST['date_created'] 			= date('Y-m-d H:i:s');
		$_POST['lastupdate'] 			= date('Y-m-d H:i:s');
		$_POST['control_no_count']		= get_last_ctrl_no_count();
		$_POST['ok_condition_files'] 	= $_FILES['ok_condition_files']['name'];
		$_POST['ng_condition_files'] 	= $_FILES['ng_condition_files']['name'];
		/* Save if threre are no error encountered */
		$array_fields_values = get_fields_values($_POST, array("action"));
		require_once('../class/oop_tqts.php');
		$table 			= "tbl_iqc_qar";
		foreach($array_fields_values['array_fields'] as $key => $value){
			$array_fields_values['array_fields'][$key] = '`'.$value.'`';
		}
		$array_fields	= $array_fields_values['array_fields'];
		$array_values	= $array_fields_values['array_values'];
		$pkid 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
		$script 		= TQTS::getInstance()->insert_query_id_script($table,$array_fields,$array_values);
		$return['pkid'] 				= $pkid;
		$return['script'] 				= $script;
		$return['array_fields_values'] 	= $array_fields_values;
		/* Save uploaded files */
		if($_FILES['ok_condition_files']['name'] != ""){
			$file_path_ok 				= return_file_path_by_div_mod('iqc_qar_ok');
			if(!file_exists($file_path_ok['path'].$pkid)){
				mkdir($file_path_ok['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ok['path'].$pkid);
			}
			move_uploaded_file($_FILES['ok_condition_files']['tmp_name'],$file_path_ok['path'].$pkid.'/'.$_FILES['ok_condition_files']['name']);
		}
		if($_FILES['ng_condition_files']['name'] != ""){
			$file_path_ng 				= return_file_path_by_div_mod('iqc_qar_ng');
			if(!file_exists($file_path_ng['path'].$pkid)){
				mkdir($file_path_ng['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ng['path'].$pkid);
			}
			move_uploaded_file($_FILES['ng_condition_files']['tmp_name'],$file_path_ng['path'].$pkid.'/'.$_FILES['ng_condition_files']['name']);
		}
		/* Send mail to mailer */
		$mail_data  = array();
		$to		   	= explode("|", $_POST['qc_supervisor']);
		$to_email 	= array();
		foreach($to as $key => $username){
			$to_email[] = return_user_email_add($username);
		}
		$to_email  =  implode(",",$to_email);
		$cc_email    = '';
		$bcc		 = 'marlope@pricon.ph,ronfern@pricon.ph';
		$from		 = 'issinforservice@pricon.ph';
		$from_name	 = 'TQTS Mailer';
		$subject 	 = 'Quality Alert Report - Awaiting Conformance';
		$message 	 = 'Good Day! <br><br>';
		$message 	.= 'This is to inform that you have a Quality Alert awaiting for Conformance. <br>';
		$message 	.= 'Quality Alert Information: <br>';
		$message 	.= 'Date Issued: '.$_POST['date_issued'].'<br>';
		$message 	.= 'Partcode: '.$_POST['part_code'].'<br>';
		$message 	.= 'Partname: '.$_POST['part_name'].'<br>';
		$message 	.= 'Model: '.$_POST['model'].'<br>';
		$message 	.= 'Mode of Defect: '.$_POST['mode_of_defect'].'<br>';
		$message 	.= 'Please login to Rapid with this link http://rapid <br><br>';
		$message 	.= 'This is a system message generated by the system, Please do not reply!';
		$send_date_time = date('Y-m-d H:i:s');
		require_once('../class/send_email.php');
		$email = new email;
		$mailer_result = $email->send_email_detailed($to_email, $from, $from_name, $cc_email, $bcc, $subject, $message, $send_date_time, $_POST['username']);
		$return['mail_data'] 		= $mailer_result;
		echo json_encode($return);
	}
	
	function edit_qar(){
		/* tweek some values */
		$error = array();
		$return = $_POST;
		
		if(isset($_POST['to'])){ 	
			$_POST['to']	= $_POST['to']; 	
		}else{
			$_POST['to']	= "";
		}
		if(isset($_POST['attn'])){ 	
			$_POST['attn']	= implode("|",$_POST['attn']); 	
		}else{
			$_POST['attn']	= "";
		}
		if(isset($_POST['cc'])){ 	
			$_POST['cc']	= implode("|",$_POST['cc']); 	
		}else{
			$_POST['cc']	= "";
		}
		if(isset($_POST['qc_supervisor'])){ 	
			$_POST['qc_supervisor']	= implode("|",$_POST['qc_supervisor']); 	
		}else{
			$_POST['qc_supervisor']	= "";
		}
		$return 				= $_POST;		
		$return['ng_file'] 		= $_FILES['ng_condition_files'];		
		$return['ok_file'] 		= $_FILES['ok_condition_files'];	
		
		/* check image size */
		$ok_filesize 			= convert_file_size_to_mb($_FILES['ok_condition_files']['size']);
		$ng_filesize 			= convert_file_size_to_mb($_FILES['ng_condition_files']['size']);
		if($ok_filesize > 2){
			$error[] = "Ok image cannot exceed 2mb!";
		}
		if($ng_filesize > 2){
			$error[] = "NG Image cannot exceed 2mb!";
		}
		/* Check if uploaded file is an image */
		$image_mime_type = array("image/png","image/jpeg","image/bmp");
		if(!in_array($_FILES['ok_condition_files']['type'],$image_mime_type) && $_FILES['ok_condition_files']['name'] != ""){
			$error[] = "Uploaded File for OK condition is not an image!";
		}
		if(!in_array($_FILES['ng_condition_files']['type'],$image_mime_type) && $_FILES['ng_condition_files']['name'] != ""){
			$error[] = "Uploaded File for NG condition is not an image!";
		}
		if($_POST['section'] == ""){
			$error[] = "Your account has not been assigned with a section, Please contact the system administrator.";
		}
		if($_POST['to'] == ""){
			$error[] = "Please enter a value for [to:]";
		}
		if($_POST['cc'] == ""){
			$error[] = "Please enter a value for [cc:]";
		}
		if($_POST['attn'] == ""){
			$error[] = "Please enter a value for [attn:]";
		}
		
		if($_POST['lot_name'] == ""){
			$error[] = "Please enter a lot number";
		}
		if($_POST['mode_of_defect'] == ""){
			$error[] = "Please enter a mode of defect";
		}
		$return['error'] = $error;
		if(count($error) != 0){
			echo json_encode($return);
			exit;
		}
		
		$_POST['created_by'] 			= $_POST['username'];
		$_POST['date_created'] 			= date('Y-m-d H:i:s');
		$_POST['lastupdate'] 			= date('Y-m-d H:i:s');
		
		if($_FILES['ok_condition_files']['name'] != ""){
			$_POST['ok_condition_files'] 	= $_FILES['ok_condition_files']['name'];
		}
		if($_FILES['ng_condition_files']['name'] != ""){
			$_POST['ng_condition_files'] 	= $_FILES['ng_condition_files']['name'];
		}		
		
		require_once('../class/oop_tqts.php');
		$array_fields_values = get_fields_values($_POST, array("action","id"));
		$table			= 'tbl_iqc_qar';
		$array_fields 	= $array_fields_values['array_fields'];
		$array_values 	= $array_fields_values['array_values'];
		$where 			= "WHERE `pkid` = '".$_POST['id']."' ";
		
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_detailed_script($table,$array_fields,$array_values,$where);
		$return['script']	= $script;
		
		/* Save uploaded files */
		$pkid = $_POST['id'];
		if($_FILES['ok_condition_files']['name'] != ""){
			$file_path_ok 				= return_file_path_by_div_mod('iqc_qar_ok');
			if(!file_exists($file_path_ok['path'].$pkid."/")){
				mkdir($file_path_ok['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ok['path'].$pkid."/");
			}
			move_uploaded_file($_FILES['ok_condition_files']['tmp_name'],$file_path_ok['path'].$pkid.'/'.$_FILES['ok_condition_files']['name']);
		}
		if($_FILES['ng_condition_files']['name'] != ""){
			$file_path_ng 				= return_file_path_by_div_mod('iqc_qar_ng');
			if(!file_exists($file_path_ng['path'].$pkid."/")){
				mkdir($file_path_ng['path'].$pkid.'/', 0777);
				$return['xpath'] = ($file_path_ng['path']."/".$pkid);
			}
			move_uploaded_file($_FILES['ng_condition_files']['tmp_name'],$file_path_ng['path'].$pkid.'/'.$_FILES['ng_condition_files']['name']);
		}
		echo json_encode($return);
	}
	
	function get_last_ctrl_qar(){
		$return = $_POST;
		$control_no = "QAR-TS-".$_POST['section']."-".date('my');
		$last_ctrl_no_count = str_pad(get_last_ctrl_no_count(),3,0,STR_PAD_LEFT);
		$control_no = $control_no."-".$last_ctrl_no_count;
		$return['control_no'] = $control_no;
		echo json_encode($return);
	}
	
	function get_last_ctrl_no_count(){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("max(control_no_count) as last_ctrl");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= '';
		$sql_order		= '';
		$sql_limit		= '';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$last_ctrl		= $row['last_ctrl'] + 1;
		$last_ctrl		= str_pad($last_ctrl,3,0,STR_PAD_LEFT);
		return $last_ctrl;
	}
	
	function convert_file_size_to_mb($file_size){
		$file_size = (($file_size / 1024) / 1024);
		return $file_size;
	}
	
	function conform_and_send_qar(){
		require_once('../class/oop_tqts.php');
		$return 		=  $_POST;
		$return['error']= array();
		if( $_POST['disposition_required_date_reply'] == "" ){
			$return['error'][] = 'Please enter a required date reply!';
		}
		if(count($return['error']) != 0){
			echo json_encode($return);
			exit;
		}
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','date_conformed','conformed_by',
								'disposition_required_date_reply','username','lastupdate');
		$array_values 	= array('1',date('Y-m-d H:i:s'),$_POST['username'],
								$_POST['disposition_required_date_reply'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		
		/* Send mail to mailer */
		$to		   	= explode("|", $_POST['attn']);
		$to_email 	= array();
		foreach($to as $key => $username){
			$to_email[] = return_user_email_add($username);
		}
		$to_email = implode(",",$to_email);
		$cc		   = explode('|',$_POST['cc']);
		$cc_email 	= array();
		foreach($cc as $key => $username){
			$cc_email[] = return_user_email_add($username);
		}
		$cc_email    = implode(",",$cc_email);
		$bcc		 = 'marlope@pricon.ph,ronfern@pricon.ph';
		$from		 = 'issinforservice@pricon.ph';
		$from_name	 = 'TQTS Mailer';
		$subject 	 = 'Quality Alert Report - Awaiting Disposition';
		$message 	 = 'Good Day! <br><br>';
		$message 	.= 'This is to inform that you have a Quality Alert awaiting for disposition. <br>';
		$message 	.= 'Quality Alert Information: <br>';
		$message 	.= 'Date Issued: '.$_POST['date_issued'].'<br>';
		$message 	.= 'Partcode: '.$_POST['part_code'].'<br>';
		$message 	.= 'Partname: '.$_POST['part_name'].'<br>';
		$message 	.= 'Model: '.$_POST['model'].'<br>';
		$message 	.= 'Mode of Defect: '.$_POST['mode_of_defect'].'<br>';
		$message 	.= 'Please login to Rapid with this link http://rapid <br><br>';
		$message 	.= 'This is a system message generated by the system, Please do not reply!';
		$send_date_time = date('Y-m-d H:i:s');
		// $date_start  = $_POST['disposition_required_date_reply'];
		$date_start  = date('Y-m-d');
		require_once('../class/send_email.php');
		$email = new email;
		$mailer_result = $email->send_scheduled_email($table, $_POST['id'], $to_email, $from, $cc_email, $subject, $message, $date_start, '2');
		$return['mail_data'] 		= $mailer_result;
		echo json_encode($return); 
	}
	
	function reject_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','date_conformed','conformed_by','username','lastupdate');
		$array_values 	= array('2',date('Y-m-d H:i:s'),$_POST['username'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function close_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','date_conformed','conformed_by','username','lastupdate');
		$array_values 	= array('4',date('Y-m-d H:i:s'),$_POST['username'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function cancel_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','remarks','username','lastupdate');
		$array_values 	= array('9',$_POST['remarks'],$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function invalid_qar(){
		require_once('../class/oop_tqts.php');
		$return 		= $_POST;
		$history		= get_qar_history($_POST['id']);
		$history 		= $history."<br>";
		$history 	   .= "User (".$_POST['username']."): Invalid QAR Remarks<br>";
		$history 	   .= $_POST['remarks'];
		$return['error']= array();
		$table			= 'tbl_iqc_qar';
		$array_fields 	= array('status','remarks','username','lastupdate');
		$array_values 	= array('9',$history,$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		/* Close alert */
		$mailer_result  = close_auto_mailer($table,$_POST['id']);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		echo json_encode($return);
	}
	
	function add_disposition_qar_recipient(){
		require_once('../class/oop_tqts.php');
		$return 					= $_POST;
		$return['file']				= $_FILES['file_excel_with_disposition'];
		$mime_content_type			= array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$disposition_rev 			= get_qar_disposition_last_rev($_POST['id']);
		$return['disposition_rev']	= $disposition_rev;
		$disposition_history		= get_qar_disposition_history($_POST['id']);
		$disposition_history		= $disposition_history."rev=".$disposition_rev.';disposition_by='.$_POST['username'].';disposition_date='.date('Y-m-d H:i:s');
		$return['error']	= array();
		if(!in_array($return['file']['type'],$mime_content_type)){
			$return['error'][]= "File uploaded is not an excel file";
		}
		if( count($return['error']) != 0 ){
			echo json_encode($return);
			exit;
		}
		$table			= 'tbl_iqc_qar';
		$array_fields	= array('status','disposition_file_name','disposition_rev',
								'disposition_by','disposition_date','disposition_history',
								'lastupdate','username');
		$array_values 	= array('3',$return['file']['name'],$disposition_rev,
								$_POST['username'],date('Y-m-d H:i:s'),$disposition_history,
								$_POST['username'],date('Y-m-d H:i:s'));
		$where 			= "WHERE `pkid` = '".$_POST['id']."'";
		$result			= TQTS::getInstance()->update_query_detailed($table,$array_fields,$array_values,$where);
		$script			= TQTS::getInstance()->update_query_script($table,$array_fields,$array_values,$where);
		$return['result'] 		= $result;
		$return['script'] 		= $script;
		/* Move uploaded file */
		$file_path = return_file_path_by_div_mod('iqc_qar_disposition');
		$file_path_disposition = $file_path['path'].$_POST['id'].'/';
		if(!file_exists($file_path_disposition)){
			mkdir($file_path_disposition,0777);
		}
		$file_path_disposition = $file_path_disposition.$disposition_rev.'/';
		if(!file_exists($file_path_disposition)){
			mkdir($file_path_disposition,0777);
		}
		move_uploaded_file($return['file']['tmp_name'], $file_path_disposition.$return['file']['name']);
		/* Close alert */
		$mailer_result  = close_auto_mailer($table,$_POST['id']);
		echo json_encode($return);
	}
	
	function get_qar_disposition_last_rev($pkid){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("disposition_rev");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= "WHERE pkid ='".$pkid."' ";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$disposition_rev = -1;
		if($row['disposition_rev'] == ""){
			$disposition_rev = -1;
		}else{
			$disposition_rev = $row['disposition_rev'];
		}
		$disposition_rev = $disposition_rev + 1;
		return $disposition_rev;
	}
	
	function get_qar_disposition_history($pkid){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("disposition_history");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= "WHERE pkid ='".$pkid."' ";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$disposition_history = "";
		if($row['disposition_history'] == ""){
			$disposition_history = "";
		}else{
			$disposition_history = $row['disposition_history'];
		}
		if($disposition_history != ""){
			$disposition_history = $disposition_history."|";
		}
		return $disposition_history;
	}
	
	function get_qar_history($pkid){
		require_once('../class/oop_tqts.php');
		$control_no = '';
		$array_fields 	= array("qar_history");
		$table			= "tbl_iqc_qar";
		$joins			= '';
		$sql_where		= "WHERE pkid ='".$pkid."' ";
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$row			= mysqli_fetch_assoc($result);
		$qar_history = "";
		if($row['qar_history'] == ""){
			$qar_history = "";
		}else{
			$qar_history = $row['qar_history'];
		}
		if($qar_history != ""){
			$qar_history = $qar_history."|";
		}
		return $qar_history;
	}
	
	/* QAR End */
	
	/* Charts Start */
	function get_oqc_chart_data(){
		$return = $_POST;
		$search_data 	= $_POST['search_data'];
		$date_start 	= $search_data['date_start'];
		$date_end		= $search_data['date_end'];
		$process		= $search_data['process'];
		
		if($process == 'IQC') {
			$data = get_iqc_visual_inspection_data($date_start,$date_end);
			$static_target_lar = 96.60;

			$static_target_dppm  = 0;
		} else {
			$data = get_visual_inspection_data($date_start,$date_end);	
			$static_target_lar = 97.97;
			$static_target_dppm  = 6;
		}
		/* values for return */
		$array_dataset_label 		= array('Target Dppm','Actual Dppm','Target LAR','Actual LAR');
		$array_labels 				= array();
		$array_target_dppm			= array();
		$array_actual_dppm			= array();
		$array_target_lar			= array();
		$array_actual_lar			= array();
		
		/* Daily Chart */
		if($search_data['frequency'] == 'Daily'){
			$array_day = array();
			$day_one =  $date_start;
			$last_day = $date_end;
			$day_ctr = $day_one;
			while( strtotime($day_ctr) <= strtotime($last_day) ){
				$array_day[] = $day_ctr;
				$day_ctr = date('Y-m-d',strtotime($day_ctr . " +1 day"));
			}
			
			$array_data_per_day = array();
			foreach($array_day as $key => $date){
				$array_data_per_day[$date] = array(
					"date_inspected"	=>  "",
					"lot_inspected"	=>  array(),
					"lot_accepted"	=>  array(),
					"sample_size"	=>  array(),
					"lot_rejected"	=>  array(),
					"target_dppm"	=>  array(),
					"actual_dppm"	=>  array(),
					"target_lar"	=>  array(),
					"actual_lar"	=>  array()
				);
			}
			
			/* place values */
			foreach($data as $key => $row){
				$array_data_per_day[ $row['date_inspected'] ]['date_inspected'] 	= $row['date_inspected'];
				$array_data_per_day[ $row['date_inspected'] ]['lot_inspected'][] 	= $row['lot_inspected'];
				$array_data_per_day[ $row['date_inspected'] ]['lot_accepted'][] 	= $row['lot_accepted'];
				$array_data_per_day[ $row['date_inspected'] ]['sample_size'][] 		= $row['sample_size'];
				$array_data_per_day[ $row['date_inspected'] ]['lot_rejected'][] 	= $row['lot_rejected'];
				$target_dppm = get_target_dppm($row['date_inspected']);
				$array_data_per_day[ $row['date_inspected'] ]['target_dppm'][] 		= $target_dppm;
				$actual_dppm = 0;
				if(!$row['lot_rejected'] == 0){
					$actual_dppm = @(($row['lot_rejected']/$row['sample_size'])*1000000);
				}
				$array_data_per_day[ $row['date_inspected'] ]['actual_dppm'][] 		= $actual_dppm;
				$target_lar = get_target_lar($row['date_inspected']);
				$array_data_per_day[ $row['date_inspected'] ]['target_lar'][] 		= $target_lar;
				$actual_lar = @($row['lot_accepted'] / $row['lot_inspected']);
				$array_data_per_day[ $row['date_inspected'] ]['actual_lar'][] 		= $actual_lar;
			}
			$count = 0;
			$array_daily_data = array();
			foreach($array_data_per_day as $date_key => $row){
				$row['date_inspected'] 	= $date_key;
				$row['lot_inspected'] 	= array_sum($row['lot_inspected']);
				$row['lot_accepted'] 	= array_sum($row['lot_accepted']);
				$row['sample_size'] 	= array_sum($row['sample_size']);
				$row['lot_rejected'] 	= array_sum($row['lot_rejected']);
				$target_dppm = 0;
				if(count($row['target_dppm']) != 0 && array_sum($row['target_dppm']) != 0){
					$target_dppm = array_sum($row['target_dppm']) / count($row['target_dppm']);
					// $target_dppm = $static_target_dppm;
				}
				// $row['target_dppm'] = $target_dppm; 	
				$row['target_dppm'] = $static_target_dppm; 
				$actual_dppm = 0;
				if(count($row['actual_dppm']) != 0 && array_sum($row['actual_dppm']) != 0){
					$actual_dppm = round(($row['lot_rejected']/$row['sample_size'])*1000000,2);
				}
				$row['actual_dppm'] = $actual_dppm;
				$target_lar = 0;
				if(count($row['target_lar']) != 0 && array_sum($row['target_lar']) != 0){
					$target_lar = array_sum($row['target_lar']) / count($row['target_lar']);
				}
				// $row['target_lar'] = $target_lar * 100;
				// $row['target_lar'] =96.60;
				$row['target_lar'] =$static_target_lar;
				$actual_lar = 0;
				if(count($row['actual_lar']) != 0 && array_sum($row['actual_lar']) != 0){
					$actual_lar = array_sum($row['actual_lar']) / count($row['actual_lar']);
				}
				$row['actual_lar'] = round($actual_lar * 100,2);
				$array_daily_data[] = $row;
				$count++;
			}
			/* return values */
			foreach($array_daily_data as $key => $row){
				$array_target_dppm[]		= $row['target_dppm'];
				$array_actual_dppm[]		= $row['actual_dppm'];
				$array_target_lar[]			= $row['target_lar'];
				$array_actual_lar[]			= $row['actual_lar'];
			}
			$return['table_data']		 	= $array_daily_data;
			$return['array_labels']		 	= $array_day;
			$return['array_target_dppm']	= $array_target_dppm;
			$return['array_actual_dppm']	= $array_actual_dppm;
			$return['array_target_lar']		= $array_target_lar;
			$return['array_actual_lar']		= $array_actual_lar;
			// print_r($return['table_data']);
			// echo $count;
		}
		else if($search_data['frequency'] == 'Weekly'){
			$array_week_range = array();
			$day_one =  $date_start;
			$last_day = $date_end;
			$day_ctr = $day_one;
			while( strtotime($day_ctr) <= strtotime($last_day) ){
				$current_day_one = $day_ctr;
				$current_day = date( 'D', strtotime($day_ctr));
				do{
					$day_ctr = date('Y-m-d',strtotime($day_ctr . " +1 day"));
					$current_day = date( 'D', strtotime($day_ctr));
				}while($current_day != 'Sun' && strtotime($day_ctr) < strtotime($last_day));
				$array_week_range[] = $current_day_one.'|'.$day_ctr;
			}					
			
			$array_data_per_week = array();
			foreach($array_week_range as $key => $week){
				$array_data_per_week[$week] = array(
					"date_inspected"	=>  "",
					"lot_inspected"	=>  array(),
					"lot_accepted"	=>  array(),
					"sample_size"	=>  array(),
					"lot_rejected"	=>  array(),
					"target_dppm"	=>  array(),
					"actual_dppm"	=>  array(),
					"target_lar"	=>  array(),
					"actual_lar"	=>  array()
				);
			}
			/* place values */
			foreach($data as $key => $row){
				foreach($array_week_range as $key_week => $week_range){
					$week_explode 	= explode("|",$week_range);
					$week_first_day = $week_explode[0];
					$week_last_day 	= $week_explode[1];
					if( strtotime($row['date_inspected']) >= strtotime($week_first_day) && strtotime($row['date_inspected']) <= strtotime($week_last_day)){
						$row['date_inspected'] = $week_range;
					}
				}
				$array_data_per_week[ $row['date_inspected'] ]['date_inspected'] 	= $row['date_inspected'];
				$array_data_per_week[ $row['date_inspected'] ]['lot_inspected'][] 	= $row['lot_inspected'];
				$array_data_per_week[ $row['date_inspected'] ]['lot_accepted'][] 	= $row['lot_accepted'];
				$array_data_per_week[ $row['date_inspected'] ]['sample_size'][] 		= $row['sample_size'];
				$array_data_per_week[ $row['date_inspected'] ]['lot_rejected'][] 	= $row['lot_rejected'];
				$target_dppm = get_target_dppm($row['date_inspected']);
				$array_data_per_week[ $row['date_inspected'] ]['target_dppm'][] 		= $target_dppm;
				$actual_dppm = 0;
				if(!$row['lot_rejected'] == 0){
					$actual_dppm = @(($row['lot_rejected']/$row['sample_size'])*1000000);
				}
				$array_data_per_week[ $row['date_inspected'] ]['actual_dppm'][] 		= $actual_dppm;
				$target_lar = get_target_lar($row['date_inspected']);
				$array_data_per_week[ $row['date_inspected'] ]['target_lar'][] 		= $target_lar;
				$actual_lar = @($row['lot_accepted'] / $row['lot_inspected']);
				$array_data_per_week[ $row['date_inspected'] ]['actual_lar'][] 		= $actual_lar;
			}
			$array_weekly_data = array();
			$count = 0;
			foreach($array_data_per_week as $date_key => $row){
				$row['date_inspected'] 	= $date_key;
				$row['lot_inspected'] 	= array_sum($row['lot_inspected']);
				$row['lot_accepted'] 	= array_sum($row['lot_accepted']);
				$row['sample_size'] 	= array_sum($row['sample_size']);
				$row['lot_rejected'] 	= array_sum($row['lot_rejected']);
				$target_dppm = 0;
				if(count($row['target_dppm']) != 0 && array_sum($row['target_dppm']) != 0){
					$target_dppm = array_sum($row['target_dppm']) / count($row['target_dppm']);
					// $target_dppm = $static_target_dppm;
				}
				// $row['target_dppm'] = $target_dppm;  
				$row['target_dppm'] = $static_target_dppm;
				$actual_dppm = 0;
				if(count($row['actual_dppm']) != 0 && array_sum($row['actual_dppm']) != 0){
					$actual_dppm = round(($row['lot_rejected']/$row['sample_size'])*1000000,2);
				}
				$row['actual_dppm'] = $actual_dppm;
				$target_lar = 0;
				if(count($row['target_lar']) != 0 && array_sum($row['target_lar']) != 0){
					$target_lar = array_sum($row['target_lar']) / count($row['target_lar']);
				}
				// $row['target_lar'] = $target_lar * 100;
				// $row['target_lar'] =96.60;
				$row['target_lar'] =$static_target_lar;
				$actual_lar = 0;
				if(count($row['actual_lar']) != 0 && array_sum($row['actual_lar']) != 0){
					$actual_lar = array_sum($row['actual_lar']) / count($row['actual_lar']);
				}
				$row['actual_lar'] = round($actual_lar * 100,2);
				$array_weekly_data[] = $row;
				$count++;
			}
			/* return values */
			foreach($array_weekly_data as $key => $row){
				$array_target_dppm[]		= $row['target_dppm'];
				$array_actual_dppm[]		= $row['actual_dppm'];
				$array_target_lar[]			= $row['target_lar'];
				$array_actual_lar[]			= $row['actual_lar'];
			}
			$return['table_data']		 	= $array_weekly_data;
			$return['array_labels']		 	= $array_week_range;
			$return['array_target_dppm']	= $array_target_dppm;
			$return['array_actual_dppm']	= $array_actual_dppm;
			$return['array_target_lar']		= $array_target_lar;
			$return['array_actual_lar']		= $array_actual_lar;
		}
		else if($search_data['frequency'] == 'Monthly'){
			$array_month_year = array();
			$array_day = array();
			$day_one =  $date_start;
			$last_day = $date_end;
			$day_ctr = $day_one;
			while( strtotime($day_ctr) <= strtotime($last_day) ){
				$month_year = date('Y-m', strtotime($day_ctr));
				if(!in_array($month_year,$array_month_year)){
					$array_month_year[] = $month_year;
				}
				$day_ctr = date('Y-m-d',strtotime($day_ctr . " +1 day"));
			}

			$array_data_per_month = array();
			foreach($array_month_year as $key => $month_year){
				$array_data_per_month[$month_year] = array(
					"date_inspected"	=>  $month_year,
					"lot_inspected"	=>  array(),
					"lot_accepted"	=>  array(),
					"sample_size"	=>  array(),
					"lot_rejected"	=>  array(),
					"target_dppm"	=>  array(),
					"actual_dppm"	=>  array(),
					"target_lar"	=>  array(),
					"actual_lar"	=>  array()
				);
			}
			foreach($data as $key => $row){
				$month_year = date('Y-m', strtotime($row['date_inspected']));
				$row['date_inspected'] = $month_year;
				$array_data_per_month[ $row['date_inspected'] ]['date_inspected'] 		= $row['date_inspected'];
				$array_data_per_month[ $row['date_inspected'] ]['lot_inspected'][] 		= $row['lot_inspected'];
				$array_data_per_month[ $row['date_inspected'] ]['lot_accepted'][] 		= $row['lot_accepted'];
				$array_data_per_month[ $row['date_inspected'] ]['sample_size'][] 		= $row['sample_size'];
				$array_data_per_month[ $row['date_inspected'] ]['lot_rejected'][] 		= $row['lot_rejected'];
				$target_dppm = get_target_dppm($row['date_inspected']);
				$array_data_per_month[ $row['date_inspected'] ]['target_dppm'][] 		= $target_dppm;
				$actual_dppm = 0;
				if(!$row['lot_rejected'] == 0){
					$actual_dppm = @(($row['lot_rejected']/$row['sample_size'])*1000000);
				}
				$array_data_per_month[ $row['date_inspected'] ]['actual_dppm'][] 		= $actual_dppm;
				$target_lar = get_target_lar($row['date_inspected']);
				$array_data_per_month[ $row['date_inspected'] ]['target_lar'][] 		= $target_lar;
				$actual_lar = @($row['lot_accepted'] / $row['lot_inspected']);
				$array_data_per_month[ $row['date_inspected'] ]['actual_lar'][] 		= $actual_lar;
				
			}
			// print_r($actual_lar);
			
			$array_monthly_data = array();
			$count = 0;
			foreach($array_data_per_month as $date_key => $row){
				$row['date_inspected'] 	= $date_key;
				$row['lot_inspected'] 	= array_sum($row['lot_inspected']);
				$row['lot_accepted'] 	= array_sum($row['lot_accepted']);
				$row['sample_size'] 	= array_sum($row['sample_size']);
				$row['lot_rejected'] 	= array_sum($row['lot_rejected']);

				/** Get the values of actual dppm and actual lar */
				$target_dppm = 0;
				if(count($row['target_dppm']) != 0 && array_sum($row['target_dppm']) != 0){
					$target_dppm = array_sum($row['target_dppm']) / count($row['target_dppm']);
					// $target_dppm = $static_target_dppm;
				}
				// $row['target_dppm'] = $target_dppm; 
				$row['target_dppm'] = $static_target_dppm;
				$actual_dppm = 0;
				if(count($row['actual_dppm']) != 0 && array_sum($row['actual_dppm']) != 0){
					$actual_dppm = round(($row['lot_rejected']/$row['sample_size'])*1000000,2);
				}
				$row['actual_dppm'] = $actual_dppm;
				$target_lar = 0;
				if(count($row['target_lar']) != 0 && array_sum($row['target_lar']) != 0){
					$target_lar = array_sum($row['target_lar']) / count($row['target_lar']);
				}
				// $row['target_lar'] = $target_lar * 100;
				// $row['target_lar'] =96.60;
				$row['target_lar'] =$static_target_lar;
				$actual_lar = 0;
				if(count($row['actual_lar']) != 0 && array_sum($row['actual_lar']) != 0){
					$actual_lar = array_sum($row['actual_lar']) / count($row['actual_lar']);
				}
				$row['actual_lar'] = round($actual_lar * 100,2);
				$array_monthly_data[] = $row;
				$count ++;
			}
			/* return values */
			foreach($array_monthly_data as $key => $row){
				$array_target_dppm[]		= $row['target_dppm'];
				$array_actual_dppm[]		= $row['actual_dppm'];
				$array_target_lar[]			= $row['target_lar'];
				$array_actual_lar[]			= $row['actual_lar'];
			}
			
			$return['table_data']		 	= $array_monthly_data;
			$return['array_labels']		 	= $array_month_year;
			$return['array_target_dppm']	= $array_target_dppm;
			$return['array_actual_dppm']	= $array_actual_dppm;
			$return['array_target_lar']		= $array_target_lar;
			$return['array_actual_lar']		= $array_actual_lar;
			// print_r($return['table_data']);
			// echo $count;
		}
		$return['array_dataset_label'] = $array_dataset_label;
		echo json_encode($return);
	}
	/* Charts End */
	
	
	/* **********************
		Advance Search
	 ********************** */
	 function qfr_8d_return_dir_fields(){
		$ctr = 0;
		$option		  =	array();
		$option[$ctr] = '<option value="po_number">P.O. Number</option>'; $ctr++;
		$option[$ctr] = '<option value="customer_name">Customer Name</option>'; $ctr++;
		$option[$ctr] = '<option value="defect_phenomenon">Defect Phenomenon</option>'; $ctr++;
		$option[$ctr] = '<option value="due_date">Due Date</option>'; $ctr++;
		$option[$ctr] = '<option value="report_file">Report File</option>'; $ctr++;
		$option[$ctr] = '<option value="approver">Approver</option>'; $ctr++;
		$option[$ctr] = '<option value="created_by">Uploaded By</option>'; $ctr++;
		$return['option'] 	= $option;
		$return['ctr'] 		= $ctr;
		echo json_encode($return);
	 }
	 
	 function qfr_8d_advance_search() {
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
		// echo json_encode($result);
	}
	
	function load_8d_main_data(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$array_fields	= array('pkid','status', 'po_number', 'customer_name', 'defect_phenomenon', 'due_date', 'remarks');
		$table			= 'tbl_qfr_8d';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$return['pkid'].'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
		}
		
		$approver_username	= array();
		$date_time_approved	= array();
		$approver_status	= array();
		$array_fields = array('approver_username','date_time_approved', 'status');
		$table 	   	= ' tbl_qfr_8d_approvers';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `fk8d`="'.$_POST['pkid'].'" AND logdel="0"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$result 	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 	= TQTS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$approver_username[] 			= $row['approver_username'];
			$date_time_approved[]		 	= $row['date_time_approved'];
			$approver_status[] 				= $row['status'];
		}
		$return['approver_username'] 	= implode(',',$approver_username);
		$return['date_time_approved']	= implode(',',$date_time_approved);
		$return['approver_status'] 		= implode(',',$approver_status);
		$return['script'] 				= $script;
		
		echo json_encode($return);
	}
	
	/* 8D End */

	

	/* QCFR Start */
	function upload_qcfr(){
		/* library for reading excel files */
		/* Read your Excel workbook */
		$inputFileName = $_FILES['file_qcfr']['tmp_name'];
		$original_file_name = $_FILES['file_qcfr']['name'];
		$excel_data 								= get_excel_content($inputFileName,100);
		/* get excel values */
		$return['excel_data']['qcfr_no'] 			= $excel_data['E6'];
		$return['excel_data']['product_name'] 		= $excel_data['B19'];
		$return['excel_data']['model_no'] 			= $excel_data['B20'];
		$return['excel_data']['batch_no_lot_no'] 	= $excel_data['B21'];
		$return['excel_data']['po_no_inv_no']		= $excel_data['B22'];
		$return['excel_data']['date_received'] 		= $excel_data['B23'];
		/* Get uploaded file filename */
		$return['original_file_name'] = $original_file_name;
		/* Check if uploaded file exist on /tmp/ folder */
		if(file_exists($inputFileName)){
			/* move the file to the temp directory */
			move_uploaded_file($inputFileName,'../uploaded_file/temp/qcfr/'.$original_file_name);
		}
		echo json_encode($return);
	}

	function save_qcfr(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		if($_POST['action'] == "save_qcfr"){
			/* check if qcfr data is already a duplicate copy */
			$return['error'] = array();
			$filename 		= str_replace('C:\fakepath\\',"",$_POST['excel_file']);
			if(!file_exists('../uploaded_file/temp/qcfr/'.$filename)){
				$return['error'][] = 'Please re-upload the file!';
			}
			$qcfr_no		= $_POST['qcfr_no'];
			$array_fields 	= array('qcfr_no');
			$table  		= "tbl_qfr_qcfr";
			$joins  	 	= "";
			$sql_where  	= "WHERE `qcfr_no` = '$qcfr_no'";
			$sql_order  	= "";
			$sql_limit  	= "";
			$result        	= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			if($result->num_rows != 0){
				$return['error'][] = 'QCFR No '.$qcfr_no." already exist!";
			}
			if(count($return['error']) == 0){
				/* save qcfr information */
				$table 						= "tbl_qfr_qcfr";
				$values 					= get_fields_values($_POST,array("action","username","excel_file"));
				$array_fields 				= $values["array_fields"];
				$array_values 				= $values["array_values"];
				$array_fields[] 			= "filename"; $array_values[] = $filename;
				$array_fields[] 			= "created_by"; $array_values[] = $_POST["username"];
				$array_fields[] 			= "date_created"; $array_values[] = date("Y-m-d H:i:s");
				$array_fields[] 			= "lastupdate"; $array_values[] = date("Y-m-d H:i:s");
				$array_fields[] 			= "username"; $array_values[] = $_POST["username"];
				$pk_file_uploaded 			= TQTS::getInstance()->insert_query_id($table,$array_fields,$array_values);
				$script 					= TQTS::getInstance()->insert_query_script($table,$array_fields,$array_values);
				$return['script'] 		= $script;
				/* save uploaded file details */
				if(file_exists('../uploaded_file/temp/qcfr/'.$filename)){
				$file_path 	= return_file_path_by_div_mod('qcfr');
					$ext 		= pathinfo('../uploaded_file/temp/qcfr/'.$filename, PATHINFO_EXTENSION);
					rename('../uploaded_file/temp/qcfr/'.$filename, $file_path['path'].$pk_file_uploaded.'.'.$ext);
					$return['file_moved'] = $file_path['path'].$pk_file_uploaded.'.'.$ext;
				}else{
					$return['file_moved'] = false;
				}
			}
		}
		$return['filename'] = $filename;
		echo json_encode($return);
	}
	
	function load_qcfr_data_details(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		$array_fields	= array('*');
		$table			= 'tbl_qfr_qcfr';
		$joins			= '';
		$sql_where		= 'WHERE `pkid` = "'.$return['pkid'].'" AND logdel="0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_assoc($result)){
			$return['data'] = $row;
		}
		echo json_encode($return);
	}
	
	function re_upload_qcfr(){
		require_once('../class/oop_tqts.php');
		$return = $_POST;
		/* Get excel values */
		$inputFileName 		= $_FILES['file_qcfr']['tmp_name'];
		$original_file_name = $_FILES['file_qcfr']['name'];
		$excel_data 								= get_excel_content($inputFileName,100);
		/* get excel values */
		$return['excel_data']['qcfr_no'] 			= $excel_data['E6'];
		$return['excel_data']['product_name'] 		= $excel_data['B19'];
		$return['excel_data']['model_no'] 			= $excel_data['B20'];
		$return['excel_data']['batch_no_lot_no'] 	= $excel_data['B21'];
		$return['excel_data']['po_no_inv_no']		= $excel_data['B22'];
		$return['excel_data']['date_received'] 		= $excel_data['B23'];		
		/* Get uploaded file filename */
		$return['original_file_name'] = $original_file_name;
		/* Check if uploaded file exist on /tmp/ folder */
		if(file_exists($inputFileName)){
			/* move the file to the temp directory */
			move_uploaded_file($inputFileName,'../uploaded_file/temp/qcfr/'.$original_file_name);
		}
		echo json_encode($return);
	}
	
	function edit_qcfr(){
		require_once('../class/oop_tqts.php');
		$return 					= $_POST;
		$return['error'] 			= array();
		$filename 					= str_replace('C:\fakepath\\',"",$_POST['excel_file']);
		/* Validate if the Control Number Exist on other data */
		$existing_qcfr_no = qcfr_ctrl_no_exist($return["pkid"],$return["qcfr_no"]); //for change QCFR number base on excel data
		$return['existing_qcfr_no'] = $existing_qcfr_no;
		if($return['existing_qcfr_no']){
			$return['error'][] = 'The control number for the excel file you want to replace is already existing on other record.';
		}
		if(count($return['error']) == 0){
			/* Update the current data */
			$table  					= 'tbl_qfr_qcfr';
			$values 					= get_fields_values($_POST,array("action","pkid","username","excel_file"));
			$array_fields 				= $values["array_fields"];
			$array_values 				= $values["array_values"];
			$pkid  						= $return['pkid'];
			$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
			$return['result'] = $result;
			/* overwrite uploaded file */
			if(file_exists('../uploaded_file/temp/qcfr/'.$filename)){
				$file_path 	= return_file_path_by_div_mod('qcfr');
				$ext 		= pathinfo('../uploaded_file/temp/qcfr/'.$filename, PATHINFO_EXTENSION);
				rename('../uploaded_file/temp/qcfr/'.$filename, $file_path['path'].$return['pkid'].'.'.$ext);
				$return['file_moved'] = $file_path['path'].$return['pkid'].'.'.$ext;
			}else{
				$return['file_moved']   = false;
				$return['error'] 		= "Something went wrong during file upload, please re-upload the file.";
			}
		}
		echo json_encode($return);
	}
	
	function qcfr_ctrl_no_exist($pkid,$qcfr_no){
		require_once('../class/oop_tqts.php');
		$array_fields	= array('qcfr_no');
		$table			= 'tbl_qfr_qcfr';
		$joins			= '';
		$sql_where		= 'WHERE `qcfr_no` = "'.$qcfr_no.'" AND `pkid` != "'.$pkid.'" AND `logdel` = "0"';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 0,1';
		$result 		= TQTS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$exist 			= false;
		while($row = mysqli_fetch_assoc($result)){
			$exist = true;
		}		
		return $exist;
	}
	
	function cancel_qcfr(){
		require_once('../class/oop_tqts.php');
		$return 					= $_POST;
		/* Update the current data */
		$table  					= 'tbl_qfr_qcfr';
		$array_fields 				= array('logdel');
		$array_values 				= array('1');
		$pkid  						= $return['pkid'];
		$result = TQTS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return['result']			= $result;
		echo json_encode($return);
	}
	/* QCFR End */
?>