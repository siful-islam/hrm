@extends('admin.admin_master')
@section('main_content')

<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small></small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Held up</li>
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
				<form class="form-horizontal" action="{{URL::to($action)}}" method="post">
                {{ csrf_field() }}	{!!$method_control!!}
				<input type="hidden" id="id" name="id" value="{{$id}}">
				<input type="hidden" id="sarok_no" name="sarok_no" value="{{$sarok_no}}">
				
				<input type="hidden" name="grade_code" value="{{$grade_code}}" id="grade_code">
				<input type="hidden" name="grade_step" value="{{$grade_step}}" id="grade_step">
				<input type="hidden" name="department_code" value="{{$department_code}}" id="department_code">
				<input type="hidden" name="designation_code" value="{{$designation_code}}" id="designation_code">
				<input type="hidden" name="br_code" value="{{$br_code}}" id="br_code">
				

				<div class="box-body col-md-9">
					
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3 {{ $errors->has('emp_id') ? ' has-error' : '' }}">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}" onChange="get_employee_info();" required>
							@if ($errors->has('emp_id'))
								<span class="help-block">
									<strong>{{ $errors->first('emp_id') }}</strong>
								</span>
							@endif
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Letter Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="letter_date" name="letter_date" value="{{$letter_date}}" onChange="get_employee_info();" required>
							
						</div>
					</div>
					<hr>


					<div class="form-group">
						
						<label for="zone_code" class="col-sm-2 control-label">What Help up <span class="required">*</span> </label>
						<div class="col-sm-3">
							<input type="text" name="what_heldup" class="form-control" value="{{$what_heldup}}" required>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Held up Time <span class="required">*</span> </label>
						<div class="col-sm-3">
							<input type="text" name="heldup_time" class="form-control" value="{{$heldup_time}}" required>
						</div>
					</div>
					<div class="form-group">
						
						<label for="zone_code" class="col-sm-2 control-label">Held up until Date <span class="required">*</span> </label>
						<div class="col-sm-3">
							<input type="date" name="heldup_until_date" class="form-control" value="{{$heldup_until_date}}" required>						
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Cause of Held up <span class="required">*</span> </label>
						<div class="col-sm-3">
							<textarea class="form-control" name="heldup_cause">{{$heldup_cause}}</textarea>
						</div>
					</div>
					<div class="form-group">
						
						<label for="status" class="col-sm-2 control-label">Activation Status </label>
						<div class="col-sm-3">
							<select name="status" id="status" class="form-control" required>
								<option value="1">Active</option>
								<option value="0">Cancel</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="col-sm-3">
							<button type="reset" class="btn btn-default">Cancel</button>
							<button type="submit" id="submit" class="btn btn-danger">{{$button_text}}</button>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/default.png')}}" alt="User profile picture">
							<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
							<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Joining Date : </b><span id="joining_date"> {{$joining_date}}</span>
								</li>
								<li class="list-group-item">
									<b>Working Station : </b><span id="branch_name"> {{$branch_name}} </span>
								</li>
							</ul>
							<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>

				<div class="box-footer">

				</div>
				<!-- /.box-footer -->
				
			</form>

		</div>
	</section>
		
	<script>
	
		$(document).ready(function() {
			var button_text = document.getElementById("submit").innerHTML;
			if(button_text == 'Save')
			{
				$('#emp_id').removeAttr('disabled');
				$('#submit').attr("disabled", true);
			}
			else
			{
				$('#emp_id').attr("disabled", true);
				$('#submit').removeAttr('disabled');
			}
			document.getElementById("designation_code").value = '{{$designation_code}}';
			document.getElementById("br_code").value = '{{$br_code}}';
			document.getElementById("grade_code").value = '{{$grade_code}}';
			document.getElementById("grade_step").value = '{{$grade_step}}';
			document.getElementById("department_code").value = '{{$department_code}}';
			document.getElementById("designation_name").innerHTML = '{{$designation_name}}';
			document.getElementById("branch_name").innerHTML = '{{$branch_name}}';
			document.getElementById("status").value = '{{$status}}';
		})
		
		function get_employee_info()
		{
			var emp_id = document.getElementById("emp_id").value;
			var letter_date = document.getElementById("letter_date").value;
			
			$.ajax({
				url : "{{ url::to('get-employee-info') }}"+"/"+ emp_id +"/"+ letter_date,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					if(data.emp_name)
					{
						$('#employee_status').html('<b>Active Employee</b>');
						$('[name="emp_id"]').val(data.emp_id);
						$('#emp_name').html(data.emp_name);
						$('#joining_date').html(data.joining_date);
						$('#br_joined_date').val(data.joining_date);
						$('#designation_code').val(data.designation_code);
						$('#designation_name').html(data.designation_name);
						$('#department_code').val(data.department_code);
						$('#grade_code').val(data.grade_code);
						$('#grade_step').val(data.grade_step);
						$('#branch_name').html(data.branch_name);
						$('#br_code').val(data.br_code);
						$('#probation_time').val(data.probation_time);
						document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
						$('#submit').removeAttr('disabled');
						
					}
					else
					{
						$('#employee_status').html('<b>This Employee is not Available</b>');
						$('[name="emp_id"]').val(data.emp_id);
						$('#emp_name').html('');
						$('#joining_date').html('');
						$('#br_joined_date').val('');
						$('#designation_code').val('');
						$('#designation_name').html('');
						$('#branch_name').html('');
						$('#department_code').val('');
						$('#grade_code').val('');
						$('#grade_step').val('');
						$('#br_code').val('');
						$('#probation_time').val('');
						$('#submit').attr("disabled", true);
						document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
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