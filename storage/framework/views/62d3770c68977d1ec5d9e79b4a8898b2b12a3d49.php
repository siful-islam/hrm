
<?php $__env->startSection('main_content'); ?> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Contractual <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Contractual</a></li>
			<li class="active"><?php echo e($Heading); ?></li>
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
			
				<form name="employee_nonid" class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

				<?php echo $method_control; ?>

				 <input type="hidden" name="br_join_date" id="br_join_date" value="<?php echo e($br_join_date); ?>" required class="form-control">
				
				<div class="form-group">
				<div class="col-md-6">
                    
					<label class="control-label col-md-4">Emp Type: <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
						<select class="form-control" name="emp_type" id="emp_type" onchange="myFunction();" required>
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
                        <input type="text" name="sacmo_id" id="sacmo_id" value="<?php echo e($sacmo_id); ?>" required class="form-control">
                        <span class="help-block"></span>
                    </div> 
                </div>

				<div class="col-md-6">
                    <!--<label class="control-label col-md-2">ID No :</label>
                    <div class="col-md-3"> 
                        <span class="help-block"></span>
                    </div>-->
					<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="<?php echo e($emp_id); ?>" readonly required>
					
					
					<label class="control-label col-md-4">Employee Name : <span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="emp_name" id="emp_name" value="<?php echo e($emp_name); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
               </div>
				<div class="col-md-6">	
					<label class="control-label col-md-4">Mother's Name : <span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="mother_name" id="mother_name" value="<?php echo e($mother_name); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
                </div> 
				<div class="col-md-6">                   
					<label class="control-label col-md-4">Father's Name: <span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="father_name" id="father_name" value="<?php echo e($father_name); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Birth Date :<span style="color:red;">*</span></label>
                    <div class="col-md-6">
                        <input type="date" name="birth_date" id="birth_date" onchange ="age_calculation()" value="<?php echo e($birth_date); ?>" class="form-control" required>
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
				<div class="col-md-6" id="blood_hide" style="display:block;">  
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
                        <input type="text" name="nationality" id="nationality" value="<?php echo e($nationality); ?>"  class="form-control">
                        <span class="help-block"></span>
                    </div>
                 </div>
				<div class="col-md-6">	
					 
                    <label class="control-label col-md-4">National ID: </label>
                    <div class="col-md-6">
                        <input type="text" name="national_id" id="national_id" value="<?php echo e($national_id); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>  
                </div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Birth Certificate: </label>
                    <div class="col-md-6">
                        <input type="text" name="birth_certificate" id="birth_certificate" value="<?php echo e($birth_certificate); ?>" class="form-control">
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
				<div class="col-md-6" id="email_hide" style="display:block;">
					<label class="control-label col-md-4">Email: </label>
                    <div class="col-md-6">
                        <input type="email" name="email" id="email" value="<?php echo e($email); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
                    <label class="control-label col-md-4">Contact Number:<span style="color:red;display:block;" id="contact_num_required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="contact_num" id="contact_num" value="<?php echo e($contact_num); ?>" required class="form-control">
                        <span class="help-block"></span>
                    </div>
					
                </div> 
				<div class="col-md-6">
                    <label class="control-label col-md-4">Last Education: <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
						<input type="text" name="last_education" id="last_education" value="<?php echo e($last_education); ?>" required class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" id="necessary_phone_hide" style="display:block;">
					 <label class="control-label col-md-4">Necessary phone: </label>
                    <div class="col-md-6">
                        <input type="text" name="nec_phone_num" id="nec_phone_num" value="<?php echo e($nec_phone_num); ?>"  class="form-control">
                        <span class="help-block"></span>
                    </div> 
                </div> 
				<!--<div class="form-group"> 
					<label class="control-label col-md-2">Pre Emp Id: </label>
                    <div class="col-md-3">
                        <input type="text" name="pre_emp_id" id="pre_emp_id" value="<?php echo e($pre_emp_id); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>-->

				<div class="col-md-6">
                    <label class="control-label col-md-4">Village : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <input type="text" name="vill_road" id="vill_road" value="<?php echo e($vill_road); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
               </div>
			   <div class="col-md-6">
					<label class="control-label col-md-4">Post Office : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <input type="text" name="post_office" id="post_office" value="<?php echo e($post_office); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="col-md-6">
                    <label class="control-label col-md-4">District : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <select name="district_code" id="district_code" required class="form-control">
							<option value="" hidden>-Select District-</option>
							<?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_districts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_districts->district_code); ?>"><?php echo e($v_districts->district_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div> 
				<div class="col-md-6">
                    <label class="control-label col-md-4">Thana :  <span style="color:red;">*</span> </label>
                     <?php if(!empty($thana_code)): ?> 
					<div class="col-md-6">
                       <select name="thana_code" id="thana_code" required class="form-control" >
							<?php $__currentLoopData = $thanas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($thana->thana_code == $thana_code): ?>
							<option value="<?php echo e($thana->thana_code); ?>" selected="selected"><?php echo e($thana->thana_name); ?></option>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                        <span class="help-block"></span>
                    </div>
					<?php else: ?>
					<div class="col-md-6">
						<select name="thana_code" disabled="disabled" id="thana_code" required class="form-control">
							<option value="">Select</option>
						</select>
						 <span class="help-block"></span>
                    </div>
					<?php endif; ?>
                </div>
				<div class="col-md-6">
					<label class="control-label col-md-4">Present Address : </label>
                    <div class="col-md-6">
						<textarea class="form-control" name="present_add" id="present_add"><?php echo e($present_add); ?></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
                    <label class="control-label col-md-4">Permanent Address : <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
						<textarea onclick='LoadAddress()' class="form-control" name="permanent_add" id="address" required><?php echo e($permanent_add); ?></textarea>
                        <span class="help-block"></span>
                    </div> 
                </div>
			    <div class="col-md-6" id="referrence_name_hide" style="display:block;">
					<label class="control-label col-md-4">Reference Name: </label>
                    <div class="col-md-6">
                        <input type="text" name="referrence_name" id="referrence_name" value="<?php echo e($referrence_name); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" id="reference_phone_hide" style="display:block;">
					<label class="control-label col-md-4">Reference Phone: </label>
                    <div class="col-md-6">
                        <input type="text" name="reference_phone" id="reference_phone" value="<?php echo e($reference_phone); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>  
				
                </div>   
				<div class="box-header with-border">
					<h3 class="box-title">Official Information</h3>
				</div><br>
			<div class="form-group">	
				<div class="col-md-6">
					<label class="control-label col-md-4">Designation: <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
						<select class="form-control" name="designation_code" id="designation_code" required>
							<option value="" hidden>Select</option>
							<?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_designation->designation_code); ?>"><?php echo e($v_designation->designation_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">	
					<label class="control-label col-md-4">Joining Branch: <span style="color:red;">*</span> </label>
					<div class="col-md-6">
						<select name="br_code" id="br_code" onchange="set_salary_branch()" required class="form-control">
							<option value="" hidden>-Select Branch-</option>
							<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						<span class="help-block"></span>
					</div>
				</div> 
				<div class="col-md-6"> 
					<label class="control-label col-md-4">Org. Joining Date: <span style="color:red;">*</span> </label>
                    <div class="col-md-6">
                        <input type="date" name="joining_date" id="joining_date" value="<?php echo e($joining_date); ?>" onchange="set_effect_date();" required class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" id="br_join_after_date_hide" style="display:block;">
					<label class="control-label col-md-4">Br Join Date(After Training): </label>
                    <div class="col-md-6">
                        <input type="date" name="after_trai_join_date" id="after_trai_join_date" value="<?php echo e($after_trai_join_date); ?>"  class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6">
				 <!--<label class="control-label col-md-2">contract Renew Date: <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        <input type="date" name="next_renew_date" id="next_renew_date" value="" required class="form-control">
                        <span class="help-block"></span>
                    </div>--> 
					<label class="control-label col-md-4">Salary Branch: <span style="color:red;">*</span> </label>
						<div class="col-md-6">
							<select name="salary_br_code" id="salary_br_code" required class="form-control">
								<option value="" hidden>-Select Branch-</option>
								<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
							 <span class="help-block"></span>
						</div> 
			    </div> 
				<div class="col-md-6" id="br_join_after_train_hide" style="display:block;">		
					<label class="control-label col-md-4">Branch ( After Training): </label>
                    <div class="col-md-6"> 
                        <span class="help-block"></span>
						<select name="after_trai_br_code" id="after_trai_br_code"  class="form-control">
							<option value="">-Select Branch-</option>
							<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select> 
						<span class="help-block"></span>						
                    </div> 
				</div>
				<div class="col-md-6" id="contract_end_hide" style="display:block;">
					<label class="control-label col-md-4" id="c_end_date_lebel">Contract Ending Date:  </label>
                    <div class="col-md-6">
                        <input type="date" name="c_end_date" readonly id="c_end_date" value="<?php echo e($c_end_date); ?>" class="form-control">
                        <span class="help-block">Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_contract_end_type()" name="end_type" id="end_type" value="<?php echo e($end_type); ?>" checked ></span>
						 <span class="help-block"></span>
                    </div>
				</div>
			</div>
				<div class="box-header with-border"> 
					<h3 class="box-title" style="float:left;">Salary Information&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
					 <span class="help-block">is Consolidated? &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_is_cosoleded()" name="is_Consolidated" id="is_Consolidated" value="<?php echo e($is_Consolidated); ?>" ></span>
				</div><br>
				<div class="form-group">	
				 <div class="col-md-6">	
					<label class="control-label col-md-4">Effect Date: <span style="color:red;">*</span> </label>
						<div class="col-md-6">
							<input type="date" name="effect_date" id="effect_date" value="<?php echo e($effect_date); ?>" required class="form-control">
							<span class="help-block"></span>
						</div>	
				   </div>	
				 <div class="col-md-6">	
					<label class="control-label col-md-4">Consolidated Salary: </label>
						<div class="col-md-6">
							<input type="text" name="console_salary" onkeyup="calculate(this.value);" id="console_salary" value="<?php echo e($console_salary); ?>"  class="form-control"> 
							<span class="help-block"></span>
						</div>	
				</div>
				 <div class="col-md-6">	
                    <label class="control-label col-md-4">Basic Salary:</label>
                    <div class="col-md-6">
                        <input type="text" name="basic_salary" id="basic_salary" value="<?php echo e($basic_salary); ?>" onkeyup="calculate(this.value);"  class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				 <div class="col-md-6" id="houserent_hide" style="display:block;">	
					<label class="control-label col-md-4">House Rent: </label>
                    <div class="col-md-6">
                        <input type="text" name="house_rent" id="house_rent" onkeyup="calculate(this.value);" value="<?php echo e($house_rent); ?>"  class="form-control"> 
                        <span class="help-block"></span>
                    </div> 
                </div>
				 <div class="col-md-6" id="medical_hide" style="display:block;">	
                    <label class="control-label col-md-4">Medical : </label>
                    <div class="col-md-6">
                        <input type="text" name="medical_a" id="medical_a" value="<?php echo e($medical_a); ?>" onkeyup="calculate(this.value);" class="form-control">
                        <span class="help-block"></span>
                    </div>
                 </div>
				  <div class="col-md-6">	
					<label class="control-label col-md-4">Conveyance </label>
                    <div class="col-md-6">
                        <input type="text" name="convence_a" id="convence_a" value="<?php echo e($convence_a); ?>" onkeyup="calculate(this.value);"  class="form-control">
                        <span class="help-block"></span>
                    </div> 
                </div>  
				 <div class="col-md-6" id="convenfuel_hide" style="display:block;">	
					<label class="control-label col-md-4">Conveyance & Fuel Allowance :</label>
                    <div class="col-md-6">
                        <input type="text" name="f_allowance" id="f_allowance" value="<?php echo e($f_allowance); ?>"  onkeyup="calculate(this.value);" class="form-control">
                        <span class="help-block"></span>
                    </div>
                 </div>
				  <div class="col-md-6" id="npa_hide" style="display:block;">	
					<label class="control-label col-md-4">NPA :</label>
                    <div class="col-md-6">
                        <input type="text" name="npa_a" id="npa_a" value="<?php echo e($npa_a); ?>"  onkeyup="calculate(this.value);" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				 <div class="col-md-6" id="motorcyle_hide" style="display:block;">	
                    <label class="control-label col-md-4" id="motor_level">Motor-Cycle</label>
                    <div class="col-md-6">
                        <input type="text" name="motor_a" id="motor_a" value="<?php echo e($motor_a); ?>"  onkeyup="calculate(this.value);" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				 <div class="col-md-6" id="fieldallow_hide" style="display:block;">	
					<label class="control-label col-md-4">Field Allowance: </label>
                    <div class="col-md-6">
                        <input type="text" name="field_a" id="field_a" value="<?php echo e($field_a); ?>"  onkeyup="calculate(this.value);" class="form-control"> 
                        <span class="help-block"></span>
                    </div> 
                </div> 
				 <div class="col-md-6">	
				<label class="control-label col-md-4" id="mobile_level">Mobile : </label>
                    <div class="col-md-6">
                        <input type="text" name="mobile_a" id="mobile_a" value="<?php echo e($mobile_a); ?>"  onkeyup="calculate(this.value);" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
				 <div class="col-md-6" id="mobile_internet_hide" style="display:block;">	
                    <label class="control-label col-md-4"> Mobile & Internet : </label>
                    <div class="col-md-6"> 	  	       	 	 	 
                        <input type="text" name="internet_a" id="internet_a" value="<?php echo e($internet_a); ?>" onkeyup="calculate(this.value);"  class="form-control">
                        <span class="help-block"></span>
                    </div>
					
					
                </div>  
				<div class="col-md-6" id="maintenance_a_hide" style="display:block;">	
                    <label class="control-label col-md-4"> Maintenance Allowance: </label>
                    <div class="col-md-6"> 	  	       	 	 	 
                        <input type="text" name="maintenance_a" id="maintenance_a" value="<?php echo e($maintenance_a); ?>" onkeyup="calculate(this.value);"  class="form-control">
                        <span class="help-block"></span>
                    </div>
					
					
                </div> 
				 <div class="col-md-6">	
                    <label class="control-label col-md-4">Gross Salary:</label>
                    <div class="col-md-6">
                        <input type="text" name="gross_salary" id="gross_salary" readonly value="<?php echo e($gross_salary); ?>"  class="form-control">
                        <span class="help-block"></span>
                    </div> 
                </div> 
              </div> 
				
				<div class="box-footer"> 
					<button type="sublit" id="btnSave" class="btn btn-primary"><?php echo e($button_text); ?></button>					
				</div>
			</form>

		</div>
	</section>
	
	
	<script language="javascript">
		
	 function set_salary_branch(){
		var br_code = document.getElementById("br_code").value;  
		document.getElementById("salary_br_code").value = br_code;  
	 } 
	 function age_calculation() { 
		var birth_date = document.getElementById("birth_date").value;
		
			$.ajax({
				url : "<?php echo e(url::to('age_calculation')); ?>"+"/"+birth_date,
				type: "GET",
				success: function(data)
				{
					document.getElementById("present_age").value = data;
				}
			});  

	 }
	function myFunction() { 
		var emptype1 = document.getElementById("emp_type").value;
		var emptype = emptype1.split(",")[0];
		var is_field_reduce = emptype1.split(",")[1];
		 if(is_field_reduce == 1){
			 document.getElementById("blood_hide").style.display = "none"; 
			 document.getElementById("email_hide").style.display = "none"; 
			 document.getElementById("necessary_phone_hide").style.display = "none";
			 document.getElementById("contact_num_required").style.display = "none"; 
			 $('#contact_num').removeAttr('required'); 
			 document.getElementById("reference_phone_hide").style.display = "none"; 
			 document.getElementById("referrence_name_hide").style.display = "none"; 
			 document.getElementById("br_join_after_date_hide").style.display = "none"; 
			 document.getElementById("br_join_after_train_hide").style.display = "none"; 
			  if(emptype == 7){
				 document.getElementById("contract_end_hide").style.display = "block"; 
			 }else{
				 document.getElementById("contract_end_hide").style.display = "none";
				 document.getElementById("c_end_date").value = ''; 		
				 document.getElementById("end_type").value = 0; 		
			 } 
			 document.getElementById("houserent_hide").style.display = "none"; 
			 document.getElementById("medical_hide").style.display = "none"; 
			 document.getElementById("convenfuel_hide").style.display = "none"; 
			 document.getElementById("npa_hide").style.display = "none"; 
			 document.getElementById("motorcyle_hide").style.display = "none"; 
			 document.getElementById("fieldallow_hide").style.display = "none"; 
			 document.getElementById("mobile_internet_hide").style.display = "none";  
			 document.getElementById("maintenance_a_hide").style.display = "none";
			  
			 document.getElementById("house_rent").value = 0; 
			 document.getElementById("medical_a").value = 0; 
			 document.getElementById("convence_a").value = 0; 
			 document.getElementById("f_allowance").value = 0; 
			 document.getElementById("npa_a").value = 0; 
			 document.getElementById("motor_a").value = 0; 
			 document.getElementById("field_a").value = 0; 
			 document.getElementById("mobile_a").value = 0; 
			 document.getElementById("internet_a").value = 0; 
			 document.getElementById("maintenance_a").value = 0; 
			 document.getElementById("after_trai_join_date").value = ''; 
			 document.getElementById("referrence_name").value = ''; 
			 document.getElementById("reference_phone").value = ''; 
			 document.getElementById("nec_phone_num").value = ''; 
			 document.getElementById("blood_group").value = ''; 
			 document.getElementById("email").value = ''; 
			 document.getElementById("contact_num").value = ''; 
			 document.getElementById("after_trai_br_code").value = ''; 
			 
			 
			 	calculate(0);			
			  
		 }else{ 
			 document.getElementById("blood_hide").style.display = "block"; 
			 document.getElementById("email_hide").style.display = "block"; 
			 document.getElementById("contact_num_required").style.display = "block"; 
			 document.getElementById("necessary_phone_hide").style.display = "block";  
			 $('#contact_num').attr("required", true);   
			 document.getElementById("reference_phone_hide").style.display = "block"; 
			 document.getElementById("referrence_name_hide").style.display = "block"; 
			 document.getElementById("br_join_after_date_hide").style.display = "block"; 
			 document.getElementById("br_join_after_train_hide").style.display = "block";  
		     document.getElementById("contract_end_hide").style.display = "block";
			 document.getElementById("houserent_hide").style.display = "block"; 
			 document.getElementById("medical_hide").style.display = "block"; 
			 document.getElementById("convenfuel_hide").style.display = "block"; 
			 document.getElementById("npa_hide").style.display = "block"; 
			 document.getElementById("motorcyle_hide").style.display = "block"; 
			 document.getElementById("fieldallow_hide").style.display = "block"; 
			 document.getElementById("mobile_internet_hide").style.display = "block";  
			 document.getElementById("maintenance_a_hide").style.display = "block"; 
			calculate(0);			 
		 }
		
			$.ajax({
				url : "<?php echo e(url::to('get-non-max')); ?>"+"/"+emptype,
				type: "GET",
				success: function(data)
				{
					document.getElementById("sacmo_id").value=data;
				}
			});  
	}
</script>
	
	
	<script language="javascript">
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
					var plus_total =  (basic_salary + npa_a + motor_a + mobile_a + house_rent + medical_a + convence_a + f_allowance + field_a + internet_a + maintenance_a + console_salary);
			  } else {
					var plus_total =  (basic_salary + npa_a + motor_a + mobile_a + house_rent + medical_a + convence_a + f_allowance + field_a + internet_a + maintenance_a);
			  } 
			document.getElementById("gross_salary").value = plus_total;
			
		}
	</script>	

	<script>
		$(document).on("change", "#district_code", function () {
			var district_code = $(this).val();   
			$.ajax({
				url : "<?php echo e(url::to('select-thana')); ?>"+"/"+district_code,
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
		document.getElementById("district_code").value= "<?php echo e($district_code); ?>";
		document.getElementById("thana_code").value= "<?php echo e($thana_code); ?>";
		document.getElementById("br_code").value= "<?php echo e($br_code); ?>";
		document.getElementById("designation_code").value= "<?php echo e($designation_code); ?>";
		document.getElementById("emp_type").value= "<?php echo e($emp_type); ?>";
		document.getElementById("gender").value= "<?php echo e($gender); ?>";
		document.getElementById("religion").value= "<?php echo e($religion); ?>";
		document.getElementById("maritial_status").value= "<?php echo e($maritial_status); ?>";
		document.getElementById("blood_group").value= "<?php echo e($blood_group); ?>";
		
		
		function set_effect_date()
		{
			var joining_date = document.getElementById("joining_date").value;
			
			document.getElementById("effect_date").value = joining_date;
			document.getElementById("br_join_date").value = joining_date;
		}
		function change_contract_end_type()
		{
			 var end_type = document.getElementById("end_type");
				   
				  if (end_type.checked == true){
					   $('#c_end_date_lebel').html("Contract Ending Date:");
					  $('#c_end_date').attr("readonly", true);  
					  $('#c_end_date').removeAttr('required');
				  } else {
					  $('#c_end_date_lebel').html("Contract Ending Date: <span style='color:red;'>*</span>");
					$('#c_end_date').removeAttr('readonly');
					 $('#c_end_date').attr("required", true); 
					
				  }
			
		}
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>