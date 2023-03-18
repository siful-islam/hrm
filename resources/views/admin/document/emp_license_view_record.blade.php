@extends('admin.admin_master')
@section('title','View License')
@section('main_content')
 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>License<small>Attachment</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Attachment</a></li>
			<li class="active">License</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
		<div class="row"> 
		<div class="col-md-12">
			<div class="box box-info"> 
			<!-- /.box-header -->
			<!-- form start -->
				<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST">
                {{csrf_field()}}  
								<div class="box-body">   
									<div class="form-group"> 
										 
										   <label class="control-label col-md-2">Employee ID</label>
											<div class="col-md-2">
												<input type="text" name="emp_id1" id="emp_id1" class="form-control" value="" required>
												<span class="help-block"></span>
											</div> 
											<div class="col-md-3">
											 <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
											</div> 
									</div>  	
							   </div>  
					</form>
							<?php if(!empty($emp_info)){ ?>
									 <div class="box box-info"> 
											 <div class="box-body"> 
												<div class="row">
													<div class="col-md-12">
													<table class="table no-border" style="width:100%;">
														<tr>
															<th  colspan="8" style="text-align:center;">STAFF STATUS HISTORY DETAILS </th>
														</tr>
													</table>
													 <table class="table table-bordered" style="width:100%;">
															<thead>
																<tr>
																  <th colspan="7" style="text-align:center;">JOB STATUS</th> 
																</tr>
																<tr>
																  <th>Entry Date</th>
																  <th>Employee Name</th>
																  <th>Designation</th>
																  <th>Working Station</th>
																  <th>License Number</th>
																  <th>License Expiry Date</th>
																  <th>Remain Days</th>
																</tr>
															</thead>
															@if(!empty($emp_name))
															<tbody>	 
																<tr>
																  <td>@if(!empty($created_at)) {{date('d-m-Y',strtotime($created_at))}} @endif</td>
																  <td>{{$emp_name}}</td>
																  <td>{{$designation_code}}</td>
																  <td>{{$branch_code}}</td> 
																  <td>{{$license_number}}</td>
																  <td>{{$license_exp_date}}</td>
																   <td><?php 
																   if(!empty($license_exp_date)){
																   
																   $current_date = date('Y-m-d');
																   date_default_timezone_set('Asia/Dhaka');
																	$date1=date_create($current_date);
																	$date2=date_create($license_exp_date);
																	$diff=date_diff($date1,$date2);
																	$total_month= ($diff->format("%y Year %m Month %d Day"));
																   echo $total_month;}
																  ?></td>
																</tr>
															</tbody>
															@endif
													</table> 
												</div> 					
												</div> 					
										</div>
								</div>
							<?php  } if(!empty($emp_document_list)){
												$ddd = explode('.',$emp_document_list->document_name);
												if($ddd[1] == 'pdf' || $ddd[1] == 'PDF'){
													$ext = 1;
												}else if($ddd[1] == 'doc' || $ddd[1] == 'DOC' ){
													$ext = 2;
												}else{
													$ext = 3;
												}
												if($ext == 1){
												?>
												<div class="box-body table-responsive no-padding" align="center">
													<embed   src="{{asset('storage/attachments/driver_license/'.$emp_document_list->document_name)}}" type="application/pdf"  width="70%"  style="min-height:500px;">
												</div>
												
												<?php }else if($ext == 2){
												?>
												<div class="box-body table-responsive no-padding" align="center" style="min-height:500px;">
													<iframe   src="{{asset('storage/attachments/driver_license/'.$emp_document_list->document_name)}}"  width="70%"></iframe>
												</div>
												
												<?php }else{
												?>
												<div class="box-body table-responsive no-padding" align="center" style="min-height:500px;">
													<img  src="{{asset('storage/attachments/driver_license/'.$emp_document_list->document_name)}}"  width="70%">
												</div>
												
												<?php } ?>
										<?php
										}
										?>    
				</div> 
			</div>
		</div>
</section>  
<script> 
	$("#emp_id1").val({{$emp_id}});  
</script> 
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupDriving_License").addClass('active');
			$("#View_License").addClass('active');
		});
	</script>

@endsection