<?php if ($this->session->flashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= $this->session->flashdata('success') ?>',
        timer: 2000,
        showConfirmButton: false
    });
</script>

<?php
    $this->session->unset_userdata('success'); 
endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '<?= $this->session->flashdata('error') ?>',
        timer: 2000,
        showConfirmButton: false
    });
</script>
<?php 
    
endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '<?= $this->session->flashdata("success"); ?>',
        showConfirmButton: false,
        timer: 2000
    });
</script>
<?php endif; ?>
