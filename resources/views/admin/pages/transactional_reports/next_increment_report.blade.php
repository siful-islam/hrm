@extends('admin.admin_master')
@section('title', 'Next Increment Report')
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
					<form class="form-inline report" action="{{URL::to('/next-incre-report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Increment Date :</label>
						  <input type="text" id="to_date" class="form-control" name="to_date" size="10" value="{{$increment_date}}" required>
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
	@if (!empty($all_result))
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Next Increment Staff</font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Increment Date</th>
							<th>Letter date</th>
							<th>Employee ID</th>
							<th>Staff Name</th>
							<th>Designation</th>
							<th>Effect date</th>
							<th>Grade</th>
							<th>Next Grade Step</th>
							<th>Workstation</th>
						</tr>
					</thead>
					<tbody> <?php $red = 0; ?>
						{{!$i=1}} @foreach($all_result as $result)
						<tr>
							<td>{{$i++}}</td>
							<td><?php echo date('d M Y',strtotime($result['next_increment_date'])); ?></td>
							<td><?php echo date('d M Y',strtotime($result['letter_date'])); ?></td>
							<?php if(!empty($result['increment_marked'])) { ?>
							<td style="background:#ED2225;color:#fff;"><?php  echo $result['emp_id']; ?><br>(Redmarked)</td>
							<?php } else { ?>
							<td><?php  echo $result['emp_id']; ?></td>
							<?php } ?>
							<?php if(!empty($result['promotion_increment_marked'])) { ?>
							<td style="background:#50d6a1;color:#fff;"><?php echo $result['emp_name_eng']; ?><br>(Marked)</td>
							<?php } else { ?>
							<td><?php echo $result['emp_name_eng']; ?></td>
							<?php } ?>
							<td>{{$result['designation_name']}}</td>
							<td><?php echo date('d M Y',strtotime($result['effect_date'])); ?></td>
							<td>{{$result['grade_name']}}</td>
							<td>{{$result['grade_step']}}</td>
							<td>{{$result['branch_name']}}</td>
						</tr>					
						
						<?php 
						$emp_id = $result['emp_id'];
						
						?>
						
						
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
		$("#Next_Increment_Report").addClass('active');
	});
</script>
@endsection