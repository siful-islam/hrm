
<?php $__env->startSection('title', 'Extra Deduction'); ?>
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
<section class="content-header">
	<h1>add-extra-deduction</h1>
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
					<div class="form-group">
						<label for="emp_id" class="col-sm-2 control-label">Employee ID <span class="required">*</span></label>
						<div class="col-sm-2 <?php echo e($errors->has('emp_id') ? ' has-error' : ''); ?>">
							<input type="number" class="form-control" id="emp_id" name="emp_id" value="<?php echo e($emp_id); ?>" onChange="get_employee_info();" required>
							<?php if($errors->has('emp_id')): ?>
								<span class="help-block">
									<strong><?php echo e($errors->first('emp_id')); ?></strong>
								</span>
							<?php endif; ?>
						</div>
						<label for="entry_date" class="col-sm-2 control-label">Entry Date <span class="required">*</span></label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="entry_date" name="entry_date" value="<?php echo e($entry_date); ?>" onChange="get_employee_info();" required>
						</div>
						<!--<button type="submit" class="btn btn-primary" >Search</button>-->
					</div>
					<hr>
					<div class="form-group">
						<label for="emp_name" class="col-sm-2 control-label">Employee Name <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="emp_name" value="<?php echo e($emp_name); ?>" required>						
						</div>
						<label for="designation_code" class="col-sm-2 control-label">Designation <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="designation_code" name="designation_code" required>						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($designation->designation_code); ?>"><?php echo e($designation->designation_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="type_id" class="col-sm-2 control-label">Select Type <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="type_id" name="type_id" required>						
								<option value="">-Select-</option>
								<?php $__currentLoopData = $all_deduc_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduc_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($deduc_type->id); ?>"><?php echo e($deduc_type->type_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<label for="br_code" class="col-sm-2 control-label">Branch <span class="required">*</span></label>
						<div class="col-sm-3">
							<select class="form-control" id="br_code" name="br_code" >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="total_amount" class="col-sm-2 control-label">Total Amount <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="total_amount" name="total_amount" value="<?php echo e($total_amount); ?>" required>							
						</div>
						<label for="month_year" class="col-sm-2 control-label">From-Month <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control month_year" id="month_year" value="<?php echo e($from_month_year); ?>" required>
						</div>
					</div>
					<div class="form-group">		
						<label for="month_year" class="col-sm-2 control-label">To-Month <span class="required">*</span></label>
						<div class="col-sm-3">
							<input type="text" class="form-control month_year" id="to_month" value="<?php echo e($to_month_year); ?>" required>
							<input type="hidden" class="form-control" name="search_dates" id="search_dates">
						</div>
						<label for="comments" class="col-sm-2 control-label">Comments <span class="required">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="comments" name="comments" value="<?php echo e($comments); ?>" required>
						</div>
					</div>						
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<a href="<?php echo e(URL::to('/extra_deduction')); ?>" class="btn bg-olive" >List</a>
					<button type="submit" id="submit" class="btn btn-primary" onclick="dateRange();"><?php echo e($button_text); ?></button>
				</div>
			   <!-- /.box-footer -->
			</div>
			</form>
		</div>					
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.month_year').datepicker({dateFormat: 'yy-mm'});
	$('#entry_date').datepicker({dateFormat: 'yy-mm-dd'});
	
	document.getElementById("designation_code").value="<?php echo e($designation_code); ?>";
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
	document.getElementById("type_id").value="<?php echo e($type_id); ?>";
});
//--></script>
<script type="text/javascript">		
	function get_employee_info() {
		var emp_id = $("#emp_id").val();	
		//alert (emp_id);
		$.ajax({
			url : "<?php echo e(url::to('get-emp-info')); ?>"+"/"+ emp_id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				if(data.error==1) {
					alert ('This ID is not available!');
				} else {
					document.getElementById("emp_id").value=data.emp_id;
					document.getElementById("emp_name").value=data.emp_name;
					document.getElementById("br_code").value=data.br_code;
					document.getElementById("designation_code").value=data.designation_code;
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
function dateRange() {
  //alert (1);
  var startDate = $("#month_year").val();
  var endDate = $("#to_month").val();
  var start      = startDate.split('-');
  var end        = endDate.split('-');
  var startYear  = parseInt(start[0]);
  var endYear    = parseInt(end[0]);
  var dates      = [];
//alert (endYear)
  for(var i = startYear; i <= endYear; i++) {
   
    var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
    var startMon = i === startYear ? parseInt(start[1])-1 : 0;
    //alert (startMon);
	for(var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
      var month = j+1;
      var displayMonth = month < 10 ? '0'+month : month;
      dates.push([i, displayMonth, '01'].join('-'));
    }
  }
  //return dates;
  document.getElementById("search_dates").value=dates;
}
</script>
<script>
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Extra_Deduction").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>