@extends('admin.admin_master')
@section('title', 'Branch Transfer')
@section('main_content')
<section class="content-header">
	<h1>Branch<small>Transfer</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Eployee</a></li>
		<li class="active">Branch Transfer</li>
	</ol>
</section>
<!-- Main content -->
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<?php if ($user_type ==3 || $user_type ==4) { ?>
				<div class="box-header">
					<a href="{{URL::to('/br_transfer_emp')}}" class="btn btn-success pull-right" type="button"><i class="glyphicon glyphicon-plus" ></i> Add</a>
				</div>
				<?php } ?>
				<div class="box-body">
					<div class="table-responsive">
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Designation</th>
								<th>Branch</th>                 
								<th>Effect Date</th>                 
								<th>Status</th>                 
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl No</th>
								<th>Emp ID</th>
								<th>Employee Name</th>
								<th>Designation</th>
								<th>Branch</th>                 
								<th>Effect Date</th>
								<th>Status</th>
								<th class="text-center" style="width:15%">Action</th>
							</tr>
						</tfoot>
						<tbody>								
							{{!$i=1}} @foreach($transfer_info as $transfer)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$transfer->emp_id}}</td>
								<td>{{$transfer->emp_name_eng}}</td>
								<td>{{$transfer->designation_name}}</td>
								<td>{{$transfer->branch_name}}</td>
								<td>{{date('d-m-Y',strtotime($transfer->br_join_date))}}</td>
								<td><?php echo ($transfer->status !=1) ? "<span style='color:red'>Pending</span>" : "<span style='color:green'>Approved</span>"; ?></td>
								<td class="text-center">
									<a class="btn bg-olive"  title="View" href="{{URL::to('/br_transfer_view/'.$transfer->emp_id.'/'.$transfer->id)}}"><i class="fa fa-eye"></i></a>
									<?php if($transfer->status !=1) { if ($user_type ==3 || $user_type ==4) { ?>
									<a class="btn btn-primary" title="Edit" href="{{URL::to('/br_transfer/'.$transfer->emp_id.'/'.$transfer->id)}}"><i class="glyphicon glyphicon-pencil"></i></a>
									<?php } } ?>
									<?php if($transfer->status ==1) { if ($user_type ==3 || $user_type ==4) { ?>
									<a href="{{asset('attachments/attach_ment_tran/'.$transfer->document_name)}}" target="_blank"><img height="40" width="40" src="{{asset('public/attachment.png')}}" border="0" alt="Attachment" /></a>
									<?php } } ?>
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
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupEmployee").addClass('active');
		$("#Branch_Transfer").addClass('active');
	});
</script>
@endsection