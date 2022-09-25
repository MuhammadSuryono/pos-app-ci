<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>
<?php

//$printr = $this->session->userdata('print_data');
$dt_json = json_decode($penjualan);
$close_print = $dt_json->ClosePirnt;

//$print_dt = $dt_json->SalesOrder;
//$order_item =  $print_dt->SalesOrderLine;
//$sales_payment =  $print_dt->SalesPayment;
?>

<div class="container">
	<div class="panel panel-default col-md-4 col-md-offset-4">
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

</table> -->
<br />
<table>
	
    <tr>
        <td>Tanggal</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"><?php echo date('d-M-Y', strtotime($close_print->Tanggal));?> </td>
	</tr>
    <tr>
        <td>Store ID</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"><?php echo $close_print->StoreCode;?></td>
	</tr>
    <!--<tr>
        <td>User Code</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"><?php echo $close_print->Username;?> </td>
	</tr>-->
	<tr>
        <td>Kasir</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo ucwords($this->session->userdata('ap_nama'));?></td>
	</tr>
	
    
    
</table>
----------------------------------------------------------
<br/>
<br/>
<div class='table-responsive'>
<table>
	
    <tr>
        <td>Cash Awal</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"><?php echo number_format($close_print->OpenCash,2,',','.');?> </td> 
	</tr>
    <tr>
        <td>Cash</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"><?php echo number_format($close_print->Cash,2,',','.');?> </td> 
	</tr>
	<tr>
        <td>Cash Close</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo number_format($close_print->CloseCash,2,',','.');?></td> 
	</tr>
	<tr>
        <td>Selisih</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo number_format($close_print->Selisih,2,',','.');?></td>
	</tr>
    <tr>
        <td>Debit</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo number_format($close_print->Debit,2,',','.');?></td>  
	</tr>
    <tr>
        <td>Credit</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"> <?php echo number_format($close_print->Credit,2,',','.');?></td> 
	</tr>
    
    <tr>
        <td>Total Penjualan</td>
        <td style="padding-left:5px;">: </td>
        <td style="padding-left:5px;"><?php echo number_format($close_print->Total,2,',','.');?></td> 
	</tr>
    
</table>
</div>
</div>
<br/>
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