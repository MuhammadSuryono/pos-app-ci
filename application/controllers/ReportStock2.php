<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportStock extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('STOCK');

		if( ! in_array($level, $allowed))
		{
			redirect('secure/logout');
		}
	}

	public function index()
	{
		$this->load->view('laporan/report_stock');
	}

	function load_chart_Detail(){
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$start 	= $this->input->post('StartDate');
		$end	= $this->input->post('EndDate');
		$store = $this->input->post('StoreCode');
		$itemcode = $this->input->post('ItemCode');
		$tipe = $this->input->post('Tipe');
		$subtipe = $this->input->post('SubTipe');
		$itemname = $this->input->post('ItemName');
		$status = '';
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'StoreCode'		=> $store,
			'DocNo'			=> $itemcode,
			'Tipe'			=> $tipe,
			'SubTipe'		=> $subtipe
		);
		$url = URL_API.'Report/ReportStockMonitoringDetail';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		
		$i = 1;
		$data = "";		
		$data .= "<b><p style='font-size:18px' id=''>Detail Item Stock (". $itemcode.") ". $start ." - ". $end." </p></b>";
		$data .= "<b><p style='font-size:18px' id=''>". $itemname ."</p></b>";
		$data .= "<p><button type='button' id='exportBtn' class='btn btn-success' style='margin-left: 0px; display:none;' onclick='ExportData(this);'>Export To Excel</button></p>";
		$data .= "<table id='ReportProductList4'  class='table table-striped table-bordered'>";
		$data .= "<thead>						
						<tr>
						<th style='width:5%;text-align: center;'>No</th>
						<th style='width:5%;text-align: center;'>Outlet</th>
						<th style='width:120px;text-align: center;'>Tanggal</th>
						<th style='width:200px; text-align: center;'>Document No</th>
						<th style='width:200px; text-align: center;'>External Doc No</th>";
		if ($tipe == "Both")	{
			$data .= "<th style='text-align: center;'>Qty</th>";
			$data .= "<th style='text-align: center;'>Qty</th>";
		}
		else {
			$data .="<th style='text-align: center;'>". $tipe ."</th>";
		}			
		$data .= "</tr>						
    				</thead><tbody>";
		if(!empty($detail->DetailStock)){
			foreach($detail->DetailStock as $so){				
				$data .= "<tr>";
				$data .= "<td>".$i."</td>";
				$data .= "<td align='center'>".$so->Location."</td>";
				$data .= "<td align='center'>".$so->Tanggal."</td>";
				$data .= "<td align='center'>".$so->DocumentNo."</td>";
				$data .= "<td align='center'>".$so->ExternalDocNo."</td>";
				if ($tipe == "Both")	{
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->qty))."</td>";
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->value))."</td>";
				}
				else if ($tipe == "Qty") {
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->qty))."</td>";
				}
				else if ($tipe == "Amount"){
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->value))."</td>";
				}								
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "<br>";
		echo $data;
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
		$url = URL_API.'Report/ReportStockMonitoring';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		$i = 1;
		$data = "";		
		$data .= "<b><p style='font-size:18px' id=''>Monitoring Stock By Qty ". $start ." - ". $end."</p></b>";
		$data .= "<p><button type='button' id='exportBtn' class='btn btn-success' style='margin-left: 0px; display:none;' onclick='ExportData(this);'>Export To Excel</button></p>";
		$data .= "<table id='ReportProductList'  class='table table-striped table-bordered'>";
		$data .= "<thead>
						<tr>
						<th style='text-align: center;' rowspan='2'>No</th>
						<th style='text-align: center;' rowspan='2'>Code</th>
						<th style='width: 45%; text-align: center;' rowspan='2'>Nama Barang</th>
						<th style='text-align: center;' rowspan='2'>Stock Awal</th>
						<th style='text-align: center;' colspan='2'>IN</th>
						<th style='text-align: center;' colspan='3'>OUT</th>
						<th style='text-align: center;' rowspan='2'>End Stock</th>
						</tr>
						<tr>
						<th style='text-align: center;'>Beli</th>
						<th style='text-align: center;'>Free</th>
						<th style='text-align: center;'>Sell</th>
						<th style='text-align: center;'>Retur</th>
						<th style='text-align: center;'>Free</th>
						</tr>						
    				</thead>";
		if(!empty($detail->ItemStockQty)){
			foreach($detail->ItemStockQty as $so){				
				$data .= "<tr>";
				$data .= "<td>".$i."</td>";
				$data .= "<td align='center'>".$so->Code.".</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="Awal" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->Awal)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="InBeli" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->InBeli)). '</a></td>';
				$data .= "<td align='right'>0</td>";
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="OutBeli" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->OutBeli)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="OutRetur" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->OutRetur)). '</a></td>';
				$data .= "<td align='right'>0</td>";
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="Akhir" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->Akhir)). '</a></td>';				
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "<br>";
		$i = 1;
		$data .= "<div id='exportdata' style='display:none'>";		
		$data .= "<b><p style='font-size:18px' id=''>Monitoring Stock ". $start ." - ". $end."</p></b>";
		$data .= "<table id='ReportProductList'  class='table table-striped table-bordered'>";
		$data .= "<thead>
					<tr>
					<th style='text-align: center;' rowspan='2'>No</th>
					<th style='text-align: center;' rowspan='2'>Code</th>
					<th style='width: 45%; text-align: center;' rowspan='2'>Nama Barang</th>
					<th style='text-align: center;' rowspan='2'>Stock Awal</th>
					<th style='text-align: center;' colspan='2'>IN</th>
					<th style='text-align: center;' colspan='3'>OUT</th>
					<th style='text-align: center;' rowspan='2'>End Stock</th>
					</tr>
					<tr>
					<th style='text-align: center;'>Beli</th>
					<th style='text-align: center;'>Free</th>
					<th style='text-align: center;'>Sell</th>
					<th style='text-align: center;'>Retur</th>
					<th style='text-align: center;'>Free</th>
					</tr>						
				</thead>";
		if(!empty($detail->ItemStock)){
			foreach($detail->ItemStock as $so){				
				$data .= "<tr>";
				$data .= "<td>".$i."</td>";
				$data .= "<td align='center'>".$so->Code.".</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= "<td align='right'>".$so->Awal."</td>";
				$data .= "<td align='right'>".$so->InBeli."</td>";
				$data .= "<td align='right'>".$so->OutBeli."</td>";
				$data .= "<td align='right'>".$so->OutRetur."</td>";
				$data .= "<td align='right'>".$so->OutFree."</td>";
				$data .= "<td align='right'>".$so->Akhir."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table></div>";	

		//-----------------------------------------------------------
		$i = 1;
		$data .= "";		
		$data .= "<b><p style='font-size:18px' id=''>Monitoring Stock By Value ". $start ." - ". $end."</p></b>";
		$data .= "<p><button type='button' id='exportBtn' class='btn btn-success' style='margin-left: 0px;display:none' onclick='ExportData(this);'>Export To Excel</button></p>";
		$data .= "<table id='ReportProductList1'  class='table table-striped table-bordered'>";
		$data .= "<thead>
					<tr>
					<th style='text-align: center;' rowspan='2'>No</th>
					<th style='text-align: center;' rowspan='2'>Code</th>
					<th style='width: 45%; text-align: center;' rowspan='2'>Nama Barang</th>
					<th style='text-align: center;' rowspan='2'>Stock Awal</th>
					<th style='text-align: center;' colspan='2'>IN</th>
					<th style='text-align: center;' colspan='3'>OUT</th>
					<th style='text-align: center;' rowspan='2'>End Stock</th>
					</tr>
					<tr>
					<th style='text-align: center;'>Beli</th>
					<th style='text-align: center;'>Free</th>
					<th style='text-align: center;'>Sell</th>
					<th style='text-align: center;'>Retur</th>
					<th style='text-align: center;'>Free</th>
					</tr>										
				</thead>";
		if(!empty($detail->ItemStockValue)){
			foreach($detail->ItemStockValue as $so){				
				$data .= "<tr>";
				$data .= "<td>".$i."</td>";
				$data .= "<td align='center'>".$so->Code.".</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= '<td align="right"><a href="#" tipe="Amount" itemname="'.$so->Name.'" subtipe="Awal" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->Awal)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Amount" itemname="'.$so->Name.'" subtipe="InBeli" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->InBeli)). '</a></td>';
				$data .= "<td align='right'>0</td>";
				$data .= '<td align="right"><a href="#" tipe="Amount" itemname="'.$so->Name.'" subtipe="OutBeli" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->OutBeli)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Amount" itemname="'.$so->Name.'" subtipe="OutRetur" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->OutRetur)). '</a></td>';
				$data .= "<td align='right'>0</td>";
				$data .= '<td align="right"><a href="#" tipe="Amount" itemname="'.$so->Name.'" subtipe="Akhir" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->Akhir)). '</a></td>';				
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "<br>";
		//------------------------------------------------------------
		$i = 1;
		$data .= "";		
		$data .= "<b><p style='font-size:18px' id=''>Monitoring Stock By Qty & Value ". $start ." - ". $end."</p></b>";
		$data .= "<p><button type='button' id='exportBtn' class='btn btn-success' style='margin-left: 0px;display:none' onclick='ExportData(this);'>Export To Excel</button></p>";
		$data .= "<table id='ReportProductList2'  class='table table-striped table-bordered'>";
		$data .= "<thead>	
						<tr>
						<th style='text-align: center;' rowspan='2'>No</th>
						<th style='text-align: center;' rowspan='2'>Code</th>
						<th style='width: 45%; text-align: center;' rowspan='2'>Nama Barang</th>
						<th style='text-align: center;' rowspan='2'>Stock Awal</th>
						<th style='text-align: center;' colspan='2'>IN</th>
						<th style='text-align: center;' colspan='3'>OUT</th>
						<th style='text-align: center;' rowspan='2'>End Stock</th>
						<th style='text-align: center;' rowspan='2'>End Value</th>
						</tr>
						<tr>
						<th style='text-align: center;'>Beli</th>
						<th style='text-align: center;'>Free</th>
						<th style='text-align: center;'>Sell</th>
						<th style='text-align: center;'>Retur</th>
						<th style='text-align: center;'>Free</th>
						</tr>											
    				</thead>";
		if(!empty($detail->ItemStockQtyValue)){
			foreach($detail->ItemStockQtyValue as $so){				
				$data .= "<tr>";
				$data .= "<td>".$i."</td>";
				$data .= "<td align='center'>".$so->Code.".</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="Awal" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->Awal)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="InBeli" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->InBeli)). '</a></td>';
				$data .= "<td align='right'>0</td>";
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="OutBeli" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->OutBeli)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="OutRetur" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->OutRetur)). '</a></td>';
				$data .= "<td align='right'>0</td>";
				$data .= '<td align="right"><a href="#" tipe="Qty" itemname="'.$so->Name.'" subtipe="Akhir" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->Akhir)). '</a></td>';
				$data .= '<td align="right"><a href="#" tipe="Amount" itemname="'.$so->Name.'" subtipe="Akhir" code="'. $so->Code .'" onclick="ShowDetail(this);">'.str_replace(",", ".", number_format($so->AkhirValue)). '</a></td>';								
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "<br>";
		echo $data;
	}

	public function get_store(){
		$post_data = array();
		$url = URL_API.'Report/ListStore/';
		$data_api = $this->send_api->send_data($url, $post_data);
		echo $data_api;
	}
	
}
