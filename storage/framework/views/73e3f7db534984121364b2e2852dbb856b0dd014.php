
<?php $__env->startSection('title', 'Next Increment Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/next-incre-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
						  <label for="pwd">Increment Date :</label>
						  <input type="text" id="to_date" class="form-control" name="to_date" size="10" value="<?php echo e($increment_date); ?>" required>
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
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Next Increment Staff</font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Increment Date</th>
							<th>Letter date</th>
							<th>Employee ID</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Effect date</th>
							<th>Grade</th>
							<th>Grade Step</th>
							<th>Basic(tk)</th>
							<th>Total Pay</th>
							<th>Net Pay</th>
							<th>Workstation</th>
						</tr>
					</thead>
					<tbody> <?php $red = 0; ?>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
							<td><?php echo date('d M Y',strtotime($result['next_increment_date'])); ?></td>
							<td><?php echo date('d M Y',strtotime($result['letter_date'])); ?></td>
							<?php if(!empty($result['increment_marked'])) { ?>
							<td style="background:#ED2225;color:#fff;"><?php  echo $result['emp_id']; ?><br>(Redmarked)</td>
							<?php } else { ?>
							<td><?php  echo $result['emp_id']; ?></td>
							<?php } ?>
							<?php if(!empty($result['promotion_increment_marked'])) { ?>
							<td style="background:#50d6a1;color:#fff;"><?php echo $result['emp_name_eng']; ?><br>(Marked)</td>
							<?php } else { ?>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<?php } ?>
							<td><?php echo e($result['designation_name']); ?></td>
							<td><?php echo date('d M Y',strtotime($result['effect_date'])); ?></td>
							<td><?php echo e($result['grade_name']); ?></td>
							<td><?php echo e($result['grade_step']); ?></td>
							<td><?php echo e($result['basic_salary']); ?></td>
							<td><?php echo empty($result['total_pay']) ? $result['total_plus'] : $result['total_pay'];?></td>
							<td><?php echo e($result['net_pay']); ?></td>
							<td><?php echo e($result['branch_name']); ?></td>
						</tr>
						
						
						
						<?php 
						$emp_id = $result['emp_id'];
						
						/*$insert['emp_id'] = $result['emp_id'];
						$insert['pre_br'] = $result['branch_name']; 
						$insert['pre_grade'] = $result['grade_code'];
						$insert['pre_step'] = $result['grade_step'];
						$insert['pre_basic'] = $result['basic_salary'];
						$insert['pre_dsg'] = $result['designation_name']; 
						$insert['is_red_mark'] = $red;
						
						DB::table('check_increment')->insert($insert);
						*/
						//DB::table('check_increment')->where('emp_id', $emp_id)->update(['is_red_mark' => $red]);
						?>
						
						
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
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
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
		$("#MainGroupTransaction_Reports").addClass('active');
		$("#Next_Increment_Report").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>