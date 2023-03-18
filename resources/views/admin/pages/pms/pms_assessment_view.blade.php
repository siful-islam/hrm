@extends('admin.admin_master')
@section('main_content')
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.modal-content {
    border-radius: 6px;
}
.modal-header {
    background: #00A8B3;
    color: #fff;
}
.form-control {
	border-radius: 3px;
}
.required {
    color: red;
    font-size: 14px;
}
</style>
<br/>
<br/>
<br/>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">	
	<div class="row">
		<div class="col-md-12">	
			<p style="float:left;margin-bottom: 2px;"><b><font size="3">A: Basic Information</font></b></p>	
			<table class="table table-bordered" cellspacing="0">
				<tbody>					
					<tr>
						<td style="width:20%;">Employee's Name</td>
						<td style="width:25%;"><?php echo $employee_info->emp_name_eng; ?></td>
						<td style="width:30%;">Date of Joining</td>
						<td style="width:25%;"><?php echo date("d-m-Y", strtotime($employee_info->org_join_date)); ?></td>
					</tr>					
					<tr>
						<td>Designation</td>
						<td><?php echo @$employee_designation->designation_name; ?></td>
						<td>Date of joining in present position (internal) / Date of joining after Study Leave</td>
						<td><?php echo date("d-m-Y", strtotime($employee_info->br_join_date)); ?></td>
					</tr>					
					<tr>
						<td>Grade</td>
						<td><?php echo @$employee_designation->grade_name; ?></td>
						<td>Appraisal period started on</td>
						<td>01-07-2020</td>
					</tr>					
					<tr>
						<td>Step</td>
						<td><?php echo @$employee_designation->grade_step-1; ?></td>
						<td>Appraisal period ended on</td>
						<td>30-06-2021</td>
					</tr>					
					<tr>
						<td>Department</td>
						<td><?php echo $emp_mapping->department_name; ?></td>
						
					</tr>					
					<tr>
						<td>Unit</td>
						<td><?php echo $emp_mapping->unit_name; ?></td>
						
					</tr>					
					<tr>
						<td>Place of Posting</td>
						<td><?php echo $employee_info->branch_name; ?></td>
					</tr>			
				</tbody>
			</table>
		</div>		
	</div>
	<form method="post" action="{{URL::to('/pms-final-save')}}" id="new_form" class="form-horizontal form-label-left">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-12">
			<p style="float:left;margin-bottom: 2px;"><b><font size="3">B: Delivery of Core Responsibilities: (Weight 60)</font></b></p>	
			<table class="table table-bordered" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Planned/Assigned Task</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Actual Performed/Delivery Tasks</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Task Weight</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:15%;text-align:center;">Comments (justify if score is 1,4 & 5)</td>
					</tr>
					<?php $i=1; $total_task_weight = 0; $total_score = 0; $total_weight_score = 0; foreach ($all_result as $result) { 
						$total_task_weight += $result->task_weight;
						$total_score += $result->score;
						$total_weight_score += $result->weight_score;
					?>
					<tr>
						<td style="text-align:center;"><?php echo $result->sl_no; ?></td>
						<td><?php echo $result->assigned_task; ?></td>
						<td><?php echo $result->performed_task; ?></td>
						<td style="text-align:center;"><?php echo $result->task_weight; ?></td>
						<td style="text-align:center;"><?php echo $result->score; ?></td>
						<td style="text-align:center;"><?php echo $result->weight_score; ?></td>
						<td><?php echo $result->comments; ?></td>
					</tr>
					<?php $i++; } ?>
					<tr>
						<td colspan="3" style="font-size:14px;"><center><b>Total</b></center></td>
						<td style="text-align:center;font-size:14px;"><b><?php echo $total_task_weight; ?></b></td>
						<td style="text-align:center;font-size:14px;"><b><?php echo $total_score; ?></b></td>
						<td style="text-align:center;font-size:14px;"><b><?php echo $total_weight_score; ?></b></td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Weight</center></td>
						<td style="text-align:center;">60%</td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Score</center></td>
						<td id="total_score" style="text-align:center;"><?php if(!empty($pms_final_score)) { echo $pms_final_score->score_b; } ?></td>
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<p style="float:left;margin-bottom: 2px;width:100%;"><b><font size="3">C: Professional, Interpersonal, Leadership and General Conduct: (Weight 40)</font></b></p>	
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.1: Professional Conduct: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table table-bordered">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<input type="hidden" name="emp_id" value="<?php echo $emp_id;?>">
					<?php $j=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_type == 1) { 
						
					?>
					<tr>
						<td style="text-align:center;"><?php echo $j; ?></td>
						<td><?php echo $pms_config->c_detail; ?></td>
						<td><?php echo $pms_config->comments; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->weight_score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->rating; ?></td>
					</tr>
					<?php $j++; } } ?>
					<input type="hidden" id="totalrow" value="<?php echo $j-1; ?>" class="form-control" >
					<tr>
						<td colspan="3" style="text-align:center;"><b>Total</b></td>
						<td id="total_weightscore" style="text-align:center;"></td>
						<td id="total_weightscore" style="text-align:center;"></td>
						<td id="total_rating" style="text-align:center;"><?php if(!empty($pms_final_score)) { echo $pms_final_score->score_c1; } ?></td>
					</tr>
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.2: Interpersonal Skills: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<?php $k=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_type == 2) {
					?>
					<tr>
						<td style="text-align:center;"><?php echo $k; ?></td>
						<td><?php echo $pms_config->c_detail; ?></td>
						<td><?php echo $pms_config->comments; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->weight_score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->rating; ?></td>
					</tr>
					<?php $k++; } } ?>
					<input type="hidden" id="totalrow1" value="<?php echo $k-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="totalweightscore" style="text-align:center;"></td>
						<td id="totalrating" style="text-align:center;"><?php if(!empty($pms_final_score)) { echo $pms_final_score->score_c2; } ?></td>
					</tr>
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.3: Leadership Skills: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<?php $i=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_type == 3) {
					?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $pms_config->c_detail; ?></td>
						<td><?php echo $pms_config->comments; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->weight_score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->rating; ?></td>
					</tr>
					<?php $i++; } } ?>
					<input type="hidden" id="totalrow2" value="<?php echo $i-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="totalweight_score" style="text-align:center;"></td>
						<td id="totalra_ting" style="text-align:center;"><?php if(!empty($pms_final_score)) { echo $pms_final_score->score_c3; } ?></td>
					</tr>
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.4: General Conduct: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:3%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:10%;text-align:center;">Detail</td>
						<td style="font-weight: bold;width:30%;text-align:center;">Comments</td>
						<td style="font-weight: bold;width:6%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Rating</td>
					</tr>
					<?php $i=1; foreach ($all_pms_config as $pms_config) { if($pms_config->c_type == 4) {
					?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $pms_config->c_detail; ?></td>
						<td><?php echo $pms_config->comments; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->weight_score; ?></td>
						<td style="text-align:center;"><?php echo $pms_config->rating; ?></td>
					</tr>
					<?php $i++; } } ?>
					<input type="hidden" id="totalrow3" value="<?php echo $i-1; ?>" class="form-control" >
					<tr>
						<td colspan="4" style="text-align:center;"><b>Total</b></td>
						<td id="total_wt_score" style="text-align:center;"></td>
						<td id="total_ra_ting" style="text-align:center;"><?php if(!empty($pms_final_score)) { echo $pms_final_score->score_c3; } ?></td>
					</tr>
				</tbody>
				<input type="hidden" name="score_b" id="score_b" class="form-control" >
				<input type="hidden" name="score_c1" id="score_c1" class="form-control" >
				<input type="hidden" name="score_c2" id="score_c2" class="form-control" >
				<input type="hidden" name="score_c3" id="score_c3" class="form-control" >
				<input type="hidden" name="score_c4" id="score_c4" class="form-control" >
			</table>
			<?php 
				$b1 = '<span id="b1">0</span>'; 
				$c1 = '<span id="c1">0</span>';
				$c2 = '<span id="c2">0</span>';
				$c3 = '<span id="c3">0</span>';
				$c4 = '<span id="c4">0</span>';
				$totalvalue = '<span id="totalvalue">0</span>';
				//$total = $b1 + $c1 + $c2 + $c3 + $c4;
			?>
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr>
						<td style="font-weight: bold;width:10%;text-align:center;">Total Marks</td>
						<td style="font-weight: bold;width:30%;text-align:center;"><?php if(!empty($pms_final_score)) { echo 'B = '.$pms_final_score->score_b.', '.'C.1 = '.$pms_final_score->score_c1.', '.'C.2 = '.$pms_final_score->score_c2.', '.'C.3 = '.$pms_final_score->score_c3.', '.'C.4 = '.$pms_final_score->score_c4; } ?></td>
						<td style="font-weight: bold;width:4%;text-align:center;"><?php if(!empty($pms_final_score)) { echo round($pms_final_score->score_b + $pms_final_score->score_c1 + $pms_final_score->score_c2 + $pms_final_score->score_c3 + $pms_final_score->score_c4); } ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</form>
</section>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#assessment_report").addClass('active');
	});
</script>
@endsection