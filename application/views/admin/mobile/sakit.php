<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title text-center mb-3">Pengajuan Izin Sakit</h5>
      <hr>

      <form action="<?= base_url('absensi/izin_absen') ?>" method="post">
        
        <div class="mb-3">
          <label class="form-label">Karyawan</label>
          <select class="form-select" disabled required>
            <?php foreach($listkaryawan as $row): ?>
              <option value="<?= $row->karyawan_id ?>"
                <?= isset($karyawan_terpilih['karyawan_id']) && $karyawan_terpilih['karyawan_id'] == $row->karyawan_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($row->nama_lengkap, ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="karyawan_id" value="<?= $karyawan_terpilih['karyawan_id'] ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
         <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <select name="status" id="status" class="form-control">
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
          </select>
        </div>

        

        <div class="mb-3">
          <label class="form-label">Alasan</label>
          <textarea name="kegiatan" class="form-control" rows="3" placeholder="Tuliskan Alasan tidak masuk kerja .. "></textarea>
        </div>
        <hr>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Simpan
          </button>
          <a href="<?= base_url('mobile') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>
        
      </form>
    </div>
  </div>
</div>
