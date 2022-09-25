<?php 
	$id = '';
								
	if(!empty($itemku->Item)){
		foreach($itemku->Item as $it){
			$id = '';
			$id = $it->Code.'Þ'.$it->Name.'Þ'.$it->Stock.'Þ'.$it->Harga.'Þ'.$it->Discount.'Þ'.$it->Barcode.'Þ'.$it->Point;
			echo '<div class="col-md-4 list-product itm_prd" id="'.$id.'">
                  	<div class="thumbnail get_product">
					<img width="200" height="100" src="'.$it->ImageUrl.'" alt="">
                            			
                    <div class="caption">
                    	<p style="text-align:center;">'.$it->Name.'<br/>'.number_format($it->Harga,2,',','.').'</p>
                    </div>
                    </div>
                  </div>';
		}
	}
?>
<script>
$('.itm_prd').click(function(){
	var id = $(this).get(0).id;
	list_cart(id);
});
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
		if(nama_length > 18){
			nama1 = nama.substring(0,18);
			nama2 = nama.substring(18);
			baris +='<strong>'+nama1+'<br/>'+nama2+'</strong> <span> Rp.'+harga+'</span>';
		}else{
			baris +='<strong>'+nama+'</strong> <span> Rp.'+harga+'</span>';
		}
        
		baris +='<input type="hidden" name="cod_item[]" value="'+myID+'">';
		baris +='<input type="hidden" name="barcode[]" value="'+barcode+'">';
		baris +='<input type="hidden" name="point[]" value="'+point+'">';
		//baris +='<div class="pull-right" style="margin-left:40px;">';
		baris +='<a href="#" onclick="deletes(\'' +_id[0]+ '\')" style="margin-left:10px;"><span class="glyphicon glyphicon-remove pull-right"></span></a>';
        baris +='<input type="text" class="pull-right" id="qty_'+_id[0]+'" name="jml_beli[]" onkeypress="return check_int(event)" onkeyup="jml_beli(\'' +_id[0]+ '\')" value="1" style="width:15%; text-align:center; margin-right:5px;"/><br/>';
        baris +='<input type="hidden" id="hrg_'+_id[0]+'" value="'+harga_ori+'" name="harga_ori[]" />';
        
		//baris +='</div>';
        //baris +='<span class="product-description">';
        baris +='<input type="hidden" class="_disc" name="_disc[]" id="disc_'+_id[0]+'" value="'+discount+'" style="width:40%; text-align:center;" placeholder="Disc." disabled /></span>';
		baris +='<input type="hidden" id="disc_ttl_'+_id[0]+'" name="disc_ttl[]" />';
		baris +='<input type="hidden" name="hrga[]" id="ttl_hrg_'+_id[0]+'" value="'+harga_ori+'" />';
        baris +='<span class="spn_hrg pull-right" id="spn_hrg_'+_id[0]+'">'+harga+'</span>';
        baris +='</div></li>';
	
		$('#list_cart').append(baris);
	}
	var qty = $('#qty_'+_id[0]).val();
	var hargaa = $('#hrg_'+_id[0]).val();
	var disc = $('#disc_'+_id[0]).val();
	HitungTotalBayar(_id[0], qty, hargaa, disc);
}

function jml_beli(id){
	var qty = $('#qty_'+id).val();
	var hargaa = $('#hrg_'+id).val();
	var disc = $('#disc_'+id).val();
	HitungTotalBayar(id, qty, hargaa, disc);
}

function HitungTotalBayar(id, qty, hrg, disc){
	var Total = qty * hrg;
	$('#ttl_hrg_'+id).val(Total);
	var _disc = 0;
	if(disc > 0){
		_disc = Total * (disc / 100);
	}
	
	$('#disc_ttl_'+id).val(_disc);
	var myTTL = '0.00';
	if(Total > 0){
		myTTL = numberWithCommas(Total);
	}
	$('#spn_hrg_'+id).html(myTTL);
	var ppn = 0;
	var ttl_ppn = 0;
	var GrandBayar = 0;
	var prices_ttls = 0;
	var prices_ttl = $("input[name^='hrga']").map(function(idx, elem) {
        var elems = elem.value;
        elems = Number(elems);
        prices_ttls += elems;
        return prices_ttls;
    }).get();
	
	var disc_ttl = 0;
	var disc_ttls = $("input[name^='disc_ttl']").map(function(idx, elem) {
        var elems = elem.value;
        elems = Number(elems);
        disc_ttl += elems;
        return disc_ttl;
    }).get();
	var disc_ttlku = 0;
	if(disc_ttl > 0){
		disc_ttlku = numberWithCommas(disc_ttl);
	}
	
	var prices_ttlku = '0.00';
	var ttlku = '0.00';
	$('#_tax').val(0);
	var nilai_ppn = '0.00';
	var ppn = 10 / 100;
	if(prices_ttls > 0){
		ttlku = Number(prices_ttls) - Number(disc_ttl);
		nilai_ppn = Number(ttlku) * Number(ppn);
		ttlku = Number(ttlku) + Number(nilai_ppn);
		prices_ttlku = numberWithCommas(prices_ttls);
	}
	$('#_tax').val(nilai_ppn);
	if(nilai_ppn > 0){
		nilai_ppn = numberWithCommas(nilai_ppn);
	}
	$('#tax').html(nilai_ppn);
	$('#spn_disc').html(disc_ttlku);
	$('#sub_ttl').html(prices_ttlku);
	$('#sb_ttl').val(prices_ttlku);
	$('#ttl').html(numberWithCommas(ttlku));
	$('#grnd_ttl').val(ttlku);
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