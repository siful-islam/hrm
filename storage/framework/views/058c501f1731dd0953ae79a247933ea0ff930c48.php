
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Payroll</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/font-awesome/css/font-awesome.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/Ionicons/css/ionicons.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/dist/css/AdminLTE.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/dist/css/skins/_all-skins.min.css')); ?>">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
	<header class="main-header">
		<nav class="navbar navbar-static-top">
		  <div class="container">
			<div class="navbar-header">
			  <a href="../../index2.html" class="navbar-brand"><b>Pay</b>Roll</a>
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
				<i class="fa fa-bars"></i>
			  </button>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
			  <ul class="nav navbar-nav">
				<!-- Notifications Menu -->
				<li class="dropdown notifications-menu">
				  <!-- Menu toggle button -->
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-bell-o"></i>
					<span class="label label-warning">10</span>
				  </a>
				  <ul class="dropdown-menu">
					<li class="header">You have 10 notifications</li>
					<li>
					  <!-- Inner Menu: contains the notifications -->
					  <ul class="menu">
						<li><!-- start notification -->
						  <a href="#">
							<i class="fa fa-users text-aqua"></i> 5 new members joined today
						  </a>
						</li>
						<!-- end notification -->
					  </ul>
					</li>
					<li class="footer"><a href="#">View all</a></li>
				  </ul>
				</li>
				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
				  <!-- Menu Toggle Button -->
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<!-- The user image in the navbar-->
				   <img src="<?php echo e(asset(Session::get('admin_photo'))); ?>" class="user-image" width="30" alt="User Image">
					<!-- hidden-xs hides the username on small devices so only the image appears. -->
					<span class="hidden-xs">Alexander Pierce</span>
				  </a>
				  <ul class="dropdown-menu">
					<!-- The user image in the menu -->
					<li class="user-header">
						<img src="<?php echo e(asset(Session::get('admin_photo'))); ?>" class="img-circle" alt="User Image">
						<p>Alexander Pierce - Web Developer <small>Member since Nov. 2012</small></p>
					</li>
					<li class="user-footer">
					  <div class="pull-right">
						<a href="#" class="btn btn-default btn-flat">Sign out</a>
					  </div>
					</li>
				  </ul>
				</li>
			  </ul>
			</div>
			<!-- /.navbar-custom-menu -->
		  </div>
		  <!-- /.container-fluid -->
		</nav>
	</header>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>Payroll<small>it all starts here</small></h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Payroll</a></li>
				<li class="active">Generate</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="box">
				<div class="box-header with-border">
					<form class="form-inline report" action="<?php echo e(URL::to('/generate_payroll')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="branch">Branch:</label>
							<select class="form-control" id="br_code" name="br_code" required onchange="set_type();">						
								<option value="" hidden>-SELECT-</option>
								<?php foreach($branches as $branch) { ?>
								<option value="<?php echo $branch->br_code; ?>"><?php echo $branch->branch_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="salary_month">Salary Month:</label>
							<select name="salary_month" id="salary_month" class="form-control">
								<option value="01">Janyary</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
						<div class="form-group">
							<label for="status">Salary Year:</label>
							<select class="form-control" id="salary_year" name="salary_year" required>						
								<option value="2021">2021</option>
							</select>
						</div>
						<div class="form-group">
							<label for="type">Staff Type:</label>
							<select class="form-control" id="type" name="type" required>						
								<option value="1" <?php if($staff_type == 1) { echo 'selected';}?>>Regular</option>
								<option id="hide_bo" value="2" <?php if($staff_type == 2) { echo 'selected';}?>>HOB</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary" onclick="dateRange();">Search</button>
					</form>
					<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
							title="Collapse">
					  <i class="fa fa-minus"></i></button>
					</div>
				</div>
				
				<?php  if ($br_code !='') { ?>
				

				
				<div class="box-body">
					<div style="overflow-y: auto;" class="col-md-12">
						<table id="tblExport" class="table table-bordered" cellspacing="0" style="font-size:12px;">
							<thead style="background-color: #025F5F; color:white; font-weight: bold;">
								<tr>
									<td rowspan="2" align="center">SL No.</td>
									<td colspan="3" align="center">Employee Information</td>
									<td rowspan="2" valign="center" align="center">Basic Salary</td>
									<td valign="center" colspan="<?php echo count($payroll_heads_plus) + 3 ;?>" align="center">Salary Allowance</td>
									<td valign="center" colspan="<?php echo count($payroll_heads_minus) + 15 + 4;?>" align="center">Deduction</td>
									<td rowspan="2" align="center">Total Deductions</td>	
									<td rowspan="2" align="center">Salary After Deduction</td>	
									<td rowspan="2" align="center">Salary Deduction</td>	
									<td rowspan="2" align="center">Staff Security</td>
									<td rowspan="2" align="center">Mobile & Internet</td>	
									<td rowspan="2" align="center">Net Payable Salary</td>	
									<td align="center" colspan="6">Allowances</td>	
								</tr>
								<tr>
									<td align="center">Employee Name</td>
									<td align="center">Emp ID</td>
									<td align="center">Designation</td>
									<?php foreach($payroll_heads_plus as $payroll_head_plus) { ?>
									<td valign="center"align="center"><?php echo $payroll_head_plus->pay_head_name;?></td>
									<?php } ?>
									<td valign="center"align="center">Total Salary</td>
									<td valign="center"align="center">P.F (Org. Contribution)</td>
									<td valign="center"align="center">Gross Salary</td>
									<?php foreach($payroll_heads_minus as $payroll_head_minus) { ?>
									<td valign="center"align="center"><?php echo $payroll_head_minus->pay_head_name;?></td>
									<?php } ?>
									<td valign="center" align="center">House rent</td>
									<td valign="center" align="center">PF Loan(Pr)</td>
									<td valign="center" align="center">PF Loan(Int)</td>
									<td valign="center" align="center">Gratuity Loan(Pr)</td>
									<td valign="center" align="center">Gratuity Loan(Int)</td>
									<td valign="center" align="center">Car Loan(Pr)</td>
									<td valign="center" align="center">Car Loan(Int)</td>
									<td valign="center" align="center">Motorcycle Loan(Pr)</td>
									<td valign="center" align="center">Motorcycle Loan(Int)</td>
									<td valign="center" align="center">Bicycle Loan(Pr)</td>
									<td valign="center" align="center">Bicycle Loan(Int)</td>
									<td valign="center" align="center">General Loan(Pr)</td>
									<td valign="center" align="center">General Loan(Int)</td>
									<td valign="center" align="center">Laptop Loan(Pr)</td>
									<td valign="center" align="center">Laptop Loan(Int)</td>
									<td valign="center" align="center">Unsettled Staff Advance</td>
									<td valign="center" align="center">Fine</td>
									<td valign="center" align="center">AIT(Income Tax)</td>
									<td valign="center" align="center">Revenue Stamp</td>
									<td valign="center" align="center">Extra Mobile Bill</td>	
									<td valign="center" align="center">Fuel Allowance</td>	
									<td valign="center" align="center">Maintenance Allowance</td>	
									<td valign="center" align="center">Maintenance Allowance (Vehicle)</td>	
									<td valign="center" align="center">Maintenance Allowance(Office)</td>	
									<td valign="center" align="center">Allowance Total</td>	
								</tr> 
							</thead>
							
							<tbody>
								<?php $i = 1; 
								
								$pf = 0;
								$gross_salary = 0;
								$m_amount = 0;
								$interest = 0;
								$principal = 0;
								$us_adv = 0;
								$house_rent = 0;
								$fine_amount = 0;
								$cesb = 0;
								$tax_amounts = 0;
								$net_payable = 0;
								$salary_deduct = 0;
								$salary_after_deduction = 0;
								$total_deduction = 0;
								$minus_total_before_loan = 0;
								$loan_total = 0;
								$staff_security = 0;
								$mobile_internet = 0;

								foreach($all_result as $result) { ?>
								<?php if ($result['is_breaking'] == 1 && $result['is_arrear'] == 0) { ?>
								<tr>
									<td align="center" rowspan="3"><?php echo $i++; ?></td>
									<td align="center" rowspan="3" Style="color:blue;"><?php echo $result['emp_name_eng']; ?></td>
									<td align="center" rowspan="3"><?php echo $result['emp_id']; ?></td>
									<td align="center" rowspan="1"><?php echo $result['designation_name']; ?></td>
									<td align="right"><?php echo $result['basic_salary']; ?></td>
									<?php foreach($payroll_heads_plus as $payroll_head_plus) { ?>
									<td valign="right"align="center">0</td>
									<?php } ?>
									<?php foreach($payroll_heads_minus as $payroll_head_minus) { ?>
									<td valign="right"align="center">0</td>
									<?php } ?>
									<td align="right">0</td>	
								</tr>
								<tr>
									<td align="center">Breakdown</td>
									<td align="right"><?php echo $result['breakdown_basic']; ?></td>
									<?php foreach($payroll_heads_plus as $payroll_head_plus) { ?>
									<td valign="right"align="center">0</td>
									<?php } ?>
									<?php foreach($payroll_heads_minus as $payroll_head_minus) { ?>
									<td valign="right"align="center">0</td>
									<?php } ?>
									<td align="right">0</td>	
								</tr>
								<tr>
									<td align="center">Total</td>
									<td align="right"><?php echo $result['basic_salary'] + $result['breakdown_basic']; ?></td>
									<?php foreach($payroll_heads_plus as $payroll_head_plus) { ?>
									<td valign="right"align="center">0</td>
									<?php } ?>
									<?php foreach($payroll_heads_minus as $payroll_head_minus) { ?>
									<td valign="right"align="center">0</td>
									<?php } ?>
									<td align="right">0</td>	
								</tr> 
								<?php } else if ($result['is_breaking'] == 0 && $result['is_arrear'] == 1 ) { ?>
								
								<tr>
									<td align="center" rowspan="3"><?php echo $i++; ?></td>
									<td align="center" rowspan="3" Style="color:blue;"><?php echo $result['emp_name_eng']; ?></td>
									<td align="center" rowspan="3"><?php echo $result['emp_id']; ?></td>
									<td align="center" rowspan="1"><?php echo $result['designation_name']; ?></td>
									<td align="right"><?php echo $result['basic_salary']; ?></td>
									<?php $gross_salary = 0; $t_p_amount = $result['basic_salary']; $h = 0; foreach($payroll_heads_plus as $payroll_head_plus) { ?>
									<td valign="right" align="right">
									<?php echo $p_amount = $result['plus_allowance'][$h++];?>
									</td>
									<?php $t_p_amount += $p_amount; } ?>
									<td valign="right" align="right"><?php echo $t_p_amount; ?></td>
									<?php 
										if($result['emp_id'] >= 200000)
										{
											$pf = 0;
										}elseif($result['is_permanent'] == 2)
										{
											$pf = round((($result['basic_salary'] *10)/100)) ;
										}else{
											$pf = 0;
											
										}
									?>
									<td valign="right" align="right"><?php echo $pf; ?></td>
									<td valign="right" align="right"><?php echo $gross_salary = $t_p_amount + $pf; ?></td>
									<?php $mh= 0; $total_minus_before_loan =array();foreach($payroll_heads_minus as $payroll_head_minus) { ?>
									<td valign="right" align="right"><?php echo $m_amount = $result['minus_allowance'][$mh++];?></td>
									<?php $total_minus_before_loan[] = $m_amount; } ?>
									<?php 
										$first_date = '2021-03-01'; 
										$upto_date  = '2021-03-31';
										$total_loan = array(); foreach ($loan_products as $loan_product) { 
											$infos = DB::table('loan as loan')
												->leftJoin('loan_schedule as schedule', 'schedule.loan_id', '=', 'loan.loan_id')
												->where('loan.emp_id', '=', $result['emp_id'])
												->where('loan.loan_product_code', '=', $loan_product->loan_product_id)
												->where('loan.loan_status', '=', 1)
												->where('schedule.repayment_date', '>=', $first_date)
												->where('schedule.repayment_date', '<=', $upto_date)
												->where('schedule.status', '=', 'Not Paid')
												->select('schedule.principal_payable','schedule.interest_payable')
											->first(); 
										if($infos)
										{
											$principal = $infos->principal_payable;
											$interest = $infos->interest_payable;
										}
										else{
											$principal = 0;
											$interest = 0;
										}											
									?>
									<td align="right"><?php echo $principal; ?></td>
									<td align="right"><?php echo $interest;?></td>
									<?php $total_loan[] = $principal + $interest; } ?>
									<td align="right"><?php 
									$us_adv_infos = DB::table('tbl_extra_deduction')
															->where('emp_id', '=', $result['emp_id'])
															->where('month_year', '=', '2021-03-01')
															->whereIn('type_id', [1,2,3,4,6])
															->sum('monthly_pay');
									if($us_adv_infos)
									{
										$us_adv = $us_adv_infos; 
									}else{
										$us_adv = 0;
									}
									echo $us_adv;?></td>
									<td align="right">
									<?php 
									$month_year = '2021-03-01';
									$fine_infos = DB::table('tbl_extra_deduction')
																->where('emp_id', '=', $result['emp_id'])
																->where('month_year', '=', $month_year)
																->where('type_id', '=', 11)
																->sum('monthly_pay');
									if($fine_infos)
									{
										$fine_amount = $fine_infos; 
									}else{
										$fine_amount = 0;
									}
									echo $fine_amount ; 
									?>
									</td>
									<td align="right">
										<?php 
										$tax_infos = DB::table('tax_config')->where('emp_id', '=', $result['emp_id'])->first();
										if($tax_infos)
										{
											$tax_amounts = $tax_infos->tax_amount;
										}else{
											$tax_amounts = 0;
										}
										echo  $tax_amounts; ?>
									</td>
									<td align="right"><?php echo $stamp = 10; ?></td>
									<td align="right">
									<?php 
									$loan_total 			 = array_sum($total_loan); 
									$minus_total_before_loan = array_sum($total_minus_before_loan);
									echo $total_deduction = $minus_total_before_loan + $loan_total + $us_adv + $fine_amount + $cesb + $tax_amounts + $stamp; ?>
									</td>
									<td align="right"><?php echo $salary_after_deduction = $gross_salary - $total_deduction; ?></td>
									<td align="right"><?php 
									$month_year = '2021-03-01';
									$salary_deduction_infos = DB::table('tbl_extra_deduction')
																->where('emp_id', '=', $result['emp_id'])
																->where('month_year', '=', $month_year)
																->whereIn('type_id', [10, 5])
																->sum('monthly_pay');
							
									if($salary_deduction_infos)
									{
										$salary_deduct = $salary_deduction_infos; 
									}else{
										$salary_deduct = 0;
									}
									echo $salary_deduct ;  
									?></td>
									<td align="right"><?php 
									$month_year = '2021-03-01';
									$staff_security_infos = DB::table('tbl_extra_deduction')->where('emp_id', '=', $result['emp_id'])->where('month_year', '=', $month_year)->where('type_id', '=', 9)->first();
									if($staff_security_infos)
									{
										$staff_security = $staff_security_infos->monthly_pay; 
									}else{
										$staff_security = 0;
									}
									echo $staff_security; 
									?></td>
									<td align="right">
									<?php 
									if($result['designation_code'] == 1 )
									{
										$mobile_internet = 0; 
									}
									elseif($result['designation_code'] == 52 || $result['designation_code'] == 75)
									{
										$mobile_internet = 300; 
									}else{
										$mobile_internet = 500; 
									}
									echo $mobile_internet; 
									?>
									</td>
									<td align="right"><?php echo $net_payable = $salary_after_deduction - ($salary_deduct + $staff_security) + $mobile_internet; ?></td>
								</tr>
								<tr>
									<td align="center">Arrear</td>
									<td align="right"><?php echo $result['arrear_basic']; ?></td>
									<td align="right">0</td>	
								</tr>
								<tr>
									<td align="center">Total</td>
									<td align="right"><?php echo $result['basic_salary'] + $result['arrear_basic']; ?></td>
									<td align="right">0</td>	
								</tr> 
								<?php } elseif ($result['is_breaking'] == 1 && $result['is_arrear'] == 1 ) { ?>
								<tr>
									<td align="center" rowspan="4"><?php echo $i++; ?></td>
									<td align="center" rowspan="4" Style="color:blue;"><?php echo $result['emp_name_eng']; ?></td>
									<td align="center" rowspan="4"><?php echo $result['emp_id']; ?></td>
									<td align="center" rowspan="1"><?php echo $result['designation_name']; ?></td>
									<td align="right"><?php echo $result['basic_salary']; ?></td>
									<td valign="right"align="center">0</td>
								</tr>
								<tr>
									<td align="center">Breakdown</td>
									<td align="right"><?php echo $result['breakdown_basic']; ?></td>
									<td align="right">0</td>	
								</tr>
								<tr>
									<td align="center">Arrear</td>
									<td valign="right"align="center">0</td>
									<td align="right"><?php echo $result['arrear_basic']; ?></td>
									<td align="right">0</td>	
								</tr>
								<tr>
									<td align="center">Total</td>
									<td align="right"><?php echo $result['basic_salary'] + $result['breakdown_basic'] + $result['arrear_basic']; ?></td>
									<td align="right">0</td>	
								</tr> 
								<?php } else { ?>
								<tr>
									<td align="center"><?php echo $i++; ?></td>
									<td align="center"><?php echo $result['emp_name_eng']; ?></td>
									<td align="center"><?php echo $result['emp_id']; ?></td>
									<td align="center"><?php echo $result['designation_name']; ?></td>
									<td align="right"><?php echo $result['basic_salary']; ?></td>
									<?php $gross_salary = 0; $t_p_amount = $result['basic_salary']; $h = 0; foreach($payroll_heads_plus as $payroll_head_plus) { ?>
									<td valign="right" align="right">
									<?php echo $p_amount = $result['plus_allowance'][$h++];?>
									</td>
									<?php $t_p_amount += $p_amount; } ?>
									<td valign="right" align="right"><?php echo $t_p_amount; ?></td>
									<?php 
										if($result['emp_id'] >= 200000)
										{
											$pf = 0;
										}if($result['is_permanent'] == 2)
										{
											$pf = round((($result['basic_salary'] *10)/100)) ;
											
										}else{
											$pf = 0;
										}
									?>
									<td valign="right" align="right"><?php echo $pf; ?></td>
									<td valign="right" align="right"><?php echo $gross_salary = $t_p_amount + $pf; ?></td>
									<?php $mh= 0; $total_minus_before_loan =array();foreach($payroll_heads_minus as $payroll_head_minus) { ?>
									<td valign="right" align="right"><?php echo $m_amount = $result['minus_allowance'][$mh++];?></td>
									<?php $total_minus_before_loan[] = $m_amount; } ?>
									<?php 
									
									$house_rent_info = DB::table('house_deduc')->where('emp_id', '=', $result['emp_id'])->where('status', '=', 'Active')->first();
									if($house_rent_info)
									{
										$house_rent = $house_rent_info->deduction; 
									}else{
										$house_rent = 0;
									}
									?>
									<td valign="right" align="right"><?php echo $house_rent; ?></td>
									<?php 
										$first_date = '2021-03-01'; 
										$upto_date  = '2021-03-31';
										$total_loan = array(); foreach ($loan_products as $loan_product) { 
											$infos = DB::table('loan as loan')
												->leftJoin('loan_schedule as schedule', 'schedule.loan_id', '=', 'loan.loan_id')
												->where('loan.emp_id', '=', $result['emp_id'])
												->where('loan.loan_product_code', '=', $loan_product->loan_product_id)
												->where('loan.loan_status', '=', 1)
												->where('schedule.repayment_date', '>=', $first_date)
												->where('schedule.repayment_date', '<=', $upto_date)
												//->where('schedule.status', '=', 'Not Paid')
												->where('schedule.status', '=', 'Paid')
												->select('schedule.principal_payable','schedule.interest_payable')
											->first(); 
										if($infos)
										{
											$principal = $infos->principal_payable;
											$interest = $infos->interest_payable;
										}
										else{
											$principal = 0;
											$interest = 0;
										}											
									?>
									<td align="right"><?php echo $principal; ?></td>
									<td align="right"><?php echo $interest;?></td>
									<?php $total_loan[] = $principal + $interest; } ?>
									<td align="right"><?php 
									$us_adv_infos = DB::table('tbl_extra_deduction')
															->where('emp_id', '=', $result['emp_id'])
															->where('month_year', '=', '2021-03-01')
															->whereIn('type_id', [1,2,3,4,6])
															->sum('monthly_pay');
									if($us_adv_infos)
									{
										$us_adv = $us_adv_infos; 
									}else{
										$us_adv = 0;
									}
									echo $us_adv;?></td>
									<td align="right">
									<?php 
									$month_year = '2021-03-01';
									$fine_infos = DB::table('tbl_extra_deduction')
																->where('emp_id', '=', $result['emp_id'])
																->where('month_year', '=', $month_year)
																->where('type_id', '=', 11)
																->sum('monthly_pay');
									if($fine_infos)
									{
										$fine_amount = $fine_infos; 
									}else{
										$fine_amount = 0;
									}
									echo $fine_amount ; 
									?>
									</td>
									<td align="right">
										<?php 
										$tax_infos = DB::table('tax_config')->where('emp_id', '=', $result['emp_id'])->first();
										if($tax_infos)
										{
											$tax_amounts = $tax_infos->tax_amount;
										}else{
											$tax_amounts = 0;
										}
										echo  $tax_amounts; ?>
									</td>
									<td align="right"><?php echo $stamp = 10; ?></td>
									<td align="right">
									<?php 
									$loan_total 			 = array_sum($total_loan); 
									$minus_total_before_loan = array_sum($total_minus_before_loan);
									echo $total_deduction = $minus_total_before_loan + $house_rent + $loan_total + $us_adv + $fine_amount + $cesb + $tax_amounts + $stamp; ?>
									</td>
									<td align="right"><?php echo $salary_after_deduction = $gross_salary - $total_deduction; ?></td>
									<td align="right"><?php 
									$month_year = '2021-03-01';
									$salary_deduction_infos = DB::table('tbl_extra_deduction')
																->where('emp_id', '=', $result['emp_id'])
																->where('month_year', '=', $month_year)
																->whereIn('type_id', [10, 5])
																->sum('monthly_pay');
							
									if($salary_deduction_infos)
									{
										$salary_deduct = $salary_deduction_infos; 
									}else{
										$salary_deduct = 0;
									}
									echo $salary_deduct ;  
									?></td>
									<td align="right"><?php 
									$month_year = '2021-03-01';
									$staff_security_infos = DB::table('tbl_extra_deduction')->where('emp_id', '=', $result['emp_id'])->where('month_year', '=', $month_year)->where('type_id', '=', 9)->first();
									if($staff_security_infos)
									{
										$staff_security = $staff_security_infos->monthly_pay; 
									}else{
										$staff_security = 0;
									}
									echo $staff_security; 
									?></td>
									<td align="right">
									<?php 
									if($result['designation_code'] == 1 )
									{
										$mobile_internet = 0; 
									}
									elseif($result['designation_code'] == 52 || $result['designation_code'] == 75)
									{
										$mobile_internet = 300; 
									}else{
										$mobile_internet = 500; 
									}
									echo $mobile_internet; 
									?>
									</td>
									<td align="right"><?php echo $net_payable = $salary_after_deduction - ($salary_deduct + $staff_security) + $mobile_internet; ?></td>
									<td align="right"><?php echo $stampp = 0; ?></td>
									<td align="right"><?php echo $stampp = 0; ?></td>
									<td align="right"><?php echo $stampp = 0; ?></td>
									<td align="right"><?php echo $stampp = 0; ?></td>
									<td align="right"><?php echo $stampp = 0; ?></td>
									<td align="right"><?php echo $stampp = 0; ?></td>
								</tr> 
								<?php } } ?> 
							</tbody>
						</table>
					</div>
				</div>
				
				<?php } ?>
				
				
				<div class="box-footer">
					<button type="button" class="btn btn-primary">Save</button>
				</div>
			</div>
		</section>
	</div>
	
	<script>
	document.getElementById("br_code").value = '<?php echo $br_code; ?>';
	document.getElementById("salary_month").value = '<?php echo $salary_month; ?>';
	document.getElementById("salary_year").value = '<?php echo $salary_year; ?>';
	document.getElementById("hide_bo").style.display = "none";
	function set_type()
	{
		var br_code = document.getElementById("br_code").value;
		if(br_code == 9999)
		{
			document.getElementById("hide_bo").style.display = "";
		}else{
			document.getElementById("hide_bo").style.display = "none";
		}
	}
	</script>


	<footer class="main-footer">
		<div class="pull-right hidden-xs">
		  <b>Version</b> 2.1.0
		</div>
		<strong>Copyright &copy; <a href="https://adminlte.io">cdip</a>.</strong> All rights reserved.
	</footer> 
  

<!-- jQuery 3 -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<!-- SlimScroll -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('public/admin_asset/bower_components/fastclick/lib/fastclick.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('public/admin_asset/dist/js/adminlte.min.js')); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(asset('public/admin_asset/dist/js/demo.js')); ?>"></script>


</body>
</html>

