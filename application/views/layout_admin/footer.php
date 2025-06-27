<!-- begin::Bottom Navigation (Mobile Only) -->
<style>
  .bottom-nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    background: #ffffff;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-around;
    padding: 0.5rem 0;
    z-index: 1030;
    border-top: 1px solid #e0e0e0;
  }

  .bottom-nav a {
    text-align: center;
    flex: 1;
    color: #666;
    font-size: 0.8rem;
    text-decoration: none;
  }

  .bottom-nav a.active,
  .bottom-nav a:hover {
    color: #0d6efd;
  }

  .bottom-nav i {
    display: block;
    font-size: 1.4rem;
  }

  @media (min-width: 768px) {
    .bottom-nav {
      display: none;
    }
  }
</style>

<div class="bottom-nav d-md-none">
  <a href="<?= base_url('dashboard') ?>" class="active">
    <i class="bi bi-house-door-fill"></i>
    Beranda
  </a>
  <a href="<?= base_url('mobile/reset_pass') ?>">
    <i class="bi bi-gear"></i>
    Pengaturan
  </a>
  <a href="#">
    <i class="bi bi-plus-circle-fill text-primary"></i>
  </a>
  <a href="<?= base_url('mobile/profile') ?>">
    <i class="bi bi-person-circle"></i>
    Profil
  </a>
  <a href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
    <i class="bi bi-box-arrow-right"></i>
    Logout
  </a>
</div>
<!-- end::Bottom Navigation -->

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="<?= base_url('assets/js/adminlte.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QVWp6rMezMHFh5tkeKNyZ7jjNcbCH7SYryStEdcMoI+vvbc9RmWJjsZEDv7iDNnc" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="<?= base_url('assets/select2/js/select2.js') ?>"></script>

<!-- OverlayScrollbars Init -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebarWrapper = document.querySelector('.sidebar-wrapper');
    if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
      OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
        scrollbars: {
          theme: 'os-theme-light',
          autoHide: 'leave',
          clickScroll: true
        }
      });
    }
  });
</script>

<!-- DataTables Init -->
<script>
  $(document).ready(function () {
    $('#datatable-details').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: ['copy', 'excel', 'pdf', 'print'],
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Berikutnya",
          previous: "Sebelumnya"
        }
      }
    });
  });
</script>
