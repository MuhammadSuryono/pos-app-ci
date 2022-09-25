<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportOwner extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('OWNER');

		if( ! in_array($level, $allowed))
		{
			redirect('secure/logout');
		}
	}

	public function index()
	{
		$this->load->view('laporan/report_owner');
	}
	
	function load_chart(){
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$start 	= $this->input->post('StartDate');
		$end	= $this->input->post('EndDate');
		$store = $this->input->post('StoreCode');
		$status = '';
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'StoreCode'		=> $store
		);
		$url = URL_API.'Report/ReportProduct';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		$i = 1;
		$data = "";
		$data .= "<table id='InvPostGroup'  style='display:none'>";
		$data .= "<thead>
							<tr>
									<th>Code</th>
									<th>Qty</th>
							</tr>
    				</thead>";
		if(!empty($detail->InvPostGroup)){
			foreach($detail->InvPostGroup as $so){				
				$data .= "<tr>";
				$data .= "<td align='center'>".$so->Code.".</td>";
				$data .= "<td>".$so->Qty."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "</br>";

		$data .= "<table id='ProdutTopTenPie' style='display:none'>";
		$data .= "<thead>
							<tr>
									<th>Name</th>
									<th>Qty</th>
							</tr>
    				</thead>";
		if(!empty($detail->ProdutTopTen)){
			foreach($detail->ProdutTopTen as $so){				
				$data .= "<tr>";
				$data .= "<td align='center'>".$so->Name.".</td>";
				$data .= "<td>".$so->Qty."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "</br>";
		$data .= "<b><p style='font-size:18px' id='lblTable1'></p></b>"; 
		$data .= "<table id='ProdutTopTen'  class='table table-striped table-bordered'>";
		$data .= "<thead>
							<tr>
									<th>Item No</th>
									<th>Name</th>
									<th>Qty</th>
									<th>Product Group</th>
							</tr>
    				</thead>";
		if(!empty($detail->ProdutTopTen)){
			foreach($detail->ProdutTopTen as $so){				
				$data .= "<tr>";
				$data .= "<td align='center'>".$so->ItemNo.".</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= "<td>".$so->Qty."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "</br>";
		$data .= "</br>";
				$data .= "</br>";
		//$data .= "<b><label>List Sales Product from "+ $start +" - "+ $end +"</label></b>"; 
		$data .= "<hr id='lineChart' style='display:block; border-top: 20px solid #eee'><b><p style='font-size:18px' id='lblTable2'></p></b>"; 
		$data .= "<table id='ReportProductList'  class='table table-striped table-bordered'>";
		$data .= "<thead>
							<tr>
									<th>Date</th>
									<th>Item No</th>
									<th>Name</th>
									<th>Qty</th>
									<th>Product Group</th>
							</tr>
    				</thead>";
		if(!empty($detail->ReportProductList)){
			foreach($detail->ReportProductList as $so){				
				$data .= "<tr>";
				$data .= "<td>".$so->Date."</td>";
				$data .= "<td align='center'>".$so->ItemNo.".</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= "<td>".$so->Qty."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "</br>";
		echo $data;
	}

	public function get_store(){
	$post_data = array();
		$url = URL_API.'Report/ListStore/';
		$data_api = $this->send_api->send_data($url, $post_data);
		echo $data_api;
	}
	
}
