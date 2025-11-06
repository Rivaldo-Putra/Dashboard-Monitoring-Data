<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard Pertanian</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root{--green:#2f855a;--dark:#123;--muted:#6b7280}
    *{box-sizing:border-box;margin:0;padding:0}
    body{
      font-family:Inter,system-ui,Arial,sans-serif;
      margin:0;
      background:linear-gradient(rgba(255,255,255,0.3),rgba(255,255,255,0.3)),
                 url('./assets/Harvest.jpg') center/cover no-repeat fixed;
      background-color:#f0f4f8;
      color:var(--dark);
      min-height:100vh;
    }
    header{background:var(--green);color:#fff;padding:14px 20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 10px rgba(0,0,0,.1)}
    .brand{font-weight:700;font-size:1.1rem}
    .user-info{margin-right:12px;color:#d1fae5;font-size:.9rem}
    .btn{background:var(--green);color:#fff;padding:8px 14px;border:none;border-radius:6px;cursor:pointer;margin:4px 0;font-size:.9rem;font-weight:600}
    .btn:hover{background:#276749}
    .btn.logout{background:#dc2626}
    .container{max-width:1200px;margin:20px auto;padding:16px}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:18px;margin-bottom:20px}
    .card{background:#fff;padding:22px;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.12)}
    h1{margin-bottom:8px}
    h2{margin-bottom:12px;color:var(--green)}
    table{width:100%;border-collapse:collapse;margin-top:10px;font-size:.9rem}
    th,td{padding:8px;text-align:left;border-bottom:1px solid #e5e7eb}
    th{background:var(--green);color:#fff}
    #snackbar{
      visibility:hidden;min-width:260px;margin-left:-130px;background:#333;color:#fff;text-align:center;
      border-radius:8px;padding:14px;position:fixed;left:50%;bottom:30px;z-index:1000;
      opacity:0;transform:translateY(10px);font-size:.95rem;
    }
    #snackbar.show{
      visibility:visible;opacity:1;transform:translateY(0);
      transition:opacity .35s,transform .35s;
    }
    #snackbar.success{background:#16a34a}
    #snackbar.error{background:#dc2626}
  </style>
</head>
<body>

<header>
  <div class="brand">Dashboard</div>
  <div>
    <span id="userInfo" class="user-info"></span>
    <button class="btn logout" onclick="logout()">Logout</button>
  </div>
</header>

<div class="container">
  <h1>Monitoring Pertanian</h1>
  <p id="welcomeMsg">Memuat...</p>

  <div class="grid">
    <div class="card">
      <h2>Statistik</h2>
      <p>Tanaman: <strong id="countTanaman">0</strong></p>
      <p>Panen: <strong id="countPanen">0</strong></p>
      <p>Total: <strong id="totalPanen">0</strong> Ton</p>
    </div>
    <div class="card">
      <h2>Grafik Panen (7 Hari)</h2>
      <canvas id="chartPanen" height="200"></canvas>
    </div>
  </div>

  <div class="grid">
    <div class="card">
      <h2>Daftar Tanaman</h2>
      <table id="tabelTanaman">
        <thead><tr><th>ID</th><th>Nama</th><th>Ditanam</th></tr></thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="card">
      <h2>Panen Terbaru</h2>
      <table id="tabelPanen">
        <thead><tr><th>ID</th><th>Panen</th><th>Ton</th><th>Tanggal</th></tr></thead>
        <tbody></tbody>
      </table>
    </div>
  </div>
</div>

<div id="snackbar"></div>

<script>
  // Toast
  function showToast(msg, type = 'default', dur = 3000) {
    const s = document.getElementById('snackbar');
    s.textContent = msg;
    s.className = 'show';
    if (type === 'success') s.classList.add('success');
    if (type === 'error') s.classList.add('error');
    setTimeout(() => s.className = '', dur);
  }

  // Cek login
  const user = JSON.parse(localStorage.getItem('user') || '{}');
  if (!user.isLoggedIn) {
    showToast('Login dulu!', 'error');
    setTimeout(() => location.href = 'login.php', 1500);
    throw new Error('Not logged in');
  }

  document.getElementById('welcomeMsg').textContent = `Selamat datang, ${user.nama || 'Petani'}!`;
  document.getElementById('userInfo').textContent = `(${user.email})`;

  // Data dari localStorage
  const getTanaman = () => JSON.parse(localStorage.getItem('tanaman') || '[]');
  const getPanen = () => JSON.parse(localStorage.getItem('panen') || '[]');

  // Update statistik
  function updateStats() {
    const tanaman = getTanaman();
    const panen = getPanen();
    document.getElementById('countTanaman').textContent = tanaman.length;
    document.getElementById('countPanen').textContent = panen.length;
    const total = panen.reduce((sum, p) => sum + (parseFloat(p.ton) || 0), 0).toFixed(2);
    document.getElementById('totalPanen').textContent = total;
  }

  // Tampilkan tabel tanaman
  function renderTanaman() {
    const tbody = document.querySelector('#tabelTanaman tbody');
    tbody.innerHTML = '';
    const data = getTanaman();
    if (data.length === 0) {
      tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;color:#9ca3af;padding:20px;">Belum ada data</td></tr>';
      return;
    }
    data.forEach(t => {
      const row = tbody.insertRow();
      row.insertCell(0).textContent = t.id || '-';
      row.insertCell(1).textContent = t.nama || '-';
      row.insertCell(2).textContent = t.ditanam || '-';
    });
  }

  // Tampilkan tabel panen
  function renderPanen() {
    const tbody = document.querySelector('#tabelPanen tbody');
    tbody.innerHTML = '';
    const data = getPanen().slice(-10).reverse();
    if (data.length === 0) {
      tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:20px;">Belum ada data</td></tr>';
      return;
    }
    data.forEach(p => {
      const row = tbody.insertRow();
      row.insertCell(0).textContent = p.id || '-';
      row.insertCell(1).textContent = p.nama || '-';
      row.insertCell(2).textContent = p.ton || '0';
      row.insertCell(3).textContent = p.tanggal || '-';
    });
  }

  // Grafik panen
  function renderChart() {
    const ctx = document.getElementById('chartPanen').getContext('2d');
    const data = getPanen().slice(-7).reverse();
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.map(p => new Date(p.tanggal).toLocaleDateString('id-ID')),
        datasets: [{
          label: 'Ton',
          data: data.map(p => parseFloat(p.ton) || 0),
          borderColor: '#2f855a',
          backgroundColor: 'rgba(47,133,90,0.1)',
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  }

  // Logout
  function logout() {
    localStorage.removeItem('user');
    showToast('Logout berhasil', 'success');
    setTimeout(() => location.href = 'index.php', 1000);
  }

  // Init
  window.onload = () => {
    updateStats();
    renderTanaman();
    renderPanen();
    renderChart();
  };
</script>

</body>
</html>