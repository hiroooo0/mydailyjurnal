<style>
/* Reuse article dark-mode styles for gallery section */
[data-theme="dark"] .gallery-section {
  background-color: rgba(255,255,255,0.02) !important;
  color: var(--section-text) !important;
  border-radius: 0.5rem;
  padding: 0.75rem;
}
[data-theme="dark"] .gallery-section .btn,
[data-theme="dark"] .gallery-section .btn-secondary,
[data-theme="dark"] .gallery-section .btn-primary {
  color: var(--section-text) !important;
  background-color: rgba(255,255,255,0.04) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .gallery-section .table,
[data-theme="dark"] .gallery-section .table th,
[data-theme="dark"] .gallery-section .table td {
  background-color: transparent !important;
  color: var(--section-text) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .gallery-section .table-striped > tbody > tr:nth-of-type(odd) {
  background-color: rgba(255,255,255,0.02) !important;
}
[data-theme="dark"] .modal-content {
  background-color: var(--section-bg) !important;
  color: var(--section-text) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .form-control { background-color: rgba(255,255,255,0.02) !important; color: var(--section-text) !important; border-color: rgba(255,255,255,0.06) !important; }
[data-theme="dark"] .form-label { color: var(--section-text) !important; }
[data-theme="dark"] .badge { color: var(--section-text) !important; }
[data-theme="dark"] .gallery-section .modal-title,
[data-theme="dark"] .gallery-section .modal-body,
[data-theme="dark"] .gallery-section .modal-footer { color: var(--section-text) !important; }
[data-theme="dark"] .btn-close { filter: invert(1) grayscale(1) contrast(1.2); }
[data-theme="dark"] .gallery-section .pagination .page-link { color: var(--section-text) !important; background-color: transparent !important; border-color: rgba(255,255,255,0.06) !important; }
[data-theme="dark"] .gallery-section .pagination .page-item.active .page-link { background-color: rgba(255,255,255,0.06) !important; border-color: rgba(255,255,255,0.12) !important; color: var(--section-text) !important; }
</style>

<div class="container gallery-section">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Gallery
    </button>
    <div class="row">
        <div class="table-responsive" id="gallery_data"></div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Tambah Gallery</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" required>
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
        $.ajax({
            url : "gallery_data.php",
            method : "POST",
            data : { hlm: hlm },
            success : function(data){
                $('#gallery_data').html(data);
            }
        })
    }

    $(document).on('click', '.halaman', function(){
        var hlm = $(this).attr('id');
        load_data(hlm);
    });
});
</script>

<?php
include "upload_foto.php";

// simpan/add atau update
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $tanggal = date("Y-m-d H:i:s");
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'admin';
    $gambar = '';
    $nama_gambar = isset($_FILES['gambar']['name']) ? $_FILES['gambar']['name'] : '';

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES['gambar']);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>alert('" . addslashes($cek_upload['message']) . "');document.location='admin.php?page=gallery';</script>";
            die;
        }
    }

    if (isset($_POST['id'])) {
        // update
        $id = intval($_POST['id']);
        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            if (!empty($_POST['gambar_lama']) && file_exists(__DIR__ . '/img/' . $_POST['gambar_lama'])) {
                @unlink(__DIR__ . '/img/' . $_POST['gambar_lama']);
            }
        }
        $stmt = $conn->prepare("UPDATE gallery SET judul =?, gambar = ?, tanggal = ?, username = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $judul, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
        // insert
        $stmt = $conn->prepare("INSERT INTO gallery (judul,gambar,tanggal,username) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $judul, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>alert('Simpan data sukses');document.location='admin.php?page=gallery';</script>";
    } else {
        echo "<script>alert('Simpan data gagal');document.location='admin.php?page=gallery';</script>";
    }

    if (isset($stmt)) $stmt->close();
    $conn->close();
}

// hapus
if (isset($_POST['hapus'])) {
    $id = intval($_POST['id']);
    $gambar = $_POST['gambar'];

    if (!empty($gambar) && file_exists(__DIR__ . '/img/' . $gambar)) {
        @unlink(__DIR__ . '/img/' . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>alert('Hapus data sukses');document.location='admin.php?page=gallery';</script>";
    } else {
        echo "<script>alert('Hapus data gagal');document.location='admin.php?page=gallery';</script>";
    }

    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>