<?php $__env->startSection('title', 'Probation Staff Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/probation-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
						  <label for="pwd">Date From:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Date To:</label>
						  <input type="text" id="to_date" class="form-control" name="to_date" size="10" value="<?php echo e($to_date); ?>" required>
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
				<b><font size="4">Probation Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<?php $total_record = 1; foreach ($all_designation as $designation) {
				$i=1; foreach($all_result as $result) { 
				if($result['designation_code'] == $designation->designation_code) { 
				if($i==1) { ?>
				<p><b>Designation Name: </b><?php echo $designation->designation_name; ?></p>
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">Last Degree</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Probation Time</th>
							<th rowspan="2">Joining Date (Org.)</th>
							<th rowspan="2">Letter Date</th>
							<th colspan="2">Present Work Station</th>
							<th rowspan="2">Permanent Address</th>
						</tr>
						<tr>
							<th>HO/BO Name</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<?php } ?>
					<tbody>
						<tr>
							<td><?php echo e($i); ?></td>
							<td><?php echo e($result['emp_id']); ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>
							<td><?php echo e($result['exam_name']); ?></td>
							<td><?php echo e($result['designation_name']); ?></td>
							<td><?php echo e($result['probation_time'] . ' Months'); ?></td>
							<td><?php echo date('d M Y',strtotime($result['org_join_date'])); ?></td>
							<td><?php echo date('d M Y',strtotime($result['letter_date'])); ?></td>
							<td><?php echo e($result['branch_name']); ?></td>
							<td><?php echo date('d M Y',strtotime($result['br_join_date'])); ?></td>
							<td><?php echo e($result['permanent_add']); ?></td>
						</tr>
						<?php $i++; } ?>  
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
		</div>
		<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
	<?php endif; ?>
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
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
		$("#MainGroupTransaction_Reports").addClass('active');
		$("#Probation_Staff").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>