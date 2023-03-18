
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
				  <input type="hidden" name="emp_id" id="emp_id" value="<?php echo e($emp_id); ?>" class="form-control">
				<div class="form-group">
                    
					<label class="control-label col-md-2">Emp Type: <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
						<select class="form-control" style="pointer-events:none;" name="emp_type" id="emp_type"  required>
							<option value="" hidden>Emp Type</option>
							<?php foreach($all_emp_type as $v_emp_type){?>
								<option value="<?php echo  $v_emp_type->id;?>"><?php echo  $v_emp_type->type_name;?></option>
							<?php } ?>
						</select>
                        <span class="help-block"></span>
                    </div> 
					<label class="control-label col-md-2">Employee Name : <span style="color:red;">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="emp_name" id="emp_name" value="<?php echo e($emp_name); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
			  </div>

				<div class="form-group">
					<label class="control-label col-md-2">Mother's Name : <span style="color:red;">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="mother_name" id="mother_name" value="<?php echo e($mother_name); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
                               
					<label class="control-label col-md-2">Father's Name: <span style="color:red;">*</span></label>
                    <div class="col-md-3">
                        <input type="text" name="father_name" id="father_name" value="<?php echo e($father_name); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2">Birth Date :<span style="color:red;">*</span></label>
                    <div class="col-md-3">
                        <input type="date" name="birth_date" id="birth_date" onchange ="age_calculation()" value="<?php echo e($birth_date); ?>" class="form-control" required>
                        <span class="help-block"></span>
                    </div>
                                
					<label class="control-label col-md-2">Present Age :</label>
                    <div class="col-md-3">
                        <input type="text" name="present_age" id="present_age" value="" class="form-control">
                        <span class="help-block"></span>
                    </div>
				 </div>
				<div class="form-group">	
					<label class="control-label col-md-2">Gender: <span style="color:red;">*</span></label>
						<div class="col-md-3">
							<select name="gender" id="gender" required class="form-control">
								<option value="male">Male</option>
								<option value="female">Female</option>
								
							</select>
							<span class="help-block"></span>
						</div>
			   
                    <label class="control-label col-md-2">Nationality: </label>
                    <div class="col-md-3">
                        <input type="text" name="nationality" id="nationality" value="<?php echo e($nationality); ?>"  class="form-control">
                        <span class="help-block"></span>
                    </div>
				</div>

				<div class="form-group">
					 
                    <label class="control-label col-md-2">National ID: </label>
                    <div class="col-md-3">
                        <input type="text" name="national_id" id="national_id" value="<?php echo e($national_id); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>  
					<label class="control-label col-md-2">Birth Certificate: </label>
                    <div class="col-md-3">
                        <input type="text" name="birth_certificate" id="birth_certificate" value="<?php echo e($birth_certificate); ?>" class="form-control">
                        <span class="help-block"></span>
                    </div>
				  </div>

				<div class="form-group">	
					<label class="control-label col-md-2">Religion : <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        <select name="religion" id="religion" required class="form-control">
							<option value="">--Select--</option>
							<?php foreach ($allreligions as $religionid => $religionname) { ?>						
							<option value="<?php echo $religionid; ?>"><?php echo $religionname; ?></option>
							<?php } ?>
						</select>
                        <span class="help-block"></span>
                    </div> 
                    <label class="control-label col-md-2">Contact Number: <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        <input type="text" name="contact_num" id="contact_num" value="<?php echo e($contact_num); ?>" required class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div> 
				<div class="form-group">
					<label class="control-label col-md-2">Present Address : </label>
                    <div class="col-md-3">
						<textarea class="form-control" name="present_add" id="present_add"><?php echo e($present_add); ?></textarea>
                        <span class="help-block"></span>
                    </div>
                    <label class="control-label col-md-2">Permanent Address : <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
						<textarea  class="form-control" name="permanent_add" id="address" required><?php echo e($permanent_add); ?></textarea>
                        <span class="help-block"></span>
                    </div> 
                </div>
				<div class="box-header with-border">
					<h3 class="box-title">Others Information</h3>
				</div><br>
				
				<div class="form-group"> 
					<label class="control-label col-md-2">Branch Joining Date: <span style="color:red;">*</span> </label>
                    <div class="col-md-3">
                        <input type="date" name="joining_date" id="joining_date" value="<?php echo e($joining_date); ?>" required class="form-control">
                        <span class="help-block"></span>
                    </div> 
					<label class="control-label col-md-2">Consolidated Salary:<span style="color:red;">*</span></label>
						<div class="col-md-3">
							 
							<input type="text"   name="console_salary" required  id="console_salary" value="<?php echo e($console_salary); ?>"  class="form-control"> 
							<span class="help-block"></span>
						</div>	
				</div>  
				<div class="box-footer"> 
					<button type="sublit" id="btnSave" class="btn btn-primary"><?php echo e($button_text); ?></button>					
				</div>
			</form>

		</div>
	</section>
<script language="javascript"> 
age_calculation(); 
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
</script>
	<script>
		document.getElementById("emp_type").value= "<?php echo e($emp_type); ?>";
		document.getElementById("gender").value= "<?php echo e($gender); ?>";
		document.getElementById("religion").value= "<?php echo e($religion); ?>";
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>