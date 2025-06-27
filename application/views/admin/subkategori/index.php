
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
                                <a href="<?= base_url($controller.'/formAdd')?>" class="btn btn-primary">Add Sub Kategori <i class="fa fa-plus"></i></a>
                                <a href="<?= base_url($controller.'/formAdd')?>" class="btn btn-success">Cetak <?= $controller ?> <i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-details">		
								
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th width="25%">Sub Kategori</th>
                                <th width="25%">Keterangan</th>
                                <th width="10%">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no =1;
                                foreach ($tampilData as $dt){
                                    $status = ($dt->status == '1') ? '<span class="badge badge-primary">Aktif</span>' : '<span class="badge badge-warning">Tidak Aktif</span>';
                            ?>
                            <tr >
                                <td><?= $dt->subkategori_id ?></td>
                                
                               
                                <td><?= $dt->subkategori_nama ?></td>
                                
                                <!-- <td><?= character_limiter($dt->ketegori_uri,20) ?></td> -->
                                <td class="text-center" width="20%">
                                    <p class="text-left">
                                        <?= character_limiter($dt->subkategori_deskripsi,20) ?>
                                    </p>
                                </td>
                                <td class="text-center"><?= $status ?></td>
                                
                                
                                <td class="actions text-center" >
                                    <a class="btn btn-primary" href="<?= base_url($controller.'/viewData/'.$dt->subkategori_id)?>" ><i class="fa fa-list"></i></a>
                                    <a class="btn btn-success" href="<?= base_url($controller.'/formUpdate/'.$dt->subkategori_id)?>"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-danger" href="<?= base_url($controller.'/actionDelete/'.$dt->subkategori_id)?>"><i class="fa fa-trash-o"></i></a>
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