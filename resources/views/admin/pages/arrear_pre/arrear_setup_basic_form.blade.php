@extends('admin.admin_master')
@section('title', 'Arrear Setup')
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
	<h1>add-arrear-setup</h1>
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
			<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="box box-info">
				<div class="box-body">	
					
					<input type="hidden" class="form-control" id="basic_salary" value="">
					<div class="form-group" >
						<label for="arrear_emp_id" class="col-sm-2 col-md-offset-1 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" id="arrear_emp_id" name="arrear_emp_id" value="{{$arrear_emp_id}}" onChange="get_employee_info();" required>
						</div>
					</div>
					<div class="form-group">	
						<label for="emp_name" class="col-sm-2 col-md-offset-1 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="emp_name" value="" required>						
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>  
					<div class="form-group">
						<label for="arrear_effect_date_from" class="col-sm-2 col-md-offset-1 control-label">From <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" onChange="set_date_range_from()" id="arrear_effect_date_from" name="arrear_effect_date_from" value="" required>							
						</div>
					</div>
					<div class="form-group">	
						<label for="arrear_effect_date_to" class="col-sm-2 col-md-offset-1 control-label">To <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" onChange="set_date_range()" id="arrear_effect_date_to" name="arrear_effect_date_to" value="" required>
						</div>
					</div>
					<div class="form-group">		
						<label for="arrear_days" class="col-sm-2 col-md-offset-1 control-label">Days<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="arrear_days" name="arrear_days" value="" required>
							 
						</div>
					</div>
					<div class="form-group">	
						<label for="arrear_basic" class="col-sm-2 col-md-offset-1 control-label">Basic <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" onChange="calc_arrear_amt();" id="arrear_basic" name="arrear_basic" value="{{$arrear_basic}}" required>
						</div>
					</div>		
					<div class="form-group">		
						<label for="arrear_basic_amount" class="col-sm-2 col-md-offset-1 control-label">Basic Amount<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off"   class="form-control" onkeydown="event.preventDefault()"  id="arrear_basic_amount" name="arrear_basic_amount" value="" required >
							 
						</div>
					</div> 
					<div class="form-group">	
						<label for="comments" class="col-sm-2 col-md-offset-1 control-label">Comments</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="comments" name="comments" value="{{$comments}}">
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
	function get_employee_info() {
		var arrear_emp_id = $("#arrear_emp_id").val();	
		//alert (arrear_emp_id);
		$.ajax({
			url : "{{ url::to('get_emp_info_arr') }}"+"/"+ arrear_emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					//alert ('This ID is not available!'); 
					document.getElementById("emp_name").value = ''; 
					document.getElementById("basic_salary").value = ''; 
					document.getElementById("arrear_basic").value=''; 
					document.getElementById("arrear_basic_amount").value=''; 
				} else {
					document.getElementById("arrear_emp_id").value=data.arrear_emp_id;
					document.getElementById("emp_name").value=data.emp_name; 
					document.getElementById("basic_salary").value=data.basic_salary; 
					document.getElementById("arrear_basic").value=''; 
					document.getElementById("arrear_basic_amount").value=''; 
					
				}
				//alert (data.br_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});
	}	
</script>
<script type="text/javascript">
 function set_date_range() {
		//$('#btnSave').attr('disabled', false);
		var arrear_effect_date_from = document.getElementById('arrear_effect_date_from').value;
		var arrear_effect_date_to = document.getElementById('arrear_effect_date_to').value;
		var start = new Date(arrear_effect_date_from);
		var end = new Date(arrear_effect_date_to);
		var days = (end - start) / 1000 / 60 / 60 / 24;
		
		document.getElementById('arrear_days').value = days + 1;
		document.getElementById("arrear_basic").value = '';
		document.getElementById("arrear_basic_amount").value = '';
		//alert(days + 1);
	}
function set_date_range_from() {
		//$('#btnSave').attr('disabled', false);
		var arrear_effect_date_from = document.getElementById('arrear_effect_date_from').value;
		document.getElementById('arrear_days').value = 1;
		document.getElementById("arrear_effect_date_to").value = arrear_effect_date_from;
		document.getElementById("arrear_effect_date_to").min = arrear_effect_date_from;
		document.getElementById("arrear_basic").value = '';
		document.getElementById("arrear_basic_amount").value = '';
		//alert(arrear_effect_date_from);
	}
function calc_arrear_amt() { 
		document.getElementById("arrear_basic_amount").value = '';
		var basic_salary = parseFloat(document.getElementById("basic_salary").value);
		var arrear_emp_id = document.getElementById("arrear_emp_id").value;
		var arrear_effect_date_from = document.getElementById("arrear_effect_date_from").value;
		var arrear_effect_date_to = document.getElementById("arrear_effect_date_to").value;
		var arrear_days = document.getElementById("arrear_days").value;
		var arrear_basic = parseFloat(document.getElementById("arrear_basic").value);
		//alert(arrear_basic);
		if(arrear_basic > basic_salary){
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			}); 
			$.ajax({
				type: 'POST',    
				url:"{{ url::to('calculation_arrear_amt')}}",
				data:'arrear_emp_id='+ arrear_emp_id+'&arrear_effect_date_from='+ arrear_effect_date_from+'&arrear_effect_date_to='+ arrear_effect_date_to+'&arrear_days='+arrear_days+'&arrear_basic='+arrear_basic,
				success: function(res){
					 console.log(res);
					 document.getElementById("arrear_basic_amount").value = res['final_total_basic'];
				}
			});
		}else{
			document.getElementById("arrear_basic_amount").value = '';
			alert("Invalid Basic");
			
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