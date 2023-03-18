@extends('admin.admin_master')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Year Closing</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Closing</a></li>
			<li class="active">Leave</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!-- /.box-header --> 
					<div class="box-header">
						<h3 class="box-title pull-right"> 
							 {{ \Carbon\Carbon::parse($last_update_date)->format('d F Y')}}
						</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Employee ID</th>
									<th>Cumulative Balance</th> 
									<th>Current Year Balance</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tbody>
								@php 
									$i=1
								@endphp
								@foreach($emp_leave_list as $emp_leave)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$emp_leave->emp_id}}</td>
									<td>{{$emp_leave->cum_close_balance}}</td> 
									<td>{{$emp_leave->current_close_balance}}</td> 
									<td class="text-center">
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/approved_leave/'.$emp_leave->id.'/'.$emp_leave->emp_id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>    
						</table> 
						</div>
						<div class="col-xs-12">
						<a class="btn bg-olive margin" href="{{URL::to('/leave_year_add/'.$fiscal_year->id)}}">Year Leave Close</a>
						
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
		
<!-- DataTables -->
<script src="{{asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	

<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script>

@endsection