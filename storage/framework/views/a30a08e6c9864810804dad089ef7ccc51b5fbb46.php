
<?php $__env->startSection('main_content'); ?>
 
 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Recommend<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Application</li>
		</ol>
	</section>

	<!-- Main content -->

	
	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> </h3>
			</div>
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>  
				 <div class="box-body"> 
					<div class="row">  
							<div class="col-md-9">  
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Financial Year From </label>
											<div class="col-md-6">
												<input type="text" name="f_year_from" id="f_year_from" class="form-control" value="<?php  echo date("Y",strtotime($fiscal_year->f_year_from)).'-'.date("Y",strtotime($fiscal_year->f_year_to));?>" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Application Date </label>
											<div class="col-md-6">
												<input type="text" name="application_date"  id="application_date"  class="form-control" value="<?php echo e($application_date); ?>" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave Type </label>
											<div class="col-md-6">
												<select  name="type_id" class="form-control"  id="type_id" disabled required > 
												<?php $__currentLoopData = $leave_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($type->id); ?>"><?php echo e($type->type_name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
											</div> 
									</div> 
								</div>  
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave's From </label>
											<div class="col-md-6">
												<input type="text" name="from_date" id="from_date" readonly class="form-control" value="<?php echo e($from_date); ?>" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave's To </label>
											<div class="col-md-6">
												<input type="text" name="to_date" id="to_date" readonly  class="form-control" value="<?php echo e($to_date); ?>" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
							 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Total Leave Day/s</label>
											<div class="col-md-6">
												<input type="text" name="no_of_days" id="no_of_days" class="form-control" readonly value="<?php echo e($no_of_days); ?>" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Reason of Leave</label>
											<div class="col-md-6">
												 <input list="browsers" class="form-control" readonly  name="remarks" value="<?php echo e($remarks); ?>" id="remarks">
												  <datalist id="browsers">
													<option value="Personal"> 
												  </datalist> 
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								<div class="col-md-6 col-md-offset-6">
									<div class="form-group"> 
										<label class="control-label col-md-4"></label>
											<div class="col-md-7"> 
												<a href="<?php echo e(URL::to('/approved_by_sup_approve_hrhead/'.$id)); ?>" class="btn btn-primary" >Approve</a>
												
												<a href="<?php echo e(URL::to('/approved_by_sup_reject_hrhead/'.$id)); ?>" class="btn btn-danger" >Reject</a>
												 
												<a href="<?php echo e(URL::to('/approved_by_sup')); ?>" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
											</div> 
									</div> 
								</div>
							</div>   
						<div class="col-md-3">  
							<div class="box-body box-profile">
							<?php if($emp_cv_photo): ?>
							<img class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('public/employee/'.$emp_cv_photo->emp_photo)); ?>"  alt="User profile picture"> 
							<?php else: ?>
							<img class="profile-user-img img-responsive img-circle" src="<?php echo e(asset('public/avatars/no_image.jpg')); ?>" alt="User profile picture">
							<?php endif; ?> 
							  <h5 class="text-center"><?php echo e($emp_id); ?></h5> 
							  <h3 class="profile-username text-center"><?php echo e($emp_info->emp_name); ?></h3>  
							  <ul class="list-group list-group-unbordered">
							  <?php 
									$tot_leave = $emp_leave_balance->cum_balance_less_close_12 + $emp_leave_balance->pre_cumulative_close + $emp_leave_balance->current_close_balance;
									
									$tot_leave_enjoy = ($emp_leave_balance->cum_balance_less_12 - $emp_leave_balance->cum_balance_less_close_12) +($emp_leave_balance->pre_cumulative_open - $emp_leave_balance->pre_cumulative_close);
								 ?>
							  
								<li class="list-group-item">
								<b>Total Leave</b> <p id="tot_earn_leave1" class="pull-right"><?php echo e($tot_leave); ?></p> 
								  
									<input type="hidden" name="tot_earn_leave" id="tot_earn_leave" readonly  class="form-control" value="<?php echo e($tot_earn_leave); ?>" required>
								</li>
								<li class="list-group-item">
								  <b>Total Leave enjoy</b> <p  class="pull-right"><?php echo e($emp_leave_balance->no_of_days + $tot_leave_enjoy); ?></p>
								</li>
								<li class="list-group-item">
								  <b>Balance</b> <p id="leave_remain1" class="pull-right"><?php echo e(($tot_leave - ($emp_leave_balance->no_of_days + $tot_leave_enjoy))); ?></p>
								</li>
							  </ul> 
							</div>
						</div>
					</form>
				</div>  
			</div> 
		</div>
	</section>
<script> 
if('<?php echo e($type_id); ?>' != ''){
	document.getElementById("type_id").value = "<?php echo e($type_id); ?>";
}
$(document).ready(function() {
		//calculate_earn_leave();
});	
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>