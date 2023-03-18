@extends('admin.admin_master')
@section('title', 'Leave Application')
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
		<h4>Employee Leave</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
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
							<a href="{{URL::to('/add-leave')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>New Leave</a>
						</h3>
					</div> 
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-hover">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Application Date</th> 
									<th>Emp ID</th>  
									<th>Emp Name</th> 
									<th>Branch</th> 
									<th>Designation</th> 
									<th>Serial No</th> 
									<th>Approved date from</th> 
									<th>Approved date to</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>SL No</th>
									<th>Application Date</th> 
									<th>Emp ID</th> 
									<th>Emp Name</th> 
									<th>Branch</th> 
									<th>Designation</th> 
									<th>Serial No</th>
									<th>Approved date from</th> 
									<th>Approved date to</th> 
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</tfoot>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@if(!empty($emp_leave_list))
								@foreach($emp_leave_list  as $emp_leave)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$emp_leave->application_date}}</td> 
									<td>{{$emp_leave->emp_id}}</td>   
									<td> 
										<?php   
											echo $emp_leave->emp_name; 
										 ?> 
									</td>
									<td>{{$emp_leave->branch_name}}</td> 									
									<td>{{$emp_leave->designation_name}}</td> 									
									<td>{{$emp_leave->serial_no}} </td> 
									<td>{{$emp_leave->appr_from_date}} </td> 
									<td>{{$emp_leave->appr_to_date}} </td> 
									<td class="text-center">
									<?php if($emp_leave->type_id != 2) { ?>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/emp_leave_br_edit/'.$emp_leave->id)}}"><i class="glyphicon glyphicon-pencil"></i></a> 
									<?php }  ?>
									&nbsp;&nbsp;&nbsp;
										<a class="btn btn-primary" onclick="return checkDelete();"  href="{{URL::to('/emp_leave_br_del/'.$emp_leave->id)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
									</td>
								</tr>
								@endforeach
								@endif
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
			$("#MainGroupEmployee").addClass('active');
			$("#Leave_Application").addClass('active');
		});
	</script>
@endsection