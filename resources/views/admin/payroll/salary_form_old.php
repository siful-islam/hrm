@extends('admin.admin_master')
@section('main_content')

<style>
.required {
    color: red;
    font-size: 20px;
}
</style>
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Employee <small>Salary</small></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> Staff Salary</h3>
			</div>
			<div class="box-body">	
				<form action="{{URL::to('/generate-salary')}}" method="post">
				{{ csrf_field() }}				
					<div class="form-group">
						<div class="col-sm-1">
							Employee ID:
						</div>
						<div class="col-sm-2">
							<input type="number" name="search_emp_id" id="search_emp_id" class="form-control" value="<?php echo $emp_id; ?>" onkeyup="get_last_tran_date(this.value);" required>							
						</div>
						<div class="col-sm-1">
							Effect Date: 
						</div>
						<div class="col-sm-2">
							<input type="date" name="search_effect_date" id="search_effect_date" value="<?php echo $effect_date; ?>" class="form-control" required>
						</div>
						<div class="col-sm-1">
							<button type="submit" id="search_submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
						</div>
						<div class="col-sm-3">
							<span id="error" style="color:red;"></span>
						</div>						
					</div>
				</form>
			</div>					
			<?php if($emp_status=='Active') { ?>			
			
			<div class="row">
				<div class="col-md-2">
					<!-- Profile Image -->
					<div class="box box-primary">				
						<form action="{{URL::to('')}}" method="post">
							<div class="box-body box-profile">
								<center>
									<div class="image-upload">
										<label for="file-input">
											<img id="emp_photo" class="img-thumbnail" src="{{asset('public/employee/'.$emp_photo)}}" width="100"/>
										</label> 
									</div> 
								</center>
								<h3 class="profile-username text-center" id="emp_name" >{{$emp_name}}</h3>
								<p class="text-muted text-center" id="designation_name">{{$designation_name}}</p>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Org.Joining Date : </b><span id="joining_date">{{$joining_date}}</span>
									</li>
									<li class="list-group-item">
										<b>Working Station : </b><span id="branch_name">{{$branch_name}}</span>
									</li>
									<li class="list-group-item">
										<b>Grade : </b><span id="grade_name">{{$grade_name}}</span>
									</li>
									<?php if($grade_step > 0) { ?>
									<li class="list-group-item">
										<b>Grade Step : </b><span id="grade_step"> Step: {{$grade_step -1}} </span>
									</li>
									<?php } else { ?>
										<b>Grade Step : </b><span id="grade_step"> Step: N/A </span>
									<?php } ?>
									<li class="list-group-item">
										<b style="color:red;">Resign Date : </b><span id="branch_name" style="color:red;"> {{$resign_date}} </span>
									</li>
								</ul>
								<?php if($resign_date == '') { ?>
									<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>{{$emp_status}}</b></a>
								<?php } elseif($resign_date < $effect_date) { ?>
									<a href="#" class="btn btn-danger btn-block" id="employee_status"><b>Terminated</b></a>
								<?php } elseif($resign_date > $effect_date){ ?>
									<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>{{$emp_status}}</b></a>
								<?php }else { ?>
									<a href="#" class="btn btn-primary btn-block" id="employee_status"><b>{{$emp_status}}</b></a>
								<?php } ?>
							</div>
						</form>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
				<div class="col-md-10">
					<div class="box box-primary"> 
						<form class="form-horizontal" action="{{URL::to($action)}}" method="POST">
							{{ csrf_field() }}	
							
							<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="<?php echo $emp_id; ?>" required>
							<input type="hidden" name="effect_date" id="effect_date" class="form-control" value="<?php echo $effect_date; ?>" required>
							<input type="hidden" name="letter_date" id="letter_date" class="form-control" value="<?php echo $effect_date; ?>" required>
							<input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>" required>
							<input type="hidden" name="sarok_no" class="form-control" value="<?php echo $sarok_no; ?>" required>
							<input type="hidden" name="br_code" class="form-control" value="<?php echo $br_code; ?>" required>
							
							<div class="box-body col-md-10">							
								<div class="box-body">
									<div class="form-group">									
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Transection:</label>
												<div class="col-sm-6">
													<select class="form-control" name="transection" id="transection" required>
														<option value="">-SELECT-</option>
														<?php foreach($transections as $v_transections) { ?>
														<option value="<?php echo $v_transections->transaction_code; ?>" <?php if($v_transections->transaction_code == $tran_type_no) {echo 'selected';}?>><?php echo $v_transections->transaction_name; ?></option>
														<?php } ?>
													<select>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Salary Branch:</label>
												<div class="col-sm-6">
													<select class="form-control" name="salary_br_code" id="salary_br_code" required>
														<option value="">-SELECT-</option>
														<?php foreach($branches as $branch) { ?>
														<option value="<?php echo $branch->br_code; ?>" <?php if($branch->br_code == $salary_br_code) {echo 'selected';}?>><?php echo $branch->branch_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Basic Salary:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="salary_basic" id="basic_salary" value="<?php echo $basic_salary; ?>" readonly required style="text-align:right;">						
												</div>
											</div>
										</div>	
										<?php 
										if($is_permanent === 1)
										{
											$basic_calculation 		= 0;
										}
										else
										{
											$basic_calculation 		= $basic_salary;
										}
										
										//echo $is_permanent;
										//echo $basic_calculation;

										if($action=='save-salary') {  ?>
											<div class="col-sm-4">
												<?php  $primary_total_plus = 0; $secondary_total_plus = 0; $plus_items_id = 1; $total_plus = 0; foreach($plus_items as $v_plus_items) { ?>
												<div class="form-group">
													<?php 
													if($v_plus_items->type == 2)
													{
														$plus_amount = $v_plus_items->fixed_amount;
														$readonly	 = 'readonly';
														$label 		 = 'Fixed';
													}
													else
													{
														$plus_amount = round(($basic_calculation*$v_plus_items->percentage)/100);
														$readonly 	 = 'readonly';
														$label 		 = $v_plus_items->percentage.'%';
													}
													?>
													
													<?php 
													$primary_amount = 0; 
													$secondary_amount = 0;
													if($v_plus_items->item_type == 0)
													{
														$add_class = 'black';
														$primary_amount = $plus_amount;
													}
													else
													{
														$add_class = '#1D5F20';
														$secondary_amount = $plus_amount;
													}													
													?>
													<label class="col-sm-6 control-label" style="color:<?php echo $add_class;?>"><?php echo $v_plus_items->items_name; ?> (<?php echo $label;?>) + :</label>
													<div class="col-sm-6">
														<input type="number" id="plus_item<?php echo $plus_items_id++; ?>" class="form-control" name="plus_item[]" value="<?php echo $plus_amount; ?>" style="text-align:right;" onkeyup="plus_calculate(<?php echo count($plus_items);?>);" <?php echo $readonly; ?>>
														<input type="hidden" class="form-control" name="plus_item_id[]" value="<?php echo $v_plus_items->id; ?>">
													</div>
												</div>
												<?php 
													$total_plus += $primary_amount;
													$secondary_total_plus += $secondary_amount;
												} ?>
											</div>
											<div class="col-sm-4">
												<?php $minus_items_id = 1; $total_minus = 0; foreach($minus_items as $v_minus_items) { ?>
												<div class="form-group">
													<?php 
													if($v_minus_items->type == 2)
													{
														$minus_amount = $v_minus_items->fixed_amount;
														$readonly	  = 'readonly';
														$label 		  = 'Fixed';
													}
													else
													{
														$minus_amount = round(($basic_calculation*$v_minus_items->percentage)/100);
														$readonly 	  = 'readonly';
														$label 		  = $v_minus_items->percentage.'%';
													}
													?>
													<label class="col-sm-6 control-label"><?php echo $v_minus_items->items_name; ?> (<?php echo $label;?>) - :</label>
													<div class="col-sm-6">
														<input type="number" class="form-control" id="minus_item<?php echo $minus_items_id++; ?>" name="minus_item[]" value="<?php echo $minus_amount= round(($basic_calculation*$v_minus_items->percentage)/100); ?>" onkeyup="minus_calculate(<?php echo count($minus_items);?>);" <?php echo $readonly; ?> style="text-align:right;">
														<input type="hidden" class="form-control" name="minus_item_id[]" value="<?php echo $v_minus_items->id; ?>">
													</div>
												</div>
												<?php $total_minus += $minus_amount; } ?>
											</div>
										<?php } else { ?>
										
												
											<div class="col-sm-4">

												<?php $plus_amount = explode(",",$plus_item); $plus_items_id = 1; $total_plus = 0; $secondary_total_plus = 0; foreach($plus_items as $v_plus_items) { ?>
												<div class="form-group">
													<label class="col-sm-6 control-label"><?php echo $v_plus_items->items_name; ?> (+):</label>
													<div class="col-sm-6">
														<input type="number" id="plus_item<?php echo $plus_items_id; ?>" class="form-control" name="plus_item[]" value="<?php echo $amount_plus = $plus_amount[$plus_items_id-1];  ?>" onkeyup="plus_calculate(<?php echo count($plus_items);?>);" style="text-align:right;">
														
														<input type="hidden" class="form-control" name="plus_item_id[]" value="<?php echo $v_plus_items->id; ?>">
														
														
													</div>
												</div>
												
												<?php 
													$primary_amount = 0; 
													$secondary_amount = 0;
													if($v_plus_items->item_type == 0)
													{
														$add_class = 'black';
														$primary_amount = $amount_plus;
													}
													else
													{
														$add_class = '#1D5F20';
														$secondary_amount = $amount_plus;
													}													
												?>
												
												<?php 
												$plus_items_id++;
												//$total_plus += $amount_plus;
												$total_plus += $primary_amount;
												$secondary_total_plus += $secondary_amount;
												} ?>
											</div>
											<div class="col-sm-4">
												<?php $minus_amount = explode(",",$minus_item); $minus_items_id = 1; $total_minus = 0; foreach($minus_items as $v_minus_items) { ?>
												<div class="form-group">
													<label class="col-sm-6 control-label"><?php echo $v_minus_items->items_name; ?> (-):</label>
													<div class="col-sm-6">
														<input type="number" id="minus_item<?php echo $minus_item_id; ?>" class="form-control" name="minus_item[]" value="<?php echo $amount_minus = $minus_amount[$minus_items_id-1];  ?>" onkeyup="minus_calculate(<?php echo count($minus_items);?>);" style="text-align:right;">
														<input type="hidden" class="form-control" name="minus_item_id[]" value="<?php echo $v_minus_items->id; ?>"></div>
												</div>
												<?php 
												$minus_items_id++;
												$total_minus += $amount_minus;
												} ?>
											</div>
										<?php } ?>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-6 control-label">Plus Total:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" id="primary_total_plus" readonly value="<?php echo $total_plus; ?>" style="text-align:right;">
													<input type="hidden" id="total_plus" name="total_plus" readonly value="<?php echo $total_plus + $secondary_total_plus ; ?>" >
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label">Total Payable:</label>
												<div class="col-sm-6"> 
													<input type="number" class="form-control" id="payable" name="payable" readonly value="<?php echo $total_pay = $basic_salary+$total_plus; ?>" style="text-align:right;">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label">Minus Total:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" id="total_minus" name="total_minus"  readonly value="<?php echo $total_minus; ?>" style="text-align:right;">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label">Net Payable:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="net_payable" id="general_net_payable" readonly value="<?php echo $total_pay-$total_minus ?>" style="text-align:right;">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-6 control-label" style="color:#1D5F20;">Other Allowance Amount:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" name="others_total_plus" id="secondary_total_plus" readonly value="<?php echo $secondary_total_plus; ?>" style="text-align:right;">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-6 control-label" style="color:#1515F0;">Gross Total:</label>
												<div class="col-sm-6">
													<input type="number" class="form-control" id="gross_total" name="gross_total" readonly value="<?php echo $total_pay-$total_minus+$secondary_total_plus ?>" style="text-align:right;">
												</div>
											</div>
										</div>
									</div>										
									<!-- /.box-body -->
									<div class="box-footer">
										<?php if($resign_date == '') { ?>
											<button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"><?php echo $button;?></button>
										<?php } elseif($resign_date < $effect_date) { ?>
											<button type="button"  class="btn btn-primary pull-right" disabled><?php echo $button;?></button>
										<?php } elseif($resign_date > $effect_date){ ?>
											<button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"><?php echo $button;?></button>
										<?php }else { ?>
											<button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"><?php echo $button;?></button>
										<?php } ?>
									</div>

								</div>	  
							</div>
						</form>

					</div>
					
					
					<div class="col-md-12">
						<div class="box box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Salary History of {{$emp_name}}</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Sl</th>
											<th>Transection</th>
											<th>Effect Date</th>
											<th>Salary Basic</th>
											<th>Net Payable</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<?php $i=1; if($salary_history) { foreach($salary_history as $v_salary_history) { ?>
											<td><?php echo $i++;?></td>
											<td><?php echo $v_salary_history->transaction_name;?></td>
											<td><?php echo $v_salary_history->effect_date;?></td>
											<td><?php echo $v_salary_history->salary_basic;?></td>
											<td><?php echo $v_salary_history->net_payable;?></td>
										</tr>
										<?php } } else { ?>
										<tr>
											<td align="center" colspan="8">There is no Record</td>
										</tr>
										<?php } ?>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					
				</div>
				
				
			</div>

			<?php } else { ?>
			<div class="row">
				<div class="col-md-12">
					<br>
					<br>
					<br>
					<center><h1 style="color:red;">This Employee is not Available !</h1></center>
					<br><br>
				</div>
			</div>
			<?php } ?>
			
	</section>
	
	<?php //echo $p_count = count($minus_items); ?>
	
	<script>
		function get_last_tran_date(id)
		{
			$.ajax({
				url : "{{ url::to('get-max-effect-date') }}"+"/"+ id,
				type: "GET",
				success: function(data)
				{
					//alert(data);
					document.getElementById("search_effect_date").value = data;
					if(data)
					{
						$('#search_submit').attr("disabled", false);
					}
					else
					{
						$('#search_submit').attr("disabled", true);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//alert('Error');
					$('#search_submit').attr("disabled", true);
				}
			});
		}
		
		function plus_calculate(val)
		{
			var val = val+1;
			var total = 0;
			for (i = 1; i < val; i++) { 
			
				var plus_value = parseFloat(document.getElementById("plus_item"+i).value);
				var total = total+plus_value;
			}
			document.getElementById("total_plus").value = total;
			//////////
			var basic_salary 	= parseFloat(document.getElementById("basic_salary").value);
			var payable 		= basic_salary+total;
			var total_minus 	= parseFloat(document.getElementById("total_minus").value);
			var gross_total 	= (payable-total_minus);
			document.getElementById("payable").value = payable;
			document.getElementById("gross_total").value = gross_total;
		}
		
		function minus_calculate(val)
		{
			var val = val+1;
			var total = 0;
			for (i = 1; i < val; i++) { 
			
				var minus_value = parseFloat(document.getElementById("minus_item"+i).value);
				var total = total+minus_value;
			}
			document.getElementById("total_minus").value = total;
			///////
			var payable 		= parseFloat(document.getElementById("payable").value);
			var gross_total 	= (payable-total);
			document.getElementById("gross_total").value = gross_total;
		}
	</script>
	
	

	
@endsection