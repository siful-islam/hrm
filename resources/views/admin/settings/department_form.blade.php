@extends('admin.admin_master')
@section('title', 'Manage Department')
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
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}
				
				<input type="hidden" id="id" name="id" value="{{$id}}" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Department ID</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" id="department_id" name="department_id" value="{{$department_id}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Department Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="department_name" name="department_name" value="{{$department_name}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Department Name Bangla</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="department_bangla" name="department_bangla" value="{{$department_bangla}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>							
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
		document.getElementById("status").value = '{{$status}}';
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Department").addClass('active');
		});
	</script>


@endsection