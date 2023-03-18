
<?php $__env->startSection('title', 'Manage Extra Deduction Type'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
  <h4>add-district</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-district</li>
  </ol>
</section>
<section class="content">	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			<?php if(Session::has('message')): ?>
			<?php echo e(session('message')); ?>

			<?php endif; ?>
		</h3>-->
		<form action="<?php echo e(URL::to($action)); ?>" method="post" class="form-horizontal" >
			<?php echo e(csrf_field()); ?>

			<?php echo $method_field; ?>

			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group<?php echo e($errors->has('type_name') ? ' has-error' : ''); ?>">
							<label for="type_name" class="col-sm-4 control-label">Type Name</label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="type_name" id="type_name" value="<?php echo e($type_name); ?>" required autofocus class="form-control">
								<?php if($errors->has('type_name')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('type_name')); ?></strong>
								</span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status</label><span class="required">*</span>
							<div class="col-sm-6">
								<select class="form-control" id="status" name="status" required>						
									<option value="1" <?php if($status=="1") echo 'selected="selected"'; ?> >Active</option>
									<option value="0" <?php if($status=="0") echo 'selected="selected"'; ?> >InActive</option>
								</select>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/extra_deduc_type')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Extra_Deduction_Type").addClass('active');
			});
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Extra_Deduction_Type").addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>