<?php
session_start();
$categories = $_SESSION['categories'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories - Dashboard Monitoring Data Wisata</title>
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
    <h2>Daftar Categories</h2>
    <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Category</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($categories)): ?>
          <tr><td colspan="2" style="text-align:center;">Belum ada data</td></tr>
        <?php else: ?>
          <?php foreach ($categories as $i => $cat): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($cat['name']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
