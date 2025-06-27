    <div class="container py-4" style="padding-bottom: 80px;">
    <div class="profile-card">
        <h6 class="text-success mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>
        Daftar Piutang Konsumen
        </h6>

        <!-- Tabel Desktop -->
        <div class="table-wrapper-desktop table-responsive">
        <table class="table table-sm table-bordered mb-0">
            <thead class="table-light">
            <tr>
                <th rowspan="2" class="text-center align-middle">Tanggal</th>
                <th colspan="2" class="text-center">Piutang</th>
                <th rowspan="2" class="text-center align-middle">Status</th>
                <th rowspan="2" class="text-center align-middle">Store</th>
            </tr>
            <tr>
                <th class="text-center">Nama Konsumen</th>
                <th class="text-center">Total Piutang</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($piutang as $row): ?>
            <tr class="<?= strtolower($row->piutang_status) === 'belum lunas' ? 'table-warning' : 'table-success' ?>">
                <td class="text-center"><?= date_indo($row->piutang_tgl) ?></td>
                <td><?= htmlspecialchars($row->konsumen_nama) ?></td>
                <td class="text-end">Rp. <?= number_format($row->piutang_sisa) ?></td>
                <td class="text-center">
                <?php if (strtolower($row->piutang_status) === 'belum lunas'): ?>
                    <span class="badge bg-danger">Belum Lunas</span>
                <?php else: ?>
                    <span class="badge bg-success">Lunas</span>
                <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row->nama_perusahaan) ?></td>
            </tr>
            <?php 
                $jumlah = $jumlah+$row->piutang_sisa;
            endforeach; 
            ?>
            <tr>
                <td  colspan="2" class="text-end">Grand Total Piutang</td>
                <td class="text-end"><?= number_format($jumlah)?></td>
            </tr>
            </tbody>
        </table>
        </div>

        <!-- Kartu Mobile -->
        <div class="table-responsive-mobile">
        <?php foreach ($piutang as $row): 
            $isBelumLunas = strtolower($row->piutang_status) === 'belum lunas';
            $cardClass = $isBelumLunas ? 'border-warning bg-light' : 'border-success';
            $badgeClass = $isBelumLunas ? 'bg-danger' : 'bg-success';
            $badgeText = $isBelumLunas ? 'Belum Lunas' : 'Lunas';
        ?>
        <div class="card shadow-sm mb-2 <?= $cardClass ?>">
            <div class="card-body p-2">
            <h6 class="mb-1"><?= htmlspecialchars($row->konsumen_nama) ?></h6>
            <p class="mb-1">Tanggal: <?= date_indo($row->piutang_tgl) ?></p>
            <p class="mb-1">Total Piutang: <strong>Rp. <?= number_format($row->piutang_sisa) ?></strong></p>
            <p class="mb-1">Store: <?= htmlspecialchars($row->nama_perusahaan) ?></p>
            <p class="mb-0">Status: <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span></p>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
    </div>

    <!-- Auto Refresh -->
    <script>
    setInterval(function() {
        location.reload();
    }, 30000); // 30 detik
    </script>
