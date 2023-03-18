@extends('admin.admin_master')
@section('title', 'Held Up')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
</style>
<section class="content-header">
	<h1>add-heldup</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">add-heldup</li>
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
							<label for="emp_id" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
							<div class="col-sm-3 {{ $errors->has('emp_id') ? ' has-error' : '' }}">
								<input type="number" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}" onChange="get_employee_info();" required>
								@if ($errors->has('emp_id'))
									<span class="help-block">
										<strong>{{ $errors->first('emp_id') }}</strong>
									</span>
								@endif
							</div>
							<label for="letter_date" class="col-sm-2 control-label">Letter Date <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="letter_date" name="letter_date" value="{{$letter_date}}" required>							
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="br_code" class="col-sm-2 control-label">Branch <span class="required">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="br_code" name="br_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($branches as $v_branches)
									<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
									@endforeach
								</select>
							</div>
							<label for="designation_code" class="col-sm-2 control-label">Designation <span class="required">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="designation_code" name="designation_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($designation as $v_designation)
									<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="what_heldup" class="col-sm-2 control-label">What HeldUp <span class="required">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="what_heldup" name="what_heldup" onchange="myFunction()" required>						
									<option value="">-Select-</option>
									<option value="Permanent" <?php if($what_heldup=="Permanent") echo 'selected="selected"'; ?> >Permanent</option>
									<option value="Increment" <?php if($what_heldup=="Increment") echo 'selected="selected"'; ?> >Increment</option>
									<option value="Promotion" <?php if($what_heldup=="Promotion") echo 'selected="selected"'; ?> >Promotion</option>
								</select>
							</div>
							<label for="heldup_time" class="col-sm-2 control-label">HeldUp Time <span class="required">*</span></label>
							<div class="col-sm-3">
								<select class="form-control" id="heldup_time" name="heldup_time" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($heldup_time=="1") echo 'selected="selected"'; ?> >1 Month</option>
									<option value="2" <?php if($heldup_time=="2") echo 'selected="selected"'; ?> >2 Months</option>
									<option value="3" <?php if($heldup_time=="3") echo 'selected="selected"'; ?> >3 Months</option>
									<option value="6" <?php if($heldup_time=="6") echo 'selected="selected"'; ?> >6 Months</option>
									<option value="12" <?php if($heldup_time=="12") echo 'selected="selected"'; ?> >12 Months</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div id="heldupuntildate">
							<label for="heldup_until_date" class="col-sm-2 control-label">HeldUp Until Date <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="start_date" name="heldup_until_date" value="{{$heldup_until_date}}" >
							</div>
							</div>
							<div id="nextincrement_date" style="display: none;" >
							<label for="next_increment_date" class="col-sm-2 control-label">Next Increment Date <span class="required">*</span></label>
							<div class="col-sm-3">
								<input type="text" class="form-control form_date" id="next_increment_date" name="next_increment_date" value="{{$next_increment_date}}" >
							</div>
							</div>
							<label for="heldup_cause" class="col-sm-2 control-label">Cause of HeldUp <span class="required">*</span></label>
							<div class="col-sm-3">
								<textarea name="heldup_cause" class="form-control">{{$heldup_cause}}</textarea>
							</div>
						</div>
												
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/heldup')}}" class="btn bg-olive" >List</a>
						<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/'.$emp_photo)}}" alt="User profile picture">
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
	$('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#letter_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.form_date').datepicker({dateFormat: 'yy-mm-dd'});
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
		
		document.getElementById("designation_code").value = '{{$designation_code}}';
		document.getElementById("br_code").value="{{$br_code}}";
		document.getElementById("branch_name").innerHTML = '{{$branch_name}}';
		var aa = $('#what_heldup').val();
		if (aa == "Increment") {
			$("#nextincrement_date").show();
			$("#heldupuntildate").hide();
			document.getElementById("heldup_until_date").value='';
		} else {
			$("#heldupuntildate").show();
			$("#nextincrement_date").hide();			
			document.getElementById("next_increment_date").value='';
		}
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
				if(data.emp_name) {
					$('#employee_status').html('<b>Active Employee</b>');
					$('[name="emp_id"]').val(data.emp_id);
					$('#emp_name').html(data.emp_name);
					$('#joining_date').html(data.joining_date);
					$('#br_join_date').val(data.joining_date);
					$('#designation_code').val(data.designation_code);
					$('#designation_name').html(data.designation_name);
					$('#branch_name').html(data.branch_name);
					$('#br_code').val(data.br_code);
					document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
					$('#submit').removeAttr('disabled');
						
				} else {					
					$('#employee_status').html('<b>This Employee is not Available</b>');
					$('[name="emp_id"]').val(data.emp_id);
					$('#emp_name').html('');
					$('#joining_date').html('');
					$('#br_join_date').val('');
					$('#designation_code').val('');
					$('#designation_name').html('');
					$('#branch_name').html('');
					$('#br_code').val('');
					$('#submit').attr("disabled", true);
					//document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
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
	
	function myFunction() { 
		var whatheldup = document.getElementById("what_heldup").value;

		if (whatheldup == "Increment") {
			$("#nextincrement_date").show();
			$("#heldupuntildate").hide();
			$('#next_increment_date').attr('required', 'required');
			$('#heldup_until_date').removeAttr("required");
			document.getElementById("heldup_until_date").value='';
		} else {
			$("#nextincrement_date").hide();
			$("#heldupuntildate").show();
			$('#next_increment_date').removeAttr("required");
			$('#heldup_until_date').attr('required', 'required');
			document.getElementById("next_increment_date").value='';
		}
		
	}
	
</script>
	<script>
		//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Held_up").addClass('active');
		});
	</script>
@endsection