<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                    <a href="#" class="btn btn-primary" disabled><?= $title ?></a>
                </div>
            </div>
            <div class="card-body">
            <form method="post" action="<?= base_url('manufaktur/actionUpdateproduct') ?>">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-5">
                        <select name="kategori_id" id="kategori_id" class="form-select">
                        <?php foreach ($kategori as $kat): ?>
                            <option value="<?= $kat->kategori_id ?>" 
                                <?= ($kat->kategori_id == $getproduct['kategori_id']) ? 'selected' : '' ?>>
                                <?= $kat->kategori_nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    </div>
                    <div class="col-sm-5">
                        <select name="subkategori_id" id="subkategori_id" class="form-select">
                            <option value="0">-- Pilih Sub Kategori --</option>
                            <?php foreach($subkategori as $k): ?>
                                <option value="<?= $k->subkategori_id ?>" <?= ($k->subkategori_id == $getproduct['subkategori_id']) ? 'selected' : '' ?>>
                                    <?= $k->subkategori_nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Bahan</label>
                    <div class="col-sm-10">
                        <?php if ($this->uri->segment(3) == null): ?>
                            <select name="bahan_id" id="bahan_id" class="form-select">
                                <option value="">-- Pilih Bahan Baku --</option>
                                <?php foreach($bahan as $k): ?>
                                    <option value="<?= $k->bahan_id ?>" <?= ($k->bahan_id == $getproduct['bahan_id']) ? 'selected' : '' ?>>
                                        <?= $k->bahan_nama ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input type="text" class="form-control" value="<?= $getproduct['bahan_nama'] ?>" readonly>
                            <input type="hidden" name="product_id" value="<?= $getproduct['product_id'] ?>">
                            <input type="hidden" name="bahan_id" value="<?= $getproduct['bahan_id'] ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nama <?= $controller ?></label>
                    <div class="col-sm-5">
                        <input type="text" name="product_nama" class="form-control" required placeholder="Nama Product" value="<?= $getproduct['product_nama'] ?>">
                    </div>
                    <div class="col-sm-3">
                        <select name="tipe_id" id="tipe_id" class="form-select">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($type as $k): ?>
                                <option value="<?= $k->tipe_id ?>" <?= ($k->tipe_id == $getproduct['tipe_id']) ? 'selected' : '' ?>>
                                    <?= $k->tipe_nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="satuan_id" id="satuan_id" class="form-select">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach($satuan as $k): ?>
                                <option value="<?= $k->satuan_id ?>" <?= ($k->satuan_id == $getproduct['satuan_id']) ? 'selected' : '' ?>>
                                    <?= $k->satuan_nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
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
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Keterangan <?= $controller ?></label>
                    <div class="col-sm-10">
                        <textarea name="product_deskripsi" class="form-control" rows="3" style="white-space: pre-wrap; font-family: Lato;">
                            <?= htmlspecialchars($getproduct['product_deskripsi']) ?>
                        </textarea>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url($controller.'/') ?>" class="btn btn-warning">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
    <div class="row p-4">
        <div class="card">
            <div class="card-header">
                Skala Harga
            </div>
            <div class="card-body">
                <?php
                $kategori_id    = $getproduct['kategori_id'];
                $subkategori_id = $getproduct['subkategori_id'];

                if ($kategori_id == '1') {
                    $this->load->view('admin/product/add_harga/kategori_1');
                } elseif ($kategori_id == '2') {
                    $this->load->view('admin/product/add_harga/kategori_2');
                } elseif ($kategori_id == '10') {
                    $this->load->view('admin/product/add_harga/kategori_3');
                }
                ?>
            </div>
        </div>
    </div>
</div>
