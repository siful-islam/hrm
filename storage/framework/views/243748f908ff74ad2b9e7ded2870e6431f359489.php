<?php $__env->startSection('main_content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Employee CV</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Employee</a></li>
		<li class="active">CV</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/board-member/create')); ?>" class="btn btn-success pull-right" type="button"> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>
								<th>Name</th>
								<th>NID</th>
								<th>Mobile</th>
								<th>Designation</th>                      
								<th>Body Name</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>SL No</th>
								<th>Name</th>
								<th>NID</th>
								<th>Mobile</th>
								<th>Designation</th>                      
								<th>Body Name</th>
								<th>Status</th> 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $result_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<?php 
									if($result->designation == 1) {
										$designation_name = 'Chairman';
									} else if ($result->designation == 2) {
										$designation_name = 'Vice Chairman';
									}  else if ($result->designation == 3) {
										$designation_name = 'Secretary';
									}  else if ($result->designation == 4) {
										$designation_name = 'Member';
									} 
								?>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($result->name_eng); ?></td>
								<td><?php echo e($result->national_id); ?></td>
								<td><?php echo e($result->mobile_phone); ?></td>
								<td><?php echo e($designation_name); ?></td>
								<td><?php echo e($result->body_name == 1 ? "General" : "Governing"); ?></td>
								<?php if ($result->status !=0) { ?>
								<td style="color:green;"><?php echo 'Active'; ?></td>
								<?php } else { ?>
								<td style="color:red;"><b><?php echo 'InActive'; ?></b></td>
								<?php } ?>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/board-member/'.$result->id)); ?>">CV</a>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/board-member/'.$result->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
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