<div class="row">
        <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title"><?= $title ?></h2>
                </header>
                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-sm-6">
                            Jumlah Data : <?= $total_rows ?>
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="mb-md">
                            <a href="#" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah User
                            </a>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped mb-none" id="datatable-details">		
								
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Roles</th>
                                
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
                                <td><?= $dt->username ?></td>
                                <td><?= $dt->role_nama ?></td>
                               
                               
                                
                                
                                <td class="actions text-center" >
                                    <a href="<?= base_url($controller.'/viewData/'.$dt->kategori_id)?>" class="btn btn-success"><i class="fa fa-list"></i></a>
                                    <a href="<?= base_url($controller.'/formUpdate/'.$dt->kategori_id)?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                                    <a href="<?= base_url($controller.'/actionDelete/'.$dt->kategori_id)?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambah Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url($controller.'/action_add')?>" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required class="form-control">
            <input type="hidden" id="active" name="active" value="1" required class="form-control">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required class="form-control">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required class="form-control">

            <label for="konfirmasi_password">Nama Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="form-control">
                    <?php 
                        foreach ($karyawan as $key => $kary) {
                ?>
                    <option value="<?= $kary->karyawan_id ?>"><?= $kary->karyawan_nama ?></option>

                <?php
                        }
                    ?>
            </select>
            <label for="konfirmasi_password">Divisi</label>
                <select name="divisi_id" id="divisi_id" class="form-control">
                    <?php 
                        foreach ($divisi as $key => $kary) {
                ?>
                    <option value="<?= $kary->divisi_id ?>"><?= $kary->divisi_nama ?></option>

                <?php
                        }
                    ?>
            </select>
            
            <hr>
            <input type="submit" value="Submit" class="btn btn-primary btn-block">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        
      </div>
    </div>
  </div>
</div>