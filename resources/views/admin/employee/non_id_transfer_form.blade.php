@extends('admin.admin_master')
@section('title', 'Edit Contractual Transfer')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Contractual <small>Transfer</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Contractual</a></li>
			<li class="active">{{$Heading}}</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
 
		
		<div class="box box-info"> 
	 
			<div class="box-header with-border">
				<h3 class="box-title"> Contractual Transfer </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
			<form id="form" class="form-horizontal" <?php if(empty($mode)){?>  onsubmit="return validateForm()" <?php } ?> action="{{URL::to($action)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}	 
				{!!$method_control!!}
				<input type="hidden" class="form-control" id="designation_code" name="designation_code" value="{{$designation_code}}"> 
				<input type="hidden" class="form-control" id="after_trai_join_date" name="after_trai_join_date" value="{{$after_trai_join_date}}"> 
				<input type="hidden" class="form-control" id="after_trai_br_code" name="after_trai_br_code" value="{{$after_trai_br_code}}"> 
				<input type="hidden" class="form-control" id="next_renew_date" name="next_renew_date" value="{{$next_renew_date}}"> 
				<input type="hidden" class="form-control" id="end_type" name="end_type" value="{{$end_type}}"> 
				<input type="hidden" class="form-control" id="c_end_date" name="c_end_date" value="{{$c_end_date}}">  
				<input type="hidden" class="form-control" id="br_join_date" name="br_join_date" value="{{$br_join_date}}"> 
				<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}"> 
				<input type="hidden" class="form-control" name="tran_db_id" value="{{$tran_db_id}}"> 
				<div class="box-body col-md-7">					
					<div class="form-group">
						<label for="emp_type" class="col-sm-2 control-label">Emp Type: <span style="color:red;">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" onChange="get_employee_info1();" name="emp_type" <?php if($mode == 'readonly'){ ?> style="pointer-events:none;" <?php } ?> id="emp_type" required>
								<option value="" hidden>Select</option>
								
								<?php foreach($all_emp_type as $v_emp_type){?>
									<option value="<?php echo  $v_emp_type->id;?>"><?php echo  $v_emp_type->type_name;?></option>
								<?php } ?> 
							</select>
						</div>
						
						<label for="sacmo_id" class="col-sm-2 control-label">Employee ID  <span style="color:red;">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" <?php echo $mode;?> id="sacmo_id" name="sacmo_id" value="{{$sacmo_id}}" onChange="get_employee_info();" required> 
						</div>
						
					</div>
					<hr> 
					<div class="form-group">
						<label for="effect_date" class="col-sm-2 control-label"> Effect Date: <span style="color:red;">*</span> </label>
						<div class="col-sm-4">
							<input type="date" name="effect_date" id="effect_date" value="{{$effect_date}}" required class="form-control">
						</div>
						
						<label for="from_branch_code" class="col-sm-2 control-label">From Branch:</label>
						<div class="col-sm-4">
							<select class="form-control"   name="from_branch_code" id="from_branch_code" required>
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select> 
						</div>
					</div> 
					<div class="form-group"> 
						<label for="to_branch_code" class="col-sm-2 control-label">To Branch:  <span style="color:red;">*</span></label>
						<div class="col-sm-4">
							<select class="form-control" onchange="set_salary_branch()" name="to_branch_code" id="to_branch_code" required>
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select> 
						</div>
						<label for="comments" class="col-sm-2 control-label"> Comments :</label>
						<div class="col-sm-4">
							 
							<select class="form-control" name="comments" id="comments" > 
								<option value="">Select</option>
								<option value="1">Official</option>
								<option value="2">Personal</option>
								 
							</select> 
						</div>
					</div> 
					<div class="form-group"> 
					<label class="control-label col-md-2">Salary Branch:</label>
						<div class="col-md-4">
							<select name="salary_br_code" id="salary_br_code" required class="form-control">
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select>
						</div>  
					</div>  
					<hr>
					<div class="form-group">
						<div class="col-sm-3">
							<button type="submit" id="submit" class="btn btn-danger">{{$button_text}}</button>
						</div>
					</div>
				</div>	 
				<div class="col-md-5">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
							<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date"> @if($joining_date) {{date("d-m-Y",strtotime($joining_date))}} @endif </span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name">{{$branch_name}} </span>
								</li>
							</ul>
							<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
							
							<!-- /.box-body --> 
						</div>
						<div>
							<center>
								<button type="button" class="btn btn-warning" id="all" onclick="get_transfer();">Show Contractual Transfer History</button>
							</center>
							<br>
							<div>
							<table class="table table-bordered table-striped" id="transfer_history" border="1">
								
							</table>
							</div>
						</div>	
							
						<!-- /.box-body -->	
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
				<!-- /.box-footer -->
			</form>
		</div>
	</section>
	
	
	<script language="javascript">
			
	/* function myFunction() { 
		var emptype = document.getElementById("emp_type").value;
		
			$.ajax({
				url : "{{ url::to('get-non-max') }}"+"/"+emptype,
				type: "GET",
				success: function(data)
				{
					document.getElementById("sacmo_id").value=data;
				}
			});  

		//////////	
		if (emptype == 'non_id') {
			document.getElementById("basic_level").innerHTML = "Consolidated Salary";
		} else if (emptype == 'sacmo') {
			document.getElementById("basic_level").innerHTML = "Basic Salary";
			document.getElementById("npa_level").innerHTML = "NPA";
			document.getElementById("motor_level").innerHTML = "Motor-Cycle / Convence";
		} else if (emptype == 'shs') {
			document.getElementById("basic_level").innerHTML = "Basic Salary";
			document.getElementById("npa_level").innerHTML = "Hardship";
			document.getElementById("motor_level").innerHTML = "Other";
		}
		
	} */
	function set_salary_branch(){
		var to_branch_code = document.getElementById("to_branch_code").value;  
		document.getElementById("salary_br_code").value = to_branch_code;  
	 } 
	function get_employee_info1(){
		document.getElementById("sacmo_id").value = '';
	}
	function get_employee_info()
		{
			var sacmo_id = document.getElementById("sacmo_id").value;
			var emp_type = document.getElementById("emp_type").value;
			
			//alert(emp_type);
			$.ajax({
				url : "{{URL::to('get_nonemployee_transfer')}}"+"/"+ sacmo_id +"/"+emp_type,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
					//alert(data.emp_name);
					if(data.emp_name)
					{ 
						$('#emp_name').html(data.emp_name);
						 
						//var id = document.getElementById("id").value;
						 if(isNaN( data.cancel_date)){ 
							$('#employee_status').html('<b>This Employee Terminated</b>');
							$("#employee_status").removeClass("btn btn-primary btn-block");
							$("#employee_status").addClass("btn btn-danger btn-block");
							$('#submit').attr("disabled", true);
						}else{ 
							$('#employee_status').html('<b>Active Employee</b>');
							$("#employee_status").removeClass("btn btn-danger btn-block");
							$("#employee_status").addClass("btn btn-primary btn-block");
							$('#submit').removeAttr('disabled');
						}
						$('#designation_name').html(data.designation_name);
						$('#branch_name').html(data.branch_name);
						$('#salary_br_code').val(data.salary_br_code);
						$('#designation_code').val(data.designation_code);
						$('#after_trai_join_date').val(data.after_trai_join_date);
						$('#after_trai_br_code').val(data.after_trai_br_code);
						$('#next_renew_date').val(data.next_renew_date);
						$('#end_type').val(data.end_type);
						$('#c_end_date').val(data.c_end_date);
						$('#from_branch_code').val(data.branch_code);
						$('#joining_date').html(data.joining_date);
						$('#br_join_date').val(data.br_join_date);
						$('#emp_id').val(data.emp_id); 
						//$('#br_code').val(data.br_code); 
						//document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";	
					}
					else
					{  
						$('#form').trigger("reset");
						//document.getElementById("emp_photo").src = "{!!asset('public/employee/"+data.emp_photo+"')!!}";
						$('#emp_type').val(data.emp_type); 
						$('#from_branch_code').val(data.branch_code); 
						$('#salary_br_code').val(data.salary_br_code); 
						$('#designation_code').val(data.designation_code);
						$('#after_trai_join_date').val(data.after_trai_join_date);
						$('#after_trai_br_code').val(data.after_trai_br_code);
						$('#next_renew_date').val(data.next_renew_date);
						$('#end_type').val(data.end_type);
						$('#c_end_date').val(data.c_end_date);
						$('#sacmo_id').val(data.sacmo_id); 
						$('#emp_id').val(data.emp_id); 
						$('#emp_name').html(''); 
						$('#branch_name').html('');
						$('#designation_name').html(''); 
						$('#joining_date').html('');
						$('#br_join_date').val(data.br_join_date);
						$('#submit').attr("disabled", true);
						$('#employee_status').html('<b>Employee is not Available</b>');
						$("#employee_status").removeClass("btn btn-primary btn-block");
						$("#employee_status").addClass("btn btn-danger btn-block");
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$('#employee_status').html('This Employee is not Available');
					//$('#submit').attr("disabled", true);
				}
			});
		}
		function get_transfer()
		{
			var emp_id = document.getElementById("emp_id").value; 
			//alert(emp_id);
			$.ajax({
				url : "{{ url::to('get_nonid_transfer_info') }}"+"/"+ emp_id,
				type: "GET",
				success: function(data)
				{
					//alert(data);
					//$("#upazila_id").attr("disabled", false);
					$("#transfer_history").html(data); 
					//$("#upazi_name").html(data); 
				}
			}); 
		}
		function validateForm()
		{
			var emp_id = document.getElementById("emp_id").value; 
			var effect_date = document.getElementById("effect_date").value;
			var succeed = false;
			//alert(emp_id);
			$.ajax({
				url : "{{ url::to('check_nonid_effect_date') }}"+"/"+ emp_id+"/"+ effect_date,
				type: "GET",
				async: false,
				success: function(data)
				{
					//alert(data);
					 if(data == 1){
						 alert("Effect Date is than the previous Effect Date. Please Delete The previous Entry");
						  succeed = false;
					 }else{
						 succeed = true; 
					 }
				}
			}); 
			return succeed;
		}
		document.getElementById("salary_br_code").value = '<?php echo $salary_br_code;?>';
		document.getElementById("from_branch_code").value = '<?php echo $from_branch_code;?>';
		document.getElementById("to_branch_code").value = '<?php echo $to_branch_code;?>';
		document.getElementById("emp_type").value = '<?php echo $emp_type;?>';
		document.getElementById("comments").value = '<?php echo $comments;?>';
		
</script>
	
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupContractual").addClass('active');
		//$("#Transfer_(Contractual)").addClass('active');
		$('[id^=Transfer_]').addClass('active');
	});
</script>	
 

@endsection