
<?php $__env->startSection('title', 'Add Movement'); ?>
<?php $__env->startSection('main_content'); ?>  
 <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')); ?>">
<style>
		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			background-color: #3c8dbc;
			border-color: #367fa9;
			padding: 1px 10px;
			color: #fff;
}
</style>	
	
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Movement<small>Register</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Movement</a></li>
			<li class="active">Register</li>
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
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?> 
                <?php echo $method_control; ?> 
				<FIELDSET>  
					<LEGEND class="col-md-9 col-md-offset-1" style="padding-left:0px;"><b>Movement Information</b></LEGEND>
						<div class="box-body">  
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Visit Type</label>
											<div class="col-md-6">
												 <select  onchange="change_visit_type();" name="visit_type" id="visit_type" class="form-control" required>  
														<option value="1">Branch</option>  
														<option value="2">Local</option>  
												</select>
											</div> 
									</div> 
								</div>  
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Purpose </label>
											<div class="col-md-6">
												 <input type="text" name="purpose" id="purpose" class="form-control" value="<?php echo e($purpose); ?>"  required>
											</div> 
									</div> 
								</div>
							</div>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Destination</label>
											<div class="col-md-6">
												<span id="branch_destination">
													<select  name="destination_code[]" multiple="multiple"   id="destination_code" class="form-control  select2" required> 
														<?php $__currentLoopData = $branch_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($branch->br_code); ?>" <?php if(in_array($branch->br_code, $destination_code)){ echo "selected";}?>><?php echo e($branch->branch_name); ?></option> 
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
														
													</select>
												</span> 
											</div> 
									</div> 
								</div> 
								
							</div>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">From Date</label>
											<div class="col-md-6">
												<input type="text" name="from_date" id="from_date" autocomplete="off" class="form-control <?php echo e($common_date); ?>" onchange="settotaldayfrom()"   value="<?php echo e($from_date); ?>" required>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
								<div class="form-group"> 
										<label class="control-label col-md-4">To Date</label>
											<div class="col-md-6">
												<input type="text" name="to_date"  id="to_date" autocomplete="off" onchange="settotalday()"  class="form-control <?php echo e($common_date); ?>" value="<?php echo e($to_date); ?>" required>
											</div> 
									</div> 
									 
								</div>  
							</div>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Day/s </label> 
											<div class="col-md-6">
												<input type="text" name="tot_day" id="tot_day" readonly  class="form-control" value="<?php echo e($tot_day); ?>"  required> 
												<span class="help-block" id="error1"></span>
												
											</div>
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave Time </label>
											<div class="col-md-6">
												<input  type="time" id="leave_time" name="leave_time"  value="<?php echo e($leave_time); ?>" class="form-control" required>
												
											</div>
									</div>  
								</div>  
							</div>
							<?php if($approved == 1): ?>
							<div class="row"> 
								<div class="col-md-5 col-md-offset-1">
									<div class="form-group"> 
										<label class="control-label col-md-4">Arrival Date</label>
											<div class="col-md-6">
												<input type="text" required name="arrival_date" id="arrival_date"  class="form-control common_date" value="<?php echo e($arrival_date); ?>">
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Arrival Time </label> 
											<div class="col-md-6">
												<input  type="time" required id="arrival_time" name="arrival_time"  value="<?php echo e($arrival_time); ?>" class="form-control" >
												
											</div>
									</div> 
								</div>  
							</div>
							<?php endif; ?>
							<div class="row">  
								<div class="col-md-5 col-md-offset-6">
									<div class="form-group"> 
										<label class="control-label col-md-4"></label>
											<div class="col-md-6">
												<button type="submit" class="btn btn-primary"><?php echo e($button); ?></button>
												<a href="<?php echo e(URL::to('movement/')); ?>" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
											</div> 
									</div> 
								</div>
							</div>  
						</div> 
				</FIELDSET>  
			</form>
		</div>
	</section> 
	
<script src="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>
<script>
 
 $('.select2').select2();

 function settotaldayfrom(){
	    $('#to_date').val(document.getElementById("from_date").value);
		settotalday();
 }  
/* $('.timepicker1').timepicker();  */
function settotalday(){  
	 var from_date         		=$('#from_date').datepicker('getDate');
	 var to_date          		=$('#to_date').datepicker('getDate');
		 if (from_date <= to_date) {
			  var day   = (to_date - from_date)/1000/60/60/24;
			  var days =day+1;  
			  $('#tot_day').val(days);
			  $('#error1').html("");
		 }else{
			 $('#error1').html("<b style='color:red;font-size:12px;'>From date must be less or equal!</b>");
			  $('#to_date').val(""); 	
		 }
}  
</script>
<script>
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});   
</script>
		<script>
			//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupTravel").addClass('active');
				$("#Add_Movement").addClass('active');
			});
		</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>