
<?php $__env->startSection('main_content'); ?>
<style>
.content {
	padding-top: 5px;
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
</style>
<br/>
<br/>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><small>Board Member</small></h1>
</section>
<?php $user_type = Session::get('user_type'); ?>
<section class="content">
	<div class="row">
        <div class="col-md-12"> 
			<div class="box box-info" style="margin-bottom:10px;">
				<div class="box-body">
					<form class="form-inline report" action="<?php echo e(URL::to('/branch-staff-report')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="form-group">
							<input type="radio" id="body_id1" name="body_id" value="1" class="form-radio-input" /> <b>General Body</b> &nbsp;&nbsp;&nbsp;
							<input type="radio" id="body_id2" name="body_id" value="2" class="form-radio-input" /> <b>Governing Body</b> &nbsp;&nbsp;&nbsp;
						</div>
						<div class="form-group" id="board_serial" style="display: none;">
							<label for="board_no">Board No. :</label>
							<select name="board_no" id="board_no" required class="form-control">
								<?php foreach ($all_board_no as $board) { ?>
								<option value="<?php echo $board->board_no; ?>"><?php echo $board->board_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="Status">Status :</label>
							<select name="status" id="status" class="form-control">
								<option value="all" >All</option>
								<option value="1" >Active</option>
								<option value="0" >Inactive</option>
							</select>
						</div>
						<div class="form-group">
							<button type="button" onclick="javascript:printDiv('printme')" class="btn bg-navy"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>	
	<div class="row">
		<div id="printme">
			<div class="col-md-12">
				<p align="center"><b><font size="2">The Annual General Meeting of the Centre for Development Innovation and Practices held on 28 September, 2020</font></b><br/>		
				<b><font size="2"> The following <span id="abc"></span> elected for three years held on 28 September, 2020</font></b></p>		
			</div>
			<div class="col-md-12">
				<table class="table table-bordered" cellspacing="0">
					<thead>
						<tr>
							<th>SL No.</th>
							<th>Name</th>
							<th>Address</th>
							<th>Nationality</th>
							<th>Designation</th>
							<th>Reamrks</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="list_view">
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</section>
<script>
	$(document).ready(function(){
		$(':radio[value="1"]').attr('checked', true);
		var body_id1 = $('#body_id1').val();
		var board_no = 1;
		var status = 1;
		$('#status').val(status);
		$("#board_serial").hide();		
		$('#abc').html('General Body');
		getData(body_id1, board_no, status);
		
	});

	$("#body_id1").click(function(){
		var body_id1 = $('#body_id1').val();
		var board_no = 1;
		var status = 1;
		$('#status').val(status);
		$("#board_serial").hide();
		$('#abc').html('General Body');
		//alert (board_no);
		getData(body_id1, board_no, status);
		
	});

	$("#body_id2").click(function(){
		var body_id1 = $('#body_id2').val();
		var board_no = $('#board_no').val();
		var status = 'all';
		$('#status').val(status);
		$("#board_serial").show();
		$('#abc').html('Governing Body');
		//alert (board_no);
		getData(body_id1, board_no, status);
	});
	
	$("#board_no").on('change', function(){
		//var aa = $('input:radio[name="body_id"]:checked').val();
		var body_id1 = 2;
		var board_no = $('#board_no').val();
		var status = $('#status').val();
		$("#board_serial").show();
		$('#abc').html('Governing Body');
		//alert (board_no);
		getData(body_id1, board_no, status);
	});
	
	$("#status").on('change', function(){
		var aa = $('input:radio[name="body_id"]:checked').val();
		if (aa == 1) {
			var body_id1 = 1;
			var board_no = 1;
		} else {
			var body_id1 = 2;
			var board_no = $('#board_no').val();
		}
		//var board_no = $('#board_no').val();
		var status = $('#status').val();
		$('#abc').html('Governing Body');
		//alert (board_no);
		getData(body_id1, board_no, status);
	}); 
</script>
<script>
	function getData(body_id1, board_no, status) {
	
		$.ajax({
			url : "<?php echo e(url::to('board-member-views')); ?>"+"/"+ body_id1+"/"+ board_no+"/"+ status,
			type: "GET",			
			cache: false,
			dataType: 'json',
			success: function(dataResult){
                //console.log(dataResult);
                var resultData = dataResult.data;
                var t_row = '';
                var i=1;
                $.each(resultData,function(index,row){
                    var CvUrl = "<?php echo e(url::to('board-member')); ?>"+"/"+ row.id;
					t_row+="<tr>"
                    t_row+="<td>"+ i++ +"</td><td>"+row.name_eng+"</td><td>"+row.permanent_address+"</td><td>"+row.nationality+"</td>"
                    +"<td>"+row.designation_name+"</td>"+"<td>"+row.remarks+"</td>"+"<td>"+row.status+"</td>";
                    t_row+="</tr>";
                    
                })
                $("#list_view").html(t_row);
            }
			/* success: function(data) <a target='_blank' href='"+CvUrl+"'>"+row.name_eng+"</a>
			{
				console.log(data);
				var t_row = '';
				if (data != 0) {
				for(var i = 0; i < data.length; i++) {
				   var sl = i + 1;
				   t_row += "<tr>"
				   //t_row += "<td>"+ sl + "</td><td>"+ data[i].name_eng + "</td><td>" + data[i].permanent_address + "</td><td>" + data[i].nationality + "</td><td>" + data[i].designation_name + "</td><td>" + data[i].remarks + "</td><td>" + data[i].status + "</td>";
				   t_row += "<td>"+sl+"</td><td>"+data[i]["name_eng"]+"</td><td>"+data[i]["permanent_address"]+"</td><td>"+data[i]["nationality"]+"</td><td>"+data[i]["designation_name"]+"</td><td>"+data[i]["remarks"]+"</td><td>"+data[i]["status"]+"</td>";
				   t_row += "</tr>";
				}			
					$("#list_view").html(t_row);	      
				} else {		   
					$("#list_view").html('');	      
				}
			} */
		});
	}
</script>
<script>
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
			'}' +  
			'</style>';
		htmlToPrint += divToPrint.outerHTML;
		newWin = window.open("");
		newWin.document.write(htmlToPrint);
		newWin.print();
		newWin.close();
		//location.reload();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>