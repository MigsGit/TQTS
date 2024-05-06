<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('../libraries/includes.php');
require_once('../handler/common_function.php');

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading"> Data</div>
				<div class="panel-body">
					<?
					$date_start = '2018-01-01';
					$date_end	= '2018-05-01';
					$data = get_visual_inspection_data($date_start,$date_end);
					echo '<table class="table table-bordered table-striped table-hover">';
					echo '	<thead>';
					echo ' 		<tr>';
					echo ' 			<th>Date Inspected</th>';
					echo ' 			<th>Lot Inspected</th>';
					echo ' 			<th>Lot OK</th>';
					echo ' 			<th>Samples</th>';
					echo ' 			<th>NG Qty</th>';
					echo ' 			<th>Target dppm</th>';
					echo ' 			<th>Actual dppm</th>';
					echo ' 			<th>Target LAR</th>';
					echo ' 			<th>Actual LAR</th>';
					echo ' 		</tr>';
					echo '	</thead>';
					echo '	<tbody>';
					foreach($data as $key => $row){
						echo '	<tr>';
						echo '		<td>'.$row['date_inspected'].'</td>';
						echo '		<td>'.$row['lot_inspected'].'</td>';
						echo '		<td>'.$row['lot_accepted'].'</td>';
						echo '		<td>'.$row['sample_size'].'</td>';
						echo '		<td>'.$row['lot_rejected'].'</td>';
						$target_dppm = get_target_dppm($row['date_inspected']);
						echo '		<td>'.$target_dppm.'</td>';
						$acutal_dppm = 0;
						if(!$row['lot_rejected'] == 0){
							$acutal_dppm = (($row['lot_rejected']/$row['sample_size'])*1000000);
						}
						echo '		<td>'.$acutal_dppm.'</td>';
						$target_lar = get_target_lar($row['date_inspected']);
						echo '		<td>'.number_format(($target_lar*100), 2, '.', '');
						$acutal_lar = $row['lot_accepted'] / $row['lot_inspected'];
						echo '		<td>'.number_format(($acutal_lar*100), 2, '.', '').'</td>';
						echo '	<tr>';
					}
					echo '	</tbody>';
					echo '</table>';
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading"> Daily Data</div>
				<div class="panel-body">
					<?
					$array_day = array();
					$day_one =  $date_start;
					$last_day = $date_end;
					$day_ctr = $day_one;
					while( strtotime($day_ctr) <= strtotime($last_day) ){
						$array_day[] = $day_ctr;
						$day_ctr = date('Y-m-d',strtotime($day_ctr . " +1 day"));
					}
					
					$array_data_per_day = array();
					foreach($array_day as $key => $date){
						$array_data_per_day[$date] = array(
							"date_inspected"	=>  "",
							"lot_inspected"	=>  array(),
							"lot_accepted"	=>  array(),
							"sample_size"	=>  array(),
							"lot_rejected"	=>  array(),
							"target_dppm"	=>  array(),
							"actual_dppm"	=>  array(),
							"target_lar"	=>  array(),
							"actual_lar"	=>  array()
						);
					}
					
					/* place values */
					foreach($data as $key => $row){
						$array_data_per_day[ $row['date_inspected'] ]['date_inspected'] 	= $row['date_inspected'];
						$array_data_per_day[ $row['date_inspected'] ]['lot_inspected'][] 	= $row['lot_inspected'];
						$array_data_per_day[ $row['date_inspected'] ]['lot_accepted'][] 	= $row['lot_accepted'];
						$array_data_per_day[ $row['date_inspected'] ]['sample_size'][] 		= $row['sample_size'];
						$array_data_per_day[ $row['date_inspected'] ]['lot_rejected'][] 	= $row['lot_rejected'];
						$target_dppm = get_target_dppm($row['date_inspected']);
						$array_data_per_day[ $row['date_inspected'] ]['target_dppm'][] 		= $target_dppm;
						$actual_dppm = 0;
						if(!$row['lot_rejected'] == 0){
							$actual_dppm = (($row['lot_rejected']/$row['sample_size'])*1000000);
						}
						$array_data_per_day[ $row['date_inspected'] ]['actual_dppm'][] 		= $actual_dppm;
						$target_lar = get_target_lar($row['date_inspected']);
						$array_data_per_day[ $row['date_inspected'] ]['target_lar'][] 		= $target_lar;
						$actual_lar = $row['lot_accepted'] / $row['lot_inspected'];
						$array_data_per_day[ $row['date_inspected'] ]['actual_lar'][] 		= $actual_lar;
					}
					
					$array_daily_data = array();
					foreach($array_data_per_day as $date_key => $row){
						$row['date_inspected'] 	= $date_key;
						$row['lot_inspected'] 	= array_sum($row['lot_inspected']);
						$row['lot_accepted'] 	= array_sum($row['lot_accepted']);
						$row['sample_size'] 	= array_sum($row['sample_size']);
						$row['lot_rejected'] 	= array_sum($row['lot_rejected']);
						$target_dppm = 0;
						if(count($row['target_dppm']) != 0 && array_sum($row['target_dppm']) != 0){
							$target_dppm = array_sum($row['target_dppm']) / count($row['target_dppm']);
						}
						$row['target_dppm'] = $target_dppm;
						$actual_dppm = 0;
						if(count($row['actual_dppm']) != 0 && array_sum($row['actual_dppm']) != 0){
							$actual_dppm = array_sum($row['actual_dppm']) / count($row['actual_dppm']);
						}
						$row['actual_dppm'] = $actual_dppm;
						$target_lar = 0;
						if(count($row['target_lar']) != 0 && array_sum($row['target_lar']) != 0){
							$target_lar = array_sum($row['target_lar']) / count($row['target_lar']);
						}
						$row['target_lar'] = $target_lar * 100;;
						$actual_lar = 0;
						if(count($row['actual_lar']) != 0 && array_sum($row['actual_lar']) != 0){
							$actual_lar = array_sum($row['actual_lar']) / count($row['actual_lar']);
						}
						$row['actual_lar'] = $actual_lar * 100;
						$array_daily_data[] = $row;
					}

					echo '<table class="table table-bordered table-striped table-hover">';
					echo '	<thead>';
					echo ' 		<tr>';
					echo ' 			<th>Date Inspected</th>';
					echo ' 			<th>Lot Inspected</th>';
					echo ' 			<th>Lot OK</th>';
					echo ' 			<th>Samples</th>';
					echo ' 			<th>NG Qty</th>';
					echo ' 			<th>Target dppm</th>';
					echo ' 			<th>Actual dppm</th>';
					echo ' 			<th>Target LAR</th>';
					echo ' 			<th>Actual LAR</th>';
					echo ' 		</tr>';
					echo '	</thead>';
					echo '	<tbody>';
					foreach($array_daily_data as $key => $row){
						echo '	<tr>';
						echo '		<td>'.$row['date_inspected'].'</td>';
						echo '		<td>'.$row['lot_inspected'].'</td>';
						echo '		<td>'.$row['lot_accepted'].'</td>';
						echo '		<td>'.$row['sample_size'].'</td>';
						echo '		<td>'.$row['lot_rejected'].'</td>';
						echo '		<td>'.$row['target_dppm'].'</td>';
						echo '		<td>'.$row['actual_dppm'].'</td>';
						echo '		<td>'.$row['target_lar'].'</td>';
						echo '		<td>'.$row['actual_lar'].'</td>';
						echo '	<tr>';
					}
					echo '	</tbody>';
					echo '</table>';
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading"> Weekly Data</div>
				<div class="panel-body">
					<?
					$array_week_range = array();
					$day_one =  $date_start;
					$last_day = $date_end;
					$day_ctr = $day_one;
					while( strtotime($day_ctr) <= strtotime($last_day) ){
						$current_day_one = $day_ctr;
						$current_day = date( 'D', strtotime($day_ctr));
						do{
							$day_ctr = date('Y-m-d',strtotime($day_ctr . " +1 day"));
							$current_day = date( 'D', strtotime($day_ctr));
						}while($current_day != 'Sun' && strtotime($day_ctr) < strtotime($last_day));
						$array_week_range[] = $current_day_one.'|'.$day_ctr;
					}					
					
					$array_data_per_week = array();
					foreach($array_week_range as $key => $week){
						$array_data_per_week[$week] = array(
							"date_inspected"	=>  "",
							"lot_inspected"	=>  array(),
							"lot_accepted"	=>  array(),
							"sample_size"	=>  array(),
							"lot_rejected"	=>  array(),
							"target_dppm"	=>  array(),
							"actual_dppm"	=>  array(),
							"target_lar"	=>  array(),
							"actual_lar"	=>  array()
						);
					}
					/* place values */
					foreach($data as $key => $row){
						foreach($array_week_range as $key_week => $week_range){
							$week_explode 	= explode("|",$week_range);
							$week_first_day = $week_explode[0];
							$week_last_day 	= $week_explode[1];
							if( strtotime($row['date_inspected']) >= strtotime($week_first_day) && strtotime($row['date_inspected']) <= strtotime($week_last_day)){
								$row['date_inspected'] = $week_range;
							}
						}
						$array_data_per_week[ $row['date_inspected'] ]['date_inspected'] 	= $row['date_inspected'];
						$array_data_per_week[ $row['date_inspected'] ]['lot_inspected'][] 	= $row['lot_inspected'];
						$array_data_per_week[ $row['date_inspected'] ]['lot_accepted'][] 	= $row['lot_accepted'];
						$array_data_per_week[ $row['date_inspected'] ]['sample_size'][] 		= $row['sample_size'];
						$array_data_per_week[ $row['date_inspected'] ]['lot_rejected'][] 	= $row['lot_rejected'];
						$target_dppm = get_target_dppm($row['date_inspected']);
						$array_data_per_week[ $row['date_inspected'] ]['target_dppm'][] 		= $target_dppm;
						$actual_dppm = 0;
						if(!$row['lot_rejected'] == 0){
							$actual_dppm = (($row['lot_rejected']/$row['sample_size'])*1000000);
						}
						$array_data_per_week[ $row['date_inspected'] ]['actual_dppm'][] 		= $actual_dppm;
						$target_lar = get_target_lar($row['date_inspected']);
						$array_data_per_week[ $row['date_inspected'] ]['target_lar'][] 		= $target_lar;
						$actual_lar = $row['lot_accepted'] / $row['lot_inspected'];
						$array_data_per_week[ $row['date_inspected'] ]['actual_lar'][] 		= $actual_lar;
					}
					// echo json_encode($array_data_per_week);
					$array_weekly_data = array();
					foreach($array_data_per_week as $date_key => $row){
						$row['date_inspected'] 	= $date_key;
						$row['lot_inspected'] 	= array_sum($row['lot_inspected']);
						$row['lot_accepted'] 	= array_sum($row['lot_accepted']);
						$row['sample_size'] 	= array_sum($row['sample_size']);
						$row['lot_rejected'] 	= array_sum($row['lot_rejected']);
						$target_dppm = 0;
						if(count($row['target_dppm']) != 0 && array_sum($row['target_dppm']) != 0){
							$target_dppm = array_sum($row['target_dppm']) / count($row['target_dppm']);
						}
						$row['target_dppm'] = $target_dppm;
						$actual_dppm = 0;
						if(count($row['actual_dppm']) != 0 && array_sum($row['actual_dppm']) != 0){
							$actual_dppm = array_sum($row['actual_dppm']) / count($row['actual_dppm']);
						}
						$row['actual_dppm'] = $actual_dppm;
						$target_lar = 0;
						if(count($row['target_lar']) != 0 && array_sum($row['target_lar']) != 0){
							$target_lar = array_sum($row['target_lar']) / count($row['target_lar']);
						}
						$row['target_lar'] = $target_lar * 100;;
						$actual_lar = 0;
						if(count($row['actual_lar']) != 0 && array_sum($row['actual_lar']) != 0){
							$actual_lar = array_sum($row['actual_lar']) / count($row['actual_lar']);
						}
						$row['actual_lar'] = $actual_lar * 100;
						$array_weekly_data[] = $row;
					}
					echo '<table class="table table-bordered table-striped table-hover">';
					echo '	<thead>';
					echo ' 		<tr>';
					echo ' 			<th>Date Inspected</th>';
					echo ' 			<th>Lot Inspected</th>';
					echo ' 			<th>Lot OK</th>';
					echo ' 			<th>Samples</th>';
					echo ' 			<th>NG Qty</th>';
					echo ' 			<th>Target dppm</th>';
					echo ' 			<th>Actual dppm</th>';
					echo ' 			<th>Target LAR</th>';
					echo ' 			<th>Actual LAR</th>';
					echo ' 		</tr>';
					echo '	</thead>';
					echo '	<tbody>';
					foreach($array_weekly_data as $key => $row){
						echo '	<tr>';
						echo '		<td>'.$row['date_inspected'].'</td>';
						echo '		<td>'.$row['lot_inspected'].'</td>';
						echo '		<td>'.$row['lot_accepted'].'</td>';
						echo '		<td>'.$row['sample_size'].'</td>';
						echo '		<td>'.$row['lot_rejected'].'</td>';
						echo '		<td>'.$row['target_dppm'].'</td>';
						echo '		<td>'.$row['actual_dppm'].'</td>';
						echo '		<td>'.$row['target_lar'].'</td>';
						echo '		<td>'.$row['actual_lar'].'</td>';
						echo '	<tr>';
					}
					echo '	</tbody>';
					echo '</table>';
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading"> Monthly Data</div>
				<div class="panel-body">
					<?
					$array_month_year = array();
					$array_day = array();
					$day_one =  $date_start;
					$last_day = $date_end;
					$day_ctr = $day_one;
					while( strtotime($day_ctr) <= strtotime($last_day) ){
						$month_year = date('Y-m', strtotime($day_ctr));
						if(!in_array($month_year,$array_month_year)){
							$array_month_year[] = $month_year;
						}
						$day_ctr = date('Y-m-d',strtotime($day_ctr . " +1 day"));
					}

					$array_data_per_month = array();
					foreach($array_month_year as $key => $month_year){
						$array_data_per_month[$month_year] = array(
							"date_inspected"	=>  $month_year,
							"lot_inspected"	=>  array(),
							"lot_accepted"	=>  array(),
							"sample_size"	=>  array(),
							"lot_rejected"	=>  array(),
							"target_dppm"	=>  array(),
							"actual_dppm"	=>  array(),
							"target_lar"	=>  array(),
							"actual_lar"	=>  array()
						);
					}
					
					foreach($data as $key => $row){
						$month_year = date('Y-m', strtotime($row['date_inspected']));
						$row['date_inspected'] = $month_year;
						$array_data_per_month[ $row['date_inspected'] ]['date_inspected'] 		= $row['date_inspected'];
						$array_data_per_month[ $row['date_inspected'] ]['lot_inspected'][] 		= $row['lot_inspected'];
						$array_data_per_month[ $row['date_inspected'] ]['lot_accepted'][] 		= $row['lot_accepted'];
						$array_data_per_month[ $row['date_inspected'] ]['sample_size'][] 		= $row['sample_size'];
						$array_data_per_month[ $row['date_inspected'] ]['lot_rejected'][] 		= $row['lot_rejected'];
						$target_dppm = get_target_dppm($row['date_inspected']);
						$array_data_per_month[ $row['date_inspected'] ]['target_dppm'][] 		= $target_dppm;
						$actual_dppm = 0;
						if(!$row['lot_rejected'] == 0){
							$actual_dppm = (($row['lot_rejected']/$row['sample_size'])*1000000);
						}
						$array_data_per_month[ $row['date_inspected'] ]['actual_dppm'][] 		= $actual_dppm;
						$target_lar = get_target_lar($row['date_inspected']);
						$array_data_per_month[ $row['date_inspected'] ]['target_lar'][] 		= $target_lar;
						$actual_lar = $row['lot_accepted'] / $row['lot_inspected'];
						$array_data_per_month[ $row['date_inspected'] ]['actual_lar'][] 		= $actual_lar;
					}
					
					$array_monthly_data = array();
					foreach($array_data_per_month as $date_key => $row){
						$row['date_inspected'] 	= $date_key;
						$row['lot_inspected'] 	= array_sum($row['lot_inspected']);
						$row['lot_accepted'] 	= array_sum($row['lot_accepted']);
						$row['sample_size'] 	= array_sum($row['sample_size']);
						$row['lot_rejected'] 	= array_sum($row['lot_rejected']);
						$target_dppm = 0;
						if(count($row['target_dppm']) != 0 && array_sum($row['target_dppm']) != 0){
							$target_dppm = array_sum($row['target_dppm']) / count($row['target_dppm']);
						}
						$row['target_dppm'] = $target_dppm;
						$actual_dppm = 0;
						if(count($row['actual_dppm']) != 0 && array_sum($row['actual_dppm']) != 0){
							$actual_dppm = array_sum($row['actual_dppm']) / count($row['actual_dppm']);
						}
						$row['actual_dppm'] = $actual_dppm;
						$target_lar = 0;
						if(count($row['target_lar']) != 0 && array_sum($row['target_lar']) != 0){
							$target_lar = array_sum($row['target_lar']) / count($row['target_lar']);
						}
						$row['target_lar'] = $target_lar * 100;;
						$actual_lar = 0;
						if(count($row['actual_lar']) != 0 && array_sum($row['actual_lar']) != 0){
							$actual_lar = array_sum($row['actual_lar']) / count($row['actual_lar']);
						}
						$row['actual_lar'] = $actual_lar * 100;
						$array_monthly_data[] = $row;
					}
					echo '<table class="table table-bordered table-striped table-hover">';
					echo '	<thead>';
					echo ' 		<tr>';
					echo ' 			<th>Date Inspected</th>';
					echo ' 			<th>Lot Inspected</th>';
					echo ' 			<th>Lot OK</th>';
					echo ' 			<th>Samples</th>';
					echo ' 			<th>NG Qty</th>';
					echo ' 			<th>Target dppm</th>';
					echo ' 			<th>Actual dppm</th>';
					echo ' 			<th>Target LAR</th>';
					echo ' 			<th>Actual LAR</th>';
					echo ' 		</tr>';
					echo '	</thead>';
					echo '	<tbody>';
					foreach($array_monthly_data as $key => $row){
						echo '	<tr>';
						echo '		<td>'.$row['date_inspected'].'</td>';
						echo '		<td>'.$row['lot_inspected'].'</td>';
						echo '		<td>'.$row['lot_accepted'].'</td>';
						echo '		<td>'.$row['sample_size'].'</td>';
						echo '		<td>'.$row['lot_rejected'].'</td>';
						echo '		<td>'.$row['target_dppm'].'</td>';
						echo '		<td>'.$row['actual_dppm'].'</td>';
						echo '		<td>'.$row['target_lar'].'</td>';
						echo '		<td>'.$row['actual_lar'].'</td>';
						echo '	<tr>';
					}
					echo '	</tbody>';
					echo '</table>';
					?>
				</div>
			</div>
		</div>
	</div>
</div>
