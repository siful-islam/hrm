@extends('admin.admin_master')
@section('title', 'Susupension')
@section('main_content')
<section class="content-header">
	<h1>Susupension<small>Setup</small></h1>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/suspension/create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>From Date</th> 
								<th>To Date</th> 
								<th>Day/s</th>    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>From Date</th> 
								<th>To Date</th> 
								<th>Day/s</th> 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td><?php echo $result->emp_id; ?></td>
								<td><?php echo $result->emp_name_eng; ?></td>
								<td>{{$result->from_date}}</td> 
								<td>{{$result->to_date}}</td> 
								<td>{{$result->total_days}}</td> 
								<td class="text-center">
									
									<!--<a class="btn bg-olive"  title="View" href="{{URL::to('/suspension_view/'.$result->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
									
									<?php if($result->payroll_satus == 0){ ?>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/suspension/'.$result->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Suspension").addClass('active');
		});
	</script>
@endsection