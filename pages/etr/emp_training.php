<div class="row" id="container_employee" style="">								
	<div class="col-xs-12 col-sm-8 col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<label> Employee Training Records</label>
			</div>
			<div class="panel-body">
				<div class="row">					
					<div class="col-sm-12">
						<button type="button" class="btn btn-default fa fa-home"> Back</button>
					</div>
				</div>
				<div class="row" style="margin-top:5px;">
					<div class="col-sm-12">
						<form id="frm_emp_info">
						<div class="panel panel-default">
							<div class="panel-heading">
								<label> Employee Information</label>
							</div>
							<div class="panel-body form-inline">
								<div class="row ">	
									<div class="col-sm-2">
										<label class="control-label condensed"> Name: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="EmpName" id="EmpName" style="width:100%" readonly>
									</div>
									<div class="col-sm-2">
										<label class="control-label condensed"> Emp No.: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="EmpNo" id="EmpNo" style="width:100%" readonly>
									</div>
								</div>
								<div class="row">	
									<div class="col-sm-2">
										<label class="control-label condensed"> Division: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="Division" id="Division" style="width:100%" readonly>
									</div>
									<div class="col-sm-2">
										<label class="control-label condensed"> Department: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="Department" id="Department" style="width:100%" readonly>
									</div>
								</div>
								<div class="row">	
									<div class="col-sm-2">
										<label class="control-label condensed"> Section: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="Section" id="Section" style="width:100%" readonly>
									</div>
									<div class="col-sm-2">								
										<label class="control-label condensed"> Position: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="Position" id="Position" style="width:100%" readonly>
									</div>
								</div>
								<div class="row">	
									<div class="col-sm-2">
										<label class="control-label condensed"> Employment Status: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="EmpStatus" id="EmpStatus" style="width:100%" readonly>
									</div>	
								</div>
								<div class="row">	
									<div class="col-sm-2">
										<label class="control-label condensed"> Date Hired: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="DateHired" id="DateHired" style="width:100%" readonly>
									</div>
									<div class="col-sm-2">
										<label class="control-label condensed"> Hiring Status: </label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="HiringStatus" id="HiringStatus" style="width:100%" readonly>
									</div>
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
				
				<div class="block-content-inner">
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
										Training Plan
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true" style="">
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12">
											<table class="table table-bordered table-condensed" id="tbl_emp_training_plan">
												<thead>
													<th><center>Training Title</center></th>
													<th><center>Total Target</center></th>
													<th><center>Total Actual</center></th>
													<th><center>Due Date</center></th>
													<th><center>Variance</center></th>
													<th><center>Status</center></th>
													<th style="display:none;">Fiscal Year</th>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
										Training/s Attended
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12">
											<table class="table table-bordered table-condensed" id="tbl_emp_trainings">
												<thead>
													<th><center>Date</center></th>
													<th><center>Title</center></th>
													<th><center>Objective</center></th>
													<th><center>Trainor</center></th>
													<th><center>Results</center></th>
													<th><center>Venue</center></th>
													<th><center>Mechanics</center></th>
													<th><center>Type of Training</center></th>
													<th><center>Remarks</center></th>
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
				</div>
			</div>
		</div>
	</div>	
</div>	

					