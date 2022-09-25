<?php if(count($penjualan->ReportPenjualan) > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>#</th>
				<th>Tanggal</th>
				<th>Total Penjualan</th>
                <th>Cash</th>
                <th>Debit Card</th>
                <th>Credit Card</th>
				<th>Online</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$total_penjualan = 0;
			$total_cash = 0;
			$total_debet = 0;
			$total_credit = 0;
			$total_online = 0;
			foreach($penjualan->ReportPenjualan as $p)
			{
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
				</tr>";
			
			?>
		</tbody>
	</table>

	<p>
		<?php
		$from 	= date('Y-m-d', strtotime($from));
		$to		= date('Y-m-d', strtotime($to));
		?>
		<!-- <a href="<?php echo site_url('laporan/pdf/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a> -->
		<a href="<?php echo site_url('laporan/excel/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a>
	</p>
	<br />
<?php } ?>

<?php if(count($penjualan->ReportPenjualan) == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>