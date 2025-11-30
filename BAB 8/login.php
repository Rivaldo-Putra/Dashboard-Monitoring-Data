<!DOCTYPE html>
<html lang="id">
<head>
  <title>Login - Pertanian Modern</title>
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
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="login.php" class="btn_login">Login</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="center">
      <div class="form-login">
        <h3>Login Admin</h3>
<form action="login-proses.php" method="post">
  <input class="input" type="text" name="username" placeholder="Username" required />
  <input class="input" type="password" name="password" placeholder="Password" required />
  <button type="submit" class="btn_login">Login</button>
</form>
        <a href="register.php" class="link-register">Belum punya akun? Daftar</a>
      </div>
    </div>
  </main>
  <footer>
    <h4>© Lab Pemrograman Komputer 2025</h4>
  </footer>
</div>
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  if (username === 'admin' && password === 'admin123') {
    localStorage.setItem('user', JSON.stringify({
      isLoggedIn: true,
      email: username + '@pertanian.com',
      name: 'Admin Pertanian'
    }));
    alert('Login berhasil! Selamat datang, ' + username);
    window.location.href = 'admin.php';
  } else {
    alert('Username atau password salah!');
  }
});
</script>
</body>
</html>