<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                    <i class="bi bi-arrow-left"></i> Kembali
                </button>
                <a class="btn btn-warning btn-block text-center" data-bs-toggle="modal" data-bs-target="#modalSupplier">
                    <i class="fa fa-building"></i> Add Supplier
                </a>
                <a class="btn btn-primary btn-block text-center" data-bs-toggle="modal" data-bs-target="#modalProduk">
                    <i class="fa fa-plus"></i> Tambah Product
                </a>
                
            </div>

            <div class="card-body text-center">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Bahan</th>
                            <th>QTY</th>
                            <th>Harga Beli</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $total = 0;
                        foreach ($temp as $dt): 
                            $jumlah = $dt->qty * $dt->harga;
                            $total += $jumlah;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-left"><?= $dt->bahan_nama ?></td>
                            <td class="text-right"><?= number_format($dt->qty) ?></td>
                            <td class="text-right"><?= number_format($dt->harga) ?></td>
                            <td class="text-right"><?= number_format($jumlah) ?></td>
                            <td>
                                <a href="<?= base_url('gudang/deleteTempbeli/' . $dt->temp_id) ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong><?= number_format($total) ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <?= validation_errors(); ?>
                <?= form_open('gudang/action_barang_masuk'); ?>
                    <div class="form-group row">
                        <label class="col-md-2 control-label">Tanggal Belanja</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="pembelian_tgl" value="<?= date('Y-m-d') ?>">
                            
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="no_faktur" placeholder="No Faktur Pembelian" value="<?= set_value('no_faktur'); ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label">Nama Supplier</label>
                        <div class="col-md-4">
                            <select data-plugin-selectTwo name="supplier_id" id="supplier_id" class="form-control">
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach($supplier as $b): ?>
                                    <option value="<?= $b->supplier_id ?>"><?= $b->supplier_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-save"></i> Simpan Pembelian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form method="post" action="<?= base_url('gudang/action_add_barang_masuk') ?>">
            <div class="modal-header">
            <h5 class="modal-title" id="modalProdukLabel">Tambahkan Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Bahan</label>
                <select class="form-select select2" name="bahan_id" id="bahan_id">
                    <option value="">-- Pilih Bahan Baku --</option>
                    <?php foreach($bahan as $b): ?>
                        <option value="<?= $b->bahan_id ?>"><?= $b->bahan_nama ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="qty">
            </div>
           
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Supplier -->
    <div class="modal fade" id="modalSupplier" tabindex="-1" aria-labelledby="modalSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form method="post" action="<?= base_url($controller . '/actionAddSupplier') ?>">
            <div class="modal-header">
            <h5 class="modal-title" id="modalSupplierLabel">Tambahkan Nama Supplier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Supplier</label>
                <input type="text" name="supplier_nama" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="supplier_nohp" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="supplier_alamat" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="supplier_email" class="form-control">
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
        </div>
    </div>
</div>


<!-- <script>
    $(document).ready(function() {
        $('#bahan_id').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Bahan Baku --',
            allowClear: true
        });
    });
</script> -->


