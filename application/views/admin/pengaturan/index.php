<div class="app-content">
    <div class="container-fluid py-4">
        <div class="row g-4">

            <?php
            $cards = [
                ['title' => 'Manajemen Toko', 'value' => $store, 'link' => 'perusahaan'],
                ['title' => 'Manajemen Pengguna', 'value' => $users, 'link' => 'akun'],
                ['title' => 'Manajemen Karyawan', 'value' => $karyawan, 'link' => 'karyawan'],
                ['title' => 'Manajemen Konsumen', 'value' => $konsumen, 'link' => 'konsumen'],
                ['title' => 'Manajemen Bahan Baku', 'value' => $bahanbaku, 'link' => 'bahan'],
                ['title' => 'Manajemen Product', 'value' => $product, 'link' => 'product'],
                ['title' => 'Manajemen Mesin', 'value' => $mesin, 'link' => 'mesin'],
                ['title' => 'Manajemen Menu', 'value' => $getmenu, 'link' => 'menu'],
                ['title' => 'Manajemen Satuan', 'value' => $getsatuan, 'link' => 'satuan'],
            ];
            ?>

            <?php foreach ($cards as $c): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $c['title'] ?></h5>
                            <!-- <p class="display-6"><?= $c['value'] ?></p> -->
                            <a href="<?= base_url($c['link']) ?>" class="btn btn-primary btn-sm">Setting</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
