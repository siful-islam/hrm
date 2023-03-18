@extends('admin.admin_master')
@section('main_content') 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Contractual <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Contractual</a></li>
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
				<h3 class="box-title"> Personal Information </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form name="employee_nonid" class="form-horizontal" action="" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
				    {{ csrf_field() }}
					{!!$method_control!!} 
				<div class="form-group">
                    
					<label class="control-label col-md-2">Emp Type: <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
						<span class="form-control"> {{$type_name}}</span> 
                        <span class="help-block"></span>
                    </div> 
					<label class="control-label col-md-2">Employee Name : <span style="color:red;">*</span></label>
                    <div class="col-md-3"> 
						<span class="form-control"> {{$emp_name}}</span> 
                    </div>
			  </div>

				<div class="form-group">
					<label class="control-label col-md-2">Mother's Name : <span style="color:red;">*</span></label>
                    <div class="col-md-3">
                       <span class="form-control"> {{$mother_name}}</span> 
                    </div>
                               
					<label class="control-label col-md-2">Father's Name: <span style="color:red;">*</span></label>
                    <div class="col-md-3">
                        
                       <span class="form-control"> {{$father_name}}</span> 
                    </div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2">Birth Date :<span style="color:red;">*</span></label>
                    <div class="col-md-3">
                        <input type="hidden" name="birth_date" id="birth_date" value="{{$birth_date}}" class="form-control" required>
                       <span class="form-control"> {{$birth_date}}</span> 
                    </div>
                                
					<label class="control-label col-md-2">Present Age :</label>
                    <div class="col-md-3">
                     
                      <span class="form-control" id="present_age"></span> 
                    </div>
				 </div>
				<div class="form-group">	
					<label class="control-label col-md-2">Gender: <span style="color:red;">*</span></label>
						<div class="col-md-3"> 
							<span class="form-control"> {{$gender}}</span> 
						</div>
			   
                    <label class="control-label col-md-2">Nationality: </label>
                    <div class="col-md-3"> 
                       <span class="form-control"> {{$nationality}}</span> 
                    </div>
				</div>

				<div class="form-group">
					 
                    <label class="control-label col-md-2">National ID: </label>
                    <div class="col-md-3">
                        
                         <span class="form-control"> {{$national_id}}</span> 
                    </div>  
					<label class="control-label col-md-2">Birth Certificate: </label>
                    <div class="col-md-3">
                         
                          <span class="form-control"> {{$birth_certificate}}</span> 
                    </div>
				</div> 
				<div class="form-group">	
					<label class="control-label col-md-2">Religion : <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        
                          <span class="form-control"> {{$religion}}</span> 
                    </div> 
                    <label class="control-label col-md-2">Contact Number: <span style="color:red;">*</span> </label>
                    <div class="col-md-3"> 
                         <span class="form-control"> {{$contact_num}}</span> 
                    </div>
                </div> 
				<div class="form-group">
					<label class="control-label col-md-2">Present Address : </label>
                    <div class="col-md-3">
						<textarea class="form-control" name="present_add" id="present_add">{{$present_add}}</textarea>
                      
                    </div>
                    <label class="control-label col-md-2">Permanent Address : <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
						<textarea class="form-control" name="permanent_add" id="address" required>{{$permanent_add}}</textarea>
                       
                    </div> 
                </div>
				<div class="box-header with-border">
					<h3 class="box-title">Others Information</h3>
				</div>
				<br>
				<div class="form-group"> 
					<label class="control-label col-md-2">Branch Joining Date: <span style="color:red;">*</span> </label>
                    <div class="col-md-3"> 
                         <span class="form-control"> {{$joining_date}}</span> 
                    </div>
					<label class="control-label col-md-2">Consolidated Salary: <span style="color:red;">*</span></label>
						<div class="col-md-3"> 
						  <span class="form-control"> {{$console_salary}}</span> 
						</div>	
				</div> 
				<div class="box-footer"> 
					
				</div>
			</form>

		</div>
	</section>
<script language="javascript">
 age_calculation();
	 function age_calculation() { 
		var birth_date = document.getElementById("birth_date").value;
		
			$.ajax({
				url : "{{ URL::to('age_calculation') }}"+"/"+birth_date,
				type: "GET",
				success: function(data)
				{
					$("#present_age").html(data);  
				}
			});  

	 }
</script>
	<script>
		document.getElementById("br_code").value= "{{$br_code}}";
		document.getElementById("designation_code").value= "{{$designation_code}}";
	</script>

@endsection