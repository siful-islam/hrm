
<?php $__env->startSection('title', 'Branch Wise Designation Report'); ?>;
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
					<form class="form-inline report" action="<?php echo e(URL::to('/branch-designation-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Employee Type :</label>
							<select name="emp_type" id="emp_type" required class="form-control">
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_emp_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_type1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($emp_type1->id); ?>"><?php echo e($emp_type1->type_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="designation">Designation Name :</label>
							<select style="width:200px;" class="form-control" id="designation_code" name="designation_code" required >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($designation->designation_code); ?>"><?php echo e($designation->designation_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="branch">Branch Name :</label>
							<select class="form-control" id="br_code" name="br_code" required >						
								<option value="" hidden>-Select-</option>
								<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_branches->br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
				<b><font size="4">Designation-Wise Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<?php if ($emp_type != 1) {
					foreach ($all_designation as $designation) { 
							if($designation_code == $designation->designation_code) {
								echo '<p><b>Designation:' . $designation->designation_name;'</p>';
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
							<th rowspan="2">Duration of Present Branch</th>
							<th rowspan="2"><?php if($emp_type ==3 || $emp_type ==4 || $emp_type ==7 ) { echo 'Total';} else { echo 'Consolidated';}?> Salary (Tk)</th>
							<th rowspan="2">Contract Ending date</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<?php $i=1; foreach($all_result as $result) { ?>
					<tbody>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo $result['sacmo_id']; ?></td>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<td><?php echo $result['designation_name']; ?></td>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php echo e($result['exam_name']); ?></td>							
							<td><?php echo $result['branch_name']; ?></td>
							<td><?php echo $result['br_join_date']; ?></td>							
							<td><?php 
								date_default_timezone_set('UTC');
								$input_date = new DateTime($form_date);
								$org_date = new DateTime($result['br_join_date']);	
								$difference = date_diff($org_date, $input_date);
								echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								 ?></td>							
							<td><?php echo e($result['total_pay']); ?></td>
							<td><?php echo e($result['c_end_date']); ?></td>
						</tr>
					</tbody>
					<?php } ?>
					</table>
					<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
				<?php } ?>
			</div>
		</div>
	<?php endif; ?>
	</div>
</section>
<script>
	$(document).on("change", "#emp_type", function () {
		var emp_type = $(this).val();   
		//if(!(emp_type == 1 || emp_type == 2)) {
		//alert(emp_type);
			$.ajax({
			url : "<?php echo e(url::to('emp_type_designation')); ?>"+"/"+emp_type,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				//$("#designation_code").attr("disabled", false);
				$("#designation_code").html(data); 
				 
			}
			});
		//} 	 
	}); 
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("designation_code").value="<?php echo e($designation_code); ?>";
	document.getElementById("emp_type").value="<?php echo e($emp_type); ?>";
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
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
		$("#MainGroupContractual").addClass('active');
		//$("#Transfer_(Contractual)").addClass('active');
		$('[id^=Branch_wise_Desig]').addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>