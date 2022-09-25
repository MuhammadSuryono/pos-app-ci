<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<style>
.footer {
	margin-bottom: 22px;
}
.panel-primary .form-group {
	margin-bottom: 10px;
}
.form-control {
	border-radius: 0px;
	box-shadow: none;
}
.error_validasi { margin-top: 0px; }
</style>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}
?>

<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
				<div class='col-sm-12'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Laporan</div>
						<div class="panel-body">

							<h2 align="center" style="color:red;"><b>Under Construction</b></h2>

						</div>
					</div>
					
				</div>
				
			</div>

		</div>
	</div>

<p class='footer'><?php echo config_item('web_footer'); ?></p>
<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>

<?php $this->load->view('include/footer'); ?>