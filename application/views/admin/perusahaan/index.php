<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Email</th>
                                <th>Logo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($tampilData as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $row->nama_perusahaan ?></td>
                                <td><?= $row->alamat_perusahaan ?></td>
                                <td><?= $row->no_wa ?></td>
                                <td><?= $row->email ?></td>
                                <td><img src="<?= base_url('assets/images/'.$row->logo) ?>" width="60"></td>
                                <td class="text-center">
                                    <!-- Tombol Modal -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row->id_perusahaan ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php foreach($tampilData as $row): ?>
<div class="modal fade" id="editModal<?= $row->id_perusahaan ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row->id_perusahaan ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="<?= base_url('Perusahaan/update') ?>" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_perusahaan" value="<?= $row->id_perusahaan ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" class="form-control" value="<?= $row->nama_perusahaan ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No Telp / WA</label>
                        <input type="text" name="no_wa" class="form-control" value="<?= $row->no_wa ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $row->email ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Website</label>
                        <input type="text" name="website" class="form-control" value="<?= $row->website ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat_perusahaan" class="form-control"><?= $row->alamat_perusahaan ?></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label>Logo (biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="logo" class="form-control">
                        <small class="text-muted">Logo saat ini: <?= $row->logo ?></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach ?>
