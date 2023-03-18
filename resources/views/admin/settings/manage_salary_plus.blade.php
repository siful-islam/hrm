@extends('admin.admin_master')
@section('title', 'Manage Salary Plus')
@section('main_content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Salary Plus Items</small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Salary Items (+)</h3>
							<a href="{{URL::to('/salary-plus/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Item</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Item Name</th>
									<th>Type</th>                   
									<th>Percentage/Amount</th>                   
									<th>HO / BO </th>                      
									<th>Designation</th>
									<th>Department</th>
									<th>Grade</th>
									<th>Employee Type</th>									
									<th>Duration</th> 								
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($items as $item) { ?>
								<tr>
									<td><?php echo $item->id; ?></td>
									<td><?php echo $item->items_name; ?></td>
									<td><?php if($item->type == 1) {echo 'Percentage';} else {echo 'Fixed';} ?></td>
									<td><?php if($item->type == 1) {echo $item->percentage.' %';} else {echo $item->fixed_amount.' Tk';} ?></td>
									<td><?php if($item->ho_bo == 0) {echo 'Head Office';} elseif($item->ho_bo == 1) {echo 'Branch';} else {echo 'Both';} ?></td>
									<td><?php if($item->designation_for == 0 ) { echo 'All';} else { echo $item->designation_name; }  ?></td> 
									<td><?php if($item->emp_department == 0 ) { echo 'All';} else { echo $item->department_name; }  ?></td> 
									<td><?php if($item->emp_grade == 0 ) { echo 'All';} else { echo $item->grade_name; }  ?></td> 
									<td><?php if($item->epmloyee_status == 0 ) { echo 'All';} elseif($item->epmloyee_status == 1 ) { echo 'Probation';} elseif($item->epmloyee_status == 2 ) { echo 'Permanent';} elseif($item->epmloyee_status == 3 ) { echo 'Masterroll';}else { echo $item->epmloyee_status; }  ?></td> 
									<td><?php echo $item->active_from; ?><span style="color:red;"> to</span> <?php echo $item->active_upto; ?></td>
									<td><?php if($item->status == 1) {echo 'Active';} else {echo 'Not Active';} ?></td> 
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/salary-plus/'.$item->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
								</tr>
								<?php } ?>
							</tbody>      
						</table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>		
	<script>
		var table;
		$(document).ready(function() {
		   table = $('#table').DataTable({
				"pageLength": 50,

			});
		});
	</script>
	<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$("#Salary_Plus").addClass('active');
			});
	</script>
@endsection