
	<div id="printme">
		 
		<div align="center">
			<table align="center">
				<tr>
					<td align="center" style="font-size:18px; font-weight:bold;">Centre for Development Innovation and Practices (CDIP)</td>
				</tr>
				<tr>
					<td align="center" style="font-size:13px; font-weight:bold;">CDIP Bhaban, House No#17, Road No#13, PC Culture Housing Society, Shekhertek, Adabor, Dhaka-1207</td>
				</tr>
				<tr>
					<td align="center" style="font-size:16px; font-weight:bold;"> Staff List</td>
				</tr>       
			</table>
			<hr>    
			
			<table width="98%" style="font-size:14px; font-weight:bold;">
				<tr>
                    <td>Date From : <?php echo $date_from; ?>  to   <?php echo $date_to; ?></td>
					<td align="right">Print Date: &nbsp;  <?php echo date('d-M-Y'); ?></td>
				</tr> 
			</table>
			
		</div>

		<div align="center">
			<?php $total_record = 0; foreach($groups as $v_designation) { ?>

			<table width="98%" cellspacing="0" cellpadding="0" border="1">
				<?php $sl = 1; foreach ($results as $v_report) { ?>
				<?php if($v_designation->id == $v_report->designation_code) {  ?>
				<?php if($sl==1) { ?>
			    <thead>			
					<tr>
						  <th scope="col" width="3%">Sl.</th>
						  <th scope="col" width="5%">ID No</th>
						  <th scope="col" width="10%">Staff Name</th>
						  <th scope="col" width="8%">Fathers Name</th>
						  <th scope="col" width="10%">Designation</th>
						  <th scope="col" width="10%">Joining Date (Org)</th>
						  <th scope="col" width="10%">Letter Date</th>
						  <th scope="col" width="15%">
							   <table align="center" border="1" width="100%" cellspacing="0" cellpadding="0">
									<tr>
										<td colspan="3">Present Work Station</td>
									</tr>
									<tr>
										<td width="50%">HO/BO</td>
										<td width="50%">Joining Date</td>
									</tr>
								</table>
						  </th>
						  <th scope="col" width="15%">Permant Address</th>
					</tr>
					<?php } ?>
				</thead>
				
				<tbody>
					<tr>
						  <td align="center"><?php echo $sl++; ?></td>
						  <td align="center"><?php echo $v_report->emp_id; ?></td>
						  <td align="center"><?php echo $v_report->emp_name_eng; ?></td>
						  <td align="center"><?php echo $v_report->father_name; ?></td>
						  <td align="center"><?php echo $v_report->designation_name; ?></td>
						  <td align="center"><?php echo $v_report->org_join_date; ?></td>
						  <td align="center"><?php echo $v_report->letter_date; ?></td>
						  <td align="center">
							  <?php echo $v_report->branch_name; ?>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <?php echo $v_report->br_joined_date; ?>
                          </td>
						  <td align="center">
						 <?php echo $v_report->permanent_add; ?>
                          </td>
					</tr>					
			    </tbody>
				<?php } ?>  
				<?php } ?>
				
			<!-- START COUNT AND LABEL -->
			<?php
			$total = $sl-1;
			if($total>0){ ?>
			<br>
			<b><span style="color:blue;float:left;"> &nbsp;&nbsp;&nbsp; Designation : <?php echo $v_designation->designation_name; ?> </span><span style="color:red;float:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Total = <?php echo $total;?>) </span> <span style="color:#494847; float:right;">Total Records: <?php echo $total_record +=$total;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b>		
			<?php } ?>
			<!-- END COUNT AND LABEL -->
				
			</table>
			<?php } ?>
			<br>
			<center><strong>END</strong></center>
		</div>
		

	</div>  
	
        
