<?php $__env->startSection('title', 'Department-Wise Staff Report'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
}
.table {
    margin-bottom: 6px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/department-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Department Name :</label>
							<select style="width:200px;" class="form-control" id="department_code" name="department_code" required >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($department->department_id); ?>"><?php echo e($department->department_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Type:</label>
							<select style="width:100px;" class="form-control" id="type_id" name="type_id" >
								<option value="1">HO</option>
								<option value="2">Branch</option>
								<option value="3">All</option>
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>
						<button type="submit" class="btn btn-primary" >Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<div class="row">
	<?php if(!empty($all_result)): ?>
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Department-Wise Staff List</font></b></p>		
			</div>
			<div class="col-md-12">					
					<?php 
						foreach ($all_department as $department) { 
							if($department_code == $department->department_id) {
								echo '<p><b>Department:' . $department->department_name;'</p>';
							}
						}
					
					?>					
					<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Joining Date (Org.)</th>
							<th rowspan="2">Last Degree</th>							
							<th colspan="2" style="text-align: center;">Present Work Station</th>
							<th rowspan="2">Grade</th>
							<th rowspan="2">Salary Branch</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<?php $i=1; $columns = array_column($all_result, 'designation_priority');
						array_multisort($columns, SORT_ASC, $all_result);
						foreach($all_result as $result) { ?>
					<tbody>
						<tr>
							<td><?php echo e($i++); ?></td>
							<?php if(!empty($result['increment_marked'])) { ?>
							<td style="background:#ED2225;color:#fff;"><?php echo $result['emp_id']; ?><br>(Redmarked)</td>
							<?php } else { ?>
							<td><?php echo $result['emp_id']; ?></td>
							<?php } ?>
							<?php if(!empty($result['promotion_marked'])) { ?>
							<td style="background:#FE9A2E;color:white;"><?php echo $result['emp_name_eng']; ?><br>(Yellowmarked)</td>
							<?php } else { ?>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<?php } ?>
							<?php if(!empty($result['permanent_marked'])) { ?>
							<td style="background:#008000;color:white;"><?php echo empty($result['asign_desig']) ? $result['designation_name'] : $result['asign_desig']; ?></td>
							<?php } else { ?>
							<td><?php echo empty($result['asign_desig']) ? $result['designation_name'] : $result['asign_desig']; ?></td>
							<?php } ?>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php echo e($result['exam_name']); ?></td>							
							<td><?php echo empty($result['asign_branch_name']) ? $result['branch_name'] : $result['asign_branch_name']; ?></td>
							<td><?php echo empty($result['asign_open_date']) ? $result['br_join_date'] : $result['asign_open_date']; ?></td>
							<td><?php echo e($result['grade_name']); ?></td>
							<td><?php echo e($result['salary_branch_name']); ?></td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
				<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
			</div>
		</div>
	<?php endif; ?>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("department_code").value="<?php echo e($department_code); ?>";
	var type = document.getElementById("type_id").value="<?php echo e($type_id); ?>";
});
</script>
<script type="text/javascript">
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-bordered th {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:2px;font: 11px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + 'table {' +
			'border-collapse: collapse;' +
			'width:100%;' +
			'}' + 'body {' +
			'margin-left: 10px;' +
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
		location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Department_wise_Report").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>