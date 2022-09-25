<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_api

{
	protected 	$ci;
    protected $requestToken = 3;
	public function __construct() {		
		$this->ci =& get_instance();
	}
	
	
	function send_data($url= '', $data=array()){
        $url = str_replace(" ", "%20", $url);
		$fields = array();
		$headers = array(
			'Content-Type:application/json',
            'Authorization: Bearer ' . $this->ci->session->userdata('access_token')
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Send Error: ' . curl_error($ch));
		}
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode == "401") {
            $this->tokenAuthorize();
            $this->send_data($url, $data);
        }
		curl_close($ch);
        log_message("info", sprintf("URL: %s, BODY: %s, RESPONSE: %s", $url, json_encode($data), $result));
		return $result;
	}

    function get_data($url= '', $data=array()){
        $url = str_replace(" ", "%20", $url);

        $fields = array();
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Bearer ' . $this->ci->session->userdata('access_token')
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response === FALSE) {
            die('Send Error: ' . curl_error($curl));
        }
        return $response;
    }

    function post_data($url= '', $data=array()){
		
		$fields = array();
		$headers = array(
			"cache-control: no-cache",
    		"content-type: multipart/form-data;"
		);
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Post Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
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
            $this->session->set_userdata("access_token", $res->access_token);
        } catch (Exception $exception) {
            die('Error refresh token');
        }
    }
	
	
}

?>