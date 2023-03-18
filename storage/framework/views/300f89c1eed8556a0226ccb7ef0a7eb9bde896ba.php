
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 14px;
}
.form-horizontal .control-label {
    text-align: left;
}
.form-inline .control-label {
    margin-bottom: 10px;
	font-size: 14px;
}

.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
<section class="content-header">
	<h1>PMS<small>PMS</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">PMS</li>
	</ol>
</section>
<!-- Main content -->
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report">
						<!--<div class="form-group">
							<label class="col-sm-12 control-label" style="margin-bottom: 30px;background-color:#00c0ef;">Assessment Year 2020-2021</label>
							<label class="col-sm-12 control-label"><a href="<?php echo e(URL::to('/pms-objective')); ?>"><span class="glyphicon glyphicon-info-sign btn btn-primary btn-circle"></span> Objective Setup</a></label>
							<label class="col-sm-12 control-label"><span class="glyphicon glyphicon-info-sign"></span> Supervisor Approval</label>
							<label class="col-sm-12 control-label"><span class="glyphicon glyphicon-info-sign"></span> End Year Submission</label>
							<label class="col-sm-12 control-label"><span class="glyphicon glyphicon-info-sign"></span> End Year Assessment</label>
						</div>-->
						<label class="col-sm-12 control-label" style="margin-bottom: 30px;background-color:#658907;color:#fff;">Assessment Year 2020-2021</label>
					</form>
					<div class="stepwizard">
						<div class="stepwizard-row setup-panel">
							<div class="stepwizard-step">
								<a href="<?php echo e(URL::to('/pms-objective')); ?>" type="button" class="btn btn-primary btn-circle">1</a>
								<p style="font-weight:bold;">Objective Setup</p>
							</div>
							<div class="stepwizard-step">
								<a <?php if($status ==2) { ?> href="<?php echo e(URL::to('/pms-view/'.$emp_id.'/1')); ?>" <?php } else { ?> href="#"<?php } ?>type="button" class="btn btn-<?php echo $status ==2 ? 'primary' : 'default'; ?> btn-circle" <?php echo $status ==2 ? '' : 'disabled'; ?>>2</a>
								<p>Supervisor Approval</p>
							</div>
							<div class="stepwizard-step">
								<a href="<?php echo e(URL::to('/pms-submission')); ?>" type="button" class="btn btn-<?php echo $status ==2 ? 'primary' : 'default'; ?> btn-circle" <?php echo $status ==2 ? '' : 'disabled'; ?>>3</a>
								<p>End Year Submission</p>
							</div>
							<div class="stepwizard-step">
								<a <?php if($complete_status ==4) { ?> href="<?php echo e(URL::to('/pms-assessment/'.$emp_id.'/1')); ?>" <?php } else { ?> href="#"<?php } ?>type="button" class="btn btn-<?php echo $complete_status ==4 ? 'primary' : 'default'; ?> btn-circle" <?php echo $complete_status ==4 ? '' : 'disabled'; ?>>4</a>
								<p>End Year Assessment</p>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</section>
</div>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#own_pms").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>