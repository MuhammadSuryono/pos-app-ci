<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Barang extends MY_Controller 
{
	public function index(){
		$dt = array();
		$code 	= !empty($this->input->post('Code')) ? $this->input->post('Code') : '*';
		$category	= !empty($this->input->post('Category')) ? $this->input->post('Category') : '*';
		$barcode 	= !empty($this->input->post('Barcode')) ? $this->input->post('Barcode') : '*';
		//$store_id	= !empty($this->input->post('StoreID')) ? $this->input->post('StoreID') : 0;
		$status = '';
		$post_data = array();
		$status = '';
		$post_data = array(
			'Code'		=> $code,
			'Category'	=> $category,
			'Barcode'	=> $barcode,
			//'StoreID'	=> $store_id,
			'StoreID'	=> $this->session->userdata('storeId')
		);
		$filter = '$filter';
		$url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item?$filter=Location_Filter eq '" . $this->session->userdata('storeId') . "'" ;
			
			
		$data_api = $this->send_api->get_data($url);
		// echo "<pre>";print_r($url);echo "</pre>";
		// echo "<pre>";print_r($post_data);echo "</pre>";
		// echo "<pre>";print_r($data_api);echo "</pre>";exit;
		$dt['itemku'] = json_decode($data_api)->value;
		$this->load->view('barang/barang_data', $dt);
	}
	
	
	
}