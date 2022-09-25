<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); 
$printr = $this->session->userdata('print_data');
$dt_json = json_decode($printr);
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
        <td style="padding-left:5px;"> <?php echo $print_dt->OrderNo;?></td>
	</tr>
    <tr>
        <td>Tanggal</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo date('d-m-Y', strtotime($print_dt->TransctionDate));?></td>
	</tr>
	<tr>
        <td>Kasir</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo ucwords($this->session->userdata('ap_nama'));?></td>
	</tr>
	<tr>
        <td>Pelanggan</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo $print_dt->CustomerName;?></td>
	</tr>
    
    
</table>
<br/>
<div class='table-responsive'>
<table class="table table-striped table-bordered">
<tr>
<td style="width:8%;">Kode</td>
<td style="width:60%;">Item</td>
<td style="width:10%;">Harga</td>
<td style="width:5%;">Qty</td>
<td style="width:15%;">Subtotal</td>
</tr>
<?php
	$no = 1;
	$qty = 0;
	$sub_ttl = 0;
	$sb_ttl = 0;
	foreach($order_item as $kd){
		$qty = $kd->Qty;
		$sub_ttl = $qty * $kd->UnitPrice;
		$sb_ttl += $sub_ttl;
		echo '<tr>';
		echo '<td>'.$kd->ItemCode.'</td>';
		echo '<td>'.$kd->ItemName.'</td>';
		echo '<td align="right">'.str_replace(',', '.', number_format($kd->UnitPrice)).'</td>';
		echo '<td align="center">'.$qty.'</td>';
		echo '<td align="right">'.str_replace(',', '.', number_format($sub_ttl)).'</td>';
		//echo '<td align="right">'.str_replace(',', '.', number_format($kd->SubTotal)).'</td>';
		echo '</tr>';
		$no++;
	}
	echo '<tr>';
	echo '<td colspan="4" align="right">Sub total</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($sb_ttl)).'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="4" align="right">PPN(10%)</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($sb_ttl * (10/100))).'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="4" align="right">Total Bayar</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($print_dt->TotalBayar)).'</td>';
	echo '</tr>';
	foreach($sales_payment as $sp){
		echo '<tr>';
		echo '<td colspan="4" align="right">'.$sp->PaymentName.'</td>';
		echo '<td align="right">'.str_replace(',', '.', number_format($sp->PaymentAmount)).'</td>';
		echo '</tr>';
	}
	echo '<tr>';
	echo '<td colspan="4" align="right">Kembalian</td>';
	echo '<td align="right">'.str_replace(',', '.', number_format($print_dt->Kembalian)).'</td>';
	echo '</tr>';
?>
</table>
</div>
</div>

<button class="btn btn-success pull-right" onClick="printdiv('printableArea');" id="btn_print"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>
</div>
<script>
function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}
</script>