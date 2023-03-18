
<?php $__env->startSection('main_content'); ?>


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Self<small>Care</small></h1>
	</section>
	
	<section class="content-header">
      <a href="<?php echo e('/profile'); ?>"><h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5></a>
		<ol class="breadcrumb">
			<li><a href="<?php echo e('/profile'); ?>">Self Care -></a> ***</li>
		</ol>
    </section>
	
	<!-- Main content -->
	<section class="content">
	


			<div class="box box-info">
				
				<div class="box-header">
				  <h3 class="box-title">Leave Approval Board </h3>
				</div>
			
				<div class="box-body no-padding">
					
					
						<form action="<?php echo e('/'); ?>" method="post">
					
							<div class="table-responsive">
								
								<table class="table table-bordered table-striped" id="list_approval">
									<tr>
										<td rowspan="2">#</td>
										<td align="center" colspan="3"><b>Employee Information</b></td>
										<td align="center" colspan="3"><b>Leave Information</b></td>
										<td align="center" rowspan="2"><b>Detail Action</b></td>
										<td align="center" rowspan="2"><b>Quick Action</b></td>
										<td align="center"><b>Bulk Action</b></td>
									</tr>
									<tr>
										<td><b>Employee Name<b></td>
										<td align="centere"><b>Photo<b></td>
										<td><b>Emp ID<b></td>
										<td><b>Date From<b></td>
										<td><b>Date To<b></td>
										<td><b>Duration<b></td>
										<td align="center"><input type="checkbox" id="select-all"></td>
									</tr>
									<?php foreach($my_stafs as $staf){ ?>
									
										<?php if($staf->supervisor_type == 2 && $staf->stage == 0) { //SUB Supervisor ?>
										<!-- USER Level : SUB SUPERVISOR and Pending Stage Application Shows -->
										<tr>
											<td><?php echo $staf->application_id; ?></td>
											<td><?php echo $staf->emp_name; ?></td>
											<td align="centere"><img src="<?php echo e(asset('public/employee/'.$staf->emp_photo)); ?>" width="50"></td>
											<td><?php echo $staf->emp_id; ?></td>
											<td><?php echo $staf->leave_from; ?></td>
											<td><?php echo $staf->leave_to; ?></td>
											<td>
												<?php 
													$dStart = new DateTime($staf->leave_from);
													$dEnd  = new DateTime($staf->leave_to);
													$dDiff = $dStart->diff($dEnd);
													echo $dDiff->format('%r%a')+1;
												?> Days
											</td>
											<td align="center"><button type="button" class="btn btn-default btn-xs" onclick="view(<?php echo $staf->application_id; ?>)"> View</button></td>
											<td align="center">
												<button type="button" class="btn btn-primary btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,1);"><i class="fa fa-check" aria-hidden="true"></i> Recomendation</button>
												<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,2);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
											</td>
											<td align="center">
												<input type="checkbox" id="car" name="vechicle" value="car">
											</td>
										</tr>
										<tr>
											<td colspan="9"></td>
											<td align="center">
												<button type="submit" class="btn btn-success"> Submit</button>
											</td>
										</tr>
											
										
										<?php } elseif($staf->supervisor_type == 1 && $staf->stage < 2) { //Supervisor ?>
										<!-- USER Level : SUPERVISOR -->
										<?php 
										if($staf->first_super_action ==1)
										{
											$color = 'green';
											$title = 'Recomended by Sub-Supervisor';
										}
										elseif($staf->first_super_action ==2)
										{
											$color = 'red';
											$title = 'Rejected by Sub-Supervisor';
										}else
										{
											$color = 'black';
											$title = 'No Sub-Supervisor Activity';
										}
										?>
										<tr>
											<td><?php echo $staf->application_id; ?></td>
											<td title="<?php echo $title; ?>" style="color:<?php echo $color;?>"><?php echo $staf->emp_name; ?></td>
											<td align="centere"><img src="<?php echo e(asset('public/employee/'.$staf->emp_photo)); ?>" width="50"></td>
											<td><?php echo $staf->emp_id; ?></td>
											<td><?php echo $staf->leave_from; ?></td>
											<td><?php echo $staf->leave_to; ?></td>
											<td>
												<?php 
													$dStart = new DateTime($staf->leave_from);
													$dEnd  = new DateTime($staf->leave_to);
													$dDiff = $dStart->diff($dEnd);
													echo $dDiff->format('%r%a')+1;
												?> Days
											</td>
											<td align="center"><button type="button" class="btn btn-default btn-xs" onclick="view(<?php echo $staf->application_id; ?>)"> View</button></td>
											<td align="center">
												<button type="button" class="btn btn-success btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,3);"><i class="fa fa-check" aria-hidden="true"></i> Proceed</button>
												<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->application_id; ?>,<?php echo $staf->supervisor_id; ?>,4);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
											</td>
											<td align="center">
												<input type="checkbox" id="car" name="vechicle" value="car">
											</td>
										</tr>
										<tr>
											<td colspan="9"></td>
											<td align="center">
												<button type="submit" class="btn btn-success"> Submit</button>
											</td>
										</tr>
										<?php } ?>
								
									
									<?php }  ?>
									
								</table>

							</div>
						
						</form>
			
					
				</div>
			</div>

    </section>
	
	
	<script>
	
	function view(application_id)
	{
		var url = "<?php echo e(URL::to('/get-leave-info')); ?>";
			$.ajax({
				type: "GET",
				url: url + "/" + application_id,
				success: function (res) {
					document.getElementById("v_application_date").value = res.application_date;
					document.getElementById("v_leave_from").value = res.leave_from;
					document.getElementById("v_leave_to").value = res.leave_to;
					document.getElementById("v_leave_type").value = res.leave_type;
					document.getElementById("v_remarks").value = res.remarks;		
					document.getElementById("first_super_emp_id").innerHTML = res.first_super_emp_id;		
					document.getElementById("first_super_action_date").innerHTML = res.first_super_action_date;		
					document.getElementById("first_super_action").innerHTML = res.first_super_action;							
					$('#v_modal_form').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-title').text('View: Leave Application'); // Set title to Bootstrap modal title
				}
			})
	}	
	
	function save_approval()
	{
		/*$('#btnSave').text('saving...'); //change button text
		$('#btnSave').attr('disabled',true); //set button disable 
		url = "<?php echo e(URL::to('/leave-appliacation')); ?>";
		message='Data Saved Successfully';
		$.ajax({
			url : url,
			type: "POST",
			data: $('#leave_form').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				if(data.insert_status)
				{
					$.gritter.add({
						title: 'Success!',
						text: message,
						sticky: false,
						class_name: 'gritter-light'
					});
				}
				$('#btnSave').text('Save'); //change button text
				$('#btnSave').attr('disabled',false); //set button enable 
				$("#list_leave").load(location.href + " #list_leave");	
				document.getElementById("leave_form").reset();				
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
		});*/
	}
	
	
	
	function save_action(application_id,supervisor_id,action_id)
	{
		var url = "<?php echo e(URL::to('/leave_approval')); ?>";
			$.ajax({
				type: "GET",
				url: url + "/" + application_id+ "/" + supervisor_id+ "/" + action_id,
				success: function (data) {

					$("#list_approval").load(location.href + " #list_approval");
					//alert(data);
					
					//$("#dynamic_content").html(res); 
				}
			})
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
				<br>
				
					<form class="form-horizontal" role="form" id="v_leave_form"> 
		
						<div class="form-group">
							<label for="supervisor" class="col-sm-3 control-label">Application Date</label>
							<div class="col-sm-8">
							  <input class="form-control" type="text" name="v_application_date" id="v_application_date"readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label for="leave_type" class="col-sm-3 control-label">Leave Source</label>
							<div class="col-sm-8">
							   <select class="form-control" name="v_leave_type" id="v_leave_type" readonly>
									<option value="1">Earn</option>
									<option value="2">Meternity</option>
									<option value="3">Special</option>
									<option value="4">Quarantine</option>
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
							<label for="remarks" class="col-sm-3 control-label">Reason of leave</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="v_remarks" id="v_remarks" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label for="remarksss" class="col-sm-3 control-label">Action</label>
							<div class="col-sm-8">
								<select class="form-control" name="" id="">
									<option value="1">Approve</option>
									<option value="2">Reject</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="remarkssss" class="col-sm-3 control-label">Remarks</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="" id=""></textarea>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-striped">
								<tr>
									<td width="50%">Sub Supervisor</td>
									<td width="30%">Action Date</td>
									<td width="20%">Action</td>
								</tr>
								<tr>
									<td id="first_super_emp_id"></td>
									<td id="first_super_action_date"></td>
									<td id="first_super_action"></td>
								</tr>
							</table>
						</div>
						
						<div class="modal-footer">
							<button type="button" id="btnvisit"  onclick="save_approval()"  class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
					</form>
			</div>
		</div>
	</div>
	<!-- End Bootstrap modal -->
	
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>