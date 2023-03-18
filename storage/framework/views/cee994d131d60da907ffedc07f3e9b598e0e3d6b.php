<?php $__env->startSection('title', 'Payroll Task'); ?>
<?php $__env->startSection('main_content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
    </section> 
    <!-- Main content -->
    <section class="content">
		<!-- Small boxes (Stat box) -->
		<?php 
		$admin_access_label 			= Session::get('admin_access_label');  
		?>  
		<!-- TO DO List -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Payroll Task</h3>
						<button type="button" onclick="add_task();" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Clearance</button>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Task Month</th>      
									<th>Action Date</th>      
									<th>Action By</th>      
									<th>HR Status</th>      
									<th>Finance</th>      
									<th>IT</th>      
								</tr>
							</thead>
							<tbody> 
								<?php 
								$j=1;
								foreach($all_task as $v_all_task){ 							
								$hr_tasks_status = explode(",",$v_all_task->hr_tasks_status);
								if(in_array(0, $hr_tasks_status))
								{
									$status = "Task Pending..";
									$color = "red";
								}
								else
								{
									$status = "Complete";
									$color = "green";
								}
								if($v_all_task->finance_tasks_status !='')
								{
									$finance_tasks_status = explode(",",$v_all_task->finance_tasks_status);
									if(in_array(0, $finance_tasks_status))
									{
										$fin_status = "Task Pending..";
										$f_color = "red";
									}
									else
									{
										$fin_status = "Complete";
										$f_color = "green";
									}
								}else{
									$fin_status = '-';
									$f_color 		= "red";
								}
								if($v_all_task->it_tasks_status !='')
								{
									$it_tasks_status = explode(",",$v_all_task->it_tasks_status);
									if(in_array(0, $it_tasks_status))
									{
										$it_status 	= "Task Pending..";
										$it_color 		= "red";
									}
									else
									{
										$it_status 	= "Complete";
										$it_color 		= "green";
									}
								}else{
									$it_status 	= '-';
									$it_color 		= "red";
								}
								?>
								<tr>
									<td align="centre"><?php echo e($j++); ?></td>
									<td align="centre"><?php echo date("Y-M", strtotime($v_all_task->tsk_month));  ?></td>    
									<td align="centre"><?php echo e($v_all_task->hr_action_date); ?></td>  
									<td align="centre"><?php echo $v_all_task->hr_assign_employee_name.' ( '.$v_all_task->hr_action_by.')'; ?></td>  
									<td align="centre" style="color:<?php echo $color; ?>"><?php echo $status;?></td>  
									<td align="centre" style="color:<?php echo $f_color; ?>"><?php echo $fin_status;?></td>  
									<td align="centre" style="color:<?php echo $it_color; ?>"><?php echo $it_status;?></td>  
								</tr>
								<?php } ?>
							</tbody>        
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
        <!-- /.box -->	
		<script>
		function add_task()
		{
			save_method = 'add';
			document.getElementById("post_method").innerHTML = "";
			$('#new_form')[0].reset(); // reset form on modals
			$('.form-group').removeClass('has-error'); // clear error class
			$('.help-block').empty(); // clear error string
			$('#modal_task').modal('show'); // show bootstrap modal
			$('.modal-title').text('Add: Clearance date upto '+'<?php echo date("Y-m-t")?>'); // Set Title to Bootstrap modal title*/
		}
		
		/*
		$(document).ready(function() { 
			save_method = 'add';
			document.getElementById("post_method").innerHTML = "";
			$('#new_form')[0].reset(); // reset form on modals
			$('.form-group').removeClass('has-error'); // clear error class
			$('.help-block').empty(); // clear error string
			$('#modal_task').modal('show'); // show bootstrap modal
			$('.modal-title').text('Add: Clearance'); // Set Title to Bootstrap modal title
		});
		*/
		</script>	
		 
	    <div class="modal fade" id="modal_task">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"></h4>
					</div>					
					<form action="<?php echo e(URL::to('/save_task_hr')); ?>" method="post" class="form-horizontal" role="form" method="POST" id="new_form">
						<div class="modal-body">
							<?php echo e(csrf_field()); ?>

							<span id="post_method"></span>	 						
							<input type="hidden" class="form-control" value="<?php echo e($assign_employee); ?>" name="hr_action_by" id="hr_action_by">
							<input type="hidden" class="form-control" value="<?php echo e($assign_employee_name); ?>" name="hr_assign_employee_name" id="hr_assign_employee_name">
							<input type="hidden" class="form-control" name="month" id="month" value="<?php echo e($month); ?>">
							<input type="hidden" class="form-control" name="year" id="year" value="<?php echo e($year); ?>">
							<div class="form-group">
								<!--<div class="form-group">
									<label class="control-label col-md-2">Month :</label>
									<div class="col-md-3">
										<select name="month" id="month" class="form-control">
											<option value="01" <?php //if($month =='01') { echo 'selected';}?>>January</option>
											<option value="02" <?php //if($month =='02') { echo 'selected';}?>>February</option>
											<option value="03" <?php //if($month =='03') { echo 'selected';}?>>March</option>
											<option value="04" <?php //if($month =='04') { echo 'selected';}?>>April</option>
											<option value="05" <?php //if($month =='05') { echo 'selected';}?>>May</option>
											<option value="06" <?php //if($month =='06') { echo 'selected';}?>>June</option>
											<option value="07" <?php //if($month =='07') { echo 'selected';}?>>July</option>
											<option value="08" <?php //if($month =='08') { echo 'selected';}?>>August</option>
											<option value="09" <?php //if($month =='09') { echo 'selected';}?>>September</option>
											<option value="10" <?php //if($month =='10') { echo 'selected';}?>>October</option>
											<option value="11" <?php //if($month =='11') { echo 'selected';}?>>November</option>
											<option value="12" <?php //if($month =='12') { echo 'selected';}?>>December</option>
										</select>
										<span class="help-block"></span>
									</div>
									<div class="col-md-2">
										<select name="year" id="year" class="form-control">
											<option value="2021">2021</option>
										<select>
										<span class="help-block"></span>
									</div> 
								</div>-->
								<?php $i = 1; $a = 0; 
								if($infos)
								{
									$hr_tasks_statuss = explode(",",$infos->hr_tasks_status); 
								}else{
									$hr_tasks_statuss = array(); 
								}
								foreach($tasks as $task) { ?>
								<input type="hidden" class="form-control" value="<?php echo $task->task_id ; ?>" name="tasks[]" id="tasks_<?php echo $i;?>">
								<div class="form-group">
									<label class="control-label col-md-3">Task : <small id="label<?php echo $i; ?>" class="label label-danger"><?php echo $i; ?></small></label>
									<div class="col-md-6">
										<input type="text" name="task_name[]" value="<?php echo $task->task_name; ?>" readonly class="form-control">
										<span class="help-block"></span>
									</div>
									<div class="col-md-2">
										<input type="checkbox" name="actions[]" id="actions<?php echo $i; ?>"  value="<?php echo $task->task_name; ?>" onclick="set_label('<?php echo $i ?>');" <?php if($hr_tasks_statuss && @$hr_tasks_statuss[$a]) { echo 'checked'; } ?>>
									</div>
								</div>
								<?php $i++; $a++; } ?>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<?php //if(Session::get('emp_id') == $assign_employee) { ?>
							<button type="submit" class="btn btn-primary"> Confirm </button>
							<?php //} ?>
						</div>
					</form>
				</div>
			</div>
        </div> 
    </section>
    <!-- /.content -->
	<script>
		
			function set_label(id)
			{
				var ids 		= 'label'+id;
				var actionsis 	= 'actions'+id;
				if(document.getElementById(actionsis).checked) {
					document.getElementById(ids).className = "label label-success";
					 
				}else{
					document.getElementById(ids).className = "label label-danger";
					 
				}
			}
		</script>	 
		 
	<script>
		//To active dashboard menu.......//
		$(document).ready(function() {
			$("#dashboard").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>	
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>