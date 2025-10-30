<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register - Dashboard Monitoring Data</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="header">
    <div class="brand">Dashboard Monitoring Data</div>
  </header>

  <main class="container auth">
    <h2>Register</h2>
    <form id="registerForm">
      <label>Nama Lengkap</label>
      <input type="text" id="fullname" required>
      <label>Email</label>
      <input type="email" id="email" required>
      <label>Password</label>
      <input type="password" id="password" required>
      <button class="btn" type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
  </main>

  <script>
    document.getElementById('registerForm').addEventListener('submit', e => {
      e.preventDefault();

      const fullname = document.getElementById('fullname').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      let users = JSON.parse(localStorage.getItem('users') || '[]');

      // cek apakah email sudah terdaftar
      if (users.some(u => u.email === email)) {
        alert("Email sudah terdaftar!");
        return;
      }

      users.push({ fullname, email, password });
      localStorage.setItem('users', JSON.stringify(users));
      alert("Pendaftaran berhasil! Silakan login.");
      location.href = 'login.php';
    });
  </script>
</body>
</html>
