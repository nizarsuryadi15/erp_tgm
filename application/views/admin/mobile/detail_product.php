    <br>
    <div class="profile-card">
    <h6 class="text-success mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>
        Detail Produk <?= htmlspecialchars($getProduct['product_nama']) ?>
    </h6>

    <!-- Desktop / Tablet View -->
    <div class="table-wrapper-desktop d-none d-sm-block table-responsive">
        <table class="table table-sm table-bordered mb-0">
        <thead class="table-light">
            <tr>
                <th>Detail Produk</th>
                <th>Range</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($getHarga as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p->detail_product) ?></td>
                <td><?= $p->range_text ?></td>
                <td class="text-end">Rp. <?= number_format($p->harga_1) ?></td>
                <td class="text-end"><?= $p->satuan_nama ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>

    <!-- Mobile View -->
    <div class="d-block d-sm-none">
        <?php foreach ($getHarga as $p): ?>
        <div class="card shadow-sm mb-2">
            <div class="card-body p-2">
            <p class="mb-1"><strong><?= htmlspecialchars($p->detail_product) ?></strong></p>
            <p class="mb-1">Range: <?= $p->range_text ?></p>
            <p class="mb-0">Harga: <strong>Rp. <?= number_format($p->harga_1) ?> / <?= $p->satuan_nama ?></strong></p>
            
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
