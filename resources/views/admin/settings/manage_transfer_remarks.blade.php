@extends('admin.admin_master')
@section('title', 'Manage Transfer Causes')
@section('main_content')
<!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>HRM<small>Configuration</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
		</ol>
    </section>
	

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Transfer Remarks</h3>
							<a href="{{URL::to('/transfer-remarks/create')}}" id="add_new" class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Remarks</a>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						
						<!--<table id="table" class="table table-hover table-bordered table-responsive" >-->
						<table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Short Name</th>                   
									<th>Status</th>                      
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($remarks as $remark)
								<tr>
									<td>{{$remark->id}}</td>
									<td>{{$remark->remarks_note}}</td>
									<td>{{$remark->status}}</td>
									<td><a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('transfer-remarks/'.$remark->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
				$('#Transfer_Causes').addClass('active');
			});
	</script>
@endsection