<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo "<script>alert('Username dan password wajib diisi!'); window.location='login.php';</script>";
        exit;
    }

    // Cari user berdasarkan username
    $stmt = $pdo->prepare("SELECT id, username, password FROM tb_admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['admin_id']   = $user['id'];
        $_SESSION['admin_nama'] = $user['username'];
        header("Location: admin.php");
        exit;
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
    }
}
?>