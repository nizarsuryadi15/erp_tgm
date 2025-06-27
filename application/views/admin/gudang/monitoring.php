<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header">
               <h3 class="card-title">Data Monitoring Barang Masuk & Keluar Gudang Utama</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            
                            <th>Nama Barang</th>
                            <th>Tipe</th>
                            <th>Qty Masuk</th>
                            <th>Qty Keluar</th>
                           
                            <th>Petugas</th>
                            <th>Dikirim ke Gudang</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        // Looping data monitoring
                        foreach ($monitoring as $row): ?>
                        <?php
                        // Menghitung jumlah masuk dan keluar
                        $qty_masuk = isset($row->qty_masuk) ? $row->qty_masuk : 0;
                        $qty_keluar = isset($row->qty_keluar) ? $row->qty_keluar : 0;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= date_indo($row->tanggal) ?>
                                <br>
                                <?php
                                    // Konversi waktu ke zona WIB (Asia/Jakarta)
                                    if (isset($row->waktu) && $row->waktu) {
                                        $dt = new DateTime($row->waktu, new DateTimeZone('UTC'));
                                        $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                        echo $dt->format('H:i:s') . ' WIB';
                                    }
                                ?>
                            </td>
                            
                            <td><?= htmlspecialchars($row->bahan_nama) ?></td>
                            <td><?= htmlspecialchars($row->tipe) ?></td>
                            <td class="text-center"><?= $row->qty_masuk ?><br> <?= htmlspecialchars($row->satuan_nama) ?></td>
                            <td class="text-center"><?= $row->qty_keluar ?><br> <?= htmlspecialchars($row->satuan_nama) ?></td>
                          
                            <td class="text-center"><?= htmlspecialchars($row->nama_karyawan) ?></td>
                            <td class="text-center">
                                <?php 
                                 if($row->qty_keluar > 0) {
                                    echo htmlspecialchars($row->nama_supplier);
                                 } else {
                                    echo '-';
                                 }
                                ?>
                              </td>
                            
                        </tr>
                        <?php
                        // Menambahkan total qty masuk dan keluar
                        $total_qty_masuk += $qty_masuk;
                        $total_qty_keluar += $qty_keluar;
                        ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-center font-weight-bold">Total</td>
                            <td class="text-center font-weight-bold"><?= $total_qty_masuk ?></td>
                            <td class="text-center font-weight-bold"><?= $total_qty_keluar ?></td>
                            <td class="text-center font-weight-bold"></td>
                        </tr>
                    </tbody>
                </table>

            </div>    
        </div>
    </div>
</div>