<?php
class M_penjualan_master extends CI_Model
{
	function insert_master($nomor_nota, $tanggal, $id_kasir, $id_pelanggan,  $grand_total, $catatan, $ppn, $grand_bayar, $bayar)
	{
		$dt = array(
			'nomor_nota' => $nomor_nota,
			'tanggal' => $tanggal,
			'grand_total' => $grand_total,
			'bayar' => $bayar,
			'ppn'	=> $ppn,
			'grand_bayar'	=> $grand_bayar,
			'keterangan_lain' => $catatan,
			'id_pelanggan' => (empty($id_pelanggan)) ? NULL : $id_pelanggan,
			'id_user' => $id_kasir
		);

		return $this->db->insert('pj_penjualan_master', $dt);
	}

	function get_id($nomor_nota)
	{
		return $this->db
			->select('id_penjualan_m')
			->where('nomor_nota', $nomor_nota)
			->limit(1)
			->get('pj_penjualan_master');
	}

	function fetch_data_penjualan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_penjualan_m`, 
				a.`nomor_nota` AS nomor_nota, 
				DATE_FORMAT(a.`tanggal`, '%d %b %Y - %H:%i:%s') AS tanggal,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`grand_total`, 0),',','.') ) AS grand_total,
				IF(b.`nama` IS NULL, 'Umum', b.`nama`) AS nama_pelanggan,
				c.`nama` AS kasir,
				a.`keterangan_lain` AS keterangan   
			FROM 
				`pj_penjualan_master` AS a 
				LEFT JOIN `pj_pelanggan` AS b ON a.`id_pelanggan` = b.`id_pelanggan` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nomor_nota` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`tanggal`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`grand_total`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(b.`nama` IS NULL, 'Umum', b.`nama`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`keterangan_lain` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`tanggal`',
			2 => 'nomor_nota',
			3 => 'a.`grand_total`',
			4 => 'nama_pelanggan',
			5 => 'keterangan',
			6 => 'kasir'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function get_baris($id_penjualan)
	{
		$sql = "
			SELECT 
				a.`nomor_nota`, 
				a.`grand_total`,
				a.`tanggal`,
				a.`bayar`,
				a.`id_user` AS id_kasir,
				a.`id_pelanggan`,
				a.`keterangan_lain` AS catatan,
				b.`nama` AS nama_pelanggan,
				b.`alamat` AS alamat_pelanggan,
				b.`telp` AS telp_pelanggan,
				b.`info_tambahan` AS info_pelanggan 
			FROM 
				`pj_penjualan_master` AS a 
				LEFT JOIN `pj_pelanggan` AS b ON a.`id_pelanggan` = b.`id_pelanggan` 
			WHERE 
				a.`id_penjualan_m` = '".$id_penjualan."' 
			LIMIT 1
		";
		return $this->db->query($sql);
	}

	function hapus_transaksi($id_penjualan, $reverse_stok)
	{
		if($reverse_stok == 'yes'){
			$loop = $this->db
				->select('id_barang, jumlah_beli')
				->where('id_penjualan_m', $id_penjualan)
				->get('pj_penjualan_detail');

			foreach($loop->result() as $b)
			{
				$sql = "
					UPDATE `pj_barang` SET `total_stok` = `total_stok` + ".$b->jumlah_beli." 
					WHERE `id_barang` = '".$b->id_barang."' 
				";

				$this->db->query($sql);
			}
		}

		$this->db->where('id_penjualan_m', $id_penjualan)->delete('pj_penjualan_detail');
		return $this->db
			->where('id_penjualan_m', $id_penjualan)
			->delete('pj_penjualan_master');
	}

	function laporan_penjualan($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tanggal`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`grand_total`) 
					FROM 
						`pj_penjualan_master` AS b 
					WHERE 
						SUBSTR(b.`tanggal`, 1, 10) = SUBSTR(a.`tanggal`, 1, 10) 
					LIMIT 1
				) AS total_penjualan,
				(
					SELECT 
						SUM(c.`nilai_bayar`) 
					FROM 
						`pj_bayar` AS c
					WHERE 
						SUBSTR(c.`tanggal`, 1, 10) = SUBSTR(c.`tanggal`, 1, 10) 
						and type_bayar = 1
					LIMIT 1
				) AS cash,
				(
					SELECT 
						SUM(c.`nilai_bayar`) 
					FROM 
						`pj_bayar` AS c
					WHERE 
						SUBSTR(c.`tanggal`, 1, 10) = SUBSTR(c.`tanggal`, 1, 10) 
						and type_bayar = 2
					LIMIT 1
				) AS debet,
				(
					SELECT 
						SUM(c.`nilai_bayar`) 
					FROM 
						`pj_bayar` AS c
					WHERE 
						SUBSTR(c.`tanggal`, 1, 10) = SUBSTR(c.`tanggal`, 1, 10) 
						and type_bayar = 3
					LIMIT 1
				) AS credit
			FROM 
				`pj_penjualan_master` AS a 
			WHERE 
				SUBSTR(a.`tanggal`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tanggal`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tanggal` ASC
		";

		return $this->db->query($sql);
	}
	
	function laporan_pengembalian($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tanggal`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`return_value`) 
					FROM 
						`pj_pengembalian_master` AS b 
					WHERE 
						SUBSTR(b.`tanggal`, 1, 10) = SUBSTR(a.`tanggal`, 1, 10) 
					LIMIT 1
				) AS total_pengembalian
			FROM 
				`pj_pengembalian_master` AS a 
			WHERE 
				SUBSTR(a.`tanggal`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tanggal`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tanggal` ASC
		";
		return $this->db->query($sql);
	}


	function cek_nota_validasi($nota)
	{
		return $this->db->select('nomor_nota')->where('nomor_nota', $nota)->limit(1)->get('pj_penjualan_master');
	}
}