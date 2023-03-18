@extends('admin.admin_master')
@section('title', 'Contractual | Official Info')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">{{$Heading}}</li>
		</ol>
	</section>

	<!-- Main content -->
	
	<?php
	$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
	$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
	?>

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Official Information </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form name="employee_nonid" class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}

				<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}"> 
				<div class="box-body col-md-7">	
					
					<div class="form-group">
						<label for="emp_type" class="col-sm-3 control-label">Emp Type: <span style="color:red;">*</span></label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php echo $type_name; ?></span>
						</div>
						
						<label for="sacmo_id" class="col-sm-3 control-label">Employee ID <span style="color:red;">*</span></label>
						<div class="col-sm-3"> 
							<span class="form-control"> <?php  echo  $sacmo_id;  ?></span>
						</div>
						
					</div>
					<div class="form-group">
						<!--<label class="control-label col-md-3">Designation: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<select class="form-control" name="designation_code" id="designation_code" required>
								<option value="" hidden>Select</option>
								@foreach ($designation as $v_designation)
									<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3">Joining Branch: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<select name="br_code" id="br_code" required class="form-control">
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>-->
					</div>  
					<div class="form-group">
					 <label class="control-label col-md-3">Contract Renew Date: <span style="color:red;">*</span> </label>
						<div class="col-md-3"> 
							<span class="form-control"> <?php echo date("d-m-Y",strtotime($next_renew_date));?></span>
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3" id="c_end_date_lebel">Contract Ending Date:  </label>
						<div class="col-md-3">
								<span class="form-control"> @if($c_end_date) {{date("d-m-Y",strtotime($c_end_date))}} @endif </span> 
							<span class="help-block">Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_contract_end_type()" name="end_type" id="end_type" value="{{$end_type}}" <?php if($end_type == 0){ ?> checked <?php }  ?>></span>
						</div>
						<!--<label class="control-label col-md-3">Salary Branch: <span style="color:red;">*</span></label>
						<div class="col-md-3">
							<select name="salary_br_code" id="salary_br_code" required class="form-control">
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select>
						</div>
					<label class="control-label col-md-3">Branch ( After Training): </label>
						<div class="col-md-3"> 
							<span class="help-block"></span>
							<select name="after_trai_br_code" id="after_trai_br_code"  class="form-control">
								<option value="">-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select> 	
						</div>-->
					</div> 
					<hr> 
				</div>
				<div class="col-md-5">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
							<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date">  @if($joining_date) {{date("d-m-Y",strtotime($joining_date))}} @endif</span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name"> {{$branch_name}} </span>
								</li>
							</ul>
							<a href="#" <?php if($cancel_date == ''){  ?> class="btn btn-primary btn-block"; <?php }else { ?> class="btn btn-danger btn-block" <?php }?>  id="employee_status"><b><?php if($cancel_date == ''){ echo "Active Employee"; }else { echo "This Employee Terminated"; }?></b></a>
						</div> 
						<!-- /.box-body --> 	
						<div>
							<center>
								<button type="button" class="btn btn-warning" id="all" onclick="get_salary();">Show Contractual Official History</button>
							</center>
							<br>
							<div>
							<table class="table table-bordered table-striped" id="transfer_history" border="1">
								
							</table>
							</div>
						</div>	
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
			</form>

		</div>
	</section> 
	<script>
	
		function get_salary()
		{
			var emp_id = document.getElementById("emp_id").value; 
			//alert(emp_id);
			$.ajax({
				url : "{{ url::to('get_nonid_official_info') }}"+"/"+ emp_id,
				type: "GET",
				success: function(data)
				{
					//alert(data);
					//$("#upazila_id").attr("disabled", false);
					$("#transfer_history").html(data); 
					//$("#upazi_name").html(data); 
				}
			}); 
		}
	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupContractual").addClass('active');
			$("#Official_info").addClass('active');
		});
	</script>
@endsection