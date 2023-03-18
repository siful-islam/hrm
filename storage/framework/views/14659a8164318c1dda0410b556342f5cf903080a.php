
<?php $__env->startSection('title', 'Designation-Wise Staff Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/designation-staff-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Employee Type :</label>
							<select name="emp_type" id="emp_type" required class="form-control">
								<?php $__currentLoopData = $all_emp_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp_type1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($emp_type1->id); ?>"><?php echo e($emp_type1->type_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Designation Name :</label>
							<select style="width:200px;" class="form-control" id="designation_code" name="designation_code" required >						
								<option value="" >-Select-</option>
								<?php if($emp_type ==1 || $emp_type ==2) { ?>
								<option value="all" >All</option>
								<?php } ?>
								<?php $__currentLoopData = $all_designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($designation->designation_code); ?>"><?php echo e($designation->designation_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required>
						</div>
						<div class="form-group">
							<label for="email">Order By :</label>
							<select name="order_by" id="order_by" class="form-control">
								<option value="" >Select</option>
								<option value="emp_id" <?php if($order_by=="emp_id") echo 'selected'; ?> >Employee ID</option>
							</select>
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
				<?php if($emp_type==1 && $designation_code == 'all' && $order_by == '') { ?>
				<?php $total_record = 0; foreach ($all_designation as $designation) {
				$i=1; foreach($all_result as $result) { 
				if($result['next_designation_code'] == $designation->designation_code) { 
				if($i==1) { ?>
				<p><b>Designation: </b><?php echo $designation->designation_name; ?></p>
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
							<th rowspan="2">Remarks</th>
							<th rowspan="2">Salary Branch</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<?php } ?>
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
							<td><?php echo e($i); ?></td>
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
							<td><?php echo e($result['incharge_as']); ?></td>
							<td><?php echo e($result['salary_branch_name']); ?></td>
						</tr>
						<?php $i++; } ?>  
						<?php } ?>
					</tbody>
				</table>
					<?php $total = $i-1; 
					if($total>0){ ?>
					<div class="col-md-12"><p align="right">Total Records: <?php echo $total_record +=$total;?></p></div>
					<?php } ?>
				<?php } } elseif(($emp_type==1 && $designation_code == 'all' && $order_by == 'emp_id') || ($emp_type==1 && $designation_code != 'all')) { ?>					
					<?php if($designation_code == 'all') {
						echo '<p><b>Designation: All</p>';
					} else {
						foreach ($all_designation as $designation) { 
							if($designation_code == $designation->designation_code) {
								echo '<p><b>Designation:' . $designation->designation_name;'</p>';
							}
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
							<th rowspan="2">Grade</th>														
							<th rowspan="2">Basic (Tk)</th>
							<th rowspan="2">Total Pay (Tk)</th>
							<th rowspan="2">Net Pay (Tk)</th>
							<!--<th rowspan="2">Cost of Org. (without allowance)</th>-->
							<?php if ($designation_code == 211 || $designation_code == 212 || $designation_code == 215) { ?>
							<th rowspan="2">Incharge effect date as Acting</th>
							<th rowspan="2">Duration(Designation)</th>
							<?php } ?>
							<th rowspan="2">Remarks</th>
							<th rowspan="2">Salary Branch</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<tbody>
					<?php $i=1; $total_basic = 0; $total_total_pay = 0; $total_net_pay = 0; $total_cot = 0; 
						foreach($all_result as $result) {
							$total_basic += $result['basic_salary'];
							$total_total_pay += $result['total_pay'];
							$total_net_pay += $result['net_pay'];
							$basic_percent = (($result['basic_salary']*21)/100);
							$pf = (($result['basic_salary']*10)/100);
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
							<!--<td><?php //echo $total_cto = (($result['permanent_provision'] == 2) ? $total_pay + $pf : (empty($result['total_pay']) ? $result['total_plus'] : $result['total_pay']));?></td>-->
							<?php if ($designation_code == 211 || $designation_code == 212 || $designation_code == 215) { ?>
							<td><?php echo e(date('d-m-Y', strtotime($result['open_date']))); ?></td>
							<td>
								<?php $date1 = new DateTime($result['open_date']);
									$date2 = new DateTime($form_date);
									$interval = date_diff($date1, $date2);						
									echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
								?>
							</td>
							<?php } ?>
							<td><?php echo e($result['incharge_as']); ?></td>
							<td><?php echo e($result['salary_branch_name']); ?></td>
						</tr>
						<?php } //$total_cot += $total_cto; ?>
						<tr>
							<td colspan="9"><center><b>Total</b></center></td>
							<td><?php echo e($total_basic); ?></td>
							<td><?php echo e($total_total_pay); ?></td>
							<td><?php echo e($total_net_pay); ?></td>
						</tr>
					</tbody>
				</table>
				<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
				<?php } else if ($emp_type != 1) {
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
							<th rowspan="2">Cost of Org.</th>
							<th rowspan="2">Contract Ending date</th>
						</tr>
						<tr>
							<th>HO/BO</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<tbody>
					<?php $i=1; $total_totalpay = 0; foreach($all_result as $result) { $total_totalpay += $result['total_pay']; ?>
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
							<td><?php echo e($result['total_pay']); ?></td>
							<td><?php echo e($result['c_end_date']); ?></td>
						</tr>
					<?php } ?>
						<tr>
							<td colspan="9"><center><b>Total</b></center></td>
							<td><?php echo e($total_totalpay); ?></td>
							<td><?php echo e($total_totalpay); ?></td>
						</tr>
					</tbody>
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
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Designation-wise_Staff").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>