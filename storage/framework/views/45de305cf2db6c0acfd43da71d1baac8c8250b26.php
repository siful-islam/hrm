
<?php $__env->startSection('title', 'Department-Wise Staff Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/program-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Program:</label>
							<select style="width:150px;" class="form-control" id="program_id" name="program_id" required >						
								<option value="" >-Select-</option>
								<option value="1">Microfinance Program</option>
								<option value="2">Special Program</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Department:</label>
							<select style="width:150px;" class="form-control" id="department_id" name="department_id" >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($department->department_id); ?>"><?php echo e($department->department_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Unit:</label>
							<select style="width:150px;" name="unit_id" id="unit_id" class="form-control" >
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_unit_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unitname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($unitname->id); ?>" selected="selected"><?php echo e($unitname->unit_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Project:</label>
							<select style="width:150px;" class="form-control" id="project_id" name="project_id" >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_project; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($project->id); ?>"><?php echo e($project->project_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Type:</label>
							<select style="width:100px;" class="form-control" id="type_id" name="type_id" >
								<option value="1">HO</option>
								<option value="2">Branch</option>
								<option value="3">All</option>
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
				<!--<b><font size="4">Program/Department/Project/Unit-Wise Staff List</font></b></p>		-->
			</div>
			<div class="col-md-12">					
					<?php 
						/* foreach ($all_department as $department) { 
							if($department_id == $department->department_id) {
								echo '<p><b>Program/Department/Project/Unit:' . $department->department_name;'</p>';
							}
						} */
					
					?>
					<p id="abc" style="font-weight:bold;"></p>
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
							<th rowspan="2">Grade</th>														
							<th rowspan="2">Basic (Tk)</th>
							<th rowspan="2">Total Pay (Tk)</th>
							<th rowspan="2">Net Pay (Tk)</th>
							<th rowspan="2">Salary Branch</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<?php $i=1; $columns = array_column($all_result, 'designation_priority');
						array_multisort($columns, SORT_ASC, $all_result);
						foreach($all_result as $result) { ?>
					<tbody>
						<?php 
							$basic_percent = (($result['basic_salary']*21)/100);
							if(empty($result['total_pay'])) {
								$total_pay = $result['total_plus'];
							} else {
								$total_pay = $result['total_pay'];
							}
							$nit_pay = $total_pay - $basic_percent;
							if ($nit_pay == $result['net_pay']) {
								$net_pay = $result['net_pay'];
							} else {
								$net_pay = $nit_pay;
							}
						?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<?php if(!empty($result['increment_marked'])) { ?>
							<td style="background:#ED2225;color:#fff;"><?php echo $result['emp_id']; ?><br>(Redmarked)</td>
							<?php } else { ?>
							<td><?php echo $result['emp_id']; ?></td>
							<?php } ?>
							<?php if(!empty($result['promotion_marked'])) { ?>
							<td style="background:#FE9A2E;color:white;"><?php echo $result['emp_name_eng']; ?><br>(Yellowmarked)</td>
							<?php } else { ?>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<?php } ?>
							<?php if(!empty($result['permanent_marked'])) { ?>
							<td style="background:#008000;color:white;"><?php echo empty($result['asign_desig']) ? $result['designation_name'] : $result['asign_desig']; ?></td>
							<?php } else { ?>
							<td><?php echo empty($result['asign_desig']) ? $result['designation_name'] : $result['asign_desig']; ?></td>
							<?php } ?>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php echo e($result['exam_name']); ?></td>							
							<td><?php echo empty($result['asign_branch_name']) ? $result['branch_name'] : $result['asign_branch_name']; ?></td>
							<td><?php echo empty($result['asign_open_date']) ? $result['br_join_date'] : $result['asign_open_date']; ?></td>
							<td><?php echo e($result['grade_name']); ?></td>
							<td><?php echo e($result['basic_salary']); ?></td>							
							<td><?php echo empty($result['total_pay']) ? $result['total_plus'] : $result['total_pay'];?></td>							
							<td><?php echo e($result['net_pay']); ?></td>
							<td><?php echo e($result['salary_branch_name']); ?></td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
				<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
			</div>
		</div>
	<?php endif; ?>
	</div>
</section>
<script type="text/javascript">
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	var program = document.getElementById("program_id").value="<?php echo e($program_id); ?>";
	var department = document.getElementById("department_id").value="<?php echo e($department_id); ?>";
	var unit = document.getElementById("unit_id").value="<?php echo e($unit_id); ?>";
	var project = document.getElementById("project_id").value="<?php echo e($project_id); ?>";
	var type = document.getElementById("type_id").value="<?php echo e($type_id); ?>";
	
	/* var text1=document.getElementById('program_id').selectedOptions[0].text;
	var text2=document.getElementById('department_id').selectedOptions[0].text;
	var text3=document.getElementById('unit_id').selectedOptions[0].text;
	var text4=document.getElementById('project_id').selectedOptions[0].text;
	var text5=document.getElementById('type_id').selectedOptions[0].text; */
	
	var text1 = (program == "") ? "" : 'Program' + '-' + $( "#program_id option:selected" ).text() + ', ';
	var text2 = (department == "") ? "" : 'Department' + '-' + $( "#department_id option:selected" ).text() + ', ';
	var text3 = (unit == "") ? "" : 'Unit' + '-' + $( "#unit_id option:selected" ).text() + ', ';
	var text4 = (project == "") ? "" : 'Project' + '-' + $( "#project_id option:selected" ).text() + ', ';
	var text5 = (type == "") ? "" : 'Type' + '-' + $( "#type_id option:selected" ).text();
	
	document.getElementById('abc').innerHTML= text1 + " " + text2 + " " + text3 + " " + text4 + " " + text5;
});

$(document).on("change", "#department_id", function () {
		var department_id = $(this).val();
		 
		$.ajax({
			url : "<?php echo e(url::to('select-unit')); ?>"+"/"+department_id,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#unit_id").html(data);
				 
			}
		});  
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
		//location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Program_wise_Report").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>