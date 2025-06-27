<br>
<br>
<div class="container py-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xs-6 row-cols-lg-3 g-3">         
        <?php foreach ($karyawan as $p): ?>
            <div class="card mb-3 shadow-sm">
                <div class="row g-0">
                    <div class="col-4 d-flex align-items-center">
                    <img 
                        src="<?= base_url('assets/images/product/' . $p->foto) ?>" 
                        class="img-fluid rounded-start img-thumbnail img-responsive" 
                        alt="<?= htmlspecialchars($p->foto) ?>">
                    </div>
                    <div class="col-8">
                    <div class="card-body py-2 px-3">
                        <h6 class="card-title mb-1"><?= htmlspecialchars($p->nama_lengkap) ?></h6>
                        <p class="card-text mb-1 text-muted" style="font-size: 13px;">
                        Email: <?= htmlspecialchars($p->email) ?>
                        </p>
                        <div class="text-end">
                        <a href="<?= base_url('mobile/produk_detail/' . $p->product_id) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-info-circle"></i> Detail
                        </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>