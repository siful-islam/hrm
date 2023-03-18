<?php $__env->startSection('title', 'Staff Join & Dropout Report'); ?>
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
	text-align: center; 
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
					<form class="form-inline report" action="<?php echo e(URL::to('/staff-join-drop')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Designation Group Name :</label>
							<select class="form-control" id="desig_group_code" name="desig_group_code" required>						
								<option value="" >-Select-</option>
								<option value="all" >All</option>
								<?php $__currentLoopData = $designation_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desig_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($desig_group->desig_group_code); ?>"><?php echo e($desig_group->desig_group_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">From Date:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="<?php echo e($form_date); ?>" required />
						</div>
						<div class="form-group">
						  <label for="pwd">To Date:</label>
						  <input type="text" id="to_date" class="form-control" name="to_date" size="10" value="<?php echo e($to_date); ?>" required />
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="date_within" class="form-control" name="date_within" size="10" value="<?php echo e($date_within); ?>" required />
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
	<?php if(!empty($designation_group_total)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Staff Join & Dropout</font></b></p>		
			</div>
			<div class="col-md-6 col-md-offset-3">
			<?php $__currentLoopData = $designation_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desig_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($desig_group->desig_group_code == $desig_group_code) { ?>
				<p style="margin-left:50px;"><b>Designation Group Name: </b><?php echo $desig_group->desig_group_name; ?></p>
				<?php } ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>			
			</div>	
			<div class="col-md-12">
				<div align="center">
	<table style="width:600px;" border="1" cellspacing="0"> 
		<tbody>
			<tr>
				<th><div align="center">SL No.</div></th>
				<th><div align="center">Designation</div></th>
				<th><div align="center">Total Strength</div></th>
				<?php if(!empty($designation_group_total1)) { ?><th><div align="center">Total Joining (New Staff)</div></th><?php } ?>
				<th style="width:110px;"><div align="center">New Staff Resign (Who Join from<br/><?php echo date("d-M-Y", strtotime($form_date)).' '.'to<br/>'.' '.date("d-M-Y", strtotime($to_date)); ?>)</div></th>
				<th><div align="center">Old Resign</div></th>
				<?php if(!empty($designation_group_total2)) { ?><th><div align="center">Total Resign</div></th><?php } ?>
			</tr>
	<?php $total=0; $old_total=0; $sl = 1; foreach ($all_designation as $v_designation) { ?>     		
		<?php foreach ($designation_group_total as $key => $value) { ?>		
			<?php if($v_designation->designation_code == $key) { $total = $total+$value; ?>
			<tr>
			<!--<div style="width:80%; float:left; margin:5px 0 5px 0;"><strong>Designation Name : </strong><?php //echo $v_designation['designation_name'].'='.$value; ?></div>-->
				<td style="padding:10px 0 5px 10px;width:50px;"><?php echo $sl++.'.'; ?></td>
				<td style="padding:10px 0 5px 10px;"><?php echo $v_designation->designation_name; ?></td>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo $value; ?></td>
				<?php if(!empty($designation_group_total1)) { $i=0; $total1=0; foreach ($designation_group_total1 as $key1 => $value1) { if ($key1 != 97) { $total1 = $total1+$value1;}
					if($key == $key1 && $key1 != 97) { $i=1;?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo $value1; ?></td>
				<?php } } if($i==0) { ?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo '-'; ?></td>
				<?php } }?>
				<?php $value4=0; if(!empty($designation_group_total3)) { $i=0; $total3=0; foreach ($designation_group_total3 as $key3 => $value3) { $total3 = $total3+$value3;
					if($key == $key3) {	$i=1;?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo $value4 = $value3; ?></td>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;" id="value5<?php echo $v_designation->designation_code;?>"><?php echo $value3; ?></td>
				<?php } } if($i==0) { ?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo '-'; ?></td>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;" id="value7<?php echo $v_designation->designation_code;?>"><?php echo '-'; ?></td>
				<?php } } else { ?>											
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo '-'; ?></td>
				<?php if(!empty($designation_group_total2)) { $k=0; $total2=0; foreach ($designation_group_total2 as $key2 => $value2) { $total2 = $total2+$value2;
					if($key == $key2) {	$k=1;?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo $value2;
				} } } else { ?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo '-'; ?></td>
				<?php } ?>
				<?php } ?>										
				
				<?php if(!empty($designation_group_total2)) { $k=0; $total2=0; foreach ($designation_group_total2 as $key2 => $value2) { $total2 = $total2+$value2;
					if($key == $key2) {	$k=1;?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo $value2;
				$value6 = $value2 - $value4;
				$old_total += $value6; if($value4!=0) {
				echo "<script>$('#value5".$v_designation->designation_code."').text($value6)</script>";
				} else {
				echo "<script>$('#value7".$v_designation->designation_code."').text($value6)</script>";
				}
				?></td>
				<?php } } if($k==0) { ?>
				<td style="padding:10px 10px 5px 10px;width:60px;text-align:right;"><?php echo '-'; ?></td>
				<?php } } ?>
			</tr>
			<?php } ?>			
		<?php } ?>			
	<?php } ?>
		   <tr>			
			   <td colspan="2" style="font-weight:bold;text-align:center;">Total</td>
			   <td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $total; ?></td>
			   <?php if(!empty($designation_group_total1)) { ?><td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $total1; ?></td><?php } ?>
			   <?php if(!empty($designation_group_total3)) { ?><td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $total3; ?></td><?php } else { ?>
			   <td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo '-'; ?></td><?php } ?>
			   <?php if(!empty($designation_group_total3)) { ?><td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $old_total; ?></td>
			   <?php } else if(!empty($designation_group_total2)) { ?>
			   <td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $total2; ?></td><?php } else { ?>
			   <td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo '-'; ?></td><?php } ?>
			   <?php if(!empty($designation_group_total2)) { ?><td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $total2; ?></td><?php } ?>
		   </tr>
		</tbody>
	</table>
	</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#date_within').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("desig_group_code").value="<?php echo e($desig_group_code); ?>";
});
//--></script>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$('[id^=Staff_Join_]').addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>