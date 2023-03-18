<?php $__env->startSection('title', 'Branch Transfer'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>Branch<small>Transfer</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Branch Transfer</li>
	</ol>
</section>
<!-- Main content -->
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<?php if ($user_type ==3 || $user_type ==4) { ?>
				<div class="box-header">
					<a href="<?php echo e(URL::to('/br_transfer_emp')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<?php } ?>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Designation</th>
								<th>Branch</th>                 
								<th>Effect Date</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Designation</th>
								<th>Branch</th>                 
								<th>Effect Date</th>
								<th>Status</th>
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $transfer_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($transfer->emp_id); ?></td>
								<td><?php echo e($transfer->emp_name_eng); ?></td>
								<td><?php echo e($transfer->designation_name); ?></td>
								<td><?php echo e($transfer->branch_name); ?></td>
								<td><?php echo e(date('d-m-Y',strtotime($transfer->br_join_date))); ?></td>
								<td><?php echo ($transfer->status !=1) ? "<span style='color:red'>Pending</span>" : "<span style='color:green'>Approved</span>"; ?></td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/br_transfer_view/'.$transfer->emp_id.'/'.$transfer->id)); ?>"><i class="fa fa-eye"></i></a>
									<?php if($transfer->status !=1) { if ($user_type ==3 || $user_type ==4) { ?>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/br_transfer/'.$transfer->emp_id.'/'.$transfer->id)); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
									<?php } } ?>
									<?php if($transfer->status ==1) { if ($user_type ==3 || $user_type ==4) { ?>
									<a href="<?php echo e(asset('attachments/attach_ment_tran/'.$transfer->document_name)); ?>" target="_blank"><img height="40" width="40" src="<?php echo e(asset('public/attachment.png')); ?>" border="0" alt="Attachment" /></a>
									<?php } } ?>
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
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Branch_Transfer").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>