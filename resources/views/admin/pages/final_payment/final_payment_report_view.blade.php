@extends('admin.admin_master')
@section('title', 'Final Payment')
@section('main_content')
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
	padding: 2px 5px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px 5px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
h4 {
	font: 16px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<?php
function getBanglaDate($date){
 $engArray = array(1,2,3,4,5,6,7,8,9,0);
 $bangArray = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
 
 $convert = str_replace($engArray, $bangArray, $date);
 return $convert;
}
 
$date = date('d-m-Y',strtotime($form_date));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Final Payment</li>
	</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/final-payment')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Employee ID:</label>
						  <input type="text" class="form-control" name="emp_id" size="10" value="{{$emp_id}}" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Payment Type:</label>
						  <select class="form-control" id="payment_type" name="payment_type" required>						
							<option value="" >-Select-</option>
							<option value="1" >Final Payment</option>
							<option value="2" >PF Payment</option>
						  </select>	
						</div>
						<div class="form-group">
						  <label for="pwd">Date:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
						</div>					
						<button type="submit" class="btn btn-primary" onclick="dateRange();">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<!-- ‍Start Provident Fund Payment Statement-->
	<div class="row">
		<div id="printme">
			<div class="col-md-10 col-md-offset-1">
				<div style="text-align:center;">
					<h4 style="margin-top:4px;"><u>Provident Fund Payment Statement</u></h4>
				</div>
				<table class="table table-striped" style="margin-bottom: 10px;">
					<tbody>
						<tr>
							<td style="border-style:none;"></td>
							<td style="text-align:right;border-style:none;">Date : <?php echo date('d-M-Y');?></td>
						</tr>
						<tr>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.4;">
									Name : <br/>
									Designation : <br/>
									Name of Branch : 
								</p>
							</td>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.4;">
									<br/>ID No. : 								
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th> &nbsp;&nbsp;Sl. No</th>
								<th><center>Description</center></th>
								<th> &nbsp;&nbsp;Account</th>
								<th><center>Amount (Tk)</center></th>
							<tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td>Final Payment</td>
								<td><b>Payable to Staff :</b></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Bank Asia Ltd, STD - 05536000011</td>
								<td>Staff Own Contribution, Provident Fund</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td>Cheque No.: 842230</td>
								<td>Organization Contribution, Provident Fund</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td>Cheque Date: 15-04-2018</td>
								<td></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td>PV No.: 1434</td>
								<td></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><b>Total (A)</b></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><b>Receivable from Staff</b></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>PF Loan</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>Non-Payable</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><b>Total (B)</b></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td colspan="3"><center><b>Net Payable/Receivable to Staff (A - B)</b></center></td>
								<td><center>-</center></td>
							</tr>
						</tbody>	
					</table>
					<p>
						<b>Taka In Word :</b>
					</p>
					<p style="padding-top:50px;">
						Prepared By
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- ‍Start Gratuity Payment Statement-->
	<div class="row">
		<div id="printme">
			<div class="col-md-10 col-md-offset-1">
				<div style="text-align:center;">
					<h4 style="margin-top:4px;"><u>Gratuity Payment Statement</u></h4>
				</div>
				<table class="table table-striped" style="margin-bottom: 10px;">
					<tbody>
						<tr>
							<td style="border-style:none;"></td>
							<td style="text-align:right;border-style:none;">Date : <?php echo date('d-M-Y');?></td>
						</tr>
						<tr>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.4;">
									Name : <br/>
									Designation : <br/>
									Name of Branch : 
								</p>
							</td>
							<td style="border-style:none;padding-top:10px;">
								<p style="font-size: 14px;line-height: 1.4;">
									<br/>ID No. : 								
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th> &nbsp;&nbsp;Sl. No</th>
								<th><center>Description</center></th>
								<th> &nbsp;&nbsp;Account</th>
								<th><center>Amount (Tk)</center></th>
							<tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td>Final Payment (Gratuity)</td>
								<td><b>Payable to Staff : 11 Years 11 Month</b></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Bank Asia Ltd, STD - 05536000011</td>
								<td>11 (Eleven) Years (13125*2*11)</td>
								<td><center>288750</center></td>
							</tr>
							<tr>
								<td></td>
								<td>Cheque No.: 842230</td>
								<td>11 (Eleven) Months (13125*2*11)/12</td>
								<td><center>24063</center></td>
							</tr>
							<tr>
								<td></td>
								<td>Cheque Date: 15-04-2018</td>
								<td>Unclaimed Account</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td>PV No.: 1434</td>
								<td></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><b>Total (A)</b></td>
								<td><center>312813</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><b>Receivable from Staff</b></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>Gratuity Loan</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>Unsettled Staff Advance</td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><b>Total (B)</b></td>
								<td><center>-</center></td>
							</tr>
							<tr>
								<td colspan="3"><center><b>Net Payable/Receivable to Staff (A - B)</b></center></td>
								<td><center>312813</center></td>
							</tr>
						</tbody>	
					</table>
					<p>
						<b>Taka In Word :</b>
					</p>
					<p style="padding-top:50px;">
						Prepared By
					</p>
				</div>
			</div>
		</div>
	</div>
	
</section>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
	document.getElementById("payment_type").value="{{$payment_type}}";
});
//--></script>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-striped p {' +
			'font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered th {' +
			'border:1px solid #757070;padding:4px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:4px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
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
		$("#MainGroupSalary_Info").addClass('active');
		$("#Final_Payment").addClass('active');
	});
</script>
@endsection