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
if($available < 1){
?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
				<div class='col-sm-3'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota</div>
						<div class="panel-body">

							<div class="form-horizontal">
                            <input type='hidden' name='nomor_nota_trans' class='form-control input-sm' id='nomor_nota_trans' value="<?php echo $this->session->userdata('ap_id_user'); ?>" <?php echo $readonly; ?>>
                            <input type='hidden' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>" <?php echo $disabled; ?>>
                             <input type='hidden' name='id_kasir' class='form-control input-sm' id='id_kasir' value="<?php echo $this->session->userdata('ap_id_user'); ?>" >
								<div class="form-group">
									<label class="col-sm-4 control-label">No. Nota</label>
									<div class="col-sm-8">
										<select name='nomor_nota' id='nomor_nota' class='select2 form-control input-sm'>
                                        <option value="">-- Pilih -- </option>
                                        <?php
										
											if(!empty($nota)){
												foreach($nota as $n){
													 echo '<option value='.$n->No.'>'.$n->No.'</option>';
												}
											}
										?>										
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-8">
										<div id='tgl'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Kasir</label>
									<div class="col-sm-8">
										<div id='kasir'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="panel panel-primary" id='PelangganArea'>
						<div class="panel-heading"><i class='fa fa-user'></i> Informasi Pelanggan</div>
						<div class="panel-body">
							<input type='hidden' name='id_pelanggan' class='form-control input-sm' id='id_pelanggan' value="" >

							<div class="form-horizontal">
                            	<div class="form-group">
									<label class="col-sm-4 control-label">Nama</label>
									<div class="col-sm-8">
										<div id='nama_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Telp / HP</label>
									<div class="col-sm-8">
										<div id='telp_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-sm-9'>
					<h5 class='judul-transaksi'>
						<i class='fa fa-shopping-cart fa-fw'></i> Return <i class='fa fa-angle-right fa-fw'></i> Transaksi
						<a href="<?php echo site_url('pengembalian/transaksi'); ?>" class='pull-right'><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a>
					</h5>
					<table class='table table-bordered' id='TabelPengembalian'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:210px;'>Kode Barang</th>
								<th>Nama Barang</th>
								<th style='width:120px;'>Harga</th>
								<th style='width:75px;'>Qty</th>
								<th style='width:125px;'>Sub Total</th>
								<!-- <th style='width:40px;' align="center"><input type="checkbox"  /></th>-->
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<!--	<hr style="border:1px dashed #ddf;"/>
						<h3>Transaksi</h3>
					<table class='table table-bordered' id='TabelTransaksi'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:210px;'>Kode Barang</th>
								<th>Nama Barang</th>
								<th style='width:120px;'>Harga</th>
								<th style='width:75px;'>Qty</th>
								<th style='width:125px;'>Sub Total</th>
								<th style='width:40px;'><button id='BarisBaru' class='btn btn-default'><i class='fa fa-plus fa-fw'></i></button></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
                    
                    <hr style="border:1px dashed #ddf;"/>
						<h2>Payment</h2>
		
                    	<table class='table table-bordered' id='TabelBayar'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:150px;'>Type Payment</th>
								<th>Bank - No.Card</th>
								<th style='width:220px;'>Nominal</th>
								
								<th style='width:40px;'><button id='BarisBaru_bayar' class='btn btn-default'><i class='fa fa-plus fa-fw'></i></button></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table> -->
                    	
                    
                    <div class='alert alert-info TotalBayar'>
						<!-- Total : <span id='TotalBayar'>Rp. 0</span><br/>
						
                        PPN (10%) : <span id='ttlPPN'>Rp. 0</span><br/>
                        Return Value (-) : <span id='return_val'>Rp. 0</span> -->
                        
                        <h3>Grand Total : <span id='GrandBayar'>Rp. 0</span></h3>
                      <!-- <h3>Bayar : <span id='Bayaran'>Rp. 0</span></h3> -->
						<input type="hidden" id='TotalBayarHidden'> 
                        <input type="hidden" id='TotalPPNHidden'>
                        <input type="hidden" id='returnValHidden'>
                        <input type="hidden" id='GrandBayarHidden'>
                        <input type='hidden' name='cash' id='UangCash' class='form-control'>
					</div>
					<div class='row'>
						 <div class='col-sm-7'>
							<!-- <textarea name='catatan' id='catatan' class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>
							
							<br /> -->							
						</div> 
						<div class='col-sm-5'>
							<div class="form-horizontal"> 
								<div class='row'>
									<div class='col-sm-6' style='padding-right: 0px;'>
										<!-- <button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
											<i class='fa fa-print'></i> Cetak
										</button> -->
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
<p class='footer'><?php echo config_item('web_footer'); ?></p>
<?php } else { ?>
<br/>
<br/>
<br/>
<br/>
<br/>
	<div class="container-fluid col-sm-4 col-sm-offset-4">
	<div class="panel panel-default">
		<div class="panel-body" style="padding-bottom:1px;">
			<div class='row'>	
                <div class='col-sm-12'>
					<form id="">
					<div class="panel panel-primary" id=''>
						<div class="panel-heading"><i class='fa fa-user'></i> Open Cash Register</div>
						<div class="panel-body">
                       		<strong>Cash</strong>
                        	<input type="text" class='form-control input-block' name="nominal_cash" id="nominal_cash" value="" placeholder="0.00" />
                            <br/>
							<button type="button" class="btn btn-block btn-success btn_open">Open</button>
						</div>
					</div>
					</form>
				</div>         
            </div>
        </div>
     </div>
    </div>
<?php } ?>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>
<script>
$(".select2").select2();
$('.btn_open').click(function(){
	var url = '<?php echo site_url('secure/open_cash');?>';
	var nominal_cash = $('#nominal_cash').val();
	if(nominal_cash != ''){
		$.ajax({
			data : {nominal_cash:nominal_cash},
			url : url,
			type : 'POST',
			success:function(response){
				location.reload();
			}
		})
	}else{
		alert('Silahkan isi nilai cash awal anda');
	}
});
$(document).ready(function(){
	$('#BarisBaru').click(function(){
		BarisBaru();
	});
	
	$('#BarisBaru_bayar').click(function(){
		bayarBaru();
	});
	$('#nomor_nota').change(function(){
		var html = '';
		if($(this).val() !== ''){
			$("#TabelTransaksi").find("tr:gt(0)").remove();
			$("#TabelBayar").find("tr:gt(0)").remove();
			//BarisBaru();
			//bayarBaru();
			
			$('#id_pelanggan').val();
			$.ajax({
				url: "<?php echo site_url('pengembalian/ajax_nota'); ?>",
				type: "POST",
				cache: false,
				data: "no_nota="+$(this).val(),
				dataType:'json',
				success: function(json){
					//console.log(json);
					$('#kasir').html(json.nama_kasir);
					$('#tgl').html(json.tanggal);
					$('#nama_pelanggan').html(json.nama);
					$('#telp_pelanggan').html(json.telp);
					$('#alamat_pelanggan').html(json.alamat);
					$('#info_tambahan_pelanggan').html(json.info_tambahan);
					$('#id_pelanggan').val(json.id_pelanggan);
					$('#return_val').html('Rp. 0');
					html = '';
                    let total = 0;
					for(var i = 0; i < json.banyak_baris; i++){
						console.log(json.hrg_satuan[i]);
                        total += parseInt(json.total[i]);
						var no = Number(i)+1;
						html +='<tr>';
						html +='<td>'+no+'.</td>';
						html +='<td>'+json.kode_barang[i]+'</td>';
						html +='<td>'+json.nama_brg[i]+'</td>';
						html +='<td>'+json.hrg_satuan[i]+'</td>';
						html +='<td>'+json.jml_beli[i]+'</td>';
						html +='<td>'+json.total[i]+'</td>';
						//html +='<td align="center"><input type="checkbox" name="chk_return[]" value="'+json.dt_total[i]+'" class="chk_return" rel="'+json.total[i]+'"></td>';
						html +='<tr>';
					}
                    $('#GrandBayar').html(total)
					$('#TabelPengembalian tbody').html(html);
				}
			});
		}
		else
		{
			//$('#GrandBayar').html('<small><i>Tidak ada</i></small>');
			//$('#ttlPPN').html('<small><i>Tidak ada</i></small>');
			//$('#TotalBayar').html('<small><i>Tidak ada</i></small>');
			$('#return_val').html('Rp. 0');
			$('#kasir').html('<small><i>Tidak ada</i></small>');
			$('#tgl').html('<small><i>Tidak ada</i></small>');
			$('#nama_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#telp_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#alamat_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#info_tambahan_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#TabelTransaksi tbody').append(html);
		}
		
	});
});
$(document).on('click', '#HapusBayar', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelBayar tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	hitung_bayar();
});

$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	HitungTotalBayar();
});
function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});

$(document).on('keyup', '#nilai_bayar', function(e){
	var charCode = e.which || e.keyCode;
	hitung_bayar();
});

$(document).on('keyup', '#jumlah_beli', function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var JumlahBeli = $(this).val();
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	$.ajax({
		url: "<?php echo site_url('barang/cek-stok'); ?>",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok="+JumlahBeli,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
				if(SubTotal > 0){
					var SubTotalVal = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('1');
			}
		}
	});
});

$(document).on('keydown', '#jumlah_beli', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});

function hitung_bayar(){
	var Total = 0;
	$('#TabelBayar tbody tr').each(function(){
		if($(this).find('td:nth-child(4) input').val() > 0)
		{
			var totals = $(this).find('td:nth-child(4) input').val();
			Total = Number(Total) + Number(totals);
		}
	});
	$('#Bayaran').html(to_rupiah(Total));
	$('#UangCash').val(Total);
}

function bayarBaru(){
	var Nomor = $('#TabelBayar tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
		Baris += "<select name='type_bayar[]' class='form-control input-sm' style='cursor: pointer;' onchange='chg_byr(this.value,"+Nomor+")'>";
		Baris += "<option value=''>- Pilih jenis bayar -</option>";
		Baris += "<option value='1'> Cash </option>";
		Baris += "<option value='2'> Debet </option>";
		Baris += "<option value='3'> Kartu Kredit </option>";
		//Baris += "<option value='4'> Voucher </option>";
		Baris += "</select>";
			
		Baris += "</td>";
		
		Baris += "<td><input type='text' class='form-control' id='nama_bank' name='nama_bank[]' disabled></td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control' id='nilai_bayar' name='nilai_bayar[]' onkeypress='return check_int(event)' disabled>";
		Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td align='center'><button class='btn btn-default' id='HapusBayar'><i class='fa fa-times' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#TabelBayar tbody').append(Baris);

	$('#TabelBayar tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});
}

function BarisBaru()
{
	var Nomor = $('#TabelTransaksi tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+".</td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
		Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td></td>";
		Baris += "<td>";
		Baris += "<input type='hidden' name='harga_satuan[]'>";
		Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' class='form-control' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td align='center'><button class='btn btn-default' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#TabelTransaksi tbody').append(Baris);

	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});

	HitungTotalBayar();
}
function HitungTotalBayar()
{
	var Total = 0;
	var ppn = 0;
	var ttl_ppn = 0;
	var GrandBayar = 0;
	var returnValHidden = $('#returnValHidden').val();
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(6) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(6) input').val();
			ppn = SubTotal * 0.1;
			ttl_ppn = ttl_ppn + ppn;
			Total = Number(Total) + Number(SubTotal);
			GrandBayar = Number(Total) + Number(ttl_ppn) - Number(returnValHidden);
		}
	});
	$('#TotalBayar').html(to_rupiah(Total));
	$('#ttlPPN').html(to_rupiah(ttl_ppn));
	$('#GrandBayar').html(to_rupiah(GrandBayar));
	$('#TotalBayarHidden').val(Total);
	$('#TotalPPNHidden').val(ttl_ppn);
	$('#GrandBayarHidden').val(GrandBayar);

	//$('#UangCash').val('');
	//$('#UangKembali').val('');
}
$(document).on('click', '.chk_return', function(e){
	var sum = 0;
    $("input[class=chk_return]:checked").each(function(){
      sum += parseInt($(this).attr("rel"));
    });
	$('#returnValHidden').val(sum);
	$('#return_val').html(to_rupiah(sum));
	$('#UangCash').val(sum);
	HitungTotalBayar();
});

function AutoCompleteGue(Lebar, KataKunci, Indexnya)
{
	$('div#hasil_pencarian').hide();
	var Lebar = Lebar + 25;

	var Registered = '';
	$('#TabelTransaksi tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
		url: "<?php echo site_url('penjualan/ajax-kode'); ?>",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
			}
			if(json.status == 0)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(0);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html('');
			}
		}
	});

	HitungTotalBayar();
}
$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());
	
	var Indexnya = $(this).parent().parent().parent().parent().index();
	var NamaBarang = $(this).find('span#barangnya').html();
	var Harganya = $(this).find('span#harganya').html();

	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(Harganya));

	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#TabelTransaksi tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		//$('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
	}

	HitungTotalBayar();
});

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}
function chg_byr(val, indexnya){
	var myIndex = parseInt(indexnya) - 1;
	var IndexIni = indexnya + 1;
	var TotalIndex = $('#TabelBayar tbody tr').length + 1;
	if(val > 0){
		$('#TabelBayar tbody tr:eq('+myIndex+') td:nth-child(4) input').removeAttr('disabled');
		if(val != 1){
			$('#TabelBayar tbody tr:eq('+myIndex+') td:nth-child(3) input').removeAttr('disabled');
		}
		if(IndexIni == TotalIndex){
			bayarBaru();
		}
	}
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
	var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
	FormData += "&nomor_nota_trans="+encodeURI($('#nomor_nota_trans').val());
	FormData += "&tanggal="+encodeURI($('#tanggal').val());
	FormData += "&id_kasir="+$('#id_kasir').val();
	FormData += "&id_pelanggan="+$('#id_pelanggan').val();
	FormData += "&" + $('#TabelTransaksi tbody input').serialize();
	FormData += "&cash="+$('#UangCash').val();
	FormData += "&catatan="+encodeURI($('#catatan').val());
	FormData += "&grand_total="+$('#TotalBayarHidden').val();
	FormData += "&returnValHidden="+$('#returnValHidden').val();
	FormData += "&ppn="+$('#TotalPPNHidden').val();
	FormData += "&grand_bayar="+$('#GrandBayarHidden').val();
	FormData += "&" + $('#TabelBayar tbody input').serialize();
	FormData += "&" + $('#TabelBayar tbody select').serialize();
	FormData += "&" + $('#TabelPengembalian tbody checked').serialize();
	FormData += "&" + $('#TabelPengembalian tbody input').serialize();

	$.ajax({
		url: "<?php echo site_url('pengembalian/simpan_return'); ?>",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		success: function(data){
			if(data.status === 'Posted'){
				$('#ModalGue').modal('hide');
				alert('Return Sukses');
				window.location.href="<?php echo site_url('pengembalian/transaksi'); ?>";
				//window.open('<?php echo site_url('penjualan/ctak_trans'); ?>');
			}
			else 
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html("Gagal simpan data");
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