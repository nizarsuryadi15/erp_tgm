<style>
        table.a{
            border: solid 0px;
            width:300px;
            font-family:lato;
            font-size:14px;
			height:75px;
        
        }
		table.b{
            border: solid 0px;
            width:300px;
            font-family:lato;
            font-size:14px;
			height:50px;
         
        }
		table.footer{
            
            width:300px;
            font-family:lato;
            font-size:14px;
			height:30px;
			/* align:right; */
         
        }
		table.bayar{
            
            width:300px;
            font-family:lato;
            font-size:12px;
			height:30px;
         
        }
        p{
            text-align :center;
            font-size:10px;
        }
        hr{
            border:solid 0.5px;
        }
    </style>
</head>

<section class="panel">
    <header class="panel-heading">
        

        <a href="<?= base_url('transaksi/produksi')?>" class="btn btn-warning"><I class="fa fa-backward"></I> Kembali </a> 
        </header>

            <div class="panel-body">
                <div class="col-sm-6">
                    <table class='a'>
                        
                        <tr><td colspan="3" align="center"><img src="<?= base_url('assets/images/'.$perusahaan['logo'])?>" width="50%"></td></tr>
                        <tr><td colspan="3"><br></td></tr>
                        <tr><td colspan="3" align="center"><p style="font-size:10px;"><?= @$perusahaan['alamat_perusahaan']?></td></p></tr>
                    
                        <tr><td colspan="3" align="center"><p style="font-size:10px;">Email : <?= @$perusahaan['email']?> <hr></td></tr>

                        <tr>
                            <td colspan="3" align="center">
                            <h3>
                            <?= $pembayaran['nospk'] ?></h3>
                            </td>
                        </tr>
                        
                        <tr><td colspan="3" align="center"><hr></td></tr>

                    

                        <tr><td width="30%">Konsumen</td><td width="5%">:</td> <td><?= $pembayaran['konsumen_nama'] ?></td></tr>
                        <tr><td width="30%">HP</td><td width="5%">:</td> <td><?= $pembayaran['konsumen_nohp'] ?></td></tr>  
                        <?php 
                            $tanggal        = $pembayaran['pembayaran_tgl'];
                            $jam            = $pembayaran['pembayaran_jam'];
                            $tgldateline    = substr($pembayaran['dateline_tgl'], 0,10);
                            
                        ?>
                        
                        <tr><td width="30%">Tanggal/Jam</td><td width="5%">:</td> <td><?= date_indo(@$tanggal) ?> / <?= date_indo(@$jam) ?></td></tr>
                        <tr><td width="30%">Kasir</td><td width="5%">:</td> <td><?= $pembayaran['username'] ?></td></tr>
                        
                        <!-- <tr><td width="30%">Dateline:</td><td width="5%">: </td> <td><?= date_indo($tgldateline) ?> - <?= @$data_transaksi['dateline_jam'] ?> </td></tr> -->
                        
                        <tr><td colspan="3" align="center"><hr></td></tr>
                    </table>
                            
                    <table class='a'>
                    
                        <tr>
                            <td width="40%"><b>Product</b></td>
                            <td  align="center" width="10%"><b>Qty</td>
                            <td  align="center" width="10%"><b>Uk</td>
                            <td width="20%" align="center"><b>Harga</td>
                            <td width="20%" align="right"><b>Jumlah</td>
                        </tr>
                    <?php
                        
                        foreach ($detailBayar as $dt)
                        {
                            if ($dt->harga_aktif == '1'){
                                $harga = $dt->harga_1;
                            }elseif ($dt->harga_aktif == '2'){
                                $harga = $dt->harga_2;
                            }elseif ($dt->harga_aktif == '3'){
                                $harga = $dt->harga_3;
                            }
                            $jumlah = $harga * $dt->qty;
                        ?>
                        <tr>
                            <td><?= $dt->detail_product ?></td>
                            <td align="center"><?= $dt->qty ?></td>
                            <td></td>
                            <td align="right"><?= number_format($harga) ?></td>
                            <td align="right"><?= number_format($jumlah) ?></td>
                        </tr>
                        <?php
                            @$no++;
                            
                        }

                    ?>
                    </table>
                    <br>
                    
                        
                        
                    <table class='footer' border="0">
                    
                        <tr>
                            <td align='center' colspan='3'>
                                <hr>
                                <p>Tidak Menerima <b>KOMPLAIN</b> atas Kerusakan/kesalahan  
                                <b>PRINT DILUAR ACC atau APPROVAL</b> </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <h3 class="text-center">PROSES PRODUKSI</h3>
                    <hr>
                    <table class="table">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                        </tr>
                        <?php 
                            foreach($detailprod as $prod){
                        ?>
                        <tr>
                            <td>
                                <?= $prod->product_nama ?>
                                <br>
                                <b><?= $prod->detail_product ?></b>
                            </td>
                            <td><?= $prod->qty ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                         <?php 
                            if($cekproduksi['status_produksi'] == '0'){
                        ?>
                        <tr>
                            <td colspan="2">
                                <form action="<?= base_url('transaksi/proses_produksi')?>" method="post">
                                    <input type="hidden" name="status_produksi" value="1">
                                    <input type="hidden" name="produksi_id" value="<?= $cekproduksi['produksi_id'] ?>">
                                    <input type="hidden" name="nospk" value="<?= $pembayaran['nospk'] ?>">
                                    <button class="btn btn-danger btn-block" type="submit" name="produksi">Produksi</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                            }
                            elseif($cekproduksi['status_produksi'] == '1'){
                        ?>
                        <tr>
                            <td colspan="2">
                                <form action="<?= base_url('transaksi/produksi_done')?>" method="post">
                                    <input type="hidden" name="status_produksi" value="2">
                                    <input type="hidden" name="produksi_id" value="<?= $cekproduksi['produksi_id'] ?>">
                                    <input type="hidden" name="nospk" value="<?= $pembayaran['nospk'] ?>">
                                    <button class="btn btn-warning btn-block" type="submit" name="produksi">Selesaikan</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                            }elseif ($cekproduksi['status_produksi'] == '2'){
                                if ($cekproduksi['finishing_id'] == '1'){
                        ?>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-success btn-block disabled" type="submit" name="produksi">Kirim Ke OP Finishing</button>
                                <a href="<?= base_url('transaksi/spk_finishing/'.$pembayaran['nospk']) ?>" class="btn btn-primary btn-block" >Cetak Label SPK untuk OP Finishing</a>
                            </td>
                        </tr>
                        <?php
                                }else{
                        ?>
                         <tr>
                            <td colspan="2">
                                <button class="btn btn-success btn-block disabled" type="submit" name="produksi">Produk sudah di PB</button>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>