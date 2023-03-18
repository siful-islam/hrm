
<?php $__env->startSection('title', 'Report'); ?>
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Self<small>Care</small></h1>
	</section>
	<section class="content-header">
      <a href="<?php echo e(URL::to('/profile')); ?>"><h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5></a>
		<ol class="breadcrumb">
			<li><a href="<?php echo e(URL::to('/profile')); ?>">Self Care -></a></li>
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
	
		<style>
		.overlay {
		  height: 100%;
		  width: 0;
		  position: fixed;
		  z-index: 1;
		  top: 0;
		  left: 0;
		  background-color: rgb(0,0,0);
		  background-color: rgba(0,0,0, 0.9);
		  overflow-x: hidden;
		  transition: 0.5s;
		}

		.overlay-content {
		  position: relative;
		  top: 25%;
		  width: 100%;
		  text-align: center;
		  margin-top: 30px;
		}

		.overlay a {
		  padding: 8px;
		  text-decoration: none;
		  font-size: 36px;
		  color: #818181;
		  display: block;
		  transition: 0.3s;
		}

		.overlay a:hover, .overlay a:focus {
		  color: #f1f1f1;
		}

		.overlay .closebtn {
		  position: absolute;
		  top: 20px;
		  right: 45px;
		  font-size: 60px;
		}

		@media  screen and (max-height: 450px) {
		  .overlay a {font-size: 20px}
		  .overlay .closebtn {
		  font-size: 40px;
		  top: 15px;
		  right: 35px;
		  }
		}
	</style>
	
	<!-- Main content -->
	<section class="content">
		<div id="myNav" class="overlay">
		  <div class="overlay-content">
			<img src="<?php echo e(asset('public/processing.gif')); ?>" width="100">
			<a href="#">Processing Your Approval ........</a>
		  </div>
		</div>
		
		<div class="box box-info">
			<div class="box-header">
				<h3 class="box-title">Leave Approval Panel</h3>
			</div>
			<div class="box-body no-padding"> 
					<div class="table-responsive">
						<table border="1" id="list_approval" style="border">
							<tr>
								<th align="center" colspan="3"><b>Employee Information</b></th>
								<th align="center" colspan="4"><b>Leave Information</b></th>
								<th align="center" rowspan="2"><b>Types</b></th>
								<th align="center" rowspan="2"><b>Detail Action</b></th>
								<th align="center" rowspan="2"><b>Quick Action</b></th>
							</tr>
							<tr>
								<th align="center"><b>Employee Name<b></th>
								<th align="center"><b>Emp ID<b></th>
								<th align="center"><b>Photo<b></th>
								<th align="center"><b>Date From<b></th>
								<th align="center"><b>Date To<b></th>
								<th align="center"><b>Duration<b></th>
								<th align="center"><b>Purpose<b></th>
							</tr>
							<?php $duration = 0; if(count($my_stafs) >0) { foreach($my_stafs as $staf) { ?>
							
							
								<?php if($staf->first_super_action !=2) { ?>
							
								<input type="hidden" id="application_id" name="application_id[]" value="<?php echo $staf->application_id; ?>">
								<input type="hidden" id="supervisor_type" name="supervisor_type[]" value="<?php echo $staf->supervisor_type; ?>">
								<input type="hidden" id="supervisor_id" name="supervisor_id[]" value="<?php echo $staf->supervisor_id; ?>">
								<tr>
									<td align="left"><b><?php echo $staf->emp_name; ?></b></td>								
									<td align="center"><?php echo $staf->emp_id; ?></td>
									<?php if($staf->emp_photo) { ?>
									<td align="center"><img src="<?php echo e(asset('public/employee/'.$staf->emp_photo)); ?>" height="40" width="40" alt="User profile picture"></td>
									<?php } else { ?>
									<td align="center"><img src="<?php echo e(asset('public/avatars/no_image.jpg')); ?>" height="40" width="40" alt="User profile picture"></td>
									<?php } ?>
									<td align="center"><?php echo date("d-m-Y", strtotime($staf->leave_from)); ?></td>
									<td align="center"><?php echo date("d-m-Y", strtotime($staf->leave_to)); ?></td>
									<td align="center">
										<?php 
											if($staf->no_of_days >1)
											{
												echo $staf->no_of_days.' Days';
											}
											elseif ($staf->no_of_days == '0.5') {
												if($staf->apply_for == 2)
												{
													echo '0.5 Days [ Half day Leave (Morning) ]';
												}
												else if($staf->apply_for == 3) {
													echo '0.5 Days [ Half day Leave (Evening) ]';
												}
											}
											else
											{
												echo $staf->no_of_days.' Day';
											}
										?> 
									</td>
									<td align="center"><div style="width:150px"><?php echo $staf->remarks; ?></div></td>
									<td align="center"><?php if($staf->modify_cancel == 0) { echo 'Regular'; } elseif($staf->modify_cancel == 1) { echo 'Modifyed'; } else{ echo 'Cancelation'; } ?></td>
									<td align="center"><button type="button" class="btn btn-warning btn-xs" onclick="view(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_type; ?>,<?php echo $staf->supervisor_id; ?>)"> View <i class="fa fa-comment" aria-hidden="true"></i></button></td>
									<?php if($staf->supervisor_type == 2 && $staf->stage == 0) { //SUB Supervisor ?>
									<td align="center">
										<button type="button" class="btn btn-primary btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,1);"><i class="fa fa-check" aria-hidden="true"></i> Proceed</button>
										<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,2);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
									</td>
									<?php } elseif ($staf->supervisor_type == 1 && $staf->stage < 2) { ?>
									<td align="center">
										<button type="button" class="btn btn-success btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,3);"><i class="fa fa-check" aria-hidden="true"></i> Approve</button>
										<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,4);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
								
							<?php } ?>
							<?php } else { ?>
								<tr>   
									<td colspan="9" align="center" style="color:blue;">No Records Found</td>
								</tr>
							<?php } ?>
						</table>
					</div> 
			</div>
		</div>
		
	<br><br>	
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<div class="table-responsive">
						<form class="form-inline report" id="leave_approval_report"  action="<?php echo e(URL::to('/approval_report')); ?>" method="post">
							<?php echo e(csrf_field()); ?>

							
							<div class="form-group">
							  <label for="form_date"></label>
							  <input type="date" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo  date("Y-m-d") ?>" required>
							</div>
							<div class="form-group">
							  <label for="to_date">To:</label>
							  <input type="date" id="to_date" class="form-control" name="to_date" size="10" value="<?php echo  date("Y-m-d") ?>" required>
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
									<option value="3">Recomendation</option>
									<option value="4">Reject(As Sub)</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Show</button>
						</form>
					</div>
				</div>
				<hr>
				<div class="box-body" id="leave_epproval_reprt" style="display:none;">
					<div style="overflow-y: auto;" class="col-md-12">
						<table id="reload_tbl" border="1" cellspacing="5">
							<thead>
								<tr>
									<td align="center" rowspan="2" style="background-color:#FAE8B8;"><b>
									<div style="width:50px">Emp Id</div></b></td>
									<td align="center" rowspan="2" style="background-color:#FAE8B8;"><b>
									<div style="width:170px">Employee Name</div></b></td>
									<td align="center" rowspan="2" style="background-color:#FAE8B8;" width="10%"><b>
									<div style="width:115px">Application Date</div></b></td>
									<td align="center" rowspan="2" style="background-color:#FAE8B8;">
									<b>
									<div style="width:105px">
									Leave From
									</div>
									</b>
									</td>
									<td align="center" rowspan="2" style="background-color:#FAE8B8;"><b>
									<div style="width:105px">
									Leave To
									</div></b></td>
									<td align="center" rowspan="2" style="background-color:#FAE8B8;"><b>
										<div style="width:100px">Leave Type</div></b>
									</td>
									<td align="center" rowspan="2" style="background-color:#FAE8B8; word-wrap: break-word">
										<b><div style="width:250px">Purpose</div></b>
									</td>
									<td colspan="4" align="center" style="background-color:#C0FAB8;"><b>Sub-Supervisor</b></td>
									<td colspan="4" align="center" style="background-color:#C6F9F8;"><b>Supervisor</b></td>
								</tr>
								<tr>
									<td align="center" style="background-color:#C0FAB8;"><div style="width:175px"><b>Sub Supervisor</b></div></td>
									<td align="center" style="background-color:#C0FAB8;"><b><div style="width:115px">Action Date</div></b></td>
									<td align="center" style="background-color:#C0FAB8;"><b>Action</b></td>
									<td align="center" style="background-color:#C0FAB8;"><b>Remarks</b></td>
									<td align="center" style="background-color:#C6F9F8;"><b><div style="width:150px">Supervisor</div></b></td>
									<td align="center" style="background-color:#C6F9F8;"><b><div style="width:115px">Action Date</div></b></td>
									<td align="center" style="background-color:#C6F9F8;"><b>Actions</b></td>
									<td align="center" style="background-color:#C6F9F8;"><b>Remarks</b></td>
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
	
	<script>
	$("#leave_approval_report").submit(function(e) {
				e.preventDefault(); 
				var form = $(this);
				var url = form.attr('action');
				 $.ajax({
					   type: "POST",
					   url: url,
					   dataType: 'json',
					   data: form.serialize(), 
					   success: function(data)
					   {
						  var x = document.getElementById("leave_epproval_reprt");
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
						  for(var x in data.all_result) {
							if(data.all_result[x]['sub_reported_to'] == null || data.all_result[x]['sub_reported_to'] == '') 
							   { 
									sub_supervisor_name = 'N/A'; 
							   } else{
									sub_supervisor_name = data.all_result[x]['sub_emp_name']; 
								}  
							if(data.all_result[x]['sub_reported_to'] == null || data.all_result[x]['sub_reported_to'] == '') 
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
							if(data.all_result[x]['sub_reported_to'] == null || data.all_result[x]['sub_reported_to'] == '') 
							   { 
									sub_action = ''; 
							   } else{
								   if(data.all_result[x]['first_super_action'] == 1){
									   sub_action = 'Recommended';
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
									 
							   } 
							   else{
								  sup_action = '';
								} 
							 t_row += 	"<tr><td>"+data.all_result[x]['emp_id']+"</td><td>"+data.all_result[x]['emp_name_eng']+"</td><td align='center'>"+data.all_result[x]['application_date']+"</td><td align='center'>"+data.all_result[x]['leave_from']+"</td><td align='center'>"+data.all_result[x]['leave_to']+"</td><td align='center'>"+data.all_result[x]['type_name']+"</td><td>"+data.all_result[x]['remarks']+"</td><td align='center'>"+sub_supervisor_name+"</td><td align='center'>"+first_super_action_date+"</td><td>"+sub_action+"</td><td>"+first_super_remarks+"</td><td align='center'>"+supervisor_name+"</td><td align='center'>"+super_action_date+"</td><td>"+sup_action+"</td><td>"+super_remarks+"</td></tr>";
					   } 
						 $('#add_table').append(t_row);
					   }
					 });
				});
	
	
	
		function view(application_id,supervisor_type,supervisor_id)
		{
			if(supervisor_type == 1)
			{
				document.getElementById("action_name").innerHTML = 'Approve';
			}
			else{
				document.getElementById("action_name").innerHTML = 'Proceed'; 
			}
			document.getElementById("v_leave_form").reset();	
			var url = "<?php echo e(URL::to('/get-leave-info')); ?>";
				$.ajax({
					type: "GET",
					url: url + "/" + application_id,
					success: function (res) {
						document.getElementById("v_application_id").value = res.application_id;
						document.getElementById("v_emp_name").value = res.emp_name +' [ '+ res.emp_id +' ]';
						document.getElementById("v_supervisor_type").value = supervisor_type;
						document.getElementById("v_supervisor_id").value = supervisor_id;
						document.getElementById("v_application_date").value = res.application_date;
						document.getElementById("v_leave_from").value = res.leave_from;
						document.getElementById("v_leave_to").value = res.leave_to;
						document.getElementById("v_no_of_days").value = res.no_of_days;
						document.getElementById("v_leave_type").value = res.leave_type;
						document.getElementById("v_remarks").value = res.remarks;	
						document.getElementById("modify_cancel").value = res.modify_cancel;	
						var x = document.getElementById("sub_panel");
						if (res.first_super_action >0) {
							x.style.display = "block";
						} else {
							x.style.display = "none";
						}
						document.getElementById("first_super_emp_id").innerHTML = res.sub_supervisor_name +
                            ' ( ' +
                            res.sub_reported_to + ' )';;		
						document.getElementById("first_super_action_date").innerHTML = res.first_super_action_date;		
						document.getElementById("first_super_remarks").innerHTML = res.first_super_remarks;
						if(res.first_super_action ==1)
						{
							var action = 'Recomended';
						}
						else if(res.first_super_action ==2){
							var action = 'Rejected';
						}else{
							var action = '';
						}
						document.getElementById("first_super_action").innerHTML = action;	
						
						if(res.modify_cancel > 0)
						{
							if(res.modify_cancel == 1)
							{
								var modify_msg = 'Modified Application';
							}
							else{
								var modify_msg = 'Cancelatation Application';
							}
							document.getElementById('modify_cancel_msg').innerHTML = modify_msg;
							document.getElementById('v_modify_remarks').innerHTML = res.modify_remarks;
							var is_modify = document.getElementById("is_modify");
							is_modify.style.display = "";
						}
						else{
							var is_modify = document.getElementById("is_modify");
							is_modify.style.display = "none";;
						}
					
						$('#v_modal_form').modal('show'); // show bootstrap modal when complete loaded
						$('.modal-title').text('View: Leave Application'); // Set title to Bootstrap modal title
					}
				})
		}	
	
		function save_approval()
		{
			var leave_approve_pending = parseInt(document.getElementById("leave_approve_pending").innerHTML);
			var new_leave_approve_pending = (leave_approve_pending - 1);
			document.getElementById("myNav").style.width = "100%";
			$('#v_modal_form').modal('hide'); // Modal form hide	
			$('#btnSave').text('saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable 
			url = "<?php echo e(URL::to('/leave-appliacation-approve')); ?>";
			message='Data Saved Successfully';
			$.ajax({
				url : url,
				type: "POST",
				data: $('#v_leave_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					document.getElementById("myNav").style.width = "0%";
					if(data)
					{
						$.gritter.add({
							title: 'Success!',
							text: message,
							sticky: false,
							class_name: 'gritter-light'
						}); 
					}
					//$('#v_modal_form').modal('hide'); // Modal form hide	
					$('#btnSave').text('Save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
					$("#list_approval").load(location.href + " #list_approval");
					document.getElementById("leave_approve_pending").innerHTML = new_leave_approve_pending;	
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
		
		function save_action(application_id,supervisor_id,action_id)
		{
			if (confirm('Confirm to execute !!')) {
				document.getElementById("myNav").style.width = "100%";
				var leave_approve_pending = parseInt(document.getElementById("leave_approve_pending").innerHTML);
				var new_leave_approve_pending = (leave_approve_pending - 1);
				var url = "<?php echo e(URL::to('/leave_approval')); ?>";
				$.ajax({
					type: "GET",
					url: url + "/" + application_id+ "/" + supervisor_id+ "/" + action_id,
					success: function (data) {
						$("#list_approval").load(location.href + " #list_approval");
						document.getElementById("leave_approve_pending").innerHTML = new_leave_approve_pending;	
						document.getElementById("myNav").style.width = "0%";
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
	
	<!-- Start Bootstrap modal -->
	<div class="modal fade" method="post" id="v_modal_form"  role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>				
				<form class="form-horizontal" role="form" id="v_leave_form"> 
					<?php echo e(csrf_field()); ?>

					<span id="post_method"></span>
					<input class="form-control" type="hidden" name="application_id" id="v_application_id" readonly>
					<input class="form-control" type="hidden" name="supervisor_type" id="v_supervisor_type" readonly>
					<input class="form-control" type="hidden" name="supervisor_id" id="v_supervisor_id" readonly>
					<input class="form-control" type="hidden" name="modify_cancel" id="modify_cancel" readonly> 
					<br>
					<div class="form-group">
						<label for="supervisor" class="col-sm-3 control-label">Applicant Name</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="v_emp_name" id="v_emp_name" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="supervisor" class="col-sm-3 control-label">Application Date</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="v_application_date" id="v_application_date" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="leave_type" class="col-sm-3 control-label">Leave Source</label>
						<div class="col-sm-8">
							<select class="form-control" name="v_leave_type" id="v_leave_type" disabled readonly>
                                <?php foreach ($leave_types_all as $v_leave_types_all) { ?>
                                <option value="<?php echo $v_leave_types_all->id; ?>"><?php echo $v_leave_types_all->type_name; ?></option>
                                <?php } ?>
                            </select>
						</div>
					</div>
					<div class="form-group">
						<label for="leave_from" class="col-sm-3 control-label">Date From</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="v_leave_from" name="v_leave_from" readonly><span>
						</div>
					</div>
					<div class="form-group">
						<label for="leave_to" class="col-sm-3 control-label">Date To</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="v_leave_to" name="v_leave_to" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="leave_to" class="col-sm-3 control-label">Duration (Days)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="v_no_of_days" name="v_no_of_days" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="remarks" class="col-sm-3 control-label">Purpose of leave</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="v_remarks" id="v_remarks" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="remarksss" class="col-sm-3 control-label">Action</label>
						<div class="col-sm-8">
							<select class="form-control" name="action" id="action">
								<option value="1" id="action_name">Approve / Proceed</option>
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
					
					<div class="table-responsive" id="is_modify">
						<hr>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="50%">Modify</th>
                                    <th width="50%">Modefy Remarks</th>
                                </tr>
                            </thead>
							<tbody>
                                <tr>
                                    <td id="modify_cancel_msg"></td>
                                    <td id="v_modify_remarks"></td>
                                </tr>
                            </tbody>
                        </table>
					</div>
					<div class="modal-footer">
						<button type="button" id="btnsave"  onclick="save_approval()"  class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Bootstrap modal -->
	<script>
		//To active  menu.......//
		$(document).ready(function() {
			setInterval(function () {
					$("#list_approval").load(location.href + " #list_approval");
					$("#leave_approve_pending").load(location.href + " #leave_approve_pending");
				}, 1000);
			$("#MainGroupSelf_Care").addClass('active');
			$("#Leave_Approve").addClass('active');

		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>