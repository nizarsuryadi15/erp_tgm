<div class="row p-4">
    <div class="card">
        
                <div class="card-body">
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
                                    <th width="10%">Action</th>
                                    <th hidden></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($tampilData as $dt) {
                                    if ($dt->status_pembayaran == '0') {
                                        $status_pembayaran = "<p class='text-danger'>Belum Bayar</p>";
                                        $base_url = base_url('transaksi/createspk/' . $dt->nospk);
                                        $tombolspk = "<a class='btn btn-primary btn-block' href='$base_url'>$dt->nospk</a>";
                                    } else {
                                        $status_pembayaran = "<p class='text-success'>Sudah Bayar</p>";
                                        $tombolspk = "<a class='btn btn-dark btn-block' href='#' disabled>$dt->nospk</a>";
                                    }

                                    $total_bayar = $dt->bayar_tunai + $dt->bayar_debit + $dt->bayar_kartukredit + $dt->bayar_transfer + $dt->bayar_ewallet;
                                    $kurang_bayar = $dt->grand_total - $total_bayar;

                                    $qdetail = $this->M_transaksi->getDetailPesan($dt->nospk)->result();
                                    $item = $this->M_transaksi->getDetailPesan($dt->nospk)->num_rows();
                                ?>
                                    <tr>
                                        <td><?= $tombolspk ?></td>
                                        <td>
                                            <?= date_indo($dt->tgl_pemesanan) ?><br>
                                            <small><?= date_indo($dt->jam_pemesanan) ?></small>
                                        </td>
                                        <td>
                                            Nama: <?= $dt->konsumen_nama ?><br>
                                            WA: <?= $dt->konsumen_nohp ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $dt->nama_jenis_transaksi ?><br>
                                            <?= $dt->marketplace_nama ?>
                                        </td>
                                        <td class="text-center"><?= $item ?></td>

                                        <!-- Hidden detail produk -->
                                        <td hidden>
                                            <table class="table table-bordered">
                                                <thead>
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
                                                    foreach ($qdetail as $dtl) {
                                                        switch ($dtl->harga_aktif) {
                                                            case '1': $harga = $dtl->harga_1; break;
                                                            case '2': $harga = $dtl->harga_2; break;
                                                            case '3': $harga = $dtl->harga_3; break;
                                                            default: $harga = 0;
                                                        }
                                                        $jumlah = $harga * $dtl->qty;
                                                    ?>
                                                        <tr>
                                                            <td><?= $nomor++ ?></td>
                                                            <td><?= $dtl->product_nama ?></td>
                                                            <td><?= $dtl->qty ?></td>
                                                            <td class="text-right"><?= number_format($harga) ?></td>
                                                            <td class="text-right"><?= number_format($jumlah) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>

                                        <td class="text-right"><?= number_format($dt->jml_pemesanan) ?></td>
                                        <td class="text-center"><?= $status_pembayaran ?></td>
                                        <td class="text-right"><?= number_format($total_bayar) ?></td>
                                        <td class="text-right"><?= number_format($kurang_bayar) ?></td>
                                        <td><?= $dt->karyawan_nama ?></td>

                                        <td class="actions text-center">
                                            <?php 
                                            if (in_array($level['role_id'], ['1', '4'])) {
                                                if ($dt->status_pembayaran == '0') {
                                                    $url_bayar = base_url($controller . "/bayar/" . encrypt_url($dt->nospk));
                                                    echo "<a href='$url_bayar' class='btn btn-primary'><i class='bi bi-cash-coin'></i></a>";
                                                } else {
                                                    $message_wa = '-TGMPrint- %20Haii%20' . $dt->konsumen_nama .
                                                        '%20Terima%20Kasih%20Sudah%20Berbelanja%20di%20TGMPrint%20Rp.%20' .
                                                        number_format($dt->jml_pemesanan) .
                                                        '%20Dengan%20Nomor%20SPK%20:' . $dt->nospk .
                                                        '%20Untuk%20Cek%20Progress%20Pekerjaan%20Anda,%20Silahkan%20Cek%20Link%20dibawah%20ini%20:%20https://erp.tgmprint.com/cekpesanan/spk/' . $dt->nospk;

                                                    echo "<a href='" . base_url($controller . "/cetak_invoice_ulang/" . $dt->nospk) . "' class='btn btn-dark'><i class='bi bi-printer-fill'></i></a> &nbsp; "; 
                                                    echo "<a target='_blank' href='https://api.whatsapp.com/send?phone={$dt->konsumen_nohp}&text={$message_wa}' class='btn btn-success'><i class='bi bi-whatsapp'></i></a>";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php $no++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
