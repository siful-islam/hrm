@extends('admin.admin_master')
@section('main_content')

<style>
.required {
    color: red;
    font-size: 20px;
}
</style>

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Salary</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Staff Salary</h3>
			</div>
			
			<div class="box-body">	
				<form action="{{URL::to('/generate-salary')}}" method="post">
				{{ csrf_field() }}				
					<div class="form-group">
						<div class="col-sm-1">
							Employee ID:
						</div>
						<div class="col-sm-2">
							<input type="number" name="search_emp_id" id="search_emp_id" class="form-control" value="<?php echo $emp_id; ?>" required>							
						</div>
						
						<div class="col-sm-1">
							Letter Date:
						</div>
						<div class="col-sm-2">
							<input type="date" name="search_letter_date" id="search_letter_date" value="<?php echo $letter_date; ?>" class="form-control" required>							
						</div>
						<div class="col-sm-1">
							<button type="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
						</div>
						<div class="col-sm-3">
							<span id="error" style="color:red;"></span>
						</div>						
					</div>
				</form>
			</div>
			
			
			<?php if($emp_status=='Active') { ?>
			
			<div class="row">
				<div class="col-md-2">
					<!-- Profile Image -->
					<div class="box box-primary">				
						<form action="{{URL::to('')}}" method="post">
							<div class="box-body box-profile">
								<center>
									<div class="image-upload">
										<label for="file-input">
											<img id="emp_photo" class="img-thumbnail" src="{{asset('public/employee/'.$emp_photo)}}" width="100"/>
										</label> 
									</div> 
								</center>
								<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
								<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Joining Date : </b><span id="joining_date"> {{$joining_date}}</span>
									</li>
									<li class="list-group-item">
										<b>Working Station : </b><span id="branch_name"> {{$branch_name}} </span>
									</li>
									<li class="list-group-item">
										<b>Grade : </b><span id="branch_name"> {{$grade_name}} </span>
									</li>
									<li class="list-group-item">
										<b>Grade Step : </b><span id="branch_name"> {{$grade_step}} </span>
									</li>
								</ul>
								<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>{{$emp_status}}</b></a>
							</div>
						</form>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
				<div class="col-md-10">
					<div class="box box-primary">
						<form class="form-horizontal" action="{{URL::to('/save-salary')}}" method="POST">
							{{ csrf_field() }}	
							
							<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="<?php echo $emp_id; ?>" required>
							<input type="hidden" name="letter_date" id="letter_date" class="form-control" value="<?php echo $letter_date; ?>" required>
							
							
							<div class="box-body col-md-10">							
								<div class="box-body">
									<div class="form-group">									
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Transection:</label>
												<div class="col-sm-6">
													<select class="form-control" name="transection" id="transection" required>
														<option value="">-SELECT-</option>
														<?php foreach($transections as $v_transections) { ?>
														<option value="<?php echo $v_transections->transaction_id; ?>" <?php if($v_transections->transaction_id == $transection_type) {echo 'selected';}?>><?php echo $v_transections->transaction_name; ?></option>
														<?php } ?>
													<select>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Scale:</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="scale" id="scale" value="<?php echo $scale_name;?>" readonly required>												
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Basic Salary:</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="salary_basic" id="basic_salary" value="<?php echo $basic_salary; ?>" required readonly>												
												</div>
											</div>
										</div>									
										<div class="col-sm-4">
											<?php $total_plus = 0; foreach($plus_items as $v_plus_items) { ?>
											<div class="form-group">
												<label class="col-sm-6 control-label"><?php echo $v_plus_items->item_name; ?> (+):</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="plus_item[]" value="<?php echo $plus_amount= round(($basic_salary*$v_plus_items->percentage)/100); ?>" style="text-align:right;">													
												</div>
											</div>
											<?php 
											$total_plus += $plus_amount;
											} ?>
										</div>											
										<div class="col-sm-4">
											<?php $total_minus = 0; foreach($minus_items as $v_minus_items) { ?>
											<div class="form-group">
												<label class="col-sm-6 control-label"><?php echo $v_minus_items->item_name; ?> (-):</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="minus_item[]" value="<?php echo $minus_amount= round(($basic_salary*$v_minus_items->percentage)/100); ?>" style="text-align:right;">
												</div>
											</div>
											<?php $total_minus += $minus_amount; } ?>
										</div>										
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Plus Total:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="total_plus" value="<?php echo $total_plus; ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label">Total Payable:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="payable" value="<?php echo $total_pay = $basic_salary+$total_plus; ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label">Minus Total:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="total_minus"  value="<?php echo $total_minus; ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label">Nit Payable:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="nit_payable" value="<?php echo $total_pay-$total_minus ?>">
												</div>
											</div>
										</div>
									</div>										

									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn btn-default">Cancel</button>
										<button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"><?php echo $button;?></button>
									</div>
									<!-- /.box-footer -->
								</div>	  
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php } else{ ?>
			
			<div class="row">
				<div class="col-md-12">
					<!-- Profile Image -->
					<div class="box box-primary">				


					</div>
					<!-- /.box -->
				</div>
			</div>
			
			<?php } ?>
	</section>
	
@endsection