function showToast(message, type = 'info', duration = 3000) {
  // Buat container kalau belum ada
  let container = document.getElementById('toastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toastContainer';
    document.body.appendChild(container);
  }

  // Buat toast
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
    <span>${message}</span>
  `;

  container.appendChild(toast);

  // Tampilkan
  setTimeout(() => toast.classList.add('show'), 100);

  // Hilangkan
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, duration);
}
function submitOrder() {
  const nama = document.getElementById('formNama').value;
  const harga = parseInt(document.getElementById('formHarga').value.replace(/[^0-9]/g, ''));
  const jumlah = parseInt(document.getElementById('formJumlah').value);
  const pembeli = document.getElementById('formNamaPembeli').value.trim();
  const noHP = document.getElementById('formNoHP').value.trim();
  const alamat = document.getElementById('formAlamat').value.trim();
  const total = harga * jumlah;

  // === SIMPAN KE localStorage UNTUK transaction.html ===
  const transaksi = {
    category: nama,           // Pakai nama barang sebagai kategori
    amount: jumlah,           // Jumlah kg
    date: new Date().toISOString().split('T')[0], // Format YYYY-MM-DD
    pembeli: pembeli,
    no_hp: noHP,
    alamat: alamat,
    total: total
  };

  let trxs = JSON.parse(localStorage.getItem('transactions') || '[]');
  trxs.push(transaksi);
  localStorage.setItem('transactions', JSON.stringify(trxs));

  showToast(`Pesanan "${nama}" berhasil disimpan di Transaksi!`, 'success');
  closeConfirm();
}