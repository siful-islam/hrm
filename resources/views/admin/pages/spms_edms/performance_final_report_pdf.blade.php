<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
body {
	font-family: 'Nikosh', sans-serif;
}

</style>
<body>
<div id="content">
	<div id="printme">
	<div class="box-header with-border" style="text-align:justfy;text-justify: inter-word;text-align:center;">					 
		<table width="90%" align="center">
			<tr>
				<td width="10%" align="left" rowspan="4"><img src="{{asset('public/cdip.png')}}" style="float:left;margin-top:0%;" width="70" ></td>
				<td align="center" width="90%" style="font-size:20px;">সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস (সিদীপ) </td>
			</tr>
			<tr>
				<td width="90%" align="center" style="font-size:18px;">Centre for Development Innovation and Practices (CDIP)</td>
			</tr>
			<tr>
				<td align="center" style="font-size:13px;">সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি, শেখেরটেক, আদাবর, ঢাকা</td>
			</tr>
			<tr>
				<td align="center" style="font-size:12px;">web:www.cdipbd.org, Email:info@cdipbd.org, Phone: 02-48118633, 02-48118634</td>
			</tr>
		</table>
		<hr>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="container-fluid">
				<div style="text-align:center;">
					<h4 style="margin-top:4px;"><b>কর্মদক্ষতা মূল্যায়ন ফরম: {{$designation_type->desig_type_name_short}}</b></h4>
					<h5 style="margin-top:4px;"><u><b>মূল্যায়নকাল: <?php echo '01-07-2020';?> হতে  <?php echo '30-06-2021';?></b></u></h5>
				</div>				
				<div class="col-md-10">
					<p>{{$designation_type->desig_type_name_level}}: {{$emp_result->emp_name}}</p>
					<p>আইডি নং: {{$emp_result->emp_id}}</p>
					<p><?php if($emp_result->desig_type_id ==5 || $emp_result->desig_type_id ==6) { echo 'অবস্থানকৃত';} ?> ব্রাঞ্চ: {{$emp_result->branch_name}}</p>  
					<p><?php if($emp_result->desig_type_id ==6) { echo 'ডিসট্রিক্ট';} else {echo'এরিয়া';} ?> : <?php if($emp_result->desig_type_id ==6) { echo $emp_result->zone_name;} else {echo $emp_result->area_name;} ?></p>
					<p>বর্তমান <?php if($emp_result->desig_type_id ==5) { echo 'এরিয়ায়';} elseif($emp_result->desig_type_id ==6) { echo 'ডিসট্রিক্ট এ';} else {echo 'ব্রাঞ্চে';} ?> যোগদানের তারিখ: {{ date('d-m-Y', strtotime($emp_result->br_join_date))}}</p>
					<p>সর্বশেষ শিক্ষাগত যোগ্যতা: {{$emp_result->education}}</p>
				</div>
			</div>
		</div>
	</div>
	<?php if($desig_type_id == 1 || $desig_type_id == 3) { 
			$ka_no = 60; $kha_no = 22; $ga_no = 12; $gha_no = 6;
			$eval_type_ka = $eval_type_ka;
			$eval_type_kha = $eval_type_kha;
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
		} else if ($desig_type_id == 2) { 
			$ka_no = 0; $kha_no = 0; $ga_no = 92; $gha_no = 8;
			$eval_type_ka =  'ক নং ক্রমিক';
			$eval_type_kha = 'খ নং ক্রমিক';
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
		} else if ($desig_type_id == 7) { 
			$ka_no = 30; $kha_no = 10; $ga_no = 52; $gha_no = 8;
			$eval_type_ka = $eval_type_ka;
			$eval_type_kha = $eval_type_kha;
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
		} else if ($desig_type_id == 4 || $desig_type_id == 10) { 
			$ka_no = 48; $kha_no = 28; $ga_no = 18; $gha_no = 6;
			$eval_type_ka = $eval_type_ka;
			$eval_type_kha = $eval_type_kha;
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
		} else if ($desig_type_id == 5 || $desig_type_id == 6) { 
			$ka_no = 40; $kha_no = 28; $ga_no = 10; $gha_no = 16; $umo_no = 6;
			$eval_type_ka = $eval_type_ka;
			$eval_type_kha = $eval_type_kha;
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
			$eval_type_umo = $eval_type_umo;
		}  else if ($desig_type_id == 8) { 
			$ka_no = 60; $kha_no = 30; $ga_no = 10; $gha_no = '';
			$eval_type_ka = $eval_type_ka;
			$eval_type_kha = $eval_type_kha;
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
		}  else if ($desig_type_id == 9) { 
			$ka_no = 60; $kha_no = 30; $ga_no = 10; $gha_no = '';
			$eval_type_ka = $eval_type_ka;
			$eval_type_kha = $eval_type_kha;
			$eval_type_ga = $eval_type_ga;
			$eval_type_gha = $eval_type_gha;
		}
	?>
	<br/>
	<div class="row">
		<div class="col-md-12">
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" style="font-size:12px;">
						<thead>
							<tr>
								<th><center>বিবরণ</center></th>
								<th><center>ধার্য্যকৃত নাম্বার</center></th>
								<th><center>প্রাপ্ত গড় নম্বর</center></th>
								<th colspan="2"><center>কর্মীর সার্বিক মূল্যায়ন</center></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><center><?php echo $eval_type_ka; ?></center></td>
								<td><center><?php echo $ka_no; ?></center></td>
								<td><?php echo $final_report->ka_marks; ?></td>
								<td><center>কর্মীর মান</center></td>
								<td><center></center></td>
							</tr>
							<tr>
								<td><center><?php echo $eval_type_kha; ?></center></td>
								<td><center><?php echo $kha_no; ?></center></td>
								<td><?php echo $final_report->kha_marks; ?></td>
								<td><center>উত্তম</center></td>								
								<td>
									<span style="margin-left:50px;padding-right:52px;">৮৫-তদুর্ধ্ব </span>
									<?php if ($final_report->total_marks >= 85) { ?>
									<input type="checkbox" checked disabled="disabled"/>
									<?php } else { ?>
									<input type="checkbox"/>
									<?php } ?>										
								</td>								
							</tr>
							<tr>
								<td><center><?php echo $eval_type_ga; ?></center></td>
								<td><center><?php echo $ga_no; ?></center></td>
								<td><?php echo $final_report->ga_marks; ?></td>
								<td><center>খুব ভাল</center></td>
								<td>
									<span style="margin-left:50px;padding-right:70px;">৭১-৮৪ </span>
									<?php if ($final_report->total_marks >= 71 && $final_report->total_marks <=84) { ?>
									<input type="checkbox" checked disabled="disabled"/>
									<?php } else { ?>
									<input type="checkbox"/>
									<?php } ?>										
								</td>								
							</tr>
							<tr>
								<td><?php if (!($desig_type_id == 8 || $desig_type_id == 9)) { ?><center><?php echo $eval_type_gha; ?><?php if(!(($desig_type_id == 5) || ($desig_type_id == 6))) echo 'লঘুদন্ডজনিত সমস্যার মূল্যায়ন সূচকসমূহ:'; ?></center><?php } ?></td>
								<td><center><?php echo $gha_no; ?></center></td>
								<td><?php if (!($desig_type_id == 8 || $desig_type_id == 9)) { ?><?php echo $final_report->gha_marks; ?><?php } ?></td>
								<td><center>ভাল</center></td>
								<td>
									<span style="margin-left:50px;padding-right:70px;">৫০-৭০</span> 
									<?php if ($final_report->total_marks >= 50 && $final_report->total_marks <=70) { ?>
									<input type="checkbox" checked disabled="disabled"/>
									<?php } else { ?>
									<input type="checkbox"/>
									<?php } ?>										
								</td>								
							</tr>
							<tr>
								<td><?php if (!($desig_type_id == 8 || $desig_type_id == 9)) { ?><center><?php if ($desig_type_id == 5 || $desig_type_id == 6) { echo $eval_type_umo.' লঘুদন্ডজনিত সমস্যার মূল্যায়ন সূচকসমূহ:'; } else { echo 'দন্ড নম্বর (প্রযোজ্য ক্ষেত্রে)'; }?></center><?php } ?></td>
								<td><?php if (!($desig_type_id == 8 || $desig_type_id == 9)) { ?><center><?php if ($desig_type_id == 5 || $desig_type_id == 6) { echo $umo_no; } else if ($desig_type_id == 4) { echo 'সর্বোচ্চ (-12)'; } else if ($desig_type_id == 3) { echo 'সর্বোচ্চ (-05)'; } else { echo 'সর্বোচ্চ (-10)'; }?></center><?php } ?></td>
								<td><?php if (!($desig_type_id == 8 || $desig_type_id == 9)) { ?><?php if ($desig_type_id == 5 || $desig_type_id == 6) { echo $final_report->umo_marks; } else { echo '(-)'; }?><?php } ?></td>
								<td><center>ভাল নয়</center></td>
								<td>
									<span style="margin-left:50px;padding-right:79px;">০-৪৯</span>  
									<?php if ($final_report->total_marks <= 49) { ?>
									<input type="checkbox" checked disabled="disabled"/>
									<?php } else { ?>
									<input type="checkbox"/>
									<?php } ?>										
								</td>
							</tr>
							<tr>
								<td><center>সর্বমোট</center></td>
								<td><center>100</center></td>
								<td><b><?php echo $final_report->total_marks; ?></b></td>							
								<td colspan="2"></td>							
							</tr>														
						</tbody>	
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
	
</div>
</body>
</html>