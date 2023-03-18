
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
							<h4><span align="center" style="font-size:16px;font-weight:bold; color:#800000; "><u>Employee  Visit information</u></span></h4>
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
						<div class="row">
							<div style="overflow-y: auto;" class="col-md-12">  
								<table  class="report" cellspacing="0" border="1" style="width:95%;margin:auto;">  
									<tbody>
										 
										<tr>
											<th><div align="left" style="width:30px">SL</div></th>  
											<th><div align="left" style="width:120px">Application Date</div></th>   
											<th><div align="left" style="width:200px">Purpose</div></th>  
											<th><div align="left" style="width:200px">Destination</div></th>  
											<th><div align="left" style="width:110px">Departure Date</div></th>  
											<th><div align="left" style="width:110px">Departure Time</div></th>  
											<th><div align="left" style="width:110px">Return Date</div></th>  
											<th><div align="left" style="width:110px">Return Time</div></th> 
											<th><div align="left" style="width:150px">Return Date(Actual)</div></th>  
											<th><div align="left" style="width:150px">Return Time(Actual)</div></th>  
											<th><div align="center" style="width:40px">Day/s</div></th>   
										</tr>   
										<?php  
										$sl = 1; 
										$tot_day = 0;
										if(!empty($all_visit_info)){ 
											foreach ($all_visit_info as $v_info) { 
										?>
										<tr>                                    
										  <td style="padding-left:2px;"><?php echo $sl++; ?></td>    
										  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($v_info->application_date)); ?></td>
										   <td style="padding-left:2px;"><?php echo wordwrap($v_info->purpose,130,"<br>\n"); ?></td> 
										  <td style="padding-left:2px;">
											<?php  if($v_info->visit_type == 1){
													$branch_name ='';
													$destination_code = explode(',',$v_info->destination_code);
													$i = 1;
													foreach ($branch_list as $branch){
														if (in_array($branch->br_code, $destination_code)){
															if($i == 1){
																$branch_name .= $branch->branch_name; 
															}else{
																$branch_name .= ', '.$branch->branch_name;
															}
															$i++;
														}
													}
													echo wordwrap($branch_name,130,"<br>\n");
												}else{ 
													echo wordwrap($v_info->destination_code,130,"<br>\n");
												}  
											?> 
										  
										  </td>  
										  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($v_info->from_date)); ?></td>
										  <td style="padding-left:2px;"><?php echo $v_info->leave_time; ?></td>
										  <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($v_info->to_date)); ?></td>
										 <td style="padding-left:2px;"><?php echo $v_info->arrival_time; ?></td>
										 <td style="padding-left:2px;"><?php echo date("d-m-Y",strtotime($v_info->arrival_date)); ?></td> 
										<td style="padding-left:2px;"><?php echo $v_info->return_time; ?></td>
										<td style="text-align:right;padding-right:2px;"><?php $tot_day += $v_info->tot_day;  echo $v_info->tot_day; ?></td>
										</tr>
								<?php  }} ?>
										<tr>                                    
										  <td colspan="10" style="text-align:right;padding-right:2px;">Total = </td>    
										  <td style="text-align:right;padding-right:2px;"><?php echo $tot_day; ?></td>  
										</tr>    
									</tbody>
								</table>  		
						</div>
					</div>
				</div>

			</div>
				
				
				
		</div>
	</section> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>