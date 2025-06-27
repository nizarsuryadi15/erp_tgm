<div class="app-content">
    <div class="container-fluid">
        <div class="row py-4">
            <div class="col-12">
                <h3 class="fw-semibold text-uppercase text-dark mb-3">Dashboard Human Resource</h3>
                <hr>
            </div>

            <!-- Card Item -->
            <?php
            $items = [
                ["Jumlah Karyawan", $total_karyawan, "fa-user", "karyawan/daftar-karyawan"],
                ["Total Akun Karyawan", $total_akun, "fa-users", "karyawan/akun"],
                ["Karyawan Laki-Laki", $total_laki, "fa-male", "karyawan/karyawan"],
                ["Karyawan Perempuan", $total_pere, "fa-female", "karyawan_karyawan"],
                ["Jumlah Deskprint", $total_deskprint, "fa-edit", "karyawan_karyawan"],
                ["Jumlah Kasir", $total_kasir, "fa-shopping-cart", "karyawan_karyawan"],
                ["Karyawan Operator", $total_operator, "fa-female", "karyawan_karyawan"],
                ["Karyawan Perempuan", $total_pere, "fa-female", "karyawan_karyawan"],
            ];

            foreach ($items as $item):
                [$title, $count, $icon, $url] = $item;
            ?>
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 fs-1">
                            <i class="fa <?= $icon ?>"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="card-title text-white"><?= $title ?></h6>
                            <h4 class="fw-bold mb-0"><?= $count ?></h4>
                            <small><a class="text-uppercase text-white-50" href="<?= base_url($url) ?>">View</a></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Tabel Daftar Akun Aktif -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Akun Aktif</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="table-details">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 40%;">Username</th>
                                    <th style="width: 55%;">Waktu Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($logs)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($logs as $log): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($log->username, ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($log->login_time)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data login.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
