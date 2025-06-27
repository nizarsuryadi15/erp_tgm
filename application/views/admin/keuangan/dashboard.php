

<!-- start: page -->
<section class="panel text-center">
<!-- <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>
            
                    <h2 class="panel-title"><?= $title ?></h2>
                </header> -->
    <div class="col-md-12 col-lg-12 col-xl-12">
            <h3 class="text-weight-semibold text-left text-dark text-uppercase mb-md mt-lg"> Status Keuangan Bulanan <?= date_indo(date('Y-m')) ?></h3>
            <hr>
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Transaksi</h4>
                                        <div class="info">
                                            <strong class="amount">Rp.<?= number_format($total_trx['total']) ?>,-</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/kategori') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Piutang</h4>
                                        <div class="info">
                                            <strong class="amount">Rp.<?= number_format($total_piutang['total']) ?>,</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/subkategori') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transaksi Cash</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_cash['total']) ?>,-</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/bahan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transaksi EDC / TF</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_noncash['total']) ?>,-</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/product') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
            </div>
            <h3 class="text-weight-semibold text-left text-dark text-uppercase mb-md mt-lg"> Status Keuangan Harian <?= date_indo(date('Y-m-d')) ?></h3>
            <hr>
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Transaksi</h4>
                                        <div class="info">
                                            <strong class="amount">Rp.<?= number_format($total_trxday['total']) ?>,-</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/kategori') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Piutang</h4>
                                        <div class="info">
                                            <strong class="amount">Rp.<?= number_format($total_piutang['total']) ?>,</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/subkategori') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transaksi Cash</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_cash['total']) ?>,-</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/bahan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transaksi EDC / TF</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_noncash['total']) ?>,-</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('inventori/product') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
            </div>
            
        </div>
    
</section>