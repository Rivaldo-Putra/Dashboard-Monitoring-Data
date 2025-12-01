<?php

require '../koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: ../login.php"); exit; }

// Ambil semua kategori untuk dropdown
$kategori = $pdo->query("SELECT id_categories, nama_categories, price FROM tb_categories ORDER BY nama_categories")->fetchAll();
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = (int)$_POST['id_kategori'];
    $pembeli     = trim($_POST['pembeli']);
    $nohp        = trim($_POST['nohp']);
    $alamat      = trim($_POST['alamat']);
    $jumlah_kg   = (int)$_POST['jumlah'];

    // Ambil harga
    $harga = $pdo->prepare("SELECT price FROM tb_categories WHERE id_categories = ?");
    $harga->execute([$id_kategori]);
    $price = $harga->fetchColumn();

    $total = $price * $jumlah_kg;

    // Simpan
    $sql = "INSERT INTO tb_transaction (id_kategori, pembeli, no_hp_pembeli, alamat, jumlah_kg, total_harga, tanggal) 
            VALUES (?, ?, ?, ?, ?, ?, CURDATE())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_kategori, $pembeli, $nohp, $alamat, $jumlah_kg, $total]);

    $pesan = "<p style='color:green; text-align:center;'>Transaksi berhasil ditambahkan!</p>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi Baru</title>
    <style>
        body{font-family:Arial;background:#f4f6f9;padding:30px;}
        .box{max-width:700px;margin:auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.1);}
        h2{color:#07c539;text-align:center;}
        label{display:block;margin:15px 0 5px;font-weight:bold;}
        input, select, textarea{width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;}
        button{padding:12px 30px;background:#07c539;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:1rem;}
        button:hover{background:#059126;}
        a{color:#07c539;margin-left:15px;}
    </style>
</head>
<body>
<div class="box">
    <h2>+ Tambah Transaksi Baru</h2>
    <?= $pesan ?>

    <form method="POST">
        <label>Produk</label>
        <select name="id_kategori" required>
            <option value="">– Pilih Produk –</option>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_categories'] ?>">
                    <?= htmlspecialchars($k['nama_categories']) ?> – Rp <?= number_format($k['price']) ?>/kg
                </option>
            <?php endforeach; ?>
        </select>

        <label>Nama Pembeli</label>
        <input type="text" name="pembeli" required>

        <label>No. HP</label>
        <input type="text" name="nohp" required>

        <label>Jumlah (kg)</label>
        <input type="number" name="jumlah" min="1" value="1" required>

        <label>Alamat Pengiriman</label>
        <textarea name="alamat" rows="3" required></textarea>

        <div style="margin-top:25px;text-align:center;">
            <button type="submit">Simpan Transaksi</button>
            <a href="transaction.php">Batal</a>
        </div>
    </form>
</div>
</body>
</html>