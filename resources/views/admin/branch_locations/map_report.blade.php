@extends('admin.admin_master')
@section('main_content')
<br></br></br>
<style>
.containers {
  position: relative;
  width: 100%;
  overflow: hidden;
  padding-top: 56.25%; /* 16:9 Aspect Ratio */
  margin-left: 10px;
}

.responsive-iframe {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
  border: none;
}
</style>

	<div class = "containers">
		<iframe class="responsive-iframe" src="https://www.google.com/maps/d/embed?mid=1iNO0mZA9Yz70R_XQ1Xt_IJ9Ej0CK8stk&z=8" ></iframe>
	</div>

	
@endsection