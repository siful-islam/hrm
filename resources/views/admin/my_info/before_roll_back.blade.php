@extends('admin.admin_master')
@section('title', 'Leave & Visit')
@section('main_content')
    <link rel="stylesheet" href="{{ asset('public/admin_asset/bower_components/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc;
            border-color: #367fa9;
            padding: 1px 10px;
            color: #fff;
        }

    </style>
    <style>
        #status_table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #status_table td,
        #list_approval th {
            border: 1px solid #ddd;
            padding: 3px;
        }
        #status_table tr:hover {
            background-color: rgb(255, 254, 254);
        }
        #status_table th {
            padding-top: 6px;
            padding-bottom: 6px;
            text-align: center;
            color: white;
        }
        .nav-tabs-custom>.nav-tabs>li.active>a,
        .nav-tabs-custom>.nav-tabs>li.active:hover>a {
            background-color: #3c8dbc;
            color: #ffffff;
            font-weight: bold;
		}
    </style>
	<style>
		.overlay {
		  height: 100%;
		  width: 0;
		  position: fixed;
		  z-index: 100;
		  top: 0;
		  left: 0;
		  background-color: rgb(0,0,0);
		  background-color: rgba(0,0,0, 0.9);
		  overflow-x: hidden;
		  transition: 0.5s;
		}

		.overlay-content {
		  position: relative;
		  top: 25%;
		  width: 100%;
		  text-align: center;
		  margin-top: 30px;
		}

		.overlay a {
		  padding: 8px;
		  text-decoration: none;
		  font-size: 36px;
		  color: #818181;
		  display: block;
		  transition: 0.3s;
		}

		.overlay a:hover, .overlay a:focus {
		  color: #f1f1f1;
		}

		.overlay .closebtn {
		  position: absolute;
		  top: 20px;
		  right: 45px;
		  font-size: 60px;
		}

		@media screen and (max-height: 450px) {
		  .overlay a {font-size: 20px}
		  .overlay .closebtn {
		  font-size: 40px;
		  top: 15px;
		  right: 35px;
		  }
		}
	</style>
	<div id="myNav" class="overlay">
	  <div class="overlay-content">
		<img src="{{ asset('public/processing.gif') }}" width="100">
        <a href="#">Processing Your Application ........</a>
	  </div>
	</div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Self<small>Care</small></h1>
    </section>
	    <section class="content-header">
        <a href="{{ URL::to('/profile') }}">
            <h5><i class="fa fa-arrow-left" aria-hidden="true"></i> Self Care</h5>
        </a>
    </section>
    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Leave</a></li>
                <li><a href="#tab_2" data-toggle="tab">Visit</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="post">
                        <div class="user-block">
                            <div class="col-sm-12">

                                <div class="box box-widget widget-user">

                                    <div class="table-responsive">
									
									<?php 
									
									$nine_twelve 					= $leave_balance->cum_balance_less_close_12;
									$eighteen_onword 				= $leave_balance->pre_cumulative_open;
									$current_year_earn_open 		= $leave_balance->current_open_balance;
									$current_year_casual_open 		= $leave_balance->casual_leave_open;
									$earn_balance					= $eighteen_onword + $current_year_earn_open;
									$current_year_earn_enjoyed 		= $earn_full_day + $earn_half_day;
									$current_year_casual_enjoyed 	= $casual_full_day + $casual_half_day;
									$earn_remaining 				= $leave_balance->current_close_balance + $leave_balance->pre_cumulative_close; //$earn_balance - $current_year_earn_enjoyed;
									//$casual_remaining 			= $current_year_casual_open - $current_year_casual_enjoyed;
									$casual_remaining 				= $leave_balance->casual_leave_close;
									?>
									 <table border="1" id="status_table">
										<tr>
											<td align="center" style="background-color:#7A7B80; color: white;">OLD Leave ( 2009 - 12 )</td>
											<td align="center" style="background-color:#658907; color: white;">Previous Leave Balance</td>
											<td align="center" style="background-color:#658907; color: white;">Earn Leave [ 2020 - 21 ]</td>
											<td align="center" style="background-color:#658907; color: white;">Total Earn Leave</td>
											<td align="center" style="background-color:#3c8dbc; color: white;"><b>Earn Leave Remaining</b></td>
											<td align="center" style="background-color:#3c8dbc; color: white;"><b>Casual Leave Remaining</b></td>
											<td align="center"><a class="btn btn-info" target="_blank" href="leave_report_profile/<?php echo $emp_id; ?>"><i class="fa fa-file" aria-hidden="true"></i> Leave Report Detail</a>
										</tr>
										<tr>
											<td align="center"><?php echo $nine_twelve; ?></td>
											<td align="center"><?php echo $eighteen_onword; ?></td>
											<td align="center"><?php echo $current_year_earn_open; ?></td>
											<td align="center"><?php echo $earn_balance; ?></b></td>
											<td align="center"><b><?php echo $earn_remaining; ?></b></td>
											<td align="center"><b><?php echo $casual_remaining; ?></td>
											<td align="center"><button type="button" onclick="add_leave();"
                                                        class="btn btn-success"><i class="fa fa-plus"></i> Application for
                                                        Leave </button></td>
										</tr>
									 </table>
                                     <input type="hidden" id="remaining_balance" value="<?php echo $earn_remaining; ?>">
                                     <input type="hidden" id="half_remaining_balance" value="<?php echo $earn_remaining + $casual_remaining; ?>">
                                     <input type="hidden" id="casual_remaining_balance" value="<?php echo $casual_remaining; ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <div class="table-responsive">

                                    <table id="table_leave" class="table table-bordered table-hover" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Application Date</th>
                                                <th>Leave Type</th>
                                                <th>Date From</th>
                                                <th>Date To</th>
                                                <th>Duration</th>
                                                <th>Purpose</th>
                                                <th>Stage</th>
                                                <th>Application</th>
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

                <!--STARTS VISIT -->


                <div class="tab-pane" id="tab_2">

                    <div class="post">
                        <div class="user-block">

                            <div class="col-sm-12">

                                <div class="box box-widget widget-user">

                                    <div class="table-responsive">
                                        <table id="status_table_visit" class="table" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="width:75%" align="center"></td>
                                                <td rowspan="2" align="center">
                                                    <a class="btn btn-info" target="_BLANCK"
                                                        href="visit_detail_info/<?php echo $emp_id; ?>"><i
                                                            class="fa fa-file" aria-hidden="true"></i> Visit
                                                        Detail <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                </td>
                                                <td align="center">
                                                    <button type="button" onclick="add_visit();"
                                                        class="btn btn-success pull-right"><i class="fa fa-plus"></i>
                                                        Application for Visit</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">

                                <div class="table-responsive">
                                    <table id="table_visit" class="table table-bordered table-hover" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Application Date</th>
                                                <th>Destination</th>
                                                <th>Departure Date</th>
                                                <th>Return Date</th>
                                                <th>Duration</th>
                                                <th>Purpose</th>
                                                <th>Stage</th>
                                                <th>Options</th>
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

    <script>
        // LEAVE ADD  
        function add_leave() {
            save_method = 'add';
            $('#btnSave').text('Submit for Approval'); //change button text
            document.getElementById("post_method").innerHTML = "";
            document.getElementById('attachments_msg').innerHTML = '';
            document.getElementById('leave_from_msg').innerHTML = '';
            document.getElementById('leave_to_msg').innerHTML = '';
            document.getElementById('leave_to_msg').innerHTML = '';
            document.getElementById('general_message').innerHTML = '';
            var leave_date_div = document.getElementById("leave_date_div");
            var leave_category_sub_div = document.getElementById("leave_category_sub_div");
            var leave_category_sub_div = document.getElementById("leave_category_sub_div");
            var leave_from_div = document.getElementById("leave_from_div");
            var leave_to_div = document.getElementById("leave_to_div");
            var leave_dates_div = document.getElementById("leave_dates_div");
            leave_date_div.style.display = "none";
            leave_category_sub_div.style.display = "none";
            leave_from_div.style.display = "";
            leave_to_div.style.display = "";
            leave_dates_div.style.display = "none";
            $('#btnSave').attr('disabled', false); //set button enable 
            $('#leave_form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add: Leave Application'); // Set Title to Bootstrap modal title
        }
        // LEAVE SAVE / UPDATE  
        $(document).ready(function() {
            $('#leave_form').on('submit', function(event) {
                event.preventDefault();

                var no_of_days = document.getElementById("no_of_days").value;
                var leave_type = document.getElementById("leave_type").value;


                /*var leave_from = document.getElementById('leave_from').value;
                var leave_to = document.getElementById('leave_to').value;
                var remaining_balance = document.getElementById('remaining_balance').value;
                var half_remaining_balance = document.getElementById('half_remaining_balance').value;
                if (leave_type != 3) {
                    var leave_balance = remaining_balance;
                } else {
                    var leave_balance = 5000;
                }
                var half_leave_balance = half_remaining_balance;
                check_all_leave_validation(leave_type, leave_from, leave_to,
                    leave_balance);

                */

                var fileInput = document.getElementById('attachments');
                var filePath = fileInput.value;
                if (leave_type == 2) {
                    if (filePath) {
                        document.getElementById("attachments_msg").innerHTML = '';
                        $('#btnSave').attr('disabled', false);
                        var flag = 1;
                    } else {
                        document.getElementById("attachments_msg").innerHTML = 'This Field is required';
                        $('#btnSave').attr('disabled', true);
                        var flag = 2;
                    }
                } else if (leave_type == 5) {
                    if (no_of_days > 3) {
                        if (filePath) {
                            document.getElementById("attachments_msg").innerHTML = '';
                            $('#btnSave').attr('disabled', false);
                            var flag = 1;
                        } else {
                            document.getElementById("attachments_msg").innerHTML =
                                'This Field is required';
                            $('#btnSave').attr('disabled', true);
                            var flag = 2;
                        }
                    } else {
                        document.getElementById("attachments_msg").innerHTML = '';
                        $('#btnSave').attr('disabled', false);
                        var flag = 1;
                    }
                } else {
                    document.getElementById("attachments_msg").innerHTML = '';
                    $('#btnSave').attr('disabled', false);
                    var flag = 1;
                }

                if (flag == 1) {
					document.getElementById("myNav").style.width = "100%";
					$('#modal_form').modal('hide'); // Modal form hide
					$('#btnSave').attr('disabled', true); //set button disable 
                    url = "{{ URL::to('/leave-appliacation') }}";
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
							document.getElementById("myNav").style.width = "0%";
                            $('#btnSave').text('Submit for Approval'); //change button text
                            $('#btnSave').attr('disabled', false); //set button enable 
							$.gritter.add({
								title: 'Success!',
								text: message,
								sticky: false,
								class_name: 'gritter-light'
							});							
                            reload_table(); // List table reloaded
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                            $.gritter.add({
                                title: 'Error!',
                                text: 'Error to Save Data'
                            });
                            $('#btnSave').text('Submit for Approval'); //change button text
                            $('#btnSave').attr('disabled', false); //set button enable 
                        }
                    });
                }

            });
        });
        // LEAVE EDIT 
        function get_leave_info(id) {
            var url = "{{ URL::to('/get-leave-info') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + id,
                success: function(res) {
                    document.getElementById("application_id").value = res.application_id;
                    document.getElementById("application_date").value = res.application_date;
                    document.getElementById("leave_from").value = res.leave_from;
                    document.getElementById("leave_to").value = res.leave_to;
                    document.getElementById("leave_type").value = res.leave_type;
                    document.getElementById("remarks").value = res.remarks;
                    var date1 = new Date(res.leave_from);
                    var date2 = new Date(res.leave_to);
                    var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10);
                    document.getElementById('no_of_days').value = diffDays + 1;
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit: Leave Application'); // Set title to Bootstrap modal title
                }
            })
        }
        // LEAVE VIEW 
        function view_leave_info(id) {
            var url = "{{ URL::to('/get-leave-info') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + id,
                success: function(res) {
                    document.getElementById("v_application_date").value = res.application_date;
                    document.getElementById("v_leave_from").value = res.leave_from;
                    document.getElementById("v_leave_to").value = res.leave_to;
                    document.getElementById("v_leave_type").value = res.leave_type;
                    document.getElementById("v_remarks").innerHTML = res.remarks;
                    document.getElementById('v_no_of_days').value = res.no_of_days;
                    //id_sub_info
                    if (res.sub_reported_to != null) {

                        if (res.first_super_action == 1) {
                            var sub_action = 'Recommended';
                        } else if (res.first_super_action == 2) {
                            var sub_action = 'Rejected';
                        } else {
                            var sub_action = 'Pending...';
                        }
                        document.getElementById("id_first_supervisor").innerHTML = res.sub_supervisor_name +
                            ' ( ' +
                            res.sub_reported_to + ' )';
                        document.getElementById("id_first_super_action_date").innerHTML = res
                            .first_super_action_date;
                        document.getElementById("id_first_super_action").innerHTML = sub_action;
                        document.getElementById("id_first_super_remarks").innerHTML = res
                            .first_super_remarks;
                    } else {
                        var id_sub_info = document.getElementById("id_sub_info");
                        id_sub_info.style.display = "none";
                    }

                    if (res.super_action == 1) {
                        var supervisor_action = 'Approved'; 
                    } else if (res.super_action == 2) {
                        var supervisor_action = 'Rejected';
                    } else {
                        var supervisor_action = 'Pending...';
                    }
                    document.getElementById("id_supervisor").innerHTML = res.supervisor_name + ' ( ' +
                        res.reported_to + ' )';
                    document.getElementById("id_super_action_date").innerHTML = res.super_action_date;
                    document.getElementById("id_super_action").innerHTML = supervisor_action;
                    document.getElementById("id_super_remarks").innerHTML = res
                        .super_remarks;
						
					if(res.sub_reported_to != null && res.first_super_action == 0)
					{
						var supervisor_action_tr = document.getElementById("supervisor_action_tr");
						supervisor_action_tr.style.display = "none";
					}else if(res.sub_reported_to != null && res.first_super_action >0)
					{
						var supervisor_action_tr = document.getElementById("supervisor_action_tr");
						supervisor_action_tr.style.display = "";
					}						

                    $('#v_modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('View: Leave Application'); // Set title to Bootstrap modal title  
                }
            })
        }
        // LEAVE DELETE  
        function delete_application(id) {
            if (confirm('Are you sure to delete this data?')) {
                var message = 'Application Deleted Successfully';
                $.ajax({
                    url: "{{ url('delete_leave_application') }}" + "/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        reload_table();
                        if (data.del_status) {
                            $.gritter.add({
                                title: 'Success!',
                                text: message,
                                sticky: false,
                                class_name: 'gritter-light'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            }
        }

        function set_date() {

            $('#btnSave').attr('disabled', false);
            var application_date = document.getElementById('application_date').value;
            var leave_from = document.getElementById('leave_from').value;
            var leave_to = document.getElementById('leave_to').value;
            var leave_date = document.getElementById('leave_date').value;
            var apply_for = document.getElementById('apply_for').value;
            var leave_type = document.getElementById('leave_type').value;
            var remaining_balance = document.getElementById('remaining_balance').value;
            var half_remaining_balance = document.getElementById('half_remaining_balance').value;
            var casual_remaining_balance = document.getElementById('casual_remaining_balance').value;
            if (apply_for > 1) {
                var days = .5;
                document.getElementById('leave_date').value = leave_from;
                document.getElementById('leave_from').value = leave_date;
                document.getElementById('leave_to').value = leave_date;
                var leave_from_div = document.getElementById("leave_from_div");
                var leave_to_div = document.getElementById("leave_to_div");
                var leave_date_div = document.getElementById("leave_date_div");
                leave_from_div.style.display = "none";
                leave_to_div.style.display = "none";
                leave_date_div.style.display = "";
                document.getElementById('special').style.display = "none";
                check_all_leave_validation(leave_type, leave_from, leave_to, half_remaining_balance);
                document.getElementById('no_of_days').value = .5;
            } else {
                document.getElementById('leave_date').value = leave_from;
                document.getElementById('leave_from').value = leave_from;
                document.getElementById('leave_to').value = leave_to;
                if (leave_from < leave_to || leave_from == leave_to) {
                    if (leave_type == 1) {
                        var leave_balance = remaining_balance;
                    } else if (leave_type == 5) {
                        var leave_balance = casual_remaining_balance;
                    } else if (leave_type == 3) {
                        var leave_balance = 50000;
                    }
                    check_all_leave_validation(leave_type, leave_from, leave_to, leave_balance);
                } else {
                    document.getElementById('leave_dates').innerHTML = '';
                    document.getElementById('no_of_days').value = 0;
                    document.getElementById('general_message').innerHTML = '';
                    $('#btnSave').attr('disabled', true);
                }
                var leave_from_div = document.getElementById("leave_from_div");
                var leave_to_div = document.getElementById("leave_to_div");
                var leave_date_div = document.getElementById("leave_date_div");
                leave_from_div.style.display = "";
                leave_to_div.style.display = "";
                leave_date_div.style.display = "none";
                document.getElementById('special').style.display = "";
            }
            document.getElementById('attachments_msg').innerHTML = '';
            var leave_from_reset = document.getElementById('leave_from').value;
            var leave_to_reset = document.getElementById('leave_to').value;
            if (leave_to_reset < leave_from_reset) {
                //document.getElementById('leave_to_msg').innerHTML = 'Invaid Date';
                $('#btnSave').attr('disabled', true);
            } else {
                document.getElementById('leave_from_msg').innerHTML = '';
                document.getElementById('leave_to_msg').innerHTML = '';
                $('#btnSave').attr('disabled', false);
                //document.getElementById('leave_to').setAttribute("min", leave_from);
            }
        }

        function set_date_range() {
            $('#btnSave').attr('disabled', false);
            var leave_date = document.getElementById('leave_date').value;
            document.getElementById('leave_from').value = leave_date;
            document.getElementById('leave_to').value = leave_date;
            var leave_type = document.getElementById('leave_type').value;
            var days = .5;
            var half_remaining_balance = document.getElementById('half_remaining_balance').value;
            var half_leave_balance = half_remaining_balance;
            check_all_leave_validation(leave_type, leave_date, leave_date, half_leave_balance);
        }

        function set_types() {
            $('#btnSave').attr('disabled', false);
            var leave_category_sub_div = document.getElementById("leave_category_sub_div");
            var leave_category = document.getElementById('leave_category').value;
            document.getElementById('leave_type').value = leave_category;
            if (leave_category == 3) {
                leave_category_sub_div.style.display = "";
            } else {
                leave_category_sub_div.style.display = "none";
            }
            document.getElementById('attachments_msg').innerHTML = '';
            var leave_from = document.getElementById('leave_from').value;
            var leave_to = document.getElementById('leave_to').value;
            var leave_type = document.getElementById('leave_type').value;
            var remaining_balance = document.getElementById('remaining_balance').value;
            var casual_remaining_balance = document.getElementById('casual_remaining_balance').value;
            if (leave_type == 1) {
                var leave_balance = remaining_balance;
            } else if (leave_type == 5) {
                var leave_balance = casual_remaining_balance;
            } else if (leave_type == 3) {
                var leave_balance = 50000;
            }
            check_all_leave_validation(leave_type, leave_from, leave_to, leave_balance);
        }

        function set_types_2() {

            $('#btnSave').attr('disabled', false);
            var leave_category_sub = document.getElementById('leave_category_sub').value;
            document.getElementById('leave_type').value = leave_category_sub;
            document.getElementById('attachments_msg').innerHTML = '';
        }

        function fileValidation() {
            var fileInput = document.getElementById('attachments');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $('#btnSave').attr('disabled', true);
                document.getElementById("attachments_msg").innerHTML =
                    "Please upload file having extensions .jpeg/.jpg/.png/.gif and pdf only.";
                fileInput.value = '';
                return false;
            } else {
                $('#btnSave').attr('disabled', false);
                document.getElementById("attachments_msg").innerHTML = "";
                return true;
            }
        }


        function check_all_leave_validation(leave_type, leave_from, leave_to, leave_balance) { 
            var apply_for = document.getElementById('apply_for').value;
            var remaining_balance = document.getElementById('remaining_balance').value;
            var casual_remaining_balance = document.getElementById('casual_remaining_balance').value;
			if(apply_for == 1)
			{
				var balance = leave_balance;
			}
			else{
				if(leave_type == 1)
				{
					var balance = remaining_balance;
				}
				else if(leave_type == 5)
				{
					var balance = casual_remaining_balance;
				}
			}
            var url = "{{ URL::to('/get-leave-validation') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + leave_type + "/" + leave_from + "/" + leave_to + "/" + balance + "/" + apply_for,
                success: function(res) {
                    document.getElementById('leave_dates').innerHTML = res.leave_dates;
                    document.getElementById('general_message').innerHTML = res.message;
                    if (apply_for != 1) {
                        document.getElementById('no_of_days').value = .5;
                    } else {
                        document.getElementById('no_of_days').value = res.days;
                    }

                    if (res.flag == 0) {
                        $('#btnSave').attr('disabled', true);
                    } else {
                        $('#btnSave').attr('disabled', false);
                    }
					flag = res.flag;
                    return flag;
                }
            })
        }



        // LEAVE LIST START 
        var table_leave;
        $(document).ready(function() {
            table_leave = $('#table_leave').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "order": [
                    [2, "DESC"]
                ],
                "ajax": {
                    "url": "{{ URL::to('/all-leave_application') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
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
                        "data": "leave_type"
                    },
                    {
                        "data": "leave_from"
                    },
                    {
                        "data": "leave_to"
                    },
					{
                        "data": "no_of_days"
                    },
                    {
                        "data": "remarks",
                        "orderable": "false"
                    },
                    {
                        "data": "status",
                        "orderable": "false"
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
        // LEAVE LIST TABLE RELOAD 

        function reload_table() {
            table_leave.ajax.reload(null, false); //reload datatable ajax 
        }

    </script>


    <!-- Start Leave Application modal -->
    <div class="modal fade" id="modal_form" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                        style="color:red;">X</button>
                </div>
                <br>
                <form class="form-horizontal" role="form" method="POST" id="leave_form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <span id="post_method"></span>
                    <input type="hidden" name="emp_name" id="emp_name"
                        value="<?php echo $emp_name; ?>">
                    <input type="hidden" name="supervisor_email" id="supervisor_email"
                        value="<?php echo $supervisor_email; ?>">
                    <input type="hidden" name="sub_supervisor_email" id="sub_supervisor_email"
                        value="<?php echo $sub_supervisor_email; ?>">
                    <input type="hidden" name="sub_supervisors_emp_id" id="sub_supervisors_emp_id"
                        value="<?php echo $sub_supervisors_emp_id; ?>">
                    <input type="hidden" name="application_id" id="application_id" value="">
                    <input type="hidden" name="emp_id" id="emp_id"
                        value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="reported_to" id="reported_to"
                        value="<?php echo $report_to; ?>">
                    <input type="hidden" name="application_date" id="application_date"
                        value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="leave_type" id="leave_type" value="1">


                    <div class="form-group">
                        <label for="supervisor" class="col-sm-3 control-label">Application to</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"
                                value="<?php echo $report_to_show; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="leave_type" class="col-sm-3 control-label">Apply For</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="apply_for" id="apply_for" onchange="set_date();">
                                <option value="1">Full Day Leave</option>
                                <?php if ($emp_br == 9999) { ?>
                                <option value="2">Half Day Leave ( Morning )</option>
                                <option value="3">Half Day Leave ( Evening )</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="leave_type" class="col-sm-3 control-label">Leave Type</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="leave_category" id="leave_category" onchange="set_types();">
                                <option value="1" id="earned">Earned</option>
                                <option value="5" id="casual">Casual</option>
                                <option value="3" id="special">Special</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="leave_category_sub_div">
                        <label for="leave_type" class="col-sm-3 control-label">Special Type</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="leave_category_sub" id="leave_category_sub"
                                onchange="set_types_2();">
                                <?php foreach ($leave_types as $leave_type) { ?>
                                <option value="<?php echo $leave_type->id; ?>"><?php echo $leave_type->type_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="leave_date_div">
                        <label for="leave_date" class="col-sm-3 control-label">Leave Date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="leave_date" value="" onchange="set_date_range();"
                                required><span>
                        </div>
                    </div>
                    <div class="form-group" id="leave_from_div">
                        <label for="leave_from" class="col-sm-3 control-label">Leave Date From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="leave_from" name="leave_from" value="" min="2020-12-01"
                                onchange="set_date();" required><span id="leave_from_msg" style="color:red;"><span>
                        </div>
                    </div>
                    <div class="form-group" id="leave_to_div">
                        <label for="leave_to" class="col-sm-3 control-label">Leave Date To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="leave_to" name="leave_to" value=""
                                onchange="set_date();" required>
                            <span id="leave_to_msg" style="color:red;"><span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_of_days" class="col-sm-3 control-label">Leave Days</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="no_of_days" name="no_of_days" value="0" readonly>
                            <span id="general_message" style="color:red;"><span>
                        </div>
                    </div>
                    <div class="form-group" id="leave_dates_div">
                        <label for="no_of_days" class="col-sm-3 control-label">Leave Dates</label>
                        <div class="col-sm-8">
                            <textarea name="leave_dates" id="leave_dates" class="form-control" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="col-sm-3 control-label">Purpose of Leave</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="remarks" id="remarks" required
                                placeholder="Purpose of Leave"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="col-sm-3 control-label">Attachment</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="attachments" name="attachments"
                                onchange="return fileValidation()">
                            <span id="attachments_msg" style="color:red;"><span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="btnSave" id="btnSave" class="btn btn-primary"
                            value="Submit for Approval">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Leave Application modal -->


    <!-- Start view Leave modal -->
    <div class="modal fade" method="post" id="v_modal_form" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <br>

                <form class="form-horizontal" role="form" id="v_leave_form">

                    <input type="hidden" name="emp_id" id="emp_id"
                        value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="reported_to" id="reported_to"
                        value="<?php echo $report_to; ?>">

                    <div class="form-group">
                        <label for="supervisor" class="col-sm-3 control-label">Application Date</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="v_application_date" id="v_application_date"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supervisor" class="col-sm-3 control-label">Application to</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"
                                value="<?php echo $report_to_show; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="leave_type" class="col-sm-3 control-label">Leave Source</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="v_leave_type" id="v_leave_type" disabled readonly>
                                <?php foreach ($leave_types_all as $v_leave_types_all) { ?>
                                <option value="<?php echo $v_leave_types_all->id; ?>"><?php echo $v_leave_types_all->type_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="leave_from" class="col-sm-3 control-label">Date From</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="v_leave_from" name="v_leave_from" readonly><span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="leave_to" class="col-sm-3 control-label">Date To</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="v_leave_to" name="v_leave_to" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="v_no_of_days" class="col-sm-3 control-label">Leave Days</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="v_no_of_days" name="v_no_of_days" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="col-sm-3 control-label">Purpose of leave</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="v_remarks" id="v_remarks" readonly></textarea>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="35%">Supervisor</th>
                                    <th width="20%">Action Date</th>
                                    <th width="15%">Action</th>
                                    <th width="35%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="id_sub_info">
                                    <td id="id_first_supervisor"></td>
                                    <td id="id_first_super_action_date"></td>
                                    <td id="id_first_super_action"></td>
                                    <td id="id_first_super_remarks"></td>
                                </tr>
                                <tr id="supervisor_action_tr">
                                    <td id="id_supervisor"></td>
                                    <td id="id_super_action_date"></td>
                                    <td id="id_super_action"></td>
                                    <td id="id_super_remarks"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Bootstrap modal -->



    <!--Start Saiful -->
    <script>
        var table_visit;
        $(document).ready(function() {
            table_visit = $('#table_visit').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": {
                    "url": "{{ URL::to('/all_movement_application') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "sl",
                        "orderable": "false"
                    },
                    {
                        "data": "application_date"
                    },
                    {
                        "data": "destination"
                    },
                    {
                        "data": "from_date"
                    },
                    {
                        "data": "to_date"
                    },
					{
                        "data": "tot_day"
                    },
                    {
                        "data": "purpose",
                        "orderable": "false"
                    },
                    {
                        "data": "status",
                        "orderable": "false"
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


        function reload_table_visit() {
            table_visit.ajax.reload(null, false); //reload datatable ajax 
        }

    </script>

    <script src="{{ asset('public/admin_asset/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Start visit application modal -->
    <div class="modal fade" id="modal_visit_form" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <br>

                <form class="form-horizontal" method="POST" role="form" id="visit_form">
                    {{ csrf_field() }}
                    <span id="post_method_visit"></span>

                    <input type="hidden" name="move_id" id="move_id" value="">
                    <input type="hidden" name="visit_emp_id" id="visit_emp_id"
                        value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="visit_emp_name" id="visit_emp_name"
                        value="<?php echo $emp_name; ?>">
                    <input type="hidden" name="visit_reported_to" id="visit_reported_to"
                        value="<?php echo $report_to; ?>">
                    <input type="hidden" name="visit_sub_supervisors_emp_id" id="visit_sub_supervisors_emp_id"
                        value="<?php echo $sub_supervisors_emp_id; ?>">
                    <input type="hidden" name="visit_application_date" id="visit_application_date"
                        value="<?php echo date('Y-m-d'); ?>">
					<input type="hidden" name="visit_sub_supervisor_email" id="visit_sub_supervisor_email"
                        value="<?php echo $sub_supervisor_email; ?>">
                    <input type="hidden" name="visit_supervisor_email" id="visit_supervisor_email"
                        value="<?php echo $supervisor_email; ?>">

                    <div class="form-group">
                        <label for="supervisor" class="col-sm-3 control-label">Application to</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"
                                value="<?php echo $report_to_show; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="visit_type" class="col-sm-3 control-label">Visit Type</label>
                        <div class="col-sm-8">
                            <select onchange="change_visit_type();" name="visit_type" id="visit_type" class="form-control"
                                required>
                                <option value="1">Branch</option>
                                <option value="2">Any Destination</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="visit_type" class="col-sm-3 control-label">Destination</label>
                        <div class="col-sm-8">
                            <span id="branch_destination" style="display:block;">
                                <select name="destination_code[]" multiple="multiple" style="width: 100%;"
                                    id="destination_code" class="form-control select2" required>
                                    @foreach ($branch_list as $branch)
                                        <option value="{{ $branch->br_code }}" <?php if (in_array($branch->
                                            br_code, $destination_code)) {
                                            echo 'selected';
                                            } ?> >{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </span>
                            <span id="local_destination" style="display:none;">
                                <input type="text" class="form-control" name="loc_destination" id="loc_destination"
                                    placeholder="Write destination">
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="purpose" class="col-sm-3 control-label">Purpose</label>
                        <div class="col-sm-8">
                            <textarea id="purpose" name="purpose" class="form-control" rows="4" cols="50"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">Departure Date</label>
                        <div class="col-sm-4">
                            <input type="date" name="from_date" id="from_date" autocomplete="off" class="form-control"
                                onchange="set_date_visit()" value="" required><span id="visit_from_msg"
                                style="color:red;"></span>
                        </div>
                        <div class="col-sm-4">
                            <select id="leave_time" name="leave_time" onchange="set_date_visit()" class="form-control">
                                <option value="6.00 AM">6:00 AM</option>
                                <option value="6.30 AM">6:30 AM</option>
                                <option value="7.00 AM">7:00 AM</option>
                                <option value="7.30 AM">7:30 AM</option>
                                <option value="8.00 AM">8:00 AM</option>
                                <option value="8.30 AM">8:30 AM</option>
                                <option value="9.00 AM">9:00 AM</option>
                                <option value="9.30 AM">9:30 AM</option>
                                <option value="10.00 AM">10:00 AM</option>
                                <option value="10.30 AM">10:30 AM</option>
                                <option value="11.00 AM">11:00 AM</option>
                                <option value="11.30 AM">11:30 AM</option>
                                <option value="12.00 PM">12:00 PM</option>
                                <option value="12.30 PM">12:30 PM</option>
                                <option value="1.00 PM">01:00 PM</option>
                                <option value="1.30 PM">01:30 PM</option>
                                <option value="2.00 PM">02:00 PM</option>
                                <option value="2.30 PM">02:30 PM</option>
                                <option value="3.00 PM">03:00 PM</option>
                                <option value="3.30 PM">03:30 PM</option>
                                <option value="4.00 PM">04:00 PM</option>
                                <option value="4.30 PM">04:30 PM</option>
                                <option value="5.00 PM">05:00 PM</option>
                                <option value="5.30 PM">05:30 PM</option>
                                <option value="6.00 PM">06:00 PM</option>
                                <option value="6.00 PM">06:30 PM</option>
                                <option value="7.00 PM">07:00 PM</option>
                                <option value="7.30 PM">07:30 PM</option>
                                <option value="8.00 PM">08:00 PM</option>
                                <option value="8.30 PM">08:30 PM</option>
                                <option value="9.00 PM">09:00 PM</option>
                                <option value="9.30 PM">09:30 PM</option>
                                <option value="10.00 PM">10:00 PM</option>
                                <option value="10.30 PM">10:30 PM</option>
                                <option value="11.00 PM">11:00 PM</option>
                                <option value="11.30 PM">11:30 PM</option>
                                <option value="12.00 AM">12:00 AM</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="to_date" class="col-sm-3 control-label">Return Date</label>
                        <div class="col-sm-4">
                            <input type="date" name="to_date" id="to_date" autocomplete="off" onchange="set_date_visit()"
                                class="form-control" value="" required>
                            <span id="visit_to_msg" style="color:red;"></span>
                        </div>
                        <div class="col-sm-4">
                            <select id="arrival_time" name="arrival_time" onchange="set_date_visit()" class="form-control">
                                <option value="6.00 AM">6:00 AM</option>
                                <option value="6.30 AM">6:30 AM</option>
                                <option value="7.00 AM">7:00 AM</option>
                                <option value="7.30 AM">7:30 AM</option>
                                <option value="8.00 AM">8:00 AM</option>
                                <option value="8.30 AM">8:30 AM</option>
                                <option value="9.00 AM">9:00 AM</option>
                                <option value="9.30 AM">9:30 AM</option>
                                <option value="10.00 AM">10:00 AM</option>
                                <option value="10.30 AM">10:30 AM</option>
                                <option value="11.00 AM">11:00 AM</option>
                                <option value="11.30 AM">11:30 AM</option>
                                <option value="12.00 PM">12:00 PM</option>
                                <option value="12.30 PM">12:30 PM</option>
                                <option value="1.00 PM">01:00 PM</option>
                                <option value="1.30 PM">01:30 PM</option>
                                <option value="2.00 PM">02:00 PM</option>
                                <option value="2.30 PM">02:30 PM</option>
                                <option value="3.00 PM">03:00 PM</option>
                                <option value="3.30 PM">03:30 PM</option>
                                <option value="4.00 PM">04:00 PM</option>
                                <option value="4.30 PM">04:30 PM</option>
                                <option value="5.00 PM">05:00 PM</option>
                                <option value="5.30 PM">05:30 PM</option>
                                <option value="6.00 PM">06:00 PM</option>
                                <option value="6.00 PM">06:30 PM</option>
                                <option value="7.00 PM">07:00 PM</option>
                                <option value="7.30 PM">07:30 PM</option>
                                <option value="8.00 PM">08:00 PM</option>
                                <option value="8.30 PM">08:30 PM</option>
                                <option value="9.00 PM">09:00 PM</option>
                                <option value="9.30 PM">09:30 PM</option>
                                <option value="10.00 PM">10:00 PM</option>
                                <option value="10.30 PM">10:30 PM</option>
                                <option value="11.00 PM">11:00 PM</option>
                                <option value="11.30 PM">11:30 PM</option>
                                <option value="12.00 AM">12:00 AM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="is_need_vehicle_sup" class="col-sm-3 control-label">Need vehicle support ?</label>
                        <div class="col-sm-8">
                            <input type="radio" name="is_need_vehicle_sup" id="is_need_vehicle_sup1" class="flat-red"
                                value="1"> <label>&nbsp; Yes </label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="is_need_vehicle_sup" id="is_need_vehicle_sup2" class="flat-red"
                                value="2" checked><label>&nbsp; No </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="button" id="btnSave_visit" class="btn btn-primary" onclick="save_visit();">Submit for Approval</button>-->
                        <input type="submit" name="btnSave_visit" id="btnSave_visit" class="btn btn-primary"
                            value="Submit for Approval">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End visit application modal -->
    <!-- Start visit view modal -->

    <div class="modal fade" id="v_modal_form_visit" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <br>

                <form class="form-horizontal" role="form" id="v_visit_form">


                    <input type="hidden" name="v_emp_id_visit" id="v_emp_id_visit"
                        value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="v_reported_to_visit" id="v_reported_to_visit"
                        value="<?php echo $report_to; ?>">

                    <div class="form-group">
                        <label for="supervisor" class="col-sm-3 control-label">Application to</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"
                                value="<?php echo $report_to_show; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="v_visit_type" class="col-sm-3 control-label">Visit Type</label>
                        <div class="col-sm-8">

                            <select id="v_visit_type" class="form-control" readonly disabled>
                                <option value="1">Branch</option>
                                <option value="2">Any Destinations</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="visit_type" class="col-sm-3 control-label">Destination</label>
                        <div class="col-sm-8">
                            <span id="v_branch_destination" style="display:block;">
                                <select multiple="multiple" style="width: 100%;" id="v_destination_code"
                                    class="form-control select2" readonly disabled>
                                    @foreach ($branch_list as $branch)
                                        <option value="{{ $branch->br_code }}" <?php if (in_array($branch->
                                            br_code, $destination_code)) {
                                            echo 'selected';
                                            } ?>>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </span>
                            <span id="v_local_destination" style="display:none;">
                                <input list="v_local_list" class="form-control" id="v_loc_destination"
                                    placeholder="Write destination" disabled>
                                <datalist id="v_local_list">
                                    <option value="MRA">
                                    <option value="PKSF">
                                </datalist>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="purpose" class="col-sm-3 control-label">Purpose</label>
                        <div class="col-sm-8">
                            <textarea id="v_purpose" class="form-control" rows="4" cols="50" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">Departure Date</label>
                        <div class="col-sm-4">
                            <input type="date" id="v_from_date" autocomplete="off" class="form-control" value="" readonly>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" id="v_leave_time" value="" class="form-control" readonly>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="v_to_date" class="col-sm-3 control-label">Return Date</label>
                        <div class="col-sm-4">
                            <input type="date" id="v_to_date" autocomplete="off" class="form-control" value="" readonly>

                        </div>
                        <div class="col-sm-4">
                            <input type="text" id="v_arrival_time" value="" class="form-control" readonly>
                        </div>
                    </div>
					 <div class="form-group">
                        <label for="v_to_date" class="col-sm-3 control-label">Return Date (Actual)</label>
                        <div class="col-sm-4">
                            <input type="date" readonly id="v_return_date" autocomplete="off" class="form-control"
                                value="">
                        </div>
                        <div class="col-sm-4">
                             <input type="text" id="v_return_time" value="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="v_is_need_vehicle_sup" class="col-sm-3 control-label">Need vehicle Support ?</label>
                        <div class="col-sm-8">
							<input type="text" id="need_car" class="form-control" value="" readonly>
                        </div>
                    </div>
					
					<div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="35%">Supervisor</th>
                                    <th width="20%">Action Date</th>
                                    <th width="15%">Action</th>
                                    <th width="30%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="id_sub_info_visit">
                                    <td id="id_first_supervisor_visit"></td>
                                    <td id="id_first_super_action_date_visit"></td>
                                    <td id="id_first_super_action_visit"></td>
                                    <td id="id_first_super_remarks_visit"></td>
                                </tr>
                                <tr id="supervisor_action_tr_visit">
                                    <td id="id_supervisor_visit"></td>
                                    <td id="id_super_action_date_visit"></td>
                                    <td id="id_super_action_visit"></td>
                                    <td id="id_super_remarks_visit"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End visit view modal -->
    <!-- Start visit close modal -->
    <div class="modal fade" id="c_modal_form_visit" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <br>

                <form class="form-horizontal" role="form" id="c_visit_form">
                    {{ csrf_field() }} 
                   
                      
					 
                    <input type="hidden" name="c_visit_emp_name" id="c_visit_emp_name"
                        value="<?php echo $emp_name; ?>">  
                    <input type="hidden" name="c_visit_application_date" id="c_visit_application_date"
                        value="<?php echo date('Y-m-d'); ?>">

					<input type="hidden" name="visit_sub_supervisor_email_c" id="visit_sub_supervisor_email_c"
                        value="<?php echo $sub_supervisor_email; ?>">
                    <input type="hidden" name="visit_supervisor_email_c" id="visit_supervisor_email_c"
                        value="<?php echo $supervisor_email; ?>">
					
                    <input type="hidden" name="c_move_id" id="c_move_id" value="">
                    <input type="hidden" name="c_emp_id" id="c_emp_id"
                        value="<?php echo $emp_id; ?>">
                    <input type="hidden" name="visit_reported_to_c" id="visit_reported_to_c"
                        value="<?php echo $report_to; ?>">
                    <input type="hidden" name="visit_sub_supervisors_emp_id_c" id="visit_sub_supervisors_emp_id_c"
                        value="<?php echo $sub_supervisors_emp_id; ?>">

                    <div class="form-group">
                        <label for="supervisor" class="col-sm-3 control-label">Application to</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"
                                value="<?php echo $report_to_show; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="c_visit_type" class="col-sm-3 control-label">Visit Type</label>
                        <div class="col-sm-8">

                            <select id="c_visit_type" name="c_visit_type" class="form-control" required
                                style="pointer-events:none;">
                                <option value="1">Branch</option>
                                <option value="2">Any Destination</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="visit_type" class="col-sm-3 control-label">Destination</label>
                        <div class="col-sm-8">
                            <span id="c_branch_destination" style="display:block;">
                                <select multiple="multiple" style="width: 100%;" id="c_destination_code"
                                    name="c_destination_code[]" class="form-control select2">
                                    @foreach ($branch_list as $branch)
                                        <option value="{{ $branch->br_code }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </span>
                            <span id="c_local_destination" style="display:none;">
                                <input list="c_local_list" class="form-control" style="pointer-events:none;"
                                    id="c_loc_destination" name="c_loc_destination" placeholder="Write destination">
                                <datalist id="c_local_list">
                                    <option value="MRA">
                                    <option value="PKSF">
                                </datalist>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="purpose" class="col-sm-3 control-label">Purpose</label>
                        <div class="col-sm-8">
                            <textarea id="c_purpose" name="c_purpose" class="form-control" required rows="4" cols="50"
                                readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">Departure Date</label>
                        <div class="col-sm-4">
                            <input type="date" readonly id="c_from_date" name="c_from_date" autocomplete="off"
                                class="form-control" value="" required>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" readonly id="c_leave_time" name="c_leave_time" value="" class="form-control"
                                required>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="v_to_date" class="col-sm-3 control-label">Return Date</label>
                        <div class="col-sm-4">
                            <input type="date" readonly id="c_to_date" name="c_to_date" autocomplete="off"
                                class="form-control" value="" required>

                        </div>
                        <div class="col-sm-4">
                            <input type="text" readonly id="c_arrival_time" name="c_arrival_time" value=""
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="v_to_date" class="col-sm-3 control-label">Return Date (Actual)</label>
                        <div class="col-sm-4">
                            <input type="date" id="return_date" name="return_date" onchange="set_date_visit_close()" autocomplete="off" class="form-control"
                                value="" required>
								 <span id="visit_close_to_msg" style="color:red;"></span>
							<input type="hidden" id="pre_return_date" name="pre_return_date" autocomplete="off" class="form-control"
                                value="" required>
								<input type="hidden" id="pre_return_time" name="pre_return_time" autocomplete="off" class="form-control"
                                value="" required>

                        </div>
                        <div class="col-sm-4">
                            <select id="return_time" name="return_time" class="form-control" required>
                                <option value="6.00 AM">6:00 AM</option>
                                <option value="6.30 AM">6:30 AM</option>
                                <option value="7.00 AM">7:00 AM</option>
                                <option value="7.30 AM">7:30 AM</option>
                                <option value="8.00 AM">8:00 AM</option>
                                <option value="8.30 AM">8:30 AM</option>
                                <option value="9.00 AM">9:00 AM</option>
                                <option value="9.30 AM">9:30 AM</option>
                                <option value="10.00 AM">10:00 AM</option>
                                <option value="10.30 AM">10:30 AM</option>
                                <option value="11.00 AM">11:00 AM</option>
                                <option value="11.30 AM">11:30 AM</option>
                                <option value="12.00 PM">12:00 PM</option>
                                <option value="12.30 PM">12:30 PM</option>
                                <option value="1.00 PM">01:00 PM</option>
                                <option value="1.30 PM">01:30 PM</option>
                                <option value="2.00 PM">02:00 PM</option>
                                <option value="2.30 PM">02:30 PM</option>
                                <option value="3.00 PM">03:00 PM</option>
                                <option value="3.30 PM">03:30 PM</option>
                                <option value="4.00 PM">04:00 PM</option>
                                <option value="4.30 PM">04:30 PM</option>
                                <option value="5.00 PM">05:00 PM</option>
                                <option value="5.30 PM">05:30 PM</option>
                                <option value="6.00 PM">06:00 PM</option>
                                <option value="6.00 PM">06:30 PM</option>
                                <option value="7.00 PM">07:00 PM</option>
                                <option value="7.30 PM">07:30 PM</option>
                                <option value="8.00 PM">08:00 PM</option>
                                <option value="8.30 PM">08:30 PM</option>
                                <option value="9.00 PM">09:00 PM</option>
                                <option value="9.30 PM">09:30 PM</option>
                                <option value="10.00 PM">10:00 PM</option>
                                <option value="10.30 PM">10:30 PM</option>
                                <option value="11.00 PM">11:00 PM</option>
                                <option value="11.30 PM">11:30 PM</option>
                                <option value="12.00 AM">12:00 AM</option>
                            </select>
                        </div>
                    </div>
                    <!--<div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                           <label for="c_is_need_vehicle_sup" class="col-sm-3 control-label">Is need vehicle Support ?</label>
                                                                                                                                                                                                                                                                                                                                                                                                                           <div class="col-sm-8">
                                                                                                                                                                                                                                                                                                                                                                                                                            <input type="radio" name="c_is_need_vehicle_sup" id="c_is_need_vehicle_sup1" class="flat-red" value="1"> <label> Yes </label>
                                                                                                                                                                                                                                                                                                                                                                                                                            <label> No </label>
                                                                                                                                                                                                                                                                                                                                                                                                                           </div>
                                                                                                                                                                                                                                                                                                                                                                                                                          </div>-->

                    <input type="hidden" name="c_is_need_vehicle_sup" id="c_is_need_vehicle_sup" class="flat-red" value="">
                    <div class="modal-footer">
                        <button type="button" id="btnvisit_close" onclick="save_visit_close()" class="btn btn-primary">Visit
                            close</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End visit close modal -->

    <!-- Start Voucher modal -->
    <div class="modal fade" id="modal_visit_form_voucher" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" style="color:red;" data-dismiss="modal"
                        aria-hidden="true">Close</button>

                    <button type="button" onclick="javascript:printDiv('printme')" class="btn btn-default"><i
                            class="fa fa-print" aria-hidden="true"></i> Print</button>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div id="printme" class="box box-danger" style="width:90%;margin:auto;">
                            <div class="box-header with-border">
                                <center style="text-align:justfy;text-justify: inter-word;" id="with_header">
                                    <span class="box-title" style="text-align:left;">
                                        <img src="{{ asset(Session::get('org_logo')) }}" style="float:left;margin-top:0%;"
                                            width="50">
                                    </span> 
								 </center>
								 <center>
                                 <span style="font-size:18px;"> সেন্টার ফর ডেভেলপমেন্ট ইনোভেশন এন্ড প্র্যাকটিসেস (  সিদীপ ) <br></span>
                                        <hr style="width:75%;">
                                    <h4><u> যাতায়াত/ ভ্রমণ ও দৈনিক ভাতার বিল </u></h4>
                                </center>

                            </div>
                            <div class="col-md-12 table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:left;width:20%;">Name</th>
                                            <td style="text-align:left;width:30%;"><?php echo $emp_name; ?></td>
                                           
											 <th style="text-align:right;width:30%;">Bill Date</th>
                                            <td style="text-align:right;width:20%;"><?php echo date('d-m-Y');
                                                ?></td>
                                        </tr>
                                        <tr>
											 <th style="text-align:left;width:20%;">Emp ID </th>
                                            <td style="text-align:left;width:30%;"><?php echo $emp_id; ?></td>
                                            <th style="text-align:right;width:20%;">Branch</th>
                                            <td style="text-align:right;width:30%;"> Head Office</td>
                                           
                                        </tr> 
										<tr>
											 <th style="text-align:left;width:20%;">Purpose</th>
                                             <td style="text-align:left;width:30%;" id="visit_pupose"></td>
                                            
                                           
                                        </tr> 
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12 table-responsive" >
                               
                                <table width="100%" border="1">
									<br>
									 
                                    <thead>
										<tr>
											<td colspan="5" align="left">Travel Allowance </td>
										</tr>
                                        <tr>
                                            <th style="width:20%;text-align:center;">তারিখ</th>
                                            <th style="width:20%;text-align:center;">হইতে</th>
                                            <th style="width:20%;text-align:center;">পর্যন্ত</th>
                                            <th style="width:20%;text-align:center;">যাতায়াতের মাধ্যম</th>
                                            <th style="width:20%;text-align:center;">টাকা</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add_table">

                                    </tbody>
                                
                                    <thead>
										<tr>
											<td colspan="5" align="left">Food Allowance</td>
										</tr>
                                        <tr>
                                            <th style="text-align:center;">তারিখ</th>
                                            <th style="text-align:center;">সকাল</th>
                                            <th style="text-align:center;">দুপুর</th>
                                            <th style="text-align:center;">রাত</th>
                                            <th style="text-align:center;">টাকা</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add_table_bill">

                                    </tbody>
									<thead>
                                        <tr>
                                            <th colspan="4" style="text-align:right;width:20%;">সর্বমোট</th>
                                            <td style="text-align:right;width:15%;padding-right: 2px;" id="grand_total_m"><b></b>
                                            </td>

                                        </tr> 
										<tr>
                                            <th colspan="5"  style="text-align:left;width:10%">কথায়: <span id="tot_in_words"></span> </th> 
                                        </tr>
                                    </thead>
								 </table>
                                <br>
                            </div> 
                            <div class="col-md-12 table-responsive">
                                
                                <br>
                                <table width="100%" align="center">
                                    <tbody>
                                        <tr>
                                            <td>.................................</td>
                                            <td>.................................</td>
                                            <td width="34%">.................................</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                ভ্রমণকারীর স্বাক্ষর : </td>
                                            <td>
                                                যাচাইকারীর স্বাক্ষর : </td>.
                                            <td>
                                                অনুমোদনকারীর স্বাক্ষর :
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                আইডি নং : </td>
                                            <td>
                                                আইডি নং : </td>
                                            <td>
                                                আইডি নং :
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Voucher modal -->

    <script>
        function convertNumberToWords(amount) {
            var Words = ['', 'এক', 'দুই', 'তিন', 'চার', 'পাঁচ', 'ছয়', 'সাত', 'আট', 'নয়', 'দশ',
                'এগার', 'বার', 'তের', 'চৌদ্দ', 'পনের', 'ষোল', 'সতের', 'আঠার', 'ঊনিশ', 'বিশ',
                'একুশ', 'বাইশ', 'তেইশ', 'চব্বিশ', 'পঁচিশ', 'ছাব্বিশ', 'সাতাশ', 'আঠাশ', 'ঊনত্রিশ', 'ত্রিশ',
                'একত্রিশ', 'বত্রিশ', 'তেত্রিশ', 'চৌত্রিশ', 'পঁয়ত্রিশ', 'ছত্রিশ', 'সাঁইত্রিশ', 'আটত্রিশ', 'ঊনচল্লিশ',
                'চল্লিশ',
                'একচল্লিশ', 'বিয়াল্লিশ', 'তেতাল্লিশ', 'চুয়াল্লিশ', 'পঁয়তাল্লিশ', 'ছেচল্লিশ', 'সাতচল্লিশ', 'আটচল্লিশ',
                'ঊনপঞ্চাশ', 'পঞ্চাশ',
                'একান্ন', 'বায়ান্ন', 'তিপ্পান্ন', 'চুয়ান্ন', 'পঞ্চান্ন', 'ছাপ্পান্ন', 'সাতান্ন', 'আটান্ন', 'ঊনষাট',
                'ষাট',
                'একষট্টি', 'বাষট্টি', 'তেষট্টি', 'চৌষট্টি', 'পঁয়ষট্টি', 'ছেষট্টি', 'সাতষট্টি', 'আটষট্টি', 'ঊনসত্তর',
                'সত্তর',
                'একাতর', 'বাহাত্তর', 'তিয়াত্তর', 'চুয়াত্তর', 'পঁচাত্তর', 'ছিয়াত্তর', 'সাতাত্তর', 'আটাত্তর', 'ঊনআশি',
                'আশি',
                'একাশি', 'বিরাশি', 'তিরাশি', 'চুরাশি', 'পঁচাশি', 'ছিয়াশি', 'সাতাশি', 'আটাশি', 'ঊননব্বই', 'নব্বই',
                'একানব্বই', 'বিরানব্বই', 'তিরানব্বই', 'চুরানব্বই', 'পঁচানব্বই', 'ছিয়ানব্বই', 'সাতানব্বই', 'আটানব্বই',
                'নিরানব্বই'
            ];

            amount = amount.toString();
            var atemp = amount.split(".");
            var before_word = "";
            var after_word = "";
            var before_number = atemp[0];
            if (before_number !== "0") {
                before_word = toWord(before_number, Words);
            }
            if (atemp.length === 2) {
                var after_number = atemp[1];
                after_word = toWord(after_number, Words);
                if (before_word !== "") {
                    before_word += ' দশমিক ' + after_word;
                } else {
                    before_word += 'দশমিক ' + after_word;
                }
            }
            return before_word;
        }

        function toWord(number, words) {
            var n_length = number.length;
            var words_string = "";

            if (n_length <= 9) {
                var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                var received_n_array = new Array();
                for (var i = 0; i < n_length; i++) {
                    received_n_array[i] = number.substr(i, 1);
                }
                for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                    n_array[i] = received_n_array[j];
                }
                for (var i = 0, j = 1; i < 9; i++, j++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        if (n_array[i] == 1) {
                            n_array[j] = 10 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 2) {
                            n_array[j] = 20 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 3) {
                            n_array[j] = 30 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 4) {
                            n_array[j] = 40 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 5) {
                            n_array[j] = 50 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 6) {
                            n_array[j] = 60 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 7) {
                            n_array[j] = 70 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 8) {
                            n_array[j] = 80 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        } else if (n_array[i] == 9) {
                            n_array[j] = 90 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        }
                    }
                }

                var value = "";
                for (var i = 0; i < 9; i++) {
                    value = n_array[i];
                    if (value != 0) {
                        words_string += words[value] + "";
                    }
                    if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += " কোটি ";
                    }
                    if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += " লাখ ";
                    }
                    if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += " হাজার ";
                    } else if (i == 6 && value != 0) {
                        words_string += "শত ";
                    }
                }

                words_string = words_string.split("  ").join(" ");

            }
            return words_string;
        }

        function printDiv(divID) {
            var divToPrint = document.getElementById(divID);
            var htmlToPrint = '' +
                '<style type="text/css">' + '.with_pay_color {' +
                'background-color:none !important;color:black !important;' +
                '}' + '.margin_left {' +
                'margin: auto;width:45%;padding-left:50px !important;' +
                '}' + 'table {' +
                'border-collapse: collapse;' +
                '}' + 'body {' +
                'width:95%;' +
                'text-align: justify;' +
                '}' +
                '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }

        function add_voucher(move_id, visit_type) {
            //alert(move_id);
            $.ajax({
                type: 'get',
                url: "{{ URL::to('get_travel_bill_info') }}" + "/" + move_id + "/" + visit_type,
                dataType: "JSON",
                success: function(data) {
                    $('#modal_visit_form_voucher').modal('show');
                    //console.log(data);
                    var is_modal_save_show = 0;
                    var ta_sub_total = 0;
                    var da_sub_total = 0;
                     
                        //$("#ta_modal_table").show();
                        //$("#ta_modal_table").css("display", "block");
                        $("#add_table").empty();
                        $("#visit_pupose").empty();
                        var t_row = '';
						 document.getElementById("visit_pupose").innerHTML = data["visit_detail"]["purpose"];
                        for (var x in data["data"]) {
                            //alert();
                            //console.log(data["data"][x]["id"]);
                            ta_sub_total += parseFloat(data["data"][x]["travel_allowance"]);
                            if (visit_type == 1) {
                                t_row += "<tr><td style='text-align:center;'>" + data["data"][x][
                                    "travel_date"
                                ] + "</td><td style='text-align:center;'>" + data["data"][x][
                                    "source_branch_name"
                                ] + "</td><td style='text-align:center;'>" + data["data"][x][
                                    "destination_branch_name"
                                ] + "</td><td style='text-align:center;'>" + data["data"][x][
                                    "medium_trav"
                                ] + "</td><td style='text-align:right; padding-right: 2px;'>" + data["data"][x][
                                    "travel_allowance"
                                ] + "</td></tr>";
                            } else {
                                t_row += "<tr><td style='text-align:center;'>" + data["data"][x][
                                        "travel_date"
                                    ] + "</td><td style='text-align:center;'>" + data["data"][x][
                                        "source_br_code"
                                    ] + "</td><td style='text-align:center;'>" + data["data"][x][
                                        "dest_br_code"
                                    ] + "</td><td style='text-align:center;'>" + data["data"][x][
                                        "medium_trav"
                                    ] + "</td><td style='text-align:right; padding-right: 2px;'>" + data["data"][x][
                                        "travel_allowance"
                                    ] + "</td></tr>";
                            }

                            //alert(t_row);
                        }
						if(t_row == ''){
							t_row +=
                            "<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
                            0 + "</td></tr>";
						}else{
							t_row +=
                            "<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
                            ta_sub_total + "</td></tr>";
						}
                        

                        //alert(t_row);
                        $('#add_table').append(t_row);
                         
						 $("#add_table_bill").empty();
                     
                        var t_row = '';
                        for (var x in data["data_b"]) {
                            //alert();
                            //console.log(data["data"][x]["id"]);
                            da_sub_total += parseFloat(data["data_b"][x]["tot_amt"]);
                            t_row += "<tr><td style='text-align:center;width:20%;'>" + data["data_b"][x]["bill_date"] +
                                "</td><td style='text-align:center;width:20%;'>" + data["data_b"][x]["breakfast"] +
                                "</td><td style='text-align:center;width:20%;'>" + data["data_b"][x]["lunch"] +
                                "</td><td style='text-align:center;width:20%;'>" + data["data_b"][x]["dinner"] +
                                "</td><td style='text-align:right;width:20%;padding-right: 2px;'>" + data["data_b"][x]["tot_amt"] +
                                "</td></tr>";
                            //alert(t_row);
                        }
						if(t_row == ''){
							 t_row +=
                            "<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
                            0 + "</td></tr>";
						}else{
							 t_row +=
                            "<tr><th colspan='4' style='text-align:right;width:75%;padding-right: 2px;'>উপমোট</th><td style='text-align:right;width:15%;padding-right: 2px;'>" +
                            da_sub_total + "</td></tr>";
						}
                       
                        //alert(t_row);
						
                        $('#add_table_bill').append(t_row);
                      
                    

                    document.getElementById("grand_total_m").innerHTML = (ta_sub_total + da_sub_total);
                    document.getElementById("tot_in_words").innerHTML = (convertNumberToWords(ta_sub_total +
                        da_sub_total)) + ' টাকা মাত্র'; 
                }
            })
        }




        function add_visit() {
            $('#btnSave_visit').text('Submit for Approval'); //change button text
            document.getElementById("post_method_visit").innerHTML = "";
            $('#visit_form')[0].reset(); // reset form on modals
			document.getElementById("destination_code").value = '';
			 document.getElementById("loc_destination").value = '';
            $('#destination_code').trigger('change.select2');
            $("#branch_destination").attr("style", "display:block");
            $("#local_destination").attr("style", "display:none");
            $("#destination_code").attr("required", true);
            $("#loc_destination").attr("required", false); 
            $("#btnSave_visit").attr("disabled", false); 
			document.getElementById('visit_from_msg').innerHTML = '';
            document.getElementById('visit_to_msg').innerHTML = ''; 
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_visit_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add: Visit'); // Set Title to Bootstrap modal title
        }

        function change_visit_type() {
            var visit_type = document.getElementById("visit_type").value;
            if (visit_type == 1) {
                $("#branch_destination").attr("style", "display:block");
                $("#local_destination").attr("style", "display:none");
                $("#destination_code").attr("required", true);
                $("#loc_destination").attr("required", false);
            } else {
                $("#branch_destination").attr("style", "display:none");
                $("#local_destination").attr("style", "display:block");
                $("#destination_code").attr("required", false);
                $("#loc_destination").attr("required", true);
            }
        }

        $('.select2').select2();



	function set_date_visit() {
		  
            var visit_emp_id = document.getElementById('visit_emp_id').value;
            var from_date = document.getElementById('from_date').value;
            var to_date = document.getElementById('to_date').value;
            var leave_time = document.getElementById('leave_time').value; 
			var db_id = 0;
            if (to_date < from_date) {
				if(to_date != ''){
					 document.getElementById('visit_to_msg').innerHTML = 'Invaid Date';
				}else{
					 document.getElementById('visit_to_msg').innerHTML = '';
				}
               
                $('#btnSave_visit').attr('disabled', true); //set button disable 
            } else {
                document.getElementById('visit_from_msg').innerHTML = '';
                document.getElementById('visit_to_msg').innerHTML = '';
                $('#btnSave_visit').attr('disabled', false); //set button enable 
				
				 var url = "{{ URL::to('/visit_check_date') }}";
					$.ajax({
						type: "GET",
						url: url + "/" + visit_emp_id+ "/" + from_date+ "/" + to_date+ "/" + db_id+ "/" + leave_time,
						success: function(res) {
							//alert(res)
							console.log(res);
							if(res == 1){
								 $('#btnSave_visit').attr('disabled', false); 
							}else{
								 document.getElementById('visit_to_msg').innerHTML = 'Date already Exist!!!';
								 $('#btnSave_visit').attr('disabled', true); 
							}
						}
					}) 
            }
        } 
		function set_date_visit_close() {
            var visit_emp_id = document.getElementById('c_emp_id').value;
            var visit_close_from_date = document.getElementById('c_from_date').value;
            var pre_return_date = document.getElementById('pre_return_date').value;
            var visit_close_to_date = document.getElementById('return_date').value;
            var c_leave_time = document.getElementById('c_leave_time').value;
			var db_id = document.getElementById('c_move_id').value;  
            if (visit_close_to_date <= pre_return_date) {
                //document.getElementById('visit_to_msg').innerHTML = 'Invaid Date';
                $('#btnvisit_close').attr('disabled', false); //set button disable 
            } else {
                document.getElementById('visit_from_msg').innerHTML = '';
                document.getElementById('visit_close_to_msg').innerHTML = '';
                $('#btnvisit_close').attr('disabled', false); //set button enable 
				
				 var url = "{{ URL::to('/visit_check_date') }}";
					$.ajax({
						type: "GET",
						url: url + "/" + visit_emp_id+ "/" + visit_close_from_date+ "/" + visit_close_to_date+ "/" + db_id+ "/" + c_leave_time,
						success: function(res) {
							//alert(res)
							console.log(res);
							if(res == 1){
								 $('#btnvisit_close').attr('disabled', false); 
							}else{
								 document.getElementById('visit_close_to_msg').innerHTML = 'Date Already Exist!!!';
								 $('#btnvisit_close').attr('disabled', true); 
							}
						}
					}) 
            }
        }
        $(document).ready(function() {

            $('#visit_form').on('submit', function(event) {
                event.preventDefault();
				document.getElementById("myNav").style.width = "100%";
				$('#modal_visit_form').modal('hide'); 
                $('#btnSave_visit').attr('disabled', true); //set button disable
                url = "{{ URL::to('/movement_application') }}";
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
						document.getElementById("myNav").style.width = "0%";
                        $('#btnSave_visit').attr('disabled', false); //set button enable 
                        if (data.status == 2) {
                            document.getElementById("visit_to_msg").innerHTML = "<span style='color:red;'>Date already exist !!!</span>"; 
                            return false;
                        } else {
                            document.getElementById("destination_code").value = '';
                            $('#destination_code').trigger('change.select2');
                            document.getElementById("loc_destination").value = '';
                            $('#modal_visit_form').modal('hide'); // Modal form hide
                            reload_table_visit(); // List table reloaded
                            if (data.status) {
                                $.gritter.add({
                                    title: 'Success!',
                                    text: message,
                                    sticky: false,
                                    class_name: 'gritter-light'
                                });
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        $.gritter.add({
                            title: 'Error!',
                            text: 'Error to Save Data'
                        });
                        $('#btnSave_visit').text('Submit for Approval'); //change button text
                        $('#btnSave_visit').attr('disabled', false); //set button enable 
                    }
                });

            });
        });

        function view_move_info(id) {
            var url = "{{ URL::to('/get_move_info') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + id,
                success: function(res) {
                    document.getElementById("v_from_date").value = res.from_date;
                    document.getElementById("v_to_date").value = res.to_date;
                    document.getElementById("v_visit_type").value = res.visit_type;
                    document.getElementById("v_purpose").value = res.purpose;
                    if (res.is_need_vehicle_sup == 1) {
                        var need_car = 'Yes';
                    } else { 
						var need_car = 'No';                    
                    }
					document.getElementById("need_car").value = need_car;
                    document.getElementById("v_leave_time").value = res.leave_time;
                    document.getElementById("v_arrival_time").value = res.arrival_time;
					if(res.is_reopen == 1){ 
						document.getElementById("v_return_date").value = res.arrival_date; 
						document.getElementById("v_return_time").value = res.return_time; 
					}else{ 
						document.getElementById("v_return_date").value = res.to_date; 
						document.getElementById("v_return_time").value = res.arrival_time; 
					}
                    if (res.visit_type == 1) {
                        $("#v_branch_destination").attr("style", "display:block");
                        $("#v_local_destination").attr("style", "display:none");
                        $('#v_destination_code').val(res.destination_code);
                        $('#v_destination_code').trigger('change');
                    } else {
                        $("#v_branch_destination").attr("style", "display:none");
                        $("#v_local_destination").attr("style", "display:block");
                        document.getElementById("v_loc_destination").value = res.destination_code;
                    }
					
				
					 //id_sub_info
                    if (res.visit_sub_supervisors_emp_id != null) {
                        if (res.first_super_action == 1) {
                            var sub_action = 'Recommended';
                        } else if (res.first_super_action == 2) {
                            var sub_action = 'Rejected';
                        } else {
                            var sub_action = 'Pending...';
                        }
                        document.getElementById("id_first_supervisor_visit").innerHTML = res.sub_supervisor_name +
                            ' ( ' +
                            res.visit_sub_supervisors_emp_id + ' )';
                        document.getElementById("id_first_super_action_date_visit").innerHTML = res
                            .first_super_action_date;
                        document.getElementById("id_first_super_action_visit").innerHTML = sub_action;
                        document.getElementById("id_first_super_remarks_visit").innerHTML = res
                            .first_super_remarks;
                    } 
					else 
					{
                        var id_sub_info = document.getElementById("id_sub_info_visit");
                        id_sub_info.style.display = "none";
                    }
                    if (res.super_action == 1) {
                        var supervisor_action = 'Approved'; 
                    } else if (res.super_action == 2) {
                        var supervisor_action = 'Rejected';
                    } else { 
							var supervisor_action = 'Pending...'; 
                    }
                    document.getElementById("id_supervisor_visit").innerHTML = res.supervisor_name + ' ( ' +
                        res.visit_reported_to + ' )';
                    document.getElementById("id_super_action_date_visit").innerHTML = res.super_action_date;
                    document.getElementById("id_super_action_visit").innerHTML = supervisor_action;
                    document.getElementById("id_super_remarks_visit").innerHTML = res
                        .super_remarks;
						
					if(res.visit_sub_supervisors_emp_id != null && res.first_super_action == 0)
					{
						var supervisor_action_tr = document.getElementById("supervisor_action_tr_visit");
						supervisor_action_tr.style.display = "none";
					}else if(res.visit_sub_supervisors_emp_id != null && res.first_super_action >0)
					{
						var supervisor_action_tr = document.getElementById("supervisor_action_tr_visit");
						supervisor_action_tr.style.display = "";
					}
					
                    $('#v_modal_form_visit').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('View: Visit Application'); // Set title to Bootstrap modal title
                }
            })
        }

        function movement_close(id) {
            var url = "{{ URL::to('/movement_close') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + id,
                success: function(res) {
                    document.getElementById("c_move_id").value = res.move_id; 
                    document.getElementById("c_leave_time").value = res.leave_time; 
                    document.getElementById("c_from_date").value = res.from_date;
                    document.getElementById("c_arrival_time").value = res.arrival_time;
                    document.getElementById("c_to_date").value = res.to_date;
                    document.getElementById("c_visit_type").value = res.visit_type;
					
					if(res.is_reopen == 1){
						document.getElementById("pre_return_date").value = res.arrival_date; 
						document.getElementById("return_date").value = res.arrival_date; 
						document.getElementById("return_time").value = res.return_time;
						document.getElementById("pre_return_time").value = res.return_time;
					}else{
						document.getElementById("pre_return_date").value = res.to_date; 
						document.getElementById("return_date").value = res.to_date;  
						document.getElementById("return_time").value = res.arrival_time;
						document.getElementById("pre_return_time").value = res.arrival_time;
					}
                    if (res.visit_type == 1) {
                        $("#c_branch_destination").attr("style", "display:block");
                        $("#c_local_destination").attr("style", "display:none");
                        $('#c_destination_code').val(res.destination_code);
                        $('#c_destination_code').trigger('change');
                    } else {
                        $("#c_branch_destination").attr("style", "display:none");
                        $("#c_local_destination").attr("style", "display:block");
                        document.getElementById("c_loc_destination").value = res.destination_code;
                    }
					document.getElementById("return_date").min = res.from_date;
                    document.getElementById("c_purpose").value = res.purpose;
                    document.getElementById("c_is_need_vehicle_sup").value = res.is_need_vehicle_sup;
                    /* if(res.is_need_vehicle_sup == 1){
                    
                    document.getElementById("c_is_need_vehicle_sup1").checked = true;
                    document.getElementById("c_is_need_vehicle_sup2").checked = false;
                    }else{
                    document.getElementById("c_is_need_vehicle_sup1").checked = false;
                    document.getElementById("c_is_need_vehicle_sup2").checked = true;  
                    } */

                    $('#c_modal_form_visit').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('View: Visit Close'); // Set title to Bootstrap modal title
                }
            })
        }

        function save_visit_close() {
            var segment = 'save_visit_close';
			document.getElementById("myNav").style.width = "100%";
			$('#c_modal_form_visit').modal('hide'); 
            //$('#btnvisit_close').text('Saving...'); //change button text
            //$('#btnvisit_close').attr('disabled', true); //set button disable 
            url = "{{ URL::to('/') }}" + "/" + segment;
            message = 'Data Updated Successfully';
            $.ajax({
                url: url,
                type: "POST",
                data: $('#c_visit_form').serialize(),
                success: function(data) {
                    console.log(data);
					document.getElementById("myNav").style.width = "0%";
                    //$('#btnvisit_close').text('Submit for Approve'); //change button text
                    //$('#btnvisit_close').attr('disabled', false); //set button enable 
                    //$('#c_modal_form_visit').modal('hide'); // Modal form hide	
                    reload_table_visit(); // List table reloaded
                    if (data.status) {
                        $.gritter.add({
                            title: 'Success!',
                            text: message,
                            sticky: false,
                            class_name: 'gritter-light'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Error to Save Data'
                    });
                    $('#btnvisit_close').text('Submit for Approve'); //change button text
                    $('#btnvisit_close').attr('disabled', false); //set button enable 
                }
            });
        }

        function get_movement_info(id) {
            var url = "{{ URL::to('/get_movement_info') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + id,
                success: function(res) {
                    console.log(res);
                    document.getElementById("move_id").value = res.move_id;
                    //document.getElementById("application_date").value = res.application_date;
                    document.getElementById("from_date").value = res.from_date;
                    document.getElementById("to_date").value = res.to_date;
                    document.getElementById("visit_type").value = res.visit_type;
                    if (res.visit_type == 1) {
                        $("#branch_destination").attr("style", "display:block");
                        $("#local_destination").attr("style", "display:none");
                        $('#destination_code').val(res.destination_code);
                        $('#destination_code').trigger('change');
                        $("#destination_code").attr("required", true);
                        $("#loc_destination").attr("required", false);
                    } else {
                        $("#branch_destination").attr("style", "display:none");
                        $("#local_destination").attr("style", "display:block");
                        $("#destination_code").attr("required", false);
                        $("#loc_destination").attr("required", true);
                        document.getElementById("loc_destination").value = res.destination_code;
                    }


                    document.getElementById("arrival_time").value = res.arrival_time;
                    document.getElementById("leave_time").value = res.leave_time;
                    document.getElementById("purpose").value = res.purpose;
                    if (res.is_need_vehicle_sup == 1) {

                        document.getElementById("is_need_vehicle_sup1").checked = true;
                        document.getElementById("is_need_vehicle_sup2").checked = false;
                    } else {
                        document.getElementById("is_need_vehicle_sup1").checked = false;
                        document.getElementById("is_need_vehicle_sup2").checked = true;
                    }

                    $('#modal_visit_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit: Movement Application'); // Set title to Bootstrap modal title 
                }
            })
        }

        function delete_move_application(id, reference_id) {
            if (confirm('Are you sure to delete this data?')) {
                var message = 'Application Deleted Successfully';

                $.ajax({
                    url: "{{ url('delete_move_application') }}" + "/" + id + "/" + reference_id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        reload_table_visit(); // List table reloaded
                        if (data.del_status) {
                            $.gritter.add({
                                title: 'Success!',
                                text: message,
                                sticky: false,
                                class_name: 'gritter-light'
                            });
                        }

                        //$("#example1").load(location.href + " #example1");		
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });

            }
        }

    </script>

    <!--End Saiful -->






    <script>
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#Leave_and_Visit").addClass('active');
        });

    </script>

@endsection
