@extends('admin.admin_master')
@section('title', 'Add Movement')
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
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} 
                {!!$method_control!!} 
				<FIELDSET>  
					<LEGEND class="col-md-9 col-md-offset-1" style="padding-left:0px;"><b>Movement Information</b></LEGEND>
						<div class="box-body">  
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Visit Type</label>
											<div class="col-md-6">
												 <select  onchange="change_visit_type();" name="visit_type" id="visit_type" class="form-control" required>  
														<option value="1">Branch</option>  
														<option value="2">Local</option>  
												</select>
											</div> 
									</div> 
								</div>  
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Purpose </label>
											<div class="col-md-6">
												 <input type="text" name="purpose" id="purpose" class="form-control" value="{{$purpose}}"  required>
											</div> 
									</div> 
								</div>
							</div>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Destination</label>
											<div class="col-md-6">
												<span id="branch_destination">
													<select  name="destination_code[]" multiple="multiple"   id="destination_code" class="form-control  select2" required> 
														@foreach($branch_list as $branch)
															<option value="{{$branch->br_code}}" <?php if(in_array($branch->br_code, $destination_code)){ echo "selected";}?>>{{$branch->branch_name}}</option> 
														@endforeach 
														
													</select>
												</span> 
											</div> 
									</div> 
								</div> 
								
							</div>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">From Date</label>
											<div class="col-md-6">
												<input type="text" name="from_date" id="from_date" autocomplete="off" class="form-control {{$common_date}}" onchange="settotaldayfrom()"   value="{{$from_date}}" required>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
								<div class="form-group"> 
										<label class="control-label col-md-4">To Date</label>
											<div class="col-md-6">
												<input type="text" name="to_date"  id="to_date" autocomplete="off" onchange="settotalday()"  class="form-control {{$common_date}}" value="{{$to_date}}" required>
											</div> 
									</div> 
									 
								</div>  
							</div>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Day/s </label> 
											<div class="col-md-6">
												<input type="text" name="tot_day" id="tot_day" readonly  class="form-control" value="{{$tot_day}}"  required> 
												<span class="help-block" id="error1"></span>
												
											</div>
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave Time </label>
											<div class="col-md-6">
												<input  type="time" id="leave_time" name="leave_time"  value="{{$leave_time}}" class="form-control" required>
												
											</div>
									</div>  
								</div>  
							</div>
							@if($approved == 1)
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Arrival Date</label>
											<div class="col-md-6">
												<input type="text" required name="arrival_date" id="arrival_date"  class="form-control common_date" value="{{$arrival_date}}">
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Arrival Time </label> 
											<div class="col-md-6">
												<input  type="time" required id="arrival_time" name="arrival_time"  value="{{$arrival_time}}" class="form-control" >
												
											</div>
									</div> 
								</div>  
							</div>
							@endif
							<div class="row">  
								<div class="col-md-5 col-md-offset-6">
									<div class="form-group"> 
										<label class="control-label col-md-4"></label>
											<div class="col-md-6">
												<button type="submit" class="btn btn-primary">{{$button}}</button>
												<a href="{{URL::to('movement/')}}" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
											</div> 
									</div> 
								</div>
							</div>  
						</div> 
				</FIELDSET>  
			</form>
		</div>
	</section> 
	
<script src="{{asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
 
 $('.select2').select2();

 function settotaldayfrom(){
	    $('#to_date').val(document.getElementById("from_date").value);
		settotalday();
 }  
/* $('.timepicker1').timepicker();  */
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
</script>
<script>
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});   
</script>
		<script>
			//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupTravel").addClass('active');
				$("#Add_Movement").addClass('active');
			});
		</script>
@endsection