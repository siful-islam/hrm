
<?php $__env->startSection('title','User Report'); ?>
<?php $__env->startSection('main_content'); ?>

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
				<h3 class="box-title"> User Manu Permission :</h3>
			</div>
			<!-- /.box-header -->

			<form role="form" action="" method="post" name="theForm"> 
				<div class="box-body">
					<div class="form-group">
						<table class="table table-bordered table-striped">
							<tr>
								<th>SL</th>
								<th style="text-align:center;">User Name</th>
								<th style="text-align:center;">Role</th> 
								<th>Manu Name</th> 
							</tr> 
							
							<?php 
								$i = 1;
								foreach($all_user as $user) { 
							
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<th align="center"><?php echo $user->admin_name; ?></th>
								
								<td align="center"><?php echo $user->admin_role_name; ?> </td>
								<td> 
								 
									<?php 
									$role_id = $user->id;
									$get_manu = DB::table('tbl_navbar')->whereRaw("find_in_set($role_id,user_access)")->where('nav_status',1)->get();
									$j = 0; 
									echo  "<table><tr>";
									foreach($get_manu as $v_get_manu){
										if($j%5 == 0){ 
											echo  "</tr><tr><td style='border:1px solid black;padding:2px;'>".$v_get_manu->nav_name."</td>"; 	
										}else
										{
											echo  "<td style='border:1px solid black;padding:2px;'>".$v_get_manu->nav_name."</td>";
										}
										$j++;
									}
									 echo  "</tr></table>";
								?>
								 
								
								
								
								
								</td>
								
							</tr> 
							<?php }?>
						</table>
					</div>
				</div> 
            </form>

		</div>
	</section>

<script>

</script>

<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#User_Report").addClass('active');
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>