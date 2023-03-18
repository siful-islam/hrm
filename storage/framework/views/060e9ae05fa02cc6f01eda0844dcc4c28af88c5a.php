
<?php $__env->startSection('title', 'Unsettle Staff Advance'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>view-unsettle</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">view-unsettle</li>
	</ol>
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
					<div class="col-md-10 col-md-offset-1 table-responsive">
						<table id="training" class="table table-bordered">
							<thead>
							  <tr>
								<th>Sl No.</th>
								<th>Employee ID</th>
								<th>Installment Amt</th>
								<th>Installment Month</th>
								<th>Status</th>
							  </tr>
							</thead>
							<?php $i=1; 
							foreach ($unsettle_staff_view as $unsettle_view) {
							?>
							<tbody>
							  <tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($unsettle_view->emp_id); ?></td>
								<td><?php echo e($unsettle_view->collection_amt); ?></td>
								<td><?php echo e($unsettle_view->collection_date); ?></td>
								<td><?php echo ($unsettle_view->pay_status == 0) ? 'Not Paid' : 'Paid'; ?></td>
							  </tr>
							</tbody>
							<?php } ?>
						</table>								
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/unsettle-staff-adv')); ?>" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
<script>
document.getElementById("designation_code").value="<?php echo e($result_info->designation_code); ?>";
document.getElementById("br_code").value="<?php echo e($result_info->br_code); ?>";
</script>
<script>
	$(document).ready(function() {
		$("#MainGroupSalary_Info").addClass('active');
		$('[id^=Unsettle_Staff_Adv]').addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>