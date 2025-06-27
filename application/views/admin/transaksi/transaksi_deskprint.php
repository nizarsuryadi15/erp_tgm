<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0" id="datatable-details">		
                        <thead class="table-dark">
                            <tr>
                                <th>Nomor SPK</th>
                                <th>Tanggal<br>Jam Pemesanan</th>
                                <th>Nama<br>Pelanggan</th>
                                <th>WA<br>Pelanggan</th>
                                <th>Metode<br>Pemesanan</th>
                                <th>Jumlah<br>Item</th>
                                <th>Total<br>Transaksi</th>
                                <th>Status<br>Pembayaran</th>
                                <th hidden></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no =1;
                                foreach ($tampilData as $dt){
                                    if ($dt->status_pembayaran == '0'){
                                        $status_pembayaran = "<span class='text-danger'>Belum Bayar</span>";
                                        $base_url          = base_url('transaksi/createspk/'.$dt->nospk);
                                        $tombolspk         = "<a class='btn btn-primary w-100' href='".$base_url."'>$dt->nospk</a>";
                                    }else{
                                        $status_pembayaran = "<span class='text-success'>Sudah Bayar</span>";
                                        $tombolspk         = "<a class='btn btn-dark w-100 disabled' href='#'>$dt->nospk</a>";
                                    }

                                    $total_bayar  = $dt->bayar_tunai + $dt->bayar_debit + $dt->bayar_kartukredit + $dt->bayar_transfer + $dt->bayar_ewallet;
                                    $kurang_bayar = $dt->grand_total - $total_bayar;
                            ?>
                            <tr>
                                <td><?= $tombolspk ?></td>
                                <td><?= date_indo($dt->tgl_pemesanan) ?> - <?= date_indo($dt->jam_pemesanan) ?></td>
                                <td><?= $dt->konsumen_nama ?></td>
                                <td><?= $dt->konsumen_nohp ?></td>
                                <td class="text-center">
                                    <div><?= $dt->nama_jenis_transaksi ?></div>
                                    <small><?= $dt->marketplace_nama ?></small>
                                </td>
                                <td hidden>
                                    <table class="table table-bordered mb-0">
                                        <thead class="table-success">
                                            <tr>
                                                <th>No</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $nomor = 1;
                                                foreach ($qdetail as $dtl){
                                                    if ($dtl->harga_aktif == '1') {
                                                        $harga = $dtl->harga_1;
                                                    } elseif ($dtl->harga_aktif == '2') {
                                                        $harga = $dtl->harga_2;
                                                    } elseif ($dtl->harga_aktif == '3') {
                                                        $harga = $dtl->harga_3;
                                                    } else {
                                                        $harga = 0;
                                                    }
                                                    $jumlah = $harga * $dtl->qty;
                                            ?>
                                            <tr>
                                                <td><?= $nomor ?></td>
                                                <td><?= $dtl->product_nama ?></td>
                                                <td><?= $dtl->qty ?></td>
                                                <td class="text-end"><?= number_format($harga) ?></td>
                                                <td class="text-end"><?= number_format($jumlah) ?></td>
                                            </tr>
                                            <?php $nomor++; } ?>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $qdetail = $this->M_transaksi->getDetailPesan($dt->nospk)->result();
                                        $item    = $this->M_transaksi->getDetailPesan($dt->nospk)->num_rows();
                                    ?>
                                    <?= $item ?>
                                </td>
                                <td class="text-end"><?= number_format($dt->jml_pemesanan) ?></td>
                                <td class="text-center"><?= $status_pembayaran ?></td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div> <!-- /.table-responsive -->
            </div> <!-- /.card-body -->
        </div> <!-- /.card -->
    </div>
</div>

