<style>
    table.a,
    table.b,
    table.footer,
    table.bayar {
        width: 300px;
        font-family: Arial, sans-serif;
        font-size: 12px;
        border: none;
    }

    table.a {
        height: 75px;
    }

    table.b {
        height: 50px;
    }

    table.footer,
    table.bayar {
        height: 30px;
    }

    p {
        text-align: center;
        font-size: 10px;
    }

    hr {
        border: solid 0.5px;
    }
</style>

<meta http-equiv='refresh' content='0.2;<?= base_url('transaksi/') ?>'>

<body onload="window.print();">

<table class='a'>
    <tr><td colspan="3" align="center"><img src="<?= base_url('assets/images/' . $perusahaan['logo']) ?>" width="50%"></td></tr>
    <tr><td colspan="3"><br></td></tr>
    <tr><td colspan="3" align="center"><p><?= @$perusahaan['alamat_perusahaan'] ?></p></td></tr>
    <tr><td colspan="3" align="center"><p>Email: <?= @$perusahaan['email'] ?></p><hr></td></tr>

    <tr><td colspan="3" align="center"><p style="font-size:16px; font-weight: bold;">NO.SPK: <?= $pembayaran['nospk'] ?></p></td></tr>
    <tr><td colspan="3" align="center"><hr></td></tr>

    <tr><td width="30%">Konsumen</td><td width="5%">:</td><td><?= $pembayaran['konsumen_nama'] ?></td></tr>
    <tr><td>HP</td><td>:</td><td><?= $pembayaran['konsumen_nohp'] ?></td></tr>
    <tr><td>Tanggal/Jam</td><td>:</td><td><?= date_indo(@$pembayaran['pembayaran_tgl']) ?> / <?= date_indo(@$pembayaran['pembayaran_jam']) ?></td></tr>
    <tr><td>Kasir</td><td>:</td><td><?= $pembayaran['username'] ?></td></tr>
    <tr><td colspan="3" align="center"><hr></td></tr>
</table>

<table class='a'>
    <tr>
        <td><b>Product</b></td>
        <td align="center"><b>Qty</b></td>
        <td align="center"><b>Uk</b></td>
        <td align="center"><b>Harga</b></td>
        <td align="right"><b>Jumlah</b></td>
    </tr>
    <?php foreach ($detailBayar as $dt):
        $harga = $dt->harga_aktif == '1' ? $dt->harga_1 : ($dt->harga_aktif == '2' ? $dt->harga_2 : $dt->harga_3);
        $jumlah = $harga * $dt->qty;
    ?>
        <tr>
            <td><?= $dt->detail_product ?></td>
            <td align="center"><?= $dt->qty ?></td>
            <td></td>
            <td align="right"><?= number_format($harga) ?></td>
            <td align="right"><?= number_format($jumlah) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>

<table class='bayar'>
    <tr><td rowspan="6" width="40%" align="center"></td><td colspan="4">Total</td><td align="right"><?= number_format(@$pembayaran['sub_total'], 0, ".", ".") ?></td></tr>
    <tr><td colspan="4">Diskon</td><td align="right"><?= number_format(@$pembayaran['diskon'], 0, ".", ".") ?></td></tr>
    <tr><td colspan="4">Ongkir</td><td align="right"><?= number_format(@$pembayaran['ongkir'], 0, ".", ".") ?></td></tr>
    <tr><td colspan="4">Grand Total</td><td align="right"><?= number_format(@$pembayaran['grand_total'], 0, ".", ".") ?></td></tr>

    <?php if ($pembayaran['bayar_tunai'] != 0): ?>
        <tr><td colspan="4">Bayar Tunai</td><td align="right"><?= number_format($pembayaran['bayar_tunai'], 0, ".", ".") ?></td></tr>
    <?php endif; ?>

    <?php if ($pembayaran['bayar_debit'] != 0): ?>
        <tr><td colspan="4">Bayar EDC</td><td align="right"><?= number_format($pembayaran['bayar_debit'], 0, ".", ".") ?></td></tr>
    <?php endif; ?>

    <?php if ($pembayaran['bayar_transfer'] != 0): ?>
        <tr><td colspan="4">Transfer</td><td align="right"><?= number_format($pembayaran['bayar_transfer'], 0, ".", ".") ?></td></tr>
        <tr><td colspan="5">No.Rek <?= $pembayaran['no_rekening'] ?></td></tr>
    <?php endif; ?>

    <?php if ($pembayaran['bayar_ewallet'] != 0): ?>
        <tr><td colspan="4"><?= $pembayaran['ewallet_nama'] ?></td><td align="right"><?= number_format($pembayaran['bayar_ewallet'], 0, ".", ".") ?></td></tr>
    <?php endif; ?>
</table>

<table class='footer'>
    <tr>
        <td width="40%"></td>
        <td colspan="2">
            <?php 
                if ($pembayaran['piutang'] != 0) {
                    if ($pembayaran['piutang'] > 0) {
                        echo "Piutang" . str_repeat("&nbsp;", 20) . number_format($pembayaran['piutang'], 0, ".", ".");
                    } else {
                        echo "Kembali" . str_repeat("&nbsp;", 20) . number_format(abs($pembayaran['piutang']), 0, ".", ".");
                    }
                } else {
                    echo "LUNAS";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <hr>
            <p>Tidak Menerima <b>KOMPLAIN</b> atas Kerusakan/kesalahan <b>PRINT DILUAR ACC atau APPROVAL</b></p>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <hr>
            <img src="<?= base_url('./assets/qrcode/' . $pembayaran['nospk']) ?>.png" width="50%">
            <p>Scan di sini untuk cek posisi pesanan anda</p>
        </td>
    </tr>
</table>

</body>
