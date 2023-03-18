@extends('admin.admin_master')
@section('main_content')
<script>
document.oncontextmenu = function() { 
    return false; 
};
</script>
<div class="col-md-12">		
	<div class="box box-info"  style="margin-top:30px;"> 
		<div class="box-body" id="html_remove">
			<a id="htm_image_show" download="" href="http://202.4.106.3/hrm/public/CDIP_Manual.pdf">
				<embed src="http://202.4.106.3/hrm/public/CDIP_Manual.pdf" type="application/pdf" width="100%" height="990">
			</a>
		</div>
	</div>
</div>
@endsection