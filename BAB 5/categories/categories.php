<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kategori</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    :root{--green:#01a701;--dark:#123}
    body{font-family:system-ui,Arial,sans-serif;background:#f4f6f8;min-height:100vh;margin:0}
    header{background:var(--green);color:#fff;padding:14px 20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 10px rgba(0,0,0,.1)}
    .brand{font-weight:700;font-size:1.1rem}
    nav a{color:#fff;text-decoration:none;margin-right:12px;font-size:.95rem}
    nav a:hover{text-decoration:underline}
    .container{max-width:900px;margin:40px auto;padding:16px}
    table{width:100%;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.08);border-collapse:collapse}
    thead{background:#04a71f;color:#fff}
    th, td{padding:14px;text-align:left}
    th{font-weight:600}
    tbody tr{border-bottom:1px solid #eee}
    tbody tr:last-child{border-bottom:none}
    .empty{text-align:center;padding:30px;color:#9ca3af;font-style:italic}
    button{background:#ef4444;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:.8rem;font-weight:600}
    button:hover{background:#dc2626}
  </style>
</head>
<body>

<header>
  <div class="brand">Daftar Kategori</div>
  <nav>
    <a href="categories-entry.php">+ Tambah</a>
    <a href="../admin.php">Kembali</a>
  </nav>
</header>

<main class="container">
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Dibuat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="catBody">
      <!-- Data diisi oleh JS -->
    </tbody>
  </table>
</main>

<script>
  function loadCategories() {
    const categories = JSON.parse(localStorage.getItem('categories') || '[]');
    const tbody = document.getElementById('catBody');

    if (categories.length === 0) {
      tbody.innerHTML = '<tr><td colspan="4" class="empty">Belum ada data</td></tr>';
      return;
    }

    tbody.innerHTML = categories.map((cat, i) => `
      <tr>
        <td>${i + 1}</td>
        <td>${cat.name}</td>
        <td>${cat.createdAt}</td>
        <td>
          <button onclick="deleteCategory(${i})">Hapus</button>
        </td>
      </tr>
    `).join('');
  }

  function deleteCategory(index) {
    if (confirm('Hapus kategori ini?')) {
      const categories = JSON.parse(localStorage.getItem('categories') || '[]');
      categories.splice(index, 1);
      localStorage.setItem('categories', JSON.stringify(categories));
      loadCategories();
    }
  }

  // Load saat halaman dibuka
  window.onload = loadCategories;
</script>

</body>
</html>