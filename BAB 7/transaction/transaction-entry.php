<?php require '../koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Transaksi</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {font-family:Inter,system-ui;background:#f9fafb;color:#1f2937;margin:0;}
    .container {max-width:600px;margin:40px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.1);}
    h2 {color:#07c539;text-align:center;margin-bottom:20px;}
    label {display:block;margin:15px 0 8px;font-weight:600;}
    input, select, textarea {width:100%;padding:12px;border-radius:8px;border:1px solid #ddd;margin-bottom:10px;}
    button {background:#07c539;color:#fff;padding:12px;border:none;border-radius:8px;cursor:pointer;font-weight:600;}
  </style>
</head>
<body>
<div class="container">
  <h2>Tambah Transaksi Baru</h2>
  <form action="transaction-proses.php" method="POST">
    <label>Kategori Produk</label>
    <select name="id_kategori" required>
      <option value="">Pilih Kategori</option>
      <?php
      $cats = $pdo->query("SELECT id_categories, nama_categories, price FROM tb_categories")->fetchAll();
      foreach ($cats as $c) {
          echo "<option value='{$c['id_categories']}' data-harga='{$c['price']}'>{$c['nama_categories']} - Rp " . number_format($c['price']) . "/kg</option>";
      }
      ?>
    </select>

    <label>Nama Pembeli</label>
    <input type="text" name="pembeli" required>

    <label>No. HP Pembeli</label>
    <input type="text" name="no_hp_pembeli" required>

    <label>Alamat Pengiriman</label>
    <textarea name="alamat" rows="3" required></textarea>

    <label>Jumlah (Kg)</label>
    <input type="number" name="jumlah_kg" min="1" required onchange="hitungTotal()">

    <label>Total Harga</label>
    <input type="text" name="total_harga" id="total_harga" readonly style="background:#f0fdf4;color:#166534;font-weight:bold;">

    <label>Tanggal Transaksi</label>
    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>

    <button type="submit" name="simpan">Simpan Transaksi</button>
  </form>
  <a href="transaction.php" style="display:block;text-align:center;margin-top:20px;color:#07c539;">Kembali</a>
</div>

<script>
function hitungTotal() {
  const select = document.querySelector('select[name="id_kategori"]');
  const harga = select.selectedIndex > 0 ? select.options[select.selectedIndex].dataset.harga : 0;
  const jumlah = document.querySelector('input[name="jumlah_kg"]').value || 0;
  const total = harga * jumlah;
  document.getElementById('total_harga').value = total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : '';
}
</script>
</body>
</html>