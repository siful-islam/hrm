@extends('admin.admin_master')
@section('main_content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Balance check</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Balance</a></li>
			<li class="active">check</li>
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
						<table id="table" class="table no-border table-hover">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Emp Name</th>
									<th>Emp Type</th>
									<th>Emp ID</th>
									<th>Branch Name</th>
									<th>cummulative Balance</th>
									<th>FY (2009-12) Balance</th>
									<th>Current Year Balance</th>
									
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Emp Name</th>
									<th>Emp Type</th>
									<th>Emp ID</th>
									<th>Branch Name</th>
									<th>cummulative Balance</th>
									<th>FY (2009-12) Balance</th>
									<th>Current Year Balance</th>
									
								</tr>
							</tfoot>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@foreach($emp_approve_list as $emp_leave)
								<tr>
									<td>{{$i++}}</td>
									<td> 
									<?php if($emp_leave->emp_type == 'regular') { 
											echo $emp_leave->emp_name; 
										} else if(($emp_leave->emp_type == 'non_id') || ($emp_leave->emp_type == 'sacmo')){
											echo $emp_leave->emp_name2; 
										} ?> 
									
									</td>
									<td>{{$emp_leave->emp_type}}</td>
									<td>{{$emp_leave->emp_id}}</td> 
									<td>{{$emp_leave->branch_name}}</td> 
									<td>{{$emp_leave->cum_close_balance}}</td> 
									<td>{{$emp_leave->cum_balance_less_close_12}}</td> 
									<td>{{$emp_leave->current_close_balance}}</td> 
									
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
		
<!-- DataTables
<script src="{{asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	 -->

<script>
	 var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	}); 
</script>

@endsection