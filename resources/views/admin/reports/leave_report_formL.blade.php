@extends('admin.admin_master')
@section('title', 'Leave Report')
@section('main_content')
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
			<!-- form start -->
				<form class="form-horizontal" action="{{URL::to($action)}}" method="POST">
                  {{csrf_field()}}  
				   	<input type="hidden" class="form-control" id="join_date"  name="join_date"  value="{{$join_date}}"/>	
				  	<input type="hidden" class="form-control" id="resign_date"  name="resign_date"  value="{{$resign_date}}"/>	
					<div class="box-body">
						<div class="form-group">  
							<div class="col-sm-2">
								  <select name="report_type" onchange="change_report_type()" id="report_type" class="form-control" required> 
									<option value="1" <?php  if($report_type == 1) echo "selected";?>>select</option> 
									<option value="2" <?php  if($report_type == 2) echo "selected";?>>Final Payment</option> 
								</select>
							</div>
							<label for="to_date" class="col-sm-1 control-label">Employee Id:</label>
							<div class="col-sm-2">
									<input type="text" onkeyup="change_report_type()" autocomplete="off" class="form-control" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>" required/>	 
							</div>
							<label for="to_date" class="col-sm-1 control-label">Date WithIn:</label>
							<div class="col-sm-2"> 
								<input type="text" class="form-control common_date" name="from_date" id="from_date" value="<?php echo $from_date; ?>" required/> 
							</div> 
							<div class="col-sm-3">
								<button type="submit" id="submit"  class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i> Show Report</button>
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>
				 @if(!empty($emp_id))
				<div id="printme" class="box box-danger">
					<div class="box-header with-border">			
						<center>
							<h3 class="box-title">Centre for Development Innovation and Practices</h3>
							<p>CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</p>
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information <?php if($report_type == 2){?>( Final Payment ) <?php } ?></u></span></h4>
							<table border="0" cellspacing="0" width="100%">                     
								<tbody>
									<tr></tr>
									<tr>
										<td style="width:50%;font-weight:bold;text-align:right;">ID</td><td style="width:50%;"> : &nbsp;&nbsp;&nbsp; <?php echo $emp_id;?></td>
									 </tr>
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Employee Name </td><td style="width:50%;"> :  &nbsp;&nbsp;&nbsp;<?php echo  $emp_name;?></td>
									 </tr>
									 <?php if($report_type == 2){?>
										<tr>
											<td style="width:50%;font-weight:bold;text-align:right;">Joining Date </td><td style="width:50%;"> : &nbsp;&nbsp;&nbsp;<?php echo  date("d-m-Y",strtotime($join_date));?></td>
										 </tr> 
										 <tr>
											<td style="width:50%;font-weight:bold;text-align:right;">Resign Effect Date </td><td style="width:50%;"> : &nbsp;&nbsp;&nbsp;<?php echo  date("d-m-Y",strtotime($resign_date));?></td>
										 </tr> 
									 <?php } ?>
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Designation </td><td style="width:50%;"> : &nbsp;&nbsp;&nbsp;<?php echo $designation_name;?></td>
									 </tr> 
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Working station</td><td style="width:50%;">  : &nbsp;&nbsp;&nbsp;<?php echo $branch_name;?></td>
									 </tr> 
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Zone</td><td style="width:50%;">  : &nbsp;&nbsp;&nbsp;<?php echo $zone_name;?></td>
									 </tr>
								</tbody>
						   </table>
						</center>
						
					</div>
					 <?php if(!empty($fiscal_year)){ ?>	
					<div class="box-body"> 
						<div style="width:95%;margin:auto;" >
							<table    style="width:100%;">
								<thead>
									<tr>
										<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:green;color:white;" class="with_pay_color" >With Pay</span></th> 
										 
									</tr>
									<tr>
										<th style="width:75%;text-align:left;">( Earned Leave ) Previous Year Leave : <?php echo $fiscal_year->pre_cumulative_open; ?> &nbsp; &nbsp; &nbsp;Current Year Leave : <?php echo $fiscal_year->current_open_balance; ?>&nbsp; &nbsp; &nbsp; Casual Leave : <?php echo $fiscal_year->casual_leave_open; ?></th>
									
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
									<th rowspan="2" style="border:1px solid black;"><div align="center">Adjustment</div></th>   
									<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th   style="border:1px solid black;text-align:center;">From</th>
									<th  style="border:1px solid black;text-align:center;">To</th>
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
								  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous Year Leave"; ?></td>
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
								</tr>
						<?php  }} ?>
								<tr style="text-align:center;">                                    
								  <td colspan="3" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>   
								  <td style="border:1px solid black;"><?php echo $total_leave; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								<td style="width:10%;border:1px solid black;"></td>			  
								</tr>    
							</tbody>
						</table>
						<br>
						
						
						<?php $total_leave_casual = 0;   if(count($getcasualleaveinfowithpay) > 0){ ?>
						<div style="width:95%;margin:auto;" >
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
									<th rowspan="2" style="border:1px solid black;"><div align="center">Adjustment</div></th>   
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
								  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous Year Leave"; ?></td>
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
								</tr>
						<?php  } ?>
								<tr style="text-align:center;">                                    
								  <td colspan="3" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>   
								  <td style="border:1px solid black;"><?php echo $total_leave_casual; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								<td style="width:10%;border:1px solid black;"></td>			  
								</tr>    
							</tbody>
						</table>
						<br>
						<?php  } ?>
						
						<br> 
					<?php 
							$pre_total_leave = 0;
						if(count($getleaveprevious) > 0){ ?>
						<div style="width:95%;margin:auto;" >
							<table  style="width:100%;">
								<thead>
									<tr>
										<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:#ADD8E6;" class="with_pay_color" >Previous Year Leave</span></th> 
										 
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
									<th rowspan="2"><div align="center">Adjustment</div></th>   
									<th rowspan="2"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th style="text-align:center;">From</th>
									<th style="text-align:center;">To</th>
								</tr>
								 <?php   
							   $sl = 1;   
								if(!empty($getleaveprevious)){
									foreach ($getleaveprevious as $previous) {
										$pre_total_leave += $previous->no_of_days_appr; 	
								?>
								<tr style="text-align:center;">                                    
								  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_from_date)); ?></td>
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_to_date)); ?></td> 
								  <td style="width:8%;border:1px solid black;"><?php echo $previous->no_of_days_appr; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $previous->serial_no; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php if($previous->leave_adjust == 1) echo "Current"; else if($previous->leave_adjust == 2) echo  "Previous Year Leave"; ?></td>
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $previous->remarks; ?>  </td>
								</tr> 
								<?php  }} ?>
								<tr style="text-align:center;">                                    
								  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
								  <td><?php echo $pre_total_leave; ?></td> 
								  <td style="text-align:left;font-weight:bold;"></td> 
								  <td style="text-align:left;font-weight:bold;"></td> 
								<td></td>			  
								</tr>    
							</tbody>
						</table>
						<br>
						<?php } ?> 
						
						<div style="width:95%;margin:auto;"> 
							<b>Earned Leave</b>
							<table border="1"  cellspacing="0" style="width:100%;margin:0px;float:left;">
								<tbody> 
										<tr> 
										
										  <td style="text-align:center;background-color:lightgreen;">Current Year Leave</td>  
										  <td style="text-align:center;background-color:lightgreen;">Enjoy Leave</td>  
										  <td style="text-align:center;background-color:lightgreen;">Balance</td> 
										
										
										
										  <td style="text-align:center;background-color:lightgray;">Earn Leave </td>  
										  <td style="text-align:center;background-color:lightgray;">Enjoy Leave </td> 
										  <?php  
											//echo  $extra_earn;
											if($report_type == 2){ 
													 $total_earn_leave = $extra_earn;  
											}else{
												if($fiscal_year1->tot_earn_leave >= 0){
												 $total_earn_leave = $fiscal_year1->tot_earn_leave + $extra_earn; 
												 }else{
													 $total_earn_leave = $extra_earn; 
												 }
											}
											  
											 
											 
											 
											 $check_year = $f_year_start+1;
											 if($report_type != 2){
													 if($check_year."-"."06"."-"."30" == $from_date){
													 $total_earn_leave = $total_earn_leave + 1.5;
												 } 
											 }
											  
											$total_leave1 = $fiscal_year->no_of_days;
											 
											 
											$ex_en =  $total_leave - $total_earn_leave; 
											 
											
											if($ex_en > 0){?>
												 <td style="text-align:center;color:red;background-color:lightgray;" class="with_pay_color">Extra Leave Enjoy </td>   
												  
											<?php }else{?> 
												<td style="text-align:center;color:green;background-color:lightgray;" class="with_pay_color">Enjoyable Leave </td>   
												   
											<?php } ?>
										  
										
 
										  <td style="text-align:center;background-color:lightblue;">Previous Year Leave</td>  
										  <td style="text-align:center;background-color:lightblue;">Enjoy Leave</td>   
										  <td style="text-align:center;background-color:lightblue;">Balance</td>
										</tr>
										<tr> 
										 <td style="text-align:center;"><?php echo $fiscal_year->current_open_balance; ?></td>
											 <td style="text-align:center;"><?php echo $total_leave; ?></td>
											 <td style="text-align:center;"><?php echo ($fiscal_year->current_open_balance - $total_leave);?></td>
											<td style="text-align:center;"><?php    echo $total_earn_leave;  ?></td> 
											<td style="text-align:center;"><?php echo $total_leave; ?></td> 
											<?php  
											 
											$ex_en =  $total_leave - $total_earn_leave; 
												 
											if($ex_en > 0){?>
												  <td  style="text-align:center;color:red;"><?php echo $ex_en;?></td>   
											<?php }else{?> 
												  <td  style="text-align:center;color:green;"><?php echo -$ex_en;?></td>  
											<?php } ?> 
											
											 <td style="text-align:center;"><?php echo $fiscal_year->pre_cumulative_open; ?></td>
											 <td style="text-align:center;"><?php echo $pre_total_leave; ?></td>
											 <td style="text-align:center;"><?php echo ($fiscal_year->pre_cumulative_open - $pre_total_leave);?></td>
										</tr>
										
								</tbody>
							</table>
							
						</div>
							<?php if($total_leave_casual != 0){ ?>
							
						<div style="width:95%;margin:auto;">
						<b>Casual Leave</b>
							<table border="1"  cellspacing="0" style="width:100%;margin:0px;float:left;">
								<tbody> 
										<tr> 
										
										  <td style="text-align:center;">Casual Leave</td>  
										  <td style="text-align:center;">Enjoy Leave</td>  
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
											<th rowspan="2"><div align="center">Adjustment</div></th>   
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
										  <td style="width:8%;border:1px solid black;"><?php echo $previous->no_of_days_appr; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php echo $previous->serial_no; ?></td>
										  <td style="width:10%;border:1px solid black;"></td>
										  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $previous->remarks; ?>  </td>
										</tr> 
										<?php  } ?>
										<tr style="text-align:center;">                                    
										  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
										  <td><?php echo $pre_total_leave1; ?></td> 
										  <td style="text-align:left;font-weight:bold;"></td> 
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
												<th rowspan="2"><div align="center">Adjustment</div></th>   
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
												  <td style="width:8%;border:1px solid black;"><?php echo $special->no_of_days_appr; ?></td>
												  <td style="width:10%;border:1px solid black;"><?php echo $special->serial_no; ?></td>
												  <td style="width:10%;border:1px solid black;"></td>
												  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $special->remarks; ?>  </td>
												</tr> 
										<?php  } ?>
											<tr style="text-align:center;">                                    
											  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
											  <td><?php echo $total_leave_special; ?></td> 
											  <td style="text-align:left;font-weight:bold;"></td> 
											  <td style="text-align:left;font-weight:bold;"></td> 
											<td></td>			  
											</tr>    
										</tbody>
									</table>
									<br>
									<?php  } ?>
									<?php $pre_total_leave_9_12 = 0;
										if(count($fiscal_year_9_12) > 0){ ?>
										<div style="width:95%;margin:auto;" >
											<table  style="width:100%;">
												<thead>
													<tr>
														<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:#ADD8E6;" class="with_pay_color" >Fiscal Yr 9-12</span></th> 
														 
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
													<th rowspan="2"><div align="center">Adjustment</div></th>   
													<th rowspan="2"><div align="center">Remarks</div></th> 
												</tr>
												<tr>
													<th style="text-align:center;">From</th>
													<th style="text-align:center;">To</th>
												</tr>
												 <?php   
											   $sl = 1;   
													foreach ($fiscal_year_9_12 as $pre_previous) {
														$pre_total_leave_9_12 += $pre_previous->no_of_days_appr; 	
												?>
												<tr style="text-align:center;">                                    
												  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
												  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($pre_previous->appr_from_date)); ?></td>
												  <td style="width:15%;border:1px solid black;"><?php echo  date("d M Y",strtotime($pre_previous->appr_to_date)); ?></td> 
												  <td style="width:8%;border:1px solid black;"><?php echo $pre_previous->no_of_days_appr; ?></td>
												  <td style="width:10%;border:1px solid black;"><?php echo $pre_previous->serial_no; ?></td>
												  <td style="width:10%;border:1px solid black;"></td>
												  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $pre_previous->remarks; ?>  </td>
												</tr> 
												<?php  } ?>		
												<tr style="text-align:center;">                                    
												  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
												  <td><?php echo $pre_total_leave_9_12; ?></td> 
												  <td style="text-align:left;font-weight:bold;"></td> 
												  <td style="text-align:left;font-weight:bold;"></td> 
												<td></td>			  
												</tr> 
													
											</tbody>
										</table>
										<br>
										<table border="1"  cellspacing="0" style="width:95%;margin:auto;">
												<tbody> 
														<tr> 
														  <td style="text-align:center;background-color:lightgray;">Fiscal Yr 9-12 Earn Leave </td>   
														  <td style="text-align:center;background-color:lightblue;">Fiscal Yr 9-12 Enjoy Leave</td>   
														  <td style="text-align:center;background-color:lightgreen;">Fiscal Yr 9-12 Balance</td>
														</tr>
														<tr> 
															<td style="text-align:center;"><?php echo $fiscal_year->cum_balance_less_12;?></td> 
															<td style="text-align:center;"><?php echo $pre_total_leave_9_12; ?></td>  
															<td style="text-align:center;"><?php echo $fiscal_year->cum_balance_less_12 - $pre_total_leave_9_12; ?></td>  
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
														<th rowspan="2"><div align="center">Adjustment</div></th>
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
														  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo1->no_of_days_appr; ?></td>
														  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo1->serial_no; ?></td>
														  <td style="width:10%;border:1px solid black;"></td>
														  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo1->remarks; ?>  </td>
														</tr> 
													
													<?php  }} ?>
													<tr style="text-align:center;">                                    
													  <td colspan="3" style="width:5%;text-align:right;font-weight:bold;">Total = </td>   
													  <td ><?php echo $total_leave1; ?></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
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
														<th rowspan="2"><div align="center">Adjustment</div></th>   
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
														  <td style="width:8%;border:1px solid black;"><?php echo $pre_quarantine->no_of_days_appr; ?></td>
														  <td style="width:10%;border:1px solid black;"><?php echo $pre_quarantine->serial_no; ?></td>
														  <td style="width:10%;border:1px solid black;"></td>
														  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $pre_quarantine->remarks; ?>  </td>
													</tr>   
														<?php  }  
													?> 
													<tr style="text-align:center;">                                    
													  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
													  <td><?php echo $total_leave_quarantine; ?></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
													<td></td>			  
													</tr>    
												</tbody>
											</table>
											<?php  } ?>
											</br>
										 <?php if($report_type == 2){?>
											 <br>
											 <br>
										<table  style="width:95%;margin:auto;">
											<thead>
												<tr>
													<th colspan="3" style="width:95%;margin:auto;"><span >Leave Sammary</span></th> 
													 
												</tr> 
											</thead>
										 </table>
											<table border="1"  cellspacing="0" style="width:95%;margin:auto;">
												<tbody> 
														<tr> 
														
														  <td style="text-align:center;background-color:lightgreen;width:50%;">Total Leave ( Previous year And Current year Earn Leave)</td>  
														  <td style="text-align:center;background-color:lightgreen;width:25%;">Enjoy Leave</td>  
														  <td style="text-align:center;background-color:lightgreen;width:25%;">Balance</td>  
														</tr>
														<tr> 
														 <td style="text-align:center;"><?php     $total_leave_earn_pre =  $fiscal_year->pre_cumulative_open + ( $total_earn_leave); echo $fiscal_year->pre_cumulative_open + ( $total_earn_leave);   ?></td>
															 <td style="text-align:center;"><?php echo ($total_leave + $pre_total_leave); ?></td>
															 <td style="text-align:center;"><?php echo $total_leave_earn_pre - ($total_leave + $pre_total_leave ) ; ?></td>
															 
														</tr>
														
 
												</tbody>
											</table>
											<?php  
												$total_finalwithout = 0; 
												if(count($finalwithoutpay)> 0 ){ 
											?>
											
											<div style="width:95%;margin:auto;margin-top:2%;" >
												<table  style="width:100%;">
													<thead>
														<tr>
															<th colspan="3" style="width:100%;text-align:left;"><span >Total Without Leave</span></th> 
															 
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
														<th rowspan="2"><div align="center">Adjustment</div></th>   
														<th rowspan="2"><div align="center">Remarks</div></th> 
													</tr>
													<tr>
														<th style="text-align:center;">From</th>
														<th style="text-align:center;">To</th>
													</tr>
													
													<?php  
														 $sl = 1;  
														foreach ($finalwithoutpay as $finalwithout) {
														   $total_finalwithout += $finalwithout->no_of_days_appr;
													?>
													<tr style="text-align:center;">                                    
														  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
														  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($finalwithout->appr_from_date)); ?></td>
														  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($finalwithout->appr_to_date)); ?></td> 
														  <td style="width:8%;border:1px solid black;"><?php echo $finalwithout->no_of_days_appr; ?></td>
														  <td style="width:10%;border:1px solid black;"><?php echo $finalwithout->serial_no; ?></td>
														  <td style="width:10%;border:1px solid black;"></td>
														  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $finalwithout->remarks; ?>  </td>
													</tr>   
														<?php  }  
													?> 
													<tr style="text-align:center;">                                    
													  <td colspan="3" style="text-align:right;font-weight:bold;">Total = </td>   
													  <td><?php echo $total_finalwithout; ?></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
													<td></td>			  
													</tr>    
												</tbody>
											</table>
											<?php  } ?>
											
											 <?php } ?>	
						</div>
						 <?php } ?>	
				</div>
				@endif
				
				
		</div>
	</section> 
<script type="text/javascript"> 
function change_report_type(){
	
	var report_type = document.getElementById("report_type").value;  
	var emp_id = document.getElementById("emp_id").value; 
	//alert(report_type);
	if((report_type != '' ) && (emp_id != '' )){
		$('#submit').attr("disabled", true);
		$.ajax({
			type: "GET",
			dataType: 'json',
			url : "{{URL::to('change_report_type')}}"+"/"+report_type+"/"+emp_id, 
			success: function(data)
			{ 
				//alert(data);
				//console.log(data);
				$('#submit').removeAttr('disabled');
				$("#from_date").val(data['resign_date']); 
				$("#resign_date").val(data['resign_date']); 
				$("#join_date").val(data['join_date']); 
			}
		});
	}
	
}
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
			$("#Leave_Report").addClass('active');
		});
	</script>

@endsection