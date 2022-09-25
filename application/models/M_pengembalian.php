<?php
class M_pengembalian extends CI_Model
{
	function get_nota(){
		return $this->db
			->select('nomor_nota,id_penjualan_m')
			->get('pj_penjualan_master');
	}
	
	function get_transaksi($id_penjualan_m){
		return $this->db
			->select('pp.nama, pp.telp, pp.alamat, pp.info_tambahan, pu.nama AS nama_kasir, ppm.*', false)
			->join('pj_pelanggan pp','pp.id_pelanggan=ppm.id_pelanggan', 'LEFT')
			->join('pj_user pu','pu.id_user=ppm.id_user', 'LEFT')
			->where('ppm.id_penjualan_m', $id_penjualan_m)
			->get('pj_penjualan_master ppm');
	}
	
	function get_brg_transaksi($id_penjualan_m){
		return $this->db
			->join('pj_barang pb','pb.id_barang=ppd.id_barang', 'LEFT')
			
			->where('ppd.id_penjualan_m', $id_penjualan_m)
			->get('pj_penjualan_detail ppd');
	}
	
	function insert_detail($id_master, $id_barang, $jumlah_return, $harga_satuan, $total){
		$dt = array(
			'id_pengembalian_m' => $id_master,
			'id_barang	' => $id_barang,
			'jumlah_return' => $jumlah_return,
			'harga_satuan' => $harga_satuan,
			'total' => $total
		);

		return $this->db->insert('pj_pengembalian_detail', $dt);
	}
	
	function insert_master($id_penjualan, $tanggal, $return_value, $id_pelanggan, $id_kasir){
		$dt = array(
			'id_penjualan_m' 	=> $id_penjualan,
			'tanggal'	 	=> $tanggal,
			'return_value'	=> $return_value,
			'id_pelanggan' 	=> (empty($id_pelanggan)) ? NULL : $id_pelanggan,
			'id_user' 		=> $id_kasir
		);
		$this->db->insert('pj_pengembalian_master', $dt);
		return $this->db->insert_id();
	}

}