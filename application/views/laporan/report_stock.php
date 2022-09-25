<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />	
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>		
<style>
#example88_paginate{
	float:right;
}
table.dataTable thead .sorting_asc, .sorting_desc, .sorting {
    background-image: none !important;
}
</style>
<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container" style="width:100%">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-shopping-cart fa-fw'></i> REPORT <i class='fa fa-angle-right fa-fw'></i> INVENTORY SUMMARY</h5>
			<hr />
			<div class="row">
			 <form class = "form-horizontal" role = "form">
			 <div class="col-sm-3">
					
						<div class="form-group">
							<label class="col-sm-6 control-label">Dari Tanggal</label>
							<div class="col-sm-6">
								<input type='text' name='from' class='form-control' id='tanggal_dari' value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
				
				</div>
				<div class="col-sm-3">
					
						<div class="form-group">
							<label class="col-sm-6 control-label">Sampai Tanggal</label>
							<div class="col-sm-6">
								<input type='text' name='to' class='form-control' id='tanggal_sampai' value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
				
				</div>
				<div class="col-sm-6">
					
						<div class="form-group">
							<label class="col-sm-4 control-label">Store</label>
							<div class="col-sm-8">
								<select name='Store' id="StoreId" class='form-control Store' style='cursor: pointer;' multiple></select>
							</div>
						</div>
					
				</div>
			 </form>
	
			</div>	
			<div class='row'>
				<div class="col-sm-12">
					<div class="form-horizontal">
						<div class="form-group">
							<div class="col-sm-12">
								<button type="button" id="TampilkanData" class="btn btn-primary pull-right" style='margin-left: 0px;'>Tampilkan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr id='lineChart2' style="display:block; border-top: 20px solid #eee">
			<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
			
			<!--<div id="containerTopTen" style="min-width: 310px; height: 400px; margin: 0 auto; display:none"></div>
			<div id="containerPendapatanChart" style="min-width: 310px; height: 400px; margin: 0 auto; display:none"></div>-->
		
			<div class='table-responsive' id='Datas'></div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-default">
        <div class="modal-dialog" style="width:70%">
            <div class="modal-content" style="width:100%; margin-left:-50">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">List Item Detail</h4>
                </div>
                <div class="modal-body">
                    <div id="message"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>

<script>
$("#StoreId").select2();
$('#tanggal_dari').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	closeOnDateSelect:true
});
$('#tanggal_sampai').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	closeOnDateSelect:true
});
$(document).ready(function(){

var url = '<?php echo site_url('ReportStock/get_store');?>';
$.ajax({
		url : url,
		type : "POST",
		success:function(response){
			var dt_json = JSON.parse(response);
			var paymentType = dt_json['Store'];
			$('.Store').append($('<option/>').attr("value", "").text("--All Store--"));
			$.each(paymentType, function( key, value ) {
				$('.Store').append($('<option/>').attr("value", value.Code).text(value.Name));
			});
		}
	});
});

$(document).on('click', '#TampilkanData', function(e){
	    var location = $('#StoreId').select2("val");
		var html = '';
		var url = '<?php echo site_url('ReportStock/load_chart');?>';
		var TanggalDari = $('#tanggal_dari').val();
		var TanggalSampai = $('#tanggal_sampai').val();
		e.preventDefault();
        if(TanggalDari == '' || TanggalSampai == '')
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html("Tanggal harus diisi !");
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
			$('#ModalGue').modal('show');
		}
		else
		{		
			$.ajax({
				data : {StartDate : $('#tanggal_dari').val(), EndDate : $('#tanggal_sampai').val(), StoreCode : location.toString() },
				url : url,
				type : "POST",
				beforeSend  : function(){ $('#container-loader-list').show(); },
				success:function(response){		
					document.getElementById("Datas").innerHTML = response;				
					dttables();									
				}
			});	
		}
	});
	function dttables(){
		$('#ReportProductList').dataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching" : true,
			"lengthChange": true,
			"language": {
				decimal: ",",
			}
		});
		$('#ReportProductList1').dataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching" : true,
			"lengthChange": true,
			"language": {
				decimal: ",",
			}
		});
		$('#ReportProductList2').dataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching" : true,
			"lengthChange": true,
			"language": {
				decimal: ",",
			}
		});
	}
	function dttabledetail(){
		$('#ReportProductList4').dataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching" : true,
			"lengthChange": true,
			"language": {
				decimal: ",",
			}
		});
	};
	
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
	"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

	function dateFormat(d){
		var t = new Date(d);
		return t.getDate()+'-'+monthNames[t.getMonth()]+'-'+t.getFullYear();
	}
	function ExportData(e) {
        //getting values of current time for generating the file name
        var dt = new Date();
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear()
        var hour = dt.getHours();
        var mins = dt.getMinutes();
        var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
        //creating a temporary HTML link element (they support setting file names)
        var a = document.createElement('a');
        //getting data from our div that contains the HTML table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('exportdata');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        //setting the file name
        a.download = 'Exported_STOCK_' + postfix + '.xls';
        //triggering the function
        a.click();
        //just in case, prevent default behaviour
        return false;
	};
	function ShowDetail(e) {
		var location = $('#StoreId').select2("val");
		document.getElementById("message").innerHTML = "";	
		var url = '<?php echo site_url('ReportStock/load_chart_Detail');?>';
		$.ajax({
				data : {
					StartDate : $('#tanggal_dari').val(), 
					EndDate : $('#tanggal_sampai').val(), 
					StoreCode : location.toString(),
					ItemCode : $(e).attr("code"),
					Tipe : $(e).attr("tipe"),
					SubTipe : $(e).attr("subtipe"),
					ItemName : $(e).attr("itemname")},
				url : url,
				type : "POST",
				beforeSend  : function(){ $('#container-loader-list').show(); },
				success:function(response){		
					document.getElementById("message").innerHTML = response;
					dttabledetail()				
					$("#modal-default").modal();
				}
		});	
    }
</script>



<?php $this->load->view('include/footer'); ?>
