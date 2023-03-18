
<?php $__env->startSection('title', 'Manage Offense'); ?>
<?php $__env->startSection('main_content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
			<li><a href="#">Employee Offense</a></li>
			<li class="active">Manage Offense</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Offense Manager</h3>
							<a href="<?php echo e(URL::to('/settings-offense/create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Offense</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Subject</th>
									<th>Details</th>
									<th>Punishment</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $offenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($offense->id); ?></td>
									<td><?php echo e($offense->crime_subject); ?></td>
									<td><?php echo e($offense->crime_detail); ?></td>
									<td><?php echo e($offense->punishment); ?></td>
									<td><?php echo e($offense->status); ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/settings-offense/'.$offense->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$("#Offence").addClass('active');
			});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>