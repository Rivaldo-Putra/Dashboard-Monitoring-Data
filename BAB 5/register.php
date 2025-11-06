<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Daftar Petani</title>
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
    nav a{color:#fff;text-decoration:none;margin-left:12px;font-size:.95rem}
    nav a:hover{text-decoration:underline}
    .container{max-width:500px;margin:40px auto;padding:16px}
    .card{background:#fff;padding:28px;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.12)}
    h2{text-align:center;margin-bottom:16px;color:var(--dark)}
    input,select{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;margin:8px 0;font-size:1rem}
    input:focus,select:focus{outline:none;border-color:var(--green);box-shadow:0 0 0 3px rgba(47,133,90,.2)}
    .btn{background:var(--green);color:#fff;padding:14px;border:none;border-radius:8px;cursor:pointer;width:100%;margin-top:16px;font-size:1.1rem;font-weight:600}
    .btn:hover{background:#276749}
    .link{text-align:center;margin-top:16px;font-size:.95rem}
    .link a{color:var(--green);text-decoration:none;font-weight:600}
    .link a:hover{text-decoration:underline}
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
  <div class="brand">Daftar Petani</div>
  <nav>
    <a href="index.php">Beranda</a>
    <a href="login.php">Login</a>
  </nav>
</header>

<div class="container">
  <div class="card">
    <h2>Daftar Akun Baru</h2>
    <form id="formDaftar">
      <input type="text" id="nama" placeholder="Nama Lengkap" required />
      <input type="email" id="email" placeholder="Email" required />
      <input type="password" id="pass" placeholder="Kata Sandi" required minlength="6" />
      <select id="provinsi" required>
        <option value="">Pilih Provinsi</option>
        <option>Jawa Barat</option>
        <option>Jawa Tengah</option>
        <option>Jawa Timur</option>
        <option>Sumatera Utara</option>
        <option>Sulawesi Selatan</option>
      </select>
      <button type="submit" class="btn">Daftar Sekarang</button>
    </form>
    <p class="link">
      Sudah punya akun? <a href="login.php">Masuk di sini</a>
    </p>
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

  // Daftar
  document.getElementById('formDaftar').onsubmit = function(e) {
    e.preventDefault();

    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('pass').value;
    const provinsi = document.getElementById('provinsi').value;

    // Validasi
    if (!nama || !email || !password || !provinsi) {
      showToast('Isi semua kolom!', 'error');
      return;
    }

    if (password.length < 6) {
      showToast('Kata sandi minimal 6 karakter!', 'error');
      return;
    }

    // Cek email sudah ada
    const users = JSON.parse(localStorage.getItem('daftarPetani') || '[]');
    if (users.some(u => u.email === email)) {
      showToast('Email sudah terdaftar!', 'error');
      return;
    }

    // Simpan user
    users.push({ nama, email, password, provinsi });
    localStorage.setItem('daftarPetani', JSON.stringify(users));

    // Login otomatis
    localStorage.setItem('user', JSON.stringify({
      isLoggedIn: true,
      nama: nama,
      email: email
    }));

    showToast(`Selamat datang, ${nama}! Akun berhasil dibuat.`, 'success');
    setTimeout(() => location.href = 'dashboard.php', 1800);
  };
</script>

</body>
</html>