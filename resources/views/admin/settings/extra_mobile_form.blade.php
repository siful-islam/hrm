@extends('admin.admin_master')
@section('title', 'Manage Holiday')
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

				<form class="form-horizontal" action="{{URL::to($action)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
				
				<input type="hidden" id="extra_allowance_id" name="extra_allowance_id" value="{{$extra_allowance_id}}" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="holiday_date" class="col-sm-2 control-label">Employee ID </label>
						<div class="col-sm-4">
							<input class="form-control" type ="number" name="extra_allowance_emp_id" value="{{$extra_allowance_emp_id}}"> 
						</div>
					</div>
					<div class="form-group">
						<label for="extra_allowance_amount" class="col-sm-2 control-label">Amount</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" id="extra_allowance_amount" name="extra_allowance_amount" value="{{$extra_allowance_amount}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="extra_allowance_from_date" class="col-sm-2 control-label">Active From</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="extra_allowance_from_date" name="extra_allowance_from_date" value="{{$extra_allowance_from_date}}">
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
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Holiday").addClass('active');
		});
	</script>
@endsection