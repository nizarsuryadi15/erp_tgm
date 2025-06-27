<div class="container py-4">
    <!-- Header Profile -->
    <div class="container py-4">
    <!-- Header Profile -->
     <div class="text-center mb-4">
      <img src="https://i.imgur.com/nG6r8Xg.jpg" alt="Foto Profil" class="profile-img">
      <h5 class="mt-3 mb-0"><?= $karyawan_terpilih['nama_lengkap']?></h5>
      <small class="text-muted"><?= $karyawan_terpilih['email']?></small>
      <br>
      <span class="badge bg-success mt-1">Operator - Customer Service</span>
    </div>

    <!-- Profile Info -->
    <div class="profile-card">
      <h6 class="text-success"><i class="bi bi-person-badge-fill me-2"></i>Reset Password</h6>
      <hr>
        <div class="container my-6">
            <form class="form-horizontal" method="post" action="<?= base_url('profile/ganti_password')?>">
                    
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileNewPassword">Password Lama</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="profileNewPassword" name="password_lama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileNewPassword">Password Baru</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="profileNewPassword" name="password_baru">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="profileNewPasswordRepeat">Ulangi Password Baru</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="profileNewPasswordRepeat" name="konfirmasi">
                            </div>
                        </div>
                    
                        <hr>
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
