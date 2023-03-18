<?php $__env->startSection('title', 'Leave Application'); ?>
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
		<h4>Employee Leave</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li class="active">Leave</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header --> 
					<div class="box-header">
						<h3 class="box-title pull-right"> 
							<a href="<?php echo e(URL::to('/add-leave')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i>New Leave</a>
						</h3>
					</div> 
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-hover">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Application Date</th> 
									<th>Emp ID</th>  
									<th>Emp Name</th> 
									<th>Branch</th> 
									<th>Designation</th> 
									<th>Serial No</th> 
									<th>Approved date from</th> 
									<th>Approved date to</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Application Date</th> 
									<th>Emp ID</th> 
									<th>Emp Name</th> 
									<th>Branch</th> 
									<th>Designation</th> 
									<th>Serial No</th>
									<th>Approved date from</th> 
									<th>Approved date to</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</tfoot>
							<tbody>
								
								<?php  
									$i=1
								 ?>
								<?php if(!empty($emp_leave_list)): ?>
								<?php $__currentLoopData = $emp_leave_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($i++); ?></td>
									<td><?php echo e($emp_leave->application_date); ?></td> 
									<td><?php echo e($emp_leave->emp_id); ?></td>   
									<td> 
										<?php   
											echo $emp_leave->emp_name; 
										 ?> 
									</td>
									<td><?php echo e($emp_leave->branch_name); ?></td> 									
									<td><?php echo e($emp_leave->designation_name); ?></td> 									
									<td><?php echo e($emp_leave->serial_no); ?> </td> 
									<td><?php echo e($emp_leave->appr_from_date); ?> </td> 
									<td><?php echo e($emp_leave->appr_to_date); ?> </td> 
									<td class="text-center">
									<?php if($emp_leave->type_id != 2) { ?>
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/emp_leave_br_edit/'.$emp_leave->id)); ?>"><i class="glyphicon glyphicon-pencil"></i></a> 
									<?php }  ?>
									&nbsp;&nbsp;&nbsp;
										<a class="btn btn-primary" onclick="return checkDelete();"  href="<?php echo e(URL::to('/emp_leave_br_del/'.$emp_leave->id)); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
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
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	 -->

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
			$("#Leave_Application").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>