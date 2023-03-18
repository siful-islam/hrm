
<?php $__env->startSection('title', 'Post Name'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
  <h4>add-post</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-post</li>
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

			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group<?php echo e($errors->has('circular_id') ? ' has-error' : ''); ?>">
							<label for="circular_id" class="col-sm-4 control-label">Circular Name</label><span class="required">*</span>
							<div class="col-sm-6">
								<select name="circular_id" id="circular_id" required class="form-control">
									<option value="">Select</option>								
									<?php $__currentLoopData = $all_circular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $circular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($circular->id); ?>"><?php echo e($circular->circular_name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
						</div>
						<div class="form-group<?php echo e($errors->has('post_name') ? ' has-error' : ''); ?>">
							<label for="post_name" class="col-sm-4 control-label">Post Name </label><span class="required">*</span>
							<div class="col-sm-6">
								<input type="text" name="post_name" id="post_name" value="<?php echo e($post_name); ?>" required class="form-control">
								<?php if($errors->has('post_name')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('post_name')); ?></strong>
								</span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group<?php echo e($errors->has('normal_age') ? ' has-error' : ''); ?>">
							<label for="normal_age" class="col-sm-4 control-label">Normal Age </label>
							<div class="col-sm-6">
								<input type="text" name="normal_age" id="normal_age" value="<?php echo e($normal_age); ?>"  class="form-control">
								<?php if($errors->has('normal_age')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('normal_age')); ?></strong>
								</span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group<?php echo e($errors->has('experience_age') ? ' has-error' : ''); ?>">
							<label for="experience_age" class="col-sm-4 control-label">Experience Age </label>
							<div class="col-sm-6">
								<input type="text" name="experience_age" id="experience_age" value="<?php echo e($experience_age); ?>"  class="form-control">
								<?php if($errors->has('experience_age')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('experience_age')); ?></strong>
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
						<a href="<?php echo e(URL::to('/circular-post')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript">
document.getElementById("circular_id").value="<?php echo e($circular_id); ?>";
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script>
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Post_Name").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>