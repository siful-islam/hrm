
<?php $__env->startSection('title', 'Staff Security'); ?>
<?php $__env->startSection('main_content'); ?>



    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Employee Department</a></li>
			<li class="active">Manage Department</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Security Money</h3>
							<a href="<?php echo e(URL::to('/staff-security/create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Staff Security</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Employee ID</th>
									<th>Date</th>
									<th>Amount</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $securities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $security): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($security->id); ?></td>
									<td><?php echo e($security->emp_id); ?></td>
									<td><?php echo e($security->diposit_date); ?></td>
									<td><?php echo e($security->diposit_amount); ?></td>
									<td><?php echo e($security->status); ?></td> 
									<td>
										<a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/staff-security/'.$security->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
										<a class="btn btn-sm btn-danger" title="Print" href="<?php echo e(URL::to('/staff-security/'.$security->id)); ?>"><i class="glyphicon glyphicon-print"></i></a>
									</td>
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
		$("#Staff_Security").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>