<style>
        table.a{
            border: solid 0px;
            width:300px;
            font-family:arial;
            font-size:12px;
			height:75px;
		}
</style>

<section class="panel">
	<div class="panel-body">
		<div class="invoice">
			<!-- <header class="clearfix"> -->
				<div class="row">
					<div class="col-sm-6 mt-md">
						<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">NO SPK </h2>
						<h4 class="h4 m-none text-dark text-weight-bold"><?= $nospk ?></h4>
					</div>
					
				</div>
			<!-- </header> -->
			
				<div class="row">
						<table class='a'>
							<tr>
								<td colspan="3" align="center">
								
								</td>
							</tr>
							<tr><td colspan="3" align="center"><hr></td></tr>
							<tr><td width="30%">Konsumen</td><td width="5%">:</td> <td><?= $pembayaran['konsumen_nama'] ?></td></tr>
							<tr><td width="30%">HP</td><td width="5%">:</td> <td><?= $pembayaran['konsumen_nohp'] ?></td></tr>  
							<?php 
								$tanggal        = $pembayaran['pembayaran_tgl'];
								$jam            = $pembayaran['pembayaran_jam'];
								$tgldateline    = substr($pembayaran['dateline_tgl'], 0,10);
								
							?>
							
							<tr><td width="30%">Tanggal/Jam</td><td width="5%">:</td> <td><?= date_indo(@$tanggal) ?> / <?= date_indo(@$jam) ?></td></tr>
							<!-- <tr><td width="30%">Nama Kasir</td><td width="5%">:</td> <td><?= $pembayaran['username'] ?></td></tr> -->
							
							<!-- <tr><td width="30%">Dateline:</td><td width="5%">: </td> <td><?= date_indo($tgldateline) ?> - <?= @$data_transaksi['dateline_jam'] ?> </td></tr> -->
							
							<tr><td colspan="3" align="center"><hr></td></tr>
						</table>
					
						<table class='a'>
						
							<tr>
								<td width="40%"><b>Product</b></td>
								<td  align="center" width="10%"><b>Qty</td>
								<td  align="center" width="10%"><b>Uk</td>
								<td width="20%" align="center"><b>Harga</td>
								<td width="20%" align="right"><b>Jumlah</td>
							</tr>
						<?php
							
							foreach ($detailBayar as $dt)
							{
								if ($dt->harga_aktif == '1'){
									$harga = $dt->harga_1;
								}elseif ($dt->harga_aktif == '2'){
									$harga = $dt->harga_2;
								}elseif ($dt->harga_aktif == '3'){
									$harga = $dt->harga_3;
								}
								$jumlah = $harga * $dt->qty;
							?>
							<tr>
								<td><?= $dt->detail_product ?></td>
								<td align="center"><?= $dt->qty ?></td>
								<td></td>
								<td align="right"><?= number_format($harga) ?></td>
								<td align="right"><?= number_format($jumlah) ?></td>
							</tr>

							<?php
								@$no++;
								
							}
							

						?>
							<tr><td colspan="5" align="center"><hr></td></tr>
							<tr>
								<td colspan="5" align="center">
									<strong>Posisi Pesanan Anda</strong>
									<hr>
								</td>
							</tr>
							<tr>
								<td colspan="6" align="center">
							<?php 
								if ($cekflow['status_produksi'] == '0'){
                                    $status = '<button class="btn btn-warning btn-block btn-sm disabled">Pending - Menunggu di Proses</button>';
                                }elseif ($cekflow['status_produksi'] == '1'){
                                    $status = '<button class="btn btn-primary btn-block disabled btn-sm">On Proses</button>';
                                }elseif ($cekflow['status_produksi'] == '2'){
                                    $status = '<button class="btn btn-danger btn-block disabled btn-sm">Barang Siap Diambil</button>';
                                }

								echo $status;
							?>

								</td>
							</tr>
						</table>
					</div>
				</div>

		</div>
	</div>
</section>