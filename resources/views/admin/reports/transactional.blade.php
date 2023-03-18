@extends('admin.admin_master')
@section('main_content')

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Form Elements<small>Preview</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Forms</a></li>
			<li class="active">Advanced Elements</li>
		</ol>
	</section>
	<!-- Main content -->

	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"> {{$Heading}}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->				
				
				<form class="form-horizontal" action="{{URL::to($action)}}" method="{{$method}}">
                {{ csrf_field() }}
				{!!$method_control!!}
				
					<div class="box-body">
						<div class="form-group">
							<div class="col-sm-2">
								<select name="report_category" id="report_category" required class="form-control">
									<option value="" hidden>-Report Type-</option>
										<?php foreach($transactions as $transaction) { ?>
										<option value="<?php echo $transaction->transaction_id; ?>"><?php echo $transaction->transaction_name; ?></option>
										<?php } ?>
								</select>
							</div>

							<label for="date_within" class="col-sm-1 control-label">Date From</label>
							<div class="col-sm-2">							
								<input type="date" class="form-control" id="date_from" id="date_from" name="date_from" value="<?php echo date('Y-m-d');?>" required>
							</div>
							<label for="date_within" class="col-sm-1 control-label">Date To</label>
							<div class="col-sm-2">							
								<input type="date" class="form-control" id="date_to" id="date_to" name="date_to" value="<?php echo date('Y-m-d');?>" required>
							</div>							
							<div class="col-sm-2">
								<button type="button" onclick="show_report();" class="btn btn-danger">Show Report</button>
								<button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default">Print</button>
							</div>
						</div>
					</div>
					<!-- /.box-body --->
				</form>
		</div>
		
		<?php //if(2==2) { ?>
		
		<div class="box box-danger">
			<div class="box-header with-border">
				<h3 class="box-title">Reports</h3>
			</div>
			
			<div class="box-body" id="report_show">
			
			</div>

		</div>
		
		<?php //} ?>
		
	</section>
	
	
<script>
	function show_report()
	{
		var report_category = document.getElementById("report_category").value;   
		var date_from = document.getElementById("date_from").value;  
		var date_to = document.getElementById("date_to").value;  
		
		$.ajax({
			url : "{{ url::to('show-report-transactions') }}"+"/"+report_category+"/"+date_from+"/"+date_to,
			type: "GET",
			success: function(data)
			{
				//alert(data);
				$("#report_show").html(data); 
						 
			}
		}); 		
	}
</script>

<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>	
	



@endsection