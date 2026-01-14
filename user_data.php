<?php
include 'koneksi.php';

// create user table if not exists (compatible with login.php expectations)
$create = "CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255),
    username VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    foto VARCHAR(255),
    tanggal DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$conn->query($create);

// Remove development sample seeding. If sample users exist from prior runs, clean them up.
// (This keeps the table empty until real users are added.)
$cleanup_usernames = ['danny','usera','userb','userc','userd','usere'];
$in = implode(',', array_map(function($u) use ($conn){ return "'".$conn->real_escape_string($u)."'"; }, $cleanup_usernames));
$conn->query("DELETE FROM `user` WHERE username IN (".$in.")");

// End of cleanup; no automatic seeding.

$hlm = (isset($_POST['hlm'])) ? intval($_POST['hlm']) : 1;
$limit = 4;
$limit_start = ($hlm -1) * $limit;

$sql = "SELECT * FROM user ORDER BY tanggal DESC LIMIT $limit_start, $limit";
$hasil = $conn->query($sql);

// if no users exist, show message and exit
$sqlCount = "SELECT COUNT(*) AS cnt FROM user";
$resCount = $conn->query($sqlCount);
$rowCount = $resCount->fetch_assoc();
$total_records = intval($rowCount['cnt']);
if ($total_records === 0) {
    echo '<div class="mt-4 text-center text-white">Belum ada data user. Silakan tambahkan user melalui tombol "Tambah User".</div>';
    return;
}
?>

<table class="table table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = $limit_start +1; while ($row = $hasil->fetch_assoc()) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><strong><?= htmlspecialchars($row['nama']) ?></strong><br><small class="text-muted"><?= $row['tanggal'] ?></small></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td>
                    <?php if (!empty($row['foto']) && file_exists(__DIR__ . '/img/' . $row['foto'])): ?>
                        <img src="img/<?= rawurlencode($row['foto']) ?>" class="user-photo" alt="">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>"><i class="bi bi-pencil"></i></a>
                    <a href="#" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>"><i class="bi bi-x-circle"></i></a>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"><h1 class="modal-title fs-5">Edit User</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required></div>
                                        <div class="mb-3"><label class="form-label">Username</label><input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['username']) ?>" required></div>
                                        <div class="mb-3"><label class="form-label">Ganti Foto</label><input type="file" class="form-control" name="foto" accept="image/*"><img class="img-preview user-photo mt-2" style="display:none;" alt="Preview foto"></div>
                                        <div class="mb-3"><label class="form-label">Foto Lama</label><br><?php if (!empty($row['foto']) && file_exists(__DIR__ . '/img/' . $row['foto'])): ?><img class="old-image user-photo" src="img/<?= rawurlencode($row['foto']) ?>" alt=""><?php endif; ?><input type="hidden" name="foto_lama" value="<?= $row['foto'] ?>"></div>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><input type="submit" value="simpan" name="simpan" class="btn btn-primary"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Edit -->

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h1 class="modal-title fs-5">Konfirmasi Hapus User</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                        <form method="post" action=""><div class="modal-body"><p>Yakin akan menghapus "<strong><?= htmlspecialchars($row['nama']) ?></strong>"?</p><input type="hidden" name="id" value="<?= $row['id'] ?>"><input type="hidden" name="foto" value="<?= $row['foto'] ?>"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><input type="submit" value="hapus" name="hapus" class="btn btn-danger"></div></form>
                        </div></div></div>
                    <!-- End Modal Hapus -->
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$sql1 = "SELECT * FROM user"; $hasil1 = $conn->query($sql1); $total_records = $hasil1->num_rows;
?>
<p>Total user : <?php echo $total_records; ?></p>
<nav class="mb-2"><ul class="pagination justify-content-end">
<?php
    $jumlah_page = ceil($total_records / $limit);
    $jumlah_number = 1; $start_number = ($hlm > $jumlah_number)? $hlm - $jumlah_number : 1; $end_number = ($hlm < ($jumlah_page - $jumlah_number))? $hlm + $jumlah_number : $jumlah_page;
    if($hlm == 1){ echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>'; echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>'; } else { $link_prev = ($hlm > 1)? $hlm - 1 : 1; echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>'; echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>'; }
    for($i = $start_number; $i <= $end_number; $i++){ $link_active = ($hlm == $i)? ' active' : ''; echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>'; }
    if($hlm == $jumlah_page){ echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>'; echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>'; } else { $link_next = ($hlm < $jumlah_page)? $hlm + 1 : $jumlah_page; echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>'; echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>'; }
?>
</ul></nav>