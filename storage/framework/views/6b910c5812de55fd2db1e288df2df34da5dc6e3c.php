
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
						<td><?php echo $employee_info->designation_name; ?></td>
						<td>Date of joining in present position (internal) / Date of joining after Study Leave</td>
						<td><?php echo date("d-m-Y", strtotime($employee_info->br_join_date)); ?></td>
					</tr>					
					<tr>
						<td>Grade</td>
						<td><?php echo $employee_info->grade_name; ?></td>
						<td>Appraisal period started on</td>
						<td>01-07-2020</td>
					</tr>					
					<tr>
						<td>Step</td>
						<td><?php echo $employee_info->grade_step-1; ?></td>
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
					<?php $total_score = 0; foreach ($all_result as $result) { $total_score += $result->task_weight;?>
					<tr>
						<td style="text-align:center;"><?php echo $result->sl_no; ?></td>
						<td><?php echo $result->assigned_task; ?></td>
						<td>-</td>
						<td style="text-align:center;"><?php echo $result->task_weight; ?></td>
						<td style="text-align:center;">-</td>
						<td style="text-align:center;">-</td>
						<td>-</td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="3" style="font-size:14px;"><center><b>Total</b></center></td>
						<td style="text-align:center;font-size:14px;"><b><?php echo $total_score; ?></b></td>
						<td style="text-align:center;">-</td>
						<td style="text-align:center;"><b>-</b></td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Weight</center></td>
						<td style="text-align:center;">60%</td>
					</tr>	
					<tr>
						<td colspan="5"><center>Total Score</center></td>
						<td style="text-align:center;">-</td>
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<form method="post" action="<?php echo e(URL::to('/pms-approve-save')); ?>" id="new_form" class="form-horizontal form-label-left">
		<?php echo e(csrf_field()); ?>

		<div class="col-md-12">
			<p style="float:left;margin-bottom: 2px;width:100%;"><b><font size="3">C: Professional, Interpersonal, Leadership and General Conduct: (Weight 40)</font></b></p>	
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.1: Professional Conduct: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<?php 
					//$task_detail_c1 = DB::table('tbl_task_detail')->where('c_no', 1)->where('status', 1)->get();
					//foreach ($task_detail_c1 as $task_detailc1) {
					?>
					<tr>
						<td style="border:none;"><input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>" />
						<input type="checkbox" name="professional[]" value="1" style="margin-left:10px;margin-right:30px;"/> Responsiveness</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="professional[]" value="2" style="margin-left:10px;margin-right:30px;"/> Analytical Capacity</td>
					</tr>
					<tr>	
						<td style="border:none;"><input type="checkbox" name="professional[]" value="3" style="margin-left:10px;margin-right:30px;"/> Understanding of assigned/planned task</td>
					</tr>
					<?php //} ?>
					<tr>
						<td style="border:none;"><input type="checkbox" name="professional[]" value="4" style="margin-left:10px;margin-right:30px;"/> Time management</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="professional[]" value="5" style="margin-left:10px;margin-right:30px;"/> Priority setting</td>
					</tr>
					<tr>	
						<td style="border:none;"><input type="checkbox" name="professional[]" value="6" style="margin-left:10px;margin-right:30px;"/> Works independently</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="professional[]" value="7" style="margin-left:10px;margin-right:30px;"/> Creativity & innovation</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="professional[]" value="8" style="margin-left:10px;margin-right:30px;"/> Develop & train staff (if applicable)</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="professional[]" value="9" style="margin-left:10px;margin-right:30px;"/> Supervise staff (if any)</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="professional[]" value="10" style="margin-left:10px;margin-right:30px;"/> Strategic thinking & application (if relevant)</td>
					</tr>				
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.2: Interpersonal Skills: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr>
						<td style="border:none;"><input type="checkbox" name="interpersonal[]" value="11" style="margin-left:10px;margin-right:30px;"/> Verbal communication</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="interpersonal[]" value="12" style="margin-left:10px;margin-right:30px;"/> Written communication</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="interpersonal[]" value="13" style="margin-left:10px;margin-right:30px;"/> Stakeholder management</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="interpersonal[]" value="14" style="margin-left:10px;margin-right:30px;"/> Listening skills and responsiveness</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="interpersonal[]" value="15" style="margin-left:10px;margin-right:30px;"/> Ability to negotiate (if applicable)</td>
					<tr>	
					</tr>	
						<td style="border:none;"><input type="checkbox" name="interpersonal[]" value="16" style="margin-left:10px;margin-right:30px;"/> Team work</td>
					</tr>				
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.3: Leadership Skills: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr>
						<td style="border:none;"><input type="checkbox" name="leadership[]" value="17" style="margin-left:10px;margin-right:30px;"/> Delegation of authority</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="leadership[]" value="18" style="margin-left:10px;margin-right:30px;"/> Problem solving and decision making</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="leadership[]" value="19" style="margin-left:10px;margin-right:30px;"/> Respectful towards others</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="leadership[]" value="20" style="margin-left:10px;margin-right:30px;"/> Ability to motivate and inspire</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="leadership[]" value="21" style="margin-left:10px;margin-right:30px;"/> Result oriented</td>
					</tr>
					<tr>	
						<td style="border:none;"><input type="checkbox" name="leadership[]" value="22" style="margin-left:10px;margin-right:30px;"/> Capacity to take higher responsibility</td>
					</tr>				
				</tbody>
			</table>
			<p style="float:left;margin-bottom: 2px;margin-left: 50px;"><b><font size="2">C.4: General Conduct: (10)</font></b></p>	
			<table style="margin-left: 80px;" class="table" cellspacing="0">
				<tbody>
					<tr>
						<td style="border:none;"><input type="checkbox" name="general[]" value="23" style="margin-left:10px;margin-right:30px;"/> Abide by rules and regulations</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="general[]" value="24" style="margin-left:10px;margin-right:30px;"/> Attitude towards job/tasks</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="general[]" value="25" style="margin-left:10px;margin-right:30px;"/> Mannerism/office decorum</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="general[]" value="26" style="margin-left:10px;margin-right:30px;"/> Cost consciousness</td>
					</tr>
					<tr>
						<td style="border:none;"><input type="checkbox" name="general[]" value="27" style="margin-left:10px;margin-right:30px;"/> Reliability / confidentiality</td>
					</tr>	
					<tr>	
						<td style="border:none;"><input type="checkbox" name="general[]" value="28" style="margin-left:10px;margin-right:30px;"/> Willingness to take additional responsibility</td>
					</tr>				
				</tbody>
			</table>
		</div>
		<div class="col-md-12">
			<button type="submit" id="submit" class="btn btn-success pull-right"> Approve</button>
		</div>
		</form>
	</div>
</section>
<script>
$("#new_form").on("submit", function () {
    $(this).find(":submit").prop("disabled", true);
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