<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>Employee<small>Mapping</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Mapping</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/emp_mapping')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Start Date</th>
								<th>Program</th>
								<th>Department</th>                 
								<th>Unit</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Start Date</th>
								<th>Program</th>
								<th>Department</th>                 
								<th>Unit</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $mapping_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($mapping->emp_id); ?></td>
								<td><?php echo e($mapping->emp_name_eng); ?></td>
								<td><?php echo e($mapping->start_date); ?></td>
								<td> <?php 
								if($mapping->current_program_id ==1) { echo 'Microfinance Program';}
								else if($mapping->current_program_id ==2) { echo 'Special Program';}
								?>
								</td>
								<td><?php echo e($mapping->department_name); ?></td>
								<td><?php echo e($mapping->unit_name); ?></td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/emp_mapping_view/'.$mapping->emp_id.'/'.$mapping->id)); ?>"><i class="fa fa-eye"></i></a>
									<!--<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/emp-mapping/'.$mapping->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>-->
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>