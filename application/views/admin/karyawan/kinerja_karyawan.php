<div class="row">
    <section class="panel">
            <header class="panel-heading">
            </header>
            <div class="panel-body">
                
                
                <table class="table table-bordered table-striped mb-none" id="datatable-detail">		
                        <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Jabatan</th>
                            <th>Jumlah Transaksi SPK</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($karyawan)) : ?>
                            <?php $no = 1; foreach ($karyawan as $k) : ?>
                                
                            <?php $jumlah_transaksi = $this->M_master->jml_spk($k->user_id)->row_array(); ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $k->nama_lengkap ?> <?= $k->user_id ?></td>
                                <td><?= ($k->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan' ?></td>
                                
                                <td><?= $k->nama_jabatan ?></td>
                                <td><?= $jumlah_transaksi['jum']?></td>
                                
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                            
                            
                            
                        
                    
            </div>
        
        <!-- end: page -->
    </section>
</div>