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
				<form   action="{{URL::to('/search_emp_info')}}" method="post" enctype="multipart/form-data" id="form1">
					  {{csrf_field()}}  
					<div class="row"> 
						<div class="col-md-4">
							<div class="form-group"> 
								<label class="control-label col-md-4"> Financial Year:</label>
									<div class="col-md-6">
										<select name="f_year_start" id="f_year_start" class="form-control"  required>  
											<?php foreach($fiscal_year as $v_fiscal_year){ ?>
												<option value="<?php  echo $v_fiscal_year->id;?>" ><?php  echo date("Y",strtotime($v_fiscal_year->f_year_from)).'-'.date("Y",strtotime($v_fiscal_year->f_year_to));?></option> 
												
											<?php } ?>
										</select>
									</div> 
							</div> 
						</div> 
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
				<form class="form-horizontal" onsubmit="return change_with_pay();" action="{{URL::to('/insert_aprove_leave')}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
				<input type="hidden" name="f_year_id" id="f_year_id" class="form-control" value="{{$f_year_id}}" readonly >
				<input type="hidden"   id="f_year_from" class="form-control" value="{{$f_year_from}}" readonly > 
				<input type="hidden" name="org_join_date" id="org_join_date"  class="form-control" value="{{$employee_his->joining_date}}" readonly required>
                <fieldset class="col-md-offset-1">
						<LEGEND class="col-md-9" style="padding-left:0px;"><b> Employee Information</b></LEGEND>
						<div class="box-body"> 
								<div class="row"> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Employee ID</label>
												<div class="col-md-6">
													<input type="text" name="emp_id" id="emp_id" class="form-control" value="{{$employee_his->emp_id}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Employee Name </label>
												<div class="col-md-6">
													<input type="text" name="emp_name_eng" class="form-control" value="{{$employee_his->emp_name}}" readonly required>
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
													<input type="text" class="form-control" value="{{$employee_his->designation_name}}" readonly required>
													<input type="hidden" name="designation_code"  class="form-control" value="{{$employee_his->designation_code}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Working Station</label>
												<div class="col-md-6">
													<input type="text"   readonly  class="form-control" value="{{$employee_his->branch_name}}" required>
													<input type="hidden" name="branch_code" readonly  class="form-control" value="{{$employee_his->br_code}}" required>
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
												<input type="text" name="application_date" autocomplete="off"  id="application_date" onchange="calculate_earn_leave();"  class="form-control" value=""  required>
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
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;">Total Leave in this Year </label>
											<div class="col-md-6">
												<input type="text" id="yearly_leave" class="form-control" value="" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">FY Cummulative </label>
											<div class="col-md-6">
												<input type="text" name="cum_balance_less_12" id="cum_balance_less_12" class="form-control" value="{{$cum_balance_less_12}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
							</div> 
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;padding-right:0px;">Cum.balance till last year</label>
											<div class="col-md-6">
												<input type="text" name="pre_cumulative_open" id="pre_cumulative_open"  class="form-control" value="{{$pre_cumulative_open}}" readonly required>
												<input type="hidden" name="cum_balance" id="cum_balance"  class="form-control" value="{{$cum_balance}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;padding-right:0px;margin-right:0px;">curr. Opening Balance </label>
											<div class="col-md-6">
												<input type="text" name="current_open_balance" id="current_open_balance" class="form-control" value="{{$current_open_balance}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
							</div>   
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;padding-right:0px;margin-right:0px;">Casual Opening Balance </label>
											<div class="col-md-6">
												<input type="text" name="casual_leave_open" id="casual_leave_open" class="form-control" value="{{$casual_leave_open}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4" style="margin-left:0px;padding-left:0px;padding-right:0px;margin-right:0px;">Apply For </label>
											<div class="col-md-6">
												<select class="form-control" name="apply_for" id="apply_for" onchange="set_day_half();">
													<option value="1">Full Day Leave</option> 
													<?php if($type_id == 1 || $type_id == 1){?>
													<option value="2">Half Day Leave( Morning )</option>
													<option value="3">Half Day Leave( Evening )</option> 
													<?php } ?>
												</select>
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
												<select  name="type_id" class="form-control" onchange="change_leave_type()" id="type_id"  required > 
												@foreach($leave_type as $type)
												<option value="{{$type->id}}">{{$type->type_name}}</option>
												@endforeach
											</select>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Pay Type </label>
											<div class="col-md-6">
												<select  name="is_pay" class="form-control"  onchange="change_pay_type();"  id="is_pay" required > 
													<option value="1">With pay</option>
													<option value="2">Without pay</option>
													<option value="3">With pay(Special)</option>
												</select>
											</div> 
									</div> 
								</div> 
							</div>   
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Approved's From </label>
											<div class="col-md-6">
												<input type="text" name="from_date" onchange="settotalday1();" autocomplete="off"  id="from_date" class="form-control" value="" required>
												<span class="help-block" id="error1" ></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Approved's To </label>
											<div class="col-md-6">
												<input type="text" name="to_date"  id="to_date"  onchange="settotalday();"  autocomplete="off"  class="form-control" value="" required>
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
												<input type="text" readonly name="no_of_days" onkeyup="change_tot_leave()" id="no_of_days" class="form-control" value="" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Remarks</label>
											<div class="col-md-6">
												 <input list="browsers" class="form-control"   name="remarks" value="" id="remarks">
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
										<label class="control-label col-md-4">Cumulative Closing</label>
											<div class="col-md-6">
												<input type="text" name="pre_cumulative_close" id="pre_cumulative_close" class="form-control" readonly value="" required>
												<input type="hidden" name="cum_close_balance" id="cum_close_balance" class="form-control" readonly value="" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Current Closing</label>
											<div class="col-md-6">
												<input type="text" name="current_close_balance" id="current_close_balance" class="form-control" readonly value="<?php //echo $current_close_balance;?>" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
							</div>  
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Casual Closing</label>
											<div class="col-md-6">
												<input type="text" name="casual_leave_close" id="casual_leave_close" class="form-control" readonly value="" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">FY Cummulative close</label>
											<div class="col-md-6">
												<input type="text"  id="cum_balance_less_close_12" name="cum_balance_less_close_12" class="form-control" readonly value="{{0}}" required>
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
												<input type="text" name="tot_earn_leave" id="tot_earn_leave" class="form-control" readonly value="" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Adjustment</label>
											<div class="col-md-6"> 
												<select  name="leave_adjust" id="leave_adjust"  class="form-control"  required > 
													<option value="1">Current</option>
													<option value="2">Cumulative</option>
													<option value="3">FY Cummulative</option>
												</select>
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
										<label class="control-label col-md-4">Approved By</label>
											<div class="col-md-6">
												<select  name="approved_id" class="form-control" id="approved_id"  required > 
												@foreach($branch_staff as $staff)
												<option value="<?php echo $staff['emp_id'].','.$staff['designation_code'] ?>">{{$staff['emp_name'].' ( '.$staff['designation_name'].' ) '}}</option>
												@endforeach
											</select>
											</div> 
									</div> 
								</div> 
							</div> 
							<div class="row"> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Balance</label>
											<div class="col-md-6">
												<input type="text" name="leave_remain" id="leave_remain" class="form-control" readonly value="" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>  
							</div> 
							<div class="row"> 
								<div class="col-md-5 col-md-offset-2">
									<div class="form-group"> 
										<label class="control-label col-md-2"></label>
											<div class="col-md-6"> 
												<input type="submit" id="submit_btn" class="btn btn-primary" value="{{$button}}">
												<a href="{{URL::to('/approved-leave')}}" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
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
function set_day_half() {
	
            var from_date = document.getElementById('from_date').value;
            var to_date = document.getElementById('to_date').value;
            var apply_for = document.getElementById('apply_for').value;
            if(apply_for > 1)
			{
				var days = .5;
				
				document.getElementById('to_date').value = from_date;
				document.getElementById('to_date').readOnly  = true; 
				document.getElementById("to_date").style.pointerEvents = "none";
				document.getElementById('no_of_days').value = days;
				if(apply_for == 2){
					document.getElementById('remarks').value = "9 a.m. to 1 p.m.";
				}else{
					document.getElementById('remarks').value = "1 p.m. to 5 p.m.";
				}
				
			}else
			{ 
				
				/* var date1 = new Date(from_date);
				var date2 = new Date(to_date);
				var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10);
				var days = diffDays + 1; */
				 
				document.getElementById('remarks').value ="";
				document.getElementById('no_of_days').value = 1;
				document.getElementById("to_date").readOnly  = false;
				document.getElementById("to_date").style.pointerEvents = "";
			} 
			change_leave_type();
        }

function change_tot_leave(){
	 //var tot_days = parseFloat(document.getElementById("app_tot_days").value); 
	//document.getElementById("tot_days").value = tot_days;
	change_leave_type();
	change_with_pay();
} 
function change_with_pay(){  
	var pre_cumulative_close = document.getElementById("pre_cumulative_close").value; 
	var current_close_balance = document.getElementById("current_close_balance").value;
	var casual_leave_close = document.getElementById("casual_leave_close").value;
	var is_pay  = document.getElementById("is_pay").value;
	 
	var return_type = true; 
			if(current_close_balance < 0){
				if(is_pay == 1){
					alert('Please Select Without pay !!!');
					return_type = false; 
				}else if(is_pay == 3){
					return_type = true; 
				} 
			}else if(pre_cumulative_close < 0){
				if(is_pay == 1){
					alert('Please Select Without pay !!!');
					return_type = false; 
				}  
			}else if(casual_leave_close < 0){
				if(is_pay == 1){
					alert('Please Select Without pay !!!');
					return_type = false; 
				}  
			} 
	 
	 
	 return return_type; 
 }
function change_pay_type(){  
	 var is_pay  = document.getElementById("is_pay").value;
	 //alert(is_pay);
	 var tot_expense  = parseFloat(document.getElementById("tot_expense").value);
	 var pre_cumulative_open  = parseFloat(document.getElementById("pre_cumulative_open").value);
	 var cum_balance  = parseFloat(document.getElementById("cum_balance").value);
	 var current_open_balance = parseFloat(document.getElementById("current_open_balance").value);
	 var casual_leave_open = parseFloat(document.getElementById("casual_leave_open").value);
	 var cum_balance_less_12 = parseFloat(document.getElementById("cum_balance_less_12").value);
	 var type_id = parseFloat(document.getElementById("type_id").value);
	 if(is_pay == 2){
		 document.getElementById("current_close_balance").value  = current_open_balance;
		 document.getElementById("casual_leave_close").value  = casual_leave_open;
		 document.getElementById("pre_cumulative_close").value   = pre_cumulative_open;
		 document.getElementById("cum_close_balance").value   = cum_balance;
		 document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12;
	 }else{
		 
		 var no_of_days = parseFloat(document.getElementById("no_of_days").value); 
		 var leave_adjust = document.getElementById("leave_adjust").value;  
	//alert(leave_adjust);
		  if(leave_adjust == 1){
			  if(type_id == 5){
				  document.getElementById("casual_leave_close").value =  casual_leave_open -  no_of_days ;
				  document.getElementById("current_close_balance").value =  current_open_balance;
			  }else{
				  document.getElementById("current_close_balance").value =  current_open_balance -  no_of_days ;
				  document.getElementById("casual_leave_close").value =  casual_leave_open
			  }
			   
			  document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12;
		 }else if(leave_adjust == 3){
			 document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12 - no_of_days;
			  document.getElementById("current_close_balance").value =  current_open_balance;
			  document.getElementById("casual_leave_close").value =  casual_leave_open;
			  document.getElementById("cum_close_balance").value =  cum_balance;
			  document.getElementById("pre_cumulative_close").value =  pre_cumulative_open;
		 }else{
			 document.getElementById("pre_cumulative_close").value =  pre_cumulative_open - no_of_days;
			 document.getElementById("cum_close_balance").value =  cum_balance - no_of_days;
			 document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12;
			 document.getElementById("current_close_balance").value =  current_open_balance;
			 document.getElementById("casual_leave_close").value =  casual_leave_open;
		 } 
	 }
 } 
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
		document.getElementById("leave_remain").value = (parseFloat( t_earn_leave ) - tot_expense); 
		 
	} 
	function calculate_month_diff(app_month,financial_month){
		if(app_month > 6){
				var month_diff = app_month - financial_month;
			}else{
				var month_diff =(5 + app_month);
			}
			return month_diff;
	}	
</script>	
<script>
 function settotalday1(){
  
	var from_date =document.getElementById("from_date").value; 
	 $('#to_date').val(document.getElementById("from_date").value);
	var to_date =document.getElementById("to_date").value;  
	var emp_id =$("#emp_id").val(); 
	//alert(from_date);
	// var dataString = 'employee_id='+employee_id;
			$.ajax({
				type:'get',
				url : "{{URL::to('leave_date_exist')}}"+"/"+from_date+"/"+to_date+"/"+emp_id,
				success:function(res){
					//alert(res);
					console.log(res['is_leave_date']);
					
					  if(res['is_leave_date'] == 1){
						  document.getElementById("no_of_days").value = 0; 
						 $("#submit_btn").attr('disabled', 'disabled').css('background-color','#DEE0E2');
						alert("This Date Already Exist !!");
							
					}else{
						if(res['flag'] == 0){
							
							document.getElementById("no_of_days").value = 0; 
							 $("#submit_btn").attr('disabled', 'disabled').css('background-color','#DEE0E2');
							alert("There is no date during this period.");
						}else{
							
							$("#submit_btn").removeAttr('disabled');
							 $("#submit_btn").css("background-color","");
							 document.getElementById("no_of_days").value = res['days'];
							settotalday11();
							change_leave_type();
						}
						 
					} 
					 
			}
		})  
 }


function settotalday11(){  
	 var from_date         		=$('#from_date').datepicker('getDate');
	 
	 $('#to_date').val(document.getElementById("from_date").value);
	 var to_date =$('#to_date').datepicker('getDate');
	 var pre_cumulative_open  	= parseFloat(document.getElementById("pre_cumulative_open").value);
	 var cum_balance  			= parseFloat(document.getElementById("cum_balance").value);
	 var tot_expense   			= parseFloat(document.getElementById("tot_expense").value); 
	 var current_open_balance   = parseFloat(document.getElementById("current_open_balance").value); 
	 var casual_leave_open   = parseFloat(document.getElementById("casual_leave_open").value); 
	 var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value);
	 var leave_adjust   		= parseFloat(document.getElementById("leave_adjust").value);  
	 var type_id   		= parseFloat(document.getElementById("type_id").value);  
    // alert(tot_expense);
		 if (from_date <= to_date) { 
			  /* var day   = (to_date - from_date)/1000/60/60/24;
			  var days =day+1;  
			  
			  $('#no_of_days').val(days); */
			  var days = parseFloat(document.getElementById("no_of_days").value);
			   var curr_close_bal = current_open_balance; 
			   var casual_leave_close = casual_leave_open; 
			  var cum_bal_close = cum_balance; 
			  var pre_cum_bal_close = pre_cumulative_open; 
			  if(leave_adjust == 1){ 
					if(type_id == 5){
						casual_leave_close = (casual_leave_close -  days); 
					}else{
						 curr_close_bal = (current_open_balance -  days); 
					}
				  
			  }else if(leave_adjust == 2){
				 var cum_bal_close = (cum_balance - days); 
				 var pre_cum_bal_close = (pre_cumulative_open - days); 
			  }else if(leave_adjust == 3){
				 var cum_balance_less_12 = (cum_balance_less_12 - days); 
			  }  
			  //alert(curr_close_bal);
			  $('#casual_leave_close').val(casual_leave_close);
			  $('#current_close_balance').val(curr_close_bal);
			  $('#cum_close_balance').val(cum_bal_close);
			  $('#pre_cumulative_close').val(pre_cum_bal_close);
			  $('#cum_balance_less_close_12').val(cum_balance_less_12);
			  $('#error1').html("");
			   set_day_half();
		 }else{
			 if(from_date > to_date){
				  $('#error1').html("<b style='color:red;font-size:12px;'>From date must be less or equal!</b>");
					$('#from_date').val("");
			 }
			
		 }
}
function settotalday(){  
	 var from_date         		=$('#from_date').datepicker('getDate');
	 var to_date          		=$('#to_date').datepicker('getDate');
	 var tot_expense  			= parseFloat(document.getElementById("tot_expense").value);
	 var cum_balance  			= parseFloat(document.getElementById("cum_balance").value);
	 var pre_cumulative_open  	= parseFloat(document.getElementById("pre_cumulative_open").value);
	 var current_open_balance   = parseFloat(document.getElementById("current_open_balance").value); 
	 var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value); 
	 var leave_adjust   		= parseFloat(document.getElementById("leave_adjust").value);
	// alert(to_date);
		 if (from_date <= to_date) {
			/* var day   = (to_date - from_date)/1000/60/60/24;
			var days =day+1;  
			$('#no_of_days').val(days); */
			 var days = parseFloat(document.getElementById("no_of_days").value);
			var curr_close_bal = current_open_balance; 
			  var cum_bal_close = cum_balance; 
			  var pre_cum_bal_close = pre_cumulative_open; 
			  if(leave_adjust == 1){ 
				 var curr_close_bal = (current_open_balance - days); 
			  }else if(leave_adjust == 2){
				 var cum_bal_close = (cum_balance - days); 
				 var pre_cum_bal_close = (pre_cumulative_open - days); 
			  }else if(leave_adjust == 3){
				 var cum_balance_less_12 = (cum_balance_less_12 - days); 
			  }  
			  $('#current_close_balance').val(curr_close_bal);
			  $('#cum_close_balance').val(cum_bal_close);
			  $('#pre_cumulative_close').val(pre_cum_bal_close);
			  $('#cum_balance_less_close_12').val(cum_balance_less_12);
			  $('#error').html("");
				
				var from_date =document.getElementById("from_date").value; 
				var to_date =document.getElementById("to_date").value;  
				var emp_id =$("#emp_id").val(); 
				//alert(from_date);
				// var dataString = 'employee_id='+employee_id;
						$.ajax({
							type:'get',
							url : "{{URL::to('leave_date_exist')}}"+"/"+from_date+"/"+to_date+"/"+emp_id,
							success:function(res){
								//alert(res); 
								 if(res['is_leave_date'] == 1){
									 document.getElementById("no_of_days").value = 0; 
									 $("#submit_btn").attr('disabled', 'disabled').css('background-color','#DEE0E2');
									alert("This Date Already Exist !!");
										
								}else{
									if(res['flag'] == 0){
										document.getElementById("no_of_days").value = 0; 
										$("#submit_btn").attr('disabled', 'disabled').css('background-color','#DEE0E2');
										alert("There is no date during this period.");
									}else{
										 document.getElementById("no_of_days").value = res['days'];
										$("#submit_btn").removeAttr('disabled');
										$("#submit_btn").css("background-color",""); 
										change_leave_type();
									}
									
								}  
						}
					}) 
				
		 }else{ 
			 $('#error').html("<b style='color:red;font-size:12px;'>To date must be grater or equal!</b>");
			$('#to_date').val(""); 
		 }
}
</script>
<script>
 if('{{$is_pay}}' != ''){
	document.getElementById("is_pay").value = "{{$is_pay}}";
} 
if('{{$leave_adjust}}' != ''){
	document.getElementById("leave_adjust").value = "{{$leave_adjust}}";
}
 if('{{$type_id}}' != ''){
	document.getElementById("type_id").value = "{{$type_id}}";
	change_leave_type();
}if('{{$f_year_id}}' != ''){
	document.getElementById("f_year_start").value = "{{$f_year_id}}"; 
} if('{{$employee_id}}' != ''){
	document.getElementById("employee_id").value = "{{$employee_id}}"; 
} if('{{$approved_id}}' != ''){
	document.getElementById("approved_id").value = "{{$approved_id.','.$appr_desig_code}}"; 
}  
function change_leave_type() {
	var type_id = document.getElementById("type_id").value;
	 //alert(type_id);
		 $.ajax({
			type: "GET",
			url : "{{URL::to('yearly-tot-leave')}}"+"/"+type_id, 
			success: function(data)
			{
				//alert(data);
				$("#yearly_leave").val(data); 
			}
		});
		var no_of_days  			= parseFloat(document.getElementById("no_of_days").value);
		var tot_expense  			= parseFloat(document.getElementById("tot_expense").value);
		var pre_cum_bal_close  		= parseFloat(document.getElementById("pre_cumulative_open").value);
		var cum_bal_close  			= parseFloat(document.getElementById("cum_balance").value);
		var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value); 
		var curr_close_bal   		= parseFloat(document.getElementById("current_open_balance").value); 
		var casual_leave_close   		= parseFloat(document.getElementById("casual_leave_open").value); 
		var leave_adjust   			= parseFloat(document.getElementById("leave_adjust").value);  
		//alert('ok');
		if(type_id == 1){
			if(leave_adjust == 1){ 
				var curr_close_bal = (curr_close_bal - no_of_days); 
			  }else if(leave_adjust == 2){
				 var cum_bal_close = (cum_bal_close - no_of_days); 
				 var pre_cum_bal_close = (pre_cum_bal_close - no_of_days); 
			  }else if(leave_adjust == 3){
				 var cum_balance_less_12 = (cum_balance_less_12 - no_of_days); 
			  } 
			  //alert(tot_expense);
			document.getElementById("casual_leave_close").value = casual_leave_close; 
			document.getElementById("current_close_balance").value = curr_close_bal; 
			document.getElementById("cum_close_balance").value = cum_bal_close; 
			document.getElementById("pre_cumulative_close").value = pre_cum_bal_close; 
			document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12; 
			change_pay_type();
		}else if(type_id == 5){
			 var casual_leave_close = (casual_leave_close - no_of_days); 
			  //alert(tot_expense);
			document.getElementById("casual_leave_close").value = casual_leave_close; 
			document.getElementById("current_close_balance").value = curr_close_bal; 
			document.getElementById("cum_close_balance").value = cum_bal_close; 
			document.getElementById("pre_cumulative_close").value = pre_cum_bal_close; 
			document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12; 
			change_pay_type();
		}else{
			
			document.getElementById("casual_leave_close").value = casual_leave_close; 
			document.getElementById("current_close_balance").value = curr_close_bal; 
			document.getElementById("pre_cumulative_close").value = pre_cum_bal_close; 
			document.getElementById("cum_close_balance").value = cum_bal_close; 
			document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12; 
		} 
		if(type_id == 1 || type_id == 5){
			$("#apply_for option[value='2']").show();
			$("#apply_for option[value='3']").show();
		}else{
			$("#apply_for option[value='2']").hide();
			$("#apply_for option[value='3']").hide();
		}
}

$(document).on("change", "#leave_adjust", function () {
		var no_of_days  			= parseFloat(document.getElementById("no_of_days").value);
		var tot_expense  			= parseFloat(document.getElementById("tot_expense").value);
		var cum_bal_close  			= parseFloat(document.getElementById("cum_balance").value);
		var pre_cum_bal_close  			= parseFloat(document.getElementById("pre_cumulative_open").value);
		var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value); 
		var curr_close_bal   		= parseFloat(document.getElementById("current_open_balance").value); 
		var leave_adjust   			= parseFloat(document.getElementById("leave_adjust").value);  
		if(leave_adjust == 1){ 
			   curr_close_bal = (curr_close_bal - no_of_days); 
		  }else if(leave_adjust == 2){
			   cum_bal_close = (cum_bal_close - no_of_days); 
			   pre_cum_bal_close = (pre_cum_bal_close - no_of_days); 
		  }else if(leave_adjust == 3){
			   cum_balance_less_12 = (cum_balance_less_12 - no_of_days); 
		  } 
		document.getElementById("current_close_balance").value = curr_close_bal; 
		document.getElementById("cum_close_balance").value = cum_bal_close;  
		document.getElementById("pre_cumulative_close").value = pre_cum_bal_close;  
		document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12;  
		change_pay_type();
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
			$("#Add_Leave").addClass('active');
			//$('[id^=Leave_Report_]')
		});
	</script>
@endsection