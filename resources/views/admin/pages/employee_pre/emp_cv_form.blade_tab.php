@extends('admin.admin_master')
@section('main_content')

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
				<form action="{{URL::to('/emp-cv')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-body">							
							<div class="form-group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
								<label for="emp_id" class="col-sm-4 control-label">Employee ID</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="emp_id" id="emp_id" value="{{$emp_cv->emp_id}}" required autofocus class="form-control">
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
									<input type="text" name="emp_name_eng" id="emp_name_eng " value="{{$emp_cv->emp_name}}" required class="form-control">
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
									<input type="text" name="emp_name_ban" id="emp_name_ban" value="" required class="form-control">
									@if ($errors->has('emp_name_ban'))
									<span class="help-block">
										<strong>{{ $errors->first('emp_name_ban') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
								<label for="father_name" class="col-sm-4 control-label">Father Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="father_name" id="father_name" value="{{$emp_cv->father_name}}" required class="form-control">
									@if ($errors->has('father_name'))
									<span class="help-block">
										<strong>{{ $errors->first('father_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
								<label for="mother_name" class="col-sm-4 control-label">Mother Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name') }}" required class="form-control">
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
									<input type="text" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required class="form-control">
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
									<input type="text" name="religion" id="religion" value="{{ old('religion') }}" required class="form-control">
									@if ($errors->has('religion'))
									<span class="help-block">
										<strong>{{ $errors->first('religion') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('maritial_status') ? ' has-error' : '' }}">
								<label for="maritial_status" class="col-sm-4 control-label">Marital Status</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="maritial_status" id="maritial_status" value="{{ old('maritial_status') }}" required class="form-control">
									@if ($errors->has('maritial_status'))
									<span class="help-block">
										<strong>{{ $errors->first('maritial_status') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
								<label for="nationality" class="col-sm-4 control-label">Nationality</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="nationality" id="nationality" value="{{ old('nationality') }}" required class="form-control">
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
									<input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}" required class="form-control">
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
									<input type="text" name="gender" id="gender" value="{{ old('gender') }}" required class="form-control">
									@if ($errors->has('gender'))
									<span class="help-block">
										<strong>{{ $errors->first('gender') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
								<label for="country_id" class="col-sm-4 control-label">Country Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="country_id" id="country_id" value="{{ old('country_id') }}" required class="form-control">
									@if ($errors->has('country_id'))
									<span class="help-block">
										<strong>{{ $errors->first('country_id') }}</strong>
									</span>
									@endif
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
									<input type="text" name="contact_num" id="contact_num" value="{{ old('contact_num') }}" required class="form-control">
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
									<input type="text" name="email" id="email" value="{{ old('email') }}" required class="form-control">
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
									<input type="text" name="blood_group" id="blood_group" value="{{ old('blood_group') }}" required class="form-control">
									@if ($errors->has('blood_group'))
									<span class="help-block">
										<strong>{{ $errors->first('blood_group') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('org_join_date') ? ' has-error' : '' }}">
								<label for="org_join_date" class="col-sm-4 control-label">Joining Date (Org.)</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="org_join_date" id="start_date" value="{{$emp_cv->joining_date}}" required class="form-control">
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
									<textarea name="present_add" class="form-control"></textarea>
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
									<input type="text" name="vill_road" id="vill_road" value="{{$emp_cv->emp_village}}" required class="form-control">
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
									<input type="text" name="post_office" id="post_office" value="{{$emp_cv->emp_po}}" required class="form-control">
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
									<input type="text" name="district_code" id="district_code" value="{{$emp_cv->emp_district}}" required class="form-control">
									@if ($errors->has('district_code'))
									<span class="help-block">
										<strong>{{ $errors->first('district_code') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('thana_code') ? ' has-error' : '' }}">
								<label for="thana_code" class="col-sm-4 control-label">Thana Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="thana_code" id="thana_code" value="{{$emp_cv->emp_thana }}" required class="form-control">
									@if ($errors->has('thana_code'))
									<span class="help-block">
										<strong>{{ $errors->first('thana_code') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('permanent_add') ? ' has-error' : '' }}">
								<label for="permanent_add" class="col-sm-4 control-label">Permanent Address</label><span class="required">*</span>
								<div class="col-sm-6">
									<textarea name="permanent_add" class="form-control"></textarea>
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
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<div class="tab-pane" id="tab_education">
				<form action="{{URL::to('/emp-edu')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
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
								<?php $education_row = 0; $i=1; ?>
								<tbody id="education-row<?php echo $education_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="{{$emp_cv->emp_id}}" >
										<select style="width:150px;" name="edu_val[<?php echo $education_row; ?>][exam_code]" required class="form-control">
											<option value="">Select</option>							
											<option value="1">SSC</option>							
											<option value="2">HSC</option>							
											<option value="3">BSC</option>							
											<option value="4">MSC</option>							
										</select>
									</td>
									<td>
										<select style="width:150px;" name="edu_val[<?php echo $education_row; ?>][subject_code]" required class="form-control">
											<option value="">Select</option>
											<option value="1">Science</option>							
											<option value="2">Arts</option>							
											<option value="3">Commerce</option>											
										</select>
									</td>
									<td>
										<select style="width:150px;" name="edu_val[<?php echo $education_row; ?>][school_code]" required class="form-control">
											<option value="">Select</option>
											<option value="1">Jessore Board</option>							
											<option value="2">Dhaka Board</option>
										</select>
									</td>
									<td><input type="text" name="edu_val[<?php echo $education_row; ?>][result]" value="{{ old('result') }}" required class="form-control" size="8"></td>
									<td><input type="text" name="edu_val[<?php echo $education_row; ?>][note]" value="{{ old('note') }}" required class="form-control" size="8"></td>
									<td><input type="text" name="edu_val[<?php echo $education_row; ?>][pass_year]" value="{{ old('pass_year') }}" required class="form-control" size="8"></td>
									<td><a onclick="$('#education-row<?php echo $education_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $education_row++; ?>
								<tfoot>
									<tr>
										<td colspan="6"></td>
										<td class="left"><a onclick="addEducation();" class="btn bg-navy">Add</a></td>
										<!--<input type="hidden" name="val_id" value="<?php //echo serialize($eduarray); ?>" />-->
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<div class="tab-pane" id="tab_training">
				<form action="{{URL::to('/emp-training')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
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
								<?php $training_row = 0; $i=1; ?>
								<tbody id="training-row<?php echo $training_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="{{$emp_cv->emp_id}}" >
										<input type="text" name="tra_val[<?php echo $training_row; ?>][tr_name]" value="{{ old('tr_name') }}" required class="form-control" />
									</td>
									<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_period]" value="{{ old('tr_period') }}" required class="form-control" /></td>
									<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_institute]" value="{{ old('tr_institute') }}" required class="form-control" /></td>
									<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_palace]" value="{{ old('tr_palace') }}" required class="form-control" /></td>
									<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_remarks]" value="{{ old('tr_remarks') }}" required class="form-control" /></td>
									<td><a onclick="$('#training-row<?php echo $training_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $training_row++; ?>
								<tfoot>
									<tr>
										<td colspan="5"></td>
										<td class="left"><a onclick="addTraining();" class="btn bg-navy">Add</a></td>
										<!--<input type="hidden" name="val_id" value="<?php //echo serialize($eduarray); ?>" />-->
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<div class="tab-pane" id="tab_experience">
				<form action="{{URL::to('/emp-experience')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
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
								<?php $experience_row = 0; $i=1; ?>
								<tbody id="experience-row<?php echo $experience_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="{{$emp_cv->emp_id}}" >
										<input type="text" name="exp_val[<?php echo $experience_row; ?>][designation]" value="{{ old('designation') }}" required class="form-control" />
									</td>
									<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][exp_period]" value="{{ old('exp_period') }}" required class="form-control" /></td>
									<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][org_name]" value="{{ old('org_name') }}" required class="form-control" /></td>
									<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][remarks]" value="{{ old('remarks') }}" required class="form-control" /></td>
									<td><a onclick="$('#experience-row<?php echo $experience_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $experience_row++; ?>
								<tfoot>
									<tr>
										<td colspan="4"></td>
										<td class="left"><a onclick="addExperience();" class="btn bg-navy">Add</a></td>
										<!--<input type="hidden" name="val_id" value="<?php //echo serialize($eduarray); ?>" />-->
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<div class="tab-pane" id="tab_reference">
				<form action="{{URL::to('/emp-reference')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
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
								<?php $reference_row = 0; $i=1; ?>
								<tbody id="reference-row<?php echo $reference_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="{{$emp_cv->emp_id}}" >
										<input type="text" name="refer_val[<?php echo $reference_row; ?>][refer_name]" value="{{ old('refer_name') }}" required class="form-control" />
									</td>
									<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][occupation]" value="{{ old('occupation') }}" required class="form-control" /></td>
									<td><textarea name="refer_val[<?php echo $reference_row; ?>][address]" rows="2" required class="form-control" ></textarea></td>
									<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][contact_no]" value="{{ old('contact_no') }}" required class="form-control" /></td>
									<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][email]" value="{{ old('email') }}" required size="16" class="form-control" /></td>
									<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][nid]" value="{{ old('nid') }}" required size="14" class="form-control" /></td>
									<td><input type="text" name="refer_val[<?php echo $reference_row; ?>][remarks]" value="{{ old('remarks') }}" required size="12" class="form-control" /></td>
									<td><a onclick="$('#reference-row<?php echo $reference_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $reference_row++; ?>
								<tfoot>
									<tr>
										<td colspan="7"></td>
										<td class="left"><a onclick="addReference();" class="btn bg-navy">Add</a></td>
										<!--<input type="hidden" name="val_id" value="<?php //echo serialize($eduarray); ?>" />-->
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<div class="tab-pane" id="tab_necessary_phone">
				<form action="{{URL::to('/emp-necessary_phone')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							
							@if(Session::has('message'))
							<h3 style="color:green">
							{{session('message')}}
							</h3>
							@endif
					
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
								<?php $neces_phone_row = 0; $i=1; ?>
								<tbody id="neces_phone-row<?php echo $neces_phone_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="{{$emp_cv->emp_id}}" >
										<input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][name]" value="{{ old('name') }}" required class="form-control" />
									</td>
									<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][relation]" value="{{ old('relation') }}" required class="form-control" /></td>
									<td><textarea name="neces_phone_val[<?php echo $neces_phone_row; ?>][address]" rows="2" required class="form-control" ></textarea></td>
									<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][contact_no]" value="{{ old('contact_no') }}" required class="form-control" /></td>
									<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][email]" value="{{ old('email') }}" required size="16" class="form-control" /></td>
									<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][nid]" value="{{ old('nid') }}" required size="14" class="form-control" /></td>
									<td><input type="text" name="neces_phone_val[<?php echo $neces_phone_row; ?>][remarks]" value="{{ old('remarks') }}" required size="12" class="form-control" /></td>
									<td><a onclick="$('#neces_phone-row<?php echo $neces_phone_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $neces_phone_row++; ?>
								<tfoot>
									<tr>
										<td colspan="7"></td>
										<td class="left"><a onclick="addNecesPhone();" class="btn bg-navy">Add</a></td>
										<!--<input type="hidden" name="val_id" value="<?php //echo serialize($eduarray); ?>" />-->
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<div class="tab-pane" id="tab_other">
				<form action="{{URL::to('/emp-other')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
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
								<?php $other_row = 0; $i=1; ?>
								<tbody id="other-row<?php echo $other_row; ?>">
								  <tr>
									<td>
										<input type="hidden" name="emp_id" value="{{$emp_cv->emp_id}}" >
										<input type="text" name="other_val[<?php echo $other_row; ?>][subject]" value="{{ old('subject') }}" required class="form-control" />
									</td>
									<td><textarea name="other_val[<?php echo $other_row; ?>][details]" rows="2" col="10" required class="form-control" ></textarea></td>
									<td><a onclick="$('#other-row<?php echo $other_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
								  </tr>
								</tbody>
								<?php $other_row++; ?>
								<tfoot>
									<tr>
										<td colspan="2"></td>
										<td class="left"><a onclick="addOther();" class="btn bg-navy">Add</a></td>
										<!--<input type="hidden" name="val_id" value="<?php //echo serialize($eduarray); ?>" />-->
									</tr>
								</tfoot>
							</table>								
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<a href="{{URL::to('/all-appointment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
var education_row = <?php echo $education_row; ?>;
function addEducation() {
	//alert (education_row);
	html  = '<tbody id="education-row' + education_row + '">';
	html += '  <tr>'; 
    html += '    <td><select style="width:150px;" name="edu_val[' + education_row + '][exam_code]" required class="form-control">';
    html += '    <option value="">Select</option>';
    html += '      <option value="1">SSC</option>';
    html += '      <option value="2">HSC</option>';
    html += '      <option value="3">BSC</option>';
    html += '      <option value="4">MSC</option>';
    html += '    </select></td>';
	html += '    <td><select style="width:150px;" name="edu_val[' + education_row + '][subject_code]" required class="form-control">';
    html += '    <option value="">Select</option>';
    html += '      <option value="1">Science</option>';
    html += '      <option value="2">Arts</option>';
    html += '      <option value="3">Commerce</option>';
    html += '    </select></td>';
	html += '    <td><select style="width:150px;" name="edu_val[' + education_row + '][school_code]" required class="form-control">';
    html += '    <option value="">Select</option>';
    html += '      <option value="1">Jessore Board</option>';
    html += '      <option value="2">Dhaka Board</option>';
    html += '    </select></td>';
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
	html += '    <td class="left"><textarea name="other_val[' + other_row + '][details]" value="" rows="2" col="10" required class="form-control" ></textarea></td>';
	html += '    <td class="left"><a onclick="$(\'#other-row' + other_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#other tfoot').before(html);
	
	other_row++;
}

</script>
@endsection