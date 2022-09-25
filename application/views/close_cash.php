<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

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
						<div class="panel-heading"><i class='fa fa-user'></i> Close Cash Register</div>
						<div class="panel-body">
                       		<strong>Cash</strong>
                        	<input type="text" class='form-control input-block' name="nominal_cash" id="nominal_cash" value="" placeholder="0.00" />
                            <br/>
							<button type="button" class="btn btn-block btn-danger btn_open">Close</button>
						</div>
                        </div>
                     </form>
                     </div>
            
            </div>
        </div>
     </div>
    </div>



		<div class="modal" id="ModalGues" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
						<h4 class="modal-title" id="ModalHeader"></h4>
					</div>
					<div class="modal-body" id="ModalContent"></div>
					<div class="modal-footer" id="ModalFooter"></div>
				</div>
			</div>
		</div>
<script src="<?php echo config_item('bootstrap'); ?>js/bootstrap.min.js"></script>
<script>
$('.btn_open').click(function(){
	var nominal_cash = $('#nominal_cash').val();
	if(nominal_cash != ''){
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin close pada hari ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='close_btn'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGues').modal('show');
	}else{
		alert('Silahkan isi nilai cash penjualan anda');
	}
});


$(document).on('click', '#close_btn', function(e){
	var url = '<?php echo site_url('secure/close_cash');?>';
	var nominal_cash = $('#nominal_cash').val();
	console.log(nominal_cash);
	$.ajax({
		data : {nominal_cash:nominal_cash},
		url : url,
		type : 'POST',
		success:function(response){
			window.location = '<?php echo site_url();?>';
		}
	})
});



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