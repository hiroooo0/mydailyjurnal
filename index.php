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

      html, body{
        background: var(--bg) !important;
        color: var(--text) !important;
        transition: background-color 200ms ease, color 200ms ease;
        font-family: 'Raleway', sans-serif;
      }

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

      #theme-toggle{
        border: 1px solid rgba(255,255,255,0.25);
        color: var(--nav-text);
        background: transparent;
      }
      #theme-toggle:focus{ outline: none; box-shadow: none; }
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
            src="./img/pict1.jpeg"
            width="300"
            class="img-fluid mb-3 mb-sm-0"
            alt="Banner"
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
    <h1 class="fw-bold display-4 pb-3">article</h1>
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
                <h5 class="card-title">Kolom 1</h5>
                <p class="card-text">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed,
                  temporibus quaerat doloremque, porro ut, possimus voluptates
                  minus earum debitis quia ea explicabo. Veritatis, commodi qui
                  laborum nesciunt dolor est non ipsa impedit beatae rerum
                  provident at ipsum a nisi harum quos natus deleniti vitae
                  earum iusto autem! Similique, necessitatibus, quasi impedit
                  itaque at porro placeat consequatur, unde hic soluta quos
                  dignissimos obcaecati culpa reiciendis aspernatur! Quibusdam
                  ipsa ad culpa rerum perspiciatis illo aut, et quae maiores
                  iste, nam commodi fugiat vitae quam aperiam? Autem quam quasi
                  expedita delectus obcaecati eos. Blanditiis fugiat qui vero,
                  inventore culpa aspernatur deleniti illo minima.
                </p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 bg-success text-white">
              <div class="card-body">
                <h5 class="card-title">Kolom 2</h5>
                <p class="card-text">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Eaque quisquam, consectetur dolorem, sint numquam unde quos
                  ducimus modi magni vitae necessitatibus fuga soluta eligendi
                  exercitationem velit hic qui maxime atque, voluptas aliquam
                  aperiam illo! Alias expedita consequuntur officiis quod
                  tenetur, quisquam beatae dolor quidem provident maiores
                  adipisci! Corporis, sunt temporibus. Atque magnam laboriosam
                  deserunt ipsa quia est nostrum similique sint nemo excepturi.
                </p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card h-100 bg-warning text-dark">
              <div class="card-body">
                <h5 class="card-title">Kolom 3</h5>
                <p class="card-text">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                  Vitae obcaecati, rerum voluptates odio quidem ipsum qui 
                  pariatur error doloremque excepturi velit voluptas exercitationem 
                  dolorem nobis at quasi saepe tempore laudantium fugiat aliquam 
                  ratione dignissimos? Animi illum nesciunt reiciendis porro 
                  voluptatem alias numquam maiores saepe?
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
            <div class="carousel-item active">
              <img src="./img/pict2.jpeg" class="d-block w-100" alt="Gambar 1" />
            </div>
            <div class="carousel-item">
              <img src="./img/pict3.jpeg" class="d-block w-100" alt="Gambar 2" />
            </div>
            <div class="carousel-item">
              <img src="./img/pict4.jpeg" class="d-block w-100" alt="Gambar 3" />
            </div>
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
