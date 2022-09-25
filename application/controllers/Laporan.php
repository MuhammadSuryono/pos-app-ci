<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Laporan extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('KASIR');

		if( ! in_array($level, $allowed))
		{
			redirect('secure/logout');
		}
	}

	public function index()
	{
		$this->load->view('laporan/form_laporan');
	}

	public function penjualan($from, $to){
		$post_data = array(
			'StartDate'		=> $from,
			'EndDate'		=> $to,
			'StoreCode'		=> $this->session->userdata('storeId'),
			'SalesName'	=> $this->session->userdata('ap_id_user')
		);
		$url = URL_API.'Report/ReportPenjualan';
		$data_api = $this->send_api->send_data($url, $post_data);
		
		$dt['penjualan'] 	= json_decode($data_api);
		
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualan', $dt);
	}
	
	public function pengembalian($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_pengembalian($from, $to);
		
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_pengembalian', $dt);
	}

	public function excel($from, $to){
		$post_data = array(
			'StartDate'		=> $from,
			'EndDate'		=> $to,
			'StoreCode'		=> $this->session->userdata('storeId')
		);
		$url = URL_API.'Report/ReportPenjualan';
		$data_api = $this->send_api->send_data($url, $post_data);
		
		$penjualan = json_decode($data_api);
		
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));;
		if(!empty($penjualan->ReportPenjualan)){
			$filename = 'Laporan_Penjualan_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
					<h4>Laporan Penjualan Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>#</th>
							<th>Tanggal</th>
							<th>Total Penjualan</th>
							<th>Cash</th>
							<th>Debet</th>
							<th>Credit Card</th>
							<th>Online</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			$total_cash = 0;
			$total_debet = 0;
			$total_credit = 0;
			$total_online = 0;
			foreach($penjualan->ReportPenjualan as $p){
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->Tanggal))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->Total + $p->Online))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->Cash))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->Debit))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->Kredit))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->Online))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->Total + $p->Online;
				$total_cash = $total_cash + $p->Cash;
				$total_debet = $total_debet + $p->Debit;
				$total_credit = $total_credit + $p->Kredit;
				$total_online = $total_online + $p->Online;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Penjualan</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_cash))."</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_debet))."</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_credit))."</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_online))."</b></td>
				</tr>
			</tbody>
			</table>";
		}
	}
	
	public function excel_pengembalian($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_pengembalian($from, $to);
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Penjualan_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
				<h4>Laporan Penjualan Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Total Pengembalian</th>
							
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			$total_cash = 0;
			$total_debet = 0;
			$total_credit = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tanggal))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_pengembalian))."</td>
						
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_pengembalian;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Penjualan</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
					
				</tr>
			</tbody>
			</table>
			";
		}
	}

	public function pdf($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 8, "Laporan Penjualan Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to)), 0, 1, 'L'); 

		$pdf->Cell(15, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(85, 7, 'Tanggal', 1, 0, 'L');
		$pdf->Cell(85, 7, 'Total Penjualan', 1, 0, 'L'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualan($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(85, 7, date('d F Y', strtotime($p->tanggal)), 1, 0, 'L');
			$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(100, 7, 'Total Seluruh Penjualan', 1, 0, 'L'); 
		$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	function open_close(){
		$url = URL_API.'SalesOrder/ClosePrint';
		$ip=$this->input->ip_address();
		//$app_login = $this->session->userdata('app_login');
		$post_data = array(
			'Username'	=> $this->session->userdata('ap_nama'),
			'MachineCode'	=> $ip,
			'StoreCode'	=> $this->session->userdata('storeId')
		);
		
		$data_api = $this->send_api->send_data($url, $post_data);
		//error_log(serialize($post_data));
		$dt['penjualan'] 	= $data_api;
		$this->load->view('laporan/cetak_open_close', $dt);
	}
}