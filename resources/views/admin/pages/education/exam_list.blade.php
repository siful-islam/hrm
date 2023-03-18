@extends('admin.admin_master')
@section('title', 'Manage Exam')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h4>Exam</h4>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Exam</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/exam/create')}}" class="btn bg-navy pull-right btn-xs" type="button"><i class="glyphicon glyphicon-plus" ></i> Add Exam</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL No</th>                      
								<th>Exam</th>                    
								<th>Level</th>                    
								<th>Status</th>                    
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tbody>								
							{{!$i=1}} @foreach($all_exam as $exam)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$exam->exam_name}}</td>
								<td>{{$exam->level_name}}</td>
								<td>{{$exam->status==1?'Active':'InActive'}}</td>
								<td class="text-center">
									<!--<a class="btn bg-olive"  title="View" href="{{URL::to('/exam')}}"><i class="fa fa-eye"></i></a>-->
									<a class="btn btn-sm btn-primary" title="Edit" href="{{URL::to('/exam/'.$exam->exam_code.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
				$('#Exam').addClass('active');
			});
	</script>
@endsection