@extends('admin.admin_master')
@section('title', 'Add Leave')
@section('main_content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Approved<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Approved</li>
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
			<?php if(!empty($employee_his)){?> 
				<form class="form-horizontal" onsubmit="return check_leave_exist();" action="{{URL::to('/insert_aprove_leave_byhrm')}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
				<input type="hidden" name="application_id"  class="form-control" value="{{$application_id}}" readonly >
				<input type="hidden" name="f_year_id" id="f_year_id" class="form-control" value="{{$f_year_id}}" readonly >
				<input type="hidden"   id="f_year_from" class="form-control" value="{{$f_year_from}}" readonly >
				<input type="hidden"  name="emp_type" id="emp_type1" class="form-control" value="{{$emp_type}}" readonly >
				  
				<input type="hidden" name="current_open_balance" id="current_open_balance" class="form-control" value="{{$current_open_balance}}" readonly required>
				<input type="hidden" name="pre_cumulative_open" id="pre_cumulative_open"  class="form-control" value="{{$pre_cumulative_open}}" readonly required> 
				<input type="hidden" name="cum_balance" id="cum_balance"  class="form-control" value="{{$cum_balance}}" readonly required> 
				 
                <fieldset class="col-md-offset-1">
						<LEGEND class="col-md-9" style="padding-left:0px;"><b> Employee Information</b></LEGEND>
						<div class="box-body"> 
								<div class="row"> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4"> Financial Year:</label>
												<div class="col-md-6">
													<select name="f_year_start" id="f_year_start" class="form-control" style="pointer-events:none;" required>  
														 
															<option value="<?php  echo $fiscal_year->id;?>" ><?php  echo date("Y",strtotime($fiscal_year->f_year_from)).'-'.date("Y",strtotime($fiscal_year->f_year_to));?></option>  
													</select>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Emp Type:</label>
												<div class="col-md-6">
													<select name="emp_type" id="emp_type" required class="form-control" style="pointer-events:none;" > 
														
														<?php foreach($all_emp_type as $v_emp_type){?>
															<option value="<?php echo  $v_emp_type->id;?>"><?php echo  $v_emp_type->type_name;?></option>
														<?php } ?> 
													</select>
												</div> 
										</div> 
									</div> 
								</div> 
								<div class="row"> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Employee ID</label>
												<div class="col-md-6">
													<input type="text" name="emp_id" id="emp_id" class="form-control" value="{{$employee_his['emp_id']}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Employee Name </label>
												<div class="col-md-6">
													<input type="text" name="emp_name_eng" class="form-control" value="{{$employee_his['emp_name']}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
								</div>  
								<div class="row"> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Designation</label>
												<div class="col-md-6">
													<input type="text" class="form-control" value="{{$employee_his['designation_name']}}" readonly required>
													<input type="hidden" name="designation_code"  class="form-control" value="{{$employee_his['designation_code']}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Working Station</label>
												<div class="col-md-6">
													<input type="text"   readonly  class="form-control" value="{{$employee_his['branch_name']}}" required>
													<input type="hidden" name="branch_code" readonly  class="form-control" value="{{$employee_his['br_code']}}" required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
								</div>
						</div>
					</fieldset> 
				
				<FIELDSET class="col-md-offset-1">  
					<LEGEND class="col-md-9" style="padding-left:0px;"><b>Leave Information</b></LEGEND>
						<div class="box-body">  
							<div class="row">  
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Application Date </label>
											<div class="col-md-6">
												<input type="text" name="application_date" autocomplete="off"  id="application_date"  class="form-control" value="{{$application_date}}"  required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Serial No</label>
											<div class="col-md-6">
												<input type="text" name="serial_no"      class="form-control" value="{{$serial_no}}"  required> 
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
							</div>  
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;">Total Leave balance</label>
											<div class="col-md-6">
												<input type="text" id="total_leave" class="form-control" value="<?php echo ($current_open_balance + $pre_cumulative_open);?>" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>  
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Casual Opening Balance</label>
											<div class="col-md-6">
												<input type="text" name="casual_leave_open" id="casual_leave_open" class="form-control" value="{{$casual_leave_open}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 		
							</div> 
							   
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Leave Type </label>
											<div class="col-md-6">
												<select  name="type_id" class="form-control" id="type_id" style="pointer-events:none;"  required > 
													@foreach($leave_type as $type)
													<option value="{{$type->id}}">{{$type->type_name}}</option>
													@endforeach
												</select>
											</div> 
									</div> 
								</div>
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">FY Cummulative </label>
											<div class="col-md-6">
												<input type="text" name="cum_balance_less_12" autocomplete="off" onkeyup="change_fy_balance()" id="cum_balance_less_12" class="form-control" value="{{$cum_balance_less_12}}"  required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 	 				
							</div>   
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Approved's From </label>
											<div class="col-md-6">
												<input type="text" style="pointer-events:none;" name="from_date" autocomplete="off"  id="from_date" class="form-control" value="{{$from_date}}" required>
												<span class="help-block" id="error1" ></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Approved's To </label>
											<div class="col-md-6">
												<input type="text" style="pointer-events:none;" name="to_date"  id="to_date"     autocomplete="off"  class="form-control" value="{{$to_date}}" required>
												<span class="help-block" id="error"></span>
											</div> 
									</div> 
								</div> 
							</div>   
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Total Leave Day/s</label>
											<div class="col-md-6">
												<input type="text" readonly name="no_of_days"  id="no_of_days" class="form-control" value="{{$no_of_days}}" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;padding-right:0px;margin-right:0px;">Apply For </label>
											<div class="col-md-6">
												<select class="form-control" style="pointer-events:none;" name="apply_for" id="apply_for">
													<option value="1">Full Day Leave</option> 
													<option value="2">First Half Leave</option>
													<option value="3">Second Half Leave</option>  
												</select>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>  
							</div>  
							
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Total Leave Closing balance</label>
											<div class="col-md-6">
												<input type="text" id="total_leave" class="form-control" value="<?php echo ($current_open_balance + $pre_cumulative_open) - $no_of_days;?>" readonly required>
											</div> 
									</div> 
								</div>  
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Reason of Leave</label>
											<div class="col-md-6">
												 <input list="browsers" class="form-control" required   name="remarks" value="{{$remarks}}" id="remarks">
												  <datalist id="browsers">
													<option value="Personal"> 
												  </datalist> 
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 	  
							</div>  
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Total Earn Leave</label>
											<div class="col-md-6">
												<input type="text" name="tot_earn_leave" id="tot_earn_leave" class="form-control" readonly value="<?php echo $tot_earn_leave;?>" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Casual Closing</label>
											<div class="col-md-6">
												<input type="text" name="casual_leave_close" id="casual_leave_close" class="form-control" readonly value="<?php  if($type_id == 5){ echo $casual_leave_open - $no_of_days; } else { echo $casual_leave_open; } ?>">
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>   
							</div> 
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Total Leave enjoy</label>
											<div class="col-md-6">
												<input type="text"  id="tot_expense" name="tot_expense" class="form-control" readonly value="{{$tot_expense}}" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">FY Cummulative close</label>
											<div class="col-md-6">
												<input type="text"  id="cum_balance_less_close_12" name="cum_balance_less_close_12" class="form-control" readonly value="{{$cum_balance_less_12}}" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>  
							</div> 
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Balance</label>
											<div class="col-md-6">
												<input type="text" name="leave_remain" id="leave_remain" class="form-control" readonly value="<?php echo ($tot_earn_leave - $tot_expense); ?>" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								<div class="col-md-5">
									 
									<div class="form-group"> 
										<label class="control-label col-md-4">Approved By</label>
											<div class="col-md-6">
												<select  name="approved_id" class="form-control" id="approved_id" style="pointer-events:none;" required > 
												<?php if($reported_to == 'Chairman'){
													?>
													<option value="<?php echo "0,0"; ?>"> Chairman</option>
													
												<?php }else{ 
												foreach($supervisor_info as $staff)
													{ 
												
												?>
													<option value="<?php echo $staff['emp_id'].','.$staff['designation_code']; ?>">{{$staff['emp_name'].' ( '.$staff['designation_name'].' ) '}}</option>
												<?php } } ?>
													
												</select>
											</div> 
									</div> 
								 
								</div> 
							</div>
							<div class="row"> 	
								<div class="col-md-5  col-md-offset-7"> 
									<div class="form-group"> 
										<label class="control-label col-md-2"></label>
											<div class="col-md-6"> 
												<input type="submit" id="submit_btn" class="btn btn-primary" value="{{$button}}">
												<a href="{{URL::to('/approved_by_hrm')}}" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
											</div> 
									</div>  
								</div> 
							</div> 
						</div> 
				</FIELDSET>  
			</form>
			<?php } ?>
		</div>
	</section> 
<script>
 function check_leave_exist(){
   
	var from_date =document.getElementById("from_date").value;  
	var to_date =document.getElementById("to_date").value; 
	var emp_type =document.getElementById("emp_type1").value;
	var emp_id =$("#emp_id").val();
	var return_type = false; 	
	//alert(from_date);
	// var dataString = 'employee_id='+employee_id;
			$.ajax({
				type:'get',
				async: false,
				url : "{{URL::to('leave_date_exist_app')}}"+"/"+from_date+"/"+to_date+"/"+emp_type+"/"+emp_id,
				success:function(res){
					console.log(res);
					 if(res == 1){
						 return_type = false;
						 $("#submit_btn").attr('disabled', 'disabled').css('background-color','#DEE0E2');
						alert("This Date Already Exist !!");
							
					}else{
						 return_type = true;
						 $("#submit_btn").removeAttr('disabled');
						 $("#submit_btn").css("background-color",""); 
					}
					 
			}
		})   
		return return_type;
 }
function change_fy_balance(){  
	var cum_balance_less_12 = document.getElementById("cum_balance_less_12").value;
	 document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12; 
 }

 if('{{$type_id}}' != ''){
	document.getElementById("type_id").value = "{{$type_id}}"; 
}if('{{$f_year_id}}' != ''){
	document.getElementById("f_year_start").value = "{{$f_year_id}}"; 
}  
if('{{$emp_type}}' != ''){
	document.getElementById("emp_type").value = "{{$emp_type}}"; 
}
$(document).ready(function() {
if('{{$apply_for}}' != ''){
	
	  document.getElementById("apply_for").value = '<?php echo $apply_for; ?>'; 
	 
} 
 });
</script>
<script type="text/javascript"> 
$(document).ready(function() {
	$('#application_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#from_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			$("#approved_By_hrm").addClass('active');
			//$('[id^=Leave_Report_]')
		});
	</script>
@endsection