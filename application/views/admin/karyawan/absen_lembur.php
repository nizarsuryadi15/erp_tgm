<div class="row p-4">
    <div class="card">
      <div class="card-body">
                <table id="datatable-details" class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                        <th>Waktu Pengajuan</th>
                        <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($karyawan as $row): ?>
                        <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->nama_lengkap ?></td>
                        <td><?= date_indo($row->tanggal) ?></td>
                        <td><?= $row->jam_mulai ?> - <?= $row->jam_selesai ?></td>
                        <td><?= $row->kegiatan ?></td>
                        <td>
                          <span class="badge badge-<?= $row->status == 'disetujui' ? 'success' : ($row->status == 'ditolak' ? 'danger' : 'warning') ?>">
                          <?= ucfirst($row->status) ?></span>
                        </td>
                        <td><?= $row->created_at ?></td>
                        <td>
                            <form class="form-approve" data-id="<?= $row->id ?>">
                              <select name="status" class="form-control form-control-sm status-select" required>
                                  <option value="">-- Pilih --</option>
                                  <option value="disetujui" <?= $row->status == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                  <option value="ditolak" <?= $row->status == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                              </select>
                              <button type="button" class="btn btn-sm btn-primary mt-1 btn-approve">Simpan</button>
                          </form>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        
        <!-- end: page -->
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambahLembur" tabindex="-1" role="dialog" aria-labelledby="modalLabelLembur" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('karyawan/aksi_simpan_lembur') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelLembur">Tambah Data Lembur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
          <div class="form-group">
            <label>Karyawan</label>
            <select name="karyawan_id" class="form-control" required>
              <option value="">-- Pilih Karyawan --</option>
              <?php foreach($listkaryawan as $row): ?>
              <option value="<?= $row->karyawan_id ?>"><?= $row->nama_lengkap ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Kegiatan</label>
            <textarea name="kegiatan" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label>Honor (Opsional)</label>
            <input type="number" name="honor" class="form-control" step="0.01">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-approve').click(function() {
        var form = $(this).closest('.form-approve');
        var id = form.data('id');
        var status = form.find('.status-select').val();

        if (!status) {
            alert("Silakan pilih status terlebih dahulu.");
            return;
        }

        if (confirm("Yakin ubah status lembur menjadi '" + status + "'?")) {
            $.ajax({
                url: '<?= base_url('karyawan/update_status_ajax') ?>',
                type: 'POST',
                data: { id: id, status: status },
                success: function(response) {
                    alert("Status berhasil diperbarui.");
                    // Optional: ubah label status di kolom jika ingin real-time update UI
                    // location.reload(); // Jika ingin refresh total
                },
                error: function() {
                    alert("Gagal memperbarui status.");
                }
            });
        }
    });
});
</script>

