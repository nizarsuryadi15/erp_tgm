<style>
    .tabel-kecil {
        font-size: 10px;
    }

</style>

<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                    <a href="#" class="btn btn-dark me-2">Jumlah Data: <?= $total_rows ?></a>
                    <a href="<?= base_url('bahan') ?>" class="btn btn-danger me-2">Bahan Produksi</a>&nbsp;
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalkategori">
                        Kategori
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalsubkategori">
                        Sub Kategori
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInputData">
                        Tambah Product
                    </button>
                    <a href="https://drive.google.com/file/d/1JXa9IaJCrsx5VJ2mZkrCWHZO5Y_nQLfi/view?usp=drive_link" target="blank" class="btn btn-info"><i class="bi bi-info"></i> Manual</a>
                </div>
                
                
            </div>

            <div class="card-body">
                <div class="flex-grow-1 overflow-auto">
                    <div class="table-responsive h-100">    
                    <table class="table table-bordered table-striped table-hover w-100 m-0 table-kecil" id="datatable-details">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <!-- <th>Gambar</th> -->
                                <th>Nama Product</th>
                                <th>Bahan produksi</th>
                                <th>Kategori</th>
                                <th width="10%">Sub Kategori</th>
                                <th width="10%">Jenis Produk</th>
                                <th width="5%">Pilihan Sisi</th>
                                <th>Satuan</th>
                                <th width="8%">Skala Harga</th>
                                <th width="8%">BOM</th>
                                <th width="8%">Routing</th>
                                <?php if ($this->session->userdata('level') == '1'): ?>
                                    <th width="8%">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($tampilData as $dt): ?>
                            <?php
                                $jml_detail  = $this->M_master->jml_detail($dt->product_id)->num_rows();
                                $jml_routing = $this->M_master->jml_routing($dt->product_id)->num_rows();
                                $jml_bom     = $this->M_master->jml_bom($dt->product_id)->num_rows();
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <!-- <td class="text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalImage<?= $dt->product_id ?>">
                                        <img src="<?= base_url('assets/images/product/' . $dt->product_img_1) ?>" class="img-thumbnail" style="max-height: 70px;">
                                    </a>
                                </td> -->
                                <td>
                                    <strong><?= $dt->product_nama ?></strong>
                                </td>
                                <td>
                                    <!-- <?= $dt->product_id ?> -->
                                    <?= $dt->bahan_nama ?>
                                
                                </td>
                                <td><?= $dt->kategori_nama ?></td>
                                <td><strong><?= $dt->subkategori_nama ?></strong></td>
                                <td><?= $dt->tipe_nama ?></td>
                                <td><?= $dt->side_name ?></td>
                                <td><?= $dt->satuan_nama ?></td>
                                <td class="text-center">
                                    <?php 
                                        $btnClass = ($jml_detail == 0) ? "text text-danger" : "text text-success";
                                    ?>
                                    <a href="<?= base_url('manufaktur/skala-harga/' . $dt->product_id) ?>" class="<?= $btnClass ?> btn-sm btn-block">
                                        Harga (<?= $jml_detail ?>)
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $btnClass = ($jml_bom == 0) ? "text text-danger" : "text text-success";
                                    ?>
                                    <a href="<?= base_url('manufaktur/bom/' . $dt->product_id) ?>" class="<?= $btnClass ?> btn-sm btn-block">Material (<?= $jml_bom ?>)</span></a>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $btnClass = ($jml_routing == 0) ? "text text-danger" : "text text-success";
                                    ?>
                                    <a href="<?= base_url('manufaktur/routing/' . $dt->product_id) ?>" class="<?= $btnClass ?> btn-sm btn-block">Routing (<?= $jml_routing ?>)</span></a>
                                </td>
                                <?php if ($this->session->userdata('level') == '1'): ?>
                                <td class="text-center">
                                    <!-- <a class="btn btn-warning btn-sm" href="<?= base_url('manufaktur/copy-product/' . $dt->product_id) ?>"><i class="bi bi-files"></i></a> -->
                                    <a class="btn btn-primary btn-sm" href="<?= base_url('manufaktur/edit-product/' . $dt->product_id) ?>"><i class="bi bi-pencil"></i></a>
                                    <!-- <a class="btn btn-success btn-sm" href="<?= base_url($controller . '/detail-product/' . $dt->product_id) ?>"><i class="bi bi-list-ul"></i></a> -->
                                    <a class="btn btn-danger btn-sm" href="<?= base_url('manufaktur/deleteproduct/' . $dt->product_id) ?>" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                                <?php endif; ?>
                            </tr>

                            <!-- Modal Image Bootstrap 5 -->
                            <div class="modal fade" id="modalImage<?= $dt->product_id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <img src="<?= base_url('assets/images/product/' . $dt->product_img_1) ?>" class="img-fluid" alt="Gambar Produk">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Input Data -->
<div class="modal fade" id="modalInputData" tabindex="-1" aria-labelledby="modalInputDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('product/actionAdd') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInputDataLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Bahan / Jasa -->
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Bahan Produksi</label>
                        <div class="col-sm-10">
                            <select name="bahan_id" class="form-select select" required>
                                <option value="">-- Pilih Bahan Baku --</option>
                                <?php foreach ($list_bahan as $k): ?>
                                    <option value="<?= $k->bahan_id ?>"><?= $k->bahan_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Kategori & Sub Kategori -->
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-5">
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k->kategori_id ?>"><?= $k->kategori_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <select name="subkategori_id" class="form-select subkategori" required>
                                <option value="">-- Pilih Sub Kategori --</option>
                                <?php foreach ($subkategori as $k): ?>
                                    <option value="<?= $k->subkategori_id ?>"><?= $k->subkategori_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Jenis Print (tampil jika kategori = 2) -->
                    <!-- <div class="mb-3 row" id="jenis_print_row" style="display: none;">
                        <label class="col-sm-2 col-form-label">Jenis Print</label>
                        <div class="col-sm-5">
                            <select name="jenisprint_id" class="form-select">
                                <option value="">-- Pilih Jenis Print --</option>
                                <option value="1">Outdoor Solvent</option>
                                <option value="2">Indoor Eco-Solvent</option>
                                <option value="3">Indoor UV</option>
                            </select>
                        </div>
                    </div> -->

                    <!-- Nama Produk, Tipe, Satuan -->
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-5">
                            <input type="text" name="product_nama" class="form-control" required
                                placeholder="Nama Produk"
                                value="<?= $getproduct['product_nama'] ?? '' ?>">
                        </div>
                        <div class="col-sm-3">
                            <select name="tipe_id" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <?php foreach ($tipe as $k): ?>
                                    <option value="<?= $k->tipe_id ?>"><?= $k->tipe_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select name="satuan_id" class="form-select" required>
                                <option value="">-- Pilih Satuan --</option>
                                <?php foreach ($satuan as $k): ?>
                                    <option value="<?= $k->satuan_id ?>"
                                        <?= isset($getproduct['satuan_id']) && $k->satuan_id == $getproduct['satuan_id'] ? 'selected' : '' ?>>
                                        <?= $k->satuan_nama ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Pilihan Sisi -->
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Pilihan Sisi</label>
                        <div class="col-sm-10">
                            <select name="side_id" class="form-select">
                                <option value="">-- Pilihan Sisi --</option>
                                <?php foreach ($sisi as $k): ?>
                                    <option value="<?= $k->side_id ?>"
                                        <?= isset($getproduct['side_id']) && $k->side_id == $getproduct['side_id'] ? 'selected' : '' ?>>
                                        <?= $k->side_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea name="product_deskripsi" class="form-control" rows="3" style="white-space: pre-wrap; font-family: Lato;"><?= htmlspecialchars($getproduct['product_deskripsi'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url($controller . '/') ?>" class="btn btn-warning">Batal</a>
                </div>
            </div>
        </form>

    </div>
</div>

<div class="modal fade" id="modalkategori" tabindex="-1" aria-labelledby="modalkategori" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalkategori">Data Ketegori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-light table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($kategori as $kat):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $kat->kategori_nama ?></td>
                        </tr>
                        <?php 
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalsubkategori" tabindex="-1" aria-labelledby="modalsubkategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalsubkategoriLabel">Data Sub Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahSubkategori" method="post">
                    <div class="row mb-3">
                        <div class="col-md-10">
                            <input type="text" name="subkategori_nama" class="form-control" placeholder="Nama Sub Kategori" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">Tambah</button>
                        </div>
                    </div>
                </form>

                <table class="table table-light table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Sub Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($subkategori as $sub): ?>
                        <tr data-id="<?= $sub->subkategori_id ?>">
                            <td><?= $no++ ?></td>
                            <td>
                                <input type="text" class="form-control subkategori-nama" value="<?= $sub->subkategori_nama ?>">
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-edit">Edit</button>
                                <button type="button" class="btn btn-danger btn-delete">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#formTambahSubkategori').on('submit', function(e) {
        e.preventDefault(); // Cegah reload form

        const nama = $(this).find('input[name="subkategori_nama"]').val();

        $.ajax({
            url: "<?= base_url('product/add_subkategori_ajax') ?>",
            method: "POST",
            data: { subkategori_nama: nama },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    // Tambahkan data baru ke tabel
                    const row = `
                        <tr data-id="${res.data.subkategori_id}">
                            <td>-</td>
                            <td><input type="text" class="form-control subkategori-nama" value="${res.data.subkategori_nama}"></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-edit">Edit</button>
                                <button type="button" class="btn btn-danger btn-delete">Hapus</button>
                            </td>
                        </tr>`;
                    $('table tbody').append(row);
                    $('#formTambahSubkategori')[0].reset(); // Kosongkan input
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Sub Kategori berhasil ditambahkan',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Gagal tambah: ' + res.message);
                }
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {

    // Edit Subkategori
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        const row = $(this).closest('tr');
        const id = row.data('id');
        const nama = row.find('.subkategori-nama').val();

        $.ajax({
            url: "<?= base_url('product/update_subkategori_ajax') ?>",
            method: "POST",
            data: {
                subkategori_id: id,
                subkategori_nama: nama
            },
            dataType: "json",
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Sub Kategori berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Gagal memperbarui data'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan: ' + xhr.statusText
                });
            }
        });
    });

    // Delete Subkategori
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const row = $(this).closest('tr');
        const id = row.data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('product/delete_subkategori_ajax') ?>",
                    method: "POST",
                    data: { subkategori_id: id },
                    dataType: "json",
                    success: function(res) {
                        if (res.status === 'success') {
                            row.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Subkategori berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message || 'Gagal menghapus data'
                            });
                        }
                    }
                });
            }
        });
    });

});
</script>






<!-- JS Init -->
<script>
$(document).ready(function() {
    $('#modalInputData').on('shown.bs.modal', function () {
        $('.select2', this).select2({
            dropdownParent: $('#modalInputData'),
            placeholder: "-- Pilih Bahan Baku --",
            allowClear: true,
            width: '100%'
        });
    });
});
</script>

<!-- Modal Gambar -->
    <div class="modal fade" id="modalImage<?= $dt->product_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body text-center">
            <img src="<?= base_url('assets/images/product/' . $dt->product_img_1) ?>" class="img-fluid" alt="Gambar Produk">
        </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#kategori_id').on('change', function() {
                const kategoriId = $(this).val();
                if (kategoriId == 2) {
                    $('#jenis_print_row').show();
                } else {
                    $('#jenis_print_row').hide();
                }
            });

            // Trigger on page load (for edit mode)
            $('#kategori_id').trigger('change');
        });
    </script>





