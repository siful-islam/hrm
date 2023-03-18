@extends('admin.admin_master')
@section('main_content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h4>Recommend Leave</h4>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Recommend</a></li>
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
						<div class="table-responsive">
						<table id="table" class="table no-border table-striped">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Emp Name</th>
									<th>Application Date</th> 
									<th>Supervisor</th> 
									<th>HR Head</th> 
									<th>View</th>  
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tbody>
								
								 <?php if(!empty($leave_recoment_list)){ 
								 $i = 1;
								foreach($leave_recoment_list as $emp_leave){ ?>
								<tr>
									<td>{{$i++}}</td>
									<td> 
									<?php if(!empty($emp_leave['emp_name'])) { 
											echo $emp_leave['emp_name']; 
										} else {
											echo $emp_leave['emp_name2']; 
										} ?> 
									
									</td>
									<td>{{$emp_leave['application_date']}}</td> 
									 
									<td>
										<?php 
											 
											if($emp_leave['super_action'] > 0){
												 
													if($emp_leave['super_action'] == 2){ ?>
													<span style="color:green;"> Approved</span>
													<?php 	} else if($emp_leave['super_action'] == 3){ ?>
													 <span style="color:#FF9900;"> Recommend</span>  
													<?php 	} else if($emp_leave['super_action'] == 1){ ?>
													 <span style="color:#FF9900;"> Pending</span> 
													<?php 	} else if($emp_leave['super_action'] == 4){ ?>
													 <span style="color:red;"> Reject</span> 
											<?php  } } ?> 
									</td>
									<td><?php    
												if($emp_leave['hrhd_action'] == 2){ ?>
													<span style="color:green;">Approved </span>
												<?php 	}else if($emp_leave['hrhd_action'] == 3){ ?>
													 <span style="color:#FF9900;">Recommend </span>  
											<?php 	} else if($emp_leave['hrhd_action'] == 1 || $emp_leave['hrhd_action'] <= 0){ ?>
													 <span style="color:#FF9900;">Pending </span> 
											<?php 	}else if($emp_leave['hrhd_action'] == 4){ ?>
													 <span style="color:red;">Reject </span> 
											<?php  } 	?>  
									</td> 
									 <td class="text-center"> 
									  <a class="btn btn-primary" title="view" href="{{URL::to('/recommend_leave_view_hrhead/'.$emp_leave['id'].'/'.$emp_leave['emp_id'])}}"><i class="fa fa-file" aria-hidden="true"></i></a>
									</td>
									<td class="text-center">
									 
									<a class="btn btn-primary" title="details" href="{{URL::to('/recommend_leave_hrhead/'.$emp_leave['id'].'/'.$emp_leave['emp_id'])}}"><i class="glyphicon glyphicon-eye-open"></i></a>
									 
									</td>
								</tr>
								 <?php }} ?>
							</tbody>    
						</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
        </div>
	</section>
		
<!-- DataTables -->
<script src="{{asset('public/admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>	

<script>
	var table;
	$(document).ready(function() {
	   table = $('#table').DataTable({
		});
	});
</script>

@endsection