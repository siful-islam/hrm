<?php $__env->startSection('title', 'PMS Staff Status'); ?>
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
<!------export to excel file------->	
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.table2excel.js')); ?>"></script>
<!------export to excel file------->
<!-- Content Header (Page header) -->
<br/>
<br/>
<section class="content-header">
	<!--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">All Staff List</li>
	</ol>-->
</section>
<section class="content">
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">PMS Staff Status</font></b></p>		
			</div>
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>						
							<th>Designation</th>
							<th>PMS Setup by Staff</th>
							<th>Approved by 1st Supervisor</th>
							<th>Approved by 2nd Supervisor</th>
						</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo $result['emp_id']; ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>
							<td><?php echo $result['designation_name']; ?></td>
							<td>
								<?php if($result['status'] == 1) { 
								echo '<span style="color:#179708"> Done</span>';
								} else if($result['status'] == 2){ 
								echo '<span style="color:#179708">Done</span>';
								} else if($result['status'] == 3){ 
								echo '<span style="color:#179708">Done</span>';
								} else { 
									if(($result['emp_id'] == 2333) || ($result['emp_id'] == 200824) || ($start_date <= $result['org_join_date'])) {
										echo '<span style="color:#179708">N/A</span>';
									} else {
									echo '<span style="color:#F70408">Pending</span>';
								} } ?>
							</td>
							<td>
								<?php  
								if($result['status'] == 2 || $result['status'] == 3) { 
								echo '<span style="color:#179708"> Done</span>';
								} else { 
								if(($result['emp_id'] == 2333) || ($result['emp_id'] == 200824) || ($start_date <= $result['org_join_date'])) {
										echo '<span style="color:#179708">N/A</span>';
									} else {
									echo '<span style="color:#F70408">Pending</span>';
								} }   ?>
							</td>
							<td>
								<?php  
								if($result['sub_super_visor_id'] != 0) { 
								if(($result['status'] == 3) && ($result['sub_status'] == 1)) { 
								echo '<span style="color:#179708"> Done</span>';
								} else { 
								echo '<span style="color:#F70408">Pending</span>';
								} } else { 
									if(($result['emp_id'] == 2333) || ($result['emp_id'] == 200824) || ($start_date <= $result['org_join_date'])) {
										echo '<span style="color:#179708">N/A</span>';
									} else {
								echo '-'; 
								} } ?>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>

<!------export to excel file------->
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
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
		//location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');
		$("#report_pms").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>