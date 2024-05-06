Lot-out Notice-


<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-file fa-lg"> Quality Complaint Feedback Report (QCFR)</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-9">
					<button class="btn btn-default fa fa-search" id="btn_qcfr_advanced_search"> Search</button>
				</div>
				<div class="col-sm-3">
					<button class="btn btn-default fa fa-plus pull-right" id="btn_add_qcfr"> New</button>
				</div>	
			</div><br />
			<div class="row">
				<div class="col-sm-12" style="overflow:auto;">
					<table class="table table-bordered table-condensed" id="tbl_qcfr">
						<thead>
							<tr>
								<th>QCFR No.</th>
								<th>Product Name</th>
								<th>Model No.</th>
								<th>Batch No./Lot No.</th>
								<th>P.O. No./ INV. No.</th>
								<th>Date Received</th>
								<th>Uploaded File</th>
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

<div class="modal" tabindex="-1" role="dialog" id="mdl_new_qcfr">
 <div class="modal-dialog modal-lg" role="document" style="width:80%;">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title fa fa-plus">Add Quality Complaint Feedback Report (QCFR)</h4>
   </div>
   <form id="frm_new_qcfr">
   <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="funkyradio" style="padding-bottom:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi" id="chk_supplier_subcon" value="0">
								<label for="chk_supplier_subcon"> <b>Supplier/Subcon</b></label>
							</div>
						</div>
						<div class="funkyradio" style="padding-top:5px;">
							<div class="funkyradio-primary">
								<input type="radio" name="subcon_pmi" id="chk_assy" value="1">
								<label for="chk_assy"> <b>PMI Assy</b></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">						
						<input type="text" class="form-control condensed" name="supplier_subcon">
						<input type="text" class="form-control condensed" name="pmi_assy">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">TO:</label>
					</div>
					<div class="col-sm-8">
						<!-- <input type="text" class="form-control condensed" name="to"> -->
						<select class="" id="cmb_to" name="to[]" multiple="multiple" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">ATTN:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="attn">
						<!-- <select class="" id="cmb_attn" name="attn[]" multiple="multiple" style="width:100%;" required>
						</select> -->
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">CC:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="cc">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">FROM:</label>
					</div>
					<div class="col-sm-8">
						<input type="text" condensed" name="from">
						<select id="cmb_from" name="from" style="width:100%;" required>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed">DATE ISSUED:</label>
					</div>
					<div class="col-sm-8">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_issued">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"><b>QCFR No.:</b></label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control condensed" name="qcfr_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding-right:0px;">
						<label class="control-label condensed"><b>Found During</b></label>
					</div>
					<div class="col-sm-9" style="">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="found_during[]" id="chk_fd_outgoing_inspection" value="1">
								<label for="chk_fd_outgoing_inspection"> Outgoing Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_incoming_inspection" value="2">
								<label for="chk_fd_incoming_inspection"> Incoming Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_in_process_inspection" value="3">
								<label for="chk_fd_in_process_inspection"> In-Process Inspection</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_quality_system_check" value="4">
								<label for="chk_fd_quality_system_check"> Quality System Check</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="found_during[]" id="chk_fd_others" value="5">
								<label for="chk_fd_others"> Others. Please Specify</label>
							</div>
						</div>
						<input type="text" class="form-control condensed" name="found_during_others" placeholder="Others. Please Specify" disabled>
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label condensed"> Reported by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Verified & Conformed by: </label>
			</div>
			<div class="col-sm-4">
				<label class="control-label condensed"> Approved by: </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="cmb_reported_by" name="reported_by[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> LQC </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_lqc" name="verified_conformed_by_lqc[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Section Head</label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_sh" name="approved_by_sh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Engineering </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_eng" name="verified_conformed_by_eng[]" style="width:100%;" required>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label condensed"> Dept. Head </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="approved_by_dh" name="approved_by_dh[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1 col-sm-offset-4">
				<label class="control-label condensed"> Production </label>
			</div>
			<div class="col-sm-3">
				<select class="" id="verified_conformed_by_prdn" name="verified_conformed_by_prdn[]" style="width:100%;" required>
				</select>
			</div>
		</div>
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Product Name</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="product_name">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Model No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="model_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Batch No./Lot No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="batch_no_lot_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> P.O. No./ INV. No.</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="po_no_invoice_no">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label class="control-label condensed"> Date Received</label>
					</div>
					<div class="col-sm-8">
						<input type="text" class="form-control condensed" name="date_received">
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-3">
							<label class="control-label condensed"> Inspection Method</label>
					</div>
					<div class="col-sm-5">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_sampling" value="1">
								<label for="chk_sampling"> Sampling</label>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="funkyradio">
							<div class="funkyradio-primary">
								<input type="checkbox" name="inspection_method[]" id="chk_hundred_percent" value="2">
								<label for="chk_hundred_percent"> 100%</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Sampling Plan</label>
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> AQL=</label>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control condensed" name="sampling_plan_aql">
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> n=</label>
					</div>
					<div class="col-sm-1">
						<input type="text" class="form-control condensed" name="sampling_plan_n">
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> Ac=</label>
					</div>
					<div class="col-sm-1">
						<input type="text" class="form-control condensed" name="sampling_plan_ac">
					</div>
					<div class="col-sm-1">
						<label class="control-label condensed"> Re=</label>
					</div>
					<div class="col-sm-1">
						<input type="text" class="form-control condensed" name="sampling_plan_re">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Affected Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="affected_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> % Defective</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_percentage">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Defective Qty.</label>
					</div>
					<div class="col-sm-3">
						<input type="number" class="form-control condensed" name="defective_qty">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> No. of Occurence</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="no_of_occurence">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label condensed"> Date Encountered</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="date_encountered">
					</div>
					<div class="col-sm-3">
						<label class="control-label condensed"> Ref. QCFR No.</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control condensed" name="reference_qcfr_no">
					</div>
				</div>
			</div>
		</div>
		<hr class="graph-orange">	
		<div class="row">
			<div class="col-sm-12">
				<label class="control-label condensed"> <b> < FAILURE / DEFECT DESCRIPTION > NOTE: Use additional attachment if necessary </b></label>
			</div>
			<div class="col-sm-12">
				<textarea type="text" class="form-control condensed" name="date_encountered"></textarea>
			</div>
			<div class="col-sm-2">
				<label class="control-label condensed"> File Attachment</label>
			</div>
			<div class="col-sm-10">
				<input type="file" class="form-control condensed" name="file_failure_defect_filename[]" multiple>
			</div>
		</div>	
		<hr class="graph-blue">
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Disposition</b> </label>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_rework_repair" value="1">
								<label for="chk_dispo_rework_repair"> Rework/Repair</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_useasis" value="2">
								<label for="chk_dispo_useasis"> Use as is</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_replace" value="3">
								<label for="chk_dispo_replace"> Replace</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="disposition[]" id="chk_dispo_return" value="4">
								<label for="chk_dispo_return"> Return</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_sorting" value="5">
								<label for="chk_dispo_sorting"> 100% sorting</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="disposition[]" id="chk_dispo_others" value="6">
								<label for="chk_dispo_others"> Others (specify)</label>
							</div>
							<input type="text" class="form-control condensed" name="disposition_others" placeholder="Others. Please Specify" disabled>
						</div>
					</div>
				</div>
			</div>		
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Nature of Request</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="nature_of_request[]" id="chk_nor_info_only" value="1">
								<label for="chk_nor_info_only"> For Information only</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="nature_of_request[]" id="chk_nor_submit_8d" value="2">
								<label for="chk_nor_submit_8d"> Submit 8D report</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="nature_of_request[]" id="chk_nor_capa" value="3">
								<label for="chk_nor_capa"> Corrective & Preventive Action Report</label>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label condensed"> <b>Answer</b> </label>
					</div>
					<div class="col-sm-12">
						<div class="funkyradio">
							<div class="funkyradio-primary" >
								<input type="checkbox" name="nature_of_request[]" id="chk_ans_need" value="1">
								<label for="chk_ans_need"> Need</label>
							</div>
							<div class="funkyradio-primary">
								<input type="checkbox" name="nature_of_request[]" id="chk_ans_mo_need" value="2">
								<label for="chk_ans_mo_need"> No Need</label>
							</div>
						</div>
					</div>
					<div class="col-sm-5">
						<label class="control-label condensed"> <b>Date Answer Required</b> </label>
					</div>
					<div class="col-sm-7">
						<input type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control condensed" name="date_answer_required">
					</div>
				</div>
			</div>		
		</div>		
		<hr class="graph-orange">		
		
   </div>
   <div class="modal-footer">
    <button type="submit" class="btn btn-primary fa fa-save"> Save</button>
    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
   </div>
   </form>
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->