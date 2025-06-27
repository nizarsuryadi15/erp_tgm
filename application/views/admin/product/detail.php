<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                    <a href="javascript:void(0);" class="btn btn-primary" onclick="copyToClipboard('<?= $getProduct['product_nama'] ?>')">
                        <?= $getProduct['product_nama'] ?>
                    </a>        
                </div>
            </dv>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="w2-account-tab" data-bs-toggle="tab" data-bs-target="#w2-account" type="button" role="tab">Form Harga</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="w2-profile-tab" data-bs-toggle="tab" data-bs-target="#w2-profile" type="button" role="tab">Detail Product</button>
                </li>
            </ul>

            <div class="tab-content pt-3" id="productTabContent">
                <div class="tab-pane fade show active" id="w2-account" role="tabpanel">
                    <?php 
                        // $kategori_id = $getProduct['kategori_id'];
                        // $allowed_ids = range(1, 10);
                        // if (in_array($kategori_id, $allowed_ids)) {
                        //     $this->load->view('admin/product/add_harga/kategori_' . $kategori_id);
                        // }
                    ?>
                    <?php 
                        $this->load->view('admin/product/add_harga/kategori_1');
                    ?>

                </div>

                <div class="tab-pane fade" id="w2-profile" role="tabpanel">
                    <table class="table table-bordered">
                        <tbody>
                            <tr><td width="20%">Kategori</td><td width="5%">:</td><td><?= $getProduct['kategori_nama']?></td></tr>
                            <tr><td>Sub Kategori</td><td>:</td><td><?= $getProduct['subkategori_nama']?></td></tr>
                            <tr><td>Bahan Baku</td><td>:</td><td><?= $getProduct['bahan_nama']?></td></tr>
                            <tr><td>Barcode</td><td>:</td><td><?= $getProduct['barcode']?></td></tr>
                            <tr><td>Nama Product</td><td>:</td><td><?= $getProduct['product_nama']?></td></tr>
                            <tr><td>Waktu Produksi</td><td>:</td><td><?= $getProduct['product_waktu_pengerjaan']?> <?= $getProduct['waktu_nama']?></td></tr>
                            <tr><td>Keterangan Product</td><td>:</td><td><?= $getProduct['product_deskripsi']?></td></tr>
                        </tbody>
                    </table>

                    <hr>
                    <!-- Button to trigger modal -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAlurKerja">
                        Setting Alur Kerja Product
                    </button>

                    <table class="table table-bordered">
                        <tr><th>No</th><th>Alur Kerja</th></tr>
                        <?php $no = 1; foreach ($getAlurKerja as $key): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $key->alur_nama ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Modal Bootstrap 5 -->
        <div class="modal fade" id="modalAlurKerja" tabindex="-1" aria-labelledby="modalAlurKerjaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <form action="<?= base_url('product/action_checkbox')?>" method="post">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalAlurKerjaLabel">Alur Kerja Product <?= $getProduct['product_nama']?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <?php foreach ($getAlur as $al): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alur_id[]" value="<?= $al->alur_id ?>" id="alur<?= $al->alur_id ?>">
                                    <label class="form-check-label" for="alur<?= $al->alur_id ?>"><?= $al->alur_nama ?></label>
                                </div>
                                <input type="hidden" name="product_id" value="<?= $kodeProduct ?>">
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function () {
            alert("Teks berhasil disalin: " + text);
        }, function () {
            alert("Gagal menyalin teks.");
        });
    }
</script>

<script>
$(document).ready(function() {
    $('.btn-hapus-harga').click(function(e) {
        e.preventDefault();
        var href = $(this).data('href');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data harga ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });
});
</script>
