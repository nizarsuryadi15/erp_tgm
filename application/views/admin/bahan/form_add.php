
<div class="row">
        <!-- start: page -->
            <section class="panel">
                <div class="panel-body">
                <h2 class="panel-title"><?= $title ?></h2>
                <hr>
                    <form class="form-horizontal form-bordered" method="post" action="<?= base_url('bahan/actionAdd')?>">
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Nama Bahan</label>
                        <div class="col-md-6">
                            <input name="subkategori_nama" class="form-control" id="subkategori_nama" type="text" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Keterangan Bahan</label>
                        <div class="col-md-6">
                            <textarea name="subkategori_deskripsi" class="form-control" id="subkategori_deskripsi"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Status Bahan</label>
                        <div class="col-md-6">
                            <input type="radio" name="status" value="1"> Aktif <br>
                            <input type="radio" name="status" value="0"> Tidak Aktif
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