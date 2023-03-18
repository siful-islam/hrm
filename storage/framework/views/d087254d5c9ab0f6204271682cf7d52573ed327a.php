
<?php $__env->startSection('title', 'Contractual | Renew Info'); ?>
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Renew Information <small>All contractual Renew info</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Renew Information</a></li>
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
				<h3 class="box-title"> Renew Information </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
			<form id="form" class="form-horizontal" <?php if(empty($mode)){?>  onsubmit="return validateForm()" <?php } ?> name="employee_nonid" action="<?php echo e(URL::to($action)); ?>" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>	 
				<?php echo $method_control; ?>  
				<input type="hidden" class="form-control" id="tra_id" name="tra_id" value="">  
				<input type="hidden" class="form-control" id="sarok_no" name="sarok_no" value="<?php echo e($sarok_no); ?>">  
				<div class="box-body col-md-8">	
					
					<div class="form-group">
						
						<label for="emp_id" class="col-sm-3 control-label">Employee ID <span style="color:red;">*</span> </label>
						<div class="col-sm-3">
							<input type="text" class="form-control" <?php if($mode == 'edit'){?> readonly <?php } ?> id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>" onChange="get_employee_info();" required> 
						</div>
						
					</div> 
					<div class="form-group">
					 <label class="control-label col-md-3">Contract Renew Date: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<input type="date" name="next_renew_date" id="next_renew_date" value="<?php echo e($next_renew_date); ?>" required class="form-control">
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3" id="c_end_date_lebel">Contract Ending Date:  </label>
						<div class="col-md-3">
							<input type="date" name="c_end_date" <?php if(empty($c_end_date)){ ?>  readonly <?php }  ?> id="c_end_date" value="<?php echo e($c_end_date); ?>" class="form-control">
							<span class="help-block">Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_contract_end_type()" name="end_type" id="end_type" value="" <?php if(empty($c_end_date)){ ?> checked <?php }  ?>></span>
						</div>
					</div> 
					<hr>
					<div class="form-group">
						<div class="col-sm-3"> 
							<button type="submit" id="submit" class="btn btn-danger"><?php echo e($button_text); ?></button>
						</div>
					</div>
				</div>	
				<div class="col-md-4">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
							<p class="text-muted text-center" id="designation_name"><?php echo e($designation_name); ?></p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date_view"> <?php if($joining_date): ?> <?php echo e(date("d-m-Y",strtotime($joining_date))); ?> <?php endif; ?> </span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name"> <?php echo e($branch_name); ?> </span>
								</li>
							</ul>
							<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
						</div>
						<!-- /.box-body -->
						<div>  
						</div>				
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">
					
				</div>
				<!-- /.box-footer -->
			</form>
		</div>
	</section>
	
	
	<script language="javascript"> 
	function validateForm()
		{
			var emp_id = document.getElementById("emp_id").value; 
			var effect_date = document.getElementById("next_renew_date").value;
			var succeed = false;
			//alert(emp_id);
			$.ajax({
				url : "<?php echo e(url::to('check_contract_effect_date')); ?>"+"/"+ emp_id+"/"+ effect_date,
				type: "GET",
				async: false,
				success: function(data)
				{
					//alert(data);
					 if(data == 1){
						 alert("Effect Date is than the previous Effect Date. Please Delete The previous Entry");
						  succeed = false;
					 }else{
						 succeed = true; 
					 }
				}
			}); 
			return succeed;
		} 
	 
	function get_employee_info()
		{
			var emp_id = document.getElementById("emp_id").value; 
			if(emp_id >= 200000){
				
			
			$.ajax({
				url : "<?php echo e(URL::to('get_nonemployee_contract_info')); ?>"+"/"+ emp_id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
					//alert(data.emp_name);
					if(data.emp_name)
					{ 
						if(isNaN( data.resign_date)){ 
							$('#employee_status').html('<b>This Employee Terminated</b>');
							$("#employee_status").removeClass("btn btn-primary btn-block");
							$("#employee_status").addClass("btn btn-danger btn-block");
							$('#submit').attr("disabled", true);
						}else{ 
							$('#employee_status').html('<b>Active Employee</b>');
							$("#employee_status").removeClass("btn btn-danger btn-block");
							$("#employee_status").addClass("btn btn-primary btn-block");
							$('#submit').removeAttr('disabled');
						}
						$('#emp_name').html(data.emp_name); 
						$('#designation_name').html(data.designation_name);  
						$('#designation_name').html(data.designation_name);
						$('#branch_name').html(data.branch_name);
						$('#joining_date_view').html(data.joining_date);
						$('#emp_id').val(data.emp_id);  
						$('#tra_id').val(data.tra_id);  
					}
					else
					{  
						$('#form').trigger("reset");  
						$('#emp_id').val(data.emp_id); 
						$('#emp_name').html(''); 
						$('#branch_name').html('');
						$('#designation_name').html(''); 
						$('#joining_date_view').html(''); 
						$('#tra_id').val('');   
						$('#submit').attr("disabled", true);
						$('#employee_status').html('<b>Employee is not Available</b>');
						$("#employee_status").removeClass("btn btn-primary btn-block");
						$("#employee_status").addClass("btn btn-danger btn-block");
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#employee_status').html('This Employee is not Available');
					//$('#submit').attr("disabled", true);
				}
			});
			}else{
				alert("Employee ID must be less than 200000");
			}
		}
		function change_contract_end_type()
		{
			 var end_type = document.getElementById("end_type");
				   
				  if (end_type.checked == true){
					   document.getElementById("c_end_date").value = "";
					   $('#c_end_date_lebel').html("Contract Ending Date:");
					  $('#c_end_date').attr("readonly", true);  
					  $('#c_end_date').removeAttr('required'); 
					 // alert('ok');
					
				  } else {
					  $('#c_end_date_lebel').html("Contract Ending Date: <span style='color:red;'>*</span>");
					$('#c_end_date').removeAttr('readonly');
					 $('#c_end_date').attr("required", true); 
					 
					
				  }
			
		}
 <?php if($mode == 'edit'){ ?>
	 
	 change_contract_end_type();
 <?php }?>  
	</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Contractual_Renew").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>