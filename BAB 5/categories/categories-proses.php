<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proses Kategori</title>
  <style>
    :root{--green:#01a701;--dark:#123;--red:#ef4444}
    *{box-sizing:border-box;margin:0;padding:0}
    body{
      font-family:system-ui,Arial,sans-serif;
      background:#f4f6f8;
      color:var(--dark);
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:20px;
    }
    .card{
      background:#fff;
      padding:32px;
      border-radius:14px;
      box-shadow:0 8px 28px rgba(0,0,0,.12);
      max-width:480px;
      width:100%;
      text-align:center;
    }
    .icon{
      font-size:3rem;
      margin-bottom:16px;
    }
    .success .icon{color:var(--green)}
    .error .icon{color:var(--red)}
    h2{margin-bottom:12px}
    p{color:#6b7280;margin-bottom:20px}
    .btn{
      background:var(--green);
      color:#fff;
      padding:12px 20px;
      border:none;
      border-radius:8px;
      cursor:pointer;
      font-size:1rem;
      font-weight:600;
      text-decoration:none;
      display:inline-block;
    }
    .btn:hover{background:#018a01}
    .btn.danger{background:var(--red)}
    .btn.danger:hover{background:#dc2626}
  </style>
</head>
<body>

<div id="resultCard" class="card">
  <div class="icon" id="icon">⏳</div>
  <h2 id="title">Memproses...</h2>
  <p id="message">Sedang menyimpan data kategori...</p>
</div>

<script>
  // Ambil data dari URL (query string)
  const params = new URLSearchParams(window.location.search);
  const nama = params.get('nama')?.trim();

  // Elemen
  const card = document.getElementById('resultCard');
  const icon = document.getElementById('icon');
  const title = document.getElementById('title');
  const message = document.getElementById('message');

  // Validasi
  if (!nama || nama === '') {
    showResult(false, 'Gagal', 'Nama kategori tidak boleh kosong!', 'Kembali');
    return;
  }

  // Ambil data existing
  const categories = JSON.parse(localStorage.getItem('categories') || '[]');

  // Cek duplikat
  if (categories.some(cat => cat.name.toLowerCase() === nama.toLowerCase())) {
    showResult(false, 'Gagal', 'Kategori dengan nama ini sudah ada!', 'Coba Lagi');
    return;
  }

  // Tambah kategori
  categories.push({
    name: nama,
    createdAt: new Date().toLocaleString('id-ID')
  });

  // Simpan
  localStorage.setItem('categories', JSON.stringify(categories));

  // Sukses
  showResult(true, 'Berhasil!', `"${nama}" berhasil ditambahkan sebagai kategori.`, 'Lihat Daftar');

  function showResult(success, judul, pesan, tombolText) {
    card.className = 'card ' + (success ? 'success' : 'error');
    icon.textContent = success ? '✓' : '✕';
    title.textContent = judul;
    message.innerHTML = pesan + '<br><br>' +
      `<a href="${success ? 'categories.php' : 'categories-entry.php'}" class="btn ${success ? '' : 'danger'}">${tombolText}</a>`;
  }
</script>

</body>
</html>