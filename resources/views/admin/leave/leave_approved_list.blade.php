@extends('admin.admin_master')
@section('title', 'Add Leave')
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
		<h4>Approved Leave</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Approved</a></li>
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
							<a href="{{URL::to('/add_aprove_leave')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>New Leave</a>
						</h3>
					</div> 
					<div class="box-body">
						<div class="table-responsive">
						<table id="table" class="table no-border table-hover">
							<thead>
								<tr>
									<th>Serial No</th> 
									<th>Application Date</th> 
									<th>Emp ID</th> 
									<th>Emp Name</th> 
									<th>Branch</th> 
									<th>Designation</th>  
									<th>Leave Type</th>  
									<th>Date From</th> 
									<th>Date To</th> 
									<th>Day</th> 
									<!--
									<th class="text-center" style="width:15%">ACtion</th>
									-->
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Serial No</th> 
									<th>Application Date</th> 
									<th>Emp ID</th> 
									<th>Emp Name</th> 
									<th>Branch</th> 
									<th>Designation</th>  
									<th>Leave Type</th>  
									<th>Date From</th> 
									<th>Date To</th> 
									<th>Day</th>  
									<!--
									<th class="text-center" style="width:15%">ACtion</th>
									-->
								</tr>
							</tfoot>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@foreach($emp_approve_list as $emp_leave)
								<tr> 
									<td>{{$emp_leave->serial_no}} </td> 
									<td>{{date("d-m-Y",strtotime($emp_leave->application_date))}}</td> 
									<td>{{$emp_leave->emp_id}}</td> 
									<td>{{$emp_leave->emp_name}} </td>
									<td>{{$emp_leave->branch_name}}</td> 									
									<td>{{$emp_leave->designation_name}}</td>  
									<td>{{$emp_leave->type_name}}</td>  
									<td>{{date("d-m-Y",strtotime($emp_leave->appr_from_date))}} </td> 
									<td>{{date("d-m-Y",strtotime($emp_leave->appr_to_date))}} </td> 
									<td><?php echo $emp_leave->no_of_days_appr; if($emp_leave->apply_for == 2){ echo " ( Morning )"; }else if($emp_leave->apply_for == 3) { echo " ( Evening )";}  ?> </td> 
									<!--<td class="text-center">
									<?php //if($emp_leave->type_id != 2) { ?>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/approved_leave/'.$emp_leave->id.'/'.$emp_leave->f_year_id.'/'.$emp_leave->emp_id)}}"><i class="glyphicon glyphicon-pencil"></i></a> 
									<?php //}  ?>
									&nbsp;&nbsp;&nbsp;
										<a class="btn btn-primary" onclick="return checkDelete();"  href="{{URL::to('/approved_leave_delete/'.$emp_leave->id.'/'.$emp_leave->f_year_id.'/'.$emp_leave->emp_id)}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
									</td> -->
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
		   "order": [[ 0, "desc" ]]
		});
	});
 	
</script>
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			$("#Add_Leave").addClass('active');
			//$('[id^=Leave_Report_]')
		});
	</script>

@endsection