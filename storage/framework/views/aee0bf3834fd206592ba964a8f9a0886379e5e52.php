<?php $__env->startSection('title', 'Transfer Staff Report'); ?>
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
</style><br/>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/transfer-report')); ?>" method="post">
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
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Transfer Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Letter date</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<!--<th>Workstation(old)</th>-->
							<th>Workstation(old) Duration</th>
							<th>Workstation(new)</th>
							<th>Br. Joining Date</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						//$counts = array_count_values($all_result);

						/* $all_databse_id1 = array_map('current',$all_result);							
						$counts = array_count_values($all_databse_id1);	 
						$emp_id1 = ''; */
						foreach($all_result as $result) {
							//echo $counts[$result['emp_id']];
							
							/* if($counts[$result['emp_id']] == 1) {
								$next_day = $to_date;								
							} else {
								if($emp_id1 != $result['emp_id']) {
									$next_day = $to_date;
								} else {
									$next_day = $br_join_date1;
								}
							} */
							$big_date=date_create($result['old_br_join_date']);
							$small_date=date_create($result['br_join_date']);
							$diff=date_diff($big_date,$small_date);
						?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $result['emp_id']; ?></td>
							<td><?php echo date('d M Y',strtotime($result['letter_date'])); ?></td>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<td><?php echo $result['designation_name']; ?></td>
							<td><?php echo $diff->format('%y Year %m Month %d Day'); ?></td>
							<td><?php echo $result['branch_name']; ?></td>
							<td><?php echo date('d M Y',strtotime($result['br_join_date'])); ?></td>
							<td><?php echo $result['comments']; ?></td>
						</tr>
						<?php //$emp_id1 = $result['emp_id'];
							  //$br_join_date1 = $result['br_join_date'];
						} ?>
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
		$("#Transfer_Staff").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>