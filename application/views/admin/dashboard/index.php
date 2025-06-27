<style>
    body {
        background-color: #f0f0f5;
        /* font-family: 'Lato', sans-serif; */
    }

    .dashboard-icon {
        background-color: #000;
        color: #fff;
        padding: 20px 10px;
        border-radius: 12px;
        text-align: center;
        transition: 0.3s;
        font-size: 0.85rem;
        min-height: 90px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        }

        .dashboard-icon:hover {
        background-color: #333;
        text-decoration: none;
        color: #fff;
        }

        .dashboard-icon i {
        font-size: 1.5rem;
        margin-bottom: 8px;
        }


    #jamDigital {
        font-weight: bold;
        font-size: 2rem;
        margin-top: 0.5rem;
        color: #333;
    }

    .powered-by img {
        height: 100px;
        margin: 15px;
        opacity: 0.7;
    }

    .powered-by img:hover {
        opacity: 1;
    }

    @media (max-width: 575.98px) {
        .dashboard-icon {
            padding: 15px 8px;
            font-size: 0.85rem;
        }

        .dashboard-icon i {
            font-size: 1.5rem;
        }
    }
</style>

<?php
date_default_timezone_set('Asia/Jakarta');
$jamAwal = date("H");
$menitAwal = date("i");
$detikAwal = date("s");
?>

<div class="app-content d-block" >
    <div class="container-fluid py-3">

        <!-- Header -->
        <div class="text-center mb-4">
            <img src="<?= base_url('assets/images/'.$logo )?>" alt="" class="img img-circle img-responsive" width="20%">
            <h6 id="clock"><?= date_indo(date('Y-m-d')) ?></h6>
            <h2 id="jamDigital"></h2>
            <p class="text-muted">Selamat Datang di ERP Sistem TGMPrint</p>
        </div>

        <!-- Menu Dashboard -->
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 justify-content-center mb-5">
            <div class="col">
                <a href="<?= base_url('dashboard') ?>" class="dashboard-icon">
                    <i class="bi bi-palette-fill"></i>
                    Dashboard
                </a>
            </div>

            <?php foreach ($menu as $mn): ?>
                <div class="col">
                    <a href="<?= base_url($mn->link) ?>" class="dashboard-icon">
                        <i class="<?= $mn->icon_fa ?>"></i>
                        <?= $mn->alias ?>
                    </a>
                </div>
            <?php endforeach; ?>

            <div class="col">
                <a href="<?= base_url('mobile') ?>" class="dashboard-icon">
                    <i class="bi bi-person-circle"></i>
                    Mobile
                </a>
            </div>

            <div class="col">
                <a href="https://tgmprint.com/website" target="_blank" class="dashboard-icon">
                    <i class="bi bi-send-fill"></i>
                    Website
                </a>
            </div>
        </div>

        <!-- Powered By -->
        <div class="text-center text-muted small powered-by">
            <p class="mb-1">Powered By:</p>
            <img src="<?= base_url('assets/images/official.png') ?>" alt="tgmerint" class="text-responsive">
            <img src="<?= base_url('assets/images/merch.png') ?>" alt="mchndys">
            <img src="<?= base_url('assets/images/salaketik.png') ?>" alt="salaketik">
            <img src="<?= base_url('assets/images/rt.png') ?>" alt="rgkt">
        </div>
    </div>
</div>

<!-- Jam Digital Script -->
<script>
    let jam = <?= $jamAwal ?>;
    let menit = <?= $menitAwal ?>;
    let detik = <?= $detikAwal ?>;

    function tampilkanJam() {
        detik++;
        if (detik >= 60) {
            detik = 0;
            menit++;
        }
        if (menit >= 60) {
            menit = 0;
            jam++;
        }
        if (jam >= 24) {
            jam = 0;
        }

        let j = jam < 10 ? "0" + jam : jam;
        let m = menit < 10 ? "0" + menit : menit;
        let d = detik < 10 ? "0" + detik : detik;

        document.getElementById("jamDigital").innerHTML = j + ":" + m + ":" + d;
    }

    setInterval(tampilkanJam, 1000);
    tampilkanJam();
</script>
