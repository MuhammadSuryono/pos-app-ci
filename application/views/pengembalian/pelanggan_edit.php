<?php echo form_open('penjualan/pelanggan-edit/'.$pelanggan->id_pelanggan, array('id' => 'FormEditPelanggan')); ?>

<div class='form-group'>
	<label>Nama</label>
	<?php
	echo form_input(array(
		'name' => 'nama', 
		'class' => 'form-control',
		'value' => $pelanggan->nama
	));
	?>
</div>
<div class='form-group'>
	<label>Alamat</label>
	<?php
	echo form_textarea(array(
		'name' => 'alamat', 
		'class' => 'form-control',
		'value' => $pelanggan->alamat,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
</div>
<div class='form-group'>
	<label>Nomor Telepon / Handphone</label>
	<?php
	echo form_input(array(
		'name' => 'telepon', 
		'class' => 'form-control',
		'value' => $pelanggan->telp
	));
	?>
</div>
<div class='form-group'>
	<label>Info Tambahan Lainnya</label>
	<?php
	echo form_textarea(array(
		'name' => 'info', 
		'class' => 'form-control',
		'value' => $pelanggan->info_tambahan,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
</div>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditPelanggan()
{
	$.ajax({
		url: $('#FormEditPelanggan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditPelanggan').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditPelanggan'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditPelanggan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditPelanggan').click(function(e){
		e.preventDefault();
		EditPelanggan();
	});

	$('#FormEditPelanggan').submit(function(e){
		e.preventDefault();
		EditPelanggan();
	});
});
</script>