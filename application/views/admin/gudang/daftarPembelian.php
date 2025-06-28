<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card shadow-sm">
            <div class="card-header">
                <!-- <h5 class="mb-0">Data Pembelian Barang</h5> -->
                 <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                    <i class="bi bi-arrow-left"></i> Kembali
                </button>
                <a href="<?= base_url('gudang/add_barang_masuk') ?>" class="btn btn-primary btn-block">
                    <i class="bi bi-cart-plus"></i> Tambah Faktur Pembelian Barang
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatable-details">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th style="width: 20%;">Kode Transaksi / Faktur</th>
                                <th style="width: 10%;">Tanggal</th>
                               
                                <th>Nama Vendor / Supplier</th>
    
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                foreach ($tampilData as $dt):
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $dt->no_faktur ?></td>
                                <td>
                                    <?= date_indo($dt->pembelian_tgl) ?><br>
                                    
                                </td>
                                <td><?= $dt->supplier_nama ?></td>
                               
                                
                                <td class="text-center">
                                    <a href="<?= base_url('gudang/detailbarangmasuk/'.$dt->pembelian_id) ?>" class="btn btn-warning btn-sm" title="Detail">
                                        <i class="bi bi-list-ul"></i>
                                    </a>
                                    <a href="<?= base_url('gudang/cetakPembelian/'.$dt->pembelian_id) ?>" class="btn btn-primary btn-sm" title="Cetak">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm btn-delete" title="Hapus"
                                        data-url="<?= base_url('gudang/deletePembelian/'.$dt->pembelian_id) ?>">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
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
