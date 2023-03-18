<?php $__env->startSection('title', 'My Basic Info'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.box-body {
    padding: 2px;
	margin-bottom:5px;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.box-header {
    padding: 2px 10px;
}
.h4, .h5, .h6, h4, h5, h6 {
    margin-top: 2px;
    margin-bottom: 2px;
}
hr {
    margin-top: 1px;
    margin-bottom: 1px;
}
.form-group {
    margin-bottom: 5px;
}
.form-group label {
    font-size: 12px;
}
.table {
    margin-bottom: 4px;
}
.table thead th { 
  background-color: #ECF0F5;
}
.table > thead > tr > th {
    padding: 4px;
}
.content-header > .breadcrumb {
    top: 5px;
	position: relative;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}

</style>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
    <section class="content-header">
        <h1>Self<small>Care</small></h1>
    </section>

    <section class="content-header">
        <a href="<?php echo e(URL::to('/profile')); ?>">
            <h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5>
        </a>
    </section>
<section class="content">	
	<div id="printme">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box box-info">
					<form class="form-horizontal">
						<div class="box-header"><h4>General Information:</h4></div>
						<hr>
						<div class="box-body">
							<div style="padding-left:2px;" class="col-md-12">
								<div class="form-group">
									<label class="col-sm-3">Employee ID</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->emp_id); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Employee Name (ENG)</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->emp_name_eng); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Employee Name (Bang)</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->emp_name_ban); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Father's Name</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->father_name); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Mother's Name</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->mother_name); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Date of Birth</label>
									<div class="col-sm-9">: <?php echo date('d-m-Y',strtotime($emp_cv_basic->birth_date)); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Present Age</label>
									<div class="col-sm-9">: 
									<?php 
									$date1 = new DateTime($emp_cv_basic->birth_date);
									$date2 = date('Y-m-d', strtotime("+1 day"));					
									$date3 = new DateTime($date2);						
									$interval = date_diff($date1, $date3);
									// $days = $diff12->d;
									//accesing months
									echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Religion</label>
									<div class="col-sm-9">: 
										<?php $__currentLoopData = $allreligions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $religionid => $religionname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($religionid == $emp_cv_basic->religion): ?>
										<?php echo e($religionname); ?>

										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Maritial Status</label>
									<div class="col-sm-9">: 
										<?php if($emp_cv_basic->maritial_status == 'Married'): ?> <?php echo e('Married'); ?>

										<?php elseif($emp_cv_basic->maritial_status == 'Unmarried'): ?> <?php echo e('Unmarried'); ?>

										<?php else: ?> <?php echo e('N/A'); ?>

										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Nationality</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->nationality); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">National Id</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->national_id); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Gender</label>
									<div class="col-sm-9">:
										<?php if($emp_cv_basic->gender == 'Male'): ?> <?php echo e('Male'); ?>

										<?php else: ?>
										<?php echo e('Female'); ?>

										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Country Name</label>
									<div class="col-sm-9">:
										<?php $__currentLoopData = $all_countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country_id => $country_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($country_id == $emp_cv_basic->country_id): ?>
										<?php echo e($country_name); ?>

										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Contact Number</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->contact_num); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Email</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->email); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Blood Group</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->blood_group); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Joining Date</label>
									<div class="col-sm-9">: <?php echo date('d-m-Y',strtotime($emp_cv_basic->org_join_date)); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Present Address</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->present_add); ?></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3">Permanent Address</label>
									<div class="col-sm-9">: <?php echo e($emp_cv_basic->permanent_add); ?></div>
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
											<th>Passing Year</th>
										</tr>
									</thead>
									<tbody>
										<?php $__currentLoopData = $emp_cv_edu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e($emp_edu->exam_name); ?></td>
											<td><?php echo e($emp_edu->subject_name); ?></td>
											<td><?php echo e($emp_edu->board_uni_name); ?></td>
											<td><?php echo e($emp_edu->result); ?></td>
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
									<?php $__currentLoopData = $emp_cv_tra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_tra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
									<?php $__currentLoopData = $emp_cv_exp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($emp_exp->designation); ?></td>
										<td><?php echo e($emp_exp->experience_period); ?></td>
										<td><?php echo e($emp_exp->organization_name); ?></td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
						</div>
						<?php if(!empty($emp_cv_ref)): ?>
						<div class="box-header"><h4>Reference Information:</h4></div>					
						<hr>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Name</th>
											<th>Occupation</th>
											<th>Address</th>
											<th>Contact</th>
											<th>Email</th>
											<th>NID</th>
										</tr>
									</thead>
									<tbody>
										<?php $__currentLoopData = $emp_cv_ref; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e($emp_ref->rf_name); ?></td>
											<td><?php echo e($emp_ref->rf_occupation); ?></td>
											<td><?php echo e($emp_ref->rf_address); ?></td>
											<td><?php echo e($emp_ref->rf_mobile); ?></td>
											<td><?php echo e($emp_ref->rf_email); ?></td>
											<td><?php echo e($emp_ref->rf_national_id); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>
						<?php endif; ?>
					</form>	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box box-info">
					<form class="form-horizontal">
						<div class="box-header"><h4>Transactions:</h4></div>					
						<hr>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Transaction</th>
											<th>Letter Date</th>
											<th>Effect Date</th>
											<th>Working Station</th>
											<th>Designation</th>
											<th>Grade</th>
										</tr>
									</thead>
									<tbody>
									<?php $__currentLoopData = $all_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e($transaction->transaction_name); ?></td>
											<td><?php echo e(date('d-m-Y',strtotime($transaction->letter_date))); ?></td>
											<td><?php echo e(date('d-m-Y',strtotime($transaction->effect_date))); ?></td>
											<td><?php echo e($transaction->branch_name); ?></td>
											<td><?php echo e($transaction->designation_name); ?></td>
											<td><?php echo e($transaction->grade_name); ?></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>
								
						
					</form>	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box box-info">
					<form class="form-horizontal">
						<div class="box-header"><h4>Timeline as Designation:</h4></div>					
						<hr>
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Designation</th>
											<th>Date From</th>
											<th>Date To</th>
											<th>Duration</th>
										</tr>
									</thead>
									<tbody>
										<?php date_default_timezone_set('UTC'); 
										$i = 1; $next_day = date("Y-m-d"); $to_date = date('Y-m-d');
										foreach($emp_history_designation as $result) {
											if($i == 1) {
												$date_upto = $to_date;
											} else {			
												$date_upto = date('Y-m-d', strtotime("-1 day", strtotime($next_day)));				
											}
											$big_date=date_create(date('Y-m-d', strtotime("+1 day", strtotime($date_upto))));
											$small_date=date_create($result['effect_date']);
											$diff=date_diff($big_date,$small_date);
										?>
										<tr>
											<td><?php echo $result['designation_name']; ?></td>
											<td><?php echo date('d-m-Y',strtotime($result['effect_date'])); ?></td>
											<td><?php echo date('d-m-Y',strtotime($date_upto)); ?></td>
											<td><?php echo $diff->format('%y Year %m Month %d Day'); ?></td>
										</tr>
										<?php $next_day = $result['effect_date'];
											$i++; 
										} ?>
									</tbody>
								</table>
							</div>
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
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#My_Basic").addClass('active');
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>