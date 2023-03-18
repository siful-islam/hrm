
<?php $__env->startSection('title', 'Contractual | Information'); ?>
<?php $__env->startSection('main_content'); ?>

<!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Contractual <small>All Contractual</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Contractual</a></li>
			<li class="active">Manage Contractual</li>
		</ol>
    </section>


    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Contractual </h3>
							<a href="<?php echo e(URL::to('/non-appoinment/create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">	
						<div class="table-responsive">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Emp ID</th> 
									<th>Emp Type</th>
									<th>Employee Name</th>
									<th>Org. Joining Date</th>
									<th>Present Branch</th>
									<th>Consolidated Salary</th>
									<th>Gross Salary</th>
									<th>Contact Number</th>
									<th>National ID</th>                                        
									<th>Status</th>                                          
									<th style="width:15%">Options</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Emp ID</th> 
									<th>Emp Type</th>
									<th>Employee Name</th>
									<th>Org. Joining Date</th>
									<th>Present Branch</th>
									<th>Consolidated Salary</th>
									<th>Gross Salary</th>
									<th>Contact Number</th>
									<th>National ID</th>
									<th>Status</th>
									<th style="width:15%">Options</th>
								</tr>
							</tfoot>
							<tbody>
							<?php 
								$j=1;
								foreach($results as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->sacmo_id;?></td>  
									<td><?php  echo $v_result->type_name;  ?></td>
									<td><?php echo $v_result->emp_name;?></td> 
									<td><?php echo date("d-m-Y",strtotime($v_result->joining_date));?></td> 
									<td><?php  echo $v_result->branch_name_o;?></td> 
									<td><?php echo $v_result->console_salary;?></td> 
									<td><?php echo $v_result->gross_salary;?></td> 
									<td><?php echo $v_result->contact_num;?></td> 
									<td><?php echo $v_result->national_id; ?></td>
									<td><?php if($v_result->cancel_date == ''){ echo '<span style="color:green">Active</span>';}else { echo '<span style="color:red">Canceled</span>'; } ?></td> 
									<?php if($v_result->cancel_date == ''){ ?>
										<td><a class="btn btn-sm btn-success btn-xs" onclick="is_contract_check_edit('<?php echo $v_result->id;?>','<?php echo $v_result->emp_id;?>');"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-info btn-xs" title="view" href="<?php echo e(URL::to('view-non-id/'.$v_result->id)); ?>"><i class="fa fa-eye"></i> View</a></td> 
									<?php }else{ ?> 
											<td><a class="btn btn-sm btn-info btn-xs" title="view" href="<?php echo e(URL::to('view-non-id/'.$v_result->id)); ?>"><i class="fa fa-eye"></i> View</a></td> 
									<?php } ?>
									
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
  		 
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	
<script type="text/javascript" src="<?php echo e(asset('public/admin_asset/bower_components/gritter/js/jquery.gritter.js')); ?>"></script>

<script>

	function is_contract_check_edit(id,emp_id)
		{
			 
			$.ajax({
				url : "<?php echo e(URL::to('is_contract_check_edit')); ?>"+"/"+id+"/"+emp_id, 
				type: "GET",
				dataType: 'json',
				success: function(data)
				{
						/*  alert(data['is_exist_salary']);
						return; */
						 if((data['is_exist_official'] == 1) || (data['is_exist_salary'] == 1 )){
							window.location.href = "<?php echo e(URL::to('non_id_info_edit')); ?>"+"/"+id;
						}else{ 
							window.location.href = "<?php echo e(URL::to('non-appoinment')); ?>"+"/"+id+"/edit";
						} 
				}
			}); 
		}


/* 	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
					 "url": "<?php echo e(URL::to('/all-non-id')); ?>",
					 "dataType": "json",
					 "type": "POST",
					 "data":{ _token: "<?php echo e(csrf_token()); ?>"}
				   },
			"columns": [
				{ "data": "id" },
				{ "data": "sacmo_id" },
				{ "data": "emp_type" },
				{ "data": "emp_name" },
				{ "data": "joining_date" },
				{ "data": "br_code" },
				{ "data": "gross_salary" },
				{ "data": "contact_num" },
				{ "data": "next_renew_date" },
				{ "data": "status" },
				{ "data": "options" }
			]    
		});
	});

	function reload_table()
	{
		table.ajax.reload(null,false); //reload datatable ajax 
	} */
</script>
  
<!--<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	-->	
	
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
		$("#MainGroupContractual").addClass('active');
		$("#Information").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>