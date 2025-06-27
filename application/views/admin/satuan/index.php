<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Satuan</h4>
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">
            <i class="bi bi-arrow-left"></i> Kembali
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSatuan">
            <i class="bi bi-plus-circle"></i> Tambah Satuan
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Satuan</th>
                    <th>Turunan</th>
                    <th>Deskripsi</th>
                    <th width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no =1;
                ?>
                <?php foreach ($satuan as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $s->satuan_nama ?></td>
                        <td class="text-center"><?= $s->satuan_turunan ?></td>
                        <td><?= $s->satuan_deskripsi ?></td>
                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSatuan<?= $s->satuan_id ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Tombol Hapus -->
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm btn-delete"
    data-url="<?= base_url('satuan/delete/' . $s->satuan_id) ?>">
    <i class="bi bi-trash"></i>
</a>
                        </td>
                    </tr>

                    <!-- Modal Edit (di dalam loop) -->
                    <div class="modal fade" id="editSatuan<?= $s->satuan_id ?>" tabindex="-1" aria-labelledby="editSatuanLabel<?= $s->satuan_id ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?= base_url('satuan/update') ?>" method="post" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Satuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="satuan_id" value="<?= $s->satuan_id ?>">

                            <div class="mb-3">
                                <label class="form-label">Nama Satuan</label>
                                <input type="text" name="satuan_nama" class="form-control" value="<?= $s->satuan_nama ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Satuan Turunan</label>
                                <input type="number" name="satuan_turunan" class="form-control" value="<?= $s->satuan_turunan ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="satuan_deskripsi" class="form-control" rows="3"><?= $s->satuan_deskripsi ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                        </form>
                    </div>
                    </div>
                    <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahSatuan" tabindex="-1" aria-labelledby="modalTambahSatuanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('satuan/simpan') ?>" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Satuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="satuan_nama" class="form-label">Nama Satuan</label>
            <input type="text" name="satuan_nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="satuan_turunan" class="form-label">Satuan Turunan</label>
            <input type="number" name="satuan_turunan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="satuan_deskripsi" class="form-label">Deskripsi</label>
            <textarea name="satuan_deskripsi" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>



