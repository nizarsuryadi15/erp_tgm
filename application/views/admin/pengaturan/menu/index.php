<div class="row">
<section class="panel">  
        <div class="panel-body">
            <div class="row">
                
                <div class="col-sm-6">
                    Jumlah Data : <?= $jmlmenu ?>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="mb-md">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahLembur">
                        Tambah Mesin
                    </button>
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered table-striped mb-none" id="datatable-details">		
                        
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>                                
                        <th>Alias</th>
                        <th>Icon</th>
                        <th>Link</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no =1;
                        foreach ($menu as $dt){
                            $status = ($dt->status == 1) ? 'Aktif' : 'Tidak Aktif';
                    ?>
                    <tr >
                        <td><?= $no ?></td>
                        <td><?= $dt->nama_menu ?></td>
                        <td>
                                <?= $dt->alias ?>
                            
                        </td>
                        <td class="text-center">
                            
                                <i class="<?= $dt->icon ?>"> </i>
                            
                        </td>
                         <td>
                                <?= $dt->link ?>
                            
                        </td>
                        <td class="actions text-center" >
                            <a href="<?= base_url('menu/submenu/'.$dt->id)?>" class="btn btn-success"><i class="fa fa-list"></i> Sub Menu</a>
                            <a href="<?= base_url('menu/edit-menu/'.$dt->id)?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                            <a href="<?= base_url('menu/delete-menu/'.$dt->id)?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
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

<div class="modal fade" id="modalTambahLembur" tabindex="-1" role="dialog" aria-labelledby="modalLabelLembur" aria-hidden="true">
<div class="modal-dialog" role="document">
<form id="waForm" method="POST" action="<?= base_url('mesin/aksi-simpan')?>" novalidate>
<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="modalLabelLembur">Tambah Data Mesin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>   
    </div>
    
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Mesin</label>
            <input type="text" name="mesin_nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Keterangan Mesin</label>
            <input type="text" name="mesin_keterangan" class="form-control" required>
        </div>
         <div class="form-group">
            <label>Kategori Mesin</label>
            <select name="kategori" id="" class="form-control">
                <option value="Produksi">Produksi</option>
                <option value="Finishing">Finishing</option>
            </select>
        </div>

        <div class="modal-footer">
        <button type="submit" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    </div>
</form>
</div>
</div>