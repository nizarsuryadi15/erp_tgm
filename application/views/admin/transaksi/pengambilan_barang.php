
<style type="text/css">
table {
    border-collapse: collapse;
    width: 100%;
    font-size: 12px;
}
</style>
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
                <div class="row">
                    
                    <div class="col-sm-6">
                        Jumlah Data : <?= $total_rows ?>
                        <!-- <?= $user ?>
                        <?= $divisi ?> -->
                    </div>
                    
                </div>
                
                <table class="table table-bordered table-striped mb-none" id="datatable-details">		
                            
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Surat Perintah Kerja</th>
                            <th>Nama Konsumen</th>
                        
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $no =1;
                            foreach ($tampilData as $dt){
                                
                                if ($dt->status_transaksi == '0'){
                                    $status = '<p class="text-warning">Pending</p>';
                                    
                                }elseif ($dt->status_transaksi == '1'){
                                    $status = '<p class="text-success">Proses</p>';
                                    
                                }elseif ($dt->status_transaksi == '2'){
                                    $status = '<p class="text-danger">Pengambilan Barang</p>';
                                }else{
                                    $status = '<p class="text-primary">Selesai</p>';
                                }
                        ?>
                        <tr >
                            <td><?= $no ?></td>
                            <td>
                                <?= $dt->nospk ?> <br>
                                <?= date_indo($dt->pembayaran_tgl) ?>
                            </td>
                            <td>
                                <?= $dt->konsumen_nama ?> <br>
                            
                            <td class="text-center">
                                
                                <?= $status ?>
                                <?= $button ?>
                            </td>
                        </tr>
                        <div class="modal fade" id="update_modal<?php echo $dt->id ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <form method="POST" action="<?= base_url('transaksi/proses_produksi')?>">
                                    <div class="modal-header">
                                    <h3 class="modal-title">Produksi Pemesanan</h3>
                                    </div>
                                    <div class="modal-body">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                        <label>Nama Bahan</label>
                                        <input type="hidden" name="id" value="<?php echo $dt->id?>"/>
                                        <input type="hidden" name="bahan_id" value="<?php echo $dt->bahan_id?>" class="form-control" required="required"/>
                                        <input type="hidden" name="nospk" value="<?php echo $dt->nospk?>" class="form-control" required="required"/>
                                        <input type="hidden" name="status" value="1" class="form-control" required="required"/>
                                        <input type="text" name="bahan_nama" value="<?php echo $dt->bahan_nama?>" class="form-control" required="required" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>QTY Pemesanan</label>
                                            <input type="text" name="qty" value="<?php echo $dt->qty?>" class="form-control" required="required" / readonly>
                                        </div>
                                        
                                        <?php 
                                            if (($dt->panjang <> '0.00') OR ($dt->lebar <> '0.00')){
                                                $luas = $dt->panjang * $dt->lebar;
                                        ?>
                                        <div class="form-group">
                                            <label>Jumlah Penggunaan Bahan</label>
                                            <div class="input-group mb-md">
                                                <span class="input-group-addon">M <sup>2</sup></span>
                                                <input type="text" name="penggunaan_bahan" class="form-control" required="required" value="<?= $luas ?>" > 
                                            </div>
                                        </div>
                                        <?php 
                                            }else{
                                        ?>
                                        <div class="form-group">
                                            <label>Jumlah Penggunaan Bahan</label>
                                            <input type="text" name="penggunaan_bahan" class="form-control" required="required" />
                                        </div>
                                        <?php 
                                            }
                                        ?>
                                    </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div class="modal-footer">
                                    <button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                                    </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
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








