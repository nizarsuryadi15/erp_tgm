<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
          
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= $title ?></h4>
                    <div>
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
                            <i class="bi bi-plus-circle"></i> Tambah <?= $title ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0" id="datatable-details">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th width="40%">Keterangan</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Stok <br>Awal Bulan</th>
                                <th width="10%">Stok <br>Tambah</th>
                                <th width="10%">Kirim Ke <br>Gudang Jasa</th>
                                <th width="10%">Stok <br>Aktif</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($tampilData as $dt):
                                $status        = ($dt->status == '1') ? 'Aktif' : 'Tidak Aktif';
                                $stokaktif     = (@$dt->stok_awal + @$dt->stok_tambah) - @$dt->stok_kurang;
                                $stokturunan   = $stokaktif * @$dt->satuan_turunan;
                                $stokminBadge  = ($stokaktif < $dt->stok_min)
                                    ? '<span class="badge bg-danger">Stok Min</span>'
                                    : '<span class="badge bg-success">Stok Max</span>';
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($dt->bahan_nama) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($dt->satuan_nama) ?></td>
                                <td class="text-end text-success fw-bold"><?= number_format($dt->stok_awal) ?></td>
                                <td class="text-end">
                                    <a href="<?= base_url('gudang/getTambahan/' . $dt->bahan_id) ?>" class="text-decoration-none">
                                        <?= number_format($dt->stok_tambah) ?>
                                    </a>
                                </td>
                                <td class="text-end">
                                    <a href="<?= base_url('gudang/getPengurangan/' . $dt->bahan_id) ?>" class="text-decoration-none">
                                        <?= number_format($dt->stok_kurang) ?>
                                    </a>
                                </td>
                                <td class="text-end">
                                    <?php if ($stokaktif > 0): ?>
                                        <span class="text-success fw-bold"><?= number_format($stokaktif) ?></span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold"><?= number_format($stokaktif) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ((date('d') > 28) && (date('d') <= 31)): ?>
                                        <form action="<?= base_url($controller . '/reloadstok/') ?>" method="post" class="d-grid gap-2">
                                            <input type="hidden" name="stok_id" value="<?= $dt->stok_id ?>">
                                            <input type="hidden" name="stok_awal" value="<?= $dt->stok_awal ?>">
                                            <input type="hidden" name="stok_tambah" value="<?= $dt->stok_tambah ?>">
                                            <input type="hidden" name="stok_kurang" value="<?= $dt->stok_kurang ?>">
                                            <input type="hidden" name="stokaktif" value="<?= $stokaktif ?>">
                                            <button type="submit" class="btn btn-primary btn-sm">Reload</button>
                                        </form>
                                    <?php endif; ?>
                                    <?= $stokminBadge ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <hr>

                    <div>
                        <h6>Keterangan:</h6>
                        <ul class="mb-0">
                            <li><strong>Stok Awal</strong>: Stok awal bulan</li>
                            <li><strong>Stok Tambahan</strong>: Stok yang masuk selama bulan berjalan</li>
                            <li><strong>Stok Keluar</strong>: Stok yang dikirim ke gudang jasa selama bulan berjalan</li>
                            <li><strong>Stok Aktif</strong>: Stok tersisa yang masih tersedia</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
