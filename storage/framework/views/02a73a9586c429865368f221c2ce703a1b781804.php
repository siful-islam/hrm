
<?php $__env->startSection('title', 'Contractual Cancel'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Resignation</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> <?php echo e($Heading); ?></h3>
			</div>			
			<!-- /.box-header -->
			<!-- form start -->
			<form id="form" class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" method="<?php echo e($method); ?>" enctype="multipart/form-data">
				<?php echo e(csrf_field()); ?>	
				<?php echo $method_control; ?>					
				
				<input type="hidden" id="id" name="id" value="<?php echo e($id); ?>">
				<input type="hidden" name="br_code" value="<?php echo e($br_code); ?>" id="br_code"> 
				<input type="hidden" name="emp_id" value="<?php echo e($emp_id); ?>" id="emp_id">
				
				<div class="box-body col-md-9">
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Employee Type <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" name="emp_type" <?php if($mode == 'edit'){?> style="pointer-events:none;" <?php } ?> onChange="get_employee_info1()" id="emp_type"  required>
								<?php foreach($all_emp_type as $v_emp_type){?>
									<option value="<?php echo  $v_emp_type->id;?>"><?php echo  $v_emp_type->type_name;?></option>
								<?php } ?>  
							</select>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-3 <?php echo e($errors->has('emp_code') ? ' has-error' : ''); ?>">
							<input type="text" class="form-control" id="emp_code" <?php if($mode == 'edit'){?> readonly <?php } ?> name="emp_code" value="<?php echo e($emp_code); ?>" onChange="get_employee_info();" required>
							<?php if($errors->has('emp_code')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('emp_code')); ?></strong>
								</span>
							<?php endif; ?>
						</div> 
					</div>
					<hr>
					<div class="form-group">
						<label for="zone_code" class="col-sm-2 control-label">Cancel Date <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="date" class="form-control" id="cancel_date" name="cancel_date" value="<?php echo e($cancel_date); ?>" required>
						</div>
						<label for="zone_code" class="col-sm-2 control-label">Resigned By <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="cancel_by" name="cancel_by" required>						
								<option value="Self">Self</option>
								<option value="Ogranization">Ogranization</option>
								<option value="Termination">Termination</option>
								<option value="Project Close">Project Close</option>
								<option value="Did Not Join">Did Not Join</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="col-sm-3"> 
							<button type="submit" id="submit" class="btn btn-danger"><?php echo e($button_text); ?></button>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					 <!-- Profile Image -->
					<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" id="emp_photo" src="<?php echo e(asset('public/employee/default.png')); ?>" alt="User profile picture">
						<h3 class="profile-username text-center" id="emp_name" ><?php echo e($emp_name); ?></h3>
						<p class="text-muted text-center" id="designation_name"></p>
						<ul class="list-group list-group-unbordered"> 
						<li class="list-group-item">
							<b>Org Joining Date : </b><span id="joining_date"><?php if(!empty($joining_date)) { echo date("d-m-Y",strtotime($joining_date));} ?></span>
						</li>
						<li class="list-group-item">
							<b>Present Working Station : </b><span id="branch_name"><?php echo e($branch_name); ?></span>
						</li>
						</ul>
						<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>Employee Status</b></a>
					</div>
					<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<div class="box-footer">

				</div>
				<!-- /.box-footer -->
			</form>
			
		</div>
	</section>
	
	<script>
	function get_employee_info1(){
		document.getElementById("emp_code").value = '';
	}
		$(document).ready(function() {
			var button_text = document.getElementById("submit").innerHTML;
			if(button_text == 'Save')
			{
				$('#emp_id').removeAttr('disabled');
				$('#submit').attr("disabled", true);
			}
			else
			{
				$('#emp_id').attr("disabled", true);
				$('#submit').removeAttr('disabled');
			}
			document.getElementById("branch_name").innerHTML = '<?php echo e($branch_name); ?>';
			document.getElementById("emp_type").value = '<?php echo e($emp_type); ?>';
			document.getElementById("cancel_by").value = '<?php echo e($cancel_by); ?>';
		})
		
		function get_employee_info()
		{
			var emp_code = document.getElementById("emp_code").value;
			var emp_type = document.getElementById("emp_type").value;
			/* if(emp_type == 'non_id'){
				var emp_type1 = 1;
			}else if(emp_type == 'sacmo'){
				var emp_type1 = 2;
			}else if(emp_type == 'shs'){
				var emp_type1 = 3;
			} */
			//alert(emp_type);
			//return;
			 $.ajax({ 
				url : "<?php echo e(URL::to('get-nonid-info')); ?>"+"/"+ emp_code +"/"+emp_type,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{		 
					//alert(data.emp_id);
					//console.log(data);
					//return;
					if(data.emp_name !='' && data.cancel_date == '')
					{										
						$('#br_code').val(data.br_code);
						$('#emp_id').val(data.emp_id);						
						$('#emp_name').html(data.emp_name);
						$('#branch_name').html(data.branch_name);
						$('#joining_date').html(data.joining_date);
						
						$('#employee_status').html('Active Employee');
						$('#submit').attr("disabled", false);
					}
					else if(data.emp_name !='' && data.cancel_date != '')
					{
						$('#br_code').val('');
						$('#emp_id').val('');
						$('#emp_name').html('');
						$('#branch_name').html('');
						$('#employee_status').html('Employee is cancelled');
						$('#submit').attr("disabled", true);
					}
					else
					{
						$('#br_code').val('');
						$('#emp_id').val('');
						$('#emp_name').html('');
						$('#branch_name').html('');
						$('#joining_date').html('');
						$('#employee_status').html('Employee is not Available');
						$('#submit').attr("disabled", true);
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#br_code').val('');
					$('#emp_id').val('');
					$('#emp_name').html('');
					$('#branch_name').html('');
					$('#joining_date').html('');
					$('#employee_status').html('Employee is not Available');
					$('#submit').attr("disabled", true);
				}
			});
		}

	</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupContractual").addClass('active');
			//$("#Transfer_(Contractual)").addClass('active');
			$('#Cancel').addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>