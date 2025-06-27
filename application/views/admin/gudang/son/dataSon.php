<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card">
            <header class="card-heading"></header>
            <div class="card-body text-center">

                <!-- Form Pilih Bahan -->
                <div class="col-md-6 mb-3">
                    <form action="" method="post">
                        <div class="input-group mb-2">
                            <select name="bahan_id" id="bahan_id" class="form-control select2" onchange="this.form.submit()">
                                <option value="">-- Pilih Bahan --</option>
                                <?php foreach ($bahan as $b): ?>
                                    <option value="<?= $b->bahan_id ?>"><?= $b->barcode ?> || <?= $b->bahan_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" id="scan_barcode" class="form-control" placeholder="Scan Barcode..." autocomplete="off" style="max-width:200px;">
                        </div>
                        <button type="submit" hidden></button>
                    </form>
                </div>
                <script>
                $(document).ready(function() {
                    $('#bahan_id').select2({
                        placeholder: "-- Pilih Bahan --",
                        allowClear: true
                    });

                    // Fungsi scan barcode: cari dan pilih option sesuai barcode
                    $('#scan_barcode').on('change', function() {
                        var barcode = $(this).val().trim();
                        if (!barcode) return;
                        var found = false;
                        $('#bahan_id option').each(function() {
                            if ($(this).text().indexOf(barcode) !== -1) {
                                $('#bahan_id').val($(this).val()).trigger('change');
                                found = true;
                                return false;
                            }
                        });
                        if (!found) {
                            alert('Barcode tidak ditemukan!');
                        }
                        $(this).val('');
                    });
                });
                </script>

                <!-- Form Input Stok Real -->
                <?php if ($getRow > 0): ?>
                <div class="col-md-12 mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barcode</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Stok Real Gudang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $no = 1;
                                    foreach ($getbahan as $b): 
                                        $stokaplikasi = ($b->stok_awal + $b->stok_tambah) - $b->stok_kurang;
                                ?>
                                <tr>
                                    <form action="<?= base_url('gudang/action_add_son') ?>" method="post">
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $b->barcode ?></td>
                                        <td class="text-left"><?= $b->bahan_nama ?></td>
                                        <td>
                                            <input type="number" name="son_real" class="form-control" required>
                                            <input type="hidden" name="bahan_id" value="<?= $b->bahan_id ?>">
                                            <input type="hidden" name="son_aplikasi" value="<?= $stokaplikasi ?>">
                                            <input type="hidden" name="son_tgl" value="<?= $hariini ?>">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </td>
                                    </form>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Tabel Riwayat Stok Opname -->
                <div class="col-md-12">
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="7">
                                        <a href="<?= base_url('gudang/cetakSon/'.$bulanini) ?>" class="btn btn-primary btn-block">
                                            Cetak Kartu Stok Opname <i class="fa fa-print"></i>
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Stok Opname</th>
                                    <th>Nama Barang</th>
                                    <th>Stok Real</th>
                                    <th>Stok Aplikasi</th>
                                    <th>Selisih</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $no = 1;
                                    foreach ($tampilData as $dt):
                                        $selisih = ($dt->son_real - $dt->son_aplikasi);
                                        if ($selisih == 0) {
                                            $keterangan = 'Sesuai';
                                        } elseif ($dt->son_real > $dt->son_aplikasi) {
                                            $keterangan = 'Lebih';
                                        } else {
                                            $keterangan = 'Kurang';
                                        }
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?= date_indo($dt->son_tgl) ?>
                                        <br>
                                        <?= isset($dt->update_at) ? date('H:i:s', strtotime($dt->update_at)) : '' ?>
                                    </td>
                                    <td>
                                        <?= $dt->bahan_nama ?>
                                        <br>
                                        <?php if (isset($dt->barcode) && !empty($dt->barcode)): ?>
                                            <img src="<?= base_url('assets/uploads/barcode/'.$dt->barcode.'.png') ?>" alt="<?= $dt->barcode ?>">
                                            <br>
                                            <?= $dt->barcode ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end"><strong><?= $dt->son_real ?></strong> <?= $dt->satuan_nama ?></td>
                                    <td class="text-end"><strong><?= $dt->son_aplikasi ?></strong> <?= $dt->satuan_nama ?></td>
                                    <td>
                                        <strong class="<?= $selisih == 0 ? 'text-success' : 'text-danger' ?>">
                                            <?= $selisih ?>
                                        </strong> <?= $dt->satuan_nama ?>
                                    </td>
                                    <td>
                                        <strong class="<?= $selisih == 0 ? 'text-success' : 'text-danger' ?>">
                                            <?= $keterangan ?>
                                        </strong>
                                        <br>
                                        <?php if ($selisih <> 0): ?>
                                            <a href="<?= base_url('gudang/cetakSonDetail/'.$dt->son_id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fa fa-print"></i> Cetak Detail
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-danger mb-0">
                                            <strong>Data Tersimpan:</strong> Anda tidak dapat menghapus data yang telah tersimpan.
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div> <!-- /.card-body -->
        </div> <!-- /.card -->
    </div> <!-- /.container-fluid -->
</div> <!-- /.app-content -->

<!-- Select2 Script -->
<script>
    $(document).ready(function() {
        $('#bahan_id').select2({
            placeholder: "-- Pilih Bahan --",
            allowClear: true
        });
    });
</script>
