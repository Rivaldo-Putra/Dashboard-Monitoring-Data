<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaksi Panen</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    :root{--green:#0cac37;--dark:#1f2937;--light:#f9fafb}
    body{font-family:system-ui,Arial,sans-serif;background:#f4f6f8;min-height:100vh;margin:0}
    header{background:var(--green);color:var(--dark);padding:14px 20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 10px rgba(0,0,0,.1)}
    .brand{font-weight:700;font-size:1.1rem}
    nav a{color:var(--dark);text-decoration:none;font-weight:600;font-size:.95rem}
    nav a:hover{text-decoration:underline}
    .container{max-width:700px;margin:40px auto;padding:16px}
    .card{background:#fff;padding:24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);margin-bottom:24px}
    label{display:block;margin-bottom:8px;font-weight:600;color:var(--dark)}
    input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;margin-bottom:12px;font-size:1rem}
    input:focus{outline:none;border-color:var(--green);box-shadow:0 0 0 3px rgba(12,172,55,.2)}
    button{background:#2f855a;color:#fff;padding:10px 16px;border:none;border-radius:8px;cursor:pointer;font-weight:600;width:100%}
    button:hover{background:#276749}
    table{width:100%;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.08);border-collapse:collapse}
    thead{background:#2f855a;color:#fff}
    th, td{padding:14px;text-align:left}
    th{font-weight:600}
    tbody tr{border-bottom:1px solid #eee}
    tbody tr:last-child{border-bottom:none}
    .empty{text-align:center;padding:30px;color:#9ca3af;font-style:italic}
    .del-btn{background:#ef4444;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:.8rem;font-weight:600}
    .del-btn:hover{background:#dc2626}
  </style>
</head>
<body>

<header>
  <div class="brand">Transaksi Panen</div>
  <nav>
    <a href="../admin.php">Kembali</a>
  </nav>
</header>

<main class="container">
  <div class="card">
    <form id="transForm">
      <label>Judul Transaksi</label>
      <input type="text" id="judul" placeholder="Contoh: Panen Padi">

      <label>Jumlah (Rp)</label>
      <input type="number" id="jumlah" placeholder="500000">

      <button type="submit">Simpan</button>
    </form>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Judul</th>
        <th>Jumlah</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="transBody">
      <!-- Data diisi oleh JS -->
    </tbody>
  </table>
</main>

<script>
  const form = document.getElementById('transForm');
  const tbody = document.getElementById('transBody');

  function loadTransactions() {
    const data = JSON.parse(localStorage.getItem('transactions') || '[]');
    
    if (data.length === 0) {
      tbody.innerHTML = '<tr><td colspan="4" class="empty">Belum ada transaksi</td></tr>';
      return;
    }

    tbody.innerHTML = data.map((t, i) => `
      <tr>
        <td>${i + 1}</td>
        <td>${t.judul || '-'}</td>
        <td>Rp ${parseInt(t.jumlah || 0).toLocaleString('id-ID')}</td>
        <td>
          <button class="del-btn" onclick="deleteTransaction(${i})">Hapus</button>
        </td>
      </tr>
    `).join('');
  }

  form.onsubmit = function(e) {
    e.preventDefault();

    const judul = document.getElementById('judul').value.trim();
    const jumlah = document.getElementById('jumlah').value.trim();

    // Validasi ringan: jika kosong semua, konfirmasi
    if (!judul && !jumlah) {
      if (!confirm('Form kosong. Tetap simpan?')) return;
    }

    const data = JSON.parse(localStorage.getItem('transactions') || '[]');
    data.push({
      judul: judul || 'Tanpa Judul',
      jumlah: jumlah || '0'
    });

    localStorage.setItem('transactions', JSON.stringify(data));
    form.reset();
    loadTransactions();

    alert('Transaksi berhasil disimpan!');
  };

  function deleteTransaction(index) {
    if (confirm('Hapus transaksi ini?')) {
      const data = JSON.parse(localStorage.getItem('transactions') || '[]');
      data.splice(index, 1);
      localStorage.setItem('transactions', JSON.stringify(data));
      loadTransactions();
    }
  }

  // Load saat halaman dibuka
  window.onload = loadTransactions;
</script>

</body>
</html>