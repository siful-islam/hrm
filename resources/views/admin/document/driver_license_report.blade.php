@extends('admin.admin_master')
@section('title', 'Driving License')
@section('main_content')
<style>
.content-header {
    padding-top: 5px;
}
.content-header > .breadcrumb {
	padding: 2px 7px;
}
.table-bordered {
    border: 1px solid #757070;
}
.table > thead > tr > th {
    border: 1px solid #757070;
	font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
	font-weight: bold;
	text-align: left; 
	padding: 2px;
}
.table > tbody > tr > td {
    border: 1px solid #757070;
	padding: 4px;
	font: 12px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
}
#header {visibility: hidden;}

#footer{visibility: hidden;}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>{{$Heading}}</small></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Driving License Report</li>
	</ol>
</section>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="{{URL::to('/drivier_license_search_report')}}" method="post">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="area_code">Area Name :</label>
							<select class="form-control" id="area_code" name="area_code" required>						
								<option value="" hidden>-Select-</option>
								<option value="all" >ALL</option>
								@foreach ($areas as $v_area)
									<option value="{{$v_area->area_code}}">{{$v_area->area_name}}</option>
								@endforeach
							</select> 
							<label for="br_code">Branch Name :</label>
							<select class="form-control" id="br_code" name="br_code">
								@if (!empty($all_branch))
									@foreach ($all_branch as $v_branch)
										<option value="{{$v_branch->br_code}}">{{$v_branch->branch_name}}</option>
									@endforeach 
								@endif 
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
	@if (!empty($all_branch))
	<div class="row">
		<div id="printme">
		<div id="header"><?php echo date("d/m/Y");?></div>
			<div class="col-md-12">
				<p align="center"><b><font size="4">Centre for Development Innovation and Practices(CDIP)</font></b><br/>		
				<b><font size="4">Driving License Report</font></b></p>		
			</div> 
			<?php  
				$total_branch = array_count_values($tot_branch_in_area);
					$tot_row = 0;
			
			if($area_code == 'all'){ 
			$total_area = array_count_values($total_in_area);
			
			?>
				<div class="col-md-12">
					 
						<table class="table table-bordered" cellspacing="0">
							<thead>
								<tr> 
									<th style="width:5%;">SL NO</th>
									<th style="width:8%;">Area Name</th>
									<th style="width:8%;">Branch Name</th>
									<th style="width:5%;">EM No.</th>
									<th style="width:12%;">Employee Name</th> 
									<th style="width:5%;">Type Name</th> 
									<th style="width:5%;">ID No</th>
									<th style="width:15%;">Designation</th> 
									<th style="width:8%;">License SL No.</th>
									<th style="width:20%;">License Number</th>
									<th style="width:14%;">Expire Date</th> 
								</tr> 
							</thead>
								<tbody>
								<?php 
								$j=1; 
								foreach($areas as $area) {     ?>
							<?php 
							
							$k=0; 
							$pre_area_code = '';
							foreach($all_branch as $branch){?> 
						
								<?php 
									if(!empty($all_result_driver_license)){ 
									$i=1; 
									
									$pre_branch_code = '';
									foreach($all_result_driver_license as $result){
									if(($result['br_code'] == $branch->br_code) && ($area->area_code == $result['area_code'])){
										if($pre_area_code != $result['area_code'] ){ 
										
											$k= $total_branch[$result['br_code']];
											$tot_row++;
										?>
											<tr> 
												<td rowspan="<?php echo $total_area[$result['area_code']];?>">{{$j++}}</td>
												<td rowspan="<?php echo $total_area[$result['area_code']];?>">{{$result['area_name']}}</td> 
												<td rowspan="<?php echo $total_branch[$result['br_code']];?>">{{$result['branch_name']}}</td> 
												<td>{{$i++}}</td>
												<td>{{$result['emp_name']}}</td> 
												<td>{{$result['type_name']}}</td>
												<td>{{$result['emp_id']}}</td>
												<td>{{$result['designation_name']}}</td>  
												<td>{{$result['dri_license_id']}}</td>
												<td>{{$result['license_number']}}</td>
												<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
											</tr> 
								<?php 		}else { 
								
												if($k > 1){ $tot_row++; ?>
														<tr> 
															<td>{{$i++}}</td>
															<td>{{$result['emp_name']}}</td> 
															<td>{{$result['type_name']}}</td> 
															<td>{{$result['emp_id']}}</td>
															<td>{{$result['designation_name']}}</td>  
															<td>{{$result['dri_license_id']}}</td>
															<td>{{$result['license_number']}}</td>
															<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
														</tr> 
												<?php $k--;	}else{  ?>

												<?php
												if($pre_branch_code != $result['br_code']){  $tot_row++; ?>
														<tr>  
															<td rowspan="<?php echo $total_branch[$result['br_code']];?>">{{$result['branch_name']}}</td> 
															<td>{{$i++}}</td>
															<td>{{$result['emp_name']}}</td> 
															<td>{{$result['type_name']}}</td> 
															<td>{{$result['emp_id']}}</td>
															<td>{{$result['designation_name']}}</td>  
															<td>{{$result['dri_license_id']}}</td>
															<td>{{$result['license_number']}}</td>
															<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
														</tr> 
												<?php	}else{  $tot_row++; ?>
														 <tr>  
															<td>{{$i++}}</td>
															<td>{{$result['emp_name']}}</td> 
															<td>{{$result['type_name']}}</td> 
															<td>{{$result['emp_id']}}</td>
															<td>{{$result['designation_name']}}</td>  
															<td>{{$result['dri_license_id']}}</td>
															<td>{{$result['license_number']}}</td>
															<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
														</tr> 
												<?php	} $pre_branch_code = $result['br_code'];
												?>
													
												<?php 	}  ?> 
								 
											 
									<?php 		}   $pre_area_code = $result['area_code']; }
								
								
								?>
								
									<?php } } } ?>
							
					<?php   } ?>
							</tbody>
						</table>
					</div>
			<?php }else{ ?>
			
				<?php 	if(!empty($br_code)){ ?>
				<div class="col-md-12">
					
					<table class="table table-bordered" cellspacing="0">
						<thead> 
							<tr> 
								<th style="width:5%;">SL NO</th>
								<th style="width:10%;">Branch Name</th>
								<th style="width:5%;">EM No.</th>
								<th style="width:13%;">Employee Name</th> 
								<th style="width:5%;">Type Name</th> 
								<th style="width:5%;">ID No</th>
								<th style="width:15%;">Designation</th> 
								<th style="width:8%;">License SL No.</th>
								<th style="width:20%;">License Number</th>
								<th style="width:14%;">Expire Date</th> 
							</tr>  
						</thead>
						<tbody>
							<?php 
								if(!empty($all_result_driver_license)){ 
								$i=1; 
								foreach($all_result_driver_license as $result){ 
									if($i == 1){ $tot_row++; ?> 
											<tr> 
												<td rowspan="<?php echo $total_branch[$result['br_code']];?>">1</td>
												<td rowspan="<?php echo $total_branch[$result['br_code']];?>">{{$result['branch_name']}}</td> 
												<td>{{$i++}}</td>
												<td>{{$result['emp_name']}}</td> 
												<td>{{$result['type_name']}}</td> 
												<td>{{$result['emp_id']}}</td>
												<td>{{$result['designation_name']}}</td>  
												<td>{{$result['dri_license_id']}}</td>
												<td>{{$result['license_number']}}</td>
												<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
											</tr>   
									<?php }else{  $tot_row++; ?>
											<tr>
												<td>{{$i++}}</td> 
												<td>{{$result['emp_name']}}</td> 
												<td>{{$result['type_name']}}</td> 
												<td>{{$result['emp_id']}}</td>
												<td>{{$result['designation_name']}}</td>  
												<td>{{$result['dri_license_id']}}</td>
												<td>{{$result['license_number']}}</td>
												<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
											</tr> 
							<?php 	}
							?>
							
								<?php  } } ?>
						</tbody>
					</table>
				</div>
			<?php }else{ ?> 
			
			<div class="col-md-12">
			<p><b>Area Name : </b><?php foreach($areas as $area ) { if($area->area_code == $area_code){   echo $area->area_name;   } } ?></p>
			
			
			
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr> 
							<th style="width:5%;">SL NO</th>
							<th style="width:10%;">Branch Name</th>
							<th style="width:5%;">EM No.</th>
							<th style="width:13%;">Employee Name</th> 
							<th style="width:5%;">Type Name</th> 
							<th style="width:5%;">ID No</th>
							<th style="width:15%;">Designation</th> 
							<th style="width:8%;">License SL No.</th>
							<th style="width:20%;">License Number</th>
							<th style="width:14%;">Expire Date</th> 
						</tr> 
					</thead>
						<tbody>
					<?php 
					
					
					$j=1; 
					foreach($all_branch as $branch){?> 
				
						<?php 
							if(!empty($all_result_driver_license)){ 
							$i=1; 
							
							$pre_branch_code = '';
							foreach($all_result_driver_license as $result){
							if($result['br_code'] == $branch->br_code){
								if($pre_branch_code != $result['br_code']){ $tot_row++; ?>
									<tr> 
										<td rowspan="<?php echo $total_branch[$result['br_code']];?>">{{$j++}}</td>
										<td rowspan="<?php echo $total_branch[$result['br_code']];?>">{{$result['branch_name']}}</td> 
										<td>{{$i++}}</td>
										<td>{{$result['emp_name']}}</td> 
										<td>{{$result['type_name']}}</td> 
										<td>{{$result['emp_id']}}</td>
										<td>{{$result['designation_name']}}</td>  
										<td>{{$result['dri_license_id']}}</td>
										<td>{{$result['license_number']}}</td>
										<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
									</tr> 
						<?php 		}else{ $tot_row++; ?>
									 <tr>  
										<td>{{$i++}}</td>
										<td>{{$result['emp_name']}}</td> 
										<td>{{$result['type_name']}}</td> 
										<td>{{$result['emp_id']}}</td>
										<td>{{$result['designation_name']}}</td>  
										<td>{{$result['dri_license_id']}}</td>
										<td>{{$result['license_number']}}</td>
										<td>{{date('d M Y',strtotime($result['license_exp_date']))}}</td> 
									</tr> 
						<?php 		}
						$pre_branch_code = $result['br_code'];
						
						?>
						
							<?php } } } ?>
					
					<?php   }?>
					</tbody>
				</table>
				
			</div>
			<?php  } ?>
			<?php } ?>
			
			<div class="col-md-12">
				 
					<p style="padding-right:5%;text-align:right"><b>Total License =</b> <?php  echo $tot_row; ?></p>
				 
			</div>
			

				<div id="footer">http://45.114.85.154/hrm/drivier_license_search_report</div>
		</div>
	</div>
	@endif
</section>
 


<script type="text/javascript"><!--


$(document).on("change", "#area_code", function () {
	var area_code = document.getElementById("area_code").value;
	 //alert(area_code);
		  $.ajax({
			type: "GET",
			dataType: 'json',
			url : "{{URL::to('get_branch_by_area')}}"+"/"+area_code, 
			success: function(data)
			{
				var t_row ="<option value='' >-Select-</option>"; 
				 for(var x in data["data"]) {
						  t_row += "<option value="+data["data"][x]["br_code"]+">"+data["data"][x]["branch_name"]+"</option>";
					   } 
				$('#br_code').html(t_row);
			}
		}); 
})








$(document).ready(function() { 
	document.getElementById("br_code").value="{{$br_code}}";
	document.getElementById("area_code").value="{{$area_code}}";
});
//--></script>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
		var divToPrint = document.getElementById(divID);
			//document.getElementById('note').style.display = 'block';
		var htmlToPrint = '' +
			'<style type="text/css">' + '.table-bordered th {' +
			'border:1px solid #757070;padding:2px;font: 14px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + '.table-bordered td {' +
			'border:1px solid #757070;padding:2px;font: 11px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;' + 
			'}' + 'table {' +
			'border-collapse: collapse;' +
			'width:100%;' +
			'}' + 'body {' +
			'margin-left: 10px;' +
			'}' + '#footer {' +
			'position: fixed;bottom: 0;' +
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
    }
</script>
<script>
//To active  menu.......//
	$(document).ready(function() {
		$("#MainGroupBasic_Reports").addClass('active');
		$("#Driving_License").addClass('active');
	});
</script>
@endsection