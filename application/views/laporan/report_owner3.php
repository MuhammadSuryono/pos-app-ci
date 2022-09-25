<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />	
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />		
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

<div class="container">
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
								<select name='Store' id="StoreId" class='form-control Store' style='cursor: pointer;'></select>
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

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>


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
var url = '<?php echo site_url('ReportOwner/get_store');?>';
$.ajax({
		url : url,
		type : "POST",
		success:function(response){
			var dt_json = JSON.parse(response);
			var paymentType = dt_json['Store'];
			$.each(paymentType, function( key, value ) {
				$('.Store').append($('<option/>').attr("value", value.Code).text(value.Name));
			});
		}
	});
});

$(document).on('click', '#TampilkanData', function(e){				
		var html = '';
		var url = '<?php echo site_url('ReportOwner/load_chart');?>';
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
				data : {StartDate : $('#tanggal_dari').val(), EndDate : $('#tanggal_sampai').val(), StoreCode :  $('#StoreId').val()},
				url : url,
				type : "POST",
				beforeSend  : function(){ $('#container-loader-list').show(); },
				success:function(response){		
					document.getElementById("Datas").innerHTML = response;				
					dttables();
					generateChart();
					document.getElementById("lineChart").style.display = "block";
					document.getElementById("containerTopTen").style.display = "block";
					document.getElementById("containerPie").style.display = "block";
					document.getElementById("containerPieAmount").style.display = "block";
					document.getElementById("lblTable1").innerHTML = "Table Top 10 ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";
					document.getElementById("lblTable2").innerHTML = "Table Sales Product ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";
					document.getElementById("lblTable3").innerHTML = "Chart Sales By Category ("+dateFormat(TanggalDari)+" / "+dateFormat(TanggalSampai)+")";;

					document.getElementById("containerPendapatanChart").style.display = "block";
					document.getElementById("TRCountDIV").innerHTML ="TOTAL TRANSACTION <br><b style='font-size:20px; text-align:right'>" + $("#TRCount").val() + " </b>";
					document.getElementById("GrossDIV").innerHTML ="GROSS SALES <br><b style='font-size:20px; text-align:right'>" + $("#GrossProfit").val() + " </b>";
					document.getElementById("NetDIV").innerHTML ="NET SALES <br><b style='font-size:20px';  text-align:right>" + $("#NetProfit").val() + " </b>";
					document.getElementById("AvgDIV").innerHTML ="AVG SALE PER TRANSCTION <br><b style='font-size:20px;  text-align:right'>" + $("#AVGProfit").val() + " </b>";
				}
			});	
		}
	});
	function dttables(){
		$('#ReportProductList').dataTable({
			"paging":   true,
			"ordering": false,
			"info":     false,
			"searching" : false,
			"lengthChange": false
		});
		$('#ProdutTopTen').dataTable({
			"paging":   false,
			"ordering": false,
			"info":     false,
			"searching" : false,
			"lengthChange": false
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
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + ' ' + this.point.name.toLowerCase();
				}
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
			},
			xAxis: {
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
				pointFormat: '<b>{'+ Highcharts.dateFormat('%e/%b/%Y', new Date(this.x))  +'} </b>'	 + 'Total: <b>{point.y:,.0f}</b>',
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
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + ' ' + this.point.name.toLowerCase();
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

</script>



<?php $this->load->view('include/footer'); ?>
