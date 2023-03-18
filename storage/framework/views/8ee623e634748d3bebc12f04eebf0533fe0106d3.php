<?php $__env->startSection('title', 'Appointment'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
.required {
    color: red;
    font-size: 12px;
}
</style>
<link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')); ?>">
<style>
	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		background-color: #3c8dbc;
		border-color: #367fa9;
		padding: 1px 10px;
		color: #fff;
	}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active"><?php echo e($Heading); ?></li>
		</ol>
	</section>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
$all_grade_step = array('1'=>'STEP : 00','2'=>'STEP : 01','3'=>'STEP : 02','4'=>'STEP : 03','5'=>'STEP : 04','6'=>'STEP : 05','7'=>'STEP : 06','8'=>'STEP : 07','9'=>'STEP : 08','10'=>'STEP : 09','11'=>'STEP : 10','12'=>'STEP : 11','13'=>'STEP : 12','14'=>'STEP : 13','15'=>'STEP : 14','16'=>'STEP : 15','17'=>'STEP : 16','18'=>'STEP : 17','19'=>'STEP : 18','20'=>'STEP : 19');
$session_branch_code = Session::get('branch_code');
?>
	<!-- Main content -->

	<section class="content">
		<div class="row">
		<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Basic Information</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" role="form" method="POST" id="new_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				<?php echo $method_control; ?>


                <input type="hidden" class="form-control" value="<?php echo e($id); ?>" name="id" id="id" readonly>
                <input type="hidden" class="form-control" value="<?php echo e($sarok_no); ?>" name="sarok_no" id="sarok_no">
                <input type="hidden" class="form-control" value="<?php echo e($emp_id); ?>" name="emp_id" id="emp_id">
				
				<?php 
				if($id != '')
				{
					$readonly = 'readonly';
				}
				else{
					$readonly = '';
				}
				?>
				<div class="form-group">
                    <label class="control-label col-md-2">Employee Name <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="emp_name" id="emp_name" value="<?php echo e($emp_name); ?>" class="form-control" required placeholder="Employee Name">
                    </div>
					<label class="control-label col-md-2">Employee Name (in Bengali) <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="emp_name_bangla" id="emp_name_bangla" value="<?php echo e($emp_name_bangla); ?>" class="form-control" required placeholder="Employee Name (Bangla)">
                    </div>
                </div>
				<div class="form-group">                  
					<label class="control-label col-md-2">Father's Name <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="fathers_name" id="fathers_name" value="<?php echo e($fathers_name); ?>" class="form-control" required placeholder="Father's Name">
                    </div>
					<label class="control-label col-md-2">Father's Name (in Bengali) </label>
                    <div class="col-md-3">
                        <input type="text" name="fathers_name_bangla" id="fathers_name_bangla" value="<?php echo e($fathers_name_bangla); ?>" class="form-control" placeholder="Father's Name (Bangla)">
                    </div>
                </div>
				<div class="form-group">                  
					<label class="control-label col-md-2">Mother's Name <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="mother_name" id="mother_name" value="<?php echo e($mother_name); ?>" class="form-control" required placeholder="Mother's name">
                    </div>
					<label class="control-label col-md-2">Mother's Name (in Bengali) </label>
                    <div class="col-md-3">
                        <input type="text" name="mother_name_ban" id="mother_name_ban" value="<?php echo e($mother_name_ban); ?>" class="form-control" placeholder="Mother's Name (Bangla)">
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Date of Birth <span class="required">*</span></label>
                    <div class="col-md-3">
						<input type="text" name="birth_date" id="birth_date" value="<?php echo e($birth_date); ?>" readonly required class="form-control" autocomplete="off">
                    </div>
					<label class="control-label col-md-2">Religion <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select name="religion" id="religion" required class="form-control">
							<option value="">Select</option>							
							<?php foreach($allreligions as $religionid => $religionname){?>
							<option value="<?php echo $religionid;?>"><?php echo $religionname;?></option>
							<?php } ?>
						</select>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Marital Status <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select name="maritial_status" id="maritial_status" required class="form-control">
							<option value="">Select</option>
							<option value="Married" >Married</option>
							<option value="Unmarried" >Unmarried</option>
							<option value="N/A" >N/A</option>
						</select>
                    </div>
					<label class="control-label col-md-2">Nationality <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="nationality" id="nationality" value="Bangladeshi" readonly class="form-control" required placeholder="Nationality">
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">National Id <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="national_id" id="national_id" value="<?php echo e($national_id); ?>" required class="form-control" placeholder="National Id">
                    </div>
					<label class="control-label col-md-2">Birth Certificate </label>
                    <div class="col-md-3">
                        <input type="text" name="birth_certificate" id="birth_certificate" value="<?php echo e($birth_certificate); ?>" required class="form-control" placeholder="Birth Certificate">
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Gender <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select name="gender" id="gender" required class="form-control">
							<option value="">Select</option>
							<option value="Male" >Male</option>
							<option value="Female" >Female</option>
						</select>
                    </div>
					<label class="control-label col-md-2">Blood Group </label>
                    <div class="col-md-3">
                        <select name="blood_group" id="blood_group" class="form-control">
							<option value="">Select</option>							
							<?php $__currentLoopData = $allbloods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bloodid => $bloodname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($bloodid); ?>"><?php echo e($bloodname); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Contact Number <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="contact_num" id="contact_num" value="<?php echo e($contact_num); ?>" class="form-control" required placeholder="Contact Number">
                    </div>
					<label class="control-label col-md-2">Email </label>
                    <div class="col-md-3">
                        <input type="text" name="email" id="email" value="<?php echo e($email); ?>" class="form-control" placeholder="Email">
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Village <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="emp_village" id="emp_village" value="<?php echo e($emp_village); ?>" class="form-control" required placeholder="Village">
                    </div>
					<label class="control-label col-md-2">Village (Bangla) </label>
                    <div class="col-md-3">
                        <input type="text" name="emp_village_bangla" id="emp_village_bangla" value="<?php echo e($emp_village_bangla); ?>" class="form-control" placeholder="Village (Bangla)">
                    </div>
                </div>
				<div class="form-group">
					<label class="control-label col-md-2">Post Office </label>
                    <div class="col-md-3">
                        <input type="text" name="emp_po" id="emp_po" value="<?php echo e($emp_po); ?>" class="form-control" placeholder="Post Office">
                    </div>
					<label class="control-label col-md-2">Post Office (Bangla) </label>
                    <div class="col-md-3">
                        <input type="text" name="emp_po_bangla" id="emp_po_bangla" value="<?php echo e($emp_po_bangla); ?>" class="form-control" placeholder="Village">
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">District <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select name="emp_district" id="emp_district" required class="form-control">
							<option value="" hidden>-Select District-</option>
							<?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_districts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_districts->district_code); ?>"><?php echo e($v_districts->district_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                    </div>
					<label class="control-label col-md-2">Thana <span class="required">*</span></label>
                    <?php if(!empty($emp_thana)): ?>
					<div class="col-md-3">
						<select name="emp_thana" id="upazila_id" required class="form-control" >
							<?php $__currentLoopData = $thanas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($thana->thana_code == $emp_thana): ?>
							<option value="<?php echo e($thana->thana_code); ?>" selected="selected"><?php echo e($thana->thana_name); ?></option>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<?php else: ?>
					<div class="col-md-3">
						<select name="emp_thana" disabled="disabled" id="upazila_id" required class="form-control">
							<option value="">Select</option>
						</select>
                    </div>
					<?php endif; ?>
                </div>
				
				<div class="box-header with-border">
				  <h3 class="box-title">Joining Information</h3>
				</div><br>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Employee Group <span class="required">*</span></label>
                    <div class="col-md-2" style="padding-right:5px;">
						<select name="emp_group" id="emp_group" required class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<option value="2">Contractual</option>
							<?php } else { ?>
							<option value="">Select</option>
							<?php foreach ($all_emp_group as $empgroup) { ?>
							<option value="<?php echo $empgroup->id; ?>"><?php echo $empgroup->group_name; ?></option>
							<?php } } ?>
						</select>
                    </div>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" data-html="true" title="Regular: স্থায়ী ভাবে নিয়োগপ্রাপ্ত staff ! Contractual: চুক্তি ভিত্তিক নিয়োগপ্রাপ্ত staff ! Volunteer: Volunteer হিসাবে নিয়োগপ্রাপ্ত staff !">&#8505;</a></div>
					<label class="control-label col-md-2">Employee Type <span class="required">*</span></label>
                    <?php if($session_branch_code != 9999) { ?>
					<div class="col-md-2" style="padding-right:5px;">
                        <select name="emp_type" id="emp_type" class="form-control" onchange="myFunction()">
							<option value="" >-Select-</option>
							<option value="5">Cook</option>
							<option value="9">Teacher (shisok)</option>
						</select>
                    </div>
					<?php } else { ?>
					<?php if(!empty($emp_type)): ?>
					<div class="col-md-2" style="padding-right:5px;">
						<select name="emp_type" id="emp_type" required class="form-control" >
							<?php $__currentLoopData = $all_emp_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emptype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($emptype->id == $emp_type): ?>
							<option value="<?php echo e($emptype->id); ?>" selected="selected"><?php echo e($emptype->type_name); ?></option>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<?php else: ?>
					<div class="col-md-2" style="padding-right:5px;">
                        <select name="emp_type" id="emp_type" class="form-control">
							<option value="">Select</option>
						</select>
                    </div>
					<?php endif; ?>
					<?php } ?>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর Type !">&#8505;</a></div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Mother Program <span class="required">*</span></label>
                    <div class="col-md-2" style="padding-right:5px;">
                        <select name="mother_program_id" id="mother_program_id" required class="form-control">
							<?php //if($session_branch_code != 9999) { ?>
							<!--option value="1">Microfinance Program</option-->
							<?php //} else { ?>
							<option value="">Select</option>
							<option value="1">Microfinance Program</option>
							<option value="2">Special Program</option>
							<?php //} ?>
						</select>
                    </div>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর Program !">&#8505;</a></div>
					<label class="control-label col-md-2">Current Program <span class="required">*</span></label>
                    <div class="col-md-2" style="padding-right:5px;">
                        <select name="current_program_id" id="current_program_id" class="form-control">
							<?php //if($session_branch_code != 9999) { ?>
							<!--option value="1">Microfinance Program</option-->
							<?php //} else { ?>
							<option value="">Select</option>
							<option value="1">Microfinance Program</option>
							<option value="2">Special Program</option>
							<?php //} ?>
						</select>
                    </div>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর কর্মরত Program !">&#8505;</a></div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Mother Department <span class="required">*</span></label>
                    <div class="col-md-2" style="padding-right:5px;">
                        <select name="mother_department_id" id="mother_department_id" required class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<option value="">Select</option>
							<option value="25">Microfinance</option>
							<option value="30">Special Program</option>
							<?php } else { ?>
							<option value="">Select</option>
							<option value="25">Microfinance</option>
							<option value="26">HR and Administration</option>
							<option value="27">Finance and Accounts</option>
							<option value="28">Audit and Monitoring</option>
							<option value="29">Digitisation</option>
							<option value="30">Special Program</option>
							<?php } ?>
						</select>
                    </div>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর  Department !">&#8505;</a></div>
					<label class="control-label col-md-2">Current Department <span class="required">*</span></label>
                    <div class="col-md-2" style="padding-right:5px;">
                        <select name="current_department_id" id="current_department_id" class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<option value="">Select</option>
							<option value="25">Microfinance</option>
							<option value="30">Special Program</option>
							<?php } else { ?>
							<option value="">Select</option>
							<option value="25">Microfinance</option>
							<option value="26">HR and Administration</option>
							<option value="27">Finance and Accounts</option>
							<option value="28">Audit and Monitoring</option>
							<option value="29">Digitisation</option>
							<option value="30">Special Program</option>
							<?php } ?>
						</select>
                    </div>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর কর্মরত Department !">&#8505;</a></div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Unit</label>
                    <?php if($session_branch_code != 9999) { ?>
					<div class="col-md-2" style="padding-right:5px;">
                        <select name="unit_id" id="unit_id" class="form-control">
							<option value="1">Microfinance</option>
							<option value="13">Education</option>
						</select>
                    </div>
					<?php } else { ?>
					<?php if(!empty($unit_id)): ?>
					<div class="col-md-2" style="padding-right:5px;">
						<select name="unit_id" id="unit_id"  class="form-control" >
							<?php $__currentLoopData = $all_unit_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unitname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($unitname->id == $unit_id): ?>
							<option value="<?php echo e($unitname->id); ?>" selected="selected"><?php echo e($unitname->unit_name); ?></option>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<?php else: ?>
					<div class="col-md-2" style="padding-right:5px;">
                        <select name="unit_id" id="unit_id" class="form-control">
							<option value="">Select</option>
							
						</select>
                    </div>
					<?php endif; ?>
					<?php } ?>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর কর্মরত Unit!">&#8505;</a></div>
                    <label class="control-label col-md-2">Project <span class="required">*</span></label>
                    <div class="col-md-2" style="padding-right:5px;">
                        <select name="project_id" required id="project_id" class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<option value="">Select</option>
							<option value="1">Microfinance</option>
							<option value="5">Education</option>
							<?php } else { ?>
							<option value="">Select</option>
							<?php foreach ($all_project as $project) { ?>
							<option value="<?php echo $project->id; ?>"><?php echo $project->project_name; ?></option>
							<?php } } ?>
						</select>
                    </div>
					<div style="padding-left: 1px;" class="col-md-1"><a data-toggle="tooltip" data-placement="top" title="Staff এর Project!">&#8505;</a></div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Supervisor <span class="required">*</span></label>
                    <div class="col-md-3">
						<select name="reported_to" id="reported_to" required class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<option value="16">BM</option>
							<?php } else { ?>
							<option value="">Select</option>
							<?php foreach ($all_supervisors as $supervisors) { ?>
							<option value="<?php echo $supervisors->supervisors_emp_id; ?>"><?php echo $supervisors->supervisors_name; ?></option>
							<?php } } ?>
						</select>
                    </div>
					<label class="control-label col-md-2">Letter Date <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="date" name="letter_date" id="letter_date" class="form-control" required value="<?php echo e($letter_date); ?>"  >
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Org. Joining Date <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="date" name="joining_date" id="joining_date" value="<?php echo e($joining_date); ?>" required class="form-control" onchange="set_permanent_date();"  <?php if($session_branch_code != 9999){   if($id == '' ){ ?> min="<?php echo date("Y-m-01");?>" <?php }   }  ?> >
						<input type="hidden" name="next_permanent_date" id="next_permanent_date" class="form-control" >
                    </div>
					<label class="control-label col-md-2">Br. Join Date <span class="required">*</span></label>
                    <div class="col-md-3">
						<input type="date" class="form-control" name="br_join_date" id="br_join_date" value="<?php echo e($br_join_date); ?>" required   <?php if($session_branch_code != 9999){   if($id == '' ){ ?> min="<?php echo date("Y-m-01");?>" <?php }   }  ?> >
                    </div>					
                </div>
				<div class="form-group">                    
					<label class="control-label col-md-2">Joining Branch <span class="required">*</span></label>
                    <div class="col-md-3">
                         <select name="joining_branch" id="joining_branch" required class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($v_branches->br_code == $joining_branch): ?>
							<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php } else { ?>
							<option value="">-Select Branch-</option>
							<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php } ?>
						</select>
                    </div>
					<label class="control-label col-md-2">Salary Branch <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select name="salary_br_code" id="salary_br_code" required class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($v_branches->br_code == $salary_br_code): ?>
							<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php } else { ?>
							<option value="">-Select Branch-</option>
							<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php } ?>
						</select>
                    </div>
                </div>
				<div class="form-group">
					<label class="control-label col-md-2">Joining Staff As <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select name="join_as" id="join_as" required class="form-control">
							<?php if($session_branch_code != 9999) { ?>
							<option value="3">Contractual</option>
							<?php } else { ?>
							<option value="">Select </option>
							<option value="1">Probation</option>
							<option value="3">Contractual</option>
							<option value="4">Volunteer</option>
							<?php } ?>
						</select>
                    </div>
					<label class="control-label col-md-2">Designation <span class="required">*</span></label>
                    <?php if($session_branch_code != 9999) { ?>
					<div class="col-md-2" style="padding-right:5px;">
                        <select name="emp_designation" id="emp_designation" onchange="myFunction2()" required class="form-control">
							<option value="" hidden>-Select-</option>
							<option value="74">Cook</option>
							<option value="242">Teacher (shisok)</option>
						</select>
                    </div>
					<?php } else { ?>
					<div class="col-md-3">
                        <select class="form-control" name="emp_designation" id="emp_designation" required>
							<option value="" hidden>-Select-</option>
							<?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_designation->designation_code); ?>"><?php echo e($v_designation->designation_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                    </div>
					<?php } ?>
                </div>								
				<div class="form-group" id="geadestep" style="display: none;">
                    <label class="control-label col-md-2">Grade <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select class="form-control" id="grade_code" name="grade_code" >						
							<option value="0" >-Select-</option>
							<?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_grades): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_grades->grade_code); ?>"><?php echo e($v_grades->grade_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                    </div>
					<label class="control-label col-md-2">Grade Step <span class="required">*</span></label>
                    <div class="col-md-3">
                        <select class="form-control" id="grade_step" name="grade_step" >
							<?php foreach($all_grade_step as $grade_step_id => $grade_step_name){?>
							<option value="<?php echo $grade_step_id;?>"><?php echo $grade_step_name;?></option>
							<?php } ?>
						</select>
                    </div>
                </div>
				<div class="form-group">
					<div id="probation" style="display: none;">
					<label class="control-label col-md-2">probation (Month) <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="period" id="period" value="<?php echo e($period); ?>" onchange="set_permanent_date();" >
                    </div>
                    </div>
					<div id="contract_ending" style="display: none;">
					<label class="control-label col-md-2" id="c_end_date_lebel">Contract Ending Date </label>
                    <div class="col-md-3">
                        <input type="date" name="c_end_date" readonly id="c_end_date" value="<?php echo e($next_permanent_date); ?>" class="form-control" <?php if($session_branch_code != 9999){   if($id == '' ){ ?> min="<?php echo date("Y-m-01");?>" <?php }   }  ?> >
                        Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_contract_end_type()" id="end_type" value="" <?php echo empty($next_permanent_date) ? 'checked':'';?>  >
                    </div>
                    </div>
					
					<label class="control-label col-md-2" id="c_end_date_lebel">Basic Salary <span class="required">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="gross_salary" id="gross_salary" value="<?php echo e($gross_salary); ?>" required class="form-control" onkeypress="return IsNumeric(event,'error1');" onpaste="return false;" ondrop = "return false;"><span id="error1" style="color: Red; display: none">Only Numbers</span>
                    </div>
                   
                </div>
				<div class="form-group">
					<div id="contract_endings" > 				
						<label class="control-label col-md-2" id="c_end_date_lebel">Referance ID </label>
						<div class="col-md-3">
							<input type="text" name="reference_id" id="reference_id" value="<?php echo e($reference_id); ?>" class="form-control" onkeypress="return IsNumeric(event,'error2');" onpaste="return false;" ondrop = "return false;">
							<span id="error2" style="color: Red; display: none">Only Numbers</span>
						</div>
                   </div>
                </div>
				<div class="box-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Reset</button>
					<button type="sublit" id="btnSave" class="btn btn-primary"><?php echo e($button_text); ?></button>					
				</div>
			</form>

		</div>
		</div>
		</div>
		<!--<div class="modal fade bd-example-modal-sm" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="width: 20%;" role="document">
				<div class="modal-content" style="top: 200px;">
					<div class="modal-body">
					
					</div>
					<div class="modal-footer" style="padding: 6px;">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>-->
		<!--<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="width: 20%;" role="document">
				<div class="modal-content" style="top: 200px;">
					<div class="modal-body">
					
					</div>
					<div class="modal-footer" style="padding: 6px;">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>-->
	</section>
	<script src="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>
<script>
$(document).ready(function() {
	$('#birth_date').datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true,yearRange: "1940:2005" });
});
/* $(document).ready(function(){
  $('[data-toggle="tooltip"]') = $.fn.tooltip.noConflict(); 
}); */
/* $(function () {
  $('[data-toggle="tooltip"]').tooltip()
}) */
/* $(window).on('load',function(){
	$('#addModal').modal('show');
	var msg = '<?php echo e(Session::get('message')); ?>';
	$('.modal-body').html(msg);
}); */

$(document).ready(function(){   
    $("#national_id").keyup(function(){  
        var national_id = $(this).val();
		if(national_id == ''){
			$('#birth_certificate').attr('required', 'required');
		} else {
			$('#birth_certificate').removeAttr("required");
		}
    });  
});

$(document).ready(function(){   
    $("#birth_certificate").keyup(function(){  
        var birth_certificate = $(this).val();
		if(birth_certificate == ''){
			$('#national_id').attr('required', 'required');
		} else {
			$('#national_id').removeAttr("required");
		}
    });  
});

function validateForm()
	{
		var national_id = $('#national_id').val();
		var emp_id = $('#emp_id').val();
		var id = $('#id').val();
		//alert(id);
		if(national_id != '') {
		var return_type = false;
		$.ajax({
			url : "<?php echo e(URL::to('select-nationalid')); ?>"+"/"+national_id+"/"+emp_id+"/"+id,
			type: "GET",
			async: false,
			success: function(data)
			{
				
				if(data == 0){
					alert('National ID Already Exists!');
					$('#national_id').val('');
					 $("#national_id").focus();
					return_type = false;
				}else{
					return_type = true;
				}
				 
			}
		});
		return return_type;
		} 
	}
</script>	
<script>
	$('.select2').select2();
	
	$(document).on("change", "#emp_group", function () {
		var emp_group = $(this).val();   
		//alert(emp_group);
		$.ajax({
			url : "<?php echo e(url::to('select-emp-type')); ?>"+"/"+emp_group,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#emp_type").html(data);
				var joining_date = document.getElementById("joining_date").value;
				var period = document.getElementById("period").value;
				var d = new Date(joining_date);
				d.setMonth(d.getMonth() + parseFloat(period));
				var dateFormated = d.toISOString().substr(0,10);
				document.getElementById("next_permanent_date").value = dateFormated;
			}
		});
		if(emp_group == 1) {
			$("#geadestep").show();
			$('#grade_code').attr('required', 'required');
			$('#grade_step').attr('required', 'required');
			$("#probation").show();
			$("#contract_ending").hide();
		} else {
			$("#geadestep").hide();
			$('#grade_code').removeAttr("required");
			$('#grade_code').removeAttr("required");
			//$('#grade_code').val("");
			//$('#grade_step').val("");
			$("#probation").hide();
			$("#contract_ending").show();
		}		
	});
	
	$(document).on("change", "#current_department_id", function () {
		var current_department_id = $(this).val();   
		//alert(current_department_id);
		 
		$.ajax({
			url : "<?php echo e(url::to('select-unit')); ?>"+"/"+current_department_id,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#unit_id").html(data);
				 
			}
		});  
	});
	
	$(document).on("change", "#emp_district", function () {
		var district_code = $(this).val();   
		//alert(district_code);
		 
		$.ajax({
			url : "<?php echo e(url::to('select-thana')); ?>"+"/"+district_code,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#upazila_id").attr("disabled", false);
				$("#upazila_id").html(data); 
				//$("#upazi_name").html(data); 
				 
			}
		});  
	});
	
	function change_contract_end_type()
		{
			var end_type = document.getElementById("end_type");				   
			if (end_type.checked == true){
				$('#c_end_date_lebel').html("Contract Ending Date:");
				$('#c_end_date').attr("readonly", true);  
				$('#c_end_date').removeAttr('required');
			} else {
				$('#c_end_date_lebel').html("Contract Ending Date: <span style='color:red;'>*</span>");
				$('#c_end_date').removeAttr('readonly');
				$('#c_end_date').attr("required", true);				
			}
			
		}		
</script>
<script>
	var specialKeys = new Array();
	specialKeys.push(9); //Tab
	var specialKeysb = new Array();
	specialKeysb.push(8); //backspace
	function IsNumeric(e,id) {
		var keyCode = e.which ? e.which : e.keyCode;
		var ret = ((keyCode >= 48 && keyCode <= 57)|| keyCode == 46 || specialKeys.indexOf(keyCode) != -1 || specialKeysb.indexOf(keyCode) != -1);
		document.getElementById(id).style.display = ret ? "none" : "inline";
		return ret;
	}		
</script>	
	<script>
	document.getElementById("emp_district").value= "<?php echo e($emp_district); ?>";
	document.getElementById("religion").value= "<?php echo e($religion); ?>";
	document.getElementById("maritial_status").value= "<?php echo e($maritial_status); ?>";
	document.getElementById("blood_group").value= "<?php echo e($blood_group); ?>";
	document.getElementById("gender").value= "<?php echo e($gender); ?>";
	document.getElementById("emp_group").value= "<?php echo e($emp_group); ?>";
	document.getElementById("join_as").value= "<?php echo e($join_as); ?>";
	document.getElementById("joining_branch").value= "<?php echo e($joining_branch); ?>";
	document.getElementById("emp_designation").value= "<?php echo e($emp_designation); ?>";
	document.getElementById("salary_br_code").value= "<?php echo e($salary_br_code); ?>";
	document.getElementById("grade_code").value= "<?php echo e($grade_code); ?>";
	document.getElementById("grade_step").value= "<?php echo e($grade_step); ?>";
	document.getElementById("reported_to").value= "<?php echo e($reported_to); ?>";
	document.getElementById("mother_program_id").value= "<?php echo e($mother_program_id); ?>";
	document.getElementById("current_program_id").value= "<?php echo e($current_program_id); ?>";
	document.getElementById("mother_department_id").value= "<?php echo e($mother_department_id); ?>";
	document.getElementById("current_department_id").value= "<?php echo e($current_department_id); ?>";
	document.getElementById("unit_id").value= "<?php echo e($unit_id); ?>";
	document.getElementById("project_id").value= "<?php echo e($project_id); ?>";
	
	var emp_group = "<?php echo e($emp_group); ?>";
	if(emp_group == 1) {
		$("#geadestep").show();
		$('#grade_code').attr('required', 'required');
		$('#grade_step').attr('required', 'required');
		$("#probation").show();
		$("#contract_ending").hide();
	} else {
		$("#geadestep").hide();
		$('#grade_code').removeAttr("required");
		$('#grade_code').removeAttr("required");
		//$('#grade_code').val("");
		//$('#grade_step').val("");
		$("#probation").hide();
		$("#contract_ending").show();
	}
	
	
	
	function set_permanent_date()
	{
		var joining_date = document.getElementById("joining_date").value;
		var period = document.getElementById("period").value;
		var d = new Date(joining_date);
		d.setMonth(d.getMonth() + parseFloat(period));
		var dateFormated = d.toISOString().substr(0,10);
		document.getElementById("next_permanent_date").value = dateFormated;
	}
	
	
	function myFunction() {
	  var x = document.getElementById("emp_type").value;
	  
	  if(x==5){
		document.getElementById('mother_program_id').value = 1;
		document.getElementById('current_program_id').value = 1;  
		document.getElementById('mother_department_id').value = 25;
		document.getElementById('current_department_id').value = 25;
		document.getElementById('unit_id').value = 1;
		document.getElementById('project_id').value = 1;
	  } else if (x==9) {		  
		  document.getElementById('mother_program_id').value = 2;
		  document.getElementById('current_program_id').value = 2;
		  document.getElementById('mother_department_id').value = 30;
		  document.getElementById('current_department_id').value = 30;
		  document.getElementById('unit_id').value = 13;
		  document.getElementById('project_id').value = 5;
	  }
	}
	
	function myFunction2() {
	  var x = document.getElementById("emp_designation").value;
	  
	  if(x==74){
		document.getElementById('mother_program_id').value = 1;
		document.getElementById('current_program_id').value = 1;  
		document.getElementById('mother_department_id').value = 25;
		document.getElementById('current_department_id').value = 25;
		document.getElementById('unit_id').value = 1;
		document.getElementById('project_id').value = 1;
	  } else if (x==242) {		  
		  document.getElementById('mother_program_id').value = 2;
		  document.getElementById('current_program_id').value = 2;
		  document.getElementById('mother_department_id').value = 30;
		  document.getElementById('current_department_id').value = 30;
		  document.getElementById('unit_id').value = 13;
		  document.getElementById('project_id').value = 5;
	  }
	}
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Appointment").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>