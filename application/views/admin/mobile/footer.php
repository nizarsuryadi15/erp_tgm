<div style="height: 60px;"></div>

<div class="bottom-nav">
  <a href="<?= base_url('mobile')?>">
    <i class="bi bi-house-door-fill"></i>
    Beranda
  </a>
  <a href="<?= base_url('mobile/reset_pass')?>">
    <i class="bi bi-gear"></i>
    Pengaturan
  </a>
  
  <a href="">
    <i class="bi bi-plus-circle"></i>
  </a>
  
  <a href="<?= base_url('mobile/profile/')?>">
    <i class="bi bi-person-circle"></i>
    Profil
  </a>
  <a href="<?= base_url('auth/logout') ?>" id="btnLogout">
    <i class="bi bi-box-arrow-right"></i>
    Logout
  </a>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  document.getElementById('btnLogout').addEventListener('click', function (e) {
    e.preventDefault(); // Hindari langsung logout

    Swal.fire({
      title: 'Logout?',
      text: "Anda yakin ingin keluar dari sistem?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = this.getAttribute('href'); // Redirect ke logout
      }
    });
  });
</script>


</body>
</html>