@extends('admin.admin_master')
@section('title', 'Experience Certificate')
@section('main_content')
<script>  
function checkDelete()
	{
	 var chk=confirm("Are you sure to delete !!!");
		if(chk)
		{
		  return true;
		}
		else{
		  return false;
		}
	}
</script>     
   <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Testimonial</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Testimonial</a></li>
			<li class="active">list</li>
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
							<a href="{{URL::to('/testimonyadd')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>New Add</a>
						</h3>
					</div> 
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-hover">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Emp Name</th> 
									<th>Emp ID</th>
									<th>Termination Date</th>
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Emp Name</th> 
									<th>Emp ID</th>
									<th>Termination Date</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</tfoot>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@foreach($emp_testimonial_list as $testimonial)
								<tr>
									<td>{{$i++}}</td>
									<td> 
										<?php  
											echo $testimonial->emp_name; 
										  ?> 
									</td> 
									<td>{{$testimonial->emp_id}}</td>
									<td>{{$testimonial->t_date}}</td>  
									<td class="text-center">
									<a class="btn bg-olive" title="View" href="{{URL::to('/testimony_view/'.$testimonial->id.'/'.$testimonial->emp_id)}}"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;&nbsp;
									 
										<a class="btn btn-primary" onclick="return checkDelete();"  href="{{URL::to('/testimonial_delete/'.$testimonial->id)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
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
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupExperience_Certificate").addClass('active');
			$("#Certificate").addClass('active');
		});
	</script>

@endsection