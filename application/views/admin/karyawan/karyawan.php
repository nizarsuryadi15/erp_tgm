<div class="app-content d-block">
  <div class="container-fluid py-3">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <button class="btn btn-dark">Jumlah Data : <?= $jml ?></button>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahKaryawan">
            Tambah Karyawan <i class="fa fa-user"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped display nowrap" id="datatable-details" style="width:100%">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($karyawan as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row->nama_lengkap ?></td>
                  <td><?= ($row->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' ?></td>
                  <td><?= $row->telepon ?></td>
                  <td><?= $row->email ?></td>
                  <td><?= $row->nama_jabatan ?></td>
                  <td><?= date('d-m-Y', strtotime($row->tanggal_masuk)) ?></td>
                  <td class="actions text-center">
                    <a href="<?= base_url('karyawan/lihat-karyawan/' . $row->karyawan_id) ?>" class="btn btn-success"><i class="bi bi-list"></i></a>
                    <a href="<?= base_url('karyawan/edit-karyawan/' . $row->karyawan_id) ?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="<?= base_url('karyawan/delete-karyawan/' . $row->karyawan_id) ?>" class="btn btn-danger"><i class="bi bi-trash3"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="modalTambahKaryawan" tabindex="-1" role="dialog" aria-labelledby="modalTambahKaryawanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('karyawan/simpan') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahKaryawanLabel">Tambah Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Form Tambah Karyawan -->
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama_lengkap" required>
          </div>

          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip">
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
              <option value="">-- Pilih --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="tempat_lahir">Tempat Lahir</label>
              <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
            </div>
            <div class="form-group col-md-6">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
            </div>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="telepon">No. Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="tanggal_masuk">Tanggal Masuk</label>
              <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk">
            </div>
            <div class="form-group col-md-6">
              <label for="status_karyawan">Status Karyawan</label>
              <select class="form-control" id="status_karyawan" name="status_karyawan">
                <option value="">-- Pilih --</option>
                <option value="Tetap">Tetap</option>
                <option value="Kontrak">Kontrak</option>
                <option value="Magang">Magang</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <select class="form-control" id="jabatan" name="jabatan_id">
              <option value="">-- Pilih Jabatan --</option>
              <!-- Ganti dengan data dari database jika dinamis -->
              <option value="1">Manager</option>
              <option value="2">Staff</option>
              <option value="3">Admin</option>
            </select>
          </div>

          <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- DataTables Init -->
<script>
  $(document).ready(function() {
    $('#datatable-details').DataTable({
      responsive: true,
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        paginate: {
          previous: "Sebelumnya",
          next: "Berikutnya"
        },
        zeroRecords: "Data tidak ditemukan",
      }
    });
  });
</script>
