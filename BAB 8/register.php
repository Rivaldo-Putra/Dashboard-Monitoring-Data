<!DOCTYPE html>
<html lang="id">
<head>
  <title>Register - Pertanian Modern</title>
  <link rel="icon" href="assets/icon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<div class="container">
  <header>
    <nav>
      <div class="logo">
        <img src="assets/logo.png" alt="Logo" />
      </div>
      <input type="checkbox" id="click" />
      <label for="click" class="menu-btn"><i class="fas fa-bars"></i></label>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="login.html" class="btn_login">Login</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="center">
      <div class="form-login">
        <h3>Daftar Akun Petani</h3>
        <p class="subtitle">Gabung dengan ribuan petani modern</p>
<form action="register-proses.php" method="post">
  <input class="input" type="text" name="username" placeholder="Username" required />
  <input class="input" type="email" name="email" placeholder="Email" required />
  <input class="input" type="password" name="password" placeholder="Password" required />
  <button type="submit" class="btn_login">Daftar Sekarang</button>
</form>
        <p class="login-link">Sudah punya akun? <a href="login.php">Login</a></p>
      </div>
    </div>
  </main>

  <footer>
    <h4>© Lab Pemrograman Komputer 2025</h4>
  </footer>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const email = document.getElementById('email').value;
  const username = document.getElementById('username').value;

  // Simpan ke localStorage (simulasi daftar)
  localStorage.setItem('user', JSON.stringify({
    isLoggedIn: true,
    email: email,
    name: username
  }));

  alert('Pendaftaran berhasil! Selamat datang, ' + username);
  window.location.href = 'admin.html';  // Langsung ke admin
});
</script>

</body>
</html>