<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama     = $_POST['detail-nama'];
    $nomor    = $_POST['detail-nomor'];
    $alamat   = $_POST['detail-alamat'];
    $kategori = $_POST['detail-kategori'];
    $harga    = $_POST['detail-harga'];
    $status   = "Success";
    $tanggal  = date('Y-m-d');

    if (empty($nama) || empty($nomor) || empty($alamat) || empty($kategori)) {
        echo "<script>alert('Pastikan semua data terisi!'); window.location='../index.php';</script>";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO tb_transaction 
        (pembeli, no_hp_pembeli, alamat, id_kategori, total_harga, tanggal) 
        VALUES (?, ?, ?, (SELECT id_categories FROM tb_categories WHERE nama_categories = ?), ?, ?)");
    
    if ($stmt->execute([$nama, $nomor, $alamat, $kategori, $harga, $tanggal])) {
        echo "<script>alert('Pesanan berhasil dikirim! Admin akan segera menghubungi Anda.'); window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan pesanan!'); window.location='../index.php';</script>";
    }
} else {
    header('location: ../index.php');
}
?>