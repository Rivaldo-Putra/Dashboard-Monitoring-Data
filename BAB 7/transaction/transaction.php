<?php require '../koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Transaksi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {font-family:Inter,system-ui;background:#f9fafb;color:#1f2937;margin:0;}
    .header {background:#07c539;color:#fff;padding:16px 20px;display:flex;justify-content:space-between;align-items:center;}
    .container {max-width:1300px;margin:40px auto;padding:20px;}
    table {width:100%;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.1);}
    th {background:#07c539;color:#fff;padding:16px;text-align:left;}
    td {padding:16px;border-bottom:1px solid #eee;vertical-align:top;}
    .btn {padding:6px 12px;border-radius:6px;text-decoration:none;margin:0 4px;font-weight:600;}
    .edit {background:#f59e0b;color:#fff;}
    .delete {background:#ef4444;color:#fff;}
    .add-btn {background:#07c539;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;}
  </style>
</head>
<body>
<div class="header">
  <h2>Daftar Transaksi</h2>
  <div>
    <a href="transaction-entry.php" class="add-btn">+ Tambah Transaksi</a>
    <a href="../admin.php" style="color:#fff;margin-left:15px;">Kembali ke Admin</a>
  </div>
</div>

<div class="container">
  <table>
    <tr>
      <th>No</th><th>Tanggal</th><th>Pembeli</th><th>No HP</th><th>Kategori</th><th>Jumlah (Kg)</th><th>Total Harga</th><th>Alamat</th><th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $stmt = $pdo->query("SELECT t.*, c.nama_categories FROM tb_transaction t 
                         LEFT JOIN tb_categories c ON t.id_kategori = c.id_categories 
                         ORDER BY t.tanggal DESC, t.created_at DESC");
    while ($row = $stmt->fetch()) {
        echo "<tr>
          <td>$no</td>
          <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
          <td><strong>{$row['pembeli']}</strong></td>
          <td>{$row['no_hp_pembeli']}</td>
          <td>{$row['nama_categories']}</td>
          <td>" . number_format($row['jumlah_kg']) . " Kg</td>
          <td>Rp " . number_format($row['total_harga']) . "</td>
          <td>" . nl2br(htmlspecialchars($row['alamat'])) . "</td>
          <td>
            <a href='transaction-edit.php?id={$row['id_transaksi']}' class='btn edit'>Edit</a>
            <a href='transaction-proses.php?hapus={$row['id_transaksi']}' class='btn delete'
               onclick=\"return confirm('Yakin hapus transaksi ini?')\">Hapus</a>
          </td>
        </tr>";
        $no++;
    }
    if ($no == 1) echo "<tr><td colspan='9' style='text-align:center;padding:60px;'>Belum ada transaksi.</td></tr>";
    ?>
  </table>
</div>
</body>
</html>