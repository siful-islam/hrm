<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 14px;
}
.form-horizontal .control-label {
    text-align: left;
}
.form-group {
    margin-bottom: 4px;
}
h3 {
    margin-top: 1px;
    margin-bottom: 2px;
}
</style>
<section class="content-header">
	<h1>add-Mapping</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">add-Mapping</li>
	</ol>
</section>
<?php $user_type = Session::get('user_type');?>
<section class="content">
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div class="col-md-12">			
			<div class="col-md-5">
				<div class="box box-info">
					<div class="box-body">
						<h4><center><u>Current Information</u></center></h4>
						<div class="form-group">
							<label for="emp_id" class="col-sm-6 control-label">Employee ID </label>
							<div class="col-sm-6">			
								<p class="form-control-static">: <?php echo e($all_result->emp_id); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Employee Name </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->emp_name_eng; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Effect Date </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo date('d-m-Y',strtotime($all_result->start_date)); ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Mother Program </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php if($all_result->mother_program_id == 1) { echo 'Microfinance Program'; } else if($all_result->mother_program_id == 2) { echo 'Special Program'; }; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Current Program</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php if($all_result->current_program_id == 1) { echo 'Microfinance Program'; } else if($all_result->current_program_id == 2) { echo 'Special Program'; }; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Mother Department </label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->department_name; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Current Department</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo $all_result->current_department; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-6 control-label">Unit</label>
							<div class="col-sm-6">
								<p class="form-control-static">: <?php echo e($all_result->unit_name); ?></p>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<a href="<?php echo e(URL::to('/emp-mapping')); ?>" class="btn bg-olive" >List</a>
					</div>
				</div>
			</div>
			<?php if(!empty($mapping_info)): ?>
			<div class="col-md-7">
				<div class="box box-info">
					<div class="box-body">
						<h4><center><u>Mapping History</u></center></h4>
						<table class="table table-bordered" cellspacing="0">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>Start Date</th>
								<th>Mother Program</th>
								<th>Current Program</th>
								<th>Mother Department</th>
								<th>Current Department</th>
								<th>Unit</th>
							</tr>
						</thead>
						<tbody>
							<?php echo e(!$i=1); ?> <?php $__currentLoopData = $mapping_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td><?php echo e($i++); ?></td>
								<td><?php echo e(date('d-m-Y', strtotime($mapping->start_date))); ?></td>
								<td> <?php 
								if($mapping->mother_program_id ==1) { echo 'Microfinance Program';}
								else if($mapping->mother_program_id ==2) { echo 'Special Program';}
								?>
								</td>
								<td> <?php 
								if($mapping->current_program_id ==1) { echo 'Microfinance Program';}
								else if($mapping->current_program_id ==2) { echo 'Special Program';}
								?>
								</td>
								<td><?php echo e($mapping->department_name); ?></td>
								<td><?php echo e($mapping->current_department); ?></td>
								<td><?php echo e($mapping->unit_name); ?></td>
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
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>