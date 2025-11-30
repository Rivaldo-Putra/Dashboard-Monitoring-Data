// ==================== TOAST NOTIFICATION (SUDAH ADA DI PROJECT KAMU) ====================
function showToast(message, type = 'info', duration = 3500) {
  let container = document.getElementById('toastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toastContainer';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  const icons = { success: 'check-circle', error: 'exclamation-circle', warning: 'exclamation-triangle', info: 'info-circle' };
  toast.innerHTML = `<i class="fas fa-${icons[type]}"></i><span>${message}</span>`;

  container.appendChild(toast);
  setTimeout(() => toast.classList.add('show'), 100);
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
  }, duration);
}

// ==================== SIDEBAR TOGGLE + JAM WIB + SALAM OTOMATIS ====================
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const sidebarBtn = document.querySelector(".sidebarBtn");

  // Toggle Sidebar (pakai Font Awesome, bukan Boxicons)
  if (sidebar && sidebarBtn) {
    sidebarBtn.onclick = function () {
      sidebar.classList.toggle("active");
      const icon = this.querySelector("i");
      if (sidebar.classList.contains("active")) {
        icon.classList.replace("fa-bars", "fa-times");
      } else {
        icon.classList.replace("fa-times", "fa-bars");
      }
    };
  }

  // Nama hari & bulan bahasa Indonesia
  const days   = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
  const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

  function checkTime(i) {
    return i < 10 ? "0" + i : i;
  }

  function updateClock() {
    // WAKTU INDONESIA WIB (UTC+7) — PASTI BENAR!
    const now = new Date();
    const wib = new Date(now.getTime() + 420 * 60 * 1000); // +7 jam

    const jam     = wib.getHours();
    const menit   = checkTime(wib.getMinutes());
    const detik   = checkTime(wib.getSeconds());
    const tanggal = wib.getDate();
    const hari    = days[wib.getDay()];
    const bulan   = months[wib.getMonth()];
    const tahun   = wib.getFullYear();

    // Update elemen dengan id="date"
    const dateEl = document.getElementById("date");
    if (dateEl) {
      dateEl.innerHTML = `${hari}, ${tanggal} ${bulan} ${tahun}, ${jam}:${menit}:${detik}`;
    }

    requestAnimationFrame(updateClock);
  }

  // Ucapan selamat sesuai jam WIB
  const now = new Date();
  const wib = new Date(now.getTime() + 420 * 60 * 1000);
  const jamWIB = wib.getHours();

  let salam = "Selamat Malam,";
  if (jamWIB >= 4 && jamWIB <= 10)  salam = "Selamat Pagi,";
  else if (jamWIB >= 11 && jamWIB <= 14) salam = "Selamat Siang,";
  else if (jamWIB >= 15 && jamWIB <= 17) salam = "Selamat Sore,";

  const textEl = document.getElementById("text");
  if (textEl) {
    textEl.textContent = `${salam} Admin`;
  }

  // Jalankan jam
  updateClock();
});