
<?php $__env->startSection('title', 'Organization Service Length Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/org-service-length')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
						  <label for="pwd">Date As:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required />
						</div>
						<div class="form-group">
						  <label for="pwd">Year As:</label>
						  <input type="text" class="form-control" name="year_as" size="6" value="<?php echo e($year_as); ?>" />
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
				<b><font size="4">Service Length from Organization Join Date</font></b></p>		
			</div>
			<?php if(!empty($year_as)) { ?>
			<div class="col-md-12">
				<?php $total_record = 0; foreach ($all_grade as $grade) {
				$i=1; foreach($all_result as $result) { 
			
				date_default_timezone_set('UTC');
				$input_date = new DateTime($form_date);
				$org_date = new DateTime($result['org_join_date']);	
				$difference = date_diff($org_date, $input_date);
				if ($difference->y >= $year_as) {
				//exit				
				if($result['grade_code'] == $grade->grade_code) { 
				if($i==1) { ?>
				<p><b>Grade: </b><?php echo $grade->grade_name; ?></p>
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Joining Date (Org.)</th>
							<th>Service Length</th>
							<th>Last Degree</th>
							<th>Grade</th>						
							<th>Work Station</th>
							<th>Staff type</th>
							<th>Is Promotion</th>
						</tr>
					</thead>
					<?php } ?>
					<tbody>
						<tr>
							<td><?php echo e($i); ?><?php if($result['tran_type_no'] == 14) { echo '<span style="color:#F70408"><b> (Demotion)</b></span> '; } ?></td>
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
							<td style="background:#008000;color:white;"><?php echo $result['designation_name']; ?></td>
							<?php } else { ?>
							<td><?php echo $result['designation_name']; ?></td>
							<?php } ?>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php 
								date_default_timezone_set('UTC');
								$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
								$input_date = new DateTime($input_date1);
								$org_date = new DateTime($result['org_join_date']);	
								$difference = date_diff($org_date, $input_date);
								echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								 ?></td>
							<td><?php echo e($result['exam_name']); ?></td>
							<td><?php echo e($result['grade_name']); ?></td>							
							<td><?php echo e($result['branch_name']); ?></td>
							<td><?php if($result['is_permanent'] == '1') {
								echo 'Probation'; } else {
								echo 'Permanent'; } ?>
							</td>
							<td><?php if($result['total']){ echo 'Yes'. ' - ' . $result['total']; } else { echo 'No  - 0';}?></td>
						</tr>
						<?php $i++; } ?>  
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
				<?php $total = $i-1; 
				if($total>0){ ?>
				<div class="col-md-12"><p align="right">Total Records: <?php echo $total_record +=$total;?></p></div>
				<?php } ?>
				<?php } ?>
			</div>
			
			<?php } else { ?>
			<div class="col-md-12">
				<?php $total_record = 1; foreach ($all_grade as $grade) {
				$i=1; foreach($all_result as $result) { 
				if($result['grade_code'] == $grade->grade_code) { 
				if($i==1) { ?>
				<p><b>Grade: </b><?php echo $grade->grade_name; ?></p>
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Joining Date (Org.)</th>
							<th>Service Length</th>
							<th>Last Degree</th>
							<th>Grade</th>						
							<th>Work Station</th>
							<th>Staff type</th>
							<th>Is Promotion</th>
						</tr>
					</thead>
					<?php } ?>
					<tbody>
						<tr>
							<td><?php echo e($i); ?><?php if($result['tran_type_no'] == 14) { echo '<span style="color:#F70408"><b> (Demotion)</b></span> '; } ?></td>
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
							<td style="background:#008000;color:white;"><?php echo $result['designation_name']; ?></td>
							<?php } else { ?>
							<td><?php echo $result['designation_name']; ?></td>
							<?php } ?>
							<td><?php echo e($result['org_join_date']); ?></td>
							<td><?php 
								date_default_timezone_set('UTC');
								$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
								$input_date = new DateTime($input_date1);
								$org_date = new DateTime($result['org_join_date']);	
								$difference = date_diff($org_date, $input_date);
								echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								 ?></td>
							<td><?php echo e($result['exam_name']); ?></td>
							<td><?php echo e($result['grade_name']); ?></td>							
							<td><?php echo e($result['branch_name']); ?></td>
							<td><?php if($result['is_permanent'] == '1') {
								echo 'Probation'; } else {
								echo 'Permanent'; } ?>
							</td>
							<td><?php if($result['total']){ echo 'Yes'. ' - ' . $result['total']; } else { echo 'No  - 0';}?></td>
						</tr>
						<?php $i++; } ?>  
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php if(empty($year_as)) { ?>
		<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
		<?php } ?>
	<?php endif; ?>
	</div>
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
			$("#MainGroupService_Length_Reports").addClass('active');
			$("#Org_Service_Length").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>