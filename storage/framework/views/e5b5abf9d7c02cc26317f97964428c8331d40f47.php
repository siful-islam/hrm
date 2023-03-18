
<?php $__env->startSection('title','Add License'); ?>
<?php $__env->startSection('main_content'); ?>
<script type="text/javascript" language="javascript">
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
	<?php  
	$msg = Session::get('msg_serial'); 
	if (!empty($msg)) {  
	echo "<script>alert('Serial number is : $msg');</script>";
	session()->forget('msg_serial'); 
	} 
	?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>License</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">License</a></li>
			<li class="active">Document</li>
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
							<a href="<?php echo e(URL::to('/add_create')); ?>" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add</a>
						</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Entry Date</th>
									<th>Employee ID</th> 
									<th>Employee Name</th> 
									<th>License Number</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Entry Date</th>
									<th>Employee ID</th> 
									<th>Employee Name</th> 
									<th>License Number</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</tfoot>
							<tbody>
								
								<?php  
									$i=1
								 ?>
								<?php $__currentLoopData = $emp_document_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($emp_leave->dri_license_id); ?></td>
									<td><?php echo e(date('d-m-Y',strtotime($emp_leave->created_at))); ?></td>
									<td><?php echo e($emp_leave->emp_id); ?></td> 
									<td><?php  
											echo $emp_leave->emp_name; 
										 ?> </td> 
									<td><?php echo e($emp_leave->license_number); ?></td> 
									<td class="text-center"> 
									<a class="btn bg-olive"  title="View" href="<?php echo e(URL::to('/license_view/'.$emp_leave->emp_id.'/'.$emp_leave->dri_license_id)); ?>"><i class="fa fa-eye"></i></a>&nbsp;
									<a class="btn btn-primary" title="Edit" href="<?php echo e(URL::to('/edit_license/'.$emp_leave->dri_license_id)); ?>"><i class="glyphicon glyphicon-pencil"></i></a>
									&nbsp; 
										<a class="btn btn-primary" onclick="return checkDelete();"  href="<?php echo e(URL::to('/delete_license/'.$emp_leave->emp_id.'/'.$emp_leave->dri_license_id)); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
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
			$("#MainGroupDriving_License").addClass('active');
			$("#Add_License").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>