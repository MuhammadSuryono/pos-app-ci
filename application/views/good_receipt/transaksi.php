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
$level 		= '';
$readonly	= '';
$disabled	= '';
$available = $this->session->userdata('available');

?>
<form id="frm_receipt">
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body" style="min-height:500px;">

			<div class='row'>
				<div class='col-sm-3'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota</div>
						<div class="panel-body">

							<div class="form-horizontal">
                            <input type='hidden' name='nomor_nota_trans' class='form-control input-sm' id='nomor_nota_trans' value="<?php echo $this->session->userdata('ap_id_user'); ?>" <?php echo $readonly; ?>>
                            
                             <input type='hidden' name='id_kasir' class='form-control input-sm' id='id_kasir' value="<?php echo $this->session->userdata('ap_id_user'); ?>" >
								<div class="form-group">
									<label class="col-sm-4 control-label">No. Nota</label>
									<div class="col-sm-8">
										<select name='nomor_nota' id='nomor_nota' class='select2 form-control input-sm'>
                                        <option value="">-- Pilih -- </option>
                                        <?php
										
											if(!empty($nota->PurchaseNo)){
												foreach($nota->PurchaseNo as $n){
													 echo '<option value='.$n->DocNo.'>'.$n->DocNo.'</option>';
												}
											}
										?>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-8">
										<input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>" >
									</div>
								</div>
								<div class="form-group" style="display:none;">
									<label class="col-sm-4 control-label">Kasir</label>
									<div class="col-sm-8">
										<div id='kasir'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
							</div>

						</div>
					</div>
					
				</div>
				<div class='col-sm-9'>
					<h5 class='judul-transaksi'>
						<i class='fa fa-shopping-cart fa-fw'></i> Terima Barang <i class='fa fa-angle-right fa-fw'></i> Transaksi
						<a href="<?php echo site_url('good_receipt'); ?>" class='pull-right'><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a>
					</h5>
					<table class='table table-bordered' id='TabelPengembalian'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:210px;'>Kode Barang</th>
								<th>Nama Barang</th>
								
								<th style='width:75px;'>Qty</th>
								<th style='width:125px;'>Qty Receipt</th>
								
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					
					<div class='row'>
						 <div class='col-sm-7'>
						
						</div> 
						<div class='col-sm-5'>
							<div class="form-horizontal">
								
                                
                               
								<div class='row'>
									<div class='col-sm-6' style='padding-right: 0px;'>
									
									</div>
									<div class='col-sm-6'>
										<button type='button' class='btn btn-primary btn-block' id='Simpann'>
											<i class='fa fa-floppy-o'></i> Simpan
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<br />
				</div>
			</div>

		</div>
	</div>
</div>
</form>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>

<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$(".select2").select2();
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});

$(document).ready(function(){
	
	$('#nomor_nota').change(function(){
		var html = '';
		if($(this).val() !== ''){
			$("#TabelTransaksi").find("tr:gt(0)").remove();
			$("#TabelBayar").find("tr:gt(0)").remove();
			
			$.ajax({
				url: "<?php echo site_url('good_receipt/ajax_nota'); ?>",
				type: "POST",
				cache: false,
				data: "no_nota="+$(this).val(),
				dataType:'json',
				success: function(json){
					for(var i = 0; i < json.banyak_baris; i++){
						var no = Number(i)+1;
						html +='<tr>';
						html +='<td>'+no+'.</td>';
						html +='<td>'+json.kode_barang[i]+'</td>';
						html +='<td>'+json.nama_brg[i]+'</td>';
						
						html +='<td>'+json.jml_beli[i]+'</td>';
						
						html +='<td align="center"><input type="hidden" class="form-control input-sm" name="kode_barang[]" value="'+json.kode_barang[i]+'" rel="'+json.kode_barang[i]+'"><input type="hidden" class="form-control input-sm" name="line_no[]" value="'+json.line_no[i]+'" rel="'+json.line_no[i]+'"><input type="text" class="form-control input-sm qty_receipt" name="qty_receipt[]" value="'+json.jml_beli[i]+'" class="qty_receipt" id="qty_receipt_'+json.kode_barang[i]+'" onkeyup="input_rev('+json.kode_barang[i]+')"><input type="hidden" class="form-control input-sm" name="qty_ori[]" value="'+json.jml_beli[i]+'" id="qty_ori_'+json.kode_barang[i]+'" rel="'+json.jml_beli[i]+'"></td>';
						html +='<tr>';
					}
					
					$('#TabelPengembalian tbody').html(html);
				}
			});
		}
		
		
	});
});

function input_rev(id){
	var val_ori = $("#qty_ori_"+id).val();
	var val_receipt = $("#qty_receipt_"+id).val();
	if(Number(val_receipt) > Number(val_ori)){
		$("#qty_receipt_"+id).val(val_ori);
		alert('Jumlah terlalu banyak');
		return false;
	}
}


$(document).on('keyup', '.qty_receipt', function(e){
	var charCode = e.which || e.keyCode;
	
});




function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}

$(document).on('click', '#Simpann', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){ 
   		$('button#SimpanTransaksi').focus();
    }, 500);
});

$(document).on('click', 'button#SimpanTransaksi', function(){
	SimpanTransaksi();
});

function SimpanTransaksi()
{
	var Formdata = $('#frm_receipt').serialize();
	
	$.ajax({
		url: "<?php echo site_url('good_receipt/simpan'); ?>",
		type: "POST",
		cache: false,
		data: Formdata,
		dataType:'json',
		success: function(data){
			//console.log(data);
			if(data.Status == 1){
				$('#ModalGue').modal('hide');
				alert('Transaksi Sukses');
				window.location.reload();
			}
			else 
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}	
		}
	});
}
$('#nominal_cash').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
</script>
<?php $this->load->view('include/footer'); ?>