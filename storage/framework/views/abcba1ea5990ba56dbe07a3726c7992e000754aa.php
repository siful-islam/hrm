<?php $__env->startSection('title', 'Covid-Nineteen'); ?>
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
	<h1><small>Covid-19 info</small></h1>
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
								<p class="form-control-static">: <?php echo $result_info->type_name; ?></p>
							</div>
							<label class="col-sm-2 control-label">Employee ID </label>
							<div class="col-sm-2">
								<p class="form-control-static">: <?php echo e($result_info->emp_id); ?></p>
							</div>
							<label class="col-sm-2 control-label">Effect Date </label>
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
</section>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupOthers").addClass('active');
			$("#Covid-19").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>