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
      <a href="{{'/profile'}}"><h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5></a>
		<ol class="breadcrumb">
			<li><a href="{{'/profile'}}">Self Care -></a> ***</li>
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
		background-color: #1d1d22;
		color: white;
		}
</style>
	
	<!-- Main content -->
	<section class="content">
	


			<div class="box box-info">
				
				<div class="box-header">
				  <h3 class="box-title">Movement Approval Panel</h3>
				</div>
			
				<div class="box-body no-padding">
					
						<form action="{{URL::to('move_bulk_action')}}" method="post">
							{{ csrf_field() }}
							<div class="table-responsive">
								
								<table class="table" id="list_approval" style="border">
									<tr>
										<th rowspan="2">#</th>
										<th align="center" colspan="3"><b>Employee Information</b></th>
										<th align="center" colspan="3"><b>Movement Information</b></th>
										<th align="center" rowspan="2"><b>Detail Action</b></th>
										<th align="center" rowspan="2"><b>Quick Action</b></th>
										<th align="center"><b>Bulk Action</b></th>
									</tr>
									<tr>
										<th><b>Employee Name<b></td>
										<th align="center"><b>Photo<b></td>
										<th><b>Emp ID<b></td>
										<th><b>Departure Date<b></td>
										<th><b>Arival Date<b></td>
										<th><b>Duration<b></td>
										<th align="center"><input type="checkbox" id="select-all"></th>
									</tr>
									<?php $duration = 0; if(count($my_stafs) >0) { foreach($my_stafs as $staf) { ?>
										<input type="hidden" id="move_id" name="move_id[]" value="<?php echo $staf->move_id; ?>">
										<input type="hidden" id="supervisor_type" name="supervisor_type[]" value="<?php echo $staf->supervisor_type; ?>">
										<input type="hidden" id="supervisor_id" name="supervisor_id[]" value="<?php echo $staf->supervisor_id; ?>">
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
											<td><?php echo $staf->move_id; ?></td> 
											<td title="<?php echo $title; ?>" style="color:<?php echo $color;?>"><b><?php echo $staf->emp_name; ?></b></td>
											<?php if($staf->emp_photo) { ?>
											<td align="center"><img src="{{asset('public/employee/'.$staf->emp_photo)}}" height="40" width="40" alt="User profile picture"></td>
											<?php } else { ?>
											<td align="center"><img src="{{asset('public/avatars/no_image.jpg')}}" height="40" width="40" alt="User profile picture"></td>
											<?php } ?>										
											<td align="center"><?php echo $staf->emp_id; ?></td>
											<td align="center"><?php echo $staf->from_date; ?></td>
											<td align="center"><?php echo $staf->to_date; ?></td>
											<td align="center">
												<?php 
													$dStart = new DateTime($staf->from_date);
													$dEnd  = new DateTime($staf->to_date);
													$dDiff = $dStart->diff($dEnd);
													echo $duration = $dDiff->format('%r%a')+1;
													if($duration >1)
													{
														echo ' Days';
													}else
													{
														echo ' Day';
													}
												?> 
											</td>
											<td align="center"><button type="button" class="btn btn-warning btn-xs" onclick="view(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_type; ?>,<?php echo $staf->supervisor_id; ?>)"> View <i class="fa fa-comment" aria-hidden="true"></i></button></td>
											<?php if($staf->supervisor_type == 2 && $staf->stage == 0) { //SUB Supervisor ?>
											<td align="center">
												<button type="button" class="btn btn-primary btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,1);"><i class="fa fa-check" aria-hidden="true"></i> Recomendation</button>
												<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,2);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
											</td>
											<?php } elseif ($staf->supervisor_type == 1 && $staf->stage < 2) { ?>
											<td align="center">
												<button type="button" class="btn btn-success btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,3);"><i class="fa fa-check" aria-hidden="true"></i> Proceed</button>
												<button type="button" class="btn btn-danger btn-xs" onclick="save_action(<?php echo $staf->move_id; ?>,<?php echo $staf->supervisor_id; ?>,4);"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
											</td>

											<?php } ?>

											<td align="center">
												<input type="checkbox" name="flag[]" value="<?php echo $staf->move_id; ?>">
											</td>
										</tr>
									<?php }  ?>
										<tr>
											<td colspan="9"></td>
											<td align="center">
												<button type="submit" class="btn btn-success"> Execute <i class="fa fa-play" aria-hidden="true"></i></button>
											</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td colspan="10" align="center" style="color:blue;">No Recoreds Found </td>
										</tr>
									<?php } ?>
								</table>

							</div>
						
						</form>
			
					
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
									<select    multiple="multiple" style="width: 100%;" id="destination_code" style="pointer-events:none;" class="form-control select2"> 
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
							<div class="col-sm-8">
								 <input type="date" readonly  id="v_from_date" autocomplete="off" class="form-control"  value="" required> 
							</div>
						</div>
						<div class="form-group">
							<label for="leave_time" class="col-sm-3 control-label">Departure Time</label>
							<div class="col-sm-8">
								<input  type="time" readonly id="v_leave_time"  value="" class="form-control" required>
							 
							</div>
						</div>  
						<div class="form-group">
							<label for="v_to_date" class="col-sm-3 control-label">Arrival Date</label>
							<div class="col-sm-8">
								<input type="date" readonly  id="v_to_date" autocomplete="off"   class="form-control" value="" required >
								
							</div>
						</div>
						<div class="form-group">
							<label for="v_arrival_time" class="col-sm-3 control-label">Arrival Time</label>
							<div class="col-sm-8">
								<input  type="time" readonly id="v_arrival_time"  value="" class="form-control" required>
							</div>
						</div>  
						<div class="form-group">
							<label for="remarksss" class="col-sm-3 control-label">Action</label>
							<div class="col-sm-8">
								<select class="form-control" name="action" id="action">
									<option value="1">Approve</option>
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
	 $('.select2').select2();
	function view(move_id,supervisor_type,supervisor_id)
	{
		
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
					$('#v_modal_form').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-title').text('View: Movement Application'); // Set title to Bootstrap modal title
				}
			})
	}	
	
	function save_approval()
	{
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
				//document.getElementById("v_visit_form").reset();		
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
			var url = "{{ URL::to('/movement_approval') }}";
				$.ajax({
					type: "GET",
					url: url + "/" + move_id+ "/" + supervisor_id+ "/" + action_id,
					success: function (data) {
						$("#list_approval").load(location.href + " #list_approval");
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
			$("#MainGroupApproval_panel").addClass('active');
			$("#Leave_Approve").addClass('active');
		});
	</script>
@endsection