<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Penjualan extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('KASIR');
		
		if( ! in_array($level, $allowed))
		{
			redirect('secure/logout');
		}
	}

	public function index(){
		$app_login = $this->session->userdata('app_login');
		$ip=$this->input->ip_address();
		//error_log($ip);
		if(!$app_login){
			redirect();
		}else{
			$this->transaksi();
		}
	}

	public function transaksi()
	{
		$level = $this->session->userdata('ap_level');
		$dt = array();
		//$code 	= !empty($this->input->post('Code')) ? $this->input->post('Code') : '*';
		//$category	= !empty($this->input->post('Category')) ? $this->input->post('Category') : '*';
		//$barcode 	= !empty($this->input->post('Barcode')) ? $this->input->post('Barcode') : '*';
		//$store_id	= !empty($this->input->post('StoreID')) ? $this->input->post('StoreID') : 0;
		$status = '';
		$post_data = array();
		// Gandhi
		// $dt = '';
		// var_dump($this->session->userdata());
		// exit();
		$filter = '$filter';
		if($level == 'KASIR'){
			$url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_GenProductPostGroup?$filter=Show_in_POS eq true";
			$data_api = $this->send_api->get_data($url);
			$dt['category'] = json_decode($data_api)->value;
			$this->load->view('penjualan/transaksi', $dt);
		}
	}
	
	public function confirm_detail($id_penjualan){
		$store_id = $this->session->userdata('storeId');
		$post_data = array(
			'OrderNo'		=> $id_penjualan,
			'PosId'			=> $store_id,
			'Confirm'		=> true
		);
		$url = URL_API.'SalesOrder/ViewSalesOrderbyNo';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		//['detail'] = '';
		//$dt['detail'] = $detail;
		if($detail->Status == 1){
			echo '';
		}else{
			echo 'Data transaksi tidak ditemukan';
			//error_log('Data transaksi tidak ditemukan');
		}		
	}
	
	public function confirm_transaksi($id_penjualan){
		$store_id = $this->session->userdata('storeId');
		$post_data = array(
			'OrderNo'		=> $id_penjualan,
			'PosId'			=> $store_id,
			'Confirm'		=> true
		);
		$url = URL_API.'SalesOrder/ViewSalesOrderbyNo';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$dt['detail'] = json_decode($data_api);
		$this->load->view('penjualan/confirm_detail', $dt);
	}
	
	function send_confirm($id_penjualan){
		$post_data = array(
			'OrderNo'		=> $id_penjualan,
			'PosId'			=> $this->session->userdata('storeId'),
			'Confirm'		=> true
		);
		$url = URL_API.'SalesOrder/ConfirmTransaction';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		echo $detail->Status;
	}
	
	function load_transaksi2(){
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$code 	= !empty($this->input->post('Code')) ? $this->input->post('Code') : '*';
		$category	= !empty($this->input->post('Category')) ? $this->input->post('Category') : '*';
		$barcode 	= !empty($this->input->post('Barcode')) ? $this->input->post('Barcode') : '*';
		$search	= !empty($this->input->post('Search')) ? strtoupper($this->input->post('Search')) : '';
		$status = '';
		$post_data = array();
		$status = '';
		$post_data = array(
			'Code'		=> $code,
			'Category'	=> $category,
			'Barcode'	=> $barcode,
			'Search'	=> $search,
			'StoreID'	=> $this->session->userdata('storeId')
		);
		$filter = '$filter';
		$url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item?$filter=Gen_Product_Posting_Group eq '$code'";
		$data_api = $this->send_api->get_data($url);
		$dt['itemku'] = json_decode($data_api)->value;
		$this->load->view('penjualan/load_transaksi', $dt);
	}

	function load_transaksi(){
		if ($this->input->post('Code') != "PROMO" && $this->input->post('Code') != "PROMO LUXO" && $this->input->post('Code') != "PROMO LUXOFOOD" && $this->input->post('Code') != "PROMO - LUXO" && $this->input->post('Code') != "PROMO - LUXOFOOD") {
			$level = $this->session->userdata('ap_level');
			$dt = array();
			$code 	= !empty($this->input->post('Code')) ? $this->input->post('Code') : '*';
			$filter = '$filter';
			$url = URL_API.'/Company(\'be489792-ee2f-ed11-97e8-000d3aa1ef31\')/POS_Item?$filter=Gen_Product_Posting_Group eq ' . sprintf("'%s'", $code) ;
			
			
			$data_api = $this->send_api->get_data($url);
				
			$dt['itemku'] = json_decode($data_api)->value;		
			//$dt['post_data'] = $post_data;		
		}
		else{
			
			$level = $this->session->userdata('ap_level');
			$dt = array();
			$search	= !empty($this->input->post('Search')) ? strtoupper(trim($this->input->post('Search'))) : '';
			$post_data = array(
				//'Code'		=> $search,				
				'Code'		=> '',				
				'LocationCode'	=> $this->session->userdata('storeId')
			);
			$url = URL_API.'SalesOrder/DiscountAdhoc';
			$data_api = $this->send_api->send_data($url, $post_data);
				
			$dt['itemku'] = json_decode($data_api);

			/*if($this->input->post('Code') == "PROMO LUXO" || $this->input->post('Code') == "PROMO LUXOFOOD" || $this->input->post('Code') == "PROMO - LUXO" || $this->input->post('Code') == "PROMO - LUXOFOOD")
			{
				foreach($dt['itemku']->DiscountAdhoc as $idx => $it)
				{
					if(strpos($it->Code,"PROMO LUXO",0) === false && strpos($it->Description,"PROMO LUXO",0) === false)
					{
						unset($dt['itemku']->DiscountAdhoc[$idx]);
					}
				}	
			}
			elseif($this->input->post('Code') == "PROMO")
			{
				foreach($dt['itemku']->DiscountAdhoc as $idx => $it)
				{
					if(strpos($it->Code,"PROMO LUXO",0) !== false || strpos($it->Description,"PROMO LUXO",0) !== false)
					{
						unset($dt['itemku']->DiscountAdhoc[$idx]);
					}
				}	
			}*/

			if($search !== '')
			{
				foreach($dt['itemku']->DiscountAdhoc as $idx => $it)
				{
					if(strpos($it->Code,$search,0) === false && strpos($it->Description,$search,0) === false)
					{
						unset($dt['itemku']->DiscountAdhoc[$idx]);
					}
				}	
			}
		}
		
		$this->load->view('penjualan/load_transaksi', $dt);
	}
	function load_detail_promo(){
		$level = $this->session->userdata('ap_level');
			$dt = array();
			$search	= !empty($this->input->post('Search')) ? strtoupper($this->input->post('Search')) : '';
			$post_data = array(
				'Code'		=> $search,				
				'LocationCode'	=> $this->session->userdata('storeId')
			);
			$url = URL_API.'SalesOrder/DiscountAdhoc';
			$data_api = $this->send_api->send_data($url, $post_data);
			echo json_encode($data_api);
	}
	
	public function simpan_transaksi(){
		$dt_pelanggan =  $this->input->post('id_pelanggan');
		$type_bayar =  $this->input->post('type_bayar');
		$type_pay = $this->input->post('type_pay');
		$nilai_bayar =  $this->input->post('nilai_bayar');
		$id_kasir =  $this->input->post('id_kasir');
		$nama_bank = $this->input->post('nama_bank');
		$kembalian = $this->input->post('kembalian');
		$idr_convert = $this->input->post('idr_convert');		
		$idr_point = $this->input->post('idr_point');
		$TotalBayar = $this->input->post('cash');
		$pelanggan = explode('Þ',$dt_pelanggan);
		$id_pelanggan = $pelanggan[0];
		$cart = $this->session->userdata('SalesOrderLine');
		$CountLine =  count($cart);
		$sales_pay = array();
		$point_int = 0;
		$nilaiafterpoin = 0;
		for($i=0;$i<sizeof($type_bayar);$i++){
			if($type_bayar[$i] > 0 || !empty($type_bayar[$i])){
				//if($type_bayar[$i] == 'CREDIT' || $type_bayar[$i] == 'DEBIT'){
				//	$type_bayar[$i] = $type_pay[$i];
				//}
				$bayar = '';
				if($type_bayar[$i] == 'CASH'){
					$bayar = 'CASH';
				}
				else {
					$bayar = $type_pay[$i];
				}
				//error_log('ok');
				$sales_pay[$i] = array(
					'StoreId'					=> $this->session->userdata('storeId'),
					'PaymentMethodCode'			=> $bayar,
					'PaymentAmount'				=> str_replace('.','',$nilai_bayar[$i]),
					'PaymentTypeDescription'	=> $nama_bank[$i],
					'Point'						=> 0
				);
				if ($nama_bank[$i] != "") {				
					$point_int = $point_int + (int)$nama_bank[$i];
				}				
			}
			
		}
		//error_log(serialize($sales_pay));
		foreach($cart as $c){
			$sales_item[] = array(
				'ItemCode'	=> $c['ItemCode'],
				'Qty'		=> $c['Qty'],
				'UnitPrice'	=> $c['UnitPrice'],
				'Discount'	=> $c['Discount'],
				'Point'		=> $c['Point'],
				'Barcode'	=> $c['Barcode'],
				'VATStatus'	=> $c['VATStatus']
			);
		}
		
		$CountPayment = count($sales_pay);
		$ip=$this->input->ip_address();
		$post_data = array(
			'OrderNo'			=> 0,
			'IPPos'				=> $ip,
			'PosId'				=> $this->session->userdata('storeId'),
			'DocumentType'		=> 1,
			'CustomerNo'		=> $id_pelanggan,
			'UserCode'			=> $id_kasir,
			'CountLine'			=> $CountLine,
			'OrderNoToReturn'	=> '',
			'CountPayment'		=> $CountPayment,
			'SalesOrderLine'	=> $sales_item,
			'SalesPayment'		=> $sales_pay,
			'TotalBayar'		=> $TotalBayar,
			'Kembalian'			=> $kembalian
		);
		//error_log(serialize($post_data));
		$url = URL_API.'SalesOrder/Transaction/';
		//error_log($url);
		
		$data_api = $this->send_api->send_data($url, $post_data);
		
		$this->session->set_userdata('print_data', '');
		$this->session->set_userdata('print_data', $data_api);

		
		// minus poin kimid
		/*if ($id_pelanggan != '011111111111' && $point_int != "0"){
			$nilai = (int)$nilaiafterpoin % (int)$idr_convert;
			$url = URL_API_WEB.'user/update_point';
			$post_data = array(
				'phone'=> $id_pelanggan,
				'point'=> $point_int,
				'capture'=> "minus"
			);
			$data_api3 = $this->send_api->send_data($url, $post_data);
		};

		//plus point kimid		
		$nilaiafterpoin = (int)$TotalBayar - ($point_int * (int)$idr_point);
		if ($id_pelanggan != '011111111111'){
			$nilai = (int)$nilaiafterpoin / (int)$idr_convert;
			$url = URL_API_WEB.'user/update_point';
			$post_data = array(
				'phone'=> $id_pelanggan,
				'point'=> floor($nilai),
				'capture'=> "plus"
			);
			$data_api2 = $this->send_api->send_data($url, $post_data);	
		};*/
	
		//$dt_json = json_decode($data_api);
		//error_log(serialize($data_api));
		//$status = $dt_json->Status;
		//error_log(serialize($data_api));
		echo $data_api;
		
	}

	public function parking(){
		$dt_pelanggan =  $this->input->post('id_pelanggan');
		$type_bayar =  $this->input->post('type_bayar');
		$type_pay = $this->input->post('type_pay');
		$nilai_bayar =  $this->input->post('nilai_bayar');
		$id_kasir =  $this->input->post('id_kasir');
		$nama_bank = $this->input->post('nama_bank');
		$kembalian = $this->input->post('UangKembalian');
		$pelanggan = explode('Þ',$dt_pelanggan);
		$id_pelanggan = $pelanggan[0];
		$cart = $this->session->userdata('SalesOrderLine');
		$CountLine =  count($cart);
		$sales_pay = array();
		
		for($i=0;$i<sizeof($type_bayar);$i++){
			if($type_bayar[$i] > 0 || !empty($type_bayar[$i])){
				if($type_bayar[$i] == 'CREDIT' || $type_bayar[$i] == 'DEBIT'){
					$type_bayar[$i] = $type_pay[$i];
				}
				//error_log('ok');
				$sales_pay[$i] = array(
					'StoreId'					=> $this->session->userdata('storeId'),
					'PaymentMethodCode'			=> $type_bayar[$i],
					'PaymentAmount'				=> str_replace('.','',$nilai_bayar[$i]),
					'PaymentTypeDescription'	=> $nama_bank[$i],
					'Point'						=> 0
				);
			}
		}
		//error_log(serialize($sales_pay));
		foreach($cart as $c){
			$sales_item[] = array(
				'ItemCode'	=> $c['ItemCode'],
				'Qty'		=> $c['Qty'],
				'UnitPrice'	=> $c['UnitPrice'],
				'Discount'	=> $c['Discount'],
				'Point'		=> $c['Point'],
				'Barcode'	=> $c['Barcode']
			);
		}
		
		$CountPayment = count($sales_pay);
		$ip=$this->input->ip_address();
		$post_data = array(
			'OrderNo'			=> 0,
			'IPPos'				=> $ip,
			'PosId'				=> $this->session->userdata('storeId'),
			'DocumentType'		=> 1,
			'CustomerNo'		=> $id_pelanggan,
			'UserCode'			=> $id_kasir,
			'CountLine'			=> $CountLine,
			'OrderNoToReturn'	=> '',
			'CountPayment'		=> $CountPayment,
			'SalesOrderLine'	=> $sales_item,
			'SalesPayment'		=> $sales_pay,
			'Kembalian'			=> $kembalian
		);
		//error_log(serialize($post_data));
		$url = URL_API.'SalesOrder/Transaction/';
		//error_log($url);
		$data_api = $this->send_api->send_data($url, $post_data);
		$this->session->set_userdata('print_data', '');
		$this->session->set_userdata('print_data', $data_api);
		//$dt_json = json_decode($data_api);
		//error_log(serialize($data_api));
		//$status = $dt_json->Status;
		//error_log(serialize($data_api));
		echo $data_api;
		
	}

	public function cek_nota($nota){
		$this->load->model('m_penjualan_master');
		$cek = $this->m_penjualan_master->cek_nota_validasi($nota);
		if($cek->num_rows() > 0){
			return FALSE;
		}
		return TRUE;
	}
	
	public function ctak_trans(){
		$out = '';
		//$this->load->model('Setting_m');
		////$opsi_val_arr = $this->Setting_m->get_key_val();
		//foreach ($opsi_val_arr as $key => $value){
			//$out[$key] = $value;
		//}
		$dt['out'] = $out;
		$this->load->view('penjualan/cetak_v', $dt);
	}

	public function transaksi_cetaks(){
		$printr = $this->session->userdata('print_data');
		$dt_json = json_decode($printr);
		$print_dt = $dt_json->SalesOrder;
		
		$nama_pelanggan = 'Test';
		$kasir = 'Kasir1';
		$nomor_nota = $print_dt->OrderNo;
		
		$tanggal = '6788';
		$order_item =  $print_dt->SalesOrderLine;
		
		$this->load->model('Setting_m');
		$opsi_val_arr = $this->Setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
			
		$pdf = new FPDF('P','mm','A5');
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(130, 4, $out['company_name'], 0, 0, 'C'); 
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(130, 4, $out['alamat'].', '.$out['telp'].' email : '.$out['email'], 0, 0, 'C'); 
		$pdf->SetFont('Arial','',10);
		$pdf->Ln();
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Nota', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $nomor_nota, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Tanggal', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $tanggal, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Kasir', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $kasir, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Pelanggan', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $nama_pelanggan, 0, 0, 'L');
		$pdf->Ln();
		

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		
		$pdf->Cell(25, 5, 'Kode', 0, 0, 'L');
		$pdf->Cell(40, 5, 'Item', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Harga', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Qty', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Subtotal', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		
		$this->load->helper('text');

		$no = 0;
		foreach($order_item as $kd){
			$nama_barang = $kd->ItemName;
			$nama_barang = character_limiter($nama_barang, 20, '..');
			
			$pdf->Cell(25, 5, $kd->ItemCode, 0, 0, 'L');
			$pdf->Cell(40, 5, $nama_barang, 0, 0, 'L');
			$pdf->Cell(25, 5, str_replace(',', '.', number_format($kd->UnitPrice)), 0, 0, 'L');
			$pdf->Cell(15, 5, $kd->Qty, 0, 0, 'L');
			$pdf->Cell(25, 5, str_replace(',', '.', number_format($kd->SubTotal)), 0, 0, 'L');
			$pdf->Ln();

			$no++;
		}

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(105, 5, 'Total Bayar', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format($print_dt->TotalBayar)), 0, 0, 'L');
		$pdf->Ln();

		//$pdf->Cell(105, 5, 'Cash', 0, 0, 'R');
		//$pdf->Cell(25, 5, str_replace(',', '.', number_format($cash)), 0, 0, 'L');
		//$pdf->Ln();

		$pdf->Cell(105, 5, 'Kembali', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format($print_dt->Kembalian)), 0, 0, 'L');
		$pdf->Ln();

		//$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		//$pdf->Ln();

		//$pdf->Cell(25, 5, 'Catatan : ', 0, 0, 'L');
		//$pdf->Ln();
		//$pdf->Cell(130, 5, (($catatan == '') ? 'Tidak Ada' : $catatan), 0, 0, 'L');
		//$pdf->Ln();

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(130, 5, "Terimakasih telah berbelanja dengan kami", 0, 0, 'C');

		$pdf->Output();
	}
	
	
	public function transaksi_cetak()
	{
		$nomor_nota 	= $this->input->get('nomor_nota');
		$tanggal		= $this->input->get('tanggal');
		$id_kasir		= $this->input->get('id_kasir');
		$id_pelanggan	= $this->input->get('id_pelanggan');
		$cash			= $this->input->get('cash');
		$catatan		= $this->input->get('catatan');
		$grand_total	= $this->input->get('grand_total');

		$this->load->model('m_user');
		$kasir = $this->m_user->get_baris($id_kasir)->row()->nama;
		
		$this->load->model('m_pelanggan');
		$this->load->model('Setting_m');
		$opsi_val_arr = $this->Setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		$pelanggan = 'umum';
		if( ! empty($id_pelanggan))
		{
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}

		$this->load->library('cfpdf');		
		$pdf = new FPDF('P','mm','A5');
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(130, 4, $out['company_name'], 0, 0, 'C'); 
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(130, 4, $out['alamat'].', '.$out['telp'].' email : '.$out['email'], 0, 0, 'C'); 
		$pdf->SetFont('Arial','',10);
		$pdf->Ln();
		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Nota', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $nomor_nota, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Tanggal', 0, 0, 'L'); 
		$pdf->Cell(85, 4, date('d-M-Y H:i:s', strtotime($tanggal)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Kasir', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $kasir, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Pelanggan', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $pelanggan, 0, 0, 'L');
		$pdf->Ln();
		//$pdf->Ln();

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		
		$pdf->Cell(25, 5, 'Kode', 0, 0, 'L');
		$pdf->Cell(40, 5, 'Item', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Harga', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Qty', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Subtotal', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$this->load->model('m_barang');
		$this->load->helper('text');

		$no = 0;
		foreach($_GET['kode_barang'] as $kd)
		{
			if( ! empty($kd))
			{
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_barang = character_limiter($nama_barang, 20, '..');

				$pdf->Cell(25, 5, $kd, 0, 0, 'L');
				$pdf->Cell(40, 5, $nama_barang, 0, 0, 'L');
				$pdf->Cell(25, 5, str_replace(',', '.', number_format($_GET['harga_satuan'][$no])), 0, 0, 'L');
				$pdf->Cell(15, 5, $_GET['jumlah_beli'][$no], 0, 0, 'L');
				$pdf->Cell(25, 5, str_replace(',', '.', number_format($_GET['sub_total'][$no])), 0, 0, 'L');
				$pdf->Ln();

				$no++;
			}
		}

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(105, 5, 'Total Bayar', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format($grand_total)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(105, 5, 'Cash', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format($cash)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(105, 5, 'Kembali', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format(($cash - $grand_total))), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(25, 5, 'Catatan : ', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 5, (($catatan == '') ? 'Tidak Ada' : $catatan), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 5, '-----------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(130, 5, "Terimakasih telah berbelanja dengan kami", 0, 0, 'C');

		$pdf->Output();
	}


	public function ajax_pelanggan()
	{
		if($this->input->is_ajax_request())
		{
			$id_pelanggan = $this->input->post('id_pelanggan');
			$this->load->model('m_pelanggan');

			$data = $this->m_pelanggan->get_baris($id_pelanggan)->row();
			$json['telp']			= ( ! empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= ( ! empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= ( ! empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
		}
	}

	public function ajax_kode()
	{
		if($this->input->is_ajax_request())
		{
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');

			$this->load->model('m_barang');

			$barang = $this->m_barang->cari_kode($keyword, $registered);

			if($barang->num_rows() > 0)
			{
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
				foreach($barang->result() as $b)
				{
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='kodenya'>".$b->kode_barang."</span> <br />
							<span id='barangnya'>".$b->nama_barang."</span>
							<span id='harganya' style='display:none;'>".$b->harga."</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			}
			else
			{
				$json['status'] 	= 0;
			}

			echo json_encode($json);
		}
	}

	public function cek_kode_barang($kode)
	{
		$this->load->model('m_barang');
		$cek_kode = $this->m_barang->cek_kode($kode);

		if($cek_kode->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function cek_nol($qty)
	{
		if($qty > 0){
			return TRUE;
		}
		return FALSE;
	}

	public function history()
	{
		$level = $this->session->userdata('ap_level');
		$post_data = array(
			'PosId'				=> $this->session->userdata('storeId')
		);
		$url = URL_API.'SalesOrder/ViewSalesOrder';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$dt['sales_order'] = json_decode($data_api);
		$this->load->view('penjualan/transaksi_history', $dt);
	}
	function load_history(){
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$start 	= $this->input->post('StartDate');
		$end	= $this->input->post('EndDate');
		$status = '';
		$post_data = array();
		$status = '';
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'PosId'		=> $this->session->userdata('storeId')
		);
		$url = URL_API.'SalesOrder/ViewSalesOrder';
		$data_api = $this->send_api->send_data($url, $post_data);

		$detail = json_decode($data_api);

		$i = 1;
		$data = "";
		if(!empty($detail->SalesOrder)){
			foreach($detail->SalesOrder as $so){				
				$data .= "<tr>";
				$data .= "<td align='center'>".$i.".</td>";
				$data .= "<td>".date('d-M-Y', strtotime($so->TransactionDate))."</td>";
				
				$data .= "<td><a href='".site_url('penjualan/detail_transaksi/'.$so->OrderNo)."' id='LihatDetailTransaksi'><i class='a fa-file-text-o fa-fw'></i> ".$so->OrderNo."</a></td>";
				$data .= "<td align='right'>".number_format($so->TotalPembayaran,2,',','.')."</td>";
				$data .= "<td>".$so->CustomerName."</td>";
				$data .= "<td>".$so->KasirName."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		echo $data;
	}
	
	public function history_shift()
	{
		$level = $this->session->userdata('ap_level');
		$start_date = date('Y-m-d');
		$ip = $this->input->ip_address();
		$post_data = array(
			'MachineCode'	=> $ip
		);
		$url = URL_API.'Report/ReportShift';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$sales_order = json_decode($data_api);
		//$dt_so = $sales_order->Shift;
		$dt['sales_order'] = $sales_order->Shift;
		$this->load->view('penjualan/history_shift', $dt);
	}

	public function history_json()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='".site_url('penjualan/detail-transaksi/'.$row['id_penjualan_m'])."' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> ".$row['nomor_nota']."</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];
		
			if($level == 'admin' OR $level == 'keuangan')
			{
				$nestedData[]	= "<a href='".site_url('penjualan/hapus-transaksi/'.$row['id_penjualan_m'])."' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
	}

	public function detail_transaksi($id_penjualan){
		$post_data = array(
			'OrderNo'		=> $id_penjualan
		);
		$url = URL_API.'SalesOrder/ViewSalesOrderbyNo';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$dt['detail'] = json_decode($data_api);
		$this->load->view('penjualan/transaksi_history_detail', $dt);
	}

	public function hapus_transaksi($id_penjualan)
	{
		if($this->input->is_ajax_request())
		{
			$level 	= $this->session->userdata('ap_level');
			if($level == 'admin')
			{
				$reverse_stok = $this->input->post('reverse_stok');

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->m_penjualan_master->hapus_transaksi($id_penjualan, $reverse_stok);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>".$nota."</b> berhasil dihapus !</font>
					"));
				}
				else
				{
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"));
				}
			}
		}
	}

	public function pelanggan(){
		$post_data = array(
			'No'		=> '*'
		);
		$url = URL_API.'customer/viewcustomer/';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$dt['pelanggan'] = json_decode($data_api);
		$this->load->view('penjualan/pelanggan_data', $dt);
	}

	public function tambah_pelanggan(){
		$this->load->view('penjualan/pelanggan_tambah');
	}
	
	public function simpan_pelanggan(){
		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$city = $this->input->post('city');
		$telepon = $this->input->post('telepon');
		$post_data = array(
			'No'		=> '0',
			'Name'		=> $nama,
			'Address'	=> $alamat,
			'Address2'	=> $alamat,
			'City'		=> $city,
			'PhoneNo'	=> $telepon
		);
		
		$url = URL_API.'Customer/InsertCustomer';
		
		$data_api = $this->send_api->send_data($url, $post_data);
		//error_log(serialize(json_decode($data_api)));
		echo $data_api;
	}
	
}