
<?php 
    if ($getproduk['subkategori_id']=='13'){
?>
    <div class="row mb-3">
        <label for="kategori_id" class="col-sm-2 col-form-label">Pilihan Mata</label>
        <div class="col-sm-10">
            <div class="input-group mb-md">
                <select name="ket_1" id="ket_1" class="form-control col-md-9 col-xs-12">
                    <option value="">-- Pilih Mata --</option>
                    <?php foreach ($mata as $sd): ?>
                        <option value="<?= $sd->id_mata ?>" <?= ($sd->id_mata == $hrg->ket_1) ? 'selected' : '' ?>>
                            <?= $sd->keterangan_mata ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
<?php
    }else{
?>
    <div class="row mb-3">
        <label for="kategori_id" class="col-sm-2 col-form-label">Pilihan Sisi</label>
        <div class="col-sm-10">
            <div class="input-group mb-md">
                <select name="ket_1" id="ket_1" class="form-control col-md-9 col-xs-12">
                    <option value="">-- Pilih Side --</option>
                    <?php foreach ($side as $sd): ?>
                        <option value="<?= $sd->side_id ?>" <?= ($sd->side_id == $hrg->ket_1) ? 'selected' : '' ?>>
                            <?= $sd->side_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
<?php 
    }
?>

    
                