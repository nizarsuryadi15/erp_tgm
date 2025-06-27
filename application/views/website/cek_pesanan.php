<div role="main" class="main">
    <section class="page-header page-header-modern bg-light py-4">
        <div class="container text-center">
            <h1 class="text-dark font-weight-bold mb-1">ERP TGM Print</h1>
            <p class="sub-title text-dark mb-0">Cek Pemesanan</p>
            <nav aria-label="breadcrumb" class="d-flex justify-content-center mt-2">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cek Pemesanan</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <form action="<?= base_url('website/cekpesanan') ?>" method="post" class="mb-4">
                    <div class="mb-3">
                        <label for="nospk" class="form-label">Masukkan No SPK</label>
                        <input type="text" name="nospk" id="nospk" class="form-control" placeholder="Contoh: SPK12345" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-dark">Cari Pesanan</button>
                    </div>
                </form>

                <?php if (!empty($pembayaran)) : ?>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-3">Detail Pesanan</h4>

                            <div class="mb-3">
                                <strong>No SPK:</strong> <?= $pembayaran['nospk'] ?><br>
                                <strong>Konsumen:</strong> <?= $pembayaran['konsumen_nama'] ?><br>
                                <strong>HP:</strong> <?= $pembayaran['konsumen_nohp'] ?><br>
                                <strong>Tanggal/Jam:</strong> <?= date_indo(@$tanggal) ?> / <?= date_indo(@$jam) ?>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Ukuran (P x L)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detailBayar as $dt): ?>
                                            <tr>
                                                <td><?= $dt->detail_product ?></td>
                                                <td class="text-center"><?= $dt->qty ?></td>
                                                <td>
                                                    <?php if ($dt->panjang != 0.0 || $dt->lebar != 0.0): ?>
                                                        <?= $dt->panjang ?> x <?= $dt->lebar ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-center">
                                <strong>Posisi Pesanan Anda</strong>
                                <div class="mt-2">
                                    <?php
                                        if ($cekflow['status_produksi'] == '0') {
                                            echo '<span class="btn btn-warning btn-sm disabled w-100 mt-2">Pending - Menunggu di Proses</span>';
                                        } elseif ($cekflow['status_produksi'] == '1') {
                                            echo '<span class="btn btn-primary btn-sm disabled w-100 mt-2">Sedang Diproses</span>';
                                        } elseif ($cekflow['status_produksi'] == '2') {
                                            echo '<span class="btn btn-success btn-sm disabled w-100 mt-2">Barang Siap Diambil</span>';
                                        }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
