
<?php $__env->startSection('title', 'Add Experience Certificate'); ?>
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Testimonial<small>add</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Testimonial</a></li>
			<li class="active">add</li>
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
				<form   action="<?php echo e(URL::to('/emp_info_testimony')); ?>" method="post" enctype="multipart/form-data" id="form1">
					  <?php echo e(csrf_field()); ?>  
					<div class="row">   
						<div class="col-md-3">
							<div class="form-group"> 
								<label class="control-label col-md-4">Employee ID :</label>
									<div class="col-md-6">
										<input type="text"  name="employee_id" id="employee_id"  class="form-control"  value="<?php // echo $employee_id; ?>" required  <?php // echo $mode_em_id;?>/>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div> 
						<div class="col-md-2">
							<div class="form-group">   
								<input type="submit" class="btn btn-primary"  value="Search" id="search"/>
								<span class="help-block"></span> 
							</div> 
						</div>  
					</div>   
				</form> 
			
			<?php if(!empty($employee_his)){?>
				<br>
				<br>
				<form class="form-horizontal" onsubmit="return is_check_resign();" action="<?php echo e(URL::to('/insert_emp_testimony')); ?>" role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?> 
						<div class="box-body"> 
							 <input type="hidden" name="letter_date" id="letter_date" value="<?php echo e($letter_date); ?>" class="form-control">  
							 <input type="hidden" name="emp_id" id="emp_id" value="<?php echo e($emp_id); ?>" class="form-control"> 
							 <input type="hidden" name="t_date" id="t_date" value="<?php echo e($t_date); ?>" class="form-control">  
							 <input type="hidden" name="pre_designation_code" id="pre_designation_code" value="<?php echo e($pre_designation_code); ?>" class="form-control"> 
							 <input type="hidden" name="branch_code" id="branch_code" value="<?php echo e($branch_code); ?>" class="form-control"> 
							 <input type="hidden" name="designation_code" id="designation_code" value="<?php echo e($designation_code); ?>" class="form-control"> 
							 <input type="hidden" name="serial_no" id="serial_no" value="<?php echo e($serial_no); ?>" class="form-control"> 
							 <input type="hidden" name="ye_ar" id="ye_ar" value="<?php echo e($ye_ar); ?>" class="form-control"> 
								<div class="row">  
									<div class="col-md-11 col-md-offset-1">
										<div class="form-group"> 
												<div class="col-md-10" style="text-align:justfy;text-justify: inter-word;">
												<br>
												<span class="pull-left"  style="font-size:20px;">
													<?php $ff = date('m/d/Y'); echo date("F d,  Y",strtotime($ff)); ?>
												</span> 
												<br>
												<br>
												<br>
												<span style="font-size:20px;">
													SL No. <?php echo $serial_no; ?>/<?php echo $ye_ar; ?>
												</span>
												<br>
												<br> 
												<h3 style="text-align:center; font-size:24px;"><u>TO WHOM IT MAY CONCERN</u></h3>
												<br>
												<br>
												<br>
												<span style="text-align: justify;text-justify: inter-word;font-size:20px;">
													This is to certify that <?php if($gender == 'male' || $gender == 'Male' ){ echo 'Mr.'; } else { echo 'Ms.'; }?><b> <?php echo $employee_his->emp_name;?></b>, ID No. <b><?php echo $employee_his->emp_id;?></b>,  Father's Name: <b><?php  echo 'Mr. '; ?><?php echo $employee_his->father_name;?></b>, Village-  <b><?php echo $employee_his->vill_road;?></b>, Post-<b><?php echo $employee_his->post_office;?></b>, P.S- <b><?php echo $employee_his->thana_name;?></b>, Dist- <b><?php echo $employee_his->district_name;?></b> joined the organization on <b> <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime($employee_his->joining_date));?> </b> as <b><?php echo $employee_his->pre_designation_name;?></b>
													
													<?php if($employee_his->designation_code == $employee_his->pre_designation_code){?>
														and continued till  <b> <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime('-1 day', strtotime($employee_his->effect_date)));?></b> in the same position.
														<br>
														<br>
														<?php if(($resignation_by =="Self")||($resignation_by =="Organization")) {  if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ; }else { if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ;} ?>
														
													<?php }else{ ?>
														. Subsequently  <?php if($gender == 'male' || $gender == 'Male' ){ echo 'he'; } else { echo 'She'; }?>  was promoted and lastly worked as <b><?php echo $employee_his->designation_name;?></b>  till  <b> <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F Y",strtotime('-1 day', strtotime($employee_his->effect_date)));?></b>.
														<br>
														<br>
														<?php if(($resignation_by =="Self")||($resignation_by =="Organization")) {  if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ; }else { if($gender == 'male' || $gender == 'Male' ){ echo 'He'; } else { echo 'She'; } echo " left the organization on "; if($gender == 'male' || $gender == 'Male' ){ echo 'his'; } else { echo 'her'; } echo " own accord." ;} ?>
													<?php } ?>
													
													
													
													<br>
													<br>
													<br>
													<?php if(($resignation_by == "Self")||($resignation_by =="Organization")){?>
													We wish  <?php if($gender == 'male' || $gender == 'Male' ){ echo 'him'; } else { echo 'her'; }?> all the success in life.
													<?php } ?>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
													<br>
												</span>	
												<span>	
													<h3>Authorized signature</h3>
													<br> 
												<br>
												<br>
												</span>
												<span>
												<input type="submit" id="submit_btn" class="btn btn-primary" value="<?php echo e($button); ?>">
													<a href="<?php echo e(URL::to('/testimony')); ?>" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
													</span>
												</div>  
										</div> 
									</div> 
								</div>    
						</div> 
					</form>
			<?php } ?>
		</div>
	</section>
<script>
function is_check_resign(){  
	var designation_code = document.getElementById("designation_code").value; 
	//alert(designation_code);
	var return_type = true;
	if(designation_code == ""){
		alert('This Employee is not Resigned');
		return_type = false; 
	}else{
		
		var emp_id = document.getElementById("emp_id").value; 
		//alert("This Date Already Exist !!");
		$.ajax({
				type:'get',
				url : "<?php echo e(URL::to('duplicate_certificate_check')); ?>"+"/"+emp_id,
				async: false,
				success:function(res){
					//alert(res);
					 if(res == 1){
						 return_type = false; 
						 $("#submit_btn").attr('disabled', 'disabled').css('background-color','#DEE0E2');
						alert("Certification is already given!!");
							
					}else{
						return_type = true; 
						 $("#submit_btn").removeAttr('disabled');
						 $("#submit_btn").css("background-color",""); 
					}  
			}
		}) 
	}
	 return return_type; 
 }
</script>
<script type="text/javascript">  
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupExperience_Certificate").addClass('active');
			$("#Certificate").addClass('active');
		});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>