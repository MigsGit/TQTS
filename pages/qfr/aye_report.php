<?php
/* Check if user access */
$qfr_aye_requestor_access 	    = array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
$subsystem_code 			= "QFR";
$module 					= "AYE Report";
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	if($subsystem_code == $subsystem_code && $user_role['module'][$key] == $module){ 
		if ($user_role['create'][$key] == 1){
			$qfr_aye_requestor_access['create'] = true;
		}
		if ($user_role['read'][$key] == 1){
			$qfr_aye_requestor_access['read'] = true;
		}
		if ($user_role['update'][$key] == 1){
			$qfr_aye_requestor_access['update'] = true;
		}
		if ($user_role['delete'][$key] == 1){
			$qfr_aye_requestor_access['delete'] = true;
		}
	}
}
?>

<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-file fa-lg"> AYE Report</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-9">
					<button class="btn btn-default fa fa-search" id="btn_aye_advanced_search"> Search</button>
				</div>
				<div class="col-sm-3">
					<?php 
						if($qfr_aye_requestor_access['create']) {
							echo '<button class="btn btn-primary fa fa-plus pull-right" id="btn_aye"> New AYE Report</button>';
						}	
					?>
					<button class="btn btn-success fa fa-file-excel-o pull-right" id="btn_report"> Report</button>
				</div>	
			</div><br />
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-condensed table-bordered" id="tbl_aye">
						<thead>
							<tr>
								<th>Control Number</th>
								<th>Date Issued</th>
								<th>Parts and Product Details</th>
								<th>Sample Size</th>
								<th>% NG</th>
								<th>Judgement Information</th>
								<th><span class="fa fa-attachment"></span> File Attachment</th>
								<th><span class="fa fa-cogs"></span></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_aye">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New AYE Report</h4>
      </div>
	  <form id="frm_aye" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_upload_aye_message">					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Control #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_number" name="control_number" readOnly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Issued: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="" name="date_issued" max="<?php echo date('Y-m-d'); ?>" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Category: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="txt_category" name="category" required>
						<option value=""></option>
						<option value="Parts">Parts</option>
						<option value="Device">Device</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Choose Image: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="" name="file_aye" accept="image/jpeg, image/png" required>
				</div>
			</div>
			<div class="row">
				<div id="container_parts">
					<div class="col-sm-2">
						<label class="fa fa-md"><input type="checkbox" id="chk_with_part_code"> Part Code: </label>
					</div>
					<div class="col-sm-4">
						<datalist id="list_aye_part_code"></datalist>
						<input list="list_aye_part_code" type="text" class="form-control" id="partcode" name="partcode" readOnly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Parts Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="partname" name="parts_affected_parts" readOnly>
					</div>
					<!-- <div class="col-sm-2">
						<label class="fa fa-md">Lot Number: </label>
					</div>
					<div class="col-sm-4">
						<select class="chosen-select" multiple id="lot_number_new_aye" name="lot_number_new_aye">
						</select>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control" id="" name="quantity" min="0">
					</div>-->
					<div class="col-sm-2">
						<label class="fa fa-md">Lot Number: </label>
					</div>
					<div class="col-sm-4">
						<button type="button" name="add_lot_number" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Lot Number</button>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Total Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="quantity" min="0" readOnly>
					</div>
				</div>
				<div id="container_device">
					<div class="col-sm-2">
						<label class="fa fa-md">PO #: </label>
					</div>
					<div class="col-sm-4">
						<datalist id="list_aye_po"></datalist>
						<input list="list_aye_po" type="text" class="form-control" id="" name="po_number">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">PO Qty: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="po_qty" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="device_name" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="" name="customer_name">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Shipment Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="" name="shipment_date">
					</div>
				</div>
             </div>
			 <div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="" name="sample_size" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">% NG: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="" name="percent_ng" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" name="remarks"></textarea>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_aye_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-edit"></i> Edit AYE Report</h4>
      </div>
	  <form id="frm_aye_edit" method="post" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" style="display:none;" role="alert" id="container_upload_aye_message">					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Control #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_number" name="control_number" readOnly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Issued: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_issued" name="date_issued" max="<?php echo date('Y-m-d'); ?>" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Category: </label>
				</div>
				<div class="col-sm-4">
					<select class="form-control" id="category" name="category" required>
						<option value=""></option>
						<option value="Parts">Parts</option>
						<option value="Device">Device</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"><input type="checkbox" id="chk_reselect_image"> Re-select Image: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="file_aye" name="" accept="image/jpeg, image/png" style="display:none">
					<a id="illustration_file" target="_blank"></a>
				</div>
			</div>
			<div class="row">
				<div id="container_parts">
					<div class="col-sm-2">
						<label class="fa fa-md"><input type="checkbox" id="chk_with_part_code"> Part Code: </label>
					</div>
					<div class="col-sm-4">
						<datalist id="list_aye_part_code_edit"></datalist>
						<input list="list_aye_part_code_edit" type="text" class="form-control" id="partcode" name="partcode">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Parts Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="parts_affected_parts" name="parts_affected_parts" readOnly>
					</div>
					<!-- <div class="col-sm-2">
						<label class="fa fa-md">Lot Number: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="lot_number" name="lot_number" list="">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="number" class="form-control" id="quantity" name="quantity" min="0">
					</div> -->
					<div class="col-sm-2">
						<label class="fa fa-md">Lot Number: </label>
					</div>
					<div class="col-sm-4">
						<button type="button" name="add_lot_number" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Lot Number</button>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Total Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="quantity" name="quantity" min="0" readOnly>
					</div>
				</div>
				<div id="container_device">
					<div class="col-sm-2">
						<label class="fa fa-md">PO #: </label>
					</div>
					<div class="col-sm-4">
						<datalist id="list_aye_po_edit"></datalist>
						<input list="list_aye_po_edit" type="text" class="form-control" id="po_number" name="po_number">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">PO Qty: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="po_qty" name="po_qty" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="device_name" name="device_name" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="customer_name" name="customer_name">
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Shipment Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="shipment_date" name="shipment_date">
					</div>
				</div>
             </div>
			 <div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="sample_size" name="sample_size" min="0" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">% NG: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="percent_ng" name="percent_ng" required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				</div>
			 </div>
		   </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_aye_add_judgement">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-edit"></i> Add Judgement</h4>
      </div>
		
		  <div class="modal-body">
			<form id="frm_aye_judgement" method="post">
			<div class="row">
				<div class="col-sm-12">
					<label style="font-size:14"><b>AYE Details: </b></label>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Control #: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="control_number" name="control_number" readOnly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Date Issued: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="date_issued" name="date_issued" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Category: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="category" name="category" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md"> Illustration File: </label>
				</div>
				<div class="col-sm-4">
					<a id="illustration_file" target="_blank"></a>
				</div>
			</div>
			<div class="row">
				<div id="container_parts">
					<div class="col-sm-2">
						<label class="fa fa-md">Part Code: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="partcode" name="partcode" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Parts Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="parts_affected_parts" name="parts_affected_parts" readOnly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Lot Number: </label>
					</div>
					<div class="col-sm-4">
						<button type="button" name="add_lot_number" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Lot Number</button>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Total Quantity: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="quantity" name="quantity" min="0" readOnly>
					</div>
				</div>
				<div id="container_device">
					<div class="col-sm-2">
						<label class="fa fa-md">PO #: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="po_number" name="po_number" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">PO Qty: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="po_qty" name="po_qty" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Device Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="device_name" name="device_name" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Customer Name: </label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="customer_name" name="customer_name" readonly>
					</div>
					<div class="col-sm-2">
						<label class="fa fa-md">Shipment Date: </label>
					</div>
					<div class="col-sm-4">
						<input type="date" class="form-control" id="shipment_date" name="shipment_date" readonly>
					</div>
				</div>
             </div>
			 <div class="row">
				<div class="col-sm-2">
					<label class="fa fa-md">Sample Size: </label>
				</div>
				<div class="col-sm-4">
					<input type="number" class="form-control" id="sample_size" name="sample_size" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">% NG: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="percent_ng" name="percent_ng" readonly>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="remarks" name="remarks" readonly></textarea>
				</div>
			 </div>
			 <div class="row">
				<div class="col-sm-12">
					<hr class="graph-green">
				</div>
				<div class="col-sm-12" id="container_aye_judgement_additional_info">	
					<div class="panel-group" id="accordion_judgement" role="tablist" aria-multiselectable="true">
					  <div class="panel panel-default box box-info">
						<div class="panel-heading" role="tab" id="headingOne">
						  <h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion_judgement" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:blue;">
							  <i class="fa fa-lightbulb-o"></i> Additional Information
							</a>
						  </h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						  <div class="panel-body">
							<p style="padding-left:2px;"> 
								*System will read judgement on cells: <br>
									N9  for AYE Judgement<br>
									N10 for Date <br>
									N11 for Remarks 
							</p>
						  </div>						 
						</div>	
					   </div>	
					</div>	
				</div>
				<div class="col-sm-12" id="">	
					<label style="font-size:14"><b>Judgement Details: </b></label>
				</div>
			 </div>
			 </form>
			 <div class="row" id="container_judgment_upload">
			  <form id="frm_aye_upload_judgement" method="post" enctype="multipart/form-data">
				<div class="col-sm-2 col-sm-offset-6">
					<label class="fa fa-md">Upload AYE Report: </label>
				</div>
				<div class="col-sm-4">
					<input type="file" class="form-control" id="judgement_file" name="judgement_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/> 
					<button type="submit" id="btn_submit_aye_judgement" style="display:none;"></button>
				</div>
			  </form>
			 </div>
		
		<form id="frm_aye_add_judgement" method="post">
			 <div class="row" id="container_judgment_details">
				<div class="col-sm-2">
					<label class="fa fa-md">AYE Judgment: </label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="aye_judgement" name="aye_judgement" readonly required>
				</div>
				<div class="col-sm-2">
					<label class="fa fa-md">Judgment Date: </label>
				</div>
				<div class="col-sm-4">
					<input type="date" class="form-control" id="judgement_date" name="judgement_date" readonly required>
				</div>
			 </div>
			 <div class="row" id="container_judgment_details_remarks">	
				<div class="col-sm-2">
					<label class="fa fa-md">Remarks: </label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control" id="judgement_remarks" name="judgement_remarks" readonly></textarea>
				</div>
			 </div>
		   </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save" id="btn_add_judgement"> Save</button>
			<button type="button" class="btn btn-default fa" data-dismiss="modal"> Close</button>
		  </div>
		</form><!-- /#frm_upload_measdata -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- <div class="modal fade" tabindex="-1" role="dialog" id="modal_aye_cancel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-times-circle"></span> Cancel Report</h4>
      </div>
      <div class="modal-body">
        <form id="frm_aye_cancel">
			<label class="control-label">Are you sure you want to cancel the created AYE report?</label>
			<label id="label_info"></label>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-danger fa fa-times-circle"> Cancel Request</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_aye_add_lot_number">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-plus"></i> Add Lot Number</h4>
      </div>		
	  <div class="modal-body">
		<form id="frm_aye_add_lot_number" method="post">
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-success" style="" role="alert" id="">					
					<b>Click the "SAVE" button to record the selected Lot Number/s</b>				
				</div>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Lot Number: </label>
			</div>
			<div class="col-sm-4">
				<datalist id="list_aye_lot_number_add"></datalist>
				<input type="text" class="form-control" list="list_aye_lot_number_add" id="lot_number" name="lot_number" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Quantity: </label>
			</div>
			<div class="col-sm-4">
				<input type="number" class="form-control" id="quantity" name="quantity" min=0 required>
			</div>
			<div class="col-sm-4 col-sm-offset-8">
				<button type="submit" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Add Lot Number</button>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-bordered table-condensed" id="tbl_lot_details" style="width:100%;">
					<thead>
						<th style="width:45%">Lot Number</th>
						<th style="width:45%">Quantity</th>
						<th style="width:10%">Remove</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	  </div>	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary fa fa-save" id="btn_save_aye_lot_number_details"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_aye_edit_lot_number">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-plus"></i> View / Edit Lot Number</h4>
      </div>		
	  <div class="modal-body">
		<form id="frm_aye_edit_lot_number" method="post">
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-success" style="" role="alert" id="">					
					<b>Click the "SAVE" button to record the selected Lot Number/s</b>				
				</div>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Lot Number: </label>
			</div>
			<div class="col-sm-4">
				<datalist id="list_aye_lot_number_edit"></datalist>
				<input type="text" class="form-control" list="list_aye_lot_number_edit" id="lot_number" name="lot_number" required>
			</div>
			<div class="col-sm-2">
				<label class="fa fa-md">Quantity: </label>
			</div>
			<div class="col-sm-4">
				<input type="number" class="form-control" id="quantity" name="quantity" min=0 required>
			</div>
			<div class="col-sm-4 col-sm-offset-8">
				<button type="submit" class="btn btn-primary fa fa-plus" style="width:100%; margin-bottom:2%"> Add Lot Number</button>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-bordered table-condensed" id="tbl_lot_details" style="width:100%;">
					<thead>
						<th style="width:45%">Lot Number</th>
						<th style="width:45%">Quantity</th>
						<th style="width:10%">Remove</th>
						<th style="display:none">pkid</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	  </div>	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary fa fa-save" id="btn_update_lot_number_details"> Save</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_aye_view_lot_number">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><i class="fa fa-eye"></i> View Lot Number</h4>
      </div>		
	  <div class="modal-body">
		<form id="frm_aye_view_lot_number" method="post">
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-bordered table-condensed" id="tbl_lot_details" style="width:100%;">
					<thead>
						<th style="width:45%">Lot Number</th>
						<th style="width:45%">Quantity</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	  </div>	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_aye_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_aye_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_aye_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_aye_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_aye_advance_search">
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