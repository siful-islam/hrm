@extends('admin.admin_master')
@section('title', 'Individual Requisition Report')
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
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
#header {visibility: hidden;}

#footer{visibility: hidden;}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Approved<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Approved</li>
		</ol>
	</section>
	<?php $user_type 			= Session::get('user_type');?>
	<!-- Main content -->
	<section class="content">
		<div class="row">
		 <div class="col-md-12"> 
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/rpt_dairy_calender_ind_post')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group"> 
							<label for="br_code">Emp Name :</label>
							<input type="text" id="emp_id" class="form-control" name="emp_id" size="10" value="{{$emp_id}}" required>
						</div>				
						<button type="submit" class="btn btn-primary">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
			<?php if(!empty($all_result)){?>
				<br>
				<br>
				<div id="printme">
					<div id="header"><?php echo date("d/m/Y");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://45.114.85.154/hrm/rpt_dairy_calender</div>
						<div class="col-md-12">
							<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
							<b><font size="4">Diary/Calendar Report</font></b></p>		
						</div>   
								<table class="table table-bordered">
								<thead>
									<tr>
										<th>Branch name</th> 
										<th>Employee name</th> 
										<th>Emp ID</th>  
										<th>Designation</th> 
										<th>Diary (Cash Purchase)</th> 
										<th>Calendar (Cash Purchase)</th>  
										<th>Diary ( Organization )</th> 
										<th>Calendar ( Organization )</th> 
									</tr>
								</thead>
										
								
									<tbody>  
									<tr>
										<td><?php echo $all_result['branch_name'];?> </td>
										<td><?php echo $all_result['emp_name'];?></td> 
										<td><?php echo $all_result['emp_id'];?></td>  
										<td><?php echo $all_result['designation_name'];?></td> 
										<td><?php echo $all_result['num_dairy'];?></td> 
										<td><?php echo $all_result['num_calender'];?></td> 
										<td><?php echo $all_result['org_num_dairy'];?></td> 
										<td><?php echo $all_result['org_num_calender'];?></td> 
										
									</tr>  
									</tbody>
								</table> 	
					<div id="footer"></div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<script type="text/javascript"><!--
$(document).ready(function() {  
	document.getElementById("emp_id").value="{{$emp_id}}";
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
			'}' + '#footer {' +
			'position: fixed;bottom: 0;' +
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
    }
</script> 
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupRequisition").addClass('active');
			$("#Individual_Diary_Report").addClass('active');
			//$('[id^=Previous_Leave_Balance]').addClass('active');
		});
	</script>
@endsection