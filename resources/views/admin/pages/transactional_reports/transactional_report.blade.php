@extends('admin.admin_master')
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
	text-align: center; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Transactional Type</li>
	</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="" method="">
						<div class="form-group">
							<label for="email">Report Type :</label>
							<select name="category_id" id="category_id" required class="form-control">
								<option value="" >Select</option>
								<?php foreach($transactions as $transaction) { ?>
								<option value="<?php echo $transaction->transaction_id.','.$transaction->action_route; ?>"><?php echo $transaction->transaction_name; ?></option>
								<?php } ?>
							</select>
						</div>						
						<button type="button" class="btn btn-primary" onclick="show_report();">Search</button>
					</form>
				</div>
			</div>
        </div>
	</div>
	<div class="box box-info">
		<!--<div class="box-header with-border">
			<h3 class="box-title">Reports</h3>
		</div>-->			
		<div class="box-body" id="report_show">
		
		</div>
	</div>
</section>
	
	
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
    })
		
	function show_report()
	{
		var category_id = document.getElementById("category_id").value;   
		//var date_from = document.getElementById("form_date").value;  
		//var date_to = document.getElementById("to_date").value;  
		//alert (category_id);
		var result = category_id.split(",");
		var id = result[0];
		var route = result[1];
		//alert (route);
		$.ajax({
			//url : "{!! URL::to('"+route+"') !!}"+"/"+id+"/"+date_from+"/"+date_to,
			url : "{!! URL::to('"+route+"') !!}",
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#report_show").html(data); 
						 
			}
		}); 		
	}
</script>
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
			'<style type="text/css">' + '.report th {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.report td {' +
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