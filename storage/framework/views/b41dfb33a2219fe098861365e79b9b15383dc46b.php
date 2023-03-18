<?php $__env->startSection('main_content'); ?>

	<style>
	/* Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	  margin: 0;
	}
	/* Firefox */
	input[type=number] {
	  -moz-appearance: textfield;
	}
	</style>


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Self<small>Care</small></h1>
    </section>

    <section class="content-header">
        <a href="<?php echo e('/profile'); ?>">
            <h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5>
        </a>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Loan Application</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="post">
                        <div class="user-block">
                            <div class="col-sm-12">
                                <table width="100%">
									<tr>
										<td width="90%"></td>
										<td align="right"><button type="button" class="btn btn-success btn-block" onclick="add_application();">  Application for Loan</button></td>
									</tr>
								</table>
								<br>
								<div class="table-responsive">
									<table id="table_loan_application" class="table table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>ID</th>
												<th>Application Date</th>
                                                <th>Loan Type</th>
                                                <th>Loan Amount</th>
                                                <th>Status</th>
                                                <th>View</th>
                                                <th style="width:15%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog" data-keyboard="false" data-backdrop="static">    
	   <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
				<div id="error_message" style="color:red">
					<ul id="msg_show">
						
					</ul>
				</div>
				<br>
                <form class="form-horizontal" role="form" method="POST" id="loan_form">
                    <?php echo e(csrf_field()); ?>

                    <span id="post_method"></span>                   
					<input type="hidden" name="loan_app_id" id="loan_app_id" value=""> 
                    <input type="hidden" name="layer" id="layer" value="4">
					<input type="hidden" name="ho_bo" id="ho_bo" value="2">
					<input type="hidden" name="supervisor_emp_id" id="supervisor_emp_id" value="<?php echo $supervisor_emp_id; ?>">
					<input type="hidden" name="supervisors_name" id="supervisors_name" value="<?php echo $supervisors_name; ?>">
					<input type="hidden" name="supervisor_designation" id="supervisor_designation" value="<?php echo $supervisor_designation; ?>">
                    <div class="form-group">
                        <label for="application_date" class="col-sm-4 control-label"> Apply Date</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" name="application_date" id="application_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supervisor" class="col-sm-4 control-label">Supervisor</label> 
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="<?php echo $supervisor_designation; ?>" readonly>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="application_date" class="col-sm-4 control-label">Select Employee</label>
                        <div class="col-sm-7">
							<select class="form-control" required name="emp_id" id="emp_id" onchange="set_loan_info();">
                                <option value="" hidden>-SELECT-</option>
								<?php foreach($my_staffs as $my_staff) { ?>
                                <option value="<?php echo $my_staff['emp_id'] ?>"><?php echo $my_staff['emp_name_eng'].'-'.$my_staff['emp_id'].' ('.$my_staff['designation_name'].')' ?></option>
                                <?php }  ?>
                            </select>
							<span id="emp_id_msg" style="color:red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_type_id" class="col-sm-4 control-label">Loan Type</label> 
                        <div class="col-sm-7">
                            <select class="form-control" required name="loan_type_id" id="loan_type_id" onchange="set_loan_info();">
                                <option value="" hidden>-SELECT-</option>
                                <?php foreach ($loan_types as $loan_type) { ?>
                                <option value="<?php echo $loan_type->loan_product_id; ?>">
                                    <?php echo $loan_type->loan_category_name; ?></option>
                                <?php } ?>
                            </select>
							<span id="loan_type_msg" style="color:red"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_amount" class="col-sm-4 control-label"> Loan Amount </label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="loan_amount" name="loan_amount" value="" onkeydown="return event.keyCode !== 69" required>
                        </div>
                    </div>
                    <div class="form-group" id="div_equipments" style="display: none;">
                        <label for="loan_amount" class="col-sm-4 control-label">Equipment</label>
                        <div class="col-sm-7">
							<?php foreach($loan_purpouse as $v_loan_purpouse) { ?>
                            <input name="equipments[]" class="equipment_c"  id="equipments" type="checkbox" value="<?php echo $v_loan_purpouse->purpose_name; ?>"> <?php echo $v_loan_purpouse->purpose_name; ?>
							<?php } ?>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="loan_amount" class="col-sm-4 control-label"> Loan Purpose <br>(Description)</label>
                        <div class="col-sm-7">
                            <textarea class="form-control" id="loan_purpose" name="loan_purpose" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_duration" class="col-sm-4 control-label">Loan Tenure</label> 
                        <div class="col-sm-7">
							<select class="form-control" id="loan_duration" name="loan_duration" required>
								
							</select>
                        </div>
						<div class="col-sm-3"></div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Interest Rate (%)</label> 
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="interest" name="interest" value="0" readOnly> 
                        </div>
						<div class="col-sm-3"></div>
                    </div>
					<hr>
					<center style="color:#054468;"><b> Your Recomendatation </b></center>
					<hr>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label" style="color:blue">Action</label> 
                        <div class="col-sm-7">
                            <select class="form-control" id="actions" name="actions">
								<option value="1">Recommend</option>
							</select>
                        </div>
						<div class="col-sm-3"></div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label" style="color:blue">Remarks</label>  
                        <div class="col-sm-7">
                            <textarea class="form-control" name="actions_remarks" id="actions_remarks" required></textarea>
                        </div>
						<div class="col-sm-3"></div>
                    </div>
					<hr>
					<center style="color:#054468;"><b> Bank Account ( Details )</b></center>
					<hr>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Name (Account Holder)</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="accounts_holder" name="accounts_holder" value="" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Bank Name</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="bank_id" name="bank_id" required>
								<option value="" hidden>- SELECT BANK -</option>
								<?php foreach($banks as $bank) { ?>
								<option value="<?php echo $bank->bank_id;?>"><?php echo $bank->bank_name?></option>
								<?php } ?>
							</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Select Branch</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="bank_branch_id" name="bank_branch_id" required>
								<option value="" hidden>-SELECT BRANCH-</option>
							</select>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Account Number</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="accounts_number" name="accounts_number" value="" pattern="[a-zA-Z0-9]+" onkeydown="return event.keyCode !== 69" required>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Routing Number</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="routing_number" name="routing_number" value="" pattern="[a-zA-Z0-9]+" onkeydown="return event.keyCode !== 69" required >
                        </div>
                    </div>
                    <div class="modal-footer">
						<input type="submit" name="btnSave" id="btnSave" class="btn btn-success" value="Submit Application">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Bootstrap modal -->

    <script>	
        var table_loan_application;
        $(document).ready(function() {
            table_loan_application = $('#table_loan_application').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "order": [
                    [2, "DESC"]
                ],
                "ajax": {
                    "url": "<?php echo e(URL::to('/all_loan_application_sc')); ?>",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "<?php echo e(csrf_token()); ?>"
                    }
                },
                "columns": [{
                        "data": "sl",
                        "defaultOrder": true,
                        "sortOrder": 'DESC'
                    },
                    {
                        "data": "emp_name"
                    },
					{
                        "data": "emp_id"
                    },
					{
                        "data": "application_date"
                    },
                    {
                        "data": "loan_type"
                    },
                    {
                        "data": "loan_amount"
                    },
                    {
                        "data": "application_stage"
                    },
                    {
                        "data": "view",
                        "orderable": "false"
                    },
                    {
                        "data": "options",
                        "orderable": "false"
                    }
                ]
            });
        });
        //TABLE RELOAD 
        function reload_table() {
            table_loan_application.ajax.reload(null, false); //reload datatable ajax 
        }		
        $(document).ready(function() {
            $('#loan_form').on('submit', function(event) {
				event.preventDefault();
				var loan_type_id = document.getElementById("loan_type_id").value;
				var returnval = true;
				if (loan_type_id == 7) {
					var abc = $(".equipment_c:checkbox").filter(":checked");
					if(abc.length > 0){
						returnval = true;
					}else{
						returnval = false;
					}
				} 
				if(returnval == true){
					var application_date 	= document.getElementById("application_date").value;
					var emp_id 				= document.getElementById("emp_id").value; 
					var loan_amount 		= document.getElementById("loan_amount").value;
					var loan_duration 		= document.getElementById("loan_duration").value;
					var get_status = check_validations(application_date,emp_id,loan_type_id,loan_amount,loan_duration);					 
					if(get_status == 0)
					{
						$('#btnSave').text('Submitting...'); //change button text
						$('#btnSave').attr('disabled', true); //set button disable 
						url = "<?php echo e(URL::to('/loan_save_sc')); ?>";
						message = 'Saved Successfully';
						$.ajax({
							url: url,
							method: "POST",
							data: new FormData(this),
							dataType: 'JSON',
							contentType: false,
							cache: false,
							processData: false,
							success: function(data) {
								$('#btnSave').text('Submit for Approval'); //change button text
								$('#btnSave').attr('disabled', false); //set button enable 
								$('#modal_form').modal('hide'); // Modal form hide
								$.gritter.add({
									title: 'Success!',
									text: message,
									sticky: false,
									class_name: 'gritter-light'
								});							
								reload_table(); // List table reloaded
							},
							error: function(jqXHR, textStatus, errorThrown) {
								$.gritter.add({
									title: 'Error!',
									text: 'Error to Save Data',
									sticky: false,
									class_name: 'gritter-light'
								});
								$('#btnSave').text('Submit for Approval'); //change button text
								$('#btnSave').attr('disabled', false); //set button enable 
							}
						});
					}
					else{
						var mesage_html='';
						for(var i = 0;i < get_status.length;i++)
						{
							if(get_status[i] != '')
							{
								mesage_html += "<li>"+get_status[i]+"</li>";	
							}
						} 
						document.getElementById("msg_show").innerHTML = mesage_html;
					}
				}else{ 
					document.getElementById("msg_show").innerHTML = 'ইকুইপমেন্ট  সিলেক্ট করুন ';
				}
			});
        });

		function check_validations(application_date,emp_id,loan_type_id,loan_amount,loan_duration)
		{
			var flag = 0;
			var returnvalue = 0;
			var url = "<?php echo e(URL::to('/loan-validations')); ?>"; 
			var return_type = true;
			$.ajax({
				type: "GET",
				url: url + "/" + application_date + "/" + emp_id + "/" + loan_type_id + "/" + loan_amount + "/" + loan_duration,
				async: false,
				success: function(res) {
					return_type = res;
				}
			})
			return return_type;
		}

        function set_interest() {
            var loan_interest = document.getElementById("loan_category").value;
            var loan_category = document.getElementById("interest").value = loan_interest;
        }

        function set_rules() {
            var loan_repayment_types = document.getElementById("loan_repayment_types").value;
            if (loan_repayment_types == 1) {
                document.getElementById("loan_duration_month").readOnly = false;
                document.getElementById("loan_fixed_amount").readOnly = true;
            } else {
                document.getElementById("loan_duration_month").readOnly = true;
                document.getElementById("loan_fixed_amount").readOnly = false;
            }
        }

        function add_application() {
            save_method = 'add';
			document.getElementById("msg_show").innerHTML = '';
            $('#btnSave').text('Submit for Approve'); //change button text
            document.getElementById("post_method").innerHTML = "";
            $('#loan_form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text(' Loan Application '); // Set Title to Bootstrap modal title
        }

    </script>
	
	<script>
		$(document).on("change", "#bank_id", function () {
			var bank_id = $(this).val();  
				$.ajax({
				url : "<?php echo e(url::to('banks_branch')); ?>"+"/"+bank_id,
				type: "GET",
				success: function(data)
				{
					$("#bank_branch_id").html(data); 
				}
			}); 
		}); 
		
		function set_loan_info()
		{
			var emp_id 		= document.getElementById("emp_id").value;
			var loan_type 	= document.getElementById("loan_type_id").value;
			document.getElementById("emp_id_msg").innerHTML = 'Select Employee';
			if(emp_id == '')
			{
				$('#btnSave').attr('disabled', true);
				document.getElementById("emp_id_msg").innerHTML = 'Select Employee';
			}else{
				document.getElementById("emp_id_msg").innerHTML = '';
				$('#btnSave').attr('disabled', false);
			}			
			if(loan_type == '')
			{
				$('#btnSave').attr('disabled', true);
				document.getElementById("loan_type_msg").innerHTML = 'Select Loan Product';
			}else{
				document.getElementById("loan_type_msg").innerHTML = '';
				$('#btnSave').attr('disabled', false);
			}
			var x = document.getElementById("div_equipments");
			if (loan_type == 7) {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
			$.ajax({
				url : "<?php echo e(url::to('loan_product_infos')); ?>"+"/"+loan_type+"/"+emp_id,
				type: "GET",
				dataType: 'JSON',
				success: function(data)
				{
					//console.log(data.interest_rate);
					$("#interest").val(data.interest_rate); 
					$("#loan_duration").html(data.options); 
				}
			}); 
		} 
	</script>
	
    <script>
        //To active  menu.......//
        $(document).ready(function() {
            //$("#MainGroupSelf_Care").addClass('active');
            //$("#My_Loan").addClass('active');
        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>