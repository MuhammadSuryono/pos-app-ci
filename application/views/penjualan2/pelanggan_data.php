<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />	
<style>
#example88_paginate{
	float:right;
}
</style>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> Data Pelanggan</h5>
			<hr />

			<div class='table-responsive'>
				
				<table id="example88" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Nama Pelanggan</th>
							<th>Alamat</th>
							<th>Telp. / HP</th>
						</tr>
                     </thead>
                     <tbody>
                        <?php 
							$address2 = '';
							if(!empty($pelanggan->Customer)){
								foreach($pelanggan->Customer as $pc){
									$address2 = '';
									if(!empty($pc->Address2)){
										$address2 = '- '.$pc->Address2;
									}
									echo '<tr>';
									echo '<td>'.$pc->Name.'</td>';
									echo '<td>'.$pc->Address.' '.$address2.'</td>';
									echo '<td>'.$pc->PhoneNo.'</td>';
									echo '</tr>';
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
<script src="<?php echo base_url(); ?>assets/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">

$(function() {
    $('#example88').dataTable({});
});

</script>
<?php $this->load->view('include/footer'); ?>