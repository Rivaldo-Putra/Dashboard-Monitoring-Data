<?php
require '../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: categories.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tb_categories WHERE id_categories = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();

if (!$cat) {
    echo "<script>alert('Kategori tidak ditemukan!'); window.location='categories.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kategori</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {font-family:Inter,system-ui;background:#f9fafb;color:#1f2937;margin:0;}
    .container {max-width:600px;margin:40px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.1);}
    h2 {color:#07c539;margin-bottom:20px;text-align:center;}
    label {display:block;margin:15px 0 8px;font-weight:600;}
    input, textarea, button {width:100%;padding:12px;border-radius:8px;border:1px solid #ddd;margin-bottom:10px;}
    button {background:#07c539;color:#fff;border:none;cursor:pointer;font-weight:600;font-size:1rem;}
    button:hover {background:#059669;}
    .current-img img {width:150px;height:150px;object-fit:cover;border-radius:10px;border:3px solid #ddd;}
    .back {display:inline-block;margin-top:20px;color:#07c539;text-decoration:none;font-weight:600;}
  </style>
</head>
<body>
<div class="container">
  <h2>Edit Kategori</h2>

  <form action="categories-proses.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $cat['id_categories'] ?>">
    <input type="hidden" name="photoLama" value="<?= htmlspecialchars($cat['photo'] ?? '') ?>">

    <?php if (!empty($cat['photo'])): ?>
      <label>Gambar Saat Ini</label>
      <div class="current-img" style="text-align:center;margin:15px 0;">
        <img src="../img_categories/<?= htmlspecialchars($cat['photo']) ?>" alt="Current">
      </div>
    <?php endif; ?>

    <label>Ganti Gambar (kosongkan jika tidak ingin ganti)</label>
    <input type="file" name="photo" accept="image/*">

    <label>Nama Kategori</label>
    <input type="text" name="categories" value="<?= htmlspecialchars($cat['nama_categories'] ?? '') ?>" required>

    <label>Harga (Rp)</label>
    <input type="number" name="price" value="<?= htmlspecialchars($cat['price'] ?? '') ?>" required>

    <label>Deskripsi</label>
    <textarea name="description" rows="5" required><?= htmlspecialchars($cat['description'] ?? '') ?></textarea>

    <button type="submit" name="edit">Update Kategori</button>
  </form>

  <a href="categories.php" class="back">← Kembali ke Daftar Kategori</a>
</div>
</body>
</html>