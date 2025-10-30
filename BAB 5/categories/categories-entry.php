<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Category - Dashboard Monitoring Data Wisata</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="header">
    <h1>Dashboard Monitoring Data Wisata</h1>
    <nav>
      <a href="../dashbor.php">Dashboard</a>
      <a href="categories.php">Categories</a>
      <a href="categories-entry.php">Tambah Category</a>
    </nav>
  </header>

  <main class="container">
    <h2>Tambah Category</h2>

    <form action="categories-proses.php" method="post">
      <label>Nama Kategori</label>
      <input type="text" name="namaKategori" placeholder="Masukkan nama kategori" required>
      <button type="submit" class="btn">Simpan</button>
      <button type="reset" class="btn secondary">Batal</button>
    </form>
  </main>
</body>
</html>
