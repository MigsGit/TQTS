<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-file fa-lg"> PTIS</i></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-9">
					<button class="btn btn-default fa fa-search" id="btn_ptis_advanced_search"> Search</button>
				</div>
				<div class="col-sm-3">

				</div>	
			</div><br />
			<!--<iframe src="http://rapid/WebPTIS" height="60%" width="100%;"></iframe>-->
			<div class="row">
				<div class="col-sm-12" style="overflow:auto;">
					<table class="table table-bordered table-condensed" id="tbl_ptis">
						<thead>
							<tr>
								<th>Date</th>
								<th>PTIS Control No.</th>
								<th>Family</th>
								<th>Device Name</th>
								<th>P.O. No.</th>
								<th>P.O. Qty.</th>
								<th>Original Shipment Date</th>
								<th>Problem (NG Parameter/s)</th>
								<th>PMI Disposition</th>
								<th>Senior Engineer In-charge</th>
								<th>YEC Disposition</th>
								<th>Effect on Socket</th>
								<th>Process Engineer In-charge</th>
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

<div class="modal" tabindex="-1" role="dialog" id="modal_ptis_advance_search">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title fa fa-search"> Advance Search</h4>
      </div>
	  <form id="frm_ptis_advance_search">
      <div class="modal-body">
		<button type="button" class="btn btn-default fa pull-left fa fa-eraser" id="btn_ptis_as_reset"> Reset Search Value</button>
		<button type="button" class="btn btn-primary fa pull-right fa fa-plus" id="btn_ptis_as_add"> Add</button><br /><br />
		<table class="table" id="tbl_ptis_advance_search">
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
