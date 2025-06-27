
    <div class="row">
        <section class="panel">  
            <div class="panel-body">
                <!-- <?= $divisi ?> -->
                <table class="table table-bordered table-striped mb-none" id="datatable-details">		
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>SPK</th>
                            <th>Dateline</th>
                            <th>Bahan</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Operator / Mesin</th>
                            <th>Produksi</th>
                            <!-- <th>Finishing</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $no =1;
                            foreach ($tampilData as $dt){
                                if ($dt->status_produksi == '0'){
                                    $status = '<button class="btn btn-warning btn-block btn-sm disabled">Menunggu</button>';
                                }elseif ($dt->status_produksi == '1'){
                                    $status = '<button class="btn btn-primary btn-block disabled btn-sm">On Proses</button>';
                                }elseif ($dt->status_produksi == '2'){
                                    $status = '<button class="btn btn-danger btn-block disabled btn-sm">PB</button>';
                                }else{
                                    $status = '<button class="btn btn-success btn-block disabled btn-sm">Selesai</button>';
                                }
                        ?>
                        <tr >
                            <td><?= $no ?></td>
                            <td>
                                <?= $dt->nospk ?> <br>
                                <?= $dt->operator_nama ?>
                            </td>
    
                            <td>
                                <?= date_indo($dt->dateline_tgl) ?><br>
                                <?= $dt->dateline_jam ?>
                            </td>
                            <td>
                                Bahan Utama : <?= $dt->bahan_nama ?> <br>
                                Nama Product : <?= $dt->product_nama ?>
                            
                            <td class="text-center">
                                <?= $dt->qty ?>
                                <br>
                                <?php 
                                    if (($dt->panjang <> '0.00') OR ($dt->lebar <> '0.00')){
                                ?>
                                <?= $dt->panjang ?> x <?= $dt->lebar ?>
                                <?php 
                                    }
                                ?>
                            </td>
                            
                            <td class="text-center">
                                
                                <?= $status ?>
                                <a class="btn btn-primary btn-block btn-sm" href="<?= base_url('transaksi/cek_invoice/'.$dt->nospk.'/'.$dt->produksi_id)?>">
                                    <i class="fa fa-edit"> </i> Cek Invoice 
                                </a>
                            </td>
                            <td>
                                <?= $dt->operator_nama ?> <br>
                                <?= $dt->operator_keterangan ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalProses<?= $dt->produksi_id ?>">
                                    <i class="fa fa-cogs"></i> Proses
                                </button>
                            </td>
                        </tr>
                        
                        </div>
                        <?php 
                            $no++;
                            }
                        ?>
                        <?php foreach ($tampilData as $dt): ?>
                            <div class="modal fade" id="modalProses<?= $dt->produksi_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $dt->produksi_id ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="<?= base_url('produksi/proses') ?>" method="post">
                                <input type="hidden" name="produksi_id" value="<?= $dt->produksi_id ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel<?= $dt->produksi_id ?>">Proses Produksi - <?= $dt->nospk ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    
                                    <div class="modal-body">
                                    
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input type="text" value="<?= $dt->product_nama ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Qty Pesan</label>
                                        <input type="text" value="<?= $dt->qty ?>" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Qty Produksi</label>
                                        <input type="text" value="<?= $dt->qty_produksi ?>" name="qty_produksi" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Masukkan Panjang</label>
                                        <input type="text" name="panjang_produksi" class="form-control" value="<?= $dt->panjang ?>" readonly>
                                        <input type="text" value="<?= $dt->panjang_produksi ?>" class="form-control" placeholder="Masukkan Panjang">
                                        <div class="input-group-append">
                                            <span class="input-group-text">meter</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Masukkan Lebar</label>
                                        <input type="text" name="lebar_produksi" class="form-control" value="<?= $dt->lebar ?>" readonly>
                                        <input type="text" value="<?= $dt->lebar_produksi ?>" class="form-control" placeholder="Masukkan Lebar">
                                        <div class="input-group-append">
                                            <span class="input-group-text">meter</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Status Produksi</label>
                                        <select class="form-control" name="status_produksi" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="1" <?= $dt->status_produksi == '1' ? 'selected' : '' ?>>Sedang Berjalan</option>
                                            <option value="2" <?= $dt->status_produksi == '2' ? 'selected' : '' ?>>PB (Perbaikan)</option>
                                            <option value="3" <?= $dt->status_produksi == '3' ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                    </div>
                                    </div>

                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            </div>
                            <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </section>
    <!-- end: page -->
</section>
</div>








