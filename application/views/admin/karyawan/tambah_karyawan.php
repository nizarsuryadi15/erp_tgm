<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title"><a href="<?= base_url('karyawan')?>">Kembali</a> Tambah Data Karyawan</h2>
            </header>
            <div class="panel-body text-left">
                <div class="container">
              <div class="container">
                
                <form action="simpan_karyawan.php" method="post" enctype="multipart/form-data">
                  
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

                  <div class="form-group text-left">
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
                      <!-- Isi dengan data jabatan dari database -->
                      <option value="1">Manager</option>
                      <option value="2">Staff</option>
                      <option value="3">Admin</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control-file" id="foto" name="foto">
                  </div>
                  <hr>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
</div>
</div>