@extends('admin.admin_master')
@section('main_content')

<script src="{{asset('public/admin_asset/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Increment Letter <small>{{$Heading}}</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Increment Letter</li>
		<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i></button>
	</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/increment-salary')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
						  <label for="pwd">Letter Date:</label>
						  <input type="text" id="letter_date" class="form-control" name="letter_date" size="10" value="{{$letter_date}}" required>
						</div>
						<div class="form-group">
						  <label for="pwd">Increment Date:</label>
						  <input type="text" id="increment_date" class="form-control" name="increment_date" size="10" value="{{$increment_date}}" required>
						</div>
						<div class="form-group">
						  <label for="email">Grade :</label>
							<select name="grade_code" id="grade_id" required class="form-control">
								<option value="">Select </option>
								<?php foreach($all_grade as $grade){?>
								<option value="<?php echo $grade->id; ?>"><?php echo $grade->grade_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
						  <label for="pwd">Basic:</label>
						  <input type="text" class="form-control" name="old_basic" size="8" value="{{$old_basic}}" required>
						</div>
						<div class="form-group">
						  <label for="email">Branch Type :</label>
							<select name="branch_type" id="branch_type" required class="form-control">
								<option value="1" <?php if($branch_type=="1") echo 'selected="selected"'; ?> >Branch</option>
								<option value="2" <?php if($branch_type=="2") echo 'selected="selected"'; ?> >HO</option>
							</select>
						</div>						
						<button type="submit" class="btn btn-primary" onclick="dateRange();">Search</button>
						<!--<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>-->
					</form>
				</div>
			</div>
        </div>
	</div>
	<?php if ($status==1) { ?>
	<div class="row">			
		<!-- form start -->
		<form action="{{URL::to($action)}}" method="{{$method}}" class="form-horizontal" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! $method_field !!}
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="comments" style="padding-top: 7%;" class="col-sm-2 control-label">Heading Line </label>
							<div class="col-sm-9">
								<textarea name="letter_heading" class="form-control">{{$letter_heading}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label">Letter Body-1 </label>
							<div class="col-sm-9">
								<textarea style="border-radius: 4px;" name="letter_body_1" class="form-control">{{$letter_body_1}}</textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<table id="table" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Sl No</th>
											<th>Emp ID</th>
											<th>Employee Name</th>
											<th>Designation</th>
											<th>Branch</th>
											<th>Next Increment Date</th>                    
											<th class="text-center" style="width:15%">Action</th>
										</tr>
									</thead>
									<tbody>								
									{{!$i=1}} @foreach($all_result as $result)
									<tr>
										<td>{{$i++}}</td>
										<input type="hidden" name="letter_date" value="{{$letter_date}}" />
										<input type="hidden" name="increment_date" value="{{$increment_date}}" />
										<input type="hidden" name="grade_code" value="{{$grade_code}}" />
										<input type="hidden" name="old_basic" value="{{$old_basic}}" />
										<input type="hidden" name="branch_type" value="{{$branch_type}}" />
										<input type="hidden" name="designation_code[]" value="{{$result['designation_code']}}" />
										<input type="hidden" name="br_code[]" value="{{$result['br_code']}}" />
										<input type="hidden" name="next_increment_date" value="{{$result['next_increment_date']}}" />
										<td><input type="text" name="emp_id[]" readonly value="{{$result['emp_id']}}"></td>
										<td><input type="text" readonly value="{{$result['emp_name_eng']}}"></td>
										<td><input type="text" readonly value="{{$result['designation_name']}}"></td>
										<td><input type="text" readonly value="{{$result['branch_name']}}"></td>								
										<td><input type="text" readonly value="{{$result['next_increment_date']}}"></td>
										<td></td>
									</tr>
									@endforeach
									</tbody>
								</table>	
							</div>
						</div>
						
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<table id="table" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Basic</th>
											<?php foreach($plus_items as $v_plus_items) { ?>
											<th><?php echo $v_plus_items->item_name; ?></th>
											<?php } ?>
											<th>Total</th>
											<?php foreach($minus_items as $v_minus_items) { ?>
											<th><?php echo $v_minus_items->item_name; ?>(-)</th>
											<?php } ?>
											<th>(-)Total</th>
											<th>Net Pay</th>
										</tr>
									</thead>
									<tbody>	
										<tr>
											<td><input type="text" name="new_basic" readonly value="{{$basic_salary}}" size="6" /></td>											
											<?php if (empty($id)) { ?>
												<?php $plus_items_id = 1; $total_plus = 0; foreach($plus_items as $v_plus_items) { ?>
												<td><input type="text" id="plus_item<?php echo $plus_items_id++; ?>" name="plus_item[]" value="<?php echo $plus_amount= round(($basic_salary*$v_plus_items->percentage)/100); ?>" size="2" />
												<input type="hidden" name="plus_item_id[]" readonly value="<?php echo $v_plus_items->id; ?>" size="2" /></td>
												<?php $total_plus += $plus_amount; } ?>																						
												<td><input type="text" name="total_pay" readonly value="<?php echo $total_plus + $basic_salary; ?>" size="6" /></td>											
												<?php $minus_items_id = 1; $total_minus = 0; foreach($minus_items as $v_minus_items) { ?>
												<td><input type="text" id="minus_item<?php echo $minus_items_id++; ?>" name="minus_item[]" value="<?php echo $minus_amount= round(($basic_salary*$v_minus_items->percentage)/100); ?>" size="2" />
												<input type="hidden" name="minus_item_id[]" readonly value="<?php echo $v_minus_items->id; ?>" size="2" /></td>
												<?php $total_minus += $minus_amount; } ?>							
												<td><input type="text" name="total_minus" readonly value="<?php echo $total_minus; ?>" size="6" /></td>
												<td><input type="text" name="net_pay" readonly value="<?php echo ($total_plus + $basic_salary) - $total_minus; ?>" size="6" /></td>
											<?php } else { ?>
												<?php $plus_amount = explode(",",$plus_item); $plus_items_id = 1; $total_plus = 0; foreach($plus_items as $v_plus_items) { ?>
												<td><input type="text" id="plus_item<?php echo $plus_items_id; ?>" name="plus_item[]" value="<?php echo $amount_plus = $plus_amount[$plus_items_id-1]; ?>" size="2" />
												<input type="hidden" name="plus_item_id[]" value="<?php echo $v_plus_items->id; ?>" size="2" ></td>
												<?php $plus_items_id++; $total_plus += $amount_plus; } ?>
												<td><input type="text" name="total_pay" readonly value="{{$total_pay}}" size="6" /></td>
												<?php $minus_amount = explode(",",$minus_item); $minus_items_id = 1; $total_minus = 0; foreach($minus_items as $v_minus_items) { ?>
												<td><input type="text" id="minus_item<?php echo $minus_item_id; ?>" name="minus_item[]" value="<?php echo $amount_minus = $minus_amount[$minus_items_id-1];  ?>" size="2" />
												<input type="hidden" name="minus_item_id[]" value="<?php echo $v_minus_items->id; ?>" size="2"></td>
												<?php $minus_items_id++; $total_minus += $amount_minus; } ?>
												<td><input type="text" name="total_minus" readonly value="{{$total_minus}}" size="6" /></td>
												<td><input type="text" name="net_pay" readonly value="{{$net_pay}}" size="6" /></td>
											<?php } ?>
										</tr>
									</tbody>
								</table>	
							</div>
						</div>
						
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label">Letter Body-2 </label>
							<div class="col-sm-9">
								<textarea style="border-radius: 4px;" name="letter_body_2" class="form-control">{{$letter_body_2}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="comments" style="padding-top: 15%;" class="col-sm-2 control-label">Letter Body-3 </label>
							<div class="col-sm-9">
								<textarea name="letter_body_3" class="form-control">{{$letter_body_3}}</textarea>
							</div>
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="#" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>			
	</div>
	<?php } ?>
</section>
<script>
	document.getElementById("grade_id").value="<?php echo isset($grade_code)?$grade_code:'';?>";
</script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#letter_date').datepicker({dateFormat: 'yy-mm-dd'});
	$('#increment_date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript"><!--
CKEDITOR.replace('letter_heading');
    CKEDITOR.add 
//--></script>
<script type="text/javascript"><!--
CKEDITOR.replace('letter_body_3');
    CKEDITOR.add 
//--></script>
@endsection