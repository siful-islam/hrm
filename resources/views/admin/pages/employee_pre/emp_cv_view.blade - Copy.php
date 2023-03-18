@extends('admin.admin_master')
@section('main_content')
<style>
.form-group {
    margin-bottom: 5px;
}
.table thead th { 
  background-color: #ECF0F5;
}
</style>
<section class="content-header">
  <h4>Employee CV View</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">Employee CV</li>
  </ol>
</section>
<section class="content">	
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<form class="form-horizontal">
					<div class="box-header"><h4>General Information:</h4></div>					
					<hr>
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-2">Employee ID</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Employee Name (ENG)</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Employee Name (Bang)</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Father Name</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Mother Name</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Date of Birth</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Age</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Religion</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Nationality</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">National Id</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Gender</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Country Name</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Contact Number</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Email</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Blood Group</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Joining Date</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Present Address</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_id}}</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2">Permanent Address</label>
							<div class="col-sm-4">: {{$emp_cv_basic->emp_name}}</div>
						</div>
					</div>
					<div class="box-header"><h4>Education Information:</h4></div>					
					<hr>
					<div class="box-body">
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
								@foreach($emp_cv_edu as $emp_edu)
								<tr>
									<td>{{$emp_edu->exam_code}}</td>
									<td>{{$emp_edu->subject_code}}</td>
									<td>{{$emp_edu->school_code}}</td>
									<td>{{$emp_edu->result}}</td>
									<td>{{$emp_edu->pass_year}}</td>
									<td>{{$emp_edu->pass_year}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
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
								@foreach($emp_cv_tra as $emp_tra)
								<tr>
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
				</form>
			</div>
		</div>
	</div>
</section>
@endsection