
<?php $__env->startSection('title', 'Permanent'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Permanent</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Permanent</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> <?php echo e($Heading); ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				<form id="form" class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>	
				<input type="hidden" id="id" name="id" value="<?php echo e($id); ?>">
				<input type="hidden" id="sarok_no" name="sarok_no" value="<?php echo e($sarok_no); ?>">
				<input type="hidden" id="action_table" name="action_table" value="<?php echo e($action_table); ?>">
				<input type="hidden" id="action_controller" name="action_controller" value="<?php echo e($action_controller); ?>">
				<input type="hidden" id="transection_type" name="transection_type" value="<?php echo e($transection_type); ?>">
				<input type="hidden" id="br_joined_date" name="br_joined_date" value="<?php echo e($br_joined_date); ?>">
				<input type="hidden" id="is_permanent" name="is_permanent" value="<?php echo e($is_permanent); ?>">
				<input type="hidden" id="grade_code_old" name="grade_code_old" value="<?php echo e($grade_code_old); ?>">
				<input type="hidden" id="grade_effect_date" name="grade_effect_date" value="<?php echo e($grade_effect_date); ?>">
				
				<div class="box-body col-md-9">
					
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3 <?php echo e($errors->has('emp_id') ? ' has-error' : ''); ?>">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>" onChange="get_employee_info();" required>
							<?php if($errors->has('emp_id')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('emp_id')); ?></strong>
								</span>
							<?php endif; ?>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Letter Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="letter_date" name="letter_date" value="<?php echo e($letter_date); ?>" onChange="get_employee_info();" required>
							
						</div>
					</div>
					<hr>

					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Effect Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="effect_date" name="effect_date" value="<?php echo e($effect_date); ?>" required>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Working Station <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="br_code" name="br_code" required>						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						
						<label for="zone_code" class="col-sm-2 control-label">Select Grade <span class="required">*</span> </label>
						<div class="col-sm-3">
							<select class="form-control" style="width: 100%;" id="grade_code" name="grade_code" required>						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_grades): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_grades->grade_code); ?>"><?php echo e($v_grades->grade_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Grade Step <span class="required">*</span> </label>
						<div class="col-sm-3">
							<select class="form-control" id="grade_step" name="grade_step" required>						
								<option value="" hidden>-SELECT-</option>
								<?php if($status == 0) { ?>
								<option value="0">	N/A </option>
								<?php }  ?>
								<option value="1">	STEP : 00 </option>
								<option value="2">	STEP : 01 </option>
								<option value="3">	STEP : 02 </option>
								<option value="4">	STEP : 03 </option>
								<option value="5">	STEP : 04 </option>
								<option value="6">	STEP : 05 </option>
								<option value="7">	STEP : 06 </option>
								<option value="8">	STEP : 07 </option>
								<option value="9">	STEP : 08 </option>
								<option value="10">	STEP : 09 </option>
								<option value="11">	STEP : 10 </option>
								<option value="12">	STEP : 11 </option>
								<option value="13">	STEP : 12 </option>
								<option value="14">	STEP : 13 </option>
								<option value="15">	STEP : 14 </option>
								<option value="16">	STEP : 15 </option>
								<option value="17">	STEP : 16 </option>
								<option value="18">	STEP : 17 </option>
								<option value="19">	STEP : 18 </option>
								<option value="20">	STEP : 19 </option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Select Department <span class="required">*</span> </label>
						<div class="col-sm-3">
							<select class="form-control" style="width: 100%;" id="department_code" name="department_code" required>						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_departments->id); ?>"><?php echo e($v_departments->department_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Select Designation <span class="required">*</span> </label>
						<div class="col-sm-3">
							<select class="form-control" style="width: 100%;" id="designation_code" name="designation_code" required>						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_designation->designation_code); ?>"><?php echo e($v_designation->designation_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Reported To</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="report_to" id="report_to" value="" readonly>
						</div>
						<label for="zone_code" class="col-sm-2 control-label"> Next Increment Date <span class="required">*</span> </label>
						<div class="col-sm-3">
							<input type="date" class="form-control" name="next_increment_date" id="next_increment_date" value="<?php echo e($next_increment_date); ?>">
						</div>
					</div>
					<div class="form-group">					
						<label for="status" class="col-sm-2 control-label">Activation Staus </label>
						<div class="col-sm-3">
							<select name="status" id="status" class="form-control" required>
								<option value="1">New Active</option>
								<option value="0">Old Active</option>
								<option value="2">Cancel</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="col-sm-3">
							<button type="reset" class="btn btn-default">Cancel</button>
							<button type="submit" id="submit" class="btn btn-danger"><?php echo e($button_text); ?></button>
						</div>
					</div>					
				</div>				
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('public/employee/'.$emp_photo)); ?>" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
							<p class="text-muted text-center" id="designation_name"><?php echo e($designation_name); ?></p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Joining Date : </b><span id="joining_date"> <?php echo e($joining_date); ?></span>
								</li>
								<li class="list-group-item">
									<b>Working Station : </b><span id="branch_name"> <?php echo e($branch_name); ?> </span>
								</li>
							</ul>
							<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</section>
	
	<script>
		$(document).ready(function() {
			var button_text = document.getElementById("submit").innerHTML;
			if(button_text == 'Save')
			{
				$('#emp_id').removeAttr('disabled');
				$('#submit').attr("disabled", true);
			}
			else
			{
				$('#emp_id').attr("disabled", true);
				$('#submit').removeAttr('disabled');
			}
			document.getElementById("designation_code").value = '<?php echo e($designation_code); ?>';
			document.getElementById("br_code").value = '<?php echo e($br_code); ?>';
			document.getElementById("grade_code").value = '<?php echo e($grade_code); ?>';
			document.getElementById("grade_code_old").value = '<?php echo e($grade_code); ?>';
			document.getElementById("grade_step").value = '<?php echo e($grade_step); ?>';
			document.getElementById("department_code").value = '<?php echo e($department_code); ?>';
			document.getElementById("designation_name").innerHTML = '<?php echo e($designation_name); ?>';
			document.getElementById("branch_name").innerHTML = '<?php echo e($branch_name); ?>';
			document.getElementById("report_to").value = '<?php echo e($report_to); ?>';
			document.getElementById("status").value = '<?php echo e($status); ?>';
		})
		
		function get_employee_info()
		{
			var emp_id = document.getElementById("emp_id").value;
			var letter_date = document.getElementById("letter_date").value;
			$.ajax({
				url : "<?php echo e(url::to('get-employee-info')); ?>"+"/"+ emp_id +"/"+ letter_date,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					if(data.emp_name)
					{
						if(data.resign_date < letter_date)
						{
							$('#employee_status').html('<b>This Employee Terminated</b>');
							$("#employee_status").removeClass("btn btn-primary btn-block");
							$("#employee_status").addClass("btn btn-danger btn-block");
							$('#submit').attr("disabled", true);
						}
						else if(data.is_permanent == 2)
						{
							$('#employee_status').html('<b>This Employee Already Permanent</b>');
							$("#employee_status").removeClass("btn btn-primary btn-block");
							$("#employee_status").addClass("btn btn-danger btn-block");
							$('#submit').attr("disabled", true);
						}
						else
						{
							$('#employee_status').html('<b>Active Employee</b>');
							$("#employee_status").removeClass("btn btn-danger btn-block");
							$("#employee_status").addClass("btn btn-primary btn-block");
							$('#submit').removeAttr('disabled');
						}
						$('[name="emp_id"]').val(data.emp_id);
						$('#emp_name').html(data.emp_name);
						$('#joining_date').html(data.joining_date);
						$('#br_joined_date').val(data.br_join_date);
						$('#designation_code').val(data.designation_code);
						$('#designation_name').html(data.designation_name);
						$('#branch_name').html(data.branch_name);
						$('#br_code').val(data.br_code);
						$('#department_code').val(data.department_code);
						$('#report_to').val(data.report_to);
						$('#probation_time').val(data.probation_time);
						$('#grade_code').val(data.grade_code);
						$('#grade_code_old').val(data.grade_code);
						$('#grade_effect_date').val(data.grade_effect_date);
						$('#grade_step').val(data.grade_step);
						document.getElementById("emp_photo").src = "<?php echo asset('public/employee/"+data.emp_photo+"'); ?>";
							
					}
					else
					{
						$('#form').trigger("reset");
						$('[name="emp_id"]').val(data.emp_id);
						document.getElementById("emp_photo").src = "<?php echo asset('public/employee/"+data.emp_photo+"'); ?>";
						$('#emp_name').html('');
						$('#joining_date').html('');
						$('#branch_name').html('');
						$('#designation_name').html(data.designation_name);
						$('#employee_status').html('<b>Employee is not Available</b>');
						$("#employee_status").removeClass("btn btn-primary btn-block");
						$("#employee_status").addClass("btn btn-danger btn-block");
						$('#submit').attr("disabled", true);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#employee_status').html('This Employee is not Available');
					$('#submit').attr("disabled", true);
				}
			});
		}
			
	</script>
	<script>
		//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Permanent").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>