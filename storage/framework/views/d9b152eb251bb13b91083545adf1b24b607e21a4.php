
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
				<b><font size="4">Assessment Report</font></b><br/>
				<b><font size="4">Assessment Year : 2020-2021</font></b></p>			
			</div>
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Department</th>
							<th>ID No</th>
							<th>Staff Name</th>						
							<th>Designation</th>
							<th>Score of B</th>
							<th>C.1</th>
							<th>C.2</th>
							<th>C.3</th>
							<th>C.4</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo $result['department_name']; ?></td>
							<td><?php echo $result['emp_id']; ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>
							<td><?php echo $result['designation_name']; ?></td>
							<td><?php echo $result['score_b']; ?></td>
							<td><?php echo $result['score_c1']; ?></td>
							<td><?php echo $result['score_c2']; ?></td>
							<td><?php echo $result['score_c3']; ?></td>
							<td><?php echo $result['score_c4']; ?></td>
							<td><?php echo round($result['score_b'] + $result['score_c1'] + $result['score_c2'] + $result['score_c3'] + $result['score_c4']); ?></td>
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
		//location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		/* $("#MainGroupBasic_Reports").addClass('active');
		$("#All_Staff_List").addClass('active'); */
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>