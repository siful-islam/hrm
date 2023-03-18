
<?php $__env->startSection('title', 'Held Up'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>Employee<small>Heldup</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Heldup</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/heldup/create')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Heldup</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Letter Date</th>
								<th>Branch Name</th>
								<th>Designation</th>
								<th>HeldUp Type</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $heldup_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $heldup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($heldup->emp_id); ?></td>
								<td><?php echo e($heldup->emp_name_eng); ?></td>
								<td><?php echo e($heldup->letter_date); ?></td>
								<td><?php echo e($heldup->branch_name); ?></td>
								<td><?php echo e($heldup->designation_name); ?></td>
								<td><?php echo e($heldup->what_heldup); ?></td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/heldup/'.$heldup->id)); ?>"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/heldup/'.$heldup->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>    
					</table>
					</div>
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
		$("#MainGroupEmployee").addClass('active');
		$("#Held_up").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>