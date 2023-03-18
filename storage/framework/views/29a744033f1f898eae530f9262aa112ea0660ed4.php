
<?php $__env->startSection('title', 'Basic Salary Wise Report'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
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
					<form class="form-inline report" action="<?php echo e(URL::to('/basic-salary-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
						  <label for="pwd">Basic Salary:</label>
						  <input type="text" class="form-control" name="basic_salary"  value="<?php echo e($basic_salary); ?>" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>						
						<button type="submit" class="btn btn-primary">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
			<p><b>Basic Salary: <?php echo $basic_salary; ?></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Basic Effect Date</th>
							<th rowspan="2">Last Degree</th>
							<th rowspan="2">Joining Date(Org.)</th>
							<th colspan="2">Present Work Station</th>
							<th rowspan="2">Grade</th>
							<th rowspan="2">Basic (Tk)</th>
							<th rowspan="2">Total Pay(Tk)</th>
							<th rowspan="2">Net Pay(Tk)</th>
						</tr>
						<tr>
							<th>HO/BO Name</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php 
							$basic_percent = (($result['basic_salary']*21)/100);
							if(empty($result['total_pay'])) {
								$total_pay = $result['total_plus'];
							} else {
								$total_pay = $result['total_pay'];
							}
							$nit_pay = $total_pay - $basic_percent;
							if ($nit_pay == $result['net_pay']) {
								$net_pay = $result['net_pay'];
							} else {
								$net_pay = $nit_pay;
							}
						?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>
							<td><?php echo e($result['emp_id']); ?></td>
							<td><?php echo e($result['designation_name']); ?></td>
							<td><?php echo e($result['effect_date']); ?></td>
							<td><?php echo e($result['exam_name']); ?></td>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php echo e($result['branch_name']); ?></td>
							<td><?php echo e($result['br_join_date']); ?></td>
							<td><?php echo e($result['grade_name']); ?></td>
							<td><?php echo e($result['basic_salary']); ?></td>
							<td><?php echo empty($result['total_pay']) ? $result['total_plus'] : $result['total_pay'];?></td>
							<td><?php echo e(round($net_pay)); ?></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script language="javascript" type="text/javascript">
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
		$("#Basic_Salary_Wise_Report").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>