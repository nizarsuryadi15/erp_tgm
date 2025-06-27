<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container py-4">
  <div class="text-center mb-4">
    <img src="<?= base_url('assets/images/'.$logo) ?>" alt="Logo TGM" class="img-fluid" style="max-width: 200px;">
  </div>
  <?php
    $isBelumAbsen = ($hasilcek == '0');
    $jamSekarang  = date('H:i');
    $issuccess    = ($success != '0');
  ?>
    <?php if (!$boleh_absen): ?>
    <!-- Hari Libur atau Di Luar Jam Kerja -->
    <div class="face-box text-center">
      Hari ini adalah <b>hari libur</b> atau di luar jam kerja.<br>
      Anda tidak dapat melakukan presensi.
    </div>

  <?php elseif ($issuccess): ?>
    <!-- Sudah Presensi Masuk & Pulang -->
    <div class="face-box text-center">
      Terima Kasih. Anda sudah presensi:<br>
      Masuk pada Jam: <strong><?= $cekabsen['jam_masuk'] ?></strong><br>
      Pulang pada Jam: <strong><?= $cekabsen['jam_pulang'] ?></strong>
    </div>

  <?php elseif ($isBelumAbsen): ?>
    <!-- Presensi Masuk -->
    <form id="formAbsenMasuk" method="post" action="<?= base_url('absensi/absen_masuk') ?>">
  <input type="hidden" name="karyawan_id" value="<?= $karyawan_terpilih['karyawan_id'] ?>">
  <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
  <input type="hidden" name="jam_masuk" value="<?= date('H:i:s') ?>">

  <button type="button" class="btn-masuk" onclick="konfirmasiAbsenMasuk()">
    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
  </button>
</form>

<script>
  function konfirmasiAbsenMasuk() {
    if (confirm("Yakin ingin melakukan absen masuk sekarang?")) {
      document.getElementById("formAbsenMasuk").submit();
    }
  }
</script>


    <div class="face-box text-center">
      Anda Belum Melakukan Presensi Hari Ini
    </div>

  <?php elseif ($jamSekarang >= '17:00'): ?>
    <!-- Presensi Pulang -->
    <form method="post" action="<?= base_url('absensi/absen_pulang') ?>">
      <input type="hidden" name="karyawan_id" value="<?= $karyawan_terpilih['karyawan_id'] ?>">
      <input type="hidden" name="jam_pulang" value="<?= date('H:i:s') ?>">
      <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
      <button type="submit" class="btn-masuk">
        <i class="bi bi-box-arrow-in-left me-1"></i> Pulang
      </button>
    </form>

  <?php else: ?>
    <!-- Belum Waktu Pulang -->
    <div class="face-box text-center">
      Anda Sudah Presensi Datang Pada Jam : <strong><?= $cekabsen['jam_masuk'] ?></strong><br>
      Presensi Pulang Hanya Bisa Dilakukan Setelah Jam 17:00
    </div>

  <?php endif; ?>

  


  <!-- Menu Grid -->
  <div class="row g-3 text-center mt-4">

    <div class="col-3">
      <a href="<?= base_url('mobile') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-speedometer2 text-primary"></i>
        <small>Home</small>
      </a>
    </div>

    <div class="col-3">
      <a href="<?= base_url('mobile/lembur') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-fire text-danger"></i>
        <small>Lembur</small>
      </a>
    </div>

    <div class="col-3">
      <a href="<?= base_url('mobile/sakit') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-person-dash text-info"></i>
        <small>Izin/Sakit</small>
      </a>
    </div>

    <div class="col-3">
      <a href="<?= base_url('mobile/profile') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-person-fill text-secondary"></i>
        <small>Profile</small>
      </a>
    </div>

    <div class="col-3">
      <a href="<?= base_url('mobile/laporan') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-bar-chart-fill text-warning"></i>
        <small>Laporan</small>
      </a>
    </div>

    <div class="col-3">
      <a href="<?= base_url('mobile/product')?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-briefcase-fill text-info"></i>
        <small>Product</small>
      </a>
    </div>

    <div class="col-3">
      <a href="#" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-moon-fill text-dark"></i>
        <small>Cuti</small>
      </a>
    </div>
    <div class="col-3">
      <a href="<?= base_url('mobile/kinerja') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-award text-success" ></i>
        <small>Kinerja</small>
      </a>
    </div>
    <div class="col-6">
      <a href="<?= base_url('dashboard') ?>" 
        id="btnErp"
        class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-box-arrow-up text-success"></i>
        <small>ERP Sistem</small>
      </a>

    </div>
    <?php 
      if ($this->session->userdata('level')=='17'){
    ?>
    <div class="col-6">
      <a href="<?= base_url('mobile/owner') ?>" class="btn btn-light w-100 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center rounded">
        <i class="bi bi-cash text-warning"></i>
        <small>Dashboard Owner</small>
      </a>
    </div>
    <?php 
      }
    ?>
  </div>
</div>

<script>
  document.getElementById('btnErp').addEventListener('click', function(e) {
    e.preventDefault(); // Mencegah langsung redirect

    Swal.fire({
      title: 'Masuk ERP Sistem?',
      text: "Yakin ingin masuk ke sistem ERP?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, lanjut!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = this.getAttribute('href'); // Redirect manual
      }
    });
  });
</script>



