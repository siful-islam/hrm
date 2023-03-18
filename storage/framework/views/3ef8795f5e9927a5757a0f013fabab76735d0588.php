<?php $__env->startSection('main_content'); ?>
<style>
.image-upload > input
{
    display: none;
}
.image-upload img
{
	margin-right:0;
	width:120px;
	height:130px;
    cursor: pointer;	
	background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px; 
}
</style>
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content-header">
  <h4>Add-CV</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Employee</a></li>
	<li class="active">add-cv</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php if ($emp_cv['tab_id'] == 1) echo 'active';?>"><a href="#tab_general" data-toggle="tab">General Info</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 2) echo 'active';?>"><a href="#tab_education" data-toggle="tab">Education</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 3) echo 'active';?>"><a href="#tab_training" data-toggle="tab">Training</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 4) echo 'active';?>"><a href="#tab_experience" data-toggle="tab">Experience</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 5) echo 'active';?>"><a href="#tab_reference" data-toggle="tab">Reference</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 6) echo 'active';?>"><a href="#tab_photo" data-toggle="tab">Photo</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 7) echo 'active';?>"><a href="#tab_necessary_phone" data-toggle="tab">Necessary Phone No.</a></li>
              <li class="<?php if ($emp_cv['tab_id'] == 8) echo 'active';?>"><a href="#tab_other" data-toggle="tab">Other</a></li>
            </ul>
            
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
	</div>	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			<?php if(Session::has('message')): ?>
			<?php echo e(session('message')); ?>

			<?php endif; ?>
		</h3>-->
		<div class="tab-content">
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 1) echo 'active';?>" id="tab_general">
				<form action="<?php echo e(URL::to($emp_cv['action'])); ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

				<div class="col-md-6">
					<?php if(Session::has('message1')): ?>
					<h5 style="color:green">
					<?php echo e(session('message1')); ?>

					</h5>
					<?php endif; ?>
					<div class="box box-info">
						<div class="box-body">							
							<div class="form-group<?php echo e($errors->has('emp_id') ? ' has-error' : ''); ?>">
								<label for="emp_id" class="col-sm-4 control-label">Employee ID</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_id" id="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" readonly required autofocus class="form-control">
									<?php if($errors->has('emp_id')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('emp_id')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('emp_name_eng') ? ' has-error' : ''); ?>">
								<label for="emp_name_eng" class="col-sm-4 control-label">Employee Name (in English)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_name_eng" id="emp_name_eng " value="<?php echo e($emp_cv['emp_name']); ?>" readonly required class="form-control">
									<?php if($errors->has('emp_name_eng')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('emp_name_eng')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('emp_name_ban') ? ' has-error' : ''); ?>">
								<label for="emp_name_ban" class="col-sm-4 control-label">Employee Name (in Bengali)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_name_ban" id="emp_name_ban" value="<?php echo e($emp_cv['emp_name_ban']); ?>" required class="form-control">
									<?php if($errors->has('emp_name_ban')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('emp_name_ban')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('father_name') ? ' has-error' : ''); ?>">
								<label for="father_name" class="col-sm-4 control-label">Father's Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="father_name" id="father_name" value="<?php echo e($emp_cv['father_name']); ?>" readonly required class="form-control">
									<?php if($errors->has('father_name')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('father_name')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('mother_name') ? ' has-error' : ''); ?>">
								<label for="mother_name" class="col-sm-4 control-label">Mother's Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="mother_name" id="mother_name" value="<?php echo e($emp_cv['mother_name']); ?>" required class="form-control">
									<?php if($errors->has('mother_name')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('mother_name')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('birth_date') ? ' has-error' : ''); ?>">
								<label for="birth_date" class="col-sm-4 control-label">Date of Birth</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="birth_date" id="birth_date" value="<?php echo e($emp_cv['birth_date']); ?>" readonly required class="form-control">
									<?php if($errors->has('birth_date')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('birth_date')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('religion') ? ' has-error' : ''); ?>">
								<label for="religion" class="col-sm-4 control-label">Religion</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="religion" id="religion" required class="form-control">
										<option value="">Select</option>							
										<?php foreach($allreligions as $religionid => $religionname){?>
										<option value="<?php echo $religionid;?>"><?php echo $religionname;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('maritial_status') ? ' has-error' : ''); ?>">
								<label for="maritial_status" class="col-sm-4 control-label">Marital Status</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="maritial_status" id="maritial_status" required class="form-control">
										<option value="">Select</option>
										<option value="Married" <?php if($emp_cv['maritial_status']=="Married") echo 'selected="selected"'; ?> >Married</option>
										<option value="Unmarried" <?php if($emp_cv['maritial_status']=="Unmarried") echo 'selected="selected"'; ?> >Unmarried</option>
										<option value="N/A" <?php if($emp_cv['maritial_status']=="N/A") echo 'selected="selected"'; ?> >N/A</option>
									</select>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('nationality') ? ' has-error' : ''); ?>">
								<label for="nationality" class="col-sm-4 control-label">Nationality</label>
								<div class="col-sm-6">
									<input type="text" name="nationality" id="nationality" value="<?php echo e($emp_cv['nationality']); ?>" class="form-control">
									<?php if($errors->has('nationality')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('nationality')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('national_id') ? ' has-error' : ''); ?>">
								<label for="national_id" class="col-sm-4 control-label">National Id</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="national_id" id="national_id" value="<?php echo e($emp_cv['national_id']); ?>" required class="form-control">
									<?php if($errors->has('national_id')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('national_id')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>						
							<div class="form-group<?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
								<label for="gender" class="col-sm-4 control-label">Gender</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="gender" id="gender" required class="form-control">
										<option value="">Select</option>
										<option value="Male" <?php if($emp_cv['gender']=="Male") echo 'selected="selected"'; ?> >Male</option>
										<option value="Female" <?php if($emp_cv['gender']=="Female") echo 'selected="selected"'; ?> >Female</option>
									</select>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('country_id') ? ' has-error' : ''); ?>">
								<label for="country_id" class="col-sm-4 control-label">Country Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="country_id" id="country_id" required class="form-control">
										<option value="1">Bangladesh</option>
										<option value="2">India</option>
									</select>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">
							<div class="form-group<?php echo e($errors->has('contact_num') ? ' has-error' : ''); ?>">
								<label for="contact_num" class="col-sm-4 control-label">Contact Number</label>
								<div class="col-sm-6">
									<input type="text" name="contact_num" id="contact_num" value="<?php echo e($emp_cv['contact_num']); ?>" class="form-control">
									<?php if($errors->has('contact_num')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('contact_num')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
								<label for="email" class="col-sm-4 control-label">Email</label>
								<div class="col-sm-6">
									<input type="text" name="email" id="email" value="<?php echo e($emp_cv['email']); ?>" class="form-control">
									<?php if($errors->has('email')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('email')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('blood_group') ? ' has-error' : ''); ?>">
								<label for="blood_group" class="col-sm-4 control-label">Blood Group</label>
								<div class="col-sm-6">
									<select name="blood_group" id="blood_group" class="form-control">
										<option value="">Select</option>							
										<?php $__currentLoopData = $allbloods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bloodid => $bloodname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($bloodid); ?>"><?php echo e($bloodname); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('org_join_date') ? ' has-error' : ''); ?>">
								<label for="org_join_date" class="col-sm-4 control-label">Joining Date (Org.)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="date" name="org_join_date" id="start_date" value="<?php echo e($emp_cv['org_join_date']); ?>" required class="form-control">
									<?php if($errors->has('org_join_date')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('org_join_date')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('present_add') ? ' has-error' : ''); ?>">
								<label for="present_add" class="col-sm-4 control-label">Present Address</label>
								<div class="col-sm-6">
									<textarea name="present_add" class="form-control" ><?php echo e($emp_cv['present_add']); ?></textarea>
									<?php if($errors->has('present_add')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('present_add')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('vill_road') ? ' has-error' : ''); ?>">
								<label for="vill_road" class="col-sm-4 control-label">Vill / Road</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="vill_road" id="vill_road" value="<?php echo e($emp_cv['vill_road']); ?>" readonly required class="form-control">
									<?php if($errors->has('vill_road')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('vill_road')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('post_office') ? ' has-error' : ''); ?>">
								<label for="post_office" class="col-sm-4 control-label">Post Office</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="post_office" id="post_office" value="<?php echo e($emp_cv['post_office']); ?>" readonly required class="form-control">
									<?php if($errors->has('post_office')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('post_office')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group<?php echo e($errors->has('district_code') ? ' has-error' : ''); ?>">
								<label for="district_code" class="col-sm-4 control-label">District Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="district_code" id="district_code" readonly required class="form-control" style="pointer-events: none;">
										<option value="">Select</option>								
										<?php $__currentLoopData = $all_district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($district->district_code); ?>"><?php echo e($district->district_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>			
							<div class="form-group<?php echo e($errors->has('thana_code') ? ' has-error' : ''); ?>">
								<label for="thana_code" class="col-sm-4 control-label">Thana Name</label><span class="required">*</span>
								<?php if(!empty($emp_cv['thana_code'])): ?>
								<div class="col-sm-6">
									<select name="thana_code" id="upazila_id" readonly required class="form-control" style="pointer-events: none;">
										<?php $__currentLoopData = $all_thana; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($thana->thana_code == $emp_cv['thana_code']): ?>
										<option value="<?php echo e($thana->thana_code); ?>" selected="selected"><?php echo e($thana->thana_name); ?></option>
										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								<?php else: ?>
								<div class="col-sm-6">
									<select name="thana_code" disabled="disabled" id="upazila_id" required class="form-control">
										<option value="">Select</option>
									</select>
								</div>
								<?php endif; ?>
							</div>
							<div class="form-group<?php echo e($errors->has('permanent_add') ? ' has-error' : ''); ?>">
								<label for="permanent_add" class="col-sm-4 control-label">Permanent Address</label><span class="required">*</span>
								<div class="col-sm-6">
									<textarea name="permanent_add" class="form-control" id="address" ><?php echo e($emp_cv['permanent_add']); ?></textarea>
									<?php if($errors->has('permanent_add')): ?>
									<span class="help-block">
										<strong><?php echo e($errors->first('permanent_add')); ?></strong>
									</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="fun_desig_id" class="col-sm-4 control-label">Functional Designation</label>
								<div class="col-sm-6">
									<select name="fun_desig_id" id="fun_desig_id" class="form-control" >
										<option value="">Select</option>								
										<?php $__currentLoopData = $all_functional_designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $functional_designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($functional_designation->id); ?>"><?php echo e($functional_designation->fun_deg_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--Start education tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 2) echo 'active';?>" id="tab_education">
				<form action="<?php echo e(URL::to('/emp-edu')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">														
							<?php if(Session::has('message2')): ?>
							<h5 style="color:green">
							<?php echo e(session('message2')); ?>

							</h5>
							<?php endif; ?>
							<div class="table-responsive">
								<table id="education" class="table table-bordered">
									<thead>
									  <tr>
										<th>Exam Name</th>
										<th>Group / Subject</th>
										<th>Board / University</th>
										<th>Result</th>
										<th>Note</th>
										<th>Passing Year</th>
										<th></th>
									  </tr>
									</thead>
									<?php $education_row = 0; $i=1; 
									$edu_array = array(); foreach ($edu_up_val as $edu_val) {
									$edu_array[] = $edu_val->id;
									?>
									<tbody id="education-row<?php echo $education_row; ?>">
									  <tr>
										<td>
											<select style="width:150px;" name="edu_val[<?php echo $education_row; ?>][exam_code]" required class="form-control">
												<option value="">Select</option>							
												<?php foreach ($all_exam as $exam) { ?>
													<?php if($exam->exam_code==$edu_val->exam_code){ ?>
														<option value="<?php echo $exam->exam_code; ?>" selected="selected"><?php echo $exam->exam_name; ?></option>
														<?php } else { ?>
														<option value="<?php echo $exam->exam_code; ?>"><?php echo $exam->exam_name; ?></option>
														<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<select style="width:150px;" name="edu_val[<?php echo $education_row; ?>][subject_code]" required class="form-control">
												<option value="">Select</option>
												<?php foreach ($all_group_subject as $group_subject) { ?>
													<?php if($group_subject->subject_code==$edu_val->subject_code){ ?>
														<option value="<?php echo $group_subject->subject_code; ?>" selected="selected"><?php echo $group_subject->subject_name; ?></option>
														<?php } else {?>
														<option value="<?php echo $group_subject->subject_code; ?>"><?php echo $group_subject->subject_name; ?></option>
														<?php } ?>   
												<?php } ?>
											</select>
										</td>
										<td>
											<select style="width:150px;" name="edu_val[<?php echo $education_row; ?>][school_code]" required class="form-control">
												<option value="">Select</option>
												<?php foreach ($all_board_university as $board_university) { ?>
													<?php if($board_university->board_uni_code==$edu_val->school_code){ ?>
														<option value="<?php echo $board_university->board_uni_code; ?>" selected="selected"><?php echo $board_university->board_uni_name; ?></option>
														<?php } else {?>
														<option value="<?php echo $board_university->board_uni_code; ?>"><?php echo $board_university->board_uni_name; ?></option>
														<?php } ?>   
												<?php } ?>
											</select>
										</td>
										<input type="hidden" name="edu_val[<?php echo $education_row; ?>][id]" value="<?php echo e($edu_val->id); ?>" />
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][result]" value="<?php echo e($edu_val->result); ?>" required class="form-control" size="8"></td>
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][note]" value="<?php echo e($edu_val->note); ?>" class="form-control" size="8"></td>
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][pass_year]" value="<?php echo e($edu_val->pass_year); ?>" required class="form-control" size="8"></td>
										<td><a onclick="$('#education-row<?php echo $education_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $education_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="6"></td>
											<td class="left"><a onclick="addEducation();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value='<?php echo serialize($edu_array); ?>' />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end education tab-->
			<!--Start training tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 3) echo 'active';?>" id="tab_training">
				<form action="<?php echo e(URL::to('/emp-training')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							<?php if(Session::has('message3')): ?>
							<h5 style="color:green">
							<?php echo e(session('message3')); ?>

							</h5>
							<?php endif; ?>
							<div class="table-responsive">
								<table id="training" class="table table-bordered">
									<thead>
									  <tr>
										<th>Training Name</th>
										<th>Training Period From</th>
										<th>Training Period To</th>
										<th>Institute Name</th>
										<th>Place</th>
										<th>Remarks</th>
										<th></th>
									  </tr>
									</thead>
									<?php $training_row = 0; 
									$tra_array = array(); foreach ($tra_up_val as $tra_val) {
									$tra_array[] = $tra_val->id;
									?>
									<tbody id="training-row<?php echo $training_row; ?>">
									  <tr>
										<td>
											<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
											<input type="text" name="tra_val[<?php echo $training_row; ?>][tr_name]" value="<?php echo e($tra_val->train_name); ?>" required class="form-control" />
										</td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_period]" value="<?php echo e($tra_val->train_period); ?>" required class="form_date form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_period_to]" value="<?php echo e($tra_val->train_period_to); ?>" class="form_date form-control" /></td>
										<input type="hidden" name="tra_val[<?php echo $training_row; ?>][id]" value="<?php echo e($tra_val->id); ?>" />
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_institute]" value="<?php echo e($tra_val->institute); ?>" required class="form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_palace]" value="<?php echo e($tra_val->palace); ?>" required class="form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_remarks]" value="<?php echo e($tra_val->remarks); ?>" class="form-control" /></td>
										<td><a onclick="$('#training-row<?php echo $training_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $training_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="6"></td>
											<td class="left"><a onclick="addTraining();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value='<?php echo serialize($tra_array); ?>' />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end training tab-->		
			<!--Start experience tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 4) echo 'active';?>" id="tab_experience">
				<form action="<?php echo e(URL::to('/emp-experience')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							<?php if(Session::has('message4')): ?>
							<h5 style="color:green">
							<?php echo e(session('message4')); ?>

							</h5>
							<?php endif; ?>
							<div class="table-responsive">
								<table id="experience" class="table table-bordered">
									<thead>
									  <tr>
										<th>Designation</th>
										<th>Experience Period</th>
										<th>Organization Name</th>
										<th>Remarks</th>
										<th></th>
									  </tr>
									</thead>
									<?php $experience_row = 0; 
									$exp_array = array(); foreach ($exp_up_val as $exp_val) {
									$exp_array[] = $exp_val->id;
									?>
									<tbody id="experience-row<?php echo $experience_row; ?>">
									  <tr>
										<td>
											<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
											<input type="text" name="exp_val[<?php echo $experience_row; ?>][designation]" value="<?php echo e($exp_val->designation); ?>" required class="form-control" />
										</td>
										<input type="hidden" name="exp_val[<?php echo $experience_row; ?>][id]" value="<?php echo e($exp_val->id); ?>" />
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][exp_period]" value="<?php echo e($exp_val->experience_period); ?>" required class="form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][org_name]" value="<?php echo e($exp_val->organization_name); ?>" required class="form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][remarks]" value="<?php echo e($exp_val->remarks); ?>" class="form-control" /></td>
										<td><a onclick="$('#experience-row<?php echo $experience_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $experience_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="4"></td>
											<td class="left"><a onclick="addExperience();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value='<?php echo serialize($exp_array); ?>' />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end experience tab-->  
			<!--Start reference tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 5) echo 'active';?>" id="tab_reference">
				<form action="<?php echo e(URL::to('/emp-reference')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							<?php if(Session::has('message5')): ?>
							<h5 style="color:green">
							<?php echo e(session('message5')); ?>

							</h5>
							<?php endif; ?>
							<div class="table-responsive">
								<table id="reference" class="table table-bordered">
									<thead>
									  <tr>
										<th>Name</th>
										<th>Occupation</th>
										<th>Address</th>
										<th>Contact No</th>
										<th>Email</th>
										<th>National ID</th>
										<th>Remarks</th>
										<th></th>
									  </tr>
									</thead>
									<?php $reference_row = 0; $i=1; 
									$refer_array = array(); foreach ($ref_up_val as $refer_val) {
									$refer_array[] = $refer_val->id;
									?>
									<tbody id="reference-row<?php echo $reference_row; ?>">
									  <tr>
										<td>
											<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
											<input type="text" name="refer_val[<?php echo $reference_row; ?>][refer_name]" value="<?php echo e($refer_val->rf_name); ?>" required class="form-control" />
										</td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][occupation]" value="<?php echo e($refer_val->rf_occupation); ?>" required class="form-control" /></td>
										<input type="hidden" name="refer_val[<?php echo $reference_row; ?>][id]" value="<?php echo e($refer_val->id); ?>" />
										<td><textarea name="refer_val[<?php echo $reference_row; ?>][address]" rows="2" required class="form-control" ><?php echo e($refer_val->rf_address); ?></textarea></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][contact_no]" value="<?php echo e($refer_val->rf_mobile); ?>" required class="form-control" /></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][email]" value="<?php echo e($refer_val->rf_email); ?>" size="16" class="form-control" /></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][nid]" value="<?php echo e($refer_val->rf_national_id); ?>" size="14" class="form-control" /></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][remarks]" value="<?php echo e($refer_val->rf_remarks); ?>" size="12" class="form-control" /></td>
										<td><a onclick="$('#reference-row<?php echo $reference_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $reference_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="7"></td>
											<td class="left"><a onclick="addReference();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value='<?php echo serialize($refer_array); ?>' />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end reference tab-->
			<!--Start photo tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 6) echo 'active';?>" id="tab_photo">
				<form action="<?php echo e(URL::to('/emp-photo')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							<?php if(Session::has('message6')): ?>
							<h5 style="color:green">
							<?php echo e(session('message6')); ?>

							</h5>
							<?php endif; ?>
					
							<table id="photo" class="table table-bordered">
								<td style="width:20%;">  
									<div class="image-upload">
									
										<?php if($emp_photo_val): ?>
										<label for="file-input">
											<img id="blah" class="img-thumbnail" src="<?php echo e(asset('public/employee/'.$emp_photo_val->emp_photo)); ?>" width="100"/> 
										</label> 
										<?php else: ?>
										<label for="file-input">
											<img id="blah" class="img-thumbnail" src="<?php echo e(asset('public/employee/placeholder.png')); ?>" width="100"/> 
										</label> 
										<?php endif; ?>
										<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
										<input onchange="readURL(this);" id="file-input" name="emp_photo" type="file"/> 
										<strong><br>Employee Photo Upload</strong>
									</div> 
								</td>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end photo tab-->
			<!--Start necessary phone tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 7) echo 'active';?>" id="tab_necessary_phone">
				<form action="<?php echo e(URL::to('/emp-necessary_phone')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							<?php if(Session::has('message7')): ?>
							<h5 style="color:green">
							<?php echo e(session('message7')); ?>

							</h5>
							<?php endif; ?>
							<div class="table-responsive">
								<table id="neces_phone" class="table table-bordered">
									<thead>
									  <tr>
										<th>Name</th>
										<th>Relation</th>
										<th>Address</th>
										<th>Contact No</th>
										<th>Email</th>
										<th>National ID</th>
										<th>Remarks</th>
										<th></th>
									  </tr>
									</thead>
									<?php $neces_phone_row = 0; 
									$neces_array = array(); foreach ($neces_phone_up_val as $neces_phone_val) {
									$neces_array[] = $neces_phone_val->id;
									?>
									<tbody id="neces_phone-row<?php echo $neces_phone_row; ?>">
									  <tr>
										<td>
											<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
											<input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][name]" value="<?php echo e($neces_phone_val->name); ?>" required class="form-control" />
										</td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][relation]" value="<?php echo e($neces_phone_val->relation); ?>" required class="form-control" /></td>
										<input type="hidden" name="neces_phone_val[<?php echo $neces_phone_row; ?>][id]" value="<?php echo e($neces_phone_val->id); ?>" />
										<td><textarea name="neces_phone_val[<?php echo $neces_phone_row; ?>][address]" rows="2" required class="form-control" ><?php echo e($neces_phone_val->address); ?></textarea></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][contact_no]" value="<?php echo e($neces_phone_val->mobile); ?>" required class="form-control" /></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][email]" value="<?php echo e($neces_phone_val->email); ?>" size="16" class="form-control" /></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][nid]" value="<?php echo e($neces_phone_val->national_id); ?>" size="14" class="form-control" /></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][remarks]" value="<?php echo e($neces_phone_val->remarks); ?>" size="12" class="form-control" /></td>
										<td><a onclick="$('#neces_phone-row<?php echo $neces_phone_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $neces_phone_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="7"></td>
											<td class="left"><a onclick="addNecesPhone();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value='<?php echo serialize($neces_array); ?>' />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end necessary phone tab-->
			<!--Start other paper tab-->
			<div class="tab-pane <?php if ($emp_cv['tab_id'] == 8) echo 'active';?>" id="tab_other">
				<form action="<?php echo e(URL::to('/emp-other')); ?>" method="post" class="form-inline" enctype="multipart/form-data">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							<?php if(Session::has('message8')): ?>
							<h5 style="color:green">
							<?php echo e(session('message8')); ?>

							</h5>
							<?php endif; ?>
					
							<table id="other" class="table table-bordered">
								<thead>
								  <tr>
									<th>Subject</th>
									<th>Details</th>
									<th></th>
								  </tr>
								</thead>
								<?php $other_row = 0; 
								$other_array = array(); foreach ($other_up_val as $other_val) {
								$other_array[] = $other_val->id;
								?>
								<tbody id="other-row<?php echo $other_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="<?php echo e($emp_cv['emp_id']); ?>" >
										<input type="text" name="other_val[<?php echo $other_row; ?>][subject]" value="<?php echo e($other_val->op_subject); ?>" required class="form-control" />
									</td>
									<input type="hidden" name="other_val[<?php echo $other_row; ?>][id]" value="<?php echo e($other_val->id); ?>" />
									<td><textarea name="other_val[<?php echo $other_row; ?>][details]" rows="2" col="10" required class="form-control" ><?php echo e($other_val->op_details); ?></textarea></td>
									<td><a onclick="$('#other-row<?php echo $other_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $other_row++; ?>
								<?php } ?>
								<tfoot>
									<tr>
										<td colspan="2"></td>
										<td class="left"><a onclick="addOther();" class="btn bg-navy">Add</a></td>
										<input type="hidden" name="val_id" value='<?php echo serialize($other_array); ?>' />
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="<?php echo e(URL::to('/emp-cv')); ?>" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end other paper tab-->
		</div>
	</div>
</section>
<script>
	$(document).on("change", "#district_code", function () {
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
</script>
<script>
	//document.getElementById("country_id").value="<?php echo e($emp_cv['country_id']); ?>";
	document.getElementById("blood_group").value="<?php echo e($emp_cv['blood_group']); ?>";
	//document.getElementById("blood_group").value="<?php echo $emp_cv['blood_group'];?>";
	document.getElementById("religion").value="<?php echo e($emp_cv['religion']); ?>";
	document.getElementById("district_code").value="<?php echo e($emp_cv['district_code']); ?>";
	document.getElementById("fun_desig_id").value="<?php echo e($emp_cv['fun_desig_id']); ?>";
</script>
<script type="text/javascript">
	$(function() {
        //alert ('sssss');
		var v='Vill';
		var p='Post';
		var t='Thana';
		var d='Dist';
		var text=document.getElementById('vill_road').value;
        var text1=document.getElementById('post_office').value;
		var text2=document.getElementById('upazila_id').selectedOptions[0].text;
		var text3=document.getElementById('district_code').selectedOptions[0].text;
		document.getElementById('address').value= v + ":" + " " + text + "," + " " + p + ":" + " " + text1 + "," + " " + t + ":" + " " + text2 + "," + " " + d + ":" + " " + text3;
    });
</script> 
<script type="text/javascript">
var education_row = <?php echo $education_row; ?>;
function addEducation() {
	//alert (education_row);
	html  = '<tbody id="education-row' + education_row + '">';
	html += '  <tr>'; 
    html += '    <td><select style="width:150px;" name="edu_val[' + education_row + '][exam_code]" required class="form-control">';
    html += '    <option value="">Select</option>';
	<?php foreach ($all_exam as $exam) { ?>
    html += '      <option value="<?php echo $exam->exam_code; ?>"><?php echo addslashes($exam->exam_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
	html += '    <td><select style="width:150px;" name="edu_val[' + education_row + '][subject_code]" required class="form-control">';
	html += '    <option value="">Select</option>';
	<?php foreach ($all_group_subject as $group_subject) { ?>
    html += '      <option value="<?php echo $group_subject->subject_code; ?>"><?php echo addslashes($group_subject->subject_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
	html += '    <td><select style="width:150px;" name="edu_val[' + education_row + '][school_code]" required class="form-control">';
    html += '    <option value="">Select</option>';
	<?php foreach ($all_board_university as $board_university) { ?>
    html += '      <option value="<?php echo $board_university->board_uni_code; ?>"><?php echo addslashes($board_university->board_uni_name); ?></option>';
    <?php } ?>
    html += '    </select></td>';
	html += '    <input type="hidden" name="edu_val[' + education_row + '][id]" value="" />';
	html += '    <td><input type="text" name="edu_val[' + education_row + '][result]" value="" size="8" required class="form-control"/></td>';
    html += '    <td><input type="text" name="edu_val[' + education_row + '][note]" value="" size="8" class="form-control"/></td>';
	html += '    <td><input type="text" name="edu_val[' + education_row + '][pass_year]" value="" size="8" required class="form-control"/></td>';
	html += '    <td><a onclick="$(\'#education-row' + education_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#education tfoot').before(html);
	
	education_row++;
}

var training_row = <?php echo $training_row; ?>;
function addTraining() {
	//alert (1);
	html  = '<tbody id="training-row' + training_row + '">';
	html += '  <tr>'; 
    html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_name]" value="" required class="form-control" /></td>';
	html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_period]" value="" required class="form_date form-control" /></td>';
	html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_period_to]" value="" class="form_date form-control" /></td>';
	html += '    <input type="hidden" name="tra_val[' + training_row + '][id]" value="" />';
	html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_institute]" value="" required class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_palace]" value="" required class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_remarks]" value="" class="form-control" /></td>';
	html += '    <td class="left"><a onclick="$(\'#training-row' + training_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#training tfoot').before(html);
	$('#training-row' + training_row + ' .form_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	training_row++;
}

var experience_row = <?php echo $experience_row; ?>;
function addExperience() {
	//alert (1);
	html  = '<tbody id="experience-row' + experience_row + '">';
	html += '  <tr>'; 
    html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][designation]" value="" required class="form-control" /></td>';
	html += '    <input type="hidden" name="exp_val[' + experience_row + '][id]" value="" />';
	html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][exp_period]" value="" required class="form-control" /></td>';
	html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][org_name]" value="" class="form-control" required/></td>';
    html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][remarks]" value="" class="form-control" /></td>';
	html += '    <td class="left"><a onclick="$(\'#experience-row' + experience_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#experience tfoot').before(html);
	
	experience_row++;
}

var reference_row = <?php echo $reference_row; ?>;
function addReference() {
	//alert (1);
	html  = '<tbody id="reference-row' + reference_row + '">';
	html += '  <tr>'; 
    html += '    <input type="hidden" name="refer_val[' + reference_row + '][id]" value="" />';
	html += '    <td class="left"><input type="text" name="refer_val[' + reference_row + '][refer_name]" value="" required class="form-control" /></td>';
	html += '    <td class="left"><input type="text" name="refer_val[' + reference_row + '][occupation]" value="" required class="form-control" /></td>';
	html += '    <input type="hidden" name="refer_val[' + reference_row + '][id]" value="" />';
	html += '    <td class="left"><textarea name="refer_val[' + reference_row + '][address]" value="" rows="2" required class="form-control" ></textarea></td>';
    html += '    <td class="left"><input type="text" name="refer_val[' + reference_row + '][contact_no]" value="" required class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="refer_val[' + reference_row + '][email]" value="" size="16" class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="refer_val[' + reference_row + '][nid]" value="" size="14" class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="refer_val[' + reference_row + '][remarks]" value="" size="12" class="form-control" /></td>';
	html += '    <td class="left"><a onclick="$(\'#reference-row' + reference_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#reference tfoot').before(html);
	
	reference_row++;
}

var neces_phone_row = <?php echo $neces_phone_row; ?>;
function addNecesPhone() {
	//alert (1);
	html  = '<tbody id="neces_phone-row' + neces_phone_row + '">';
	html += '  <tr>'; 
    html += '    <input type="hidden" name="neces_phone_val[' + neces_phone_row + '][id]" value="" />';
	html += '    <td class="left"><input type="text" name="neces_phone_val[' + neces_phone_row + '][name]" value="" required class="form-control" /></td>';
	html += '    <td class="left"><input type="text" name="neces_phone_val[' + neces_phone_row + '][relation]" value="" required class="form-control" /></td>';
	html += '    <input type="hidden" name="neces_phone_val[' + neces_phone_row + '][id]" value="" />';
	html += '    <td class="left"><textarea name="neces_phone_val[' + neces_phone_row + '][address]" value="" rows="2" required class="form-control" ></textarea></td>';
    html += '    <td class="left"><input type="text" name="neces_phone_val[' + neces_phone_row + '][contact_no]" value="" required class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="neces_phone_val[' + neces_phone_row + '][email]" value="" size="16" class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="neces_phone_val[' + neces_phone_row + '][nid]" value="" size="14" class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="neces_phone_val[' + neces_phone_row + '][remarks]" value="" size="12" class="form-control" /></td>';
	html += '    <td class="left"><a onclick="$(\'#neces_phone-row' + neces_phone_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#neces_phone tfoot').before(html);
	
	neces_phone_row++;
}

var other_row = <?php echo $other_row; ?>;
function addOther() {
	//alert (1);
	html  = '<tbody id="other-row' + other_row + '">';
	html += '  <tr>'; 
    html += '    <input type="hidden" name="other_val[' + other_row + '][id]" value="" />';
	html += '    <td class="left"><input type="text" name="other_val[' + other_row + '][subject]" value="" required class="form-control" /></td>';
	html += '    <input type="hidden" name="other_val[' + other_row + '][id]" value="" />';
	html += '    <td class="left"><textarea name="other_val[' + other_row + '][details]" value="" rows="2" col="10" required class="form-control" ></textarea></td>';
	html += '    <td class="left"><a onclick="$(\'#other-row' + other_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#other tfoot').before(html);
	
	other_row++;
}

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#blah')
				.attr('src', e.target.result)
				.css({'width' : '120px' , 'height' : '130px'});
		}; 
		reader.readAsDataURL(input.files[0]);
    }
}

</script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#birth_date').datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true,yearRange: "1940:2005" });
});
//--></script>
<script type="text/javascript">
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>