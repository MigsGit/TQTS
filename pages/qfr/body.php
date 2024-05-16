	<section class="main">
		<section class="tab-content" id="tab-content">	
		   <section class="tab-pane active fade in content" id="qfr">
				<div class="row">
				   <div class="col-xs-12">
						<legend><a href="#" id="a_menu"><i class="fa fa-file"></i> Quality Report Feedback</a></legend>
					    <ol class="breadcrumb">
						  <li id="bc_menu"><a href="#" class="active"><i class="fa fa-home"></i> Home</a></li>
						  <li id="bc_ng"><a href="#"><i class="fa fa-file"></i> NG Report </a></li>
						  <li id="bc_sa"><a href="#"><i class="fa fa-file"></i> Special Acceptance</a></li>
						  <li id="bc_aye"><a href="#"><i class="fa fa-file"></i> AYE Report</a></li>
						  <li id="bc_ptis"><a href="#"><i class="fa fa-file"></i> PTIS</a></li>
						  <li id="bc_itn"><a href="#"><i class="fa fa-file"></i> ITN</a></li>
						  <li id="bc_qcfr"><a href="#"><i class="fa fa-file"></i> QCFR</a></li>
						  <li id="bc_attention_tag"><a href="#"><i class="fa fa-file"></i> Attention Tag</a></li>
						  <li id="bc_8d"><a href="#"><i class="fa fa-file"></i> 8D</a></li>
						  <li id="bc_capa"><a href="#"><i class="fa fa-file"></i> CAPA Monitoring Report</a></li>
						  <li id="bc_ccr"><a href="#"><i class="fa fa-file"></i> Customer Claim Response</a></li>
						  <li id="bc_lcd"><a href="#"><i class="fa fa-file"></i> Loss Cost Data</a></li>
						</ol>
						<div class="row" id="container_menu">
							<?php include('main_menu.php'); ?>
						</div>
					</div>
				</div>
				
				<div class="row" id="container_ng">
					<?php include('ng_report.php'); ?>
				</div>
				
				<div class="row" id="container_sa">
					<?php include('special_acceptance.php'); ?>
				</div>
				
				<div class="row" id="container_aye">
					<?php include('aye_report.php'); ?>
				</div>
				
				<div class="row" id="container_ptis">
					<?php include('ptis.php'); ?>
				</div>
				
				<div class="row" id="container_itn">
					<?php include('itn.php'); ?>
				</div>
				
				<div class="row" id="container_qcfr">
					<?php include('qcfr.php'); ?>
				</div>
				
				<div class="row" id="container_attention_tag">
					<?php include('attention_tag.php'); ?>
				</div>
				
				<div class="row" id="container_8d">
					<?php include('8d.php'); ?>
				</div>
				
				<div class="row" id="container_capa">
					<?php include('capa.php'); ?>
				</div>
				
				<div class="row" id="container_ccr">
					<?php include('customer_claim_response.php'); ?>
				</div>
				
				<div class="row" id="container_lcd">
					<?php include('loss_cost_data.php'); ?>
				</div>
			</section>
			
		   
		</section>
		
	</section>

<!---------------------
	Modals - Start 
---------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_system_message" style="z-index:1051">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <div class="modal-body">
		<div class="row">
			<div class="col-sm-12" id="">				
				<div class="alert alert-success" role="alert" id="container_message">					
				</div>
			</div>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	  </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modal_system_notification">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <div class="modal-body">
     
      <H2>Record has been saved!</H2>
      <h4>New Attention tag has been added!</h4>
     
      </div>
    </div>
  </div>
</div>

<script>
	/* ***************************
		Menu Functions - Start
	/****************************/
	fn_display_sub_page('container_menu');
	$('#a_menu').click(function(){ fn_display_sub_page('container_menu'); });
	$('#bc_menu').click(function(){ fn_display_sub_page('container_menu'); });
	$('#a_ng').click(function(){ fn_display_sub_page('container_ng'); });
	$('#bc_ng').click(function(){ fn_display_sub_page('container_ng'); });
	$('#a_sa').click(function(){ fn_display_sub_page('container_sa'); });
	$('#bc_sa').click(function(){ fn_display_sub_page('container_sa'); });
	$('#a_aye').click(function(){ fn_display_sub_page('container_aye'); });
	$('#bc_aye').click(function(){ fn_display_sub_page('container_aye'); });
	$('#a_ptis').click(function(){ fn_display_sub_page('container_ptis'); });
	$('#bc_ptis').click(function(){ fn_display_sub_page('container_ptis'); });
	$('#a_itn').click(function(){ fn_display_sub_page('container_itn'); });
	$('#bc_itn').click(function(){ fn_display_sub_page('container_itn'); });
	$('#a_qcfr').click(function(){ fn_display_sub_page('container_qcfr'); });
	$('#a_attention_tag').click(function(){ fn_display_sub_page('container_attention_tag'); });
	$('#a_8d').click(function(){ fn_display_sub_page('container_8d'); });
	$('#a_capa').click(function(){ fn_display_sub_page('container_capa'); });
	$('#a_ccr').click(function(){ fn_display_sub_page('container_ccr'); });
	$('#bc_ccr').click(function(){ fn_display_sub_page('container_ccr'); });
	$('#a_lcd').click(function(){ fn_display_sub_page('container_lcd'); });
	$('#bc_lcd').click(function(){ fn_display_sub_page('container_lcd'); });
	
	
	var qfr_category = '';
	
	function fn_display_sub_page(sub_page){
		/* containers */
		$("#qfr div[id*='container_']").hide();
		$('#qfr #container_di').hide();
		/* breadcrumbs */
		$('#qfr ol li').hide();
		var bc_id = sub_page.split('_');
			bc_id = bc_id[bc_id.length-1];
			qfr_category = bc_id;
		if(sub_page == "container_menu"){
			$('#qfr ol #bc_menu').show();
		}else{
			$('#qfr ol #bc_menu').show();
			$('#qfr ol #bc_'+bc_id).show();
		}
		$('#qfr #'+sub_page).toggle(500);
	}
	/* ***************************
		Menu Functions - End
	/****************************/
	
	var common_handler 		= './handler/common_handler.php';
	var handler_qfr 		= './handler/handler_qfr.php';
	var handler_qfr_ng 		= './handler/handler_qfr_ng.php';
	var handler_qfr_itn 	= './handler/handler_qfr_itn.php';
	var handler_qfr_aye 	= './handler/handler_qfr_aye.php';
	var handler_qfr_8d 		= './handler/handler_qfr_8d.php';
	var handler_qfr_capa	= './handler/handler_qfr_capa.php';
	var handler_qcfr		= './handler/handler_qcfr.php';
	var handler_loss_cost	= './handler/handler_loss_cost.php';
	var username 			= $('#hd_username').val();
	var date_today 			= "<?php echo date('Y-m-d'); ?>";
	
	/* ***************************
		ITN Functions - Start
	/****************************/
	
	
	/* ***************************
		ITN Functions - End
	/****************************/
	
	/* Date Range Picker */
	function date_time_picker(id) {
		$('#'+id).daterangepicker(
				{
					ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
						'Last 7 Days': [moment().subtract('days', 6), moment()],
						'Last 30 Days': [moment().subtract('days', 29), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
					},
					startDate: moment().subtract('days', 29),
					endDate: moment()
				},
			function(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				if(id == "date_created_search_group") {
					load_all_control_number_per_date_created('control_number_search_list_group','control_number_search',$('#date_created_search_group').val());
				}
			}
		);
		return false;
	}

	$('input[type="file"]').bind('change', function() {
		var file_size = this.files[0].size;
		if (file_size > 3145728)
		{
			$('#modal_system_message').modal();
			$('#container_message').attr('class','alert alert-danger');
			$('#container_message').html( '<h4>Allowed file size exceeded. (Max. 3mb)</h4>' );
		   //reset file upload control
		   this.value = null;
		}
	});
	
	$('.modal').on('hidden.bs.modal', function (e) {
		/* Allows the overlayed modal to be scrollable */
		if($('.modal').hasClass('in')) {
			$('body').addClass('modal-open');
		}    
	});
	
	/* ***************************
		Test Functions - Start
	/****************************/
	// setTimeout(function(){
		// fn_display_sub_page('container_itn');
		// fn_display_sub_page('container_ng');
		// fn_display_sub_page('container_itn');
		// $('#container_capa nav-tabs li').attr('class','');
		// fn_display_sub_page('container_capa');
	// },200);
	// $('#modal_capa_qs_inspector_external_new').modal('show');
	
	/* ***************************
		Test Functions - End
	/****************************/
</script>

<script src="js/qfr/ypics.js" type="text/javascript"></script>
<script src="js/qfr/ng_report.js" type="text/javascript"></script>
<script src="js/qfr/special_acceptance.js?force={{ rand(0, 100000) }}" type="text/javascript"></script>
<!-- <script src="js/qfr/special_acceptance.js".date("YmdHis") type="text/javascript"></script> -->
<!-- <script src="<?php echo asset("js/qfr/ng_report.js?".date("YmdHis")) ?>"></script> -->
<!-- <script src="<?php echo asset("js/qfr/special_acceptance.js?".date("YmdHis")) ?>"></script> -->
<script src="js/qfr/aye_report.js" type="text/javascript"></script>
<script src="js/qfr/attention_tag.js?098765" type="text/javascript"></script>
<script src="js/qfr/ptis.js" type="text/javascript"></script>
<script src="js/qfr/itn.js" type="text/javascript"></script>
<script src="js/common_functions.js" type="text/javascript"></script>
<script src="js/qfr/8d.js" type="text/javascript"></script>
<script src="js/qfr/capa.js" type="text/javascript"></script>
<script src="js/qfr/qcfr.js" type="text/javascript"></script>
<script src="js/qfr/loss_cost.js" type="text/javascript"></script>