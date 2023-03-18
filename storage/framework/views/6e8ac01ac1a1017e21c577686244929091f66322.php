<?php $__env->startSection('title', 'Manage Area'); ?>
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
			
				<?php 
				/*$access_label 	= Session::get('admin_access_label');
				$permission    	= DB::table('tbl_user_permissions')
									->where('user_role_id',$access_label)
									->where('nav_id',7)
									->where('status',1)
									->get();
									
									
				print_r($permission);*/
				?>
			
			
			
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				
				<input type="hidden" id="id" name="id" value="<?php echo e($id); ?>" >
				
				<div class="box-body">
					
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Select Zone </label>
						<div class="col-sm-4">
						<select class="form-control" id="zone_code" name="zone_code" required>						
							<option value="" hidden>-SELECT-</option>
							<?php $__currentLoopData = $all_zone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_all_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_all_zone->zone_code); ?>"><?php echo e($v_all_zone->zone_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="area_name" class="col-sm-2 control-label">Area Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="area_name" name="area_name" value="<?php echo e($area_name); ?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="area_code" class="col-sm-2 control-label">Area Code </label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="area_code" name="area_code" value="<?php echo e($area_code); ?>" required>
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
	document.getElementById("zone_code").value=<?php echo e($zone_code); ?>;
	document.getElementById("status").value=<?php echo e($status); ?>;
	</script>
	
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Area").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>