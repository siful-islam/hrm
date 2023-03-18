<style>
.content {
	padding-top: 5px;
}
.table > tr > th {   
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tr > td {
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content">
	<strong><u>General Information :</u></strong>
	<table>
		<tr>
			<td>Employee ID : <?php echo $emp_cv_basic->emp_id; ?></td>
			<td rowspan="10"><img style="height: 180px; width: 172px;" src="<?php //echo (asset('public/employee/'.$emp_cv_photo->emp_photo)); ?>" /> </td>
		</tr>
		<tr>
			<td>Employee Name (in English) : <?php echo $emp_cv_basic->emp_name_eng; ?></td>
		</tr>
		<tr>
			<td>Employee Name (in Bengali) : <?php echo $emp_cv_basic->emp_name_ban; ?></td>
		</tr>
		<tr>
			<td>Father's Name : <?php echo $emp_cv_basic->father_name; ?></td>
		</tr>
		<tr>
			<td>Mother's Name : <?php echo $emp_cv_basic->mother_name; ?></td>
		</tr>
		<tr>
			<td>Date of Birth : <?php echo $emp_cv_basic->birth_date; ?></td>
		</tr>
		<tr>
			<td>Present Age : <?php $date1 = new DateTime($emp_cv_basic->birth_date);
									$date2 = date('Y-m-d', strtotime("+1 day"));						
									$date3 = new DateTime($date2);						
									$interval = date_diff($date1, $date3);
									echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; ?>
			</td>
		</tr>
		<tr>
			<td>Religion : <?php $__currentLoopData = $allreligions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $religionid => $religionname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($religionid == $emp_cv_basic->religion): ?>
										<?php echo e($religionname); ?>

										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
		</tr>
		<tr>
			<td>Maritial Status : <?php if($emp_cv_basic->maritial_status == 'Married'): ?> <?php echo e('Married'); ?>

										<?php elseif($emp_cv_basic->maritial_status == 'Unmarried'): ?> <?php echo e('Unmarried'); ?>

										<?php else: ?> <?php echo e('N/A'); ?>

										<?php endif; ?></td>
		</tr>
		<tr>
			<td>Nationality : <?php echo $emp_cv_basic->nationality; ?></td>
		</tr>
		<tr>
			<td>National Id : <?php echo $emp_cv_basic->national_id; ?></td>
		</tr>
		<tr>
			<td>Gender : <?php if($emp_cv_basic->gender == 'Male'): ?> <?php echo e('Male'); ?>

										<?php else: ?>
										<?php echo e('Female'); ?>

										<?php endif; ?></td>
		</tr>
		<tr>
			<td>Country Name : <?php $__currentLoopData = $all_countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country_id => $country_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($country_id == $emp_cv_basic->country_id): ?>
										<?php echo e($country_name); ?>

										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
		</tr>
		<tr>
			<td>Contact Number : <?php echo $emp_cv_basic->contact_num; ?></td>
		</tr>
		<tr>
			<td>Email : <?php echo $emp_cv_basic->email; ?></td>
		</tr>
		<tr>
			<td>Blood Group : <?php echo $emp_cv_basic->blood_group; ?></td>
		</tr>
		<tr>
			<td>Joining Date : <?php echo $emp_cv_basic->org_join_date; ?></td>
		</tr>
		<tr>
			<td>Present Address : <?php echo $emp_cv_basic->present_add; ?></td>
		</tr>
		<tr>
			<td>Permanent Address : <?php echo $emp_cv_basic->permanent_add; ?></td>
		</tr>
	</table>
	<br><br>
	<strong><u>Education Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Exam. Name</th>
			<th>Group/Subject</th>
			<th>Board/University</th>
			<th>Result</th>
			<th>Passing Year</th>
		</tr>
		<?php $__currentLoopData = $emp_cv_edu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($emp_edu->exam_name); ?></td>
			<td><?php echo e($emp_edu->subject_name); ?></td>
			<td><?php echo e($emp_edu->board_uni_name); ?></td>
			<td><?php echo e($emp_edu->result); ?></td>
			<td><?php echo e($emp_edu->pass_year); ?></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<br><br>
	<strong><u>Training Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Training Name</th>
			<th>Training Period</th>
			<th>Institute Name</th>
			<th>Place</th>
		</tr>
		<?php $__currentLoopData = $emp_cv_tra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_tra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($emp_tra->train_name); ?></td>
			<td><?php echo e($emp_tra->train_period); ?></td>
			<td><?php echo e($emp_tra->institute); ?></td>
			<td><?php echo e($emp_tra->palace); ?></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<br><br>
	<strong><u>Experience Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Designation</th>
			<th>Experience Period</th>
			<th>Organization Name</th>
		</tr>
		<?php $__currentLoopData = $emp_cv_exp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($emp_exp->designation); ?></td>
			<td><?php echo e($emp_exp->experience_period); ?></td>
			<td><?php echo e($emp_exp->organization_name); ?></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<br><br>
	<strong><u>Reference Information :</u></strong>
	<br>
	<table class="table" width="100%" border="1" cellspacing="0"> 
		<tr>
			<th>Name</th>
			<th>Occupation</th>
			<th>Address</th>
			<th>Contact</th>
			<th>Email</th>
			<th>NID</th>
		</tr>
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
	</table>
</section>