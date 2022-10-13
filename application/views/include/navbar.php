<?php
$controller = $this->router->fetch_class();
$level = $this->session->userdata('ap_level');
$available = $this->session->userdata('available');
?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url(); ?>">
				<b>VINES POS v.06</b>
			</a>
		</div>

		<!--<p class="navbar-text">Anda login sebagai <?php echo $this->session->userdata('ap_level_caption'); ?></p>-->
		<input type='hidden' name='' class='' id='StoreName' value="<?php echo  $this->session->userdata('ap_store_name');?>">
		<input type='hidden' name='' class='' id='StoreAddress' value="<?php echo  $this->session->userdata('ap_store_address');?>">
		<input type='hidden' name='' class='' id='StoreHP' value="<?php echo  $this->session->userdata('ap_store_HP');?>">
		<input type='hidden' name='' class='' id='StorePostCode' value="<?php echo  $this->session->userdata('ap_store_postcode');?>">
		<input type='hidden' name='' class='' id='StoreCity' value="<?php echo  $this->session->userdata('ap_store_city');?>">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<?php if($level == 'KASIR') { ?>
				<li class="dropdown <?php if($controller == 'penjualan') { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-shopping-cart fa-fw'></i> Penjualan <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('penjualan/transaksi'); ?>">Transaksi</a></li>
						<li><a href="<?php echo site_url('penjualan/history'); ?>">History Penjualan</a></li>
                        <!--<li><a href="<?php echo site_url('penjualan/history_shift'); ?>">History Penjualan Shift</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('penjualan/pelanggan'); ?>">Data Pelanggan</a></li>-->
					</ul>
				</li>
				<?php }           
                if($level == 'MANAGER') { ?>
				<li class="dropdown <?php if($controller == 'pengembalian') { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-shopping-cart fa-fw'></i> Return <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php if($level !== 'keuangan'){ ?>
						<li><a href="<?php echo site_url('pengembalian/transaksi'); ?>">Return</a></li>
						<?php } ?>
						<li><a href="<?php echo site_url('pengembalian/history'); ?>">History Return</a></li>	
					</ul>
				</li>
				<?php }
				if($level == 'KASIR') { ?>
					<li class="<?php if($controller == 'barang') { echo 'active'; } ?>"><a href="<?php echo site_url('barang'); ?>"><i class='fa fa-cube fa-fw'></i> List Barang</a></li>
				<?php }
				if($level == 'KASIR') { ?>
					<li class="dropdown <?php if($controller == 'laporan') { echo 'active'; } ?>">
<!--						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-file-text-o fa-fw'></i> Laporan <span class="caret"></span></a>-->
<!--						<ul class="dropdown-menu">-->
<!--							<li><a href="--><?php //echo site_url('laporan'); ?><!--">Laporan Penjualan</a></li>-->
<!--							--><?php //if($available == 1 ){ ?>
<!--							<li><a href="--><?php //echo site_url('laporan/open_close'); ?><!--">Laporan Open-Close</a></li>-->
<!--							--><?php //} ?>
						</ul>
					</li>   
				<?php }
				if($level == 'OWNER') { ?>
					<li class="<?php if($controller == 'reportowner') { echo 'active'; } ?>"><a href="<?php echo site_url('reportowner'); ?>"><i class='fa fa-cube fa-fw'></i> Report Penjualan</a></li>
					<li class="<?php if($controller == 'reportstock') { echo 'active'; } ?>"><a href="<?php echo site_url('reportstock'); ?>"><i class='fa fa-cube fa-fw'></i> Report Stock</a></li>
				<?php }      
				?> 
                <!--<li class="<?php if($controller == 'barang') { echo 'active'; } ?>"><a href="<?php echo site_url('good_receipt'); ?>"><i class='fa fa-cube fa-fw'></i> Terima Barang</a></li>-->	
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-user fa-fw'></i> <?php echo $this->session->userdata('ap_nama'); ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<!--<li><a href="<?php echo site_url('user/ubah-password'); ?>" id='GantiPass'>Ubah Password</a></li>
                        <li><a href="<?php echo site_url('setting'); ?>">Setting</a></li> 
						<li role="separator" class="divider"></li>-->
                        <!--<?php 
							if($available == 0 ){ ?>
                        <li><a href="<?php echo site_url('secure/close_v'); ?>"><i class='fa fa-close fa-fw'></i> Close Cash Register</a></li>
                        <?php } ?>-->
						<li><a href=""><i class='fa fa-minus fa-fw'></i><?php echo  $this->session->userdata('ap_store_name');?></a></li>
						<li><a href="<?php echo site_url('secure/logout'); ?>"><i class='fa fa-sign-out fa-fw'></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<script>
$(document).on('click', '#GantiPass', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Ubah Password');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});
</script>