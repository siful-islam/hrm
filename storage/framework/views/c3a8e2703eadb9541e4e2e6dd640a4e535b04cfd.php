<?php $__env->startSection('title', 'Marked Assign'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>view-assign</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">view-assign</li>
	</ol>
</section>
<section class="content">	
	<div class="row">
		<form class="form-horizontal">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Open Date</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($mark_assign_info->open_date); ?></div></div>
							<label class="col-sm-2 control-label">Employee ID</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($mark_assign_info->emp_id); ?></div></div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Name</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($mark_assign_info->emp_name_eng); ?></div></div>
							<label class="col-sm-2 control-label">Designation</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($mark_assign_info->designation_name); ?></div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Branch</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($mark_assign_info->branch_name); ?></div></div>
							<label class="col-sm-2 control-label">Marked for</label>		
							<div class="col-sm-3">
								<div class="form-control">
									<?php if($mark_assign_info->marked_for=="Permanent") { echo 'Permanent';} 
									else if ($mark_assign_info->marked_for=="Increment") { echo 'Increment';}
									else if ($mark_assign_info->marked_for=="Promotion") { echo 'Promotion';}
									else if ($mark_assign_info->marked_for=="Promotion_Increment") { echo 'Promotion & Increment';} ?>
								</div>
							</div>
						</div>
						<div class="form-group">							
							<label class="col-sm-2 control-label">Marked Details</label>
							<div class="col-sm-3"><div class="form-control"><?php echo e($mark_assign_info->marked_details); ?></div></div>
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/mark-assign')); ?>" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
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
		$("#Marked_Assign").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>