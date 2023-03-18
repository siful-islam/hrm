@extends('admin.admin_master')
@section('title', 'Branch Leave Report')
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
					<div class="box-body">
						<div class="form-group"> 
							<label for="emp_id" class="col-sm-1 control-label">Employee Id:</label>
							<div class="col-sm-2">
									<input type="text"  class="form-control" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>" required/>	 
							</div>
							<label for="to_date" class="col-sm-1 control-label">Fiscal Year:</label>
							<div class="col-sm-2"> 
								<select name="fiscal_year_id" id="fiscal_year_id" class="form-control"  required>  
									 
									<option value="<?php echo  $select_fiscal_year->id;?>"><?php  echo date("Y",strtotime($select_fiscal_year->f_year_from)).'-'.date("Y",strtotime($select_fiscal_year->f_year_to));?></option>
											 
								</select> 
							</div> 
							<div class="col-sm-3">
								<button type="submit"  id="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i> Show Report</button>
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
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Leave information </u></span></h4>
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
									 <tr>
										<td style="width:50%;font-weight:bold;text-align:right;">Zone</td><td style="width:50%;">  : &nbsp;&nbsp;&nbsp;<?php echo $zone_name;?></td>
									 </tr>
								</tbody>
						   </table>
						</center>
						
					</div>
					<?php if($is_employee == 1){ 
						?>
					
					<div class="box-body"> 
						<div style="width:95%;margin:auto;" >
							<table    style="width:100%;">
								<thead>
									<tr>
										<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:green;color:white;" class="with_pay_color" >With Pay</span></th> 
										 
									</tr>
									<tr>
										<th style="width:75%;text-align:left;">( Earn Leave) Previous Leave : <?php echo $fiscal_year->pre_cumulative_open; ?> &nbsp; &nbsp; &nbsp;Current Year Leave : <?php echo $fiscal_year->current_open_balance; ?>&nbsp; Casual Leave : <?php echo $fiscal_year->casual_leave_open; ?></th>
									
										<th style="width:25%;text-align:right;">Fiscal Year : <?php $f_year_start = date('Y',strtotime($fiscal_year->f_year_from));  echo date('Y',strtotime($fiscal_year->f_year_from));echo "-"; echo date('Y',strtotime($fiscal_year->f_year_from))+1; ?>
										<br>( <?php echo date('d F,  Y',strtotime($fiscal_year->f_year_from));?> থেকে <?php echo date('d F,  Y',strtotime($fiscal_year->f_year_to));?>)
										</th>
									</tr>
								</thead>
							</table>
						</div>
						<table  class="report" cellspacing="0" style="width:95%;margin:auto;">  
							<tbody>
								<tr>
									<th rowspan="2" style="border:1px solid black;"><div align="center">Branch</div></th>
									<th rowspan="2" style="border:1px solid black;"><div align="center">SL No.</div></th> 
									<th colspan="2" style="border:1px solid black;"><div align="center">Leave Date</div></th> 
									<th rowspan="2" style="border:1px solid black;"><div align="center">Days</div></th>
									<th rowspan="2" style="border:1px solid black;"><div align="center">Serial No</div></th>   
									<th rowspan="2" style="border:1px solid black;"><div align="center">Adjustment</div></th>   
									<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th style="border:1px solid black;">From</th>
									<th style="border:1px solid black;">To</th>
								</tr>
								<?php 
								$total_leave = 0;  
						if(count($getleaveinfowithpay) > 0){ 
								$sl = 1; 
								$pre_br_code = ''; 
								
									foreach ($getleaveinfowithpay as $leaveinfo) {
										
											$total_leave += $leaveinfo->no_of_days_appr;
										 
									if($leaveinfo->total_row == 1){ 
								?>
								<tr style="text-align:center;">  
								   <td style="width:7%;border:1px solid black;"><?php echo $leaveinfo->branch_name; ?></td>  
								  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
								  
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
								  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous"; ?></td>
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
								</tr>
						
									<?php  }else{  
									if($leaveinfo->br_code != $pre_br_code){ ?>
										<tr style="text-align:center;">  
										   <td style="width:7%;border:1px solid black;" rowspan="<?php echo $leaveinfo->total_row; ?>"><?php echo $leaveinfo->branch_name; ?></td>  
										  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
										  
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
										  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous"; ?></td>
										  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
										</tr>
									<?php 
										}else{ ?>
										<tr style="text-align:center;">   
										  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
										  
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
										  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous"; ?></td>
										  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
										</tr>
									<?php } ?> 	
									<?php } ?>
						<?php  $pre_br_code = $leaveinfo->br_code; } }   ?>
								<tr style="text-align:center;">                                    
								  <td colspan="4" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>   
								  <td style="border:1px solid black;"><?php echo $total_leave; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								<td style="width:10%;border:1px solid black;"></td>			  
								</tr>    
							</tbody>
						</table>
						<br>
						<?php $total_leave_casual = 0;  
						if(count($getcasualleaveinfowithpay) > 0){	 ?>
						<div style="width:95%;margin:auto;" >
							<table    style="width:100%;">
								<thead> 
									<tr>
										<th style="width:75%;text-align:left;">( Casual Leave) </th> 
									</tr>
								</thead>
							</table>
						</div>
						<table  class="report" cellspacing="0" style="width:95%;margin:auto;">  
							<tbody>
								<tr>
									<th rowspan="2" style="border:1px solid black;"><div align="center">Branch</div></th>
									<th rowspan="2" style="border:1px solid black;"><div align="center">SL No.</div></th> 
									<th colspan="2" style="border:1px solid black;"><div align="center">Leave Date</div></th> 
									<th rowspan="2" style="border:1px solid black;"><div align="center">Days</div></th>
									<th rowspan="2" style="border:1px solid black;"><div align="center">Serial No</div></th>   
									<th rowspan="2" style="border:1px solid black;"><div align="center">Adjustment</div></th>   
									<th rowspan="2" style="border:1px solid black;"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th style="border:1px solid black;">From</th>
									<th style="border:1px solid black;">To</th>
								</tr>
								<?php  
								$sl = 1; 
								$pre_br_code = ''; 
								
									foreach ($getcasualleaveinfowithpay as $leaveinfo) {
										
											$total_leave_casual += $leaveinfo->no_of_days_appr;
										 
									if($leaveinfo->total_row == 1){ 
								?>
								<tr style="text-align:center;">  
								   <td style="width:7%;border:1px solid black;"><?php echo $leaveinfo->branch_name; ?></td>  
								  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
								  
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
								  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
								  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous"; ?></td>
								  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
								</tr>
						
									<?php  }else{  
									if($leaveinfo->br_code != $pre_br_code){ ?>
										<tr style="text-align:center;">  
										   <td style="width:7%;border:1px solid black;" rowspan="<?php echo $leaveinfo->total_row; ?>"><?php echo $leaveinfo->branch_name; ?></td>  
										  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
										  
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
										  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous"; ?></td>
										  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
										</tr>
									<?php 
										}else{ ?>
										<tr style="text-align:center;">   
										  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
										  
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_from_date)); ?></td>
										  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo->appr_to_date)); ?></td> 
										  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo->no_of_days_appr; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo->serial_no; ?></td>
										  <td style="width:10%;border:1px solid black;"><?php if($leaveinfo->leave_adjust == 1) echo "Current"; else if($leaveinfo->leave_adjust == 2) echo  "Previous"; ?></td>
										  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo->remarks; ?>  </td>
										</tr>
									<?php } ?> 	
									<?php } ?>
						<?php  $pre_br_code = $leaveinfo->br_code; }    ?>
								<tr style="text-align:center;">                                    
								  <td colspan="4" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>   
								  <td style="border:1px solid black;"><?php echo $total_leave_casual; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 
								<td style="width:10%;border:1px solid black;"></td>			  
								</tr>    
							</tbody>
						</table>
						<br>
						<?php   }   ?>
						<br> 
						<?php  
							$pre_total_leave = 0;
						if(count($getleaveprevious) > 0){ ?>
						<div style="width:95%;margin:auto;" >
							<table  style="width:100%;">
								<thead>
									<tr>
										<th colspan="3" style="width:100%;text-align:left;"><span style="background-color:#ADD8E6;" class="with_pay_color" >Previous</span></th> 
										 
									</tr>
								</thead>
							</table>
						</div>
						<table  class="report" border="1" cellspacing="0" style="width:95%;margin:auto;">  
							<tbody>
								<tr>
									<th rowspan="2"><div align="center">Branch</div></th>
									<th rowspan="2"><div align="center">SL No.</div></th> 
									<th colspan="2"><div align="center">Leave Date</div></th> 
									<th rowspan="2"><div align="center">Days</div></th>
									<th rowspan="2"><div align="center">Serial No</div></th>   
									<th rowspan="2"><div align="center">Adjustment</div></th>   
									<th rowspan="2"><div align="center">Remarks</div></th> 
								</tr>
								<tr>
									<th>From</th>
									<th>To</th>
								</tr>
								 <?php   
							    $sl = 1;  
								$pre_br_code_p = '';		
									foreach ($getleaveprevious as $previous) {
										$pre_total_leave += $previous->no_of_days_appr; 
									  if($previous->total_row == 1){ ?>
										  <tr style="text-align:center;"> 
											  <td style="width:7%;border:1px solid black;"><?php echo $previous->branch_name; ?></td> 								
											  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
											   
											  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_from_date)); ?></td>
											  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_to_date)); ?></td> 
											  <td style="width:8%;border:1px solid black;"><?php echo $previous->no_of_days_appr; ?></td>
											  <td style="width:10%;border:1px solid black;"><?php echo $previous->serial_no; ?></td>
											  <td style="width:10%;border:1px solid black;"><?php if($previous->leave_adjust == 1) echo "Current"; else if($previous->leave_adjust == 2) echo  "Previous"; ?></td>
											  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $previous->remarks; ?>  </td>
											</tr> 
									 <?php 
										}else{
											if($pre_br_code_p != $previous->br_code){?> 
											<tr style="text-align:center;"> 
												  <td style="width:7%;border:1px solid black;" rowspan="<?php echo $previous->total_row; ?>"><?php echo $previous->branch_name; ?></td> 								
												  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
												   
												  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_from_date)); ?></td>
												  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_to_date)); ?></td> 
												  <td style="width:8%;border:1px solid black;"><?php echo $previous->no_of_days_appr; ?></td>
												  <td style="width:10%;border:1px solid black;"><?php echo $previous->serial_no; ?></td>
												  <td style="width:10%;border:1px solid black;"><?php if($previous->leave_adjust == 1) echo "Current"; else if($previous->leave_adjust == 2) echo  "Previous"; ?></td>
												  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $previous->remarks; ?>  </td>
												</tr> 
									 <?php 	}else{ ?>
										 <tr style="text-align:center;"> 	
											  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>  
											  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_from_date)); ?></td>
											  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($previous->appr_to_date)); ?></td> 
											  <td style="width:8%;border:1px solid black;"><?php echo $previous->no_of_days_appr; ?></td>
											  <td style="width:10%;border:1px solid black;"><?php echo $previous->serial_no; ?></td>
											  <td style="width:10%;border:1px solid black;"><?php if($previous->leave_adjust == 1) echo "Current"; else if($previous->leave_adjust == 2) echo  "Previous"; ?></td>
											  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $previous->remarks; ?>  </td>
										</tr> 
										<?php }		}							
									?> 
								<?php $pre_br_code_p = $previous->br_code;  }?>
								<tr style="text-align:center;">                                    
								  <td colspan="4" style="text-align:right;font-weight:bold;">Total = </td>   
								  <td><?php echo $pre_total_leave; ?></td> 
								  <td style="text-align:left;font-weight:bold;"></td> 
								  <td style="text-align:left;font-weight:bold;"></td> 
								<td></td>			  
								</tr>    
							</tbody>
						</table> 
						<?php } ?> 
						
						<div style="width:95%;margin:auto;margin-bottom:10px;">
							<b>Earn Leave</b>
							<table border="1"  cellspacing="0" style="width:100%;margin:0px;float:left;">
								<tbody> 
										<tr> 
										
										  <td style="text-align:center;background-color:lightgreen;">Current Year Leave</td>  
										  <td style="text-align:center;background-color:lightgreen;">Enjoy Leave</td>  
										  <td style="text-align:center;background-color:lightgreen;">Balance</td> 
										
										
										
										  <td style="text-align:center;background-color:lightgray;">Earn Leave </td>  
										  <td style="text-align:center;background-color:lightgray;">Enjoy Leave </td> 
										  <?php  
											$total_earn_leave = $extra_earn;  
											$ex_en =  $total_leave - $extra_earn; 
											
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
											<td style="text-align:center;"><?php echo $total_earn_leave; ?></td> 
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
						<br> 
						<br>
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
						</div>
						<br> 
						<br>
						<?php } ?>
						
						<br>
						 
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
														<th rowspan="2"><div align="center">Branch</div></th>
														<th rowspan="2"><div align="center">SL No.</div></th>
														<th colspan="2"><div align="center">Leave Date</div></th> 
														<th rowspan="2"><div align="center">Days</div></th>
														<th rowspan="2"><div align="center">Serial No</div></th> 
														<th rowspan="2"><div align="center">Adjustment</div></th>
														<th rowspan="2"><div align="center">Remarks</div></th> 
													</tr>
													<tr>
														<th>From</th>
														<th>To</th>
													</tr>
													 <?php 
														 $sl = 1; 
														$total_leave1 = 0; 
														$pre_br_code_w = '';
														foreach ($getleaveinfowithoutpay as $leaveinfo1) {
															$total_leave1 += $leaveinfo1->no_of_days_appr;
															if($leaveinfo1->total_row == 1){ ?>
																 <tr style="text-align:center;">  
																	   <td style="width:7%;border:1px solid black;"><?php echo $leaveinfo1->branch_name; ?></td> 
																	  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
																	  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_from_date)); ?></td>
																	  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_to_date)); ?></td> 
																	  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo1->no_of_days_appr; ?></td>
																	  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo1->serial_no; ?></td>
																	  <td style="width:10%;border:1px solid black;"></td>
																	  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo1->remarks; ?>  </td>
																	</tr> 
														 <?php 	}else{
															if($leaveinfo1->br_code != $pre_br_code_w){ ?>
																<tr style="text-align:center;">  
																	<td style="width:7%;border:1px solid black;" rowspan="<?php echo $leaveinfo1->total_row; ?>"><?php echo $leaveinfo1->branch_name; ?></td>
																	  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
																	  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_from_date)); ?></td>
																	  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_to_date)); ?></td> 
																	  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo1->no_of_days_appr; ?></td>
																	  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo1->serial_no; ?></td>
																	  <td style="width:10%;border:1px solid black;"></td>
																	  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo1->remarks; ?>  </td>
																	</tr> 
														 <?php	
															}else{ ?>
																<tr style="text-align:center;">                                    
																  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
																  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_from_date)); ?></td>
																  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($leaveinfo1->appr_to_date)); ?></td> 
																  <td style="width:8%;border:1px solid black;"><?php echo $leaveinfo1->no_of_days_appr; ?></td>
																  <td style="width:10%;border:1px solid black;"><?php echo $leaveinfo1->serial_no; ?></td>
																  <td style="width:10%;border:1px solid black;"></td>
																  <td style="text-align:center;width:35%;border:1px solid black;"><?php echo $leaveinfo1->remarks; ?>  </td>
																</tr> 
														 <?php	
															}
															 ?>
																
													 <?php 		
													 }
													?>  
													<?php $pre_br_code_w =  $leaveinfo1->br_code;} ?>
													<tr style="text-align:center;">                                    
													  <td colspan="4" style="width:5%;text-align:right;font-weight:bold;">Total = </td>   
													  <td ><?php echo $total_leave1; ?></td> 
													  <td style="text-align:left;font-weight:bold;"></td> 
													  <td></td>			  
													  <td></td>			  
													</tr>   
												</tbody>
											</table> 
											<br>
										 <?php } ?>
											</br>
											
											
											
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
													<th rowspan="2"><div align="center">Serial No</div></th>   
													<th rowspan="2"><div align="center">Adjustment</div></th>   
													<th rowspan="2"><div align="center">Remarks</div></th> 
												</tr>
												<tr>
													<th>From</th>
													<th>To</th>
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
												<th rowspan="2"><div align="center">Serial No</div></th>   
												<th rowspan="2"><div align="center">Adjustment</div></th>   
												<th rowspan="2"><div align="center">Remarks</div></th> 
											</tr>
											<tr>
												<th>From</th>
												<th>To</th>
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
											
											
											
											
						</div>
						
					<?php  }else{ ?>
						<div class="box-body" style="text-align:center;color:red;"> 
							<p><b>Employee is not in this Branch</b></p>
						</div> 
						
					<?php } ?>
				</div>
				@endif
				
				
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
<script>
		//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee").addClass('active');
			$("#Branch_Leave_Report").addClass('active');
		});
	</script>
@endsection