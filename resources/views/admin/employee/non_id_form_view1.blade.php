@extends('admin.admin_master')
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
				<h3 class="box-title"> Personal Information </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form name="employee_nonid" class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}



				<div class="form-group">
                    <label class="control-label col-md-2">ID No :</label>
                    <div class="col-md-3">
                        <input type="text" name="emp_id" id="emp_id" class="form-control" value="{{$emp_id}}" readonly required>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Employee Name :</label>
                    <div class="col-md-3">
                        <input type="text" name="emp_name" id="emp_name" value="{{$emp_name}}" class="form-control" required readonly>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				
				<div class="form-group">                   
					<label class="control-label col-md-2">Father Name: </label>
                    <div class="col-md-3">
                        <input type="text" name="father_name" id="father_name" value="{{$father_name}}" class="form-control" required readonly>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Mother Name : </label>
                    <div class="col-md-3">
                        <input type="text" name="mother_name" id="mother_name" value="{{$mother_name}}" class="form-control" required readonly>
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group">                  
					<label class="control-label col-md-2">Birth Date :</label>
                    <div class="col-md-3">
                        <input type="date" name="birth_date" id="birth_date" value="{{$birth_date}}" class="form-control" readonly required>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Gender: </label>
                    <div class="col-md-3">
						<select name="gender" id="gender" required readonly class="form-control">
							<option value="male">Male</option>
							<option value="femmale">Female</option>
							
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
	
				<div class="form-group">
                    <label class="control-label col-md-2">Nationality: </label>
                    <div class="col-md-3">
                        <input type="text" name="nationality" id="nationality" value="{{$nationality}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Religion : </label>
                    <div class="col-md-3">
                        <select name="religion" id="religion" required readonly class="form-control">
							<?php foreach ($allreligions as $religionid => $religionname) { ?>						
							<option value="<?php echo $religionid; ?>"><?php echo $religionname; ?></option>
							<?php } ?>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Contact Number: </label>
                    <div class="col-md-3">
                        <input type="text" name="contact_num" id="contact_num" value="{{$contact_num}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Email: </label>
                    <div class="col-md-3">
                        <input type="email" name="email" id="email" value="{{$email}}" readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">National Id: </label>
                    <div class="col-md-3">
                        <input type="text" name="national_id" id="national_id" value="{{$national_id}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Maritial Status: </label>
                    <div class="col-md-3">
						<select name="maritial_status" id="maritial_status" required readonly class="form-control">
							<option value="Married">Married</option>
							<option value="UnMarried">UnMarried</option>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Joining Branch: </label>
					<div class="col-md-3">
						<select name="br_code" id="br_code" required readonly class="form-control">
							<option value="" hidden>-Select Branch-</option>
							@foreach ($branches as $v_branches)
							<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
							@endforeach
						</select>
						<span class="help-block"></span>
					</div>
					
					<label class="control-label col-md-2">Joining Date: </label>
                    <div class="col-md-3">
                        <input type="date" name="joining_date" id="joining_date" value="{{$joining_date}}" onchange="set_renew_date();" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				
				<div class="form-group">
                    <label class="control-label col-md-2">Last Education: </label>
                    <div class="col-md-3">
						<input type="text" name="last_education" id="last_education" value="{{$last_education}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div><label class="control-label col-md-2">Blood Group: </label>
                    <div class="col-md-3">
						<select class="form-control" name="blood_group" id="blood_group" readonly required>
							<?php foreach ($allbloods as $blood_id => $blood_name) { ?>
								<option value="<?php echo $blood_id; ?>"><?php echo $blood_name; ?></option>
							<?php } ?>	
						</select>
                        <span class="help-block"></span>
                    </div>
					
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Necessary phone: </label>
                    <div class="col-md-3">
                        <input type="text" name="nec_phone_num" id="nec_phone_num" value="{{$nec_phone_num}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Referrence Name: </label>
                    <div class="col-md-3">
                        <input type="text" name="referrence_name" id="referrence_name" value="{{$referrence_name}}" readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				
				<div class="form-group">
                    <label class="control-label col-md-2">Designation: </label>
                    <div class="col-md-3">
						<select class="form-control" name="designation_code" id="designation_code" readonly required>
							<option value="" hidden>Designation</option>
							@foreach ($designation as $v_designation)
								<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
							@endforeach
						</select>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Emp Type: </label>
                    <div class="col-md-3">
						<select class="form-control" name="emp_type" id="emp_type" onchange="myFunction();" readonly required>
							<option value="" hidden>Emp Type</option>
							<option value="non_id">Non Id</option>
							<option value="sacmo">Sacmo</option>
							<option value="shs">Shs</option>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Sacmo Id: </label>
                    <div class="col-md-3">
                        <input type="text" name="sacmo_id" id="sacmo_id" value="{{$sacmo_id}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Br Join Date: </label>
                    <div class="col-md-3">
                        <input type="date" name="br_join_date" id="br_join_date" value="{{$br_join_date}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Next Renew Date: </label>
                    <div class="col-md-3">
                        <input type="date" name="next_renew_date" id="next_renew_date" value="{{$next_renew_date}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Pre Emp Id: </label>
                    <div class="col-md-3">
                        <input type="text" name="pre_emp_id" id="pre_emp_id" value="{{$pre_emp_id}}" readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="control-label col-md-2">Village : </label>
                    <div class="col-md-3">
                        <input type="text" name="vill_road" id="vill_road" value="{{$vill_road}}" class="form-control" required readonly  placeholder="Village">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Post Office : </label>
                    <div class="col-md-3">
                        <input type="text" name="post_office" id="post_office" value="{{$post_office}}" class="form-control" required readonly placeholder="Post Office">
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="control-label col-md-2">District : </label>
                    <div class="col-md-3">
                        <select name="district_code" id="district_code" required readonly class="form-control">
							<option value="" hidden>-Select District-</option>
							@foreach ($districts as $v_districts)
								<option value="{{$v_districts->district_code}}">{{$v_districts->district_name}}</option>
							@endforeach
						</select>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Thana : </label>
                    @if(!empty($thana_code))
					<div class="col-md-3">
						<select name="thana_code" id="thana_code" required readonly class="form-control" >
							@foreach($thanas as $thana)
							@if($thana->thana_code == $thana_code)
							<option value="{{$thana->thana_code}}" selected="selected">{{$thana->thana_name}}</option>
							@endif
							@endforeach
						</select>
					</div>
					@else
					<div class="col-md-3">
						<select name="thana_code" disabled="disabled" id="thana_code" readonly required class="form-control">
							<option value="">Select</option>
						</select>
                    </div>
					@endif
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Permanenet Address : </label>
                    <div class="col-md-3">
						<textarea onclick='LoadAddress()' class="form-control" name="permanent_add" readonly id="address">{{$permanent_add}}</textarea>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Present Address : </label>
                    <div class="col-md-3">
						<textarea class="form-control" name="present_add" readonly id="present_add">{{$present_add}}</textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="box-header with-border">
					<h3 class="box-title">Salary Information</h3>
				</div><br>
					
					

				<div class="form-group">
                    <label class="control-label col-md-2" id="basic_level"><?php echo ($emp_type=='non_id') ? 'Consolidated Salary' : 'Basic Salary'; ?> : </label>
                    <div class="col-md-3">
                        <input type="number" name="basic_salary" id="basic_salary" value="{{$basic_salary}}" onkeyup="calculate(this.value);" required readonly  class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2" id="npa_level"><?php echo ($emp_type=='shs') ? 'Hardship' : 'NPA'; ?> : </label>
                    <div class="col-md-3">
                        <input type="number" name="npa_a" id="npa_a" value="{{$npa_a}}" required onkeyup="calculate(this.value);" readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2" id="motor_level"><?php echo ($emp_type=='shs') ? 'Other' : 'Motor-Cycle'; ?> : </label>
                    <div class="col-md-3">
                        <input type="number" name="motor_a" id="motor_a" value="{{$motor_a}}" required onkeyup="calculate(this.value);" readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2" id="mobile_level">Mobile Allowance: </label>
                    <div class="col-md-3">
                        <input type="number" name="mobile_a" id="mobile_a" value="{{$mobile_a}}" required onkeyup="calculate(this.value);" readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="control-label col-md-2" id="gross_level">Gross Salary: </label>
                    <div class="col-md-3">
                        <input type="number" name="gross_salary" id="gross_salary" value="{{$gross_salary}}" required readonly class="form-control">
                        <span class="help-block"></span>
                    </div>
					
                </div>

			</form>

		</div>
	</section>
	
	
	<script language="javascript">
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

		//////////	
		if (emptype == 'non_id') {
			document.getElementById("basic_level").innerHTML = "Consolidated Salary";
		} else if (emptype == 'sacmo') {
			document.getElementById("basic_level").innerHTML = "Basic Salary";
			document.getElementById("npa_level").innerHTML = "NPA";
			document.getElementById("motor_level").innerHTML = "Motor-Cycle";
		} else if (emptype == 'shs') {
			document.getElementById("basic_level").innerHTML = "Basic Salary";
			document.getElementById("npa_level").innerHTML = "Hardship";
			document.getElementById("motor_level").innerHTML = "Other";
		}
		
	}
</script>
	
	
	<script language="javascript">
		function calculate(value)
		{
			
			var basic_salary=parseFloat(document.employee_nonid.basic_salary.value);
			if(isNaN(basic_salary)) {
				var basic_salary = 0;
			}

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
			
			var mobile_a=parseFloat(document.employee_nonid.mobile_a.value);
			if(isNaN(mobile_a)) {
				var mobile_a = 0;
			}
			document.getElementById("mobile_a").value = mobile_a;
			
			var plus_total =  (basic_salary+npa_a+motor_a+mobile_a);

			document.getElementById("gross_salary").value = plus_total;
			
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
		document.getElementById("br_code").value= "{{$br_code}}";
		document.getElementById("designation_code").value= "{{$designation_code}}";
		document.getElementById("emp_type").value= "{{$emp_type}}";
		document.getElementById("gender").value= "{{$gender}}";
		document.getElementById("religion").value= "{{$religion}}";
		document.getElementById("maritial_status").value= "{{$maritial_status}}";
		document.getElementById("blood_group").value= "{{$blood_group}}";
		
		
		function set_renew_date()
		{
			var joining_date = document.getElementById("joining_date").value;
			var period = 12;
			var d = new Date(joining_date);
			d.setMonth(d.getMonth() + parseFloat(period));
			var dateFormated = d.toISOString().substr(0,10);
			document.getElementById("next_renew_date").value = dateFormated;
		}
	</script>

@endsection