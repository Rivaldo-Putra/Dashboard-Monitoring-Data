<?php
require '../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
$admin_name = $_SESSION['admin_nama'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan</title>
    <style>
        body {font-family: Arial, sans-serif; background: #f4f6f9; margin:0; padding:20px;}
        .container {max-width:1400px; margin:auto; background:#fff; padding:30px; border-radius:15px; box-shadow:0 10px 30px rgba(0,0,0,.1);}
        h2 {text-align:center; color:#07c539;}
        .btn {display:inline-block; padding:12px 25px; background:#07c539; color:#fff; text-decoration:none; border-radius:8px; margin:20px 0;}
        table {width:100%; border-collapse:1px solid #ddd; border-collapse:collapse; margin-top:20px;}
        th, td {padding:12px; text-align:center; border:1px solid #ddd;}
        th {background:#07c539; color:#fff;}
        tr:nth-child(even) {background:#f9f9f9;}
        .btn-edit {background:#f39c12; color:#fff; padding:6px 12px; border:none; border-radius:5px; text-decoration:none;}
        .btn-hapus {background:#e74c3c; color:#fff; padding:6px 12px; border:none; border-radius:5px; cursor:pointer;}
        .total {background:#d5f5d9; font-weight:bold; font-size:1.1rem;}
    </style>
</head>
<body>
<div class="container">
      <div style="display:flex; justify-content:space-between; align-items:center; margin:20px 0; flex-wrap:wrap; gap:15px;">
    <!-- Tombol Tambah Transaksi -->
    <a href="tambah-transaksi.php" class="add-btn" style="font-size:1rem; font-weight:bold; color:#9b59b6;">
        + Tambah Transaksi
    </a>

    <!-- Tombol Kembali ke Admin -->
    <a href="../admin.php" style="display:inline-block; padding:12px 24px; background:#07c539; color:white; text-decoration:none; border-radius:10px; font-weight:bold; box-shadow:0 5px 15px rgba(7,197,57,0.4); transition:0.3s;">
        Kembali ke Dashboard Admin
    </a>
</div>
</div>
    <h2>DAFTAR TRANSAKSI PENJUALAN</h2>
    <p style="text-align:center;">Selamat datang, <strong><?=htmlspecialchars($admin_name)?></strong></p>

    <a href="transaction-cetak.php" target="_blank" class="btn">Cetak Laporan PDF</a>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pembeli</th>
            <th>No. HP</th>
            <th>Produk</th>
            <th>Jumlah (kg)</th>
            <th>Total Harga</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $totalPendapatan = 0;
        $stmt = $pdo->query("SELECT t.*, c.nama_categories FROM tb_transaction t LEFT JOIN tb_categories c ON t.id_kategori = c.id_categories ORDER BY t.id_transaksi DESC");
        while ($r = $stmt->fetch()) {
            $totalPendapatan += $r['total_harga'];
            echo "<tr>
                <td>$no</td>
                <td>".date('d-m-Y', strtotime($r['tanggal']))."</td>
                <td><strong>{$r['pembeli']}</strong></td>
                <td>{$r['no_hp_pembeli']}</td>
                <td>{$r['nama_categories']}</td>
                <td><strong>{$r['jumlah_kg']}</strong></td>
                <td>Rp ".number_format($r['total_harga'])."</td>
                <td>{$r['alamat']}</td>
                <td>
                    <a href='edit-transaksi.php?id={$r['id_transaksi']}' class='btn-edit'>Edit</a>
                    <button class='btn-hapus' onclick=\"if(confirm('Yakin hapus?')) location.href='hapus-transaksi.php?id={$r['id_transaksi']}'\">Hapus</button>
                </td>
            </tr>";
            $no++;
        }
        if ($no == 1) {
            echo "<tr><td colspan='9' style='padding:40px; color:#999;'>Belum ada transaksi</td></tr>";
        } else {
            echo "<tr class='total'>
                <td colspan='6'>TOTAL PENDAPATAN</td>
                <td colspan='3'>Rp ".number_format($totalPendapatan)."</td>
            </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>