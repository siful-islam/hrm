
<?php $__env->startSection('title', 'Held Up'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>view-heldup</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">view-heldup</li>
	</ol>
</section>
<section class="content">	
	<div class="row">
		<form class="form-horizontal">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee ID</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->emp_id); ?></div></div>
							<label class="col-sm-2 control-label">Letter Date</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->letter_date); ?></div></div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Branch</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->branch_name); ?></div></div>
							<label class="col-sm-2 control-label">Designation</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->designation_name); ?></div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">What HeldUp</label>
							<div class="col-sm-3"><div class="form-control">
								<?php if($heldup_info->what_heldup=="Permanent") echo 'Permanent'; ?>
								<?php if($heldup_info->what_heldup=="Increment") echo 'Increment'; ?>
								<?php if($heldup_info->what_heldup=="Promotion") echo 'Promotion'; ?>
							</div></div>
							<label class="col-sm-2 control-label">HeldUp Time</label>
							<div class="col-sm-3"><div class="form-control">
								<?php if($heldup_info->heldup_time=="1") echo '1 Months'; ?>
								<?php if($heldup_info->heldup_time=="2") echo '2 Months'; ?>
								<?php if($heldup_info->heldup_time=="3") echo '3 Months'; ?>
								<?php if($heldup_info->heldup_time=="6") echo '6 Months'; ?>
								<?php if($heldup_info->heldup_time=="12") echo '12 Months'; ?>
							</div></div>
						</div>
						<div class="form-group">
							<?php if($heldup_info->what_heldup=="Increment") { ?>
							<label class="col-sm-2 control-label">Next Increment Date</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->next_increment_date); ?></div></div>
							<?php } else { ?>
							<label class="col-sm-2 control-label">HeldUp Until Date</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->heldup_until_date); ?></div></div>
							<?php } ?>
							<label class="col-sm-2 control-label">Cause of HeldUp</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($heldup_info->heldup_cause); ?></div></div>
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/heldup')); ?>" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
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
		$("#MainGroupEmployee").addClass('active');
		$("#Held_up").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>