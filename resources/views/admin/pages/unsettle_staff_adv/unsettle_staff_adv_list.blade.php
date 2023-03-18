@extends('admin.admin_master')
@section('title', 'Unsettle Staff Advance List')
@section('main_content')
<style>
.pull-right {
margin-right: 10px;	
}
</style>
<section class="content-header">
	<h1>Extra<small>Deduction</small></h1>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/unsettle-staff-adv-payroll')}}" class="btn btn-success pull-right" type="button"> Payroll Collection</a>
					<a href="{{URL::to('/unsettle-staff-adv/create')}}" class="btn btn-primary pull-right" type="button"> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp Type</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Total Amount</th>
								<th>Entry Date</th>
								<th>Designation</th>
								<th>Remarks</th>                
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp Type</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Total Amount</th>
								<th>Entry Date</th>
								<th>Designation</th>
								<th>Remarks</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td><?php 
									if($result->emp_type == 1) { echo 'Regular';}
									else if ($result->emp_type == 2) { echo 'OT';}
									else if ($result->emp_type == 3) { echo 'CH';}
									else if ($result->emp_type == 4) { echo 'SHS';}
									?></td>
								<td><?php echo empty($result->sacmo_id) ? $result->emp_id : $result->sacmo_id; ?></td>
								<td><?php echo empty($result->emp_name) ? $result->emp_name_eng : $result->emp_name; ?></td>
								<td>{{$result->total_amount}}</td>
								<td>{{$result->entry_date}}</td>
								<td>{{$result->designation_name}}</td>
								<td>{{$result->comments}}</td>
								<td class="text-center">
									<a class="btn btn-info" title="Details" href="{{URL::to('/unsettle_view/'.$result->emp_id.'/'.$result->incre_id)}}">Details</a>
									<?php if ($result->is_payroll == 1) { ?>
										<a class="btn btn-primary" title="Resedule" href="{{URL::to('/unsettle_resedule/'.$result->emp_id.'/'.$result->usc_incre_id)}}">Resedule</a>
									<?php } else { ?>
										<a class="btn btn-success" title="Collection" href="{{URL::to('/unsettle_collection/'.$result->emp_id.'/'.$result->incre_id)}}">Collection</a>
										<a class="btn btn-danger" title="Transfer" href="{{URL::to('/unsettle_transfer/'.$result->emp_id.'/'.$result->incre_id)}}">Transfer</a>
									<?php } ?>
								</td>
							</tr>
							@endforeach
						</tbody>    
					</table>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>
</section>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Unsettle_Staff_Advance").addClass('active');
		});
	</script>
@endsection