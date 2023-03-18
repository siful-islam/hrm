@extends('admin.admin_master')
@section('main_content')
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content-header">
  <h4>add-appointment</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-appointment</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_general" data-toggle="tab">General Info</a></li>
              <li><a href="#tab_education" data-toggle="tab">Education</a></li>
              <li><a href="#tab_training" data-toggle="tab">Training</a></li>
              <li><a href="#tab_experience" data-toggle="tab">Experience</a></li>
              <li><a href="#tab_reference" data-toggle="tab">Reference</a></li>
              <li><a href="#tab_photo" data-toggle="tab">Photo</a></li>
              <li><a href="#tab_necessary_phone" data-toggle="tab">Necessary Phone No.</a></li>
              <li><a href="#tab_other" data-toggle="tab">Other</a></li>
            </ul>
            
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
	</div>	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			@if(Session::has('message'))
			{{session('message')}}
			@endif
		</h3>-->
		<div class="tab-content">
			<div class="tab-pane active" id="tab_general">
				<form action="{{URL::to($emp_cv['action'])}}" method="post" class="form-horizontal" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">							
							<div class="form-group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
								<label for="emp_id" class="col-sm-4 control-label">Employee ID</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_id" id="emp_id" value="{{$emp_cv['emp_id']}}" readonly required autofocus class="form-control">
									@if ($errors->has('emp_id'))
									<span class="help-block">
										<strong>{{ $errors->first('emp_id') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('emp_name_eng') ? ' has-error' : '' }}">
								<label for="emp_name_eng" class="col-sm-4 control-label">Employee Name (ENG)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_name_eng" id="emp_name_eng " value="{{$emp_cv['emp_name']}}" readonly required class="form-control">
									@if ($errors->has('emp_name_eng'))
									<span class="help-block">
										<strong>{{ $errors->first('emp_name_eng') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('emp_name_ban') ? ' has-error' : '' }}">
								<label for="emp_name_ban" class="col-sm-4 control-label">Employee Name (Bang)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_name_ban" id="emp_name_ban" value="{{$emp_cv['emp_name_ban']}}" readonly required class="form-control">
									@if ($errors->has('emp_name_ban'))
									<span class="help-block">
										<strong>{{ $errors->first('emp_name_ban') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
								<label for="father_name" class="col-sm-4 control-label">Father's Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="father_name" id="father_name" value="{{$emp_cv['father_name']}}" readonly required class="form-control">
									@if ($errors->has('father_name'))
									<span class="help-block">
										<strong>{{ $errors->first('father_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
								<label for="mother_name" class="col-sm-4 control-label">Mother's Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="mother_name" id="mother_name" value="{{$emp_cv['mother_name']}}" required class="form-control">
									@if ($errors->has('mother_name'))
									<span class="help-block">
										<strong>{{ $errors->first('mother_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
								<label for="birth_date" class="col-sm-4 control-label">Date of Birth</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="date" name="birth_date" id="birth_date" value="{{$emp_cv['birth_date']}}" class="form-control">
									@if ($errors->has('birth_date'))
									<span class="help-block">
										<strong>{{ $errors->first('birth_date') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
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
							<div class="form-group{{ $errors->has('maritial_status') ? ' has-error' : '' }}">
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
							<div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
								<label for="nationality" class="col-sm-4 control-label">Nationality</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="nationality" id="nationality" value="{{$emp_cv['nationality']}}" required class="form-control">
									@if ($errors->has('nationality'))
									<span class="help-block">
										<strong>{{ $errors->first('nationality') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('national_id') ? ' has-error' : '' }}">
								<label for="national_id" class="col-sm-4 control-label">National Id</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="national_id" id="national_id" value="{{$emp_cv['national_id']}}" required class="form-control">
									@if ($errors->has('national_id'))
									<span class="help-block">
										<strong>{{ $errors->first('national_id') }}</strong>
									</span>
									@endif
								</div>
							</div>						
							<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
								<label for="gender" class="col-sm-4 control-label">Gender</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="gender" id="gender" required class="form-control">
										<option value="">Select</option>
										<option value="Male" <?php if($emp_cv['gender']=="Male") echo 'selected="selected"'; ?> >Male</option>
										<option value="Female" <?php if($emp_cv['gender']=="Female") echo 'selected="selected"'; ?> >Female</option>
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
								<label for="country_id" class="col-sm-4 control-label">Country Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="country_id" id="country_id" required class="form-control">
										<option value="">Select</option>							
										<?php foreach($all_countries as $countryid => $countryname){?>
										<option value="<?php echo $countryid;?>"><?php echo $countryname;?></option>
										<?php } ?>
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
							<div class="form-group{{ $errors->has('contact_num') ? ' has-error' : '' }}">
								<label for="contact_num" class="col-sm-4 control-label">Contact Number</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="contact_num" id="contact_num" value="{{$emp_cv['contact_num']}}" required class="form-control">
									@if ($errors->has('contact_num'))
									<span class="help-block">
										<strong>{{ $errors->first('contact_num') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="email" class="col-sm-4 control-label">Email</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="email" id="email" value="{{$emp_cv['email']}}" required class="form-control">
									@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
								<label for="blood_group" class="col-sm-4 control-label">Blood Group</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="blood_group" id="blood_group" required class="form-control">
										<option value="">Select</option>							
										@foreach($allbloods as $bloodid => $bloodname)
										<option value="{{$bloodid}}">{{$bloodname}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('org_join_date') ? ' has-error' : '' }}">
								<label for="org_join_date" class="col-sm-4 control-label">Joining Date (Org.)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="date" name="org_join_date" id="start_date" value="{{$emp_cv['org_join_date']}}" readonly required class="form-control">
									@if ($errors->has('org_join_date'))
									<span class="help-block">
										<strong>{{ $errors->first('org_join_date') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('present_add') ? ' has-error' : '' }}">
								<label for="present_add" class="col-sm-4 control-label">Present Address</label><span class="required">*</span>
								<div class="col-sm-6">
									<textarea name="present_add" class="form-control">{{$emp_cv['present_add']}}</textarea>
									@if ($errors->has('present_add'))
									<span class="help-block">
										<strong>{{ $errors->first('present_add') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('vill_road') ? ' has-error' : '' }}">
								<label for="vill_road" class="col-sm-4 control-label">Vill / Road</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="vill_road" id="vill_road" value="{{$emp_cv['vill_road']}}" readonly required class="form-control">
									@if ($errors->has('vill_road'))
									<span class="help-block">
										<strong>{{ $errors->first('vill_road') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('post_office') ? ' has-error' : '' }}">
								<label for="post_office" class="col-sm-4 control-label">Post Office</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="post_office" id="post_office" value="{{$emp_cv['post_office']}}" readonly required class="form-control">
									@if ($errors->has('post_office'))
									<span class="help-block">
										<strong>{{ $errors->first('post_office') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('district_code') ? ' has-error' : '' }}">
								<label for="district_code" class="col-sm-4 control-label">District Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="district_code" id="district_code" readonly required class="form-control" style="pointer-events: none;">
										<option value="">Select</option>								
										@foreach($all_district as $district)
										<option value="{{$district->district_code}}">{{$district->district_name}}</option>
										@endforeach
									</select>
								</div>
							</div>			
							<div class="form-group{{ $errors->has('thana_code') ? ' has-error' : '' }}">
								<label for="thana_code" class="col-sm-4 control-label">Thana Name</label><span class="required">*</span>
								@if(!empty($emp_cv['thana_code']))
								<div class="col-sm-6">
									<select name="thana_code" id="upazila_id" readonly required class="form-control" style="pointer-events: none;">
										@foreach($all_thana as $thana)
										@if($thana->thana_code == $emp_cv['thana_code'])
										<option value="{{$thana->thana_code}}" selected="selected">{{$thana->thana_name}}</option>
										@endif
										@endforeach
									</select>
								</div>
								@else
								<div class="col-sm-6">
									<select name="thana_code" disabled="disabled" id="upazila_id" required class="form-control">
										<option value="">Select</option>
									</select>
								</div>
								@endif
							</div>
							<div class="form-group{{ $errors->has('permanent_add') ? ' has-error' : '' }}">
								<label for="permanent_add" class="col-sm-4 control-label">Permanent Address</label><span class="required">*</span>
								<div class="col-sm-6">
									<textarea name="permanent_add" class="form-control" id="address" onclick='LoadAddress()'>{{$emp_cv['permanent_add']}}</textarea>
									@if ($errors->has('permanent_add'))
									<span class="help-block">
										<strong>{{ $errors->first('permanent_add') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<!--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="employee_photo" class="col-sm-4 control-label">Photo </label><span class="require">*</span>
								<div class="col-sm-6">
									<input type="file" name="employee_photo" class="form-control" id="file">
									@if ($errors->has('employee_photo'))
									<span class="help-block">
										<strong>{{ $errors->first('employee_photo') }}</strong>
									</span>
									@endif
								</div>
							</div>-->
								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--Start education tab-->
			<div class="tab-pane" id="tab_education">
				<form action="{{URL::to('/emp-edu')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
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
										<input type="hidden" name="edu_val[<?php echo $education_row; ?>][id]" value="{{$edu_val->id}}" />
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][result]" value="{{$edu_val->result}}" required class="form-control" size="8"></td>
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][note]" value="{{$edu_val->note}}" class="form-control" size="8"></td>
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][pass_year]" value="{{$edu_val->pass_year}}" required class="form-control" size="8"></td>
										<td><a onclick="$('#education-row<?php echo $education_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $education_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="6"></td>
											<td class="left"><a onclick="addEducation();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value="<?php echo serialize($edu_array); ?>" />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end education tab-->
			<!--Start training tab-->
			<div class="tab-pane" id="tab_training">
				<form action="{{URL::to('/emp-training')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
							<div class="table-responsive">
								<table id="training" class="table table-bordered">
									<thead>
									  <tr>
										<th>Training Name</th>
										<th>Training Period</th>
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
											<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
											<input type="text" name="tra_val[<?php echo $training_row; ?>][tr_name]" value="{{$tra_val->train_name}}" required class="form-control" />
										</td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_period]" value="{{$tra_val->train_period}}" required class="form-control" /></td>
										<input type="hidden" name="tra_val[<?php echo $training_row; ?>][id]" value="{{$tra_val->id}}" />
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_institute]" value="{{$tra_val->institute}}" required class="form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_palace]" value="{{$tra_val->palace}}" required class="form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_remarks]" value="{{$tra_val->remarks}}" required class="form-control" /></td>
										<td><a onclick="$('#training-row<?php echo $training_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $training_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="5"></td>
											<td class="left"><a onclick="addTraining();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value="<?php echo serialize($tra_array); ?>" />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end training tab-->		
			<!--Start experience tab-->
			<div class="tab-pane" id="tab_experience">
				<form action="{{URL::to('/emp-experience')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
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
											<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
											<input type="text" name="exp_val[<?php echo $experience_row; ?>][designation]" value="{{$exp_val->designation}}" required class="form-control" />
										</td>
										<input type="hidden" name="exp_val[<?php echo $experience_row; ?>][id]" value="{{$exp_val->id}}" />
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][exp_period]" value="{{$exp_val->experience_period}}" required class="form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][org_name]" value="{{$exp_val->organization_name}}" required class="form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][remarks]" value="{{$exp_val->remarks}}" required class="form-control" /></td>
										<td><a onclick="$('#experience-row<?php echo $experience_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $experience_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="4"></td>
											<td class="left"><a onclick="addExperience();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value="<?php echo serialize($exp_array); ?>" />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end experience tab-->  
			<!--Start reference tab-->
			<div class="tab-pane" id="tab_reference">
				<form action="{{URL::to('/emp-reference')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
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
											<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
											<input type="text" name="refer_val[<?php echo $reference_row; ?>][refer_name]" value="{{$refer_val->rf_name}}" required class="form-control" />
										</td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][occupation]" value="{{$refer_val->rf_occupation}}" required class="form-control" /></td>
										<input type="hidden" name="refer_val[<?php echo $reference_row; ?>][id]" value="{{$refer_val->id}}" />
										<td><textarea name="refer_val[<?php echo $reference_row; ?>][address]" rows="2" required class="form-control" >{{$refer_val->rf_address}}</textarea></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][contact_no]" value="{{$refer_val->rf_mobile}}" required class="form-control" /></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][email]" value="{{$refer_val->rf_email}}" required size="16" class="form-control" /></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][nid]" value="{{$refer_val->rf_national_id}}" required size="14" class="form-control" /></td>
										<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][remarks]" value="{{$refer_val->rf_remarks}}" required size="12" class="form-control" /></td>
										<td><a onclick="$('#reference-row<?php echo $reference_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $reference_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="7"></td>
											<td class="left"><a onclick="addReference();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value="<?php echo serialize($refer_array); ?>" />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end reference tab-->
			<!--Start photo tab-->
			<div class="tab-pane" id="tab_photo">
				<form action="{{URL::to('/emp-photo')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
							<table id="photo" class="table table-bordered">
								<td style="width:20%;">  
									<div class="image-upload">
									
										@if($emp_photo_val)
										<label for="file-input">
											<img id="blah" class="img-thumbnail" src="{{asset('storage/image/'.$emp_photo_val->emp_photo)}}" width="100"/> 
										</label> 
										@else
										<label for="file-input">
											<img id="blah" class="img-thumbnail" src="{{asset('storage/image/placeholder.png')}}" width="100"/> 
										</label> 
										@endif
										<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
										<input onchange="readURL(this);" id="file-input" name="emp_photo" type="file"/> 
										<strong ><br>Employee Photo Upload</strong>
										<input type="text" name="student_photo" value="" readonly />
									</div> 
								</td>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end photo tab-->
			<!--Start necessary phone tab-->
			<div class="tab-pane" id="tab_necessary_phone">
				<form action="{{URL::to('/emp-necessary_phone')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
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
											<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
											<input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][name]" value="{{$neces_phone_val->name}}" required class="form-control" />
										</td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][relation]" value="{{$neces_phone_val->relation}}" required class="form-control" /></td>
										<input type="hidden" name="neces_phone_val[<?php echo $neces_phone_row; ?>][id]" value="{{$neces_phone_val->id}}" />
										<td><textarea name="neces_phone_val[<?php echo $neces_phone_row; ?>][address]" rows="2" required class="form-control" >{{$neces_phone_val->address}}</textarea></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][contact_no]" value="{{$neces_phone_val->mobile}}" required class="form-control" /></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][email]" value="{{$neces_phone_val->email}}" required size="16" class="form-control" /></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][nid]" value="{{$neces_phone_val->national_id}}" required size="14" class="form-control" /></td>
										<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][remarks]" value="{{$neces_phone_val->remarks}}" required size="12" class="form-control" /></td>
										<td><a onclick="$('#neces_phone-row<?php echo $neces_phone_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $neces_phone_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="7"></td>
											<td class="left"><a onclick="addNecesPhone();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id" value="<?php echo serialize($neces_array); ?>" />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end necessary phone tab-->
			<!--Start other paper tab-->
			<div class="tab-pane" id="tab_other">
				<form action="{{URL::to('/emp-other')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
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
										<input type="hidden" name="emp_id" value="{{$emp_cv['emp_id']}}" >
										<input type="text" name="other_val[<?php echo $other_row; ?>][subject]" value="{{$other_val->op_subject}}" required class="form-control" />
									</td>
									<input type="hidden" name="other_val[<?php echo $other_row; ?>][id]" value="{{$other_val->id}}" />
									<td><textarea name="other_val[<?php echo $other_row; ?>][details]" rows="2" col="10" required class="form-control" >{{$other_val->op_details}}</textarea></td>
									<td><a onclick="$('#other-row<?php echo $other_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $other_row++; ?>
								<?php } ?>
								<tfoot>
									<tr>
										<td colspan="2"></td>
										<td class="left"><a onclick="addOther();" class="btn bg-navy">Add</a></td>
										<input type="hidden" name="val_id" value="<?php echo serialize($other_array); ?>" />
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/emp-cv')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
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
			url : "{{ url::to('select-thana') }}"+"/"+district_code,
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
	document.getElementById("country_id").value="{{$emp_cv['country_id']}}";
	document.getElementById("blood_group").value="{{$emp_cv['blood_group']}}";
	//document.getElementById("blood_group").value="<?php echo $emp_cv['blood_group'];?>";
	document.getElementById("religion").value="{{$emp_cv['religion']}}";
	document.getElementById("district_code").value="{{$emp_cv['district_code']}}";
</script>
<script type="text/javascript">
	function LoadAddress() {
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
    }
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
	html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_period]" value="" required class="form-control" /></td>';
	html += '    <input type="hidden" name="tra_val[' + training_row + '][id]" value="" />';
	html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_institute]" value="" required class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_palace]" value="" class="form-control" /></td>';
    html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_remarks]" value="" class="form-control" /></td>';
	html += '    <td class="left"><a onclick="$(\'#training-row' + training_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#training tfoot').before(html);
	
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
@endsection