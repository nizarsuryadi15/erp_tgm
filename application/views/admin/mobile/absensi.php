<div class="header d-flex justify-content-between align-items-center">
    <div>
      <h5>TGMPrint</h5>
      <small>halo@suryaprinting.cc</small><br>
      <small>Operator - Customer Service</small>
    </div>
    <div>
      <img src="https://i.imgur.com/nG6r8Xg.jpg" alt="Profile" class="profile-img">
    </div>
  </div>

  <!-- Tombol Masuk -->
  <div class="text-center mt-4">
  <form id="absenForm" method="post" action="<?= base_url('absensi/hadir') ?>">
    <input type="hidden" name="karyawan_id" value="1">
    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
    <input type="hidden" name="waktu" value="<?= date('H:i:s') ?>">
    <button type="button" class="btn-masuk" onclick="confirmAbsen()">Masuk</button>
  </form>
</div>

<script>
  function confirmAbsen() {
    if (confirm('Yakin ingin melakukan absen masuk sekarang?')) {
      document.getElementById('absenForm').submit();
    }
  }
</script>


  <!-- Info Karyawan -->
  <div class="container">
    <div class="info-box d-flex justify-content-between align-items-center">
      <div><i class="fas fa-user text-danger"></i> <?= $karyawan_terpilih['nama_lengkap'] ?></div>
    </div>
  </div>

  <!-- Menu Grid -->
  <div class="container mb-5">
    <div class="row text-center">

      <div class="col-4">
        <a href="<?= base_url('profile/myprofile') ?>" class="text-decoration-none text-dark">
          <div class="menu-icon">👨‍💼<div>Profile</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-dark">
          <div class="menu-icon">⏱️<div>ERP Sistem</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="/kasbon" class="text-decoration-none text-dark">
          <div class="menu-icon">🏧<div>Slip Gaji</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="/izin" class="text-decoration-none text-dark">
          <div class="menu-icon">🤒<div>Izin/Sakit</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="<?= base_url('mobile/pengajuan_lembur') ?>" class="text-decoration-none text-dark">
          <div class="menu-icon">🔥<div>Lembur</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="/pinjaman" class="text-decoration-none text-dark">
          <div class="menu-icon">📊<div>Pinjaman</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="/checklog" class="text-decoration-none text-dark">
          <div class="menu-icon">🕒<div>Checklog</div></div>
        </a>
      </div>

      <div class="col-4">
        <a href="<?= base_url('auth/logout') ?>" class="text-decoration-none text-dark" onclick="return confirmLogout()">
          <div class="menu-icon">🔓<div>Logout</div></div>
        </a>
      </div>

    </div>
  </div>