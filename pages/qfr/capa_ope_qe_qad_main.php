<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$libraries = '../../libraries/includes_direct_page.php';
if(!file_exists($libraries)){
	echo 'NO LIB';
}else{
	require_once($libraries);
}
?>

<div class="panel panel-info">
	<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Operations QE and QAD QE</i></div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12"><br />
				<table class="table table-striped table-bordered table-condensed" id="tbl_capa_ope_qe_qad">
					<thead>
						<th>Control No.</th>
						<th>Classification</th>
						<th>Section</th>
						<th>Product Mode</th>
						<th>Received Date</th>
						<th>Failure Mode</th>
						<th>Customer</th>
						<th>Assigned Line JS/SS</th>
						<th>CAPA Received</th>
						<th>Action</th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="../../js/qfr/capa_iframe.js" type="text/javascript"></script>