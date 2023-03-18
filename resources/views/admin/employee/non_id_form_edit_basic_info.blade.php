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
			
				<form name="employee_nonid" class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
                {{ csrf_field() }} 
				<input type="hidden" name="db_id" value="{{$id}}" required class="form-control">
				<div class="form-group"> 
					<div class="col-md-6">
						
						<label class="control-label col-md-4">Emp Type: <span style="color:red;">*</span> </label>
						<div class="col-md-6">
							<select class="form-control" name="emp_type" id="emp_type" style="pointer-events:none;" onchange="myFunction();" required>
								<option value="" hidden>Emp Type</option>
								<?php foreach($all_emp_type as $v_emp_type){?>
									<option value="<?php echo  $v_emp_type->id.','.$v_emp_type->is_field_reduce;?>"><?php echo  $v_emp_type->type_name;?></option>
								<?php } ?>
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="col-md-6">	
						 <label class="control-label col-md-4"> ID: <span style="color:red;">*</span> </label>
						<div class="col-md-6"> 
							<input type="text" name="sacmo_id" id="sacmo_id" readonly value="{{$sacmo_id}}" required class="form-control">
							<span class="help-block"></span>
						</div> 
					</div>  
				<div class="col-md-6">
                    <!--<label class="control-label col-md-2">ID No :</label>
                    <div class="col-md-3"> 
                        <span class="help-block"></span>
                    </div>-->
					<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="{{$emp_id}}" readonly required>
					<label class="control-label col-md-4">Employee Name : <span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="emp_name" id="emp_name" value="{{$emp_name}}" class="form-control" required placeholder="Employee Name">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Mother's Name : <span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="mother_name" id="mother_name" value="{{$mother_name}}" class="form-control" required placeholder="Mother Name">
                        <span class="help-block"></span>
                    </div>
                </div>  
				<div class="col-md-6">                   
					<label class="control-label col-md-4">Father's Name: <span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="father_name" id="father_name" value="{{$father_name}}" class="form-control" required placeholder="Father Name">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">    
					<label class="control-label col-md-4">Birth Date :<span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="date" name="birth_date" id="birth_date" onchange ="age_calculation()" value="{{$birth_date}}" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
                </div> 
				<div class="col-md-6">                  
						<label class="control-label col-md-4">Present Age :</label>
                    <div class="col-md-6">
                        <input type="text" name="present_age" id="present_age" value="" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div> 
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?> >  
					<label class="control-label col-md-4">Blood Group: </label>
                    <div class="col-md-6">
						<select class="form-control" name="blood_group" id="blood_group">
							<?php foreach ($allbloods as $blood_id => $blood_name) { ?>
								<option value="<?php echo $blood_id; ?>"><?php echo $blood_name; ?></option>
							<?php } ?>	
						</select>
                        <span class="help-block"></span>
                    </div> 
                </div> 
				<div class="col-md-6">
					<label class="control-label col-md-4">Marital Status: <span style="color:red;">*</span> </label>
						<div class="col-md-6">
							<select name="maritial_status" id="maritial_status" required class="form-control">
								<option value="Married">Married</option>
								<option value="UnMarried">Unmarried</option>
							</select>
							<span class="help-block"></span>
						</div>
				</div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Gender: <span style="color:red;">*</span></label>
						<div class="col-md-6">
							<select name="gender" id="gender" required class="form-control">
								<option value="male">Male</option>
								<option value="female">Female</option>
								
							</select>
							<span class="help-block"></span>
						</div>
			    </div> 
				<div class="col-md-6">
                    <label class="control-label col-md-4">Nationality: </label>
                    <div class="col-md-6">
                        <input type="text" name="nationality" id="nationality" value="{{$nationality}}"  class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div> 
				<div class="col-md-6">	 
                    <label class="control-label col-md-4">National Id: </label>
                    <div class="col-md-6">
                        <input type="text" name="national_id" id="national_id" value="{{$national_id}}" class="form-control">
                        <span class="help-block"></span>
                    </div>  
                </div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Birth Certificate: </label>
                    <div class="col-md-6">
                        <input type="text" name="birth_certificate" id="birth_certificate" value="{{$birth_certificate}}" class="form-control">
                        <span class="help-block"></span>
                    </div>  
                </div> 
				<div class="col-md-6">
					<label class="control-label col-md-4">Religion : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <select name="religion" id="religion" required class="form-control">
							<option value="">--Select--</option>
							<?php foreach ($allreligions as $religionid => $religionname) { ?>						
							<option value="<?php echo $religionid; ?>"><?php echo $religionname; ?></option>
							<?php } ?>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?> >
					<label class="control-label col-md-4">Email: </label>
                    <div class="col-md-6">
                        <input type="email" name="email" id="email" value="{{$email}}" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="col-md-6">
                    <label class="control-label col-md-4">Contact Number: <span <?php if($is_field_reduce == 1){ ?> style="color:red;display:none;"  <?php }else{?> style="color:red;"<?php  } ?>  >*</span> </label>
                    <div class="col-md-6">
                        <input type="text" name="contact_num" id="contact_num" value="{{$contact_num}}" <?php if($is_field_reduce == 0){ ?> required  <?php } ?>  class="form-control">
                        <span class="help-block"></span>
                    </div>
					
                </div> 
				 
				<div class="col-md-6" >
                    <label class="control-label col-md-4">Last Education: <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
						<input type="text" name="last_education" id="last_education" value="{{$last_education}}"   required  class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?> >
					 <label class="control-label col-md-4">Necessary phone: </label>
                    <div class="col-md-6">
                        <input type="text" name="nec_phone_num" id="nec_phone_num" value="{{$nec_phone_num}}"  class="form-control">
                        <span class="help-block"></span>
                    </div> 
                </div>  
				<div class="col-md-6">
                    <label class="control-label col-md-4">Village : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <input type="text" name="vill_road" id="vill_road" value="{{$vill_road}}" class="form-control" required placeholder="Village">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Post Office : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <input type="text" name="post_office" id="post_office" value="{{$post_office}}" class="form-control" required placeholder="Post Office">
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="col-md-6">
                    <label class="control-label col-md-4">District : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <select name="district_code" id="district_code" required class="form-control">
							<option value="" hidden>-Select District-</option>
							@foreach ($districts as $v_districts)
								<option value="{{$v_districts->district_code}}">{{$v_districts->district_name}}</option>
							@endforeach
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Thana : <span style="color:red;">*</span> </label>
                    @if(!empty($thana_code)) 
					<div class="col-md-6">
						<select name="thana_code" id="thana_code" required class="form-control" >
							@foreach($thanas as $thana)
							@if($thana->thana_code == $thana_code)
							<option value="{{$thana->thana_code}}" selected="selected">{{$thana->thana_name}}</option>
							@endif
							@endforeach
						</select>
						    <span class="help-block"></span>
					</div>
					@else
					<div class="col-md-6">
						<select name="thana_code" disabled="disabled" id="thana_code" required class="form-control">
							<option value="">Select</option>
						</select>
						    <span class="help-block"></span>
                    </div>
					@endif
                </div>
				
				<div class="col-md-6">
					<label class="control-label col-md-4">Present Address : </label>
                    <div class="col-md-6">
						<textarea class="form-control" name="present_add" id="present_add">{{$present_add}}</textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
                    <label class="control-label col-md-4">Permanent Address : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
						<textarea onclick='LoadAddress()' class="form-control" name="permanent_add" id="address" required>{{$permanent_add}}</textarea>
                        <span class="help-block"></span>
                    </div> 
                </div> 
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?> >
					<label class="control-label col-md-4">Reference Name: </label>
                    <div class="col-md-6">
                        <input type="text" name="referrence_name" id="referrence_name" value="{{$referrence_name}}" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?> >
					<label class="control-label col-md-4">Reference Phone: </label>
                    <div class="col-md-6">
                        <input type="text" name="reference_phone" id="reference_phone" value="{{$reference_phone}}" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
			 
            </div> 
				<div class="box-footer">
					 
					<button type="sublit" id="btnSave" class="btn btn-primary">{{$button_text}}</button>					
				</div>
			</form>

		</div>
	</section>
	
	
	<script language="javascript">
	function set_salary_branch() { 
		var br_code = document.getElementById("br_code").value;  
		document.getElementById("salary_br_code").value = br_code;  
	 } 
	 function change_is_cosoleded()
		{		    
			calculate(0);	
		}
	function calculate(value)
		{
			
			var basic_salary=parseFloat(document.employee_nonid.basic_salary.value);
			if(isNaN(basic_salary)) {
				var basic_salary = 0;
			}
			document.getElementById("basic_salary").value = basic_salary;
			var house_rent=parseFloat(document.employee_nonid.house_rent.value);
			if(isNaN(house_rent)) {
				var house_rent = 0;
			}
			document.getElementById("house_rent").value = house_rent;
			
			var medical_a=parseFloat(document.employee_nonid.medical_a.value);
			if(isNaN(medical_a)) {
				var medical_a = 0;
			}
			document.getElementById("medical_a").value = medical_a;
			
			var convence_a=parseFloat(document.employee_nonid.convence_a.value);
			if(isNaN(convence_a)) {
				var convence_a = 0;
			}
			document.getElementById("convence_a").value = convence_a;
			
			var f_allowance=parseFloat(document.employee_nonid.f_allowance.value);
			if(isNaN(f_allowance)) {
				var f_allowance = 0;
			}
			document.getElementById("f_allowance").value = f_allowance;
			var npa_a=parseFloat(document.employee_nonid.npa_a.value);
			if(isNaN(npa_a)) {
				var npa_a = 0;
			}
			document.getElementById("npa_a").value = npa_a;

			var motor_a=parseFloat(document.employee_nonid.motor_a.value);
			if(isNaN(motor_a)) {
				var motor_a = 0;
			}
			document.getElementById("motor_a").value = motor_a;
			
			var field_a=parseFloat(document.employee_nonid.field_a.value);
			if(isNaN(field_a)) {
				var field_a = 0;
			}
			document.getElementById("field_a").value = field_a;
			
			var mobile_a=parseFloat(document.employee_nonid.mobile_a.value);
			if(isNaN(mobile_a)) {
				var mobile_a = 0;
			}
			document.getElementById("mobile_a").value = mobile_a;
		    
			var internet_a=parseFloat(document.employee_nonid.internet_a.value);
			if(isNaN(internet_a)) {
				var internet_a = 0;
			}
			document.getElementById("internet_a").value = internet_a;
			
			var maintenance_a=parseFloat(document.employee_nonid.maintenance_a.value);
			if(isNaN(maintenance_a)) {
				var maintenance_a = 0;
			}
			document.getElementById("maintenance_a").value = maintenance_a;
			
			var console_salary=parseFloat(document.employee_nonid.console_salary.value);
			if(isNaN(console_salary)) {
				var console_salary = 0;
			}
			document.getElementById("console_salary").value = console_salary;
			  
			if (is_Consolidated.checked == true){
					var plus_total =  (basic_salary+npa_a+motor_a+mobile_a+house_rent+medical_a+convence_a+f_allowance+field_a+internet_a+maintenance_a+console_salary);
			  } else {
					var plus_total =  (basic_salary+npa_a+motor_a+mobile_a+house_rent+medical_a+convence_a+f_allowance+field_a+internet_a+maintenance_a);
			  } 
			document.getElementById("gross_salary").value = plus_total;
			
		} 
	 function age_calculation() { 
		var birth_date = document.getElementById("birth_date").value;
		
			$.ajax({
				url : "{{ url::to('age_calculation') }}"+"/"+birth_date,
				type: "GET",
				success: function(data)
				{
					document.getElementById("present_age").value = data;
				}
			});  

	 }
	function myFunction() { 
		var emptype = document.getElementById("emp_type").value;
		
			$.ajax({
				url : "{{ url::to('get-non-max') }}"+"/"+emptype,
				type: "GET",
				success: function(data)
				{
					document.getElementById("sacmo_id").value=data;
				}
			});    
	}
</script>
	
	 

	<script>
		$(document).on("change", "#district_code", function () {
			var district_code = $(this).val();   
			$.ajax({
				url : "{{ url::to('select-thana') }}"+"/"+district_code,
				type: "GET",
				success: function(data)
				{
					//alert(data);
					$("#thana_code").attr("disabled", false);
					$("#thana_code").html(data); 
					//$("#upazi_name").html(data); 			 
				}
			});  
		}); 
	</script>	

	<script type="text/javascript">
		function LoadAddress() {
			var v='Vill';
			var p='Post';
			var t='Thana';
			var d='Dist';
			var text=document.getElementById('vill_road').value;
			var text1=document.getElementById('post_office').value;
			var text2=document.getElementById('thana_code').selectedOptions[0].text;
			var text3=document.getElementById('district_code').selectedOptions[0].text;
			document.getElementById('address').value= v + ":" + " " + text + "," + " " + p + ":" + " " + text1 + "," + " " + t + ":" + " " + text2 + "," + " " + d + ":" + " " + text3;
		}
	</script>
	
	<script> 
		document.getElementById("district_code").value= "{{$district_code}}";
		document.getElementById("thana_code").value= "{{$thana_code}}";  
		document.getElementById("emp_type").value= "{{$emp_type.','.$is_field_reduce}}";
		document.getElementById("gender").value= "{{$gender}}";
		document.getElementById("religion").value= "{{$religion}}";
		document.getElementById("maritial_status").value= "{{$maritial_status}}";
		document.getElementById("blood_group").value= "{{$blood_group}}";
		age_calculation();
		 
	</script>

@endsection