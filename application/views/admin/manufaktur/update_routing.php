<div class="row">
    <section class="panel">
        <header class="panel-heading">
            <a class="btn btn-dark" href="<?= base_url('product')?>">Kembali</a>
            <button disabled class="btn btn-dark"><?= $title ?></button>
        </header>
        <div class="panel-body">
            <section class="panel form-wizard" id="w2">
                <form action="<?= base_url('manufaktur/action_update_routing/' . $routing['routing_id']) ?>" method="post">
                    <div class="form-group">
                        <label for="routing_name">Routing Name</label>
                        <input type="text" name="routing_name" id="routing_name" class="form-control" value="<?= $routing['routing_name'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="product_id">Product</label>
                        <select name="product_id" id="product_id" class="form-control">
                            <?php foreach ($product_list as $p): ?>
                                <option value="<?= $p->product_id ?>" <?= ($p->product_id == $routing['product_id']) ? 'selected' : '' ?>>
                                    <?= $p->product_nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="routing_urutan">Routing Urutan</label>
                        <input type="number" name="routing_urutan" id="routing_urutan" class="form-control" value="<?= $routing['routing_urutan'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="mesin_id">Mesin</label>
                        <select name="mesin_id" id="mesin_id" class="form-control">
                            <?php foreach ($mesin_list as $m): ?>
                                <option value="<?= $m->mesin_id ?>" <?= ($m->mesin_id == $routing['mesin_id']) ? 'selected' : '' ?>>
                                    <?= $m->mesin_nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="durasi">Durasi (menit)</label>
                        <input type="number" name="durasi" id="durasi" class="form-control" value="<?= $routing['durasi'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"><?= $routing['keterangan'] ?></textarea>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?= ($routing['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>

                    <input type="hidden" name="created_at" value="<?= $routing['created_at'] ?>">

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </section>
        </div>
    </section>
</div>

