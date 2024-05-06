	<section class="main">
		<section class="tab-content" id="tab-content">	
		   <section class="tab-pane active fade in content" id="ipqc">
				<div class="row">
				   <div class="col-xs-12">
						<legend><a href="#" id="a_menu"><i class="fa fa-file"></i> In-process Quality Control</a></legend>
					    <ol class="breadcrumb">
						  <li id="bc_menu"><a href="#" class="active"><i class="fa fa-home"></i> Home</a></li>
						  <li id="bc_pp"><a href="#"><i class="fa fa-american-sign-language-interpreting"></i> Pre-production </a></li>
						  <li id="bc_vir"><a href="#"><i class="fa fa-file"></i> Visual Inspection Result </a></li>
						  <li id="bc_dir"><a href="#"><i class="fa fa-file"></i> Dimension Inspection Result</a></li>
						</ol>
						<div class="row" id="container_menu">
						   <div class="col-xs-12">
								<div class="col-xs-12 col-sm-6 col-lg-4">
									<div class="panel panel-info">
									  <div class="panel-heading">
										<div class="row">
										  <div class="col-xs-2">
											<i class="fa fa-american-sign-language-interpreting fa-5x"></i>
										  </div>
										  <div class="col-xs-10 text-right">
											<p class="announcement-heading"></p>
											<p class="announcement-text fa-lg"> Pre-production</p>
										  </div>
										</div>
									  </div>
									  <a href="#" id="a_pp">
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
									  </a>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-6 col-lg-4">
									<div class="panel panel-info">
									  <div class="panel-heading">
										<div class="row">
										  <div class="col-xs-2">
											<i class="fa fa-file fa-5x"></i>
										  </div>
										  <div class="col-xs-10 text-right">
											<p class="announcement-heading"></p>
											<p class="announcement-text fa-lg"> Visual Inspection Result</p>
										  </div>
										</div>
									  </div>
									  <a href="#" id="a_vir">
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
									  </a>
									</div>
								</div>
								
								<div class="col-xs-12 col-sm-6 col-lg-4">
									<div class="panel panel-info">
									  <div class="panel-heading">
										<div class="row">
										  <div class="col-xs-2">
											<i class="fa fa-file fa-5x"></i>
										  </div>
										  <div class="col-xs-10 text-right">
											<p class="announcement-heading"></p>
											<p class="announcement-text fa-lg"> Dimension Inspection Result</p>
										  </div>
										</div>
									  </div>
									  <a href="#" id="a_dir">
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
									  </a>
									</div>
								</div>

							</div>
						</div>
				   </div>
				</div>
				
				<div class="row" id="container_pp">
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Pre-production Result</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-12">
										<table class="table table-striped table-bordered table-condensed" id="tbl_preproduction">
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
				</div>
								
				<div class="row" id="container_vir">
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Visual Inspection Result</i></div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-6">
										<button class="btn btn-default fa"><i class="fa fa-search"></i> Search</button>
									</div>
									<div class="col-sm-6">
										<button class="btn btn-success fa pull-right" id="btn_upload_di"><i class="fa fa-upload"></i> New Monitoring Report</button>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<table class="table table-striped table-bordered table-condensed" id="tbl_preproduction">
											<thead>
												<th>Line #</th>
												<th>Station</th>
												<th>FY #</th>
												<th>WW #</th>
												<th>Shift</th>
												<th>Last update</th>
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
				
				<div class="row" id="container_lcd">
					<div class="col-sm-12">
						<div class="panel panel-info">
							<div class="panel-heading"><i class="fa fa-file fa-lg"> Loss Cost Data</i></div>
							<div class="panel-body">
								
							</div>
						</div>
					</div>
				</div>
			</section>
			
		   
		</section>
		
	</section>

<!---------------------
	Modals - Start 
---------------------->

<!---------------------
	Modals - End 
---------------------->

<script>
	/* ***************************
		Menu Functions - Start
	/****************************/
	fn_display_sub_page('container_menu');
	$('#a_menu').click(function(){ fn_display_sub_page('container_menu'); });
	$('#bc_menu').click(function(){ fn_display_sub_page('container_menu'); });
	$('#container_menu #a_pp').click(function(){ fn_display_sub_page('container_pp'); });
	$('#bc_pp').click(function(){ fn_display_sub_page('container_pp'); });
	$('#container_menu #a_vir').click(function(){ fn_display_sub_page('container_vir'); });
	$('#bc_vir').click(function(){ fn_display_sub_page('container_vir'); });
	
	var ipqc_category = '';
	
	function fn_display_sub_page(sub_page){
		/* containers */
		$("#ipqc div[id*='container_']").hide();
		/* breadcrumbs */
		$('#ipqc ol li').hide();
		var bc_id = sub_page.split('_');
			bc_id = bc_id[bc_id.length-1];
		if(sub_page == "container_menu"){
			$('#ipqc ol #bc_menu').show();
		}else{
			$('#ipqc ol #bc_menu').show();
			$('#ipqc ol #bc_'+bc_id).show();
		}
		$('#ipqc #'+sub_page).toggle(500);
		// alert('a');
	}
	/* ***************************
		Menu Functions - End
	/****************************/
	
	var handler_ipqc 		= './handler/TS/handler_ipqc.php';
	var username 				= $('#hd_username').val();
	var date_today 				= "<?php echo date('Y-m-d'); ?>";
	
	
	/* **************************************************
		Pre-production - Start
	/***************************************************/
	
	
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	});
	
	// dt_ng_for_filling = $('#'+tbl_ng_for_filling).DataTable({
		// "aaSorting"	 : [],	
		// "sAjaxSource": "server_side_scripts/qr/dt_ng_for_filling.php?un="+username
	// });
	
    // $('#'+tbl_ng_for_filling+' tbody').on('click', '#btn_edit', function() {
        // var tr = $(this).closest('tr');
        // $('#frm_upload_ng #invoice_no_ng').val(tr.find('td:eq(3)').text());
        // $('#frm_upload_ng #part_code_ng').val(tr.find('td:eq(4)').text());
        // $('#frm_upload_ng #part_name_ng').val(tr.find('td:eq(5)').text());
        // $('#frm_upload_ng #lot_no_ng').val(tr.find('td:eq(6)').text());
        // $('#frm_upload_ng #supplier_ng').val(tr.find('td:eq(7)').text());
        // $('#frm_upload_ng #invoice_no_ng').prop('readOnly', true);
        // $('#frm_upload_ng #part_name_ng').prop('readOnly', true);
        // $('#frm_upload_ng #supplier_ng').prop('readOnly', true);
        // $('#frm_upload_ng #part_code_ng').prop('readOnly', true);
        // $('#frm_upload_ng #lot_no_ng').prop('readOnly', true);
        // $('#container_upload_ng_message').hide();
		// fn_load_ng_approver_chosen('tbl_approver_ng',function() {
			// fn_ng_get_new_issuance_no(function() {
				// $('#issuance_date_ng').val( date_today );
				// $('#modal_upload_ng').modal('show');
			// });
		// });
    // });
	
	
	
	/* ***************************
		Pre-production - End
	/****************************/
	
	/* **************************************************
		Visual Inspection - Start
	/***************************************************/
	
	
	
	/* **************************************************
		Visual Inspection - End
	/***************************************************/
	
	
	
	
	/* ***************************
		Test Functions - Start
	/****************************/
	
	
	/* ***************************
		Test Functions - End
	/****************************/
	
	/* ***************************
		Test Functions - Start
	/****************************/
	
	
	/* ***************************
		Test Functions - End
	/****************************/
	
</script>

