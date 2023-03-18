@extends('admin.admin_master')
@section('title', 'Salary Adjustment')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Salary</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Payroll</a></li>
			<li><a href="#">Salary</a></li>
			<li class="active">Adjustment </li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">

		<div class="row">
			<div class="col-md-9">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<div class="box-header with-border">
							<h3 class="box-title"> Salary Adjustment</h3>
						</div>
						
						<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}">
							{{ csrf_field() }}	
							{!!$method_control!!}							
							
							<input type="hidden" id="id" name="id" value="{{$id}}">
							<input type="hidden" id="sarok_no" name="sarok_no" value="{{$sarok_no}}">							
							<input type="hidden" id="grade_step" name="grade_step" value="{{$grade_step}}">
							<input type="hidden" id="designation_code" name="designation_code" value="{{$designation_code}}">
							<input type="hidden" id="department_code" name="department_code" value="{{$department_code}}">
							<input type="hidden" id="br_code" name="br_code" value="{{$br_code}}">
							<input type="hidden" id="grade_code" name="grade_code" value="{{$grade_code}}">

							<div class="box-body col-md-12">
								
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
									<label for="zone_code" class="col-sm-2 control-label">Effect Date <span class="required">*</span></label>
									<div class="col-sm-3">
										<input type="date" class="form-control" id="letter_date" name="letter_date" value="{{$letter_date}}" onChange="get_employee_info();" required>
									</div>
								</div>

								<div class="form-group">
									<label for="zone_code" class="col-sm-2 control-label">Effect Date<span class="required">*</span></label>
									<div class="col-sm-3">
										<input type="date" class="form-control" id="effect_date" name="effect_date" value="{{$effect_date}}" required >
									</div>
								</div>
								<div class="form-group">
									<label for="zone_code" class="col-sm-2 control-label">Basic salary<span class="required">*</span></label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="basic_salary" name="basic_salary" value="{{$basic_salary}}" readonly >
									</div>
								</div>
								<div class="form-group">
									<label for="zone_code" class="col-sm-2 control-label">Adjustment Amount<span class="required">*</span></label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="adjustment_amount" name="adjustment_amount" value="{{$adjustment_amount}}" onkeyup="calculate();" required >
									</div>
								</div>
								<div class="form-group">
									<label for="zone_code" class="col-sm-2 control-label">New Basic Salary<span class="required">*</span></label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="new_basic_salary" name="new_basic_salary" value="{{$new_basic_salary}}" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="zone_code" class="col-sm-2 control-label">Adjustment Note<span class="required">*</span></label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="adjustment_note" name="adjustment_note" value="{{$adjustment_note}}" required >
									</div>
								</div>
							</div>	
							<div class="box-footer with-border">
								<button type="submit" id="submit" class="btn btn-danger">{{$button_text}}</button>
							</div>
							
						</form>			
					</div>
					<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- /.col -->			
			<div class="col-md-3">
				<div class="box box-primary">				
						<form action="{{URL::to('')}}" method="post">
							<div class="box-body box-profile">
								<center>
									<div class="image-upload">
										<label for="file-input">
											 <img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/default.png')}}" alt="User profile picture">
										</label> 
									</div> 
								</center>
								<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
								<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Joining Date : </b><span id="joining_date"> {{$joining_date}}</span>
									</li>
									<li class="list-group-item">
										<b>Working Station : </b><span id="branch_name"> {{$branch_name}} </span>
									</li>
									<li class="list-group-item">
										<b>Grade : </b><span id="grade_name">{{$grade_name}} </span>
									</li>
								</ul>
								<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>{{$emp_status}}</b></a>
							</div>
						</form>
						<!-- /.box-body -->
					</div>
			  <!-- /.box -->
			</div>		
			<!-- /.col -->
		</div>
		<!-- /.row -->

    </section>

	<script>
		function calculate()
		{
			var basic_salary 		= parseFloat(document.getElementById("basic_salary").value);
			var adjustment_amount 	= parseFloat(document.getElementById("adjustment_amount").value);
			var new_basic_salary 	= (basic_salary+adjustment_amount);
			document.getElementById("new_basic_salary").value = new_basic_salary;
		}
	</script>
	
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
			document.getElementById("report_to").value = '{{$report_to}}';
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
						$('#branch_name').html(data.branch_name);
						$('#br_code').val(data.br_code);
						$('#department_code').val(data.department_code);
						$('#report_to').val(data.report_to);
						$('#grade_code').val(data.grade_code);
						$('#grade_step').val(data.grade_step);
						$('#grade_name').html(data.grade_name);
						$('#basic_salary').val(data.basic_salary);
						$('#new_basic_salary').val(data.basic_salary);
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
						$('#br_code').val('');
						$('#department_code').val('');
						//$('#report_to').val('');
						$('#grade_code').val('');
						$('#grade_name').val('');
						$('#grade_step').val('');
						$('#basic_salary').val(0);
						$('#new_basic_salary').val(0);
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
	
	<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Salary_Adjustment").addClass('active');
		});
	</script>
	
@endsection