<style>
/* Dark mode for article section and related UI */
[data-theme="dark"] .article-section {
  background-color: rgba(255,255,255,0.02) !important;
  color: var(--section-text) !important;
  border-radius: 0.5rem;
  padding: 0.75rem;
}
[data-theme="dark"] .article-section .btn,
[data-theme="dark"] .article-section .btn-secondary,
[data-theme="dark"] .article-section .btn-primary {
  color: var(--section-text) !important;
  background-color: rgba(255,255,255,0.04) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .article-section .table,
[data-theme="dark"] .article-section .table th,
[data-theme="dark"] .article-section .table td {
  background-color: transparent !important;
  color: var(--section-text) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .article-section .table-striped > tbody > tr:nth-of-type(odd) {
  background-color: rgba(255,255,255,0.02) !important;
}
/* Make modals, form controls, and badges readable */
[data-theme="dark"] .modal-content {
  background-color: var(--section-bg) !important;
  color: var(--section-text) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .form-control {
  background-color: rgba(255,255,255,0.02) !important;
  color: var(--section-text) !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .form-label { color: var(--section-text) !important; }
[data-theme="dark"] .badge { color: var(--section-text) !important; }

/* Modal titles, footer and body */
[data-theme="dark"] .article-section .modal-title,
[data-theme="dark"] .article-section .modal-body,
[data-theme="dark"] .article-section .modal-footer {
  color: var(--section-text) !important;
}
/* make the modal close icon visible in dark mode */
[data-theme="dark"] .article-section .btn-close {
  filter: invert(1) grayscale(1) contrast(1.2);
}
/* Pagination / page links (next/prev) */
[data-theme="dark"] .article-section .pagination .page-link {
  color: var(--section-text) !important;
  background-color: transparent !important;
  border-color: rgba(255,255,255,0.06) !important;
}
[data-theme="dark"] .article-section .pagination .page-item.active .page-link {
  background-color: rgba(255,255,255,0.06) !important;
  border-color: rgba(255,255,255,0.12) !important;
  color: var(--section-text) !important;
}
[data-theme="dark"] .article-section .pagination .page-item.disabled .page-link {
  color: rgba(255,255,255,0.4) !important;
}
/* Ensure small text and strong elements in list are readable */
[data-theme="dark"] .article-section small,
[data-theme="dark"] .article-section p,
[data-theme="dark"] .article-section strong {
  color: var(--section-text) !important;
}
</style>

<div class="container article-section">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Article
    </button>
    <div class="row">
        <div class="table-responsive" id="article_data">

        </div>
        <!-- Awal Modal Tambah-->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" required>
                            </div>
                            <div class="mb-3">
                                <label for="floatingTextarea2">Isi</label>
                                <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                                <img class="img-preview img-fluid mt-2" style="display:none; max-width:320px;" alt="Preview gambar">
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
    <!-- Akhir Modal Tambah-->
    </div>
</div>

<script>
$(document).ready(function(){
    load_data();
    function load_data(hlm){
        $.ajax({
            url : "article_data.php",
            method : "POST",
            data : {
                        hlm: hlm
                   },
            success : function(data){
                    $('#article_data').html(data);
            }
        })
    } 

    // handle pagination clicks (inside ready so it can access load_data)
    $(document).on('click', '.halaman', function(){
        var hlm = $(this).attr("id");
        load_data(hlm);
    });

    // delegated image preview for Add/Edit modals (more robust)
    $(document).on('change', 'input[type="file"][name="gambar"]', function(e){
        var file = this.files && this.files[0];
        var $input = $(this);
        var $modal = $input.closest('.modal');
        // prefer preview next to the input (in the same form group)
        var $preview = $input.siblings('.img-preview').first();
        var $old = $modal.find('img.old-image').first();

        if (file) {
            console.log('preview: file selected', file.name, file.type, file.size);
            var url = URL.createObjectURL(file);
            if ($preview.length === 0) {
                $preview = $('<img>').addClass('img-preview img-fluid mt-2').css('max-width','320px').insertAfter($input);
            }
            // revoke previous object URL if any
            var prevUrl = $preview.data('object-url');
            if (prevUrl) { try { URL.revokeObjectURL(prevUrl); } catch(e){} }
            $preview.attr('src', url).show().data('object-url', url);
            if ($old.length) $old.hide();
        } else {
            // clear preview
            if ($preview.length) {
                var prevUrl = $preview.data('object-url');
                if (prevUrl) { try { URL.revokeObjectURL(prevUrl); } catch(e){} }
                $preview.removeAttr('src').hide().data('object-url', '');
            }
            if ($old.length) $old.show();
        }
    });

    // cleanup when a modal is closed (revoke URLs and reset previews)
    $(document).on('hidden.bs.modal', '.modal', function(){
        var $modal = $(this);
        var $preview = $modal.find('.img-preview').first();
        if ($preview.length) {
            var prevUrl = $preview.data('object-url');
            if (prevUrl) { try { URL.revokeObjectURL(prevUrl); } catch(e){} }
            $preview.removeAttr('src').hide().data('object-url', '');
        }
        // show old image again if present
        var $old = $modal.find('img.old-image').first();
        if ($old.length) $old.show();
        // clear file input so reopening modal starts clean
        $modal.find('input[type="file"][name="gambar"]').val('');
    });
});
</script>

<?php
include "upload_foto.php";

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    //jika ada file yang dikirim  
    if ($nama_gambar != '') {
		    //panggil function upload_foto untuk cek spesifikasi file yg dikirimkan user
		    //function ini memiliki 2 keluaran yaitu status dan message
        $cek_upload = upload_foto($_FILES["gambar"]);

				//cek status true/false
        if ($cek_upload['status']) {
		        //jika true maka message berisi nama file gambar
            $gambar = $cek_upload['message'];
        } else {
		        //jika true maka message berisi pesan error, tampilkan dalam alert
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=article';
            </script>";
            die;
        }
    }

		//cek apakah ada id yang dikirimkan dari form
    if (isset($_POST['id'])) {
        //jika ada id, lakukan update data dengan id tersebut
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            //jika tidak ganti gambar
            $gambar = $_POST['gambar_lama'];
        } else {
            //jika ganti gambar, hapus gambar lama
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE article 
                                SET 
                                judul =?,
                                isi =?,
                                gambar = ?,
                                tanggal = ?,
                                username = ?
                                WHERE id = ?");

        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
		    //jika tidak ada id, lakukan insert data baru
        $stmt = $conn->prepare("INSERT INTO article (judul,isi,gambar,tanggal,username)
                                VALUES (?,?,?,?,?)");

        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=article';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=article';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

//jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        //hapus file gambar
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id =?");

    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=article';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=article';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>