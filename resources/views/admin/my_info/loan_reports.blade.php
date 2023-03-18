@extends('admin.admin_master')
@section('title', 'Loan Report')
@section('main_content')
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

		@media screen and (max-height: 450px) {
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
				<img src="{{ asset('public/processing.gif') }}" width="100">
				<a href="#">Processing Your Approval ........</a>
			</div>
		</div>
		
		

		<div class="box box-info">
			<div class="box-header">
				<form action="{{URL::to('/loan_reports')}}" method="post" class="form-inline">
				  {{ csrf_field() }}   
                    <span id="post_method"></span>
					<div class="form-group">
						<label for="date_from">From Date:</label>
						<input class="form-control" name="date_from" id="date_from" value="<?php echo $date_from; ?>" type="date" required>
					</div>
					<div class="form-group">
						<label for="date_to">To Date:</label>
						<input class="form-control" name="date_to" id="date_to" type="date" value="<?php echo $date_to; ?>" required>
					</div>
					<div class="form-group">
						<label for="date_to">Loan Stage:</label>
						<select class="form-control" name="loan_stage" id="loan_stage" required>
							<option value="" hidden>Select</option>
							<option value="10">All</option>
							<option value="0">Pending</option>
							<option value="1">Recomended</option>
							<option value="2">Approved</option>
							<option value="3">Disbursed</option>
						</select>
					</div>
					<div class="form-group">
						<label for="date_to">Action Type:</label>
						<select class="form-control" name="action_type" required id="action_type">
							<option value="" hidden>Select</option>
							<option value="0">General</option>
							<option value="1">Rejected</option>
						</select>
					</div>
					<button type="submit" class="btn btn-success">Show</button>
				</form>
			</div>
			
			<br>
			<center><h3>Loan Report<h3></center>
			<hr>
			<div class="box-body no-padding"> 
				<div class="table-responsive" id="dynamic_report">
				
						<table class="table table-bordered table-striped">
							<tr>
								<th>#</th>
								<th>Employee Name</th>
								<th>ID</th>
								<th>Designation</th>
								<th>Branch</th>
								<th>Area</th>
								<th>Zone</th>
								<th>Apply Date</th>
								<th>Loan Type</th>
								<th>Loan Amount</th>
								<th>Status</th>
							</tr>
							<?php $i = 1; $total_loan_amount = 0;foreach($infos as $result) { 
							
							if($result->application_stage == 0){
								$status = 'Pending';
							}elseif($result->application_stage == 1)
							{
								$status = 'Recomended';
							}elseif($result->application_stage == 2)
							{
								$status = 'Approved';
							}elseif($result->application_stage == 3)
							{
								$status = 'Disbursed';
							}
							if($result->is_reject == 1)
							{
								$status = 'Rejected';
							}
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $result->emp_name; ?></td> 
								<td><?php echo $result->emp_id; ?></td> 
								<td><?php echo $result->designation_name; ?></td> 
								<td><?php echo $result->branch_name; ?></td>
								<?php 
									if($result->branch_name == 'Head Office')
									{
										$area_name = 'Head Office';
										$zone_name = 'Head Office';
									}else{
										$area_name = $result->area_name;
										$zone_name = $result->zone_name;
									}
								?>															
								<td><?php echo $area_name; ?></td> 
								<td><?php echo $zone_name; ?></td> 
								
								<td><?php echo $result->application_date; ?></td> 
								<td><?php echo $result->loan_product_name; ?></td> 
								<td align="right"><?php echo number_format($result->loan_amount); ?></td> 
								<td><a target="_BLANCK" href='{{URL::to("/application_location/$result->loan_app_id")}}'><?php echo $status; ?></a></td> 
							</tr>
							<?php $total_loan_amount += $result->loan_amount; } ?>
							<tr>
								<td colspan="9" align="right">Total</td>
								<td align="right"><?php echo number_format($total_loan_amount); ?></td> 
								<td>-</td> 
							</tr>
						</table>
				</div> 
			</div>
		</div>

    </section>
	
	<script>
	document.getElementById("loan_stage").value = '<?php echo $loan_stage?>';
	document.getElementById("action_type").value = '<?php echo $action_type?>';
	</script>
	
	<script>
		$(document).ready(function() {
			//$("#MainGroupSelf_Care").addClass('active');
			//$("#Leave_Approve").addClass('active');
		});
	</script>
@endsection