
<?php $__env->startSection('title', 'Manage Punishment Type'); ?>
<?php $__env->startSection('main_content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
			<li><a href="#">Punishment Type</a></li>
			<li class="active">Manage Punishment Type</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Punishment Type Manager</h3>
							<a href="<?php echo e(URL::to('/punishment-type/create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New punishment Type</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Punishment Type</th>                
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $punishment_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $punishment_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($punishment_type->id); ?></td>
									<td><?php echo e($punishment_type->punishment_type); ?></td>
									<td><?php echo e($punishment_type->status); ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/punishment-type/'.$punishment_type->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Punishment_Type").addClass('active');
			});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>