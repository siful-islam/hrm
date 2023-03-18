@extends('admin.admin_master')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Designation</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Designation</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/functional-designation/create')}}" class="btn bg-navy pull-right btn-xs" type="button"><i class="glyphicon glyphicon-plus" ></i> Add </a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>                      
								<th>Designation Name</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$result->fun_deg_name}}</td>
								<td>{{$result->status==1?'Active':'InActive'}}</td>
								<td class="text-center">
									<!--<a class="btn bg-olive"  title="View" href="{{URL::to('/district')}}"><i class="fa fa-eye"></i></a>-->
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/functional-designation/'.$result->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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