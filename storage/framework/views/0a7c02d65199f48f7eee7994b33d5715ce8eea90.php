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
					
					<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id;?>">
					<div class="form-group" >
						<label for="arrear_emp_id" class="col-sm-2 col-md-offset-1 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" autocomplete="off" class="form-control" id="arrear_emp_id" name="arrear_emp_id" value="<?php echo e($arrear_emp_id); ?>" onChange="get_employee_info();" required>
						</div>
					</div>
					<div class="form-group">	
						<label for="emp_name" class="col-sm-2 col-md-offset-1 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" readonly class="form-control" id="emp_name" value="<?php echo $emp_name;?>" required>						
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>  
					<div class="form-group">
						<label for="arrear_from" class="col-sm-2 col-md-offset-1 control-label">Arrear From<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control"   id="arrear_from" name="arrear_from" value="<?php echo $arrear_from;?>" required>							
						</div>
					</div>
					<div class="form-group">
						<label for="arrear_to" class="col-sm-2 col-md-offset-1 control-label">Arrear To<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control"  id="arrear_to" name="arrear_to" value="<?php echo $arrear_to;?>" required>							
						</div>
					</div>
					<div class="form-group">	
						<label for="arrear_pay_month" class="col-sm-2 col-md-offset-1 control-label">Pay Month <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control"   id="arrear_pay_month" name="arrear_pay_month" value="<?php echo $arrear_pay_month;?>" required>
						</div>
					</div>
					
					<?php if($allowance_head){ 
						foreach($allowance_head as $v_allowance_head){	?>
					<div class="form-group">
						<input type="hidden" class="form-control"  name="alowance_head_code[<?php echo $v_allowance_head->pay_head_code; ?>]" value="<?php echo $v_allowance_head->pay_head_code; ?>" >	
						<label for="pay_head_code<?php echo $v_allowance_head->pay_head_code; ?>" class="col-sm-2 col-md-offset-1 control-label"><?php 	echo $v_allowance_head->pay_head_name; ?>
						<span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="alowance_amount<?php echo $v_allowance_head->pay_head_code; ?>" name="alowance_amount[<?php echo $v_allowance_head->pay_head_code; ?>]" value="<?php if(!empty($array_allowance_amount)){  echo $array_allowance_amount[$v_allowance_head->pay_head_code]; }else echo 0; ?>" required>
						</div>
					</div>
					<?php 	}  } ?>
					<div class="form-group">	
						<label for="comments" class="col-sm-2 col-md-offset-1 control-label">Comments</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="comments" name="comments" value="<?php echo e($comments); ?>">
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
			url : "<?php echo e(url::to('get_emp_info_arr_alowance')); ?>"+"/"+ arrear_emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					//alert ('This ID is not available!'); 
					document.getElementById("emp_name").value = ''; 
					document.getElementById("arrear_from").value = ''; 
					document.getElementById("arrear_to").value = ''; 
					document.getElementById("arrear_pay_month").value=''; 
					document.getElementById("comments").value=''; 
				} else {
					document.getElementById("arrear_emp_id").value=data.arrear_emp_id;
					document.getElementById("emp_name").value=data.emp_name; 
					document.getElementById("arrear_from").value=''; 
					document.getElementById("arrear_to").value = ''; 
					document.getElementById("arrear_pay_month").value=''; 
					document.getElementById("comments").value=''; 
					
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
<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Arrear_Allawance").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>