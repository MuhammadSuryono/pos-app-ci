<?php 
	$id = '';
								
	if(!empty($itemku->Item)){
		foreach($itemku->Item as $it){
			$id = '';
			$vatsts = '';
			$id = $it->Code.'Þ'.$it->Name.'Þ'.$it->Stock.'Þ'.$it->Harga.'Þ'.$it->Discount.'Þ'.$it->Barcode.'Þ'.$it->Point.'Þ'.$it->VATStatus.'Þ'.explode('!', $it->Name)[1];
			if ($it->VATStatus == 'NOVAT'){
				$vatsts = 'btn-success';	
			}else{
				$vatsts = 'btn-danger';
			}
			$a = explode('!', $it->Name);
			$b = "";
			if (explode('!', $it->Name)[1] != "Available"){ 
				$b = '<p style="margin: 0 0 -3px; color:#000">Not Available</p>';
			}
			echo '<div class="col-sm-12 list-product itm_prd" id="'.$id.'">
                  	<div class="thumbnail get_product '.$vatsts.'">       			
                    <div class="caption">
                    	<p style="color:#FFF; font-size:16px; margin: 0 0 -3px;"><b>'.$a[0].'</b><span class="badge badge-primary badge-pill pull-right" style="font-size:16px">Rp. '.number_format($it->Harga,2,',','.').'</span></p>
						 '.$b.'
					</div>
					
                    </div>
                  </div>';
			
		}
	}
	if(!empty($itemku->DiscountAdhoc)){
		foreach($itemku->DiscountAdhoc as $it){			 
				echo '<div class="col-sm-12 list-product itm_prd_promo" id="'.$it->Code.'">
						<div class="thumbnail get_product_promo">       			
						<div class="caption">
							<p style="color:#000; font-size:16px; margin: 0 0 -3px;"><b>'.$it->Code.' - '.$it->Description.'</b></p>
						</div>
						
						</div>
					</div>';
			}	
	} 
	
?>
<script>
$('.itm_prd').click(function(){
	
	var id = $(this).get(0).id;
	var _id = id.split('Þ');
	//if (_id[8] == 'Available'){
	//	list_cart(id);
	//}
	list_cart(id);
});
$('.itm_prd_promo').click(function(){
	var id = $(this).get(0).id;
	var url = '<?php echo site_url('penjualan/load_detail_promo');?>';
	$.ajax({
		data : {Code : "PR", Search : id},
		url : url,
		type : "POST",
		beforeSend  : function(){ $('#container-loader-list').show(); },
		success:function(response){
			if(response != ''){
				
				var data = JSON.parse(response);
				var tes = JSON.parse(data);
				var head = tes["DiscountAdhoc"][0];
				$(head["line"]).each(function (index) {
					var disc_int = parseInt($(this).attr('DiscountAmount').replace(',', '').replace(',', ''));
					
					var price_int = parseInt($(this).attr('SalesPrice').replace(',', '').replace(',', ''));
					console.log(price_int);
					list_cart_promo($(this).attr('ItemNo'), 
					price_int,
					parseInt($(this).attr('Qty')),
					disc_int,
					$(this).attr('VATGroup'),
					$(this).attr('Description'));
                }); 
				
			}
		}
	});	
	//list_cart_promo(id);
});
function list_cart_promo(myID, harga, qty_promo, discount, vatstat, nama){
	var nomor = $('#list_cart li').length + 1;
	//var _id = id.split('Þ');
	//var nama = _id[1];
	//var harga = _id[3];
	//var discount = _id[4];
	var harga_ori = harga;
	//var myID = _id[0];
	//var barcode = _id[5];
	//var point = _id[6];
	//var vatstat = _id[7];
	if(harga > 0){
		harga = numberWithCommas(harga);
	}else{
		harga = '0.00';
	}
	var nama_length = nama.length;
	var nama1 = nama;
	var nama2 = '';
	var cnt_item = $('#item_'+myID).length;
	if(cnt_item > 0){
		var qty = Number($('#qty_'+myID).val()) + qty_promo;
		$('#qty_'+myID).val(qty);
		//var disc = $('#disc_'+myID).val();
		
		$('#disc_ttl_'+myID).val(Number($('#disc_ttl_'+myID).val()) + discount);
		$('#disc_'+myID).val($('#disc_ttl_'+myID).val() + discount);
	}else{
		var baris = '<li class="item" id="item_'+myID+'">';
        baris += '<div class="product-info">';
		baris +='<strong>'+ nama +'</strong>';
		baris +='<p>';
		baris +='<span class="pull-left" style="margin-top:5px;width:120px;">Rp.'+harga+'</span>';
		baris +='<a href="#" onclick="deletes(\'' +myID+ '\')" class="spn_hrg pull-right"><span class="glyphicon glyphicon-remove pull-right"></span></a>';
		baris +='<span class="spn_hrg pull-right" id="spn_hrg_'+myID+'">'+harga+'</span>';
		baris +='<input type="text" class="pull-left" id="qty_'+myID+'" name="jml_beli[]" onkeypress="return check_int(event)" onkeyup="jml_beli(\'' +myID+ '\')" value="'+ qty_promo +'" style="margin-left:-10px;margin-top:5px;width:15%;text-align:center">';
		baris +='</p>';
		baris +='<input type="hidden" name="cod_item[]" value="'+myID+'">';
		baris +='<input type="hidden" name="barcode[]" value="">';
		baris +='<input type="hidden" name="point[]" value="">';
		baris +='<input type="hidden" id="vatstat_'+myID+'" name="vatstat[]" value="'+vatstat+'">';
		baris +='<input type="hidden" id="hrg_'+myID+'" value="'+harga_ori+'" name="harga_ori[]" />';        
        baris +='<input type="hidden" class="_disc" name="_disc[]" id="disc_'+myID+'" value="'+discount+'" style="width:40%; text-align:center;" placeholder="Disc." disabled /></span>';
		baris +='<input type="text" class="pull-left" disabled onkeyup="promo(\'' +myID+ '\')"  value="'+discount+'" id="disc_ttl_'+myID+'" name="disc_ttl[]" ids="'+vatstat+'" placeholder="Disc." style="margin-top:-5px;width:25%;text-align:right"/>';
		baris +='<input type="hidden" name="hrga[]" id="ttl_hrg_'+myID+'" value="" ids="'+vatstat+'" />';
		baris +='</div></li>';
	
		$('#list_cart').append(baris);
	}
	var qty = $('#qty_'+myID).val();
	var hargaa = $('#hrg_'+myID).val();
	var disc = $('#disc_'+myID).val();
	HitungTotalBayar(myID, qty, hargaa, disc, vatstat, 1);
}

function list_cart(id){
	var nomor = $('#list_cart li').length + 1;
	var _id = id.split('Þ');
	var nama = _id[1];
	var harga = _id[3];
	var discount = _id[4];
	var harga_ori = harga;
	var myID = _id[0];
	var barcode = _id[5];
	var point = _id[6];
	var vatstat = _id[7];
	if(harga > 0){
		harga = numberWithCommas(harga);
	}else{
		harga = '0.00';
	}
	var nama_length = nama.length;
	var nama1 = nama;
	var nama2 = '';
	var cnt_item = $('#item_'+_id[0]).length;
	if(cnt_item > 0){
		var qty = Number($('#qty_'+_id[0]).val()) + 1;
		$('#qty_'+_id[0]).val(qty);
	}else{
		var baris = '<li class="item" id="item_'+_id[0]+'">';
        baris += '<div class="product-info">';
		baris +='<strong>'+ nama.split('!')[0] +'</strong>';
		baris +='<p>';
		baris +='<span class="pull-left" style="margin-top:5px;width:120px;">Rp.'+harga+'</span>';
		baris +='<a href="#" onclick="deletes(\'' +_id[0]+ '\')" class="spn_hrg pull-right"><span class="glyphicon glyphicon-remove pull-right"></span></a>';
		baris +='<span class="spn_hrg pull-right" id="spn_hrg_'+_id[0]+'">'+harga+'</span>';
		baris +='<input type="text" class="pull-left" id="qty_'+_id[0]+'" name="jml_beli[]" onkeypress="return check_int(event)" onkeyup="jml_beli(\'' +_id[0]+ '\')" value="1" style="margin-left:-10px;margin-top:5px;width:15%;text-align:center">';
		baris +='</p>';
		baris +='<input type="hidden" name="cod_item[]" value="'+myID+'">';
		baris +='<input type="hidden" name="barcode[]" value="'+barcode+'">';
		baris +='<input type="hidden" name="point[]" value="'+point+'">';
		baris +='<input type="hidden" id="vatstat_'+_id[0]+'" name="vatstat[]" value="'+vatstat+'">';
		baris +='<input type="hidden" id="hrg_'+_id[0]+'" value="'+harga_ori+'" name="harga_ori[]" />';        
        baris +='<input type="hidden" class="_disc" name="_disc[]" id="disc_'+_id[0]+'" value="'+discount+'" style="width:40%; text-align:center;" placeholder="Disc." disabled /></span>';
		baris +='<input type="text" class="pull-left" disabled onkeyup="promo(\'' +_id[0]+ '\')" id="disc_ttl_'+_id[0]+'" name="disc_ttl[]" ids="'+vatstat+'" placeholder="Disc." style="margin-top:-5px;width:25%;text-align:right"/>';
		baris +='<input type="hidden" name="hrga[]" id="ttl_hrg_'+_id[0]+'" value="" ids="'+vatstat+'" />';
		baris +='</div></li>';
	
		$('#list_cart').append(baris);
	}
	var qty = $('#qty_'+_id[0]).val();
	var hargaa = $('#hrg_'+_id[0]).val();
	var disc = $('#disc_'+_id[0]).val();
	HitungTotalBayar(_id[0], qty, hargaa, disc, vatstat, 0);
}
function jml_beli(id){
	var qty = $('#qty_'+id).val();
	var hargaa = $('#hrg_'+id).val();
	var disc = $('#disc_'+id).val();
	var vatstat = $('#vatstat_'+id).val();
	HitungTotalBayar(id, qty, hargaa, disc, vatstat, 0);	
}
function promo(id){
	var qty = $('#qty_'+id).val();
	var hargaa = $('#hrg_'+id).val();
	var disc = $('#disc_'+id).val();
	var vatstat = $('#vatstat_'+id).val();
	HitungTotalBayar(id, qty, hargaa, disc, vatstat, 1);	
}

function HitungTotalBayar(id, qty, hrg, disc, vatstat, ispromo){
	var Total = 0
	var TotalNP = 0;
	var myTTL = '0.00';
	var myTTLNP = '0.00';
	if (vatstat == 'NOVAT'){
		TotalNP = qty * hrg;
		$('#ttl_hrg_'+id).val(TotalNP);		
	}else{
		Total = qty * hrg;
		$('#ttl_hrg_'+id).val(Total);
	}
	
	
	var _disc = 0;
	var _discNP = 0;
	if(vatstat != 'NOVAT'){		
		if (disc > 0){
			//_disc = Total * (disc / 100);
		}
		if(ispromo == 0){
			$('#disc_ttl_'+id).val(_disc);
		}

		if(Total > 0){
			myTTL = numberWithCommas(Total);
		}
		$('#spn_hrg_'+id).html(myTTL);
	}
	if(vatstat == 'NOVAT'){		
		if (disc > 0){
			//_discNP = TotalNP * (disc / 100);
		}
		if(ispromo == 0){
			$('#disc_ttl_'+id).val(_discNP);
		}
		
		if(TotalNP > 0){
			myTTLNP  = numberWithCommas(TotalNP);
		}
		$('#spn_hrg_'+id).html(myTTLNP);
	}
	var ppn = 0;
	var ttl_ppn = 0;
	var GrandBayar = 0;
	var prices_ttls = 0;
	var prices_ttls_vat = 0;
	$('input[name="hrga[]"]').each(function() {
		var elem = $(this).attr('ids');				
		if (elem == "NOVAT"){
			prices_ttls_vat += Number($(this).val()); 
		} else{
			prices_ttls +=  Number($(this).val());
		}
	});

	var disc_ttl = 0;
	var disc_ttl_vat = 0;
	$('input[name="disc_ttl[]"]').each(function() {
		var elem = $(this).attr('ids');		
		if (elem == "NOVAT"){
			disc_ttl_vat += Number($(this).val()); 
		} else{
			disc_ttl +=  Number($(this).val());
		}
	});	
	var disc_ttlku = 0;
	if(disc_ttl > 0){
		disc_ttlku = numberWithCommas(disc_ttl);
	}
	
	var prices_ttlku = '0.00';
	var notax = 0;
	var notaxku = '0.00';
	var ttlku = '0.00';
	var ttlkuvat = '0.00';
	var potonganku = '0.00';
	$('#_tax').val(0);
	var nilai_ppn = '0.00';
	var ppn = 0.1;
	if (prices_ttls == 0 && prices_ttls_vat == 0){
		ttlku = '0.00';
		ttlkuvat = '0.00';
		nilai_ppn = '0.00';
		prices_ttlku = '0.00';
		notax = '0.00';
		$('#notax').val(0);
		$('#_tax').val(0);
		$('#ttl').html(0);
		$('#grnd_ttl').val(0);
		$('#potongan').val(0);
	}else{
		ttlku = Number(prices_ttls) - Number(disc_ttl);
		ttlkuvat = Number(prices_ttls_vat) - Number(disc_ttl_vat);
		nilai_ppn = Number(ttlku) * Number(ppn);
		//ttlku = Number(ttlku) + Number(nilai_ppn.toFixed(4)) + (Number(prices_ttls_vat) - Number(disc_ttl_vat)); 'KIMID HIlang PPN
		ttlku = Number(ttlku) + (Number(prices_ttls_vat) - Number(disc_ttl_vat));
		prices_ttlku = numberWithCommas(parseFloat(prices_ttls.toFixed(4)));
		notax = Number(prices_ttls_vat);
		notaxku= numberWithCommas(parseFloat(Number(prices_ttls_vat).toFixed(4)));
		
		$('#_tax').val(nilai_ppn.toFixed(4));
		$('#ttl').html(numberWithCommas(parseFloat(ttlku.toFixed(4))));
		$('#grnd_ttl').val(ttlku.toFixed(4));
		$('#_potongan').val((Number(disc_ttl) + Number(disc_ttl_vat)).toFixed(4));
		potonganku = numberWithCommas(parseFloat((Number(disc_ttl) + Number(disc_ttl_vat)).toFixed(4)));
		
	}
	
	if(nilai_ppn > 0){
		nilai_ppn = numberWithCommas(parseFloat($('#_tax').val()));
	} 
	$('#tax').html(nilai_ppn);
	$('#spn_disc').html(disc_ttlku);
	$('#sub_ttl').html(prices_ttlku);
	$('#sb_ttl').val(prices_ttlku);
	$('#_notax').val(notax);
	$('#notax').html(notaxku);
	$('#potongan').html(potonganku);
	
}

function numberWithCommas(x) {
	
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
$('#nominal_cash').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
</script>