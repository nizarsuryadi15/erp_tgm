<?php
date_default_timezone_set('Asia/Jakarta');
$waktuSekarang = date("H:i:s");
$bg = $conf->bg_login;

if ($waktuSekarang >= '04:59:00' && $waktuSekarang <= '11:00:00') {
    $waktu = "Pagi";
} elseif ($waktuSekarang >= '11:01:00' && $waktuSekarang <= '16:00:00') {
    $waktu = "Siang";
} elseif ($waktuSekarang >= '16:01:00' && $waktuSekarang <= '18:00:00') {
    $waktu = "Sore";
} else {
    $waktu = "Malam";
}
?>

<style>
    body {
        background-image: url('<?= base_url('assets/images/bg1.jpg') ?>');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel-sign {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
    }

    .panel-title-sign h2 {
        font-size: 20px;
    }

    .panel-body h3 {
        font-size: 18px;
    }

    @media (max-width: 576px) {
        .panel-sign {
            padding: 20px;
            margin: 15px;
        }

        .panel-body h3,
        .panel-title-sign h2 {
            text-align: center;
        }
    }

    .input-group-addon {
        background: #e9ecef;
        border-left: none;
    }

    .input-group .form-control {
        border-right: none;
    }
</style>

<?php if ($this->session->flashdata('error')): ?>   
    <div class="alert alert-danger text-center">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success text-center">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<section class="body-sign">
    <div class="center-sign">
        <div class="panel panel-sign">
            <div class="panel-title-sign mb-3 text-left">
                <h2 class="text-uppercase text-weight-bold m-0">
                    <i class="fa fa-user mr-2"></i> ERP Sistem
                </h2>
            </div>
            <div class="panel-body">
                <h3>Halo, Selamat <?= $waktu ?></h3>
                <form action="<?= base_url('auth/proses_login') ?>" method="post">
                    <div class="form-group mb-3">
                        <label for="username">Nama Pengguna</label>
                        <div class="input-group input-group-icon">
                            <input name="username" type="text" id="username" class="form-control input-lg" placeholder="Masukkan ID Pengguna" required />
                            <span class="input-group-addon">
                                <span class="icon icon-lg"><i class="fa fa-user"></i></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password-field">Kata Sandi</label>
                        <div class="input-group input-group-icon">
                            <input name="password" type="password" id="password-field" class="form-control input-lg" placeholder="Masukkan Kata Sandi" required />
                            <span class="input-group-addon" onclick="togglePassword()" style="cursor: pointer;">
                                <span class="icon icon-lg"><i class="fa fa-eye" id="togglePasswordIcon"></i></span>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-7">
                            <div class="checkbox-custom checkbox-default">
                                <input id="RememberMe" name="rememberme" type="checkbox" />
                                <label for="RememberMe">Ingatkan Saya</label>
                            </div>
                        </div>
                        <div class="col-5 text-end">
                            <button type="submit" class="btn btn-primary btn-block w-100">Masuk</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword() {
    const passwordField = document.getElementById("password-field");
    const toggleIcon = document.getElementById("togglePasswordIcon");

    const isPassword = passwordField.getAttribute("type") === "password";
    passwordField.setAttribute("type", isPassword ? "text" : "password");

    toggleIcon.classList.toggle("fa-eye");
    toggleIcon.classList.toggle("fa-eye-slash");
}
</script>
