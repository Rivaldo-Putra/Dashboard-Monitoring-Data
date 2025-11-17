<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kategori</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header style="background:#02b92a;color:#fff;padding:14px 20px;">
    <div style="font-weight:700;">Tambah Kategori</div>
    <nav><a href="../admin.php/categories.php" style="color:#fff;text-decoration:none;">Kembali</a></nav>
  </header>

  <main style="max-width:500px;margin:40px auto;padding:16px;">
    <div style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);">
      <form id="catForm">
        <label style="display:block;margin-bottom:8px;font-weight:600;">Nama Kategori</label>
        <input type="text" id="catName" style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;margin-bottom:16px;" placeholder="Contoh: Padi" required>

        <button type="submit" style="background:#24b300;color:#fff;padding:10px 16px;border:none;border-radius:8px;cursor:pointer;font-weight:600;">Simpan</button>
      </form>
    </div>
  </main>

  <script>
    document.getElementById('catForm').onsubmit = function(e) {
      e.preventDefault();
      const name = document.getElementById('catName').value.trim();
      if (!name) return alert('Nama kategori wajib diisi!');

      // Baca data dari localStorage
      let cats = JSON.parse(localStorage.getItem('categories') || '[]');

      // Cek duplikat
      if (cats.some(c => c.name.toLowerCase() === name.toLowerCase())) {
        return alert('Kategori "' + name + '" sudah ada!');
      }

      // Tambah kategori baru
      cats.push({
        id: Date.now(),
        name: name,
        created_at: new Date().toISOString().split('T')[0]
      });

      // Simpan ke localStorage
      localStorage.setItem('categories', JSON.stringify(cats));

      alert('Kategori "' + name + '" berhasil disimpan!');
      this.reset();
    };
  </script>
</body>
</html>