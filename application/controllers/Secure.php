<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Secure extends MY_Controller 
{
	public function construct(){
        parent::__construct();
    }

	public function index(){
		$username 	= $this->input->post('username') != null ? strtoupper($this->input->post('username')) : "";
		$password	= $this->input->post('password');
		$data_api = '';
		$post_data = array();
		$url = '';
		$status = '';
		$dt = array();
		// Parsing IP manual
		// $ip=$this->input->ip_address();
		$ip = "127.0.0.1";
		$app_login = $this->session->userdata('app_login');
		
		if($app_login){
			redirect(site_url('penjualan'));
		}
		if($this->input->is_ajax_request()){
			$status = '';

			$url = URL_API.'/POS_Integration_ValidateUserPasswordLoginPOS?Company=be489792-ee2f-ed11-97e8-000d3aa1ef31';
			$post_data = array(
				'userName'	=> $username,
				'userPassword'	=> $password,
			);
			$data_api = $this->send_api->send_data($url, $post_data);
			$dt = json_decode($data_api);
			$status = $dt->value;
			if($status != "Failed"){
                $explodeStatus = explode(";",$status);
//				$user = $dt->User;
                $status = $explodeStatus[0];
				$applevel = 'KASIR';
                if ($explodeStatus[1] == 'Yes') {
                    $applevel = 'MANAGER';
                }
//				if ($user->StoreId == 'POS-OWNER'){
//					$applevel = 'OWNER';
//				} else if ($user->StoreId == 'POS-MGR'){
//					$applevel = 'MANAGER';
//				}
//				else if ($user->StoreId == 'POS-STOCK'){
//					$applevel = 'STOCK';
//				}
//				else if ($user->StoreId == 'POS-REPORT'){
//					$applevel = 'REPORT';
//				}
//				else {
//					$applevel = 'KASIR';
//				}
				$applevel = 
				$session = array(
					'app_login'	=> TRUE,
//					'ap_id_user' => $user->Code,
//					'ap_password' => $password,
					'ap_level'	=> $applevel,
//					'ap_nama' => $username,
					'storeId'	=> $status,
					'available'	=> 1,
					'ap_level_caption' => $applevel,
//					'ap_store_name' => $user->StoreName,
//					'ap_store_address' => $user->Address,
//					'ap_store_postcode' => $user->PostCode,
//					'ap_store_HP' => $user->HP,
//					'ap_store_city' => $user->City
				);
				$this->session->set_userdata($session);	
				$level = $this->session->userdata('ap_level');
				$URL_home = site_url('penjualan');
				
				if($level == 'OWNER'){
					$URL_home = site_url('reportowner');
				}
				if($level == 'REPORT'){
					$URL_home = site_url('reportowner');
				}
				if($level == 'MANAGER'){
					$URL_home = site_url('pengembalian/');
				}
				if($level == 'STOCK'){
					$URL_home = site_url('reportstock/');
				}
				if($level == 'KASIR'){
					$URL_home = site_url('penjualan/');
				}
				$json['status']		= 1;
				$json['url_home'] 	= $URL_home;
				echo json_encode($json);
			}else{
				$this->query_error("Login Gagal, Cek Kombinasi Username & Password !");
			}
		}else{
			$this->load->view('secure/login_page');
		}

	}

	function open_cash(){
		$ip=$this->input->ip_address();
		$nominal_cash = $_POST['nominal_cash'];
		$nominal_cash = str_replace('.','',$nominal_cash);
		//error_log($nominal_cash);
		$post_data = array(
			'UserCode'		=> $this->session->userdata('ap_id_user'),
			'EntryType'		=> 0,
			'MachineCode'	=> $ip,
			'StoreCode'		=> $this->session->userdata('storeId'),
			'Amount'		=> $nominal_cash
		);
		$url = URL_API.'SalesOrder/OpenCloseStore';
		$data_api = $this->send_api->send_data($url, $post_data);
		$dt = json_decode($data_api);
		$open_close = $dt->OpenClose;
		$status = $open_close->Status == '0' ? $open_close->Status : 1;
		$this->session->set_userdata('available', 0);
		echo json_encode($dt);
	}
	
	function close_cash(){
		$ip=$this->input->ip_address();
		$nominal_cash = $_POST['nominal_cash'];
		$nominal_cash = str_replace('.','',$nominal_cash);
		
		$post_data = array(
			'UserCode'		=> $this->session->userdata('ap_id_user'),
			'EntryType'		=> 1,
			'MachineCode'	=> $ip,
			'StoreCode'		=> $this->session->userdata('storeId'),
			'Amount'		=> $nominal_cash
		);
		$url = URL_API.'SalesOrder/OpenCloseStore';
		$data_api = $this->send_api->send_data($url, $post_data);
		$dt = json_decode($data_api);
		$open_close = $dt->OpenClose;
		$status = $open_close->Status == '0' ? $open_close->Status : 1;
		$this->session->set_userdata('available', $status);	
		echo json_encode($dt);
	}
	
	function close_v(){
		$this->load->view('close_cash');
	}


	function logout()
	{
		$this->session->unset_userdata('app_login');
		$this->session->unset_userdata('ap_id_user');
		$this->session->unset_userdata('ap_password');
		$this->session->unset_userdata('ap_nama');
		$this->session->unset_userdata('ap_level');
		$this->session->unset_userdata('ap_level_caption');
		redirect();
	}
}
