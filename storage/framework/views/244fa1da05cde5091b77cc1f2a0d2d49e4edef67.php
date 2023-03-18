<?php $__env->startSection('title', 'Employee Assign'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 14px;
}
</style>
<section class="content-header">
	<h1>add-assign</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">add-assign</li>
	</ol>
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

			<input type="hidden" id="branch_code" name="branch_code" >
			<div class="box box-info">
				<div class="box-body">							
					<div class="form-group">
						<label for="open_date" class="col-sm-2 control-label">Effect Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="letter_date" name="open_date" value="<?php echo e($open_date); ?>" required>							
						</div>
						<label for="emp_id" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3 <?php echo e($errors->has('emp_id') ? ' has-error' : ''); ?>">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>" onChange="get_employee_info(this.value);" required>
							<?php if($errors->has('emp_id')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('emp_id')); ?></strong>
								</span>
							<?php endif; ?>
						</div>							
					</div>
					<hr>
					<div class="form-group">
						<label for="select_type" class="col-sm-2 control-label">Select Type <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="select_type" name="select_type" onchange="myFunction();" required>						
								<option value="">-Select-</option>
								<option value="1" <?php if($select_type==1) echo 'selected'; ?> >Employee Assign</option>
								<option value="2" <?php if($select_type==2) echo 'selected'; ?> >Work Station Change</option>
								<option value="3" <?php if($select_type==3) echo 'selected'; ?> >Letter of Council</option>
								<option value="4" <?php if($select_type==4) echo 'selected'; ?> >Report to HO</option>
								<option value="5" <?php if($select_type==5) echo 'selected'; ?> >Designation Change</option>
								<option value="6" <?php if($select_type==6) echo 'selected'; ?> >Final Deadline</option>
							</select>
						</div>
						<label for="emp_name" class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="emp_name" value="<?php echo e($emp_name); ?>" required>							
						</div>
					</div>
					<div class="form-group">
						<label for="designation_code" class="col-sm-2 control-label">Designation <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="designation_code" name="designation_code" required>						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($designation->designation_code); ?>"><?php echo e($designation->designation_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div id="branch" style="display: none;">
						<label for="br_code" class="col-sm-2 control-label">Branch <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="br_code" name="br_code" onchange="set_salary_br();">						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						</div>
					</div>
					<div class="form-group">		
						<label for="incharge_as" id="label_text" class="col-sm-2 control-label">Incharge As <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="incharge_as" name="incharge_as" value="<?php echo e($incharge_as); ?>" required>
						</div>
						<div id="salary_branch" style="display: none;">
						<label for="salary_br_code" class="col-sm-2 control-label">Salary Branch <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="salary_br_code" name="salary_br_code" >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo e(URL::to('/emp-assign')); ?>" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary"><?php echo e($button_text); ?></button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
			<?php if(!empty($id)){ ?>
			<form class="form-horizontal" action="<?php echo e(URL::to('/emp-assign-close')); ?>" method="post" >
			<?php echo e(csrf_field()); ?>

			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">		
						<label for="close_date" id="label_text" class="col-sm-2 control-label"><span style="color:red;">Close Date</span> </label>
						<div class="col-sm-2">
							<input type="hidden" name="assign_id" value="<?php echo $id; ?>" />
							<input type="hidden" name="designation_code" value="<?php echo $designation_code; ?>" />
							<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>" />
							<input type="text" name="close_date" id="close_date" class="form-control" value="<?php echo e($close_date); ?>" />
						</div>
						<div class="col-sm-2">
							<button type="submit" id="submit" class="btn btn-primary">Closed</button>
						</div>
					</div>						
				</div>
			</div>
			</form>
			<?php } ?>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#letter_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#close_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	var aa = $('#select_type').val();	
	if (aa == '2') {
		$("#branch").show();
		$("#salary_branch").show();
	} else {
		$("#branch").hide();
		$("#salary_branch").hide();
		document.getElementById("br_code").value='';
		document.getElementById("salary_br_code").value='';
	}
    $('#select_type').on('change', function() {
      if (this.value == '2') {
		$("#branch").show();
		$("#salary_branch").show();
      } else {
		$("#branch").hide();
		$("#salary_branch").hide();
		document.getElementById("br_code").value='';
		document.getElementById("salary_br_code").value='';
      }
    });
	
	document.getElementById("designation_code").value="<?php echo e($designation_code); ?>";
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
	document.getElementById("branch_code").value="<?php echo e($br_code); ?>";
	document.getElementById("salary_br_code").value="<?php echo e($salary_br_code); ?>";
	
	if (aa == '1') {
		document.getElementById("label_text").innerHTML = "Incharge As <span class='required'>*</span>";
	} else if (aa == '2') {
		document.getElementById("label_text").innerHTML = "Workstation Change <span class='required'>*</span>";
	} else if (aa == '3') {
		document.getElementById("label_text").innerHTML = "Letter of Council <span class='required'>*</span>";
	} else if (aa == '4') {
		document.getElementById("label_text").innerHTML = "Description <span class='required'>*</span>";
	} else if (aa == '6') {
		document.getElementById("label_text").innerHTML = "Reason <span class='required'>*</span>";
	}
});
//--></script>
<script type="text/javascript">	
	function myFunction() { 
		var selecttype = document.getElementById("select_type").value;

		if (selecttype == '1') {
			document.getElementById("label_text").innerHTML = "Incharge As <span class='required'>*</span>";
			$("#branch").hide();
			$("#salary_branch").hide();
			$('#br_code').removeAttr("required");
			$('#salary_br_code').removeAttr("required");
		} else if (selecttype == '2') {
			document.getElementById("label_text").innerHTML = "Workstation Change <span class='required'>*</span>";
			$("#branch").show();
			$("#salary_branch").show();
			$('#br_code').attr('required', 'required');
			$('#salary_br_code').attr('required', 'required');
		} else if (selecttype == '3') {
			document.getElementById("label_text").innerHTML = "Letter of Council <span class='required'>*</span>";
			$("#branch").hide();
			$("#salary_branch").hide();
			$('#br_code').removeAttr("required");
			$('#salary_br_code').removeAttr("required");
		} else if (selecttype == '4') {
			document.getElementById("label_text").innerHTML = "Description <span class='required'>*</span>";
			$("#branch").hide();
			$("#salary_branch").hide();
			$('#br_code').removeAttr("required");
			$('#salary_br_code').removeAttr("required");
		} else if (selecttype == '6') {
			document.getElementById("label_text").innerHTML = "Reason <span class='required'>*</span>";
			$("#branch").hide();
			$("#salary_branch").hide();
			$('#br_code').removeAttr("required");
			$('#salary_br_code').removeAttr("required");
		}
		
	}
	
	function get_employee_info(emp_id) {
		//alert (emp_id);	
		$.ajax({
			url : "<?php echo e(url::to('get-employee-info-training')); ?>"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
				} else {
					document.getElementById("emp_name").value=data.emp_name;
					document.getElementById("branch_code").value=data.br_code;
					document.getElementById("designation_code").value=data.designation_code;
				}
				//alert (data.designation_code);		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//alert('Error: To Get Info');
			}
		});
	}
	
	function set_salary_br() {
		var br_code = document.getElementById("br_code").value;
		document.getElementById("salary_br_code").value = br_code;
	}
	
</script>
<script>
	//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Employee_Assign").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>