<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Good_receipt extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('ap_level') == 'inventory'){
			redirect();
		}
	}

	public function index()
	{
		$this->transaksi();
	}

	public function transaksi(){
		$this->session->set_userdata('SalesOrderLine', '');
		$this->session->set_userdata('data_master', '');
		$level = $this->session->userdata('ap_level');
		$post_data = array('Location' => $this->session->userdata('storeId'));
		$url = URL_API.'Purchase/ListPurchaseNo';
		$data_api = $this->send_api->send_data($url, $post_data);
			
			
		$dt['nota'] = json_decode($data_api);
		//$dt['nota'] = $this->m_pengembalian->get_nota();
		$this->load->view('good_receipt/transaksi', $dt);
	}
	
	
	

	public function ajax_nota(){
		$no_nota =  $this->input->post('no_nota');
		$post_data = array(
			'DocNo'		=> $no_nota
		);
		$url = URL_API.'Purchase/ListPurchLine';
		$data_api = $this->send_api->send_data($url, $post_data);
		
		$detail = json_decode($data_api);
		$data_order = $detail->PurchaseLine;
		$detail_order = $data_order->PurchLine;
		$banyak_baris = count($detail_order);
		$json = array();
		if($this->input->is_ajax_request()){
			$nama_barang = array();
			if($banyak_baris > 0){
				foreach($detail_order as $db){
					$kode_barang[] = $db->ItemCode;
					$nama_barang[] = $db->ItemName;
					$jml_beli[] = $db->Qty;
					$line_no[] = $db->LineNo;
				}
			}
			
			$json['nama_brg'] = $nama_barang;
			$json['jml_beli'] = $jml_beli;
			$json['kode_barang'] = $kode_barang;
			$json['line_no'] = $line_no;
			$json['banyak_baris'] = $banyak_baris;
			$json['no_nota'] = $no_nota;
		}
		echo json_encode($json);
	}
	
	public function simpan(){
		$no_nota = $this->input->post('nomor_nota');
		$tgl = date('Y-m-d', strtotime($this->input->post('tanggal')));
		$line_no = $this->input->post('line_no');
		$kode_barang = $this->input->post('kode_barang');
		$qty_receipt = $this->input->post('qty_receipt');
		$qty_ori = $this->input->post('qty_ori');
		for($i=0;$i<sizeof($kode_barang);$i++){
			$dataSet[$i] = array (
				'LineNo'	=> $line_no[$i],
				'ItemCode'	=> $kode_barang[$i],
				'Qty'		=> $qty_ori[$i],
				'QtyRecive'	=> $qty_receipt[$i]
			);	
		}
		$post_data = array(
			'DocNo'		=> $no_nota,
			'Tanggal'	=> $tgl,
			'PurchLine'	=> $dataSet
		);
		
		$url = URL_API.'Purchase/UpdatePurchLine';
		//$url = '';
		$data_api = $this->send_api->send_data($url, $post_data);
		
		echo $data_api;
	}

	
	
}