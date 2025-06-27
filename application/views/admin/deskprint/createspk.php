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
<div class="container-fluid">
<div class="row" style="padding-bottom: 60px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php 
                    $this->load->view('admin/deskprint/menu_deskprint');
                ?>
            </div>
            <div class="panel-body">
                <?php
                    if ($this->uri->segment(3) == NULL){
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="<?= base_url('deskprint/step_satu') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <!-- Konsumen -->
                                <div class="form-group">
                                    <label for="konsumenSelect">Pilih Konsumen</label>
                                    <select name="konsumen_id" id="konsumenSelect" class="form-control form-control" style="width:100%;">
                                    </select>
                                    <input type="hidden" name="perusahaan_id" value="<?= $perusahaan_id ?>">
                                </div>

                                <!-- Jenis Transaksi -->
                                <div class="form-group">
                                    <label for="id_jenis_transaksi">Jenis Transaksi</label>
                                    <select name="id_jenis_transaksi" id="id_jenis_transaksi" class="form-control form-control-lg" onchange="showDiv(this)">
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
                                    <button class="btn btn-dark btn-block" type="submit" name="step_satu">
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    
                        <!-- Kolom 1 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-5">Tanggal</label>
                                <div class="col-md-7"><?= date_indo('Y-m-d') ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5">Pelanggan</label>
                                <div class="col-md-7"><?= $getkosumen['konsumen_nama'] ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5">Alamat</label>
                                <div class="col-md-7"><?= substr($getkosumen['konsumen_alamat'], 0, 20) . '...' ?></div>
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-xs-5">Metode Pemesanan</label>
                                <div class="col-xs-7"><?= $getkosumen['nama_jenis_transaksi'] ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-5">Marketplace / Email</label>
                                <div class="col-xs-7"><?= $getkosumen['marketplace_nama'] ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-5">Resi Marketplace</label>
                                <div class="col-xs-7"><?= $getkosumen['resi_marketplace'] ?></div>
                            </div>
                        </div>

                        <!-- Kolom 3 -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-xs-5">Alamat Email</label>
                                <div class="col-xs-7"><?= $getkosumen['konsumen_email'] ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-5">No HP</label>
                                <div class="col-xs-7"><?= $getkosumen['konsumen_nohp'] ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-5">Nomor SPK</label>
                                <div class="col-xs-7">
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
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="" method="get">
                    <select name="kodeproduk" id="product_id" class="form-control" style="width: 100%; font-size: 1.4rem; height: 50px; padding: 10px;" onchange="this.form.submit()">
                        <!-- opsi akan terisi dari JavaScript atau PHP -->
                    </select>
                </form>

            <br>
            <h6 class="mb-0">Product yang Akan di Kerjakan :  <strong><?= $getproduk['product_nama']?></strong></h6>
        </div>
        <div class="panel-body">
            <form method="post" id="form-add-temp">
                <!-- Hidden Inputs -->
                <?php
                    $hiddenFields = [
                        'user_id' => $this->session->userdata('id'),
                        'nospk' => $nospk,
                        'panjang' => '0.0',
                        'lebar' => '0.0',
                        'ket_1' => '0',
                        'kode_trx' => '0',
                        'keterangan' => '-',
                        'kategori_id' => $getproduk['kategori_id'],
                        'subkategori_id' => $getproduk['subkategori_id'],
                        'bahan_id' => $getproduk['bahan_id'],
                        'tipe_id' => $getproduk['tipe_id'],
                        'product_id' => $getproduk['product_id'],
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
                                <select name="kategori_id" id="kategori_id" class="form-select form-control" disabled>
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
                            <?php 
                                $this->load->model('M_master');
                                $allowed = $this->M_master->get_kategori();
                                $view = 'admin/deskprint/createspk/kategori_' . $getproduk['kategori_id'];

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
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="transaksi">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Daftar Product / Jasa</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Harga Satuan</th>
                            <th width="10%">Ukuran</th>
                            <th width="10%">Status Approval</th>
                            <th width="10%">Harga Total</th>
                            <th width="5%">Ubah / Hapus</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                
            </div>
            <form action="<?= site_url('deskprint/add_pemesanan')?>" method="post" >
            <input type="hidden" class="form-control" name="nospk" value="<?= $nospk ?>" readonly>
            <input type="hidden" class="form-control" name="konsumen_id" value="<?= $getkosumen['konsumen_id'] ?>" readonly>
            <input type="hidden" class="form-control" name="deskprint_id" value="<?= $deskprint_id ?>" readonly>
            <input type="hidden" name="total_pemesanan" id="total_pemesanan">
            <input type="hidden" class="form-control" name="transaksi_tgl" value="<?= $hariini?>" readonly>
            <input type="hidden" class="form-control" name="transaksi_jam" value="<?= $jamini?>" readonly>
            <input type="hidden" class="form-control" name="id_jenis_transaksi" value="<?= $getkosumen['id_jenis_transaksi'] ?>" readonly>
            <input type="hidden" class="form-control" name="marketplace_id" value="<?= $getkosumen['marketplace_id'] ?>" readonly>
            <input type="hidden" class="form-control" name="resi_marketplace" value="<?= $getkosumen['resi_marketplace'] ?>" readonly>
            <!-- <input type="text" class="form-control" name="total_pemesanan" value="<?= $getkosumen['resi_marketplace'] ?>" readonly> -->

            <div class="panel-body">
                <div class="col-md-4 col-xs-12"></div>        
                <div class="col-md-5 col-xs-12 text-right" >
                    <?php 
                    $label = ($cek_transaksi == 0) ? 'Simpan' : 'Update';
                    $class = ($cek_transaksi == 0) ? 'btn-success' : 'btn-primary';
                ?>
                <button class="btn btn-warning" type="submit">Kirim Ke Kasir</button>
                <button class="btn <?= $class ?>" type="submit"><?= $label ?></button>
                </div>
                <div class="col-md-3 text-right col-xs-12" id="summarySection">
                    <p>Jumlah Item: <span id="jmlItem">0</span></p>
                    <h3>Total Harga: Rp <span id="totalHarga">0</span></h3>

                </div>
            </div>
        </form>
        </div>  
    </div>      
</div>
</div>
    <script>
        
        $(document).ready(function() {
        $('#konsumenSelect').select2({
            placeholder: 'Cari Nama atau No HP Konsumen...',
            ajax: {
                url: '<?= base_url("deskprint/search_konsumen") ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // kata kunci pencarian
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.konsumen_id,
                                text: item.konsumen_nama + ' - ' + item.konsumen_nohp
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

    <script>
    $(document).ready(function() {
    $('#product_id').select2({
        placeholder: 'Pilih Produk yang akan dikerjakan',
        allowClear: true,
        ajax: {
            url: '<?= base_url("deskprint/search_product") ?>',  
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

    <script>
    $(document).ready(function () {
    loadTransaksi();
    $('#form-add-temp').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '<?= base_url('deskprint/action_add_temp') ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json', // <--- penting!
            success: function (response) {
                if (response.status === 'success') {
                    alert('Item ditambahkan!');
                    loadSummary();
                    loadTransaksi(); // <- ini yang penting -> load tabel
                    $('#form-add-temp')[0].reset();
                } else {
                    alert('Gagal menambahkan item: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // debugging
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });

    });

    function loadTransaksi() {
        $.ajax({
            url: '<?= base_url('deskprint/load_transaksi/' . $nospk) ?>',
            type: 'GET',
            dataType: 'html', // atau json kalau ingin parsing sendiri
            success: function (html) {
                $('#transaksi tbody').html(html); // replace tbody isi
            },
            error: function () {
                // alert('Gagal memuat data transaksi');
            }
        });
    }

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

    $(document).on('click', '.btn_del', function() {
    var id = $(this).attr('id');

    if (confirm('Yakin ingin menghapus item ini?')) {
        $.ajax({
            url: '<?= base_url("transaksi/delete_temp_item") ?>', // sesuaikan dengan controller kamu
            type: 'POST',
            data: { temp_id: id },
            success: function(response) {
                // Optional: bisa hapus baris dari DOM langsung
                $('.del_mem' + id).fadeOut('slow', function() {
                    $(this).remove();
                });
                loadSummary();

            },
            error: function() {
                alert('Terjadi kesalahan saat menghapus data.');
            }
        });
    }
    });

    });

    let total = parseFloat($('#total_pemesanan_val').val());
    console.log("Total dari PHP:", total);

</script>















        



