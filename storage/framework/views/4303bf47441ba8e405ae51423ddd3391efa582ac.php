
<?php $__env->startSection('title', 'Previous Leave Report'); ?>
<?php $__env->startSection('main_content'); ?> 
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
			
			<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
				 <?php if(!empty($all_report)): ?>
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Center for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Previous  Leave information</u></span></h4> 
							
						</center>
						
					</div>
					<div class="box-body">  
						   
						 <table   class="report" border="1" cellspacing="0" style="width:90%;margin:auto;">  
								<thead>
									<tr>
										<th><div align="center">SL No.</div></th> 
										<th><div align="center">Employee ID</div></th> 
										<th><div align="left">Employee Name</div></th>  
										<th><div align="left">Designation</div></th>
										<th><div align="left">Branch</div></th>  
										<th><div align="left">Join Date</div></th>  
										<th><div align="center">Previous Leave Balance</div></th>  
										<th><div align="center">Without Pay Leave</div></th>  
									</tr>
								</thead>
									<tbody>
									<?php  
										$sl = 1; 
											 
									foreach ($all_report as $report) {  ?>
										<tr style="text-align:center;" >                                    
										  <td style="width:5%;"><?php echo $sl++; ?></td>  
										  <td style="width:8%;"><?php echo $report['emp_id']; ?></td>										  
										  <td style="width:20%;text-align:left;padding-left:2px;"><?php echo $report['emp_name']; ?></td>
										
										  <td style="width:15%;text-align:left;padding-left:2px;"><?php echo $report['designation_name']; ?></td> 
										  <td style="width:10%;text-align:left;padding-left:2px;"><?php echo $report['branch_name']; ?></td>
										  <td style="width:13%;"><?php echo date("d-m-Y",strtotime($report['joining_date'])); ?></td>
										  <td style="width:13%;"><?php echo $report['pre_cumulative_close']; ?></td>
										  <td style="width:12%;"><?php echo $report['tot_without_pay']; ?></td> 
										</tr>
									<?php  
										} ?>
									
								</tbody>
							</table> 
					</div>

				</div>
				<?php endif; ?>
				
				
		</div>
	</section> 
<script>
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


$(document).ready(function() {
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'});
	//$('#to_date').datepicker({dateFormat: 'yy-mm-dd'}); 
});
</script>

	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			$("#Previous_Leave_Report").addClass('active');
			//$('[id^=Leave_Report_]')
		});
	</script>
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>