
<?php $__env->startSection('title', 'Staff Strength-Org. Report'); ?>
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
					<form class="form-inline report" action="<?php echo e(URL::to('/staff-info-glance')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="email">Employee Group :</label>
							<select name="emp_group" id="emp_group" required class="form-control">
								<option value="">Select</option>
								<?php foreach ($all_emp_group as $empgroup) { ?>
								<option value="<?php echo $empgroup->id; ?>"><?php echo $empgroup->group_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Designation Group Name :</label>
							<select style="width:200px;" class="form-control" id="desig_group_code" name="desig_group_code" required>						
								<option value="" >-Select-</option>
								<option value="all" >All</option>
								<?php $__currentLoopData = $designation_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desig_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($desig_group->desig_group_code); ?>"><?php echo e($desig_group->desig_group_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
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
				<p align="center"><b><font size="3">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="3">Staff Strength-Organization Report</font></b><?php echo ' ( as on'.' '.date("d-m-Y", strtotime($date_within)).')'; ?></p>		
			</div>
			<div class="col-md-6 col-md-offset-3">
			<?php $__currentLoopData = $designation_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desig_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($desig_group->desig_group_code == $desig_group_code) { ?>
				<p style="margin-left:15px;"><b>Designation Group Name: </b><?php echo $desig_group->desig_group_name; ?> 
				</p>
				<?php } ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<p style="margin-left:15px;"><b>Employee Group:</b> <?php if ($emp_group==1) { echo 'Regular';} else if ($emp_group==2) { echo 'Contractual';} else if ($emp_group==3) { echo 'Volunteer';}?><span style="float:right">Print Date: <?php echo date("d-m-Y"); ?></span></p>
			</div>		
			<div class="col-md-12">
				<div align="center">
					<table style="width:700px;" border="1" cellspacing="0"> 
						<tbody>
							<tr>
								<th><div style="padding:10px 0 5px 10px;">SL No.</div></th>
								<th><div style="padding:10px 0 5px 10px;">Designation Group</div></th>
								<th><div style="padding:10px 0 5px 10px;">Designation</div></th>
								<th><div style="padding:10px 0 5px 10px;">No. of Staff</div></th>
								<th><div style="padding:10px 0 5px 10px;">Total Number</div></th>
							</tr>
							<?php $j=1; foreach($designation_group as $desig_group) { ?> 				
							<?php if(!empty($all_result)){ 
							$i=1;$k=1; $total_qty=0;$totalqty=0;
							$array = json_decode(json_encode($all_result), true);
							foreach($all_result as $result){
							$total_qty += $result['designation_value'];
							if($result['designationgroup_code'] == $desig_group->desig_group_code){
							$totalqty += $result['designation_value'];
							if($i==1) {
								$k=1;
								$count_array = array_count_values(array_column($array,'designationgroup_code'))[$result['designationgroup_code']];									
							?>
							<tr> 
								<td rowspan="<?php echo $count_array; ?>" style="vertical-align: middle; padding-left:10px;"><?php echo $j++;?></td>
								<td rowspan="<?php echo $count_array; ?>" style="vertical-align: middle; padding-left:10px;"><?php echo $desig_group->desig_group_name;?></td>
								<td style="padding:10px 0 5px 10px;"><?php echo $result['designation_name']; ?></td>
								<td style="text-align:right;padding-right:10px;"><?php echo $result['designation_value']; ?></td>
								<td rowspan="<?php echo $count_array; ?>" style="vertical-align: middle;text-align:center;"><span id="td_row_id<?php echo $desig_group->desig_group_code; ?>" ></span></td>	
							</tr>
                            <?php 
							if($count_array == $k) { ?>
							<script>
								document.getElementById("td_row_id<?php echo $desig_group->desig_group_code; ?>").innerText =<?php echo $totalqty; ?>;
							</script>
							<?php } ?>
							<?php $i++; } else { ?>
							<tr> 
								<td style="padding:10px 0 5px 10px;"><?php echo $result['designation_name']; ?></td>
								<td style="text-align:right;padding-right:10px;"><?php echo $result['designation_value']; ?></td>
							</tr>
							<?php 
							if($count_array == $k) { ?>
							<script>
								document.getElementById("td_row_id<?php echo $desig_group->desig_group_code; ?>").innerText =<?php echo $totalqty; ?>;
							</script>
							<?php $totalqty =0; } } ?>
							<?php $k++; } } } ?>					
							<?php } ?>		   
							<tr>			
								<td colspan="3" style="font-weight:bold;text-align:center;">Total</td>
								<td style="padding:10px 10px 5px 10px;text-align:right;"><?php echo $total_qty; ?></td>
								<td style="padding:10px 10px 5px 10px;text-align:center;"><?php echo $total_qty; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<script>
	$(document).on("change", "#emp_group", function () {
		var emp_group = $(this).val();   
		//if(!(emp_group == 1 || emp_group == 2)) {
		//alert(emp_group);
			$.ajax({
			url : "<?php echo e(url::to('emp_type_designation_group')); ?>"+"/"+emp_group,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#desig_group_code").html(data); 
				 
			}
			});
		//} 	 
	}); 
</script>
<script>
$(document).ready(function() {
	$('#date_within').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("emp_group").value="<?php echo e($emp_group); ?>";
	document.getElementById("desig_group_code").value="<?php echo e($desig_group_code); ?>";
});
</script>
<script>
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
			$("#MainGroupService_Length_Reports").addClass('active');
			$("#Staff_Strength-Org_Report").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>