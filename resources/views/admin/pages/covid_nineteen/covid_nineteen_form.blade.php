@extends('admin.admin_master')
@section('title', 'Covid-Nineteen')
@section('main_content')
<style>
.content {
	padding-top: 5px;
}
.required {
    color: red;
    font-size: 14px;
}
.col-sm-2, .col-sm-1 {
	padding-left: 6px;
}
</style>
<br/>
<br/>
<section class="content-header">
	<h1><small>Covid-19 Info</small></h1>
</section>
<section class="content">	
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" >
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label class="col-sm-2 control-label">Employee Type <span class="required">*</span></label>
						<div class="col-sm-2">
							<select name="emp_type" id="emp_type" onChange="get_employee_info();" required class="form-control">
								@foreach ($all_emp_type as $emp_type1)
								<option value="{{$emp_type1->id}}">{{$emp_type1->type_name}}</option>
								@endforeach
							</select>
						</div>
						<label class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="emp_id" value="{{$emp_id}}" id="emp_id" onChange="get_employee_info();" required>
						</div>
						<label class="col-sm-2 control-label">Effect Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" name="entry_date" class="form-control entry_date" value="{{$entry_date}}" required>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="emp_name" value="{{$emp_name}}" readonly >							
						</div>
						<label class="col-sm-2 control-label">Designation <span class="required">*</span></label>
						<div class="col-sm-2">
							<select class="form-control" name="designation_code" id="designation_code" style="pointer-events:none;" readonly >						
								<option value="" >-Select-</option>
								@foreach ($all_designation as $designation)
								<option value="{{$designation->designation_code}}">{{$designation->designation_name}}</option>
								@endforeach
							</select>
						</div>
						<label class="col-sm-2 control-label">Branch <span class="required">*</span></label>
						<div class="col-sm-2">
							<select class="form-control" name="br_code" id="br_code" style="pointer-events:none;" readonly >						
								<option value="" >-Select-</option>
								@foreach ($all_branch as $branch)
								<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-sm-2 control-label">Comments <span class="required">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="comments" name="comments" value="{{$comments}}" >							
						</div>
					</div>						
				</div>
				<div class="box-footer">
					<a href="{{URL::to('/covid-nineteen')}}" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" >{{$button_text}}</button>
				</div>
			</div>
			</form>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.entry_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	document.getElementById("designation_code").value="{{$designation_code}}";
	document.getElementById("br_code").value="{{$br_code}}";
	document.getElementById("emp_type").value="{{$emp_type}}";
	
});
</script>
<script type="text/javascript">		
	function get_employee_info() {
		var emp_id = $("#emp_id").val();	
		var emp_type = $("#emp_type").val();	
		//alert (emp_id);
		$.ajax({
			url : "{{ url::to('get-emp-info') }}"+"/"+ emp_id +"/"+ emp_type,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
				} else {
					//document.getElementById("emp_id").value=data.emp_id;
					document.getElementById("emp_name").value=data.emp_name;
					document.getElementById("br_code").value=data.br_code;
					document.getElementById("designation_code").value=data.designation_code;
					//document.getElementById("emp_type").value=emp_type;
				}
				//alert (data.br_code);		
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
			$("#MainGroupOthers").addClass('active');
			$("#Covid-19").addClass('active');
		});
	</script>
@endsection