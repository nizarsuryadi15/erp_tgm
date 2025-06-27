    <br>
    <div class="profile-card">
    <h6 class="text-success mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>
       Daftar Product Terlaris Bulan <?= date('M Y')?>
    </h6>

    <!-- Desktop / Tablet View -->
    <div class="table-wrapper-desktop d-none d-sm-block table-responsive">
        <table class="table table-sm table-bordered mb-0">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah Penjualan</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($analisis as $p): ?>
            <tr>
                <td><?= $no ?></td>
                <td ><?= htmlspecialchars($p->product_nama) ?></td>
                <td class="text-end"><?= $p->total_qty ?></td>
                
                <td class="text-end"><?= $p->satuan_nama ?></td>
            </tr>
            <?php 
                $no++;
                endforeach; 
            ?>
        </tbody>
        </table>
    </div>

    <!-- Mobile View -->
    <div class="d-block d-sm-none">
        <?php foreach ($analisis as $p): ?>
        <div class="card shadow-sm mb-2">
            <div class="card-body p-2">
            <p class="mb-1"><strong><?= htmlspecialchars($p->product_nama) ?></strong></p>
            <p class="mb-1">Jumlah Penjualan: <?= $p->total_qty ?> <?= $p->satuan_nama ?></p>
        
            
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
