
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
}
.required {
    color: red;
    font-size: 14px;
}
.col-sm-2, .col-sm-1 {
	padding-left: 6px;
}
</style>
<br/>
<br/>
<section class="content-header">
	<h1><small>Unsettled Staff Advance</small></h1>
</section>
<section class="content">	
	<div class="row">
		<form class="form-horizontal">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Type </label>
							<div class="col-sm-2">
								<p class="form-control-static">: 
								<?php if($result_info->emp_type==1) echo 'Regular'; ?>
								<?php if($result_info->emp_type==2) echo 'OT'; ?>
								<?php if($result_info->emp_type==3) echo 'CH'; ?>
								<?php if($result_info->emp_type==4) echo 'SHS'; ?>
								</p>
							</div>
							<label class="col-sm-2 control-label">Employee ID </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->emp_id); ?></p>
							</div>
							<label class="col-sm-2 control-label">Entry Date </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e(date('d-m-Y', strtotime($result_info->entry_date))); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Name </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo empty($result_info->emp_name) ? $result_info->emp_name_eng : $result_info->emp_name; ?></p>							
							</div>
							<label class="col-sm-2 control-label">Designation </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->designation_name); ?></p>
							</div>
							<label class="col-sm-2 control-label">Branch </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->branch_name); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Claim Description </label>
							<div class="col-sm-2">
								<p class="form-control-static">: 
								<?php if($result_info->claim_description==1) echo 'Audit Report'; ?>
								<?php if($result_info->claim_description==2) echo 'Branch Findings'; ?>
								</p>							
							</div>
							<label class="col-sm-2 control-label">Claim Date </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e(date('d-m-Y', strtotime($result_info->claim_date))); ?></p>
							</div>
							<label class="col-sm-2 control-label">Claim Branch </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->claim_branch_name); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Total Amount </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->total_amount); ?></p>
							</div>
							<label class="col-sm-2 control-label">Rest of Amount </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->rest_of_amt); ?></p>
							</div>
							<label class="col-sm-2 control-label">Comments</label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->comments); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>">
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Collection Amount <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="hidden" name="us_staff_ad_id" value="<?php echo e($result_info->id); ?>" class="form-control">
								<input type="hidden" name="emp_id" value="<?php echo e($result_info->emp_id); ?>" class="form-control">
								<input type="hidden" name="total_amount" value="<?php echo e($result_info->total_amount); ?>" class="form-control">
								<input type="text" name="collection_amt" value="" class="form-control">
							</div>
							<label class="col-sm-2 control-label">Collection Date <span class="required">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="collection_date" value="" class="form-control month_year" >
							</div>
							<label class="col-sm-2 control-label">Comments</label>
							<div class="col-sm-2">
								<input type="text" name="comments" value="" class="form-control" >
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/unsettle-staff-adv')); ?>" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
						<button type="submit" id="submit" class="btn btn-primary" >Save</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<script>
$(document).ready(function() {
	$('.month_year').datepicker({dateFormat: 'yy-mm-dd'});	
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>