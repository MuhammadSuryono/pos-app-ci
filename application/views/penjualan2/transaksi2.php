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
.list-product{margin-bottom:15px;}
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
	height:270px;
	overflow-y:scroll;
}
.itm_prd{
	cursor:pointer;
}
.spn_hrg{
	margin-top:5px;
	margin-left:280px;
}
.products-list>.item{
	padding-bottom:30px;
}
</style>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
$available = $this->session->userdata('available');
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}

if($available < 1){
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
                        	
                        	<ul class="products-list product-list-in-box">
                                <li class="item">
                                  
                                  <div class="product-info">
                                    <strong>Sub Total </strong>
                                     <span class="pull-right" id="sub_ttl">0.00</span>
                                     <input type="hidden" name="sb_ttl" id="sb_ttl" value="0" />
                                  </div>
                                </li>
           
                                <li class="item">
                                  
                                  <div class="product-info">
                                    <strong>Discount </strong>
                                     <span class="pull-right" id="spn_disc">0.00</span>
                                  </div>
                                </li>
                <!-- /.item -->
                                <li class="item">
                                  
                                  <div class="product-info">
                                    <strong>Tax </strong>
                                     <span class="pull-right" id="tax">0.00</span>
                                     <input type="hidden" name="_tax" value="" id="_tax"/>
                                  </div>
                                </li>
                <!-- /.item -->
                            <li class="item">
                                  
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
                            	<button type='button' class='btn btn-warning btn-block'>
									<i class='fa fa-floppy-o'></i> Get Parking
								</button>
							</div>
							<div class='col-sm-6'>
                            	<button type="button" class="btn btn-block btn-success btn_save" >Save 
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
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> List Produk</div>
						<div class="panel-body panel_product">
							
                            <div class="form-horizontal">
								<div class="form-group">
									
									<div class="col-sm-4 col-sm-offset-8">
                                        <div class="input-group">
      										<input type="text" class="form-control" name="pencarian" placeholder="Search..." id="pencarian">
											<span class="input-group-btn">
                              					<button class="btn btn-success" onclick="searchProduct()" type="button">Search</button>
                               				</span>
										</div><!-- /input-group -->
                                           
                                        
									</div>
								</div>
                             </div>
                            
							<div class="row" id="dftr_produk">
                            
                            	
                            	
                                    
                            </div>

						</div>
                        
					</div>
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
<!-- <p class='footer'><?php echo config_item('web_footer'); ?></p> -->

<script>
load_data('','','','');
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
	load_data('','','',nama_product);
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
				//console.log(response);
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



</script>

<?php $this->load->view('include/footer'); ?>