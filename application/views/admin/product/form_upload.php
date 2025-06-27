<div class="panel panel-heading">
    <h4 class="panel-heading">Upload Gambar <?= $product['product_nama']?></h4>
</div>
    <div class="panel panel-body">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?= base_url($controller.'/actionuploadaproduct')?>">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDisabled">Gambar Sekarang </label>
                    <div class="col-md-5">
                        <img width="30%" class="img img-responsive img-thumbnail img-thumbnail-hover-icon" src="<?= base_url('assets/images/product/'.$product['product_img_1']) ?>">
                    </div>
                </div>
                    
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDisabled">Upload Gambar 1 </label>
                    <div class="col-md-10">
                        <input type="hidden" name="product_id" value="<?= $product['product_id']?>">
                        <input type="file" name="product_img_1" class="form-control">
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-md-12" >
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <a href="<?= base_url($controller.'/product') ?>" class="btn btn-warning">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

