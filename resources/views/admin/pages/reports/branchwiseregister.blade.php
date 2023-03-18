@extends('admin.admin_master')
@section('title', 'Reports|All Staff Report')
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
<!------export to excel file------->	
<script type="text/javascript" src="{{asset('public/scripts/jquery.table2excel.js')}}"></script>
<!------export to excel file------->
<!-- Content Header (Page header) -->
<br/>
<br/>
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
	<!--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">All Staff List</li>
	</ol>-->
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					 <form class="form-inline report" action="{{URL::to('/branch_wise_register_post')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
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
	 @if (!empty($all_result))
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Staff List</font></b></p>		
			</div>
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Branch Code(HRM)</th>						
							<th>Branch Name</th>						
							<th>FO</th>
							<th>MEDO</th>
							<th>AC</th> 
							<th>Total</th> 
						</tr> 
					</thead>
					<tbody>
					<?php 
						 $i=1; 
						 $total_fo = 0;
						 $total_Medo = 0;
						 $total_Acc = 0;
						 foreach($all_result as $result){
							$total_fo += $result->FO + $result->JFO;
							$total_Medo += $result->Medo;
							$total_Acc += $result->Acc;
							 ?>
						<tr>
							<td>{{$i++}}</td> 
							<td>{{$result->main_br_code}}</td> 
							<td>{{$result->branch_name}}</td> 
							<td>{{$result->FO + $result->JFO}}</td> 
							<td>{{$result->Medo}}</td> 
							<td>{{$result->Acc}}</td> 
							<td>{{$result->FO + $result->JFO + $result->Medo + $result->Acc }}</td> 
						</tr>
						<?php 
						 }
						?>
						<tr>
							<td colspan="3">Total </td>  
							<td>{{$total_fo}}</td> 
							<td>{{$total_Medo}}</td> 
							<td>{{$total_Acc}}</td> 
							<td>{{$total_fo + $total_Medo + $total_Acc}}</td> 
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endif
</section>
<script>
$(document).ready(function() {
	$('#form_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
 
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
		//location.reload();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Branchwise_Register").addClass('active');
	});
</script>
@endsection