@extends('admin.admin_master')
@section('title', 'Arrear Pay')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 14px;
}
.col-sm-2, .col-sm-1 {
	padding-left: 6px;
}
</style>
<meta name="csrf-token" content="<?php echo csrf_token() ?>">
<section class="content-header">
	<h1>add-arrear-Pay</h1>
</section>
<section class="content">	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			@if(Session::has('message'))
			{{session('message')}}
			@endif
		</h3>-->
		<div class="col-md-12">
			<form class="form-horizontal" action="{{URL::to($action)}}" onsubmit="return pay_month_validation_arrear()" method="{{$method}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="box box-info">
				<div class="box-body">	
					
					<input type="hidden" autocomplete="off" class="form-control"   name="arrear_id"  value="{{$arrear_id}}" readonly required>
					<input type="hidden" autocomplete="off" class="form-control"   name="arrear_basic" id="arrear_basic" value="{{$arrear_basic}}" readonly required>
					<input type="hidden" autocomplete="off" class="form-control"   name="arrear_effect_date_from" id="arrear_effect_date_from" value="{{$arrear_effect_date_from}}" readonly required>
					<input type="hidden" autocomplete="off" class="form-control"   name="arrear_effect_date_to" id="arrear_effect_date_to" value="{{$arrear_effect_date_to}}" readonly required>
					<input type="hidden" autocomplete="off" class="form-control"   name="arrear_effect_date_from_payment" id="arrear_effect_date_from_payment" value="" readonly>
					<input type="hidden" autocomplete="off" class="form-control"   name="due_total_basic" id="due_total_basic" value="" readonly>
					<div class="form-group" >
						<label for="arrear_emp_id" class="col-sm-2 col-md-offset-1 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" id="arrear_emp_id" name="arrear_emp_id" value="{{$arrear_emp_id}}" readonly required>
						</div>
					</div>
					<div class="form-group">	
						<label for="emp_name" class="col-sm-2 col-md-offset-1 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="emp_name" value="{{$emp_name}}" required>						
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>  
					<div class="form-group">		
						<label for="arrear_days" class="col-sm-2 col-md-offset-1 control-label">Days<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="arrear_days" name="arrear_days" value="{{$arrear_days}}" required>
							 
						</div>
					</div>
					<div class="form-group">		
						<label for="arrear_basic_amount" class="col-sm-2 col-md-offset-1 control-label">Basic Amount<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" readonly  id="arrear_basic_amount" name="arrear_basic_amount" value="{{$arrear_basic_amount}}" required >
							 
						</div>
					</div>
					<div class="form-group">	
						<label for="arrear_to_pay_month" class="col-sm-2 col-md-offset-1 control-label">Pay Month <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="arrear_to_pay_month" name="arrear_to_pay_month" value="" required>
						</div>
					</div>
					<div class="form-group">		
						<label for="paid_status" class="col-sm-2 col-md-offset-1 control-label">Paid Status<span class="required">*</span></label>
						<div class="col-sm-3">
							<select name="paid_status"  class="form-control" onchange="paid_status_change();" id="paid_status"> 
							  <option value="1">Full</option>
							 <option value="2">Partial</option>
							</select> 
						</div>
					</div>
					<div class="form-group" id ="show_hide_day">		
						<label for="arrear_paid_days"  class="col-sm-2 col-md-offset-1 control-label">Pay Day/s<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" onchange="calc_arrear_amt_payment();"  id="arrear_paid_days" name="arrear_paid_days" value=""   >
							 
						</div>
					</div>
					<div class="form-group" id ="show_hide_amount">		
						<label for="arrear_paid_basic" class="col-sm-2 col-md-offset-1 control-label">Pay Amount<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" onkeydown="event.preventDefault()" class="form-control"  id="arrear_paid_basic" name="arrear_paid_basic" value=""   >
							 
						</div>
					</div>
					<div class="form-group" id ="show_hide_comment">		
						<label for="comments" class="col-sm-2 col-md-offset-1 control-label">Comments</label>
						<div class="col-sm-3">
							<input type="text"  class="form-control"  id="comments" name="comments" value=""   >
							 
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="{{URL::to('/arrear_setup')}}" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary">{{$button_text}}</button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
</section>
  
<script type="text/javascript">
function pay_month_validation_arrear() { 

		var arrear_to_pay_month        = document.getElementById("arrear_to_pay_month").value;
		var arrear_emp_id        = document.getElementById("arrear_emp_id").value;
		var succeed = false;
		$.ajax({
			url : "{{ url::to('pay_month_validation_arrear') }}"+"/"+ arrear_emp_id+"/"+ arrear_to_pay_month,
			type: "GET",
			dataType: "JSON",
			async: false,
			success: function(res)
			{
				//alert(res.flag);
				console.log(res);
				if(res.flag == 0){  
					 succeed = true;
				}else {
					alert("This month is already exits!!!");
					succeed = false;
				} 
				//alert (data.br_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});

		return succeed;	 
}

	paid_status_change();
 function paid_status_change(){
		var paid_status = document.getElementById("paid_status").value;
		 var x = document.getElementById("show_hide_day"); 
		 var y = document.getElementById("show_hide_amount"); 
		 var z = document.getElementById("show_hide_comment"); 
		// var x = document.getElementById("show_hide_day_amount"); 
		 if(paid_status == 2){ 
			x.style.display = "block"; 
			y.style.display = "block"; 
			z.style.display = "block"; 
			document.getElementById("arrear_paid_days").required = true;
			document.getElementById("arrear_paid_basic").required = true;
		 }else{  
			x.style.display = "none"; 
			y.style.display = "none"; 
			z.style.display = "none"; 
			document.getElementById("arrear_paid_days").required = false;
			document.getElementById("arrear_paid_basic").required = false;
		 }   
	}
	/* function paid_day_calculation() {  
		var arrear_basic_amount = parseFloat(document.getElementById("arrear_basic_amount").value);
		var arrear_days = parseFloat(document.getElementById("arrear_days").value);
		var arrear_paid_days = parseFloat(document.getElementById("arrear_paid_days").value);
		//alert(arrear_paid_days);
		if(arrear_paid_days < arrear_days){
			document.getElementById("arrear_paid_basic").value = ((arrear_basic_amount / arrear_days) * arrear_paid_days);
		}else{ 
			document.getElementById("arrear_paid_basic").value = '';
			alert("Invalid Day/s");
			
		}
		 
	}  */
	function calc_arrear_amt_payment() { 
		document.getElementById("arrear_paid_basic").value = ''; 
		document.getElementById("arrear_effect_date_from_payment").value = ''; 
		document.getElementById("due_total_basic").value = ''; 
		var arrear_effect_date_from = document.getElementById("arrear_effect_date_from").value;
		var arrear_effect_date_to 	= document.getElementById("arrear_effect_date_to").value; 
		var arrear_basic 			= parseFloat(document.getElementById("arrear_basic").value);
		var arrear_paid_days 		= parseInt(document.getElementById("arrear_paid_days").value);
		var arrear_days 			= parseInt(document.getElementById("arrear_days").value);
		//alert(arrear_basic);
		if(arrear_paid_days < arrear_days){
			if(arrear_paid_days != 0){
				 $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  }
				}); 
				$.ajax({
					type: 'POST',    
					url:"{{ url::to('calc_arrear_amt_payment')}}",
					data:'arrear_effect_date_from='+ arrear_effect_date_from+'&arrear_effect_date_to='+ arrear_effect_date_to+'&arrear_basic='+arrear_basic+'&arrear_paid_days='+arrear_paid_days,
					success: function(res){
						 console.log(res);
						 document.getElementById("arrear_paid_basic").value = res['final_total_basic'];
						 document.getElementById("arrear_effect_date_from_payment").value = res['arrear_effect_date_from_payment']; 
						 document.getElementById("due_total_basic").value = res['due_total_basic'];
					}
				});
			 }else{
				  
				 document.getElementById("arrear_paid_basic").value = '';
			 }
		}else{
			document.getElementById("arrear_paid_basic").value = '';
			alert("Invalid Day/s");
		}
		   
	} 
</script>
<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Arrear").addClass('active');
		});
	</script>
@endsection