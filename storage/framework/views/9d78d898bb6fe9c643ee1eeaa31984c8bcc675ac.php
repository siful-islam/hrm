<?php $__env->startSection('title', 'Salary Adjustment'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Payroll</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i>Employee</a></li>
			<li><a href="#">Salary</a></li>
			<li class="active">Adjustment</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Salary Adjustment</h3>
						<a href="<?php echo e(URL::to('/salary-adjustment/create')); ?>" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Adjustment </a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Employee ID</th>
									<th>Employee Name</th>
									<th>Letter Date</th>
									<th>Amount</th>                   
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $adjustment_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_adjustment_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($v_adjustment_info->id); ?></td>
									<td><?php echo e($v_adjustment_info->emp_name_eng); ?></td>
									<td><?php echo e($v_adjustment_info->emp_id); ?></td>
									<td><?php echo e($v_adjustment_info->letter_date); ?></td>
									<td><?php echo e($v_adjustment_info->adjustment_amount); ?></td>
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/salary-adjustment/'.$v_adjustment_info->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>       
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>		
	<script>
		var table;
		$(document).ready(function() {
		   table = $('#table').DataTable({
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Salary_Adjustment").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>