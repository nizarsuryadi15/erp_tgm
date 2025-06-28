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
                       
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0" id="datatable-details">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th width="20%">Barcode</th>
                                <th width="30%">Nama Barang</th>
                               
                                <th width="10%">Stok <br>Awal Bulan</th>
                                <th width="10%">Stok <br>Tambah</th>
                                <th width="10%">Kirim Ke <br>Gudang Jasa</th>
                                <th width="10%">Stok <br>Aktif</th>
                                 <th width="10%">Satuan</th>
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
                                    <img src="<?= base_url('assets/uploads/barcode/'.$dt->barcode.'.png') ?>" alt="<?= $dt->barcode ?>" /><br>
                                    <?= $dt->barcode ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($dt->bahan_nama) ?></strong>
                                </td>
                               
                                <td class="text-end text-success fw-bold"><?= number_format($dt->stok_awal) ?></td>
                                <td class="text-end">
                                   
                                        <?= number_format($dt->stok_tambah) ?>
                                   
                                </td>
                                <td class="text-end">
                                    
                                        <?= number_format($dt->stok_kurang) ?>
                                   
                                </td>
                                <td class="text-end">
                                    <?php if ($stokaktif > 0): ?>
                                        <span class="text-success fw-bold"><?= number_format($stokaktif) ?></span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold"><?= number_format($stokaktif) ?></span>
                                    <?php endif; ?>
                                </td>
                                 <td><?= htmlspecialchars($dt->satuan_nama) ?></td>
                                <td class="text-center">
                                    
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
