@extends('admin.admin_master')
@section('title', 'Manage User')
@section('main_content')

<style>

.image-upload > input
{
    display: none;
}

.image-upload img
{
    margin-left:20%;
	margin-top:10px;
	width: 90;
	height:110;
    cursor: pointer;	
	background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px;
}
</style>

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> {{$data['Heading']}}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				
				<?php 
				//print_r($data['user_role']);
				?>
				
				<form class="form-horizontal" action="{{URL::to($data['action'])}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
				
				<input type="hidden" id="admin_id" name="admin_id" value="{{$data['admin_id']}}">
				
				<div class="box-body">
					<div class="form-group">
						<label for="first_name" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="first_name" name="first_name" value="{{$data['first_name']}}" placeholder="First Name">
						</div>
					</div>
					<div class="form-group">
						<label for="last_name" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="last_name" name="last_name" value="{{$data['last_name']}}" placeholder="Last Name">
						</div>
					</div>
					<div class="form-group">
						<label for="first_name" class="col-sm-2 control-label">Emp ID</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="emp_id" name="emp_id" value="{{$data['emp_id']}}" placeholder="Emp Id">
						</div>
					</div>
					<div class="form-group">
						<label for="admin_name" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="admin_name" name="admin_name" value="{{$data['admin_name']}}" placeholder="Username" required>
						</div>
					</div>
					<div class="form-group">
						<label for="email_address" class="col-sm-2 control-label">User Email</label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="email_address"  name="email_address" value="{{$data['email_address']}}" placeholder="User Email" required>
						</div>
					</div>
					<div class="form-group">
						<label for="cell_no" class="col-sm-2 control-label">Cell No</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="cell_no"  name="cell_no" value="{{$data['cell_no']}}" placeholder="Cell No">
						</div>
					</div>					
					<div class="form-group">
						<label for="admin_password" class="col-sm-2 control-label">User Password</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="admin_password"  name="admin_password" value="{{$data['admin_password']}}" placeholder="User Password" required>
						</div>
					</div>					
					<div class="form-group">
						<label for="access_label" class="col-sm-2 control-label">Access Lavel</label>
						<div class="col-sm-4">
							<select class="form-control" name="access_label" id="access_label" required>
								<option value="" hidden>-SELECT-</option>
								@foreach ($data['user_role'] as $user_role)
									<option value="{{ $user_role->id }}">{{ $user_role->admin_role_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="br_code" class="col-sm-2 control-label">Workstation</label>
						<div class="col-sm-4">
							<select class="form-control" name="br_code" id="br_code" required>
								<option value="0" >-Select-</option>
								@foreach ($data['branch_info'] as $branch)
									<option value="{{ $branch->br_code }}">{{ $branch->branch_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="user_type" class="col-sm-2 control-label">User Type</label>
						<div class="col-sm-4">
							<select class="form-control" name="user_type" id="user_type" required>
								<option value="0" >-Select-</option>
								<option value="1" <?php if($data['user_type']==1) echo 'selected'; ?> >Admin</option>
								<option value="2" <?php if($data['user_type']==2) echo 'selected'; ?> >HO</option>
								<option value="3" <?php if($data['user_type']==3) echo 'selected'; ?> >DM</option>
								<option value="4" <?php if($data['user_type']==4) echo 'selected'; ?> >AM</option>
								<option value="5" <?php if($data['user_type']==5) echo 'selected'; ?> >BM</option>
								<option value="6" <?php if($data['user_type']==6) echo 'selected'; ?> >Employee</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="admin_photo" class="col-sm-2 control-label">Profile Picture</label>
						<div class="col-sm-4">
							<label for="admin_photo">
							<img id="blah" class="img-thumbnail" src="{{asset($data['admin_photo'])}}" width="90" height="110"/>
							</label>
							<input type="file" onchange="readURL(this);" class="form-control" name="admin_photo" id="admin_photo">
							<input type="hidden" name="pre_admin_photo" value="{{$data['pre_admin_photo']}}">
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info">{{$data['button_text']}}</button>
				</div>
				<!-- /.box-footer -->
			</form>
		</div>
	</section>
	
	<script>
	document.getElementById("access_label").value={{$data['access_label']}}
	document.getElementById("br_code").value={{$data['br_code']}}
	</script>
	

	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#blah')
						.attr('src', e.target.result)
						.width(90)
						.height(110);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#User_Manager").addClass('active');
		});
	</script>
	
@endsection