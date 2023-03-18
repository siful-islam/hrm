<?php $__env->startSection('title', 'Leave Application'); ?>
<?php $__env->startSection('main_content'); ?>

	<!-- Content Header (Page header) -->
	<br>
	<br>
	<br>
	<section class="content-header">
		<h1>Employee<small>Leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Application</li>
		</ol>
	</section>
<style>
		 
</style>	 
	<!-- Main content --> 
<section class="content">	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			<?php if(Session::has('message')): ?>
			<?php echo e(session('message')); ?>

			<?php endif; ?>
		</h3>--> 
		<div id="wait" style="display:none;position:absolute;top:20%;left:45%;">
							<img src="<?php echo e(asset('/loading.gif')); ?>" width="150" height="150" />
						</div>
		<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" onsubmit="return change_with_pay()" method="POST" enctype="multipart/form-data">
			<?php echo e(csrf_field()); ?> 
			<input type="hidden" name="db_id" id="db_id"  class="form-control" value="<?php echo e($db_id); ?>">
			<input type="hidden" name="current_open_balance" id="current_open_balance" class="form-control" value="<?php echo e($current_open_balance); ?>" required >
			<input type="hidden"  id="pre_current_close_balance" class="form-control" value="<?php echo e($current_close_balance); ?>" >
			<input type="hidden" name="current_close_balance" id="current_close_balance" class="form-control" value="<?php echo e($current_close_balance); ?>" required >
			<input type="hidden" name="casual_leave_open" id="casual_leave_open" class="form-control" value="<?php echo e($casual_leave_open); ?>"> 
			<input type="hidden" name="pre_casual_leave_close" id="pre_casual_leave_close" class="form-control" value="<?php echo e($casual_leave_close); ?>"> 
			<input type="hidden" name="casual_leave_close" id="casual_leave_close" class="form-control" value="<?php echo e($casual_leave_close); ?>"> 
			<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="<?php echo e($emp_id); ?>" required> 
			<input type="hidden" name="branch_code" id="branch_code" class="form-control" value="<?php echo e($br_code); ?>" required>
			<input type="hidden" name="designation_code" id="designation_code" class="form-control" value="<?php echo e($designation_code); ?>"> 
			<input type="hidden" name="f_year_id" id="f_year_id" class="form-control" value="<?php echo e($f_year_id); ?>">  
			<input type="hidden" name="org_join_date" id="org_join_date" class="form-control" value="">  
			<input type="hidden" name="tot_earn_leave" id="tot_earn_leave" class="form-control" value="">  
			<input type="hidden" name="pre_cumulative_close" id="pre_cumulative_close" class="form-control" value="">  
			<input type="hidden" name="pre_pre_cumulative_close" id="pre_pre_cumulative_close" class="form-control" value="">  
			<input type="hidden" name="cum_close_balance" id="cum_close_balance" class="form-control" value="">   
			<input type="hidden" name="pre_cum_close_balance" id="pre_cum_close_balance" class="form-control" value="">   
			  
			<div id="html_display" class="box box-info">
					<div class="box-body">	
					
					  <div class="col-md-8">
										
						<div class="form-group"> 
							<label class="control-label col-md-2"> Financial Year:</label>
								<div class="col-md-2">
									<select name="f_year_start" id="f_year_start" class="form-control"  required>  
											
											<option value="<?php  echo $fiscal_year->id;?>" ><?php  echo date("Y",strtotime($fiscal_year->f_year_from)).'-'.date("Y",strtotime($fiscal_year->f_year_to));?></option> 
											
										 
									</select>
								</div> 
								<label class="control-label col-md-1">Emp ID :</label>
								<div class="col-md-2">
									<input type="text"  autocomplete="off"  name="employee_id" id="employee_id" onchange="get_emp_leave_info()" class="form-control" value=""  required>  
									<span class="help-block"></span>
								</div> 
								<div class="col-md-2">
									 <button onclick="get_emp_leave_info1()" class="btn btn-primary">Search</button>
									<span class="help-block"></span>
								</div> 
						</div> 
						<hr>
						<div class="form-group"> 
									<label class="control-label col-md-3">Serial No</label>
										<div class="col-md-3"> 
											<input type="text" name="serial_no"   class="form-control" value="<?php echo e($serial_no); ?>" readonly > 
											<input type="hidden" name="f_year_from" id="f_year_from" class="form-control" value="<?php echo e($fiscal_year->f_year_from); ?>" readonly required> 
											<span class="help-block"></span>
										</div> 
									<label class="control-label col-md-3">Application Date </label>
										<div class="col-md-3">
											<input type="text" onchange="calculate_earn_leave()"  autocomplete="off"  name="application_date"  id="application_date" class="form-control" value="<?php echo e($application_date); ?>" required>
											<span class="help-block"></span>
									</div> 
						</div> 
						<div class="form-group"> 
									<label class="control-label col-md-3">Leave Type </label>
										<div class="col-md-3">
											<select  name="type_id" class="form-control" onchange="change_leave_type();"  id="type_id" required > 
											<?php $__currentLoopData = $leave_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($type->id); ?>"><?php echo e($type->type_name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
										</div> 
										<label class="control-label col-md-3">Pay Type </label>
										<div class="col-md-3">
											<select  name="is_pay" class="form-control"  onchange="change_pay_type();"  id="is_pay" required > 
													<option value="1">With pay</option>
													<option value="2">Without pay</option>
												</select>
											<span class="help-block"></span>
										</div>  
								</div> 
												
					 
					<div class="form-group"> 
									<label class="control-label col-md-3">From </label>
										<div class="col-md-3">
											<input type="text" name="from_date"  autocomplete="off"  id="from_date" class="form-control" onchange="settotaldayfrom()" value="<?php echo e($from_date); ?>" required>
											<span class="help-block"></span>
										</div> 
							
									<label class="control-label col-md-3">To </label>
										<div class="col-md-3">
											<input type="text" autocomplete="off" name="to_date" id="to_date" class="form-control" onchange="settotalday()" value="<?php echo e($to_date); ?>" required>
											<span class="help-block"></span>
										</div> 
								</div> 
							<div class="form-group"> 
						
									<label class="control-label col-md-3">Remarks</label>
										<div class="col-md-3">
											 <input list="browsers" class="form-control" name="remarks" required value="<?php echo e($remarks); ?>" id="remarks">
											  <datalist id="browsers">
												<option value="Personal"> 
											  </datalist> 
											<span class="help-block"></span>
										</div> 
											<label class="control-label col-md-3">Total Leave Day/s</label>
											<div class="col-md-3">
												<input type="text" name="no_of_days" id="no_of_days" class="form-control" readonly value="<?php echo e($no_of_days_appr); ?>" required>
												<span class="help-block"></span>
											</div> 										
							</div>
							<div class="form-group"> 
									<label class="control-label col-md-3">Adjustment</label>
										<div class="col-md-3">
											<select  name="leave_adjust" id="leave_adjust"  class="form-control"  required > 
													<option value="1">Current</option>
													<option value="2">Cumulative</option> 
												</select>
										</div> 		
							</div> 		
						<div class="form-group"> 
							<label class="control-label col-md-3"></label>
								<div class="col-md-3 col-md-offset-6">
									<a href="<?php echo e(URL::to('/emp-leave')); ?>" class="btn bg-olive" >List</a>
									<button type="submit" id="submit" class="btn btn-primary"><?php echo e($button); ?></button>
									<span class="help-block"></span>
								</div>  
						</div>  
			</div>
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-body box-profile">
						 
						<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="<?php echo e(asset('public/employee/'.$emp_photo)); ?>" alt="User profile picture">
						<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
						<p class="text-muted text-center" id="designation_name"><?php echo e($designation_name); ?></p>
						<p class="text-muted text-center"><b>Org. Join Date:</b> <span id="org_join_date_view" ></span></p>
						 <ul class="list-group list-group-unbordered"><b>(Earn Leave)</b>
								<li class="list-group-item">
								 Total Previous Leave Balance(Cumulative) <p id="total_previous_leave_balance" class="pull-right">0</p> 
								</li> 
								<li class="list-group-item"> 
								 Total Current Year Leave( Current ) <p id="this_year_open_balance" class="pull-right"><?php if(!empty($current_open_balance)): ?><?php echo e($current_open_balance); ?> <?php else: ?> <?php echo e(0); ?> <?php endif; ?></p> 
								</li> 
								<li class="list-group-item">
								  Total Leave enjoy <p  id="total_leave_enjoy" class="pull-right"><?php if(!empty($no_of_days)): ?><?php echo e($no_of_days); ?> <?php else: ?> <?php echo e(0); ?> <?php endif; ?></p>
								  <input type="hidden" class="form-control" name="tot_expense" id="tot_expense" readonly value="<?php if(!empty($no_of_days)): ?><?php echo e($no_of_days); ?> <?php else: ?> <?php echo e(0); ?> <?php endif; ?>" >
								</li> 
								<li class="list-group-item">
								  Balance <p id="leave_remain1" class="pull-right"><?php echo e($leave_remain); ?></p>
								  <input type="hidden" name="leave_remain" id="leave_remain" class="form-control" readonly value="<?php echo e($leave_remain); ?>" >
								</li>
						  </ul> 
						  <ul class="list-group list-group-unbordered"><b>( Casual Leave )</b>
								<li class="list-group-item">
								  Casual Leave Balance <p id="total_casual_leave_balance" class="pull-right">0</p> 
								</li> 
								<li class="list-group-item">
								  Casual Leave enjoy <p  id="total_leave_enjoy_casual" class="pull-right">0</p> 
								</li> 
								<li class="list-group-item">
								 Casual Leave Balance <p id="leave_remain_casual" class="pull-right"></p>
								  
								</li>
						  </ul> 
					</div>
				</div>
			</div> 
			</div>
				</div>
		</form>
	</div>
</section>


	
	
<script type="text/javascript">
function calculate_earn_leave(){ 
		var f_year_from = document.getElementById("f_year_from").value;
		
		var application_date = document.getElementById("application_date").value;
		//alert(application_date);
		 var org_join_date = document.getElementById("org_join_date").value; 
		var tot_expense = parseFloat(document.getElementById("tot_expense").value);	
		var current_date =  new Date(); 
		var current_month = current_date.getMonth()+1;
		if( org_join_date >= f_year_from){ 
		
			if(isNaN(application_date)){
				var apply_date1 = new Date(application_date); 
			}else{
				var apply_date1 = current_date; 
			} 
			
			var org_join_date1 = new Date(org_join_date);
			var apply_date2 = new Date(apply_date1);
			
			 var month1=org_join_date1.getMonth();
			var year1=org_join_date1.getYear();
			
			var app_day = org_join_date.split("-")[2]; 

			var month2=apply_date2.getMonth();
			var year2=apply_date2.getYear(); 
			
			var diff=((year2*12)+month2)-((year1*12)+month1);
			var additional_day=0;
			if(diff != 0){
			    if(app_day <= '10'){
					additional_day = 1.5;
				}else if(app_day <= '20'){
					additional_day = 1;
				}else {
					additional_day = 0.5;
				}
			} 		

			if(diff < 0){
				var additional_day = -additional_day;
				var earn_leave = (diff + 1 ) * 1.5;  
			}else if(diff==0){
				var earn_leave = 0; 
			}else{
				var earn_leave = (diff -1 ) * 1.5; 
			} 
			//alert(app_day);
			var t_earn_leave = parseFloat(additional_day) + parseFloat(earn_leave);
			
			
		}else{ 
			
			if(isNaN(application_date)){
				var apply_date1 = new Date(application_date); 
			}else{
				var apply_date1 = current_date; 
			} 
			
			var f_year_from1 = new Date(f_year_from);
			var apply_date2 = new Date(apply_date1);
			
			 var month1=f_year_from1.getMonth();
			var year1=f_year_from1.getYear();
			
			 

			var month2=apply_date2.getMonth();
			var year2=apply_date2.getYear(); 
			
			var diff=((year2*12)+month2)-((year1*12)+month1);
 
			if(diff < 0){
				var t_earn_leave = (diff) * 1.5; 
			}else if(diff==0){
				var t_earn_leave = 0; 
			}else{
				var t_earn_leave = (diff) * 1.5; 
			}
			
			
			
			
		} 
		document.getElementById("tot_earn_leave").value = t_earn_leave;   
	} 
function change_emp_type(){
	document.getElementById("emp_photo").src = "";
		$('#employee_id').val('');   
		$('#emp_id').val('');
		$('#tot_expense').val('');
		$('#designation_code').val(''); 
		$('#branch_code').val(''); 						
		$('#leave_remain').val(0); 
		$('#current_open_balance').val(0);
		$('#current_close_balance').val(0);
		$('#pre_current_close_balance').val(0);
		$('#pre_cumulative_close').val(0);
		$('#pre_pre_cumulative_close').val(0);
		$('#cum_close_balance').val(0);
		$('#pre_cum_close_balance').val(0);
		$('#org_join_date').val('');						
		$('#total_leave_enjoy').html('');  
		$('#emp_name').html('');  
		$('#leave_remain1').html('');  
		$('#designation_name').html('');  
		$('#to_date').val(''); 
		$('#no_of_days').val(0); 
		$('#org_join_date_view').html('');  
		$('#total_previous_leave_balance').html('');  
		$('#this_year_open_balance').html('');  
}
 
function change_with_pay(){  
	var type_id 		= document.getElementById("type_id").value;
	var no_of_days 		= document.getElementById("no_of_days").value;
	var current_close_balance 		= document.getElementById("current_close_balance").value;
	var pre_cumulative_close 		= document.getElementById("pre_cumulative_close").value;
	var is_pay  					= document.getElementById("is_pay").value;
	var return_type 				= true;
	if(type_id == 5){
		if(no_of_days > 3){
				alert('Please Contact To HR !!!');
				return_type = false; 
			}
	}else{
		if(current_close_balance < 0){
			if(is_pay == 1){
				alert('Please Select Without pay !!!');
				return_type = false; 
			} 
		}else if(pre_cumulative_close < 0){
			if(is_pay == 1){
				alert('Please Select Without pay !!!');
				return_type = false; 
			}  
		}
	}
	
	calculate_earn_leave();
	 return return_type; 
 }
 function change_leave_type() {
			change_pay_type();			
	} 
function change_pay_type(){  
	 var is_pay  					= document.getElementById("is_pay").value;
	 var leave_adjust  				= document.getElementById("leave_adjust").value;
	 var type_id  				= document.getElementById("type_id").value;
	 var current_open_balance 		= parseFloat(document.getElementById("current_open_balance").value); 
	 var pre_current_close_balance 	= parseFloat(document.getElementById("pre_current_close_balance").value);
	 var tot_expense 				= parseFloat(document.getElementById("tot_expense").value);
	 var pre_cumulative_close 		= parseFloat(document.getElementById("pre_cumulative_close").value);
	 var pre_pre_cumulative_close 	= parseFloat(document.getElementById("pre_pre_cumulative_close").value);
	 var cum_close_balance 			= parseFloat(document.getElementById("cum_close_balance").value);
	 var pre_cum_close_balance 		= parseFloat(document.getElementById("pre_cum_close_balance").value);
	 var casual_leave_open 			= parseFloat(document.getElementById("casual_leave_open").value);
	 var pre_casual_leave_close 	= parseFloat(document.getElementById("pre_casual_leave_close").value);
	  var no_of_days 				= parseFloat(document.getElementById("no_of_days").value); 
	 if(is_pay == 2){
		 
		 document.getElementById("casual_leave_close").value  			= pre_casual_leave_close;
		 document.getElementById("current_close_balance").value  		= pre_current_close_balance;
		 document.getElementById("pre_cumulative_close").value 			=  pre_pre_cumulative_close;
	     document.getElementById("cum_close_balance").value 			=  pre_cum_close_balance; 
	 }else{
		 
		 if(leave_adjust == 1){ 
			 if(type_id == 5){
				 document.getElementById("casual_leave_close").value 	= pre_casual_leave_close - no_of_days; 
				 document.getElementById("current_close_balance").value = pre_current_close_balance; 
				 document.getElementById("pre_cumulative_close").value 	=  pre_pre_cumulative_close;
				 document.getElementById("cum_close_balance").value 		=  pre_cum_close_balance; 
			 }else{
				document.getElementById("current_close_balance").value 	= current_open_balance - (tot_expense + no_of_days); 
			    document.getElementById("pre_cumulative_close").value 	=  pre_pre_cumulative_close;
			    document.getElementById("casual_leave_close").value 	=  pre_casual_leave_close;  
			    document.getElementById("cum_close_balance").value 		=  pre_cum_close_balance;  
			 }
			  
		 }else{ 
			 document.getElementById("current_close_balance").value 	= pre_current_close_balance;
			 document.getElementById("pre_cumulative_close").value 		=  pre_pre_cumulative_close - no_of_days;
			 document.getElementById("cum_close_balance").value 		=  pre_cum_close_balance - no_of_days;
			 document.getElementById("casual_leave_close").value 		=  pre_casual_leave_close;
		 }
		 
		 
		
		
	 }
	 change_with_pay();
 }
 
$(document).on("change", "#leave_adjust", function () {
		change_pay_type();
});   
  
  function get_emp_leave_info1(){
	 var employee_id = document.getElementById("employee_id").value; 
	 // alert(employee_id);
	  if(employee_id == ''){ 
		  $("#employee_id").css("border-color", "#3C8DBC");
	  }else{
		 get_emp_leave_info();
	  }
  }
  
	function get_emp_leave_info(){ 
	var employee_id 			= document.getElementById("employee_id").value;
	if(employee_id != ''){
		$("#wait").css("display", "block");
		$("#html_display").css("display", "none");
		 
		var f_year_start 			= document.getElementById("f_year_start").value;
		//alert(f_year_start);
		  $.ajax({
			type: "GET",
			url : "<?php echo e(URL::to('get_emp_leave_info')); ?>"+"/"+employee_id+"/"+f_year_start, 
			dataType: "JSON",
			success: function(data)
			{ 
			$("#wait").css("display", "none");
			$("#html_display").css("display", "block");
			//console.log(data);
			//alert(data.emp_name); 
					if(data.is_current_br == 1){
						if((data.desig_group_code == 8) || ((data.desig_group_code == 11) && (data.designation_code != 246))){
								alert("This Leave is accessed by Head Office");
								document.getElementById("emp_photo").src = "";
								$('#emp_id').val('');
								$('#tot_expense').val('');
								$('#designation_code').val(''); 
								$('#branch_code').val(''); 						
								$('#leave_remain').val(0); 
								$('#current_open_balance').val(0);
								$('#current_close_balance').val(0);
								$('#casual_leave_open').val(0);
								$('#casual_leave_close').val(0);
								$('#pre_current_close_balance').val(0);
								$('#org_join_date').val('');	
								$('#org_join_date_view').html('');							
								$('#total_leave_enjoy').html('');  
								$('#emp_name').html('');  
								$('#leave_remain1').html('');  
								$('#designation_name').html('');  
								$('#to_date').val(''); 
								$('#no_of_days').val(''); 
								$('#this_year_open_balance').html(''); 
								$('#total_casual_leave_balance').html(''); 
								$('#total_leave_enjoy_casual').html(''); 
								$('#leave_remain_casual').html(''); 
								$('#total_previous_leave_balance').html(''); 
								$('#submit').attr("disabled", true); 
						}
					else if(data.emp_name)
					{  
						$('#submit').removeAttr('disabled');
						$('#emp_name').html(data.emp_name);
						  
						$('#total_casual_leave_balance').html(data.casual_leave_open); 
						$('#total_leave_enjoy_casual').html(data.casual_leave_open - data.casual_leave_close); 
						$('#leave_remain_casual').html(data.casual_leave_close); 
						$('#this_year_open_balance').html(data.current_open_balance); 
						$('#total_previous_leave_balance').html(data.pre_cumulative_close); 
						$('#total_leave_enjoy').html(data.tot_expense); 
						$('#designation_name').html(data.designation_name); 
						$('#org_join_date').val(data.joining_date);
						$('#org_join_date_view').html(data.joining_date_view);
						$('#current_open_balance').val(data.current_open_balance); 
						$('#current_close_balance').val(data.current_close_balance); 
						$('#pre_current_close_balance').val(data.current_close_balance); 
						$('#pre_cumulative_close').val(data.pre_cumulative_close); 
						$('#pre_pre_cumulative_close').val(data.pre_cumulative_close); 
						$('#cum_close_balance').val(data.cum_close_balance); 
						$('#pre_cum_close_balance').val(data.cum_close_balance); 
						$('#casual_leave_open').val(data.casual_leave_open);
						$('#pre_casual_leave_close').val(data.casual_leave_close);
						$('#casual_leave_close').val(data.casual_leave_close);
						$('#tot_expense').val(data.tot_expense); 
						$('#emp_id').val(data.emp_id);  
						$('#designation_code').val(data.designation_code); 
						$('#branch_code').val(data.br_code); 
						$('#to_date').val(''); 
						$('#no_of_days').val(''); 
						$('#leave_remain1').html(data.leave_remain); 
						$('#leave_remain').val(data.leave_remain); 
						
						document.getElementById("emp_photo").src = "<?php echo asset('public/employee/"+data.emp_photo+"'); ?>";	
					}
					else
					{  
						//$('#form').trigger("reset");
						document.getElementById("emp_photo").src = "";
						$('#emp_id').val('');
						$('#tot_expense').val('');
						$('#designation_code').val(''); 
						$('#branch_code').val(''); 						
						$('#leave_remain').val(0); 
						$('#current_open_balance').val(0);
						$('#current_close_balance').val(0);
						$('#pre_current_close_balance').val(0);
						$('#pre_cumulative_close').val(0);
						$('#pre_pre_cumulative_close').val(0);
						$('#cum_close_balance').val(0);
						$('#pre_cum_close_balance').val(0);
						$('#casual_leave_open').val(0);
						$('#casual_leave_close').val(0);
						$('#pre_casual_leave_close').val(0);
						$('#org_join_date').val('');						
						$('#org_join_date_view').html('');						
						$('#total_leave_enjoy').html('');  
						$('#emp_name').html('');  
						$('#leave_remain1').html('');  
						$('#designation_name').html('');  
						$('#to_date').val(''); 
						$('#no_of_days').val(''); 
						$('#total_casual_leave_balance').html(''); 
						$('#total_leave_enjoy_casual').html(''); 
						$('#leave_remain_casual').html(''); 
						$('#total_previous_leave_balance').html('');  
						$('#this_year_open_balance').html('');  
						$('#submit').attr("disabled", true); 
					}
				}else{
						alert("Employee is not in this Branch");
						document.getElementById("emp_photo").src = "";
						$('#emp_id').val('');
						$('#tot_expense').val('');
						$('#designation_code').val(''); 
						$('#branch_code').val(''); 						
						$('#leave_remain').val(0); 
						$('#current_open_balance').val(0);
						$('#current_close_balance').val(0);
						$('#pre_current_close_balance').val(0);
						$('#casual_leave_open').val(0);
						$('#casual_leave_close').val(0);
						$('#pre_casual_leave_close').val(0);
						$('#org_join_date').val('');	
						$('#org_join_date_view').html('');							
						$('#total_leave_enjoy').html('');  
						$('#emp_name').html('');  
						$('#leave_remain1').html('');  
						$('#designation_name').html('');  
						$('#to_date').val(''); 
						$('#no_of_days').val(''); 
						$('#total_casual_leave_balance').html(''); 
						$('#total_leave_enjoy_casual').html(''); 
						$('#leave_remain_casual').html(''); 
						$('#this_year_open_balance').html(''); 
						$('#total_previous_leave_balance').html(''); 
						$('#submit').attr("disabled", true); 
				}   
			}
		}); 
	}
		
		
	}
	
	
</script>  
<script language="javascript">
 function settotalday(){   
	 var from_date         		=$('#from_date').datepicker('getDate');
	 var to_date          		=$('#to_date').datepicker('getDate');
		 if (from_date <= to_date) {
			  /* var day   = (to_date - from_date)/1000/60/60/24;
			  var days =day+1;  */
			  var days = parseFloat(document.getElementById("no_of_days").value);
			  $('#no_of_days').val(days);
			  
			  
			 // alert(to_date);
			  
			  
			  settotalday1();
			  
		}else{
			$('#to_date').val(''); 
		}
 }
 function settotalday1(){
   
	 
	var from_date =document.getElementById("from_date").value;  
	var to_date =document.getElementById("to_date").value; 
	var emp_id =$("#emp_id").val(); 
	
	// var dataString = 'employee_id='+employee_id;
 
		//alert(db_id);
		$.ajax({
				type:'get',
				url : "<?php echo e(URL::to('leave_date_exist_br')); ?>"+"/"+from_date+"/"+to_date+"/"+emp_id,
				success:function(res){
					 
					 if(res['is_leave_date'] == 1){
						 document.getElementById("no_of_days").value = 0; 
						 $("#submit").attr('disabled', 'disabled').css('background-color','#DEE0E2');
						alert("This Date Already Exist !!");
							
					}else{
							if(res['flag'] == 0){
								document.getElementById("no_of_days").value = 0; 
								$("#submit").attr('disabled', 'disabled').css('background-color','#DEE0E2');
								alert("There is no date during this period.");
							}else{
								document.getElementById("no_of_days").value = res['days'];
									$("#submit").removeAttr('disabled');
									$("#submit").css("background-color",""); 
									change_pay_type();
							}
						
					}
					 
			}
		})  
	 
			
 }
 </script>
 <script>
 function settotaldayfrom(){
	    $('#to_date').val(document.getElementById("from_date").value);
		settotalday();
 } 
 </script>
<script type="text/javascript"> 
document.getElementById('type_id').value = "<?php echo e($type_id); ?>";
document.getElementById('is_pay').value = "<?php echo e($is_pay); ?>";
$(document).ready(function() {
	 var year = '<?php echo e($fiscal_year->f_year_from); ?>';
	$('#from_date').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true, 
		minDate: new Date(year)
	});
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#application_date').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true, 
		minDate: new Date(year)
		});
});
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Leave_Application").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>