@extends('admin.admin_master')
@section('title', 'Final Payment')
@section('main_content')
<section class="content-header">
	<h1>Employee<small>Final Payment</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Employee</a></li>
		<li class="active">Final Payment</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/final-payment/create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add </a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>ID No.</th>                    
								<th>Name </th>
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>
							{{!$i=1}} @foreach($final_payment_info as $payment_info)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$payment_info->emp_id}}</td>							
								<td>{{$payment_info->emp_name_eng}}</td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/final-payment/1')}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/final-payment/1/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupSalary_Info").addClass('active');
		$("#Final_Payment").addClass('active');
	});
</script>
@endsection