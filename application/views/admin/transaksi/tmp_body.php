<?php 
    $no = 1;
    if ($jmlTmp != '0'){
        foreach (@$transaksi as $dt){
            $cekkonsumen = $this->db->get_where('tbl_konsumen', ['konsumen_id' => $dt->konsumen_id])->row_array();

            $hargaField = 'harga_' . $dt->harga_aktif;
            $hargaSatuan = isset($dt->$hargaField) ? $dt->$hargaField : 0; // fallback jika tidak ada

    ?>
        <tr class="del_mem<?= $dt->temp_id ?>">
            <td><?= $no ?></td>
            <td>
                <?php if (!empty($dt->detail_product)) : ?>
                    <p><?= $dt->detail_product ?></p>
                <?php else : ?>
                    <b>Detail Product Belum di Set Oleh Admin</b><br>
                    <small>Hubungi Admin atau hapus data ini</small><br>
                    <button type="button" class="btn_del btn btn-warning btn-sm mt-1" id="<?= $dt->temp_id ?>">Hapus</button><br>
                    <b class="text-danger">Operator tidak mengetahui bahan yang akan dicetak</b>
                <?php endif; ?>
            </td>
            <td class="text-center"><?= $dt->temp_qty ?> </td>
            <td><?= $dt->satuan_nama ?></td>
            <td class="text-end"><?= number_format($hargaSatuan) ?></td>
            <td class="text-center">
                <?= ($dt->temp_panjang != '0.0' && $dt->temp_lebar != '0.0') ? "{$dt->temp_panjang} x {$dt->temp_lebar}" : '' ?>
            </td>
            <td></td>
            <td class="text-end">
                <?php
                    $totalHarga = $hargaSatuan * $dt->temp_qty;

                    if (($dt->satuan_id == '2') OR ($dt->satuan_id == '4')) {
                        $totalHarga *= $dt->temp_panjang * $dt->temp_lebar;
                    }
                ?>
                <b><?= number_format($totalHarga) ?></b>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn_del" id="<?= $dt->temp_id ?>" title="Hapus item"><i class="fa fa-trash"></i></button>

            </td>
        </tr>

    <?php 
        $no++;
        $totalPemesanan += $totalHarga; // <- JUMLAHKAN DI SINI
        }
    }
    else{
        echo "<tr><td colspan='8' class='text-center'><b>Belum Ada Data Yang Tersedia</b></td></tr>";
    
    }
    
?>
    