

        <!-- start: page -->
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>
            
                    <h2 class="panel-title"><?= $title ?></h2>
                </header>
                <div class="panel-body">
                    
                    <form class="form-horizontal form-bordered" method="post" action="<?= base_url('kategori/actionUpdate')?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">ID <?= $controller ?></label>
                        <div class="col-md-6">
                            <input name="kategori_id" type="text" class="form-control" id="inputDefault" value ="<?= $getlist['kategori_id']  ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Urutan <?= $controller ?></label>
                        <div class="col-md-6">
                            <input name="kategori_urutan" class="form-control" id="kategori_urutan" type="text" value ="<?= $getlist['kategori_urutan']  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Nama <?= $controller ?></label>
                        <div class="col-md-6">
                            <input name="kategori_nama" class="form-control" id="kategori_nama" type="text" value ="<?= $getlist['kategori_nama']  ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Keterangan <?= $controller ?></label>
                        <div class="col-md-6">
                            <textarea name="kategori_deskripsi" class="form-control" id="kategori_deskripsi">
                                <?= $getlist['kategori_deskripsi']?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Status <?= $controller ?></label>
                        <div class="col-md-6">
                            <?php 
                                if ($getlist['status'] == 1) {
                                    echo '<input type="radio" name="status" value="1" checked> Aktif <br>';
                                    echo '<input type="radio" name="status" value="0"> Tidak Aktif';
                                } else {
                                    echo '<input type="radio" name="status" value="1"> Aktif <br>';
                                    echo '<input type="radio" name="status" value="0" checked> Tidak Aktif';
                                }
                            ?>
                           
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