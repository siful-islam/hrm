@extends('admin.admin_master')
@section('main_content')

<link rel="stylesheet" href="{{asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')}}">
<style>
		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			background-color: #3c8dbc;
			border-color: #367fa9;
			padding: 1px 10px;
			color: #fff;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Self<small>Care</small></h1>
	</section> 
	<section class="content-header">
      <a href="{{URL::to('/profile')}}"><h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5></a>
		<ol class="breadcrumb">
			<li><a href="{{URL::to('/profile')}}">Self Care -></a> ***</li>
		</ol>
	</section>
	
	<style>
		#list_approval {
		font-family: Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
		}

		#list_approval td, #list_approval th {
		border: 1px solid #ddd;
		padding: 3px;
		}

		#list_approval tr:nth-child(even){background-color: #f2f2f2;}

		#list_approval tr:hover {background-color: rgb(255, 254, 254);}

		#list_approval th {
		padding-top: 6px;
		padding-bottom: 6px;
		text-align: center;
		background-color: #3c8dbc;
		color: white;
		} 
	</style>
	
	<!-- Main content -->
	<section class="content">
			<div class="box box-info">
				<div class="box-header">
				  <h3 class="box-title">Visit Approval Panel</h3>
				</div>
				<div class="box-body no-padding">
					<div class="table-responsive">
						<table class="table" id="list_approval" style="border">
							<tr>
								<th align="center" colspan="3"><b>Employee Information</b></th>
								<th align="center" colspan="4"><b>Visit Information</b></th>
								<th align="center" rowspan="2"><b>Detail Action</b></th>
								<th align="center" rowspan="2"><b>Quick Action</b></th>
							</tr>
							<tr>
								<th><b>Employee Name<b></td>
								<th align="center"><b>Photo<b></td>
								<th><b>Employee ID<b></td>
								<th><b>Departure Date<b></td>
								<th><b>Return Date<b></td>
								<th><b>Return Date (Actual)<b></td>
								<th><b>Duration<b></td>
							</tr>
							<?php $duration = 0; if(count($my_stafs) >0) { foreach($my_stafs as $staf) { ?>
							
							<?php if($staf->first_super_action !=2) { ?>
								<input type="hidden" id="move_id" name="move_id[]" value="<?php echo $staf->move_id; ?>">
								<input type="hidden" id="supervisor_type" name="supervisor_type[]" value="<?php echo $staf->supervisor_type; ?>">
								<input type="hidden" id="supervisor_id" name="supervisor_id[]" value="<?php echo $staf->supervisor_id; ?>">
								<?php 
								if($staf->first_super_action ==1)
								{
									$title = 'Proceed by Sub-Supervisor';
								}
								elseif($staf->first_super_action ==2)
								{
									$title = 'Rejected by Sub-Supervisor';
								}else
								{
									$title = 'No Sub-Supervisor Activity';
								}
								?>
								<tr>
									<td title="<?php echo $title; ?>"><b><?php echo $staf->emp_name; ?></b></td>
									<?php if($staf->emp_photo) { ?>
									<td align="center"><img src="{{asset('public/employee/'.$staf->emp_photo)}}" height="40" width="40" alt="User profile picture"></td>
									<?php } else { ?>
									<td align="center"><img src="{{asset('public/avatars/no_image.jpg')}}" height="40" width="40" alt="User profile picture"></td>
									<?php } ?>										
									<td align="center"><?php echo $staf->emp_id; ?></td>
									<td align="center"><?php echo date("d-m-Y",strtotime($staf->from_date)); ?></td>
									<td align="center"><?php echo date("d-m-Y",strtotime($staf->to_date)); ?></td>
									<td align="center"><?php echo date("d-m-Y",strtotime($staf->arrival_date)); ?></td>
									<td align="center"><?php echo $staf->tot_day;?><?php echo $staf->tot_day == 1 ? ' day' : ' days';  ?></td> 
									<td align="center"><button type="button" class="btn btn-warning btn-xs" onclick="view(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_type; ?>,<?php echo $staf->supervisor_id; ?>)"> View <i class="fa fa-comment" aria-hidden="true"></i></button></td>
									<?php if($staf->supervisor_type == 2 && $staf->stage == 0) { //SUB Supervisor ?>
									<td align="center">
										<button type="button" class="btn btn-primary btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,1);"><i class="fa fa-check" aria-hidden="true"></i> Proceed</button>
										<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,2);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
									</td>
									<?php } elseif ($staf->supervisor_type == 1 && $staf->stage < 2) { ?>
									<td align="center">
										<button type="button" class="btn btn-success btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,3);"><i class="fa fa-check" aria-hidden="true"></i> Approve</button>
										<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,4);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
									</td>

									<?php } ?>
								</tr>
							<?php }  ?>
							<?php }  ?>

							<?php } else { ?>
								<tr>
									<td colspan="9" align="center" style="color:blue;">No Recoreds Found </td>
								</tr>
							<?php } ?>
						</table>			
					</div> 
				</div>
			</div> 
			
	
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
				
					<form class="form-inline report" id="visit_approval_report" action="{{URL::to('/approval_report_visit')}}" method="post">
						{{ csrf_field() }}
						
						<div class="form-group">
						  <label for="form_date"></label>
						  <input type="date" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
						</div>
						<div class="form-group">
						  <label for="to_date">To:</label>
						  <input type="date" id="to_date" class="form-control" name="to_date" size="10" value="{{$to_date}}" required>
						</div>
						<div class="form-group">
						  <label for="emp_id"></label>
						  <input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="" placeholder="Emp ID:All" >
						</div>
						<div class="form-group">
							<label for="pwd"></label>
							<select id="activities" class="form-control" name="activities" required>
								<option value="0">All</option>
								<option value="1">Approved</option>
								<option value="2">Rejected</option>
								<option value="3">Proceed</option>
								<option value="4">Reject(As Sub)</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Show</button>
					</form>
				</div>
				<hr>
				<div  class="box-body" id="visit_epproval_reprt" style="display:none;" > 
					<div style="overflow-y: auto;" class="col-md-12">
						<table border="1" cellspacing="5">
							<thead>
								<tr> 
									<td rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:50px">Emp Id</div></b></td>
									<td align='center' rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:170px">Employee Name</div></b></td>
									<td align='center' rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:105px">Application Date</div></b></td>
									<td align='center' rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:105px">Departure Date</div></b></td>
									<td align='center' rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:105px">Arrival Date</div></b></td>
									<td align='center' rowspan="2" style="background-color:#FAE8B8;"><b>Day</b></td>
									<td align='center' rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:250px">Destination</div></b></td>
									<td rowspan="2" style="background-color:#FAE8B8;"><b><div style="width:250px">Purpouse</div></b></td>
									<td align='center' colspan="4" align="center" style="background-color:#C0FAB8;"><b>Sub-Supervisor</b></td>
									<td align='center' colspan="4" align="center" style="background-color:#C6F9F8;"><b>Supervisor</b></td>
								</tr>
								<tr>
									<td align='center' style="background-color:#C0FAB8;"><b><div style="width:175px">Sub Supervisor</div></b></td>
									<td align='center' style="background-color:#C0FAB8;"><b><div style="width:115px">Action Date</div></b></td>
									<td align='center' style="background-color:#C0FAB8;"><b>Action</b></td>
									<td align='center' style="background-color:#C0FAB8;"><b>Remarks</b></td>
									<td align='center' style="background-color:#C6F9F8;"><b><div style="width:175px">Supervisor</div></b></td>
									<td align='center' style="background-color:#C6F9F8;"><b><div style="width:115px">Action Date</div></b></td>
									<td align='center' style="background-color:#C6F9F8;"><b>Actions</b></td>
									<td align='center' style="background-color:#C6F9F8;"><b>Remarks</b></td>
								</tr>
							</thead>
							<tbody  id="add_table">
								 
							</tbody>
						</table>
					</div>
				</div>

				<hr>
								
			</div>
        </div>
	</div>
	
	

    </section>
	
	
	
	
	<!-- Start Bootstrap modal -->
	<div class="modal fade" method="post" id="v_modal_form"  role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>				
				<form class="form-horizontal" role="form" id="v_visit_form"> 
					{{ csrf_field() }}
					<span id="post_method"></span>
					
					<input class="form-control" type="hidden" name="move_id" id="v_move_id" readonly>
					<input class="form-control" type="hidden" name="supervisor_type" id="v_supervisor_type" readonly>
					<input class="form-control" type="hidden" name="supervisor_id" id="v_supervisor_id" readonly>
					
					<div class="form-group">
							<label for="v_visit_type" class="col-sm-3 control-label">Visit Type</label>
							<div class="col-sm-8">
								
								<select   id="v_visit_type" class="form-control" required style="pointer-events:none;">  
										<option value="1">Branch</option>  
										<option value="2">Local</option>  
								</select> 
							</div>
						</div>
						<div class="form-group">
							<label for="visit_type" class="col-sm-3 control-label">Destination</label>
							<div class="col-sm-8">
								 <span id="branch_destination" style="display:block;">
									<select    multiple="multiple" style="width: 100%;" id="destination_code" disabled class="form-control select2"> 
										@foreach($branch_list as $branch)
											<option value="{{$branch->br_code}}">{{$branch->branch_name}}</option> 
										@endforeach 
									</select>
								</span>
								<span id="local_destination" style="display:none;">
									<input list="local_list" class="form-control"   id="loc_destination" style="pointer-events:none;"  placeholder="Write destination" >
									<datalist id="local_list">
										<option value="MRA">
										<option value="PKSF"> 
									</datalist> 
								</span>
							</div>
						</div> 
						<div class="form-group">
							<label for="purpose" class="col-sm-3 control-label">Purpose</label>
							<div class="col-sm-8"> 
									 <textarea id="v_purpose" readonly  class="form-control" rows="4" cols="50"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="from_date" class="col-sm-3 control-label">Departure Date</label>
							<div class="col-sm-4">
								 <input type="date" readonly  id="v_from_date" autocomplete="off" class="form-control"  value="" required> 
							</div> 
							<div class="col-sm-4">
								<input  type="text" readonly id="v_leave_time"  value="" class="form-control" required>
							 
							</div>
						</div>  
						<div class="form-group">
							<label for="v_to_date" class="col-sm-3 control-label">Return Date</label>
							<div class="col-sm-4">
								<input type="date" readonly  id="v_to_date" autocomplete="off"   class="form-control" value="" required >
								
							</div> 
							<div class="col-sm-4">
								<input  type="text" readonly id="v_arrival_time"  value="" class="form-control" >
							</div>
						</div>
						<div class="form-group">
                        <label for="return_date" class="col-sm-3 control-label">Return Date (Actual)</label>
                        <div class="col-sm-4">
                          <input type="date" readonly id="return_date" name="return_date" autocomplete="off" class="form-control" value="">

                        </div>
                        <div class="col-sm-4">
                            <input  type="text" readonly id="return_time"  value="" class="form-control" >
                        </div>
                    </div>	
						<div class="form-group">
							<label for="v_is_need_vehicle_sup" class="col-sm-3 control-label">Need vehicle Support ?</label>
							<div class="col-sm-8">
								<input type="text" id="need_car" class="form-control" value="" readonly>
							</div>
						</div>						
						<div class="form-group">
							<label for="remarksss" class="col-sm-3 control-label">Action</label>
							<div class="col-sm-8">
								<select class="form-control" name="action" id="action">
									<option value="1" id="action_name">Approve</option>
									<option value="2">Reject</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="remarkssss" class="col-sm-3 control-label">Remarks</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="remarks" id="remarks"></textarea>
							</div>
						</div> 
						<div class="table-responsive" id="sub_panel">
							<table class="table table-bordered table-striped">
								<tr>
									<td width="25%">Sub Supervisor</td>
									<td width="15%">Action Date</td>
									<td width="15%">Action</td>
									<td width="40%">Remarks</td>
								</tr>
								<tr>
									<td id="first_super_emp_id"></td>
									<td id="first_super_action_date"></td>
									<td id="first_super_action"></td>
									<td id="first_super_remarks"></td>
								</tr>
							</table>
						</div>
						
					<div class="modal-footer">
						<button type="button" id="btnsave"  onclick="save_approval()"  class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	 
	
	
	<!-- End Bootstrap modal -->
	<script src="{{asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
	<script>
	
	$("#visit_approval_report").submit(function(e) {

				e.preventDefault(); // avoid to execute the actual submit of the form.

				var form = $(this);
				var url = form.attr('action');
				 
				 $.ajax({
					   type: "POST",
					   url: url,
					   dataType: 'json',
					   data: form.serialize(), // serializes the form's elements.
					   success: function(data)
					   {
						    // show response from the php script.
						  // $("#reload_tbl").load(location.href + " #reload_tbl");
						  var x = document.getElementById("visit_epproval_reprt");
							 
						   x.style.display = "block";
							 
						   $('#add_table').empty();
						  var t_row = '';
						  var sub_supervisor_name = '';
						  var first_super_action_date = '';
						  var first_super_remarks = '';
						  var sub_action = ''; 
						  var supervisor_name = '';
						  var super_action_date = '';
						  var super_remarks = '';
						  var sup_action = '';
						  var destination_code = '';
						  //var branchList='<?php echo $branch_list; ?>';
						  //var branchList_length='<?php echo count($branch_list); ?>';
						  //console.log(branchList);
						  //console.log(branchList_length);
						  for(var x in data.all_result) {
						  //console.log(data.all_result[0]['application_date']); 
							 
							if(data.all_result[x]['visit_sub_supervisors_emp_id'] == null || data.all_result[x]['visit_sub_supervisors_emp_id'] == '') 
							   { 
									sub_supervisor_name = 'N/A'; 
							   } else{
									sub_supervisor_name = data.all_result[x]['sub_emp_name']; 
								}  
							if(data.all_result[x]['visit_sub_supervisors_emp_id'] == null || data.all_result[x]['visit_sub_supervisors_emp_id'] == '') 
							   { 
									first_super_action_date = ''; 
							   } else{
									first_super_action_date = data.all_result[x]['first_super_action_date']; 
								} 
							if(data.all_result[x]['first_super_remarks'] != null) 
							   { 
									first_super_remarks = data.all_result[x]['first_super_remarks']; 
									
							   } else{
									first_super_remarks = ''; 
								} 
							if(data.all_result[x]['visit_sub_supervisors_emp_id'] == null || data.all_result[x]['visit_sub_supervisors_emp_id'] == '') 
							   { 
									sub_action = ''; 
							   } else{
								   if(data.all_result[x]['first_super_action'] == 1){
									   sub_action = 'Recomended';
								   }else{
									  sub_action = 'Rejected';
								   }  
								} 
						   if(data.all_result[x]['super_action'] != 0) 
							   { 
									
									supervisor_name = data.all_result[x]['sup_emp_name'];
							   } else{
									 supervisor_name = ''; 
								}   
							 if(data.all_result[x]['super_action'] != 0) 
							   { 
									 
									super_action_date = data.all_result[x]['super_action_date']; 
							   } else{
									super_action_date = '';
								} 
						   if(data.all_result[x]['super_remarks'] != null) 
							   { 
									super_remarks = data.all_result[x]['super_remarks'];
									
							   } else{
									 super_remarks = ''; 
								} 
							if(data.all_result[x]['super_action'] != 0) 
							   { 
									 if(data.all_result[x]['super_action'] == 1){
									   sup_action = 'Approved';
								   }else{
									  sup_action = 'Rejected';
								   } 
									 
							   } else{
								  sup_action = '';
								} 
								
							if(data.all_result[x]['visit_type']==1){
											 
								destination_code1  = data.all_result[x]['destination_code'].split(","); 
								//console.log(branchList.br_code);
								var i =0 ;
								var des_variable ='' ;
								for(var y in data.branch_list) {
									//alert(data.branch_list[y]['br_code']);
									//console.log(data.branch_list[y]['br_code']);
									 if($.inArray(data.branch_list[y]['br_code'],destination_code1)!= -1){
										if(i == 0){
											des_variable  = data.branch_list[y]['branch_name'];
										}else{
											des_variable  += ', '+data.branch_list[y]['branch_name'];
										}
										i++;
									} 
								}
								destination_code  = des_variable;
								
								 
							}else{
								destination_code = data.all_result[x]['destination_code'];
							}	
							 t_row += 	"<tr><td>"+data.all_result[x]['emp_id']+"</td><td>"+data.all_result[x]['emp_name_eng']+"</td><td align='center'>"+data.all_result[x]['application_date']+"</td><td align='center'>"+data.all_result[x]['from_date']+"</td><td align='center'>"+data.all_result[x]['to_date']+"</td><td align='center'>"+data.all_result[x]['tot_day']+"</td><td align='center'>"+destination_code+"</td><td align='center'>"+data.all_result[x]['purpose']+"</td><td align='center'>"+sub_supervisor_name+"</td><td align='center'>"+first_super_action_date+"</td><td align='center'>"+sub_action+"</td><td align='center'>"+first_super_remarks+"</td><td align='center'>"+supervisor_name+"</td><td align='center'>"+super_action_date+"</td><td align='center'>"+sup_action+"</td><td align='center'>"+super_remarks+"</td></tr>";
						  
						  
						  
					   } 
						 $('#add_table').append(t_row); 
						  
					   }
					 });
				
	});
	
	 $('.select2').select2();
	function view(move_id,supervisor_type,supervisor_id)
	{
		
		if(supervisor_type == 1)
			{
				document.getElementById("action_name").innerHTML = 'Approve';
			}
			else{
				document.getElementById("action_name").innerHTML = 'Proceed'; 
			}
		document.getElementById("v_visit_form").reset();	
		var url = "{{ URL::to('/get_move_info') }}";
			$.ajax({
				type: "GET",
				url: url + "/" + move_id,
				success: function (res) {
					document.getElementById("v_move_id").value = res.move_id;
					document.getElementById("v_supervisor_type").value = supervisor_type;
					document.getElementById("v_supervisor_id").value = supervisor_id; 
					document.getElementById("v_from_date").value = res.from_date;
					document.getElementById("v_to_date").value = res.to_date; 
					document.getElementById("v_leave_time").value = res.leave_time; 
					document.getElementById("v_arrival_time").value = res.arrival_time;
					if(res.is_reopen == 1){
						document.getElementById("return_date").value = res.arrival_date; 
						document.getElementById("return_time").value = res.return_time;
					}else{
						document.getElementById("return_date").value = res.to_date; 
						document.getElementById("return_time").value = res.arrival_time;
					}				
					 
					document.getElementById("v_visit_type").value = res.visit_type;
					document.getElementById("v_purpose").value = res.purpose;	
					 
					if(res.visit_type == 1 ){
						$("#branch_destination").attr("style", "display:block");
						$("#local_destination").attr("style", "display:none");
						$('#destination_code').val(res.destination_code);
						$('#destination_code').trigger('change');
					}else{
						$("#branch_destination").attr("style", "display:none");
						$("#local_destination").attr("style", "display:block");
						 document.getElementById("loc_destination").value = res.destination_code;
					} 
					 console.log(res);
					  
					var x = document.getElementById("sub_panel");
						if (res.first_super_action >0) {
							x.style.display = "block";
						} else {
							x.style.display = "none";
						}
						document.getElementById("first_super_emp_id").innerHTML = res.sub_supervisor_name +
                            ' ( ' +
                            res.visit_sub_supervisors_emp_id + ' )';;		
						document.getElementById("first_super_action_date").innerHTML = res.first_super_action_date;		
						document.getElementById("first_super_remarks").innerHTML = res.first_super_remarks;
						if (res.is_need_vehicle_sup == 1) {
                        var need_car = 'Yes';
						} else { 
							var need_car = 'No';                    
						}
						document.getElementById("need_car").value = need_car;
						if(res.first_super_action ==1)
						{
							var action = 'Proceed'; 
						}
						else if(res.first_super_action ==2){
							var action = 'Rejected';
						}else{
							var action = '';
						}
						document.getElementById("first_super_action").innerHTML = action;
					$('#v_modal_form').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-title').text('View: Visit Application'); // Set title to Bootstrap modal title
				}
			})
	}	
	
	function save_approval()
	{
		var visit_approve_pending = parseInt(document.getElementById("visit_approve_pending").innerHTML);
		var new_visit_approve_pending = (visit_approve_pending - 1);
			
		$('#btnSave').text('saving...'); //change button text
		$('#btnSave').attr('disabled',true); //set button disable 
		url = "{{URL::to('/move_appliacation_approve')}}";
		message='Data Saved Successfully';
		$.ajax({
			url : url,
			type: "POST",
			data: $('#v_visit_form').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				if(data)
				{
					$.gritter.add({
						title: 'Success!',
						text: message,
						sticky: false,
						class_name: 'gritter-light'
					}); 
				}
				$('#v_modal_form').modal('hide'); // Modal form hide	
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
				$("#list_approval").load(location.href + " #list_approval");	
				document.getElementById("visit_approve_pending").innerHTML = new_visit_approve_pending;			
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				$.gritter.add({
					title: 'Error!',
					text: 'Error to Save Data'
				});
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
			}
		});
	}
	
	
	
	function save_action(move_id,supervisor_id,action_id)
	{
		if (confirm('Confirm to execute !!')) {
			var visit_approve_pending = parseInt(document.getElementById("visit_approve_pending").innerHTML);
			var new_visit_approve_pending = (visit_approve_pending - 1);
			var url = "{{ URL::to('/movement_approval') }}";
				$.ajax({
					type: "GET",
					url: url + "/" + move_id+ "/" + supervisor_id+ "/" + action_id,
					success: function (data) {
						$("#list_approval").load(location.href + " #list_approval");
						document.getElementById("visit_approve_pending").innerHTML = new_visit_approve_pending;	
					}
				})
		  }
	}
	
	$(document).ready(function() {
	  $('#select-all').click(function() {
		$('input[type="checkbox"]').prop('checked', this.checked);
	  })
	});
		
	</script>
	
	
	<script>
		//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSelf_Care").addClass('active');
			$("#Visit_Approval").addClass('active');
		});
	</script>
@endsection