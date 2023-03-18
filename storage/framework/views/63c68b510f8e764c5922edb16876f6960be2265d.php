
<?php $__env->startSection('title', 'Susupension'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 14px;
}
.col-sm-2, .col-sm-1 {
	padding-left: 6px;
}
</style>
<meta name="csrf-token" content="<?php echo csrf_token() ?>">
<section class="content-header">
	<h1>Suspension</h1>
</section>
<section class="content">	
	<div class="row">			
		<!-- form start -->
		<!--<h3 style="color:green">
			<?php if(Session::has('message')): ?>
			<?php echo e(session('message')); ?>

			<?php endif; ?>
		</h3>-->
		<div class="col-md-12">
			<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>" enctype="multipart/form-data">
			<?php echo e(csrf_field()); ?>

			<?php echo $method_field; ?>

			<div class="box box-info">
				<div class="box-body">	
					
					<input type="hidden" class="form-control" id="basic_salary" value="">
					<div class="form-group" >
						<label for="emp_id" class="col-sm-2 col-md-offset-1 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>" onChange="get_employee_info();" required>
						</div>
					</div>
					<div class="form-group">	
						<label for="emp_name" class="col-sm-2 col-md-offset-1 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="emp_name" value="<?php echo e($emp_name); ?>" required>						
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>  
					<div class="form-group">
						<label for="from_date" class="col-sm-2 col-md-offset-1 control-label">From <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" onChange="set_date_range_from()" id="from_date" name="from_date" value="<?php echo e($from_date); ?>" required>							
						</div>
					</div>
					<div class="form-group">	
						<label for="to_date" class="col-sm-2 col-md-offset-1 control-label">To <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" onChange="set_date_range()" id="to_date" name="to_date" value="<?php echo e($to_date); ?>" required>
						</div>
					</div>
					<div class="form-group">		
						<label for="total_days" class="col-sm-2 col-md-offset-1 control-label">Days<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="total_days" name="total_days" value="<?php echo e($total_days); ?>" required>
							 
						</div>
					</div> 
					<div class="form-group">	
						<label for="comments" class="col-sm-2 col-md-offset-1 control-label">Comments</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="comments" name="comments" value="<?php echo e($comments); ?>">
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo e(URL::to('/suspension')); ?>" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary"><?php echo e($button_text); ?></button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
</section> 
<script type="text/javascript">		
	function get_employee_info() {
		var emp_id = $("#emp_id").val();	
		//alert (emp_id);
		$.ajax({
			url : "<?php echo e(url::to('get_emp_info_sus')); ?>"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				console.log(data);
				if(data.error==1) {
					//alert ('This ID is not available!'); 
					document.getElementById("emp_name").value = ''; 
					document.getElementById("basic_salary").value = '';   
				} else {
					document.getElementById("emp_id").value=data.emp_id;
					document.getElementById("emp_name").value=data.emp_name; 
					document.getElementById("basic_salary").value=data.basic_salary;   
					
				}
				//alert (data.br_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});
	}	
</script>
<script type="text/javascript">
 function set_date_range() {
		//$('#btnSave').attr('disabled', false);
		var from_date = document.getElementById('from_date').value;
		var to_date = document.getElementById('to_date').value;
		var start = new Date(from_date);
		var end = new Date(to_date);
		var days = (end - start) / 1000 / 60 / 60 / 24;
		
		document.getElementById('total_days').value = days + 1;  
		//alert(days + 1);
	}
function set_date_range_from() {
		//$('#btnSave').attr('disabled', false);
		var from_date = document.getElementById('from_date').value;
		document.getElementById('total_days').value = 1;
		document.getElementById("to_date").value = from_date;
		document.getElementById("to_date").min = from_date;  
		//alert(from_date);
	}
 
</script>
<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Suspension").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>