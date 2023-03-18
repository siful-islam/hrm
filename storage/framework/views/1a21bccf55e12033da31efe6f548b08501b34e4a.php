
<?php $__env->startSection('title', 'Manage Zone'); ?>
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

				
				<input type="hidden" id="zone_id" name="zone_id" value="<?php echo e($zone_id); ?>" >
				
				<div class="box-body">
					
					
					<div class="form-group">
						<label for="zone_name" class="col-sm-2 control-label">Zone Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="zone_name" name="zone_name" value="<?php echo e($zone_name); ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Zone Code </label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="zone_code" name="zone_code" value="<?php echo e($zone_code); ?>" required>
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
	document.getElementById("status").value=<?php echo e($status); ?>;
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Zone").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>