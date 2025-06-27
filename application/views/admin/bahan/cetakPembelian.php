

        <!-- start: page -->
        <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title"> <a href="<?= base_url('gudang/DaftarPembelian')?>">Kembali</a> -- <?= $title ?> </h2>
                </header>
                <div class="panel-body">

                        <table class="table">
                            <tr>
                                <td width="15%">Nama Supplier</td>
                                <td width="5%">:</td>
                                <td><?= $getData['supplier_nama']?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembelian</td>
                                <td>:</td>
                                <td><?= date_indo($getData['pembelian_tgl']) ?></td>
                            </tr>
                        </table>
                        
                        <hr>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bahan</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $no = 1;
                                    foreach ($tampilData as $key => $value) {
                                        @$jumlah = $value->pemb_qty * $value->pemb_harga;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $value->bahan_nama ?></td>
                                    <td class="text-right"><?= number_format($value->pemb_qty) ?></td>
                                    <td class="text-right"><?= number_format($value->pemb_harga) ?></td>
                                    <td class="text-right">
                                    Rp. <?= number_format($jumlah) ?>
                                    </td>
                                </tr>
                                <?php
                                    $no++;
                                    }
                                ?>
                                <tr>
                                    <td colspan="4" class="text-right">Jumlah</td>
                                    <td class="text-right">Rp. <?= number_format($getData['pembelian_total']) ?>,-</td>
                                </tr>
                                
                            </tbody>
                        </table>
                        
                        
                    
                    
                
                    
                </div>
            </section>
        <!-- end: page -->
    </section>

</div>