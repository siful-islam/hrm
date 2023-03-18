
<?php $__env->startSection('main_content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
				
					<form class="form-horizontal" action="<?php echo e(URL::to('next-incre-list')); ?>" method="post">
						<?php echo e(csrf_field()); ?>		
						<div class="form-group">
							<div class="col-sm-2">
								<select name="search_branch" id="search_branch" class="form-control" required>
									<option value="" hidden>-Select Branch-</option>
									<?php foreach($all_branches as $all_branch) { ?>
									<option value="<?php echo $all_branch->br_code?>"><?php echo $all_branch->branch_name?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-1">
								<button type="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
							</div>
						</div>
					</form>
					
				</div>
				
				<?php if(!empty($all_report)): ?>
				<div class="row">
					<div id="printme">
						<div class="col-md-12">
							<table class="table table-bordered" cellspacing="0">
								<thead>
									<tr>
										<th rowspan="2">SL No.</th>
										<th rowspan="2">Staff Name</th>
										<th rowspan="2">ID No</th>
										<th rowspan="2">Emp Type</th>
										<th rowspan="2">Designation</th>
										 
										<th rowspan="2">File</th>
									</tr> 
								</thead>
								<tbody>
									<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($i++); ?></td>
										<td><?php echo e($result['emp_name']); ?></td>
										<td><?php echo e($result['emp_id']); ?></td>
										<td><?php echo e($result['type_name']); ?></td>
										<td><?php echo e($result['designation_name']); ?></td> 
										<td><a href="<?php echo e(asset('attachments/attach_ment_tran/'.$result['document_name'])); ?>" target="_blank"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /></td> 
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
        </div>
	</div>
	
</section>
<script>
	document.getElementById("search_branch").value = '<?php echo $search_branch?>';
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>