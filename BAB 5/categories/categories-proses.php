<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaKategori = trim($_POST['namaKategori'] ?? '');

    if ($namaKategori === '') {
        echo "<script>alert('Nama kategori tidak boleh kosong!');history.back();</script>";
        exit;
    }

    // Simpan data ke session
    if (!isset($_SESSION['categories'])) {
        $_SESSION['categories'] = [];
    }

    $_SESSION['categories'][] = ['name' => $namaKategori];

    echo "<script>
        alert('Kategori berhasil ditambahkan!');
        window.location.href='categories.php';
    </script>";
    exit;
} else {
    echo "<script>alert('Akses tidak valid!');window.location.href='categories-entry.php';</script>";
}
?>
