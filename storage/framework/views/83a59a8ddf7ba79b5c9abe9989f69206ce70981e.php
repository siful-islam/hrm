
<?php $__env->startSection('title', 'Training'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>Employee<small>Training</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Training</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/training/create')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Training</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Training No</th>
								<th>Training Name</th>
								<th>Institute Name</th>
								<th>Date from</th>
								<th>Date to</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $training_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($training->training_no); ?></td>
								<td><?php echo e($training->training_name); ?></td>
								<td><?php if($training->institute_name == 1): ?> <?php echo e('CDIP'); ?> <?php endif; ?></td>
								<td><?php echo e($training->tr_date_from); ?></td>								
								<td><?php echo e($training->tr_date_to); ?></td>								
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/training/'.$training->training_no)); ?>"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/training/'.$training->training_no.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
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
			$("#Training").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>