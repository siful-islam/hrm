<link rel="stylesheet" href="<?php echo e(asset('public/css/bootstrap.min.css')); ?>">
<style>
body {
	font-family: 'nikosh', sans-serif; 
	-webkit-print-color-adjust: exact;
	color-adjust: exact;
	font-size:16px;
} 
</style> 

	<!-- Main content -->
	<section class="content">
		<div class="box-header with-border" style="text-align:justfy;text-justify: inter-word;text-align:center;">					 
			<table width="90%" align="center">
				<tr>
					<td width="10%" align="left" rowspan="4"><img src="<?php echo e(asset('public/cdip.png')); ?>" style="float:left;margin-top:0%;" width="70" ></td>
					<td align="center" width="90%" style="font-size:26px;">সেন্টার ফর ডেভেলপমেন্ট     ইনোভেশন এন্ড প্র্যাকটিসেস (সিদীপ) </td>
				</tr>
				<tr>
					<td width="90%" align="center" style="font-size:17px;">Centre for Development Innovation and Practices (CDIP)</td>
				</tr>
				<tr>
					<td align="center">সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি, শেখেরটেক, আদাবর, ঢাকা</td>
				</tr>
				<tr>
					<td align="center" style="font-size:12px;">web:www.cdipbd.org, Email:info@cdipbd.org, Phone:02-48118633,02-48118634</td>
				</tr>
			</table>
			<table width="100%" border="1" align="center">
			<tr>
				<td></td>
			</tr>
			</table>
		</div>	


		 জুলাই ০১ , <?php echo $year_bangla; ?><br><br>
		<?php echo $emp_name_ban; ?><br>
		আইডি নং - <?php echo $id_bangla; ?> <br>
		<?php echo $designation_bangla; ?> <br>
		
		
		
		
		<?php 
		
		//$zonal_designation = array();
		//$area_designation = array();


		if($designation_code == 211 || $designation_code == 209 || $designation_code == 244 || $designation_code == 253 || $designation_code == 255) { // Zonal Manager hole ?>
		
		<?php if($emp_id == 146){ echo $br_name_bangla.' '.' ব্রাঞ্চ ';  } else { echo $zone_name_bn; } ?>। 
		
		<?php } elseif($designation_code == 122 || $designation_code == 212 || $designation_code == 246) { // Area Manager hole  ?>
		
		<?php echo $area_name_bn; ?>। 
		
		<?php } else { ?>
		
		<?php echo $br_name_bangla; if($br_code != 9999) { echo ' ব্রাঞ্চ '; }?>। 
		
		<?php } ?>
		
		
		
		<br><br>
		
		<strong>বিষয়: বার্ষিক ইনক্রিমেন্ট।</strong>
		<br><br>	
		জনাব,<br>
		আপনি জেনে আনন্দিত হবেন যে, জুলাই ০১ , <?php echo $year_bangla; ?> হতে আপনাকে <strong> <?php echo $incre_bn ?> </strong> টি বার্ষিক ইনক্রিমেন্ট প্রদান করা হলো। উল্লিখিত  তারিখ থেকে আপনার বেতন ভাতা হবে নিম্নরূপ: <br><br>
		
		<span style="font-weight: 900;"> </span>  বর্তমান গ্রেড:  <?php echo $grade_name_ban; ?>,  মোট প্রাপ্ত ইনক্রিমেন্ট সংখ্যা:  <?php echo $grade_step_ban; ?>
		
		<br>
		<center>
			<table width="100%" border="1" style="font-size:14px;"> 
				<tr>
					<td align="center" rowspan="2"> মূল বেতন </td>  
					<?php 
					$others_allowance_name = array();
					$others_allowance_value = array();
					foreach($plus_items as $plus_item) {  ?>
					<?php if($plus_item->item_type == 0) { ?>
					<td align="center" rowspan="2"><?php if($plus_item->type == 1) {  $persentage = $plus_item->percentage_bn;  $suffix = '('.$persentage.'%)'; } else {$suffix = ''; } echo $plus_item->items_name_bn .'<br>'. $suffix; ?></td>
					<?php } else { ?>
					<?php $others_allowance_name[] = $plus_item->items_name_bn; ?>					
					<?php } } ?>
					<td align="center" rowspan="2"> মোট প্রাপ্য বেতন </td>
					<td align="center" colspan="<?php echo count($minus_items);?>"> কর্তনসমূহ </td>
					<td align="center" rowspan="2"> মোট কর্তন </td>
					<td align="center" rowspan="2"> নীট প্রাপ্য বেতন </td>
				</tr>
				<tr>
					<?php foreach($minus_items as $minus_item) {  ?>
					<td align="center"><?php if($minus_item->type == 1) { $persentage = $minus_item->percentage_bn; $suffix = '('.$persentage.'%)'; } else {$suffix = ''; } echo $minus_item->items_name_bn.'<br>'. $suffix; ?></td>
					<?php } ?>
				</tr>
				<tr>
					<td align="center"><?php echo $basic_bangla;?></td>
					<?php foreach($plus_item_amount_bn as $plus_amount) {  ?>
					<td align="center"><?php echo $plus_amount;?></td>
					<?php } ?>
					<td align="center"><?php echo $payable_bangla;?></td>
					<?php foreach($minus_item_amount_bn as $minus_amount) {  ?>
					<td align="center"><?php echo $minus_amount;?></td>
					<?php } ?>
					<td align="center"><?php echo $total_minus_bangla;?></td>
					<td align="center"><?php echo $net_payable_bangla;?></td>
				</tr>
			</table>
			<br>
			<?php if($br_code != 9999) { $extra_item_count = sizeof($others_allowance_name); ?>
			<?php if($extra_item_count >0) { ?>
			উল্লিখিত বেতন-ভাতার বাইরে প্রতিমাসে  নিম্নলিখিত  ভাতাসমূহ প্রাপ্য হবেন:
			<?php } ?>
			<table width="80%" border="1" style="font-size:15px;"> 
			
				<?php $i = 0; foreach($others_allowance_name as $others_name) { ?>
				<tr>
					<td align="left">&nbsp;<?php echo $others_name; ?>&nbsp;</td>				
					<td align="right">&nbsp;<?php echo $secondary_plus_amount[$i]; ?> /-  টাকা &nbsp;&nbsp;</td>				
				</tr>
				<?php $i++; } ?>  
				
				<?php if($ho_bo ==1) { ?>
				
				<?php if($emp_id == 1131) { $taka = '৩,০০০'; } elseif($emp_id == 2031) {$taka = '২,০০০';}  
					else{
						if($designation_code == 24 || $designation_code == 13 || $designation_code == 215 || $designation_code == 228)
						{
							$taka = ' ২,০০০'; 
						}
						else
						{
							$taka = ' ১,০০০'; 
						}
					} ?>

					<?php 
					//off cilo
					//$hobe_na = array(256,209,211,122,212,75,147,227,226,207,213,210,255,24);
					//$is_in  = in_array($designation_code, $hobe_na);
					//if($is_in == '') { ?>
					<!--<tr>
						<td align="left">&nbsp;জ্বালানী ভাতা (মোটর সাইকেল ব্যবহার সাপেক্ষে, নীতিমালা মোতাবেক) </td>	 			
						<td align="right">&nbsp;<?php //echo $taka; ?> /-  টাকা &nbsp;&nbsp;</td>						
					</tr>-->
					<?php //} ?>
				
				<?php } ?>
		
				<?php 
				//Area Manager
				if($designation_code == 122 || $designation_code == 212) { ?>
				<tr>
					<td align="left">&nbsp;প্রতি ব্রাঞ্চের জন্য জ্বালানী ভাতা (মোটর সাইকেল ব্যবহার সাপেক্ষে, নীতিমালা মোতাবেক) </td>	 			
					<td align="right">&nbsp;  ৫০০ /-  টাকা &nbsp;&nbsp;</td>			
				</tr>
				<?php } ?>	
			</table>
			
			<?php } ?>
		</center>
		<br>
		
		<table>
		
			<?php if($ho_bo ==1) { ?>
			
				<?php if($designation_code == 255 || $designation_code == 256 || $designation_code == 209 || $designation_code == 211 || $designation_code == 207|| $designation_code == 210|| $designation_code == 213|| $designation_code == 226|| $designation_code == 227|| $designation_code == 228 || $designation_code == 186 || $designation_code == 241 || $designation_code == 54) { ?>
				<tr>
					<td align="left" valign="top">* </td>
					<td> অফিসের কাজে যাতায়াতের জন্য সংস্থা কর্তক নির্ধারিত ও প্রযোজ্য ক্ষেত্রে প্রকৃত যাতায়াত বিল প্রাপ্য হবেন।</td>
				</tr>
				<?php } ?>
				
				<?php if($designation_code != 75) { // Office Assistant er jonno hobe na. ?>
				<tr>
					<td align="left" valign="top">* </td>
					<td> অফিসের আবাসিকে অবস্থান করলে মূল বেতনের ৫% বাড়ি ভাড়া কর্তন প্রযোজ্য হবে।</td>
				</tr>
				<?php } } ?>
				<!--<tr>
					<td align="left" valign="top">*</td>
					<td> পি.এফ বাবদ মূল বেতনের ২০% টাকা কর্তনের সাথে সংস্থা মূল বেতনের ১০% টাকা আপনার  পি.এফ ফান্ডে জমা করবে। </td>
				</tr>-->
		</table>
		
		
		<!--
		<ul>
			<?php //if($ho_bo ==1) { ?>
				<?php //if($designation_code == 209 || $designation_code == 211 || $designation_code == 207|| $designation_code == 210|| $designation_code == 213|| $designation_code == 226|| $designation_code == 227|| $designation_code == 228) { ?>
			<li> অফিসের কাজে যাতায়াতের জন্য সংস্থা কর্তক নির্ধারিত ও প্রযোজ্য ক্ষেত্রে প্রকৃত যাতায়াত বিল প্রাপ্য হবেন।</li>
				<?php //} ?>
			<?php //if($designation_code != 75) { // Office Assistant er jonno hobe na. ?>
			<li>অফিসের আবাসিকে অবস্থান করলে মূল বেতনের ৫% বাড়ি ভাড়া কর্তন প্রযোজ্য হবে।</li>
			<?php// } }  ?>
			<li>পি.এফ বাবদ মূল বেতনের ২০% টাকা কর্তনের সাথে সংস্থা মূল বেতনের ১০% টাকা আপনার  পি.এফ ফান্ডে জমা করবে। </li>
		</ul> 
		
		-->
		<br>
		<span><b>ধন্যবাদান্তে, </b> <span>
		<br>
		<?php 
		$designation_rank = array(99,47,145,167,28,144,194,225,250,263,257);
		
		if(in_array($designation_code, $designation_rank)) { ?>
		
		<table>
			<tr>
				<td><img src="<?php echo e(asset('public/ed_mifta_sir.jpg')); ?>" height="80" width="80" style="float:left;margin-top:0%;"></td>
			</tr>
			<tr>
				<td><b>মিফতা নাঈম হুদা </b></td>
			</tr>
			<tr>
				<td> নির্বাহী পরিচালক </td>
			</tr>
		</table>

		<?php } else { ?>
		
		<table>
			<tr>
				<td><img src="<?php echo e(asset('public/aahad_dfo.jpg')); ?>" height="50" style="float:left;margin-top:0%;"></td>
			</tr>
			<tr>
				<td><b> এস.আবদুল আহাদ, এফসিএমএ </b></td>
			</tr>
			<tr>
				<td> পরিচালক (ফাইন্যান্স এন্ড অপারেশন্স)  </td> 
			</tr>
		</table>
		
		<?php } ?>
		
		<br>
		অনুলিপি:
		<br>
		
		<?php if($br_code != 9999) { ?>
			<?php if($designation_code == 11 || $designation_code == 192 ||$designation_code == 16 ||$designation_code == 217 ||$designation_code == 170 ||$designation_code == 75 || $designation_code == 219 || $designation_code == 130 ||$designation_code == 177 || $designation_code == 216)  { ?>
					<ul style="list-style: none;">
						<li>১। সংশ্লিষ্ট এরিয়া ম্যানেজার:  উক্ত কর্মী অন্যত্র বদলি হয়ে থাকলে তার বদলিকৃত কর্মস্থলে চিঠিটি প্রেরণের ব্যবস্থা নিবেন।</li>
						<li>২। সংশ্লিষ্ট ব্রাঞ্চ ম্যানেজার<?php //echo $br_name_bangla; ?>: উপরোল্লিখিত ছক ও নির্দেশনা মোতাবেক বেতন-ভাতা প্রদানের  ব্যবস্থা নিবেন।</li>
						<li>৩। ব্যক্তিগত ফাইল। </li>
					</ul>
			<?php } elseif($designation_code == 265 || $designation_code == 215 || $designation_code == 13 || $designation_code == 15 || $designation_code == 19 ||$designation_code == 23 ||$designation_code == 24 ||$designation_code == 37||$designation_code == 228 ) { ?>
					<ul style="list-style: none;">
						<li>১। সংশ্লিষ্ট এরিয়া ম্যানেজার।</li>
						<li>২। সংশ্লিষ্ট ব্রাঞ্চ ম্যানেজার<?php //echo $br_name_bangla; ?>: উপরোল্লিখিত ছক ও নির্দেশনা মোতাবেক বেতন-ভাতা প্রদানের  ব্যবস্থা নিবেন।</li>   
						<li>৩। ব্যক্তিগত ফাইল। </li>
					</ul>
			<?php } else { ?>
				<ul style="list-style: none;">
					<li>১।  অর্থ ও হিসাব বিভাগ। </li>
					<li>২। ব্যক্তিগত ফাইল।</li>
				</ul>
			<?php } ?>
		<?php } elseif($br_code == 9999) { ?>
		<ul style="list-style: none;">
			<li>১। অর্থ ও হিসাব বিভাগ। </li> 
			<li>২। ব্যক্তিগত ফাইল।</li>
		</ul>
		<?php } ?>

	<?php if($designation_code != 24) { ?>		
		<br><br>
	<?php } ?> 
		<table width="100%" border="0" align="center">
			<tr>
				<td align="left" style="font-size:8px;">This Letter Generated by CDIP Human Resource Management Software</td>
			</tr>
		</table>
	</section> 
