@extends('admin.admin_master')
@section('title', 'Grade Wise Service Length Report')
@section('main_content')
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
	<h1><small>{{$Heading}}</small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/grade-service-length')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email">Grade Name :</label>
							<select class="form-control" id="grade_code" name="grade_code" required>						
								<option value="" >-Select-</option>
								<option value="all" >All</option>
								@foreach ($all_grade as $grade)
								<option value="{{$grade->grade_code}}">{{$grade->grade_name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
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
						<div class="form-group">
							<a href="{{URL::to('/demotion-report')}}" target="_blank" class="btn btn-success" type="button"> Demotion Staff Report</a>
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
				<b><font size="4">Grade-Wise Service Length</font></b></p>		
			</div>
			<div class="col-md-12">
				<?php if($grade_code == 'all' && $order_by == '') { ?>
				<?php $total_record = 0; foreach ($all_grade as $grade) {
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
							<th>Grade</th>
							<th>Grade (effect date)</th>
							<th>Service Length</th>
							<th>Last Degree</th>							
							<th>Work Station</th>
							<th>Staff type</th>
							<th>Is Promotion</th>
						</tr>
					</thead>
					<?php } ?>
					<tbody>
						<tr>
							<td>{{$i}}</td>
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
							<td style="background:#008000;color:white;"><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?></td>
							<?php } else { ?>
							<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?>
							</td>
							<?php } ?>
							<td>{{$result['org_join_date']}}</td>
							<td>{{$result['grade_name']}}</td>
							<td>{{$result['grade_effect_date']}}<?php if(!empty($result['incharge_as'])) { echo '<span style="color:#F70408"><b> ('.$result['incharge_as'].')</b></span> '; } ?></td>
							<td><?php 
								date_default_timezone_set('UTC');
								$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
								$input_date = new DateTime($input_date1);
								$org_date = new DateTime($result['grade_effect_date']);	
								$difference = date_diff($org_date, $input_date);
								echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								 ?></td>
							<td>{{$result['exam_name']}}</td>							
							<td>{{$result['branch_name']}}</td>
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
					<?php $total = $i-1; 
					if($total>0){ ?>
					<div class="col-md-12"><p align="right">Total Records: <?php echo $total_record +=$total;?></p></div>
					<?php } ?>
				<?php } } elseif(($grade_code == 'all' && $order_by == 'emp_id') || ($grade_code != 'all')) { ?>					
					<?php if($grade_code == 'all') {
						echo '<p><b>Grade: All</p>';
					} else {
						foreach ($all_grade as $grade) { 
							if($grade_code == $grade->grade_code) {
								echo '<p><b>Grade:' . $grade->grade_name;'</p>';
							}
						}
					}
					?>					
					<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Joining Date (Org.)</th>
							<th>Grade</th>
							<th>Grade (effect date)</th>
							<th>Service Length</th>
							<th>Last Degree</th>							
							<th>Work Station</th>
							<th>Staff type</th>
							<th>Is Promotion</th>
							<th>Censure</th>
							<th>Strong Warning</th>
							<th>Warning</th>
							<th>Fine</th>
							<th>Explanation</th>
							<th>Fine Amount</th>
						</tr>
					</thead>
					<?php $i=1; foreach($all_result as $result) { ?>
					<tbody>
						<tr>
							<td>{{$i++}}</td>
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
							<td style="background:#008000;color:white;"><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?></td>
							<?php } else { ?>
							<td><?php if((!empty($result['assign_designation'])) && ($result['assign_open_date'] <= $form_date)) {
									echo $result['assign_designation']; } else {
									echo $result['designation_name']; 
									} ?></td>
							<?php } ?>
							<td>{{$result['org_join_date']}}</td>
							<td>{{$result['grade_name']}}</td>
							<td>{{$result['grade_effect_date']}}<?php if(!empty($result['incharge_as'])) { echo '<span style="color:#F70408"><b> ('.$result['incharge_as'].')</b></span> '; } ?></td>
							<td><?php 
								date_default_timezone_set('UTC');
								$input_date1 = date('Y-m-d', strtotime("+1 day", strtotime($form_date)));
								$input_date = new DateTime($input_date1);
								$org_date = new DateTime($result['grade_effect_date']);	
								$difference = date_diff($org_date, $input_date);
								echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								 ?></td>
							<td>{{$result['exam_name']}}</td>							
							<td>{{$result['branch_name']}}</td>
							<td><?php if($result['is_permanent'] == '1') {
								echo 'Probation'; } else {
								echo 'Permanent'; } ?>
							</td>
							<td><?php if($result['total']){ echo 'Yes'. ' - ' . $result['total']; } else { echo 'No  - 0';}?></td>
							<td>{{$result['total_censure']}}</td>
							<td>{{$result['total_strong_warning']}}</td>
							<td>{{$result['total_warning']}}</td>
							<td>{{$result['total_fine']}}</td>
							<td>{{$result['total_explanation']}}</td>
							<td>{{$result['total_fine_amount']}}</td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
				<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
				<?php } ?>
			</div>
		</div>
	@endif
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("grade_code").value="{{$grade_code}}";
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
			$("#Grade-Wise_Service_Length").addClass('active');
		});
	</script>
@endsection