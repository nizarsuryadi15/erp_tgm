

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
            <h3 class="text-weight-semibold text-left text-dark text-uppercase mb-md mt-lg"> Status Pesanan </h3>
            <hr>
            <div class="row">
            <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-warning">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">SPK on Day</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_rows ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-primary">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-calculator"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transaction This Month</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_trx['total']); ?>,- </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-uppercase" href="<?= base_url('penjualan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-calculator"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transaction On Day</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_trxday['total']); ?>,- </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-uppercase" href="<?= base_url('penjualan/onday') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-warning">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-calculator"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Credit On Day</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_piutang['total']); ?>,- </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-danger">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Cash On Day Rp. </h4>
                                        <div class="info">
                                            <strong class="amount"><?= number_format($total_cash_day['total']) ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan/onday/1') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-info">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Transfer On Day Rp.</h4>
                                        <div class="info">
                                            <strong class="amount"><?= number_format($total_trf_day['total']) ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan/onday/2') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">EDC On Day Rp. </h4>
                                        <div class="info">
                                            <strong class="amount"><?= number_format($total_edc_day['total']) ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan/onday/3') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-success">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">E-Wallet On Day Rp.</h4>
                                        <div class="info">
                                            <strong class="amount"><?= number_format($total_wal_day['total']) ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan/onday/4') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-4 col-xl-4">
                    <section class="panel">
                        <div class="panel-body bg-warning">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Bayar Piutang Rp.</h4>
                                        <div class="info">
                                            <strong class="amount"><?= number_format($bayar_piutang['total']) ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-danger">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-life-ring"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Bahan Baku</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_bahan ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('bahan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-info">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Product</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_product ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('bahan') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-success">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Konsumen</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_konsumen ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('konsumen') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-primary">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Deskprint</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_desk ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('profile/daftarpengguna') ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
            </div>
        </div>
    
</section>