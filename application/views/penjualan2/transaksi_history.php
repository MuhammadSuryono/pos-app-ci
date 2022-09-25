<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>
<link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />	
<style>
#example88_paginate{
	float:right;
}
</style>
<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> History Penjualan</h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="example88" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="text-align:center" width="5%">No.</th>
							<th style="text-align:center">Tanggal</th>
							<th style="text-align:center">Nomor Nota</th>
							<th style="text-align:center">Grand Total</th>
							<th style="text-align:center">Pelanggan</th>
							<th style="text-align:center">Kasir</th>
							
						</tr>
					</thead>
                    <tbody>
                        <?php 
							$i = 1;
							if(!empty($sales_order->SalesOrder)){
								foreach($sales_order->SalesOrder as $so){
									
									echo '<tr>';
									echo '<td align="center">'.$i.'.</td>';
									echo '<td>'.date('d-M-Y', strtotime($so->TransactionDate)).'</td>';
									
									echo '<td><a href="'.site_url('penjualan/detail_transaksi/'.$so->OrderNo).'" id="LihatDetailTransaksi"><i class="fa fa-file-text-o fa-fw"></i> '.$so->OrderNo.'</a></td>';
									echo '<td align="right">'.number_format($so->TotalPembayaran,2,',','.').'</td>';
									echo '<td>'.$so->CustomerName.'</td>';
									echo '<td>'.$so->KasirName.'</td>';
									echo '</tr>';
									$i++;
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<?php
$tambahan = nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
?>
<script src="<?php echo base_url(); ?>assets/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


<script type="text/javascript" language="javascript" >
	$(function() {
    	$('#example88').dataTable({});
	});
	

	$(document).on('click', '#LihatDetailTransaksi', function(e){
		e.preventDefault();
		var CaptionHeader = 'Transaksi Nomor Nota ' + $(this).text();
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-lg');
		$('#ModalHeader').html(CaptionHeader);
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Tutup</button>");
		$('#ModalGue').modal('show');
	});
</script>


<?php $this->load->view('include/footer'); ?>