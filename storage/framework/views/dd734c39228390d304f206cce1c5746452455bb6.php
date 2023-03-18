<?php $__env->startSection('title', 'Final Clearence Report'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content-header {
    padding-top: 5px;
}
.content-header > .breadcrumb {
	padding: 2px 7px;
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
.form-group {
    margin-bottom: 2px;
}

blink {
    animation: 1s linear infinite condemned_blink_effect;
	color: #900C3F;
	font-weight: bold;
	font-size: 16px;
}
@keyframes  condemned_blink_effect {
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Final Clearence Report</li>
	</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report">
						<div class="form-group">
							<label for="email">Final Clearence Report :</label>
						</div>
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
				<b><font size="4">Final Clearence Report </font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Employee ID</th>
							<th>Employee Name</th>
							<th>Designation</th>
							<th>Branch</th>
							<th>Resign Date</th>
							<th>FC Date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach($all_result as $result) { ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $result['emp_id']; ?></td>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<td><?php echo $result['designation_name']; ?></td>
							<td><?php echo $result['branch_name']; ?></td>
							<td><?php echo date("d M Y", strtotime($result['effect_date'])); ?></td>
							<td><?php echo date("d M Y", strtotime($result['ed_effect_date'])); ?></td>
							<td><a>Pending</a></td>
						</tr>
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
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
		$("#FC_Reports").addClass('active');
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>