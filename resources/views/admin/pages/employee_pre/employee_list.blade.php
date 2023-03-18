@extends('admin.admin_master')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Employee CV</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Employee</a></li>
		<li class="active">CV</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Joining Date</th>
								<th>Contact Number</th>
								<th>Thana</th>                      
								<th>District</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>
							
							{{!$i=1}} @foreach($all_emp_list as $emp_list)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$emp_list->emp_id}}</td>
								<td>{{$emp_list->emp_name_eng}}</td>
								<td>{{$emp_list->org_join_date}}</td>
								<td>{{$emp_list->contact_num}}</td>
								<td>{{$emp_list->thana_name}}</td>
								<td>{{$emp_list->district_name}}</td>
								<td class="text-center">
								<a class="btn bg-olive"  title="View" href="{{URL::to('/emp-cv/'.$emp_list->emp_id)}}"><i class="fa fa-eye"></i></a>
								<a class="btn btn-primary" title="Edit" href="{{URL::to('/emp-general/'.$emp_list->emp_id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script>
@endsection