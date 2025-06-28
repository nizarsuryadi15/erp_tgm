<div class="app-content">
  <div class="container-fluid">

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div class="row mb-12">
          <div class="col-sm-12">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-primary disabled">Kembali</a>
            <a href="#" class="btn btn-dark disabled">Jumlah Konsumen : <?= $jml_konsumen ?></a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKonsumen">Tambah Konsumen</button>
          </div>  
        </div>
      </div>
      <div class="card-body">
        
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="datatable-detailss">
              <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th width="20%">No HP</th>
                <th width="30%">Alamat</th>
                <th>Email</th>
                <th>Status</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalKonsumen" tabindex="-1" aria-labelledby="modalKonsumenLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formKonsumen" method="POST" action="<?= base_url('konsumen/actionAdd') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalKonsumenLabel">Tambah Konsumen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label for="nama" class="form-label">Nama Konsumen</label>
            <input type="text" class="form-control" name="konsumen_nama" required>
          </div>
          <div class="mb-2">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="konsumen_alamat" required>
          </div>
          <div class="mb-2">
            <label for="nohp" class="form-label">Nomor WhatsApp</label>
            <input type="tel" class="form-control" id="wa_number" name="konsumen_nohp" placeholder="+6281234567890" required>
            <div id="wa_error" class="text-danger small mt-1"></div>
          </div>
          <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="konsumen_email" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal Edit Konsumen -->
<div class="modal fade" id="modalEditKonsumen" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="<?= base_url('konsumen/aksi_edit') ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Konsumen</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <!-- Konsumen ID harus hidden agar tidak bisa diubah user -->
            <input type="text" name="konsumen_id" id="edit_id" required>

            <div class="form-group">
                <label>Nama Konsumen</label>
                <input type="text" name="konsumen_nama" id="edit_nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="konsumen_alamat" id="edit_alamat" class="form-control" required>
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="tel" name="konsumen_nohp" id="edit_nohp" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="konsumen_email" id="edit_email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control" required>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
    </div>
    </form>
  </div>
</div>

<script>
document.getElementById('formKonsumen').addEventListener('submit', function(e) {
  const waInput = document.getElementById('wa_number');
  const errorDiv = document.getElementById('wa_error');
  const waValue = waInput.value.trim();
  const valid = /^\+\d{8,15}$/.test(waValue);

  errorDiv.textContent = '';
  if (!valid) {
    e.preventDefault();
    errorDiv.textContent = 'Format nomor harus +62 dan 8–15 digit angka.';
    waInput.focus();
  }
});

let tableKonsumen;

$(document).ready(function() {
    // Perbaiki id datatable
    if (!$.fn.DataTable.isDataTable('#datatable-detailss')) {
        tableKonsumen = $('#datatable-detailss').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "<?= base_url('konsumen/get_ajax') ?>",
                type: "POST"
            },
            columnDefs: [
                { targets: [0, 6], className: 'text-center' }
            ],
            columns: [
                { data: "no" },
                { data: "konsumen_nama" },
                { data: "konsumen_nohp" },
                { data: "konsumen_alamat" },
                { data: "konsumen_email" },
                { data: "status" },
                { 
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button type="button" class="btn btn-warning btn-sm btn-edit-konsumen"
                                data-id     ="${row.konsumen_id}"
                                data-nama   ="${row.konsumen_nama}"
                                data-alamat ="${row.konsumen_alamat}"
                                data-nohp   ="${row.konsumen_nohp}"
                                data-email  ="${row.konsumen_email}"
                                data-status ="${row.status}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditKonsumen"
                            >
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        `;
                    }
                }
            ]
        });
    }

    // Delegasi klik tombol edit (pastikan event delegation pada document)
    $(document).on('click', '.btn-edit-konsumen', function() {
        // Pastikan ID diisi ke input hidden, bukan ke input nama
        $('#edit_id').val($(this).data('id'));
        $('#edit_nama').val($(this).data('nama'));
        $('#edit_alamat').val($(this).data('alamat'));
        $('#edit_nohp').val($(this).data('nohp'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_status').val($(this).data('status'));
        $('#modalEditKonsumen').modal('show');
    });
});
</script>