<?php $__env->startSection('title', 'Area Wise Staff Number'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/area-staff-no')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Area Name :</label>
							<select class="form-control" id="area_code" name="area_code" required>						
								<option value="" >-Select-</option>
								<option value="all" >All</option>
								<?php $__currentLoopData = $all_area; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_area->area_code); ?>"><?php echo e($v_area->area_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
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
<script>
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("area_code").value="<?php echo $area_code;?>";
});
</script>
	<div class="row">
	<?php if(!empty($area_code)): ?>
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Area wise Staff No.</font></b></p>		
			</div>
			<div class="col-md-12">							
				<table class="table table-bordered" cellspacing="0">
					<?php if(!empty($all_result2) && ($area_code != 'all')) { ?>
					<thead>
						<tr>
							<th>Branch Name</th>
							<?php  foreach($all_emp_type as $emp_type) { ?>	
							<th><?php echo $emp_type->type_name;
							?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=1; foreach ($all_branch as $branch) { 
						?>

						<tr>
							<td><?php echo $branch->branch_name;?></td>
							<?php foreach ($all_emp_type as $emp_type) {	
								$abc = 1;
								foreach($all_result2 as $result) {
								if(($branch->br_code == $result['br_code']) && ($emp_type->id == $result['emp_type'])) { 
								$abc = 0;
							?>
							<td><?php echo $result['emp_type_value']; ?></td>
							<?php } ?>								
							<?php } if($abc==1) { ?>
							<td><?php echo 0; ?></td>
							<?php } } ?>
						</tr>
						<?php } ?>
						<tr>                                      
							<td colspan="10" style="background-color:lightgray;color:#172321;"><b><?php echo $get_area->area_name." Area"; ?></b></td>							
						</tr>
					</tbody>
					<?php } else if(!empty($all_result2) && ($area_code = 'all')){ ?>
					<thead>
						<tr>
							<th>Branch Name</th>
							<?php  foreach($all_emp_type as $emp_type) { ?>	
							<th><?php echo $emp_type->type_name;
							?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($all_area as $area) {
						$i=1; foreach ($all_branch as $branch) { 
						if($area->area_code == $branch->area_code) {
						?>

						<tr>
							<td><?php echo $branch->branch_name;?></td>
							<?php foreach ($all_emp_type as $emp_type) {	
								$abc = 1;
								foreach($all_result2 as $result) {
								if(($branch->br_code == $result['br_code']) && ($emp_type->id == $result['emp_type'])) { 
								$abc = 0;
							?>
							<td><?php echo $result['emp_type_value']; ?></td>
							<?php } ?>								
							<?php } if($abc==1) { ?>
							<td><?php echo 0; ?></td>
							<?php } } ?>
						</tr>
						<?php } } ?>
						<tr>                                      
							<td colspan="10" style="background-color:lightgray;color:#172321;"><b><?php echo $area->area_name." Area"; ?></b></td>
							<?php } ?>
						</tr>
					</tbody>
					<?php } ?>
				</table>				
			</div>
		</div>
	<?php endif; ?>
	</div>
</section>
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
		//$("#District_wise_Staff_No.").addClass('active');
		$('[id^=Area_wise_Staff_No]').addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>