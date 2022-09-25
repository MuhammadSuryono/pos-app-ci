<?php
$data_order = $detail->ReturOrder;
if(!empty($data_order)){
	echo "
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
	$no 			= 1;
	
	foreach($data_order->ReturOrderLine as $d){
		echo "<tr>
				<td>".$no."</td>
				<td>".$d->ItemCode."</td>
				<td>".$d->ItemName."</td>
				<td align=''>".number_format($d->UnitPrice,2,',','.')."</td>
				<td align=''>".$d->Qty."</td>
				<td align=''>".number_format($d->SubTotal,2,',','.')."</td>
			</tr>";
		$no++;
	}

	echo "
		<tr style='background:#deeffc;'>
			<td colspan='5' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".number_format($data_order->TotalPembayaran,2,',','.')."</b></td>
		</tr>";
	//foreach($data_order->Payment as $dp){
		//echo "<tr style='background:#deeffc;'>";
		//echo "<td colspan='5' style='text-align:right;'><b>".$dp->Description."</b></td>";
		//echo "<td><b>Rp. ".number_format($dp->Nominal,2,',','.')."</b></td>";
		//echo "</tr>";
	//}
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	//var Tombol = "<button type='button' class='btn btn-primary' id='Cetaks'><i class='fa fa-print'></i> Cetak</button>";
	var Tombol = "";
	 Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
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
</script>