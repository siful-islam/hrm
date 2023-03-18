@extends('admin.admin_master')
@section('title', 'Manage User Role')
@section('main_content')

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
				<h3 class="box-title"> {{$Heading}}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				

			
			<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}">
               
				{{ csrf_field() }}
				{!!$method_control!!}
				
				<input type="hidden" class="form-control" value="" name="id" id="id">
				
				<div class="box-body">
					<div class="form-group">
						<label for="admin_role_name" class="col-sm-2 control-label">Role Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="admin_role_name" name="admin_role_name" value="{{$admin_role_name}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="role_description" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-4">
							<textarea class="form-control" id="role_description" name="role_description" required>{{$role_description}}</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="role_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="role_status" id="role_status" class="form-control" required>							
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
					</div>					
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">Cancel</button>
					<button type="submit" class="btn btn-info">{{$button_text}}</button>
				</div>
				<!-- /.box-footer -->
			</form>
			

		</div>
	</section>
	
	<script>
		document.getElementById("role_status").value = '{{$role_status}}';
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupConfig").addClass('active');
			$("#Manage_User_Role").addClass('active');
		});
	</script>
@endsection