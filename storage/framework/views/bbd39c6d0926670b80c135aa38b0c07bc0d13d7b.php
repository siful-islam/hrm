
<?php $__env->startSection('title', 'Branch Contractual | Staff Cancel'); ?>;
<?php $__env->startSection('main_content'); ?>

<!-- Content Header (Page header) -->
	
    <section class="content-header">
		<h1>Employee <small>All Contractual Cancel</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Eplooyee</a></li>
			<li class="active">Manage Contractual Cancell</li>
		</ol>
    </section>
	
	
	
	
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Contractual Cancell Branch</h3>
							<a href="<?php echo e(URL::to('/non_id_cancel_br_create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">	
						<div class="table-responsive">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th> 
									<th>Employee Name</th>
									<th>Emp Type </th>
									<th>Cancel Date</th>
									<th>Branch name</th>                                 
									<th>Cancel By</th>                                 
									<th style="width:15%">Options</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$j=1;
								foreach($result as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->emp_code;?></td> 
									<td><?php echo $v_result->emp_name;?></td> 
									<td><?php  echo $v_result->type_name;  ?></td> 
									<td><?php echo $v_result->cancel_date;?></td> 
									<td><?php echo $v_result->branch_name;?></td> 
									<td><?php echo $v_result->cancel_by;?></td>  
									<td><a class="btn btn-sm btn-success btn-xs" title="Edit" href="<?php echo e(URL::to('non_id_cancel_br_edit/'.$v_result->id)); ?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a></td>  
								</tr>
							<?php
							}
							?>
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
			$("#MainGroupBranch_Contractual").addClass('active');
			$("#Staff_Cancel").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>