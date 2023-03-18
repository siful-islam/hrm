@extends('admin.admin_master')
@section('title', 'Manage Scale')
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
						<label for="org_full_name" class="col-sm-2 control-label">Scale Id</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="scale_id" name="scale_id" value="{{$scale_id}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Scale Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="scale_name" name="scale_name" value="{{$scale_name}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Scale Basic </label>
						<div class="col-sm-4">
							<input type="number" class="form-control" id="scale_basic_1st_step" name="scale_basic_1st_step" value="{{$scale_basic_1st_step}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Increment Amount</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="increment_amount" name="increment_amount" value="{{$increment_amount}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Effect From</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="start_from" name="start_from" value="{{$start_from}}" required>
						</div>
					</div><div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Effect To</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="end_to" name="end_to" value="{{$end_to}}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Final Barer</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="final_bareer" name="final_bareer" value="{{$final_bareer}}" required>
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
				$("#Scale").addClass('active');
			});
	</script>

@endsection