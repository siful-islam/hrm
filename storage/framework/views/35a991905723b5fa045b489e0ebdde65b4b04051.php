
<?php $__env->startSection('title', 'Recruitment'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.form-group {
    margin-bottom: 5px;
}
.form-group label {
    font-size: 12px;
}
.table thead th { 
  background-color: #ECF0F5;
}
</style>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content-header">
  <h4>Recruitment CV View</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">Employee CV</li>
	<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
  </ol>
</section>
<section class="content">	
	<div id="printme">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form class="form-horizontal">
						<div class="box-header"><h4>General Information:</h4></div>
						<hr>
						<div class="box-body">
							<div style="padding-left:2px;" class="col-md-8 col-xs-6">
								<div class="form-group">
									<label class="col-sm-4">Recruitment ID</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->id); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Name</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->full_name); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Father Name</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->father_name); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Mother Name</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->mother_name); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Date of Birth</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->birth_date); ?></div>
								</div> 
								<div class="form-group">
									<label class="col-sm-4">Religion</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->religion); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Maritial Status</label>
									<div class="col-sm-6">:  <?php echo e($recruitment_cv_basic->maritial_status); ?> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Nationality</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->nationality); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">National Id</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->national_id); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Gender</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->gender); ?>

									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Contact Number</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->contact_num); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Email</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->email); ?></div>
								</div>  
								<div class="form-group">
									<label class="col-sm-4">Present Address</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->present_add); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Permanent Address</label>
									<div class="col-sm-6">: <?php echo e($recruitment_cv_basic->permanent_add); ?></div>
								</div>
							</div> 
						</div>
						<div class="box-header"><h4>Education Information:</h4></div>					
						<hr>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Exam. Name</th>
											<th>Group/Subject</th>
											<th>Board/University</th>
											<th>Result</th>
											<th>GPA</th>
											<th>Passing Year</th>
										</tr>
									</thead>
									<tbody>
										<?php $__currentLoopData = $recruitment_cv_edu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e($emp_edu->exam_name); ?></td>
											<td><?php echo e($emp_edu->subject_name); ?></td>
											<td><?php echo e($emp_edu->board_uni_name); ?></td>
											<td><?php echo e($emp_edu->result); ?></td>
											<td><?php echo e($emp_edu->pass_year); ?></td>
											<td><?php echo e($emp_edu->pass_year); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="box-header"><h4>Training Information:</h4></div>					
						<hr>
						<div class="box-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Training Name</th>
										<th>Training Period</th>
										<th>Institute Name</th>
										<th>Place</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $recruitment_cv_tra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_tra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($emp_tra->train_name); ?></td>
										<td><?php echo e($emp_tra->train_period); ?></td>
										<td><?php echo e($emp_tra->institute); ?></td>
										<td><?php echo e($emp_tra->palace); ?></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
						</div>
						<div class="box-header"><h4>Experience Information:</h4></div>					
						<hr>
						<div class="box-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Designation</th>
										<th>Experience Period</th>
										<th>Organization Name</th>
									</tr>
								</thead>
								<tbody>
									<?php $__currentLoopData = $recruitment_cv_exp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($emp_exp->designation); ?></td>
										<td><?php echo e($emp_exp->experience_period); ?></td>
										<td><?php echo e($emp_exp->organization_name); ?></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
						</div> 
					</form>	
				</div>
			</div>
		</div>
	</div>
</section>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>
<script>
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Recruitment").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>