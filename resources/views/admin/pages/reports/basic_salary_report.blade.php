@extends('admin.admin_master')
@section('title', 'Basic Salary Wise Report')
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
					<form class="form-inline report" action="{{URL::to('/basic-salary-report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Basic Salary:</label>
						  <input type="text" class="form-control" name="basic_salary"  value="{{$basic_salary}}" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
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
	@if (!empty($all_result))
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
			<p><b>Basic Salary: <?php echo $basic_salary; ?></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">SL No.</th>
							<th rowspan="2">Staff Name</th>
							<th rowspan="2">ID No</th>
							<th rowspan="2">Designation</th>
							<th rowspan="2">Basic Effect Date</th>
							<th rowspan="2">Last Degree</th>
							<th rowspan="2">Joining Date(Org.)</th>
							<th colspan="2">Present Work Station</th>
							<th rowspan="2">Grade</th>
							<th rowspan="2">Basic (Tk)</th>
							<th rowspan="2">Total Pay(Tk)</th>
							<th rowspan="2">Net Pay(Tk)</th>
						</tr>
						<tr>
							<th>HO/BO Name</th>
							<th>Joining date</th>
						</tr>
					</thead>
					<tbody>
						{{!$i=1}} @foreach($all_result as $result)
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
							<td>{{$i++}}</td>
							<td>{{$result['emp_name_eng']}}</td>
							<td>{{$result['emp_id']}}</td>
							<td>{{$result['designation_name']}}</td>
							<td>{{$result['effect_date']}}</td>
							<td>{{$result['exam_name']}}</td>
							<td>{{$result['org_join_date']}}</td>
							<td>{{$result['branch_name']}}</td>
							<td>{{$result['br_join_date']}}</td>
							<td>{{$result['grade_name']}}</td>
							<td>{{$result['basic_salary']}}</td>
							<td><?php echo empty($result['total_pay']) ? $result['total_plus'] : $result['total_pay'];?></td>
							<td>{{round($net_pay)}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endif
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
		$("#Basic_Salary_Wise_Report").addClass('active');
	});
</script>
@endsection