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
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?php
$level = $this->session->userdata('ap_level');
?>
<style>
table.dataTable thead .sorting_asc, .sorting_desc, .sorting {
    background-image: none !important;
}
</style>
<div class="container" style="width:100%">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-shopping-cart fa-fw'></i> REPORT <i class='fa fa-angle-right fa-fw'></i> SALES SUMMARY</h5>
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
		
			<div id='Datas'></div>
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
                    <h4 class="modal-title">List Detail Transaksi</h4>
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
<div class="modal fade" id="modal-default-payment">
        <div class="modal-dialog" style="width:70%">
            <div class="modal-content" style="width:100%; margin-left:-50">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">List Detail Transaksi By Payment Methode</h4>
                </div>
                <div class="modal-body">
                    <div id="message-payment"></div>
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


<script type="text/javascript">
$("#StoreId").select2();
$(function(){
    $('#export').click(function(){
     
    })
})
</script>
<script>
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
var url = '<?php echo site_url('ReportOwner_new/get_store');?>';
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
		var url = '<?php echo site_url('ReportOwner_new/load_chart');?>';
		e.preventDefault();

		var TanggalDari = $('#tanggal_dari').val();
		var TanggalSampai = $('#tanggal_sampai').val();

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
					generateChart();
					document.getElementById("lineChart").style.display = "block";
					document.getElementById("containerTopTen").style.display = "none";
					document.getElementById("containerPie").style.display = "block";
					document.getElementById("containerPieAmount").style.display = "block";
					document.getElementById("lblTable1").innerHTML = "Table Sales By Product Group ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";
					document.getElementById("lblTable2").innerHTML = "Table Sales Product ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";
					document.getElementById("lblTable3").innerHTML = "Chart Sales By Category ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";;
					document.getElementById("lblTable4").innerHTML = "Table Sales Product ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";
					document.getElementById("lblTable10").innerHTML = "Table Sales By Payment Methode ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";
					document.getElementById("containerPendapatanChart").style.display = "block";
					document.getElementById("TRCountDIV").innerHTML ="TOTAL NOTA <br><b style='font-size:20px; text-align:right'>" + $("#TRCount").val() + " </b>";
					document.getElementById("GrossDIV").innerHTML ="TOTAL PENJUALAN <br><b style='font-size:20px; text-align:right'>" + $("#GrossProfit").val() + " </b>";
					document.getElementById("NetDIV").innerHTML ="TOTAL PENJUALAN SETELAH DISKON <br><b style='font-size:20px';  text-align:right>" + $("#NetProfit").val() + " </b>";
					document.getElementById("TDiscDIV").innerHTML ="TOTAL NILAI DISKON <br><b style='font-size:20px';  text-align:right>" + $("#DiscProfit").val() + " </b>";
					document.getElementById("AvgDIV").innerHTML ="RATA-RATA PENJUALAN <br><b style='font-size:20px;  text-align:right'>" + $("#AVGProfit").val() + " </b>";
					document.getElementById("TotQtyDIV").innerHTML ="TOTAL QTY<br><b style='font-size:20px';  text-align:right>" + $("#TotalQty").val() + " </b>";
					
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
			//"order": [[ 0, "desc" ]],
			"language": {
				decimal: ",",
			}
		});
		$('#ProdutTopTen').dataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching" : true,
			"lengthChange": true,
			"order": [[ 3, "desc" ]],
			"language": {
				decimal: ",",
			}
		});
		$('#ProductPayment').dataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching" : true,
			"lengthChange": true,
			"language": {
				decimal: ",",
			}
		});

		$('#ReportProductList tbody').on('click', 'td a.details-control', function () {
			var tr = $(this).closest('tr');
			var childId = tr.data('child-value');

			$("#nota-detail-"+childId).modal();
		} );		
	}

	function dttabledetail(){
		$('#tblDetailProductGroup').dataTable({
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

	function dttabledetail_payment(){
		$('#tblDetailSalesPayment').dataTable({
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
	
	function generateChart(){
		var a = Highcharts.chart('containerPie', {
			data: {
				table: 'InvPostGroup'
			},
			chart: {
				type: 'pie'
			},
			title: {
				text: 'Data Qty By Category (Qty)'
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Quantity'
				}
			},
			tooltip: {
				//formatter: function () {
				//	return '<b>' + this.series.name + '</b><br/>' +
				//		this.point.y + ' ' + this.point.name.toLowerCase();
				//}
				pointFormat: '{series.name}: <b>{point.y} - ({point.percentage:.1f}%)</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					},
					events: {
						click: function(event) {
							ShowDetailPie(event.point.name.replace('.', ''), 'Qty');
						}
					}
				},
			}
		});
		var b = Highcharts.chart('containerTopTen', {
			data: {
				table: 'ProdutTopTenPie'
			},
			chart: {
				type: 'column'
			},
			title: {
				text: 'Data Top 10 Product'
			},
			
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Quantity'
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + ' ' + this.point.name.toLowerCase();
				}
			}
		});
		var d = Highcharts.chart('containerPendapatanChart', {
			data: {
				table: 'ReportPendapatanChart'
			},
			chart: {
				type: 'column'
			},
			title: {
				text: 'Data Sales'
			},xAxis: {
				type: 'datetime',
				labels: {
				format: '{value:%e/%b/%Y}'}
			},
				yAxis: {
				allowDecimals: false,
				title: {
					text: 'Amount'
				}
			},
			lang: {
				decimalPoint: '.',
				thousandsSep: ','
			},
			tooltip: {
				pointFormat: 'Total: <b>{point.y:,.0f}</b>',
				shared: true,
            	useHTML: true
			}
		});
		var mm = Highcharts.chart('containerTimeChart', {
			data: {
				table: 'ReportTimeChart'
			},
			chart: {
				type: 'column'
			},
			title: {
				text: 'Summary Transaction By Time'
			},
				yAxis: {
				allowDecimals: false,
				title: {
					text: 'Transaction'
				}
			},
			lang: {
				decimalPoint: '.',
				thousandsSep: ','
			},
			tooltip: {
				pointFormat: 'Total: <b>{point.y:,.0f}</b>',
				shared: true,
            	useHTML: true
			}
		});
		var c = Highcharts.chart('containerPieAmount', {
			data: {
				table: 'InvPostGroupAmount'
			},
			chart: {
				type: 'pie'
			},
			title: {
				text: 'Data Qty By Category (Amount)'
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Amount'
				}
			},
			tooltip: {
				//formatter: function () {
				//	return '<b>' + this.series.name + '</b><br/>' +
				//		this.point.y + ' ' + this.point.name.toLowerCase();
				//}
				pointFormat: '{series.name}: <b>{point.y} - ({point.percentage:.1f}%)</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					},
					events: {
						click: function(event) {
							ShowDetailPie(event.point.name.replace('.', ''), 'Amount');
						}
					}
				}
			}
		});
	}
	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
	"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

	function dateFormat(d){
	var t = new Date(d);
	return t.getDate()+'-'+monthNames[t.getMonth()]+'-'+t.getFullYear();
	}
	function ExportExcel(e){
		   //getting values of current time for generating the file name
        var dt = new Date();
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        var hour = dt.getHours();
        var mins = dt.getMinutes();
        var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
        //creating a temporary HTML link element (they support setting file names)
        var a = document.createElement('a');
        //getting data from our div that contains the HTML table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('TblTransExport');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        //setting the file name
        a.download = 'Exported_Sales_Vines_POS' + postfix + '.xls';
        //triggering the function
        a.click();
        //just in case, prevent default behaviour
        return false;//e.preventDefault();
	}

	function ExportExcel2(e){
		   //getting values of current time for generating the file name
        var dt = new Date();
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        var hour = dt.getHours();
        var mins = dt.getMinutes();
        var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
        //creating a temporary HTML link element (they support setting file names)
        var a = document.createElement('a');
        //getting data from our div that contains the HTML table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('TblPaymentExport');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        //setting the file name
        a.download = 'Exported_Payment_Vines_POS' + postfix + '.xls';
        //triggering the function
        a.click();
        //just in case, prevent default behaviour
        return false;//e.preventDefault();
	}

	function TampilkanProduct(){
		var location = $('#StoreId').select2("val");
		var html = '';
		var url = '<?php echo site_url('ReportOwner_new/loatTopTenCat');?>';
		//e.preventDefault();

		var TanggalDari = $('#tanggal_dari').val();
		var TanggalSampai = $('#tanggal_sampai').val();

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
				data : {StartDate : $('#tanggal_dari').val(), EndDate : $('#tanggal_sampai').val(), StoreCode : location.toString(), Category : $('#ddlCat').val()},
				url : url,
				type : "POST",
				beforeSend  : function(){ $('#container-loader-list').show(); },
				success:function(response){
					document.getElementById("toptendiv").innerHTML = response;
					$('#ProdutTopTen').dataTable({
						"paging":   true,
						"ordering": true,
						"info":     true,
						"searching" : true,
						"lengthChange": true,
						"order": [[ 3, "desc" ]],
						"language": {
							decimal: ",",
						}
					});
				}
			});	
		}
	};
	
	function ShowDetail(e) {
		var location = $('#StoreId').select2("val");
		document.getElementById("message").innerHTML = "";	
		var url = '<?php echo site_url('ReportOwner_new/load_detail_product_group');?>';
		$.ajax({
				data : {
					StartDate : $('#tanggal_dari').val(), 
					EndDate : $('#tanggal_sampai').val(), 
					StoreCode : location.toString(),
					ItemCode : $(e).attr("code"),
					ItemName : $(e).attr("itemname"),
					CatLoc : $(e).attr("CatLoc"),
					Tipe : 'Qty' },
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

	function ShowDetailPie(e, f) {
		var location = $('#StoreId').select2("val");
		document.getElementById("message").innerHTML = "";	
		var url = '<?php echo site_url('ReportOwner_new/load_detail_product_group');?>';
		$.ajax({
				data : {
					StartDate : $('#tanggal_dari').val(), 
					EndDate : $('#tanggal_sampai').val(), 
					StoreCode : location.toString(),
					Category : e,
					Tipe : f },
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
	
	function ShowDetailPayment(e) {
		var location = $('#StoreId').select2("val");
		document.getElementById("message").innerHTML = "";	
		var url = '<?php echo site_url('ReportOwner_new/load_detail_sales_payment');?>';
		$.ajax({
				data : {
					StartDate : $('#tanggal_dari').val(), 
					EndDate : $('#tanggal_sampai').val(), 
					StoreCode : location.toString(),
					ItemCode : $(e).attr("code"),
					ItemName : $(e).attr("itemname")},
				url : url,
				type : "POST",
				beforeSend  : function(){ $('#container-loader-list').show(); },
				success:function(response){
					document.getElementById("message-payment").innerHTML = response;
					dttabledetail_payment();			
					$("#modal-default-payment").modal();
				}
		});	
    }
</script>



<?php $this->load->view('include/footer'); ?>
