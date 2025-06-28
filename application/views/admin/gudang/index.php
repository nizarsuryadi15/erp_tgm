
<div class="container-fluid">
  

  <div class="row g-4">
    <div class="col-md-3">
      <div class="card bg-dark text-white">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 fs-3">
            <i class="fa fa-download"></i>
          </div>
          <div>
            <h5 class="card-title mb-1">Bahan Produksi</h5>
            <p class="card-text fw-bold"><?= $total_bahan ?></p>
            <a href="<?= base_url('gudang/bahan') ?>" class="text-white text-uppercase small">View</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-white">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 fs-3">
            <i class="fa fa-print"></i>
          </div>
          <div>
            <h5 class="card-title mb-1">Stok Bahan Produksi </h5>
            <p class="card-text fw-bold"><?= $jml_stok_minim ?></p>
            <a href="<?= base_url('gudang/stok') ?>" class="text-white text-uppercase small">View</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-white">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 fs-3">
            <i class="fa fa-check"></i>
          </div>
          <div>
            <h5 class="card-title mb-1">Data Barang Masuk</h5>
            <p class="card-text fw-bold"><?= $total_masuk ?></p>
            <a href="<?= base_url('gudang/barang-masuk') ?>" class="text-white text-uppercase small">View</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-white">
        <div class="card-body d-flex align-items-center">
          <div class="me-3 fs-3">
            <i class="fa fa-upload"></i>
          </div>
          <div>
            <h5 class="card-title mb-1">Data Barang Keluar</h5>
            <p class="card-text fw-bold"><?= $total_keluar ?></p>
            <a href="<?= base_url('gudang/barang-keluar') ?>" class="text-white text-uppercase small">View</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stok Minim Section -->
  <div class="card mt-5">
    <div class="card-header">
      <h4 class="mb-0">Daftar Stok Minim</h4>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th width="5%">No</th>
            <th width="40%">Keterangan</th>
            <th width="10%">Satuan</th>
            <th width="10%">Stok Aktif</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $no = 1;
            foreach ($stok_minim as $dt) {
                $stokaktif = (@$dt->stok_awal + @$dt->stok_tambah) - @$dt->stok_kurang;
                $stokturunan = $stokaktif * @$dt->satuan_turunan;
                $stokmin = ($stokaktif < $dt->stok_min)
                    ? '<span class="badge bg-danger">Stok Min</span>'
                    : '<span class="badge bg-success">Stok Max</span>';
          ?>
            <tr>
              <td><?= $no ?></td>
              <td class="text-start"><?= $dt->bahan_nama ?></td>
              <td><?= $dt->satuan_nama ?></td>
              <td><?= $stokaktif ?> &nbsp; <?= $stokmin ?></td>
            </tr>
          <?php 
            $no++;
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

