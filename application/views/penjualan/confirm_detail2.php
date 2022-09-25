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
	}

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
	}
	echo '<tr>';
	echo '<td colspan="5" style="text-align:right;"><b>Kembalian</b></td>';
	echo '<td><b>Rp. '.number_format($data_order->Kembalian,2,',','.').'</b></td>';
	echo '</tr>';
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	var Tombol = "";
	 Tombol += "<button type='button' class='btn btn-success btn_confirm'>Confirm</button>";
	$('#ModalFooter').html(Tombol);

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
});


</script>