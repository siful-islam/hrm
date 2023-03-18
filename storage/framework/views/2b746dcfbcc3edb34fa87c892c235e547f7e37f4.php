<?php $__env->startSection('title', 'Add Thana'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
  <h4>add-thana</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-thana</li>
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
							<div class="form-group<?php echo e($errors->has('district_name') ? ' has-error' : ''); ?>">
								<label for="district_name" class="col-sm-4 control-label">District Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="district_code" id="district_code" required class="form-control">
										<option value="">Select</option>								
										<?php $__currentLoopData = $all_district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($district->district_code); ?>"><?php echo e($district->district_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('thana_name') ? ' has-error' : ''); ?>">
								<label for="thana_name" class="col-sm-4 control-label">Thana Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="thana_name" id="thana_name" value="<?php echo e($thana_name); ?>" required autofocus class="form-control">
									<?php if($errors->has('thana_name')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('thana_name')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('thana_bangla') ? ' has-error' : ''); ?>">
								<label for="thana_bangla" class="col-sm-4 control-label">Thana Name (Bangla)</label>
								<div class="col-sm-6">
									<input type="text" name="thana_bangla" id="thana_bangla" value="<?php echo e($thana_bangla); ?>" class="form-control">
									<?php if($errors->has('thana_bangla')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('thana_bangla')); ?></strong>
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
							<a href="<?php echo e(URL::to('/thana')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
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
	document.getElementById("district_code").value="<?php echo e($district_code); ?>";
</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Thana").addClass('active');
			});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>