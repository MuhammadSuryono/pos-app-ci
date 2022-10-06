<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); 
$printr = $this->session->userdata('print_data');
$print_dt = $dt_json->SalesOrder;
$order_item =  $print_dt->SalesOrderLine;
$sales_payment =  $print_dt->SalesPayment;
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
<div id="printableArea">			
<!--<table style="width:100%;">
<thead>
	<tr>
	<td colspan="4" align="center"><?php echo $out['company_name'];?></td>
    </tr>
    <tr>
    <td colspan="4" align="center"><?php echo $out['alamat'].', '.$out['telp'].' email : '.$out['email'];?></td>
    </tr>
     <tr>
    <td colspan="4" align="center" style="vertical-align:top">-----------------------------------------------------------------------------------------------------------------------------------------</td>
    </tr>
    
</thead>

</table> 
<br /> -->

<table>
	<tr>
        <td>Nota</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo $header->no;?></td>
	</tr>
    <tr>
        <td>Tanggal</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo date('d-m-Y H:i:s', strtotime($header->Posting_Date . ' ' . $header->POSTransTime));?></td>
	</tr>
	<tr>
        <td>Kasir</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo ucwords($this->session->userdata('ap_nama'));?></td>
	</tr>
	<tr>
        <td>Pelanggan</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo $header->sellToCustomerName;?></td>
	</tr>
    
    
</table>
<input type="hidden" id="TglPrint" value="<?php echo date('d-m-Y H:i:s', strtotime($print_dt->TransctionDate));?>" />
<input type="hidden" id="NotaPrint" value="<?php echo $print_dt->OrderNo;?>" />
<br/>
<div class='table-responsive'>
<table class="table table-striped table-bordered">
<tr>
<td align="center" style="width:10%;">Kode</td>
<td align="left" style="width:60%;">Item</td>
<td align="center" style="width:10%;">Harga</td>
<td align="center" style="width:5%;">Qty</td>
<td align="center" style="width:5%;">Potongan</td>
<td align="center	" style="width:15%;">Subtotal</td>
</tr>

<?php
	$no = 1;
	$qty = 0;
	$sub_ttl = 0;
	$sb_ttl = 0;
	$sb = 0;
	$sb_vat = 0;
	$sb_ttl_vat = 0;
	$potongan = 0;
	$discount_vat = 0;
	$discount = 0;
	$totalbayar = 0;
	$ttl_disc_pjk = 0;
	$stringdetail = '';
	$stringPayment = '';
	foreach($lines as $kd){
		if ($kd->VATProdPostingGroup == 'NOVAT'){
			//$discount_vat = $kd->UnitPrice * ($kd->Discount / 100);
			$discount_vat = $kd->DiscountAmount;
			$sb_vat = $kd->quantity * $kd->unitPrice;
			$sb_ttl_vat = $sb_ttl_vat + $sb_vat; 
			//$sb_vat += $sb_vat;
			$potongan = $potongan + $discount_vat;
			//$potongan = $potongan + ($discount_vat * $kd->Qty);
            $name = $kd->description;
			echo '<tr>';
            echo '<td>'.$kd->no.'</td>';
            echo '<td>'.$kd->description.'</td>';
            echo '<td align="right">'.str_replace(',', '.', number_format($kd->unitPrice)).'</td>';
            echo '<td align="center">'.$kd->quantity.'</td>';
            echo '<td align="right">'.str_replace(',', '.', number_format($kd->DiscountAmount)).'</td>';
            echo '<td align="right">'.str_replace(',', '.', number_format(($kd->unitPrice * $kd->quantity) - $kd->DiscountAmount )).'</td>';
			echo '</tr>';

            $stringdetail = $stringdetail . '@' . $kd->description . '#' . $kd->quantity . '#' . str_replace(',', '.',number_format($kd->unitPrice)) . '#' . str_replace(',', '.',number_format($kd->DiscountAmount));
		} else{
			$discount = $kd->DiscountAmount;
			//$discount = $kd->UnitPrice * ($kd->Discount / 100);
			$qty = $kd->quantity;
			$sb  = $qty * $kd->unitPrice;
			$name = $kd->description;
			//$ttl_disc_pjk = $ttl_disc_pjk + ($discount * $kd->Qty);
			$sb_ttl = $sb_ttl + $sb;
			$potongan = $potongan + $discount;
			//$potongan = $potongan + ($discount * $kd->Qty);
 			echo '<tr>';
            echo '<td>'.$kd->no.'</td>';
            echo '<td>'.$kd->description.'</td>';
            echo '<td align="right">'.str_replace(',', '.', number_format($kd->unitPrice)).'</td>';
            echo '<td align="center">'.$kd->quantity.'</td>';
            echo '<td align="right">'.str_replace(',', '.', number_format($kd->DiscountAmount)).'</td>';
            echo '<td align="right">'.str_replace(',', '.', number_format(($kd->unitPrice * $kd->quantity) -$kd->DiscountAmount )).'</td>';
            echo '</tr>';
			$stringdetail = $stringdetail . '@' . $kd->description . '#' . $kd->quantity . '#' . str_replace(',', '.',number_format($kd->unitPrice)) . '#' . str_replace(',', '.',number_format($kd->DiscountAmount));
		}	
		$no++;
	}
	$totalbayar = ($sb_ttl_vat + $sb_ttl) - $potongan; // Hapus Pajak
	//$totalbayar = (($sb_ttl_vat + $sb_ttl) + (($sb_ttl - $ttl_disc_pjk) * (10/100))) - $potongan;
	echo '<tr>';
	echo '<td colspan="5" align="right">Sub total(NOPJK)</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($sb_ttl_vat)).'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="5" align="right">Sub total</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($sb_ttl)).'</td>';
	echo '</tr>';
	echo '<tr style="display:none;">';
	echo '<td colspan="5" align="right">PPN(10%)</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format(($sb_ttl - $ttl_disc_pjk) * (10/100))).'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="5" align="right">Potongan</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($potongan)).'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="5" align="right">Total Bayar</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($totalbayar)).'</td>';
	echo '</tr>';
    $totalPembayaran = 0;
	foreach($payment as $sp){
        $totalPembayaran += $sp->NominalPayment;
		echo '<tr>';
		echo '<td colspan="5" align="right">'.$sp->PaymentType.' - ' . $sp->PaymentMethodCode . '</td>';
		echo '<td align="right">'.str_replace(',', '.', number_format($sp->NominalPayment)).'</td>';
		echo '</tr>';
		$stringPayment = $stringPayment . '@' . $sp->PaymentType . '#' . str_replace(',', '.',number_format($sp->NominalPayment));
	}
	echo '<tr>';
	echo '<td colspan="5" align="right">Kembalian</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($totalPembayaran - $totalbayar)).'</td>';
	echo '</tr>';
	echo '<tr style="display:none">';
	$totalsub = $sb_ttl_vat + $sb_ttl;
	echo '<td colspan="6" align="right">
			<input type="text" id="DetailProductPrint" value="'. $stringdetail .'" /> 
			<input type="text" id="SubtotalPrint" value="'. str_replace(',', '.',number_format($totalsub)) .'" /> 
			<input type="text" id="PotonganPrint" value="'.str_replace(',', '.',number_format($potongan)).'" />
			<input type="text" id="GrandTotalPrint" value="'. str_replace(',', '.',number_format($totalbayar)) .'" />
			<input type="text" id="Kembalian" value="'. str_replace(',', '.',number_format($print_dt->Kembalian)) .'" />
			<input type="text" id="PaymentPrint" value="'. $stringPayment .'" />
			</td>';
	echo '</tr>';
?>
</table>
</div>
</div>

<button class="btn btn-success pull-right" onClick="showReceiptTermal();" id="btn_print"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>
</div>
<script type="text/javascript">
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
						$("#Kembalian").val() + "&1&" + countPrint + "&0878-8338-1818.&" +  hasil[1] + "&A&0" ;
						//console.log(stringResult);
        Android.showReceipt(stringResult);
		countPrint = countPrint + 1;
    }
</script>
<script>
function printdiv(printpage)
{
	
//var headstr = "<html><head><title></title></head><body>";
//var footstr = "</body>";
//var newstr = document.all.item(printpage).innerHTML;
//var oldstr = document.body.innerHTML;
//document.body.innerHTML = headstr+newstr+footstr;
//window.print();
//document.body.innerHTML = oldstr;
return false;
}
</script>
