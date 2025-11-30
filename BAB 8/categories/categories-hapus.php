<?php
require '../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: categories.php");
    exit;
}

$id = $_GET['id'];

try {
    // Cek apakah kategori ini dipakai di transaksi
    $cek = $pdo->prepare("SELECT COUNT(*) FROM tb_transaction WHERE id_kategori = ?");
    $cek->execute([$id]);
    $jumlah = $cek->fetchColumn();

    if ($jumlah > 0) {
        // PAKAI SWEETALERT-STYLE TAPI TETAP PAKAI ALERT BIAR SIMPEL
        echo "
        <script>
            alert('GAGAL MENGHAPUS KATEGORI!\\n\\nKategori ini sedang digunakan di $jumlah transaksi.\\n\\nSilakan hapus atau ubah transaksi tersebut terlebih dahulu sebelum menghapus kategori ini.');
            window.location = 'categories.php';
        </script>
        ";
        exit;
    }

    // Jika aman → hapus kategori + gambar
    $stmt = $pdo->prepare("SELECT photo FROM tb_categories WHERE id_categories = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetchColumn();

    $stmt = $pdo->prepare("DELETE FROM tb_categories WHERE id_categories = ?");
    $stmt->execute([$id]);

    if ($photo && file_exists("../img_categories/$photo")) {
        unlink("../img_categories/$photo");
    }

    echo "
    <script>
        alert('Kategori berhasil dihapus!');
        window.location = 'categories.php';
    </script>
    ";

} catch (Exception $e) {
    echo "
    <script>
        alert('Gagal menghapus!\\nKategori ini tidak bisa dihapus karena masih terkait dengan data transaksi.');
        window.location = 'categories.php';
    </script>
    ";
}
?>