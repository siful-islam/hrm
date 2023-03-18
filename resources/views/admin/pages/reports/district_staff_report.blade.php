@extends('admin.admin_master')
@section('title', 'District Staff Report')
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
					<form class="form-inline report" action="{{URL::to('/district-staff-report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email">District Name :</label>
							<select class="form-control" id="district_code" name="district_code" required>						
								<option value="" >-Select-</option>
								@foreach ($all_district as $v_district)
								<option value="{{$v_district->district_code}}">{{$v_district->district_name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="email">Status :</label>
							<select name="status" id="status" required class="form-control">
								<option value="" >Select</option>
								<option value="1" <?php if($status==1) echo 'selected'; ?> >Running</option>
								<option value="2" <?php if($status==2) echo 'selected'; ?> >Cancel</option>
							</select>
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
	@if (!empty($all_result))
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">District-Wise Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
			@foreach ($all_district as $v_district)
				<?php if($v_district->district_code == $district_code) { ?>
				<p><b>District Name: <?php echo $v_district->district_name; ?></b></p>
				<?php } ?>
				@endforeach			
			</div>		
			<div class="col-md-12">
				<?php $total_record = 1; foreach ($all_thana as $v_thana) {
				$i=1; foreach($all_result as $result) { 
				if($result['thana_code'] == $v_thana->thana_code) { 
				if($i==1) { ?>
				<p><b>Thaha Name: </b><?php echo $v_thana->thana_name; ?></p>
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2" style="width:2%;">SL No.</th>
							<th rowspan="2" style="width:3%;">ID No</th>
							<th rowspan="2" style="width:10%;">Staff Name</th>
							<th rowspan="2" style="width:10%;">Father's Name</th>
							<th rowspan="2" style="width:10%;">Designation</th>
							<th rowspan="2" style="width:5%;">Joining Date(Org.)</th>
							<th colspan="2" style="width:20%;text-align: center;">Present Work Station</th>
							<th rowspan="2" style="width:3%;">Basic (tk)</th>
							<th rowspan="2" style="width:30%;">Permanent Address</th>
							<th rowspan="2" style="width:3%;">Status</th>
						</tr>
						<tr>
							<th style="width:7%;">HO/BO Name</th>
							<th style="width:7%;">Joining date</th>
						</tr>
					</thead>
					<?php } ?>
					<tbody>
						<tr>
							<td>{{$i}}</td>
							<td>{{$result['emp_id']}}</td>
							<td>{{$result['emp_name_eng']}}</td>
							<td>{{$result['father_name']}}</td>
							<td>{{$result['designation_name']}}</td>
							<td>{{$result['org_join_date']}}</td>
							<td>{{$result['branch_name']}}</td>
							<td>{{$result['br_join_date']}}</td>
							<td>{{$result['basic_salary']}}</td>
							<td>{{$result['permanent_add']}}</td>
							<td>Running</td>
						</tr>
						<?php $i++; } ?>  
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
		</div>
		<div class="col-md-12"><p align="right">Total Records: <?php echo count ($all_result); ?></p></div>
	@endif
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	document.getElementById("district_code").value="{{$district_code}}";
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
		$("#District_Wise_Staff").addClass('active');
	});
</script>
@endsection