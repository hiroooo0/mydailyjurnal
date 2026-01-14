<?php
session_start();

include "koneksi.php";

if (!isset($_SESSION['username'])) { 
	header("location:login.php"); 
} 
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

      /* Dark-mode helpers (cards, text, and white backgrounds) */
      [data-theme="dark"] .text-dark {
        color: var(--section-text) !important;
      }
      [data-theme="dark"] .card {
        background-color: var(--section-bg) !important;
        color: var(--section-text) !important;
        border-color: rgba(255,255,255,0.06) !important;
      }
      [data-theme="dark"] .card .card-body,
      [data-theme="dark"] .card .card-header,
      [data-theme="dark"] .card .card-footer,
      [data-theme="dark"] .card .card-title,
      [data-theme="dark"] .card .card-text,
      [data-theme="dark"] .text-body-secondary {
        color: var(--section-text) !important;
      }
      [data-theme="dark"] .bg-white {
        background-color: transparent !important;
        color: var(--section-text) !important;
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

      /* Make footer sticky to bottom even when content is short */
      html, body { height: 100%; }
      body { display: flex; flex-direction: column; min-height: 100vh; }
      section#content { flex: 1; padding-bottom: 160px; }
      footer { margin-top: auto; width: 100%; }
    </style>
  </head>
  <body>

    <!-- nav begin -->
    <nav class="navbar navbar-expand-lg theme-navbar">
    <div class="container">
        <a class="navbar-brand" href="">My Daily Journal</a>
        <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
          <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?page=article">Article</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?page=gallery">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php?page=user">User</a>
            </li>
            <li class="nav-item ms-2">
              <button id="theme-toggle" class="btn btn-sm" aria-label="Toggle theme">
                <i id="theme-icon" class="bi bi-moon-fill"></i>
              </button>
            </li>                                  
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $_SESSION['username']?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li> 
                </ul>
            </li> 
        </ul>
        </div>
    </div>
    </nav>
    <!-- nav end -->
    <!-- content begin -->
     <section id="content" class="p-5">
      <div class="container">
          <?php
          if(isset($_GET['page'])){
          ?>
            <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle"><?= ucfirst($_GET['page'])?></h4>
            <?php
            include($_GET['page'].".php");
          }else{
          ?>
            <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle">Dashboard</h4>
            <?php
            include("dashboard.php");
          }
        ?>
      </div>
    </section>
    <!-- content begin -->
    
<!-- content end -->
    <!-- content end -->
    <!-- footer begin -->
    <footer class="text-center py-4 mt-5 border-top theme-footer">
      <p class="mb-0 fw-semibold">@Dibuat oleh emil dengan bootstrap</p>
    </footer>
    <!-- footer end -->
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
    ></script>
    <script src="java.js"></script>
</body>
</html> 