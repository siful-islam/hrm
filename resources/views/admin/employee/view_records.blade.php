@extends('admin.admin_master')
@section('title', 'View Records')
@section('main_content')
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>View Records</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<!--<h3 class="box-title"> {{$Heading}}</h3>-->
				<form class="form-horizontal" action="{{URL::to('view-records')}}" method="post">
                {{ csrf_field() }}	
					<div class="form-group">
						<div class="col-sm-1">	
							Employee ID :
						</div>
						<div class="col-sm-2">	
							<input type="number" class="form-control" name="emp_id" value="{{$emp_id}}" required>
						</div>
						<div class="col-sm-3">
							<button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-search-plus" aria-hidden="true"></i> Show Record </button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.box-header -->
		</div>	
		<?php if(count($employee_info) > 0) {?>	
			<div class="col-md-12">
				<div class="box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">View Records </h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<a class="btn btn-info pull-right" target="_BLANK" href="document-view/{{$emp_id}}/0/0"><i class="fa fa-book" aria-hidden="true"></i> EDMS</a>
						<br></br>
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
							<div class="carousel-inner">
								<?php $i= 1;  foreach($employee_info as $v_employee_info) { ?>
								<?php 
								if($i ==1 )
								{
									$class='item active';
								}
								else
								{
									$class='item';
								}
								?>
								<div class="<?php echo $class?>">
									<div class="col-md-12">
										 <!-- Profile Image -->
										<div class="box box-primary">
											<div class="box-body box-profile">
												<?php if($v_employee_info->emp_photo){ $emp_photo = $v_employee_info->emp_photo; }else { $emp_photo = 'default.png'; } ?>
												<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="{{asset('public/employee/'.$emp_photo)}}" alt="User profile picture">
												<p class="text-muted text-center">Employee ID: <?php echo $v_employee_info->emp_id; ?></p>
												<h3 class="profile-username text-center"><?php echo $v_employee_info->transaction_name; ?></h3>
												<center>
													<table class="table table-bordered table-striped" style="width:70%;">
														<tr>
															<td><b>Letter Date : </b> <?php echo $v_employee_info->letter_date; ?></td>
															<td><b>Sarok No : <?php echo $v_employee_info->sarok_no; ?></td>
														</tr>
														<tr>
															<td><b>Employee Name : </b> <?php echo $v_employee_info->emp_name; ?></td>
															<td><b>Employee Address : </b>  <?php echo $v_employee_info->emp_village; ?></td>
														</tr>
														<?php if($v_employee_info->transaction_code == 1 || $v_employee_info->transaction_code == 2 ||$v_employee_info->transaction_code == 3 ||$v_employee_info->transaction_code == 4  ||$v_employee_info->transaction_code == 6 ) { ?>
														
														<tr>
															<td><b>Designation  : </b> <?php echo $v_employee_info->designation_name; ?></td>
															<td><b>Department :</b>  <?php echo $v_employee_info->department_name; ?></td>
														</tr>
														<tr>
															<td><b>Working Station : </b> <?php echo $v_employee_info->branch_name; ?></td>
															<td><b>Grade : </b> <?php echo $v_employee_info->grade_name; ?></td>
														</tr>																											
														<tr>
															<td><b>Basic Salary: </b>  <?php  echo $v_employee_info->basic_salary; ?></td>
															<td><b>Grade Step : </b> <?php echo $v_employee_info->grade_step -1; ?></td>
														</tr>
														<?php } ?>
														<?php if($v_employee_info->transaction_code == 9 ) { ?>
														<tr>
															<td><b>Punishment Type : </b> <?php echo $v_employee_info->punishment_type; ?></td>
															<td><b>Punished By : </b>  <?php echo $v_employee_info->punishment_by; ?> </td>
														</tr>
														<tr>
															<td colspan="2"><b>Offense : </b> <?php echo $v_employee_info->crime_subject; ?></td>
														</tr>
														<tr>
															<td colspan="2"><b>Punishment Detail : </b> <?php echo $v_employee_info->punishment_details; ?></td>
														</tr>
														<?php } ?>
														<?php if($v_employee_info->transaction_code == 5) { ?>
														<tr>
															<td><b>What Heldup : </b> <?php echo $v_employee_info->what_heldup; ?></td>
															<td><b>Heldup Time : </b>  <?php echo $v_employee_info->heldup_time; ?> </td>
														</tr>
														<tr>
															<td colspan="2"><b>Heldup Until Date : </b> <?php echo $v_employee_info->heldup_until_date; ?></td>
														</tr>
														<tr>
															<td colspan="2"><b>Heldup Cause : </b> <?php echo $v_employee_info->heldup_cause; ?></td>
														</tr>
														<?php } ?>
														
														<?php if($v_employee_info->transaction_code == 7 ) { ?>
														<tr>
															<td><b>Effect Date : </b> <?php echo $v_employee_info->effect_date; ?></td>
															<td><b>Resigned By : </b>  <?php echo $v_employee_info->resignation_by; ?> </td>
														</tr>
														<?php } ?>

														<?php if($v_employee_info->transaction_code == 8 ) { ?>
														<tr>
															<td><b>Letter Date : </b> <?php echo $v_employee_info->letter_date; ?></td>
															<td><b>Effect Date : </b>  <?php //echo $v_employee_info->effect_date; ?> </td>
														</tr>
														<?php } ?>
														
													</table>
												</center>
												<br>
											</div>
											<!-- /.box-body -->
										</div>
										<!-- /.box -->
									</div>
									<div>
										Record : <?php echo $i. ' / '. count($employee_info); ?>										
									</div>
								</div>
								<?php $i++; } ?>								
							</div>
							<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><span class="fa fa-angle-left"></span></a>
							<a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><span class="fa fa-angle-right"></span></a>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<?php } else { ?>		
			<div class="col-md-12">
				<div class="box box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">View Records </h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					
					<h1>NO Employee Found !</h1>
					
					</div>
				</div>
			</div>
			<?php } ?>

	</section>
	<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#View_Records").addClass('active');
	});
</script>
@endsection