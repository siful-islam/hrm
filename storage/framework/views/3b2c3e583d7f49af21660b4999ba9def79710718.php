<?php $__env->startSection('title', 'Contractual | Official Info'); ?>
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active"><?php echo e($Heading); ?></li>
		</ol>
	</section>

	<!-- Main content -->
	
	<?php
	$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
	$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
	?>

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Contractual Renew </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form name="employee_nonid" class="form-horizontal" action="" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?> 
				<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>"> 
				<div class="box-body col-md-7">	
					
					<div class="form-group">
						
						<label for="emp_id" class="col-sm-3 control-label">Employee ID <span style="color:red;">*</span></label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php  echo  $emp_id;  ?></span>
						</div>
						
					</div>
					<div class="form-group">
					 <label class="control-label col-md-3">Contract Renew Date: <span style="color:red;">*</span> </label>
						<div class="col-md-3"> 
							<span class="form-control"> <?php echo date("d-m-Y",strtotime($effect_date));?></span>
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3" id="c_end_date_lebel">Contract Ending Date:  </label>
						<div class="col-md-3">
								<span class="form-control"> <?php if($c_end_date): ?> <?php echo e(date("d-m-Y",strtotime($c_end_date))); ?> <?php endif; ?> </span> 
							<span class="help-block">Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_contract_end_type()"  value="" <?php if(empty($c_end_date)){ ?> checked <?php }  ?>></span>
						</div>
					</div> 
					<hr> 
				</div>
				<div class="col-md-5">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
							<p class="text-muted text-center" id="designation_name"><?php echo e($designation_name); ?></p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date">  <?php if($joining_date): ?> <?php echo e(date("d-m-Y",strtotime($joining_date))); ?> <?php endif; ?></span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name"> <?php echo e($branch_name); ?> </span>
								</li>
							</ul>
							<a href="#" <?php if($cancel_date == ''){  ?> class="btn btn-primary btn-block"; <?php }else { ?> class="btn btn-danger btn-block" <?php }?>  id="employee_status"><b><?php if($cancel_date == ''){ echo "Active Employee"; }else { echo "This Employee Terminated"; }?></b></a>
						</div> 
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
			</form>

		</div>
	</section> 
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Contractual_Renew").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>