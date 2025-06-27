

<div class="container py-4" style="padding-bottom: 80px;">

    <?php 
    // Pastikan model diload sebelum view
    $this->load->model('M_transaksi');

    $totalstore1 = 0;
    $totalstore2 = 0;
    ?>

    <div class="profile-card">
        <h6 class="text-success mb-3">
            <i class="bi bi-person-badge-fill me-2"></i>
            Transaksi  Bulan <?= date_indo(date('Y-m')) ?>
        </h6>
        <div class="table-wrapper-desktop table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="text-center">Tanggal</th>
                        <th colspan="2" class="text-center">Total Transaksi</th>
                        <th rowspan="2" class="text-center">Jumlah</th>
                    </tr>
                    <tr>
                        <th class="text-center">Store 1</th>
                        <th class="text-center">Store 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalstore1 = 0;
                        $totalstore2 = 0;
                        foreach ($keuangan as $row): 
                            $tgl = $row->pembayaran_tgl;
                            $jml1 = $this->M_transaksi->jmltransaksi($tgl, '1')->row('jumlah') ?? 0;
                            $jml2 = $this->M_transaksi->jmltransaksi($tgl, '2')->row('jumlah') ?? 0;
                            $total = $jml1 + $jml2;
                            $totalstore1 += $jml1;
                            $totalstore2 += $jml2;
                    ?>
                    <tr>
                        <td class="text-center"><?= date_indo($tgl) ?></td>
                        <td class="text-right"><?= number_format($jml1) ?></td>
                        <td class="text-right"><?= number_format($jml2) ?></td>
                        <td class="text-right"><?= number_format($total) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-right"><strong>Total</strong></td>
                        <td class="text-right"><strong><?= number_format($totalstore1) ?></strong></td>
                        <td class="text-right"><strong><?= number_format($totalstore2) ?></strong></td>
                        <td class="text-right"><strong><?= number_format($totalstore1 + $totalstore2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive-mobile">
            <?php
                $totalstore1 = 0;
                $totalstore2 = 0;
                foreach ($keuangan as $row):
                    $tgl = $row->pembayaran_tgl;
                    $jml1 = $this->M_transaksi->jmltransaksi($tgl, '1')->row('jumlah') ?? 0;
                    $jml2 = $this->M_transaksi->jmltransaksi($tgl, '2')->row('jumlah') ?? 0;
                    $total = $jml1 + $jml2;
                    $totalstore1 += $jml1;
                    $totalstore2 += $jml2;
            ?>
            <div class="card shadow-sm mb-2">
                <div class="card-body p-2">
                    <h6 class="mb-1"><?= date_indo($tgl) ?></h6>
                    <p class="mb-1">Store 1: <strong><?= number_format($jml1) ?></strong></p>
                    <p class="mb-1">Store 2: <strong><?= number_format($jml2) ?></strong></p>
                    <p class="mb-0">Total: <strong><?= number_format($total) ?></strong></p>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="card bg-light mt-3">
                <div class="card-body p-2">
                    <h6 class="mb-1">Total Keseluruhan</h6>
                    <p class="mb-1">Store 1: <strong><?= number_format($totalstore1) ?></strong></p>
                    <p class="mb-1">Store 2: <strong><?= number_format($totalstore2) ?></strong></p>
                    <p class="mb-0">Jumlah: <strong><?= number_format($totalstore1 + $totalstore2) ?></strong></p>
                </div>
            </div>
        </div>
    </div>

        <br>
     <div class="profile-card">
        <h6 class="text-success mb-3">
            <i class="bi bi-person-badge-fill me-2"></i>
            Pengeluaran  Bulan <?= date_indo(date('Y-m')) ?>
        </h6>

        <div class="table-wrapper-desktop table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" class="text-center">Tanggal</th>
                        <th colspan="2" class="text-center">Pengeluaran</th>
                        <th rowspan="2" class="text-center">Jumlah</th>
                    </tr>
                    <tr>
                        <th class="text-center">Store 1</th>
                        <th class="text-center">Store 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalstore11 = 0;
                        $totalstore22 = 0;
                        foreach ($pengeluaran as $row): 
                            $tgl          = $row->pengeluaran_tgl;
                            $pengeluaran1 = $this->M_transaksi->jmlpengeluaran($tgl, '1')->row('jumlah') ?? 0;
                            $pengeluaran2 = $this->M_transaksi->jmlpengeluaran($tgl, '2')->row('jumlah') ?? 0;
                            $total        = $pengeluaran1 + $pengeluaran2;
                            $totalstore11 += $pengeluaran1;
                            $totalstore22 += $pengeluaran2;
                    ?>
                    <tr>
                        <td class="text-center"><?= date_indo($tgl) ?></td>
                        <td class="text-end"><?= number_format($pengeluaran1) ?></td>
                        <td class="text-end"><?= number_format($pengeluaran2) ?></td>
                        <td class="text-end"><?= number_format($total) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-end"><strong>Total</strong></td>
                        <td class="text-end"><strong><?= number_format($totalstore11) ?></strong></td>
                        <td class="text-end"><strong><?= number_format($totalstore22) ?></strong></td>
                        <td class="text-end"><strong><?= number_format($totalstore11 + $totalstore22) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive-mobile">
            <?php
                $totalstore11 = 0;
                $totalstore22 = 0;
                foreach ($pengeluaran as $row):
                    $tgl          = $row->pengeluaran_tgl;
                    $pengeluaran1 = $this->M_transaksi->jmlpengeluaran($tgl, '1')->row('jumlah') ?? 0;
                    $pengeluaran2 = $this->M_transaksi->jmlpengeluaran($tgl, '2')->row('jumlah') ?? 0;
                    $total        = $pengeluaran1 + $pengeluaran2;
                    $totalstore11 += $pengeluaran1;
                    $totalstore22 += $pengeluaran2;
            ?>
            <div class="card shadow-sm mb-2">
                <div class="card-body p-2">
                    <h6 class="mb-1"><?= date_indo($tgl) ?></h6>
                    <p class="mb-1">Store 1: <strong><?= number_format($pengeluaran1) ?></strong></p>
                    <p class="mb-1">Store 2: <strong><?= number_format($pengeluaran2) ?></strong></p>
                    <p class="mb-0">Total: <strong><?= number_format($total) ?></strong></p>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Total Keseluruhan -->
            <div class="card bg-light mt-3">
                <div class="card-body p-2">
                    <h6 class="mb-1">Total Keseluruhan</h6>
                    <p class="mb-1">Store 1: <strong><?= number_format($totalstore11) ?></strong></p>
                    <p class="mb-1">Store 2: <strong><?= number_format($totalstore22) ?></strong></p>
                    <p class="mb-0">Jumlah: <strong><?= number_format($totalstore11 + $totalstore22) ?></strong></p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
  // Reload halaman setiap 30 detik (30000 ms)
  setInterval(function() {
    location.reload();
  }, 30000);
</script>
