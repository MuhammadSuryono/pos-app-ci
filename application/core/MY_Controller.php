<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//$this->session_cek();
		if ($this->session->userdata('timeout') + 2 * 60 < time()) {
			$this->tokenAuthorize();
		 }
	}
	
	function input_error()
	{
		$json['status'] = 0;
		$json['pesan'] 	= "<div class='alert alert-warning error_validasi'>".validation_errors()."</div>";
		echo json_encode($json);
	}

	function query_error($pesan = "Terjadi kesalahan, coba lagi !")
	{
		$json['status'] = 2;
		$json['pesan'] 	= "<div class='alert alert-danger error_validasi'>".$pesan."</div>";
		echo json_encode($json);
	}

	function session_cek()
	{
		$u = $this->session->userdata('ap_id_user');
		$p = $this->session->userdata('ap_password');
		$x = $this->session->userdata('ap_level');

		$controller = $this->router->fetch_class();
		$method		= $this->router->fetch_method();

		if($controller == 'secure')
		{
			if($method == 'index')
			{
				if( ! empty($u) && ! empty($p))
				{
					$URL_home = 'penjualan';
					if($x == 'inventory')
					{
						$URL_home = 'barang';
					}
					if($x == 'keuangan')
					{
						$URL_home = 'penjualan/history';
					}

					redirect($URL_home, 'refresh');
				}
			}
		}
		else
		{
			if(empty($u) OR empty($p))
			{
				redirect('secure', 'refresh');
			}
			else
			{
				$this->load->model('m_user');
				$cek = $this->m_user->is_valid($u, $p);
				if($cek->num_rows() < 1)
				{
					redirect('secure/logout', 'refresh');
				}
			}
		}
	}

	function clean_tag_input($str)
	{
		$t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
		$t = htmlentities($t, ENT_QUOTES, "UTF-8");
		$t = trim($t);
		return $t;
	}

    public function accessToken() {
        return $this->session->userdata('access_token');
    }

    function tokenAuthorize() {
        try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://login.microsoftonline.com/8a0e3ae1-437d-4b41-a199-69cbaca7641a/oauth2/v2.0/token',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.businesscentral.dynamics.com%2F.default&client_id=e75ecd6b-ad76-4f33-84aa-ea071be15bbb&client_secret=j.g8Q~wihHsc2C2nvrkOej3PBYhega_63zPkBcoj',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$res = json_decode($response);
			$this->session->set_userdata('timeout', time());
			$this->session->set_userdata("access_token", $res->access_token);
		} catch (Exception $exception) {

		}

    }
}