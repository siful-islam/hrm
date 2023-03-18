@extends('admin.admin_master')
@section('title', 'Staff Strength-Org. Report')
@section('main_content')
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: 1px solid black;
}
.table > thead > tr > th {
    border: 1px solid black;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: center; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid black;
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
					<form class="form-inline report" action="{{URL::to('/pomis_three_reportprowise')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="date_within" class="form-control" name="date_within" size="10" value="{{$date_within}}" required />
						</div>  
						<button type="submit" class="btn btn-primary">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="3">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="3">POMIS-3 Report</font></b><?php echo ' ( as on'.' '.date("d-m-Y", strtotime($date_within)).')'; ?><br>
				<font size="3">Staff Information</font>
				</p>
				
				<div class="pull-left">
				  <font size="3">Name of Month : <?php echo date("F",strtotime($date_within)).' - '.date('Y', strtotime($date_within));?>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				   
				  </font> 
				  
			  </div> 
			  <div class="pull-right" id="hide_printdate" style="display:none;" >
				Print date: <?php echo date("d-m-Y");?> 
			</div>  
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					 
										<thead>
											<tr>
												<th>Sl No.</th>
												<th>Emp ID</th> 
												<th>Emp Name</th> 
												<th>Designation</th> 
												<th>Gender</th>   
												<th>Project</th> 
												<th>Branch</th> 
											</tr>
											
										</thead>
										 <tbody >
											
											<?php 
											if(!empty($all_result)){
												
											 
											$i= 1;
											foreach($all_result as $v_all_result){ ?>
												<tr>
													<td><?php echo $i++;?></td>
													<td><?php echo $v_all_result['emp_id'];?></td>
													<td><?php echo $v_all_result['emp_name'];?></td> 
													<td><?php echo $v_all_result['designation_name'];?></td> 
													<td><?php echo $v_all_result['gender'];?></td> 
													<td><?php echo $v_all_result['project_name'];?></td> 
													<td><?php echo $v_all_result['branch_name'];?></td>  
													 
												</tr>
											<?php 
											}
											}
											?>	
										</tbody>
									 
				</table>
			</div>
		</div>
	</div> 
</section>
<script> 
$(document).ready(function() {
	$('#date_within').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script>
    function printDiv(divID) {
        //Get the HTML of div
		 
		$("#hide_printdate").show();
		
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><style>"  + '.table-bordered th, .table-bordered td {' +
        'border:1px solid black !important;' + 
        '}' + '#tblExport th, #tblExport td {' +
        'text-align: center !important;' + 
        '}'+  '#micro_bold_bottom {' +
        'border-bottom: 2px solid black !important;text-align:center;' + 
        '}'+  '#micro_bold_bottom_j {' +
        'border-bottom: 2px solid black !important;text-align:center;' + 
        '}'+ '.micro_bold_bottom {' +
        'border-bottom: 2px solid black !important;text-align:center;' + 
        '}'+ "</style><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
		/* window.close(
		
		alert('ok');
		); */ 
		setTimeout(function () {  $("#hide_printdate").hide(); }, 1);
    }
	 
	
</script>

<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupService_Length_Reports").addClass('active');
			$("#Pomis-3_Project_wise").addClass('active');
		});
	</script>
@endsection