@extends('admin.admin_master')
@section('title', 'PMS Staff Status')
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
	<!--<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">All Staff List</li>
	</ol>-->
</section>
<section class="content">
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Assessment Report</font></b><br/>
				<b><font size="4">Assessment Year : 2020-2021</font></b></p>			
			</div>
			<div class="col-md-12" style="padding-bottom:50px;" >
			<form class="form-inline report" action="{{URL::to('/pms-assessment-report')}}" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="email">Assessment Year :</label>
					<select class="form-control" id="assessment_year" name="assessment_year" required >						
						<option value="" >-Select-</option>
						<option value="1" >2020-2021</option>
						<option value="2" >2021-2022</option>
					</select>
				</div>	
				<div class="form-group">
					<label for="email">Department:</label>
					<select style="width:150px;" class="form-control" id="department_id" name="department_id" >						
						<option value="" >-Select-</option>
						@foreach ($all_department as $department)
						<option value="{{$department->department_id}}">{{$department->department_name}}</option>
						@endforeach
					</select>
				</div>						
				<button type="submit" class="btn btn-primary" >Search</button>
				<button type="button" id="btnExport" class="btn btn-primary" >Export Excel</button>
			</form>
			</div>
		@if (!empty($all_result))
			<div class="col-md-12">
				<table id="tblExport" class="table table-bordered table-striped" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Department</th>
							<th>ID No</th>
							<th>Staff Name</th>						
							<th>Designation</th>
							<th>Score of B</th>
							<th>C.1</th>
							<th>C.2</th>
							<th>C.3</th>
							<th>C.4</th>
							<th>Total</th>
						</tr>
					</thead>					
					<tbody>
						{{!$i=1}} @foreach($all_result as $result)
						<tr>
							<td>{{$i++}}</td>
							<td><?php echo $result->department_name; ?></td>
							<td><?php echo $result->empid; ?></td>
							<td><?php echo $result->emp_name_eng; ?></td>
							<td><?php echo $result->designation_name; ?></td>
							<td><?php echo $result->score_b; ?></td>
							<td><?php echo $result->score_c1; ?></td>
							<td><?php echo $result->score_c2; ?></td>
							<td><?php echo $result->score_c3; ?></td>
							<td><?php echo $result->score_c4; ?></td>
							<td><?php echo round($result->score_b + $result->score_c1 + $result->score_c2 + $result->score_c3 + $result->score_c4); ?></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@endif
		</div>
	</div>
</section>

<!------export to excel file------->
<script>
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").table2excel({
                exclude:".noExl",
				name:"Assessment Report",
				filename:"assessment_list",
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
		//location.reload();
    }
</script>
<script>
$(document).ready(function(){
  $("#assessment_year").val('<?php echo $assessment_year; ?>');
  $("#department_id").val('<?php echo $department_id; ?>');
});
</script>

<script>
	var table;
	$(document).ready(function() {
	   table = $('.table').DataTable({
		"iDisplayLength": 50
		});
	});
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupPms").addClass('active');	
		$("#assessment_report").addClass('active');
	});
</script>
@endsection