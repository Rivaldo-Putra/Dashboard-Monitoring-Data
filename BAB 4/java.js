// ===== STORAGE =====
const getData = (key) => JSON.parse(localStorage.getItem(key) || '[]');
const setData = (key, data) => localStorage.setItem(key, JSON.stringify(data));

// ===== DATA =====
let categories = getData('categories');
let transactions = getData('transactions');
let panen = getData('panen');

// ===== TOAST =====
const showToast = (msg, type = 'default', dur = 3000) => {
  const s = document.getElementById('snackbar');
  s.textContent = msg;
  s.className = 'show';
  if (type === 'success') s.classList.add('success');
  if (type === 'error') s.classList.add('error');
  setTimeout(() => s.className = '', dur);
};

// ===== UPDATE STATS =====
const updateStats = () => {
  ['countCategories', 'dashCategories'].forEach(id => 
    document.getElementById(id)?.textContent = categories.length
  );
  ['countTransactions', 'dashTransactions'].forEach(id => 
    document.getElementById(id)?.textContent = transactions.length
  );
  const total = panen.reduce((a, x) => a + (parseFloat(x.ton) || 0), 0).toFixed(2);
  document.getElementById('dashTotal')?.textContent = total;
  setData('categories', categories);
  setData('transactions', transactions);
  setData('panen', panen);
  renderTables();
};

// ===== RENDER TABEL =====
const renderTables = () => {
  const cat = document.querySelector('#tableCategories tbody');
  const trx = document.querySelector('#tableTransactions tbody');
  cat.innerHTML = categories.map((c, i) => `
    <tr><td>${i+1}</td><td>${c.name}</td><td>${c.createdAt}</td>
    <td><button class="btn danger" onclick="deleteCategory(${i})">Hapus</button></td></tr>
  `).join('') || '<tr><td colspan="4">Kosong</td></tr>';
  trx.innerHTML = transactions.map((t, i) => `
    <tr><td>${i+1}</td><td>${t.name}</td><td>${t.status}</td><td>${t.createdAt}</td>
    <td><button class="btn danger" onclick="deleteTransaction(${i})">Hapus</button></td></tr>
  `).join('') || '<tr><td colspan="5">Kosong</td></tr>';
};

// ===== HAPUS =====
window.deleteCategory = (i) => { if (confirm('Hapus?')) { categories.splice(i,1); updateStats(); showToast('Dihapus','success'); }};
window.deleteTransaction = (i) => { if (confirm('Hapus?')) { transactions.splice(i,1); updateStats(); showToast('Dihapus','success'); }};

// ===== POPUP =====
const openPopup = (title, html, cb) => {
  document.getElementById('popupTitle').textContent = title;
  document.getElementById('popupContent').innerHTML = html;
  document.getElementById('popupOverlay').classList.remove('hidden');
  const btn = document.querySelector('#popupContent button');
  if (btn) {
    const newBtn = btn.cloneNode(true);
    btn.replaceWith(newBtn);
    newBtn.addEventListener('click', () => { cb(); document.getElementById('popupOverlay').classList.add('hidden'); });
  }
};

document.getElementById('closePopupBtn')?.addEventListener('click', () => {
  document.getElementById('popupOverlay').classList.add('hidden');
});

// ===== TOMBOL AKSI =====
document.getElementById('addCatBtn')?.addEventListener('click', () => {
  const name = 'Kategori ' + Math.floor(Math.random() * 999);
  categories.push({ name, createdAt: new Date().toLocaleString('id-ID') });
  updateStats(); showToast('Ditambah', 'success');
});

document.getElementById('addTrxBtn')?.addEventListener('click', () => {
  const name = 'Transaksi ' + Math.floor(Math.random() * 999);
  const status = Math.random() > 0.5 ? 'Sudah Dibayar' : 'Belum Dibayar';
  transactions.push({ name, status, createdAt: new Date().toLocaleString('id-ID') });
  updateStats(); showToast('Ditambah', 'success');
});

document.getElementById('popup1Btn')?.addEventListener('click', () => {
  openPopup('Tambah Kategori', `<input type="text" id="popupCatName" placeholder="Nama"><button class="btn">Tambah</button>`, () => {
    const name = document.getElementById('popupCatName').value.trim();
    if (name) { categories.push({ name, createdAt: new Date().toLocaleString('id-ID') }); updateStats(); showToast('Ditambah','success'); }
  });
});

document.getElementById('popup2Btn')?.addEventListener('click', () => {
  openPopup('Tambah Transaksi', `<input type="text" id="popupTrxName" placeholder="Nama"><select id="popupTrxStatus"><option>Belum Dibayar</option><option>Sudah Dibayar</option></select><button class="btn">Tambah</button>`, () => {
    const name = document.getElementById('popupTrxName').value.trim();
    const status = document.getElementById('popupTrxStatus').value;
    if (name) { transactions.push({ name, status, createdAt: new Date().toLocaleString('id-ID') }); updateStats(); showToast('Ditambah','success'); }
  });
});

document.getElementById('toastSuccessBtn')?.addEventListener('click', () => showToast('Sukses!','success'));
document.getElementById('toastErrorBtn')?.addEventListener('click', () => showToast('Error!','error'));

document.getElementById('btnShowQuote')?.addEventListener('click', async () => {
  try {
    const res = await fetch('https://api.quotable.io/random');
    const d = await res.json();
    showToast(`"${d.content}" — ${d.author}`, 'success', 5000);
  } catch { showToast('Gagal ambil quote','error'); }
});

// ===== NAVIGASI =====
window.showPage = (page) => {
  document.querySelectorAll('[id^="page-"]').forEach(p => p.classList.add('hidden'));
  document.getElementById(`page-${page}`).classList.remove('hidden');
  if (page === 'dashboard') loadDashboard();
  updateNav();
};

window.logout = () => {
  localStorage.removeItem('user');
  showToast('Logout sukses','success');
  showPage('beranda');
};

const updateNav = () => {
  const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
  document.getElementById('navLogin').classList.toggle('hidden', u.isLoggedIn);
  document.getElementById('navDaftar').classList.toggle('hidden', u.isLoggedIn);
  document.getElementById('btnLogout').classList.toggle('hidden', !u.isLoggedIn);
  document.getElementById('userInfo').textContent = u.isLoggedIn ? `(${u.email})` : '';
};

// ===== LOGIN & DAFTAR =====
document.getElementById('formDaftar').onsubmit = (e) => {
  e.preventDefault();
  const n = document.getElementById('namaDaftar').value.trim();
  const em = document.getElementById('emailDaftar').value.trim();
  const p = document.getElementById('passDaftar').value;
  if (!n || !em || !p) return showToast('Isi semua!','error');
  const daftar = getData('daftarPetani');
  if (daftar.some(x => x.email === em)) return showToast('Email sudah ada','error');
  daftar.push({nama:n,email:em,password:p});
  setData('daftarPetani', daftar);
  localStorage.setItem('user', JSON.stringify({isLoggedIn:true,nama:n,email:em}));
  showToast('Daftar sukses!','success');
  setTimeout(() => showPage('dashboard'), 1500);
};

document.getElementById('formLogin').onsubmit = (e) => {
  e.preventDefault();
  const em = document.getElementById('emailLogin').value.trim();
  const p = document.getElementById('passLogin').value;
  const user = getData('daftarPetani').find(x => x.email === em && x.password === p);
  if (!user) return showToast('Salah email/sandi','error');
  localStorage.setItem('user', JSON.stringify({isLoggedIn:true,nama:user.nama,email:em}));
  showToast('Login sukses!','success');
  setTimeout(() => showPage('dashboard'), 1500);
};

// ===== DASHBOARD =====
const loadDashboard = () => {
  const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
  if (!u.isLoggedIn) return setTimeout(() => showPage('login'), 1000);
  document.getElementById('welcomeMsg').textContent = `Selamat datang, ${u.nama}!`;
  updateStats();
  if (panen.length) renderChart();
};

const renderChart = () => {
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
        fill: true
      }]
    },
    options: { responsive: true }
  });
};

// ===== INIT =====
window.addEventListener('load', () => {
  updateStats();
  const u = JSON.parse(localStorage.getItem('user') || '{"isLoggedIn":false}');
  showPage(u.isLoggedIn ? 'dashboard' : 'beranda');
});