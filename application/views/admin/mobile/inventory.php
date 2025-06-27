    <br>
    <div class="profile-card">
    <h6 class="text-success mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>
        Inventory / Gudang
    </h6>

    <!-- Tabel untuk Desktop/Tablet -->
    <div class="table-wrapper-desktop table-responsive">
        <table class="table table-sm table-bordered mb-0">
        <thead class="table-light">
            <tr>
            <th>Nama Bahan</th>
            <th class="text-end">Jumlah Stok</th>
            <th class="text-end">Satuan</th>
            <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tampildata as $p): 
                $stok     = ($p->stok_awal + $p->stok_tambah) - $p->stok_kurang;
                $stok_min = $p->stok_min;
                $is_low   = $stok < $stok_min;
            ?>
            <tr class="<?= $is_low ? 'table-warning' : '' ?>">
            <td><?= htmlspecialchars($p->bahan_nama) ?></td>
            <td class="text-end"><?= number_format($stok) ?></td>
            <td class="text-end"><?= $p->satuan_nama ?></td>
            <td class="text-center">
                <?php if ($is_low): ?>
                <span class="badge bg-danger">Stok Menipis</span>
                <?php else: ?>
                <span class="badge bg-success">Aman</span>
                <?php endif; ?>
            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>

    <!-- Tampilan Kartu untuk Mobile -->
    <div class="table-responsive-mobile">
        <?php foreach ($tampildata as $p): 
            $stok     = ($p->stok_awal + $p->stok_tambah) - $p->stok_kurang;
            $stok_min = $p->stok_min;
            $is_low   = $stok < $stok_min;
        ?>
        <div class="card shadow-sm mb-2 <?= $is_low ? 'border-warning bg-light' : '' ?>">
        <div class="card-body p-2">
            <h6 class="mb-1"><?= htmlspecialchars($p->bahan_nama) ?></h6>
            <p class="mb-1">Jumlah Stok: <strong><?= number_format($stok) ?></strong></p>
            <p class="mb-1">Satuan: <?= $p->satuan_nama ?></p>
            <p class="mb-0">
            Status:
            <?php if ($is_low): ?>
                <span class="badge bg-danger">Stok Menipis</span>
            <?php else: ?>
                <span class="badge bg-success">Aman</span>
            <?php endif; ?>
            </p>
        </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
