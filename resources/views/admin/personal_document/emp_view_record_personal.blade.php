@extends('admin.admin_master')
@section('title','View Document')
@section('main_content')
 <style>
 

.clearfix {
  overflow: auto;
}

.img2 {
  float: left;
}
#htm_image_show{
			 position: absolute;
			  top: -42px;
			  left: 0;width:100%;
		 }
 </style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Attachment<small>View</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Attachment</a></li>
			<li class="active">View</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
		<div class="row"> 
		<div class="col-md-4">
			<div class="box box-info">
			<!-- /.box-header -->
			<!-- form start -->
			<?php  $access_label 	= Session::get('admin_access_label');
				$u_user_type 	= Session::get('user_type');
			?>
				<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST">
                {{csrf_field()}}  
					 <div class="box-body">  
									<input type="hidden"   id="u_user_type" class="form-control" value="<?php echo $u_user_type;?>" required> 
									 
									<div class="form-group" style="margin-bottom:0px;"> 
										<label class="control-label col-md-4">Employee ID</label>
											<div class="col-md-5">
												<input type="text" name="emp_id1" id="emp_id1" class="form-control" value="" required> 
												<span class="help-block"> </span>
											</div> 
									</div> 
									<?php if((!empty($emp_name)) && ($emp_name != 1)){?>
									<div class="form-group" style="margin-top:-35px;padding-left:20%;"> 
										 <div class="col-md-12" style="text-align:left;">
											 	{{$emp_name}} 
												<br>
												 {{$designation_code}}, {{$branch_code}} 
										</div>  		
									</div>
									<?php } ?> 
									<div class="form-group"> 
										<label class="control-label col-md-4">Group</label>
											<div class="col-md-5">
												<select  name="category_id" id="category_id" class="form-control" > 
													<option value="">--Select--</option>
													@foreach($category_list as $category)
														<option value="{{$category->category_id}}">{{$category->category_name}}</option> 
													@endforeach	
													</select>
												<span class="help-block"></span>
											</div>  
									</div> 
									
									<div class="form-group"> 
										<label class="control-label col-md-4">Category</label>
											<div class="col-md-5">
												<select  name="subcat_id" id="subcat_id" <?php if($u_user_type != 7){ ?> style="pointer-events: none;" <?php } ?> class="form-control"> 
													<option value="">--Select--</option> 
													@if(!empty($category_id))
													@foreach($subcategory_list as $subcat)
														<option value="{{$subcat->subcat_id}}">{{$subcat->subcategory_name}}</option> 
													@endforeach	
													@endif
												</select> 
											</div>  
									</div>
									<div class="form-group"> 
										<label class="control-label col-md-4">Emp Status</label>
											<div class="col-md-5">
												  <?php 
												  if($c_effect_date != 1 ){
													  if($c_effect_date == 2){
														  echo '<span style="color:#F70408"><b>Is not Available</b></span>';
													  }else{
														 if(!empty($c_effect_date)) {
													
																	echo '<span style="color:#F70408"><b>Cancel</b></span>';
																
															} else {
																echo '<span style="color:#179708"><b>Running</b></span>';
															}   
													  }
													 
												  }
													
													?>
											</div>  
									</div> 
									<div class="form-group"> 
										<label class="control-label col-md-4"></label>
											<div class="col-md-5">
											 <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
											</div> 
									</div> 
									<?php if(!empty($emp_name)){?>
									<div class="box-body table-responsive no-padding">
										<table class="table table-hover table1">
											<thead>
												<tr>
												  <th>SL</th>
												  <th>Category</th>
												</tr>
											</thead>
											<tbody>	 
											<?php   
												if($is_access == 1){ ?> 
												  
												<?php $i = 1;?>
												@if(!empty($emp_document_list))
													@foreach($emp_document_list as $emp_document)
												<?php  
												$ddd = explode('.',$emp_document->document_name);
													if($ddd[1] == 'pdf' || $ddd[1] == 'PDF'){
														$ext = 1;
													}else if($ddd[1] == 'doc' || $ddd[1] == 'DOC' ){
														$ext = 2;
													}else{
														$ext = 3;
													}
													if($emp_document->category_id == 13){
														$folder_name = "c_v/";
													}else if($emp_document->category_id == 5){
														$folder_name = "edu_cation/";
													}else if($emp_document->category_id == 11){
														$folder_name = "miscell_aneous/";
													}else if($emp_document->category_id == 24){
														$folder_name = "train_ing_info/";
													}else if($emp_document->category_id == 2){
															$folder_name = "assessment/";
														}else {
														if(($emp_document->effect_date == '2019-07-01' || $emp_document->effect_date == '2021-07-01') && ($emp_document->category_id == 23) && ($emp_document->subcat_id == 24)){
															$folder_name = "attach_ment_tran/auto_increment/";
														}else{
															$folder_name = "attach_ment_tran/";
														}
														
													}
													$filename = "attachments/$folder_name/$emp_document->document_name";
													if (file_exists($filename)) {
												?> 
													<tr>
														<td>{{$i}}</td>
														<td style="cursor:pointer;" onclick="show_image({{$i}},{{$ext}},{{$emp_document->category_id}},{{$emp_document->subcat_id}},'{{$emp_document->effect_date}}')"><?php echo date('d-m-Y',strtotime($emp_document->effect_date));echo ' '.$emp_document->subcategory_name;?>
															<!-- <span><?php if($ext==1){ ?> <img  src="{{asset('storage/attachments/pdf.png')}}" width='40'><?php  } else if($ext==2){ ?> <img  src="{{asset('storage/attachments/doc.png')}}" width='40'> <?php }else{ ?> <img  src="{{asset('storage/attachments/image.png')}}" width='40'><?php } ?> </span>--><input type="hidden" id="file_name{{$i}}" value="{{$emp_document->document_name}}">
														</td>
													</tr>
													
													<?php $i++; } ?>
													@endforeach
												@endif 
											
											
										 
									<?php }else{ ?>
										<tr>
											<td colspan="3" style="text-align:center;color:red;"><?php echo "access is denied";?></td>
										</tr>
 
									<?php } ?> 
											</tbody>
										  </table> 
										</div>
									<?php } ?> 
						</div>
				</div>
			</div>
		</form>	
		<div class="col-md-8">
			<div class="box box-info"> 
					 <div class="box-body" id="html_remove"> 
					 <?php if($is_access == 1){ ?>
						<div class="row">
							<div class="col-md-12">
							<?php 
							
							$imagename = "public/employee/$emp_image";  
							if (file_exists($imagename)) { 
							 ?>
							<table class="table no-border" style="width:100%;">
								<tr>
									<th  rowspan="2">   <img class="img-thumbnail" src="{{asset('public/employee/'.$emp_image)}}" style="height: 125px; width: 120px;"></th>
									<th >   STAFF STATUS HISTORY DETAILS</th>
								</tr>
								<tr>
								  <th style="padding-left:10px;">Employee Details</th> 
								</tr>
							</table>
							<?php }else{ 
								?>
								<table class="table no-border" style="width:100%;">
								<tr>
									<th  colspan="8" style="text-align:center;">STAFF STATUS HISTORY DETAILS </th>
								</tr>
								<tr>
								  <th   colspan="8" style="text-align:center;">Employee Details</th> 
								</tr>
								</table>
								 
							</table>
							<?php } ?>
							<?php if($emp_name == 1){ ?> 
							
								 <p style='text-align:center;color:red;'>Please Insert Employee ID</p> 
								 
							<?php }else if(!empty($emp_name)){ ?>
							 <table class="table table-bordered" style="width:100%;">
									<thead> 
										<tr>
										<th style="width:35%;">Employee Name</th>
										  <th style="width:35%;">Designation</th>
										  <th style="width:30%;">Grade</th>
										</tr>
									</thead> 
									<tbody>	 
										<tr>
										  <td>{{$emp_name}}</td>
										  <td>{{$designation_code}}</td>
										 <td>{{$grade_name}}</td>
										</tr>
									</tbody> 
							</table>  
							<table class="table table-bordered" style="width:100%;">
									<thead> 
										<tr>
										  <th style="width:35%;">Last Degree</th>
										  <th style="width:35%;">Program/Department/Project/Unit</th>
										  <th style="width:30%;">Working Station</th>
										</tr>
									</thead> 
									<tbody>	 
										<tr> 
										 <td>{{$exam_name}}</td>
										 <td>{{$department_name}}</td> 
										 <td>{{$branch_code}}</td>
										</tr>
									</tbody> 
							</table> 
							<?php 
								if(!empty($emp_history_probition)){ ?>
								<table class="table table-bordered" style="width:100%;">
									<thead>
										<tr>
										  <th colspan="3" style="text-align:center;">JOB STATUS</th> 
										</tr>
										<tr>
										  <th style="width:35%;">Status Name</th>
										  <th style="width:35%;">Effective Date</th>
										  <th style="width:30%;">Issue Date</th>
										</tr>
									</thead>
									 
									<tbody>	  
										<?php 
											if(!empty($emp_history_permanent)){ ?>
										<tr>
										  <td>Permanent</td>
										  <td>{{date('d-m-Y',strtotime($emp_history_permanent->effect_date))}}</td>
										  <td>{{date('d-m-Y',strtotime($emp_history_permanent->letter_date))}}</td>
										</tr> 
									<?php 
											}
									if(!empty($emp_history_probition)){
									//foreach($emp_history_probition as $v_probition){
										?>
										<tr>
										  <td>Probation</td>
										  <td>{{date('d-m-Y',strtotime($emp_history_probition->br_joined_date))}}</td>
										  <td>{{date('d-m-Y',strtotime($emp_history_probition->letter_date))}}</td>
										</tr>
									<?php
										//}
									}
									?>
									
									</tbody> 
								</table> 
								<?php 
									}
								?>
							<?php 
								if(!empty($emp_history_designation)){ ?>
							<table class="table table-bordered" style="width:100%;"> 
									<thead>
										<tr>
										  <th colspan="3" style="text-align:center;">Designation</th> 
										</tr>
										<tr>
										  <th style="width:35%;">Designation</th>
										  <th style="width:35%;">Effective Date</th>
										  <th style="width:30%;">Issue Date</th>
										</tr>
									</thead>
									 
									<tbody>	 
									<?php 
									 
									foreach($emp_history_designation as $v_designation){
										?>
										<tr> 
										  <td><?php echo $v_designation['designation_name']; ?></td>
										  <td><?php echo date("d-m-Y",strtotime($v_designation['effect_date'])); ?></td>
										  <td><?php echo date("d-m-Y",strtotime($v_designation['letter_date'])); ?></td>
										</tr>
									<?php
										} 
									?> 
									</tbody> 
								</table>
								<?php 	 
									}
								?> 
								<?php   
									if($emp_id <= 200000){ 
									if(count($emp_history_promotion) > 0){
										?>	
									
							<table class="table table-bordered" style="width:100%;"> 
									<thead>
										<tr>
										  <th colspan="3" style="text-align:center;">Promotion</th> 
										</tr>
										<tr>
										  <th style="width:35%;">Grade</th>
										  <th style="width:35%;">Effective Date</th>
										  <th style="width:30%;">Issue Date</th>
										</tr>
									</thead>
									 
									<tbody>	 
									<?php  
									foreach($emp_history_promotion as $v_promotion){
										?>
										<tr>
										  <td>{{$v_promotion->grade_code}}</td>
										  <td>{{date('d-m-Y',strtotime($v_promotion->effect_date))}}</td>
										  <td>{{date('d-m-Y',strtotime($v_promotion->letter_date))}}</td>
										</tr>
									<?php
										} 
									?> 
									</tbody> 
							</table> 
								<?php 	 
							} }
								?> 
							<?php  if($emp_id <= 200000){  
									if(count($emp_history_transfer) > 0){ ?>
							<table class="table table-bordered" style="width:100%;"> 
									<thead>
										<tr>
										  <th colspan="3" style="text-align:center;">Transfer</th> 
										</tr>
										<tr>
										  <th style="width:35%;">Branch Name</th>
										  <th style="width:35%;">Effective Date</th>
										  <th style="width:30%;">Issue Date</th>
										</tr>
									</thead>
									 
									<tbody>	 
									<?php 
									
									foreach($emp_history_transfer as $v_transfer){
										?>
										<tr>
										  <td>{{$v_transfer->branch_name}}</td>
										  <td>{{date('d-m-Y',strtotime($v_transfer->br_joined_date))}}</td>
										  <td>{{date('d-m-Y',strtotime($v_transfer->letter_date))}}</td>
										</tr>
									<?php
										} 
									?> 
									</tbody> 
							</table> 
							<?php 	 
							}}
							?> 
							<?php }else{
								 
								 echo "<p style='text-align:center;color:red;'>Employee is not available</p>";
								
							} ?>
						</div> 					
						</div> 
					 <?php } ?>
				</div>
		</form>
		</div>
		</div>
</div>
</section> 
	<script type="text/javascript">
		 
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	</script>
<script>
/* 	$("#search_attachment").on('submit',function(e){
		e.preventDefault();
	 
		//alert(dd);
		$.ajax({
			type: "POST",
			url : "{{URL::to('emp-attachment')}}", 
			data: $('#search_attachment').serialize(),
			success: function(data)
			{
				alert(data); 
				 $("#add_row").html(data); 
				  /* $('#example2').DataTable({
						"paging": true,
						"lengthChange": false,
						"searching": false,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"sDom": 'lfrtip'
					}); 
			}
		});
	});*/  
	function show_image(val,ext,category_id,subcat_id,effect_date){
		//alert(effect_date);
		var u_user_type = $("#u_user_type").val(); 
		var file_name = $("#file_name"+val).val(); 
		$("#html_remove").html(''); 
		var view_image = "<a  id='htm_image_show'></a>";
		$("#html_remove").html(view_image); 
		//alert(file_name);
		if(category_id == 13){
			var folder_name = "c_v/";
		}else if(category_id == 5){
			var folder_name = "edu_cation/";
		}else if(category_id == 11){
			var folder_name = "miscell_aneous/";
		}else if(category_id == 24){
			var folder_name = "train_ing_info/";
		}else if(category_id == 2){
			var folder_name = "assessment/";
		}else {
			if((effect_date == '2019-07-01' || effect_date == '2021-07-01') && (category_id == 23) && (subcat_id == 24))
			{
				var folder_name = "attach_ment_tran/auto_increment/";
			}else{
				var folder_name = "attach_ment_tran/";
			}
			
		} 
	  if(ext == 1){ ///for pdf
			//var dd="<embed src='{!!asset('storage/attachments/"+folder_name+file_name+"')!!}' type='application/pdf'  width='100%'  height='700'>";
			if(u_user_type == 7){
				var dd="<embed src='{!!asset('attachments/"+folder_name+file_name+"#toolbar=1')!!}' type='application/pdf'  width='100%'  height='700'>";
			}else{
				var dd="<embed src='{!!asset('attachments/"+folder_name+file_name+"#toolbar=0&navpanes=0&scrollbar=0')!!}' type='application/pdf'  width='100%'  height='700'>";
			}
			
			//$("#htm_image_show").attr('href',"{!!asset('storage/attachments/"+folder_name+file_name+"')!!}"); 
			$("#htm_image_show").attr('href',"{!!asset('attachments/"+folder_name+file_name+"')!!}"); 
			$("#htm_image_show").html(dd); 
			document.getElementById("htm_image_show").focus();
		}else if(ext == 3){ /// for image
		 ///alert('not ok');
	
			var dd="<img src='{!!asset('attachments/"+folder_name+file_name+"')!!}'  width='100%'  height='100%'>";
			$("#htm_image_show").attr('href',"{!!asset('attachments/"+folder_name+file_name+"')!!}"); 
			$("#htm_image_show").html(dd); 
		}else if(ext == 2){ // for doc 
		 var dd="<iframe  src='{!!asset('attachments/"+folder_name+file_name+"')!!}'  width='100%'  height='100%'></iframe>";
			$("#htm_image_show").attr('href',"{!!asset('attachments/"+folder_name+file_name+"')!!}");  
			$("#htm_image_show").html(dd);  
			/* var dd="<iframe src='storage/attachments/"+file_name+"'  width='100%'  height='400'></iframe>";
			$("#htm_image_show").attr('href',"storage/attachments/"+file_name);  
			$("#htm_image_show").html(dd);   */
			 
		}  
		//alert(ext);
		
		// alert("ok"); 
	} 
</script>  
<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	
	
	
	
	});
	
	$("#emp_id1").val({{$emp_id}}); 
</script> 
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupDocument").addClass('active');
		$("#View_Document").addClass('active');
	});
	
	
$('#category_id').on('change',function(e){
		e.preventDefault(); 
		var category_id = $(this).val(); 
		if(category_id != ''){
			$.ajax({
					type: "GET",
					url : "{{URL::to('select_subcategory_per')}}"+"/"+category_id, 
					success: function(data)
					{ 
						 $("#subcat_id").html(data); 
					}
			}); 
		}else{
			$("#subcat_id").html("<option value=''>--Select--</option> "); 
		}
		   
	});	
	$("#category_id").val({{$category_id}});
	 var gg = '<?php echo $subcat_id;?>';
	//alert(gg); 
	if(gg != 0){
		//alert(gg);
		$("#subcat_id").val({{$subcat_id}}); 
	} 
</script>

@endsection