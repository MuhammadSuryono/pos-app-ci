<?php
class M_barang extends CI_Model 
{
	function fetch_data_barang($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`nama_barang`,
				a.point,
				IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) AS total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`,
				IF(c.`merk` IS NULL, '-', c.`merk` ) AS merk 
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_merk_barang` AS c ON a.`id_merk_barang` = c.`id_merk_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' and a.`type`=1 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_barang` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nama_barang` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`size` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`keterangan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`kategori` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`merk` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'a.`size`',
			4 => 'b.`kategori`',
			5 => 'c.`merk`',
			6 => 'a.`total_stok`',
			7 => '`harga`',
			8 => 'a.`keterangan`'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function hapus_barang($id_barang)
	{
		$dt['dihapus'] = 'ya';
		return $this->db
				->where('id_barang', $id_barang)
				->update('pj_barang', $dt);
	}

	function tambah_baru($kode, $nama, $id_kategori_barang, $size, $id_merk_barang, $stok, $harga, $keterangan, $type, $point)
	{
		$dt = array(
			'kode_barang' => $kode,
			'nama_barang' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'id_merk_barang' => (empty($id_merk_barang)) ? NULL : $id_merk_barang,
			'keterangan' => $keterangan,
			'dihapus' => 'tidak',
			'type'		=> $type,
			'point'		=> $point
		);

		return $this->db->insert('pj_barang', $dt);
	}

	function cek_kode($kode)
	{
		return $this->db
			->select('id_barang')
			->where('kode_barang', $kode)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('pj_barang');
	}

	function get_baris($id_barang)
	{
		return $this->db
			->select('id_barang, kode_barang, nama_barang, total_stok, harga, id_kategori_barang, id_merk_barang, keterangan')
			->where('id_barang', $id_barang)
			->limit(1)
			->get('pj_barang');
	}

	function update_barang($id_barang, $kode_barang, $nama, $id_kategori_barang, $size, $id_merk_barang, $stok, $harga, $keterangan, $point)
	{
		$dt = array(
			'kode_barang' => $kode_barang,
			'nama_barang' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'size' => $size,
			'id_kategori_barang' => $id_kategori_barang,
			'id_merk_barang' => (empty($id_merk_barang)) ? NULL : $id_merk_barang,
			'keterangan' => $keterangan,
			'point'		=> $point
		);

		return $this->db
			->where('id_barang', $id_barang)
			->update('pj_barang', $dt);
	}

	function cari_kode($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if(count($koma) > 1)
		{
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach($koma as $k)
			{
				$not_in .= " '".$k."', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in.")";
		}
		if(count($koma) == 1)
		{
			$not_in .= " AND `kode_barang` != '".$registered."' ";
		}

		$sql = "
			SELECT 
				`kode_barang`, `nama_barang`, `harga` 
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `total_stok` > 0 
				AND ( 
					`kode_barang` LIKE '%".$this->db->escape_like_str($keyword)."%' 
					OR `nama_barang` LIKE '%".$this->db->escape_like_str($keyword)."%' 
				) 
				".$not_in." 
		";

		return $this->db->query($sql);
	}

	function get_stok($kode)
	{
		return $this->db
			->select('nama_barang, total_stok')
			->where('kode_barang', $kode)
			->limit(1)
			->get('pj_barang');
	}

	function get_id($kode_barang)
	{
		return $this->db
			->select('id_barang, nama_barang')
			->where('kode_barang', $kode_barang)
			->limit(1)
			->get('pj_barang');
	}

	function update_stok($id_barang, $jumlah_beli)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` - ".$jumlah_beli." WHERE `id_barang` = '".$id_barang."'
		";

		return $this->db->query($sql);
	}
	
	function fetch_data_voucher($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`nama_barang`,
				
				IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) AS total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`,
				IF(c.`merk` IS NULL, '-', c.`merk` ) AS merk 
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_merk_barang` AS c ON a.`id_merk_barang` = c.`id_merk_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' and a.`type`=2 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_barang` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nama_barang` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`size` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`keterangan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`kategori` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`merk` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'a.`size`',
			4 => 'b.`kategori`',
			5 => 'c.`merk`',
			6 => 'a.`total_stok`',
			7 => '`harga`',
			8 => 'a.`keterangan`'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
}