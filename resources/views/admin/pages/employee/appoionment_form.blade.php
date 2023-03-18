@extends('admin.admin_master')
@section('main_content')


	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>

	<!-- Main content -->

	<section class="content">
 
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> {{$Heading}}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
				<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="new_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" value="{{$id}}" name="id" id="id">

				<div class="form-group">
                    <label class="control-label col-md-2">ID No :</label>
                    <div class="col-md-3">
                        <input type="text" name="emp_id" id="emp_id" class="form-control" value="{{$emp_id}}" required readonly>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Letter Date : </label>
                    <div class="col-md-3">
                        <input type="date" name="letter_date" id="letter_date" class="form-control" required value="{{$letter_date}}">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Employee Name :</label>
                    <div class="col-md-3">
                        <input type="text" name="emp_name" id="emp_name" value="{{$emp_name}}" class="form-control" required placeholder="Employee Name">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Fathers Name : </label>
                    <div class="col-md-3">
                        <input type="text" name="father_name" id="father_name" value="{{$father_name}}" class="form-control" required placeholder="Fathers name">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Village : </label>
                    <div class="col-md-3">
                        <input type="text" name="emp_village" id="emp_village" value="{{$emp_village}}" class="form-control" required placeholder="Village">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Post Office : </label>
                    <div class="col-md-3">
                        <input type="text" name="emp_po" id="emp_po" value="{{$emp_po}}" class="form-control" required placeholder="Post Office">
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">District : </label>
                    <div class="col-md-3">
                        <select name="emp_district" id="emp_district" required class="form-control">
							<option value="" hidden>District</option>
							<option value="1">Dhaka</option>
							<option value="2">Comilla</option>
							<option value="2">Rajshahi</option>
						</select>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Thana : </label>
                    <div class="col-md-3">
                        <select name="emp_thana" id="emp_thana" required class="form-control">
							<option value="" hidden>Thana</option>
							<option value="1">Dhanmondi</option>
							<option value="2">Mohammadpur</option>
							<option value="2">Banani</option>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="box-header with-border">
				  <h3 class="box-title">Joining Info</h3>
				</div><br>
					
				<div class="form-group">
                    <label class="control-label col-md-2">Joining Date : </label>
                    <div class="col-md-3">
                        <input type="date" name="joining_date" id="joining_date" value="{{$joining_date}}" required class="form-control">
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Joining Branch : </label>
                    <div class="col-md-3">
                         <select name="joining_branch" id="joining_branch" required class="form-control">
							<option value="" hidden>Branch</option>
							<option value="1">Head Office</option>
							<option value="2">Kuti</option>
							<option value="2">Dharkar</option>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
					<label class="control-label col-md-2">Join as : </label>
                    <div class="col-md-3">
                        <select name="join_as" id="join_as" required class="form-control">
							<option value="" hidden>Join as</option>
							<option value="1">Probesion</option>
							<option value="2">Masterrole</option>
						</select>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Period (Month) : </label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="period" id="period" value="{{$period}}" required>
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group">
					<label class="control-label col-md-2">Gross Salary : </label>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="gross_salary" id="gross_salary" value="{{$gross_salary}}" required>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Diposit Money : </label>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="diposit_money" id="diposit_money" value="{{$diposit_money}}" required>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="control-label col-md-2">Designation : </label>
                    <div class="col-md-3">
                        <select class="form-control" name="emp_designation" id="emp_designation" required>
							<option value="" hidden>Designation</option>
							<option value="1">Accounts Officer</option>
							<option value="2">AGM</option>
							<option value="2">DGM</option>
						</select>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Department : </label>
                    <div class="col-md-3">
                        <select class="form-control" name="emp_department" id="emp_department" required>
							<option value="" hidden>Department</option>
							<option value="1">Program</option>
							<option value="2">Admin</option>
							<option value="2">Accounts</option>
						</select>
                        <span class="help-block"></span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="control-label col-md-2">Reported To : </label>
                    <div class="col-md-3">
                        <select class="form-control" name="reported_to" id="reported_to" required>
							<option value="" hidden>Reported To</option>
							<option value="1">Accounts Officer</option>
							<option value="2">AGM</option>
							<option value="2">DGM</option>
						</select>
                        <span class="help-block"></span>
                    </div>
					<label class="control-label col-md-2">Joined date : </label>
                    <div class="col-md-3">
                        <input type="date" name="joined_date" id="joined_date" class="form-control" value="{{$joined_date}}" required>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
					<label class="control-label col-md-2">Letter Body </label>
					<div class="col-md-8">
					   <textarea id="letter_body" name="letter_body" rows="15" cols="80">{{$letter_body}}</textarea>
						<span class="help-block"></span>
					</div>
				</div>
  
				<div class="box-footer">
					<button type="sublit" id="btnSave" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>

		</div>
	</section>

	
	<!-- CK Editor -->
<script src="{{asset('public/admid_asset/bower_components/ckeditor/ckeditor.js')}}"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('letter_body')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>

@endsection