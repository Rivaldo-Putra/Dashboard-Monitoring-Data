<?php
require '../koneksi.php';

header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'error';
    exit;
}

$nama_kategori = $_POST['nama'] ?? '';
$jumlah_kg     = (int)($_POST['jumlah'] ?? 0);
$pembeli       = trim($_POST['pembeli'] ?? '');
$nohp          = trim($_POST['nohp'] ?? '');
$alamat        = trim($_POST['alamat'] ?? '');

if ($jumlah_kg < 1 || empty($pembeli) || empty($nohp) || empty($alamat)) {
    echo 'error validasi';
    exit;
}

// Ambil harga
$stmt = $pdo->prepare("SELECT price FROM tb_categories WHERE nama_categories = ? LIMIT 1");
$stmt->execute([$nama_kategori]);
$harga = $stmt->fetchColumn();

if (!$harga) {
    echo 'error harga';
    exit;
}

$total_harga = $harga * $jumlah_kg;

try {
    $sql = "INSERT INTO tb_transaction 
            (id_kategori, pembeli, no_hp_pembeli, alamat, jumlah_kg, total_harga, tanggal) 
            VALUES 
            ((SELECT id_categories FROM tb_categories WHERE nama_categories = ?), ?, ?, ?, ?, ?, CURDATE())";

    $insert = $pdo->prepare($sql);
    $insert->execute([$nama_kategori, $pembeli, $nohp, $alamat, $jumlah_kg, $total_harga]);
    echo 'success';
} catch (Exception $e) {
    echo 'error db: ' . $e->getMessage();
}
?>