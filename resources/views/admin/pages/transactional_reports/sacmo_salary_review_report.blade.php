@extends('admin.admin_master')
@section('title','Salary Review Report SACMO')
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
					<form class="form-inline report" action="{{URL::to('/sacmo-salary-review-report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Date Within:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
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
	@if (!empty($all_nonid_emp))
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Salary review report for SACMO</font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>ID No</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Joining Date (Org.)</th>
							<th>Total Salary</th>
							<th>Salary Effect date</th>
							<th>Salary Duration</th>
							<th>Branch join date</th>
							<th>Branch</th>
						</tr>
					</thead>
					<tbody>
						{{!$i=1}} @foreach($all_nonid_emp as $result)
						<?php date_default_timezone_set('Asia/Dhaka');
							$input_date = new DateTime($form_date);
							$org_date = new DateTime($result->effect_date);	
							$difference = date_diff($org_date, $input_date);
							if ($difference->y >= 1) { ?>
						<tr>
							<td>{{$i++}}</td>
							<td>{{$result->sacmo_id}}</td>
							<td>{{$result->emp_name}}</td>
							<td>{{$result->designation_name}}</td>
							<td><?php echo date('d M Y',strtotime($result->joining_date)); ?></td>
							<td>{{$result->gross_salary}}</td>
							<td><?php echo date('d M Y',strtotime($result->effect_date)); ?></td>
							<td><?php								
								echo $difference->y . " years, " . $difference->m." months, ".$difference->d." days ";
								 ?>
							</td>
							<td>{{date('d M Y',strtotime($result->br_join_date))}}</td>						
							<td>{{$result->branch_name}}</td>
						</tr>
							<?php } ?>
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
 $(document).ready(function(){
	 $('#MainGroupContractual').addClass('active');
	 $('#Salary_review_report').addClass('active');
 });
</script>
@endsection