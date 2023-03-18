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
<script>
function checkDelete() {
	var chk=confirm("Are you sure you want to delete!");
	if(chk) {
		return true;
	} else {
		return false;				
	}
	
}			
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
</section>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/unsettle-claim-report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email">Employee Type :</label>
							<select name="emp_type" id="emp_type" required class="form-control">
								@foreach ($all_emp_type as $emp_type1)
								<option value="{{$emp_type1->id}}">{{$emp_type1->type_name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">from date :</label>
						  <input type="text" id="from_date" class="form-control entry_date" name="from_date" size="10" value="{{$from_date}}" required autocomplete="off">
						</div>
						<div class="form-group">
						  <label for="pwd">to date :</label>
						  <input type="text" id="to_date" class="form-control entry_date" name="to_date" size="10" value="{{$to_date}}" required autocomplete="off">
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
	<?php if (!empty($result_info)) { ?>
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Unsettle Staff Advance</font></b></p>		
			</div>
			<br/>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>Employee ID</th>
							<th>Name</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Balance</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; $balance = 0; foreach($result_info as $result) { ?>
						<tr>
							<td><?php echo $result['emp_id']; ?></td>
							<td><?php echo $result['emp_name']; ?></td>
							<td style="text-align: right;"><?php echo ($result['debit_amt'] ==0) ? '' : $result['debit_amt'];?></td>
							<td style="text-align: right;"><?php echo ($result['credit_amt'] ==0) ? '' : $result['credit_amt'];?></td>
							<td style="text-align: right;"><?php echo $result['balance'];?></td>
							<td><a href="{{URL::to('/unsettle-statement/'.$result['emp_id'])}}" target="_blank">Details</a> ||
							<?php if ($result['debit_amt'] ==0 && $result['credit_amt'] ==0) { ?>
							<a href="{{URL::to('/unsettle-delete/'.$result['emp_id'])}}" onclick="return checkDelete();" style="color:red;">Delete</a>
							<?php } else { ?>
							<span style="color:gray;">Delete</span></td>
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
	$('.entry_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script>
	function LoadPage() {
		var transaction_type = document.getElementById("transaction_type").value;
		var emp_id = document.getElementById("emp_id").value;
		var incre_id = document.getElementById("incre_id").value;
		//alert(transaction_type);		
			$.ajax({
			url : "{{ url::to('get-page-info') }}"+"/"+ transaction_type+"/"+ emp_id+"/"+ incre_id,
			type: "GET",
			success: function(data)
			{
				//alert (data);
				$("#content_load").html(data);				
			}
		});
		
	}
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
		newWin.document.write("<style> th:nth-child(6){display:none;} </style>");
		newWin.document.write("<style> td:nth-child(6){display:none;} </style>");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
		location.reload();
    }
</script>
@endsection