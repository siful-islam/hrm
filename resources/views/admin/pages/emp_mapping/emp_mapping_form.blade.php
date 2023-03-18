@extends('admin.admin_master')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
.form-horizontal .control-label {
    text-align: left;
}
.form-group {
    margin-bottom: 4px;
}
h3 {
    margin-top: 1px;
    margin-bottom: 2px;
}
</style>
<section class="content-header">
	<h1>add-Mapping</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">add-Mapping</li>
	</ol>
</section>
<?php $user_type = Session::get('user_type');?>
<section class="content">	
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/emp_mapping')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email">Employee ID :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" value="{{$emp_id}}" required>
						</div>						
						<button type="submit" class="btn btn-primary" >Search</button>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if ($value_id == 1) { ?>
	@if (!empty($all_result))
	<div class="row">
		<div class="col-md-12">			
			<div class="col-md-5">
				<div class="box box-info">
					<div class="box-body">
						<h4><center><u>Existing Information</u></center></h4>
						<div class="form-group">
							<label for="emp_id" class="col-sm-6 control-label">Employee ID </label>
							<div class="col-sm-6">			
								<p class="form-control-static">: {{$all_result->emp_id}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Employee Name </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->emp_name_eng; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Mother Program </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php if($all_result->mother_program_id == 1) { echo 'Microfinance Program'; } else if($all_result->mother_program_id == 2) { echo 'Special Program'; }; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Current Program</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php if($all_result->current_program_id == 1) { echo 'Microfinance Program'; } else if($all_result->current_program_id == 2) { echo 'Special Program'; }; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Mother Department </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->department_name; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Current Department</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->current_department; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Unit</label>
							<div class="col-sm-6">
								<p class="form-control-static">: {{$all_result->unit_name}}</p>
							</div>
						</div>
					</div>          
				</div>
			</div>
			<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" onsubmit="return validateForm()" enctype="multipart/form-data">
				{{ csrf_field() }}
				{!! $method_field !!}
				<input type="hidden" name="emp_id" value="{{$emp_id}}">
				<input type="hidden" name="id" value="{{$id}}">
				
				<div class="col-md-7">
					<div class="box box-info">
						<div class="box-body">
							<h4><center><u>New Information</u></center></h4>
							<br>
							<div class="form-group">
								<label class="control-label col-md-4">Mother Program <span class="required">*</span></label>
								<div class="col-md-4">
									<select name="mother_program_id" id="mother_program_id" required class="form-control">
										<option value="">Select</option>
										<option value="1">Microfinance Program</option>
										<option value="2">Special Program</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Current Program <span class="required">*</span></label>
								<div class="col-md-4">
									<select name="current_program_id" id="current_program_id" required class="form-control">
										<option value="">Select</option>
										<option value="1">Microfinance Program</option>
										<option value="2">Special Program</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Mother Department <span class="required">*</span></label>
								<div class="col-md-4">
									<select name="mother_department_id" id="mother_department_id" required class="form-control">
										<option value="">Select</option>
										<option value="25">Microfinance</option>
										<option value="26">HR and Administration</option>
										<option value="27">Finance and Accounts</option>
										<option value="28">Audit and Monitoring</option>
										<option value="29">Digitisation</option>
										<option value="30">Special Program</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Current Department <span class="required">*</span></label>
								<div class="col-md-4">
									<select name="current_department_id" id="current_department_id" class="form-control">
										<option value="">Select</option>
										<option value="25">Microfinance</option>
										<option value="26">HR and Administration</option>
										<option value="27">Finance and Accounts</option>
										<option value="28">Audit and Monitoring</option>
										<option value="29">Digitisation</option>
										<option value="30">Special Program</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Unit</label>									
								<div class="col-sm-4">
									<select name="unit_id" id="unit_id" class="form-control">
										<option value="">Select</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Effect Date <span class="required">*</span></label>
								<div class="col-sm-4">
									 <input type="date" name="start_date" id="start_date" class="form-control" required value="">
								</div>
							</div>
						</div>
						<div class="box-footer">
							<a href="{{URL::to('/emp-mapping')}}" class="btn bg-olive" >List</a>
							<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
						</div>
					</div>
				</div>
			</form>
		</div>					
	</div>
	@endif
	<?php } else if ($value_id == 2) { ?>
	<div class="box-body" style="text-align:center;color:red;"> 
		<p><b>Employee ID is not Available</b></p>
	</div>
	<?php } ?>
</section>
<script>
	$(document).on("change", "#current_department_id", function () {
		var current_department_id = $(this).val();   
		//alert(current_department_id);
		 
		$.ajax({
			url : "{{ url::to('select-unit') }}"+"/"+current_department_id,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#unit_id").html(data);
				 
			}
		});  
	}); 
</script>
@endsection