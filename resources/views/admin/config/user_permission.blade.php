@extends('admin.admin_master')
@section('main_content')

<style>
input[type="checkbox"][readonly] {
  pointer-events: none;
}
</style>

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Config<small>Permission</small></h1>
	</section>

	<!-- Main content -->

	<section class="content">

		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> User Role Permission for : <span style="color:red;">{{$admin_role_name->admin_role_name}}</span></h3>
			</div>
			<!-- /.box-header -->

			<form role="form" action="{{URL::to('save-permission')}}" method="post" name="theForm">
			{{ csrf_field() }}
			
				<input type="hidden" name="user_role" value="{{$user_role}}">
				
				<div class="box-body">
					<div class="form-group">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL</th>
								<th align="center">Menu Name</th>
								<?php foreach($actions as $v_actions) { ?>
								<td align="center"><b><?php echo $v_actions->action_name; ?></b></td>
								<?php }?>
							</tr>
						
							<?php $i=1; if(count($exist_permission_info)) { foreach($exist_permission_info as $v_exist){ ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<th align="center"><?php echo $v_exist->nav_name; ?></th>
								<?php foreach($actions as $action) { ?>
								<td align="center"><input type="checkbox" value="<?php echo $action->action_id; ?>" name="role_permission[<?php echo $v_exist->nav_id; ?>][]" <?php if(in_array($action->action_id,$p = explode(",", $v_exist->permission))) {echo 'checked';} ?> <?php if($action->action_id ==1) {echo 'readonly';} ?>></td>
								<?php }?>
							</tr>
							<?php } } else { ?>
							<tr>
								<td style="color:red;" align="center" colspan="<?php echo count($actions)+3;?>">No Accessable Menu Available! </td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<?php if(count($navbar)) { ?>
				<div class="box-footer">
					<button type="submit" class="btn btn-danger"> Update Changes</button>
				</div>
				<?php } ?>
            </form>

		</div>
	</section>

<script>
function selectToggle(toggle, form) {
    var myForm = document.forms[form];
	
	
    for( var i=0; i < myForm.length; i++ ) { 
        if(toggle) {
            myForm.elements[i].checked = "checked";
        } 
		else {
            myForm.elements[i].checked = "";
        }
    }
}
</script>

	

@endsection