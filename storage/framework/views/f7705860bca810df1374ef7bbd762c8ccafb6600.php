
<?php $__env->startSection('title', 'All total Staff Report'); ?>
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
	<!--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">All Total Staff List</li>
	</ol>-->
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/all-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="pwd">Date WithIn:</label>
							<input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>
						<div class="form-group">
							<label for="email">Employee Group:</label>
							<select name="emp_group" id="emp_group" required class="form-control">
								<option value="">Select</option>
								<?php foreach ($all_emp_group as $empgroup) { ?>
								<option value="<?php echo $empgroup->id; ?>"><?php echo $empgroup->group_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Employee Type:</label>
							<select style="width:200px;" class="form-control" id="emp_type" name="emp_type" required >						
								<option value="" >-Select-</option>
								<?php $__currentLoopData = $all_emp_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emptype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($emptype->id); ?>"><?php echo e($emptype->type_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Status :</label>
							<select name="status" id="status" required class="form-control">
								<option value="1" <?php if($status==1) echo 'selected'; ?> >Running</option>
								<option value="0" <?php if($status==0) echo 'selected'; ?> >Cancel</option>
							</select>
						</div>						
						<button type="submit" class="btn btn-primary">Search</button>
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
			<div style="overflow-y: auto; height: 650px;" class="col-xs-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Last Degree</th>
							<th rowspan="2">Group/Subject</th>
							<th rowspan="2">Father's Name</th>
							<th rowspan="2">Mother Name</th>
							<th rowspan="2">Joining Date(Org)</th>
							<th rowspan="2">Total Job Duration (Org.)</th>
							<th colspan="2" style="text-align:center;">Present Work Station</th>
							<th rowspan="2">Duration of Present Branch</th>
							<th rowspan="2">Area</th>
							<th rowspan="2">Basic (Tk)</th>
							<th rowspan="2">Total Pay</th>
							<th rowspan="2">Net Pay</th>
							<th rowspan="2">Grade</th>
							<th rowspan="2">Grade Effect Date</th>
							<th rowspan="2">Duration of Present Grade</th>
							<th rowspan="2">Staff type</th>
							<th rowspan="2">No of Fine</th>
							<th rowspan="2">No of Warning</th>
							<th rowspan="2">No of Strong Warning</th>
							<th rowspan="2">No of Censure</th>
							<th rowspan="2">Permanent Address</th>
							<th rowspan="2">Blood Group</th>
							<th rowspan="2">Religion</th>
							<th rowspan="2">Gender</th>
							<th rowspan="2">Married/UnMarried</th>
							<th rowspan="2">DOB</th>
							<th rowspan="2">Present Age</th>
							<th rowspan="2">Contact No.</th>
							<th rowspan="2">NID</th>
							<th rowspan="2">Thana</th>
							<th rowspan="2">District</th>
							<th rowspan="2">Status</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<?php $i=1; foreach($all_result as $result) { ?>
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
							<td><?php echo e($result['emp_name_eng']); ?><?php if(!empty($result['incharge_as'])) { echo '<span style="color:#F70408"><b> ('.$result['incharge_as'].')</b></span> '; } ?></td>
							<td><?php echo e($result['emp_id']); ?></td>
							<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?></td>
							<td><?php echo e($result['exam_name']); ?></td>
							<td><?php echo e($result['subject_name']); ?></td>
							<td><?php echo e($result['father_name']); ?></td>
							<td><?php echo e($result['mother_name']); ?></td>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php 
									date_default_timezone_set('UTC');
									if(empty($result['re_effect_date'])) { 
										$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
										$input_date = new DateTime($input_date1);
									} else {
										$input_date = new DateTime($result['re_effect_date']);
									}
									$org_date = new DateTime($result['org_join_date']);	
									$difference = date_diff($org_date, $input_date);
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								?>
							</td>
							<td><?php if (empty($result['asign_branch_name'])) { echo $result['branch_name']; } else { echo $result['asign_branch_name']; } ?></td>
							<td><?php if (empty($result['asign_open_date'])) { echo $result['br_join_date']; } else { echo $result['asign_open_date']; } ?></td>
							<td><?php 
									if(empty($result['re_effect_date'])) { 
										$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
										$input_date = new DateTime($input_date1);
									} else {
										$input_date = new DateTime($result['re_effect_date']);
									}
									if (empty($result['asign_open_date'])) {
										$br_join_date = new DateTime($result['br_join_date']);
									} else {
										$br_join_date = new DateTime($result['asign_open_date']);
									}
									
									$difference = date_diff($br_join_date, $input_date);
									
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								?>
							</td>
							<td><?php if (empty($result['asign_area_name'])) { echo $result['area_name']; } else { echo $result['asign_area_name']; } ?></td>
							<td><?php echo e($result['basic_salary']); ?></td>
							<td><?php echo empty($result['total_pay']) ? $result['total_plus'] : $result['total_pay'];?></td>
							<?php if($result['emp_group'] == 1) { ?>
							<td><?php echo ($result['transection'] == 1) ? $result['net_pay'] : round($net_pay);?></td>
							<?php } else { ?>
							<td><?php echo round($result['gross_total']);?></td>
							<?php } ?>
							<td><?php echo e($result['grade_name']); ?></td>
							<td><?php echo e($result['grade_effect_date']); ?></td>
							<td><?php 
									$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
									$input_date = new DateTime($input_date1);
									$grade_effect_date = new DateTime($result['grade_effect_date']);	
									$difference = date_diff($grade_effect_date, $input_date);
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								?>
							</td>
							<td><?php if($emp_group ==1){ if($result['is_permanent'] == 1) {
								echo 'Probation'; } else {
								echo 'Permanent'; } } else if($emp_group ==2) {echo 'Contractual';} else {echo 'Volunteer';} ?>
							</td>
							<td><?php echo e($result['total_fine']); ?></td>
							<td><?php echo e($result['total_warning']); ?></td>
							<td><?php echo e($result['total_strong_warning']); ?></td>
							<td><?php echo e($result['total_censure']); ?></td>
							<td><?php echo e($result['permanent_add']); ?></td>
							<td><?php echo e($result['blood_group']); ?></td>
							<td><?php echo e($result['religion']); ?></td>
							<td><?php echo e($result['gender']); ?></td>
							<td><?php echo e($result['maritial_status']); ?></td>
							<td><?php echo e($result['birth_date']); ?></td>
							<td><?php 
									$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
									$input_date = new DateTime($input_date1);
									$birth_date = new DateTime($result['birth_date']);	
									$difference = date_diff($birth_date, $input_date);
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								?>
							</td>
							<td><?php echo e($result['contact_num']); ?></td>
							<td><?php echo e($result['national_id']); ?></td>
							<td><?php echo e($result['thana_name']); ?></td>
							<td><?php echo e($result['district_name']); ?></td>
							<td>
								<?php if(!empty($result['re_effect_date']) && $result['re_effect_date'] < $form_date ) { 
								echo '<span style="color:#F70408"> Cancel</span>';
								} else { 
								echo '<span style="color:#179708">Running</span>';
								}  ?>
							</td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<script type="text/javascript">
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("emp_group").value="<?php echo e($emp_group); ?>";
	document.getElementById("emp_type").value="<?php echo e($emp_type); ?>";
});

$(document).on("change", "#emp_group", function () {
	var emp_group = $(this).val();   
	//alert(emp_group);
	$.ajax({
		url : "<?php echo e(url::to('select-emp-type')); ?>"+"/"+emp_group,
		type: "GET",
		success: function(data)
		{
			//alert(data);
			$("#emp_type").html(data);
			 
		}
	});		
});
</script>
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
		//location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#All_Reports").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>