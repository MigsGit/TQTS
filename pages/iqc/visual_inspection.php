<div class="col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Visual Inspection Result</i> - Will read data from SEIKO QC Database</div>
		<div class="panel-body">
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-primary fa pull-right" id="btnSetWeeklyReport" title= "View Report Week"><i class="fa fa-calendar"></i></button>	
				<button class="btn btn-success fa pull-right" id="btnMonthlyReport" title= "Montly Report"><i class="fa fa-file-excel-o"></i> Report</button>
			</div> <br> <br>
		</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped table-bordered table-condensed" id="tbl_iqc_visual">
						<thead>
							<th>Invoice #</th>
							<th>Application Date</th>
							<th>Inspection Date</th>
							<th>Inspection Time</th>
							<th>FY #</th>
							<th>WW #</th>
							<th>Sub</th>
							<th>Part Code</th>
							<th>Part Name</th>
							<th>Supplier</th>
							<th>Lot #</th>
							<th>AQL</th>
							<th>Judgement</th>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ADD -->
<div class="modal fade" id="modal_week_table">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Report Week Table</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                    <div id="data_table"></div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">

                <div class="row">
                    <div class="col-12">
                        <div class="pull-right pr-5">
                            <button type="button" class="btn btn-md btn-danger" id="delete_week" data-toggle="tooltip" title="Delete Week"><i class="fa fa-close"></i></button>
                        </div>

                        <div class="pull-right pr-5">
                            <button type="button" class="btn btn-md btn-warning" id="edit_week" data-toggle="tooltip" title="Edit Week"><i class="fa fa-cogs"></i></button>
                        </div>

                        <div class="pull-right pr-5">
                            <button type="button" class="btn btn-md btn-primary" id="create_week" data-toggle="tooltip" title="Create Week"><i class="fa fa-plus"></i></button>
                        </div>

                        <div class="pull-right pr-5">
                            <button type="button" class="btn btn-md btn-dark" id="set_default_week" data-toggle="tooltip" title="Set Default Week"><i class="fa fa-tag"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->
    <div class="modal fade" id="modal_edit_week">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="form_edit_week" action="" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title"><strong>Create Report Week</strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                                <fieldset class="form-control" style="border-color: #D3D3D3;">
                                    <legend style="font-size: 15px; color: #FF8C00">
                                        <strong>Month & Year</strong>
                                    </legend>
                                </fieldset>
                                <div class="row">
                                        <input type="hidden" name="id_edit" id="id_edit">
                                    <div class="col-md-7">
                                        <label for="month">Month</label>
                                        <select class="form-control" name="month_edit" id="month_edit">
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <label for="year">Year</label>
                                        <select class="form-control" name="year_edit" id="year_edit" >
                                        </select>
                                    </div>
                                </div> 
                            <fieldset class="form-control" style="border-color: #D3D3D3;" >
                                <legend style="font-size: 15px; color: #FF8C00">
                                    <strong>Week 1</strong>
                                </legend>
                            </fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="w1_start">Start Date</label>
                                        <input class="form-control" type="date" name="w1s_edit" id="w1s_edit" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="w1_end">End Date</label>
                                        <input class="form-control" type="date" name="w1e_edit" id="w1e_edit" required>
                                    </div>
                                </div> 
                            <fieldset class="form-control" style="border-color: #D3D3D3;">
                                <legend style="font-size: 15px; color: #FF8C00">
                                    <strong>Week 2</strong>
                                </legend>
                            </fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="w2_start">Start Date</label>
                                        <input class="form-control" type="date" name="w2s_edit" id="w2s_edit" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="w2_end">End Date</label>
                                        <input class="form-control" type="date" name="w2e_edit" id="w2e_edit" required>
                                    </div>
                                </div>
                            <fieldset class="form-control" style="border-color: #D3D3D3;">
                                <legend style="font-size: 15px; color: #FF8C00">
                                    <strong>Week 3</strong>
                                </legend>
                            </fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="w3_start">Start Date</label>
                                        <input class="form-control" type="date" name="w3s_edit" id="w3s_edit" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="w3_end">End Date</label>
                                        <input class="form-control" type="date" name="w3e_edit" id="w3e_edit" required>
                                    </div>
                                </div>
                            <fieldset class="form-control" style="border-color: #D3D3D3;">
                                <legend style="font-size: 15px; color: #FF8C00">
                                    <strong>Week 4</strong>
                                </legend>
                            </fieldset>
                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="w4_start">Start Date</label>
                                        <input class="form-control" type="date" name="w4s_edit" id="w4s_edit" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="w4_end">End Date</label>
                                        <input class="form-control" type="date" name="w4e_edit" id="w4e_edit" required>
                                    </div>
                                </div>
                            <fieldset class="form-control" style="border-color: #D3D3D3;">

                                <legend style="font-size: 15px; color: #FF8C00">
                                    <strong>Week 5</strong>
                                </legend>
                            </fieldset>
                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="w5_start">Start Date</label>
                                        <input class="form-control" type="date" name="w5s_edit" id="w5s_edit">
                                    </div>
                                    <div class="col-md-6">

                                        <label for="w5_end">End Date</label>
                                        <input class="form-control" type="date" name="w5e_edit" id="w5e_edit">
                                    </div>
                                </div>
                        </div> 
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Submit</button>
                            <button type="button" class="btn btn-secondary" id="btn_close" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CREATE WEEK MODAL -->
    <div class="modal fade" id="modal_create_week">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="form_create_week" action="" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title"><strong>Create Report Week</strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <br>
                            <fieldset class="form-control" style="border-color: #D3D3D3;">
                                <legend style="font-size: 15px; color: #FF8C00">
                                    <strong>Month & Year</strong>
                                </legend>
                            </fieldset>
                            <br>
                        <div class="row">
                                <div class="col-md-1">
                                    <label for="month">Month</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control" name="month" id="month" >
                                        <option value="" disabled selected>Select Month</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </div>
                                <br>
                        </div>
                        <div class="row">
                                <div class="col-md-1">
                                    <label for="year">Year</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control" name="year" id="year" >
                                    </select>
                                </div>
                        </div> <br>

                        <fieldset class="form-control" style="border-color: #D3D3D3;">
                            <legend style="font-size: 15px; color: #FF8C00">
                                <strong>Week 1</strong>
                            </legend>
                        </fieldset>
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="w1_start">Start Date</label>
                                    <input class="form-control" type="date" name="w1_start" id="w1_start" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="w1_end">End Date</label>
                                    <input class="form-control" type="date" name="w1_end" id="w1_end" required>
                                </div>
                            </div> 
                        <fieldset class="form-control" style="border-color: #D3D3D3;">
                            <legend style="font-size: 15px; color: #FF8C00">
                                <strong>Week 2</strong>
                            </legend>
                        </fieldset>
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="w2_start">Start Date</label>
                                    <input class="form-control" type="date" name="w2_start" id="w2_start" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="w2_end">End Date</label>
                                    <input class="form-control" type="date" name="w2_end" id="w2_end" required>
                                </div>
                            </div> 

                        <fieldset class="form-control" style="border-color: #D3D3D3;">
                            <legend style="font-size: 15px; color: #FF8C00">
                                <strong>Week 3</strong>
                            </legend>
                        </fieldset>
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="w3_start">Start Date</label>
                                    <input class="form-control" type="date" name="w3_start" id="w3_start" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="w3_end">End Date</label>
                                    <input class="form-control" type="date" name="w3_end" id="w3_end" required>
                                </div>
                            </div> 
                        <fieldset class="form-control" style="border-color: #D3D3D3;">

                            <legend style="font-size: 15px; color: #FF8C00">
                                <strong>Week 4</strong>
                            </legend>
                        </fieldset>
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="w4_start">Start Date</label>
                                    <input class="form-control" type="date" name="w4_start" id="w4_start" required>
                                </div>
                                <div class="col-md-6">

                                    <label for="w4_end">End Date</label>
                                    <input class="form-control" type="date" name="w4_end" id="w4_end" required>
                                </div>
                            </div>
                        <fieldset class="form-control" style="border-color: #D3D3D3;">
                            <legend style="font-size: 15px; color: #FF8C00">
                                <strong>Week 5</strong>
                            </legend>
                        </fieldset>
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="w5_start">Start Date</label>
                                    <input class="form-control" type="date" name="w5_start" id="w5_start">
                                </div>
                                <div class="col-md-6">

                                    <label for="w5_end">End Date</label>
                                    <input class="form-control" type="date" name="w5_end" id="w5_end">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Set Default -->
    <div class="modal fade" id="modal_set_default_week">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Week Settings</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="default_week" id="default_week" class="form-control"></select>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btn_default_week"><i class="fa fa-calendar"></i> Set</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>