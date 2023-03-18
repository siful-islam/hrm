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
				{!!$method_control!!}
			<div class="form-group">
				<div class="col-md-6">     
                    
					<label class="control-label col-md-4">Emp Type:</label>
                    <div class="col-md-6" > 
                        <span class="form-control"> <?php   echo  $type_name; ?></span> 
						   <span class="help-block"></span>
                    </div>
                    </div>
				<div class="col-md-6"> 
					 <label class="control-label col-md-4"> ID:</label>
                    <div class="col-md-6"> 
                       <span class="form-control"> <?php echo  $sacmo_id;?></span>
					     <span class="help-block"></span>
                    </div> 
                </div>

				<div class="col-md-6"> 
                    <!--<label class="control-label col-md-4">ID No :</label>
                    <div class="col-md-6"> 
                        <span class="help-block"></span>
                    </div>-->
					<label class="control-label col-md-4">Employee Name :</label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $emp_name;?></span>
						  <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Mother's Name :</label>
                    <div class="col-md-6"> 
                        <span class="form-control"> <?php echo  $mother_name;?></span>
						  <span class="help-block"></span>
                    </div>
                </div> 
				<div class="col-md-6">                   
					<label class="control-label col-md-4">Father's Name:</label>
                    <div class="col-md-6"> 
                        <span class="form-control"> <?php echo  $father_name;?></span>
						  <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Birth Date :</label>
                    <div class="col-md-6">
					<input type="hidden"   id="birth_date" readonly value="<?php  echo  $birth_date;?>" class="form-control"> 
                         <span class="form-control"> <?php  echo  date("d-m-Y",strtotime($birth_date));?></span>
						   <span class="help-block"></span>
                    </div>
                </div>

				<div class="col-md-6">                   
						<label class="control-label col-md-4">Present Age :</label>
                    <div class="col-md-6">
                        <input type="hidden" name="present_age" id="present_age" readonly value="" class="form-control">
                        <span class="form-control" id="present_age1"></span>
						  <span class="help-block"></span>
                    </div>
               </div>
			   <div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Blood Group: </label>
                    <div class="col-md-6"> 
                         <span class="form-control"> <?php echo  $blood_group;?></span>
						   <span class="help-block"></span>
                    </div> 
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Maritial Status:</label>
						<div class="col-md-6"> 
							 <span class="form-control"> <?php if($maritial_status =="Married"){ echo  "Married"; }  else {  echo  "Unmarried";   }?></span>
							   <span class="help-block"></span>
						</div>
				</div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Gender: </label>
						<div class="col-md-6"> 
							 <span class="form-control"> <?php if($gender =="male"){ echo  "Male"; }  else {  echo  "Female";   }?></span>
							   <span class="help-block"></span>
						
						</div>
			    </div> 
				<div class="col-md-6"> 
                    <label class="control-label col-md-4">Nationality: </label>
                    <div class="col-md-6">
                          <span class="form-control"> <?php echo  $nationality;?></span>
						    <span class="help-block"></span>
                    </div>
                    </div>
				<div class="col-md-6"> 	 
                    <label class="control-label col-md-4">National Id: </label>
                    <div class="col-md-6">
                         <span class="form-control"> <?php echo  $national_id;?></span>
						   <span class="help-block"></span>
                    </div>  
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Birth Certificate: </label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $birth_certificate;?></span>
						  <span class="help-block"></span>
                    </div>  
                </div>  
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Religion : </label>
                    <div class="col-md-6"> 
                        <span class="form-control"> <?php echo  $religion;?></span>
						  <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Email: </label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $email;?></span>
						  <span class="help-block"></span>
                    </div>
                    </div>
					<div class="col-md-6"> 
                    <label class="control-label col-md-4">Contact Number: </label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $contact_num;?></span>
						  <span class="help-block"></span>
                    </div>
					
                </div> 
				<div class="col-md-6"> 
                    <label class="control-label col-md-4">Last Education: </label>
                    <div class="col-md-6">
						 <span class="form-control"> <?php echo  $last_education;?></span>
						   <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					 <label class="control-label col-md-4">Necessary phone: </label>
                    <div class="col-md-6">
                         <span class="form-control"> <?php echo  $nec_phone_num;?></span>
						   <span class="help-block"></span>
                    </div> 
                </div> 
				<!--<div class="form-group"> 
					<label class="control-label col-md-4">Pre Emp Id: </label>
                    <div class="col-md-6">
                        <input type="text" name="pre_emp_id" id="pre_emp_id" value="{{$pre_emp_id}}" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>-->

			<div class="col-md-6"> 
                    <label class="control-label col-md-4">Village : </label>
                    <div class="col-md-6">
                        <input type="hidden" name="vill_road" readonly id="vill_road" value="{{$vill_road}}" class="form-control" required placeholder="Village">
                        <span class="form-control"> <?php echo  $vill_road;?></span>
						  <span class="help-block"></span>
                    </div>
            </div>
			<div class="col-md-6"> 		
					<label class="control-label col-md-4">Post Office :</label>
                    <div class="col-md-6">
                        <input type="hidden" name="post_office"  readonly id="post_office" value="{{$post_office}}" class="form-control" required placeholder="Post Office">
                         <span class="form-control"> <?php echo  $post_office;?></span>
						   <span class="help-block"></span>
                    </div>
                </div>

				<div class="col-md-6"> 
                    <label class="control-label col-md-4">District : </label>
                    <div class="col-md-6">
                        <select name="district_code"  id="district_code"  style="pointer-events:none;" class="form-control"> 
							@foreach ($districts as $v_districts)
								<option value="{{$v_districts->district_code}}">{{$v_districts->district_name}}</option>
							@endforeach
						</select> 
						  <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Thana :</label>
                    @if(!empty($thana_code)) 
					<div class="col-md-6">
						<select name="thana_code" id="thana_code" style="pointer-events:none;"  class="form-control" >
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
						<select name="thana_code" disabled="disabled" style="pointer-events:none;" readonly id="thana_code" required class="form-control">
						 
						</select>
						  <span class="help-block"></span>
                    </div>
					@endif
                </div>
				
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Present Address : </label>
                    <div class="col-md-6">
						<textarea class="form-control"  name="present_add" id="present_add">{{$present_add}}</textarea>
						  <span class="help-block"></span>
                        
                    </div>
                    </div>
					<div class="col-md-6"> 
                    <label class="control-label col-md-4">Permanent Address : </label>
                    <div class="col-md-6">
						<textarea   class="form-control" name="permanent_add" id="address" >{{$permanent_add}}</textarea>
						  <span class="help-block"></span>
                        
                    </div> 
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Reference Name: </label>
                    <div class="col-md-6">
                       <span class="form-control"> <?php echo  $referrence_name;?></span>
					     <span class="help-block"></span>
                    </div>
                    </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Reference Phone: </label>
                    <div class="col-md-6">  
                        <span class="form-control"> <?php echo  $reference_phone;?></span>
						 <span class="help-block"></span>
                    </div>
                </div>  
                </div>  
			<div class="box-header with-border">
					<h3 class="box-title">Official Information</h3>
				</div><br>
					<div class="form-group">
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Designation: </label>
                    <div class="col-md-6">
						<select class="form-control" name="designation_code" style="pointer-events:none;"  id="designation_code" >
							@foreach ($designation as $v_designation)
								<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
							@endforeach
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Joining Branch:</label>
					<div class="col-md-6">
						<select name="join_br_code" id="join_br_code" style="pointer-events:none;"  class="form-control">
							@foreach ($branches as $v_branches)
							<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
							@endforeach
						</select>
						<span class="help-block"><?php //echo $join_br_code; ?></span>
					</div> 
				</div> 
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Org. Joining Date:</label>
                    <div class="col-md-6"> 
                        <span class="form-control"> <?php echo  date("d-m-Y",strtotime($joining_date));?></span>
						   <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Br Join Date(After Training): </label>
                    <div class="col-md-6"> 
                       <span class="form-control"> <?php if(!empty($after_trai_join_date)){ echo  date("d-m-Y",strtotime($after_trai_join_date)); } ?></span>
					      <span class="help-block"></span>
                    </div>
                </div>	
				<div class="col-md-6"> 
				 <!--<label class="control-label col-md-4">contract Renew Date: <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <input type="date" name="next_renew_date" id="next_renew_date" value="" required class="form-control">
                        <span class="help-block"></span>
                    </div>--> 
					<label class="control-label col-md-4">Salary Branch: </label>
						<div class="col-md-6">
							<select name="salary_br_code" id="salary_br_code" required style="pointer-events:none;" class="form-control"> 
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select>
							   <span class="help-block"></span>
						</div>  
				    </div>  
					<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Branch ( After Training): </label>
                    <div class="col-md-6"> 
                        <span class="help-block"></span>
						<select name="after_trai_br_code" id="after_trai_br_code" style="pointer-events:none;"   class="form-control"> 
							@foreach ($branches as $v_branches)
							<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
							@endforeach
						</select> 	
						   <span class="help-block"></span>
                    </div> 
				</div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){  if($emp_type == 7){?> style="display:block;"  <?php }else{ ?> style="display:none;" <?php } } ?>> 
					<label class="control-label col-md-4" id="c_end_date_lebel">Contract Ending Date:  </label>
                    <div class="col-md-6"> 
						<span class="form-control" <?php if($end_type == 0){ ?>  readonly <?php }  ?> >  <?php if(!empty($c_end_date)) { echo date('d-m-Y',strtotime($c_end_date)); } ?> </span>
                        <span class="help-block">Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" name="end_type" id="end_type" value="{{$end_type}}" <?php if($end_type == 0){ ?> checked <?php }  ?> ></span>
						   <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Present Working Branch: </label>
					<div class="col-md-6">
						<select name="br_code" id="br_code" style="pointer-events:none;"  class="form-control">
							@foreach ($branches as $v_branches)
							<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
							@endforeach
						</select>
						<span class="help-block"></span>
					</div>
				</div>
				</div>
				<div class="box-header with-border">
					 
					<h3 class="box-title" style="float:left;">Salary Information&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
					 <span class="help-block" >is Consolidated? &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="is_Consolidated" id="is_Consolidated" value="{{$is_Consolidated}}" <?php if($is_Consolidated == 2) echo "checked";?> ></span>
				</div><br>
					<div class="form-group">
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Effect Date:</label>
						<div class="col-md-6"> 
							<span class="form-control"> <?php echo  date("d-m-Y",strtotime($effect_date));?></span>
							   <span class="help-block"></span>
						</div>	
						</div>	
				<div class="col-md-6" > 
					<label class="control-label col-md-4">Consolidated Salary: </label>
						<div class="col-md-6">
							 <span class="form-control"> <?php echo  $console_salary;?></span>
							    <span class="help-block"></span>
						</div>	
				</div>
				<div class="col-md-6"> 
                    <label class="control-label col-md-4">Basic Salary:</label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $basic_salary;?></span>
						   <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">House Rent: </label>
                    <div class="col-md-6">
                         <span class="form-control"> <?php echo  $house_rent;?></span>
						    <span class="help-block"></span>
                    </div> 
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
                    <label class="control-label col-md-4">Medical : </label>
                    <div class="col-md-6">
                         <span class="form-control"> <?php echo  $medical_a;?></span>
						    <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Conveyance </label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $convence_a;?></span>
						   <span class="help-block"></span>
                    </div> 
                </div>  
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Conveyance & Fuel Allowance :</label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $f_allowance;?></span>
						   <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">NPA :</label>
                    <div class="col-md-6"> 
						 <span class="form-control"> <?php echo  $npa_a;?></span>
						    <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 	
                    <label class="control-label col-md-4" id="motor_level">Motor-Cycle</label>
                    <div class="col-md-6">
						<span class="form-control"> <?php echo  $motor_a;?></span>
						   <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-4">Field Allowance: </label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $field_a; ?></span>
						   <span class="help-block"></span>
                    </div> 
                </div> 
				<div class="col-md-6"> 
				<label class="control-label col-md-4" id="mobile_level">Mobile : </label>
                    <div class="col-md-6">
                         <span class="form-control"> <?php echo  $mobile_a;?></span>
						    <span class="help-block"></span>
                    </div>
                    </div>
			    <div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
                    <label class="control-label col-md-4"> Mobile & Internet : </label>
                    <div class="col-md-6"> 	  	       	 	 	 
                        <span class="form-control"> <?php echo  $internet_a;?></span>
						   <span class="help-block"></span>
                    </div>
					
					
                </div> 
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
                    <label class="control-label col-md-4"> Maintenance allowance : </label>
                    <div class="col-md-6"> 	  	       	 	 	 
                        <span class="form-control"> <?php echo  $maintenance_a;?></span>
						   <span class="help-block"></span>
                    </div>
					
					
                </div> 
				<div class="col-md-6"> 
                    <label class="control-label col-md-4">Gross Salary:</label>
                    <div class="col-md-6">
                        <span class="form-control"> <?php echo  $gross_salary;  	?></span>
						   <span class="help-block"></span>
                    </div> 
                    </div> 
					<div class="col-md-6"> 
					<label class="control-label col-md-4">Comments:</label>
                    <div class="col-md-6">
						<textarea   class="form-control"><?php echo  $nara_tion.$br_code.'ok';  	?></textarea>
						   <span class="help-block"></span>
                    </div> 
                </div> 
                </div> 
				<br>
			</form>  
		</div>
	</section> 
	<script type="text/javascript">
	function hide(){
		var earrings = document.getElementById('district_code');
		earrings.style.visibility = 'hidden';
		}

	 function age_calculation() { 
		var birth_date = document.getElementById("birth_date").value;
		
			$.ajax({
				url : "{{ url::to('age_calculation') }}"+"/"+birth_date,
				type: "GET",
				success: function(data)
				{
					document.getElementById("present_age").value = data;
					document.getElementById("present_age1").innerHTML  = data;
				}
			});  

	 }
	 age_calculation();
	 
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
			var earrings = document.getElementById('district_code');
			earrings.style.visibility = 'hidden';
		}
	</script>
	
	<script>
		document.getElementById("district_code").value= "{{$district_code}}";
		document.getElementById("thana_code").value= "{{$thana_code}}";
		document.getElementById("salary_br_code").value= "{{$salary_br_code}}";
		document.getElementById("after_trai_br_code").value= "{{$after_trai_br_code}}";
		<?php if(!empty($after_trai_br_code)){ ?>
				document.getElementById("br_code").value= "{{$after_trai_br_code}}";
		<?php }else{ ?>
			document.getElementById("br_code").value= "{{$br_code}}";
		<?php } ?>
		
		document.getElementById("designation_code").value= "{{$designation_code}}";  
		document.getElementById("join_br_code").value= "{{$join_br_code}}";  
	</script>

@endsection