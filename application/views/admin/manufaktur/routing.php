<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="panel-title"><?= $title ?> : <?= $getproduct['product_nama'] ?></h2>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <p>Jumlah Data: <?= $total_rows ?></p>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInputData">
                            <i class="fa fa-plus"></i> Tambah Routing
                        </button>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="datatable-detail">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Nama Product / Items</th>
                            <th width="15%">Nama Routing</th>
                            <th width="15%">Status</th>
                            <!-- <th width="15%">Mesin</th> -->
                            <th width="25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($tampilData as $dt): 
                            $status = ($dt->is_active == '1') ? 'Aktif' : 'Tidak Aktif';
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $dt->product_nama ?></td>
                                <td><strong><?= $dt->routing_name ?></strong></td>
                                <td><?= $status ?></td>
                                <!-- <td><?= $dt->mesin_nama ?></td> -->
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm" href="<?= base_url('manufaktur/updaterouting/' . $dt->routing_id) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="<?= base_url('manufaktur/aksideletestep/' . $dt->routing_id . '/' . $dt->product_id) ?>">
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

<!-- Modal Tambah Routing -->
<div class="modal fade" id="modalInputData" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('manufaktur/action_add_routing') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Routing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="product_id" value="<?= $getproduct['product_id'] ?>">
                    <div class="mb-3">
                        <label for="routing_urutan" class="form-label">Nomor Urut</label>
                        <input type="number" name="routing_urutan" id="routing_urutan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="routing_name" class="form-label">Nama Routing</label>
                        <input type="text" name="routing_name" id="routing_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="mesin_id" class="form-label">Operator</label>
                        <select name="mesin_id" id="mesin_id" class="form-control">
                            <?php foreach ($operator_list as $m): ?>
                                <option value="<?= $m->operator_id ?>">
                                    <?= $m->operator_nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="durasi" class="form-label">Durasi (menit)</label>
                        <input type="number" name="durasi" id="durasi" class="form-control" required>
                    </div> -->

                    <!-- <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    </div> -->

                    <!-- <div class="form-check mb-3">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1">
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div> -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
