<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Pengembalian extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('MANAGER');

		if( ! in_array($level, $allowed))
		{
			redirect('secure/logout');
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
		$date = date("Y-m-d");
		$post_data = array(
			//'StartDate'		=> date( "Y-m-d", strtotime( "$date -1 day" )),
			'StartDate'		=> $date,
			'EndDate'		=> $date,
			'PosId'		=> $this->session->userdata('storeId')
		);
        $filter = '$filter';
        $location = $this->session->userdata('storeId');
        $dateNow = date("Y-m-d");
        $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesOrders?$filter=LocationCode eq '$location' and DocumentType eq 'Invoice' and PostingDate ge $dateNow";
		$data_api = $this->send_api->get_data($url, $post_data);
						
		$dt['nota'] = json_decode($data_api)->value;
		//$dt['nota'] = $this->m_pengembalian->get_nota();
		$this->load->view('pengembalian/transaksi', $dt);
	}
	
	
	public function simpan_transaksi()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir')
		{
			if($_POST)
			{
				if( ! empty($_POST['kode_barang']))
				{
					$this->load->model('m_pengembalian');
					$total = 0;
					foreach($_POST['kode_barang'] as $k)
					{
						if( ! empty($k)){ $total++; }
					}

					if($total > 0)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota_trans','Nomor Nota','trim|required|max_length[40]|alpha_numeric');
						$this->form_validation->set_rules('tanggal','Tanggal','trim|required');
						
						$no = 0;
						foreach($_POST['kode_barang'] as $d)
						{
							if( ! empty($d))
							{
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');
								$this->form_validation->set_rules('jumlah_beli['.$no.']','Qty #'.($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli['.$no.']]');
							}

							$no++;
						}
						
						$this->form_validation->set_rules('cash','Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan','Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$nomor_nota 	= $this->input->post('nomor_nota_trans');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$ppn			= $this->input->post('ppn');
							$grand_bayar	= $this->input->post('grand_bayar');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							if($bayar < $grand_bayar)
							{
								$this->query_error("Cash Kurang");
							}
							else
							{
								$this->load->model('m_penjualan_master');
								$master = $this->m_penjualan_master->insert_master($nomor_nota, $tanggal, $id_kasir, $id_pelanggan, $grand_total, $catatan, $ppn, $grand_bayar, $bayar);
								//error_log($this->db->last_query());
								if($master)
								{
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach($_POST['kode_barang'] as $k)
									{
										if( ! empty($k))
										{
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$sub_total 		= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;
											
											$insert_detail	= $this->m_penjualan_detail->insert_detail($id_master, $id_barang, $jumlah_beli, $harga_satuan, $sub_total);
											if($insert_detail)
											{
												$this->m_barang->update_stok($id_barang, $jumlah_beli);
												$inserted++;
											}
										}

										$no_array++;
									}

									if($inserted > 0)
									{
										$_noArray = 0;
										$type_bayar = '';
										$nilai_bayar = 0;
										$nama_bank = '';
										
										foreach($_POST['type_bayar'] as $rb){
											$type_bayar = $_POST['type_bayar'][$_noArray];
											$nilai_bayar = $_POST['nilai_bayar'][$_noArray];
											$nama_bank =  $_POST['nama_bank'][$_noArray];
											if($nilai_bayar > 0){
												$this->m_penjualan_detail->insert_bayar($id_master, $type_bayar, $nilai_bayar, $nama_bank, $tanggal);
												//error_log($this->db->last_query());
											}
											$_noArray++;
										}
										
										$ttl_ck = 0;
										$returnValHidden = $_POST['returnValHidden'];
										if(!empty($returnValHidden)){
											$master_return = $this->m_pengembalian->insert_master($id_master, $tanggal, $returnValHidden, $id_pelanggan, $id_kasir);
											$this->m_penjualan_detail->insert_bayar($id_master, 5, $returnValHidden, $master_return, $tanggal);
										}
										if($master_return > 0){
											$ckArray = 0;
											foreach($_POST['chk_return'] as $ck){
												$val_ck = $_POST['chk_return'][$ckArray];
												$_ck = explode('_', $val_ck);
												$_id_barang = 0;
												$_id_barang = $_ck[0];
												$_jumlah_return = $_ck[1];
												$_harga_satuan = $_ck[2];
												$_total = $_ck[3];
												
												$ttl_ck += $_total;
												if($_id_barang > 0){
													$this->m_pengembalian->insert_detail($master_return, $_id_barang, $_jumlah_return, $_harga_satuan, $_total);
													error_log($this->db->last_query());
												}
												$ckArray++;
											}
										}
										
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									}
									else
									{
										$this->query_error();
									}
								}
								else
								{
									$this->query_error();
								}
							}
						}
						else
						{
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
						}
					}
					else
					{
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				}
				else
				{
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			}
			else
			{
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan']= $this->m_pelanggan->get_all();
				$this->load->view('penjualan/transaksi', $dt);
			}
		}
	}

	public function ajax_nota(){
		$no_nota =  $this->input->post('no_nota');
		$post_data = array(
			'OrderNo'		=> $no_nota
		);
        $filter = '$filter';
        $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesOrders?$filter=no eq '$no_nota'";
        $data_api = $this->send_api->get_data($url, $post_data);
		$this->session->set_userdata('SalesOrderLine', '');
		$detail = json_decode($data_api);
		$data_order = $detail->value[0];


        $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment?$filter=SalesOrderNo eq '$no_nota'";
        $data_api = $this->send_api->get_data($url, $post_data);
        $detailPayment = json_decode($data_api);
        $dataPayment = $detailPayment->value[0];

        $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesLines?$filter=DocumentNo eq '$no_nota'";
        $data_api = $this->send_api->get_data($url, $post_data);
        $lines = json_decode($data_api);
		$detail_order = $lines->value;
		$banyak_baris = count($detail_order);
		if($this->input->is_ajax_request()){
			$nama_barang = array();
            $grandTotal = 0;
			if($banyak_baris > 0){
				foreach($detail_order as $db){
					$kode_barang[] = $db->no;
					$nama_barang[] = $db->description;
					$jml_beli[] = $db->quantity;
					$_disc[] = $db->DiscountAmount;
					$hrg_satuan[] =  number_format($db->unitPrice,2,',','.');
					$total[] =  number_format($db->unitPrice * $db->quantity,2,',','.');
					$dt_total[] = $db->No.'_'.$db->quantity.'_'.$db->unitPrice.'_'.$db->unitPrice * $db->quantity;
					$hrg_satuans[] =  $db->unitPrice;
					$point[] =  $db->Point;
					$barcode[] = $db->no;
                    $subTotal[] = $db->unitPrice * $db->quantity;
                    $grandTotal +=  $db->unitPrice * $db->quantity;
                    $locationCode[] =  $db->Location_Code;
                    $Unit_of_Measure[] =  $db->Unit_of_Measure;
				}
			}
			$json['grand_bayar'] = (!empty($dataPayment->NominalPayment)) ? number_format($dataPayment->NominalPayment,2,',','.') : 0;
			$json['ppn'] = 0;
			$CustomerNo = $data_order->sellToCustomerNo;
            $CustomerName = $data_order->sellToCustomerName;
            $paymentMethodeCode = $data_order->PaymentMethodCode;
			$json['id_pelanggan'] = $data_order->sellToCustomerNo;
			$json['grand_ttl'] = (!empty($grandTotal)) ? number_format($grandTotal,2,',','.') : 0;
			$json['nama_kasir']	= (!empty($data_order->KasirName)) ? $data_order->KasirName : "<small><i>POS-03</i></small>";
			$json['tanggal'] = (!empty($data_order->PostingDate)) ? date('d F Y', strtotime($data_order->PostingDate)) : "<small><i>Tidak ada</i></small>";
			$json['nama'] = (!empty($data_order->sellToCustomerName)) ? $data_order->sellToCustomerName : "<small><i>Tidak ada</i></small>";
			$json['telp'] = (!empty($data_order->PhoneNo)) ? $data_order->PhoneNo : "<small><i>Tidak ada</i></small>";
			$json['nama_brg'] = $nama_barang;
			$json['jml_beli'] = $jml_beli;
			$json['hrg_satuan'] = $hrg_satuan;
			$json['total'] = $total;
			$json['subTotal'] = $subTotal;
			$json['dt_total'] = $dt_total;
			$json['banyak_baris'] = $banyak_baris;
			$json['kode_barang'] = $kode_barang;
			
			$data_master['no_nota'] = $no_nota;
			$data_master['CustomerNo'] = $CustomerNo;
			$data_master['CustomerName'] = $CustomerName;
			$data_master['PaymentMethodeCode'] = $paymentMethodeCode;

			for($i=0;$i<sizeof($kode_barang);$i++){
			//if($jml_beli[$i] > 0){
				$dataSet[$i] = array (
					'ItemCode'	=> $kode_barang[$i],
					'Qty'		=> $jml_beli[$i],
					'UnitPrice'	=> $hrg_satuans[$i],
					'Discount'	=> $_disc[$i],
					'Point'		=> $point[$i],
					'Barcode'	=> $barcode[$i],
                    'Nama' => $nama_barang[$i],
                    'Location_Code' => $locationCode[$i],
                    'Unit_of_Measure' => $Unit_of_Measure[$i]
				);
			//}
			}
			$this->session->set_userdata('data_master', '');
			$this->session->set_userdata('SalesOrderLine', $dataSet);
			$this->session->set_userdata('data_master', $data_master);
			echo json_encode($json);
		}
	}
	
	public function simpan_return(){

        $filter = '$filter';
        $url = URL_API."/POS_Integration_GetLastNoUsedSeries?Company=MKS%20DEMO";
        $data_api = $this->send_api->send_data($url, ["documentType" => "crmemo", "locationFilter" => $this->session->userdata("storeId")]);
        $lastCode = json_decode($data_api)->value;
		
        $data_master = $this->session->userdata('data_master');

        $bodySalesInvoiceHeader = [
            "no" => $lastCode,
            "DocumentType"=> "Credit Memo",
            "PostingDate"=> date("Y-m-d"),
            "sellToCustomerNo"=> $data_master["CustomerNo"],
            "sellToCustomerName"=> $data_master["CustomerName"],
            "shipmentDate"=> date("Y-m-d"),
            "ExternalDocNo"=> $data_master["no_nota"],
            "PaymentMethod"=> $data_master["PaymentMethodeCode"],
            "POSTransTime" => date('h:m:i'),
			"Appliestodoctype" => "Invoice",
			"Appliestodocno" => $data_master["no_nota"],
            "PostingNo" => $lastCode,
            "LocationCode"=> $this->session->userdata("storeId"),
        ];
        $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesOrders";
        $data_api = $this->send_api->send_data($url, $bodySalesInvoiceHeader);

        $salesOrder = $this->session->userdata('SalesOrderLine');
        $ReturOrderLine = array();
        foreach ($salesOrder as $key => $sales) {
			$returnData = [
                "DocumentType"=> "Credit Memo",
                "DocumentNo"=> $lastCode,
                "lineNo"=> 10000 + ($key * 10000) ,
                "type"=> "Item",
                "no"=> $sales['ItemCode'],
                "description"=> $sales["Nama"],
                "unitOfMeasure"=> $sales["Unit_of_Measure"],
                "LocationCode"=> $sales["Location_Code"],
                "quantity"=> (int)$sales['Qty'],
                "unitPrice"=> (int)$sales['UnitPrice'],
                "DiscountAmount" => (int)$sales['Discount']
            ];
            $ReturOrderLine[] = $returnData;

			$url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesLines";
			$data_api = $this->send_api->send_data($url, $returnData);
        }

        $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment?$filter=SalesOrderNo eq '$data_master[no_nota]'";
        $data_api = $this->send_api->get_data($url, []);
        $detailPayment = json_decode($data_api);
        $dataPayment = $detailPayment->value;

        foreach ($dataPayment as $key => $value) {
            $bodySalesInvoicePayment = [
                "SalesOrderNo"=> $lastCode,
                "PaymentMethodCode"=> $value->PaymentMethodCode,
                "NominalPayment"=> -(int)$value->NominalPayment,
                "PaymentType"=> $value->PaymentType,
                "QtyPoint"=> 0,
                "NoNOTA"=> "",
                "DeliveryAmount"=> 0
            ];
            $url = URL_API."/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment";
            $data_api = $this->send_api->send_data($url, $bodySalesInvoicePayment);
        }

        $bodySubmit = ["crMemoNo" => $lastCode];

        $url = URL_API."/POS_Integration_PostingCrMemo?Company=MKS%20DEMO";
        $data_api = $this->send_api->send_data($url, $bodySubmit);
        echo json_encode(['status' => 'Posted']);
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
		$pelanggan = 'umum';
		if( ! empty($id_pelanggan))
		{
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}

		$this->load->library('cfpdf');		
		$pdf = new FPDF('P','mm','A5');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',10);

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
		//$level = $this->session->userdata('ap_level');
		$post_data = array(
			'PosId'		=> $this->session->userdata('storeId')
		);
		$url = URL_API.'ReturOrder/ViewReturOrder';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$dt['sales_order'] = json_decode($data_api);
		$this->load->view('pengembalian/transaksi_history', $dt);
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
			'OrderNo'		=> $id_penjualan,
			'PosId'		=> $this->session->userdata('storeId')
		);
		$url = URL_API.'ReturOrder/ViewReturOrderbyNo';
		$data_api = $this->send_api->send_data($url, $post_data);
			
		$dt['detail'] = json_decode($data_api);
		$this->load->view('pengembalian/transaksi_history_detail', $dt);
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

	public function pelanggan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			$this->load->view('penjualan/pelanggan_data');
		}
	}

	public function pelanggan_json()
	{
		$this->load->model('m_pelanggan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_pelanggan->fetch_data_pelanggan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['alamat']);
			$nestedData[]	= $row['telp'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['info_tambahan']);
			$nestedData[]	= $row['waktu_input'];
			
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan') 
			{
				$nestedData[]	= "<a href='".site_url('penjualan/pelanggan-edit/'.$row['id_pelanggan'])."' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if($level == 'admin') 
			{
				$nestedData[]	= "<a href='".site_url('penjualan/pelanggan-hapus/'.$row['id_pelanggan'])."' id='HapusPelanggan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_pelanggan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama','Nama','trim|required|alpha_spaces|max_length[40]');
				$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
				$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');
				$this->form_validation->set_rules('info','Info Tambahan Lainnya','trim|max_length[1000]');

				$this->form_validation->set_message('alpha_spaces','%s harus alphabet !');
				$this->form_validation->set_message('numeric','%s harus angka !');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('m_pelanggan');
					$nama 		= $this->input->post('nama');
					$alamat 	= $this->clean_tag_input($this->input->post('alamat'));
					$telepon 	= $this->input->post('telepon');
					$info 		= $this->clean_tag_input($this->input->post('info'));

					$unique		= time().$this->session->userdata('ap_id_user');
					$insert 	= $this->m_pelanggan->tambah_pelanggan($nama, $alamat, $telepon, $info, $unique);
					if($insert)
					{
						$id_pelanggan = $this->m_pelanggan->get_dari_kode($unique)->row()->id_pelanggan;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil ditambahkan sebagai pelanggan.</div>",
							'id_pelanggan' => $id_pelanggan,
							'nama' => $nama,
							'alamat' => preg_replace("/\r\n|\r|\n/",'<br />', $alamat),
							'telepon' => $telepon,
							'info' => (empty($info)) ? "<small><i>Tidak ada</i></small>" : preg_replace("/\r\n|\r|\n/",'<br />', $info)						
						));
					}
					else
					{
						$this->query_error();
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
				$this->load->view('penjualan/pelanggan_tambah');
			}
		}
	}

	public function pelanggan_edit($id_pelanggan = NULL)
	{
		if( ! empty($id_pelanggan))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('m_pelanggan');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama','Nama','trim|required|alpha_spaces|max_length[40]');
						$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
						$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');
						$this->form_validation->set_rules('info','Info Tambahan Lainnya','trim|max_length[1000]');

						$this->form_validation->set_message('alpha_spaces','%s harus alphabet !');
						$this->form_validation->set_message('numeric','%s harus angka !');
						$this->form_validation->set_message('required','%s harus diisi !');

						if($this->form_validation->run() == TRUE)
						{
							$nama 		= $this->input->post('nama');
							$alamat 	= $this->clean_tag_input($this->input->post('alamat'));
							$telepon 	= $this->input->post('telepon');
							$info 		= $this->clean_tag_input($this->input->post('info'));

							$update 	= $this->m_pelanggan->update_pelanggan($id_pelanggan, $nama, $alamat, $telepon, $info);
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
								));
							}
							else
							{
								$this->query_error();
							}
						}
						else
						{
							$this->input_error();
						}
					}
					else
					{
						$dt['pelanggan'] = $this->m_pelanggan->get_baris($id_pelanggan)->row();
						$this->load->view('penjualan/pelanggan_edit', $dt);
					}
				}
			}
		}
	}

	public function pelanggan_hapus($id_pelanggan)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('m_pelanggan');
				$hapus = $this->m_pelanggan->hapus_pelanggan($id_pelanggan);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
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
	
	public function laporan(){
		$this->load->view('pengembalian/form_laporan');
	}
	
}