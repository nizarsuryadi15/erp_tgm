

        <!-- start: page -->
        <section class="panel">
                <header class="panel-heading">
                    <a href="javascript:history.back()" class="btn btn-dark">Kembali</a>
                </header>
                <div class="panel-body">
                    
                    <form class="form-horizontal form-bordered" method="post" action="<?= base_url('bahan/actionUpdate')?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Barcode </label>
                        <div class="col-md-9">

                            <input name="barcode" class="form-control" id="bahan_nama" type="text" value ="<?= $getlist['barcode']  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Nama Bahan </label>
                        <div class="col-md-9">
                            <input name="bahan_id" class="form-control" id="bahan_id" type="hidden" value ="<?= $getlist['bahan_id']  ?>">
                            <input name="bahan_nama" class="form-control" id="bahan_nama" type="text" value ="<?= $getlist['bahan_nama']  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Satuan Gudang</label>
                        <div class="col-md-9">
                            <select name="satuan_gudang" id="kategori_id" class="form-control">
                                <option value="">-- Pilih Satuan --</option>
                                <?php foreach($satuan as $k): 
                                    
                                    if ($k->satuan_id == $getlist['satuan_gudang']) {
                                        echo "<option value='$k->satuan_id' selected>$k->satuan_nama</option>";
                                    } else {
                                        echo "<option value='$k->satuan_id'>$k->satuan_nama</option>";
                                    }
                                ?>
                                    
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Produk / Jasa</label>
                        <div class="col-md-9">
                            <select name="product_jasa" id="kategori_id" class="form-control">
                                <?php
                                    if ($getlist['product_jasa'] == '1'){
                                ?>
                                <option value="1" selected>Produk</option>
                                <option value="0">Jasa</option>
                                <?php
                                    }else{
                                ?>
                                <option value="1" >Produk</option>
                                <option value="0" selected>Jasa</option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group text-center">
                        <div class="col-md-12" >
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url($controller.'/') ?>" class="btn btn-warning">Batal</a>
                        </div>
                    </div>
                    
                        
                    </div>

                </form>
            </div>
        </section>

    </div>
</div>