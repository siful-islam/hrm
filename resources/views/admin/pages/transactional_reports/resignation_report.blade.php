@extends('admin.admin_master')
@section('title', 'Resignation Staff Report')
@section('main_content')
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
	<h1><small>{{$Heading}}</small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/resignation-report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Date From:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Date To:</label>
						  <input type="text" id="to_date" class="form-control" name="to_date" size="10" value="{{$to_date}}" required>
						</div>
						<div class="form-group">
							<label for="email">Resigned By :</label>
							<select name="resigned_by" id="resigned_by" required class="form-control">
								<option value="All" <?php if($resigned_by=="All") echo 'selected'; ?> >All</option>
								<option value="Self" <?php if($resigned_by=="Self") echo 'selected'; ?> >Self</option>
								<option value="Ogranization" <?php if($resigned_by=="Ogranization") echo 'selected'; ?> >Ogranization</option>
								<option value="Termination" <?php if($resigned_by=="Termination") echo 'selected'; ?> >Termination</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Order By :</label>
							<select name="order_by" id="order_by" required class="form-control">
								<option value="designation" <?php if($order_by=="designation") echo 'selected'; ?> >Designation</option>
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
	@if (!empty($all_result))
		<div id="printme">		
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Resignation Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<?php if($order_by == 'emp_id') { ?>
					<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Joining Date (Org.)</th>
							<th>Grade</th>
							<th>Work Station</th>
							<th>Area</th>
							<th>Resign Effect date</th>
							<th>Job Duration</th>
							<th>Thana</th>
							<th>District</th>
							<th>Remarks</th>
							<th>File Status</th>
							<th>Job Duration</th>
							<th>Termination Stage</th>
						</tr>
					</thead>
					<?php $i=1; foreach($all_result as $result) { ?>
					<tbody>
						<tr>
							<td>{{$i++}}</td>
							<td>{{$result['emp_id']}}</td>
							<td>{{$result['emp_name_eng']}}</td>
							<td>{{$result['designation_name']}}</td>
							<td><?php echo date('d M Y',strtotime($result['org_join_date'])); ?></td>
							<td>{{$result['grade_name']}}</td>
							<td>{{$result['branch_name']}}</td>
							<td>{{$result['area_name']}}</td>
							<td><?php echo date('d M Y',strtotime($result['effect_date'])); ?></td>
							<td><?php 
								$org_join_date = new DateTime($result['org_join_date']); 
								$effect_date = new DateTime($result['effect_date']); 
								$diff = $org_join_date->diff($effect_date); 
								echo $diff->format('%y Year %m Month %d Day'); 
								?>
							</td>
							<td>{{$result['thana_name']}}</td>
							<td>{{$result['district_name']}}</td>
							<td>{{$result['terminate_by']}}</td>
							<td><?php if($result['fp_status'] > 0) { echo '<span style="color:#F70408"> Settled </span>'; } 
								else if($result['file_status'] > 0) { echo '<span style="color:#2733d1">Under Process </span>'; }			
								else { echo '-'; }
							?></td>
							<td>{{$result['days']}}</td>
							<td>{{$result['staff_status']}}</td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
				
				<?php } else { ?>
				
				<?php $total_record = 1; foreach ($all_designation as $designation) {
				$i=1; foreach($all_result as $result) { 
				if($result['designation_code'] == $designation->designation_code) { 
				if($i==1) { ?>
				<p><b>Designation Name: </b><?php echo $designation->designation_name; ?></p>
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Joining Date (Org.)</th>
							<th>Grade</th>
							<th>Work Station</th>
							<th>Area</th>
							<th>Resign Effect date</th>
							<th>Job Duration</th>
							<th>Thana</th>
							<th>District</th>
							<th>Remarks</th>
							<th>File Status</th>
							<th>Job Duration</th>
							<th>Termination Stage</th>
						</tr>
					</thead>
					<?php } ?>
					<tbody>
						<tr>
							<td>{{$i}}</td>
							<td>{{$result['emp_id']}}</td>
							<td>{{$result['emp_name_eng']}}</td>
							<td>{{$result['designation_name']}}</td>
							<td><?php echo date('d M Y',strtotime($result['org_join_date'])); ?></td>
							<td>{{$result['grade_name']}}</td>
							<td>{{$result['branch_name']}}</td>
							<td>{{$result['area_name']}}</td>
							<td><?php echo date('d M Y',strtotime($result['effect_date'])); ?></td>
							<td><?php 
								$org_join_date = new DateTime($result['org_join_date']); 
								$effect_date = new DateTime($result['effect_date']); 
								$diff = $org_join_date->diff($effect_date); 
								echo $diff->format('%y Year %m Month %d Day'); 
								?>
							</td>
							<td>{{$result['thana_name']}}</td>
							<td>{{$result['district_name']}}</td>
							<td>{{$result['terminate_by']}}</td>
							<td><?php if($result['fp_status'] > 0) { echo '<span style="color:#F70408"> Settled </span>'; } 
								else if($result['file_status'] > 0) { echo '<span style="color:#2733d1">Under Process </span>'; }
								else { echo '-'; }
							?></td>
							<td>{{$result['days']}}</td>
							<td>{{$result['staff_status']}}</td>
						</tr>
						<?php $i++; } ?>  
						<?php } ?>
					</tbody>
				</table>
				<?php } } ?>
			</div>
		</div>
		<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
	@endif
	</div>
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
		$("#Resignation_Staff").addClass('active');
	});
</script>
@endsection