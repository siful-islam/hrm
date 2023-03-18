@extends('admin.admin_master')
@section('title', 'Approval')
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
				<h3 class="box-title">Loan Recommendation List</h3>
			</div>
			<div class="box-body no-padding"> 
					<div class="table-responsive">
					
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
								<th>loan Amount</th>
								<th>Action</th>
							</tr>
							<?php $i = 1; foreach($pending as $v_pending) { ?> 
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $v_pending->emp_name; ?></td>
								<td><?php echo $v_pending->emp_id; ?></td>
								<td><?php echo $v_pending->designation_name; ?></td>
								<td><?php echo $v_pending->branch_name; ?></td>
								<td><?php echo $v_pending->area_name; ?></td>
								<td><?php echo $v_pending->zone_name; ?></td>
								<td><?php echo $v_pending->application_date; ?></td>
								<td><?php echo $v_pending->loan_product_name; ?></td>
								<td><?php echo $v_pending->loan_amount; ?></td>
								<td><a class="btn btn-info" href="{{ URL::to("/loan-approval/$v_pending->loan_app_id/$action_type")}}";> <?php echo $btn_link;?></a></td>
							</tr>
							<?php } ?>
						</table>
						
					</div> 
			</div>
		</div>
		
		
		<hr>
		<div class="box box-danger">
			<div class="box-header">
				<form class="form-inline">
				  {{ csrf_field() }}   
                    <span id="post_method"></span>
					<div class="form-group">
						<label for="date_from">From Date:</label>
						<input class="form-control" name="date_from" id="date_from" type="date">
					</div>
					<div class="form-group">
						<label for="date_to">To Date:</label>
						<input class="form-control" name="date_to" id="date_to" type="date">
					</div>
					<button type="button" class="btn btn-success" onclick="show_data()">Show</button>
				</form>
			</div>
			<div class="box-body no-padding"> 
				<div class="table-responsive" id="dynamic_report">

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
	
	<script>
		function show_data()
		{
			var date_from 	= document.getElementById("date_from").value;  
			var date_to 	= document.getElementById("date_to").value;  
			var url = "{{ URL::to('/loan_report') }}"; 
			$.ajax({
				type: "GET",
				url: url + "/" + date_from + "/" + date_to,
				async: false,
				success: function(res) {
					$("#dynamic_report").html(res); 
				}
			})
		}
	</script>
@endsection