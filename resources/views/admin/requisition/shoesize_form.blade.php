@extends('admin.admin_master')
@section('main_content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>shoesize<small></small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">shoesize</a></li>
			<li class="active">Shoesize</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<?php if(!empty($all_result)){?>
				<br>
				<br>
				<form class="form-horizontal"  action="{{URL::to('/insert_shoesize')}}" role="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} 
						<table class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>  
									<th>Emp Name</th>
									<th>Designation</th> 
									<th>Gender</th> 
									<th>Shoe Size</th>  
								</tr>
							</thead>
							<tbody>
								
								<?php
									$designation_code_array = array(236,248,238,231,237,240,242,232,247,233,230);
									$designation_code_array_ho = array(236,248,238,231,237,240,242,232,247,233,230,52,75);
									$i=1;
									$all_emp_id = '';
								 foreach($all_result as $emp){
									if($emp['br_code'] != 9999){
										 
									 if(!in_array($emp['designation_code'],$designation_code_array)){ 
									 	
									?> 
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $emp['emp_id'];?>
									<input type="hidden" name="emp_id[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['emp_id'];?>">
									</td> 
									<td><?php echo $emp['emp_name'];?> </td>
									<td><?php echo $emp['designation_name'];?>
									<input type="hidden" name="designation_code[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['designation_code'];?>">
									</td> 
									<td> 
									
									<?php  
											 
											if(($emp['gender'] == 'Male' )|| ($emp['gender'] == 'male')){
												echo "Male";
											}else if(($emp['gender'] == 'Female')||($emp['gender'] == 'female')){
												echo "Female";
											}
										  ?>
									</td>  
									<td>
									<select type="text"  name="size[<?php echo $i;?>]" class="form-control"> 	

									<option   value="">--Select--</option> 
									<?php    if(($emp['gender'] == "Male")||($emp['gender'] == "male")){  ?>
									 
									 
									<option   value="5">5 </option> 
									<option   value="6">6 </option> 
									<option   value="7">7 </option> 
									<option   value="8">8 </option> 
									<option   value="9">9 </option> 
									<option   value="10">10 </option> 
									
									<?php
									
									}else{   ?>
									
									<option   value="3">3 </option> 
									<option   value="4">4 </option> 
									<option   value="5">5 </option> 
									<option   value="6">6 </option>  
									<?php }  ?>  
										</select> 
								 </td> 
								</tr>
								 <?php $i++; }}else{ 
								 
								 
										if(in_array($emp['designation_code'],$designation_code_array_ho)){
											 
								 ?>
									 <tr>
										<td><?php echo $i;?></td>
										<td><?php echo $emp['emp_id'];?>
										<input type="hidden" name="emp_id[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['emp_id'];?>">
										</td> 
										<td><?php echo $emp['emp_name'];?> </td>
										<td><?php echo $emp['designation_name'];?>
										<input type="hidden" name="designation_code[<?php echo $i;?>]" class="form-control" value="<?php echo $emp['designation_code'];?>">
										</td> 
										<td> 
										
										<?php  
												 
												if(($emp['gender'] == 'Male' )|| ($emp['gender'] == 'male')){
													echo "male";
												}else if(($emp['gender'] == 'Female')||($emp['gender'] == 'female')){
													echo "Female";
												}
											  ?>
										</td>  
										<td>
										<select type="text"  name="size[<?php echo $i;?>]" class="form-control"> 	

										<option   value="">--Select--</option> 
										<?php    if(($emp['gender'] == "Male")||($emp['gender'] == "male")){  ?>
										 
										 
										<option   value="5">5 </option> 
										<option   value="6">6 </option> 
										<option   value="7">7 </option> 
										<option   value="8">8 </option> 
										<option   value="9">9 </option> 
										<option   value="10">10 </option> 
										
										<?php
										
										}else{   ?>
										
										<option   value="3">3 </option> 
										<option   value="4">4 </option> 
										<option   value="5">5 </option> 
										<option   value="6">6 </option>  
										<?php }  ?>  
											</select> 
									 </td> 
									</tr>
								 <?php
										$i++;	} 
										}
									}
								?>
							</tbody>    
						</table> 
				
						 
							<div class="row"> 
								<div class="col-md-11">
									<input type="hidden" name="tot_row" class="form-control" value="<?php echo $i;?>">
										<div class="pull-right"> 
											<input type="submit" id="submit_btn" class="btn btn-primary" value="Save"> 		 
										</div>
								</div>
							</div>  
						
					</form>
			<?php } ?>
		</div>
</section> 
@endsection