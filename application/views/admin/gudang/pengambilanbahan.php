<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header">
                 <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                    <i class="bi bi-arrow-left"></i> Kembali
                </button>
                <a class="btn btn-primary btn-block text-center" data-bs-toggle="modal" data-bs-target="#modalProduk">
                    <i class="fa fa-plus"></i> Cari Barang 
                </a>
            </div>
            <div class="card-body">
                <p>Pengambilan Barang adalah, mutasi barang dari gudang utama ke Gudang Produksi</p>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Bahan Nama</th>
                            <th>QTY</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $total = 0;
                        foreach ($temp as $dt): 
                            $jumlah = $dt->qty * $dt->harga;
                            $total += $jumlah;
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $dt->bahan_nama ?></td>
                            <td class="text-right"><?= number_format($dt->qty) ?></td>
                            <td>
                                <a href="<?= base_url('gudang/deleteTempAmbil/' . $dt->temp_id) ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                    </tbody>
                </table>

                <p class="text-danger">* Pastikan semua bahan yang diambil sudah benar, sebelum menyimpan pengambilan.</p>
               



                <?= validation_errors() ?>
                <?= form_open('gudang/actionAddpengambilan') ?>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Pengambilan</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="pengambilan_tgl" required value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama Petugas</label>
                        <div class="col-md-4">
                            <select class="form-control select2" name="karyawan_id" required>
                                <option value="">-- Nama Petugas --</option>
                                <?php foreach ($karyawan as $b): ?>
                                    <option value="<?= $b->karyawan_id ?>"><?= $b->nama_lengkap ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Dikirim ke Gudang?</label>
                        <div class="col-md-4">
                            <select class="form-control select2" name="gudang_id" required>
                                <option value="">-- Pilih Gudang --</option>
                                <?php foreach ($gudang as $b): ?>
                                    <option value="<?= $b->gudang_id ?>"><?= $b->gudang_nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-save"></i> Simpan Pengambilan
                            </button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form method="post" action="<?= base_url('gudang/action_add_barang_keluar') ?>">
            <div class="modal-header">
            <h5 class="modal-title" id="modalProdukLabel">Tambahkan Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Bahan</label>
                <select class="form-select select2" name="bahan_id" id="bahan_id">
                    <option value="">-- Pilih Bahan Baku --</option>
                    <?php foreach($bahan as $b): ?>
                        <option value="<?= $b->bahan_id ?>"><?= $b->bahan_nama ?> || Stok : <?= $b->jumlah_stok ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="qty">
            </div>
           
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSimpanBarang">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // SweetAlert untuk validasi sebelum submit form tambah barang keluar
    $('#btnSimpanBarang').click(function(e) {
        var bahan_id = $('#bahan_id').val();
        var qty = $('input[name="qty"]').val();
        if (!bahan_id || !qty || qty <= 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Data tidak lengkap',
                text: 'Pilih bahan dan masukkan jumlah yang valid!',
            });
            return false;
        }
        // Form akan submit jika valid
    });

    // SweetAlert untuk hapus (jika ada tombol hapus di halaman ini)
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>




