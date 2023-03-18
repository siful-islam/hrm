
<?php $__env->startSection('title', 'Contractual Cancel'); ?>
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
						<h3 class="box-title">Contractual Cancell</h3>
							<a href="<?php echo e(URL::to('/non-cancel/create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
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
							<tfoot>
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
							</tfoot> 
							 
								<tbody>
								<?php 
								$j=1;
								foreach($results as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->emp_code;?></td> 
									<td><?php echo $v_result->emp_name;?></td> 
									<td><?php  echo $v_result->type_name;  ?></td> 
									<td><?php echo $v_result->cancel_date;?></td> 
									<td><?php echo $v_result->branch_name;?></td> 
									<td><?php echo $v_result->cancel_by;?></td>  
									<td><a class="btn btn-sm btn-success btn-xs" title="Edit" href="<?php echo e(URL::to('non-cancel/'.$v_result->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a></td>  
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
		
<!-- DataTables
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	
<script type="text/javascript" src="<?php echo e(asset('public/admin_asset/bower_components/gritter/js/jquery.gritter.js')); ?>"></script> -->

<script>
/* 	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "<?php echo e(URL::to('/all-non-id_cancel')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "id" },
				{ "data": "emp_id" }, 
				{ "data": "emp_name" },
				{ "data": "type_name" },
				{ "data": "cancel_date" },
				{ "data": "branch_name" },
				{ "data": "cancel_by" },
				{ "data": "options" }
			]    
		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	} */
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupContractual").addClass('active');
		//$("#Transfer_(Contractual)").addClass('active');
		$('#Cancel').addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>