@extends('admin.admin_master')
@section('title', 'Branch Contractual | Staff Cancel');
@section('main_content')
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Resignation</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{$Heading}}</h3>
			</div>			
			<!-- /.box-header -->
			<!-- form start -->
			<form id="form" class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}" enctype="multipart/form-data">
				{{ csrf_field() }}	 
				<input type="hidden" id="id" name="id" value="{{$id}}">
				<input type="hidden" name="br_code" value="{{$br_code}}" id="br_code"> 
				<input type="hidden" name="emp_id" value="{{$emp_id}}" id="emp_id">
				
				<div class="box-body col-md-9">
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Employee Type <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" name="emp_type" <?php if($mode == 'edit'){?> style="pointer-events:none;" <?php } ?> onChange="get_employee_info1()" id="emp_type"  required>
								<?php foreach($all_emp_type as $v_emp_type){?>
									<option value="<?php echo  $v_emp_type->id;?>"><?php echo  $v_emp_type->type_name;?></option>
								<?php } ?>  
							</select>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">  
								<select class="form-control" onChange="get_employee_info();"  id="emp_code" <?php if($mode == 'edit'){?> style="pointer-events:none;" <?php } ?> name="emp_code" required>	
								
									<?php if ($results){ ?>
									<option value="">--Select--</option>
									<?php foreach($results as $v_result){
											if(empty($v_result->cancel_date)){ 
											?> 
										<option value="<?php echo $v_result->sacmo_id; ?>"><?php echo $v_result->emp_name; ?></option> 
									<?php } } }else{  ?>
										<option value="<?php echo $emp_code; ?>"><?php echo $emp_name; ?></option> 
										
									<?php } ?>
							</select>
						</div> 
					</div>
					<hr>
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Cancel Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="cancel_date" name="cancel_date" value="{{$cancel_date}}" required>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Resigned By <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="cancel_by" name="cancel_by" required>						
								<option value="Self">Self</option>
								<option value="Ogranization">Ogranization</option>
								<option value="Termination">Termination</option>
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
				<div class="col-md-3">
					 <!-- Profile Image -->
					<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/default.png')}}" alt="User profile picture">
						<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
						<p class="text-muted text-center" id="designation_name"></p>
						<ul class="list-group list-group-unbordered"> 
						<li class="list-group-item">
							<b>Org Joining Date : </b><span id="joining_date"><?php if(!empty($joining_date)) { echo date("d-m-Y",strtotime($joining_date));} ?></span>
						</li>
						<li class="list-group-item">
							<b>Present Working Station : </b><span id="branch_name">{{$branch_name}}</span>
						</li>
						</ul>
						<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
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
	
	<script>
	function get_employee_info1(){
		document.getElementById("emp_code").value = '';
		var emp_type = document.getElementById("emp_type").value;
		$.ajax({ 
				url : "{{URL::to('non_id_branch_wise_staff')}}"+"/"+emp_type,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{		 
					 console.log(data);
					 var t_row = '';
					   t_row = "<option value=''>--Select--</option>"; 
					 for(var x in data["data"]) {
						 if(isNaN(data["data"][x]["cancel_date"])){ 
						 }else{
							t_row +=  "<option value='"+data["data"][x]["sacmo_id"]+"'>"+data["data"][x]["emp_name"]+"</option>"; 
						 } 
					 }
					  $('#emp_code').html(t_row);
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{  
				}
			});
		
		
	}
		$(document).ready(function() {
			var button_text = document.getElementById("submit").innerHTML;
			if(button_text == 'Save')
			{
				$('#emp_id').removeAttr('disabled');
				$('#submit').attr("disabled", true);
			}
			else
			{
				$('#emp_id').attr("disabled", true);
				$('#submit').removeAttr('disabled');
			}
			document.getElementById("branch_name").innerHTML = '{{$branch_name}}';
			document.getElementById("emp_type").value = '{{$emp_type}}';
			document.getElementById("cancel_by").value = '{{$cancel_by}}';
		})
		
		function get_employee_info()
		{
			var emp_code = document.getElementById("emp_code").value;
			var emp_type = document.getElementById("emp_type").value;
			/* if(emp_type == 'non_id'){
				var emp_type1 = 1;
			}else if(emp_type == 'sacmo'){
				var emp_type1 = 2;
			}else if(emp_type == 'shs'){
				var emp_type1 = 3;
			} */
			//alert(emp_type);
			//return;
			 $.ajax({ 
				url : "{{URL::to('get_nonid_info_br')}}"+"/"+ emp_code +"/"+emp_type,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{		 
					//alert(data.emp_id);
					//console.log(data);
					//return;
					if(data.emp_name !='' && data.cancel_date == '')
					{										
						$('#br_code').val(data.br_code);
						$('#emp_id').val(data.emp_id);						
						$('#emp_name').html(data.emp_name);
						$('#branch_name').html(data.branch_name);
						$('#joining_date').html(data.joining_date);
						
						$('#employee_status').html('Active Employee');
						$('#submit').attr("disabled", false);
					}
					else if(data.emp_name !='' && data.cancel_date != '')
					{
						$('#br_code').val('');
						$('#emp_id').val('');
						$('#emp_name').html('');
						$('#branch_name').html('');
						$('#employee_status').html('Employee is cancelled');
						$('#submit').attr("disabled", true);
					}
					else
					{
						$('#br_code').val('');
						$('#emp_id').val('');
						$('#emp_name').html('');
						$('#branch_name').html('');
						$('#joining_date').html('');
						$('#employee_status').html('Employee is not Available');
						$('#submit').attr("disabled", true);
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#br_code').val('');
					$('#emp_id').val('');
					$('#emp_name').html('');
					$('#branch_name').html('');
					$('#joining_date').html('');
					$('#employee_status').html('Employee is not Available');
					$('#submit').attr("disabled", true);
				}
			});
		}

	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupBranch_Contractual").addClass('active');
			$("#Staff_Cancel").addClass('active');
		});
	</script>
@endsection