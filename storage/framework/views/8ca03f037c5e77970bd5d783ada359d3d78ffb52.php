
<?php $__env->startSection('title', 'Covid-Nineteen'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
}
.required {
    color: red;
    font-size: 14px;
}
.col-sm-2, .col-sm-1 {
	padding-left: 6px;
}
</style>
<br/>
<br/>
<section class="content-header">
	<h1><small>Covid-19 Info</small></h1>
</section>
<section class="content">	
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>" >
			<?php echo e(csrf_field()); ?>

			<?php echo $method_field; ?>

			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label class="col-sm-2 control-label">Employee Type <span class="required">*</span></label>
						<div class="col-sm-2">
							<select name="emp_type" id="emp_type" onChange="get_employee_info();" required class="form-control">
								<?php $__currentLoopData = $all_emp_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_type1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($emp_type1->id); ?>"><?php echo e($emp_type1->type_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<label class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="emp_id" value="<?php echo e($emp_id); ?>" id="emp_id" onChange="get_employee_info();" required>
						</div>
						<label class="col-sm-2 control-label">Effect Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" name="entry_date" class="form-control entry_date" value="<?php echo e($entry_date); ?>" required>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="emp_name" value="<?php echo e($emp_name); ?>" readonly >							
						</div>
						<label class="col-sm-2 control-label">Designation <span class="required">*</span></label>
						<div class="col-sm-2">
							<select class="form-control" name="designation_code" id="designation_code" style="pointer-events:none;" readonly >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($designation->designation_code); ?>"><?php echo e($designation->designation_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<label class="col-sm-2 control-label">Branch <span class="required">*</span></label>
						<div class="col-sm-2">
							<select class="form-control" name="br_code" id="br_code" style="pointer-events:none;" readonly >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-2 control-label">Comments <span class="required">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="comments" name="comments" value="<?php echo e($comments); ?>" >							
						</div>
					</div>						
				</div>
				<div class="box-footer">
					<a href="<?php echo e(URL::to('/covid-nineteen')); ?>" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" ><?php echo e($button_text); ?></button>
				</div>
			</div>
			</form>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.entry_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	document.getElementById("designation_code").value="<?php echo e($designation_code); ?>";
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
	document.getElementById("emp_type").value="<?php echo e($emp_type); ?>";
	
});
</script>
<script type="text/javascript">		
	function get_employee_info() {
		var emp_id = $("#emp_id").val();	
		var emp_type = $("#emp_type").val();	
		//alert (emp_id);
		$.ajax({
			url : "<?php echo e(url::to('get-emp-info')); ?>"+"/"+ emp_id +"/"+ emp_type,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
				} else {
					//document.getElementById("emp_id").value=data.emp_id;
					document.getElementById("emp_name").value=data.emp_name;
					document.getElementById("br_code").value=data.br_code;
					document.getElementById("designation_code").value=data.designation_code;
					//document.getElementById("emp_type").value=emp_type;
				}
				//alert (data.br_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});
	}	
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupOthers").addClass('active');
			$("#Covid-19").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>