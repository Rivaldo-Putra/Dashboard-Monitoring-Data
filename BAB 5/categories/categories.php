<?php
// categories/categories.php
// File PHP untuk struktur & keamanan
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kategori</title>
  <link rel="icon" href="../assets/icon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #04b40d;
      --bg: #f9fafb;
      --text: #1f2937;
      --border: #e5e7eb;
      --danger: #ef4444;
      --success: #16a34a;
    }
    * {box-sizing:border-box;margin:0;padding:0;font-family:Inter,system-ui,Arial,sans-serif;}
    body {background:var(--bg);color:var(--text);padding:20px;}
    header {
      background:var(--primary);color:#fff;padding:16px 20px;display:flex;justify-content:space-between;align-items:center;
      border-radius:12px 12px 0 0;box-shadow:0 4px 12px rgba(0,0,0,.08);position:sticky;top:0;z-index:100;
    }
    header h1 {font-size:1.3rem;font-weight:700;}
    nav a {color:#fff;text-decoration:none;font-weight:600;margin-left:12px;}
    nav a:hover {text-decoration:underline;}
    main {max-width:900px;margin:30px auto;}
    .form-container {
      background:#fff;padding:24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);margin-bottom:24px;
    }
    .form-group {margin-bottom:16px;}
    .form-group label {display:block;margin-bottom:6px;font-weight:600;color:#374151;}
    .form-group input {width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:1rem;}
    .btn {padding:10px 16px;border:none;border-radius:8px;cursor:pointer;font-weight:600;font-size:.9rem;}
    .btn-primary {background:var(--primary);color:#fff;}
    .btn-secondary {background:#6b7280;color:#fff;margin-left:8px;}
    .btn:hover {opacity:0.9;}
    table {width:100%;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.08);}
    thead {background:var(--primary);color:#fff;}
    th, td {padding:14px;text-align:left;}
    tbody tr {border-bottom:1px solid #eee;}
    tbody tr:last-child {border-bottom:none;}
    .action-btn {padding:6px 10px;border:none;border-radius:6px;cursor:pointer;font-size:.8rem;margin:0 4px;}
    .edit {background:#f59e0b;color:#fff;}
    .delete {background:var(--danger);color:#fff;}
    .empty {text-align:center;padding:30px;color:#9ca3af;font-style:italic;}
  </style>
</head>
<body>

<header>
  <h1>Daftar Kategori</h1>
  <nav>
    <a href="categories-entry.php">+ Tambah</a>
    <a href="../admin.php">Kembali</a>
  </nav>
</header>

<main>
  <div class="form-container" id="editForm" style="display:none;">
    <h3>Edit Kategori</h3>
    <div class="form-group">
      <label>Nama Kategori</label>
      <input type="text" id="editName" placeholder="Masukkan nama kategori" />
    </div>
    <button class="btn btn-primary" onclick="saveEdit()">Simpan</button>
    <button class="btn btn-secondary" onclick="cancelEdit()">Batal</button>
  </div>

  <table>
    <thead>
      <tr><th>No</th><th>Nama</th><th>Dibuat</th><th>Aksi</th></tr>
    </thead>
    <tbody id="catBody"></tbody>
  </table>
</main>

<script>
let editIndex = null;

function formatDate(date) {
  const d = new Date(date);
  const options = { day: '2-digit', month: 'long', year: 'numeric' };
  return d.toLocaleDateString('id-ID', options);
}

function load() {
  const cats = JSON.parse(localStorage.getItem('categories') || '[]');
  const tbody = document.getElementById('catBody');
  tbody.innerHTML = cats.length ? cats.map((c, i) => `
    <tr>
      <td>${i+1}</td>
      <td>${c.name}</td>
      <td>${formatDate(c.createdAt)}</td>
      <td>
        <button class="action-btn edit" onclick="startEdit(${i})">Edit</button>
        <button class="action-btn delete" onclick="del(${i})">Hapus</button>
      </td>
    </tr>
  `).join('') : `<tr><td colspan="4" class="empty">Belum ada kategori</td></tr>`;
}

function startEdit(i) {
  const cats = JSON.parse(localStorage.getItem('categories') || '[]');
  document.getElementById('editName').value = cats[i].name;
  editIndex = i;
  document.getElementById('editForm').style.display = 'block';
  document.querySelector('main').scrollIntoView({ behavior: 'smooth' });
}

function saveEdit() {
  const name = document.getElementById('editName').value.trim();
  if (!name) {
    alert('Nama kategori tidak boleh kosong!');
    return;
  }
  
  const cats = JSON.parse(localStorage.getItem('categories') || '[]');
  cats[editIndex].name = name;
  localStorage.setItem('categories', JSON.stringify(cats));
  cancelEdit();
  load();
}

function cancelEdit() {
  editIndex = null;
  document.getElementById('editForm').style.display = 'none';
}

function del(i) {
  if (!confirm('Hapus kategori ini?\n\nSemua transaksi terkait akan tetap ada.')) return;
  const cats = JSON.parse(localStorage.getItem('categories') || '[]');
  cats.splice(i, 1);
  localStorage.setItem('categories', JSON.stringify(cats));
  load();
}

window.onload = load;
</script>

</body>
</html>