<div class="container py-4">
    <!-- Header Profile -->
    <div class="container py-4">
    <!-- Header Profile -->
     <div class="text-center mb-4">
      <!-- <img src="https://i.imgur.com/nG6r8Xg.jpg" alt="Foto Profil" class="profile-img"> -->
      <h5 class="mt-3 mb-0"><?= $karyawan_terpilih['nama_lengkap']?></h5>
      <small class="text-muted"><?= $karyawan_terpilih['email']?></small>
      <br>
      <span class="badge bg-success mt-1">Operator - Customer Service</span>
    </div>

    <!-- Profile Info -->
    <div class="profile-card">
      <h6 class="text-success"><i class="bi bi-person-badge-fill me-2 text-center"></i>Informasi Karyawan</h6>
      
        <div class="container my-6">
            <form class="form-horizontal" method="post" action="<?= base_url('mobile/aksi_edit_profile')?>">
            
                <fieldset>
                    <div class="form-group">
                        <small class="text-muted">Nama Lengkap</small>
                        <div class="col-md-8">
                            <input type="hidden" class="form-control" name = "karyawan_id" id="profileFirstName" value="<?= $profile['karyawan_id']?>">
                            <input type="text" class="form-control" name = "nama_lengkap" id="profileFirstName" value="<?= $profile['nama_lengkap']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-muted">Jenis Kelamin</small>
                        <div class="col-md-8">
                            <select name="jenis_kelamin" class="form-control">
                                <option value="L" <?= $profile['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $profile['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-muted">Tempat Lahir</small>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="tempat_lahir" id="profileLastName" value="<?= $profile['tempat_lahir']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-muted">Tanggal Lahir</small>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="tanggal_lahir" id="profileAddress" value="<?= $profile['tanggal_lahir']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-muted">No WA Aktif</small>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="telepon" id="profileAddress" value="<?= $profile['telepon']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-muted">Alamat Email</small>
                        <div class="col-md-8">
                            <input type="email" class="form-control" name="email" id="profileAddress" value="<?= $profile['email']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-muted">Alamat Rumah</small>
                        <div class="col-md-8">
                            <textarea name="alamat" id="" class="form-control"><?= $profile['alamat']?></textarea>
                        </div>
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
                </div>
            </form>
        
        </div>
    </div>
</div>
