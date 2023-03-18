
<?php $__env->startSection('title', 'AM & BM Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/am-bm-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Select :</label>
							<select class="form-control" id="am_bm_code" name="am_bm_code" required>						
								<option value="" hidden>-Select-</option>
								<option value="12" <?php if($am_bm_code==12) echo 'selected'; ?> >All Branch Manager</option>
								<option value="11" <?php if($am_bm_code==11) echo 'selected'; ?> >All Area Manager</option>
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
	<div class="row">
	<?php if(!empty($all_result)): ?>
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">AM & BM Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<?php $total_record = 1; foreach ($all_zone as $v_zone) { $sl=1; $pre_area = ''; ?>
				<div style="width:15%; float:left; margin:5px 0 5px 0;"><strong>Zone Name : </strong><?php echo $v_zone->zone_name; ?></div>
			
				<?php foreach ($all_area as $v_area) {
				$post_area = $v_area->area_code;
				foreach($all_result as $staff) {
				if($v_zone->zone_code == $staff['zone_code']) {
				if($v_area->area_code == $staff['area_code']) {
				if($sl==1) { ?>
					<table class="table table-bordered" cellspacing="0">
						<thead>
							<tr>
								<th rowspan="2">SL No.</th>
								<th rowspan="2">Staff ID</th>
								<th rowspan="2">Staff Name</th>
								<th rowspan="2">Designation</th>				
								<th rowspan="2">Last Degree</th>
								<th rowspan="2">Joining Date(Org.)</th>
								<th colspan="2" style="text-align: center;">Present Work Station</th>
								<th rowspan="2">Duration (<?php echo ($am_bm_code == '12') ? 'Present Branch' : 'Present Area'; ?>)</th>
								<th rowspan="2">Area</th>
								<th rowspan="2">Grade</th>
								<th rowspan="2">Grade Effect Date</th>
								<th rowspan="2">Duration (Grade)</th>
								<th rowspan="2">Thana</th>
								<th rowspan="2">District</th>
							</tr>
							<tr>
								<th>HO/BO</th>
								<th>Joining date</th>
							</tr>
						</thead>
				<?php } ?>
						<tbody>
							<tr <?php if (($am_bm_code == '12') && $pre_area != $post_area) { ?> style="background-color:lightgray;" <?php } ?>>                                    
								<td><?php echo $sl; ?></td>   
								<td><?php echo $staff['emp_id']; ?></td>
								<td><?php echo $staff['emp_name_eng']; ?></td>
								<td><?php echo $staff['designation_name']; ?></td>
								<td><?php echo $staff['exam_name']; ?></td>
								<td><?php echo $staff['org_join_date']; ?></td>
								<td><?php echo $staff['branch_name']; ?></td>
								<td><?php echo $staff['br_join_date']; ?></td>
								<td><?php 
									date_default_timezone_set('UTC');
									$input_date = new DateTime($form_date);
									$br_join_date = new DateTime($staff['br_join_date']);	
									$difference = date_diff($br_join_date, $input_date);
									// $days = $diff12->d;
									//accesing months
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
									//accesing years
									// $years = $diff12->y;
									?>
								</td>
								<td><?php echo $staff['area_name']; ?></td>
								<td><?php echo $staff['grade_name']; ?></td>
								<td><?php echo $staff['grade_effect_date']; ?></td>
								<td><?php 
									date_default_timezone_set('UTC');
									$input_date = new DateTime($form_date);
									$grade_effect_date = new DateTime($staff['grade_effect_date']);	
									$difference = date_diff($grade_effect_date, $input_date);
									// $days = $diff12->d;
									//accesing months
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
									//accesing years
									// $years = $diff12->y;
									?>
								</td>
								<td><?php echo $staff['thana_name']; ?></td>
								<td><?php echo $staff['district_name']; ?></td>
							</tr>
				<?php $pre_area=$v_area->area_code; $sl++; } } ?>  
				<?php } ?>			
				<?php } ?>
						</tbody>
					</table>
				<?php } ?>
				<?php $staff_count = 0; if (($am_bm_code == '11') && !empty($am_bm_staff)) { $staff_count = count ($am_bm_staff); ?>
					<div style="width:15%; float:left; margin:5px 0 5px 0;"><strong>Zone Name : </strong><?php echo ''; ?></div>
					<table class="table table-bordered" cellspacing="0">
						<thead>				
							<tr>
								<th rowspan="2">SL No.</th>
								<th rowspan="2">Staff ID</th>
								<th rowspan="2">Staff Name</th>
								<th rowspan="2">Designation</th>				
								<th rowspan="2">Last Degree</th>
								<th rowspan="2">Joining Date(Org.)</th>
								<th colspan="2" style="text-align: center;">Present Work Station</th>
								<th rowspan="2">Duration (<?php echo ($am_bm_code == '12') ? 'Present Branch' : 'Present Area'; ?>)</th>
								<th rowspan="2">Area</th>
								<th rowspan="2">Grade</th>
								<th rowspan="2">Grade Effect Date</th>
								<th rowspan="2">Duration (Grade)</th>
								<th rowspan="2">Thana</th>
								<th rowspan="2">District</th>
							</tr>
							<tr>
								<th>HO/BO</th>
								<th>Joining date</th>
							</tr>
						</thead>
							<?php $s2=1; foreach($am_bm_staff as $staff1) { ?>
						<tbody>	
							<tr>                                    
							  <td><?php echo $s2++; ?></td>   
							  <td><?php echo $staff1['emp_id']; ?></td>
								<td><?php echo $staff1['emp_name_eng']; ?></td>
								<td><?php echo $staff1['designation_name']; ?></td>
								<td><?php echo $staff1['exam_name']; ?></td>
								<td><?php echo $staff1['org_join_date']; ?></td>
								<td><?php echo $staff1['branch_name']; ?></td>
								<td><?php echo $staff1['br_join_date']; ?></td>
								<td><?php 
									date_default_timezone_set('UTC');
									$input_date = new DateTime($form_date);
									$br_join_date = new DateTime($staff1['br_join_date']);	
									$difference = date_diff($br_join_date, $input_date);
									// $days = $diff12->d;
									//accesing months
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
									//accesing years
									// $years = $diff12->y;
									?>
								</td>
								<td><?php echo $staff1['area_name']; ?></td>
								<td><?php echo $staff1['grade_name']; ?></td>
								<td><?php echo $staff1['grade_effect_date']; ?></td>
								<td><?php 
									date_default_timezone_set('UTC');
									$input_date = new DateTime($form_date);
									$grade_effect_date = new DateTime($staff1['grade_effect_date']);	
									$difference = date_diff($grade_effect_date, $input_date);
									// $days = $diff12->d;
									//accesing months
									echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
									//accesing years
									// $years = $diff12->y;
									?>
								</td>
								<td><?php echo $staff1['thana_name']; ?></td>
								<td><?php echo $staff1['district_name']; ?></td>
							</tr>
						</tbody>
							<?php } ?>
					</table>
				<?php } ?>	
			</div>
		</div>
		<b><span style="color:#494847; float:right;margin:5px 0 5px 0;">Total Records: <?php echo count ($all_result)+$staff_count; ?></span></b>
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
		$("#MainGroupBasic_Reports").addClass('active');
		$('[id^=AM_]').addClass('active');
		
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>