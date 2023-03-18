@extends('admin.admin_master')
@section('main_content')
<section class="content-header">
	<h4>Transfer</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Transfer</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/transfer/create')}}" class="btn bg-navy pull-right btn-xs" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Transfer</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Branch Name</th>
								<th>Sarok No</th>
								<th>Letter Date</th>
								<th>Br. Join Date</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($transfer_info as $transfer)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$transfer->emp_id}}</td>
								<td>{{$transfer->emp_name_eng}}</td>
								<td>{{$transfer->br_name}}</td>
								<td>{{$transfer->sarok_no}}</td>
								<td>{{$transfer->letter_date}}</td>
								<td>{{$transfer->join_date}}</td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/transfer/'.$transfer->id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/transfer/'.$transfer->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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