<?php $__env->startSection('title', 'Add Exam'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
  <h4>Exam</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">Exam</li>
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
		<div class="tab-content">
			<form action="<?php echo e(URL::to($action)); ?>" method="post" class="form-horizontal" >
				<?php echo e(csrf_field()); ?>

				<?php echo $method_field; ?>

				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">							
							<div class="form-group<?php echo e($errors->has('exam_name') ? ' has-error' : ''); ?>">
								<label for="exam_name" class="col-sm-4 control-label">Exam Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="exam_name" id="exam_name" value="<?php echo e($exam_name); ?>" required autofocus class="form-control">
									<?php if($errors->has('exam_name')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('exam_name')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('level_id') ? ' has-error' : ''); ?>">
								<label for="level_id" class="col-sm-4 control-label">Level Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="level_id" id="level_id" required class="form-control">
										<option value="">Select</option>								
										<?php $__currentLoopData = $all_level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($level->level_id); ?>"><?php echo e($level->level_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
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
							<a href="<?php echo e(URL::to('/exam')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
			</form>			
		</div>
	</div>
</section>
<script>
	document.getElementById("level_id").value="<?php echo e($level_id); ?>";
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Exam').addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>