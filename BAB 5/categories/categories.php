<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kategori</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header style="background:#02b92a;color:#fff;padding:14px 20px;display:flex;justify-content:space-between;align-items:center;">
    <div style="font-weight:700;">Daftar Kategori</div>
    <div>
      <a href="../categories/categories-entry.php" style="background:#24b300;color:#fff;padding:8px 16px;border-radius:6px;text-decoration:none;">+ Tambah</a>
      <a href="../admin.php" style="color:#fff;margin-left:10px;">Kembali</a>
    </div>
  </header>

  <main style="max-width:800px;margin:40px auto;padding:16px;">
    <div id="list" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);">
      <p>Loading...</p>
    </div>
  </main>

  <script>
    function loadCategories() {
      const cats = JSON.parse(localStorage.getItem('categories') || '[]');
      const el = document.getElementById('list');

      if (!cats.length) {
        el.innerHTML = '<p>Tidak ada kategori.</p>';
        return;
      }

      let html = `<table style="width:100%;border-collapse:collapse;margin-top:10px;">
        <tr style="background:#f3f4f6;"><th style="padding:12px;text-align:left;">No</th><th>Nama</th><th>Tanggal</th></tr>`;

      cats.forEach((c, i) => {
        html += `<tr>
          <td style="padding:12px;border-bottom:1px solid #ddd;">${i+1}</td>
          <td style="border-bottom:1px solid #ddd;">${c.name}</td>
          <td style="border-bottom:1px solid #ddd;">${c.created_at}</td>
        </tr>`;
      });

      el.innerHTML = html + `</table>`;
    }

    window.onload = loadCategories;
  </script>
</body>
</html>