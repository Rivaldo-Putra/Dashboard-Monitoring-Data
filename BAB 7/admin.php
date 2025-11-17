<?php
require 'koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['admin_nama'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pertanian Admin</title>
  <link rel="icon" href="assets/icon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <!-- BOXICONS - WAJIB UNTUK TUGAS -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/style.css">
  <style>
    :root {
      --primary:#04b40d;--sidebar-bg:#07c539;--bg:#f9fafb;--text:#1f2937;--border:#e5e7eb;--success:#16a34a;--danger:#ef4444;
    }
    * {box-sizing:border-box;margin:0;padding:0;font-family:Inter,system-ui,Arial,sans-serif;}
    body {background:var(--bg);color:var(--text);display:flex;min-height:100vh;}
    .sidebar {
      width:260px;background:var(--sidebar-bg);color:#fff;padding:20px 0;position:fixed;height:100%;left:0;top:0;z-index:1000;
      box-shadow:2px 0 10px rgba(0,0,0,.1);transition:width .3s ease;
    }
    .sidebar.active {width:80px;}
    .sidebar.active .logo span, .sidebar.active a span {display:none;}
    .sidebar.active a {justify-content:center;}
    .sidebar .logo {font-size:1.5rem;font-weight:700;padding:0 24px;margin-bottom:30px;display:flex;align-items:center;}
    .sidebar a {
      display:flex;align-items:center;padding:12px 24px;color:#fff;text-decoration:none;font-size:.95rem;
      transition:.2s;border-left:4px solid transparent;cursor:pointer;
    }
    .sidebar a:hover, .sidebar a.active {background:rgba(255,255,255,.2);border-left-color:#fff;}
    .sidebar a i {margin-right:12px;width:20px;text-align:center;font-size:1.3rem;}
    .main-content {margin-left:260px;flex:1;transition:margin-left .3s ease;}
    .topbar {
      background:#fff;padding:14px 24px;display:flex;justify-content:space-between;align-items:center;
      box-shadow:0 1px 3px rgba(0,0,0,.1);position:sticky;top:0;z-index:900;
    }
    .topbar .user {font-size:.9rem;color:#6b7280;}
    .topbar .user i {margin-right:6px;}
    .content {padding:40px;min-height:calc(100vh - 64px);}
    .grid {display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:20px;}
    .card {
      background:#fff;padding:24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);
      border:1px solid var(--border);
    }
    .card h3 {margin-bottom:12px;color:#374151;}
    .card p {color:#6b7280;font-size:.95rem;}
    .sidebarBtn {
      position:fixed;top:15px;left:270px;width:45px;height:45px;background:var(--sidebar-bg);color:white;
      font-size:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;
      z-index:999;box-shadow:0 4px 10px rgba(0,0,0,0.2);transition:left .3s ease;
    }
    .sidebar.active ~ .main-content .sidebarBtn {left:90px;}
    .home-content h2 {font-size:1.9rem;font-weight:700;color:#1f2937;margin:0;}
    .home-content h3 {font-size:1rem;color:#6b7280;margin:8px 0 20px;font-weight:500;}
    @media (max-width:992px) {
      .sidebar{width:80px;}.sidebar .logo span,.sidebar a span{display:none;}.sidebar a{justify-content:center;}
      .main-content{margin-left:80px;}.sidebarBtn{left:90px;}
    }
  </style>
</head>
<body>

  <!-- TOMBOL SIDEBAR (BOXICONS) -->
  <div class="sidebarBtn">
    <i class='bx bx-menu'></i>
  </div>

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="logo"><i class="fas fa-seedling"></i> <span>Pertanian</span></div>
    <nav>
      <a href="#" class="active"><i class='bx bxs-dashboard'></i> <span>Dashboard</span></a>
      <a href="categories/categories.php"><i class='bx bxs-category'></i> <span>Categories</span></a>
      <a href="transaction/transaction.php"><i class='bx bxs-cart'></i> <span>Transaction</span></a>
      <a href="logout.php"><i class='bx bxs-log-out'></i> <span>Log out</span></a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <header class="topbar">
      <div></div>
      <div class="user"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($admin_name) ?></div>
    </header>
    <main class="content">
      <div class="home-content">
        <h2 id="text"><?= htmlspecialchars($admin_name) ?></h2>
        <h3 id="date"></h3>
      </div>
      <p>Kelola semua data pertanian dengan mudah dan cepat.</p>
      <div class="grid">
        <div class="card"><h3>Total Kategori</h3><p style="font-size:1.8rem;font-weight:700;color:var(--primary);" id="totalCat">0</p></div>
        <div class="card"><h3>Total Transaksi</h3><p style="font-size:1.8rem;font-weight:700;color:var(--primary);" id="totalTrx">0</p></div>
        <div class="card"><h3>Status Sistem</h3><p style="color:var(--success);font-weight:600;">Semua berjalan normal</p></div>
      </div>
    </main>
  </div>

  <!-- JAVASCRIPT 100% SESUAI TUGAS DOSEN -->
  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else {
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      }
    };

    function myFunction() {
      const months = ["Januari", "Februari", "Maret", "April", "Mei",
        "Juni", "Juli", "Agustus", "September",
        "Oktober", "November", "Desember"
      ];
      const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis",
        "Jumat", "Sabtu"
      ];
      let date = new Date();
      jam = date.getHours();
      tanggal = date.getDate();
      hari = days[date.getDay()];
      bulan = months[date.getMonth()];
      tahun = date.getFullYear();
      let m = date.getMinutes();
      let s = date.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById("date").innerHTML = `${hari}, ${tanggal} ${bulan} ${tahun}, ${jam}:${m}:${s}`;
      requestAnimationFrame(myFunction);
    }

    function checkTime(i) {
      if (i < 10) {
        i = "0" + i;
      }
      return i;
    }

    window.onload = function() {
      let date = new Date();
      jam = date.getHours();
      if (jam >= 4 && jam <= 10) {
        document.getElementById("text").insertAdjacentText("afterbegin", "Selamat Pagi, ");
      } else if (jam >= 11 && jam <= 14) {
        document.getElementById("text").insertAdjacentText("afterbegin", "Selamat Siang, ");
      } else if (jam >= 15 && jam <= 18) {
        document.getElementById("text").insertAdjacentText("afterbegin", "Selamat Sore, ");
      } else {
        document.getElementById("text").insertAdjacentText("afterbegin", "Selamat Malam, ");
      }
      myFunction();
    };
  </script>
</body>
</html>