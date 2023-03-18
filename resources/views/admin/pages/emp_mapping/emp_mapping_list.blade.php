@extends('admin.admin_master')
@section('main_content')
<section class="content-header">
	<h1>Employee<small>Mapping</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Manage Mapping</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/emp_mapping')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Start Date</th>
								<th>Program</th>
								<th>Department</th>                 
								<th>Unit</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Start Date</th>
								<th>Program</th>
								<th>Department</th>                 
								<th>Unit</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($mapping_info as $mapping)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$mapping->emp_id}}</td>
								<td>{{$mapping->emp_name_eng}}</td>
								<td>{{$mapping->start_date}}</td>
								<td> <?php 
								if($mapping->current_program_id ==1) { echo 'Microfinance Program';}
								else if($mapping->current_program_id ==2) { echo 'Special Program';}
								?>
								</td>
								<td>{{$mapping->department_name}}</td>
								<td>{{$mapping->unit_name}}</td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/emp_mapping_view/'.$mapping->emp_id.'/'.$mapping->id)}}"><i class="fa fa-eye"></i></a>
									<!--<a class="btn btn-primary" title="Edit" href="{{URL::to('/emp-mapping/'.$mapping->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>-->
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
@endsection