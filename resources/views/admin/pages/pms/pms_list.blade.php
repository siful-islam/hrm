@extends('admin.admin_master')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
.form-horizontal .control-label {
    text-align: left;
}
.form-inline .control-label {
    margin-bottom: 10px;
	font-size: 14px;
}

.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
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
<section class="content-header">
	<h1>PMS<small>PMS</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Employee</a></li>
		<li class="active">PMS</li>
	</ol>
</section>
<!-- Main content -->
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report">
						<!--<div class="form-group">
							<label class="col-sm-12 control-label" style="margin-bottom: 30px;background-color:#00c0ef;">Assessment Year 2020-2021</label>
							<label class="col-sm-12 control-label"><a href="{{ URL::to('/pms-objective')}}"><span class="glyphicon glyphicon-info-sign btn btn-primary btn-circle"></span> Objective Setup</a></label>
							<label class="col-sm-12 control-label"><span class="glyphicon glyphicon-info-sign"></span> Supervisor Approval</label>
							<label class="col-sm-12 control-label"><span class="glyphicon glyphicon-info-sign"></span> End Year Submission</label>
							<label class="col-sm-12 control-label"><span class="glyphicon glyphicon-info-sign"></span> End Year Assessment</label>
						</div>-->
						<label class="col-sm-12 control-label" style="margin-bottom: 30px;background-color:#658907;color:#fff;">Assessment Year 2021-2022</label>
					</form>
					<div class="stepwizard">
						<div class="stepwizard-row setup-panel">
							<div class="stepwizard-step">
								<a href="{{ URL::to('/pms-objective')}}" type="button" class="btn btn-primary btn-circle">1</a>
								<p style="font-weight:bold;">Objective Setup</p>
							</div>
							<div class="stepwizard-step">
								<a <?php if($status ==3) { ?> href="{{ URL::to('/pms-view/'.$emp_id.'/1')}}" <?php } else { ?> href="#"<?php } ?>type="button" class="btn btn-<?php echo ($status ==3) ? 'primary' : 'default'; ?> btn-circle" <?php echo ($status ==3) ? '' : 'disabled'; ?>>2</a>
								<p>Supervisor Approval</p>
							</div>
							<div class="stepwizard-step">
								<a <?php if($submission_status ==3) { ?> href="{{ URL::to('/pms-submission')}}" <?php } else { ?> href="#"<?php } ?>type="button" class="btn btn-<?php echo $submission_status ==3 ? 'primary' : 'default'; ?> btn-circle" <?php echo $submission_status ==3 ? '' : 'disabled'; ?>>3</a>
								<!--<a href="{{ URL::to('/pms-submission')}}" type="button" class="btn btn-<?php //echo $status ==2 ? 'primary' : 'default'; ?> btn-circle" <?php //echo $status ==2 ? '' : 'disabled'; ?>>3</a>-->
								<p>End Year Submission</p>
							</div>
							<div class="stepwizard-step">
								<a <?php if($complete_status ==4) { ?> href="{{ URL::to('/pms-assessment/'.$emp_id.'/1')}}" <?php } else { ?> href="#"<?php } ?>type="button" class="btn btn-<?php echo $complete_status ==4 ? 'primary' : 'default'; ?> btn-circle" <?php echo $complete_status ==4 ? '' : 'disabled'; ?>>4</a>
								<p>End Year Assessment</p>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
		<div class="col-md-12">
			<form class="form-inline report" action="{{URL::to('/pms')}}" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email">Assessment Year :</label>
					<select class="form-control" id="assessment_year" name="assessment_year" value="<?php //echo $assessment_year; ?>" required >						
						<option value="" >-Select-</option>
						<option value="1" >2020-2021</option>
						<option value="2" >2021-2022</option>
					</select>
				</div>						
				<button type="submit" class="btn btn-primary" >Search</button>
			</form>
		</div>
	</div>
	<?php if(count($all_result1) > 0) { ?>
	<?php if(!empty($employee_info)) { ?>
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
						<td><?php if(!empty($employee_designation)) { echo $employee_designation->designation_name; } ?></td>
						<td>Date of joining in present position (internal) / Date of joining after Study Leave</td>
						<td><?php echo date("d-m-Y", strtotime($employee_info->br_join_date)); ?></td>
					</tr>					
					<tr>
						<td>Grade</td>
						<td><?php  if(!empty($employee_designation)) { echo $employee_designation->grade_name; } ?></td>
						<td>Appraisal period started on</td>
						<td>01-07-2021</td>
					</tr>					
					<tr>
						<td>Step</td>
						<td><?php  if(!empty($employee_designation)) { echo $employee_designation->grade_step-1; } ?></td>
						<td>Appraisal period ended on</td>
						<td>30-06-2022</td>
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
	<?php } ?>
	<?php if(!empty($all_result1)) { ?>
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
						<td style="font-weight: bold;width:4%;text-align:center;">Score</td>
						<td style="font-weight: bold;width:4%;text-align:center;">Weighted Score</td>
						<td style="font-weight: bold;width:17%;text-align:center;">Comments (justify if score is 1,4 & 5)</td>
					</tr>
					</tr>
					<?php $i=1; $total_task_weight = 0; $total_score = 0; $total_weight_score = 0; foreach ($all_result1 as $result) { 
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
	<?php } ?>
	<?php if(!empty($all_pms_approve)) { ?>
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
					<?php $j=1; foreach ($all_c_one_item as $c_one_item) { if($c_one_item) { 
						$c_one = DB::table('tbl_pms_marks_entry as pe')
								->where('c_no', $c_one_item['c_one_value'])
								->where('emp_id', $emp_id)
								->where('year_id', $assessment_year)
								->first();
					?>
					<tr>
						<td style="text-align:center;"><?php echo $j; ?></td>
						<td><?php echo $c_one_item['c_one_detail']; ?></td>
						<td><?php if(!empty($c_one)) { echo $c_one->comments; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_one)) {echo $c_one->score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_one)) {echo $c_one->weight_score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_one)) {echo $c_one->rating; } ?></td>
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
					<?php $k=1; foreach ($all_c_two_item as $c_two_item) { if($c_two_item) { 
						$c_two = DB::table('tbl_pms_marks_entry as pe')
								->where('c_no', $c_two_item['c_two_value'])
								->where('emp_id', $emp_id)
								->where('year_id', $assessment_year)
								->first();
					?>
					<tr>
						<td style="text-align:center;"><?php echo $k; ?></td>
						<td><?php echo $c_two_item['c_two_detail']; ?></td>
						<td><?php if(!empty($c_two)) { echo $c_two->comments; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_two)) {echo $c_two->score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_two)) {echo $c_two->weight_score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_two)) {echo $c_two->rating; } ?></td>
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
					<?php $i=1; foreach ($all_c_three_item as $c_three_item) { if($c_two_item) { 
						$c_three = DB::table('tbl_pms_marks_entry as pe')
								->where('c_no', $c_three_item['c_three_value'])
								->where('emp_id', $emp_id)
								->where('year_id', $assessment_year)
								->first();
					?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $c_three_item['c_three_detail']; ?></td>
						<td><?php if(!empty($c_three)) { echo $c_three->comments; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_three)) {echo $c_three->score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_three)) {echo $c_three->weight_score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_three)) {echo $c_three->rating; } ?></td>
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
					<?php $i=1; foreach ($all_c_four_item as $c_four_item) { if($c_four_item) { 
						$c_four = DB::table('tbl_pms_marks_entry as pe')
								->where('c_no', $c_four_item['c_four_value'])
								->where('emp_id', $emp_id)
								->where('year_id', $assessment_year)
								->first();
					?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td><?php echo $c_four_item['c_four_detail']; ?></td>
						<td><?php if(!empty($c_four)) { echo $c_four->comments; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_four)) {echo $c_four->score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_four)) {echo $c_four->weight_score; } ?></td>
						<td style="text-align:center;"><?php if(!empty($c_four)) {echo $c_four->rating; } ?></td>
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
	<?php } ?>
	<?php } ?>
</section>
</div>
<script>
$(document).ready(function(){
  $("#assessment_year").val('<?php echo $assessment_year; ?>');
});
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#own_pms").addClass('active');
	});
</script>
@endsection