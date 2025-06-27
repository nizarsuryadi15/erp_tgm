<div class="row p-4">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Data Absensi Karyawan</h2>

            <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($absensi) > 0): ?>
                  <?php foreach ($absensi as $i => $row): ?>
                    <tr>
                      <td><?= $i + 1 ?></td>
                      <td><?= $row->nama ?></td>
                      <td><?= $row->tanggal ?></td>
                      <td>
                        <span class="badge badge-<?= 
                          $row->status == 'Hadir' ? 'success' : (
                          $row->status == 'Izin' ? 'info' : (
                          $row->status == 'Sakit' ? 'warning' : 'danger')) ?>">
                          <?= $row->status ?>
                        </span>
                      </td>
                      <td><?= $row->keterangan ?: '-' ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>