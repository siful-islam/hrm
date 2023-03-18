<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manuals and Circulars</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>

<div class="container">
  <br>
  <center><h2 style="color:blue">Manual and Circulars</h2></center>
  </hr>
  <div class="row">
    <div class="table-responsive pt-8">
          
         
			<fieldset>
				<legend>Manual : </legend>
			
					<table class="table table-bordered table-striped">
					  <thead>
						<tr class="active-row">
							<th>CDIP Manual</th>
							<td> <a target="_blank" href="http://hrm.microfineye.com/public/CDIP_Manual.pdf"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /> View</i></a></td>
						</tr>
					  </thead>
					  <tbody>
						<tr class="active-row">
							<th>Finance Manual</th>
							<td> <a target="_blank" href="http://hrm.microfineye.com/public/FinanceMannual.pdf"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /> View</i></a></td>
						</tr>
					  </tbody>
					</table>
			</fieldset>
			<hr>
			<fieldset>
				<legend>Circulars : </legend>
					<table  class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="width:10%">SL No</th> 
								<th style="width:30%;text-align:center;">Title</th>
								<th style="width:30%;text-align:center;">Description </th>
								<th style="width:10%">Date</th> 
								<th style="width:20%">Download</th>  
							</tr>
						</thead>
						<tbody>
							<?php 
							$j=1;
							foreach($office_order_file as $order_file){ ?>
							<tr>
								<td><?php echo  $j++;?></td>
								<td style="text-align:center;"><?php echo  $order_file->title;?></td>
								<td style="text-align:center;"><?php echo  $order_file->comments;?></td>
								<td><?php echo  date("d-m-Y",strtotime($order_file->order_date));?></td> 
								<td>
								<?php if(!empty($order_file->file_name)){?>
								<a href="<?php echo e(asset('storage/office_order/'.$order_file->file_name)); ?>" target="_blank"><img src="<?php echo e(asset('storage/office_order/pdf.png')); ?>" width="40" style="height:35px;" /></a> 
								<?php } ?>
								  </td> 
							</tr> 
							<?php } ?>
						</tbody>    
					</table>
			</fieldset>
		
    </div>
  </div>
</div>

</body>
</html>

<!--FinanceMannual.pdf-->