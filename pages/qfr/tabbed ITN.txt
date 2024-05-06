<div>
  <div class="col-sm-12">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#itn_itn" aria-controls="itn_itn" role="tab" data-toggle="tab">ITN</a></li>
		<li role="presentation"><a href="#itn_qcfr" aria-controls="itn_qcfr" role="tab" data-toggle="tab">QCFR</a></li>
		<?php
			/* Check if there is a read role on one Attenton Tag Report */
			$user_qfr_at_read_access = false;
			foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
				if($subsystem_code == "QFR" && $user_role['module'][$key] == "Attention Tag" && $user_role['read'][$key] == 1){ 
					$user_qfr_at_read_access = true;
				}
			}
			if( $user_qfr_at_read_access ){
				echo '<li role="presentation"><a href="#itn_attention_tag" aria-controls="itn_attention_tag" role="tab" data-toggle="tab">Attention Tag</a></li>';
			}
		 ?>
		<li role="presentation"><a href="#itn_8d" aria-controls="itn_8d" role="tab" data-toggle="tab">8D</a></li>
		<li role="presentation"><a href="#itn_capa" aria-controls="itn_capa" role="tab" data-toggle="tab">CAPA Monitoring Report</a></li>
	  </ul>
  </div>
  <!-- Tab panes -->
  <div class="tab-content">
	<div role="tabpanel" class="tab-pane active col-sm-12" id="itn_itn">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-file fa-lg"> ITN</i></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<button type="button" class="btn btn-default fa" id=""><i class="fa fa-search"></i> Search</button>
					</div>
					<div class="col-sm-6">
						<button type="button" class="btn btn-primary fa fa-plus pull-right" id=""> New ITN</button><br /><br />
					</div>
				</div>
				<table class="table table-condensed table-striped table-bordered" id="tbl_itn"> 
					<thead>
						<tr>
							<th>Control #</th>
							<th>Attention</th>
							<th>Project</th>
							<th>Product</th>
							<th>Date / Time</th>
							<th>Issuance Date</th>
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
	<div role="tabpanel" class="tab-pane col-sm-12" id="itn_qcfr">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-file fa-lg"> QCFR</i></div>
			<div class="panel-body">
				
			</div>
		</div>
	</div>
	<?php
		/* Check if there is a read role on one Attenton Tag Report */
		$user_qfr_at_read_access = false;
		foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
			if($subsystem_code == "QFR" && $user_role['module'][$key] == "Attention Tag" && $user_role['read'][$key] == 1){ 
				$user_qfr_at_read_access = true;
			}
		}
		if( $user_qfr_at_read_access ){
			echo '<div role="tabpanel" class="tab-pane col-sm-12" id="itn_attention_tag">
					<div class="panel panel-default">
						<div class="panel-heading" style=""><i class="fa fa-file fa-lg"> Attention Tag</i></div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<button type="button" class="btn btn-default fa" id="btn_at_search_main"><i class="fa fa-search"></i> Search</button>
								</div>
								<div class="col-sm-6">
									<button type="button" class="btn btn-primary fa fa-plus pull-right" id="btn_attention_tag_new"> New Attention Tag</button>
									<button type="button" class="btn btn-success fa fa-file-excel-o pull-right" id="btn_export_attention_tag_summary"> Report</button><br /><br />
								</div>
							</div>
							<table class="table table-condensed table-striped table-bordered" id="tbl_attention_tag"> 
								<thead>
									<tr>
										<th>Status</th>
										<th>Control #</th>
										<th>Date</th>
										<th>Category</th>
										<th>Product</th>
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
				</div>';
		}
	 ?>
	
	<div role="tabpanel" class="tab-pane col-sm-12" id="itn_8d">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-file fa-lg"> 8D</i></div>
			<div class="panel-body">
				
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane col-sm-12" id="itn_capa">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-file fa-lg"> CAPA Monitoring Report</i></div>
			<div class="panel-body">
				
			</div>
		</div>
	</div>
  </div>
</div>

<!-----------------
	MODALS
------------------>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_itn_attention_tag">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New Attention Tag</h4>
      </div>
      <div class="modal-body">
        <form id="frm_attention_tag_new" name="frm_attention_tag_new">
			<div class="row">
				<div class="col-sm-6">
					<div class="funkyradio">
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox1" value="Material">
							<label for="checkbox1"> Material</label>
						</div>
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox2" value="Workmanship">
							<label for="checkbox2"> Workmanship</label>
						</div>
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox3" value="Machine">
							<label for="checkbox3"> Machine</label>
						</div>
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox4" value="Others">
							<label for="checkbox4"> Others</label>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">Status</label>
						</div>
						<div class="col-sm-8">
							<span class="badge highlight-color-green"> Open</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">Control No.</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control condensed" name="control_no" disabled>
							<!--<span ng-show="frm_attention_tag_new.txt_control_no.$touched && frm_attention_tag_new.txt_control_no.$invalid">The control number is required.</span>-->
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">Date</label>
						</div>
						<div class="col-sm-8">
							<input type="date" class="form-control condensed" name="date" max="<?php echo date('Y-m-d'); ?>" required>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">In-Charge</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control condensed" name="incharge" required>	
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-orange"> 
			<!--<div class="panel panel-primary">
				<div class="panel-heading"><label class="fa fa-lg">Product Information</span></div>
			</div>-->
			<div class="row">
				<div class="col-sm-3">
					<label class="fa condensed">Product</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="product" required>
				</div>
				<div class="col-sm-2">
					<label class="fa condensed">Lot No.</label>
				</div>
				<div class="col-sm-3">
					<input type="text" class="form-control condensed" name="lot_number" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="fa condensed">Model</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="model" required>
				</div>
				<div class="col-sm-2">
					<label class="fa condensed">Quantity</label>
				</div>
				<div class="col-sm-3">
					<input type="number" class="form-control condensed" name="quantity" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="fa condensed">Parts Code/ P.O. No.</label>
				</div>
				<div class="col-sm-4">
					<datalist id="list_at_po"></datalist>
					<input type="text" class="form-control condensed" name="partscode_pono" list="list_at_po" required>
				</div>
				<div class="col-sm-2">
					<label class="fa condensed">Issued By</label>
				</div>
				<div class="col-sm-3">
					<input type="text" class="form-control condensed" name="issued_by" required>
				</div>
			</div>
			<hr class="graph-blue"> 
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">DESCRIPTION</label>
					<textarea class="form-control" name="description"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">ANALYSIS</label>
					<textarea class="form-control" name="analysis"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">DISPOSITION/ RECOMMENDATION</label>
					<textarea class="form-control" name="disposition"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">CORRECTIVE/ PREVENTIVE ACTION</label>
					<textarea class="form-control" name="corrective_action"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">REMARKS</label>
					<textarea class="form-control" name="remarks"></textarea>
				</div>
			</div>
	  </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-remove" data-dismiss="modal"> Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_itn_attention_tag_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit/View Attention Tag</h4>
      </div>
      <div class="modal-body">
        <form id="frm_itn_attention_tag_edit" name="frm_attention_tag_edit">
			<div class="row">
				<div class="col-sm-6">
					<div class="funkyradio">
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox5" value="Material">
							<label for="checkbox5"> Material</label>
						</div>
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox6" value="Workmanship">
							<label for="checkbox6"> Workmanship</label>
						</div>
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox7" value="Machine">
							<label for="checkbox7"> Machine</label>
						</div>
						<div class="funkyradio-primary">
							<input type="checkbox" name="category[]" id="checkbox8" value="Others">
							<label for="checkbox8"> Others</label>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">Status</label>
						</div>
						<div class="col-sm-8">
							<span class="badge highlight-color-red" id="status"> </span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">Control No.</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control condensed" name="control_no" disabled>
							<!--<span ng-show="frm_attention_tag_new.txt_control_no.$touched && frm_attention_tag_new.txt_control_no.$invalid">The control number is required.</span>-->
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">Date</label>
						</div>
						<div class="col-sm-8">
							<input type="date" class="form-control condensed" name="date" required>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label class="fa condensed">In-Charge</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control condensed" name="incharge" required>	
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-orange"> 
			<!--<div class="panel panel-primary">
				<div class="panel-heading"><label class="fa fa-lg">Product Information</span></div>
			</div>-->
			<div class="row">
				<div class="col-sm-3">
					<label class="fa condensed">Product</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="product" required>
				</div>
				<div class="col-sm-2">
					<label class="fa condensed">Lot No.</label>
				</div>
				<div class="col-sm-3">
					<input type="text" class="form-control condensed" name="lot_number" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="fa condensed">Model</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="model" required>
				</div>
				<div class="col-sm-2">
					<label class="fa condensed">Quantity</label>
				</div>
				<div class="col-sm-3">
					<input type="number" class="form-control condensed" name="quantity" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="fa condensed">Parts Code/ P.O. No.</label>
				</div>
				<div class="col-sm-4">
					<input type="text" class="form-control condensed" name="partscode_pono" required>
				</div>
				<div class="col-sm-2">
					<label class="fa condensed">Issued By</label>
				</div>
				<div class="col-sm-3">
					<input type="text" class="form-control condensed" name="issued_by" required>
				</div>
			</div>
			<hr class="graph-blue"> 
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">DESCRIPTION</label>
					<textarea class="form-control" name="description"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">ANALYSIS</label>
					<textarea class="form-control" name="analysis"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">DISPOSITION/ RECOMMENDATION</label>
					<textarea class="form-control" name="disposition"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">CORRECTIVE/ PREVENTIVE ACTION</label>
					<textarea class="form-control" name="corrective_action"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label class="fa condensed">REMARKS</label>
					<textarea class="form-control" name="remarks"></textarea>
				</div>
			</div>
	  </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Save</button>
			<button type="button" class="btn btn-default fa fa-remove" data-dismiss="modal"> Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_itn_attention_tag_change_status">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Update Status Attention Tag</h4>
      </div>
      <div class="modal-body">
        <form id="frm_itn_attention_tag_change_status" name="frm_attention_tag_edit">
			<p></p>
	  </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save"> Yes</button>
			<button type="button" class="btn btn-default fa fa-remove" data-dismiss="modal"> Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal" tabindex="-1" role="dialog" id="modal_at_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_at_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_at_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_at_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_at_advance_search">
			<tbody>
			</tbody>
		</table>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info fa fa-search"> Search</button>
        <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
      </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

