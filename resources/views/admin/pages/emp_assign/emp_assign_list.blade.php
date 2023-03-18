@extends('admin.admin_master')
@section('title', 'Employee Assign')
@section('main_content')
<section class="content-header">
	<h1>Employee<small>Assign</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Assign</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/emp-assign/create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Open Date</th>
								<th>Designation</th>
								<th>Remarks</th>                 
								<th>Assign Type</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Open Date</th>
								<th>Designation</th>
								<th>Remarks</th>                 
								<th>Assign Type</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($assign_info as $assign)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$assign->emp_id}}</td>
								<td>{{$assign->emp_name_eng}}</td>
								<td>{{$assign->open_date}}</td>
								<td>{{$assign->designation_name}}</td>
								<td>{{$assign->incharge_as}}</td>
								<td> <?php 
								if($assign->select_type ==1) { echo 'Employee Assign';}
								else if($assign->select_type ==2) { echo 'Work Station Change';}
								else if($assign->select_type ==3) { echo 'Letter of Council';}
								else if($assign->select_type ==4) { echo 'Report to HO';}
								else if($assign->select_type ==5) { echo 'Designation Change';}
								else if($assign->select_type ==6) { echo 'Final Deadline';}
								?>
								</td>
								<?php if ($assign->status !=0) { ?>
								<td style="color:green;"><?php echo 'Active'; ?></td>
								<?php } else { ?>
								<td style="color:red;"><b><?php echo 'InActive'; ?></b></td>
								<?php } ?>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/emp-assign/'.$assign->id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/emp-assign/'.$assign->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
		$("#MainGroupEmployee").addClass('active');
		$("#Employee_Assign").addClass('active');
	});
</script>
@endsection