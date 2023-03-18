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
						<td>Pre Branch</td>
						<td>Post Branch </td>
						<td>Branch Status</td>
						<td>Pre Grade</td>
						<td>Post Grade</td>
						<td>Grade Status</td>
						<td>Pre Step</td>
						<td>Post Step</td>
						<td>Step Status</td>
						<td>Pre Basic</td>
						<td>Post Basic</td>
						<td>Basic Status</td>
						<td>Pre Designation</td>
						<td>Post Designation</td>
						<td>Des Status</td>
						<td>Red Marked</td>
						
					</tr>
				<?php $i = 1; $not_found =array(); foreach($infos as $info) {  ?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $info->emp_id; ?></td>
						
						<td><?php echo $info->pre_br; ?></td>
						<td><?php echo $info->post_br; ?></td>
						<td><?php if($info->pre_br == $info->post_br) { $br_match = 'Ok'; } else { $br_match = 'Br_Wrong'; } echo $br_match; ?></td>
						
						<td><?php echo $info->pre_grade; ?></td>
						<td><?php echo $info->post_grade; ?></td>
						<td><?php if($info->pre_grade == $info->post_grade) { $grade_match = 'Ok'; } else { $grade_match = 'Grade_Wrong'; } echo $grade_match; ?></td>
						
						<td><?php echo $info->pre_step; ?></td>
						<td><?php echo $info->post_step; ?></td>
						<td>
						<?php if($info->post_step == '') 
						{
							$basic_match = 'Redmarked';
						}
						else 
						{ 
							if($info->pre_step == $info->post_step) { $step_match = 'Ok'; } else { $step_match = 'Step_Wrong'; }
						}
						 echo $step_match; ?></td>
						
						<td><?php echo $info->pre_basic; ?></td>
						<td><?php echo $info->post_basic; ?></td>
						<td>
						<?php if($info->post_basic == '') 
						{
							$basic_match = 'Redmarked';
						}
						else 
						{ 
							if($info->pre_basic == $info->post_basic) { $basic_match = 'Ok'; } else { $basic_match = 'Basic_Wrong'; }
						}
						 echo $basic_match; ?></td>
						
						<td><?php echo $info->pre_dsg; ?></td>
						<td><?php echo $info->post_dsg; ?></td>
						<td><?php if($info->pre_dsg == $info->post_dsg) { $dsg_match = 'Ok'; } else { $dsg_match = 'Wrong'; } echo $dsg_match; ?></td>
						<?php if($info->is_red_mark ==1) { ?>
						<td style="color:red">Red Marked</td>
						<?php  } else { ?>
						<td>***</td>
						<?php  } ?>
					</tr>
				<?php 
								
				/*if() 
				{
					$status['correct_count'] += 1;
				}
				else
				{
					$status['wrong_count'] += 1;
					//$wrong_count[] += 1;
				}*/
				
				} ?>	
					
				</table>
						
	

						
			</div>
        </div>
		
		
		

		
		
		
		
		
	</div>
	
</section>

@endsection

