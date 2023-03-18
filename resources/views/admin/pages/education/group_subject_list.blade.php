@extends('admin.admin_master')
@section('title', 'Manage Group-Subject')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Group-Subject</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Group-Subject</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/group-subject/create')}}" class="btn bg-navy pull-right btn-xs" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Group-Subject</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>                      
								<th>Group-Subject</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($all_group_subject as $group_subject)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$group_subject->subject_name}}</td>
								<td>{{$group_subject->status==1?'Active':'InActive'}}</td>
								<td class="text-center">
									<!--<a class="btn bg-olive"  title="View" href="{{URL::to('/group-subject')}}"><i class="fa fa-eye"></i></a>-->
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/group-subject/'.$group_subject->id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
				$("#MainGroupSettings").addClass('active');
				$('#Group_Subject').addClass('active');
			});
	</script>
@endsection