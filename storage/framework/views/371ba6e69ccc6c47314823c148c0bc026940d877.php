
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
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
	

				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Center for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information</u></span></h4>
							<table border="0" cellspacing="0" width="100%">                     
								<tbody>
									<tr></tr>
									<tr>
										<td style="width:50%;font-weight:bold;text-align:right;">ID</td><td style="width:50%;"> : &nbsp;&nbsp;&nbsp; <?php echo $emp_id;?></td>
									 </tr>
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Employee Name </td><td style="width:50%;"> :  &nbsp;&nbsp;&nbsp;<?php echo  $emp_name;?></td>
									 </tr>
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Designation </td><td style="width:50%;"> : &nbsp;&nbsp;&nbsp;<?php echo $designation_name;?></td>
									 </tr> 
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Working station</td><td style="width:50%;">  : &nbsp;&nbsp;&nbsp;<?php echo $branch_name;?></td>
									 </tr> 
								</tbody>
						   </table>
						</center>
						
					</div>
					<div class="box-body"> 
						<div style="width:95%;margin:auto;" >
							<table    style="width:100%;">
								<thead>
									<tr>
										<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:green;color:white;" class="with_pay_color" >With Pay</span></th> 
										 
									</tr>
									<tr>
										<th style="width:75%;text-align:left;">( Earn Leave ) Old Leave (9-12): <?php echo $fiscal_year->cum_balance_less_12; ?> &nbsp; &nbsp; &nbsp; Previous Leave : <?php echo $fiscal_year->pre_cumulative_open; ?> &nbsp; &nbsp; &nbsp;Current Year Leave : <?php echo $fiscal_year->current_open_balance; ?></th>
									
										<th style="width:25%;text-align:right;">Fiscal Year : <?php $f_year_start = date('Y',strtotime($fiscal_year->f_year_from));  echo date('Y',strtotime($fiscal_year->f_year_from));echo "-"; echo date('Y',strtotime($fiscal_year->f_year_from))+1; ?>
										<br>( <?php echo date('d F,  Y',strtotime($fiscal_year->f_year_from));?> To <?php echo date('d F,  Y',strtotime($fiscal_year->f_year_to));?>) 
										</th>
									</tr>
								</thead>
							</table>
						</div> 
						<table  class="report" cellspacing="0" style="width:95%;margin:auto;">  
							<tbody>
								<tr>
									<th rowspan="2" style="border:1px solid black;"><div align="center">SL No.</div></th>
									<th colspan="2" style="border:1px solid black;"><div align="center">Leave Date</div></th> 
									<th rowspan="2" style="border:1px solid black;"><div align="center">Days</div></th>
									<th rowspan="2" style="border:1px solid black;"><div align="center">Serial No.</div></th>    
									<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th style="border:1px solid black;text-align:center;">From</th>
									<th style="border:1px solid black;text-align:center;">To</th>
								</tr>
								<?php 
								$total_leave = 0;  
								$sl = 1;  
								if(!empty($getleaveinfowithpay)){ 
									foreach ($getleaveinfowithpay as $leaveinfo) {
										
											$total_leave += $leaveinfo->no_of_days_appr;
										
										
								?>
								<tr style="text-align:center;">                                    
								  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
								  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; if($leaveinfo->apply_for == 2){ echo " (Morning)"; }else if($leaveinfo->apply_for == 3){ echo " (Evening)";}?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td> 
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
								</tr>
						<?php  }} ?>
								<tr style="text-align:center;">                                    
								  <td colspan="3" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>   
								  <td style="border:1px solid black;"><?php echo $total_leave; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								<td style="width:10%;border:1px solid black;"></td>			  
								</tr>    
							</tbody>
						</table>
						<br> 
						<div style="width:95%;margin:auto;">
							<b>Earn Leave</b>
							<table border="1"  cellspacing="0" style="width:100%;margin:0px;float:left;">
								<tbody> 
										<tr> 
										 <td style="text-align:center;background-color:Lavender;">Old Leave (9-12)</td>  
										  <td style="text-align:center;background-color:Lavender;">Enjoy Leave</td>   
										  <td style="text-align:center;background-color:Lavender;">Balance</td>
										  
										  <td style="text-align:center;background-color:lightblue;">Previous Year Leave</td>  
										  <td style="text-align:center;background-color:lightblue;">Enjoyed Leave</td>   
										  <td style="text-align:center;background-color:lightblue;">Balance</td>
										  
										  <td style="text-align:center;background-color:lightgreen;">Current Year Leave</td>  
										  <td style="text-align:center;background-color:lightgreen;">Enjoyed Leave</td>  
										  <td style="text-align:center;background-color:lightgreen;">Balance</td> 
										
										
										
										  <td style="text-align:center;background-color:lightgray;">Earned Leave </td>  
										  <td style="text-align:center;background-color:lightgray;">Enjoyed Leave </td> 
										  <?php  
											
											  
											  $total_earn_leave = $extra_earn; 
											 
											 $check_year = $f_year_start+1;
											
												if($check_year."-"."06"."-"."30" == $from_date){
													 $total_earn_leave = $total_earn_leave + 2;
												 } 
											
											  
											//$total_leave1 = $fiscal_year->no_of_days;
											$total_leave1 = ($fiscal_year->current_open_balance  - $fiscal_year->current_close_balance);
											 
											$ex_en =  $total_leave - $total_earn_leave; 
											 
											
											if($ex_en > 0){?>
												 <td style="text-align:center;color:red;background-color:lightgray;" class="with_pay_color">Extra Leave Enjoyed </td>   
												  
											<?php }else{?> 
												<td style="text-align:center;color:green;background-color:lightgray;" class="with_pay_color">Enjoyable Leave </td>   
												   
											<?php } ?> 
										</tr>
										<tr>
											 <td style="text-align:center;"><?php echo $fiscal_year->cum_balance_less_12; ?></td>
											 <td style="text-align:center;"><?php echo ($fiscal_year->cum_balance_less_12 -  $fiscal_year->cum_balance_less_close_12); ?></td>
											 <td style="text-align:center;"><?php echo ($fiscal_year->cum_balance_less_close_12);?></td>
											 <td style="text-align:center;"><?php echo $fiscal_year->pre_cumulative_open; ?></td>
											  <td style="text-align:center;"><?php echo $previous_enjoy_leave = ($fiscal_year->pre_cumulative_open -  $fiscal_year->pre_cumulative_close);  ?></td>
											 <td style="text-align:center;"><?php  echo $fiscal_year->pre_cumulative_close;?></td>  
											<td style="text-align:center;"><?php echo $fiscal_year->current_open_balance; ?></td>
											  <td style="text-align:center;">
											  <?php 
												//echo $current_enjoy_leave = $fiscal_year->no_of_days;
												echo $current_enjoy_leave = ($fiscal_year->current_open_balance  - $fiscal_year->current_close_balance);
											  ?>
											  </td>
											 <td style="text-align:center;"><?php echo ($fiscal_year->current_close_balance);?></td>
											 <td style="text-align:center;"><?php    echo $total_earn_leave;  ?></td> 
											<td style="text-align:center;">
											<?php 
												//echo $fiscal_year->no_of_days; 
												echo ($fiscal_year->current_open_balance  - $fiscal_year->current_close_balance);
											?>
											</td> 
											<?php  
											 
											//$ex_en =  $fiscal_year->no_of_days - $total_earn_leave; 
											$ex_en =  ($fiscal_year->current_open_balance  - $fiscal_year->current_close_balance) - $total_earn_leave; 
												 
											if($ex_en > 0){?>
												  <td  style="text-align:center;color:red;"><?php echo $ex_en;?></td>   
											<?php }else{?> 
												  <td  style="text-align:center;color:green;"><?php echo -$ex_en;?></td>  
											<?php } ?>  
										</tr>
										
								</tbody>
							</table>
						<br> 					
						<br> 					
						<br> 					
						</div>
						<?php $total_leave_casual = 0;   if(count($getcasualleaveinfowithpay) > 0){ ?>
						<div style="width:95%;margin:auto;padding-top:50px;" >
							<table    style="width:100%;">
								<thead>
									<tr>
										<th colspan="3" style="width:100%;text-align:left;"><span  class="with_pay_color" >Casual Leave</span></th> 
										 
									</tr> 
								</thead>
							</table>
						</div>
						<table  class="report" cellspacing="0" style="width:95%;margin:auto;">  
							<tbody>
								<tr>
									<th rowspan="2" style="border:1px solid black;"><div align="center">SL No.</div></th>
									<th colspan="2" style="border:1px solid black;"><div align="center">Leave Date</div></th> 
									<th rowspan="2" style="border:1px solid black;"><div align="center">Days</div></th>
									<th rowspan="2" style="border:1px solid black;"><div align="center">Serial No.</div></th>  
									<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th  style="border:1px solid black;text-align:center;">From</th>
									<th   style="border:1px solid black;text-align:center;">To</th>
								</tr>
								<?php 
								 
								$sl = 1;  
								
									foreach ($getcasualleaveinfowithpay as $leaveinfo) {
										
											$total_leave_casual += $leaveinfo->no_of_days_appr;
										
										
								?>
								<tr style="text-align:center;">                                    
								  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
								  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr;if($leaveinfo->apply_for == 2){ echo " (Morning)"; }else if($leaveinfo->apply_for == 3){ echo " (Evening)"; }?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
								</tr>
						<?php  } ?>
								<tr style="text-align:center;">                                    
								  <td colspan="3" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>   
								  <td style="border:1px solid black;"><?php echo $total_leave_casual; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								<td style="width:10%;border:1px solid black;"></td>			  
								</tr>    
							</tbody>
						</table>
						<br>
						<?php  } ?> 
						<?php if($total_leave_casual != 0){ ?>
							 
						<div style="width:95%;margin:auto;padding-top:5px;"> 
						<b>Casual Leave</b>
							<table border="1"  cellspacing="0" style="width:100%;margin:0px;float:left;">
								<tbody> 
										<tr> 
										
										  <td style="text-align:center;">Casual Leave</td>  
										  <td style="text-align:center;">Enjoyed Leave</td>  
										  <td style="text-align:center;">Balance</td>  
										</tr>
										<tr> 
										 <td style="text-align:center;"><?php echo $fiscal_year->casual_leave_open; ?></td>
											 <td style="text-align:center;"><?php echo $total_leave_casual; ?></td>
											 <td style="text-align:center;"><?php echo ($fiscal_year->casual_leave_open - $total_leave_casual);?></td>
										 
											 
										</tr>
										
								</tbody>
							</table>
								<?php } ?> 
						</div>
						<br>
						<?php $sl=1; $pre_total_leave1 = 0;
							if(count($getleavemeternity) > 0){ ?>
								<div style="width:95%;margin:auto;" >
									<table  style="width:100%;">
										<thead>
											<tr>
												<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:#ADD8E6;" class="with_pay_color" >Meternity</span></th> 
												 
											</tr>
										</thead>
									</table>
								</div>
								<table  class="report" border="1" cellspacing="0" style="width:95%;margin:auto;">  
									<tbody>
										<tr>
											<th rowspan="2"><div align="center">SL No.</div></th>
											<th colspan="2"><div align="center">Leave Date</div></th> 
											<th rowspan="2"><div align="center">Days</div></th>
											<th rowspan="2"><div align="center">Serial No.</div></th>   
											<th rowspan="2"><div align="center">Remarks</div></th> 
										</tr>
										<tr>
											<th style="text-align:center;">From</th>
											<th style="text-align:center;">To</th>
										</tr>
										<?php  
											foreach ($getleavemeternity as $previous) {
												$pre_total_leave1 += $previous->no_of_days_appr; 	
										?>
										<tr style="text-align:center;">                                    
										  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_from_date));?></td>
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_to_date)); ?></td> 
										  <td style="width:8%;border:1px solid black;"><?php echo $previous->no_of_days_appr; if($previous->apply_for == 2){ echo " (Morning)"; }else if($previous->apply_for == 3){ echo " (Evening)";} ?></td>
										  <td style="width:10%;border:1px solid black;"><?php echo $previous->serial_no; ?></td>
										  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $previous->remarks; ?>  </td>
										</tr> 
										<?php  } ?>
										<tr style="text-align:center;">                                    
										  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
										  <td><?php echo $pre_total_leave1; ?></td> 
										  <td style="text-align:left;font-weight:bold;"></td> 
										<td></td>			  
										</tr>    
									</tbody>
								</table>
								<br>
								<?php } ?>
							<?php 
							$total_leave_special = 0; 
							if(count($getleavespecial)>0){ 
								?>
	
									<div style="width:95%;margin:auto;margin-top:2%;" >
										<table  style="width:100%;">
											<thead>
												<tr>
													<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:green;color:white;" class="with_pay_color" >Special</span></th> 
													 
												</tr> 
											</thead>
										</table>
									</div>
									
									<table class="report" border="1" cellspacing="0" style="width:95%;margin:auto;">  
										<tbody>
											 
											<tr>
												<th rowspan="2"><div align="center">SL No.</div></th>
												<th colspan="2"><div align="center">Leave Date</div></th> 
												<th rowspan="2"><div align="center">Days</div></th>
												<th rowspan="2"><div align="center">Serial No.</div></th>   
												<th rowspan="2"><div align="center">Remarks</div></th> 
											</tr>
											<tr>
												<th style="text-align:center;">From</th>
												<th style="text-align:center;">To</th>
											</tr>
											 <?php  
												 $sl = 1;   
												foreach ($getleavespecial as $special) {
												   $total_leave_special += $special->no_of_days_appr;
											?>
											<tr style="text-align:center;">                                    
												  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
												  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($special->appr_from_date)); ?></td>
												  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($special->appr_to_date)); ?></td> 
												  <td style="width:8%;border:1px solid black;"><?php echo $special->no_of_days_appr; if($special->apply_for == 2){ echo " (Morning)"; }else if($special->apply_for == 3){ echo " (Evening)";}?></td>
												  <td style="width:10%;border:1px solid black;"><?php echo $special->serial_no; ?></td>
												  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $special->remarks; ?>  </td>
												</tr> 
										<?php  } ?>
											<tr style="text-align:center;">                                    
											  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
											  <td><?php echo $total_leave_special; ?></td>  
											  <td style="text-align:left;font-weight:bold;"></td> 
											<td></td>			  
											</tr>    
										</tbody>
									</table>
									<br>
									<?php  } ?> 
										<?php if(count($getleaveinfowithoutpay) > 0){?> 
	
											<div style="width:95%;margin:auto;" >
												<table>
													<thead>
														<tr>
															<th style="text-align:left;margin-top:25px;"><span style="background-color:red;color:white;" class="with_pay_color">Without Pay</span></th> 
															
														</tr> 
													</thead>
												</table>
											</div>
											<table  class="report" border="1" cellspacing="0" style="width:95%;margin:auto;">  
												<tbody>
													<tr>
														<th rowspan="2"><div align="center">SL No.</div></th>
														<th colspan="2"><div align="center">Leave Date</div></th> 
														<th rowspan="2"><div align="center">Days</div></th>
														<th rowspan="2"><div align="center">Serial No.</div></th>  
														<th rowspan="2"><div align="center">Remarks</div></th> 
													</tr>
													<tr>
														<th style="text-align:center;">From</th>
														<th style="text-align:center;">To</th>
													</tr>
													 <?php 
														 $sl = 1; 
														$total_leave1 = 0; 
													if(!empty($getleaveinfowithoutpay)){
														foreach ($getleaveinfowithoutpay as $leaveinfo1) {
															$total_leave1 += $leaveinfo1->no_of_days_appr;
													?> 
													<tr style="text-align:center;">                                    
														  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
														  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_from_date)); ?></td>
														  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_to_date)); ?></td> 
														  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo1->no_of_days_appr;if($leaveinfo1->apply_for == 2){ echo " (Morning)"; }else if($leaveinfo1->apply_for == 3){ echo " (Evening)"; }?></td>
														  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo1->serial_no; ?></td> 
														  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo1->remarks; ?>  </td>
														</tr> 
													
													<?php  }} ?>
													<tr style="text-align:center;">                                    
													  <td colspan="3" style="width:5%;text-align:right;font-weight:bold;">Total = </td>   
													  <td ><?php echo $total_leave1; ?></td>  
													  <td></td>			  
													  <td></td>			  
													</tr>   
												</tbody>
											</table> 
											<br>
										 <?php } 
												$total_leave_quarantine = 0; 
												if(count($getleavequarantine)> 0 ){ 
											?>
											
											<div style="width:95%;margin:auto;margin-top:2%;" >
												<table  style="width:100%;">
													<thead>
														<tr>
															<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:green;color:white;" class="with_pay_color" >Quarantine</span></th> 
															 
														</tr> 
													</thead>
												</table>
											</div>
											
											<table class="report" border="1" cellspacing="0" style="width:95%;margin:auto;">  
												<tbody>
													 
													<tr>
														<th rowspan="2"><div align="center">SL No.</div></th>
														<th colspan="2"><div align="center">Leave Date</div></th> 
														<th rowspan="2"><div align="center">Days</div></th>
														<th rowspan="2"><div align="center">Serial No.</div></th>    
														<th rowspan="2"><div align="center">Remarks</div></th> 
													</tr>
													<tr>
														<th style="text-align:center;">From</th>
														<th style="text-align:center;">To</th>
													</tr>
													
													<?php  
														 $sl = 1;  
														foreach ($getleavequarantine as $pre_quarantine) {
														   $total_leave_quarantine += $pre_quarantine->no_of_days_appr;
													?>
													<tr style="text-align:center;">                                    
														  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
														  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($pre_quarantine->appr_from_date)); ?></td>
														  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($pre_quarantine->appr_to_date)); ?></td> 
														  <td style="width:8%;border:1px solid black;"><?php echo $pre_quarantine->no_of_days_appr; if($pre_quarantine->apply_for == 2){ echo " (Morning)"; }else if($pre_quarantine->apply_for == 3){ echo " (Evening)";}?></td>
														  <td style="width:10%;border:1px solid black;"><?php echo $pre_quarantine->serial_no; ?></td>
														  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $pre_quarantine->remarks; ?>  </td>
													</tr>   
														<?php  }  
													?> 
													<tr style="text-align:center;">                                    
													  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
													  <td><?php echo $total_leave_quarantine; ?></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
													<td></td>			  
													</tr>    
												</tbody>
											</table>
											<?php  } ?>
											</br>
									
						</div>

				</div>
				
				
				
		</div>
	</section> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>