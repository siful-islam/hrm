@extends('admin.admin_master')
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
				<form class="form-horizontal" action="" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} 
                {!!$method_control!!} 
				 
				<input type="hidden" name="appr_status" id="appr_status" class="form-control" value="{{$appr_status}}" readonly >
				<input type="hidden" name="f_year_id" id="f_year_id" class="form-control" value="{{$fiscal_year->id}}" readonly >
				<input type="hidden" name="org_join_date" id="org_join_date"  class="form-control" value="{{$emp_info->org_join_date}}" readonly required>
                <fieldset class="col-md-offset-1">
						<LEGEND class="col-md-9" style="padding-left:0px;"><b> Employee Information</b></LEGEND>
						<div class="box-body"> 
								<div class="row"> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Employee ID</label>
												<div class="col-md-6">
													<input type="text" name="emp_id" class="form-control" value="{{$emp_info->emp_id}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div>
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Employee Name </label>
												<div class="col-md-6">
													<input type="text" name="emp_name_eng" class="form-control" value="{{$emp_info->emp_name_eng}}" readonly required>
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
													<input type="text" name="designation_code"  class="form-control" value="{{$emp_info->designation_name}}" readonly required>
													<span class="help-block"></span>
												</div> 
										</div> 
									</div> 
									<div class="col-md-5">
										<div class="form-group"> 
											<label class="control-label col-md-4">Working Station</label>
												<div class="col-md-6">
													<input type="text" name="branch_code" readonly  class="form-control" value="{{$emp_info->branch_name}}" required>
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
										<label class="control-label col-md-4">Financial Year From </label>
											<div class="col-md-6">
												<input type="text" name="f_year_from" id="f_year_from" class="form-control" value="{{date('Y',strtotime($fiscal_year->f_year_from)).'-'.date('Y',strtotime($fiscal_year->f_year_to))}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>
								<!--<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">To </label>
											<div class="col-md-6">
												<input type="text" name="f_year_to" id="f_year_to" class="form-control" value="{{$fiscal_year->f_year_to}}" readonly required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> -->
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Application Date </label>
											<div class="col-md-6">
												<input type="text" name="application_date" id="application_date" class="form-control" value="{{$application_date}}" readonly required>
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
												<input type="text" name="cum_balance_less_12" id="cum_balance_less_12" class="form-control" value="{{0}}" readonly required>
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
												<input type="text" name="pre_cumulative_open" id="pre_cumulative_open"  class="form-control" value="0" readonly required>
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
										<label class="control-label col-md-4">Leave Type </label>
											<div class="col-md-6">
												<select  name="type_id" class="form-control"  id="type_id"  required > 
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
												<input type="text" name="from_date" onchange="settotalday1();"  id="from_date" class="form-control" value="{{$from_date}}" required>
												<span class="help-block" id="error1" ></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Approved's To </label>
											<div class="col-md-6">
												<input type="text" name="to_date"  id="to_date"  onchange="settotalday();"  class="form-control" value="{{$to_date}}" required>
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
												<input type="text" name="no_of_days" id="no_of_days" class="form-control" readonly value="{{$no_of_days}}" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div> 
								<div class="col-md-5">
									<div class="form-group"> 
										<label class="control-label col-md-4">Remarks</label>
											<div class="col-md-6">
												 <input list="browsers" class="form-control" readonly  name="remarks" value="{{$remarks}}" id="remarks">
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
										<label class="control-label col-md-4">Total Earn Leave</label>
											<div class="col-md-6">
												<input type="text" name="tot_earn_leave" id="tot_earn_leave" class="form-control" readonly value="{{$tot_earn_leave}}" required>
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
										<label class="control-label col-md-4">Total Leave enjoy</label>
											<div class="col-md-6">
												<input type="text"  id="tot_expense" name="tot_expense" class="form-control" readonly value="{{$tot_expense}}" required>
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
										<label class="control-label col-md-4">Balance</label>
											<div class="col-md-6">
												<input type="text" name="leave_remain" id="leave_remain" class="form-control" readonly value="{{$leave_remain}}" required>
												<span class="help-block"></span>
											</div> 
									</div> 
								</div>  
							</div> 
							<div class="row">  
								<div class="col-md-5 col-md-offset-5">
									<div class="form-group"> 
										<label class="control-label col-md-4"></label>
											<div class="col-md-6"> 
												<input type="submit" class="btn btn-primary" value="{{$button}}" formaction="{{URL::to($action1)}}">
												
												<input type="submit" class="btn btn-danger" value="Reject" formaction="{{URL::to($action2)}}">    
												<a href="{{URL::to('/approved-leave')}}" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
											</div> 
									</div> 
								</div>
							</div>  
						</div> 
				</FIELDSET>  
			</form>
		</div>
	</section>
<script>
function change_pay_type(){  
	 var is_pay  = document.getElementById("is_pay").value;
	 //alert(is_pay);
	 var tot_expense  = parseFloat(document.getElementById("tot_expense").value);
	 var pre_cumulative_open  = parseFloat(document.getElementById("pre_cumulative_open").value);
	 var cum_balance  = parseFloat(document.getElementById("cum_balance").value);
	 var current_open_balance = parseFloat(document.getElementById("current_open_balance").value);
	 var cum_balance_less_12 = parseFloat(document.getElementById("cum_balance_less_12").value);
	 if(is_pay == 2){
		 document.getElementById("current_close_balance").value  = current_open_balance;
		 document.getElementById("pre_cumulative_close").value   = pre_cumulative_open;
		 document.getElementById("cum_close_balance").value   = cum_balance;
		 document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12;
	 }else{
		 
		 var no_of_days = parseFloat(document.getElementById("no_of_days").value); 
		 var leave_adjust = document.getElementById("leave_adjust").value;  
	//alert(leave_adjust);
		  if(leave_adjust == 1){
			  document.getElementById("current_close_balance").value =  current_open_balance - ( no_of_days + tot_expense ) ; 
			  document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12;
		 }else if(leave_adjust == 3){
			 document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12 - no_of_days;
			  document.getElementById("current_close_balance").value =  current_open_balance;
			  document.getElementById("cum_close_balance").value =  cum_balance;
			  document.getElementById("pre_cumulative_close").value =  pre_cumulative_open;
		 }else{
			 document.getElementById("pre_cumulative_close").value =  pre_cumulative_open - no_of_days;
			 document.getElementById("cum_close_balance").value =  cum_balance - no_of_days;
			 document.getElementById("cum_balance_less_close_12").value =  cum_balance_less_12;
		 }    
	 }
 }
/* function calculate_earn_leave(){ 
	//alert('ok');
		var f_year_from = document.getElementById("f_year_from").value;
		//alert(f_year_from);
		var application_date = document.getElementById("application_date").value;
		var org_join_date = document.getElementById("org_join_date").value;
		var tot_expense = parseFloat(document.getElementById("tot_expense").value); 
		var current_date =  new Date();
		var current_month = current_date.getMonth()+1;
		if( org_join_date >= f_year_from){
			var org_join_date1 = new Date(org_join_date); 
			var join_month = org_join_date1.getMonth()+1; 
			if(isNaN(application_date)){
				var apply_date1 = new Date(application_date); 
			}else{
				var apply_date1 = current_date; 
			} 
			var app_month = apply_date1.getMonth()+1;  
			var month_diff = calculate_month_diff(app_month,join_month);
			
		}else{
			var f_year_from1 = new Date(f_year_from); 
			var financial_month = f_year_from1.getMonth()+1; 
			if(isNaN(application_date)){
				var apply_date1 = new Date(application_date); 
			}else{
				var apply_date1 = current_date; 
			} 
			var app_month = apply_date1.getMonth()+1;  
			
			var month_diff = calculate_month_diff(app_month,financial_month);
		}
		//alert(month_diff);
		var t_earn_leave = month_diff * parseFloat(1.5); 
		document.getElementById("tot_earn_leave").value = t_earn_leave;
		document.getElementById("leave_remain").value = (t_earn_leave - tot_expense); 

	} 
	function calculate_month_diff(app_month,financial_month){
		if(app_month > 6){
				var month_diff = app_month - financial_month;
			}else{
				var month_diff =(5 + app_month);
			}
			return month_diff;
	} */	
</script>	
<script>
function settotalday1(){  
	 var from_date         		=$('#from_date').datepicker('getDate');
	 var to_date          		=$('#to_date').datepicker('getDate');
	 var pre_cumulative_open  	= parseFloat(document.getElementById("pre_cumulative_open").value);
	 var cum_balance  			= parseFloat(document.getElementById("cum_balance").value);
	 var tot_expense   			= parseFloat(document.getElementById("tot_expense").value); 
	 var current_open_balance   = parseFloat(document.getElementById("current_open_balance").value); 
	 var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value);
	 var leave_adjust   		= parseFloat(document.getElementById("leave_adjust").value);  
	// alert(to_date);
		 if (from_date <= to_date) {
			  var day   = (to_date - from_date)/1000/60/60/24;
			  var days =day+1;  
			  $('#no_of_days').val(days);
			   var curr_close_bal = current_open_balance; 
			  var cum_bal_close = cum_balance; 
			  var pre_cum_bal_close = pre_cumulative_open; 
			  if(leave_adjust == 1){ 
				 var curr_close_bal = (current_open_balance - ( days + tot_expense)); 
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
			  $('#error1').html("");
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
	 var pre_cumulative_open  			= parseFloat(document.getElementById("pre_cumulative_open").value);
	 var current_open_balance   = parseFloat(document.getElementById("current_open_balance").value); 
	 var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value); 
	 var leave_adjust   		= parseFloat(document.getElementById("leave_adjust").value);
	// alert(to_date);
		 if (from_date <= to_date) {
			var day   = (to_date - from_date)/1000/60/60/24;
			var days =day+1;  
			$('#no_of_days').val(days);
			var curr_close_bal = current_open_balance; 
			  var cum_bal_close = cum_balance; 
			  var pre_cum_bal_close = pre_cumulative_open; 
			  if(leave_adjust == 1){ 
				 var curr_close_bal = (current_open_balance - (days + tot_expense)); 
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
} 
$(document).on("change", "#type_id", function () {
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
		var pre_cum_bal_close  	= parseFloat(document.getElementById("pre_cumulative_open").value);
		var cum_bal_close  			= parseFloat(document.getElementById("cum_balance").value);
		var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value); 
		var curr_close_bal   		= parseFloat(document.getElementById("current_open_balance").value); 
		var leave_adjust   			= parseFloat(document.getElementById("leave_adjust").value);  
		//alert('ok');
		if(type_id == 1){
			if(leave_adjust == 1){ 
				var curr_close_bal = (curr_close_bal - (no_of_days + tot_expense)); 
			  }else if(leave_adjust == 2){
				 var cum_bal_close = (cum_bal_close - no_of_days); 
				 var pre_cum_bal_close = (pre_cum_bal_close - no_of_days); 
			  }else if(leave_adjust == 3){
				 var cum_balance_less_12 = (cum_balance_less_12 - no_of_days); 
			  } 
			  //alert(tot_expense);
			document.getElementById("current_close_balance").value = curr_close_bal; 
			document.getElementById("cum_close_balance").value = cum_bal_close; 
			document.getElementById("pre_cumulative_close").value = pre_cum_bal_close; 
			document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12; 
			change_pay_type();
		}else{
			
			document.getElementById("current_close_balance").value = curr_close_bal; 
			document.getElementById("pre_cumulative_close").value = pre_cum_bal_close; 
			document.getElementById("cum_close_balance").value = cum_bal_close; 
			document.getElementById("cum_balance_less_close_12").value = cum_balance_less_12; 
		} 	 
});	

$(document).on("change", "#leave_adjust", function () {
		var no_of_days  			= parseFloat(document.getElementById("no_of_days").value);
		var tot_expense  			= parseFloat(document.getElementById("tot_expense").value);
		var cum_bal_close  			= parseFloat(document.getElementById("cum_balance").value);
		var pre_cum_bal_close  			= parseFloat(document.getElementById("pre_cumulative_open").value);
		var cum_balance_less_12   	= parseFloat(document.getElementById("cum_balance_less_12").value); 
		var curr_close_bal   		= parseFloat(document.getElementById("current_open_balance").value); 
		var leave_adjust   			= parseFloat(document.getElementById("leave_adjust").value);  
		if(leave_adjust == 1){ 
			 var curr_close_bal = (curr_close_bal - (no_of_days + tot_expense) ); 
		  }else if(leave_adjust == 2){
			 var cum_bal_close = (cum_bal_close - no_of_days); 
			 var pre_cum_bal_close = (pre_cum_bal_close - no_of_days); 
		  }else if(leave_adjust == 3){
			 var cum_balance_less_12 = (cum_balance_less_12 - no_of_days); 
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
	$('#from_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>
@endsection