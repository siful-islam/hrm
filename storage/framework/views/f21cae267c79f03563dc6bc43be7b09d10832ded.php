<?php $__env->startSection('title', 'Loan Pending'); ?>
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Self<small>Care</small></h1>
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
				<h3 class="box-title">Loan Approval Panel</h3>
			</div>
			<div class="box-body no-padding"> 
					<div class="table-responsive">
					
						<div class="col-md-6">
						
							<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" role="form" method="POST" id="loan_form">
							<?php echo e(csrf_field()); ?>

							
							<?php //echo $action ?>

							<input type="hidden" class="form-control" name="supervisors_id" id="supervisors_id" value="<?php echo $supervisor_emp_id;?>" readonly>
							<input type="hidden" class="form-control" name="action_type" id="action_type" value="<?php echo $action_type;?>" readonly>	
							<input type="hidden" class="form-control" name="application_id" id="application_id" value="<?php echo $info->loan_app_id;?>" readonly>
							<input type="hidden" class="form-control" name="loan_type_id" id="loan_type_id" value="<?php echo $info->loan_type_id;?>" readonly>
							<input type="hidden" class="form-control" name="emp_id" id="emp_id" value="<?php echo $info->emp_id;?>" readonly>
							
							<?php if($ho_bo !=9999) { ?>
							<input type="hidden" class="form-control" name="supervisors_name" id="supervisors_name" value="<?php echo $supervisors_name;?>" readonly>
							<input type="hidden" class="form-control" name="supervisor_designation" id="supervisor_designation" value="<?php echo $supervisor_designation;?>" readonly>
							<?php } ?>
							<input type="hidden" class="form-control" name="ho_bo" id="ho_bo" value="<?php echo $ho_bo;?>" readonly>
								
								<table class="table table-bordered table-striped">
									<tr>
										<th>Employee Name</th>
										<td><input type="text" class="form-control" name="" id="" value="<?php echo $info->emp_name_eng;?>" readonly></td>
									</tr>
									<tr>
										<th>Loan Product</th>
										<td><input type="text" class="form-control" name="" id="" value="<?php echo $info->loan_product_name;?>" readonly></td>
									</tr>
									<?php if($info->loan_type_id == 7) { ?>
									<tr>
										<th>Equipments</th>
										<td><input type="text" class="form-control" name="" id="" value="<?php echo $info->equipments;?>" readonly></td>
									</tr>
									<?php } ?>
									<tr>
										<th>Loan Purpose</th>
										<td><input type="text" class="form-control" name="" id="" value="<?php echo $info->loan_purpose;?>" readonly></td>
									</tr>
									<tr>
										<th>Loan Amount</th>
										<td><input type="text" class="form-control" name="" id="" value="<?php echo $info->loan_amount;?>" readonly></td>
									</tr>
									<tr>
										<th>Action</th>
										<td>
											<select class="form-control" id="actions" name="actions">
												<option value="1"><?php echo $positive_action ?></option>
												<option value="2">Reject</option>
											</select>
										</td>
									</tr>
									<?php if($info->loan_type_id == 4) { ?>
									<tr>
										<th>Motorcycle Registration</th> 
										<td>
											<select class="form-control" id="motorcycle_registration" name="motorcycle_registration">
												<!--<option value="0">Not Applicable</option>-->
												<option value="1">Registration for Self</option>
												<option value="2">Registration for Organization</option>
											</select>
										</td>
									</tr>
									<?php } else{ ?>
									<input type="hidden" class="form-control" name="motorcycle_registration" id="motorcycle_registration" value="0" readonly>
									<?php } ?>
									<tr>
										<th>Remarks</th> 
										<td>
											<textarea class="form-control" name="actions_remarks" id="actions_remarks" required></textarea>
										</td>
									</tr>
									<tr>
										<td colspan="3" align="right"><input type="submit" name="btnSave" id="btnSave" class="btn btn-success" value="Submit"></td> 
									</tr>
								</table>
							</form>
						
						</div> 
						
						<div class="col-md-6">
						
						<?php
						//print_r($recomendation_info);
						?>
						<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td colspan="7" align="center" style="color:blue"><h3>Remarks</h3></td> 
									</tr>
									<tr>
										<td rowspan="2" align="center">No</td>
										<td colspan="3" align="center">Supervisor</td>
										<td rowspan="2" valign="center" align="center">Action Date</td>
										<td rowspan="2" valign="center" align="center">Action</td>
										<td rowspan="2" valign="center" align="center">Remarks</td>
									</tr>
									<tr>
										<td align="center">Name</td>
										<td align="center">ID</td> 
										<td align="center">Designation</td>
									</tr>
									<?php $l=1; foreach($recomendation_info as $v_recomendation_info) { 
									
									if($v_recomendation_info->actions == 1)
									{
										$actions =	'Recommended';
									}else{
										$actions =	'Rejected';
									}
									 ?>
									<tr>
										<td><?php echo $l++?></td>
										<td align="center"><?php echo $v_recomendation_info->supervisors_name?></td>
										<td align="center"><?php echo $v_recomendation_info->supervisors_id?></td>
										<td align="center"><?php echo $v_recomendation_info->supervisor_designation?></td>
										<td align="center"><?php echo $v_recomendation_info->action_date?></td>
										<td align="center"><?php echo $actions?></td>
										<td align="center"><?php echo $v_recomendation_info->actions_remarks?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						
					</div> 
					
					
					<div class="table-responsive">
						
						<div class="col-md-4">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td colspan="2" align="center" style="color:blue"><h3>Employee Info</h3></td> 
									</tr>
									<tr>
										<td><b>Employee Name:</b> </td> 
										<td><?php echo $basic_info['emp_name']; ?></td>
									</tr>
									<tr>
										<td><b>Employee ID:</b> </td> 
										<td><?php echo $basic_info['emp_id']; ?></td>
									</tr>
									<tr>
										<td><b>Designation:</b> </td>
										<td><?php echo $basic_info['designation_name']; ?></td>
									</tr>
									<tr>
										<td><b>Branch:</b> </td>
										<td><?php echo $basic_info['branch_name']; ?></td>
									</tr>
									<tr>
										<td><b>Joining Date:</b> </td>
										<td><?php echo date('d-m-Y',strtotime($basic_info['org_join_date'])); ?></td>
									</tr>
									<tr>
										<td><b>Service Length:</b> </td>
										<td>
											<?php 			
												$letter_date 	= date('Y-m-d');
												$joining_dates =   date('Y-m-d',strtotime($basic_info['joining_date'] . "+1 days"));												
												date_default_timezone_set('Asia/Dhaka');
												$input_date = new DateTime($letter_date);
												$org_date = new DateTime($joining_dates);	
												$difference = date_diff($org_date, $input_date);
												echo $difference->y . " years, " . $difference->m." months"; 
											?>		
										</td>
									</tr>
								</tbody>
							</table>
										
						</div>
						<div class="col-md-8">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td colspan="7" align="center" style="color:blue"><h3>Loan History</h3></td> 
									</tr>
									<tr>
										<td>No</td>
										<td>Loan Product</td>
										<td>Application Date</td>
										<td>Disbursement Date</td>
										<td>Loan Code</td>
										<td>Loan Amount</td>
										<td>Loan Status</td>
									</tr>
									<?php $l=1; foreach($previous_loan_info as $v_previous_loan_info) { 
									
									if($v_previous_loan_info->loan_status == 1)
									{
										$prv_loan_status = 'Running';
										$prv_loan_class = 'green';
									}elseif($v_previous_loan_info->loan_status == 2)
									{
										$prv_loan_status = 'Rescheduled';
										$prv_loan_class = 'blue';
									}else{
										$prv_loan_status = 'Paid';
										$prv_loan_class = 'red';
									}
									
									?>
									<tr>
										<td><?php echo $l++?></td>
										<td><?php echo $v_previous_loan_info->loan_product_name?></td>
										<td><?php echo $v_previous_loan_info->application_date?></td>
										<td><?php echo $v_previous_loan_info->disbursement_date?></td>
										<td><?php echo $v_previous_loan_info->loan_code?></td>
										<td><?php echo $v_previous_loan_info->loan_amount?></td>
										<td style="color:<?php echo $prv_loan_class ?>"><?php echo $prv_loan_status; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="table-responsive">
						<div class="col-md-4">
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td colspan="2" align="center" style="color:blue"><h3>P.F & Gratuity </h3></td> 
									</tr>
									<?php 
									
									if($basic_info['salary_br_code'] == 9999){
									$upto = '';	
									}else{
										$upto = ' (Upto June-2021)';
									}
									if($pf_info){
										$closing_balance_staff 	= $pf_info->closing_balance_staff;
										$closing_balance_org 	= $pf_info->closing_balance_org;
									}else{
										$closing_balance_staff 	= 0;
										$closing_balance_org 	= 0;
									}
									?>
									<tr>
										<td>P.F Amount:</td>
										<td><?php echo number_format($closing_balance_staff + $closing_balance_org) . $upto; ?></td>
									</tr>
									<tr>
										<td>Gratuity:</td>
										<td><?php echo number_format($gratuity_info)?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-8"> 
							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td colspan="4" align="center" style="color:blue"><h3>Grievance</h3></td> 
									</tr>
									<tr>
										<td>Sl.</td>
										<td>Date</td>
										<td>Details</td>
										<td>Fine</td>
									</tr>
									<?php $o = 1; foreach($offence_info as $v_offence_info) { ?>
									<tr>
										<td><?php echo  $o++; ?></td>
										<td><?php echo  $v_offence_info->letter_date; ?></td>
										<td style="color:red;"><?php echo  $v_offence_info->punishment_details; ?></td>
										<td><?php echo  $v_offence_info->fine_amount; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
			</div>
		</div>
		

    </section>
	
	<script>
		$(document).ready(function() {
			//$("#MainGroupSelf_Care").addClass('active');
			//$("#Leave_Approve").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>