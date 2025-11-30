```php
<?php
require '../koneksi.php';
require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVuSans');
$dompdf = new Dompdf($options);

// Ambil semua transaksi + nama kategori (pakai LEFT JOIN biar tetap muncul meski kategori dihapus)
$stmt = $pdo->query("
    SELECT 
        t.*,
        COALESCE(c.nama_categories, 'Kategori Dihapus') AS nama_produk
    FROM tb_transaction t
    LEFT JOIN tb_categories c ON t.id_kategori = c.id_categories
    ORDER BY t.tanggal DESC, t.created_at DESC
");

$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Pertanian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; font-size: 13px; }
        h2 { text-align: center; color: #07c539; margin: 0; }
        h3 { text-align: center; color: #333; margin: 10px 0 30px 0; }
        .info { text-align: center; color: #555; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 10px; }
        th { background: #07c539; color: white; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row { background: #e8f5e8; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 60px; text-align: right; font-size: 12px; color: #555; }
    </style>
</head>
<body>

    <h2>PERTANIAN INDONESIA</h2>
    <h3>LAPORAN TRANSAKSI PENJUALAN</h3>
    <div class="info">
        Dicetak pada: ' . date('d F Y - H:i') . ' WIB
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pembeli</th>
                <th width="12%">No. HP</th>
                <th width="15%">Produk</th>
                <th width="8%">Jumlah (kg)</th>
                <th width="12%">Total Harga</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
$totalPendapatan = 0;

while ($t = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Jika jumlah_kg NULL → tampilkan 0, begitu juga total_harga
    $jumlah_kg   = $t['jumlah_kg'] ?? 0;
    $total_harga = $t['total_harga'] ?? 0;
    $totalPendapatan += $total_harga;

    $html .= '
            <tr>
                <td class="text-center">' . $no++ . '</td>
                <td class="text-center">' . date('d-m-Y', strtotime($t['tanggal'])) . '</td>
                <td><strong>' . htmlspecialchars($t['pembeli'] ?? '-') . '</strong></td>
                <td>' . htmlspecialchars($t['no_hp_pembeli'] ?? '-') . '</td>
                <td>' . htmlspecialchars($t['nama_produk']) . '</td>
                <td class="text-center">' . ($jumlah_kg > 0 ? $jumlah_kg : '-') . '</td>
                <td class="text-right">Rp ' . number_format($total_harga) . '</td>
                <td>' . htmlspecialchars($t['alamat'] ?? '-') . '</td>
            </tr>';
}

$html .= '
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right"><strong>TOTAL PENDAPATAN</strong></td>
                <td class="text-right"><strong>Rp ' . number_format($totalPendapatan) . '</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak oleh: Admin Pertanian<br>
        Tanggal: ' . date('d F Y') . '
    </div>

</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Laporan_Transaksi_" . date('d-m-Y') . ".pdf", ["Attachment" => false]);