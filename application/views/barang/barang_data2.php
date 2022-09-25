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
			<h5><i class='fa fa-cube fa-fw'></i> Barang <i class='fa fa-angle-right fa-fw'></i> Semua Barang</h5>
			<hr />

			<div class='table-responsive'>
				
				<table id="example88" class="table table-striped table-bordered">
					<thead>
						<tr>
							
							<th style="text-align:center;">Kode</th>
							<th style="text-align:center;"">Name</th>
							<th style="text-align:center;">Category</th>
							<th style="text-align:center;">Point</th>
							<th style="text-align:center;">Brand</th>
							<th style="text-align:center;">Stock</th>
							<th style="text-align:center;">Price</th>
							<th style="text-align:center;">Discount(%)</th>
							
						</tr>
					</thead>
                    <tbody>
                    <?php 
						if(!empty($itemku->Item)){
							
							foreach($itemku->Item as $it){
								echo '<tr>';
								echo '<td>'.$it->Code.'</td>';
								echo '<td>'.$it->Name.'</td>';
								echo '<td>'.$it->Category.'</td>';
								echo '<td>'.$it->Point.'</td>';
								echo '<td>'.$it->Brand.'</td>';
								echo '<td>'.$it->Stock.'</td>';
								echo '<td align="right">'.number_format($it->Harga,2,',','.').'</td>';
								echo '<td>'.$it->Discount.'</td>';
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