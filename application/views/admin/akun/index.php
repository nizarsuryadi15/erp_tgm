<div class="app-content">
    <div class="container-fluid">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <a href="#" class="btn btn-dark">Jumlah Data:</strong> <?= $total_rows ?></a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                                Tambah Akun / Users <i class="fa fa-user"></i>
                            </button>

                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="datatable-details">
                            <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Store</th>
                            <th>Username</th>
                            <th>Password</th>
                            
                            <th>Hak Akses</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($tampilData as $dt): ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $dt->nama_lengkap ?></td>
                                <td><?= $dt->nama_perusahaan ?></td>
                                <td><?= $dt->username ?></td>
                                <td>
                                    <?= $dt->password ?> <br>
                                    <span class="badge badge-primary">Password Terenkripsi</span>
                                </td>
                                
                                <td>
                                    <?= $dt->role_name ?>
                                </td>
                                <td class="actions text-center">
                                    <a href="#" 
                                    class="btn btn-warning btn-reset-password" 
                                    data-userid="<?= $dt->user_id ?>" 
                                    title="Reset Password">
                                    <i class="bi bi-key-fill"></i> Reset Password
                                    </a>
                                    <a href="#" 
                                    class="btn btn-danger btn-hapus-akun" 
                                    data-href="<?= base_url('karyawan/delete-akun/' . $dt->user_id) ?>" 
                                    title="Hapus Akun">
                                    <i class="bi bi-trash3"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php 
                        $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahAkunLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('akun/action_add_user') ?>" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAkunLabel">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Form fields -->
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <select name="karyawan_id" class="form-control" required>
                            <?php foreach ($list_karyawan as $store): ?>
                                <option value="<?= $store->karyawan_id ?>"><?= $store->nama_lengkap ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Store</label>
                        <select name="perusahaan_id" class="form-control" required>
                            <?php foreach ($list_perusahaan as $store): ?>
                                <option value="<?= $store->id_perusahaan ?>"><?= $store->nama_perusahaan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-btn");
    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("editUserId").value = this.dataset.userid;
            document.getElementById("editUsername").value = this.dataset.username;
            document.getElementById("editRoleId").value = this.dataset.roleid;
            document.getElementById("editKaryawanId").value = this.dataset.karyawanid;
        });
    });
});
</script>

<script>
$(document).ready(function () {
    $('.btn-hapus-akun').on('click', function (e) {
        e.preventDefault(); // hentikan aksi default link

        const href = $(this).data('href');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Akun yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const resetButtons = document.querySelectorAll('.btn-reset-password');

    resetButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.getAttribute('data-userid');

            Swal.fire({
                title: 'Reset Password?',
                text: "Password akan dikembalikan ke default!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, reset!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke URL reset password
                    window.location.href = "<?= base_url('akun/reset_password/') ?>" + userId;
                }
            });
        });
    });
});
</script>







