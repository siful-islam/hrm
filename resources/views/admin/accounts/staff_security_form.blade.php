@extends('admin.admin_master')
@section('title', 'Staff Security')
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
						<label for="org_full_name" class="col-sm-2 control-label">Employee Id</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Deposit Date</label>
						<div class="col-sm-4">
							<input type="date" class="form-control" id="diposit_date" name="diposit_date" value="{{$diposit_date}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Deposit Amount</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="diposit_amount" name="diposit_amount" value="{{$diposit_amount}}" required>
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
	$(document).ready(function() {
		$("#MainGroupSalary_Info").addClass('active');
		$("#Staff_Security").addClass('active');
	});
</script>

@endsection