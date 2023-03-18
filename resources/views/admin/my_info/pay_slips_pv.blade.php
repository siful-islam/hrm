@extends('admin.admin_master')
@section('title', 'Pay-Slip')
@section('main_content')


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
    <section class="content">

        <div class="box box-default">
            <div class="box-body">

                <form class="form-inline" action="/action_page.php">

                    <div class="form-group">
                        <select name="salary_month" id="salary_month" class="form-control">
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="salary_year" id="salary_year" class="form-control">
                            <option value="2020">2020</option>
							<option value="2021">2021</option>
                        </select>
                    </div>
                    <button type="button" id="btnShow" onClick="get_pay_slip();" class="btn btn-success">Show</button>
                </form>
            </div>
        </div>


        <!-- Main content -->
        <section class="invoice" id="dynamic_content">

        </section>
        <!-- /.content -->
    </section>


    <script>
        var d = new Date();
        var m = d.getMonth();
        document.getElementById("salary_month").value = "<?php echo date('m')?>";
        document.getElementById("salary_year").value = "<?php echo date('Y')?>";
        //document.getElementById("salary_month").value = 12;


        function get_pay_slip() {
			$('#btnShow').attr('disabled', true);
			$('#btnShow').text('Loading.....');
            var month = document.getElementById("salary_month").value;
            var year = document.getElementById("salary_year").value;
            var salary_month = year + '-' + month + '-' + '01';
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            let current_datetime = new Date(salary_month)
            let formatted_date = months[current_datetime.getMonth()] + "-" + current_datetime.getFullYear()
            var url = "{{ URL::to('/get-pay-slip') }}";
            $.ajax({
                type: "GET",
                url: url + "/" + salary_month,
                success: function(res) {
					console.log(res);
                    //document.getElementById("formatted_date").innerHTML = formatted_date;
					$('#btnShow').attr('disabled', false);
					$('#btnShow').text('Show');
                    $("#dynamic_content").html(res);
                }
            })
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
	
	<script language="javascript" type="text/javascript">
        function printDiv_r(divID) {
            var divToPrint = document.getElementById(dynamic_content);
            var htmlToPrint = '' +
                '<style type="text/css">' + '.table-bordered th, .table-bordered td {' +
                'border:1px solid #000;padding:4px;' +
                '}' + 'h4 {' +
                'font-size: 20px;font-weight: 400;' +
                '}' + 'table {' +
                'border-collapse: collapse;' +
                'width:100%;' +
                '}' + 'body {' +
                'margin-left: 30px;' +
                '}' +
                '</style>';
            htmlToPrint += divID.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }
    </script>

    <script>
        //To active  menu.......//
        $(document).ready(function() {
            $("#MainGroupSelf_Care").addClass('active');
            $("#Pay_Slip").addClass('active');
        });

    </script>


@endsection
