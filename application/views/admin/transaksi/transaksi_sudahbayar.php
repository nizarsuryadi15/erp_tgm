<div class="container-fluid my-4">
    <div class="row">
        <div class="col-12">
            <!-- Panel wrapper -->
            <div class="card">
                <div class="card-body">

                    <!-- Tombol aksi (jika diperlukan, uncomment) -->
                    <!--
                    <div class="mb-3">
                        <a href="<?= base_url('transaksi/add/1/1'); ?>" class="btn btn-primary">Tambah Transaksi <?= $controller ?></a>
                        <a href="<?= base_url($controller.'/formAdd') ?>" class="btn btn-success">
                            Cetak <?= $controller ?> <i class="fa fa-print"></i>
                        </a>
                    </div>
                    -->

                    <!-- Tabel Transaksi -->
                   <div class="table-responsive">
                    <table id="datatable-details" class="table table-bordered table-striped">
                        <thead class="table-dark">
                                <tr>
                                    <th>Nomor SPK</th>
                                    <th>Tanggal<br>Jam Pemesanan</th>
                                    <th>Nama<br>Pelanggan</th>
                                    <th>Metode<br>Pemesanan</th>
                                    <th>Jumlah Item</th>
                                    <th>Total<br>Transaksi</th>
                                    <th>Status<br>Pembayaran</th>
                                    <th>Total<br>Bayar</th>
                                    <th>Kurang<br>Bayar</th>
                                    <th>Pengguna</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi_sudahbayar as $dt): 
                                    $status_pembayaran = ($dt->status_pembayaran == '0') 
                                        ? "<span class='text-danger'>Belum Bayar</span>" 
                                        : "<span class='text-success'>Sudah Bayar</span>";

                                    $total_bayar  = $dt->bayar_tunai + $dt->bayar_debit + $dt->bayar_kartukredit + $dt->bayar_transfer + $dt->bayar_ewallet;
                                    $kurang_bayar = $dt->grand_total - $total_bayar;

                                    $item = $this->M_transaksi->getDetailPesan($dt->nospk)->num_rows();

                                    $message_wa = '-TGMPrint- %20Haii%20'.$dt->konsumen_nama.'%20Terima%20Kasih%20Sudah%20Berbelanja%20di%20TGMPrint%20Rp.%20'.number_format($dt->jml_pemesanan).'%20Dengan%20Nomor%20SPK%20:'.$dt->nospk.'%20Untuk%20Cek%20Progress%20Pekerjaan%20Anda,%20Silahkan%20Cek%20Link%20dibawah%20ini%20:%20https://erp.tgmprint.com/cekpesanan/spk/'.$dt->nospk;
                                ?>
                                <tr>
                                    <td><?= $dt->nospk ?></td>
                                    <td>
                                        <?= date_indo($dt->tgl_pemesanan) ?><br>
                                        <small class="text-muted"><?= date_indo($dt->jam_pemesanan) ?></small>
                                    </td>
                                    <td>
                                        Nama: <?= $dt->konsumen_nama ?><br>
                                        WA: <?= $dt->konsumen_nohp ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $dt->nama_jenis_transaksi ?><br>
                                        <small class="text-muted"><?= $dt->marketplace_nama ?></small>
                                    </td>
                                    <td class="text-center"><?= $item ?></td>
                                    <td class="text-end"><?= number_format($dt->jml_pemesanan) ?></td>
                                    <td class="text-center"><?= $status_pembayaran ?></td>
                                    <td class="text-end"><?= number_format($total_bayar) ?></td>
                                    <td class="text-end"><?= number_format($kurang_bayar) ?></td>
                                    <td><?= $dt->karyawan_nama ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url($controller . "/cetak_invoice_ulang/" . $dt->nospk) ?>" class="btn btn-sm btn-dark" title="Cetak Invoice">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?phone=<?= $dt->konsumen_nohp ?>&text=<?= $message_wa ?>" target="_blank" class="btn btn-sm btn-success" title="Kirim WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> <!-- .table-responsive -->

                </div>
            </div>
        </div>
    </div>
</div>
