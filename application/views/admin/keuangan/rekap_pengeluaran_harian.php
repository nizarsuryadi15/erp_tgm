<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }
    form#input[type=text] {
        font-size: 12px;
    }
</style>
<div class="row">
        <!-- start: page -->
        <section class="panel">
                
                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-md-12 text-center">
                        <a class="mb-xs mt-xs mr-xs modal-basic btn btn-primary btn-xs" href="#AddPengeluaran">Tambah Pengeluaran</a>
                            <br>
                            
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Kategori Pengeluran</th>
                                        <th width="30%">Total Pengeluaran</th>  
                                    </tr>
                                    <?php 
                                        $no = 1;
                                        foreach ($kategori as $key => $value) {
                                            $total_pengeluaran = $this->db->query("SELECT SUM(pengeluaran_jumlah) as total_pengeluaran FROM tbl_pengeluaran_harian WHERE kategori_pengeluaran_id = '$value->id' AND pengeluaran_tgl = $hariini ")->row_array();
                                            if ($total_pengeluaran['total_pengeluaran'] != 0) {
                                                echo "<tr>"; ?>
                                                <td><?= $no++ ?></td>
                                                <td class="text-left"><?= $value->kategori_pengeluaran ?></td>
                                                <td class="text-right"><?= number_format($total_pengeluaran['total_pengeluaran']) ?></td>
                                                <?php
                                                echo "</tr>";
                                                $grandtotal = $total_pengeluaran['total_pengeluaran'] + $grandtotal;
                                            }
                                        
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="2" class="text-right">Grand Total</td>
                                        <td colspan="2" class="text-right">
                                            <?php 
                                                echo "<b>Rp. ".number_format($grandtotal).",-</b>";
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <a href="" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> cetak</a>
                                        </td>
                                    </tr>
                                    
                                </table>
                            </div>
                            
                    </div>
                    <hr>
                    <table class="table table-bordered table-hover mb-none" id="datatable-details">		
								
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Jenis Pengeluaran</th>
                                <th width="25%">Keterangan</th>
                                <th width="25%">Jumlah</th>
                                <th width="20%">Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no =1;
                                foreach ($pengeluaran as $dt){
                            ?>
                            <tr >
                                <td><?= $no ?></td>
                                <td><?= $dt->kategori_pengeluaran ?></td>
                                <td><?= $dt->pengeluaran_detail ?></td>
                                <td><?= number_format($dt->pengeluaran_jumlah) ?></td>
                                <td><?= $dt->pengeluaran_penerima ?></td>
                            
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

<div id="AddPengeluaran" class="modal-block modal-header-color modal-block-primary mfp-hide">
    <form action="<?= base_url('keuangan/add_pengeluaran_harian')?>" method="post">
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Tambah Pengeluaran Harian</h2>
        </header>
        <div class="panel-body">
                <div class="form-group mt-lg">
                    <label class="col-sm-3 control-label">Tanggal</label>
                    <div class="col-sm-9">
                        <input type="text" name="tgl" id="tgl" class="form-control" value="<?= date('d-m-Y') ?>" readonly>
                    </div>
                </div>
                <div class="form-group mt-lg">
                    <label class="col-sm-3 control-label">Jenis</label>
                    <div class="col-sm-9">
                        <select data-plugin-selectTwo class="form-control populate" name="kategori" id="kategori" style="width:300px;">
                            <?php 
                                foreach ($kategori as $key => $value) {
                            ?>
                            <option value="<?= $value->id ?>"><?= $value->kategori_pengeluaran ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-lg">
                    <label class="col-sm-3 control-label">Keterangan</label>
                    <div class="col-sm-9">
                        <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan">
                    </div>
                </div>
                <div class="form-group mt-lg">
                    <label class="col-sm-3 control-label">Jumlah</label>
                    <div class="col-sm-9">
                        <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" onkeypress="return event.charCode >= 48 && event.charCode <=57">
                    </div>
                </div>
                
                <div class="form-group mt-lg">
                    <label class="col-sm-3 control-label">Penerima</label>
                    <div class="col-sm-9">
                        <input type="text" name="penerima" id="penerima" class="form-control" placeholde="Nama Penerima">
                    </div>
                </div>
            
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                </div>
            </div>
        </footer>
        </form>
    </section>
</div>