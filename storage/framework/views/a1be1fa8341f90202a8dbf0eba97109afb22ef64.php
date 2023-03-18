
<?php $__env->startSection('title', 'Arrear Setup'); ?>
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
	<h1>add-arrear-setup</h1>
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
						<label for="arrear_emp_id" class="col-sm-2 col-md-offset-1 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" id="arrear_emp_id" name="arrear_emp_id" value="<?php echo e($arrear_emp_id); ?>" onChange="get_employee_info();" required>
						</div>
					</div>
					<div class="form-group">	
						<label for="emp_name" class="col-sm-2 col-md-offset-1 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" name="emp_name" id="emp_name" value="<?php echo e($emp_name); ?>" required>						
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>  
					<div class="form-group">
						<label for="arrear_effect_date_from" class="col-sm-2 col-md-offset-1 control-label">From <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" onChange="set_date_range_from()" id="arrear_effect_date_from" name="arrear_effect_date_from" value="<?php echo e($arrear_effect_date_from); ?>" required>							
						</div>
					</div>
					<div class="form-group">	
						<label for="arrear_effect_date_to" class="col-sm-2 col-md-offset-1 control-label">To <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" onChange="set_date_range()" id="arrear_effect_date_to" name="arrear_effect_date_to" value="<?php echo e($arrear_effect_date_to); ?>" required>
						</div>
					</div>
					<div class="form-group">		
						<label for="arrear_days" class="col-sm-2 col-md-offset-1 control-label">Days<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="arrear_days" name="arrear_days" value="<?php echo e($arrear_days); ?>" required>
							 
						</div>
					</div>	
					<div class="form-group">		
						<label for="arrear_amount" class="col-sm-2 col-md-offset-1 control-label">Arrear Amount<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" id="arrear_amount" name="arrear_amount" value="<?php echo e($arrear_amount); ?>" required >
							 
						</div>
					</div> 
					<div class="form-group">	
						<label for="comments" class="col-sm-2 col-md-offset-1 control-label">Comments</label>
						<div class="col-sm-3">
							<textarea class="form-control" id="comments" name="comments" value=""><?php echo e($comments); ?></textarea>
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo e(URL::to('/arrear_setup')); ?>" class="btn bg-olive" >List</a>
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
		var arrear_emp_id = $("#arrear_emp_id").val();	
		//alert (arrear_emp_id);
		$.ajax({
			url : "<?php echo e(url::to('get_emp_info_arr')); ?>"+"/"+ arrear_emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					//alert ('This ID is not available!'); 
					document.getElementById("emp_name").value = ''; 
					document.getElementById("basic_salary").value = ''; 
					document.getElementById("arrear_basic").value=''; 
					document.getElementById("arrear_basic_amount").value=''; 
				} else {
					document.getElementById("arrear_emp_id").value=data.arrear_emp_id;
					document.getElementById("emp_name").value=data.emp_name; 
					document.getElementById("basic_salary").value=data.basic_salary; 
					document.getElementById("arrear_basic").value=''; 
					document.getElementById("arrear_basic_amount").value=''; 
					
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
		var arrear_effect_date_from = document.getElementById('arrear_effect_date_from').value;
		var arrear_effect_date_to = document.getElementById('arrear_effect_date_to').value;
		var start = new Date(arrear_effect_date_from);
		var end = new Date(arrear_effect_date_to);
		var days = (end - start) / 1000 / 60 / 60 / 24;
		
		document.getElementById('arrear_days').value = days + 1;
		document.getElementById("arrear_basic").value = '';
		document.getElementById("arrear_basic_amount").value = '';
		//alert(days + 1);
	}
function set_date_range_from() {
		//$('#btnSave').attr('disabled', false);
		var arrear_effect_date_from = document.getElementById('arrear_effect_date_from').value;
		document.getElementById('arrear_days').value = 1;
		document.getElementById("arrear_effect_date_to").value = arrear_effect_date_from;
		document.getElementById("arrear_effect_date_to").min = arrear_effect_date_from;
		document.getElementById("arrear_basic").value = '';
		document.getElementById("arrear_basic_amount").value = '';
		//alert(arrear_effect_date_from);
	} 
</script>
<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Arrear").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>