@extends('admin.admin_master')
@section('title','Contractual|Salary')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Contractual <small>Salary</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Contractual</a></li>
			<li class="active">{{$Heading}}</li>
		</ol>
	</section>
	
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

	<!-- Main content -->
	<section class="content">
		<div class="box box-info"> 
			<div class="box-header with-border"> 
				<h3 class="box-title" style="float:left;">Salary Information&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
					 <span class="help-block">is Consolidated? &nbsp;&nbsp;&nbsp;<input type="checkbox"   id="is_Consolidated1" onclick="change_is_cosoleded()" value="{{$is_consolidated}}" <?php if($is_consolidated == 1) echo "checked";?> ></span>
			</div>
			<div class="box-body">	
				<form id="form" class="form-horizontal" <?php if(empty($mode)){?>  onsubmit="return validateForm()"  <?php } ?>  name="employee_nonid" action="{{URL::to($action)}}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}	 
					{!!$method_control!!}
					<input type="hidden" class="form-control" id="sarok_no" name="sarok_no" value="{{$sarok_no}}"> 
					 
					<input type="hidden" class="form-control" id="br_code" name="br_code" value="{{$br_code}}"> 
					<input type="hidden" class="form-control" id="is_consolidated" name="is_consolidated" value="{{$is_consolidated}}"> 

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="col-md-6">	
									<label for="letter_date" class="col-sm-6 control-label">Search Within Date: <span style="color:red;">*</span></label>
									<div class="col-sm-6">
										 
										<input type="date" class="form-control" autocomplete="off" <?php if($mode == 'edit'){?> readonly <?php } ?> id="letter_date" name="letter_date" value="{{$letter_date}}" onChange="get_employee_info();" required>
										<span class="help-block"></span>
									</div>
								</div> 
								<div class="col-md-6">	
									<label for="emp_id" class="col-sm-6 control-label">Employee ID <span style="color:red;">*</span></label>
									<div class="col-sm-6">
										<input type="number" class="form-control" autocomplete="off" <?php if($mode == 'edit'){?> readonly <?php } ?> id="emp_id" min="200000" name="emp_id" value="{{$emp_id}}" onChange="get_employee_info();" required>
										<span class="help-block"></span>							
									</div>
								</div>
								<div class="col-md-6">	
									<label for="emp_name" class="col-sm-6 control-label">Employee Name <span style="color:red;">*</span></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="emp_name" readonly>
										<span class="help-block"></span>							
									</div>
								</div>
								
								<div class="col-md-6">	
									<label for="designation_name" class="col-sm-6 control-label">Employee Designation <span style="color:red;">*</span></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="designation_name" readonly>
										<span class="help-block"></span>							
									</div>
								</div>
								<div class="col-md-6">	
									<label for="branch_name" class="col-sm-6 control-label">Employee Branch <span style="color:red;">*</span></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="branch_name" readonly>
										<span class="help-block"></span>							
									</div>
								</div>
								<div class="col-md-6">	
									<label for="employee_status" class="col-sm-6 control-label">Employee Status <span style="color:red;">*</span></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="employee_status" readonly>
										<span class="help-block"></span>							
									</div>
								</div>
			
								<div class="col-md-6">	
								<label class="control-label col-md-6">Salary Branch: <span style="color:red;">*</span> </label>
									<div class="col-md-6">
										<select class="form-control" name="salary_br_code" id="salary_br_code"
											required>
											<option value="">-SELECT-</option>
											<?php foreach($branches as $branch) { ?>
											<option value="<?php echo $branch->br_code; ?>"><?php echo $branch->branch_name; ?></option>
											<?php } ?>
										</select>
										<span class="help-block"></span>
									</div>	
								</div>
								<div class="col-md-6">	  
								<label class="control-label col-md-6">Transection: <span style="color:red;">*</span> </label>
									<div class="col-md-6">
										<select class="form-control" name="transection" id="transection" required>
											<option value="16">Contractual Employee</option>
											<!--<?php //foreach ($transections as $v_transections) { ?>
											<option value="<?php //echo $v_transections->transaction_code; ?>"><?php //echo $v_transections->transaction_name; ?>
											</option>
											<?php //} ?>-->
										</select>
										<span class="help-block"></span>
									</div>	
								</div>
								
								<div class="col-md-6">	
								<label class="control-label col-md-6">Salary Effect Date: <span style="color:red;">*</span> </label>
									<div class="col-md-6">
										<input type="date" name="effect_date" id="effect_date" value="<?php echo date('Y-m-d');?>" required class="form-control">
										<span class="help-block"></span>
									</div>	
								</div>
								<div class="col-md-6">	
									<label class="control-label col-md-6">Basic Salary:</label>
									<div class="col-md-6">
										<input type="number" name="salary_basic" id="salary_basic" value="0" onkeyup="calculate(this.value);" onclick="this.select();" dir="rtl" class="form-control">
										<span class="help-block"></span>
									</div>
								</div>

								
								{{-- Allowances --}}
								<div class="col-md-6">	
									<div class="box box-success"> 
										<div class="box-header"> 
												<h5 class=""><b>Allowances</b></h5>
										</div>
										<div class="box-body">
											<?php 
												$plus_items_id = 1;
												if(!empty($salaryPlusItems)){
													foreach ($salaryPlusItems as $key => $value) {
													// $plus_items_id++; 

											?>
												<label class="control-label col-md-8"> <?php echo $value->items_name; ?> </label>
												<div class="col-md-4">
													<input type="hidden" name="plus_item_id[]" id=""  value="<?php echo $value->item_id; ?>"  class="form-control">
													<input type="number" class="form-control plus_item" value="0" name="plus_item[]" onclick="this.select();" dir="rtl" />
													<span class="help-block"></span>
												</div>
											<?php 
													}
												}
											?>
										</div>
									</div>
								</div>

								
								{{-- Deduction --}}
								<div class="col-md-6">	
									<div class="box box-danger"> 
										<div class="box-header"> 
											<h5> <b>Deduction</b></h5>
										</div>
										<div class="box-body">
											<?php 
												
												if(!empty($salaryMinusItems)){
													foreach ($salaryMinusItems as $key => $value) {

											?>
												<label class="control-label col-md-8"> <?php echo $value->items_name; ?> </label>
												<div class="col-md-4">
													<input type="hidden" name="minus_item_id[]" value="<?php echo $value->item_id; ?>"  class="form-control">
													<input type="number" name="minus_item[]" value="0" class="minus_item form-control" onclick="this.select();" dir="rtl">
													<span class="help-block"></span>
												</div>
											<?php 
													}
												}
											?>
										</div>
									</div>
								</div>


								<div class="col-md-6">	
									<label class="control-label col-md-8">Plus Total:</label>
									<div class="col-md-4">
										<input type="number" name="total_plus" id="total_plus" value="0" onkeyup=""  class="form-control" onclick="this.select();" dir="rtl" readonly />
										<span class="help-block"></span>
									</div>
								</div>

								<div class="col-md-6">	
									<label class="control-label col-md-8">Total Payable :</label>
									<div class="col-md-4">
										<input type="number" name="payable" id="payable" value="0" onkeyup=""  class="form-control" onclick="this.select();" dir="rtl" readonly />
										<span class="help-block"></span>
									</div>
								</div>

								<div class="col-md-6">	
									<label class="control-label col-md-8">Minus Total :</label>
									<div class="col-md-4">
										<input type="number" name="total_minus" id="total_minus" value="0" onkeyup=""  class="form-control" onclick="this.select();" dir="rtl" readonly />
										<span class="help-block"></span>
									</div>
								</div>

								<div class="col-md-6">	
									<label class="control-label col-md-8">Net Payable :</label>
									<div class="col-md-4">
										<input type="number" name="net_payable" id="net_payable" value="0" onkeyup=""  class="form-control" onclick="this.select();" dir="rtl" readonly />
										<span class="help-block"></span>
									</div>
								</div>

								<div class="col-md-6">	
									<label class="control-label col-md-8">Gross Total :</label>
									<div class="col-md-4">
										<input type="number" name="gross_total" id="gross_total" value="0" onkeyup=""  class="form-control" onclick="this.select();" dir="rtl" readonly />
										<span class="help-block"></span>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="box-footer">
						<div class="form-group">
							<div class="col-sm-12" style="text-align: right;"> 
								<button type="submit" id="submit" class="btn btn-danger">{{$button_text}}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>



	<script language="javascript">
		$(function(){
			$("#salary_basic").keyup(function(){
				var salary_basic = $('#salary_basic').val();
				if( salary_basic >= 0){
					var plusAmount = 0;
					$('.plus_item').each(function(){
						plusAmount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
					});
					var minusAmount = 0;
					$('.minus_item').each(function(){
						minusAmount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
					});
					var payable = parseInt(salary_basic)+parseInt(plusAmount);
					var net_payable = parseInt(payable)-parseInt(minusAmount);
					$("#payable").val(payable);
					$("#net_payable").val(net_payable);
					$("#gross_total").val( parseInt($("#net_payable").val()));
				}
			});
			
			$(".plus_item").keyup(function(){
				if($(this).val() > 0){
					var plusAmount = 0;
					$('.plus_item').each(function(){
						plusAmount += parseInt($(this).val());  // Or this.innerHTML, this.innerText
					});
					var minusAmount = 0;
					$('.minus_item').each(function(){
						minusAmount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
					});
					$("#total_plus").val(plusAmount);
					$("#payable").val(plusAmount + parseInt($("#salary_basic").val()));
					$("#net_payable").val( parseInt($("#payable").val()) - minusAmount);
					$("#gross_total").val( parseInt($("#net_payable").val()));
				}
			});

			$(".minus_item").keyup(function(){
				if($(this).val() > 0){
					var plusAmount = 0;
					$('.plus_item').each(function(){
						plusAmount += parseInt($(this).val());  // Or this.innerHTML, this.innerText
					});

					var minusAmount = 0;
					$('.minus_item').each(function(){
						minusAmount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
					});

					$("#total_minus").val(minusAmount);
					$("#net_payable").val( parseInt($("#payable").val()) - minusAmount);

					$("#total_plus").val(plusAmount);
					$("#payable").val(plusAmount + parseInt($("#salary_basic").val()));
					$("#net_payable").val( parseInt($("#payable").val()) - minusAmount);
					$("#gross_total").val( parseInt($("#net_payable").val()));
				}
			});
		})

        function minus_calculate(val) {
            var val = val + 1;
            var total = 0;
            for (i = 1; i < val; i++) {

                var minus_value = parseFloat(document.getElementById("minus_item" + i).value);
                var total = total + minus_value;
            }
            document.getElementById("total_minus").value = total;
            ///////
            var payable = parseFloat(document.getElementById("payable").value);
            var gross_total = (payable - total);
            document.getElementById("gross_total").value = gross_total;
        }

		function validateForm()
		{
			var emp_id = document.getElementById("emp_id").value; 
			var effect_date = document.getElementById("effect_date").value;
			var succeed = false;
			$.ajax({
				url : "{{ url::to('check_nonid_salary_effect_date') }}"+"/"+ emp_id+"/"+ effect_date,
				type: "GET",
				async: false,
				success: function(data)
				{
					 if(data == 1){
						 alert("Already Exist This Effect Date!!!!");
						  succeed = false;
					 }else{
						 succeed = true; 
					 }
				}
			}); 
			return succeed;
		}
		
		function change_is_cosoleded()
		{
			 var is_Consolidated1 = document.getElementById("is_Consolidated1");
			  if (is_Consolidated1.checked == true){
				   //alert(is_Consolidated1.checked);
				   $('#is_consolidated').val(1);
					calculate(0);					   
			  } else {
					$('#is_consolidated').val(0); 
					calculate(0);	
			  }
		}
	
		function get_employee_info()
		{
			var emp_id = document.getElementById("emp_id").value;
			var letter_date = document.getElementById("letter_date").value;
			$.ajax({
				url : "{{URL::to('get_nonemployee_info')}}"+"/"+ emp_id +"/"+letter_date,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					//console.log(data);
					
					if(data.emp_name)
					{ 
						if(isNaN( data.cancel_date)){ 
							$('#employee_status').val('Terminated');
							$('#submit').attr("disabled", true);
						}else{ 
							$('#employee_status').val('Active');
							$('#submit').removeAttr('disabled');
						}
						$('#emp_name').val(data.emp_name);  
						$('#designation_name').val(data.designation_name);
						$('#branch_name').val(data.branch_name);
						$('#emp_id').val(data.emp_id); 
						$('#transection').val(data.transection); 
						$('#br_code').val(data.br_code); 
						$('#sarok_no').val(data.sarok_no); 
						$('#salary_br_code').val(data.salary_br_code); 
						$('#effect_date').val(data.effect_date); 
					}
					else
					{  
						$('#form').trigger("reset");
						$('#letter_date').val(data.letter_date); 
						$('#emp_id').val(data.emp_id);  
						$('#transection').val(data.transection);  
						$('#br_code').val(data.br_code); 
						$('#sarok_no').val(data.sarok_no); 
						$('#salary_br_code').val(data.salary_br_code); 
						$('#effect_date').val(data.effect_date); 
						$('#emp_name').val(''); 
						$('#branch_name').val('');
						$('#designation_name').val(''); 
						$('#submit').attr("disabled", true);
						$('#employee_status').val('--');
					} 
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#submit').attr("disabled", true);
				}
			});
		}
		function get_salary()
		{
			var emp_id = document.getElementById("emp_id").value; 
			$.ajax({
				url : "{{ url::to('get_nonid_salary_info') }}"+"/"+ emp_id,
				type: "GET",
				success: function(data)
				{
					$("#transfer_history").html(data); 
				}
			}); 
		} 
	</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
		  $("#MainGroupContractual").addClass('active');
		  $("#Salary").addClass('active');
		}); 
  </script>
@endsection