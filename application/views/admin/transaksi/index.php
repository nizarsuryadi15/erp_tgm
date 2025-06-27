<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Info Boxes-->
        <div class="row">
            <!-- Pendapatan Total -->
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa fa-download fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title">Pendapatan Total</h5>
                            <h6 class="card-subtitle mb-2">Rp. <?= number_format($total_transaksi['totalna']) ?></h6>
                            <a href="<?= base_url('transaksi/transaksi_sudahbayar') ?>" class="text-white">Cek Detail</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Masuk (Belum Bayar) -->
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa fa-download fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title">Transaksi Masuk</h5>
                            <h6 class="card-subtitle mb-2"><?= $total_belumbayar ?></h6>
                            <a href="<?= base_url('transaksi/transaksi_belumbayar') ?>" class="text-white">Perlu Di Proses</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Sudah Bayar -->
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa fa-check fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title">Transaksi Masuk</h5>
                            <h6 class="card-subtitle mb-2"><?= $total_sudahbayar ?></h6>
                            <a href="<?= base_url('transaksi/transaksi_sudahbayar') ?>" class="text-white">Sudah di Proses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Info Boxes-->

        <!--begin::Transaksi Table-->
        <div class="row mt-5">
            <div class="col-12">
                <h2>Transaksi Yang Perlu Di Proses</h2>
                <hr>
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
                                <th>Deskprint</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi_belumbayar as $dt): 
                                $status_pembayaran = $dt->status_pembayaran == '0' 
                                    ? "<span class='text-danger'>Belum Bayar</span>" 
                                    : "<span class='text-success'>Sudah Bayar</span>";

                                $tombolspk = $dt->status_pembayaran == '0' 
                                    ? "<a class='btn btn-primary' href='" . base_url('transaksi/createspk/' . $dt->nospk) . "'>$dt->nospk</a>" 
                                    : "<button class='btn btn-secondary' disabled>$dt->nospk</button>";

                                $total_bayar = $dt->bayar_tunai + $dt->bayar_debit + $dt->bayar_kartukredit + $dt->bayar_transfer + $dt->bayar_ewallet;
                                $kurang_bayar = $dt->grand_total - $total_bayar;
                                $qdetail = $this->M_transaksi->getDetailPesan($dt->nospk)->result();
                                $item = count($qdetail);
                                $message_wa = '-TGMPrint- %20Haii%20' . $dt->konsumen_nama . '%20Terima%20Kasih%20Sudah%20Berbelanja%20di%20TGMPrint%20Rp.%20' . number_format($dt->jml_pemesanan) . '%20Dengan%20Nomor%20SPK%20:' . $dt->nospk . '%20Untuk%20Cek%20Progress%20Pekerjaan%20Anda,%20Silahkan%20Cek%20Link%20dibawah%20ini%20:%20https://erp.tgmprint.com/cekpesanan/spk/' . $dt->nospk;
                            ?>
                            <tr>
                                <td><?= $dt->nospk ?></td>
                                <td><?= date_indo($dt->tgl_pemesanan) ?><br><small><?= date_indo($dt->jam_pemesanan) ?></small></td>
                                <td>Nama: <?= $dt->konsumen_nama ?><br>WA: <?= $dt->konsumen_nohp ?></td>
                                <td><?= $dt->nama_jenis_transaksi ?><br><?= $dt->marketplace_nama ?></td>
                                <td><?= $item ?></td>
                                <td class="text-end"><?= number_format($dt->jml_pemesanan) ?></td>
                                <td><?= $status_pembayaran ?></td>
                                <td class="text-end"><?= number_format($total_bayar) ?></td>
                                <td class="text-end"><?= number_format($kurang_bayar) ?></td>
                                <td><?= $dt->nama_lengkap ?></td>
                                <td>
                                    <?php if (in_array($level['role_id'], ['1', '3'])): ?>
                                        <?php if ($dt->status_pembayaran == '0'): ?>
                                            <a href="<?= base_url($controller . "/bayar/" . encrypt_url($dt->nospk)) ?>" class="btn btn-primary" title="Bayar">
                                                <i class="fa fa-money-bill-wave"></i> Bayar
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= base_url($controller . "/cetak_invoice_ulang/" . $dt->nospk) ?>" class="btn btn-dark" title="Cetak Ulang Invoice">
                                                <i class="fa fa-print"></i> Invoice
                                            </a>
                                            <a href="https://api.whatsapp.com/send?phone=<?= $dt->konsumen_nohp ?>&text=<?= $message_wa ?>" target="_blank" class="btn btn-success" title="Kirim WhatsApp">
                                                <i class="fab fa-whatsapp"></i> WA
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Transaksi Table-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
