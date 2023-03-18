@extends('admin.admin_master')
@section('main_content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>aaaa</small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				
	
				<?php 
				//echo '<pre>';
				//print_r($infos);
				?>
				
				
				
				
				<table width="100%" border="1">
					<tr>
						<td>Sl</td>
						<td>Emp ID</td>
						<td>Sarok No</td>
						<td>Branch Name</td>
						<td>Designation</td>
						<td>Grade</td>
						<td>Step</td>
						<td>Basic Salary</td>
					</tr>
				<?php $i = 1; $correct_count = 0; $wrong_count = 0; $not_found =array(); foreach($infos as $info) {  ?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $info->emp_id; ?></td>
						<td><?php echo $info->sarok_no; ?></td>
						<td><?php echo $info->branch_name; ?></td>
						<td><?php echo $info->designation_name; ?></td>
						<td><?php echo $info->grade_code; ?></td>
						<td><?php echo $info->grade_step; ?></td>
						<td><?php echo $info->basic_salary; ?></td>
					</tr>
					
					
						<?php 

						
						$emp_id = $info->emp_id;
						
						$update['post_br'] = $info->branch_name;
						$update['post_grade'] = $info->grade_code;
						$update['post_step'] = $info->grade_step;
						$update['post_basic'] = $info->basic_salary;
						$update['post_dsg'] = $info->designation_name;

						$status = DB::table('check_increment')
							->where('emp_id', $emp_id)
							->update($update);
						
						?>
					
					
					
					
					
					
				<?php } ?>	
					
				</table>
						
	
	
	<?php
	//print_r($status);
	?>
						
			</div>
        </div>
		
		
		

		
		
		
		
		
	</div>
	
</section>

@endsection

