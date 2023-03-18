@extends('admin.admin_master')
@section('title', 'Employee Assign')
@section('main_content')
<section class="content-header">
	<h1>view-assign</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">view-assign</li>
	</ol>
</section>
<section class="content">	
	<div class="row">
		<form class="form-horizontal">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label class="col-sm-2 control-label">Effect Date</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->open_date}}</div></div>
							<label class="col-sm-2 control-label">Employee ID</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->emp_id}}</div></div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Select Type</label>
							<div class="col-sm-3"><div class="form-control">
								<?php if($assign_info->select_type=="1") echo 'Employee Assign'; ?>
								<?php if($assign_info->select_type=="2") echo 'Work Station Change'; ?>
								<?php if($assign_info->select_type=="3") echo 'Letter of Council'; ?>
								<?php if($assign_info->select_type=="4") echo 'Report to HO'; ?>
								<?php if($assign_info->select_type=="5") echo 'Designation Change'; ?>
								<?php if($assign_info->select_type=="6") echo 'Final Deadline'; ?>
							</div></div>
							<label class="col-sm-2 control-label">Employee Name</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->emp_name_eng}}
							</div></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Designation</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->designation_name}}</div></div>
							<?php if($assign_info->select_type=="2") { ?>
							<label class="col-sm-2 control-label">Branch</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->branch_name}}</div></div>
							<?php } ?>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?php if($assign_info->select_type=="1") echo 'Incharge As'; ?>
								<?php if($assign_info->select_type=="2") echo 'Work Station Change'; ?>
								<?php if($assign_info->select_type=="3") echo 'Letter of Council'; ?>
								<?php if($assign_info->select_type=="4") echo 'Description'; ?>
								<?php if($assign_info->select_type=="5") echo 'Description'; ?>
								<?php if($assign_info->select_type=="6") echo 'Reason'; ?>
							</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->incharge_as}}</div></div>
							<?php if($assign_info->select_type=="2") { ?>
							<label class="col-sm-2 control-label">Salary Branch</label>
							<div class="col-sm-3"><div class="form-control">{{$assign_info->salary_branch_name}}</div></div>
							<?php } ?>
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/emp-assign')}}" class="btn bg-olive" ><i class="fa fa-fw fa-long-arrow-left" ></i> Back-to-List</a>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>
	</div>
</section>
<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Employee_Assign").addClass('active');
	});
</script>
@endsection