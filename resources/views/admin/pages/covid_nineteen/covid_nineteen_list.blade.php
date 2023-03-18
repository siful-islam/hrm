@extends('admin.admin_master')
@section('title', 'Covid-Nineteen')
@section('main_content')
<style>
.pull-right {
margin-right: 10px;	
}
</style>
<section class="content-header">
	<h1>Covid-<small>19</small></h1>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/covid-nineteen/create')}}" class="btn btn-primary pull-right" type="button"> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp Type</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Effect Date</th>
								<th>Designation</th>                
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp Type</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Effect Date</th>
								<th>Designation</th>                
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td><?php echo $result->type_name; ?></td>
								<td><?php echo empty($result->sacmo_id) ? $result->emp_id : $result->sacmo_id; ?></td>
								<td><?php echo empty($result->emp_name) ? $result->emp_name_eng : $result->emp_name; ?></td>
								<td>{{$result->entry_date}}</td>
								<td>{{$result->designation_name}}</td>
								<td class="text-center">
									<a class="btn btn-info" title="View" href="{{URL::to('/covid_nineteen_view/'.$result->emp_id.'/'.$result->id)}}"><i class="fa fa-eye"></i></a>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/covid-nineteen/'.$result->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupOthers").addClass('active');
			$("#Covid-19").addClass('active');
		});
	</script>
@endsection