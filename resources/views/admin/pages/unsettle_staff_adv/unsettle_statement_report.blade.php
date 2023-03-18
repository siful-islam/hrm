@extends('admin.admin_master')
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
.noborder{
	border: none;
}
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->

<!--<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
</section> -->
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report">
						<div class="form-group">
							<label for="email">Unsettle Statement :</label>
						</div>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if (!empty($all_result)) { 
	$transaction = array('1' => "Cash", '2' => "Payroll", '3' => "Transfer", '4' => "Adjustment", '5' => "Unsettle Claim", '6' => "Payment", '7' => "Khudra jhuki", '8' => "Resedule");
	?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Unsettle Staff Advance</font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table" cellspacing="0">
					<tbody>
						<tr>
							<td style="border: none;">Employee ID : <?php echo $result_info->emp_id; ?></td>
							<td style="border: none;">Employee Name : <?php echo $result_info->emp_name_eng; ?></td>
						</tr>
						<tr>
							<td style="border: none;">Designation : <?php echo $result_info->designation_name; ?></td>
							<td style="border: none;">Branch : <?php echo $result_info->branch_name; ?></td>
						</tr>
						<tr>
							<td style="border: none;">Total Amount : <?php echo $result_info->total_amount; ?></td>
							<td style="border: none;">Claim date : <?php echo date('d-m-Y',strtotime($result_info->claim_date)); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>Date</th>
							<th>Narration</th>
							<th>Transaction Type</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Balance</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; $balance = 0; $length = count($all_result); foreach($all_result as $result) { $i++;
						$debit_amt = isset($result->debit_amt) ? $result->debit_amt : 0;
						$credit_amt = isset($result->credit_amt) ? $result->credit_amt : 0;
						if(isset($result->transfer_emp_id)) {
							$transfer_emp = '-(transfer to : '.$result->transfer_emp_id.'-'.$result->emp_name_eng.')';
						} else if (isset($result->transfer_from_emp_id)) {
							$transfer_emp = '-(transfer from : '.$result->transfer_from_emp_id.'-'.$result->emp_name.')';
						}
						//$transfer_emp = isset($result->transfer_emp_id) ? '-(transfer to : '.$result->transfer_emp_id.'-'.$result->emp_name_eng.')' : '';
						
						$balance += $debit_amt - $credit_amt;
						?>
						<tr>
							<td><?php echo date('d-m-Y',strtotime($result->claim_date)); ?></td>
							<td><?php echo ($result->transaction_type == 3) ? $result->comments.$transfer_emp : $result->comments; ?></td>
							<?php foreach ($transaction as $id => $val) { 
							if ($id == $result->transaction_type) { ?>
							<td><?php echo $val; ?></td>
							<?php } } ?>
							<td style="text-align: right;"><?php echo ($debit_amt ==0) ? '' : $debit_amt;?></td>
							<td style="text-align: right;"><?php echo ($credit_amt ==0) ? '' : $credit_amt;?></td>
							<td style="text-align: right;"><?php echo $balance;?></td>
							<?php if ($i == $length) { ?>
							<td><a href="{{URL::to('/unsettle-edit/'.$result->emp_id)}}" >Edit</a></td>
							<?php } else { ?>
							<td>-</td>
							<?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
</section>
<script>
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script>
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table > tbody > tr > td {' +
			'font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered th {' +
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
@endsection