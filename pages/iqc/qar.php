<?php
/* get user role - requestor */
$user_iqc_qar_requestor_access 	    = array("create" => false, 
											"read" => false,
											"update" => false,
											"delete" => false,
											"section" => ""
											);
$subsystem_code 			= "IQC";
$module 					= "Quality Alert Report (QAR) - Requestor";
foreach($user_role['subsystem_code'] as $key => $subsystem_code_value ){
	if($subsystem_code == $subsystem_code_value && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$user_iqc_qar_requestor_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$user_iqc_qar_requestor_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$user_iqc_qar_requestor_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$user_iqc_qar_requestor_access['delete'] = true;
		}
		$user_iqc_qar_requestor_access['section'] = $user_role['section'][$key];
	}
}
echo '<input type="hidden" id="txt_iqc_qar_requestor_section" value="'.$user_iqc_qar_requestor_access['section'].'">'; 
/* get user role - Conformance */
$user_iqc_qar_conformance_access 	    = array("create" => false, 
											"read" => false,
											"update" => false,
											"delete" => false
											);
$subsystem_code 			= "IQC";
$module 					= "Quality Alert Report (QAR) - Conformance";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$user_iqc_qar_conformance_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$user_iqc_qar_conformance_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$user_iqc_qar_conformance_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$user_iqc_qar_conformance_access['delete'] = true;
		}
	}
}
/* get user role - Recipient */
$user_iqc_qar_recipient_access 	    = array("create" => false, 
												"read" => false,
												"update" => false,
												"delete" => false
												);
$subsystem_code 			= "IQC";
$module 					= "Quality Alert Report (QAR) - Recipient";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$user_iqc_qar_recipient_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$user_iqc_qar_recipient_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$user_iqc_qar_recipient_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$user_iqc_qar_recipient_access['delete'] = true;
		}
	}
}
?>
<div class="col-sm-12">
	<div>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php
				$class_active = "active";
				if($user_iqc_qar_requestor_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#requestor" aria-controls="requestor" role="tab" data-toggle="tab">Requestor Page</a></li>';
					$class_active = '';
				}
				if($user_iqc_qar_conformance_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#conformance" aria-controls="conformance" role="tab" data-toggle="tab">Conformance Page</a></li>';
					$class_active = '';
				}
				if($user_iqc_qar_recipient_access['read']){
					echo '<li role="presentation" class="'.$class_active.'"><a href="#recipient" aria-controls="recipient" role="tab" data-toggle="tab">Recipient Page</a></li>';
					$class_active = '';
				}
			?>	
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php
				$class_active = "active";
				if($user_iqc_qar_requestor_access['read']){
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="requestor">
							<!------------------------------
								Requestror Page - Start
							------------------------------->
							<div class="panel panel-info">
								<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Quality Alert Report</i></div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-6">
											<button class="btn btn-default fa" id="btn_dir_search_main"><i class="fa fa-search"></i> Search</button>
										</div>
										<div class="col-sm-6">';
										if($user_iqc_qar_requestor_access['create']){
											echo '<button class="btn btn-primary fa pull-right" id="btn_new_iqc_qar"><i class="fa fa-plus"></i> Create New</button>';
										}
					echo	'			</div>
									</div>
									<div class="row">
										<div class="col-sm-12"><br />
											<table class="table table-striped table-bordered table-condensed" id="tbl_iqc_qar_requestor">
												<thead>
													<tr>
														<th>Status</th>
														<th>Control #</th>
														<th>Part Code</th>
														<th>Part Name</th>
														<th>Model</th>
														<th>Mode of Defect</th>
														<th>Location of Defects</th>
														<th>Lot Name</th>
														<th>Lot Qty</th>
														<th>Checked Qty</th>
														<th>NG Qty</th>
														<th>NG Rate</th>
														<th><span class="fa fa-cogs"></span></th>
													</tr>
												</thead>
												<tbody></tbody>						
											</table>
										</div>
									</div>
								</div>
							</div>
							<!------------------------------
								Requestror Page - End
							------------------------------->
						</div>';
					$class_active = '';
				}			
				if ($user_iqc_qar_conformance_access['read']){
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="conformance">
							<!------------------------------
								Approver Page - Start
							------------------------------->
							<div class="panel panel-info">
								<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Quality Alert Report</i></div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12"><br />
											<table class="table table-striped table-bordered table-condensed" id="tbl_iqc_qar_conformance">
												<thead>
													<tr>
														<th>Status</th>
														<th>Control #</th>
														<th>Part Code</th>
														<th>Part Name</th>
														<th>Model</th>
														<th>Mode of Defect</th>
														<th>Location of Defects</th>
														<th>Lot Name</th>
														<th>Lot Qty</th>
														<th>Checked Qty</th>
														<th>NG Qty</th>
														<th>NG Rate</th>
														<th><span class="fa fa-cogs"></span></th>
													</tr>
												</thead>
												<tbody></tbody>						
											</table>
										</div>
									</div>
								</div>
							</div>
							<!------------------------------
								Approver Page - End
							------------------------------->
						</div>';
					$class_active = '';
				}			
				
				if ($user_iqc_qar_recipient_access['read']){
					echo '<div role="tabpanel" class="tab-pane '.$class_active.'" id="recipient">
							<!------------------------------
								Recipient Page - Start
							------------------------------->
							<div class="panel panel-info">
								<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Quality Alert Report</i></div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12"><br />
											<table class="table table-striped table-bordered table-condensed" id="tbl_iqc_qar_recipient">
												<thead>
													<tr>
														<th>Status</th>
														<th>Control #</th>
														<th>Part Code</th>
														<th>Part Name</th>
														<th>Model</th>
														<th>Mode of Defect</th>
														<th>Location of Defects</th>
														<th>Lot Name</th>
														<th>Lot Qty</th>
														<th>Checked Qty</th>
														<th>NG Qty</th>
														<th>NG Rate</th>
														<th><span class="fa fa-cogs"></span></th>
													</tr>
												</thead>
												<tbody></tbody>						
											</table>
										</div>
									</div>
								</div>
							</div>
							<!------------------------------
								Conformance Page - End
							------------------------------->
						</div>';
					$class_active = '';
				}
			?>
		</div>

	</div>
	
</div>

<!---------------------
	Modals - Start 
---------------------->
<div class="modal fade"  tabindex="-1" role="dialog" id="modal_iqc_qar_view">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report <span class="badge highlight-color-red" id="span_disposition_text"> </span></h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_view">
			<div class="profile-info-title h4" >
                <span class="fa fa-users"></span> Recipient
            </div>
            <hr class="graph-orange" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">To: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_to" name="to" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Attn: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">CC: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">QC Supervisor: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_qc_supervisor" name="qc_supervisor[]" multiple="multiple" style="width:100%;" required></select>
                </div>
            </div>
            <div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Details
            </div>
            <hr class="graph-blue" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Date Issued: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="date" class="form-control" id="txt_date_issued" list="" name="date_issued" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partcode: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partcode" list="" name="part_code" required>
                </div>                
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Model: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_model" name="model" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partname: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partname" list="" name="part_name" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_mode_of_defect">Mode of Defect</button>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_lot"> Add Lot Number</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <div class="col-sm-2">
                    <label class="fa fa-md">Checked Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_checked_qty" name="checked_qty" required>
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">NG Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_qty" list="" name="ng_qty" required>
                </div>
            </div>
             <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">NG Rate: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_rate" name="ng_rate" step=".01" required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Product Code: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="prod_code" name="prod_code" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">OK Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ok_condition" name="ok_condition_text" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">NG Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ng_condition" name="ng_condition_text" required>
                </div>
            </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [OK]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ok" height="200px;" style="overflow:auto;">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [NG]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ng" height="200px;" style="overflow:auto;"> 
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload Reference File: </label>
                </div>
				<div class="col-sm-4">
					<a href="#" id="a_reference_file">Sample File</a>
                </div>
			</div>
			<div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Disposition 
            </div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
                <div class="col-sm-3">
                    <label class="fa fa-md">QAR Excel Attachment: </label>
                </div>
                <div class="col-sm-5">
					<button type="button" class="btn btn-default fa fa-file-excel-o" id="btn_download_qar_excel_attachment"> Download Excel File</button><br />
					
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <!--<button type="submit" class="btn btn-primary fa fa-save"> Save</button>-->
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade"  tabindex="-1" role="dialog" id="modal_iqc_qar_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report <span class="badge highlight-color-red" id="span_disposition_text"> </span></h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_edit">
			<div class="profile-info-title h4" >
                <span class="fa fa-users"></span> Recipient
            </div>
            <hr class="graph-orange" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">To: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_to" name="to" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Attn: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">CC: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">QC Supervisor: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_qc_supervisor" name="qc_supervisor[]" multiple="multiple" style="width:100%;" required></select>
                </div>
            </div>
            <div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Details
            </div>
            <hr class="graph-blue" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Date Issued: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="date" class="form-control" id="txt_date_issued" list="" name="date_issued" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partcode: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partcode" list="" name="part_code" required>
                </div>                
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Model: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_model" name="model" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partname: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partname" list="" name="part_name" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_mode_of_defect">Mode of Defect</button>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_lot"> Add Lot Number</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <div class="col-sm-2">
                    <label class="fa fa-md">Checked Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_checked_qty" name="checked_qty" required>
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">NG Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_qty" list="" name="ng_qty" required>
                </div>
            </div>
             <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">NG Rate: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_rate" name="ng_rate" step=".01" required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Product Code: </label>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" id="prod_code" name="prod_code" required></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">OK Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ok_condition" name="ok_condition_text" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">NG Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ng_condition" name="ng_condition_text" required>
                </div>
            </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [OK]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ok" height="200px;" style="overflow:auto;">
					<input type="file" class="form-control" name="ok_condition_files" accept="image/x-png,image/gif,image/jpeg">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [NG]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ng" height="200px;" style="overflow:auto;"> 
					<input type="file" class="form-control" name="ng_condition_files" accept="image/x-png,image/gif,image/jpeg">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload Reference: </label>
                </div>
				<div class="col-sm-4">
					<a href="#" id="a_reference_file">Sample File</a>
					<input type="file" class="form-control" name="reference_files">
                </div>				
			</div>
			<div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Disposition 
            </div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
                <div class="col-sm-3">
                    <label class="fa fa-md">QAR Excel Attachment: </label>
                </div>
                <div class="col-sm-5">
					<button type="button" class="btn btn-default fa fa-file-excel-o" id="btn_download_qar_excel_attachment"> Download Excel File</button><br />
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_file_upload_ng_condition_view" style="z-index:1051">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-image"></i> Upload Files</h4>
      </div>
	  <div class="modal-body">
			<form id="frm_iqc_qar_new_file_upload_ng_condition_view">
				<div class="row" style="margin-top:5px;" id="div_add_lot">
					 <div class="col-sm-3">
						<label class="fa fa-md">Image Upload: </label>
					</div>
					<div class="col-sm-7">
						<input type="file" class="form-control" id="file_image_uploads" name="image_uploads[]" multiple required>
					</div>
					<div class="col-sm-2">
						<button type="submit" class="btn btn-primary fa fa-save pull-right" id="btn_add_file"> Add File</button>
					</div>
				</div>
			</form>
			<form id="ng_condition_files">
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12">
						<table class="table table-bordered table-striped table-condensed" id="tbl_iqc_qar_file_uploaded" style="font-size:12px;">
							<thead>
								<tr>
									<th>Filename</th>
									<th>Image</th>
									<th style="width:5%;"><span class="fa fa-cogs"></span></th>
								</tr>                            
								<tbody>
								</tbody>
							</thead>
						</table>
					</div>
				</div>
      </div>
      <div class="modal-footer">
				<!--<button type="submit" class="btn btn-primary fa fa-save"> Save</button>-->
				<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
			</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_conformance">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report <span class="badge highlight-color-red" id="span_disposition_text"> </span></h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_conformance">
            <div class="profile-info-title h4" >
                <span class="fa fa-users"></span> Recipient
            </div>
            <hr class="graph-orange" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">To: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_to" name="to" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Attn: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">CC: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">QC Supervisor: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_qc_supervisor" name="qc_supervisor[]" multiple="multiple" style="width:100%;" required></select>
                </div>
            </div>
            <div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Details
            </div>
            <hr class="graph-blue" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Date Issued: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_issued" list="" name="date_issued" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partcode: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partcode" list="" name="part_code" required>
                </div>                
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Model: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_model" name="model" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partname: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partname" list="" name="part_name" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_mode_of_defect">Mode of Defect</button>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_lot"> Add Lot Number</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <div class="col-sm-2">
                    <label class="fa fa-md">Checked Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_checked_qty" name="checked_qty" required>
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">NG Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_qty" list="" name="ng_qty" required>
                </div>
            </div>
             <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">NG Rate: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_rate" name="ng_rate" step=".01" required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Product Code: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="prod_code" name="prod_code" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">OK Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ok_condition" name="ok_condition_text" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">NG Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ng_condition" name="ng_condition_text" required>
                </div>
            </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [OK]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ok" height="200px;" style="overflow:auto;">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [NG]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ng" height="200px;" style="overflow:auto;"> 
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload Reference File: </label>
                </div>
				<div class="col-sm-4">
					<a href="#" id="a_reference_file">Sample File</a>
                </div>				
			</div>
			<div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Disposition 
            </div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
                <div class="col-sm-3">
                    <label class="fa fa-md">QAR Excel Attachment: </label>
                </div>
                <div class="col-sm-5">
                    <button type="button" class="btn btn-default fa fa-file-excel-o" id="btn_download_qar_excel_attachment"> Download Excel File</button>
                </div>
			</div>
			<div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Date Required Reply 
            </div>
			<hr class="graph-blue" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Date Required Reply: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="date" class="form-control" id="txt_disposition_required_date_reply" min="<?php echo date('Y-m-d') ?>" name="disposition_required_date_reply" required>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <?php
			if($user_iqc_qar_conformance_access['update']){
				echo '<button type="button" class="btn btn-success fa fa-check-circle" id="btn_close"> Accept Disposition and Close</button>';
				echo '<button type="button" class="btn btn-success fa fa-check-circle" id="btn_conform"> Conform & Send</button>';
			}
			if($user_iqc_qar_conformance_access['update']){
				echo '<button type="button" class="btn btn-danger fa fa-share-square" id="btn_return"> Return For Disposition</button>';
				echo '<button type="button" class="btn btn-danger fa fa-remove" id="btn_reject"> Reject</button>';
			}
		?>
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_recipient">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report <span class="badge highlight-color-red" id="span_disposition_text"> </span></h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_recipient">
            <div class="profile-info-title h4" >
                <span class="fa fa-users"></span> Recipient
            </div>
            <hr class="graph-orange" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">To: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_to" name="to" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Attn: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">CC: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">QC Supervisor: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_qc_supervisor" name="qc_supervisor[]" multiple="multiple" style="width:100%;" required></select>
                </div>
            </div>
            <div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Details
            </div>
            <hr class="graph-blue" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Date: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_issued" list="" name="date_issued" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partcode: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partcode" list="" name="part_code" required>
                </div>                
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Model: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_model" name="model" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partname: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partname" list="" name="part_name" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_mode_of_defect">Mode of Defect</button>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_lot"> Add Lot Number</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <div class="col-sm-2">
                    <label class="fa fa-md">Checked Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_checked_qty" name="checked_qty" required>
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">NG Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_qty" list="" name="ng_qty" required>
                </div>
            </div>
             <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">NG Rate: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_rate" name="ng_rate" step=".01" required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Product Code: </label>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" id="prod_code" name="prod_code" required></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">OK Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ok_condition" name="ok_condition_text" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">NG Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ng_condition" name="ng_condition_text" required>
                </div>
            </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [OK]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ok" height="200px;" style="overflow:auto;">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [NG]: </label>
                </div>
				<div class="col-sm-4">
					<img src="" id="img_ng" height="200px;" style="overflow:auto;"> 
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload Reference File: </label>
                </div>
				<div class="col-sm-4">
					<a href="#" id="a_reference_file">Sample File</a>
                </div>					
			</div>
			<div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Disposition
            </div>
			<hr class="graph-orange" style="margin-top:0px;">
			<div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">QAR Excel Attachment: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-file-excel-o" id="btn_download_qar_excel_attachment"> Download Excel File</button>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload Excel Attachment with Disposition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="file" class="form-control" name="file_excel_with_disposition" required>
                </div>
			</div>
      </div>
      <div class="modal-footer">
         <?php
			if($user_iqc_qar_recipient_access['update']){
				echo '<button type="submit" class="btn btn-success fa fa-check-circle" id="btn_submit"> Submit</button>';
				//echo '<button type="button" class="btn btn-danger fa fa-remove" id="btn_invalid"> Invalid QAR</button>';
			}
		 ?>		
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_new">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report</h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_new">
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">To: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_to" name="to" style="width:100%;" required></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Attn: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;" required></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">CC: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">QC Supervisor: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_qc_supervisor" name="qc_supervisor[]" multiple="multiple" style="width:100%;" required></select>
                </div>
            </div>
            <div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Details
            </div>
            <hr class="graph-blue" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Date: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="date" class="form-control" id="date_issued" max="<?php echo date('Y-m-d'); ?>" list="" name="date_issued" required>
                </div>
				<datalist id="list_partcode_qar"></datalist>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partcode: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partcode" list="list_partcode_qar" name="part_code" required>
                </div>                
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Model: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_model" name="model" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Partname: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partname" list="" name="part_name" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_mode_of_defect"> Mode of Defect</button>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default fa fa-plus" id="btn_add_lot"> Add Lot Number</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Checked Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_checked_qty" name="checked_qty" required>
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">NG Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_qty" list="" name="ng_qty" required>
                </div>
            </div>
             <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">NG Rate: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_rate" name="ng_rate" step=".01" readonly required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Product Code: </label>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" id="prod_code" name="prod_code" required></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">OK Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ok_condition" name="ok_condition_text" required>
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">NG Condition: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_ng_condition" name="ng_condition_text" required>
                </div>
            </div>
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [OK]: </label>
                </div>
				<div class="col-sm-4">
                   <input type="file" class="form-control" name="ok_condition_files" accept="image/x-png,image/gif,image/jpeg">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [NG]: </label>
                </div>
				<div class="col-sm-4">
                    <input type="file" class="form-control" name="ng_condition_files" accept="image/x-png,image/gif,image/jpeg">
                </div>
				<div class="col-sm-2">
                    <label class="fa fa-md">Upload File [Reference Document]: </label>
                </div>
				<div class="col-sm-4">
                    <input type="file" class="form-control" name="reference_files">
                </div>				
			</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_cancel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report</h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_cancel">
            <div class="profile-info-title h4" >
                <span class="fa fa-users"></span> Recipient
            </div>
            <hr class="graph-orange" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">To: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_to" name="to" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Attn: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
				<div class="col-sm-2">
                    <label class="fa fa-md">CC: </label>
                </div>
                <div class="col-sm-10">
                    <select class="" id="cmb_cc" name="cc[]" multiple="multiple" style="width:100%;"></select>
                </div>
            </div>
            <div class="profile-info-title h4" >
                <span class="fa fa-exclamation-circle"></span> Details
            </div>
            <hr class="graph-blue" style="margin-top:0px;">
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Partcode: </label>
                </div>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partcode" list="" name="part_code" required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Partname: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_partname" list="" name="part_name" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Model: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_model" name="model" required>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" id="btn_add_mode_of_defect">Mode of Defect</button>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot: </label>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" id="btn_add_lot"> Add Lot Number</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <div class="col-sm-2">
                    <label class="fa fa-md">Checked Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_checked_qty" name="checked_qty" required>
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">NG Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_qty" list="" name="ng_qty" required>
                </div>
            </div>
             <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">NG Rate: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_ng_rate" name="ng_rate" step=".01" required>
                </div>
                <div class="col-sm-2">
                    <label class="fa fa-md">Product Code: </label>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" id="prod_code" name="prod_code" required></select>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Attachment: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_attachment" name="attachment_text" required>
                    <!--<input type="file" class="form-control" id="file_attachment" name="file_attachment">-->
                </div>                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger fa fa-remove" id="btn_cancel_request"> Cancel Request</button>
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_confirm_cancel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report</h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_confirm_cancel">
             <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Cancellation Remarks: </label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" id="txt_remarks" name="remarks" required></textarea>
                </div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger fa fa-remove" id="btn_confirm_cancel_request"> Cancel Request</button>
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_confirm_invalid">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Quality Alert Report</h4>
      </div>
	  <div class="modal-body">
		 <form id="frm_iqc_qar_confirm_invalid">
             <div class="row" style="margin-top:5px;">
                <div class="col-sm-2">
                    <label class="fa fa-md">Invalid QAR Remarks: </label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" id="txt_remarks" name="remarks" required></textarea>
                </div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger fa fa-remove" id="btn_confirm_invalid"> Cancel Request</button>
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_view_lot" style="z-index:1051">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Lot Number</h4>
      </div>
	  <div class="modal-body">
          <form id="frm_iqc_qar_view_lot">
            <div class="row" style="margin-top:5px;" id="div_add_lot">
                 <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot #: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_lot_no" name="lot_no">
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">Lot Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_lot_qty" list="" name="lot_qty">
                </div>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary fa fa-save pull-right" id="btn_add_lot"> Add Lot</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped table-condensed" id="tbl_iqc_qar_lot_number" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Lot No.</th>
                                <th>Lot Qty</th>
                                <th style="width:5%;"><span class="fa fa-cogs"></span></th>
                            </tr>                            
                            <tbody>
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <!--<button type="submit" class="btn btn-primary fa fa-save"> Save</button>-->
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_view_mode_of_defect" style="z-index:1051">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Mode of Defect</h4>
      </div>
	  <div class="modal-body">
          <form id="frm_iqc_qar_view_mode_of_defect">
            <div class="row" style="margin-top:5px;" id="div_add_mode_of_defect">
                 <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_mode_of_defect" name="mode_of_defect">
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">Location of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_location_of_defect" list="" name="location_of_defect">
                </div>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary fa fa-save pull-right" id="btn_add_mode_of_defect"> Add Mode of Defect</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped table-condensed" id="tbl_iqc_qar_mode_of_defect" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Mode of Defect</th>
                                <th>Location of Defect</th>
                                <th style="width:5%;"><span class="fa fa-cogs"></span></th>
                            </tr>                            
                            <tbody>
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <!--<button type="submit" class="btn btn-primary fa fa-save"> Save</button>-->
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_new_lot" style="z-index:1051">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Lot Number</h4>
      </div>
	  <div class="modal-body">
          <form id="frm_iqc_qar_new_lot">
            <div class="row" style="margin-top:5px;">
                 <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Lot #: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_lot_no" name="lot_no">
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">Lot Qty: </label>
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="txt_lot_qty" list="" name="lot_qty">
                </div>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary fa fa-save pull-right" id="btn_add_lot"> Add Lot</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped table-condensed" id="tbl_iqc_qar_lot_number" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Lot No.</th>
                                <th>Lot Qty</th>
                                <th style="width:5%;"><span class="fa fa-cogs"></span></th>
                            </tr>                            
                            <tbody>
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <!--<button type="submit" class="btn btn-primary fa fa-save"> Save</button>-->
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_iqc_qar_mode_of_defect" style="z-index:1051">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Mode of Defect</h4>
      </div>
	  <div class="modal-body">
          <form id="frm_iqc_qar_mode_of_defect">
            <div class="row" style="margin-top:5px;">
                 <!-- Datalist -->
                <datalist id=""></datalist>
                <div class="col-sm-2">
                    <label class="fa fa-md">Mode of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_mode_of_defect" name="mode_of_defect">
                </div>
                 <div class="col-sm-2">
                    <label class="fa fa-md">Location of Defect: </label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="txt_location_of_defect" list="" name="location_of_defect">
                </div>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary fa fa-save pull-right" id="btn_add_mode_of_defect"> Add Mode of Defect</button>
                </div>
            </div>
            <div class="row" style="margin-top:5px;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped table-condensed" id="tbl_iqc_qar_mode_of_defect" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>Mode of Defect</th>
                                <th>Location of Defect</th>
                                <th style="width:5%;"><span class="fa fa-cogs"></span></th>
                            </tr>                            
                            <tbody>
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <!--<button type="submit" class="btn btn-primary fa fa-save"> Save</button>-->
        <button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
      </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal" tabindex="-1" role="dialog" id="modal_iqc_qar_system_message" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> System Message</h4>
      </div>
      <div class="modal-body">
		<div class="" id="div_system_message"></div>
      </div>
      <div class="modal-footer">
        <div id="div_countdown"></div>
		<!--<button type="submit" class="btn btn-primary fa fa-search"> Search</button>-->
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_iqc_qar_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_iqc_qar_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_iqc_qar_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_iqc_qar_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_iqc_qar_advance_search">
			<tbody>
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary fa fa-search"> Search</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="js/iqc/qar.js?2" type="text/javascript"></script>