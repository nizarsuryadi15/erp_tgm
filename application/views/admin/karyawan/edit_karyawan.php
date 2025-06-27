<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title"><a href="<?= base_url('karyawan/karyawan')?>">Kembali</a> Edit Data Karyawan</h2>
            </header>
            <div class="panel-body text-left">
                <div class="container">
                
                <form action="<?= base_url('karyawan/aksi_edit_karyawan') ?>" method="post">
                    <input type="hidden" name="karyawan_id" value="<?= $karyawan->karyawan_id ?>">
                    <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= $karyawan->nama_lengkap ?>" required>
                    </div>

                    <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nip" class="form-control" value="<?= $karyawan->nik ?>">
                    </div>

                    <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="L" <?= $karyawan->jenis_kelamin == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $karyawan->jenis_kelamin == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                    </div>

                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?= $karyawan->tempat_lahir ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= $karyawan->tanggal_lahir ?>">
                    </div>
                    </div>

                    <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= $karyawan->alamat ?></textarea>
                    </div>

                    <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="<?= $karyawan->telepon ?>">
                    </div>

                    <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $karyawan->email ?>">
                    </div>

                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="<?= $karyawan->tanggal_masuk ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Status Karyawan</label>
                        <select name="status_karyawan" class="form-control">
                        <option value="Tetap" <?= $karyawan->status_karyawan == 'Tetap' ? 'selected' : '' ?>>Tetap</option>
                        <option value="Kontrak" <?= $karyawan->status_karyawan == 'Kontrak' ? 'selected' : '' ?>>Kontrak</option>
                        <option value="Magang" <?= $karyawan->status_karyawan == 'Magang' ? 'selected' : '' ?>>Magang</option>
                        </select>
                    </div>
                    </div>

                    <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan_id" class="form-control">
                        <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j->jabatan_id ?>" <?= $karyawan->jabatan_id == $j->jabatan_id ? 'selected' : '' ?>>
                            <?= $j->nama_jabatan ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label>Foto</label><br>
                        <?php if (!empty($karyawan->foto)) : ?>
                            <img src="<?= base_url('assets/images/karyawan/' . $karyawan->foto) ?>" width="100" class="mb-2">
                        <?php endif; ?>
                        <input type="file" name="foto" class="form-control-file">
                        <small class="form-text text-muted">Format: JPG/PNG. Max: 2MB.</small>
                        </div>

                    <hr>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="<?= base_url('karyawan') ?>" class="btn btn-secondary">Batal</a>
                </form>
                </div>
                
            </div>
        </section>
        </div>
    </div>
</div>