<?php $__env->startSection('main_content'); ?>
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
<?php $login_emp_id = Session::get('emp_id'); ?>
<section class="content">	
	<!--<div class="row">
		<div class="col-md-12">	
			<table class="table table-bordered" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;text-align:center;">Total Staff</td>
						<td style="font-weight: bold;text-align:center;">Objective Submitted</td>
						<td style="font-weight: bold;text-align:center;">1st Supervisor Approved</td>
						<?php //if($assessment_year == 2) { ?>
						<td style="font-weight: bold;text-align:center;">2nd Supervisor Approved</td>
						<?php //} ?>
						<td style="font-weight: bold;text-align:center;">End Year Submitted</td>
						<td style="font-weight: bold;text-align:center;">Assessment Completed</td>
					</tr>					
					<tr>
						<td style="text-align:center;"><?php //echo count($pms_staff_status); ?></td>
						<td style="text-align:center;"><?php //echo count($pms_submitted); ?></td>
						<td style="text-align:center;"><?php //echo count($pms_approved); ?></td>
						<?php //if($assessment_year == 2) { ?>
						<td style="text-align:center;"><?php //echo count($pmsapproved); ?></td>
						<?php //} ?>
						<td style="text-align:center;"><?php //echo count($pms_submission); ?></td>
						<td style="text-align:center;"><?php //echo count($pms_submission_complete); ?></td>
					</tr>			
				</tbody>
			</table>
		</div>		
	</div>-->
	<div class="row">
		<div class="col-md-12">
			<p style="float:left;margin-bottom: 2px;"><b><font size="3">Submitted for Action</font></b></p>	
			<table class="table table-bordered" cellspacing="0">
				<tbody>
					<tr style="background-color:lightgray;">
						<td style="font-weight: bold;padding:9px;width:15%;text-align:center;">Sl. No.</td>
						<td style="font-weight: bold;width:15%;text-align:center;">Employee ID</td>
						<td style="font-weight: bold;width:20%;text-align:center;">Employee Name</td>
						<td style="font-weight: bold;width:20%;text-align:center;">Designation</td>
						<td style="font-weight: bold;width:15%;text-align:center;">Action Required</td>
						<td style="font-weight: bold;width:15%;text-align:center;">Details</td>
					</tr>
					<?php $i = 1; if(!empty($all_result)) { foreach ($all_result as $result) { 
					if($super_visor_type == 3) {
					if((($login_emp_id == $result->super_visorid) && ($login_emp_id != $result->sub_super_visorid) && ($result->status == 3)) || (($login_emp_id != $result->super_visorid) && ($login_emp_id == $result->sub_super_visorid) && ($result->status == 1))) {
					?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td style="text-align:center;"><?php echo $result->emp_id; ?></td>
						<td><?php echo $result->emp_name_eng; ?></td>
						<?php $empid = $result->emp_id; $letter_date = date('Y-m-d');
						$max_sarok_designation = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $empid)
										->where('m.letter_date', '=', function($query) use ($empid, $letter_date)
											{
												$query->select(DB::raw('max(letter_date)'))
													  ->from('tbl_master_tra')
													  ->where('emp_id',$empid)
													  ->where('effect_date', '<=', $letter_date);
											})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();
						$designation = DB::table('tbl_master_tra as m')
										->leftjoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
										->where('m.sarok_no', $max_sarok_designation->sarok_no)
										->where('m.status', 1)
										->select('d.designation_name')
										->first();
						
						?>
						<td><?php echo $designation->designation_name; ?></td>
						<td style="text-align:center;">Supervisor Approval</td>
						<td style="text-align:center;"><a href="<?php echo e(URL::to('/pms-view/'.$result->emp_id.'/2')); ?>" class="btn btn-primary btn-sm" id="View" title="View" >View</a></td>
					</tr>
					<?php } } else { ?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td style="text-align:center;"><?php echo $result->emp_id; ?></td>
						<td><?php echo $result->emp_name_eng; ?></td>
						<?php $empid = $result->emp_id; $letter_date = date('Y-m-d');
						$max_sarok_designation = DB::table('tbl_master_tra as m')
										->where('m.emp_id', '=', $empid)
										->where('m.letter_date', '=', function($query) use ($empid, $letter_date)
											{
												$query->select(DB::raw('max(letter_date)'))
													  ->from('tbl_master_tra')
													  ->where('emp_id',$empid)
													  ->where('effect_date', '<=', $letter_date);
											})
										->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
										->groupBy('emp_id')
										->first();
						$designation = DB::table('tbl_master_tra as m')
										->leftjoin('tbl_designation as d', 'm.designation_code', '=', 'd.designation_code')
										->where('m.sarok_no', $max_sarok_designation->sarok_no)
										->where('m.status', 1)
										->select('d.designation_name')
										->first();
						
						?>
						<td><?php echo $designation->designation_name; ?></td>
						<td style="text-align:center;">Supervisor Approval</td>
						<td style="text-align:center;"><a href="<?php echo e(URL::to('/pms-view/'.$result->emp_id.'/2')); ?>" class="btn btn-primary btn-sm" id="View" title="View" >View</a></td>
					</tr>
					<?php  $i++; } } } ?>					
				</tbody>
			</table>
		</div>
		<div class="col-md-12">
			<form class="form-inline report" action="<?php echo e(URL::to('/pms-supervisor')); ?>" method="post">
				<?php echo e(csrf_field()); ?>

				<div class="form-group">
					<label for="email">Assessment Year :</label>
					<select class="form-control" id="assessment_year" name="assessment_year" value="<?php echo $assessment_year; ?>" required >						
						<option value="" >-Select-</option>
						<option value="1" >2020-2021</option>
						<option value="2" >2021-2022</option>
					</select>
				</div>	
				<div class="form-group">
					<label for="email">Search by Staff ID :</label>
					<input type="text" id="emp_id" class="form-control" name="emp_id" value="<?php echo $emp_id; ?>" required>
				</div>						
				<button type="submit" class="btn btn-primary" >Search</button>
			</form>
		</div>
	</div>
	<br/>
	<br/>
	<?php if($count_id == 0) {	
	} else { ?>
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
	<?php } else { ?>
	<h3 style="color:red;text-align:center;">"You are not authorized to view this PMS"</h3>
	<?php } ?>
	<?php } ?>
</section>
<script>assessment_year
$(document).ready(function(){
  $("#assessment_year").val('<?php echo $assessment_year; ?>');

});
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#team_pms").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>