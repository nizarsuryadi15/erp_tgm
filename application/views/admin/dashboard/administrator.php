<section class="panel text-center">
    <div class="col-md-12 col-lg-12 col-xl-12">
            <h3 class="text-weight-semibold text-center text-dark text-uppercase mb-md mt-lg"> Status Pesanan </h3>
            <hr>
            <div class="row">
            <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-download"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Perlu Di Proses</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_belumbayar ?></strong>
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
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-print"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Sedang di Proses</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $total_sudahbayar ?></strong>
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
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-check"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Selesai Produksi</h4>
                                        <div class="info">
                                            <strong class="amount"> </strong>
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
                <div class="col-md-3 col-xl-3">
                    <section class="panel">
                        <div class="panel-body bg-dark">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon">
                                        <i class="fa fa-upload"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Diambil Konsumen</h4>
                                        <div class="info">
                                            <strong class="amount"></strong>
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
            </div>
            
                <h3 class="text-weight-semibold text-left text-dark text-uppercase mb-md mt-lg"> Performa Toko </h3>
            
                <hr>
                <div class="row">
                    <div class="col-md-3 col-xl-3">
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
                                        <h4 class="title">Total Penjualan Kemarin</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_kemarin['total']) ?>,- </strong>
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
                <div class="col-md-3 col-xl-3">
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
                                        <h4 class="title">Total Penjualan Hari ini</h4>
                                        <div class="info">
                                            <strong class="amount">Rp. <?= number_format($total_trxday['total']); ?>,- </strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                    <a class="text-uppercase" href="<?= base_url('penjualan/onday/1') ?>"> View</a>
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
                                        <i class="fa fa-file"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Penjualan Produk Kemarin</h4>
                                        <div class="info">
                                            <strong class="amount"><?= number_format($total_penj_kemarin['total']) ?></strong>
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
                <div class="col-md-3 col-xl-3">
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
                                        <h4 class="title">Total Penjualan Produk Hari ini</h4>
                                        <div class="info">
                                        <strong class="amount"><?= number_format($total_penj_hariini['total']) ?></strong>
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
                
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                        </div>
        
                        <h2 class="panel-title">Performa Toko <?= $perusahaan ?></h2>
                        <p class="panel-subtitle">Grafik Penjualan </p>
                    </header>
                    <div class="panel-body">
                        
                        <!-- Flot: Bars -->
                        <div class="chart chart-md" id="flotBars"></div>
                        <script type="text/javascript">
                            var flotBarsData = [
                                ["Jan", <?= $jan['total']?>],
                                ["Feb", <?= $feb['total']?>],
                                ["Mar", <?= $mar['total']?>],
                                ["Apr", <?= $apr['total']?>],
                                ["May", <?= $mei['total']?>],
                                ["Jun", <?= $jun['total']?>],
                                ["Jul", <?= $jul['total']?>],
                                ["Aug", <?= $ags['total']?>],
                                ["Sep", <?= $sept['total']?>],
                                ["Oct", <?= $okt['total']?>],
                                ["Nov", <?= $nov['total']?>],
                                ["Dec", <?= $des['total']?>]
                            ];
        
                            // See: assets/javascripts/ui-elements/examples.charts.js for more settings.
        
                        </script>
        
                    </div>
                </section>
            </div>
    
</section>