<style>
    .form-group label {
        font-weight: bold;
    }
    .select2-container .select2-selection--single {
        height: 45px !important;
        padding: 10px;
        font-size: 12px;
    }
</style>
<script type="text/javascript">
    function showDiv(select){
        if(select.value==2){
            document.getElementById('hidden_div').style.display = "block";
            document.getElementById('email_div').style.display = "none";
        } else if (select.value==3) {
            document.getElementById('email_div').style.display = "block";
            document.getElementById('hidden_div').style.display = "none";
        }else{
            document.getElementById('hidden_div').style.display = "none";
            document.getElementById('email_div').style.display = "none";
        }
    } 
</script>

<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <?php
                    if ($this->uri->segment(3) == NULL){
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="<?= base_url('transaksi/step_satu') ?>" method="post">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <!-- Konsumen -->
                                <div class="form-group">
                                    <label for="konsumenSelect">Pilih Konsumen</label>
                                    <select name="konsumen_id" id="konsumenSelect1" class="form-control" style="width:100%;"></select>

                                    <input type="hidden" name="perusahaan_id" value="<?= $perusahaan_id ?>">
                                </div>

                                <!-- Jenis Transaksi -->
                                <div class="form-group">
                                    <label for="id_jenis_transaksi">Jenis Transaksi</label>
                                    <select name="id_jenis_transaksi" id="id_jenis_transaksi" class="form-control" onchange="showDiv(this)">
                                        <option value="1">On The Spot</option>
                                        <option value="2">Marketplace</option>
                                        <option value="3">WhatsApp / Email</option>
                                    </select>
                                </div>

                                <!-- Marketplace (tampil jika dipilih) -->
                                <div id="hidden_div" style="display:none;">
                                    <div class="form-group">
                                        <label for="id_marketplace">Marketplace</label>
                                        <select name="id_marketplace" id="id_marketplace" class="form-control form-control-lg">
                                            <option value="0">Onsite</option>
                                            <option value="1">Tokopedia</option>
                                            <option value="2">Shopee</option>
                                            <option value="3">Website</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="resi_marketplace">No Resi Marketplace</label>
                                        <input type="text" class="form-control form-control-lg" name="resi_marketplace" value="-" placeholder="Masukkan No Resi">
                                    </div>
                                </div>

                                <!-- Email/NoHP (tampil jika dipilih) -->
                                <div id="email_div" style="display:none;">
                                    <div class="form-group">
                                        <label for="email_nohp">Email / No. HP</label>
                                        <input type="text" class="form-control form-control-lg" name="email_nohp" placeholder="Masukkan Email / No HP">
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-dark" type="submit" name="step_satu">
                                        <i class="fa fa-plus"></i> Buat Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php 
                    }else{
                ?>
                <div class="row col-md-12">
                    <!-- Kolom 1 -->
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Tanggal Transaksi</label>
                            <div class="col-sm-7 pt-1">: <?= date_indo('Y-m-d') ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-7 pt-1">: <?= $getkosumen['konsumen_nama'] ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Alamat</label>
                            <div class="col-sm-7 pt-1">: <?= substr($getkosumen['konsumen_alamat'], 0, 20) . '...' ?></div>
                        </div>
                    </div>

                    <!-- Kolom 2 -->
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Metode Pemesanan</label>
                            <div class="col-sm-7 pt-1">: <?= $getkosumen['nama_jenis_transaksi'] ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Marketplace / Email</label>
                            <div class="col-sm-7 pt-1">: <?= $getkosumen['marketplace_nama'] ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Resi Marketplace</label>
                            <div class="col-sm-7 pt-1">: <?= $getkosumen['resi_marketplace'] ?></div>
                        </div>
                    </div>

                    <!-- Kolom 3 -->
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Alamat Email</label>
                            <div class="col-sm-7 pt-1">: <?= $getkosumen['konsumen_email'] ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">No HP</label>
                            <div class="col-sm-7 pt-1">: <?= $getkosumen['konsumen_nohp'] ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Nomor SPK</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="text-copy" name="spk" value="<?= $nospk ?>" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-success btn-sm copy-btn" type="button">
                                            <i class="fa fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            <?php 
                }
            ?>
            </div>


            <div class="card-body">
                <!-- PILIH PRODUK -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="" method="get">
                            <!-- <select name="kodeproduk" id="product_id" class="form-control" style="width: 100%; font-size: 1.4rem; height: 50px; padding: 10px;" onchange="this.form.submit()"> -->
                                <!-- opsi akan terisi dari JavaScript atau PHP -->
                            <select name="kodeproduk" id="productSelect" class="form-control select2" style="width:100%;" onchange="this.form.submit()">
                                <option value="">-- Pilih Produk --</option>
                                <?php foreach ($product as $prod): ?>  
                                    <option value="<?= $prod->product_id ?>"><?= $prod->product_nama ?></option>
                                <?php endforeach; ?>
                            </select>

                        </form>

                        <br>
                        <h6 class="mb-0">Product yang Akan di Kerjakan :  <strong><?= $getproduk['product_nama']?></strong></h6>
                    </div>
                </div>
                <br>
                <!-- FORM TAMBAH PRODUK -->
                <form method="post" id="form-add-temp">
                <!-- <form method="post" id="form-add-temp" actionn="<?= base_url('transaksi/action_add_temp')?>"> -->
                    <!-- Hidden Inputs -->
                    <?php
                        $hiddenFields = [
                            'user_id'           => $this->session->userdata('id'),
                            'nospk'             => $nospk,
                            'panjang'           => '0.0',
                            'lebar'             => '0.0',
                            'ket_1'             => '0',
                            'kode_trx'          => '0',
                            'keterangan'        => '-',
                            'kategori_id'       => $getproduk['kategori_id'],
                            'subkategori_id'    => $getproduk['subkategori_id'],
                            'bahan_id'          => $getproduk['bahan_id'],
                            'tipe_id'           => $getproduk['tipe_id'],
                            'product_id'        => $getproduk['product_id'],
                        ];
                        foreach ($hiddenFields as $name => $value): ?>
                            <input type="hidden" name="<?= $name ?>" value="<?= $value ?>">
                    <?php endforeach; ?>

                    <div class="row">
                        <!-- KOLOM KIRI -->
                        <div class="col-md-6">
                            <!-- Kategori -->
                            <div class="row mb-3">
                                <label for="kategori_id" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select name="kategori_id" id="kategori_id" class="form-select" disabled>
                                        <option value="-">Pilih Kategori Pekerjaan</option>
                                        <?php foreach ($kategori as $kat): ?>
                                            <option value="<?= $kat->kategori_id ?>" <?= ($getproduk['kategori_id'] == $kat->kategori_id) ? 'selected' : '' ?>>
                                                <?= $kat->kategori_nama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>


                            <!-- Bahan Utama -->
                            <div class="row mb-3">
                                <label for="kategori_id" class="col-sm-2 col-form-label">Bahan Utama</label>
                                <div class="col-sm-10">
                                    <select name="bahan_id" id="bahan_id" class="form-control" disabled>
                                        <option value="">No Selected</option>
                                        <?php foreach($bahan as $bhn): ?>
                                            <option value="<?= $bhn->bahan_id ?>" <?= ($getproduk['bahan_id'] == $bhn->bahan_id) ? 'selected' : '' ?>>
                                                <?= $bhn->bahan_nama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Jenis Produk -->
                            <div class="row mb-3">
                                <label for="kategori_id" class="col-sm-2 col-form-label">Jenis Produk</label>
                                <div class="col-sm-10">
                                    <select name="tipe_id" id="tipe_id" class="form-control" disabled>
                                        <option value="">No Selected</option>
                                        <?php foreach ($tipe as $t): ?>
                                            <option value="<?= $t->tipe_id ?>" <?= ($getproduk['tipe_id'] == $t->tipe_id) ? 'selected' : '' ?>>
                                                <?= $t->tipe_nama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- View Tambahan Berdasarkan Kategori -->
                            <div class="form-group">
                                <div class="row mb-3">
                                    <label for="kategori_id" class="col-sm-2 col-form-label">Pilihan Sisi</label>
                                    <div class="col-sm-10">
                                        <div class="input-group mb-md">
                                            <select name="ket_1" id="ket_1" class="form-control col-md-9 col-xs-12">
                                                <option value="">-- Pilih Side --</option>
                                                <?php foreach ($side as $sd): ?>
                                                    <option value="<?= $sd->side_id ?>" <?= ($sd->side_id == $getproduk['side_id']) ? 'selected' : '' ?>>
                                                        <?= $sd->side_name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    $this->load->model('M_master');
                                    $allowed    = $this->M_master->get_kategori();
                                    $view       = 'admin/transaksi/createspk/kategori_' . $getproduk['kategori_id'];
                                
                                    if (in_array($getproduk['kategori_id'], $allowed)) {
                                        $this->load->view($view);
                                    } else {
                                        echo "<small class='text-danger'>Kategori tidak dikenali. Cek pada daftar produk.</small>";
                                    }
                                ?>
                            </div>
                        </div>

                        <!-- KOLOM KANAN -->
                        <div class="col-md-6">
                            <!-- Jumlah Pesanan -->
                            <div class="row mb-3">
                                <label for="qty" class="col-sm-3 col-form-label">Jumlah Pesanan</label>
                                <div class="col-sm-9">
                                    <input type="number" name="qty" id="qty" class="form-control" required>
                                </div>
                            </div>

                            <!-- Status Approval -->
                            <div class="row mb-3">
                                <label for="qty" class="col-sm-3 col-form-label">Status Approval</label>
                                <div class="col-sm-9">
                                    <select name="approve" id="approve" class="form-control">
                                        <option value="1">Lanjut Produksi</option>
                                        <option value="0">Sampel Produksi</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Lokasi Print -->
                            <div class="row mb-3">
                                <label for="qty" class="col-sm-3 col-form-label">Lokasi Print</label>
                                <div class="col-sm-9">
                                    <select name="lokasi_id" id="lokasi_id" class="form-control">
                                        <option value="1">TGM Official</option>
                                        <option value="2">TGM Merch</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="form-group mt-12 text-end">
                                <button type="submit" class="btn btn-success"><i class="fa fas-plus"></i> Tambahkan Item</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="transaksi">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Daftar Produk / Jasa</th>
                                <th width="5%">Qty</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Harga Satuan</th>
                                <th width="10%">Ukuran</th>
                                <th width="10%">Status Approval</th>
                                <th width="10%">Harga Total</th>
                                <th width="5%">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data transaksi akan dimuat di sini secara dinamis -->
                        </tbody>
                    </table>
                </div>

                <!-- FORM KIRIM KE KASIR -->
                <form action="<?= site_url('transaksi/add_pemesanan') ?>" method="post">
                    <!-- Input Hidden -->
                    <input type="hidden" name="nospk" value="<?= $nospk ?>">
                    <input type="hidden" name="konsumen_id" value="<?= $getkosumen['konsumen_id'] ?>">
                    <input type="hidden" name="deskprint_id" value="<?= $deskprint_id ?>">
                    <input type="hidden" name="total_pemesanan" id="total_pemesanan">
                    <input type="hidden" name="transaksi_tgl" value="<?= $hariini ?>">
                    <input type="hidden" name="transaksi_jam" value="<?= $jamini ?>">
                    <input type="hidden" name="id_jenis_transaksi" value="<?= $getkosumen['id_jenis_transaksi'] ?>">
                    <input type="hidden" name="marketplace_id" value="<?= $getkosumen['marketplace_id'] ?>">
                    <input type="hidden" name="resi_marketplace" value="<?= $getkosumen['resi_marketplace'] ?>">

                    <!-- Tombol dan Ringkasan -->
                    <div class="row mt-4">
                        <!-- Spacer -->
                        <div class="col-md-4 col-xs-12"></div>

                        <!-- Tombol Aksi -->
                        <div class="col-md-6 col-xs-12 text-end mb-3">
                            <?php 
                                $label = ($cek_transaksi == 0) ? 'Simpan' : 'Update';
                                $class = ($cek_transaksi == 0) ? 'btn-success' : 'btn-primary';
                            ?>
                            <button type="button" id="btnKirimKasir" class="btn btn-warning mr-2">
                                <i class="fas fa-save"> </i> Kirim Ke Kasir
                            </button>
                            <button type="submit" class="btn <?= $class ?> mr-2" ><i class="fas fa-save"> </i> 
                                <?= $label ?>
                            </button>
                        </div>

                        <!-- Ringkasan -->
                        <div class="col-md-2 col-xs-12 text-end" id="summarySection">
                                <h6 class="mb-1 text-end">Jumlah Item: <strong id="jmlItem">0</strong></h6>
                                <h4 class="mb-1 text-end">Total Harga: Rp <strong id="totalHarga">0</strong></h4>
                        </div>
                    </div>
                </form>
                

            </div>

            </div>  
        </div>      

</div>


<!-- Javascript nya  -->



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#btnKirimKasir').click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kirim ke Kasir?',
                text: "Pastikan semua data sudah benar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form
                    $(this).closest('form').submit();
                }
            });
        });
    });
</script>

<script>
    // FUNGSI untuk memuat tabel transaksi
    $(document).ready(function () {
        loadTransaksi(); // ⬅️ otomatis dijalankan saat halaman di-refresh
        loadSummary();
        updateSummary();
    });

    function loadTransaksi() {
        $.ajax({
            url: '<?= base_url('transaksi/load_transaksi/' . $nospk) ?>',
            type: 'GET',
            dataType: 'html',
            success: function (html) {
                $('#transaksi tbody').html(html);
            },
            error: function (xhr) {
                console.error("Gagal load transaksi: " + xhr.responseText);
            }
        });
    }

    // FUNGSI ringkasan (jika ada)
    function loadSummary() {
        $.ajax({
            url: '<?= base_url('transaksi/loadsummary/'.$nospk) ?>',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#jmlItem').text(data.jml_item);
                $('#totalHarga').text(new Intl.NumberFormat('id-ID').format(data.total_harga));
                $('#total_pemesanan').val(data.total_harga); // ← SIMPAN DI INPUT HIDDEN
            }
        });
    }

    $(document).on('click', '.btn_del', function () {
        var id = $(this).attr('id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("transaksi/delete_temp_item") ?>',
                    type: 'POST',
                    data: { temp_id: id },
                    success: function (response) {
                        $('.del_mem' + id).fadeOut('slow', function () {
                            $(this).remove();
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Item berhasil dihapus.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        loadSummary();
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data.'
                        });
                    }
                });
            }
        });
    });

    let total = parseFloat($('#total_pemesanan_val').val());
    console.log("Total dari PHP:", total);

</script>

<script>
    // Fungsi menghitung jumlah item dan total harga
    function updateSummary() {
        let totalItem = 0;
        let totalHarga = 0;

        // Loop tiap baris dalam tbody
        $('#transaksi tbody tr').each(function () {
            totalItem++;

            // Ambil total harga dari kolom ke-6 (indeks mulai dari 0)
            let harga = $(this).find('td:eq(6)').text().replace(/[^\d]/g, ''); // Hilangkan "Rp" dan tanda koma
            totalHarga += parseInt(harga) || 0;
        });

        // Tampilkan hasil
        $('#jmlItem').text(totalItem);
        $('#totalHarga').text(formatRupiah(totalHarga));
        $('#total_pemesanan').val(totalHarga); // Set ke input hidden
    }

    // Format angka ke Rupiah (contoh: 10000 => 10.000)
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Jalankan saat dokumen siap
    $(document).ready(function () {
        updateSummary(); // hitung saat pertama kali load

        // Jalankan juga saat ada perubahan pada tabel (contoh: setelah AJAX)
        // Panggil updateSummary() lagi setiap kamu tambahkan atau hapus baris dari tabel.
    });
</script>

<script>
    $(document).ready(function () {
        $('#konsumenSelect').select2({
            placeholder: 'Cari Konsumen...',
            width: '100%',
            ajax: {
                url: '<?= base_url("transaksi/search_konsumen") ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // search keyword
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.konsumen_id,
                                text: item.konsumen_nama
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>



    <script>
    $(document).ready(function() {
        $('#product_id').select2({
            placeholder: 'Pilih Produk yang akan dikerjakan',
            allowClear: true,
            ajax: {
                url: '<?= base_url("transaksi/search_product") ?>',  // Ganti sesuai controller-mu
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // keyword input user
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.product_id,
                                text: item.product_nama
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });
    });
    </script>

    <!-- Pastikan SweetAlert2 sudah disertakan -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#form-add-temp').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('transaksi/action_add_temp') ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Item berhasil ditambahkan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadSummary();
                    loadTransaksi();
                    $('#form-add-temp')[0].reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Item gagal ditambahkan.'
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Gagal mengirim data ke server.'
                });
            }
        });
    });
</script>

<script>
$(document).ready(function() {
    $('#konsumenSelect1').select2({
        placeholder: 'Cari konsumen...',
        minimumInputLength: 2,
        ajax: {
            url: '<?= site_url("konsumen/search_ajax") ?>', // bukan base_url
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // user input
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.konsumen_id,
                            text: item.konsumen_nama
                        };
                    })
                };
            },
            cache: true
        }
    });
});

</script>


<script>
$(document).ready(function() {
    $('#productSelect').select2({
        placeholder: 'Cari Produk...',
        allowClear: true,
        width: '100%' // agar lebar sesuai container
    });
});
</script>
