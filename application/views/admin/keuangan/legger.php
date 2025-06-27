<div class="row p-4">

    <div class="card">
        <div class="card-header">
            Legger Bulan <?= $bulan ?>
        </div>
        <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="mulai" class="form-label">Tanggal Awal</label>
                            <input type="date" id="mulai" name="mulai" class="form-control" required value="<?= $mulai ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="selesai" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="selesai" name="selesai" class="form-control" required value="<?= $selesai ?>">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Set</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" id="datatable-detail">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">Penjualan Tanggal</th>
                            <th colspan="5" class="text-center">Metode</th>
                            <th rowspan="2" class="text-center align-middle">Jumlah</th>
                        </tr>
                        <tr>
                            <th class="text-center">Cash</th>
                            <th class="text-center">Transfer</th>
                            <th class="text-center">EDC</th>
                            <th class="text-center">E-Wallet</th>
                            <th class="text-center">Piutang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($legger as $row): ?>
                            <tr>
                                <td><?= date_indo($row->pembayaran_tgl) ?></td>
                                <td class="text-end">Rp. <?= number_format($row->total_cash, 0, ',', '.') ?></td>
                                <td class="text-end">Rp. <?= number_format($row->total_transfer, 0, ',', '.') ?></td>
                                <td class="text-end">Rp. <?= number_format($row->total_edc, 0, ',', '.') ?></td>
                                <td class="text-end">Rp. <?= number_format($row->total_ewallet, 0, ',', '.') ?></td>
                                <td class="text-end">Rp. <?= number_format($row->total_piutang, 0, ',', '.') ?></td>
                                <td class="text-end"><strong><?= number_format($row->total_harian, 0, ',', '.') ?></strong></td>
                            </tr>
                            <?php 
                                $cash           =   $cash+$row->total_cash;
                                $transfer       =   $transfer+$row->total_transfer;
                                $edc            =   $edc+$row->total_edc;
                                $ewallet        =   $ewallet+$row->total_ewallet;
                                $piutang        =   $piutang+$row->total_piutang;
                                $grabndtotal    =   $cash + $transfer + $edc + $ewallet + $piutang;
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-end">Total</th>
                            <th class="text-end">Rp. <?= number_format($cash, 0, ',', '.') ?></th>
                            <th class="text-end">Rp. <?= number_format($transfer, 0, ',', '.') ?></th>
                            <th class="text-end">Rp. <?= number_format($edc, 0, ',', '.') ?></th>
                            <th class="text-end">Rp. <?= number_format($ewallet, 0, ',', '.') ?></th>
                            <th class="text-end">Rp. <?= number_format($piutang, 0, ',', '.') ?></th>
                            <th class="text-end">Rp. <?= number_format($grabndtotal, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>