<?php $__env->startSection('title', 'Requisition Report'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content-header {
    padding-top: 5px;
}
.content-header > .breadcrumb {
	padding: 2px 7px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
#header {visibility: hidden;}

#footer{visibility: hidden;}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Approved<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Approved</li>
		</ol>
	</section>
	<?php $user_type 			= Session::get('user_type');?>
	<!-- Main content -->
	<section class="content">
		<div class="row">
		 <div class="col-md-12"> 
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/rpt_dairy_calender_post')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<label for="area_code">Area Name :</label>
							<select class="form-control" id="area_code" name="area_code" required>						
								<option value="" hidden>-Select-</option>
								<option value="all" >ALL</option>
								<option value="all_a" >ALL consolidated</option>
								<?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($v_area->area_code); ?>"><?php echo e($v_area->area_name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select> 
							<label for="br_code">Branch Name :</label>
							<select class="form-control" id="br_code" name="br_code">
								<?php if(!empty($all_branch)): ?>
									<?php $__currentLoopData = $all_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v_branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($v_branch->br_code); ?>"><?php echo e($v_branch->branch_name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
								<?php endif; ?> 
							</select>
						</div>				
						<button type="submit" class="btn btn-primary">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
			<?php if(!empty($all_result)){?>
				<br>
				<br>
				<div id="printme">
					<div id="header"><?php echo date("d/m/Y");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://45.114.85.154/hrm/rpt_dairy_calender</div>
						<div class="col-md-12">
							<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
							<b><font size="4">Diary/Calendar Report</font></b></p>		
						</div><?php  if($area_code != 'all'){ ?>
							Area Name:&nbsp; <?php  //echo $area_name->area_name.'<br>';?> 
						<?php }?>
						
					
						<?php  
								$all_branch_code = array_column($all_result, 'branch_code');
								//print_r($all_branch_code);
								$count = array_count_values($all_branch_code); 
								if($area_code == 'all'){ ?>
								
								<table class="table table-bordered">
								<thead>
									<tr>
										<th>SL No</th>
										<th>Branch name</th> 
										<th>Emp No</th> 
										<th>Employee name</th> 
										<th>Emp ID</th>  
										<th>Designation</th> 
										<th>Diary (Cash Purchase)</th> 
										<th>Calendar (Cash Purchase)</th>  
										<?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
										<th>Diary ( Organization )</th> 
										<th>Calendar ( Organization )</th>
										<?php //} 		 ?>
									</tr>
								</thead>
										
								
									<tbody> 
										<?php 
											$i=1;
											$j=1;
											$grand_tot_dairy_org = 0;
											$grand_tot_dairy = 0;
											$grand_emp_num = 0;
											$tot_dairy_org = 0;
											$tot_dairy = 0;
											$tot_calender_org = 0;
											$tot_calender = 0;
											$grand_tot_calender = 0;
											$grand_tot_calender_org = 0;
											$pre_br_code = '';
										 foreach($all_result as $emp){ 
											if($emp['branch_code'] == $pre_br_code){ 
											$tot_dairy_org += $emp['org_num_dairy'];
											$tot_dairy += $emp['num_dairy'];
											$tot_calender_org += $emp['org_num_calender'];
											$tot_calender += $emp['num_calender'];
											?>
												<tr>
													<td><?php echo $j++;?></td>
													<td><?php echo $emp['emp_name'];?></td> 
													<td><?php echo $emp['emp_id'];?></td>  
													<td><?php echo $emp['designation_name'];?></td> 
													<td><?php echo $emp['num_dairy'];?></td> 
													<td><?php echo $emp['num_calender'];?></td> 
													 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
													<td><?php echo $emp['org_num_dairy'];?></td> 
													<td><?php echo $emp['org_num_calender'];?></td> 
													<?php //} 		 ?>
												</tr>
										
										<?php }else{ 
											$j=1;
											$tot_dairy = 0;
											$tot_dairy_org = 0;
											$tot_calender = 0;
											$tot_calender_org = 0;
											$tot_dairy += $emp['num_dairy'];
											$tot_dairy_org += $emp['org_num_dairy'];
											$tot_calender += $emp['num_calender'];
											$tot_calender_org += $emp['org_num_calender'];
										?> 
												<tr>
														<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $i++;?></td>
														<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $emp['branch_name'];?> </td>
														<td><?php echo $j++;?></td>
														<td><?php echo $emp['emp_name'];?></td> 
														<td><?php echo $emp['emp_id'];?></td>  
														<td><?php echo $emp['designation_name'];?></td> 
														<td><?php echo $emp['num_dairy'];?></td> 
														<td><?php echo $emp['num_calender'];?></td> 
														  <?php// if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
														<td><?php echo $emp['org_num_dairy'];?></td> 
														<td><?php echo $emp['org_num_calender'];?></td> 
														<?php// } 		 ?>
													</tr>
										 <?php   } $pre_br_code = $emp['branch_code'];
										 
											?>  
											<?php	
										if($count[$emp['branch_code']] == ($j-1)){ ?>
											<tr style="background-color:lightgray;">
													<td colspan="2" style="text-align:center;font-weight:bold;">Total</td>
													<td style="font-weight:bold;"><?php $grand_emp_num += $j-1; echo $j-1;?></td>
													<td colspan="3"><?php //echo $tot_dairy;?></td> 
													<td style="font-weight:bold;"><?php $grand_tot_dairy += $tot_dairy; echo $tot_dairy;?></td> 
													<td style="font-weight:bold;"><?php $grand_tot_calender += $tot_calender; echo $tot_calender;?></td> 
													 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
													<td style="font-weight:bold;"><?php $grand_tot_dairy_org += $tot_dairy_org; echo $tot_dairy_org;?></td>
													<td style="font-weight:bold;"><?php $grand_tot_calender_org += $tot_calender_org; echo $tot_calender_org;?></td> 
													 <?php //}		 ?> 
											</tr>
										<?php	} ?> 
										<?php 	  }
											 foreach($branches as $v_branches){
												if(!in_array($v_branches->br_code, $all_branch_code)){?>
													<tr>
														<td><?php echo $i++;?></td>
														<td ><?php echo $v_branches->branch_name;?> </td> 
														<td><?php //echo $emp['designation_name'];?></td> 
														<td><?php //echo $emp['num_dairy'];?></td> 
														<td><?php //echo $emp['num_calender'];?></td> 
														<td><?php //echo $emp['num_calender'];?></td> 
														<td><?php //echo $emp['num_calender'];?></td> 
														<td><?php //echo $emp['num_calender'];?></td> 
														  <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
													    <td><?php //echo $emp['org_num_dairy'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													<?php //} 		 ?>
													</tr>
										<?php 		} 
											} 
										?>
										<tr style="background-color:lightgray;">
													<td colspan="2" style="text-align:center;font-weight:bold;">Grand Total</td>
													<td style="font-weight:bold;"><?php echo $grand_emp_num;?></td>
													<td colspan="3"><?php //echo $tot_dairy;?></td> 
													<td style="font-weight:bold;"><?php echo $grand_tot_dairy;?></td> 
													<td style="font-weight:bold;"><?php echo $grand_tot_calender;?></td> 
													 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
													<td style="font-weight:bold;"><?php echo $grand_tot_dairy_org;?></td> 
													<td style="font-weight:bold;"><?php echo $grand_tot_calender_org;?></td> 
													 <?php //} 		 ?>
													 
											</tr>
									</tbody>
								</table> 									
							<?php 
									}else if($area_code == 'all_a'){ ?>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>SL No</th>
												<th>Area name</th>  
												<th>Diary (Cash Purchase)</th> 
												<th>Calendar (Cash Purchase)</th>
												<?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
												<th>Diary ( Organization )</th> 
												<th>Calendar ( Organization )</th>
												<?php //} 		 ?>
											</tr>
										</thead>
									<tbody> 
									
									<?php 
									$j=1;
									$grand_tot_dairy_org = 0;
									$grand_tot_dairy = 0;
									$grand_tot_calender_org = 0;
									$grand_tot_calender = 0;
									foreach($areas as $v_areas){?>
										
										<?php 
											$i=1;
											
											
											$grand_emp_num = 0;
											$tot_dairy = 0;
											$tot_dairy_org = 0;
											$tot_calender = 0;
											$tot_calender_org = 0;
											
											$pre_br_code = '';
										 foreach($all_result as $emp){ 
											if($emp['area_code'] == $v_areas->area_code){ 
											$tot_dairy_org += $emp['org_num_dairy'];
											$tot_dairy += $emp['num_dairy'];
											$tot_calender += $emp['num_calender'];
											$tot_calender_org += $emp['org_num_calender'];
											?> 
										<?php } ?>
										<?php	} ?> 
										
										<tr>
													<td><?php echo $j++;?></td>
													<td><?php echo $v_areas->area_name;?></td> 
													<td><?php  $grand_tot_dairy += $tot_dairy;echo $tot_dairy;?></td> 
													<td><?php $grand_tot_calender += $tot_calender;echo $tot_calender;?></td> 
													 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
													<td><?php  $grand_tot_dairy_org += $tot_dairy_org; echo $tot_dairy_org;?></td> 
													<td><?php $grand_tot_calender_org += $tot_calender_org;echo $tot_calender_org;?></td> 
													<?php //} 		 ?>
										</tr>
										<?php 	  }
											 
										?> 
										<tr>
													<td><?php //echo $j++;?></td>
													<td></td> 
													<td><?php echo $grand_tot_dairy;?></td> 
													<td><?php echo $grand_tot_calender;?></td> 
													 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
													<td><?php echo $grand_tot_dairy_org;?></td> 
													<td><?php echo $grand_tot_calender_org;?></td> 
													 <?php //} 		 ?>
										</tr>
									</tbody>  
									</table> 
								<?php 	}else{
											if(!empty($br_code)){ ?>
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>SL No</th>
														<th>Branch name</th> 
														<th>Emp No</th> 
														<th>Employee name</th> 
														<th>Emp ID</th>  
														<th>Designation</th> 
														<th>Diary (Cash Purchase)</th> 
														<th>Calendar (Cash Purchase)</th>  
														<?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
														<th>Diary ( Organization )</th> 
														<th>Calendar ( Organization )</th>
														<?php //} 		 ?>
													</tr>
												</thead>
												<tbody> 
												<?php 
												$grand_tot_calender_org = 0;
												$grand_tot_calender = 0;
												$grand_tot_dairy_org = 0;
												$grand_tot_dairy = 0;
												$grand_emp_num = 0;
												foreach($all_branch as $v_branch){ ?>
												
													<?php 
														$i=1;
														$j=1;
														
														
														$tot_dairy_org = 0;
														$tot_dairy = 0;
														$tot_calender_org = 0;
														$tot_calender = 0;
														
														$pre_br_code = '';
													 foreach($all_result as $emp){
														if($emp['branch_code'] == $v_branch->br_code ){ ?>
															<?php 
														if($emp['branch_code'] == $pre_br_code){ 
														$tot_dairy_org += $emp['org_num_dairy'];
														$tot_dairy += $emp['num_dairy'];
														$tot_calender_org += $emp['org_num_calender'];
														$tot_calender += $emp['num_calender'];
														?>
															<tr>
																<td><?php echo $j++;?></td>
																<td><?php echo $emp['emp_name'];?></td> 
																<td><?php echo $emp['emp_id'];?></td>  
																<td><?php echo $emp['designation_name'];?></td> 
																<td><?php echo $emp['num_dairy'];?></td> 
																<td><?php echo $emp['num_calender'];?></td> 
																  <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																<td><?php echo $emp['org_num_dairy'];?></td> 
																<td><?php echo $emp['org_num_calender'];?></td> 
																<?php // } 		 ?>
															</tr>
													
													<?php }else{ 
														$j=1;
														$tot_dairy_org = 0;
														$tot_dairy = 0;
														$tot_calender_org = 0;
														$tot_calender = 0;
														$tot_dairy_org += $emp['org_num_dairy'];
														$tot_dairy += $emp['num_dairy'];
														$tot_calender_org += $emp['org_num_calender'];
														$tot_calender += $emp['num_calender'];
													?> 
															<tr>
																	<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $i++;?></td>
																	<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $emp['branch_name'];?> </td>
																	<td><?php echo $j++;?></td>
																	<td><?php echo $emp['emp_name'];?></td> 
																	<td><?php echo $emp['emp_id'];?></td>  
																	<td><?php echo $emp['designation_name'];?></td> 
																	<td><?php echo $emp['num_dairy'];?></td> 
																	<td><?php echo $emp['num_calender'];?></td> 
																	  <?php // if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																	<td><?php echo $emp['org_num_dairy'];?></td> 
																	<td><?php echo $emp['org_num_calender'];?></td> 
																	<?php //} 		 ?>
																</tr>
													 <?php   } $pre_br_code = $emp['branch_code'];
													 
														?>  
														<?php	
													if($count[$emp['branch_code']] == ($j-1)){ ?>
														<tr style="background-color:lightgray;">
																<td colspan="2" style="text-align:center;font-weight:bold;">Total</td>
																<td style="font-weight:bold;"><?php $grand_emp_num += $j-1; echo $j-1;?></td>
																<td colspan="3"><?php //echo $tot_dairy;?></td> 
																<td style="font-weight:bold;"><?php $grand_tot_dairy += $tot_dairy; echo $tot_dairy;?></td> 
																<td style="font-weight:bold;"><?php $grand_tot_calender += $tot_calender; echo $tot_calender;?></td> 
																  <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?> 
																<td style="font-weight:bold;"><?php $grand_tot_dairy_org += $tot_dairy_org; echo $tot_dairy_org;?></td> 
																<td style="font-weight:bold;"><?php $grand_tot_calender_org += $tot_calender_org; echo $tot_calender_org;?></td> 
																  <?php // } 		 ?>
														</tr>
														<?php	} }?>  
													<?php	} ?>
										<?php		}  ?>
												</tbody> 
											</table> 	
										<?php	}else{ ?>
										<table class="table table-bordered">
												<thead>
													<tr>
														<th>SL No</th>
														<th>Branch name</th> 
														<th>Emp No</th> 
														<th>Employee name</th> 
														<th>Emp ID</th>  
														<th>Designation</th> 
														<th>Diary (Cash Purchase)</th> 
														<th>Calendar (Cash Purchase)</th>  
														<?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
														<th>Diary ( Organization )</th> 
														<th>Calendar ( Organization )</th>
														<?php //} 		 ?>
													</tr>
												</thead>
												<tbody> 
													<?php 
													$grand_tot_calender_org = 0;
													$grand_tot_calender = 0;
													$grand_tot_dairy_org = 0;
													$grand_tot_dairy = 0;
													$grand_emp_num = 0;
													foreach($all_branch as $v_branch){ ?>
													
														<?php 
															$i=1;
															$j=1;
															
															
															$tot_dairy_org = 0;
															$tot_dairy = 0;
															$tot_calender_org = 0;
															$tot_calender = 0;
															
															$pre_br_code = '';
														 foreach($all_result as $emp){
															if($emp['branch_code'] == $v_branch->br_code ){ ?>
																<?php 
															if($emp['branch_code'] == $pre_br_code){ 
															$tot_dairy_org += $emp['org_num_dairy'];
															$tot_dairy += $emp['num_dairy'];
															$tot_calender_org += $emp['org_num_calender'];
															$tot_calender += $emp['num_calender'];
															?>
																<tr>
																	<td><?php echo $j++;?></td>
																	<td><?php echo $emp['emp_name'];?></td> 
																	<td><?php echo $emp['emp_id'];?></td>  
																	<td><?php echo $emp['designation_name'];?></td> 
																	<td><?php echo $emp['num_dairy'];?></td> 
																	<td><?php echo $emp['num_calender'];?></td> 
																	  <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																	<td><?php echo $emp['org_num_dairy'];?></td> 
																	<td><?php echo $emp['org_num_calender'];?></td> 
																	<?php //} 		 ?>
																</tr>
														
														<?php }else{ 
															$j=1;
															$tot_dairy_org = 0;
															$tot_dairy = 0;
															$tot_calender_org = 0;
															$tot_calender = 0;
															$tot_dairy_org += $emp['org_num_dairy'];
															$tot_dairy += $emp['num_dairy'];
															$tot_calender_org += $emp['org_num_calender'];
															$tot_calender += $emp['num_calender'];
														?> 
																<tr>
																		<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $i++;?></td>
																		<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $emp['branch_name'];?> </td>
																		<td><?php echo $j++;?></td>
																		<td><?php echo $emp['emp_name'];?></td> 
																		<td><?php echo $emp['emp_id'];?></td>   
																		<td><?php echo $emp['designation_name'];?></td> 
																		<td><?php echo $emp['num_dairy'];?></td> 
																		<td><?php echo $emp['num_calender'];?></td> 
																		 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																		<td><?php echo $emp['org_num_dairy'];?></td> 
																		<td><?php echo $emp['org_num_calender'];?></td> 
																		<?php //} 		 ?> 
																	</tr>
														 <?php   } $pre_br_code = $emp['branch_code'];
														 
															?>  
															<?php	
														if($count[$emp['branch_code']] == ($j-1)){ ?>
															<tr style="background-color:lightgray;">
																	<td colspan="2" style="text-align:center;font-weight:bold;">Total</td>
																	<td style="font-weight:bold;"><?php $grand_emp_num += $j-1; echo $j-1;?></td>
																	<td colspan="3"><?php //echo $tot_dairy;?></td> 
																	<td style="font-weight:bold;"><?php $grand_tot_dairy += $tot_dairy; echo $tot_dairy;?></td> 
																	<td style="font-weight:bold;"><?php $grand_tot_calender += $tot_calender; echo $tot_calender;?></td>
																	 <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																	<td style="font-weight:bold;"><?php $grand_tot_dairy_org += $tot_dairy_org; echo $tot_dairy_org;?></td> 
																	<td style="font-weight:bold;"><?php $grand_tot_calender_org += $tot_calender_org; echo $tot_calender_org;?></td> 
																	 <?php //} 		 ?>
																	 
															</tr>
															<?php	} }?>  
														<?php	} ?>
											<?php		}  
														foreach($all_branch as $v_branches){
																if(!in_array($v_branches->br_code, $all_branch_code)){?>
																	<tr>
																		<td><?php echo $i++;?></td>
																		<td ><?php echo $v_branches->branch_name;?> </td> 
																		<td><?php //echo $emp['designation_name'];?></td> 
																		<td><?php //echo $emp['num_dairy'];?></td> 
																		<td><?php //echo $emp['num_calender'];?></td> 
																		<td><?php //echo $emp['num_calender'];?></td> 
																		<td><?php //echo $emp['num_calender'];?></td> 
																		<td><?php //echo $emp['num_calender'];?></td> 
																		  <?php //if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																		<td><?php //echo $emp['org_num_dairy'];?></td> 
																		<td><?php //echo $emp['org_num_calender'];?></td> 
																		<?php //} 		 ?>
																	</tr>
														<?php 		} 
															} 
														?>
														<tr style="background-color:lightgray;">
																	<td colspan="2" style="text-align:center;font-weight:bold;">Grand Total</td>
																	<td style="font-weight:bold;"><?php echo $grand_emp_num;?></td>
																	<td colspan="3"><?php //echo $tot_dairy;?></td> 
																	<td style="font-weight:bold;"><?php echo $grand_tot_dairy;?></td> 
																	<td style="font-weight:bold;"><?php echo $grand_tot_calender;?></td> 
																	 <?php if(( $user_type == 1 ) || ($user_type == 2 )) { 		 ?>
																	<td style="font-weight:bold;"><?php echo $grand_tot_dairy_org;?></td> 
																	<td style="font-weight:bold;"><?php echo $grand_tot_calender_org;?></td> 
																	 <?php } 		 ?>
																	 
															</tr>
													</tbody> 
													</table> 
										<?php	} ?>
										
										
						<?php 		} 
						?>
						   
					
					<div id="footer"></div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<script type="text/javascript"><!--


$(document).on("change", "#area_code", function () {
	var area_code = document.getElementById("area_code").value;
	 //alert(area_code);
		  $.ajax({
			type: "GET",
			dataType: 'json',
			url : "<?php echo e(URL::to('get_branch_by_area')); ?>"+"/"+area_code, 
			success: function(data)
			{
				var t_row ="<option value='' >-Select-</option>"; 
				 for(var x in data["data"]) {
						  t_row += "<option value="+data["data"][x]["br_code"]+">"+data["data"][x]["branch_name"]+"</option>";
					   } 
				$('#br_code').html(t_row);
			}
		}); 
})








$(document).ready(function() { 
	document.getElementById("br_code").value="<?php echo e($br_code); ?>";
	document.getElementById("area_code").value="<?php echo e($area_code); ?>";
});
//--></script>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-bordered th {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:2px;font: 11px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + 'table {' +
			'border-collapse: collapse;' +
			'width:100%;' +
			'}' + 'body {' +
			'margin-left: 10px;' +
			'}' + '#footer {' +
			'position: fixed;bottom: 0;' +
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
    }
</script> 
	<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupRequisition").addClass('active');
			$("#Requisition_Report").addClass('active');
			//$('[id^=Previous_Leave_Balance]').addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>