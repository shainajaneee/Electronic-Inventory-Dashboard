<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management System</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="landing-body">

  <!-- 🌐 Navbar -->
  <header class="navbar">
    <div class="logo">IMS</div>
    <nav class="nav-links">
      <a href="#" class="active">Home</a>
      <a href="#about">About</a>
      <a href="#features">Features</a>
      <a href="#" id="loginBtn">Login</a>
      <a href="#" id="registerBtn" class="btn-dashboard">Register</a>
    </nav>
  </header>

  <!-- 🦸 Hero Section -->
  <section class="hero full-screen">
    <div class="hero-overlay"></div>
    <div class="hero-text">
      <h1>Welcome to InventorySys</h1>
      <p>Smart. Simple. Scalable.  
      Manage your inventory efficiently and never run out of stock again.</p>
      <a href="dashboard.php" class="cta-btn">Go to Dashboard</a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="article">
    <h2>About the System</h2>
    <p>
      InventorySys is a complete PHP-based inventory management solution that
      helps track, monitor, and manage your product stocks effortlessly.
    </p>
  </section>

  <!-- Features Section -->
  <section id="features" class="article">
    <h2>Key Features</h2>
    <ul>
      <li>📦 Add, edit, and delete inventory items</li>
      <li>⚠️ Out-of-stock auto reporting</li>
      <li>📊 Dashboard analytics & insights</li>
      <li>🔐 Secure user login & management</li>
    </ul>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 InventorySys | Designed by Shang</p>
  </footer>

  <!-- 🪄 LOGIN MODAL -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeLogin">&times;</span>
      <h2>Login to InventorySys</h2>
      <form action="login.php" method="POST">
        <label for="login-username">Username</label>
        <input type="text" id="login-username" name="username" required>

        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" required>

        <button type="submit" class="btn-submit">Login</button>
      </form>
    </div>
  </div>

  <!-- 🪄 REGISTER MODAL -->
  <div id="registerModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeRegister">&times;</span>
      <h2>Create an Account</h2>
      <form action="register.php" method="POST">
        <label for="reg-username">Username</label>
        <input type="text" id="reg-username" name="username" required>

        <label for="reg-email">Email</label>
        <input type="email" id="reg-email" name="email" required>

        <label for="reg-password">Password</label>
        <input type="password" id="reg-password" name="password" required>

        <button type="submit" class="btn-submit">Register</button>
      </form>
    </div>
  </div>

  <!-- 💡 JavaScript for Modals -->
  <script>
  // Open Login Modal
  document.getElementById('loginBtn').onclick = () => {
    document.getElementById('loginModal').style.display = 'flex';
  };
  // Open Register Modal
  document.getElementById('registerBtn').onclick = () => {
    document.getElementById('registerModal').style.display = 'flex';
  };
  // Close buttons
  document.getElementById('closeLogin').onclick = () => {
    document.getElementById('loginModal').style.display = 'none';
  };
  document.getElementById('closeRegister').onclick = () => {
    document.getElementById('registerModal').style.display = 'none';
  };
  // Close modal when clicking outside
  window.onclick = (e) => {
    if (e.target.classList.contains('modal')) e.target.style.display = 'none';
  };
  </script>

</body>
</html>
