
<?php $__env->startSection('main_content'); ?>
<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
 <?php
 function taka_format($amount = 0)
	{
		$tmp = explode('.',$amount);  // for float or double values
		$strMoney = '';
		$amount = $tmp[0];
		$strMoney .= substr($amount, -3,3 );
		$amount = substr($amount, 0,-3 );
		 while(strlen($amount)>0)
		{
			$strMoney = substr($amount, -2,2 ).','.$strMoney;
			$amount = substr($amount, 0,-2 );
		} 

		if(isset($tmp[1]))         // if float and double add the decimal digits here.
		{
		return $strMoney.'.'.$tmp[1];
		}
		return $strMoney;
	}

	function bn2enNumber ($number){
		$replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০",",");
		$search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9","0",",");
		$en_number = str_replace($search_array, $replace_array, $number);
		return $en_number;
	} 
 ?>
 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>View Records</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<!--<h3 class="box-title"> <?php echo e($Heading); ?></h3>-->
				<form class="form-horizontal" action="<?php echo e(URL::to('salary_certicate_emo_info_depo')); ?>" method="post">
                <?php echo e(csrf_field()); ?>	
					<div class="form-group">
						<div class="col-sm-1">	
							Employee ID :
						</div>
						<div class="col-sm-2">	
							<input type="number" class="form-control" name="emp_id" value="<?php echo e($emp_id); ?>" required>
						</div>
						<div class="col-sm-3">
							<button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-search-plus" aria-hidden="true"></i> Search   </button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.box-header -->
		</div>	
		
			<div class="col-md-12">
				<div class="box box-solid">
				<?php if($is_access == 1){ if(!empty($all_report) > 0) {?>	
					<div class="box-header with-border">
						<div class="pull-right"> <button type="button"  onclick="javascript:printDiv('printme')"><i class="fa fa-print" aria-hidden="true"></i> Print</a></button> 
						</div>
					</div>
					<!-- /.box-header -->
					<div id="printme" >
					  <div class="box-body">
						 <div class="box-header with-border">
						<center style="text-align:justfy;text-justify: inter-word;" > 
							<span class="box-title" style="text-align:left;" >
							<img src="<?php echo e(asset(Session::get('org_logo'))); ?>" style="float:left;margin-top:0%;" width="78" >
							</span>
							
								<span class="box-title" style="text-align:justify; text-justify: inter-word;" >
									<span style="font-size:20px;"> সেন্টার ফর ডেভেলপমেন্ট     ইনোভেশন এন্ড প্র্যাকটিসেস ( সিদীপ )  <br></span><span  style="font-size:24px;">Centre for Development Innovation and Practices(CDIP)</span><br>
									<span style="font-size:12px;">সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি, সেখেরটেক, আদাবর, ঢাকা - ১২০৭</span><br>
									<span style="font-size:14px;font-weight:bold; color:#800000; ">web:www.cdipbd.org, Email:info@cdipbd.org, Phone:02-48118633,02-48118634</span>
								</span>  
							</center>
							<hr>
							<div>		
								<p style="text-align:center;"><u>CERTIFICATE OF DEPOSIT</u></p>
								<table style="width:100%;">
									<tr>
										<td style="width:25%;">Employee ID</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $all_report['emp_id'];?></td>
									</tr>							
									<tr>
										<td style="width:25%;">Name of Depositor</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $all_report['emp_name'];?></td>
									</tr>						
									<tr>						
										<td style="width:25%;">Designation</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $all_report['designation_name'];?></td>
									</tr>
									<tr>
										<td style="width:25%;">Assesment Year</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("Y",strtotime($all_report['f_year_from']." + 1 year")).' to '.date("Y",strtotime($all_report['f_year_to']." + 1 year"));  ?> </td>
									</tr>	
									<tr>	 
										<td style="width:25%;">Income Period</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("d F ,Y",strtotime($all_report['f_year_from'])).' to '.date("d F, Y",strtotime($all_report['f_year_to']));  ?> </td>
									</tr>	
									<tr>	
										<td style="width:25%;">Twelve Digit e-TIN</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $all_report['tin_number'].', Tax Circle '.$all_report['tax_circle'].', ' .$all_report['tax_zone'];?></td>
									</tr>	
									<tr>	
										<td style="width:25%;">Work Station</td> 
										<td style="width:75%;">:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $all_report['branch_name'];?></td>
														
									</tr>
								</table>
								<br>
								Certified that the above named person, who was employed by our <?php if($all_report['branch_code'] == 9999){ ?> Head office<?php }else{ ?>  Branch office<?php } ?> , was deposited of taka = <span  id = "tot_deposit"></span> /- during the stated period as follows.
								<table class="table table-bordered table-responsive table-striped"  style="width:100%;">
								<?php $tot_amount = 0; $tot_amount_non = 0; $i = 1;  ?>
									<tr>
										<td>SN.</td>
										<td>Name of deposit</td>
										<td style="text-align:right;">Amount ( Taka )</td>
									</tr>
									<tr>
										<td>1</td>
										<td>Both Contribution to a Recognized Provident Fund</td>
										<td style="text-align:right;"> <?php $tot_amount +=  ($all_report['provident_fund'] * 3); echo taka_format($all_report['provident_fund'] * 3);?></td>
									</tr>
									 
									<tr>
										<td>2</td>
										<td>Employee Contribution to Welfare Fund</td>
										<td style="text-align:right;"> <?php $tot_amount += round(($all_report['basic'] * 1) / 100) * $all_report['work_month']; echo taka_format(round(($all_report['basic'] * 1) / 100) * $all_report['work_month']); ?></td>
									</tr> 
									<tr>
										<td colspan="2" style="text-align:center;"><b>Total Deposit</b></td> 
										<td style="text-align:right;"><b> <?php echo taka_format($tot_amount); ?></b>

											<script>
														document.getElementById("tot_deposit").innerHTML = '<?php echo taka_format($tot_amount);?>';
											</script>
										</td>
									</tr>
								</table> 
										<table width="100%">
												<tr>
													<td style="border: 0px solid white !important; text-align:right !important;"> 
														
													</td>
													<td style="border: 0px solid white !important; text-align:right !important;"> 
														for Centre for Development Innovation and Practices (CDIP) 
														Head Office, Dhaka
													</td>
												</tr>
											</table>
											<br>
											<br>
											<table width="100%">
												<tr>
													<td style="border: 0px solid white !important;"> Dated, <?php echo date("j\<\s\u\p\>S\<\/\s\u\p\> F, Y",strtotime(date("Y-m-d")));?></td>
													<td style="border: 0px solid white !important;text-align:right !important;"> Authorized Signature </td>
												</tr>
											</table> 
											<table width="100%" style="margin:0px;padding:0px;" >
												<tr>
													<td style="border: 0px solid white !important;text-align:center !important;padding-top:12px !important;">This is Computer Generated Deposit Statement reqiured no Signature</td>
												</tr>
											</table>
								
								 
							</div> 
					</div>	
					
					</div>
				</div>
					<!-- /.box-body -->
				<?php }}else{
			  echo "<p style='color:red;text-align:center;'>Access is Denied</p>";
				
		} ?>
				</div>
				<!-- /.box -->
			</div>
			
		
	</section>
	 <script language="javascript" type="text/javascript"> 
 function printDiv(divID) {
    var divToPrint = document.getElementById(divID);
    var htmlToPrint = '' +
        '<style type="text/css">'+'.no-border th, .no-border td {' +
        'border:none;' + 
        '}' + '.table-bordered th, .table-bordered td {' +
        'border:1px solid #000 !important;' + 'font-size:13px !important;' + 
        '}'+ '.custom th, .custom td {' 
         + 'font-size:11px !important;' + 
        '}' + 'table {' +
        'border-collapse: collapse;' + 
        '}' + '.box-body {' +
        '-webkit-print-color-adjust: exact;' + 'height: 99vh; width: 100vw;' +
        'color-adjust: exact;'+
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close(); 
//}
    } 
	 
</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>