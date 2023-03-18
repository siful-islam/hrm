@extends('admin.admin_master')
@section('main_content')
<script type="text/javascript" language="javascript">
function checkDelete() {
	var chk=confirm("Are you sure you want to delete!");
	if(chk) {
		return true;
	} else {
		return false;				
	}
	
}			
</script>
<section class="content-header">
	<h4>Marked</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Marked</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/marked/create')}}" class="btn bg-navy pull-right btn-xs" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Marked</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Open Date</th>
								<th>Branch Name</th>
								<th>Designation</th>
								<th>Marked For</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($marked_info as $marked)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$marked->emp_id}}</td>
								<td>{{$marked->emp_name_eng}}</td>
								<td>{{$marked->open_date}}</td>
								<td>{{$marked->br_name}}</td>
								<td>{{$marked->designation_name}}</td>
								<td>{{$marked->marked_for}}</td>
								<td>{{$marked->status==1?'InActive':'Active'}}</td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/marked/'.$marked->id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/marked/'.$marked->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
									<a class="btn btn-danger" title="Delete" href="{{URL::to('/marked-delete/'.$marked->id)}}" onclick="return checkDelete();"><i class="glyphicon glyphicon-remove"></i></a>
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