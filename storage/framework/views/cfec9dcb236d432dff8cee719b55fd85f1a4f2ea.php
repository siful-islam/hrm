
<?php $__env->startSection('title', 'File Movement Report' ); ?>
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
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<?php if($user_type==1) { ?>
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/file-move-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="emp_id">Employee Name :</label>
							<select name="emp_id" id="emp_id" required class="form-control">
								<option value="3015" <?php if($emp_id==3015) echo 'selected'; ?> >Mahmuda Akhter</option>
								<option value="2540" <?php if($emp_id==2540) echo 'selected'; ?> >Md Tazul Islam</option>
								<option value="2333" <?php if($emp_id==2333) echo 'selected'; ?> >B.N Nazmoon Amin</option>
								<option value="3204" <?php if($emp_id==3204) echo 'selected'; ?> >Md Enamul Haque </option>
								<option value="3993" <?php if($emp_id==3993) echo 'selected'; ?> >Mst. Shamima Yeasmin Sumi</option>
								<option value="4118" <?php if($emp_id==4118) echo 'selected'; ?> >Roshni Daulat Rahman</option>
							</select>
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
	<?php } ?>
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">File Movement Report</font></b></p>		
			</div>
			<div class="col-md-12">
			<p>Employee Name: <?php if($emp_id==3015) echo 'Mahmuda Akhter'; 
								if($emp_id==2540) echo 'Md Tazul Islam';
								if($emp_id==2333) echo 'B.N Nazmoon Amin';
								if($emp_id==3204) echo 'Md Enamul Haque'; 
								if($emp_id==3993) echo 'Mst. Shamima Yeasmin Sumi'; 
								if($emp_id==4118) echo 'Roshni Daulat Rahman'; ?>
								
			<span style="float:right;">Print date & time : <?php date_default_timezone_set('Asia/Dhaka'); echo date("d-m-Y");?> & <?php echo date("h:i:sa");?></span>
			</p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Staff Type</th>
							<th>Receive Date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($result->fp_emp_id); ?></td>
							<td><?php echo empty($result->emp_name) ? $result->emp_name_eng : $result->emp_name; ?></td>
							<td><?php 
								if($result->emp_type == 1) { echo 'Regular';}
								else if ($result->emp_type == 2) { echo 'OT';}
								else if ($result->emp_type == 3) { echo 'CH';}
								else if ($result->emp_type == 4) { echo 'SHS';}
								?></td>
							<td><?php echo date('d-m-Y',strtotime($result->entry_date)); ?></td>
							<td><?php 
								if($result->file_type == 1) { echo 'Legal Notice';}
								else if ($result->file_type == 2) { echo 'Final Payment';}
								else if ($result->file_type == 3) { echo 'Final Payment Info';}
								else if ($result->file_type == 4) { echo 'Departmental Notice';}
								else if ($result->file_type == 5) { echo 'Final Payment Close';}
								else if ($result->file_type == 6) { echo 'Final Payment Settlement';}
								else if ($result->file_type == 7) { echo 'Litigation / Mgt. Decision';}
								?>
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
		$("#File_Movement_Report").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>