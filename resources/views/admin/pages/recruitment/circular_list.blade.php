@extends('admin.admin_master')
@section('title', 'Circular')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Circular</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Circular</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/circular-add')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Circular</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>                      
								<th>Circular Name</th>                    
								<th>Circular Date</th>                    
								<th>End Date</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($circular_info as $cir_info)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$cir_info->circular_name}}</td>
								<td>{{$cir_info->start_date}}</td>
								<td>{{$cir_info->end_date}}</td>
								<td>{{$cir_info->status==1?'Active':'InActive'}}</td>
								<td class="text-center">
									<!--<a class="btn bg-olive"  title="View" href="{{URL::to('/view-circular')}}"><i class="fa fa-eye"></i></a>-->
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/edit-circular/'.$cir_info->id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
<script>
	$(document).ready(function() {
		$("#MainGroupRecruitment").addClass('active');
		$("#Circular").addClass('active');
	});
</script>
@endsection