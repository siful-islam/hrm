
<?php $__env->startSection('title', 'Manage Scale'); ?>
<?php $__env->startSection('main_content'); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configureation</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Config</a></li>
			<li><a href="#">Employee Scale</a></li>
			<li class="active">Manage Scale</li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Scale Manager</h3>
							<a href="<?php echo e(URL::to('/config-scale/create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Scale</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>									
									<th>Scale Name</th>
									<th>Scale ID</th>
									<th>Basic Salary</th>               
									<th>Duration</th>               
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $scales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($scale->id); ?></td>
									<td><?php echo e($scale->scale_name); ?></td>
									<td><?php echo e($scale->scale_id); ?></td>
									<td><?php echo e($scale->scale_basic_1st_step); ?></td>
									<td><?php echo e($scale->start_from); ?> <span style="color:red;">to</span> <?php echo e($scale->end_to); ?></td>
									<td><?php echo e($scale->status); ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="<?php echo e(URL::to('/config-scale/'.$scale->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$("#Scale").addClass('active');
			});
	</script>
		


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>