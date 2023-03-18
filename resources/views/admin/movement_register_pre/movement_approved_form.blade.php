@extends('admin.admin_master')
@section('title', 'Movement Approved')
@section('main_content')
 <link rel="stylesheet" href="{{asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')}}">
<style>
		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			background-color: #3c8dbc;
			border-color: #367fa9;
			padding: 1px 10px;
			color: #fff;
}
</style>	 
 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Movement<small>Register</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Movement</a></li>
			<li class="active">Register</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			
			<!-- /.box-header -->
			<!-- form start -->
			<div class="col-md-8">
				<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}  
				<input type="hidden" name="move_id"  value="{{$move_id}}"  class="form-control readonly"> 
				  
				<FIELDSET>  
					<LEGEND class="col-md-9" style="padding-left:0px;"><b>Movement Information</b></LEGEND>
						<div class="box-body">  
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Destination</label>
											<div class="col-md-6">
												 <select  name="destination_code[]" multiple="multiple"   id="destination_code" class="form-control  select2" required> 
													@foreach($branch_list as $branch)
														<option value="{{$branch->br_code}}" <?php if(in_array($branch->br_code, $destination_code)){ echo "selected";}?>>{{$branch->branch_name}}</option> 
													@endforeach 
													
												</select>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Purpose </label>
											<div class="col-md-6">
												 <input type="text" name="purpose" id="purpose" class="form-control" value="{{$purpose}}" readonly required >
											</div> 
									</div> 
								</div>
							</div>
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">From Date</label>
											<div class="col-md-6">
												<input type="text" name="from_date" id="from_date"  class="form-control common_date" value="{{$from_date}}" required readonly>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave Time </label>
											<div class="col-md-6">
												 <input type="time" name="leave_time" id="leave_time" class="form-control" value="{{$leave_time}}" required readonly>
											</div> 
									</div> 
								</div>  
							</div>
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">To Date</label>
											<div class="col-md-6">
												<input type="text" onchange="settotalday()" name="to_date" id="to_date"  class="form-control common_date" value="{{$to_date}}" required>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Day/s </label>
											<div class="col-md-6">
												<input type="text" name="tot_day" id="tot_day"  class="form-control" value="{{$tot_day}}" required> 
												<span class="help-block" id="error1"></span>
											</div> 
									</div> 
								</div>  
							</div>
							
							
							@if(!empty($arrival_date))
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Arrival Date</label>
											<div class="col-md-6">
												<input type="text" name="arrival_date" id="arrival_date"  class="form-control common_date" value="{{$arrival_date}}" readonly>
											</div> 
									</div> 
								</div> 
								<div class="col-md-6">
									<div class="form-group"> 
										<label class="control-label col-md-4">Arrival Time </label>
											<div class="col-md-6">
												 <input type="time" name="arrival_time" id="arrival_time" class="form-control" value="{{$arrival_time}}" readonly>
											</div> 
									</div> 
								</div>  
							</div>
							@endif
							<br>
							<div class="row">  
								<div class="col-md-6 col-md-offset-5">
									<div class="form-group"> 
											<div class="col-md-10">
												<div class="pull-right">
													<button type="submit" class="btn btn-primary">Approved</button> 
													<a href="{{URL::to('movement_reject/2/'.$move_id)}}" class="btn btn-danger" >&nbsp;&nbsp;Reject&nbsp;&nbsp;</a>
													<a href="{{URL::to('movement_approved')}}" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
												</div> 
											</div> 
									</div> 
								</div>
							</div>  
						</div> 
				</FIELDSET>  
			</form>
		</div>
			<div class="col-md-4">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="{{asset('public/employee/'.$emp_image)}}" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
							<p class="text-muted text-center" id="designation_name">{{$designation_name.', ID '.$emp_id}}</p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date">{{$org_join_date}} </span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name">{{$branch_name}} </span>
								</li>
							</ul>
							<a href="#" <?php if(!empty($cancel_date)){echo "class='btn btn-danger btn-block'";}else{echo "class='btn btn-primary btn-block'";}?>   id="employee_status"><b><?php if(!empty($cancel_date)){echo "cancel";}else{echo "Running";}?></b></a>
						</div>
					</div>
					<!-- /.box -->
				</div>
	</div>
	</div>
</section> 
<script src="{{asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$('.select2').select2();

function settotalday(){  
	 var from_date         		=$('#from_date').datepicker('getDate');
	 var to_date          		=$('#to_date').datepicker('getDate');
		 if (from_date <= to_date) {
			  var day   = (to_date - from_date)/1000/60/60/24;
			  var days =day+1;  
			  $('#tot_day').val(days);
			  $('#error1').html("");
		 }else{
			 $('#error1').html("<b style='color:red;font-size:12px;'>From date must be less or equal!</b>");
			  $('#to_date').val(""); 	
		 }
}
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
}); 
</script>

		<script>
			//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupTravel").addClass('active');
				$("#Approved_Movement").addClass('active');
			});
		</script>
@endsection