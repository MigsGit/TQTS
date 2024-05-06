<section class="main">
		
		<section class="tab-content" id="tab-content">
			
		   <section class="tab-pane active fade in content" id="dashboard">
				<span class="fa fa-2x fa-dashboard"> Dashboard </span>
				<hr>
				
				<!--
				<div class="row">
				   <div class="col-xs-12">
						<legend><a href="#" id="a_menu"><i class="fa fa-dashboard"></i> Dashboard - Total Quality Tracking System (TQTS)</a></legend>
					    <ol class="breadcrumb" style="background-color:lightblue;">
						  <li id="bc_menu"><a href="#" class="active"><i class="fa fa-search"></i> IQC </a></li>
						  <li id="bc_pp"><a href="#"><i class="fa fa-search"></i> IPQC </a></li>
						  <li id="bc_oqc"><a href="#"><i class="fa fa-search"></i> OQC </a></li>
						  <li id="bc_ypd"><a href="#"><i class="fa fa-line-chart"></i> Yield Performance Data </a></li>
						  <li id="bc_dir"><a href="#"><i class="fa fa-file"></i> Quality Feedback Report </a></li>
						  <li id="bc_etr"><a href="#"><i class="fa fa-users"></i> ETR </a></li>
						</ol>
					</div>
				</div>
				-->
				
				<div>

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist" id="tab_dashboard_menu">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><span class="fa fa-home"></span> Modules</a></li>
					<li role="presentation" class=""><a href="#search" aria-controls="search" role="tab" data-toggle="tab"><span class="fa fa-search"></span> Search</a></li>
					<li role="presentation" class=""><a href="#charts" aria-controls="charts" role="tab" data-toggle="tab"><span class="fa fa-bar-chart"></span> Charts</a></li>
					<li role="presentation" class=""><a href="#loss_cost" aria-controls="charts" role="tab" data-toggle="tab"><span class="fa fa-bar-chart"></span> Loss Cost</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <!---------------------------------
					------------- Home tab ----------
					---------------------------------->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						
						<div class="row"><!-- Modules DIV Start -->					
							<div class="col-xs-3">
								<div class="panel panel-primary">
								   <div class="panel-heading">
									  <i class="fa fa-tags"></i> <span class="fa"> Modules</span>
								   </div>
									<div class="panel-body" style="height:750px;overflow:auto;">
										<?php 
											/* Check if there is a read role on one IQC modules */
											$user_iqc_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "IQC" && $user_role['read'][$key] == 1){ 
													$user_iqc_read_access = true;
												}
											}
											if( $user_iqc_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_iqc">
															<div class="panel panel-success" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-search fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-2x"> IQC</p>
																  </div>
																</div>
															  </div>
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															</div>
														</a>
													</div>';
											}
											/* Check if there is a read role on one IPQC modules */
											$user_ipqc_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "IPQC" && $user_role['read'][$key] == 1){ 
													$user_ipqc_read_access = true;
												}
											}
											if( $user_ipqc_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_ipqc">
															<div class="panel panel-info" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-search fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-2x"> IPQC</p>
																  </div>
																</div>
															  </div>
															 
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															 
															</div>
														</a>
													</div>';
											}
											/* Check if there is a read role on one OQC modules */
											$user_oqc_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "OQC" && $user_role['read'][$key] == 1){ 
													$user_oqc_read_access = true;
												}
											}
											if( $user_oqc_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_oqc">
															<div class="panel panel-warning" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-search fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-2x"> OQC</p>
																  </div>
																</div>
															  </div>
															  
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															</div>
														</a>
													</div>';
											}
											/* Check if there is a read role on one YPD modules */
											$user_ypd_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "YPD" && $user_role['read'][$key] == 1){ 
													$user_ypd_read_access = true;
												}
											}
											if( $user_ypd_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_ypd">
															<div class="panel panel-danger" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-line-chart fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-lg"> Yield Performance Data</p>
																  </div>
																</div>
															  </div>
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															</div>
														</a>
													</div>';
											}
											/* Check if there is a read role on one QFR modules */
											$user_qfr_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "QFR" && $user_role['read'][$key] == 1){ 
													$user_qfr_read_access = true;
												}
											}
											if( $user_qfr_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_qfr">
															<div class="panel panel-success" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-cogs fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-lg"> Quality Feedback Report</p>
																  </div>
																</div>
															  </div>
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															</div>
														</a>
													</div>';
											}
											/* Check if there is a read role on one ETR modules */
											$user_etr_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "ETR" && $user_role['read'][$key] == 1){ 
													$user_etr_read_access = true;
												}
											}
											if( $user_etr_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_etr">
															<div class="panel panel-info" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-users fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-lg"> Qualification & Certification</p>
																  </div>
																</div>
															  </div>
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															</div>
														</a>
													</div>';
											}
											/* Check if there is a read role on one Theoretical modules */
											$user_ccte_read_access = false;
											foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
												if($subsystem_code == "CCTE" && $user_role['read'][$key] == 1){ 
													$user_ccte_read_access = true;
												}
											}
											if( $user_ccte_read_access ){
												echo '<div class="col-xs-12">
														<a href="#" id="a_dashboard_menu_ccte">
															<div class="panel panel-info" style="padding:0px;">
															  <div class="panel-heading">
																<div class="row">
																  <div class="col-xs-5">
																	<i class="fa fa-edit fa-5x"></i>
																  </div>
																  <div class="col-xs-7 text-right">
																	<p class="announcement-heading"></p>
																	<p class="announcement-text fa-lg"> Theoretical Exam</p>
																  </div>
																</div>
															  </div>
																<div class="panel-footer announcement-bottom">
																  <div class="row">
																	<div class="col-xs-6">
																	  Open
																	</div>
																	<div class="col-xs-6 text-right">
																	  <i class="fa fa-arrow-circle-right"></i>
																	</div>
																  </div>
																</div>
															</div>
														</a>
													</div>';
											}
										?>
										
									</div>
								</div>
								<!--<div class="panel panel-primary">
									<div class="panel-heading"> Pending Requests</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="panel panel-danger">
												   <div class="panel-heading">
													  <i class="fa fa-check-circle"></i> <span class="fa"> Pending Approvals</span>
												   </div>
												   <div class="panel-body">
														<canvas id="pie_chart_pending_approvals" width="400" height="200"></canvas>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>-->
							</div>
							
							
							<div class="col-xs-9">
								
								<div class="row">
									<div class="col-xs-12">
										<div class="panel panel-primary">
										   <div class="panel-heading">
											  <i class="fa fa-desktop"></i> <span class="fa fa-lg"> Features</span>
										   </div>
										   <div class="panel-body">
												<div class="row">
													<div class="col-xs-6">
														<div class="panel panel-info">
														   <div class="panel-heading">
															  <i class="fa fa-search"></i> <span class="fa fa-lg"> Search</span>
														   </div>
														   <div class="panel-body">
																<div class="row">
																	<div class="col-xs-3" style="padding:0px;">
																		<div class="panel panel-default" style="padding:0px;">
																			<div class="panel-body alert-danger" style="padding-left:0px;padding-right:0px;color:white;height:138px;">
																				<br><a href="#" style="color:white;"><center><span class="fa fa-search fa-4x"></span></center></a>
																			</div>
																		</div>
																	</div>
																	<div class="col-xs-9" style="padding:0px;">
																		<div class="panel panel-default" style="padding:0px;height:140px;overflow:auto;">
																			<div class="panel-body alert-default" style="">
																				<ul class="meta-search">
																					<strong class="text-primary fa fa-lg"> Search data using the following information:</strong>
																					<li>PO Number</li>
																					<li>Device Code / Device Name</li>
																					<li>Part Code / Part Name</li>
																					<li>Supplier</li>
																				</ul>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12" style="padding:0px;overflow:auto;">
																		<img src="images/search_thumbnail.PNG" width="450px">
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12" style="padding:0px;margin-top:0px;">
																		<a href="#" style="color:white;" id="a_search_now"> <span class="alert alert-danger pull-right fa fa-search"> Search Now <i class="fa fa-caret-right"></i></span></a>
																	</div>
																</div>
														   </div>
														</div>
													</div>
													<div class="col-xs-6">
														<div class="panel panel-info">
														   <div class="panel-heading">
															  <i class="fa fa-bar-chart"></i> <span class="fa fa-lg"> Charts</span>
														   </div>
														   <div class="panel-body">
																<div class="row">
																	<div class="col-xs-3" style="padding:0px;">
																		<div class="panel panel-default" style="padding:0px;">
																			<div class="panel-body alert-success" style="padding-left:0px;padding-right:0px;color:white;height:138px;">
																				<br><a href="#" style="color:white;"><center><span class="fa fa-bar-chart fa-4x"></span></center></a>
																			</div>
																		</div>
																	</div>
																	<div class="col-xs-9" style="padding:0px;">
																		<div class="panel panel-default" style="padding:0px;height:140px;overflow:auto;">
																			<div class="panel-body alert-default" style="">
																				<ul class="meta-search">
																					<strong class="text-primary fa fa-lg"> View data with use of charts</strong>
																					<li>Bar Chart</li>
																					<li>Pie Chart</li>
																					<li>Line Chart</li>
																				</ul>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12" style="padding:0px;margin-top:0px;">
																		<canvas id="bar_chart_display" width="400" height="200"></canvas>
																	</div>
																</div>
																<div class="row">
																	<div class="col-xs-12" style="padding:0px;margin-top:0px;">
																		<a href="#" style="color:white;" id="a_go_to_charts"> <span class="alert alert-success pull-right fa fa-bar-chart"> Go to Chart <i class="fa fa-caret-right"></i></span></a>
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
						</div>
						
					</div>
					
					<!---------------------------------
					------------- Search tab ----------
					---------------------------------->
					<div role="tabpanel" class="tab-pane" id="search">
						<div id="div_tqts_search"><!-- Search DIV Start -->
							<div class="panel panel-primary">
							   <div class="panel-heading">
								  <i class="fa fa-search"></i> <span class="fa fa-lg"> Search</span>
							   </div>
							   <div class="panel-body">
									<div class="row">
										<div class="col-xs-12">
											
										</div>
									</div>
									<div class="row" id="container_google_like_search">
										<div class="col-xs-12">
											<div class="input-group">
												<div class="input-group-btn search-panel">
													<button type="button" class="btn btn-default btn-md dropdown-toggle" data-toggle="dropdown">
														<span id="search_concept">Filter by</span> <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
													  <li><a href="#po_number">PO Number</a></li>
													  <li><a href="#parts_code">Part Code</a></li>
													  <li><a href="#parts_name">Part Name</a></li>
													  <li><a href="#device_code">Device Code</a></li>
													  <li><a href="#device_name">Device Name</a></li>
													  <li><a href="#supplier">Supplier</a></li>
													</ul>
												</div>
												<input type="text" name="x" id="txt_search" placeholder="Search term... enter 2 or more characters before searching" style="height:39px;">
											</div>
										</div>
									</div><br />
									
									<hgroup class="mb20">
										<h1></h1>
										<h2 class="lead"></h2>								
									</hgroup>
									
									<section id="div_search_temp_display" class="col-xs-12 col-sm-6 col-md-12">
										<article>
											<div class="row">
												<center><span class="fa fa-search fa-5x"> Search in TQTS</span></center>
											</div>
										</article>
									</section>
									<section id="section_search_tqts" class="col-xs-12 col-sm-6 col-md-12" style="height:500px;overflow-y:auto;">
										
									</section>
								</div>
							</div>
						</div><!-- Search DIV End -->
					</div>
					
					<!---------------------------------
					------------- Charts tab ----------
					---------------------------------->
					<div role="tabpanel" class="tab-pane" id="charts">
						
						<div class="row">
							<div class="col-xs-12">
								<div class="panel panel-info">
								   <div class="panel-heading">
									  <i class="fa fa-line-chart"></i> <span class="fa"> Visual Inspection Performance</span>
								   </div>
								   <div class="panel-body">
										<form id="frm_search_oqc_visual_inspection_data">
											<div class="row">
												<div class="col-sm-2">
													<select class="form-control" id="select_process" name="process">
														<option value="IQC">IQC</option>
														<option value="OQC">OQC</option>
													</select>
												</div>
												<div class="col-sm-2">
													<input type="date" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"> 
												</div>
												<div class="col-sm-2">
													<input type="date" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
												</div>
												<div class="col-sm-2">
													<select class="form-control" id="select_frequency" name="frequency">
														<option value="Daily">Daily</option>
														<option value="Weekly">Weekly</option>
														<option value="Monthly">Monthly</option>
													</select>
												</div>
												<div class="col-sm-2">
													<button type="submit" class="btn btn-primary fa fa-calendar"> Set Range</button>
												</div>
											</div>
										</form>
										<div class="row">
											<div class="col-sm-12">
												<!-- <canvas id="chart_oqc_visual_inspection"></canvas> -->
												<div id="chart_div" style="width: 500v; height: 800px;"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--<div class="col-xs-6">
								<div class="panel panel-info">
								   <div class="panel-heading">
									  <i class="fa fa-line-chart"></i> <span class="fa"> Charts</span>
								   </div>
								   <div class="panel-body">
										<div class="row">
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"> 
											</div>
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary fa fa-calendar"> Set Range</button>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<canvas id="canvas_bar_line_2"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="panel panel-info">
								   <div class="panel-heading">
									  <i class="fa fa-line-chart"></i> <span class="fa"> Charts</span>
								   </div>
								   <div class="panel-body">
										<div class="row">
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"> 
											</div>
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary fa fa-calendar"> Set Range</button>
											</div>
										</div>
										<canvas id="myChartLine" width="400" height="200"></canvas>
									</div>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="panel panel-danger">
								   <div class="panel-heading">
									  <i class="fa fa-bar-chart"></i> <span class="fa"> Charts</span>
								   </div>
								   <div class="panel-body">
									   <div class="row">
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"> 
											</div>
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary fa fa-calendar"> Set Range</button>
											</div>
										</div>
										<canvas id="myChart" width="400" height="200"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="panel panel-warning">
								   <div class="panel-heading">
									  <i class="fa fa-pie-chart"></i> <span class="fa"> Charts</span>
								   </div>
								   <div class="panel-body">
										<div class="row">
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"> 
											</div>
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary fa fa-calendar"> Set Range</button>
											</div>
										</div>
										<canvas id="myChartPie" width="400" height="200"></canvas>
									</div>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="panel panel-warning">
								   <div class="panel-heading">
									  <i class="fa fa-pie-chart"></i> <span class="fa"> Charts</span>
								   </div>
								   <div class="panel-body">
										<div class="row">
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>"> 
											</div>
											<div class="col-sm-4">
												<input type="date" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>">
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary fa fa-calendar"> Set Range</button>
											</div>
										</div>
										<canvas id="myChartPie2" width="400" height="200"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							
						</div>
						<div class="row">
							
						</div>
					</div>-->
				  
						</div>

				    </div>
				
					<!---------------------------------
					------------- Loss Cost tab ----------
					---------------------------------->
					<div role="tabpanel" class="tab-pane" id="loss_cost">						
						<div class="row">
							<div class="col-xs-12">
								<div class="panel panel-info">
								   <div class="panel-heading">
									  <i class="fa fa-line-chart"></i> <span class="fa"> Loss Cost Data</span>
								   </div>
								   <div class="panel-body">
										<form id="frm_search_loss_cost_data">
											<div class="row">
												<div class="col-sm-4">
													<input type="month" class="form-control" id="txt_start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required> 
												</div>
												<div class="col-sm-4">
													<input type="month" class="form-control" id="txt_end_date" name="end_date" value="<?php echo date('Y-m-d'); ?>" required>
												</div>
												<div class="col-sm-2">
													<button type="submit" class="btn btn-primary fa fa-calendar"> Set Range</button>
												</div>
											</div>
										</form>
										<div class="row">
											<div class="col-sm-12">
												<div id="loss_cost_display"></div>
											</div>
										</div>
									</div>
								</div>
							</div>				  
						</div>
				    </div>
				
				
				
				

			</section>
		   
		</section>
		
	</section>
	<!--<div class="row">
									<div class="col-sm-12">
										<table class="table table-bordered table-striped table-hover table-condensed" id="tbl_record" style="font-size:12px;">
											<thead>
												<tr>
													<th>PO Number</th>
													<th>Device Code</th>
													<th>Device Name</th>
													<th>IQC Result</th>
													<th>IPQC Result</th>
													<th>OQC Result</th>
													<th>Yield Performance</th>
													<th>Quality Feedback Report</th>
													<th>ETR</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>-->
</article>

<?php
$file_location = 'pages/modals/sample_modal1.php';
if(file_exists($file_location)){
	require_once($file_location);
}else{
	echo "No file exist for ".$file_location;
}

?>
<!-- 
	Script - Homapage Google Like Search 
-->
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script>
	var table_id 	   		= 'tbl_record';
	var search_keyword 		= '';
	var search_value   		= '';
	var otable_search  		= '';
	var handler_dashboard 	= 'handler/handler_dashboard.php';
	
	$('.tab-content').on('click','#btn-minimize',function(){
		$(this).closest('div.panel').find('div.panel-body').toggle();
	});
	
	$('#a_dashboard_menu_iqc').click(function(){
		$('.sidebar li#li_iqc').trigger('click');
	});
	
	$('#a_dashboard_menu_qfr').click(function(){
		$('.sidebar li#li_qfr').trigger('click');
	});
	
	$('#a_dashboard_menu_ipqc').click(function(){
		$('.sidebar li#li_ipqc').trigger('click');
	});
	
	$('#a_dashboard_menu_oqc').click(function(){
		$('.sidebar li#li_oqc').trigger('click');
	});
	
	$('#a_dashboard_menu_ypd').click(function(){
		$('.sidebar li#li_ypd').trigger('click');
	});
	
	$('#a_dashboard_menu_etr').click(function(){
		$('.sidebar li#li_etr').trigger('click');
	});
	
	$('#a_dashboard_menu_ccte').click(function(){
		$('.sidebar li#li_ccte').trigger('click');
	});
	
	
	var container = 'container_google_like_search';
	
	setTimeout(function(){
		$('#'+container+' #txt_search').attr('class','form-control');
	},1000);
	
	$('#a_go_to_charts').click(function(){
		$('#tab_dashboard_menu li span.fa-bar-chart').trigger('click');
	});
	
	$('#a_search_now').click(function(){
		$('#tab_dashboard_menu li span.fa-search').trigger('click');
	});
	
	$('#'+container+' .input-group').on('click','li',function(){
		var text = $(this).find('a').text();
		$('#'+container+' #search_concept').text(text);
	});
	
	$('#'+container+' #txt_search').keyup(function(e){
		/* detect enter */
		var key_pressed = e.which;
		if(key_pressed != '13'){
			return false;
		}		
		var search_pattern = $(this).val();
		var search_category = $('#'+container+' #search_concept').text();
		if(search_pattern.length <= 2){
			return false;
		}
		if(search_category == 'Filter by'){
			alert("Please select a search category");
			$('#'+container+' button').focus();
			return false;
		}
		
		$('#div_search_temp_display').hide();
		$('#section_search_tqts').show();
		
		fn_search_equivalent_field(search_category,function(result){
			var search = {
				"category"			: result['field_name'],
				"search_pattern" 	: search_pattern
			};
			fn_search_tqts(search);
		});
		
	});
	
	function fn_search_equivalent_field(category,callback){
		var data = {
			"action"	: "search_equivalent_field",
			"category"	: category
		}
		call_ajax(data, handler_dashboard, function(result){
			console.log(result);
			callback(result);
		});
	}
	
	function fn_search_tqts(search){
		/* one search pattern possible one or multiple fields */
		var data = {
			"action"	: "search_tqts",
			"search"	: search
		}
		call_ajax(data, handler_dashboard, function(result){
			console.log(result);
			var div_id = 'div_tqts_search';
			$('#'+div_id+' #section_search_tqts').empty();
			if(result['html'] != ''){
				$('#'+div_id+' #section_search_tqts').append(result['html']);
			}
			/* convert tables into datatable */
			$('#'+div_id+' #tbl_search_result').each(function(){
				$(this).attr('style','width:100%;')
				$(this).DataTable({
					// scrollY : '200px',
					// aaSorting : false
				});
			});
			
			/* after validation */
			var search_result_label = '<strong class="text-danger">'+result['total_match_found']+'</strong> results were found for the search for <strong class="text-danger">'+search['search_pattern']+'</strong>';
			$('#'+div_id+' hgroup.mb20 h1').html('Search Results');
			$('#'+div_id+' hgroup.mb20 h2.lead').html(search_result_label);
		});
	}
	
	$('#div_tqts_search #section_search_tqts').on('click','span.plus',function(e){
		e.preventDefault();
		$(this).html('<a href="#" title="Lorem ipsum" style="color:red;"><i class="glyphicon glyphicon-minus"></i> Minimize</a>');
		$(this).attr('class','minus');
		var article = $(this).closest('article');
		article.find('#div_expanded_content').toggle();
	});
	
	$('#div_tqts_search #section_search_tqts').on('click','span.minus',function(e){
		// e.preventDefault();
		$(this).html('<a href="#" title="Lorem ipsum" style=""><i class="glyphicon glyphicon-plus"></i> Expand</a>');
		$(this).attr('class','plus');
		var article = $(this).closest('article');
		article.find('#div_expanded_content').toggle();
	});
	
	
	/* Charts.js */
	// var ctx = document.getElementById("myChart");
	// var myChart = new Chart(ctx, {
		// type: 'bar',
		// data: {
			// labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
			// datasets: [{
				// label: '# of Votes',
				// data: [12, 19, 3, 5, 2, 3],
				// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// 'rgba(54, 162, 235, 0.2)',
					// 'rgba(255, 206, 86, 0.2)',
					// 'rgba(75, 192, 192, 0.2)',
					// 'rgba(153, 102, 255, 0.2)',
					// 'rgba(255, 159, 64, 0.2)'
				// ],
				// borderColor: [
					// 'rgba(255,99,132,1)',
					// 'rgba(54, 162, 235, 1)',
					// 'rgba(255, 206, 86, 1)',
					// 'rgba(75, 192, 192, 1)',
					// 'rgba(153, 102, 255, 1)',
					// 'rgba(255, 159, 64, 1)'
				// ],
				// borderWidth: 1
			// }]
		// },
		// options: {
			// scales: {
				// yAxes: [{
					// ticks: {
						// beginAtZero:true
					// }
				// }]
			// }
		// }
	// });
	
	// var ctxLine = document.getElementById("myChartLine");
	// var myChartLine = new Chart(ctxLine, {
		// type: 'line',
		// data: {
			// labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
			// datasets: [{
				// label: '# of Votes',
				// data: [12, 19, 3, 5, 2, 3],
				// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// 'rgba(54, 162, 235, 0.2)',
					// 'rgba(255, 206, 86, 0.2)',
					// 'rgba(75, 192, 192, 0.2)',
					// 'rgba(153, 102, 255, 0.2)',
					// 'rgba(255, 159, 64, 0.2)'
				// ],
				// borderColor: [
					// 'rgba(255,99,132,1)',
					// 'rgba(54, 162, 235, 1)',
					// 'rgba(255, 206, 86, 1)',
					// 'rgba(75, 192, 192, 1)',
					// 'rgba(153, 102, 255, 1)',
					// 'rgba(255, 159, 64, 1)'
				// ],
				// borderWidth: 1
			// }]
		// },
		// options: {
			// scales: {
				// yAxes: [{
					// ticks: {
						// beginAtZero:true
					// }
				// }]
			// }
		// }
	// });
	
	// var ctxPie = document.getElementById("myChartPie");
	// var myChartLine = new Chart(ctxPie, {
		// type: 'pie',
		// data: {
			// labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
			// datasets: [{
				// label: '# of Votes',
				// data: [12, 19, 3, 5, 2, 3],
				// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// 'rgba(54, 162, 235, 0.2)',
					// 'rgba(255, 206, 86, 0.2)',
					// 'rgba(75, 192, 192, 0.2)',
					// 'rgba(153, 102, 255, 0.2)',
					// 'rgba(255, 159, 64, 0.2)'
				// ],
				// borderColor: [
					// 'rgba(255,99,132,1)',
					// 'rgba(54, 162, 235, 1)',
					// 'rgba(255, 206, 86, 1)',
					// 'rgba(75, 192, 192, 1)',
					// 'rgba(153, 102, 255, 1)',
					// 'rgba(255, 159, 64, 1)'
				// ],
				// borderWidth: 1
			// }]
		// },
		// options: {
			// scales: {
				// yAxes: [{
					// ticks: {
						// beginAtZero:true
					// }
				// }]
			// }
		// }
	// });
	
	// var ctxPie2 = document.getElementById("myChartPie2");
	// var myChartLine = new Chart(ctxPie2, {
		// type: 'line',
		// data: {
			// labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
			// datasets: [{
				// label: '# of Votes',
				// data: [12, 19, 3, 5, 2, 3],
				// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// 'rgba(54, 162, 235, 0.2)',
					// 'rgba(255, 206, 86, 0.2)',
					// 'rgba(75, 192, 192, 0.2)',
					// 'rgba(153, 102, 255, 0.2)',
					// 'rgba(255, 159, 64, 0.2)'
				// ],
				// borderColor: [
					// 'rgba(255,99,132,1)',
					// 'rgba(54, 162, 235, 1)',
					// 'rgba(255, 206, 86, 1)',
					// 'rgba(75, 192, 192, 1)',
					// 'rgba(153, 102, 255, 1)',
					// 'rgba(255, 159, 64, 1)'
				// ],
				// borderWidth: 1
			// }]
		// },
		// options: {
			// scales: {
				// yAxes: [{
					// ticks: {
						// beginAtZero:true
					// }
				// }]
			// }
		// }
	// });
	
	
	
	// var chart_data = {
			// labels: ["IQC", "OQC", "IPQC", "QFR", "ETR",],
			// datasets: [{
				// label: 'Charts',
				// data: [2, 3, 2, 1, 5, 2],
				// backgroundColor: [
					// 'rgba(255, 99, 132, 0.2)',
					// 'rgba(54, 162, 235, 0.2)',
					// 'rgba(255, 206, 86, 0.2)',
					// 'rgba(75, 192, 192, 0.2)',
					// 'rgba(153, 102, 255, 0.2)',
					// 'rgba(255, 159, 64, 0.2)'
				// ],
				// borderColor: [
					// 'rgba(255,99,132,1)',
					// 'rgba(54, 162, 235, 1)',
					// 'rgba(255, 206, 86, 1)',
					// 'rgba(75, 192, 192, 1)',
					// 'rgba(153, 102, 255, 1)',
					// 'rgba(255, 159, 64, 1)'
				// ],
				// borderWidth: 1
			// }]
		// }
	// var opt = {
			// scales: {
				// xAxes: [{
					// ticks: {
						// beginAtZero: true
					// }
				// }]
			// }
		// }
		
	// var ctx_pending_approvals = document.getElementById("bar_chart_display").getContext("2d");
	// var chart_pending_approvals = new Chart(ctx_pending_approvals, {
		// type: 'horizontalBar',
		// data: chart_data,
		// options: opt
	// });
	
	
	
	
	
	/* Bar and Line Charts */
	$('#frm_search_oqc_visual_inspection_data').submit(function(e){
		e.preventDefault();
		var data = {
			"date_start"	: $(this).find('input#txt_start_date').val(),
			"date_end"		: $(this).find('input#txt_end_date').val(),
			"process"		: $(this).find('select#select_process').val(),
			"frequency"		: $(this).find('select#select_frequency').val(),
		}
		// get_oqc_chart_data(data);	
		get_iqc_oqc_chart(data);	
	});
	
	window.chartColors = {
		red: 'rgb(255, 0, 0)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(0, 255, 0)',
		blue: 'rgb(0, 0, 255)',
		purple: 'rgb(255, 0, 255)',
		grey: 'rgb(201, 203, 207)'
	};
	
	function random_value(){
		return Math.floor((Math.random() * 20) + 1);
	}
	
	
	// window.onload = function() {
	// var chartData = {
		// labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
		// datasets: [
			// {
				// type: 'line',
				// label: 'Dataset 1',
				// borderColor: window.chartColors.red,
				// borderWidth: 2,
				// fill: false,
				// data: [
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value()
				// ]
			// }, {
				// type: 'line',
				// label: 'Dataset 2',
				// borderColor: window.chartColors.blue,
				// borderWidth: 2,
				// fill: false,
				// data: [
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value()
				// ]
			// }, {
				// type: 'bar',
				// label: 'Dataset 3',
				// backgroundColor: window.chartColors.purple,
				// data: [
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value()
				// ],
				// borderColor: 'black',
				// borderWidth: 1
			// }, {
				// type: 'bar',
				// label: 'Dataset 4',
				// backgroundColor: window.chartColors.green,
				// data: [
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value(),
					// random_value()
				// ],
				// borderColor: 'black',
				// borderWidth: 1
			// }
		// ]

	// };
	var ctx = document.getElementById('chart_oqc_visual_inspection').getContext('2d');
	var chart_oqc_visual_inspection = new Chart(ctx, {
		type: 'bar',
		data: [],
		options: {
			responsive: true,
			title: {
				display: true,
				text: 'Visual Inspection Chart'
			},
			tooltips: {
				mode: 'index',
				intersect: true
			}
		}
	});

	function get_iqc_oqc_chart(search_data){
		var data = {
			"action"		: "get_oqc_chart_data",
			"search_data"	: search_data
		}
		call_ajax(data,handler_dashboard,function(result){
			current_data = [];
			current_data.push(['Category C',result['array_target_lar']]);
		
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawVisualization);

			function drawVisualization() {

				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Topping');
				data.addColumn('number', 'Target DPPM'); //3rd Data
				data.addColumn('number', 'Actual DPPM'); //4th Data
				data.addColumn('number', 'Target LAR'); //1st Data
				data.addColumn('number', 'Actual LAR'); //2nd Data

/* Here's the sample of Static Value
				data.addColumn('string', 'Topping');
				data.addColumn('number', 'Target DPPM');
				data.addColumn('number', 'Actual DPPM');
				data.addColumn('number', 'Target LAR');
				data.addColumn('number', 'Actual LAR');

				data.addRows([
					['2023-02-01|2023-02-02', 3,4,6,7],
					['2023-02-02|2023-02-09', 1,4,6,7],
					['2023-02-09|2023-02-16', 1,4,6,7],
					['2023-02-16|2023-02-23', 1,4,6,7],
					['2023-02-23|2023-02-28', 2,4,6,7]
				]);
*/
				var dataArrayTo = [];
				for (let i = 0; i < result['array_target_lar'].length; i++) {
					/** From this loop, there is relationship of this data with the google graph
					 * 1st & 2nd data = Left axis
					 
					 *TAKE NOTE: Don't you ever try to change the order, because the 1st data will dictate what would be 
					 the minimum and maximum data of left axis (LAR) while the 3rd == to left axis (DPPM)
					 */
					array_labels 	 	= result['array_labels'][i]
					array_target_lar 	= result['array_target_lar'][i]; //1st Data
					array_actual_lar 	= result['array_actual_lar'][i]; //2nd Data
					array_target_dppm 	= result['array_target_dppm'][i] //3rd Data
					array_actual_dppm 	= result['array_actual_dppm'][i] //4th Data
				
					let data = [
						array_labels,
						parseFloat(array_target_dppm),
						parseFloat(array_actual_dppm),
						parseFloat(array_target_lar), 
						parseFloat(array_actual_lar),
					];
					dataArrayTo.push(data);
				}

				data.addRows(dataArrayTo);
				console.log(dataArrayTo);

			// Define the chart options
			/** IQC Chart */
			if(search_data['process']=="IQC"){
				var options = {
					title: 'Visual Inspection Result',
					seriesType: 'line',
					curveType: 'function',
					legend: { position: 'bottom' },
					series: {
						0: { 
							targetAxisIndex: 1, //TARGET DPPM
							type: 'bars' 
						},
						1: { 
							targetAxisIndex: 1, //ACTUAL DPPM
							type: 'bars' 
						},
						2:{
							// targetAxisIndex: 2,
							targetAxisIndex: 0, //TARGET LAR
						
						},
						3:{
							targetAxisIndex: 0, //ACTUAL LAR
						}
					}, 
					vAxes: {
						0: {title: 'LAR (%)',
							minValue: 0}, //Left Axis which the LAR
						1: {title: 'DPPM', 
							minValue: 0, 
							maxValue:10000} //Right Axis which the DPPM
					}
				};
			}else{ /** OQC Chart */
				var options = {
					title: 'Visual Inspection Result',
					seriesType: 'line',
					curveType: 'function',
					legend: { position: 'bottom' },
					series: {
						0: { 
							targetAxisIndex: 1, //DPPM
							type: 'bars' 
						},
						1: { 
							targetAxisIndex: 1, //DPPM
							type: 'bars' 
						},
						2:{
							// targetAxisIndex: 2,
							targetAxisIndex: 0, //LAR
						
						},
						3:{
							targetAxisIndex: 0, //LAR
						}
					}, 
					vAxes: {
						0: {title: 'LAR (%)',
							minValue: 97}, //Left Axis which the LAR

						1: {title: 'DPPM',
							minValue: 0, 
							maxValue:50} //Right Axis which the DPPM
					}
				};
			}
				var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		});
	}
	/**
	 * 
	 */
	function get_oqc_chart_data(search_data){
		// data = "action=get_oqc_chart_data&" + $.param(data);
		var data = {
			"action"		: "get_oqc_chart_data",
			"search_data"	: search_data
		}
		call_ajax(data,handler_dashboard,function(result){
			console.log(result['array_target_lar']);
			/** Get the data  */
			var oqc_vi_data = {
				labels: result['array_labels'],
				// data:{ //nmodify
					datasets: [
						{
							type: 'line',
							yAxisID: 'A',
							label: result['array_dataset_label'][2],
							borderColor: window.chartColors.red,
							borderWidth: 2,
							fill: false,
							pointRadius: 1,
							data: result['array_target_lar']
						}, {
							type: 'line',
							yAxisID: 'A',
							label: result['array_dataset_label'][3],
							borderColor: window.chartColors.blue,
							// borderColor: 'rgb(75, 150, 250)',
							borderWidth: 2,
							fill: false,
							pointRadius: 1,
							data:  result['array_actual_lar']
						}, {
							type: 'bar',
							yAxisID: 'B',
							label: result['array_dataset_label'][0],
							backgroundColor: window.chartColors.orange,
							data: result['array_target_dppm'],
							borderColor: 'black',
							borderWidth: 1
						}, {
							type: 'bar',
							yAxisID: 'B',
							label: result['array_dataset_label'][1],
							backgroundColor: window.chartColors.blue,
							data: result['array_actual_dppm'],
							// borderColor: 'black',
							borderWidth: 1
						}
					]
			};
			/* Change chart data */
			var ctx = document.getElementById('chart_oqc_visual_inspection');
			if(typeof(chart_oqc_visual_inspection) != "undefined" && chart_oqc_visual_inspection !== null) {
				chart_oqc_visual_inspection.destroy();
			}		
			console.log(search_data['process']);

			if(search_data['process']=="IQC"){
				chart_oqc_visual_inspection = new Chart(ctx, {
					type: 'bar',
					data: oqc_vi_data,
					options: {
						responsive: true,
						title: {
							display: true,
							text: 'Visual Inspection Chart'
						},
						tooltips: {
							mode: 'index',
							intersect: true
						},
						scales: {
							yAxes: [{
								id: 'A',
								type: 'linear',
								position: 'left',
								ticks: {
								suffix: "%",
								max: 100,
								min: 97
								},
								scaleLabel: {
									display: true,
									labelString: 'L A R (%)',
								}
							}, 
							{
								id: 'B',
								type: 'linear',
								position: 'right',
								ticks: {
								// beginAtZero: true,
								max: 10000,
								min: 0,
								// interval: 20000
								},scaleLabel: {
									display: true,
									labelString: 'D P P M'
								}
							}]
							}
					}
				});	
			}else{
				chart_oqc_visual_inspection = new Chart(ctx, {
					type: 'bar',
					data: oqc_vi_data,
					options: {
						responsive: true,
						title: {
							display: true,
							text: 'Visual Inspection Chart'
						},
						tooltips: {
							mode: 'index',
							intersect: true
						},
						scales: {
							yAxes: [{
								id: 'A',
								type: 'linear',
								position: 'left',
								ticks: {
								suffix: "%",
								max: 100,
								min: 97
								},
								scaleLabel: {
									display: true,
									labelString: 'L A R (%) ',
								}
							}, 
							{
								id: 'B',
								type: 'linear',
								position: 'right',
								ticks: {
								// beginAtZero: true,
								max: 80,
								min: 0,
								// interval: 20000
								
								},scaleLabel: {
									display: true,
									labelString: ' D P P M '
								}
							}]
							}
					}
				});	
			}
			
		});
	}

	/* Loss cost display */
	$('#frm_search_loss_cost_data').submit(function(e){
		e.preventDefault();
		return_lost_cost_presentation($(this).find('input#txt_start_date').val(), $(this).find('input#txt_end_date').val());
	});
	
	function return_lost_cost_presentation(date_start, date_end) {
		$('#loss_cost_display').empty();
		var data = {
			"action"		: "return_lost_cost_presentation",
			"date_start"	: date_start,
			"date_end"		: date_end
		}
		call_ajax(data,handler_dashboard,function(result){
			for(var i=0; i<(result['loss_cost']).length; i++) {
				$('#loss_cost_display').append("<iframe src="+result['loss_cost'][i]+" width=\"50%\" style=\"height:80%\"></iframe>");
			}
		});
	}
	
	// otable_search = $('#'+table_id).DataTable({
		// "aaSorting"	 : [],	
		// "ajaxSource": "server_side_scripts/search/dt_search.php?kw="+search_keyword+"&vl="+search_value
	// });
		
	// var container_google_like_search_id = 'container_google_like_search';
	// $('#'+container_google_like_search_id+' .search-panel .dropdown-menu li').click(function(){
		// var search_text = $(this).find('a').text();
			// search_keyword = ($(this).find('a').attr('href')).replace("#","");
		// $('#'+container_google_like_search_id+' #search_concept').text(search_text);
	// });
	// $('#'+container_google_like_search_id+' #txt_search').keyup(function(e){
		// if(e.keyCode == 13) {
			// search_value = $(this).val();
			// otable_search.ajax.url( "server_side_scripts/search/dt_search.php?kw="+search_keyword+"&vl="+search_value ).load();
		// }
	// });
</script>

