<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                    <i class="fa fa-plus"></i> Tambah Supplier
                </a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped" id="datatable-details">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($tampilData as $dt): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $dt->supplier_kode ?></td>
                            <td><?= $dt->supplier_nama ?></td>
                            <td><?= $dt->supplier_alamat ?></td>
                            <td><?= $dt->supplier_nohp ?></td>
                            <td><?= $dt->supplier_email ?></td>
                            <td class="text-center">
                                <a href="<?= base_url($controller . '/updatesupplier/' . $dt->supplier_id) ?>" class="btn btn-sm btn-dark">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('pembelian/delete/'.$dt->supplier_id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus supplier ini?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Supplier -->
<div class="modal fade" id="modalSupplier" tabindex="-1" aria-labelledby="modalSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= base_url($controller . '/actionAddSupplier') ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSupplierLabel">Tambah Supplier Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="supplier_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="supplier_nohp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="supplier_alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="supplier_email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
