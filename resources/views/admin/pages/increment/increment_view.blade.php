@extends('admin.admin_master')
@section('main_content')
<section class="content-header">
  <h4>add-increment</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-increment</li>
  </ol>
</section>
<section class="content">	
	<div class="row">			
		<form class="form-horizontal">
			<div class="col-md-9">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee ID</label>
							<div class="col-sm-3"><div class="form-control">{{$increment_info->emp_id}}</div></div>
							<label class="col-sm-2 control-label">Letter Date</label>
							<div class="col-sm-3"><div class="form-control">{{date("d-m-Y", strtotime($increment_info->letter_date))}}</div></div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Effect Date</label>
							<div class="col-sm-3"><div class="form-control">{{date("d-m-Y", strtotime($increment_info->effect_date))}}</div></div>
							<label class="col-sm-2 control-label">Working Station</label>
							<div class="col-sm-3"><div class="form-control">{{$increment_info->br_name}}</div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Grade</label>
							<div class="col-sm-3"><div class="form-control">{{$increment_info->grade_name}}</div></div>
							<label class="col-sm-2 control-label">Department</label>
							<div class="col-sm-3"><div class="form-control">{{$increment_info->dept_name}}</div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Designation</label>
							<div class="col-sm-3"><div class="form-control">{{$increment_info->designation_name}}</div></div>
							<label class="col-sm-2 control-label">Reported To</label>
							<div class="col-sm-3"><div class="form-control">{{$increment_info->designation_name}}</div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Increment Type</label>
							<div class="col-sm-3"><div class="form-control">
								<?php if($increment_info->increment_type=="Increment") echo 'Increment'; ?>
								<?php if($increment_info->increment_type=="Review") echo 'Review'; ?>
							</div></div>
							<label class="col-sm-2 control-label">Next Increment Date</label>
							<div class="col-sm-3"><div class="form-control">{{date("d-m-Y", strtotime($increment_info->letter_date))}}</div></div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/increment')}}" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/1505038990.png')}}" alt="User profile picture">
						<h3 class="profile-username text-center" id="emp_name" >{{$increment_info->emp_name_eng}}</h3>
						<p class="text-muted text-center" id="designation_name">{{$increment_info->designation_name}}</p>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item"><b>Joining Date : </b><span id="joining_date"></span></li>
							<li class="list-group-item"><b>Working Station : </b><span id="branch_name">{{$increment_info->br_name}} </span></li>
						</ul>
						<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
@endsection