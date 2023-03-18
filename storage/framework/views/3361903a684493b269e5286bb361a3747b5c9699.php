
<?php $__env->startSection('title', 'Employee Leave Report'); ?>
<?php $__env->startSection('main_content'); ?> 
<!------export to excel file------->	
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.btechco.excelexport.js')); ?>"></script>		
<script type="text/javascript" src="<?php echo e(asset('public/scripts/jquery.base64.js')); ?>"></script>		
<!------export to excel file------->

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
				 <?php if(!empty($all_report)): ?>
					 <button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>&nbsp;&nbsp;&nbsp;<button type="button" id="btnExport" class="btn btn-primary" >Export Excel</button>
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Centre for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information</u></span></h4> 
						</center>
						
					</div>
					<div class="box-body">  
						   
						 <table id="tblExport"  class="report" border="1" cellspacing="0" style="width:90%;margin:auto;">  
								<thead>
									<tr>
										<th><div align="center">SL No.</div></th>
										<th><div align="left">Employee Name</div></th>  
										<th><div align="center">Employee ID</div></th> 
										<th><div align="left">Designation</div></th>
										<th><div align="left">Branch</div></th>  
										<th><div align="center">Basic Salary</div></th>  
										<th><div align="center">Leave Balance</div></th>  
										<th><div align="center">Amount(TK)</div></th>  
										
										<th><div align="center">Grade</div></th>  
									</tr>
								</thead>
									<tbody>
									<?php  
										$sl = 1; 
											$pre_emp_id ='';
											$total_amount = 0;
									foreach ($all_report as $report) {  
											 ?>
												<tr   style="text-align:center;" >                                    
												  <td style="width:5%;"><?php echo $sl++; ?></td>   
												  <td style="width:20%;text-align:left;padding-left:2px;"><?php echo $report['emp_name']; ?></td>
												  <td style="width:8%;"><?php echo $report['emp_id']; ?></td> 
												  <td style="width:15%;text-align:left;padding-left:2px;"><?php if((!empty($report['assign_designation'])) && ($report['assign_open_date'] <= $form_date)) {
									echo $report['assign_designation']; } else {
									echo $report['designation_name']; 
									} ?></td> 
												  <td style="width:10%;text-align:left;padding-left:2px;"><?php if (empty($report['asign_branch_name'])) { echo $report['branch_name']; } else { echo $report['asign_branch_name']; } ?></td>
												   <td style="width:12%;"><?php echo $report['basic_salary']; ?></td>
												  <td style="width:13%;"><?php echo $report['current_close_balance'] + $report['pre_cumulative_close']; ?></td>
												  <td style="width:12%;"><?php $total_amount += round(($report['current_close_balance'] + $report['pre_cumulative_close']) * ( $report['basic_salary'] / 30)); echo round(($report['current_close_balance'] + $report['pre_cumulative_close']) * ( $report['basic_salary'] / 30));  ?></td>
												 
												  <td style="width:5%;"><?php echo $report['grade_name']; ?></td>
												</tr>	
										<?php   } ?>
									<tr   style="text-align:center;" >                                    
												  <td  colspan="7" style="text-align:center;"> Total </td>   
												 
												 
												  <td style="width:12%;"><?php echo  $total_amount;  ?></td>
												 
												  <td style="width:5%;"></td>
												</tr>	
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
			//$("#Leave_Report")
			$('[id^=Leave_Report_]').addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>