@extends('admin.admin_master')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Recommend Leave</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Recommend</a></li>
			<li class="active">Leave</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header --> 
					<div class="box-body">
					
					<form action="{{URL::to('leave_bulk_action_hrm')}}" onsubmit="return validateForm()"	method="post">
							{{ csrf_field() }}
						
						<div class="table-responsive">
						<table class="table table-bordered" cellspacing="0">
							<thead>
								 
									<tr>
										<th align="center" style="text-align:center;"> <b>Bulk Action</b><br><input type="checkbox" id="selectall" onClick="selectAll(this);" /></th> 
										<th style="text-align:center;"><b>Employee Name<b></td>
										<th align="center" style="text-align:center;"><b>Photo<b></td>
										<th style="text-align:center;"><b>Employee ID<b></td>
										<th style="text-align:center;"><b>Designation<b></td>
										<th style="text-align:center;"><b>Branch<b></td>
										<th style="text-align:center;"><b>Application Date<b></td>
										<th style="text-align:center;"><b>Leave Type<b></td>
										<th style="text-align:center;"><b>Date From<b></td>
										<th style="text-align:center;"><b>Date To<b></td>
										<th style="text-align:center;"><b>Duration<b></td>
										<th align="center" style="text-align:center;"><b>Detail Action</b></th>	 
									</tr>
							</thead> 
								<tbody>	
									<?php
										
										if(!empty($leave_recoment_list)){ 
										$columns = array_column($leave_recoment_list, 'id');
										array_multisort($columns, SORT_DESC, $leave_recoment_list);
									/*  echo "<pre>";
									print_r($leave_recoment_list);
									exit;  */
									?>
										@php 
											$i=1
										@endphp
										@foreach($leave_recoment_list as $emp_leave)
											<input type="hidden" name="application_id[]"  class="form-control" value="{{$emp_leave['id']}}">	 
											<input type="hidden" name="uni_emp_id[]"  class="form-control" value="{{$emp_leave['uni_emp_id']}}">	 
											<input type="hidden" name="emp_id[]"  class="form-control" value="{{$emp_leave['emp_id']}}"> 
											<input type="hidden" name="f_year_id[]"  class="form-control" value="{{$emp_leave['f_year_id']}}">	 
											<input type="hidden" name="type_id[]"  class="form-control" value="{{$emp_leave['type_id']}}">	 
											<input type="hidden" name="designation_code[]"  class="form-control" value="{{$emp_leave['designation_code']}}">	 
											<input type="hidden" name="branch_code[]"  class="form-control" value="{{$emp_leave['branch_code']}}">	 
											<input type="hidden" name="application_date[]"  class="form-control" value="{{$emp_leave['application_date']}}">	 
											<input type="hidden" name="apply_for[]"  class="form-control" value="{{$emp_leave['apply_for']}}">	 
											<input type="hidden" name="remarks[]"  class="form-control" value="{{$emp_leave['remarks']}}">	 
											<input type="hidden" name="approved_id[]"  class="form-control" value="{{$emp_leave['approved_id']}}">	 
											<input type="hidden" name="appr_desig_code[]"  class="form-control" value="{{$emp_leave['appr_desig_code']}}">	 
											<input type="hidden" name="leave_remain[]"  class="form-control" value="0">	 
											<input type="hidden" name="tot_earn_leave[]"  class="form-control" value="{{$emp_leave['tot_earn_leave']}}">	 
											<input type="hidden" name="cum_balance_less_12[]"  class="form-control" value="{{$emp_leave['cum_balance_less_12']}}">	 
											<input type="hidden" name="cum_balance[]"  class="form-control" value="{{$emp_leave['cum_balance']}}">	 
											<input type="hidden" name="pre_cumulative_open[]"  class="form-control" value="{{$emp_leave['pre_cumulative_open']}}">	 
											<input type="hidden" name="current_open_balance[]"  class="form-control" value="{{$emp_leave['current_open_balance']}}">	 
											<input type="hidden" name="casual_leave_open[]"  class="form-control" value="{{$emp_leave['casual_leave_open']}}">	 
											<input type="hidden" name="from_date[]"  class="form-control" value="{{$emp_leave['leave_from']}}">	 
											<input type="hidden" name="to_date[]"  class="form-control" value="{{$emp_leave['leave_to']}}">	 
											<input type="hidden" name="no_of_days[]"  class="form-control" value="{{$emp_leave['no_of_days']}}">	 
										<tr> 
											<td style="text-align:center;"> 
											@if($emp_leave['type_id'] != 3)
											<input type="checkbox" name="flag[]" value="{{$emp_leave['id']}}">
											@endif
											</td>   
											<td style="text-align:center;"><b><?php if(!empty($emp_leave['emp_name'])) { 
													echo $emp_leave['emp_name']; 
												} else {
													echo $emp_leave['emp_name2']; 
												} ?> </b>
											</td>
											<?php if($emp_leave['emp_photo']) { ?>
											<td align="center" style="text-align:center;"><img src="{{asset('public/employee/'.$emp_leave['emp_photo'])}}" height="40" width="40" alt="User profile picture"></td>
											<?php } else { ?>
											<td align="center"><img src="{{asset('public/avatars/no_image.jpg')}}" height="40" width="40" alt="User profile picture"></td>
											<?php } ?>										
											<td align="center"><?php echo $emp_leave['uni_emp_id']; ?></td>
											<td align="center"><?php echo $emp_leave['designation_name']; ?></td>
											<td align="center"><?php echo $emp_leave['branch_name']; ?></td>
											<td align="center"><?php echo date("d-m-Y",strtotime($emp_leave['application_date'])); ?></td>
											<td align="center"><?php echo $emp_leave['type_name']; ?></td>
											<td align="center"><?php echo date("d-m-Y",strtotime($emp_leave['leave_from'])); ?></td>
											<td align="center"><?php echo date("d-m-Y",strtotime($emp_leave['leave_to'])); ?></td>
											<td align="center"><?php echo $emp_leave['no_of_days']; if($emp_leave['apply_for'] == 2 ){ echo "Half Day Leave( Morning ) "; } else if($emp_leave['apply_for'] == 3 ){ echo "Half Day Leave( Evening )"; } ?></td> 
											<td style="text-align:center;"> 
											@if($emp_leave['executor_action'] != 1)
											<a class="btn btn-primary" title="details" href="{{URL::to('/approve_leave_byhrm/'.$emp_leave['id'])}}"><i class="glyphicon glyphicon-eye-open"></i></a>
											@endif
											</td>  
										</tr>
										@endforeach
										<?php } ?> 
								</tbody> 
						</table>
						</div>
						<?php if(!empty($leave_recoment_list)){ ?>
						<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Execute</button>
						<?php } ?>
					</form>	
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
		
<!-- DataTables -->
 

<script> 
	function validateForm() {    
					var flag  = document.getElementsByName("flag[]");
						
					console.log(flag.length);
					 var succeed = false;
					if(flag.length > 0){ 
						 succeed = true;
					}else{
						 alert("Please select checkbox !!!");
						 succeed = false;
					}
					return succeed;  
			}
	function selectAll(source) {
		checkboxes = document.getElementsByName('flag[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	} 
	$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			$("#approved_By_hrm").addClass('active');
			//$('[id^=Leave_Report_]')
		});
</script>

@endsection