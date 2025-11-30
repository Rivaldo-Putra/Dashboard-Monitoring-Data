<?php require '../koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kategori</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {font-family:Inter,system-ui;background:#f9fafb;color:#1f2937;margin:0;}
    .header {background:#07c539;color:#fff;padding:16px 20px;display:flex;justify-content:space-between;align-items:center;}
    .container {max-width:1000px;margin:40px auto;padding:20px;}
    table {width:100%;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.1);}
    th {background:#07c539;color:#fff;padding:16px;text-align:left;}
    td {padding:16px;border-bottom:1px solid #eee;}
    img {width:60px;height:60px;object-fit:cover;border-radius:8px;}
    .btn {padding:6px 12px;border-radius:6px;text-decoration:none;margin:0 4px;font-weight:600;}
    .edit {background:#f59e0b;color:#fff;}
    .delete {background:#ef4444;color:#fff;}
    .add-btn {background:#07c539;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;}
  </style>
</head>
<body>
<div class="header">
  <h2>Daftar Kategori</h2>
  <div>
    <a href="categories-entry.php" class="add-btn">+ Tambah Kategori</a>
    <a href="../admin.php" style="color:#fff;margin-left:15px;">Kembali ke Admin</a>
  </div>
</div>

<div class="container">
  <table>
    <tr><th>No</th><th>Gambar</th><th>Nama</th><th>Harga</th><th>Deskripsi</th><th>Aksi</th></tr>
    <?php
    $no = 1;
    $stmt = $pdo->query("SELECT * FROM tb_categories ORDER BY id_categories DESC");
    while ($row = $stmt->fetch()) {
        $photo = $row['photo'] ?? '';
        $nama  = $row['nama_categories'] ?? '-';
        $price = $row['price'] ?? 0;
        $desc  = $row['description'] ?? '-';

        echo "<tr>
          <td>$no</td>
          <td>
            " . ($photo ? "<img src='../img_categories/$photo' alt='photo'>" : "<img src='https://via.placeholder.com/60?text=No+Image'>") . "
          </td>
          <td><strong>" . htmlspecialchars($nama) . "</strong></td>
          <td>Rp " . number_format((float)$price) . "</td>
          <td>" . htmlspecialchars($desc) . "</td>
          <td>
            <a href='categories-edit.php?id={$row['id_categories']}' class='btn edit'>Edit</a>
            <a href='categories-hapus.php?id={$row['id_categories']}' class='btn delete'
               onclick=\"return confirm('Yakin hapus? Gambar akan ikut terhapus!')\">Hapus</a>
          </td>
        </tr>";
        $no++;
    }
    if ($no == 1) echo "<tr><td colspan='6' style='text-align:center;padding:50px;'>Belum ada kategori.</td></tr>";
    ?>
  </table>
</div>
</body>
</html>