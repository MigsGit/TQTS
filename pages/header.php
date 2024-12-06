<!-- Redirect to another page (for no-js support) (place it in your <head>) -->
<noscript><meta http-equiv="refresh" content="0;url=pages/nojs-version.php"></noscript>    
<html>
<title>TQTS</title>
<head>
<?php require_once('pages/login_validation.php'); ?>
<?php require_once('libraries/includes.php'); ?>
<?php require_once('get_user_roles.php'); ?>
<?php echo '<input type="hidden" id="txt_selected_menu" value="'.$selected_menu.'">'; ?>


<?php 
/* used for standalone testing purposed only - remove on live or do not patch this page */
// $_SESSION['username'] = 'ronfern'; 
?>
<?php 
// $_SESSION['rapid_account_type'] = 2; 
/* used for standalone testing purposed only - remove on live or do not patch this page */
?>
<input type="text" id="hd_username" value="<?php echo $_SESSION['username']; ?>">
</head>
<body>
	<div id="loading_overlay">
		<div id="loading_overlay_center">
			<center>
				<img src="images/loader.gif"><br />	
				<h2>Loading Module...</h2>
			</center>
		</div>
	</div>
	<nav class="navbar navbar-default navbar-fixed-top topbar">
		<div class="">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">
					<span class="hidden-xs">TQTS TS</span>
				</a>

				<p class="navbar-text">
					
				</p>
			</div>

			<div class="navbar-collapse collapse" id="navbar-collapse-main">
				<ul class="nav navbar-nav navbar-left">
					<li>
						<a href="#" class="sidebar-toggle" id="toggle-menu">
							<i class="fa fa-bars"></i>
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right" style="padding-right:8px;">
					<li class="dropdown">
						<button class="navbar-btn" data-toggle="dropdown">
							<i class="fa fa-globe fa-2x"></i> <i class="badge">5</i>
						</button>
						<ul class="dropdown-menu">
							<li><a href="#">(IQC) In-coming Quality Inspection <i class="badge">1</i></a></li>
							<li><a href="#">(OQC) Out-going Quality Inspection <i class="badge">4</i></a></li>
							<li class="nav-divider"></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
	<article class="wrapper">
	
	<aside class="sidebar">
		<ul class="sidebar-nav">
			<li class="active" id="li_dashboard"><a href="#dashboard" data-toggle="tab"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php 
				/* Check if there is a read role on one IQC modules */
				$user_iqc_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "IQC" && $user_role['read'][$key] == 1){ 
						$user_iqc_read_access = true;
					}
				}
				if( $user_iqc_read_access ){
					echo '<li id="li_iqc"><a href="#" data-toggle="tab"><i class="fa fa-puzzle-piece"></i> <span>IQC</span></a></li>';
				}
				/* Check if there is a read role on one IPQC modules */
				$user_ipqc_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "IPQC" && $user_role['read'][$key] == 1){ 
						$user_ipqc_read_access = true;
					}
				}
				if( $user_ipqc_read_access ){
					echo '<li id="li_ipqc"><a href="#" data-toggle="tab"><i class="fa fa-puzzle-piece"></i> <span>IPQC</span></a></li>';
				}
				/* Check if there is a read role on one OQC modules */
				$user_oqc_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "OQC" && $user_role['read'][$key] == 1){ 
						$user_oqc_read_access = true;
					}
				}
				if( $user_oqc_read_access ){
					echo '<li id="li_oqc"><a href="#" data-toggle="tab"><i class="fa fa-puzzle-piece"></i> <span>OQC</span></a></li>';
				}
				/* Check if there is a read role on one YPD modules */
				$user_ypd_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "YPD" && $user_role['read'][$key] == 1){ 
						$user_ypd_read_access = true;
					}
				}
				if( $user_ypd_read_access ){
					echo '<li id="li_ypd"><a href="#" data-toggle="tab"><i class="fa fa-line-chart"></i> <span>Yield Performance Data</span></a></li>';
				}
				/* Check if there is a read role on one QFR modules */
				$user_qfr_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "QFR" && $user_role['read'][$key] == 1){ 
						$user_qfr_read_access = true;
					}
				}
				if( $user_qfr_read_access ){
					echo '<li id="li_qfr"><a href="#" data-toggle="tab"><i class="fa fa-file"></i> <span>Quality Feedback Report</span></a></li>';
				}
				/* Check if there is a read role on one ETR modules */
				$user_etr_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "ETR" && $user_role['read'][$key] == 1){ 
						$user_etr_read_access = true;
					}
				}
				if( $user_etr_read_access ){
					echo '<li id="li_etr"><a href="#" data-toggle="tab"><i class="fa fa-users"></i> <span>Qualification & Certification</span></a></li>';
				}
				/* Check if there is a read role on one CCTE modules */
				$user_ccte_read_access = false;
				foreach($user_role['subsystem_code'] as $key => $subsystem_code ){
					if($subsystem_code == "CCTE" && $user_role['read'][$key] == 1){ 
						$user_ccte_read_access = true;
					}
				}
				if( $user_ccte_read_access ){
					echo '<li id="li_ccte"><a href="#" data-toggle="tab"><i class="fa fa-edit"></i> <span>Theoretical Exam</span></a></li>';
				}
				/* user configuration only ISS admin and main user should have this */
				// if($_SESSION['rapid_account_type'] == 1 || $_SESSION['rapid_account_type'] == 2){
				if($_SESSION['username'] == 'judcata' || // Authorized user; might be change once user is resigned
					$_SESSION['username'] == 'cnpoblete' ||
					$_SESSION['username'] == 'joysust' ||
					$_SESSION['username'] == 'joymotin' ||
					$_SESSION['username'] == 'rancali' ||
					$_SESSION['rapid_account_type'] == 2){ // ISS
					echo '<li id="li_configuration"><a href="#" data-toggle="tab"><i class="fa fa-cogs"></i> <span>Configuration</span></a></li>';
				}
			?>
		</ul>
	</aside>
	
	<script>
		var script_url = '';
		var handler = 'handler/handler.php';
		var selected_menu = $('#txt_selected_menu').val();
		$(function () { $('[data-toggle="popover"]').popover(); });

		$(document).on("click",".sidebar-toggle",function(){
			$(".wrapper").toggleClass("toggled");
		});
		
		$('.sidebar li').click(function(){
			fn_get_page(this.id);
			console.log('labas'+this.id);
		});
		
		display_loading_screent();
		function display_loading_screent(){
			document.getElementById("loading_overlay").style.display = "block";
			setTimeout(function(){
				document.getElementById("loading_overlay").style.display = "none";
			},300);
		}
		
		function fn_get_page(page_id){
			var data = {
				"action"	: "fn_get_page",
				"page_id"	: page_id
			}
			data = $.param(data);
			$.ajax({
				type	: "post",
				dataType: "json",
				data 	: data,
				url 	: handler,
				success	:function(result){
					console.log(result);
					window.location.href = "index.php?page="+result['page'];
				},error	: function(result){
					console.log(result);
				}
			});
		}
		
		fn_set_active_nav(selected_menu);
		function fn_set_active_nav(selected_menu){
			if(selected_menu == ''){
				$('.sidebar .sidebar-nav li').attr('class','');
				$('.sidebar .sidebar-nav #li_dashboard').attr('class','active');
			}else{
				$('.sidebar .sidebar-nav li').attr('class','');
				$('.sidebar .sidebar-nav #li_'+selected_menu).attr('class','active');
			}
		}
	</script>