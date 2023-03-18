@extends('admin.admin_master')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
				
					<form class="form-horizontal" action="{{URL::to('next-incre-list')}}" method="post">
						{{ csrf_field() }}		
						<div class="form-group">
							<div class="col-sm-2">
								<select name="search_branch" id="search_branch" class="form-control" required>
									<option value="" hidden>-Select Branch-</option>
									<?php foreach($all_branches as $all_branch) { ?>
									<option value="<?php echo $all_branch->br_code?>"><?php echo $all_branch->branch_name?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-1">
								<button type="submit" class="btn btn-danger"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
							</div>
						</div>
					</form>
					
				</div>
				
				@if (!empty($all_report))
				<div class="row">
					<div id="printme">
						<div class="col-md-12">
							<table class="table table-bordered" cellspacing="0">
								<thead>
									<tr>
										<th rowspan="2">SL No.</th>
										<th rowspan="2">Staff Name</th>
										<th rowspan="2">ID No</th>
										<th rowspan="2">Emp Type</th>
										<th rowspan="2">Designation</th>
										 
										<th rowspan="2">File</th>
									</tr> 
								</thead>
								<tbody>
									{{!$i=1}} @foreach($all_report as $result)
									<tr>
										<td>{{$i++}}</td>
										<td>{{$result['emp_name']}}</td>
										<td>{{$result['emp_id']}}</td>
										<td>{{$result['type_name']}}</td>
										<td>{{$result['designation_name']}}</td> 
										<td><a href="{{asset('attachments/attach_ment_tran/auto_increment/'.$result['document_name'])}}" target="_blank"><img src="{{asset('storage/office_order/pdf.png')}}" width="40" style="height:35px;" /></td> 
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
			</div>
        </div>
	</div>
	
</section>
<script>
	document.getElementById("search_branch").value = '<?php echo $search_branch?>';
</script>
@endsection

