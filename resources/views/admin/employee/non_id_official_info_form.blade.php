@extends('admin.admin_master')
@section('title', 'Contractual | Official Info')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Official Information <small>All contractual official info</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Official Information</a></li>
			<li class="active">{{$Heading}}</li>
		</ol>
	</section>

	<!-- Main content -->
	
	<?php
	$allreligions = array('Islam'=>'Islam','Hinduism'=>'Hinduism','Christianity'=>'Christianity','Buddhism'=>'Buddhism','Other'=>'Other');
	$allbloods = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','7'=>'O+','O-'=>'O-');
	?>

	<section class="content">
 
		
		<div class="box box-info"> 
	 
			<div class="box-header with-border">
				<h3 class="box-title"> Official Information </h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
			<form id="form" class="form-horizontal" <?php if(empty($mode)){?>  onsubmit="return validateForm()" <?php } ?> name="employee_nonid" action="{{URL::to($action)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}	 
				{!!$method_control!!}
				<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}"> 
				<input type="hidden" class="form-control" id="br_join_date" name="br_join_date" value=""> 
				<input type="hidden" class="form-control" id="after_trai_join_date" name="after_trai_join_date" value=""> 
				<div class="box-body col-md-8">	
					
					<div class="form-group">
						<label for="emp_type" class="col-sm-3 control-label">Emp Type: <span style="color:red;">*</span> </label>
						<div class="col-sm-3">
							<select class="form-control" onChange="get_employee_info1()" name="emp_type" <?php if($mode == 'edit'){?> style="pointer-events:none;" <?php } ?> id="emp_type" required>
								<option value="" hidden>Select</option>
								
								<?php foreach($all_emp_type as $v_emp_type){?>
								<option value="<?php echo  $v_emp_type->id;?>"><?php echo  $v_emp_type->type_name;?></option>
							<?php } ?>
								 
							</select>
						</div>
						
						<label for="sacmo_id" class="col-sm-3 control-label">Employee ID <span style="color:red;">*</span> </label>
						<div class="col-sm-3">
							<input type="text" class="form-control" <?php if($mode == 'edit'){?> readonly <?php } ?> id="sacmo_id" name="sacmo_id" value="{{$sacmo_id}}" onChange="get_employee_info();" required> 
						</div>
						
					</div>
					<div class="form-group">
						<!--<label class="control-label col-md-3">Designation: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<select class="form-control" name="designation_code" id="designation_code" required>
								<option value="" hidden>Select</option>
								@foreach ($designation as $v_designation)
									<option value="{{$v_designation->designation_code}}">{{$v_designation->designation_name}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>-->
						<input type="hidden" name="designation_code" id="designation_code" value="{{$designation_code}}" class="form-control">
						<input type="hidden" name="br_code" id="br_code" value="{{$br_code}}" class="form-control">
						<input type="hidden" name="salary_br_code" id="salary_br_code" value="{{$salary_br_code}}" class="form-control">
						<!--<label class="control-label col-md-3">Joining Branch: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<select name="br_code" id="br_code" required class="form-control">
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select>
							<span class="help-block"></span>
						</div>-->
					</div> 
					<!--<div class="form-group"> 
						<label class="control-label col-md-3">Org. Joining Date: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<input type="date" name="joining_date" id="joining_date" value="{{$joining_date}}" onchange="set_effect_date();" required class="form-control">
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3">Br Join Date(After Training): </label>
						<div class="col-md-3">
							<input type="date" name="after_trai_join_date" id="after_trai_join_date" value=""  class="form-control">
							<span class="help-block"></span>
						</div>
					</div>-->
					<div class="form-group">
					 <label class="control-label col-md-3">Contract Renew Date: <span style="color:red;">*</span> </label>
						<div class="col-md-3">
							<input type="date" name="next_renew_date" id="next_renew_date" value="{{$next_renew_date}}" required class="form-control">
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3" id="c_end_date_lebel">Contract Ending Date:  </label>
						<div class="col-md-3">
							<input type="date" name="c_end_date" <?php if($end_type == 0){ ?>  readonly <?php }  ?> id="c_end_date" value="{{$c_end_date}}" class="form-control">
							<span class="help-block">Till the Project is running &nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="change_contract_end_type()" name="end_type" id="end_type" value="{{$end_type}}" <?php if($end_type == 0){ ?> checked <?php }  ?>></span>
						</div>
						<!--<label class="control-label col-md-3">Salary Branch: <span style="color:red;">*</span></label>
						<div class="col-md-3">
							<select name="salary_br_code" id="salary_br_code" required class="form-control">
								<option value="" hidden>-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select>
						</div>-->
					<!--<label class="control-label col-md-3">Branch ( After Training): </label>
						<div class="col-md-3"> 
							<span class="help-block"></span>
							<select name="after_trai_br_code" id="after_trai_br_code"  class="form-control">
								<option value="">-Select Branch-</option>
								@foreach ($branches as $v_branches)
								<option value="{{$v_branches->br_code}}">{{$v_branches->branch_name}}</option>
								@endforeach
							</select> 	
						</div>-->
					</div> 
					<hr>
					<div class="form-group">
						<div class="col-sm-3"> 
							<button type="submit" id="submit" class="btn btn-danger">{{$button_text}}</button>
						</div>
					</div>
				</div>	
				<div class="col-md-4">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img id="emp_photo" class="profile-user-img img-responsive img-circle" src="" alt="Employee Photo"/>
							<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
							<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
							<ul class="list-group list-group-unbordered">
								<li class="list-group-item">
									<b>Org Joining Date : </b><span id="joining_date_view"> @if($joining_date) {{date("d-m-Y",strtotime($joining_date))}} @endif </span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name"> {{$branch_name}} </span>
								</li>
							</ul>
							<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
						</div>
						<!-- /.box-body -->
						<div>
							<center>
								<button type="button" class="btn btn-warning" id="all" onclick="get_nonid_official_info();">Show Contractual Official History</button>
							</center>
							<br>
							<div>
							<table class="table table-bordered table-striped" id="transfer_history" border="1">
								
							</table>
							</div>
						</div>				
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
	function validateForm()
		{
			var emp_id = document.getElementById("emp_id").value; 
			var effect_date = document.getElementById("next_renew_date").value;
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
	function get_employee_info1(){
		document.getElementById("sacmo_id").value = '';
	}
	function get_nonid_official_info()
		{
			var emp_id = document.getElementById("emp_id").value; 
			//alert(emp_id);
			$.ajax({
				url : "{{ url::to('get_nonid_official_info') }}"+"/"+ emp_id,
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
	function get_employee_info()
		{
			var sacmo_id = document.getElementById("sacmo_id").value;
			var emp_type = document.getElementById("emp_type").value;
			 
			//alert(emp_type);
			$.ajax({
				url : "{{URL::to('get_nonemployee_official_info')}}"+"/"+ sacmo_id +"/"+emp_type,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
					//alert(data.emp_name);
					if(data.emp_name)
					{ 
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
						$('#emp_name').html(data.emp_name); 
						$('#designation_name').html(data.designation_name);
						$('#designation_code').val(data.designation_code);
						$('#br_code').val(data.br_code);
						$('#salary_br_code').val(data.salary_br_code);
						$('#after_trai_join_date').val(data.after_trai_join_date);
						$('#br_join_date').val(data.br_join_date);
						$('#designation_name').html(data.designation_name);
						$('#branch_name').html(data.branch_name);
						$('#joining_date_view').html(data.joining_date);
						$('#emp_id').val(data.emp_id);  
					}
					else
					{  
						$('#form').trigger("reset"); 
						$('#emp_type').val(data.emp_type); 
						$('#sacmo_id').val(data.sacmo_id); 
						$('#emp_id').val(data.emp_id); 
						$('#emp_name').html(''); 
						$('#branch_name').html('');
						$('#designation_name').html(''); 
						$('#joining_date_view').html('');
						$('#designation_code').val('');
						$('#br_code').val('');
						$('#salary_br_code').val('');
						$('#br_join_date').val('');
						$('#after_trai_join_date').val('');
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
		function change_contract_end_type()
		{
			 var end_type = document.getElementById("end_type");
				   
				  if (end_type.checked == true){
					   document.getElementById("c_end_date").value = "";
					   $('#c_end_date_lebel').html("Contract Ending Date:");
					  $('#c_end_date').attr("readonly", true);  
					  $('#c_end_date').removeAttr('required'); 
					 // alert('ok');
					
				  } else {
					  $('#c_end_date_lebel').html("Contract Ending Date: <span style='color:red;'>*</span>");
					$('#c_end_date').removeAttr('readonly');
					 $('#c_end_date').attr("required", true); 
					 
					
				  }
			
		}
 <?php if($mode == 'edit'){ ?>
	 
	 change_contract_end_type();
 <?php }?>
		document.getElementById("emp_type").value= "{{$emp_type}}"; 
		//document.getElementById("designation_code").value= "{{$designation_code}}"; 
		document.getElementById("br_code").value= "{{$br_code}}"; 
		document.getElementById("salary_br_code").value= "{{$salary_br_code}}"; 
		 
	</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupContractual").addClass('active');
		$("#Official_info").addClass('active');
	});
</script>
@endsection