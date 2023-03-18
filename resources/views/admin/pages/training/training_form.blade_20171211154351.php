@extends('admin.admin_master')
@section('main_content')
<section class="content-header">
  <h4>add-training</h4>
  <ol class="breadcrumb">
	<li><a href="#"><i class="icon-home"></i> Home</a></li>
	<li class="active">add-training</li>
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
							<label for="tr_date_from" class="col-sm-2 control-label">Training Date From</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="start_date" name="tr_date_from" value="{{$tr_date_from}}" required>
							</div>
							<label for="tr_date_to" class="col-sm-2 control-label">Training Date To</label><span class="required">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="form_date" name="tr_date_to" value="{{$tr_date_to}}" required>
							</div>						
						</div>
						<div class="form-group">						
							<label for="tr_venue" class="col-sm-2 control-label">Training Venue</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="tr_venue" name="tr_venue" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($tr_venue=="1") echo 'selected="selected"'; ?> >HO</option>
									<option value="2" <?php if($tr_venue=="2") echo 'selected="selected"'; ?> >Branch</option>
									<option value="3" <?php if($tr_venue=="3") echo 'selected="selected"'; ?> >Other</option>
								</select>
							</div>
							<label for="tr_result" class="col-sm-2 control-label">Result</label><span class="required">*</span>
							<div class="col-sm-3">
								<select class="form-control" id="tr_result" name="tr_result" required>						
									<option value="">-Select-</option>
									<option value="1" <?php if($tr_result=="1") echo 'selected="selected"'; ?> >A+</option>
									<option value="2" <?php if($tr_result=="2") echo 'selected="selected"'; ?> >A</option>
									<option value="3" <?php if($tr_result=="3") echo 'selected="selected"'; ?> >A-</option>
									<option value="4" <?php if($tr_result=="4") echo 'selected="selected"'; ?> >B+</option>
									<option value="5" <?php if($tr_result=="5") echo 'selected="selected"'; ?> >B</option>
									<option value="6" <?php if($tr_result=="6") echo 'selected="selected"'; ?> >B-</option>
									<option value="7" <?php if($tr_result=="7") echo 'selected="selected"'; ?> >C</option>
									<option value="8" <?php if($tr_result=="8") echo 'selected="selected"'; ?> >D</option>
									<option value="9" <?php if($tr_result=="9") echo 'selected="selected"'; ?> >F</option>
									<option value="10" <?php if($tr_result=="10") echo 'selected="selected"'; ?> >N/A</option>
								</select>
							</div>						
						</div>
						<div class="form-group" style="display:none;" id="other">						
							<label for="tr_venue_other" class="col-sm-2 control-label">Training Venue (Other)</label><span class="require">*</span>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="tr_venue_other" name="tr_venue_other" value="{{$tr_venue_other}}" >
							</div>						
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="{{URL::to('/training')}}" class="btn bg-olive" >List</a>
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
$(document).ready(function(){
	var aa = $('#tr_venue').val();	
	if (aa == '3') {
		$("#other").show();
	} else {
		$("#other").hide();
		document.getElementById("tr_venue_other").value='';
	}
    $('#tr_venue').on('change', function() {
      if (this.value == '3') {
		$("#other").show();
      } else {
		$("#other").hide();
		document.getElementById("tr_venue_other").value='';
      }
    });
});
</script>
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
		document.getElementById("designation_code").value="{{$designation_code}}";
		document.getElementById("branch_name").innerHTML = '{{$branch_name}}';
	})
	
	function get_employee_info()
	{
		var emp_id = document.getElementById("emp_id").value;
		
		$.ajax({
			url : "{{ url::to('get-employee-info-training') }}"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.emp_name) {
					$('#employee_status').html('<b>Active Employee</b>');
					$('#emp_name').html(data.emp_name);
					$('#joining_date').html(data.joining_date);
					$('#designation_name').html(data.designation_name);
					$('#branch_name').html(data.branch_name);
					document.getElementById("emp_photo").src = "{{asset('public/employee/1505034887.jpg')}}";
					$('#submit').removeAttr('disabled');					
				} else {
					$('#employee_status').html('<b>This Employee is not Available</b>');
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