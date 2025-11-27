<?php
// inc/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
$loggedIn = !empty($_SESSION['userID']);
?>
<header class="site-header">
  <div class="wrap">
    <div class="brand">
      <a href="welcome.php" class="logo">TaskHive</a>
      <span class="tagline">Smart, simple task management</span>
    </div>
    <nav class="site-nav">
      <a href="welcome.php">Home</a>
      <?php if (!$loggedIn): ?>
        <a href="login.php">Login</a>
        <a href="register.php" class="btn-outline">Register</a>
      <?php else: ?>
        <a href="home.php">Dashboard</a>
        <a href="analytics.php">Analytics</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php" class="btn-outline">Logout</a>
      <?php endif; ?>
    </nav>
  </div>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/main.js" defer></script>
</header>
