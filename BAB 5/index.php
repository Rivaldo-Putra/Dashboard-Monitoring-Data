<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard Pertanian</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root{--green:#2f855a;--dark:#123;--muted:#6b7280;--light:#f9fafb}
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
    nav a{color:#fff;text-decoration:none;margin-left:12px;font-size:.95rem}
    nav a:hover{text-decoration:underline}
    .container{max-width:1100px;margin:40px auto;padding:16px}
    .hidden{display:none}
    .card{background:#fff;padding:24px;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.12);margin-bottom:20px}
    .btn{background:var(--green);color:#fff;padding:10px 16px;border:none;border-radius:8px;cursor:pointer;margin:6px 0;display:inline-block;font-size:1rem;font-weight:600}
    .btn:hover{background:#276749}
    .btn.logout{background:#dc2626}
    .btn.danger{background:#ef4444}
    input,select{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;margin:8px 0;font-size:1rem}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:18px;margin-top:20px}
    table{width:100%;border-collapse:collapse;margin-top:10px;font-size:.9rem}
    th,td{padding:8px;text-align:left;border-bottom:1px solid #e5e7eb}
    th{background:var(--green);color:#fff}
    #snackbar{visibility:hidden;min-width:260px;margin-left:-130px;background:#333;color:#fff;text-align:center;border-radius:8px;padding:14px;position:fixed;left:50%;bottom:30px;z-index:1000;opacity:0;transform:translateY(10px);font-size:.95rem}
    #snackbar.show{visibility:visible;opacity:1;transform:translateY(0);transition:opacity .35s,transform .35s}
    #snackbar.success{background:#16a34a}#snackbar.error{background:#dc2626}
    #userInfo{margin-left:12px;color:#d1fae5;font-size:.85rem}
    #popupOverlay{display:none;justify-content:center;align-items:center;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:2000}
    .popup{background:#fff;padding:24px;border-radius:14px;max-width:500px;width:90%;box-shadow:0 10px 30px rgba(0,0,0,.2)}
    .popup h3{margin-bottom:16px}
    .popup button{margin-top:12px}
  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="brand">Dashboard Pertanian</div>
    <nav>
      <a href="#" onclick="showPage('beranda')">Beranda</a>
      <a href="#" onclick="showPage('login')" id="navLogin">Login</a>
      <a href="#" onclick="showPage('daftar')" id="navDaftar">Daftar</a>
      <span id="userInfo"></span>
      <button class="btn logout hidden" id="btnLogout" onclick="logout()">Logout</button>
    </nav>
  </header>

  <!-- BERANDA -->
  <div id="page-beranda" class="container">
    <h1>Selamat Datang, Petani!</h1>
    <p>Sistem monitoring tanaman & panen</p>
    <div style="display:flex;gap:12px;justify-content:center;margin:20px 0;flex-wrap:wrap">
      <button class="btn" onclick="showPage('login')">Login</button>
      <button class="btn" onclick="showPage('daftar')">Daftar</button>
    </div>

    <div class="grid">
      <div class="card">
        <h3>Statistik</h3>
        <p>Kategori: <strong id="countCategories">0</strong></p>
        <p>Transaksi: <strong id="countTransactions">0</strong></p>
        <button class="btn" onclick="toDashboard()">Buka Dashboard</button>
      </div>
      <div class="card">
        <h3>Aksi Cepat</h3>
        <button class="btn" onclick="addCatDemo()">Tambah Kategori Demo</button>
        <button class="btn" onclick="addTrxDemo()">Tambah Transaksi Demo</button>
        <button class="btn" onclick="openAddCat()">Tambah Kategori</button>
        <button class="btn" onclick="openAddTrx()">Tambah Transaksi</button>
      </div>
      <div class="card">
        <h3>Tes Notifikasi</h3>
        <button class="btn" onclick="showToast('Sukses!','success')">Toast Sukses</button>
        <button class="btn danger" onclick="showToast('Error!','error')">Toast Error</button>
        <button class="btn" onclick="fetchQuote()">Ambil Quote</button>
      </div>
    </div>
  </div>

  <!-- DAFTAR -->
  <div id="page-daftar" class="container hidden">
    <div style="max-width:500px;margin:0 auto">
      <div class="card">
        <h2>Daftar Petani</h2>
        <form id="formDaftar">
          <input type="text" id="namaDaftar" placeholder="Nama Lengkap" required />
          <input type="email" id="emailDaftar" placeholder="Email" required />
          <input type="password" id="passDaftar" placeholder="Kata Sandi" required minlength="6" />
          <select id="provDaftar" required>
            <option value="">Pilih Provinsi</option>
            <option>Jawa Barat</option>
            <option>Jawa Tengah</option>
            <option>Jawa Timur</option>
          </select>
          <button type="submit" class="btn">Daftar</button>
        </form>
      </div>
    </div>
  </div>

  <!-- LOGIN -->
  <div id="page-login" class="container hidden">
    <div style="max-width:460px;margin:0 auto">
      <div class="card">
        <h2>Login Petani</h2>
        <form id="formLogin">
          <input type="email" id="emailLogin" placeholder="Email" required />
          <input type="password" id="passLogin" placeholder="Kata Sandi" required />
          <button type="submit" class="btn">Masuk</button>
        </form>
      </div>
    </div>
  </div>

  <!-- DASHBOARD -->
  <div id="page-dashboard" class="container hidden">
    <h1>Dashboard</h1>
    <p id="welcomeMsg">Memuat...</p>

    <div class="grid">
      <div class="card">
        <h2>Kategori</h2>
        <table id="tableCategories">
          <thead><tr><th>No</th><th>Nama</th><th>Dibuat</th><th>Aksi</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="card">
        <h2>Transaksi</h2>
        <table id="tableTransactions">
          <thead><tr><th>No</th><th>Nama</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <div class="grid">
      <div class="card">
        <h2>Grafik Panen</h2>
        <canvas id="chartPanen" height="180"></canvas>
      </div>
      <div class="card">
        <h2>Statistik</h2>
        <p>Kategori: <strong id="dashCategories">0</strong></p>
        <p>Transaksi: <strong id="dashTransactions">0</strong></p>
        <p>Total Panen: <strong id="dashTotal">0</strong> Ton</p>
      </div>
    </div>
  </div>

  <!-- POPUP -->
  <div id="popupOverlay" class="hidden">
    <div class="popup">
      <h3 id="popupTitle">Popup</h3>
      <div id="popupContent"></div>
      <button class="btn danger" onclick="closePopup()">Tutup</button>
    </div>
  </div>

  <!-- TOAST -->
  <div id="snackbar"></div>

  <!-- SEMUA JS -->
  <script>
    // Data
    let categories = JSON.parse(localStorage.getItem('categories') || '[]');
    let transactions = JSON.parse(localStorage.getItem('transactions') || '[]');
    let panen = JSON.parse(localStorage.getItem('panen') || '[]');

    // Toast
    function showToast(msg, type = 'default', dur = 3000) {
      const s = document.getElementById('snackbar');
      s.textContent = msg;
      s.className = 'show';
      if (type === 'success') s.classList.add('success');
      if (type === 'error') s.classList.add('error');
      setTimeout(() => s.className = '', dur);
    }

    // Update stats
    function updateStats() {
      ['countCategories', 'dashCategories'].forEach(id => document.getElementById(id).textContent = categories.length);
      ['countTransactions', 'dashTransactions'].forEach(id => document.getElementById(id).textContent = transactions.length);
      const total = panen.reduce((a, x) => a + (parseFloat(x.ton) || 0), 0).toFixed(2);
      document.getElementById('dashTotal').textContent = total;
      localStorage.setItem('categories', JSON.stringify(categories));
      localStorage.setItem('transactions', JSON.stringify(transactions));
      localStorage.setItem('panen', JSON.stringify(panen));
      renderTables();
    }

    // Render tabel
    function renderTables() {
      const cat = document.querySelector('#tableCategories tbody');
      const trx = document.querySelector('#tableTransactions tbody');
      cat.innerHTML = categories.map((c, i) => `<tr><td>${i+1}</td><td>${c.name}</td><td>${c.createdAt}</td><td><button class="btn danger" onclick="deleteCategory(${i})">Hapus</button></td></tr>`).join('') || '<tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:20px;">Belum ada data</td></tr>';
      trx.innerHTML = transactions.map((t, i) => `<tr><td>${i+1}</td><td>${t.name}</td><td>${t.status}</td><td>${t.createdAt}</td><td><button class="btn danger" onclick="deleteTransaction(${i})">Hapus</button></td></tr>`).join('') || '<tr><td colspan="5" style="text-align:center;color:#9ca3af;padding:20px;">Belum ada transaksi</td></tr>';
    }

    // Hapus
    function deleteCategory(i) { if (confirm('Hapus kategori?')) { categories.splice(i,1); updateStats(); showToast('Dihapus','success'); }}
    function deleteTransaction(i) { if (confirm('Hapus transaksi?')) { transactions.splice(i,1); updateStats(); showToast('Dihapus','success'); }}

    // Popup
    function openPopup(title, html, cb) {
      document.getElementById('popupTitle').textContent = title;
      document.getElementById('popupContent').innerHTML = html;
      document.getElementById('popupOverlay').classList.remove('hidden');
      const btn = document.querySelector('#popupContent button');
      if (btn) btn.onclick = () => { cb(); closePopup(); };
    }
    function closePopup() { document.getElementById('popupOverlay').classList.add('hidden'); }

    // Aksi cepat
    function addCatDemo() {
      const name = 'Kategori ' + Math.floor(Math.random() * 999);
      categories.push({ name, createdAt: new Date().toLocaleString('id-ID') });
      updateStats(); showToast('Kategori demo ditambah','success');
    }
    function addTrxDemo() {
      const name = 'Transaksi ' + Math.floor(Math.random() * 999);
      const status = Math.random() > 0.5 ? 'Sudah Dibayar' : 'Belum Dibayar';
      transactions.push({ name, status, createdAt: new Date().toLocaleString('id-ID') });
      updateStats(); showToast('Transaksi demo ditambah','success');
    }
    function openAddCat() {
      openPopup('Tambah Kategori', `<input type="text" id="popupCatName" placeholder="Nama Kategori"><button class="btn">Tambah</button>`, () => {
        const name = document.getElementById('popupCatName').value.trim();
        if (name) { categories.push({ name, createdAt: new Date().toLocaleString('id-ID') }); updateStats(); showToast('Ditambah','success'); }
      });
    }
    function openAddTrx() {
      openPopup('Tambah Transaksi', `<input type="text" id="popupTrxName" placeholder="Nama"><select id="popupTrxStatus"><option>Belum Dibayar</option><option>Sudah Dibayar</option></select><button class="btn">Tambah</button>`, () => {
        const name = document.getElementById('popupTrxName').value.trim();
        const status = document.getElementById('popupTrxStatus').value;
        if (name) { transactions.push({ name, status, createdAt: new Date().toLocaleString('id-ID') }); updateStats(); showToast('Ditambah','success'); }
      });
    }

    // Quote
    async function fetchQuote() {
      try {
        const res = await fetch('https://api.quotable.io/random');
        const d = await res.json();
        showToast(`"${d.content}" — ${d.author}`, 'success', 5000);
      } catch { showToast('Gagal ambil quote','error'); }
    }

    // Navigasi
    function showPage(page) {
      document.querySelectorAll('[id^="page-"]').forEach(p => p.classList.add('hidden'));
      document.getElementById(`page-${page}`).classList.remove('hidden');
      if (page === 'dashboard') loadDashboard();
      updateNav();
    }

    function toDashboard() {
      const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
      if (!u.isLoggedIn) { showToast('Login dulu!','error'); showPage('login'); return; }
      showPage('dashboard');
    }

    function logout() {
      localStorage.removeItem('user');
      showToast('Logout sukses','success');
      showPage('beranda');
    }

    function updateNav() {
      const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
      document.getElementById('navLogin').classList.toggle('hidden', u.isLoggedIn);
      document.getElementById('navDaftar').classList.toggle('hidden', u.isLoggedIn);
      document.getElementById('btnLogout').classList.toggle('hidden', !u.isLoggedIn);
      document.getElementById('userInfo').textContent = u.isLoggedIn ? `(${u.email})` : '';
    }

    // Login & Daftar
    document.getElementById('formDaftar').onsubmit = (e) => {
      e.preventDefault();
      const n = document.getElementById('namaDaftar').value.trim();
      const em = document.getElementById('emailDaftar').value.trim();
      const p = document.getElementById('passDaftar').value;
      if (!n || !em || !p) return showToast('Isi semua!','error');
      const daftar = JSON.parse(localStorage.getItem('daftarPetani') || '[]');
      if (daftar.some(x => x.email === em)) return showToast('Email sudah ada','error');
      daftar.push({nama:n,email:em,password:p});
      localStorage.setItem('daftarPetani', JSON.stringify(daftar));
      localStorage.setItem('user', JSON.stringify({isLoggedIn:true,nama:n,email:em}));
      showToast('Daftar sukses!','success');
      setTimeout(() => showPage('dashboard'), 1500);
    };

    document.getElementById('formLogin').onsubmit = (e) => {
      e.preventDefault();
      const em = document.getElementById('emailLogin').value.trim();
      const p = document.getElementById('passLogin').value;
      const user = JSON.parse(localStorage.getItem('daftarPetani') || '[]').find(x => x.email === em && x.password === p);
      if (!user) return showToast('Salah email/sandi','error');
      localStorage.setItem('user', JSON.stringify({isLoggedIn:true,nama:user.nama,email:em}));
      showToast('Login sukses!','success');
      setTimeout(() => showPage('dashboard'), 1500);
    };

    // Dashboard
    function loadDashboard() {
      const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
      if (!u.isLoggedIn) { showPage('login'); return; }
      document.getElementById('welcomeMsg').textContent = `Selamat datang, ${u.nama}!`;
      updateStats();
      if (panen.length) renderChart();
    }

    function renderChart() {
      const ctx = document.getElementById('chartPanen').getContext('2d');
      const data = panen.slice(-7).reverse();
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.map(x => new Date(x.tanggal || Date.now()).toLocaleDateString('id-ID')),
          datasets: [{
            label: 'Ton',
            data: data.map(x => parseFloat(x.ton) || 0),
            borderColor: '#2f855a',
            backgroundColor: 'rgba(47,133,90,0.1)',
            fill: true,
            tension: 0.3
          }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
      });
    }

    // Init
    window.addEventListener('load', () => {
      updateStats();
      const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
      showPage(u.isLoggedIn ? 'dashboard' : 'beranda');
    });
  </script>
</body>
</html>