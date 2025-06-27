<div class="app-content">
    <div class="container-fluid pb-5">

        <!-- PEMASUKAN BULANAN -->
        <h6 class="text-start text-dark text-uppercase my-4">Pemasukan Bulan <?= date_indo(date('Y-m')) ?></h6>
        <div class="row g-4">
            <?php
            $pemasukanBulanan = [
                ['title' => 'Total Transaksi Bulanan', 'icon' => 'bi-database', 'total' => $grandtotal['total'], 'url' => 'keuangan/transaksi_bulanan', 'desc' => 'Seluruh Transaksi Termasuk Piutang'],
                ['title' => 'Total Piutang Bulanan', 'icon' => 'bi-credit-card', 'total' => $total_piutang['total'], 'url' => 'keuangan/piutang', 'desc' => 'Seluruh Piutang'],
                ['title' => 'Transaksi Cash', 'icon' => 'bi-cash', 'total' => $total_cash['total'], 'url' => 'keuangan/transaksi_cash_bulanan', 'desc' => 'Transaksi + Bayar Piutang'],
                ['title' => 'Transaksi Transfer', 'icon' => 'bi-bank', 'total' => $total_transfer['total'], 'url' => 'keuangan/transaksi_transfer_bulanan', 'desc' => 'Transaksi + Bayar Piutang'],
                ['title' => 'Transaksi EDC / Debit', 'icon' => 'bi-credit-card-2-front', 'total' => $total_edc['total'], 'url' => 'keuangan/transaksi_edc_bulanan', 'desc' => 'Transaksi + Bayar Piutang'],
                ['title' => 'Transaksi E-Wallet', 'icon' => 'bi-wallet2', 'total' => $total_ewallet['total'], 'url' => 'keuangan/transaksi_ewallet_bulanan', 'desc' => 'Transaksi + Bayar Piutang'],
            ];

            foreach ($pemasukanBulanan as $item): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card bg-dark text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi <?= $item['icon'] ?> fs-2 me-3"></i>
                            <div>
                                <h5><?= $item['title'] ?></h5>
                                <p class="mb-1">Rp. <?= number_format($item['total']) ?>,-</p>
                                <a href="<?= base_url($item['url']) ?>" class="text-white text-decoration-none"><?= $item['desc'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- PEMASUKAN HARIAN -->
        <h6 class="text-start text-dark text-uppercase my-5">Pemasukan Harian <?= date_indo(date('Y-m-d')) ?></h6>
        <div class="row g-4">
            <?php
            $pemasukanHarian = [
                ['title' => 'Total Transaksi Harian', 'icon' => 'bi-database', 'total' => $grandtotalharian['total'], 'url' => 'keuangan/transaksi_harian'],
                ['title' => 'Total Piutang Harian', 'icon' => 'bi-credit-card', 'total' => $total_piutangharian['total'], 'url' => 'keuangan/transaksi_piutang_harian'],
                ['title' => 'Total Cash Harian', 'icon' => 'bi-cash', 'total' => $total_cashharian['total'], 'url' => 'keuangan/transaksi_cash_harian'],
                ['title' => 'Total Transfer Harian', 'icon' => 'bi-bank', 'total' => $total_tf_harian['total'], 'url' => 'keuangan/transaksi_transfer_harian'],
                ['title' => 'Total EDC/Debit Harian', 'icon' => 'bi-credit-card-2-front', 'total' => $total_edc_harian['total'], 'url' => 'keuangan/transaksi_edc_harian'],
                ['title' => 'Total E-Wallet Harian', 'icon' => 'bi-wallet2', 'total' => $total_ewallet_harian['total'], 'url' => 'keuangan/transaksi_ewallet_harian'],
            ];

            foreach ($pemasukanHarian as $item): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card bg-dark text-white h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi <?= $item['icon'] ?> fs-2 me-3"></i>
                            <div>
                                <h5><?= $item['title'] ?></h5>
                                <p class="mb-1">Rp. <?= number_format($item['total']) ?>,-</p>
                                <a href="<?= base_url($item['url']) ?>" class="text-white text-decoration-none">Seluruh Transaksi Termasuk Piutang</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- PENGELUARAN -->
        <h6 class="text-start text-dark text-uppercase my-5">Pengeluaran</h6>
        <div class="row g-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-arrow-down-circle fs-2 me-3"></i>
                        <div>
                            <h5>Total Pengeluaran Harian</h5>
                            <p class="mb-1">Rp. <?= number_format($pengeluaran_harian['total']) ?>,-</p>
                            <a href="<?= base_url('keuangan/pengeluaran_harian') ?>" class="text-white text-decoration-none">Seluruh Pengeluaran</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-arrow-down-circle fs-2 me-3"></i>
                        <div>
                            <h5>Total Pengeluaran Bulanan</h5>
                            <p class="mb-1">Rp. <?= number_format($pengeluaran_bulanan['total']) ?>,-</p>
                            <a href="<?= base_url('keuangan/pengeluaran_bulanan') ?>" class="text-white text-decoration-none">Seluruh Pengeluaran</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- .container-fluid -->
</div> <!-- .app-content -->
