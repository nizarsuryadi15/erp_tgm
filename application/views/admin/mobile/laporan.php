<div class="container py-4" style="padding-bottom: 80px;">

    <!-- Header Profile -->
    <div class="text-center mb-4">
        <!-- <img src="https://i.imgur.com/nG6r8Xg.jpg" alt="Foto Profil" class="profile-img"> -->
        <h5 class="mt-3 mb-0"><?= $karyawan_terpilih['nama_lengkap']?></h5>
        <small class="text-muted"><?= $karyawan_terpilih['email']?></small><br>
        <!-- <span class="badge bg-success mt-1">Operator - Customer Service</span> -->
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        <h6 class="text-success mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>
        Laporan Absensi Bulan Ini - <?= date_indo(date('Y-m')) ?>
        </h6>
    
        <div class="table-wrapper-desktop">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none" id="datatable-details">	
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($absensi)): ?>
                            <tr><td colspan="4" class="text-center">Belum ada Absensi Bulan ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($absensi as $row): ?>
                            <tr>
                                <td><?= date_indo($row['tanggal']) ?></td>
                                <td><?= $row['jam_masuk'] ?? '-' ?></td>
                                <td><?= $row['jam_pulang'] ?? '-' ?></td>
                                <td><?= $row['status'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    
        <div class="table-responsive-mobile">
        <?php if (empty($absensi)): ?>
            <div class="alert alert-info text-center">Belum ada Absensi Bulan ini.</div>
        <?php else: ?>
            <?php foreach ($absensi as $row): ?>
            <div class="card mb-2 shadow-sm">
                <div class="card-body p-2">
                    <h6 class="mb-1"><?= date_indo($row['tanggal']) ?></h6>
                    <p class="mb-1"><strong>Masuk:</strong> <?= $row['jam_masuk'] ?? '-' ?></p>
                    <p class="mb-1"><strong>Pulang:</strong> <?= $row['jam_pulang'] ?? '-' ?></p>
                    <p class="mb-0"><strong>Status:</strong> <?= $row['status'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    </div>
    
    <div class="profile-card">
        <h6 class="text-success mb-3">
        <i class="bi bi-person-badge-fill me-2"></i>
        Laporan Lembur Bulan Ini - <?= date_indo(date('Y-m')) ?>
        </h6>
        <div class="table-wrapper-desktop table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="25%">Tanggal</th>
                        <th>Waktu Lembur</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lembur)): ?>
                        <tr><td colspan="4" class="text-center">Belum Lembur Bulan ini.</td></tr>
                    <?php else: ?>
                        <?php foreach ($lembur as $row): ?>
                        <tr>
                            <td><?= date_indo($row->tanggal) ?></td>
                            <td><?= $row->jam_mulai ?> - <?= $row->jam_selesai ?></td>
                            <td><?= $row->kegiatan ?></td>
                            <td class="text-center">
                                <?php
                                    if ($row->status == 'disetujui') {
                                        echo '<span class="text-success">✅</span>';
                                    } elseif ($row->status == 'menunggu') {
                                        echo '<span class="text-warning">🕒</span>';
                                    } elseif ($row->status == 'ditolak') {
                                        echo '<span class="text-danger">❌</span>';
                                    } else {
                                        echo $row->status;
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-responsive-mobile">
            <?php if (empty($lembur)): ?>
                <div class="alert alert-info text-center">Belum Lembur Bulan ini.</div>
            <?php else: ?>
                <?php foreach ($lembur as $row): ?>
                <div class="card shadow-sm mb-2">
                    <div class="card-body p-2">
                        <h6 class="mb-1"><strong><?= date_indo($row->tanggal) ?></strong></h6>
                        <p class="mb-1"><strong>Jam:</strong> <?= $row->jam_mulai ?> - <?= $row->jam_selesai ?></p>
                        <p class="mb-1"><strong>Kegiatan:</strong> <?= $row->kegiatan ?></p>
                        <p class="mb-0">
                            <strong>Status:</strong>
                            <?php
                                if ($row->status == 'disetujui') {
                                    echo '<span class="text-success">✅ Disetujui</span>';
                                } elseif ($row->status == 'menunggu') {
                                    echo '<span class="text-warning">🕒 Menunggu</span>';
                                } elseif ($row->status == 'ditolak') {
                                    echo '<span class="text-danger">❌ Ditolak</span>';
                                } else {
                                    echo $row->status;
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>



    </div>


</div>
