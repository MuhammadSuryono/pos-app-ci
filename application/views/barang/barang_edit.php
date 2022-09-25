<?php echo form_open('barang/edit/'.$barang->id_barang, array('id' => 'FormEditBarang')); ?>
<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label">Kode Barang</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'kode_barang',
				'class' => 'form-control',
				'value' => $barang->kode_barang
			));
			echo form_hidden('kode_barang_old', $barang->kode_barang);
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Nama Barang</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'nama_barang',
				'class' => 'form-control',
				'value' => $barang->nama_barang
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Kategori</label>
		<div class="col-sm-8">
			<select name='id_kategori_barang' class='form-control'>
				<option value=''></option>
				<?php
				foreach($kategori->result() as $k)
				{
					$selected = '';
					if($barang->id_kategori_barang == $k->id_kategori_barang){
						$selected = 'selected';
					}
					
					echo "<option value='".$k->id_kategori_barang."' ".$selected.">".$k->kategori."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Point</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'point',
				'class' => 'form-control',
				'value' => ''
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Merek</label>
		<div class="col-sm-8">
			<select name='id_merk_barang' class='form-control'>
				<option value=''></option>
				<?php
				foreach($merek->result() as $m)
				{
					$selected = '';
					if($barang->id_merk_barang == $m->id_merk_barang){
						$selected = 'selected';
					}

					echo "<option value='".$m->id_merk_barang."' ".$selected.">".$m->merk."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Stok</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'total_stok',
				'class' => 'form-control',
				'value' => $barang->total_stok
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Harga</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'harga',
				'class' => 'form-control',
				'value' => $barang->harga
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Keterangan</label>
		<div class="col-sm-8">
			<textarea name='keterangan' class='form-control' rows='3' style='resize:vertical;'><?php echo $barang->keterangan; ?></textarea>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditBarang'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('#SimpanEditBarang').click(function(){
		$.ajax({
			url: $('#FormEditBarang').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditBarang').serialize(),
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
	});
});
</script>