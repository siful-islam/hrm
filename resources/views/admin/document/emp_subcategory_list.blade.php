@extends('admin.admin_master')
@section('title', 'Manage EDMS Category')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Subcategory</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Subcategory</a></li>
			<li class="active">List</li>
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
							<a href="{{URL::to('/edms-subcategory/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add</a>
						</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th> 
									<th>Category Name</th>
									<th>Group Name</th>
									<th>Status</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th> 
									<th>Category Name</th>
									<th>Group Name</th>
									<th>Status</th>
									<th class="text-center" style="width:15%">ACtion</th>									
								</tr>
							</tfoot>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@foreach($emp_subcategory_list as $subcategory)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$subcategory->subcategory_name}}</td>
									<td>{{$subcategory->category_name}}</td>
									<td>@if($subcategory->status == 1) <span style="color:green;"> {{"Active"}} </span> @else <span style="color:red;">{{"Inactive"}} </span> @endif</td>
									 
									<td class="text-center">
									  
										<a class="btn btn-primary" title="Edit" href="{{URL::to('/edms-subcategory/'.$subcategory->subcat_id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
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
</script>
<script>
		//To active  menu.......//
			$(document).ready(function() {
				$("#MainGroupSettings").addClass('active');
				$('#Edms_Category').addClass('active');
			});
	</script>
@endsection