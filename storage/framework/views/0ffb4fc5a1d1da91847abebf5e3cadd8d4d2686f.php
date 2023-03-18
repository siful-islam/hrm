<?php $__env->startSection('title', 'Contractual | Official Info'); ?>
<?php $__env->startSection('main_content'); ?>
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
<!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Contractual <small> Renew</small></h1>
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
						<h3 class="box-title">Contractual Renew info</h3>
							<a href="<?php echo e(URL::to('/contractual_renew/create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
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
									<th>Designation</th>
									<th>Branch</th>   
									<th>Renew Date</th>   
									<th>Status</th>   
									<th style="width:15%">Options</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Emp ID</th> 
									<th>Employee Name</th>  
									<th>Designation</th>
									<th>Branch</th>   
									<th>Renew Date</th>   
									<th>Status</th>   
									<th style="width:15%">Options</th>
								</tr>
							</tfoot>
							<tbody>
							<?php 
								$j=1;
								if(!empty($results)){
								foreach($results as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->emp_id;?></td>  
									<td><?php echo $v_result->emp_name;?></td>  
									<td><?php echo $v_result->designation_name;?></td>   
									<td><?php echo $v_result->branch_name;?></td>   
									<td><?php echo date("d-m-Y",strtotime($v_result->effect_date));?></td>  
									<td><?php if($v_result->cancel_date == ''){ echo '<span style="color:green">Active</span>';}else { echo '<span style="color:red">Canceled</span>'; } ?></td> 
									<?php if($v_result->cancel_date == ''){ ?>
									<td>
										<?php if( date("Y-m-d",strtotime($v_result->created_at)) > "2021-01-03"){?>
										<a class="btn btn-sm btn-success btn-xs" title="Edit" href="<?php echo e(URL::to('contractual_renew/'.$v_result->id.'/edit')); ?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;&nbsp;&nbsp;
										<?php } ?>
									
									<a class="btn btn-sm btn-info btn-xs" title="view" href="<?php echo e(URL::to('view_contract_renew_info/'.$v_result->id)); ?>"><i class="fa fa-eye"></i> View</a></td> 
									<?php }else{ ?> 
										<td> <a class="btn btn-sm btn-info btn-xs" title="view" href="<?php echo e(URL::to('view_contract_renew_info/'.$v_result->id)); ?>"><i class="fa fa-eye"></i> View</a></td> 
									<?php } ?>
								</tr>
							<?php
								} 
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
		$("#MainGroupEmployee").addClass('active');
		$("#Contractual_Renew").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>