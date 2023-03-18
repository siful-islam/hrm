<?php $__env->startSection('title', 'Arrear Setup'); ?>
<?php $__env->startSection('main_content'); ?>
<section class="content-header">
	<h1>Arrear<small>Setup</small></h1>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="<?php echo e(URL::to('/arrear_setup/create')); ?>" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>From Date</th> 
								<th>To Date</th> 
								<th>Day/s</th> 
								<th>Basic</th> 
								<th>Basic Amount</th>                
								<th> Status </th>                
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>From Date</th> 
								<th>To Date</th> 
								<th>Day/s</th> 
								<th>Basic</th> 
								<th>Basic Amount</th>                 
								<th> Status </th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo $result->arrear_emp_id; ?></td>
								<td><?php echo $result->emp_name_eng; ?></td>
								<td><?php echo e($result->arrear_effect_date_from); ?></td> 
								<td><?php echo e($result->arrear_effect_date_to); ?></td> 
								<td><?php echo e($result->arrear_days); ?></td> 
								<td><?php echo e($result->arrear_basic); ?></td> 
								<td><?php echo e($result->arrear_basic_amount); ?></td>
								<td><?php if($result->paid_status == 1) echo "Full Paid"; else if($result->paid_status == 2) echo "Partial Paid";  ?></td>
								<td class="text-center">
									<?php if($result->paid_status == 0){ ?>
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/arrear_setup_pay/'.$result->arrear_id)); ?>">Pay</a>
									<?php } ?>
									<!--<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/arrear_setup/'.$result->arrear_id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i></a>-->
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
			$("#MainGroupSalary_Info").addClass('active');
			$("#Arrear_setup").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>