<?php
$data_order = $detail->SalesOrder;
if(!empty($data_order)){
	echo "
	    <input type='hidden' id='_no_order' value='".$data_order->OrderNo."'>
		<table class='info_pelanggan'>
			<tr>
				<td>Nama Pelanggan</td>
				<td>:</td>
				<td>".$data_order->CustomerName."</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>Jakarta</td>
			</tr>
			<tr>
				<td>Telp. / HP</td>
				<td>:</td>
				<td>".$data_order->PhoneNo."</td>
			</tr>
			
		</table>
		<hr />
		<input type='hidden' id='TglPrint' value='".date('d-m-Y H:i:s', strtotime($data_order->TransactionDate))."' />
		<input type='hidden' id='NotaPrint' value='".$data_order->OrderNo."' />
	";
}

?>

<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Harga Satuan</th>
			<th>Jumlah Beli</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$totalbayar = 0;
	$stringPayment = 0;
	$stringdetail = 0;
	foreach($data_order->SalesOrderLine as $d){
		echo "<tr>
				<td>".$no."</td>
				<td>".$d->ItemCode."</td>
				<td>".$d->ItemName."</td>
				<td align=''>".number_format($d->UnitPrice,2,',','.')."</td>
				<td align=''>".$d->Qty."</td>
				<td align=''>".number_format($d->SubTotal,2,',','.')."</td>
			</tr>";
		$no++;
		$totalbayar = $totalbayar + ($d->UnitPrice * $d->Qty);
		$stringdetail = $stringdetail . '@' . $d->ItemName . '#' . $d->Qty . '#' . str_replace(',', '.',number_format($d->UnitPrice)) . '#' . str_replace(',', '.',number_format($d->SubTotal));
	}
	$dv = 0;
	foreach($data_order->Payment as $dev){			
		$dv = $dev->DeliveryOrder;
	}
	echo "
		<tr style='background:#deeffc;'>
			<td colspan='5' style='text-align:right;'><b>Total</b></td>
			<td><b>Rp. ".number_format($totalbayar,2,',','.')."</b></td>
		</tr>		
		<tr style='background:#deeffc;'>
			<td colspan='5' style='text-align:right;'><b>Potongan</b></td>
			<td><b>Rp. ".number_format($totalbayar - ($data_order->TotalPembayaran - $dv),2,',','.')."</b></td>
		</tr>";
	//if (substr($data_order->OrderNo,1 ,5) == "ECOM") {
	echo  "	
	<tr style='background:#deeffc;'>
	<td colspan='5' style='text-align:right;'><b>Delivery</b></td>
	<td><b>Rp. ".number_format($dv,2,',','.')."</b></td>
	</tr>";
	//}
	echo "
		<tr style='background:#deeffc;'>
			<td colspan='5' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".number_format($data_order->TotalPembayaran,2,',','.')."</b></td>
		</tr>";
	foreach($data_order->Payment as $dp){
		echo "<tr style='background:#deeffc;'>";
		echo "<td colspan='5' style='text-align:right;'><b>".$dp->Description."</b></td>";
		echo "<td><b>Rp. ".number_format($dp->Nominal,2,',','.')."</b></td>";
		echo "</tr>";
		$stringPayment = $stringPayment . '@' . $dp->Description . '#' . str_replace(',', '.',number_format($dp->Nominal));
	}
	echo "<tr style='background:#deeffc;'>";
	echo '<td colspan="5" style="text-align:right;"><b>Kembalian</b></td>';
	echo '<td><b>Rp. '.number_format($data_order->Kembalian,2,',','.').'</b></td>';
	echo '</tr>';
	echo '<tr style="display:none">';
	echo '<td colspan="6" align="right">
			<input type="text" id="DetailProductPrint" value="'. $stringdetail .'" /> 
			<input type="text" id="SubtotalPrint" value="'. str_replace(',', '.',number_format($totalbayar)) .'" /> 
			<input type="text" id="PotonganPrint" value="'.str_replace(',', '.',number_format($totalbayar - $data_order->TotalPembayaran)).'" />
			<input type="text" id="GrandTotalPrint" value="'. str_replace(',', '.',number_format($data_order->TotalPembayaran)) .'" />
			<input type="text" id="Kembalian" value="'. str_replace(',', '.',number_format($data_order->Kembalian)) .'" />
			<input type="text" id="PaymentPrint" value="'. $stringPayment .'" />
			</td>';
	echo '</tr>';
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	//var Tombol = "<button type='button' class='btn btn-primary' id='Cetaks'><i class='fa fa-print'></i> Cetak</button>";
	var Tombol = "";
	 Tombol += "<button class='btn  btn-warning' onClick='showReceiptTermal();' id='btn_print'><i class='glyphicon glyphicon-print'></i> Print</button>&nbsp;<button type='button' class='btn btn-success btn_confirm'>Confirm</button>";
	$('#ModalFooter').html(Tombol);

	$('button#Cetaks').click(function(){
		var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
		FormData += "&tanggal="+encodeURI($('#tanggal').val());
		FormData += "&id_kasir="+$('#id_kasir').val();
		FormData += "&id_pelanggan="+$('#id_pelanggan').val();
		FormData += "&" + $('.tabel-transaksi tbody input').serialize();
		FormData += "&cash="+$('#UangCash').val();
		FormData += "&catatan="+encodeURI($('#catatan').val());
		FormData += "&grand_total="+$('#TotalBayarHidden').val();

		window.open("<?php echo site_url('penjualan/transaksi-cetak/?'); ?>" + FormData,'_blank');
	});
});
var countPrint = 0;
    function showReceiptTermal() {
		var ee = $("#StoreName").val();
		var hasil = ee.split('&');
		var stringResult = $("#StoreAddress").val() + "&" +
						$("#StoreCity").val() + "&" +
						$("#StorePostCode").val() + "&" +
						$("#StoreHP").val() + "&" +
						$("#TglPrint").val() + "&" +
						$("#NotaPrint").val() + "&" +
						hasil[0] + "&" +
						$("#DetailProductPrint").val() + "&" +
						$("#SubtotalPrint").val() + "&" +
						$("#PotonganPrint").val() + "&" +
						$("#GrandTotalPrint").val() + "&" +
						$("#PaymentPrint").val() + "&" +
						$("#Kembalian").val() + "&1&" + countPrint + "&0878-8338-1818.&" +  hasil[1] ;
						//console.log(stringResult);
        Android.showReceipt(stringResult);
		//countPrint = countPrint + 1;
    }
	$('.btn_confirm').click(function(){
		var no_order = $('#_no_order').val();
		$.ajax({
			url: "<?php echo site_url('penjualan/send_confirm'); ?>/"+no_order,
			type: "POST",
			cache: false,
			data: '',
			//dataType:'json',
			success: function(datas){
				console.log(datas);
				if(datas == 1){
					alert('Confirm Sukses');
					$('.btn_confirm').hide();
				}else{
					alert('Confirm Failed');
				}
			}
		});
	});
</script>