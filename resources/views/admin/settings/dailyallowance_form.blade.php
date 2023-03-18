@extends('admin.admin_master')
@section('title', 'Add Daily Allowance')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
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
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}
				
				<input type="hidden" id="id" name="id" value="{{$id}}" >
				
				<div class="box-body">
					<div class="form-group">
						<label for="org_full_name" class="col-sm-2 control-label">Grade</label>
						<div class="col-sm-4">
							<select  name="grade_code" id="grade_code" required class="form-control"> 
								<option value="">--Select--</option>
								@foreach($grade_list as $grade)
									<option value="{{$grade->grade_code}}">{{$grade->grade_name}}</option> 
								@endforeach
							</select> 
						</div>
					</div> 
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Breakfast</label>
						<div class="col-sm-4">
							<input type="text" name="breakfast" id="breakfast" class="form-control" value="{{$breakfast}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Lunch</label>
						<div class="col-sm-4">
							<input type="text" name="lunch" id="lunch"  class="form-control" value="{{$lunch}}" required >
						</div>
					</div>
					 <div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">dinner</label>
						<div class="col-sm-4">
							<input type="text" name="dinner" id="dinner"  class="form-control" value="{{$dinner}}" required >
						</div>
					</div>
					 <div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">From</label>
						<div class="col-sm-4">
							<input type="text" name="from_date"  id="from_date"  class="form-control common_date" value="{{$from_date}}" required >
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">To</label>
						<div class="col-sm-4">
							<input type="text" name="to_date"  id="to_date"  class="form-control common_date" value="{{$to_date}}" required >
						</div>
					</div>
					<div class="form-group">
						<label for="org_status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select name="status" id="status" class="form-control" required>							
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
					</div>
					
				</div>
				<!-- /.box-body -->
				<div class="box-footer"> 
					<button type="submit" class="btn btn-info">{{$button_text}}</button>
				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</section>
	
	<script>
		document.getElementById("status").value = '{{$status}}'; 
		document.getElementById("grade_code").value = '{{$grade_code}}';  
	$(document).ready(function() {
			$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
		}); 
			
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Daily_Allowance').addClass('active');
			});
	</script>

@endsection