<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kategori</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    :root{--green:#0cac37;--dark:#1f2937}
    body{font-family:system-ui,Arial,sans-serif;background:#f4f6f8;min-height:100vh;margin:0}
    header{background:var(--green);color:#fff;padding:14px 20px;display:flex;justify-content:space-between;align-items:center}
    .brand{font-weight:700;font-size:1.1rem}
    nav a{color:#fff;text-decoration:none;font-weight:600}
    .container{max-width:600px;margin:40px auto;padding:16px}
    .card{background:#fff;padding:28px;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.12)}
    label{display:block;margin-bottom:8px;font-weight:600;color:var(--dark)}
    input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;margin-bottom:16px;font-size:1rem}
    input:focus{outline:none;border-color:var(--green);box-shadow:0 0 0 3px rgba(12,172,55,.2)}
    .btn{background:var(--green);color:#fff;padding:12px 20px;border:none;border-radius:8px;cursor:pointer;font-weight:600;width:100%}
    .btn:hover{background:#0a8f2d}
    .back-link{margin-top:20px;display:block;text-align:center;color:var(--green);text-decoration:none;font-weight:600}
    .back-link:hover{text-decoration:underline}
  </style>
</head>
<body>

<header>
  <div class="brand">Tambah Kategori</div>
  <nav>
    <a href="categories.php">Kembali</a>
  </nav>
</header>

<div class="container">
  <div class="card">
    <form action="categories-proses.php" method="GET">
      <label for="nama">Nama Kategori</label>
      <input type="text" id="nama" name="nama" placeholder="Contoh: Padi, Jagung, Sayur" required>
      
      <button type="submit" class="btn">Simpan Kategori</button>
    </form>

    <a href="categories.php" class="back-link">← Batal & Kembali ke Daftar</a>
  </div>
</div>

</body>
</html>