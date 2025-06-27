<table class="table">
    <thead>
        <tr>
            <th width="25%">Keteragan (Ini Akan Muncul di Faktur)</th>
            
            <th width="10%">Range</th>
            <th width="3%">Min Pembelian</th>
            <th width="15%">HPP</th>
            <th width="15%">Harga Jual</th>
            <?php 
                if ($this->session->userdata('level') == '1'){
            ?>
            <th width="5%">Action</th>
            <?php 
                }
            ?>
        </tr>
    </thead>
    <tbody>
        
    <form action="<?= base_url('manufaktur/action_save_all')?>" method="post">
        <?php 
        foreach ($getHarga as $hrg){
        ?>
        <tr>
            <td>
                <input type="hidden" class="form-control" name="segmen2" value="<?= $segment2 ?>">
                <input type="hidden" name="product_id" class="form-control" value="<?= $getproduct['product_id']?>">
                <input type="hidden" class="form-control" name="kategori_id[]" value="<?= $getProduct['kategori_id'] ?>">
                <input type="hidden" class="form-control" name="subkategori_id[]" value="<?= $getProduct['subkategori_id'] ?>">
                <input type="hidden" class="form-control" name="" value="<?= $hrg->harga_id ?>">
                <input type="text" name="detail_product[]" class="form-control" value="<?= $hrg->detail_product ?>">
            </td>
            
            <td>
                <select name="range_id[]" id="range_id" class="form-control">
                    <option value="-">-- Pilih --</option>
                    <?php foreach ($getRange as $value): ?>
                        <option value="<?= $value->range_id ?>" <?= $value->range_id == $hrg->range_id ? 'selected' : '' ?>>
                            <?= $value->range_text ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </td>
            <td>
                <input type="text" value="<?= $hrg->jml_minimum ?>" name="jml_minimum[]" class="form-control">
            </td>
            <td>
                <input type="hidden" name="harga_id[]" class="form-control" value="<?= $hrg->harga_id ?>">
                <div class="input-group">
                    <div class="input-group mb-md">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="harga_id" class="form-control" name="hpp[]" value='<?= $hrg->hpp ?>' onkeypress="return event.charCode >= 48 && event.charCode <=57">
                    </div>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <div class="input-group mb-md">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="hpp" class="form-control" name="harga_1[]" value='<?= $hrg->harga_1 ?>' onkeypress="return event.charCode >= 48 && event.charCode <=57">
                    </div>
                </div>
            </td>
            <?php 
                if ($this->session->userdata('level') == '1'){
            ?>
            <td class="text-center">
                
                <a href="<?= base_url($controller.'/del_harga/'.$hrg->harga_id.'/'.$getproduct['product_id'])?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
            </td>
            <?php 
                }
            ?>
        </tr>
        
        <?php 
            }
        ?>
        <?php 
        if ($this->session->userdata('level') == '1'){
        ?>
        <tr>
            <td colspan="8" class="text-center"><button type="submit" class="btn btn-primary btn-block">Simpan Semua</button></td>
        </tr>
        <?php 
        }
        ?>
    </form>
    <?php 
        if ($this->session->userdata('level') == '1'){
    ?>
        <tr>
            <td colspan="8" class="text-center">
                <form action="<?= base_url('manufaktur/addHarga')?>" method="post">

                    <input type="hidden" class="form-control" name="segmen2" value="<?= $segment2 ?>">
                    <input type="hidden" name="product_id" value="<?= $getProduct['product_id'] ?>">
                    <button type="submit" class="btn btn-warning btn-block">Tambah Harga</button></td>
                </form>
            </td>
        </tr>
    <?php 
        }
    ?>
    </tbody>
</table>

<script>
    // Format angka jadi Rupiah (dengan titik)
    document.querySelectorAll('input[name="harga_1[]"]').forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    });
</script>