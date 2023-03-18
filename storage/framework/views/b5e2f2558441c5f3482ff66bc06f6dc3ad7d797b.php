
<?php $__env->startSection('title', 'Transfer'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Transfer</small></h1>
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
				<input type="hidden" id="next_increment_date" name="next_increment_date" value="<?php echo e($next_increment_date); ?>">				
				<input type="hidden" id="is_permanent" name="is_permanent" value="<?php echo e($is_permanent); ?>">	
				<input type="hidden" id="grade_code" name="grade_code" value="<?php echo e($grade_code); ?>">				
				<input type="hidden" id="grade_step" name="grade_step" value="<?php echo e($grade_step); ?>">	
				<input type="hidden" id="grade_effect_date" name="grade_effect_date" value="<?php echo e($grade_effect_date); ?>">	
				<input type="hidden" id="effect_date" name="effect_date" value="<?php echo e($effect_date); ?>">	
				<input type="hidden" id="designation_code_old" name="designation_code_old" value="<?php echo e($designation_code); ?>">	
				
				<div class="box-body col-md-7">					
					<div class="form-group">
						<label for="zone_code" class="col-sm-3 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3 <?php echo e($errors->has('emp_id') ? ' has-error' : ''); ?>">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>" onChange="get_employee_info();" required>
							<?php if($errors->has('emp_id')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('emp_id')); ?></strong>
								</span>
							<?php endif; ?>
						</div>
						<label for="zone_code" class="col-sm-3 control-label">Letter Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="letter_date" name="letter_date" value="<?php echo e($letter_date); ?>" onChange="get_employee_info();" required>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="zone_code" class="col-sm-3 control-label"> Branch Joining Date <span class="required">*</span> </label>
						<div class="col-sm-3">
							<input type="date" class="form-control" name="br_joined_date" id="br_joined_date" value="<?php echo e($br_joined_date); ?>" onchange="set_date();">
						</div>
						
						<label for="zone_code" class="col-sm-3 control-label">Transferred Branch <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="br_code" name="br_code" required onchange="set_salary_br();">						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					
					<div class="form-group">

						<label for="zone_code" class="col-sm-3 control-label">Select Department <span class="required">*</span> </label>
						<div class="col-sm-3">
							<select class="form-control" style="width: 100%;" id="department_code" name="department_code" required>						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_departments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_departments->id); ?>"><?php echo e($v_departments->department_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<label for="zone_code" class="col-sm-3 control-label">Select Designation <span class="required">*</span> </label>
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
						<label for="zone_code" class="col-sm-3 control-label">Reported To <span class="required">*</span> </label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="report_to" id="report_to" value="<?php echo e($report_to); ?>">
						</div>
						<label for="zone_code" class="col-sm-3 control-label">Remarks </label>
						<div class="col-sm-3">
							<select class="form-control" style="width: 100%;" id="remarks" name="remarks">						
								<option value="" hidden>-SELECT-</option>
								<?php $__currentLoopData = $transfer_remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_transfer_remarks): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_transfer_remarks->id); ?>"><?php echo e($v_transfer_remarks->remarks_note); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>					
					<div class="form-group">
						<label for="zone_code" class="col-sm-3 control-label">Comments <span class="required">*</span> </label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="comments" id="comments" value="<?php echo e($comments); ?>">
						</div>
					</div>
					<div class="form-group">					
						<label for="status" class="col-sm-3 control-label">Salary Branch </label>
						<div class="col-sm-3">
							<select class="form-control" name="salary_br_code" id="salary_br_code" required>
								<option value="">-SELECT-</option>
								<?php foreach($branches as $branch) { ?>
								<option value="<?php echo $branch->br_code; ?>"><?php echo $branch->branch_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<label for="status" class="col-sm-3 control-label">Activation Status </label>
						<div class="col-sm-3">
							<select name="status" id="status" class="form-control" required>
								<option value="1">New Active</option>
								<option value="2">Cancel</option>
								<option value="0">Old Active</option>
							</select>
						</div>
					</div>
					<hr>
					
					<?php if($id == '') { ?>
					<div class="form-group">
						<div class="col-sm-3">
							<button type="reset" class="btn btn-default">Cancel</button>
							<button type="submit" id="submit" class="btn btn-danger"><?php echo e($button_text); ?></button>
						</div>
					</div>
					<?php } ?>
					
				</div>	
				
				<div class="col-md-5">
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
						<div>
							<center>
								<button type="button" class="btn btn-warning" id="all" onclick="get_transfer('all');">Show Transfer History</button>
							</center>
							<br>
							<div>
							<table class="table table-bordered table-striped" id="transfer_history" border="1">
								
							</table>
							</div>
						</div>				
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
				<!-- /.box-footer -->
			</form>
			
			
			<?php echo $salary_br_code; ?>
			
			
			
			
			
		</div>
	</section>
	<script>
			$(document).ready(function() {

			document.getElementById("designation_code").value = '<?php echo e($designation_code); ?>';
			document.getElementById("br_code").value = '<?php echo e($br_code); ?>';
			document.getElementById("salary_br_code").value = '<?php echo e($salary_br_code); ?>';
			document.getElementById("grade_code").value = '<?php echo e($grade_code); ?>';
			document.getElementById("grade_step").value = '<?php echo e($grade_step); ?>';
			document.getElementById("grade_effect_date").value = '<?php echo e($grade_effect_date); ?>';
			document.getElementById("next_increment_date").value = '<?php echo e($next_increment_date); ?>';
			document.getElementById("effect_date").value = '<?php echo e($effect_date); ?>';
			document.getElementById("department_code").value = '<?php echo e($department_code); ?>';
			document.getElementById("designation_name").innerHTML = '<?php echo e($designation_name); ?>';
			document.getElementById("branch_name").innerHTML = '<?php echo e($branch_name); ?>';
			document.getElementById("report_to").value = '<?php echo e($report_to); ?>';
			document.getElementById("status").value = '<?php echo e($status); ?>';
			document.getElementById("remarks").value = '<?php echo e($remarks); ?>';
			document.getElementById("designation_code_old").value = '<?php echo e($designation_code); ?>';
			
						
			
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
						var id = document.getElementById("id").value;
						if(id !='')
						{
							$('#br_joined_date').val(data.joining_date);
						}
						$('#designation_code').val(data.designation_code);
						$('#designation_name').html(data.designation_name);
						$('#branch_name').html(data.branch_name);
						$('#salary_br_code').val(data.salary_br_code);
						//$('#br_code').val(data.br_code);
						$('#department_code').val(data.department_code);
						$('#report_to').val(data.report_to);
						$('#probation_time').val(data.probation_time);
						$('#grade_code').val(data.grade_code);
						$('#grade_step').val(data.grade_step);
						$('#grade_effect_date').val(data.grade_effect_date);
						$('#next_increment_date').val(data.next_increment_date);
						$('#effect_date').val(data.effect_date);
						$('#is_permanent').val(data.is_permanent);
						$('#designation_code_old').val(data.designation_code);
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
		
		function get_transfer(val)
		{
			var emp_id = document.getElementById("emp_id").value;
			//alert(emp_id);
			$.ajax({
				url : "<?php echo e(url::to('get-transfer-info')); ?>"+"/"+ emp_id +"/"+ val,
				type: "GET",
				success: function(data)
				{
					//alert(data);
					//$("#upazila_id").attr("disabled", false);
					$("#transfer_history").html(data); 
					//$("#upazi_name").html(data); 
				}
			}); 
		}
		
		function set_salary_br()
		{
			var br_code = document.getElementById("br_code").value;
			document.getElementById("salary_br_code").value = br_code;
		}
		
	</script>
	<script>
		//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Transfer").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>