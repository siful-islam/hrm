@extends('admin.admin_master')
@section('title','Diary or Calendar Org')
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
			
			
			<form   action="{{URL::to('/requisition_search_emp_info')}}" method="post">
					  {{csrf_field()}}  
					<div class="row"> 
						<div class="col-md-4">
							<div class="form-group"> 
								<label class="control-label col-md-4"> Designation:</label>
									<div class="col-md-6">
										<select name="desig_group_code" id="desig_group_code" class="form-control"  required> 
											<option value="" >Select</option>
											 <?php foreach($all_designation_group as $v_desig_group){ ?>
													<option value="<?php  echo $v_desig_group->desig_group_code;?>" ><?php  echo  $v_desig_group->desig_group_name;?></option> 
											 <?php } ?>
										</select>
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
			
			
			
			
			<?php if(!empty($all_result)){?>
				<br>
				<br>
				<form class="form-horizontal"  action="{{URL::to('/insert_dairy_calender_org')}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} 
						<table class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>emp Name</th>
									<th>Designation</th> 
									<th><div class="pull-left">Org Diary </div> <div class="pull-right" style="padding-right:50px;">All <input type="checkbox" name="diary_is_all" id="diary_is_all" value=""></div></th> 
									<th><div class="pull-left">Org Calendar </div> <div class="pull-right" style="padding-right:50px;">All <input type="checkbox" name="calender_is_all" id="calender_is_all" value=""></div></th>  
								</tr>
							</thead>
							<tbody>
								
								<?php
									 
									$i=1;
									$all_emp_id = '';
								 foreach($all_result as $emp){  
									?> 
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $emp['emp_id'];?>
									<input type="hidden" name="emp_id[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['emp_id'];?>">
									</td>
									<td> <?php echo $emp['emp_name'];?> </td>
									<td><?php echo $emp['designation_name'];?>
									<input type="hidden" name="designation_code[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['designation_code'];?>">
									<input type="hidden" name="branch_code[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['branch_code'];?>">
									</td>  
									<td><input type="text" name="org_num_dairy[<?php echo $i;?>]" id="org_num_dairy<?php echo $i;?>" class="form-control" value="0"></td> 
									<td><input type="text" name="org_num_calender[<?php echo $i;?>]" id="org_num_calender<?php echo $i;?>" class="form-control" value="0" ></td> 
									 
								</tr>
								<?php 	$i++; } 
								?>
							</tbody>    
						</table> 
				
						 
							<div class="row"> 
								<div class="col-md-11">
									<input type="hidden" name="tot_row" id="tot_row" class="form-control" value="<?php echo $i;?>">
										<div class="pull-right"> 
											<input type="submit" id="submit_btn" class="btn btn-primary" value="Save"> 		 
										</div>
								</div>
							</div>  
						
					</form>
			<?php } ?>
		</div>
</section> 
 
<script>
$('#diary_is_all').click(function() {
	var tot_row = $("#tot_row").val();
		 if ($(this).is(':checked')) {  
			for(var k = 1; k < tot_row; k++){
				$("#org_num_dairy"+k).val(1); 
			} 
		} else { 
			
			for(var k= 1; k < tot_row; k++){
				$("#org_num_dairy"+k).val(0);
			} 
		} 
	});
$('#calender_is_all').click(function() {
	var tot_row = $("#tot_row").val();
		 if ($(this).is(':checked')) {  
			for(var k = 1; k < tot_row; k++){
				$("#org_num_calender"+k).val(1); 
			} 
		} else {  
			for(var k= 1; k < tot_row; k++){
				$("#org_num_calender"+k).val(0);
			} 
		} 
	});
	document.getElementById("desig_group_code").value= "{{$desig_group_code}}";
</script> 
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupRequisition").addClass('active');
			$("#Diary_or_Calendar_Org").addClass('active');
		});
	</script>
@endsection