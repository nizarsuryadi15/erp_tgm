<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                    <a href="#" class="btn btn-warning disabled">Total: <?= $total_rows ?></a>
                    <?php
                        // Hitung jumlah Product dan Jasa
                        $jumlah_product = 0;
                        $jumlah_jasa = 0;
                        foreach ($tampilData as $dt) {
                            if ($dt->product_jasa == '1') {
                                $jumlah_product++;
                            } else {
                                $jumlah_jasa++;
                            }
                        }
                    ?>
                    <button class="btn btn-primary">Produk Bahan: <?= $jumlah_product ?></button>
                    <button class="btn btn-secondary">Produk Jasa: <?= $jumlah_jasa ?></button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalInputData">
                        Tambah Bahan Produksi
                    </button>
                </div>
            </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="datatable-details">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th width="150">Barcode</th>
                            <th width="500">Produk Bahan / Jasa</th>
                            <th>Detail</th>
                            <th>Jenis</th>
                            <th>Satuan Produksi</th>
                            <th>Satuan Gudang</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($tampilData as $dt): 
                            $projas = ($dt->product_jasa == '1') ? '<span class="badge bg-primary">Product</span>' : '<span class="badge bg-secondary">Jasa</span>';
                            $jumlahProduk = $this->M_master->get_produk_by_bahan($dt->bahan_id)->num_rows();
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-center">
                                <img src="<?= base_url('assets/uploads/barcode/'.$dt->barcode.'.png') ?>" alt="<?= $dt->barcode ?>" /><br>
                                <?= $dt->barcode ?>
                            </td>
                            <td>
                                <h5><?= $dt->bahan_nama ?></h5>
                                
                            </td>
                            <td>
                                <a href="<?= base_url('gudang/produk-bahan/'.$dt->bahan_id) ?>" class="badge bg-success"><?= $jumlahProduk ?></a>
                                <a href="<?= base_url('gudang/buat-produk/'.$dt->bahan_id) ?>" class="badge bg-success">Buat Product</a>
                                <a href="<?= base_url('gudang/lihat-produk/'.$dt->bahan_id) ?>" class="badge bg-success">Lihat Product</a>
                            </td>
                            <td class="text-center"><?= $projas ?></td>
                            <td><?= $dt->satuan_nama ?></td>
                            <td><?= $dt->satuan_gudang_nama ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditData"
                                    data-id="<?= $dt->bahan_id ?>"
                                    data-barcode="<?= $dt->barcode ?>"
                                    data-nama="<?= $dt->bahan_nama ?>"
                                    data-product_jasa="<?= $dt->product_jasa ?>"
                                    data-satuan_id="<?= $dt->satuan_id ?>"
                                    data-satuan_gudang="<?= $dt->satuan_gudang ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button type="button" class="btn btn-default btn-sm btn-edit-barcode"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modaleditBarcode"
                                    data-id="<?= $dt->bahan_id ?>"
                                    data-barcode="<?= $dt->barcode ?>">
                                   
                                   <i class="bi bi-upc-scan"></i>
                                </button>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm btn-delete"
                                    data-url="<?= base_url('gudang/hapus-bahan/'.$dt->bahan_id) ?>">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInputData" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('bahan/actionAdd') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bahan Produksi</label>
                        <input name="bahan_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product / Jasa</label>
                        <select name="product_jasa" class="form-select">
                            <option value="1">Product</option>
                            <option value="0">Jasa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan Gudang</label>
                        <select name="satuan_gudang" class="form-select">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($satuan as $s): ?>
                                <option value="<?= $s->satuan_id ?>"><?= $s->satuan_nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan Product</label>
                        <select name="satuan_id" class="form-select">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($satuan as $s): ?>
                                <option value="<?= $s->satuan_id ?>"><?= $s->satuan_nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalEditData" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('bahan/actionUpdate') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bahan Produksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bahan_id" id="edit_id">
                    <!-- <div class="mb-3>
                        <label>Barcode</label>
                        <input type="text" name="barcode" id="edit_barcode" class="form-control" required>
                    </div> -->
                    <div class="mb-3">
                        <label>Nama Bahan Produksi</label>
                        <input type="text" name="bahan_nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Product / Jasa</label>
                        <select name="product_jasa" id="edit_product_jasa" class="form-select">
                            <option value="1">Product</option>
                            <option value="0">Jasa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan Gudang</label>
                        <select name="satuan_gudang" class="form-select" id="edit_satuan_gudang">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($satuan as $s): ?>
                                <option value="<?= $s->satuan_id ?>"><?= $s->satuan_nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan Product</label>
                        <select name="satuan_id" id="edit_satuan_id" class="form-select">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($satuan as $s): ?>
                                <option value="<?= $s->satuan_id ?>"><?= $s->satuan_nama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modaleditBarcode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('bahan/updateBarcodeOnly') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Barcode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bahan_id" id="edit_barcode_id">
                    <div class="mb-3">
                        <label>Barcode</label>
                        <?php
                            $barcode_value = '';
                            if (isset($dt)) {
                                if (empty($dt->barcode) || $dt->barcode == '0') {
                                    $barcode_value = isset($last_barcode->barcode) && is_numeric($last_barcode->barcode)
                                        ? str_pad($last_barcode->barcode + 1, 8, '0', STR_PAD_LEFT)
                                        : '00000001';
                                } else {
                                    $barcode_value = $dt->barcode;
                                }
                            }
                        ?>
                        <input type="text" name="barcode" id="edit_barcode" class="form-control" required value="<?= $barcode_value ?>">
                    </div>
                    <div class="mb-3 text-center">
                        <img id="barcode_img" src="<?= isset($barcode_value) && $barcode_value ? base_url('assets/uploads/barcode/'.$barcode_value.'.png') : '' ?>" alt="Barcode" style="max-width:200px;max-height:60px;">
                        <br><?= $barcode_value ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.btn-edit').click(function() {
        const id                = $(this).data('id');
        const nama              = $(this).data('nama');
        const product_jasa      = $(this).data('product_jasa');
        const satuan_id         = $(this).data('satuan_id');
        const satuan_gudang     = $(this).data('satuan_gudang');

        $('#edit_id').val(id);
        $('#edit_nama').val(nama);
        $('#edit_product_jasa').val(product_jasa);
        $('#edit_satuan_id').val(satuan_id);
        $('#edit_satuan_gudang').val(satuan_gudang);
    });



    $('.btn-edit-barcode').click(function() {
        const id = $(this).data('id');
        let barcode = $(this).data('barcode');
        // Jika barcode kosong atau 0, gunakan barcode baru dari PHP
        if (!barcode || barcode === '0') {
            barcode = '<?= isset($last_barcode->barcode) && is_numeric($last_barcode->barcode) ? str_pad($last_barcode->barcode + 1, 8, "0", STR_PAD_LEFT) : "00000001" ?>';
        }
        $('#edit_barcode_id').val(id);
        $('#edit_barcode').val(barcode);
        $('#barcode_img').attr('src', '<?= base_url('assets/uploads/barcode/') ?>' + barcode + '.png');
    });

    // Update gambar barcode saat input barcode diubah manual
    $('#edit_barcode').on('input', function() {
        var val = $(this).val();
        $('#barcode_img').attr('src', '<?= base_url('assets/uploads/barcode/') ?>' + val + '.png');
    });

    $('.btn-delete').click(function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
