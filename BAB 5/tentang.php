<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tentang - Dashboard Monitoring Data</title>
  <style>
    :root{
      --green:#2f855a;
      --dark:#123;
      --muted:#6b7280;
    }
    body{
      font-family:Inter,Arial,sans-serif;
      margin:0;
      background:#f8faf9;
      color:var(--dark);
    }
    header{
      background:var(--green);
      color:#fff;
      padding:14px 20px;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    nav a{
      color:#fff;
      text-decoration:none;
      margin-left:12px;
    }
    nav a:hover{
      text-decoration:underline;
    }
    .container{
      max-width:900px;
      margin:30px auto;
      padding:20px;
      background:#fff;
      border-radius:10px;
      box-shadow:0 4px 12px rgba(0,0,0,0.08);
    }
    h2{
      color:var(--green);
    }
    p{
      line-height:1.6;
      text-align:justify;
    }
    footer{
      text-align:center;
      padding:15px;
      color:var(--muted);
      margin-top:40px;
    }
  </style>
</head>
<body>
  <header>
    <div class="brand">Dashboard Monitoring Data</div>
    <nav>
      <a href="index.php">Beranda</a>
      <a href="tentang.php">Tentang</a>
      <a href="#" style="opacity:0.5;cursor:not-allowed;">Dashboard (Login)</a>
    </nav>
  </header>

  <main class="container">
    <h2>Tentang Aplikasi</h2>
    <p>
      <strong>Dashboard Monitoring Data</strong> merupakan proyek web sederhana
      yang dibuat untuk latihan implementasi <em>JavaScript DOM</em>,
      <em>event handling</em>, <em>web storage</em>, serta <em>asynchronous request</em>
      menggunakan <code>fetch()</code>.
    </p>
    <p>
      Aplikasi ini menampilkan simulasi data kategori dan transaksi wisata
      yang disimpan di <code>localStorage</code>. Selain itu,
      terdapat fitur notifikasi berbasis <strong>Toast/Snackbar</strong>,
      serta <strong>pop-up interaktif</strong> seperti <code>alert</code>,
      <code>confirm</code>, dan <code>prompt</code>.
    </p>
    <p>
      Halaman <strong>Dashboard</strong> hanya dapat diakses setelah login.
      Fungsinya untuk menampilkan data statistik secara lebih rinci dan real-time.
      Dengan ini pengguna dapat memantau data dengan antarmuka yang lebih interaktif.
    </p>
    <p>
      Proyek ini dikembangkan sepenuhnya menggunakan HTML, CSS, dan JavaScript murni
      tanpa framework tambahan — agar lebih mudah dipelajari dan dipahami konsep dasarnya.
    </p>
  </main>

  <footer>© 2025 Dashboard Monitoring Data</footer>
</body>
</html>
