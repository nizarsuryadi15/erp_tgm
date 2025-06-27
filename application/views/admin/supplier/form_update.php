<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title"><a href="<?= base_url('inventori/supplier')?>">Kembali</a> Update Bahan</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal"  method="post" action="<?= base_url($controller.'/actionupdatebahan')?>">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">ID Supplier</label>
                        <div class="col-md-9">
                            <input name="bahan_id" type="text" class="form-control" id="inputDefault" value ="<?= $getlist['supplier_id'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Kode Supplier </label>
                        <div class="col-md-9">
                            <input name="barcode" class="form-control" id="barcode" type="text" value ="<?= $getlist['supplier_kode']  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Nama Supplier</label>
                        <div class="col-md-9">
                            <input name="supplier_nama" class="form-control" id="supplier_nama" type="text" value ="<?= $getlist['supplier_nama']  ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Alamat Supplier</label>
                        <div class="col-md-9">
                            <input name="supplier_alamat" class="form-control" id="supplier_alamat" type="text" value ="<?= $getlist['supplier_alamat']  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">No HP Supplier</label>
                        <div class="col-md-9">
                            <input name="supplier_nama" class="form-control" id="supplier_nama" type="text" value ="<?= $getlist['supplier_nama']  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDisabled">Supplier Email</label>
                        <div class="col-md-9">
                            <input name="supplier_email" class="form-control" id="supplier_email" type="text" value ="<?= $getlist['supplier_email']  ?>">
                        </div>
                    </div>
                
                    
                    <div class="form-group text-center">
                        <div class="col-md-12" >
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url($controller.'/bahan') ?>" class="btn btn-warning">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        </div>
    </div>
</div>