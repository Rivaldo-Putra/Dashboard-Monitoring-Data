<!DOCTYPE html> 
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Panel - Pertanian</title>
  <style>
    body {font-family: 'Segoe UI', sans-serif; background: #f4f6f9; margin: 0;}
    header {
      background: #2563eb; color: #fff; padding: 14px 20px;
      display: flex; justify-content: space-between; align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .brand {font-size: 18px; font-weight: bold;}
    nav a {
      color: #fff; text-decoration: none; background: #1e40af;
      padding: 8px 14px; border-radius: 6px; transition: .3s;
    }
    nav a:hover {background: #1d4ed8;}
    .container {padding: 20px;}
    table {
      width: 100%; border-collapse: collapse; margin-top: 10px;
      background: #fff; border-radius: 8px; overflow: hidden;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    th, td {border: 1px solid #ddd; padding: 10px; text-align: center;}
    th {background: #e5e7eb;}
    button {
      background: #2563eb; color: #fff; border: none;
      padding: 6px 12px; border-radius: 6px; cursor: pointer;
      transition: .3s;
    }
    button:hover {background: #1e40af;}
    .delete-btn {background: #dc2626;}
    .delete-btn:hover {background: #b91c1c;}
    .edit-btn {background: #f59e0b;}
    .edit-btn:hover {background: #d97706;}
    .add-btn {background: #16a34a;}
    .add-btn:hover {background: #15803d;}
    .stats {display: flex; gap: 20px; margin-top: 20px;}
    .card {
      background: #fff; padding: 20px; border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1); flex: 1; text-align: center;
    }
    .card h3 {margin: 0; color: #2563eb;}
    h2 {color: #1e3a8a;}
    .hidden {display: none;}
    form {
      background: #fff; padding: 20px; border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-width: 320px; margin: 100px auto;
    }
    input, button {padding: 8px; width: 100%; margin-bottom: 10px;}
  </style>
</head>
<body>
  <header>
    <div class="brand">Admin Panel Pertanian</div>
    <nav>
      <a href="index.php">Kembali</a>
    </nav>
  </header>

  <!-- Halaman Login -->
  <main id="loginPage" class="container">
    <form onsubmit="loginAdmin(event)">
      <h3 style="text-align:center;color:#1e3a8a;">Login Admin</h3>
      <input type="text" id="adminUser" placeholder="Username" required>
      <input type="password" id="adminPass" placeholder="Password" required>
      <button type="submit">Masuk</button>
    </form>
  </main>

  <!-- Dashboard Admin -->
  <main id="adminDashboard" class="container hidden">
    <h2>Selamat Datang, Admin!</h2>

    <div class="stats">
      <div class="card">
        <h3 id="countKategori">0</h3>
        <p>Jumlah Kategori Tanaman</p>
      </div>
      <div class="card">
        <h3 id="countTransaksi">0</h3>
        <p>Jumlah Transaksi Panen</p>
      </div>
    </div>

    <h3>Data Kategori Tanaman</h3>
    <button class="add-btn" onclick="tambahKategori()">+ Tambah Kategori</button>
    <table id="adminCategories">
      <thead>
        <tr>
          <th>Nama Kategori</th>
          <th>Tanggal Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <h3>Data Transaksi Panen</h3>
    <button class="add-btn" onclick="tambahTransaksi()">+ Tambah Transaksi</button>
    <table id="adminTransactions">
      <thead>
        <tr>
          <th>Nama Transaksi</th>
          <th>Status Pembayaran</th>
          <th>Tanggal Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </main>

  <script>
    const adminUsername = "admin";
    const adminPassword = "12345";

    const loginPage = document.getElementById('loginPage');
    const adminDashboard = document.getElementById('adminDashboard');
    const countKategori = document.getElementById('countKategori');
    const countTransaksi = document.getElementById('countTransaksi');

    function loginAdmin(e) {
      e.preventDefault();
      const user = document.getElementById('adminUser').value.trim();
      const pass = document.getElementById('adminPass').value.trim();

      if (user === adminUsername && pass === adminPassword) {
        loginPage.classList.add('hidden');
        adminDashboard.classList.remove('hidden');
        loadData();
      } else {
        alert("Username atau Password salah!");
      }
    }

    function loadData() {
      const categories = JSON.parse(localStorage.getItem('categories') || '[]');
      const transactions = JSON.parse(localStorage.getItem('transactions') || '[]');
      renderAdminData(categories, transactions);
    }

    function renderAdminData(categories, transactions) {
      const catBody = document.querySelector('#adminCategories tbody');
      const transBody = document.querySelector('#adminTransactions tbody');

      countKategori.textContent = categories.length;
      countTransaksi.textContent = transactions.length;

      catBody.innerHTML = categories.map((c, i) => `
        <tr>
          <td>${c.name}</td>
          <td>${c.createdAt}</td>
          <td>
            <button class="edit-btn" onclick="editCategory(${i})">Edit</button>
            <button class="delete-btn" onclick="deleteCategory(${i})">Hapus</button>
          </td>
        </tr>
      `).join('');

      transBody.innerHTML = transactions.map((t, i) => `
        <tr>
          <td>${t.name}</td>
          <td>${t.status}</td>
          <td>${t.createdAt}</td>
          <td>
            <button class="edit-btn" onclick="editTransaction(${i})">Edit</button>
            <button class="delete-btn" onclick="deleteTransaction(${i})">Hapus</button>
          </td>
        </tr>
      `).join('');
    }

    function tambahKategori() {
      const name = prompt("Masukkan nama kategori tanaman:");
      if (name) {
        const data = JSON.parse(localStorage.getItem('categories') || '[]');
        data.push({ name, createdAt: new Date().toLocaleString() });
        localStorage.setItem('categories', JSON.stringify(data));
        loadData();
      }
    }

    function tambahTransaksi() {
      const name = prompt("Masukkan nama transaksi panen:");
      const status = prompt("Masukkan status pembayaran (Sudah Dibayar / Belum Dibayar):");
      if (name && status) {
        const data = JSON.parse(localStorage.getItem('transactions') || '[]');
        data.push({ name, status, createdAt: new Date().toLocaleString() });
        localStorage.setItem('transactions', JSON.stringify(data));
        loadData();
      }
    }

    function editCategory(index) {
      const data = JSON.parse(localStorage.getItem('categories') || '[]');
      const newName = prompt("Ubah nama kategori:", data[index].name);
      if (newName) {
        data[index].name = newName;
        localStorage.setItem('categories', JSON.stringify(data));
        loadData();
      }
    }

    function deleteCategory(index) {
      const data = JSON.parse(localStorage.getItem('categories') || '[]');
      if (confirm("Hapus kategori ini?")) {
        data.splice(index, 1);
        localStorage.setItem('categories', JSON.stringify(data));
        loadData();
      }
    }

    function editTransaction(index) {
      const data = JSON.parse(localStorage.getItem('transactions') || '[]');
      const newName = prompt("Ubah nama transaksi:", data[index].name);
      const newStatus = prompt("Ubah status pembayaran (Sudah Dibayar / Belum Dibayar):", data[index].status);
      if (newName && newStatus) {
        data[index].name = newName;
        data[index].status = newStatus;
        localStorage.setItem('transactions', JSON.stringify(data));
        loadData();
      }
    }

    function deleteTransaction(index) {
      const data = JSON.parse(localStorage.getItem('transactions') || '[]');
      if (confirm("Hapus transaksi ini?")) {
        data.splice(index, 1);
        localStorage.setItem('transactions', JSON.stringify(data));
        loadData();
      }
    }

    // Perbarui data otomatis setiap 3 detik
    setInterval(loadData, 3000);
  </script>
</body>
</html>
