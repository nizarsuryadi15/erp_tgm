<div class="row p-4">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <!-- Optional button action -->
                    <!--
                    <a class="btn btn-primary me-2" href="<?= base_url('transaksi/add/1/1'); ?>">Tambah Transaksi <?= $controller ?></a>
                    <a href="<?= base_url($controller.'/formAdd')?>" class="btn btn-success">Cetak <?= $controller ?> <i class="fa fa-print"></i></a>
                    -->
                </div>
            </div>

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
                            <th>Action</th>
                            <th class="d-none"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($transaksi_belumbayar as $dt):
                            $status_pembayaran = $dt->status_pembayaran == '0' 
                                ? "<p class='text-danger'> Belum Bayar</p>" 
                                : "<p class='text-success'> Sudah Bayar</p>";

                            $tombolspk = $dt->status_pembayaran == '0'
                                ? "<a class='btn btn-primary w-100' href='".base_url('transaksi/createspk/'.$dt->nospk)."'>$dt->nospk</a>"
                                : "<a class='btn btn-dark w-100' href='#' disabled>$dt->nospk</a>";

                            $total_bayar  = $dt->bayar_tunai + $dt->bayar_debit + $dt->bayar_kartukredit + $dt->bayar_transfer + $dt->bayar_ewallet;
                            $kurang_bayar = $dt->grand_total - $total_bayar;
                            $qdetail      = $this->M_transaksi->getDetailPesan($dt->nospk)->result();
                            $item         = count($qdetail);

                            if ($dt->status == '1')
                            {
                                $tr = 'table-danger';
                            }else if ($dt->status == '2')
                            {
                                $tr = 'table-warning';
                            }else if ($dt->status == '3')
                            {
                                $tr = 'table-success';
                            }else if ($dt->status == '4')
                            {
                                $tr = 'table-info';
                            }else if ($dt->status == '5')
                            {
                                $tr = 'table-secondary';
                            }else if ($dt->status == '6')
                            {
                                $tr = 'table-dark';
                            }else{
                                $tr = '';
                            }
                            
                        ?>
                        <tr class="<?= isset($tr) ? $tr : '' ?>">
                            <td>
                                <?= $dt->nospk ?>
                            </td>
                            <td>
                                <?= date_indo($dt->tgl_pemesanan) ?><br>
                                <small><?= date_indo($dt->jam_pemesanan) ?></small>
                            </td>
                            <td>
                                Nama: <?= $dt->konsumen_nama ?><br>
                                WA: <?= $dt->konsumen_nohp ?>
                            </td>
                            <td class="text-center">
                                <p class="mb-0"><?= $dt->nama_jenis_transaksi ?></p>
                                <small><?= $dt->marketplace_nama ?></small>
                            </td>
                            <td class="text-center"><?= $item ?></td>
                            <td class="text-end"><?= number_format($dt->jml_pemesanan) ?></td>
                            <td class="text-center"><?= $status_pembayaran ?></td>
                            <td class="text-end"><?= number_format($total_bayar) ?></td>
                            <td class="text-end"><?= number_format($kurang_bayar) ?></td>
                            <td><?= $dt->nama_lengkap ?></td>
                            <td class="text-center">
                                <?php 
                                if (($level['role_id'] == '3') || ($level['role_id'] == '1')):
                                    if ($dt->status_pembayaran == '0'):
                                ?>
                                    <a href="<?= base_url($controller."/bayar/".encrypt_url($dt->nospk)) ?>" class="btn btn-primary mb-1">
                                        <i class="fas fa-money-bill"></i> 
                                    </a>
                                <?php 
                                    else:
                                        $message_wa = '-TGMPrint- %20Haii%20'.$dt->konsumen_nama.'%20Terima%20Kasih%20Sudah%20Berbelanja%20di%20TGMPrint%20Rp.%20'.number_format($dt->jml_pemesanan).'%20Dengan%20Nomor%20SPK%20:'.$dt->nospk.'%20Untuk%20Cek%20Progress%20Pekerjaan%20Anda,%20Silahkan%20Cek%20Link%20dibawah%20ini%20:%20https://erp.tgmprint.com/cekpesanan/spk/'.$dt->nospk;
                                ?>
                                    <a href="<?= base_url($controller."/cetak_invoice_ulang/".$dt->nospk) ?>" class="btn btn-dark mb-1">
                                        <i class="fas fa-print"></i>  
                                    </a>
                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?= $dt->konsumen_nohp ?>&text=<?= $message_wa ?>" class="btn btn-success">
                                        <i class="fab fa-whatsapp"></i> 
                                    </a>
                                <?php 
                                    endif;
                                endif;
                                ?>
                            </td>
                            <td class="d-none">
                                <table class="table table-bordered mb-0">
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
                                        foreach ($qdetail as $dtl):
                                            $harga = $dtl->harga_aktif == '1' ? $dtl->harga_1 : ($dtl->harga_aktif == '2' ? $dtl->harga_2 : $dtl->harga_3);
                                            $jumlah = $harga * $dtl->qty;
                                        ?>
                                        <tr>
                                            <td><?= $nomor++ ?></td>
                                            <td><?= $dtl->product_nama ?></td>
                                            <td><?= $dtl->qty ?></td>
                                            <td class="text-end"><?= number_format($harga) ?></td>
                                            <td class="text-end"><?= number_format($jumlah) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <?php 
                        $no++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
