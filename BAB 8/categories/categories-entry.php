<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kategori</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {font-family:Inter,system-ui;background:#f9fafb;color:#1f2937;margin:0;}
    .container {max-width:600px;margin:40px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.1);}
    h2 {color:#07c539;}
    input, textarea, button {width:100%;padding:12px;margin:10px 0;border-radius:8px;border:1px solid #ddd;}
    button {background:#07c539;color:#fff;border:none;cursor:pointer;font-weight:600;}
    button:hover {background:#059669;}
    .back {display:inline-block;margin-top:20px;color:#07c539;text-decoration:none;}
  </style>
</head>
<body>
<div class="container">
  <h2><i class='bx bx-plus-circle'></i> Tambah Kategori</h2>
  <form action="categories-proses.php" method="POST" enctype="multipart/form-data">
    <label>Gambar Kategori</label>
    <input type="file" name="photo" accept="image/*" required>

    <label>Nama Kategori</label>
    <input type="text" name="categories" placeholder="Contoh: Padi" required>

    <label>Harga (Rp)</label>
    <input type="number" name="price" placeholder="Contoh: 50000" required>

    <label>Deskripsi</label>
    <textarea name="description" rows="4" placeholder="Jelaskan kategori ini..." required></textarea>

    <button type="submit" name="simpan">Simpan Kategori</button>
  </form>
  <a href="categories.php" class="back">← Kembali ke Daftar</a>
</div>
</body>
</html>