@extends('admin.admin_master')
@section('title', 'Shoe Size Report')
@section('main_content')
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
		<h1>Shoe<small>size</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Shoe size</a></li>
			<li class="active">Report</li>
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
					<form class="form-inline report" action="{{URL::to('/shoe_size_rprt_post')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="area_code">Area Name :</label>
							<select class="form-control" id="area_code" name="area_code" required>						
								<option value="" hidden>-Select-</option>
								<option value="all" >ALL</option>
								<option value="all_a" >ALL consolidated</option>
								@foreach ($areas as $v_area)
									<option value="{{$v_area->area_code}}">{{$v_area->area_name}}</option>
								@endforeach
							</select> 
							<label for="br_code">Branch Name :</label>
							<select class="form-control" id="br_code" name="br_code">
								@if (!empty($all_branch))
									@foreach ($all_branch as $v_branch)
										<option value="{{$v_branch->br_code}}">{{$v_branch->branch_name}}</option>
									@endforeach 
								@endif 
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
					<div id="header"><?php echo date("d/m/Y");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://45.114.85.154/hrm/shoe_size_rprt</div>
						<div class="col-md-12">
							<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
							<b><font size="4">Shoe Size Report</font></b></p>		
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
										<th>Shoe Size 5( Male )</th>   
										<th>Shoe Size 6( Male )</th>   
										<th>Shoe Size 7( Male )</th>   
										<th>Shoe Size 8( Male )</th>   
										<th>Shoe Size 9( Male )</th>   
										<th>Shoe Size 10( Male )</th>   
										<th>Shoe Size 3( Female )</th>   
										<th>Shoe Size 4( Female )</th>   
										<th>Shoe Size 5( Female )</th>   
										<th>Shoe Size 6( Female )</th>    
									</tr>
								</thead>
										
								
									<tbody> 
										<?php 
											$i=1;
											$j=1;
											$grand_tot_size = 0; 
											$grand_emp_num = 0;
											$tot_size = 0;
											$grand_tot_size_male_5 = 0;
											$grand_tot_size_male_6 = 0;
											$grand_tot_size_male_7 = 0;
											$grand_tot_size_male_8 = 0;
											$grand_tot_size_male_9 = 0;
											$grand_tot_size_male_10 = 0;
											$grand_tot_size_female_3 = 0;
											$grand_tot_size_female_4 = 0;
											$grand_tot_size_female_5 = 0;
											$grand_tot_size_female_6 = 0;	
											$pre_br_code = '';
											
											$tot_size_male_5 = 0;
												$tot_size_male_6 = 0;
												$tot_size_male_7 = 0;
												$tot_size_male_8 = 0;
												$tot_size_male_9 = 0;
												$tot_size_male_10 = 0;
												$tot_size_female_3 = 0;
												$tot_size_female_4 = 0;
												$tot_size_female_5 = 0;
												$tot_size_female_6 = 0;
												
										 foreach($all_result as $emp){ 
											if($emp['branch_code'] == $pre_br_code){ 
												$tot_size += $emp['size'];
												if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
												 
												if( $emp['size'] == "5"){
													$tot_size_male_5 += 1;
												}else if($emp['size'] == "6"){
													$tot_size_male_6 += 1;
												}else if($emp['size'] == "7"){
													$tot_size_male_7 += 1;
												}else if($emp['size'] == "8"){
													$tot_size_male_8 += 1;
												}else if($emp['size'] == "9"){
													$tot_size_male_9 += 1;
												}else if($emp['size'] == "10"){
													$tot_size_male_10 += 1;
												}
												
												 
												  
											}else{
												if( $emp['size'] == "3"){
													$tot_size_female_3 += 1;
												}else if($emp['size'] == "4"){
													$tot_size_female_4 += 1;
												}else if($emp['size'] == "5"){
													$tot_size_female_5 += 1;
												}else if($emp['size'] == "6"){
													$tot_size_female_6 += 1;
												}
												 
											}
												
											?>
												<tr>
													<td><?php echo $j++;?></td>
													<td><?php echo $emp['emp_name'];?></td> 
													<td><?php echo $emp['emp_id'];?></td> 
													<td><?php echo $emp['designation_name'];?></td>  
													<?php if(($emp['gender'] == "male") ||($emp['gender'] == "Male")){ ?> 
													<td><?php if($emp['size'] == "5")  echo 1;?></td>
													<td><?php if($emp['size'] == "6")  echo 1;?></td>
													<td><?php if($emp['size'] == "7")  echo 1;?></td>
													<td><?php if($emp['size'] == "8")  echo 1;?></td>
													<td><?php if($emp['size'] == "9")  echo 1;?></td>
													<td><?php if($emp['size'] == "10")  echo 1;?></td>
													
													
													<?php  }else{ ?>
														
														<td> </td>
														<td> </td>
														<td> </td>
														<td> </td>
														<td> </td>
														<td> </td>
													 
													<?php } 
														if(($emp['gender'] == "female") ||($emp['gender'] == "Female")){ ?>
														
															<td><?php if($emp['size'] == "3")  echo 1;?></td>
															<td><?php if($emp['size'] == "4")  echo 1;?></td>
															<td><?php if($emp['size'] == "5")  echo 1;?></td>
															<td><?php if($emp['size'] == "6")  echo 1;?></td>
													<?php
														}else{ ?>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
													<?php	}
													?> 
												</tr>
										
										<?php }else{ 
											$j=1;
											$tot_size = 0;
											$tot_size_male_5 = 0;
											$tot_size_male_6 = 0;
											$tot_size_male_7 = 0;
											$tot_size_male_8 = 0;
											$tot_size_male_9 = 0;
											$tot_size_male_10 = 0;
											$tot_size_female_3 = 0;
											$tot_size_female_4 = 0;
											$tot_size_female_5 = 0;
											$tot_size_female_6 = 0;
											$tot_size += $emp['size'];
											if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
												 
												if( $emp['size'] == "5"){
													$tot_size_male_5 += 1;
												}else if($emp['size'] == "6"){
													$tot_size_male_6 += 1;
												}else if($emp['size'] == "7"){
													$tot_size_male_7 += 1;
												}else if($emp['size'] == "8"){
													$tot_size_male_8 += 1;
												}else if($emp['size'] == "9"){
													$tot_size_male_9 += 1;
												}else if($emp['size'] == "10"){
													$tot_size_male_10 += 1;
												}
												
												 
												  
											}else{
												if( $emp['size'] == "3"){
													$tot_size_female_3 += 1;
												}else if($emp['size'] == "4"){
													$tot_size_female_4 += 1;
												}else if($emp['size'] == "5"){
													$tot_size_female_5 += 1;
												}else if($emp['size'] == "6"){
													$tot_size_female_6 += 1;
												}
												 
											}	
										?> 
												<tr>
														<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $i++;?></td>
														<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $emp['branch_name'];?> </td>
														<td><?php echo $j++;?></td>
														<td><?php echo $emp['emp_name'];?></td> 
														<td><?php echo $emp['emp_id'];?></td> 
														<td><?php echo $emp['designation_name'];?></td> 
														<?php if(($emp['gender'] == "male") ||($emp['gender'] == "Male")){ ?> 
																<td><?php if($emp['size'] == "5")  echo 1;?></td>
																<td><?php if($emp['size'] == "6")  echo 1;?></td>
																<td><?php if($emp['size'] == "7")  echo 1;?></td>
																<td><?php if($emp['size'] == "8")  echo 1;?></td>
																<td><?php if($emp['size'] == "9")  echo 1;?></td>
																<td><?php if($emp['size'] == "10")  echo 1;?></td>
																
																
																<?php  }else{ ?>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																<?php } 
																	if(($emp['gender'] == "female") ||($emp['gender'] == "Female")){ ?>
																	
																		<td><?php if($emp['size'] == "3")  echo 1;?></td>
																		<td><?php if($emp['size'] == "4")  echo 1;?></td>
																		<td><?php if($emp['size'] == "5")  echo 1;?></td>
																		<td><?php if($emp['size'] == "6")  echo 1;?></td>
																<?php
																	}else{ ?>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td></td>
																<?php
																	}
																?>   
													</tr>
										 <?php   } $pre_br_code = $emp['branch_code'];
										 
											?>  
											<?php	
										if($count[$emp['branch_code']] == ($j-1)){ ?>
											<tr style="background-color:lightgray;">
													<td colspan="2" style="text-align:center;font-weight:bold;">Total</td>
													<td style="font-weight:bold;"><?php $grand_emp_num += $j-1; echo $j-1;?></td>
													<td colspan="3"> </td>  
													 
													 	<td style="font-weight:bold;"><?php $grand_tot_size_male_5 += $tot_size_male_5; echo $tot_size_male_5;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_6 += $tot_size_male_6; echo $tot_size_male_6;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_7 += $tot_size_male_7; echo $tot_size_male_7;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_8 += $tot_size_male_8; echo $tot_size_male_8;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_9 += $tot_size_male_9; echo $tot_size_male_9;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_10 += $tot_size_male_10; echo $tot_size_male_10;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_3 += $tot_size_female_3; echo $tot_size_female_3;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_4 += $tot_size_female_4; echo $tot_size_female_4;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_5 += $tot_size_female_5; echo $tot_size_female_5;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_6 += $tot_size_female_6; echo $tot_size_female_6;?></td>  
																 
											</tr>
										<?php	} ?> 
										<?php 	  }
											 foreach($branches as $v_branches){
												if(!in_array($v_branches->br_code, $all_branch_code)){?>
													<tr>
														<td><?php echo $i++;?></td>
														<td ><?php echo $v_branches->branch_name;?> </td>
														<td><?php //echo $emp['designation_name'];?></td>  
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
													    <td><?php //echo $emp['org_num_calender'];?></td> 
														
													</tr>
										<?php 		} 
											} 
										?>
										<tr style="background-color:lightgray;">
													<td colspan="2" style="text-align:center;font-weight:bold;">Grand Total</td>
													<td style="font-weight:bold;"><?php echo $grand_emp_num;?></td>
													<td colspan="3"><?php //echo $tot_dairy;?></td>  
													<td style="font-weight:bold;"><?php echo $grand_tot_size_male_5;?></td>
													<td style="font-weight:bold;"><?php echo $grand_tot_size_male_6;?></td>
													<td style="font-weight:bold;"><?php echo $grand_tot_size_male_7;?></td>
													<td style="font-weight:bold;"><?php echo $grand_tot_size_male_8;?></td>
													<td style="font-weight:bold;"><?php echo $grand_tot_size_male_9;?></td>
													<td style="font-weight:bold;"><?php echo $grand_tot_size_male_10;?></td>
													<td style="font-weight:bold;"><?php echo $grand_tot_size_female_3;?></td>  
													<td style="font-weight:bold;"><?php echo $grand_tot_size_female_4;?></td>  
													<td style="font-weight:bold;"><?php echo $grand_tot_size_female_5;?></td>  
													<td style="font-weight:bold;"><?php echo $grand_tot_size_female_6;?></td>  
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
												<th>Shoe Size 5( Male )</th>   
												<th>Shoe Size 6( Male )</th>   
												<th>Shoe Size 7( Male )</th>   
												<th>Shoe Size 8( Male )</th>   
												<th>Shoe Size 9( Male )</th>   
												<th>Shoe Size 10( Male )</th>   
												<th>Shoe Size 3( Female )</th>   
												<th>Shoe Size 4( Female )</th>   
												<th>Shoe Size 5( Female )</th>   
												<th>Shoe Size 6( Female )</th>   
												    
											 
											</tr>
										</thead>
									<tbody> 
									
									<?php 
									$j=1; 
									$grand_tot_size = 0;
											$grand_tot_size_male_5 = 0;
											$grand_tot_size_male_6 = 0;
											$grand_tot_size_male_7 = 0;
											$grand_tot_size_male_8 = 0;
											$grand_tot_size_male_9 = 0;
											$grand_tot_size_male_10 = 0;
											$grand_tot_size_female_3 = 0;
											$grand_tot_size_female_4 = 0;
											$grand_tot_size_female_5 = 0;
											$grand_tot_size_female_6 = 0;	
									foreach($areas as $v_areas){?>
										
										<?php 
											$i=1;
											
											
											$grand_emp_num = 0; 
											$tot_size_male_5 = 0;
											$tot_size_male_6 = 0;
											$tot_size_male_7 = 0;
											$tot_size_male_8 = 0;
											$tot_size_male_9 = 0;
											$tot_size_male_10 = 0;
											$tot_size_female_3 = 0;
											$tot_size_female_4 = 0;
											$tot_size_female_5 = 0;
											$tot_size_female_6 = 0;
											
											$tot_size = 0;
											
											$pre_br_code = '';
										 foreach($all_result as $emp){ 
											if($emp['area_code'] == $v_areas->area_code){  
											$tot_size += $emp['size']; 
											if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
												 
												if( $emp['size'] == "5"){
													$tot_size_male_5 += 1;
												}else if($emp['size'] == "6"){
													$tot_size_male_6 += 1;
												}else if($emp['size'] == "7"){
													$tot_size_male_7 += 1;
												}else if($emp['size'] == "8"){
													$tot_size_male_8 += 1;
												}else if($emp['size'] == "9"){
													$tot_size_male_9 += 1;
												}else if($emp['size'] == "10"){
													$tot_size_male_10 += 1;
												}
												
												 
												  
											}else{
												if( $emp['size'] == "3"){
													$tot_size_female_3 += 1;
												}else if($emp['size'] == "4"){
													$tot_size_female_4 += 1;
												}else if($emp['size'] == "5"){
													$tot_size_female_5 += 1;
												}else if($emp['size'] == "6"){
													$tot_size_female_6 += 1;
												}
												 
											}
											?> 
										<?php } ?>
										<?php	} ?> 
										
										<tr>
													<td><?php echo $j++;?></td>
													<td><?php echo $v_areas->area_name;?></td> 
													<td><?php $grand_tot_size_male_5 += $tot_size_male_5; echo $tot_size_male_5; ?></td>  
													<td><?php $grand_tot_size_male_6 += $tot_size_male_6; echo $tot_size_male_6; ?></td>  
													<td><?php $grand_tot_size_male_7 += $tot_size_male_7; echo $tot_size_male_7; ?></td>  
													<td><?php $grand_tot_size_male_8 += $tot_size_male_8; echo $tot_size_male_8; ?></td>  
													<td><?php $grand_tot_size_male_9 += $tot_size_male_9; echo $tot_size_male_9; ?></td>  
													<td><?php $grand_tot_size_male_10 += $tot_size_male_10; echo $tot_size_male_10; ?></td>  
													<td><?php $grand_tot_size_female_3 += $tot_size_female_3; echo $tot_size_female_3; ?></td>  
													<td><?php $grand_tot_size_female_4 += $tot_size_female_4; echo $tot_size_female_4; ?></td>  
													<td><?php $grand_tot_size_female_5 += $tot_size_female_5; echo $tot_size_female_5; ?></td>  
													<td><?php $grand_tot_size_female_6 += $tot_size_female_6; echo $tot_size_female_6; ?></td>  
										</tr>
										<?php 	  }
											 
										?> 
										<tr>
													<td><?php //echo $j++;?></td>
													<td></td> 
													<td><?php echo $grand_tot_size_male_5 ; ?></td>  
													<td><?php echo $grand_tot_size_male_6 ; ?></td>  
													<td><?php echo $grand_tot_size_male_7 ; ?></td>  
													<td><?php echo $grand_tot_size_male_8 ; ?></td>  
													<td><?php echo $grand_tot_size_male_9 ; ?></td>  
													<td><?php echo $grand_tot_size_male_10 ; ?></td>  
													<td><?php echo $grand_tot_size_female_3 ; ?></td>  
													<td><?php echo $grand_tot_size_female_4; ?></td>  
													<td><?php echo $grand_tot_size_female_5 ; ?></td>  
													<td><?php echo $grand_tot_size_female_6; ?></td>
										</tr>
										<tr>
													<td>Grand Total</td>
													<td colspan="9"></td> 
													 
													<td><?php echo ($grand_tot_size_male_5 + $grand_tot_size_male_6 + $grand_tot_size_male_7 + $grand_tot_size_male_8 + $grand_tot_size_male_9 + $grand_tot_size_male_10 + $grand_tot_size_female_3 + $grand_tot_size_female_4 + $grand_tot_size_female_5 + $grand_tot_size_female_6);  ?></td>  
													
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
														<th>Shoe Size 5( Male )</th>   
														<th>Shoe Size 6( Male )</th>   
														<th>Shoe Size 7( Male )</th>   
														<th>Shoe Size 8( Male )</th>   
														<th>Shoe Size 9( Male )</th>   
														<th>Shoe Size 10( Male )</th>   
														<th>Shoe Size 3( Female )</th>   
														<th>Shoe Size 4( Female )</th>   
														<th>Shoe Size 5( Female )</th>   
														<th>Shoe Size 6( Female )</th>  
													</tr>
												</thead>
												<tbody> 
												<?php  
												$grand_tot_size = 0;
												$grand_tot_size_male_5 = 0;
												$grand_tot_size_male_6 = 0;
												$grand_tot_size_male_7 = 0;
											$grand_tot_size_male_8 = 0;
											$grand_tot_size_male_9 = 0;
											$grand_tot_size_male_10 = 0;
											$grand_tot_size_female_3 = 0;
											$grand_tot_size_female_4 = 0;
											$grand_tot_size_female_5 = 0;
											$grand_tot_size_female_6 = 0;	
												$grand_emp_num = 0;
												foreach($all_branch as $v_branch){ ?>
												
													<?php 
														$i=1;
														$j=1;  
														$tot_size = 0; 
														$tot_size_male_5 = 0;
														$tot_size_male_6 = 0;
														$tot_size_male_7 = 0;
														$tot_size_male_8 = 0;
														$tot_size_male_9 = 0;
														$tot_size_male_10 = 0;
														$tot_size_female_3 = 0;
														$tot_size_female_4 = 0;
														$tot_size_female_5 = 0;
														$tot_size_female_6 = 0;
														$pre_br_code = '';
														 
													 foreach($all_result as $emp){
														if($emp['branch_code'] == $v_branch->br_code ){ 
														 
														
														?>
															<?php 
														if($emp['branch_code'] == $pre_br_code){  
														
														$tot_size += $emp['size']; 
														if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
												 
															if( $emp['size'] == "5"){
																$tot_size_male_5 += 1;
															}else if($emp['size'] == "6"){
																$tot_size_male_6 += 1;
															}else if($emp['size'] == "7"){
																$tot_size_male_7 += 1;
															}else if($emp['size'] == "8"){
																$tot_size_male_8 += 1;
															}else if($emp['size'] == "9"){
																$tot_size_male_9 += 1;
															}else if($emp['size'] == "10"){
																$tot_size_male_10 += 1;
															}
															
															 
															  
														}else{
															if( $emp['size'] == "3"){
																$tot_size_female_3 += 1;
															}else if($emp['size'] == "4"){
																$tot_size_female_4 += 1;
															}else if($emp['size'] == "5"){
																$tot_size_female_5 += 1;
															}else if($emp['size'] == "6"){
																$tot_size_female_6 += 1;
															}
															 
														}
														
														
														
														
														?>
															<tr>
																<td><?php echo $j++;?></td>
																<td><?php echo $emp['emp_name'];?></td> 
																<td><?php echo $emp['emp_id'];?></td> 
																<td><?php echo $emp['designation_name'];?></td> 
																<?php if(($emp['gender'] == "male") ||($emp['gender'] == "Male")){ ?> 
																<td><?php if($emp['size'] == "5")  echo 1;?></td>
																<td><?php if($emp['size'] == "6")  echo 1;?></td>
																<td><?php if($emp['size'] == "7")  echo 1;?></td>
																<td><?php if($emp['size'] == "8")  echo 1;?></td>
																<td><?php if($emp['size'] == "9")  echo 1;?></td>
																<td><?php if($emp['size'] == "10")  echo 1;?></td>
																
																
																<?php  }else{ ?>
																	
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																 
																<?php } 
																	if(($emp['gender'] == "female") ||($emp['gender'] == "Female")){ ?>
																	
																		<td><?php if($emp['size'] == "3")  echo 1;?></td>
																		<td><?php if($emp['size'] == "4")  echo 1;?></td>
																		<td><?php if($emp['size'] == "5")  echo 1;?></td>
																		<td><?php if($emp['size'] == "6")  echo 1;?></td>
																<?php
																	}else{ ?>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td></td>
																<?php	}
																?> 
															</tr>
													
													<?php }else{ 
														$j=1; 
														$tot_size = 0; 
														$tot_size += $emp['size'];
														if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
												 
															if( $emp['size'] == "5"){
																$tot_size_male_5 += 1;
															}else if($emp['size'] == "6"){
																$tot_size_male_6 += 1;
															}else if($emp['size'] == "7"){
																$tot_size_male_7 += 1;
															}else if($emp['size'] == "8"){
																$tot_size_male_8 += 1;
															}else if($emp['size'] == "9"){
																$tot_size_male_9 += 1;
															}else if($emp['size'] == "10"){
																$tot_size_male_10 += 1;
															}
															
															 
															  
														}else{
															if( $emp['size'] == "3"){
																$tot_size_female_3 += 1;
															}else if($emp['size'] == "4"){
																$tot_size_female_4 += 1;
															}else if($emp['size'] == "5"){
																$tot_size_female_5 += 1;
															}else if($emp['size'] == "6"){
																$tot_size_female_6 += 1;
															}
															 
														}
													?> 
															<tr>
																	<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $i++;?></td>
																	<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $emp['branch_name'];?> </td>
																	<td><?php echo $j++;?></td>
																	<td><?php echo $emp['emp_name'];?></td> 
																	<td><?php echo $emp['emp_id'];?></td>  
																	<td><?php echo $emp['designation_name'];?></td> 
																	<?php if(($emp['gender'] == "male") ||($emp['gender'] == "Male")){ ?> 
																<td><?php if($emp['size'] == "5")  echo 1;?></td>
																<td><?php if($emp['size'] == "6")  echo 1;?></td>
																<td><?php if($emp['size'] == "7")  echo 1;?></td>
																<td><?php if($emp['size'] == "8")  echo 1;?></td>
																<td><?php if($emp['size'] == "9")  echo 1;?></td>
																<td><?php if($emp['size'] == "10")  echo 1;?></td>
																
																
																<?php  }else{ ?>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																	<td> </td>
																<?php } 
																	if(($emp['gender'] == "female") ||($emp['gender'] == "Female")){ ?>
																	
																		<td><?php if($emp['size'] == "3")  echo 1;?></td>
																		<td><?php if($emp['size'] == "4")  echo 1;?></td>
																		<td><?php if($emp['size'] == "5")  echo 1;?></td>
																		<td><?php if($emp['size'] == "6")  echo 1;?></td>
																<?php
																	}else{ ?>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td></td>
																<?php
																	}
																?>   
																</tr>
													 <?php   } $pre_br_code = $emp['branch_code'];
													 
														?>  
														<?php	
													if($count[$emp['branch_code']] == ($j-1)){ ?>
														<tr style="background-color:lightgray;">
																<td colspan="2" style="text-align:center;font-weight:bold;">Total</td>
																<td style="font-weight:bold;"><?php $grand_emp_num += $j-1; echo $j-1;?></td>
																<td colspan="3"><?php //echo $tot_dairy;?></td> 
																<td style="font-weight:bold;"><?php $grand_tot_size_male_5 += $tot_size_male_5; echo $tot_size_male_5;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_6 += $tot_size_male_6; echo $tot_size_male_6;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_7 += $tot_size_male_7; echo $tot_size_male_7;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_8 += $tot_size_male_8; echo $tot_size_male_8;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_9 += $tot_size_male_9; echo $tot_size_male_9;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_male_10 += $tot_size_male_10; echo $tot_size_male_10;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_3 += $tot_size_female_3; echo $tot_size_female_3;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_4 += $tot_size_female_4; echo $tot_size_female_4;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_5 += $tot_size_female_5; echo $tot_size_female_5;?></td>  
																<td style="font-weight:bold;"><?php $grand_tot_size_female_6 += $tot_size_female_6; echo $tot_size_female_6;?></td>  
																 
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
														<th>Shoe Size 5( Male )</th>   
														<th>Shoe Size 6( Male )</th>   
														<th>Shoe Size 7( Male )</th>   
														<th>Shoe Size 8( Male )</th>   
														<th>Shoe Size 9( Male )</th>   
														<th>Shoe Size 10( Male )</th>   
														<th>Shoe Size 3( Female )</th>   
														<th>Shoe Size 4( Female )</th>   
														<th>Shoe Size 5( Female )</th>   
														<th>Shoe Size 6( Female )</th>  
													</tr>
												</thead>
												<tbody> 
													<?php  
													$grand_tot_size = 0;
													$grand_tot_size_male_5 = 0;
													$grand_tot_size_male_6 = 0;
													$grand_tot_size_male_7 = 0;
													$grand_tot_size_male_8 = 0;
													$grand_tot_size_male_9 = 0;
													$grand_tot_size_male_10 = 0;
													$grand_tot_size_female_3 = 0;
													$grand_tot_size_female_4 = 0;
													$grand_tot_size_female_5 = 0;
													$grand_tot_size_female_6 = 0;
													$grand_emp_num = 0;
													foreach($all_branch as $v_branch){ ?>
													
														<?php 
															$i=1;
															$j=1;  
															$tot_size = 0; 
															$tot_size_male_5 = 0;
															$tot_size_male_6 = 0;
															$tot_size_male_7 = 0;
															$tot_size_male_8 = 0;
															$tot_size_male_9 = 0;
															$tot_size_male_10 = 0;
															$tot_size_female_3 = 0;
															$tot_size_female_4 = 0;
															$tot_size_female_5 = 0;
															$tot_size_female_6 = 0;
															$pre_br_code = '';
														 foreach($all_result as $emp){
															if($emp['branch_code'] == $v_branch->br_code ){ ?>
																<?php 
															if($emp['branch_code'] == $pre_br_code){ 
															$tot_size += $emp['size']; 
																if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
													 
																if( $emp['size'] == "5"){
																	$tot_size_male_5 += 1;
																}else if($emp['size'] == "6"){
																	$tot_size_male_6 += 1;
																}else if($emp['size'] == "7"){
																	$tot_size_male_7 += 1;
																}else if($emp['size'] == "8"){
																	$tot_size_male_8 += 1;
																}else if($emp['size'] == "9"){
																	$tot_size_male_9 += 1;
																}else if($emp['size'] == "10"){
																	$tot_size_male_10 += 1;
																}
																
																 
																  
															}else{
																if( $emp['size'] == "3"){
																	$tot_size_female_3 += 1;
																}else if($emp['size'] == "4"){
																	$tot_size_female_4 += 1;
																}else if($emp['size'] == "5"){
																	$tot_size_female_5 += 1;
																}else if($emp['size'] == "6"){
																	$tot_size_female_6 += 1;
																}
																 
															}
															
													
															?>
																<tr>
																	<td><?php echo $j++;?></td>
																	<td><?php echo $emp['emp_name'];?></td> 
																	<td><?php echo $emp['emp_id'];?></td> 
																	<td><?php echo $emp['designation_name'];?></td> 
																	<?php if(($emp['gender'] == "male") ||($emp['gender'] == "Male")){ ?> 
																	<td><?php if($emp['size'] == "5")  echo 1;?></td>
																	<td><?php if($emp['size'] == "6")  echo 1;?></td>
																	<td><?php if($emp['size'] == "7")  echo 1;?></td>
																	<td><?php if($emp['size'] == "8")  echo 1;?></td>
																	<td><?php if($emp['size'] == "9")  echo 1;?></td>
																	<td><?php if($emp['size'] == "10")  echo 1;?></td>
																	
																	
																	<?php  }else{ ?>
																		
																		<td> </td>
																		<td> </td>
																		<td> </td>
																		<td> </td>
																		<td> </td>
																		<td> </td>
																	 
																	<?php } 
																		if(($emp['gender'] == "female") ||($emp['gender'] == "Female")){ ?>
																		
																			<td><?php if($emp['size'] == "3")  echo 1;?></td>
																			<td><?php if($emp['size'] == "4")  echo 1;?></td>
																			<td><?php if($emp['size'] == "5")  echo 1;?></td>
																			<td><?php if($emp['size'] == "6")  echo 1;?></td>
																	<?php
																		}else{ ?>
																			<td></td>
																			<td></td>
																			<td></td>
																			<td></td>
																	<?php	}
																	?>  
																</tr>
														
														<?php }else{ 
															$j=1;
															$tot_size = 0; 
															$tot_size_male_5 = 0;
															$tot_size_male_6 = 0;
															$tot_size_male_7 = 0;
															$tot_size_male_8 = 0;
															$tot_size_male_9 = 0;
															$tot_size_male_10 = 0;
															$tot_size_female_3 = 0;
															$tot_size_female_4 = 0;
															$tot_size_female_5 = 0;
															$tot_size_female_6 = 0;
															if(($emp['gender'] == "male")||($emp['gender'] == "Male")){
												 
															if( $emp['size'] == "5"){
																$tot_size_male_5 += 1;
															}else if($emp['size'] == "6"){
																$tot_size_male_6 += 1;
															}else if($emp['size'] == "7"){
																$tot_size_male_7 += 1;
															}else if($emp['size'] == "8"){
																$tot_size_male_8 += 1;
															}else if($emp['size'] == "9"){
																$tot_size_male_9 += 1;
															}else if($emp['size'] == "10"){
																$tot_size_male_10 += 1;
															}
															
															 
															  
														}else{
															if( $emp['size'] == "3"){
																$tot_size_female_3 += 1;
															}else if($emp['size'] == "4"){
																$tot_size_female_4 += 1;
															}else if($emp['size'] == "5"){
																$tot_size_female_5 += 1;
															}else if($emp['size'] == "6"){
																$tot_size_female_6 += 1;
															}
															 
														}
															$tot_size += $emp['size']; 
														?> 
																<tr>
																		<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $i++;?></td>
																		<td rowspan="<?php echo $count[$emp['branch_code']];?>"><?php echo $emp['branch_name'];?> </td>
																		<td><?php echo $j++;?></td>
																		<td><?php echo $emp['emp_name'];?></td> 
																		<td><?php echo $emp['emp_id'];?></td>  
																		<td><?php echo $emp['designation_name'];?></td> 
																		 <?php if(($emp['gender'] == "male") ||($emp['gender'] == "Male")){ ?> 
																		<td><?php if($emp['size'] == "5")  echo 1;?></td>
																		<td><?php if($emp['size'] == "6")  echo 1;?></td>
																		<td><?php if($emp['size'] == "7")  echo 1;?></td>
																		<td><?php if($emp['size'] == "8")  echo 1;?></td>
																		<td><?php if($emp['size'] == "9")  echo 1;?></td>
																		<td><?php if($emp['size'] == "10")  echo 1;?></td>
																		
																		
																		<?php  }else{ ?>
																			
																			<td> </td>
																			<td> </td>
																			<td> </td>
																			<td> </td>
																			<td> </td>
																			<td> </td>
																		 
																		<?php } 
																			if(($emp['gender'] == "female") ||($emp['gender'] == "Female")){ ?>
																			
																				<td><?php if($emp['size'] == "3")  echo 1;?></td>
																				<td><?php if($emp['size'] == "4")  echo 1;?></td>
																				<td><?php if($emp['size'] == "5")  echo 1;?></td>
																				<td><?php if($emp['size'] == "6")  echo 1;?></td>
																		<?php
																			}else{ ?>
																				<td></td>
																				<td></td>
																				<td></td>
																				<td></td>
																		<?php	}
																		?> 
																	</tr>
														 <?php   } $pre_br_code = $emp['branch_code'];
														 
															?>  
															<?php	
														if($count[$emp['branch_code']] == ($j-1)){ ?>
															<tr style="background-color:lightgray;">
																	<td colspan="2" style="text-align:center;font-weight:bold;">Total</td>
																	<td style="font-weight:bold;"><?php $grand_emp_num += $j-1; echo $j-1;?></td>
																	<td colspan="3"><?php //echo $tot_dairy;?></td> 
																	<td style="font-weight:bold;"><?php $grand_tot_size_male_5 += $tot_size_male_5; echo $tot_size_male_5;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_male_6 += $tot_size_male_6; echo $tot_size_male_6;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_male_7 += $tot_size_male_7; echo $tot_size_male_7;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_male_8 += $tot_size_male_8; echo $tot_size_male_8;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_male_9 += $tot_size_male_9; echo $tot_size_male_9;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_male_10 += $tot_size_male_10; echo $tot_size_male_10;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_female_3 += $tot_size_female_3; echo $tot_size_female_3;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_female_4 += $tot_size_female_4; echo $tot_size_female_4;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_female_5 += $tot_size_female_5; echo $tot_size_female_5;?></td>  
																	<td style="font-weight:bold;"><?php $grand_tot_size_female_6 += $tot_size_female_6; echo $tot_size_female_6;?></td>
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
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_male_5;?></td>
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_male_6;?></td>
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_male_7;?></td>
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_male_8;?></td>
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_male_9;?></td>
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_male_10;?></td>
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_female_3;?></td>  
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_female_4;?></td>  
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_female_5;?></td>  
																	<td style="font-weight:bold;"><?php echo $grand_tot_size_female_6;?></td>  
																	 
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
			url : "{{URL::to('get_branch_by_area')}}"+"/"+area_code, 
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
	document.getElementById("br_code").value="{{$br_code}}";
	document.getElementById("area_code").value="{{$area_code}}";
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
			$("#Shoe_Size_Report").addClass('active');
			//$('[id^=Previous_Leave_Balance]').addClass('active');
		});
	</script>
@endsection