@extends('admin.admin_master')
@section('main_content')
 <link rel="stylesheet" href="{{asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')}}">
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
		<h1>My <small>Profile</small></h1>
	</section>
	
	<section class="content-header">
      <h1>
        My Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Profile</a></li>
        <li class="active">My Profile</li>
      </ol>
    </section>
	
	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-3">

				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
						@if($emp_cv_photo)
						<img class="profile-user-img img-responsive img-circle" src="{{asset('public/employee/'.$emp_cv_photo->emp_photo)}}"  alt="User profile picture"> 
						@else
						<img class="profile-user-img img-responsive img-circle" src="{{asset('public/avatars/no_image.jpg')}}" alt="User profile picture">
						@endif
						
						
						
						<h3 class="profile-username text-center"><?php echo $emp_name;?></h3>
						<p class="text-muted text-center"><?php echo $designation_name;?></p>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Grade</b> <a class="pull-right"><?php echo $grade_code;?></a>
							</li>
							<li class="list-group-item">
								<b>Grade Step</b> <a class="pull-right"><?php echo $grade_step;?></a>
							</li>
							<li class="list-group-item">
								<b>Working Station</b> <a class="pull-right"><?php echo $branch_name;?></a>
							</li>
							<li class="list-group-item">
								<b>Department </b> <a class="pull-right"><?php echo $department_name;?></a>
							</li>
							<li class="list-group-item">
								<b>Org. Joining Date</b> <a class="pull-right"><?php echo date('d-m-Y',strtotime($emp_cv_basic->org_join_date)); ?></a>
							</li>
							<li class="list-group-item">
								<b>Permanent Date</b> <a class="pull-right"> <?php if($p_effect_date) { echo date('d-m-Y',strtotime($p_effect_date->effect_date)); } else { echo '--';}  ?></a>
							</li>
							<li class="list-group-item">
								<b>Last Promotion Date</b> <a class="pull-right"><?php if($promotion) { echo date('d-m-Y',strtotime($promotion->effect_date)); } else{ echo 'No Promotion'; }  ?></a>
							</li>
							<li class="list-group-item">
								<b>Service Length</b> <a class="pull-right">
								
								<?php 			
									$letter_date 	= date('Y-m-d');				
									date_default_timezone_set('Asia/Dhaka');
									$input_date = new DateTime($letter_date);
									$org_date = new DateTime($joining_date);	
									$difference = date_diff($org_date, $input_date);
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";

									?>
								</a>
							</li>
						</ul>
					    <a href="#" class="btn btn-primary btn-block"><b><h4>ID: <?php echo $emp_id;?> </h4></b></a>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			
<?php 
$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
$all_countries = array('1'=>'Bangladesh','2'=>'India');
?>		
			
			
			
		
		
			<!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#activity" data-toggle="tab">General Info</a></li>
						<li><a href="#pay_slip" data-toggle="tab">Pay Slip</a></li>
						<li><a href="#leave" data-toggle="tab">Leave</a></li>
						<li><a href="#tax_token" data-toggle="tab">Security Money</a></li>
						<li><a href="#p_f" data-toggle="tab">P.F</a></li>
						<!--<li><a href="#pay_slip" data-toggle="tab">Salary Certificate</a></li>-->
						<li><a href="#loan_info" data-toggle="tab">Loan info</a></li>
						<!--<li><a href="#movement" data-toggle="tab">Movement</a></li>-->
						<li><a href="#web_link" data-toggle="tab">Web Link</a></li>
						<li><a href="#my_document" data-toggle="tab">My Document</a></li>
						<li><a href="#time_line" data-toggle="tab">Timeline</a></li>
					</ul>
					<div class="tab-content">
					
						<div class="active tab-pane" id="activity">
							<div class="post">
								<div class="user-block">
	
									<div class="box-header"><h4>General Information:</h4></div>
									
									<div class="box-body">
										<div class="table-responsive">
											
											<div class="col-md-9">
											<table class="table table-bordered">
												<tr>
													<td width="30%">Employee ID</td>
													<td>{{$emp_cv_basic->emp_id}}</td>
												</tr>
												<tr>
													<td width="30%">Employee Name (ENG)</td>
													<td>{{$emp_cv_basic->emp_name_eng}}</td>
												</tr>
												<tr>
													<td width="30%">Employee Name (Bang)</td>
													<td>{{$emp_cv_basic->emp_name_ban}}</td>
												</tr>
												<tr>
													<td width="30%">Father's Name</td>
													<td>{{$emp_cv_basic->father_name}}</td>
												</tr>
												<tr>
													<td width="30%">Mother's Name</td>
													<td>{{$emp_cv_basic->mother_name}}</td>
												</tr>
												<tr>
													<td width="30%">Date of Birth</td>
													<td><?php echo date('d-m-Y',strtotime($emp_cv_basic->birth_date)); ?></td>
												</tr>
												<tr>
													<td width="30%">Present Age</td>
													<td><?php $date1 = new DateTime($emp_cv_basic->birth_date);
													$date2 = date('Y-m-d');						
													$date3 = new DateTime($date2);						
													$interval = date_diff($date1, $date3);
													echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; ?>
													</td>
													
												</tr>
												<tr>
													<td width="30%">Religion</td>
													<td>@foreach ($allreligions as $religionid => $religionname)
													@if($religionid == $emp_cv_basic->religion)
													{{$religionname}}
													@endif
													@endforeach
													</td>
													
												</tr>
												<tr>
													<td width="30%">Maritial Status</td>
													<td>
														@if($emp_cv_basic->maritial_status == 'Married') {{'Married'}}
														@elseif($emp_cv_basic->maritial_status == 'Unmarried') {{'Unmarried'}}
														@else {{'N/A'}}
														@endif
													</td>
													
												</tr>
												<tr>
													<td width="30%">Nationality</td>
													<td>{{$emp_cv_basic->nationality}}</td>
													
												</tr>
												<tr>
													<td width="30%">National Id</td>
													<td>{{$emp_cv_basic->national_id}}</td>
												</tr>
												<tr>
													<td width="30%">Gender</td>
													
													<td>
													@if($emp_cv_basic->gender == 'Male') {{'Male'}}
													@else
													{{'Female'}}
													@endif
													</td>
												</tr>
												<tr>
													<td width="30%">Country Name</td>
													<td>
														@foreach ($all_countries as $country_id => $country_name)
														@if($country_id == $emp_cv_basic->country_id)
														{{$country_name}}
														@endif
														@endforeach
													</td>
												</tr>
												<tr>
													<td width="30%">Contact Number</td>
													<td>{{$emp_cv_basic->contact_num}}</td>
												</tr>
												<tr>
													<td width="30%">Email</td>
													<td>{{$emp_cv_basic->email}}</td>
												</tr>
												<tr>
													<td width="30%">Blood Group</td>
													<td>{{$emp_cv_basic->blood_group}}</td>
												</tr>
												<tr>
													<td width="30%">Joining Date</td>
													<td><?php echo date('d-m-Y',strtotime($emp_cv_basic->org_join_date)); ?></td>
												</tr>
												<tr>
													<td width="30%">Present Address</td>
													<td>{{$emp_cv_basic->present_add}}</td>
												</tr>
												<tr>
													<td width="30%">Permanent Address</td>
													<td>{{$emp_cv_basic->permanent_add}}</td>
												</tr>
											</table>
											</div>
											<div class="col-md-3">
												@if($emp_cv_photo)
												<img style="height: 180px; width: 172px;" class="img-thumbnail" src="{{asset('public/employee/'.$emp_cv_photo->emp_photo)}}" />
												@else
												<img style="height: 180px; width: 172px;" class="img-thumbnail" src="{{asset('public/employee/placeholder.png')}}" /> 
												@endif
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
													@foreach($emp_cv_edu as $emp_edu)
													<tr>
														<td>{{$emp_edu->exam_name}}</td>
														<td>{{$emp_edu->subject_name}}</td>
														<td>{{$emp_edu->board_uni_name }}</td>
														<td>{{$emp_edu->result}}</td>
														<td>{{$emp_edu->pass_year}}</td>
													</tr>
													@endforeach
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
													<th>Sl</th>
													<th>Training Name</th>
													<th>Training Period</th>
													<th>Institute Name</th>
													<th>Place</th>
												</tr>
											</thead>
											<tbody>
												@foreach($emp_cv_tra as $emp_tra)
												<tr>
													<td>{{$loop->iteration}}</td>
													<td>{{$emp_tra->train_name}}</td>
													<td>{{$emp_tra->train_period}}</td>
													<td>{{$emp_tra->institute}}</td>
													<td>{{$emp_tra->palace}}</td>
												</tr>
												@endforeach
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
												@foreach($emp_cv_exp as $emp_exp)
												<tr>
													<td>{{$emp_exp->designation}}</td>
													<td>{{$emp_exp->experience_period}}</td>
													<td>{{$emp_exp->organization_name}}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
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
													@foreach($emp_cv_ref as $emp_ref)
													<tr>
														<td>{{$emp_ref->rf_name}}</td>
														<td>{{$emp_ref->rf_occupation}}</td>
														<td>{{$emp_ref->rf_address}}</td>
														<td>{{$emp_ref->rf_mobile}}</td>
														<td>{{$emp_ref->rf_email}}</td>
														<td>{{$emp_ref->rf_national_id}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
									
									

											
											
											
											
											
											
										
								</div>
							</div>
						</div>
				
						
						<div class="tab-pane" id="pay_slip">
							<div class="post">
								<div class="user-block">
									
									<table>
										<tr>
											<td><input type="date" name="salary_month" id="salary_month" value="<?php echo date('Y-m-d', strtotime('last day of previous month')); ?>"></td>
											<td><button type="button" onClick="get_pay_slip();">Search</button></td>
											<td><button type="button" onclick="javascript:printDiv('printable_div')">Print</button></td>
										</tr>
									</table>
									<hr>
									<div id="printable_div">
										
										<table border="0" cellspacing="0" width="100%" align="center">
											<tbody>
												<tr>
													<td rowspan="4" align="right"><img style="width: 80px; height: 80px;" src="{{ asset('public/org_logo/cdip.png') }}"></td>
													<td align="center"><b><font size="4">
														Centre for Development Innovation and Practices (CDIP)</font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
													<font size="4"><b> সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস  (  সিদীপ ) </font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
														<b><font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
														<b><font size="2">Web: www.cdipbd.org, Phone: 02-9141891 & 9141893</font></b>
													</td>
												</tr>
											</tbody>
										</table>
										<hr>
										<center><h3><u>Monthly Pay Slip</u></h3></center>
										<br>
										<table width="100%" border="0">
											<tr>
												<td>Name </td>
												<td align="right"> : </td>
												<td align="left" width="60%">{{$emp_cv_basic->emp_name_eng}}</td>
												<td align="right">Month of Salary</td>
												<td align="right"> : </td>
												<td align="right" id="formatted_date">--</td>
											</tr>
											<tr>
												<td>ID</td>
												<td align="right"> :</td>
												<td><?php echo $emp_id;?></td>
											</tr>
											<tr>
												<td>Designation</td>
												<td align="right"> :</td>
												<td><?php echo $designation_name;?></td>
											</tr>
											<tr>
												<td>Program/Dept.</td>
												<td align="right"> :</td>
												<td><?php echo $department_name ; ?></td>
											</tr>
										</table>
										<br><br>
										<div id="dynamic_content">
										
										
										
										</div>
										<hr>
										<p>Note: This statement generated following payroll applications</p>
										
									</div>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="p_f">
							<div class="post">
								<div class="user-block">
									
									<div id="printme">
										<div class="text-center">
											<table border="0" cellspacing="0" width="80%" align="center">
											<tbody>
												<tr>
													<td rowspan="4" align="right"><img style="width: 100px; height: 100px;" src="{{ asset('public/org_logo/cdip.png') }}"></td>
													<td align="center"><b><font size="5">
														Centre for Development Innovation and Practices (CDIP)</font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
													<font size="4"><b> সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস  (  সিদীপ ) </font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
														<b><font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font></b>
													</td>
												</tr>
												<tr>
													<td align="center">
														<b><font size="2">Web: www.cdipbd.org, Phone: 02-48118633 , 02-48118634</font></b>
													</td>
												</tr>
											</tbody>
										</table>
										</div>
										<hr>
										<table class="table table-bordered">
											<tr align="center">
												<td rowspan="2">ID</td>
												<td rowspan="2">Name</td>
												<td colspan="2">Opening Balance</td>
												<td colspan="2">Interest</td>
												<td colspan="2">Closing Balance</td>
											</tr>
											<tr align="center">
												<td>Staff</td>
												<td>Org</td>
												<td>Staff</td>
												<td>Org</td>
												<td>Staff</td>
												<td>Org</td>
											</tr>
											<tr align="center">
												<td>{{$emp_cv_basic->emp_id}}</td>
												<td>{{$emp_cv_basic->emp_name_eng}}</td>
												<?php if($pf_info) { ?>
												<td><?php echo $pf_info->opening_balance; ?></td>
												<td><?php echo $pf_info->opening_balance_org; ?></td>
												<td><?php echo $pf_info->interest_amount_stuff; ?></td>
												<td><?php echo $pf_info->interest_amount_org; ?></td>
												<td><?php echo $pf_info->closing_balance_staff; ?></td>
												<td><?php echo $pf_info->closing_balance_org; ?></td>
												<?php } else { ?>
												<td colspan="6" align="center">No PF Information</td>
												<?php } ?>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="movement">
							<div class="post">
								<div class="user-block">
								
									<form class="form-horizontal" role="form" method="POST" id="movement_form">
										{{ csrf_field() }}
										<input type="hidden" name="emp_id" value="<?php echo $emp_id;?>">
										
										<div class="form-group">
											<label for="leave_type" class="col-sm-2 control-label"> Destinations </label>
											<div class="col-sm-10">
											   <select  name="destination_code[]" multiple="multiple"   id="destination_code" class="form-control  select2" required> 
													@foreach($branch_list as $branch)
														<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option> 
													@endforeach 
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="purpose" class="col-sm-2 control-label">Purpose</label>
											<div class="col-sm-4">
											  <input type="text" name="purpose" id="purpose" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label for="from_date" class="col-sm-2 control-label">Date From</label>
											<div class="col-sm-3">
											  <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d');?>" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label for="to_date" class="col-sm-2 control-label">Date To</label>
											<div class="col-sm-3">
											  <input type="date" name="to_date"  id="to_date" value="<?php echo date('Y-m-d');?>" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label for="leave_time" class="col-sm-2 control-label">Leave Time </label>
											<div class="col-sm-3">
												<input  type="time" id="leave_time" name="leave_time" class="form-control">
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="button" class="btn btn-danger" id="btn_movement" onclick="save_movement_application();">Submit for Approvol</button>
											</div>
										</div>
										
										
									</form>
								
								</div>
							</div>
						</div>
						
						
						
						
						
						
						
						<div class="tab-pane" id="leave">
							<div class="post">
								<div class="user-block">
								
									<div class="col-sm-6">
										<form class="form-horizontal" role="form" method="POST" id="leave_form"> 
											{{ csrf_field() }}
											<input type="hidden" name="emp_id" value="<?php echo $emp_id;?>">
											<input type="hidden" name="id" id="id" value="">
											<input type="hidden" name="reported_to" id="reported_to" value="<?php echo $report_to_new; ?>">
											
											<div class="form-group">
												<label for="leave_type" class="col-sm-4 control-label">Leave Source</label>
												<div class="col-sm-8">
												   <select class="form-control" name="leave_type" id="leave_type">
														<option value="1">Earn</option>
														<option value="2">Previous Year</option>
												   </select>
												</div>
											</div>
											<div class="form-group">
												<label for="application_date" class="col-sm-4 control-label">Application Date</label>
												<div class="col-sm-8">
												   <input type="date" class="form-control" id="application_date" name="application_date" value="<?php echo date('Y-m-d')?>">
												</div>
											</div>
											<div class="form-group">
												<label for="leave_from" class="col-sm-4 control-label">Date From</label>
												<div class="col-sm-8">
												   <input type="date" class="form-control" id="leave_from" name="leave_from" value="<?php echo date('Y-m-d')?>">
												</div>
											</div>
											<div class="form-group">
												<label for="leave_to" class="col-sm-4 control-label">Date To</label>
												<div class="col-sm-8">
												   <input type="date" class="form-control" id="leave_to" name="leave_to" value="<?php echo date('Y-m-d')?>">
												</div>
											</div>
											<div class="form-group">
												<label for="pay_type" class="col-sm-4 control-label">Pay Type of Leave</label>
												<div class="col-sm-8">
												   <select class="form-control" name="pay_type" id="pay_type">
														<option value="1">With Pay</option>
														<option value="2">Without Pay</option>
												   </select>
												</div>
											</div>
											<div class="form-group">
												<label for="remarks" class="col-sm-4 control-label">Remarks</label>
												<div class="col-sm-8">
												   <input type="text" class="form-control" id="remarks" name="remarks"  placeholder="Cause of Leave">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<button type="button" class="btn btn-danger" id="btnSave" onclick="save_leave_application();">Submit for Approve</button>
												</div>
											</div>
										</form>
									</div>
									
									<div class="col-sm-6">
										<a href="#" class="btn btn-success btn-block"><b>Earn Leave :  <?php echo $leave_balance->current_open_balance ;?></b></a>
										<a href="#" class="btn btn-warning btn-block"><b>Enjoyed : <?php echo $leave_balance->no_of_days ;?></b></a>
										<a href="#" class="btn btn-danger btn-block"><b>Balance : <?php echo $leave_balance->current_close_balance ;?></b></a>
										<a class="btn btn-info btn-block" target="_BLANCK" href="leave_report_profile/<?php echo $emp_id; ?>">Detail...</a>
										<table class="table table-bordered" id="list_leave">
											<tr>
												<th>Sl</th>
												<th>Date From</th>
												<th>Date To</th>
												<th>Duration</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
											<?php $l= 1; if($leave_infos) { foreach($leave_infos as $leave_info) { ?>
											<tr>
												<td><?php echo $l++; ?></td>
												<td><?php echo date('d-m-Y',strtotime($leave_info->leave_from)); ?></td>
												<td><?php echo date('d-m-Y',strtotime($leave_info->leave_to)); ?></td>
												<td>
												<?php 
													$dStart = new DateTime($leave_info->leave_from);
													$dEnd  = new DateTime($leave_info->leave_to);
													$dDiff = $dStart->diff($dEnd);
													echo $dDiff->format('%r%a')+1;
												?>
												Day.
												</td>
												<?php if($leave_info->is_approve == 0 ) { ?> 
												<td>Pending..</td>
												<td>
													<button onclick="get_leave_info('<?php echo $leave_info->id; ?>')" class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></button>
													<button onclick="delete_application('<?php echo $leave_info->id; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-times" aria-hidden="true"></i></button>
												</td>
												<?php } else { ?>
												<td>Approved..</td>
												<td>--</td>
												<?php } ?>
											</tr>
											<?php } } else { ?>
											<tr>
												<td colspan="6" align="center">No Record's Found </td>
											</tr>
											<?php } ?>
										</table>
										
									</div>
									
									<br>
								
									
								
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="tax_token">
							<div class="post">
								<div class="user-block">
									<h3>Security Money</h3>
									<table class="table table-bordered">
										<tr>
											<td>Deposit Amount</td>
											<td>Interest Amount</td>
											<td>Total Amount</td>
										</tr>
										<tr>
											<td><?php if($staff_security) { echo $my_diposit = $staff_security->diposit_amount; } else { echo $my_diposit = 0; }  ?></td>
											<td><?php echo $interest = 0; ?></td>
											<td><?php echo $total_amount = $my_diposit + $interest; ?></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="web_link">
							<div class="post">
							  <div class="user-block">
								
									<h3>Service Rules</h3>
									
									<table class="table table-bordered">
										<tr>
											<td>1.</td>
											<td>Service Rules</td>
											<td>Publish Date</td>
											<td>Document</a></td>
										</tr>
										<?php foreach($offfice_orders as $offfice_order) { ?>
										<tr>
											<td>Sl</th>
											<td><?php echo $offfice_order->title ?></td>
											<td><?php echo date('d-m-Y',strtotime($offfice_order->order_date)) ;?></td>
											<td><?php 
													if(!empty($offfice_order->file_name)){ 
														$ss= explode('.',$offfice_order->file_name);
													if($ss[1] == 'pdf')
													{?>
													<a href="{{asset('storage/office_order/'.$offfice_order->file_name)}}" target="_blank"><img src="{{asset('storage/office_order/pdf.png')}}" width="40" style="height:35px;" /></a> 
												<?php }else if($ss[1] == 'doc'){ ?>
														<a href="{{asset('storage/office_order/'.$offfice_order->file_name)}}" target="_blank"><img src="{{asset('storage/office_order/doc.png')}}" width="40" style="height:35px;" /></a> 
												<?php }else{ ?>
														<a href="{{asset('storage/office_order/'.$offfice_order->file_name)}}" target="_blank"><img    src="{{asset('storage/office_order/'.$offfice_order->file_name)}}" width="40" style="height:35px;" /></a> 
													<?php } }else{ ?>
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<?php } ?>
												&nbsp;&nbsp;&nbsp;&nbsp;
									
												<?php if(!empty($offfice_order->word_file_name)){
													$ss= explode('.',$offfice_order->word_file_name);
													if($ss[1] == 'pdf')
													{?>
													<a href="{{asset('storage/office_order/'.$offfice_order->word_file_name)}}" target="_blank"><img src="{{asset('storage/office_order/pdf.png')}}" width="40" style="height:35px;" /></a> 
												<?php }else if($ss[1] == 'doc'){ ?>
														<a href="{{asset('storage/office_order/'.$offfice_order->word_file_name)}}" target="_blank"><img src="{{asset('storage/office_order/doc.png')}}" width="40" style="height:35px;" /></a> 
												<?php }else{ ?>
														<a href="{{asset('storage/office_order/'.$offfice_order->word_file_name)}}" target="_blank"><img    src="{{asset('storage/office_order/'.$offfice_order->word_file_name)}}" width="40" style="height:35px;" /></a> 
												<?php }} ?>
											</td>
										</tr>
										<?php } ?>									
									</table>
								
							  </div>
							</div>
						</div>
						
						<div class="tab-pane" id="my_document">
							<div class="post">
							  <div class="user-block">
								
									<h3>My Document's</h3>
									
									<table class="table table-bordered">
										<tr>
											<th>Sl</th>
											<th>Subject</th>
											<th>Date</th>
											<th>Link</th>
										</tr>
										<?php $dc = 1; foreach($emp_document_list as $emp_document) { ?>
										<tr>
											<td><?php echo $dc++; ?></td>
											<td><?php echo $emp_document->subcategory_name; ?></td>
											<td><?php echo date('d-m-Y',strtotime($emp_document->effect_date)); ?></td>
											<?php  
												$ddd = explode('.',$emp_document->document_name);
													if($ddd[1] == 'pdf' || $ddd[1] == 'PDF'){
														$ext = 1;
													}else if($ddd[1] == 'doc' || $ddd[1] == 'DOC' ){
														$ext = 2;
													}else{
														$ext = 3;
													}
													if($emp_document->category_id == 13){
														$folder_name = "c_v/";
													}else if($emp_document->category_id == 5){
														$folder_name = "edu_cation/";
													}else if($emp_document->category_id == 11){
														$folder_name = "miscell_aneous/";
													}else if($emp_document->category_id == 24){
														$folder_name = "train_ing_info/";
													}else {
														if(($emp_document->effect_date == '2019-07-01') && ($emp_document->category_id == 23) && ($emp_document->subcat_id == 24)){
															$folder_name = "attach_ment_tran/auto_increment/";
														}else{
															$folder_name = "attach_ment_tran/";
														}
													}
													$filename = "attachments/$folder_name/$emp_document->document_name";
												?> 
											<td><a href="{{asset($filename)}}" target="_blank" ><img src="{{asset('storage/office_order/pdf.png')}}"></a></td>
										</tr>
										<?php } ?>
									</table>
								
							  </div>
							</div>
						</div>

						<!-- /.tab-pane -->
						<div class="tab-pane" id="time_line">
							<!-- The timeline -->
							
							<?php foreach($all_sarok as $v_all_sarok) { ?>
							
							
							<?php if($v_all_sarok->transaction_code == 9) { 
							
							
							$punishment = DB::table('tbl_punishment')
										->where('tbl_punishment.sarok_no', $v_all_sarok->sarok_no)
										->first();
							
							
							} ?>
							
							<ul class="timeline timeline-inverse">
							  <!-- timeline time label -->
								<li class="time-label">
									<span class="bg-red"><?php echo date('d-m-Y',strtotime($v_all_sarok->letter_date)); ?></span>
								</li>
							  <!-- /.timeline-label -->
							  <!-- timeline item -->
								<li>
									<i class="fa fa-envelope bg-blue"></i>
									<div class="timeline-item">
										<h3 class="timeline-header"><a href="#"><?php echo $v_all_sarok->transaction_name; ?></a></h3>
										<div class="timeline-body">
											
											<?php if($v_all_sarok->transaction_code != 13) { ?>
											
											<?php if($v_all_sarok->transaction_code != 9) {  ?>
											<table class="table table-bordered">
												<tr>
													<td>Sarok No</td>
													<td>: </td>
													<td><?php echo $v_all_sarok->sarok_no;?></td>
												</tr>
												<tr>
													<td>Letter Date</td>
													<td>: </td>
													<td><?php echo date('d-m-Y',strtotime($v_all_sarok->letter_date));?></td>
												</tr>
												<tr>
													<td>Effect Date</td>
													<td>: </td> 
													<td><?php if($v_all_sarok->transaction_code == 8) { echo date('d-m-Y',strtotime($v_all_sarok->br_join_date)); } else { echo date('d-m-Y',strtotime($v_all_sarok->effect_date)); }  ?></td>
												</tr>
												<tr>
													<td>Working Station</td>
													<td>: </td>
													<td><?php echo @$v_all_sarok->branch_name;?></td>
												</tr>
												<tr>
													<td>Designation</td>
													<td>: </td>
													<td><?php echo $v_all_sarok->designation_name;?></td>
												</tr>
												<tr>
													<td>Grade</td>
													<td>: </td>
													<td>Grade : <?php echo $v_all_sarok->grade_code;?></td>
												</tr>
												<tr>
													<td>Step</td>
													<td>: </td>
													<td><?php echo $v_all_sarok->grade_step -1 ;?></td>
												</tr>
												<tr>
													<td>Basic Salary</td>
													<td>: </td>
													<td><?php echo $v_all_sarok->basic_salary;?></td>
												</tr>
											</table>
										<?php } else { ?>
										
											<table class="table table-bordered">
												<tr>
													<td>Sarok No</td>
													<td>: </td>
													<td><?php echo $v_all_sarok->sarok_no;?></td>
												</tr>
												<tr>
													<td>Letter Date</td>
													<td>: </td>
													<td><?php echo $v_all_sarok->letter_date;?></td>
												</tr>
												<tr>
													<td>Punishment Details</td>
													<td>: </td>
													<td><?php echo $punishment->punishment_details ;?></td>
												</tr>
												<tr>
													<td>Fine Amount</td>
													<td>: </td>
													<td><?php if($punishment->fine_amount == '' ) { echo 0; } else { echo $punishment->fine_amount; } ?></td>
												</tr>
												<tr>
													<td>Punishment By</td>
													<td>: </td>
													<td><?php echo $punishment->punishment_by ;?></td>
												</tr>
											</table>
										
											<?php } } ?>
										
										</div>
										<!--
										<div class="timeline-footer">
											<a class="btn btn-primary btn-xs">Details..</a>
										</div>-->
									</div>
								</li>
								<!-- END timeline item -->
							</ul>
							<?php } ?>
						</div>
						<!-- /.tab-pane -->

		
						<div class="tab-pane" id="loan_info">
							<div class="post">
							  <div class="user-block">
								
									<h3>Loan info</h3>

									<table class="table table-bordered">
										<tr>
											<td>Sl</td>
											<td>Loan Id</td>
											<td>Application Date</td>
											<td>Loan Code</td>
											<td>Loan Product</td>
											<td>Disbursement Date</td>
											<td>Loan Amount</td>
											<td>First repayment date</td>
											<td>View</td>
										</tr>
										<?php $l=1; if(!empty($loanData[0])) { foreach($loanData as $loan) {  ?>
										<tr>
											<td><?php echo $l; ?></td>
											<td><?php echo $loan->loan_id; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->application_date)); ?></td>
											<td><?php echo $loan->loan_code; ?></td>
											<td><?php echo $loan->loan_product_name; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->disbursement_date)); ?></td>
											<td><?php echo $loan->loan_amount; ?></td>
											<td><?php echo date('d-m-Y',strtotime($loan->first_repayment_date)); ?></td>
											<td>
											<button type="button" class="btn btn-primary btn-xs button view_button"
													data-toggle="modal" data-target="#view_loan_details"
													data-id="{{ $loan->loan_id }}"
													data-loan_code="{{ $loan->loan_code }}"
													data-loan_product_name="{{ $loan->loan_product_name }}"
													data-first_repayment_date="{{ date("M-Y", strtotime($loan->first_repayment_date)) }}"
													data-emp_id="{{ $loan->emp_id }}"
													data-emp_name="{{ $loan->emp_name_eng }}">
												<i class="fa fa-search"></i>
											</button>
											</td>
										</tr>
										<?php $l++; } } else { ?>
										<tr>
											<td align="center" colspan="9">There is no loan informarion</td>
										</tr>
										<?php } ?>
									</table>
									
								</div>
							</div>
						</div>
						
					</div>
					<!-- /.tab-content -->
				</div>
			  <!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
    </section>
	
	
	
	
	
	
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>   
            <br>

			<input type="text" class="form-control" value="" name="loan_id" id="loan_id">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


    <style>
        .modal-dialog {
            width: 80%;
            /*height: 100%;*/
            margin: 0 auto;
            padding: 1%;
        }

        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }
    </style>

    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view_loan_details"
         class="modal fade bd-example-modal-md">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    
					<div id="printme">
                        <div class="text-center">
                            <table border="0" cellspacing="0" width="100%">
                                <tbody>
									<tr>
										<td align="center"><b><font size="4"> <img style="width: 40px" src="{{ asset('public/org_logo/cdip.png') }}">
											Centre for Development Innovation and Practices (CDIP)</font></b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<b><font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font></b>
										</td>
									</tr>
									<tr>
										<td align="center">
											<b><font size="2">Web: www.cdipbd.org, Phone: 02-9141891 & 9141893</font></b>
										</td>
									</tr>
                                </tbody>
                            </table>
                        </div>
                        <table style="margin-bottom: 10px" border="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <td align="left"><b><font size="4">Name: <span id="loan_schedule_for"></span></font></b>
                                </td>
                                <td align="center">
                                    <b><font size="4"><span id="for_loan_code"></span></font></b>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <b><font size="2"><span id="first_repayment_date"></span></font></b>
                                </td>
                                <td align="center">
                                    <b><font size="2">Print Date: {{ date("d-m-Y") }}</font></b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="modal-body">
                            <div id="view_loan_details_list" class="row">
                                <div id="loan_table" class="box-body table-responsive">

                                </div>

                            </div>
                            <div id="note" style="display: none !important; position: fixed; bottom: 0;">
                                <small style="float:left">** (Report Generated From : CDIP Payroll)</small>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
	</div>
	
	
	
	
	<script>
		
            $(document).on("click", '.view_button', function (e) {

                var id = $(this).data('id');
                var for_loan_code = $(this).data('loan_code');
                var loan_schedule_for = $(this).data('emp_name');
                var emp_id = $(this).data('emp_id');
                var loan_product_name = $(this).data('loan_product_name');
                var first_repayment_date = $(this).data('first_repayment_date');
                var url = "{{ URL::to('/get_loan_details_by_id') }}";
                $.ajax({
                    type: "GET",
//                data: {id: id},
                    url: url + "/" + id,
                    success: function (res) {
//                    console.log(res);
                        $("#loan_table").html(res);
                        $("#loan_schedule_for").text(loan_schedule_for + " (" + emp_id + ")");
                        $("#for_loan_code").text('Loan code: ' + loan_product_name + ' (' + for_loan_code + ')');
                        $("#first_repayment_date").text('Repayment Date: ' + first_repayment_date);
                    }
                })

            });
			
			
			
		function get_leave_info(id)
		{
			var url = "{{ URL::to('/get-leave-info') }}";
			$.ajax({
				type: "GET",
				url: url + "/" + id,
				success: function (res) {
					document.getElementById("id").value = res.id;
					document.getElementById("application_date").value = res.application_date;
					document.getElementById("leave_from").value = res.leave_from;
					document.getElementById("leave_to").value = res.leave_to;
					document.getElementById("leave_type").value = res.leave_type;
					document.getElementById("pay_type").value = res.pay_type;
					document.getElementById("remarks").value = res.remarks;
				}
			})
		}
		
		function delete_application(id){
			if(confirm('Are you sure to delete this data?'))
			{
				var message='Application Deleted Successfully';
				
				$.ajax({
					url : "{{url('delete_leave_application')}}"+"/"+id,
					type: "GET",
					dataType: "JSON",
					success: function(data)
					{
						if(data.del_status)
						{
							$.gritter.add({
								title: 'Success!',
								text: message,
								sticky: false,
								class_name: 'gritter-light'
							});
						}
						
						$("#list_leave").load(location.href + " #list_leave");	
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('Error deleting data');
					}
				});

			}
		}

		
		function save_leave_application()
		{
			$('#btnSave').text('saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable 
			url = "{{URL::to('/leave-appliacation')}}";
			message='Data Saved Successfully';
			$.ajax({
				url : url,
				type: "POST",
				data: $('#leave_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(data.insert_status)
					{
						$.gritter.add({
							title: 'Success!',
							text: message,
							sticky: false,
							class_name: 'gritter-light'
						});
					}
					$('#btnSave').text('Save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
					$("#list_leave").load(location.href + " #list_leave");	
					document.getElementById("leave_form").reset();				
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$.gritter.add({
						title: 'Error!',
						text: 'Error to Save Data'
					});
					$('#btnSave').text('Save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}
		
		function save_movement_application()
		{
			$('#btn_movement').text('saving...'); //change button text
			$('#btn_movement').attr('disabled',true); //set button disable 
			url = "{{URL::to('/movement')}}";
			message='Data Saved Successfully';
			$.ajax({
				url : url,
				type: "POST",
				data: $('#movement_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(data.insert_status)
					{
						$.gritter.add({
							title: 'Success!',
							text: message,
							sticky: false,
							class_name: 'gritter-light'
						});
					}
					$('#btn_movement').text('Save'); //change button text
					$('#btn_movement').attr('disabled',false); //set button enable 
					document.getElementById("movement_form").reset();				
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$.gritter.add({
						title: 'Error!',
						text: 'Error to Save Data'
					});
					$('#btn_movement').text('Save'); //change button text
					$('#btn_movement').attr('disabled',false); //set button enable 
				}
			});
		}
		
	</script>
	
	<script>
		var iWords = ['Zero', ' One', ' Two', ' Three', ' Four', ' Five', ' Six', ' Seven', ' Eight', ' Nine'];
		var ePlace = ['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
		var tensPlace = ['', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety'];
		var inWords = [];
		 
		var numReversed, inWords, actnumber, i, j;
		 
		function tensComplication() {
			'use strict';
			if (actnumber[i] === 0) {
				inWords[j] = '';
			} else if (actnumber[i] === 1) {
				inWords[j] = ePlace[actnumber[i - 1]];
			} else {
				inWords[j] = tensPlace[actnumber[i]];
			}
		}
		 
		function testSkill() {
			'use strict';
			var junkVal = document.getElementById('net_pay').value;
			//alert(finalWord);
			
			junkVal = Math.floor(junkVal);
			var obStr = junkVal.toString();
			numReversed = obStr.split('');
			actnumber = numReversed.reverse();
		 
			if (Number(junkVal) >= 0) {
				//do nothing
			} else {
				window.alert('wrong Number cannot be converted');
				return false;
			}
			if (Number(junkVal) === 0) {
				document.getElementById('container').innerHTML = obStr + '' + 'Taka Zero Only';
				return false;
			}
			if (actnumber.length > 9) {
				window.alert('Oops!!!! the Number is too big to covertes');
				return false;
			}
		 
		 
		 
			var iWordsLength = numReversed.length;
			var finalWord = '';
			j = 0;
			for (i = 0; i < iWordsLength; i++) {
				switch (i) {
					case 0:
						if (actnumber[i] === '0' || actnumber[i + 1] === '1') {
							inWords[j] = '';
						} else {
							inWords[j] = iWords[actnumber[i]];
						}
						inWords[j] = inWords[j] + ' Only';
						break;
					case 1:
						tensComplication();
						break;
					case 2:
						if (actnumber[i] === '0') {
							inWords[j] = '';
						} else if (actnumber[i - 1] !== '0' && actnumber[i - 2] !== '0') {
							inWords[j] = iWords[actnumber[i]] + ' Hundred and';
						} else {
							inWords[j] = iWords[actnumber[i]] + ' Hundred';
						}
						break;
					case 3:
						if (actnumber[i] === '0' || actnumber[i + 1] === '1') {
							inWords[j] = '';
						} else {
							inWords[j] = iWords[actnumber[i]];
						}
						if (actnumber[i + 1] !== '0' || actnumber[i] > '0') {
							inWords[j] = inWords[j] + ' Thousand';
						}
						break;
					case 4:
						tensComplication();
						break;
					case 5:
						if (actnumber[i] === '0' || actnumber[i + 1] === '1') {
							inWords[j] = '';
						} else {
							inWords[j] = iWords[actnumber[i]];
						}
						if (actnumber[i + 1] !== '0' || actnumber[i] > '0') {
							inWords[j] = inWords[j] + ' Lakh';
						}
						break;
					case 6:
						tensComplication();
						break;
					case 7:
						if (actnumber[i] === '0' || actnumber[i + 1] === '1') {
							inWords[j] = '';
						} else {
							inWords[j] = iWords[actnumber[i]];
						}
						inWords[j] = inWords[j] + ' Crore';
						break;
					case 8:
						tensComplication();
						break;
					default:
						break;
				}
				j++;
			}
		 
		 
			inWords.reverse();
			for (i = 0; i < inWords.length; i++) {
				finalWord += inWords[i];
			}
			//document.getElementById('container').innerHTML = obStr + '  ' + finalWord;
			
			//alert(finalWord);
			document.getElementById('in_word').innerHTML =  finalWord;
		}

		//testSkill();
		</script>
	
	<script src="{{asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
	
	<script>
		function get_pay_slip()
		{
			var salary_month = document.getElementById("salary_month").value;
			const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			let current_datetime = new Date(salary_month)
			let formatted_date =  months[current_datetime.getMonth()] + "-" + current_datetime.getFullYear()
			var url = "{{ URL::to('/get-pay-slip') }}";
			$.ajax({
				type: "GET",
				url: url + "/" + salary_month,
				success: function (res) {
					document.getElementById("formatted_date").innerHTML = formatted_date;
					$("#dynamic_content").html(res); 
				}
			})
		}	
	</script>
	
	
	<script>

	 $('.select2').select2();

	 function settotaldayfrom(){
			$('#to_date').val(document.getElementById("from_date").value);
			settotalday();
	 }  
	/* $('.timepicker1').timepicker();  */
	function settotalday(){  
		 var from_date         		=$('#from_date').datepicker('getDate');
		 var to_date          		=$('#to_date').datepicker('getDate');
			 if (from_date <= to_date) {
				  var day   = (to_date - from_date)/1000/60/60/24;
				  var days =day+1;  
				  $('#tot_day').val(days);
				  $('#error1').html("");
			 }else{
				 $('#error1').html("<b style='color:red;font-size:12px;'>From date must be less or equal!</b>");
				  $('#to_date').val(""); 	
			 }
	}  
	</script>
	
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
	
@endsection