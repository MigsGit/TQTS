	<section class="main">
		
		<section class="tab-content" id="tab-content">
			
		   <section class="tab-pane active fade in content" id="dashboard">
				<div class="row">
				   <div class="col-xs-12">
					   <div class="panel panel-info">
						   <div class="panel-heading">
							  <i class="fa fa-search"></i> <span class="fa fa-lg"> Search Item</span>
						   </div>
						   <div class="panel-body" style="overflow:auto;">
							   	<div class="container" id="container_google_like_search">
								    <div class="row">    
								        <div class="col-xs-10">
										    <div class="input-group">
								                <div class="input-group-btn search-panel">
								                    <button type="button" class="btn btn-default btn-md dropdown-toggle" data-toggle="dropdown">
								                    	<span id="search_concept">Filter by</span> <span class="caret"></span>
								                    </button>
								                    <ul class="dropdown-menu" role="menu">
								                      <li><a href="#PONumber">PO Number</a></li>
								                      <li><a href="#DeviceCode">Parts Code</a></li>
								                      <li><a href="#DeviceName">Parts/Series Name</a></li>
								                      <li><a href="#Supplier">Supplier's Name</a></li>
													  
								                      <!-- 
													  <li><a href="#po">Contains</a></li>
													  <li><a href="#its_equal">It's equal</a></li>
								                      <li><a href="#greather_than">Greather than ></a></li>
								                      <li><a href="#less_than">Less than < </a></li>
								                      <li class="divider"></li>
								                      <li><a href="#all">Anything</a></li> -->
								                    </ul>
								                </div>
								                <input type="text" class="form-control" name="x" id="txt_search" placeholder="Search term...">
								            </div>
								        </div>
									</div><br />
									<div class="row">
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
													<!-- <tr>
														<td>450159614000010 </td>
														<td>000070901</td>
														<td>Device Name</td>
														<td><a href="#" title="get from SEIKO QC Database"><i class="fa fa-plus"></i> View Result</a></td>
														<td>Pending</td>
														<td>Pending</td>
														<td>Pending</td>
														<td><a href="#"><i class="fa fa-paperclip"></i> See Attachments <span class="badge">5</span></a></td>
														<td>N/A</td>
													</tr> -->
												</tbody>
											</table>
										</div>
									</div>
				
								</div>
								<!-- Start Search Results 
							   	
							   	<div class="container">
								    <hgroup class="mb20">
										<h3>Search Results</h3>
										<h4 class="lead"><strong class="text-danger">3</strong> results were found for the search for <strong class="text-danger">450159614000010</strong></h4>								
									</hgroup>

								    <section class="col-xs-12 col-sm-6 col-md-12">
										<article class="search-result row">
											<div class="col-xs-12 col-sm-12 col-md-2">
												<ul class="meta-search">
													<li><i class="glyphicon glyphicon-calendar"></i> <span>02/15/2014</span></li>
													<li><i class="glyphicon glyphicon-time"></i> <span>4:28 pm</span></li>
													<li><i class="glyphicon glyphicon-book"></i> <span>CN</span></li>
													<li><i class="glyphicon glyphicon-tags"></i> <span>IQC</span></li>
												</ul>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-7 excerpet">
												<a href="#" title="" class="fa-lg">450159614000010 - IQC Result</a>
												<p>Device Code = 000070901, Device Name = IC30-1100-G4, PO Qty = 70</p>						
											</div>
											<span class="clearfix borda"></span>
										</article>

								        <article class="search-result row">
											<div class="col-xs-12 col-sm-12 col-md-2">
												<ul class="meta-search">
													<li><i class="glyphicon glyphicon-calendar"></i> <span>02/13/2014</span></li>
													<li><i class="glyphicon glyphicon-time"></i> <span>8:32 pm</span></li>
													<li><i class="glyphicon glyphicon-book"></i> <span>CN</span></li>
													<li><i class="glyphicon glyphicon-tags"></i> <span>Measdata</span></li>
												</ul>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-7">
												<a href="#" title="" class="fa-lg">450159614000010 - Measdata</a>
												<p>Device Code = 000070901, Device Name = IC30-1100-G4, PO Qty = 70</p>					
											</div>
											<span class="clearfix borda"></span>
										</article>

										<article class="search-result row">
											<div class="col-xs-12 col-sm-12 col-md-2">
												<ul class="meta-search">
													<li><i class="glyphicon glyphicon-calendar"></i> <span>01/11/2014</span></li>
													<li><i class="glyphicon glyphicon-time"></i> <span>10:13 am</span></li>
													<li><i class="glyphicon glyphicon-book"></i> <span>CN</span></li>
													<li><i class="glyphicon glyphicon-tags"></i> <span>NG Report</span></li>
												</ul>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-7">
												<a href="#" title="" class="fa-lg">450159614000010 - NG Report</a>
												<p><p>Device Code = 000070901, Device Name = IC30-1100-G4, PO Qty = 70</p></p>						
											</div>
											<span class="clearfix border"></span>
										</article>			

									</section>
								</div>-->
								<!-- End Search Results -->
						   </div>
					   </div>
				   </div>
				   
				   <!--
				   <div class="col-xs-12 col-sm-3">
					   <div class="panel panel-default">
						   <div class="panel-heading">
							   Something
						   </div>
						   <div class="panel-body">
							   The sidebar is naturally responsive according to screen width. You can toggle it using the menu button in the topbar. Test it out by increasing/decreasing your screen width and watch it respond.
						   </div>
					   </div>
				   </div>
				   -->
			   </div>
		   </section>
		   
		   <section class="tab-pane fade" id="users">
			  <section class="content">
				  <div class="row">
					<div class="col-sm-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								testing
							</div>
							<div class="panel-body">
								<button class="btn btn-primary">Test</button>
							</div>
						</div>
					</div>
				  </div>
			  </section>
		   </section>
		   
		   <section class="tab-pane fade content" id="mail">
				<div class="row">
					<div class="col-sm-3">
						<div class="panel panel-default">
							<div class="panel-heading"><span class="fa fa-keyboard"></span> <b>Keyboard Shortcuts</b></div>
							<div class="panel-body">
								<p>(Alt + N) - New Data</p>
							</div>
						</div>
					</div>
					<div class="col-sm-9">
						<button class="btn btn-primary pull-right"><span class="fa fa-plus"></span> Add New Data</button>
					</div>
					<div class="col-sm-12">
						<div class="panel panel-primary">
							<div class="panel-heading">	Sample Div</div>
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
										<th>Field 1</th>
										<th>Field 2</th>
										<th>Field 3</th>
										<th>Field 4</th>
										<th>Field 5</th>
										<th>Field 6</th>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
		   </section>
		   
		   <section class="tab-pane fade" id="configuration"><!-- Start Configuration -->
			   <nav class="subbar">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#access" data-toggle="tab"><i class="fa fa-code"></i> <span>System</span></a></li>
						<li><a href="#roles" data-toggle="tab"><i class="fa fa-user"></i> <span>Roles</span></a></li>
					</ul>
				</nav>
				
				<section class="tab-content content">
					
					<section class="tab-pane active fade in" id="access">
						
						<div class="row">
							
							<div class="col-xs-12 col-sm-4">
								<div class="panel panel-default">
									<div class="panel-heading">
										Title
									</div>
									<div class="panel-body">
										<br/><br/><br/><br/>
									</div>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-4">
								<div class="panel panel-default">
									<div class="panel-heading">
										Title
									</div>
									<div class="panel-body">
										<br/><br/><br/><br/>
									</div>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-4">
								<div class="panel panel-default">
									<div class="panel-heading">
										Title
									</div>
									<div class="panel-body">
										<br/><br/><br/><br/>
									</div>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-4">
								<div class="panel panel-default">
									<div class="panel-heading">
										Title
									</div>
									<div class="panel-body">
										<br/><br/><br/><br/>
									</div>
								</div>
							</div>
						</div>
						
						
					</section>
					
					<section class="tab-pane fade" id="roles">
						
						<div class="row">
							<div class="col-xs-12 col-sm-8 col-md-9">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-users fa-lg"></i> Users CRUD
									</div>
									<div class="panel-body">
										<table class="table table-bordered">
											<thead>
												<th>Employee #</th>
												<th>Name</th>
												<th>Create <input type="checkbox"></th>
												<th>Read <input type="checkbox"></th>
												<th>Update <input type="checkbox"></th>
												<th>Delete <input type="checkbox"></th>
											</thead>
											<tbody>
												<td>J007</td>
												<td>Mark Joseph Lopez</td>
												<td><center><input type="checkbox"></center></td>
												<td><center><input type="checkbox"></center></td>
												<td><center><input type="checkbox"></center></td>
												<td><center><input type="checkbox"></center></td>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							
							<div class="hidden-xs col-sm-4 col-md-3">
								<div class="panel panel-info">
									<div class="panel-heading">
										<i class="fa fa-book fa-lg"></i> Didn't Find Employee from list?
									</div>
									<div class="panel-body">
										<p>To add employee to the CRUD list, please assign the system to this employee using Rapid.</p>
									</div>
								</div>
								
							</div>
							
							<div class="hidden-xs col-sm-4 col-md-3">
								<div class="panel panel-info">
									<div class="panel-heading">
										<i class="fa fa-book fa-lg"></i> Administrator
									</div>
									<div class="panel-body">
										<p>Only Rapid Admin from ISS will have an access to this page.</p>
									</div>
								</div>
							</div>
					   </div>
					</section>
					
				</section>
				
		   </section> <!-- End Configuration -->
		   
		</section>
		
	</section>
</article>

<?php
$file_location = 'pages/modals/sample_modal1.php';
if(file_exists($file_location)){
	require_once($file_location);
}else{
	echo "No file exist for ".$file_location;
}

?>
<script>
	// var script_url = '';
	// $(document).on("click",".sidebar-toggle",function(){
		// $(".wrapper").toggleClass("toggled");
	// });
	
	// var ctrlDown 	= false,
		// altDown  	= false,
        // ctrlKey 	= 17,
        // altKey 	    = 18,
        // cmdKey 		= 91,
        // nKey 		= 78,
        // uKey 		= 67;
		
	// $(document).keydown(function(e) {
        // if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        // if (e.keyCode == altKey || e.keyCode == altKey) altDown = true;
    // }).keyup(function(e) {
        // if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false; 
		// if (e.keyCode == altKey || e.keyCode == altKey) altDown = false; 
    // });
	
	// $(document).keyup(function(e) {
		// var keypress = e.which;
		// if( altDown && keypress == 78 ){
			// $('#modal_1').modal('show');
		// }
	// });
	
	// $( '.sidebar .sidebar-nav li a[href=#users]' ).on( 'click', function() {
		// script_url = 'js/tqts_functions.js';
		// $.getScript( script_url, function( data, textStatus, jqxhr ) {
		  // console.log( textStatus ); // display success or fail
		// });
	// });
</script>

<!-- 
	Script - Homapage Google Like Search 
-->
<script>
	var table_id 	   = 'tbl_record';
	var search_keyword = '';
	var search_value   = '';
	var otable_search  = '';
	
		otable_search = $('#'+table_id).DataTable({
			"aaSorting"	 : [],	
			"ajaxSource": "server_side_scripts/search/dt_search.php?kw="+search_keyword+"&vl="+search_value
		});
		
	var container_google_like_search_id = 'container_google_like_search';
	$('#'+container_google_like_search_id+' .search-panel .dropdown-menu li').click(function(){
		var search_text = $(this).find('a').text();
			search_keyword = ($(this).find('a').attr('href')).replace("#","");
		$('#'+container_google_like_search_id+' #search_concept').text(search_text);
	});
	$('#'+container_google_like_search_id+' #txt_search').keyup(function(e){
		if(e.keyCode == 13) {
			search_value = $(this).val();
			// otable_search.ajax.reload();
			otable_search.ajax.url( "server_side_scripts/search/dt_search.php?kw="+search_keyword+"&vl="+search_value ).load();
		}
	});
</script>