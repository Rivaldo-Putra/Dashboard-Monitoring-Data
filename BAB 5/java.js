// ===== Web Storage Helper =====
function getData(key) {
  try {
    return JSON.parse(localStorage.getItem(key) || '[]');
  } catch (e) {
    console.error('Error parsing', key, e);
    return [];
  }
}

function setData(key, data) {
  try {
    localStorage.setItem(key, JSON.stringify(data));
  } catch (e) {
    console.error('Error saving', key, e);
  }
}

// ===== Inisialisasi Data =====
let categories = getData('categories');
let transactions = getData('transactions');

// ===== Toast / Snackbar =====
function showToast(msg, type = 'default', duration = 3000) {
  const s = document.getElementById('snackbar');
  if (!s) return;
  s.textContent = msg;
  s.className = 'show';
  if (type === 'success') {
    s.classList.add('success');
    s.classList.remove('error');
  } else if (type === 'error') {
    s.classList.add('error');
    s.classList.remove('success');
  } else s.classList.remove('success', 'error');
  setTimeout(() => {
    s.className = '';
    s.classList.remove('success', 'error');
  }, duration);
}

// ===== Update Stats =====
function updateStats() {
  document.getElementById('countCategories')?.textContent = categories.length;
  document.getElementById('countTransactions')?.textContent = transactions.length;
  setData('categories', categories);
  setData('transactions', transactions);
  renderTables(); // perbarui tabel setiap kali data berubah
}

// ===== Render Tabel =====
function renderTables() {
  const catTable = document.getElementById('tableCategories')?.querySelector('tbody');
  const trxTable = document.getElementById('tableTransactions')?.querySelector('tbody');

  if (catTable) {
    catTable.innerHTML = categories.map((c, i) => `
      <tr>
        <td>${i + 1}</td>
        <td>${c.name}</td>
        <td>${c.createdAt}</td>
        <td><button onclick="deleteCategory(${i})">Hapus</button></td>
      </tr>
    `).join('') || `<tr><td colspan="4">Belum ada kategori</td></tr>`;
  }

  if (trxTable) {
    trxTable.innerHTML = transactions.map((t, i) => `
      <tr>
        <td>${i + 1}</td>
        <td>${t.name}</td>
        <td>${t.status}</td>
        <td>${t.createdAt}</td>
        <td><button onclick="deleteTransaction(${i})">Hapus</button></td>
      </tr>
    `).join('') || `<tr><td colspan="5">Belum ada transaksi</td></tr>`;
  }
}

// ===== Hapus Data =====
function deleteCategory(i) {
  if (confirm("Yakin hapus kategori ini?")) {
    categories.splice(i, 1);
    updateStats();
    showToast('Kategori dihapus', 'success');
  }
}

function deleteTransaction(i) {
  if (confirm("Yakin hapus transaksi ini?")) {
    transactions.splice(i, 1);
    updateStats();
    showToast('Transaksi dihapus', 'success');
  }
}

// ===== Popup =====
const popupOverlay = document.getElementById('popupOverlay');
const popupTitle = document.getElementById('popupTitle');
const popupContent = document.getElementById('popupContent');
const closePopupBtn = document.getElementById('closePopupBtn');
closePopupBtn?.addEventListener('click', () => popupOverlay.style.display = 'none');

function openPopup(title, contentHTML, submitCallback) {
  popupTitle.textContent = title;
  popupContent.innerHTML = contentHTML;

  const submitBtn = popupContent.querySelector('button');
  const newSubmit = submitBtn.cloneNode(true);
  submitBtn.parentNode.replaceChild(newSubmit, submitBtn);

  newSubmit.addEventListener('click', () => {
    submitCallback();
    popupOverlay.style.display = 'none';
  });

  popupOverlay.style.display = 'flex';
}

// ===== Popup 1: Tambah Kategori =====
document.getElementById('popup1Btn')?.addEventListener('click', () => {
  openPopup('Tambah Kategori', `
    <input type="text" id="popupCatName" placeholder="Nama kategori" style="width:90%;padding:6px;margin-bottom:6px;">
    <button class="btn">Tambah</button>
  `, () => {
    const name = document.getElementById('popupCatName').value.trim();
    if (name) {
      categories.push({ name, createdAt: new Date().toLocaleString() });
      updateStats();
      showToast('Kategori "' + name + '" ditambahkan', 'success', 2500);
    }
  });
});

// ===== Popup 2: Tambah Transaksi =====
document.getElementById('popup2Btn')?.addEventListener('click', () => {
  openPopup('Tambah Transaksi', `
    <input type="text" id="popupTrxName" placeholder="Nama transaksi" style="width:90%;padding:6px;margin-bottom:6px;">
    <select id="popupTrxStatus" style="width:95%;padding:6px;margin-bottom:6px;">
      <option value="Belum Dibayar">Belum Dibayar</option>
      <option value="Sudah Dibayar">Sudah Dibayar</option>
    </select>
    <button class="btn">Tambah</button>
  `, () => {
    const name = document.getElementById('popupTrxName').value.trim();
    const status = document.getElementById('popupTrxStatus').value;
    if (name) {
      transactions.push({ name, status, createdAt: new Date().toLocaleString() });
      updateStats();
      showToast('Transaksi "' + name + '" ditambahkan', 'success', 2500);
    }
  });
});

// ===== Tombol Demo =====
document.getElementById('addCatBtn')?.addEventListener('click', () => {
  const name = 'Kategori Demo ' + Math.floor(Math.random() * 900 + 100);
  categories.push({ name, createdAt: new Date().toLocaleString() });
  updateStats();
  showToast('Kategori "' + name + '" ditambahkan', 'success', 2500);
});

document.getElementById('addTrxBtn')?.addEventListener('click', () => {
  const name = 'Transaksi Demo ' + Math.floor(Math.random() * 900 + 100);
  const status = Math.random() < 0.5 ? 'Belum Dibayar' : 'Sudah Dibayar';
  transactions.push({ name, status, createdAt: new Date().toLocaleString() });
  updateStats();
  showToast('Transaksi "' + name + '" ditambahkan', 'success', 2500);
});

// ===== Tombol Toast =====
document.getElementById('toastSuccessBtn')?.addEventListener('click', () => showToast('Notifikasi sukses!', 'success'));
document.getElementById('toastErrorBtn')?.addEventListener('click', () => showToast('Terjadi kesalahan!', 'error'));

// ===== Fetch Quote (Asynchronous + Promise + Fetch) =====
document.getElementById('btnShowQuote')?.addEventListener('click', async () => {
  try {
    const res = await fetch('https://api.quotable.io/random');
    const data = await res.json();
    showToast(`Quote: "${data.content}" — ${data.author}`, 'success', 4000);
  } catch (e) {
    showToast('Gagal memuat quote!', 'error', 3000);
  }
});

// ===== Inisialisasi =====
updateStats();
renderTables();
