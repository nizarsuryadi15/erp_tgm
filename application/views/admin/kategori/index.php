

        <div class="row">
            <section class="panel">
                <header class="panel-heading">
                    
        
        
                </header>
                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-sm-6">
                            Jumlah Data : <?= $total_rows ?>
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="mb-md">
                                <a href="<?= base_url($controller.'/addkategori')?>" class="btn btn-primary">Add Kategori <i class="fa fa-plus"></i></a>
                                <!-- <a href="<?= base_url($controller.'/formAdd')?>" class="btn btn-success">Cetak <?= $controller ?> <i class="fa fa-print"></i></a> -->
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-details">		
								
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <!-- <th>Kategori URL</th> -->
                                
                                <th>Kategori Keterangan</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no =1;
                                foreach ($tampilData as $dt){
                                    $status = ($dt->status == 1) ? 'Aktif' : 'Tidak Aktif';
                            ?>
                            <tr >
                                <td><?= $no ?></td>
                                <td><?= $dt->kategori_nama ?></td>
                                <!-- <td><?= $dt->kategori_url ?></td> -->
                                <td class="text-center" width="40%">
                                    <p class="text-left">
                                    <?= $dt->kategori_deskripsi ?>
                                    </p>
                                </td>
                                <td><?= $status ?></td>
                                
                                
                                <td class="actions text-center" >
                                    <a class="btn btn-primary" href="<?= base_url($controller.'/viewData/'.$dt->kategori_id)?>" ><i class="fa fa-list"></i></a>
                                    <a class="btn btn-success" href="<?= base_url($controller.'/updatekategori/'.$dt->kategori_id)?>"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" href="<?= base_url($controller.'/actionDelete/'.$dt->kategori_id)?>"><i class="fa fa-trash-o"></i></a>
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