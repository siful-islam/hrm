@extends('admin.admin_master')
@section('title','Eid Execution form')
@section('main_content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Approved<small>leave</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Leave</a></li>
			<li class="active">Approved</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Leave Execution For Eid</h3>
			</div>
			
			
			<form   action="" method="post" id="eid_form">
					  {{csrf_field()}}  
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4">Execution Date</label>
									<div class="col-md-6">
										<input type="date" class="form-control"  value="<?php echo $date_within;?>" name="date_within" id="date_within"/>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div>
					</div> 
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4"> Branch</label>
									<div class="col-md-6">
										<select name="br_code" id="br_code" class="form-control"  required> 
											<?php foreach($branches as $v_branch){ ?>
											<option value="<?php echo $v_branch->br_code; ?>" ><?php echo $v_branch->branch_name; ?></option>  
											<?php } ?>
										</select>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div>
					</div>
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4"> Leave For</label>
									<div class="col-md-6">
										<select name="leave_for" id="leave_for" class="form-control"  required>
																			
											<option value="2"> Eid Ul Adha </option> 
											<option value="1" >Eid Ul Fitr</option>		
										</select>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div>
					</div>
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4"> Leave Source</label>
									<div class="col-md-6">
										<select name="type_id" id="type_id" class="form-control"  required> 
											<option value="1" >Earn</option>  
										</select>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div>
					</div>
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4">Leave From </label>
									<div class="col-md-6">
										<input type="date" class="form-control" onchange="set_date();" value="<?php echo $from_date;?>" name="from_date" id="from_date"/>
										<span  class="help-block" style="color:red;"><span>
									</div> 
							</div> 
						</div> 
					</div>
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4">Leave To </label>
									<div class="col-md-6">
										<input type="date" class="form-control" onchange="set_date();" value="<?php echo  $to_date; ?>" name="to_date" id="to_date"/>
										  <span class="help-block" id="leave_to_msg" style="color:red;"><span>
									</div> 
							</div> 
						</div> 
					</div>
					<div class="row"> 
						<div class="col-md-4 col-md-offset-2">
							<div class="form-group"> 
								<label class="control-label col-md-4">Days </label>
									<div class="col-md-6">
										<input type="text"  readonly class="form-control"  value="2" name="no_of_days" id="no_of_days"/>
										<span class="help-block"></span>
									</div> 
							</div> 
						</div> 
					</div>
					<br>
					<br>
					<div class="row"> 
						<div class="col-md-4 col-md-offset-5">
							<div class="form-group">   
								<button type="submit" class="btn btn-primary"    id="btnSave"/>Execute</button>
								<span class="help-block"></span> 
							</div> 
						</div> 
					</div>   
			</form>   
		</div>
</section> 
 
<script>
	 $(document).ready(function() {

            $('#eid_form').on('submit', function(event) {
                event.preventDefault();
                $('#btnSave').text('Executing...'); //change button text
				//exit();
                $('#btnSave').attr('disabled', true); //set button disable 
                url = "{{ URL::to('/insert_eid_leave_execute') }}";
                message = 'Data Saved Successfully';

                $.ajax({
                    url: url,
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $('#btnSave').text('Execute'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 
						location.reload();
							  
						 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        $.gritter.add({
                            title: 'Error!',
                            text: 'Error to Save Data'
                        });
                        $('#btnSave').text('Execute'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 
                    }
                });

            });
        }); 
	function set_date(){
					var from_date =  document.getElementById("from_date").value;
					var to_date =  document.getElementById("to_date").value;
					var date1 = new Date(from_date);
                    var date2 = new Date(to_date);
                    var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10);
                    document.getElementById('no_of_days').value = diffDays + 1;
		 
            if (to_date < from_date) {
                document.getElementById('leave_to_msg').innerHTML = 'Invaid Date';
                $('#btnSave').attr('disabled', true); //set button disable 
            } else {
               
                document.getElementById('leave_to_msg').innerHTML = '';
                $('#btnSave').attr('disabled', false); //set button enable 
                 
            }
	} 
</script> 
<script>
	//To active  menu.......//
		$(document).ready(function() {
			$("#MainGroupEmployee_Leave").addClass('active');
			$("#Eid_Leave_Execute").addClass('active');
		});
	</script>
@endsection