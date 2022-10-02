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
.list-product{margin-bottom:5px;}
.product-list-in-box>.item {
    -webkit-box-shadow: none;
    box-shadow: none;
    border-radius: 0;
    border-bottom: 1px solid #f4f4f4;
}
.products-list>.item {
	padding: 10px 0;
}
.products-list .product-img img {
    width: 50px;
    height: 50px;
}
img {
    vertical-align: middle;
}
.products-list {
    list-style: none;
    margin: 0;
    padding: 0;
}
.products-list .product-img {
    float: left;
	margin-right: 5px;
}
products-list .product-info {
    margin-left: 60px;
}

.panel_product{
	height:570px;
	overflow-y:scroll;
}
.panel_products{
	height:285px;
	overflow-y:scroll;
}
.itm_prd{
	cursor:pointer;
}
.itm_cat_prd{
	cursor:pointer;
}
.spn_hrg{
	margin-top:5px;
	margin-right:10px;
}
.products-list>.item{
	padding-bottom:25px;
}

</style>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
// $available = $this->session->userdata('available');
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
				<div class='col-sm-4'>
					<form id="frm_transaksi" method="post">
					<div class="panel panel-primary" id='PelangganArea'>
						<div class="panel-heading"><i class='fa fa-user'></i> Transaksi </div>
						<div class="panel-body panel_products">
							<ul class="products-list product-list-in-box" id="list_cart">
            
            	  			</ul>
						</div>
                        
                        <div class="panel-footer clearfix" style="background-color:#fff;">
                        	
                <!-- /.item -->
                        	<ul class="products-list product-list-in-box">
							<li class="item" style="padding-bottom:15px">
                                  <div class="product-info">
                                    <strong>Sub Total (NOPJK) </strong>
                                     <span class="pull-right" id="notax">0.00</span>
                                     <input type="hidden" name="_notax" value="" id="_notax"/>
                                  </div>
                                </li>
                                <li class="item" style="padding-bottom:15px">
                                  <div class="product-info">
                                    <strong>Sub Total </strong>
                                     <span class="pull-right" id="sub_ttl">0.00</span>
                                     <input type="hidden" name="sb_ttl" id="sb_ttl" value="0" />
                                  </div>
                                </li>
                <!-- /.item -->
                                <li class="item" style="padding-bottom:15px; display:none">
                                  <div class="product-info">
                                    <strong>Tax </strong>
                                     <span class="pull-right" id="tax">0.00</span>
                                     <input type="hidden" name="_tax" value="" id="_tax"/>
                                  </div>
                                </li>
								
                                <li class="item" style="padding-bottom:15px">
                                  <div class="product-info">
                                    <strong>Potongan</strong>
                                     <span class="pull-right" id="potongan">0.00</span>
                                     <input type="hidden" name="_potongan" value="" id="_potongan"/>
                                  </div>
                                </li>
                                
                            <li class="item" style="padding-bottom:15px">                                  
                                  <div class="product-info">
                                    <strong>Grand Total </strong>
                                    <span class="pull-right" id="ttl">0.00</span>
                                    <input type="hidden" name="grnd_ttl" value="" id="grnd_ttl"/>
                                  </div>
                                </li>
                <!-- /.item -->
              			</ul>
                        
                        
                        <div class='row'>
							<div class='col-sm-6'>
								<!--<button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
									<i class='fa fa-print'></i> Cetak
								</button> -->
                            	<!--<button type='button' class='btn btn-warning btn-block btn_parking'>-->
								<button type='button' class='btn btn-warning btn-block btn_parking'>	
									<i class='fa fa-floppy-o'></i> CEK ECOM
								</button>
							</div>
							<div class='col-sm-6'>
                            	<button type="button" class="btn btn-block btn-success btn_save" >Payment 
                					<i class="fa fa-arrow-circle-right"></i>
                                </button>
							</div>
						</div>
                        
                        </div>
					</div>
                    </form>
				</div>
				<div class='col-sm-8'>
					<div class="panel panel-primary">
						<div class="panel-heading">
							 <div class="input-group">
							 				<span class="input-group-btn">
                              					<button class="btn btn-danger" id="back"  type="button">Back</button>
                               				</span>
      										<input type="text" class="form-control" name="pencarian" placeholder="Search..." id="pencarian">
											<span class="input-group-btn">
                              					<button class="btn btn-success" onclick="searchProduct()" type="button">Search</button>
                               				</span>
										</div>
						</div>
						<div class="panel-body panel_product">	                         
							<div class="row" id="dftr_produk" style="display:none">
								                       
                            </div>
							<div class="row" id="dftr_cat_produk" style="display:block">
								<?php
									if(!empty($category)){
										foreach($category as $cat){											
											echo '<div class="col-sm-4 itm_cat_prd" id="'.$cat->Code.'">
														<div class="thumbnail ">      			
															<div class="caption">
																<p style="font-size:20px"><b>'.$cat->Code.'</b></span></p>
															</div>										
														</div>
													</div>';											
										}
									}
								?> 
								
								<?php
									if(!empty($promo)){
										foreach($promo as $cat){											
											echo '<div class="col-sm-4 itm_cat_prd" id="'.$cat->Promo_Code.'">
														<div class="thumbnail ">      			
															<div class="caption">
																<p style="font-size:20px"><b>'.$cat->Promo_Code.'</b></span></p>
															</div>										
														</div>
													</div>';											
										}
									}
								?>    
                            </div>							
						</div>                      
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>
<div class="modal" id="ModalConfirms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
						<h4 class="modal-title" id="ModalHeader">Confirm</h4>
					</div>
					<div class="modal-body" id="ModalContent">
						<?php echo form_open('penjualan/confirm', array('id' => 'frm_confirm')); ?>
						<div class='form-group'>
							<label>No. Order</label><label class="err_msg" style="color:red; float:right;"></label>
							<input type='text' name='no_order' class='form-control no_order' id='no_order'>
						</div>
						<div class='form-group hide'>
							<label>Store ID</label>
							<input type='text' name='store_id' class='form-control store_id' id='store_id' value="<?php echo  $this->session->userdata('storeId');?>">
						</div>
						

						<?php echo form_close(); ?>
					</div>
					<div class="modal-footer" id="ModalFooter">
					<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
					<button type='button' class='btn btn-primary btn_cek' autofocus>Cek order</button></div>
				</div>
			</div>
		</div>
<script>
//load_data('','','','');
var cats = '';
$('.itm_cat_prd').click(function(){
	var html = '';	
	$("#tbl_load").html(html);
	var id = $(this).get(0).id;
	if (id != 'PROMO'){
		load_data(id,'','',id);
	}else{
		load_data(id,'','','');
	}
	
	cats = id;
	document.getElementById("dftr_cat_produk").style.display = "none";
	document.getElementById("dftr_produk").style.display = "block";
	$("#pencarian").val("");
});
$('#back').click(function(){
	document.getElementById("dftr_cat_produk").style.display = "block";
	document.getElementById("dftr_produk").style.display = "none";
	$("#pencarian").val("");
});
function load_data(code,category,barcode,searchs){		
	var html = '';	
	$("#tbl_load").html(html);
	var url = '<?php echo site_url('penjualan/load_transaksi');?>';
	$.ajax({
		data : {Code : code, Category : category, Barcode : barcode, Search : searchs},
		url : url,
		type : "POST",
		beforeSend  : function(){ $('#container-loader-list').show(); },
		success:function(response){
			if(response != ''){
				$('#container-loader-list').hide();	
				html += response;				
				$("#dftr_produk").html(html);
			}						
		}
	});	
}
function searchProduct(){
	var nama_product = $('#pencarian').val();
	
	if (cats != 'PROMO'){
		load_data('','','',nama_product);
	}else{
		load_data(cats,'','',nama_product);
	}
	
	document.getElementById("dftr_cat_produk").style.display = "none";
	document.getElementById("dftr_produk").style.display = "block";
}
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
$('.btn_save').click(function(){
	$("._disc").prop('disabled', false);
	//var dt = $('#frm_transaksi').serialize();
	
	if($("#list_cart li").length > 0){
		var url = '<?php echo site_url('pembayaran/add_cart');?>';
		$('#frm_transaksi').attr('action', url);
		$('#frm_transaksi').submit();
	}else{
		alert('Silahkan pilih produk');
		return false;
	}
	
});



function deletes(id){
	$('#item_'+id).remove();
	//$('#item_'+id).hide();
	$('#qty_'+id).val(0);
	$('#hrg_'+id).val(0);
	$('#disc_'+id).val(0);
	var qty = $('#qty_'+id).val();
	var hargaa = $('#hrg_'+id).val();
	var disc = $('#disc_'+id).val();
	HitungTotalBayar(id, qty,hargaa, disc);
}

$('.btn_parking').click(function(){
	$('#frm_confirm').each(function(){
		this.reset();
	});
	$('.err_msg').text('');
	$('#ModalConfirms').modal('show');
	// $('#ModalHeader').html('Berhasil');
});
$(document).on('click', '.btn_cek', function(e){
	var no_order = $('#no_order').val();
	if (no_order != ''){
	$('.err_msg').text('');
	$.ajax({
		url: "<?php echo site_url('penjualan/confirm_detail'); ?>/"+no_order,
		type: "POST",
		cache: false,
		data: '',
		//dataType:'json',
		success: function(datas){			
			if(datas == 'Data transaksi tidak ditemukan'){
				$('.err_msg').text(datas);
			}else{
				// e.preventDefault();
				//$('#ModalConfirms').modal('hide');
				var CaptionHeader = 'Transaksi Nomor Nota ' + no_order;
				$('.modal-dialog').removeClass('modal-sm');
				$('.modal-dialog').addClass('modal-lg');
				$('#ModalHeader').html(CaptionHeader);
				$('#ModalContent').load('<?php echo site_url('penjualan/confirm_transaksi');?>/'+no_order);
				$('#ModalFooter').html("<button type='button' class='btn btn-success' data-dismiss='modal'>Confirm</button>");
				//$('#ModalGue').modal('show');
			}
		}
	});}
});
$('#ModalConfirms').on('hidden.bs.modal', function () {
    location.reload();
})
</script>
<?php $this->load->view('include/footer'); ?>