@extends('admin.admin_master')
@section('title', 'Arrear Setup')
@section('main_content')
<section class="content-header">
	<h1>Arrear<small>Setup</small></h1>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<a href="{{URL::to('/arrear_allow_setup/create')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Arrear Month</th>  
								<th>Pay Month</th> 								
								<th> Status </th>                
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Arrear From</th> 
								<th>Arrear To</th>  
								<th>Pay Month</th>  
								<th> Status </th>                
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($all_result as $result)
							<tr>
								<td>{{$i++}}</td>
								<td><?php echo $result->arrear_emp_id; ?></td>
								<td><?php echo $result->emp_name_eng; ?></td>
								<td>{{$result->arrear_from}}</td> 
								<td>{{$result->arrear_to}}</td> 
								<td>{{$result->arrear_pay_month}}</td>  
								<td><?php if($result->paid_status == 1) echo "Paid"; else if($result->paid_status ==0) echo "Not Paid";  ?></td>
								<td class="text-center">
									<?php if($result->paid_status == 0){ ?>
									<a class="btn bg-olive"  title="Edit" href="{{URL::to('/arrear_allow_setup/'.$result->arrear_alowance_id.'/edit')}}"><i class="glyphicon glyphicon-pencil"></i></a>
									<?php } ?>
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
		$(document).ready(function() {
			$("#MainGroupSalary_Info").addClass('active');
			$("#Arrear_Allawance").addClass('active');
		});
	</script>
@endsection