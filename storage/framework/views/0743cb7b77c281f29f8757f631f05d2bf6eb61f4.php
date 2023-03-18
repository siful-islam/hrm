<?php $__env->startSection('title', 'Add Branch'); ?>
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
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
			
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				
				<input type="hidden" id="id" name="br_id" value="<?php echo e($br_id); ?>" >
				
				<div class="box-body">
					
					<div class="form-group">
						<label for="area_code" class="col-sm-2 control-label">Select Area </label>
						<div class="col-sm-4">
						<select class="form-control" id="area_code" name="area_code" required>						
							<option value="" hidden>-SELECT-</option>
							<?php $__currentLoopData = $all_areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_all_areas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_all_areas->area_code); ?>"><?php echo e($v_all_areas->area_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="branch_name" class="col-sm-2 control-label">Branch Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo e($branch_name); ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="br_name_bangla" class="col-sm-2 control-label">Branch Name (Bangla) </label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="br_name_bangla" name="br_name_bangla" value="<?php echo e($br_name_bangla); ?>" >
						</div>
					</div>
					
					<div class="form-group">
						<label for="br_code" class="col-sm-2 control-label">Branch Code</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="br_code" name="br_code" value="<?php echo e($br_code); ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="branch_contact_no" class="col-sm-2 control-label">Branch Contact</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="branch_contact_no" name="branch_contact_no" value="<?php echo e($branch_contact_no); ?>" >
						</div>
					</div>
					
					<div class="form-group">
						<label for="branch_email" class="col-sm-2 control-label">Branch Email</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="branch_email" name="branch_email" value="<?php echo e($branch_email); ?>" >
						</div>
					</div>
					
					<div class="form-group">
						<label for="branch_address" class="col-sm-2 control-label">Branch Address</label>
						<div class="col-sm-4">
							<textarea class="form-control" id="branch_address" name="branch_address" ><?php echo e($branch_address); ?></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="start_date" class="col-sm-2 control-label">Start Date</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e($start_date); ?>" >
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Staus</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>
								<option value="1">Active</option>
								<option value="0">Drop</option>
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
	document.getElementById("area_code").value=<?php echo e($area_code); ?>;
	document.getElementById("status").value=<?php echo e($status); ?>;
	</script>
	
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Branch").addClass('active');
		});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>