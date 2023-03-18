@extends('admin.admin_master')
@section('main_content')

<style>
.required {
    color: red;
    font-size: 20px;
}
.form-inline.report .form-group {
    padding-left: 5px;
    padding-right: 5px;
}
#cke_1_contents {
	height: 100px !important;
}
</style>
<script src="{{asset('public/admin_asset/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
	<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Increment Letter <small>{{$Heading}}</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Increment Letter</li>
	</ol>
</section>
<section class="content">
	<div class="row">			
		<!-- form start -->
		<form action="{{URL::to($action)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<input type="hidden" name="id" value="{{$id}}" />
						<div class="form-group">
							<label for="comments" style="padding-top: 7%;" class="col-sm-2 control-label">Heading Line </label>
							<div class="col-sm-9">
								<textarea name="letter_heading" class="form-control">{{$letter_heading}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label">Letter Body-1 </label>
							<div class="col-sm-9">
								<textarea style="border-radius: 4px;" name="letter_body_1" class="form-control">{{$letter_body_1}}</textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label">Letter Body-2 </label>
							<div class="col-sm-9">
								<textarea style="border-radius: 4px;" name="letter_body_2" class="form-control">{{$letter_body_2}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="comments" style="padding-top: 15%;" class="col-sm-2 control-label">Letter Body-3 </label>
							<div class="col-sm-9">
								<textarea name="letter_body_3" class="form-control">{{$letter_body_3}}</textarea>
							</div>
						</div>						
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<a href="#" class="btn bg-olive" type="button"><i class="icon-list" ></i> List</a>&nbsp;
						<button type="submit" class="btn bg-navy"><i class="icon-save"></i> Save</button>
					</div>
				   <!-- /.box-footer -->
				</div>
			</div>
		</form>			
	</div>
</section>
<script type="text/javascript"><!--
CKEDITOR.replace('letter_heading');
    CKEDITOR.add 
//--></script>
<script type="text/javascript"><!--
CKEDITOR.replace('letter_body_3');
    CKEDITOR.add 
//--></script>
@endsection