@extends('admin.admin_master')
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
					 
						<table  class="report" cellspacing="0" style="width:95%;margin:auto;">  
							<tbody>
								<tr>
									<th   style="border:1px solid black;"><div align="center">SL No.</div></th>
									<th   style="border:1px solid black;"><div align="center">Application Date</div></th> 
									<th  style="border:1px solid black;"><div align="center">Destination</div></th>
									<th   style="border:1px solid black;"><div align="center">Date From</div></th>   
									<th   style="border:1px solid black;"><div align="center">Date To</div></th>   
									<th   style="border:1px solid black;"><div align="center">Days</div></th>   
									<th   style="border:1px solid black;"><div align="center">Purpose</div></th> 
								</tr> 
								<?php  
								$sl = 1; 
								$tot_day = 0;
								if(!empty($all_visit_info)){ 
									foreach ($all_visit_info as $v_info) { 
								?>
								<tr style="text-align:center;">                                    
								  <td style="width:7%;border:1px solid black;"><?php echo $sl++; ?></td>   
								  <td style="width:15%;border:1px solid black;"><?php echo date("d M Y",strtotime($v_info->application_date)); ?></td>
								  <td style="width:15%;border:1px solid black;">
									<?php  if($v_info->visit_type == 1){
											$destination_code = explode(',',$v_info->destination_code);
											$i = 1;
											foreach ($branch_list as $branch){
												if (in_array($branch->br_code, $destination_code)){
													if($i == 1){
														echo $branch->branch_name; 
													}else{
														echo ', '.$branch->branch_name;
													}
													$i++;
												}
											}
										}else{
											echo $v_info->destination_code;
										}  
									?> 
								  
								  </td> 
								  <td style="width:8%;border:1px solid black;"><?php echo date("d M Y",strtotime($v_info->from_date)); ?></td>
								  <td style="width:10%;border:1px solid black;"><?php echo date("d M Y",strtotime($v_info->to_date)); ?></td>
								 
								  <td style="width:10%;border:1px solid black;">
									<?php  
										$dStart = new DateTime($v_info->from_date);
										$dEnd  = new DateTime($v_info->to_date);
										$dDiff = $dStart->diff($dEnd);
										echo $duration = $dDiff->format('%r%a')+1;
											$tot_day += $duration;
									?> 
									</td> 
								  <td style="width:10%;border:1px solid black;"><?php echo $v_info->purpose; ?></td> 
								</tr>
						<?php  }} ?>
								<tr style="text-align:center;">                                    
								  <td colspan="5" style="text-align:right;font-weight:bold;border:1px solid black;">Total = </td>    
								  <td style="text-align:center;border:1px solid black;"><?php echo $tot_day; ?></td> 
								  <td style="text-align:left;font-weight:bold;border:1px solid black;"></td> 	  
								</tr>    
							</tbody>
						</table>  		
						</div>

				</div>
				
				
				
		</div>
	</section> 
@endsection