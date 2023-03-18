@extends('admin.admin_master')
@section('title', 'Employee Leave Report')
@section('main_content') 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee Leave<small>Report</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee Leave</a></li>
			<li class="active">Report</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
				<form class="form-horizontal" action="{{URL::to($action)}}" method="POST">
                  {{csrf_field()}}  
					<div class="box-body">
						<div class="form-group">  
							<label for="to_date" class="col-sm-1 control-label">Date From:</label>
							<div class="col-sm-2"> 
								<input type="date" class="form-control" onchange="set_date()" name="from_date" id="from_date" value="<?php echo $from_date; ?>" required/> 
							</div> 
							<label for="to_date" class="col-sm-1 control-label">Date To:</label>
							<div class="col-sm-2"> 
								<input type="date" class="form-control" name="to_date" id="to_date" value="<?php echo $to_date; ?>" min="<?php echo $from_date; ?>"  required/> 
							</div> 
							<label for="to_date" class="col-sm-1 control-label">Branch:</label>
							<div class="col-sm-2"> 
								<select name="br_code" id="br_code" class="form-control">
								 <option value="all">ALL</option>
								<?php foreach($all_branch as $v_all_branch){ ?> 
								  <option value="<?php echo $v_all_branch->br_code; ?>"><?php echo $v_all_branch->branch_name; ?></option>
								  <?php } ?>
								</select>
							</div> 
							<div class="col-sm-3">
								<button type="submit"  class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i> Show Report</button>
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>
				 @if(!empty($all_report))
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Centre for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information</u></span></h4> 
						</center>
						
					</div>
					<div class="box-body">  
						   
						 <table   class="report" border="1" cellspacing="0" style="width:90%;margin:auto;">  
								<thead>
									<tr>
										<th><div align="center">SL No.</div></th>
										<th><div align="left">Employee Name</div></th>  
										<th><div align="center">Employee ID</div></th>
										<th><div align="left">Designation</div></th>
										<th><div align="left">Branch</div></th>  
										<th><div align="center">From Date</div></th>  
										<th><div align="center">To Date</div></th>  
										<th><div align="center">Day/s</div></th>  
										<th><div align="center">Total Times</div></th>  
									</tr>
								</thead>
									<tbody>
									<?php  
										$sl = 1; 
											$pre_emp_id ='';
									foreach ($all_report as $report) { 
									if($report['total_row'] == 1){?>
										<tr style="text-align:center;" >                                    
										  <td style="width:5%;"><?php echo $sl++; ?></td>   
										  <td style="width:20%;text-align:left;padding-left:2px;"><?php echo $report['emp_name']; ?></td>
										  <td style="width:8%;"><?php echo $report['emp_id']; ?></td>
										  <td style="width:15%;text-align:left;padding-left:2px;"><?php echo $report['designation_name']; ?></td> 
										  <td style="width:10%;text-align:left;padding-left:2px;"><?php echo $report['branch_name']; ?></td>
										  <td style="width:13%;"><?php echo $report['appr_from_date']; ?></td>
										  <td style="width:12%;"><?php echo $report['appr_to_date']; ?></td>
										  <td style="width:5%;"><?php echo $report['no_of_days_appr']; ?></td>
										  <td style="width:5%;"><?php echo $report['tot_no_of_days_appr']; ?></td>
										</tr>
									<?php 
										}else{
											if($report['emp_id'] != $pre_emp_id){?>
												<tr   style="text-align:center;" >                                    
												  <td style="width:5%;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $sl++; ?></td>   
												  <td style="width:20%;text-align:left;padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['emp_name']; ?></td>
												  <td style="width:8%;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['emp_id']; ?></td>
												  <td style="width:15%;text-align:left;padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['designation_name']; ?></td> 
												  <td style="width:10%;text-align:left;padding-left:2px;" rowspan="<?php echo $report['total_row']; ?>"><?php echo $report['branch_name']; ?></td>
												  <td style="width:13%;"><?php echo $report['appr_from_date']; ?></td>
												  <td style="width:12%;"><?php echo $report['appr_to_date']; ?></td>
												  <td style="width:5%;"><?php echo $report['no_of_days_appr']; ?></td>
												  <td style="width:5%;" rowspan="<?php echo $report['total_row']; ?>" ><?php echo $report['tot_no_of_days_appr']; ?></td>
												</tr>	
										<?php 	}else{?>
												<tr   style="text-align:center;" >   
												  <td style="width:13%;"><?php echo $report['appr_from_date']; ?></td>
												  <td style="width:12%;"><?php echo $report['appr_to_date']; ?></td>
												  <td style="width:5%;"><?php echo $report['no_of_days_appr']; ?></td>
												   
												</tr>	
										<?php	}  
											} $pre_emp_id = $report['emp_id'];
										} ?>
									
								</tbody>
							</table> 
					</div>

				</div>
				@endif
				
				
		</div>
	</section> 
<script>
function set_date(){
	var from_date = document.getElementById('from_date').value; 
	document.getElementById('to_date').setAttribute("min", from_date);
}
function moveScroll(){
		var scroll = $(window).scrollTop();
		var anchor_top = $("#maintable").offset().top;
		var anchor_bottom = $("#bottom_anchor").offset().top;
		if (scroll>anchor_top && scroll<anchor_bottom) {
		clone_table = $("#clone");
		if(clone_table.length == 0){
			clone_table = $("#maintable").clone();
			clone_table.attr('id', 'clone');
			clone_table.css({position:'fixed',
					 'pointer-events': 'none',
					 top:60});
			clone_table.width($("#maintable").width());
			$("#table-container").append(clone_table);
			$("#clone").css({visibility:'hidden'});
			$("#clone thead").css({visibility:'visible'});
		}
		} else {
		$("#clone").remove();
		}
	}
	$(window).scroll(moveScroll);
</script>
<script type="text/javascript"> 


function printDiv(divID) {
    var divToPrint = document.getElementById(divID);
    var htmlToPrint = '' +
        '<style type="text/css">'+'.with_pay_color {' +
        'background-color:none !important;color:black !important;' + 
        '}' + '.margin_left {' +
        'margin: auto;width:45%;padding-left:50px !important;' + 
        '}' +  'table {' +
        'border-collapse: collapse;' + 
        '}' + 'body {' +
        'width:100%;'+
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close(); 
   } 

document.getElementById("br_code").value = '<?php echo $br_code; ?>';
$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'});
	//$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			//$("#Leave_Report")
			$('[id^=Leave_Report_]').addClass('active');
		});
	</script>
@endsection