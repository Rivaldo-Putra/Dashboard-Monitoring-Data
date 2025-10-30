<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pertanian</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #e6f3e6;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #2e7d32;
      color: white;
      text-align: center;
      padding: 15px;
    }
    section {
      margin: 20px auto;
      width: 80%;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 5px #aaa;
    }
    input, select, button {
      padding: 8px;
      margin: 5px 0;
      width: 100%;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #43a047;
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover { background-color: #2e7d32; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th {
      background-color: #66bb6a;
      color: white;
    }
    td, th {
      padding: 10px;
      text-align: center;
    }
    .count-box {
      background: #a5d6a7;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Dashboard Pertanian</h1>
    <nav>
      <a href="index.php">Kembali</a>
    </nav>
  </header>
  <section>
    <div class="count-box">
      <p>Total Kategori: <span id="totalCategories">0</span></p>
      <p>Total Transaksi: <span id="totalTransactions">0</span></p>
    </div>

    <h2>Tambah Kategori</h2>
    <input type="text" id="categoryName" placeholder="Nama Kategori">
    <button onclick="addCategory()">Tambah Kategori</button>

    <h2>Tambah Transaksi</h2>
    <input type="text" id="transactionName" placeholder="Nama Transaksi">
    <select id="paymentStatus">
      <option value="Belum Dibayar">Belum Dibayar</option>
      <option value="Sudah Dibayar">Sudah Dibayar</option>
      <option value="Proses">Proses</option>
    </select>
    <button onclick="addTransaction()">Tambah Transaksi</button>

    <h2>Data Kategori</h2>
    <table id="categoryTable">
      <tr>
        <th>Nama Kategori</th>
        <th>Tanggal Dibuat</th>
        <th>Aksi</th>
      </tr>
    </table>

    <h2>Data Transaksi</h2>
    <table id="transactionTable">
      <tr>
        <th>Nama Transaksi</th>
        <th>Status Pembayaran</th>
        <th>Tanggal Dibuat</th>
        <th>Aksi</th>
      </tr>
    </table>

  <script>
    function loadData() {
      let categories = JSON.parse(localStorage.getItem('categories')) || [];
      let transactions = JSON.parse(localStorage.getItem('transactions')) || [];
      document.getElementById("totalCategories").textContent = categories.length;
      document.getElementById("totalTransactions").textContent = transactions.length;

      const categoryTable = document.getElementById("categoryTable");
      categoryTable.innerHTML = `
        <tr><th>Nama Kategori</th><th>Tanggal Dibuat</th><th>Aksi</th></tr>`;
      categories.forEach((cat, i) => {
        const row = categoryTable.insertRow();
        row.innerHTML = `
          <td>${cat.name}</td>
          <td>${cat.date}</td>
          <td><button onclick="deleteCategory(${i})">Hapus</button></td>`;
      });

      const transactionTable = document.getElementById("transactionTable");
      transactionTable.innerHTML = `
        <tr><th>Nama Transaksi</th><th>Status Pembayaran</th><th>Tanggal Dibuat</th><th>Aksi</th></tr>`;
      transactions.forEach((tr, i) => {
        const row = transactionTable.insertRow();
        row.innerHTML = `
          <td>${tr.name}</td>
          <td>${tr.status}</td>
          <td>${tr.date}</td>
          <td><button onclick="deleteTransaction(${i})">Hapus</button></td>`;
      });
    }

    function addCategory() {
      const name = document.getElementById("categoryName").value;
      if (!name) return alert("Masukkan nama kategori!");
      let categories = JSON.parse(localStorage.getItem('categories')) || [];
      categories.push({ name, date: new Date().toLocaleString() });
      localStorage.setItem('categories', JSON.stringify(categories));
      document.getElementById("categoryName").value = "";
      loadData();
    }

    function addTransaction() {
      const name = document.getElementById("transactionName").value;
      const status = document.getElementById("paymentStatus").value;
      if (!name) return alert("Masukkan nama transaksi!");
      let transactions = JSON.parse(localStorage.getItem('transactions')) || [];
      transactions.push({ name, status, date: new Date().toLocaleString() });
      localStorage.setItem('transactions', JSON.stringify(transactions));
      document.getElementById("transactionName").value = "";
      loadData();
    }

    function deleteCategory(index) {
      let categories = JSON.parse(localStorage.getItem('categories')) || [];
      categories.splice(index, 1);
      localStorage.setItem('categories', JSON.stringify(categories));
      loadData();
    }

    function deleteTransaction(index) {
      let transactions = JSON.parse(localStorage.getItem('transactions')) || [];
      transactions.splice(index, 1);
      localStorage.setItem('transactions', JSON.stringify(transactions));
      loadData();
    }

    loadData();
  </script>
</body>
</html>
