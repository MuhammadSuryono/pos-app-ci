<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportOwner_new extends MY_Controller 
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
		$this->load->view('laporan/report_owner_new');
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
		$s09 = 0;
		$s10 = 0;
		$s11 = 0;
		$s12 = 0;
		$s13 = 0;
		$s14 = 0;
		$s15 = 0;
		$s16 = 0;
		$s17 = 0;
		$s18 = 0;
		$s19 = 0;
		$s20 = 0;
		$s21 = 0;
		$s22 = 0;
		$s23 = 0;
		$post_data = array(
			'StartDate'		=> $start,
			'EndDate'		=> $end,
			'StoreCode'		=> $store
		);
		$url = URL_API.'Report/ReportProduct';
		$data_api = $this->send_api->send_data($url, $post_data);
		$detail = json_decode($data_api);
		// echo "<pre>";print_r($detail);echo "</pre>";exit;
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
									<th>No Nota</th>
									<th>Outlet</th>
									<th>Total Items</th>
									<th>Total Qty</th>
									<th>Penjualan (Rp)</th>
									<th>Penjualan - Disc (Rp)</th>
									<th></th>
							</tr>
    				</thead>";
		$data .= "<tbody>";
		$modals = '';
		$dataexport	= '';
		if(!empty($detail->PendapatanReal)){
			$NoNota = [];
			$NoNotaR = [];

			$newdata	= [];
			$newtable	= [];

			foreach($detail->PendapatanReal as $so){
				$txt	= $so->Date;
				$time	= date('H:i', strtotime(substr($txt, -7)));
				$date	= substr($txt, 0, 11);
				$nonota = trim(str_replace("(R)","",$so->InventoryPostingGroup));

				if(strpos($so->InventoryPostingGroup,"(R)",0) !== false)
				{
					if(isset($NoNota[$nonota][$so->ItemNo]))
					{
						$NoNotaR[$nonota][$so->ItemNo]				= $NoNota[$nonota][$so->ItemNo];
						if($NoNotaR[$nonota][$so->ItemNo]->GrossSales > 0)
						{
							$NoNotaR[$nonota][$so->ItemNo]->GrossSales	= $NoNotaR[$nonota][$so->ItemNo]->GrossSales * -1;
						}
						else
						{
							//$NoNota[$nonota][$so->ItemNo]
						}
						if($NoNotaR[$nonota][$so->ItemNo]->NetSales > 0)
						{
							$NoNotaR[$nonota][$so->ItemNo]->NetSales	= $NoNotaR[$nonota][$so->ItemNo]->NetSales * -1;
						}
						$so->GrossSales	= $NoNotaR[$nonota][$so->ItemNo]->GrossSales;
						$so->NetSales	= $NoNotaR[$nonota][$so->ItemNo]->NetSales;
					}
					else
					{
						$NoNotaR[$nonota][$so->ItemNo]		= $so;
					}
					//$NoNotaR[$nonota][$so->ItemNo]->date	= $date;
					//$NoNotaR[$nonota][$so->ItemNo]->time	= $time;
					//echo "<pre>";print_r($NoNotaR[$nonota][$so->ItemNo]);echo "</pre>";
				}
				else
				{
					$NoNota[$nonota][$so->ItemNo]		= $so;
					/*if($NoNota[$nonota][$so->ItemNo]->GrossSales < 0)
					{
						$NoNota[$nonota][$so->ItemNo]->GrossSales	= $NoNota[$nonota][$so->ItemNo]->GrossSales * -1;
					}
					if($NoNota[$nonota][$so->ItemNo]->NetSales < 0)
					{
						$NoNota[$nonota][$so->ItemNo]->NetSales	= $NoNota[$nonota][$so->ItemNo]->NetSales * -1;
					}
					$so->GrossSales	= $NoNota[$nonota][$so->ItemNo]->GrossSales;
					$so->NetSales	= $NoNota[$nonota][$so->ItemNo]->NetSales;*/
					//$NoNota[$nonota][$so->ItemNo]->date	= $date;
					//$NoNota[$nonota][$so->ItemNo]->time	= $time;
					//echo "<pre>";print_r($NoNota[$nonota][$so->ItemNo]);echo "</pre>";
				}

				$dataexport .= "<td>".$date . " " .$time."</td>";
				//$dataexport .= "<td>".$so->Date."</td>";
				$dataexport .= "<td align='center'>".$so->ItemNo."</td>";
				$dataexport .= "<td>".$so->Name."</td>";
				$dataexport .= "<td>".$so->CatLoc."</td>";
				$dataexport .= "<td align='right'>".$so->Qty."</td>";
				$dataexport .= "<td align='right'>".$so->GrossSales."</td>";
				$dataexport .= "<td align='right'>".$so->NetSales."</td>";
				$dataexport .= "<td>".$so->InventoryPostingGroup."</td>";
				$dataexport .= "<td>".$so->Outlet."</td>";
				$dataexport .= "</tr>";

				$newtable[$nonota]['redeem']		= (isset($newtable[$nonota]['redeem']) && ($newtable[$nonota]['redeem'] == true || ($newtable[$nonota]['redeem'] == false && strpos($so->InventoryPostingGroup,"(R)") !== false))) ? true : false;
				$newtable[$nonota]['items'][]		= $so;
				if(substr($so->InventoryPostingGroup,-3) == "(R)")
				{
					$newtable[$nonota]['redeem_items'][]	= $so;
				}
				$newtable[$nonota]['totalQty']		= (!isset($newtable[$nonota]['totalQty']))		? $so->Qty 			: ($newtable[$nonota]['totalQty'] 	+ $so->Qty);
				$newtable[$nonota]['totalGross']	= (!isset($newtable[$nonota]['totalGross']))	? $so->GrossSales 	: ($newtable[$nonota]['totalGross'] + $so->GrossSales);
				$newtable[$nonota]['totalNett']		= (!isset($newtable[$nonota]['totalNett']))		? $so->NetSales 	: ($newtable[$nonota]['totalNett'] 	+ $so->NetSales);
				$newtable[$nonota]['noNota']		= $nonota.(($newtable[$nonota]['redeem']) ? " (R)" : "");
				$newtable[$nonota]['date']			= $date . " " .$time;

				$newtable[$nonota]['html']		= '';
				$newtable[$nonota]['html']		.= "<tr data-child-value=\"".$nonota."\">";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"left\">".$date . " " .$time."</td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"left\"><a class=\"details-control\" href=\"#\">".$newtable[$nonota]['noNota']."</a></td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "").">".$so->Outlet."</td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"right\">".(count($newtable[$nonota]['items'])-((isset($newtable[$nonota]['redeem_items'])) ? count($newtable[$nonota]['redeem_items']) : 0))."</td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"right\">".number_format($newtable[$nonota]['totalQty'])."</td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"right\">".number_format($newtable[$nonota]['totalGross'])."</td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"right\">".(($newtable[$nonota]['totalNett'] <= 0) ? '0' : number_format($newtable[$nonota]['totalNett']))."</td>";
				$newtable[$nonota]['html']		.= "<td".(($newtable[$nonota]['redeem']) ? " class=\"bg-danger\"" : "")." align=\"center\"><a class=\"details-control\" href=\"#\"><i class=\"fa fa-search\"></i></a></td>";
				$newtable[$nonota]['html']		.= "</tr>";

				if (substr($so->InventoryPostingGroup,-3) == "(R)") {
					$TransactionCount--;
					$tm = substr($time, 0, 2);
					if ($tm == "09"){
						$s09--;
					}
					elseif ($tm == "10"){
						$s10--;
					}
					elseif ($tm == "11"){
						$s11--;
					}
					elseif ($tm == "12"){
						$s12--;
					}
					elseif ($tm == "13"){
						$s13--;
					}
					elseif ($tm == "14"){
						$s14--;
					}
					elseif ($tm == "15"){
						$s15--;
					}
					elseif ($tm == "16"){
						$s16--;
					}
					elseif ($tm == "17"){
						$s17--;
					}
					elseif ($tm == "18"){
						$s18--;
					}
					elseif ($tm == "19"){
						$s19--;
					}
					elseif ($tm == "20"){
						$s20--;
					}
					elseif ($tm == "21"){
						$s21--;
					}
					elseif ($tm == "22"){
						$s22--;
					}
					elseif ($tm == "23"){
						$s23--;
					}
				}
				else {
					$TransactionCount++;
					$tm = substr($time, 0, 2);
					if ($tm == "09"){
						$s09++;
					}
					elseif ($tm == "10"){
						$s10++;
					}
					elseif ($tm == "11"){
						$s11++;
					}
					elseif ($tm == "12"){
						$s12++;
					}
					elseif ($tm == "13"){
						$s13++;
					}
					elseif ($tm == "14"){
						$s14++;
					}
					elseif ($tm == "15"){
						$s15++;
					}
					elseif ($tm == "16"){
						$s16++;
					}
					elseif ($tm == "17"){
						$s17++;
					}
					elseif ($tm == "18"){
						$s18++;
					}
					elseif ($tm == "19"){
						$s19++;
					}
					elseif ($tm == "20"){
						$s20++;
					}
					elseif ($tm == "21"){
						$s21++;
					}
					elseif ($tm == "22"){
						$s22++;
					}
					elseif ($tm == "23"){
						$s23++;
					}
				}

				$GrossProfit = $GrossProfit + $so->GrossSales;
				$NetProfit = $NetProfit  + $so->NetSales ;				
				$totalQty = $totalQty + $so->Qty;
				
				$i++;				
			}

			foreach ($newtable as $key => $row)
			{
				$data .= $row['html'];
				$modals .= "<div class=\"modal fade\" id=\"nota-detail-".trim(str_replace("(R)","",$key))."\">";
				$modals .= "	<div class=\"modal-dialog\" style=\"width:70%\">";
				$modals .= "		<div class=\"modal-content\" style=\"width:100%; margin-left:-50\">";
				$modals .= "			<div class=\"modal-header\">";
				$modals .= "				<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
				$modals .= "					<span aria-hidden=\"true\">&times;</span>";
				$modals .= "				</button>";
				$modals .= "				<h4 class=\"modal-title\">List Detail Nota #".$key.(($row['redeem']) ? " (R)" : "")."</h4>";
				$modals .= "			</div>";
				$modals .= "			<div class=\"modal-body\">";
				$modals .= "				<table class='table table-striped table-bordered'>";
				$modals .= "					<thead>";
				$modals .= "						<tr>";
				//$modals .= "							<th>No Nota</th>";
				$modals .= "							<th>Item No</th>";
				$modals .= "							<th>Name</th>";
				$modals .= "							<th>Category Location</th>";
				$modals .= "							<th>Qty</th>";
				$modals .= "							<th>Penjualan (Rp)</th>";
				$modals .= "							<th>Penjualan - Disc (Rp)</th>";
				$modals .= "						</tr>";
				$modals .= "					</thead>";
				$modals .= "					<tbody>";
				foreach ($row['items'] as $idx => $item)
				{
					$modals .= "					<tr>";
					//$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='left'>".$item->InventoryPostingGroup."</td>";
					$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='left'>".$item->ItemNo."</td>";
					$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='left'>".$item->Name."</td>";
					$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='center'>".$item->CatLoc."</td>";
					$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='right'>".number_format($item->Qty)."</td>";
					$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='right'>".number_format(((substr($item->InventoryPostingGroup,-3) !== "(R)" && $item->GrossSales <= 0) ? ($item->GrossSales * -1) : $item->GrossSales))."</td>";
					$modals .= "						<td".((substr($item->InventoryPostingGroup,-3) == "(R)") ? " class=\"bg-danger\"" : "")." align='right'>".number_format(((substr($item->InventoryPostingGroup,-3) !== "(R)" && $item->NetSales <= 0) ? ($item->NetSales * -1) : $item->NetSales))."</td>";
					$modals .= "					</tr>";
				}
				$modals .= "					</tbody>";
				$modals .= "					<tfoot>";
				$modals .= "						<tr>";
				$modals .= "							<th style=\"text-align:right !important;\" colspan=\"3\">Total</th>";
				$modals .= "							<th style=\"text-align:right !important;\">".number_format($row['totalQty'])."</th>";
				$modals .= "							<th style=\"text-align:right !important;\">".number_format($row['totalGross'])."</th>";
				$modals .= "							<th style=\"text-align:right !important;\">".(($row['totalQty'] == 0 || $row['totalQty'] == 0) ? 0 : number_format($row['totalNett']))."</th>";
				$modals .= "						</tr>";
				$modals .= "					</tfoot>";
				$modals .= "				</table>";
				$modals .= "			</div>";
				$modals .= "			<div class=\"modal-footer\">";
				$modals .= "				<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>";
				$modals .= "			</div>";
				$modals .= "		</div>";
				$modals .= "		<!-- /.modal-content -->";
				$modals .= "	</div>";
				$modals .= "	<!-- /.modal-dialog -->";
				$modals .= "</div>";
			}

			$TotalDiskon = $GrossProfit - $NetProfit;
			$AverageProfit = $TransactionCount != 0 ? $NetProfit / $TransactionCount : 0;
		}

		$data .= "</tbody></table>";
		$data .= $modals;
		
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
			//foreach($detail->PendapatanReal as $so){
				$data .= $dataexport;			
				/*$data .= "<tr>";
				$txt = $so->Date;
				$time = date('H:i', strtotime(substr($txt, -7)));
				$date = substr($txt, 0, 11);			
				$data .= "<td>".$date . " " .$time."</td>";
				//$data .= "<td>".$so->Date."</td>";
				$data .= "<td align='center'>".$so->ItemNo."</td>";
				$data .= "<td>".$so->Name."</td>";
				$data .= "<td>".$so->CatLoc."</td>";
				$data .= "<td align='right'>".$so->Qty."</td>";
				$data .= "<td align='right'>".$so->GrossSales."</td>";
				$data .= "<td align='right'>".$so->NetSales."</td>";
				$data .= "<td>".$so->InventoryPostingGroup."</td>";
				$data .= "<td>".$so->Outlet."</td>";
				$data .= "</tr>";*/
				//$i++;				
			//}			
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
			
		$data .="<div id='containerTimeChart' style='min-width: 310px; height: 400px; margin: 0 auto; display:block'></div><br>";
		$data .= "<table id='ReportTimeChart'  class='table table-striped table-bordered'  style='display:none'>";
		$data .= "<thead>
							<tr>
									<th></th>
									<th>Time Interval</th>
							</tr>
					</thead><tbody>";
		$data .= "<tr><td>09:00-10:00</td><td>".$s09."</td></tr>";
		$data .= "<tr><td>10:00-11:00</td><td>".$s10."</td></tr>";
		$data .= "<tr><td>11:00-12:00</td><td>".$s11."</td></tr>";
		$data .= "<tr><td>12:00-13:00</td><td>".$s12."</td></tr>";
		$data .= "<tr><td>13:00-14:00</td><td>".$s13."</td></tr>";
		$data .= "<tr><td>14:00-15:00</td><td>".$s14."</td></tr>";
		$data .= "<tr><td>15:00-16:00</td><td>".$s15."</td></tr>";
		$data .= "<tr><td>16:00-17:00</td><td>".$s16."</td></tr>";
		$data .= "<tr><td>17:00-18:00</td><td>".$s17."</td></tr>";
		$data .= "<tr><td>18:00-19:00</td><td>".$s18."</td></tr>";
		$data .= "<tr><td>19:00-20:00</td><td>".$s19."</td></tr>";
		$data .= "<tr><td>20:00-21:00</td><td>".$s20."</td></tr>";
		$data .= "<tr><td>21:00-22:00</td><td>".$s21."</td></tr>";
		$data .= "<tr><td>22:00-23:00</td><td>".$s22."</td></tr>";
		$data .= "<tr><td>23:00-24:00</td><td>".$s23."</td></tr>";
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
		//$data .= "<button type='button' id='export' onclick='ExportExcel2(this);' class='btn btn-success' style='margin-left: 0px;'>Export Data Payment</button>";
		//$data .= "<br><br>";
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
					if($so->Type == 'CASH')
					{
						$data .= "<td align='right'>".str_replace(",", ".", number_format(($so->TotalAmount - $so->TotalKembalian - $so->TotalDelivery)))."</td>";
					}
					else
					{
						$data .= "<td align='right'>".str_replace(",", ".", number_format($so->TotalAmount - $so->TotalDelivery))."</td>";
					}
					$data .= "</tr>";
					$i++;
				}
			}
		}
		$data .= "</tbody></table>";
		$data .= "</div>";

		//table export
		$data .="<div id='TblPaymentExport' style='display:none'>";
		$data .= "<b><p style='font-size:18px' id='lblTable4'></p></b>";
		$data .= "<table id='ReportPaymentList'  class='table table-striped table-bordered'>";
		$data .= "<thead>
							<tr>
									<th>Payment Type</th>
									<th>Payment Methode</th>
									<th>Description</th>
									<th>Total Transaksi</th>
									<th>Total Amount</th>
							</tr>
					</thead>";
					
		$totTrxPayment		= 0;
		$totAmountPayment	= 0;
		$totAmountDelivery	= 0;
		if(!empty($detail->PendapatanPaymentMethode)){
			foreach($detail->PendapatanPaymentMethode as $so){				
				if ($so->TotalTransaksi != 0){
					$totTrxPayment		= $totTrxPayment + $so->TotalTransaksi;
					$totAmountPayment	= $totAmountPayment + $so->TotalAmount;
					$totAmountDelivery	= $totAmountDelivery + $so->TotalDelivery;
					
					$data .= "<tr>";
					$data .= "<td>".$so->Type."</td>";
					$data .= "<td>".$so->Code.".</td>";
					$data .= "<td>".$so->Description."</td>";
					$data .= "<td align='right'>".str_replace(",", ".", number_format($so->TotalTransaksi))."</td>";
					if($so->Type == 'CASH')
					{
						$totAmountPayment	= $totAmountPayment - $so->TotalKembalian;
						$data .= "<td align='right'>".str_replace(",", ".", number_format(($so->TotalAmount - $so->TotalKembalian - $so->TotalDelivery)))."</td>";
					}
					else
					{
						$data .= "<td align='right'>".str_replace(",", ".", number_format($so->TotalAmount - $so->TotalDelivery))."</td>";
					}
					$data .= "</tr>";
					$i++;
				}
			}			
		}
		$data .= "<tr><td colspan=\"3\"></td><td align='right'>".str_replace(",", ".", number_format($totTrxPayment))."</td><td align='right'>".str_replace(",", ".", number_format($totAmountPayment - $totAmountDelivery))."</td></tr>";
		$data .= "</tbody></table>";
		$data .="</div>";
		//end Table Export

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
	
		//$data .= "<input type='hidden' id='TRCount' value='".str_replace(",", ".", number_format($TransactionCount))."' />" ;
		$data .= "<input type='hidden' id='TRCount' value='".str_replace(",", ".", number_format(count($newtable)))."' />" ;
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
