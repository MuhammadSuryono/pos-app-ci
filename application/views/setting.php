<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-cube fa-fw'></i> Setting </h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
                
                <?php if($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
		                    <i class="fa fa-check"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data berhasil disimpan.
		                </div>
					</div><br />
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
		                    <i class="fa fa-warning"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
		                </div>
					</div><br />
				<?php } 
				
				?>

                <div class="form-group">
					<?php 
					echo form_open('');
					//nama sekolah
					$data = array(
		              'name'        => 'company_name',
		              'id'			=> 'company_name',
		              'class'		=> 'form-control',
		              'value'       => $company_name,		   
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Company Name', 'company_name');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'telp',
		              'id'			=> 'telp',
		              'class'		=> 'form-control',
		              'value'       => $telp,		           
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Telp', 'telp');
					echo form_input($data);
					echo '<br>';
					
					//hp ketua
					$data = array(
		              'name'        => 'email',
		              'id'			=> 'email',
		              'class'		=> 'form-control',
		              'value'       => $email,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Email', 'email');
					echo form_input($data);
					echo '<br>';

					$data = array(
		              'name'        => 'alamat',
		              'id'			=> 'alamat',
		              'class'		=> 'form-control',
		              'value'       => $alamat,		              
		              'style'       => 'width: 100%'
	            	);
					echo form_label('Alamat', 'alamat');
					echo form_textarea($data);
					echo '<br>';
					
					// submit
					$data = array(
				    'name' 		=> 'submit',
				    'id' 		=> 'submit',
				    'class' 	=> 'btn btn-primary',
				    'value'		=> 'true',
				    'type'	 	=> 'submit',
				    'content' 	=> 'Update'
					);
					//echo '<br>';
					echo form_button($data);


					echo form_close();

					?>
				</div>
				
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<?php
$tambahan = '';
if($level == 'admin' OR $level == 'inventory')
{
	$tambahan .= nbs(2)."<a href='".site_url('barang/tambah')."' class='btn btn-default' id='TambahBarang'><i class='fa fa-plus fa-fw'></i> Tambah Barang</a>";
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
}
?>


<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>