<?php $this->load->view('include/header'); ?>

<div class="container-fluid">
	<div class="login-panel">
		<center>
			<img style="width:100%;" src="<?php echo config_item('img'); ?>1.png" />
		</center>
		<div class='panel panel-default'>
			<div class='panel-body'>
				<?php echo form_open('secure', array('id' => 'FormLogin')); ?>
					<div class="form-group">
						<label>Username</label>
						<div class="input-group">
							<div class="input-group-addon">
								<span class='glyphicon glyphicon-user'></span>
							</div>
							<?php 
							echo form_input(array(
								'name' => 'username', 
								'class' => 'form-control', 
								'autocomplete' => 'off', 
								'autofocus' => 'autofocus'
							)); 
							?>
						</div>
					</div>
					<div class="form-group">
						<label>Password</label>
						<div class="input-group">
							<div class="input-group-addon">
								<span class='glyphicon glyphicon-lock'></span>
							</div>
							<?php 
							echo form_password(array(
								'name' => 'password', 
								'class' => 'form-control', 
								'id' => 'InputPassword'
							)); 
							?>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">
						<span class='glyphicon glyphicon-log-in' aria-hidden="true"></span> Sign In
					</button>
					<button type="reset" class="btn btn-default" id='ResetData'>Reset</button>
				<?php echo form_close(); ?>

				<div id='ResponseInput'></div>
			</div>
		</div>
		<!-- <p class='footer'><?php echo config_item('web_footer'); ?></p> -->
	</div>
</div>

<!-- <hr style='border-color:#999; border-style:dashed; '/>
<div class='container'>
<center>
LIST AKSES<br /><br />
<div class='row'>
<div class='col-sm-3'><b>Admin</b> <br />Username : admin<br />Password : admin</div>
<div class='col-sm-3'><b>Kasir</b> <br />Username : kasir<br />Password : kasir</div>
<div class='col-sm-3'><b>Gudang</b> <br />Username : jaka<br />Password : jaka</div>
<div class='col-sm-3'><b>Keuangan</b> <br />Username : joko<br />Password : joko</div>
</div>
</center>
</div> -->

<script>
$(function(){
	//------------------------Proses Login Ajax-------------------------//
	$('#FormLogin').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			cache: false,
			data: $(this).serialize(),
			dataType:'json',
			success: function(jsons){
				//response dari json_encode di controller
				console.log(jsons);
				if(jsons.status == 1){ window.location.href = jsons.url_home; }
				if(jsons.status == 0){ $('#ResponseInput').html(jsons.pesan); }
				if(jsons.status == 2){
					$('#ResponseInput').html(jsons.pesan);
					$('#InputPassword').val('');
				}
			}
		});
	});

	//-----------------------Ketika Tombol Reset Diklik-----------------//
	$('#ResetData').click(function(){
		$('#ResponseInput').html('');
	});
});
</script>

<?php $this->load->view('include/footer'); ?>


