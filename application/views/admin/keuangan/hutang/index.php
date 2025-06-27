
    <div class="row p-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Total Piutang:</strong> Rp. <?= number_format($total_trx['total_piutang']) ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="datatable-details">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <td hidden></td>
                                <th width="15%">Konsumen</th>
                                <th>Total Piutang</th>
                                <th>Keterangan</th>
                                <th hidden>Detail Transaksi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach ($tampilData as $dt):
                                    $totalPiutang = $this->M_transaksi->totalPiutangKonsumen($dt->konsumen_id)->row_array();
                                    $getPiutang   = $this->M_transaksi->getPiutangKonsumen($dt->konsumen_id)->result();
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td hidden></td>
                                <td>
                                    <?= $dt->konsumen_nama ?> <br>
                                    <?= $dt->konsumen_nohp ?>
                                </td>
                                <td class="text-end">
                                    Rp. <?= number_format($totalPiutang['total']) ?>
                                </td>
                                <td><?= $dt->piutang_status ?></td>
                                <td hidden>
                                    <table class="table table-bordered table-sm">
                                        <?php foreach ($getPiutang as $dt2): ?>
                                        <tr>
                                            <td width="30%">
                                                No SPK: <?= $dt2->nospk ?> <br>
                                                <?= date_indo($dt2->tempo_tgl) ?>
                                            </td>
                                            <td>Total Piutang: <?= number_format($dt2->piutang_total) ?></td>
                                            <td>Total Bayar: <?= number_format($dt2->piutang_bayar) ?></td>
                                            <td>Total Sisa: <?= number_format($dt2->piutang_sisa) ?></td>
                                            <td class="text-center">
                                                <?php if ($dt2->piutang_sisa != 0): ?>
                                                <a href="<?= base_url('keuangan/bayar_piutang/'.$dt2->nospk) ?>" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-credit-card"></i>
                                                </a>
                                                <?php 
                                                    $message_wa = '-TGMPrint- %0AHaii%20'.$dt2->konsumen_nama.'%20Piutang%20Anda%0ARp.%20'.number_format($dt2->piutang_sisa).'%0ANomor%20SPK%20:'.$dt2->nospk.'%0ASudah%20Memasuki%20Jatuh%20Tempo%20Mohon%20Segera%20melakukan%20Pembayaran%0AAbaikan%20Pesan%20ini%20Jika%20Sudah%20Melakukan%20Pembayaran';
                                                    if ($dt2->tempo_tgl > $hariini):
                                                ?>
                                                <a target="_blank" href="https://api.whatsapp.com/send?phone=<?= $dt2->konsumen_nohp ?>&text=<?= $message_wa ?>" class="btn btn-success btn-sm">
                                                    <i class="fa fa-whatsapp"></i>
                                                </a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                                <td>
                                    <a href="<?= base_url($controller.'/detail_piutang/'.$dt->konsumen_id) ?>" class="btn btn-outline-secondary btn-sm">
                                        Detail
                                    </a>
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
