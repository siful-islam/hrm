
<?php $__env->startSection('title', 'Add Transfer Causes'); ?>
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Settings<small><?php echo e($Heading); ?></small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li class="active"><?php echo e($Heading); ?></li>
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
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>">
                <?php echo e(csrf_field()); ?>

				<?php echo $method_control; ?>

				
				<input type="hidden" id="id" name="id" value="<?php echo e($id); ?>" >				
				<div class="box-body">
					<div class="form-group">
						<label for="remarks_note" class="col-sm-2 control-label">Remarks Note</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="remarks_note" name="remarks_note" value="<?php echo e($remarks_note); ?>" placeholder="Remarks Note" required>
						</div>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Status</label>
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
		document.getElementById("status").value = '<?php echo e($status); ?>';
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Transfer_Causes').addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>