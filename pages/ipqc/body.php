<style>
.modal-backdrop {
    /* bug fix - no overlay */    
    display: none;    
}
</style>
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
					  <li id="bc_lmr"><a href="#"><i class="fa fa-file"></i> LQC Monitoring Result</a></li>
					</ol>
					<div class="row" id="container_menu">
						<?php include('main_menu.php'); ?>
					</div>
				</div>
			</div>
			
			<div class="row" id="container_pp">
				<?php include('pre_production.php'); ?>
			</div>
							
			<div class="row" id="container_vir">
				<?php include('visual_inspection.php'); ?>
			</div>
							
			<div class="row" id="container_dir">
				<?php include('dimension_inspection.php'); ?>
			</div>
			<div class="row" id="container_lmr">
				<?php include('lqc_monitoring_result.php'); ?>
			</div>
			
		</section>
	</section>
</section>

<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_system_message">
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
	$('#container_menu #a_dir').click(function(){ fn_display_sub_page('container_dir'); });
	$('#bc_dir').click(function(){ fn_display_sub_page('container_dir'); });
	$('#container_menu #a_lmr').click(function(){ fn_display_sub_page('container_lmr'); });
	$('#bc_lmr').click(function(){ fn_display_sub_page('container_lmr'); });

	
	var ipqc_category = '';
	
	function fn_display_sub_page(sub_page){
		/* containers */
		$("#ipqc div[id*='container_']").hide();
		/* breadcrumbs */
		$('#ipqc ol li').hide();
		var bc_id = sub_page.split('_');
			bc_id = bc_id[bc_id.length-2];
		if(sub_page == "container_menu"){
			$('#ipqc ol #bc_menu').show();
		}else{
			$('#ipqc ol #bc_menu').show();
			$('#ipqc ol #bc_'+bc_id).show();
		}
		$('#ipqc #'+sub_page).toggle(500);
		
		
		$('#div_vir_new').hide(); //uncomment this
		$('#div_vir_view').hide(); //uncomment this
		$('#vir_main').show(); //uncomment this
	}
	/* ***************************
		Menu Functions - End
	/****************************/
	
	var handler_common 			= './handler/common_handler.php';
	var handler_ipqc_vir 	= './handler/handler_ipqc_vir.php';
	var handler_ipqc_pp 		= './handler/handler_ipqc_pp.php';
	var handler_ipqc_dir 	= './handler/handler_ipqc_dir.php';
	var handler_ipqc_lmr 	= './handler/handler_ipqc_lmr.php';
	var username 				= $('#hd_username').val();
	var date_today 				= "<?php echo date('Y-m-d'); ?>";
	
	/* $(window).keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	}); */
		
	/* ***************************
		Pre-production - End
	/****************************/
	
	// setTimeout(function() {
		// fn_display_sub_page('container_pp');
	// }, 100);
	
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
	
	// $('input[type="file"]').bind('change', function() {
	// 	var file_size = this.files[0].size;
	// 	if (file_size > 2097152)
	// 	{
	// 		$('#modal_system_message').modal();
	// 		$('#container_message').attr('class','alert alert-danger');
	// 		$('#container_message').html( '<h4>Allowed file size exceeded. (Max. 2mb)</h4>' );
	// 	   //reset file upload control
	// 	   this.value = null;
	// 	}
	// });
	
</script>
<script src="js/common_functions.js" type="text/javascript"></script>
<script src="js/ipqc/common.js" type="text/javascript"></script>
<script src="js/ipqc/pre_production.js?n=4" type="text/javascript"></script>
<script src="js/ipqc/visual_inspection.js?n=4" type="text/javascript"></script>
<script src="js/ipqc/dimension_inspection.js?123456" type="text/javascript"></script>
<script src="js/ipqc/lqc_monitoring_result.js?n=4" type="text/javascript"></script>
<script src="js/ipqc/ypics.js" type="text/javascript"></script>



