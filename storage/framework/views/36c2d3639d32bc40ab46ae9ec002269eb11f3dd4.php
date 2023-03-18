
<?php $__env->startSection('title', 'View Salary'); ?>
<?php $__env->startSection('main_content'); ?>

<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Salary</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> View Salary</h3>
			</div>
			<div class="box-body">	
				<form action="<?php echo e(URL::to('/view-salary')); ?>" method="post">
				<?php echo e(csrf_field()); ?>				
					<div class="form-group">
						<div class="col-sm-1">
							Employee ID:
						</div>
						<div class="col-sm-2">
							<input type="number" name="search_emp_id" id="search_emp_id" class="form-control" value="<?php echo $emp_id; ?>" required>							
						</div>
						<div class="col-sm-1">
							Effect Date: 
						</div>
						<div class="col-sm-2">
							<input type="date" name="search_effect_date" id="search_effect_date" value="<?php echo $effect_date; ?>" class="form-control" required>
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
			
			<hr>
			
			
			
			<?php if($emp_name !='') { ?>


			<div class="row">
			
				<div class="col-md-2">
					<div class="box box-primary">				
						<form action="<?php echo e(URL::to('')); ?>" method="post">
							<div class="box-body box-profile">
								<center>
									<div class="image-upload">
										<label for="file-input">
											<img id="emp_photo" class="img-thumbnail" src="<?php echo e(asset('public/employee/'.$emp_photo)); ?>" width="100"/>
										</label> 
									</div> 
								</center>
								<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
								<p class="text-muted text-center" id="designation_name"><?php echo e($designation_name); ?></p>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Org.Joining Date : </b><span id="joining_date"><?php echo e($joining_date); ?></span>
									</li>
									<li class="list-group-item">
										<b>Working Station : </b><span id="branch_name"><?php echo e($branch_name); ?></span>
									</li>
									<li class="list-group-item">
										<b>Salary Branch : </b><span id="salary_branch_name"><?php echo e($salary_branch_name); ?></span>
									</li>
									<li class="list-group-item">
										<b>Grade : </b><span id="grade_name"><?php echo e($grade_name); ?></span>
									</li>
									<?php if($grade_step > 0) { ?>
									<li class="list-group-item">
										<b>Grade Step : </b><span id="grade_step"> Step: <?php echo e($grade_step -1); ?> </span>
									</li>
									<?php } else { ?>
										<b>Grade Step : </b><span id="grade_step"> Step: N/A </span>
									<?php } ?>
									<li class="list-group-item">
										<b style="color:red;">Resign Date : </b><span id="branch_name" style="color:red;"> <?php echo e($resign_date); ?> </span>
									</li>
								</ul>
								<?php if($resign_date == '') { ?>
									<a href="#" class="btn btn-primary btn-block" id="employee_status"><b><?php echo e($emp_status); ?></b></a>
								<?php } elseif($resign_date < $effect_date) { ?>
									<a href="#" class="btn btn-danger btn-block" id="employee_status"><b>Terminated</b></a>
								<?php } elseif($resign_date > $effect_date){ ?>
									<a href="#" class="btn btn-primary btn-block" id="employee_status"><b><?php echo e($emp_status); ?></b></a>
								<?php }else { ?>
									<a href="#" class="btn btn-primary btn-block" id="employee_status"><b><?php echo e($emp_status); ?></b></a>
								<?php } ?>
							</div>
						</form>
						<!-- /.box-body -->
					</div>
				
				</div>
				<div class="col-md-10">
				
				<?php //print_r($plus_item_name); ?>
				
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-6 control-label">Transaction:</label>
							<div class="col-sm-6">
							<?php if(!empty($last_salary))
							{
								$transaction_name = $last_salary->transaction_name;
							}else
							{ 
								$transaction_name = '';
							}
							?>
								<input type="text" class="form-control" id="total_minus" name="total_minus"  readonly value="<?php echo $transaction_name;?>" style="text-align:right;">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-8 control-label">Basic Salary:</label>
							<div class="col-sm-4">
								<?php if(!empty($last_salary))
								{
									$transaction_name = $last_salary->transaction_name;
									$salary_basic = $last_salary->salary_basic;
									$total_plus = $last_salary->total_plus;
									$payable = $last_salary->payable;
									$total_minus = $last_salary->total_minus;
									$net_payable = $last_salary->net_payable;
								}else
								{ 
									$transaction_name = '';
									$salary_basic = '';
									$total_plus = '';
									$payable = '';
									$total_minus = '';
									$net_payable = '';
								}
								?>
								<input type="number" class="form-control" name="salary_basic" id="salary_basic" value="<?php echo $salary_basic; ?>" readonly required style="text-align:right;">						
							</div>
						</div>
					</div>
					
					
					<div class="col-sm-6">
						<h4 style="color:blue;">Salary and Allowance</h4>
						<hr>
						<?php 
	
						if(@$plus_item_name[0]) { ?>
						<div class="form-group">
							<?php $p = 0; foreach($plus_item_name as $v_plus_item_name) { ?>
							<label class="col-sm-8 control-label"><?php echo $v_plus_item_name->items_name; ?></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" value="<?php echo $plus_taka[$p]; ?>" style="text-align:right;" readonly>
							</div>
							<?php $p++ ; } ?>
						</div>
						<?php } ?>
						<?php 
						
						//print_r($minus_item_name);
						
						if(@$minus_item_name[0]) { ?>
						<h4 style="color:blue;">Deduction</h4>
						<hr>
							<div class="form-group">
								<?php $m = 0; foreach($minus_item_name as $v_minus_item_name) { ?>
								<label class="col-sm-8 control-label"><?php echo $v_minus_item_name->items_name; ?></label>
								<div class="col-sm-4">
									<input type="text" class="form-control" value="<?php echo $minus_taka[$m]; ?>" style="text-align:right;" readonly>
								</div>
								<?php $m++ ; } ?>
							</div>
						<?php } ?>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-8 control-label">Plus Total:</label>
							<div class="col-sm-4">
								<input type="number" class="form-control" id="primary_total_plus" readonly value="<?php echo $total_plus;?>" style="text-align:right;">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-8 control-label">Total Payable:</label>
							<div class="col-sm-4"> 
								<input type="number" class="form-control" id="payable" name="payable" readonly value="<?php echo $payable;?>" style="text-align:right;">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-8 control-label">Minus Total:</label>
							<div class="col-sm-4">
								<input type="number" class="form-control" id="total_minus" name="total_minus"  readonly value="<?php echo $total_minus;?>" style="text-align:right;">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-8 control-label">Net Payable:</label>
							<div class="col-sm-4">
								<input type="number" class="form-control" name="net_payable" id="general_net_payable" readonly value="<?php echo $net_payable;?>" style="text-align:right;">
							</div>
						</div>
					</div>
					
				</div>
				
			</div>


			<hr>



			<div class="row">
				<div class="col-md-12">
					<div class="box box-solid">
						<!-- /.box-header -->
						<div class="box-body">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Sl</th>
										<th>Transection</th>
										<th>Effect Date</th>
										<th>Salary Basic</th>
										<th>Plus Total</th>
										<th>Payable</th>
										<th>Minus Total</th>
										<th>Net Payable</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									<?php $i=1; if($salary_history) { foreach($salary_history as $v_salary_history) { ?>
										<td><?php echo $i++;?></td>
										<td><?php echo $v_salary_history->transaction_name;?></td>
										<td><?php echo $v_salary_history->effect_date;?></td>
										<td><?php echo $v_salary_history->salary_basic;?></td>
										<td><?php echo $v_salary_history->total_plus;?></td>
										<td><?php echo $v_salary_history->payable;?></td>
										<td><?php echo $v_salary_history->total_minus;?></td>
										<td><?php echo $v_salary_history->net_payable;?></td>
									</tr>
									<?php } } else { ?>
									<tr>
										<td align="center" colspan="8">There is no Record</td>
									</tr>
									<?php } ?>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>
			<?php } ?>
	</section>
	<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#View_Salary").addClass('active');
		});
	</script>
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>