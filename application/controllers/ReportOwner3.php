<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportOwner extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('OWNER', 'REPORT');

		if( ! in_array($level, $allowed))
		{
			redirect('secure/logout');
		}
	}

	public function index()
	{
		$this->load->view('laporan/report_owner');
	}
	function loatTopTenCat()
	{
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$start 	= $this->input->post('StartDate');
		$end	= $this->input->post('EndDate');
		$store = $this->input->post('StoreCode');
		$category = $this->input->post('Category');
		$status = '';
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'StoreCode'		=> $store,
			'Category'		=> $category
		);
		$url = URL_API.'Report/ReportTopTenByCat';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		$data = "";
		$data .= "<table id='ProdutTopTen'  class='table table-striped table-bordered'>";
		$data .= "<thead>
							<tr>
									<th>Item No</th>
									<th>Name</th>
									<th>Category Location</th>
									<th>Qty</th>									
									<th>Gross Sales (Rp)</th>
									<th>Net Sales (Rp)</th>
									<th>Product Group</th>
							</tr>
    				</thead>";
		if(!empty($detail->ProdutTopTen)){
			foreach($detail->ProdutTopTen as $so){				
				$data .= "<tr>";
				$data .= "<td style='cursor: pointer;' align='center' code='".$so->ItemNo."' itemname='".$so->Name."' catloc='".$so->CatLoc."' onclick='ShowDetail(this);'>".$so->ItemNo.".</td>";
				$data .= "<td style='cursor: pointer;' code='".$so->ItemNo."' itemname='".$so->Name."' catloc='".$so->CatLoc."' onclick='ShowDetail(this);'>".$so->Name."</td>";
				$data .= "<td>".$so->CatLoc."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->Qty))."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->GrossSales))."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->NetSales))."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "</tr>";
			}
		}
		$data .= "</tbody></table>";
		echo $data;
	}
	
	
	function load_chart(){
		$GrossProfit = 0;
		$NetProfit = 0;
		$TransactionCount = 0;
		$TotalDiskon = 0;
		$AverageProfit = 0;
		$totalQty = 0;
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
		$data = "<div class='row' style='margin-left:5px; margin-right:5px'>";
		$data .="<div class='col-md-1' id='TRCountDIV' style='border:solid 2px black; text-align:right;padding-right: 5px;padding-left: 5px;'>".$TransactionCount."</div>";
		$data .="<div class='col-md-1' id='TotQtyDIV' style='border:solid 2px black;text-align:right;padding-right: 5px;padding-left: 5px;'>".$totalQty."</div>";
		$data .="<div class='col-md-3' id='GrossDIV' style='border:solid 2px black;text-align:right'>".$GrossProfit."</div>";
		$data .="<div class='col-md-3' id='NetDIV' style='border:solid 2px black;;text-align:right'>".$NetProfit."</div>";
		$data .="<div class='col-md-2' id='TDiscDIV' style='border:solid 2px black;;text-align:right'>".$TotalDiskon."</div>";
		$data .="<div class='col-md-2' id='AvgDIV' style='border:solid 2px black;text-align:right'>".$AverageProfit."</div>";
		$data .="</div></br>";
		$data .= "";		
		$data .= "<b><p style='font-size:18px' id='lblTable2'></p></b>";
		$data .= "<button type='button' id='export' onclick='ExportExcel(this);' class='btn btn-success' style='margin-left: 0px;'>Export Data Sales</button>";
		$data .= "<br><br><table id='ReportProductList'  class='table table-striped table-bordered'>";
		$data .= "<thead>
							<tr>
									<th>Date</th>
									<th>Item No</th>
									<th>Name</th>
									<th>Category Location</th>
									<th>Qty</th>
									<th>Penjualan (Rp)</th>
									<th>Penjualan - Disc (Rp)</th>
									<th>No Nota</th>
									<th>Outlet</th>
							</tr>
    				</thead>";
		if(!empty($detail->PendapatanReal)){
			foreach($detail->PendapatanReal as $so){				
				$data .= "<tr>";
				$txt = $so->Date;
				$time = date('H:i', strtotime(substr($txt, -7)));
				$date = substr($txt, 0, 11);			
				$data .= "<td>".$date . " " .$time."</td>";
				//$data .= "<td>".$so->Date."</td>";
				$data .= "<td align='center'>".$so->ItemNo."</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= "<td>".$so->CatLoc."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->Qty))."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->GrossSales))."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->NetSales))."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "<td>".$so->Outlet."</td>";
				$data .= "</tr>";
				$i++;				
			}
		}
		if(!empty($detail->PendapatanReal)){
			$NoNota = '';
			$NoNotaR = '';
			foreach($detail->PendapatanReal as $so){								
				//$TransactionCount++;
				if ($so->InventoryPostingGroup !=  str_replace("(R)", "", $so->InventoryPostingGroup) . "(R)"){
					if ($NoNota != $so->InventoryPostingGroup ){
						$TransactionCount++;
						$NoNota = $so->InventoryPostingGroup;
					}					
				//	$totalQty = $totalQty + $so->Qty;
				//}else {
				//	$totalQty = $totalQty - $so->Qty;
				}else{
					if ($NoNotaR != $so->InventoryPostingGroup ){
						$TransactionCount--;
						$NoNotaR = $so->InventoryPostingGroup;
					}
				}
				$GrossProfit = $GrossProfit + $so->GrossSales;
				$NetProfit = $NetProfit  + $so->NetSales ;
				$TotalDiskon = $GrossProfit - $NetProfit;
				$AverageProfit = $TransactionCount != 0 ? $NetProfit / $TransactionCount : 0;
				$totalQty = $totalQty + $so->Qty;
			}
		}
		$data .= "</tbody></table>";
		
		//table export
		$data .="<div id='TblTransExport' style='display:none'>";
		$data .= "<b><p style='font-size:18px' id='lblTable4'></p></b>";
		$data .= "<table id='ReportProductList'  class='table table-striped table-bordered'>";
		$data .= "<thead>
							<tr>
									<th>Date</th>
									<th>Item No</th>
									<th>Name</th>
									<th>Category Location</th>
									<th>Qty</th>
									<th>Penjualan (Rp)</th>
									<th>Penjualan - Disc (Rp)</th>
									<th>No Nota</th>
									<th>Outlet</th>
							</tr>
    				</thead>";
		if(!empty($detail->PendapatanReal)){
			foreach($detail->PendapatanReal as $so){				
				$data .= "<tr>";
				$txt = $so->Date;
				$time = date('H:i', strtotime(substr($txt, -7)));
				$date = substr($txt, 0, 11);			
				$data .= "<td>".$date . " " .$time."</td>";
				//$data .= "<td>".$so->Date."</td>";
				$data .= "<td align='center'>".$so->ItemNo."</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= "<td>".$so->CatLoc."</td>";
				$data .= "<td align='right'>".number_format($so->Qty)."</td>";
				$data .= "<td align='right'>".number_format($so->GrossSales)."</td>";
				$data .= "<td align='right'>".number_format($so->NetSales)."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "<td>".$so->Outlet."</td>";
				$data .= "</tr>";
				$i++;				
			}
		}
		$data .= "</tbody></table>";
		$data .="</div>";
		//end Table Export
		$data .="<div id='containerPendapatanChart' style='min-width: 310px; height: 400px; margin: 0 auto; display:block'></div><br>";
		$data .= "<table id='ReportPendapatanChart'  class='table table-striped table-bordered'  style='display:none'>";
		$data .= "<thead>
							<tr>
									<th>Date</th>
									<th>Net Sales</th>
							</tr>
    				</thead>";
		if(!empty($detail->PendapatanChart)){
			foreach($detail->PendapatanChart as $so){				
				$data .= "<tr>";
				$data .= "<td>".$so->Dates."</td>";
				$data .= "<td align='right'>".$so->NetSales."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		// CHART 10 TEN
		$data .= "<hr id='lineChart' style='display:none; border-top: 20px solid #eee'>";		
		$data .= "<b><p style='font-size:18px' id='lblTable1'></p></b>"; 
		$data .= "<div class='row'><div class='col-sm-4'><select name='Store' id='ddlCat' class='form-control Store' style='cursor: pointer;'>
					<option value=''>--All Category--</option>";
		if(!empty($detail->ListItemCategory)){
			foreach($detail->ListItemCategory as $so){			
				$data .= "<option value='".$so->CategoryCode."'>".$so->CategoryCode."</option>";								
			}
		}
					
		$data .= "</select></div><div class='col-sm-8'><button type='button' id='Tampilkan' onclick='TampilkanProduct();' class='btn btn-primary' style='margin-left: 0px;'>Tampilkan</button></div>";
		$data .= "<br><br><div id='toptendiv' style='margin: 15px;'>"; 
		$data .= "<table id='ProdutTopTen'  class='table table-striped table-bordered table-responsive'>";
		$data .= "<thead>
							<tr>
									<th>Item No</th>
									<th>Name</th>
									<th>Category Location</th>
									<th>Qty</th>
									<!--<th>Pendapatan (Rp)</th>-->
									<th>Pendapatan Setelah Disc (Rp)</th>
									<th>Product Group</th>
							</tr>
    				</thead>";
		if(!empty($detail->ProdutTopTen)){
			foreach($detail->ProdutTopTen as $so){				
				$data .= "<tr>";
				$data .= "<td style='cursor: pointer;' align='center' code='".$so->ItemNo."' itemname='".$so->Name."' catloc='".$so->CatLoc."' onclick='ShowDetail(this);'>".$so->ItemNo.".</td>";
				$data .= "<td style='cursor: pointer;' code='".$so->ItemNo."' itemname='".$so->Name."' catloc='".$so->CatLoc."' onclick='ShowDetail(this);'>".$so->Name."</td>";
				$data .= "<td>".$so->CatLoc."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->Qty))."</td>";
				//$data .= "<td align='right'>".str_replace(",", ".", number_format($so->GrossSales))."</td>";
				$data .= "<td align='right'>".str_replace(",", ".", number_format($so->NetSales))."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "</tr>";
				$i++;
			}
		}
		$data .= "</tbody></table>";
		$data .= "</div>";
		$data .= "<div id='containerTopTen' style='min-width: 310px; height: 400px; margin: 0 auto; display:none'></div>";
		$data .= "";
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
		$data .= "";
		// SALES BY PAYMENT
		$data .= "<div class='row' style='margin:15px'>";
		$data .= "<hr id='lineChart' style='display:block; border-top: 20px solid #eee'>";		
		$data .= "<b><p style='font-size:18px; style='margin: 15px;' id='lblTable10'></p></b>"; 
		$data .= "<table id='ProductPayment'  class='table table-striped table-bordered table-responsive'>";
		$data .= "<thead>
							<tr>
									<th>Payment Type</th>
									<th>Payment Methode</th>
									<th>Description</th>
									<th>Total Transaksi</th>
									<th>Total Amount</th>
							</tr>
    				</thead>";
		if(!empty($detail->PendapatanPaymentMethode)){
			foreach($detail->PendapatanPaymentMethode as $so){	
				if ($so->TotalTransaksi != 0){
					$data .= "<tr>";
					$data .= "<td>".$so->Type."</td>";
					$data .= "<td style='cursor: pointer;' code='".$so->Code."' itemname='".$so->Description."' onclick='ShowDetailPayment(this);'>".$so->Code.".</td>";
					$data .= "<td style='cursor: pointer;' code='".$so->Code."' itemname='".$so->Description."' onclick='ShowDetailPayment(this);'>".$so->Description."</td>";
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->TotalTransaksi))."</td>";
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->TotalAmount))."</td>";
					$data .= "</tr>";
					$i++;
				}
			}
		}
		$data .= "</tbody></table>";
		$data .= "</div>";
		$data .= "";

		// PIE CHART
		$data .= "<div style='margin:15px'><hr id='lineChart' style='display:block; border-top: 20px solid #eee'><b><p style='font-size:18px' id='lblTable3'></p></b>"; 
		$data .= "<div id='containerPie' class='col-sm-6' style='min-width: 310px; height: 400px; margin: 0 auto; display:none'></div>
				  <div id='containerPieAmount' class='col-sm-6' style='min-width: 310px; height: 400px; margin: 0 auto; display:none'></div>
				 ";
		$data .= "<table id='InvPostGroup'  style='display:none'>";
		$data .= "<thead>
							<tr>
									<th>Code</th>
									<th>Qty</th>
							</tr>
    				</thead>";
					if(!empty($detail->InvPostGroup)){
						foreach($detail->InvPostGroup as $so){
							if ($so->Qty != 0){
								$data .= "<tr>";
								$data .= "<td align='center'>".$so->Code.".</td>";
								$data .= "<td>".$so->Qty."</td>";
								$data .= "</tr>";
								$i++;
							}									
						}
					}
		$data .= "<table id='InvPostGroupAmount'  style='display:none'>";
		$data .= "<thead>
							<tr>
									<th>Code</th>
									<th>NetSales</th>
							</tr>
    				</thead>";
					if(!empty($detail->InvPostGroup)){
						foreach($detail->InvPostGroup as $so){	
							if ($so->Qty != 0){			
								$data .= "<tr>";
								$data .= "<td align='center'>".$so->Code.".</td>";
								$data .= "<td>".$so->NetSales."</td>";
								$data .= "</tr>";
								$i++;
							}
						}
					}
		$data .= "</tbody></table>";
		$data .= "</br>";
		$data .= "</tbody></table></div>";
		$data .= "<input type='hidden' id='TRCount' value='".str_replace(",", ".", number_format($TransactionCount))."' />" ;
		$data .= "<input type='hidden' id='GrossProfit' value='Rp.".str_replace(",", ".", number_format($GrossProfit)).",00' />" ;
		$data .= "<input type='hidden' id='NetProfit' value='Rp.".str_replace(",", ".", number_format($NetProfit)) .",00' />" ;
		$data .= "<input type='hidden' id='DiscProfit' value='Rp.".str_replace(",", ".", number_format($TotalDiskon)) .",00' />" ;
		$data .= "<input type='hidden' id='TotalQty' value='".str_replace(",", ".", number_format($totalQty))."' />" ;
		$data .= "<input type='hidden' id='AVGProfit' value='Rp. ".str_replace(",", ".", number_format($AverageProfit)).",00' />" ;
		echo $data;
	}

	public function get_store(){
	$post_data = array();
		$url = URL_API.'Report/ListStore/';
		$data_api = $this->send_api->send_data($url, $post_data);
		echo $data_api;
	}

	function load_detail_product_group(){
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$start 	= $this->input->post('StartDate');
		$end	= $this->input->post('EndDate');
		$store = $this->input->post('StoreCode');
		$itemcode = $this->input->post('ItemCode');
		$itemname = $this->input->post('ItemName');
		$catloc = $this->input->post('CatLoc');
		$category = $this->input->post('Category');
		$tipe = $this->input->post('Tipe');
		$status = '';
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'StoreCode'		=> $store,
			'DocNo'			=> $itemcode,
			'Category'		=> $category
		);
		$url = URL_API.'Report/ReportTopTenDetail';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		$i = 1;
		$data = "";
		if ($itemcode != null){
			$data .= "<b><p style='font-size:18px' id=''>Detail Product Group (". $itemcode.") ". $start ." - ". $end." </p></b>";
			$data .= "<b><p style='font-size:18px' id=''>". $itemname .", (".$catloc.")</p></b>";
		}else{
			$data .= "<b><p style='font-size:18px' id=''>Detail Product Category (". $category.") ". $start ." - ". $end." </p></b>";
		}		
		
		$data .= "<p><button type='button' id='exportBtn' class='btn btn-success' style='margin-left: 0px; display:none;' onclick='ExportData(this);'>Export To Excel</button></p>";
		$data .= "<table id='tblDetailProductGroup'  class='table table-striped table-bordered'>";
		$data .= "<thead>	
				<th>Outlet</th>				
				<th>Qty</th>		
				<tbody>";
				if(!empty($detail->PendapatanReal)){
					foreach($detail->PendapatanReal as $so){				
						$data .= "<tr>";
						$data .= "<td>".$so->Outlet."</td>";
						if ($tipe == 'Amount'){
							$data .= "<td align='right'>".str_replace(",", ".", number_format($so->NetSales))."</td>";
						}else{
							$data .= "<td align='right'>".str_replace(",", ".", number_format($so->Qty))."</td>";
						}						
						$data .= "</tr>";
						$i++;				
					}
				}
				$data .= "</tbody></table>";
		$data .= "<br>";
		echo $data;
	}

	function load_detail_sales_payment(){
		$level = $this->session->userdata('ap_level');
		$dt = array();
		$start 	= $this->input->post('StartDate');
		$end	= $this->input->post('EndDate');
		$store = $this->input->post('StoreCode');
		$itemcode = $this->input->post('ItemCode');
		$itemname = $this->input->post('ItemName');
		$status = '';
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'StoreCode'		=> $store,
			'DocNo'			=> $itemcode,
		);
		$url = URL_API.'Report/ReportSalesPaymentDetail';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		$i = 1;
		$data = "";		
		$data .= "<b><p style='font-size:18px' id=''>Detail Payment Methode (". $itemcode.") ". $start ." - ". $end." </p></b>";
		$data .= "<b><p style='font-size:18px' id=''>". $itemname ."</p></b>";
		$data .= "<p><button type='button' id='exportBtn' class='btn btn-success' style='margin-left: 0px; display:none;' onclick='ExportData(this);'>Export To Excel</button></p>";
		$data .= "<table id='tblDetailSalesPayment'  class='table table-striped table-bordered'>";
		$data .= "<thead>
				<th>Outlet</th>		
				<th>Total Transaksi</th>
				<th>Nominal</th>				
				<tbody>";
				if(!empty($detail->PendapatanReal)){
					foreach($detail->PendapatanReal as $so){				
						$data .= "<tr>";
						$data .= "<td>".$so->Outlet."</td>";
						$data .= "<td align='right'>".str_replace(",", ".", number_format($so->Qty))."</td>";					
						$data .= "<td align='right'>".str_replace(",", ".", number_format($so->NetSales))."</td>";
						$data .= "</tr>";
						$i++;				
					}
				}
				$data .= "</tbody></table>";
		$data .= "<br>";
		echo $data;
	}
	
}
