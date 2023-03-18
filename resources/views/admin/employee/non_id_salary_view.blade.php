@extends('admin.admin_master')
@section('title','Contractual|Salary')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Appointment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> HRM</a></li>
			<li><a href="#">Employee</a></li>
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
					<h3 class="box-title" style="float:left;">Salary Information&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
					 <span class="help-block">is Consolidated? &nbsp;&nbsp;&nbsp;<input type="checkbox"   id="is_Consolidated1" onclick="change_is_cosoleded()" value="{{$is_Consolidated}}" <?php if($is_Consolidated == 2) echo "checked";?> ></span>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form name="employee_nonid" class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="employee_nonid" enctype="multipart/form-data">
                {{ csrf_field() }}
				{!!$method_control!!}

				<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="{{$emp_id}}"> 
				<div class="box-body col-md-8">	
					<div class="form-group">
					<div class="col-md-6"> 
						<label for="emp_type" class="col-sm-6 control-label">Emp Type:</label>
						<div class="col-sm-6">
							<span class="form-control"> <?php echo  $type_name; ?></span>
							<span class="help-block"></span>
						</div>
						</div>
					<div class="col-md-6"> 	
						<label for="sacmo_id" class="col-sm-6 control-label">Employee ID </label>
						<div class="col-sm-6">
							<span class="form-control">{{$sacmo_id}}</span> 
							<span class="help-block"></span>
						</div>
						
					</div>

					<div class="col-md-6"> 
					<label class="control-label col-md-6">Effect Date: </label>
						<div class="col-md-6"> 
							<span class="form-control">{{date("d-m-Y",strtotime($effect_date))}}</span>
							<span class="help-block"></span>
							 
						</div>	
						</div>
					<div class="col-md-6"> 						
					<label class="control-label col-md-6">Consolidated Salary: </label>
						<div class="col-md-6">
							<span class="form-control">{{$console_salary}}</span>
							<span class="help-block"></span>
							  
						</div>	
				</div>
				<div class="col-md-6"> 
                    <label class="control-label col-md-6">Basic Salary:</label>
                    <div class="col-md-6">
                      <span class="form-control">{{$basic_salary}}</span>
					  <span class="help-block"></span>
                       
                    </div>
                    </div>
					<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-6">House Rent: </label>
                    <div class="col-md-6">
                          <span class="form-control">{{$house_rent}}</span>
						  <span class="help-block"></span>
                        
                    </div> 
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
                    <label class="control-label col-md-6">Medical : </label>
                    <div class="col-md-6">
                         <span class="form-control">{{$medical_a}}</span>
						 <span class="help-block"></span>
                    </div>
                    </div>
					<div class="col-md-6"> 
					<label class="control-label col-md-6">Conveyance </label>
                    <div class="col-md-6">
                           <span class="form-control">{{$convence_a}}</span>
						   <span class="help-block"></span>
                    </div> 
                </div>  
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-6">Conveyance & Fuel Allowance:</label>
                    <div class="col-md-6"> 
                        <span class="form-control">{{$f_allowance}}</span>
						<span class="help-block"></span>
                    </div>
                    </div>
					<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-6">NPA :</label>
                    <div class="col-md-6">
                         <span class="form-control">{{$npa_a}}</span>
						 <span class="help-block"></span>
                    </div>
                </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 	
                    <label class="control-label col-md-6" id="motor_level">Motor-Cycle</label>
                    <div class="col-md-6">
                         <span class="form-control">{{$motor_a}}</span>
						 <span class="help-block"></span>
                    </div>
                    </div>
					<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
					<label class="control-label col-md-6">Field Allowance: </label>
                    <div class="col-md-6">
                         <span class="form-control">{{$field_a}}</span>
						 <span class="help-block"></span>
                    </div> 
                </div> 
				<div class="col-md-6"> 
				<label class="control-label col-md-6" id="mobile_level">Mobile : </label>
                    <div class="col-md-6">
                          <span class="form-control">{{$mobile_a}}</span>
						  <span class="help-block"></span>
                    </div>
                    </div>
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
                    <label class="control-label col-md-6">  Mobile & Internet : </label>
                    <div class="col-md-6"> 	  	       	 	 	 
                         <span class="form-control">{{$internet_a}}</span>
						 <span class="help-block"></span>
                    </div>
					
					
                </div> 
				<div class="col-md-6" <?php if($is_field_reduce == 1){ ?> style="display:none;" <?php } ?>> 
                    <label class="control-label col-md-6"> Maintenance Allowance : </label>
                    <div class="col-md-6"> 	  	       	 	 	 
                         <span class="form-control">{{$maintenance_a}}</span>
						 <span class="help-block"></span>
                    </div>
					
					
                </div> 
				<div class="col-md-6"> 
                    <label class="control-label col-md-6">Gross Salary:</label>
                    <div class="col-md-6"> 
                       <span class="form-control">{{$gross_salary}}</span>
					   <span class="help-block"></span>
                    </div> 
                    </div> 
					<div class="col-md-6"> 
					<label class="control-label col-md-6">Comments: </label>
                    <div class="col-md-6"> 
                     <textarea   class="form-control"><?php echo  $nara_tion;  	?></textarea>
					   <span class="help-block"></span>
                    </div> 
                   </div>  
                </div>  
					<hr>
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
									<b>Org Joining Date : </b><span id="joining_date">  @if($joining_date) {{date("d-m-Y",strtotime($joining_date))}} @endif</span>
								</li>
								<li class="list-group-item">
									<b>Present Working Station : </b><span id="branch_name"> <?php if(!empty($after_trai_branch_name))  echo $after_trai_branch_name; else echo $branch_name;   ?>  </span>
								</li>
							</ul>
							<a href="#" <?php if($cancel_date == ''){  ?> class="btn btn-primary btn-block"; <?php }else { ?> class="btn btn-danger btn-block" <?php }?>  id="employee_status"><b><?php if($cancel_date == ''){ echo "Active Employee"; }else { echo "This Employee Terminated"; }?></b></a>
						</div> 
						<!-- /.box-body --> 	
						<div>
							<center>
								<button type="button" class="btn btn-warning" id="all" onclick="get_salary();">Show Contractual Salary History</button>
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
			</form>

		</div>
	</section> 
	<script>
	
		function get_salary()
		{
			var emp_id = document.getElementById("emp_id").value; 
			//alert(emp_id);
			$.ajax({
				url : "{{ url::to('get_nonid_salary_info') }}"+"/"+ emp_id,
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
	</script>
		 <script type="text/javascript">
    $(document).ready(function() {
      $("#MainGroupContractual").addClass('active');
      $("#Salary").addClass('active');
    }); 
  </script>
@endsection