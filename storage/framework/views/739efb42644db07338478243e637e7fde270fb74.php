
<?php $__env->startSection('main_content'); ?>
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Password<small> 
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Password</a></li>
			<li class="active">Change</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info"> 
			<div class="row">  
			 <?php
				$message=Session::get('message');
				 
				if($message)
				{ ?>
					<h3   style="color:green;text-align:center;padding-right:20%;"><?php echo $message; ?></h3> 
			   <?php Session::put('message',''); } 
			?> 
					<div class="col-sm-10 col-sm-offset-2">  
						<!-- form start -->
						<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" onsubmit="return validateForm()"   role="form" method="POST" enctype="multipart/form-data">
						<?php echo e(csrf_field()); ?>  
						  <div class="box-body">
							<div class="form-group">
							  <label for="old_password" class="col-sm-2 control-label">Old Password</label>

							  <div class="col-sm-3">
								<input type="password" required class="form-control" autocomplete="off" id="old_password" name="old_password" value="">
							  </div>
							</div> 
							<div class="form-group">
							  <label for="new_password" class="col-sm-2 control-label">New Password</label>

							  <div class="col-sm-3">
								<input type="password" required class="form-control" autocomplete="off" id="new_password" name="new_password" value="">
							  </div>
							</div>
							<div class="form-group">
							  <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>

							  <div class="col-sm-3">
								<input type="password" required class="form-control" autocomplete="off" id="confirm_password" name="confirm_password" value="">
							  </div>
							</div> 
						  </div> 
						 <div class="form-group">
						 
							<div class="col-sm-3 col-sm-offset-2"> 
								<button type="submit" class="btn btn-info">Save</button> 
							</div>
						</div> 
						</form>  
					  </div> 
			  </div>
          </div>
	</section> 
<script>
function validateForm() {  

				var old_password = document.getElementById("old_password").value; 
				var new_password  = document.getElementById("new_password").value;
				var confirm_password  = document.getElementById("confirm_password").value;  
				/* alert(old_password);
				alert(new_password);
				alert(confirm_password); */
				var succeed = false;
				if(new_password == confirm_password){
					$.ajax({
						type:'get',
						async: false,
						url : "<?php echo e(URL::to('check_password_old')); ?>"+"/"+old_password, 
						success:function(res){ 
							//alert(res);
							 if(res == 1){   
								succeed = true; 
							}else{ 
								alert("Old Password is not Valid");
								succeed = false;
							} 
						}
					});   
				}else{ 
					alert("confirm password is Wrong!!!!");
					succeed = false;
				}
				
				return succeed;   
			}  
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>