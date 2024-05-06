<?php

$admin_access = false;
$user_at_access 	    	= array("create" => false, 
									"read" => false,
									"update" => false,
									"delete" => false
									);
foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
	
	if ($subsystem_code =="QFR" && $user_role['module'][$key] == "Attention Tag"){
		if($user_role['create'][$key]==1){
			$user_at_access['create']=true;
		}
	}
}
?>
<div class="col-sm-12">
	<div class="panel panel-default">
			<div class="panel-heading" style=""><i class="fa fa-file fa-lg"> Attention Tag</i></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<button type="button" class="btn btn-default fa" id="btn_at_search_main"><i class="fa fa-search"></i> Search</button>
					</div>
					<div class="col-sm-6">
						<?php 
						if($user_at_access['create']){
						echo 
						'<button type="button" class="btn btn-primary fa fa-plus pull-right" id="btn_attention_tag_new"> 
							New Attention Tag
						</button>
						';
						}
						?>
						<br /><br />
						<!-- <button type="button" class="btn btn-success fa fa-file-excel-o pull-right" id="btn_export_attention_tag_summary"> 
							Report
						</button><br /><br /> -->
					</div>
				</div>
				<table class="table table-condensed table-striped table-bordered" id="tbl_attention_tag"> 
					<thead>
						<tr>
							<th>Status</th>
							<th>Control #</th>
							<th>Date</th>
							<th style="width:10%">Category</th>
							<th style="width:20%">Product and Model Details</th>
							<th>Issued By</th>
							<th>Description</th>
							<th>Download</th>
							<th><span class="fa fa-cogs"></span></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table> 
			</div>
		</div>
	</div>
</div>

<!-- Modal - AddAttentionTag -->
<div class="modal fade" tabindex="-1" id="modal_add_attention_tag" role="dialog" >
    <div class="modal-dialog modal-lg" role = "document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Attention Tag</h4>
        </div>
		<form id= "form_add_attention_tag" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="rdo_1" value="Material">
								<label for="rdo_1"> Material</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="rdo_2" value="Workmanship">
								<label for="rdo_2"> Workmanship</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="rdo_3" value="Machine">
								<label for="rdo_3"> Machine</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="rdo_4" value="Others">
								<label for="rdo_4"> Others</label>
							</div>
						</div>
					</div>
					<div class="col-sm-2"> 
						<label for="">Control No:</label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="text" id="control_number" name="control_number" required>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-2"> 
						<label for="">Choose File: </label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="file" id="selected_file" name="selected_file" accept ="application/pdf" required> 
					</div>
					<div class="col-sm-2"> 
						<label for="">Date: </label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="date" id="date" name="date" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3"> 
						<input type="radio" name="radio_type_search" id="radio_parts" value ="Parts" required> Part Code 
						<input type="radio" name="radio_type_search" id="radio_po"  value="PO" required> PO No. 
					</div>
					<div class="col-sm-3">
						<datalist id="list_at_po"></datalist>
						<input  class="form-control" type="text" id="part_po" name="part_po" list = "list_at_po">
					</div>
					<div class="col-sm-2"> 
							<label for="">Issuance By:</label> 
						</div>
						<div class="col-sm-4" >
							<select class="form-control" name="issuance_by" id="issuance_by" style = "width:100%;" required>
							</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2"> 
						<label for="">Product:</label> 
					</div>
					<div class="col-sm-4" >
						<input class="form-control" type="text" id="product" name="product"required>
					</div>
					<div class="col-sm-2" style ="padding-top:5px;"> 
						<label for="">Lot No:</label> 
					</div>
					<div class="col-sm-4" style ="padding-top:5px;">
						<input class="form-control" type="text" id="lot_no" name="lot_no"required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
					<label>Model</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="model"required>
					</div>
					<div class="col-sm-2"> 
						<label for="">Quantity:</label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="number" id="quantity" name="quantity"required>
					</div>
				</div>
				<hr class="graph-blue"> 
				<div class="row">
					<div class="col-sm-12">
						<label class="fa condensed">DESCRIPTION</label>
						<textarea class="form-control" name="description" required></textarea>
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-12">
						<label class="fa condensed">REMARKS</label>
						<textarea class="form-control" name="remarks" required></textarea>
					</div>
				</div>	
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
				<button type="button" class="btn btn-default  fa fa-close" data-dismiss="modal"> Close</button>
			</div>
		</form>
      </div>
    </div> <!-- End Content -->
</div> <!-- End Modal -->

<!-- Modal - View-AttentionTag -->
<div class="modal fade" tabindex="-1" id="modal_view_attention_tag" role="dialog">
    <div class="modal-dialog modal-lg" role = "document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Attention Tag</h4>
        </div>
		<form id= "form_view_attention_tag" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-2">
						<input class="form-control" type="hidden" id= "pkid" name="pkid" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="radio1" value="Material"/>
								<label for="radio1">Material</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="radio2" value="Workmanship"/>
								<label for="radio2">Workmanship</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="radio3" value="Machine"/>
								<label for="radio3">Machine</label>
							</div>
							<div class="funkyradio-primary">
								<input type="radio" name="category" id="radio4" value="Others"/>
								<label for="radio4">Others</label>
							</div>
						</div>
					</div>
					<div class="col-sm-2"> 
						<label for="">Control No:</label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="text" id="control_number" name="control_number" required>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-2"> 
						<input type='checkbox' id="file_chkbox"> Choose File: </input> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="file" id="selected_file" name="selected_file"  accept="application/pdf"> 
						 <h5><a href="#" class="fa fa-file-pdf-o" id="btn_selected_file"><u> Download PDF File</u></a></h5>
						 <input class="form-control" type="input" id="input_file_name" name="input_file_name" style = "display:none">
					</div>
					<div class="col-sm-2"> 
						<label for="">Date: </label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="date" id="date" name="date" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3"> 
						<input type = "radio" name="radio_type_search" id="radio_parts" value ="Parts" required> Part Code 
						<input type = "radio" name="radio_type_search" id="radio_po"  value ="PO" required> PO No. 
					</div>
					<div class="col-sm-3">
						<datalist id="list_at_po"></datalist>
						<input  class="form-control" type="text" id="part_po" name="part_po" list = "list_at_po" required>
					</div>
					<div class="col-sm-2"> 
							<label for="">Issuance By:</label> 
						</div>
						<div class="col-sm-4" >
							<select class="form-control" name="issuance_by" id="issuance_by" style = "width:100%;" required>
							</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2"> 
						<label for="">Product:</label> 
					</div>
					<div class="col-sm-4" >
						<input class="form-control" type="text" id="product" name="product">
					</div>
					<div class="col-sm-2" style ="padding-top:5px;"> 
						<label for="">Lot No:</label> 
					</div>
					<div class="col-sm-4" style ="padding-top:5px;">
						<input class="form-control" type="text" id="lot_no" name="lot_no" required>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
					<label>Model</label>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="model">
					</div>
					<div class="col-sm-2"> 
						<label for="">Quantity:</label> 
					</div>
					<div class="col-sm-4">
						<input class="form-control" type="number" id="quantity" name="quantity" required>
					</div>
				</div>
				<hr class="graph-blue"> 
				<div class="row">
					<div class="col-sm-12">
						<label class="fa condensed">DESCRIPTION</label>
						<textarea class="form-control" name="description" required></textarea>
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-12">
						<label class="fa condensed">REMARKS</label>
						<textarea class="form-control" name="remarks" required></textarea>
					</div>
				</div>	
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary fa fa-save" id="btn_save"> Save</button>
				<button type="button" class="btn btn-default  fa fa-close" data-dismiss="modal"> Close</button>
			</div>
		</form>
      </div>
    </div> <!-- End Content -->
</div> <!-- End Modal -->

<!-- Modal - View-AttentionTag -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_at_cancel">
  <div class="modal-dialog modal-md" role="document">
	  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="fa fa-remove"></span> Cancel Report</h4>
      </div>
      <div class="modal-body">
        <form id="form_at_cancel">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label">Are you sure you want to cancel </label>
					<label id="label_info"></label>
				</div>
				<div class="col-sm-12">
					<input type="text" name="pkid" style="display:none;">
					<textarea type="text" class="form-control condensed" name="cancel_remarks" placeholder="Please state your reason for cancellation" required></textarea>
				</div>
			</div>
      </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-danger"> Confirm</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
