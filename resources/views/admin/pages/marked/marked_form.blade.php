@extends('admin.admin_master')
@section('main_content')
<section class="content-header">
  <h4>add-marked</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-marked</li>
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
							<label for="open_date" class="col-sm-2 control-label">Open Date</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="form_date" name="open_date" value="{{$open_date}}" required>							
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="br_code" class="col-sm-2 control-label">Branch</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="br_code" name="br_code" required>						
									<option value="" hidden>-Select-</option>
									@foreach ($branches as $v_branches)
									<option value="{{$v_branches->br_code}}">{{$v_branches->br_name}}</option>
									@endforeach
								</select>
							</div>
							<label for="designation_code" class="col-sm-2 control-label">Designation</label><span class="required">*</span>
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
							<label for="marked_for" class="col-sm-2 control-label">Marked for</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="marked_for" name="marked_for" required>						
									<option value="">-Select-</option>
									<option value="Permanent" <?php if($marked_for=="Permanent") echo 'selected="selected"'; ?> >Permanent</option>
									<option value="Increment" <?php if($marked_for=="Increment") echo 'selected="selected"'; ?> >Increment</option>
									<option value="Promotion" <?php if($marked_for=="Promotion") echo 'selected="selected"'; ?> >Promotion</option>
								</select>
							</div>
							<label for="marked_details" class="col-sm-2 control-label">Marked Details</label><span class="required">*</span>
							<div class="col-sm-3">
								<textarea name="marked_details" class="form-control">{{$marked_details}}</textarea>
							</div>
						</div>
						@if($id)
						<hr>	
						<div class="form-group">
							<label for="close_date" class="col-sm-2 control-label">Marked Close Date</label><span class="required">*</span>
							<div class="col-sm-3 {{ $errors->has('emp_id') ? ' has-error' : '' }}">
								<input type="text" class="form-control" id="start_date" name="close_date" value="{{$close_date}}" >
							</div>
						</div>
						@endif
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/marked')}}" class="btn bg-olive" >List</a>
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
	$('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
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
	})
	
	function get_employee_info()
	{
		var emp_id = document.getElementById("emp_id").value;
		
		$.ajax({
			url : "{{ url::to('get-employee-info-heldup') }}"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.emp_name) {
					$('#employee_status').html('<b>Active Employee</b>');
					$('[name="emp_id"]').val(data.emp_id);
					$('#emp_name').html(data.emp_name);
					$('#joining_date').html(data.joining_date);
					$('#designation_name').html(data.designation_name);
					$('#branch_name').html(data.branch_name);
					document.getElementById("emp_photo").src = "{{asset('public/employee/1505034887.jpg')}}";
					$('#submit').removeAttr('disabled');					
				} else {
					$('#employee_status').html('<b>This Employee is not Available</b>');
					$('[name="emp_id"]').val(data.emp_id);
					$('#emp_name').html('');
					$('#joining_date').html('');
					$('#designation_name').html('');
					$('#branch_name').html('');
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