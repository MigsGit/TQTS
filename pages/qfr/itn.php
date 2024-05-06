<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading"><i class="fa fa-file fa-lg"> ITN</i></div>
		<div class="panel-body">
			
			<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#originator" aria-controls="originator" role="tab" data-toggle="tab"> Originator</a></li>
				<li role="presentation"><a href="#lqc" aria-controls="lqc" role="tab" data-toggle="tab"> LQC Supervisor</a></li>
				<li role="presentation"><a href="#inspector" aria-controls="inspector" role="tab" data-toggle="tab"> QC Inspector</a></li>
				<li role="presentation"><a href="#engineering_production_supervisor" aria-controls="engineering_production_supervisor" role="tab" data-toggle="tab"> Engineering / Production Supervisor</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content"><!-- Tab Originator Start -->
				<div role="tabpanel" class="tab-pane active" id="originator">
					<div class="row">
						<div class="col-sm-6">
							<button type="button" class="btn btn-default fa" id=""><i class="fa fa-search"></i> Search</button>
						</div>
						<div class="col-sm-6">
							<button type="button" class="btn btn-primary fa fa-plus pull-right" id="btn_qfr_itn_new"> New ITN</button><br /><br />
						</div>
					</div>
					<table class="table table-condensed table-striped table-bordered" id="tbl_itn"> 
						<thead>
							<tr>
								<th>Status</th>
								<th>Control #</th>
								<th>Project</th>
								<th>Lot #</th>
								<th>Model</th>
								<th>Date / Time</th>
								<th>Station</th>
								<th>Sample</th>
								<th>Name</th>
								<th>Excel</th>
								<th><span class="fa fa-cogs"></span></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table> 
				</div><!-- Tab Originator End -->
				
				<div role="tabpanel" class="tab-pane" id="lqc">
					<table class="table table-condensed table-striped table-bordered" id="tbl_itn_lqc_supervisor"> 
						<thead>
							<tr>
								<th>Status</th>
								<th>Control #</th>
								<th>Project</th>
								<th>Lot #</th>
								<th>Model</th>
								<th>Date / Time</th>
								<th>Station</th>
								<th>Sample</th>
								<th>Name</th>
								<th>Excel</th>
								<th><span class="fa fa-cogs"></span></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table> 
				</div>
				<div role="tabpanel" class="tab-pane" id="inspector">
					<table class="table table-condensed table-striped table-bordered" id="tbl_itn_inspector"> 
						<thead>
							<tr>
								<th>Status</th>
								<th>Control #</th>
								<th>Project</th>
								<th>Lot #</th>
								<th>Model</th>
								<th>Date / Time</th>
								<th>Station</th>
								<th>Sample</th>
								<th>Name</th>
								<th>Excel</th>
								<th><span class="fa fa-cogs"></span></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table> 
				</div>
				<div role="tabpanel" class="tab-pane" id="engineering_production_supervisor">
					<table class="table table-condensed table-striped table-bordered" id="tbl_itn_production_supervisor"> 
						<thead>
							<tr>
								<th>Status</th>
								<th>Control #</th>
								<th>Project</th>
								<th>Lot #</th>
								<th>Model</th>
								<th>Date / Time</th>
								<th>Station</th>
								<th>Sample</th>
								<th>Name</th>
								<th>Excel</th>
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
	</div>
</div>

<datalist id="list_qc_personnel"><option>QC Personnel</option></datalist>
<datalist id="list_lqc_supervisor"></datalist>
<datalist id="list_line_supervisor"></datalist>
<datalist id="list_product_engineering"></datalist>

<!-----------------
	MODALS
------------------>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_qfr_itn_new">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New Inspection Trouble Notice</h4>
      </div>
      <div class="modal-body">
        <form id="frm_qfr_itn_new">
			<div class="row" style="margin-top:5px;">
				<div class="col-sm-6 col-sm-offset-6">
					<div class="profile-info-title h4" >
						<p style="text-align:right;">
							<span class="fa fa-book"></span> Control No. <span id="span_ctrl_no" class="badge highlight-color-blue size-14"> Test</span>
						</p>
					</div>
				</div>
            </div>
			<!--<div class="row">
				<div class="col-md-2 col-sm-offset-6">
					<label class="control-label condensed">CONTROL #</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="control_no" readonly>
				</div>
			</div>
			<hr class="graph-orange">-->
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">ATTENTION</label>
				</div>
				<div class="col-md-10">
					<select class="" name="attention[]" id="cmb_attn" multiple="multiple" style="width:100%;">
					</select>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">PROJECT</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="project">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">REFERENCE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="reference">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">MODEL	</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="model">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">DATE/TIME</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="date_time">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">STATION</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="station">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">SAMPLE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="sample">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">NAME</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="name">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">AC/RE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="ac_re">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">ISSUANCE DATE</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="issuance_date">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">RETURN DATE</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="return_date">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">LOT NUMBER</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="lot_no">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">LOT QUANTITY</label>
				</div>
				<div class="col-md-4">
					<input type="number" class="form-control" name="lot_qty">
				</div>
			</div>
			<hr class="graph-orange"> 
			<div class="row">
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-3">
							<center><b>Shift</b></center>
						</div>
						<div class="col-md-9">
							<div class="funkyradio">
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_a" id="chk_shift_a" value="1">
									<label for="chk_shift_a"> A</label>
								</div>
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_b" id="chk_shift_b" value="1">
									<label for="chk_shift_b"> B</label>
								</div>
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_c" id="chk_shift_c" value="1">
									<label for="chk_shift_c"> C</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="row">
						<div class="funkyradio">
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="gate" id="chk_gate" value="1">
									<label for="chk_gate" style="width:60%;"> GATE</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="surveillance" id="chk_surveillance" value="1">
									<label for="chk_surveillance" style="width:60%;"> SURVEILLANCE</label>
								</div>
							</div>
						</div>
					</div>
					<hr class="graph-blue">
					<div class="row">
						<div class="funkyradio">
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="normal" id="checkbox6" value="1">
									<label for="checkbox6" style="width:60%;"> Normal</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="tightened" id="checkbox7" value="1">
									<label for="checkbox7" style="width:60%;"> Tightened</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="reduced" id="checkbox8" value="1">
									<label for="checkbox8" style="width:60%;"> Reduced</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>FINDINGS / PROBLEM:</b></label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed"><i>Description of found non-conformity / discrepant product</i></label>
						</div>
						<div class="col-md-5">
							<label class="control-label condensed"><i>STANDARD SPECIFICATION/S:</i></label>
						</div>
						<div class="col-md-7">
							<input type="text" class="form-control" name="standard_specification">
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="10" name="findings_problem"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Inspected by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">QC Personnel</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="fp_inspected_by" list="list_qc_personnel">-->
							<select class="form-control" name="fp_inspected_by" id="cmb_fp_inspected_by" style="width:100%;" required>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Verified by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">LQC Supervisor</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="fp_verfied_by" list="list_lqc_supervisor">-->
							<select class="form-control" name="fp_verfied_by" id="cmb_fp_verfied_by" style="width:100%;" required>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Conformed by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Line Supervisor</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="fp_conformed_by" list="list_line_supervisor">-->
							<select class="form-control" name="fp_conformed_by" id="cmb_fp_conformed_by" style="width:100%;" required>
							</select>
						</div>
					</div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_itn">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New Inspection Trouble Notice</h4>
      </div>
      <div class="modal-body">
        <form id="frm_itn_new">
			<div class="row" id="error_message">
				<div class="col-md-12 alert alert-danger">
					<p>Error Message:</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-6">
					<label class="control-label condensed">STATUS</label>
				</div>
				<div class="col-md-4">
					<span class="badge highlight-color-red">Open</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">ATTENTION</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="attention">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">CONTROL #</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="control_no" readonly>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">PROJECT</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="project">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">LOT NUMBER</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="lot_no">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">MODEL	</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="model">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">DATE/TIME</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="date_time">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">STATION</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="station">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">SAMPLE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="sample">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">NAME</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="name">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">AC/RE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="ac_re">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">REFERENCE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="reference">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">ISSUANCE DATE</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="issuance_date">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">LOT QUANTITY</label>
				</div>
				<div class="col-md-4">
					<input type="number" class="form-control" name="lot_qty">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">RETURN DATE</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="return_date">
				</div>
			</div>
			<hr class="graph-orange"> 
			<div class="row">
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-3">
							<center><b>Shift</b></center>
						</div>
						<div class="col-md-9">
							<div class="funkyradio">
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_a" id="chk_shift_a" value="1">
									<label for="chk_shift_a"> A</label>
								</div>
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_b" id="chk_shift_b" value="1">
									<label for="chk_shift_b"> B</label>
								</div>
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_c" id="chk_shift_c" value="1">
									<label for="chk_shift_c"> C</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="row">
						<div class="funkyradio">
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="gate" id="chk_gate" value="1">
									<label for="chk_gate" style="width:60%;"> GATE</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="surveillance" id="chk_surveillance" value="1">
									<label for="chk_surveillance" style="width:60%;"> SURVEILLANCE</label>
								</div>
							</div>
						</div>
					</div>
					<hr class="graph-blue">
					<div class="row">
						<div class="funkyradio">
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="normal" id="checkbox6" value="1">
									<label for="checkbox6" style="width:60%;"> Normal</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="tightened" id="checkbox7" value="1">
									<label for="checkbox7" style="width:60%;"> Tightened</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="reduced" id="checkbox8" value="1">
									<label for="checkbox8" style="width:60%;"> Reduced</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>FINDINGS / PROBLEM:</b></label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed"><i>Description of found non-conformity / discrepant product</i></label>
						</div>
						<div class="col-md-5">
							<label class="control-label condensed"><i>STANDARD SPECIFICATION/S:</i></label>
						</div>
						<div class="col-md-7">
							<input type="text" class="form-control" name="standard_specification">
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="10" name="findings_problem"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Inspected by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">QC Personnel</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="fp_inspected_by" list="list_qc_personnel">-->
							<select class="form-control" name="fp_inspected_by">
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Verified by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">LQC Supervisor</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="fp_verfied_by" list="list_lqc_supervisor">-->
							<select class="form-control" name="fp_verfied_by">
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Conformed by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Line Supervisor</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="fp_conformed_by" list="list_line_supervisor">-->
							<select class="form-control" name="fp_conformed_by">
							</select>
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-orange">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>ANALYSIS:</b></label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="7" name="analysis"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Validated by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Line Supervisor</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="a_validated_by" list="list_line_supervisor">-->
							<select class="form-control" name="a_validated_by">
							</select>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Date</label>
						</div>
						<div class="col-md-12">
							<input type="date" class="form-control" name="a_date">
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>CORRECTIVE ACTION:</b></label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="7" name="corrective_action"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Responsible:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Production/Engineering</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="ca_responsible" list="list_product_engineering">-->
							<select class="form-control" name="ca_responsible">
							</select>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Date</label>
						</div>
						<div class="col-md-12">
							<input type="date" class="form-control" name="ca_date">
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-orange">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>RESULT OF CONFIRMATION: </b></label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="7" name="result_confirmation"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Responsible:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Production/Engineering</label>
						</div>
						<div class="col-md-12">
							<!--<input type="text" class="form-control" name="rc_responsible" list="list_product_engineering">-->
							<select class="form-control" name="rc_responsible">
							</select>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Date</label>
						</div>
						<div class="col-md-12">
							<input type="date" class="form-control" name="rc_date">
						</div>
					</div>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_itn_view_edit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> New Inspection Trouble Notice</h4>
      </div>
      <div class="modal-body">
        <form id="frm_itn_view_edit">
			<div class="row" id="error_message">
				<div class="col-md-12 alert alert-danger">
					<p>Error Message:</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2 col-md-offset-6">
					<label class="control-label condensed">STATUS</label>
				</div>
				<div class="col-md-4">
					<span class="badge highlight-color-red">Open</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">ATTENTION</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="attention">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">CONTROL #</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="control_no" readonly>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">PROJECT</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="project">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">LOT NUMBER</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="lot_no">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">MODEL	</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="model">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">DATE/TIME</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="date_time">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">STATION</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="station">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">SAMPLE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="sample">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">NAME</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="name">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">AC/RE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="ac_re">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">REFERENCE</label>
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" name="reference">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">ISSUANCE DATE</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="issuance_date">
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<label class="control-label condensed">LOT QUANTITY</label>
				</div>
				<div class="col-md-4">
					<input type="number" class="form-control" name="lot_qty">
				</div>
				<div class="col-md-2">
					<label class="control-label condensed">RETURN DATE</label>
				</div>
				<div class="col-md-4">
					<input type="date" class="form-control" name="return_date">
				</div>
			</div>
			<hr class="graph-orange"> 
			<div class="row">
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-3">
							<center><b>Shift</b></center>
						</div>
						<div class="col-md-9">
							<div class="funkyradio">
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_a" id="chk_shift_a_e" value="1">
									<label for="chk_shift_a_e"> A</label>
								</div>
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_b" id="chk_shift_b_e" value="1">
									<label for="chk_shift_b_e"> B</label>
								</div>
								<div class="funkyradio-primary">
									<input type="checkbox" name="shift_c" id="chk_shift_c_e" value="1">
									<label for="chk_shift_c_e"> C</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="row">
						<div class="funkyradio">
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="gate" id="chk_gate_e" value="1">
									<label for="chk_gate_e" style="width:60%;"> GATE</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="surveillance" id="chk_surveillance_e" value="1">
									<label for="chk_surveillance_e" style="width:60%;"> SURVEILLANCE</label>
								</div>
							</div>
						</div>
					</div>
					<hr class="graph-blue">
					<div class="row">
						<div class="funkyradio">
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="normal" id="chk_normal_e" value="1">
									<label for="chk_normal_e" style="width:60%;"> Normal</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="tightened" id="chk_tightened_e" value="1">
									<label for="chk_tightened_e" style="width:60%;"> Tightened</label>
								</div>
							</div>
							<div class="col-md-12">
								<div class="funkyradio-primary">
									<input type="checkbox" name="reduced" id="chk_reduced_e" value="1">
									<label for="chk_reduced_e" style="width:60%;"> Reduced</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>FINDINGS / PROBLEM:</b></label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed"><i>Description of found non-conformity / discrepant product</i></label>
						</div>
						<div class="col-md-5">
							<label class="control-label condensed"><i>STANDARD SPECIFICATION/S:</i></label>
						</div>
						<div class="col-md-7">
							<input type="text" class="form-control" name="standard_specification">
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="10" name="findings_problem"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Inspected by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">QC Personnel</label>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" name="fp_inspected_by">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Verified by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">LQC Supervisor</label>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" name="fp_verfied_by">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Conformed by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Line Supervisor</label>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" name="fp_conformed_by">
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-orange">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>ANALYSIS:</b></label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="7" name="analysis"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Validated by:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Line Supervisor</label>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" name="a_validated_by">
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Date</label>
						</div>
						<div class="col-md-12">
							<input type="date" class="form-control" name="a_date">
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-blue">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>CORRECTIVE ACTION:</b></label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="7" name="corrective_action"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Responsible:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Production/Engineering</label>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" name="ca_responsible">
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Date</label>
						</div>
						<div class="col-md-12">
							<input type="date" class="form-control" name="ca_date">
						</div>
					</div>
				</div>
			</div>
			<hr class="graph-orange">
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed"><b>RESULT OF CONFIRMATION: </b></label>
						</div>
						<div class="col-md-12">
							<textarea class="form-control condensed" rows="7" name="result_confirmation"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<label class="control-label condensed">Responsible:</label>
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Production/Engineering</label>
						</div>
						<div class="col-md-12">
							<input type="text" class="form-control" name="rc_responsible">
						</div>
						<div class="col-md-12">
							<label class="control-label condensed">Date</label>
						</div>
						<div class="col-md-12">
							<input type="date" class="form-control" name="rc_date">
						</div>
					</div>
				</div>
			</div>
	  </div>
      <div class="modal-footer">
			<button type="submit" class="btn btn-primary fa fa-save" id="btn_edit_itn"> Save</button>
			<button type="button" class="btn btn-default fa fa-remove" data-dismiss="modal"> Close</button>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_itn_change_status">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Update Status Inspection Trouble Notice</h4>
      </div>
      <div class="modal-body">
        <form id="frm_itn_change_status">
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