<?php if($penjualan->num_rows() > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>#</th>
				<th>Tanggal</th>
				<th>Total Pengembalian</th>
               
			</tr>
		</thead>
		<tbody>
			<?php
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
			";
			
			?>
		</tbody>
	</table>

	<p>
		<?php
		$from 	= date('Y-m-d', strtotime($from));
		$to		= date('Y-m-d', strtotime($to));
		?>
		<!-- <a href="<?php echo site_url('laporan/pdf/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a> -->
		<a href="<?php echo site_url('laporan/excel_pengembalian/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a>
	</p>
	<br />
<?php } ?>

<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>