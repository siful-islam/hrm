
<?php $__env->startSection('title', 'Reports|Branch Staff Report'); ?>
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
	<?php if($user_type == 1 || $user_type == 11 || $user_type == 7) { ?>
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/branch-staff-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Branch Name :</label>
							<select class="form-control" id="br_code" name="br_code" required>						
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
						<div class="form-group">
							<label for="email">Status :</label>
							<select name="status" id="status" required class="form-control">
								<option value="1" <?php if($status==1) echo 'selected'; ?> >Running</option>
								<option value="2" <?php if($status==2) echo 'selected'; ?> >Cancel</option>
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
				<b><font size="4">Branch Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
			<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($v_branches->br_code == $br_code) { ?>
			<p><b>Branch Name: <?php echo $v_branches->branch_name; ?></b></p>
				<?php } ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Last Degree</th>
							<th rowspan="2">Joining Date(Org.)</th>
							<th colspan="2" style="text-align: center;">Present Work Station</th>							
							<th rowspan="2">Father's Name</th>
							<th rowspan="2">Permanent Address</th>
							<th rowspan="2">Status</th>
							<?php if($user_type == 1 || $user_type == 2) { ?>
							<th rowspan="2">Remarks</th>
							<?php } ?>
						</tr>
						<tr>
					<th>HO/BO Name</th>
					<th>Joining date</th>
				</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
				<?php 		
				/*$mapping = array();
				
				$mapping['emp_id'] 					= $result['emp_id'];
				$mapping['emp_name'] 				= $result['emp_name_eng'];
				$mapping['supervisor_id'] 			= 11;
				$mapping['supervisor_designation'] 	= 11;
				$mapping['active_from'] 			= '2018-01-01';
				$mapping['mapping_status'] 			= 1;
				
				DB::table('supervisor_mapping_ho')->insert($mapping);
				*/
				?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>							
							<td><?php /* if($result['emp_id'] <= 200000) { */ echo $result['emp_id'];//}
								/* else if ($result['emp_type'] == 2) { echo 'OT-'.$result['non_id'];}
								else if ($result['emp_type'] == 3) { echo 'CH-'.$result['non_id'];}
								else if ($result['emp_type'] == 4) { echo 'SHS-'.$result['non_id'];}
								else if ($result['emp_type'] == 5) { echo 'Cook-'.$result['non_id'];}
								else if ($result['emp_type'] == 6) { echo 'CMS-'.$result['non_id'];}
								else if ($result['emp_type'] == 7) { echo 'ED-'.$result['non_id'];}
								else if ($result['emp_type'] == 8) { echo 'HV-'.$result['non_id'];}
								else if ($result['emp_type'] == 9) { echo 'TS-'.$result['non_id'];} */
							?></td>
							<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?></td>
							<td><?php echo e($result['exam_name']); ?></td>
							<td><?php echo e(date('d M Y',strtotime($result['org_join_date']))); ?></td>
							<td><?php if (empty($result['asign_branch_name'])) { echo $result['branch_name']; } else { echo $result['asign_branch_name']; } ?></td>
							<td><?php if (empty($result['asign_open_date'])) { echo $result['br_join_date']; } else { echo $result['asign_open_date']; } ?></td>							
							<td><?php echo e($result['father_name']); ?></td>
							<td><?php echo e($result['permanent_add']); ?></td>
							<td><?php echo ($status == 1)?'Running':"Cancel"; ?></td>
							<?php if($user_type == 1 || $user_type == 2) { ?>
							<?php if(!empty($result['incharge_as'])) { ?>
							<td><?php echo e($result['incharge_as']); ?></td>
							<?php } } ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<script>
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
});
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Branch_Staff_List").addClass('active');
	});
</script>
<script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>