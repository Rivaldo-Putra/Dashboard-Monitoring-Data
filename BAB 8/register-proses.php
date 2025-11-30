<?php
require 'koneksi.php';   // ← SEKARANG $pdo SUDAH ADA!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field wajib diisi!'); window.location='register.php';</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid!'); window.location='register.php';</script>";
        exit;
    }

    // Cek duplikat
    $cek = $pdo->prepare("SELECT id FROM tb_admin WHERE username = ? OR email = ?");
    $cek->execute([$username, $email]);
    if ($cek->rowCount() > 0) {
        echo "<script>alert('Username atau Email sudah digunakan!'); window.location='register.php';</script>";
        exit;
    }

    // Simpan admin baru
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO tb_admin (username, email, password) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$username, $email, $hash])) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Gagal registrasi. Coba lagi.'); window.location='register.php';</script>";
    }
}
?>