
<?php $__env->startSection('title', 'Staff Strength-Org. Report'); ?>
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
}
.table-bordered {
    border: 1px solid black;
}
.table > thead > tr > th {
    border: 1px solid black;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: center; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid black;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small><?php echo e($Heading); ?></small></h1>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/pomis_three_report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
						  <label for="pwd">Date WithIn:</label>
						  <input type="text" id="date_within" class="form-control" name="date_within" size="10" value="<?php echo e($date_within); ?>" required />
						</div> 
						<div class="form-group"> 
						   <select name="is_register_form" id="is_register_form" class="form-control"> 
							  <option value="1" <?php if($is_register_form == 1){ echo "Selected";}?>>All</option> 
							  <option value="2" <?php if($is_register_form == 2){ echo "Selected";}?>>Only Register</option>
							</select>
						</div>		
						<button type="submit" class="btn btn-primary">Search</button>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
	
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="3">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="3">POMIS-3 Report</font></b><?php echo ' ( as on'.' '.date("d-m-Y", strtotime($date_within)).')'; ?><br>
				<font size="3">Staff Information</font>
				</p>
				
				<div class="pull-left">
				  <font size="3">Name of Month : <?php echo date("F",strtotime($date_within)).' - '.date('Y', strtotime($date_within));?>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				   <?php if($is_register_form == 1){ echo "All";} ?>
				   <?php if($is_register_form == 2){ echo "Only Register";} ?>
				     
				  </font> 
				 
			  </div>
			  <div class="pull-right" id="hide_pending_branch">
				 <button type="button"  onclick="get_branch_name()" class="btn btn-warning">
					Pending Branch
              </button>
			  </div>
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr style="background-color:lightgray;">
							<th rowspan="2" style="width:15%;vertical-align: middle;">Name of Program</th>
							<th rowspan="2" style="width:5%;vertical-align: middle;">Gender</th>
							<th colspan="11" style="width:70%;text-align:center;">Branch Level</th>
							<th rowspan="2" style="width:5%;vertical-align: middle;" >Head Office</th>
							<th rowspan="2" style="width:5%;vertical-align: middle;">Total</th>
						</tr>
						<tr style="background-color:lightgray;">
							<th style="width:6%;border:1px solid black;">FO</th>
							<th style="width:6%;border:1px solid black;">MEDO</th>
							<th style="width:6%;border:1px solid black;">BA</th>
							<th style="width:6%;border:1px solid black;">ABM</th>
							<th style="width:6%;border:1px solid black;">BM</th>
							<th style="width:6%;border:1px solid black;">Auditor</th>
							<th style="width:6%;border:1px solid black;">AM</th>
							<th style="width:6%;border:1px solid black;">DM</th>
							<th style="width:6%;border:1px solid black;">ADM</th>
							<th style="width:6%;border:1px solid black;">Others</th>
							<th style="width:6%;border:1px solid black;">Sub Total</th>
						</tr>
					</thead>
					<tbody>
					
					<?php if(!empty($designation_count)) {
						$ff = array();
						$fo_m=0;$fo_f=0;$medo_m=0;$medo_f=0;$ba_m=0;$ba_f=0;$abm_m=0;$abm_f=0;$bm_m=0;$bm_f=0;$au_m=0;$au_f=0;$am_m=0;$am_f=0;$dm_m=0;$dm_f=0;$adm_m=0;$adm_f=0;$ot_m=0;$ot_f=0;					
						$en_hv_m=0;$en_hv_f=0;$en_of_m=0;$en_of_f=0;$en_mo_m=0;$en_mo_f=0;$m_sacmo_m=0;$m_sacmo_f=0;$en_po_m=0;$en_po_f=0;			
						$sm_ao_m=0;$sm_ao_f=0;							
						$ed_te_m=0;$ed_te_f=0;$ed_es_m=0;$ed_es_f=0;							
						$he_hv_m=0;$he_hv_f=0;$he_sa_m=0;$he_sa_f=0;
						$sc_of_m=0;$sc_of_f=0;$sc_dm_m=0;$sc_dm_f=0;
						$ad_po_m=0;$ad_po_f=0;
						$vc_of_m=0;$vc_of_f=0;$vc_ft_f=0;$vc_ft_m=0;$enrich_m=0;$enrich_f=0;$es_enrich_f=0;$es_enrich_m=0;
							
							 foreach($designation_count as $v_designation_count){
								if($v_designation_count['project_id'] == 1){
									if($v_designation_count['pomis_designation_group'] == 1){
										
										if($is_register_form == 2){
											if($v_designation_count['is_register'] == 1){
												if($v_designation_count['gender'] == 'Male'){ 
													$fo_m++;
												}else{
													$fo_f++;
												}
											} 
										}else{
											if($v_designation_count['gender'] == 'Male'){ 
												$fo_m++;
											}else{
												$fo_f++;
											}
										}
									} else if($v_designation_count['pomis_designation_group'] == 2){
										
										if($is_register_form == 2){
											if($v_designation_count['is_register'] == 1){
												if($v_designation_count['gender'] == 'Male'){ 
													$medo_m++;
												}else{
													$medo_f++;
												}
											} 
										}else{
											if($v_designation_count['gender'] == 'Male'){ 
												$medo_m++;
											}else{
												$medo_f++;
											}
										}
									} else if($v_designation_count['pomis_designation_group'] == 3){
										if($v_designation_count['gender'] == 'Male'){ 
											$ba_m++;
										}else{
											$ba_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 4){
										if($v_designation_count['gender'] == 'Male'){ 
											$abm_m++;
										}else{
											$abm_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 5){
										if($v_designation_count['gender'] == 'Male'){ 
											$bm_m++;
										}else{
											$bm_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 6){
										if($v_designation_count['gender'] == 'Male'){ 
											$au_m++;
										}else{
											$au_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 7){
										if($v_designation_count['gender'] == 'Male'){ 
											$am_m++;
										}else{
											$am_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 8){
										if($v_designation_count['gender'] == 'Male'){ 
											$dm_m++;
										}else{
											$dm_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 9){
										if($v_designation_count['gender'] == 'Male'){ 
											$adm_m++;
										}else{
											$adm_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 10){
										if($v_designation_count['gender'] == 'Male'){ 
											$ot_m++;
										}else{
											$ot_f++;
										}
									}
								} else if($v_designation_count['project_id'] == 2){
									if($v_designation_count['pomis_designation_group'] == 14){
										if($v_designation_count['gender'] == 'Male'){ 
											$en_hv_m++;
										}else{
											$en_hv_f++;
										}
										$teacher[] = $v_designation_count['emp_id'];
										
									} else if($v_designation_count['pomis_designation_group'] == 15){
										if($v_designation_count['gender'] == 'Male'){ 
											$en_of_m++;
										}else{
											$en_of_f++;
										}
										$teacher[] = $v_designation_count['emp_id'];
									} else if($v_designation_count['pomis_designation_group'] == 16){
										if($v_designation_count['gender'] == 'Male'){ 
											$en_mo_m++;
										}else{
											$en_mo_f++;
										} 
									}
									else if($v_designation_count['pomis_designation_group'] == 28){
										if($v_designation_count['gender'] == 'Male'){ 
											$m_sacmo_m++;
										}else{
											$m_sacmo_f++;
										}
										$teacher[] = $v_designation_count['emp_id'];
									}else if($v_designation_count['pomis_designation_group'] == 13){
										if($v_designation_count['gender'] == 'Male'){ 
											$enrich_m++;
										}else{
											$enrich_f++;
										}
										$teacher[] = $v_designation_count['emp_id'];
									}else if($v_designation_count['pomis_designation_group'] == 27){
										if($v_designation_count['gender'] == 'Male'){ 
											$es_enrich_m++;
										}else{
											$es_enrich_f++;
										}
										$teacher[] = $v_designation_count['emp_id'];
									}else if($v_designation_count['pomis_designation_group'] == 18){
										if($v_designation_count['gender'] == 'Male'){ 
											$en_po_m++;
										}else{
											$en_po_f++;
										}
										$teacher[] = $v_designation_count['emp_id'];
									} 

									
								} else if($v_designation_count['project_id'] == 3){
									if($v_designation_count['pomis_designation_group'] == 17){
										if($v_designation_count['gender'] == 'Male'){ 
											$sm_ao_m++;
										}else{
											$sm_ao_f++;
										}
									} 
								}else if($v_designation_count['project_id'] == 4){
									if($v_designation_count['pomis_designation_group'] == 19){
										if($v_designation_count['gender'] == 'Male'){ 
											$ed_te_m++;
										}else{
											$ed_te_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 20){
										if($v_designation_count['gender'] == 'Male'){ 
											$ed_es_m++;
										}else{
											$ed_es_f++;
										}
									}
								} else if($v_designation_count['project_id'] == 5){
									if($v_designation_count['pomis_designation_group'] == 22){
										if($v_designation_count['gender'] == 'Male'){ 
											$he_hv_m++;
											//$ff[] = $v_designation_count['emp_id']; 
										}else{
											$he_hv_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 23){
										if($v_designation_count['gender'] == 'Male'){ 
											$he_sa_m++;
										}else{
											$he_sa_f++;
										}
									}
								} else if($v_designation_count['project_id'] == 6){
									if($v_designation_count['pomis_designation_group'] == 21){
										if($v_designation_count['gender'] == 'Male'){ 
											$sc_of_m++;
										}else{
											$sc_of_f++;
										}
									} else if($v_designation_count['pomis_designation_group'] == 25){
										if($v_designation_count['gender'] == 'Male'){ 
											$sc_dm_m++;
										}else{
											$sc_dm_f++;
										}
									}
								} else if($v_designation_count['project_id'] == 7){
									if($v_designation_count['pomis_designation_group'] == 24){
										if($v_designation_count['gender'] == 'Male'){ 
											$ad_po_m++;
										}else{
											$ad_po_f++;
										}
									}
								} else if($v_designation_count['project_id'] == 8){
									if($v_designation_count['pomis_designation_group'] == 26){
										if($v_designation_count['gender'] == 'Male'){ 
											$vc_of_m++;
										}else{
											$vc_of_f++;
										}
									}else if($v_designation_count['pomis_designation_group'] == 29){
										if($v_designation_count['gender'] == 'Male'){ 
											$vc_ft_m++;
										}else{
											$vc_ft_f++;
										}
										//$teacher[] = $v_designation_count['emp_id'];
									}
								}
								
							 }
							 /* echo "<pre>";
						print_r($teacher); 
						echo "</pre>"; */ 
					?>
					
					
					
						<tr>
							<td rowspan="2" style="vertical-align:middle;">Microfinance Program</td>
							<td>Male</td>
							<td><center><?php echo $fo_m>0?$fo_m:'-';?></center></td>
							<td><center><?php echo $medo_m>0?$medo_m:'-'; ?></center></td>
							<td><center><?php echo $ba_m>0?$ba_m:'-'; ?></center></td>
							<td><center><?php echo $abm_m>0?$abm_m:'-'; ?></center></td>
							<td><center><?php echo $bm_m>0?$bm_m:'-'; ?></center></td>
							<td><center><?php echo $au_m>0?$au_m:'-'; ?></center></td>
							<td><center><?php echo $am_m>0?$am_m:'-'; ?></center></td>
							<td><center><?php echo $dm_m>0?$dm_m:'-'; ?></center></td>
							<td><center><?php echo $adm_m>0?$adm_m:'-'; ?></center></td>
							<td><center><?php echo $ot_m>0?$ot_m:'-'; ?></center></td>
							<td><center><?php   $sub_total_m = $fo_m+$medo_m+$ba_m+$abm_m+$bm_m+$au_m+$am_m+$dm_m+$adm_m+$ot_m; echo $sub_total_m>0?$sub_total_m:'-'; ?></center></td>
							<td><center><?php echo $designation_group_total['Male']>0?$designation_group_total['Male']:'-'; ?></center></td>
							<td><center><?php $subtotal_m = $sub_total_m + $designation_group_total['Male']; echo $subtotal_m>0?$subtotal_m:'-'; ?></center></td>
						</tr>
						<tr>
							<td>Female</td>
							<td><center><?php echo $fo_f>0?$fo_f:'-';?></center></td>
							<td><center><?php echo $medo_f>0?$medo_f:'-';?></center></td>
							<td><center><?php echo $ba_f>0?$ba_f:'-'; ?></center></td>
							<td><center><?php echo $abm_f>0?$abm_f:'-'; ?></center></td>
							<td><center><?php echo $bm_f>0?$bm_f:'-'; ?></center></td>
							<td><center><?php echo $au_f>0?$au_f:'-'; ?></center></td>
							<td><center><?php echo $am_f>0?$am_f:'-'; ?></center></td>
							<td><center><?php echo $dm_f>0?$dm_f:'-'; ?></center></td>
							<td><center><?php echo $adm_f>0?$adm_f:'-'; ?></center></td>
							<td><center><?php echo $ot_f>0?$ot_f:'-'; ?></center></td>
							<td><center><?php $sub_total_f = $fo_f+$medo_f+$ba_f+$abm_f+$bm_f+$au_f+$am_f+$dm_f+$adm_f+$ot_f; echo $sub_total_f>0?$sub_total_f:'-';  ?></center></td>
							<td><center><?php echo $designation_group_total['Female']>0?$designation_group_total['Female']:'-'; ?></center></td>
							<td><center><?php   $subtotal_f = $sub_total_f + $designation_group_total['Female']; echo $subtotal_f>0?$subtotal_f:'-'?></center></td>
						</tr>
						<tr>
							<td><center><b>Total</b></center></td>
							<td>-</td>
							<td><center><?php echo ($fo_m + $fo_f)>0? $fo_m + $fo_f:'-';?></center></td>
							<td><center><?php echo ($medo_m + $medo_f)>0? $medo_m + $medo_f:'-';?></center></td>
							<td><center><?php echo ($ba_m + $ba_f)>0? $ba_m + $ba_f:'-';?></center></td>
							<td><center><?php echo ($abm_m + $abm_f)>0? $abm_m + $abm_f:'-';?></center></td>
							<td><center><?php echo ($bm_m + $bm_f)>0? $bm_m + $bm_f:'-';?></center></td>
							<td><center><?php echo ($au_m + $au_f)>0? $au_m + $au_f:'-';?></center></td>
							<td><center><?php echo ($am_m + $am_f)>0? $am_m + $am_f:'-';?></center></td>
							<td><center><?php echo ($dm_m + $dm_f)>0? $dm_m + $dm_f:'-';?></center></td>
							<td><center><?php echo ($adm_m + $adm_f)>0? $adm_m + $adm_f :'-';?></center></td>
							<td><center><?php echo ($ot_m + $ot_f)>0? $ot_m + $ot_f :'-';?></center></td>
							<td><center><?php echo ($sub_total_m + $sub_total_f)>0?$sub_total_m + $sub_total_f:'-';?></center></td>
							<td><center><?php echo ($designation_group_total['Male'] + $designation_group_total['Female'])>0?$designation_group_total['Male'] + $designation_group_total['Female']:'-';?></center></td>
							<td><center><?php echo ($subtotal_m + $subtotal_f)>0?$subtotal_m + $subtotal_f:'-';?></center></td>
						</tr>
					</tbody>
				</table> 
				<table id="tblExport" class="table table-bordered" cellspacing="0">
					<thead>
						<tr style="background-color:lightgray;">
							<th colspan="2" style="width:10%;vertical-align:middle;">Name of Program</th>
							<th style="width:4%;vertical-align:middle;">Gender</th>
							<th style="width:6%;vertical-align:middle;">Teacher</th>
							<th style="width:6%;vertical-align:middle;">Education Supervisor</th>
							<th style="width:6%;vertical-align:middle;">Officer</th>
							<th style="width:6%;vertical-align:middle;">Health Volunteer</th>
							<th style="width:6%;vertical-align:middle;">Health Visitor</th>
							<th style="width:6%;vertical-align:middle;">SACMO</th>
							<th style="width:6%;vertical-align:middle;">Food Technologist</th>
							<th style="width:6%;vertical-align:middle;">Agricultural Officer</th>
							<th style="width:6%;vertical-align:middle;">Social Dev Officer</th>
							<th style="width:6%;vertical-align:middle;">Program Officer</th>
							<th style="width:6%;vertical-align:middle;">Program Co-Ordinator</th> 
							<th style="width:6%;vertical-align:middle;">DM</th> 
							<th style="width:6%;vertical-align:middle;">Total</th>
						</tr>
					</thead>
					<tbody>
					
						<tr > 
							<td style="vertical-align:middle;" id="micro_bold_bottom"  rowspan="4">Microfinance Program</td>
							<td style="vertical-align:middle;" rowspan="2">Value Chain</td>
							<td>Male</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $vc_ft_m>0?$vc_ft_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $vc_ft_m>0?$vc_ft_m:'-'; ?></center></td>
						</tr>
						<tr> 
							<td>Female</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $vc_ft_f>0?$vc_ft_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $vc_ft_f>0?$vc_ft_f:'-'; ?></center></td>
						</tr> 
						<tr>  
							<td style="vertical-align:middle;" id="micro_bold_bottom_j"  rowspan="2">SMAP (JICA)</td>
							<td>Male</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sm_ao_m>0?$sm_ao_m:'-';?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sm_ao_m>0?$sm_ao_m:'-'; ?></center></td>
						</tr>
						<tr class="micro_bold_bottom"> 
							<td  >Female</td>
							<td><center>-</center></td>
							<td> <center>-</center></td>
							<td><center>-</center></td>
							<td   ><center>-</center></td>
							<td   ><center>-</center></td>
							<td   ><center>-</center></td>
							<td   ><center>-</center></td>
							<td   ><center><?php echo $sm_ao_f>0?$sm_ao_f:'-';?></center></td>
							<td  ><center>-</center></td>
							<td><center>-</center></td>
							<td ><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sm_ao_f>0?$sm_ao_f:'-'; ?></center></td>
						</tr> 
						<tr>
							<td style="vertical-align:middle;" rowspan="10">Special Program</td>
							<td style="vertical-align:middle;" rowspan="2">Education</td>
							<td>Male</td>
							<td><center><?php echo $ed_te_m>0?$ed_te_m:'-'; ?></center></td>
							<td><center><?php echo $ed_es_m>0?$ed_es_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo ($ed_te_m+$ed_es_m)>0?$ed_te_m+$ed_es_m:'-'; ?></center></td>
						</tr>
						<tr>
							<td>Female</td>
							<td><center><?php echo $ed_te_f>0?$ed_te_f:'-'; ?></center></td>
							<td><center><?php echo $ed_es_f>0?$ed_es_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo ($ed_te_f+$ed_es_f)>0?$ed_te_f+$ed_es_f:'-'; ?></center></td>
						</tr>
						<tr>
							<td style="vertical-align:middle;" rowspan="2">Health</td>
							<td>Male</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $he_hv_m>0?$he_hv_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center><?php echo $he_sa_m>0?$he_sa_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo ($he_hv_m+$he_sa_m)>0?$he_hv_m+$he_sa_m:'-'; ?></center></td>
						</tr>
						<tr>
							<td>Female</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $he_hv_f>0?$he_hv_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center><?php echo $he_sa_f>0?$he_sa_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo ($he_hv_f+$he_sa_f)>0?$he_hv_f+$he_sa_f:'-'; ?></center></td>
						</tr>
						<tr>
							<td style="vertical-align:middle;" rowspan="2">Social Commodity</td>
							<td>Male</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sc_of_m>0?$sc_of_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sc_dm_m>0?$sc_dm_m:'-'; ?></center></td>
							<td><center><?php echo ($sc_of_m+$sc_dm_m)>0?$sc_of_m+$sc_dm_m:'-'; ?></center></td>
						</tr>
						<tr>
							<td>Female</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sc_of_f>0?$sc_of_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $sc_dm_f>0?$sc_dm_f:'-'; ?></center></td>
							<td><center><?php echo ($sc_of_f+$sc_dm_f)>0?$sc_of_f+$sc_dm_f:'-'; ?></center></td>
						</tr>
						<tr>
							<td style="vertical-align:middle;" rowspan="2">Adolescent</td>
							<td>Male</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $ad_po_m>0?$ad_po_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $ad_po_m>0?$ad_po_m:'-'; ?></center></td>
						</tr>
						<tr>
							<td>Female</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $ad_po_f>0?$ad_po_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $ad_po_f>0?$ad_po_f:'-'; ?></center></td>
						</tr> 
						 <tr>
							<td style="vertical-align:middle;" rowspan="2">ENRICH</td>
							<td>Male</td>
							<td><center><?php echo $enrich_m>0?$enrich_m:'-';?></center></td>
							<td><center><?php echo $es_enrich_m>0?$es_enrich_m:'-';?></center></td>
							<td><center><?php echo $vc_of_m>0?$vc_of_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center><?php echo $en_hv_m>0?$en_hv_m:'-';?></center></td>
							<td><center><?php echo $m_sacmo_m>0?$m_sacmo_m:'-';?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $en_of_m>0?$en_of_m:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center><?php echo $en_po_m>0?$en_po_m:'-';?></center></td>
							<td><center>-</center></td>
							<td><center><?php   $m_abc = $vc_of_m+$en_of_m+$enrich_m+$es_enrich_m+$m_sacmo_m+$en_po_m+$en_hv_m; echo $m_abc>0?$m_abc:'-' ?></center></td>
						</tr>
						<tr>
							<td>Female</td>
							<td><center><?php echo $enrich_f>0?$enrich_f:'-'; ?></center></td>
							<td><center><?php echo $es_enrich_f>0?$es_enrich_f:'-';?></center></td>
							<td><center><?php echo $vc_of_f>0?$vc_of_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center><?php echo $en_hv_f>0?$en_hv_f:'-';?></center></td>
							<td><center><?php echo $m_sacmo_f>0?$m_sacmo_f:'-';?></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo $en_of_f>0?$en_of_f:'-'; ?></center></td>
							<td><center>-</center></td>
							<td><center><?php echo $en_po_f>0?$en_po_f:'-';?></center></td>
							<td><center>-</center></td>
							<td><center><?php $abc= $vc_of_f+$en_of_f+ $enrich_f+ $es_enrich_f+ $m_sacmo_f+ $en_po_f+ $en_hv_f; echo $abc >0?$abc:'-'?></center></td>
						</tr> 
						<tr>
							<td><center><b>Total</b></center></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td><center><?php echo ($ed_te_m + $ed_te_f + $enrich_m+ $enrich_f)>0?$ed_te_m + $ed_te_f + $enrich_m+ $enrich_f:'-'; ?></center></td>
							<td><center><?php echo ($ed_es_m + $ed_es_f+ $es_enrich_f+ $es_enrich_m)>0?$ed_es_m + $ed_es_f+ $es_enrich_f+ $es_enrich_m:'-'; ?></center></td>
							<td><center><?php echo ($sc_of_m + $sc_of_f + $vc_of_m + $vc_of_f)>0?$sc_of_m + $sc_of_f + $vc_of_m + $vc_of_f:'-'; ?></center></td>
							<td><center><?php echo ($he_hv_m + $he_hv_f)>0?$he_hv_m + $he_hv_f:'-'; ?></center></td> 
							<td><center><?php echo ($en_hv_m+ $en_hv_f)>0?$en_hv_m+ $en_hv_f:'-'; ?></center></td>
							<td><center><?php echo ($he_sa_m + $he_sa_f + $m_sacmo_f+ $m_sacmo_m)>0?$he_sa_m + $he_sa_f + $m_sacmo_f+ $m_sacmo_m:'-'; ?></center></td>
							<td><center><?php echo ($vc_ft_m + $vc_ft_f)>0?$vc_ft_m + $vc_ft_f:'-'; ?></center></td>
							<td><center><?php echo ($sm_ao_m + $sm_ao_f)>0?$sm_ao_m + $sm_ao_f:'-'; ?> </center></td>
							<td><center><?php echo ($en_of_m + $en_of_f)>0?$en_of_m + $en_of_f:'-'; ?></center></td>
							<td><center><?php echo ($ad_po_m + $ad_po_f)>0?$ad_po_m + $ad_po_f:'-'; ?></center></td>
							<td><center><?php echo ($en_po_m + $en_po_f)>0?$en_po_m + $en_po_f:'-'; ?></center></td>
							<td><center><?php echo ($sc_dm_m + $sc_dm_f)>0?$sc_dm_m + $sc_dm_f:'-'; ?></center></td>
							<td><center><?php echo $ed_te_m+$ed_te_f+$ed_es_m+$ed_es_f+$sc_of_m+$sc_of_f+$vc_of_m+$vc_of_f+$he_hv_m+$he_hv_f+$he_sa_m+$he_sa_f+$ad_po_m + $ad_po_f+$sc_dm_m+$sc_dm_f+$en_of_m+$en_of_f+$en_po_m+ $en_po_f+ $en_hv_m+ $en_hv_f+$enrich_m+ $enrich_f+$es_enrich_f+ $es_enrich_m+ $m_sacmo_f+ $m_sacmo_m+$vc_ft_m + $vc_ft_f+ $sm_ao_m + $sm_ao_f ;   ?></center></td>
						</tr>
						<tr>
							<td colspan="15"><center><b>Grand Total</b></center></td> 
							<td><center><?php echo $ed_te_m+$ed_te_f+$ed_es_m+$ed_es_f+$sc_of_m+$sc_of_f+$vc_of_m+$vc_of_f+$he_hv_m+$he_hv_f+$he_sa_m+$he_sa_f+$ad_po_m + $ad_po_f+$sc_dm_m+$sc_dm_f+$en_of_m+$en_of_f+$en_po_m+ $en_po_f+ $en_hv_m+ $en_hv_f+$enrich_m+ $enrich_f+$es_enrich_f+ $es_enrich_m+ $m_sacmo_f+ $m_sacmo_m+$vc_ft_m + $vc_ft_f+ $sm_ao_m + $sm_ao_f + $subtotal_m + $subtotal_f;   ?></center>
							</td>
						</tr>
					<?php } ?>
					</tbody> 
				</table>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_default_branch">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Branch</h4>
              </div>
              <div class="modal-body">
				<div class="col-md-12 table-responsive">
									<table width="100%" border="1">
										<thead>
											<tr>
												<th>Sl No.</th>
												<th>Branch Name</th> 
											</tr>
											
										</thead>
										 <tbody id="add_table">

                                    </tbody>
									</table>
								</div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                 
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
</section>
<script>
function get_branch_name()
		{
			 var date_within = $('#date_within').val(); 
			// alert(date_within);
			 
			 $.ajax({
                type: "GET",
				dataType: "JSON",
                url: "<?php echo e(URL::to('pomis_getno_branch')); ?>"+"/"+ date_within,
                success: function(data) {
					console.log(data);
					 $("#add_table").empty();
					  var t_row = '';
					  var j=1;
					for (var x in data["data"]) {
                             t_row += "<tr><td>" + j++ +
                                "</td><td>" + data["data"][x]["branch_name"] +
                                "</td></tr>"; 
					}
					 $('#add_table').append(t_row);
					console.log(data);
                }
            }) 
			
			$('#modal_default_branch').modal('show'); // show bootstrap modal
			$('.modal-title').text('Branch'); // Set Title to Bootstrap modal title 
		}
$(document).ready(function() {
	$('#date_within').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script>
    function printDiv(divID) {
        //Get the HTML of div
		
		$("#hide_pending_branch").hide();
		
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><style>"  + '.table-bordered th, .table-bordered td {' +
        'border:1px solid black !important;' + 
        '}' + '#tblExport th, #tblExport td {' +
        'text-align: center !important;' + 
        '}'+  '#micro_bold_bottom {' +
        'border-bottom: 2px solid black !important;text-align:center;' + 
        '}'+  '#micro_bold_bottom_j {' +
        'border-bottom: 2px solid black !important;text-align:center;' + 
        '}'+ '.micro_bold_bottom {' +
        'border-bottom: 2px solid black !important;text-align:center;' + 
        '}'+ "</style><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
		/* window.close(
		
		alert('ok');
		); */ 
		setTimeout(function () { $("#hide_pending_branch").show(); }, 1);
    }
	 
	
</script>

<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupService_Length_Reports").addClass('active');
			$("#POMIS-3").addClass('active');
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>