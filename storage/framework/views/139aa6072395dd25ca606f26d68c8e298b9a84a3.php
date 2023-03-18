
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
        <ol class="breadcrumb">
            <li><a href="<?php echo e('/profile'); ?>">Self Care -></a> ***</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Loan Application</a></li>
                <li><a href="#tab_2" data-toggle="tab">My Loan</a></li>
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
                                                <th>Application Date</th>
                                                <th>Loan Type</th>
                                                <th>Loan Amount</th>
                                                <th>Statge</th>
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


                <div class="tab-pane" id="tab_2">
                    <div class="post">
                        <div class="user-block">
                            <div class="col-sm-3">
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <h3 class="profile-username text-center">Loan Status</h3>
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <button type="button" class="btn btn-default btn-block"><b>Loan Cycle : <?php echo count($loanData); ?></b></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Sl</td>
                                            <td>Loan Id</td>
                                            <td>Application Date</td>
                                            <td>Loan Code</td>
                                            <td>Loan Product</td>
                                            <td>Disbursement Date</td>
                                            <td>Loan Amount</td>
                                            <td>First repayment date</td>
                                            <td>View</td>
                                        </tr>
                                        <?php
                                        $l = 1;
                                        if (!empty($loanData[0])) {
                                        foreach ($loanData as $loan) { ?>
                                        <tr>
                                            <td><?php echo $l; ?></td>
                                            <td><?php echo $loan->loan_id; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($loan->application_date));
                                                ?></td>
                                            <td><?php echo $loan->loan_code; ?></td>
                                            <td><?php echo $loan->loan_product_name; ?></td>
                                            <td><?php echo date('d-m-Y',
                                                strtotime($loan->disbursement_date)); ?></td>
                                            <td><?php echo $loan->loan_amount; ?></td>
                                            <td><?php echo date('d-m-Y',
                                                strtotime($loan->first_repayment_date)); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-xs button view_button"
                                                    data-toggle="modal" data-target="#view_loan_details"
                                                    data-id="<?php echo e($loan->loan_id); ?>" data-loan_code="<?php echo e($loan->loan_code); ?>"
                                                    data-loan_product_name="<?php echo e($loan->loan_product_name); ?>"
                                                    data-first_repayment_date="<?php echo e(date('M-Y', strtotime($loan->first_repayment_date))); ?>"
                                                    data-emp_id="<?php echo e($loan->emp_id); ?>"
                                                    data-emp_name="<?php echo e($loan->emp_name_eng); ?>">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $l++;}
                                        } else {
                                        ?>
                                        <tr>
                                            <td align="center" colspan="9">There is no loan informarion</td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>

    </section>



    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view_loan_details"
        class="modal fade bd-example-modal-md">
        <div class="modal-dialog" style="width: 80%; margin: 0 auto; padding: 1%;">
            <div class="modal-content" style=" height: auto; min-height: 100%; border-radius: 0;">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>

                    <div id="printme">
                        <div class="text-center">
                            <table border="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td align="center"><b>
                                                <font size="4"> <img style="width: 40px"
                                                        src="<?php echo e(asset('public/org_logo/cdip.png')); ?>">
                                                    Centre for Development Innovation and Practices (CDIP)</font>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <b>
                                                <font size="2"> সিদীপ ভবন, হাউজ # ১৭, রোড # ১৩, পিসিকালচার হাউজিং সোসাইটি , শেখেরটেক, আদাবর, ঢাকা।</font>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <b>
                                                <font size="2">Web: www.cdipbd.org, Phone: 02-9141891 & 9141893</font>
                                            </b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table style="margin-bottom: 10px" border="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td align="left"><b>
                                            <font size="4">Name: <span id="loan_schedule_for"></span></font>
                                        </b>
                                    </td>
                                    <td align="center">
                                        <b>
                                            <font size="4"><span id="for_loan_code"></span></font>
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <b>
                                            <font size="2"><span id="first_repayment_date"></span></font>
                                        </b>
                                    </td>
                                    <td align="center">
                                        <b>
                                            <font size="2">Print Date: <?php echo e(date('d-m-Y')); ?></font>
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal-body">
                            <div id="view_loan_details_list" class="row">
                                <div id="loan_table" class="box-body table-responsive">

                                </div>

                            </div>
                            <div id="note" style="display: none !important; position: fixed; bottom: 0;">
                                <small style="float:left">** (Report Generated From : CDIP Payroll)</small>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>






    <!-- Start Bootstrap modal -->
    <div class="modal fade" method="post" id="modal_form" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <br>

                <form class="form-horizontal" role="form" method="POST" id="loan_form">
                    <?php echo e(csrf_field()); ?>

                    <span id="post_method"></span>
                    <input type="hidden" name="loan_app_id" id="loan_app_id" value="">
                    <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="supervisor" id="supervisor" value="<?php echo $report_to; ?>">
					<input type="hidden" id="years" placeholder="Years">
                    <div class="form-group">
                        <label for="application_date" class="col-sm-4 control-label">ঋণ আবেদনের তারিখ </label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" name="application_date" id="application_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supervisor" class="col-sm-4 control-label">প্রতি  (সুপারভাইসার)</label> 
                        <div class="col-sm-7">
                            <input type="text" class="form-control" value="<?php echo $report_to_show; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_type_id" class="col-sm-4 control-label">ঋণ টাইপ </label>
                        <div class="col-sm-7">
                            <select class="form-control" name="loan_type_id" id="loan_type_id" onchange="set_loan_info(this.value);">
                                <option value="" hidden>-SELECT-</option>
                                <?php foreach ($loan_types as $loan_type) { ?>
                                <option value="<?php echo $loan_type->loan_product_id; ?>">
                                    <?php echo $loan_type->name_bangla; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_amount" class="col-sm-4 control-label"> ঋণ আবেদনের পরিমান </label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" id="loan_amount" name="loan_amount" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_amount" class="col-sm-4 control-label"> ঋণ নেয়ার কারণ  (বিবরন) </label>
                        <div class="col-sm-7">
                            <textarea class="form-control" id="loan_purpose" name="loan_purpose"></textarea>
                        </div>
                    </div>
					<!--
                    <div class="form-group">
                        <label for="loan_repayment_types" class="col-sm-4 control-label">Installment in</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="loan_repayment_types" id="loan_repayment_types"
                                onchange="set_rules();">
                                <option value="1">Monthly</option>
                                <option value="2">Fixed Amount</option>
                            </select>
                        </div>
                    </div>
					-->
                    <div class="form-group">
                        <label for="loan_duration" class="col-sm-4 control-label">ঋণের মেয়াদ</label> 
                        <div class="col-sm-4">
							<select class="form-control" id="loan_duration" name="loan_duration" required>
								<option value="1">১ মাস </option>
								<option value="2">২ মাস</option>
								<option value="3">৩ মাস</option>
								<option value="4">৪ মাস</option>
								<option value="5">৫ মাস</option>
								<option value="6">৬ মাস</option>
								<option value="7">৭ মাস</option>
								<option value="8">৮ মাস</option>
								<option value="9">৯ মাস</option>
								<option value="10">১০ মাস</option> 
								<option value="11">১১ মাস</option> 
								<option value="12">১২ মাস</option>  
								<option value="18">১৮ মাস</option> 
								<option value="24">২৪ মাস</option> 
								<option value="30">৩০ মাস</option> 
								<option value="36">৩৬ মাস</option> 

							</select>
                        </div>
						<div class="col-sm-3"></div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label"> ইন্টারেস্ট রেট ( % )</label> 
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="interest" name="interest" value="0" readOnly> 
                        </div>
						<div class="col-sm-3"></div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">ই.এম.আই</label> 
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="emi" name="emi" value="0" readonly>
                        </div>
						<div class="col-sm-3">
                           <button type="button" class="btn btn-primary" onclick="myFunction()"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate</button>
                        </div>
                    </div>
					<hr>
					<center style="color:#054468;"><b> ব্যাংক হিসাবের বিবরণ </b></center>
					<hr>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Name (Account Holder)</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="accounts_holder" name="accounts_holder" value="">
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
                            <input type="text" class="form-control" id="accounts_number" name="accounts_number" value="" pattern="[a-zA-Z0-9]+">
                        </div>
                    </div>
					<div class="form-group">
                        <label for="loan_fixed_amount" class="col-sm-4 control-label">Routing Number</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="routing_number" name="routing_number" value="" pattern="[a-zA-Z0-9]+">
                        </div>
                    </div>
                    <div class="modal-footer">
						<input type="submit" name="btnSave" id="btnSave" class="btn btn-success"
                            value="আবেদন জমা করুন">
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
                    "url": "<?php echo e(URL::to('/all_loan_application')); ?>",
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

				$('#btnSave').text('Submitting...'); //change button text
				$('#btnSave').attr('disabled', true); //set button disable 
				url = "<?php echo e(URL::to('/my_loan')); ?>";
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
				
			});
        });
		
		
		
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
            $('#btnSave').text('Submit for Approve'); //change button text
            document.getElementById("post_method").innerHTML = "";
            $('#loan_form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text(' ঋণ আবেদন ফরমঃ '); // Set Title to Bootstrap modal title
        }

        $(document).on("click", '.view_button', function(e) {

            var id = $(this).data('id');
            var for_loan_code = $(this).data('loan_code');
            var loan_schedule_for = $(this).data('emp_name');
            var emp_id = $(this).data('emp_id');
            var loan_product_name = $(this).data('loan_product_name');
            var first_repayment_date = $(this).data('first_repayment_date');
            var url = "<?php echo e(URL::to('/get_loan_details_by_id')); ?>";
            $.ajax({
                type: "GET",
                // data: {id: id},
                url: url + "/" + id,
                success: function(res) {
                    //console.log(res);
                    $("#loan_table").html(res);
                    $("#loan_schedule_for").text(loan_schedule_for + " (" + emp_id + ")");
                    $("#for_loan_code").text('Loan code: ' + loan_product_name + ' (' + for_loan_code +
                        ')');
                    $("#first_repayment_date").text('Repayment Date: ' + first_repayment_date);
                }
            })

        });

        function myFunction() {
            
			var interests = $('#interest').val();
			
			var loan = $('#loan_amount').val(),
                month = $('#loan_duration').val(),
                int = $('#interest').val(),
                //years = $('#years').val(),
                //down = $('#down').val(),
                down = 0,
                amount = parseInt(loan),
                months = parseInt(month),
                down = parseInt(down),
                annInterest = parseFloat(int),
                monInt = annInterest / 1200,
                calculation = ((monInt + (monInt / (Math.pow((1 + monInt), months) - 1))) * (amount - (down || 0))).toFixed(
                    2);
			if(interests == 0)
			{
				calculation = parseFloat(loan/month);
			}
			document.getElementById("emi").value =  Math.round(calculation);
        }


        $(function() {
            var month = $(this).val(),
                doneTypingInterval = 500,
                months = parseInt(month),
                typingTimer;

            $('#months').keyup(function() {
                month = $(this).val();
                months = parseInt(month);

                clearTimeout(typingTimer);
                if (month) {
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                }
            });

            function doneTyping() {
                $('#years').val(months / 12);
            }
        })

        $(function() {
            var month = $(this).val(),
                doneTypingInterval = 500,
                months = parseInt(month),
                typingTimer;
            $('#months').keyup(function() {
                month = $(this).val();
                months = parseInt(month);
                clearTimeout(typingTimer);
                if (month) {
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                }
            });

            function doneTyping() {
                $('#years').val(months / 12);
            }
        })

        $(function() {
            var year = $(this).val(),
                doneTypingInterval = 500,
                years = parseInt(year),
                typingTimer;

            $('#years').keyup(function() {
                year = $(this).val();
                myears = parseInt(year);

                clearTimeout(typingTimer);
                if (year) {
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                }
            });

            function doneTyping() {
                $('#months').val(year * 12);
            }
        })

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
			
			function set_loan_info(id)
			{
				$.ajax({
					url : "<?php echo e(url::to('loan_product_info')); ?>"+"/"+id,
					type: "GET",
					success: function(data)
					{
						$("#interest").val(data); 
					}
				}); 
			}
		</script>


    <script>
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#My_Loan").addClass('active');
        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>