@extends('admin.admin_master')
@section('title', 'Recruitment')
@section('main_content')
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
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>
<section class="content-header">
  <h4>Add-Recruitment</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Employee</a></li>
	<li class="active">add-Recruitment</li>
  </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php if ($recruit_data['tab_id'] == 1) echo 'active';?>"><a href="#tab_general" data-toggle="tab">General Info</a></li> 
              <li class="<?php if ($recruit_data['tab_id'] == 3) echo 'active';?>"><a href="#tab_training" data-toggle="tab">Training</a></li>
			   <!--<li class="<?php //if ($recruit_data['tab_id'] == 2) echo 'active';?>"><a href="#tab_education" data-toggle="tab">Education</a></li>
              <li class="<?php //if ($recruit_data['tab_id'] == 4) echo 'active';?>"><a href="#tab_experience" data-toggle="tab">Experience</a></li>-->
			  <div class="pull-right">
					<a href="{{URL::to('/add-recruit')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Recruitment</a>
				</div>
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
			<div class="tab-pane <?php if ($recruit_data['tab_id'] == 1) echo 'active';?>" id="tab_general">
				<form action="{{URL::to($recruit_data['action'])}}" method="post"  onsubmit="return calculate_age()" class="form-horizontal" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="col-md-6">
					@if(Session::has('message1'))
					<h5 style="color:green">
					{{session('message1')}}
					</h5>
					@endif
					<div class="box box-info">
						<div class="box-body">
						
						<input type="hidden"   id="end_date" value="{{$recruit_data['end_date']}}"   class="form-control">
						<input type="hidden"   id="normal_age" value="{{$recruit_data['normal_age']}}"   class="form-control">
						<input type="hidden"   id="experience_age" value="{{$recruit_data['experience_age']}}"   class="form-control">
						<input type="hidden"   name="new_recruitment_id" value="{{$recruit_data['new_recruitment_id']}}"   class="form-control">
							<div class="form-group{{ $errors->has('circular_id') ? ' has-error' : '' }}">
								<label for="circular_id" class="col-sm-4 control-label">Circular Name </label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="circular_id" id="circular_id"  required class="form-control">
										 						
										<?php foreach($recruit_circular as $circular){?>
										<option value="<?php echo $circular->id;?>"><?php echo  $circular->circular_name;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
								<label for="full_name" class="col-sm-4 control-label">Full Name </label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="full_name" id="full_name " value="{{$recruit_data['full_name']}}" required class="form-control">
									@if ($errors->has('full_name'))
									<span class="help-block">
										<strong>{{ $errors->first('full_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
								<label for="father_name" class="col-sm-4 control-label">Father's Name</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="father_name" id="father_name" value="{{$recruit_data['father_name']}}" required class="form-control">
									@if ($errors->has('father_name'))
									<span class="help-block">
										<strong>{{ $errors->first('father_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
								<label for="mother_name" class="col-sm-4 control-label">Mother's Name</label>
								<div class="col-sm-6">
									<input type="text" name="mother_name" id="mother_name" value="{{$recruit_data['mother_name']}}"  class="form-control">
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
									<input type="text" name="birth_date" id="birth_date" onchange="change_disabled_mode();" value="{{$recruit_data['birth_date']}}" required class="form-control">
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
										<option value="Married" <?php if($recruit_data['maritial_status']=="Married") echo 'selected="selected"'; ?> >Married</option>
										<option value="Unmarried" <?php if($recruit_data['maritial_status']=="Unmarried") echo 'selected="selected"'; ?> >Unmarried</option>
										<option value="N/A" <?php if($recruit_data['maritial_status']=="N/A") echo 'selected="selected"'; ?> >N/A</option>
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
								<label for="nationality" class="col-sm-4 control-label">Nationality</label>
								<div class="col-sm-6">
									<input type="text" name="nationality" id="nationality" value="{{$recruit_data['nationality']}}"  class="form-control">
									@if ($errors->has('nationality'))
									<span class="help-block">
										<strong>{{ $errors->first('nationality') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('national_id') ? ' has-error' : '' }}">
								<label for="national_id" class="col-sm-4 control-label">National Id</label>
								<div class="col-sm-6">
									<input type="text" name="national_id" id="national_id" value="{{$recruit_data['national_id']}}"  class="form-control">
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
										<option value="Male" <?php if($recruit_data['gender']=="Male") echo 'selected="selected"'; ?> >Male</option>
										<option value="Female"  <?php if($recruit_data['gender']=="Female") echo 'selected="selected"'; ?> >Female</option>
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('contact_num') ? ' has-error' : '' }}">
								<label for="contact_num" class="col-sm-4 control-label">Mobile No.</label><span class="required">*</span>
								<div class="col-sm-6">
									<input type="text" name="contact_num" id="contact_num" value="{{$recruit_data['contact_num']}}" required class="form-control">
									@if ($errors->has('contact_num'))
									<span class="help-block">
										<strong>{{ $errors->first('contact_num') }}</strong>
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
							<div class="form-group{{ $errors->has('post_id') ? ' has-error' : '' }}">
								<label for="post_id" class="col-sm-4 control-label">Post Name</label><span class="required">*</span> 
								<div class="col-sm-6"> 
									<select name="post_id" id="post_id" onchange="select_circular_date()" required class="form-control"  >
										<option value="">select</option>
										@foreach($all_post as $post) 
											@if($recruit_data['post_id'] == $post->id)
											  <option value="{{$post->id}}" selected >{{$post->post_name}}</option> 
										    @else 
											  <option value="{{$post->id}}">{{$post->post_name}}</option> 	
										    @endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
								<label for="email" class="col-sm-4 control-label">Email</label>
								<div class="col-sm-6">
									<input type="text" name="email" id="email" value="{{$recruit_data['email']}}" class="form-control">
									@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
							</div>	
							<div class="form-group{{ $errors->has('vill_road') ? ' has-error' : '' }}">
								<label for="vill_road" class="col-sm-4 control-label">Vill / Road</label>
								<div class="col-sm-6">
									<input type="text" name="vill_road" id="vill_road" value="{{$recruit_data['vill_road']}}" class="form-control">
									@if ($errors->has('vill_road'))
									<span class="help-block">
										<strong>{{ $errors->first('vill_road') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('post_office') ? ' has-error' : '' }}">
								<label for="post_office" class="col-sm-4 control-label">Post Office</label>
								<div class="col-sm-6">
									<input type="text" name="post_office" id="post_office" value="{{$recruit_data['post_office']}}"  class="form-control">
									@if ($errors->has('post_office'))
									<span class="help-block">
										<strong>{{ $errors->first('post_office') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('district_code') ? ' has-error' : '' }}">
								<label for="district_code" class="col-sm-4 control-label">Home District</label><span class="required">*</span>
								<div class="col-sm-6">
									<select name="district_code" id="district_code" required class="form-control" >
										<option value="">Select</option>								
										@foreach($all_district as $district)
										<option value="{{$district->district_code}}">{{$district->district_name}}</option>
										@endforeach
									</select>
								</div>
							</div>			
							<div class="form-group{{ $errors->has('thana_code') ? ' has-error' : '' }}">
								<label for="thana_code" class="col-sm-4 control-label">Thana Name</label><span class="required">*</span>
								@if(!empty($recruit_data['thana_code']))
								<div class="col-sm-6">
									<select name="thana_code" id="upazila_id" readonly required class="form-control" style="pointer-events: none;">
										@foreach($all_thana as $thana)
										@if($thana->thana_code == $recruit_data['thana_code'])
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
									<textarea name="permanent_add" class="form-control" id="address" onclick='LoadAddress()'>{{$recruit_data['permanent_add']}}</textarea>
									@if ($errors->has('permanent_add'))
									<span class="help-block">
										<strong>{{ $errors->first('permanent_add') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group{{ $errors->has('present_add') ? ' has-error' : '' }}">
								<label for="present_add" class="col-sm-4 control-label">Present Address <br> <span style ="font-weight:normal;" >same as permanent address &nbsp;&nbsp;</span><input type="checkbox" onclick="check_same_present_address()" @if($recruit_data['is_same_present_address'] == 1) checked @endif name="is_same_present_address" id="is_same_present_address"  value="1"  ></label><span class="required">*</span>
								<div class="col-sm-6">
									<textarea name="present_add" id="present_add" class="form-control" @if($recruit_data['is_same_present_address'] == 1) readonly @endif required>{{$recruit_data['present_add']}}</textarea>
									@if ($errors->has('present_add'))
									<span class="help-block">
										<strong>{{ $errors->first('present_add') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="is_education_certif" class="col-sm-4 control-label">Is Certificate </label>
								<div class="col-sm-1">
									<input type="checkbox" name="is_education_certif" id="is_education_certif" @if($recruit_data['is_education_certif'] == 1) checked @endif	value="1" >
								</div>
								<label for="is_nid" class="col-sm-2 control-label">Is NID </label>
								<div class="col-sm-1">
									<input type="checkbox" name="is_nid" id="is_nid" @if($recruit_data['is_nid'] == 1) checked @endif  value="1"  >
									
								</div>
								<label for="is_photo" class="col-sm-2 control-label">Is Photo</label>
								<div class="col-sm-1">
									<input type="checkbox" name="is_photo" id="is_photo"  @if($recruit_data['is_photo'] ==1 ) checked @endif value="1">
								</div>
							</div> 
						</div> 
					</div>
				</div>
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">	
						<span style="font-weight:bold;font-size:16px;">Education</span>
							<br>						
							<br>						
							@if(Session::has('message2'))
							<h5 style="color:green">
							{{session('message2')}}
							</h5>
							@endif
							<div class="table-responsive">
								<table id="education" class="table table-bordered">
									<thead>
									  <tr>
										<th>Exam Name</th>
										<th>Group / Subject</th>
										<th>Board / University</th>
										<th>Result</th>
										<th>CGPA</th>
										<th>Range</th>
										<th>Passing Year</th>
										<th></th>
									  </tr>
									</thead>
									<?php $education_row = 0; $i=1; 
									$edu_array = array(); foreach ($recruit_edu as $edu_val) {
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
										<td>
										<select style="width:150px;" onchange="open_cgpa(<?php echo $education_row; ?>)" id="result<?php echo $education_row; ?>" name="edu_val[<?php echo $education_row; ?>][result]" required class="form-control">
												<option value="1" <?php if($edu_val->result == 1) echo 'selected'; ?>  >1st class</option>
												<option value="2" <?php if($edu_val->result == 2) echo 'selected'; ?> >2nd class</option>
												<option value="3" <?php if($edu_val->result == 3) echo 'selected'; ?> >3rd class</option>
												<option value="10" <?php if($edu_val->result == 10) echo 'selected'; ?> >GPA</option>
											</select> 
										 </td>
										<td>
											<input type="text" <?php if($edu_val->result <= 3){ echo "readonly"; } ?>  id="cgpa<?php echo $education_row; ?>" name="edu_val[<?php echo $education_row; ?>][cgpa]" value="{{$edu_val->cgpa}}"  class="form-control" size="8">
											
											
										</td>
										<td>
											<select    id="out_of_range<?php echo $education_row; ?>" name="edu_val[<?php echo $education_row; ?>][out_of_range]" class="form-control">
												<option value="0" <?php if($edu_val->out_of_range == 0) echo 'selected'; ?>>out of</option>
												<option value="1" <?php if($edu_val->out_of_range == 1) echo 'selected'; ?>>5</option>
												<option value="2" <?php if($edu_val->out_of_range == 2) echo 'selected'; ?>>4</option>
											</select>
										</td>
										<td><input type="text" name="edu_val[<?php echo $education_row; ?>][pass_year]" value="{{$edu_val->pass_year}}" required class="form-control" size="8"></td>
										<td><a onclick="$('#education-row<?php echo $education_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $education_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="7"></td>
											<td class="left"><a onclick="addEducation();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id_edu" value='<?php echo serialize($edu_array); ?>' />
										</tr>
									</tfoot>
								</table>								
							</div>
						</div> 
					</div>
				</div>
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">	
							<span style="font-weight:bold;font-size:16px;">Experience</span>
							<br>							
							<br>							
							@if(Session::has('message4'))
							<h5 style="color:green">
							{{session('message4')}}
							</h5>
							@endif
							<div class="table-responsive">
								<table id="experience" class="table table-bordered">
									<thead>
									  <tr>
										<th>Designation</th> 
										<th>Experience Period</th>
										<th>From</th>
										<th>To</th>
										<th>Organization Name</th>
										<th>Remarks</th>
										<th></th>
									  </tr>
									</thead>
									<?php $experience_row = 0; 
									$exp_array = array(); foreach ($recruit_exp as $exp_val) {
									$exp_array[] = $exp_val->id;
									?>
									<tbody id="experience-row<?php echo $experience_row; ?>">
									  <tr>
										<td>
											 
											<input type="text" name="exp_val[<?php echo $experience_row; ?>][designation]" value="{{$exp_val->designation}}" required class="form-control" />
										</td>
										<input type="hidden" name="exp_val[<?php echo $experience_row; ?>][id]" value="{{$exp_val->id}}" />
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][exp_period]" value="{{$exp_val->experience_period}}" required class="form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][exp_from]" value="{{$exp_val->exp_from}}"  class="form_date form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][exp_to]" value="{{$exp_val->exp_to}}"  class="form_date form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][org_name]" value="{{$exp_val->organization_name}}" required class="form-control" /></td>
										<td><input type="text" name="exp_val[<?php echo $experience_row; ?>][remarks]" value="{{$exp_val->remarks}}" class="form-control" /></td>
										<td><a onclick="$('#experience-row<?php echo $experience_row; ?>').remove();" class="btn bg-navy">Remove</a></td>
									  </tr>
									</tbody>
									<?php $experience_row++; ?>
									<?php } ?>
									<tfoot>
										<tr>
											<td colspan="6"></td>
											<td class="left"><a onclick="addExperience();" class="btn bg-navy">Add</a></td>
											<input type="hidden" name="val_id_exp" value='<?php echo serialize($exp_array); ?>' />
										</tr>
									</tfoot>
								</table>
								<table   class="table table-bordered">
									<thead>
									  <tr>
										<th colspan="3">Experience in relevant field </th> 
									  </tr>
									</thead>
									<tbody>
									  <tr>
										<td>
											<select style="width:50%;float:left;"   id="relevent_year" name="relevent_year"  class="form-control">
												<option value="">Select</option>
												<option value="1"  <?php if($recruit_data['relevent_year'] == 1){ echo "Selected"; }?> >1</option>
												<option value="2"  <?php if($recruit_data['relevent_year'] == 2){ echo "Selected"; }?>>2</option> 
												<option value="3" <?php if($recruit_data['relevent_year'] == 3){ echo "Selected"; }?> >3</option> 
												<option value="4"  <?php if($recruit_data['relevent_year'] == 4){ echo "Selected"; }?>>4</option> 
												<option value="5" <?php if($recruit_data['relevent_year'] == 5){ echo "Selected"; }?>>5</option> 
												<option value="6" <?php if($recruit_data['relevent_year'] == 6){ echo "Selected"; }?>>6</option> 
												<option value="7" <?php if($recruit_data['relevent_year'] == 7){ echo "Selected"; }?>>7</option> 
												<option value="8" <?php if($recruit_data['relevent_year'] == 8){ echo "Selected"; }?>>8</option> 
												<option value="9" <?php if($recruit_data['relevent_year'] == 9){ echo "Selected"; }?>>9</option> 
												<option value="10" <?php if($recruit_data['relevent_year'] == 10){ echo "Selected"; }?>>10</option> 
												<option value="11" <?php if($recruit_data['relevent_year'] == 11){ echo "Selected"; }?>>11</option> 
												<option value="12" <?php if($recruit_data['relevent_year'] == 12){ echo "Selected"; }?>>12</option> 
												 
											</select><span style="position:top;float:left;padding-left:4px;">Year</span> 
										</td> 
										<td>
											<select style="width:50%;float:left;"   id="relevent_month" name="relevent_month"  class="form-control">
												<option value="">Select</option>
												<option value="1"  <?php if($recruit_data['relevent_month'] == 1){ echo "Selected"; }?> >1</option>
												<option value="2"  <?php if($recruit_data['relevent_month'] == 2){ echo "Selected"; }?>>2</option> 
												<option value="3" <?php if($recruit_data['relevent_month'] == 3){ echo "Selected"; }?> >3</option> 
												<option value="4"  <?php if($recruit_data['relevent_month'] == 4){ echo "Selected"; }?>>4</option> 
												<option value="5" <?php if($recruit_data['relevent_month'] == 5){ echo "Selected"; }?>>5</option> 
												<option value="6" <?php if($recruit_data['relevent_month'] == 6){ echo "Selected"; }?>>6</option> 
												<option value="7" <?php if($recruit_data['relevent_month'] == 7){ echo "Selected"; }?>>7</option> 
												<option value="8" <?php if($recruit_data['relevent_month'] == 8){ echo "Selected"; }?>>8</option> 
												<option value="9" <?php if($recruit_data['relevent_month'] == 9){ echo "Selected"; }?>>9</option> 
												<option value="10" <?php if($recruit_data['relevent_month'] == 10){ echo "Selected"; }?>>10</option> 
												<option value="11" <?php if($recruit_data['relevent_month'] == 11){ echo "Selected"; }?>>11</option> 
												<option value="12" <?php if($recruit_data['relevent_month'] == 12){ echo "Selected"; }?>>12</option> 
												 
											</select><span style="position:top;float:left;padding-left:4px;">Month</span> 
										</td>
										<td width="50%"></td> 
										</tr>
									</tbody>
									 
									 
								</table>								
							</div>
						</div>
						<!-- /.box-body  -->  
						<div class="box-footer">
							<a href="{{URL::to('/recruitment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit" id="submit_btn" class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer  -->  
					</div>
				</div>
				</form>			
			</div>
			<!--Start education tab
			<div class="tab-pane <?php //if ($recruit_data['tab_id'] == 2) echo 'active';?>" id="tab_education">
				<form action="{{URL::to('/recruit-edu')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="recruitment_id" value="{{$recruit_data['recruitment_id']}}" >
				
				</form>			
			</div>-->
			<!--end education tab-->
			<!--Start training tab-->
			<div class="tab-pane <?php if ($recruit_data['tab_id'] == 3) echo 'active';?>" id="tab_training">
				<form action="{{URL::to('/recruit-training')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="text" name="recruitment_id" value="{{$recruit_data['recruitment_id']}}" >
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">							
							@if(Session::has('message3'))
							<h5 style="color:green">
							{{session('message3')}}
							</h5>
							@endif
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
									$tra_array = array(); foreach ($recruit_train as $tra_val) {
									$tra_array[] = $tra_val->id;
									?>
									<tbody id="training-row<?php echo $training_row; ?>">
									  <tr>
										<td>
											<input type="hidden" name="recruitment_id" value="{{$recruit_data['recruitment_id']}}" >
											<input type="text" name="tra_val[<?php echo $training_row; ?>][tr_name]" value="{{$tra_val->train_name}}" required class="form-control" />
										</td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_period]" value="{{$tra_val->train_period}}" required class="form_date form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_period_to]" value="{{$tra_val->train_period_to}}" required class="form_date form-control" /></td>
										<input type="hidden" name="tra_val[<?php echo $training_row; ?>][id]" value="{{$tra_val->id}}" />
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_institute]" value="{{$tra_val->institute}}" required class="form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_palace]" value="{{$tra_val->palace}}" required class="form-control" /></td>
										<td><input type="text" name="tra_val[<?php echo $training_row; ?>][tr_remarks]" value="{{$tra_val->remarks}}" class="form-control" /></td>
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
							<a href="{{URL::to('/recruitment')}}" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
							<button type="submit"   class="btn bg-navy"><i class="icon-save"></i> Save</button>
						</div>
					   <!-- /.box-footer -->
					</div>
				</div>
				</form>			
			</div>
			<!--end training tab-->		
			<!--Start experience tab
			 <div class="tab-pane <?php //if ($recruit_data['tab_id'] == 4) echo 'active';?>" id="tab_experience">
				<form action="{{URL::to('/recruit-experience')}}" method="post" class="form-inline" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="recruitment_id" value="{{$recruit_data['recruitment_id']}}" >
				
				</form>			
			</div> -->
			<!--end experience tab-->  
			
		</div>
	</div>
</section>
<script> 
function select_circular_date(){
	  var circular_id = $("#circular_id").val(); 
	  var post_id = $("#post_id").val(); 
	  //alert('ok');
	  $.ajax({
			url : "{{ url::to('select_circular_date') }}"+"/"+circular_id+"/"+post_id,
			type: "GET",
			dataType: 'json',
			success: function(data)
			{
				//alert(data); 
				console.log(data);
				$("#end_date").val(data["end_date"]);
				$("#normal_age").val(data["normal_age"]);
				$("#experience_age").val(data["experience_age"]);
				 
			}
		}); 
}
// remember this is equivalent to 06 01 2010
//dates in js are counted from 0, so 05 is june
 

function change_disabled_mode(){
	 $("#submit_btn").removeAttr('disabled'); 
}
function calculate_age(){
	var succeed = true;
	var normal_age = $("#normal_age").val();
	var experience_age = $("#experience_age").val();
	var rowCount = $('#experience >tbody >tr').length;
	if(rowCount > 0){
		var max_year = experience_age;
	}else{
		var max_year = normal_age;
	} 
	var end_date = $("#end_date").val();
	var birth_date = $("#birth_date").val();
	
	var a = moment(end_date);
	var b = moment(birth_date);

	var years = a.diff(b, 'year');
	b.add(years, 'years');

	var months = a.diff(b, 'months');
	b.add(months, 'months');

	var days = a.diff(b, 'days');
	if(years < 22){
		succeed = false;
		$("#submit_btn").attr('disabled','disabled');  	
		alert(years + ' years ' + months + ' months ' + days + ' days'); 
		
	}else if(years == max_year){
		if(months > 0){
			succeed = false;
			$("#submit_btn").attr('disabled','disabled');  	
			alert(years + ' years ' + months + ' months ' + days + ' days');
		}else if(days > 0){
			succeed = false;
			$("#submit_btn").attr('disabled','disabled');  	
			alert(years + ' years ' + months + ' months ' + days + ' days');
		}
	}else if(years > max_year){
		succeed = false;
		$("#submit_btn").attr('disabled','disabled');  	
		alert(years + ' years ' + months + ' months ' + days + ' days');
	}else{
		 succeed = true;
		 $("#submit_btn").removeAttr('disabled');  	
	} 
	return succeed;
}

 
function check_same_present_address(){
	 var is_same_present_address = $("#is_same_present_address").is(':checked');
	 if(is_same_present_address){
		  //var address = $("#address").text();
		  $("#present_add").text('');
		  $("#present_add").attr('readonly','readonly');  		 
	 }else{
		 $("#present_add").text('');  
		 $("#present_add").removeAttr('readonly');
	 } 
}
	 $(document).on("change", "#circular_id", function () {
		var circular_id = $(this).val();   
		//alert(circular_id);
		 
		$.ajax({
			url : "{{ url::to('select_circular_post') }}"+"/"+circular_id,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				 $("#post_id").attr("disabled", false);
				$("#post_id").html(data);
				 
			}
		});  
	});  
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
	document.getElementById("religion").value="{{$recruit_data['religion']}}";
	document.getElementById("district_code").value="{{$recruit_data['district_code']}}";
	document.getElementById("circular_id").value="{{$recruit_data['circular_id']}}";
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
	html += '    <td><select style="width:150px;" onchange="open_cgpa('+ education_row +')" id="result'+ education_row +'" name="edu_val['+ education_row +'][result]" required class="form-control"><option value="1">1st class</option><option value="2">2nd class</option><option value="3">3rd class</option><option value="10">GPA</option></select></td>';
	html += '    <td><input type="text" id="cgpa' + education_row + '" name="edu_val[' + education_row + '][cgpa]" value="" size="8" readonly  class="form-control"/></td>';
	html += '    <td><select    id="out_of_range'+ education_row +'" name="edu_val['+ education_row +'][out_of_range]" class="form-control"><option value="0">out of</option><option value="1">5</option><option value="2">4</option></select></td>';
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
	html += '    <td class="left"><input type="text" name="tra_val[' + training_row + '][tr_period_to]" value="" required class="form_date form-control" /></td>';
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
	html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][exp_from]" value=""  class="form_date form-control" /></td>';
	html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][exp_to]" value=""  class="form_date form-control" /></td>'; 
	html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][org_name]" value="" class="form-control" required/></td>';
    html += '    <td class="left"><input type="text" name="exp_val[' + experience_row + '][remarks]" value="" class="form-control" /></td>';
	html += '    <td class="left"><a onclick="$(\'#experience-row' + experience_row + '\').remove();" class="btn bg-navy">Remove</a></td>';
	html += '  </tr>';	
    html += '</tbody>'; 
	
	$('#experience tfoot').before(html);
	$('#experience-row' + experience_row + ' .form_date').datepicker({dateFormat: 'yy-mm-dd'});
	experience_row++;
}
function open_cgpa(row_value){
	var result = $("#result"+row_value).val(); 
	//alert(result);
	if(result == 10){
		 $("#cgpa"+row_value).val(''); 
		 $("#cgpa"+row_value).removeAttr('readonly'); 
		 $("#cgpa"+row_value).removeAttr('required'); 
	 }else{  
		$("#cgpa"+row_value).val('');  
		$("#cgpa"+row_value).attr('readonly','readonly');  		
		$("#cgpa"+row_value).attr('required','required');  		
	 }  
	 
}
</script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#birth_date').datepicker({dateFormat: 'yy-mm-dd',changeYear: true,changeMonth: true,yearRange: "1970:2018" });
});
//--></script>
<script type="text/javascript">
$(document).ready(function() {
$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script>
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Recruitment").addClass('active');
	});
</script>
@endsection