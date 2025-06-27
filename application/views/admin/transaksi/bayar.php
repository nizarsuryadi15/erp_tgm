<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <header class="mb-3 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('transaksi/pembayaran'); ?>" class="btn btn-danger">Kembali</a>
                <button class="btn btn-primary" disabled>Pembayaran <?= $nospk ?></button>
            </header>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <!-- Info Transaksi -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pesan</label>
                                <p class="text-dark"><?= date_indo($getdata['tgl_pemesanan']) ?> -- Jam : <?= $getdata['jam_pemesanan'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konsumen</label>
                                <p class="text-dark"><strong><?= $getdata['konsumen_nama'] ?></strong> -- No HP : <?= $getdata['konsumen_nohp'] ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Metode Pesan</label>
                                <p class="text-success"><?= $getdata['nama_jenis_transaksi'] ?></p>
                                <?php if ($getdata['id_jenis_transaksi'] == '2') : ?>
                                    <p class="text-success"><?= $getdata['marketplace_nama'] ?> - No Transaksi: <?= $getdata['resi_marketplace'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Info Invoice -->
                        <div class="col-md-6 text-end">
                            <h2 class="text-dark fw-bold">NO SPK </h2>
                            <h4 class="text-dark fw-bold">#<?= $nospk ?></h4>
                            <hr>
                            <h4 class="text-center fw-bold">Sub Total :</h4>
                            <h1 class="text-end text-dark fw-bold">Rp. <?= number_format($getdata['jml_pemesanan']) ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Produk -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Detail Produk</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered m-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Product</th>
                                    <th>Harga Satuan</th>
                                    <th>Qty</th>
                                    <th>Jumlah</th>
                                    <th>Dateline</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($getdetail as $dt) {
                                    $harga = $dt->harga_1;
                                    if ($dt->harga_aktif == '2') $harga = $dt->harga_2;
                                    if ($dt->harga_aktif == '3') $harga = $dt->harga_3;

                                    $jumlah = ($dt->panjang != '0' && $dt->lebar != '0') 
                                        ? $dt->panjang * $dt->lebar * $harga * $dt->qty 
                                        : $harga * $dt->qty;
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $dt->product_nama ?><br><small><?= $dt->detail_product ?></small></td>
                                    <td>Rp. <?= number_format($harga) ?></td>
                                    <td class="text-center">
                                        <?= $dt->qty ?><br>
                                        <?= ($dt->panjang != '0' && $dt->lebar != '0') ? "{$dt->panjang} x {$dt->lebar}" : '' ?>
                                    </td>
                                    <td>Rp. <?= number_format($jumlah) ?></td>
                                    <td>
                                        <form action="" method="post" class="d-flex align-items-center gap-2">
                                            <input type="hidden" name="id" value="<?= $dt->id ?>">
                                            <input type="date" name="dateline_tgl" value="<?= $dt->dateline_tgl ?>" class="form-control form-control-sm" style="width: auto;">
                                            <input type="time" name="dateline_jam" value="<?= $dt->dateline_jam ?>" class="form-control form-control-sm" style="width: auto;">
                                            <button type="submit" class="btn btn-sm btn-primary">Set</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tombol Bayar -->
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <a href="#modalHeaderColorPrimary" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal">
                        <i class="fa fa-save"></i> Bayar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Bootstrap 5 -->
<div class="modal fade" id="modalHeaderColorPrimary" tabindex="-1" aria-labelledby="modalHeaderColorPrimaryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-primary">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalHeaderColorPrimaryLabel">Pembayaran SPK No <?= $nospk ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="<?= base_url('transaksi/action_bayar'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <input type="hidden" name="nospk" value="<?= $nospk ?>">
                                    <input type="hidden" name="konsumen_id" value="<?= $getdata['konsumen_id'] ?>">
                                    <input type="hidden" name="deskprint_id" value="<?= $getdata['deskprint_id'] ?>">
                                    <input type="hidden" name="id_jenis_transaksi" value="<?= $getdata['id_jenis_transaksi'] ?>">
                                    <input type="hidden" name="marketplace_id" value="<?= $getdata['marketplace_id'] ?: 0 ?>">
                                    <input type="hidden" name="pembayaran_tgl" value="<?= $hariini ?>">
                                    <input type="hidden" name="pembayaran_jam" value="<?= $jamini ?>">

                                    <div class="mb-3">
                                        <label>Sub Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" name="sub_total" id="sub_total" class="form-control" value="<?= $getdata['jml_pemesanan'] ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Diskon</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="diskon" name="diskon" class="form-control" value="0" onkeypress="return event.charCode >= 48 && event.charCode <=57">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Ongkir</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="ongkir" name="ongkir" class="form-control" value="0" onkeypress="return event.charCode >= 48 && event.charCode <=57">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Grand Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" id="grandtotal" name="grandtotal" class="form-control" value="<?= $getdata['jml_pemesanan'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Metode Bayar</label>
                                        <select name="metode" id="metodeBayar" class="form-control">
                                            <option value="">-- Pilih Metode --</option>
                                            <option value="cash">Cash</option>
                                            <option value="transfer">Transfer</option>
                                            <option value="edc">EDC</option>
                                            <option value="ewallet">E-Wallet</option>
                                            <option value="piutang">Piutang</option>
                                        </select>
                                    </div>

                                    <!-- Form Cash -->
                                    <div class="metode-input d-none" id="cashForm">
                                        <div class="mb-3">
                                            <label>Jumlah Tunai</label>
                                            <input type="text" name="bayar_tunai" class="form-control" placeholder="Masukkan jumlah tunai">
                                        </div>
                                        <div class="mb-3">
                                            <label>Kembali</label>
                                            <input type="text" id="kembalian" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Form Transfer -->
                                    <div class="metode-input d-none" id="transferForm">
                                        <div class="mb-3">
                                            <label>Jumlah Transfer</label>
                                            <input type="text" name="bayar_transfer" class="form-control" placeholder="Masukkan jumlah transfer">
                                        </div>
                                        <div class="mb-3">
                                            <label>No Rekening</label>
                                            <select name="rekening_id" class="form-control">
                                                <option value="0">Pilih No Rekening</option>
                                                <?php foreach ($rekening as $rek): ?>
                                                    <option value="<?= $rek->id ?>"><?= $rek->no_rekening ?> - <?= $rek->atas_nama ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Form EDC -->
                                    <div class="metode-input d-none" id="edcForm">
                                        <div class="mb-3">
                                            <label>EDC / QRIS</label>
                                            <input type="text" name="bayar_debit" class="form-control" placeholder="Masukkan jumlah EDC">
                                        </div>
                                        <div class="mb-3">
                                            <label>Pilih EDC / QRIS</label>
                                            <select name="id_edc" class="form-control">
                                                <option value="0">Pilih EDC / QRIS</option>
                                                <option value="1">EDC BCA / QRIS</option>
                                                <option value="2">EDC BRI / QRIS</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>No Kartu</label>
                                            <input type="text" name="nomor_debit" class="form-control" placeholder="Nomor Kartu" value="-">
                                        </div>
                                    </div>

                                    <!-- Form E-Wallet -->
                                    <div class="metode-input d-none" id="ewalletForm">
                                        <div class="mb-3">
                                            <label>Jumlah E-Wallet</label>
                                            <input type="text" name="bayar_ewallet" class="form-control" placeholder="Masukkan jumlah e-wallet">
                                        </div>
                                        <div class="mb-3">
                                            <label>Pilih E-Wallet</label>
                                            <select name="ewallet_id" class="form-control">
                                                <option value="0">Pilih E-Wallet</option>
                                                <?php foreach ($ewallet as $rek): ?>
                                                    <option value="<?= $rek->id ?>"><?= $rek->ewallet_nama ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Form Piutang -->
                                    <div class="metode-input d-none" id="piutangForm">
                                        <div class="mb-3">
                                            <label>Jumlah DP</label>
                                            <input type="text" name="bayar_dp" class="form-control" placeholder="Masukkan jumlah DP">
                                        </div>
                                        <div class="mb-3">
                                            <label>Piutang</label>
                                            <input type="text" name="piutang" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Simpan Pembayaran</button>
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
function formatRupiah(angka, prefix = "Rp") {
    const number = angka.replace(/[^,\d]/g, "");
    const [int, dec] = number.split(",");
    const sisa = int.length % 3;
    let rupiah = int.substring(0, sisa);
    const ribuan = int.substring(sisa).match(/\d{3}/g);
    if (ribuan) rupiah += (sisa ? "." : "") + ribuan.join(".");
    return prefix + " " + (dec !== undefined ? rupiah + "," + dec : rupiah);
}

function toAngka(rupiah) {
    return parseInt(rupiah.replace(/[^0-9]/g, "")) || 0;
}

function hitungGrandTotal() {
    const subTotal = toAngka(document.getElementById("sub_total").value);
    const diskon = toAngka(document.getElementById("diskon").value);
    const ongkir = toAngka(document.getElementById("ongkir").value);
    const total = subTotal + ongkir - diskon;
    document.getElementById("grandtotal").value = total;
    hitungKembalian();
}

function hitungKembalian() {
    const grandTotal = toAngka(document.getElementById("grandtotal").value);
    const metodeInputs = document.querySelectorAll('.metode-input input[type="text"]');

    let totalBayar = 0;
    metodeInputs.forEach(input => {
        totalBayar += toAngka(input.value);
    });

    const kembali = Math.max(totalBayar - grandTotal, 0);
    const piutang = Math.max(grandTotal - totalBayar, 0);

    const kembalianInput = document.getElementById("kembalian");
    if (kembalianInput) {
        kembalianInput.value = formatRupiah(kembali.toString());
    }

    const piutangInput = document.getElementById("piutang");
    if (piutangInput && document.getElementById('metodeBayar').value === 'piutang') {
        piutangInput.value = formatRupiah(piutang.toString());
    }
}

function setupInputHandlers() {
    const inputs = ['diskon', 'ongkir', 'bayar_tunai', 'bayar_transfer', 'bayar_debit', 'bayar_ewallet'];
    inputs.forEach(id => {
        const input = document.querySelector(`[name="${id}"]`);
        if (input) {
            input.addEventListener('input', function () {
                const angka = this.value.replace(/[^0-9]/g, '');
                this.value = formatRupiah(angka);
                if (id === 'diskon' || id === 'ongkir') {
                    hitungGrandTotal();
                } else {
                    hitungKembalian();
                }
            });

            input.addEventListener('keypress', function (e) {
                if (!/\d/.test(e.key)) e.preventDefault();
            });
        }
    });
}

document.getElementById('metodeBayar').addEventListener('change', function () {
    document.querySelectorAll('.metode-input').forEach(el => el.classList.add('d-none'));
    const selectedForm = document.getElementById(this.value + 'Form');
    if (selectedForm) selectedForm.classList.remove('d-none');
    hitungKembalian();
});

document.addEventListener('DOMContentLoaded', () => {
    setupInputHandlers();
    hitungGrandTotal();
});
</script>

<script>
    $(document).ready(function () {
        $('.modal-basic').magnificPopup({
            type: 'inline',
            preloader: false,
            modal: true
        });

        $(document).on('click', '.modal-dismiss', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });
    });
</script>


