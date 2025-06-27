<div class="row">
    <section class="panel form-wizard" id="w2">
        <header class="panel-heading dark">
            <a href="<?= base_url($controller.'/product')?>" class="btn btn-warning"><I class="fa fa-backward"></I> Kembali </a> 
            <a href="#" class="btn btn-success"><?= $getProduct['product_nama']?> <?= $getProduct['kategori_id'] ?> <?= $getProduct['subkategori_id'] ?></a>
        </header>
        <div class="panel-body">
            <div class="tabs">
                <ul class="nav nav-tabs nav-justify">
                    <li class="active">
                        <a href="#w2-account" data-toggle="tab" class="text-center">
                            <span class="badge hidden-xs">1</span>
                            Product
                        </a>
                    </li>
                    <li>
                        <a href="#w2-profile" data-toggle="tab" class="text-center">
                            <span class="badge hidden-xs">2</span>
                            Detail Product (Harga)
                        </a>
                    </li>
                    <li>
                        <a href="#w2-manufactur" data-toggle="tab" class="text-center">
                            <span class="badge hidden-xs">3</span>
                            Manufactur
                        </a>
                    </li>
                    <li>
                        <a href="#w2-gambar" data-toggle="tab" class="text-center">
                            <span class="badge hidden-xs">4</span>
                            Gambar Product
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div id="w2-account" class="tab-pane active">
                        <?php
                            $this->load->view('admin/inventori/product/form_update');
                        ?>
                    </div>
                    <div id="w2-profile" class="tab-pane">
                        <?php 
                            $this->load->view('admin/inventori/product/detail');
                        ?>
                    </div>
                    <div id="w2-manufactur" class="tab-pane">
                        <?php 
                            $this->load->view('admin/inventori/product/manufactur');
                        ?>
                    </div>
                
                
            </div>
        <div>
    </section>
</div>

