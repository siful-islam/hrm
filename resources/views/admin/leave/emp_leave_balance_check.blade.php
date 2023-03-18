@extends('admin.admin_master')
@section('title', 'Leave Application')
@section('main_content')
<script type="text/javascript" src="{{asset('public/scripts/jquery.btechco.excelexport.js')}}"></script>		
<script type="text/javascript" src="{{asset('public/scripts/jquery.base64.js')}}"></script>		
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
					 
					<div class="box-body">
					<button type="button" id="btnExport" class="btn btn-primary" >Export Excel</button>
						<div class="table-responsive">
						<table id="tblExport" class="table">
							<thead>
								<tr>
									<th>SL No</th> 
									<th>Emp ID</th>
									<th>Emp Type</th> 
									<!--<th>Previous Year Leave(opening)</th> 
									<th>Days</th> 
									<th>Previous Year Leave(closing) </th>
									<th>Current Year leave(opening)</th> 
									
									<th>Days</th>  
									<th>Current Year leave(Closing)</th> 
									<th>Previous(9-12)(opening)</th> 
									<th>Days</th>  
									<th>Previous(9-12)(Closing)</th>  -->
									<th>Current Year leave(Closing)</th> 
									<th>Previous Year Leave(closing) </th>
									<th>new previous balance</th> 
								</tr>
							</thead>
							<tbody>
								
								@php 
									$i=1
								@endphp
								@if(!empty($check_balance_all))
								@foreach($check_balance_all  as $v_check_balance)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$v_check_balance['emp_id']}}</td> 
									<td>{{$v_check_balance['type_name']}}</td> 
									<!--<td>{{$v_check_balance['pre_cumulative_open']}}</td>  
									<td>{{$v_check_balance['no_of_days_pre']}}</td>
									<td>{{$v_check_balance['pre_cumulative_close']}}</td> 
									<td>{{$v_check_balance['current_open_balance']}}</td>  
									  
									<td>{{$v_check_balance['no_of_days']}}</td>   
									<td>{{$v_check_balance['current_close_balance']}}</td>  
									<td>{{$v_check_balance['cum_balance_less_12']}}</td>  
									<td>{{$v_check_balance['no_of_days_9_12']}}</td>  
									<td>{{$v_check_balance['cum_balance_less_close_12']}}</td>  -->
									
									<td>{{$v_check_balance['current_close_balance']}}</td> 
									<td>{{$v_check_balance['pre_cumulative_close']}}</td> 
									<td>{{$v_check_balance['after_pre_cumulative_open']}}</td>
									
									
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
    $(document).ready(function () {
        $("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
            });
        });
    });
</script>
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