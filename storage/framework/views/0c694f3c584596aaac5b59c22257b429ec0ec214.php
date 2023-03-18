
<?php $__env->startSection('title','Diary or Calendar'); ?>
<?php $__env->startSection('main_content'); ?>

<!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Requisition</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Requisition</a></li>
			<li class="active">Manage Requisition</li>
		</ol>
    </section>


    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Requisition </h3>
						<?php if($tot_value > 0){?> 
						
						<a href="<?php echo e(URL::to('/requisition_update')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Update</a>
						<?php }else{ ?>
							<a href="<?php echo e(URL::to('/requisition_create')); ?>" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add New</a>
						<?php } ?>
							
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
									<th>Diary</th>     
									<th>Calendar</th>     
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>No</th>
									<th>Emp ID</th> 
									<th>Employee Name</th>               
									 <th>Diary</th>     
									<th>Calendar</th>  
								</tr>
							</tfoot>
							<tbody>
							<?php 
								$j=1;
								foreach($emp_list as $v_result){ ?>
									<tr>
									<td><?php echo $j++;?></td>
									<td><?php echo $v_result->emp_id;?></td>  
									<td> 
									<?php 
											echo $v_result->emp_name; 
										 ?> 
									</td> 
									<td><?php echo $v_result->num_dairy;?></td> 
									<td><?php echo $v_result->num_calender;?></td> 									
									<!--<td><a class="btn btn-sm btn-success btn-xs" onclick="is_contract_check_edit('<?php //echo $v_result->id;?>','<?php //echo $v_result->emp_id;?>');"><i class="glyphicon glyphicon-pencil"></i> Edit</a></td> -->
									  
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
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script> 
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupRequisition").addClass('active');
			$("#Diary_or_Calendar").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>