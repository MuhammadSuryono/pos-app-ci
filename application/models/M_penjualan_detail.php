<?php
class M_penjualan_detail extends CI_Model
{
	function insert_detail($id_master, $id_barang, $jumlah_beli, $harga_satuan, $sub_total)
	{
		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_barang	' => $id_barang,
			'jumlah_beli' => $jumlah_beli,
			'harga_satuan' => $harga_satuan,
			'total' => $sub_total
		);

		return $this->db->insert('pj_penjualan_detail', $dt);
	}
	
	function insert_bayar($id_master, $type_bayar, $nilai_bayar, $nama_bank, $tanggal)
	{
		$dt = array(
			'id_penjualan' 	=> $id_master,
			'nilai_bayar' 	=> $nilai_bayar,
			'type_bayar'	=> $type_bayar,
			'keterangan'	=> $nama_bank,
			'tanggal' 		=> $tanggal
		);

		return $this->db->insert('pj_bayar', $dt);
	}

	function get_detail($id_penjualan)
	{
		$sql = "
			SELECT 
				b.`kode_barang`,  
				b.`nama_barang`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total,
				a.`total` AS sub_total_asli  
			FROM 
				`pj_penjualan_detail` a 
				LEFT JOIN `pj_barang` b ON a.`id_barang` = b.`id_barang` 
			WHERE 
				a.`id_penjualan_m` = '".$id_penjualan."' 
			ORDER BY 
				a.`id_penjualan_d` ASC 
		";

		return $this->db->query($sql);
	}
}