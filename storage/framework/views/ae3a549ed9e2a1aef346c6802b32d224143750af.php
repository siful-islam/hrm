
<?php $__env->startSection('title', 'Manage Salary Plus'); ?>
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Salary Items<small>Plus</small></h1>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> <?php echo e($Heading); ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->				
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				<?php echo $method_control; ?>

				<input type="hidden" id="id" name="id" value="<?php echo e($id); ?>" >
				<div class="box-body">
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Plus Item's Name</label>
						<div class="col-sm-4">
							<select class="form-control" id="item_name" name="item_name" required>
								<option value="" hidden>-SELECT ITEMS-</option>
								<?php foreach($plus_items as $plus_item) { ?>
								<option value="<?php echo $plus_item->item_id; ?>"><?php echo $plus_item->items_name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="type" class="col-sm-2 control-label">Type</label>
						<div class="col-sm-4">
							<select name="type" id="type" class="form-control" onchange="set_data();" required>							
								<option value="1">Percentage % </option>
								<option value="2">Fixed Amount</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Percentage %</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="percentage" name="percentage" value="<?php echo e($percentage); ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Fixed Amount</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="fixed_amount" name="fixed_amount" value="<?php echo e($fixed_amount); ?>" required readOnly>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Head Office/Branch</label>
						<div class="col-sm-4">
							<select name="ho_bo" id="ho_bo" class="form-control" required>							
								<option value="0">HO</option>
								<option value="1">BO</option>
								<option value="3">N/A</option>
								<option value="2">Both</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Designation</label>
						<div class="col-sm-4">
							<select name="designation_for" id="designation_for" class="form-control" required>							
								<option value="0">All</option>
								<?php foreach($designation as $v_designation) { ?>
								<option value="<?php echo $v_designation->designation_code; ?>"><?php echo $v_designation->designation_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Department</label>
						<div class="col-sm-4">
							<select name="emp_department" id="emp_department" class="form-control" required>							
								<option value="0">All</option>
								<?php foreach($departments as $department) { ?>
								<option value="<?php echo $department->id; ?>"><?php echo $department->department_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Grade</label>
						<div class="col-sm-4">
							<select name="emp_grade" id="emp_grade" class="form-control" required>							
								<option value="0">All</option>
								<?php foreach($grades as $grade) { ?>
								<option value="<?php echo $grade->grade_code; ?>"><?php echo $grade->grade_name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Employee Type</label>
						<div class="col-sm-4">
							<select name="epmloyee_status" id="epmloyee_status" class="form-control" required>							
								<option value="0">All</option>
								<option value="1">Probation</option>
								<option value="2">Permanent</option>
								<option value="3">Masterroll</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Effect From</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="active_from" name="active_from" value="<?php echo e($active_from); ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Effect To</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="active_upto" name="active_upto" value="<?php echo e($active_upto); ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>							
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info"><?php echo e($button_text); ?></button>
				</div>
				<!-- /.box-footer -->
			</form>
		</div>
	</section>	
	<script>
		document.getElementById("type").value = '<?php echo e($type); ?>';
		document.getElementById("item_name").value = '<?php echo e($item_name); ?>';
		document.getElementById("status").value = '<?php echo e($status); ?>';
		document.getElementById("ho_bo").value = '<?php echo e($ho_bo); ?>';
		document.getElementById("designation_for").value = '<?php echo e($designation_for); ?>';
		document.getElementById("emp_department").value = '<?php echo e($emp_department); ?>';
		document.getElementById("emp_grade").value = '<?php echo e($emp_grade); ?>';
		document.getElementById("epmloyee_status").value = '<?php echo e($epmloyee_status); ?>';
	</script>
	<script>
		function set_data()
		{
			var type = document.getElementById("type").value;
			if(type == 1)
			{
				document.getElementById("fixed_amount").value = 0;
				document.getElementById("fixed_amount").readOnly = true;
				document.getElementById("percentage").readOnly = false;
			}
			if(type == 2)
			{
				document.getElementById("percentage").value = 0;
				document.getElementById("percentage").readOnly = true;
				document.getElementById("fixed_amount").readOnly = false;
			}
		}
		function abc()
		{
			var type = document.getElementById("type").value;
			if(type == 1)
			{
				document.getElementById("fixed_amount").value = 0;
				document.getElementById("fixed_amount").readOnly = true;
				document.getElementById("percentage").readOnly = false;
			}
			if(type == 2)
			{
				document.getElementById("percentage").value = 0;
				document.getElementById("percentage").readOnly = true;
				document.getElementById("fixed_amount").readOnly = false;
			}
		}
		abc();
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Salary_Plus").addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>