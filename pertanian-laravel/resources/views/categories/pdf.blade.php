<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kategori Produk Pertanian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #16a34a; margin: 0; font-size: 28px; }
        .header p { color: #666; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #16a34a; color: white; padding: 12px; text-align: center; }
        td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .footer { text-align: center; margin-top: 50px; color: #666; font-size: 12px; }
        img { max-height: 80px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERTANIAN MODERN</h1>
        <p>LAPORAN DATA KATEGORI PRODUK</p>
        <p>Dicetak pada: {{ date('d F Y - H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Foto</th>
                <th>Nama Produk</th>
                <th width="20%">Harga per Kg</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $i => $cat)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    @if($cat->foto)
                        <img src="{{ public_path('storage/' . $cat->foto) }}" width="80">
                    @else
                        <small>Tanpa Foto</small>
                    @endif
                </td>
                <td><strong>{{ $cat->nama_categories }}</strong></td>
                <td>Rp {{ number_format($cat->price) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Belum ada data kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>© 2025 Pertanian Modern - Dibuat dengan Laravel 12 & DomPDF</p>
    </div>
</body>
</html>