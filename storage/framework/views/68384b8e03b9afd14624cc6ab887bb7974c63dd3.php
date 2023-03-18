
<?php $__env->startSection('main_content'); ?>  
 <link rel="stylesheet" href="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css')); ?>">
<style>
		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			background-color: #3c8dbc;
			border-color: #367fa9;
			padding: 1px 10px;
			color: #fff;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Movement<small>Register</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Movement</a></li>
			<li class="active">Register</li>
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
				<form class="form-horizontal" action="<?php echo e(URL::to($action)); ?>" role="form" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>  
				<FIELDSET>  
					<LEGEND class="col-md-12" style="padding-left:0px;"><b>Movement Information</b></LEGEND>
						<input type="hidden" name="grade_code"   id="grade_code"  class="form-control" value="<?php echo e($grade_code); ?>" >
						<input type="hidden" name="move_id"   id="move_id"  class="form-control" value="<?php echo e($move_id); ?>" >
						<div class="row"> 
								<div class="col-md-4">
									<div class="form-group"> 
										<label class="control-label col-md-3">Visit Type</label>
											<div class="col-md-9">
												 <?php $visit = "Local"; if($visit_type == 1){ $visit = "Branch"; } ?>
												 <input type="text" name="" id=""  class="form-control" value="<?php echo e($visit); ?>"   >
												 
											</div> 
									</div> 
								</div> 
								<div class="col-md-4">
									<div class="form-group"> 
										<label class="control-label col-md-3">Destination</label>
											<div class="col-md-9">
											<?php if($visit_type == 1){ ?>
												 <select  name="destination_code[]" multiple="multiple" disabled  id="destination_code" class="form-control  select2" > 
													<?php $__currentLoopData = $branch_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<option value="<?php echo e($branch->br_code); ?>" <?php if(in_array($branch->br_code, $destination_code)){ echo "selected";}?>><?php echo e($branch->branch_name); ?></option> 
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
													
												</select>
											<?php } else if($visit_type == 2){ ?>
												<input list="local_list" class="form-control" name="loc_destination" id="loc_destination" value="<?php echo $destination_code;?>" readonly>
												<datalist id="local_list">
													<option value="MRA">
													<option value="PKSF"> 
												</datalist>
												<?php } ?>
											</div>  
									</div> 
								</div> 
								<div class="col-md-4">
									<div class="form-group"> 
										<label class="control-label col-md-3">Purpose </label>
											<div class="col-md-9">
												 <input type="text" name="purpose" id="purpose" class="form-control" value="<?php echo e($purpose); ?>" <?php echo e($mode); ?> required>
											</div> 
										
									</div> 
								</div>		
						</div>
						<div class="row">		
								<div class="col-md-4">
									<div class="form-group"> 
										<label class="control-label col-md-3">Departure Date</label>
											<div class="col-md-9">
												<input type="text" name="from_date" id="from_date"  class="form-control" value="<?php echo e($travel_date); ?>" required >
											</div> 
									</div> 
								</div>  
								<div class="col-md-4">
									<div class="form-group"> 
										<label class="control-label col-md-3">Arrival Date</label>
											<div class="col-md-9">
												<input type="text" name="to_date" id="to_date"  class="form-control" value="<?php echo e($to_date); ?>" required>
											</div> 
									</div> 
								</div>
								<div class="col-md-4">
									<div class="form-group"> 
										<label class="control-label col-md-3">Day/s </label> 
											<div class="col-md-9">
												<input type="text" name="tot_day" id="tot_day"  class="form-control" value="<?php echo e($tot_day); ?>" <?php echo e($mode); ?> required> 
												<span class="help-block" id="error1"></span>
												
											</div>
									</div> 
								</div>  
						</div>  
						<hr>
						<br>  
						<div class="box-body"> 
							<div class="row"> 
								<div class="col-md-11 table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr> 
												<th>Travel Date</th> 
												<th>Source</th> 
												<th>Destination</th> 
												<th>Vehicle</th> 
												<th>Travel Allowance</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="new_row">
											<?php 
												$j = 0;
												$tot_travel_allowance = 0;
												foreach($travel_details as $v_travel_details){ 
													if($j == 0){
														$movement_array = $j;
													}else{
														$movement_array .= ','.$j;
													}
													$tot_travel_allowance += $v_travel_details->travel_allowance;
												?>
											<tr id="movement_row<?php echo $j;?>">
												<td>
													<input type="text" onchange="select_travel_amt(<?php echo $j;?>)"  name="movement[<?php echo $j;?>][travel_date]"   id="travel_date<?php echo $j;?>"  class="form-control <?php echo e($common_date); ?>" value="<?php echo $v_travel_details->travel_date;?>" required>
												
												</td> 
												<td> 
													<select  name="movement[<?php echo $j;?>][source_br_code]" id="source_br_code<?php echo $j;?>" onchange="select_travel_amt(<?php echo $j;?>)" required class="form-control"> 
													<?php if($visit_type == 1){ ?>
														<option value="">--Select--</option>
														<?php $__currentLoopData = $branch_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($branch->br_code); ?>" <?php if($branch->br_code == $v_travel_details->source_br_code) echo "selected";?> ><?php echo e($branch->branch_name); ?></option> 
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php }else if($visit_type == 2){?>
														<option value="9999" selected>Head Office</option>
														
													<?php } ?> 
													</select> 
												</td> 
												<td> 
													<select  name="movement[<?php echo $j;?>][dest_br_code]" required onchange="select_travel_amt(<?php echo $j;?>)" id="dest_br_code<?php echo $j;?>" class="form-control"> 
													<?php if($visit_type == 1){ ?>
														<option value="">--Select--</option>
														 
														<?php $__currentLoopData = $branch_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($branch->br_code); ?>" <?php if($branch->br_code == $v_travel_details->dest_br_code) echo "selected";?>><?php echo e($branch->branch_name); ?></option> 
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
														<?php }else if($visit_type == 2){ ?>
															 <option value="0"><?php echo e($destination_code); ?></option>
														<?php }  ?> 
													</select> 
												</td> 
												<td>
													<input type="text" name="movement[<?php echo $j;?>][medium_trav]"  id="medium_trav<?php echo $j;?>"  class="form-control" value="<?php  echo $v_travel_details->medium_trav;?>">
												</td>
												<td>
												<input type="text" name="movement[<?php echo $j;?>][travel_allowance]" onkeyup="calculate_travel_allowance()" <?php if($v_travel_details->travel_allowance != 0){ ?> readonly  <?php } ?> id="travel_allowance<?php echo $j;?>"  class="form-control" value="<?php  echo $v_travel_details->travel_allowance;?>" required>
												</td>
												
												<?php if($j == 0){?>
												<td>
												 <button type="button" onclick="add_row()" class="btn btn-primary">Add</button>
												 </td>
												<?php }else{ ?>
												<td>
													<a onclick="row_delete(<?php echo $j;?>)" class="btn btn-danger">Remove</a>
												<?php } ?>
												</td>
												
											</tr>
											<?php		
													$j++; }  
											?>
											 <input type="hidden" name="movement_array" id="movement_array"  class="form-control" value="<?php echo $movement_array;?>">
										</tbody>
										<tbody>
											<tr>
												<th colspan="4" style="text-align:right;">Sub Total</th>
												<td><input type="text" name="tot_travel_allowance" readonly id="tot_travel_allowance"  class="form-control" value="<?php echo $tot_travel_allowance;?>"> </td>
											</tr>
										</tbody>
										
									</table> 
								</div>	
							</div>
							<div class="row"> 
								<div class="col-md-11 table-responsive">
									<table class="table table-bordered"> 
										<thead>
											<tr> 
												<th style="width:20%;">Bill Date</th> 
												<th style="width:15%;">Breakfast</th> 
												<th style="width:20%;">Lunch</th> 
												<th style="width:20%;">Dinner</th>
												<th style="width:15%;">Total</th>
												<th style="width:10%;"> <button type="button" onclick="add_row_bill()" class="btn btn-primary">Add</button></th>
											</tr>
										</thead>
										<tbody  id="new_row_bill">
											<?php 
											$tot_travel_allowance_bill = 0;
											$b = 0;
											if(count($bill_details) > 0){ 
											
												
												foreach($bill_details as $v_bill_details){ 
													if($b == 0){
														$movement_array_bill = $b;
													}else{
														$movement_array_bill .= ','.$b;
													}
													$tot_travel_allowance_bill += $v_bill_details->tot_amt;
													?>
													<tr id="movement_row_bill<?php echo $b;?>">
														<td>
															<input type="text" onchange="get_grade_wise_allowance(<?php echo $b;?>)"  name="movement_bill[<?php echo $b;?>][bill_date]" id="bill_date<?php echo $b;?>"  class="form-control" value="<?php  echo $v_bill_details->bill_date;?>" required>
														</td>
														<td>  
															<input type="text" name="movement_bill[<?php echo $b;?>][breakfast]" onkeyup="calculate_travel_allowance_bill()" required id="breakfast<?php echo $b;?>" class="form-control" value="<?php  echo $v_bill_details->breakfast;?>" >
														</td>
														<td>
															<input type="text" name="movement_bill[<?php echo $b;?>][lunch]" onkeyup="calculate_travel_allowance_bill()" required id="lunch<?php echo $b;?>" class="form-control" value="<?php  echo $v_bill_details->lunch;?>" >
														</td>
														<td>
															<input type="text" name="movement_bill[<?php echo $b;?>][dinner]" onkeyup="calculate_travel_allowance_bill()" required id="dinner<?php echo $b;?>" class="form-control" value="<?php  echo $v_bill_details->dinner;?>" >
														</td>
														<td>
															<input type="text" name="movement_bill[<?php echo $b;?>][tot_amt]" onkeyup="calculate_travel_allowance_bill()" required id="tot_amt<?php echo $b;?>" class="form-control" value="<?php  echo $v_bill_details->tot_amt;?>" >
														</td>
														<td>
															<a onclick="row_delete_bill(<?php echo $b;?>)" class="btn btn-danger">Remove</a>
														</td>
													</tr>
											
											<?php 	$b++;}
											  }else{ ?>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td> 
												</tr>
											<?php  
											$movement_array_bill = '';
											}  
												?> 
											<input type="hidden" name="movement_array_bill" id="movement_array_bill"  class="form-control" value="<?php echo $movement_array_bill;?>">
											
										</tbody>
										<tbody>
											<tr>
												<th colspan="4" style="text-align:right;">Sub Total</th>
												<td><input type="text" name="tot_travel_allowance_bill" readonly id="tot_travel_allowance_bill"  class="form-control" value="<?php echo $tot_travel_allowance_bill;?>"> </td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												 
											</tr>
											<tr>
												<th colspan="4" style="text-align:right;">Grand Total</th>
												<td><input type="text"   readonly id="grand_tot_allowance_bill"  class="form-control" value="<?php echo $tot_travel_allowance + $tot_travel_allowance_bill;?>"> </td>
											</tr>
										</tbody>
									</table> 
								</div>	
							</div>  
							 
							<div class="row">  
								<div class="col-md-5 col-md-offset-6">
									<div class="form-group"> 
										<label class="control-label col-md-4"></label>
											<div class="col-md-6">
												<button type="submit" class="btn btn-primary"><?php echo e($button); ?></button>
												<a href="<?php echo e(URL::to('movement_bill/')); ?>" class="btn btn-success" >&nbsp;&nbsp;list&nbsp;&nbsp;</a>
											</div> 
									</div> 
								</div>
							</div>  
						</div> 
				</FIELDSET>  
			</form>
		</div>
	</section> 
<script src="<?php echo e(asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>

<script>
$('.select2').select2();
function get_grade_wise_allowance(val){
		var grade_code =  document.getElementById("grade_code").value;
		var bill_date =  document.getElementById("bill_date"+val).value;
		 
		 
	  $.ajax({
				type:'get',
				url : "<?php echo e(URL::to('get_grade_wise_allowance')); ?>"+"/"+grade_code+"/"+bill_date,
				success:function(res){ 
					console.log(res);
					 $('#breakfast'+val).val(res.split(',')[0]);
					 $('#lunch'+val).val(res.split(',')[1]);
					 $('#dinner'+val).val(res.split(',')[2]);
					 $('#tot_amt'+val).val(res.split(',')[3]);
					 calculate_travel_allowance_bill();
			}
		})
}
function select_travel_amt(val){
	
	var travel_date = $('#travel_date'+val).val();
	var source_br_code = $('#source_br_code'+val).val(); 
	var dest_br_code = $('#dest_br_code'+val).val(); 
		$.ajax({
				type:'get',
				url : "<?php echo e(URL::to('select_travel_amt')); ?>"+"/"+source_br_code+"/"+dest_br_code+"/"+travel_date,
				success:function(res){
					 
					 
					// alert(res);
					 $('#travel_allowance'+val).val(res);
					 if(res == 0){ 
						 $('#travel_allowance'+val).removeAttr("readonly");
					 }else{
						$('#travel_allowance'+val).attr("readonly","readonly"); 
					 }
					 calculate_travel_allowance();
			}
		})  
}
function calculate_travel_allowance(){
	var tot_travel_allowance = 0;
	var tot_travel_allowance_bill = parseFloat(document.getElementById("tot_travel_allowance_bill").value);
	if(isNaN(tot_travel_allowance_bill)) {
		var tot_travel_allowance_bill = 0;
	}
	var movement_array =$("#movement_array").val();
	var movement_array1 = movement_array.split(','); 
	$.each(movement_array1, function( index, val) {
			var travel_allowance=parseFloat(document.getElementById("travel_allowance"+val).value);
					if(isNaN(travel_allowance)) {
						var travel_allowance = 0;
					} 
					 tot_travel_allowance += travel_allowance;
			});  
			document.getElementById("tot_travel_allowance").value = tot_travel_allowance; 
			document.getElementById("grand_tot_allowance_bill").value = tot_travel_allowance_bill + tot_travel_allowance; 
	 
			  set_calender();
}
function calculate_travel_allowance_bill(){
	var tot_travel_allowance_bill = 0;
	var tot_travel_allowance = parseFloat(document.getElementById("tot_travel_allowance").value);
	if(isNaN(tot_travel_allowance)) {
		var tot_travel_allowance = 0;
	}
	var movement_array_bill =$("#movement_array_bill").val();
	var movement_array1_bill = movement_array_bill.split(','); 
	if(movement_array_bill != ''){
		$.each(movement_array1_bill, function( index, val) {
			var breakfast_amt = parseFloat(document.getElementById("breakfast"+val).value);
			var lunch_amt=parseFloat(document.getElementById("lunch"+val).value);
			var dinner_amt=parseFloat(document.getElementById("dinner"+val).value);
					if(isNaN(breakfast_amt)) {
						var breakfast_amt = 0;
					}if(isNaN(lunch_amt)) {
						var lunch_amt = 0;
					} if(isNaN(dinner_amt)) {
						var dinner_amt = 0;
					} 
					var tot_amt = ( breakfast_amt + lunch_amt + dinner_amt);
					$("#tot_amt"+val).val(tot_amt);
					 tot_travel_allowance_bill += tot_amt;
			});  
	}
	
			document.getElementById("tot_travel_allowance_bill").value = tot_travel_allowance_bill;
			document.getElementById("grand_tot_allowance_bill").value = tot_travel_allowance_bill + tot_travel_allowance; 			
	 
			  set_calender_bill();
}
var number_row = <?php echo $j;?>;
function add_row(){ 
	//alert (training_row); 
	
	var movement_array = $("#movement_array").val();  
	var movement_array1 = movement_array.split(',');
	var hh = jQuery.inArray(number_row,movement_array1);  
	if(movement_array1 == ''){
	   movement_array1 =number_row;
   }else{
	   movement_array1.push(number_row);
   }
	$("#movement_array").val(movement_array1);
	html = '<tr id="movement_row' + number_row + '">'; 
	html += '<td><input type="text" name="movement['+ number_row +'][travel_date]" onchange="select_travel_amt('+ number_row +')" id="travel_date'+ number_row +'"  class="form-control" value="" required></td>';	
    html += ' <td> <select  name="movement['+ number_row +'][source_br_code]" required id="source_br_code'+ number_row +'" onchange="select_travel_amt('+ number_row +')" class="form-control"><option value="">--Select--</option><?php $__currentLoopData = $branch_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select> </td>';  
	html += ' <td><select  name="movement['+ number_row +'][dest_br_code]" required id="dest_br_code'+ number_row +'" onchange="select_travel_amt('+ number_row +')" class="form-control"><option value="">--Select--</option><?php $__currentLoopData = $branch_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($branch->br_code); ?>"><?php echo e($branch->branch_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td>'; 
	html += '<td><input type="text" name="movement['+ number_row +'][medium_trav]"  id="medium_trav'+ number_row +'"  class="form-control" value="" required></td>';
	html += '<td><input type="text" name="movement['+ number_row +'][travel_allowance]" readonly onkeyup="calculate_travel_allowance()" id="travel_allowance'+ number_row +'"  class="form-control" value="" required></td>';
	  
	html += '<td><a onclick="row_delete(' + number_row + ')" class="btn btn-danger">Remove</a></td>';
	html += '</tr>';	 
	$('#new_row').append(html);

	number_row++; 
	calculate_travel_allowance();
} 
var number_row_bill = <?php echo $b;?>;
function add_row_bill(){ 
	//alert (training_row); 
	
	var movement_array_bill = $("#movement_array_bill").val();  
	var movement_array1_bill = movement_array_bill.split(',');
	var hh = jQuery.inArray(number_row_bill,movement_array1_bill);  
	if(movement_array1_bill == ''){
	   movement_array1_bill =number_row_bill;
   }else{
	   movement_array1_bill.push(number_row_bill);
   }
	$("#movement_array_bill").val(movement_array1_bill);
	html = '<tr id="movement_row_bill' + number_row_bill + '">';
	html += '<td><input type="text" onchange="get_grade_wise_allowance('+ number_row_bill +')"  name="movement_bill['+ number_row_bill +'][bill_date]" id="bill_date'+ number_row_bill +'"  class="form-control" value="" required></td>';	
    html += ' <td>  <input type="text" name="movement_bill['+ number_row_bill +'][breakfast]" onkeyup="calculate_travel_allowance_bill()" required id="breakfast'+ number_row_bill +'" class="form-control" value="" ></td>'; 
	html += '<td><input type="text" name="movement_bill['+ number_row_bill +'][lunch]" onkeyup="calculate_travel_allowance_bill()" required id="lunch'+ number_row_bill +'" class="form-control" value="" ></td>'; 
	html += ' <td><input type="text" name="movement_bill['+ number_row_bill +'][dinner]" onkeyup="calculate_travel_allowance_bill()" required id="dinner'+ number_row_bill +'" class="form-control" value="" ></td>'; 
	html += ' <td><input type="text" name="movement_bill['+ number_row_bill +'][tot_amt]" onkeyup="calculate_travel_allowance_bill()" required id="tot_amt'+ number_row_bill +'" class="form-control" value="" ></td>'; 
	html += '<td><a onclick="row_delete_bill(' + number_row_bill + ')" class="btn btn-danger">Remove</a></td>';
	html += '</tr>';	 
	$('#new_row_bill').append(html);

	number_row_bill++; 
	calculate_travel_allowance_bill();
} 	
function row_delete_bill(val){
	$("#movement_row_bill"+val).remove();
	 var movement_array_bill = $("#movement_array_bill").val();  
	var movement_array1_bill = movement_array_bill.split(','); 
	
	   var result_bill = movement_array1_bill.filter(function(elem){
		return elem != val;
		});    
	$("#movement_array_bill").val(result_bill); 
	calculate_travel_allowance_bill();
}
function row_delete(val){
	$("#movement_row"+val).remove();
	 var movement_array = $("#movement_array").val();  
	var movement_array1 = movement_array.split(','); 
	
	   var result = movement_array1.filter(function(elem){
		return elem != val;
		});    
	$("#movement_array").val(result); 
	calculate_travel_allowance();
}

</script>
<script>
 function set_calender() {
	var movement_array =$("#movement_array").val();
	var movement_array1 = movement_array.split(','); 
	$.each(movement_array1, function( index, val) { 
						$("#travel_date"+val).datepicker({dateFormat: 'yy-mm-dd'});  
			});  
}  
function set_calender_bill() {
	var movement_array_bill =$("#movement_array_bill").val();
	var movement_array1_bill = movement_array_bill.split(','); 
	$.each(movement_array1_bill, function( index, val) { 
						$("#bill_date"+val).datepicker({dateFormat: 'yy-mm-dd'});  
			});  
}  
$(document).ready(function() { 
	$('.common_date').datepicker({dateFormat: 'yy-mm-dd'}); 
}); 
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>