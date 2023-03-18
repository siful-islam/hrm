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
						<table   class="table table-bordered">
							<thead>
								<tr>
									<th>SL No</th>
									<th>Emp Name</th>
									<th>Application Date</th>  
									<th>View</th>  
									<th class="text-center" style="width:15%">ACtion</th>
								</tr>
							</thead>
							<tbody>
								
								 <?php if(!empty($leave_recoment_list)){ 
								 $i = 1;
								 date_default_timezone_set('Asia/Dhaka');
								foreach($leave_recoment_list as $emp_leave){ 
									
									$date1=date_create($emp_leave['from_date']);
									$date2=date_create($emp_leave['to_date']);
									$diff=date_diff($date1,$date2);
									$no_of_days = $diff->format("%a")+1;
								?>
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
									
									 <td class="text-center"> 
									  <a class="btn btn-primary" title="view" href="{{URL::to('/recommend_leave_view_hrhead/'.$emp_leave['id'].'/'.$emp_leave['emp_id'])}}"><i class="fa fa-file" aria-hidden="true"></i></a>
									</td> 
									<td><?php    
											
												if($no_of_days <= 10){ 
													if($emp_leave['hrhd_action'] == 2){?>
														 <button class="btn btn-primary" disabled title="details">Approved </button> 
												<?php 	}else{ ?>
														 <a class="btn btn-primary" title="details" href="{{URL::to('/approved_by_sup_approve_hrhead/'.$emp_leave['id'])}}"> Approved</a>  
												<?php 	}
												
												?>
													
												<?php }else {

													 if($emp_leave['hrhd_action'] ==3 ){ ?>
														  <button class="btn btn-info" disabled title="details">Recommend </button> 
													<?php }else{ ?>
														  <span style="color:#FF9900;"><a class="btn btn-info" title="details" href="{{URL::to('/approved_by_sup_reject_hrhead/'.$emp_leave['id'])}}">Recommend </a> </span> 
													<?php  }
													?>
													 
											<?php 	} 
												if($emp_leave['hrhd_action'] == 4){ ?>
													 <button class="btn btn-danger" disabled title="details">Reject </button> 
											<?php	}else{ ?>
													<a class="btn btn-danger" title="details" href="{{URL::to('/approved_by_sup_reject_hrhead/'.$emp_leave['id'])}}">Reject </a>  
											<?php }
											?>
												 
											  
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