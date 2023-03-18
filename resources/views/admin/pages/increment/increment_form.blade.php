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
		<!-- form start -->
		<!--<h3 style="color:green">
			@if(Session::has('message'))
			{{session('message')}}
			@endif
		</h3>-->
		<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<input type="hidden" id="id" name="id" value="{{$id}}">
			<input type="hidden" id="sarok_no" name="sarok_no" value="{{$sarok_no}}">
			<div class="col-md-9">
				<div class="box box-info">
					<div class="box-body">							
						<div class="form-group">
							<label for="emp_id" class="col-sm-2 control-label">Employee ID</label><span class="required">*</span>
							<div class="col-sm-3 {{ $errors->has('emp_id') ? ' has-error' : '' }}">
								<input type="number" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}" onChange="get_employee_info();" required>
								@if ($errors->has('emp_id'))
									<span class="help-block">
										<strong>{{ $errors->first('emp_id') }}</strong>
									</span>
								@endif
							</div>
							<label for="letter_date" class="col-sm-2 control-label">Letter Date</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control start_date" id="letter_date" name="letter_date" value="{{$letter_date}}" required>							
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="effect_date" class="col-sm-2 control-label">Effect Date</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control start_date" name="effect_date" value="{{$effect_date}}" required>
							</div>
							<label for="br_code" class="col-sm-2 control-label">Working Station</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="br_code" name="br_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($branches as $v_branches)
									<option value="{{$v_branches->br_code}}">{{$v_branches->br_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="grade_code" class="col-sm-2 control-label">Grade</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="grade_code" name="grade_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($grades as $v_grades)
									<option value="{{$v_grades->id}}">{{$v_grades->grade_name}}</option>
									@endforeach
								</select>
							</div>
							<label for="department_code" class="col-sm-2 control-label">Department</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="department_code" name="department_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($departments as $v_departments)
									<option value="{{$v_departments->id}}">{{$v_departments->dept_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="designation_code" class="col-sm-2 control-label">Select Designation</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="designation_code" name="designation_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($designation as $v_designation)
									<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
									@endforeach
								</select>
							</div>
							<label for="report_to" class="col-sm-2 control-label">Reported To</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" style="width: 100%;" id="report_to" name="report_to" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($designation as $v_designation)
									<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="increment_type" class="col-sm-2 control-label">Increment Type</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="increment_type" name="increment_type" required>						
									<option value="Increment" <?php if($increment_type=="Increment") echo 'selected="selected"'; ?> >Increment</option>
									<option value="Review" <?php if($increment_type=="Review") echo 'selected="selected"'; ?> >Review</option>
								</select>
							</div>
							<label for="department_code" class="col-sm-2 control-label">Next Increment Date</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control start_date" name="letter_date" value="{{$letter_date}}" required>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Cancel</button>
						<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/1505038990.png')}}" alt="User profile picture">
						<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
						<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item"><b>Joining Date : </b><span id="joining_date"> {{$joining_date}}</span></li>
							<li class="list-group-item"><b>Working Station : </b><span id="branch_name"> {{$branch_name}} </span></li>
						</ul>
						<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.start_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript">

	$(document).ready(function() {

		var button_text = document.getElementById("submit").innerHTML;
		if(button_text == 'Save') {
			$('#emp_id').removeAttr('disabled');
			$('#submit').attr("disabled", true);
		} else {
			$('#emp_id').attr("disabled", true);
			$('#submit').removeAttr('disabled');
		}
		
		document.getElementById("br_code").value="{{$br_code}}";
		document.getElementById("grade_code").value = '{{$grade_code}}';
		document.getElementById("department_code").value = '{{$department_code}}';
		document.getElementById("designation_code").value = '{{$designation_code}}';
		document.getElementById("branch_name").innerHTML = '{{$branch_name}}';
		document.getElementById("report_to").value = '{{$report_to}}';
	})
	
	function get_employee_info()
	{
		var emp_id = document.getElementById("emp_id").value;
		
		$.ajax({
			url : "{{ url::to('get-employee-info-transfer') }}"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.emp_name) {
					$('#employee_status').html('<b>Active Employee</b>');
					$('[name="emp_id"]').val(data.emp_id);
					$('#emp_name').html(data.emp_name);
					$('#joining_date').html(data.joining_date);
					$('#designation_code').val(data.designation_code);
					$('#designation_name').html(data.designation_name);
					$('#branch_name').html(data.branch_name);
					$('#br_code').val(data.br_code);
					$('#department_code').val(data.department_code);
					$('#report_to').val(data.report_to);
					$('#probation_time').val(data.probation_time);
					document.getElementById("emp_photo").src = "{{asset('public/employee/1505034887.jpg')}}";
					$('#submit').removeAttr('disabled');					
				} else {
					$('#employee_status').html('<b>This Employee is not Available</b>');
					$('[name="emp_id"]').val(data.emp_id);
					$('#emp_name').html('');
					$('#joining_date').html('');
					$('#designation_code').val('');
					$('#designation_name').html('');
					$('#branch_name').html('');
					$('#br_code').val('');
					$('#department_code').val('');
					$('#report_to').val('');
					$('#probation_time').val('');
					$('#submit').attr("disabled", true);
					document.getElementById("emp_photo").src = "{{asset('public/employee/1505038990.png')}}";
					$("#employee_status").removeClass("btn btn-primary btn-block");
					$("#employee_status").addClass("btn btn-danger btn-block"); 
				}
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
				$('#employee_status').html('This Employee is not Available');
				$('#submit').attr("disabled", true);
			}
		});
	}
	
</script>
@endsection