@extends('admin.admin_master')
@section('title', 'Marked Assign')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
</style>
<section class="content-header">
	<h1>mark-assign</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">mark-assign</li>
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
		<div class="col-md-12">
			<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label for="open_date" class="col-sm-2 control-label">Open Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="letter_date" name="open_date" value="{{$open_date}}" required>							
						</div>
						<label for="emp_id" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3 {{ $errors->has('emp_id') ? ' has-error' : '' }}">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}" onChange="get_employee_info(this.value);" required>
							@if ($errors->has('emp_id'))
								<span class="help-block">
									<strong>{{ $errors->first('emp_id') }}</strong>
								</span>
							@endif
						</div>							
					</div>
					<hr>
					<div class="form-group">
						<label for="br_code" class="col-sm-2 control-label">Branch <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="br_code" name="br_code" >						
								<option value="" >-Select-</option>
								@foreach ($all_branch as $branch)
								<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option>
								@endforeach
							</select>
						</div>
						<label for="emp_name" class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="emp_name" value="{{$emp_name}}" required>							
						</div>
					</div>
					<div class="form-group">
						<label for="designation_code" class="col-sm-2 control-label">Designation <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="designation_code" name="designation_code" required>						
								<option value="" >-Select-</option>
								@foreach ($all_designation as $designation)
								<option value="{{$designation->designation_code}}">{{$designation->designation_name}}</option>
								@endforeach
							</select>
						</div>						
						<label for="marked_for" class="col-sm-2 control-label">Marked for <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="marked_for" name="marked_for" required>						
								<option value="">-Select-</option>
								<option value="Permanent" <?php if($marked_for=="Permanent") echo 'selected'; ?> >Permanent</option>
								<option value="Increment" <?php if($marked_for=="Increment") echo 'selected'; ?> >Increment</option>
								<option value="Promotion" <?php if($marked_for=="Promotion") echo 'selected'; ?> >Promotion</option>
								<option value="Promotion_Increment" <?php if($marked_for=="Promotion_Increment") echo 'selected'; ?> >Promotion & Increment</option>
							</select>
						</div>
					</div>
					<div class="form-group">		
						<label for="marked_details" id="label_text" class="col-sm-2 control-label">Marked Details <span class="required">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="marked_details" name="marked_details" value="{{$marked_details}}" required>
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="{{URL::to('/mark-assign')}}" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
			<?php if(!empty($id)){ ?>
			<form class="form-horizontal" action="{{URL::to('/mark-assign-close')}}" method="post" >
			{{ csrf_field() }}
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">		
						<label for="close_date" id="label_text" class="col-sm-2 control-label"><span style="color:red;">Close Date</span> </label>
						<div class="col-sm-2">
							<input type="hidden" name="assign_id" value="<?php echo $id; ?>" />
							<input type="text" name="close_date" id="close_date" class="form-control" value="{{$close_date}}" />
						</div>
						<div class="col-sm-2">
							<button type="submit" id="submit" class="btn btn-primary">Closed</button>
						</div>
					</div>						
				</div>
			</div>
			</form>
			<?php } ?>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#letter_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#close_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	document.getElementById("designation_code").value="{{$designation_code}}";
	document.getElementById("br_code").value="{{$br_code}}";
	
});
//--></script>
<script type="text/javascript">
	
	function get_employee_info(emp_id) {
		//alert (emp_id);	
		$.ajax({
			url : "{{ url::to('get-employee-info-training') }}"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
				} else {
					document.getElementById("emp_name").value=data.emp_name;
					document.getElementById("br_code").value=data.br_code;
					document.getElementById("designation_code").value=data.designation_code;
				}
				//alert (data.designation_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});
	}
	
</script>
<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Marked_Assign").addClass('active');
	});
</script>
@endsection