// === Navigasi Single Page ===
const pages = {
  home: `
    <h2>Selamat Datang di Dashboard Wisata</h2>
    <div class="grid">
      <div class="card">
        <h3>Statistik Data</h3>
        <p class="small">Jumlah Kategori: <span id="countCategories">0</span></p>
        <p class="small">Jumlah Transaksi: <span id="countTransactions">0</span></p>
        <button class="btn" id="btnAddCategory">Tambah Kategori</button>
        <button class="btn" id="btnAddTransaction" style="margin-top:8px">Tambah Transaksi</button>
      </div>
      <div class="card">
        <h3>Aktivitas</h3>
        <p class="small">Aksi terakhir: <span id="lastAction">-</span></p>
        <button class="btn" id="btnShowQuote">Tampilkan Quote</button>
      </div>
    </div>
  `,
  dashboard: `
    <h2>Halaman Dashboard</h2>
    <p>Berikut data kategori dan transaksi yang tersimpan di localStorage:</p>
    <div id="dataList"></div>
  `,
  about: `
    <h2>Tentang Aplikasi</h2>
    <p>Aplikasi ini dibuat untuk tugas latihan JavaScript: menerapkan DOM, event, web storage, asynchronous, dan toast/snackbar.</p>
  `
};

function renderPage(page){
  document.querySelector('.container').innerHTML = pages[page];
  if(page==='home') initHomeEvents();
  if(page==='dashboard') showDashboard();
}

// pas diklik
document.querySelectorAll('.nav-btn').forEach(btn=>{
  btn.addEventListener('click',()=>{
    renderPage(btn.dataset.page);
  });
});

// fungsi tambahan utk dashboard
function showDashboard(){
  const cats = getData('categories');
  const trxs = getData('transactions');
  const div = document.getElementById('dataList');
  div.innerHTML = `
    <h3>Kategori (${cats.length})</h3>
    <ul>${cats.map(c=>`<li>${c.name}</li>`).join('')}</ul>
    <h3>Transaksi (${trxs.length})</h3>
    <ul>${trxs.map(t=>`<li>ID: ${t.id} — Rp${t.nominal}</li>`).join('')}</ul>
  `;
}
