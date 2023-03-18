@extends('admin.admin_master')
@section('title', 'Manage Holiday')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Navs<small>Extra Molibe</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Extra Mobile Allowance</h3>
						<a href="{{URL::to('/add-extra_mobile')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Eployee ID</th>
									<th>Amount</th>
									<th>Active From</th>     
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($allowances as $allowance)
								<tr>
									<td>{{$allowance->extra_allowance_id}}</td>
									<td>{{$allowance->extra_allowance_emp_id}}</td>
									<td>{{$allowance->extra_allowance_amount}}</td>
									<td>{{$allowance->extra_allowance_from_date}}</td>
									<td>
										<a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/edit-extra_mobile/'.$allowance->extra_allowance_id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
										<a class="btn btn-sm btn-danger" title="Delete" href="{{URL::to('/delete-extra_mobile/'.$allowance->extra_allowance_id)}}" onclick="return confirm('Are you sure?')"><i class="glyphicon glyphicon-trash"></i></a>
									</td>
								</tr>
								@endforeach
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

		});
	});
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupSettings").addClass('active');
			$("#Holidays").addClass('active');
		});
	</script>

@endsection