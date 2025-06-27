<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="panel-title"><?= $title ?> : <?= $getproduct['product_nama'] ?></h2>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <p>Jumlah Data : <?= $total_rows ?><br>Kebutuhan Bahan untuk membuat 1 product</p>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInputData">
                            <i class="bi bi-plus-circle-fill"></i> Tambah BOM
                        </button>
                    </div>
                </div>

                <table class="table table-bordered table-striped mb-0" id="datatable-detail">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Bahan</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($tampilData as $dt): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $dt->product_nama ?></td>
                                <td><?= $dt->bahan_nama ?></td>
                                <td>
                                    <?= $dt->quantity ?><br>
                                    <?= $dt->panjang ?> x <?= $dt->lebar ?>
                                </td>
                                <td><?= $dt->satuan_nama ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success" href="<?= base_url($controller . '/formUpdate/' . $dt->routing_id) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger" href="<?= base_url('manufaktur/aksideletestep/' . $dt->routing_id) ?>">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalInputData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?= base_url('manufaktur/aksi_simpan_bom') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelLembur">Tambah Data BOM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Nama Product</label>
                        <input type="text" class="form-control" value="<?= $getproduct['product_nama'] ?>" readonly>
                        <input type="hidden" name="product_id" class="form-control" value="<?= $getproduct['product_id'] ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label>Pilih Bahan Utama</label>
                        <select name="bahan_id" class="form-control" data-plugin-selectTw>
                            <?php foreach ($bahan as $p): ?>
                                <option value="<?= $p->bahan_id ?>"><?= $p->bahan_nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Panjang</label>
                        <input type="text" name="panjang" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Lebar</label>
                        <input type="text" name="lebar" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Satuan</label>
                        <select name="satuan_id" class="form-control" data-plugin-selectTw>
                            <?php foreach ($satuan as $p): ?>
                                <option value="<?= $p->satuan_id ?>"><?= $p->satuan_nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
