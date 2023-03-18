
<?php $__env->startSection('main_content'); ?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Leave<small>Report</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Report</li>
		</ol>
	</section>

	<!-- Main content -->
	
	<section class="content">
 <?php 
		$admin_access_label		= Session::get('admin_access_label');
	?>
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div> 
					<div class="box-body">
						<div class="form-group"> 
							 
							<div class="pull-right"> 
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
							</div>
						</div>
					</div> 
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Center for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information</u></span></h4> 
						</center>
						
					</div>
					<div class="box-body">  
						<div style="width:95%;margin:auto;" > 
							 <table  class="report" border="1" cellspacing="0" style="width:90%;margin:auto;">  
								<tbody>  
									<tr style="text-align:center;padding-left:2px;">                                    
									  <td colspan="10">Fiscal Year : <?php if($admin_access_label == 1){ echo date("Y",strtotime($fiscal_year->f_year_from))."-";echo date("Y",strtotime($fiscal_year->f_year_from))+1;} else { echo "2009-2012";} ?></td> 
									</tr> 
									<tr style="text-align:left;padding-left:2px;">                                    
									  <td>SL No</td>  									  
									  <td>ID</td> 
									  <td>Name</td> 
									  <td>Designation</td> 
									  <td>Branch</td> 
									  <?php if($admin_access_label == 1){?>
									  <td>Current Leave</td> 
									  <td>Enjoy Leave</td>  
									  <td>Total leave(2009-2012)</td>  
									  <td>Enjoy Leave (2009-12) </td>  
									  <td>Balance (2009-12) </td>  
									  <?php }else{ ?>
									  <td>Total leave(2009-2012) </td> 
									  <td>Enjoy Leave</td>  
									  <td>Balance</td> 
									 <?php } ?>
									  <!--<td>Total enjoy Leave</td> --> 
									</tr>  
									<?php 
										$j=1;
										foreach($all_report as $v_all_report){
											if(($v_all_report['cum_balance_less_12'] - $v_all_report['no_of_days_appr']) != 0 ){											
										
									?>
									<tr >                                    
									  <td style="padding-left:2px;"> <?php echo $j++; ?></td>     
									  <td style="padding-left:2px;"> <?php echo $v_all_report['emp_id']; ?></td>    
									  <td style="padding-left:2px;"> <?php echo $v_all_report['emp_name']; ?></td>    
									  <td style="padding-left:2px;"> <?php echo $v_all_report['designation_name']; ?></td>    
									  <td style="padding-left:2px;"> <?php echo $v_all_report['branch_name']; ?></td> 
									<?php if($admin_access_label == 1){?>									  
									  <td style="padding-left:2px;"> <?php echo $v_all_report['current_open_balance']; ?></td>   
									  <td style="padding-left:2px;"> <?php echo $v_all_report['no_of_days']; ?></td> 
									
									  <td style="padding-left:2px;"> <?php echo $v_all_report['cum_balance_less_12']; ?></td>
									  <td style="padding-left:2px;"> <?php if(!empty($v_all_report['no_of_days_appr'])){echo $v_all_report['no_of_days_appr'];} else { echo 0;  } ?></td>
									  <td style="padding-left:2px;"> <?php echo $v_all_report['cum_balance_less_12'] - $v_all_report['no_of_days_appr'];  ?></td> 
									  <?php }else{ ?>
									  <td style="padding-left:2px;"> <?php echo $v_all_report['cum_balance_less_12']; ?></td>   
									  <td style="padding-left:2px;"> <?php  if(!empty($v_all_report['no_of_days_appr'])) { echo $v_all_report['no_of_days_appr']; }else echo 0;?></td>   
									  <td style="padding-left:2px;"> <?php echo $v_all_report['cum_balance_less_12'] - $v_all_report['no_of_days_appr'];  ?></td> 
									  <?php } ?>
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
				 
				
		</div>
	</section> 
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>