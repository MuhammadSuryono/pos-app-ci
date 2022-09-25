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
.borderless td, .borderless th {
    border: none;
}
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

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
				<div class='col-sm-3'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota</div>
						<div class="panel-body">

							<div class="form-horizontal">
								
								<div class="form-group">
                                
									<label class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-8">
										<input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>" <?php echo $disabled; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Kasir</label>
									<div class="col-sm-8">
                                    	<input type='hidden' name='kode_kasir' class='form-control input-sm' id='kode_kasir' value="<?php echo $this->session->userdata('ap_id_user'); ?>" <?php echo $readonly; ?>>
										<input type='text' name='kasir' class='form-control input-sm' id='kasir' value="<?php echo $this->session->userdata('ap_nama'); ?>" disabled>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="panel panel-primary" id='PelangganArea'>
						<div class="panel-heading"><i class='fa fa-user'></i> Informasi Pelanggan</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Pelanggan</label>
								<!--<a href="<?php echo site_url('penjualan/tambah-pelanggan'); ?>" class='pull-right' id='TambahPelanggan'>Tambah Baru ?</a>-->
								<select name='id_pelanggan' id='id_pelanggan' class='form-control input-sm select2' style='cursor: pointer;'>
									
									<?php
										$id = '';
										if(!empty($pelanggan->Customer)){
											foreach($pelanggan->Customer as $pc){
												$id = $pc->No.'Þ'.$pc->Name.'Þ'.$pc->Address.'-'.$pc->Address2.'Þ'.$pc->PhoneNo;
												echo "<option value='".$id."'>".$pc->Name."</option>";
											}
										}
									
									?>
								</select>
							</div>

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">Telp / HP</label>
									<div class="col-sm-8">
										<div id='telp_pelanggan'>011111111111</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Alamat</label>
									<div class="col-sm-8">
										<div id='alamat_pelanggan'>-</div>
									</div>
								</div>
								
							</div>

						</div>
					</div>
				</div>
				<div class='col-sm-9'>
					<h5 class='judul-transaksi'>
						<i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> Payment
						<a href="<?php echo site_url('penjualan/transaksi'); ?>" class='pull-right' style="display:none;"><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a>
					</h5>
					 
                    	<table class='table table-bordered' id='TabelBayar'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:150px;'>Type Payment</th>
								<th>Bank</th>
                                <th>No.Card</th>
								<th style='width:220px;'>Nominal</th>
								
								<th style='width:40px;'><button id='BarisBaru_bayar' class='btn btn-default'><i class='fa fa-plus fa-fw'></i></button></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
                    
                    <div class='alert alert-info TotalBayar'>
                    <table class='borderless' style="width:100%;">
                    	<tr>
                        	<td align="right">Sub Total(NOPJK)</td>
                            <td width="10px;"> : </td>
                            <td width="100px;">Rp. <?php echo number_format($notax,2,',','.');?></td>
                        </tr>
						<tr>
                        	<td align="right">Sub Total</td>
                            <td width="10px;"> : </td>
                            <td width="100px;">Rp. <?php echo $sub_ttl.',00'; ?></td>
                        </tr>
                        <tr style="display:none">
                        	<td align="right">PPN(10%)</td>
                            <td> : </td>
                            <td width="100px;">Rp. <?php echo number_format($tax,2,',','.');?></td>
                        </tr>
						<tr>
                        	<td align="right">Potongan</td>
                            <td width="10px;"> : </td>
                            <td width="100px;">Rp. <?php echo number_format($potongan,2,',','.');?></td>
                        </tr>
                         <tr>
                        	<td align="right">Grand Total</td>
                            <td> : </td>
                            <td width="100px;">Rp. <?php echo number_format($grnd_ttl,2,',','.');?></td>
                        </tr>
                        <tr>
                        	<td align="right">Bayar</td>
                            <td> : </td>
                            <td width="100px;"><span id='Bayaran'>Rp. <?php echo number_format($grnd_ttl,2,',','.');?></span></td>
                        </tr>
                        <tr>
                        	<td align="right">Kembalian</td>
                            <td> : </td>
                            <td width="100px;"><span id='kembalian'>Rp. 0.00</span></td>
                        </tr>
                    </table> 
                         <input type="hidden" id='grnd_ttl' value="<?php echo $grnd_ttl;?>">
                         <input type='hidden' name='cash' id='UangCash' value="<?php echo $grnd_ttl;?>">
                         <input type='hidden' name='UangKembalian' id='UangKembalian'>
                         
					</div>
                    

					<div class='row'>
						<div class='col-sm-7'>
							
						</div>
						<div class='col-sm-5'>
							<div class="form-horizontal">
								
                               
								<div class='row'>
									<div class='col-sm-6'>
										<!--<button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
											<i class='fa fa-print'></i> Cetak
										</button> 
                                        <button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
											<i class='fa fa-floppy-o'></i> Parking
										</button>-->
									</div>
									<div class='col-sm-6'>
                                    	
										<button type='button' class='btn btn-primary btn-block' id='Simpann'>
											<i class='fa fa-floppy-o'></i> Submit
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

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('.select2').select2();
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});

$(document).ready(function(){
	var a ='<?php echo number_format($grnd_ttl,2,',','.') ;?>';
	//console.log(a);
	for(B=1; B<=1; B++){
		//BarisBaru();
		bayarBaru(a.replace(',00', ''));
	}

	$('#id_pelanggan').change(function(){
		if($(this).val() !== ''){
			var val = $(this).val();
			var _val = val.split('Þ');
			var telp = '-';
			var address = '-';
			if(_val[3] != ''){
				telp = _val[3];
			}
			if(_val[2] != ''){
				address = _val[2];
			}
			
			$('#telp_pelanggan').html(telp);
			$('#alamat_pelanggan').html(address);
		}
		else{
			$('#telp_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#alamat_pelanggan').html('<small><i>Tidak ada</i></small>');
			//$('#info_tambahan_pelanggan').html('<small><i>Tidak ada</i></small>');
		}
	});
	


	$('#BarisBaru').click(function(){
		BarisBaru();
	});
	
	$('#BarisBaru_bayar').click(function(){
		bayarBaru('');
	});

	$("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
});

function chg_byr(val, indexnya){
	var myIndex = parseInt(indexnya) - 1;
	var IndexIni = indexnya + 1;
	var TotalIndex = $('#TabelBayar tbody tr').length + 1;
	if(val > 0 || val !=''){
		$('#TabelBayar tbody tr:eq('+myIndex+') td:nth-child(5) input').removeAttr('disabled');
		if(val == 'CREDIT' || val == 'DEBIT' || val == 'ONLINE'){
			var url = '<?php echo site_url('pembayaran/get_payment_type');?>';
			var dt = val;
			$.ajax({
				data : {val : dt},
				url : url,
				type : "POST",
				success:function(response){
					var dt_json = JSON.parse(response);
					var paymentType = dt_json['PaymentMethod'];
					$.each(paymentType, function( key, value ) {					 
						$('.payType_'+indexnya).find('option').remove().end();
					});
					$.each(paymentType, function( key, value ) {					 
						$('.payType_'+indexnya).append($('<option/>').attr("value", value.PaymentCode).text(value.PaymentDescription));
					});
				}
			});
		}
		if (val == 'CASH'){
			$('.payType_'+indexnya).find('option').remove().end();
			$('.payType_'+indexnya).append($('<option/>').attr("value", null).text("- Pilih type bayar -"));
			//$('#TabelBayar tbody tr:eq('+indexnya+') td:nth-child(4) input').val('');
			//$('#TabelBayar tbody tr:eq('+indexnya+') td:nth-child(3) select').val('');
		}
		if(val != 12){
			console.log(val);
			$('#TabelBayar tbody tr:eq('+myIndex+') td:nth-child(4) input').removeAttr('disabled');
			$('#TabelBayar tbody tr:eq('+myIndex+') td:nth-child(3) select').removeAttr('disabled');
		}
		if(IndexIni == TotalIndex){
			//bayarBaru('');
		}
	}
}

function bayarBaru(nominal){
	var url = '<?php echo site_url('pembayaran/get_payment');?>';
	var dt = '';
	//var Payment = '';
	var Nomor = $('#TabelBayar tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
		Baris += "<select name='type_bayar[]' class='form-control input-sm paymentType_"+Nomor+"' style='cursor: pointer;' onchange='chg_byr(this.value,"+Nomor+")'>";
		//	Baris += "<option value=''>- Pilih jenis bayar -</option>";
		Baris += "</select>";
			
		Baris += "</td>";
		
		Baris +="<td>";
		Baris += "<select name='type_pay[]' class='form-control input-sm payType_"+Nomor+"' style='cursor: pointer;' >";
		Baris += "<option value=''>- Pilih type bayar -</option>";
		Baris += "</select>";
		Baris +="</td>";
		Baris += "<td><input type='text' class='form-control' id='nama_bank' name='nama_bank[]' ></td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control nilai_bayar' value='"+ nominal +"' id='nilai_bayar' name='nilai_bayar[]' onkeypress='return check_int(event)'>";
		Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td align='center'><button class='btn btn-default' id='HapusBayar'><i class='fa fa-times' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#TabelBayar tbody').append(Baris);
	$.ajax({
		data : dt,
		url : url,
		type : "POST",
		success:function(response){
			var dt_json = JSON.parse(response);
			var paymentType = dt_json['PaymentType'];
			$.each(paymentType, function( key, value ) {
			 //console.log(  value.TypeCode + ": " + value.TypeDesc );
			 	//Payment += '<option value="'+value.TypeCode+'">"'+ value.TypeDesc +'"</option>';
				$('.paymentType_'+Nomor).append($('<option/>').attr("value", value.TypeCode).text(value.TypeDesc));
			});
		}
	});
	
	$('#TabelBayar tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});
}

function BarisBaru()
{	
	var Nomor = $('#TabelTransaksi tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
		Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td></td>";
		Baris += "<td>";
		Baris += "<input type='hidden' name='harga_satuan[]'>";
		Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' class='form-control' id='jumlah_beli' value='"+ <?php echo intval($grnd_ttl);?> +"' name='jumlah_beli[]' onkeypress='return check_int(event)' disabled></td>";
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

$(document).on('keyup', '#pencarian_kode', function(e){
	if($(this).val() !== '')
	{
		var charCode = e.which || e.keyCode;
		if(charCode == 40)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Selanjutnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').next();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

				Selanjutnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		} 
		else if(charCode == 38)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Sebelumnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').prev();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');
			
				Sebelumnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		}
		else if(charCode == 13)
		{
			var Field = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
			var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
			var Barangnya = Field.find('div#hasil_pencarian li.autocomplete_active span#barangnya').html();
			var Harganya = Field.find('div#hasil_pencarian li.autocomplete_active span#harganya').html();
			
			Field.find('div#hasil_pencarian').hide();
			Field.find('input').val(Kodenya);

			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(Barangnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) input').removeAttr('disabled').val(1);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) span').html(to_rupiah(Harganya));
			
			var IndexIni = $(this).parent().parent().index() + 1;
			var TotalIndex = $('#TabelTransaksi tbody tr').length;
			if(IndexIni == TotalIndex){
				BarisBaru();

				$('html, body').animate({ scrollTop: $(document).height() }, 0);
			}
			else {
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) input').focus();
			}
		}
		else 
		{
			AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
		}
	}
	else
	{
	$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	}

	HitungTotalBayar();
});

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

$(document).on('keyup', '#nilai_bayar', function(e){
	
	var charCode = e.which || e.keyCode;
	
	$(this).val(function(index, value) {
		return value
		.replace(/\D/g, "")
		.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	});
	hitung_bayar();
});
var TotalBayaranku_ = <?php echo intval($grnd_ttl) ;?>		;
function hitung_bayar(){
	var Total = 0;
	var total_ku = '';
	$('#TabelBayar tbody tr').each(function(){
		
		if($(this).find('td:nth-child(5) input').val().length > 0)
		{
			
			var totals = $(this).find('td:nth-child(5) input').val();
			
			totals = totals.replace('.','');
			totals = totals.replace('.','');
			totals = totals.replace('.','');
			totals = totals.replace('.','');
			Total = Number(Total) + Number(totals );
		}
	});
	$('#Bayaran').html(to_rupiah(Total));
	TotalBayaranku_ = Total;
	$('#UangCash').val(Total);
	HitungTotalKembalian()
}

function HitungTotalBayar()
{
	var Total = 0;
	var ppn = 0;
	var ttl_ppn = 0;
	var GrandBayar = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(6) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(6) input').val();
			ppn = SubTotal * 0.1;
			ttl_ppn = ttl_ppn + ppn;
			Total = parseInt(Total) + parseInt(SubTotal);
			GrandBayar = Total + ttl_ppn;
		}
	});
	$('#TotalBayar').html(to_rupiah(Total));
	$('#ttlPPN').html(to_rupiah(ttl_ppn));
	$('#GrandBayar').html(to_rupiah(GrandBayar));
	$('#TotalBayarHidden').val(Total);
	$('#TotalPPNHidden').val(ttl_ppn);
	$('#GrandBayarHidden').val(GrandBayar);
	$('#UangCash').val(GrandBayar);
	//$('#UangKembali').val('');
}

function HitungTotalKembalian(){
	var Cash = $('#UangCash').val();
	
	var TotalBayar = $('#grnd_ttl').val();
	$('#kembalian').val('0');
	$('#UangKembalian').val('0');
	$('#kembalian').html(to_rupiah(0));
	if(parseInt(Cash) >= parseInt(TotalBayar)){
		var Selisih = parseInt(Cash) - parseInt(TotalBayar);
		$('#kembalian').html(to_rupiah(Selisih));
		$('#UangKembalian').val(Selisih);
	} else {
		$('#kembalian').val('');
	}
}

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

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}

$(document).on('keydown', 'body', function(e){
	var charCode = ( e.which ) ? e.which : event.keyCode;

	if(charCode == 118) //F7
	{
		BarisBaru();
		return false;
	}

	if(charCode == 119) //F8
	{
		$('#UangCash').focus();
		return false;
	}

	if(charCode == 120) //F9
	{
		CetakStruk();
		return false;
	}

	if(charCode == 121) //F10
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function(){ 
	   		$('button#SimpanTransaksi').focus();
	    }, 500);

		return false;
	}
});

$(document).on('click', '#Simpann', function(){
	if (document.getElementById("telp_pelanggan").innerHTML == "-"){
		alert("Pilih Pelanggan");
	}
	else if(TotalBayaranku_ < $('#grnd_ttl').val())
		alert("Jumlah Bayar lebih kecil dari Total Pembelian");
	else {
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function(){ 
			$('button#SimpanTransaksi').focus();
		}, 500);
	}
});

$(document).on('click', 'button#SimpanTransaksi', function(){
	SimpanTransaksi();
});

$(document).on('click', 'button#CetakStruk', function(){
	CetakStruk();
});

function SimpanTransaksi(){
	
	//var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
	var FormData = "&tanggal="+encodeURI($('#tanggal').val());
	FormData += "&id_kasir="+$('#kode_kasir').val();
	FormData += "&id_pelanggan="+$('#id_pelanggan').val();
	FormData += "&" + $('#TabelTransaksi tbody input').serialize();
	FormData += "&cash="+$('#UangCash').val();
	FormData += "&kembalian="+$('#UangKembalian').val();
	//FormData += "&catatan="+encodeURI($('#catatan').val());
	//FormData += "&grand_total="+$('#TotalBayarHidden').val();
	//FormData += "&ppn="+$('#TotalPPNHidden').val();
	FormData += "&grand_bayar="+$('#GrandBayarHidden').val();
	FormData += "&" + $('#TabelBayar tbody input').serialize();
	FormData += "&" + $('#TabelBayar tbody select').serialize();
	//console.log(FormData);
	$.ajax({
		url: "<?php echo site_url('penjualan/simpan_transaksi'); ?>",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		success: function(data){
			console.log(data);
			if(data.Status == 1){
				$('#ModalGue').modal('hide');
				alert('Penjualan Sukses');
				window.location.href="<?php echo site_url('penjualan/ctak_trans'); ?>";
				//window.open('<?php echo site_url('penjualan/ctak_trans'); ?>');
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

$(document).on('click', '#TambahPelanggan', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Pelanggan');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});

function CetakStruk()
{
	if($('#TotalBayarHidden').val() > 0)
	{
		if($('#UangCash').val() !== '')
		{
			var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_kasir="+$('#id_kasir').val();
			FormData += "&id_pelanggan="+$('#id_pelanggan').val();
			FormData += "&" + $('#TabelTransaksi tbody input').serialize();
			FormData += "&cash="+$('#UangCash').val();
			FormData += "&catatan="+encodeURI($('#catatan').val());
			FormData += "&grand_total="+$('#TotalBayarHidden').val();

			window.open("<?php echo site_url('penjualan/transaksi-cetak/?'); ?>" + FormData,'_blank');
		}
		else
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html('Harap masukan Total Bayar');
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
			$('#ModalGue').modal('show');
		}
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap pilih barang terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}
</script>

<?php $this->load->view('include/footer'); ?>