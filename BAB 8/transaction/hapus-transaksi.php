<?php
session_start();
require '../koneksi.php';
if (!isset($_SESSION['admin_id'])) exit;

$id = (int)$_GET['id'] ?? 0;
if ($id > 0) {
    $pdo->prepare("DELETE FROM tb_transaction WHERE id_transaksi = ?")->execute([$id]);
}
header("Location: transaction.php");
exit;
?>