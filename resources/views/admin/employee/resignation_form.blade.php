@extends('admin.admin_master')
@section('title', 'Resignation')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
<?php 
	
	$session_branch_code 	   = Session::get('branch_code');
?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Resignation</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> {{$Heading}}</h3>
			</div>			
			<!-- /.box-header -->
			<!-- form start -->
			<form id="form" class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
				{{ csrf_field() }}	
				{!!$method_control!!}					
				<input type="hidden" id="session_branch_code" value="{{$session_branch_code}}">
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
						<label class="col-sm-2 control-label">Letter Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="letter_date" name="letter_date" value="{{$letter_date}}" onChange="get_employee_info();" required>
							
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Effect Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="effect_date" <?php if($session_branch_code != 9999){   if($id == '' ){ ?> min="<?php echo date("Y-m-01");?>" <?php }   }  ?> name="effect_date" value="{{$effect_date}}" required>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Resigned By <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="resignation_by" name="resignation_by" required>						
								<option value="Self">Self</option>
								<option value="Ogranization">Ogranization</option>
								<option value="Termination">Termination</option>
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
			document.getElementById("designation_name").innerHTML = '{{$designation_name}}';
			document.getElementById("branch_name").innerHTML = '{{$branch_name}}';
			document.getElementById("resignation_by").value = '{{$resignation_by}}';
		})
		
		function get_employee_info()
		{
			var session_branch_code = document.getElementById("session_branch_code").value;
			var emp_id = document.getElementById("emp_id").value;
			var letter_date = document.getElementById("letter_date").value;
			$.ajax({
				url : "{{ url::to('get-employee-info') }}"+"/"+ emp_id +"/"+ letter_date,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
					if(session_branch_code != 9999){ 
						if(data.emp_name)
							{
								if(session_branch_code == data.br_code)
								{
									if(data.designation_code == 74 || data.designation_code == 242){
										if(data.resign_date < letter_date)
										{
											$('#employee_status').html('<b>This Employee Terminated</b>');
											$("#employee_status").removeClass("btn btn-primary btn-block");
											$("#employee_status").addClass("btn btn-danger btn-block");
											$('#submit').attr("disabled", true);
										}
										else
										{
											$('#employee_status').html('<b>Active Employee</b>');
											$("#employee_status").removeClass("btn btn-danger btn-block");
											$("#employee_status").addClass("btn btn-primary btn-block");
											$('#submit').removeAttr('disabled');
										}
										$('[name="emp_id"]').val(data.emp_id);
										$('#emp_name').html(data.emp_name);
										$('#joining_date').html(data.joining_date);
										$('#br_joined_date').val(data.joining_date);
										$('#designation_code').val(data.designation_code);
										$('#designation_name').html(data.designation_name);
										$('#branch_name').html(data.branch_name);
										$('#br_code').val(data.br_code);
										$('#department_code').val(data.department_code);
										$('#report_to').val(data.report_to);
										$('#probation_time').val(data.probation_time);
										$('#grade_code').val(data.grade_code);
										$('#grade_step').val(data.grade_step);
										document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
									}else{
										$('#form').trigger("reset");
										$('[name="emp_id"]').val(data.emp_id);
										document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
										$('#emp_name').html('');
										$('#joining_date').html('');
										$('#branch_name').html('');
										$('#designation_name').html(data.designation_name);
										$('#employee_status').html('<b>Accesss Denied</b>');
										$("#employee_status").removeClass("btn btn-primary btn-block");
										$("#employee_status").addClass("btn btn-danger btn-block");
										$('#submit').attr("disabled", true);
									}
								}else{
									$('#form').trigger("reset");
									$('[name="emp_id"]').val(data.emp_id);
									document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
									$('#emp_name').html('');
									$('#joining_date').html('');
									$('#branch_name').html('');
									$('#designation_name').html(data.designation_name);
									$('#employee_status').html('<b>Accesss Denied</b>');
									$("#employee_status").removeClass("btn btn-primary btn-block");
									$("#employee_status").addClass("btn btn-danger btn-block");
									$('#submit').attr("disabled", true);
									alert(' This Employee is not in this Branch');
								} 
									
							}
							else
							{
								$('#form').trigger("reset");
								$('[name="emp_id"]').val(data.emp_id);
								document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
								$('#emp_name').html('');
								$('#joining_date').html('');
								$('#branch_name').html('');
								$('#designation_name').html(data.designation_name);
								$('#employee_status').html('<b>Employee is not Available</b>');
								$("#employee_status").removeClass("btn btn-primary btn-block");
								$("#employee_status").addClass("btn btn-danger btn-block");
								$('#submit').attr("disabled", true);
							}
					}else{
						 if(data.emp_name)
							{
								if(data.resign_date < letter_date)
								{
									$('#employee_status').html('<b>This Employee Terminated</b>');
									$("#employee_status").removeClass("btn btn-primary btn-block");
									$("#employee_status").addClass("btn btn-danger btn-block");
									$('#submit').attr("disabled", true);
								}
								else
								{
									$('#employee_status').html('<b>Active Employee</b>');
									$("#employee_status").removeClass("btn btn-danger btn-block");
									$("#employee_status").addClass("btn btn-primary btn-block");
									$('#submit').removeAttr('disabled');
								}
								$('[name="emp_id"]').val(data.emp_id);
								$('#emp_name').html(data.emp_name);
								$('#joining_date').html(data.joining_date);
								$('#br_joined_date').val(data.joining_date);
								$('#designation_code').val(data.designation_code);
								$('#designation_name').html(data.designation_name);
								$('#branch_name').html(data.branch_name);
								$('#br_code').val(data.br_code);
								$('#department_code').val(data.department_code);
								$('#report_to').val(data.report_to);
								$('#probation_time').val(data.probation_time);
								$('#grade_code').val(data.grade_code);
								$('#grade_step').val(data.grade_step);
								document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
									
							}
							else
							{
								$('#form').trigger("reset");
								$('[name="emp_id"]').val(data.emp_id);
								document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
								$('#emp_name').html('');
								$('#joining_date').html('');
								$('#branch_name').html('');
								$('#designation_name').html(data.designation_name);
								$('#employee_status').html('<b>Employee is not Available</b>');
								$("#employee_status").removeClass("btn btn-primary btn-block");
								$("#employee_status").addClass("btn btn-danger btn-block");
								$('#submit').attr("disabled", true);
							} 
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#employee_status').html('This Employee is not Available');
					$('#submit').attr("disabled", true);
				}
			});
		}

	</script>
	<script>
		//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Resignation").addClass('active');
		});
	</script>
@endsection