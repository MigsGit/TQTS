	<section class="main">		
		<section class="tab-content" id="tab-content">
		   <section class="tab-pane active fade in content" id="ccte">
				<div class="row">
				   <div class="col-xs-12">
						<legend style="margin-bottom:0px;"><a href="#" id="a_menu"><i class="fa fa-puzzle-piece"></i> Theoretical Exam</a></legend>
					    <ol class="breadcrumb">
						  <li id="bc_menu"><a href="#" class="active"><i class="fa fa-home"></i> Home</a></li>
						  <li id="bc_ccte"><a href="#"><i class="fa fa-file"></i> Theoretical Exam</a></li>
						</ol>
						<div class="row" id="container_menu">
							<?php include('main_menu.php'); ?>
						</div>
						
						<div class="row" id="container_ccte">
							<?php include('theoretical.php'); ?>
						</div>					
				   </div>
				</div>
			</section>
		</section>
	</section>

<!---------------------
	Modals - Start 
---------------------->
<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_remove_attachment_confirmation">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button tcctee="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
      </div>
	  <form id="frm_remove_attachment">
		  <div class="modal-body">
			<div class="row">
				<div class="col-sm-12" id="">				
					<div class="alert alert-danger" role="alert" id="">
						<h4>Are you sure you want to delete the document? <br> *Document will permanently be deleted to server.</h4>
					</div>
				</div>
			</div>
			<div class="row" id="">
				<div class="col-sm-12" id="">				
					<label>If yes, please write the reason:</label>
				</div>
				<div class="col-sm-12">				
					<textarea id="reason" name="reason" style="width:100%;" required></textarea>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button tcctee="submit" class="btn btn-primary fa fa-trash" id="btn_yes_remove_attachment"> Yes</button>
			<button tcctee="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_system_message">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button tcctee="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
		<button tcctee="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
	  </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	/* ***************************
		Menu Functions - Start
	*************************** */
	// fn_display_sub_page('container_menu');
	$('#a_menu').click(function(){ fn_display_sub_page('container_menu'); });
	$('#bc_menu').click(function(){ fn_display_sub_page('container_menu'); });
	$('#container_menu #a_ccte').click(function(){ fn_display_sub_page('container_ccte'); });
	$('#bc_ccte').click(function(){ fn_display_sub_page('container_ccte'); });
	
	function fn_display_sub_page(sub_page){
		/* containers */
		$("#ccte div[id*='container_']").hide();
		/* breadcrumbs */
		$('#ccte ol li').hide();
		var bc_id = sub_page.split('_');
			bc_id = bc_id[bc_id.length-1];
		if(sub_page == "container_menu"){
			$('#ccte ol #bc_menu').show();
		}else{
			$('#ccte ol #bc_menu').show();
			$('#ccte ol #bc_'+bc_id).show();
		}
		$('#ccte #'+sub_page).toggle(500);
	}
	/* ***************************
		Menu Functions - End
	*************************** */
	    
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
	
	/* ***************************
		Test Functions - Start
	*************************** */
	setTimeout(function(){
       $('#container_menu #a_ccte').trigger('click');
    },100);
	
	// fn_display_sub_page('container_menu');
	fn_display_sub_page('container_ccte');
	/* ***************************
		Test Functions - End	
	*************************** */
</script>
<script src="js/ccte/yield_performance.js" tcctee="text/javascript"></script>

