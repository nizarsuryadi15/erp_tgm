
<?php 
    $bom_data = $this->M_master->getbombykode($getproduk['product_id'])->row(); 
?>

<?php 
    if ($getproduk['tipe_id'] == '1'){
?>
<div class="row mb-3">
        <label for="kategori_id" class="col-sm-2 col-form-label">Ukuran</label>
    <div class="col-sm-10">
        <div class="input-group mb-md">
            <div class="col-sm-5">
                <input type="text" class="form-control" name="panjang" placeholder="Panjang"
                    value="<?= isset($bom_data->panjang) ? $bom_data->panjang : '' ?>">
            </div>
            <div class="col-sm-2 text-center"> x </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="lebar" placeholder="Lebar"
                    value="<?= isset($bom_data->lebar) ? $bom_data->lebar : '' ?>">
            </div>
        </div>
    </div>    
</div>

<div class="row mb-3">
    <label for="kategori_id" class="col-sm-2 col-form-label">Pilihan Mata</label>
    <div class="col-sm-10">
        <div class="input-group mb-md">
            <select name="jenisprint_id" class="form-select">
                <option value="">-- Pilih Jenis Print --</option>
                <option value="1">
                    Outdoor Solvent
                </option>
                <option value="2">
                    Indoor Eco-Solvent
                </option>
                <option value="3">
                    Indoor UV
                </option>
            </select>
        </div>
    </div>
</div>
<?php 
    }
?>
