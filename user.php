<style>
/* Dark-mode parity for users (container + text + controls) */
[data-theme="dark"] .user-section { background-color: var(--section-bg) !important; color: #fff !important; border-radius: 0.5rem; padding: 0.75rem; }
[data-theme="dark"] .user-section .form-control { background-color: rgba(255,255,255,0.02) !important; color: #fff !important; border-color: rgba(255,255,255,0.06) !important; }
[data-theme="dark"] .user-section .modal-content { background-color: var(--section-bg) !important; color: #fff !important; }
/* ensure muted labels are readable in dark mode */
[data-theme="dark"] .user-section .text-muted { color: rgba(255,255,255,0.8) !important; }
/* links and pagination */
[data-theme="dark"] .user-section a, [data-theme="dark"] .user-section .page-link { color: #fff !important; }
[data-theme="dark"] .user-section .pagination .page-link { background: transparent !important; border-color: rgba(255,255,255,0.1) !important; }
[data-theme="dark"] .user-section .pagination .page-item.active .page-link { background-color: rgba(255,255,255,0.12) !important; border-color: rgba(255,255,255,0.2) !important; }

/* circular, fixed-size user photo (table) */
.user-section .user-photo { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; display: inline-block; }

/* modal preview should be larger but also circular */
.user-section .img-preview.user-photo { width: 160px; height: 160px; display: block; margin-top: .5rem; border-radius: 50%; object-fit: cover; }

/* smaller old-image preview */
.user-section .old-image.user-photo { width: 80px; height: 80px; display: inline-block; border-radius: 50%; object-fit: cover; }

/* ensure table cells align nicely */
.user-section .table td, .user-section .table th { vertical-align: middle; }


</style>

<div class="container user-section">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>
    <div class="row">
        <div class="table-responsive" id="user_data"></div>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="modalTambahUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Tambah User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                                <small class="text-muted">Password akan disimpan sebagai MD5 (saat ini sesuai mekanisme login).</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                                <img class="img-preview user-photo mt-2" style="display:none;" alt="Preview foto">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal Tambah -->
    </div>
</div>

<script>
$(document).ready(function(){
    load_data();
    function load_data(hlm){
        $.ajax({ url: 'user_data.php', method: 'POST', data: { hlm: hlm }, success: function(data){ $('#user_data').html(data); } });
    }
    $(document).on('click', '.halaman', function(){ var hlm = $(this).attr('id'); load_data(hlm); });

    // preview handler reuses article handler style
    $(document).on('change', 'input[type="file"][name="foto"]', function(e){
        var file = this.files && this.files[0];
        var $input = $(this);
        var $modal = $input.closest('.modal');
        var $preview = $input.siblings('.img-preview').first();
        if (file) {
            var url = URL.createObjectURL(file);
            if ($preview.length === 0) $preview = $('<img>').addClass('img-preview img-fluid mt-2').css('max-width','320px').insertAfter($input);
            var prevUrl = $preview.data('object-url'); if (prevUrl) try{ URL.revokeObjectURL(prevUrl);}catch(e){}
            $preview.attr('src', url).show().data('object-url', url);
        } else {
            if ($preview.length) { var prevUrl = $preview.data('object-url'); if (prevUrl) try{ URL.revokeObjectURL(prevUrl);}catch(e){}; $preview.hide().data('object-url',''); }
        }
    });

    $(document).on('hidden.bs.modal', '.modal', function(){ var $modal = $(this); var $preview = $modal.find('.img-preview').first(); if ($preview.length){ var prevUrl = $preview.data('object-url'); if (prevUrl) try{ URL.revokeObjectURL(prevUrl);}catch(e){}; $preview.removeAttr('src').hide().data('object-url',''); } $modal.find('input[type="file"][name="foto"]').val(''); });
});
</script>

<?php
include 'upload_foto.php';

// handle save (insert or update)
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $tanggal = date('Y-m-d H:i:s');
    $foto = '';
    $nama_foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';

    if ($nama_foto != '') {
        $cek = upload_foto($_FILES['foto']);
        if ($cek['status']) {
            $foto = $cek['message'];
        } else {
            echo "<script>alert('" . addslashes($cek['message']) . "');document.location='admin.php?page=user';</script>"; die;
        }
    }

    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        if ($nama_foto == '') { $foto = $_POST['foto_lama']; } else { if (!empty($_POST['foto_lama']) && file_exists(__DIR__ . '/img/' . $_POST['foto_lama'])) @unlink(__DIR__ . '/img/' . $_POST['foto_lama']); }
        $stmt = $conn->prepare("UPDATE user SET nama=?, username=?, foto=?, tanggal=? WHERE id=?");
        $stmt->bind_param('ssssi', $nama, $username, $foto, $tanggal, $id);
        $simpan = $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO user (nama,username,password,foto,tanggal) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss', $nama, $username, $password, $foto, $tanggal);
        $simpan = $stmt->execute();
    }

    if ($simpan) echo "<script>alert('Simpan data sukses');document.location='admin.php?page=user';</script>"; else echo "<script>alert('Simpan data gagal');document.location='admin.php?page=user';</script>";
    if (isset($stmt)) $stmt->close(); $conn->close();
}

// handle delete
if (isset($_POST['hapus'])) {
    $id = intval($_POST['id']);
    $foto = $_POST['foto'];
    if (!empty($foto) && file_exists(__DIR__ . '/img/' . $foto)) @unlink(__DIR__ . '/img/' . $foto);
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?"); $stmt->bind_param('i', $id); $hapus = $stmt->execute();
    if ($hapus) echo "<script>alert('Hapus data sukses');document.location='admin.php?page=user';</script>"; else echo "<script>alert('Hapus data gagal');document.location='admin.php?page=user';</script>";
    if (isset($stmt)) $stmt->close(); $conn->close();
}
?>