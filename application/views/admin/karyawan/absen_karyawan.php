<div class="row p-4">
    <div class="card">
                <div class="card-body">
                <table id="datatable-details" class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($absensi as $row): ?>
                        <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->nama_lengkap ?></td>
                        <td><?= date_indo($row->tanggal) ?></td>
                        <td><?= $row->jam_masuk ?></td>
                        <td><?= $row->jam_pulang ?></td>
                        <td><?= $row->status ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        
        <!-- end: page -->
      </div>
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


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#modalTambahLembur form");

    form.addEventListener("submit", function (e) {
      const jamMulai = form.querySelector("input[name='jam_mulai']").value;
      const jamSelesai = form.querySelector("input[name='jam_selesai']").value;

      if (jamMulai >= jamSelesai) {
        e.preventDefault(); // Mencegah form terkirim
        alert("Jam selesai harus lebih besar dari jam mulai.");
      }
    });
  });
</script>

