@extends('admin.admin_master')
@section('title', 'All Staff MIS Report')
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
<!------export to excel file------->	
<script type="text/javascript" src="{{asset('public/scripts/jquery.btechco.excelexport.js')}}"></script>		
<script type="text/javascript" src="{{asset('public/scripts/jquery.base64.js')}}"></script>		
<!------export to excel file------->
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
	<!--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">All Total Staff List</li>
	</ol>-->
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/all-staff-mis-reports')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="form_date" class="form-control" name="form_date" size="10" value="{{$form_date}}" required>
						</div>
						<div class="form-group">
							<label for="email">Status :</label>
							<select name="status" id="status" required class="form-control">
								<option value="1" <?php if($status==1) echo 'selected'; ?> >Running</option>
							</select>
						</div>						
						<button type="submit" class="btn btn-primary">Search</button>
						<button type="button" id="btnExport" class="btn btn-primary" >Export Excel</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php ini_set('memory_limit', '-1'); ?>
	@if (!empty($all_result2))
	<div class="row">
		<div id="printme">
			<div style="overflow-y: auto; height: 650px;" class="col-xs-12">
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Branch Code</th>
							<th>Branch Name</th>
							<?php foreach ($all_designation as $designation) { ?>
							<th><?php echo $designation->designation_name;?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=1; foreach ($all_branch as $branch) { ?>
						
						<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $branch->br_code;?></td>
						<td><?php echo $branch->branch_name;?></td>
						<?php foreach ($all_designation as $designation) {	
							$abc = 1;
						foreach($all_result2 as $result) {
							if(($branch->br_code == $result['br_code']) && ($designation->designation_code == $result['designation_code'])) { 
						$abc = 0;
						
						?>
							<td><?php echo $result['designation_value']; ?></td>
						
						<?php } ?>
							
						<?php } if($abc==1) { ?>

						<td><?php echo 0; ?></td>

						<?php } } ?>
						</tr>
						<?php } ?>
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
<!------export to excel file------->
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
            });
        });
    });
</script>
<!------export to excel file------->
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
			$("#MIS_Reports").addClass('active');
		});
	</script>
@endsection