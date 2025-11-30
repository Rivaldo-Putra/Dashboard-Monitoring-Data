<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die("ID transaksi tidak valid!");
}

// Ambil data transaksi
$stmt = $pdo->prepare("SELECT t.*, c.nama_categories FROM tb_transaction t LEFT JOIN tb_categories c ON t.id_kategori = c.id_categories WHERE t.id_transaksi = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    die("Transaksi tidak ditemukan!");
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah = (int)$_POST['jumlah'];
    $alamat = trim($_POST['alamat']);

    if ($jumlah > 0 && !empty($alamat)) {
        // Hitung ulang total_harga berdasarkan harga kategori
        $harga_per_kg = $pdo->prepare("SELECT price FROM tb_categories WHERE id_categories = ?")->execute([$data['id_kategori']]);
        $harga = $pdo->query("SELECT price FROM tb_categories WHERE id_categories = " . (int)$data['id_kategori'])->fetchColumn();
        $total_harga = $harga * $jumlah;

        $update = $pdo->prepare("UPDATE tb_transaction SET jumlah_kg = ?, total_harga = ?, alamat = ? WHERE id_transaksi = ?");
        $update->execute([$jumlah, $total_harga, $alamat, $id]);

        header("Location: transaction.php?status=updated");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi #<?= $id ?></title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;padding:40px;}
        .box{max-width:600px;margin:auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.1);}
        h2{color:#07c539;text-align:center;}
        label{display:block;margin:15px 0 5px;font-weight:bold;}
        input, textarea{width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-size:1rem;}
        button{padding:12px 25px;background:#07c539;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:1rem;}
        button:hover{background:#059126;}
        a{color:#07c539;text-decoration:none;margin-left:10px;}
    </style>
</head>
<body>
<div class="box">
    <h2>Edit Transaksi: <?= htmlspecialchars($data['pembeli']) ?></h2>
    <p><strong>Produk:</strong> <?= htmlspecialchars($data['nama_categories'] ?? 'Tidak diketahui') ?><br>
       <strong>Harga per kg:</strong> Rp <?= number_format($pdo->query("SELECT price FROM tb_categories WHERE id_categories = " . (int)$data['id_kategori'])->fetchColumn() ?: 0) ?></p>

    <form method="POST">
        <label>Jumlah (kg)</label>
        <input type="number" name="jumlah" value="<?= $data['jumlah_kg'] ?>" min="1" required>

        <label>Alamat Pengiriman</label>
        <textarea name="alamat" rows="4" required><?= htmlspecialchars($data['alamat']) ?></textarea>

        <div style="margin-top:20px;">
            <button type="submit">Simpan Perubahan</button>
            <a href="transaction.php">Batal</a>
        </div>
    </form>
</div>
</body>
</html>