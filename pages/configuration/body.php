	<section class="main">
		
		<section class="tab-content" id="tab-content">
			
		   <section class="tab-pane active fade in content" id="configuration">
			   <div class="row">
				   <div class="col-xs-12 col-sm-8 col-md-9">
						<a href="#"><span aria-hidden="true" class="fa fa-users fa-2x"> Configuration</span></a>
					</div>
			    </div><br />
				<div class="row">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#user_roles" aria-controls="user_roles" role="tab" data-toggle="tab"> User Roles</a></li>
					<li role="presentation"><a href="#supplier" aria-controls="supplier" role="tab" data-toggle="tab"> Supplier</a></li>
					<li role="presentation"><a href="#approver" aria-controls="supplier" role="tab" data-toggle="tab"> Approver</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="user_roles">
						<?php include('user_roles.php'); ?>
					</div>
					<div role="tabpanel" class="tab-pane" id="supplier">
						<?php include('supplier.php'); ?>
					</div>
					<div role="tabpanel" class="tab-pane" id="approver">
						<?php include('approver.php'); ?>
					</div>
				  </div>
				</div>
		   </section>
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
<!-- 
	Script - Homapage Google Like Search 
-->
<script>
var username 				= $('#hd_username') .val();
var handler_configuration 	= 'handler/handler_configuration.php';


/* ****************
	Test Codes
****************** */
// $('#container_user_crud .panel-body,#container_user_crud .panel-heading').toggle(500);
</script>

<script type="text/javascript" src="../common_functions/common_functions.j?2"></script>
<script type="text/javascript" src="js/configuration/supplier.js?214567"></script>
<script type="text/javascript" src="js/configuration/approver.js?2"></script>
<script type="text/javascript" src="js/configuration/user_roles.js?2"></script>