<?php
//memulai session atau melanjutkan session yang sudah ada
session_start();

//menyertakan code dari file koneksi
include "koneksi.php";

//check jika sudah ada user yang login arahkan ke halaman admin
if (isset($_SESSION['username'])) { 
	header("location:admin.php"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['user'];
  
  //menggunakan fungsi enkripsi md5 supaya sama dengan password  yang tersimpan di database
  $password = md5($_POST['pass']);

	//prepared statement
  $stmt = $conn->prepare("SELECT username 
                          FROM user 
                          WHERE username=? AND password=?");

	//parameter binding 
  $stmt->bind_param("ss", $username, $password);//username string dan password string
  
  //database executes the statement
  $stmt->execute();
  
  //menampung hasil eksekusi
  $hasil = $stmt->get_result();
  
  //mengambil baris dari hasil sebagai array asosiatif
  $row = $hasil->fetch_array(MYSQLI_ASSOC);

  //check apakah ada baris hasil data user yang cocok
  if (!empty($row)) {
    //jika ada, simpan variable username pada session
    $_SESSION['username'] = $row['username'];

    //mengalihkan ke halaman admin
    header("location:admin.php");
  } else {
	  //jika tidak ada (gagal), alihkan kembali ke halaman login
    header("location:login.php");
  }

	//menutup koneksi database
  $stmt->close();
  $conn->close();
} else {
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
        --card-bg: #ffffff;
        --control-bg: #ffffff;
        --control-text: #000000;
        --control-border: rgba(0,0,0,0.12);
        --btn-danger-bg: #dc3545;
        --btn-danger-text: #ffffff;
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
        --card-bg: var(--section-bg);
        --control-bg: rgba(255,255,255,0.03);
        --control-text: var(--section-text);
        --control-border: rgba(255,255,255,0.12);
        --btn-danger-bg: #d64545;
        --btn-danger-text: #ffffff;
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

      .card{
        background: var(--card-bg) !important;
        color: var(--text) !important;
      }
      .card .card-body{ background: transparent; }

      .bi{ color: var(--text); }

      .form-control{
        background: var(--control-bg) !important;
        color: var(--control-text) !important;
        border: 1px solid var(--control-border) !important;
        box-shadow: none !important;
      }
      .form-control::placeholder{ color: rgba(0,0,0,0.5); }
      [data-theme="dark"] .form-control::placeholder{ color: rgba(255,255,255,0.6); }

      .btn-danger{
        background-color: var(--btn-danger-bg) !important;
        color: var(--btn-danger-text) !important;
        border-color: transparent !important;
      }
      .card.shadow{
        box-shadow: 0 6px 22px rgba(16,24,40,0.08) !important;
      }
      [data-theme="dark"] .card.shadow{
        box-shadow: 0 8px 30px rgba(2,6,23,0.6) !important;
      }

      hr{ border-color: rgba(0,0,0,0.08); }
      [data-theme="dark"] hr{ border-color: rgba(255,255,255,0.08); }

      .login-section{
        justify-content: center;
        text-align: left;
        margin-top: 20px;
        background: var(--card-bg);
        padding: 10px;
        border-radius: 10px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        color: var(--text);
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
      }
      [data-theme="dark"] .login-section{ box-shadow: 0 4px 10px rgba(255,255,255,0.02); }
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
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Data diri</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">login</a>
            </li>
            <li class="nav-item ms-2">
              <button id="theme-toggle" class="btn btn-sm" aria-label="Toggle theme">
                <i id="theme-icon" class="bi bi-moon-fill"></i>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <div class="container mt-5 pt-5">
      <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
          <div class="card border-0 shadow rounded-5">
            <div class="card-body">
              <div class="text-center mb-3">
                <i class="bi bi-person-circle h1 display-4"></i>
                <p>My Daily Journal</p>
                <hr />
              </div>
              <?php if(isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo htmlspecialchars($error); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              <?php endif; ?>
              <form action="" method="post">
                <input
                  type="text"
                  name="user"
                  class="form-control my-4 py-2 rounded-4"
                  placeholder="Username"
                  required
                />
                <input
                  type="password"
                  name="pass"
                  class="form-control my-4 py-2 rounded-4"
                  placeholder="Password"
                  required
                />
                <div class="text-center my-3 d-grid">
                  <button type="submit" class="btn btn-danger rounded-4">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="java.js"></script>
  </body>
</html>

<?php
}
?>