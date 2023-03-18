@extends('admin.admin_master')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Self<small>Care</small></h1>
	</section>
	
	<section class="content-header">
      <a href="{{'/profile'}}"><h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5></a>
		<ol class="breadcrumb">
			<li><a href="{{'/profile'}}">Self Care -></a> ***</li>
		</ol>
    </section>
	
	<!-- Main content -->
	<section class="content">


			
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
												<td></td>
												
											</tr>
											<tr>
												<td width="30%">Marital Status</td>
												<td></td>
												
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
												<td></td>
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
												@foreach($edu_up_val as $emp_edu)
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

    </section>
	
	
	<script>

		
	</script>
	
	
@endsection