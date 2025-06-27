<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="<?= base_url('gudang/tambah-pengiriman')?>" class="btn btn-primary">Tambah Pengambilan Barang</a> 
            </div>
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <!-- Jumlah Data : <?= $total_rows ?> -->
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="mb-md">
                                <!-- <a href="<?= base_url($controller.'/formAdd')?>" class="btn btn-primary">Add <?= $controller ?> <i class="fa fa-plus"></i></a>
                                <a href="<?= base_url($controller.'/formAdd')?>" class="btn btn-success">Cetak <?= $controller ?> <i class="fa fa-print"></i></a> -->
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-details">		
								
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pembelian</th>
                                <th>Nama Petugas</th>
                                <th>Lokasi Pengiriman</th>
                                
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no =1;
                                foreach ($tampilData as $dt){
                            ?>
                            <tr >
                                <td><?= $no ?></td>
                                
                                <td><?= date_indo($dt->pengambilan_tgl) ?></td>
                                <td><?= $dt->nama_lengkap ?></td>
                                <td><?= $dt->gudang_nama ?></td>
                                
                                <td class="actions text-center">
                                    <a href="<?= base_url('gudang/detailPengambilan/'.$dt->pengambilan_id)?>" class="btn btn-warning btn-xs"><i class="fa fa-list"></i> </a>
                                    <a href="<?= base_url('gudang/cetakPengambilan/'.$dt->pengambilan_id)?>" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>
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