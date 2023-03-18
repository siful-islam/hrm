
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
		<form class="form-horizontal" action="<?php echo e(URL::to('/unsettle-staff-adv-payroll')); ?>" method="post">
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Type </label>
							<div class="col-sm-2">
								<select name="emp_type" class="form-control" required>
								<option value="1" <?php if($emp_type==1) echo 'selected'; ?> >Regular</option>
								<option value="2" <?php if($emp_type==2) echo 'selected'; ?> >OT</option>
								<option value="3" <?php if($emp_type==3) echo 'selected'; ?> >CH</option>
								<option value="4" <?php if($emp_type==4) echo 'selected'; ?> >SHS</option>
							</select>
							</div>
							<label class="col-sm-2 control-label">Employee ID </label>
							<div class="col-sm-2">
								<input type="text" name="emp_id" value="<?php echo e($emp_id); ?>" class="form-control" required>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-primary" >Search</button>
							</div>
						</div>
						<?php if(!empty($result_info)): ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Name </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->emp_name_eng); ?></p>							
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
						<?php endif; ?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php if(!empty($result_info)): ?>
	<div class="row">
		<form class="form-horizontal" action="<?php echo e(URL::to('/unsettle-staff-adv-col')); ?>" method="post">
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Installment Amount: </label>
							<div class="col-sm-2">
								<input type="hidden" name="us_staff_ad_id" value="<?php echo e($result_info->id); ?>" class="form-control">
								<input type="hidden" name="emp_id" value="<?php echo e($result_info->emp_id); ?>" class="form-control">
								<input type="hidden" name="total_amount" value="<?php echo e($result_info->total_amount); ?>" class="form-control">
								<input type="hidden" name="is_payroll" value="1" class="form-control">
								<input type="text" name="collection_amt" value="" required class="form-control">
							</div>
							<label class="col-sm-2 control-label">Start Date:</label>
							<div class="col-sm-2">
								<input type="text" name="collection_date" value="" required class="form-control month_year" >
							</div>
							<label class="col-sm-2 control-label">Comments:</label>
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
	<?php endif; ?>
</section>
<script>
$(document).ready(function() {
	$('.month_year').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>