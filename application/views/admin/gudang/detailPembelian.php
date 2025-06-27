<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                    <i class="bi bi-arrow-left"></i> Kembali
                </button>
            </div>

            <div class="card-body">
                  Nama Supplier : <?= $getData['supplier_nama']?> <br>
                        Tanggal Pembelian  : <?= date_indo($getData['pembelian_tgl']) ?> <br>
                      
                <?php
                    $total_pembelian = 0;
                    foreach ($tampilData as $value) {
                        $total_pembelian += $value->pemb_qty * $value->pemb_harga;
                    }
                ?>
                Jumlah Pembelian (Total Detail): Rp. <?= number_format($total_pembelian) ?>,-
                        <table class="table table-bordered table-hover">
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
                                    <td class="text-right"><?= $value->bahan_nama ?></td>
                                    <td class="text-right"><?= number_format($value->pemb_qty) ?></td>
                                    <td class="text-right">
                                        <form action="<?= base_url('gudang/updateHarga') ?>" method="post">
                                            <input type="hidden" name="pemb_detail_id" value="<?= $value->pemb_detail_id ?>">
                                            <input type="hidden" name="pembelian_id" value="<?= $pembelian ?>">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="pemb_harga" value="<?= number_format($value->pemb_harga) ?>">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($jumlah) ?>
                                    </td>
                                </tr>
                                <?php
                                    $no++;
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                        
                        
                    
                    
                
                    
                </div>
            </section>
        <!-- end: page -->
    </section>

</div>