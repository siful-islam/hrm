<?php $__env->startSection('title', 'Recruitment'); ?>
<?php $__env->startSection('main_content'); ?>
<!-- Content Header (Page header) -->
<script>  
function checkDelete()
	{
	 var chk=confirm("Are you sure to delete !!!");
		if(chk)
		{
		  return true;
		}
		else{
		  return false;
		}
	}
</script> 
<section class="content-header">
	<h4>Employee Recruitment</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Employee</a></li>
		<li class="active">Recruitment</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!-- /.box-header -->
				<div class="box-header">
					<a href="<?php echo e(URL::to('/add-recruit')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Recruitment</a>
				</div>
				<div class="box-body">
				<?php if(Session::has('message11')): ?>
					<h5 style="color:green">
					<?php echo e(session('message11')); ?>

					</h5>
					<?php endif; ?>
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>
								<th>Recruitment ID</th>
								<th>Circular Name</th>
								<th>Post Name</th>
								<th>Full Name</th>
								<th>Mobile No.</th>
								<th>Thana</th>                      
								<th>District</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr> 
								<th>SL No</th>
								<th>Recruitment ID</th>
								<th>Circular Name</th>
								<th>Post Name</th>
								<th>Full Name</th>
								<th>Mobile No.</th>
								<th>Thana</th>                      
								<th>District</th>                    
								<th class="text-center" style="width:15%">Action</th>
							 
							</tr>
						</tfoot>
						<tbody>
							
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e($data->new_recruitment_id); ?></td>
								<td><?php echo e($data->circular_name); ?></td>
								<td><?php echo e($data->post_name); ?></td>
								<td><?php echo e($data->full_name); ?></td>
								<td><?php echo e($data->contact_num); ?></td>
								<td><?php echo e($data->thana_name); ?></td>
								<td><?php echo e($data->district_name); ?></td>
								<td class="text-center">
								<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/recruitment_view/'.$data->id)); ?>"><i class="fa fa-eye"></i></a>
								<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/edit-recruit/'.$data->id.'/1')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
								&nbsp;&nbsp;
									<a class="btn btn-primary" onclick="return checkDelete();"  href="<?php echo e(URL::to('/delete_recruit/'.$data->id)); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
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
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Recruitment").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>