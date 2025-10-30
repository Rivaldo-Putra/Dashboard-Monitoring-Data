<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login - Dashboard Monitoring Data</title>
<link rel="stylesheet" href="css/style.css">
<style>
  .error {color: red; margin-top: 10px; text-align: center;}
  header {background: #2f855a; color:#fff; padding:14px 20px; display:flex; justify-content:space-between; align-items:center;}
  .brand {font-weight:700;}
  nav a {color:#fff; margin-left:12px; text-decoration:none;}
  .container {max-width:400px; margin:20px auto; padding:16px;}
  .btn {background:#2f855a;color:#fff;padding:10px 14px;border:none;border-radius:6px;cursor:pointer;}
</style>
</head>
<body>
<header>
  <div class="brand">Dashboard Monitoring Data</div>
  <nav>
    <a href="admin.php">Login Admin</a>
    <a href="dashbor.php">Dashboard</a>
    <a href="register.php">Register</a>
  </nav>
</header>

<main class="container auth">
  <h2>Login</h2>
  <form id="loginForm">
    <label>Email</label>
    <input type="email" id="email" required style="width:100%;padding:6px;margin:6px 0;">
    <label>Password</label>
    <input type="password" id="password" required style="width:100%;padding:6px;margin:6px 0;">
    <button class="btn" type="submit">Login</button>
    <p id="errorMsg" class="error"></p>
  </form>
  <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</main>

<script>
document.getElementById('loginForm').addEventListener('submit', e=>{
  e.preventDefault();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();
  const errorMsg = document.getElementById('errorMsg');
  const users = JSON.parse(localStorage.getItem('users')||'[]');
  const foundUser = users.find(u=>u.email===email && u.password===password);
  if(!foundUser){ 
    errorMsg.textContent="Email atau password salah!"; 
    return; 
  }
  localStorage.setItem('loggedIn','true');
  localStorage.setItem('currentUser',JSON.stringify(foundUser));
  location.href='dashbor.php';
});
</script>
</body>
</html>
