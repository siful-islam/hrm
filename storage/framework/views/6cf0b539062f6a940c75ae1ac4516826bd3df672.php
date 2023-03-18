
<?php $__env->startSection('title', 'Auto Increment Check'); ?>
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
<!------export to excel file------->	
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.btechco.excelexport.js')); ?>"></script>		
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.base64.js')); ?>"></script>		
<!------export to excel file------->
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/increment-staff-check')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
						  <label for="pwd">Effect Date:</label>
						  <input type="text" id="effect_date" class="form-control" name="effect_date" size="10" value="<?php echo e($effect_date); ?>" required>
						</div>						
						<button type="submit" class="btn btn-primary" >Search</button>
						<button type="button" id="btnExport" class="btn btn-primary" >Export Excel</button>
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
				<b><font size="4">Increment Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Workstation</th>
							<th>Grade</th>
							<th>Grade Step</th>
							<th>Basic(tk)</th>
						</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($result['emp_id']); ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>
							<td><?php echo e($result['designation_name']); ?></td>
							<td><?php echo e($result['branch_name']); ?></td>
							<td><?php echo e($result['grade_code']); ?></td>
							<td><?php echo e($result['grade_step']); ?></td>
							<td><?php echo e($result['basic_salary']); ?></td>
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
	$('#effect_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#effect_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<!------export to excel file------->
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
            });
        });
    });
</script>
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
		location.reload();
    }
</script>
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupService_Length_Reports").addClass('active');
			$("#Auto_Increment_Check").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>