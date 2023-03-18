<?php $__env->startSection('title', 'Reports|All Staff Report'); ?>
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
<!------export to excel file------->	
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.table2excel.js')); ?>"></script>
<!------export to excel file------->
<!-- Content Header (Page header) -->
<br/>
<br/>
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
	
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/all-blood-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						
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
							<label for="email">Branch Type:</label>
							<select name="branch_type" id="branch_type" required class="form-control">
								<option value="">Select</option>								
								<option value="all" <?php if (@$branch_type=='all') echo 'selected'; ?>>All</option>
								<option value="9999" <?php if (@$branch_type==9999) echo 'selected'; ?>>Head Office</option>
								<option value="1" <?php if (@$branch_type==1) echo 'selected'; ?>>Branch Office</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Blood Group:</label>
							<select name="blood_group" id="blood_group" class="form-control" required>
								<option value="">Select</option>
								<option value="all" <?php if (@$blood_group=='all') echo 'selected'; ?>>All</option>	
								<option value="A+" <?php if (@$blood_group=='A+') echo 'selected'; ?>>A+</option>
								<option value="A-" <?php if (@$blood_group=='A-') echo 'selected'; ?>>A-</option>
								<option value="B+" <?php if (@$blood_group=='B+') echo 'selected'; ?>>B+</option>
								<option value="B-" <?php if (@$blood_group=='B-') echo 'selected'; ?>>B-</option>
								<option value="AB+" <?php if (@$blood_group=='AB+') echo 'selected'; ?>>AB+</option>
								<option value="AB-" <?php if (@$blood_group=='AB-') echo 'selected'; ?>>AB-</option>
								<option value="O+" <?php if (@$blood_group=='O+') echo 'selected'; ?>>O+</option>
								<option value="O-" <?php if (@$blood_group=='O-') echo 'selected'; ?>>O-</option>
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
	<?php if(!empty($all_result)): ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Blood Group Report </font></b></p>		
			</div>
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Staff Name</th>						
							<th rowspan="2">Staff Name (in Bengali)</th>						
							<th rowspan="2">ID No</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Date Of Birth</th>
							<th rowspan="2">Blood Group</th>
							<th rowspan="2">Work Station</th>
							<th rowspan="2">Area Name</th>		
							<th rowspan="2">Permanent Address</th>							
						</tr>
						<tr>
					
				</tr>
					</thead>
					<tbody>
						<?php echo e(!$i=1); ?> <?php $__currentLoopData = $all_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($result['emp_name_eng']); ?></td>							
							<td><?php echo e($result['emp_name_ban']); ?></td>
							<td><?php echo $result['emp_id']; ?></td>
							<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?>
							</td>
							<td><?php echo e(date('d-m-Y', strtotime($result['birth_date']))); ?></td>
							<td><?php echo e($result['blood_group']); ?></td>
							<td><?php if (empty($result['asign_branch_name'])) { echo $result['branch_name']; } else { echo $result['asign_branch_name']; } ?></td>
							
							
							<td><?php if (empty($result['asign_area_name'])) { echo $result['area_name']; } else { echo $result['asign_area_name']; } ?></td>
							
							<td><?php echo e($result['permanent_add']); ?></td>
							
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
            $("#tblExport").table2excel({
                exclude:".noExl",
				name:"All Staff List",
				filename:"all_staff_list",
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
		$("#All_Staff_List").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>