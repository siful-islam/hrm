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
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/project-branch-staff')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label>Branch Name :</label>
							<select class="form-control" id="br_code" name="br_code" required>						
								<option value="" hidden>-Select-</option>
								<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($v_branches->main_br_code); ?>"><?php echo e($v_branches->branch_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label>Year :</label>
							<select name="year" id="year" required class="form-control">
								<option value="<?php echo date('Y'); ?>" ><?php echo date('Y'); ?></option>
							</select>
						</div>
						<div class="form-group">
						  <label>Month:</label>
						  <select name="month" id="month" required class="form-control">
							  <option value="01">January</option>
							  <option value="02">February</option>
							  <option value="03">March</option>
							  <option value="04">April</option>
							  <option value="05">May</option>
							  <option value="06">June</option>
							  <option value="07">July</option>
							  <option value="08">August</option>
							  <option value="09">September</option>
							  <option value="10">October</option>
							  <option value="11">November</option>
							  <option value="12">December</option>
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
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Project Wise Branch Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
			<?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($v_branches->main_br_code == $br_code) { ?>
			<p><b>Branch Name: <?php echo $v_branches->branch_name; ?></b>
				<?php } ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<span style="float: right;"><b>Month: <?php echo date("F",strtotime($form_date)); ?>-2022</b></span>
			</p>
			</div>
			<form action="<?php echo e(URL::to('/project-staff-save')); ?>" method="post" class="form-horizontal">	
			<?php echo e(csrf_field()); ?>

			<div class="col-md-12">
				<table class="table table-bordered" style="width:100%;" cellspacing="0">
					<thead>
						<tr>
							<th style="width:5%;text-align:center;">SL No.</th>
							<th style="width:10%;">Program</th>
							<th style="width:10%;">Project</th>
							<th style="width:5%;text-align:center;">Emp ID</th>
							<th style="width:10%;">Staff Name</th>
							<th style="width:10%;">Designation</th>
							<th style="width:5%;">Branch Name</th>
							<th style="width:5%;">Is Register</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$column = array_column($all_result, 'program_id');
						array_multisort($column, SORT_ASC, $all_result);
						$columnn = array_column($all_result, 'project_id');
						array_multisort($columnn, SORT_ASC, $all_result);
						$columns = array_column($all_result, 'priority');
						array_multisort($columns, SORT_ASC, $all_result);
						$array = json_decode(json_encode($all_result), true);
						 /*  echo "<pre>";
						print_r($all_result); */
						 //$count_microfinance = array_count_values(array_column($array,'program_id'))[1];
						 //$count_special = array_count_values(array_column($array,'program_id'))[2];
						 $k=0;
						 ?>
						 <?php 
							$renderedPrograms = []; 
							$renderedProjects = []; 
						 ?>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
						<tr>
							<input type="hidden" name="result_item[<?php echo $result['emp_id']; ?>][emp_id]" value="<?php echo $result['emp_id']; ?>">
							<input type="hidden" name="br_code" value="<?php echo $br_code; ?>">
							<td><center><?php echo e($i++); ?></center></td>		
								<?php if(!in_array($result['program_id'], $renderedPrograms)): ?>
								<?php $renderedPrograms[] = $result['program_id']; ?>
								<?php $count_array = array_count_values(array_column($array,'program_id'))[$result['program_id']];?>
								<td rowspan="<?php echo e($count_array); ?>">
									<?php echo $result['program_id'] == 1 ? 'Microfinance Program' : 'Special Program'; ?>
								</td>
							<?php endif; ?>	
							<?php if(!in_array($result['project_name'], $renderedProjects)): ?>
								<?php $renderedProjects[] = $result['project_name']; ?>
								<?php $count_arrays = array_count_values(array_column($array,'project_name'))[$result['project_name']];?>
								<td rowspan="<?php echo e($count_arrays); ?>">
									<?php echo $result['project_name'] ; ?>
								</td>
							<?php endif; ?>		
							 <!--td >
									<?php //echo $result['program_id'] == 1 ? 'Microfinance' : 'Special'; ?>
								</td>	
							<td><?php // echo $result['project_name'];?></td-->
							<td><center><?php echo $result['emp_id'];?></center></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>							
							<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?>
							</td>
							<td><?php echo $result['branch_name']; ?></td>
							<td><?php if($result['is_register'] == 1 )  echo "Yes"; else if($result['is_register'] == 2) echo "No"; ?></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
			</form>
		</div>
	</div>
	<?php endif; ?>
</section>
<script>
$(document).ready(function() {
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
	document.getElementById("month").value = "<?php echo $month; ?>";
});
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupService_Length_Reports").addClass('active');
		$("#Project_Wise_Branch_Staff").addClass('active');
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