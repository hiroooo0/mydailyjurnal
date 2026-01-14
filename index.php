<?php
session_start();
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Latihan Bootstrap</title>
    <link rel="icon" href="logo.webp" type="image/webp" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <style>
      :root{
        --bg: #ffffff;
        --text: #000000;
        --nav-bg: #0d6efd;
        --nav-text: #ffffff;
        --footer-bg: #0d6efd;
        --footer-text: #ffffff;
        --section-text: #000000;
      }

      [data-theme="dark"]{
        --bg: #0b1220;
        --text: #e6eef6;
        --nav-bg: #0b1730;
        --nav-text: #e6eef6;
        --footer-bg: #081225;
        --footer-text: #cfe6ff;
        --section-bg: #071026;
        --section-text: #ffffff;
      }

      [data-theme="dark"] .text-dark {
        color: var(--section-text) !important;
      }

      /* Cards: dark background + white text in dark mode */
      [data-theme="dark"] .card {
        background-color: var(--section-bg) !important;
        color: var(--section-text) !important;
        border-color: rgba(255,255,255,0.06) !important;
      }
      [data-theme="dark"] .card .card-body,
      [data-theme="dark"] .card .card-footer,
      [data-theme="dark"] .card .card-title,
      [data-theme="dark"] .card .card-text,
      [data-theme="dark"] .text-body-secondary {
        color: var(--section-text) !important;
      }
      /* Make elements with explicit white bg (e.g., .bg-white) readable in dark mode */
      [data-theme="dark"] .bg-white {
        background-color: transparent !important;
        color: var(--section-text) !important;
      }

      /* Preserve jadwal card header colors in dark mode (keep original day label colors) */
      [data-theme="dark"] #jadwal .card.bg-primary .card-header { background-color: #0d6efd !important; color: #fff !important; }
      [data-theme="dark"] #jadwal .card.bg-success .card-header { background-color: #198754 !important; color: #fff !important; }
      [data-theme="dark"] #jadwal .card.bg-danger .card-header { background-color: #dc3545 !important; color: #fff !important; }
      [data-theme="dark"] #jadwal .card.bg-warning .card-header { background-color: #ffc107 !important; color: #ffffff !important; }
      [data-theme="dark"] #jadwal .card.bg-info .card-header    { background-color: #0dcaf0 !important; color: #ffffff !important; }
      [data-theme="dark"] #jadwal .card.bg-secondary .card-header{ background-color: #6c757d !important; color: #fff !important; }
      [data-theme="dark"] #jadwal .card.bg-dark .card-header     { background-color: #212529 !important; color: #fff !important; }

      /* Data-diri: dark container and tables in dark mode */
      [data-theme="dark"] #data-diri .container {
        background-color: #0b1220 !important;
        color: var(--section-text) !important;
        border-radius: 0.5rem;
        padding: 1rem;
      }
      [data-theme="dark"] #data-diri .table,
      [data-theme="dark"] #data-diri .table th,
      [data-theme="dark"] #data-diri .table td {
        color: var(--section-text) !important;
        border-color: rgba(255,255,255,0.06) !important;
        background-color: transparent !important;
      }
      [data-theme="dark"] #data-diri .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: rgba(255,255,255,0.02) !important;
      }
      /* adjust dark borders for headings */
      [data-theme="dark"] .border-bottom.border-dark {
        border-bottom-color: rgba(255,255,255,0.12) !important;
      }

      /* Ensure footer sits at bottom by using flex on body */
      html, body { height: 100%; }
      body { display: flex; flex-direction: column; min-height: 100vh; background: var(--bg) !important; color: var(--text) !important; transition: background-color 200ms ease, color 200ms ease; font-family: 'Raleway', sans-serif; }

      .theme-navbar{
        background-color: var(--nav-bg) !important;
      }
      .theme-navbar .navbar-brand,
      .theme-navbar .nav-link{
        color: var(--nav-text) !important;
      }

      section[id^="home"], section[id^="gallery"]{
        background: var(--section-bg) !important;
      }

      section{
        color: var(--section-text) !important;
      }

      .theme-footer{
        background: var(--footer-bg) !important;
        color: var(--footer-text) !important;
      }
      /* Ensure footer sits at bottom */
      footer { margin-top: auto; width: 100%; }

      #theme-toggle{
        border: 1px solid rgba(255,255,255,0.25);
        color: var(--nav-text);
        background: transparent;
      }
      #theme-toggle:focus{ outline: none; box-shadow: none; }

      /* Article images: keep consistent aspect ratio and cover the area */
      #article .card-img-top {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        display: block;
      }

      /* Article paragraphs: justify text, enable hyphenation and prevent overflow */
      #article .card-text,
      #article .lead,
      #article p {
        text-align: justify;
        text-align-last: left;
        hyphens: auto;
        -webkit-hyphens: auto;
        -ms-hyphens: auto;
        word-wrap: break-word;
      }

      /* Gallery carousel images: fixed display area 16:9, target 1080px height (cropped via object-fit) */
      #carouselExample .carousel-item img {
        width: 100%;
        aspect-ratio: 16/9;
        height: 720px; /* target display height */
        object-fit: cover; /* crop so original resolution doesn't distort layout */
        display: block;
      }
      /* Responsive fallbacks so carousel isn't too tall on smaller viewports */
      @media (max-width: 1200px) {
        #carouselExample .carousel-item img { height: 60vh; }
      }
      @media (max-width: 576px) {
        #carouselExample .carousel-item img { height: 40vh; }
      }

      .profile-img-container{ display:flex; justify-content:center; align-items:center; }
      .profile-img{
        width: min(220px, 100%);
        aspect-ratio: 1/1;
        object-fit: cover;
        border-radius: 50%; /* perfect circle */
        display:block;
      }
      @media (max-width: 576px){
        .profile-img{ width: 150px; }
      }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg sticky-top theme-navbar">
      <div class="container">
        <a class="navbar-brand" href="#">Latihan Bootstrap</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#jadwal">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#data-diri">Data diri</a>
            </li>
            <li class="nav-item">
              <?php if(isset($_SESSION['username'])): ?>
                <a class="nav-link" href="admin.php">Admin Panel</a>
              <?php else: ?>
                <a class="nav-link" href="login.php">Login</a>
              <?php endif; ?>
            </li>
            <li class="nav-item ms-2">
              <button id="theme-toggle" class="btn btn-sm" aria-label="Toggle theme">
                <i id="theme-icon" class="bi bi-moon-fill"></i>
              </button>
            </li>
            <?php if(isset($_SESSION['username'])): ?>
              <li class="nav-item ms-2">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <section
      id="home"
      class="text-center text-sm-start p-5 bg-light rounded-4 shadow"
    >
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img
            src=""
            width="300"
            class="img-fluid mb-3 mb-sm-0"
            alt=""
          />
          <div>
            <h1 class="fw-bold display-5 text-primary">
              Latihan CSS Dasar Menggunakan Bootstrap
            </h1>
            <h4 class="lead text-dark">
              Mempelajari layout dan komponen dengan framework Bootstrap versi
              terbaru.
            </h4>
          </div>
        </div>
      </div>
    </section>

    <!-- article begin -->
<section id="article" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">Article</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php
      $sql = "SELECT * FROM article ORDER BY tanggal DESC";
      $hasil = $conn->query($sql); 

      while($row = $hasil->fetch_assoc()){
      ?>
        <div class="col">
          <div class="card h-100">
            <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title"><?= $row["judul"]?></h5>
              <p class="card-text">
                <?= $row["isi"]?>
              </p>
            </div>
            <div class="card-footer">
              <small class="text-body-secondary">
                <?= $row["tanggal"]?>
              </small>
            </div>
          </div>
        </div>
        <?php
      }
      ?> 
    </div>
  </div>
</section>
  <!-- article end -->

    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3 border-bottom border-dark">Article </h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center mt-3">
          <div class="col">
            <div class="card h-100 bg-primary text-white">
              <div class="card-body">
                <h5 class="card-title">Dark Souls 1</h5>
                <p class="card-text">
                  bercerita tentang karakter pemain undead terkutuk di kerajaan Lordran yang sedang runtuh, yang ditugaskan untuk menghubungkan Api Pertama yang memudar untuk memperpanjang Zaman Api, tetapi malah mengungkap sejarah kelam para dewa, jiwa gelap umat manusia, dan tindakan putus asa Gwyn dalam menghubungkan api tersebut, yang mengarah pada pilihan antara menghubungkannya kembali atau mengantarkan Zaman Kegelapan bagi umat manusia. Kisah ini mengikuti perjalanan Sang Undead Terpilih untuk membunyikan lonceng, mengumpulkan jiwa-jiwa yang kuat, dan menghadapi para dewa untuk menentukan nasib dunia. 
                </p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 bg-success text-white">
              <div class="card-body">
                <h5 class="card-title">Dark Souls 3</h5>
                <p class="card-text">
                  berlatar di kerajaan Lothric yang runtuh, di mana Sang Ashen One, seorang undead yang bangkit kembali, ditugaskan untuk mengumpulkan Lords of Cinder yang telah meninggalkan tahta mereka dan menghubungkan Api Pertama yang memudar untuk memperpanjang Zaman Api. Sepanjang perjalanan, pemain menghadapi berbagai musuh, makhluk, dan karakter yang kompleks, sambil mengungkap sejarah kelam Lothric dan konflik antara para dewa, manusia, dan makhluk lainnya. Cerita ini mengeksplorasi tema kehancuran, pengorbanan, dan siklus abadi antara cahaya dan kegelapan.
                </p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 bg-warning text-dark">
              <div class="card-body">
                <h5 class="card-title">Elden Ring</h5>
                <p class="card-text">
                  berlatar di dunia fantasi bernama The Lands Between, di mana pemain mengendalikan karakter yang dikenal sebagai Tarnished, yang dipanggil kembali ke tanah tersebut untuk mengumpulkan pecahan Elden Ring yang hilang dan menjadi Elden Lord. Sepanjang perjalanan, pemain menjelajahi dunia terbuka yang luas, bertemu dengan berbagai karakter, melawan makhluk-makhluk kuat, dan mengungkap misteri di balik kehancuran Elden Ring serta konflik antara dewa-dewa, manusia, dan makhluk lainnya. Cerita ini mengeksplorasi tema kekuasaan, takdir, dan pencarian jati diri di tengah dunia yang penuh bahaya dan keajaiban.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="gallery" class="text-center p-5 bg-light-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3 border-bottom border-dark">
          Gallery
        </h1>
        <div id="carouselExample" class="carousel slide mt-4">
          <div class="carousel-inner">
            <?php
            // Load gallery images from DB, fall back to static images if none
            $sqlG = "SELECT * FROM gallery ORDER BY tanggal DESC";
            $resG = $conn->query($sqlG);
            // Build slides server-side and only render carousel if at least one slide exists
            $sqlG = "SELECT * FROM gallery WHERE gambar <> '' ORDER BY tanggal DESC";
            $resG = $conn->query($sqlG);
            $slides = '';
            $slideCount = 0;
            if ($resG && $resG->num_rows > 0){
                while ($g = $resG->fetch_assoc()){
                    $gpath = __DIR__ . '/img/' . $g['gambar'];
                    if (!empty($g['gambar']) && file_exists($gpath)){
                        $gurl = 'img/' . rawurlencode($g['gambar']);
                        $active = ($slideCount==0)? ' active' : '';
                        $slides .= '<div class="carousel-item' . $active . '">';
                        $slides .= '<img src="' . $gurl . '" class="d-block w-100" alt="' . htmlspecialchars($g['judul']) . '">';
                        $slides .= '</div>';
                        $slideCount++;
                    }
                }
            }
            if ($slideCount > 0){
                echo $slides;
            } else {
                // no slides found; the client-side script will replace the carousel with a message
            }
            ?>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExample"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </section>

<script>
$(function(){
  var $carousel = $('#carouselExample');
  if ($carousel.length) {
    $carousel.find('.carousel-item').each(function(){
      var $img = $(this).find('img');
      if ($img.length && ($img.attr('alt') === 'gambar' || ($img.attr('src') && $img.attr('src').indexOf('data:image/svg+xml') === 0))) {
         $(this).remove();
      }
    });
    var cnt = $carousel.find('.carousel-item').length;
    if (cnt === 0) {
       $carousel.replaceWith('<div class="mt-4 text-center text-muted"><small>Tidak ada gambar gallery saat ini.</small></div>');
    } else if (cnt === 1) {
       $carousel.find('.carousel-control-prev, .carousel-control-next').remove();
    }
  }
});
</script>

    <section id="jadwal" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3 border-bottom border-dark"> Jadwal Kuliah dan Kegiatan Mahasiswa </h1>
        <div class="row row-cols-1 row-cols-sm-4 row-cols-md-7 g-3 justify-content-left">

          <div class="col">
              <div class="card h-100 bg-primary text-white shadow">
                <div class="card-header fw-bold fs-5 p-2 "> Senin </div> 
                <div class="card-body p-2 text-center bg-white text-dark">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>08:00 - 10:00</strong>
                  </div>
                  <div>
                    <p class="small mb-0">Kalkulus</p>
                  </div>
                </div>
              </div>
          </div>

          <div class="col">
              <div class="card h-100 bg-success shadow">
                <div class="card-header fw-bold fs-5 p-2 text-white"> Selasa </div> 
                <div class="card-body p-2 text-center bg-white">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>09:00 - 11:00</strong>
                  </div>
                  <div>
                    <p class="small mb-0">Pemrograman Web</p>
                  </div>
                </div>
              </div>
          </div>

          <div class="col">
              <div class="card h-100 bg-danger text-white shadow">
                <div class="card-header fw-bold fs-5 p-2"> Rabu </div> 
                <div class="card-body p-2 text-center bg-white text-dark">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>10:00 - 12:00</strong>
                  </div>
                  <div>
                    <p class="small mb-0">Basis Data</p>
                  </div>
                </div>
              </div>
          </div>

          <div class="col">
              <div class="card h-100 bg-warning text-white shadow">
                <div class="card-header fw-bold fs-5 p-2 text-white"> Kamis </div> 
                <div class="card-body p-2 text-center bg-white text-dark">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>08:00 - 10:00</strong>
                  </div>
                  <div>
                    <p class="small mb-0">Algoritma</p>
                  </div>
                </div>
              </div>
          </div>

          <div class="col">
              <div class="card h-100 bg-info text-white shadow">
                <div class="card-header fw-bold fs-5 p-2 text-white"> Jumat </div> 
                <div class="card-body p-2 text-center bg-white text-dark">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>13:00 - 15:00</strong>
                  </div>
                  <div>
                    <p class="small mb-0">Praktik Pemrograman</p>
                  </div>
                </div>
              </div>
          </div>

          <div class="col">
              <div class="card h-100 bg-secondary text-white shadow">
                <div class="card-header fw-bold fs-5 p-2 text-white"> Sabtu </div> 
                <div class="card-body p-2 text-center bg-white text-dark">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>09:00 - 11:00</strong>
                  </div>
                  <div>
                    <p class="small mb-0">Rapat Kelompok</p>
                  </div>
                </div>
              </div>
          </div>

          <div class="col">
              <div class="card h-100 bg-dark text-white shadow">
                <div class="card-header fw-bold fs-5 p-2 text-white"> Minggu </div> 
                <div class="card-body p-2 text-start bg-white text-dark">
                  <div class="mb-2 border-bottom border-white pb-1">
                    <strong>Libur</strong>
                  </div>
                </div>
              </div>
          </div>

          </div>
        </div>
      </div>
    </section>

    <section id="data-diri" class="p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3 border-bottom border-dark text-center"> Profil Mahasiswa</h1>
        <div class="row align-items-center mt-5">
          <div class="col-12 col-md-4 mb-4 mb-md-0 profile-img-container">
            <img src="./img/foto pas.png" alt="foto profil" class="img-fluid rounded-circle border border-primary border-0 profile-img">
          </div>
          <div class="col-12 col-md-8">
            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <tbody>
                  <tr>
                    <th>Nama Lengkap</th>
                    <td>Emil Fatha </td>
                  </tr>
                  <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>semarang, 12 Juni 2006</td>
                  </tr>
                  <tr>
                    <th>Alamat</th>
                    <td>Jl. Contoh No. 123, semarang</td>
                  </tr>
                  <tr>
                    <th>No. Telepon</th>
                    <td>+62 812-3456-7890</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>emil@example.com</td>
                  </tr>
                  <tr>
                    <th>Universitas</th>
                    <td>Universitas Dian Nuswantoro</td>
                  </tr>
                  <tr>
                    <th>Jurusan</th>
                    <td>Teknik Informatika</td>
                  </tr>
                  <tr>
                    <th>NIM</th>
                    <td>12345678</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </section>

    <footer class="text-center py-4 mt-5 border-top theme-footer">
      <p class="mb-0 fw-semibold">@Dibuat oleh emil dengan bootstrap</p>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="java.js"></script>
  </body>
</html>
